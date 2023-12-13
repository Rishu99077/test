<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\AddToCart;
use App\Models\ProductCheckoutGiftCard;
use App\Models\Customers;

use App\Models\Country;
use App\Models\City;

use File;

class GiftCardController extends Controller
{
    public function gift_add_to_cart(Request $request)
    {
        $output            = [];
        $output['status']  = false;
        $output['message'] = 'Data Not Found';
        $validation = Validator::make($request->all(), [
            'language'   => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validation->errors()->first(),
                ],
            );
        }
        $error = false;

        $language_id  = $request->language;
        $user_id     = $request->user_id != "" ? checkDecrypt($request->user_id) : 0;

        $dataArr['name']                   = $request->name;
        $dataArr['email']                  = $request->email;
        $dataArr['phone_code']             = $request->phone_code;
        $dataArr['phone_number']           = $request->phone_number;
        $dataArr['recipient_name']         = $request->recipient_name;
        $dataArr['recipient_email']        = $request->recipient_email;
        $dataArr['recipient_phone_number'] = $request->recipient_phone_number;
        $dataArr['recipient_phone_code']   = $request->recipient_phone_code;
        $dataArr['note']                   = $request->note;
        $dataArr['image_id']               = $request->image_id;
        $dataArr['currency']               = $request->currency;
        $image                             = "";
        if ($request->image_id > 0 && is_numeric($request->image_id)) {
            $string = $request->image;
            $symbol = "/";

            $imageName = "";
            $index = strrpos($string, $symbol);
            if ($index !== false) {
                $imageName = substr($string, $index + strlen($symbol));
            }

            File::copy(public_path('uploads/GiftCardPage/' . $imageName), public_path('uploads/user_gift_card/' . $imageName));
            $image = $imageName;
        } else {
            if ($request->hasFile('image')) {
                $random_no       = uniqid();
                $img              = $request->file('image');
                $ext              = $img->getClientOriginalExtension();
                $image          = $random_no . '.' . $ext;
                $destinationPath =  public_path('uploads/user_gift_card/');
                $img->move($destinationPath, $image);
            }
        }

        $dataArr['image']      = $image;
        $dataArr['amount']     = $request->amount;
        $dataArr['gift_title'] = $request->gift_title;
        $jsonData              = json_encode($dataArr);

        if ($error != true) {
            $AddToCart                 = new AddToCart();
            $AddToCart['product_id']   = "";
            $AddToCart['product_type'] = "GiftCard";
            $AddToCart['user_id']      = $user_id;
            $AddToCart['token']        = $request->token;
            $AddToCart['extra']        = $jsonData;
            $AddToCart['status']       = "Active";
            $AddToCart->save();
            $output['status'] = true;
            $output['message'] = 'Add To Cart Successfully...';
        }
        return json_encode($output);
    }

    public function gift_card_list(Request $request)
    {
        $output            = [];
        $output['status']  = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            'user_id'  => 'required',
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


        $get_list_arr     = [];
        $language         = $request->language;
        $user_id          = $request->user_id;

        $setLimit     = 10;
        $offset       = $request->offset;
        $limit        = $offset * $setLimit;

        //Products
        $get_list_product_arr  = [];

        $GiftCount = ProductCheckoutGiftCard::where('user_id', $user_id)->orderBy('id', 'DESC')->get();

        $GiftCount = $GiftCount->count();

        $get_order_details = ProductCheckoutGiftCard::where('user_id', $user_id)->offset($limit)->orderBy('id', 'desc')->limit($setLimit)->get();

        if (!$get_order_details->isEmpty()) {
            foreach ($get_order_details as $key => $get_order_detail) {

                $get_details_arr                 = array();
                $get_details_arr['id']           = encrypt($get_order_detail['id']);
                $get_details_arr['order_id']     = "#" . $get_order_detail['order_id'];
                $get_details_arr['user_id']      = $get_order_detail['user_id'];

                $get_customers_details  = Customers::where(['id' => $get_order_detail['user_id']])->first();
                if ($get_customers_details) {
                    $get_details_arr['name']         = $get_customers_details['name'];
                    $get_details_arr['email']        = $get_customers_details['email'];
                    $get_details_arr['phone_number'] = $get_customers_details['phone_number'];
                    $get_details_arr['city_id']      = $get_customers_details['city'];
                    $get_details_arr['country_id']   = $get_customers_details['country'];

                    $get_details_arr['country_name'] = '';
                    if ($get_customers_details['country']) {
                        $get_country = Country::where('id', $get_customers_details['country'])->first();
                        if ($get_country) {
                            $get_details_arr['country_name'] = $get_country->name != '' ? $get_country->name : '';
                        }
                    }
                    $get_details_arr['city_name'] = '';
                    if ($get_customers_details['city']) {
                        $get_city = City::where('id', $get_customers_details['city'])->first();
                        if ($get_city) {
                            $get_details_arr['city_name'] = $get_city->name != '' ? $get_city->name : '';
                        }
                    }

                    $get_details_arr['address']        = $get_customers_details['address'];
                }

                $get_details_arr['date']           = date('Y-m-d', strtotime($get_order_detail['created_at']));
                $get_details_arr['product_count']  = count(json_decode($get_order_detail['extra']));
                $get_details_arr['extras']       = [];
                if (count(json_decode($get_order_detail['extra'])) > 0) {
                    $products = json_decode($get_order_detail['extra']);

                    foreach ($products as $product_key => $product_value) {

                        $get_product                   = array();
                        $get_product['name']           = $product_value->name;
                        $get_product['email']          = $product_value->email;
                        $get_product['phone_code']     = $product_value->phone_code;
                        $get_product['phone_number']            = $product_value->phone_number;
                        $get_product['recipient_name']          = $product_value->recipient_name;
                        $get_product['recipient_phone_number']  = $product_value->recipient_phone_number;

                        $get_product['recipient_phone_code']    = $product_value->recipient_phone_code;
                        $get_product['note']        = $product_value->note;
                        $get_product['total']       = $product_value->total;
                        $get_product['type']        = $product_value->type;
                        $get_product['image']       = $product_value->image;

                        $get_details_arr['extras'][] = $get_product;
                    }
                }
                $get_list_product_arr[] = $get_details_arr;
            }
        }
        $get_list_arr = array_merge($get_list_product_arr);
        if (count($get_list_arr) > 0) {
            $output['status']                  = true;
            $output['data']                    = $get_list_arr;
            $output['page_count']              = ceil($GiftCount / $setLimit);
            $output['message']                 = "Gift card List";
        }
        return json_encode($output);
    }
}
