<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    //
    public function __construct()
    {
        // examples:
        $this->middleware(['permission:view permissions'])->only(['index']);
        $this->middleware(['permission:create permissions'])->only(['create', 'store']);
        $this->middleware(['permission:edit permissions'])->only(['edit', 'update']);
        $this->middleware(['permission:delete permissions'])->only(['destroy']);
    }

    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Permission::all())
                ->addColumn('action', function ($permission) {
                    return view('admin.action', ['path' => 'admin.permissions.edit', 'id' => $permission->id]);
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.permissions.index');
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3',
        ]);

        if ($validator->passes()) {
            Permission::create(['name' => $request->name]);
            return response()->json(['status' => true, 'message' => 'Permission created successfully.']);
        } else {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request)
    {
        $permission = Permission::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:permissions,name,' . $permission->id,
        ]);

        if ($validator->passes()) {

            $permission->update(['name' => $request->name]);

            return response()->json(['status' => true, 'message' => 'Permission updated successfully.']);
        } else {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }
    }

    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            $permission = Permission::findOrFail($request->id);
            $permission->delete();
            return response()->json(['success' => true, 'message' => 'Permission deleted successfully.']);
        }
    }
}
