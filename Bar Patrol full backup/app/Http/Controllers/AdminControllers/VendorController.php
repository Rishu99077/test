<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Models\UserModel;
use App\Models\VendorModel;

class VendorController extends Controller
{

    public function vendors(){
    	$data = array();
    	$data['main_menu'] = 'Product type';
    	$user_id = Session::get('user_id');
    	$data['user_details'] = UserModel::where(['id' => $user_id])->first();

      // $get_vendors = VendorModel::where(['User_ID' => $user_id])->get();

      @$Vendorname = $_GET['Vendorname'];
     
      $VendorModel = VendorModel::where(['User_ID' => $user_id]);
      if ($Vendorname!='') {
          $VendorModel->where('vendor_name','LIKE','%'.$Vendorname.'%');
      }

      $get_vendors = $VendorModel->orderBy('VendorID', 'desc')->paginate(config('restaurant.records_per_page'));
     
    	$vendors = array();
        foreach ($get_vendors as $key => $value) {
          	$vendor['VendorID'] = $value['VendorID'];
            $vendor['vendor_name'] = $value['vendor_name'];
            $vendor['contact_name'] = $value['contact_name'];
            $vendor['phone_number'] = $value['phone_number'];
            $vendor['email'] = $value['email'];
            $vendor['status'] = $value['status'];
            $vendor['restaurant_name'] = '';
            $single_user_details = UserModel::where(['id' => $value['User_ID']])->first();
            if (!empty($single_user_details)) {
               $vendor['restaurant_name'] = $single_user_details['restaurant_name'];
            }
            
            $vendors[] = $vendor;
        }
    	return view('admin.Vendor.vendors',compact('data','vendors','get_vendors'));
    }

    public function admin_vendors(){
      $data = array();
      $data['main_menu'] = 'Product type';
      $user_id = Session::get('user_id');
      $data['user_details'] = UserModel::where(['id' => $user_id])->first();

      $get_vendors = VendorModel::where('User_ID','!=','1')->get();
     
      $vendors = array();
        foreach ($get_vendors as $key => $value) {
            $vendor['VendorID'] = $value['VendorID'];
            $vendor['vendor_name'] = $value['vendor_name'];
            $vendor['contact_name'] = $value['contact_name'];
            $vendor['phone_number'] = $value['phone_number'];
            $vendor['email'] = $value['email'];
            $vendor['status'] = $value['status'];
            $vendor['restaurant_name'] = '';
            $single_user_details = UserModel::where(['id' => $value['User_ID']])->first();
            if (!empty($single_user_details)) {
               $vendor['restaurant_name'] = $single_user_details['restaurant_name'];
            }
            $vendors[] = $vendor;
        }
      return view('admin.Vendor.admin_vendors',compact('data','vendors'));
    }
    
    public function master_vendors(){
      $data = array();
      $data['main_menu'] = 'Product type';
      $user_id = Session::get('user_id');
      $data['user_details'] = UserModel::where(['id' => $user_id])->first();

      $get_vendors = VendorModel::where('User_ID','=','1')->get();
     
      $vendors = array();
        foreach ($get_vendors as $key => $value) {
            $vendor['VendorID'] = $value['VendorID'];
            $vendor['vendor_name'] = $value['vendor_name'];
            $vendor['contact_name'] = $value['contact_name'];
            $vendor['phone_number'] = $value['phone_number'];
            $vendor['email'] = $value['email'];
            $vendor['status'] = $value['status'];
            $vendor['restaurant_name'] = '';
            $single_user_details = UserModel::where(['id' => $value['User_ID']])->first();
            if (!empty($single_user_details)) {
               $vendor['restaurant_name'] = $single_user_details['restaurant_name'];
            }
            $vendors[] = $vendor;
        }
      return view('admin.Vendor.master_vendors',compact('data','vendors'));
    }

    public function add_vendor(){  
   	    $data = array();
      	$data['main_menu'] = 'Product type'; 
        $data['heading'] = 'Add Vendor';
      	$user_id = Session::get('user_id');
      	$data['user_details'] = UserModel::where(['id' => $user_id])->first()->toArray();
      

          $vendors = array();
          $vendors['vendor_name']  = '';
          $vendors['contact_name']  = '';
          $vendors['phone_number']  = '';
          $vendors['email']  = '';
          $vendors['status']  = '';
          $vendors['User_ID'] = '';

          if(@$_GET['VendorID'] != ''){
            $data['heading'] = 'Edit Vendor';

              $VendorID = $_GET['VendorID'];
               $get_vendor = VendorModel::where(['VendorID'=>$VendorID])->first()->toArray();
               $vendors['VendorID'] = $get_vendor['VendorID'];
               $vendors['vendor_name'] = $get_vendor['vendor_name'];
               $vendors['contact_name'] = $get_vendor['contact_name'];        
               $vendors['phone_number'] = $get_vendor['phone_number'];
               $vendors['email'] = $get_vendor['email'];
               $vendors['status'] = $get_vendor['status'];
               $vendors['User_ID'] = $get_vendor['User_ID'];
          }
         
          return view('admin.Vendor.add_vendor',compact('vendors','data'));       
    }


    public function save_vendor(Request $request){
        $user_id = Session::get('user_id');
        $input = $request->all();
       
        $VendorID = $request->VendorID;	
        
        $data = $request->all();

          if ($VendorID!='') {

              $get_vendor = VendorModel::where('VendorID','!=',$VendorID)->where('User_ID',$user_id)->where('vendor_name',$data['vendor_name'])->first();
              if($get_vendor){
                $error['vendor_name'] = "The Vendor name is already taken";
                return response()->json(array('error' => $error));
              }



              $get_vendor = VendorModel::where(['VendorID' => $VendorID])->first();
              $VendorID = $get_vendor['VendorID'];

                $UpdateData = array();
                $UpdateData['vendor_name'] = $data['vendor_name'];
                $UpdateData['contact_name'] = $data['contact_name'];
               	$UpdateData['email'] = $data['email'];
               	$UpdateData['phone_number'] = $data['phone_number'];
                $UpdateData['status'] = $data['status'];
                $UpdateData['User_ID'] = $data['User_ID'];

                VendorModel::where(['VendorID' => $VendorID])->update($UpdateData);
                $request->session()->flash('success', 'Vendor Details Updated successfully!');
          }else{

            $rules = [];
            $rules['vendor_name'] = 'required';
            $rules['contact_name'] = 'required';
            $rules['email'] = 'required';
            $rules['phone_number'] = 'required';
            $required_msg = "The :attribute field is required.";

            $custom_msg = [];
            $custom_msg['required'] = $required_msg;

            $validator = Validator::make($input, $rules, $custom_msg);

            if ($validator->fails()) {
                return response()->json(array('error'=>$validator->getMessageBag()->toArray(),));
            }

            $get_vendor = VendorModel::where('User_ID',$user_id)->where('vendor_name',$data['vendor_name'])->first();
            if($get_vendor){
              $error['vendor_name'] = "The Vendor name is already taken";
              return response()->json(array('error' => $error));
            }

            $Data = array();
            $Data['vendor_name'] = $data['vendor_name'];
            $Data['contact_name'] = $data['contact_name'];
           	$Data['email'] = $data['email'];
           	$Data['phone_number'] = $data['phone_number'];
            if ($user_id=='1') {
              $Data['status'] = '1';
              $Data['superadmin_id'] = $user_id;
            }else{
          	  $Data['status'] = '0';
              $Data['admin_id'] = $user_id;
            }
            $Data['User_ID'] = $user_id;
            $Data['source'] = 'Web';

            $insert_id = VendorModel::create($Data);
            $request->session()->flash('success', 'Vendor Details added successfully!');           
      
          }   
    }

    public function add_from_master(Request $request){
        $user_id = Session::get('user_id');

        $VendorID = $request->VendorID;
        $vendor_name = $request->vendor_name;
        $get_admin_vendor = VendorModel::where(['vendor_name' => $vendor_name,'User_ID' => $user_id])->first();
        if (empty($get_admin_vendor)) {
          if(!empty($VendorID)){
              $get_vendors = VendorModel::where(['VendorID' => $VendorID])->first();
              if(!empty($get_vendors)){
                $Data = array();
                $Data['vendor_name'] = $get_vendors['vendor_name'];
                $Data['contact_name'] = $get_vendors['contact_name'];
                $Data['email'] = $get_vendors['email'];
                $Data['phone_number'] = $get_vendors['phone_number'];
                $Data['User_ID'] = $user_id;
                $Data['status'] = $get_vendors['status'];
                $Data['admin_id'] = $user_id;
                $Data['superadmin_id'] = '0';
                $Data['source'] = 'Web';
                
                VendorModel::create($Data); 
                $request->session()->flash('success', 'Vendor add to master');
              }
              
          }  
        }else{
          $request->session()->flash('danger', 'Alraedy added');
        }
      
    }

    public function vendor_movetomaster(Request $request){
        $VendorID = $request->VendorID;
        if(!empty($VendorID)){
          $UpdateData = array();      
          $UpdateData['status'] = '1';

          VendorModel::where(['VendorID' => $VendorID])->update($UpdateData);  
          $request->session()->flash('success', 'Vendor move to master');
        }
    }
    

    public function vendor_remove_master(Request $request){
        $VendorID = $request->VendorID;
        if(!empty($VendorID)){
          $UpdateData = array();      
          $UpdateData['status'] = '0';

          VendorModel::where(['VendorID' => $VendorID])->update($UpdateData);  
          $request->session()->flash('success', 'Vendor Remove from master');
        }
    }

    public function delete_vendor(Request $request){
      if($_GET['VendorID'] != ''){
         $VendorID = $_GET['VendorID'];
          
         VendorModel::where('VendorID', $VendorID)->delete();

         $request->session()->flash('danger', 'Vendors deleted successfully!');
         return redirect('vendors');  
      }
    }

}
