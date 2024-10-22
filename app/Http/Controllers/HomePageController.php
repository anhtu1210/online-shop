<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Events\OrderShipped;
use App\Models\Banner;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomePageController extends Controller
{
    public function home()
    {

        // when
        $isProductFeatured = Product::when(function ($query) {
            return $query->where([
                'is_featured' => 'Yes',
                'status' => 1,
                'is_show_home' => 'Yes'
            ]);
        })->with('galleries')->get();


        // when
        $latest = Product::when(function ($query) {
            return $query->orderBy('id', 'desc')->where([
                'status' => 1,
                'is_show_home' => 'Yes'
            ]);
        })->with('galleries')->get();

        // when
        $productPriceSale = Product::when(function ($query) {
            return $query->where([
                ['status', '=', 1],
                ['is_show_home',  'Yes'],
                ['price_sale', '>', 0]
            ]);
        })->with('galleries')->get();

        // $user = User::find(Auth::user()->id)->notifications()->get();
        // dd($user);

        $sliders = Banner::where('status', '1')->get();


        return view('client.pages.home', compact('isProductFeatured', 'latest', 'productPriceSale', 'sliders'));
    }
}
