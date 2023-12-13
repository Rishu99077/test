<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AffilliateGeneratedLinks;
use App\Models\AffilliateCommission;
use App\Models\ProductCheckout;
use App\Models\Customers;
use App\Models\Product;
use App\Models\AffilliateCommissionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class AffilliateController extends Controller
{
    public function generate_affiliate_link(Request $request)
    {

        $output            = [];
        $output['status']  = false;
        $output['message'] = "User Not Found";
        $validator = Validator::make($request->all(), [
            'language'         => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                ],
                402,
            );
        }
        $user_id    = $request->user_id;
        $product_id = $request->product_id;
        $Product = Product::where('slug', $product_id)->first();
        $product_id = $Product->id;
        $code       = $request->code;

        $AffilliateGeneratedLinksCount = AffilliateGeneratedLinks::where(['product_id' => $product_id, 'user_id' => $user_id, 'code' => $code])->count();

        if ($AffilliateGeneratedLinksCount == 0) {
            $AffilliateGeneratedLinks = new AffilliateGeneratedLinks();
            $AffilliateGeneratedLinks->product_id = $product_id;
            $AffilliateGeneratedLinks->user_id = $user_id;
            $AffilliateGeneratedLinks->code = $code;
            $AffilliateGeneratedLinks->save();
            $output['status'] = true;
            $output['message'] = "Date Save Successfully...";
        }


        return json_encode($output);
    }

    public function affiliate_commission_list(Request $request)
    {
        $output            = [];
        $output['status']  = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            'language' => 'required',
            'user_id' => 'required',
            'code' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validation->errors()->first(),
                ],
                402,
            );
        }
        $setLimit    = 10;
        $offset      = 0;
        $user_id      = $request->user_id;
        $code      = $request->code;
        if ($request->offset) {
            $offset      = $request->offset;
        }
        $limit                         = $offset * $setLimit;
        $get_affiliate_commission      = AffilliateCommission::where(['user_id' => $user_id, 'affilliate_code' => $code])->orderBy('id', 'desc');
        $get_affiliate_commissionCount = $get_affiliate_commission->count();
        $get_affiliate_commission      = $get_affiliate_commission->offset($limit)->limit($setLimit)->get();
        $affiliate_comission = array();
        foreach ($get_affiliate_commission as $key => $value) {
            $row = array();
            $row['id']               = encrypt($value['id']);
            $row['currency']         = '';
            
            $row['product_order_id'] = '';
            if ($value['order_id']) {
                $get_product_checkout  = ProductCheckout::where(['id' => $value['order_id']])->first();
                if ($get_product_checkout) {
                    $row['product_order_id'] = "#" . $get_product_checkout['order_id'];
                    $row['currency']         = $get_product_checkout['currency'];
                }
            }
            $row['user_id']         = $value['user_id'];
            $row['date']         = date('Y-m-d', strtotime($value['created_at']));

            $row['affiliate_name']  = '';
            if ($value['user_id']) {
                $get_customer  = Customers::where(['id' => $value['user_id']])->first();
                if ($get_customer) {
                    $row['affiliate_name'] = $get_customer['name'];
                }
            }

            $row['affilliate_code'] = $value['affilliate_code'];
            $row['total']           = $value['total'];
            $row['order_id']        = $value['order_id'];

            $affiliate_comission[] = $row;
        }

        if (count($affiliate_comission) > 0) {
            $output['status']                  = true;
            $output['page_count']              = ceil($get_affiliate_commissionCount / $setLimit);
            $output['data']                    = $affiliate_comission;
            $output['message']                 = "Affiliate comission List";
        }
        return json_encode($output);
    }


    public function affiliate_commission_detail(Request $request)
    {
        $output            = [];
        $output['status']  = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            'order_id' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validation->errors()->first(),
                ],
                402,
            );
        }
        $get_details_arr  = [];
        $order_id         = checkDecrypt($request->order_id);

        $get_affiliate_commission    = AffilliateCommission::where('id', $order_id)->first();

        if ($get_affiliate_commission) {
            $get_details_arr['currency']         = '';
            $get_details_arr['id']               = $get_affiliate_commission['id'];
            $get_details_arr['product_order_id'] = "";
            if ($get_affiliate_commission['order_id']) {
                $get_product_checkout  = ProductCheckout::where(['id' => $get_affiliate_commission['order_id']])->first();
                if ($get_product_checkout) {
                    $get_details_arr['product_order_id'] = "#" . $get_product_checkout['order_id'];
                    $get_details_arr['currency']         =      $get_product_checkout['currency'];
                }
            }
            $get_details_arr['user_id']        = $get_affiliate_commission['user_id'];
            $get_details_arr['affiliate_name'] = '';

            if ($get_affiliate_commission['user_id']) {
                $get_customer  = Customers::where(['id' => $get_affiliate_commission['user_id']])->first();
                if ($get_customer) {
                    $get_details_arr['affiliate_name'] = $get_customer['name'];
                }
            }

            $get_details_arr['affilliate_code'] = $get_affiliate_commission['affilliate_code'];
            $get_details_arr['total']           = $get_affiliate_commission['total'];
            $get_details_arr['order_id']        = $get_affiliate_commission['order_id'];
            $get_details_arr['date']            = date('Y-m-d', strtotime($get_affiliate_commission['created_at']));
            $get_details_arr['history']         = [];
            $AfilliateComissionHistory          = AffilliateCommissionHistory::where('afilliate_comission_id',$get_affiliate_commission['id'])->orderBy('id','desc')->get();
            if(!$AfilliateComissionHistory->isEmpty()){
                foreach ($AfilliateComissionHistory as $key => $value) {
                    # code...
                    $get_history = [];
                    $get_history['currency']        = "AED";
                    $get_history['amount']        = $value['paid_amount'];
                    $get_history['date']          = date('Y-m-d h:i:s', strtotime($value['created_at']));
                    $get_details_arr['history'][] = $get_history;
                }
            }

            if (count(json_decode($get_affiliate_commission['extra'])) > 0) {
                $get_details_arr['extra']           = json_decode($get_affiliate_commission['extra']);
            }


            $output['status']                  = true;
            $output['data']                    = $get_details_arr;
            $output['message']                 = "Order Detail";
        }
        return json_encode($output);
    }
}
