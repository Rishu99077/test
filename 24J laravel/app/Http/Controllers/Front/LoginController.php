<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\Country;
use App\Models\Users;

use Image;

class LoginController
{

    public function signup(Request $request){
        $common = array();
        $common['title'] = 'Signup';
        $common['heading_title'] = 'Signup';

        $data = Session::all();
        $get_country = Country::all();
        $get_all_user = Users::all();

        if ($request->isMethod('post')) {

            $req_filed                  =   array();
            $req_filed['first_name']    =   "required";
            $req_filed['last_name']     =   "required";
            $req_filed['email']         =   "required|email|unique:users";
            $req_filed['password']      =   "required";
            $req_filed['company_name']  =   "required";
            $req_filed['designation']   =   "required";
            $req_filed['contact']       =   "required";
            $req_filed['image']          =  'mimes:jpeg,png,jpg,gif';
            $req_filed['country']       =   "required";
            $req_filed['status']        =   "required";

            $validation = Validator::make($request->all(), $req_filed);

            if ($validation->fails()) {
                return back()->withErrors($validation)->withInput();
            }

            $Users = new Users();
            $Users->first_name        = $request->first_name;
            $Users->last_name         = $request->last_name;
            $Users->email             = $request->email;
            $Users->password          = Hash::make($request->password);
            $Users->company_name      = $request->company_name;
            $Users->designation       = $request->designation;
            $Users->contact           = $request->contact;

            if ($request->hasFile('image')) {
                $random_no = Str::random(5);
                $img = $request->file('image');
                $ext = $img->getClientOriginalExtension();
                $new_name = time() . $random_no . '.' . $ext;
                $destinationPath = public_path('uploads/users/');
                $img->move($destinationPath, $new_name);
                $Users->image = $new_name;
            }

            $Users->country           = $request->country;
            $Users->town              = $request->town;
            $Users->address           = $request->address;
            $Users->create_group      = $request->create_group;
            $Users->status            = $request->status;
            $Users->role              = $request->role;

            if ($request->contact_users) {
                $Users->contact_users     = implode(',', $request->contact_users);
            }
            
            $Users->source            = 'WEB';

            $Users->save();

            return redirect(route('login'))->withErrors(['success' => "Signup Successfully"]);
        }

        return view('front.signup', compact('common','get_country','data','get_all_user'));
    }


    public function login(Request $request){
        $common = array();
        $common['title'] = 'Login';
        $common['heading_title'] = 'Login';

        if ($request->isMethod('post')) {

            $validation = Validator::make($request->all(), [
                'email'    => 'email|required',
                'password' => 'required'
            ]);
            if ($validation->fails()) {
                return back()->withErrors($validation)->withInput();
            }
            $user = Users::where(['email' => $request->email])->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    $request->session()->put('em_user_id', $user->id);
                    return redirect(route('home'))->withErrors(['success' => "Login Successfully"]);
                } else {
                    return back()->withErrors(['error' => "Invalid Credential", 'emailid' => $request->email]);
                }
            } else {
                return back()->withErrors(['error' => "Invalid Credential", 'emailid' => $request->email]);
            }
        }
        return view('front.login', compact('common'));
    }

     ///Logout
    public function logout(){
        session()->flush();
        return redirect()->route('login');
    }

}