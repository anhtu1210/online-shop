<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    public function productDetail($slug)
    {

        $product = Product::where('slug', $slug)->with('galleries')->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->with('galleries')->limit(4)->get();

        return view('client.pages.product-detail', compact('product', 'relatedProducts'));
    }

    public function cart(Request $request)
    {
        return response()->json([
            'data' => $request->all()
        ]);
    }
}
