<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarDetailLanguage;
use App\Models\CarDetails;
use App\Models\Language;
use App\Models\Product;
use App\Models\ProductGroupPercentage;
use App\Models\ProductGroupPercentageDetails;
use App\Models\ProductGroupPercentageLanguage;
use App\Models\ProductOptionDetails;
use App\Models\ProductOptionGroupPercentage;
use App\Models\ProductOptionLanguage;
use App\Models\ProductOptionPeriodPricing;
use App\Models\ProductOptionPrivateTourPrice;
use App\Models\ProductOptions;
use App\Models\ProductOptionTaxServiceCharge;
use App\Models\ProductOptionTime;
use App\Models\ProductOptionTourUpgrade;
use App\Models\ProductOptionWeekTour;
use App\Models\ProductTourPriceDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BreakdownController extends Controller
{
    // Get Activity Price Break Down
    public function activity_price_brakdown(Request $request)
    {
        return 'data';
        $output = [];
        $output['status'] = true;
        $output['msg'] = 'Not Data Found';
        $validation = Validator::make($request->all(), [
            'activity_id' => 'required',
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
        $data = [];
        $total_amount = 0;
        $get_total = 0;
        $activity_id = $request->activity_id;
        $Product = Product::where('slug', $activity_id)->first();
        $activity_id = $Product->id;
        $optionID = $request->optionID;
        if (isset($request->data[$request->optionID])) {
            $data = $request->data[$request->optionID];
        }

        $req_adult_qty = 0;
        $req_child_qty = 0;
        $req_infant_qty = 0;
        $language = $request->language;

        if (isset($data['data']['tour_adult_price']['qty'])) {
            $req_adult_qty = $data['data']['tour_adult_price']['qty'];
        }
        if (isset($data['data']['tour_child_price']['qty'])) {
            $req_child_qty = $data['data']['tour_child_price']['qty'];
        }
        if (isset($data['data']['tour_infant_price']['qty'])) {
            $req_infant_qty = $data['data']['tour_infant_price']['qty'];
        }

        $totalQty = $req_adult_qty + $req_child_qty + $req_infant_qty;
        $resoponse = [];
        $PriceBreakDown = [];
        $get_product_options = ProductOptions::where('product_id', $activity_id)
            ->where('id', $optionID)
            ->where('status', 1)
            ->first();
        if ($get_product_options && count($data) > 0) {
            $adult_price = 0;
            $total_child_price = 0;
            $total_infant_price = 0;
            $adult_price = 0;
            $child_price = 0;
            $infant_price = 0;
            $get_main_option_data = [];
            $ProductOptionLanguage = ProductOptionLanguage::where('option_id', $get_product_options['id'])->first();
            //option
            $get_main_option_data['option_name'] = '';
            if ($ProductOptionLanguage) {
                $get_main_option_data['option_name'] = $ProductOptionLanguage['title'];
            }

            //Private Tour Price
            if ($get_product_options['is_private_tour'] == 1) {
                $ProductOptionPrivateTourPrice = ProductOptionPrivateTourPrice::where('product_id', $activity_id)
                    ->where('product_option_id', $get_product_options['id'])
                    ->first();

                if ($ProductOptionPrivateTourPrice) {
                    $private_per_price = $ProductOptionPrivateTourPrice['private_per_price'];
                    $total_allowed = $ProductOptionPrivateTourPrice['total_allowed'];
                    $private_tour_pasenger = $req_adult_qty;
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
                    $get_main_option_data['car_name'] = '';
                    $get_main_option_data['car_seats'] = $total_allowed;
                    $get_main_option_data['car_price'] = $private_per_price;
                    $get_main_option_data['total_cars'] = $private_tour_total_passanger_;
                    $get_main_option_data['total_pasenger'] = $private_tour_pasenger;
                    $get_main_option_data['total_private_per_price'] = $total_amount += $get_total = $total_private_per_price;
                    $get_main_option_data['infant_message'] = '';
                }
            } else {

                $get_option_tour_detail = ProductTourPriceDetails::where('product_option_id', $get_product_options['id'])
                    ->where('product_id', $activity_id)
                    ->first();

                $ProductOptionGroupPercentage = ProductOptionGroupPercentage::where(['product_id' => $activity_id, 'product_option_id' => $get_product_options['id'], 'number_of_passenger' => $totalQty])->first();

                if ($get_option_tour_detail) {

                    $adult_price = get_partners_dis_price($get_option_tour_detail['adult_price'], $activity_id, $request->user_id, 'tour_price', 'excursion');
                    $child_price = get_partners_dis_price($get_option_tour_detail['child_price'], $activity_id, $request->user_id, 'tour_price', 'excursion');
                    $infant_price =  get_partners_dis_price($get_option_tour_detail['infant_price'], $activity_id, $request->user_id, 'tour_price', 'excursion');

                    // is_week_days_id
                }

                if (isset($data['is_week_days_id']) && $data['is_week_days_id'] > 0) {
                    $get_week_tour = ProductOptionWeekTour::where(['id' => $data['is_week_days_id']])->first();
                    if ($get_week_tour) {
                        $adult_price = get_partners_dis_price($get_week_tour['adult'], $activity_id, $request->user_id, 'weekdays', 'excursion');
                        $child_price = get_partners_dis_price($get_week_tour['child_price'], $activity_id, $request->user_id, 'weekdays', 'excursion');
                        $infant_price = get_partners_dis_price($get_week_tour['infant_price'], $activity_id, $request->user_id, 'weekdays', 'excursion');
                    }
                }

                // Check Period Pricing

                if (isset($data['is_period_pricing']) && $data['is_period_pricing'] > 0) {
                    $get_period_pricing = ProductOptionPeriodPricing::where(['id' => $data['is_period_pricing']])->first();

                    if ($get_period_pricing) {
                        $adult_price = $get_period_pricing['adult_price'];
                        $child_price = $get_period_pricing['child_price'];
                        $infant_price = $get_period_pricing['infant_price'];
                    }
                }

                $AdultpercentageType = $ProductOptionGroupPercentage != '' ? $ProductOptionGroupPercentage->default_percentage : $adult_price;
                $ChildpercentageType = $ProductOptionGroupPercentage != '' ? $ProductOptionGroupPercentage->weekdays_percentage : $child_price;
                $infantpercentageType = $ProductOptionGroupPercentage != '' ? $ProductOptionGroupPercentage->period_percentage : $infant_price;
                // $adult_price = $adult_price - ($adult_price / 100) * $percentageType;
                // $child_price = $child_price - ($child_price / 100) * $percentageType;
                // $infant_price = $infant_price - ($infant_price / 100) * $percentageType;

                $adult_price = $AdultpercentageType;
                $child_price = $ChildpercentageType;
                $infant_price = $infantpercentageType;

                if ($data['is_week_days_id'] == 0 && $data['is_period_pricing'] == 0 && $ProductOptionGroupPercentage == "") {
                    if ($request->date != '' && $req_child_qty == 0 && $req_infant_qty == 0 && $get_product_options['minimum_people'] == $req_adult_qty) {
                        $WeekDay = date('l', strtotime($request->date));

                        $ProductTourPriceDetails = ProductTourPriceDetails::where(['product_id' => $activity_id, 'product_option_id' => $get_product_options['id']])->first();

                        $ProductOptionWeekTour = ProductOptionWeekTour::where(['product_id' => $activity_id, 'product_option_id' => $get_product_options['id'], 'week_day' => $WeekDay])->first();
                        $adult_price = $ProductTourPriceDetails != '' ? get_partners_dis_price($ProductTourPriceDetails->adult_price, $activity_id, $request->user_id, 'tour_price', 'excursion') : 0;
                        $infant_price = $ProductTourPriceDetails != '' ?  get_partners_dis_price($ProductTourPriceDetails->infant_price, $activity_id, $request->user_id, 'tour_price', 'excursion') : 0;
                        $child_price = $ProductTourPriceDetails != '' ? get_partners_dis_price($ProductTourPriceDetails->child_price, $activity_id, $request->user_id, 'tour_price', 'excursion') : 0;
                        $infant_allowed = $ProductTourPriceDetails != '' ? $ProductTourPriceDetails->infant_allowed : 0;
                        $child_allowed = $ProductTourPriceDetails != '' ? $ProductTourPriceDetails->child_allowed : 0;
                        $weekDayID = 0;
                        $is_period_pricing = 0;
                        if ($ProductOptionWeekTour != '') {
                            $adult_price = $ProductOptionWeekTour->adult != '' ? get_partners_dis_price($ProductOptionWeekTour->adult, $activity_id, $request->user_id, 'weekdays', 'excursion') : 0;
                            $child_price = $ProductOptionWeekTour->child_price != '' ? get_partners_dis_price($ProductOptionWeekTour->child_price, $activity_id, $request->user_id, 'weekdays', 'excursion') : 0;
                            $infant_price = $ProductOptionWeekTour->infant_price != '' ?  get_partners_dis_price($ProductOptionWeekTour->infant_price, $activity_id, $request->user_id, 'weekdays', 'excursion') : 0;
                            $child_allowed = $ProductOptionWeekTour->child_allowed != '' ? $ProductOptionWeekTour->child_allowed : 0;
                            $infant_allowed = $ProductOptionWeekTour->infant_allowed != '' ? $ProductOptionWeekTour->infant_allowed : 0;
                            $weekDayID = $ProductOptionWeekTour->id;
                        }

                        $date = Carbon::now();
                        $ProductOptiossnPeriodPricing = ProductOptionPeriodPricing::where(['product_id' => $activity_id, 'product_option_id' => $get_product_options['id']])
                            ->whereDate('from_date', '<=', $request->date)
                            ->whereDate('to_date', '>=', $request->date)
                            ->first();
                        if ($ProductOptiossnPeriodPricing != '') {
                            $adult_price = $ProductOptiossnPeriodPricing->adult_price != '' ? $ProductOptiossnPeriodPricing->adult_price : 0;
                            $child_price = $ProductOptiossnPeriodPricing->child_price != '' ? $ProductOptiossnPeriodPricing->child_price : 0;
                            $infant_price = $ProductOptiossnPeriodPricing->infant_price != '' ? $ProductOptiossnPeriodPricing->infant_price : 0;
                            $child_allowed = $ProductOptiossnPeriodPricing->child_allowed != '' ? $ProductOptiossnPeriodPricing->child_allowed : 0;
                            $infant_allowed = $ProductOptiossnPeriodPricing->infant_allowed != '' ? $ProductOptiossnPeriodPricing->infant_allowed : 0;
                            $weekDayID = 0;
                            $is_period_pricing = $ProductOptiossnPeriodPricing->id;
                        }
                    }
                }

                $total_adult_price = $adult_price * $req_adult_qty;
                $total_child_price = $child_price * $req_child_qty;
                $total_infant_price = $infant_price * $req_infant_qty;
                $total_amount += $get_total = $total_adult_price + $total_child_price + $total_infant_price;

                $get_main_option_data['total_adult_price'] = $total_adult_price;
                $get_main_option_data['total_child_price'] = $total_child_price;
                $get_main_option_data['total_infant_price'] = $total_infant_price;
            }

            $get_main_option_data['adult_price'] = $adult_price > 0 ? $adult_price : 'N/A';
            $get_main_option_data['child_price'] = $child_price > 0 ? $child_price : 'N/A';
            $get_main_option_data['infant_price'] = $infant_price > 0 ? $infant_price : 'N/A';
            $get_main_option_data['req_adult_qty'] = $req_adult_qty > 0 ? $req_adult_qty : 'N/A';
            $get_main_option_data['req_child_qty'] = $req_child_qty > 0 ? $req_child_qty : 'N/A';
            $get_main_option_data['req_infant_qty'] = $req_infant_qty > 0 ? $req_infant_qty : 'N/A';
            $get_main_option_data['is_private_tour'] = $get_product_options['is_private_tour'];
            $get_main_option_data['car_status'] = 0;
            $get_main_option_data['total'] = number_format($get_total, 2);
            $PriceBreakDown[] = $get_main_option_data;

            //Tour OPtion
            $get_tour_option_arr = [];
            if (isset($data['tour_transfer_id'])) {
                if ($data['tour_transfer_id'] > 0) {
                    $total_car_price = 0;
                    $get_option_details = ProductOptionDetails::where('product_id', $activity_id)
                        ->where('product_option_id', $request->optionID)
                        ->where('id', $data['tour_transfer_id'])
                        ->first();
                    if ($get_option_details) {
                        $get_tour_option_arr['car_status'] = 0;
                        $adult_price = get_partners_dis_price($get_option_details['edult'], $activity_id, $request->user_id, 'transfer_option', 'excursion');
                        $child_price = get_partners_dis_price($get_option_details['child_price'], $activity_id, $request->user_id, 'transfer_option', 'excursion');
                        $infant_price =  get_partners_dis_price($get_option_details['infant'], $activity_id, $request->user_id, 'transfer_option', 'excursion');
                        $total_adult_price = $adult_price * $req_adult_qty;
                        $total_child_price = $child_price * $req_child_qty;
                        $total_infant_price = $infant_price * $req_infant_qty;

                        if ($get_option_details['is_input'] == 0) {
                            $car_seats = 0;
                            $car_price = 0;
                            $total_pasenger = $req_adult_qty + $req_child_qty;
                            if (isset($data['private_car'])) {
                                $get_car_detail = CarDetails::where('id', $data['private_car'])
                                    ->where('status', 'Active')
                                    ->first();
                                if ($get_car_detail) {
                                    $get_car_name = CarDetailLanguage::where('car_details_id', $get_car_detail['id'])
                                        ->where('language_id', $language)
                                        ->first();

                                    $car_price = $get_car_detail['price'];
                                    $car_seats = $get_car_detail['number_of_passengers'];

                                    if ($total_pasenger == 0) {
                                        $car_price = 0;
                                    }
                                    $get_tour_option_arr['car_status'] = 1;
                                    $get_tour_option_arr['car_name'] = $get_car_name['title'];
                                    $get_tour_option_arr['car_seats'] = $car_seats;
                                    $get_tour_option_arr['car_price'] = $car_price;
                                    $get_tour_option_arr['total_pasenger'] = $total_pasenger;
                                    $get_tour_option_arr['infant_message'] = translate('Infant Not Countable in Private Car');

                                    if ($car_seats > 0) {
                                        if ($total_pasenger > $car_seats) {
                                            $total_passanger_ = ceil($total_pasenger / $car_seats);
                                        } else {
                                            $total_passanger_ = 1;
                                        }
                                        $total_car_price = $car_price * $total_passanger_;
                                    }
                                    $get_tour_option_arr['total_cars'] = $total_passanger_;
                                    $total_amount += $get_total = $total_car_price;
                                }
                            }
                        } else {
                            $total_amount += $get_total = $total_adult_price + $total_child_price + $total_infant_price;
                        }

                        $get_tour_option_arr['option_name'] = '';
                        if ($get_option_details['transfer_option']) {
                            $get_tour_option_arr['option_name'] = $get_option_details['transfer_option'];
                        }

                        $get_tour_option_arr['adult_price'] = $get_option_details['edult'] > 0 ?  get_partners_dis_price($get_option_details['edult'], $activity_id, $request->user_id, 'transfer_option', 'excursion') : 'N/A';
                        $get_tour_option_arr['child_price'] = $get_option_details['child_price'] > 0 ? get_partners_dis_price($get_option_details['child_price'], $activity_id, $request->user_id, 'transfer_option', 'excursion') : 'N/A';
                        $get_tour_option_arr['infant_price'] = $get_option_details['infant'] > 0 ? get_partners_dis_price($get_option_details['infant'], $activity_id, $request->user_id, 'transfer_option', 'excursion') : 'N/A';
                        $get_tour_option_arr['req_adult_qty'] = $req_adult_qty > 0 ? $req_adult_qty : 'N/A';
                        $get_tour_option_arr['req_child_qty'] = $req_child_qty > 0 ? $req_child_qty : 'N/A';
                        $get_tour_option_arr['req_infant_qty'] = $req_infant_qty > 0 ? $req_infant_qty : 'N/A';
                        $get_tour_option_arr['total_adult_price'] = $total_adult_price;
                        $get_tour_option_arr['total_child_price'] = $total_child_price;
                        $get_tour_option_arr['total_infant_price'] = $total_infant_price;
                        $get_tour_option_arr['total'] = $get_total;
                    }
                    $PriceBreakDown[] = $get_tour_option_arr;
                }
            }

            //Upgrade Option
            $get_upgrade_option = [];
            // print_die($tour_upgrade_arr);
            if (isset($data['data']['tour_adult_price']['tour_upgrade_arr'])) {
                $tour_upgrade_arr = $data['data']['tour_adult_price']['tour_upgrade_arr'];
                foreach ($tour_upgrade_arr as $upgrade_key => $tour_upgrade_value) {
                    $get_product_option_tour_upgrade = ProductOptionTourUpgrade::where('id', $tour_upgrade_value['id'])->first();
                    if ($get_product_option_tour_upgrade) {
                        $get_upgrade_arr = [];

                        $req_adult_qty = 0;
                        $req_child_qty = 0;
                        $req_infant_qty = 0;
                        $adult_price = get_partners_dis_price($get_product_option_tour_upgrade['adult_price'], $activity_id, $request->user_id, 'tour_upgrade_option', 'excursion') ?? 0;
                        $child_price =  get_partners_dis_price($get_product_option_tour_upgrade['child_price'], $activity_id, $request->user_id, 'tour_upgrade_option', 'excursion') ?? 0;
                        $infant_price = get_partners_dis_price($get_product_option_tour_upgrade['infant_price'], $activity_id, $request->user_id, 'tour_upgrade_option', 'excursion') ?? 0;

                        if ($tour_upgrade_value['qty']) {
                            $req_adult_qty = $tour_upgrade_value['qty'];
                        }
                        if (isset($data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                            $req_child_qty = $data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                        }
                        if (isset($data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                            $req_infant_qty = $data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                        }

                        $total_adult_price = $adult_price * $req_adult_qty;
                        $total_child_price = $child_price * $req_child_qty;
                        $total_infant_price = $infant_price * $req_infant_qty;
                        $total_amount += $get_total = $total_adult_price + $total_child_price + $total_infant_price;

                        $get_upgrade_arr['option_name'] = $get_product_option_tour_upgrade['title'] ?? '';
                        $get_upgrade_arr['adult_price'] = $adult_price > 0 ? $adult_price : 'N/A';
                        $get_upgrade_arr['child_price'] = $child_price > 0 ? $child_price : 'N/A';
                        $get_upgrade_arr['infant_price'] = $infant_price > 0 ? $infant_price : 'N/A';
                        $get_upgrade_arr['req_adult_qty'] = $req_adult_qty > 0 ? $req_adult_qty : 'N/A';
                        $get_upgrade_arr['req_child_qty'] = $req_child_qty > 0 ? $req_child_qty : 'N/A';
                        $get_upgrade_arr['req_infant_qty'] = $req_infant_qty > 0 ? $req_infant_qty : 'N/A';
                        $get_upgrade_arr['total_adult_price'] = $total_adult_price;
                        $get_upgrade_arr['total_child_price'] = $total_child_price;
                        $get_upgrade_arr['total_infant_price'] = $total_infant_price;
                        $get_upgrade_arr['car_status'] = 0;
                        $get_upgrade_arr['total'] = $get_total;
                        $PriceBreakDown[] = $get_upgrade_arr;
                    }
                }
            }
            $output['status'] = true;
            $output['msg'] = 'Data Fetched Successfully...';
        }

        $service_charge = 0;
        $tax = 0;
        $tax_amount = 0;
        $resoponse['service_charge'] = 0;
        $resoponse['total_amount'] = 0;
        $resoponse['tax'] = 0;
        $get_option_service_charge = ProductOptionTaxServiceCharge::where('product_option_id', $optionID)
            ->where('product_id', $activity_id)
            ->first();
        if ($get_option_service_charge) {
            if ($get_option_service_charge['service_charge_allowed'] == 1) {
                $service_charge = $get_option_service_charge['service_charge_amount'] != '' ? $get_option_service_charge['service_charge_amount'] : 0;
            }
            if ($get_option_service_charge['tax_allowed'] == 1) {
                $tax = $get_option_service_charge['tax_percentage'] != '' ? $get_option_service_charge['tax_percentage'] : 0;
            }
        }
        if ($tax != 0 && $total_amount != 0) {
            $tax_amount = ($total_amount / 100) * $tax;
        }

        $resoponse['price_break_down'] = $PriceBreakDown;
        $resoponse['tax_amount'] = number_format($tax_amount, 2);
        $resoponse['sub_total'] = number_format($total_amount, 2);
        if ($total_amount != 0) {
            $resoponse['service_charge'] = $service_charge;
            $resoponse['tax'] = number_format($tax, 2);
            $resoponse['total_amount'] = number_format($total_amount + $service_charge + $tax_amount, 2);
        }
        $output['data'] = $resoponse;
        return json_encode($output);
    }

    // Get Time Sloats
    //Get Tour Option Time
    public function get_tour_option_time(Request $request)
    {
        $output = [];
        $output['status'] = true;
        $output['msg'] = 'No Timeslots Available ';
        $validation = Validator::make($request->all(), [
            'activity_id' => 'required',
            'option_id' => 'required',
            'date' => 'required',
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

        $request_date = date('Y-m-d', strtotime($request->date));
        $get_time_id = [];
        $get_option = [];
        $activity_id = $request->activity_id;
        $Product = Product::where('slug', $activity_id)->first();
        $activity_id = $Product->id;
        $totalQty = $request->qty;

        $WeekDay = date('l', strtotime($request->date));
        $ProductOptionGroupPercentage = ProductOptionGroupPercentage::where(['product_id' => $activity_id, 'product_option_id' => $request->option_id, 'number_of_passenger' => $totalQty])->first();
        $ProductTourPriceDetails = ProductTourPriceDetails::where(['product_id' => $activity_id, 'product_option_id' => $request->option_id])->first();


        $ProductOptionWeekTour = ProductOptionWeekTour::where(['product_id' => $activity_id, 'product_option_id' => $request->option_id, 'week_day' => $WeekDay])->first();
        $adult_price = $ProductTourPriceDetails != '' ? $ProductTourPriceDetails->adult_price : 0;
        $infant_price = $ProductTourPriceDetails != '' ? $ProductTourPriceDetails->infant_price : 0;
        $child_price = $ProductTourPriceDetails != '' ? $ProductTourPriceDetails->child_price : 0;
        $infant_allowed = $ProductTourPriceDetails != '' ? $ProductTourPriceDetails->infant_allowed : 0;
        $child_allowed = $ProductTourPriceDetails != '' ? $ProductTourPriceDetails->child_allowed : 0;
        $weekDayID = 0;
        $is_period_pricing = 0;
        if ($ProductOptionWeekTour != '') {
            $adult_price = $ProductOptionWeekTour->adult != '' ? $ProductOptionWeekTour->adult : 0;
            $child_price = $ProductOptionWeekTour->child_price != '' ? $ProductOptionWeekTour->child_price : 0;
            $infant_price = $ProductOptionWeekTour->infant_price != '' ? $ProductOptionWeekTour->infant_price : 0;
            $child_allowed = $ProductOptionWeekTour->child_allowed != '' ? $ProductOptionWeekTour->child_allowed : 0;
            $infant_allowed = $ProductOptionWeekTour->infant_allowed != '' ? $ProductOptionWeekTour->infant_allowed : 0;
            $weekDayID = $ProductOptionWeekTour->id;
        }

        $date = Carbon::now();
        $ProductOptiossnPeriodPricing = ProductOptionPeriodPricing::where(['product_id' => $activity_id, 'product_option_id' => $request->option_id])
            ->whereDate('from_date', '<=', $request->date)
            ->whereDate('to_date', '>=', $request->date)
            ->first();
        if ($ProductOptiossnPeriodPricing != '') {
            $adult_price = $ProductOptiossnPeriodPricing->adult_price != '' ? $ProductOptiossnPeriodPricing->adult_price : 0;
            $child_price = $ProductOptiossnPeriodPricing->child_price != '' ? $ProductOptiossnPeriodPricing->child_price : 0;
            $infant_price = $ProductOptiossnPeriodPricing->infant_price != '' ? $ProductOptiossnPeriodPricing->infant_price : 0;
            $child_allowed = $ProductOptiossnPeriodPricing->child_allowed != '' ? $ProductOptiossnPeriodPricing->child_allowed : 0;
            $infant_allowed = $ProductOptiossnPeriodPricing->infant_allowed != '' ? $ProductOptiossnPeriodPricing->infant_allowed : 0;
            $weekDayID = 0;
            $is_period_pricing = $ProductOptiossnPeriodPricing->id;
        }

        // if ($data['is_week_days_id'] == 0 && $data['is_period_pricing'] == 0) {
        //     if ($request->date != '' && $req_child_qty == 0 && $req_infant_qty == 0 && $get_product_options['minimum_people'] == $req_adult_qty) {
        //         $WeekDay = date('l', strtotime($request->date));

        //         $ProductTourPriceDetails = ProductTourPriceDetails::where(['product_id' => $activity_id, 'product_option_id' => $get_product_options['id']])->first();

        //         $ProductOptionWeekTour = ProductOptionWeekTour::where(['product_id' => $activity_id, 'product_option_id' => $get_product_options['id'], 'week_day' => $WeekDay])->first();
        //         $adult_price = $ProductTourPriceDetails != '' ? $ProductTourPriceDetails->adult_price : 0;
        //         $infant_price = $ProductTourPriceDetails != '' ? $ProductTourPriceDetails->infant_price : 0;
        //         $child_price = $ProductTourPriceDetails != '' ? $ProductTourPriceDetails->child_price : 0;
        //         $infant_allowed = $ProductTourPriceDetails != '' ? $ProductTourPriceDetails->infant_allowed : 0;
        //         $child_allowed = $ProductTourPriceDetails != '' ? $ProductTourPriceDetails->child_allowed : 0;
        //         $weekDayID = 0;
        //         $is_period_pricing = 0;
        //         if ($ProductOptionWeekTour != '') {
        //             $adult_price = $ProductOptionWeekTour->adult != '' ? $ProductOptionWeekTour->adult : 0;
        //             $child_price = $ProductOptionWeekTour->child_price != '' ? $ProductOptionWeekTour->child_price : 0;
        //             $infant_price = $ProductOptionWeekTour->infant_price != '' ? $ProductOptionWeekTour->infant_price : 0;
        //             $child_allowed = $ProductOptionWeekTour->child_allowed != '' ? $ProductOptionWeekTour->child_allowed : 0;
        //             $infant_allowed = $ProductOptionWeekTour->infant_allowed != '' ? $ProductOptionWeekTour->infant_allowed : 0;
        //             $weekDayID = $ProductOptionWeekTour->id;
        //         }

        //         $date = Carbon::now();
        //         $ProductOptiossnPeriodPricing = ProductOptionPeriodPricing::where(['product_id' => $activity_id, 'product_option_id' => $get_product_options['id']])
        //             ->whereDate('from_date', '<=', $request->date)
        //             ->whereDate('to_date', '>=', $request->date)
        //             ->first();
        //         if ($ProductOptiossnPeriodPricing != '') {
        //             $adult_price = $ProductOptiossnPeriodPricing->adult_price != '' ? $ProductOptiossnPeriodPricing->adult_price : 0;
        //             $child_price = $ProductOptiossnPeriodPricing->child_price != '' ? $ProductOptiossnPeriodPricing->child_price : 0;
        //             $infant_price = $ProductOptiossnPeriodPricing->infant_price != '' ? $ProductOptiossnPeriodPricing->infant_price : 0;
        //             $child_allowed = $ProductOptiossnPeriodPricing->child_allowed != '' ? $ProductOptiossnPeriodPricing->child_allowed : 0;
        //             $infant_allowed = $ProductOptiossnPeriodPricing->infant_allowed != '' ? $ProductOptiossnPeriodPricing->infant_allowed : 0;
        //             $weekDayID = 0;
        //             $is_period_pricing = $ProductOptiossnPeriodPricing->id;
        //         }
        //     }
        // }

        $AdultpercentageType = $ProductOptionGroupPercentage != '' ? $ProductOptionGroupPercentage->default_percentage : $adult_price;
        $ChildpercentageType = $ProductOptionGroupPercentage != '' ? $ProductOptionGroupPercentage->weekdays_percentage : $child_price;
        $infantpercentageType = $ProductOptionGroupPercentage != '' ? $ProductOptionGroupPercentage->period_percentage : $infant_price;


        $adult_price = $AdultpercentageType;
        $child_price = $ChildpercentageType;
        $infant_price = $infantpercentageType;


        $get_option['adult_price'] = $adult_price;
        $get_option['child_price'] = $child_price;
        $get_option['infant_price'] = $infant_price;
        $get_option['infant_allowed'] = $infant_allowed;
        $get_option['child_allowed'] = $child_allowed;
        $get_option['is_week_days_id'] = $weekDayID;
        $get_option['is_period_pricing'] = $is_period_pricing;
        $get_option['total'] = $adult_price * $request->qty;

        $getProductOptions = ProductOptions::where('id', $request->option_id)
            ->where('product_id', $activity_id)
            ->where('status', 1)
            ->first();
        if ($getProductOptions) {
            if ($getProductOptions->available_type == 'daily') {
                if ($getProductOptions->time_available) {
                    $get_time_id = explode(',', $getProductOptions->time_available);
                }
            }

            if ($getProductOptions->available_type == 'date_available') {
                if ($getProductOptions->date_available) {
                    $get_dates = (array) json_decode($getProductOptions->date_available, true);
                    if (array_key_exists($request_date, $get_dates)) {
                        if (isset($get_dates[$request_date]) && $get_dates[$request_date] != '') {
                            $get_time_id = explode(',', $get_dates[$request_date]);
                        }
                    }
                }
            }

            if ($getProductOptions->available_type == 'days_available') {
                $day = date('l', strtotime($request->date));
                if ($getProductOptions->days_available) {
                    $get_days = (array) json_decode($getProductOptions->days_available, true);
                    if (array_key_exists($day, $get_days)) {
                        if (isset($get_days[$day]) && $get_days[$day] != '') {
                            $get_time_id = explode(',', $get_days[$day]);
                        }
                    }
                }
            }
            $get_option['option_id'] = $getProductOptions['id'];
            $get_option['product_id'] = $getProductOptions['product_id'];
            $get_option['time_sloats'] = [];
            if (count($get_time_id) > 0) {
                $ProductOptionTime = ProductOptionTime::whereIn('id', $get_time_id)
                    ->where('status', 1)
                    ->get();
                foreach ($ProductOptionTime as $key => $value) {
                    $get_time_arr = [];
                    $get_time_arr['time_id'] = $value['id'];
                    $get_time_arr['time'] = $value['title'];
                    $get_option['time_sloats'][] = $get_time_arr;
                }
                $output['msg'] = 'Time Slots Data';
                $output['status'] = true;
            }
            $output['data'] = $get_option;
            return json_encode($output);
        }
    }

    // Get Group Rates Option Time
    public function get_group_tour_option_time(Request $request)
    {
        $output = [];
        $output['status'] = true;
        $output['msg'] = 'No Timeslots Available ';
        $validation = Validator::make($request->all(), [
            'activity_id' => 'required',
            'option_id' => 'required',
            'date' => 'required',
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

        $request_date = date('Y-m-d', strtotime($request->date));
        $get_time_id = [];
        $get_option = [];
        $activity_id = $request->activity_id;
        $Product = Product::where('slug', $activity_id)->first();
        $activity_id = $Product->id;

        $ProductGroupPercentage = ProductGroupPercentage::where('id', $request->option_id)
            ->where('product_id', $activity_id)
            ->where('status', 1)
            ->first();
        if ($ProductGroupPercentage) {
            if ($ProductGroupPercentage->available_type == 'daily') {
                if ($ProductGroupPercentage->time_available) {
                    $get_time_id = explode(',', $ProductGroupPercentage->time_available);
                }
            }

            if ($ProductGroupPercentage->available_type == 'date_available') {
                if ($ProductGroupPercentage->date_available) {
                    $get_dates = (array) json_decode($ProductGroupPercentage->date_available, true);
                    if (array_key_exists($request_date, $get_dates)) {
                        if (isset($get_dates[$request_date]) && $get_dates[$request_date] != '') {
                            $get_time_id = explode(',', $get_dates[$request_date]);
                        }
                    }
                }
            }

            if ($ProductGroupPercentage->available_type == 'days_available') {
                $day = date('l', strtotime($request->date));
                if ($ProductGroupPercentage->days_available) {
                    $get_days = (array) json_decode($ProductGroupPercentage->days_available, true);
                    if (array_key_exists($day, $get_days)) {
                        if (isset($get_days[$day]) && $get_days[$day] != '') {
                            $get_time_id = explode(',', $get_days[$day]);
                        }
                    }
                }
            }
            $get_option['option_id'] = $ProductGroupPercentage['id'];
            $get_option['product_id'] = $ProductGroupPercentage['product_id'];
            $get_option['time_sloats'] = [];
            if (count($get_time_id) > 0) {
                $ProductOptionTime = ProductOptionTime::whereIn('id', $get_time_id)
                    ->where('status', 1)
                    ->get();
                foreach ($ProductOptionTime as $key => $value) {
                    $get_time_arr = [];
                    $get_time_arr['time_id'] = $value['id'];
                    $get_time_arr['time'] = $value['title'];
                    $get_option['time_sloats'][] = $get_time_arr;
                }
                $output['msg'] = 'Time Slots Data';
                $output['status'] = true;
            }
            $output['data'] = $get_option;
            return json_encode($output);
        }
    }

    // Get Group Rates BreakDown
    public function activity_group_rates_breakdown(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['msg'] = 'Not Data Found';
        $validation = Validator::make($request->all(), [
            'activity_id' => 'required',
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
        $data = [];
        $total_amount = 0;
        $get_total = 0;
        $activity_id = $request->activity_id;
        $language = $request->language;
        $Product = Product::where('slug', $activity_id)->first();
        $activity_id = $Product->id;
        $optionID = $request->optionID;
        $qty = $request->data;
        $BreakDown = [];
        $ProductGroupPercentage = ProductGroupPercentage::where(['id' => $optionID, 'product_id' => $activity_id])->first();
        $ProductGroupPercentageLanguage = ProductGroupPercentageLanguage::where(['product_id' => $activity_id])->get();
        if ($ProductGroupPercentage) {
            $ProductGroupPercentageDetails = ProductGroupPercentageDetails::where(['product_id' => $activity_id])
                ->where('number_of_pax', '>=', $qty)
                ->where('number_of_pax', '<=', $qty)
                ->orderBy('number_of_pax', 'asc')
                ->first();

            $amount = $ProductGroupPercentage->group_price;

            if ($ProductGroupPercentageDetails) {
                $amount = $ProductGroupPercentageDetails->group_price;
            } else {
                $ProductGroupPercentageDetails = ProductGroupPercentageDetails::where(['product_id' => $activity_id])
                    ->where('number_of_pax', '>=', $qty)
                    ->orderBy('number_of_pax', 'asc')
                    ->first();
                if ($ProductGroupPercentageDetails) {
                    $amount = $ProductGroupPercentageDetails->group_price;
                }
            }
            $BreakDown['title'] = getLanguageTranslate($ProductGroupPercentageLanguage, $language, $optionID, 'title', 'group_percentage_id');

            $group_price = 0;
            if ($qty <= 0) {
                $amount = 0;
            } else {
                $group_price = $amount / $qty;
            }
            $BreakDown['qty'] = $qty;
            $BreakDown['total'] = $amount;
            $BreakDown['group_price'] = $group_price;
            $output['status'] = true;
            $output['msg'] = 'Data Found';
        }
        $output['data'] = $BreakDown;
        return json_encode($output);
    }
}
