<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\Language;
use App\Models\Product;
use App\Models\MetaGlobalLanguage;
use App\Models\TopDestinationLanguage;
use App\Models\ProductLanguage;
use App\Models\Currency;
use App\Models\CurrencyRates;
use App\Models\TopDestination;
use App\Models\HomeCount;
use App\Models\HomeCountLanguage;
use App\Models\TopTenSellerLanguage;
use App\Models\ProductSetting;
use App\Models\CarDetails;
use App\Models\ProductGroupPercentage;
use App\Models\ProductGroupPercentageDetails;
use App\Models\CarDetailLanguage;
use App\Models\TopTenSeller;
use App\Models\AddToCart;
use App\Models\ProductLodge;
use App\Models\ProductLodgePrice;
use App\Models\ProductLodgeLanguage;
use App\Models\ProductOptionTourUpgrade;
use App\Models\ProductOptionTaxServiceCharge;
use App\Models\ProductOptionPrivateTourPrice;
use App\Models\ProductOptionLanguage;
use App\Models\ProductTourPriceDetails;
use App\Models\CurrencySymbol;
use App\Models\ProductOptionGroupPercentage;
use App\Models\ProductOptionPeriodPricing;
use App\Models\HomeCountry;
use App\Models\HomeZone;
use App\Models\RewardsPoints;

use App\Models\ProductOptionWeekTour;
use App\Models\ProductGroupPercentageLanguage;
use App\Models\ProductOptionDetails;
use App\Models\TransportationVehicle;
use App\Models\Productyachttransferoption;
use App\Models\Productyachtwatersport;
use App\Models\ProductOptions;
use App\Models\AirportModel;
use App\Models\TransferZones;
use App\Models\Country;
use App\Models\City;
use App\Models\Zones;
use App\Models\Locations;
use App\Models\AffilliateCommission;
use App\Models\Admin;
use App\Models\User;

use App\Models\HomeSliderImages;

use App\Models\BannerOverview;
use App\Models\BannerOverviewLanguage;

use App\Models\HomeDestinationOverview;
use App\Models\HomeDestinationOverviewLanguage;

use App\Models\PageSliders;
use App\Models\PageSlidersLanguage;
use App\Models\ProductCheckout;

use App\Models\CouponCode;

use App\Models\ProductCheckoutGiftCard;
use App\Models\ProductVoucher;
use App\Models\ProductVoucherLanguage;
use App\Models\AllOrders;
use App\Models\UserWalletHistory;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ProductCheckoutController extends Controller
{
    public function product_checkout(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            'language' => 'required',
            'user_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone_code' => 'required',
            'phone_number' => 'required|numeric',
            'city' => 'required',
            'country' => 'required',
            'postcode' => 'required',
            'address' => 'required',
            'payment_method' => 'required',
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

        $token = $request->token;
        $language = $request->language;
        $user_id = $request->user_id;
        $reward_point_apply = $request->reward_point_apply;
        $giftcard_wallet_apply = $request->giftcard_wallet_apply;
        $tax = 0;
        $tax_amount = 0;
        $total_amount = 0;
        $grandTotal = 0;
        $no_tax_service_total_amnt = 0;
        $user_current_reward_points = 0;

        $data = [];
        $get_products = [];
        $data['grand_total'] = 0;
        $rewards_points_id_arr = [];
        $totalCommission = 0;
        // return $request->all();
        // where('token', $token)

        $user_current_reward_points = 0;
        if ($request->user_id) {
            $get_user = User::where('id', $user_id)
                ->where('status', 'Active')
                ->where('is_verified', 1)
                ->first();
            if ($get_user) {
                $user_current_reward_points = $get_user['current_reward_points'];
            }
        }
        $output['user_current_reward_points'] = $user_current_reward_points;

        $getCartItem = AddToCart::select('add_to_cart.*', 'products.point_to_purchase_product')
            ->leftjoin('products', 'products.id', '=', 'add_to_cart.product_id')
            ->where('user_id', $user_id)
            ->orderBy('products.point_to_purchase_product', 'DESC')
            ->get();

        $AffilliateCommissionArr = [];
        $AffilliateCommission = new AffilliateCommission();
        $AffilliateCode = isset($request->affilliate_code) ? $request->affilliate_code : '';
        if (!$getCartItem->isEmpty()) {
            $total_no_tax_service = 0;
            $total_tax = 0;
            $total_service_charge = 0;
            $affilate_user = 0;
            $total_client_rewards_points = 0;
            $total_reddem_client_rewards_points = 0;
            $gift_card_id_arr = [];

            $getUser = User::where('affiliate_code', $AffilliateCode)
                ->where('user_type', 'Affiliate')
                ->where('is_verified', 1)
                ->first();
            if ($getUser) {
                $affilate_user = $getUser['id'];
            }
            $AffilliateCommission['user_id'] = $affilate_user;
            foreach ($getCartItem as $key => $cart_value) {
                $get_commission_arr = [];
                $get_cart_item = [];
                $total_tax_per_product = 0;
                $total_service_per_product = 0;
                $total_tax_percentage_per_product = 0;
                $no_tax_service_total_amnt_per_product = 0;
                $product_id = $cart_value['product_id'];
                $activity_id = $cart_value['product_id'];
                $Product = Product::where('id', $product_id)->first();
                $get_cart_item['cart_id'] = $cart_value['id'];
                if ($Product) {
                    $forCommisontotalAmount = 0;
                    $totalAmount = 0;
                    $productLang = ProductLanguage::where(['product_id' => $product_id, 'language_id' => $language])->first();
                    $title = '';
                    $main_description = '';
                    if ($productLang) {
                        $title = $productLang->description;
                        $main_description = $productLang->main_description;
                    }
                    $get_cart_item['id'] = $Product['id'];
                    $get_cart_item['client_reward_point'] = $Product['client_reward_point'];
                    $get_cart_item['per_value'] = $Product['per_value'];
                    $get_cart_item['title'] = $title;
                    $get_cart_item['type'] = $cart_value['product_type'];
                    $get_cart_item['per_modifi_or_cancellation'] = $Product['per_modifi_or_cancellation'];
                    $get_cart_item['description'] = $main_description;
                    $get_cart_item['image'] = asset('uploads/product_images/' . $Product['image']);
                    $productPrice = $Product['selling_price'] !== '' ? $Product['selling_price'] : $Product['original_price'];

                    $get_cart_item['price'] = get_partners_dis_price(ConvertCurrency($productPrice), $product_id, $request->user_id, 'base_price', 'lodge');
                    $get_cart_item['option'] = [];
                    $get_cart_item['order_cancel'] = 0;
                    $get_cart_item['order_cancel_by'] = 'User';
                    $get_cart_item['order_cancel_time'] = '';
                    $point_to_purchase_product = $Product['point_to_purchase_product'];

                    //Cancllation Date Time
                    $get_cart_item['cancellation_up_to_time'] = get_cancelled_time($Product->can_be_cancelled_up_to_advance, date('Y-m-d h:i:s'), 'cancellation_up_to_time');
                    $get_cart_item['cancellation_up_to_time_stamp'] = get_cancelled_time($Product->can_be_cancelled_up_to_advance, date('Y-m-d h:i:s'), 'cancellation_up_to_time_stamp');
                    //Cancllation Date Time

                    //GEt Rewar POint in product
                    $get_cart_item['buy_on_reward_point'] = false;
                    $get_cart_item['reward_point_apply'] = false;
                    $get_cart_item['buy_on_reward_point_text'] = '';
                    $get_cart_item['reward_point_apply_text'] = '';
                    $get_cart_item['point_to_purchase_product'] = $point_to_purchase_product;

                    if ($user_current_reward_points > 0 && $point_to_purchase_product > 0) {
                        if ($user_current_reward_points >= $point_to_purchase_product) {
                            $user_current_reward_points = $user_current_reward_points - $point_to_purchase_product;
                            $get_cart_item['buy_on_reward_point'] = true;
                            $get_cart_item['buy_on_reward_point_text'] =
                                "<p class='reward_point_text'> Purchase This Product in <span class='rewardpoints'>" .
                                number_format($point_to_purchase_product, 2) .
                                "</span>
                                  Rewards points</p>    ";
                            if ($reward_point_apply == 'true') {
                                $get_cart_item['reward_point_apply'] = true;
                                $total_reddem_client_rewards_points += $point_to_purchase_product;
                                $get_cart_item['reward_point_apply_text'] = "<p class='reward_apply_point_text'> Purchase This Product in <span class='apply_rewardpoints'>" . number_format($point_to_purchase_product, 2) . '</span>';
                            }
                        }
                    }
                    $get_cart_item['product_user_current_reward_points'] = $user_current_reward_points;
                    //GEt Rewar POint in product

                    if ($cart_value['product_type'] == 'lodge' || $cart_value['product_type'] == 'excursion') {
                        // $totalAmount                        =    get_partners_dis_price($productPrice, $product_id, $request->user_id, 'base_price', 'lodge');
                        // $forCommisontotalAmount             =   get_partners_dis_price($productPrice, $product_id, $request->user_id, 'base_price', 'lodge');
                    }

                    if ($cart_value['product_type'] == 'lodge') {
                        $lodge_option = json_decode($cart_value['extra']);
                        foreach ($lodge_option as $LO) {
                            $tax = 0;
                            $tax_amount = 0;
                            $service_charge = 0;
                            $totalOptionAmount = 0;

                            $get_lodge_upgrade = [];
                            $lodge_option_id = $LO->lodge_option_id;

                            // Get Calculation
                            $ProductLodge = ProductLodge::where(['product_id' => $product_id, 'id' => $lodge_option_id])->first();
                            $ProductOptionTaxServiceCharge = ProductOptionTaxServiceCharge::where(['product_id' => $product_id, 'product_option_id' => $lodge_option_id])->first();
                            if ($ProductOptionTaxServiceCharge) {
                                if ($ProductOptionTaxServiceCharge->service_charge_allowed == 1) {
                                    $service_charge = $ProductOptionTaxServiceCharge->service_charge_amount != '' ? ConvertCurrency($ProductOptionTaxServiceCharge->service_charge_amount) : 0;
                                }
                                if ($ProductOptionTaxServiceCharge->tax_allowed == 1) {
                                    $tax = $ProductOptionTaxServiceCharge->tax_percentage != '' ? $ProductOptionTaxServiceCharge->tax_percentage : 0;
                                }
                            }

                            $arrivalDate = $LO->lodge_arrival_date;
                            $departureDate = $LO->lodge_departure_date;
                            $adultQty = $LO->lodge_option_adult;
                            $childQty = $LO->lodge_option_child;
                            $infantQty = $LO->lodge_option_infant;
                            $ProductPrice = get_partners_dis_price(ConvertCurrency($ProductLodge->lodge_price), $product_id, $request->user_id, 'tour_price', 'lodge');

                            if ($arrivalDate != '' && $departureDate != '') {
                                $date = Carbon::createFromFormat('Y-m-d', $departureDate);
                                $departureDate = $date->subDay(1);
                                $departureDate = date('Y-m-d', strtotime($departureDate));

                                if ($arrivalDate == $departureDate) {
                                    $dateArr = [$arrivalDate];
                                } else {
                                    $dateArr = $this->getDatesFromRange($arrivalDate, $departureDate);
                                }
                                // $ProductPrice = 0;
                            } else {
                                $dateArr = [];
                                $getProductLodgePrice = ProductLodgePrice::where('product_id', $product_id)
                                    ->where('product_lodge_id', $lodge_option_id)
                                    ->whereDate('from_date', '<=', date('Y-m-d'))
                                    ->whereDate('to_date', '>=', date('Y-m-d'))
                                    ->orderBy('id', 'desc')
                                    ->first();
                                if ($getProductLodgePrice) {
                                    $ProductPrice = get_partners_dis_price(ConvertCurrency($getProductLodgePrice->price), $product_id, $request->user_id, 'room_details', 'lodge');
                                }
                            }
                            $total_nights = count($dateArr);

                            $is_more = 0;
                            $limitAdult = $ProductLodge->adult;
                            $limitChild = $ProductLodge->child;
                            $limitInfant = $ProductLodge->infant;

                            if ($adultQty > 0 || $childQty || $infantQty > 0) {
                                foreach ($dateArr as $key => $DA) {
                                    $price = get_partners_dis_price(ConvertCurrency($ProductLodge->lodge_price), $product_id, $request->user_id, 'tour_price', 'lodge');
                                    $getProductLodgePrice = ProductLodgePrice::where('product_id', $product_id)
                                        ->where('product_lodge_id', $lodge_option_id)
                                        ->whereDate('from_date', '<=', $DA)
                                        ->whereDate('to_date', '>=', $DA)
                                        ->orderBy('id', 'desc')
                                        ->first();

                                    if ($getProductLodgePrice != '') {
                                        $price = get_partners_dis_price(ConvertCurrency($getProductLodgePrice->price), $product_id, $request->user_id, 'room_details', 'lodge');
                                    }
                                    $totalOptionAmount += $price;
                                }
                            }

                            $TourUpgradeTotal = 0;
                            if (isset($LO->lodgeupgrade)) {
                                // if (isset($request->is_upgrade)) {
                                foreach ($LO->lodgeupgrade as $key => $DL) {
                                    $lodge_option_upgrade_id = $DL->upgrade_id;
                                    $ProductOptionLodgeUpgrade = ProductOptionTourUpgrade::where(['id' => $lodge_option_upgrade_id])->first();
                                    if ($DL->lodge_adult_qty > 0) {
                                        $check_service_charge = 1;
                                        if (isset($DL->lodge_adult_qty)) {
                                            $TourUpgradeTotal += $DL->lodge_adult_qty * get_partners_dis_price(ConvertCurrency($ProductOptionLodgeUpgrade->adult_price), $product_id, $request->user_id, 'tour_upgrade_option', 'lodge') * $total_nights;
                                        } else {
                                            $TourUpgradeTotal += 0;
                                        }
                                    }
                                    if ($DL->lodge_child_qty > 0) {
                                        $check_service_charge = 1;

                                        if (isset($DL->lodge_child_qty)) {
                                            $TourUpgradeTotal += $DL->lodge_child_qty * get_partners_dis_price(ConvertCurrency($ProductOptionLodgeUpgrade->child_price), $product_id, $request->user_id, 'tour_upgrade_option', 'lodge') * $total_nights;
                                        } else {
                                            $TourUpgradeTotal += 0;
                                        }
                                    }
                                    if ($DL->lodge_infant_qty > 0) {
                                        $check_service_charge = 1;
                                        if (isset($DL->lodge_child_qty)) {
                                            $TourUpgradeTotal += $DL->lodge_infant_qty * get_partners_dis_price(ConvertCurrency($ProductOptionLodgeUpgrade->infant_price), $product_id, $request->user_id, 'tour_upgrade_option', 'lodge') * $total_nights;
                                        } else {
                                            $TourUpgradeTotal += 0;
                                        }
                                    }
                                }
                            }

                            // }

                            if ($adultQty > 0 || $childQty || $infantQty > 0 || $check_service_charge == 1) {
                            } else {
                                $service_charge = 0;
                            }

                            // if (isset($request->is_upgrade)) {
                            $totalQty = $LO->no_of_rooms;
                            // }
                            $totalOptionAmount = $totalOptionAmount * $totalQty;
                            $NewTotalForTax = $totalOptionAmount + $TourUpgradeTotal;

                            if ($tax != 0 && $NewTotalForTax != 0) {
                                $tax_amount = ($NewTotalForTax / 100) * $tax;
                            }
                            $forCommisontotalAmount += $NewTotalForTax;
                            // Tax And Service Charge---------------------------------------------------------------------
                            $total_tax += $tax_amount;
                            $total_service_charge += $service_charge;

                            $total_tax_per_product += $tax_amount;
                            $total_service_per_product += $service_charge;
                            $total_tax_percentage_per_product += $tax;

                            if ($get_cart_item['reward_point_apply'] != true) {
                                $no_tax_service_total_amnt += $NewTotalForTax;
                                $no_tax_service_total_amnt_per_product += $NewTotalForTax;
                            }

                            // Tax And Service Charge Lodge --------------------------------------------------------------

                            $totalAmount += $totalOptionAmount = $NewTotalForTax + $tax_amount + $service_charge;

                            ////////////////////////////////////

                            $ProductLodgeLanguage = ProductLodgeLanguage::where(['product_id' => $product_id])->get();
                            $get_lodge_upgrade['title'] = getLanguageTranslate($ProductLodgeLanguage, $language, $lodge_option_id, 'title', 'lodge_id');
                            $get_lodge_upgrade['adult'] = $LO->lodge_option_adult;
                            $get_lodge_upgrade['child'] = $LO->lodge_option_child;
                            $get_lodge_upgrade['infant'] = $LO->lodge_option_infant;
                            $get_lodge_upgrade['lodge_arrival_date'] = $LO->lodge_arrival_date;
                            $get_lodge_upgrade['lodge_departure_date'] = $LO->lodge_departure_date;
                            $get_lodge_upgrade['no_of_rooms'] = $LO->no_of_rooms;
                            $get_lodge_upgrade['option_total'] = $totalOptionAmount;
                            $get_lodge_upgrade['with_out_tax_and_service_amount'] = $NewTotalForTax;
                            if (isset($LO->lodgeupgrade)) {
                                foreach ($LO->lodgeupgrade as $k => $LOU) {
                                    $get_option_lodge_upgrade_arr = [];
                                    $lodge_option_upgrade_id = $LOU->upgrade_id;
                                    $ProductOptionLodgeUpgrade = ProductOptionTourUpgrade::where(['id' => $lodge_option_upgrade_id])->first();
                                    $get_option_lodge_upgrade_arr['title'] = $ProductOptionLodgeUpgrade->title;
                                    $get_option_lodge_upgrade_arr['adult_price'] = ConvertCurrency($ProductOptionLodgeUpgrade->adult_price);
                                    $get_option_lodge_upgrade_arr['lodge_adult_qty'] = $LOU->lodge_adult_qty;
                                    $get_option_lodge_upgrade_arr['child_price'] = ConvertCurrency($ProductOptionLodgeUpgrade->child_price);
                                    $get_option_lodge_upgrade_arr['lodge_child_qty'] = $LOU->lodge_child_qty;
                                    $get_option_lodge_upgrade_arr['infant_price'] = ConvertCurrency($ProductOptionLodgeUpgrade->infant_price);
                                    $get_option_lodge_upgrade_arr['lodge_infant_qty'] = $LOU->lodge_infant_qty;
                                    $get_lodge_upgrade['lodge_upgrade_option'][] = $get_option_lodge_upgrade_arr;
                                }
                            }
                            $get_cart_item['option'][] = $get_lodge_upgrade;
                        }
                    }

                    if ($cart_value['product_type'] == 'excursion') {
                        $excursion_option = json_decode($cart_value['extra']);
                        $ProductOptionArr = [];

                        foreach ($excursion_option as $key => $EO) {
                            $service_charge = 0;
                            $tax = 0;
                            $tax_amount = 0;
                            if ($key == 'private_tour') {
                                $ProductOptionArr['private_tour'] = [];
                                foreach ($EO as $ptkey => $PT) {
                                    $total_tour_transfer_amount = 0;
                                    $service_charge = 0;
                                    $tax = 0;
                                    $tax_amount = 0;
                                    $total_amount = 0;
                                    $get_private_tour_arr = [];
                                    $ProductOptionPrivateTourPrice = ProductOptionPrivateTourPrice::where('product_id', $product_id)
                                        ->where('product_option_id', $PT->id)
                                        ->first();
                                    $ProductOptionLanguage = ProductOptionLanguage::where('product_id', $product_id)->get();
                                    $get_option_service_charge = ProductOptionTaxServiceCharge::where('product_option_id', $PT->id)
                                        ->where('product_id', $product_id)
                                        ->first();

                                    if ($get_option_service_charge) {
                                        if ($get_option_service_charge['service_charge_allowed'] == 1) {
                                            $service_charge = $get_option_service_charge['service_charge_amount'] != '' ? ConvertCurrency($get_option_service_charge['service_charge_amount']) : 0;
                                        }
                                        if ($get_option_service_charge['tax_allowed'] == 1) {
                                            $tax = $get_option_service_charge['tax_percentage'] != '' ? $get_option_service_charge['tax_percentage'] : 0;
                                        }
                                    }

                                    if ($ProductOptionPrivateTourPrice) {
                                        $private_per_price = ConvertCurrency($ProductOptionPrivateTourPrice['private_per_price']);
                                        $total_allowed = $ProductOptionPrivateTourPrice['total_allowed'];
                                        $private_tour_pasenger = $PT->qty;
                                        $private_tour_total_passanger_ = 0;
                                        $total_private_per_price = 0;

                                        if ($total_allowed > 0) {
                                            if ($private_tour_pasenger > $total_allowed) {
                                                $private_tour_total_passanger_ = ceil($private_tour_pasenger / $total_allowed);
                                            } else {
                                                $private_tour_total_passanger_ = 1;
                                            }
                                            $total_private_per_price = $private_per_price * $private_tour_total_passanger_;
                                        }
                                        if ($private_tour_pasenger == 0) {
                                            $private_per_price = 0;
                                            $total_private_per_price = 0;
                                        }

                                        $get_private_tour_arr['title'] = getLanguageTranslate($ProductOptionLanguage, $language, $PT->id, 'title', 'option_id');
                                        $get_private_tour_arr['adult'] = $PT->tour_adult_qty;
                                        $get_private_tour_arr['child'] = $PT->tour_child_qty;
                                        $get_private_tour_arr['infant'] = $PT->tour_infant_qty;
                                        $get_private_tour_arr['car_seats'] = $total_allowed;
                                        $get_private_tour_arr['date'] = date('Y-m-d', strtotime($PT->date));
                                        $get_private_tour_arr['total_cars'] = $private_tour_total_passanger_;
                                        $get_private_tour_arr['total_pasenger'] = $private_tour_pasenger;
                                        $get_private_tour_arr['price'] = $total_private_per_price;

                                        $private_tour_upgrade_total_amount = 0;
                                        $private_tour_total = 0;
                                        if (isset($PT->tour_upgrade)) {
                                            foreach ($PT->tour_upgrade as $k => $TU) {
                                                if ($TU != '') {
                                                    $req_adult_qty = 0;
                                                    $req_child_qty = 0;
                                                    $req_infant_qty = 0;
                                                    $adult_price = 0;
                                                    $child_price = 0;
                                                    $infant_price = 0;
                                                    $get_option_tour_upgrade_arr = [];
                                                    $tour_option_upgrade_id = $TU->id;

                                                    $ProductOptionLodgeUpgrade = ProductOptionTourUpgrade::where(['id' => $tour_option_upgrade_id])->first();
                                                    $get_option_tour_upgrade_arr['title'] = $ProductOptionLodgeUpgrade->title;
                                                    $get_option_tour_upgrade_arr['adult_price'] = $adult_price = get_partners_dis_price(ConvertCurrency($ProductOptionLodgeUpgrade->adult_price), $activity_id, $request->user_id, 'tour_upgrade_option', 'excursion');
                                                    $get_option_tour_upgrade_arr['lodge_adult_qty'] = $req_adult_qty = $TU->adult_qty;
                                                    $get_option_tour_upgrade_arr['child_price'] = $child_price = get_partners_dis_price(ConvertCurrency($ProductOptionLodgeUpgrade->child_price), $activity_id, $request->user_id, 'tour_upgrade_option', 'excursion');
                                                    $get_option_tour_upgrade_arr['lodge_child_qty'] = $req_child_qty = $TU->child_qty;
                                                    $get_option_tour_upgrade_arr['infant_price'] = $infant_price = get_partners_dis_price(ConvertCurrency($ProductOptionLodgeUpgrade->infant_price), $activity_id, $request->user_id, 'tour_upgrade_option', 'excursion');
                                                    $get_option_tour_upgrade_arr['lodge_infant_qty'] = $req_infant_qty = $TU->infant_qty;

                                                    $total_adult_price = $adult_price * $req_adult_qty;
                                                    $total_child_price = $child_price * $req_child_qty;
                                                    $total_infant_price = $infant_price * $req_infant_qty;
                                                    $private_tour_upgrade_total_amount += $total_adult_price + $total_child_price + $total_infant_price;
                                                    $get_private_tour_arr['tour_upgrade_option'][] = $get_option_tour_upgrade_arr;
                                                }
                                            }
                                        }
                                        $private_tour_total = $total_private_per_price + $private_tour_upgrade_total_amount;
                                        if ($tax != 0 && $private_tour_total != 0) {
                                            $tax_amount = ($private_tour_total / 100) * $tax;
                                        }
                                        if ($total_private_per_price != 0) {
                                            $get_private_tour_arr['service_charge'] = $service_charge;
                                            $get_private_tour_arr['tax'] = number_format($tax, 2);

                                            $total_tax += $tax_amount;
                                            $total_service_charge += $service_charge;

                                            // Tax Amd Servce Charge Private Excursion ----------------------------------------------------------------------------
                                            $total_tax_per_product += $tax_amount;
                                            $total_service_per_product += $service_charge;
                                            $total_tax_percentage_per_product += $tax;
                                            // Tax Amd Servce Charge Private Excursion ----------------------------------------------------------------------------

                                            if ($get_cart_item['reward_point_apply'] != true) {
                                                $no_tax_service_total_amnt += $private_tour_total;
                                                $no_tax_service_total_amnt_per_product += $private_tour_total;
                                            }

                                            $forCommisontotalAmount += $private_tour_total;
                                            $totalAmount += $private_tour_total + $service_charge + $tax_amount;
                                            $get_private_tour_arr['with_out_tax_and_service_amount'] = $private_tour_total;
                                            $get_private_tour_arr['total_amount'] = number_format($private_tour_total + $service_charge + $tax_amount, 2);
                                        }
                                    }

                                    $ProductOptionArr['private_tour'][] = $get_private_tour_arr;
                                }
                                // print_die($ProductOptionArr);
                            }

                            if ($key == 'tour_transfer') {
                                $ProductOptionArr['tour_transfer'] = [];
                                foreach ($EO as $ttkey => $TT) {
                                    $get_tour_transfer_arr = [];
                                    $ProductOptionLanguage = ProductOptionLanguage::where('product_id', $product_id)->get();
                                    $get_tour_transfer_arr['title'] = getLanguageTranslate($ProductOptionLanguage, $language, $TT->id, 'title', 'option_id');
                                    $get_tour_transfer_arr['adult'] = $TT->tour_adult_qty;
                                    $get_tour_transfer_arr['child'] = $TT->tour_child_qty;
                                    $get_tour_transfer_arr['infant'] = $TT->tour_infant_qty;

                                    $total_tour_transfer_amount = 0;

                                    $get_option_tour_detail = ProductTourPriceDetails::where('product_option_id', $TT->id)
                                        ->where('product_id', $product_id)
                                        ->first();

                                    $ProductOptionPrivateTourPrice = ProductOptionPrivateTourPrice::where('product_id', $product_id)
                                        ->where('product_option_id', $TT->id)
                                        ->first();

                                    $get_option_service_charge = ProductOptionTaxServiceCharge::where('product_option_id', $TT->id)
                                        ->where('product_id', $product_id)
                                        ->first();

                                    if ($get_option_service_charge) {
                                        if ($get_option_service_charge['service_charge_allowed'] == 1) {
                                            $service_charge = $get_option_service_charge['service_charge_amount'] != '' ? ConvertCurrency($get_option_service_charge['service_charge_amount']) : 0;
                                        }
                                        if ($get_option_service_charge['tax_allowed'] == 1) {
                                            $tax = $get_option_service_charge['tax_percentage'] != '' ? $get_option_service_charge['tax_percentage'] : 0;
                                        }
                                    }

                                    $totalQty = $TT->tour_adult_qty + $TT->tour_child_qty + $TT->tour_infant_qty;
                                    $ProductOptionGroupPercentage = ProductOptionGroupPercentage::where(['product_id' => $product_id, 'product_option_id' => $TT->id, 'number_of_passenger' => $totalQty])->first();

                                    if ($get_option_tour_detail) {
                                        $adult_price = get_partners_dis_price(ConvertCurrency($get_option_tour_detail['adult_price']), $activity_id, $request->user_id, 'tour_price', 'excursion');
                                        $child_price = get_partners_dis_price(ConvertCurrency($get_option_tour_detail['child_price']), $activity_id, $request->user_id, 'tour_price', 'excursion');
                                        $infant_price = get_partners_dis_price(ConvertCurrency($get_option_tour_detail['infant_price']), $activity_id, $request->user_id, 'tour_price', 'excursion');

                                        $WeekDay = date('l', strtotime($TT->date));
                                        $ProductOptionWeekTour = ProductOptionWeekTour::where(['product_id' => $product_id, 'product_option_id' => $TT->id, 'week_day' => $WeekDay])->first();
                                        // is_week_days_id
                                        if ($ProductOptionWeekTour) {
                                            $adult_price = get_partners_dis_price(ConvertCurrency($ProductOptionWeekTour['adult']), $activity_id, $request->user_id, 'weekdays', 'excursion');
                                            $child_price = get_partners_dis_price(ConvertCurrency($ProductOptionWeekTour['child_price']), $activity_id, $request->user_id, 'weekdays', 'excursion');
                                            $infant_price = get_partners_dis_price(ConvertCurrency($ProductOptionWeekTour['infant_price']), $activity_id, $request->user_id, 'weekdays', 'excursion');
                                        }

                                        $date = Carbon::now();
                                        $ProductOptiossnPeriodPricing = ProductOptionPeriodPricing::where(['product_id' => $product_id, 'product_option_id' => $TT->id])
                                            ->whereDate('from_date', '<=', $date)
                                            ->whereDate('to_date', '>=', $date)
                                            ->first();
                                        if ($ProductOptiossnPeriodPricing) {
                                            $adult_price = ConvertCurrency($ProductOptiossnPeriodPricing['adult_price']);
                                            $child_price = ConvertCurrency($ProductOptiossnPeriodPricing['child_price']);
                                            $infant_price = ConvertCurrency($ProductOptiossnPeriodPricing['infant_price']);
                                        }

                                        $AdultpercentageType = $ProductOptionGroupPercentage != '' ? ConvertCurrency($ProductOptionGroupPercentage->default_percentage) : $adult_price;
                                        $ChildpercentageType = $ProductOptionGroupPercentage != '' ? ConvertCurrency($ProductOptionGroupPercentage->weekdays_percentage) : $child_price;
                                        $infantpercentageType = $ProductOptionGroupPercentage != '' ? ConvertCurrency($ProductOptionGroupPercentage->period_percentage) : $infant_price;

                                        $get_tour_transfer_arr['per_adult_price'] = $adult_price;
                                        $get_tour_transfer_arr['per_child_price'] = $child_price;
                                        $get_tour_transfer_arr['per_infant_price'] = $infant_price;

                                        $adult_price = $AdultpercentageType;
                                        $child_price = $ChildpercentageType;
                                        $infant_price = $infantpercentageType;

                                        $total_adult_price = $adult_price * $TT->tour_adult_qty;
                                        $total_child_price = $child_price * $TT->tour_child_qty;
                                        $total_infant_price = $infant_price * $TT->tour_infant_qty;
                                        $total_tour_transfer_amount += $total_adult_price + $total_child_price + $total_infant_price;
                                    }

                                    if ($TT->is_private_transfer == 1) {
                                        $get_option_details = ProductOptionDetails::where('product_id', $product_id)
                                            ->where('product_option_id', $TT->id)
                                            ->where('id', $TT->transfer_option)
                                            ->first();
                                        $adult_price = get_partners_dis_price(ConvertCurrency($get_option_details['edult']), $activity_id, $request->user_id, 'transfer_option', 'excursion');
                                        $child_price = get_partners_dis_price(ConvertCurrency($get_option_details['child_price']), $activity_id, $request->user_id, 'transfer_option', 'excursion');
                                        $infant_price = get_partners_dis_price(ConvertCurrency($get_option_details['infant']), $activity_id, $request->user_id, 'transfer_option', 'excursion');
                                        $total_adult_price = $adult_price * $TT->tour_adult_qty;
                                        $total_child_price = $child_price * $TT->tour_child_qty;
                                        $total_infant_price = $infant_price * $TT->tour_infant_qty;

                                        $get_car_detail = CarDetails::where('id', $TT->car_id)
                                            ->where('status', 'Active')
                                            ->first();

                                        if ($get_car_detail) {
                                            $car_seats = 0;
                                            $car_price = 0;
                                            $total_pasenger = $TT->tour_adult_qty + $TT->tour_child_qty;
                                            $get_car_name = CarDetailLanguage::where('car_details_id', $get_car_detail['id'])
                                                ->where('language_id', $language)
                                                ->first();

                                            $car_price = $get_car_detail['price'];
                                            $car_seats = $get_car_detail['number_of_passengers'];

                                            if ($total_pasenger == 0) {
                                                $car_price = 0;
                                            }
                                            if ($get_option_details['transfer_option']) {
                                                $get_tour_transfer_arr['option_name'] = $get_option_details['transfer_option'];
                                            }
                                            $get_tour_transfer_arr['adult'] = $TT->tour_adult_qty;
                                            $get_tour_transfer_arr['adult_price'] = $adult_price;
                                            $get_tour_transfer_arr['child_price'] = $child_price;
                                            $get_tour_transfer_arr['infant_price'] = $infant_price;
                                            $get_tour_transfer_arr['is_private_car'] = 1;
                                            $get_tour_transfer_arr['child'] = $TT->tour_child_qty;
                                            $get_tour_transfer_arr['infant'] = $TT->tour_infant_qty;
                                            $get_tour_transfer_arr['car_seats'] = $car_seats;
                                            $get_tour_transfer_arr['date'] = date('Y-m-d', strtotime($TT->date));
                                            $get_tour_transfer_arr['car_price'] = $car_price;
                                            $get_tour_transfer_arr['car_name']  = isset($get_car_name['title'])  ? $get_car_name['title'] : '';;
                                            $get_tour_transfer_arr['total_pasenger'] = $total_pasenger;
                                            if ($car_seats > 0) {
                                                if ($total_pasenger > $car_seats) {
                                                    $total_passanger_ = ceil($total_pasenger / $car_seats);
                                                } else {
                                                    $total_passanger_ = 1;
                                                }
                                                $total_car_price = $car_price * $total_passanger_;
                                            }
                                            $get_tour_transfer_arr['total_cars'] = $total_passanger_;

                                            $total_tour_transfer_amount += $total_car_price;
                                        }
                                    } else {
                                        $get_option_details = ProductOptionDetails::where('product_id', $product_id)
                                            ->where('product_option_id', $TT->id)
                                            ->where('id', $TT->transfer_option)
                                            ->first();
                                        $transfer_adult_price = get_partners_dis_price(ConvertCurrency($get_option_details['edult']), $activity_id, $request->user_id, 'transfer_option', 'excursion');
                                        $transfer_child_price = get_partners_dis_price(ConvertCurrency($get_option_details['child_price']), $activity_id, $request->user_id, 'transfer_option', 'excursion');
                                        $transfer_infant_price = get_partners_dis_price(ConvertCurrency($get_option_details['infant']), $activity_id, $request->user_id, 'transfer_option', 'excursion');
                                        $transfer_total_adult_price = $transfer_adult_price * $TT->tour_adult_qty;
                                        $transfer_total_child_price = $transfer_child_price * $TT->tour_child_qty;
                                        $transfer_total_infant_price = $transfer_infant_price * $TT->tour_infant_qty;

                                        $total_transfer = $transfer_total_adult_price + $transfer_total_child_price + $transfer_total_infant_price;

                                        $get_tour_transfer_arr['adult_price'] = $get_option_details['edult'] > 0 ? get_partners_dis_price(ConvertCurrency($get_option_details['edult']), $activity_id, $request->user_id, 'transfer_option', 'excursion') : 'N/A';

                                        $get_tour_transfer_arr['child_price'] = $get_option_details['child_price'] > 0 ? get_partners_dis_price(ConvertCurrency($get_option_details['child_price']), $activity_id, $request->user_id, 'transfer_option', 'excursion') : 'N/A';

                                        $get_tour_transfer_arr['infant_price'] = $get_option_details['infant'] > 0 ? get_partners_dis_price(ConvertCurrency($get_option_details['infant']), $activity_id, $request->user_id, 'transfer_option', 'excursion') : 'N/A';

                                        if ($get_option_details['transfer_option']) {
                                            $get_tour_transfer_arr['option_name'] = $get_option_details['transfer_option'];
                                        }
                                        $get_tour_transfer_arr['is_private_car'] = 1;
                                        $get_tour_transfer_arr['adult'] = $TT->tour_adult_qty;
                                        $get_tour_transfer_arr['date'] = date('Y-m-d', strtotime($TT->date));
                                        $get_tour_transfer_arr['child'] = $TT->tour_child_qty;
                                        $get_tour_transfer_arr['infant'] = $TT->tour_infant_qty;
                                        $get_tour_transfer_arr['total_adult_price'] = $total_adult_price;
                                        $get_tour_transfer_arr['total_child_price'] = $total_child_price;
                                        $get_tour_transfer_arr['total_infant_price'] = $total_infant_price;

                                        $get_tour_transfer_arr['total'] = $total_tour_transfer_amount = $total_tour_transfer_amount + $total_transfer;
                                    }

                                    $tour_transfer_upgrade_total_amount = 0;
                                    $private_tour_total = 0;
                                    if (isset($TT->tour_upgrade)) {
                                        foreach ($TT->tour_upgrade as $k => $TU) {
                                            if ($TU != '') {
                                                $req_adult_qty = 0;
                                                $req_child_qty = 0;
                                                $req_infant_qty = 0;
                                                $adult_price = 0;
                                                $child_price = 0;
                                                $infant_price = 0;
                                                $get_option_tour_upgrade_arr = [];
                                                $tour_option_upgrade_id = $TU->id;

                                                $ProductOptionLodgeUpgrade = ProductOptionTourUpgrade::where(['id' => $tour_option_upgrade_id])->first();
                                                $get_option_tour_upgrade_arr['title'] = $ProductOptionLodgeUpgrade->title;
                                                $get_option_tour_upgrade_arr['adult_price'] = $adult_price = get_partners_dis_price(ConvertCurrency($ProductOptionLodgeUpgrade->adult_price), $activity_id, $request->user_id, 'tour_upgrade_option', 'excursion');
                                                $get_option_tour_upgrade_arr['lodge_adult_qty'] = $req_adult_qty = $TU->adult_qty;
                                                $get_option_tour_upgrade_arr['child_price'] = $child_price = get_partners_dis_price(ConvertCurrency($ProductOptionLodgeUpgrade->child_price), $activity_id, $request->user_id, 'tour_upgrade_option', 'excursion');
                                                $get_option_tour_upgrade_arr['lodge_child_qty'] = $req_child_qty = $TU->child_qty;
                                                $get_option_tour_upgrade_arr['infant_price'] = $infant_price = get_partners_dis_price(ConvertCurrency($ProductOptionLodgeUpgrade->infant_price), $activity_id, $request->user_id, 'tour_upgrade_option', 'excursion');
                                                $get_option_tour_upgrade_arr['lodge_infant_qty'] = $req_infant_qty = $TU->infant_qty;

                                                $total_adult_price = $adult_price * $req_adult_qty;
                                                $total_child_price = $child_price * $req_child_qty;
                                                $total_infant_price = $infant_price * $req_infant_qty;
                                                $tour_transfer_upgrade_total_amount += $total_adult_price + $total_child_price + $total_infant_price;
                                                $get_tour_transfer_arr['tour_upgrade_option'][] = $get_option_tour_upgrade_arr;
                                            }
                                        }
                                    }
                                    $total_tour_transfer_amount = $total_tour_transfer_amount + $tour_transfer_upgrade_total_amount;

                                    if ($tax != 0 && $total_tour_transfer_amount != 0) {
                                        $tax_amount = ($total_tour_transfer_amount / 100) * $tax;
                                    }
                                    if ($total_tour_transfer_amount != 0) {
                                        $get_tour_transfer_arr['service_charge'] = $service_charge;
                                        $get_tour_transfer_arr['tax'] = number_format($tax, 2);
                                        $get_tour_transfer_arr['total_amount'] = number_format($total_tour_transfer_amount + $service_charge + $tax_amount, 2);
                                    }
                                    $total_tax += $tax_amount;
                                    $total_service_charge += $service_charge;

                                    // TAX And SERvice  ----------------------------------------------------------------------------------
                                    $total_service_per_product += $service_charge;
                                    $total_tax_per_product += $tax_amount;
                                    $total_tax_percentage_per_product += $tax;

                                    // TAX And SERvice Excursion ----------------------------------------------------------------------------------
                                    if ($get_cart_item['reward_point_apply'] != true) {
                                        $no_tax_service_total_amnt += $total_tour_transfer_amount;
                                        $no_tax_service_total_amnt_per_product += $total_tour_transfer_amount;
                                    }

                                    $forCommisontotalAmount += $total_tour_transfer_amount;

                                    $totalAmount += $total_tour_transfer_amount + $service_charge + $tax_amount;
                                    $get_tour_transfer_arr['with_out_tax_and_service_amount'] = $total_tour_transfer_amount;

                                    $ProductOptionArr['tour_transfer'][] = $get_tour_transfer_arr;
                                }
                            }

                            if ($key == 'group_percentage') {
                                foreach ($EO as $gpkey => $GP) {
                                    $tour_group_percentage_arr = [];
                                    $ProductGroupPercentageLanguage = ProductGroupPercentageLanguage::where(['product_id' => $product_id])->get();
                                    $ProductGroupPercentage = ProductGroupPercentage::where(['id' => $GP->id, 'product_id' => $product_id])->first();

                                    $ProductGroupPercentageDetails = ProductGroupPercentageDetails::where(['product_id' => $product_id])
                                        ->where('number_of_pax', '>=', $GP->qty)
                                        ->where('number_of_pax', '<=', $GP->qty)
                                        ->orderBy('number_of_pax', 'asc')
                                        ->first();
                                    $amount = ConvertCurrency($ProductGroupPercentage->group_price);

                                    if ($ProductGroupPercentageDetails) {
                                        $amount = ConvertCurrency($ProductGroupPercentageDetails->group_price);
                                    } else {
                                        $ProductGroupPercentageDetails = ProductGroupPercentageDetails::where(['product_id' => $product_id])
                                            ->where('number_of_pax', '>=', $GP->qty)
                                            ->orderBy('number_of_pax', 'asc')
                                            ->first();
                                        if ($ProductGroupPercentageDetails) {
                                            $amount = ConvertCurrency($ProductGroupPercentageDetails->group_price);
                                        }
                                    }
                                    $group_price = 0;
                                    if ($GP->qty <= 0) {
                                        $amount = 0;
                                    } else {
                                        $group_price = $amount / $GP->qty;
                                    }

                                    $service_charge = 0;
                                    $tax = 0;
                                    $tax_amount = 0;

                                    //Tax And Service
                                    if ($ProductGroupPercentage['service_charge_allowed'] == 1) {
                                        $service_charge = $ProductGroupPercentage['service_charge_amount'] != '' ? ConvertCurrency($ProductGroupPercentage['service_charge_amount']) : 0;
                                    }
                                    if ($ProductGroupPercentage['tax_allowed'] == 1) {
                                        $tax = $ProductGroupPercentage['tax_percentage'] != '' ? $ProductGroupPercentage['tax_percentage'] : 0;
                                        if ($tax != 0 && $amount != 0) {
                                            $tax_amount = ($amount / 100) * $tax;
                                        }
                                    }

                                    $tour_group_percentage_arr['service_charge_allowed'] = $ProductGroupPercentage['service_charge_allowed'];
                                    $tour_group_percentage_arr['tax_allowed'] = $ProductGroupPercentage['tax_allowed'];
                                    $tour_group_percentage_arr['tax_percentage'] = $ProductGroupPercentage['tax_percentage'];
                                    $tour_group_percentage_arr['tax_amount'] = $tax_amount;
                                    $tour_group_percentage_arr['service_charge'] = $service_charge;

                                    $total_amount = 0;
                                    $total_tax += $tax_amount;
                                    $total_service_charge += $service_charge;

                                    // Tax Service Excusrion---------------------------------------------------------
                                    $total_tax_per_product += $tax_amount;
                                    $total_service_per_product += $service_charge;
                                    $total_tax_percentage_per_product = $tax;

                                    // Tax Service Excusrion---------------------------------------------------------
                                    if ($get_cart_item['reward_point_apply'] != true) {
                                        $no_tax_service_total_amnt += $amount;
                                        $no_tax_service_total_amnt_per_product += $amount;
                                    }

                                    $forCommisontotalAmount += $amount;
                                    $total_amount = $amount + $service_charge + $tax_amount;

                                    $tour_group_percentage_arr['title'] = getLanguageTranslate($ProductGroupPercentageLanguage, $language, $GP->id, 'title', 'group_percentage_id');
                                    $tour_group_percentage_arr['date'] = date('Y-m-d', strtotime($GP->date));
                                    $tour_group_percentage_arr['qty'] = $GP->qty;
                                    $tour_group_percentage_arr['sub_total_amount'] = $amount;
                                    $tour_group_percentage_arr['amount'] = $total_amount;
                                    $tour_group_percentage_arr['with_out_tax_and_service_amount'] = $amount;
                                    $tour_group_percentage_arr['is_group_percentage'] = 1;
                                    $tour_group_percentage_arr['group_price'] = number_format($group_price, 2);

                                    $totalAmount += $total_amount;
                                    $ProductOptionArr['group_percentage'][] = $tour_group_percentage_arr;
                                }
                            }
                        }

                        $get_cart_item['option'][] = $ProductOptionArr;
                    }

                    if ($cart_value['product_type'] == 'Yatch') {
                        $get_yacht_arr = [];
                        $totalYachtAmount = 0;
                        $yacht_option = json_decode($cart_value['extra']);

                        $price = $Product->selling_price !== '' ? get_partners_dis_price(ConvertCurrency($Product->selling_price), $product_id, $request->user_id, 'base_price', 'yacht') : get_partners_dis_price(ConvertCurrency($Product->original_price), $product_id, $request->user_id, 'base_price', 'yacht');
                        if (isset($yacht_option->date)) {
                            if ($yacht_option->date != '') {
                                $WeekDay = date('l', strtotime($yacht_option->date));
                                $ProductPrice = ProductOptionWeekTour::where(['product_id' => $product_id, 'week_day' => $WeekDay, 'for_general' => 1])->first();
                                if ($ProductPrice) {
                                    $price = get_partners_dis_price(ConvertCurrency($ProductPrice->adult), $product_id, $request->user_id, 'weekdays', 'yacht');
                                }
                            } else {
                                $date = date('Y-m-d');
                                $WeekDay = date('l', strtotime($date));
                                $ProductPrice = ProductOptionWeekTour::where(['product_id' => $product_id, 'week_day' => $WeekDay, 'for_general' => 1])->first();
                                if ($ProductPrice) {
                                    $price = get_partners_dis_price(ConvertCurrency($ProductPrice->adult), $product_id, $request->user_id, 'weekdays', 'yacht');
                                }
                            }
                        } else {
                            $date = date('Y-m-d');
                            $WeekDay = date('l', strtotime($date));
                            $ProductPrice = ProductOptionWeekTour::where(['product_id' => $product_id, 'week_day' => $WeekDay, 'for_general' => 1])->first();
                            if ($ProductPrice) {
                                $price = get_partners_dis_price(ConvertCurrency($ProductPrice->adult), $product_id, $request->user_id, 'weekdays', 'yacht');
                            }
                        }

                        if (isset($yacht_option->start_time)) {
                            $startTime = $yacht_option->start_time;
                        } else {
                            $startTime = date('H');
                        }
                        if (isset($yacht_option->end_time)) {
                            $endTime = $yacht_option->end_time;
                        } else {
                            $endTime = $startTime + $yacht_option->get_hours;
                        }
                        $get_yacht_arr['title'] = 'Hour Price';
                        $get_yacht_arr['date'] = $yacht_option->date;
                        $get_yacht_arr['start_time'] = $startTime;
                        $get_yacht_arr['end_time'] = $endTime;
                        $get_yacht_arr['price'] = $price;
                        $get_cart_item['price'] = $price;
                        $get_yacht_arr['get_hours'] = $yacht_option->get_hours;
                        $hprice = $price * $yacht_option->get_hours;
                        $get_yacht_arr['total_price'] = $hprice;
                        $get_yacht_arr['guest'] = $yacht_option->guest;
                        $get_yacht_arr['hour_price'] = 1;
                        $get_yacht_arr['way'] = 0;

                        $totalAmount += $price * $yacht_option->get_hours;
                        $forCommisontotalAmount += $price * $yacht_option->get_hours;

                        foreach ($yacht_option as $yokey => $YO) {
                            if ($yokey == 'transportaion') {
                                $get_yacht_arr['transportaion'] = [];
                                foreach ($YO as $tkey => $TP) {
                                    $TransportationVehicle = TransportationVehicle::where(['id' => $TP->id])->first();
                                    $ProductTransportationVehicle = $Product->transportation_vehicle;
                                    $ProductTransportationVehicleArr = explode(',', $ProductTransportationVehicle);
                                    if (in_array($TP->id, $ProductTransportationVehicleArr)) {
                                        if ($TransportationVehicle) {
                                            $transportationArr = [];

                                            if ($TP->two_way == 1) {
                                                $price = get_partners_dis_price(ConvertCurrency($TransportationVehicle->two_way_price), $product_id, $request->user_id, 'transportation', 'yacht');
                                            } else {
                                                $price = get_partners_dis_price(ConvertCurrency($TransportationVehicle->one_way_price), $product_id, $request->user_id, 'transportation', 'yacht');
                                            }

                                            $transportationArr['title'] = $TP->title;
                                            $transportationArr['way'] = $TP->two_way == 1 ? 'Two Way' : 'One Way';
                                            $transportationArr['price'] = $price;
                                            $transportationArr['select_qty'] = $TP->select_qty;
                                            $trprice = $price * $TP->select_qty;
                                            $totalAmount += $trprice;
                                            $forCommisontotalAmount += $trprice;
                                            $transportationArr['total_price'] = $trprice;

                                            $transportationArr['hour_price'] = 1;
                                            if ($trprice > 0) {
                                                $get_yacht_arr['transportaion'][] = $transportationArr;
                                            }
                                        }
                                    }
                                }
                            }

                            if ($yokey == 'transfer_option') {
                                $get_yacht_arr['transfer_option'] = [];
                                foreach ($YO as $tkey => $TP) {
                                    $Productyachttransferoption = Productyachttransferoption::where(['id' => $TP->id])->first();
                                    if ($Productyachttransferoption) {
                                        $get_transfer_arr = [];
                                        $get_transfer_arr['title'] = $TP->title;
                                        $get_transfer_arr['way'] = 1;
                                        $get_transfer_arr['price'] = get_partners_dis_price(ConvertCurrency($Productyachttransferoption->price), $product_id, $request->user_id, 'transfer_option', 'yacht');
                                        $get_transfer_arr['select_qty'] = $TP->select_qty;
                                        $tprice = get_partners_dis_price(ConvertCurrency($Productyachttransferoption->price), $product_id, $request->user_id, 'transfer_option', 'yacht') * $TP->select_qty;
                                        $totalAmount += $tprice;
                                        $forCommisontotalAmount += $tprice;
                                        $get_transfer_arr['total_price'] = $tprice;

                                        $get_transfer_arr['hour_price'] = 1;
                                        if ($tprice > 0) {
                                            $get_yacht_arr['transfer_option'][] = $get_transfer_arr;
                                        }
                                    }
                                }
                            }

                            if ($yokey == 'water_sports') {
                                $get_yacht_arr['food_beverage'] = [];
                                foreach ($YO as $wkey => $WSA) {
                                    $get_water_sports_arr = [];
                                    $adult_price = 0;
                                    $infant_price = 0;
                                    $child_price = 0;
                                    $adult_qty = isset($WSA->adult_qty) ? $WSA->adult_qty : 0;
                                    $child_qty = isset($WSA->child_qty) ? $WSA->child_qty : 0;

                                    $ProductOptions = ProductOptions::where(['id' => $WSA->id])->first();
                                    $ProductOptionLanguage = ProductOptionLanguage::where(['product_id' => $product_id])->get();
                                    $ProductTourPriceDetails = ProductTourPriceDetails::where(['product_id' => $product_id, 'product_option_id' => $WSA->id])->first();
                                    $ProductOptionWeekTour = ProductOptionWeekTour::where(['product_id' => $product_id, 'product_option_id' => $WSA->id, 'week_day' => $WeekDay])->first();

                                    $adult_price = $ProductTourPriceDetails != '' ? get_partners_dis_price(ConvertCurrency($ProductTourPriceDetails->adult_price), $product_id, $request->user_id, 'food_beverage', 'yacht') : 0;
                                    $infant_price = $ProductTourPriceDetails != '' ? get_partners_dis_price(ConvertCurrency($ProductTourPriceDetails->infant_price), $product_id, $request->user_id, 'food_beverage', 'yacht') : 0;
                                    $child_price = $ProductTourPriceDetails != '' ? get_partners_dis_price(ConvertCurrency($ProductTourPriceDetails->child_price), $product_id, $request->user_id, 'food_beverage', 'yacht') : 0;
                                    if ($ProductOptionWeekTour != '') {
                                        $adult_price = get_partners_dis_price(ConvertCurrency($ProductOptionWeekTour->adult), $product_id, $request->user_id, 'food_beverage', 'yacht');
                                        $child_price = get_partners_dis_price(ConvertCurrency($ProductOptionWeekTour->child_price), $product_id, $request->user_id, 'food_beverage', 'yacht');
                                        $infant_price = get_partners_dis_price(ConvertCurrency($ProductOptionWeekTour->infant_price), $product_id, $request->user_id, 'food_beverage', 'yacht');
                                    }

                                    if ($adult_qty > 0 || $child_qty > 0) {
                                        $get_water_sports_arr['title'] = getLanguageTranslate($ProductOptionLanguage, $language, $WSA->id, 'title', 'option_id');
                                        $get_water_sports_arr['hour_price'] = 0;
                                        $get_water_sports_arr['way'] = 0;
                                        $get_water_sports_arr['adult_price'] = $adult_price;
                                        $get_water_sports_arr['adult_qty'] = $adult_qty;
                                        $get_water_sports_arr['child_price'] = $child_price;
                                        $get_water_sports_arr['child_qty'] = $child_qty;
                                        $wprice = $child_price * $child_qty + $adult_qty * $adult_price;
                                        $totalAmount += $wprice;
                                        $forCommisontotalAmount += $wprice;
                                        $get_water_sports_arr['total_price'] = $wprice;
                                        if ($wprice > 0) {
                                            $get_yacht_arr['food_beverage'][] = $get_water_sports_arr;
                                        }
                                    }
                                }
                            }

                            if ($yokey == 'food_beverage') {
                                $get_yacht_arr['water_sports'] = [];
                                foreach ($YO as $tkey => $TPA) {
                                    $Productyachtwatersport = Productyachtwatersport::where(['id' => $TPA->id])->first();
                                    if ($Productyachtwatersport) {
                                        $get_water_arr = [];
                                        $get_water_arr['title'] = $TPA->title;
                                        $get_water_arr['way'] = 1;
                                        $get_water_arr['price'] = get_partners_dis_price(ConvertCurrency($Productyachtwatersport->price), $product_id, $request->user_id, 'water_sports', 'yacht');
                                        $get_water_arr['get_hours'] = $TPA->select_qty;
                                        $tprice = get_partners_dis_price(ConvertCurrency($Productyachtwatersport->price), $product_id, $request->user_id, 'water_sports', 'yacht') * $TPA->select_qty;
                                        $totalAmount += $tprice;
                                        $forCommisontotalAmount += $tprice;
                                        $get_water_arr['total_price'] = $tprice;

                                        $get_water_arr['hour_price'] = 1;
                                        if ($tprice > 0) {
                                            $get_yacht_arr['water_sports'][] = $get_water_arr;
                                        }
                                    }
                                }
                            }
                        }

                        $get_yacht_arr['sub_total'] = $totalAmount;
                        if ($get_cart_item['reward_point_apply'] != true) {
                            $no_tax_service_total_amnt += $totalAmount;
                            $no_tax_service_total_amnt_per_product += $totalAmount;
                        }

                        $tax_amount = 0;
                        $service_charge = 0;
                        $tax_percentage = 0;
                        if ($Product->tax_allowed == 1) {
                            if ($Product->tax_percentage > 0) {
                                $tax_percentage = $Product->tax_percentage;
                                $tax_amount = ($totalAmount / 100) * $Product->tax_percentage;
                            }
                        }
                        $get_cart_item['tax_amount'] = $tax_amount;
                        $get_cart_item['tax'] = $tax_percentage;

                        if ($Product->service_allowed == 1) {
                            if ($Product->service_amount > 0) {
                                $service_charge = ConvertCurrency($Product->service_amount);
                            }
                        }
                        $get_cart_item['service_charge'] = $service_charge;

                        // Tax Service Yacht  ---------------------------------------------------------------
                        $total_tax += $tax_amount;
                        $total_service_charge += $service_charge;

                        $total_service_per_product += $service_charge;
                        $total_tax_per_product += $tax_amount;
                        $total_tax_percentage_per_product += $tax_percentage;

                        // Tax Service Yacht ---------------------------------------------------------------

                        // $forCommisontotalAmount                 += $get_yacht_arr['total_amount'];
                        $totalAmount += $get_yacht_arr['total_amount'] = $service_charge + $tax_amount;
                        $get_cart_item['option'][] = $get_yacht_arr;
                    }

                    if ($cart_value['product_type'] == 'Limousine') {
                        $get_yacht_arr = [];
                        $totalYachtAmount = 0;
                        $yacht_option = json_decode($cart_value['extra']);

                        $price = $Product->selling_price !== '' ? get_partners_dis_price(ConvertCurrency($Product->selling_price), $product_id, $request->user_id, 'base_price', 'limousine') : get_partners_dis_price(ConvertCurrency($Product->original_price), $product_id, $request->user_id, 'base_price', 'limousine');
                        if (isset($yacht_option->date)) {
                            if ($yacht_option->date != '') {
                                $WeekDay = date('l', strtotime($yacht_option->date));
                                $ProductPrice = ProductOptionWeekTour::where(['product_id' => $product_id, 'week_day' => $WeekDay, 'for_general' => 1])->first();
                                if ($ProductPrice) {
                                    $price = get_partners_dis_price(ConvertCurrency($ProductPrice->adult), $product_id, $request->user_id, 'weekdays', 'limousine');
                                }
                            } else {
                                $date = date('Y-m-d');
                                $WeekDay = date('l', strtotime($date));
                                $ProductPrice = ProductOptionWeekTour::where(['product_id' => $product_id, 'week_day' => $WeekDay, 'for_general' => 1])->first();
                                if ($ProductPrice) {
                                    $price = get_partners_dis_price(ConvertCurrency($ProductPrice->adult), $product_id, $request->user_id, 'weekdays', 'limousine');
                                }
                            }
                        } else {
                            $date = date('Y-m-d');
                            $WeekDay = date('l', strtotime($date));
                            $ProductPrice = ProductOptionWeekTour::where(['product_id' => $product_id, 'week_day' => $WeekDay, 'for_general' => 1])->first();
                            if ($ProductPrice) {
                                $price = get_partners_dis_price(ConvertCurrency($ProductPrice->adult), $product_id, $request->user_id, 'weekdays', 'limousine');
                            }
                        }

                        if (isset($yacht_option->start_time)) {
                            $startTime = $yacht_option->start_time;
                        } else {
                            $startTime = date('H');
                        }
                        if (isset($yacht_option->end_time)) {
                            $endTime = $yacht_option->end_time;
                        } else {
                            $endTime = $startTime + $yacht_option->get_hours;
                        }
                        $get_yacht_arr['title'] = 'Hour Price';
                        $get_yacht_arr['date'] = $yacht_option->date;
                        $get_yacht_arr['start_time'] = $startTime;
                        $get_yacht_arr['end_time'] = $endTime;
                        $get_yacht_arr['price'] = $price;
                        $get_cart_item['price'] = $price;
                        $get_yacht_arr['get_hours'] = $yacht_option->get_hours;
                        $hprice = $price * $yacht_option->get_hours;
                        $get_yacht_arr['total_price'] = $hprice;
                        $get_yacht_arr['guest'] = $yacht_option->guest;
                        $get_yacht_arr['hour_price'] = 1;
                        $get_yacht_arr['way'] = 0;

                        $totalAmount += $price * $yacht_option->get_hours;
                        $forCommisontotalAmount += $price * $yacht_option->get_hours;

                        foreach ($yacht_option as $yokey => $YO) {
                            if ($yokey == 'transfer_option') {
                                $get_yacht_arr['transfer_option'] = [];

                                foreach ($YO as $tkey => $TP) {
                                    $Productyachttransferoption = Productyachttransferoption::where(['id' => $TP->id])->first();
                                    if ($Productyachttransferoption) {
                                        $get_transfer_arr = [];
                                        $get_transfer_arr['title'] = $TP->title;
                                        $get_transfer_arr['way'] = 1;
                                        $get_transfer_arr['price'] = get_partners_dis_price(ConvertCurrency($Productyachttransferoption->price), $product_id, $request->user_id, 'transfer_option', 'limousine');
                                        $get_transfer_arr['get_hours'] = $TP->select_qty;
                                        $tprice = get_partners_dis_price(ConvertCurrency($Productyachttransferoption->price), $product_id, $request->user_id, 'transfer_option', 'limousine') * $TP->select_qty;
                                        $totalAmount += $tprice;
                                        $forCommisontotalAmount += $tprice;
                                        $get_transfer_arr['total_price'] = $tprice;

                                        $get_transfer_arr['hour_price'] = 1;
                                        if ($tprice > 0) {
                                            $get_yacht_arr['transfer_option'][] = $get_transfer_arr;
                                        }
                                    }
                                }
                            }
                        }

                        $get_yacht_arr['sub_total'] = $totalAmount;
                        if ($get_cart_item['reward_point_apply'] != true) {
                            $no_tax_service_total_amnt += $totalAmount;
                            $no_tax_service_total_amnt_per_product += $totalAmount;
                        }

                        $tax_amount = 0;
                        $service_charge = 0;
                        $tax_percentage = 0;
                        if ($Product->tax_allowed == 1) {
                            if ($Product->tax_percentage > 0) {
                                $tax_percentage = $Product->tax_percentage;
                                $tax_amount = ($totalAmount / 100) * $Product->tax_percentage;
                            }
                        }
                        $get_cart_item['tax_amount'] = $tax_amount;
                        $get_cart_item['tax'] = $tax_percentage;

                        if ($Product->service_allowed == 1) {
                            if ($Product->service_amount > 0) {
                                $service_charge = ConvertCurrency($Product->service_amount);
                            }
                        }

                        // Tax Service Yacht  ---------------------------------------------------------------
                        $total_tax += $tax_amount;
                        $total_service_charge += $service_charge;

                        $total_service_per_product += $service_charge;
                        $total_tax_per_product += $tax_amount;
                        $total_tax_percentage_per_product += $tax_percentage;
                        // Tax Service Yacht ---------------------------------------------------------------

                        $get_cart_item['service_charge'] = $service_charge;
                        $get_yacht_arr['total_amount'] = $totalAmount = $totalAmount + $service_charge + $tax_amount;
                        $get_cart_item['option'][] = $get_yacht_arr;
                    }

                    // $total_no_tax_service               += $no_tax_service_total_amnt;

                    $grandTotal += $get_cart_item['total'] = $totalAmount;

                    $get_cart_item['total_tax_per_product'] = $total_tax_per_product;
                    $get_cart_item['total_service_per_product'] = $total_service_per_product;
                    $get_cart_item['total_tax_percentage_per_product'] = $total_tax_percentage_per_product;
                    $get_cart_item['total_tax_percentage_per_product'] = $total_tax_percentage_per_product;
                    $get_cart_item['no_tax_service_total_amnt_per_product'] = $no_tax_service_total_amnt_per_product;
                    $get_cart_item['sum_tax_service_per_product'] = $total_service_per_product + $total_tax_per_product;

                    //Product Vouchers Start
                    // OrderProductVouchers
                    $get_vouchers_detail = [];
                    $get_cart_item['vouchers'] = [];
                    $ProductVoucher = ProductVoucher::where('product_id', $product_id)->get();
                    if (!$ProductVoucher->isEmpty()) {
                        foreach ($ProductVoucher as $key => $value) {
                            $get_vouchers = [];
                            $get_vouchers['title'] = '';
                            $get_vouchers['description'] = '';
                            $get_vouchers['remark'] = '';

                            $ProductVoucherLanguage = ProductVoucherLanguage::where('voucher_id', $value['id'])
                                ->where('language_id', $language)
                                ->first();
                            if ($ProductVoucherLanguage) {
                                if ($ProductVoucherLanguage['title']) {
                                    $get_vouchers['title'] = $ProductVoucherLanguage['title'];
                                }
                                if ($ProductVoucherLanguage['description']) {
                                    $get_vouchers['description'] = $ProductVoucherLanguage['description'];
                                }
                                if ($ProductVoucherLanguage['voucher_remark ']) {
                                    $get_vouchers['voucher_remark '] = $ProductVoucherLanguage['voucher_remark '];
                                }
                            }
                            $get_vouchers['voucher_amount'] = $value['voucher_amount'];
                            $get_vouchers['meeting_point'] = $value['meeting_point'];
                            $get_vouchers['phone_number'] = $value['phone_number'];
                            $get_vouchers['product_id'] = $value['product_id'];
                            $get_vouchers['type'] = $value['type'];
                            $get_vouchers['amount_type'] = $value['amount_type'];
                            if ($value['our_logo'] != '') {
                                $get_vouchers['our_logo'] = url('uploads/product_images', $value['our_logo']);
                            } else {
                                $get_vouchers['our_logo'] = '';
                            }
                            if ($value['voucher_image'] != '') {
                                $get_vouchers['voucher_image'] = url('uploads/product_images', $value['voucher_image']);
                            } else {
                                $get_vouchers['voucher_image'] = '';
                            }
                            if ($value['client_logo'] != '') {
                                $get_vouchers['client_logo'] = url('uploads/product_images', $value['client_logo']);
                            } else {
                                $get_vouchers['client_logo'] = '';
                            }
                            $get_cart_item['vouchers'][] = $get_vouchers;
                        }
                    }
                    //Product Vouchers Start

                    $get_products[] = $get_cart_item;

                    $get_commission_arr['product_id'] = $product_id;
                    $get_commission_arr['product_name'] = $title;
                    $get_commission_arr['commission'] = $Product->affiliate_commission;
                    $total_amnt = $totalAmount - $tax_amount - $service_charge;

                    $Currency = Currency::where('is_default', 1)->first();

                    $to = request()->currency;
                    $from = $Currency->sort_code;

                    $currentDatetime = carbon::now()->timestamp;
                    $CurrencyRatesData = CurrencyRates::where(['base' => $from, 'country_code' => $to])
                        ->where('date', '>=', $currentDatetime)
                        ->first();

                    // dd($forCommisontotalAmount);
                    $forCommisontotalAmount = $forCommisontotalAmount / $CurrencyRatesData->rate;

                    $get_commission_arr['product_amount'] = $forCommisontotalAmount;
                    // totalAmount
                    $get_commission_arr['commission_amount'] = ($forCommisontotalAmount / 100) * $Product->affiliate_commission;
                    $totalCommission += ($forCommisontotalAmount / 100) * $Product->affiliate_commission;
                    $AffilliateCommissionArr[] = $get_commission_arr;

                    // Add User Rewads Points Strt
                    //  $client_rewards_points = $Product['client_reward_point'];

                    // if ($client_rewards_points > 0) {
                    //      $RewardsPoints                = new RewardsPoints();
                    //      $RewardsPoints->user_id       = $user_id;
                    //      $RewardsPoints->product_id    = $product_id;
                    //      $RewardsPoints->type          = "products";
                    //      $RewardsPoints->points        = $client_rewards_points;

                    //      $total_client_rewards_points += $client_rewards_points;
                    //      $RewardsPoints->save();
                    //      $rewards_points_id_arr[]      = $RewardsPoints->id;
                    //  }

                    // Add User Rewads Points Strt
                    $client_rewards_points = $Product['client_reward_point'];
                    $client_reward_point_type = $Product['client_reward_point_type'];
                    if ($client_rewards_points > 0) {
                        $RewardsPoints                    = new RewardsPoints();
                        $RewardsPoints->user_id           = $user_id;
                        $RewardsPoints->product_id        = $product_id;
                        $RewardsPoints->type              = 'products';
                        $RewardsPoints->reward_point_type = $client_reward_point_type;

                        if ($client_reward_point_type == 'Percentage') {
                            $reward_point_percentage   = $client_rewards_points;
                            $client_rewards_points      = ($no_tax_service_total_amnt_per_product * $client_rewards_points) / 100;
                            $RewardsPoints->percentage = $reward_point_percentage;
                            $RewardsPoints->points     = $client_rewards_points;
                        } else {
                            $RewardsPoints->points     = $client_rewards_points;
                        }

                        $total_client_rewards_points   += $client_rewards_points;
                        $RewardsPoints->save();
                        $rewards_points_id_arr[] = $RewardsPoints->id;
                    }
                    // Add User Rewads Points End
                }
                $gift_arr = [];

                if ($cart_value['product_type'] == 'GiftCard') {
                    $gift_option = json_decode($cart_value['extra']);
                    $get_gift_arr = [];
                    $giftCardrandomId = giftCardrandomId();

                    $get_gift_arr['cart_id'] = $cart_value['id'];
                    $get_gift_arr['name'] = $gift_option->name;
                    $get_gift_arr['email'] = $gift_option->email;
                    $get_gift_arr['phone_code'] = $gift_option->phone_code;
                    $get_gift_arr['phone_number'] = $gift_option->phone_number;
                    $get_gift_arr['recipient_name'] = $gift_option->recipient_name;
                    $get_gift_arr['recipient_phone_number'] = $gift_option->recipient_phone_number;
                    $get_gift_arr['recipient_phone_code'] = $gift_option->recipient_phone_code;
                    $get_gift_arr['recipient_email'] = $gift_option->recipient_email;
                    $get_gift_arr['note'] = $gift_option->gift_title;
                    $get_gift_arr['total'] = ConvertCurrency($gift_option->amount, $gift_option->currency);
                    $no_tax_service_total_amnt += ConvertCurrency($gift_option->amount, $gift_option->currency);
                    $no_tax_service_total_amnt_per_product += ConvertCurrency($gift_option->amount, $gift_option->currency);
                    $get_gift_arr['type'] = 'GiftCard';
                    $get_gift_arr['gift_card_code'] = $giftCardrandomId;
                    // $get_cart_item['price']                 = $gift_option->amount > 0 ? $gift_option->amount : 0;
                    $get_gift_arr['image'] = asset('public/uploads/user_gift_card/' . $gift_option->image);
                    // $get_cart_item['option'][] = $get_gift_arr;

                    $gift_arr[] = $get_gift_arr;

                    // ---------------------------------------------------------
                    $ProductCheckoutGiftCard = new ProductCheckoutGiftCard();
                    $ProductCheckoutGiftCard->user_id = $user_id;
                    $ProductCheckoutGiftCard->extra = json_encode($gift_arr, true);
                    $ProductCheckoutGiftCard->gift_card_code = giftCardrandomId();
                    $ProductCheckoutGiftCard->gift_amount = ConvertCurrency($gift_option->amount, $gift_option->currency);
                    $ProductCheckoutGiftCard->gift_card_status = 'Pending';
                    $ProductCheckoutGiftCard->currency = $gift_option->currency;
                    $ProductCheckoutGiftCard->save();

                    ///Email Data
                    $email_data = [];
                    $email_data['page'] = 'email.gift_card_email';
                    $email_data['subject'] = 'Gift Card from ' . $gift_option->name;
                    $email_data['from_name'] = $gift_option->name;
                    $email_data['from_email'] = $gift_option->email;
                    $email_data['from_phone_code'] = $gift_option->phone_code;
                    $email_data['from_phone_number'] = $gift_option->phone_number;
                    $email_data['recipient_name'] = $gift_option->recipient_name;
                    $email_data['currency'] = $gift_option->currency;
                    $email_data['recipient_phone_number'] = $gift_option->recipient_phone_number;
                    $email_data['recipient_phone_code'] = $gift_option->recipient_phone_code;
                    $email_data['email'] = $gift_option->recipient_email;
                    $email_data['image'] = asset('public/uploads/user_gift_card/' . $gift_option->image);
                    $email_data['note'] = $gift_option->gift_title;
                    $email_data['amount'] = ConvertCurrency($gift_option->amount, $gift_option->currency);
                    Admin::send_mail($email_data);

                    $gift_card_id_arr[] = $ProductCheckoutGiftCard->id;
                    $get_gift_arr['id'] = $ProductCheckoutGiftCard->id;
                    // ---------------------------------------------------------

                    $get_products[] = $get_gift_arr;
                    // $grandTotal     = $grandTotal +   $gift_option->amount;
                }
            }

            // return $get_products;

            // return .'---Tax---'.$total_tax.'---service_charge--'.$total_service_charge.'---total_no_tax_service---'.$total_no_tax_service;

            //Reddem User REward Points
            if ($total_reddem_client_rewards_points > 0) {
                $User = User::where('id', $user_id)
                    ->where('is_verified', 1)
                    ->first();
                if ($User) {
                    if ($User->current_reward_points > $total_reddem_client_rewards_points) {
                        $User->current_reward_points = $User->current_reward_points - $total_reddem_client_rewards_points;
                        $User->spend_reward_points = $User->spend_reward_points + $total_reddem_client_rewards_points;
                        // -------------------
                        $User->save();
                        // -------------------
                    }
                }
            }
            //Reddem User REward Points End

            usort($get_products, function ($a, $b) {
                return $a['cart_id'] > $b['cart_id'] ? -1 : 1;
            });

            $AffilliateCommission['extra'] = json_encode($AffilliateCommissionArr);
            $AffilliateCommission['affilliate_code'] = $AffilliateCode;
            $AffilliateCommission['total'] = $totalCommission;
            $AffilliateCommission['type'] = 'product';
            if (count($get_products) > 0) {
                //Save User Reward Reward Point Start
                if ($total_client_rewards_points > 0) {
                    $User = User::where('id', $user_id)
                        ->where('is_verified', 1)
                        ->first();
                    if ($User) {
                        $User->current_reward_points = $User->current_reward_points + $client_rewards_points;
                        // -------------------
                        $User->save();
                        // -------------------
                    }
                }
                //Save User Reward REward Point Start
                $total_no_tax_service = $no_tax_service_total_amnt;
                $ProductCheckout = new ProductCheckout();
                $ProductCheckout->user_id = $user_id;
                $ProductCheckout->language_id = $language;
                $ProductCheckout->first_name = $request->first_name;
                $ProductCheckout->last_name = $request->last_name;
                $ProductCheckout->email = $request->email;
                $ProductCheckout->phone_code = $request->phone_code;
                $ProductCheckout->phone_number = $request->phone_number;
                $ProductCheckout->city = $request->city;
                $ProductCheckout->country = $request->country;
                $ProductCheckout->postcode = $request->postcode;
                $ProductCheckout->address = $request->address;

                $currency = request()->currency;
                $CurrencySymbol = CurrencySymbol::where('code', $currency)->first();

                if ($CurrencySymbol) {
                    $currency = $CurrencySymbol->symbol;
                }

                $ProductCheckout->currency = $currency;

                if ($request->coupon_id) {
                    $get_coupon_code = CouponCode::where(['id' => $request->coupon_id, 'status' => 'Active'])->first();
                    if ($get_coupon_code) {
                        $total = 0;
                        if ($get_coupon_code['coupon_value'] > 0) {
                            $coupon_value = ConvertCurrency($get_coupon_code['coupon_value']);
                            if ($get_coupon_code['coupon_type'] == 'percent') {
                                if ($total_no_tax_service > 0) {
                                    $coupon_value = ($total_no_tax_service / 100) * $coupon_value;
                                }
                            }
                            $total_no_tax_service = $total_no_tax_service - $coupon_value;
                            if ($total_no_tax_service < 0) {
                                $total_no_tax_service = 0;
                            }
                        }
                        $ProductCheckout->coupon_code_id = $get_coupon_code['id'];
                        $ProductCheckout->coupon_code = $get_coupon_code['coupon_code'];
                        $ProductCheckout->coupon_value = $coupon_value;
                    }
                }

                $grandTotal = $total_no_tax_service + $total_tax + $total_service_charge;
                if ($request->gift_card_coupon_id) {
                    $get_gift_card_coupon_code = ProductCheckoutGiftCard::where(['id' => $request->gift_card_coupon_id, 'gift_card_status' => 'Pending'])->first();
                    if ($get_gift_card_coupon_code) {
                        $total = 0;
                        $gift_card_amount = ConvertCurrency($get_gift_card_coupon_code['gift_amount'], $get_gift_card_coupon_code['currency']);

                        $AfterGiftCardTotal = $grandTotal - $gift_card_amount;

                        $ProductCheckout->giftcard_code_id = $get_gift_card_coupon_code['id'];
                        $ProductCheckout->giftcard_code = $get_gift_card_coupon_code['gift_card_code'];
                        $ProductCheckout->giftcard_value = $gift_card_amount;
                        $get_gift_card_coupon_code->gift_card_status = "Applied";
                        $get_gift_card_coupon_code->appilied_user_id = $user_id;
                        $get_gift_card_coupon_code->save();

                        if ($grandTotal < $gift_card_amount) {
                            $AfterGiftCardTotal = 0;
                            $gift_card_due_amnt = $gift_card_amount - $grandTotal;
                            $Currency = Currency::where('is_default', 1)->first();
                            if ($Currency) {
                                $to = $Currency['sort_code'];
                                $gift_card_due_amnt_ch = ConvertCurrency($gift_card_due_amnt, $to);

                                $UserWalletHistory = new UserWalletHistory();
                                $UserWalletHistory->user_id = $user_id;
                                $UserWalletHistory->amount = $gift_card_due_amnt_ch;
                                $UserWalletHistory->added_by = 'Giftcard';
                                $UserWalletHistory->save();

                                $User = User::where('id', $user_id)->first();
                                $giftcard_wallet = 0;
                                if ($User->giftcard_wallet) {
                                    $giftcard_wallet = $User->giftcard_wallet;
                                }
                                $User->giftcard_wallet = $giftcard_wallet + $gift_card_due_amnt_ch;
                                $User->save();
                            }
                        }

                        $grandTotal = $AfterGiftCardTotal;
                    }
                }

                //GiftCard Wallet Amount
                $used_gift_card_wallet_amount = 0;
                if ($giftcard_wallet_apply == 'true') {
                    $CheckWalletUser = User::where('id', $user_id)->first();
                    if ($CheckWalletUser) {
                        $giftcard_wallet = $CheckWalletUser['giftcard_wallet'];
                        $user_gift_card_wallet = $CheckWalletUser['giftcard_wallet'];
                        if ($user_gift_card_wallet > 0) {
                            $user_gift_card_wallet = ConvertCurrency($user_gift_card_wallet);
                            $after_gift_card_wallet_amnt = $grandTotal - $user_gift_card_wallet;

                            $balence_amnt = $giftcard_wallet;
                            $due_amount = 0;

                            if ($grandTotal < $user_gift_card_wallet) {
                                $after_gift_card_wallet_amnt = 0;
                                $gift_card_due_wallet_amnt = $user_gift_card_wallet - $grandTotal;
                                $Currency = Currency::where('is_default', 1)->first();

                                if ($Currency) {
                                    $to = $Currency['sort_code'];
                                    $user_gift_card_wallet_ch = ConvertCurrency($gift_card_due_wallet_amnt, $to);

                                    $balence_amnt = $giftcard_wallet - $user_gift_card_wallet_ch;
                                    $due_amount = $user_gift_card_wallet_ch;
                                }
                            }

                            $UserWalletHistory = new UserWalletHistory();
                            $UserWalletHistory->user_id = $user_id;
                            $UserWalletHistory->amount = $balence_amnt;
                            $UserWalletHistory->added_by = 'Debit';
                            $UserWalletHistory->save();

                            $CheckWalletUser->giftcard_wallet = $due_amount;
                            $CheckWalletUser->save();

                            $used_gift_card_wallet_amount = ConvertCurrency($balence_amnt);
                            $grandTotal = $after_gift_card_wallet_amnt;
                        }
                    }
                }
                //GiftCard Wallet Amount End

                $ProductCheckout->user_wallet_amount = $used_gift_card_wallet_amount;
                $ProductCheckout->sub_total = $no_tax_service_total_amnt;
                $ProductCheckout->total_tax = $total_tax;
                $ProductCheckout->total_service_tax = $total_service_charge;
                $ProductCheckout->total = $grandTotal;
                $ProductCheckout->payment_method = $request->payment_method;
                $ProductCheckout->status = 'Success';
                $ProductCheckout->extra = json_encode($get_products, true);

                $ProductCheckout->save();
                $order_id = $ProductCheckout->id;
                $custom_order_id = 'TOT' . date('Y') . str_pad($order_id, 2, '0', STR_PAD_LEFT);
                $getProductCheckout = ProductCheckout::find($order_id);
                $getProductCheckout->order_id = $custom_order_id;
                $getProductCheckout->save();
                $AllOrders = new AllOrders();
                $AllOrders->order_type = 'product';
                $AllOrders->user_id = $user_id;
                $AllOrders->order_id = $getProductCheckout->id;
                $AllOrders->save();

                $ProductCheckoutGiftCard = ProductCheckoutGiftCard::whereIn('id', $gift_card_id_arr)->update(['order_id' => $order_id]);

                //Update Order in Rewarpoints Tsble
                $UpdateRewardsPoints = RewardsPoints::whereIn('id', $rewards_points_id_arr)->update(['order_id' => $order_id]);
                //Update Order in Rewarpoints Tsble End

                $AffilliateCommission['order_id'] = $ProductCheckout->id;
                AddToCart::where('user_id', $user_id)->delete();
                $output['status'] = true;
                $output['order_id'] = encrypt($order_id);
                $output['type'] = 'product';
                $output['message'] = 'Checkout Successfully';
                $msg = 'Checkout Successfully';

                //Order MAil
                ///Email Data

                $order_email_data = [];
                $order_email_data['page'] = 'email.order_mail';
                $order_email_data['subject'] = translate('Order Detail Mail');
                $order_email_data['full_name'] = $ProductCheckout->first_name . ' ' . $ProductCheckout->last_name;
                $order_email_data['email'] = $ProductCheckout->email;
                $order_email_data['order_id'] = '#' . $ProductCheckout->order_id;
                $order_email_data['address'] = $ProductCheckout->address;
                $order_email_data['total'] = $ProductCheckout->total;
                $order_email_data['currency'] = $ProductCheckout->currency;
                $order_email_data['id'] = encrypt($ProductCheckout->id);
                $order_email_data['type'] = 'product';
                $order_email_data['order_date'] = date('Y-m-d', strtotime($ProductCheckout->created_at));
                Admin::send_mail($order_email_data);
            }
            if ($affilate_user > 0) {
                $AffilliateCommission->save();
            }
        } else {
            $output['message'] = 'No item in cart';
        }

        return json_encode($output);
    }

    // Get Date Range
    public function getDatesFromRange($start, $end, $format = 'Y-m-d')
    {
        return array_map(function ($timestamp) use ($format) {
            return date($format, $timestamp);
        }, range(strtotime($start) + ($start < $end ? 4000 : 8000), strtotime($end) + ($start < $end ? 8000 : 4000), 86400));
    }
}
