<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

use App\Models\Country;
use App\Models\States;
use App\Models\City;

use App\Models\ProductRequestForm;
use App\Models\Language;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;



class ProductRequestController extends Controller
{
    //
    public function product_request(Request $request , $type='')
    {
        $type =  @$_GET['type'];
        $common = array();
        Session::put("TopMenu", "Request");
        Session::put("SubMenu", "Yacht Request");
        $common['title']  = translate("Yacht Request");

        $get_request = [];

        if ($type == 'Yatch') {
            Session::put("SubMenu", "Yacht Request");
            $common['title']  = translate("Yacht Request");

        }elseif ($type == 'Limousine') {

            Session::put("SubMenu", "Limousine Request");
            $common['title']  = translate("Limousine Request");

        }elseif ($type == 'lodge') {

            Session::put("SubMenu", "Lodge Request");
            $common['title']  = translate("Lodge Request");

        }elseif ($type == 'excursion') {

            Session::put("SubMenu", "Excursion Request");
            $common['title']  = translate("Excursion Request");

        }

        $get_request = ProductRequestForm::where(['product_type' => $type])->orderBy('id', 'desc')->paginate(config('adminconfig.records_per_page'));


        return view('admin.Request_forms.yacht_list', compact('common','get_request'));
    }


    public function product_request_view(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Request");
        Session::put("SubMenu", "Yacht Request");
        $common['title']      = translate("View Yacht Request");
        $get_order = [];
        $orders  = array();
        if ($id != "") {

            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id = checkDecrypt($id);

            $get_order =  ProductRequestForm::where('id', $id)->first();
            if ($get_order) {
                $orders['id']            = $get_order['id'];
                $orders['order_id']      = $get_order['order_id'];

                $orders['user_id']       = $get_order['user_id'];
                $get_user_details = User::select('*')->where('id', $get_order['user_id'])->first(); 
                if ($get_user_details) {
                    $orders['first_name']    = $get_user_details['name'];
                    $orders['email']         = $get_user_details['email'];
                    $orders['phone_code']    = $get_user_details['phone_code'];
                    $orders['phone_number']  = $get_user_details['phone_number'];
                    $orders['address']       = $get_user_details['address'];

                    $orders['country']  = '';
                    $orders['city']     = '';
                    $get_country = Country::where('id',$get_user_details['country'])->first();
                    if ($get_country) {
                        $orders['country'] = $get_country['name'];
                    }
                    $get_city = City::where('id',$get_user_details['city'])->first();
                    if ($get_city) {
                        $orders['city'] = $get_city['name'];
                    }
                }
                $orders['total']           = $get_order['total'];
                $orders['payment_method']  = $get_order['payment_method'];
                $orders['status']          = $get_order['status'];
                $orders['created_at']      = $get_order['created_at'];
                $orders['postcode']        = $get_order['postcode'];


                $orders['products_detail']   = json_decode($get_order['extra']);
               
            }


            if (!$get_order) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.Request_forms.request_view', compact('common', 'get_order','orders'));
    }

}    