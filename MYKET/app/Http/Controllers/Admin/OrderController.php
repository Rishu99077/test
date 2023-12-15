<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AffilliateCommission;
use App\Models\Orders;
use App\Models\Countries;
use App\Models\States;
use App\Models\Cities;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mail;
use App\Models\PartnerAdminCommission;
use App\Models\User;
use DB;

class OrderController
{
    // Orders List
    public function index(Request $request)
    {
        $common          = array();
        $common['title'] = translate("Orders");
        Session::put("TopMenu", translate("Sales"));
        Session::put("SubMenu", translate("Orders"));

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        // Filter
        if ($request->isMethod('post')) {
            if (isset($request->filter)) {
                Session::put('order_id', $request->order_id);
                Session::put('order_name', $request->order_name);
                Session::put('order_email', $request->order_email);
                Session::put('order_orderDate', $request->order_Date);
                Session::put('order_status', $request->order_status);
            } elseif (isset($request->reset)) {
                Session::put('order_id', '');
                Session::put('order_name', '');
                Session::put('order_email', '');
                Session::put('order_orderDate', '');
                Session::put('order_status', '');
            }
            return redirect()->route('admin.orders');
        }

        $order_id  = Session::get('order_id');
        $order_name      = Session::get('order_name');
        $order_email      = Session::get('order_email');
        $order_orderDate  = Session::get('order_orderDate');
        $order_status  = Session::get('order_status');

        $common['order_id']     = $order_id;
        $common['order_name']   = $order_name;
        $common['order_email']  = $order_email;
        $common['order_orderDate'] = $order_orderDate;
        $common['order_status'] = $order_status;

        $get_orders = Orders::orderBy('id', 'desc');

        if ($order_id) {
            $get_orders = $get_orders->where('order_id', 'like', '%' . $order_id . '%');
        }

        if ($order_name) {
            $get_orders = $get_orders->where(DB::raw('concat(`first_name`," ", `last_name`)'), 'like', '%' . $order_name . '%');
        }

        if ($order_email) {
            $get_orders = $get_orders->where('email', 'like', '%' . $order_email . '%');
        }
        if ($order_status) {
            $get_orders = $get_orders->where('status',  $order_status);
        }

        if ($order_orderDate) {
            $getordersDate = explode('to', $order_orderDate);
            $formdate = '';
            $todate = '';
            if (isset($getordersDate[0])) {
                $formdate = $getordersDate[0] . " 00:00:00";
                $get_orders->whereDate('created_at', '>=', $formdate);
            }
            if (isset($getordersDate[1])) {
                $todate = $getordersDate[1] . " 23:59:59";
                $get_orders->whereDate('created_at', '<=', $todate);
            }
        }

        $get_orders = $get_orders->paginate(config('adminconfig.records_per_page'));

        return view('admin.orders.index', compact('common', 'get_orders'));
    }

    public function orders_details(Request $request, $id = "")
    {

        $common          = array();
        $common['title'] = translate("Orders Deatils");
        Session::put("TopMenu", translate("Sales"));
        Session::put("SubMenu", translate("Orders"));

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id   = checkDecrypt($id);

            $orders = array();
            $get_orders  = Orders::where('id', $id)->first();
            if ($get_orders) {
                $orders['id']           = $get_orders['id'];
                $orders['user_name']    = $get_orders['first_name'] . ' ' . $get_orders['last_name'];
                $orders['order_id']     = $get_orders['order_id'];
                $orders['email']        = $get_orders['email'];
                $orders['phone']        = $get_orders['phone'];
                $orders['total_amount'] = $get_orders['total_amount'];
                $orders['status']       = $get_orders['status'];
                $orders['booking_date'] = $get_orders['booking_date'];
                $orders['created_at']   = $get_orders['created_at'];

                $orders['country']         = '';
                $orders['state']           = '';
                $orders['city']            = '';

                $get_country = Countries::where(['id' => $get_orders['country']])->first();
                if ($get_country) {
                    $orders['country']     = $get_country['name'];
                }
                $get_state = States::where(['id' => $get_orders['state']])->first();
                if ($get_state) {
                    $orders['state']       = $get_state['name'];
                }
                $get_city = Cities::where(['id' => $get_orders['city']])->first();
                if ($get_city) {
                    $orders['city']       = $get_city['name'];
                }
                $orders['address']         = $get_orders['address'];
                $orders['zipcode']         = $get_orders['zipcode'];

                $orders['products']        = json_decode($get_orders['order_json']);
            }

            $commissions = array();
            $get_affiliate_commission = AffilliateCommission::where('order_id', $id)->first();
            if ($get_affiliate_commission) {
                $commissions['user_id'] = $get_affiliate_commission['user_id'];
                $commissions['affilliate_code'] = $get_affiliate_commission['affilliate_code'];
                $commissions['total']        = $get_affiliate_commission['total'];
                $commissions['type']         = $get_affiliate_commission['type'];
                $commissions['order_id']     = $get_affiliate_commission['order_id'];
                $commissions['affilliate_commission'] = json_decode($get_affiliate_commission['product_json']);
            }

            if (!$get_orders) {
                return back()->withErrors(["error" => translate("Something went wrong")]);
            }
        }
        // echo "<pre>"; 
        //   print_r($commissions);
        //   echo "</pre>";die();

        return view('admin.orders.details', compact('common', 'get_orders', 'orders', 'commissions'));
    }

    public function change_status(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        $Orders = Orders::find($id);
        if ($Orders) {
            $Orders->status = $status;
            $Orders->save();
        }
    }


    public function test_template(Request $request)
    {

        $common          = array();
        $common['title'] = translate("Orders Deatils");
        Session::put("TopMenu", translate("Sales"));
        Session::put("SubMenu", translate("Orders"));

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $id   = 30;

        $get_partner_commission  = PartnerAdminCommission::where('id', $id)->first();

        if ($get_partner_commission) {
            $commissions = array();
            $commissions['products']                 = json_decode($get_partner_commission['product_json']);
            $commissions['product_total']            = $get_partner_commission['product_total'];
            $commissions['partner_total']            = $get_partner_commission['partner_total'];
            $commissions['admin_total_commission']   = $get_partner_commission['admin_total_commission'];
            $commissions['type']                     = $get_partner_commission['type'];
            $commissions['status']                   = $get_partner_commission['status'];

            $get_orders = Orders::where(['id' => $get_partner_commission['order_id']])->first();

            if ($get_orders) {
                $commissions['order_id'] = $get_orders['order_id'];
            }

            $commissions['user_name'] = '-';
            $get_affiliate  = User::where(['id' => $get_partner_commission['partner_id']])->first();
            if ($get_affiliate) {
                $commissions['user_name'] = $get_affiliate['first_name'] . ' ' . $get_affiliate['last_name'];
            }
        }

        return view('email.partner_commission', compact('common', 'get_partner_commission', 'commissions'));
    }
}
