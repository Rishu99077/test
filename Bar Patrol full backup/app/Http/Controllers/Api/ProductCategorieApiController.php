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
use App\Models\ProductCategorieModel;
use App\Models\ProductTypeModel;
use App\Models\IconsModel;

class ProductCategorieApiController extends Controller
{

	  public function product_categorie_add(Request $request){
		   
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validator = Validator::make(
              $request->all(), 
              [
                  'categorie_name' => 'required',
                  'product_type_id' => 'required',
                  'user_id' => 'required',
              ]
            );

            $get_category = ProductCategorieModel::where('User_ID',$request->user_id)->where('categorie_name',$request->categorie_name)->first();
            if ($get_category!='') {
              return response()->json([
                    'status' => false,
                    'message' => 'This categorie name is already exists',
              ], 402);
            } 

            if ($validator->fails()) {
                return response()->json([
                  'status' => false,
                  'message' => $validator->errors()->first(),
                ], 402);
            }
						
            $product_type_details = ProductTypeModel::where(['id' => $request->product_type_id , 'User_ID' => $request->user_id])->first();
            if ($product_type_details) {
                  $data = array();
                  $data['categorie_name'] = $request->categorie_name; 
                  $data['product_type_id'] = $request->product_type_id;
                  $data['User_ID'] = $request->user_id; 
                  if ($request->user_id == '1') {
                    $data['superadmin_id'] = $request->user_id; 
                    $data['status'] = 1;
                  }else{
                    $data['admin_id'] = $request->user_id;
                    $data['status'] = 0; 
                  }
                  // $data['source'] = 'App'; 

                  $insert_id = ProductCategorieModel::create($data);
                   
                  $res_data = array();
                  $res_data['product_categorie_id'] = $insert_id['id'];
                  $res_data['categorie_name'] = $request->categorie_name;
                  $res_data['product_type_id'] = $data['product_type_id'];

                  return response()->json([
                    'status' => true,
                    'message' =>'Product categorie added successfully',
                    'data' => $res_data,
                  ], 402);
            }else{
                return response()->json([
                  'status' => false,
                  'message' => 'This Product Type is not exist for this user',
                ], 402);
            }
        }else{
          $output['message'] = '405';
        } 
       echo json_encode($output);
       die;   
  	
    }

    public function product_categorie_add_new(Request $request){
       
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validator = Validator::make(
              $request->all(), 
              [
                  'categorie_name' => 'required',
                  'product_type_id' => 'required',
                  'user_id' => 'required',
              ]
            );

            $get_category = ProductCategorieModel::where('User_ID',$request->user_id)->where('categorie_name',$request->categorie_name)->first();
            if ($get_category!='') {
              return response()->json([
                    'status' => false,
                    'message' => 'This categorie name is already exists',
              ], 402);
            } 

            if ($validator->fails()) {
                return response()->json([
                  'status' => false,
                  'message' => $validator->errors()->first(),
                ], 402);
            }
            
            $product_type_details = ProductTypeModel::where(['id' => $request->product_type_id , 'User_ID' => $request->user_id])->first();
            
            if ($product_type_details) {

                  $CategorieName = $request->categorie_name;
                  $User_id = $request->user_id;

                  
                  foreach ($CategorieName as $key => $value) {
                    $datapostproducts =array();
                    $datapostproducts['product_type_id'] = $product_type_details->id;
                    $datapostproducts['categorie_name'] = $CategorieName[$key];
                    $datapostproducts['User_ID'] = $User_id;
                    if ($request->User_id == '1') {
                      $datapostproducts['superadmin_id'] = $User_id; 
                      $datapostproducts['status'] = 1;
                    }else{
                      $datapostproducts['admin_id'] = $User_id;
                      $datapostproducts['status'] = 0; 
                    }
                    $last_id = ProductCategorieModel::create($datapostproducts);
                 
                  } 
                   
               

                  return response()->json([
                    'status' => true,
                    'message' =>'Product categorie added successfully',
                    // 'data' => $res_data,
                  ], 402);
            }else{
                return response()->json([
                  'status' => false,
                  'message' => 'This Product Type is not exist for this user',
                ], 402);
            }
        }else{
          $output['message'] = '405';
        } 
       echo json_encode($output);
       die;   
    
    }

    public function product_categorie_detail(Request $request){
    
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

            $get_single_product_categorie = ProductCategorieModel::where(['product_type_id' => $request->product_type_id , 'User_ID' => $request->user_id])->first();
            
            if ($get_single_product_categorie) {
               $product_type_id = array();
               $product_type_name = array();
               $product_type_id = $request->product_type_id;
               
               $get_product_types = ProductTypeModel::where(['id' => $product_type_id])->first();
               if ($get_product_types) {
                 $product_type_name = $get_product_types['name'];
               }   
              
              $get_single_product_categorie = ProductCategorieModel::where(['product_type_id' => $request->product_type_id , 'User_ID' => $request->user_id])->get();
              $data = array();
              foreach ($get_single_product_categorie as $key => $value) {
                   $type['categorie_id'] = $value['Categorie_ID'];  
                   $type['categorie_name'] = $value['categorie_name'];
                  
                   $data[] = $type;
              }
              
               return response()->json([
                  'status' => true,
                  'message' =>'Product categorie detail',
                  'product_type_id' => $product_type_id,
                  'product_type_name' => $product_type_name,
                  'data' => $data,
                ], 402);

            }else{
                return response()->json([
                  'status' => false,
                  'message' => 'This Product categorie is not exist',
                  
                ], 402);
            }
           
         
           
        }else{
          $output['message'] = '405';
        } 
       echo json_encode($output);
       die;   
    
    }

    public function product_categorie_update(Request $request){
      $output=array();
      $output['status']=false;
      if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validator = Validator::make(
              $request->all(), 
              [
                  'product_categorie_id' => 'required',
                  'categorie_name' => 'required',
                  'user_id' => 'required',
              ]
            );

            if ($validator->fails()) {
                return response()->json([
                  'status' => false,
                  'message' => $validator->errors()->first(),
                ], 402);
            }

            $get_categorie = ProductCategorieModel::where('Categorie_ID','!=',$request->product_categorie_id)->where('User_ID',$request->user_id)->where('categorie_name',$request->categorie_name)->first();
            if ($get_categorie!='') {
                return response()->json([
                      'status' => false,
                      'message' => 'This Categorie name is already taken.',
                ], 402);
            }

            $get_single_categorie = ProductCategorieModel::where(['User_ID' => $request->user_id,'Categorie_ID' => $request->product_categorie_id])->first();
         
            if($get_single_categorie!=''){
                  $data = array();
                  $data['Categorie_ID'] = $get_single_categorie['Categorie_ID'];
                  $data['categorie_name'] = $request->categorie_name;
                  $data['User_ID'] = $get_single_categorie['User_ID'];
                  // $data['source'] = 'App';

                  ProductCategorieModel::where('Categorie_ID', $get_single_categorie['Categorie_ID'])->update($data);
                    
                  $res_data = array();
                  $res_data['product_categorie_id'] = $data['Categorie_ID'];
                  $res_data['categorie_name'] = $data['categorie_name'];
                  $res_data['user_id'] = $data['User_ID'];
                  // $res_data['source'] = $data['source'];  

                  return response()->json([
                    'status' => true,
                    'message' => 'Product Categorie updated succesfully',
                    'data' => $res_data,
                  ], 402);

            }else{
                 return response()->json([
                  'status' => false,
                  'message' => 'This Product Categorie is not exist for this user',
                ], 402);
            }
      }else{
         $output['message'] = '405';
      } 
      echo json_encode($output);
      die;   

    }


    public function product_categorie_update_new(Request $request){
      $output=array();
      $output['status']=false;
      if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

          $validator = Validator::make(
            $request->all(), 
            [
                'product_type_id' => 'required',
                'categorie_name' => 'required',
                'user_id' => 'required',
            ]
          );

          if ($validator->fails()) {
              return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
              ], 402);
          }

          $get_categorie = ProductCategorieModel::where('Categorie_ID','!=',$request->product_categorie_id)->where('User_ID',$request->user_id)->where('categorie_name',$request->categorie_name)->first();
            if ($get_categorie!='') {
                return response()->json([
                      'status' => false,
                      'message' => 'This Categorie name is already taken.',
                ], 402);
            }


            $product_type_details = ProductTypeModel::where(['id' => $request->product_type_id , 'User_ID' => $request->user_id])->first();
            if ($product_type_details) {
            
              $get_categorie = ProductCategorieModel::where(['User_ID' => $request->user_id,'product_type_id' => $request->product_type_id])->get();
            
              ProductCategorieModel::where('product_type_id', $request->product_type_id)->delete();
              if(!empty($get_categorie)){

                    $CategorieName = $request->categorie_name;
                    $User_id = $request->user_id;

                    
                    foreach ($CategorieName as $key => $value) {
                      $datapostproducts =array();
                      $datapostproducts['product_type_id'] = $product_type_details->id;
                      $datapostproducts['categorie_name'] = $CategorieName[$key];
                      $datapostproducts['User_ID'] = $User_id;
                      if ($request->User_id == '1') {
                        $datapostproducts['superadmin_id'] = $User_id; 
                        $datapostproducts['status'] = 1;
                      }else{
                        $datapostproducts['admin_id'] = $User_id;
                        $datapostproducts['status'] = 0; 
                      }
                      $last_id = ProductCategorieModel::create($datapostproducts);
                   
                    } 
                      
                     
                    return response()->json([
                      'status' => true,
                      'message' => 'Product Categorie updated succesfully',
                      // 'data' => $res_data,
                    ], 402);

              }else{
                   return response()->json([
                    'status' => false,
                    'message' => 'This Product Categorie is not exist for this user',
                  ], 402);
              }
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'This Product type is not exists',
                  ], 402);
            }  
         
      }else{
        $output['message'] = '405';
      } 
      echo json_encode($output);
      die;   

    }


    public function product_categorie_list(Request $request){
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

          $get_product_categories = ProductCategorieModel::where(['User_ID' => $request->user_id])->first();
          
          if ($get_product_categories) {
            $get_product_categories = ProductCategorieModel::where(['User_ID' => $request->user_id])->get();
              $data = array();
              foreach ($get_product_categories as $key => $value) {
                   $type['id'] = $value['Categorie_ID'];  
                   $type['name'] = $value['categorie_name'];
                   $type['product_type_id'] = $value['product_type_id'];
                   $type['product_type_name'] = '';
                   $get_product_types = ProductTypeModel::where(['id' => $value['product_type_id']])->first();
                   if ($get_product_types) {
                      $type['product_type_name'] = $get_product_types['name'];
                   } 
                   
                   $type['user_id'] = $value['User_ID'];
                   $type['status'] = $value['status'];  
                   // $type['source'] = $value['source']; 
                $data[] = $type;
              }

              // $data['types'] = $types;          
             
              return response()->json([
                'status' => true,
                'message' => 'Product Categorie list',
                'data' => $data,
              ], 402);
          }else{
              return response()->json([
                'status' => false,
                'message' => 'No Product categorie list for this user',
              ], 402);
          }
          

      }else{
        $output['message'] = '405';
      } 
      echo json_encode($output);
      die;   

    }


    public function product_categorie_delete(Request $request){
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

          $get_products_category = ProductCategorieModel::where(['User_ID' => $request->user_id,'product_type_id' => $request->product_type_id])->first();

       
          if ($get_products_category) {
             
             ProductCategorieModel::where(['User_ID' => $request->user_id,'product_type_id' => $request->product_type_id])->delete();
              return response()->json([
                'status' => true,
                'message' => 'Product category deleted sucessfully',
              ], 402);
          }else{
              return response()->json([
                'status' => false,
                'message' => 'No Product Category for this user',
              ], 402);
          }
          

      }else{
        $output['message'] = '405';
      } 
      echo json_encode($output);
      die;   

    }


}