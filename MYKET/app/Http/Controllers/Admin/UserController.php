<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mail;
use DB;

class UserController
{
    // Partner List
    public function partners(Request $request)
    {
        $common          = array();
        $common['title'] = "Suppliers";
        Session::put("TopMenu", "Accounts");
        Session::put("SubMenu", "Suppliers");

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];


        // Filter
        if ($request->isMethod('post')) {
            if (isset($request->filter)) {
                Session::put('partner_name', $request->partner_name);
                Session::put('partner_email', $request->partner_email);
                Session::put('partner_status', $request->partner_status);
                Session::put('partner_date', $request->partner_date);
            } elseif (isset($request->reset)) {
                Session::put('partner_name', '');
                Session::put('partner_email', '');
                Session::put('partner_status', '');
                Session::put('partner_date', '');
            }
            return redirect()->route('admin.partner_account');
        }

        $partner_name   = Session::get('partner_name');
        $partner_email  = Session::get('partner_email');
        $partner_status = Session::get('partner_status');
        $partner_date   = Session::get('partner_date');

        $common['partner_name']   = $partner_name;
        $common['partner_email']  = $partner_email;
        $common['partner_status'] = $partner_status;
        $common['partner_date']   = $partner_date;


        $get_partners = User::orderBy('id', 'desc')
            ->where(['user_type' => 'Partner'])->whereNull('is_delete');

        if ($partner_name) {
            $get_partners = $get_partners->where(DB::raw('concat(`first_name`," ", `last_name`)'), 'like', '%' . $partner_name . '%');
        }

        if ($partner_email) {
            $get_partners = $get_partners->where('email', 'like', '%' . $partner_email . '%');
        }

        if ($partner_status) {
            $get_partners = $get_partners->where('status', $partner_status);
        }

        if ($partner_date) {

            $getordersDate = explode('to', $partner_date);
            $formdate = '';
            $todate = '';
            if (isset($getordersDate[0])) {
                $formdate = $getordersDate[0] . " 00:00:00";

                $get_partners->whereDate('created_at', '>=', $formdate);
            }
            if (isset($getordersDate[1])) {
                $todate = $getordersDate[1] . " 23:59:59";
                $get_partners->whereDate('created_at', '<=', $todate);
            }
        }

        $get_partners_count = $get_partners->count();
        $get_partners = $get_partners->paginate(config('adminconfig.records_per_page'));

        return view('admin.accounts.partners', compact('common', 'get_partners', 'get_partners_count'));
    }

    // Add Partner
    public function add_partner_account(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Accounts");
        Session::put("SubMenu", "Suppliers");

        $common['title']          = 'Suppliers';
        $common['heading_title']  = 'Add Suppliers';
        $common['button']         = translate("Save");

        $get_partners            = getTableColumn('users');

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        if ($request->isMethod('post')) {

            $req_fields = array();
            $req_fields['first_name']     = "required";
            $req_fields['last_name']      = "required";
            if ($request->id == '') {
                $req_fields['image']              = "required|mimes:jpg,jpeg,png,gif,svg";
                $req_fields['password']           = "required";
                $req_fields['confirm_password']   = "required|same:password";
                $req_fields['email']          = "required|email|unique:users";
            }
            $req_fields['phone_number']   = "required";
            $req_fields['company_email']   = "required";
            $req_fields['company_phone']   = "required";
            $req_fields['company_address']   = "required";

            $errormsg = [
                "first_name" => translate("First Name"),
                "last_name"  => translate("Last Name"),
                "email"      => translate("Email"),
                "phone_number"  => translate("Phone number"),
                "password"    => translate("Password"),
                "confirm_password" => translate("Confirm Password"),
                "company_email"    => translate("Company Email"),
                "company_phone"    => translate("Company Phone"),
                "company_address"  => translate("Company Address"),

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
                $User = User::find($request->id);
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $User = new User();
                $User->password         = Hash::make($request->password);
                $User->decrypt_password = $request->password;
            }

            $User->first_name    = $request->first_name;
            $User->last_name     = $request->last_name;
            $User->email         = $request->email;
            $User->phone_number  = $request->phone_number;
            $User->company_email = $request->company_email;
            $User->company_phone = $request->company_phone;
            $User->company_address = $request->company_address;
            $User->partner_commission = $request->partner_commission;
            $User->status        = $request->status;
            $User->user_type     = 'Partner';
            $User->is_verified   = 1;

            if ($request->hasFile('image')) {
                $random_no  = uniqid();
                $img        = $request->file('image');
                $mime_type  =  $img->getMimeType();
                $ext        = $img->getClientOriginalExtension();
                $new_name   = $random_no . '.' . $ext;
                $destinationPath =  public_path('uploads/user_image');
                $img->move($destinationPath, $new_name);
                $User->image = $new_name;
            }
            $User->save();

            return redirect()->route('admin.partner_account')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                         = checkDecrypt($id);
            $common['title']            = "Edit Partners";
            $common['heading_title']    = "Edit Partners";
            $common['button']           = "Update";

            $get_partners = User::where('id', $id)->first();
            if (!$get_partners) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }

        return view('admin.accounts.add_partner', compact('common', 'get_partners'));
    }


    // Delete Partners
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_partner =  User::where(['id' => $id])->first();
        if ($get_partner) {
            $get_partner->is_delete = 1;
            $get_partner->save();
        }
        $status     = 'success';
        $message    = 'Delete Successfully';
        return back()->withErrors([$status => $message]);
    }


    // User List
    public function users_list(Request $request)
    {
        $common          = array();
        $common['title'] = "Users";
        Session::put("TopMenu", "Accounts");
        Session::put("SubMenu", "Users");

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        // Filter
        if ($request->isMethod('post')) {
            if (isset($request->filter)) {
                Session::put('customer_name', $request->customer_name);
                Session::put('customer_email', $request->customer_email);
                Session::put('customer_status', $request->customer_status);
                Session::put('customer_date', $request->customer_date);
            } elseif (isset($request->reset)) {
                Session::put('customer_name', '');
                Session::put('customer_email', '');
                Session::put('customer_date', '');
                Session::put('customer_status', '');
            }
            return redirect()->route('admin.users_list');
        }


        $customer_name   = Session::get('customer_name');
        $customer_email  = Session::get('customer_email');
        $customer_status = Session::get('customer_status');
        $customer_date   = Session::get('customer_date');

        $common['customer_name']   = $customer_name;
        $common['customer_email']  = $customer_email;
        $common['customer_status'] = $customer_status;
        $common['customer_date']   = $customer_date;

        $get_users = User::orderBy('id', 'desc')->where(['user_type' => 'Customer'])->whereNull('is_delete');



        if ($customer_name) {
            $get_users = $get_users->where(DB::raw('concat(`first_name`," ", `last_name`)'), 'like', '%' . $customer_name . '%');
        }

        if ($customer_email) {
            $get_users = $get_users->where('email', 'like', '%' . $customer_email . '%');
        }

        if ($customer_status) {
            $get_users = $get_users->where('status', $customer_status);
        }

        if ($customer_date) {

            $getordersDate = explode('to', $customer_date);
            $formdate = '';
            $todate = '';
            if (isset($getordersDate[0])) {
                $formdate = $getordersDate[0] . " 00:00:00";

                $get_users->whereDate('created_at', '>=', $formdate);
            }
            if (isset($getordersDate[1])) {
                $todate = $getordersDate[1] . " 23:59:59";
                $get_users->whereDate('created_at', '<=', $todate);
            }
        }
        $get_users_count = $get_users->count();
        $get_users = $get_users->paginate(config('adminconfig.records_per_page'));



        return view('admin.accounts.users_list', compact('common', 'get_users', 'get_users_count'));
    }



    public function change_status(Request $request)
    {

        $id = $request->id;
        $is_approved = $request->is_approved;

        $User = User::find($id);
        if ($User) {

            $User->status = $is_approved;
            $User->save();

            // Status Change Email ---------------------
            $get_user = User::where(['id' => $id, 'user_type' => 'Partner'])->first();
            if ($get_user) {
                $email_array                   = [];
                $email_array['username']       = $get_user->first_name . ' ' . $get_user->last_name;
                $email_array['email']          = $get_user->email;
                $email_array['status']         = $get_user->status;
                $email_array['subject']        = 'Status Change';
                $email_array['page']           = 'email.status_change';
                Admin::send_mail($email_array);
            }
        }
    }

    public function changepassword(Request $request)
    {
        $common                  = [];
        $common['title']         = 'Change Password';
        $common['heading_title'] = 'Change Password';
        $common['button']        = 'Save';
        Session::put('TopMenu', 'Change Password');
        Session::put('SubMenu', 'Change Password');
        $user_id = Session::get('em_admin_id');
        $admin   = Admin::where(['id' => $user_id, 'role' => 'Admin'])->first();

        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'old_password'     => 'required',
                'new_password'     => 'required',
                'confirm_password' => 'required',
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            if ($admin) {
                if (Hash::check($request->old_password, $admin->password)) {
                    if (!Hash::check($request->confirm_password, $admin->password)) {
                        $admin->password = Hash::make($request->confirm_password);
                        $admin->save();
                        return redirect(route('admin.dashboard'))->withErrors(['success' => "Password Change Successfully"]);
                    } else {
                        return back()->withErrors(['error' => "old password and new password must not match"]);
                    }
                } else {
                    return back()->withErrors(['error' => "Password Not match"]);
                }
            } else {
                return back()->withErrors(['error' => "Invalid Credential"]);
            }
        }
        return view('admin.changepassword', compact('common', 'admin'));
    }
}
