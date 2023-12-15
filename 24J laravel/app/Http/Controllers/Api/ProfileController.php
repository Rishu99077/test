<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Users;
use App\Models\UserDescription;

use Mail;
use Image;
use Illuminate\Support\Str;

class ProfileController extends Controller
{

    public function profile(Request $request){
        $output=array();
        $output['status']=false;

        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validation = Validator::make($request->all(), [
              'user_id'     => 'required',
              'password'    => 'required',
            ]);

            if ($validation->fails()) {
              $output['message'] = $validation->errors()->first();
              return response()->json($output); die;
            }

            $customer = Users::where(['id' => $request->user_id])->first();

            if ($customer) {
                if ($request->password==$customer->password) {
                    $data = array();
                    $data['full_name']           = $customer['first_name'].' '.$customer['last_name'];
                    $data['email']               = $customer['email'];
                    $data['image']               = $customer['image']  != '' ? asset('uploads/users/' . $customer['image']) : asset('/frontassets/image/placeholder.jpg');

                    $data['phone_number']        = '';
                    $data['company_name']        = '';
                    $data['address']             = '';
                    $data['designation']         = '';
                    $data['country_name']        = '';
                    $data['town']                = '';
                    $data['create_group']        = '';

                    if ($customer['contact']) { $data['phone_number']       = $customer['contact']; }
                    if ($customer['company_name']) { $data['company_name']  = $customer['company_name']; }
                    if ($customer['address']) { $data['address']            = $customer['address']; }
                    if ($customer['designation']) { $data['designation']    = $customer['designation']; }
                    if ($customer['country_name']) { $data['country_name']  = $customer['country_name']; }
                    if ($customer['town']) { $data['town']                  = $customer['town']; }
                    if ($customer['create_group']) { $data['create_group']  = $customer['create_group']; }


                    $data['bussiness_details'] = [];
                    $get_user_desc = UserDescription::where(['User_id'=>$request->user_id])->get();
                    if (!$get_user_desc->isEmpty()) {
                        foreach ($get_user_desc as $key => $value) {
                            $row = array();
                            $row['company'] = $value['company'];
                            $row['location'] = $value['location'];
                            $row['services'] = $value['services'];
                            $row['role'] = $value['role'];
                            $row['company_contact'] = $value['company_contact'];
                            $row['company_email'] = $value['company_email'];
                            $row['linkedin_url']  = $value['linkedin_url'];
                            $row['facebook_url']  = $value['facebook_url'];
                            $row['twitter_url']   = $value['twitter_url'];
                            $row['instagram_url'] = $value['instagram_url'];

                            $data['bussiness_details'][] = $row;
                        }
                    }

                    $output['status']  = true;
                    $output['data']    = $data;
                    $output['message'] = 'User profile';
                } else {
                    $output['message'] = '401';
                }
            } else {
                $output['message'] = '401';
            }

        }else{
            $output['message'] = '405';
        }
        return response()->json($output); die;
    }

    public function profile_update(Request $request){
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validation = Validator::make($request->all(), [
              'user_id'       => 'required',
              'password'      => 'required',
              'full_name'     => 'required',
            ]);

            if ($validation->fails()) {
              $output['message'] = $validation->errors()->first();
              return response()->json($output); die;
            }
        
            $customer = Users::where(['id' => $request->user_id])->first();
           
            if($customer){
                if ($request->password==$customer->password) {
                    $data = array();
                    $data['id']             = $customer['id'];
                    $data['first_name']     = $request->full_name;
                    if ($request->company_name) {
                        $data['company_name']   = $request->company_name;
                    }

                    if ($request->hasFile('image')) {
                        $random_no = Str::random(5);
                        $img = $request->file('image');
                        $ext = $img->getClientOriginalExtension();
                        $new_name = time() . $random_no . '.' . $ext;
                        $destinationPath = public_path('uploads/users/');
                        $img->move($destinationPath, $new_name);
                        $data['image'] = $new_name;
                    }
                    
                    
                    Users::where('id', $customer['id'])->update($data);

                    $output['status']  = true;
                    $output['data']    = $data;
                    $output['message'] = 'Profile Update succesfully';
                }else {
                    $output['message'] = '401';
                }
            }else{
                $output['message'] = '401';
            }
        }else{
            $output['message'] = '405';
        }
        return response()->json($output); die;
    }

    public function change_password(Request $request){
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){
            $validation = Validator::make($request->all(), [
              'user_id'              => 'required',
              'current_password'     => 'required',
              'new_password'         => 'required|min:6',
              'confirm_password'     => 'required|same:new_password|min:6',
            ]);

            if ($validation->fails()) {
              $output['message'] = $validation->errors()->first();
              return response()->json($output); die;
            }
            $customer = Users::where(['id' => $request->user_id])->first();

            if ($customer) {          
                if (Hash::check($request->current_password, $customer->password)) { 
                    $data = array();
                    $output['status'] = true;
                    if ($request->new_password) {
                        $data['password']    = Hash::make($request->new_password);                   
                    }
                    Users::where('id', $customer['id'])->update($data); 

                    $customer = Users::where(['id' => $request->user_id])->first();

                    $output['status']    = true;
                    $output['password']  = $customer->password;
                    $output['message']   = 'Password updated succesfully';
                }else{
                    $output['message']   = 'Current Password does not match';
                }  
            } else {
                $output['message'] = '401';
            }
        }else{
            $output['message'] = '405';
        }
        return response()->json($output); die;
    }
    
}