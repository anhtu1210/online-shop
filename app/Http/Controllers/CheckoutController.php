<?php

namespace App\Http\Controllers;

use App\Events\OrderShipped;
use App\Notifications\SendNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Cities;
use App\Models\DiscountCoupon;
use App\Models\Shipping;
use App\Models\User;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        if (Cart::count() == 0) {
            return redirect()->route('cartShow');
        }
        if (!Auth::check()) {
            if (!session()->has('url.intended')) {
                session(['url.intended' => url()->current()]);
            }
            return redirect()->route('login');
        }

        $cities = Cities::all();

        session()->forget('url.intended');

        return view('client.pages.checkout', compact('cities'));
    }

    public function pocessCheckout(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:100',
            'email' => 'required|email',
            'phone_number' => 'required|numeric',
            'address' => 'required',
            'payment_status' => 'required|in:cod,paypal',
        ]);

        $carts = Cart::content();

        $validated['total_price'] = $request->total;
        $validated['amount_shipping'] = $request->amount_shipping;
        $validated['amount_coupon'] = $request->amount_coupon ?? 0;

        if ($request->payment_status == 'paypal') {
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
            date_default_timezone_set('Asia/Ho_Chi_Minh');

            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = route('vnpay.callback');
            $vnp_TmnCode = "FX4DX39X"; //Mã website tại VNPAY
            $vnp_HashSecret = "IAE2QHSH5HFIB90RQ7X9NLBQAWIR3HL0"; //Chuỗi bí mật

            $vnp_TxnRef = rand(00, 9999);
            $vnp_OrderInfo = "Nội dung thanh toán";
            $vnp_OrderType = "billpayment";
            $vnp_Amount = $validated['total_price'] * 100;
            $vnp_Locale = "vn";
            $vnp_BankCode = "NCB";
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }

            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }

            session(['checkout_data' => $validated]);

            return redirect()->away($vnp_Url);
        } else {
            try {
                DB::beginTransaction();


                $validated['amount_coupon']  = $request->amount_coupon ?? 0;

                $address = Cities::find($request->address)->select('name')->first();
                $validated['address'] = $address->name;


                $order = User::find(Auth::user()->id)->orders()->create($validated);

                $orderItems = Cart::content()->map(function ($item) {
                    return [
                        'product_id' => $item->id,
                        'name' => $item->name,
                        'price' => $item->price,
                        'tax' => $item->tax,
                        'quantity' => $item->qty,
                    ];
                })->toArray();

                $order->details()->attach($orderItems);
                Cart::destroy();

                // OrderShipped::dispatch($order);
                event(new OrderShipped($order, $carts));

                $user = User::find(Auth::user()->id);
                $user->notify(new SendNotification($order));

                DB::commit();
            } catch (Exception $exception) {
                DB::rollBack();
                session()->flash('errors', $exception->getMessage());
            }

            session()->flash('success', 'Đặt hàng thành công');
            return redirect()->route('thank-you');
        }
    }


    public function thankYou()
    {
        if (session()->has('success')) {
            return view('client.pages.thank-you');
        }
        return redirect()->route('home');
    }

    public function getAmount(Request $request)
    {
        $carts = Cart::content();
        $subtotal = $carts->map(function ($item) {
            return $item->price * $item->qty + $item->tax;
        });
        $total = $subtotal->sum();
        $discount_amount = 0;
        $shipping_amount = 0;


        if ($request->city_id) {
            $shipping = Shipping::query()->select('amount')->where('city_id', $request->city_id)->first();
            $shipping_amount = $shipping->amount;
        }


        $totalQty = Cart::content()->sum('qty');


        if ($request->coupon_code) {
            $discount = DiscountCoupon::query()->where('code', $request->coupon_code)->first();
            if ($discount != null) {
                if ($discount->type == 'percent') {
                    $discount_amount = ($total * $discount->discount_amount) / 100;
                } else {
                    $discount_amount = $discount->discount_amount;
                }
            }
        }


        return response()->json([
            'shipping_amount' => number_format($shipping_amount * $totalQty, 0, ',', '.') . 'đ',
            'grand_total' => number_format(($total - $discount_amount) + ($shipping_amount * $totalQty), 0, ',', '.') . 'đ',
            'discount_amount' => '-' . number_format($discount_amount, 0, ',', '.') . 'đ',
        ]);
    }


    public function vnpayCallback(Request $request)
    {
        $vnp_HashSecret = "IAE2QHSH5HFIB90RQ7X9NLBQAWIR3HL0"; //Chuỗi bí mật

        $inputData = array();
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= urlencode($key) . '=' . urlencode($value) . '&';
        }
        $hashData = rtrim($hashData, '&');

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash == $vnp_SecureHash) {
            if ($inputData['vnp_ResponseCode'] == '00') {
                // Thanh toán thành công, cập nhật cơ sở dữ liệu
                try {
                    DB::beginTransaction();
                    // Lấy thông tin từ session hoặc request trước đó
                    $validated = session('checkout_data');
                    $carts = Cart::content();

                    $address = Cities::find($validated['address'])->select('name')->first();
                    $validated['address'] = $address->name;
                    $validated['payment_status'] = 'paypal';
                    $validated['status'] = 'processing';

                    $order = User::find(Auth::user()->id)->orders()->create($validated);

                    $orderItems = $carts->map(function ($item) {
                        return [
                            'product_id' => $item->id,
                            'name' => $item->name,
                            'price' => $item->price,
                            'tax' => $item->tax,
                            'quantity' => $item->qty,
                        ];
                    })->toArray();

                    $order->details()->attach($orderItems);
                    Cart::destroy();

                    event(new OrderShipped($order, $carts));

                    $user = User::find(Auth::user()->id);
                    $user->notify(new SendNotification($order));

                    DB::commit();

                    session()->flash('success', 'Đặt hàng thành công');
                    session()->forget('checkout_data');
                    return redirect()->route('thank-you');
                } catch (Exception $exception) {
                    DB::rollBack();
                    session()->flash('errors', $exception->getMessage());
                    return redirect()->route('checkout')->withErrors('Có lỗi xảy ra, vui lòng thử lại.');
                }
            } else {
                session()->flash('errors', 'Giao dịch thất bại');
                return redirect()->route('checkout')->withErrors('Giao dịch thất bại');
            }
        } else {
            session()->flash('errors', 'Chữ ký không hợp lệ');
            return redirect()->route('checkout')->withErrors('Chữ ký không hợp lệ');
        }
    }
}
