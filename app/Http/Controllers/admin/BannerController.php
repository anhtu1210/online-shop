<?php

namespace App\Http\Controllers\admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Banner::latest()->get())
                ->addColumn('action', function ($data) {
                    return view('admin.action', ['path' => 'admin.banners.edit', 'id' => $data->id]);
                })
                ->addColumn('image_url', function ($data) {
                    return '<img src="' . asset('images/banners/' . $data->image_url) . '" class="img-thumbnail" width="50">';
                })
                ->rawColumns(['action', 'image_url'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.banner.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valiate = $request->validate([
            'title' => 'required',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status' => 'required|in:1,0',
            'link' => 'nullable|url',
        ]);

        $image = $request->file('image_url');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('/images/banners'), $filename);

        $valiate['image_url'] = $filename;
        Banner::create($valiate);

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banner.edit', ['banner' => $banner]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $valiate = $request->validate([
            'title' => 'required',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status' => 'required|in:1,0',
            'link' => 'nullable|url',
        ]);


        if ($request->hasFile('image_url')) {
            File::delete(public_path('/images/banners/' . $banner->image_url));
            $image = $request->file('image_url');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/images/banners'), $filename);
            $valiate['image_url'] = $filename;
        }

        $banner->update($valiate);
        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        File::delete(public_path('/images/banners/' . $banner->image_url));
        $banner->delete();

        return response()->json(['status' => true, 'message' => 'Banner deleted successfully.']);
    }
}
