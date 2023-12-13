<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Hash;

use App\Models\User;

class ApiAuth
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
        $validator = Validator::make(
            $request->all(),

            [
                'user_id' => 'required',

                'password' => 'required',
            ],
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,

                    'message' => $validator->errors()->first(),
                ],
                402,
            );
        }

        $User = User::where('id', $request->user_id)->first();

        if ($User) {
            if ($request->password == $User->password) {
                return $next($request);
            }
        }

        return response()->json(['message' => '403', 'status' => 'false'], 401);
    }
}
