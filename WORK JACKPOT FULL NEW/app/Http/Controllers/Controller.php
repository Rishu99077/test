<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

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
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{

   
    public function get_chat(Request $request){
       
       $response  = array();
       $id        = $request->user;
       $cust_id   = "Admin";
        if(Session::has('cust_id')){
          $cust_id = Session::get('cust_id');
        }
       $chats     = array();

       $to_user =array();
       if($id == "Admin"){
         $user      = UserModel::where(['id' => 1])->first();
         $to_user['fullname'] = $user['first_name']." ".$user['last_name'];
         $to_user['id']       = "Admin";
       }else{
         $user      = CustomersModel::where(['id' => $id])->first();
         $to_user['fullname'] = $user['firstname']." ".$user['surname'];
         $to_user['id']       = $user['id'];
       }
        




        $customer_id_to    = $id;
        $customer_id_from  = $cust_id;
        $ChatModel = ChatModel::where(function ($query) use ($customer_id_to,$customer_id_from) {
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
        
        $response['html']   = view('front.chat.chat',compact('chats','to_user'))->render();
        $response['status'] = true;
       
       return json_encode($response); 

    }




    public function send_chat(Request $request){
        $response              = array();
        $response['status']    = false;
        $customer_id_to        = $request->user;
        $message               = $request->message;
        $cust_id                 = "Admin";
        if(Session::has('cust_id')){
          $cust_id = Session::get('cust_id');
          $user                  = CustomersModel::where(['id' => $cust_id])->first();
        }else{
          $user                  = UserModel::where(['id' => 1])->first();

        }
        


        if($request->message !=""){
            $ChatModel                       = new ChatModel();
            $ChatModel->customer_id_to       = $customer_id_to;
            $ChatModel->customer_id_from     = $cust_id;
            $ChatModel->message              = $message;
            $ChatModel->save();
            
            $date = date("d-m-Y",strtotime($ChatModel['created_at'])); 
            $time = date("h:i A",strtotime($ChatModel['created_at']));
            $message = $ChatModel->message;


            $response['status']              = true;
            
            $html = "";
            $html .= '<div class=" msg_send">
                            <div class="msg_img">
                                 ';if($user['profile_image'] !=""){
                                $html .= '<img src="'.url('profile',$user['profile_image']).'" alt="" srcset="">';
                                 }else{ 
                                $html .= '<img src="'.url('assets/images/bo.png').'" alt="" srcset="">';
                                 }
                            $html .='</div>
                            <div class="msg_details">
                                <div class="msg_date_time">
                                    <span class="msgdate">'.$date.'</span>
                                    <span class="msgtime">'.$time.'</span>
                                </div>
                                <div class="msg_text">
                                    <p>'.$message.'</p>
                                </div>
                            </div>
                        </div>';

            $response['html']      = $html;
        }else{
            $response['message'] = "Message is Empty";
        }
        return json_encode($response);
    }
}
