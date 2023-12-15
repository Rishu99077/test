<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Users;

use Mail;
use Illuminate\Support\Facades\Hash;
use Image;
use Illuminate\Support\Str;

class LoginController extends Controller
{

    public function signup(Request $request){
    
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){
            $validation = Validator::make($request->all(), [
              'full_name'       => 'required',
              'email'           => 'required|unique:users,email',
              'phone_number'    => 'required|unique:users,contact',
              'password'        => 'required|min:6|confirmed',
              'password_confirmation' => 'required|min:6',
              'company_name'    => 'required',
              'designation'     => 'required',
              'country'         => 'required|numeric',
              'town'            => 'required',
            ]);
            if ($validation->fails()) {
              $output['message'] = $validation->errors()->first();
              return response()->json($output); die;
            }

            
            $Users = new Users();
            $Users->first_name       = $request->full_name;
            $Users->email            = $request->email;
            $Users->contact          = $request->phone_number;
            $Users->password         = Hash::make($request->password);
            $Users->company_name     = $request->company_name;
            $Users->designation      = $request->designation;
            $Users->country          = $request->country;
            $Users->town             = $request->town;
            $Users->address          = $request->address;
            $Users->status           = $request->status;
            $Users->create_group     = $request->create_group;
            if ($request->contact_users) {
                $Users->contact_users    = implode(',', $request->contact_users);
            }
            $Users->source           = 'APP';

            if ($request->hasFile('image')) {
                $random_no = Str::random(5);
                $img = $request->file('image');
                $ext = $img->getClientOriginalExtension();
                $new_name = time() . $random_no . '.' . $ext;
                $destinationPath = public_path('uploads/users/');
                $img->move($destinationPath, $new_name);
                $Users->image = $new_name;
            }


            $Users->save();
        
            $output['status']      = true;
            $output['customer_id'] = $Users->id;
            $output['message']     = 'Signup Successfully';
        }else{
            $output['message'] = '405';
        }
        return response()->json($output); die;
    }

    public function login(Request $request){

        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){
            $validation = Validator::make($request->all(), [
              'phone_number' => 'required',
              'password'     => 'required',
              
            ]);
            if ($validation->fails()) {
              $output['message'] = $validation->errors()->first();
              return response()->json($output); die;
            }

            $customer = Users::where(['contact' => $request->phone_number])->first();
            if ($customer) {
                if (Hash::check($request->password, $customer->password)) {
                
                    $output['status'] = true;
                    $output['customer_id']  = $customer->id;
                    $output['password']     = $customer->password;
                    $output['message']      = 'Login Successfully';
                   
                } else {
                    $output['message'] = 'Invalid credential';
                }
            } else {
                $output['message'] = 'User Not exist';
            }
        }else{
            $output['message'] = '405';
        }
        return response()->json($output); die;
    }

    public function forgotpasword(Request $request){
        $output=array();
        $output['status']=false;

        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){
            $validation = Validator::make($request->all(), [
              'phone_number'          => 'required',
            ]);

            if ($validation->fails()) {
              $output['message'] = $validation->errors()->first();
              return response()->json($output); die;
            }
            
            $customer = Users::where(['contact' => $request->phone_number])->first();
            if ($customer) {
                $otp = random_int(1000, 9999);
                // $otp = 1234;
                $customer->otp   = $otp;
                $customer->save();

                // MAIL NOTIFICATION
                $data = array();
                $data['name']  = $customer->first_name;   
                $data['email'] = $customer->email;
                $data['otp']   = $customer->otp;
                $data['subject']     = 'Forgot password on 24JE Cards ';
                $data['description'] = 'Forgot password on 24JE Cards ';
                //echo "string"; die;
                Mail::send('email.forgotpassword', $data, function ($message) use ($data) {
                    $message->to($data['email'], $data['name'])
                        ->subject($data['subject']);
                });

                $output['status']  = true;
                $output['email']   = $customer->email;
                $output['message'] = 'Mail send Successfully on your registered email id, please check otp there';
            }else{
                $output['message'] = 'Phone number not exist';
            }
        }else{
            $output['message'] = '405';
        }
        return response()->json($output); die;
    }

    public function verify_otp(Request $request){
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validation = Validator::make($request->all(), [
              'email'            => 'email|required',
              'otp'              => 'required',
            ]);

            if ($validation->fails()) {
              $output['message'] = $validation->errors()->first();
              return response()->json($output); die;
            }

            $customer = Users::where(['otp' => $request->otp,'email' => $request->email])->first();
            if ($customer) { 
                $output['status']  = true;
                $output['message'] = 'Otp match Successfully';       
            } else {
                $output['message'] = 'Otp does not match';
            }

        }else{
            $output['message'] = '405';
        }
        return response()->json($output); die;
    }
   
    public function resetpasword(Request $request){
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){
            
            $validation = Validator::make($request->all(), [
              'email'            => 'required',
              'new_password'     => 'required|min:6',
              'confirm_password' => 'required|same:new_password|min:6',
            ]);

            if ($validation->fails()) {
              $output['message'] = $validation->errors()->first();
              return response()->json($output); die;
            }
            $customer = Users::where(['email' => $request->email])->first();
            if ($customer) {           
                $data = array();
                $output['status'] = true;
                if ($request->new_password) {
                    $data['password']    = Hash::make($request->new_password);                  
                }
                Users::where('id', $customer['id'])->update($data);  

                $output['status']  = true;
                $output['message'] = 'Password Update Successfully';       
            } else {
                $output['message'] = "User Not exist";
            }
        }else{
            $output['message'] = '405';
        }
        return response()->json($output); die;
    }
 
}