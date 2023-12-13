<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mail;

class LoginController extends Controller
{
    //
    public function login(Request $request){
        return view('admin.login');
    }
    public function dologin(Request $request){
        if ($request->isMethod('post')) {
            $validation = Validator::make($request->all(), [
                'email'    => 'email|required',
                'password' => 'required'
            ]);

            if ($validation->fails()) {
                return back()->withErrors($validation)->withInput();
            }
            $admin = Admin::where(['email' => $request->email, 'role' => 'Admin'])->first();
            $default_lang = Language::where(['is_default' => 1])->first();
            if ($default_lang) {
                $Lang_id = $default_lang['id'];
            }
            if ($admin) {
                if (Hash::check($request->password, $admin->password)) {
                    $request->session()->put('admin_id', $admin->id);
                    $request->session()->put('user_type', "admin");
                    Session::put('Lang', $Lang_id);
                    return redirect(route('admin.dashboard'))->withErrors(['success' => "Login Successfully"]);
                } else {
                    return back()->withErrors(['error' => "Invalid Credential", 'emailid' => $request->email]);
                }
            } else {
                return back()->withErrors(['error' => "Invalid Credential", 'emailid' => $request->email]);
            }
        } else {
            return back()->withErrors(['error' => "Invalid Credential"]);
        }
    }



    ///Forget Password
    public function forgot_pasword(Request $request)
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

                $admin->forgot_password_token   = Str::random(60);
                $admin->save();
                $name          = $admin->name;
                $email         = $admin->email;
                $data = array('subject' => "Forgot Password", 'email' => $admin->email, 'user_id' => $admin->id, 'name' => $admin->first_name . ' ' . $admin->last_name, 'token_' => $admin->forgot_password_token, 'page' => 'admin.email.forgotpassword');

                $send_mail = Admin::send_mail($data);
                // mail($email,"My subject",$admin->forgot_password_token);
                return redirect(route('login'))->withErrors(["success" => "Mail Send Successfully"]);
            } else {
                return back()->withErrors(['error' => "User Not Found"]);
            }
        } else {
            return view('admin.forgot_password');
        }
    }


    ///Reset Password
    public function reset_password($token = "", Request $request)
    {
        if ($token != "") {
            $admin =  Admin::where('forgot_password_token', $token)->first();
            if ($admin) {
                return view('admin.reset_password', compact('token'));
            }
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [

                'new_password'     => 'required',
                'confirm_password' => 'required_with:new_password|same:new_password|'

            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }


            $admin = Admin::where(['forgot_password_token' => $request->token])->first();
            if ($admin) {
                $admin->password = Hash::make($request->confirm_password);
                $admin->save();
                return redirect(route('login'))->withErrors(["success" => "Password Update Successfully "]);
            } else {
                return redirect(route('login'))->withErrors(['error' => "Invalid Credential"]);
            }
        }
    }


    ///Logout
    public function logout()
    {
        if (Session::get('user_type') == "admin") {
            $route = route('login');
        } else {
            $route = route('vendor.login');
        }
        session()->flush();


        return redirect($route);
    }


    public function demoMAil(Request $request){        
        return view('email.demoEmail');
        
        // $data = [];
        // $data['email'] = "dev2.infosparkles@gmail.com";
        // $data['subject'] = "dev2.infosparkles@gmail.com";
        // $message = "dev2.infosparkles@gmail.com";
        // $sent = Mail::send('email.demoEmail', $data, function ($message) use ($data) {
        //     $message->to($data['email'])->subject($data['subject']);
        // });
    }
}
