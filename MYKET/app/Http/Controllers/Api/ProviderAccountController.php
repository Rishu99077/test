<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\ProductLocation;
use App\Models\ProductDescription;
use App\Models\ProductHighlight;
use App\Models\ProductInclusion;
use App\Models\ProductRestriction;
use App\Models\ProductInformation;
use App\Models\Categories;
use App\Models\Wishlist;
use App\Models\ProductAboutActivity;
use App\Models\ProductOption;
use App\Models\ProductOptionPricing;
use App\Models\ProductOptionPricingDetails;
use App\Models\ProductOptionAddOnTiers;
use App\Models\ProductOptionPricingTiers;
use App\Models\ProductOptionAvailability;
use App\Models\ProductOptionDiscount;
use App\Models\ProductTransportation;
use App\Models\ProductOptionAddOn;
use App\Models\Countries;
use App\Models\User;
use App\Models\Orders;
use App\Models\States;
use App\Models\Cities;
use App\Models\RecommendedThings;
use App\Models\RecommendedThingsDescription;
use App\Models\ProductOptionAvailabilityDescription;
use App\Models\ProductOptionPricingDescription;
use App\Models\ProductFoodDrink;
use App\Models\PartnerAdminCommission;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use DB;

class ProviderAccountController extends Controller
{
    // Get Product List
    public function my_tours(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language' => 'required',
            'currency' => 'required',
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
        $user_id  = $request->user_id;
        $setLimit     = 9;
        $offset       = $request->offset;
        $limit        = $offset * $setLimit;
        $data  = [];



        // Categaory Array
        $get_category = Categories::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
            ->get();

        $listing_data = [];
        if (!empty($get_category)) {
            foreach ($get_category as $key => $value) {
                $row  = getLanguageData('category_descriptions', $language_id, $value['id'], 'category_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $listing_data[] = $row;
            }
        }


        $where = '';
        $where = ['products.is_delete' => null];



        $Product  = Product::where($where)->where('slug', '!=', '')->where(['partner_id' => $user_id, 'added_by' => 'partner'])
            ->select('products.*');




        if (isset($request->is_filter) && $request->is_filter == 1) {

            if (isset($request->is_status)) {
                $Product = $Product->where('status', $request->is_status);
            }

            if (isset($request->is_approved)) {
                $Product = $Product->where('is_approved', $request->is_approved);
            }


            // Category Filter
            $category_filter = $request->category_filter;
            if (isset($category_filter)) {
                $Product = $Product->where(function ($data) use ($category_filter) {
                    foreach ($category_filter  as $CF) {
                        $data->orWhere('category', $CF);
                    }
                });
            }
        }




        $ProductCount = count(($Product->get()));

        $Product = $Product->orderBy('products.id', 'DESC')
            ->offset($limit)
            ->limit($setLimit)
            ->get();



        $data['products'] =  getProductArr($Product, $language_id, $user_id);
        $data['categories'] = $listing_data;



        $output['page_count']   = ceil($ProductCount / $setLimit);
        $output['ProductCount'] = $ProductCount;
        $output['data']         = $data;
        $output['status']       = true;
        $output['status_code']  = 200;
        $output['message']      = "Data Fetch Successfully";
        return json_encode($output);
    }

    // Partner Upcoming Orders
    public function partner_upcoming_orders(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language'   => 'required',
            'currency'   => 'required',
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
        $user_id     = $request->user_id;
        $setLimit     = 9;
        $offset       = $request->offset;
        $limit        = $offset * $setLimit;

        $Orders = Orders::orderBy('id', 'desc');

        if (isset($request->is_filter) && $request->is_filter == 1) {


            if (isset($request->customer_name)) {
                $Orders = $Orders->where(DB::raw('concat(`first_name`," ", `last_name`)'), 'like', '%' .  $request->customer_name . '%');
            }

            if (isset($request->order_id)) {
                $Orders = $Orders->where('order_id', 'like', '%' . $request->order_id . '%');
            }

            if (isset($request->status)) {
                $Orders = $Orders->where('status', $request->status);
            }

            if (isset($request->search_by)) {
                if ($request->search_by == "Date") {

                    if (isset($request->from_date)) {
                        $formdate = '';

                        if (isset($request->from_date)) {
                            $formdate = $request->from_date . " 00:00:00";
                        }

                        if ($formdate != '') {
                            $Orders->whereDate('created_at', '>=', $formdate);
                        }
                    }

                    if (isset($request->to_date)) {

                        $todate = '';

                        if (isset($request->to_date)) {
                            $todate = $request->to_date . " 23:59:59";
                        }
                        if ($todate != '') {

                            $Orders->whereDate('created_at', '<=', $todate);
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
                            $Orders = $Orders->whereMonth('created_at', $month);
                            $Orders = $Orders->whereYear('created_at', $year);
                        }
                    }
                }
            }
        }

        $Orders = $Orders->get();

        $OrderData = [];
        $Currentdate = strtotime(date('m/d/Y'));

        foreach ($Orders as $Okey => $O) {
            $totalAmount = 0;
            $total_tax = 0;
            $coupon_amount = 0;
            $order_json = json_decode($O['order_json']);


            // $OLDDATE = '';
            if ($order_json) {
                foreach ($order_json->detail as $OJkey => $OJ) {

                    if (isset($OJ->added_by)) {
                        $date = strtotime($OJ->date);



                        if ($date > $Currentdate) {
                            if ($OJ->added_by == "partner") {
                                $partner_id = isset($OJ->partner_id) ? $OJ->partner_id : 0;
                                if ($user_id == $partner_id) {
                                    $totalAmount  += $OJ->totalAmount;
                                    $total_tax  += $OJ->total_tax;
                                    $coupon_amount  += isset($OJ->coupon_amount) ? $OJ->coupon_amount : 0;

                                    $OrderData[$O['id']]['id']         = encrypt($O['id']);
                                    $OrderData[$O['id']]['order_id']   = $O['order_id'];
                                    $OrderData[$O['id']]['order_date'] = date("Y M,d", strtotime($O['created_at']));

                                    $OrderData[$O['id']]['amount']      = get_price_front("", "", "", "", round($totalAmount + $total_tax - $coupon_amount, 2));
                                    $OrderData[$O['id']]['status']      = $O['status'];
                                    $OrderData[$O['id']]['name']        = $O['first_name'] . " " . $O['last_name'];
                                    $OrderData[$O['id']]['address']     = $O['address'] . '(' . $O['zipcode'] . ')';
                                    $OrderData[$O['id']]['order_json'][] = $OJ;

                                    // if ($OLDDATE > $date) {
                                    //     $OLDDATE = $date;
                                    // }

                                    // if ($OLDDATE < $date) {

                                    //     $OLDDATE = $date;
                                    // }
                                    // $OrderData[$O['id']]['date'] =  Carbon::createFromTimestamp($OLDDATE)->format('m/d/Y');


                                    $OrderData[$O['id']]['totalAmount'] = get_price_front("", "", "", "", round($totalAmount + $total_tax - $coupon_amount, 2));
                                }
                            }
                        }
                    }
                    // $OrderData[$O['id']] = $totalAmount;
                }
            }
        }

        // $DateNew = array_column($OrderData, 'date');
        // array_multisort($DateNew, SORT_ASC, $OrderData);





        if (count($OrderData) > 0) {
            $output['status']      = true;
        }
        $OrderDataDetails = array_slice($OrderData, $limit, $setLimit);

        $output['page_count'] = ceil(count($OrderData) / $setLimit);
        $output['data']        = $OrderDataDetails;

        $output['status_code'] = 200;
        $output['message']     = "Order Detail Fetched Successfully";
        return json_encode($output);
    }


    // Delete Partner Toure
    public function delete_partner_tour(Request $request)
    {

        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language' => 'required',
            'currency' => 'required',
            'tourId'   => 'required',
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
        $user_id  = $request->user_id;
        $id  = $request->tourId;
        $data = "";
        $get_product =  Product::where(['id' => $id, 'partner_id' => $user_id, 'added_by' => 'partner'])->whereNull('is_delete')->first();
        if ($get_product) {
            $get_product->is_delete = 1;
            $get_product->save();
            ProductDescription::where(['product_id' => $id])->delete();
            ProductLocation::where(['product_id' => $id])->delete();
            ProductInclusion::where(['product_id' => $id])->delete();
            ProductHighlight::where(['product_id' => $id])->delete();
            // ProductHighlightDescription::where(['product_id' => $id])->delete();
            ProductRestriction::where(['product_id' => $id])->delete();
            ProductAboutActivity::where(['product_id' => $id])->delete();
            // ProductAboutActivityDescription::where(['product_id' => $id])->delete();
            ProductTransportation::where(['product_id' => $id])->delete();
            ProductFoodDrink::where(['product_id' => $id])->delete();

            ProductInformation::where(['product_id' => $id])->delete();
            // ProductInformationDescription::where(['product_id' => $id])->delete();
            ProductImages::where(['product_id' => $id])->delete();
            ProductOption::where(['product_id' => $id])->delete();
            ProductOptionPricing::where(['product_id' => $id])->delete();
            ProductOptionPricingDetails::where(['product_id' => $id])->delete();
            ProductOptionPricingTiers::where(['product_id' => $id])->delete();
            ProductOptionAddOn::where(['product_id' => $id])->delete();
            ProductOptionAddOnTiers::where(['product_id' => $id])->delete();
            ProductOptionPricingDescription::where(['product_id' => $id])->delete();
            ProductOptionAvailability::where(['product_id' => $id])->delete();
            ProductOptionAvailabilityDescription::where(['product_id' => $id])->delete();
            ProductOptionDiscount::where(['product_id' => $id])->delete();
            $output['status']  = 'success';
            $output['message'] = 'Delete Successfully';
        }
        $output['data']          = $data;
        $output['status']        = true;
        $output['status_code']   = 200;

        return json_encode($output);
    }

    // Add Provider Company Details

    public function company_details(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'User Not Found';

        $req_fields = array();


        $req_fields['currency']                  = "required";
        $req_fields['language']                  = "required";
        $req_fields['partner_title']             = "required";
        $req_fields['partner_short_description'] = "required";
        $req_fields['company_name']              = "required";
        $req_fields['company_address']           = "required";
        $req_fields['company_email']             = "required";
        $req_fields['company_description']       = "required";
        $req_fields['company_banner_image']      = "required";
        $req_fields['company_logo_image']        = "required";


        $errormsg = [
            "currency"                  => translate("Currency"),
            "language"                  => translate("Language"),
            "partner_title"             => translate("Title"),
            "partner_short_description" => translate("Short Description"),
            "phone_number"              => translate("Phone number"),
            "company_name"              => translate("Company Name"),
            "company_address"           => translate("Company Address"),
            "company_email"             => translate("Company Email"),
            "company_description"       => translate("Description"),
            "company_banner_image"      => translate("Banner Image"),
            "company_logo_image"        => translate("Logo Image"),

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
            ->where('user_type', 'Partner')
            ->where('is_verified', 1)
            ->where('is_delete', null)
            ->first();

        if ($User) {

            if ($request->hasFile('company_banner_image')) {
                $random_no = uniqid();
                $img = $request->file('company_banner_image');
                $ext = $img->getClientOriginalExtension();
                $new_name = $random_no . '.' . $ext;
                $destinationPath = public_path('uploads/provider');
                $img->move($destinationPath, $new_name);
                $User->company_banner_image = $new_name;
            }

            if ($request->hasFile('company_logo_image')) {
                $random_no = uniqid();
                $img = $request->file('company_logo_image');
                $ext = $img->getClientOriginalExtension();
                $new_name = $random_no . '.' . $ext;
                $destinationPath = public_path('uploads/provider');
                $img->move($destinationPath, $new_name);
                $User->company_logo_image = $new_name;
            }

            $User->slug                      = createSlug('users', $request->company_name, $user_id);
            $User->partner_title             = $request->partner_title == "" ? "" : $request->partner_title;
            $User->partner_short_description = $request->partner_short_description == "" ? "" : $request->partner_short_description;
            $User->company_name              = $request->company_name == "" ? "" : $request->company_name;
            $User->company_address           = $request->company_address;
            $User->company_email             = $request->company_email;
            $User->company_phone             = $request->company_phone;
            $User->company_information       = $request->company_information == "" ? "" : $request->company_information;
            $User->company_description       = $request->company_description == "" ? "" : $request->company_description;

            $User->save();
            $output['status'] = true;
            $output['message'] = 'Account Update Successfully';
        }
        return json_encode($output);
    }

    // Get Company Details

    public function get_company_details(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'Details Not Found';

        $req_fields = array();


        $req_fields['currency']     = "required";
        $req_fields['language']     = "required";
        // $req_fields['slug'] = "required";

        $errormsg = [
            "currency"     => translate("Currency"),
            "language"     => translate("Language"),
            "slug" => translate("Company ID"),

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
        $slug = $request->slug;

        $User =  User::where(['slug' => $slug])->first();
        $data = [];
        if ($User) {
            $data['banner']              = $User->company_banner_image != '' ? url('uploads/provider', $User->company_banner_image) : asset('public/uploads/img_avatar.png');
            $data['logo']                = $User->company_logo_image != '' ? url('uploads/provider', $User->company_logo_image) : asset('public/uploads/img_avatar.png');
            $data['title']               = $User->partner_title   != '' ? $User->partner_title : $User->company_name;
            $data['short_description']   = $User->partner_short_description != '' ? $User->partner_short_description : '';
            $data['company_name']        = $User->company_name;
            $data['company_email']       = $User->company_email;
            $data['company_description'] = $User->company_description;
            $data['company_information'] = $User->company_information;
            $data['company_address']     = $User->company_address;
            $data['company_phone']       = $User->company_phone;
            $data['slug']                = $User->slug;
            $data['rating_count']                = 0;
            $data['total_review']        = $total_review =  Product::where(['partner_id' => $User->id, 'products.status' => 'Active', 'is_approved' => 'Approved', 'added_by' => 'partner', 'products.is_delete' => null, 'user_review.status' => 'Active'])
                ->join('user_review', 'user_review.product_id', 'products.id')
                ->count();

            $review_sum = Product::where(['partner_id' => $User->id, 'products.status' => 'Active', 'is_approved' => 'Approved', 'added_by' => 'partner', 'products.is_delete' => null, 'user_review.status' => 'Active'])
                ->join('user_review', 'user_review.product_id', 'products.id')
                ->sum('user_review.rating');


            if ($review_sum > 0 && $total_review > 0) {
                $total_review = $review_sum / $total_review;
                $data['rating_count']  = substr($total_review, 0, 3);
            }

            $output['status'] = true;
            $output['data'] = $data;
            $output['message'] = 'Company Details';
        }
        return json_encode($output);
    }


    // Partner Order List
    public function partner_order_list(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language'   => 'required',
            'currency'   => 'required',
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
        $user_id     = $request->user_id;
        $setLimit     = 10;
        $offset       = $request->offset;
        $limit        = $offset * $setLimit;

        $Orders = Orders::orderBy('id', 'desc');

        if (isset($request->is_filter) && $request->is_filter == 1) {

            if (isset($request->customer_name)) {
                $Orders = $Orders->where(DB::raw('concat(`first_name`," ", `last_name`)'), 'like', '%' .  $request->customer_name . '%');
            }

            if (isset($request->order_id)) {
                $Orders = $Orders->where('order_id', 'like', '%' . $request->order_id . '%');
            }

            if (isset($request->status)) {
                $Orders = $Orders->where('status', $request->status);
            }

            if (isset($request->search_by)) {
                if ($request->search_by == "Date") {

                    if (isset($request->from_date)) {
                        $formdate = '';

                        if (isset($request->from_date)) {
                            $formdate = $request->from_date . " 00:00:00";
                        }

                        if ($formdate != '') {
                            $Orders->whereDate('created_at', '>=', $formdate);
                        }
                    }

                    if (isset($request->to_date)) {

                        $todate = '';

                        if (isset($request->to_date)) {
                            $todate = $request->to_date . " 23:59:59";
                        }
                        if ($todate != '') {

                            $Orders->whereDate('created_at', '<=', $todate);
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
                            $Orders = $Orders->whereMonth('created_at', $month);
                            $Orders = $Orders->whereYear('created_at', $year);
                        }
                    }
                }
            }
        }

        $Orders = $Orders->get();

        $OrderData = [];
        foreach ($Orders as $Okey => $O) {
            $totalAmount = 0;
            $total_tax = 0;
            $coupon_amount = 0;
            $order_json = json_decode($O['order_json']);
            if ($order_json) {
                foreach ($order_json->detail as $OJkey => $OJ) {

                    if (isset($OJ->added_by)) {
                        if ($OJ->added_by == "partner") {
                            $partner_id = isset($OJ->partner_id) ? $OJ->partner_id : 0;
                            if ($user_id == $partner_id) {
                                $totalAmount  += $OJ->totalAmount;
                                $total_tax  += $OJ->total_tax;
                                $coupon_amount  += isset($OJ->coupon_amount) ? $OJ->coupon_amount : 0;

                                $OrderData[$O['id']]['id']       = encrypt($O['id']);
                                $OrderData[$O['id']]['order_id'] = $O['order_id'];
                                $OrderData[$O['id']]['order_date'] = date("Y M,d", strtotime($O['created_at']));
                                $OrderData[$O['id']]['amount']   = get_price_front("", "", "", "", round($totalAmount + $total_tax - $coupon_amount, 2));
                                $OrderData[$O['id']]['status']   = $O['status'];
                                $OrderData[$O['id']]['name']        = $O['first_name'] . " " . $O['last_name'];
                                $OrderData[$O['id']]['address']  = $O['address'] . '(' . $O['zipcode'] . ')';
                                $OrderData[$O['id']]['order_json'][] = $OJ;
                                $OrderData[$O['id']]['totalAmount'] = get_price_front("", "", "", "", round($totalAmount + $total_tax - $coupon_amount, 2));
                            }
                        }
                    }
                    // $OrderData[$O['id']] = $totalAmount;
                }
            }
        }

        if (count($OrderData) > 0) {
            $output['status']      = true;
        }
        $OrderDataDetails = array_slice($OrderData, $limit, $setLimit);

        $output['page_count'] = ceil(count($OrderData) / $setLimit);
        $output['data']        = $OrderDataDetails;

        $output['status_code'] = 200;
        $output['message']     = "Order Detail Fetched Successfully";

        // return json_encode($output);
        return response()->json($output);
    }

    // Partner Order Details
    public function partner_order_details(Request $request)
    {

        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language' => 'required',
            'currency' => 'required',
            'order_id' => 'required',
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


        $user_id     = $request->user_id;
        $order_id     =  checkDecrypt($request->order_id);

        $Orders = Orders::where(['id' => $order_id])->first();
        $orderData = [];
        $cart_tax_fee               = [];
        if ($Orders) {
            $orderData['id']           = encrypt($Orders->id);
            $orderData['order_id']     = $Orders->order_id;
            $orderData['first_name']   = $Orders->first_name;
            $orderData['email']        = $Orders->email;
            $orderData['phone']        = $Orders->phone;
            $orderData['zipcode']      = $Orders->zipcode;
            $orderData['address']      = $Orders->address;
            $orderData['total_amount'] = $Orders->total_amount;
            $orderData['status']       = $Orders->status;
            $orderData['order_date']   = date("d,M Y", strtotime($Orders->created_at));
            $orderData['country']      = getDataFromDB('countries', ['id' => $Orders->country], 'row', 'name');
            $orderData['state']        = getDataFromDB('states', ['id' => $Orders->state], 'row', 'name');
            $orderData['city']         = getDataFromDB('cities', ['id' => $Orders->city], 'row', 'name');
            $orderData['order_json']   = [];
            $order_json =  json_decode($Orders->order_json);

            $totalAmount = 0;
            $totalTax = 0;
            $coupon_amount = 0;

            if ($order_json) {
                foreach ($order_json->detail as $OJkey => $OJ) {

                    if (isset($OJ->added_by)) {
                        if ($OJ->added_by == "partner") {
                            $partner_id = isset($OJ->partner_id) ? $OJ->partner_id : 0;
                            if ($user_id == $partner_id) {
                                $totalAmount  += $OJ->totalAmount;
                                $newTax = $OJ->total_tax;
                                $coupon_amount += isset($OJ->coupon_amount) ? $OJ->coupon_amount : 0;


                                $containsCurrency = Str::contains($OJ->total_tax, "$");
                                if ($containsCurrency) {
                                    $newTax = trim($OJ->total_tax, "$");
                                }
                                $totalTax += (float)$newTax;

                                $detailsArr[] = $OJ;
                                $orderData['order_json'] = $detailsArr;
                            }
                        }
                    }
                }
            }

            $cart_tax_fee['amount'] =  get_price_front('', '', '', '', round($totalAmount, 2));
            $cart_tax_fee['title'] =  'Sub Total';
            $orderData['cart_tax_fee'][] = $cart_tax_fee;

            $cart_tax_fee['amount'] =  get_price_front('', '', '', '', round($totalTax, 2));
            $cart_tax_fee['title'] =  'Total Tax';
            $orderData['cart_tax_fee'][] = $cart_tax_fee;

            if ($coupon_amount > 0) {
                $cart_tax_fee['amount'] =  get_price_front('', '', '', '', round($coupon_amount, 2));
                $cart_tax_fee['title'] =  'Total Discount';
                $orderData['cart_tax_fee'][] = $cart_tax_fee;
            }

            $cart_tax_fee['amount'] =  get_price_front('', '', '', '', round($totalTax + $totalAmount - $coupon_amount, 2));
            $cart_tax_fee['title'] =  'Total';
            $orderData['cart_tax_fee'][] = $cart_tax_fee;





            $output['data']        = $orderData;
            $output['status']      = true;
            $output['status_code'] = 200;
            $output['message']     = "Order Detail Fetched Successfully";
        }
        return json_encode($output);
    }

    // Reomve Product Option 
    public function remove_product_option(Request $request)
    {

        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language' => 'required',
            'optionId' => 'required',
            'tourId'   => 'required',
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
        $user_id     = $request->user_id;
        $tourId     = $request->tourId;
        $optionId     = $request->optionId;



        $ProductOption = ProductOption::where(['product_id' => $tourId, 'id' => $optionId])->first();
        if ($ProductOption) {
            $ProductOption->delete();
            $output['status']      = true;
        }

        $output['status_code'] = 200;
        $output['message']     = "Option Delete Successfully";
        return json_encode($output);
    }

    // Reomve Product Option  Pricing
    public function remove_product_option_pricing(Request $request)
    {

        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language'  => 'required',
            'optionId'  => 'required',
            'pricingId' => 'required',
            'tourId'    => 'required',
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
        $user_id   = $request->user_id;
        $tourId    = $request->tourId;
        $optionId  = $request->optionId;
        $pricingId = $request->pricingId;



        $ProductOptionPricing = ProductOptionPricing::where(['product_id' => $tourId, 'option_id' => $optionId, 'id' => $pricingId])->first();
        if ($ProductOptionPricing) {
            $ProductOptionPricing->delete();

            ProductOptionPricingDetails::where(['product_id' => $tourId, 'option_id' => $optionId, 'pricing_id' => $pricingId])->delete();
            ProductOptionPricingTiers::where(['product_id' => $tourId, 'option_id' => $optionId, 'pricing_id' => $pricingId])->delete();
            $output['status']      = true;
        }

        $output['status_code'] = 200;
        $output['message']     = "Option Delete Successfully";
        return json_encode($output);
    }


    // Provider Dashboard
    public function provider_dashboard(Request $request)
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
        $data         = [];

        $Dashboardmonth = "";
        $Dashboardyear = "";
        if (isset($request->month)) {

            $Dashboardmonth = date("m", strtotime($request->month));
            $Dashboardyear = date("Y", strtotime($request->month));
        }

        $get_product  = Product::where('slug', '!=', '')->where(['partner_id' => $user_id, 'added_by' => 'partner', 'is_delete' => null])->get();
        $ProductCount = count($get_product);



        // Upcoming Orders
        $Currentdate = strtotime(date('m/d/Y'));
        $Orders = Orders::orderBy('id', 'desc');

        if ($Dashboardmonth != "") {
            $Orders = $Orders->whereMonth('created_at', $Dashboardmonth);
            $Orders = $Orders->whereYear('created_at', $Dashboardyear);
        }

        $Orders =  $Orders->get();


        $OrderList = [];
        $get_orders = [];
        $totalEarnings = 0;

        $data['orders'] = array();
        foreach ($Orders as $Okey => $O) {
            $order_json = json_decode($O['order_json']);
            // dd($order_json);
            if ($order_json) {
                foreach ($order_json->detail as $OJkey => $OJ) {
                    $date = strtotime($OJ->date);
                    if (isset($OJ->added_by)) {
                        if ($OJ->added_by == "partner") {
                            $partner_id = isset($OJ->partner_id) ? $OJ->partner_id : 0;
                            if ($user_id == $partner_id) {
                                if ($date >= $Currentdate) {
                                    $OrderList[] = $O['id'];
                                }
                                $get_orders[] = $O['id'];
                                if ($O['status'] == 'Success') {
                                    $totalEarnings += $OJ->totalAmount + $OJ->total_tax - (isset($OJ->coupon_amount) ? $OJ->coupon_amount : 0);
                                }
                            }
                        }
                    }
                }
            }
        }
        $OrderData = [];
        $order_list = array_unique($OrderList);
        $customer_order_list = array_unique($get_orders);
        $UpcomingOrdersCount = count($order_list);
        $OrdersCount = count($customer_order_list);





        $get_orders = Orders::orderBy('id', 'desc')->get();

        if (count($get_orders) > 0) {
            foreach ($get_orders as $key => $value) {



                $totalAmount = 0;
                $total_tax = 0;
                $coupon_amount = 0;
                $order_json = json_decode($value['order_json']);

                if ($order_json) {
                    foreach ($order_json->detail as $OJkey => $OJ) {
                        if (isset($OJ->added_by)) {
                            if ($OJ->added_by == "partner") {
                                $partner_id = isset($OJ->partner_id) ? $OJ->partner_id : 0;
                                if ($user_id == $partner_id) {

                                    $orderData = array();
                                    $orderData['id']           = encrypt($value->id);
                                    $orderData['order_id']     = $value->order_id;
                                    $orderData['first_name']   = $value->first_name;
                                    $orderData['email']        = $value->email;
                                    $orderData['phone']        = $value->phone;
                                    $orderData['zipcode']      = $value->zipcode;
                                    $orderData['address']      = $value->address;
                                    $orderData['total_amount'] = $value->total_amount;
                                    if (count($data['orders']) <= 2) {
                                        $data['orders'][] = $orderData;
                                    }
                                }
                            }
                        }
                        // $OrderData[$O['id']] = $totalAmount;
                    }
                }
            }
        }

        $data['header_data'] = [];

        // Upcoming Booking
        $upcoming_booking_arr = array();
        $upcoming_booking_arr['title'] = 'Upcoming Orders';
        $upcoming_booking_arr['count'] =  $UpcomingOrdersCount;
        $upcoming_booking_arr['link']  =  '/supplier-upcoming';
        $upcoming_booking_arr['image'] =  url('/public/uploads/provider/dashbord_img1.png');
        $data['header_data'][] = $upcoming_booking_arr;

        // Total Products
        $total_products_arr = array();
        $total_products_arr['title'] = 'Total Products';
        $total_products_arr['count'] =  $ProductCount;
        $total_products_arr['link']  =  '/my-tours';
        $total_products_arr['image'] =  url('/public/uploads/provider/dashbord_img2.png');
        $data['header_data'][] = $total_products_arr;

        // Total Orders
        $total_orders_arr = array();
        $total_orders_arr['title'] = 'Total Orders';
        $total_orders_arr['count'] =  $OrdersCount;
        $total_orders_arr['link']  =  '/supplier-orders';
        $total_orders_arr['image'] =  url('/public/uploads/provider/dashbord_img3.png');
        $data['header_data'][] = $total_orders_arr;


        // Total Earnings
        $total_earning_arr = array();
        $total_earning_arr['title'] = 'Total Earnings';
        $total_earning_arr['count'] =   get_price_front("", "", "", "", $totalEarnings);
        $total_earning_arr['link']  =  'supplier-transaction-history';
        $total_earning_arr['image'] =  url('/public/uploads/provider/dashbord_img4.png');
        $data['header_data'][] = $total_earning_arr;


        // line chart






        $Months = array();
        $last_month = 3;
        if (isset($request->last_month)) {
            $last_month = $request->last_month;
        }

        for ($i = 0; $i <= $last_month; $i++) {
            $Months = Carbon::today()->subMonth($i)->monthName;
            $month = Carbon::today()->subMonth($i)->format('m');

            $get_orders =   Orders::whereMonth('created_at', $month)->where(['user_id' => $user_id, 'status' => 'Success'])
                ->orderby('id', 'asc')
                ->get();


            $Bookingcount = 0;
            foreach ($get_orders as $Okey => $O) {
                $order_json = json_decode($O['order_json']);
                // dd($order_json);
                if ($order_json) {
                    foreach ($order_json->detail as $OJkey => $OJ) {
                        $date = strtotime($OJ->date);
                        if (isset($OJ->added_by)) {
                            if ($OJ->added_by == "partner") {
                                $partner_id = isset($OJ->partner_id) ? $OJ->partner_id : 0;
                                if ($user_id == $partner_id) {
                                    if ($O['status'] == 'Success') {
                                        $Bookingcount++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $order['uData'][] = $Bookingcount;
            $order['xLabels'][] = $Months;



            $OrderLine = $order;
        }

        $data['line_chart'] = $OrderLine;

        // Donut Chart

        $data['donut_chart'] = [];


        $donut_orders = Orders::orderBy('id', 'desc')->whereMonth('created_at', Carbon::now())->where(['user_id' => $user_id])->get();
        $total_orders_arr = [];
        $complete_orders_arr = [];
        $fail_orders_arr = [];
        foreach ($donut_orders as $Okey => $O) {
            $order_json = json_decode($O['order_json']);
            // dd($order_json);
            if ($order_json) {
                foreach ($order_json->detail as $OJkey => $OJ) {
                    $date = strtotime($OJ->date);
                    if (isset($OJ->added_by)) {
                        if ($OJ->added_by == "partner") {
                            $partner_id = isset($OJ->partner_id) ? $OJ->partner_id : 0;
                            if ($user_id == $partner_id) {
                                $total_orders_arr[] = $O['id'];
                                if ($O['status'] == 'Success') {
                                    $complete_orders_arr[] = $O['id'];
                                }
                                if ($O['status'] == 'Failed') {
                                    $fail_orders_arr[] = $O['id'];
                                }
                            }
                        }
                    }
                }
            }
        }

        $total_orders = array_unique($total_orders_arr);
        $complete_orders = array_unique($complete_orders_arr);
        $fail_orders = array_unique($fail_orders_arr);


        $data['donut_chart']['label'] = ' ';
        $data['donut_chart']['data'] = [count($total_orders), count($complete_orders), count($fail_orders)];
        $data['donut_chart']['backgroundColor'] = ["#FC5301", "#02AB13", "#EB1313"];
        $data['donut_chart']['borderColor'] = ["#ECECEC", "#ECECEC", "#ECECEC"];
        $data['donut_chart']['borderWidth'] =  10;

        $data['donut_chart_data'] = ['Total Orders', ' Success Orders', 'Failed Orders'];


        $output['data']         = $data;
        $output['status']       = true;
        $output['status_code']  = 200;
        $output['message']      = "Data Fetch Successfully";
        return json_encode($output);
    }


    // Partner Commission
    public function partner_commission(Request $request)
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
        $data = [];


        $setLimit     = 10;
        $offset       = $request->offset;
        $limit        = $offset * $setLimit;

        $PartnerAdminCommission = PartnerAdminCommission::where('partner_id', $request->user_id)
            ->select('partner_admin_commission.*')
            ->leftJoin('orders', 'partner_admin_commission.order_id', '=', 'orders.id')
            ->orderBy('partner_admin_commission.id', 'desc');


        if (isset($request->is_filter) && $request->is_filter == 1) {



            if (isset($request->order_id)) {
                $PartnerAdminCommission = $PartnerAdminCommission->where('orders.order_id', 'like', '%' . $request->order_id . '%');
            }


            if (isset($request->search_by)) {
                if ($request->search_by == "Date") {

                    if (isset($request->from_date)) {
                        $formdate = '';

                        if (isset($request->from_date)) {
                            $formdate = $request->from_date . " 00:00:00";
                        }

                        if ($formdate != '') {
                            $PartnerAdminCommission->whereDate('partner_admin_commission.created_at', '>=', $formdate);
                        }
                    }

                    if (isset($request->to_date)) {

                        $todate = '';

                        if (isset($request->to_date)) {
                            $todate = $request->to_date . " 23:59:59";
                        }
                        if ($todate != '') {

                            $PartnerAdminCommission->whereDate('partner_admin_commission.created_at', '<=', $todate);
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
                            $PartnerAdminCommission = $PartnerAdminCommission->whereMonth('partner_admin_commission.created_at', $month);
                            $PartnerAdminCommission = $PartnerAdminCommission->whereYear('partner_admin_commission.created_at', $year);
                        }
                    }
                }
            }
        }


        $PartnerAdminCommission =  $PartnerAdminCommission->get();
        $PartnerAdminCommissionArr = [];

        foreach ($PartnerAdminCommission as $key => $PAC) {

            $row = [];

            $Order = Orders::find($PAC['order_id']);

            if ($Order) {
                $row                           = $PAC;
                $row['order_id']               = $Order->order_id;
                $row['status']                 = $Order->status;
                $row['order_encrypt']          = encrypt($Order->id);
                $product_json                  = json_decode($PAC['product_json']);
                $row['product_total']          = get_price_front("", "", "", "", $PAC['product_total']);
                $row['admin_total_commission'] = get_price_front("", "", "", "", $PAC['admin_total_commission']);
                $row['partner_total']          = get_price_front("", "", "", "", $PAC['partner_total']);
                $row['order_date']             = date("Y M,d", strtotime($Order->created_at));
                $jsonArr                       = [];
                foreach ($product_json as  $PJ) {
                    $product_json_arr = [];
                    $product_json_arr = (array)$PJ;

                    $product_json_arr['product_amount'] = get_price_front("", "", "", "", $PJ->product_amount);
                    $product_json_arr['admin_commission_amount'] = get_price_front("", "", "", "", $PJ->admin_commission_amount);
                    $product_json_arr['partner_amount'] = get_price_front("", "", "", "", $PJ->partner_amount);
                    $jsonArr[] = $product_json_arr;
                }
                $row['product_json'] = $jsonArr;

                $PartnerAdminCommissionArr[] = $row;
            }
        }

        $data = array_slice($PartnerAdminCommissionArr, $limit, $setLimit);

        $output['data']         = $data;
        $output['page_count'] = ceil(count($PartnerAdminCommissionArr) / $setLimit);
        $output['status']       = true;
        $output['status_code']  = 200;
        $output['message']      = "Data Fetch Successfully";
        return json_encode($output);
    }
}
