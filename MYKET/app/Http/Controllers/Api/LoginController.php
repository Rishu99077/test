<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Mail;
use App\Models\User;
use App\Models\Admin;
use App\Models\AddToCart;


class LoginController extends Controller
{

    //Signup
    public function signup(Request $request)
    {

        $output = [];
        $output['status'] = false;
        $validator = Validator::make($request->all(), [
            'language'         => 'required',
            'name'             => 'required',
            'phone_number'     => 'required',
            'phone_code'       => 'required',
            'email'            => 'required|email',
            'user_type'        => 'required',
            'password'         => 'required',
            'confirm_password' => 'required_with:password|same:password',
        ]);

        $validator->after(function ($validator) {
            if (emailValidate('users', 'email', $validator->getData()['email'], $validator->getData()['user_type']) > 0) {
                $validator->errors()->add('email', 'email already exist');
            }
        });

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->errors()->first(),
                ],
                402,
            );
        }

        $User                   = new User();
        $User->first_name       = $request->name;
        $User->last_name        = $request->last_name;
        $User->phone_number     = $request->phone_number;
        $User->email            = $request->email;
        $User->password         = Hash::make($request->password);
        $User->decrypt_password = $request->password;
        $User->user_type        = $request->user_type;
        $User->phone_code       = $request->phone_code;
        $User->is_verified      = 1;
        $User->status           = "Active";

        if ($request->user_type == "Partner") {
            $User->status          = "Deactive";
            $User->slug            = createSlug('users', $request->company_name);
            $User->company_name    = $request->company_name;
            $User->company_address = $request->company_address;
            $User->company_email   = $request->company_email;
            $User->company_phone   = $request->company_phone;
        }

        if ($request->user_type  == "Affiliate") {
            $unique_affiliate_code = unique_affiliate_code('users', 'affiliate_code');
            $User->affiliate_code  = $unique_affiliate_code;
        }

        // $otp                        = unique_otp('users', 'verfication_otp');
        // $User->verfication_otp      = $otp;
        // $expiry_time_str            = strtotime('+5 minutes', strtotime(date('Y-m-d H:i:s')));
        // $User->verfication_otp_time = date('Y-m-d H:i:s', $expiry_time_str);

        $User->save();

        // Singup mail

        $email_data_array                   = [];
        $email_data_array['username']       = $request->name . ' ' . $request->last_name;
        $email_data_array['email']          = $request->email;
        $email_data_array['password']       = $request->password;
        $email_data_array['subject']        = 'Welcome to mytekt.com';
        $email_data_array['page']           = 'email.signup_mail';
        Admin::send_mail($email_data_array);

        AddToCart::where('token', $request->token)->update(['user_id' => $User->id, 'token' => null]);

        $data = [
            'subject' => 'Signup Verfication',
            'title'   => 'Signup Verification Otp',
            'email'   => $User->email,
            'name'    => $User->name,
            'page'    => 'email.signup_otp',
            // 'otp' => $otp,
        ];

        // User::send_mail($data);
        $output['user_id']   = encrypt($User->id);
        $output['password']  = $User->password;
        $output['user_type'] = $request->user_type;

        $output['status']   = true;
        // $output['message']  = 'Signup Successfull Check Your Mail For verification Otp';
        $output['message']  = 'Signup Successfully';

        return json_encode($output);
    }

    //Login
    public function login(Request $request)
    {
        $output             = [];
        $output['status']   = false;
        $output['verified'] = false;
        $output['message']  = 'Invalid  Credintial';

        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->errors()->first(),
                ],
                402,
            );
        }

        $user = User::where(['email' => $request->email])->first();
        if (!empty($user)) {
            if (Hash::check($request->password, $user->password)) {
                if ($user->is_verified == 1) {
                    $checkLogin = 0;
                    if ($user->status == 'Active') {
                        $checkLogin = 1;
                    }
                    if ($user->user_type == "Partner") {
                        $checkLogin = 1;
                    }
                    if ($checkLogin == 1) {
                        if ($user->is_delete == 0) {


                            $output['status']   = true;
                            $output['verified'] = true;
                            $output['user_id']  = encrypt($user->id);
                            $output['user_type'] = $user->user_type;
                            $output['password'] = $user->password;
                            $output['message']  = 'Login Success';

                            AddToCart::where('token', $request->token)->update(['user_id' => $user->id]);

                            //  AddToCart::where("token", $request->token)->update(['user_id' => $user->id]);
                        }
                    } else {
                        $output['message']  = 'Your Account is not active';
                    }
                } else {
                    $output['status']    = true;
                    $output['user_id']   = encrypt($user->id);
                    $output['user_type'] = $user->user_type;

                    $output['message']      = 'Account was Not Verified Please Verfiy Your Account';
                }
            }
        }
        return json_encode($output);
    }

    // Verify Email
    public function verify_email(Request $request)
    {
        // verify_email
        $output             = [];
        $output['status']   = false;
        $output['verified'] = false;
        $output['message']  = 'User not found.';

        $validator = Validator::make($request->all(), [
            'email'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->errors()->first(),
                ],
                402,
            );
        }
        // verified_otp 
        $user = User::where(['email' => $request->email])->first();
        if ($user) {
            $expiry_time_str            = strtotime('+5 minutes', strtotime(date('Y-m-d H:i:s')));
            $user->verified_otp_time = date('Y-m-d H:i:s', $expiry_time_str);
            $user->save();
            $data = [
                'title' => 'Forgot Password',
                'username' => $user->first_name . ' ' . $user->last_name,
                'email' => $request->email,
                'subject' => 'Forgot Password',
                'page' => 'email.forgotpassword',
                'link' => env("APP_URL") . 'change-password/' . encrypt($user->id),
            ];

            Admin::send_mail($data);

            $output['status']      = true;
            $output['status_code'] = 200;
            $output['message']     = 'Code Sent successfully Check your email!';
        }
        return json_encode($output);
    }

    // Forget Verify Link
    public function forget_verify_link(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'otp was not matched';

        $validator = Validator::make($request->all(), [
            'id'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->errors()->first(),
                ],
                402,
            );
        }

        $User = User::where(['is_delete' => null, 'id' => checkDecrypt($request->id)])->where('status', 'Active');
        $User = $User->first();
        // dd(checkDecrypt($request->id));
        if ($User) {
            $current_time = date('Y-m-d H:i:s');

            if (strtotime($User->verified_otp_time) >= strtotime($current_time)) {
                $output['status']   = true;
                $output['email']    = $User->email;
                $output['message']  = 'Verfication successfully';
            } else {
                $output['message']  = 'Verfication link was expired ';
            }
        }
        return json_encode($output);
    }


    //Reset Password
    public function reset_password(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Something Went Wrong";
        $validator = Validator::make($request->all(), [
            "email"           => "required|email",
            "password"        => "required",
            "confirm_password" => "required|same:password",
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->errors()->first(),
                ],
                402,
            );
        }
        $user = User::where('is_delete', null)->where('status', 'Active')->where('email', $request->email)->first();
        if ($user) {
            if (!Hash::check($request->password, $user->password)) {
                $user->password          = Hash::make($request->password);
                $user->decrypt_password  = $request->password;
                $user->verified_otp      = NULL;
                $user->verified_otp_time = NULL;
                $user->save();
                $output['status']      = true;
                $output['status_code'] = 200;
                $output['message']     = "Password Updated Successfully!";
            } else {
                $output['message'] = "Your New password must be different from previously used password!";
            }
        } else {
            $output['message']      = "user not recognised!";
        }
        return json_encode($output);
    }
}
