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
use App\Models\InventriesModel;
use App\Models\InventriesProductModel;
use App\Models\LocationsModel;
use App\Models\VendorModel;
use App\Models\ProductsModel;

class InventriesController extends Controller
{

  public function inventries(){

    $data = array();
    $data['main_menu'] = 'Inventry';
    $user_id = Session::get('user_id');
    $data['user_details'] = UserModel::where(['id' => $user_id])->first()->toArray();

    $get_vendors = VendorModel::where(['User_ID' => $user_id])->get();
    $get_inventries_date = InventriesModel::where(['User_ID' => $user_id])->get();
    $get_products = ProductsModel::where(['User_ID' => $user_id])->get();
    $get_master_products = ProductsModel::where(['User_ID' => '1'])->get();
    $get_locations = LocationsModel::where(['User_ID' => $user_id])->get();

    @$Date = $_GET['Date'];
    if ($Date != '') {
      $get_inventries = InventriesModel::where(['date' => @$Date, 'User_ID' => $user_id])->orderBy('InventryID', 'desc')->get();
    } else {
      $get_inventries = InventriesModel::where(['User_ID' => $user_id])->orderBy('InventryID', 'desc')->get();
    }

    $inventries = array();

    foreach ($get_inventries as $key => $value) {
      $inventry['InventryID'] = $value['InventryID'];
      $inventry['location'] = $value['location'];
      $inventry['description'] = $value['description'];
      $inventry['date'] = $value['date'];
      $inventry['vendor_name'] = '';
      if ($value['vendor_id'] != '') {
        $get_vendor = VendorModel::where(['VendorID' => $value['vendor_id']])->first();
        $inventry['vendor_name'] = @$get_vendor['vendor_name'];
      }

      $inventry['inventrie_notes'] = $value['inventrie_notes'];
      $inventries[] = $inventry;
    }

    // draft inventries
    $get_draft_inventry = InventriesProductModel::where(['InventryID' => 0, 'User_ID' => $user_id])->orderBy("sort_order", "ASC")->get();

    return view('admin.Inventry.index', compact('data', 'get_inventries_date', 'inventries', 'get_vendors', 'get_products', 'get_locations', 'get_draft_inventry', 'get_master_products'));
  }

  public function edit_inventries(){

    $data = array();
    $data['main_menu'] = 'Inventry';
    $user_id = Session::get('user_id');
    $data['user_details'] = UserModel::where(['id' => $user_id])->first();

    $get_vendors = VendorModel::where(['User_ID' => $user_id])->get();
    $get_products = ProductsModel::where(['User_ID' => $user_id])->get();
    $get_locations = LocationsModel::where(['User_ID' => $user_id])->get();

    $inventries = array();
    $inventries['location_name']  = '';
    $inventries['description']  = '';
    $inventries['date']  = '';
    $inventries['inventrie_notes']  = '';
    $inventries['vendor_id']  = '';

    if (@$_GET['InventryID'] != '') {

      $InventryID = $_GET['InventryID'];
      $get_inventry = InventriesModel::where(['InventryID' => $InventryID, 'User_ID' => $user_id])->first();
      if ($get_inventry) {
        $inventries['InventryID'] = $get_inventry['InventryID'];
        $inventries['location_name'] = $get_inventry['location'];
        $inventries['description']  = $get_inventry['description'];
        $inventries['date']  = $get_inventry['date'];
        $inventries['inventrie_notes']  = $get_inventry['inventrie_notes'];
        $inventries['vendor_id']  = $get_inventry['vendor_id'];

        $get_inventryproducts = InventriesProductModel::where(['InventryID' => $InventryID, 'User_ID' => $user_id])->orderBy("sort_order", "ASC")->get();
      } else {
        return redirect('inventries');
      }
    }
    return view('admin.Inventry.edit_inventries', compact('data', 'inventries', 'get_vendors', 'get_products', 'get_locations', 'get_inventryproducts'));
  }

  public function save_single_inventrie(Request $request){
    // $Location = $request->Location;
    $user_id = Session::get('user_id');
    $input = $request->all();
    $data = $request->all();
    $datapostproducts = array();
    $datapostproducts['InventryID'] = 0;
    $datapostproducts['product_id'] = $data['get_product_id'];
    $datapostproducts['product_name'] = $data['get_product_name'];
    $datapostproducts['location_id'] = $data['get_location_id'];
    $datapostproducts['location_name'] = $data['get_location_name'];
    $datapostproducts['quantity_type'] = $data['get_quantity_type'];
    $datapostproducts['case_size'] = $data['get_case_size'];
    $datapostproducts['quantity'] = $data['get_quantity'];
    $datapostproducts['weight'] = $data['get_weight'];
    $datapostproducts['whole_sale_value'] = $data['get_whole_sale_value'];
    $datapostproducts['retail_value'] = $data['get_retail_value'];
    $datapostproducts['User_ID'] = $user_id;

    // echo "<pre>"; 
    // print_r($datapostproducts);
    // echo "</pre>";
    // die();
    $insert_product_id = InventriesProductModel::create($datapostproducts);
  }

  public function update_single_inventrie(Request $request){
    // $Location = $request->Location;
    $user_id = Session::get('user_id');
    $input = $request->all();
    $data = $request->all();
    $datapostproducts = array();
    $datapostproducts['InventryID'] = $data['get_inventry_id'];
    $datapostproducts['product_id'] = $data['get_product_id'];
    $datapostproducts['product_name'] = $data['get_product_name'];
    $datapostproducts['location_id'] = $data['get_location_id'];
    $datapostproducts['location_name'] = $data['get_location_name'];
    $datapostproducts['quantity_type'] = $data['get_quantity_type'];
    $datapostproducts['case_size'] = $data['get_case_size'];
    $datapostproducts['quantity'] = $data['get_quantity'];
    $datapostproducts['weight'] = $data['get_weight'];
    $datapostproducts['whole_sale_value'] = $data['get_whole_sale_value'];
    $datapostproducts['retail_value'] = $data['get_retail_value'];
    $datapostproducts['User_ID'] = $user_id;


    $insert_product_id = InventriesProductModel::create($datapostproducts);
  }

  public function save_inventrie(Request $request){
    $user_id = Session::get('user_id');
    $input = $request->all();
    $rules = [];
    $rules['location'] = 'required';
    $rules['date'] = 'required';
    $rules['product_name'] = 'required';
    $required_msg = "The :attribute field is required.";
    $custom_msg = [];
    $custom_msg['required'] = $required_msg;


    $validator = Validator::make($input, $rules, $custom_msg);

    if ($validator->fails()) {
      return response()->json(array('error' => $validator->getMessageBag()->toArray(),));
    }
    // edit condition
    $inventry_id = $request->inventry_id;
    if ($inventry_id != '') {
      $data = $request->all();

      $Data = array();
      $Data['location_id'] = $data['location'];
      $get_locations_details = LocationsModel::where(['LocationID' => $Data['location_id']])->first();
      $Data['location'] = $get_locations_details['location_name'];
      $Data['description']  = $data['description'];
      $Data['date']  = $data['date'];
      $Data['inventrie_notes']  = $data['inventrie_notes'];
      $Data['vendor_id']  = $data['vendor_id'];
      $Data['User_ID']  = $user_id;

      InventriesModel::where('InventryID', $inventry_id)->delete();
      // InventriesProductModel::where('InventryID', $inventry_id)->delete(); 

      $insert_id = InventriesModel::create($Data);
      // echo "<pre>"; 
      // print_r($insert_id);
      // echo "</pre>";
      // die();
      $InventryID = $insert_id;
      $InventryID['id'];

      $Inventry_ID = $data['InventryID'];
      $Product_ID = $data['product_id'];
      $Product_name = $data['product_name'];
      $Location_ID = $data['location_id'];
      $Location_name = $data['location_name'];
      $Quantity_type = $data['quantity_type'];
      $Case_size = $data['case_size'];
      $Quantity = $data['quantity'];
      $Weight = $data['weight'];
      $Whole_sale_value = $data['whole_sale_value'];
      $Retail_value = $data['retail_value'];


      foreach ($Quantity_type as $key => $value) {
        $datapostproducts = array();
        $datapostproducts['InventryID'] = $InventryID['id'];

        InventriesProductModel::where(['InventryID' => $Inventry_ID[$key], 'User_ID' => $user_id])->update($datapostproducts);
      }

      $request->session()->flash('success', 'Inventry Updated successfully!');
    } else {
      $InventryID = $request->InventryID;
      $data = $request->all();

      $Data = array();
      $Data['location_id'] = $data['location'];
      $get_locations_details = LocationsModel::where(['LocationID' => $Data['location_id']])->first();
      $Data['location'] = $get_locations_details['location_name'];
      $Data['description']  = $data['description'];
      $Data['date']  = $data['date'];
      $Data['inventrie_notes']  = $data['inventrie_notes'];
      $Data['vendor_id']  = $data['vendor_id'];
      $Data['User_ID']  = $user_id;

      $insert_id = InventriesModel::create($Data);

      $InventryID = $insert_id;
      $InventryID['id'];

      $Inventry_ID = $data['InventryID'];
      $Product_ID = $data['product_id'];
      $Product_name = $data['product_name'];
      $Location_ID = $data['location_id'];
      $Location_name = $data['location_name'];
      $Quantity_type = $data['quantity_type'];
      $Case_size = $data['case_size'];
      $Quantity = $data['quantity'];
      $Weight = $data['weight'];
      $Whole_sale_value = $data['whole_sale_value'];
      $Retail_value = $data['retail_value'];


      foreach ($Quantity_type as $key => $value) {
        $datapostproducts = array();
        $datapostproducts['InventryID'] = $InventryID['id'];

        InventriesProductModel::where(['InventryID' => $Inventry_ID[$key], 'User_ID' => $user_id])->update($datapostproducts);
      }

      $request->session()->flash('success', 'Inventry added successfully!');
    }
  }

  public function get_products(Request $request){
    $Product_ID = $request->Product_ID;
    $get_products = ProductsModel::where(['ProductID' => $Product_ID])->first();

    $get_ajx_case_size = $get_products['case_size'];
    $get_full_weight = $get_products['full_weight'];
    $get_whole_sale_value = $get_products['wholesale_container_price'];
    $get_retail_portion_price = $get_products['retail_portion_price'];
    $get_container_type = $get_products['container_type'];

    $array = array(
      'error'   => false,
      'get_ajx_case_size' => $get_ajx_case_size,
      'get_full_weight' => $get_full_weight,
      'get_whole_sale_value' => $get_whole_sale_value,
      'get_retail_portion_price' => $get_retail_portion_price,
      'get_container_type' => $get_container_type,
    );
    echo json_encode($array);
    die;
  }

  public function get_locations(Request $request){
    $user_id = Session::get('user_id');

    $Location_ID = $request->Location_ID;

    $get_locations_details = InventriesProductModel::where(['location_id' => $Location_ID, 'User_ID' => $user_id])->orderBy("sort_order","ASC")->get();
    $html = '';
    if (count($get_locations_details) > 0) {
      $cnt = 1;
      $html .= '<div class="table-responsive table-sorti">';
      $html .= 'Previous added location';
      $html .= '<table class="table table_products">';
      $html .= '<thead>';
      $html .= '<tr>';
      $html .= '<th>S.no.</th>';
      $html .= '<th>Products name</th>';
      $html .= '<th>Location ID</th>';
      $html .= '<th>Location name</th>';
      $html .= '<th>Quantity Type</th>';
      $html .= '<th>Case Size</th>';
      $html .= '<th>Quantity</th>';
      $html .= '<th>Weight</th>';
      $html .= '<th>Whole sale value</th>';
      $html .= '<th>Retail value</th>';
      $html .= '<th>Action</th>';
      $html .= '</tr>';
      $html .= '</thead>';
      $html .= '<tbody class="sort_ajax">';
      foreach ($get_locations_details as $key => $value) {
        if ($value['sort_order']!='') {
          $number = $value['sort_order'];
        }else{
          $number = $cnt; 
        }
        
        $html .= '<tr id='.$value['Inventries_productsID'].' style="cursor: grab;">
                      <td>'.$number.'</td>
                      <td>
                        <input type="hidden" class="form-control" value="' . $value['product_id'] . '" readonly/>
                        <input type="text" class="form-control" value="' . $value['product_name'] . '" readonly/></td>
                      <td><input type="text"  class="form-control" value="' . $value['location_id'] . '" readonly/></td>
                      <td><input type="text"  class="form-control" value="' . $value['location_name'] . '" readonly/></td>
                      <td><input type="text"  class="form-control" value="' . $value['quantity_type'] . '" readonly/></td>
                      <td><input type="text" class="form-control" value="' . $value['case_size'] . '" readonly/></td>
                      <td><input type="number"  class="form-control quantity_focus" value="' . $value['quantity'] . '" data-id="' . $value['Inventries_productsID'] . '"/></td>
                      <td><input type="number" class="form-control weight_focus" value="' . $value['weight'] . '" data-id="' . $value['Inventries_productsID'] . '"/></td>
                      <td><input type="number"  class="form-control" value="' . $value['whole_sale_value'] . '" readonly/></td>
                      <td><input type="number"  class="form-control" value="' . $value['retail_value'] . '" readonly/></td>
                      <td><button type="button" name="remove" id="ajx_btn_remove" class="btn btn-danger btn_remove" data-id="' . $value['Inventries_productsID'] . '">X</button></a></td>
                  </tr>';
      $cnt++;}
      $html .= '</tbody>';
      $html .= '</table>';
      $html .= '</div>';
      $html .= '</div>';
    } else {
      $html .= '<p>No products assign for this location</p>';
    }

    echo $html;
    die();
  }

  public function update_quantity(Request $request)
  {
    $user_id = Session::get('user_id');
    $Inventries_productsID = $request->Inventries_productsID;
    $Quantity = $request->Quantity;
    $input = $request->all();
    $data = $request->all();
    $datapostproducts = array();
    $datapostproducts['quantity'] = $Quantity;

    InventriesProductModel::where(['Inventries_productsID' => $Inventries_productsID, 'User_ID' => $user_id])->update($datapostproducts);
  }

  public function update_weight(Request $request)
  {
    $user_id = Session::get('user_id');
    $Inventries_productsID = $request->Inventries_productsID;
    $Weight = $request->Weight;
    $input = $request->all();
    $data = $request->all();
    $datapostproducts = array();
    $datapostproducts['weight'] = $Weight;
    // echo "<pre>"; 
    // print_r($datapostproducts);
    // echo "</pre>";
    // die();
    InventriesProductModel::where(['Inventries_productsID' => $Inventries_productsID, 'User_ID' => $user_id])->update($datapostproducts);
  }

  // edit inventry
  public function add_inventrie(){

    $data = array();
    $data['main_menu'] = 'Inventry';
    $user_id = Session::get('user_id');
    $data['user_details'] = UserModel::where(['id' => $user_id])->first();
    $get_locations = LocationsModel::where(['User_ID' => $user_id])->get();

    $get_vendors = VendorModel::where(['User_ID' => $user_id])->get();
    $inventries = array();
    $inventries['location_id']  = '';
    $inventries['location_name']  = '';
    $inventries['description']  = '';
    $inventries['date']  = '';
    $inventries['inventrie_notes']  = '';
    $inventries['vendor_id']  = '';

    if (@$_GET['InventryID'] != '') {

      $InventryID = $_GET['InventryID'];
      $get_inventry = InventriesModel::where(['InventryID' => $InventryID, 'User_ID' => $user_id])->first();

      $inventries['InventryID'] = $get_inventry['InventryID'];
      $inventries['location_name'] = $get_inventry['location'];
      $inventries['description']  = $get_inventry['description'];
      $inventries['date']  = $get_inventry['date'];
      $inventries['inventrie_notes']  = $get_inventry['inventrie_notes'];
      $inventries['vendor_id']  = $get_inventry['vendor_id'];
    }

    return view('admin.Inventry.add_inventry', compact('inventries', 'data', 'get_vendors', 'get_locations'));
  }

  // View inventry
  public function view_inventrie(Request $request){

    $data = array();
    $data['main_menu'] = 'Inventry';
    $user_id = Session::get('user_id');
    $data['user_details'] = UserModel::where(['id' => $user_id])->first();

    $get_locations = LocationsModel::where(['User_ID' => $user_id])->get();
    $get_vendors = VendorModel::where(['User_ID' => $user_id])->get();

    if (@$_GET['InventryID'] != '') {
      $InventryID = $_GET['InventryID'];
      $get_inventry = InventriesModel::where(['InventryID' => $InventryID, 'User_ID' => $user_id])->first();
      if ($get_inventry) {

        $data['location'] = $get_inventry['location'];
        $data['date'] = $get_inventry['date'];

        $get_inventry_products = InventriesProductModel::where(['InventryID' => $InventryID, 'User_ID' => $user_id])->distinct()->get(['location_name'])->toArray();

        $inventrie_products = array();
        foreach ($get_inventry_products as $key => $value) {
          $product['location_name'] = $value['location_name'];
          $inventrie_products[] = $product;
        }

        return view('admin.Inventry.view_inventrie', compact('inventrie_products', 'data', 'get_vendors', 'get_locations'));
      } else {
        $request->session()->flash('danger', 'No inventries');
        return redirect('inventries');
      }
    } else {
      $request->session()->flash('danger', 'Please select inventry');
      return redirect('inventries');
    }
  }

  public function view_locationinventrie(){

    $data = array();
    $data['main_menu'] = 'Inventry';
    $user_id = Session::get('user_id');
    $data['user_details'] = UserModel::where(['id' => $user_id])->first();

    $get_vendors = VendorModel::where(['User_ID' => $user_id])->get();
    $get_products = ProductsModel::where(['User_ID' => $user_id])->get();
    $get_locations = LocationsModel::where(['User_ID' => $user_id])->get();

    @$Location = $_GET['Location'];
    @$ProductSearch = $_GET['ProductSearch'];
    @$LocationSearch = $_GET['LocationSearch'];

    if ($ProductSearch != '' || $LocationSearch != '') {
      $get_inventry_products = InventriesProductModel::where(['User_ID' => $user_id])->where('product_name', 'LIKE', '%' . $ProductSearch . '%')->where('location_name', '=', $LocationSearch)->get()->toArray();
    } else {
      $get_inventry_products = InventriesProductModel::where(['location_name' => $Location, 'User_ID' => $user_id])->get()->toArray();
    }
    $inventrie_products = array();
    if ($get_inventry_products) {
      $data['location'] = $get_inventry_products[0]['location_name'];
      $InventryID = $get_inventry_products[0]['InventryID'];

      $data['InventryID'] = $InventryID;

      $get_inventry = InventriesModel::where(['InventryID' => $InventryID, 'User_ID' => $user_id])->first()->toArray();
      $data['date'] = $get_inventry['date'];

      foreach ($get_inventry_products as $key => $value) {
        $product['product_name'] = $value['product_name'];
        $product['location_name'] = $value['location_name'];
        $product['quantity_type'] = $value['quantity_type'];
        $product['case_size'] = $value['case_size'];
        $product['quantity'] = $value['quantity'];
        $product['weight'] = $value['weight'];
        $product['whole_sale_value'] = $value['whole_sale_value'];
        $product['retail_value'] = $value['retail_value'];
        $inventrie_products[] = $product;
      }
    }

    return view('admin.Inventry.view_locationinventrie', compact('inventrie_products', 'data', 'get_vendors', 'get_products', 'get_locations'));
  }


  public function save_inventrie_products(Request $request){
    $input = $request->all();
    $rules = [];
    $rules['quantity_type'] = 'required';
    $rules['case_size'] = 'required';
    $rules['weight'] = 'required';
    $rules['quantity'] = 'required';
    $rules['whole_sale_value'] = 'required';
    $rules['retail_value'] = 'required';

    $required_msg = "The :attribute field is required.";
    $custom_msg = [];
    $custom_msg['required'] = $required_msg;
    $validator = Validator::make($input, $rules, $custom_msg);

    if ($validator->fails()) {
      return response()->json(array('error' => $validator->getMessageBag()->toArray(),));
    }
    $InventryID = $request->InventryID;
    $data = $request->all();
    $Data = array();

    $Data['InventryID']  = $data['InventryID'];
    $Data['quantity_type'] = $data['quantity_type'];
    $Data['case_size']  = $data['case_size'];
    $Data['weight']  = $data['weight'];
    $Data['quantity']  = $data['quantity'];
    $Data['whole_sale_value'] = $data['whole_sale_value'];
    $Data['retail_value']  = $data['retail_value'];
    $insert_id = InventriesProductModel::create($Data);
    return redirect('add_inventrie');
    // $request->session()->flash('success', 'Inventry added successfully!');              

  }

  public function delete_inventrie(Request $request) {
    if ($_GET['InventryID'] != '') {
      $InventryID = $_GET['InventryID'];

      InventriesProductModel::where('InventryID', $InventryID)->delete();
      InventriesModel::where('InventryID', $InventryID)->delete();

      $request->session()->flash('danger', 'Inventry deleted successfully!');
      return redirect('inventries');
    }
  }

  public function delete_inventrie_products(Request $request){
    $Inventries_productsID = $request->Inventries_productsID;


    if ($Inventries_productsID != '') {
      InventriesProductModel::where('Inventries_productsID', $Inventries_productsID)->delete();
    }
  }
}
