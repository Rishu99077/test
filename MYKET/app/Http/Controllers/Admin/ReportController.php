<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Orders;
use App\Models\AffilliateCommission;
use App\Models\PartnerAdminCommission;
use App\Models\HotelCommission;
use Illuminate\Support\Str;

class ReportController extends Controller
{

    public function affilliate_history(Request $request)
    {
        $common          = array();
        $common['title'] = "Affiliates";
        Session::put("TopMenu", "Sales");
        Session::put("SubMenu", "Affiliates history");


        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        // Filter
        if ($request->isMethod('post')) {
            if (isset($request->filter)) {
                Session::put('affiliate_name', $request->affiliate_name);
                Session::put('affiliate_status', $request->affiliate_status);
                Session::put('affiliate_code', $request->affiliate_code);
                Session::put('affiliate_date', $request->affiliate_date);
            } elseif (isset($request->reset)) {
                Session::put('affiliate_name', '');
                Session::put('affiliate_status', '');
                Session::put('affiliate_code', '');
                Session::put('affiliate_date', '');
            }
            return redirect()->route('admin.affilliate_history');
        }

        $affiliate_name    = Session::get('affiliate_name');
        $affiliate_status    = Session::get('affiliate_status');
        $affiliate_code    = Session::get('affiliate_code');
        $affiliate_date    = Session::get('affiliate_date');

        $common['affiliate_name']   = $affiliate_name;
        $common['affiliate_status'] = $affiliate_status;
        $common['affiliate_code']   = $affiliate_code;
        $common['affiliate_date']   = $affiliate_date;


        $get_affiliates = User::orderBy('total_commission', 'desc')->where(['user_type' => 'Affiliate'])->whereNull('is_delete');
        if ($affiliate_name) {
            $get_affiliates = $get_affiliates->where(DB::raw('concat(`first_name`," ", `last_name`)'), 'like', '%' . $affiliate_name . '%');
        }

        if ($affiliate_status) {
            $get_affiliates = $get_affiliates->where('status', $affiliate_status);
        }

        if ($affiliate_code) {
            $get_affiliates = $get_affiliates->where('affiliate_code', $affiliate_code);
        }


        if ($affiliate_date) {

            $getordersDate = explode('to', $affiliate_date);
            $formdate = '';
            $todate = '';
            if (isset($getordersDate[0])) {
                $formdate = $getordersDate[0] . " 00:00:00";

                $get_affiliates->whereDate('created_at', '>=', $formdate);
            }
            if (isset($getordersDate[1])) {
                $todate = $getordersDate[1] . " 23:59:59";
                $get_affiliates->whereDate('created_at', '<=', $todate);
            }
        }

        $get_affiliates_count = $get_affiliates->count();
        $get_affiliates = $get_affiliates->paginate(config('adminconfig.records_per_page'));


        return view('admin.reports.affilliate_history', compact('common', 'get_affiliates', 'get_affiliates_count'));
    }

    public function affilliate_history_details(Request $request, $id)
    {
        $common          = array();
        $common['title'] = "Affiliates history details";
        Session::put("TopMenu", "Sales");
        Session::put("SubMenu", "Affiliates history");


        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $id = checkDecrypt($id);

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        // Filter
        if ($request->isMethod('post')) {
            if (isset($request->filter)) {
                Session::put('aff_affilliate_code', $request->affilliate_code);
                Session::put('aff_affilliate_name', $request->affilliate_name);
                Session::put('aff_affilliate_date', $request->affilliate_date);
                Session::put('aff_affilliate_order_id', $request->affilliate_order_id);
            } elseif (isset($request->reset)) {
                Session::put('aff_affilliate_code', '');
                Session::put('aff_affilliate_name', '');
                Session::put('aff_affilliate_date', '');
                Session::put('aff_affilliate_order_id', '');
            }
            return redirect()->route('admin.affilliate_history_details', ["id" => encrypt($id)]);
        }

        $aff_affilliate_code    = Session::get('aff_affilliate_code');
        $aff_affilliate_name    = Session::get('aff_affilliate_name');
        $aff_affilliate_date    = Session::get('aff_affilliate_date');
        $aff_affilliate_order_id    = Session::get('aff_affilliate_order_id');

        $common['aff_affilliate_code'] = $aff_affilliate_code;
        $common['aff_affilliate_name'] = $aff_affilliate_name;
        $common['aff_affilliate_date'] = $aff_affilliate_date;
        $common['aff_affilliate_order_id'] = $aff_affilliate_order_id;

        $total_commission = 0;

        $User = User::find($id);
        if ($User) {
            if ($User->total_commission != "") {
                $total_commission = $User->total_commission;
            }
        }

        $get_affiliates_commisions = AffilliateCommission::select('afilliate_comission.*', 'users.first_name', 'users.last_name', 'orders.order_id as OrderId')
            ->where('afilliate_comission.user_id', $id)
            ->leftjoin('users', 'afilliate_comission.user_id', '=', 'users.id')
            ->leftjoin('orders', 'afilliate_comission.order_id', '=', 'orders.id')
            ->orderBy('afilliate_comission.id', 'desc');

        if ($aff_affilliate_order_id) {
            $get_affiliates_commisions = $get_affiliates_commisions->where('orders.order_id', 'like', '%' . $aff_affilliate_order_id . '%');
        }

        if ($aff_affilliate_code) {
            $get_affiliates_commisions = $get_affiliates_commisions->where('afilliate_comission.affilliate_code', 'like', '%' . $aff_affilliate_code . '%');
        }

        if ($aff_affilliate_name) {
            $get_affiliates_commisions = $get_affiliates_commisions->where(DB::raw('concat(`first_name`," ", `last_name`)'), 'like', '%' . $aff_affilliate_name . '%');
        }

        if ($aff_affilliate_date) {

            $getordersDate = explode('to', $aff_affilliate_date);
            $formdate = '';
            $todate = '';
            if (isset($getordersDate[0])) {
                $formdate = $getordersDate[0] . " 00:00:00";

                $get_affiliates_commisions->whereDate('afilliate_comission.created_at', '>=', $formdate);
            }
            if (isset($getordersDate[1])) {
                $todate = $getordersDate[1] . " 23:59:59";
                $get_affiliates_commisions->whereDate('afilliate_comission.created_at', '<=', $todate);
            }
        }


        $get_affiliates_commisions = $get_affiliates_commisions->paginate(config('adminconfig.records_per_page'));

        return view('admin.reports.affilliate_history_details', compact('common', 'get_affiliates_commisions', 'total_commission'));
    }

    // Partner History

    public function supplier_history(Request $request)
    {

        $common          = array();
        $common['title'] = "Suppliers";
        Session::put("TopMenu", "Sales");
        Session::put("SubMenu", "Suppliers history");


        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        // Filter
        if ($request->isMethod('post')) {
            if (isset($request->filter)) {
                Session::put('supplier_name', $request->supplier_name);
                Session::put('supplier_status', $request->supplier_status);
                Session::put('supplier_date', $request->supplier_date);
            } elseif (isset($request->reset)) {
                Session::put('supplier_name', '');
                Session::put('supplier_status', '');
                Session::put('supplier_date', '');
            }
            return redirect()->route('admin.supplier_history');
        }

        $supplier_name    = Session::get('supplier_name');
        $supplier_status    = Session::get('supplier_status');
        $supplier_date    = Session::get('supplier_date');

        $common['supplier_name']   = $supplier_name;
        $common['supplier_status'] = $supplier_status;
        $common['supplier_date']   = $supplier_date;


        $get_supplier = User::orderBy('total_commission', 'desc')->where(['user_type' => 'Partner'])->whereNull('is_delete');
        if ($supplier_name) {
            $get_supplier = $get_supplier->where(DB::raw('concat(`first_name`," ", `last_name`)'), 'like', '%' . $supplier_name . '%');
        }

        if ($supplier_status) {
            $get_supplier = $get_supplier->where('status', $supplier_status);
        }




        if ($supplier_date) {

            $getordersDate = explode('to', $supplier_date);
            $formdate = '';
            $todate = '';
            if (isset($getordersDate[0])) {
                $formdate = $getordersDate[0] . " 00:00:00";

                $get_supplier->whereDate('created_at', '>=', $formdate);
            }
            if (isset($getordersDate[1])) {
                $todate = $getordersDate[1] . " 23:59:59";
                $get_supplier->whereDate('created_at', '<=', $todate);
            }
        }

        $get_supplier_count = $get_supplier->count();
        $get_supplier = $get_supplier->paginate(config('adminconfig.records_per_page'));


        return view('admin.reports.supplier_history', compact('common', 'get_supplier', 'get_supplier_count'));
    }


    // Supplier History Details
    public function supplier_history_details(Request $request, $id)
    {
        $common          = array();
        $common['title'] = "Supplier history details";
        Session::put("TopMenu", "Sales");
        Session::put("SubMenu", "Supplier history");


        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $id = checkDecrypt($id);

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        // Filter
        if ($request->isMethod('post')) {
            if (isset($request->filter)) {

                Session::put('sup_suppliers_name', $request->affilliate_name);
                Session::put('sup_suppliers_date', $request->affilliate_date);
                Session::put('sup_suppliers_order_id', $request->affilliate_order_id);
            } elseif (isset($request->reset)) {
                Session::put('sup_suppliers_name', '');
                Session::put('sup_suppliers_date', '');
                Session::put('sup_suppliers_order_id', '');
            }
            return redirect()->route('admin.supplier_history_details ', ["id" => encrypt($id)]);
        }

        $sup_suppliers_name    = Session::get('sup_suppliers_name');
        $sup_suppliers_date    = Session::get('sup_suppliers_date');
        $sup_suppliers_order_id    = Session::get('sup_suppliers_order_id');

        $common['sup_suppliers_name'] = $sup_suppliers_name;
        $common['sup_suppliers_date'] = $sup_suppliers_date;
        $common['sup_suppliers_order_id'] = $sup_suppliers_order_id;

        $total_commission = 0;

        $User = User::find($id);
        if ($User) {
            if ($User->total_commission != "") {
                $total_commission = $User->total_commission;
            }
        }

        $get_supplier_commisions = PartnerAdminCommission::select('partner_admin_commission.*', 'users.first_name', 'users.last_name', 'orders.order_id as OrderId')
            ->where('partner_admin_commission.partner_id', $id)
            ->leftjoin('users', 'partner_admin_commission.partner_id', '=', 'users.id')
            ->leftjoin('orders', 'partner_admin_commission.order_id', '=', 'orders.id')
            ->orderBy('partner_admin_commission.id', 'desc');

        if ($sup_suppliers_order_id) {
            $get_affiliates_commisions = $get_supplier_commisions->where('orders.order_id', 'like', '%' . $sup_suppliers_order_id . '%');
        }



        if ($sup_suppliers_name) {
            $get_supplier_commisions = $get_supplier_commisions->where(DB::raw('concat(`first_name`," ", `last_name`)'), 'like', '%' . $sup_suppliers_name . '%');
        }

        if ($sup_suppliers_date) {

            $getordersDate = explode('to', $sup_suppliers_date);
            $formdate = '';
            $todate = '';
            if (isset($getordersDate[0])) {
                $formdate = $getordersDate[0] . " 00:00:00";

                $get_supplier_commisions->whereDate('afilliate_comission.created_at', '>=', $formdate);
            }
            if (isset($getordersDate[1])) {
                $todate = $getordersDate[1] . " 23:59:59";
                $get_supplier_commisions->whereDate('afilliate_comission.created_at', '<=', $todate);
            }
        }


        $get_supplier_commisions = $get_supplier_commisions->paginate(config('adminconfig.records_per_page'));

        return view('admin.reports.supplier_history_details', compact('common', 'get_supplier_commisions', 'total_commission'));
    }

    // Supplier Commission Details 
    public function supplier_commission_view(Request $request, $id = "", $order_id = "")
    {

        $common          = array();
        $common['title'] = "Supplier history details";
        Session::put("TopMenu", "Sales");
        Session::put("SubMenu", "Supplier history");


        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $user_id = checkDecrypt($id);
        $order_id = checkDecrypt($order_id);

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $Orders = Orders::where(['id' => $order_id])->first();
        $orderData = [];
        $cart_tax_fee               = [];
        if ($Orders) {
            $orderData['id']           = encrypt($Orders->id);
            $orderData['order_id']     = $Orders->order_id;
            $orderData['user_name']   = $Orders->first_name . " " . $Orders->last_name;
            $orderData['email']        = $Orders->email;
            $orderData['phone']        = $Orders->phone;
            $orderData['zipcode']      = $Orders->zipcode;
            $orderData['address']      = $Orders->address;
            $orderData['total_amount'] = $Orders->total_amount;
            $orderData['status']       = $Orders->status;
            $orderData['created_at']       = $Orders->created_at;
            $orderData['order_date']   = date("d,M Y", strtotime($Orders->created_at));
            $orderData['country']      = getDataFromDB('countries', ['id' => $Orders->country], 'row', 'name');
            $orderData['state']        = getDataFromDB('states', ['id' => $Orders->state], 'row', 'name');
            $orderData['city']         = getDataFromDB('cities', ['id' => $Orders->city], 'row', 'name');
            $orderData['order_json']   = [];
            $order_json =  json_decode($Orders->order_json);

            $totalAmount = 0;
            $totalTax = 0;
            $coupon_amount = 0;

            if ($order_json) {
                foreach ($order_json->detail as $OJkey => $OJ) {

                    if (isset($OJ->added_by)) {
                        if ($OJ->added_by == "partner") {
                            $partner_id = isset($OJ->partner_id) ? $OJ->partner_id : 0;
                            if ($user_id == $partner_id) {
                                $totalAmount  += $OJ->totalAmount;
                                $newTax = $OJ->total_tax;
                                $coupon_amount += isset($OJ->coupon_amount) ? $OJ->coupon_amount : 0;


                                $containsCurrency = Str::contains($OJ->total_tax, "$");
                                if ($containsCurrency) {
                                    $newTax = trim($OJ->total_tax, "$");
                                }
                                $totalTax += (float)$newTax;

                                $detailsArr[] = $OJ;
                                $orderData['order_json'] = $detailsArr;
                            }
                        }
                    }
                }
            }

            $cart_tax_fee['amount'] =  get_price_front('', '', '', '', round($totalAmount, 2));
            $cart_tax_fee['title'] =  'Sub Total';
            $orderData['cart_tax_fee'][] = $cart_tax_fee;

            $cart_tax_fee['amount'] =  get_price_front('', '', '', '', round($totalTax, 2));
            $cart_tax_fee['title'] =  'Total Tax';
            $orderData['cart_tax_fee'][] = $cart_tax_fee;

            if ($coupon_amount > 0) {
                $cart_tax_fee['amount'] =  get_price_front('', '', '', '', round($coupon_amount, 2));
                $cart_tax_fee['title'] =  'Total Discount';
                $orderData['cart_tax_fee'][] = $cart_tax_fee;
            }

            $cart_tax_fee['amount'] =  get_price_front('', '', '', '', round($totalTax + $totalAmount - $coupon_amount, 2));
            $cart_tax_fee['title'] =  'Total';
            $orderData['cart_tax_fee'][] = $cart_tax_fee;
        }
        return view('admin.reports.supplier_commission_view', compact('common', 'orderData'));
    }

    // Hotel History
    public function hotel_history(Request $request)
    {
        $common          = array();
        $common['title'] = "Hotels";
        Session::put("TopMenu", "Sales");
        Session::put("SubMenu", "Hotels history");


        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        // Filter
        if ($request->isMethod('post')) {
            if (isset($request->filter)) {
                Session::put('hotel_name', $request->hotel_name);
                Session::put('hotel_status', $request->hotel_status);
                Session::put('hotel_date', $request->hotel_date);
            } elseif (isset($request->reset)) {
                Session::put('hotel_name', '');
                Session::put('hotel_status', '');
                Session::put('hotel_date', '');
            }
            return redirect()->route('admin.hotel_history');
        }

        $hotel_name    = Session::get('hotel_name');
        $hotel_status    = Session::get('hotel_status');
        $hotel_date    = Session::get('hotel_date');

        $common['hotel_name']   = $hotel_name;
        $common['hotel_status'] = $hotel_status;
        $common['hotel_date']   = $hotel_date;


        $get_hotels = User::orderBy('total_commission', 'desc')->select('users.*', 'hotel_descriptions.hotel_name')
            ->leftJoin('hotel_descriptions', 'hotel_descriptions.hotel_id', '=', 'users.id')
            ->where(['user_type' => 'Hotel'])->whereNull('is_delete');

        if ($hotel_name) {
            $get_hotels = $get_hotels->where('hotel_descriptions.hotel_name', 'like', '%' . $hotel_name . '%');
        }

        if ($hotel_status) {
            $get_hotels = $get_hotels->where('status', $hotel_status);
        }



        if ($hotel_date) {

            $getordersDate = explode('to', $hotel_date);
            $formdate = '';
            $todate = '';
            if (isset($getordersDate[0])) {
                $formdate = $getordersDate[0] . " 00:00:00";

                $get_hotels->whereDate('users.created_at', '>=', $formdate);
            }
            if (isset($getordersDate[1])) {
                $todate = $getordersDate[1] . " 23:59:59";
                $get_hotels->whereDate('users.created_at', '<=', $todate);
            }
        }

        $get_hotels_count = $get_hotels->count();
        $get_hotels = $get_hotels->paginate(config('adminconfig.records_per_page'));


        return view('admin.reports.hotel_history', compact('common', 'get_hotels', 'get_hotels_count'));
    }

    // Hotel History Details

    public function hotel_history_details(Request $request, $id)
    {
        $common          = array();
        $common['title'] = "Hotel history details";
        Session::put("TopMenu", "Sales");
        Session::put("SubMenu", "Hotels history");


        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $id = checkDecrypt($id);

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        // Filter
        if ($request->isMethod('post')) {
            if (isset($request->filter)) {
                Session::put('ht_hotel_name', $request->hotel_name);
                Session::put('ht_hotel_date', $request->hotel_date);
                Session::put('ht_hotel_order_id', $request->hotel_order_id);
            } elseif (isset($request->reset)) {
                Session::put('ht_hotel_name', '');
                Session::put('ht_hotel_date', '');
                Session::put('ht_hotel_order_id', '');
            }
            return redirect()->route('admin.hotel_history_details', ["id" => encrypt($id)]);
        }

        $ht_hotel_name    = Session::get('ht_hotel_name');
        $ht_hotel_date    = Session::get('ht_hotel_date');
        $ht_hotel_order_id    = Session::get('ht_hotel_order_id');


        $common['ht_hotel_name'] = $ht_hotel_name;
        $common['ht_hotel_date'] = $ht_hotel_date;
        $common['ht_hotel_order_id'] = $ht_hotel_order_id;

        $total_commission = 0;

        $User = User::find($id);
        if ($User) {
            if ($User->total_commission != "") {
                $total_commission = $User->total_commission;
            }
        }

        $get_hotel_commisions = HotelCommission::select('hotel_commission.*', 'users.first_name', 'users.last_name', 'orders.order_id as OrderId', 'hotel_descriptions.hotel_name', 'users.id', 'hotel_commission.id as ht_com_id')
            ->where('hotel_commission.hotel_id', $id)
            ->leftjoin('users', 'hotel_commission.hotel_id', '=', 'users.id')
            ->leftJoin('hotel_descriptions', 'hotel_descriptions.hotel_id', '=', 'users.id')
            ->leftjoin('orders', 'hotel_commission.order_id', '=', 'orders.id')
            ->orderBy('hotel_commission.id', 'desc');

        if ($ht_hotel_order_id) {
            $get_hotel_commisions = $get_hotel_commisions->where('orders.order_id', 'like', '%' . $ht_hotel_order_id . '%');
        }



        if ($ht_hotel_order_id) {

            $getordersDate = explode('to', $ht_hotel_order_id);
            $formdate = '';
            $todate = '';
            if (isset($getordersDate[0])) {
                $formdate = $getordersDate[0] . " 00:00:00";

                $get_hotel_commisions->whereDate('hotel_commission.created_at', '>=', $formdate);
            }
            if (isset($getordersDate[1])) {
                $todate = $getordersDate[1] . " 23:59:59";
                $get_hotel_commisions->whereDate('hotel_commission.created_at', '<=', $todate);
            }
        }

        $get_hotel_commisions = $get_hotel_commisions->paginate(config('adminconfig.records_per_page'));

        return view('admin.reports.hotel_history_details', compact('common', 'get_hotel_commisions', 'total_commission'));
    }

    // Hotel Commission VIew
    public function hotel_commission_view(Request $request, $id = "")
    {

        $common          = array();
        $common['title'] = "Hotel Commission";
        Session::put("TopMenu", "Sales");
        Session::put("SubMenu", "Hotels history");

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                         = checkDecrypt($id);

            $get_hotel_commisions  = HotelCommission::where('id', $id)->first();

            if ($get_hotel_commisions) {
                $commissions = array();
                $commissions['total']           = $get_hotel_commisions['total'];
                $commissions['products']        = json_decode($get_hotel_commisions['product_json']);
                $commissions['type']            = $get_hotel_commisions['type'];
                $commissions['date']            = $get_hotel_commisions['created_at'];

                $get_orders = Orders::where(['id' => $get_hotel_commisions['order_id']])->first();
                if ($get_orders) {
                    $commissions['order_id'] = $get_orders['order_id'];
                }

                $commissions['user_name'] = '-';
                $get_affiliate  = User::where(['id' => $get_hotel_commisions['hotel_id']])->first();
                if ($get_affiliate) {
                    $commissions['user_name'] = $get_affiliate['first_name'] . ' ' . $get_affiliate['last_name'];
                }
            }

            if (!$get_hotel_commisions) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }



        return view('admin.reports.hotel_commission_view', compact('common', 'get_hotel_commisions', 'commissions'));
    }
}
