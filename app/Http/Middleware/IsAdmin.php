<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        // dd($request);
        // dd($request);
        // if (!$request->expectsJson()) {
        //     return route('login');
        // }
        // if (Auth::guard('webadmin')->user()->hak_akses) {
        //     return $next($request);
        // }
        return redirect('/admin/auth/dashboard/login')->with('error', "Only admin can access!");
    }
}
