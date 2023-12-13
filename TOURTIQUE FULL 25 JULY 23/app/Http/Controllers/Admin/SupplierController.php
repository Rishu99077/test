<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\Country;
use App\Models\States;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class SupplierController extends Controller
{
    // All Supplier
    public function index()
    {
        $common = array();
        Session::put("TopMenu", "Supplier");
        Session::put("SubMenu", "Supplier");

        $common['title']             = translate("Supplier");

        $get_supplier = Supplier::orderBy('id', 'desc')->where(['is_delete' => 0])->paginate(config('adminconfig.records_per_page'));
        return view('admin.supplier.index', compact('common', 'get_supplier'));
    }



    public function store(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Supplier");
        Session::put("SubMenu", "Supplier");
        $common['title']      = translate("Add Supplier");
        $common['button']     = translate("Save");
        $get_supplier = getTableColumn('supplier');
        $country      = Country::all();

        if ($request->isMethod('post')) {

            $req_fields        = array();
            $req_fields['username']        = "required";
            $req_fields['contact']         = "required";
            $req_fields['company_name']    = "required";
            $req_fields['booking_contact'] = "required";
            $req_fields['country']         = "required";
            $req_fields['state']           = "required";
            $req_fields['city']            = "required";

            if ($request->id == "") {
                $req_fields['email']         = "required|unique:supplier,email";
                $req_fields['booking_email'] = "required|unique:supplier,booking_email";
            } else {
                $req_fields['email']         = "required|unique:supplier,email," . $request->id;
                $req_fields['booking_email'] = "required|unique:supplier,booking_email," . $request->id;
            }



            $errormsg = [
                "username"        => translate("Full Name"),
                "contact"         => translate("Phone"),
                "email"           => translate("Email"),
                "booking_email"   => translate("Booking Email"),
                "company_name"    => translate("Company Name"),
                "booking_contact" => translate("Booking Contact"),
                "country"         => translate("Country"),
                "state"           => translate("State"),
                "city"            => translate("City"),


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
                $status   = translate("success");
                $data     = $request->except('id', '_token');
                $Supplier = Supplier::find($request->id);
            } else {
                $message  = translate("Add Successfully");
                $status   = translate("success");
                $data     = $request->except('_token');
                $Supplier = new Supplier();
            }
            foreach ($data as $key => $value) {
                if ($key == "logo") {
                    if ($request->hasFile('logo')) {
                        $random_no       = uniqid();
                        $img              = $request->file('logo');
                        $ext              = $img->getClientOriginalExtension();
                        $new_name          = $random_no . '.' . $ext;
                        $destinationPath =  public_path('uploads/supplier');
                        $img->move($destinationPath, $new_name);
                        $value     = $new_name;
                    }
                }
                $Supplier->user_id  = Session::get('admin_id');
                $Supplier->added_by = "admin";
                $Supplier->$key     = $value;
            }


            $Supplier->save();
            return redirect()->route('admin.supplier')->withErrors([$status => $message]);
        }

        if ($id != "") {

            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id = checkDecrypt($id);
            $common['title']             = translate("Edit Supplier");
            $common['button']            = translate("Update");
            $get_supplier =  Supplier::where('id', $id)->first();

            if (!$get_supplier) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.supplier.form', compact('common', 'get_supplier', 'country'));
    }
}
