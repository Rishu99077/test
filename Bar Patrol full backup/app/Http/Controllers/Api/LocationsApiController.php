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
use App\Models\LocationsModel;

class LocationsApiController extends Controller
{

	  public function add(Request $request){
		
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validator = Validator::make(
              $request->all(), 
              [
                  'location_name' => 'required',
                  'user_id' => 'required',
              ]
            );

            if ($validator->fails()) {
                return response()->json([
                  'status' => false,
                  'message' => $validator->errors()->first(),
                ], 402);
            }

            $get_location =LocationsModel::where('User_ID',$request->user_id)->where('location_name',$request->location_name)->first();
            if ($get_location!='') {
              return response()->json([
                    'status' => false,
                    'message' => 'This Location name is already exists',
              ], 402);
            }   

						
            $LocationName = $request->location_name;
            $User_id = $request->user_id;

            foreach ($LocationName as $key => $value) {
  	          $data = array();
  	          $data['location_name'] = $LocationName[$key]; 
  	          $data['User_ID'] = $User_id;	
              if ($User_id == '1') {
                $data['superadmin_id'] = $User_id; 
  	            $data['status'] = 1;
              }else{
                $data['admin_id'] = $User_id;
                $data['status'] = 0; 
              }
  	          $data['source'] = 'App'; 

  	      	  $insert_id = LocationsModel::create($data);
            }  

          
	       
	          return response()->json([
	            'status' => true,
	            'message' =>'Location added successfully',
	            // 'data' => $res_data,
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
                  'location_id' => 'required',
                  'user_id' => 'required',
              ]
            );

            if ($validator->fails()) {
                return response()->json([
                  'status' => false,
                  'message' => $validator->errors()->first(),
                ], 402);
            }

            $get_location = LocationsModel::where(['LocationID' => $request->location_id])->first();
           
            if($get_location) {
              $data = array();
              $data['location_id'] = $get_location->LocationID;
              $data['location_name'] = $get_location->location_name;   
              $data['status'] = $get_location->status;   
              $data['source'] = $get_location->source;   

              return response()->json([
                'status' => true,
                'message' =>'Location detail',
                'data' => $data,
              ], 402);


            }else{
                return response()->json([
                  'status' => false,
                  'message' => 'This Location is not exist',
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
                'location_id' => 'required',
                'location_name' => 'required',
                'user_id' => 'required',
            ]
          );

          if ($validator->fails()) {
              return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
              ], 402);
          }

          $get_location = LocationsModel::where('LocationID','!=',$request->location_id)->where('User_ID',$request->user_id)->where('location_name',$request->location_name)->first();
          if ($get_location!='') {
              return response()->json([
                    'status' => false,
                    'message' => 'This Location is already taken.',
              ], 402);
          }else{
              $LocationsModel = LocationsModel::where(['LocationID' => $request->location_id])->first();
              if($LocationsModel){
                    
                    $User_id = $request->user_id;
                    $data = array();
                    $data['location_name'] = $request->location_name;
                    if ($User_id == '1') {
                      $data['superadmin_id'] = $User_id; 
                      $data['status'] = 1;
                    }else{
                      $data['admin_id'] = $User_id;
                      $data['status'] = 0; 
                    }
                    $data['User_ID'] = $User_id;
                    
                    LocationsModel::where('LocationID', $request->location_id)->update($data);  

                    return response()->json([
                      'status' => true,
                      'message' => 'Location update succesfully',
                    ], 402);

              }else{
                   return response()->json([
                    'status' => false,
                    'message' => 'This Location is not exist',
                  ], 402);
              }

          }    
      }else{
        $output['message'] = '405';
      } 
      echo json_encode($output);
      die;   

    }


    public function locations_list(Request $request){
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
          $get_locations = LocationsModel::where(['User_ID' => $request->user_id])->first();
          if ($get_locations) {
             $get_locations = LocationsModel::where(['User_ID' => $request->user_id])->get();
              $locations = array();
              foreach ($get_locations as $key => $value) {
                  $location = array();
                  $location['location_id'] = $value['LocationID']; 
                  $location['location_name'] = $value['location_name'];
                  $location['user_id'] = $value['User_ID'];
                  $location['status'] = $value['status'];  
                  $location['source'] = $value['source']; 
                  $locations[] = $location;
              }
             
              return response()->json([
                'status' => true,
                'message' => 'Locations list',
                'data' => $locations,
              ], 402);
            
          }else{
              return response()->json([
                  'status' => false,
                  'message' => 'No location',
              ], 402);
          }
      }else{
        $output['message'] = '405';
      } 
      echo json_encode($output);
      die;   

    }


    public function delete(Request $request){
      $output=array();
      $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validator = Validator::make(
              $request->all(), 
              [
                  'location_id' => 'required',
                  'user_id' => 'required',
              ]
            );

            if ($validator->fails()) {
                return response()->json([
                  'status' => false,
                  'message' => $validator->errors()->first(),
                ], 402);
            }

            $get_single_location = LocationsModel::where(['LocationID' => $request->location_id,'User_ID' => $request->user_id])->first();
           
            if($get_single_location!=''){
                 
                LocationsModel::where('LocationID', $get_single_location['LocationID'])->delete();

                return response()->json([
                  'status' => true,
                  'message' => 'Location has been deleted',
                ], 402);

            }else{
                 return response()->json([
                  'status' => false,
                  'message' => 'The Location is not exist',
                ], 402);
            }
            

       }else{
          $output['message'] = '405';
       } 
       echo json_encode($output);
       die;   

    }


}