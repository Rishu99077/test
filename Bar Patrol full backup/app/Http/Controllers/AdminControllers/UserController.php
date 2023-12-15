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
use App\Models\ProductTypeModel;
use App\Models\IconsModel;

class UserController extends Controller{

	  public function users(){

    	$data = array();
    	$data['main_menu'] = 'Users';
    	$user_id = Session::get('user_id');
    	$data['user_details'] = UserModel::where(['id' => $user_id])->first();
     
    	$get_users = UserModel::all();
    	
    	$users = array();

        foreach ($get_users as $key => $value) {
        	  $user['id'] = $value['id'];
            $user['restaurant_name'] = $value['restaurant_name'];
            $user['email'] = $value['email'];
            $user['phone_no'] = $value['phone_no'];
            $users[] = $user;
        }

    	return view('admin.Users.index',compact('data','users'));

    }

    public function add_user(){  
   	    $data = array();
      	$data['main_menu'] = 'Users'; 
        $data['heading_title'] = 'Add Restaurant'; 
      	$user_id = Session::get('user_id');
      	$data['user_details'] = UserModel::where(['id' => $user_id])->first();

          $users = array();
          $users['phone_no']  = '';
          $users['password']  = '';
          $users['email']  = '';
          $users['restaurant_name'] = '';

          if(@$_GET['UserID'] != ''){
              $data['heading_title'] = 'Edit Restaurant'; 
              $UserID = $_GET['UserID'];
               $get_user = UserModel::where(['id'=>$UserID])->first();
               $users['UserID'] = $get_user['id'];
               $users['restaurant_name'] = $get_user['restaurant_name'];
               $users['phone_no'] = $get_user['phone_no'];
               $users['email'] = $get_user['email'];
               $users['password'] = $get_user['password'];
          }
         
          return view('admin.Users.add_user',compact('users','data'));       
    }

    public function update_userprofile(){  
        $data = array();
        $data['main_menu'] = 'Users'; 
        $data['heading_title'] = 'Add Restaurant'; 
        $user_id = Session::get('user_id');
        $data['user_details'] = UserModel::where(['id' => $user_id])->first();

          $users = array();
          $users['phone_no']  = '';
          $users['password']  = '';
          $users['email']  = '';
          $users['restaurant_name'] = '';

          if($user_id){
              $data['heading_title'] = 'Edit Restaurant'; 
             
               $get_user = UserModel::where(['id'=>$user_id])->first();
               $users['UserID'] = $get_user['id'];
               $users['phone_no'] = $get_user['phone_no'];
               $users['restaurant_name'] = $get_user['restaurant_name'];
               $users['email'] = $get_user['email'];
               $users['password'] = $get_user['password'];
          }
         
          return view('admin.Users.update_profile',compact('users','data'));       
    }

    public function save_user(Request $request){
        $user_id = Session::get('user_id');
        $user_details = UserModel::where(['id' => $user_id])->first();
        $user_role = $user_details['user_role'];
        $input = $request->all();      
        $UserID = $request->UserID;	    	
        $data = $request->all();
          if ($UserID!='') {
              $get_user = UserModel::where(['id' => $UserID])->first();
            
                $UpdateData = array();
               	$UpdateData['email'] = $data['email'];
               	$UpdateData['phone_no'] = $data['phone_no'];
               	$UpdateData['restaurant_name'] = $data['restaurant_name'];
               	$UpdateData['user_role'] = $user_role;

        
                UserModel::where(['id' => $UserID])->update($UpdateData);


                $request->session()->flash('success', 'Restaurant Details Updated successfully!');

          }else{
              $rules = [];
              $rules['restaurant_name'] = 'required|unique:users';
              $rules['email'] = 'required|email|unique:users';
              $rules['phone_no'] = 'required|min:10|unique:users';
              $rules['password'] = 'required|min:6';
              $required_msg = "The :attribute field is required.";

              $custom_msg = [];
              $custom_msg['required'] = $required_msg;

              $validator = Validator::make($input, $rules, $custom_msg);

              if ($validator->fails()) {
                  return response()->json(array('error'=>$validator->getMessageBag()->toArray(),));
              }

            $Data = array();
           	$Data['restaurant_name'] = $data['restaurant_name'];
           	$Data['email'] = $data['email'];
           	$Data['phone_no'] = $data['phone_no'];
           	$Data['password'] = sha1($data['password']);
           	$Data['user_role'] = $user_role;
            $insert_id = UserModel::create($Data);
            $request->session()->flash('success', 'Restaurant Details added successfully!');           
      
          }   
    }

    public function delete_user(Request $request){
      if($_GET['UserID'] != ''){
         $UserID = $_GET['UserID'];
          
         UserModel::where('id', $UserID)->delete();

         $request->session()->flash('danger', 'Restaurant deleted successfully!');
         return redirect('users');  
      }
    }


}
