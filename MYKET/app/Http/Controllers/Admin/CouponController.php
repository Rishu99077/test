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
use App\Models\Categories;
use App\Models\Product;
use App\Models\Coupon;
use View;

class CouponController
{

    public function index(Request $request)
    {
        $common          = array();
        $common['title'] = translate("Coupon");
        Session::put("TopMenu", translate("Marketing"));
        Session::put("SubMenu", translate("Coupon"));

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        if ($request->isMethod('post')) {
            if (isset($request->filter)) {
                Session::put('coupon_code', $request->coupon_code);
                Session::put('coupon_amount_type', $request->coupon_amount_type);
                Session::put('coupon_type', $request->coupon_type);
                Session::put('coupon_date', $request->coupon_date);
                Session::put('coupon_status', $request->coupon_status);
            } elseif (isset($request->reset)) {
                Session::put('coupon_code', '');
                Session::put('coupon_amount_type', '');
                Session::put('coupon_type', '');
                Session::put('coupon_date', '');
                Session::put('coupon_status', '');
            }
            return redirect()->route('admin.coupon');
        }

        $coupon_code   = Session::get('coupon_code');
        $coupon_amount_type  = Session::get('coupon_amount_type');
        $coupon_type = Session::get('coupon_type');
        $coupon_date   = Session::get('coupon_date');
        $coupon_status   = Session::get('coupon_status');

        $common['coupon_code']   = $coupon_code;
        $common['coupon_amount_type']  = $coupon_amount_type;
        $common['coupon_type'] = $coupon_type;
        $common['coupon_date']   = $coupon_date;
        $common['coupon_status']   = $coupon_status;



        $get_coupon = Coupon::orderBy('id', 'desc')->whereNull('is_delete')->where('coupon_type', '!=', 'affilliate');

        if ($coupon_code) {
            $get_coupon = $get_coupon->where('code', 'like', '%' . $coupon_code . '%');
        }

        if ($coupon_amount_type) {
            $get_coupon = $get_coupon->where('coupon_amount_type',  $coupon_amount_type);
        }
        if ($coupon_type) {
            $get_coupon = $get_coupon->where('coupon_type',  $coupon_type);
        }

        if ($coupon_status) {
            $get_coupon = $get_coupon->where('status',  $coupon_status);
        }

        if ($coupon_date) {

            $getordersDate = explode('to', $coupon_date);
            $formdate = '';
            $todate = '';
            if (isset($getordersDate[0])) {
                $formdate = $getordersDate[0] . " 00:00:00";

                $get_coupon->whereDate('start_date', '>=', $formdate);
            }
            if (isset($getordersDate[1])) {
                $todate = $getordersDate[1] . " 23:59:59";
                $get_coupon->whereDate('end_date', '<=', $todate);
            }
        }



        $get_coupon = $get_coupon->paginate(config('adminconfig.records_per_page'));

        return view('admin.coupon.index', compact('common', 'get_coupon'));
    }


    public function add_coupon(Request $request, $id = "")
    {

        $common = array();
        Session::put("TopMenu", translate("Marketing"));
        Session::put("SubMenu", translate("Coupon"));

        $common['title']          = translate(translate();
        $common[)'heading_title']  = translate(translate();
        $common[)'button']         = translate("Save");
        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $get_coupon              = getTableColumn('coupon');

        $partner = User::orderBy('id', 'desc')->where(['status' => 'Active', 'user_type' => "Partner"])->whereNull('is_delete')
            ->get();


        $get_category = Categories::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
            ->get();

        $categories = array();
        if (!empty($get_category)) {
            foreach ($get_category as $key => $value) {
                $row  = getLanguageData('category_descriptions', $language_id, $value['id'], 'category_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $categories[] = $row;
            }
        }

        $get_product = Product::where(['products.is_delete' => null, 'products.status' => 'Active', 'products.is_approved' => 'Approved'])->where('slug', '!=', '')->where('products_description.language_id', $language_id)
            ->select('products.*', 'products_description.title', 'products_description.language_id')
            ->leftJoin('products_description', 'products.id', '=', 'products_description.product_id')
            ->get();


        if ($request->isMethod('post')) {

            // echo "<pre>"; 
            // print_r($request->all());
            // echo "</pre>";die();

            $req_fields = array();
            $id  = checkDecrypt($id);
            if ($request->id == '') {
                $req_fields['coupon_code']    = "required|unique:coupon,code," . $id;
            } else {
                $req_fields['coupon_code']    = "required";
            }


            $req_fields['start_date']     = "required";
            $req_fields['end_date']       = "required";
            $req_fields['minimum_amount'] = "required";
            $req_fields['coupon_amount']  = "required";

            if ($request->copuon_for == 'partner') {
                $req_fields['coupon_value_part']     = "required";
            }
            if ($request->copuon_for == 'category') {
                $req_fields['coupon_value_cat']     = "required";
            }
            if ($request->copuon_for == 'product') {
                $req_fields['coupon_value_pro']     = "required";
            }

            $errormsg = [
                "coupon_code"    => translate("Coupon Code"),
                "start_date"     => translate("Start Date"),
                "end_date"       => translate("End Date"),
                "minimum_amount" => translate("Minimum Amount"),
                "coupon_amount"  => translate("Coupon Amount"),
                "coupon_value_part"  => translate("Coupon Value"),
                "coupon_value_cat"   => translate("Coupon Value"),
                "coupon_value_pro"   => translate("Coupon Value"),
            ];

            $validation = Validator::make(
                $request->all(),
                $req_fields,
                [
                    'required' => 'The :attribute field is required.',
                ],
                $errormsg
            );

            // if ($validation->fails()) {
            //     return response()->json(['error' => array_reverse($validation->getMessageBag()->toArray())]);
            // }

            if ($validation->fails()) {
                return back()->withErrors($validation)->withInput();
            }

            if ($request->id != "") {
                $message  = translate("Update Successfully");
                $status   = "success";
                $Coupon = Coupon::find($request->id);
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $Coupon    = new Coupon();
            }

            $Coupon->coupon_type        = $request->copuon_for;
            $Coupon->status             = $request->status;
            $Coupon->coupon_amount      = $request->coupon_amount;
            $Coupon->coupon_amount_type = $request->coupon_amount_type;
            $Coupon->minimum_amount     = $request->minimum_amount;
            $Coupon->start_date         = $request->start_date;
            $Coupon->end_date           = $request->end_date;
            $Coupon->code               = $request->coupon_code;
            if ($request->copuon_for == 'partner') {
                $Coupon->value              = $request->coupon_value_part;
            }
            if ($request->copuon_for == 'category') {
                $Coupon->value              = $request->coupon_value_cat;
            }
            if ($request->copuon_for == 'product') {
                $Coupon->value              = $request->coupon_value_pro;
            }

            $Coupon->save();

            return redirect()->route('admin.coupon')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                         = checkDecrypt($id);
            $common['title']            = translate("Edit Coupon");
            $common['heading_title']    = translate("Edit Coupon");
            $common['button']           = translate("Update");

            $get_coupon = Coupon::where('id', $id)->first();
            if (!$get_coupon) {
                return back()->withErrors(["error" => translate("Something went wrong")]);
            }
        }
        // echo "<pre>"; 
        // print_r($get_coupon);
        // echo "</pre>";die();

        return view('admin.coupon.add', compact('common', 'partner', 'categories', 'get_product', 'get_coupon'));
    }


    // Delete Coupon
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" =>translate("No Record Found")]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = translate('Something went wrong!');
        $get_coupon  =  Coupon::where(['id' => $id])->first();
        if ($get_coupon) {
            $get_coupon->is_delete = '1';
            $get_coupon->save();
        }
        $status     = 'success';
        $message    = translate('Delete Successfully');
        return back()->withErrors([$status => $message]);
    }
}
