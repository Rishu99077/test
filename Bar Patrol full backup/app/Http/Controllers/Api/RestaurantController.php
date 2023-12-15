<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use App\Models\UserModel;
use App\Models\CountriesModel;
use App\Models\StatesModel;
use App\Models\CitiesModel;

use Mail;
use App\Mail\NotifyMail;

class RestaurantController extends Controller{

    public function detail(Request $request){
    
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validator = Validator::make(
              $request->all(), 
              [
                  'user_id' => 'required',
              ]
            );

            if ($validator->fails()) {
                return response()->json([
                  'status' => false,
                  'message' => $validator->errors()->first(),
                ], 402);
            }

            $get_single_user = UserModel::where(['id' => $request->user_id])->first();
           
            $data = array();
            if($get_single_user) {
              $data['restaurant_id'] = $get_single_user->id;
              $data['restaurant_name'] = $get_single_user->restaurant_name;
              $data['email'] = $get_single_user->email;   
              $data['phone_no'] = $get_single_user->phone_no;
              $country_id = $get_single_user->country;
              $state_id = $get_single_user->state;
              $city_id = $get_single_user->city;
              $data['country_name'] = ''; 
              $data['state_name'] = '';  
              $data['city_name'] = '';  

              $get_country = CountriesModel::where(['id' => $country_id])->first();
              if ($get_country) {
                $data['country_name'] = $get_country->name;
              }

              $get_state = StatesModel::where(['id' => $state_id])->first();
              if ($get_state) {
                $data['state_name'] = $get_state->name;
              }

              $get_city = CitiesModel::where(['id' => $city_id])->first();
              if ($get_city) {
                $data['city_name'] = $get_city->name;
              }
              $data['source'] = $get_single_user->source;   

              return response()->json([
                'status' => true,
                'message' =>'Restaurant detail',
                'data' => $data,
              ], 402);


            }else{
                return response()->json([
                  'status' => false,
                  'message' => 'This restaurant is not exist',
                ], 402);
            }
           
        }else{
          $output['message'] = '405';
        } 
       echo json_encode($output);
       die;   
    
    }

    public function update(Request $request){
      $output=array();
      $output['status']=false;
      if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

          $validator = Validator::make(
            $request->all(), 
            [
                'user_id' => 'required',
                'restaurant_name'=>'required',
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

           $get_user = UserModel::where('id','!=',$request->user_id)->where('restaurant_name',$request->restaurant_name)->first();
           if ($get_user!='') {
               return response()->json([
                    'status' => false,
                    'message' => 'This Restaurant name is already exists',
                  ], 402);
           }else{

              $get_single_user = UserModel::where(['id' => $request->user_id])->first();
              
              if($get_single_user!=''){
                    $data = array();
                    $data['id'] = $get_single_user['id'];
                    $data['restaurant_name'] = $request->restaurant_name;
                    $data['country'] = $request->country_id;
                    $data['state'] = $request->state_id;
                    $data['city'] = $request->city_id;
                    $data['source'] = 'App';  

                    UserModel::where('id', $get_single_user['id'])->update($data);
                     
                    $res_data = array();
                    $res_data['restaurant_id'] = $data['id'];
                    $res_data['restaurant_name'] = $data['restaurant_name'];
                    $res_data['country_id'] = $data['country'];
                    $res_data['state_id'] = $data['state'];
                    $res_data['city_id'] = $data['city'];
                    $res_data['source'] = $data['source'];
                      
                    return response()->json([
                      'status' => true,
                      'message' => 'Restaurant update succesfully',
                      'data' => $res_data,
                    ], 402);

              }else{
                   return response()->json([
                    'status' => false,
                    'message' => 'This Restaurant is not exist',
                  ], 402);
              }
           }  
      }else{
        $output['message'] = '405';
      } 
      echo json_encode($output);
      die;   

    }


    public function changepassword(Request $request){

      $output=array();
      $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validator = Validator::make(
              $request->all(), 
              [
                  'user_id' => 'required',
                  'device_id' => 'required',
              ]
            );

            if ($validator->fails()) {
                return response()->json([
                  'status' => false,
                  'message' => $validator->errors()->first(),
                ], 402);
            }

          
            $get_single_user = UserModel::where(['id' => $request->user_id])->first();
           
            if($get_single_user!=''){
                  $validator = Validator::make(
                    $request->all(), 
                    [
                        'oldpassword' => 'required',
                    ]
                  );

                  if ($validator->fails()) {
                      return response()->json([
                        'status' => false,
                        'message' => $validator->errors()->first(),
                      ], 402);
                  }

                  $check_oldpassword = sha1($request->oldpassword);
                  if ($check_oldpassword == $get_single_user->password) {
                      $validator = Validator::make(
                        $request->all(), 
                        [
                            'new_password' => 'required|min:6',
                        ]
                      );

                      if ($validator->fails()) {
                          return response()->json([
                            'status' => false,
                            'message' => $validator->errors()->first(),
                          ], 402);
                      }

                      $data['password'] = sha1($request->new_password); 

                      UserModel::where('id', $get_single_user['id'])->update($data);

                      return response()->json([
                        'status' => true,
                        'message' => 'Password Change successfully',
                        // 'data' => $data,
                      ], 402);
                  }else{
                      return response()->json([
                        'status' => false,
                        'message' => 'Old password is wrong',
                        // 'data' => $data,
                      ], 402);
                  }

            }else{
                 return response()->json([
                  'status' => false,
                  'message' => 'This Restaurant is not exist',
                ], 402);
            }
            

       }else{
          $output['message'] = '405';
       } 
       echo json_encode($output);
       die;   

    }

    public function forgotpassword(Request $request){

      $output=array();
      $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

               $validator = Validator::make(
                  $request->all(), 
                  [
                      'email' => 'required',
                  ]
                );

                if ($validator->fails()) {
                    return response()->json([
                      'status' => false,
                      'message' => $validator->errors()->first(),
                    ], 402);
                }

          
                $get_single_user = UserModel::where(['email' => $request->email])->first();
                if($get_single_user != ''){

                    $data = array();
                    $password = rand(100000,1000000);
                    $data['password'] = $password;
                    $data['restaurant_name'] = $get_single_user['restaurant_name'];

                    $Updatedata = array();
                    $Updatedata['password'] = sha1($password);
                    UserModel::where('id', $get_single_user['id'])->update($Updatedata);

                    $tomail = $get_single_user['email'];

                    Mail::to($tomail)->send(new NotifyMail($data));

                    // Mail::send('emails.demoMail', ['get_single_user'=>$get_single_user,'password' => $password], function ($message) use ($password) {
                    //     $message->from('test@gmail.com', 'Your Application');
                    //     $message->to('dev4.infosparkles@gmail.com', $password)->subject('Forgot Password');
                    // });

                    return response()->json([
                        'status' => true,
                        'message' => 'mail send successfully',
                        // 'data' => $data,
                    ], 402); 

                }else{
                    return response()->json([
                      'status' => false,
                      'message' => 'This email is not exist',
                    ], 402);
                }  
              
                    
       }else{
          $output['message'] = '405';
       } 
       echo json_encode($output);
       die;   

    }


    public function check_number(Request $request){

      $output=array();
      $output['status']=false;
       if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

               $validator = Validator::make(
                  $request->all(), 
                  [
                      'phone_no' => 'required',
                  ]
                );

                if ($validator->fails()) {
                    return response()->json([
                      'status' => false,
                      'message' => $validator->errors()->first(),
                    ], 402);
                }

          
                $get_single_user = UserModel::where(['phone_no' => $request->phone_no])->first();
                if($get_single_user != ''){                
                    if ($request->new_password) {
                        $data=array();
                        $data['password'] = sha1($request->new_password); 
                        UserModel::where('id', $get_single_user['id'])->update($data);

                        return response()->json([
                          'status' => true,
                          'message' => 'Password set successfully',
                        ], 402);
                     
                    }else{
                        return response()->json([
                          'status' => true,
                          'message' => 'Number exists',
                        ], 402);
                    }            
                }else{
                    return response()->json([
                      'status' => false,
                      'message' => 'This phone number is not exist',
                    ], 402);
                }  
              
       }else{
          $output['message'] = '405';
       } 
       echo json_encode($output);
       die;   

    }


}