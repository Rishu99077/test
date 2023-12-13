<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\ProductCheckout;
use App\Models\AirportTransferCheckOut;

use App\Models\Product;

use App\Models\Supplier;
use App\Models\Country;
use App\Models\States;
use App\Models\City;
use App\Models\UserReview;
use App\Models\AllOrders;
use App\Models\ProductVoucher;


use App\Models\LocationDistanceTiming;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderController extends Controller
{
    // All Supplier
    public function index(Request $request)
    {
        $common = array();
        Session::put("TopMenu", "Orders");
        Session::put("SubMenu", "Orders");

        $common['title']             = translate("Orders");


        //FILTER ORDER POST DATA
        if ($request->isMethod('post')) {
            if (isset($request->filter)) {
                Session::put('product_name', $request->get('product_name'));
                Session::put('order_all', $request->get('All'));
                Session::put('order_id', $request->get('OrderID'));
                Session::put('order_name', $request->get('Name'));
                Session::put('order_email', $request->get('Email'));
                Session::put('order_status', $request->get('Status'));
                Session::put('order_date', $request->get('Order_date'));
            } elseif (isset($request->reset)) {
                Session::put('product_name', '');
                Session::put('order_all', '');
                Session::put('order_id', '');
                Session::put('order_name', '');
                Session::put('order_email', '');
                Session::put('order_status', '');
                Session::put('order_date', '');
            }
            return redirect()->route('admin.orders');
        }

        $product_name = Session::get('product_name');
        $order_all    = Session::get('order_all');
        $order_id     = Session::get('order_id');
        $order_name   = Session::get('order_name');
        $order_email  = Session::get('order_email');
        $order_status = Session::get('order_status');
        $order_date   = Session::get('order_date');

        $common['product_name']    = $product_name;
        $common['order_all']    = $order_all;
        $common['order_id']     = $order_id;
        $common['order_name']   = $order_name;
        $common['order_email']  = $order_email;
        $common['order_status'] = $order_status;
        $common['order_date']   = $order_date;



        //All Order Product Check Out And Air port Tranasfer
        $ProductCheckout         = AllOrders::select('all_orders.*')
                                    ->leftJoin('product_checkout', 'all_orders.order_id', '=', 'product_checkout.id')
                                    ->leftJoin('airport_transfer_checkout', 'all_orders.order_id', '=', 'airport_transfer_checkout.id');
        if($product_name !=''){
            $ProductCheckout = $ProductCheckout->where('product_checkout.extra', 'LIKE', '%' . $product_name . '%');
            $ProductCheckout = $ProductCheckout->orwhere('airport_transfer_checkout.extras', 'LIKE', '%' . $product_name . '%');
        }

       
                                    
        if ($order_all) {
            $ProductCheckout = $ProductCheckout->where('product_checkout.order_id', 'LIKE', '%' . $order_all . '%');
            $ProductCheckout = $ProductCheckout->where('airport_transfer_checkout.order_id', 'LIKE', '%' . $order_all . '%');
            
            
            $ProductCheckout = $ProductCheckout->orwhere('product_checkout.first_name', 'LIKE', '%' . $order_all . '%');
            $ProductCheckout = $ProductCheckout->orwhere('product_checkout.last_name', 'LIKE', '%' . $order_all . '%');
            $ProductCheckout = $ProductCheckout->orwhere('product_checkout.email', 'LIKE', '%' . $order_all . '%');
            $ProductCheckout = $ProductCheckout->orwhere('product_checkout.phone_number', 'LIKE', '%' . $order_all . '%');


            $ProductCheckout = $ProductCheckout->orwhere('airport_transfer_checkout.first_name', 'LIKE', '%' . $order_all . '%');
            $ProductCheckout = $ProductCheckout->orwhere('airport_transfer_checkout.last_name', 'LIKE', '%' . $order_all . '%');
            $ProductCheckout = $ProductCheckout->orwhere('airport_transfer_checkout.email', 'LIKE', '%' . $order_all . '%');
            $ProductCheckout = $ProductCheckout->orwhere('airport_transfer_checkout.phone_number', 'LIKE', '%' . $order_all . '%');
        }

        if ($order_id) {
            $ProductCheckout = $ProductCheckout->where('product_checkout.order_id', $order_id);
            $ProductCheckout = $ProductCheckout->orwhere('airport_transfer_checkout.order_id', $order_id);
        }

        if ($order_name) {
            $ProductCheckout = $ProductCheckout->where('product_checkout.first_name', 'LIKE', '%' . $order_name . '%');
            $ProductCheckout = $ProductCheckout->orwhere('product_checkout.last_name', 'LIKE', '%' . $order_name . '%');
            $ProductCheckout = $ProductCheckout->orwhere('airport_transfer_checkout.first_name', 'LIKE', '%' . $order_name . '%');
            $ProductCheckout = $ProductCheckout->orwhere('airport_transfer_checkout.last_name', 'LIKE', '%' . $order_name . '%');
        }

        if ($order_email) {
            $ProductCheckout = $ProductCheckout->where('product_checkout.email', 'LIKE', '%' . $order_email . '%');
            $ProductCheckout = $ProductCheckout->orwhere('airport_transfer_checkout.email', 'LIKE', '%' . $order_email . '%');
        }

        if ($order_status) {
            $ProductCheckout = $ProductCheckout->where('product_checkout.status', $order_status);
            $ProductCheckout = $ProductCheckout->orwhere('airport_transfer_checkout.status', $order_status);
        }

        if ($order_date) {
            $getordersDate = explode('to', $order_date);
            $formdate = '';
            $todate = '';
             if (isset($getordersDate[0])) {
                $formdate = $getordersDate[0]." 00:00:00";
             }
             if (isset($getordersDate[1])) {
                $todate = $getordersDate[1]." 23:59:59";
             }
             if ($formdate!='' AND $todate!='') {
                $ProductCheckout->whereDate('all_orders.created_at', '>=',$formdate);
                $ProductCheckout->whereDate('all_orders.created_at', '<=',$todate);
             }
        }
        $get_orders = $ProductCheckout->orderBy('all_orders.id', 'desc')->paginate(config('adminconfig.records_per_page'));
       
        $get_details_arr = array();
   
        foreach ($get_orders as $key => $value) {
            # code...
            $row                 = [];
            if($value['order_type'] == 'product'){
                $get_order_detail = ProductCheckout::where('id',$value['order_id'])
                    ->orderBy('id', 'desc')
                    ->first();
                if ($get_order_detail) {
                    
                        # code...
                        $row['product_type'] = 'product';
                        $row['id']           = $get_order_detail['id'];
                        $row['order_id']     = '#' . $get_order_detail['order_id'];
                        $row['first_name']   = $get_order_detail['first_name'];
                        $row['last_name']    = $get_order_detail['last_name'];
                        $row['email']        = $get_order_detail['email'];
                        $row['phone_code']   = $get_order_detail['phone_code'];
                        $row['phone_number'] = $get_order_detail['phone_number'];
                        $row['city_id']      = $get_order_detail['city'];
                        $row['country_id']   = $get_order_detail['country'];
                        $row['currency']     = $get_order_detail['currency'];
                        $row['country_name'] = '';
                        if ($get_order_detail['country']) {
                            $get_country = Country::where('id', $get_order_detail['country'])->first();
                            if ($get_country) {
                                $row['country_name'] = $get_country->name != '' ? $get_country->name : '';
                            }
                        }
                        $row['city_name'] = '';
                        if ($get_order_detail['city']) {
                            $get_city = City::where('id', $get_order_detail['city'])->first();
                            if ($get_city) {
                                $row['city_name'] = $get_city->name != '' ? $get_city->name : '';
                            }
                        }
                        $row['postcode'] = $get_order_detail['postcode'];
                        $row['address'] = $get_order_detail['address'];
                        $row['total'] = $get_order_detail['total'];
                        $row['payment_method'] = strtoupper($get_order_detail['payment_method']);
                        $row['date'] = date('Y-m-d', strtotime($get_order_detail['created_at']));
                        $row['status'] = $get_order_detail['status'];
                        $row['product_count'] = count(json_decode($get_order_detail['extra']));
                        $row['products']       = [];
                        if(count(json_decode($get_order_detail['extra']))>0){
                            $row['product_detail'] = json_decode($get_order_detail['extra']);
                            $products =  json_decode(json_encode($row['product_detail']), true);
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
                                $row['products'][] = $get_product;
                            }
                        }
                        $row['giftcard_code']       = $get_order_detail['giftcard_code']       != '' ? $get_order_detail['giftcard_code'] : '';
                        $row['giftcard_value']      = $get_order_detail['giftcard_value']      != '' ? $get_order_detail['giftcard_value'] : '';

                        $row['sent_to_supplier']      = $get_order_detail['sent_to_supplier'];
                        $row['paid_to_supplier']      = $get_order_detail['paid_to_supplier'];
                        $row['supplier_name']         = $get_order_detail['supplier_name']      != '' ? $get_order_detail['supplier_name'] : '';
                        
                    }
                }else{
                    $get_order_detail = AirportTransferCheckOut::where('id',$value['order_id'])
                    ->orderBy('id', 'desc')
                    ->first();
                    if ($get_order_detail) {
                            $row['products']       = [];
                            $row['product_type'] = 'tranfer_product';
                            $row['id']           = $get_order_detail['id'];
                            // $row['decrypt_id']              =$get_order_detail['id'];
                            // $row['id']                      = $get_order_detail['id'];
                            $row['currency']                = $get_order_detail['currency'];
                            $row['order_id']                = $get_order_detail['order_id']                != '' ? '#' . $get_order_detail['order_id'] : 0;
                            $row['title']                   = $get_order_detail['product_name']            != '' ? $get_order_detail['product_name'] : '';
                            $row['airport_name']           = $get_order_detail['airport_name']           != '' ? $get_order_detail['airport_name'] : '';
                            $row['going_to_location']       = $get_order_detail['going_to_location']       != '' ? $get_order_detail['going_to_location'] : '';
                            $row['adult']                   = $get_order_detail['adult']                   != '' ? $get_order_detail['adult'] : 0;
                            $row['child']                   = $get_order_detail['child']                   != '' ? $get_order_detail['child'] : 0;
                            $row['infant']                  = $get_order_detail['infant']                  != '' ? $get_order_detail['infant'] : 0;
                            $row['name_title']              = $get_order_detail['product_name']                   != '' ? $get_order_detail['product_name'] : '';

                            // $row['name_title']              = $get_order_detail['title']                   != '' ? $get_order_detail['title'] : '';
                            
                            $row['first_name']              = $get_order_detail['first_name']              != '' ? $get_order_detail['first_name'] : '';
                            $row['last_name']               = $get_order_detail['last_name']               != '' ? $get_order_detail['last_name'] : '';
                            $row['email']                   = $get_order_detail['email']                   != '' ? $get_order_detail['email'] : '';
                            $row['phone_code']              = $get_order_detail['phone_code']              != '' ? $get_order_detail['phone_code'] : '';
                            $row['phone_number']            = $get_order_detail['phone_number']            != '' ? $get_order_detail['phone_number'] : '';
                            $row['address']                 = $get_order_detail['address']                 != '' ? $get_order_detail['address'] : '';
                            $row['return_transfer_check']   = $get_order_detail['return_transfer_check']   != '' ? $get_order_detail['return_transfer_check'] : 0;
                            $row['flight_number']           = $get_order_detail['flight_number']           != '' ? $get_order_detail['flight_number'] : '';
                            $row['flight_arrival_time']     = $get_order_detail['flight_arrival_time']     != '' ? $get_order_detail['flight_arrival_time'] : '';
                            $row['drop_off_point']          = $get_order_detail['drop_off_point']          != '' ? $get_order_detail['drop_off_point'] : '';
                            $row['pick_up_point']           = $get_order_detail['pick_up_point']           != '' ? $get_order_detail['pick_up_point'] : '';
                            $row['flight_departure_time']   = $get_order_detail['flight_departure_time']   != '' ? $get_order_detail['flight_departure_time'] : '';
                            $row['number_of_vehical']       = $get_order_detail['number_of_vehical']       != '' ? $get_order_detail['number_of_vehical'] : '';
                            $row['airportParkingFee']       = $get_order_detail['airportParkingFee']       != '' ? $get_order_detail['airportParkingFee'] : 0;
                            $row['total']                   = $get_order_detail['total_amount']            != '' ? $get_order_detail['total_amount'] : 0;
                            $row['remarks']                 = $get_order_detail['notes']                   != '' ? $get_order_detail['notes'] : '';
                            $row['accommodation_name']      = $get_order_detail['accommodation_name']      != '' ? $get_order_detail['accommodation_name'] : '';
                            $row['address_line_2']          = $get_order_detail['address_line_2']          != '' ? $get_order_detail['address_line_2'] : '';
                            $row['address_line_3']          = $get_order_detail['address_line_3']          != '' ? $get_order_detail['address_line_3'] : '';
                            $row['departure_flight_number'] = $get_order_detail['departure_flight_number'] != '' ? $get_order_detail['departure_flight_number'] : '';
                            $row['payment_method']          = $get_order_detail['payment_method']          != '' ? $get_order_detail['payment_method'] : '';
                            $row['country_id']              = $get_order_detail['country'];
                            $row['country_name']            = '';
                            if ($get_order_detail['country']) {
                                $get_country = Country::where('id', $get_order_detail['country'])->first();
                                if ($get_country) {
                                    $row['country_name'] = $get_country->name != '' ? $get_country->name : '';
                                }
                            }
                            $row['giftcard_code']    = '';
                            $row['giftcard_value']   = '';
                            $row['sent_to_supplier'] = '';
                            $row['paid_to_supplier'] = '';
                            $row['supplier_name']    = '';

                            $row['status']         = $get_order_detail['status'];
                            $row['date']           = date('Y-m-d', strtotime($get_order_detail['created_at']));
                            $row['payment_method'] = strtoupper($get_order_detail['payment_method']);
                        }

                        // $output['status']                  = true;
                        // $output['data']                    = $get_list_arr;
                        // $output['message']                 = "Airport transfer Booking List";
                    
                }
            $get_details_arr[] = $row;
        }
        // print_die($get_details_arr);

        return view('admin.Orders.orders_list', compact('common','get_orders','get_details_arr'));
    }


    public function order_view(Request $request, $id = "")
    {

        $common = array();
        Session::put("TopMenu", "Orders");
        Session::put("SubMenu", "Orders");
        $common['title']      = translate("View Orders");
        $get_order = [];
        if ($id != "") {

            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id = checkDecrypt($id);

            $orders  = array();
            $get_order =  ProductCheckout::where('id', $id)->first();
            if ($get_order) {
                $orders['id']            = $get_order['id'];
                $orders['order_id']      = $get_order['order_id'];
                $orders['user_id']       = $get_order['user_id'];
                $orders['first_name']    = $get_order['first_name'];
                $orders['last_name']     = $get_order['last_name'];
                $orders['email']         = $get_order['email'];
                $orders['phone_code']    = $get_order['phone_code'];
                $orders['phone_number']  = $get_order['phone_number'];
                $orders['address']           = $get_order['address'];
                $orders['total']             = $get_order['total'];
                $orders['payment_method']    = $get_order['payment_method'];

                $orders['coupon_code']       = $get_order['coupon_code'];
                $orders['coupon_value']      = $get_order['coupon_value'];
                $orders['sub_total']         = $get_order['sub_total']         != '' ? $get_order['sub_total'] : '';
                $orders['total_tax']         = $get_order['total_tax']         != '' ? $get_order['total_tax'] : '';
                $orders['total_service_tax'] = $get_order['total_service_tax'] != '' ? $get_order['total_service_tax'] : '';

                $orders['status']            = $get_order['status'];
                $orders['created_at']        = date('Y-m-d', strtotime($get_order['created_at']));
                $orders['postcode']          = $get_order['postcode'];

                $orders['country_name'] = '';
                if ($get_order['country']) {
                    $get_country = Country::where('id', $get_order['country'])->first();
                    if ($get_country) {
                        $orders['country_name'] = $get_country->name != '' ? $get_country->name : '';
                    }
                }
                $orders['city_name'] = '';
                if ($get_order['city']) {
                    $get_city = City::where('id', $get_order['city'])->first();
                    if ($get_city) {
                        $orders['city_name'] = $get_city->name != '' ? $get_city->name : '';
                    }
                }



                $orders['country']  = '';
                $orders['city']     = '';
                $get_country = Country::where('id', $get_order['country'])->first();
                if ($get_country) {
                    $orders['country'] = $get_country['name'];
                }
                $get_city = City::where('id', $get_order['city'])->first();
                if ($get_city) {
                    $orders['city'] = $get_city['name'];
                }

                $orders['currency']   = $get_order['currency'];
                $orders['products_detail']   = json_decode($get_order['extra']);

                // $get_details_arr['products_detail']          = [];
                // if (count(json_decode($get_order['extra'])) > 0) {
                //     foreach (json_decode($get_order['extra']) as $key => $value) {

                //         if ($value->type == 'GiftCard') {

                //             $product_id = 0;
                //         } else {
                //             $product_id = $value->id;
                //         }

                //         $is_review = false;
                //         $get_review = UserReview::where('product_id', $product_id)
                //             ->where('type', 'product')
                //             ->first();
                //         if ($get_review) {
                //             $is_review = true;
                //             $value->rating = $get_review['rating'];
                //             $value->rating_title = $get_review['title'];
                //             $value->rating_description = $get_review['description'];
                //         }
                //         $value->is_review = $is_review;
                //         $get_details_arr['products_detail'][] = $value;
                //     }
                // }

            }


            if (!$get_order) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.Orders.orders_view', compact('common', 'get_order', 'orders'));
    }


    public function airport_transfer_order_detail($id){
        $common = array();
        Session::put("TopMenu", "Orders");
        Session::put("SubMenu", "Orders");
        $common['title'] = translate("Airport Transfer Orders");
        $get_details_arr = [];
        $order_id        = checkDecrypt($id);
        $get_order_detail = AirportTransferCheckOut::where('id', $order_id)
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
            $is_review                                  = false;

            $get_details_arr['product_detail_arr']      = '';
            $get_details_arr['product_detail']          = '';
            if ($get_order_detail['extras'] != '') {
                $get_details_arr['product_detail']      = json_decode($get_order_detail['extras']);
                $get_details_arr['product_detail_arr']  = json_decode(json_encode($get_details_arr['product_detail']), true);
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

            $voucherDetails = ProductVoucher::where("product_id", $product_id)->first();

            // print_die($get_details_arr);
            return view('admin.Orders.airport_tranfer_order_detail', compact('common', 'get_details_arr','get_order_detail'));

        }else{
            return back()->withErrors(["error" => "Something went wrong"]);
        }
        
    }


    public function order_cancel(Request $request)
    {
        $order_id = $request->order_id;
        $product_id = $request->product_id;

        $get_checkout_detail     = ProductCheckout::where('id', $order_id)->first();
        if ($get_checkout_detail) {

            $Product_detail = json_decode($get_checkout_detail['extra'], true);

            if ($Product_detail != '') {
                $Product_detail_New = array();
                foreach ($Product_detail as $key => $value) {
                    if ($value['id'] == $product_id) {
                        $value['order_cancel']      = 1;
                        $value['order_cancel_time'] = date('d-m-Y H:i:s');
                        $value['order_cancel_by']   = 'User';
                    }
                    $Product_detail_New[] = $value;
                }
                $ProductCheckout = ProductCheckout::find($order_id);
                $ProductCheckout->extra  = json_encode($Product_detail_New);
                $ProductCheckout->save();
            }
        }
    }


    public function generate_excel(Request $request){

        $common = array();
            //FILTER ORDER POST DATA
        if ($request->isMethod('post')) {
            if (isset($request->filter)) {
                Session::put('order_all', $request->get('All'));
                Session::put('order_id', $request->get('OrderID'));
                Session::put('order_name', $request->get('Name'));
                Session::put('order_email', $request->get('Email'));
                Session::put('order_status', $request->get('Status'));
                Session::put('order_date', $request->get('Order_date'));
            } elseif (isset($request->reset)) {
                Session::put('order_all', '');
                Session::put('order_id', '');
                Session::put('order_name', '');
                Session::put('order_email', '');
                Session::put('order_status', '');
                Session::put('order_date', '');
            }
            return redirect()->route('admin.orders');
        }

        $order_all    = Session::get('order_all');
        $order_id     = Session::get('order_id');
        $order_name   = Session::get('order_name');
        $order_email  = Session::get('order_email');
        $order_status = Session::get('order_status');
        $order_date   = Session::get('order_date');

        $common['order_all']     = $order_all;
        $common['order_id']      = $order_id;
        $common['order_name']    = $order_name;
        $common['order_email']  = $order_email;
        $common['order_status'] = $order_status;
        $common['order_date']   = $order_date;

        $ProductCheckout = ProductCheckout::orderBy('id', 'desc');

        if ($order_all) {
            $ProductCheckout = $ProductCheckout->where('order_id', 'LIKE', '%' . $order_all . '%');
            $ProductCheckout = $ProductCheckout->orwhere('first_name', 'LIKE', '%' . $order_all . '%');
            $ProductCheckout = $ProductCheckout->orwhere('last_name', 'LIKE', '%' . $order_all . '%');
            $ProductCheckout = $ProductCheckout->orwhere('email', 'LIKE', '%' . $order_all . '%');
            $ProductCheckout = $ProductCheckout->orwhere('phone_number', 'LIKE', '%' . $order_all . '%');
        }

        if ($order_id) {
            $ProductCheckout = $ProductCheckout->where('order_id', $order_id);
        }

        if ($order_name) {
            $ProductCheckout = $ProductCheckout->where('first_name', 'LIKE', '%' . $order_name . '%');
            $ProductCheckout = $ProductCheckout->orwhere('last_name', 'LIKE', '%' . $order_name . '%');
        }

        if ($order_email) {
            $ProductCheckout = $ProductCheckout->where('email', 'LIKE', '%' . $order_email . '%');
        }

        if ($order_status) {
            $ProductCheckout = $ProductCheckout->where('status', $order_status);
        }

        if ($order_date) {
            $getordersDate = explode('to', $order_date);
            $formdate = '';
            $todate = '';
             if (isset($getordersDate[0])) {
                $formdate = $getordersDate[0]." 00:00:00";
             }
             if (isset($getordersDate[1])) {
                $todate = $getordersDate[1]." 23:59:59";
             }
             if ($formdate!='' AND $todate!='') {
                 $ProductCheckout->whereDate('created_at', '>=',$formdate);
                 $ProductCheckout->whereDate('created_at', '<=',$todate);
             }
        }

        $get_orders = $ProductCheckout->get();


        $fileName = 'Orders.csv';

        ///////////EXCEL ////////
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        );
        $columns = array("Order ID.","Created by","Booking Date","Excursion Date","Ship To","Amount","Status");

        $callback = function () use ($get_orders,$columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($get_orders as $key => $value) {

                $row["Order ID."]        = $value['order_id'];
                $row["Created by"]       = $value['first_name'].' '.$value['last_name'];
                $row["Booking Date"]     = date('Y-m-d', strtotime($value['created_at']));
                $row["Excursion Date"]   = date('Y-m-d', strtotime($value['created_at']));
                $row["Ship To"]          = $value['address'];
                $row["Amount"]           = $value['currency'].' '.$value['total'];
                $row["Status"]           = $value['status'];
       
                fputcsv($file, array(
                    $row["Order ID."],
                    $row["Created by"],
                    $row["Booking Date"],
                    $row["Excursion Date"],
                    $row["Ship To"],
                    $row["Amount"],
                    $row["Status"],
                ));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
        
    }


    public function order_supplier_update(Request $request){

        $message = translate('Something went wrong');
        $status = 'error';

        if (isset($request->checkout_id)) {
            $message = translate('Update Successfully');
            $status = 'success';

            $ProductCheckout = ProductCheckout::find($request->checkout_id);
            $ProductCheckout['sent_to_supplier'] = isset($request->sent_to_supplier) ? 1 : 0;
            $ProductCheckout['supplier_name']    = $request->supplier_name;   
            $ProductCheckout['paid_to_supplier'] = isset($request->paid_to_supplier) ? 1 : 0;  
                
            $ProductCheckout->save();
        }
        return redirect()->back()->withErrors([$status => $message]);

    }

}
