<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\TransactionHistory;
use App\Models\AffilliateCommission;
use App\Models\Orders;
use App\Models\Admin;
use DB;


class TransactionHistoryController extends Controller
{

    public function transaction_history(Request $request)
    {
        $common          = array();
        $common['title'] = "Transaction History";
        Session::put("TopMenu", "Financial");
        Session::put("SubMenu", "Transaction History");

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        // Filter
        if ($request->isMethod('post')) {
            if (isset($request->filter)) {
                Session::put('user_name', $request->user_name);
                Session::put('user_status', $request->user_status);
                Session::put('user_type', $request->user_type);
            } elseif (isset($request->reset)) {
                Session::put('user_name', '');
                Session::put('user_status', '');
                Session::put('user_type', '');
            }
            return redirect()->route('admin.transaction_history');
        }

        $user_name    = Session::get('user_name');
        $user_status  = Session::get('user_status');
        $user_type    = Session::get('user_type');

        $common['user_name']   = $user_name;
        $common['user_status'] = $user_status;
        $common['user_type']   = $user_type;

        $get_user = User::orderBy('id', 'desc')->where('user_type', '!=', 'Customer')->whereNull('is_delete');

        if ($user_name) {
            $get_user = $get_user->where(DB::raw('concat(`first_name`," ", `last_name`)'), 'like', '%' . $user_name . '%');
        }

        if ($user_status) {
            $get_user = $get_user->where('status', $user_status);
        }

        if ($user_type) {
            $get_user = $get_user->where('user_type', $user_type);
        }

        $get_user = $get_user->paginate(config('adminconfig.records_per_page'));


        return view('admin.transaction_history.index', compact('common', 'get_user'));
    }

    // View Transaction History
    public function view_transaction_history(Request $request, $id = "")
    {

        $common = array();
        Session::put("TopMenu", "Financial");
        Session::put("SubMenu", "Transaction History");

        $common['title']          = 'Transaction History';
        $common['heading_title']  = 'View Transaction History';
        $common['button']         =  translate("Save");

        $get_user                 = getTableColumn('users');
        $get_transaction_history  = getTableColumn('transaction_history');

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        if ($request->isMethod('post')) {

            $message  = translate("Add Successfully");
            $status   = "success";
            $TransactionHistory   = new TransactionHistory();
            $prevAmount = 0;
            $get_user = User::where('id', $request->user_id)->first();
            +$paid_amount_days_type = 1;

            if ($get_user) {
                $paid_amount_days_type = $get_user['paid_amount_days_type'];
            }

            $TransactionHistory->user_id     = $request->user_id;
            $TransactionHistory->user_type   = $request->user_type;
            $TransactionHistory->paid_amount = $request->paid_amount;
            $TransactionHistory->amount_type = $request->amount_type;
            $TransactionHistory->description = $request->description;
            $TransactionHistory->tax         = $paid_amount_days_type == 0 ? 10 : 0;

            if ($request->hasFile('payment_proof')) {
                $random_no  = uniqid();
                $img        = $request->file('payment_proof');
                $mime_type  =  $img->getMimeType();
                $ext        = $img->getClientOriginalExtension();
                $new_name   = $random_no . '.' . $ext;
                $destinationPath =  public_path('uploads/transaction_history');
                $img->move($destinationPath, $new_name);
                $TransactionHistory->payment_proof = $new_name;
            }

            if ($request->hasFile('invoice')) {
                $random_no  = uniqid();
                $img        = $request->file('invoice');
                $mime_type  =  $img->getMimeType();
                $ext        = $img->getClientOriginalExtension();
                $new_name   = $random_no . '.' . $ext;
                $destinationPath =  public_path('uploads/transaction_history');
                $img->move($destinationPath, $new_name);
                $TransactionHistory->invoice = $new_name;
            }




            $TransactionHistory->save();


            if ($get_user) {
                $total_paid        = $get_user['total_paid'];
                $paid_commission   = $total_paid + $request->paid_amount;
                $paid_amount_days_type = $get_user['paid_amount_days_type'];
            }

            $User                    = User::find($request->user_id);
            $User->total_paid        = $paid_commission;
            if ($request->bank_name) {
                $User->bank_name        = $request->bank_name;
            }
            if ($request->iban) {
                $User->iban        = $request->iban;
            }
            if ($request->swift) {
                $User->swift        = $request->swift;
            }
            $User->save();

            // Transaction History mail

            $email_data_array                       = [];
            $email_data_array['total_commission']   = $get_user->total_commission;
            $email_data_array['total_paid']         = $paid_commission;
            $email_data_array['amount_paid']        = $request->paid_amount;
            $email_data_array['due']                = $get_user->total_commission - $paid_commission;
            $email_data_array['username']           = $get_user->first_name . ' ' . $get_user->last_name;
            $email_data_array['email']              = $get_user->email;
            $email_data_array['amount_type']        = $request->amount_type;
            $email_data_array['description']        = $request->description;
            $email_data_array['subject']            = 'Transaction Report';
            $email_data_array['page']               = 'email.transaction_history';



            Admin::send_mail($email_data_array);


            return redirect()->route('admin.transaction_history.view', encrypt($request->user_id))->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                         = checkDecrypt($id);
            $common['title']            = "View Transaction History";
            $common['heading_title']    = "View Transaction History";
            $common['button']           = "Add";

            $get_user = User::where('id', $id)->first();
            $get_transaction_history = TransactionHistory::where('user_id', $id)->orderBy('id', 'desc')->get();

            if (!$get_user) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }

        $tax_text = "If amount paid is selected 15th of month 10€ tax will be applied ";

        return view('admin.transaction_history.view', compact('common', 'get_user', 'get_transaction_history', 'tax_text'));
    }
}
