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
use App\Models\OrderModel;
use App\Models\PurchaseOrderModel;
use App\Models\ProductsModel;
use App\Models\VendorModel;

class PurchaseOrderController extends Controller
{

    public function purchase_order(){
    	$data = array();
    	$data['main_menu'] = 'Ordering';
    	$user_id = Session::get('user_id');
    	$data['user_details'] = UserModel::where(['id' => $user_id])->first();
    	
    	$get_order = OrderModel::where(['User_ID' => $user_id,'order_status' => '0'])->get();
      $total_count = PurchaseOrderModel::where(['User_ID' => $user_id,'order_status' => '0'])->count();
     
      $main_data = array();
      if (count($get_order)>0) {
            foreach ($get_order as $key => $value) {
                $get_purchaseorder = PurchaseOrderModel::where(['User_ID' => $user_id,'OrderID' => $value['Order'],'order_status' => '0'])->get();
                $res_data = array();
                foreach ($get_purchaseorder as $key => $value_pur) {
                  $data['vendor_name'] = '';
                  $get_vendor = VendorModel::where(['VendorID' => $value_pur['vendor_id']])->first();
                  if ($get_vendor) {
                     $data['vendor_name'] = $get_vendor['vendor_name'];
                  }
                  $data['PurchaseID'] = $value_pur['PurchaseID'];
                  $data['OrderID'] = $value_pur['OrderID'];
                  $data['product_id'] = $value_pur['product_id'];
                  $data['product_name'] = $value_pur['product_name'];
                  $data['order_by'] = $value_pur['order_by'];
                  $data['vendor_id'] = $value_pur['vendor_id'];
                  $data['case_size'] = $value_pur['case_size'];
                  $data['quantity'] = $value_pur['quantity'];
                  $data['wholesale_value'] = $value_pur['wholesale_value'];
                  $data['updated_at'] = $value_pur['updated_at'];
                  $res_data[] = $data;
                }
            $main_data[] = $res_data;
            }  
      }

      $OrderID = @$get_purchaseorder[0]['OrderID'];
    	$get_products = ProductsModel::where(['User_ID' => $user_id])->get();

    	return view('admin.Purchaseorder.index',compact('data','main_data','get_products','OrderID','total_count'));
    }

    public function save_draft_order(Request $request){
        $user_id = Session::get('user_id');

        $input = $request->all();
        $rules = [];
        $rules['product_name'] = 'required';
        $rules['order_by'] = 'required';
        $rules['quantity'] = 'required';
        $rules['wholesale_value'] = 'required';

        $product_required_msg = "Please select atleast one Product";
        $required_msg = "The :attribute field is required.";

        $custom_msg = [];
        $custom_msg['product_name.required'] = $product_required_msg;
        $custom_msg['required'] = $required_msg;

        $validator = Validator::make($input, $rules, $custom_msg);

        if ($validator->fails()) {
            return response()->json(array('error'=>$validator->getMessageBag()->toArray(),));
        }
       
        $data = $request->all();
      
        $get_single_product = ProductsModel::where(['product_name' => $data['product_name']])->first()->toArray();
        // echo "<pre>"; 
        // print_r($get_single_product);
        // echo "</pre>";
        // die();
        $vendor_id = $get_single_product['vendor_id']; 
       
        $getvendors_id = PurchaseOrderModel::where(['User_ID' => $user_id,'vendor_id' => $vendor_id])->get()->toArray();
        
        if (empty($getvendors_id)) {
            $datapost =array();
            $datapost['Order'] = $vendor_id;
            $datapost['User_ID'] = $user_id;
            $last_order_id = OrderModel::create($datapost);
        }
       
        $data_purchase =array();
        // if (empty($getvendors_id)) {
        //    $data_purchase['OrderID'] = $last_order_id['id'];
        // }else{
        //    $data_purchase['OrderID'] = $data['OrderID'];
        // }
        $data_purchase['OrderID'] = $get_single_product['vendor_id'];
        $data_purchase['product_name'] = $data['product_name'];
        $get_single_product = ProductsModel::where(['product_name' => $data['product_name']])->first()->toArray();
        $data_purchase['product_id'] = $get_single_product['ProductID'];
        $data_purchase['vendor_id'] = $get_single_product['vendor_id'];
        $data_purchase['order_by'] = $data['order_by'];
        $data_purchase['case_size'] = '';
        if ($data['order_by']=='Case') {
         $data_purchase['case_size'] = $data['case_size'];
        }
        $data_purchase['wholesale_value'] = $data['wholesale_value'];
        $data_purchase['quantity'] =  $data['quantity'];
        $data_purchase['User_ID'] = $user_id;

        $insert_product_id = PurchaseOrderModel::create($data_purchase);


        $request->session()->flash('success', 'Order added successfully!');           
      
    }

    public function save_purchase_order(Request $request){

        $input = $request->all();
        $rules = [];
        $rules['product_name'] = 'required';
        $rules['order_by'] = 'required';
        $rules['quantity'] = 'required';
        $rules['wholesale_value'] = 'required';

        $product_required_msg = "Please select atleast one Product";
        $required_msg = "The :attribute field is required.";

        $custom_msg = [];
        $custom_msg['product_name.required'] = $product_required_msg;
        $custom_msg['required'] = $required_msg;

        $validator = Validator::make($input, $rules, $custom_msg);

        if ($validator->fails()) {
            return response()->json(array('error'=>$validator->getMessageBag()->toArray(),));
        }
         
        $data = $request->all();

        $get_purchase = PurchaseOrderModel::where(['PurchaseID' => $data['PurchaseID']])->first()->toArray();
        $OrderID = $get_purchase['OrderID'];
        // echo "<pre>"; 
        // print_r($get_purchase);
        // echo "</pre>";
        // die();

        $PurchaseID = $data['PurchaseID'];
        $Product_name = $data['product_name'];
        $Order_by = $data['order_by'];
        $Case_size = $data['case_size'];
        $Wholesale_value = $data['wholesale_value'];
        $Quantity = $data['quantity'];

           
        if ($Product_name!='') {
          foreach ($PurchaseID as $key => $value) {
              $data_desc = array();  
              $data_desc['order_status'] = '1';
              PurchaseOrderModel::where(['PurchaseID' => $value])->update($data_desc); 
          }  
           $data_order = array();  
           $data_order['order_status'] = '1';
          OrderModel::where(['OrderID' => $OrderID])->update($data_order); 
          $request->session()->flash('success', 'All Order placed successfully!');  
        }    
      
    }

    public function save_single_order(Request $request){
      $PurchaseID = $request->PurchaseID;

      $get_purchase = PurchaseOrderModel::where(['PurchaseID' => $PurchaseID])->first()->toArray();
      $OrderID = $get_purchase['OrderID'];

      if ($PurchaseID!='') {
          foreach ($PurchaseID as $key => $value) {
              $data_single = array();  
              $data_single['order_status'] = '1';
              PurchaseOrderModel::where(['PurchaseID' => $value])->update($data_single); 
          
          }  
          $data_order = array();  
           $data_order['order_status'] = '1';
          OrderModel::where(['OrderID' => $OrderID])->update($data_order);
          
          $request->session()->flash('success', 'Order placed successfully!');  
      }

    }

    public function delete_purchase_order(Request $request){
      if($_GET['PurchaseID'] != ''){
         $PurchaseID = $_GET['PurchaseID'];
          
         PurchaseOrderModel::where('PurchaseID', $PurchaseID)->delete();
         // OrderModel::where('OrderID', $PurchaseID)->delete();

         $request->session()->flash('danger', 'Order deleted successfully!');
         return redirect('purchase_order');  
      }
    }

    public function save_order(Request $request){
      if($_GET['PurchaseID'] != ''){
         $PurchaseID = $_GET['PurchaseID'];
          
         $data_desc = array();  
         $data_desc['order_status'] = '1';
         PurchaseOrderModel::where(['PurchaseID' => $PurchaseID])->update($data_desc);

         $request->session()->flash('success', 'Single Order added successfully!');
         return redirect('purchase_order');  
      }
    }

}
