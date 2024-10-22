<?php

namespace App\Http\Controllers\admin;

use App\Models\Role;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        // examples:
        $this->middleware(['permission:view products'])->only(['index']);
        $this->middleware(['permission:create products'])->only(['create', 'store']);
        $this->middleware(['permission:edit products'])->only(['edit', 'update']);
        $this->middleware(['permission:delete products'])->only(['destroy']);
    }
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Product::with('galleries')->get())
                ->addColumn('action', function ($product) {
                    return view('admin.action', ['path' => 'admin.products.edit', 'id' => $product->id]);
                })
                ->addColumn('image', function ($product) {
                    $image = $product->galleries->isNotEmpty() ? $product->galleries->first()->image : null;
                    return  $image ? '<img src="' . asset('images/products/' . $image . '') . '" class="img-thumbnail" width="50">' : '';
                })
                ->addColumn('status', function ($product) {
                    return $product->status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Block</span>';
                })
                ->addColumn('price', function ($product) {
                    return number_format($product->price, 0, '.', ',');
                })
                ->addColumn('qty', function ($product) {
                    return !empty($product->qty) ? $product->qty  . ' left in Stock' : 'N/A';
                })
                ->rawColumns(['action', 'image', 'status'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.products.index');
    }

    public function create()
    {
        $categories = Category::get()->toTree();

        $brands = Brand::get();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {

        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products',
            'price' => 'required|numeric',
            'sku' => 'required',
            'track_qty' => 'required|in:Yes,No',
            'category_id' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
            'is_show_home' => 'required|in:Yes,No',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            $rules['qty'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            try {
                DB::beginTransaction();

                $product =  Product::create([
                    'title' => $request->title,
                    'slug' => $request->slug,
                    'description' => $request->description,
                    'price' => $request->price,
                    'price_sale' => $request->price_sale,
                    'sku' => $request->sku,
                    'barcode' => $request->barcode,
                    'track_qty' => $request->track_qty,
                    'qty' => $request->qty,
                    'is_featured' => $request->is_featured,
                    'is_show_home' => $request->is_show_home,
                    'category_id' => $request->category_id,
                    'brand_id' => $request->brand_id,
                    'status' => $request->status,
                ]);

                if ($request->hasFile('image')) {
                    $imageMain = $request->file('image');

                    $filename = time() . $product->id . '.' . $imageMain->getClientOriginalExtension();

                    $product->galleries()->create([
                        'product_id' => $product->id,
                        'image' => $filename
                    ]);

                    $imageMain->move(public_path('/images/products'), $filename);
                }

                if ($request->hasFile('image_gallery')) {
                    $images = $request->file('image_gallery');

                    foreach ($images as $key => $image) {
                        $filenameGallery = time() . $key . $product->id . '.' . $image->getClientOriginalExtension();

                        $product->galleries()->create([
                            'product_id' => $product->id,
                            'image' => $filenameGallery
                        ]);

                        $image->move(public_path('/images/products'), $filenameGallery);
                    }
                } else {
                    return response()->json(['status' => false, 'message' => 'Please select at least one image.']);
                }

                DB::commit();

                session()->flash('success', 'Product created successfully.');
            } catch (\Throwable $th) {
                DB::rollBack();
                session()->flash('error', $th->getMessage());
            }

            return response()->json(['status' => true, 'message' => 'Product created successfully.']);
        } else {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::get()->toTree();
        $brands = Brand::get();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $rules = [
            'title' => 'required|unique:products,title,' . $id,
            'slug' => 'required|unique:products,slug,' . $id,
            'price' => 'required|numeric',
            'sku' => 'required',
            'track_qty' => 'required|in:Yes,No',
            'category_id' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
            'is_show_home' => 'required|in:Yes,No',
        ];

        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            $rules['qty'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            try {
                DB::beginTransaction();
                $product->update([
                    'title' => $request->title,
                    'slug' => $request->slug,
                    'description' => $request->description,
                    'price' => $request->price,
                    'price_sale' => $request->price_sale,
                    'sku' => $request->sku,
                    'barcode' => $request->barcode,
                    'track_qty' => $request->track_qty,
                    'qty' => $request->qty,
                    'is_featured' => $request->is_featured,
                    'is_show_home' => $request->is_show_home,
                    'category_id' => $request->category_id,
                    'brand_id' => $request->brand_id,
                    'status' => $request->status,
                ]);

                $fisrtGallery = $product->galleries->first();

                if ($request->hasFile('image')) {
                    $imageMain = $request->file('image');
                    $filename = time() . $product->id . '.' . $imageMain->getClientOriginalExtension();

                    $urlImage = $fisrtGallery->image;

                    $fisrtGallery->update([
                        'image' => $filename
                    ]);

                    $imageMain->move(public_path('/images/products'), $filename);

                    File::delete(public_path('/images/products/' . $urlImage));
                }

                $galleryDelete = $product->galleries()->whereNotIn('id', $request->ids)->where('id', '!=', $fisrtGallery->id);

                foreach ($galleryDelete->get() as $gallery) {
                    File::delete(public_path('/images/products/' . $gallery->image));
                }

                $galleryDelete->delete();

                if ($request->hasFile('image_gallery')) {
                    $images = $request->file('image_gallery');
                    foreach ($images as $key => $image) {
                        $filenameGallery = time() . $key . $product->id . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('/images/products'), $filenameGallery);

                        $product->galleries()->create([
                            'product_id' => $product->id,
                            'image' => $filenameGallery
                        ]);
                    }
                }

                DB::commit();
                session()->flash('success', 'Product updated successfully.');

                return response()->json(['status' => true, 'message' => 'Product updated successfully.']);
            } catch (\Throwable $th) {
                DB::rollBack();
                session()->flash('error', $th->getMessage());
            }
        } else {

            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }
    }

    public function destroy(Request $request)
    {
        $product = Product::findOrFail($request->id);


        if ($product->galleries->count() > 0) {

            foreach ($product->galleries as $gallery) {
                if (File::exists(public_path('/images/products/' . $gallery->image))) {
                    File::delete(public_path('/images/products/' . $gallery->image));
                }
            }
        }

        $product->delete();

        return response()->json(['status' => true, 'message' => 'Product deleted successfully.']);
    }
}
