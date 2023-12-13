<?php
namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Models\UserModel;
use App\Models\CountryModel;
use App\Models\CityModel;
use App\Models\StateModel;
use App\Models\TestimonialsModel;
use App\Models\TestimonialDescriptionModel;
use App\Models\LanguagesModel;
use App\Models\ContactModel;
use App\Models\User;
use App\Models\CustomersModel;


class ProviderController extends Controller{


    public function signup(Request $request){
        
        if($request->isMethod('post')){
            $req_fields = array(
                'firstname'         => 'required|max:25',
                'familyname'        => 'required|max:25',
                'phone_no'          => 'required',
                'email'             => 'required|email|unique:customers',
                'password'          => 'required',
                'confirm_password'  => 'required|same:password',
                'rules'             => 'required',
                'gdpr'              => 'required',
                'accept_term'       => 'required',
                'files'             => 'required',
            );

            $req_fields['company_name'] = "required";
            $req_fields['tax_number']   = "required";
            $req_fields['country']      = "required";
            $req_fields['street']       = "required";
            $req_fields['city']         = "required";
            $req_fields['zipcode']      = "required";
            // $req_fields['office_no']    = "required";
            $req_fields['state']        = "required";
        
            $errormsg = array(
                'firstname'         => 'FirstName',
                'familyname'        => 'FamilyName',
                'phone_no'          => 'Phone Number',
                'email'             => 'Email',
                'password'          => 'Password',
                'confirm_password'  => 'Confirm Password',
                'rules'             => 'Rules Services',
                'gdpr'              => 'GDPR Terms',
                'accept_term'       => 'Terms Information',
                'files'             => 'File',
                'company_name'      => 'Company Name',
                'tax_number'        => 'Tax number',
                'country'           => 'Country',
                'street'            => 'Street',
                'state'             => 'State',
                'city'              => 'City',
                'zipcode'           => 'Zipcode',
                // 'office_no'         => 'Office Number',
                
            );
            
            $validator = Validator::make(
                $request->all(),
                $req_fields,
                [
                    'required' => ':attribute '. __('customer.text_field_required'),
                    'unique'  => ':attribute '. __('customer.text_unique'),
                    'mimes'    => ':attribute'.__('customer.text_must_file').': :values.',
                ],
                $errormsg

            );
            
            if($validator->fails()) {
               return back()->withErrors($validator)->withInput();
            }

            $CustomersModel = new CustomersModel();
            $CustomersModel->firstname    = $request->firstname;
            $CustomersModel->familyname   = $request->familyname;
            $CustomersModel->phone_number = $request->phone_no;
            $CustomersModel->password     = Hash::make($request->password);
            $CustomersModel->email        = $request->email;
            $CustomersModel->role         = "provider";
            
            $CustomersModel->company_name = $request->company_name;
            $CustomersModel->tax_number   = $request->tax_number;
            $CustomersModel->street       = $request->street;
            $CustomersModel->country      = $request->country;
            $CustomersModel->state        = $request->state;
            $CustomersModel->city         = $request->city;
            $CustomersModel->zip_code     = $request->zipcode;
            // $CustomersModel->office_no    = $request->office_no;
            

            if($request->hasFile('files')) {
                $random_no  = uniqid();
                $img = $request->file('files');
                $ext = $img->getClientOriginalExtension();
                $new_name = $random_no . '.' . $ext;
                $destinationPath =  public_path('uploads');
                $img->move($destinationPath, $new_name);
                $CustomersModel->file = $new_name;
            }

            $otp                             =  rand(100000,999999);
            // $otp                 =  123456;
            $CustomersModel->otp             = $otp;
            $expiry_time_str                 = strtotime("+1 minutes", strtotime(date('Y-m-d H:i:s')));
            $CustomersModel->otp_expiry_time = date('Y-m-d H:i:s',$expiry_time_str);
            $CustomersModel->save();

            $request->session()->put('temp_session_id', $CustomersModel->id);

            $data['otp']  = $otp;
            $email        = $request->email;

            $sent = Mail::send('emails.registraion_otp', $data, function($message) use ($email) {
                $message->to($email)->subject('Your Otp');
            });
            return back()->withErrors(['provider_otp_modal'=>  __('customer.text_registration_success')]); 
        }
        $CountryModel = CountryModel::get();
        return view('front.signup',compact('CountryModel'));
    }




    ///Seeker And Provider Registraion
    public function match_otp(Request $request){
        if(session('temp_session_id')){
            $last_temp_id = session('temp_session_id');
        }

        $response = array();
        $CustomersModel = CustomersModel::where('id',$last_temp_id)->first();
        if($CustomersModel){
            if($request->otp == $CustomersModel->otp){
                $current_time = date('Y-m-d H:i:s');
                if(strtotime($CustomersModel->otp_expiry_time) >= strtotime($current_time)){
                    $UpdateData = array();
                    $UpdateData['otp'] = Null;
                    $UpdateData['is_verify'] = "1";
                    CustomersModel::where(['id' => $last_temp_id])->update($UpdateData);
                    $response['status']  = "success";
                    $response['message'] = __('customer.text_otp_verify');
                }else{
                    $response['status'] = "error";
                    $response['message'] = __('customer.text_otp_expired');
                }
            }else{
                $response['status'] = "error";
                $response['message'] = __('customer.text_otp_wrong');
            }
        }else{
            $response['status']  = "error";
            $response['message'] = __('customer.text_user_not_found');
        }
        return json_encode($response);
    }

    public function resend_otp(Request $request){
        if(session('temp_session_id')){
            $last_temp_id = session('temp_session_id');
        }

        $response = array();
        $response['status'] = "error";
        $get_temp_customer = CustomersModel::where('id',$last_temp_id)->first();
        if($get_temp_customer){
            $otp =  rand(100000,999999);
            // $otp                 =  123456;
            $expiry_time_str           = strtotime("+2 minutes", strtotime(date('Y-m-d H:i:s')));
            $UpdateData = array();
            $UpdateData['otp']             = $otp;
            $UpdateData['otp_expiry_time'] = date('Y-m-d H:i:s',$expiry_time_str);;
            $UpdateData['is_verify']       = "0";
            CustomersModel::where(['id' => $last_temp_id])->update($UpdateData);
            $data['otp'] = $otp;
            $email = $get_temp_customer->email;
            $sent = Mail::send('emails.registraion_otp', $data, function($message) use ($email) {
                $message->to($email)->subject('Your Otp');
            });
            $response['status'] = "success";
        }
        return json_encode($response);

    }

}



