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
use App\Models\ProductTypeModel;
use App\Models\IconsModel;
use App\Models\InventriesProductModel;


class ProductTypeController extends Controller
{

  public function Product_type(){
    $data = array();
    $data['main_menu'] = 'Product type';
    $user_id = Session::get('user_id');
    $data['user_details'] = UserModel::where(['id' => $user_id])->first();

    @$ProductName = $_GET['ProductName'];
    @$MasterProductName = $_GET['MasterProductName'];

    // Product type added by current user
    $ProductTypeModel = ProductTypeModel::where(['User_ID' => $user_id]);
    if ($ProductName!='') {
          $ProductTypeModel->where('name','LIKE','%'.$ProductName.'%');
    }
    $get_user_producttype = $ProductTypeModel->orderBy('id', 'desc')->paginate(config('restaurant.records_per_page'),['*'],'get_user_producttype');


    $user_products = array();
    foreach ($get_user_producttype as $key => $value) {
      $product['id'] = $value['id'];
      $product['name'] = $value['name'];
      $product['icon_name'] = '';
      $icon_details = IconsModel::where(['IconID' => $value['icon']])->first();
      if ($icon_details) {
        $product['icon_name'] = $icon_details['image'];
      }
      $product['status'] = $value['status'];

      $product['restaurant_name'] = '';
      $single_user_details = UserModel::where(['id' => $value['User_ID']])->first();
      if (!empty($single_user_details)) {
        $product['restaurant_name'] = $single_user_details['restaurant_name'];
      }
      $user_products[] = $product;
    }

    // Product type added by all admin
    $ProductTypeModel = ProductTypeModel::where('User_ID', '!=', '1');
    if ($ProductName!='') {
        $ProductTypeModel->where('name','LIKE','%'.$ProductName.'%');
    }
    $get_admin_producttype = $ProductTypeModel->orderBy('id', 'desc')->paginate(config('restaurant.records_per_page'),['*'],'get_admin_producttype');
    $admin_products = array();
    foreach ($get_admin_producttype as $key => $value) {
      $product['id'] = $value['id'];
      $product['name'] = $value['name'];
      $product['icon_name'] = '';
      $icon_details = IconsModel::where(['IconID' => $value['icon']])->first();
      if ($icon_details) {
        $product['icon_name'] = $icon_details['image'];
      }
      $product['status'] = $value['status'];

      $product['restaurant_name'] = '';
      $single_user_details = UserModel::where(['id' => $value['User_ID']])->first();
      if (!empty($single_user_details)) {
        $product['restaurant_name'] = $single_user_details['restaurant_name'];
      }
      $admin_products[] = $product;
    }

    // Product type added by Super admin
    $ProductTypeModel = ProductTypeModel::where('User_ID', '=', '1');
    if ($MasterProductName!='') {
        $ProductTypeModel->where('name','LIKE','%'.$MasterProductName.'%');
    }
    $get_superadmin_producttype = $ProductTypeModel->orderBy('id', 'desc')->paginate(config('restaurant.records_per_page'),['*'],'get_superadmin_producttype');
    $master_products = array();
    foreach ($get_superadmin_producttype as $key => $value) {
      $product['id'] = $value['id'];
      $product['name'] = $value['name'];
      $product['icon_name'] = '';
      $icon_details = IconsModel::where(['IconID' => $value['icon']])->first();
      if ($icon_details) {
        $product['icon_name'] = $icon_details['image'];
      }
      $product['status'] = $value['status'];

      $product['restaurant_name'] = '';
      $single_user_details = UserModel::where(['id' => $value['User_ID']])->first();
      if (!empty($single_user_details)) {
        $product['restaurant_name'] = $single_user_details['restaurant_name'];
      }

      $master_products[] = $product;
    }

    return view('admin.Product_type.product_type', compact('data', 'user_products', 'admin_products', 'master_products','get_user_producttype','get_admin_producttype','get_superadmin_producttype'));
  }

  public function add_Producttype(){
    $data = array();
    $data['main_menu'] = 'Product type';
    $user_id = Session::get('user_id');
    $data['user_details'] = UserModel::where(['id' => $user_id])->first();
    $get_icons = IconsModel::where(['User_ID' => $user_id])->get();

    $products = array();
    $products['name']  = '';
    $products['icon'] = '';
    $products['status'] = '';
    $products['User_ID'] = '';

    if (@$_GET['Product_type_Id'] != '') {
      $Product_type_Id = $_GET['Product_type_Id'];
      $get_product_type = ProductTypeModel::where(['id' => $Product_type_Id])->first();

      $products['Product_type_Id'] = $get_product_type['id'];
      $products['name'] = $get_product_type['name'];
      $products['icon'] = $get_product_type['icon'];
      $products['status'] = $get_product_type['status'];
      $products['User_ID'] = $get_product_type['User_ID'];
    }

    return view('admin.Product_type.add_producttype', compact('products', 'data', 'get_icons'));
  }

  public function save_product_type(Request $request){
    $user_id = Session::get('user_id');
    $user_details = UserModel::where(['id' => $user_id])->first();

    $input = $request->all();
    $rules = [];
    $rules['name'] = 'required';
    $required_msg = "The :attribute field is required.";

    $custom_msg = [];
    $custom_msg['required'] = $required_msg;

    $validator = Validator::make($input, $rules, $custom_msg);

    if ($validator->fails()) {
      return response()->json(array('error' => $validator->getMessageBag()->toArray(),));
    }

    $Product_type_Id = $request->Product_type_Id;

    $data = $request->all();

    if ($Product_type_Id != '') {
      $get_product_type = ProductTypeModel::where('id','!=',$Product_type_Id)->where('User_ID',$user_id)->where('name',$data['name'])->first();
      if($get_product_type){
        $error['name'] = "The product type name is already taken";
        return response()->json(array('error' => $error));
      }


      $get_product_type = ProductTypeModel::where(['id' => $Product_type_Id])->first();
      $Product_type_Id = $get_product_type['id'];

      $UpdateData = array();
      $UpdateData['name'] = $data['name'];
      $UpdateData['icon'] = $data['icon'];
      $UpdateData['status'] = $data['status'];
      $UpdateData['User_ID'] = $data['User_ID'];

      ProductTypeModel::where(['id' => $Product_type_Id])->update($UpdateData);
      $request->session()->flash('success', 'Product type update successfully!');
    } else {

      $get_product_type = ProductTypeModel::where('User_ID',$user_id)->where('name',$data['name'])->first();
      if($get_product_type){
        $error['name'] = "The product type name is already taken";
        return response()->json(array('error' => $error));
      }


      $Data = array();
      $Data['name'] = $data['name'];
      $Data['icon'] = $data['icon'];
      $Data['User_ID'] = $user_id;
      if ($user_id == '1') {
        $Data['status'] = '1';
        $Data['superadmin_id'] = $user_id;
      } else {
        $Data['status'] = '0';
        $Data['admin_id'] = $user_id;
      }
      $Data['source'] = 'Web';

      $insert_id = ProductTypeModel::create($Data);
      $request->session()->flash('success', 'Product type added successfully!');
    }
  }

  public function addtype_from_master(Request $request){
    $user_id = Session::get('user_id');
    $Type_ID = $request->Type_ID;
    $type_name = $request->type_name;

    $get_producttype_byuser = ProductTypeModel::where(['name' => $type_name, 'User_ID' => $user_id])->first();
    if (empty($get_producttype_byuser)) {
      if (!empty($Type_ID)) {
        $get_producttype = ProductTypeModel::where(['id' => $Type_ID])->first();
        if (!empty($get_producttype)) {
          $Data = array();
          $Data['name'] = $get_producttype['name'];
          $Data['icon'] = $get_producttype['icon'];
          $Data['User_ID'] = $user_id;
          $Data['status'] = $get_producttype['status'];
          $Data['admin_id'] = $user_id;
          $Data['superadmin_id'] = '0';

          ProductTypeModel::create($Data);
          $request->session()->flash('success', 'Product type add to master');
        }
      }
    } else {
      $request->session()->flash('danger', 'This Product type is already added');
    }
  }

  public function product_type_movetomaster(Request $request){
    $user_id = Session::get('user_id');
    $Type_ID = $request->Type_ID;
    $type_name = $request->type_name;

    $get_producttype_byuser = ProductTypeModel::where(['name' => $type_name, 'User_ID' => $user_id])->first();
    if (empty($get_producttype_byuser)) {
      if (!empty($Type_ID)) {
        $get_producttype = ProductTypeModel::where(['id' => $Type_ID])->first();
        if (!empty($get_producttype)) {
          $Data = array();
          $Data['name'] = $get_producttype['name'];
          $Data['icon'] = $get_producttype['icon'];
          $Data['User_ID'] = $user_id;
          $Data['status'] = $get_producttype['status'];
          $Data['admin_id'] = '0';
          $Data['superadmin_id'] = $user_id;

          ProductTypeModel::create($Data);

          $UpdateData = array();
          $UpdateData['status'] = '1';

          ProductTypeModel::where(['id' => $Type_ID])->update($UpdateData);

          $request->session()->flash('success', 'Product type add to master');
        }
      }
    } else {
      $request->session()->flash('danger', 'This Product type is already added');
    }
  }


  public function product_type_remove_master(Request $request){
    $user_id = Session::get('user_id');
    $Type_ID = $request->Type_ID;
    $type_name = $request->type_name;

    if (!empty($Type_ID)) {

      ProductTypeModel::where(['User_ID' => $user_id, 'name' => $type_name])->delete();

      $UpdateData = array();
      $UpdateData['status'] = '0';

      ProductTypeModel::where(['id' => $Type_ID])->update($UpdateData);
      $request->session()->flash('success', 'Product type Remove from master');
    }
  }


  public function delete_Producttype(Request $request){
    if ($_GET['Product_type_Id'] != '') {
      $Product_type_Id = $_GET['Product_type_Id'];

      ProductTypeModel::where('id', $Product_type_Id)->delete();

      $request->session()->flash('danger', 'Product type deleted successfully!');
      return redirect('Product_type');
    }
  }


  // Product Save Sorting position

  public function ProductsavePosition(Request $request){
    foreach ($request->id as $key => $id) {
      InventriesProductModel::where("Inventries_productsID", $id)->update(['sort_order' => $request->position[$key]]);
    }
  }

  public function ProducteditPosition(Request $request){
    foreach ($request->id as $key => $id) {
      InventriesProductModel::where("Inventries_productsID", $id)->update(['sort_order' => $request->position[$key]]);
    }
  }
}
