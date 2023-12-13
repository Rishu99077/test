<?php



namespace App\Http\Middleware;



use Closure;

use Illuminate\Http\Request;



class Cors

{

    /**

     * Handle an incoming request.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next

     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse

     */

     public function handle($request, Closure $next)
     {
   
        $browsers = ['Opera', 'Mozilla', 'Firefox', 'Chrome', 'Edge','Safari'];

        $userAgent = request()->header('User-Agent');
      
        $isBrowser = false;
      
        foreach($browsers as $browser){
          if(strpos($userAgent, $browser) !==  false){
            return $next($request);
          }
        }
        return $next($request);
      
        // return ['result' => 'No-Access'];
     }

}

