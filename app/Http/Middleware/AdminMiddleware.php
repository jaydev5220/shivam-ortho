<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminMiddleware
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

        if (!Auth::check()) {
            // User is not logged in — Redirect to login page without a message
            return redirect()->route('admin.login');
        }
        if (Auth::check() && Auth::user()->is_admin == 1) {
            return $next($request);
        } else {
            // You may redirect or return a response here show 404 page
            // return abort(404);
            return redirect()->route('admin.login')->with(['message' => 'This User is Not And Admin.', 'type' => 'error']);
        }
        return abort(404);
    }
}
