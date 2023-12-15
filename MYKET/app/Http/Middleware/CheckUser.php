<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class CheckUser
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
            'currency' => 'required',
            'language' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 403);
        }
        $user_id = 0;
        if (checkDecrypt($request->user_id)) {
            $user_id = checkDecrypt($request->user_id);

            $User = User::where('id', $user_id)
                ->first();
            if ($User) {
                $checkStatus = 0;
                if ($User->status == 'Active') {
                    $checkStatus = 1;
                }
                if ($User->user_type == 'Partner') {
                    $checkStatus = 1;
                }
                if ($checkStatus == 1) {
                    if ($request->password == $User->password) {
                        $request->request->add(['user_id' => $user_id]);
                        return $next($request);
                    }
                }
            }
        }
        return response()->json(['message' => 'User ID or Password is wrong', 'status' => 'false'], 401);
    }
}
