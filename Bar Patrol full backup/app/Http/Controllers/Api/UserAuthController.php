<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use App\Models\UserModel;

class UserAuthController extends Controller
{
    /**
     * Get Login page
     * @return view
     */

    public function customer_signup(Request $request){   

      $output=array();
      $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validator = Validator::make(
              $request->all(), 
               [
                  'restaurant_name'=>'required|unique:users',
                  'email' => 'required|email|unique:users',
                  'password' => 'required|min:6',
                  'confirm_password' => 'required|min:6|same:password',
                  'phone_no' => 'required|min:10|unique:users',
                  'country_id'=>'required',
                  'state_id'=>'required',
                  'city_id'=>'required',
              ]
            );

            if ($validator->fails()) {
                return response()->json([
                  'status' => false,
                  'message' => $validator->errors()->first(),
                ], 402);
            }

            $data = array();
            $data['restaurant_name'] = $request->restaurant_name;
            $data['email'] = $request->email;
            $data['password'] = sha1($request->password);
            $data['phone_no'] = $request->phone_no;
            $data['country'] = $request->country_id;
            $data['state'] = $request->state_id;
            $data['city'] = $request->city_id;
            $data['user_role'] = 2;
            $data['source'] = 'App';
           
            $insert_id = UserModel::create($data);

            $res_data = array();
            $res_data['restaurant_id'] = $insert_id['id'];
            $res_data['restaurant_name'] = $data['restaurant_name'];
            $res_data['email'] = $data['email'];
            $res_data['phone_no'] = $data['phone_no'];
            $res_data['country_id'] = $data['country'];
            $res_data['state_id'] = $data['state'];
            $res_data['city_id'] = $data['city'];
            $res_data['user_role'] = $data['user_role'];
            $res_data['source'] = $data['source'];
          
            return response()->json([
              'status' => true,
              'message' => 'Customer signup successfully',
              'data' => $res_data,
            ], 402);

       }else{
          $output['message'] = '405';
       } 
       echo json_encode($output);
       die;   

    }

    public function customer_login(Request $request){
    
          $output=array();
          $output['status']=false;
          if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

              
              $validator = Validator::make(
                $request->all(), 
                [
                   'phone_no' => 'required',
                   'password' => 'required',
                ],
              );

              if ($validator->fails()) {
                  return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                  ], 402);
              }

              $get_single_user = UserModel::where(['phone_no' => $request->phone_no])->first();
              if (empty($get_single_user)) {
                 $get_single_user = UserModel::where(['email' => $request->phone_no])->first();
              }


              if($get_single_user!=''){     
                  $data = array();
                  $data['user_id'] = $get_single_user['id'];
                  $data['restaurant_name'] = $get_single_user['restaurant_name'];
                  $data['password'] = $get_single_user['password'];                    
                    $check_password = sha1($request->password);
                    if ($check_password == $get_single_user['password']) {
                        $success_msg = 'Login successfully';
                    
                        $res_data = array();
                        $res_data['user_id'] = $get_single_user['id'];
                        $res_data['restaurant_name'] = $get_single_user['restaurant_name'];

                        return response()->json([
                          'status' => true,
                          'message' => $success_msg,
                          'data' => $res_data,
                        ], 402);
                    
                    }else{

                        return response()->json([
                          'status' => false,
                          'message' => 'This password is incorrect',
                        ], 402);

                    }
              }else{
                  
                  return response()->json([
                    'status' => false,
                    'message' => 'This phone number or email does not exist',
                  ], 402); 
              }

          }else{
            $output['message'] = '405';
          } 
          echo json_encode($output);
          die;   
    }
}