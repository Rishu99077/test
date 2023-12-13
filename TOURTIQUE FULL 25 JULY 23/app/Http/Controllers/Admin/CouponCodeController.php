<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CouponCode;
use App\Models\CouponCodeLanguage;
use App\Models\Country;
use App\Models\States;
use App\Models\City;
use App\Models\Language;
use App\Models\User;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class CouponCodeController extends Controller
{

    public function index()
    {
        $common = array();
        Session::put("TopMenu", "Coupon Code");
        Session::put("SubMenu", "Coupon Code");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $common['title']  = translate("Coupon Code");

        $get_coupon_codes = CouponCode::select('coupon_code.*', 'coupon_code_language.title')
            ->orderBy('coupon_code.id', 'desc')->where(['coupon_code.is_delete' => 0])
            ->leftjoin("coupon_code_language", 'coupon_code.id', '=', 'coupon_code_language.coupon_code_id')
            ->groupBy('coupon_code.id')
            ->paginate(config('adminconfig.records_per_page'));

        return view('admin.CouponCode.index', compact('common', 'get_coupon_codes','lang_id'));
    }


    public function store(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Coupon Code");
        Session::put("SubMenu", "Coupon Code");
        $common['title']      = translate("Add Coupon Code");
        $common['button']     = translate("Save");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $get_coupon_code = getTableColumn('coupon_code');
        $get_coupon_code_language = [];

        $languages                      = Language::where(ConditionQuery())->get();

        $get_customers = User::where(['user_type' => 'Customer', 'is_delete' => 0])->get();

        if ($request->isMethod('post')) {

            $req_fields        = array();
            $req_fields['title.*']          = "required";
            $req_fields['coupon_code']      = "required";
            $req_fields['coupon_type']      = "required";
            $req_fields['amount']             = "required";


            $errormsg = [
                "title.*"         => translate("Title"),
                "coupon_code"     => translate("Coupon code"),
                "coupon_type"     => translate("Coupon Type"),
                "amount"          => translate("Amount"),
            ];

            $validation = Validator::make(
                $request->all(),
                $req_fields,
                [
                    'required' => 'The :attribute field is required.',
                ],
                $errormsg
            );

            if ($validation->fails()) {
                return back()->withErrors($validation)->withInput();
            }

            if ($request->id != "") {
                $message    = translate("Update Successfully");
                $status     = translate("success");
                $CouponCode = CouponCode::find($request->id);
                CouponCodeLanguage::where('coupon_code_id', $request->id)->where('language_id',$lang_id)->delete();
            } else {
                $message  = translate("Add Successfully");
                $status   = translate("success");
                $CouponCode = new CouponCode();
            }

            $CouponCode->coupon_code  = $request->coupon_code;
            $CouponCode->coupon_type  = $request->coupon_type;
            $CouponCode->coupon_value = $request->coupon_value;

            $CouponCode->amount       = $request->amount;

            $CouponCode->number_of_uses      = $request->number_of_uses;
            $CouponCode->how_many            = $request->how_many;
            $CouponCode->start_date          = $request->start_date;
            $CouponCode->end_date            = $request->end_date;
            $CouponCode->customer_selection  = $request->customer_selection;
            $CouponCode->customers           = $request->customers != null ? json_encode($request->customers) : "";
            $CouponCode->status              = $request->status;

            $CouponCode->save();

            $coupon_code_id = $CouponCode->id;

            $get_languages = Language::where(['status'=>'Active','is_delete'=>0])->get();

            if (!empty($get_languages)) {
                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('coupon_code_language',['language_id'=>$value['id'],'coupon_code_id'=>$request->id],'row')) {

                        $CouponCodeLanguage = new CouponCodeLanguage();
                   
                        $CouponCodeLanguage->title                    = isset($request->title[$value['id']]) ?  $request->title[$value['id']] : $request->title[$lang_id];
                        $CouponCodeLanguage->coupon_code_id           = $coupon_code_id;
                        $CouponCodeLanguage->language_id              = $value['id'];

                        $CouponCodeLanguage->save();
                    }
                }
            }

            return redirect()->route('admin.coupon_code')->withErrors([$status => $message]);
        }

        if ($id != "") {

            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id = checkDecrypt($id);
            $common['title']            = translate("Edit coupon code");
            $common['button']           = translate("Update");
            $get_coupon_code             =  CouponCode::where('id', $id)->first();
            $get_coupon_code_language   =  CouponCodeLanguage::where('coupon_code_id', $id)->get();

            if (!$get_coupon_code) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.CouponCode.form', compact('common', 'get_coupon_code', 'get_coupon_code_language', 'languages', 'get_customers','lang_id'));
    }


    // Deleete Coupon code
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $CouponCode =  CouponCode::find($id);
        if ($CouponCode) {
            $CouponCode->delete();
            CouponCodeLanguage::where('coupon_code_id', $id)->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }

}
