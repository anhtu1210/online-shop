<?php

namespace App\Http\Controllers;


use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index()
    {
        $carts = Cart::content();
        // Cart::destroy();

        // dd($carts->toArray());

        return view('client.pages.cart', compact('carts'));
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $product =  Product::with('galleries')->findOrFail($request->productId);

            if ($request->qty > $product->qty) {
                return response()->json(['status' => false, 'message' => 'Số lượng trong kho không đủ.']);
            }

            if (Cart::count() > 0) {
                $carts = Cart::content()->pluck('id')->toArray();

                if (in_array($product->id, $carts)) {
                    $status = false;
                    $message = 'Sản phẩm đã có trong giỏ hàng.';
                } else {
                    Cart::add($product->id, $product->title, $request->quantity, $product->price_sale ?? $product->price, ['product_image' => $product->galleries->first()]);
                    $status = true;
                    $message = 'Sản phẩm đã được thêm vào giỏ hàng.';
                }
            } else {
                Cart::add($product->id, $product->title, $request->quantity, $product->price_sale ?? $product->price, ['product_image' => $product->galleries->first()]);
                $status = true;
                $message = 'Sản phẩm đã được thêm vào giỏ hàng.';
            }

            $carts = Cart::content();

            return response()->json(['status' => $status, 'message' => $message, 'count' => count($carts ?? [1])]);
        }
    }

    public function update(Request $request)
    {

        if ($request->ajax()) {

            $rowId =  $request->rowId;

            $qty = $request->quantity;

            $carts = Cart::get($rowId);

            $product = Product::select('id', 'qty')->findOrFail($carts->id);



            if ($qty > $product->qty) {
                return response()->json(['status' => false, 'message' => 'Số lượng trong kho không đủ.']);
            }

            Cart::update($rowId, $qty);


            $carts = Cart::content();


            return response()->json(['status' => true, 'message' => 'Sản phẩm đã được cập nhật.', 'carts' => $carts]);
        }
    }

    public function destroy(Request $request)
    {

        if ($request->ajax()) {

            $rowId =  $request->rowId;

            Cart::remove($rowId);

            return response()->json(['status' => true, 'message' => 'Sản phẩm đã được xóa.', 'carts' => Cart::content()->toArray(), 'count' => Cart::count()]);
        }
    }
}
