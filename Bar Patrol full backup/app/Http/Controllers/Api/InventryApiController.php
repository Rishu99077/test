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
use App\Models\UserModel;
use App\Models\LocationsModel;
use App\Models\OrderModel;
use App\Models\PurchaseOrderModel;
use App\Models\ProductsModel;
use App\Models\VendorModel;
use App\Models\InventriesModel;
use App\Models\InventriesProductModel;


class InventryApiController extends Controller
{

   
    public function add_inventry(Request $request){
		
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validator = Validator::make(
              $request->all(), 
              [
                  'location_id' => 'required',
                  'product_id' => 'required',
                  'vendor_id'=> 'required',
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
            $get_single_product = ProductsModel::where(['ProductID' => $request->product_id,'User_ID' => $request->user_id])->first();  
            $get_single_vendor = VendorModel::where(['VendorID' => $request->vendor_id,'User_ID' => $request->user_id])->first();
          
            if ($get_single_location && $get_single_vendor && $get_single_product) {
                  
                  $location_name = $get_single_location->location_name;

                  $data = array();
                  $data['location_id'] = $request->location_id;
                  $data['location'] = $location_name; 
                  $data['description'] = '';
                  if ($request->description) {
                    $data['description'] = $request->description;
                  }
                  $data['date'] = date('Y-m-d H:i:s'); 
                  $data['inventrie_notes'] = '';
                  if ($request->inventrie_notes) {
                    $data['inventrie_notes'] = $request->inventrie_notes;
                  }
                  $data['vendor_id'] = $request->vendor_id;
                  $data['User_ID'] = $request->user_id;

                  
                  $insert_id = InventriesModel::create($data);

                  $inventries = array();
                  $inventry['location_id'] = $data['location_id'];
                  $inventry['location'] = $data['location'];
                  $inventry['description'] = $data['description'];
                  $inventry['date'] = $data['date'];
                  $inventry['inventrie_notes'] = $data['inventrie_notes'];
                  $inventry['vendor_id'] = $data['vendor_id'];
                  
                  $Product_Id = $request->product_id;
                  $Product_name = $request->product_name;
                  // $Location_Id = $request->location_id;
                  // $Location_name = $location_name;
                  $Quantity_type = $request->quantity_type;
                  $Case_size = $request->case_size;
                  $Quantity = $request->quantity;
                  $Weight = $request->weight;
                  $Whole_sale_value = $request->whole_sale_value;
                  $Retail_value = $request->retail_value;
                  $User_id = $request->user_id;


                  foreach ($Quantity_type as $key => $value) {
                    $datapostproducts =array();
                    $datapostproducts['InventryID'] = $insert_id['id'];
                    $datapostproducts['product_id'] = $Product_Id[$key];
                    $get_product = ProductsModel::where(['ProductID' => $Product_Id[$key]])->first();
                    $datapostproducts['product_name'] = $get_product['product_name'];

                    $datapostproducts['location_id'] = $request->location_id;
                    $get_location = LocationsModel::where(['LocationID' => $request->location_id])->first();
                    $datapostproducts['location_name'] = $get_location['location_name'];

                    $datapostproducts['quantity_type'] = $Quantity_type[$key];
                    $datapostproducts['case_size'] = $Case_size[$key];
                    $datapostproducts['quantity'] = $Quantity[$key];
                    $datapostproducts['weight'] = $Weight[$key];
                    $datapostproducts['whole_sale_value'] = $Whole_sale_value[$key];
                    $datapostproducts['retail_value'] = $Retail_value[$key];
                    $datapostproducts['User_ID'] = $User_id;

                    $last_id = InventriesProductModel::create($datapostproducts);
                    $get_inventries_products = InventriesProductModel::where(['InventryID' => $last_id['InventryID']])->get();
                    
                    
                    $products = array();
                    foreach ($get_inventries_products as $key => $value_pro) {
                      $prod['product_name'] = $value_pro['product_name'];
                      $prod['location_name'] = $value_pro['location_name'];
                      $prod['quantity_type'] = $value_pro['quantity_type'];
                      $prod['case_size'] = $value_pro['case_size'];
                      $prod['quantity'] = $value_pro['quantity'];
                      $prod['weight'] = $value_pro['weight'];
                      $prod['whole_sale_value'] = $value_pro['whole_sale_value'];
                      $prod['retail_value'] = $value_pro['retail_value'];
                      $products[] = $prod;
                    }
                    $inventry['products'] = $products;
                    
                  } 
                  $inventries[] = $inventry;

              

                  return response()->json([
                    'status' => true,
                    'message' =>'Inventrie added successfully',
                    'data' => $inventries,
                  ], 402);    


            }else{
                return response()->json([
                  'status' => false,
                  'message' => 'This location or vendor is not exist',
                ], 402);
            }
	         
        }else{
          $output['message'] = '405';
        } 
       echo json_encode($output);
       die;   
  	
    }


    public function all_inventries(Request $request){
    
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
            $get_inventries = InventriesModel::where(['User_ID' => $request->user_id])->orderBy('InventryID', 'desc')->get();

            if (count($get_inventries)>0) {

                $inventries = array();
                foreach ($get_inventries as $key => $value) {
                    $inventry = array();

                    $inventry['inventry_id'] = $value['InventryID'];
                    $inventry['inventry_location'] = $value['location'];
                    $inventry['description'] = $value['description'];
                    $inventry['datetime'] = $value['date'];
                    $inventry['date'] = date("Y-m-d",strtotime($value['date']));
                    $inventry['time'] = date("H:i:s",strtotime($value['date']));
                    $inventry['vendor_name'] = '';
                    $inventry['inventrie_notes'] = '';

                    if ($value['vendor_id']!='') {
                      $get_vendor = VendorModel::where(['VendorID' => $value['vendor_id']])->first();
                      $inventry['vendor_name'] = @$get_vendor['vendor_name'];
                    }
                    if ($value['inventrie_notes']!=''){
                      $inventry['inventrie_notes'] = $value['inventrie_notes'];
                    }
                    $get_inventries_products = InventriesProductModel::where(['InventryID' => $value['InventryID']])->get();
                    $products = array();
                    $location = array();
                    foreach ($get_inventries_products as $key => $value_pro) {
                      $prod['product_name'] = $value_pro['product_name'];
                      $prod['location_name'] = $value_pro['location_name'];
                      $prod['quantity_type'] = $value_pro['quantity_type'];
                      $prod['case_size'] = $value_pro['case_size'];
                      $prod['quantity'] = $value_pro['quantity'];
                      $prod['weight'] = $value_pro['weight'];
                      $prod['whole_sale_value'] = $value_pro['whole_sale_value'];
                      $products[] = $prod;
                      $location[$value_pro['location_name']] = $prod;
                    }
                    $inventry['products'] = count($products);
                    $inventry['location'] = count($location);
                    $inventries[] = $inventry;
                }

                return response()->json([
                  'status' => true,
                  'message' =>'All Inventry detail',
                  'data' => $inventries,
                ], 402);
            }else{
                return response()->json([
                  'status' => false,
                  'message' => 'No inventries',
                ], 402);
            }
        
        }else{
          $output['message'] = '405';
        } 
       echo json_encode($output);
       die;   
    
    }


    public function view_inventry_detail(Request $request){
    
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validator = Validator::make(
              $request->all(), 
              [
                  'user_id' => 'required',
                  'inventry_id' => 'required',
              ]
            );

            if ($validator->fails()) {
                return response()->json([
                  'status' => false,
                  'message' => $validator->errors()->first(),
                ], 402);
            }
            $get_inventries = InventriesModel::where(['User_ID' => $request->user_id,'InventryID' => $request->inventry_id])->orderBy('InventryID', 'desc')->first();

            if ($get_inventries) {

                    $inventry = array();
                    $inventry['inventry_id'] = $get_inventries['InventryID'];
                    $inventry['location'] = $get_inventries['location'];
                    $inventry['description'] = $get_inventries['description'];
                    $inventry['datetime'] = $get_inventries['date'];
                    $inventry['date'] = date("Y-m-d",strtotime($get_inventries['date']));
                    $inventry['time'] = date("H:i:s",strtotime($get_inventries['date']));
    
                    $inventry['vendor_name'] = '';
                    $inventry['inventrie_notes'] = '';

                    if ($get_inventries['vendor_id']!='') {
                      $get_vendor = VendorModel::where(['VendorID' => $get_inventries['vendor_id']])->first();
                      $inventry['vendor_name'] = @$get_vendor['vendor_name'];
                    }
                    if ($get_inventries['inventrie_notes']!=''){
                      $inventry['inventrie_notes'] = $get_inventries['inventrie_notes'];
                    }
                
                    $get_inventries_products = InventriesProductModel::where(['InventryID' => $get_inventries['InventryID']])->get();

                    $Getlocations = array();
                    foreach ($get_inventries_products as $key => $value_pro) {
                      $prod['product_name'] = $value_pro['product_name'];
                      $prod['location_name'] = $value_pro['location_name'];
                      $prod['quantity_type'] = $value_pro['quantity_type'];
                      $prod['case_size'] = $value_pro['case_size'];
                      $prod['quantity'] = $value_pro['quantity'];
                      $prod['weight'] = $value_pro['weight'];
                      $prod['whole_sale_value'] = $value_pro['whole_sale_value'];
                      $Getlocations[$value_pro['location_name']][] = $prod;
                    }

                    $locations = array();
                    foreach ($Getlocations as $key => $value_locations) {
                      $get_single_location = LocationsModel::where(['location_name' => $key])->first();
                      if($get_single_location){
                          $location = array();
                          $location['location_id'] = $get_single_location->LocationID;
                          $location['location_name'] = $key;
                          $location['products'] = count($value_locations);
                          $locations[] = $location;
                      }
                    }

                    $inventry['locations'] = $locations;
              

                return response()->json([
                  'status' => true,
                  'message' =>'Single Inventry detail',
                  'data' => $inventry,
                ], 402);
            }else{
                return response()->json([
                  'status' => false,
                  'message' => 'The Inventry is not done',
                ], 402);
            }
        
        }else{
          $output['message'] = '405';
        } 
       echo json_encode($output);
       die;   
    
    }

    public function add_inventry_products(Request $request){
    
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validator = Validator::make(
              $request->all(), 
              [
                  'location_id' => 'required',
                  'inventry_id'=> 'required',
                  'product_id'=> 'required',
                  'user_id' => 'required',
              ]
            );

            if ($validator->fails()) {
                return response()->json([
                  'status' => false,
                  'message' => $validator->errors()->first(),
                ], 402);
            }
            
            $get_products = ProductsModel::where(['ProductID' => $request->product_id,'User_ID'=> $request->user_id])->first();
            if ($get_products) {
                return response()->json([
                  'status' => false,
                  'message' => 'This product not found',
                ], 402);
            }

            $get_inventry = InventriesModel::where(['InventryID' => $request->inventry_id,'User_ID' => $request->user_id])->first();
            if ($get_inventry) {

                  $data = array();
                  $data['location_name'] = '';
                  $get_location = LocationsModel::where(['LocationID' => $request->location_id])->first();
                  if ($get_location) {
                    $data['location_name'] = $get_location['location_name']; 
                  }
                  $get_products = ProductsModel::where(['ProductID' => $request->product_id])->first();
                
                  if ($get_products) {
                    $data['product_name'] = $get_products['product_name']; 
                    $data['quantity_type'] = $get_products['container_type']; 
                    $data['case_size'] = $get_products['case_size']; 
                    $data['quantity'] = 'test'; 
                    $data['weight'] = $get_products['full_weight']; 
                    $data['whole_sale_value'] = $get_products['wholesale_container_price']; 
                    $data['retail_value'] = $get_products['retail_portion_price']; 

                  }
                  $data['InventryID'] = $request->inventry_id;  
                  $data['User_ID'] = $request->user_id;
                  $insert_id = InventriesProductModel::create($data);

                  return response()->json([
                    'status' => true,
                    'message' =>'Inventrie added successfully',
                    // 'data' => $inventries,
                  ], 402);    


            }else{
                return response()->json([
                  'status' => false,
                  'message' => 'This Inventry not found',
                ], 402);
            }
           
        }else{
          $output['message'] = '405';
        } 
       echo json_encode($output);
       die;   
    
    }


    public function edit_inventry(Request $request){
    
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validator = Validator::make(
              $request->all(), 
              [
                  'inventry_id' => 'required',
                  'product_id' => 'required',
                  'location_id' => 'required',
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
            
            $get_single_location = LocationsModel::where(['LocationID' => $request->location_id,'User_ID' => $request->user_id])->first();
            
            $get_inventrie = InventriesModel::where(['InventryID' => $request->inventry_id])->first();
            $get_single_product = ProductsModel::where(['ProductID' => $request->product_id,'User_ID' => $request->user_id])->first();  

            if ($get_inventrie && $get_single_location && $get_single_product) {        
                  $location_name = $get_single_location->location_name;

                  $data = array();
                  $data['location_id'] = $request->location_id;
                  $data['location'] = $location_name; 
                  $data['description'] = '';
                  if ($request->description) {
                    $data['description'] = $request->description;
                  }
                  $data['date'] = date('Y-m-d H:i:s'); 
                  $data['inventrie_notes'] = '';
                  if ($request->inventrie_notes) {
                    $data['inventrie_notes'] = $request->inventrie_notes;
                  }
                  $data['vendor_id'] = $request->vendor_id;
                  $data['User_ID'] = $request->user_id;

                  
                  InventriesModel::where('InventryID', $get_inventrie['InventryID'])->update($data);

                  $get_inventries_products = InventriesProductModel::where(['InventryID' => $request->inventry_id])->get();
                  $inventries = array();
                  $inventry['location'] = $data['location'];
                  $inventry['description'] = $data['description'];
                  $inventry['date'] = $data['date'];
                  $inventry['inventrie_notes'] = $data['inventrie_notes'];
                  $inventry['vendor_id'] = $data['vendor_id'];
                  
                  $Product_Id = $request->product_id;
                  $Product_name = $request->product_name;
                  // $Location_name = $location_name;
                  $Quantity_type = $request->quantity_type;
                  $Case_size = $request->case_size;
                  $Quantity = $request->quantity;
                  $Weight = $request->weight;
                  $Whole_sale_value = $request->whole_sale_value;
                  $Retail_value = $request->retail_value;
                  $User_id = $request->user_id;

                  InventriesProductModel::where('InventryID', $get_inventrie['InventryID'])->delete();
                  foreach ($Quantity_type as $key => $value) {
                      $datapostproducts =array();
                      $datapostproducts['InventryID'] = $get_inventrie['InventryID'];

                      $datapostproducts['product_id'] = $Product_Id[$key];
                      $get_product = ProductsModel::where(['ProductID' => $Product_Id[$key]])->first();
                      $datapostproducts['product_name'] = $get_product['product_name'];

                      $datapostproducts['location_id'] = $request->location_id;
                      $get_location = LocationsModel::where(['LocationID' => $request->location_id])->first();
                      $datapostproducts['location_name'] = $get_location['location_name'];

                      $datapostproducts['quantity_type'] = $Quantity_type[$key];
                      $datapostproducts['case_size'] = $Case_size[$key];
                      $datapostproducts['quantity'] = $Quantity[$key];
                      $datapostproducts['weight'] = $Weight[$key];
                      $datapostproducts['whole_sale_value'] = $Whole_sale_value[$key];
                      $datapostproducts['retail_value'] = $Retail_value[$key];
                      $datapostproducts['User_ID'] = $User_id;

                      $last_id = InventriesProductModel::create($datapostproducts);                      
                    
                  } 
                  
                  $get_inventries_products = InventriesProductModel::where(['InventryID' => $get_inventrie['InventryID']])->get();
                  $products = array();
                  foreach ($get_inventries_products as $key => $value_pro) {
                      $prod['product_name'] = $value_pro['product_name'];
                      $prod['location_name'] = $value_pro['location_name'];
                      $prod['quantity_type'] = $value_pro['quantity_type'];
                      $prod['case_size'] = $value_pro['case_size'];
                      $prod['quantity'] = $value_pro['quantity'];
                      $prod['weight'] = $value_pro['weight'];
                      $prod['whole_sale_value'] = $value_pro['whole_sale_value'];
                      $prod['retail_value'] = $value_pro['retail_value'];
                      $products[] = $prod;
                  }
                  $inventry['products'] = $products;
                  $inventries[] = $inventry;

              

                  return response()->json([
                    'status' => true,
                    'message' =>'Inventrie Updated successfully',
                    'data' => $inventries,
                  ], 402);    


            }else{
                return response()->json([
                  'status' => false,
                  'message' => 'This location or vendor is not exist',
                ], 402);
            }
           
        }else{
          $output['message'] = '405';
        } 
       echo json_encode($output);
       die;   
    
    }

    public function inventry_locations(Request $request){

        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validator = Validator::make(
              $request->all(), 
              [
                  'inventry_id' => 'required',
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
              $data['datetime'] = $get_location->created_at;
              $data['date'] = date("Y-m-d",strtotime($get_location->created_at));
              $data['time'] = date("H:i:s",strtotime($get_location->created_at));

              $data['status'] = $get_location->status;   
              $data['source'] = $get_location->source;

              $get_inventries_products = InventriesProductModel::where(['location_id' => $get_location->LocationID,'InventryID' => $request->inventry_id])->get()->toArray();
             
              $products = array();
              foreach ($get_inventries_products as $key => $value_pro) {
                $prod = array();
                $ProductsModel = ProductsModel::where(['ProductID' => $value_pro['product_id']])->first();
                $prod['product_id'] = '';
                if($ProductsModel){
                  $prod['product_id'] = $ProductsModel->ProductID;
                }
                $prod['product_name'] = $value_pro['product_name'];
                $prod['location_name'] = $value_pro['location_name'];
                $prod['quantity_type'] = $value_pro['quantity_type'];
                $prod['case_size'] = $value_pro['case_size'];
                $prod['quantity'] = $value_pro['quantity'];
                $prod['weight'] = $value_pro['weight'];
                $prod['whole_sale_value'] = $value_pro['whole_sale_value'];
                $prod['retail_value'] = $value_pro['retail_value'];
                $prod['date'] = date("Y-m-d",strtotime($value_pro['created_at']));
                if($ProductsModel){
                  $products[] = $prod;
                }
              }
              $data['products'] = $products;
              $data['products_count'] = count($products);
   

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

    

}