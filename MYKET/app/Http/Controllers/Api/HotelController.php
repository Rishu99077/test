<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HotelCommission;
use App\Models\Orders;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Validator;

class HotelController extends Controller
{
    // Dashboard 
    public function hotel_dashboard(Request $request)
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



        $get_hotel_commission  = HotelCommission::orderBy('id', 'desc')
            ->where(['hotel_commission.hotel_id' => $user_id, 'orders.status' => "Success"])
            ->select('hotel_commission.*', 'users.slug', 'orders.created_at')
            ->join('users', 'users.slug', '=', 'hotel_commission.hotel_slug')
            ->join('orders', 'orders.id', '=', 'hotel_commission.order_id');

        if ($Dashboardmonth != "") {
            $get_hotel_commission = $get_hotel_commission->whereMonth('orders.created_at', $Dashboardmonth);
            $get_hotel_commission = $get_hotel_commission->whereYear('orders.created_at', $Dashboardyear);
        }

        $get_hotel_commission = $get_hotel_commission->get();


        $hotel_comission = [];
        $total = 0;
        foreach ($get_hotel_commission as $key => $value) {
            if ($value['order_id']) {
                $Orders = Orders::find($value['order_id']);
                if ($Orders) {
                    $row = array();
                    $row['id']               = encrypt($value['id']);
                    $hotel_comission[] = $row;
                    $total += $value['total'];
                }
            }
        }

        $total_order_arr = array();
        $total_order_arr['title'] = 'Total Orders';
        $total_order_arr['count'] =  count($hotel_comission);
        $total_order_arr['link']  =  '/hotel-user-commission-history';
        $total_order_arr['image'] =  url('/public/uploads/provider/dashbord_img1.png');
        $data['header_data'][] = $total_order_arr;

        // Total Earnings
        $total_earning_arr = array();
        $total_earning_arr['title'] = 'Total Earnings';
        $total_earning_arr['count'] =  get_price_front("", "", "", "", $total);
        $total_earning_arr['link']  =  '/hotel-user-transaction-history';
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




            $HotelCommission =    HotelCommission::orderBy('id', 'desc')
                ->whereMonth('hotel_commission.created_at', $month)
                ->where(['hotel_commission.hotel_id' => $user_id, 'orders.status' => "Success"])
                ->select('hotel_commission.*', 'users.slug')
                ->join('users', 'users.slug', '=', 'hotel_commission.hotel_slug')
                ->join('orders', 'orders.id', '=', 'hotel_commission.order_id')
                ->get();


            $BookingAmount = 0;
            foreach ($HotelCommission as $Okey => $O) {

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


    // Hotel Commission History
    public function hotel_commission_list(Request $request)
    {
        $output            = [];
        $output['status']  = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            'language'        => 'required',
            'user_id'         => 'required',
            'hotel_slug'      => 'required',
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
        $code     = $request->hotel_slug;
        if ($request->offset) {
            $offset      = $request->offset;
        }
        $limit                         = $offset * $setLimit;

        $get_hotel_commission  = HotelCommission::orderBy('id', 'desc')
            ->select('hotel_commission.*', 'users.first_name', 'users.last_name')
            ->leftJoin('users', 'users.id', '=', 'hotel_commission.hotel_id')
            ->leftJoin('orders', 'orders.id', '=', 'hotel_commission.order_id')
            ->where(['hotel_commission.hotel_id' => $user_id, 'hotel_commission.hotel_slug' => $code, 'orders.status' => "Success"]);

        if (isset($request->is_filter) && $request->is_filter == 1) {

            if (isset($request->customer_name)) {
                $get_hotel_commission = $get_hotel_commission->where(DB::raw('concat(`users.first_name`," ", `users.last_name`)'), 'like', '%' .  $request->customer_name . '%');
            }

            if (isset($request->order_id)) {
                $get_hotel_commission = $get_hotel_commission->where('orders.order_id', 'like', '%' . $request->order_id . '%');
            }

            if (isset($request->status)) {
                $get_hotel_commission = $get_hotel_commission->where('hotel_commission.status', $request->status);
            }


            if (isset($request->search_by)) {
                if ($request->search_by == "Date") {

                    if (isset($request->from_date)) {
                        $formdate = '';

                        if (isset($request->from_date)) {
                            $formdate = $request->from_date . " 00:00:00";
                        }

                        if ($formdate != '') {
                            $get_hotel_commission->whereDate('hotel_commission.created_at', '>=', $formdate);
                        }
                    }

                    if (isset($request->to_date)) {

                        $todate = '';

                        if (isset($request->to_date)) {
                            $todate = $request->to_date . " 23:59:59";
                        }
                        if ($todate != '') {

                            $get_hotel_commission->whereDate('hotel_commission.created_at', '<=', $todate);
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
                            $get_hotel_commission = $get_hotel_commission->whereMonth('hotel_commission.created_at', $month);
                            $get_hotel_commission = $get_hotel_commission->whereYear('hotel_commission.created_at', $year);
                        }
                    }
                }
            }
        }

        $get_hotel_commission  =   $get_hotel_commission->get();

        $hotel_comission = [];
        foreach ($get_hotel_commission as $key => $value) {
            if ($value['order_id']) {
                $Orders = Orders::find($value['order_id']);

                if ($Orders) {
                    $row = array();
                    $row['id']               = encrypt($value['id']);
                    $row['order_id'] = "#" . $Orders->order_id;
                    $row['date']         = date('Y-m-d', strtotime($value['created_at']));
                    $row['total']           =  get_price_front('', '', '', '', $value['total']);
                    $product_json = json_decode($value['product_json']);
                    $product_total = 0;
                    if ($product_json) {
                        foreach ($product_json as $key => $PJ) {
                            $product_total += $PJ->product_amount;
                        }
                    }
                    $row['product_total']           =  get_price_front('', '', '', '', $product_total);


                    $hotel_comission[] = $row;
                }
            }
        }
        $hotel_comission = array_slice($hotel_comission, $limit, $setLimit);
        if (count($get_hotel_commission) > 0) {
            $output['status']     = true;
            $output['page_count'] = ceil(count($get_hotel_commission) / $setLimit);
            $output['data']       = $hotel_comission;
            $output['message']    = "Hotel comission List";
        }
        return json_encode($output);
    }


    // Hotel Commission Details
    public function hotel_commission_details(Request $request)
    {
        $output            = [];
        $output['status']  = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            'id' => 'required',
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
        $order_id         = checkDecrypt($request->id);

        $get_affiliate_commission    = HotelCommission::where('id', $order_id)->first();
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
}
