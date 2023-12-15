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
use App\Models\IconsModel;
use App\Models\LocationsModel;


class LocationsController extends Controller{

    public function locations(){
    	$data = array();
    	$data['main_menu'] = 'Setting';
    	$user_id = Session::get('user_id');
    	$data['user_details'] = UserModel::where(['id' => $user_id])->first();
      
      // Location added by current user
      	$get_user_locations = LocationsModel::where(['User_ID' => $user_id])->orderBy('LocationID', 'desc')->get();
      	$user_locations = array();
        foreach ($get_user_locations as $key => $value) {
          	$loc['LocationID'] = $value['LocationID'];
            $loc['location_name'] = $value['location_name'];
            $loc['restaurant_name'] = '';
            $single_user_details = UserModel::where(['id' => $value['User_ID']])->first();
            if (!empty($single_user_details)) {
               $loc['restaurant_name'] = $single_user_details['restaurant_name'];
            }
            $loc['status'] = $value['status'];
            $user_locations[] = $loc;
        }

      // Location added by all admin  
        $get_admin_locations = LocationsModel::where('User_ID','!=','1')->orderBy('LocationID', 'desc')->get();
        $admin_locations = array();
        foreach ($get_admin_locations as $key => $value) {
            $loc['LocationID'] = $value['LocationID'];
            $loc['location_name'] = $value['location_name'];
            $loc['restaurant_name'] = '';
            $single_user_details = UserModel::where(['id' => $value['User_ID']])->first();
            if (!empty($single_user_details)) {
               $loc['restaurant_name'] = $single_user_details['restaurant_name'];
            }
            $loc['status'] = $value['status'];
            $admin_locations[] = $loc;
        }

      // Location added by Super admin 
        $get_master_locations = LocationsModel::where(['User_ID' => '1'])->orderBy('LocationID', 'desc')->get();
        $master_locations = array();
        foreach ($get_master_locations as $key => $value) {
            $loc['LocationID'] = $value['LocationID'];
            $loc['location_name'] = $value['location_name'];
            $loc['restaurant_name'] = '';
            $single_user_details = UserModel::where(['id' => $value['User_ID']])->first();
            if (!empty($single_user_details)) {
               $loc['restaurant_name'] = $single_user_details['restaurant_name'];
            }
            $loc['status'] = $value['status'];
            $master_locations[] = $loc;
        }


    	return view('admin.Locations.index',compact('data','user_locations','admin_locations','master_locations'));
    }

    public function master_locations(){
      $data = array();
      $data['main_menu'] = 'Setting';
      $user_id = Session::get('user_id');
      $data['user_details'] = UserModel::where(['id' => $user_id])->first();
      
      $get_locations = LocationsModel::where('User_ID','=','1')->get();
      

      $locations = array();
        foreach ($get_locations as $key => $value) {
            $loc['LocationID'] = $value['LocationID'];
            $loc['location_name'] = $value['location_name'];
            $loc['restaurant_name'] = '';
            $single_user_details = UserModel::where(['id' => $value['User_ID']])->first();
            if (!empty($single_user_details)) {
               $loc['restaurant_name'] = $single_user_details['restaurant_name'];
            }
            $loc['status'] = $value['status'];
            $locations[] = $loc;
        }

      return view('admin.Locations.master_locations',compact('data','locations'));
    }

    public function add_location_from_master(Request $request){
        $user_id = Session::get('user_id');

        $LocationID = $request->LocationID;
        $location_name = $request->location_name;
        $get_admin_location = LocationsModel::where(['location_name' => $location_name,'User_ID' => $user_id])->first();
        if (empty($get_admin_location)) {
          if(!empty($LocationID)){
              $get_location = LocationsModel::where(['LocationID' => $LocationID])->first();
              if(!empty($get_location)){
                $Data = array();
                $Data['location_name'] = $get_location['location_name'];
                $Data['User_ID'] = $user_id;
                $Data['status'] = $get_location['status'];
                $Data['admin_id'] = $user_id;
                $Data['superadmin_id'] = '0';
                $Data['source'] = 'Web';

                LocationsModel::create($Data); 
                $request->session()->flash('success', 'Location add to master');
              }
              
          }  
        }else{
          $request->session()->flash('danger', 'This location is already added');
        }
      
    }

    public function add_location(){  
   	    $data = array();
      	$data['main_menu'] = 'Setting'; 
      	$user_id = Session::get('user_id');
      	$data['user_details'] = UserModel::where(['id' => $user_id])->first();
      	$data['heading'] = 'Add location';

        $locations = array();
        $locations['location_name']  = '';
        $locations['status'] = '';
        $locations['added_by'] = '';


        if(@$_GET['LocationID'] != ''){
            $data['heading'] = 'Edit location';

            $LocationID = $_GET['LocationID'];
            $get_location = LocationsModel::where(['LocationID'=>$LocationID])->first();
           
            $locations['LocationID'] = $get_location['LocationID'];
            $locations['location_name'] = $get_location['location_name'];       
            $locations['status'] = $get_location['status'];

        }
        return view('admin.Locations.add_location',compact('locations','data'));       

    }

    public function save_locations(Request $request){
        $user_id = Session::get('user_id');
        $user_details = UserModel::where(['id' => $user_id])->first();
        $input = $request->all();
        
       
        $LocationID = $request->LocationID;
        $data = $request->all();

          if ($LocationID!='') {
              $get_location = LocationsModel::where('LocationID','!=',$LocationID)->where('User_ID',$user_id)->where('location_name',$data['location_name'])->first();
                if($get_location){
                  $error['location_name'] = "The location name is already taken";
                  return response()->json(array('error' => $error));
                }

                $get_icon = LocationsModel::where(['LocationID' => $LocationID])->first();
                $LocationID = $get_icon['LocationID'];

                $UpdateData = array();
                $UpdateData['location_name'] = $data['location_name'];
                $UpdateData['status'] = $data['status'];
                $UpdateData['User_ID'] = $user_id;

                LocationsModel::where(['LocationID' => $LocationID])->update($UpdateData);

          		$request->session()->flash('success', 'Location Updated successfully!');           

          }else{
              $rules = [];
              $rules['location_name'] = 'required';

              $required_msg = "The :attribute field is required.";
              $custom_msg = [];
              $custom_msg['required'] = $required_msg;
              $validator = Validator::make($input, $rules, $custom_msg);
              if ($validator->fails()) {
                return response()->json(array('error'=>$validator->getMessageBag()->toArray(),));
              }

              $get_location = LocationsModel::where('User_ID',$user_id)->where('location_name',$data['location_name'])->first();
           
              if($get_location){
                $error['location_name'] = "The location name is already taken";
                return response()->json(array('error' => $error));
              }

              $Data = array();
              $Data['location_name'] = $data['location_name'];
              $Data['User_ID']  = $user_id;
              if ($user_id=='1') {
                $Data['status'] = '1';
                $Data['superadmin_id'] = $user_id;
              }else{
                $Data['status'] = '0';
                $Data['admin_id'] = $user_id;
              }
              $Data['source']  = 'Web';

              $insert_id = LocationsModel::create($Data);
              $request->session()->flash('success', 'Location added successfully!');          

          }   

    }

    public function location_movetomaster(Request $request){
        $user_id = Session::get('user_id');

        $LocationID = $request->LocationID;
        $location_name = $request->location_name;
        $get_admin_location = LocationsModel::where(['location_name' => $location_name,'User_ID' => $user_id])->first();
        if (empty($get_admin_location)) {
          if(!empty($LocationID)){
              $get_location = LocationsModel::where(['LocationID' => $LocationID])->first();
              if(!empty($get_location)){
                $Data = array();
                $Data['location_name'] = $get_location['location_name'];
                $Data['User_ID'] = $user_id;
                $Data['status'] = $get_location['status'];
                $Data['admin_id'] = '0';
                $Data['superadmin_id'] = $user_id;
                $Data['source'] = 'Web';
                
                LocationsModel::create($Data); 

                $UpdateData = array();      
                $UpdateData['status'] = '1';

                LocationsModel::where(['LocationID' => $LocationID])->update($UpdateData);

                $request->session()->flash('success', 'Location add to master');
              }
              
          }  
        }else{
          $request->session()->flash('danger', 'This location is already added');
        }
    }


    public function location_remove_master(Request $request){
        $user_id = Session::get('user_id');
        $LocationID = $request->LocationID;
        $location_name = $request->location_name;

        if(!empty($LocationID)){
          
          LocationsModel::where(['User_ID' => $user_id,'location_name' => $location_name])->delete();

          $UpdateData = array();      
          $UpdateData['status'] = '0';

          LocationsModel::where(['LocationID' => $LocationID])->update($UpdateData);  
          $request->session()->flash('success', 'Location Remove from master');
        }
    }

    public function delete_location(Request $request){
      if($_GET['LocationID'] != ''){
         $LocationID = $_GET['LocationID'];
         LocationsModel::where(['LocationID' => $LocationID])->delete();
         $request->session()->flash('danger', 'Location deleted successfully!');
         return redirect('locations');  
      }
    }
}

