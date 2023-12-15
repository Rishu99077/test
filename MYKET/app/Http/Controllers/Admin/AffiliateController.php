<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Coupon;
use App\Models\AffilliateCommission;
use App\Models\Orders;
use DB;

use App\Models\Languages;
use Illuminate\Support\Str;

class AffiliateController extends Controller
{
    public function index(Request $request)
    {
        $common = [];
        $common['title'] = translate('Affiliates');
        Session::put('TopMenu', translate('Account'));
        Session::put('SubMenu', translate('Affiliates'));
        Session::put('SubSubMenu', translate('Affiliates'));

        $get_session_language = getLang();
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
            return redirect()->route('admin.affiliates');
        }

        $affiliate_name = Session::get('affiliate_name');
        $affiliate_status = Session::get('affiliate_status');
        $affiliate_code = Session::get('affiliate_code');
        $affiliate_date = Session::get('affiliate_date');

        $common['affiliate_name'] = $affiliate_name;
        $common['affiliate_status'] = $affiliate_status;
        $common['affiliate_code'] = $affiliate_code;
        $common['affiliate_date'] = $affiliate_date;

        $get_affiliates = User::orderBy('id', 'desc')
            ->where(['user_type' => 'Affiliate'])
            ->whereNull('is_delete');

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
                $formdate = $getordersDate[0] . ' 00:00:00';

                $get_affiliates->whereDate('created_at', '>=', $formdate);
            }
            if (isset($getordersDate[1])) {
                $todate = $getordersDate[1] . ' 23:59:59';
                $get_affiliates->whereDate('created_at', '<=', $todate);
            }
        }

        $get_affiliates_count = $get_affiliates->count();
        $get_affiliates = $get_affiliates->paginate(config('adminconfig.records_per_page'));

        return view('admin.affiliates.index', compact('common', 'get_affiliates', 'get_affiliates_count'));
    }

    // Add affiliate

    public function add_affiliate(Request $request, $id = '')
    {
        $common = [];
        Session::put('TopMenu', translate('Account'));
        Session::put('SubMenu', translate('Affiliates'));
        Session::put('SubSubMenu', translate('Affiliate Commission'));

        $common['title'] = translate('Affiliates');
        $common['heading_title'] = translate('Add Affiliates');
        $common['button'] = translate('Save');

        $get_affiliate = getTableColumn('users');

        $get_session_language = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        if ($request->isMethod('post')) {
            $req_fields = [];
            $req_fields['first_name'] = 'required';
            $req_fields['last_name'] = 'required';
            if ($request->id == '') {
                $req_fields['image'] = 'required|mimes:jpg,jpeg,png,gif,svg';
                $req_fields['password'] = 'required';
                $req_fields['confirm_password'] = 'required|same:password';
                $req_fields['email'] = 'required|email|unique:users';
            }
            $req_fields['phone_number'] = 'required|numeric';

            $errormsg = [
                'first_name' => translate('First Name'),
                'last_name' => translate('Last Name'),
                'email' => translate('Email'),
                'phone_number' => translate('Phone number'),
                'password' => translate('Password'),
                'confirm_password' => translate('Confirm Password'),
            ];

            $validation = Validator::make(
                $request->all(),
                $req_fields,
                [
                    'required' => 'The :attribute field is required.',
                ],
                $errormsg,
            );

            if ($validation->fails()) {
                return back()
                    ->withErrors($validation)
                    ->withInput();
            }

            if ($request->id != '') {
                $message = translate('Update Successfully');
                $status = 'success';
                $User = User::find($request->id);
            } else {
                $message = translate('Add Successfully');
                $status = 'success';
                $User = new User();
                $User->password = Hash::make($request->password);
                $User->decrypt_password = $request->password;
                $unique_affiliate_code = unique_affiliate_code('users', 'affiliate_code');
                $User->affiliate_code = $unique_affiliate_code;
            }

            $User->first_name = $request->first_name;
            $User->last_name = $request->last_name;
            $User->email = $request->email;
            $User->phone_number = $request->phone_number;
            $User->affiliate_commission = $request->affiliate_commission;

            $User->status = $request->status;
            $User->user_type = 'Affiliate';
            $User->is_verified = 1;

            if ($request->hasFile('image')) {
                $random_no = uniqid();
                $img = $request->file('image');
                $mime_type = $img->getMimeType();
                $ext = $img->getClientOriginalExtension();
                $new_name = $random_no . '.' . $ext;
                $destinationPath = public_path('uploads/user_image');
                $img->move($destinationPath, $new_name);
                $User->image = $new_name;
            }
            $User->save();

            return redirect()
                ->route('admin.affiliates')
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'No Record Found']);
            }
            $id = checkDecrypt($id);
            $common['title'] = translate('Edit Affiliates');
            $common['heading_title'] = translate('Edit Affiliates');
            $common['button'] = translate('Update');

            $get_affiliate = User::where('id', $id)->first();
            if (!$get_affiliate) {
                return back()->withErrors(['error' => 'Something went wrong']);
            }
        }

        return view('admin.affiliates.add_affiliate', compact('common', 'get_affiliate'));
    }

    // Delete Affiliates
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'No Record Found']);
        }
        $id = checkDecrypt($id);
        $status = 'error';
        $message = translate('Something went wrong!');
        $get_affiliate = User::where(['id' => $id])->first();
        if ($get_affiliate) {
            $get_affiliate->is_delete = 1;
            $get_affiliate->save();
        }
        $status = 'success';
        $message = translate('Delete Successfully');
        return back()->withErrors([$status => $message]);
    }

    public function affiliate_commission(Request $request)
    {
        $common = [];
        $common['title'] = translate('Affiliate Commission');
        Session::put('TopMenu', translate('Account'));
        Session::put('SubMenu', translate('Affiliate Commission'));

        $get_session_language = getLang();
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
            return redirect()->route('admin.affiliate_commission');
        }

        $aff_affilliate_code = Session::get('aff_affilliate_code');
        $aff_affilliate_name = Session::get('aff_affilliate_name');
        $aff_affilliate_date = Session::get('aff_affilliate_date');
        $aff_affilliate_order_id = Session::get('aff_affilliate_order_id');

        $common['aff_affilliate_code'] = $aff_affilliate_code;
        $common['aff_affilliate_name'] = $aff_affilliate_name;
        $common['aff_affilliate_date'] = $aff_affilliate_date;
        $common['aff_affilliate_order_id'] = $aff_affilliate_order_id;

        $get_affiliates_commisions = AffilliateCommission::select('afilliate_comission.*', 'users.first_name', 'users.last_name', 'orders.order_id as OrderId')
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
                $formdate = $getordersDate[0] . ' 00:00:00';

                $get_affiliates_commisions->whereDate('afilliate_comission.created_at', '>=', $formdate);
            }
            if (isset($getordersDate[1])) {
                $todate = $getordersDate[1] . ' 23:59:59';
                $get_affiliates_commisions->whereDate('afilliate_comission.created_at', '<=', $todate);
            }
        }

        $get_affiliates_commisions = $get_affiliates_commisions->paginate(config('adminconfig.records_per_page'));

        return view('admin.affiliates.affiliate_commission', compact('common', 'get_affiliates_commisions'));
    }

    public function affiliate_commission_view(Request $request, $id = '')
    {
        $common = [];
        $common['title'] = translate('Affiliate Commission');
        Session::put('TopMenu', translate('Account'));
        Session::put('SubMenu', translate('Affiliate Commission'));

        $get_session_language = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'No Record Found']);
            }
            $id = checkDecrypt($id);

            $get_affiliates_commisions = AffilliateCommission::where('id', $id)->first();

            if ($get_affiliates_commisions) {
                $commissions = [];
                $commissions['affilliate_code'] = $get_affiliates_commisions['affilliate_code'];
                $commissions['total'] = $get_affiliates_commisions['total'];
                $commissions['products'] = json_decode($get_affiliates_commisions['product_json']);
                $commissions['type'] = $get_affiliates_commisions['type'];
                $commissions['date'] = $get_affiliates_commisions['created_at'];

                $get_orders = Orders::where(['id' => $get_affiliates_commisions['order_id']])->first();
                if ($get_orders) {
                    $commissions['order_id'] = $get_orders['order_id'];
                }

                $commissions['user_name'] = '-';
                $get_affiliate = User::where(['id' => $get_affiliates_commisions['user_id']])->first();
                if ($get_affiliate) {
                    $commissions['user_name'] = $get_affiliate['first_name'] . ' ' . $get_affiliate['last_name'];
                }
            }

            if (!$get_affiliates_commisions) {
                return back()->withErrors(['error' => 'Something went wrong']);
            }
        }

        return view('admin.affiliates.affiliate_commission_view', compact('common', 'get_affiliates_commisions', 'commissions'));
    }

    // Affiliiate Coupon
    public function affilliate_coupon(Request $request, $id = '')
    {
        $common = [];

        Session::put('TopMenu', translate('Account'));
        Session::put('SubMenu', translate('Affiliates'));

        $common['title'] = translate('Affiliates Coupon');
        $common['heading_title'] = translate('Add Affiliates Coupon');
        $common['button'] = translate('Save');

        $id = checkDecrypt($id);

        $get_session_language = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $get_coupon = Coupon::where('value', $id)
            ->orderBy('id', 'desc')
            ->whereNull('is_delete')
            ->paginate(config('adminconfig.records_per_page'));

        return view('admin.affiliates.affilliate_coupon', compact('common', 'get_coupon', 'id'));
    }

    // Add Affilliate Coupon

    public function add_affilliate_coupon(Request $request, $Affilliateid = '', $id = '')
    {
        $common = [];
        Session::put('TopMenu', translate('Account'));
        Session::put('SubMenu', translate('Affiliates'));

        $common['title'] = translate('Add Affiliates Coupon');
        $common['heading_title'] = translate('Add Affiliates Coupon');
        $common['button'] = translate('Save');
        $get_session_language = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $get_coupon = getTableColumn('coupon');

        $name = '';
        $Affilliateid = checkDecrypt($Affilliateid);
        $User = User::find($Affilliateid);
        if ($User) {
            $name = $User->first_name . ' ' . $User->last_name;
        } else {
            return back()->withErrors(['error' => 'Something went wrong']);
        }

        if ($request->isMethod('post')) {
            // echo "<pre>";
            // print_r($request->all());
            // echo "</pre>";die();

            $req_fields = [];
            $id = checkDecrypt($id);
            if ($request->id == '') {
                $req_fields['coupon_code'] = 'required|unique:coupon,code,' . $id;
            } else {
                $req_fields['coupon_code'] = 'required';
            }

            $req_fields['start_date'] = 'required';
            $req_fields['end_date'] = 'required';
            $req_fields['minimum_amount'] = 'required';
            $req_fields['coupon_amount'] = 'required';

            $errormsg = [
                'coupon_code' => translate('Coupon Code'),
                'start_date' => translate('Start Date'),
                'end_date' => translate('End Date'),
                'minimum_amount' => translate('Minimum Amount'),
                'coupon_amount' => translate('Coupon Amount'),
            ];

            $validation = Validator::make(
                $request->all(),
                $req_fields,
                [
                    'required' => 'The :attribute field is required.',
                ],
                $errormsg,
            );

            // if ($validation->fails()) {
            //     return response()->json(['error' => array_reverse($validation->getMessageBag()->toArray())]);
            // }

            if ($validation->fails()) {
                return back()
                    ->withErrors($validation)
                    ->withInput();
            }

            if ($request->id != '') {
                $message = translate('Update Successfully');
                $status = 'success';
                $Coupon = Coupon::find($request->id);
            } else {
                $message = translate('Add Successfully');
                $status = 'success';
                $Coupon = new Coupon();
            }

            $Coupon->coupon_type = 'affilliate';
            $Coupon->status = $request->status;
            $Coupon->coupon_amount = $request->coupon_amount;
            $Coupon->coupon_amount_type = $request->coupon_amount_type;
            $Coupon->minimum_amount = $request->minimum_amount;
            $Coupon->start_date = $request->start_date;
            $Coupon->end_date = $request->end_date;
            $Coupon->code = $request->coupon_code;

            $Coupon->value = $Affilliateid;

            $Coupon->save();

            return redirect()
                ->route('admin.affiliates.affilliate_coupon', ['id' => encrypt($Affilliateid)])
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => translate('No Record Found')]);
            }
            $id = checkDecrypt($id);
            $common['title'] = translate('Edit Affilliate Coupon');
            $common['heading_title'] = translate('Edit Affilliate Coupon');
            $common['button'] = translate('Update');

            $get_coupon = Coupon::where('id', $id)->first();
            if (!$get_coupon) {
                return back()->withErrors(['error' => 'Something went wrong']);
            }
        }

        return view('admin.affiliates.add_affilliate_coupon', compact('common', 'get_coupon', 'name', 'Affilliateid'));
    }
}
