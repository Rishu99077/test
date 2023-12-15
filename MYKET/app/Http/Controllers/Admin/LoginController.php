<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mail;

class LoginController
{
    //
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $validation = Validator::make($request->all(), [
                'email'    => 'email|required',
                'password' => 'required'
            ]);


            if ($validation->fails()) {
                return back()->withErrors($validation)->withInput();
            }

            $admin = Admin::where(['email' => $request->email, 'role' => 'Admin'])->first();
            if ($admin) {
                if (Hash::check($request->password, $admin->password)) {
                    $request->session()->put('em_admin_id', $admin->id);
                    $request->session()->put('em_role', "admin");
                    return redirect(route('admin.dashboard'))->withErrors(['success' => translate("Login Successfully")]);
                } else {
                    return back()->withErrors(['error' => translate("Invalid Credential"), 'emailid' => $request->email]);
                }
            } else {
                return back()->withErrors(['error' => translate("Invalid Credential"), 'emailid' => $request->email]);
            }
        }
        return view('admin.login');
    }

    ///Forget Password
    public function forgot_password(Request $request)
    {
        if ($request->isMethod('post')) {
            $validation = Validator::make($request->all(), [
                'email'    => 'email|required',
            ]);

            if ($validation->fails()) {
                return back()->withErrors($validation)->withInput();
            }

            $admin = Admin::where(['email' => $request->email])->first();
            if ($admin) {

                $name          = $admin->name;
                $email         = $admin->email;
                $data = array('subject' => "Forgot Password", 'title' => "Forgot Password", 'email' => $admin->email, 'user_id' => $admin->id, 'name' => $admin->first_name . ' ' . $admin->last_name, 'token_' => encrypt($admin->id), 'page' => 'email.admin.forgotpassword');

                $send_mail = Admin::send_mail($data);
                return redirect(route('login'))->withErrors(["success" => translate("Mail Send Successfully")]);
            } else {
                return back()->withErrors(['error' => translate("User Not Found")]);
            }
        } else {
            return view('admin.forgot_password');
        }
    }


    ///Reset Password
    public function reset_password($user_id = "", Request $request)
    {

        if ($user_id != "") {
            $user_id = checkDecrypt($user_id);
            $admin =  Admin::where('id', $user_id)->first();
            if ($admin) {
                return view('admin.reset_password', compact('user_id'));
            }
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'new_password'     => 'required',
                'new_password'     => 'required',
                'confirm_password' => 'required_with:new_password|same:new_password|'
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            if ($request->token) {
                $user_id = checkDecrypt($request->token);
                $admin = Admin::where(['id' => $user_id])->first();
                if ($admin) {
                    $admin->password = Hash::make($request->confirm_password);
                    $admin->save();
                    return redirect(route('login'))->withErrors(["success" => translate("Password Update Successfully")]);
                } else {
                    return redirect(route('login'))->withErrors(['error' => translate("Invalid Credential")]);
                }
            }
        }
    }

    ///Logout
    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
