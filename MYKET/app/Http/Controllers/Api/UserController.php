<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\TransactionHistory;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //User Profile
    public function userProfile(Request $request)
    {

        $output = [];
        $output['status'] = false;
        $output['message'] = 'User Not Found';

        $req_fields = array();


        $req_fields['currency']   = "required";
        $req_fields['language']   = "required";

        $errormsg = [
            "currency"                 => translate("Currency"),
            "language"                 => translate("Language"),
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
            return response()->json(
                [
                    'status' => false,
                    'message' => $validation->errors()->first(),
                ],
                402,
            );
        }


        $user_id = $request->user_id;

        $data = [];
        $User = User::where('id', $user_id)
            ->where('is_verified', 1)
            ->where('is_delete', null)
            ->first();

        if ($User) {
            $checkStatus = 0;
            if ($User->status == 'Active') {
                $checkStatus = 1;
            }
            if ($User->user_type == 'Partner') {
                $checkStatus = 1;
            }
            if ($checkStatus == 1) {
                $data['first_name']   = $User->first_name   != '' ? $User->first_name : '';
                $data['last_name']    = $User->last_name    != '' ? $User->last_name : '';
                $data['phone_number'] = $User->phone_number != '' ? $User->phone_number : '';
                $data['phone_code']   = $User->phone_code   != '' ? $User->phone_code : '';
                $data['email']        = $User->email        != '' ? $User->email : '';
                $data['country']      = $User->country      != '' ? $User->country : '';
                $data['state']        = $User->state        != '' ? $User->state : '';
                $data['city']         = $User->city         != '' ? $User->city : '';
                $data['slug']         = $User->slug         != '' ? $User->slug : '';

                $data['address']                = $User->address != '' ? $User->address : '';
                $data['zipcode']                = $User->zipcode != '' ? $User->zipcode : '';
                $data['paid_amount_days_type'] = $User->paid_amount_days_type;
                $data['user_type']              = $User->user_type;
                $data['image']                  = $User->image   != '' ? url('uploads/user_image', $User->image) : asset('public/uploads/img_avatar.png');
                if ($User->user_type == "Affiliate") {
                    $data['affiliate_code'] = $User->affiliate_code;
                }
                $data['is_paypal_account'] = 1;

                $output['status'] = true;
                $output['user_id'] = encrypt($User->id);
                $output['password'] = $User->password;
                $output['data'] = $data;
                $output['message'] = 'User Profile';
            }
        }
        return json_encode($output);
    }

    // User Profile Update
    public function  userProfileUpdate(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'User Not Found';

        $req_fields = array();


        $req_fields['currency']        = "required";
        $req_fields['language']        = "required";
        $req_fields['first_name']      = "required";
        $req_fields['phone_number']    = "required";
        $req_fields['phone_code']    = "required";
        $req_fields['country']         = "required";
        $req_fields['state']           = "required";
        $req_fields['city']            = "required";
        $req_fields['change_password'] = "required";

        if (isset($request->change_password) && $request->change_password == 1) {
            $req_fields['old_password']     = "required|min:6";
            $req_fields['new_password']     = "required|min:6";
            $req_fields['confirm_password'] = "required_with:new_password|same:new_password|min:6";
        }

        $errormsg = [
            "currency"         => translate("Currency"),
            "language"         => translate("Language"),
            "first_name"       => translate("First name"),
            "phone_number"     => translate("Phone number"),
            "country"          => translate("Country"),
            "state"            => translate("State"),
            "city"             => translate("City"),
            "change_password"  => translate("Change password"),
            "old_password"     => translate("Old password"),
            "new_password"     => translate("New password"),
            "confirm_password" => translate("Confirm password"),
            "phone_code"       => translate("Phone Code"),
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
            return response()->json(
                [
                    'status' => false,
                    'message' => $validation->errors()->first(),
                ],
                402,
            );
        }


        $user_id = $request->user_id;
        $User = User::where('id', $user_id)
            ->where('is_verified', 1)

            ->where('is_delete', null)
            ->first();
        if ($User) {

            $checkStatus = 0;
            if ($User->status == 'Active') {
                $checkStatus = 1;
            }
            if ($User->user_type == 'Partner') {
                $checkStatus = 1;
            }
            if ($checkStatus == 1) {
                $User->first_name            = $request->first_name;
                $User->last_name             = $request->last_name;
                $User->phone_number          = $request->phone_number;
                $User->phone_code            = $request->phone_code;
                $User->country               = $request->country;
                $User->state                 = $request->state;
                $User->city                  = $request->city;
                $User->zipcode               = $request->zipcode;
                $User->address               = $request->address;
                $User->paid_amount_days_type = $request->paid_amount_days_type;


                if ($request->hasFile('image')) {
                    $random_no = uniqid();
                    $img = $request->file('image');
                    $ext = $img->getClientOriginalExtension();
                    $new_name = $random_no . '.' . $ext;
                    $destinationPath = public_path('uploads/user_image');
                    $img->move($destinationPath, $new_name);
                    $User->image = $new_name;
                }




                $output['message'] = 'Profile Update Successfully';
                $checkPasswod = 1;
                if (isset($request->change_password) && $request->change_password == 1) {

                    if ($request->old_password == $User->decrypt_password) {
                        $User->password = Hash::make($request->new_password);
                        $User->decrypt_password = $request->old_password;
                        $output['message'] = 'Profile Update & Password Change Successfully';
                    } else {
                        $checkPasswod = 0;

                        $output['message'] = 'old password was wrong';
                    }
                }
                if ($checkPasswod == 1) {
                    $User->save();
                    $output['status'] = true;
                    $output['user_id'] = encrypt($User->id);
                    $output['password'] = $User->password;
                }
            }
        }
        return json_encode($output);
    }


    //User History
    public function transactionHistory(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'User Not Found';

        $user_id = $request->user_id;

        $setLimit     = 10;
        $offset       = $request->offset;
        $limit        = $offset * $setLimit;

        $data = [];
        $User = User::where('id', $user_id)
            ->where('is_verified', 1)
            ->where('is_delete', null)
            ->first();



        if ($User) {
            if ($User->total_commission == "") {
                $User->total_commission = 0;
            }
            if ($User->total_paid == "") {
                $User->total_paid = 0;
            }

            $Totalcommission = [];
            $Totalcommission['text'] = 'Total Commission';
            $Totalcommission['amount'] = get_price_front('', '', '', '', $User->total_commission);
            $Totalcommission['image'] =  url('/public/uploads/provider/dashbord_img1.png');
            $data['header_data'][] = $Totalcommission;

            $TotalPaidcommission = [];
            $TotalPaidcommission['text'] = 'Total Paid';
            $TotalPaidcommission['amount'] = get_price_front('', '', '', '', $User->total_paid);
            $TotalPaidcommission['image'] =  url('/public/uploads/provider/dashbord_img1.png');
            $data['header_data'][] = $TotalPaidcommission;

            $due_amount                 = $User->total_commission - $User->total_paid;

            $TotalDuecommission = [];
            $TotalDuecommission['text'] = 'Due Amount';
            $TotalDuecommission['amount'] = get_price_front('', '', '', '', $due_amount);
            $TotalDuecommission['image'] =  url('/public/uploads/provider/dashbord_img1.png');
            $data['header_data'][] = $TotalDuecommission;



            $bookings = array();

            $get_transaction_history = TransactionHistory::where('user_id', $request->user_id)->orderBy('id', 'desc')->offset($limit)
                ->limit($setLimit)->get();
            $count_get_transaction_history =  TransactionHistory::where('user_id', $request->user_id)->count();
            if (count($get_transaction_history) > 0) {
                foreach ($get_transaction_history as $key => $value) {
                    $row = array();

                    $row['id']                    = $value['id'];
                    $row['amount_type']           = $value['amount_type'];
                    $row['user_type']             = $value['user_type'];
                    $row['description']           = $value['description'];
                    $row['trans_type']            = $value['trans_type'];
                    $row['paid_amount_days_type'] = $value['paid_amount_days_type'];
                    $row['tax']                  = get_price_front("", "", "", "", $value['tax']);

                    $payment_proof_link = $value['payment_proof'] != '' ? url('uploads/transaction_history', $value['payment_proof']) : asset('uploads/placeholder/placeholder.png');
                    $img_extension = "png";
                    @$img_explode = explode('.', $value['payment_proof']);
                    @$img_extension = $img_explode[1];

                    $payment_proof_img = $payment_proof_link;
                    if ($img_extension == 'pdf') {
                        $payment_proof_img = asset('uploads/placeholder/pdf.png');
                    }

                    $row['payment_proof_extension']     = $img_extension;
                    $row['payment_proof_link'] = $payment_proof_link;
                    $row['payment_proof_img'] = $payment_proof_img;


                    $invoice_link = $value['invoice'] != '' ? url('uploads/transaction_history', $value['invoice']) : asset('uploads/placeholder/placeholder.png');

                    $invoice_img_extension = "png";
                    @$invoice_img_explode = explode('.', $value['invoice']);
                    @$invoice_img_extension = $invoice_img_explode[1];


                    $invoice_img = $invoice_link;
                    if ($invoice_img_extension == 'pdf') {
                        $invoice_img = asset('uploads/placeholder/pdf.png');
                    }

                    $row['invoice_extension']     = $invoice_img_extension;
                    $row['invoice_link'] = $invoice_link;
                    $row['invoice_img'] = $invoice_img;

                    $row['paid_amount']   = get_price_front('', '', '', '', $value['paid_amount']);
                    $row['date']          = date("d-M-Y H:i:s", strtotime($value['created_at']));

                    $bookings[] = $row;
                }
            }
            $data['transaction_history']   = $bookings;
            $output['page_count']   = ceil($count_get_transaction_history / $setLimit);
            $output['status'] = true;
            $output['user_id']  = encrypt($User->id);
            $output['password'] = $User->password;
            $output['data']     = $data;
            $output['message']  = 'Transaction History';
        }
        return json_encode($output);
    }
}
