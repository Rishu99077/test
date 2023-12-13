<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class CheckCustomer{
    public function handle(Request $request, Closure $next){
        if ($request->session()->has('cust_id')) {
            return $next($request);
        }
        return redirect('login');
    }
}
