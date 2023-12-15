<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class CheckUserAuth
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
        $validator = Validator::make($request->all(), [
            'user_id'  => 'required',
            'password' => 'required', 
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ],403);
        }
        $user_id = 0;
        if (checkDecrypt($request->user_id)) {
            $user_id = checkDecrypt($request->user_id);
            
            $User = User::where('id', $user_id)
                    ->where('status', 'Active')
                    ->first();
            if ($User) {
                if ($request->password == $User->password) {
                    $request->request->add(['user_id' => $user_id]);
                    return $next($request);
                }
            }
        }
        return response()->json(['message' => '401', 'status' => 'false'], 401);
    }
}
