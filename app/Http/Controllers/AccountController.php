<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\VerifyMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function login()
    {
        return view('client.pages.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->passes()) {
            // $remember = $request->filled('remember') ? true : false;

            if (Auth::attempt($validator->validated(), $request->get('remember'))) {
                // if (Auth::user()->email_verified_at == null) {
                //     return response()->json([
                //         'status' => false,
                //         'message' => 'Bạn chưa xác thực email. Vui lòng xác thực email để đăng nhập.'
                //     ]);
                // }
                // else {

                $request->session()->regenerate();


                if (session()->has('url.intended')) {
                    $url = session()->get('url.intended');
                }
                return response()->json([
                    'status' => true,
                    'url' => $url ?? route('home')
                ]);
                // }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Email hoặc mật khẩu không đúng'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function register()
    {
        return view('client.pages.register');
    }

    public function pocessRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
        if ($validator->passes()) {
            $user = User::create($request->all());

            Auth::login($user, true);

            return response()->json([
                'status' => true,
                'url' => route('home')
            ]);

            // Mail::to($user->email)->send(new VerifyMail($user));
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function verificationEmail($email)
    {
    }

    public function profile()
    {
        return view('client.pages.profile');
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('home');
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = Order::query()
            ->with('details')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('client.pages.order', compact('orders'));
    }

    public function orderDetail(string $orderId)
    {

        $user = Auth::user();

        $order = Order::query()
            ->with('details')
            ->where('id', $orderId)
            ->first();

        // dd($order);

        return view('client.pages.order-detail', compact('order'));
    }

    public function orderCancel(string $id)
    {
        $order = Order::query()->find($id);

        if ($order->user_id == Auth::user()->id) {
            if ($order->status == "pending") {
                $order->status = 'cancelled';
                $order->save();
                return redirect()->route('my-orders')->with('success', 'Đơn hàng ' . $order->id . ' đã hủy.');
            }
            return redirect()->back()->with('error', 'Không thể hủy đơn hàng.');
        }
    }
}
