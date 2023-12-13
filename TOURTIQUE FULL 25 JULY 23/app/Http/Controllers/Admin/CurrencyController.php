<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    public function index(Request $request)
    {
        $common          = array();
        $common['title'] =  translate("Currency");

        Session::put("TopMenu", translate("Settings"));
        Session::put("SubMenu", translate("Currency"));


        $get_currency = Currency::orderBy('id', 'desc')->where(['is_delete' => 0])->paginate(config('adminconfig.records_per_page'));
        return view('admin.currency.index', compact('common', 'get_currency'));
    }

    public function store(Request $request, $id = "")
    {

        $common = array();
        Session::put("TopMenu", translate("Settings"));
        Session::put("SubMenu", translate("Currency"));


        $common['title']      = translate("Add Currency");
        $common['button']     = translate("Save");
        $get_currency         = getTableColumn('currency');


        if ($request->isMethod('post')) {


            $req_fields                       = array();
            $req_fields['title']              = "required|unique:currency";
            $req_fields['sort_code']          = "required|unique:currency|regex:/^[a-zA-Z]+$/u";
            // $req_fields['flag_image']         = "required";

            $errormsg = [
                "title"      => translate("Title"),
                "sort_code"  => translate("Short Code"),
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
                $message  = translate("Update Successfully");
                $status   = "success";
                $data     = $request->except('id', '_token');
                $Currency = Currency::find($request->id);
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $data     = $request->except('_token');
                $Currency = new Currency();
            }
            foreach ($data as $key => $value) {
                $Currency->$key = $value;
            }
            $Currency->save();
            return redirect()->route('admin.currency')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => translate("No Record Found")]);
            }
            $id = checkDecrypt($id);
            $common['title']             = translate("Edit Category");
            $common['button']            = translate("Update");
            $get_currency =  Currency::where('id', $id)->first();

            if (!$get_currency) {
                return back()->withErrors(["error" => translate("Something went wrong")]);
            }
        }

        return view('admin.currency.form', compact('common', 'get_currency'));
    }

    public function delete($id){
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_currency =  Currency::find($id);
        if ($get_currency) {
            $get_currency->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }
}
