<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Users;
use App\Models\UserDescription;

use App\Models\RequestModel;
use App\Models\ContactUs;

use App\Models\Country;
use App\Models\SliderImages;

use App\Models\Plans;
use App\Models\PlanFeature;


use Mail;
use Illuminate\Support\Facades\Hash;
use Image;
use Illuminate\Support\Str;

class HomeController extends Controller
{

    public function index(Request $request){
    
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validation = Validator::make($request->all(), [
              'user_id'       => 'required',
            ]);

            if ($validation->fails()) {
              $output['message'] = $validation->errors()->first();
              return response()->json($output); die;
            }

            $users = [];
            $get_users = Users::where('id','!=',$request->user_id)->get();
            if (!$get_users->isEmpty()) {
                foreach ($get_users as $key => $value) {
                    $row = array();
                    $row['id']               = $value->id;
                    $row['full_name']        = $value->first_name;
                    $row['email']            = $value->email;
                    $row['contact']          = $value->contact;
                    $row['company_name']     = $value->company_name;
                    $row['image']            = $value['image']  != '' ? asset('uploads/users/' . $value['image']) : asset('/frontassets/image/placeholder.jpg');


                    $row['request_status'] = '';

                    $user_id    = $request->user_id;
                    $to_user_id = $value->id;

                    $query = RequestModel::whereNull('is_delete');
                    $query->where(function ($query) use ($user_id) {
                        $query->orWhere('user_id',$user_id);
                        $query->orWhere('to_user_id',$user_id);
                    });    
                    $query->where(function ($query) use ($to_user_id) {
                        $query->orWhere('user_id',$to_user_id);
                        $query->orWhere('to_user_id',$to_user_id);
                    });    
                    $get_request = $query->first();


                    if ($get_request) {
                        $row['request_status'] = $get_request['status'];
                    }

                    $users[] = $row;
                }
            }

            $slider_data = [];
            $get_slider_details = SliderImages::where(['status'=>'Active'])->get();

            if (!$get_slider_details->isEmpty()) {
                foreach ($get_slider_details as $key => $value) {
                    $row = array();
                    $row['id']            = $value['id'];
                    $row['title']         = $value['title'];
                    $row['image']         = $value['image'] != '' ? url('uploads/slider_images', $value['image']) : asset('frontassets/image/placeholder.jpg');

                    $slider_data[] = $row;
                }
            }
        
            $output['status']   = true;
            $output['data']     = $users;
            $output['slider']   = $slider_data;
            $output['message']  = 'Users list';
        }else{
            $output['message'] = '405';
        }
        return response()->json($output); die;
    }

    public function contact_us(Request $request){
    
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validation = Validator::make($request->all(), [
              'full_name'       => 'required',
              'email'           => 'email|required',
              'phone_number'    => 'required',
              'message'         => 'required',
            ]);

            if ($validation->fails()) {
              $output['message'] = $validation->errors()->first();
              return response()->json($output); die;
            }

            
            $ContactUs = new ContactUs();
            $ContactUs->full_name        = $request->full_name;
            $ContactUs->email            = $request->email;
            $ContactUs->phone_number     = $request->phone_number;
            $ContactUs->message          = $request->message;

            $ContactUs->save();


            // MAIL NOTIFICATION
            $data = array();
            $data['name']      = $ContactUs->full_name;   
            $data['email']     = $ContactUs->email;
            $data['message']   = $ContactUs->message;

            $data['subject']     = 'Contact us on 24JE Cards ';
            $data['description'] = 'Contact us on 24JE Cards ';
            //echo "string"; die;
            Mail::send('email.contact', $data, function ($message) use ($data) {
                $message->to($data['email'], $data['name'])
                    ->subject($data['subject']);
            });

        
            $output['status']      = true;
            $output['message']     = 'Mail send Successfully';
        }else{
            $output['message'] = '405';
        }
        return response()->json($output); die;
    }

    public function users_list(Request $request){

        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $user_data = [];
            $get_user = Users::all();

            if (!$get_user->isEmpty()) {
                foreach ($get_user as $key => $value) {
                    $row = array();
                    $row['id']            = $value['id'];
                    $row['name']          = $value['first_name'].' '.$value['last_name'];
                    $row['email']         = $value['email'];
                    $row['company_name']  = $value['company_name'];
                    $row['image']         = $value['image'] != '' ? url('uploads/users', $value['image']) : asset('frontassets/image/placeholder.jpg');

                    $user_data[] = $row;
                }

                $output['status']   = true;
                $output['data']     = $user_data;
                $output['message']  = 'Users list';
            }else{
                $output['message']  = 'Something went wrong';
            }
        }else{
            $output['message'] = '405';
        }
        return response()->json($output); die;   
    }

    public function users_details(Request $request){
        $output=array();
        $output['status']=false;

        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validation = Validator::make($request->all(), [
              'user_id'     => 'required',
            ]);

            if ($validation->fails()) {
              $output['message'] = $validation->errors()->first();
              return response()->json($output); die;
            }

            $customer = Users::where(['id' => $request->user_id])->first();

            if ($customer) {
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

                if ($customer['contact']) { $data['phone_number']       = $customer['contact']; }
                if ($customer['company_name']) { $data['company_name']  = $customer['company_name']; }
                if ($customer['address']) { $data['address']            = $customer['address']; }
                if ($customer['designation']) { $data['designation']    = $customer['designation']; }
                if ($customer['country_name']) { $data['country_name']  = $customer['country_name']; }
                if ($customer['town']) { $data['town']                  = $customer['town']; }


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
                $output['message'] = 'User Deatils';
                
            } else {
                $output['message'] = '401';
            }

        }else{
            $output['message'] = '405';
        }
        return response()->json($output); die;
    }


    public function countries(Request $request){

        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $country_data = [];
            $get_country = Country::all();

            if (!$get_country->isEmpty()) {
                foreach ($get_country as $key => $value) {
                    $row = array();
                    $row['id']            = $value['id'];
                    $row['sortname']      = $value['sortname'];
                    $row['name']          = $value['name'];
                    $row['phonecode']     = $value['phonecode'];

                    $country_data[] = $row;
                }

                $output['status']   = true;
                $output['data']     = $country_data;
                $output['message']  = 'Country list';
            }else{
                $output['message']  = 'Something went wrong';
            }
        }else{
            $output['message'] = '405';
        }
        return response()->json($output); die;   
    }


    // Subscription Plan
    public function subscription_plan(Request $request){

        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $plan_data = [];
            $get_plans = Plans::where(['status'=>'Active'])->get();

            if (!$get_plans->isEmpty()) {
                foreach ($get_plans as $key => $value) {
                    $row = array();
                    $row['id']            = $value['id'];
                    $row['title']         = isset($value['title']) ?  $value['title'] : '';
                    $row['description']   = isset($value['description']) ?  $value['description'] : '';
                    $row['price']         = isset($value['price']) ?  $value['price'] : '';
                    $row['duration']      = isset($value['duration']) ?  $value['duration'] : '';
                    $row['image']         = $value['image'] != '' ? url('uploads/plan_images', $value['image']) : asset('frontassets/image/placeholder.jpg');

                    $get_plan_features = PlanFeature::where('plan_id',$value['id'])->get();
                    if (!$get_plan_features->isEmpty()) {
                        $row['features']   = array();
                        foreach ($get_plan_features as $fea_key => $fea_value) {
                            $feat = array();
                            $feat['id']            = $fea_value['id'];
                            $feat['plan_id']       = $fea_value['plan_id'];
                            $feat['feature_title'] = isset($fea_value['feature_title']) ?  $fea_value['feature_title'] : '';
                            $row['features'][]  = $feat;
                        }
                    }

                    $plan_data[] = $row;
                }

                $output['status']   = true;
                $output['data']     = $plan_data;
                $output['message']  = 'Subscription plan';
            }else{
                $output['message']  = 'Something went wrong';
            }
        }else{
            $output['message'] = '405';
        }
        return response()->json($output); die;   
    }

}