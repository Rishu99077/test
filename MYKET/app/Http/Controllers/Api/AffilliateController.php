<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AffilliateCommission;
use App\Models\Orders;
use App\Models\AffilliateGeneratedLinks;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Validator;

class AffilliateController extends Controller
{
    public function generate_affiliate_link(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
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
        $product_id = $request->tourId;
        $Product = Product::where('slug', $product_id)->first();
        $product_id = $Product->id;
        $code       = $request->affilliate_code;

        $AffilliateGeneratedLinksCount = AffilliateGeneratedLinks::where(['product_id' => $product_id, 'user_id' => $user_id, 'code' => $code])->count();

        if ($AffilliateGeneratedLinksCount == 0) {
            $AffilliateGeneratedLinks = new AffilliateGeneratedLinks();
            $AffilliateGeneratedLinks->product_id = $product_id;
            $AffilliateGeneratedLinks->user_id = $user_id;
            $AffilliateGeneratedLinks->code = $code;
            $AffilliateGeneratedLinks->save();
            $output['status'] = true;
            $output['message'] = "Link Generated Successfully...";
        }


        return json_encode($output);
    }

    // Affiliate Commission History
    public function affiliate_commission_list(Request $request)
    {
        $output            = [];
        $output['status']  = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            'language'        => 'required',
            'user_id'         => 'required',
            'affilliate_code' => 'required',
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
        $setLimit = 10;
        $offset   = 0;
        $user_id  = $request->user_id;
        $code     = $request->affilliate_code;
        if ($request->offset) {
            $offset      = $request->offset;
        }
        $limit                         = $offset * $setLimit;

        $get_affiliate_commission  = AffilliateCommission::orderBy('id', 'desc')
            ->select('afilliate_comission.*', 'users.first_name', 'users.last_name')
            ->leftJoin('users', 'users.id', '=', 'afilliate_comission.user_id')
            ->leftJoin('orders', 'orders.id', '=', 'afilliate_comission.order_id')
            ->where(['afilliate_comission.user_id' => $user_id, 'afilliate_comission.affilliate_code' => $code, 'orders.status' => "Success"]);

        if (isset($request->is_filter) && $request->is_filter == 1) {

            if (isset($request->customer_name)) {
                $get_affiliate_commission = $get_affiliate_commission->where(DB::raw('concat(`users.first_name`," ", `users.last_name`)'), 'like', '%' .  $request->customer_name . '%');
            }

            if (isset($request->order_id)) {
                $get_affiliate_commission = $get_affiliate_commission->where('orders.order_id', 'like', '%' . $request->order_id . '%');
            }

            if (isset($request->status)) {
                $get_affiliate_commission = $get_affiliate_commission->where('afilliate_comission.status', $request->status);
            }


            if (isset($request->search_by)) {
                if ($request->search_by == "Date") {

                    if (isset($request->from_date)) {
                        $formdate = '';

                        if (isset($request->from_date)) {
                            $formdate = $request->from_date . " 00:00:00";
                        }

                        if ($formdate != '') {
                            $get_affiliate_commission->whereDate('afilliate_comission.created_at', '>=', $formdate);
                        }
                    }

                    if (isset($request->to_date)) {

                        $todate = '';

                        if (isset($request->to_date)) {
                            $todate = $request->to_date . " 23:59:59";
                        }
                        if ($todate != '') {

                            $get_affiliate_commission->whereDate('afilliate_comission.created_at', '<=', $todate);
                        }
                    }
                }
                if ($request->search_by == "Month") {
                    if (isset($request->last_month)) {
                        $newDate = $request->last_month;
                        // $newDate = date("Y-m-d", strtotime("+1 month", $last_month));

                        $month = date("m", strtotime($newDate));
                        $year = date("Y", strtotime($newDate));
                        $new_date = $year . "-" . $month . "-" . "01";
                        if ($month != '') {
                            $get_affiliate_commission = $get_affiliate_commission->whereMonth('afilliate_comission.created_at', $month);
                            $get_affiliate_commission = $get_affiliate_commission->whereYear('afilliate_comission.created_at', $year);
                        }
                    }
                }
            }
        }

        $get_affiliate_commission  =   $get_affiliate_commission->get();

        $affiliate_comission = [];
        foreach ($get_affiliate_commission as $key => $value) {
            if ($value['order_id']) {
                $Orders = Orders::find($value['order_id']);

                if ($Orders) {
                    $row             = array();
                    $row['id']       = encrypt($value['id']);
                    $row['order_id'] = "#" . $Orders->order_id;
                    $row['date']     = date('Y-m-d', strtotime($value['created_at']));
                    $row['total']    = get_price_front('', '', '', '', $value['total']);
                    $product_json    = json_decode($value['product_json']);
                    $product_total   = 0;
                    if ($product_json) {
                        foreach ($product_json as $key => $PJ) {
                            $product_total += $PJ->product_amount;
                        }
                    }
                    $row['product_total']           =  get_price_front('', '', '', '', $product_total);


                    $affiliate_comission[] = $row;
                }
            }
        }
        $affiliate_comission = array_slice($affiliate_comission, $limit, $setLimit);
        if (count($get_affiliate_commission) > 0) {
            $output['status']     = true;
            $output['page_count'] = ceil(count($get_affiliate_commission) / $setLimit);
            $output['data']       = $affiliate_comission;
            $output['message']    = "Affiliate comission List";
        }
        return json_encode($output);
    }

    // Affilliate Commission Details

    public function affiliate_commission_details(Request $request)
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
        $totalAmount = 0;
        if ($get_affiliate_commission) {
            $get_details_arr['currency']         = '';
            $get_details_arr['id']               = $get_affiliate_commission['id'];
            $get_details_arr['order_id'] = "";
            if ($get_affiliate_commission['order_id']) {
                $get_product_checkout  = Orders::where(['id' => $get_affiliate_commission['order_id']])->first();
                if ($get_product_checkout) {
                    $get_details_arr['order_id'] = "#" . $get_product_checkout['order_id'];
                    $get_details_arr['currency']         =      $get_product_checkout['currency'];
                }
            }
            // $get_details_arr['user_id']        = $get_affiliate_commission['user_id'];


            $get_details_arr['affilliate_code'] = $get_affiliate_commission['affilliate_code'];
            $get_details_arr['total']           = $get_affiliate_commission['total'];

            // $get_details_arr['order_id']        = $get_affiliate_commission['order_id'];
            $get_details_arr['date']            = date('Y-m-d', strtotime($get_affiliate_commission['created_at']));

            $amount = [];
            $amount['title']  = "Total Commission";
            $amount['amount']  = get_price_front('', '', '', '', $get_affiliate_commission['total']);

            $get_details_arr['amount'][] = $amount;


            if (count(json_decode($get_affiliate_commission['product_json'])) > 0) {
                $get_details_arr['product_json']           = json_decode($get_affiliate_commission['product_json']);
            }


            $output['status']                  = true;
            $output['data']                    = $get_details_arr;
            $output['message']                 = "Order Detail";
        }
        return json_encode($output);
    }

    // Make Money

    public function make_money(request $request)
    {
        $output            = [];
        $output['status']  = false;
        $output['message'] = 'Record Not Found';
        $output['data']    = '';


        $user_id = $request->user_id;
        $User = User::find($user_id);
        $data = [];
        if ($User) {
            if ($User->user_type == "Affiliate") {
                $data['title'] = 'How to get rewards';
                $data['description'] = 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book';

                $middle_section = [];
                $first['image'] = asset('uploads/affilliate/box.png');
                $first['heading'] = 'Copy link bellow';
                $middle_section[] = $first;

                $second['image'] = asset('uploads/affilliate/box.png');
                $second['heading'] = 'Make commission for each person that buys through the link';
                $middle_section[] = $second;

                $third['image'] = asset('uploads/affilliate/gift.png');
                $third['heading'] = 'Share it in your social media accounts or blog';
                $middle_section[] = $third;


                $fourth['image'] = asset('uploads/affilliate/gift.png');
                $fourth['heading'] = 'Your earned amount can be added to your wallet or send to your via bank transfer';
                $middle_section[] = $fourth;

                $data['middle_section'] = $middle_section;
                $data['url'] = env("APP_URL") . $User->affiliate_code;

                $share = [];

                $linkedin['image'] = asset('uploads/social/linkedin.png');
                $linkedin['link'] = '#';
                $share[] = $linkedin;

                $instagram['image'] = asset('uploads/social/instagram.png');
                $instagram['link'] = '#';
                $share[] = $instagram;

                $youtube['image'] = asset('uploads/social/youtube.png');
                $youtube['link'] = '#';
                $share[] = $youtube;

                $pinterest['image'] = asset('uploads/social/pinterest.png');
                $pinterest['link'] = '#';
                $share[] = $pinterest;

                $twitter['image'] = asset('uploads/social/twitter.png');
                $twitter['link'] = '#';
                $share[] = $twitter;


                $facebook['image'] = asset('uploads/social/facebook.png');
                $facebook['link'] = '#';
                $share[] = $facebook;


                $data['share'] = $share;
                $data['share_text'] = 'Your earned amount can be added to your wallet or send to your via bank transfer';


                $output['status']  = true;
                $output['message'] = 'Record fetched Found';
                $output['data']    = $data;
            }
        }

        return json_encode($output);
    }

    // Dashboard 
    public function affilliate_dashboard(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(
                [
                    'status'  => false,
                    'message' => $validation->errors()->first(),
                ],
                402,
            );
        }

        $language_id  = $request->language;
        $user_id      = $request->user_id;
        $month        = $request->month;

        $Dashboardmonth = "";
        $Dashboardyear = "";
        if (isset($request->filter_month)) {

            $Dashboardmonth = date("m", strtotime($request->filter_month));
            $Dashboardyear = date("Y", strtotime($request->filter_month));
        }



        $get_affiliate_commission  = AffilliateCommission::orderBy('id', 'desc')
            ->where(['afilliate_comission.user_id' => $user_id, 'orders.status' => "Success"])
            ->select('afilliate_comission.*', 'users.affiliate_code', 'orders.created_at')
            ->join('users', 'users.affiliate_code', '=', 'afilliate_comission.affilliate_code')
            ->join('orders', 'orders.id', '=', 'afilliate_comission.order_id');

        if ($Dashboardmonth != "") {
            $get_affiliate_commission = $get_affiliate_commission->whereMonth('orders.created_at', $Dashboardmonth);
            $get_affiliate_commission = $get_affiliate_commission->whereYear('orders.created_at', $Dashboardyear);
        }

        $get_affiliate_commission = $get_affiliate_commission->get();


        $affiliate_comission = [];
        $total = 0;
        foreach ($get_affiliate_commission as $key => $value) {
            if ($value['order_id']) {
                $Orders = Orders::find($value['order_id']);
                if ($Orders) {
                    $row = array();
                    $row['id']               = encrypt($value['id']);
                    $affiliate_comission[] = $row;
                    $total += $value['total'];
                }
            }
        }

        $total_order_arr = array();
        $total_order_arr['title'] = 'Total Orders';
        $total_order_arr['count'] =  count($affiliate_comission);
        $total_order_arr['link']  =  '/commission-history';
        $total_order_arr['image'] =  url('/public/uploads/provider/dashbord_img1.png');
        $data['header_data'][] = $total_order_arr;

        // Total Earnings
        $total_earning_arr = array();
        $total_earning_arr['title'] = 'Total Earnings';
        $total_earning_arr['count'] =  get_price_front("", "", "", "", $total);
        $total_earning_arr['link']  =  '/commission-history';
        $total_earning_arr['image'] =  url('/public/uploads/provider/dashbord_img4.png');
        $data['header_data'][] =  $total_earning_arr;

        $Months = array();
        $last_month = 3;
        if (isset($request->last_month)) {
            $last_month = $request->last_month;
        }

        for ($i = 0; $i <= $last_month; $i++) {
            $Months = Carbon::today()->subMonth($i)->monthName;
            $month = Carbon::today()->subMonth($i)->format('m');




            $AffilliateCommission =    AffilliateCommission::orderBy('id', 'desc')
                ->whereMonth('afilliate_comission.created_at', $month)
                ->where(['afilliate_comission.user_id' => $user_id, 'orders.status' => "Success"])
                ->select('afilliate_comission.*', 'users.affiliate_code')
                ->join('users', 'users.affiliate_code', '=', 'afilliate_comission.affilliate_code')
                ->join('orders', 'orders.id', '=', 'afilliate_comission.order_id')
                ->get();


            $BookingAmount = 0;
            foreach ($AffilliateCommission as $Okey => $O) {

                if ($O['order_id']) {
                    $Orders = Orders::find($O['order_id']);
                    if ($Orders) {
                        $BookingAmount += $O['total'];
                    }
                }
            }
            $order['uData'][] = $BookingAmount;
            $order['xLabels'][] = $Months;



            $OrderLine = $order;
        }

        $data['line_chart'] = $OrderLine;
        $data['is_paypal_account'] = 0;

        $output['data']         = $data;
        $output['status']       = true;
        $output['status_code']  = 200;
        $output['message']      = "Data Fetch Successfully";
        return json_encode($output);
    }
}
