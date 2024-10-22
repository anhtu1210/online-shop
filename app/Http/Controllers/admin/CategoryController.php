<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        // examples:
        $this->middleware(['permission:view categories'])->only(['index']);
        $this->middleware(['permission:create categories'])->only(['create', 'store']);
        $this->middleware(['permission:edit categories'])->only(['edit', 'update']);
        $this->middleware(['permission:delete categories'])->only(['destroy']);
    }
    public function index()
    {

        if (request()->ajax()) {
            return datatables()->of(Category::with('parent')->select('*'))
                ->addColumn('action', function ($category) {
                    return view('admin.action', ['path' => 'admin.categories.edit', 'id' => $category->id]);
                })
                ->addColumn('parent', function ($category) {
                    return ($category->parent) ? $category->parent->name : 'Root';
                })
                ->addColumn('image', function ($category) {
                    return  $category->image ? '<img src="' . $category->image . '" class="img-thumbnail" width="50">' : '';
                })
                ->rawColumns(['action', 'image'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.categories.index');

        // ->addColumn('action', function($category) {
        //     return view('admin.categories.action', compact('category'))->render();
        // })
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get()->toTree();


        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => ['required', Rule::unique('categories')->where(function ($query) use ($request) {
                return $query->where('parent_id', $request->parent_id);
            })],
            'slug' => ['required', Rule::unique('categories')->where(function ($query) use ($request) {
                return $query->where('parent_id', $request->parent_id);
            })],
            'status' => 'required',
            'parent_id' => 'nullable|exists:categories,id',
        ]);



        if ($validate->passes()) {
            $category = Category::create([
                'name' => $request->name,
                'slug' => str()->slug($request->slug),
                'status' => $request->status
            ]);

            if ($request->parent_id) {
                $parentCategory = Category::find($request->parent_id);
                $parentCategory->appendNode($category);
            } else {
                $category->saveAsRoot();
            }

            Session::flash('success', 'Thêm danh mục thành công.');

            return response()->json(['status' => true, 'message' => 'Thêm mới danh mục thành công.'], 200);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validate->errors()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $categories = Category::where('id', '!=', $id)->get()->toTree();


        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,' . $request->id,
            'slug' => 'required',
            'status' => 'required',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category = Category::findOrFail($request->id);

        if ($validate->passes()) {
            // Update category attributes
            $category->update([
                'name' => $request->name,
                'slug' => str()->slug($request->slug),
                'status' => $request->status
            ]);

            if ($request->parent_id) {
                $parentCategory = Category::find($request->parent_id);
                if ($parentCategory) {
                    $category->appendToNode($parentCategory)->save();
                } else {
                    return response()->json(['status' => false, 'message' => 'Danh mục cha không tồn tại.'], 400);
                }
            } else {
                $category->saveAsRoot();
            }

            Session::flash('success', 'Cập nhật mục thành công.');

            return response()->json(['status' => true, 'message' => 'Cập nhật danh mục thành công.'], 200);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validate->errors(),
            ]);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->delete();

        return response()->json(['success' => true]);
    }
}
