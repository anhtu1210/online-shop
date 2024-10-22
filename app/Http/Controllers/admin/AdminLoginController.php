<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);


        if ($validator->passes()) {

            if (auth()->guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

                $user = auth()->guard('admin')->user();

                if ($user->roles->isNotEmpty()) {
                    return redirect()->route('admin.dashboard')->with('success', 'Chào mừng quay trở lại.');
                } else {
                    Auth::guard('admin')->logout();
                    return redirect()->route('admin.login')->with('error', 'Bạn không có quyền truy cập vào ban quản lý.')->withInput($request->only('email'));
                }
            } else {

                return redirect()->route('admin.login')->with('error', 'Tài khoản hoặc mật khẩu không chính xác.');
            }
        } else {
            return redirect()->route('admin.login')->withErrors($validator)->withInput($request->only('email'));
        }
    }
}
