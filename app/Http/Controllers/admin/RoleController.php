<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function __construct()
    {
        // examples:
        $this->middleware(['permission:view roles'])->only(['index']);
        $this->middleware(['permission:create roles'])->only(['create', 'store']);
        $this->middleware(['permission:edit roles'])->only(['edit', 'update']);
        $this->middleware(['permission:delete roles'])->only(['destroy']);
    }
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Role::orderBy('name', 'ASC')->where('name', '!=', 'Admin')->get())
                ->addColumn('action', function ($role) {
                    return view('admin.action', ['path' => 'admin.roles.edit', 'id' => $role->id]);
                })
                ->addColumn('permissions', function ($role) {
                    return $role->permissions->pluck('name')->implode(', ');
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.roles.index');
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles',
            'permissions' => 'required',
        ]);

        if ($validator->passes()) {
            $role = Role::create(['name' => $request->name]);
            $role->syncPermissions($request->permissions);

            session()->flash('success', 'Role created successfully.');
            return response()->json(['status' => true, 'message' => 'Role created successfully.']);
        } else {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }
    }

    public function edit($id)
    {

        $role = Role::find($id);

        $rolePrommissions = $role->permissions()->pluck('name')->toArray();

        $permissions = Permission::all();

        return view('admin.roles.edit', compact('role', 'rolePrommissions', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $id,
            'permissions' => 'required',
        ]);

        if ($validator->passes()) {
            $role = Role::find($id);
            $role->name = $request->name;
            $role->save();
            $role->syncPermissions($request->permissions);

            session()->flash('success', 'Role updated successfully.');
            return response()->json(['status' => true, 'message' => 'Role updated successfully.']);
        } else {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }
    }
}
