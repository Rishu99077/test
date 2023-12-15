<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;
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

class ReceiveProductsController extends Controller
{

    public function receive_products(){
     
    	$data = array();
    	$data['main_menu'] = 'Ordering';
    	$user_id = Session::get('user_id');
    	$data['user_details'] = UserModel::where(['id' => $user_id])->first()->toArray();
    	
    	  $get_purchaseorder = PurchaseOrderModel::where(['User_ID' => $user_id,'order_status' => '1'])->get()->toArray();
        $total_count = PurchaseOrderModel::where(['User_ID' => $user_id,'order_status' => '1'])->count();

        foreach ($get_purchaseorder as $key => $value) {  
        $get_order_by_vendor = PurchaseOrderModel::where(['User_ID' => $user_id,'vendor_id' => $value['vendor_id'],'order_status' => '1'])->get()->toArray();
            $vendors[$value['vendor_id']] = $get_order_by_vendor;
        }
       
        $preorders = array();
        if (!empty($vendors)) {
            foreach ($vendors as $key_vendor => $value_vendor) {  
                $orders = array();
                foreach ($value_vendor as $key => $val) {
                  $order['PurchaseID'] = $val['PurchaseID'];
                  $order['OrderID'] = $val['OrderID'];
                  $order['product_name'] = $val['product_name'];
                  $order['vendor_id'] = $val['vendor_id'];  
                  $get_vendor = VendorModel::where(['VendorID' => $val['vendor_id']])->first()->toArray();
                  $order['vendor_name'] = $get_vendor['vendor_name'];
                  $order['order_by'] = $val['order_by'];
                  $order['case_size'] = $val['case_size'];
                  $order['quantity'] = $val['quantity'];
                  $order['wholesale_value'] = $val['wholesale_value'];
                  $order['updated_at'] = $val['updated_at'];

                  $orders[] = $order;
                }
                $preorders[] = $orders;
            }   
        }
    	return view('admin.Ordering.receive_products',compact('data','preorders'));
    }

    public function update_productstatus(Request $request){
        $PurchaseID = $_GET['PurchaseID'];	

        $get_purchase = PurchaseOrderModel::where(['PurchaseID' => $PurchaseID])->first()->toArray();
        $OrderID = $get_purchase['OrderID'];

        $data = $request->all();
          if ($PurchaseID!='') {
                $UpdateData = array();
                $UpdateData['order_status'] = '2';

                PurchaseOrderModel::where(['PurchaseID' => $PurchaseID])->update($UpdateData);
                OrderModel::where(['OrderID' => $OrderID])->update($UpdateData);
                $request->session()->flash('success', 'Order sent to Invoice');
                return redirect('receive_products');
          }
    }


    public function delete_order(Request $request){
      if($_GET['PurchaseID'] != ''){
         $PurchaseID = $_GET['PurchaseID'];
          
         PurchaseOrderModel::where('PurchaseID', $PurchaseID)->delete();

         $request->session()->flash('danger', 'Order deleted successfully!');
         return redirect('receive_products');  
      }
    }


    public function invoice(){
     
      $data = array();
      $data['main_menu'] = 'Ordering';
      $user_id = Session::get('user_id');
      $data['user_details'] = UserModel::where(['id' => $user_id])->first()->toArray();
      
      $get_purchase_order = PurchaseOrderModel::where(['User_ID' => $user_id,'order_status' => '2'])->get();

      $orders = array();
        foreach ($get_purchase_order as $key => $value) {
            $order['PurchaseID'] = $value['PurchaseID'];
            $order['product_name'] = $value['product_name'];
            $order['order_by'] = $value['order_by'];
            $order['quantity'] = $value['quantity'];
            $order['wholesale_value'] = $value['wholesale_value'];
            $order['updated_at'] = $value['updated_at'];
            $orders[] = $order;
        }
        
      $get_products = ProductsModel::where(['User_ID' => $user_id])->get();  
      return view('admin.Ordering.invoice',compact('data','orders','get_products'));
    }

    public function delete_invoice(Request $request){
      if($_GET['PurchaseID'] != ''){
         $PurchaseID = $_GET['PurchaseID'];
          
         PurchaseOrderModel::where('PurchaseID', $PurchaseID)->delete();

         $request->session()->flash('danger', 'Order deleted successfully!');
         return redirect('invoice');  
      }
    }
}
