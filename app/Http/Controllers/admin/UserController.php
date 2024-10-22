<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        // examples:
        $this->middleware(['permission:view users'])->only(['index']);
        $this->middleware(['permission:create users'])->only(['create', 'store']);
        $this->middleware(['permission:edit users'])->only(['edit', 'update']);
        $this->middleware(['permission:delete users'])->only(['destroy']);
    }

    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(User::where('id', '!=', Auth::user()->id)->with('roles')->get())
                ->addColumn('action', function ($user) {
                    return view('admin.action', ['path' => 'admin.users.edit', 'id' => $user->id]);
                })
                ->addColumn('created_at', function ($user) {
                    return $user->created_at->diffForHumans();
                })
                ->addColumn('role', function ($user) {
                    return  $user->roles->pluck('name')->implode(' | ');
                })
                ->rawColumns(['action', 'remember_token', 'role'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::get();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required',
                'comfirm_password' => 'required|same:password',
            ]);

            if ($validator->passes()) {

                try {
                    DB::beginTransaction();

                    $user = User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'address' => $request->address,
                        'phone_number' => $request->phone_number,
                        'password' => bcrypt($request->password),
                        'email_verified_at' => now()->format('Y-m-d H:i:s'),
                    ]);

                    $user->syncRoles($request->roles);

                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollBack();
                    session()->flash('error', $th->getMessage());
                }
                return response()->json(['status' => true, 'message' => 'Thêm người dùng thành công.']);
            } else {
                return response()->json(['status' => false, 'errors' => $validator->errors()]);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $roles = Role::get();

        return view('admin.users.edit', ['user' => User::findOrFail($id), 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|unique:users,email,' . $id,
                'roles' => 'required',
            ]);

            if ($validator->passes()) {
                try {
                    DB::beginTransaction();

                    User::findOrFail($id)->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'address' => $request->address,
                        'phone_number' => $request->phone_number,
                    ]);

                    $user = User::findOrFail($id);
                    $user->syncRoles($request->roles);

                    // $user->save();

                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollBack();
                    session()->flash('error', $th->getMessage());
                }
                Session::flash('success', 'Cập nhật người dùng thành công.');

                return response()->json(['status' => true, 'message' => 'Cập nhật người dùng thành công.']);
            } else {
                return response()->json(['status' => false, 'errors' => $validator->errors()]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            $user = User::findOrFail($request->id);
            $user->delete();
            return response()->json(['success' => true]);
        }
    }
}
