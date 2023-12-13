<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\City;
use App\Models\AirportTransferCheckOut;
use App\Models\ProductCheckout;
use App\Models\ProductVoucher;
use App\Models\UserReview;
use App\Models\AllOrders;
use App\Models\LocationDistanceTiming;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;


require_once __DIR__ . "../../../../../public/plugin/dompdf/autoload.inc.php";

use Dompdf\Dompdf;

class OrderController extends Controller
{
    // public function order_list(Request $request)
    // {
    //     $output = [];
    //     $output['status'] = false;
    //     $output['message'] = 'Record Not Found';
    //     $validation = Validator::make($request->all(), [
    //         'language' => 'required',
    //     ]);

    //     if ($validation->fails()) {
    //         return response()->json(
    //             [
    //                 'status' => false,
    //                 'message' => $validation->errors()->first(),
    //             ],
    //             402,
    //         );
    //     }

    //     $get_list_arr = [];
    //     $language = $request->language;
    //     $user_id = $request->user_id;

    //     //Products
    //     $get_list_product_arr = [];
    //     $get_order_details = ProductCheckout::where('user_id', $user_id)
    //         ->orderBy('id', 'desc')
    //         ->get();
    //     if (!$get_order_details->isEmpty()) {
    //         foreach ($get_order_details as $key => $get_order_detail) {
    //             # code...
    //             $get_details_arr                 = [];
    //             $get_details_arr['product_type'] = 'product';
    //             $get_details_arr['id']           = encrypt($get_order_detail['id']);
    //             $get_details_arr['order_id']     = '#' . $get_order_detail['order_id'];
    //             $get_details_arr['first_name']   = $get_order_detail['first_name'];
    //             $get_details_arr['last_name']    = $get_order_detail['last_name'];
    //             $get_details_arr['email']        = $get_order_detail['email'];
    //             $get_details_arr['phone_code']   = $get_order_detail['phone_code'];
    //             $get_details_arr['phone_number'] = $get_order_detail['phone_number'];
    //             $get_details_arr['city_id']      = $get_order_detail['city'];
    //             $get_details_arr['country_id']   = $get_order_detail['country'];
    //             $get_details_arr['currency']     = $get_order_detail['currency'];
    //             $get_details_arr['country_name'] = '';
    //             if ($get_order_detail['country']) {
    //                 $get_country = Country::where('id', $get_order_detail['country'])->first();
    //                 if ($get_country) {
    //                     $get_details_arr['country_name'] = $get_country->name != '' ? $get_country->name : '';
    //                 }
    //             }
    //             $get_details_arr['city_name'] = '';
    //             if ($get_order_detail['city']) {
    //                 $get_city = City::where('id', $get_order_detail['city'])->first();
    //                 if ($get_city) {
    //                     $get_details_arr['city_name'] = $get_city->name != '' ? $get_city->name : '';
    //                 }
    //             }
    //             $get_details_arr['postcode'] = $get_order_detail['postcode'];
    //             $get_details_arr['address'] = $get_order_detail['address'];
    //             $get_details_arr['total'] = $get_order_detail['total'];
    //             $get_details_arr['payment_method'] = strtoupper($get_order_detail['payment_method']);
    //             $get_details_arr['date'] = date('Y-m-d', strtotime($get_order_detail['created_at']));
    //             $get_details_arr['status'] = $get_order_detail['status'];
    //             $get_details_arr['product_count'] = count(json_decode($get_order_detail['extra']));
    //             $get_details_arr['products']       = [];
    //             if(count(json_decode($get_order_detail['extra']))>0){
    //                 $get_details_arr['product_detail'] = json_decode($get_order_detail['extra']);
    //                 $products =  json_decode(json_encode($get_details_arr['product_detail']), true);
    //                 foreach ($products as $product_key => $product_value) {
    //                     # code...
    //                     if(isset($product_value['title'])){

    //                         $get_product                   = array();
    //                         $get_product['title']          = $product_value['title'];
    //                         $get_product['description']    = $product_value['description'];
    //                         $get_product['total']          = $product_value['total'];
    //                         $get_details_arr['products'][] = $get_product;
    //                     }
    //                 }
    //             }
    //             $get_list_product_arr[] = $get_details_arr;
    //         }
    //     }

    //     $get_list_tranfer_arr = [];
    //     // //Tranfer Check Out
    //     $AirportTransferCheckOut = AirportTransferCheckOut::where('user_id', $user_id)
    //         ->orderBy('id', 'desc')
    //         ->get();
    //     if (!$AirportTransferCheckOut->isEmpty()) {
    //         foreach ($AirportTransferCheckOut as $key => $get_order_detail) {
    //             # code...
    //             $get_details_arr                 = [];
    //             $get_details_arr['product_type'] = 'tranfer_product';
    //             $get_details_arr['id']           = encrypt($get_order_detail['id']);
    //               // $get_details_arr['decrypt_id']              =$get_order_detail['id'];
    //               // $get_details_arr['id']                      = $get_order_detail['id'];
    //             $get_details_arr['order_id']                = $get_order_detail['order_id']                != '' ? '#' . $get_order_detail['order_id'] : 0;
    //             $get_details_arr['title']                   = $get_order_detail['product_name']            != '' ? $get_order_detail['product_name'] : '';
    //             $get_details_arr['airport_name']           = $get_order_detail['airport_name']           != '' ? $get_order_detail['airport_name'] : '';
    //             $get_details_arr['going_to_location']       = $get_order_detail['going_to_location']       != '' ? $get_order_detail['going_to_location'] : '';
    //             $get_details_arr['adult']                   = $get_order_detail['adult']                   != '' ? $get_order_detail['adult'] : 0;
    //             $get_details_arr['child']                   = $get_order_detail['child']                   != '' ? $get_order_detail['child'] : 0;
    //             $get_details_arr['infant']                  = $get_order_detail['infant']                  != '' ? $get_order_detail['infant'] : 0;
    //             $get_details_arr['name_title']              = $get_order_detail['title']                   != '' ? $get_order_detail['title'] : '';
    //             $get_details_arr['first_name']              = $get_order_detail['first_name']              != '' ? $get_order_detail['first_name'] : '';
    //             $get_details_arr['last_name']               = $get_order_detail['last_name']               != '' ? $get_order_detail['last_name'] : '';
    //             $get_details_arr['email']                   = $get_order_detail['email']                   != '' ? $get_order_detail['email'] : '';
    //             $get_details_arr['phone_code']              = $get_order_detail['phone_code']              != '' ? $get_order_detail['phone_code'] : '';
    //             $get_details_arr['phone_number']            = $get_order_detail['phone_number']            != '' ? $get_order_detail['phone_number'] : '';
    //             $get_details_arr['address']                 = $get_order_detail['address']                 != '' ? $get_order_detail['address'] : '';
    //             $get_details_arr['return_transfer_check']   = $get_order_detail['return_transfer_check']   != '' ? $get_order_detail['return_transfer_check'] : 0;
    //             $get_details_arr['flight_number']           = $get_order_detail['flight_number']           != '' ? $get_order_detail['flight_number'] : '';
    //             $get_details_arr['flight_arrival_time']     = $get_order_detail['flight_arrival_time']     != '' ? $get_order_detail['flight_arrival_time'] : '';
    //             $get_details_arr['drop_off_point']          = $get_order_detail['drop_off_point']          != '' ? $get_order_detail['drop_off_point'] : '';
    //             $get_details_arr['pick_up_point']           = $get_order_detail['pick_up_point']           != '' ? $get_order_detail['pick_up_point'] : '';
    //             $get_details_arr['flight_departure_time']   = $get_order_detail['flight_departure_time']   != '' ? $get_order_detail['flight_departure_time'] : '';
    //             $get_details_arr['number_of_vehical']       = $get_order_detail['number_of_vehical']       != '' ? $get_order_detail['number_of_vehical'] : '';
    //             $get_details_arr['airportParkingFee']       = $get_order_detail['airportParkingFee']       != '' ? $get_order_detail['airportParkingFee'] : 0;
    //             $get_details_arr['total']                   = $get_order_detail['total_amount']            != '' ? $get_order_detail['total_amount'] : 0;
    //             $get_details_arr['remarks']                 = $get_order_detail['notes']                   != '' ? $get_order_detail['notes'] : '';
    //             $get_details_arr['accommodation_name']      = $get_order_detail['accommodation_name']      != '' ? $get_order_detail['accommodation_name'] : '';
    //             $get_details_arr['address_line_2']          = $get_order_detail['address_line_2']          != '' ? $get_order_detail['address_line_2'] : '';
    //             $get_details_arr['address_line_3']          = $get_order_detail['address_line_3']          != '' ? $get_order_detail['address_line_3'] : '';
    //             $get_details_arr['departure_flight_number'] = $get_order_detail['departure_flight_number'] != '' ? $get_order_detail['departure_flight_number'] : '';
    //             $get_details_arr['payment_method']          = $get_order_detail['payment_method']          != '' ? $get_order_detail['payment_method'] : '';
    //             $get_details_arr['country_id']              = $get_order_detail['country'];
    //             $get_details_arr['country_name']            = '';
    //             if ($get_order_detail['country']) {
    //                 $get_country = Country::where('id', $get_order_detail['country'])->first();
    //                 if ($get_country) {
    //                     $get_details_arr['country_name'] = $get_country->name != '' ? $get_country->name : '';
    //                 }
    //             }

    //             $get_details_arr['status']         = $get_order_detail['status'];
    //             $get_details_arr['date']           = date('Y-m-d', strtotime($get_order_detail['created_at']));
    //             $get_details_arr['payment_method'] = strtoupper($get_order_detail['payment_method']);
    //             $get_list_tranfer_arr[]            = $get_details_arr;
    //         }

    //         // $output['status']                  = true;
    //         // $output['data']                    = $get_list_arr;
    //         // $output['message']                 = "Airport transfer Booking List";
    //     }

    //     $get_list_arr = array_merge($get_list_product_arr, $get_list_tranfer_arr);

    //     if (count($get_list_arr) > 0) {
    //         $output['status'] = true;
    //         $output['data'] = $get_list_arr;
    //         $output['message'] = 'Order List';
    //     }
    //     return json_encode($output);
    // }


    public function order_list(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            'language' => 'required',
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
        if($request->offset){
            $offset      = $request->offset ;
        }
        $limit       = $offset * $setLimit;

        $get_list_arr = [];
        $language     = $request->language;
        $user_id      = $request->user_id;

        //Products
        $get_list_product_arr = [];  
        $getAllOrders         = AllOrders::where('user_id',$user_id);
        $getAllOrdersCount   = $getAllOrders->count();
        
        $getAllOrders         = $getAllOrders->offset($limit)->limit($setLimit)->orderBy('id', 'desc')->get();
        if (!$getAllOrders->isEmpty()) {
            foreach ($getAllOrders as $key => $value) {
                # code...
                $get_details_arr                 = [];
                if($value['order_type'] == 'product'){
                    $get_order_detail = ProductCheckout::where('user_id', $user_id)->where('id',$value['order_id'])
                        ->orderBy('id', 'desc')
                        ->first();
                if ($get_order_detail) {
                    
                        # code...
                        $get_details_arr['product_type'] = 'product';
                        $get_details_arr['id']           = encrypt($get_order_detail['id']);
                        $get_details_arr['order_id']     = '#' . $get_order_detail['order_id'];
                        $get_details_arr['first_name']   = $get_order_detail['first_name'];
                        $get_details_arr['last_name']    = $get_order_detail['last_name'];
                        $get_details_arr['email']        = $get_order_detail['email'];
                        $get_details_arr['phone_code']   = $get_order_detail['phone_code'];
                        $get_details_arr['phone_number'] = $get_order_detail['phone_number'];
                        $get_details_arr['city_id']      = $get_order_detail['city'];
                        $get_details_arr['country_id']   = $get_order_detail['country'];
                        $get_details_arr['currency']     = $get_order_detail['currency'];
                        $get_details_arr['country_name'] = '';
                        if ($get_order_detail['country']) {
                            $get_country = Country::where('id', $get_order_detail['country'])->first();
                            if ($get_country) {
                                $get_details_arr['country_name'] = $get_country->name != '' ? $get_country->name : '';
                            }
                        }
                        $get_details_arr['city_name'] = '';
                        if ($get_order_detail['city']) {
                            $get_city = City::where('id', $get_order_detail['city'])->first();
                            if ($get_city) {
                                $get_details_arr['city_name'] = $get_city->name != '' ? $get_city->name : '';
                            }
                        }
                        $get_details_arr['postcode'] = $get_order_detail['postcode'];
                        $get_details_arr['address'] = $get_order_detail['address'];
                        $get_details_arr['total'] = $get_order_detail['total'];
                        $get_details_arr['payment_method'] = strtoupper($get_order_detail['payment_method']);
                        $get_details_arr['date'] = date('Y-m-d', strtotime($get_order_detail['created_at']));
                        $get_details_arr['status'] = $get_order_detail['status'];
                        $get_details_arr['product_count'] = count(json_decode($get_order_detail['extra']));
                        $get_details_arr['products']       = [];
                        if(count(json_decode($get_order_detail['extra']))>0){
                            $get_details_arr['product_detail'] = json_decode($get_order_detail['extra']);
                            $products =  json_decode(json_encode($get_details_arr['product_detail']), true);
                            foreach ($products as $product_key => $product_value) {
                                # code...
                                $get_product                   = array();
                                if(isset($product_value['title'])){
        
                                    $get_product['title']          = $product_value['title'];
                                    $get_product['description']    = $product_value['description'];
                                    $get_product['total']          = $product_value['total'];
                                }else{
                                    $get_product['title']          = "Gift Card";
                                }
                                $get_details_arr['products'][] = $get_product;
                            }
                        }
                        
                    }
                }else{
                    $get_order_detail = AirportTransferCheckOut::where('user_id', $user_id)->where('id',$value['order_id'])
                    ->orderBy('id', 'desc')
                    ->first();
                    if ($get_order_detail) {
                            
                            $get_details_arr['product_type'] = 'tranfer_product';
                            $get_details_arr['id']           = encrypt($get_order_detail['id']);
                            // $get_details_arr['decrypt_id']              =$get_order_detail['id'];
                            // $get_details_arr['id']                      = $get_order_detail['id'];
                            $get_details_arr['order_id']                = $get_order_detail['order_id']                != '' ? '#' . $get_order_detail['order_id'] : 0;
                            $get_details_arr['title']                   = $get_order_detail['product_name']            != '' ? $get_order_detail['product_name'] : '';
                            $get_details_arr['airport_name']           = $get_order_detail['airport_name']           != '' ? $get_order_detail['airport_name'] : '';
                            $get_details_arr['going_to_location']       = $get_order_detail['going_to_location']       != '' ? $get_order_detail['going_to_location'] : '';
                            $get_details_arr['adult']                   = $get_order_detail['adult']                   != '' ? $get_order_detail['adult'] : 0;
                            $get_details_arr['child']                   = $get_order_detail['child']                   != '' ? $get_order_detail['child'] : 0;
                            $get_details_arr['infant']                  = $get_order_detail['infant']                  != '' ? $get_order_detail['infant'] : 0;
                            $get_details_arr['name_title']              = $get_order_detail['product_name']                   != '' ? $get_order_detail['product_name'] : '';

                            // $get_details_arr['name_title']              = $get_order_detail['title']                   != '' ? $get_order_detail['title'] : '';
                            
                            $get_details_arr['first_name']              = $get_order_detail['first_name']              != '' ? $get_order_detail['first_name'] : '';
                            $get_details_arr['last_name']               = $get_order_detail['last_name']               != '' ? $get_order_detail['last_name'] : '';
                            $get_details_arr['email']                   = $get_order_detail['email']                   != '' ? $get_order_detail['email'] : '';
                            $get_details_arr['phone_code']              = $get_order_detail['phone_code']              != '' ? $get_order_detail['phone_code'] : '';
                            $get_details_arr['phone_number']            = $get_order_detail['phone_number']            != '' ? $get_order_detail['phone_number'] : '';
                            $get_details_arr['address']                 = $get_order_detail['address']                 != '' ? $get_order_detail['address'] : '';
                            $get_details_arr['return_transfer_check']   = $get_order_detail['return_transfer_check']   != '' ? $get_order_detail['return_transfer_check'] : 0;
                            $get_details_arr['flight_number']           = $get_order_detail['flight_number']           != '' ? $get_order_detail['flight_number'] : '';
                            $get_details_arr['flight_arrival_time']     = $get_order_detail['flight_arrival_time']     != '' ? $get_order_detail['flight_arrival_time'] : '';
                            $get_details_arr['drop_off_point']          = $get_order_detail['drop_off_point']          != '' ? $get_order_detail['drop_off_point'] : '';
                            $get_details_arr['pick_up_point']           = $get_order_detail['pick_up_point']           != '' ? $get_order_detail['pick_up_point'] : '';
                            $get_details_arr['flight_departure_time']   = $get_order_detail['flight_departure_time']   != '' ? $get_order_detail['flight_departure_time'] : '';
                            $get_details_arr['number_of_vehical']       = $get_order_detail['number_of_vehical']       != '' ? $get_order_detail['number_of_vehical'] : '';
                            $get_details_arr['airportParkingFee']       = $get_order_detail['airportParkingFee']       != '' ? $get_order_detail['airportParkingFee'] : 0;
                            $get_details_arr['total']                   = $get_order_detail['total_amount']            != '' ? $get_order_detail['total_amount'] : 0;
                            $get_details_arr['remarks']                 = $get_order_detail['notes']                   != '' ? $get_order_detail['notes'] : '';
                            $get_details_arr['accommodation_name']      = $get_order_detail['accommodation_name']      != '' ? $get_order_detail['accommodation_name'] : '';
                            $get_details_arr['address_line_2']          = $get_order_detail['address_line_2']          != '' ? $get_order_detail['address_line_2'] : '';
                            $get_details_arr['address_line_3']          = $get_order_detail['address_line_3']          != '' ? $get_order_detail['address_line_3'] : '';
                            $get_details_arr['departure_flight_number'] = $get_order_detail['departure_flight_number'] != '' ? $get_order_detail['departure_flight_number'] : '';
                            $get_details_arr['payment_method']          = $get_order_detail['payment_method']          != '' ? $get_order_detail['payment_method'] : '';
                            $get_details_arr['country_id']              = $get_order_detail['country'];
                            $get_details_arr['country_name']            = '';
                            if ($get_order_detail['country']) {
                                $get_country = Country::where('id', $get_order_detail['country'])->first();
                                if ($get_country) {
                                    $get_details_arr['country_name'] = $get_country->name != '' ? $get_country->name : '';
                                }
                            }

                            $get_details_arr['status']         = $get_order_detail['status'];
                            $get_details_arr['date']           = date('Y-m-d', strtotime($get_order_detail['created_at']));
                            $get_details_arr['payment_method'] = strtoupper($get_order_detail['payment_method']);
                        }

                        // $output['status']                  = true;
                        // $output['data']                    = $get_list_arr;
                        // $output['message']                 = "Airport transfer Booking List";
                    
                }
                $get_list_product_arr[] = $get_details_arr;
            }

            $output['status']     = true;
            $output['data']       = $get_list_product_arr;
            $output['page_count'] = ceil($getAllOrdersCount / $setLimit);
            $output['message']    = 'Order List';
        } 
        return json_encode($output);
    }
    
    public function order_detail(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            // 'language' => 'required',
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

        $get_details_arr = [];
        $language = $request->language;
        $user_id = $request->user_id;
        $order_id = checkDecrypt($request->order_id);
        $get_order_detail = ProductCheckout::where('user_id', $user_id)
            ->where('id', $order_id)
            ->first();
        if ($get_order_detail) {
            $get_details_arr['product_type'] = 'product';
            $get_details_arr['id']           = $get_order_detail['id'];
            $get_details_arr['order_id']     = '#' . $get_order_detail['order_id'];
            $get_details_arr['first_name']   = $get_order_detail['first_name'];
            $get_details_arr['last_name']    = $get_order_detail['last_name'];
            $get_details_arr['email']        = $get_order_detail['email'];
            $get_details_arr['phone_code']   = $get_order_detail['phone_code'];
            $get_details_arr['phone_number'] = $get_order_detail['phone_number'];
            $get_details_arr['city_id']      = $get_order_detail['city'];
            $get_details_arr['country_id']   = $get_order_detail['country'];
            $get_details_arr['currency']     = $get_order_detail['currency'];
            $get_details_arr['date']         = date('Y-m-d', strtotime($get_order_detail['created_at']));
            $get_details_arr['country_name'] = '';
            if ($get_order_detail['country']) {
                $get_country = Country::where('id', $get_order_detail['country'])->first();
                if ($get_country) {
                    $get_details_arr['country_name'] = $get_country->name != '' ? $get_country->name : '';
                }
            }
            $get_details_arr['city_name'] = '';
            if ($get_order_detail['city']) {
                $get_city = City::where('id', $get_order_detail['city'])->first();
                if ($get_city) {
                    $get_details_arr['city_name'] = $get_city->name != '' ? $get_city->name : '';
                }
            }
            $get_details_arr['postcode']          = $get_order_detail['postcode'];
            $get_details_arr['address']           = $get_order_detail['address'];
            $get_details_arr['coupon_code']       = $get_order_detail['coupon_code']       != '' ? $get_order_detail['coupon_code'] : '';
            $get_details_arr['coupon_value']      = $get_order_detail['coupon_value']      != '' ? $get_order_detail['coupon_value'] : '';
            $get_details_arr['sub_total']         = $get_order_detail['sub_total']         != '' ? $get_order_detail['sub_total'] : '';
            $get_details_arr['total_tax']         = $get_order_detail['total_tax']         != '' ? $get_order_detail['total_tax'] : '';
            $get_details_arr['total_service_tax'] = $get_order_detail['total_service_tax'] != '' ? $get_order_detail['total_service_tax'] : '';
            $get_details_arr['total']             = $get_order_detail['total'];
            $get_details_arr['payment_method']    = $get_order_detail['payment_method'];
            $get_details_arr['status']            = $get_order_detail['status'];
            
            $get_details_arr['giftcard_code']       = $get_order_detail['giftcard_code']       != '' ? $get_order_detail['giftcard_code'] : '';
            $get_details_arr['giftcard_value']      = $get_order_detail['giftcard_value']      != '' ? $get_order_detail['giftcard_value'] : '';
            $get_details_arr['user_wallet_amount']      = $get_order_detail['user_wallet_amount']      != '' ? $get_order_detail['user_wallet_amount'] : 0;

            $get_details_arr['products']          = [];
            if (count(json_decode($get_order_detail['extra'])) > 0) {
                foreach (json_decode($get_order_detail['extra']) as $key => $value) {

                    if ($value->type == 'GiftCard') {

                        $product_id = 0;
                    } else {
                        $product_id = $value->id;
                    }

                    $is_review = false;
                    $get_review = UserReview::where('user_id', $user_id)
                        ->where('product_id', $product_id)
                        ->where('type', 'product')
                        ->first();
                    if ($get_review) {
                        $is_review = true;
                        $value->rating = $get_review['rating'];
                        $value->rating_title = $get_review['title'];
                        $value->rating_description = $get_review['description'];
                    }
                    $value->is_review = $is_review;
                    $get_details_arr['products'][] = $value;
                }
            }
            // return $get_details_arr;
            $output['status']  = true;
            $output['data']    = $get_details_arr;
            $output['message'] = 'Order Detail';
        }

        // $get_details_arr['product_type'] ="tranfer_product";

        return json_encode($output);
    }

    // Airport Transfer Order Detail
    public function airport_transfer_order_detail(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            'language' => 'required',
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

        $get_details_arr = [];
        $language        = $request->language;
        $user_id         = $request->user_id;
        $order_id        = checkDecrypt($request->order_id);





        $get_order_detail = AirportTransferCheckOut::where('user_id', $user_id)
            ->where('id', $order_id)
            ->first();
        if ($get_order_detail) {
            # code...
            $product_id                                 = $get_order_detail['product_id'];
            $get_details_arr['product_id']              = $get_order_detail['product_id'];
            $get_details_arr['id']                      = $get_order_detail['id'];
            $get_details_arr['order_id']                = $get_order_detail['order_id']                != '' ? '#' . $get_order_detail['order_id'] : 0;
            $get_details_arr['title']                   = $get_order_detail['product_name']            != '' ? $get_order_detail['product_name'] : '';
            $get_details_arr['airport_name']            = $get_order_detail['airport_name']            != '' ? $get_order_detail['airport_name'] : '';
            $get_details_arr['going_to_location']       = $get_order_detail['going_to_location']       != '' ? $get_order_detail['going_to_location'] : '';
            $get_details_arr['adult']                   = $get_order_detail['adult']                   != '' ? $get_order_detail['adult'] : 0;
            $get_details_arr['child']                   = $get_order_detail['child']                   != '' ? $get_order_detail['child'] : 0;
            $get_details_arr['infant']                  = $get_order_detail['infant']                  != '' ? $get_order_detail['infant'] : 0;
            $get_details_arr['name_title']              = $get_order_detail['title']                   != '' ? $get_order_detail['title'] : '';
            $get_details_arr['first_name']              = $get_order_detail['first_name']              != '' ? $get_order_detail['first_name'] : '';
            $get_details_arr['last_name']               = $get_order_detail['last_name']               != '' ? $get_order_detail['last_name'] : '';
            $get_details_arr['email']                   = $get_order_detail['email']                   != '' ? $get_order_detail['email'] : '';
            $get_details_arr['phone_code']              = $get_order_detail['phone_code']              != '' ? $get_order_detail['phone_code'] : '';
            $get_details_arr['phone_number']            = $get_order_detail['phone_number']            != '' ? $get_order_detail['phone_number'] : '';
            $get_details_arr['address']                 = $get_order_detail['address']                 != '' ? $get_order_detail['address'] : '';
            $get_details_arr['return_transfer_check']   = $get_order_detail['return_transfer_check']   != '' ? $get_order_detail['return_transfer_check'] : 0;
            $get_details_arr['flight_number']           = $get_order_detail['flight_number']           != '' ? $get_order_detail['flight_number'] : '';
            $get_details_arr['flight_arrival_time']     = $get_order_detail['flight_arrival_time']     != '' ? $get_order_detail['flight_arrival_time'] : '';
            $get_details_arr['drop_off_point']          = $get_order_detail['drop_off_point']          != '' ? $get_order_detail['drop_off_point'] : '';
            $get_details_arr['pick_up_point']           = $get_order_detail['pick_up_point']           != '' ? $get_order_detail['pick_up_point'] : '';
            $get_details_arr['flight_departure_time']   = $get_order_detail['flight_departure_time']   != '' ? $get_order_detail['flight_departure_time'] : '';
            $get_details_arr['number_of_vehical']       = $get_order_detail['number_of_vehical']       != '' ? $get_order_detail['number_of_vehical'] : '';
            $get_details_arr['airportParkingFee']       = $get_order_detail['airportParkingFee']       != '' ? $get_order_detail['airportParkingFee'] : 0;
            $get_details_arr['total_amount']            = $get_order_detail['total_amount']            != '' ? $get_order_detail['total_amount'] : 0;
            $get_details_arr['remarks']                 = $get_order_detail['notes']                   != '' ? $get_order_detail['notes'] : '';
            $get_details_arr['accommodation_name']      = $get_order_detail['accommodation_name']      != '' ? $get_order_detail['accommodation_name'] : '';
            $get_details_arr['address_line_2']          = $get_order_detail['address_line_2']          != '' ? $get_order_detail['address_line_2'] : '';
            $get_details_arr['address_line_3']          = $get_order_detail['address_line_3']          != '' ? $get_order_detail['address_line_3'] : '';
            $get_details_arr['departure_flight_number'] = $get_order_detail['departure_flight_number'] != '' ? $get_order_detail['departure_flight_number'] : '';
            $get_details_arr['currency']                = $get_order_detail['currency']                != '' ? $get_order_detail['currency'] : '';


            $get_details_arr['distance'] = '';
            $get_details_arr['journey_time'] = '';
            $get_distace_timing = LocationDistanceTiming::where(['airport_id' => $get_order_detail['airport_id'], 'location_id' => $get_order_detail['going_to_id']])->first();
            if ($get_distace_timing) {
                $get_details_arr['distance'] = $get_distace_timing['distance'];
                $get_details_arr['journey_time'] = $get_distace_timing['duration'];
            }

            $is_review = false;
            $get_review = UserReview::where('user_id', $user_id)
                ->where('product_id', $product_id)
                ->where('type', 'transfer_product')
                ->first();
            if ($get_review) {
                $is_review                             = true;
                $get_details_arr['rating']             = $get_review['rating'];
                $get_details_arr['rating_title']       = $get_review['title'];
                $get_details_arr['rating_description'] = $get_review['description'];
            }

            $get_details_arr['is_review'] = $is_review;
            $get_details_arr['product_detail'] = '';
            if ($get_order_detail['extras'] != '') {
                $get_details_arr['product_detail'] = json_decode($get_order_detail['extras']);
            }

            $get_details_arr['country_name'] = '';
            if ($get_order_detail['country']) {
                $get_country = Country::where('id', $get_order_detail['country'])->first();
                if ($get_country) {
                    $get_details_arr['country_name'] = $get_country->name != '' ? $get_country->name : '';
                }
            }
            $get_details_arr['departure_country'] = '';
            if ($get_order_detail['country']) {
                $get_departure_country = Country::where('id', $get_order_detail['departure_country'])->first();
                if ($get_departure_country) {
                    $get_details_arr['departure_country'] = $get_departure_country->name != '' ? $get_departure_country->name : '';
                }
            }
            $get_details_arr['status']         = $get_order_detail['status'];
            $get_details_arr['order_date']     = date('Y-m-d', strtotime($get_order_detail['created_at']));
            $get_details_arr['payment_method'] = strtoupper($get_order_detail['payment_method']);

            $output['status']  = true;
            $output['data']    = $get_details_arr;
            $output['message'] = 'Airport transfer Detail';
        }
        return json_encode($output);
    }


    public  function order_cancel(Request $request)
    {
        $output            = [];
        $output['status']  = false;
        $output['message'] = 'Record Not Found';
        $validation        = Validator::make($request->all(), [
            'language'     => 'required',
            'order_id'     => 'required',
            'type'         => 'required',
            // 'product_id'     => 'required',
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

        $language     = $request->language;
        $order_id     = $request->order_id;
        $product_id   = $request->product_id;


        $data            = [];
        if ($request->type == 'products') {
            $get_checkout_detail     = ProductCheckout::where('id', $order_id)->first();
            if ($get_checkout_detail) {

                $Product_detail = json_decode($get_checkout_detail['extra'], true);

                if ($Product_detail != '') {
                    $Product_detail_New = array();
                    foreach ($Product_detail as $key => $value) {
                        if (isset($value['id'])) {
                            // if ($request->product_type == $value['type']) {
                                if ($value['id'] == $product_id) {
                                    $value['order_cancel']      = 1;
                                    $value['order_cancel_time'] = date('d-m-Y H:i:s');
                                    $value['order_cancel_by']   = 'User';
                                }
                                $Product_detail_New[] = $value;
                            // }
                        }
                    }
                    $ProductCheckout         = ProductCheckout::find($order_id);
                    $ProductCheckout->extra  = json_encode($Product_detail_New);
                    $ProductCheckout->save();

                    $output['status']  = true;
                    $output['order_cancel']  = 1;
                    $output['order_cancel_time']  = date('d-m-Y H:i:s');
                    $output['message'] = "Order cancel successfully";
                } else {
                    $output['message'] = "Product not found";
                }
            } else {
                $output['message'] = "No Order available";
            }
        } elseif ($request->type == 'transfer_product') {
            $get_transfer_order_detail = AirportTransferCheckOut::where('id', $order_id)->where('order_cancel', 0)->first();
            if ($get_transfer_order_detail) {
                $Product_detail = json_decode($get_transfer_order_detail['extras'], true);
                // foreach ($Product_detail as $key => $value) {
                $Product_detail['order_cancel']      = 1;
                $Product_detail['order_cancel_time'] = date('d-m-Y H:i:s');
                $Product_detail['order_cancel_by']   = 'User';
                $Product_detail_New = $Product_detail;
                // }
                $AirportTransferCheckOut                    = AirportTransferCheckOut::find($order_id);
                $AirportTransferCheckOut->extras            = json_encode($Product_detail_New);
                $AirportTransferCheckOut->order_cancel      = 1;
                $AirportTransferCheckOut->order_cancel_time = date('d-m-Y H:i:s');
                $AirportTransferCheckOut->order_cancel_by   = 'User';
                $AirportTransferCheckOut->save();
                $output['status']  = true;
                $output['order_cancel']  = 1;
                $output['order_cancel_time']  = date('d-m-Y H:i:s');
                $output['message'] = "Order cancel successfully";
            } else {
                $output['message'] = "No Order available";
            }
        }
        return json_encode($output);
    }


    public function generate_airport_voucher($order_id)
    {
        $order_id          = checkDecrypt($order_id);
        $get_order_detail = AirportTransferCheckOut::where('id', $order_id)
        ->first();
        if ($get_order_detail) {
            $dompdf            = new Dompdf();
            # code...
            $product_id                                 = $get_order_detail['product_id'];
            $get_details_arr['product_id']              = $get_order_detail['product_id'];
            $get_details_arr['id']                      = $get_order_detail['id'];

            $get_details_arr['order_id']                = $get_order_detail['order_id']                != '' ? '#' . $get_order_detail['order_id'] : 0;
            $get_details_arr['title']                   = $get_order_detail['product_name']            != '' ? $get_order_detail['product_name'] : '';
            $get_details_arr['airport_name']            = $get_order_detail['airport_name']            != '' ? $get_order_detail['airport_name'] : '';
            $get_details_arr['going_to_location']       = $get_order_detail['going_to_location']       != '' ? $get_order_detail['going_to_location'] : '';
            $get_details_arr['adult']                   = $get_order_detail['adult']                   != '' ? $get_order_detail['adult'] : 0;
            $get_details_arr['child']                   = $get_order_detail['child']                   != '' ? $get_order_detail['child'] : 0;
            $get_details_arr['infant']                  = $get_order_detail['infant']                  != '' ? $get_order_detail['infant'] : 0;
            $get_details_arr['name_title']              = $get_order_detail['title']                   != '' ? $get_order_detail['title'] : '';
            $get_details_arr['first_name']              = $get_order_detail['first_name']              != '' ? $get_order_detail['first_name'] : '';
            $get_details_arr['last_name']               = $get_order_detail['last_name']               != '' ? $get_order_detail['last_name'] : '';
            $get_details_arr['email']                   = $get_order_detail['email']                   != '' ? $get_order_detail['email'] : '';
            $get_details_arr['phone_code']              = $get_order_detail['phone_code']              != '' ? $get_order_detail['phone_code'] : '';
            $get_details_arr['phone_number']            = $get_order_detail['phone_number']            != '' ? $get_order_detail['phone_number'] : '';
            $get_details_arr['address']                 = $get_order_detail['address']                 != '' ? $get_order_detail['address'] : '';
            $get_details_arr['return_transfer_check']   = $get_order_detail['return_transfer_check']   != '' ? $get_order_detail['return_transfer_check'] : 0;
            $get_details_arr['flight_number']           = $get_order_detail['flight_number']           != '' ? $get_order_detail['flight_number'] : '';
            $get_details_arr['flight_arrival_time']     = $get_order_detail['flight_arrival_time']     != '' ? $get_order_detail['flight_arrival_time'] : '';
            $get_details_arr['drop_off_point']          = $get_order_detail['drop_off_point']          != '' ? $get_order_detail['drop_off_point'] : '';
            $get_details_arr['pick_up_point']           = $get_order_detail['pick_up_point']           != '' ? $get_order_detail['pick_up_point'] : '';
            $get_details_arr['flight_departure_time']   = $get_order_detail['flight_departure_time']   != '' ? $get_order_detail['flight_departure_time'] : '';
            $get_details_arr['number_of_vehical']       = $get_order_detail['number_of_vehical']       != '' ? $get_order_detail['number_of_vehical'] : '';
            $get_details_arr['airportParkingFee']       = $get_order_detail['airportParkingFee']       != '' ? $get_order_detail['airportParkingFee'] : 0;
            $get_details_arr['total_amount']            = $get_order_detail['total_amount']            != '' ? $get_order_detail['total_amount'] : 0;
            $get_details_arr['remarks']                 = $get_order_detail['notes']                   != '' ? $get_order_detail['notes'] : '';
            $get_details_arr['accommodation_name']      = $get_order_detail['accommodation_name']      != '' ? $get_order_detail['accommodation_name'] : '';
            $get_details_arr['address_line_2']          = $get_order_detail['address_line_2']          != '' ? $get_order_detail['address_line_2'] : '';
            $get_details_arr['address_line_3']          = $get_order_detail['address_line_3']          != '' ? $get_order_detail['address_line_3'] : '';
            $get_details_arr['departure_flight_number'] = $get_order_detail['departure_flight_number'] != '' ? $get_order_detail['departure_flight_number'] : '';
            $get_details_arr['currency'] = $get_order_detail['currency'] != '' ? $get_order_detail['currency'] : '';
            $is_review                                  = false;


            $get_details_arr['product_detail'] = '';
            if ($get_order_detail['extras'] != '') {
                $get_details_arr['product_detail'] = json_decode($get_order_detail['extras']);
                $get_details_arr['product_detail_arr'] = json_decode(json_encode($get_details_arr['product_detail']), true);
            }

            // print_die($get_details_arr['product_detail_arr']['transfer_zones']);
            
            
            $get_details_arr['country_name'] = '';
            if ($get_order_detail['country']) {
                $get_country = Country::where('id', $get_order_detail['country'])->first();
                if ($get_country) {
                    $get_details_arr['country_name'] = $get_country->name != '' ? $get_country->name : '';
                }
            }
            $get_details_arr['departure_country'] = '';
            if ($get_order_detail['country']) {
                $get_departure_country = Country::where('id', $get_order_detail['departure_country'])->first();
                if ($get_departure_country) {
                    $get_details_arr['departure_country'] = $get_departure_country->name != '' ? $get_departure_country->name : '';
                }
            }
            $get_details_arr['status']         = $get_order_detail['status'];
            $get_details_arr['order_date']     = date('Y-m-d', strtotime($get_order_detail['created_at']));
            $get_details_arr['payment_method'] = strtoupper($get_order_detail['payment_method']);

            $voucherDetails = ProductVoucher::where("product_id", $product_id)->first();

            $viewhtml = View::make("pdf.airport_transfer_detail", compact('get_details_arr', 'voucherDetails'))->render();



            // return $viewhtml;
            $dompdf->load_html($viewhtml);            
            $options = $dompdf->getOptions();
            $options->set(array('isRemoteEnabled' => true));
            $options->set('isPhpEnabled', true);
            $dompdf->setOptions($options);
            $dompdf->set_paper('A4', 'potrait');
            $dompdf->render();
            $pdf = $dompdf->output();
            ob_end_clean();
            $dompdf->stream('airport_transfer.pdf',array('Attachment' => true));
            // $dompdf->stream(
            //     "Menu-Engineering.pdf",
            //     array('Attachment' => false)
            // );
        }
    }

    public function generate_product_voucher($order_id)
    {
        $get_details_arr   = [];
        
        $order_id          = checkDecrypt($order_id);
        $get_order_detail  = ProductCheckout::where('id', $order_id)
        ->first();
        if ($get_order_detail) {
            $dompdf            = new Dompdf();
            $get_details_arr['product_type'] = 'product';
            $get_details_arr['id']           = $get_order_detail['id'];
            $get_details_arr['order_id']     = '#' . $get_order_detail['order_id'];
            $get_details_arr['first_name']   = $get_order_detail['first_name'];
            $get_details_arr['last_name']    = $get_order_detail['last_name'];
            $get_details_arr['email']        = $get_order_detail['email'];
            $get_details_arr['phone_code']   = $get_order_detail['phone_code'];
            $get_details_arr['phone_number'] = $get_order_detail['phone_number'];
            $get_details_arr['city_id']      = $get_order_detail['city'];
            $get_details_arr['country_id']   = $get_order_detail['country'];
            $get_details_arr['currency']     = $get_order_detail['currency'];
            $get_details_arr['date']         = date('Y-m-d', strtotime($get_order_detail['created_at']));
            $get_details_arr['country_name'] = '';
            if ($get_order_detail['country']) {
                $get_country = Country::where('id', $get_order_detail['country'])->first();
                if ($get_country) {
                    $get_details_arr['country_name'] = $get_country->name != '' ? $get_country->name : '';
                }
            }
            $get_details_arr['city_name'] = '';
            if ($get_order_detail['city']) {
                $get_city = City::where('id', $get_order_detail['city'])->first();
                if ($get_city) {
                    $get_details_arr['city_name'] = $get_city->name != '' ? $get_city->name : '';
                }
            }
            $get_details_arr['postcode']          = $get_order_detail['postcode'];
            $get_details_arr['address']           = $get_order_detail['address'];
            $get_details_arr['coupon_code']       = $get_order_detail['coupon_code']       != '' ? $get_order_detail['coupon_code'] : '';
            $get_details_arr['coupon_value']      = $get_order_detail['coupon_value']      != '' ? $get_order_detail['coupon_value'] : '';
            $get_details_arr['sub_total']         = $get_order_detail['sub_total']         != '' ? $get_order_detail['sub_total'] : '';
            $get_details_arr['total_tax']         = $get_order_detail['total_tax']         != '' ? $get_order_detail['total_tax'] : '';
            $get_details_arr['total_service_tax'] = $get_order_detail['total_service_tax'] != '' ? $get_order_detail['total_service_tax'] : '';
            $get_details_arr['total']             = $get_order_detail['total'];
            $get_details_arr['payment_method']    = $get_order_detail['payment_method'];
            $get_details_arr['status']            = $get_order_detail['status'];
            
            $get_details_arr['giftcard_code']       = $get_order_detail['giftcard_code']       != '' ? $get_order_detail['giftcard_code'] : '';
            $get_details_arr['giftcard_value']      = $get_order_detail['giftcard_value']      != '' ? $get_order_detail['giftcard_value'] : '';

            $get_details_arr['product_detail_arr'] = [];
            if (count(json_decode($get_order_detail['extra'])) > 0) {
                $product_detail = json_decode($get_order_detail['extra']);
                $get_details_arr['product_detail_arr'] = json_decode(json_encode($product_detail), true);
            }
            
            // $get_details_arr['products']          = [];
            // if (count(json_decode($get_order_detail['extra'])) > 0) {
            //     foreach (json_decode($get_order_detail['extra']) as $key => $value) {

            //         if ($value->type == 'GiftCard') {
            //             $product_id = 0;
            //         } else {
            //             $product_id = $value->id;
            //         }

            //         // $is_review = false;
            //         // $get_review = UserReview::where('user_id', $user_id)
            //         //     ->where('product_id', $product_id)
            //         //     ->where('type', 'product')
            //         //     ->first();
            //         // if ($get_review) {
            //         //     $is_review = true;
            //         //     $value->rating = $get_review['rating'];
            //         //     $value->rating_title = $get_review['title'];
            //         //     $value->rating_description = $get_review['description'];
            //         // }
            //         // $value->is_review = $is_review;
            //         $get_details_arr['products'][] = $value;
            //     }
            // }
            // return $get_details_arr;

            $viewhtml = View::make("pdf.product_detail", compact('get_details_arr'))->render();



            // return $viewhtml;
            $dompdf->load_html($viewhtml);            
            $options = $dompdf->getOptions();
            $options->set(array('isRemoteEnabled' => true));
            $options->set('isPhpEnabled', true);
            $dompdf->setOptions($options);
            $dompdf->set_paper('A4', 'potrait');
            $dompdf->render();
            $pdf = $dompdf->output();
            $dompdf->stream('product.pdf',array('Attachment' => true));
        }
    }


   


    







}
