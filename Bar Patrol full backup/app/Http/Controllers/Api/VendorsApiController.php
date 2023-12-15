<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use App\Models\VendorModel;

class VendorsApiController extends Controller
{

   
    public function add(Request $request){
		
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validator = Validator::make(
              $request->all(), 
              [
                  'vendor_name' => 'required',
                  'contact_name'=> 'required',
                  'phone_number'=> 'required',
                  'email'=> 'required|unique:vendors', 
                  'user_id' => 'required',

              ]
            );

            if ($validator->fails()) {
                return response()->json([
                  'status' => false,
                  'message' => $validator->errors()->first(),
                ], 402);
            }

            $get_vendor_add =VendorModel::where('User_ID',$request->user_id)->where('vendor_name',$request->vendor_name)->first();
            if ($get_vendor_add!='') {
              return response()->json([
                    'status' => false,
                    'message' => 'This Vendor name is already exists',
              ], 402);
            } 

						
	          $data = array();
	          $data['vendor_name'] = $request->vendor_name; 
	          $data['contact_name'] = $request->contact_name; 
	          $data['phone_number'] = $request->phone_number; 
	          $data['email'] = $request->email; 
	          $data['User_ID'] = $request->user_id;	
            if ($request->user_id == '1') {
              $data['superadmin_id'] = $request->user_id; 
              $data['status'] = 1;
            }else{
              $data['admin_id'] = $request->user_id;
              $data['status'] = 0; 
            }
	          $data['source'] = 'App'; 



	      	  $insert_id = VendorModel::create($data);
	       
            $res_data = array();
            $res_data['vendor_id'] = $insert_id['id'];
            $res_data['vendor_name'] = $request->vendor_name; 
            $res_data['contact_name'] = $request->contact_name; 
            $res_data['phone_number'] = $request->phone_number; 
            $res_data['email'] = $request->email;
	         
	          return response()->json([
	            'status' => true,
	            'message' =>'Vendor added successfully',
	            'data' => $res_data,
	          ], 402);
        }else{
          $output['message'] = '405';
        } 
       echo json_encode($output);
       die;   
  	
    }


    public function detail(Request $request){
    
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validator = Validator::make(
              $request->all(), 
              [
                  'vendor_id' => 'required',
                  'user_id' => 'required',

              ]
            );

            if ($validator->fails()) {
                return response()->json([
                  'status' => false,
                  'message' => $validator->errors()->first(),
                ], 402);
            }

            $get_vendor = VendorModel::where(['VendorID' => $request->vendor_id])->first();
            
            if ($get_vendor) {
              $data = array();
              $data['vendor_id'] = '';
              $data['vendor_name'] = '';
              $data['contact_name'] = '';
              $data['phone_number'] = '';
              $data['email'] = '';
              $data['source'] = '';

              if ($get_vendor->VendorID) {
                $data['vendor_id'] = $get_vendor->VendorID;   
              } 
              if ($get_vendor->vendor_name) {
                $data['vendor_name'] = $get_vendor->vendor_name;   
              } 
              if ($get_vendor->contact_name) {
                $data['contact_name'] = $get_vendor->contact_name;   
              } 
              if ($get_vendor->phone_number) {
                $data['phone_number'] = $get_vendor->phone_number;   
              } 
              if ($get_vendor->email) {
                $data['email'] = $get_vendor->email;   
              } 
              if ($get_vendor->source) {
                $data['source'] = $get_vendor->source;   
              } 

              return response()->json([
                'status' => true,
                'message' =>'Vendor detail',
                'data' => $data,
              ], 402);
            }else{
                return response()->json([
                  'status' => false,
                  'message' => 'This Vendor is not exist',
                ], 402);
            }
        }else{
          $output['message'] = '405';
        } 
       echo json_encode($output);
       die;   
    
    }

    public function update(Request $request){
      $output=array();
      $output['status']=false;
      if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

          $validator = Validator::make(
            $request->all(), 
            [
                'vendor_id' => 'required',
                'vendor_name' => 'required',
                'contact_name'=> 'required',
                'phone_number'=> 'required',
                'user_id' => 'required',
            ]
          );

          if ($validator->fails()) {
              return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
              ], 402);
          }

          $get_vendor = VendorModel::where('VendorID','!=',$request->vendor_id)->where('User_ID',$request->user_id)->where('vendor_name',$request->vendor_name)->first();
          if ($get_vendor!='') {
              return response()->json([
                    'status' => false,
                    'message' => 'This Vendor name is already taken',
              ], 402);
          }

          $get_single_vendor = VendorModel::where(['User_ID' => $request->user_id,'VendorID' => $request->vendor_id])->first();
         
          if($get_single_vendor!=''){
                $data = array();
                $data['VendorID'] = $get_single_vendor['VendorID'];
                $data['vendor_name'] = $request->vendor_name;
                $data['contact_name'] = $request->contact_name;
                $data['phone_number'] = $request->phone_number;
                $data['source'] = 'App';  

                VendorModel::where('VendorID', $get_single_vendor['VendorID'])->update($data);
                  
                $res_data = array();
                $res_data['vendor_id'] = $data['VendorID'];
                $res_data['vendor_name'] = $data['vendor_name'];
                $res_data['contact_name'] = $data['contact_name'];
                $res_data['phone_number'] = $data['phone_number'];
                $res_data['email'] = $get_single_vendor['email'];
                $res_data['source'] = $data['source'];


                return response()->json([
                  'status' => true,
                  'message' => 'Vendor update succesfully',
                  'data' => $res_data,
                ], 402);

          }else{
               return response()->json([
                'status' => false,
                'message' => 'This Vendor is not exist for this user',
              ], 402);
          }
             
      }else{
        $output['message'] = '405';
      } 
      echo json_encode($output);
      die;   

    }


	  public function vendors_list(Request $request){
      $output=array();
      $output['status']=false;
      if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

          $validator = Validator::make(
            $request->all(), 
             [
                'user_id' => 'required',
            ]
          );

          if ($validator->fails()) {
              return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
              ], 402);
          }

          $data = array();
          $get_vendors = VendorModel::where(['User_ID' => $request->user_id])->first();
          if ($get_vendors) {
               $get_vendors = VendorModel::where(['User_ID' => $request->user_id])->get();

               $vendors = array();
                foreach ($get_vendors as $key => $value) {
                  $vendor = array();
                  $vendor['id'] = $value['VendorID'];  
                  $vendor['name'] = $value['vendor_name'];
                  $vendor['contact_name'] = $value['contact_name'];
                  $vendor['phone_number'] = $value['phone_number']; 
                  $vendor['email'] = $value['email'];  
                  $vendors[] = $vendor;
                }         
               
                return response()->json([
                  'status' => true,
                  'message' => 'Vendor list',
                  'data' => $vendors,
                ], 402);
          }else{
              return response()->json([
                'status' => false,
                'message' => 'No Vendor for this user',
              ], 402);
          }
         
      }else{
        $output['message'] = '405';
      } 
      echo json_encode($output);
      die;   

    }


    public function vendor_delete(Request $request){
      $output=array();
      $output['status']=false;
      if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

          $validator = Validator::make(
            $request->all(), 
            [
                'vendor_id' => 'required',
                'user_id' => 'required',
            ]
          );

          if ($validator->fails()) {
              return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
              ], 402);
          }

          $get_vendors = VendorModel::where(['User_ID' => $request->user_id,'VendorID' => $request->vendor_id])->first();
       
          if ($get_vendors) {
             
              VendorModel::where(['User_ID' => $request->user_id,'VendorID' => $request->vendor_id])->delete();
             
              return response()->json([
                'status' => true,
                'message' => 'Vendor deleted sucessfully',
              ], 402);
          }else{
              return response()->json([
                'status' => false,
                'message' => 'No Vendor for this user',
              ], 402);
          }
          

      }else{
        $output['message'] = '405';
      } 
      echo json_encode($output);
      die;   

    }

}