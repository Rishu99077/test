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
use App\Models\OrderModel;
use App\Models\PurchaseOrderModel;
use App\Models\ProductsModel;
use App\Models\VendorModel;

class OrderApiController extends Controller
{

   
    public function add_order(Request $request){
		
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validator = Validator::make(
              $request->all(), 
              [
                  'product_id' => 'required',
                  'order_by'=> 'required',
                  'quantity'=> 'required',
                  'wholesale_value'=> 'required', 
                  'user_id' => 'required',

              ]
            );

            if ($validator->fails()) {
                return response()->json([
                  'status' => false,
                  'message' => $validator->errors()->first(),
                ], 402);
            }
						  
            $get_single_product = ProductsModel::where(['ProductID' => $request->product_id])->first();
            if ($get_single_product) {
                  

                  $data = array();
                  $data['product_id'] = $request->product_id; 
                  $data['product_name'] = $get_single_product->product_name; 
                  $data['vendor_id'] = $get_single_product->vendor_id; 
                  $data['OrderID'] = $get_single_product->vendor_id;
                  $data['order_by'] = $request->order_by; 
                  $data['case_size'] = '';
                  if ($request->case_size) {
                    $data['case_size'] = $request->case_size; 
                  }
                  $data['quantity'] = $request->quantity; 
                  $data['wholesale_value'] = $request->wholesale_value; 
                  $data['User_ID'] = $request->user_id; 
                  $data['order_status'] = 0; 
                  // $data['source'] = 'App'; 

                  $getvendors_id = PurchaseOrderModel::where(['User_ID' => $request->user_id,'vendor_id' => $get_single_product->vendor_id])->get()->toArray();
                  // echo "<pre>"; 
                  // print_r($getvendors_id);
                  // echo "</pre>";
                  // die();
                  if (empty($getvendors_id)) {
                      $datapost =array();
                      $datapost['Order'] = $get_single_product->vendor_id;
                      $datapost['User_ID'] = $request->user_id;
                      $last_order_id = OrderModel::create($datapost);
                  }

                  $insert_id = PurchaseOrderModel::create($data);
               
                  $res_data = array();
                  $res_data['order_id'] = $insert_id['id'];
                  $res_data['product_name'] = $data['product_name']; 
                  $res_data['case_size'] = $data['case_size']; 
                  $res_data['quantity'] = $data['quantity']; 
                  $res_data['wholesale_value'] = $data['wholesale_value'];
                  $res_data['user_id'] = $data['User_ID']; 
                 
                  return response()->json([
                    'status' => true,
                    'message' =>'Order added successfully',
                    'data' => $res_data,
                  ], 402);    


            }else{
                return response()->json([
                  'status' => false,
                  'message' => 'This Product is not exist',
                ], 402);
            }
	         
        }else{
          $output['message'] = '405';
        } 
       echo json_encode($output);
       die;   
  	
    }


    public function purchase_order_detail(Request $request){
    
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validator = Validator::make(
              $request->all(), 
              [
                  // 'vendor_id' => 'required',
                  'user_id' => 'required',
              ]
            );

            if ($validator->fails()) {
                return response()->json([
                  'status' => false,
                  'message' => $validator->errors()->first(),
                ], 402);
            }
            $get_order = OrderModel::where(['User_ID' => $request->user_id,'order_status' => '0'])->get();

            if (count($get_order)>0) {
                $main_data = array();
                foreach ($get_order as $key => $value) {
                    $get_purchaseorder = PurchaseOrderModel::where(['User_ID' => $request->user_id,'OrderID' => $value['Order'],'order_status' => '0'])->get();
                    $res_data = array();
                    foreach ($get_purchaseorder as $key => $value_pur) {
                      $data['vendor_name'] = '';
                      $get_vendor = VendorModel::where(['VendorID' => $value_pur['vendor_id']])->first();
                      if ($get_vendor) {
                         $data['vendor_name'] = $get_vendor['vendor_name'];
                      }
                      $data['purchase_id'] = $value_pur['PurchaseID'];
                      $data['order_id'] = $value_pur['OrderID'];
                      $data['product_id'] = $value_pur['product_id'];
                      $data['product_name'] = $value_pur['product_name'];
                      $data['order_by'] = $value_pur['order_by'];
                      $data['vendor_id'] = $value_pur['vendor_id'];
                      $data['case_size'] = $value_pur['case_size'];
                      $data['quantity'] = $value_pur['quantity'];
                      $data['wholesale_value'] = $value_pur['wholesale_value'];

                      $res_data[] = $data;
                    }
                $main_data[] = $res_data;
                }  

                return response()->json([
                  'status' => true,
                  'message' =>'Order detail',
                  'data' => $main_data,
                ], 402);
            }else{
                return response()->json([
                  'status' => false,
                  'message' => 'This Order is not exist',
                ], 402);
            }
        
        }else{
          $output['message'] = '405';
        } 
       echo json_encode($output);
       die;   
    
    }

    public function place_order(Request $request){
      $output=array();
      $output['status']=false;
      if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

          $validator = Validator::make(
            $request->all(), 
            [
                'order_id' => 'required',
                'user_id' => 'required',
            ]
          );

          if ($validator->fails()) {
              return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
              ], 402);
          }

          $get_purchaseorder = PurchaseOrderModel::where(['User_ID' => $request->user_id,'OrderID' => $request->order_id,'order_status' => '0'])->get()->toArray();
          // echo "<pre>"; 
          // print_r($get_purchaseorder);
          // echo "</pre>";
          // die();
          if(count($get_purchaseorder)>0){
                $data = array();
                $data['order_status'] = '1';
                foreach ($get_purchaseorder as $key => $value) {
                    PurchaseOrderModel::where(['PurchaseID' => $value['PurchaseID']])->update($data);
                    OrderModel::where(['Order' => $value['OrderID']])->update($data); 
                }

                return response()->json([
                  'status' => true,
                  'message' => 'Order placed successfully',
                ], 402);

          }else{
               return response()->json([
                'status' => false,
                'message' => 'No order exist',
              ], 402);
          }
      }else{
        $output['message'] = '405';
      } 
      echo json_encode($output);
      die;   

    }


	  public function received_order_detail(Request $request){
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
          $get_purchaseorder = PurchaseOrderModel::where(['User_ID' => $request->user_id,'order_status' => '1'])->get();
         
          $orders = array();
          foreach ($get_purchaseorder as $key => $value) {
                $order['vendor_name'] = '';
                $get_vendor = VendorModel::where(['VendorID' => $value['vendor_id']])->first();
                if ($get_vendor) {
                   $order['vendor_name'] = $get_vendor['vendor_name'];
                }
                $order['purchase_id'] = $value['PurchaseID'];
                $order['order_id'] = $value['OrderID'];
                $order['product_id'] = $value['product_id'];
                $order['product_name'] = $value['product_name'];
                $order['order_by'] = $value['order_by'];
                $order['vendor_id'] = $value['vendor_id'];
                $order['case_size'] = $value['case_size'];
                $order['quantity'] = $value['quantity'];
                $order['wholesale_value'] = $value['wholesale_value'];
            $orders[] = $order;
          }

          $data['received_orders'] = $orders;          
         
          return response()->json([
            'status' => true,
            'message' => 'Recieved order list',
            'data' => $data,
          ], 402);

      }else{
        $output['message'] = '405';
      } 
      echo json_encode($output);
      die;   

    }


    public function add_order_to_invoice(Request $request){
      $output=array();
      $output['status']=false;
      if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

          $validator = Validator::make(
            $request->all(), 
            [
                'purchase_id' => 'required',
                'user_id' => 'required',
            ]
          );

          if ($validator->fails()) {
              return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
              ], 402);
          }

          $get_purchaseorder = PurchaseOrderModel::where(['User_ID' => $request->user_id,'PurchaseID' => $request->purchase_id,'order_status' => '1'])->get()->toArray();
         
          if(count($get_purchaseorder)>0){
                $data = array();
                $data['order_status'] = '2';
                foreach ($get_purchaseorder as $key => $value) {
                    PurchaseOrderModel::where(['PurchaseID' => $value['PurchaseID']])->update($data);
                    OrderModel::where(['Order' => $value['OrderID']])->update($data); 
                }

                return response()->json([
                  'status' => true,
                  'message' => 'Order receive to invoice',
                  // 'data' => $res_data,
                ], 402);

          }else{
               return response()->json([
                'status' => false,
                'message' => 'No order exist',
              ], 402);
          }
      }else{
        $output['message'] = '405';
      } 
      echo json_encode($output);
      die;   

    }

}