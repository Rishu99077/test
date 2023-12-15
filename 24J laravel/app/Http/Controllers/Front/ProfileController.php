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
use App\Models\UserDescription;
use App\Models\RequestModel;
use App\Models\Favourites;

use Image;


class ProfileController
{

    public function my_profile(Request $request){
        $common = array();
        $common['title'] = 'My Profile';
        $common['heading_title'] = 'My Profile';

        $user_id = Session::get('em_user_id');

        $get_all_user        = [];
        $user                = [];
        $get_user_desc       = [];
        $get_favourites_user = [];

        $get_all_user = Users::where('id','!=',$user_id)->get();
        $get_favourites_user = Favourites::where(['user_id'=>$user_id])->first();
        
        $user = Users::where('id',$user_id)->first();
        if ($user) {
            $get_user_desc = UserDescription::where('user_id',$user['id'])->get();
        }

        if ($request->isMethod('post')) {

            $req_filed                  =   array();
            $req_filed['first_name']    =   "required";
            $req_filed['last_name']     =   "required";


            $validation = Validator::make($request->all(), $req_filed);

            if ($validation->fails()) {
                return back()->withErrors($validation)->withInput();
            }

            $Users = Users::find($request->id);
            $Users->prefix            = $request->prefix;
            $Users->first_name        = $request->first_name;
            $Users->last_name         = $request->last_name;
            $Users->email             = $request->email;
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
            $Users->facebook          = $request->facebook;
            $Users->twitter           = $request->twitter;
            $Users->linkedin          = $request->linkedin;
            $Users->instagram         = $request->instagram;
            $Users->status            = $request->status;
            $Users->save();

            if ($request->company != "") {
                UserDescription::where('User_id', $request->id)->delete();
                foreach ($request->company as $key => $value) {
                    $UserDescription = new UserDescription();
                    if ($value != '') {
                        $UserDescription->User_id         = $request->id;
                        $UserDescription->company         = $value;
                        $UserDescription->location        = $request->location[$key];
                        $UserDescription->services        = $request->services[$key];
                        $UserDescription->role            = $request->role[$key];
                        $UserDescription->company_contact = $request->company_contact[$key];
                        $UserDescription->company_email   = $request->company_email[$key];
                        $UserDescription->linkedin_url    = $request->linkedin_url[$key];
                        $UserDescription->facebook_url    = $request->facebook_url[$key];
                        $UserDescription->twitter_url     = $request->twitter_url[$key];
                        $UserDescription->instagram_url   = $request->instagram_url[$key];


                        $UserDescription->save();
                    }
                }
            }
            return redirect(route('my_profile'))->withErrors(['success' => "Profile Update Successfully"]);
        }

        return view('front.profile.my_profile', compact('common','user','get_user_desc','get_all_user','get_favourites_user'));
    }


    public function save_favourites(Request $request){

        if ($request) {
            Favourites::where('user_id', $request->ID)->delete();

            $Favourites = new Favourites;
            $Favourites->user_id            = $request->ID;
            $Favourites->favourite_user_id  = implode(',', $request->fav_users);
            $Favourites->status             = 'Active';
            
            $Favourites->save();
        }  
    }


    public function my_friends(Request $request){

        $common = array();
        $common['title'] = 'Friends';
        $common['heading_title'] = 'Friends';

        $user_id = Session::get('em_user_id');

        $query = RequestModel::whereNull('is_delete')->where('status','Accept');
        $query->where(function ($query) use ($user_id) {
            $query->orWhere('user_id',$user_id);
            $query->orWhere('to_user_id',$user_id);
        });    
        $query->orderBy('id', 'DESC');
        $get_accept_reqest = $query->get();

        $data = array();
        foreach ($get_accept_reqest as $key => $value) {

            if ($user_id==$value->user_id) {
                $customer = Users::where(['id' => $value->to_user_id])->whereNull('is_delete')->first();
                $get_usersdata_data = array();
                $get_usersdata_data['request_id']       = $value['id'];
                $get_usersdata_data['user_id']          = $customer['id'];
                $get_usersdata_data['full_name']        = $customer['first_name'].' '.$customer['last_name'];
                $get_usersdata_data['email']            = $customer['email'];
                $get_usersdata_data['designation']      = $customer['designation'];
                $get_usersdata_data['address']          = $customer['address'];
                $get_usersdata_data['company_name']     = $customer['company_name'];
                $get_usersdata_data['phone_number']     = $customer['contact'];
                $get_usersdata_data['request_status']   = $value['status'];
                $get_usersdata_data['image']            = $customer['image'] != '' ? url('uploads/users', $customer['image']) : asset('frontassets/image/placeholder.jpg');
            }else{
                $customer = Users::where(['id' => $value->user_id])->whereNull('is_delete')->first();
                $get_usersdata_data = array();
                $get_usersdata_data['request_id']       = $value['id'];
                $get_usersdata_data['user_id']          = $customer['id'];
                $get_usersdata_data['full_name']        = $customer['first_name'].' '.$customer['last_name'];
                $get_usersdata_data['email']            = $customer['email'];
                $get_usersdata_data['designation']      = $customer['designation'];
                $get_usersdata_data['address']          = $customer['address'];
                $get_usersdata_data['company_name']     = $customer['company_name'];
                $get_usersdata_data['phone_number']     = $customer['contact'];
                $get_usersdata_data['request_status']   = $value['status'];
                $get_usersdata_data['image']            = $customer['image'] != '' ? url('uploads/users', $customer['image']) : asset('frontassets/image/placeholder.jpg');
            }

            if ($get_usersdata_data) {
                $data[] = $get_usersdata_data;
            }
        }


        return view('front.profile.my_friends', compact('common','data'));
    }

}

?>