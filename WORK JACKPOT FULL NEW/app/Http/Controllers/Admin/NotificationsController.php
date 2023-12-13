<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Models\UserModel;
use App\Models\CustomersModel;
use App\Models\LanguagesModel;
use App\Models\NotificationsModel;

class NotificationsController extends Controller{


    public function notifications(){
    	$common = array();
        $common['main_menu']        = 'Menu';
        $common['sub_menu']         = 'Notification';
        $common['heading_title']    = __('admin.text_notification');

        $user = array();
        $user_id = Session::get('user_id');
        $user = UserModel::where(['id' => $user_id])->first();

        $get_customers = CustomersModel::orderBy('id','Desc')->paginate(10);

        return view('admin.Notifications.index',compact('common','get_customers','user'));
    }

    public function send_notification(Request $request){
        $user_id = Session::get('user_id');
        $user_details = UserModel::where(['id' => $user_id])->first();

        $data = $request->all();
      
        $Data = array();
        $Data['cust_id'] = $data['cust_id'];
        $Data['customer_name'] = $data['customer_name'];
        $Data['customer_phone'] = $data['customer_phone'];
        $Data['customer_email'] = $data['customer_email'];
        $Data['message'] = $data['message'];
        $insert_id = NotificationsModel::create($Data);

        return redirect('admin/notifications')->withErrors(['success'=> __('admin.text_notification').' '.__('admin.text_send_success')]);
             
    }


    public function faq_delete(Request $request){
      if(@$_GET['id'] != ''){
        $Faq_id = @$_GET['id'];
        FaqsModel::where('id', $Faq_id)->delete();
        FaqsDescriptionModel::where('faq_id', $Faq_id)->delete();   
      }
      return redirect('admin/faqs')->withErrors(['error'=> __('admin.text_notification_deleted')]);
    }

}



