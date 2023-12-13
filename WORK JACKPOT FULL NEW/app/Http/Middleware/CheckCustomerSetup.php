<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class CheckCustomerSetup{
    public function handle(Request $request, Closure $next){      
        if (Session::get('role') == 'seeker' AND Session::get('is_setup') == '0') {
            return redirect('verification_account');
        }
        return $next($request);
    }
}
