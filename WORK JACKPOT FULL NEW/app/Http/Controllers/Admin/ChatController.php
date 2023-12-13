<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Models\UserModel;
use App\Models\CountryModel;
use App\Models\CityModel;
use App\Models\StateModel;
use App\Models\TestimonialsModel;
use App\Models\TestimonialDescriptionModel;
use App\Models\LanguagesModel;
use App\Models\ContactModel;
use App\Models\CustomersModel;
use App\Models\ChatModel;



class ChatController extends Controller{
    public function index(){
      $common = array();
      $common['main_menu'] = 'Menu';
      $common['sub_menu']  = 'chat';
      $common['heading_title'] = 'Chat';  
      $user    = array();
      $user_id = Session::get('user_id');
      $user    = UserModel::where(['id' => $user_id])->first();

       $Get_Customer   = array();

       $ChatModel = ChatModel::where('customer_id_to', '=', "Admin")->orWhere('customer_id_from', '=', "Admin")->orderBy('id','desc')->get();
       foreach($ChatModel as $key=>$value){
            if ($value['customer_id_to']=='Admin') {
                if(!array_key_exists($value['customer_id_from'],$Get_Customer)){
                     $CustomersModel = CustomersModel::where('id', $value['customer_id_from'])->first();
                    if ($CustomersModel) {
                       $Get_Customer[$CustomersModel['id']]   = $CustomersModel;
                    }
                }
            }else{
                if(!array_key_exists($value['customer_id_to'],$Get_Customer)){
                  $CustomersModel = CustomersModel::where('id', $value['customer_id_to'])->first();
                    if ($CustomersModel) {
                       $Get_Customer[$CustomersModel['id']]   = $CustomersModel;
                    }
                }
            }
       }


        $CustomersModel =  CustomersModel::select('*');
        if(@$_GET['search_input']){
            $search         = @$_GET['search_input'];
            $CustomersModel = $CustomersModel->where('firstname', 'LIKE','%'.$search.'%');
        }
        

       $CustomersModel = $CustomersModel->orderBy('id','desc')->get();
       foreach($CustomersModel as $key => $value) {
        if (!array_key_exists($value['id'],$Get_Customer)){
            $CustomersModel1 = CustomersModel::where('id',$value['id'])->first();
            if ($CustomersModel1) {
               $Get_Customer[$CustomersModel1['id']]   = $CustomersModel1;
            }
        }

      }
      return view('admin.Chat.chat',compact('user','common','Get_Customer'));
    }
}



