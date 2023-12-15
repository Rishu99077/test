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
use App\Models\CountriesModel;
use App\Models\StatesModel;
use App\Models\CitiesModel;

class ListApiController extends Controller{


	public function countries(Request $request){
        
      $output=array();
      $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

        	$validator = Validator::make(
              $request->all(), 
              [
                  'device_id' => 'required',
              ]
            );

            if ($validator->fails()) {
                return response()->json([
                  'status' => false,
                  'message' => $validator->errors()->first(),
                ], 402);
            }

            $get_countries = CountriesModel::all();
            $data = array();
            foreach ($get_countries as $key => $value) {
              $row = array();
              $row['id'] = $value['id'];
              $row['name'] = $value['name'];
              $data[] = $row;
            }
            
           
            return response()->json([
              'status' => true,
              'message' => 'All Country list',
              'data' => $data,
            ], 402);

       }else{
          $output['message'] = '405';
       } 
       echo json_encode($output);
       die;   

    }


    public function states(Request $request){
        
      $output=array();
      $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

        	$validator = Validator::make(
              $request->all(), 
              [
                  'country_id'=>'required',
                  'device_id' => 'required',
              ]
            );

            if ($validator->fails()) {
                return response()->json([
                  'status' => false,
                  'message' => $validator->errors()->first(),
                ], 402);
            }

            $get_states = StatesModel::where(['country_id' => $request->country_id])->get();
            $data = array();
            foreach ($get_states as $key => $value) {
              $row = array();
              $row['id'] = $value['id'];
              $row['name'] = $value['name'];
              $row['country_id'] = $value['country_id'];
              $data[] = $row;
            }

           

            return response()->json([
              'status' => true,
              'message' => 'All States list',
              'data' => $data,
            ], 402);

       }else{
          $output['message'] = '405';
       } 
       echo json_encode($output);
       die;   

    }


    public function cities(Request $request){
        
      $output=array();
      $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

        	 $validator = Validator::make(
              $request->all(), 
              [
                  'state_id'=>'required',
                  'device_id' => 'required',
              ]
            );

            if ($validator->fails()) {
                return response()->json([
                  'status' => false,
                  'message' => $validator->errors()->first(),
                ], 402);
            }
            $data = array();

            if($request->state_id!=''){
              $get_cities = CitiesModel::where(['state_id' => $request->state_id])->get();
              foreach ($get_cities as $key => $value) {
                $row = array();
                $row['id'] = $value['id'];
                $row['name'] = $value['name'];
                $row['state_id'] = $value['state_id'];
                $data[] = $row;
              }
            }elseif($request->country!=''){  
                $get_states = StatesModel::where(['country_id' => $request->country])->get();

                foreach ($get_states as $key_get_states => $value_get_states) {
                  $get_cities = CitiesModel::where(['state_id' => $value_get_states->id])->get();
                  foreach ($get_cities as $key => $value) {
                    $row = array();
                    $row['id'] = $value['id'];
                    $row['name'] = $value['name'];
                    $row['state_id'] = $value['state_id'];
                    $data[] = $row;
                  }
                }
                
            }else{
              $get_cities = CitiesModel::get();
              foreach ($get_cities as $key => $value) {
                $row = array();
                $row['id'] = $value['id'];
                $row['name'] = $value['name'];                
                $row['state_id'] = $value['state_id'];
                $data[] = $row;
              }
            }

        
            return response()->json([
              'status' => true,
              'message' => 'All Cities list',
              'data' => $data,
            ], 402);

       }else{
          $output['message'] = '405';
       } 
       echo json_encode($output);
       die;   

    }


}