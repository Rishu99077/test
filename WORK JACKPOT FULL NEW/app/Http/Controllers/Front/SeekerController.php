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


class SeekerController extends Controller{


    public function signup(Request $request){
        if($request->isMethod('post')){
            $req_fields = array(
                'firstname'         => 'required|max:25',
                'familyname'        => 'required|max:25',
                'nickname'          => 'required|max:25',
                'country'           => 'required',
                'state'             => 'required',
                'city'              => 'required',
                'street'            => 'required',
                'zipcode'           => 'required',
                'house_no'          => 'required',
                'phone_no'          => 'required',
                'email'             => 'required|email|unique:customers',
                'password'          => 'required',
                'confirm_password'  => 'required|same:password',
                'files'             => 'required',
                'rules'             => 'required',
                'gdpr'              => 'required',
                'accept_term'       => 'required',
            );

            $errormsg = array(
                'firstname'         => 'FirstName',
                'familyname'        => 'FamilyName',
                'nickname'          => 'NickName',
                'country'           => 'Country',
                'state'             => 'State',
                'city'              => 'City',
                'street'            => 'Street',
                'zipcode'           => 'Zipcode',
                'house_no'          => 'House Number',
                'phone_no'          => 'Phone Number',
                'email'             => 'Email',
                'password'          => 'Password',
                'confirm_password'  => 'Confirm Password',
                'files'             => 'File',
                'rules'             => 'Rules Services',
                'gdpr'              => 'GDPR Terms',
                'accept_term'       => 'Terms Information',
                
            );


            
            $validator = Validator::make(
                $request->all(),
                $req_fields,
                [
                    'required'  => __('customer.text_field_required').' :attribute',
                    'unique'    => ':attribute'. __('customer.text_unique'),
                    'mimes'     => ':attribute'. __('customer.text_must_file').': :values.',
                ],
                $errormsg,
            );
            
            if($validator->fails()) {
               return back()->withErrors($validator)->withInput();
            }

            $CustomersModel = new CustomersModel();
            $CustomersModel->role         = "seeker";
            $CustomersModel->firstname    = $request->firstname;
            $CustomersModel->familyname   = $request->familyname;
            $CustomersModel->nick_name    = $request->nickname;
            $CustomersModel->country      = $request->country;
            $CustomersModel->state        = $request->state;
            $CustomersModel->city         = $request->city;
            $CustomersModel->street       = $request->street;
            $CustomersModel->zip_code     = $request->zipcode;
            $CustomersModel->house_no     = $request->house_no;
            $CustomersModel->phone_number = $request->phone_no;
            $CustomersModel->email        = $request->email;
            $CustomersModel->password     = Hash::make($request->password);

            if($request->hasFile('files')) {
                $random_no  = uniqid();
                $img = $request->file('files');
                $ext = $img->getClientOriginalExtension();
                $new_name = $random_no . '.' . $ext;
                $destinationPath =  public_path('uploads');
                $img->move($destinationPath, $new_name);
                $CustomersModel->file = $new_name;
                
            }
            
            $otp                 =  rand(100000,999999);
            // $otp                 =  123456;
            $CustomersModel->otp = $otp;
            $expiry_time_str                 = strtotime("+8 minutes", strtotime(date('Y-m-d H:i:s')));
            $CustomersModel->otp_expiry_time = date('Y-m-d H:i:s',$expiry_time_str);
            $CustomersModel->update();
            $CustomersModel->save();

            $request->session()->put('temp_session_id', $CustomersModel->id);

            $data['otp'] = $otp;
            $email = $request->email;

            $sent = Mail::send('emails.registraion_otp', $data, function($message) use ($email) {
                $message->to($email)->subject('Your Otp');
            });
            return back()->withErrors(['seeker_otp_modal'=> __('customer.text_registration_success')]); 
        }
        $CountryModel = CountryModel::get();
        return view('front.seeker_signup',compact('CountryModel'));
    }

    
}



