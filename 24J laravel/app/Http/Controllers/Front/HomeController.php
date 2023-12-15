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
use App\Models\RequestModel;
use App\Models\Staff;

use Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use JeroenDesloovere\VCard\VCard;
use Illuminate\Support\Facades\Crypt;

class HomeController
{
    public function index(Request $request){
        $common = array();
        $common['title'] = 'Home';
        $common['heading_title'] = 'Home';

        $user_id = Session::get('em_user_id');

        $Search = @$_GET['Search'];
       
        $get_users = [];
        $query = Users::where('id','!=',$user_id);

        if ($Search!='') {
            $query = $query->where('first_name','LIKE','%'.$Search.'%');
            $query = $query->orwhere('last_name','LIKE','%'.$Search.'%');
            $query = $query->orwhere('email',$Search);
            $query = $query->orwhere('company_name','LIKE','%'.$Search.'%');
            $query = $query->orwhere('designation','LIKE','%'.$Search.'%');
            $query = $query->orwhere('contact','LIKE','%'.$Search.'%');
        }

        $get_users_details = $query->orderBy('id','desc')->paginate(80);

        if (!$get_users_details->isEmpty()) {
            foreach ($get_users_details as $key => $value) {
                $row = array();
                $row['id']            = $value['id'];
                $row['user_id']       = $value['user_id'];
                $row['prefix']        = $value['prefix'];
                $row['first_name']    = $value['first_name'];
                $row['last_name']     = $value['last_name'];
                $row['email']         = $value['email'];
                $row['company_name']  = $value['company_name'];
                $row['designation']   = $value['designation'];
                $row['contact']       = $value['contact'];
                $row['address']       = $value['address'];
                $row['country']       = $value['country'];
                $row['country_name']  = $value['country_name'];
                $row['town']          = $value['town'];
                $row['image']         = $value['image'];
                $row['avatar_file']   = $value['avatar_file'];
                $row['status']        = $value['status'];

                $row['request_status'] = '';

                $to_user_id = $value['id'];

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
                $get_users[] = $row;
            }
        }

/*        echo "<pre>"; 
  print_r($get_users);
  echo "</pre>";die();*/


        return view('front.home', compact('common','get_users','user_id','get_users_details'));

    }

    public function my_request(Request $request){
        $common = array();
        $common['title'] = 'My Request';
        $common['heading_title'] = 'My Request';

        $user_id = Session::get('em_user_id');

        $query = RequestModel::whereNull('is_delete');
        $query->where(function ($query) use ($user_id) {
            // $query->orWhere('user_id',$user_id);
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
                $get_usersdata_data['user_id']      = $customer['id'];
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
                $get_usersdata_data['user_id']      = $customer['id'];
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

        return view('front.my_request', compact('common','data'));
    }


    public function send_request(Request $request){
        
        $Pending_request = RequestModel::whereNull('is_delete')
                                        ->where('status','Pending')
                                        ->where(['user_id' => $request->to_user_id,'to_user_id' => $request->user_id])->first();

        if ($Pending_request){
            $Pending_request->status   = 'Accept';
            $Pending_request->save();
        }else{
            $get_request = RequestModel::whereNull('is_delete')->where(['user_id' => $request->user_id,'to_user_id' => $request->to_user_id])->first();
            if ($get_request) {
               
            }else{
                $RequestModel = new RequestModel();
                $RequestModel->user_id          = $request->user_id;
                $RequestModel->customer_status      = 'Send';
                $RequestModel->to_user_id       = $request->to_user_id;
                $RequestModel->status   = 'Pending';
                $RequestModel->str_time   = time();
                $RequestModel->save();
            }
        }

    }

    public function change_request_status(Request $request){
        $get_request = RequestModel::where('id',$request->request_id)->first();  
        if ($get_request) {
            if ($request->status=='Reject') {
                $data_update = array();
                $data_update['status']    = $request->status;
                $data_update['is_delete'] = 1;
            }else{
                $data_update = array();
                $data_update['status'] = $request->status;
            }
            RequestModel::where('id',$request->request_id)->update($data_update);
        }  
    }


    public function staff($id=''){

        $staff_id =  Crypt::decrypt($id);
        $get_staff = Users::where(['id' => $staff_id])->first();
        if($get_staff){
            $get_staff->view_count = $get_staff->view_count + 1;
            $get_staff->save();
            return view('front.index',compact('get_staff'));
        }else{
            return redirect()->route('front.no_found');
        }

    }

    public function downoad_vcard($id=''){

        $staff_id =  Crypt::decrypt($id);
        $get_staff = Users::where(['id' => $staff_id])->first();
        if($get_staff){

            $get_staff->download_count = $get_staff->download_count + 1;
            $get_staff->save();

            // define vcard
            $vcard = new VCard();
            $lastname = $get_staff->first_name;
            $firstname = $get_staff->first_name;
            $additional = '';
            $prefix = '';
            $suffix = '';
            
            // add personal data
            $vcard->addName($firstname, $lastname, $additional, $prefix, $suffix);
            
            if(isset($get_staff->avatar_file)){
                if($get_staff->avatar_file !=''){
                    $vcard->addPhoto(asset('uploads/staff/'.$get_staff->avatar_file));
                }
            }


            if($get_staff->email){
                $email_arr = explode(",",$get_staff->email);
                foreach ($email_arr as $email_val) {
                    $vcard->addEmail($email_val, 'Email');
                }
            }

            if($get_staff->contact){
                $contact_arr = explode(",",$get_staff->contact);
                foreach ($contact_arr as $contact_val) {
                    $vcard->addPhoneNumber($contact_val, 'Contact');
                }
            }

            if($get_staff->address){
                $vcard->addAddress($get_staff->address, 'Address');
            }

            $vcard->addCompany($get_staff->company_name);
            $vcard->addJobtitle($get_staff->designation);
            return $vcard->download();
        }else{
            return redirect()->route('front.no_found');
        }
    }

    public function no_found(){
        return view('front.no_found');
    }

}