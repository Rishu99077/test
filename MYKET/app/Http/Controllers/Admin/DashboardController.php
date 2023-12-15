<?php


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use App\Models\Countries;
use App\Models\States;
use App\Models\Cities;
use App\Models\User;
use App\Models\Languages;
use App\Models\Product;
use App\Models\Orders;
use View;

class DashboardController
{
    //
    public function index(Request $request)
    {

        $common = [];
        Session::put("TopMenu", translate("Dashboards"));
        Session::put("SubMenu", translate("Dashboards"));


        // Filter
        if ($request->isMethod('post')) {
            if (isset($request->filter)) {
                Session::put('order_orderDate', $request->order_Date);
            } elseif (isset($request->reset)) {
                Session::put('order_orderDate', '');
            }
            return redirect()->route('admin.dashboard');
        }

        $order_orderDate  = Session::get('order_orderDate');

        $common['order_orderDate'] = $order_orderDate;


        // Total Affilliates

        $get_AffiliateCount = User::where(['user_type' => 'Affiliate', 'is_delete' => null]);

        if ($order_orderDate) {
            $get_AffiliateCount = getDateFilter($get_AffiliateCount, $order_orderDate);
        }

        $data['AffiliateCount'] = $get_AffiliateCount->count();


        $get_PartnerCount = User::where(['user_type' => 'Partner', 'is_delete' => null]);

        if ($order_orderDate) {
            $get_PartnerCount = getDateFilter($get_PartnerCount, $order_orderDate);
        }

        $data['PartnerCount'] = $get_PartnerCount->count();


        $get_HotelCount = User::where(['user_type' => 'Hotel', 'is_delete' => null]);
        if ($order_orderDate) {
            $get_HotelCount = getDateFilter($get_HotelCount, $order_orderDate);
        }
        $data['HotelCount'] = $get_HotelCount->count();


        $get_ProductCount = Product::where(['is_delete' => null]);
        if ($order_orderDate) {
            $get_ProductCount = getDateFilter($get_ProductCount, $order_orderDate);
        }
        $data['ProductCount'] = $get_ProductCount->count();


        $get_HotelCommission = User::where(['user_type' => 'Hotel', 'is_delete' => null]);
        if ($order_orderDate) {
            $get_HotelCommission = getDateFilter($get_HotelCommission, $order_orderDate);
        }
        $HotelCommission = $get_HotelCommission->sum('total_commission');


        $get_HotelPaidCommission = User::where(['user_type' => 'Hotel', 'is_delete' => null]);
        if ($order_orderDate) {
            $get_HotelPaidCommission = getDateFilter($get_HotelPaidCommission, $order_orderDate);
        }
        $HotelPaidCommission = $get_HotelPaidCommission->sum('total_paid');

        $get_AffilliateCommission = User::where(['user_type' => 'Affiliate', 'is_delete' => null]);
        if ($order_orderDate) {
            $get_AffilliateCommission = getDateFilter($get_AffilliateCommission, $order_orderDate);
        }
        $AffilliateCommission = $get_AffilliateCommission->sum('total_commission');

        $get_AffilliatePaidCommission = User::where(['user_type' => 'Affiliate', 'is_delete' => null]);
        if ($order_orderDate) {
            $get_AffilliatePaidCommission = getDateFilter($get_AffilliatePaidCommission, $order_orderDate);
        }
        $AffilliatePaidCommission = $get_AffilliatePaidCommission->sum('total_paid');

        $get_PartnerCommission = User::where(['user_type' => 'Partner', 'is_delete' => null]);
        if ($order_orderDate) {
            $get_PartnerCommission = getDateFilter($get_PartnerCommission, $order_orderDate);
        }
        $PartnerCommission = $get_PartnerCommission->sum('total_commission');

        $get_PartnerPaidCommission = User::where(['user_type' => 'Partner', 'is_delete' => null]);
        if ($order_orderDate) {
            $get_PartnerPaidCommission = getDateFilter($get_PartnerPaidCommission, $order_orderDate);
        }
        $PartnerPaidCommission = $get_PartnerPaidCommission->sum('total_paid');


        $data['afffilliate_commission_chart'] = [];

        $get_arr = [];
        $get_arr['label'] = translate('Total Earning');
        $get_arr['value'] = round($AffilliateCommission, 2);
        $data['afffilliate_commission_chart'][] = $get_arr;


        $get_arr['label'] = translate('Due');
        $get_arr['value'] = round($AffilliateCommission - $AffilliatePaidCommission, 2);
        $data['afffilliate_commission_chart'][] = $get_arr;


        $get_arr['label'] = translate('Total Paid');
        $get_arr['value'] = round($AffilliatePaidCommission, 2);
        $data['afffilliate_commission_chart'][] = $get_arr;


        $data['supplier_commission_chart'] = [];

        $get_arr = [];
        $get_arr['label'] = translate('Total Earning');
        $get_arr['value'] = round($PartnerCommission, 2);
        $data['supplier_commission_chart'][] = $get_arr;


        $get_arr['label'] = translate('Due');
        $get_arr['value'] = round($PartnerCommission - $PartnerPaidCommission, 2);
        $data['supplier_commission_chart'][] = $get_arr;


        $get_arr['label'] = translate('Total Paid');
        $get_arr['value'] = round($PartnerPaidCommission, 2);
        $data['supplier_commission_chart'][] = $get_arr;

        $data['hotel_commission_chart'] = [];

        $get_arr = [];
        $get_arr['label'] = translate('Total Earning');
        $get_arr['value'] = round($HotelCommission, 2);
        $data['hotel_commission_chart'][] = $get_arr;


        $get_arr['label'] = translate('Due');
        $get_arr['value'] = round($HotelCommission - $HotelPaidCommission, 2);
        $data['hotel_commission_chart'][] = $get_arr;


        $get_arr['label'] = translate('Total Paid');
        $get_arr['value'] = round($HotelPaidCommission, 2);
        $data['hotel_commission_chart'][] = $get_arr;


        $get_charts_items = Orders::select(
            Orders::raw("(COUNT(*)) as count"),
            Orders::raw("DATE(created_at) as month_name"),
            Orders::raw("sum(total_amount) as totale")
        )
            ->groupBy('month_name')
            ->take(20)
            ->orderby('created_at', 'desc');

        if ($order_orderDate) {
            $get_charts_items = getDateFilter($get_charts_items, $order_orderDate);
        }

        $data['get_charts_items'] =   $get_charts_items->get();

        $get_last_orders = Orders::where(['status' => 'Success'])->orderBy('id', "desc")->take(10);
        if ($order_orderDate) {
            $get_last_orders = getDateFilter($get_last_orders, $order_orderDate);
        }
        $data['last_orders'] = $get_last_orders->get();

        $get_products = Product::select('products.*', 'products_description.title')
            ->where(['is_approved' => 'Not approved', 'added_by' => 'partner', 'status' => 'Active', 'is_delete' => null])
            ->leftjoin('products_description', 'products.id', '=', 'products_description.product_id')
            ->orderBy('products.id', "desc")
            ->take(10);

        if ($order_orderDate) {
            $getordersDate = explode('to', $order_orderDate);
            $formdate = '';
            $todate = '';
            if (isset($getordersDate[0])) {
                $formdate = $getordersDate[0] . " 00:00:00";
                $get_products->whereDate('products.created_at', '>=', $formdate);
            }
            if (isset($getordersDate[1])) {
                $todate = $getordersDate[1] . " 23:59:59";
                $get_products->whereDate('products.created_at', '<=', $todate);
            }
        }
        $data['last_product'] = $get_products->get();

        // total earnings
        $get_total_earning =    Orders::where(['status' => 'Success']);

        if ($order_orderDate) {
            $get_total_earning = getDateFilter($get_total_earning, $order_orderDate);
        }
        $data['total_earning'] = $get_total_earning->sum("total_amount");

        $total_earning_by_affilliate  = Orders::where(['status' => 'Success', 'earning_type' => 'affiliate']);

        if ($order_orderDate) {
            $getordersDate = explode('to', $order_orderDate);
            $formdate = '';
            $todate = '';
            if (isset($getordersDate[0])) {
                $formdate = $getordersDate[0] . " 00:00:00";
                $total_earning_by_affilliate->whereDate('created_at', '>=', $formdate);
            }
            if (isset($getordersDate[1])) {
                $todate = $getordersDate[1] . " 23:59:59";
                $total_earning_by_affilliate->whereDate('created_at', '<=', $todate);
            }
        }
        $data['total_earning_by_affilliate'] = $total_earning_by_affilliate->sum("total_amount");

        // Total earning 
        $get_total_earning_by_hotel =    Orders::where(['status' => 'Success', 'earning_type' => 'hotel']);

        if ($order_orderDate) {
            $getordersDate = explode('to', $order_orderDate);
            $formdate = '';
            $todate = '';
            if (isset($getordersDate[0])) {
                $formdate = $getordersDate[0] . " 00:00:00";
                $get_total_earning_by_hotel->whereDate('created_at', '>=', $formdate);
            }
            if (isset($getordersDate[1])) {
                $todate = $getordersDate[1] . " 23:59:59";
                $get_total_earning_by_hotel->whereDate('created_at', '<=', $todate);
            }
        }

        $data['total_earning_by_hotel'] = $get_total_earning_by_hotel->sum("total_amount");


        return view('admin.dashboard', compact('common', 'data'));
    }

    public function profileUpdate(Request $request)
    {
        $common = array();
        $common['main_menu']    = translate('profile');
        $common['submain_menu'] = translate('profile');
        $common['title']        = translate("Profile");
        $admin_id               = Session::get('em_admin_id');

        $get_admin              = Admin::where('id', $admin_id)->first();

        if ($request->isMethod('post')) {

            $req_filed                =   array();
            $req_filed['first_name']  =   "required";
            $req_filed['last_name']   =   "required";
            $validation = Validator::make($request->all(), $req_filed);

            if ($validation->fails()) {
                return back()->withErrors($validation)->withInput();
            }


            $message           = translate("Something went wrong");
            $status            = "error";
            $data              = $request->except('id', '_token');
            $Admin             = Admin::find($admin_id);

            if ($Admin) {
                $Admin->first_name = $request->first_name;
                $Admin->last_name  = $request->last_name;
                if ($request->hasFile('image')) {
                    $random_no  = uniqid();
                    $img = $request->file('image');
                    $ext = $img->getClientOriginalExtension();
                    $new_name = $random_no . '.' . $ext;
                    $destinationPath =  public_path('uploads/admin_image');
                    $img->move($destinationPath, $new_name);
                    $Admin->image = $new_name;
                }
                $message           = translate("Update Successfully");
                $status            = "success";
                $Admin->save();
            }
            return back()->withErrors([$status => $message]);
        }
        return view('admin.profile', compact('common', 'get_admin'));
    }

    public function changelanguage(Request $request, $lng)
    {
        if ($lng != '') {
            $Languages = Languages::whereNull('is_delete')->where(['id' => $lng, 'status' => 'Active'])->first();
            if ($Languages) {
                Session::put('Lang', $Languages->id);
            }
        }
    }

    public function language_change(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = translate('something went wrong!');

        if ($request->isMethod('post')) {
            $Language = Languages::where('status', 'Active')->where('id', $request->lang_id)->first();
            if ($Language) {
                Session::put('Lang', $request->lang_id);
                $output['status']  = true;
                $output['message'] = translate('Language changed successfully');
            } else {
                $output['message'] = translate('language not found');
            }
        }
        return $output;
    }

    // Get State City

    public function get_state_city(Request $request)
    {

        if ($request->type == 'country') {
            $data = States::where('country_id', $request->country)->get();
        } elseif ($request->type == 'zone') {
            $get_zone =  Zones::where('id', $request->zone)->first();
            $data = Countries::where('id', $get_zone->country)->get();
        } else {
            $data =  Cities::where('state_id', $request->state)->get();
        }

        return View::make('admin.append_page.select', compact('data'))->render();
    }
}
