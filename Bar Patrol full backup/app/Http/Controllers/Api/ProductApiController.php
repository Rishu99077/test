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
use App\Models\ProductsModel;
use App\Models\VendorModel;

class ProductApiController extends Controller
{

	  public function product_add(Request $request){
		   
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validator = Validator::make(
              $request->all(), 
              [   
                  'user_id' => 'required',
                  'product_name' => 'required',
                  'product_code' => 'required|unique:products',
                  'vendor_code' => 'required',
                  'product_type_id' => 'required',
                  'presentation' => 'required',
                  'product_categorie_id' => 'required',
                  'container_type' => 'required',
                  'container_size' => 'required',
                  'units' => 'required',
                  'vendor_id' => 'required',
              ]
            );

            if ($validator->fails()) {
                return response()->json([
                  'status' => false,
                  'message' => $validator->errors()->first(),
                ], 402);
            }

            $get_product = ProductsModel::where('User_ID',$request->user_id)->where('product_name',$request->product_name)->first();
            if ($get_product!='') {
              return response()->json([
                    'status' => false,
                    'message' => 'This product name is already exists',
              ], 402);
            } 

						
            $product_type_details = ProductTypeModel::where(['id' => $request->product_type_id , 'User_ID' => $request->user_id])->first();
            if ($product_type_details) {
                $product_categorie_details = ProductCategorieModel::where(['Categorie_ID' => $request->product_categorie_id , 'User_ID' => $request->user_id])->first();
                if ($product_categorie_details) {
                    $product_vendor_details = VendorModel::where(['VendorID' => $request->vendor_id , 'User_ID' => $request->user_id])->first();
                    if ($product_vendor_details) {

                            $data = array();
                            $data['product_name'] = $request->product_name; 
                            $data['product_code'] = $request->product_code;
                            $data['vendor_code'] = $request->vendor_code;
                            $data['product_type_id'] = $request->product_type_id;
                            $data['product_categorie_id'] = $request->product_categorie_id;

                            $data['container_type'] = $request->container_type;
                            $data['container_size'] = $request->container_size;
                            $data['presentation'] = $request->presentation;
                            $data['units'] = $request->units;
                            $data['vendor_id'] = $request->vendor_id;
                            $data['wholesale_container_price'] = '0';
                            if ($request->wholesale_container_price) {
                              $data['wholesale_container_price'] = $request->wholesale_container_price;
                            }
                            $data['retail_portion_price'] = '0';
                            if ($request->retail_portion_price) {
                              $data['retail_portion_price'] = $request->retail_portion_price;
                            }
                            $data['single_portion_size'] = $request->single_portion_size;
                            $data['single_portion_unit'] = $request->single_portion_unit;
                            $data['full_weight'] = '0';
                            if ($request->full_weight) {
                              $data['full_weight'] = $request->full_weight;
                            }
                            $data['empty_weight'] = '0';
                            if ($request->empty_weight) {
                              $data['empty_weight'] = $request->empty_weight;
                            }
                            $data['case_size'] = $request->case_size;
                            $data['par'] = $request->par;

                            $data['reorder_point'] = $request->reorder_point;
                            $data['order_by_the'] = $request->order_by_the;
                            $data['ideal_pour_cost'] = $request->ideal_pour_cost;

                            $data['User_ID'] = $request->user_id; 
                            if ($request->user_id == '1') {
                              $data['superadmin_id'] = $request->user_id; 
                              $data['status'] = 1;
                            }else{
                              $data['admin_id'] = $request->user_id;
                              $data['status'] = 0; 
                            }
                            $data['source'] = 'App'; 

                            $insert_id = ProductsModel::create($data);
                            
                            $res_data = array();
                            $res_data['product_id'] = $insert_id['id'];
                            $res_data['product_name'] = $request->product_name;
                            $res_data['product_type_id'] = $data['product_type_id'];
                            $res_data['product_categorie_id'] = $data['product_categorie_id'];
                            $res_data['vendor_code'] = $data['vendor_code'];
                            $res_data['vendor_id'] = $data['vendor_id'];
                            $res_data['user_id'] = $data['User_ID'];
                            $res_data['source'] = $data['source'];

                            return response()->json([
                              'status' => true,
                              'message' =>'Product added successfully',
                              'data' => $res_data,
                            ], 402);
            
                    }else{
                        return response()->json([
                          'status' => false,
                          'message' => 'This Vendor is not exist for this user',
                        ], 402);
                    }
                }else{
                    return response()->json([
                      'status' => false,
                      'message' => 'This Product Categorie is not exist for this user',
                    ], 402);
                }
            }else{
                return response()->json([
                  'status' => false,
                  'message' => 'This Product type is not exist for this user',
                ], 402);
            }



            $product_details = ProductsModel::where(['User_ID' => $request->user_id])->first();
            if ($product_details) {

            }else{
                return response()->json([
                  'status' => false,
                  'message' => 'This Product is not exist for this user',
                ], 402);
            }
        }else{
          $output['message'] = '405';
        } 
       echo json_encode($output);
       die;   
  	
    }

    public function product_detail(Request $request){
    
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validator = Validator::make(
              $request->all(), 
              [
                  'product_id' => 'required',
                  'user_id' => 'required',
              ]
            );

            if ($validator->fails()) {
                return response()->json([
                  'status' => false,
                  'message' => $validator->errors()->first(),
                ], 402);
            }

            $get_single_product = ProductsModel::where(['ProductID' => $request->product_id , 'User_ID' => $request->user_id])->first();
            
            if ($get_single_product) {
              $res_data = array();
              $res_data['product_id'] = $get_single_product->ProductID;
              $res_data['product_name'] = $get_single_product->product_name; 
              $res_data['product_code'] = $get_single_product->product_code;
              $res_data['vendor_code'] = $get_single_product->vendor_code;
              $res_data['product_type_id'] = $get_single_product->product_type_id;
              $res_data['product_type_name'] = '';
              $type_details = ProductTypeModel::where(['id' => $get_single_product->product_type_id])->first();
              if ($type_details) {
                $res_data['product_type_name'] = $type_details['name'];
              }

              $res_data['product_categorie_id'] = $get_single_product->product_categorie_id;
              $res_data['product_categorie_name'] = '';
              $categorie_details = ProductCategorieModel::where(['Categorie_ID' => $get_single_product->product_categorie_id])->first();
              if ($categorie_details) {
                $res_data['product_categorie_name'] = $categorie_details['categorie_name'];
              }

              $res_data['container_type'] = $get_single_product->container_type;
              $res_data['container_size'] = $get_single_product->container_size;
              $res_data['presentation'] = $get_single_product->presentation;
              $res_data['units'] = $get_single_product->units;
              $res_data['vendor_id'] = $get_single_product->vendor_id;
              $res_data['vendor_name'] = '';
              $vendor_details = VendorModel::where(['VendorID' => $get_single_product->vendor_id])->first();
              if ($vendor_details) {
                $res_data['vendor_name'] = $vendor_details['vendor_name'];
              }

              $res_data['wholesale_container_price'] = $get_single_product->wholesale_container_price;
              $res_data['retail_portion_price'] = $get_single_product->retail_portion_price;
            
              $res_data['quantity'] = '';
              if ($get_single_product->quantity) {
                  $res_data['quantity'] = $get_single_product->quantity;
              }
              $res_data['single_portion_size'] = '';
              if ($get_single_product->single_portion_size) {
                  $res_data['single_portion_size'] = $get_single_product->single_portion_size;
              }
              $res_data['single_portion_unit'] = '';
              if ($get_single_product->single_portion_unit) {
                  $res_data['single_portion_unit'] = $get_single_product->single_portion_unit;
              }

              $res_data['full_weight'] = $get_single_product->full_weight;
              $res_data['empty_weight'] = $get_single_product->empty_weight;
              
              $res_data['case_size'] = '';
              if ($get_single_product->case_size) {
                  $res_data['case_size'] = $get_single_product->case_size;
              }
              $res_data['par'] = '';
              if ($get_single_product->par) {
                  $res_data['par'] = $get_single_product->par;
              }

              $res_data['reorder_point'] = '';
              if ($get_single_product->reorder_point) {
                $res_data['reorder_point'] = $get_single_product->reorder_point;
              }
              $res_data['order_by_the'] = '';
              if ($get_single_product->reorder_point) {
                $res_data['order_by_the'] = $get_single_product->order_by_the;
              }
              $res_data['ideal_pour_cost'] = '';
              if ($get_single_product->reorder_point) {
                $res_data['ideal_pour_cost'] = $get_single_product->ideal_pour_cost;
              }
              $res_data['source'] = '';
              if ($get_single_product->reorder_point) {
                $res_data['source'] = $get_single_product->source;
              }
              
            }else{
                return response()->json([
                  'status' => false,
                  'message' => 'This Product is not exist',
                ], 402);
            }
           
         
            return response()->json([
              'status' => true,
              'message' =>'Product detail',
              'data' => $res_data,
            ], 402);
        }else{
          $output['message'] = '405';
        } 
       echo json_encode($output);
       die;   
    
    }

    public function product_update(Request $request){
      $output=array();
      $output['status']=false;
      if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

          $validator = Validator::make(
            $request->all(), 
            [
                'product_id' => 'required',
                'user_id' => 'required',
                'product_name' => 'required',
            ]
          );

          if ($validator->fails()) {
              return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
              ], 402);
          }

          $get_product = ProductsModel::where('ProductID','!=',$request->product_id)->where('User_ID',$request->user_id)->where('product_name',$request->product_name)->first();

          if ($get_product!='') {
              return response()->json([
                    'status' => false,
                    'message' => 'This product name is already taken',
              ], 402);
          }

          $product_type_details = ProductTypeModel::where(['id' => $request->product_type_id , 'User_ID' => $request->user_id])->first();
          if ($product_type_details) {
            $product_categorie_details = ProductCategorieModel::where(['Categorie_ID' => $request->product_categorie_id , 'User_ID' => $request->user_id])->first();
            if ($product_categorie_details) {
                $product_vendor_details = VendorModel::where(['VendorID' => $request->vendor_id , 'User_ID' => $request->user_id])->first();
                if ($product_vendor_details) {
                    $get_single_product = ProductsModel::where(['User_ID' => $request->user_id,'ProductID' => $request->product_id])->first();
                    if($get_single_product!=''){
                          $data = array();
                          $data['product_name'] = $request->product_name;
                          $data['vendor_code'] = $request->vendor_code;
                          $data['product_type_id'] = $request->product_type_id;
                          $data['product_categorie_id'] = $request->product_categorie_id;
                          $data['container_type'] = $request->container_type;
                          $data['container_size'] = $request->container_size;
                          $data['units'] = $request->units;
                          $data['presentation'] = $request->presentation;  
                          $data['vendor_id'] = $request->vendor_id;
                          $data['wholesale_container_price'] = '0';
                          if ($request->wholesale_container_price) {
                            $data['wholesale_container_price'] = $request->wholesale_container_price;
                          }
                          $data['retail_portion_price'] = '0';
                          if ($request->retail_portion_price) {
                            $data['retail_portion_price'] = $request->retail_portion_price;
                          }
                          $data['single_portion_size'] = $request->single_portion_size;
                          $data['single_portion_unit'] = $request->single_portion_unit;
                          $data['full_weight'] = '0';
                          if ($request->full_weight) {
                            $data['full_weight'] = $request->full_weight;
                          }
                          $data['empty_weight'] = '0';
                          if ($request->empty_weight) {
                            $data['empty_weight'] = $request->empty_weight;
                          }
                          $data['case_size'] = $request->case_size;
                          $data['par'] = $request->par;
                          $data['reorder_point'] = $request->reorder_point;
                          $data['order_by_the'] = $request->order_by_the;
                          $data['ideal_pour_cost'] = $request->ideal_pour_cost;
                          

                          ProductsModel::where('ProductID', $get_single_product['ProductID'])->update($data);
                          
                          $get_single_product = ProductsModel::where(['User_ID' => $request->user_id,'ProductID' => $request->product_id])->first();

                          $res_data = array();
                          $res_data['product_id'] = $get_single_product->ProductID;
                          $res_data['product_name'] = $get_single_product->product_name;
                          $res_data['vendor_code'] = $get_single_product->vendor_code;
                          $res_data['product_type_id'] = $get_single_product->product_type_id;
                          $res_data['product_categorie_id'] = $get_single_product->product_categorie_id;

                        
                          return response()->json([
                            'status' => true,
                            'message' => 'Product updated succesfully',
                            'data' => $res_data,
                          ], 402);

                    }else{
                         return response()->json([
                          'status' => false,
                          'message' => 'This Product is not exist for this user',
                        ], 402);
                    }
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'This Vendor is not exist for this user',
                      ], 402);
                }
            }else{
              return response()->json([
                      'status' => false,
                      'message' => 'This Product Categorie is not exist for this user',
                    ], 402);
            }
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

    public function product_quantity_update(Request $request){
      $output=array();
      $output['status']=false;
      if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

          $validator = Validator::make(
            $request->all(), 
            [
                'product_id' => 'required',
                'user_id' => 'required',
                'container_type' => 'required',
                'quantity' => 'required',
            ]
          );

          if ($validator->fails()) {
              return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
              ], 402);
          }

          $get_product = ProductsModel::where('ProductID','!=',$request->product_id)->where('product_name',$request->product_name)->first();
          if ($get_product!='') {
              return response()->json([
                    'status' => false,
                    'message' => 'This product name is already taken',
              ], 402);
          }else{
              $get_single_product = ProductsModel::where(['User_ID' => $request->user_id,'ProductID' => $request->product_id])->first();
              if($get_single_product!=''){
                    $data = array();
                    
                    $data['container_type'] = $request->container_type;
                    $data['quantity'] = $request->quantity;
                   
                    ProductsModel::where('ProductID', $get_single_product['ProductID'])->update($data);
                    
                    $get_single_product = ProductsModel::where(['User_ID' => $request->user_id,'ProductID' => $request->product_id])->first();

                    $res_data = array();
                    $res_data['product_id'] = $get_single_product->ProductID;
                    $res_data['product_name'] = $get_single_product->product_name;
                    $res_data['container_type'] = $get_single_product->container_type;
                    $res_data['quantity'] = $get_single_product->quantity;

                  
                    return response()->json([
                      'status' => true,
                      'message' => 'Product quantity updated succesfully',
                      'data' => $res_data,
                    ], 402);

              }else{
                   return response()->json([
                    'status' => false,
                    'message' => 'This Product is not exist for this user',
                  ], 402);
              }
          }  
      }else{
        $output['message'] = '405';
      } 
      echo json_encode($output);
      die;   

    }

    public function product_list(Request $request){
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

          $get_products = ProductsModel::where(['User_ID' => $request->user_id])->first();
        
          if ($get_products) {
              $get_products = ProductsModel::where(['User_ID' => $request->user_id])->get();
              $data = array();
              foreach ($get_products as $key => $value) {
                
                 $row['product_id'] = $value['ProductID'];  
                 $row['product_name'] = $value['product_name'];
                 $row['product_code'] = $value['product_code'];
                 $row['vendor_code'] = $value['vendor_code'];  
                 $row['product_type_id'] = $value['product_type_id'];
                 $row['product_type_name'] = '';
                 $get_product_types = ProductTypeModel::where(['id' => $value['product_type_id']])->first();
                 if ($get_product_types) {
                    $row['product_type_name'] = $get_product_types['name'];
                 } 
                 $row['product_categorie_id'] = $value['product_categorie_id'];
                 $row['product_categorie_name'] = '';
                 $get_product_categorie = ProductCategorieModel::where(['Categorie_ID' => $value['product_categorie_id']])->first();
                 if ($get_product_categorie) {
                    $row['product_categorie_name'] = $get_product_categorie['categorie_name'];
                 } 

                  $row['container_type'] = $value['container_type'];  
                  $row['container_size'] = $value['container_size'];
                  $row['presentation'] = $value['presentation'];
                  $row['units'] = $value['units'];

                  $row['wholesale_container_price'] = $value['wholesale_container_price']; 
                  $row['retail_portion_price'] = $value['retail_portion_price'];
                  
                  
                  $row['single_portion_size'] = '';
                  if ($value['single_portion_size']) {
                    $row['single_portion_size'] = $value['single_portion_size'];
                  }
                  $row['single_portion_unit'] = '';
                  if ($value['single_portion_unit']) {
                    $row['single_portion_unit'] = $value['single_portion_unit'];  
                  }
                  $row['full_weight'] = '';
                  if ($value['full_weight']) {
                    $row['full_weight'] = $value['full_weight'];
                  }
                  $row['empty_weight'] = '';
                  if ($value['empty_weight']) {
                    $row['empty_weight'] = $value['empty_weight'];  
                  }
                  $row['case_size'] = '';
                  if ($value['case_size']) {
                    $row['case_size'] = $value['case_size']; 
                  }

                  $row['vendor_id'] = $value['vendor_id']; 

                  $row['vendor_name'] = '';
                  $get_single_vendor = VendorModel::where(['VendorID' => $value['vendor_id']])->first();
                  if ($get_single_vendor) {
                      $row['vendor_name'] = $get_single_vendor['vendor_name'];
                  } 

                  $row['par'] = '';
                  if ($value['par']) {
                     $row['par'] = $value['par'];
                  }
                  $row['reorder_point'] = '';
                  if ($value['reorder_point']) {
                     $row['reorder_point'] = $value['reorder_point'];
                  }
                  $row['order_by_the'] = '';
                  if ($value['order_by_the']) {
                   $row['order_by_the'] = $value['order_by_the'];
                  }
                  $row['ideal_pour_cost'] = '';
                  if ($value['ideal_pour_cost']) { 
                   $row['ideal_pour_cost'] = $value['ideal_pour_cost'];
                  } 
                  $row['user_id'] = $value['User_ID'];
                  $row['source'] = $value['source']; 
                 
                 $data[] = $row; 
              }
         
             
              return response()->json([
                'status' => true,
                'message' => 'Product list',
                'data' => $data,
              ], 402);
          }else{
              return response()->json([
                'status' => false,
                'message' => 'No Product list for this user',
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
                'product_id' => 'required',
                'user_id' => 'required',
            ]
          );

          if ($validator->fails()) {
              return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
              ], 402);
          }

          $get_products = ProductsModel::where(['User_ID' => $request->user_id,'ProductID' => $request->product_id])->first();
       
          if ($get_products) {
             
              ProductsModel::where(['User_ID' => $request->user_id,'ProductID' => $request->product_id])->delete();
             
              return response()->json([
                'status' => true,
                'message' => 'Product deleted sucessfully',
              ], 402);
          }else{
              return response()->json([
                'status' => false,
                'message' => 'No Product list for this user',
              ], 402);
          }
          

      }else{
        $output['message'] = '405';
      } 
      echo json_encode($output);
      die;   

    }


}