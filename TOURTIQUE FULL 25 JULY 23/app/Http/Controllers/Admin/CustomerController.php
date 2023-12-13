<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Language;

use App\Models\Country;
use App\Models\CustomerGroup;
use App\Models\CustomerGroupLanguage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function partners_list(){
        $common          = array();
        $common['title'] = "Partner";
        Session::put("TopMenu", "Partner");
        Session::put("SubMenu", "Partner");

        $get_customers = User::orderBy('id', 'desc')->where(['user_type' => 'Partner' , 'is_delete' => 0])
            ->paginate(config('adminconfig.records_per_page'));
            
        return view('admin.Customer.index', compact('common', 'get_customers'));
    }


    ///Add Partner
    public function add_Partner(Request $request, $id = ""){
        $common = array();
        Session::put("TopMenu", "Partner");
        Session::put("SubMenu", "Partner");

        $common['title']              = translate("Add Partner");
        $common['button']             = translate("Save");
        $get_partner                  = getTableColumn('users');
        
        $languages   = Language::where(ConditionQuery())->get();
        $country 	 = Country::all();
        $customerGroup = CustomerGroup::select('customer_group.*', 'customer_group_language.title as title')
            ->where('customer_group.is_delete', 0)
            ->join('customer_group_language', 'customer_group.id', '=', 'customer_group_language.customer_group_id')
            ->groupBy('customer_group.id')
            ->orderBy('customer_group.id', 'desc')
            ->get();

        if ($request->isMethod('post')) {

            $req_fields = array();
            $req_fields['name']   = "required";

            $errormsg = [
                "name" => translate("Name"),
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

            $request->request->add(['user_id' => Session::get('admin_id')]);
            if ($request->id != "") {
                $message  = translate("Update Successfully");
                $status   = "success";
                $Customers 	  = User::find($request->id);
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $Customers 	  = new User();
            }

            $Customers['name'] 		= $request->name;
            $Customers['country'] 	= $request->country;
            $Customers['state'] 	= $request->state;
            $Customers['city'] 		= $request->city;
            $Customers['customer_group'] = $request->customer_group;
            $Customers['address'] 	= $request->address;
            $Customers['status'] 	= $request->status;
            $Customers->save();
 
            return redirect()->route('admin.partners_list')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id           = checkDecrypt($id);
            $common['title']      = "Edit Partner";
            $common['button']     = "Update";
            $get_partner = User::where(['id'=> $id,'user_type' => 'Partner'])->first();

            if (!$get_partner) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.Customer.form', compact('common', 'get_partner','languages','country','customerGroup'));
    }
    
    public function delete($id){
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_partner =  User::find($id);
        if ($get_partner) {
            $get_partner->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }

    
}
