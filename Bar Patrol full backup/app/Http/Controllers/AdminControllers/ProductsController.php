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
use App\Models\ProductCategorieModel;
use App\Models\ProductTypeModel;
use App\Models\VendorModel;
use App\Models\ProductsModel;

class ProductsController extends Controller
{

    public function products(){
      $data = array();
      $data['main_menu'] = 'Products';
      $user_id = Session::get('user_id');
      $data['user_details'] = UserModel::where(['id' => $user_id])->first();

      $get_productscategories = ProductCategorieModel::where(['User_ID' => $user_id])->get();

      @$ProductSearch = $_GET['ProductSearch'];
      @$Productcode = $_GET['Productcode'];
      @$Productcategory = $_GET['Productcategory'];

      $ProductsModel = ProductsModel::where(['User_ID' => $user_id]);
      if ($ProductSearch!='') {
          $ProductsModel->where('product_name','LIKE','%'.$ProductSearch.'%');
      }

      if ($Productcode!='') {
          $ProductsModel->where('product_code','LIKE','%'.$Productcode.'%');
      }

      if ($Productcategory!='') {
          $ProductsModel->where('product_categorie_id','=',$Productcategory);
      }


      $get_products = $ProductsModel->orderBy('ProductID', 'desc')->paginate(config('restaurant.records_per_page'));
      
      $products = array();
      foreach ($get_products as $key => $value) {
          $pro['ProductID'] = $value['ProductID'];
          $pro['product_name'] = $value['product_name'];
          $pro['product_code'] = $value['product_code'];
          $pro['vendor_code'] = $value['vendor_code'];
          $get_product_type = ProductTypeModel::where(['id' => $value['product_type_id']])->first();
          
          $pro['product_type_name'] = '';
          if (!empty($get_product_type)) {
            $pro['product_type_name'] = $get_product_type['name'];
          }

          $get_product_categorie = ProductCategorieModel::where(['Categorie_ID' => $value['product_categorie_id']])->first();
          $pro['categorie_name'] = '';
          if (!empty($get_product_categorie)) {
            $pro['categorie_name'] = $get_product_categorie['categorie_name'];
          }
          $pro['product_categorie_id'] = $value['product_categorie_id'];

          $pro['container_type'] = $value['container_type'];
          $pro['container_size'] = $value['container_size'];
          $pro['presentation'] = $value['presentation'];
          $pro['units'] = $value['units'];
          $pro['wholesale_container_price'] = $value['wholesale_container_price'];

          $pro['single_portion_size'] = $value['single_portion_size'];
          $pro['single_portion_unit'] = $value['single_portion_unit'];
          $pro['retail_portion_price'] = $value['retail_portion_price'];
          $pro['full_weight'] = $value['full_weight'];

          $pro['empty_weight'] = $value['empty_weight'];
          $pro['case_size'] = $value['case_size'];
          $pro['vendor_id'] = $value['vendor_id'];
          
          $pro['vendor_name'] = '';
          $get_vendor = VendorModel::where(['VendorID' => $value['vendor_id']])->first();
          if (!empty($get_vendor)) {
             $pro['vendor_name'] = $get_vendor['vendor_name'];
          }

          $pro['par'] = $value['par'];
          $pro['reorder_point'] = $value['reorder_point'];
          $pro['order_by_the'] = $value['order_by_the'];
          $pro['ideal_pour_cost'] = $value['ideal_pour_cost'];
          $pro['status'] = $value['status'];
          
          $pro['restaurant_name'] = '';
          $single_user_details = UserModel::where(['id' => $value['User_ID']])->first();
          if (!empty($single_user_details)) {
             $pro['restaurant_name'] = $single_user_details['restaurant_name'];
          }

          $products[] = $pro;
      }
      return view('admin.Product.products',compact('data','get_products','products','get_productscategories'));
    }


    public function admin_products(){
      $data = array();
      $data['main_menu'] = 'Products';
      $user_id = Session::get('user_id');
      $data['user_details'] = UserModel::where(['id' => $user_id])->first();
      $get_products_items = ProductsModel::all();

      $get_productscategories = ProductCategorieModel::where('User_ID','!=','1')->get();

      @$ProductSearch = $_GET['ProductSearch'];
      @$Productcode = $_GET['Productcode'];
      @$Productcategory = $_GET['Productcategory'];

      $ProductsModel = ProductsModel::where('User_ID','!=','1');
      if ($ProductSearch!='') {
          $ProductsModel->where('product_name','LIKE','%'.$ProductSearch.'%');
      }

      if ($Productcode!='') {
          $ProductsModel->where('product_code','LIKE','%'.$Productcode.'%');
      }

      if ($Productcategory!='') {
          $ProductsModel->where('product_categorie_id','=',$Productcategory);
      }


      $get_products = $ProductsModel->orderBy('ProductID', 'desc')->paginate(config('restaurant.records_per_page'));
      
      $products = array();
      foreach ($get_products as $key => $value) {
          $pro['ProductID'] = $value['ProductID'];
          $pro['product_name'] = $value['product_name'];
          $pro['product_code'] = $value['product_code'];
          $pro['vendor_code'] = $value['vendor_code'];
          $get_product_type = ProductTypeModel::where(['id' => $value['product_type_id']])->first();
          
          $pro['product_type_name'] = '';
          if (!empty($get_product_type)) {
            $pro['product_type_name'] = $get_product_type['name'];
          }

          $get_product_categorie = ProductCategorieModel::where(['Categorie_ID' => $value['product_categorie_id']])->first();
          $pro['categorie_name'] = '';
          if (!empty($get_product_categorie)) {
            $pro['categorie_name'] = $get_product_categorie['categorie_name'];
          }
          $pro['product_categorie_id'] = $value['product_categorie_id'];

          $pro['container_type'] = $value['container_type'];
          $pro['container_size'] = $value['container_size'];
          $pro['presentation'] = $value['presentation'];
          $pro['units'] = $value['units'];
          $pro['wholesale_container_price'] = $value['wholesale_container_price'];

          $pro['single_portion_size'] = $value['single_portion_size'];
          $pro['single_portion_unit'] = $value['single_portion_unit'];
          $pro['retail_portion_price'] = $value['retail_portion_price'];
          $pro['full_weight'] = $value['full_weight'];

          $pro['empty_weight'] = $value['empty_weight'];
          $pro['case_size'] = $value['case_size'];
          $pro['vendor_id'] = $value['vendor_id'];
          
          $pro['vendor_name'] = '';
          $get_vendor = VendorModel::where(['VendorID' => $value['vendor_id']])->first();
          if (!empty($get_vendor)) {
             $pro['vendor_name'] = $get_vendor['vendor_name'];
          }

          $pro['par'] = $value['par'];
          $pro['reorder_point'] = $value['reorder_point'];
          $pro['order_by_the'] = $value['order_by_the'];
          $pro['ideal_pour_cost'] = $value['ideal_pour_cost'];
          $pro['status'] = $value['status'];

          $pro['restaurant_name'] = '';
          $single_user_details = UserModel::where(['id' => $value['User_ID']])->first();
          if (!empty($single_user_details)) {
             $pro['restaurant_name'] = $single_user_details['restaurant_name'];
          }

          $products[] = $pro;
      }
      return view('admin.Product.admin_products',compact('data','get_products','products','get_productscategories'));
    }

    public function master_products(){
      $data = array();
      $data['main_menu'] = 'Products';
      $user_id = Session::get('user_id');
      $data['user_details'] = UserModel::where(['id' => $user_id])->first();
      $get_products_items = ProductsModel::all();

      $get_productscategories = ProductCategorieModel::where(['User_ID' => 1])->get();

      @$ProductSearch = $_GET['ProductSearch'];
      @$Productcode = $_GET['Productcode'];
      @$Productcategory = $_GET['Productcategory'];

      $ProductsModel = ProductsModel::where(['User_ID' => 1]);
      if ($ProductSearch!='') {
          $ProductsModel->where('product_name','LIKE','%'.$ProductSearch.'%');
      }

      if ($Productcode!='') {
          $ProductsModel->where('product_code','LIKE','%'.$Productcode.'%');
      }

      if ($Productcategory!='') {
          $ProductsModel->where('product_categorie_id','=',$Productcategory);
      }


      $get_products = $ProductsModel->orderBy('ProductID', 'desc')->paginate(config('restaurant.records_per_page'));
      
      $products = array();
      foreach ($get_products as $key => $value) {
          $pro['ProductID'] = $value['ProductID'];
          $pro['product_name'] = $value['product_name'];
          $pro['product_code'] = $value['product_code'];
          $pro['vendor_code'] = $value['vendor_code'];
          $get_product_type = ProductTypeModel::where(['id' => $value['product_type_id']])->first();
          
          $pro['product_type_name'] = '';
          if (!empty($get_product_type)) {
            $pro['product_type_name'] = $get_product_type['name'];
          }

          $get_product_categorie = ProductCategorieModel::where(['Categorie_ID' => $value['product_categorie_id']])->first();
          $pro['categorie_name'] = '';
          if (!empty($get_product_categorie)) {
            $pro['categorie_name'] = $get_product_categorie['categorie_name'];
          }
          $pro['product_categorie_id'] = $value['product_categorie_id'];

          $pro['container_type'] = $value['container_type'];
          $pro['container_size'] = $value['container_size'];
          $pro['presentation'] = $value['presentation'];
          $pro['units'] = $value['units'];
          $pro['wholesale_container_price'] = $value['wholesale_container_price'];

          $pro['single_portion_size'] = $value['single_portion_size'];
          $pro['single_portion_unit'] = $value['single_portion_unit'];
          $pro['retail_portion_price'] = $value['retail_portion_price'];
          $pro['full_weight'] = $value['full_weight'];

          $pro['empty_weight'] = $value['empty_weight'];
          $pro['case_size'] = $value['case_size'];
          $pro['vendor_id'] = $value['vendor_id'];
          
          $pro['vendor_name'] = '';
          $get_vendor = VendorModel::where(['VendorID' => $value['vendor_id']])->first();
          if (!empty($get_vendor)) {
             $pro['vendor_name'] = $get_vendor['vendor_name'];
          }

          $pro['par'] = $value['par'];
          $pro['reorder_point'] = $value['reorder_point'];
          $pro['order_by_the'] = $value['order_by_the'];
          $pro['ideal_pour_cost'] = $value['ideal_pour_cost'];
          $pro['status'] = $value['status'];

          $pro['restaurant_name'] = '';
          $single_user_details = UserModel::where(['id' => $value['User_ID']])->first();
          if (!empty($single_user_details)) {
             $pro['restaurant_name'] = $single_user_details['restaurant_name'];
          }

          $products[] = $pro;
      }
      return view('admin.Product.master_products',compact('data','get_products','products','get_productscategories'));
    }

    public function addproduct_from_master(Request $request){
        $user_id = Session::get('user_id');

        $ProductID = $request->ProductID;
        $product_name = $request->product_name;
        $get_admin_product = ProductsModel::where(['product_name' => $product_name,'User_ID' => $user_id])->first();
        if (empty($get_admin_product)) {
          if(!empty($ProductID)){
              $get_product = ProductsModel::where(['ProductID' => $ProductID])->first();
              if(!empty($get_product)){
                $Data = array();
                $Data['product_name'] = $get_product['product_name'];
                $Data['product_code'] = $get_product['product_code'];
                $Data['vendor_code'] = $get_product['vendor_code'];
                $Data['product_type_id'] = $get_product['product_type_id'];
                $Data['product_categorie_id'] = $get_product['product_categorie_id'];

                $Data['container_type'] = $get_product['container_type'];
                $Data['container_size'] = $get_product['container_size'];
                $Data['presentation'] = $get_product['presentation'];
                $Data['units'] = $get_product['units'];
                $Data['wholesale_container_price'] = $get_product['wholesale_container_price'];

                $Data['single_portion_size'] = $get_product['single_portion_size'];
                $Data['single_portion_unit'] = $get_product['single_portion_unit'];
                $Data['retail_portion_price'] = $get_product['retail_portion_price'];
                $Data['full_weight'] = $get_product['full_weight'];

                $Data['empty_weight'] = $get_product['empty_weight'];
                $Data['case_size'] = $get_product['case_size'];
                $Data['vendor_id'] = $get_product['vendor_id'];
                $Data['par'] = $get_product['par'];

                $Data['reorder_point'] = $get_product['reorder_point'];
                $Data['order_by_the'] = $get_product['order_by_the'];
                $Data['ideal_pour_cost'] = $get_product['ideal_pour_cost'];
                $Data['User_ID']  = $user_id;
                $Data['status'] = $get_product['status'];
                $Data['admin_id'] = $user_id;
                $Data['superadmin_id'] = '0';
                $Data['source'] = 'Web';
                ProductsModel::create($Data); 
                
                $request->session()->flash('success', 'Product add to master');
              }
              
          }  
        }else{
          $request->session()->flash('danger', 'Already added');
        }
      
    }

    public function add_product(){  
      $data = array();
      $data['main_menu'] = 'Products'; 
      $user_id = Session::get('user_id');
      $data['user_details'] = UserModel::where(['id' => $user_id])->first();
      $data['heading'] = 'Add product';

      $get_productstype = ProductTypeModel::where(['User_ID' => $user_id])->get();
      $get_productscategories = ProductCategorieModel::where(['User_ID' => $user_id])->get();
      $get_vendors = VendorModel::where(['User_ID' => $user_id])->get();

        $products = array();
          $products['product_name'] = '';
          $products['product_code'] = '';
          $products['vendor_code'] = '';
          $products['product_type_id'] = '';
          $products['product_categorie_id'] = '';

          $products['container_type'] = '';
          $products['container_size'] = '';
          $products['presentation'] = '';
          $products['units'] = '';
          $products['wholesale_container_price'] = '';

          $products['single_portion_size'] = '';
          $products['single_portion_unit'] = '';
          $products['retail_portion_price'] = '';
          $products['full_weight'] = '';

          $products['empty_weight'] = '';
          $products['case_size'] ='';
          $products['vendor_id'] = '';
          $products['par'] = '';

          $products['reorder_point'] = '';
          $products['order_by_the'] = '';
          $products['ideal_pour_cost'] = '';
          $products['status'] = '';
          $products['User_ID'] = '';
          $products['added_by'] = '';

        if(@$_GET['ProductID'] != ''){
            $data['heading'] = 'Edit product';  

             $ProductID = $_GET['ProductID'];
             $get_product = ProductsModel::where(['ProductID'=>$ProductID])->first();
             $products['ProductID'] = $get_product['ProductID'];
             $products['product_name'] = $get_product['product_name'];
             $products['product_code'] = $get_product['product_code'];
             $products['vendor_code'] = $get_product['vendor_code'];
             $products['product_type_id'] = $get_product['product_type_id'];
             $products['product_categorie_id'] = $get_product['product_categorie_id'];

             $products['container_type'] = $get_product['container_type'];
             $products['container_size'] = $get_product['container_size'];
             $products['presentation'] = $get_product['presentation'];
             $products['units'] = $get_product['units'];
             $products['wholesale_container_price'] = $get_product['wholesale_container_price'];

             $products['single_portion_size'] = $get_product['single_portion_size'];
             $products['single_portion_unit'] = $get_product['single_portion_unit'];
             $products['retail_portion_price'] = $get_product['retail_portion_price'];
             $products['full_weight'] = $get_product['full_weight'];

             $products['empty_weight'] = $get_product['empty_weight'];
             $products['case_size'] = $get_product['case_size'];
             $products['vendor_id'] = $get_product['vendor_id'];
             $products['par'] = $get_product['par'];

             $products['reorder_point'] = $get_product['reorder_point'];
             $products['order_by_the'] = $get_product['order_by_the'];
             $products['ideal_pour_cost'] = $get_product['ideal_pour_cost'];
             $products['status'] = $get_product['status'];
             $products['User_ID'] = $get_product['User_ID'];
            
          }
       
        return view('admin.Product.add_product',compact('products','data','get_productstype','get_productscategories','get_vendors'));       
    }


    public function save_product(Request $request){
        $user_id = Session::get('user_id');
       
        $input = $request->all();
        
            $rules = [];
            $rules['vendor_code'] = 'required';
            $rules['product_type_id'] = 'required';
            $rules['product_categorie_id'] = 'required';
            $rules['container_type'] = 'required';
            $rules['container_size'] = 'required';
            $rules['presentation'] = 'required';
            $rules['units'] = 'required';
            $rules['vendor_id'] = 'required';

            $required_msg = "The :attribute field is required.";

            $custom_msg = [];
            $custom_msg['required'] = $required_msg;

            $validator = Validator::make($input, $rules, $custom_msg);

            if ($validator->fails()) {
                return response()->json(array('error'=>$validator->getMessageBag()->toArray(),));
            }
       
        $ProductID = $request->ProductID; 
        
        $data = $request->all();

          if ($ProductID!='') {
              $get_pro = ProductsModel::where('ProductID','!=',$ProductID)->where('User_ID',$user_id)->where('product_name',$data['product_name'])->first();
              if($get_pro){
                $error['product_name'] = "The Product name is already taken";
                return response()->json(array('error' => $error));
              }


              $get_product = ProductsModel::where(['ProductID' => $ProductID])->first();
              $ProductID = $get_product['ProductID'];

                $UpdateData = array();
                $UpdateData['product_name'] = $data['product_name'];
                $UpdateData['product_code'] = $data['product_code'];
                $UpdateData['vendor_code'] = $data['vendor_code'];
                $UpdateData['product_type_id'] = $data['product_type_id'];
                $UpdateData['product_categorie_id'] = $data['product_categorie_id'];

                $UpdateData['container_type'] = $data['container_type'];
                $UpdateData['container_size'] = $data['container_size'];
                $UpdateData['presentation'] = $data['presentation'];
                $UpdateData['units'] = $data['units'];
                $UpdateData['wholesale_container_price'] = $data['wholesale_container_price'];

                $UpdateData['single_portion_size'] = $data['single_portion_size'];
                $UpdateData['single_portion_unit'] = $data['single_portion_unit'];
                $UpdateData['retail_portion_price'] = $data['retail_portion_price'];
                $UpdateData['full_weight'] = $data['full_weight'];

                $UpdateData['empty_weight'] = $data['empty_weight'];
                $UpdateData['case_size'] = $data['case_size'];
                $UpdateData['vendor_id'] = $data['vendor_id'];
                $UpdateData['par'] = $data['par'];

                $UpdateData['reorder_point'] = $data['reorder_point'];
                $UpdateData['order_by_the'] = $data['order_by_the'];
                $UpdateData['ideal_pour_cost'] = $data['ideal_pour_cost'];
                $UpdateData['status'] = $data['status'];
                $UpdateData['User_ID'] = $data['User_ID'];

                ProductsModel::where(['ProductID' => $ProductID])->update($UpdateData);
                $request->session()->flash('success', 'Products Updated successfully!');
          }else{

            $rules = [];
            $rules['product_name'] = 'required';
            $rules['product_code'] = 'required|unique:products';
            $rules['vendor_code'] = 'required';
            $rules['product_type_id'] = 'required';
            $rules['product_categorie_id'] = 'required';
            $rules['container_type'] = 'required';
            $rules['container_size'] = 'required';
            $rules['presentation'] = 'required';
            $rules['units'] = 'required';
            $rules['vendor_id'] = 'required';

            $required_msg = "The :attribute field is required.";

            $custom_msg = [];
            $custom_msg['required'] = $required_msg;

            $validator = Validator::make($input, $rules, $custom_msg);

            if ($validator->fails()) {
                return response()->json(array('error'=>$validator->getMessageBag()->toArray(),));
            }
           
            $get_product = ProductsModel::where('User_ID',$user_id)->where('product_name',$data['product_name'])->first();
           
            if($get_product){
              $error['product_name'] = "The Product name is already taken";
              return response()->json(array('error' => $error));
            }

            $Data = array();
            $Data['product_name'] = $data['product_name'];
            $Data['product_code'] = $data['product_code'];
            $Data['vendor_code'] = $data['vendor_code'];
            $Data['product_type_id'] = $data['product_type_id'];
            $Data['product_categorie_id'] = $data['product_categorie_id'];

            $Data['container_type'] = $data['container_type'];
            $Data['container_size'] = $data['container_size'];
            $Data['presentation'] = $data['presentation'];
            $Data['units'] = $data['units'];
            $Data['wholesale_container_price'] = $data['wholesale_container_price'];

            $Data['single_portion_size'] = $data['single_portion_size'];
            $Data['single_portion_unit'] = $data['single_portion_unit'];
            $Data['retail_portion_price'] = $data['retail_portion_price'];
            $Data['full_weight'] = $data['full_weight'];

            $Data['empty_weight'] = $data['empty_weight'];
            $Data['case_size'] = $data['case_size'];
            $Data['vendor_id'] = $data['vendor_id'];
            $Data['par'] = $data['par'];

            $Data['reorder_point'] = $data['reorder_point'];
            $Data['order_by_the'] = $data['order_by_the'];
            $Data['ideal_pour_cost'] = $data['ideal_pour_cost'];
            $Data['User_ID']  = $user_id;
          
            if ($user_id == '1') {
              $Data['superadmin_id'] = $user_id; 
              $Data['status'] = 1;
            }else{
              $Data['admin_id'] = $user_id;
              $Data['status'] = 0; 
            }
            $Data['source'] = 'Web';

            $insert_id = ProductsModel::create($Data);
            $request->session()->flash('success', 'Products added successfully!');           
      
          }   
    }


    public function product_movetomaster(Request $request){
        $user_id = Session::get('user_id');

        $ProductID = $request->ProductID;
        $product_name = $request->product_name;
        $get_admin_product = ProductsModel::where(['product_name' => $product_name,'User_ID' => $user_id])->first();
        if (empty($get_admin_product)) {
          if(!empty($ProductID)){
              $get_product = ProductsModel::where(['ProductID' => $ProductID])->first();
              if(!empty($get_product)){
                $Data = array();
                $Data['product_name'] = $get_product['product_name'];
                $Data['product_code'] = $get_product['product_code'];
                $Data['vendor_code'] = $get_product['vendor_code'];
                $Data['product_type_id'] = $get_product['product_type_id'];
                $Data['product_categorie_id'] = $get_product['product_categorie_id'];

                $Data['container_type'] = $get_product['container_type'];
                $Data['container_size'] = $get_product['container_size'];
                $Data['presentation'] = $get_product['presentation'];
                $Data['units'] = $get_product['units'];
                $Data['wholesale_container_price'] = $get_product['wholesale_container_price'];

                $Data['single_portion_size'] = $get_product['single_portion_size'];
                $Data['single_portion_unit'] = $get_product['single_portion_unit'];
                $Data['retail_portion_price'] = $get_product['retail_portion_price'];
                $Data['full_weight'] = $get_product['full_weight'];

                $Data['empty_weight'] = $get_product['empty_weight'];
                $Data['case_size'] = $get_product['case_size'];
                $Data['vendor_id'] = $get_product['vendor_id'];
                $Data['par'] = $get_product['par'];

                $Data['reorder_point'] = $get_product['reorder_point'];
                $Data['order_by_the'] = $get_product['order_by_the'];
                $Data['ideal_pour_cost'] = $get_product['ideal_pour_cost'];
                $Data['User_ID']  = $user_id;
                $Data['status'] = $get_product['status'];
                $Data['admin_id'] = '0';
                $Data['superadmin_id'] = $user_id;
                $Data['source'] = 'Web'; 
                ProductsModel::create($Data); 

                $UpdateData = array();      
                $UpdateData['status'] = '1';

                ProductsModel::where(['ProductID' => $ProductID])->update($UpdateData);  

                $request->session()->flash('success', 'Product add to master');
              }
              
          }  
        }else{
          $request->session()->flash('danger', 'This product is already added');
        }
    }


    public function product_remove_master(Request $request){
        $user_id = Session::get('user_id');
        $product_name = $request->product_name;
        $ProductID = $request->ProductID;
        if(!empty($ProductID)){

          ProductsModel::where(['User_ID' => $user_id,'product_name' => $product_name])->delete();

          $UpdateData = array();      
          $UpdateData['status'] = '0';

          ProductsModel::where(['ProductID' => $ProductID])->update($UpdateData);  
          $request->session()->flash('success', 'Product Remove from master');
        }
    }

    public function get_categories(Request $request){
        $Product_type_id = $request->Product_type_id;

        $get_categories = ProductCategorieModel::where(['product_type_id' => $Product_type_id])->get()->toArray();
       
        $html = '';
        if ($get_categories) {
            
            $html .= '<select class="form-control select2box" id="product_categorie_id" name="product_categorie_id">'; 
            $html .= '<option value="">Select categorie</option>';
                foreach ($get_categories as $value) {
                $html .='<option value="'.$value['categorie_name'].'" ';
                $html .='>'.$value['categorie_name'].'</option>';
                }
            $html .='</select>';

        } else {
          $html .= '<p>Please assign categorie in product type</p>';
        }
        // $response['seed'] = $html; 
        echo json_encode($html);
        die;
       /* echo $html;
        die();*/
    }


    public function delete_product(Request $request){
      if($_GET['ProductID'] != ''){
         $ProductID = $_GET['ProductID'];
          
         ProductsModel::where('ProductID', $ProductID)->delete();

         $request->session()->flash('danger', 'Products deleted successfully!');
         return redirect('products');  
      }
    }

}
