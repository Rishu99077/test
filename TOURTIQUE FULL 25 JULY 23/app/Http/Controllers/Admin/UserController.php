<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\UserWalletHistory;
use App\Models\Language;

use App\Models\Country;
use App\Models\CustomerGroup;
use App\Models\CustomerGroupLanguage;

use Illuminate\Support\Facades\Hash;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        $common          = array();
        $common['title'] = "Users";
        Session::put("TopMenu", "Users");
        Session::put("SubMenu", "Users");

        $get_customers = User::orderBy('id', 'desc')->where(['is_delete' => 0])
            ->paginate(config('adminconfig.records_per_page'));
            
        return view('admin.User.index', compact('common', 'get_customers'));
    }


    ///Add Partner
    public function add_User(Request $request, $id = ""){
        $common = array();
        Session::put("TopMenu", "Users");
        Session::put("SubMenu", "Users");

        $common['title']              = translate("Add Users");
        $common['button']             = translate("Save");
        $get_user                  = getTableColumn('users');
        
        $languages   = Language::where(ConditionQuery())->get();
        $country 	 = Country::all();
        
        if ($request->isMethod('post')) {

            $req_fields = array();
            $req_fields['name']   = "required";
            if ($request->id == '') {
                $req_fields['email']        = "required";
                $req_fields['password']     = "required";
                $req_fields['phone_number'] = "required";
            }

            $errormsg = [
                "name" => translate("Name"),
                "email" => translate("Email"),
                "password" => translate("Password"),
                "phone_number" => translate("Phone number"),
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

            $Customers['name']      = $request->name;
            $Customers['email']     = $request->email;
            $Customers['phone_number'] = $request->phone_number;
            $Customers['country'] 	= $request->country;
            $Customers['state'] 	= $request->state;
            $Customers['city'] 		= $request->city;
            $Customers['address'] 	= $request->address;
            $Customers['giftcard_wallet'] = $request->giftcard_wallet;
            $Customers['status'] 	= $request->status;
            if ($request->password) {
                $Customers['password'] = Hash::make($request->password);
            }

            $Customers->save();

            if (isset($request->giftcard_wallet)) {
                UserWalletHistory::where(['user_id' => $Customers->id])->delete();    
                
                $UserWalletHistory = new UserWalletHistory();
                $UserWalletHistory['user_id']      = $Customers->id;
                $UserWalletHistory['amount']       = $request->giftcard_wallet;
                $UserWalletHistory['added_by']     = 'Admin';
                $UserWalletHistory->save();
            }

 
            return redirect()->route('admin.user')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id           = checkDecrypt($id);
            $common['title']      = "Edit User";
            $common['button']     = "Update";
            $get_user = User::where(['id'=> $id])->first();

            if (!$get_user) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.User.form', compact('common', 'get_user','languages','country'));
    }
    
    public function delete($id){
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_user =  User::find($id);
        if ($get_user) {
            $get_user->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }

    
}
