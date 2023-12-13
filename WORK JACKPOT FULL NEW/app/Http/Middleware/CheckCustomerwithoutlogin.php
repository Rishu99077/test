<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class CheckCustomerwithoutlogin{
    public function handle(Request $request, Closure $next){
        if ($request->session()->has('cust_id')) {            
            return redirect('dashboard');
        }
        return $next($request);
    }
}
