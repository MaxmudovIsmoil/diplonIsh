<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check())
            return redirect()->route('login')->with('message', trans('admin.Login or password error'));

        if (Auth::user()->status !== '1')
            return redirect()->route('login')->with('message', trans('admin.You are blocked. Contact your administrator to login'));


        return $next($request);
    }
}
