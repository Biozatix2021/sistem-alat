<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class session
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
        // check if session is exist
        if ($request->session()->has('id') && $request->session()->has('name')) {
            return $next($request);
        } else {
            return redirect('https://sso.impellink.net/login');
        }
    }
}
