<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Session;
use Route;

class AdminAuth
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



        if (Session::has('session_url')) {
            if (Session::has('previous_session_url')) {
                if (Session::get('session_url') != url()->current()) {
                    $request->session()->put('previous_session_url', Session::get('session_url'));
                }
            }else{
                $request->session()->put('previous_session_url', url()->previous());
            }
        }else{
            $request->session()->put('previous_session_url', url()->previous());
        }


        $request->session()->put('session_url', url()->current());
        if ($request->session()->has('em_admin_id')) {
            return $next($request);
        }
        return  redirect()->route('login');
    }
}
