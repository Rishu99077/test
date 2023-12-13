<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Models\UserModel;
use App\Models\LanguagesModel;
use App\Models\ContactUsModel;
use App\Models\CustomersModel;
use App\Models\CountryModel;
use App\Models\CityModel;
use App\Models\StateModel;
use App\Models\FavouriteCustomerModel;
use App\Models\NotificationsModel;
use App\Models\ContractsModel;
use App\Models\ChatModel;
use App\Models\JobsModel;


class ContactController extends Controller{

    public function index(Request $request){

        $common                  = array();
        $to_user                 = array();
        $common['main_menu']     = 'Contact us';
        $common['heading_title'] = __('customer.text_contact_us');
        
      	$cust_id = Session::get('cust_id');
      	$user    = CustomersModel::where(['id' => $cust_id])->first();

        $Get_Customer = array();   
        $UserModel    = UserModel::first();
        $Get_Customer['chat_customer_id'] = $UserModel['id'];
        $Get_Customer['profile_image']    = $UserModel['profile_image'];
        $customer_id_to    = "Admin";
        $customer_id_from  = $cust_id;
        $Get_Customer['fullname']    =   $UserModel['first_name']." ".$UserModel['last_name'];


        $chats = array();
        $user_detail         = UserModel::where(['id' => 1])->first();
        $to_user['fullname'] = $user_detail['first_name']." ".$user_detail['last_name'];
        $to_user['id']       = "Admin";
        $customer_id_to      = "Admin";
        $customer_id_from    = $cust_id;
        $ChatModel           = ChatModel::where(function ($query) use ($customer_id_to,$customer_id_from) {
                                    $query->orWhere('customer_id_to', '=', $customer_id_to)
                                          ->where('customer_id_from', '=', $customer_id_from);
                                })->orWhere(function ($query) use ($customer_id_to,$customer_id_from) {
                                    $query->where('customer_id_to', '=', $customer_id_from)
                                          ->where('customer_id_from', '=', $customer_id_to);
                                })->orderBy('id','asc')->get();

        foreach($ChatModel as $kye => $value){
            $chat_user  = array();
            if($value['customer_id_to']==$cust_id){
                $chat_user['position'] = 'left';
            }else{
                $chat_user['position'] = 'right';
            }
            if($value['customer_id_from'] == "Admin"){
              $CustomersModel_chat   = UserModel::where(['id' => 1])->first();
            }else{
              $CustomersModel_chat   = CustomersModel::where(['id' => $value['customer_id_from']])->first();
            }

            $chat_user['customer_id']      = $CustomersModel_chat['id'];
            $chat_user['customer_image']   = $CustomersModel_chat['profile_image'];     
            
            $chat_user['message']    = $value['message']; 
            $chat_user['date'] = date("d-m-Y",strtotime($value['created_at'])); 
            $chat_user['time'] = date("h:i A",strtotime($value['created_at'])); 
            $chats[] = $chat_user;
        }




        return view('front.contact',compact('user','common','Get_Customer','chats','to_user'));
    }


    public function save_contact_us(Request $request){

        $cust_id = Session::get('cust_id');
        $user_detail    = CustomersModel::where(['id' => $cust_id])->first();
 
        

        $validator = Validator::make($request->all(), [
            'topic'     => 'required',
            'email'     => 'required',
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        $Data = array();
        $Data['topic']   = $data['topic'];
        $Data['email']   = $data['email'];
        $Data['message'] = $data['message'];
        $Data['customer_id'] = $cust_id;

        $provider_mail = 'test@gmail.com';
        if ($request->rules) {
            $provider_mail = $user_detail['email'];
        }

        if ($request->file('files')) {
            $random_no  = uniqid();
            $img = $data['files'];
            $ext = $img->getClientOriginalExtension();
            $new_name = $random_no . '.' . $ext;
            if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg') {
                $destinationPath  =  public_path('/Images/Contacts');
                $img->move($destinationPath, $new_name);
                $Data['files'] = $new_name;
            }
        }

        $insert_id = ContactUsModel::create($Data);
        $Contact_us_detail = ContactUsModel::where(['id' => $insert_id['id']])->first();
        if (!empty($Contact_us_detail)) {
           
            $topic            = $Contact_us_detail['topic'];
            $email            = $Contact_us_detail['email'];
            $message_content  = $Contact_us_detail['message'];
            $message_files    = $Contact_us_detail['files'];

            $mails = array();
            $mails = [$Contact_us_detail['email'],$provider_mail];

            $data = array('email'=>$email,'user_id'=>$cust_id,'topic'=>$topic,'message_content'=>$message_content,'message_files'=> $message_files );
           
            $sent = Mail::send('emails.contact_us', $data, function($message) use ($mails) {
                $message->to($mails)->subject('Contact Us');
            });
        }

        return redirect('contact-us')->withErrors(['success'=> __('customer.text_contact_detail').' '. __('customer.text_send_success')]);    
        
    }

    public function notification(Request $request){

        $common = array();
        $get_notification = array();
        $common['main_menu'] = 'Notifications';
        $common['heading_title'] = __('customer.text_notification');
        
        $cust_id = Session::get('cust_id');
        $user = CustomersModel::where(['id' => $cust_id])->first();
        
        $get_notification = NotificationsModel::where(['cust_id' => $cust_id])->get();



        return view('front.notification',compact('user','common','get_notification'));
    }







    
}
