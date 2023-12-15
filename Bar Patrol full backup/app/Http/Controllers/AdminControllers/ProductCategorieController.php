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
use App\Models\ProductCategorieModel;

class ProductCategorieController extends Controller
{

    public function productcategorie(){
      $data = array();
      $data['main_menu'] = 'Product type';
      $user_id = Session::get('user_id');
      $data['user_details'] = UserModel::where(['id' => $user_id])->first()->toArray();
      
      // Product categorie added by user
        $get_user_product_categorie = ProductCategorieModel::where(['User_ID' => $user_id])->get();
        $user_products = array();
        foreach ($get_user_product_categorie as $key => $value) {
            $product['Categorie_ID'] = $value['Categorie_ID'];
            $product['categorie_name'] = $value['categorie_name'];

            $product['product_type_name'] = '';
            $get_product_type = ProductTypeModel::where(['id' =>  $value['product_type_id']])->first();
            if (!empty($get_product_type)) {
              $product['product_type_name'] = $get_product_type['name'];
            }

            $product['restaurant_name'] = '';
            $single_user_details = UserModel::where(['id' => $value['User_ID']])->first();
            if (!empty($single_user_details)) {
               $product['restaurant_name'] = $single_user_details['restaurant_name'];
            }

            $product['status'] = $value['status'];
            $user_products[] = $product;
        }

      // Product categorie added all admin
        $get_admin_product_categorie = ProductCategorieModel::where('User_ID' ,'!=', '1')->get();
        $admin_products = array();
        foreach ($get_admin_product_categorie as $key => $value) {
            $product['Categorie_ID'] = $value['Categorie_ID'];
            $product['categorie_name'] = $value['categorie_name'];

            $product['product_type_name'] = '';
            $get_product_type = ProductTypeModel::where(['id' =>  $value['product_type_id']])->first();
            if (!empty($get_product_type)) {
              $product['product_type_name'] = $get_product_type['name'];
            }

            $product['restaurant_name'] = '';
            $single_user_details = UserModel::where(['id' => $value['User_ID']])->first();
            if (!empty($single_user_details)) {
               $product['restaurant_name'] = $single_user_details['restaurant_name'];
            }

            $product['status'] = $value['status'];
            $admin_products[] = $product;
        }


      // Product categorie added Super admin
        $get_master_product_categorie = ProductCategorieModel::where('User_ID' ,'=', '1')->get();
        $master_products = array();
        foreach ($get_master_product_categorie as $key => $value) {
            $product['Categorie_ID'] = $value['Categorie_ID'];
            $product['categorie_name'] = $value['categorie_name'];

            $product['product_type_name'] = '';
            $get_product_type = ProductTypeModel::where(['id' =>  $value['product_type_id']])->first();
            if (!empty($get_product_type)) {
              $product['product_type_name'] = $get_product_type['name'];
            }

            $product['restaurant_name'] = '';
            $single_user_details = UserModel::where(['id' => $value['User_ID']])->first();
            if (!empty($single_user_details)) {
               $product['restaurant_name'] = $single_user_details['restaurant_name'];
            }

            $product['status'] = $value['status'];
            $master_products[] = $product;
        }


      return view('admin.Product_categorie.product_categorie',compact('data','user_products','admin_products','master_products'));
    }

  
    public function add_productcategorie(){  
      $data = array();

      $data['main_menu'] = 'Product type'; 
      $data['heading'] = 'Add Categorie'; 
      $user_id = Session::get('user_id');
      $data['user_details'] = UserModel::where(['id' => $user_id])->first()->toArray();

      $get_product_types = ProductTypeModel::all()->toArray();
     
        $products = array();
        $products['categorie_name']  = '';
        $products['product_type_id'] = '';
        $products['status'] = '';
        $products['User_ID'] = '';

        if(@$_GET['Categorie_ID'] != ''){
            $data['heading'] = 'Edit Categorie';

            $Categorie_ID = $_GET['Categorie_ID'];
             $get_product_categorie = ProductCategorieModel::where(['Categorie_ID'=>$Categorie_ID])->first()->toArray();
             $products['Categorie_ID'] = $get_product_categorie['Categorie_ID'];
             $products['categorie_name'] = $get_product_categorie['categorie_name']; 
             $products['product_type_id'] = $get_product_categorie['product_type_id'];        
             $products['status'] = $get_product_categorie['status'];
              $products['User_ID'] = $get_product_categorie['User_ID'];
        }
       
        return view('admin.Product_categorie.add_productcategorie',compact('products','data','get_product_types'));       
    }


    public function save_categorie(Request $request){
        $user_id = Session::get('user_id');
        $user_details = UserModel::where(['id' => $user_id])->first();
        $Categorie_ID = $request->Categorie_ID; 
        
        $data = $request->all();

          if ($Categorie_ID!='') {

              $get_cat = ProductCategorieModel::where('Categorie_ID','!=',$Categorie_ID)->where('User_ID',$user_id)->where('categorie_name',$data['categorie_name'])->first();
              if($get_cat){
                $error['categorie_name'] = "The Categorie name is already taken";
                return response()->json(array('error' => $error));
              }

              $get_categorie = ProductCategorieModel::where(['Categorie_ID' => $Categorie_ID])->first();
              $Categorie_ID = $get_categorie['Categorie_ID'];

                $UpdateData = array();
                $UpdateData['status'] = $data['status'];
                $UpdateData['product_type_id'] = $data['product_type_id'];
                $UpdateData['categorie_name'] = $data['categorie_name'];
                $UpdateData['User_ID'] = $data['User_ID'];

                ProductCategorieModel::where(['Categorie_ID' => $Categorie_ID])->update($UpdateData);
                $request->session()->flash('success', 'Product categorie Updated successfully!');
          }else{
            $input = $request->all();
            $rules = [];
            $rules['categorie_name'] = 'required';
            $rules['product_type_id'] = 'required';
            $required_msg = "The :attribute field is required.";

            $custom_msg = [];
            $custom_msg['required'] = $required_msg;

            $validator = Validator::make($input, $rules, $custom_msg);

            if ($validator->fails()) {
                return response()->json(array('error'=>$validator->getMessageBag()->toArray(),));
            }

            $get_cate = ProductCategorieModel::where('User_ID',$user_id)->where('categorie_name',$data['categorie_name'])->first();
            if($get_cate){
              $error['categorie_name'] = "The Categorie name is already taken";
              return response()->json(array('error' => $error));
            }

            $Data = array();
            $Data['categorie_name'] = $data['categorie_name'];
            $Data['product_type_id'] = $data['product_type_id'];
            $Data['User_ID']  = $user_id;
            if ($user_id=='1') {
              $Data['status'] = '1';
              $Data['superadmin_id'] = $user_id;
            }else{
              $Data['status'] = '0';
              $Data['admin_id'] = $user_id;
            }

            $insert_id = ProductCategorieModel::create($Data);
            $request->session()->flash('success', 'Product categorie added successfully!');           
      
          }   
    }


    public function addcategorie_from_master(Request $request){
        $user_id = Session::get('user_id');

        $Categorie_ID = $request->Categorie_ID;
        $categorie_name = $request->categorie_name;
        $get_admin_categorie = ProductCategorieModel::where(['categorie_name' => $categorie_name,'User_ID' => $user_id])->first();
        if (empty($get_admin_categorie)) {
          if(!empty($Categorie_ID)){
              $get_categorie = ProductCategorieModel::where(['Categorie_ID' => $Categorie_ID])->first();
              if(!empty($get_categorie)){
                $Data = array();
                $Data['categorie_name'] = $get_categorie['categorie_name'];
                $Data['product_type_id'] = $get_categorie['product_type_id'];
                $Data['User_ID'] = $user_id;
                $Data['status'] = $get_categorie['status'];
                $Data['admin_id'] = $user_id;
                $Data['superadmin_id'] = '0';

                ProductCategorieModel::create($Data); 
                $request->session()->flash('success', 'Categorie add to master');
              }
              
          }  
        }else{
          $request->session()->flash('danger', 'This categorie is already added');
        }
      
    }

    public function categorie_movetomaster(Request $request){
        $user_id = Session::get('user_id');
        $Categorie_ID = $request->Categorie_ID;
        $categorie_name = $request->categorie_name;

        $get_admin_categorie = ProductCategorieModel::where(['categorie_name' => $categorie_name,'User_ID' => $user_id])->first();
        if (empty($get_admin_categorie)) {
          if(!empty($Categorie_ID)){
              $get_categorie = ProductCategorieModel::where(['Categorie_ID' => $Categorie_ID])->first();
              if(!empty($get_categorie)){
                $Data = array();
                $Data['categorie_name'] = $get_categorie['categorie_name'];
                $Data['product_type_id'] = $get_categorie['product_type_id'];
                $Data['User_ID'] = $user_id;
                $Data['status'] = $get_categorie['status'];
                $Data['admin_id'] = '0';
                $Data['superadmin_id'] = $user_id;

                ProductCategorieModel::create($Data); 

                $UpdateData = array();      
                $UpdateData['status'] = '1';

                ProductCategorieModel::where(['Categorie_ID' => $Categorie_ID])->update($UpdateData);

                $request->session()->flash('success', 'Categorie move to master');
              }
              
          }  
        }else{
          $request->session()->flash('danger', 'This categorie is already added');
        }
    }


    public function categorie_remove_master(Request $request){
        $user_id = Session::get('user_id');
        $Categorie_ID = $request->Categorie_ID;
        $categorie_name = $request->categorie_name;

        if(!empty($Categorie_ID)){

          ProductCategorieModel::where(['categorie_name' => $categorie_name,'User_ID' => $user_id])->delete();

          $UpdateData = array();      
          $UpdateData['status'] = '0';

          ProductCategorieModel::where(['Categorie_ID' => $Categorie_ID])->update($UpdateData);  
          $request->session()->flash('success', 'Product categorie Remove from master');
        }
    }

    public function delete_categorie(Request $request){
      if($_GET['Categorie_ID'] != ''){
         $Categorie_ID = $_GET['Categorie_ID'];
          
         ProductCategorieModel::where('Categorie_ID', $Categorie_ID)->delete();

         $request->session()->flash('danger', 'Product Categorie deleted successfully!');
         return redirect('productcategorie');  
      }
    }

}
