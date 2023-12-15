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
use App\Models\ProductTypeModel;
use App\Models\ProductCategorieModel;
use App\Models\IconsModel;

class ProductTypeApiController extends Controller
{

	  public function product_type_add(Request $request){
		   
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validator = Validator::make(
              $request->all(), 
              [
                  'name' => 'required',
                  'icon_id' => 'required',
                  'user_id' => 'required',
              ]
            );

            if ($validator->fails()) {
                return response()->json([
                  'status' => false,
                  'message' => $validator->errors()->first(),
                ], 402);
            }
						
            $get_type =ProductTypeModel::where('User_ID',$request->user_id)->where('name',$request->name)->first();
            if ($get_type!='') {
              return response()->json([
                    'status' => false,
                    'message' => 'This product type name is already exists',
              ], 402);
            }   

            $icon_details = IconsModel::where(['IconID' => $request->icon_id , 'User_ID' => $request->user_id])->first();
            if ($icon_details) {
                  $data = array();
                  $data['name'] = $request->name; 
                  $data['icon'] = $request->icon_id;
                  $data['User_ID'] = $request->user_id; 
                  if ($request->user_id == '1') {
                    $data['superadmin_id'] = $request->user_id; 
                    $data['status'] = 1;
                  }else{
                    $data['admin_id'] = $request->user_id;
                    $data['status'] = 0; 
                  }
                  $data['source'] = 'App'; 

                  $insert_id = ProductTypeModel::create($data);
                   
                  $res_data = array();
                  $res_data['product_type_id'] = $insert_id['id'];
                  $res_data['name'] = $request->name;
                  $res_data['icon'] = $data['icon'];

                  return response()->json([
                    'status' => true,
                    'message' =>'Product Type added successfully',
                    'data' => $res_data,
                  ], 402);
            }else{
                return response()->json([
                  'status' => false,
                  'message' => 'This Icon is not exist for this user',
                ], 402);
            }
        }else{
          $output['message'] = '405';
        } 
       echo json_encode($output);
       die;   
  	
    }

    public function product_type_detail(Request $request){
    
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validator = Validator::make(
              $request->all(), 
              [
                  'product_type_id' => 'required',
                  'user_id' => 'required',
              ]
            );

            if ($validator->fails()) {
                return response()->json([
                  'status' => false,
                  'message' => $validator->errors()->first(),
                ], 402);
            }

            $get_single_product_type = ProductTypeModel::where(['id' => $request->product_type_id , 'User_ID' => $request->user_id])->first();
            
            if ($get_single_product_type) {
              $data = array();
              $data['product_type_id'] = $get_single_product_type->id;
              $data['name'] = '';
              if ($get_single_product_type->name) {
                $data['name'] = $get_single_product_type->name;   
              } 
              $data['icon'] = '';
              if ($get_single_product_type->icon) {
                $data['icon'] = $get_single_product_type->icon;   
              } 
            }else{
                return response()->json([
                  'status' => false,
                  'message' => 'This Product Type is not exist',
                ], 402);
            }
           
         
            return response()->json([
              'status' => true,
              'message' =>'Product Type edit',
              'data' => $data,
            ], 402);
        }else{
          $output['message'] = '405';
        } 
       echo json_encode($output);
       die;   
    
    }

    public function product_type_update(Request $request){
      $output=array();
      $output['status']=false;
      if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

          $validator = Validator::make(
            $request->all(), 
            [
                'product_type_id' => 'required',
                'name' => 'required',
                'icon_id'=>'required',
                'user_id' => 'required',
            ]
          );

          if ($validator->fails()) {
              return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
              ], 402);
          }

          $get_type = ProductTypeModel::where('id','!=',$request->product_type_id)->where('User_ID',$request->user_id)->where('name',$request->name)->first();
          if ($get_type!='') {
              return response()->json([
                    'status' => false,
                    'message' => 'This product type name is already taken',
              ], 402);
          }
          
          $get_single_product_type = ProductTypeModel::where(['User_ID' => $request->user_id,'id' => $request->product_type_id])->first();
          
          if($get_single_product_type!=''){
                $data = array();
                $data['id'] = $get_single_product_type['id'];
                $data['name'] = $request->name;
                $data['icon'] = $request->icon_id;
                $data['User_ID'] = $get_single_product_type['User_ID'];
                $data['source'] = 'App';

                ProductTypeModel::where('id', $get_single_product_type['id'])->update($data);
                  
                $res_data = array();
                $res_data['product_type_id'] = $data['id'];
                $res_data['name'] = $data['name'];
                $res_data['icon_id'] = $data['icon'];
                $res_data['user_id'] = $data['User_ID'];
                $res_data['source'] = $data['source'];  

                return response()->json([
                  'status' => true,
                  'message' => 'Product type updated succesfully',
                  'data' => $res_data,
                ], 402);

          }else{
               return response()->json([
                'status' => false,
                'message' => 'This Product type is not exist for this user',
              ], 402);
          }
              
      }else{
        $output['message'] = '405';
      } 
      echo json_encode($output);
      die;   

    }


    public function product_type_list(Request $request){
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

          $get_product_types = ProductTypeModel::where(['User_ID' => $request->user_id])->get();
          // echo "<pre>"; 
          // print_r($get_product_types);
          // echo "</pre>";
          $types = array();
          if (count($get_product_types)>0) {
              foreach ($get_product_types as $key => $value) {
                  $type['id'] = $value['id'];  
                  $type['name'] = $value['name'];
                  $type['icon_id'] = $value['icon'];
                  $type['icon'] = '';
                  $type['icon_name'] = '';
                  $icon_details = IconsModel::where(['IconID' => $value['icon'],'User_ID' => $request->user_id])->first();

                  if ($icon_details) {
                    $IconImage = $icon_details['image'];
                    $type['icon'] = url('/App/IconsImages/'.$IconImage);
                    $type['icon_name'] = $icon_details['icon_name'];
                  }
                  $type['user_id'] = $value['User_ID'];
                  $type['status'] = $value['status'];  
                  $type['source'] = $value['source']; 

                  $product_categories = array();
                  $get_product_categories = ProductCategorieModel::where(['product_type_id' =>$value['id']])->get();
                  foreach ($get_product_categories as $key => $value1) {
                     $categories =  array();
                     $categories['id'] = $value1['Categorie_ID'];  
                     $categories['name'] = $value1['categorie_name'];
                     $categories['product_type_id'] = $value1['product_type_id'];
                     $categories['product_type_name'] = '';
                     $get_product_types = ProductTypeModel::where(['id' => $value1['product_type_id']])->first();
                     if ($get_product_types) {
                        $categories['product_type_name'] = $get_product_types['name'];
                     } 
                     $categories['user_id'] = $value1['User_ID'];
                     $categories['status'] = $value1['status'];   
                     $product_categories[] = $categories;
                  }

                  $type['product_categories'] = $product_categories;

                  $types[] = $type;
              }
              
              return response()->json([
                'status' => true,
                'message' => 'Product type list',
                'data' => $types,
              ], 402);

          }else{

              return response()->json([
                'status' => false,
                'message' => 'No Product type list for this user',
              ], 402);
          }
          

      }else{
        $output['message'] = '405';
      } 
      echo json_encode($output);
      die;   

    }


    public function product_type_delete(Request $request){
      $output=array();
      $output['status']=false;
      if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

          $validator = Validator::make(
            $request->all(), 
            [
                'product_type_id' => 'required',
                'user_id' => 'required',
            ]
          );

          if ($validator->fails()) {
              return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
              ], 402);
          }

          $get_products_type = ProductTypeModel::where(['User_ID' => $request->user_id,'id' => $request->product_type_id])->first();
       
          if ($get_products_type) {
             
              ProductTypeModel::where(['User_ID' => $request->user_id,'id' => $request->product_type_id])->delete();
             
              return response()->json([
                'status' => true,
                'message' => 'Product type deleted sucessfully',
              ], 402);
          }else{
              return response()->json([
                'status' => false,
                'message' => 'No Product type list for this user',
              ], 402);
          }
          

      }else{
        $output['message'] = '405';
      } 
      echo json_encode($output);
      die;   

    }


}