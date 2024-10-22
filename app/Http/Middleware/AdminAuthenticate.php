<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // dd($request->expectsJson());
        return $request->expectsJson() ? null : route('admin.login');
    }

    protected function authenticate($request, array $guards)
    {
        if (Auth::guard('admin')->check()) {
            return $this->auth->shouldUse('admin');
        }
        // else {
        //     session(['url.intended' => url()->current()]);
        //     return redirect()->route('admin.login');
        // }

        $this->unauthenticated($request, ['admin']);
    }
}
