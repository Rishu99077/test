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


class SettingController extends Controller{


   public function index(){
    $common                  = array();
    $common['main_menu']     = 'settings';
    $common['heading_title'] = __('customer.text_setting');
    $cust_id                 = Session::get('cust_id');
    $user                    = CustomersModel::where(['id' => $cust_id])->first();

    return view('front.settings.setting',compact('common','user'));
   } 

   

   public function update_settings(Request $request){
    $cust_id     = Session::get('cust_id');
    $User        = CustomersModel::where(['id' => $cust_id])->first();
    
    $User->is_online           = "offline";
    $User->is_online           = "no";
    $User->is_delete           = "Off";
    $User->notification_status = "Off";
    if($request->notification){
        $User->notification_status = $request->notification;
    }

    if($request->account_privacy){
        $User->is_online = $request->account_privacy;
    }

    if($request->account_pause){
        $User->is_pause  = $request->account_pause;
    }

    if($request->delete_account){
        $User->is_delete  = $request->delete_account;
    }

    $User->update();


    if($request->delete_account){
        if($request->delete_account == "On"){
            $request->session()->flush();
            return redirect('/login')->withErrors(['error' => __('customer.text_acc_deleted')]);
        }
    }

    return back()->withErrors(['success'=> __('customer.text_update_success')]);

   }
}



