<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class BrandController extends Controller
{
    public function __construct()
    {
        // examples:
        // $this->middleware(['permission:view brands'])->only(['index']);
        // $this->middleware(['permission:create brands'])->only(['create', 'store']);
        // $this->middleware(['permission:edit brands'])->only(['edit', 'update']);
        // $this->middleware(['permission:delete brands'])->only(['destroy']);
    }
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Brand::select('*'))
                ->addColumn('action', function ($brand) {
                    return view('admin.action', ['path' => 'admin.brands.edit', 'id' => $brand->id]);
                })
                ->rawColumns(['action'])
                ->make(true);;
        }
        return view('admin.brands.index');
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:brands',
            'slug' => 'required|unique:brands',
        ]);

        if ($validator->passes()) {

            Brand::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'status' => $request->status,
            ]);

            Session::flash('success', 'Brand created successfully.');
            return response()->json(['status' => true, 'message' => 'Brand created successfully.']);
        } else {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:brands,name,' . $request->id,
            'slug' => 'required|unique:brands,slug,' . $request->id,
        ]);

        if ($validator->passes()) {

            $brand = Brand::findOrFail($request->id);
            $brand->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'status' => $request->status,
            ]);

            Session::flash('success', 'Brand updated successfully.');

            return response()->json(['status' => true, 'message' => 'Brand updated successfully.']);
        } else {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }
    }

    public function destroy(Request $request)
    {
        $brand = Brand::findOrFail($request->id);
        $brand->delete();
        return response()->json(['status' => true, 'message' => 'Brand deleted successfully.']);
    }
}
