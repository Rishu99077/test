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
use App\Models\UserWalletHistory;
use App\Models\AffilliateCommission;
use Mail;

class UserController extends Controller
{
    //User Profile
    public function userProfile(Request $request)
    {
        $output            = [];
        $output['status']  = false;
        $output['message'] = "User Not Found";
        $validator = Validator::make($request->all(), [
            'language'         => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ],
                402,
            );
        }
        $user_id = $request->user_id;
        $data    = array();
        $User                       = User::where('id', $user_id)->where('is_verified', 1)->where('status', 'Active')->where('is_delete', 0)->first();
        if ($User) {
            $data['name']            = $User->name            != "" ? $User->name         : '';
            $data['phone_number']    = $User->phone_number    != '' ? $User->phone_number : '';
            $data['email']           = $User->email           != '' ? $User->email        : '';
            $data['country']         = $User->country         != '' ? $User->country      : '';
            $data['giftcard_wallet'] = $User->giftcard_wallet != '' ? $User->giftcard_wallet      : 0;
            $data['giftcard_wallet'] = $User->giftcard_wallet != '' ? ConvertCurrency($User->giftcard_wallet)      : 0;
            $data['country_name']   = "";
            if ($User->country) {
                $get_country        = Country::where('id', $User->country)->first();
                if ($get_country) {
                    $data['country_name']   = $get_country->name != '' ? $get_country->name  : '';
                }
            }

            $data['state']          = $User->state != '' ? $User->state : '';
            $data['state_name']     = "";
            if ($User->state) {
                $get_state          = States::where('country_id', $User->country)->first();
                if ($get_state) {
                    $data['state_name']   = $get_state->name != '' ? $get_state->name  : '';
                }
            }

            $data['city']           = $User->city != '' ? $User->city : "";
            $data['city_name']      = "";
            if ($User->state) {
                $get_city           = City::where('state_id', $User->state)->first();
                if ($get_city) {
                    $data['city_name']   =  $get_city->name   != '' ?  $get_city->name  : '';
                }
            }
            $data['address']               = $User->address != '' ? $User->address : "";
            $data['code']                  = $User->affiliate_code;
            $data['user_type']             = $User->user_type;
            $data['image']                 = $User->image   != '' ? url('uploads/user_image',$User->image): asset('public/uploads/img_avatar.png');

            $data['current_reward_points'] = number_format($User->current_reward_points,2);
            $data['spend_reward_points']   = number_format($User->spend_reward_points,2);
            $data['total_reward_points']   = number_format($User->spend_reward_points + $User->current_reward_points,2);

           
            if($User['user_type'] == 'Affiliate'){
                $total_affilate_comision   = AffilliateCommission::where('user_id', $user_id)->sum('total');
                $pending_affilate_comision = AffilliateCommission::where('user_id', $user_id)->where('status','Pending')->sum('total');
                $paid_affilate_comision    = AffilliateCommission::where('user_id', $user_id)->where('status','Paid')->sum('total');
                
                
                $data['total_affilate_comision']   = number_format($total_affilate_comision,2);
                $data['pending_affilate_comision'] = number_format($pending_affilate_comision,2);
                $data['paid_affilate_comision']    = number_format($paid_affilate_comision,2);
            }


            $output['status']   = true;
            $output['user_id']  = encrypt($User->id);
            $output['password'] = $User->password;
            $output['data']     = $data;
            $output['message']  = 'User Profile';
        }
        return json_encode($output);
    }


    //User Profile Update
    public function userProfileupdate(Request $request)
    {
        $output           = [];
        $output['status'] = false;
        $validator = Validator::make($request->all(), [
            'language'         => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ],
                402,
            );
        }
        $user_id = $request->user_id;

        $User                           = User::where('id', $user_id)->where('is_verified', 1)->where('status', 'Active')->where('is_delete', 0)->first();
        if ($User) {
            if ($request->name) {
                $User->name                 = $request->name;
            }
            if ($request->phone_number) {
                $User->phone_number         = $request->phone_number;
            }
            // if($request->email){
            //     $User->email                = $request->email;
            // }
            if ($request->country) {
                $User->country              = $request->country;
            }
            if ($request->state) {
                $User->state                = $request->state;
            }
            if ($request->city) {
                $User->city                 = $request->city;
            }

            if ($request->address) {
                $User->address              = $request->address;
            }

            if ($request->hasFile('image')) {
                $random_no  	 = uniqid();
                $img 			 = $request->file('image');
                $ext 			 = $img->getClientOriginalExtension();
                $new_name 		 = $random_no . '.' . $ext;
                $destinationPath =  public_path('uploads/user_image');
                $img->move($destinationPath, $new_name);
                $User->image     = $new_name;
            }
            $User->save();

            $output['user_id']  = encrypt($User->id);
            $output['password'] = $User->password;
            $output['status']   = true;
            $output['message']  = 'Profile Update Successfull';
        }
        return json_encode($output);
    }


    //User Change Password
    public function changePassword(Request $request)
    {
        $output           = [];
        $output['status'] = false;
        $validator        = Validator::make($request->all(), [
            'language'          => 'required',
            'old_password'      => 'required',
            'new_password'      => 'required',
            'confirm_password'  => 'required|same:new_password',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ],
                402,
            );
        }
        $user_id                = $request->user_id;
        $User                   = User::where('id', $user_id)->where('is_verified', 1)->where('status', 'Active')->where('is_delete', 0)->first();
        if ($User) {
            if ($request->old_password == $User->decrypt_password) {
                $User->password         = Hash::make($request->password);
                $User->decrypt_password = $request->old_password;
                $User->save();

                $data = [
                    'subject' => 'Password Changed Successfull',
                    'title'   => 'Password Changed Successfully',
                    'email'   => $User->email,
                    'name'    => $User->name,
                    'page'    => 'email.password_changed_mail',
                ];

                User::send_mail($data);

                $output['user_id']  = encrypt($User->id);
                $output['password'] = $User->password;
                $output['status']   = true;
                $output['message']  = 'Password  Update Successfull';
            } else {
                $output['message']  = 'old password was wrong';
            }
        }
        return json_encode($output);
    }


    //User userWalletHistory
    public function userWalletHistory(Request $request)
    {
        $output            = [];
        $output['status']  = false;
        $output['message'] = "User Not Found";
        $validator = Validator::make($request->all(), [
            'language'         => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ],
                402,
            );
        }
        $user_id = $request->user_id;
        $data    = array();
        $get_history_arr         = [];
        $UserWalletHistory       = UserWalletHistory::where('user_id', $user_id)->orderBy('id','desc')->get();
        if(!$UserWalletHistory->isEmpty()){
            foreach($UserWalletHistory as $key => $value){
                $get_arr = [];
                $get_arr['amount']   = ConvertCurrency($value['amount']);
                $get_arr['added_by'] = $value['added_by'];
                $get_arr['date']     = date('Y-m-d',strtotime($value['created_at']));
                $get_history_arr[]   = $get_arr;
            }

            $output['status']   = true;
            $output['data']     = $get_history_arr;
            $output['message']  = 'User Wallet History';
        }        
        
        
        
        return json_encode($output);
    }
}
