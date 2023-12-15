<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AddToCart;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\ProductLocation;
use App\Models\ProductOption;
use App\Models\ProductOptionPricingDetails;
use App\Models\ProductOptionPricing;
use App\Models\ProductOptionDiscount;
use App\Models\ProductOptionAvailability;
use App\Models\ProductOptionPricingTiers;
use App\Models\AffilliateCommission;
use App\Models\HotelCommission;
use App\Models\PartnerAdminCommission;
use App\Models\Orders;
use App\Models\Admin;
use App\Models\User;
use App\Models\Tax;
use App\Models\Coupon;
use App\Models\TaxDescription;
use App\Models\UserReview;
use App\Models\Settings;
use App\Models\UserReviewDescription;
use App\Models\TransactionHistory;
use App\Models\CancelOrderHistory;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use App\Models\Hotels;
use App\Models\Hoteldescriptions;
use Stripe;
use DB;

use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function add_to_cart(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language'   => 'required',
            'currency'   => 'required',
            'token'      => 'required',
            'product_id' => 'required',
            'option_id'  => 'required',
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
        // dd($request->all());
        $language_id  = $request->language;
        $token        = $request->token;
        $product_slug = $request->product_id;
        $option_id    = $request->option_id;
        $user_id = checkDecrypt($request->user_id);
        $data = [];
        $Product = Product::where(['slug' => $product_slug, 'is_delete' => null, 'status' => 'Active'])->first();
        if ($Product) {
            $product_id = $Product->id;
            $AddToCart = new AddToCart();
            if (isset($user_id)) {
                $AddToCart['user_id'] = $user_id;
            }
            $AddToCart['token'] = $token;


            $AddToCart['product_id'] = $product_id;
            $json = [
                'adult'      => $request->adult,
                'child'      => $request->child,
                'infant'     => $request->infant,
                'date'       => $request->date,
                'time_slot'  => $request->time_slot,
                'option_id'  => $request->option_id,
                'added_by'   => $Product->added_by,
                'partner_id' => $Product->partner_id,
            ];
            $AddToCart['json'] = json_encode($json);
            $AddToCart->save();
            $output['status']        = true;
            $output['status_code']   = 200;
            $output['message']       = "Add to cart Successfully";
        }
        return json_encode($output);
    }

    public function cart_list(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language'   => 'required',
            'currency'   => 'required',
            'token'      => 'required',
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

        $language_id = $request->language;
        $token       = $request->token;
        $user_id     = checkDecrypt($request->user_id);
        // $user_id     = checkDecrypt($request->user_id);
        $data        = [];
        if (isset($user_id) && $user_id > 0) {

            $AddToCart = AddToCart::where('user_id', $user_id)->orderBy('id', 'desc')->get();
        } else {
            $AddToCart = AddToCart::where('token', $token)->orderBy('id', 'desc')->get();
        }



        $cartTotalAmount = 0;
        $finalTaxAmount = 0;
        $cartSubTotalAmount = 0;
        $couponTotalAmount = 0;
        $cart_tax_fee               = [];
        $checkout               = [];


        // Coupon Code Start
        $coupon      = '';
        $coupon_flag = 1;
        $coupon_msg = '';
        $is_coupon   = 0;
        $coupon_type = '';
        $Coupondate  = date("Y-m-d");
        if (isset($request->coupon)) {

            $AffilliateCode = isset($request->affilliate_code) ? $request->affilliate_code : '0';
            $getUser = User::where('affiliate_code', $AffilliateCode)
                ->where('user_type', 'Affiliate')
                ->where('is_verified', 1)
                ->first();

            if ($getUser) {
                $coupon  = Coupon::where(["code" => str_replace(" ", "", $request->coupon), 'status' => 'Active', 'value' => $getUser->id])->whereDate('start_date', '<=', $Coupondate)->whereDate('end_date', '>=', $Coupondate)->first();
                if (!$coupon) {
                    $coupon  = Coupon::where(["code" => str_replace(" ", "", $request->coupon), 'status' => 'Active'])->whereDate('start_date', '<=', $Coupondate)->whereDate('end_date', '>=', $Coupondate)->where('coupon_type', '!=', 'affilliate')->first();
                }
            } else {
                $coupon  = Coupon::where(["code" => str_replace(" ", "", $request->coupon), 'status' => 'Active'])->whereDate('start_date', '<=', $Coupondate)->whereDate('end_date', '>=', $Coupondate)->where('coupon_type', '!=', 'affilliate')->first();
            }

            if ($coupon) {
                if ($coupon->coupon_type == "product") {
                    $is_coupon = 1;
                }
                if ($coupon->coupon_type == "partner") {
                    $is_coupon = 1;
                }

                if ($coupon->coupon_type == "category") {
                    $is_coupon = 1;
                }
                if ($coupon->coupon_type == "affilliate") {
                    $is_coupon = 1;
                }
            } else {
                $coupon_flag = 0;
                $coupon_msg = "Coupon is not valid";
            }
        }
        // Coupon Code End




        $coupon_ids_arr   = [];
        $coupon_ids_count = [];
        $count = 1;

        if (count($AddToCart)  > 0) {
            foreach ($AddToCart as $ATCkey => $ATC) {
                $Product = Product::where(['id' => $ATC['product_id'], 'is_delete' => null, 'status' => 'Active'])->first();
                if ($Product) {
                    $TotalTaxAmount = 0;
                    $product_id = $Product->id;
                    $ProductImages = ProductImages::where(['product_id' => $product_id])->first();
                    $ProductDescription  = getLanguageData('products_description', $language_id, $product_id, 'product_id');
                    $file = 'dummyproduct.png';
                    if ($Product->cover_image != "") {
                        $file = $Product->cover_image;
                    } else {
                        if ($ProductImages) {
                            $file = $ProductImages->image;
                        }
                    }


                    $get_product               = [];
                    $get_product['id']         = $ATC['id'];
                    $get_product['slug']       = $Product->slug;
                    $get_product['product_id'] = $Product->id;
                    $get_product['category']   = $Product->category;
                    $get_product['partner_id']   = $Product->partner_id;
                    $get_product['token']      = $ATC['token'];
                    $get_product['image']      = asset('uploads/products/' . $file);
                    $get_product['title']      = $ProductDescription['title']      != "" ? $ProductDescription['title'] : "No Title";
                    $get_product['image_text'] = $ProductDescription['image_text'] != "" ? $ProductDescription['image_text'] : "";

                    $get_product['ratings']           = get_rating($product_id);
                    $get_product['total_review'] = UserReview::where('product_id', $product_id)
                        ->count();
                    $likely_to_sell_out                = ProductOption::where(['product_id' => $product_id, 'status' => 'Active', 'likely_to_sell_out' => 'yes'])->count();
                    $get_product['likely_to_sell_out'] = $likely_to_sell_out > 0  ? 'yes'  : 'no';


                    $ProductLocation              = ProductLocation::where(['product_id' => $product_id])->get();
                    $ProductLocationArr           = [];
                    foreach ($ProductLocation as $key => $PL) {
                        $get_location         = [];
                        $get_location       = explode(",", $PL['address']);
                        $ProductLocationArr[] = $get_location[0];
                    }
                    $get_product['location']       = implode(",", $ProductLocationArr);
                    $JSON                          = json_decode($ATC['json']);
                    $option_id                     = $JSON->option_id;
                    $date                          = $JSON->date;
                    $total                         = $JSON->adult + $JSON->child + $JSON->infant;
                    $get_product['option_details'] = getLanguageData('product_option_descriptions', $language_id, $option_id, 'option_id');
                    $get_product['adult']          = $adult  = $JSON->adult;
                    $get_product['child']          = $child  = $JSON->child;
                    $get_product['infant']         = $infant = $JSON->infant;
                    $get_product['provider']         = '';
                    $get_product['provider_slug']         = '';
                    if (isset($JSON->added_by)) {
                        if ($JSON->added_by == "partner") {
                            $User  = User::find($JSON->partner_id);
                            if ($User) {
                                $get_product['provider']      = $User->first_name . " " . $User->last_name;
                                $get_product['provider_slug'] = $User->slug;
                            }
                        }
                    }



                    $get_product['time_slot']      = $JSON->time_slot;
                    $get_product['date']           = $date;
                    $beforeDiscountAmount = 0;
                    $totalAmount = 0;

                    $ProductOptionPricing = ProductOptionPricing::where(['product_id' => $product_id, 'option_id' => $option_id, 'is_delete' => null])->first();
                    if ($ProductOptionPricing) {

                        $ProductOptionPricingDetails = ProductOptionPricingDetails::where(['product_id' => $product_id, 'option_id' => $option_id, 'pricing_id' => $ProductOptionPricing->id])->get();

                        $ProductOptionDiscount =  ProductOptionDiscount::where(['product_id' => $product_id, 'option_id' => $option_id, 'pricing_id' => $ProductOptionPricing->id])
                            ->where('valid_from', '<=', date('Y-m-d', strtotime($date)))->where('valid_to', '>=',  date('Y-m-d', strtotime($date)))
                            ->first();
                        $percentage = 0;

                        $day = "";
                        if (isset($date)) {
                            $timestampDate =  strtotime($date);
                            $fullday =  Carbon::parse($date)->format('l');
                            $day  = Str::lower(substr($fullday, 0, 3));
                        }


                        if ($ProductOptionDiscount) {

                            if (strtotime($ProductOptionDiscount->valid_from) <=  $timestampDate && strtotime($ProductOptionDiscount->valid_to) >=  $timestampDate) {
                                $percentage = $ProductOptionDiscount->date_percentage;
                            }


                            if ($ProductOptionDiscount->time_json != "") {
                                $time_json = json_decode($ProductOptionDiscount->time_json);
                                foreach ($time_json as $TJkey => $TJ) {
                                    if ($TJkey == $day) {
                                        if ($TJ > 0 && $TJ != "") {
                                            $percentage = $TJ;
                                        }
                                    }
                                }
                            }

                            if ($ProductOptionDiscount->date_json != "") {
                                $date_json = json_decode($ProductOptionDiscount->date_json);
                                foreach ($date_json as $DJkey => $DJ) {
                                    if ($DJkey == date("Y-m-d", strtotime($date))) {
                                        if ($DJ > 0 && $DJ != "") {
                                            $percentage = $DJ;
                                        }
                                    }
                                }
                            }
                        }

                        $price_brakdown = [];


                        foreach ($ProductOptionPricingDetails as $POPDkey => $POPD) {
                            $ProductOptionAvailability = ProductOptionAvailability::where(["product_id" => $product_id, 'pricing_id' => $ProductOptionPricing->id, 'option_id' => $option_id])->where('valid_from', '<=', date('Y-m-d', strtotime($date)))
                                ->where('valid_to', '>=', date('Y-m-d', strtotime($date)))
                                ->first();

                            if ($ProductOptionAvailability) {
                                if ($ProductOptionPricing->pricing_type == "person") {

                                    if (isset($adult) && $adult > 0 && $POPD['person_type']  == 'adult') {

                                        if ($POPD['booking_category'] == 'not_permitted') {
                                            $get_product['require_participants_msg']  = 'Adult not permitted for this activity.';
                                            $get_product['require_participants']         = false;
                                        } else {
                                            $ProductOptionPricingTiers = ProductOptionPricingTiers::where(['product_id' => $product_id, 'option_id' => $option_id, 'pricing_id' => $ProductOptionPricing->id, 'pricing_details_id' => $POPD['id'], 'type' => 'adult'])->where('from_no_of_people', '<=', $adult)->where('no_of_people', '>=', $adult)->first();

                                            if ($ProductOptionPricingTiers) {
                                                $adultData = [];
                                                $adultData['title'] = "Adult";
                                                $adultData['totalParticipants'] = $adult;
                                                $retail_price = $ProductOptionPricingTiers->retail_price;

                                                $adultData['booking_category'] = $POPD['booking_category'];


                                                if ($POPD['booking_category'] == 'free' || $POPD['booking_category'] == 'free_no_ticket') {
                                                    $retail_price = 0;
                                                }
                                                $beforeDiscountAdultPrice = $retail_price * $adult;
                                                $beforeDiscountAmount += $beforeDiscountAdultPrice;
                                                if ($percentage > 0) {
                                                    $percentageAmount = ($retail_price * $percentage) / 100;
                                                    $retail_price  = $retail_price - $percentageAmount;
                                                }
                                                $adultPrice = $retail_price * $adult;
                                                $adultData['pricePerPerson'] = $retail_price;

                                                $adultData['totalPrice'] = round($adultPrice, 2);
                                                $totalAmount += $adultPrice;
                                                $adultData['formattedValue'] = get_price_front($product_id, '', '', '', $adultPrice);
                                                $price_brakdown[] = $adultData;
                                            }
                                        }
                                    }
                                    if (isset($child) && $child > 0 && $POPD['person_type']  == 'child') {

                                        if ($POPD['booking_category'] == 'not_permitted') {
                                            $get_product['require_participants_msg']  = 'Child not permitted for this activity.';
                                            $get_product['require_participants']         = false;
                                        } else {
                                            $ProductOptionPricingTiersChild = ProductOptionPricingTiers::where(['product_id' => $product_id, 'option_id' => $option_id, 'pricing_id' => $ProductOptionPricing->id, 'type' => 'child'])->where('from_no_of_people', '<=', $child)->where('no_of_people', '>=', $child)->first();


                                            if (!$ProductOptionPricingTiersChild) {

                                                $ProductOptionPricingTiersChild = ProductOptionPricingTiers::where(['product_id' => $product_id, 'option_id' => $option_id, 'pricing_id' => $ProductOptionPricing->id, 'type' => 'adult'])->where('from_no_of_people', '<=', $child)->where('no_of_people', '>=', $child)->first();
                                            }

                                            if ($ProductOptionPricingTiersChild) {
                                                $childData = [];
                                                $childData['title'] = "Children";
                                                $childData['totalParticipants'] = $child;

                                                $childData['booking_category'] = $POPD['booking_category'];



                                                $retail_price = $ProductOptionPricingTiersChild->retail_price;
                                                if ($POPD['booking_category'] == 'free' || $POPD['booking_category'] == 'free_no_ticket') {
                                                    $retail_price = 0;
                                                }
                                                $beforeDiscountChildPrice = $retail_price * $child;
                                                $beforeDiscountAmount += $beforeDiscountChildPrice;


                                                if ($percentage > 0) {
                                                    $percentageAmount = ($retail_price * $percentage) / 100;
                                                    $retail_price  = $retail_price - $percentageAmount;
                                                }
                                                $childPrice = $retail_price * $child;
                                                $childData['pricePerPerson'] = $retail_price;

                                                $childData['totalPrice'] = round($childPrice, 2);
                                                $totalAmount += $childPrice;
                                                $childData['formattedValue'] = get_price_front($product_id, '', '', '', $childPrice);
                                                $price_brakdown[] = $childData;
                                            }
                                        }
                                    }

                                    if (isset($infant) && $infant > 0 && $POPD['person_type']  == 'infant') {

                                        if ($POPD['booking_category'] == 'not_permitted') {
                                            $get_product['require_participants_msg']  = 'Infant not permitted for this activity.';
                                            $get_product['require_participants']         = false;
                                        } else {
                                            $ProductOptionPricingTiersInfant = ProductOptionPricingTiers::where(['product_id' => $product_id, 'option_id' => $option_id, 'pricing_id' => $ProductOptionPricing->id, 'type' => 'infant'])->where('from_no_of_people', '<=', $infant)->where('no_of_people', '>=', $infant)->first();

                                            if (!$ProductOptionPricingTiersInfant) {
                                                $ProductOptionPricingTiersInfant = ProductOptionPricingTiers::where(['product_id' => $product_id, 'option_id' => $option_id, 'pricing_id' => $ProductOptionPricing->id, 'type' => 'adult'])->where('from_no_of_people', '<=', $infant)->where('no_of_people', '>=', $infant)->first();
                                            }

                                            if ($ProductOptionPricingTiersInfant) {
                                                $infantData = [];
                                                $infantData['title'] = "Infant";
                                                $infantData['totalParticipants'] = $infant;

                                                $infantData['booking_category'] = $POPD['booking_category'];



                                                $retail_price = $ProductOptionPricingTiersInfant->retail_price;
                                                if ($POPD['booking_category'] == 'free' || $POPD['booking_category'] == 'free_no_ticket') {
                                                    $retail_price = 0;
                                                }
                                                $beforeDiscountinfantPrice = $retail_price * $infant;
                                                $beforeDiscountAmount += $beforeDiscountinfantPrice;

                                                if ($percentage > 0) {
                                                    $percentageAmount = ($retail_price * $percentage) / 100;
                                                    $retail_price  = $retail_price - $percentageAmount;
                                                }
                                                $infantPrice = $retail_price * $infant;
                                                $infantData['pricePerPerson'] = $retail_price;



                                                $infantData['totalPrice'] =  round($infantPrice, 2);
                                                $totalAmount += $infantPrice;
                                                $infantData['formattedValue'] = get_price_front($product_id, '', '', '', $infantPrice);
                                                $price_brakdown[] = $infantData;
                                            }
                                        }
                                    }
                                } else {

                                    $ProductOptionPricingTiers = ProductOptionPricingTiers::where(['product_id' => $product_id, 'option_id' => $option_id, 'pricing_id' => $ProductOptionPricing->id, 'pricing_details_id' => $POPD['id'], 'type' => 'group'])->where('from_no_of_people', '<=', $total)->where('no_of_people', '>=', $total)->first();

                                    if ($ProductOptionPricingTiers) {
                                        $groupData = [];
                                        $groupData['title'] = "Participants";
                                        $groupData['totalParticipants'] = $total;

                                        $retail_price = $ProductOptionPricingTiers->retail_price;
                                        $beforeDiscountGroupPrice = $retail_price;
                                        $beforeDiscountAmount += $beforeDiscountGroupPrice;
                                        if ($percentage > 0) {
                                            $percentageAmount = ($retail_price * $percentage) / 100;
                                            $retail_price  = $retail_price - $percentageAmount;
                                        }
                                        $groupPrice = $retail_price;
                                        $groupData['pricePerPerson'] = $retail_price;

                                        $groupData['totalPrice'] = round($groupPrice, 2);
                                        $totalAmount += $groupPrice;
                                        $groupData['formattedValue'] = get_price_front($product_id, '', '', '', $groupPrice);
                                        $price_brakdown[] = $groupData;
                                    }
                                }
                            } else {
                                $get_product['require_participants_msg']  = 'This date is not available. Please select a different date.';
                                $get_product['require_participants']         = false;
                            }
                        }




                        $get_product['price_brakdown'] = $price_brakdown;
                        $finalTotalAmount = $totalAmount;
                        $get_product['totalAmount'] = round($totalAmount, 2);




                        $get_product['tax'] = [];
                        // Check Tax Amount
                        if ($totalAmount > 0) {
                            // print_r($get_product);
                            $tax_title = ['product_tax_title', 'category_tax_title', 'destination_tax_title'];
                            $tax_title = getPagemeta($tax_title, $language_id, '');
                            $User = User::find($user_id);

                            $destinationTaxAmount = 0;
                            $categoryTaxAmount = 0;
                            $all_tax = [];
                            // For Destination Tax
                            if ($User) {

                                $destinationTax = "";
                                $tax = "";
                                $UserCountry = $User->country;
                                $UserState   = $User->state;
                                $UserCity    = $User->city;

                                $tax  = Tax::where(['country' => $UserCountry, 'state' => 0, 'city' => 0])->first();
                                if ($tax) {
                                    $destinationTax = $tax;
                                }
                                $tax  = Tax::where(['country' => $UserCountry, 'state' => $UserState, 'city' => 0])->first();
                                if ($tax) {
                                    $destinationTax = $tax;
                                }
                                $tax  = Tax::where(['country' => $UserCountry, 'state' => $UserState, 'city' => $UserCity])->first();
                                if ($tax) {
                                    $destinationTax = $tax;
                                }

                                if ($destinationTax != "") {
                                    $detinationTitle = "Destination Tax";

                                    $TaxDescription = TaxDescription::where(['tax_id' => $destinationTax->id, 'language_id' => $language_id])->first();
                                    if ($TaxDescription) {
                                        if ($TaxDescription->title != "") {
                                            $detinationTitle = $TaxDescription->title;
                                        }
                                    }

                                    $all_tax['title'] = $detinationTitle;
                                    $all_tax['type'] = $destinationTax->tax_type;
                                    $all_tax['basic'] = $destinationTax->amount;
                                    if ($destinationTax->tax_type == "percentage") {


                                        $percentageDestinationAmount = ($finalTotalAmount * $destinationTax->amount) / 100;


                                        $destinationTaxAmount = $percentageDestinationAmount;
                                    } else {
                                        $destinationTaxAmount = $destinationTax->amount;
                                    }

                                    $TotalTaxAmount +=   $destinationTaxAmount;

                                    $all_tax['format_amount'] = get_price_front('', '', '', '', $destinationTaxAmount);
                                    $get_product['tax'][] = $all_tax;
                                }
                            }

                            // For Category tax
                            if ($Product->category != "") {
                                $categoryTax  = Tax::where(['category' => $Product->category])->first();
                                if ($categoryTax != "") {
                                    $categoryTitle = "Category Tax";

                                    $TaxDescription = TaxDescription::where(['tax_id' => $categoryTax->id, 'language_id' => $language_id])->first();
                                    if ($TaxDescription) {
                                        if ($TaxDescription->title != "") {
                                            $categoryTitle = $TaxDescription->title;
                                        }
                                    }

                                    if (isset($tax_title['category_tax_title'])) {
                                        if ($tax_title['category_tax_title'] != "") {
                                            $categoryTitle = $tax_title['category_tax_title'];
                                        }
                                    }

                                    $all_tax['title'] = $categoryTitle;
                                    $all_tax['type'] = $categoryTax->tax_type;
                                    $all_tax['basic'] = $categoryTax->amount;
                                    if ($categoryTax->tax_type == "percentage") {


                                        $percentageDestinationAmount = ($finalTotalAmount * $categoryTax->amount) / 100;


                                        $categoryTaxAmount = $percentageDestinationAmount;
                                    } else {
                                        $categoryTaxAmount = $categoryTax->amount;
                                    }
                                    $TotalTaxAmount +=  $categoryTaxAmount;

                                    $all_tax['format_amount'] = get_price_front('', '', '', '', $categoryTaxAmount);
                                    $get_product['tax'][] = $all_tax;
                                }
                            }

                            // For Product Tax
                            if ($Product->id != "") {
                                $productTax  = Tax::where(['products' => $Product->id])->first();
                                if ($productTax != "") {
                                    $categoryTitle = "Product Tax";

                                    $TaxDescription = TaxDescription::where(['tax_id' => $productTax->id, 'language_id' => $language_id])->first();
                                    if ($TaxDescription) {
                                        if ($TaxDescription->title != "") {
                                            $categoryTitle = $TaxDescription->title;
                                        }
                                    }




                                    $all_tax['title'] = $categoryTitle;
                                    $all_tax['type'] = $productTax->tax_type;
                                    $all_tax['basic'] = $productTax->amount;
                                    if ($productTax->tax_type == "percentage") {


                                        $percentageDestinationAmount = ($finalTotalAmount * $productTax->amount) / 100;


                                        $productTaxAmount = $percentageDestinationAmount;
                                    } else {
                                        $productTaxAmount = $productTax->amount;
                                    }

                                    $TotalTaxAmount +=    $productTaxAmount;

                                    $all_tax['format_amount'] = get_price_front('', '', '', '', $productTaxAmount);
                                    $get_product['tax'][] = $all_tax;
                                }
                            }
                            $ProductDescriptionTitle = $ProductDescription['title']      != "" ? $ProductDescription['title'] : "No Title";
                            $cart_tax_fee['amount'] =  get_price_front('', '', '', '', $TotalTaxAmount + $totalAmount);
                            $cart_tax_fee['title'] =   $ProductDescriptionTitle;

                            $data['cart_tax_fee'][] = $cart_tax_fee;
                        }

                        $get_product['total_tax'] =  $TotalTaxAmount;
                        $get_product['total_tax_format'] =  get_price_front('', '', '', '', $TotalTaxAmount);
                        $finalTaxAmount += $TotalTaxAmount;
                        $cartSubTotalAmount += $totalAmount;
                        $cartTotalAmount += $totalAmount + $TotalTaxAmount;
                        $get_product['formatTotalAmount'] = get_price_front($product_id, '', '', '', $totalAmount);






                        if ($percentage > 0) {
                            $get_product['deal']['originalPrice'] = $beforeDiscountAmount;
                            $get_product['deal']['percentage'] = $percentage;
                            $percentageAmount = ($beforeDiscountAmount * $percentage) / 100;
                            $totalAmount  = $beforeDiscountAmount - $percentageAmount;
                            $get_product['deal']['formatTotalAmount'] = get_price_front($product_id, '', '', '', $totalAmount);
                            $get_product['deal']['formatoriginalPrice'] = get_price_front($product_id, '', '', '', $beforeDiscountAmount);
                        } else {
                            $get_product['deal'] = '';
                        }

                        if ($totalAmount > 0) {
                            if ($coupon) {
                                if ($coupon->coupon_type == "product") {
                                    // $coupon_ids_arr[$product_id] = 0;
                                    $coupon_ids_arr[$product_id]   = isset($coupon_ids_arr[$product_id])   ? $coupon_ids_arr[$product_id]   + $totalAmount  : $totalAmount;
                                    $coupon_ids_count[$product_id] = isset($coupon_ids_count[$product_id]) ? $coupon_ids_count[$product_id] + 1   : 1;
                                }
                                if ($coupon->coupon_type == "category") {
                                    // $coupon_ids_arr[$product_id] = 0;
                                    $coupon_ids_arr[$Product->category]   = isset($coupon_ids_arr[$Product->category])   ? $coupon_ids_arr[$Product->category]   + $totalAmount  : $totalAmount;
                                    $coupon_ids_count[$Product->category] = isset($coupon_ids_count[$Product->category]) ? $coupon_ids_count[$Product->category] + 1   : 1;
                                }

                                if ($coupon->coupon_type == "partner") {
                                    // $coupon_ids_arr[$product_id] = 0;
                                    $coupon_ids_arr[$Product->partner_id]   = isset($coupon_ids_arr[$Product->partner_id])   ? $coupon_ids_arr[$Product->partner_id]   + $totalAmount  : $totalAmount;
                                    $coupon_ids_count[$Product->partner_id] = isset($coupon_ids_count[$Product->partner_id]) ? $coupon_ids_count[$Product->partner_id] + 1   : 1;
                                }

                                if ($coupon->coupon_type == "affilliate") {

                                    // $coupon_ids_arr[$product_id] = 0;
                                    $coupon_ids_arr[$coupon->value]   = isset($coupon_ids_arr[$coupon->value])   ? $coupon_ids_arr[$coupon->value]   + $totalAmount  : $totalAmount;
                                    $coupon_ids_count[$coupon->value] = isset($coupon_ids_count[$coupon->value]) ? $coupon_ids_count[$coupon->value] + 1   : 1;
                                }
                            }
                            $data['amnt'] = $coupon_ids_arr;
                            $data['coupon_ids_count'] = $coupon_ids_count;
                            $data['detail'][] = $details =  $get_product;
                        }
                    }
                    // $count++;     
                }
            }


            $checkCouponApplied  = 0;
            // return $coupon_ids_arr;
            if (count($coupon_ids_arr) > 0) {
                $cartSubTotalAmount = 0; //237.5 + 237.5 + 
                $finalTaxAmount = 0;
                $cartTotalAmount = 0;

                $isCouponApplied = 0;
                foreach ($coupon_ids_arr as $coupon_ids_arr_key => $coupon_ids_amnt) {
                    if ($is_coupon == 1) {

                        foreach ($data['detail'] as $Dkey => $D) {
                            $newProductTaxAmount = 0;

                            if ($coupon->coupon_type == "category") {
                                $check_id_arr_type = $D['category'];
                            }
                            if ($coupon->coupon_type == "product") {
                                $check_id_arr_type = $D['product_id'];
                            }
                            if ($coupon->coupon_type == "partner") {
                                $check_id_arr_type = $D['partner_id'];
                            }

                            if ($coupon->coupon_type == "affilliate") {
                                $check_id_arr_type = $getUser->id;
                            }

                            if ($coupon_ids_arr_key == $check_id_arr_type) {
                                if ($coupon_ids_amnt >= $coupon->minimum_amount) {


                                    if ($coupon->coupon_type == "category" && $coupon_ids_arr_key == $coupon->value) {

                                        if ($coupon_ids_arr_key == $D['category']) {
                                            if ($isCouponApplied == 0) {
                                                $isCouponApplied = 1;
                                            }
                                            $coupon_amount = $coupon->coupon_amount / $coupon_ids_count[$coupon_ids_arr_key];
                                            $couponText =  "Coupon Appiled (#" . $coupon->code . " " . round($coupon_amount, 2) . ")";
                                            if ($coupon->coupon_amount_type == "percentage") {
                                                $coupon_amount = $coupon->coupon_amount;
                                                $couponText         = "Coupon Applied(#" . $coupon->code . " " . round($coupon_amount, 2) . "%)";
                                                $coupon_amount      = ($D['totalAmount'] * $coupon_amount) / 100;
                                            }

                                            // $D['totalAmount'] = $D['totalAmount'] - $coupon_amount;
                                            $taxTotalAmount = $D['totalAmount'] - $coupon_amount;
                                            if ($taxTotalAmount < 0) {
                                                $taxTotalAmount = 0;
                                            }
                                            $D['after_coupon_discount'] =  get_price_front('', '', '', '', $taxTotalAmount);


                                            $cartSubTotalAmount += $D['totalAmount'];
                                            $D['coupon_amount_format'] =  get_price_front('', '', '', '', round($coupon_amount, 2));
                                            $D['coupon_amount'] =  round($coupon_amount, 2);
                                            $couponTotalAmount +=  round($coupon_amount, 2);
                                            $D['couponText']    = $couponText;

                                            $productTaxAmount = 0;
                                            foreach ($D['tax'] as $Tkey => $T) {
                                                $productTaxAmount  = $T['basic'];
                                                if ($T['type'] == "percentage") {
                                                    $percentageAmount = ($taxTotalAmount * $T['basic']) / 100;
                                                    $productTaxAmount = $percentageAmount;
                                                }
                                                $finalTaxAmount += $productTaxAmount;
                                                $newProductTaxAmount += $productTaxAmount;
                                                $D['tax'][$Tkey]['format_amount'] = get_price_front('', '', '', '', $productTaxAmount);
                                            }

                                            $D['total_tax'] = $newProductTaxAmount;
                                            $D['total_tax_format'] =  get_price_front('', '', '', '', $newProductTaxAmount);
                                            $cartTotalAmount +=  $D['totalAmount'] + $newProductTaxAmount;
                                            // echo $cartTotalAmount . "--TAx--";
                                            $D['cartTotalAmount'] = $cartTotalAmount;
                                            $data['detail'][$Dkey]   = $D;
                                        }
                                    } elseif ($coupon->coupon_type == "product" && $coupon_ids_arr_key == $coupon->value) {

                                        if ($coupon_ids_arr_key == $D['product_id']) {
                                            if ($isCouponApplied == 0) {
                                                $isCouponApplied = 1;
                                            }
                                            $coupon_amount = $coupon->coupon_amount / $coupon_ids_count[$coupon_ids_arr_key];
                                            $couponText =  "Coupon Appiled (#" . $coupon->code . " " . round($coupon_amount, 2) . ")";
                                            if ($coupon->coupon_amount_type == "percentage") {
                                                $coupon_amount = $coupon->coupon_amount;
                                                $couponText         = "Coupon Applied(#" . $coupon->code . " " . round($coupon_amount, 2) . "%)";
                                                $coupon_amount      = ($D['totalAmount'] * $coupon_amount) / 100;
                                            }

                                            // $D['totalAmount'] = $D['totalAmount'] - $coupon_amount;
                                            $taxTotalAmount = $D['totalAmount'] - $coupon_amount;
                                            if ($taxTotalAmount < 0) {
                                                $taxTotalAmount = 0;
                                            }
                                            $D['after_coupon_discount'] =  get_price_front('', '', '', '', $taxTotalAmount);
                                            $cartSubTotalAmount += $D['totalAmount'];
                                            $D['coupon_amount_format'] =  get_price_front('', '', '', '', round($coupon_amount, 2));
                                            $D['coupon_amount'] =  round($coupon_amount, 2);
                                            $couponTotalAmount +=  round($coupon_amount, 2);
                                            $D['couponText']    = $couponText;

                                            $productTaxAmount = 0;
                                            foreach ($D['tax'] as $Tkey => $T) {
                                                $productTaxAmount  = $T['basic'];
                                                if ($T['type'] == "percentage") {
                                                    $percentageAmount = ($taxTotalAmount * $T['basic']) / 100;
                                                    $productTaxAmount = $percentageAmount;
                                                }
                                                $finalTaxAmount += $productTaxAmount;
                                                $newProductTaxAmount += $productTaxAmount;
                                                $D['tax'][$Tkey]['format_amount'] = get_price_front('', '', '', '', $productTaxAmount);
                                            }

                                            $D['total_tax'] = $newProductTaxAmount;
                                            $D['total_tax_format'] =  get_price_front('', '', '', '', $newProductTaxAmount);
                                            $cartTotalAmount +=  $D['totalAmount'] + $newProductTaxAmount;
                                            $D['cartTotalAmount'] = $cartTotalAmount;
                                            // echo $cartTotalAmount . "--TAx--";

                                            $data['detail'][$Dkey]   = $D;
                                        }
                                    } elseif ($coupon->coupon_type == "partner" && $coupon_ids_arr_key == $coupon->value) {

                                        if ($coupon_ids_arr_key == $D['partner_id']) {
                                            if ($isCouponApplied == 0) {
                                                $isCouponApplied = 1;
                                            }
                                            $coupon_amount = $coupon->coupon_amount / $coupon_ids_count[$coupon_ids_arr_key];
                                            $couponText =  "Coupon Appiled (#" . $coupon->code . " " . round($coupon_amount, 2) . ")";
                                            if ($coupon->coupon_amount_type == "percentage") {
                                                $coupon_amount = $coupon->coupon_amount;
                                                $couponText         = "Coupon Applied(#" . $coupon->code . " " . round($coupon_amount, 2) . "%)";
                                                $coupon_amount      = ($D['totalAmount'] * $coupon_amount) / 100;
                                            }

                                            // $D['totalAmount'] = $D['totalAmount'] - $coupon_amount;
                                            $taxTotalAmount = $D['totalAmount'] - $coupon_amount;
                                            if ($taxTotalAmount < 0) {
                                                $taxTotalAmount = 0;
                                            }

                                            $D['after_coupon_discount'] =  get_price_front('', '', '', '', $taxTotalAmount);
                                            $cartSubTotalAmount += $D['totalAmount'];
                                            $D['coupon_amount_format'] =  get_price_front('', '', '', '', round($coupon_amount, 2));
                                            $D['coupon_amount'] =  round($coupon_amount, 2);
                                            $couponTotalAmount +=  round($coupon_amount, 2);
                                            $D['couponText']    = $couponText;

                                            $productTaxAmount = 0;
                                            foreach ($D['tax'] as $Tkey => $T) {
                                                $productTaxAmount  = $T['basic'];
                                                if ($T['type'] == "percentage") {
                                                    $percentageAmount = ($taxTotalAmount * $T['basic']) / 100;
                                                    $productTaxAmount = $percentageAmount;
                                                }
                                                $finalTaxAmount += $productTaxAmount;
                                                $newProductTaxAmount += $productTaxAmount;
                                                $D['tax'][$Tkey]['format_amount'] = get_price_front('', '', '', '', $productTaxAmount);
                                            }

                                            $D['total_tax'] = $newProductTaxAmount;
                                            $D['total_tax_format'] =  get_price_front('', '', '', '', $newProductTaxAmount);
                                            $cartTotalAmount +=  $D['totalAmount'] + $newProductTaxAmount;
                                            $D['cartTotalAmount'] = $cartTotalAmount;
                                            // echo $cartTotalAmount . "--TAx--";

                                            $data['detail'][$Dkey]   = $D;
                                        }
                                    } elseif ($coupon->coupon_type == "affilliate" && $coupon_ids_arr_key == $coupon->value) {

                                        if ($coupon_ids_arr_key == $getUser->id) {
                                            if ($isCouponApplied == 0) {
                                                $isCouponApplied = 1;
                                            }
                                            $coupon_amount = $coupon->coupon_amount / $coupon_ids_count[$coupon_ids_arr_key];
                                            $couponText =  "Coupon Appiled (#" . $coupon->code . " " . round($coupon_amount, 2) . ")";
                                            if ($coupon->coupon_amount_type == "percentage") {
                                                $coupon_amount = $coupon->coupon_amount;
                                                $couponText         = "Coupon Applied(#" . $coupon->code . " " . round($coupon_amount, 2) . "%)";
                                                $coupon_amount      = ($D['totalAmount'] * $coupon_amount) / 100;
                                            }

                                            // $D['totalAmount'] = $D['totalAmount'] - $coupon_amount;
                                            $taxTotalAmount = $D['totalAmount'] - $coupon_amount;
                                            if ($taxTotalAmount < 0) {
                                                $taxTotalAmount = 0;
                                            }
                                            $D['after_coupon_discount'] =  get_price_front('', '', '', '', $taxTotalAmount);

                                            $cartSubTotalAmount += $D['totalAmount'];
                                            $D['coupon_amount_format'] =  get_price_front('', '', '', '', round($coupon_amount, 2));
                                            $D['coupon_amount'] =  round($coupon_amount, 2);
                                            $couponTotalAmount +=  round($coupon_amount, 2);
                                            $D['couponText']    = $couponText;

                                            $productTaxAmount = 0;
                                            foreach ($D['tax'] as $Tkey => $T) {
                                                $productTaxAmount  = $T['basic'];
                                                if ($T['type'] == "percentage") {
                                                    $percentageAmount = ($taxTotalAmount * $T['basic']) / 100;
                                                    $productTaxAmount = $percentageAmount;
                                                }
                                                $finalTaxAmount += $productTaxAmount;
                                                $newProductTaxAmount += $productTaxAmount;
                                                $D['tax'][$Tkey]['format_amount'] = get_price_front('', '', '', '', $productTaxAmount);
                                            }

                                            $D['total_tax'] = $newProductTaxAmount;
                                            $D['total_tax_format'] =  get_price_front('', '', '', '', $newProductTaxAmount);
                                            $cartTotalAmount +=  $D['totalAmount'] + $newProductTaxAmount;
                                            $D['cartTotalAmount'] = $cartTotalAmount;
                                            // echo $cartTotalAmount . "--TAx--";

                                            $data['detail'][$Dkey]   = $D;
                                        }
                                    } else {
                                        $cartSubTotalAmount += $D['totalAmount'];
                                        $finalTaxAmount     += $D['total_tax'];
                                        $cartTotalAmount    += $D['totalAmount'] + $D['total_tax'];
                                    }
                                } else {

                                    $cartSubTotalAmount += $D['totalAmount'];
                                    $finalTaxAmount += $D['total_tax'];
                                    $cartTotalAmount +=  $D['totalAmount'] + $D['total_tax'];

                                    // echo $cartTotalAmount . "++OLD++";
                                }
                                // echo $finalTaxAmount . "***";

                            }
                            // $cartTotalAmount - 
                        }
                    }
                }
            }
            if ($is_coupon == 1) {
                if ($couponTotalAmount == 0) {
                    if ($checkCouponApplied == 0) {
                        $coupon_flag = 0;
                        $coupon_msg = "Coupon not valid for products";
                    } else {
                        $coupon_flag = 0;
                        $coupon_msg = "Coupon minimum amount is " . $coupon->minimum_amount;
                    }
                }
            }

            $data['coupon_flag']  = $coupon_flag;
            $data['coupon_msg']  = $coupon_msg;




            if ($cartTotalAmount > 0) {
                $checkout['amount']  = get_price_front('', '', '', '', $cartSubTotalAmount);
                $checkout['title']  = 'Sub Total';

                $data['checkout'][] = $checkout;

                if ($finalTaxAmount > 0) {
                    $checkout['amount']  =  get_price_front('', '', '', '', $finalTaxAmount);
                    $checkout['title']  = 'Total Tax';
                    $data['checkout'][] = $checkout;
                }

                if ($couponTotalAmount > 0) {
                    $checkout['amount']  =  get_price_front('', '', '', '', round($couponTotalAmount));
                    $checkout['title']  = 'Total Discount';
                    $data['checkout'][] = $checkout;
                }



                $checkout['amount']  = get_price_front('', '', '', '', $cartTotalAmount - $couponTotalAmount);
                $checkout['title']  = 'Total';

                $data['checkout'][] = $checkout;


                $cart_tax_fee['amount'] =  get_price_front('', '', '', '', $cartTotalAmount);
                $cart_tax_fee['title'] =  'Total (' . count($data['detail']) . ' item)';

                $data['cart_tax_fee'][] = $cart_tax_fee;
                $data['final_amount']  = $cartTotalAmount - $couponTotalAmount;

                $output['data']        = $data;
                $output['status']      = true;
                $output['status_code'] = 200;
                $output['message']     = "Data fetched Successfully";
            }
        }
        return json_encode($output);
    }

    public function delete_cart(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language'   => 'required',
            'currency'   => 'required',
            'token'      => 'required',
            'cart_id'      => 'required',
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

        $language_id = $request->language;
        $cart_id       = $request->cart_id;

        $data        = [];
        $AddToCart = AddToCart::find($cart_id);

        if ($AddToCart) {
            $AddToCart->delete();
        }


        $output['status']      = true;
        $output['status_code'] = 200;
        $output['message']     = "Delete Successfully";
        return json_encode($output);
    }

    public function checkout(Request $request)
    {

        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language'   => 'required',
            'currency'   => 'required',
            'token'      => 'required',
            'user_id'    => 'required',
            'first_name' => 'required',
            'email'      => 'required',
            'phone'      => 'required',
            'country'    => 'required',
            'state'      => 'required',
            'city'       => 'required',
            'zipcode'    => 'required',
            'address'    => 'required',
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
        $is_hotel = 0;
        if (isset($request->url)) {
            // $url =  "radison"; // $request->url;/
            $url =  $request->url;
            $Hotel = User::where(['slug' => $url, 'is_delete' => null, 'status' => 'Active'])->first();
            if ($Hotel) {
                $is_hotel = 1;
            }
        };

        $language_id  = $request->language;
        $token        = $request->token;
        $product_slug = $request->product_id;
        $option_id    = $request->option_id;

        $data = [];

        // $user_id     = checkDecrypt($request->user_id);
        $user_id     = $request->user_id;
        $data        = [];
        $AddToCart = '';
        $earning_type = "";
        if (isset($user_id) && $user_id > 0) {

            $AddToCart = AddToCart::where('user_id', $user_id)->where('token', '!=', "")->orderBy('id', 'Desc')->get();
        }
        $cartTotalAmount = 0;
        $finalTaxAmount = 0;
        $cartSubTotalAmount = 0;
        $couponTotalAmount = 0;

        $UserDetails = User::find($user_id);

        // Coupon Code Start
        $coupon      = '';
        $is_coupon   = 0;
        $coupon_type = '';
        $Coupondate  = date("Y-m-d");
        if (isset($request->coupon)) {

            $AffilliateCode = isset($request->affilliate_code) ? $request->affilliate_code : '0';
            $getAffilliateUser = User::where('affiliate_code', $AffilliateCode)
                ->where('user_type', 'Affiliate')
                ->where('is_verified', 1)
                ->first();

            if ($getAffilliateUser && $is_hotel == 0) {
                $coupon  = Coupon::where(["code" => str_replace(" ", "", $request->coupon), 'status' => 'Active', 'value' => $getAffilliateUser->id])->whereDate('start_date', '<=', $Coupondate)->whereDate('end_date', '>=', $Coupondate)->first();
                if (!$coupon) {
                    $coupon  = Coupon::where(["code" => str_replace(" ", "", $request->coupon), 'status' => 'Active'])->whereDate('start_date', '<=', $Coupondate)->whereDate('end_date', '>=', $Coupondate)->where('coupon_type', '!=', 'affilliate')->first();
                }
            } else {
                $coupon  = Coupon::where(["code" => str_replace(" ", "", $request->coupon), 'status' => 'Active'])->whereDate('start_date', '<=', $Coupondate)->whereDate('end_date', '>=', $Coupondate)->where('coupon_type', '!=', 'affilliate')->first();
            }



            if ($coupon) {
                if ($coupon->coupon_type == "product") {
                    $is_coupon = 1;
                }
                if ($coupon->coupon_type == "partner") {
                    $is_coupon = 1;
                }

                if ($coupon->coupon_type == "category") {
                    $is_coupon = 1;
                }
                if ($coupon->coupon_type == "affilliate") {
                    $is_coupon = 1;
                }
            }
        }
        // Coupon Code End




        $coupon_ids_arr   = [];
        $coupon_ids_count = [];
        $count = 1;




        $totalCommission      = 0;

        $totalPartnerAmount   = 0;
        $totalAdminCommission = 0;
        $partnerProductTotal  = 0;

        $checkout             = [];
        $cart_tax_fee         = [];

        // Affiliate Commission
        $AffilliateCommissionArr = [];
        $AdminCommissionArr = [];
        $AffilliateCommission = new AffilliateCommission();
        $AffilliateCode = isset($request->affilliate_code) ? $request->affilliate_code : '0';

        // Hotel Commission
        $HotelCommissionArr = [];
        $HotelCommission  = new HotelCommission();


        if ($AddToCart) {
            if ($is_hotel == 0) {
                $affilate_user = "";
                $user_affiliate_commission = "";
                $getUser = User::where('affiliate_code', $AffilliateCode)
                    ->where('user_type', 'Affiliate')
                    ->where('is_verified', 1)
                    ->first();

                if ($getUser) {
                    $affilate_user = $getUser['id'];
                    $user_affiliate_commission = $getUser->affiliate_commission;
                    $earning_type = "affiliate";
                }

                $AffilliateCommission['user_id'] = $affilate_user;
            }

            if ($is_hotel == 1) {
                $HotelCommission['hotel_id'] = $Hotel->id;
                $HotelCommission['hotel_slug'] = $Hotel->slug;
                $earning_type = "hotel";
            }


            foreach ($AddToCart as $ATCkey => $ATC) {
                $Product = Product::where(['id' => $ATC['product_id'], 'is_delete' => null, 'status' => 'Active'])->first();
                if ($Product) {
                    $TotalTaxAmount = 0;
                    $TotalCouponDiscountAmount = 0;
                    $get_commission_arr = [];
                    $get_hotel_commission_arr = [];
                    $get_admin_partner_commission_arr = [];
                    $product_id = $Product->id;
                    $ProductImages = ProductImages::where(['product_id' => $product_id])->first();
                    $ProductDescription  = getLanguageData('products_description', $language_id, $product_id, 'product_id');
                    $file = 'dummyproduct.png';
                    if ($Product->cover_image != "") {
                        $file = $Product->cover_image;
                    } else {
                        if ($ProductImages) {
                            $file = $ProductImages->image;
                        }
                    }
                    $get_product               = [];

                    $get_product['id']            = $ATC['id'];
                    $get_product['product_id']    = $product_id;
                    $get_product['category']      = $Product->category;
                    $get_product['partner_id']    = $Product->partner_id;
                    $get_product['activity_type'] = ucfirst(str_replace("_", " ", $Product->type));
                    $get_product['token']         = $ATC['token'];
                    $get_product['image']         = asset('uploads/products/' . $file);
                    $get_product['title']         = $title                             = $ProductDescription['title'] != "" ? $ProductDescription['title'] : "No Title";
                    $get_product['image_text']    = $ProductDescription['image_text'] != "" ? $ProductDescription['image_text'] : "";



                    if ($is_hotel == 0) {
                        if ($getUser) {
                            // Affilate Code  Start
                            $Settings = Settings::where('meta_title', 'affilliate_commission')->first();
                            $affiliate_commission = 0;
                            if ($Product->affiliate_commission != "") {
                                $affiliate_commission = $Product->affiliate_commission;
                            } else if ($user_affiliate_commission != "") {
                                $affiliate_commission = $user_affiliate_commission;
                            } else if ($Settings->content != "") {
                                $affiliate_commission = $Settings->content;
                            }

                            $get_commission_arr['product_id']   = $product_id;
                            $get_commission_arr['product_name'] = $title;
                            $get_commission_arr['commission']   = $affiliate_commission;
                        }
                    }

                    if ($is_hotel == 1) {
                        $hotel_commission = 0;
                        $Hotel_Commission = $Hotel->hotel_commission;

                        if ($HotelCommission != "") {
                            $hotel_commission = $Hotel_Commission;
                        }


                        $get_hotel_commission_arr['product_id']   = $product_id;
                        $get_hotel_commission_arr['product_name'] = $title;
                        $get_hotel_commission_arr['commission']   = $hotel_commission;
                    }

                    // Affilate Code  end

                    $ProductLocation              = ProductLocation::where(['product_id' => $product_id])->get();
                    $ProductLocationArr           = [];
                    foreach ($ProductLocation as $key => $PL) {
                        $get_location         = [];
                        $get_location       = explode(",", $PL['address']);
                        $ProductLocationArr[] = $get_location[0];
                    }
                    $get_product['location']       = implode(",", $ProductLocationArr);
                    $JSON                          = json_decode($ATC['json']);
                    $option_id                     = $JSON->option_id;
                    $date                          = $JSON->date;
                    $total                         = $JSON->adult + $JSON->child + $JSON->infant;
                    $get_product['option_details'] = getLanguageData('product_option_descriptions', $language_id, $option_id, 'option_id');
                    $get_product['adult']          = $adult  = $JSON->adult;
                    $get_product['child']          = $child  = $JSON->child;
                    $get_product['infant']         = $infant = $JSON->infant;
                    $get_product['added_by']       = isset($JSON->added_by) ? $JSON->added_by : '';
                    $get_product['partner_id']     = isset($JSON->partner_id) ?  $JSON->partner_id : '';
                    $get_product['partner_name']   = '';
                    $get_product['partner_slug']   = '';
                    $get_product['time_slot']      = $JSON->time_slot;
                    $get_product['date']           = $date;
                    $get_product['is_review']      = false;
                    $AdminCommission               = 0;
                    if (isset($JSON->added_by)) {
                        if ($JSON->added_by == "partner") {
                            $User  = User::find($JSON->partner_id);
                            if ($User) {
                                $get_product['partner_name'] = $User->first_name . " " . $User->last_name;
                                $get_product['partner_slug'] = $User->slug;
                                $Settings = Settings::where('meta_title', 'admin_commission')->first();
                            }
                            if ($User->partner_commission != "") {
                                $AdminCommission = $User->partner_commission;
                            } else if ($Settings->content != "") {
                                $AdminCommission = $Settings->content;
                            }

                            $get_admin_partner_commission_arr['product_id']   = $product_id;
                            $get_admin_partner_commission_arr['product_name'] = $title;


                            $get_admin_partner_commission_arr['commission']   = $AdminCommission;
                            $get_admin_partner_commission_arr['order_index']   = $ATCkey;
                        }
                    }

                    $beforeDiscountAmount = 0;
                    $totalAmount = 0;
                    $ProductOptionPricing = ProductOptionPricing::where(['product_id' => $product_id, 'option_id' => $option_id, 'is_delete' => null])->first();
                    if ($ProductOptionPricing) {

                        $ProductOptionPricingDetails = ProductOptionPricingDetails::where(['product_id' => $product_id, 'option_id' => $option_id, 'pricing_id' => $ProductOptionPricing->id])->get();

                        $ProductOptionDiscount =  ProductOptionDiscount::where(['product_id' => $product_id, 'option_id' => $option_id, 'pricing_id' => $ProductOptionPricing->id])
                            ->where('valid_from', '<=', date('Y-m-d', strtotime($date)))->where('valid_to', '>=',  date('Y-m-d', strtotime($date)))
                            ->first();
                        $percentage = 0;

                        $day = "";
                        if (isset($date)) {
                            $timestampDate =  strtotime($date);
                            $fullday =  Carbon::parse($date)->format('l');
                            $day  = Str::lower(substr($fullday, 0, 3));
                        }


                        if ($ProductOptionDiscount) {

                            if (strtotime($ProductOptionDiscount->valid_from) <=  $timestampDate && strtotime($ProductOptionDiscount->valid_to) >=  $timestampDate) {
                                $percentage = $ProductOptionDiscount->date_percentage;
                            }


                            if ($ProductOptionDiscount->time_json != "") {
                                $time_json = json_decode($ProductOptionDiscount->time_json);
                                foreach ($time_json as $TJkey => $TJ) {
                                    if ($TJkey == $day) {
                                        if ($TJ > 0 && $TJ != "") {
                                            $percentage = $TJ;
                                        }
                                    }
                                }
                            }

                            if ($ProductOptionDiscount->date_json != "") {
                                $date_json = json_decode($ProductOptionDiscount->date_json);
                                foreach ($date_json as $DJkey => $DJ) {
                                    if ($DJkey == $date) {
                                        if ($DJ > 0 && $DJ != "") {
                                            $percentage = $DJ;
                                        }
                                    }
                                }
                            }
                        }

                        $price_brakdown = [];

                        foreach ($ProductOptionPricingDetails as $POPDkey => $POPD) {
                            $ProductOptionAvailability = ProductOptionAvailability::where(["product_id" => $product_id, 'pricing_id' => $ProductOptionPricing->id, 'option_id' => $option_id])->where('valid_from', '<=', date('Y-m-d', strtotime($date)))
                                ->where('valid_to', '>=', date('Y-m-d', strtotime($date)))
                                ->first();

                            if ($ProductOptionAvailability) {
                                if ($ProductOptionPricing->pricing_type == "person") {

                                    if (isset($adult) && $adult > 0 && $POPD['person_type']  == 'adult') {

                                        if ($POPD['booking_category'] == 'not_permitted') {
                                            $row['require_participants_msg']  = 'Adult not permitted for this activity.';
                                            $row['require_participants']         = false;
                                        } else {
                                            $ProductOptionPricingTiers = ProductOptionPricingTiers::where(['product_id' => $product_id, 'option_id' => $option_id, 'pricing_id' => $ProductOptionPricing->id, 'pricing_details_id' => $POPD['id'], 'type' => 'adult'])->where('from_no_of_people', '<=', $adult)->where('no_of_people', '>=', $adult)->first();

                                            if ($ProductOptionPricingTiers) {
                                                $adultData = [];
                                                $adultData['title'] = "Adult";
                                                $adultData['totalParticipants'] = $adult;
                                                $retail_price = $ProductOptionPricingTiers->retail_price;

                                                $adultData['booking_category'] = $POPD['booking_category'];


                                                if ($POPD['booking_category'] == 'free' || $POPD['booking_category'] == 'free_no_ticket') {
                                                    $retail_price = 0;
                                                }
                                                $beforeDiscountAdultPrice = $retail_price * $adult;
                                                $beforeDiscountAmount += $beforeDiscountAdultPrice;
                                                if ($percentage > 0) {
                                                    $percentageAmount = ($retail_price * $percentage) / 100;
                                                    $retail_price  = $retail_price - $percentageAmount;
                                                }
                                                $adultPrice = $retail_price * $adult;
                                                $adultData['pricePerPerson'] = $retail_price;

                                                $adultData['totalPrice'] = round($adultPrice, 2);
                                                $totalAmount += $adultPrice;
                                                $adultData['formattedValue'] = get_price_front($product_id, '', '', '', $adultPrice);
                                                $price_brakdown[] = $adultData;
                                            }
                                        }
                                    }
                                    if (isset($child) && $child > 0 && $POPD['person_type']  == 'child') {

                                        if ($POPD['booking_category'] == 'not_permitted') {
                                            $row['require_participants_msg']  = 'Child not permitted for this activity.';
                                            $row['require_participants']         = false;
                                        } else {
                                            $ProductOptionPricingTiersChild = ProductOptionPricingTiers::where(['product_id' => $product_id, 'option_id' => $option_id, 'pricing_id' => $ProductOptionPricing->id, 'type' => 'child'])->where('from_no_of_people', '<=', $child)->where('no_of_people', '>=', $child)->first();


                                            if (!$ProductOptionPricingTiersChild) {

                                                $ProductOptionPricingTiersChild = ProductOptionPricingTiers::where(['product_id' => $product_id, 'option_id' => $option_id, 'pricing_id' => $ProductOptionPricing->id, 'type' => 'adult'])->where('from_no_of_people', '<=', $child)->where('no_of_people', '>=', $child)->first();
                                            }

                                            if ($ProductOptionPricingTiersChild) {
                                                $childData = [];
                                                $childData['title'] = "Children";
                                                $childData['totalParticipants'] = $child;

                                                $childData['booking_category'] = $POPD['booking_category'];



                                                $retail_price = $ProductOptionPricingTiersChild->retail_price;
                                                if ($POPD['booking_category'] == 'free' || $POPD['booking_category'] == 'free_no_ticket') {
                                                    $retail_price = 0;
                                                }
                                                $beforeDiscountChildPrice = $retail_price * $child;
                                                $beforeDiscountAmount += $beforeDiscountChildPrice;


                                                if ($percentage > 0) {
                                                    $percentageAmount = ($retail_price * $percentage) / 100;
                                                    $retail_price  = $retail_price - $percentageAmount;
                                                }
                                                $childPrice = $retail_price * $child;
                                                $childData['pricePerPerson'] = $retail_price;

                                                $childData['totalPrice'] =  round($childPrice, 2);
                                                $totalAmount += $childPrice;
                                                $childData['formattedValue'] = get_price_front($product_id, '', '', '', $childPrice);
                                                $price_brakdown[] = $childData;
                                            }
                                        }
                                    }

                                    if (isset($infant) && $infant > 0 && $POPD['person_type']  == 'infant') {

                                        if ($POPD['booking_category'] == 'not_permitted') {
                                            $row['require_participants_msg']  = 'Infant not permitted for this activity.';
                                            $row['require_participants']         = false;
                                        } else {
                                            $ProductOptionPricingTiersInfant = ProductOptionPricingTiers::where(['product_id' => $product_id, 'option_id' => $option_id, 'pricing_id' => $ProductOptionPricing->id, 'type' => 'infant'])->where('from_no_of_people', '<=', $infant)->where('no_of_people', '>=', $infant)->first();

                                            if (!$ProductOptionPricingTiersInfant) {
                                                $ProductOptionPricingTiersInfant = ProductOptionPricingTiers::where(['product_id' => $product_id, 'option_id' => $option_id, 'pricing_id' => $ProductOptionPricing->id, 'type' => 'adult'])->where('from_no_of_people', '<=', $infant)->where('no_of_people', '>=', $infant)->first();
                                            }

                                            if ($ProductOptionPricingTiersInfant) {
                                                $infantData = [];
                                                $infantData['title'] = "Infant";
                                                $infantData['totalParticipants'] = $infant;

                                                $infantData['booking_category'] = $POPD['booking_category'];



                                                $retail_price = $ProductOptionPricingTiersInfant->retail_price;
                                                if ($POPD['booking_category'] == 'free' || $POPD['booking_category'] == 'free_no_ticket') {
                                                    $retail_price = 0;
                                                }
                                                $beforeDiscountinfantPrice = $retail_price * $infant;
                                                $beforeDiscountAmount += $beforeDiscountinfantPrice;

                                                if ($percentage > 0) {
                                                    $percentageAmount = ($retail_price * $percentage) / 100;
                                                    $retail_price  = $retail_price - $percentageAmount;
                                                }
                                                $infantPrice = $retail_price * $infant;
                                                $infantData['pricePerPerson'] = $retail_price;



                                                $infantData['totalPrice'] =  round($infantPrice, 2);
                                                $totalAmount += $infantPrice;
                                                $infantData['formattedValue'] = get_price_front($product_id, '', '', '', $infantPrice);
                                                $price_brakdown[] = $infantData;
                                            }
                                        }
                                    }
                                } else {

                                    $ProductOptionPricingTiers = ProductOptionPricingTiers::where(['product_id' => $product_id, 'option_id' => $option_id, 'pricing_id' => $ProductOptionPricing->id, 'pricing_details_id' => $POPD['id'], 'type' => 'group'])->where('from_no_of_people', '<=', $total)->where('no_of_people', '>=', $total)->first();

                                    if ($ProductOptionPricingTiers) {
                                        $groupData = [];
                                        $groupData['title'] = "Participants";
                                        $groupData['totalParticipants'] = $total;

                                        $retail_price = $ProductOptionPricingTiers->retail_price;
                                        $beforeDiscountGroupPrice = $retail_price;
                                        $beforeDiscountAmount += $beforeDiscountGroupPrice;
                                        if ($percentage > 0) {
                                            $percentageAmount = ($retail_price * $percentage) / 100;
                                            $retail_price  = $retail_price - $percentageAmount;
                                        }
                                        $groupPrice = $retail_price;
                                        $groupData['pricePerPerson'] = $retail_price;

                                        $groupData['totalPrice'] =  round($groupPrice, 2);
                                        $totalAmount += $groupPrice;
                                        $groupData['formattedValue'] = get_price_front($product_id, '', '', '', $groupPrice);
                                        $price_brakdown[] = $groupData;
                                    }
                                }
                            } else {
                                $row['require_participants_msg']  = 'This date is not available. Please select a different date.';
                                $row['require_participants']         = false;
                            }
                        }



                        $get_product['price_brakdown'] = $price_brakdown;
                        $finalTotalAmount = $totalAmount;
                        $get_product['totalAmount'] = $totalAmount;

                        $get_product['tax'] = [];

                        // Check Tax Amount
                        if ($totalAmount > 0) {
                            // print_r($get_product);
                            $tax_title = ['product_tax_title', 'category_tax_title', 'destination_tax_title'];
                            $tax_title = getPagemeta($tax_title, $language_id, '');
                            $User = User::find($user_id);

                            $destinationTaxAmount = 0;
                            $categoryTaxAmount = 0;
                            $all_tax = [];
                            // For Destination Tax
                            if ($User) {
                                $destinationTax = "";
                                $tax = "";
                                $UserCountry = $User->country;
                                $UserState   = $User->state;
                                $UserCity    = $User->city;

                                $tax  = Tax::where(['country' => $UserCountry])->first();
                                if ($tax) {
                                    $destinationTax = $tax;
                                }
                                $tax  = Tax::where(['country' => $UserCountry, 'state' => $UserState])->first();
                                if ($tax) {
                                    $destinationTax = $tax;
                                }
                                $tax  = Tax::where(['country' => $UserCountry, 'state' => $UserState, 'city' => $UserCity])->first();
                                if ($tax) {
                                    $destinationTax = $tax;
                                }
                                if ($destinationTax != "") {
                                    $detinationTitle = "Destination Tax";

                                    $TaxDescription = TaxDescription::where(['tax_id' => $destinationTax->id, 'language_id' => $language_id])->first();
                                    if ($TaxDescription) {
                                        if ($TaxDescription->title != "") {
                                            $detinationTitle = $TaxDescription->title;
                                        }
                                    }

                                    $all_tax['title'] = $detinationTitle;
                                    $all_tax['type'] = $destinationTax->tax_type;
                                    $all_tax['basic'] = $destinationTax->amount;
                                    if ($destinationTax->tax_type == "percentage") {


                                        $percentageDestinationAmount = ($finalTotalAmount * $destinationTax->amount) / 100;


                                        $destinationTaxAmount = $percentageDestinationAmount;
                                    } else {
                                        $destinationTaxAmount = $destinationTax->amount;
                                    }

                                    $TotalTaxAmount +=   $destinationTaxAmount;

                                    $all_tax['format_amount'] = get_price_front('', '', '', '', $destinationTaxAmount);
                                    $get_product['tax'][] = $all_tax;
                                }
                            }

                            // For Category tax
                            if ($Product->category != "") {
                                $categoryTax  = Tax::where(['category' => $Product->category])->first();
                                if ($categoryTax != "") {
                                    $categoryTitle = "Category Tax";

                                    $TaxDescription = TaxDescription::where(['tax_id' => $categoryTax->id, 'language_id' => $language_id])->first();
                                    if ($TaxDescription) {
                                        if ($TaxDescription->title != "") {
                                            $categoryTitle = $TaxDescription->title;
                                        }
                                    }

                                    $all_tax['title'] = $categoryTitle;
                                    $all_tax['type'] = $categoryTax->tax_type;
                                    $all_tax['basic'] = $categoryTax->amount;
                                    if ($categoryTax->tax_type == "percentage") {


                                        $percentageDestinationAmount = ($finalTotalAmount * $categoryTax->amount) / 100;


                                        $categoryTaxAmount = $percentageDestinationAmount;
                                    } else {
                                        $categoryTaxAmount = $categoryTax->amount;
                                    }
                                    $TotalTaxAmount +=  $categoryTaxAmount;

                                    $all_tax['format_amount'] = get_price_front('', '', '', '', $categoryTaxAmount);
                                    $get_product['tax'][] = $all_tax;
                                }
                            }

                            // For Product Tax
                            if ($Product->id != "") {
                                $productTax  = Tax::where(['products' => $Product->id])->first();
                                if ($productTax != "") {
                                    $categoryTitle = "Product Tax";

                                    $TaxDescription = TaxDescription::where(['tax_id' => $productTax->id, 'language_id' => $language_id])->first();
                                    if ($TaxDescription) {
                                        if ($TaxDescription->title != "") {
                                            $categoryTitle = $TaxDescription->title;
                                        }
                                    }

                                    $all_tax['title'] = $categoryTitle;
                                    $all_tax['type'] = $productTax->tax_type;
                                    $all_tax['basic'] = $productTax->amount;
                                    if ($productTax->tax_type == "percentage") {


                                        $percentageDestinationAmount = ($finalTotalAmount * $productTax->amount) / 100;


                                        $productTaxAmount = $percentageDestinationAmount;
                                    } else {
                                        $productTaxAmount = $productTax->amount;
                                    }

                                    $TotalTaxAmount +=    $productTaxAmount;

                                    $all_tax['format_amount'] = get_price_front('', '', '', '', $productTaxAmount);
                                    $get_product['tax'][] = $all_tax;
                                }
                            }
                            $ProductDescriptionTitle = $ProductDescription['title']      != "" ? $ProductDescription['title'] : "No Title";
                            $cart_tax_fee['amount'] =  get_price_front('', '', '', '', $TotalTaxAmount + $totalAmount);
                            $cart_tax_fee['title'] =   $ProductDescriptionTitle;

                            $data['cart_tax_fee'][] = $cart_tax_fee;
                        }


                        $get_product['total_tax'] = $TotalTaxAmount;
                        $get_product['total_tax_format'] =  get_price_front('', '', '', '', $TotalTaxAmount);
                        $finalTaxAmount += $TotalTaxAmount;
                        $cartSubTotalAmount += $totalAmount;
                        $cartTotalAmount += $totalAmount + $TotalTaxAmount;

                        if ($is_hotel == 0) {

                            if ($getUser) {
                                $get_commission_arr['product_amount'] = $totalAmount;
                                $get_commission_arr['order_index'] = $ATCkey;
                                // totalAmount
                                $get_commission_arr['commission_amount'] = round(($totalAmount / 100) * $affiliate_commission, 2);
                                $totalCommission += ($totalAmount / 100) * $affiliate_commission;
                                $AffilliateCommissionArr[] = $get_commission_arr;
                                $get_product['affilliate_commission'] = $get_commission_arr;
                            }
                        }

                        if ($is_hotel == 1) {
                            $get_hotel_commission_arr['product_amount'] = $totalAmount;
                            $get_hotel_commission_arr['order_index'] = $ATCkey;

                            // totalAmount
                            $get_hotel_commission_arr['commission_amount'] = round(($totalAmount / 100) * $hotel_commission, 2);
                            $totalCommission += ($totalAmount / 100) * $hotel_commission;
                            $HotelCommissionArr[] = $get_hotel_commission_arr;
                            $get_product['hotel_commission'] = $get_hotel_commission_arr;
                        }



                        if (isset($JSON->added_by)) {
                            if ($JSON->added_by == "partner") {
                                $get_admin_partner_commission_arr['product_amount'] = $totalAmount;
                                $get_admin_partner_commission_arr['admin_commission_amount'] = $admin_commission_amount =  round(($totalAmount / 100) * $AdminCommission, 2);

                                $get_admin_partner_commission_arr['partner_amount'] = $partner_amount =  round($totalAmount - $admin_commission_amount, 2);
                                $totalAdminCommission += $admin_commission_amount;
                                $totalPartnerAmount += $partner_amount;
                                $partnerProductTotal += $totalAmount;

                                $AdminCommissionArr[$JSON->partner_id][] = $get_admin_partner_commission_arr;
                                $get_product['partner_commission'] = $get_admin_partner_commission_arr;
                            }
                        }


                        $OldAdminCommissionArr = $AdminCommissionArr;
                        $get_product['formatTotalAmount'] = get_price_front($product_id, '', '', '', $totalAmount);

                        if ($percentage > 0) {
                            $get_product['deal']['originalPrice'] = $beforeDiscountAmount;
                            $get_product['deal']['percentage'] = $percentage;
                            $percentageAmount = ($beforeDiscountAmount * $percentage) / 100;
                            $totalAmount  = $beforeDiscountAmount - $percentageAmount;
                            $get_product['deal']['formatTotalAmount'] = get_price_front($product_id, '', '', '', $totalAmount);
                            $row['deal']['formatoriginalPrice'] = get_price_front($product_id, '', '', '', $beforeDiscountAmount);
                        } else {
                            $get_product['deal'] = '';
                        }
                    }

                    if ($totalAmount > 0) {
                        if ($coupon) {
                            if ($coupon->coupon_type == "product") {
                                // $coupon_ids_arr[$product_id] = 0;
                                $coupon_ids_arr[$product_id]   = isset($coupon_ids_arr[$product_id])   ? $coupon_ids_arr[$product_id]   + $totalAmount  : $totalAmount;
                                $coupon_ids_count[$product_id] = isset($coupon_ids_count[$product_id]) ? $coupon_ids_count[$product_id] + 1   : 1;
                            }
                            if ($coupon->coupon_type == "category") {
                                // $coupon_ids_arr[$product_id] = 0;
                                $coupon_ids_arr[$Product->category]   = isset($coupon_ids_arr[$Product->category])   ? $coupon_ids_arr[$Product->category]   + $totalAmount  : $totalAmount;
                                $coupon_ids_count[$Product->category] = isset($coupon_ids_count[$Product->category]) ? $coupon_ids_count[$Product->category] + 1   : 1;
                            }
                            if ($coupon->coupon_type == "partner") {
                                // $coupon_ids_arr[$product_id] = 0;
                                $coupon_ids_arr[$Product->partner_id]   = isset($coupon_ids_arr[$Product->partner_id])   ? $coupon_ids_arr[$Product->partner_id]   + $totalAmount  : $totalAmount;
                                $coupon_ids_count[$Product->partner_id] = isset($coupon_ids_count[$Product->partner_id]) ? $coupon_ids_count[$Product->partner_id] + 1   : 1;
                            }

                            if ($coupon->coupon_type == "affilliate") {

                                // $coupon_ids_arr[$product_id] = 0;
                                $coupon_ids_arr[$coupon->value]   = isset($coupon_ids_arr[$coupon->value])   ? $coupon_ids_arr[$coupon->value]   + $totalAmount  : $totalAmount;
                                $coupon_ids_count[$coupon->value] = isset($coupon_ids_count[$coupon->value]) ? $coupon_ids_count[$coupon->value] + 1   : 1;
                            }
                        }
                        $data['amnt'] = $coupon_ids_arr;
                        $data['coupon_ids_count'] = $coupon_ids_count;
                        $data['detail'][]  =  $get_product;
                    }
                }
            }

            // if (isset($data['detail'])) {

            //     $data['detail']  = array_reverse($data['detail']);
            // } else {
            //     $data['detail'] = [];
            // }



            // return $coupon_ids_arr;
            if (count($coupon_ids_arr) > 0) {
                $cartSubTotalAmount = 0; //237.5 + 237.5 + 
                $finalTaxAmount = 0;
                $cartTotalAmount = 0;
                $totalCommission = 0;
                $AffilliateCommissionArr = [];
                $HotelCommissionArr = [];

                $AdminCommissionArr = [];

                $totalAdminCommission = 0;
                $totalPartnerAmount   = 0;
                $partnerProductTotal  = 0;


                foreach ($coupon_ids_arr as $coupon_ids_arr_key => $coupon_ids_amnt) {
                    if ($is_coupon == 1) {

                        foreach ($data['detail'] as $Dkey => $D) {
                            $get_commission_arr = [];
                            $get_hotel_commission_arr = [];

                            $newProductTaxAmount = 0;
                            $get_admin_partner_commission_arr = [];

                            if ($coupon->coupon_type == "category") {
                                $check_id_arr_type = $D['category'];
                            }
                            if ($coupon->coupon_type == "product") {
                                $check_id_arr_type = $D['product_id'];
                            }
                            if ($coupon->coupon_type == "partner") {
                                $check_id_arr_type = $D['partner_id'];
                            }

                            if ($coupon->coupon_type == "affilliate") {
                                $check_id_arr_type = $getAffilliateUser->id;
                            }


                            if ($is_hotel == 0) {
                                if ($getUser) {
                                    $Settings = Settings::where('meta_title', 'affilliate_commission')->first();
                                    $affiliate_commission = 0;
                                    $Product = Product::find($D['product_id']);
                                    if ($Product->affiliate_commission != "") {
                                        $affiliate_commission = $Product->affiliate_commission;
                                    } else if ($user_affiliate_commission != "") {
                                        $affiliate_commission = $user_affiliate_commission;
                                    } else if ($Settings->content != "") {
                                        $affiliate_commission = $Settings->content;
                                    }
                                }
                            }

                            if ($is_hotel == 1) {
                                $hotel_commission = 0;
                                $Hotel_Commission = $Hotel->hotel_commission;
                                if ($HotelCommission != "") {
                                    $hotel_commission = $Hotel_Commission;
                                }
                            }


                            $AdminCommission = 0;
                            if ($D['added_by'] == 'partner') {

                                $User  = User::find($D['partner_id']);
                                $Settings = Settings::where('meta_title', 'admin_commission')->first();

                                if ($User->partner_commission != "") {
                                    $AdminCommission = $User->partner_commission;
                                } elseif ($Settings->content != "") {
                                    $AdminCommission = $Settings->content;
                                }
                            }


                            if ($coupon_ids_arr_key == $check_id_arr_type) {
                                if ($coupon_ids_amnt >= $coupon->minimum_amount) {

                                    if ($is_hotel == 0) {
                                        if ($getUser) {
                                            $get_commission_arr['product_id']   = $D['product_id'];
                                            $get_commission_arr['product_name'] = $D['title'];
                                            $get_commission_arr['commission']   = $affiliate_commission;
                                        }
                                        // echo $D['title'] . "***";
                                    }

                                    if ($is_hotel == 1) {
                                        $get_hotel_commission_arr['product_id']   =  $D['product_id'];
                                        $get_hotel_commission_arr['product_name'] = $D['title'];
                                        $get_hotel_commission_arr['commission']   = $hotel_commission;
                                    }


                                    if ($D['added_by'] == 'partner') {
                                        $get_admin_partner_commission_arr['product_id']   = $D['product_id'];
                                        $get_admin_partner_commission_arr['product_name'] = $D['title'];
                                        $get_admin_partner_commission_arr['commission']   = $AdminCommission;
                                        $get_admin_partner_commission_arr['order_index']  = $Dkey;
                                    }

                                    if ($coupon->coupon_type == "category" && $coupon_ids_arr_key == $coupon->value) {

                                        if ($coupon_ids_arr_key == $D['category']) {
                                            $coupon_amount = $coupon->coupon_amount / $coupon_ids_count[$coupon_ids_arr_key];
                                            $couponText =  "Coupon Appiled (#" . $coupon->code . " " . round($coupon_amount, 2) . ")";
                                            if ($coupon->coupon_amount_type == "percentage") {
                                                $coupon_amount = $coupon->coupon_amount;
                                                $couponText         = "Coupon Applied(#" . $coupon->code . " " . round($coupon_amount, 2) . "%)";
                                                $coupon_amount      = ($D['totalAmount'] * $coupon_amount) / 100;
                                            }

                                            // $D['totalAmount'] = $D['totalAmount'] - $coupon_amount;
                                            $taxTotalAmount = $D['totalAmount'] - $coupon_amount;
                                            if ($taxTotalAmount < 0) {
                                                $taxTotalAmount = 0;
                                            }
                                            $D['after_coupon_discount'] =  get_price_front('', '', '', '', $taxTotalAmount);
                                            $cartSubTotalAmount += $D['totalAmount'];
                                            $D['coupon_amount_format'] =  get_price_front('', '', '', '', round($coupon_amount, 2));
                                            $D['coupon_amount'] =  round($coupon_amount, 2);
                                            $couponTotalAmount +=  round($coupon_amount, 2);
                                            $D['couponText']    = $couponText;



                                            if ($is_hotel == 0) {
                                                if ($getUser) {
                                                    $get_commission_arr['product_amount'] = $taxTotalAmount;
                                                    $get_commission_arr['order_index'] = $Dkey;
                                                    // totalAmount
                                                    $get_commission_arr['commission_amount'] = round(($taxTotalAmount / 100) * $affiliate_commission, 2);
                                                    $totalCommission += ($taxTotalAmount / 100) * $affiliate_commission;
                                                    $AffilliateCommissionArr[] = $get_commission_arr;
                                                    $D['affilliate_commission'] = $get_commission_arr;
                                                }
                                            }

                                            if ($is_hotel == 1) {
                                                $get_hotel_commission_arr['product_amount'] = $totalAmount;
                                                $get_hotel_commission_arr['order_index'] = $Dkey;
                                                // totalAmount
                                                $get_hotel_commission_arr['commission_amount'] = round(($totalAmount / 100) * $hotel_commission, 2);
                                                $totalCommission += ($totalAmount / 100) * $hotel_commission;
                                                $HotelCommissionArr[] = $get_hotel_commission_arr;
                                                $D['hotel_commission'] = $get_hotel_commission_arr;
                                            }

                                            if ($D['added_by'] == "partner") {
                                                $get_admin_partner_commission_arr['product_amount'] = $taxTotalAmount;
                                                $get_admin_partner_commission_arr['admin_commission_amount'] = $admin_commission_amount =  round(($taxTotalAmount / 100) * $AdminCommission, 2);

                                                $get_admin_partner_commission_arr['partner_amount'] = $partner_amount =  round($taxTotalAmount - $admin_commission_amount, 2);


                                                $AdminCommissionArr[$D['partner_id']][] = $get_admin_partner_commission_arr;
                                                $D['partner_commission'] = $get_admin_partner_commission_arr;
                                            }


                                            $productTaxAmount = 0;
                                            foreach ($D['tax'] as $Tkey => $T) {
                                                $productTaxAmount  = $T['basic'];
                                                if ($T['type'] == "percentage") {
                                                    $percentageAmount = ($taxTotalAmount * $T['basic']) / 100;
                                                    $productTaxAmount = $percentageAmount;
                                                }
                                                $finalTaxAmount += $productTaxAmount;
                                                $newProductTaxAmount += $productTaxAmount;
                                                $D['tax'][$Tkey]['format_amount'] = get_price_front('', '', '', '', $productTaxAmount);
                                            }

                                            $D['total_tax'] = $newProductTaxAmount;
                                            $D['total_tax_format'] =  get_price_front('', '', '', '', $newProductTaxAmount);
                                            $cartTotalAmount +=  $D['totalAmount'] + $newProductTaxAmount;
                                            // echo $cartTotalAmount . "--TAx--";
                                            $D['cartTotalAmount'] = $cartTotalAmount;
                                            $data['detail'][$Dkey]   = $D;
                                        }
                                    } elseif ($coupon->coupon_type == "product" && $coupon_ids_arr_key == $coupon->value) {

                                        if ($coupon_ids_arr_key == $D['product_id']) {
                                            $coupon_amount = $coupon->coupon_amount / $coupon_ids_count[$coupon_ids_arr_key];
                                            $couponText =  "Coupon Appiled (#" . $coupon->code . " " . round($coupon_amount, 2) . ")";
                                            if ($coupon->coupon_amount_type == "percentage") {
                                                $coupon_amount = $coupon->coupon_amount;
                                                $couponText         = "Coupon Applied(#" . $coupon->code . " " . round($coupon_amount, 2) . "%)";
                                                $coupon_amount      = ($D['totalAmount'] * $coupon_amount) / 100;
                                            }
                                            // $D['totalAmount'] = $D['totalAmount'] - $coupon_amount;
                                            $taxTotalAmount = $D['totalAmount'] - $coupon_amount;
                                            if ($taxTotalAmount < 0) {
                                                $taxTotalAmount = 0;
                                            }
                                            $D['after_coupon_discount'] =  get_price_front('', '', '', '', $taxTotalAmount);
                                            $cartSubTotalAmount += $D['totalAmount'];
                                            $D['coupon_amount_format'] =  get_price_front('', '', '', '', round($coupon_amount, 2));
                                            $D['coupon_amount'] =  round($coupon_amount, 2);
                                            $couponTotalAmount +=  round($coupon_amount, 2);
                                            $D['couponText']    = $couponText;


                                            if ($is_hotel == 0) {
                                                if ($getUser) {
                                                    $get_commission_arr['product_amount'] = $taxTotalAmount;
                                                    $get_commission_arr['order_index'] = $Dkey;
                                                    // totalAmount
                                                    $get_commission_arr['commission_amount'] = round(($taxTotalAmount / 100) * $affiliate_commission, 2);
                                                    $totalCommission += ($taxTotalAmount / 100) * $affiliate_commission;
                                                    $AffilliateCommissionArr[] = $get_commission_arr;
                                                    $D['affilliate_commission'] = $get_commission_arr;
                                                }
                                            }

                                            if ($is_hotel == 1) {
                                                $get_hotel_commission_arr['product_amount'] = $totalAmount;
                                                $get_hotel_commission_arr['order_index'] = $Dkey;
                                                // totalAmount
                                                $get_hotel_commission_arr['commission_amount'] = round(($totalAmount / 100) * $hotel_commission, 2);
                                                $totalCommission += ($totalAmount / 100) * $hotel_commission;
                                                $HotelCommissionArr[] = $get_hotel_commission_arr;
                                                $D['hotel_commission'] = $get_hotel_commission_arr;
                                            }




                                            if ($D['added_by'] == "partner") {
                                                $get_admin_partner_commission_arr['product_amount'] = $taxTotalAmount;
                                                $get_admin_partner_commission_arr['admin_commission_amount'] = $admin_commission_amount =  round(($taxTotalAmount / 100) * $AdminCommission, 2);

                                                $get_admin_partner_commission_arr['partner_amount'] = $partner_amount =  round($taxTotalAmount - $admin_commission_amount, 2);


                                                $AdminCommissionArr[$D['partner_id']][] = $get_admin_partner_commission_arr;
                                                $D['partner_commission'] = $get_admin_partner_commission_arr;
                                            }

                                            $productTaxAmount = 0;
                                            foreach ($D['tax'] as $Tkey => $T) {
                                                $productTaxAmount  = $T['basic'];
                                                if ($T['type'] == "percentage") {
                                                    $percentageAmount = ($taxTotalAmount * $T['basic']) / 100;
                                                    $productTaxAmount = $percentageAmount;
                                                }
                                                $finalTaxAmount += $productTaxAmount;
                                                $newProductTaxAmount += $productTaxAmount;
                                                $D['tax'][$Tkey]['format_amount'] = get_price_front('', '', '', '', $productTaxAmount);
                                            }

                                            $D['total_tax'] = $newProductTaxAmount;
                                            $D['total_tax_format'] =  get_price_front('', '', '', '', $newProductTaxAmount);
                                            $cartTotalAmount +=  $D['totalAmount'] + $newProductTaxAmount;
                                            $D['cartTotalAmount'] = $cartTotalAmount;
                                            // echo $cartTotalAmount . "--TAx--";

                                            $data['detail'][$Dkey]   = $D;
                                        }
                                    } elseif ($coupon->coupon_type == "partner" && $coupon_ids_arr_key == $coupon->value) {

                                        if ($coupon_ids_arr_key == $D['partner_id']) {
                                            $coupon_amount = $coupon->coupon_amount / $coupon_ids_count[$coupon_ids_arr_key];
                                            $couponText =  "Coupon Appiled (#" . $coupon->code . " " . round($coupon_amount, 2) . ")";
                                            if ($coupon->coupon_amount_type == "percentage") {
                                                $coupon_amount = $coupon->coupon_amount;
                                                $couponText         = "Coupon Applied(#" . $coupon->code . " " . round($coupon_amount, 2) . "%)";
                                                $coupon_amount      = ($D['totalAmount'] * $coupon_amount) / 100;
                                            }
                                            // $D['totalAmount'] = $D['totalAmount'] - $coupon_amount;
                                            $taxTotalAmount = $D['totalAmount'] - $coupon_amount;
                                            if ($taxTotalAmount < 0) {
                                                $taxTotalAmount = 0;
                                            }
                                            $D['after_coupon_discount'] =  get_price_front('', '', '', '', $taxTotalAmount);
                                            $cartSubTotalAmount += $D['totalAmount'];
                                            $D['coupon_amount_format'] =  get_price_front('', '', '', '', round($coupon_amount, 2));
                                            $D['coupon_amount'] =  round($coupon_amount, 2);
                                            $couponTotalAmount +=  round($coupon_amount, 2);
                                            $D['couponText']    = $couponText;


                                            if ($is_hotel == 0) {
                                                if ($getUser) {
                                                    $get_commission_arr['product_amount'] = $taxTotalAmount;
                                                    $get_commission_arr['order_index'] = $Dkey;
                                                    // totalAmount
                                                    $get_commission_arr['commission_amount'] = round(($taxTotalAmount / 100) * $affiliate_commission, 2);
                                                    $totalCommission += ($taxTotalAmount / 100) * $affiliate_commission;
                                                    $AffilliateCommissionArr[] = $get_commission_arr;
                                                    $D['affilliate_commission'] = $get_commission_arr;
                                                }
                                            }

                                            if ($is_hotel == 1) {
                                                $get_hotel_commission_arr['product_amount'] = $totalAmount;
                                                $get_hotel_commission_arr['order_index'] = $Dkey;
                                                // totalAmount
                                                $get_hotel_commission_arr['commission_amount'] = round(($totalAmount / 100) * $hotel_commission, 2);
                                                $totalCommission += ($totalAmount / 100) * $hotel_commission;
                                                $HotelCommissionArr[] = $get_hotel_commission_arr;
                                                $D['hotel_commission'] = $get_hotel_commission_arr;
                                            }





                                            if ($D['added_by'] == "partner") {
                                                $get_admin_partner_commission_arr['product_amount'] = $taxTotalAmount;
                                                $get_admin_partner_commission_arr['admin_commission_amount'] = $admin_commission_amount =  round(($taxTotalAmount / 100) * $AdminCommission, 2);

                                                $get_admin_partner_commission_arr['partner_amount'] = $partner_amount =  round($taxTotalAmount - $admin_commission_amount, 2);

                                                $AdminCommissionArr[$D['partner_id']][] = $get_admin_partner_commission_arr;
                                                $D['partner_commission'] = $get_admin_partner_commission_arr;
                                            }

                                            $productTaxAmount = 0;
                                            foreach ($D['tax'] as $Tkey => $T) {
                                                $productTaxAmount  = $T['basic'];
                                                if ($T['type'] == "percentage") {
                                                    $percentageAmount = ($taxTotalAmount * $T['basic']) / 100;
                                                    $productTaxAmount = $percentageAmount;
                                                }
                                                $finalTaxAmount += $productTaxAmount;
                                                $newProductTaxAmount += $productTaxAmount;
                                                $D['tax'][$Tkey]['format_amount'] = get_price_front('', '', '', '', $productTaxAmount);
                                            }

                                            $D['total_tax'] = $newProductTaxAmount;
                                            $D['total_tax_format'] =  get_price_front('', '', '', '', $newProductTaxAmount);
                                            $cartTotalAmount +=  $D['totalAmount'] + $newProductTaxAmount;
                                            $D['cartTotalAmount'] = $cartTotalAmount;
                                            // echo $cartTotalAmount . "--TAx--";

                                            $data['detail'][$Dkey]   = $D;
                                        }
                                    } elseif ($coupon->coupon_type == "affilliate" && $coupon_ids_arr_key == $coupon->value) {

                                        if ($coupon_ids_arr_key == $getAffilliateUser->id) {
                                            $coupon_amount = $coupon->coupon_amount / $coupon_ids_count[$coupon_ids_arr_key];
                                            $couponText =  "Coupon Appiled (#" . $coupon->code . " " . round($coupon_amount, 2) . ")";
                                            if ($coupon->coupon_amount_type == "percentage") {
                                                $coupon_amount = $coupon->coupon_amount;
                                                $couponText         = "Coupon Applied(#" . $coupon->code . " " . round($coupon_amount, 2) . "%)";
                                                $coupon_amount      = ($D['totalAmount'] * $coupon_amount) / 100;
                                            }
                                            // $D['totalAmount'] = $D['totalAmount'] - $coupon_amount;
                                            $taxTotalAmount = $D['totalAmount'] - $coupon_amount;
                                            if ($taxTotalAmount < 0) {
                                                $taxTotalAmount = 0;
                                            }
                                            $D['after_coupon_discount'] =  get_price_front('', '', '', '', $taxTotalAmount);
                                            $cartSubTotalAmount += $D['totalAmount'];
                                            $D['coupon_amount_format'] =  get_price_front('', '', '', '', round($coupon_amount, 2));
                                            $D['coupon_amount'] =  round($coupon_amount, 2);
                                            $couponTotalAmount +=  round($coupon_amount, 2);
                                            $D['couponText']    = $couponText;


                                            if ($is_hotel == 0) {
                                                if ($getUser) {
                                                    $get_commission_arr['product_amount'] = $taxTotalAmount;
                                                    $get_commission_arr['order_index'] = $Dkey;
                                                    // totalAmount
                                                    $get_commission_arr['commission_amount'] = round(($taxTotalAmount / 100) * $affiliate_commission, 2);
                                                    $totalCommission += ($taxTotalAmount / 100) * $affiliate_commission;
                                                    $AffilliateCommissionArr[] = $get_commission_arr;
                                                    $D['affilliate_commission'] = $get_commission_arr;
                                                }
                                            }

                                            if ($is_hotel == 1) {
                                                $get_hotel_commission_arr['product_amount'] = $totalAmount;
                                                $get_hotel_commission_arr['order_index'] = $Dkey;
                                                // totalAmount
                                                $get_hotel_commission_arr['commission_amount'] = round(($totalAmount / 100) * $hotel_commission, 2);
                                                $totalCommission += ($totalAmount / 100) * $hotel_commission;
                                                $HotelCommissionArr[] = $get_hotel_commission_arr;
                                                $D['hotel_commission'] = $get_hotel_commission_arr;
                                            }





                                            if ($D['added_by'] == "partner") {
                                                $get_admin_partner_commission_arr['product_amount'] = $taxTotalAmount;
                                                $get_admin_partner_commission_arr['admin_commission_amount'] = $admin_commission_amount =  round(($taxTotalAmount / 100) * $AdminCommission, 2);

                                                $get_admin_partner_commission_arr['partner_amount'] = $partner_amount =  round($taxTotalAmount - $admin_commission_amount, 2);

                                                $AdminCommissionArr[$D['partner_id']][] = $get_admin_partner_commission_arr;
                                                $D['partner_commission'] = $get_admin_partner_commission_arr;
                                            }

                                            $productTaxAmount = 0;
                                            foreach ($D['tax'] as $Tkey => $T) {
                                                $productTaxAmount  = $T['basic'];
                                                if ($T['type'] == "percentage") {
                                                    $percentageAmount = ($taxTotalAmount * $T['basic']) / 100;
                                                    $productTaxAmount = $percentageAmount;
                                                }
                                                $finalTaxAmount += $productTaxAmount;
                                                $newProductTaxAmount += $productTaxAmount;
                                                $D['tax'][$Tkey]['format_amount'] = get_price_front('', '', '', '', $productTaxAmount);
                                            }

                                            $D['total_tax'] = $newProductTaxAmount;
                                            $D['total_tax_format'] =  get_price_front('', '', '', '', $newProductTaxAmount);
                                            $cartTotalAmount +=  $D['totalAmount'] + $newProductTaxAmount;
                                            $D['cartTotalAmount'] = $cartTotalAmount;
                                            // echo $cartTotalAmount . "--TAx--";

                                            $data['detail'][$Dkey]   = $D;
                                        }
                                    } else {

                                        if ($is_hotel == 0) {
                                            if ($getUser) {
                                                $get_commission_arr['product_id']   = $D['product_id'];
                                                $get_commission_arr['product_name'] = $D['title'];
                                                $get_commission_arr['commission']   = $affiliate_commission;
                                            }
                                            // echo $D['title'] . "***";
                                        }

                                        if ($is_hotel == 1) {
                                            $get_hotel_commission_arr['product_id']   =  $D['product_id'];
                                            $get_hotel_commission_arr['product_name'] = $D['title'];
                                            $get_hotel_commission_arr['commission']   = $hotel_commission;
                                        }


                                        if ($D['added_by'] == 'partner') {
                                            $get_admin_partner_commission_arr['product_id']   = $D['product_id'];
                                            $get_admin_partner_commission_arr['product_name'] = $D['title'];
                                            $get_admin_partner_commission_arr['commission']   = $AdminCommission;
                                            $get_admin_partner_commission_arr['order_index']  = $Dkey;
                                        }

                                        $cartSubTotalAmount += $D['totalAmount'];
                                        $finalTaxAmount += $D['total_tax'];
                                        $cartTotalAmount +=  $D['totalAmount'] + $D['total_tax'];

                                        if ($is_hotel == 0) {
                                            if ($getUser) {
                                                $get_commission_arr['product_amount'] =  $D['totalAmount'];
                                                $get_commission_arr['order_index'] = $Dkey;
                                                // totalAmount
                                                $get_commission_arr['commission_amount'] = round(($D['totalAmount'] / 100) * $affiliate_commission, 2);
                                                $totalCommission += ($D['totalAmount'] / 100) * $affiliate_commission;
                                                $AffilliateCommissionArr[] = $get_commission_arr;
                                            }
                                        }

                                        if ($is_hotel == 1) {
                                            $get_hotel_commission_arr['product_amount'] =  $D['totalAmount'];
                                            $get_hotel_commission_arr['order_index'] = $Dkey;
                                            // totalAmount
                                            $get_hotel_commission_arr['commission_amount'] = round(($D['totalAmount'] / 100) * $hotel_commission, 2);
                                            $totalCommission += ($D['totalAmount'] / 100) * $hotel_commission;
                                            $HotelCommissionArr[] = $get_hotel_commission_arr;
                                        }

                                        if ($D['added_by'] == "partner") {

                                            if ($D['added_by'] == "partner") {
                                                $taxTotalAmount = $D['totalAmount'];
                                                $get_admin_partner_commission_arr['product_amount'] = $taxTotalAmount;
                                                $get_admin_partner_commission_arr['admin_commission_amount'] = $admin_commission_amount =  round(($taxTotalAmount / 100) * $AdminCommission, 2);

                                                $get_admin_partner_commission_arr['partner_amount'] = $partner_amount =  round($taxTotalAmount - $admin_commission_amount, 2);


                                                $AdminCommissionArr[$D['partner_id']][] = $get_admin_partner_commission_arr;
                                                $D['partner_commission'] = $get_admin_partner_commission_arr;
                                            }

                                            // $AdminCommissionArr[$D['partner_id']] = $OldAdminCommissionArr[$D['partner_id']];
                                        }
                                    }
                                } else {

                                    if ($is_hotel == 0) {
                                        if ($getUser) {
                                            $get_commission_arr['product_id']   = $D['product_id'];
                                            $get_commission_arr['product_name'] = $D['title'];
                                            $get_commission_arr['commission']   = $affiliate_commission;
                                        }
                                        // echo $D['title'] . "***";
                                    }

                                    if ($is_hotel == 1) {
                                        $get_hotel_commission_arr['product_id']   =  $D['product_id'];
                                        $get_hotel_commission_arr['product_name'] = $D['title'];
                                        $get_hotel_commission_arr['commission']   = $hotel_commission;
                                    }


                                    if ($D['added_by'] == 'partner') {
                                        $get_admin_partner_commission_arr['product_id']   = $D['product_id'];
                                        $get_admin_partner_commission_arr['product_name'] = $D['title'];
                                        $get_admin_partner_commission_arr['commission']   = $AdminCommission;
                                        $get_admin_partner_commission_arr['order_index']  = $Dkey;
                                    }



                                    $cartSubTotalAmount += $D['totalAmount'];
                                    $finalTaxAmount     += $D['total_tax'];
                                    $cartTotalAmount    += $D['totalAmount'] + $D['total_tax'];

                                    if ($is_hotel == 0) {
                                        if ($getUser) {
                                            $get_commission_arr['product_amount'] =  $D['totalAmount'];
                                            $get_commission_arr['order_index'] = $Dkey;
                                            // totalAmount
                                            $get_commission_arr['commission_amount'] = round(($D['totalAmount'] / 100) * $affiliate_commission, 2);
                                            $totalCommission += ($D['totalAmount'] / 100) * $affiliate_commission;
                                            $AffilliateCommissionArr[] = $get_commission_arr;
                                        }
                                    }

                                    if ($is_hotel == 1) {
                                        $get_hotel_commission_arr['product_amount'] =  $D['totalAmount'];
                                        $get_hotel_commission_arr['order_index'] = $Dkey;
                                        // totalAmount
                                        $get_hotel_commission_arr['commission_amount'] = round(($D['totalAmount'] / 100) * $hotel_commission, 2);
                                        $totalCommission += ($D['totalAmount'] / 100) * $hotel_commission;
                                        $HotelCommissionArr[] = $get_hotel_commission_arr;
                                    }


                                    if ($D['added_by'] == "partner") {
                                        $taxTotalAmount = $D['totalAmount'];
                                        $get_admin_partner_commission_arr['product_amount'] = $taxTotalAmount;
                                        $get_admin_partner_commission_arr['admin_commission_amount'] = $admin_commission_amount =  round(($taxTotalAmount / 100) * $AdminCommission, 2);

                                        $get_admin_partner_commission_arr['partner_amount'] = $partner_amount =  round($taxTotalAmount - $admin_commission_amount, 2);


                                        $AdminCommissionArr[$D['partner_id']][] = $get_admin_partner_commission_arr;
                                        $D['partner_commission'] = $get_admin_partner_commission_arr;
                                    }
                                }
                            }
                        }
                    }
                }
            }




            if ($cartTotalAmount > 0) {
                $checkout['amount']  = get_price_front('', '', '', '', $cartSubTotalAmount);
                $checkout['title']  = 'Sub Total';

                $data['checkout'][] = $checkout;

                if ($finalTaxAmount > 0) {
                    $checkout['amount']  =  get_price_front('', '', '', '', $finalTaxAmount);
                    $checkout['title']  = 'Total Tax';
                    $data['checkout'][] = $checkout;
                }

                if ($couponTotalAmount > 0) {
                    $checkout['amount']  =  get_price_front('', '', '', '', round($couponTotalAmount));
                    $checkout['title']  = 'Total Discount';
                    $data['checkout'][] = $checkout;
                }


                $checkout['amount']  = get_price_front('', '', '', '', $cartTotalAmount - $couponTotalAmount);
                $checkout['title']  = 'Total';

                $data['checkout'][] = $checkout;


                $cart_tax_fee['amount'] =  get_price_front('', '', '', '', $cartTotalAmount);
                $cart_tax_fee['title'] =  'Total (' . count($AddToCart) . ' item)';

                $data['cart_tax_fee'][] = $cart_tax_fee;


                // AddToCart::where('user_id', $user_id)->delete();
            }

            $lastOrder                = Orders::orderBy('id', 'desc')->first();
            $Orders                   = new Orders();
            $Orders['user_id']        = $user_id;
            $Orders['first_name']     = $request->first_name;
            $Orders['last_name']      = $request->last_name;
            $Orders['email']          = $request->email;
            $Orders['phone']          = $request->phone;
            $Orders['country']        = $request->country;
            $Orders['state']          = $request->state;
            $Orders['city']           = $request->city;
            $Orders['zipcode']        = $request->zipcode;
            $Orders['address']        = $request->address;
            $Orders['earning_type']   = $earning_type;
            $Orders['payment_method'] = $payment_method = $request->payment_method;

            $Orders['status']       =       $order_status = 'Pending';
            if ($payment_method == "paypal") {
                $Orders['payment_json']      = $request->paypal_details;
                $Orders['status']       = $order_status =  json_decode($request->paypal_details)->status == "COMPLETED"  ? "Success" : json_decode($request->paypal_details)->status;
            }
            if ($payment_method == "stripe") {
                $secret_key = 'sk_test_51NBViIJsssUGiiyHHpIOIDEDzBbstrsrJclmrJQlaOV98BduBHFl7UtTZWUMq2WUgcZV6E5f2Up4bVMAJENwqpYR004N7LXGJf';
                $getSettings = Settings::where('meta_title', 'stripe_secret_key')
                    ->where('child_meta_title', 'stripe_secret_key')
                    ->first();
                if ($getSettings) {
                    $secret_key = $getSettings['content'];
                }
                // print_die($secret_key);
                Stripe\Stripe::setApiKey($secret_key);
                $total_amount = $cartTotalAmount - $couponTotalAmount;
                $total_amount_100 = $total_amount * 100;
                $total_amount_100 = (int)$total_amount_100;
                $response = Stripe\Charge::create([
                    'amount'      => $total_amount_100,
                    'currency'    => 'usd',
                    'source'      => $request->stripe_token,
                    'description' => 'This payment is testing purpose of Infosparkles',
                ]);

                if ($response->status == 'succeeded') {

                    $order_status   = "Success";
                }
                $Orders['payment_json']      = $response;
                $Orders['status']       = $order_status;
            }


            $Orders['total_amount'] =  $cartTotalAmount - $couponTotalAmount;
            // $Orders['booking_date'] = $date;
            $Orders['order_json']   = json_encode($data);
            if (!$lastOrder) {
                $lastOrder = 0;
            } else {
                $lastOrder = $lastOrder->id;
            }
            $Orders['order_id'] = "MT-" .  $lastOrder + 1;

            $Orders->save();


            if ($order_status == "Success") {
                $email_data_array                   = [];

                $email_data_array['orders']    = $Orders;
                $email_data_array['products']  = json_decode($Orders['order_json']);
                $email_data_array['status']    = $order_status;
                $email_data_array['user_name'] = $request->first_name . ' ' . $request->last_name;
                $email_data_array['email']     = $request->email;
                $email_data_array['subject']   = 'Order Details';
                $email_data_array['page']      = 'email.order';


                Admin::send_mail($email_data_array);
            }


            if ($is_hotel == 0) {
                if ($getUser) {
                    $AffilliateCommission['product_json']    = json_encode($AffilliateCommissionArr);
                    $AffilliateCommission['affilliate_code'] = $AffilliateCode;
                    $AffilliateCommission['total']           = $totalCommission;
                    $AffilliateCommission['type']            = 'product';
                    $AffilliateCommission['status']          = $order_status;

                    $AffilliateCommission['order_id'] = $Orders->id;
                    if ($affilate_user > 0) {
                        $AffilliateCommission->save();
                    }

                    // Affiliate Order mail ---------------------------------
                    $get_affiliate_commission  = AffilliateCommission::where('id', $AffilliateCommission->id)->first();

                    if ($get_affiliate_commission) {
                        if ($order_status == 'Success') {
                            $email_array                   = [];

                            $email_array['products']            = json_decode($get_affiliate_commission['product_json']);
                            $email_array['affilliate_code']     = $get_affiliate_commission['affilliate_code'];
                            $email_array['total']               = $get_affiliate_commission['total'];


                            $get_orders = Orders::where(['id' => $get_affiliate_commission['order_id']])->first();
                            if ($get_orders) {
                                $email_array['order_id'] = $get_orders['order_id'];
                            }

                            $User = User::find($get_affiliate_commission['user_id']);
                            if ($User) {

                                $email_array['user_name']      = $User->first_name . ' ' . $User->last_name;
                                $email_array['email']          = $User->email;
                                $email_array['subject']        = 'Affiliate Commission';
                                $email_array['page']           = 'email.affiliate_commission';
                                Admin::send_mail($email_array);
                            }
                        }
                    }

                    if ($getUser) {
                        if ($getUser->user_type == "Affiliate") {
                            $getUser->total_commission += $totalCommission;
                        }
                        $getUser->save();
                    }
                }
            }


            if ($is_hotel == 1) {

                $HotelCommission['product_json']    = json_encode($HotelCommissionArr);
                $HotelCommission['total']           = $totalCommission;
                $HotelCommission['type']            = 'product';
                $HotelCommission['status']          = $order_status;

                $HotelCommission['order_id'] = $Orders->id;

                $HotelCommission->save();


                // Hotel Order mail ---------------------------------
                $get_hotel_commission  = HotelCommission::where('id', $HotelCommission->id)->first();

                if ($get_hotel_commission) {
                    if ($order_status == 'Success') {
                        $email_array                   = [];

                        $email_array['products']   = json_decode($get_hotel_commission['product_json']);
                        $email_array['total']      = $get_hotel_commission['total'];
                        $email_array['hotel_name'] = 'No Title';

                        $Hoteldescriptions  = Hoteldescriptions::where(['hotel_id' => $get_hotel_commission['hotel_id'], 'language_id' => $language_id])->first();
                        if ($Hoteldescriptions) {
                            $email_array['hotel_name'] = $Hoteldescriptions['hotel_name'];
                        }

                        $get_orders = Orders::where(['id' => $get_hotel_commission['order_id']])->first();
                        if ($get_orders) {
                            $email_array['order_id'] = $get_orders['order_id'];
                        }

                        $User = User::find($get_hotel_commission['hotel_id']);

                        if ($User) {

                            $email_array['user_name'] = $User->first_name . ' ' . $User->last_name;
                            $email_array['email']     = $User->email;
                            $email_array['subject']   = 'Hotel Commission';
                            $email_array['page']      = 'email.hotel_commission';
                            Admin::send_mail($email_array);


                            $User->total_commission += $totalCommission;
                            $User->save();
                        }
                    }
                }
            }


            // if ($totalPartnerAmount > 0) {

            foreach ($AdminCommissionArr as $ACAkey => $ACA) {

                $PartnerAdminCommission = new PartnerAdminCommission();
                $product_json = [];
                $totalPartnerAmount = 0;
                $partnerProductTotal = 0;
                $totalAdminCommission = 0;
                foreach ($ACA as $K => $ACAA) {
                    $ProductJsonArr = [];
                    $totalPartnerAmount += $ACAA['partner_amount'];
                    $partnerProductTotal += $ACAA['product_amount'];
                    $totalAdminCommission += $ACAA['admin_commission_amount'];
                    $product_json[] = $ACAA;
                }
                $PartnerAdminCommission['partner_id']             = $ACAkey;
                $PartnerAdminCommission['product_total']          = $partnerProductTotal;
                $PartnerAdminCommission['partner_total']          = $totalPartnerAmount;
                $PartnerAdminCommission['admin_total_commission'] = $totalAdminCommission;
                $PartnerAdminCommission['product_json']           = json_encode($product_json);
                $PartnerAdminCommission['type']                   = 'product';
                $PartnerAdminCommission['order_id']               = $Orders->id;
                $PartnerAdminCommission['status']                 = $order_status;
                $PartnerAdminCommission->save();

                // Order mail ---------------------------------
                $get_partner_commission  = PartnerAdminCommission::where('id', $PartnerAdminCommission->id)->first();

                if ($get_partner_commission) {
                    if ($get_partner_commission['status'] == 'Success') {
                        $email_data_array                   = [];

                        $email_data_array['products']                 = json_decode($get_partner_commission['product_json']);
                        $email_data_array['product_total']            = $get_partner_commission['product_total'];
                        $email_data_array['partner_total']            = $get_partner_commission['partner_total'];
                        $email_data_array['admin_total_commission']   = $get_partner_commission['admin_total_commission'];
                        $email_data_array['type']                     = $get_partner_commission['type'];
                        $email_data_array['status']                   = $get_partner_commission['status'];

                        $User = User::find($ACAkey);
                        $get_orders = Orders::where(['id' => $get_partner_commission['order_id']])->first();
                        if ($get_orders) {
                            $email_data_array['order_id'] = $get_orders['order_id'];
                        }


                        if ($User) {
                            $email_data_array['user_name']      = $User->first_name . ' ' . $User->last_name;
                            $email_data_array['email']          = $User->email;
                            $email_data_array['subject']        = 'Partner Commission';
                            $email_data_array['page']           = 'email.partner_commission';
                            Admin::send_mail($email_data_array);
                        }
                    }
                }


                $User  = User::find($ACAkey);
                if ($User) {
                    $User->total_commission += $totalPartnerAmount;
                    $User->save();
                }
            }


            $data['order_id']      = encrypt($Orders->id);
            $output['data']        = $data;
            $output['status']      = true;
            $output['status_code'] = 200;
            $output['message']     = "Order Successfully";
        }
        return json_encode($output);
    }

    public function upcoming_booking(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language'   => 'required',
            'currency'   => 'required',
            'user_id'    => 'required',
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


        $setLimit     = 10;
        $offset       = $request->offset;
        $limit        = $offset * $setLimit;
        $user_id     = $request->user_id;

        $Currentdate = strtotime(date('m/d/Y'));
        $Orders = Orders::where(['user_id' => $user_id])->orderBy('id', 'desc');

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



        $OrderList = [];
        foreach ($Orders as $Okey => $O) {
            $order_json = json_decode($O['order_json']);
            // dd($order_json);
            if ($order_json) {
                foreach ($order_json->detail as $OJkey => $OJ) {
                    $date = strtotime($OJ->date);

                    if ($date > $Currentdate) {
                        $OrderList[] = $O['id'];
                    }
                }
            }
        }
        $OrderData = [];
        $order_list = array_unique($OrderList);

        if (count($order_list) > 0) {
            foreach ($order_list as $OL) {
                $orderArr = [];
                $Orders = Orders::find($OL);
                if ($Orders) {
                    $orderArr['id']         = encrypt($Orders->id);
                    $orderArr['order_id']   = "#" . $Orders->order_id;
                    $orderArr['order_date'] = date("Y M,d", strtotime($Orders->created_at));
                    $orderArr['amount']     = $Orders->total_amount;
                    $orderArr['status']     = $Orders->status;
                    $orderArr['name']       = $Orders->first_name . " " . $Orders->last_name;
                    $orderArr['address']    = $Orders->address . '(' . $Orders->zipcode . ')';
                    $order_json             = json_decode($Orders->order_json);

                    if ($order_json) {
                        foreach ($order_json->detail as $OJkey => $OJ) {
                            $date = strtotime($OJ->date);

                            if ($date > $Currentdate) {
                                $orderArr['order_json'][] = $OJ;
                            }
                        }
                    }
                    $OrderData[]          = $orderArr;
                }
            }
            $OrderDataDetails = array_slice($OrderData, $limit, $setLimit);

            $output['page_count'] = ceil(count($OrderData) / $setLimit);
            $output['data']        = $OrderDataDetails;
            $output['status']      = true;
            $output['status_code'] = 200;
            $output['message']     = "Order Detail Fetched Successfully";
        }
        return json_encode($output);
    }

    public function booking_history(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language'   => 'required',
            'currency'   => 'required',
            'user_id'    => 'required',
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

        $Orders = Orders::where(['user_id' => $user_id]);

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



        $Orders = $Orders->orderBy('id', 'DESC')

            ->get();

        if (count($Orders) > 0) {
            foreach ($Orders as $OL) {
                $orderArr = [];

                $orderArr['id']         = encrypt($OL['id']);
                $orderArr['order_id']   = $OL['order_id'];
                $orderArr['order_date'] = date("Y M,d", strtotime($OL['created_at']));
                $orderArr['amount']     = $OL['total_amount'];
                $orderArr['status']     = $OL['status'];
                $orderArr['name']       = $OL['first_name'] . " " . $OL['last_name'];
                $orderArr['address']    = $OL['address'] . '(' . $OL['zipcode'] . ')';
                $order_json = json_decode($OL['order_json']);
                if ($order_json) {
                    foreach ($order_json->detail as $OJkey => $OJ) {
                        $orderArr['order_json'][] = $OJ;
                    }
                }
                $OrderData[]            = $orderArr;
            }
            $OrderDataDetails = array_slice($OrderData, $limit, $setLimit);


            $output['page_count'] = ceil(count($OrderData) / $setLimit);
            $output['data']        = $OrderDataDetails;
            $output['status']      = true;
            $output['status_code'] = 200;
            $output['message']     = "Order Detail Fetched Successfully";
        }

        // return json_encode($output);
        return response()->json($output);
    }



    // Order Details
    public function order_details(Request $request)
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

        $Orders = Orders::where(['id' => $order_id, 'user_id' => $user_id])->first();
        $orderData = [];
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
            $orderData['order_json']   = $order_json = json_decode($Orders->order_json);


            $newJson = [];
            // dd($order_json);
            if ($order_json) {
                foreach ($order_json->detail as $OJkey => $OJ) {
                    $cancel_msg = '';
                    $cancel_time_slot = '';
                    if (isset($OJ->option_details)) {
                        $date = date("Y-m-d", strtotime($OJ->date));
                        $ProductOption =  ProductOption::find($OJ->option_details->option_id);
                        if ($ProductOption) {
                            if ($ProductOption->is_cancelled == true) {
                                $product_id  = $OJ->product_id;
                                $option_id  = $OJ->option_details->option_id;
                                $new_date_time = "";
                                $cancel_msg = "";
                                $cancel_time = "";
                                $cancel_time_slot = "";
                                if ($OJ->time_slot != "") {
                                    $new_time =  Carbon::parse($OJ->time_slot)->format('H:i:s');
                                    $new_date_time = date('Y-m-d H:i:s', strtotime($OJ->date . " " . $new_time));
                                } else {
                                    $Parsedate = Carbon::parse($OJ->date)->subDay(1)->format('Y-m-d');
                                    $new_date_time = date('Y-m-d H:i:s', strtotime($Parsedate . " " . "23:59:59"));
                                }

                                if ($new_date_time != "") {
                                    if ($ProductOption->cancelled_type == "hour") {
                                        $cancel_time = date('Y-m-d H:i:s', strtotime($new_date_time . " -" . $ProductOption->cancelled_time . " hour"));
                                    }
                                    if ($ProductOption->cancelled_type == "day") {
                                        $cancel_time = date('Y-m-d H:i:s', strtotime($new_date_time . ' -' . $ProductOption->cancelled_time . ' day'));
                                    }
                                }
                                // }    
                                if ($cancel_time != "") {
                                    $cancel_msg = "Cancel before " . Carbon::parse($cancel_time)->format('g:i A') . " on " . date('M d', strtotime($cancel_time)) . " for a full refund";
                                    $cancel_time_slot = Carbon::parse($cancel_time)->format('g:i A');
                                }



                                if (strtotime($cancel_time) < strtotime(date("Y-m-d H:i:s"))) {
                                    $cancel_time = "";
                                    $cancel_msg = "";
                                    $cancel_time_slot = "";
                                }
                            }
                        }
                    }
                    $OJ->cancel_msg = $cancel_msg;
                    $OJ->cancel_time_slot = $cancel_time_slot;
                    $newJson[] = $OJ;
                }
            }
            $orderData['order_json']->detail = $newJson;


            $output['data']        = $orderData;
            $output['status']      = true;
            $output['status_code'] = 200;
            $output['message']     = "Order Detail Fetched Successfully";
        }
        return json_encode($output);
    }


    // Add review
    public function add_review(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Order not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language'    => 'required',
            'currency'    => 'required',
            'order_id'    => 'required',
            'product_id'  => 'required',
            'option_id'   => 'required',
            'order_index' => 'required',
            'rating'      => 'required',
            'title'       => 'required',
            'description' => 'required',
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
        $language_id = $request->language;
        $order_id    = checkDecrypt($request->order_id);
        $product_id  = $request->product_id;
        $option_id   = $request->option_id;
        $order_index = $request->order_index;
        $rating      = $request->rating;
        $title       = $request->title;
        $description = $request->description;
        $Orders      = Orders::where(['id' => $order_id, 'user_id' => $user_id])->first();
        $UserReview = UserReview::where(['order_id' => $order_id, 'user_id' => $user_id, 'option_id' => $option_id, 'order_index' => $order_index])->first();
        if (!$UserReview) {
            if ($Orders) {
                $check = 0;
                $orderJson = json_decode($Orders->order_json);
                foreach ($orderJson as $key => $value) {
                    if ($key == "detail") {
                        foreach ($value as $Vkey => $details) {
                            if ($Vkey == $order_index) {
                                $check = 1;
                                // dd($orderJson->$key[$Vkey]->is_review);
                                $orderJson->$key[$Vkey]->is_review = true;
                                $orderJson->$key[$Vkey]->rating = $rating;
                                $orderJson->$key[$Vkey]->review_title = $title;
                                $orderJson->$key[$Vkey]->review_description = $description;
                            }
                        }
                    }
                }
                $Orders->order_json = json_encode($orderJson);

                if ($check == 1) {
                    $UserReview                = new UserReview();
                    $UserReview['product_id']  = $product_id;
                    $UserReview['user_id']     = $user_id;
                    $UserReview['order_id']    = $order_id;
                    $UserReview['option_id']   = $option_id;
                    $UserReview['order_index'] = $order_index;
                    $UserReview['rating']      = $rating;
                    $UserReview['status']      = "Deactive";
                    $UserReview->save();
                    $Orders->save();

                    $UserReviewDescription = new UserReviewDescription();
                    $UserReviewDescription->review_id = $UserReview->id;
                    $UserReviewDescription->language_id = $language_id;
                    $UserReviewDescription->title = $title;
                    $UserReviewDescription->description = $description;
                    $UserReviewDescription->save();


                    $output['status']      = true;
                    $output['status_code'] = 200;
                    $output['message']     = "Review Submit Successfully";
                }
            }
        } else {
            $output['message']     = "Already review submitted!";
        }
        return json_encode($output);
    }


    // Cancel Product

    public function cancel_order(Request $request)
    {

        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Order not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language'    => 'required',
            'currency'    => 'required',
            'order_id'    => 'required',
            'product_id'  => 'required',
            'option_id'   => 'required',
            'order_index' => 'required',

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
        $language_id = $request->language;
        $order_id    = checkDecrypt($request->order_id);
        $product_id  = $request->product_id;
        $option_id   = $request->option_id;
        $order_index = $request->order_index;

        $OldSubTotalAmount      = 0;
        $OldTotalTaxAmount      = 0;
        $OldTotalDiscountAmount = 0;
        $OldTotalFinalAmount    = 0;
        $Orders                 = Orders::where(['id' => $order_id, 'user_id' => $user_id])->first();
        if ($Orders) {

            $orderJson = json_decode($Orders->order_json);
            foreach ($orderJson as $key => $value) {
                if ($key == "detail") {

                    foreach ($value as $Vkey => $details) {
                        $orderJson->$key[$Vkey]->is_cancel = 0;
                        if ($Vkey == $order_index) {

                            $CancelOrderHistory = new CancelOrderHistory();


                            // Check Hotel Commission
                            if (isset($details->hotel_commission)) {
                                $HotelCommission  = HotelCommission::where('order_id', $order_id)->first();
                                $TotalCommissionAmount = 0;
                                if ($HotelCommission) {
                                    $hotel_product_json = json_decode($HotelCommission->product_json);

                                    foreach ($hotel_product_json as $HPJkey => $HPJ) {
                                        $hotel_product_json[$HPJkey]->is_cancel = 0;

                                        if ($order_index == $HPJ->order_index) {
                                            $hotel_product_json[$HPJkey]->is_cancel = 1;
                                            $User = User::find($HotelCommission->hotel_id);
                                            if ($User) {
                                                $User->total_commission =  $User->total_commission - $HPJ->commission_amount;
                                                $User->save();

                                                $TransactionHistory = new TransactionHistory();
                                                $TransactionHistory->user_id  = $User->id;
                                                $TransactionHistory->user_type   = 'Hotel';
                                                $TransactionHistory->paid_amount   = $HPJ->commission_amount;
                                                $TransactionHistory->amount_type   = 'online';
                                                $TransactionHistory->description   = 'Order Cancel By User Order Id:' . $Orders->order_id . '';
                                                $TransactionHistory->trans_type   = 'Debited';

                                                $TransactionHistory->save();
                                            }
                                        } else {
                                            $TotalCommissionAmount += $HPJ->commission_amount;
                                        }
                                    }
                                    $HotelCommission->total = $TotalCommissionAmount;
                                    $HotelCommission->product_json = json_encode($hotel_product_json);
                                    $HotelCommission->save();
                                }
                            }

                            // Check Partner Commission
                            if (isset($details->partner_commission)) {
                                if ($details->added_by == "partner") {

                                    $PartnerAdminCommission = PartnerAdminCommission::where(['partner_id' => $details->partner_id, 'order_id' => $order_id])->first();
                                    $TotalProductTotal = 0;
                                    $TotalPartnerTotal = 0;
                                    $AdminTotalCommission = 0;
                                    if ($PartnerAdminCommission) {
                                        $partner_product_json = json_decode($PartnerAdminCommission->product_json);
                                        foreach ($partner_product_json as $PPJkey => $PPJ) {
                                            $partner_product_json[$PPJkey]->is_cancel = 0;
                                            if ($order_index == $PPJ->order_index) {
                                                $partner_product_json[$PPJkey]->is_cancel = 1;

                                                $User = User::find($PartnerAdminCommission->partner_id);
                                                if ($User) {
                                                    $User->total_commission =  $User->total_commission  - $PPJ->partner_amount;
                                                    $User->save();

                                                    $TransactionHistory              = new TransactionHistory();
                                                    $TransactionHistory->user_id     = $User->id;
                                                    $TransactionHistory->user_type   = 'Partner';
                                                    $TransactionHistory->paid_amount = $PPJ->partner_amount;
                                                    $TransactionHistory->amount_type = 'online';
                                                    $TransactionHistory->description = 'Order Cancel By User Order Id:' . $Orders->order_id . '';
                                                    $TransactionHistory->trans_type  = 'Debited';
                                                    $TransactionHistory->save();
                                                }
                                            } else {
                                                $TotalProductTotal += $PPJ->product_amount;
                                                $TotalPartnerTotal += $PPJ->partner_amount;
                                                $AdminTotalCommission += $PPJ->admin_commission_amount;
                                            }
                                        }
                                        $PartnerAdminCommission->product_total          = $TotalProductTotal;
                                        $PartnerAdminCommission->partner_total          = $TotalPartnerTotal;
                                        $PartnerAdminCommission->admin_total_commission = $AdminTotalCommission;
                                        $PartnerAdminCommission->product_json           = json_encode($partner_product_json);
                                        $PartnerAdminCommission->save();
                                    }
                                }
                            }

                            // Check Affilliate Commission
                            if (isset($details->affilliate_commission)) {
                                $AffilliateCommission  = AffilliateCommission::where('order_id', $order_id)->first();
                                $TotalAffilliateCommissionAmount = 0;
                                if ($AffilliateCommission) {
                                    $affilliate_product_json = json_decode($AffilliateCommission->product_json);

                                    foreach ($affilliate_product_json as $APJkey => $APJ) {
                                        $affilliate_product_json[$APJkey]->is_cancel = 0;
                                        if ($order_index == $APJ->order_index) {
                                            $affilliate_product_json[$APJkey]->is_cancel = 1;
                                            $User = User::find($AffilliateCommission->user_id);
                                            if ($User) {

                                                $User->total_commission =  $User->total_commission - $APJ->commission_amount;
                                                $User->save();


                                                $TransactionHistory              = new TransactionHistory();
                                                $TransactionHistory->user_id     = $User->id;
                                                $TransactionHistory->user_type   = 'Affiliate';
                                                $TransactionHistory->paid_amount = $APJ->commission_amount;
                                                $TransactionHistory->amount_type = 'online';
                                                $TransactionHistory->description = 'Order Cancel By User Order Id : ' . $Orders->order_id . '';
                                                $TransactionHistory->trans_type  = 'Debited';
                                                $TransactionHistory->save();
                                            }
                                        } else {
                                            $TotalAffilliateCommissionAmount += $APJ->commission_amount;
                                        }
                                    }
                                    $AffilliateCommission->total = $TotalAffilliateCommissionAmount;
                                    $AffilliateCommission->product_json = json_encode($affilliate_product_json);
                                    $AffilliateCommission->save();
                                }
                            }

                            $orderJson->$key[$Vkey]->is_cancel = 1;
                            $totalAmount = 0;
                            $total_tax = 0;
                            $coupon_amount = 0;
                            if (isset($details->totalAmount)) {
                                $totalAmount = $details->totalAmount;
                            }
                            if (isset($details->total_tax)) {

                                $total_tax = $details->total_tax;
                            }
                            if (isset($details->coupon_amount)) {
                                $coupon_amount = $details->coupon_amount;
                            }


                            $CancelOrderHistory->order_id      = $Orders->id;
                            $CancelOrderHistory->order_index   = $order_index;
                            $CancelOrderHistory->product_json  = json_encode($details);
                            $CancelOrderHistory->cancel_by     = 'user';
                            $CancelOrderHistory->payment_mode  = 'online';
                            $CancelOrderHistory->user_id       = $user_id;
                            $CancelOrderHistory->cancel_reason = 'Nothing';
                            $CancelOrderHistory->amount =  get_price_front("", "", "", "", (($totalAmount + $total_tax) - $coupon_amount));
                            $CancelOrderHistory->save();
                        } else {
                            if (isset($details->totalAmount)) {
                                $OldSubTotalAmount      += $details->totalAmount;
                            }
                            if (isset($details->total_tax)) {

                                $OldTotalTaxAmount      += $details->total_tax;
                            }
                            if (isset($details->coupon_amount)) {
                                $OldTotalDiscountAmount += $details->coupon_amount;
                            }
                        }
                    }
                }

                if ($key == 'checkout') {

                    foreach ($value as $Ckey => $checkout) {
                        if ($checkout->title == "Sub Total") {
                            $orderJson->$key[$Ckey]->amount = get_price_front("", "", "", "", $OldSubTotalAmount);
                        }

                        if ($checkout->title == "Total Tax") {
                            $orderJson->$key[$Ckey]->amount = get_price_front("", "", "", "", $OldTotalTaxAmount);
                        }

                        if ($checkout->title == "Total Discount") {
                            $orderJson->$key[$Ckey]->amount = get_price_front("", "", "", "", $OldTotalDiscountAmount);
                        }

                        if ($checkout->title == "Total") {
                            $orderJson->$key[$Ckey]->amount = get_price_front("", "", "", "", ($OldSubTotalAmount + $OldTotalTaxAmount) - $OldTotalDiscountAmount);
                        }
                    }
                }
            }
            $Orders->order_json = json_encode($orderJson);
            $Orders->total_amount  = get_price_front("", "", "", "", ($OldSubTotalAmount + $OldTotalTaxAmount) - $OldTotalDiscountAmount);

            $Orders->save();

            $output['status']      = true;
            $output['status_code'] = 200;
            $output['message']     = "Order Cancel Successfully";
        } else {
            $output['message']     = "Order Not Found!";
        }
        return json_encode($output);
    }
}
