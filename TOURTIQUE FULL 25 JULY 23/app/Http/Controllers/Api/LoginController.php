<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\City;
use App\Models\Country;
use App\Models\States;
use App\Models\AddToCart;
use App\Models\TransferZones;
use App\Models\Locations;


use App\Models\Transfer;
use App\Models\TransferExtrasOptions;
use App\Models\TransferExtrasOptionsLanguage;
use App\Models\TransferExtras;
use App\Models\TransferExtrasLanguage;
use App\Models\TransferLanguage;
use App\Models\TransferCarType;
use Mail;


use App\Models\AirportTransferCheckOut;

class LoginController extends Controller
{
    //Signup
    public function signup(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $validator = Validator::make($request->all(), [
            'language' => 'required',
            'name' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email',
            'user_type' => 'required',
            'password' => 'required',
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
        $User->name             = $request->name;
        $User->phone_number     = $request->phone_number;
        $User->email            = $request->email;
        $User->password         = Hash::make($request->password);
        $User->decrypt_password = $request->password;
        $User->user_type        = $request->user_type;
        $User->added_by         = $request->user_type;
        $User->status           = "Active";
        if ($request->user_type  == "Affiliate") {

            $unique_affiliate_code = unique_affiliate_code('users', 'affiliate_code');
            $User->affiliate_code  = $unique_affiliate_code;
        }
        $otp                        = unique_otp('users', 'verfication_otp');
        $User->verfication_otp      = $otp;
        $expiry_time_str            = strtotime('+5 minutes', strtotime(date('Y-m-d H:i:s')));
        $User->verfication_otp_time = date('Y-m-d H:i:s', $expiry_time_str);
        $User->save();

        $data = [
            'subject' => 'Signup Verfication',
            'title' => 'Signup Verification Otp',
            'email' => $User->email,
            'name' => $User->name,
            'page' => 'email.signup_otp',
            'otp' => $otp,
        ];

        User::send_mail($data);
        $output['user_id']  = encrypt($User->id);
        $output['password'] = $User->password;
        $output['status']   = true;
        $output['message']  = 'Signup Successfull Check Your Mail For verification Otp';

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
                    if ($user->status == 'Active') {
                        if ($user->is_delete == 0) {

                            if ($request->agent_code) {
                                if ($user->agent_code == $request->agent_code) {
                                    $output['status']   = true;
                                    $output['verified'] = true;
                                    $output['user_id']  = encrypt($user->id);
                                    $output['password'] = $user->password;
                                    $output['message']  = 'Login Success';
                                } else {
                                    $output['message']  = 'Agent code not match';
                                }
                            } else {
                                $output['status']   = true;
                                $output['verified'] = true;
                                $output['user_id']  = encrypt($user->id);
                                $output['password'] = $user->password;
                                $output['message']  = 'Login Success';
                            }


                            AddToCart::where("token", $request->token)->update(['user_id' => $user->id]);
                        }
                    } else {
                        $output['message']  = 'Your Account is not active';
                    }
                } else {
                    $output['status']       = true;
                    $output['user_id']      = encrypt($user->id);
                    $output['message']      = 'Account was Not Verified Please Verfiy Your Account';
                }
            }
        }
        return json_encode($output);
    }

    //Verfy Otp
    public function verify_otp(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'Invalid  Credintial';

        $validator = Validator::make($request->all(), [
            'language' => 'required',
            'user_id' => 'required',
            'otp' => 'required',
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
        $user_id = checkDecrypt($request->user_id);

        // $User = User::where('verfication_otp', $request->otp);
        // if ($request->user_id) {
        $User =  User::where('id', $user_id);
        // }
        $User = $User->first();
        if ($User) {
            $current_time = date('Y-m-d H:i:s');
            // if (strtotime($User->verfication_otp_time) >= strtotime($current_time)) {
            // $User->verfication_otp = '';
            $User->is_verified     = 1;
            $User->update();
            $output['status']   = true;
            $output['user_id']  = encrypt($User->id);
            $output['password'] = $User->password;
            $output['message']  = 'otp verfication successfully';
            // } else {
            //     $output['message'] = 'verfication otp was expired ';
            // }
        }
        return json_encode($output);
    }

    //Resend Otp
    public function resend_otp(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'something went wrong';

        $validator = Validator::make($request->all(), [
            'user_id'  => 'required',
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
        $user_id = checkDecrypt($request->user_id);
        $User = User::where('id', $user_id)->first();
        if ($User) {
            $otp                        = rand(100000, 999999);
            $User->verfication_otp      = $otp;
            $expiry_time_str            = strtotime('+5 minutes', strtotime(date('Y-m-d H:i:s')));
            $User->verfication_otp_time = date('Y-m-d H:i:s', $expiry_time_str);
            $User->save();

            $data = [
                'subject' => 'Signup Verfication',
                'title'   => 'Signup Verification Otp',
                'email'   => $User->email,
                'name'    => $User->name,
                'page'    => 'email.signup_otp',
                'otp'     => $otp,
            ];

            User::send_mail($data);
            $output['status']   = true;
            $output['user_id']  = encrypt($User->id);
            $output['password'] = $User->password;
            $output['message']  = 'send otp on your mail successfully';
        }
        return json_encode($output);
    }

    //////Countries
    public function countries(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $validator = Validator::make($request->all(), [
            'language' => 'required',
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

        $get_countries = Country::get();
        $data = [];
        $row  = [];
        foreach ($get_countries as $key => $value) {
            $row['label'] = '';
            $row['value']   = $value['id'];
            if ($value['name']) {
                $row['label'] = $value['name'];
            }
            $data[] = $row;
        }

        return response()->json(
            [
                'status' => true,
                'message' => 'All Country list',
                'data' => $data,
            ],
            200,
        );
    }

    //////States
    public function states(Request $request)
    {
        $output = [];
        $output['status'] = false;

        $validator = Validator::make($request->all(), [
            'country_id' => 'required',
            'language' => 'required',
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

        $data       = [];
        $row        = [];
        $get_states = States::where(['country_id' => $request->country_id])->get();

        foreach ($get_states as $key => $value) {
            $row['label']       = '';
            $row['country_id'] = '';
            $row['value']         = $value['id'];
            if ($value['name']) {
                $row['label'] = $value['name'];
            }
            if ($value['country_id']) {
                $row['country_id'] = $value['country_id'];
            }
            $data[] = $row;
        }

        return response()->json(
            [
                'status' => true,
                'message' => 'All States list',
                'data' => $data,
            ],
            200,
        );

        return json_encode($output);
    }

    /////Cities
    public function cities(Request $request)
    {
        $output = [];
        $output['status'] = false;

        $validator = Validator::make($request->all(), [
            'language'  => 'required',
            'state_id'  => 'required',
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
        $data       = [];
        $get_cities = City::where('state_id', $request->state_id)->get();
        foreach ($get_cities as $key => $value) {
            $row['label']     = '';
            $row['state_id'] = '';
            $row['value']       = $value['id'];
            if ($value['name']) {
                $row['label'] = $value['name'];
            }
            if ($value['state_id']) {
                $row['state_id'] = $value['state_id'];
            }
            $data[] = $row;
        }

        return response()->json(
            [
                'status' => true,
                'message' => 'All Cities list',
                'data' => $data,
            ],
            200,
        );

        return  json_encode($output);
        die();
    }


    public function demoMAil(Request $request){
        
        $data = [];
        $data['email'] = "dev2.infosparkles@gmail.com";
        $data['subject'] = "dev2.infosparkles@gmail.com";
        $message = "dev2.infosparkles@gmail.com";
        $sent = Mail::send('email.demoEmail', $data, function ($message) use ($data) {
            $message->to($data['email'])->subject($data['subject']);
        });
    }


    //Forgot password
    public function forgot_password(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Something Went Wrong";
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
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
        $User = User::where('is_delete',0)->where('status', 'Active')->where('email', $request->email)->first();
        if ($User) {

            $otp                        = unique_otp('users', 'verfication_otp');
            $User->verfication_otp      = $otp;
            $expiry_time_str            = strtotime('+5 minutes', strtotime(date('Y-m-d H:i:s')));
            $User->verfication_otp_time = date('Y-m-d H:i:s', $expiry_time_str);
            $User->save();

            $data = [
            'subject' => 'forgot password',
            'title' => 'Forgot password Otp',
            'email' => $User->email,
            'name' => $User->name,
            'page' => 'email.signup_otp',
            'otp' => $otp,
            ];

            User::send_mail($data);

            $output['status']      = true;
            $output['status_code'] = 200;
            $output['user_id']       = encrypt($User->id);
            $output['message']     = 'Code Sent successfully Check your email!';
        } else {
            $output['message'] = "User not Recognised";
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
        $user = User::where('is_delete',0)->where('status', 'Active')->where('email', $request->email)->first();
        if ($user) {
            if (!Hash::check($request->password, $user->password)) {
                $user->password             = Hash::make($request->password);
                $user->verfication_otp      = NULL;
                $user->verfication_otp_time = NULL;
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


    //Forgot PAssword Verfy Otp
    public function forgot_verify_otp(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'otp was not matched';

        $validator = Validator::make($request->all(), [
            'language' => 'required',
            'otp'      => 'required',
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

        $User = User::where('verfication_otp', $request->otp)->where('is_delete',0)->where('status','active');
        $User = $User->first();
        if ($User) {
            $current_time = date('Y-m-d H:i:s');
            if (strtotime($User->verfication_otp_time) >= strtotime($current_time)) {
                $output['status']   = true;
                $output['email']    = $User->email;
                $output['message']  = 'otp verfication successfully';
            } else {
                $output['message']  = 'verfication otp was expired ';
            }
        }
        return json_encode($output);
    }
}

