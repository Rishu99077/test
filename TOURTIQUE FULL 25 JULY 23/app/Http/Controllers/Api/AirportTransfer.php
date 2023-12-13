<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Country;
use App\Models\States;
use App\Models\City;
use App\Models\Transfer;
use App\Models\TransferLanguage;
use App\Models\Currency;
use App\Models\CurrencyRates;
use App\Models\AirportModel;
use App\Models\TransferHighlights;
use App\Models\TransferCarType;
use App\Models\TransferHighlightsLanguage;
use App\Models\CurrencySymbol;
use App\Models\TransferExtrasOptions;
use App\Models\TransferExtrasOptionsLanguage;
use App\Models\TransferExtras;
use App\Models\TransferExtrasLanguage;
use App\Models\ProductToolTipLanguage;
use App\Models\TransferZones;
use App\Models\AirportTranferRequest;
use App\Models\Locations;
use App\Models\AffilliateCommission;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use App\Models\AirportTransferCheckOut;
use App\Models\TransferBusType;
use App\Models\RewardsPoints;
use App\Models\Admin;
use App\Models\AllOrders;


use App\Models\LocationDistanceTiming;
use App\Models\ProductVoucher;
use App\Models\ProductVoucherLanguage;

require_once __DIR__ . "../../../../../public/plugin/dompdf/autoload.inc.php";

use Dompdf\Dompdf;


class AirportTransfer extends Controller
{
    // Transfer Products
    public function index(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            // 'transfer_id'  => 'required',
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

        $transfer_id     = $request->transfer_id;
        $language_id = $request->language;
        $Transfer = Transfer::where('is_delete', '0')
            ->orderBy('id', 'desc')
            ->get();
        $transferDeatils = [];
        if (!$Transfer->isEmpty()) {
            foreach ($Transfer as $key => $value) {
                $get_product_arr = [];
                $get_product_arr['transfer_id'] = $value['id'];

                //Country
                $get_product_arr['country'] = '';
                if ($value['country'] != '') {
                    $get_product_arr['country'] = $value['country'];
                    $get_product_arr['country_name'] = '';
                    $get_country = Country::where('id', $value['country'])->first();
                    if ($get_country) {
                        $get_product_arr['country_name'] = $get_country['name'];
                    }
                }

                //State
                $get_product_arr['state'] = '';
                if ($value['state'] != '') {
                    $get_product_arr['state'] = $value['state'];
                    $get_product_arr['state_name'] = '';
                    $get_state = States::where('id', $Transfer['state'])->first();
                    if ($get_state) {
                        $get_product_arr['state_name'] = $get_state['name'];
                    }
                }

                //City
                $get_product_arr['city'] = '';
                if ($value['city'] != '') {
                    $get_product_arr['city'] = $value['city'];
                    $get_product_arr['city_name'] = '';
                    $get_city = City::where('id', $value['city'])->first();
                    if ($get_city) {
                        $get_product_arr['city_name'] = $get_city['name'];
                    }
                }
            }

            //Country
            $transferDeatils['country'] = '';
            if ($Transfer['country'] != '') {
                $transferDeatils['country'] = $Transfer['country'];
                $transferDeatils['country_name'] = '';
                $get_country = Country::where('id', $Transfer['country'])->first();
                if ($get_country) {
                    $transferDeatils['country_name'] = $get_country['name'];
                }
            }

            //State
            $transferDeatils['state'] = '';
            if ($Transfer['state'] != '') {
                $transferDeatils['state'] = $Transfer['state'];
                $transferDeatils['state_name'] = '';
                $get_state = States::where('id', $Transfer['state'])->first();
                if ($get_state) {
                    $transferDeatils['state_name'] = $get_state['name'];
                }
            }

            //City
            $transferDeatils['city'] = '';
            if ($Transfer['city'] != '') {
                $transferDeatils['city'] = $Transfer['city'];
                $transferDeatils['city_name'] = '';
                $get_city = City::where('id', $Transfer['city'])->first();
                if ($get_city) {
                    $transferDeatils['city_name'] = $get_city['name'];
                }
            }
            $transferDeatils['image'] = $Transfer['main_image'] != '' ? url('uploads/Transfer_images', $Transfer['main_image']) : asset('uploads/placeholder/placeholder.png');

            $transferDeatils['title'] = '';
            $transferDeatils['description'] = '';

            $get_transfer_language = TransferLanguage::where('transfer_id', $transfer_id)
                ->where('language_id', $language_id)
                ->first();
            if ($get_transfer_language) {
                $transferDeatils['title'] = $get_transfer_language['title'];
                $transferDeatils['description'] = $get_transfer_language['description'];
            }

            $transferDeatils['airport_name'] = '';
            $get_airport = AirportModel::where('id', $Transfer['airport'])
                ->where('is_delete', '0')
                ->first();
            if ($get_airport) {
                $transferDeatils['airport_name'] = $get_airport['name'];
            }

            //Why Book Transfer
            // $transferDeatils['why_book_tranfer'] = array();
            // $get_why_book_tran                   = TransferWhyBook::where('transfer_id',$transfer_id)->get();
            // if(!$get_why_book_tran->isEmpty()){
            //     foreach($get_why_book_tran as $why_key => $why_value){
            //         $get_why_book_arr            = array();
            //         $get_why_book_arr['']            = array();
            //     }
            // }

            //highlights
            $transferDeatils['highlights'] = [];
            $get_highlights = TransferHighlights::where('transfer_id', $transfer_id)->get();
            if (!$get_highlights->isEmpty()) {
                foreach ($get_highlights as $highlight_key => $high_value) {
                    $get_highlight_arr = [];
                    $get_highlight_arr['title'] = '';
                    $get_highlight_arr['description'] = '';
                    $get_highlight_language = TransferHighlightsLanguage::where('highlights_id', $high_value['id'])
                        ->where('language_id', $language_id)
                        ->first();
                    if ($get_highlight_language) {
                        $get_highlight_arr['title'] = $get_highlight_language['title'] != '' ? $get_highlight_language['title'] : '';
                        $get_highlight_arr['description'] = $get_highlight_language['description'] != '' ? $get_highlight_language['description'] : '';
                    }
                    $transferDeatils['highlights'][] = $get_highlight_arr;
                }
            }

            $output['data'] = $transferDeatils;
            $output['status'] = true;
            $output['msg'] = 'Data Fetched Successfully...';
        }
        return json_encode($output);
    }

    // Transfer List
    public function airport_transfer_list(Request $request)
    {
        $output = [];


        $output['status'] = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            // 'transfer_id'  => 'required',
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
        $setLimit = 9;
        $offset  = $request->offset;
        $limit =  $offset * $setLimit;

        if (isset($request->id)) {
            $TransferID = $request->id;
        } else {
            $TransferID = 0;
        }
        $language_id = $request->language;
        $ProductCount = 0;
        $total_qty = 0;
        if ($TransferID > 0) {
            $Transfer = Transfer::where(['id' => $TransferID])->get();
        } else {
            if (isset($request->airportData)) {
                $ProductCount = Transfer::select('transfer.*')
                    ->where(['transfer.is_delete' => 0, 'transfer.status' => 'Active'])
                    ->join("transfer_language", 'transfer.id', '=', 'transfer_language.transfer_id')->groupBy('transfer.id')->count();

                $Transfer =  Transfer::select('transfer.*')
                    ->where(['transfer.is_delete' => 0, 'transfer.status' => 'Active'])
                    ->join("transfer_language", 'transfer.id', '=', 'transfer_language.transfer_id')->groupBy('transfer.id');
                $TransferData = [];

                if (isset($request->airportData)) {
                    if ($request->airportData['airport_id'] != "") {

                        // $Transfer = $Transfer->get();
                        $airportData = $request->airportData;
                        $TransferZones = [];
                        // foreach ($Transfer as $tkey => $T) {
                        $zone = 0;
                        if ($airportData['going_to_type'] == "location") {
                            $Locations = Locations::where(['id' => $airportData['going_to_id']])->first();
                            if ($Locations) {

                                $zone =     $Locations->zone;
                            }
                        } else {
                            $zone = $airportData['going_to_id'];
                        }
                        $adult = isset($airportData['adult']) ? $airportData['adult']  > 0 ? $airportData['adult'] : 0 : 0;
                        $child = isset($airportData['child']) ? $airportData['child'] > 0 ? $airportData['child'] : 0 : 0;

                        $total_qty     = $adult + $child;
                        $TransferZones = TransferZones::where(["airport_id" => $airportData['airport_id'], 'zone_id' => $zone])->where('zone_status', '!=', '1')->groupBy('transfer_id')->get();


                        foreach ($TransferZones as $key => $TZ) {
                            $TransferData[] = Transfer::where("id", $TZ['transfer_id'])->where(['is_delete' => 0, 'status' => 'Active'])->first();
                        }
                        // }
                    }


                    if (count($TransferData) > 0) {
                        $Transfer = [];
                        $Transfer = $TransferData;
                        // $Transfer = $Transfer->offset($limit)->limit($setLimit)->get();
                    }
                }
            } else {
                $Transfer = [];
                $ProductCount = 0;
            }
        }


        $output['page_count'] = ceil($ProductCount / $setLimit);
        $TransferArr = [];
        foreach ($Transfer as $T) {

            if ($T !== null) {

                if ($T['product_type'] == "bus") {
                    $TransferCarType              = TransferBusType::where(['transfer_id' => $T['id']])->first();
                } else {
                    $TransferCarType              = TransferCarType::where(['transfer_id' => $T['id']])->first();
                }


                $get_bus_transfer_language    = TransferLanguage::where(['transfer_id' => $T['id'], 'vehicle_type' => 'bus'])->get();
                $get_car_transfer_language    = TransferLanguage::where(['transfer_id' => $T['id'], 'vehicle_type' => 'car'])->get();
                $get_transfer                 = [];
                $get_transfer['id']           = $T['id'];
                $get_transfer['product_type'] = $T['product_type'];
                // $get_transfer['journey_time'] = $T['journey_time'] != '' ? $T['journey_time'] : '';
                $get_transfer['title']        =  $T['product_type'] == "bus" ?  getLanguageTranslate($get_bus_transfer_language, $language_id, $T['id'], 'title', 'transfer_id') : getLanguageTranslate($get_car_transfer_language, $language_id, $T['id'], 'title', 'transfer_id');
                // $get_transfer['description']  = getLanguageTranslate($get_bus_transfer_language, $language_id, $T['id'], 'description', 'transfer_id');

                $get_transfer['description'] = $T['product_type'] == "bus" ?  getLanguageTranslate($get_bus_transfer_language, $language_id, $T['id'], 'description', 'transfer_id') : getLanguageTranslate($get_car_transfer_language, $language_id, $T['id'], 'description', 'transfer_id');

                $get_transfer['short_description'] = $T['product_type'] == "bus" ?  getLanguageTranslate($get_bus_transfer_language, $language_id, $T['id'], 'short_description', 'transfer_id') : getLanguageTranslate($get_car_transfer_language, $language_id, $T['id'], 'short_description', 'transfer_id');


                // getLanguageTranslate($get_car_transfer_language, $language_id, $T['id'], 'short_description', 'transfer_id');
                if ($TransferCarType) {

                    $AirportTransferZones = TransferZones::where(['transfer_id' => $T['id'], 'airport_id' => $request->airportData['airport_id'], 'zone_status' => 0, 'vehicle_type' => $T['product_type']])->orderBy('price', "ASC")->first();


                    if ($AirportTransferZones) {
                        if ($T['product_type'] == "bus") {
                            $price =  ConvertCurrency($AirportTransferZones->adult_price);
                        } else {
                            $price =  ConvertCurrency($AirportTransferZones->price);
                        }
                        $adult_price = ConvertCurrency($AirportTransferZones->adult_price);
                        $child_price = ConvertCurrency($AirportTransferZones->child_price);

                        if (isset($request->airportData['return_date'])) {
                            $adult_price = ConvertCurrency($AirportTransferZones->adult_price) * 2;
                            $child_price = ConvertCurrency($AirportTransferZones->child_price) * 2;
                        }

                        $airport_parking_fee =  ConvertCurrency($AirportTransferZones->airport_parking_fee);
                        $Passengernumber = 1;

                        $passengers                        = $TransferCarType->passengers;
                        $get_transfer['car_type']          = $TransferCarType->car_type;
                        if ($T['product_type'] == "bus") {
                            $get_transfer['car_type_name']     = getAllInfo('bus_type_language', ['bus_type_id' => $TransferCarType->car_type, 'language_id' => $language_id], 'title');
                        } else {
                            $get_transfer['car_type_name']     = getAllInfo('car_type_language', ['car_type_id' => $TransferCarType->car_type, 'language_id' => $language_id], 'title');
                        }


                        $get_transfer['car_image']         = asset('public/uploads/Transfer_images/' . $TransferCarType->car_image);
                        $get_transfer['country']           = getAllInfo('countries', ['id' => $TransferCarType->country], 'name');
                        $get_transfer['state']             = getAllInfo('states', ['id' => $TransferCarType->state], 'name');
                        $get_transfer['passengers']        = $TransferCarType->passengers;
                        $get_transfer['luggage_allowed']   = $TransferCarType->luggage_allowed;
                        $get_transfer['free_cancelation']  = $TransferCarType->free_cancelation;
                        $get_transfer['upgrade_icon']      = $TransferCarType->upgrade_icon;
                        $get_transfer['free_upgrade']      = $TransferCarType->free_upgrade;
                        $get_transfer['adult_price']       = $adult_price;
                        $get_transfer['child_price']       = $child_price;
                        $get_transfer['cancelation_icon']  = $TransferCarType->cancelation_icon;
                        $Passengernumber                   = $total_qty > 0 && $passengers > 0 ? ceil($total_qty / $passengers) : 1;
                        $get_transfer['number_of_vehicle'] = $Passengernumber == 0 ? 1 : $Passengernumber;
                        $get_transfer['airport']           = getAllInfo('airport_detail', ['id' => $TransferCarType->airport_id], 'name');
                        $get_transfer['zone']              = getAllInfo('zones', ['id' => $TransferCarType->zone_id], 'zone_title');




                        if (isset($request->airportData)) { {
                                if ($request->airportData != "") {
                                    $airportData = $request->airportData;
                                    $zone = 0;
                                    if ($airportData['going_to_type'] == "location") {
                                        $Locations = Locations::where(['id' => $airportData['going_to_id']])->first();
                                        if ($Locations) {
                                            $zone =     $Locations->zone;
                                        }

                                        $get_transfer['distance'] = '';
                                        $get_transfer['journey_time'] = '';
                                        $get_distace_timing = LocationDistanceTiming::where(['airport_id' => $airportData['airport_id'], 'location_id' => $airportData['going_to_id']])->first();
                                        if ($get_distace_timing) {
                                            $get_transfer['distance'] = $get_distace_timing['distance'];
                                            $get_transfer['journey_time'] = $get_distace_timing['duration'];
                                        }
                                    } else {
                                        $zone = $airportData['going_to_id'];
                                    }
                                    $TransferZones = TransferZones::where(["airport_id" => $airportData['airport_id'], 'zone_id' => $zone, 'transfer_id' => $T['id'], 'vehicle_type' => $T['product_type']])->first();
                                    if ($TransferZones) {
                                        if ($T['product_type'] == "bus") {


                                            $price     = ConvertCurrency($TransferZones->adult_price) * $request->airportData['adult'];
                                            // return $price;
                                            $price     = $price + ConvertCurrency($TransferZones->child_price) * $request->airportData['child'];
                                        } else {
                                            $price =  ConvertCurrency($TransferZones->price);
                                        }


                                        $airport_parking_fee  = ConvertCurrency($TransferZones->airport_parking_fee);
                                    }
                                }


                                if (isset($airportData['return_date'])) {
                                    if ($airportData['return_date'] != "") {

                                        $price = $price * 2;
                                        $airport_parking_fee = $airport_parking_fee * 2;
                                    }
                                }
                            }
                        }


                        $Passengernumber                     = $Passengernumber   == 0 ? 1 : $Passengernumber;
                        $get_transfer['price']               = (float)$price;
                        $get_transfer['airport_parking_fee'] = $airport_parking_fee;
                        $get_transfer['no_hidden_cost']      = $TransferCarType->no_hidden_cost;
                        $get_transfer['product_bookable']    = $TransferCarType->product_bookable;
                        $get_transfer['tax_allowed']         = $T['tax_allowed'];
                        $get_transfer['transfer_pdf']        = $T['transfer_pdf'] != "" ? asset('uploads/Transfer_PDF/' . $T['transfer_pdf']) : '';
                        $get_transfer['service_allowed']     = $T['service_allowed'];
                        $get_transfer['extra_top_text']      = $T['extra_top_text'];
                        $get_transfer['tax_percentage']      = $T['tax_percentage'] > 0 ? $T['tax_percentage'] : 0;
                        $get_transfer['service_amount']      = $T['service_amount'] > 0 ? ConvertCurrency($T['service_amount']) : 0;
                        $get_transfer['meet_greet']          = $TransferCarType->meet_greet;

                        $TransferExtrasOptions = TransferExtrasOptions::where('transfer_id', $T['id'])->get();
                        foreach ($TransferExtrasOptions as $key => $TEO) {
                            $TransferExtrasOptionsLanguage                 = TransferExtrasOptionsLanguage::where('extra_option_id', $TEO['id'])->get();
                            $get_transfer_extra_option_arr                 = [];
                            $get_transfer_extra_option_arr['id']           = $TEO['id'];
                            $get_transfer_extra_option_arr['price']        = ConvertCurrency($TEO['extra_price']);
                            $get_transfer_extra_option_arr['type']         = '0';
                            $get_transfer_extra_option_arr['is_check']     = 0;
                            $get_transfer_extra_option_arr['is_outward']   = 1;
                            $get_transfer_extra_option_arr['is_return']    = 0;
                            $get_transfer_extra_option_arr['departure']    = 0;
                            $get_transfer_extra_option_arr['arrival']      = 0;
                            $get_transfer_extra_option_arr['is_departure'] = $TEO['departure'];
                            $get_transfer_extra_option_arr['is_arrival']   = $TEO['arrival'];
                            $get_transfer_extra_option_arr['title']        = $title =  getLanguageTranslate($TransferExtrasOptionsLanguage, $language_id, $TEO['id'], 'option_title', 'extra_option_id');
                            $get_transfer_extra_option_arr['description']  = getLanguageTranslate($TransferExtrasOptionsLanguage, $language_id, $TEO['id'], 'option_description', 'extra_option_id');
                            // if ($TEO['extra_price'] > 0) {
                            if ($TEO['departure'] > 0 || $TEO['arrival'] > 0 && $title != "") {
                                $get_transfer['extra_option'][]                = $get_transfer_extra_option_arr;
                            }
                            // }
                        }

                        $TransferExtras = TransferExtras::where('transfer_id', $T['id'])->get();

                        foreach ($TransferExtras as $key => $TE) {
                            $TransferExtrasLanguage = TransferExtrasLanguage::where('extras_id', $TE['id'])->get();
                            $get_transfer_extra_arr = [];
                            $get_transfer_extra_arr['id'] = $TE['id'];
                            $get_transfer_extra_arr['adult_price'] = $adult_price =  ConvertCurrency($TE['adult_price']);
                            $get_transfer_extra_arr['child_price'] = $child_price =  $TE['child_allowed'] == 1 ? ConvertCurrency($TE['child_price']) : 'N/A';
                            $get_transfer_extra_arr['child_allowed'] = $TE['child_allowed'];
                            $get_transfer_extra_arr['adult_qty'] = 0;
                            $get_transfer_extra_arr['child_qty'] = 0;
                            $get_transfer_extra_arr['total'] = 0;
                            $get_transfer_extra_arr['is_outward']  = 0;
                            $get_transfer_extra_arr['is_return']   = 0;
                            $get_transfer_extra_arr['title'] = $title = getLanguageTranslate($TransferExtrasLanguage, $language_id, $TE['id'], 'extra_title', 'extras_id');
                            $get_transfer_extra_arr['description'] = getLanguageTranslate($TransferExtrasLanguage, $language_id, $TE['id'], 'extra_information', 'extras_id');
                            if ($title != "") {
                                $get_transfer['extra_needs'][] = $get_transfer_extra_arr;
                            }
                        }

                        // // Product Tool Tip
                        $get_tool_tip = [];
                        $get_product_tool_tip = ProductToolTipLanguage::where('product_id', $T['id'])
                            ->where('type', "transfer")
                            ->where('language_id', $language_id)
                            ->get();
                        foreach ($get_product_tool_tip as $tool_tip_key => $tool_tip_value) {
                            $get_tool_tip[$tool_tip_value['tooltip_title']] = $tool_tip_value['tooltip_description'];
                        }
                        $get_transfer['product_tool_tip'] = $get_tool_tip;
                        $TransferArr[] = $get_transfer;
                    }
                }
            }
        }

        // $collection->sortBy("product.price")->toArray()
        // $TransferArr = collect($TransferArr)->sortBy('price')->toArray();
        $output['data'] = $TransferArr;
        $output['status'] = true;
        $output['message'] = 'Data Fetched Successfully...';

        return json_encode($output);
    }


    // Transfer Extra Option Total
    public function transfer_extra_option_total(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            'product_id' => 'required',
            'option_id'  => 'required',
            'details'    => 'required',
            'language'   => 'required',
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
        $product_id             = $request->product_id;
        $extraOptionID          = $request->option_id;
        $details                = $request->details;
        $number_vehicle         = $request->number_vehicle;
        $totalAmount            = 0;
        $Amount                 = 0;
        $transferExtraOptionArr = [];
        $Product                = TransferCarType::where('transfer_id', $product_id)
            ->first();
        if ($Product) {
            $TransferExtrasOptionsForAmount =  TransferExtrasOptions::where(["id" => $extraOptionID])->first();
            if ($TransferExtrasOptionsForAmount) {
                if ($details[$extraOptionID]['departure'] == 1) {
                    if ($TransferExtrasOptionsForAmount != "") {

                        if ($details[$extraOptionID]['arrival'] == 1) {
                            $Amount = ConvertCurrency($TransferExtrasOptionsForAmount->extra_price) * 2;
                        } else {
                            $Amount = ConvertCurrency($TransferExtrasOptionsForAmount->extra_price);
                        }
                    }
                } else {
                    // if ($details[$extraOptionID]['arrival'] == 1) {
                    if ($TransferExtrasOptionsForAmount != "") {
                        $Amount = ConvertCurrency($TransferExtrasOptionsForAmount->extra_price);
                    }
                    // }    
                }
            }

            $AirportTransferZones = TransferZones::where(['transfer_id' => $product_id])->orderBy('price', "ASC")->first();
            if ($AirportTransferZones) {
                $price =  ConvertCurrency($AirportTransferZones->price);
                $airport_parking_fee =  ConvertCurrency($AirportTransferZones->airport_parking_fee);
            }

            if (isset($request->airportData)) {
                if ($request->airportData != "") {
                    $airportData = $request->airportData;
                    $zone = 0;
                    if ($airportData['going_to_type'] == "location") {
                        $Locations = Locations::where(['id' => $airportData['going_to_id']])->first();
                        if ($Locations) {
                            $zone =     $Locations->zone;
                        }
                    } else {
                        $zone = $airportData['going_to_id'];
                    }
                    $TransferZones = TransferZones::where(["airport_id" => $airportData['airport_id'], 'zone_id' => $zone, 'transfer_id' => $product_id])->first();
                    if ($TransferZones) {
                        $price                = ConvertCurrency($TransferZones->price);
                        $airport_parking_fee  = ConvertCurrency($TransferZones->airport_parking_fee);
                    }
                }
                if (isset($airportData['return_date'])) {
                    if ($airportData['return_date'] != "") {
                        $price = $price * 2;
                        $airport_parking_fee = $airport_parking_fee * 2;
                    }
                }
            } else {
                $price = $price;
                $airport_parking_fee = $airport_parking_fee;
            }

            $totalAmount = $price * $number_vehicle[$product_id] +  $airport_parking_fee * $number_vehicle[$product_id];
            foreach ($details as $key => $value) {
                $TransferExtrasOptions =  TransferExtrasOptions::where(["id" => $value['id']])->first();
                if ($TransferExtrasOptions) {
                    if ($value['is_check'] == '1') {
                        if ($value['departure'] == 1) {
                            if ($value['arrival'] == 1) {
                                $totalAmount = $totalAmount + ConvertCurrency($TransferExtrasOptions->extra_price) * 2;
                            } else {
                                $totalAmount = $totalAmount + ConvertCurrency($TransferExtrasOptions->extra_price);
                            }
                        } else {
                            if ($value['arrival'] == 1) {
                                $totalAmount = $totalAmount +  ConvertCurrency($TransferExtrasOptions->extra_price);
                            }
                        }
                    }
                    // echo $totalAmount;
                }
            }
        }
        // return $Amount;
        $transferExtraOptionArr['number_vehicle'] = $number_vehicle[$product_id];
        $transferExtraOptionArr['airport_parking_fee'] = $airport_parking_fee;
        $transferExtraOptionArr['price'] = $price;
        $transferExtraOptionArr['extra_total_option_amount'] = $totalAmount;
        $transferExtraOptionArr['extra_option_amount']       = $Amount;
        $output['data']                                      = $transferExtraOptionArr;
        $output['status']                                    = true;
        $output['msg']                                       = 'Data Fetched Successfully...';
        return json_encode($output);
    }

    // Transfer Extra Need Total

    public function transfer_extra_need_total(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            'product_id' => 'required',
            'need_id'    => 'required',
            'details'    => 'required',
            'language'   => 'required',
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
        $product_id  = $request->product_id;
        $extraNeedID = $request->need_id;
        $details     = $request->details;
        $ExtraNeedArr = [];
        $total  = 0;
        foreach ($details as $key => $value) {
            if ($extraNeedID ==  $value['id']) {
                if ($value['adult_qty'] > 0 || $value['child_qty'] > 0) {
                    $TransferExtras = TransferExtras::where("id", $value['id'])->first();





                    $adultPrice = ConvertCurrency($TransferExtras->adult_price) * $value['adult_qty'];
                    $childPrice = ConvertCurrency($TransferExtras->child_price) * $value['child_qty'];
                    if ($value['is_return'] == 1 || $value['is_outward'] == 1) {
                        $total = $adultPrice + $childPrice;
                    } else {
                        $total = 0;
                    }

                    if ($value['is_return'] == 1) {
                        if ($value['is_outward'] == 1) {
                            $total = $total * 2;
                        }
                    }
                }
            }
        }
        //    if($details)
        $output['data']                                      = number_format($total,2);
        $output['status']                                    = true;
        $output['msg']                                       = 'Data Fetched Successfully...';
        return json_encode($output);
    }


    public function transfer_total_amount(Request $request)
    {

        $output = [];
        $output['status'] = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            'product_id' => 'required',
            'language'   => 'required',
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


        $product_id             = $request->product_id;
        $extraOptionID          = $request->option_id;
        $extra_option           = $request->extra_option;
        $extra_needs            = $request->extra_needs;
        $number_vehicle         = $request->number_vehicle[$product_id];
        $totalAmount            = 0;
        $Amount                 = 0;
        $transferExtraOptionArr = [];
        $totalQty               = 0;
        $transferData           = Transfer::find($product_id);
        $Product                = TransferCarType::where('transfer_id', $product_id)
            ->first();
        $Passengernumber = 1;
        if ($Product) {


            $AirportTransferZones = TransferZones::where(['transfer_id' => $product_id, 'vehicle_type' => $transferData->product_type])->orderBy('price', "ASC")->first();
            if ($AirportTransferZones) {
                if ($transferData->product_type == "bus") {
                    $price =  ConvertCurrency($AirportTransferZones->adult_price);
                } else {
                    $price =  ConvertCurrency($AirportTransferZones->price);
                }

                $airport_parking_fee =  ConvertCurrency($AirportTransferZones->airport_parking_fee);
            }

            if (isset($request->airportData)) {
                if ($request->airportData != "") {
                    $airportData = $request->airportData;
                    $adult = isset($airportData['adult']) ? $airportData['adult'] : 0;
                    $child = isset($airportData['child']) ? $airportData['child'] : 0;
                    $totalQty = $adult + $child;
                    $zone = 0;
                    if ($airportData['going_to_type'] == "location") {
                        $Locations = Locations::where(['id' => $airportData['going_to_id']])->first();
                        if ($Locations) {
                            $zone =     $Locations->zone;
                        }
                    } else {
                        $zone = $airportData['going_to_id'];
                    }
                    $TransferZones = TransferZones::where(["airport_id" => $airportData['airport_id'], 'zone_id' => $zone, 'transfer_id' => $product_id, 'vehicle_type' => $transferData->product_type])->first();
                    if ($TransferZones) {
                        if ($transferData->product_type == "bus") {
                            $price =  ConvertCurrency($TransferZones->adult_price) + ConvertCurrency($TransferZones->child_price);
                            $adult_price =  ConvertCurrency($TransferZones->adult_price);
                            $child_price =  ConvertCurrency($TransferZones->child_price);
                        } else {
                            $price =  ConvertCurrency($TransferZones->price);
                        }

                        $airport_parking_fee  = ConvertCurrency($TransferZones->airport_parking_fee);
                    }
                }
                if (isset($airportData['return_date'])) {
                    if ($airportData['return_date'] != "") {

                        $price = $price * 2;
                        $adult_price =  ConvertCurrency($TransferZones->adult_price) * 2;
                        $child_price =  ConvertCurrency($TransferZones->child_price) * 2;

                        if ($transferData->product_type != "bus") {
                            $airport_parking_fee = $airport_parking_fee * 2;
                        }
                    }
                }
            } else {
                $price               = $price;
                $airport_parking_fee = $airport_parking_fee;
            }

            $passengers      = $Product->passengers;
            if ($number_vehicle == 0) {
                $Passengernumber = $totalQty > 0 && $passengers > 0 ? ceil($totalQty / $passengers) : 1;
                $number_vehicle  = $Passengernumber == 0 ? 1 : $Passengernumber;
            }
            if ($transferData->product_type == "bus") {
                if (isset($request->airportData)) {

                    $totalAmount     = ($adult_price * $request->airportData['adult']) +  $airport_parking_fee;

                    $totalAmount     = $totalAmount + $child_price * $request->airportData['child'];
                }
            } else {
                $totalAmount     = $price * $number_vehicle +  $airport_parking_fee * $number_vehicle;
            }
        }


        if ($extra_option != null) {
            foreach ($extra_option as $key => $value) {
                if (isset($value['is_check'])) {
                    if ($value['is_check'] == 1) {
                        $TransferExtrasOptions =  TransferExtrasOptions::where(["id" => $value['id']])->first();
                        if ($TransferExtrasOptions) {
                            if ($value['departure'] == 1) {

                                if ($value['arrival'] == 1) {
                                    $totalAmount = $totalAmount + ConvertCurrency($TransferExtrasOptions->extra_price) * 2;
                                } else {
                                    $totalAmount = $totalAmount + ConvertCurrency($TransferExtrasOptions->extra_price);
                                }
                            } else {
                                if ($value['arrival'] == 1) {
                                    $totalAmount = $totalAmount +  ConvertCurrency($TransferExtrasOptions->extra_price);
                                }
                            }
                        }
                    }
                }
            }
        }
        if ($extra_needs != null) {
            foreach ($extra_needs as $key => $value) {
                if ($value['adult_qty'] > 0 || $value['child_qty'] > 0) {
                    $TransferExtras = TransferExtras::where("id", $value['id'])->first();
                    $adultPrice = ConvertCurrency($TransferExtras->adult_price) * $value['adult_qty'];
                    $childPrice = ConvertCurrency($TransferExtras->child_price) * $value['child_qty'];
                    $TransferExtrasTotal = $adultPrice + $childPrice;

                    if ($value['is_return'] == 1 || $value['is_outward'] == 1) {
                        $TransferExtrasTotal = $adultPrice + $childPrice;
                    } else {
                        $TransferExtrasTotal = 0;
                    }

                    if ($value['is_return'] == 1) {
                        if ($value['is_outward'] == 1) {
                            $TransferExtrasTotal =  $TransferExtrasTotal * 2;
                        }
                    }
                    $totalAmount = $totalAmount + $TransferExtrasTotal;
                }
            }
        }



        $output['data']              = $totalAmount;
        $output['number_of_vehicle'] = $number_vehicle;
        $output['status']            = true;
        $output['msg']               = 'Data Fetched Successfully...';
        return json_encode($output);
    }





    // Airport Tranfer Add Request 
    public function add_airport_request(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $validator = Validator::make($request->all(), [
            'language'          => 'required',
            'first_name'        => 'required',
            'last_name'         => 'required',
            'phone_number'      => 'required',
            'email'             => 'required',
            'arrival_airport'   => 'required',
            'transfer_to'       => 'required',
            // 'arrival_date'      => 'required',
            // 'departure_date'    => 'required',
            // 'departure_airport' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->errors()->first(),
                ],
                402,
            );
        }

        $AirportTranferRequest                    = new AirportTranferRequest();
        $AirportTranferRequest->first_name        = $request->first_name;
        $AirportTranferRequest->last_name         = $request->last_name;
        $AirportTranferRequest->phone_number      = $request->phone_number;
        $AirportTranferRequest->email             = $request->email;
        $AirportTranferRequest->arrival_airport   = $request->arrival_airport;
        $AirportTranferRequest->transfer_to       = $request->transfer_to;
        $AirportTranferRequest->adult             = $request->adult;
        $AirportTranferRequest->child             = $request->child;
        $AirportTranferRequest->infant            = $request->infant;
        $AirportTranferRequest->departure_date    = $request->departure_date;
        $AirportTranferRequest->departure_airport = $request->departure_airport;
        $AirportTranferRequest->remarks           = $request->notes;
        $AirportTranferRequest->save();
        $output['status']   = true;
        $output['message']  = 'Submit Successfully';
        return json_encode($output);
    }

    public function add_airport_checkout_detail(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $validator = Validator::make($request->all(), [
            'language'            => 'required',
            'product_id'          => 'required',
            'airport_id'          => 'required',
            'going_to_id'         => 'required',
            'first_name'          => 'required',
            'last_name'           => 'required',
            'title'               => 'required',
            'phone_number'        => 'required',
            'email'               => 'required',
            // 'address'             => 'required',
            // 'airline_name'        => 'required',
            'flight_number'       => 'required',
            // 'originating_id'      => 'required',
            // 'originating_airport' => 'required',
            'flight_arrival_time' => 'required',
            'drop_off_point'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->errors()->first(),
                ],
                402,
            );
        }
        $language                      = $request->language;
        $user_id                       = $request->user_id;
        $product_id                    = $request->product_id;
        $airport_id                    = $request->airport_id;
        $going_to_id                   = $request->going_to_id;
        $adult                         = $request->adult;
        $child                         = $request->child;
        $infant                        = $request->infant;
        $return_transfer_check         = $request->return_transfer_check;
        $return_diffrent_address_check = $request->return_diffrent_address;
        $going_to_id                   = $request->going_to_id;
        $number_of_vehical             = $request->number_of_vehical;
        $going_to_type                 = $request->going_to_type;
        $extra_options               = [];
        if (isset($request->extraOptions)) {
            $extra_options           =  $request->extraOptions;
        }
        $extra_needs                 = [];
        if (isset($request->extraNeeds)) {
            $extra_needs             = $request->extraNeeds;
        }

        $extra_arr                    = [];

        $Transfer   = Transfer::where('id', $product_id)->where('is_delete', '!=', 1)->where('status', 'Active')->first();
        if ($Transfer) {

            $zone_id                        = $going_to_id;
            $extra_arr['country']           = '';
            $extra_arr['departure_country'] = '';
            if ($request->country) {
                $extra_arr['country'] = get_table_data('countries', 'name', $request->country);
            }
            if ($request->departure_country) {
                $extra_arr['departure_country'] = get_table_data('countries', 'name', $request->departure_country);
            }
            if ($going_to_type == 'location') {
                $Locations      = Locations::where(['id' => $going_to_id])->first();
                $zone_id        = $Locations->zone;
            }
            $get_bus_transfer_language      = TransferLanguage::where(['transfer_id' => $product_id, 'vehicle_type' => 'bus'])->get();
            $get_car_transfer_language      = TransferLanguage::where(['transfer_id' => $product_id, 'vehicle_type' => 'car'])->get();
            $get_transfer_language          = TransferLanguage::where(['transfer_id' => $product_id])->where('language_id', $language)->first();
            $extra_arr['title']             = "";
            $extra_arr['short_description'] = "";
            if ($get_transfer_language) {
                $extra_arr['title']             = $Transfer->product_type == "bus" ?  getLanguageTranslate($get_bus_transfer_language, $language, $product_id, 'title', 'transfer_id') : getLanguageTranslate($get_car_transfer_language, $language, $product_id, 'title', 'transfer_id');
                $extra_arr['short_description']             = $Transfer->product_type == "bus" ?  getLanguageTranslate($get_bus_transfer_language, $language, $product_id, 'short_description', 'transfer_id') : getLanguageTranslate($get_car_transfer_language, $language, $product_id, 'short_description', 'transfer_id');
                $extra_arr['description']             = $Transfer->product_type == "bus" ?  getLanguageTranslate($get_bus_transfer_language, $language, $product_id, 'description', 'transfer_id') : getLanguageTranslate($get_car_transfer_language, $language, $product_id, 'description', 'transfer_id');
            }
            $product_id                         = $Transfer->id;
            $extra_arr['product_id']            = $product_id;
            if ($Transfer->product_type == "bus") {
                $TransferCarType              = TransferBusType::where(['transfer_id' => $product_id])->first();
            } else {
                $TransferCarType              = TransferCarType::where(['transfer_id' => $product_id])->first();
            }

            $extra_arr['passengers']            = $TransferCarType->passengers != '' ? $TransferCarType->passengers  : 0;
            $extra_arr['car_image']             = asset('public/uploads/Transfer_images/' . $TransferCarType->car_image);
            $extra_arr['luggage_allowed']       = $TransferCarType->luggage_allowed;
            $extra_arr['meet_greet']            = $TransferCarType->meet_greet;
            $extra_arr['product_bookable']      = $TransferCarType->product_bookable;
            $extra_arr['journey_time']          = $TransferCarType->journey_time;
            $extra_arr['distance']              = '';
            $extra_arr['product_type']          = $Transfer->product_type;
            $extra_arr['number_of_vehical']     = $number_of_vehical;
            $extra_arr['adult']                 = $adult;
            $extra_arr['child']                 = $child;
            $extra_arr['infant']                = $infant;
            $extra_arr['return_transfer_check'] = $return_transfer_check;

            // V 07-17-2023 4-21 
            $zone_id  = $going_to_id;
            if ($going_to_type == 'location') {
                $Locations      = Locations::where(['id' => $going_to_id])->first();
                if($Locations){
                    $zone_id        = $Locations->zone;
                }
                $get_distace_timing = LocationDistanceTiming::where(['airport_id' => $airport_id, 'location_id' => $going_to_id])->first();
                if ($get_distace_timing) {
                    $extra_arr['distance']     = $get_distace_timing['distance'];
                    $extra_arr['journey_time'] = $get_distace_timing['duration'];
                }
            }
            //V 07-17-2023 4-21 


            //TransferZones Type
            $zone_total_amnt             = 0;
            $airport_parking_fee         = 0;
            $transfer_parking_total      = 0;
            $extra_arr['transfer_zones'] = [];
            $TransferZones               = TransferZones::where('transfer_id', $Transfer->id)->where('airport_id', $airport_id)->where('zone_id', $zone_id)->where('vehicle_type', $Transfer->product_type)->first();
            if ($TransferZones) {
                $adult_price = 0;
                $child_price = 0;
                if ($Transfer->product_type == "bus") {
                    $adult_price = ConvertCurrency($TransferZones['adult_price']);
                    $child_price =   ConvertCurrency($TransferZones['child_price']);
                    $price = $adult_price * $adult + $child_price * $child;
                } else {
                    $price =   ConvertCurrency($TransferZones['price']);
                }



                $extra_arr['transfer_zones']['airport_id']          = $TransferZones['airport_id'];
                $extra_arr['transfer_zones']['zone_id']             = $TransferZones['zone_id'];
                $extra_arr['transfer_zones']['price']               = $price                                != '' ? $price : '';
                $extra_arr['transfer_zones']['adult_price']         = $adult_price                          != '' ? $adult_price : '';
                $extra_arr['transfer_zones']['child_price']               = $child_price                          != '' ? $child_price : '';
                $extra_arr['transfer_zones']['airport_parking_fee'] = $TransferZones['airport_parking_fee'] != '' ? ConvertCurrency($TransferZones['airport_parking_fee']) : 0;
                $extra_arr['transfer_zones']['going_to_type']       = $going_to_type;


                if ($return_transfer_check == 'true') {

                    if ($Transfer->product_type == "bus") {
                        $airport_parking_feeDAta =  ConvertCurrency($TransferZones['airport_parking_fee']);
                    } else {
                        $airport_parking_feeDAta =  ConvertCurrency($TransferZones['airport_parking_fee']) * 2;
                    }

                    $zone_total_amnt     += $extra_arr['transfer_zones']['total_price']           = $price * 2;
                    $airport_parking_fee += $extra_arr['transfer_zones']['total_parking_fee']     = $airport_parking_feeDAta;
                } else {
                    $zone_total_amnt     += $extra_arr['transfer_zones']['total_price']           = $price;
                    $airport_parking_fee += $extra_arr['transfer_zones']['total_parking_fee']     = ConvertCurrency($TransferZones['airport_parking_fee']);
                }
                if ($Transfer->product_type == "bus") {
                    $extra_arr['transfer_zones']['transfer_total'] = $zone_total_amnt;
                    $extra_arr['transfer_zones']['parking_total']  = $airport_parking_fee;
                    $zone_total_amnt     = $zone_total_amnt;
                    $airport_parking_fee = $airport_parking_fee;
                } else {
                    $extra_arr['transfer_zones']['transfer_total'] = $zone_total_amnt * $number_of_vehical;
                    $extra_arr['transfer_zones']['parking_total']  = $airport_parking_fee * $number_of_vehical;
                    $zone_total_amnt     = $zone_total_amnt * $number_of_vehical;
                    $airport_parking_fee = $airport_parking_fee * $number_of_vehical;
                }
            }




            //TransferExtrasOptions Start
            $extra_options_total = 0;
            $extra_arr['transfer_option'] = [];
            if (count($extra_options) > 0) {
                $extra_arr['transfer_option']['options'] = [];
                $extra_arr['transfer_option']['total']   = 0;
                foreach ($extra_options as $extra_option_key => $extra_option_value) {
                    # code...
                    $extra_option_arr      = array();
                    $TransferExtrasOptions = TransferExtrasOptions::where('transfer_id', $product_id)->where('id', $extra_option_value['id'])->first();
                    if ($TransferExtrasOptions) {
                        if ($extra_option_value['is_check'] == 1) {
                            $TransferExtrasOptionsLanguage   = TransferExtrasOptionsLanguage::where('extra_option_id', $TransferExtrasOptions['id'])->where('language_id', $language)->first();
                            $extra_option_arr['id']          = $TransferExtrasOptions['id'];
                            $extra_option_arr['title']       = $TransferExtrasOptionsLanguage['option_title']       != '' ? $TransferExtrasOptionsLanguage['option_title'] : '';
                            $extra_option_arr['description'] = $TransferExtrasOptionsLanguage['option_description'] != '' ? $TransferExtrasOptionsLanguage['option_description'] : '';
                            $extra_option_arr['price']       = ConvertCurrency($TransferExtrasOptions['extra_price']);

                            $extra_option_arr['user_departure'] = $extra_option_value['departure'];
                            $extra_option_arr['user_arrival']   = $extra_option_value['arrival'];
                            $extra_option_arr['total_price']    = 0;

                            if ($extra_option_value['departure'] == 1 && $extra_option_value['arrival'] == 1) {
                                $extra_options_total += $extra_option_arr['total_price'] = ConvertCurrency($TransferExtrasOptions['extra_price']) * 2;
                            } else {
                                $extra_options_total += $extra_option_arr['total_price'] = ConvertCurrency($TransferExtrasOptions['extra_price']);
                            }
                            $extra_arr['transfer_option']['options'][] = $extra_option_arr;
                        }
                    }
                }
                $extra_arr['transfer_option']['total'] = $extra_options_total;
            }
            //TransferExtrasOptions End


            //Extra needs Start
            $extra_need_total = 0;
            $extra_arr['transfer_needs']  = [];
            if (count($extra_needs) > 0) {
                $extra_arr['transfer_needs']['option'] = [];
                $extra_arr['transfer_needs']['total'] = 0;
                foreach ($extra_needs as $extra_need_key => $extra_need_value) {
                    # code...
                    $total                                = 0;
                    if ($extra_need_value['adult_qty'] > 0 || $extra_need_value['child_qty'] > 0) {
                        $extra_needs_arr = [];
                        $TransferExtras = TransferExtras::where('transfer_id', $product_id)->where('id', $extra_need_value['id'])->first();
                        if ($TransferExtras) {
                            $TransferExtrasLanguage               = TransferExtrasLanguage::where('extras_id', $extra_need_value['id'])->where('language_id', $language)->first();
                            $extra_needs_arr['id']                    = $TransferExtras['id'];
                            $extra_needs_arr['title']                 = $TransferExtrasLanguage['extra_title'] != "" ? $TransferExtrasLanguage['extra_title'] : '';
                            $extra_needs_arr['extra_information']     = $TransferExtrasLanguage['extra_information'] != '' ? $TransferExtrasLanguage['extra_information'] : '';
                            $extra_needs_arr['adult_price']           = $TransferExtras['adult_price'];
                            $extra_needs_arr['child_price']           = $TransferExtras['child_price'];
                            $extra_needs_arr['child_allowed']         = $TransferExtras['child_allowed'];
                            $extra_needs_arr['is_return']             = $extra_need_value['is_return'];
                            $extra_needs_arr['is_outward']            = $extra_need_value['is_outward'];
                            $extra_needs_arr['adult_qty']             = $extra_need_value['adult_qty'];
                            $extra_needs_arr['child_qty']             = $extra_need_value['child_qty'];
                            if ($extra_need_value['is_return'] == 1 && $extra_need_value['is_outward'] == 1) {
                                $total                                   += $extra_needs_arr['child_total_price'] = $extra_need_value['child_qty'] * ConvertCurrency($TransferExtras['child_price']) * 2;
                                $total                                   += $extra_needs_arr['adult_total_price'] = $extra_need_value['adult_qty'] * ConvertCurrency($TransferExtras['adult_price']) * 2;
                            } else {
                                $total                                    += $extra_needs_arr['child_total_price'] = $extra_need_value['child_qty'] * ConvertCurrency($TransferExtras['child_price']);
                                $total                                   += $extra_needs_arr['adult_total_price'] = $extra_need_value['adult_qty'] * ConvertCurrency($TransferExtras['adult_price']);
                            }

                            $extra_need_total += $extra_needs_arr['total']                 = $total;
                            $extra_arr['transfer_needs']['option'][]  = $extra_needs_arr;
                        }
                    }
                }
                $extra_arr['transfer_needs']['total'] =   number_format($extra_need_total,2);
            }
            //Extra needs end
            $sub_total                    = $zone_total_amnt + $extra_need_total + $extra_options_total;
            $service_amount               = 0;
            $tax_amount                   = 0;

            $extra_arr['service_allowed'] = (int) $Transfer['service_allowed'];
            $extra_arr['tax_allowed']     = (int) $Transfer['tax_allowed'];

            if ($Transfer['service_allowed'] == 1) {
                $service_amount               = ConvertCurrency($Transfer['service_amount']);
            }
            if ($Transfer['tax_allowed'] == 1) {
                $extra_arr['tax_percentage']  = $Transfer['tax_percentage'];
                if ($Transfer['tax_percentage'] != 0 && $Transfer['tax_percentage'] != null  && $sub_total != 0) {
                    $tax_amount              = ($sub_total * $Transfer['tax_percentage']) / 100;
                }
            }
            $extra_arr['tax_amount']      = number_format($tax_amount, 2);
            $extra_arr['service_amount']  = number_format($service_amount, 2);
            $extra_arr['tax_service']     = $tax_amount + $service_amount;
            $extra_arr['sub_total']       = $sub_total + $airport_parking_fee + $tax_amount + $service_amount;


            // $AirportTransferCheckOut->extras        = json_encode($extra_arr);
            // $AirportTransferCheckOut->total_amount  = $sub_total;
            // $AirportTransferCheckOut->save();

            $output['data']     = $extra_arr;
            $output['status']   = true;
            $output['message']  = 'Submit Successfully';
        } else {
            $output['status']   = false;
            $output['message']  = 'Something Went Wrong...';
        }
        return json_encode($output);
    }

    //////
    // Airport Tranfer Add checkOut 
    public function add_airport_checkout(Request $request)
    {

        // return $request->all();
        $output = [];
        $output['status'] = false;
        $validator = Validator::make($request->all(), [
            'language'            => 'required',
            'product_id'          => 'required',
            'airport_id'          => 'required',
            'going_to_id'         => 'required',
            'first_name'          => 'required',
            'last_name'           => 'required',
            'title'               => 'required',
            'phone_number'        => 'required',
            'email'               => 'required',
            // 'address'             => 'required',
            // 'airline_name'        => 'required',
            'flight_number'       => 'required',
            // 'originating_id'      => 'required',
            // 'originating_airport' => 'required',
            'flight_arrival_time' => 'required',
            'drop_off_point'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->errors()->first(),
                ],
                402,
            );
        }

        $language                      = $request->language;
        $user_id                       = $request->user_id;
        $product_id                    = $request->product_id;
        $airport_id                    = $request->airport_id;
        $going_to_id                   = $request->going_to_id;
        $adult                         = $request->adult;
        $child                         = $request->child;
        $infant                        = $request->infant;
        $return_transfer_check         = $request->return_transfer_check;
        $return_diffrent_address_check = $request->return_diffrent_address;
        $going_to_id                   = $request->going_to_id;
        $number_of_vehical             = $request->number_of_vehical;
        $going_to_type                 = $request->going_to_type;
        $extra_options               = [];
        if (isset($request->extraOptions)) {
            $extra_options           =  $request->extraOptions;
        }
        $extra_needs                 = [];
        if (isset($request->extraNeeds)) {
            $extra_needs             = $request->extraNeeds;
        }
        


        $extra_arr                    = [];

        $AffilliateCommissionArr = [];
        $AffilliateCommission    = new AffilliateCommission();
        $AffilliateCode          = isset($request->affilliate_code) ? $request->affilliate_code  : "";
        $Transfer                = Transfer::where('id', $product_id)->where('is_delete', '!=', 1)->where('status', 'Active')->first();
        if ($Transfer) {

            $product_id                                             = $Transfer->id;
            $AirportTransferCheckOut                                = new AirportTransferCheckOut();
            $get_transfer_language                                  = TransferLanguage::where(['transfer_id' => $product_id])->where('language_id', $language)->first();
            if ($get_transfer_language) {
                $AirportTransferCheckOut->product_name                  = $get_transfer_language['title'];
            }
            $AirportTransferCheckOut->first_name                    = $request->first_name;
            $AirportTransferCheckOut->last_name                     = $request->last_name;
            $AirportTransferCheckOut->phone_code                    = $request->phone_code;
            $AirportTransferCheckOut->phone_number                  = $request->phone_number;
            $AirportTransferCheckOut->email                         = $request->email;
            $AirportTransferCheckOut->flight_number                 = $request->flight_number;
            $AirportTransferCheckOut->flight_arrival_time           = $request->flight_arrival_time;
            $AirportTransferCheckOut->drop_off_point                = $request->drop_off_point;
            $AirportTransferCheckOut->pick_up_point                 = $request->pick_up_point;
            $AirportTransferCheckOut->recommended_pick_up_time      = $request->recommended_pick_up_time;
            $AirportTransferCheckOut->flight_departure_time         = $request->flight_departure_time;
            $AirportTransferCheckOut->notes                         = $request->notes;
            $AirportTransferCheckOut->country                       = $request->country;
            $AirportTransferCheckOut->departure_country             = $request->departure_country;
            $AirportTransferCheckOut->accommodation_name            = $request->accommodation_name;
            $AirportTransferCheckOut->address_line_1                = $request->address_line_1;
            $AirportTransferCheckOut->address_line_2                = $request->address_line_2;
            $AirportTransferCheckOut->address_line_3                = $request->address_line_3;
            $AirportTransferCheckOut->departure_flight_number       = $request->departure_flight_number;
            $AirportTransferCheckOut->user_id                       = $user_id;
            $AirportTransferCheckOut->language_id                   = $language;
            $AirportTransferCheckOut->airport_id                    = $airport_id;
            $AirportTransferCheckOut->airport_name                  = getAllInfo('airport_detail', ['id' => $airport_id], 'name');
            $AirportTransferCheckOut->going_to_id                   = $going_to_id;
            $AirportTransferCheckOut->going_to_location             = getAllInfo('locations', ['id' => $going_to_id], 'location_title');
            $AirportTransferCheckOut->adult                         = $adult;
            $AirportTransferCheckOut->child                         = $child;
            $AirportTransferCheckOut->infant                        = $infant;
            $AirportTransferCheckOut->product_id                    = $product_id;
            $AirportTransferCheckOut->return_transfer_check         = $return_transfer_check == "true" ? 1 : 0;
            $AirportTransferCheckOut->return_diffrent_address_check = $return_diffrent_address_check == "true" ? 1 : 0;
            $AirportTransferCheckOut->number_of_vehical             = $number_of_vehical;
            $AirportTransferCheckOut->title                         = $request->title;

            $currency = request()->currency;
            $CurrencySymbol = CurrencySymbol::where('code', $currency)->first();

            if ($CurrencySymbol) {
                $currency = $CurrencySymbol->symbol;
            }

            $AirportTransferCheckOut->currency              = $currency;


            $zone_id            = $going_to_id;
            if ($going_to_type == 'location') {
                $Locations      = Locations::where(['id' => $going_to_id])->first();
                $zone_id        = $Locations->zone;
            }


            // $extra_arr['product_image']             = Transfer;
            $product_title                  = '';
            $extra_arr['description']       = '';
            $extra_arr['short_description'] = '';
            $get_bus_transfer_language    = TransferLanguage::where(['transfer_id' => $product_id, 'vehicle_type' => 'bus'])->get();
            $get_car_transfer_language    = TransferLanguage::where(['transfer_id' => $product_id, 'vehicle_type' => 'car'])->get();
            if ($get_transfer_language) {
                $product_title                    = $Transfer->product_type == "bus" ?  getLanguageTranslate($get_bus_transfer_language, $language, $product_id, 'title', 'transfer_id') : getLanguageTranslate($get_car_transfer_language, $language, $product_id, 'title', 'transfer_id');
                $extra_arr['description']         =  $Transfer->product_type == "bus" ?  getLanguageTranslate($get_bus_transfer_language, $language, $product_id, 'description', 'transfer_id') : getLanguageTranslate($get_car_transfer_language, $language, $product_id, 'description', 'transfer_id');
                $extra_arr['short_description']   =  $Transfer->product_type == "bus" ?  getLanguageTranslate($get_bus_transfer_language, $language, $product_id, 'short_description', 'transfer_id') : getLanguageTranslate($get_car_transfer_language, $language, $product_id, 'short_description', 'transfer_id');
            }
            $extra_arr['title']               = $product_title;
            $extra_arr['client_reward_point'] = $Transfer->client_reward_point;

            if ($Transfer->product_type  == "bus") {
                $TransferCarType              = TransferBusType::where(['transfer_id' => $product_id])->first();
            } else {

                $TransferCarType                  = TransferCarType::where(['transfer_id' => $product_id])->first();
            }

            $extra_arr['car_image']           = $TransferCarType != "" ? asset('public/uploads/Transfer_images/' . $TransferCarType->car_image) : asset('uploads/placeholder/placeholder.png');
            $extra_arr['passengers']          = $TransferCarType->passengers;
            $extra_arr['car_type']            = $TransferCarType->car_type;
            $extra_arr['car_type_name']       = getAllInfo('car_type_language', ['car_type_id' => $TransferCarType->car_type, 'language_id' => $language], 'title');
            $extra_arr['country_id']          = $TransferCarType->country;
            $extra_arr['country_name']        = getAllInfo('countries', ['id' => $TransferCarType->country], 'name');

            $extra_arr['state_id']          = $TransferCarType->state;
            $extra_arr['state_name']        = getAllInfo('states', ['id' => $TransferCarType->state], 'name');
            $extra_arr['luggage_allowed']   = $TransferCarType->luggage_allowed;
            $extra_arr['free_cancelation']  = $TransferCarType->free_cancelation;
            $extra_arr['airport']           = $TransferCarType->airport_id;
            $extra_arr['airport_name']      = getAllInfo('airport_detail', ['id' => $TransferCarType->airport_id], 'name');
            $extra_arr['zone_id']           = $TransferCarType->zone_id;
            $extra_arr['zone']              = getAllInfo('zones', ['id' => $TransferCarType->zone_id], 'zone_title');
            $extra_arr['no_hidden_cost']    = $TransferCarType->no_hidden_cost;
            $extra_arr['product_bookable']  = $TransferCarType->product_bookable;
            $extra_arr['meet_greet']        = $TransferCarType->meet_greet;
            $extra_arr['journey_time']      = $Transfer['journey_time'];
            $extra_arr['tax_allowed']       = $Transfer['tax_allowed'];
            $extra_arr['service_allowed']   = $Transfer['service_allowed'];
            $extra_arr['product_type']      = $Transfer['product_type'];
            $extra_arr['tax_percentage']    = $Transfer['tax_percentage'];
            $extra_arr['service_amount']    = ConvertCurrency($Transfer['service_amount']);
            $extra_arr['order_cancel']      = 0;
            $extra_arr['order_cancel_by']   = 'User';
            $extra_arr['order_cancel_time'] = '';

            // V 07-17-2023 4-21 
            $zone_id  = $going_to_id;
            if ($going_to_type == 'location') {
                $Locations      = Locations::where(['id' => $going_to_id])->first();
                if($Locations){
                    $zone_id        = $Locations->zone;
                }
                $get_distace_timing = LocationDistanceTiming::where(['airport_id' => $airport_id, 'location_id' => $going_to_id])->first();
                if ($get_distace_timing) {
                    $extra_arr['distance']     = $get_distace_timing['distance'];
                    $extra_arr['journey_time'] = $get_distace_timing['duration'];
                }
            }
            //V 07-17-2023 4-21






            //TransferZones Type
            $zone_total_amnt              = 0;
            $airport_parking_fee          = 0;
            $extra_arr['transfer_zones']  = [];
            $TransferZones      = TransferZones::where('transfer_id', $Transfer->id)->where('airport_id', $airport_id)->where('zone_id', $zone_id)->where('vehicle_type', $Transfer->product_type)->first();
            if ($TransferZones) {

                $adult_price = 0;
                $child_price = 0;
                if ($Transfer->product_type == "bus") {

                    $adult_price =   ConvertCurrency($TransferZones['adult_price']);
                    $child_price =   ConvertCurrency($TransferZones['child_price']);
                    $price = $adult_price * $adult + $child_price * $child;
                } else {
                    $price =   ConvertCurrency($TransferZones['price']);
                }

                $extra_arr['transfer_zones']['airport_id']          = $TransferZones['airport_id'];
                $extra_arr['transfer_zones']['zone_id']             = $TransferZones['zone_id'];
                $extra_arr['transfer_zones']['price']               = ConvertCurrency($TransferZones['price']);
                $extra_arr['transfer_zones']['adult_price']         = $adult_price != '' ? $adult_price : '';
                $extra_arr['transfer_zones']['child_price']         = $child_price != '' ? $child_price : '';
                $extra_arr['transfer_zones']['airport_parking_fee'] = ConvertCurrency($TransferZones['airport_parking_fee']);
                $extra_arr['transfer_zones']['going_to_type']       = $going_to_type;

                if ($return_transfer_check == 'true') {

                    if ($Transfer->product_type == "bus") {
                        $airport_parking_feeDAta =  ConvertCurrency($TransferZones['airport_parking_fee']);
                    } else {
                        $airport_parking_feeDAta =  ConvertCurrency($TransferZones['airport_parking_fee']) * 2;
                    }


                    $zone_total_amnt     += $extra_arr['transfer_zones']['total_price']           = $price  * 2;
                    $airport_parking_fee += $extra_arr['transfer_zones']['total_parking_fee']     = $airport_parking_feeDAta;
                } else {
                    $zone_total_amnt     += $extra_arr['transfer_zones']['total_price']           = $price;
                    $airport_parking_fee += $extra_arr['transfer_zones']['total_parking_fee']     = ConvertCurrency($TransferZones['airport_parking_fee']);
                }

                if ($Transfer->product_type == "bus") {
                    $extra_arr['transfer_zones']['transfer_total'] = $zone_total_amnt;
                    $extra_arr['transfer_zones']['parking_total']  = $airport_parking_fee;
                    $zone_total_amnt     = $zone_total_amnt;
                    $airport_parking_fee = $airport_parking_fee;
                } else {
                    $extra_arr['transfer_zones']['transfer_total'] = $zone_total_amnt * $number_of_vehical;
                    $extra_arr['transfer_zones']['parking_total']  = $airport_parking_fee * $number_of_vehical;
                    $zone_total_amnt     = $zone_total_amnt * $number_of_vehical;
                    $airport_parking_fee = $airport_parking_fee * $number_of_vehical;
                }
            }

            //TransferZones Type End

            //TransferExtrasOptions Start
            $extra_options_total = 0;
            $extra_arr['transfer_option'] = [];
            if (count($extra_options) > 0) {
                $extra_arr['transfer_option']['options'] = [];
                $extra_arr['transfer_option']['total']   = 0;
                foreach ($extra_options as $extra_option_key => $extra_option_value) {
                    # code...
                    $extra_option_arr      = array();
                    $TransferExtrasOptions = TransferExtrasOptions::where('transfer_id', $product_id)->where('id', $extra_option_value['id'])->first();
                    if ($TransferExtrasOptions) {
                        if ($extra_option_value['is_check'] == 1) {
                            $TransferExtrasOptionsLanguage    = TransferExtrasOptionsLanguage::where('extra_option_id', $TransferExtrasOptions['id'])->where('language_id', $language)->first();
                            $extra_option_arr['title']       = $TransferExtrasOptionsLanguage['option_title'];
                            $extra_option_arr['description'] = $TransferExtrasOptionsLanguage['option_description'];
                            $extra_option_arr['id']          = $TransferExtrasOptions['id'];
                            $extra_option_arr['price']       = ConvertCurrency($TransferExtrasOptions['extra_price']);
                            $extra_option_arr['departure']   = $TransferExtrasOptions['departure'];
                            $extra_option_arr['arrival']     = $TransferExtrasOptions['arrival'];

                            $extra_option_arr['user_departure'] = $extra_option_value['departure'];
                            $extra_option_arr['user_arrival']   = $extra_option_value['arrival'];
                            $extra_option_arr['total']        = 0;

                            if ($extra_option_value['departure'] == 1 && $extra_option_value['arrival'] == 1) {
                                $extra_options_total += $extra_option_arr['total_price'] = ConvertCurrency($TransferExtrasOptions['extra_price']) * 2;
                            } else {
                                $extra_options_total += $extra_option_arr['total_price'] = ConvertCurrency($TransferExtrasOptions['extra_price']);
                            }

                            $extra_arr['transfer_option']['options'][] = $extra_option_arr;
                        }
                    }
                }
                $extra_arr['transfer_option']['total'] = $extra_options_total;
            }
            //TransferExtrasOptions End



            //Extra needs Start
            $extra_need_total = 0;
            $extra_arr['transfer_needs']  = [];
            if (count($extra_needs) > 0) {
                $extra_arr['transfer_needs']['option'] = [];
                $extra_arr['transfer_needs']['total'] = 0;
                foreach ($extra_needs as $extra_need_key => $extra_need_value) {
                    # code...
                    if ($extra_need_value['adult_qty'] > 0 || $extra_need_value['child_qty'] > 0) {
                        $extra_needs_arr = [];
                        $TransferExtras = TransferExtras::where('transfer_id', $product_id)->where('id', $extra_need_value['id'])->first();
                        if ($TransferExtras) {
                            $total                                = 0;
                            $TransferExtrasLanguage               = TransferExtrasLanguage::where('extras_id', $extra_need_value['id'])->where('language_id', $language)->first();
                            $extra_needs_arr['id']                    = $TransferExtras['id'];
                            $extra_needs_arr['adult_price']           = ConvertCurrency($TransferExtras['adult_price']);
                            $extra_needs_arr['child_price']           = ConvertCurrency($TransferExtras['child_price']);
                            $extra_needs_arr['child_allowed']         = $TransferExtras['child_allowed'];
                            $extra_needs_arr['is_return']             = $extra_need_value['is_outward'];
                            $extra_needs_arr['is_outward']            = $extra_need_value['is_outward'];
                            $extra_needs_arr['title']                 = $TransferExtrasLanguage['extra_title'];
                            $extra_needs_arr['extra_information']     = $TransferExtrasLanguage['extra_information'];
                            $extra_needs_arr['adult_qty']             = $extra_need_value['adult_qty'];
                            $extra_needs_arr['child_qty']             = $extra_need_value['child_qty'];

                            if ($extra_need_value['is_return'] == 1 && $extra_need_value['is_outward'] == 1) {
                                $total                                   += $extra_needs_arr['child_total_price'] = $extra_need_value['child_qty'] * ConvertCurrency($TransferExtras['child_price']) * 2;
                                $total                                   += $extra_needs_arr['adult_total_price'] = $extra_need_value['adult_qty'] * ConvertCurrency($TransferExtras['adult_price']) * 2;
                            } else {
                                $total                                   += $extra_needs_arr['child_total_price'] = $extra_need_value['child_qty'] * ConvertCurrency($TransferExtras['child_price']);
                                $total                                   += $extra_needs_arr['adult_total_price'] = $extra_need_value['adult_qty'] * ConvertCurrency($TransferExtras['adult_price']);
                            }

                            $extra_need_total += $extra_needs_arr['total'] = $total;
                            $extra_arr['transfer_needs']['option'][]  = $extra_needs_arr;
                        }
                    }
                }
                $extra_arr['transfer_needs']['total'] = $extra_need_total;
            }
            //Extra needs end


            //Product Vouchers Start
            // OrderProductVouchers
            $ProductVoucher = ProductVoucher::where('product_id',$product_id)->get();
            if(!$ProductVoucher->isEmpty()){
                foreach ($ProductVoucher as $key => $value) {
                    $get_vouchers                = [];
                    $get_vouchers['title']       = '';
                    $get_vouchers['description'] = '';
                    $get_vouchers['remark']      = '';
                    $ProductVoucherLanguage = ProductVoucherLanguage::where('voucher_id',$value['id'])->where('language_id',$language)->first();
                    if($ProductVoucherLanguage){
                        if($ProductVoucherLanguage['title']){
                            $get_vouchers['title']       = $ProductVoucherLanguage['title'];
                        }
                        if($ProductVoucherLanguage['description']){
                            $get_vouchers['description']       = $ProductVoucherLanguage['description'];
                        }
                        if($ProductVoucherLanguage['voucher_remark ']){
                            $get_vouchers['voucher_remark ']    = $ProductVoucherLanguage['voucher_remark '];
                        }
                    }
                    $get_vouchers['voucher_amount'] = $value['voucher_amount'];
                    $get_vouchers['meeting_point']  = $value['meeting_point'];
                    $get_vouchers['phone_number']   = $value['phone_number'];
                    $get_vouchers['product_id']     = $value['product_id'];
                    $get_vouchers['type']           = $value['type'];
                    $get_vouchers['amount_type']    = $value['amount_type'];
                    
                    if($value['our_logo']!=''){
                        $get_vouchers['our_logo']       = url('uploads/Transfer_images',$value['our_logo']);
                    }else{
                        $get_vouchers['our_logo']    = '';
                    }
                    if($value['voucher_image']!=''){
                        $get_vouchers['voucher_image']       = url('uploads/Transfer_images',$value['voucher_image']);
                    }else{
                        $get_vouchers['voucher_image']    = '';
                    }
                    if($value['client_logo']!=''){
                        $get_vouchers['client_logo']       = url('uploads/Transfer_images',$value['client_logo']);
                    }else{
                        $get_vouchers['client_logo']    = '';
                    }                    
                    $extra_arr['vouchers'][]    = $get_vouchers;
                }
            }
        //Product Vouchers Start

            $sub_total                    = $zone_total_amnt + $extra_need_total + $extra_options_total;


            $Currency = Currency::where('is_default', 1)->first();


            $to  =  request()->currency;
            $from = $Currency->sort_code;

            $currentDatetime = carbon::now()->timestamp;
            $CurrencyRatesData = CurrencyRates::where(['base' => $from, 'country_code' => $to])->where('date', ">=", $currentDatetime)->first();

            // dd($forCommisontotalAmount);
            $sub_total_for_affilaiate =  $sub_total / $CurrencyRatesData->rate;

            $total_affilate_comision      = ($sub_total_for_affilaiate / 100) *  $Transfer->affiliate_commission;
            $affilate_user                = 0;
            $getUser                      = User::where('affiliate_code', $AffilliateCode)->where('user_type', 'Affiliate')->where('is_verified', 1)->first();
            if ($getUser) {
                $affilate_user = $getUser['id'];
            }
            $AffilliateCommission['user_id']         = $affilate_user;
            $get_commission_arr                      = [];
            $get_commission_arr['product_id']        = $product_id;
            $get_commission_arr['product_name']      = $product_title;
            $get_commission_arr['product_amount']    = $sub_total;
            $get_commission_arr['commission']        = $Transfer->affiliate_commission;
            // totalAmount
            $get_commission_arr['commission_amount'] = $total_affilate_comision;
            $AffilliateCommissionArr[]               = $get_commission_arr;
            $AffilliateCommission['extra']           = json_encode($AffilliateCommissionArr);
            $AffilliateCommission['affilliate_code'] = $AffilliateCode;
            $AffilliateCommission['total']           = $total_affilate_comision;
            $AffilliateCommission['type']            = "transfer";


            //////Tax And Servoice
            $service_amount               = 0;
            $tax_amount                   = 0;

            $extra_arr['service_allowed'] = (int) $Transfer['service_allowed'];
            $extra_arr['tax_allowed']     = (int) $Transfer['tax_allowed'];

            if ($Transfer['service_allowed'] == 1) {
                $service_amount               = ConvertCurrency($Transfer['service_amount']);
            }
            if ($Transfer['tax_allowed'] == 1) {
                $extra_arr['tax_percentage']  = $Transfer['tax_percentage'];
                if ($Transfer['tax_percentage'] != 0 && $Transfer['tax_percentage'] != null  && $sub_total != 0) {
                    $tax_amount              = ($sub_total * $Transfer['tax_percentage']) / 100;
                }
            }
            $extra_arr['tax_amount']      = number_format($tax_amount, 2);
            $extra_arr['service_amount']  = number_format($service_amount, 2);
            $extra_arr['tax_service']     = $tax_amount + $service_amount;
            $extra_arr['sub_total']       = $sub_total = $sub_total + $airport_parking_fee + $tax_amount + $service_amount;
            //////Tax And Servoice
            // return json_encode($extra_arr);

            // return json_encode($extra_arr);
            $AirportTransferCheckOut->total_amount   = $sub_total;
            $AirportTransferCheckOut->status         = "Success";
            $AirportTransferCheckOut->payment_method = "Cod";
            $AirportTransferCheckOut->save();
            $order_id                               = $AirportTransferCheckOut->id;
            $custom_order_id                        = "TOT" . date('Y') . str_pad($order_id, 2, '0', STR_PAD_LEFT);
            $getProductCheckout                     = AirportTransferCheckOut::find($order_id);
            $getProductCheckout->order_id           = $custom_order_id;


            // Cancel TIME

            $Cancel_time = $Transfer->can_be_cancelled_up_to_advance;
            $Cancellation_date = "";
            $Cancellation_timestamp = "";
            if ($Cancel_time != "") {
                $time_string = explode('-', $Cancel_time);
                $order_date  = Carbon::create($getProductCheckout->created_at);

                $Cancellation_date      = $order_date->addDays($time_string[0])->addHours($time_string[1])->addMinute($time_string[2]);
                $Cancellation_timestamp = strtotime($Cancellation_date);
            }

            $extra_arr['cancellation_up_to_time']       = $Cancellation_date;
            $extra_arr['cancellation_up_to_time_stamp'] = $Cancellation_timestamp;

            $getProductCheckout->extras         = json_encode($extra_arr);
            $getProductCheckout->save();

            $AllOrders                          = new AllOrders();
            $AllOrders->user_id                 = $user_id;
            $AllOrders->order_type              = 'transfer';
            $AllOrders->order_id                = $getProductCheckout->id;
            $AllOrders->save();



            $AffilliateCommission['order_id']       = $order_id;
            if ($affilate_user > 0) {
                $AffilliateCommission->save();
            }


            // Add User Rewads Points Strt
            $client_rewards_points = $Transfer->client_reward_point;
            if ($client_rewards_points > 0) {
                $RewardsPoints             = new RewardsPoints();
                $RewardsPoints->user_id    = $user_id;
                $RewardsPoints->order_id   = $order_id;
                $RewardsPoints->product_id = $product_id;
                $RewardsPoints->type       = "transfer_product";
                $RewardsPoints->points     = $client_rewards_points;
                $RewardsPoints->save();
                
            }
            // Add User Rewads Points End

            // Add User Rewads Points Strt
            $client_rewards_points = $Transfer['client_reward_point'];
            $client_reward_point_type = $Transfer['client_reward_point_type'];
            if ($client_rewards_points > 0) {
                $RewardsPoints             = new RewardsPoints();
                $RewardsPoints->user_id    = $user_id;
                $RewardsPoints->order_id   = $order_id;
                $RewardsPoints->product_id = $product_id;
                $RewardsPoints->type       = "transfer_product";
                if ($client_reward_point_type == 'Percentage') {
                    $reward_point_percentage   = $client_rewards_points;
                    $client_rewards_points      = ($no_tax_service_total_amnt_per_product * $client_rewards_points) / 100;
                    $RewardsPoints->percentage = $reward_point_percentage;
                    $RewardsPoints->points     = $client_rewards_points;
                } else {
                    $RewardsPoints->points     = $client_rewards_points;
                }
                $RewardsPoints->save();
                $rewards_points_id_arr[]   = $RewardsPoints->id;
                $User                      = User::where('id', $user_id)->where('is_verified', 1)->first();
                if ($User) {
                    $User->current_reward_points = $User->current_reward_points + $client_rewards_points;
                    $User->save();
                }               
            }
            // Add User Rewads Points End


            
            
            //Order Detail Mail
            $order_email_data                           = [];
            $order_email_data['page']                   = "email.order_mail";
            $order_email_data['subject']                = translate('Order Detail Mail');
            $order_email_data['full_name']              = $AirportTransferCheckOut->first_name  .' '.$AirportTransferCheckOut->last_name;
            $order_email_data['email']                  = $AirportTransferCheckOut->email;
            $order_email_data['order_id']               = '#'.$AirportTransferCheckOut->order_id;
            $order_email_data['address']                = $AirportTransferCheckOut->address_line_1;
            $order_email_data['total']                  = $AirportTransferCheckOut->total_amount;
            $order_email_data['payment_method']         = $AirportTransferCheckOut->payment_method;
            $order_email_data['currency']               = $AirportTransferCheckOut->currency;
            $order_email_data['id']                     = encrypt($AirportTransferCheckOut->id);
            $order_email_data['type']                   = "transfer";
            $order_email_data['order_date']             = date('Y-m-d', strtotime( $AirportTransferCheckOut->created_at));
            Admin::send_mail($order_email_data);
            //Order Detail Mail




            $output['status']   = true;
            $output['type']     = "transfer";
            $output['id']       = encrypt($order_id);
            $output['message']  = 'Submit Successfully';
        } else {
            $output['status']   = false;
            $output['message']  = 'Something Went Wrong...';
        }
        return json_encode($output);
    }




    public function api_for_add_location(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            'transfer_id'  => 'required',
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

        $transfer_id     = $request->transfer_id;

        $get_transfer_zones_loc = TransferZones::where("transfer_id", $transfer_id)->get();

        if ($get_transfer_zones_loc) {
            foreach ($get_transfer_zones_loc as $key => $value_tra) {

                $zone_id = $value_tra['zone_id'];
                $airport_id = $value_tra['airport_id'];

                $get_airport = AirportModel::where('id', $airport_id)->first();

                $address_lattitude = $get_airport['address_lattitude'];
                $address_longitude = $get_airport['address_longitude'];

                $decode_res = [];
                $destination_addresses = $address_lattitude . '%2C' . $address_longitude;

                $get_count = Locations::where('zone', $zone_id)->count();
                $get_limit = round($get_count / 25);

                $Locations = Locations::where('zone', $zone_id);
                $new_arr = array();
                for ($i = 0; $i < $get_limit; $i++) {

                    $AddVer = 1;
                    if ($i == 0) {
                        $AddVer = 0;
                    }
                    $skip_limit = $i * 25;

                    $get_loc_details = $Locations->skip($skip_limit)->take(25)->get(); //get first 10 rows

                    $new_arr[] = $get_loc_details;
                }


                foreach ($new_arr as $key_2 => $value_new) {

                    $origins_arr = array();
                    foreach ($value_new as $key => $value) {

                        $row = array();
                        $new_row = array();
                        $get_distace_timing = LocationDistanceTiming::where(['airport_id' => $airport_id, 'location_id' => $value['id']])->first();
                        if ($get_distace_timing == '') {
                            $row = $value["address_lattitude"] . '%2C' . $value["address_longitude"];

                            $origins_arr[] = $row;
                        }
                    }

                    $List = implode('%7C', $origins_arr);


                    if (count($origins_arr) > 0) {
                        $curl = curl_init();

                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://maps.googleapis.com/maps/api/distancematrix/json?destinations=' . $destination_addresses . '&origins=' . $List . '&units=imperial&key=AIzaSyCpqoRKJ3CM7GGiFWTEY0qCKYYRh00ULF0',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                        ));

                        $response = curl_exec($curl);


                        $decode_res = json_decode($response);

                        curl_close($curl);
                    }

                    // echo $response;
                    $loc_array = array();
                    if (count($origins_arr) > 0) {
                        if ($decode_res->status == 'OK') {
                            foreach ($decode_res->rows as $key_t => $value) {
                                $LocationDistanceTiming = new LocationDistanceTiming();
                                if ($value != '') {
                                    $LocationDistanceTiming->airport_id     = $airport_id;
                                    $LocationDistanceTiming->location_id    = $value_new[$key_t]['id'];
                                    $LocationDistanceTiming->distance       = @$value->elements[0]->distance->text;
                                    $LocationDistanceTiming->duration       = @$value->elements[0]->duration->text;
                                    $LocationDistanceTiming->save();
                                }
                            }
                        }
                    }
                }

                $output['status'] = true;
                $output['message'] = 'Data Fetched Successfully...';
            }
        }

        return json_encode($output);
    }

    
}
