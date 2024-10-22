<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
// Intervention

use Intervention\Image\Facades\Image;

class ShopPageController extends Controller
{
    public function shop($slug = null)
    {

        $category = null;
        // Lấy ra danh sách các danh mục con của các danh mục cha có parent_id = null
        $categories = Category::query()->with('children')->whereHas('parent', function ($query) {
            $query->whereNull('parent_id');
        })->get();

        // Lấy ra danh sách các thương hiệu
        $brands = Brand::all();

        // Khởi tạo query sản phẩm với eager loading 'galleries'
        $products = Product::with('galleries');

        if (!empty($slug)) {
            // Lấy ra danh mục đầu tiên có slug là $slug
            $category = Category::query()->where('slug', $slug)->first();

            // Nếu tồn tại danh mục thì lọc sản phẩm theo danh mục và các danh mục con của nó
            if ($category) {
                $categoryIds = Category::query()->descendantsOf($category->id)->pluck('id');
                $products->whereIn('category_id', $categoryIds->toArray());
            }
        }

        // Phân trang và trả về view
        $products = $products->paginate(9);

        return view('client.pages.shop', compact('categories', 'brands', 'category', 'products'));
    }


    public function filter(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::query();

            $products->when(!empty($request->category_id), function ($query) use ($request) {
                return $query->where('category_id', $request->category_id);
            });

            $products->when(!empty($request->brand_id), function ($query) use ($request) {
                return $query->where('brand_id', $request->brand_id);
            });

            $products->when(!empty($request->price_order), function ($query) use ($request) {
                $orderDirection = $request->price_order == 'desc' ? 'desc' : 'asc';
                return $query->orderByRaw('COALESCE(price_sale, price) ' . $orderDirection);
            });

            // $products->when($request->min && $request->max, function ($query) use ($request) {
            //     return $query->selectRaw('*, CASE WHEN price_sale IS NULL THEN price ELSE price_sale END AS price')->whereBetween('price', ["{$request->min}000", "{$request->max}000"]);
            // });

            $products->when($request->min && $request->max, function ($query) use ($request) {
                $min = (int) $request->min * 1000;
                $max = (int) $request->max * 1000;
                return $query->where(function ($query) use ($min, $max) {
                    $query->whereBetween('price', [$min, $max])
                        ->orWhereBetween('price_sale', [$min, $max]);
                });
            });

            $products = $products->with('galleries')->paginate(9);

            return response()->json([
                'data' => $products->items(),
                'links' => (string) $products->links()
            ]);
        }
    }
}
