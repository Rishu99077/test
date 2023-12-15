<?php

namespace App\Http\Middleware;

use Closure;

class CustomAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('user_id')) {
            return $next($request);
        }
        return redirect('/admin_login');
    }
}
