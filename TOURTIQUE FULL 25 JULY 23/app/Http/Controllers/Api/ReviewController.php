<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\UserReview;
use App\Models\User;

use App\Models\Country;
use App\Models\City;

use App\Models\Product;
use App\Models\ProductLanguage;

use App\Models\NewsLatterSubscribe;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;

class ReviewController extends Controller
{
    //Add Review
    public function add_review(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $validation = Validator::make($request->all(), [
            'language' => 'required',
            'user_id' => 'required',
            'title' => 'required',
            'rating' => 'required',
            'type' => 'required',
            'description' => 'required',
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

        $UserReview = new UserReview();
        $UserReview->user_id = $request->user_id;
        $UserReview->product_id = $request->product_id;
        $UserReview->title = $request->title;
        $UserReview->description = $request->description;
        $UserReview->rating = $request->rating;
        $UserReview->type = $request->type;
        $UserReview->save();

        $output['status'] = true;
        $output['rating'] = $request->rating;
        $output['title'] = $request->title;
        $output['description'] = $request->description;
        $output['message'] = 'Review Add Successfull';
        return $output;
    }

    public function review_list(Request $request)
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

        $get_list_arr = [];
        $language = $request->language;
        $setLimit = 10;
        $offset = $request->offset;
        $slug = '';
        $limit = $offset * $setLimit;
        if ($request->slug) {
            $slug = $request->slug;
        }

        //Products
        $product_id = 0;
        $get_product_id = Product::where('slug', $slug)
            ->where('status', 'Active')
            ->where('is_delete', 0)
            ->first();
        if ($get_product_id) {
            $product_id = $get_product_id->id;
        }
        $ReviewCount = UserReview::where('status', 'Active');
        $get_review_details = UserReview::where('status', 'Active');
        if ($slug != '') {
            $get_review_details = $get_review_details->where('product_id', $product_id);
            $ReviewCount = $ReviewCount->where('product_id', $product_id);
        }
        $ReviewCount = $ReviewCount
            ->orderBy('id', 'DESC')
            ->get()
            ->count();
        $get_review_details = $get_review_details
            ->offset($limit)
            ->orderBy('id', 'desc')
            ->limit($setLimit)
            ->get();

        $get_list_product_arr = [];
        if (!$get_review_details->isEmpty()) {
            foreach ($get_review_details as $key => $get_detail) {
                $product_id = $get_detail['product_id'];
                $get_product = Product::where(['id' => $get_detail['product_id'], 'status' => 'Active', 'is_delete' => 0])->first();
                if ($get_product) {
                    $get_details_arr = [];
                    // $get_details_arr['product_id'] = $get_detail['product_id'];
                    $get_details_arr['id'] = encrypt($get_detail['id']);
                    $get_details_arr['rating'] = $get_detail['rating'];
                    $get_details_arr['type'] = $get_detail['type'];
                    $get_details_arr['title'] = $get_detail['title'];
                    $get_details_arr['description'] = $get_detail['description'];

                    $get_details_arr['user_id'] = $get_detail['user_id'];

                    $get_customers_details = User::where(['id' => $get_detail['user_id']])->first();
                    if ($get_customers_details) {
                        $get_details_arr['name'] = $get_customers_details['name'];
                        $get_details_arr['email'] = $get_customers_details['email'];
                        $get_details_arr['phone_number'] = $get_customers_details['phone_number'];
                        $get_details_arr['city_id'] = $get_customers_details['city'];
                        $get_details_arr['country_id'] = $get_customers_details['country'];
                        $get_details_arr['image'] = $get_customers_details['image'] != '' ? url('uploads/user_image', $get_customers_details['image']) : asset('uploads/placeholder/placeholder.png');

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

                        $get_details_arr['address'] = $get_customers_details['address'];
                    }

                    $get_details_arr['slug'] = $get_product['slug'];
                    $get_details_arr['link'] = '';
                    if ($get_product['product_type'] == 'excursion') {
                        $get_details_arr['link'] = '/activities-detail/' . $get_product['slug'];
                    } elseif ($get_product['product_type'] == 'yacht') {
                        $get_details_arr['link'] = '/yacht-charts-details/' . $get_product['slug'];
                    } elseif ($get_product['product_type'] == 'lodge') {
                        $get_details_arr['link'] = '/lodge-detail/' . $get_product['slug'];
                    } elseif ($get_product['product_type'] == 'limousine') {
                        $get_details_arr['link'] = '/limousine-detail/' . $get_product['slug'];
                    }

                    $productLang = ProductLanguage::where(['product_id' => $get_detail['product_id'], 'language_id' => $language])->first();
                    $get_details_arr['  '] = '';
                    $get_details_arr['product_description'] = '';
                    if ($productLang) {
                        $get_details_arr['product_title'] = $productLang->description;
                        $get_details_arr['product_description'] = $productLang->main_description;
                    }
                    $get_details_arr['date'] = date('Y-m-d', strtotime($get_detail['created_at']));
                    $get_list_product_arr[] = $get_details_arr;
                }
            }
        }

        $get_list_arr = array_merge($get_list_product_arr);
        if (count($get_list_arr) > 0) {
            $output['status'] = true;
            $output['data'] = $get_list_arr;
            $output['page_count'] = ceil($ReviewCount / $setLimit);
            $output['message'] = 'Review List';
        }
        return json_encode($output);
    }


    //NewsLatter Subscribe
    public function newsLatterSubscribe(Request $request){
        $output = [];
        $output['status'] = false;
        $validation = Validator::make($request->all(), [
            // 'language'    => 'required',
            'email'       => 'required',
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

        $getNewsLatterSubscribe = NewsLatterSubscribe::where('email',$request->email)->first();
        if(!$getNewsLatterSubscribe){
            $NewsLatterSubscribe = new NewsLatterSubscribe();
            $NewsLatterSubscribe->email = $request->email;
            $NewsLatterSubscribe->save();
            $output['status'] = true;
            $output['message'] = 'Subscribe Successfull';
        }else{
            $output['message'] = 'Alerady Subscribe Successfull';
        }
        return $output;
    }
}
