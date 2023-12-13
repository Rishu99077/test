<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\ProductLanguage;
use App\Models\ProductTimings;
use App\Models\ProductHighlights;
use App\Models\ProductHighlightLanguage;
use App\Models\ProductAddtionalInfo;
use App\Models\ProductAdditionalInfoLanguage;
use App\Models\ProductImages;
use App\Models\ProductSiteAdvertisement;
use App\Models\ProductSiteAdvertisementLanguage;
use App\Models\ProductFaqs;
use App\Models\ProductFaqLanguage;
use App\Models\ProductOptions;
use App\Models\ProductOptionLanguage;
use App\Models\ProductOptionDetails;
use App\Models\ProductOptionTourUpgrade;
use App\Models\Timing;
use App\Models\ProductPrivateTransferCars;
use App\Models\ProductTourPriceDetails;
use App\Models\ProductToolTipLanguage;
use App\Models\ProductOptionWeekTour;
use App\Models\ProductOptionTaxServiceCharge;
use App\Models\ProductInfo;
use App\Models\ProductOptionPeriodPricing;
use App\Models\Language;
use App\Models\ProductLodge;
use App\Models\ProductLodgeLanguage;
use App\Models\ProductOptionPrivateTourPrice;
use App\Models\YachtFeatureHighlight;
use App\Models\YachtFeatureHighlightLanguage;
use App\Models\MetaGlobalLanguage;
use App\Models\YachtAmenities;
use App\Models\YachtAmenitiesLanguage;
use App\Models\YachtBoatSpecification;
use App\Models\YachtBoatSpecificationLanguage;
use App\Models\YachtAmenitiesPoints;
use App\Models\YachtAmenitiesPointsLanguage;
use App\Models\TransportationVehicle;
use App\Models\TransportationVehicleLanguage;
use App\Models\OverRideBanner;
use App\Models\OverRideBannerLanguage;
use App\Models\Productyachttransferoption;
use App\Models\Productyachttransferoptionlanguage;
use App\Models\AddToCart;
use App\Models\Productyachtwatersport;
use App\Models\Productyachtwatersportlanguage;
use App\Models\Productyachtrelatedboats;
use App\Models\Wishlist;
use App\Models\BoatTypes;
use App\Models\BoatLocations;
use App\Models\Country;
use App\Models\AffilliateGeneratedLinks;
use App\Models\ProductRequestForm;
use App\Models\UserReview;
use App\Models\User;

use App\Models\ProductExprienceIcon;
use App\Models\ProductExprienceIconLanguage;

use App\Models\Customers;
use App\Models\ProuductCustomerGroupDiscount;

use Illuminate\Support\Arr;
use DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;

class YachtController extends Controller
{
    // Yacht List
    public function yacht_list(Request $request)
    {
        $output = [];
        $output['status'] = false;
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
        $setLimit = 9;
        $offset   = $request->offset;
        $limit    = $offset * $setLimit;
        $boatLocation = [];
        $ProductForBoat = [];
        if (isset($request->is_filter) && $request->is_filter == 1) {
            $ProductCount = Product::where(['status' => 'Active', 'is_delete' => 0, 'product_type' => 'yacht']);
            $Product = Product::select("*")->addSelect(DB::raw('IF(selling_price > 0, selling_price, original_price ) AS current_price'))->where(['status' => 'Active', 'is_delete' => 0, 'product_type' => 'yacht'])
                ->where('slug', '!=', '');

            if (isset($request->country)) {
                $country = $request->country;
                if ($country > 0) {
                    $ProductCount = $ProductCount->where("country", $country);
                    $Product = $Product->where("country", $country);
                }
            }
            if (isset($request->state)) {
                $state = $request->state;
                if ($state  > 0) {
                    $ProductCount = $ProductCount->where("state", $state);
                    $Product = $Product->where("state", $state);
                }
            }
            if (isset($request->city)) {
                $city = $request->city;
                if ($city) {
                    $ProductCount = $ProductCount->where("city", $city);
                    $Product = $Product->where("city", $city);
                }
            }
            if (isset($request->guest)) {
                $guest = $request->guest;
                if ($guest > 0) {
                    $ProductCount = $ProductCount->where("boat_maximum_capacity", '>=', $guest);
                    $Product = $Product->where("boat_maximum_capacity", '>=', $guest);
                }
            }

            if (isset($request->boat_type)) {
                $boat_type = $request->boat_type;
                if ($boat_type > 0) {
                    $ProductCount = $ProductCount->whereRaw('FIND_IN_SET(?, boat_type)', [$boat_type]);
                    $Product = $Product->whereRaw('FIND_IN_SET(?, boat_type)', [$boat_type]);
                }
            }

            if (isset($request->sort)) {
                $sort = $request->sort;
                if ($sort != "") {
                    if ($sort == "high_low") {

                        $Product = $Product->orderBy("current_price", "DESC");
                    } else if ($sort == "capacity_high") {
                        $Product = $Product->orderBy("boat_maximum_capacity", "DESC");
                    } else if ($sort == "capacity_low") {
                        $Product = $Product->orderBy("boat_maximum_capacity", "asc");
                    } else {
                        $Product = $Product->orderBy("current_price", "ASC");
                    }
                }
            }
            $Product = $Product->orderBy("boat_maximum_capacity", "DESC");



            $newProduct = $Product->get();
            $ProductForBoat = $newProduct;
            ///Gets Boat Location

            $boatLocation_arr = $newProduct->map(function ($item) {
                return (int)$item->boat_location;
            });
            $boatLocationID       = json_decode($boatLocation_arr, true);
            $UniqueboatLocationID = array_unique($boatLocationID);
            $boatLocation = BoatLocations::select('boat_location as name', 'id')->find($UniqueboatLocationID);

            ///Gets Boat Location End



            if (isset($request->is_boat_location)) {

                $is_boat_location = $request->is_boat_location;

                $ProductCount = $ProductCount->where(function ($q) use ($is_boat_location) {
                    foreach ($is_boat_location as $IBL => $case) {
                        if ($case == "true") {
                            $q->orWhere('boat_location', $IBL);
                        }
                    }
                });


                $Product = $Product->where(function ($q) use ($is_boat_location) {

                    foreach ($is_boat_location as $IBL => $case) {
                        // return $IBL;
                        if ($case == "true") {
                            $q->orWhere('boat_location', $IBL);
                        }
                    }
                });


                // return ($Product->toSql());

                // foreach ($is_boat_location as $ikey => $IBL) {
                //     if ($IBL == "true") {

                //         $ProductCount = $ProductCount->where("boat_location", $ikey);
                //         $Product = $Product->where("boat_location", $ikey);
                //     }
                // }
                // $ProductCount = $ProductCount->where("boat_location", $is_boat_location);
                // $Product = $Product->where("boat_location", $is_boat_location);
            }

            $ProductCount = $ProductCount->where('slug', '!=', '')
                ->count();


            $Product = $Product
                ->offset($limit)
                ->limit($setLimit)
                ->get();
        } else {
            $ProductCount = Product::where(['status' => 'Active', 'is_delete' => 0, 'product_type' => 'yacht'])
                ->where('slug', '!=', '')
                ->count();
            $ProductForBoat = Product::where(['status' => 'Active', 'is_delete' => 0, 'product_type' => 'yacht'])
                ->where('slug', '!=', '')
                ->orderBy('id', 'DESC')->get();
            $Product = Product::where(['status' => 'Active', 'is_delete' => 0, 'product_type' => 'yacht'])
                ->where('slug', '!=', '')
                ->orderBy('boat_maximum_capacity', 'DESC')
                ->offset($limit)
                ->limit($setLimit)
                ->get();
        }

        $output['page_count'] = ceil($ProductCount / $setLimit);
        $output['total_product'] = $ProductCount;
        $language = $request->language;
        $ProductArr = [];
        $BoatID = [];
        foreach ($ProductForBoat as $pkey => $PFB) {
            if ($PFB['boat_type'] != "") {
                $BoatID[] = explode(",", $PFB['boat_type']);
            }
        }



        foreach ($Product as $key => $P) {
            $productLang = ProductLanguage::where(['product_id' => $P['id'], 'language_id' => $language])->first();
            $title = '';
            $main_description = '';

            if ($productLang) {
                $title = $productLang->description;
                $short_description = $productLang->short_description;
                $main_description = $productLang->main_description;
            }

            $approx = '';
            if ($P['approx'] == 1) {
                $approx = '(Approx)';
            }

            $duration = explode('-', $P['duration']);
            $dura = '';

            foreach ($duration as $k => $D) {
                if ($k == 0) {
                    $val = 'D ';
                } elseif ($k == 1) {
                    $val = 'H ';
                } else {
                    $val = 'M ';
                }
                if ($D > 0) {
                    $dura .= $D . $val;
                }
            }
            $duration = $dura . $approx;

            $city = getAllInfo('cities', ['id' => $P['city']], 'name');

            $getProductArr                          = [];
            $getProductArr['id']                    = $P['id'];
            $getProductArr['image']                 = $P['image']              != '' ? asset('public/uploads/product_images/' . $P['image']) : asset('public/assets/img/no_image.jpeg');
            // $getProductArr['name']                  = $title;
            $getProductArr['name']                   = short_description_limit($title, 50);
            $getProductArr['full_name']               = $title;
            $getProductArr['short_description']      = short_description_limit($short_description, 50);
            // $getProductArr['short_description']     = $short_description;
            $getProductArr['main_description']      = Str::limit($main_description, 60);
            $getProductArr['duration']              = $duration;
            $getProductArr['city']                  = $city;
            $getProductArr['slug']                  = $P['slug'];
            $getProductArr['boat_maximum_capacity'] = $P['boat_maximum_capacity'];
            $getProductArr['minimum_booking']       = $P['minimum_booking'];
            $getProductArr['total_sold']            = $P['how_many_are_sold'] !== '' ? $P['how_many_are_sold'] : 0;
            $getProductArr['per_value']             = $P['per_value'];
            $getProductArr['boat_type']             = $P['boat_type'];

            $getProductArr['image_text']    = $P['image_text'] ?? null;
            $getProductArr['price']         = $P['original_price'] ?? 0;
            $getProductArr['selling_price'] = $P['selling_price'] ?? 0;
            $getProductArr['button']        = $P['product_bookable_type'] === 'bookable' ? 'Book Now' : 'On Request';
            $getProductArr['ratings']       = get_rating($P['id']);
            $getProductArr['price_html']        = get_price_front($P['id'], $request->user_id, $P['product_type']);


            // Partner
            $user_id = $request->user_id;
            if ($user_id) {

                $get_partner = User::where(['id' => $user_id, 'user_type' => 'Partner'])->first();
                if ($get_partner) {
                    $customer_group = $get_partner['customer_group'];
                    if ($customer_group) {
                        $customer_group_discount = ProuductCustomerGroupDiscount::where(['product_id' => $P['id'], 'customer_group_id' => $customer_group, 'type' => 'yacht'])->first();

                        if ($customer_group_discount) {
                            $base_price_percent = $customer_group_discount['base_price'];

                            $dicounted_amount  =  ($base_price_percent / 100) * $P['selling_price'];

                            if ($dicounted_amount) {
                                $getProductArr['partner_original_price'] = $P['selling_price'] ?? 0;

                                $getProductArr['partner_selling_price'] = $P['selling_price'] - $dicounted_amount;
                            }
                        }
                    }
                }
            }
            // Partner


            $ProductArr[] = $getProductArr;
        }


        $BoatID_flat   = Arr::flatten($BoatID);
        $BoatIDS       = array_unique($BoatID_flat);
        $BoatTypes     = BoatTypes::where(["status" => "Active", 'is_delete' => 0, 'type' => "yacht"])->whereIn('id', $BoatIDS)->get();
        $BoatTypesArr = [];
        foreach ($BoatTypes as $btkey => $BT) {
            $get_boat_type         = [];
            $get_boat_type['value']   = $BT['id'];
            $get_boat_type['label'] = $BT['boat_type'];
            $BoatTypesArr[]        = $get_boat_type;
        }

        $output['boat_location'] = $boatLocation;
        $output['boat_types']    = $BoatTypesArr;



        $output['data']        = $ProductArr;

        $output['status']      = true;
        $output['msg']         = 'Data Fetched Successfully...';
        return json_encode($output);
    }

    // Lodge Details
    public function yacht_details(Request $request)
    {

        $output = [];
        $output['status'] = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            'product_id' => 'required',
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

        $activity_id = $request->product_id;
        $user_id     = $request->user_id != "" ? decrypt($request->user_id) : 0;
        $Product     = Product::where('slug', $activity_id)->first();
        $productDeatils = [];

        if ($Product) {
            $product_id                   = $Product->id;
            $productDeatils['isWishlist'] = false;
            if ($request->user_id) {
                $user_id     = checkDecrypt($request->user_id);
                $getWishlist = Wishlist::where('user_id', $user_id)->where('product_id', $product_id)->first();
                if ($getWishlist) {
                    $productDeatils['isWishlist'] = true;
                }
            }



            $product_slug = $Product->slug;
            $language = $request->language;
            $Product = Product::where('id', $product_id)
                ->where('product_type', 'yacht')
                ->where('status', 'Active')
                ->first();

            if ($Product) {
                $WeekDay                      = Carbon::now()->dayName;
                $productDeatils['product_id'] = $Product['id'];

                //Price
                $productDeatils['price_html']         = get_price_front_detail($Product['id'], $request->user_id, $Product['product_type']);
                //Price

                $productDeatils['ratings']        = get_rating($Product['id']);
                $productDeatils['total_rating_count']    = DB::table('user_review')->where('product_id', $Product['id'])->count();

                $productDeatils['total_ratings']  = get_ratings_count($Product['id']);
                $productDeatils['generated_link']  = '';
                if ($request->user_id) {
                    $productDeatils['generated_link'] = generate_product_link("affilliate_generated_links", $product_id, $user_id, "Yacht-charts-details");
                }
                $ProductDetails                   = (array) $Product->toArray();
                $approx                           = '';
                if ($ProductDetails['approx'] == 1) {
                    $approx = '(Approx)';
                }



                foreach ($ProductDetails as $Pkey => $P) {
                    if ($Pkey == 'image' || $Pkey == 'logo' || $Pkey == 'video_thumbnail') {
                        $P = $P != '' ? asset('uploads/product_images/' . $P) : asset('uploads/placeholder/placeholder.png');
                    }

                    if ($Pkey == 'duration') {
                        if ($P != '') {
                            $duration = explode('-', $P);
                            $P = '';
                            foreach ($duration as $k => $D) {
                                if ($k == 0) {
                                    $val = ' Day ';
                                } elseif ($k == 1) {
                                    $val = ' Hours ';
                                } else {
                                    $val = ' Minute ';
                                }
                                if ($D > 0) {
                                    $P .= $D . $val;
                                }
                            }
                            $P = $P . $approx;
                        }
                    }
                    if ($Pkey == 'original_price' || $Pkey == 'selling_price') {
                        $P = ConvertCurrency($P);
                    }
                    if ($Pkey == 'blackout_date') {
                        $PNew = [];
                        if ($P != '') {
                            $P = json_decode($P, true);
                            if (count($P) > 0) {
                                foreach ($P as $Pval) {
                                    $PNew[] = trim($Pval);
                                }
                            }
                        }
                        $P = $PNew;
                    }
                    $productDeatils[$Pkey] = $P != '' ? $P : '';
                }
                $description_heading =  MetaGlobalLanguage::where('product_id', $product_id)->where('meta_title', 'yacth_description_title')
                                    ->where('language_id', $language)
                                    ->where('status', 'Active')
                                    ->first();
                if($description_heading){
                    $productDeatils['description_heading'] =$description_heading['title'];
                }else{
                    $productDeatils['description_heading'] = '';
                }
                

                $from_date = '';
                $to_date = '';
                if ($Product->note_on_sale_date != '') {
                    $dateArr = explode('to', $Product->note_on_sale_date);
                    if (isset($dateArr[0]) && isset($dateArr[1])) {
                        $from_date = trim($dateArr[0]);
                        $to_date = trim($dateArr[1]);
                    }
                }
                $productDeatils['from_date'] = $from_date;
                $productDeatils['to_date'] = $to_date;

                $currentDateTime = Carbon::now();
                $bookable_up_to = '';
                if ($Product->can_be_booked_up_to_advance != '') {
                    $duration = explode('-', $Product->can_be_booked_up_to_advance);
                    $dura = '';
                    foreach ($duration as $k => $D) {
                        if ($k == 0) {
                            if ($D > 0) {
                                $currentDateTime = $currentDateTime->addDays($D);
                            }
                        }
                        if ($k == 1) {
                            if ($D > 0) {
                                $currentDateTime = $currentDateTime->addHours($D);
                            }
                        }
                        if ($k == 2) {
                            if ($D > 0) {
                                $currentDateTime = $currentDateTime->addMinutes($D);
                            }
                        }
                    }

                    $period = CarbonPeriod::create(Carbon::now(), $currentDateTime);
                    $bookable_up_to = collect();
                    foreach ($period as $date) {
                        $bookable_up_to->add($date->format('Y-m-d'));
                    }
                }
                $productDeatils['bookable_up_to'] = $bookable_up_to;

                $productLang = ProductLanguage::where(['product_id' => $product_id, 'language_id' => $language])->first();
                $title = '';
                $main_description = '';
                $related_product_title = '';
                if ($productLang) {
                    $title = $productLang->description;
                    $main_description = $productLang->main_description;
                    if ($productLang->related_product_title) {
                        $related_product_title = $productLang->related_product_title;
                    }
                }
                $productDeatils['title'] = $title;
                $productDeatils['main_description'] = $main_description;
                $productDeatils['related_product_title'] = $related_product_title;

                // // Product Timing Code

                $ProductTimingsArr = [];
                $checkDaily = 0;
                if ($Product->timing_status == 1) {
                    $ProductTimings = ProductTimings::where(['product_id' => $product_id])->get();
                    foreach ($ProductTimings as $timeKey => $PT) {
                        $getProductTiming = [];
                        $getProductTimingDaily = [];
                        if ($PT['day'] == "Daily") {
                            if ($PT['is_close'] == 0) {
                                $checkDaily = 1;

                                $getProductTimingDaily['day'] = $PT['day'];
                                $getProductTimingDaily['time_from'] = date('g:i a', strtotime($PT['time_from']));
                                $getProductTimingDaily['time_to'] = date('g:i a', strtotime($PT['time_to']));
                                $getProductTimingDaily['is_close'] = $PT['is_close'];
                            }
                        } else {

                            $getProductTiming['day'] = $PT['day'];
                            $getProductTiming['time_from'] = date('g:i a', strtotime($PT['time_from']));
                            $getProductTiming['time_to'] = date('g:i a', strtotime($PT['time_to']));
                            $getProductTiming['is_close'] = $PT['is_close'];
                        }
                        if ($checkDaily == 1) {
                            $ProductTimingsArr = [];
                            $ProductTimingsArr[] = $getProductTimingDaily;
                            break;
                        } else {
                            $ProductTimingsArr[] = $getProductTiming;
                        }
                    }
                }
                $productDeatils['product_timing'] = $ProductTimingsArr;

                // Product Images Code
                $imagesArr = [];
                $productImages = ProductImages::where(['product_id' => $product_id])
                    ->orderBy('sort_order_images')
                    ->get();
                foreach ($productImages as $PI) {
                    $imagesArr[] = $PI['product_images'] != '' ? asset('uploads/product_images/' . $PI['product_images']) : asset('uploads/placeholder/placeholder.png');
                }
                $productDeatils['images'] = $imagesArr;

                // Product Info
                $ProductInfo = ProductInfo::where('title', 'yacht_type')
                    ->where('product_id', $product_id)
                    ->first();
                $productDeatils['free_cancellation'] = $ProductInfo != '' ? $ProductInfo->value : '';

                //Highlight Code
                $ProductHighlightsArr = [];
                $ProductHighlights = ProductHighlights::where(['product_id' => $product_id])->get();
                $ProductHighlightLanguage = ProductHighlightLanguage::where(['product_id' => $product_id])->get();
                foreach ($ProductHighlights as $key => $PH) {
                    $getProductHighlight = [];
                    $hightitle = getLanguageTranslate($ProductHighlightLanguage, $language, $PH['id'], 'title', 'highlight_id');
                    if ($hightitle != '') {
                        $getProductHighlight['title'] = getLanguageTranslate($ProductHighlightLanguage, $language, $PH['id'], 'title', 'highlight_id');
                        $getProductHighlight['description'] = getLanguageTranslate($ProductHighlightLanguage, $language, $PH['id'], 'description', 'highlight_id');
                        $ProductHighlightsArr[] = $getProductHighlight;
                    }
                }
                $productDeatils['highlight'] = $ProductHighlightsArr;

                // Product Additinal information
                $ProductAddtionalInfo = ProductAddtionalInfo::where(['product_id' => $product_id])->get();
                $ProductAdditionalInfoLanguage = ProductAdditionalInfoLanguage::where(['product_id' => $product_id])->get();
                $ProductAdditionalInfoArr = [];
                foreach ($ProductAddtionalInfo as $PAIkey => $PAI) {
                    $getProductAdditionalInfo = [];
                    $addtitle = getLanguageTranslate($ProductAdditionalInfoLanguage, $language, $PAI['id'], 'description', 'product_additional_info_id');
                    if ($addtitle != '') {
                        $getProductAdditionalInfo['title'] = $addtitle;
                        $getProductAdditionalInfo['file'] = $PAI['image'] != '' ? asset('uploads/product/' . $PAI['image']) : asset('uploads/placeholder/placeholder.png');
                        $ProductAdditionalInfoArr[] = $getProductAdditionalInfo;
                    }
                }
                $productDeatils['additional_info'] = $ProductAdditionalInfoArr;

                //Product Site Advertisement
                $ProductSiteAdvertisement = ProductSiteAdvertisement::where(['product_id' => $product_id])->get();
                $ProductSiteAdvertisementLanguage = ProductSiteAdvertisementLanguage::where(['product_id' => $product_id])->get();
                $ProductSiteAdvertisementArr = [];
                foreach ($ProductSiteAdvertisement as $PSAkey => $PSA) {
                    $getProductSiteAdver = [];
                    $sitetitle = getLanguageTranslate($ProductSiteAdvertisementLanguage, $language, $PSA['id'], 'title', 'site_advertisement_id');
                    if ($sitetitle != '') {
                        $getProductSiteAdver['title'] = getLanguageTranslate($ProductSiteAdvertisementLanguage, $language, $PSA['id'], 'title', 'site_advertisement_id');
                        $getProductSiteAdver['description'] = getLanguageTranslate($ProductSiteAdvertisementLanguage, $language, $PSA['id'], 'description', 'site_advertisement_id');
                        $getProductSiteAdver['file'] = $PSA['image'] != '' ? asset('uploads/product/' . $PSA['image']) : asset('uploads/placeholder/placeholder.png');
                        $getProductSiteAdver['link'] = $PSA['link'];
                        $ProductSiteAdvertisementArr[] = $getProductSiteAdver;
                    }
                }

                $OverRideBanner = OverRideBanner::select('over_ride_banner.*')
                    ->whereRaw('FIND_IN_SET(?, country)', [$Product->country])
                    ->join('over_ride', 'over_ride.id', '=', 'over_ride_banner.over_ride_id')
                    ->where(['over_ride.status' => 'Active', 'is_delete' => 0])
                    ->get();

                $OverRideBannerArr = [];
                foreach ($OverRideBanner as $ORB) {
                    $OverRideBannerLanguage = OverRideBannerLanguage::where(['over_ride_id' => $ORB['over_ride_id']])->get();

                    $getProductSiteAdver = [];
                    $sitetitle = getLanguageTranslate($OverRideBannerLanguage, $language, $ORB['id'], 'banner_title', 'over_ride_banner_id');
                    if ($sitetitle != '') {
                        $getProductSiteAdver['title'] = getLanguageTranslate($OverRideBannerLanguage, $language, $ORB['id'], 'banner_title', 'over_ride_banner_id');
                        $getProductSiteAdver['description'] = getLanguageTranslate($OverRideBannerLanguage, $language, $ORB['id'], 'description', 'over_ride_banner_id');
                        $file = '';
                        if ($ORB['banner_image'] != '') {
                            $file = asset('uploads/our_team/' . $ORB['banner_image']);
                        }
                        $getProductSiteAdver['file'] = $file;
                        $getProductSiteAdver['link'] = $ORB['link'];
                        $OverRideBannerArr[] = $getProductSiteAdver;
                    }
                }

                if (count($OverRideBanner) > 0) {
                    $ProductSiteAdvertisementArr = $OverRideBannerArr;
                }
                $productDeatils['site_advertisement'] = $ProductSiteAdvertisementArr;

                $ProductOptions = ProductOptions::where(['product_id' => $product_id, 'is_private_tour' => 0])->get();
                $ProductOptionLanguage = ProductOptionLanguage::where(['product_id' => $product_id])->get();
                $ProductOptionArr = [];

                foreach ($ProductOptions as $POkey => $PO) {
                    $getProductOption                    = [];
                    $ProductTourPriceDetails             = ProductTourPriceDetails::where(['product_id' => $product_id, 'product_option_id' => $PO['id']])->first();
                    $ProductOptionWeekTour               = ProductOptionWeekTour::where(['product_id' => $product_id, 'product_option_id' => $PO['id'], 'week_day' => $WeekDay])->first();
                    $ProductOptionTaxServiceCharge       = ProductOptionTaxServiceCharge::where(['product_id' => $product_id, 'product_option_id' => $PO['id']])->first();
                    $getProductOption['adult_price']     = 'N/A';
                    $getProductOption['child_price']     = 'N/A';
                    $getProductOption['infant_price']    = 'N/A';
                    $getProductOption['is_week_days_id'] = 0;
                    $adult_price                         = $ProductTourPriceDetails            != '' ? get_partners_dis_price(ConvertCurrency($ProductTourPriceDetails->adult_price), $product_id, $request->user_id, 'food_beverage', 'yacht') : 0;
                    $infant_price                        = $ProductTourPriceDetails            != '' ? get_partners_dis_price(ConvertCurrency($ProductTourPriceDetails->infant_price), $product_id, $request->user_id, 'food_beverage', 'yacht') : 0;
                    $child_price                         = $ProductTourPriceDetails            != '' ? get_partners_dis_price(ConvertCurrency($ProductTourPriceDetails->child_price), $product_id, $request->user_id, 'food_beverage', 'yacht') : 0;
                    $infant_allowed                      = $ProductTourPriceDetails            != '' ? $ProductTourPriceDetails->infant_allowed : 0;
                    $child_allowed                       = $ProductTourPriceDetails            != '' ? $ProductTourPriceDetails->child_allowed : 0;
                    $minimum_food                        = $ProductTourPriceDetails            != '' ? $ProductTourPriceDetails->minimum_food : 0;
                    $maximum_people                      = $getProductOption['maximum_people']  = $PO['maximum_people'];
                    $minimum_people                      = $getProductOption['minimum_people']  = $PO['minimum_people'];
                    if ($ProductOptionWeekTour != '') {
                        $adult_price                         = get_partners_dis_price(ConvertCurrency($ProductOptionWeekTour->adult), $product_id, $request->user_id, 'food_beverage', 'yacht');
                        $child_price                         = get_partners_dis_price(ConvertCurrency($ProductOptionWeekTour->child_price), $product_id, $request->user_id, 'food_beverage', 'yacht');
                        $infant_price                        =  get_partners_dis_price(ConvertCurrency($ProductOptionWeekTour->infant_price), $product_id, $request->user_id, 'food_beverage', 'yacht');

                        $child_allowed                       = $ProductOptionWeekTour->child_allowed;
                        $infant_allowed                      = $ProductOptionWeekTour->infant_allowed;
                        $getProductOption['is_week_days_id'] = $ProductOptionWeekTour->id;
                    }
                    $getProductOption['is_period_pricing'] = 0;
                    $date = Carbon::now();
                    $ProductOptionPeriodPricing = ProductOptionPeriodPricing::where(['product_id' => $activity_id, 'product_option_id' => $PO['id']])
                        ->whereDate('from_date', '<=', date('Y-m-d'))
                        ->whereDate('to_date', '>=', date('Y-m-d'))
                        ->first();
                    if ($ProductOptionPeriodPricing != '') {
                        $adult_price                           = ConvertCurrency($ProductOptionPeriodPricing->adult_price);
                        $child_price                           = ConvertCurrency($ProductOptionPeriodPricing->child_price);
                        $infant_price                          = ConvertCurrency($ProductOptionPeriodPricing->infant_price);

                        $child_allowed                         = $ProductOptionPeriodPricing->child_allowed;
                        $infant_allowed                        = $ProductOptionPeriodPricing->infant_allowed;
                        $minimum_food                          = $ProductOptionPeriodPricing->minimum_food;
                        $getProductOption['is_period_pricing'] = $ProductOptionPeriodPricing->id;
                        $getProductOption['is_week_days_id']   = 0;
                    }
                    $getProductOption['infant_allowed'] = $infant_allowed;
                    $getProductOption['child_allowed']  = $child_allowed;
                    $getProductOption['adult_price']    = $adult_price;
                    $getProductOption['minimum_food']    = $minimum_food;
                    if ($child_allowed == 1) {
                        $getProductOption['child_price'] = $child_price;
                    }
                    if ($infant_allowed == 1) {
                        $getProductOption['infant_price'] = $infant_price;
                    }
                    $getProductOption['optionID']       = $PO['id'];
                    $getProductOption['available_type'] = $available_type = $PO['available_type'];
                    $DAArr = [];
                    if ($available_type == 'days_available') {
                        $days_available = json_decode($PO['days_available']);
                        foreach ($days_available as $DAKey => $DA) {
                            $Timing = Timing::where('day', $DAKey)->first();
                            if ($Timing) {
                                $DAArr[] = $Timing->value;
                            }
                        }
                    } elseif ($available_type == 'date_available') {
                        $date_available = json_decode($PO['date_available']);
                        foreach ($date_available as $DAKey => $DA) {
                            if ($from_date != '' && $to_date != '') {
                                if ($DAKey <= $from_date || $DAKey >= $to_date) {
                                    $date = $DAKey;
                                }
                            } else {
                                $date = $DAKey;
                            }
                            if ($Product->blackout_date != '') {
                                $P = json_decode($Product->blackout_date, true);
                                $BLA = [];
                                foreach ($P as $D) {
                                    $BLA[] = trim($D);
                                }
                                if (!in_array($DAKey, $BLA)) {
                                    $date = $DAKey;
                                }
                            } else {
                                $date = $DAKey;
                            }
                            $DAArr[] = $date;
                        }
                    }
                    $getProductOption['available_days'] = $DAArr;
                    getLanguageTranslate($ProductOptionLanguage, $language, $PO['id'], 'title', 'option_id');
                    $getProductOption['title']      = $title = getLanguageTranslate($ProductOptionLanguage, $language, $PO['id'], 'title', 'option_id');
                    $getProductOption['description'] = getLanguageTranslate($ProductOptionLanguage, $language, $PO['id'], 'description', 'option_id');
                    ///////////////////////////////////
                    $getProductOption['tax_allowed']            = $ProductOptionTaxServiceCharge != '' ? $ProductOptionTaxServiceCharge->tax_allowed : 0;
                    $getProductOption['service_charge_allowed'] = $ProductOptionTaxServiceCharge != '' ? $ProductOptionTaxServiceCharge->service_charge_allowed : 0;
                    $getProductOption['tax_percentage']         = $ProductOptionTaxServiceCharge != '' ? $ProductOptionTaxServiceCharge->tax_percentage : 0;
                    $getProductOption['service_charge_amount']  = $ProductOptionTaxServiceCharge != '' ? ConvertCurrency($ProductOptionTaxServiceCharge->service_charge_amount) : 0;
                    $getProductOption['adult_qty']              = 0;
                    $getProductOption['child_qty']              = 0;
                    $getProductOption['infant_qty']             = 0;
                    $getProductOption['total_amount']           = 0;
                    $getProductOption['service_charge']         = 0;
                    $getProductOption['upgrade_amount']         = 0;
                    $getProductOption['tax_amount']             = 0;
                    $getProductOption['service_charge']         = 0;
                    $getProductOption['tax_percentage']         = 0;
                    $getProductOption['is_reset']               = 0;
                    // Tour Upgrade
                    $ProductOptionTourUpgrade = ProductOptionTourUpgrade::where(['product_option_id' => $PO['id'], 'product_id' => $activity_id])->get();
                    if (count($ProductOptionTourUpgrade) > 0) {
                        foreach ($ProductOptionTourUpgrade as $key => $POTU) {
                            $getProductTourTourArr                   = [];
                            $getProductTourTourArr['id']             = $POTU['id'];
                            $getProductTourTourArr['title']          = $POTU['title'];
                            $getProductTourTourArr['adult_price']    = ConvertCurrency($POTU['adult_price']);
                            $getProductTourTourArr['child_price']    = ConvertCurrency($POTU['child_price']);
                            $getProductTourTourArr['infant_price']   = ConvertCurrency($POTU['infant_price']);
                            $getProductTourTourArr['child_allowed']  = $POTU['child_allowed'];
                            $getProductTourTourArr['infant_allowed'] = $POTU['infant_allowed'];
                            $getProductTourTourArr['infant_allowed'] = $POTU['infant_allowed'];
                            $getProductOption['tourUpgrade'][]       = $getProductTourTourArr;
                        }
                    } else {
                        $getProductOption['tourUpgrade'] = [];
                    }
                    if ($title != "") {
                        $ProductOptionArr[] = $getProductOption;
                    }
                }



                $productDeatils['water_sports'] = $ProductOptionArr;
                // // Product Frequently Asked Question
                $ProductFAQArr = [];
                $ProductFaqs = ProductFaqs::where(['product_id' => $product_id])->get();
                $ProductFaqLanguage = ProductFaqLanguage::where(['product_id' => $product_id])->get();
                foreach ($ProductFaqs as $PFkey => $PF) {
                    $getProductFAQ = [];
                    $faqtitle      = getLanguageTranslate($ProductFaqLanguage, $language, $PF['id'], 'question', 'faq_id');
                    if ($faqtitle != '') {
                        $getProductFAQ['question'] = getLanguageTranslate($ProductFaqLanguage, $language, $PF['id'], 'question', 'faq_id');
                        $getProductFAQ['answer']   = getLanguageTranslate($ProductFaqLanguage, $language, $PF['id'], 'answer', 'faq_id');
                        $ProductFAQArr[]           = $getProductFAQ;
                    }
                }
                $productDeatils['faq'] = $ProductFAQArr;

                // // Product Tool Tip
                $get_tool_tip = [];
                $get_product_tool_tip = ProductToolTipLanguage::where('product_id', $product_id)
                    ->where('language_id', $language)
                    ->where("type", "yacht")
                    ->get();
                foreach ($get_product_tool_tip as $tool_tip_key => $tool_tip_value) {
                    $get_tool_tip[$tool_tip_value['tooltip_title']] = $tool_tip_value['tooltip_description'];
                }
                $productDeatils['product_tool_tip'] = $get_tool_tip;

                $TransportationVehicleArr = [];
                // Require Trnsportation
                if ($Product->transportation_vehicle != '') {
                    $vehicles = explode(',', $Product->transportation_vehicle);
                    foreach ($vehicles as $vkey => $V) {
                        $get_vehicle_arr = [];
                        $TransportationVehiclelanguage = TransportationVehicleLanguage::where(['transportation_vehicle_id' => $V])->get();
                        $TransportationVehicle = TransportationVehicle::where(['id' => $V, 'status' => 'Active'])->first();

                        $TransportationVehicleLanguage = getLanguageTranslate($TransportationVehiclelanguage, $language, $V, 'title', 'transportation_vehicle_id');

                        if ($TransportationVehicle) {
                            $get_vehicle_arr['id'] = $V;
                            $get_vehicle_arr['title'] = $TransportationVehicleLanguage;
                            $get_vehicle_arr['price'] = ConvertCurrency($TransportationVehicle->price);
                            $get_vehicle_arr['quantity'] = $TransportationVehicle->quantity;
                            $get_vehicle_arr['one_way'] = 0;
                            $get_vehicle_arr['two_way'] = 0;
                            $get_vehicle_arr['oneway_price'] = ConvertCurrency($TransportationVehicle->one_way_price);
                            $get_vehicle_arr['twoway_price'] = ConvertCurrency($TransportationVehicle->two_way_price);
                            $get_vehicle_arr['select_qty'] = 0;
                            $get_vehicle_arr['total_amount'] = 0;
                            $get_vehicle_arr['tax_amount'] = 0;
                            $get_vehicle_arr['service_charge'] = 0;
                            $get_vehicle_arr['tax_percentage'] = 0;
                            if ($TransportationVehicleLanguage != "") {
                                $TransportationVehicleArr[] = $get_vehicle_arr;
                            }
                        }
                    }
                }
                $productDeatils['transportation_vehicle'] = $TransportationVehicleArr;

                //Feature Highlights
                $get_feature_highlights = [];
                $get_feature_highlights['heading_title'] = '';
                $get_feature_highlights['feature_highlights'] = [];
                $features_highlights = MetaGlobalLanguage::where('product_id', $product_id)
                    ->where('meta_title', 'feature_highlight')
                    ->where('language_id', $language)
                    ->where('status', 'Active')
                    ->first();
                if ($features_highlights) {
                    $get_feature_highlights['heading_title'] = $features_highlights['title'] != '' ? $features_highlights['title'] : '';
                    $get_yacht_feature_highlight = YachtFeatureHighlight::where('product_id', $product_id)->get();
                    foreach ($get_yacht_feature_highlight as $feature_key => $feature_value) {
                        # code...
                        $get_highlights = [];
                        $get_feature_language = YachtFeatureHighlightLanguage::where('feature_highlight_id', $feature_value['id'])
                            ->where('language_id', $language)
                            ->where('product_id', $product_id)
                            ->first();
                        if ($get_feature_language) {
                            $get_highlights['title'] = $get_feature_language['title'];
                        }
                        $get_feature_highlights['feature_highlights'][] = $get_highlights;
                    }
                }
                $productDeatils['feature_highlights'] = $get_feature_highlights;

                //Boat Specification
                $get_boat_specification = [];
                $get_boat_specification['heading_title'] = '';
                $get_boat_specification['heading_content'] = '';
                $get_boat_specification['boat_specification'] = [];
                $get_boat_specification_highlights = MetaGlobalLanguage::where('product_id', $product_id)
                    ->where('meta_title', 'boat_specification')
                    ->where('language_id', $language)
                    ->where('status', 'Active')
                    ->first();
                if ($get_boat_specification_highlights) {
                    $get_boat_specification['heading_title'] = $get_boat_specification_highlights['title'] != '' ? $get_boat_specification_highlights['title'] : '';
                    $get_boat_specification['heading_content'] = $get_boat_specification_highlights['content'] != '' ? $get_boat_specification_highlights['content'] : '';

                    $_get_boat_specification = YachtBoatSpecification::where('product_id', $product_id)->get();
                    foreach ($_get_boat_specification as $boat_spec_key => $boat_spec_value) {
                        # code...
                        $get_boat_spec_arr = [];
                        $get_boat_spec_language = YachtBoatSpecificationLanguage::where('boat_specification_id', $boat_spec_value['id'])
                            ->where('language_id', $language)
                            ->where('product_id', $product_id)
                            ->first();
                        if ($get_boat_spec_language) {
                            $get_boat_spec_arr['title'] = $get_boat_spec_language['title'] != '' ? $get_boat_spec_language['title'] : '';
                            $get_boat_spec_arr['content'] = $get_boat_spec_language['content'] != '' ? $get_boat_spec_language['content'] : '';
                        }
                        $get_boat_specification['boat_specification'][] = $get_boat_spec_arr;
                    }
                }
                $productDeatils['boat_specification'] = $get_boat_specification;

                //Amenities
                $get_amenities = [];
                $get_amenities['heading_title'] = '';
                $get_amenities['amenties'] = [];
                $get_amentiens_highlights = MetaGlobalLanguage::where('product_id', $product_id)
                    ->where('meta_title', 'amenities')
                    ->where('language_id', $language)
                    ->where('status', 'Active')
                    ->first();
                if ($get_amentiens_highlights) {
                    $get_amenities['heading_title'] = $get_amentiens_highlights['title'] != '' ? $get_amentiens_highlights['title'] : '';

                    $get_yacht_amenties = YachtAmenities::where('product_id', $product_id)->get();
                    foreach ($get_yacht_amenties as $amenties_key => $amenties_value) {
                        # code...
                        $get_amenties_arr = [];
                        $get_amenties_arr['type'] = $amenties_value['type'];
                        $get_amenties_language = YachtAmenitiesLanguage::where('amenities_id', $amenties_value['id'])
                            ->where('language_id', $language)
                            ->where('product_id', $product_id)
                            ->first();
                        if ($get_amenties_language) {
                            $get_amenties_arr['title'] = $get_amenties_language['title'];
                            $get_amenties_arr['description'] = $get_amenties_language['description'];
                            $get_amenties_arr['points'] = [];
                            $get_yacht_amenities_point = YachtAmenitiesPoints::where('product_id', $amenties_value['product_id'])
                                ->where('amenti_id', $amenties_value['id'])
                                ->get();
                            if (!$get_yacht_amenities_point->isEmpty()) {
                                foreach ($get_yacht_amenities_point as $gyap_key => $gyap_value) {
                                    # code...
                                    $YachtAmenitiesPointsLanguage = YachtAmenitiesPointsLanguage::where('product_id', $gyap_value['product_id'])
                                        ->where('amenities_id', $gyap_value['amenti_id'])
                                        ->where('point_amenities_id', $gyap_value['id'])
                                        ->where('language_id', $language)
                                        ->get();
                                    foreach ($YachtAmenitiesPointsLanguage as $YAPL_key => $YAPL_value) {
                                        # code...
                                        $get_point_arr = [];
                                        $get_point_arr['title'] = $YAPL_value['title'];
                                        $get_amenties_arr['points'][] = $get_point_arr;
                                    }
                                }
                            }
                        }
                        $get_amenities['amenties'][] = $get_amenties_arr;
                    }
                }
                $productDeatils['amenties'] = $get_amenities;

                // Extra Transfer Option
                $ProductyachttransferoptionArr      = [];
                $Productyachttransferoption         = Productyachttransferoption::where(['product_id' => $product_id])->get();
                $ProductyachttransferoptionLanguage = Productyachttransferoptionlanguage::where(['product_id' => $product_id])->get();
                foreach ($Productyachttransferoption as $key => $pyto) {
                    $gettransferOption                   = [];
                    $title                               = getLanguageTranslate($ProductyachttransferoptionLanguage, $language, $pyto['id'], 'title', 'product_yacht_transfer_option_id');
                    $gettransferOption['id']             = $pyto['id'];
                    $gettransferOption['title']          = $title;
                    $gettransferOption['price']          = get_partners_dis_price(ConvertCurrency($pyto->price), $product_id, $request->user_id, 'transfer_option', 'yacht');
                    $gettransferOption['quantity']       = $pyto->quantity;
                    $gettransferOption['select_qty']     = 0;
                    $gettransferOption['total_amount']   = 0;
                    $gettransferOption['tax_amount']     = 0;
                    $gettransferOption['service_charge'] = 0;
                    $gettransferOption['tax_percentage'] = 0;
                    if ($title !=  "") {
                        $ProductyachttransferoptionArr[] = $gettransferOption;
                    }
                }
                $productDeatils['transfer_option'] = $ProductyachttransferoptionArr;



                // Food & Beverage
                $ProductfoodbeverrageArr      = [];
                $Productfoodbeverrage         = Productyachtwatersport::where(['product_id' => $product_id])->get();
                $ProductfoodbeverrageLanguage = Productyachtwatersportlanguage::where(['product_id' => $product_id])->get();
                foreach ($Productfoodbeverrage as $key => $pyfb) {
                    $getfoodbeverage                   = [];
                    $title                             = getLanguageTranslate($ProductfoodbeverrageLanguage, $language, $pyfb['id'], 'title', 'product_yacht_water_sport_id');
                    $getfoodbeverage['id']             = $pyfb['id'];
                    $getfoodbeverage['title']          = $title;
                    $getfoodbeverage['price']          = get_partners_dis_price(ConvertCurrency($pyfb->price), $product_id, $request->user_id, 'water_sports', 'yacht');
                    $getfoodbeverage['quantity']       = $pyfb->quantity != "" ? $pyfb->quantity : 0;
                    $getfoodbeverage['select_qty']     = 0;
                    $getfoodbeverage['total_amount']   = 0;
                    $getfoodbeverage['tax_amount']     = 0;
                    $getfoodbeverage['service_charge'] = 0;
                    $getfoodbeverage['tax_percentage'] = 0;
                    if ($title != "") {
                        $ProductfoodbeverrageArr[] = $getfoodbeverage;
                    }
                }
                $productDeatils['food_beverage'] = $ProductfoodbeverrageArr;



                $minimum_booking = $Product->minimum_booking > 0 ? $Product->minimum_booking : 1;

                $ProductOptionWeekTour = ProductOptionWeekTour::where(['product_id' => $Product->id, 'for_general' => 1, 'week_day' => $WeekDay])->first();
                if ($ProductOptionWeekTour) {
                    $getamount = ConvertCurrency($ProductOptionWeekTour->adult);
                    $productDeatils['selling_price'] = $getamount  =   get_partners_dis_price($getamount, $product_id, $request->user_id, 'weekdays', 'yacht');
                    $productDeatils['original_price'] =   0;
                } else {
                    $productDeatils['selling_price'] =  $getamount = $Product->selling_price !== '' ? get_partners_dis_price(ConvertCurrency($Product->selling_price), $product_id, $request->user_id, 'base_price', 'yacht') : get_partners_dis_price(ConvertCurrency($Product->original_price), $product_id, $request->user_id, 'base_price', 'yacht');
                }
                $amount = $getamount * $minimum_booking;

                $tax_amount = 0;
                $service_charge = 0;
                if ($Product->tax_allowed == 1) {
                    if ($Product->tax_percentage > 0) {
                        $tax_amount = ($amount / 100) * $Product->tax_percentage;
                    }
                }

                if ($Product->service_allowed == 1) {
                    if ($Product->service_amount > 0) {
                        $service_charge = ConvertCurrency($Product->service_amount);
                    }
                }


                $totalAmount = 0;

                $productDeatils['total_amount'] = $totalAmount;

                // Releated Product 
                $Productyachtrelatedboats = Productyachtrelatedboats::where(['product_id' => $product_id, 'type' => "Yatch"])->get();
                $ProductArr = [];
                foreach ($Productyachtrelatedboats as $key => $PData) {
                    $P = Product::find($PData['boat_id']);
                    $productLang = ProductLanguage::where(['product_id' => $PData['boat_id'], 'language_id' => $language])->first();
                    $title = '';
                    $main_description = '';
                    $getProductArr = [];
                    $short_description = '';
                    if ($P) {
                        if ($productLang) {
                            $title = $productLang->description;
                            $main_description = $productLang->main_description;
                            $short_description = $productLang->short_description;
                        }

                        $approx = '';
                        if ($P['approx'] == 1) {
                            $approx = '(Approx)';
                        }

                        $duration = explode('-', $P['duration']);
                        $dura = '';
                        foreach ($duration as $k => $D) {
                            if ($k == 0) {
                                $val = 'D ';
                            } elseif ($k == 1) {
                                $val = 'H ';
                            } else {
                                $val = 'M ';
                            }
                            if ($D > 0) {
                                $dura .= $D . $val;
                            }
                        }
                        $duration = $dura . $approx;

                        $city = getAllInfo('cities', ['id' => $P['city']], 'name');


                        $getProductArr['id'] = $P['id'];
                        $getProductArr['image'] = $P['image'] != '' ? asset('public/uploads/product_images/' . $P['image']) : asset('public/assets/img/no_image.jpeg');
                        $getProductArr['name']              = short_description_limit($title, 50);
                        $getProductArr['full_name']          = $title;
                        $getProductArr['short_description'] = short_description_limit($short_description, 50);

                        // $getProductArr['name'] = $title;
                        $getProductArr['main_description'] = Str::limit($main_description, 60);
                        $getProductArr['duration'] = $duration;
                        $getProductArr['city'] = $city;
                        $getProductArr['slug'] = $P['slug'];
                        $getProductArr['boat_maximum_capacity'] = $P['boat_maximum_capacity'];
                        $getProductArr['minimum_booking'] = $P['minimum_booking'];
                        $getProductArr['total_sold'] = $P['how_many_are_sold'] !== '' ? $P['how_many_are_sold'] : 0;
                        $getProductArr['per_value'] = $P['per_value'];
                        $getProductArr['image_text'] = $P['image_text'] ?? null;
                        $getProductArr['price'] =  ConvertCurrency($P['original_price']) ?? 0;
                        $getProductArr['selling_price'] = ConvertCurrency($P['selling_price']) ?? 0;
                        $getProductArr['button']        = $P['product_bookable_type'] === 'bookable' ? 'Book Now' : 'On Request';
                        $getProductArr['ratings']       = get_rating($P['id']);
                        $getProductArr['price_html']        = get_price_front($P['id'], $request->user_id, $P['product_type']);

                        $ProductArr[] = $getProductArr;
                    }
                }
                $productDeatils['releated'] = $ProductArr;



                ///Review For This Product
                $productDeatils['reviews'] = [];
                $get_review                = UserReview::where('product_id', $product_id)->orderBy('id', 'desc')->get();
                if (!$get_review->isEmpty()) {
                    foreach ($get_review as $review_key => $review_value) {
                        # code...
                        $get_review_arr                = [];
                        $get_review_arr['title']       = $review_value['title'];
                        $get_review_arr['description'] = $review_value['description'];
                        $get_review_arr['rating']      = $review_value['rating'];
                        $get_review_arr['date']        = date('M d', strtotime($review_value['created_at']));
                        $get_review_arr['user_name']   = "";
                        $get_review_arr['user_image']  = asset('public/uploads/img_avatar.png');
                        $get_user                      = User::where('id', $review_value['user_id'])->first();
                        if ($get_user) {
                            $get_review_arr['user_name']  = $get_user['name'];
                            $get_review_arr['user_image'] = $get_user['image'] != '' ? url('uploads/user_image/', $get_user['image']) : asset('public/uploads/img_avatar.png');
                        }
                        $productDeatils['reviews'][] = $get_review_arr;
                    }
                }


                // Product Experience ICon
                $productDeatils['experience_heading'] = '';
                $heading_title                        = MetaGlobalLanguage::where('product_id', $product_id)->where('meta_parent', 'middle_experience_heading')
                    ->where('meta_title', 'heading_title')
                    ->where('language_id', $language)
                    ->where('product_id', $product_id)
                    ->first();
                if ($heading_title) {
                    $productDeatils['experience_heading'] = $heading_title['title'];
                }

                $productDeatils['opening_heading'] = '';
                $heading_title                        = MetaGlobalLanguage::where('product_id', $product_id)->where('meta_parent', 'yatch_opening_heading')
                    ->where('meta_title', 'heading_title')
                    ->where('language_id', $language)
                    ->first();
                if ($heading_title) {
                    $productDeatils['opening_heading'] = $heading_title['title'];
                }

                $productDeatils['additional_heading'] = '';
                $heading_title                        = MetaGlobalLanguage::where('product_id', $product_id)->where('meta_parent', 'yatch_additional_heading')
                    ->where('meta_title', 'heading_title')
                    ->where('language_id', $language)
                    ->first();
                if ($heading_title) {
                    $productDeatils['additional_heading'] = $heading_title['title'];
                }


                $productDeatils['faq_heading'] = '';
                $heading_title                        = MetaGlobalLanguage::where('product_id', $product_id)->where('meta_parent', 'yatch_faq_heading')
                    ->where('meta_title', 'heading_title')
                    ->where('language_id', $language)
                    ->where('product_id', $product_id)
                    ->first();
                if ($heading_title) {
                    $productDeatils['faq_heading'] = $heading_title['title'];
                }

                // Product Experience ICon
                $productDeatils['experience_icon'] = [];
                $ProductExprienceIcon              = ProductExprienceIcon::where(['product_id' => $product_id, 'type' => 'yacht'])->where('position_type', 'middel')->get();



                $ProductExprienceIconLanguage      = ProductExprienceIconLanguage::where(['product_id' => $product_id, 'type' => 'yacht'])->where('position_type', 'middel')->get();
                $ProductExperienceArr              = [];
                foreach ($ProductExprienceIcon as $PAIkey => $PEI) {
                    $getProductExperience = [];
                    $addtitle = getLanguageTranslate($ProductExprienceIconLanguage, $language, $PEI['id'], 'title', 'experience_icon_id');
                    if ($addtitle != '') {
                        $getProductExperience['title'] = $addtitle;
                        $file                          = '';
                        if ($PEI['image'] != '') {
                            $file = asset('uploads/expericence_icons/' . $PEI['image']);
                        }
                        $getProductExperience['file']        = $file;
                        $productDeatils['experience_icon'][] = $getProductExperience;
                    }
                }
                $productDeatils['header_experience_heading']     = '';
                $experience_heading = MetaGlobalLanguage::where('product_id', $product_id)->where('meta_parent', 'header_experience_heading')
                    ->where('meta_title', 'heading_title')
                    ->where('language_id', $language)
                    ->where('product_id', $product_id)
                    ->first();
                if ($experience_heading) {
                    $productDeatils['header_experience_heading'] = $experience_heading['title'];
                }
                // Product Experience ICon
                $productDeatils['header_experience_icon'] = [];
                $ProductExprienceIconHeader              = ProductExprienceIcon::where(['product_id' => $product_id, 'type' => 'yacht'])->where('position_type', 'upper')->get();
                $ProductExprienceIconLanguageHeader      = ProductExprienceIconLanguage::where(['product_id' => $product_id])->where('position_type', 'upper')->get();
                $ProductExperienceArr              = [];
                foreach ($ProductExprienceIconHeader as $PAIkey => $PEIH) {
                    $productDeatils['$product_id'] = $PEIH;
                    $getProductExperience = [];
                    $addtitle             = getLanguageTranslate($ProductExprienceIconLanguageHeader, $language, $PEIH['id'], 'title', 'experience_icon_id');
                    $information          = getLanguageTranslate($ProductExprienceIconLanguageHeader, $language, $PEIH['id'], 'information', 'experience_icon_id');
                    if ($addtitle != '') {
                        $getProductExperience['title']       = $addtitle;
                        $getProductExperience['information'] = $information;
                        $file                          = '';
                        if ($PEIH['image'] != '') {
                            $file = asset('uploads/header_expericence_icons/' . $PEIH['image']);
                        }
                        $getProductExperience['file']               = $file;
                        $productDeatils['header_experience_icon'][] = $getProductExperience;
                    }
                }




                // Product Popup
                $productDeatils['product_popup']                 = [];
                $productDeatils['product_popup']['title']        = '';
                $productDeatils['product_popup']['description']  = '';
                $productDeatils['product_popup']['popup_status'] = $Product->popup_status == 'Active' ? true : false;
                if ($Product->popup_status == 'Active') {
                    $productLang      = ProductLanguage::where(['product_id' => $Product['id'], 'language_id' => $language])->first();
                    if ($productLang->pro_popup_title) {
                        $productDeatils['product_popup']['title']       = $productLang->pro_popup_title;
                        $productDeatils['product_popup']['description'] = $productLang->pro_popup_desc;
                    }
                    $productDeatils['product_popup']['link']        = $Product->pro_popup_link;
                    $productDeatils['product_popup']['redirect_link'] = $Product->redirection_link;
                    
                    $productDeatils['product_popup']['product_image']       = $Product->image != '' ? url('uploads/product_images', $Product->image) : asset('uploads/placeholder/placeholder.png');
                    $productDeatils['product_popup']['image']       = $Product->pro_popup_image != '' ? url('uploads/product_images', $Product->pro_popup_image) : '';
                    $productDeatils['product_popup']['video']        = $Product->pro_popup_video != '' ? url('uploads/product_images/popup_image', $Product->pro_popup_video) : '';
                    $productDeatils['product_popup']['thumnail']     = $Product->pro_popup_thumnail_image != '' ? url('uploads/product_images/popup_image', $Product->pro_popup_thumnail_image) : ($Product->image != '' ? url('uploads/product_images/', $Product->image) : asset('uploads/placeholder/placeholder.png'));
                }


                $output['data'] = $productDeatils;
                $output['status'] = true;
                $output['message'] = 'Data Fetched Successfully...';
            }
        }

        return json_encode($output);
    }

    // Yacht Total
    public function get_yacht_total(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            'product_id' => 'required',
            'option_id' => 'required',
            'language' => 'required',
            'details' => 'required',
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

        $product_id = $request->product_id;
        $option_id = $request->option_id;
        $Product = Product::where('slug', $product_id)->first();
        $product_id = $Product->id;
        $language = $request->language;

        $total = 0;
        $PriceArr = [];
        if ($Product) {
            if ($request->details != '') {
                $Details      = $request->details;
                $adult_price  = 0;
                $child_price  = 0;
                $infant_price = 0;
                // Water Sports
                if (isset($request->water_sports)) {
                    $ProductOptionTaxServiceCharge = ProductOptionTaxServiceCharge::where(['product_id' => $product_id, 'product_option_id' => $option_id])->first();

                    $adultQty = $Details['adult_qty'];
                    $childQty = $Details['child_qty'];

                    $get_option_tour_detail = ProductTourPriceDetails::where('product_option_id', $option_id)
                        ->where('product_id', $product_id)
                        ->first();
                    if ($get_option_tour_detail) {
                        $adult_price = get_partners_dis_price(ConvertCurrency($get_option_tour_detail['adult_price']), $product_id, $request->user_id, 'food_beverage', 'yacht');
                        $child_price = get_partners_dis_price(ConvertCurrency($get_option_tour_detail['child_price']), $product_id, $request->user_id, 'food_beverage', 'yacht');
                        $infant_price = get_partners_dis_price(ConvertCurrency($get_option_tour_detail['infant_price']), $product_id, $request->user_id, 'food_beverage', 'yacht');
                        // is_week_days_id
                    }

                    $is_week_days_id = $Details['is_week_days_id'];
                    if ($is_week_days_id > 0) {
                        $get_week_tour = ProductOptionWeekTour::where(['id' => $is_week_days_id])->first();
                        if ($get_week_tour) {
                            $adult_price = get_partners_dis_price(ConvertCurrency($get_week_tour['adult']), $product_id, $request->user_id, 'food_beverage', 'yacht');
                            $child_price = get_partners_dis_price(ConvertCurrency($get_week_tour['child_price']), $product_id, $request->user_id, 'food_beverage', 'yacht');
                            $infant_price = get_partners_dis_price(ConvertCurrency($get_week_tour['infant_price']), $product_id, $request->user_id, 'food_beverage', 'yacht');
                        }
                    }

                    $is_period_pricing = $Details['is_period_pricing'];

                    if ($is_period_pricing > 0) {
                        $get_period_pricing = ProductOptionPeriodPricing::where(['id' => $is_period_pricing])->first();
                        if ($get_period_pricing) {
                            $adult_price = ConvertCurrency($get_period_pricing['adult_price']);
                            $child_price = ConvertCurrency($get_period_pricing['child_price']);
                            $infant_price = ConvertCurrency($get_period_pricing['infant_price']);
                        }
                    }

                    $total_adult_price = $adult_price * $adultQty;
                    $total_child_price = $child_price * $childQty;
                    $total = $total_child_price + $total_adult_price;
                }

                // Transportation Vehicle
                if (isset($request->transportation)) {
                    $TransportationVehicle = TransportationVehicle::find($option_id);

                    $total = 0;
                    if ($TransportationVehicle) {
                        if ($request->type != "") {
                            if ($request->type == 'one_way') {
                                $price = get_partners_dis_price(ConvertCurrency($TransportationVehicle->one_way_price), $product_id, $request->user_id, 'transportation', 'yacht');
                            } else {
                                $price = get_partners_dis_price(ConvertCurrency($TransportationVehicle->two_way_price), $product_id, $request->user_id, 'transportation', 'yacht');
                            }
                        } else {
                            $price = 0;
                        }
                        $total = $price * $Details['qty'];
                    }
                }

                // Tranferoption
                if (isset($request->transferoption)) {
                    $Productyachttransferoption = Productyachttransferoption::find($option_id);
                    $total = 0;
                    if ($Productyachttransferoption) {
                        $total = get_partners_dis_price(ConvertCurrency($Productyachttransferoption->price), $product_id, $request->user_id, 'transfer_option', 'yacht') * $Details['qty'];
                    }
                }

                // Tranferoption
                if (isset($request->foodbeverage)) {
                    $Productyachttransferoption = Productyachtwatersport::find($option_id);
                    $total = 0;
                    if ($Productyachttransferoption) {
                        $total = get_partners_dis_price(ConvertCurrency($Productyachttransferoption->price), $product_id, $request->user_id, 'water_sports', 'yacht') * $Details['qty'];
                    }
                }

                $PriceArr['total'] = $total;
                $output['data'] = $PriceArr;
                $output['status'] = true;
                $output['message'] = 'Data Fetched Successfully...';
            }
        }

        return json_encode($output);
    }

    // Yacht Total Amount Calculation
    public function get_yacht_total_amount_calculation(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            'product_id' => 'required',
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

        $product_id      = $request->product_id;
        $option_id       = $request->option_id;
        $Product         = Product::where('slug', $product_id)->first();
        $product_id      = $Product->id;
        $language        = $request->language;
        $totalAmount     = 0;
        $water_sports    = $request->water_sports;
        $transportaion   = $request->transportaion;
        $transfer_option = $request->transfer_option;
        $food_beverage   = $request->food_beverage;
        $Hourprice       = $Product->selling_price !== '' ? get_partners_dis_price(ConvertCurrency($Product->selling_price), $product_id, $request->user_id, 'base_price', 'yacht') : get_partners_dis_price(ConvertCurrency($Product->original_price), $product_id, $request->user_id, 'base_price', 'yacht');


        if (isset($request->date)) {
            $WeekDay = date('l', strtotime($request->date));
            $ProductPrice = ProductOptionWeekTour::where(['product_id' => $product_id, 'week_day' => $WeekDay, 'for_general' => 1])->first();
            if ($ProductPrice) {
                $Hourprice = get_partners_dis_price(ConvertCurrency($ProductPrice->adult), $product_id, $request->user_id, 'weekdays', 'yacht');
            }
        } else {
            $date = date("Y-m-d");
            $WeekDay = date('l', strtotime($date));
            $ProductPrice = ProductOptionWeekTour::where(['product_id' => $product_id, 'week_day' => $WeekDay, 'for_general' => 1])->first();
            if ($ProductPrice) {
                $Hourprice = get_partners_dis_price(ConvertCurrency($ProductPrice->adult), $product_id, $request->user_id, 'weekdays', 'yacht');
            }
        }





        // $ProductPrice = ProductOptionWeekTour::where(['product_id' => $product_id, 'week_day' => $WeekDay, 'for_general' => 1])->first();
        // if ($ProductPrice) {
        //     $hourPrice = $ProductPrice->adult;
        // } else {
        //     $hourPrice = $Product->selling_price !== '' ? $Product->selling_price : $Product->original_price;
        // }

        if ($water_sports != '') {
            foreach ($water_sports as $wkey => $WS) {
                $adult = 0;
                $child = 0;
                $adult_qty = isset($WS['adult_qty'])  ? $WS['adult_qty'] : 0;
                $child_qty = isset($WS['child_qty'])  ? $WS['child_qty'] : 0;
                if ($adult_qty > 0 || $child_qty) {
                    if ($WS['adult_price'] > 0 && $WS['adult_qty']) {
                        $adult = $WS['adult_price'] * $WS['adult_qty'];
                    }
                    if ($WS['child_price'] && $WS['child_qty']) {
                        $child = $WS['child_price'] * $WS['child_qty'];
                    }

                    $totalAmount += $adult + $child;
                }
            }
        }

        if ($transportaion != '') {
            // return $transportaion;

            foreach ($transportaion as $key => $T) {
                if ($T['select_qty'] > 0) {
                    $TransportationVehicle = TransportationVehicle::where(['id' => $T['id']])->first();

                    $price = 0;
                    if ($TransportationVehicle) {

                        if ($T['two_way'] == 1 || $T['one_way'] == 1) {
                            if ($T['two_way'] == 1) {
                                $price =  get_partners_dis_price(ConvertCurrency($TransportationVehicle->two_way_price), $product_id, $request->user_id, 'transportation', 'yacht');
                            } else {
                                $price = get_partners_dis_price(ConvertCurrency($TransportationVehicle->one_way_price), $product_id, $request->user_id, 'transportation', 'yacht');
                            }
                        } else {
                            $price = 0;
                        }
                        $totalAmount += $price * $T['select_qty'];
                    }
                }
            }
        }

        if ($transfer_option != '') {
            foreach ($transfer_option as $taKey => $TA) {
                if ($TA['select_qty'] > 0) {
                    $Productyachttransferoption = Productyachttransferoption::where(['id' => $TA['id']])->first();
                    if ($Productyachttransferoption) {
                        $totalAmount += get_partners_dis_price(ConvertCurrency($Productyachttransferoption->price), $product_id, $request->user_id, 'transfer_option', 'yacht') * $TA['select_qty'];
                    }
                }
            }
        }

        if ($food_beverage != '') {
            foreach ($food_beverage as $fbKey => $FB) {
                if ($FB['select_qty'] > 0) {
                    $Productyachtwatersport = Productyachtwatersport::where(['id' => $FB['id']])->first();
                    if ($Productyachtwatersport) {
                        $totalAmount += get_partners_dis_price(ConvertCurrency($Productyachtwatersport->price), $product_id, $request->user_id, 'water_sports', 'yacht') * $FB['select_qty'];
                    }
                }
            }
        }

        $tax_amount = 0;
        $service_charge = 0;
        $tax_Hourprice = 0;

        $Hourprice =  $Hourprice *  $request->get_hours;
        if ($Product->tax_allowed == 1) {
            if ($Product->tax_percentage > 0) {
                $tax_amount = ($totalAmount / 100) * $Product->tax_percentage;
                $tax_Hourprice = ($Hourprice / 100) * $Product->tax_percentage;
            }
        }
        $Hourprice = $Hourprice + $tax_Hourprice;

        if ($Product->service_allowed == 1) {
            if ($Product->service_amount > 0) {
                $service_charge = ConvertCurrency($Product->service_amount);
            }
        }



        $PriceArr['total_amount'] = $totalAmount  + $service_charge  +  $tax_amount;
        $PriceArr['hour_amount'] = $Hourprice;
        $output['data'] = $PriceArr;
        $output['status'] = true;
        $output['message'] = 'Data Fetched Successfully...';

        return json_encode($output);
    }



    // Yacht Option Price
    public function get_yacht_option_price(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            'product_id' => 'required',
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

        $product_id = $request->product_id;
        $option_id = $request->option_id;
        $Product = Product::where('slug', $product_id)->first();
        $product_id = $Product->id;
        $language = $request->language;
        $date = date('Y-m-d', strtotime($request->date));
        $WeekDay = date('l', strtotime($request->date));

        $ProductOptions = ProductOptions::where(['product_id' => $product_id, 'is_private_tour' => 0])->get();
        $ProductPrice = ProductOptionWeekTour::where(['product_id' => $product_id, 'week_day' => $WeekDay, 'for_general' => 1])->first();
        if ($ProductPrice) {
            $hourPrice = get_partners_dis_price(ConvertCurrency($ProductPrice->adult), $product_id, $request->user_id, 'weekdays', 'yacht');
        } else {
            $hourPrice = $Product->selling_price !== '' ? get_partners_dis_price(ConvertCurrency($Product->selling_price), $product_id, $request->user_id, 'base_price', 'yacht') : get_partners_dis_price(ConvertCurrency($Product->original_price), $product_id, $request->user_id, 'base_price', 'yacht');
        }
        $ProductOptionArr = [];
        $ProductOptionArr['hour_price'] = $hourPrice;
        foreach ($ProductOptions as $POkey => $PO) {
            $get_option_arr = [];
            $ProductTourPriceDetails = ProductTourPriceDetails::where(['product_id' => $product_id, 'product_option_id' => $PO['id']])->first();
            $ProductOptionWeekTour = ProductOptionWeekTour::where(['product_id' => $product_id, 'product_option_id' => $PO['id'], 'week_day' => $WeekDay])->first();
            $adult_price = $ProductTourPriceDetails != '' ? get_partners_dis_price(ConvertCurrency($ProductTourPriceDetails->adult_price), $product_id, $request->user_id, 'food_beverage', 'yacht') : 0;
            $infant_price = $ProductTourPriceDetails != '' ?  get_partners_dis_price(ConvertCurrency($ProductTourPriceDetails->infant_price), $product_id, $request->user_id, 'food_beverage', 'yacht') : 0;
            $child_price = $ProductTourPriceDetails != '' ?  get_partners_dis_price(ConvertCurrency($ProductTourPriceDetails->child_price), $product_id, $request->user_id, 'food_beverage', 'yacht') : 0;
            $infant_allowed = $ProductTourPriceDetails != '' ? $ProductTourPriceDetails->infant_allowed : 0;
            $child_allowed = $ProductTourPriceDetails != '' ? $ProductTourPriceDetails->child_allowed : 0;
            $weekDayID = 0;
            $is_period_pricing = 0;
            if ($ProductOptionWeekTour != '') {
                $adult_price = $ProductOptionWeekTour->adult != '' ? get_partners_dis_price(ConvertCurrency($ProductOptionWeekTour->adult), $product_id, $request->user_id, 'food_beverage', 'yacht') : 0;
                $child_price = $ProductOptionWeekTour->child_price != '' ? get_partners_dis_price(ConvertCurrency($ProductOptionWeekTour->child_price), $product_id, $request->user_id, 'food_beverage', 'yacht') : 0;
                $infant_price = $ProductOptionWeekTour->infant_price != '' ? get_partners_dis_price(ConvertCurrency($ProductOptionWeekTour->infant_price), $product_id, $request->user_id, 'food_beverage', 'yacht') : 0;
                $child_allowed = $ProductOptionWeekTour->child_allowed != '' ? $ProductOptionWeekTour->child_allowed : 0;
                $infant_allowed = $ProductOptionWeekTour->infant_allowed != '' ? $ProductOptionWeekTour->infant_allowed : 0;
                $weekDayID = $ProductOptionWeekTour->id;
            }
            $get_option_arr['adult_price'] = $adult_price;
            $get_option_arr['child_price'] = $child_price;
            $get_option_arr['child_allowed'] = $child_allowed;
            $get_option_arr['is_week_days_id'] = $weekDayID;
            $ProductOptionArr['option'][$PO['id']] = $get_option_arr;
        }

        $output['data'] = $ProductOptionArr;
        $output['status'] = true;
        $output['message'] = 'Data Fetched Successfully...';

        return json_encode($output);
    }

    // Yacht BreadkDown

    public function get_yacht_breakdown(Request $request)
    {

        $output = [];
        $output['status'] = false;
        $output['msg'] = 'Data Not Found';
        $validation = Validator::make($request->all(), [
            'language' => 'required',
            'product_id' => 'required',

            // 'lodge_arrival_date'  => 'required',
            // 'lodge_departure_date'=> 'required',
            // 'room_qty'            => 'required',
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
        $product_slug    = $request->product_id;
        $product_id      = $request->product_id;
        $Product         = Product::where('slug', $product_slug)->first();
        $water_sports    = $request->water_sports;
        $transportaion   = $request->transportaion;
        $transfer_option = $request->transfer_option;
        $food_beverage   = $request->food_beverage;
        $total_amount    = 0;

        if ($Product) {
            $product_id = $Product->id;
            $product_slug = $Product->slug;
            $language = $request->language;
            $Product = Product::where('id', $product_id)
                ->where('product_type', 'yacht')
                ->where('status', 'Active')
                ->first();
            $breakDownArr = [];
            if ($Product) {
                $hourPriceArr = [];
                $price = $Product->selling_price !== '' ? get_partners_dis_price(ConvertCurrency($Product->selling_price), $product_id, $request->user_id, 'base_price', 'yacht') : get_partners_dis_price(ConvertCurrency($Product->original_price), $product_id, $request->user_id, 'base_price', 'yacht');
                if (isset($request->date)) {

                    if ($request->date != "") {
                        $WeekDay = date('l', strtotime($request->date));
                        $ProductPrice = ProductOptionWeekTour::where(['product_id' => $product_id, 'week_day' => $WeekDay, 'for_general' => 1])->first();
                        if ($ProductPrice) {
                            $price = get_partners_dis_price(ConvertCurrency($ProductPrice->adult), $product_id, $request->user_id, 'weekdays', 'yacht');
                        }
                    } else {
                        $date = date("Y-m-d");
                        $WeekDay = date('l', strtotime($date));
                        $ProductPrice = ProductOptionWeekTour::where(['product_id' => $product_id, 'week_day' => $WeekDay, 'for_general' => 1])->first();
                        if ($ProductPrice) {
                            $price = get_partners_dis_price(ConvertCurrency($ProductPrice->adult), $product_id, $request->user_id, 'weekdays', 'yacht');
                        }
                    }
                } else {
                    $date = date("Y-m-d");
                    $WeekDay = date('l', strtotime($date));
                    $ProductPrice = ProductOptionWeekTour::where(['product_id' => $product_id, 'week_day' => $WeekDay, 'for_general' => 1])->first();
                    if ($ProductPrice) {
                        $price = get_partners_dis_price(ConvertCurrency($ProductPrice->adult), $product_id, $request->user_id, 'weekdays', 'yacht');
                    }
                }
                $hourPriceArr['price'] = $price;

                if (isset($request->start_time)) {
                    $startTime = $request->start_time;
                } else {
                    $startTime = date("H");
                }
                if (isset($request->end_time)) {
                    $endTime = $request->end_time;
                } else {
                    $endTime = $startTime + $request->get_hours;
                }

                $hourPriceArr['title']        = "Hour Price";
                $hourPriceArr['start_time']   = $startTime;
                $hourPriceArr['end_time']     = $endTime;
                $hourPriceArr['price']        = $price;
                $hourPriceArr['get_hours']    = $request->get_hours;
                $hprice                       = $price * $request->get_hours;
                $total_amount                += $hprice;
                $hourPriceArr['total_price']  = $hprice;
                $hourPriceArr['hour_price']   = 1;
                $hourPriceArr['way']          = 0;
                $breakDownArr['detail'][]     = $hourPriceArr;


                if ($water_sports != '') {
                    foreach ($water_sports as $wkey => $WS) {
                        $get_water_sports_arr = [];
                        $adult = 0;
                        $child = 0;
                        if ($WS['adult_qty'] > 0 || $WS['child_qty'] > 0) {
                            if ($WS['adult_price'] > 0 && $WS['adult_qty']) {
                                $adult = $WS['adult_price'] * $WS['adult_qty'];
                            }
                            if ($WS['child_price'] && $WS['child_qty']) {
                                $child = $WS['child_price'] * $WS['child_qty'];
                            }


                            $get_water_sports_arr['title']       = $WS['title'];
                            $get_water_sports_arr['hour_price']  = 0;
                            $get_water_sports_arr['way']         = 0;
                            $get_water_sports_arr['adult_price'] = $WS['adult_price'];
                            $get_water_sports_arr['adult_qty']   = $WS['adult_qty'];
                            $get_water_sports_arr['child_price'] = $WS['child_price'];
                            $get_water_sports_arr['child_qty']   = $WS['child_qty'];
                            $wprice  =  ($WS['child_price'] *  $WS['child_qty']) + ($WS['adult_qty'] *  $WS['adult_price']);
                            $total_amount += $wprice;
                            $get_water_sports_arr['total_price'] = $wprice;

                            $breakDownArr['detail'][]                      = $get_water_sports_arr;
                        }
                    }
                }

                if ($transportaion != '') {
                    $get_transportation_arr = [];
                    // return $transportaion;
                    foreach ($transportaion as $key => $T) {
                        if ($T['select_qty'] > 0) {
                            $TransportationVehicle = TransportationVehicle::where(['id' => $T['id']])->first();

                            $price = 0;
                            if ($TransportationVehicle) {
                                if ($T['two_way'] == 1 || $T['one_way'] == 1) {
                                    if ($T['two_way'] == 1) {
                                        $price =  get_partners_dis_price(ConvertCurrency($TransportationVehicle->two_way_price), $product_id, $request->user_id, 'transportation', 'yacht');
                                    } else {
                                        $price = get_partners_dis_price(ConvertCurrency($TransportationVehicle->one_way_price), $product_id, $request->user_id, 'transportation', 'yacht');
                                    }
                                } else {
                                    $price = 0;
                                }
                            }
                            $get_transportation_arr['title']        = $T['title'];
                            $get_transportation_arr['way']          = $T['two_way'] == 1 ? "Two Way" : "One Way";
                            $get_transportation_arr['price']        = $price;
                            $get_transportation_arr['get_hours']    = $T['select_qty'];
                            $trprice                                = $price  * $T['select_qty'];
                            $total_amount                          += $trprice;
                            $get_transportation_arr['total_price']  = $trprice;

                            $get_transportation_arr['hour_price']  = 1;
                            $breakDownArr['detail'][]                        = $get_transportation_arr;
                        }
                    }
                }

                if ($transfer_option != '') {
                    $get_transfer_arr = [];
                    foreach ($transfer_option as $taKey => $TA) {
                        if ($TA['select_qty'] > 0) {
                            $Productyachttransferoption = Productyachttransferoption::where(['id' => $TA['id']])->first();
                            if ($Productyachttransferoption) {
                                $get_transfer_arr['title']        = $TA['title'];
                                $get_transfer_arr['way']          = 1;
                                $get_transfer_arr['price']        = ConvertCurrency($Productyachttransferoption->price);
                                $get_transfer_arr['get_hours']    = $TA['select_qty'];
                                $tprice                           = get_partners_dis_price(ConvertCurrency($Productyachttransferoption->price), $product_id, $request->user_id, 'transfer_option', 'yacht')  * $TA['select_qty'];
                                $total_amount                    += $tprice;
                                $get_transfer_arr['total_price']  = $tprice;


                                $get_transfer_arr['hour_price']  = 1;
                                $breakDownArr['detail'][]                  = $get_transfer_arr;
                            }
                        }
                    }
                }

                if ($food_beverage != '') {
                    $get_food_arr = [];
                    foreach ($food_beverage as $faKey => $FB) {
                        if ($FB['select_qty'] > 0) {
                            $Productyachtwatersport = Productyachtwatersport::where(['id' => $FB['id']])->first();
                            if ($Productyachtwatersport) {
                                $get_food_arr['title']        = $FB['title'];
                                $get_food_arr['way']          = 1;
                                $get_food_arr['price']        = get_partners_dis_price(ConvertCurrency($Productyachtwatersport->price), $product_id, $request->user_id, 'water_sports', 'yacht');
                                $get_food_arr['get_hours']    = $FB['select_qty'];
                                $tprice                           = get_partners_dis_price(ConvertCurrency($Productyachtwatersport->price), $product_id, $request->user_id, 'water_sports', 'yacht')  * $FB['select_qty'];
                                $total_amount                    += $tprice;
                                $get_food_arr['total_price']  = $tprice;


                                $get_food_arr['hour_price']  = 1;
                                $breakDownArr['detail'][]                  = $get_food_arr;
                            }
                        }
                    }
                }
                $total_arr = [];
                $total_arr['sub_total'] = $total_amount;


                $tax_amount = 0;
                $service_charge = 0;
                $tax_percentage = 0;
                if ($Product->tax_allowed == 1) {
                    if ($Product->tax_percentage > 0) {
                        $tax_percentage = $Product->tax_percentage;
                        $tax_amount = ($total_amount / 100) * $Product->tax_percentage;
                    }
                }
                $total_arr['tax_amount'] = $tax_amount;
                $total_arr['tax']        = $tax_percentage;

                if ($Product->service_allowed == 1) {
                    if ($Product->service_amount > 0) {
                        $service_charge = ConvertCurrency($Product->service_amount);
                    }
                }

                $total_arr['service_charge']        = $service_charge;

                $total_arr['total_amount'] = $total_amount + $service_charge + $tax_amount;


                $breakDownArr[]   = $total_arr;


                $output['data'] = $breakDownArr;
                $output['status'] = true;
                $output['message'] = 'Data Fetched Successfully...';

                return json_encode($output);
            }
        }
    }


    //Yacht Add to Cart
    public function yacht_add_to_cart(Request $request)
    {
        $output            = [];
        $output['status']  = false;
        $output['message'] = 'Data Not Found';
        $validation = Validator::make($request->all(), [
            'language'   => 'required',
            'product_id' => 'required',
            'date'       => 'required',
            'start_time' => 'required',
            'end_time'   => 'required',
            'guest'      => 'required',
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

        // print_die($request->all());                                                     
        $product_id   = $request->product_id;
        $language_id  = $request->language;
        $Product      = Product::where('slug', $product_id)->first();
        $user_id     = $request->user_id != "" ? checkDecrypt($request->user_id) : 0;
        if ($Product) {
            $get_extra_data_arr   = array();
            $transportaion        = '';
            $transportationCheck  = '';
            if (isset($request->transportaion)) {
                $transportaion = $request->transportaion;
            }
            if (isset($request->transportationCheck)) {
                $transportationCheck = $request->transportationCheck;
            }

            $transferOptionCheck  = '';
            $transfer_option      = '';
            if (isset($request->transfer_option)) {
                $transfer_option = $request->transfer_option;
            }
            if (isset($request->transferOptionCheck)) {
                $transferOptionCheck = $request->transferOptionCheck;
            }

            $foodBeverageCheck  = '';
            $food_beverage      = '';
            if (isset($request->foodBeverageCheck)) {
                $foodBeverageCheck = $request->foodBeverageCheck;
            }
            if (isset($request->food_beverage)) {
                $food_beverage = $request->food_beverage;
            }


            $waterSportsCheck  = '';
            $water_sports      = '';
            if (isset($request->water_sports)) {
                $water_sports = $request->water_sports;
            }
            if (isset($request->waterSportsCheck)) {
                $waterSportsCheck = $request->waterSportsCheck;
            }



            $product_id    = $Product->id;
            $start_time    = Carbon::parse($request->start_time);
            $end_time      = Carbon::parse($request->end_time);
            $diff_in_hour  = $start_time->diffInHours($end_time);


            //Minnimum Hours Check
            if ($Product->minimum_booking != '') {
                if ($Product->minimum_booking > $diff_in_hour) {
                    $error             = true;
                    $output['status']  = false;
                    $output['message'] = 'Minimum ' . $Product->minimum_booking . ' Hours are Allowed';
                }
            }



            //Number Of Passenger
            if ($request->guest != '') {
                if ($request->guest > $Product->boat_maximum_capacity) {
                    $error             = true;
                    $output['status']  = false;
                    $output['message'] = 'Only ' . $Product->boat_maximum_capacity . ' people are allowed in a boat!';
                } elseif ($request->guest == 0) {
                    $error             = true;
                    $output['status']  = false;
                    $output['message'] = 'Please Select Number Of Guests';
                }
            }

            $get_extra_data_arr['product_id']    = $product_id;
            $get_extra_data_arr['guest']         = $request->guest;
            $get_extra_data_arr['date']          = $request->date;
            $get_extra_data_arr['start_time']    = $request->start_time;
            $get_extra_data_arr['end_time']      = $request->end_time;
            $get_extra_data_arr['get_hours']     = $request->get_hours;
            $get_extra_data_arr['transportaion'] = array();
            // Transportation
            if ($transportaion != '') {
                foreach ($transportaion as $key => $transportaion_value) {
                    if ($transportationCheck != '') {
                        $get_transportaion = array();
                        if (isset($transportationCheck[$transportaion_value['id']]) &&  $transportationCheck[$transportaion_value['id']] == 'true') {
                            $TransportationVehicle = TransportationVehicle::where(['id' => $transportaion_value['id'], 'status' => 'Active'])->first();
                            $TransportationVehiclelanguage = TransportationVehicleLanguage::where(['transportation_vehicle_id' => $transportaion_value['id']])->get();
                            $TransportationVehicleLanguage = getLanguageTranslate($TransportationVehiclelanguage, $language_id, $transportaion_value['id'], 'title', 'transportation_vehicle_id');
                            if ($transportaion_value['select_qty'] > 0) {
                                $get_transportaion['id']               = $transportaion_value['id'];
                                $get_transportaion['title']            = $transportaion_value['title'];
                                $get_transportaion['quantity']         = $transportaion_value['quantity'];
                                $get_transportaion['select_qty']       = $transportaion_value['select_qty'];
                                $get_transportaion['one_way']          = $transportaion_value['one_way'];
                                $get_transportaion['two_way']          = $transportaion_value['two_way'];
                                $get_transportaion['total_amount']     = $transportaion_value['total_amount'];
                                $get_extra_data_arr['transportaion'][] = $get_transportaion;
                            } else {
                                $error             = true;
                                $output['status']  = false;
                                $output['message'] = 'Please Transportation ' . $TransportationVehicleLanguage . ' Select Qty';
                                break;
                            }
                        }
                    }
                }
            }
            // Transportation End

            $get_extra_data_arr['transfer_option'] = array();

            // Add Extra Options
            if ($transfer_option != '') {
                foreach ($transfer_option as $transfer_option_key => $transfer_option_value) {
                    if ($transferOptionCheck != '') {
                        $get_transfer_option = array();
                        if (isset($transferOptionCheck[$transfer_option_value['id']]) &&  $transferOptionCheck[$transfer_option_value['id']] == 'true') {
                            $Productyachttransferoption         = Productyachttransferoption::where(['id' => $transfer_option_value['id']])->first();
                            $ProductyachttransferoptionLanguage = Productyachttransferoptionlanguage::where(['product_yacht_transfer_option_id' => $transfer_option_value['id']])->where('language_id', $language_id)->first();
                            $transfer_title                     = '';
                            if ($ProductyachttransferoptionLanguage) {
                                $transfer_title                 = $ProductyachttransferoptionLanguage['title'];
                            }
                            if ($Productyachttransferoption) {
                                if ($transfer_option_value['select_qty'] > 0) {
                                    $get_transfer_option['id']               = $transfer_option_value['id'];
                                    $get_transfer_option['title']            = $transfer_option_value['title'];
                                    $get_transfer_option['price']            = $transfer_option_value['price'];
                                    $get_transfer_option['quantity']         = 0;
                                    $get_transfer_option['select_qty']       = $transfer_option_value['select_qty'];
                                    $get_transfer_option['total_amount']     = $transfer_option_value['total_amount'];
                                    $get_extra_data_arr['transfer_option'][] = $get_transfer_option;
                                } else {
                                    $error             = true;
                                    $output['status']  = false;
                                    $output['message'] = 'Please Transfer Option ' . $transfer_title . ' Select Qty';
                                    break;
                                }
                            }
                        }
                    }
                }
            }
            // Add Extra Options End


            // Add Food Beverage Data

            $get_extra_data_arr['water_sports'] = array();
            //Your Water Sports
            if ($water_sports != '') {
                foreach ($water_sports as $water_sports_key => $water_sports_value) {
                    if ($waterSportsCheck != '') {
                        $get_water_sports = array();
                        if (isset($waterSportsCheck[$water_sports_value['optionID']]) &&  $waterSportsCheck[$water_sports_value['optionID']] == 'true') {
                            $ProductOptions        = ProductOptions::where('id', $water_sports_value['optionID'])->first();
                            $ProductOptionLanguage = ProductOptionLanguage::where('option_id', $water_sports_value['optionID'])->where('language_id', $language_id)->first();
                            $water_sports_title                     = '';
                            if ($ProductOptionLanguage) {
                                $water_sports_title                 = $ProductOptionLanguage['title'];
                            }
                            if ($ProductOptions) {
                                if ($water_sports_value['adult_qty'] > 0 || $water_sports_value['child_qty'] > 0) {
                                    $get_water_sports['id']               = $water_sports_value['optionID'];
                                    $get_water_sports['adult_price']      = $water_sports_value['adult_price'];
                                    $get_water_sports['child_price']      = $water_sports_value['child_price'];
                                    $get_water_sports['infant_price']     = $water_sports_value['infant_price'];
                                    $get_water_sports['adult_qty']        = $water_sports_value['adult_qty'];
                                    $get_water_sports['child_qty']        = $water_sports_value['child_qty'];
                                    $get_water_sports['total_amount']     = $water_sports_value['total_amount'];
                                    $get_extra_data_arr['water_sports'][] = $get_water_sports;
                                } else {
                                    $error             = true;
                                    $output['status']  = false;
                                    $output['message'] = 'Please Food & Beverage ' . $water_sports_title . ' Select Qty';
                                    break;
                                }
                            }
                        }
                    }
                }
            }
            //Your Food Beverage  End


            // Add Watre Sports Data Start 
            $get_extra_data_arr['food_beverage'] = array();

            // Add Extra Options
            if ($food_beverage != '') {
                foreach ($food_beverage as $food_beverage_key => $food_beverage_value) {
                    if ($foodBeverageCheck != '') {
                        $get_food_beverage = array();
                        if (isset($foodBeverageCheck[$food_beverage_value['id']]) &&  $foodBeverageCheck[$food_beverage_value['id']] == 'true') {
                            $Productyachtwatersport         = Productyachtwatersport::where(['id' => $food_beverage_value['id']])->first();
                            $Productyachtwatersportlanguage = Productyachtwatersportlanguage::where(['product_yacht_water_sport_id' => $food_beverage_value['id']])->where('language_id', $language_id)->first();
                            $transfer_title                     = '';
                            if ($Productyachtwatersportlanguage) {
                                $transfer_title                 = $Productyachtwatersportlanguage['title'];
                            }
                            if ($Productyachtwatersport) {
                                if ($food_beverage_value['select_qty'] > 0) {
                                    $get_food_beverage['id']               = $food_beverage_value['id'];
                                    $get_food_beverage['title']            = $food_beverage_value['title'];
                                    $get_food_beverage['price']            = $food_beverage_value['price'];
                                    $get_food_beverage['quantity']         = $food_beverage_value['quantity'];
                                    $get_food_beverage['select_qty']       = $food_beverage_value['select_qty'];
                                    $get_food_beverage['total_amount']     = $food_beverage_value['total_amount'];
                                    $get_extra_data_arr['food_beverage'][] = $get_food_beverage;
                                } else {
                                    $error             = true;
                                    $output['status']  = false;
                                    $output['message'] = 'Please Water Sports ' . $transfer_title . ' Select Qty';
                                    break;
                                }
                            }
                        }
                    }
                }
            }
            // Add Watre Sports Data End 



            // print_die($get_extra_data_arr);

            //Addto Cart 
            if ($error != true) {
                $AddToCart                 = new AddToCart();
                $AddToCart['product_id']   = $product_id;
                $AddToCart['product_type'] = "Yatch";
                $AddToCart['user_id']      = $user_id;
                $AddToCart['token']        = $request->token;
                $AddToCart['extra']        = json_encode($get_extra_data_arr);
                $AddToCart['status']       = "Active";
                $AddToCart->save();
                $output['status'] = true;
                $output['message'] = 'Add To Cart Successfully...';
            }
        }

        return json_encode($output);
    }



    //yacht_request
    public function yacht_request(Request $request)
    {
        $output            = [];
        $output['status']  = false;
        $output['message'] = 'Data Not Found';
        $validation = Validator::make($request->all(), [
            'language'   => 'required',
            'product_id' => 'required',
            'date'       => 'required',
            'start_time' => 'required',
            'end_time'   => 'required',
            'guest'      => 'required',
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

        // print_die($request->all());                                                     
        $product_id   = $request->product_id;
        $language_id  = $request->language;
        $Product      = Product::where('slug', $product_id)->first();
        $user_id     = $request->user_id != "" ? checkDecrypt($request->user_id) : 0;
        if ($Product) {
            $get_extra_data_arr   = array();
            $transportaion        = '';
            $transportationCheck  = '';
            if (isset($request->transportaion)) {
                $transportaion = $request->transportaion;
            }
            if (isset($request->transportationCheck)) {
                $transportationCheck = $request->transportationCheck;
            }

            $transferOptionCheck  = '';
            $transfer_option      = '';
            if (isset($request->transfer_option)) {
                $transfer_option = $request->transfer_option;
            }
            if (isset($request->transferOptionCheck)) {
                $transferOptionCheck = $request->transferOptionCheck;
            }

            $foodBeverageCheck  = '';
            $food_beverage      = '';
            if (isset($request->foodBeverageCheck)) {
                $foodBeverageCheck = $request->foodBeverageCheck;
            }
            if (isset($request->food_beverage)) {
                $food_beverage = $request->food_beverage;
            }


            $waterSportsCheck  = '';
            $water_sports      = '';
            if (isset($request->water_sports)) {
                $water_sports = $request->water_sports;
            }
            if (isset($request->waterSportsCheck)) {
                $waterSportsCheck = $request->waterSportsCheck;
            }



            $product_id    = $Product->id;
            $start_time    = Carbon::parse($request->start_time);
            $end_time      = Carbon::parse($request->end_time);
            $diff_in_hour  = $start_time->diffInHours($end_time);


            //Minnimum Hours Check
            if ($Product->minimum_booking != '') {
                if ($Product->minimum_booking > $diff_in_hour) {
                    $error             = true;
                    $output['status']  = false;
                    $output['message'] = 'Minimum ' . $Product->minimum_booking . ' Hours are Allowed';
                }
            }



            //Number Of Passenger
            if ($request->guest != '') {
                if ($request->guest > $Product->boat_maximum_capacity) {
                    $error             = true;
                    $output['status']  = false;
                    $output['message'] = 'Only ' . $Product->boat_maximum_capacity . ' people are allowed in a boat!';
                } elseif ($request->guest == 0) {
                    $error             = true;
                    $output['status']  = false;
                    $output['message'] = 'Please Select Number Of Guests';
                }
            }

            $get_extra_data_arr['product_id']    = $product_id;
            $get_extra_data_arr['guest']         = $request->guest;
            $get_extra_data_arr['date']          = $request->date;
            $get_extra_data_arr['start_time']    = $request->start_time;
            $get_extra_data_arr['end_time']      = $request->end_time;
            $get_extra_data_arr['get_hours']     = $request->get_hours;
            $get_extra_data_arr['transportaion'] = array();
            // Transportation
            if ($transportaion != '') {
                foreach ($transportaion as $key => $transportaion_value) {
                    if ($transportationCheck != '') {
                        $get_transportaion = array();
                        if (isset($transportationCheck[$transportaion_value['id']]) &&  $transportationCheck[$transportaion_value['id']] == 'true') {
                            $TransportationVehicle = TransportationVehicle::where(['id' => $transportaion_value['id'], 'status' => 'Active'])->first();
                            $TransportationVehiclelanguage = TransportationVehicleLanguage::where(['transportation_vehicle_id' => $transportaion_value['id']])->get();
                            $TransportationVehicleLanguage = getLanguageTranslate($TransportationVehiclelanguage, $language_id, $transportaion_value['id'], 'title', 'transportation_vehicle_id');
                            if ($transportaion_value['select_qty'] > 0) {
                                $get_transportaion['id']               = $transportaion_value['id'];
                                $get_transportaion['title']            = $transportaion_value['title'];
                                $get_transportaion['quantity']         = $transportaion_value['quantity'];
                                $get_transportaion['select_qty']       = $transportaion_value['select_qty'];
                                $get_transportaion['one_way']          = $transportaion_value['one_way'];
                                $get_transportaion['two_way']          = $transportaion_value['two_way'];
                                $get_transportaion['total_amount']     = $transportaion_value['total_amount'];
                                $get_extra_data_arr['transportaion'][] = $get_transportaion;
                            } else {
                                $error             = true;
                                $output['status']  = false;
                                $output['message'] = 'Please Transportation ' . $TransportationVehicleLanguage . ' Select Qty';
                                break;
                            }
                        }
                    }
                }
            }
            // Transportation End

            $get_extra_data_arr['transfer_option'] = array();

            // Add Extra Options
            if ($transfer_option != '') {
                foreach ($transfer_option as $transfer_option_key => $transfer_option_value) {
                    if ($transferOptionCheck != '') {
                        $get_transfer_option = array();
                        if (isset($transferOptionCheck[$transfer_option_value['id']]) &&  $transferOptionCheck[$transfer_option_value['id']] == 'true') {
                            $Productyachttransferoption         = Productyachttransferoption::where(['id' => $transfer_option_value['id']])->first();
                            $ProductyachttransferoptionLanguage = Productyachttransferoptionlanguage::where(['product_yacht_transfer_option_id' => $transfer_option_value['id']])->where('language_id', $language_id)->first();
                            $transfer_title                     = '';
                            if ($ProductyachttransferoptionLanguage) {
                                $transfer_title                 = $ProductyachttransferoptionLanguage['title'];
                            }
                            if ($Productyachttransferoption) {
                                if ($transfer_option_value['select_qty'] > 0) {
                                    $get_transfer_option['id']               = $transfer_option_value['id'];
                                    $get_transfer_option['title']            = $transfer_option_value['title'];
                                    $get_transfer_option['price']            = $transfer_option_value['price'];
                                    $get_transfer_option['quantity']         = $transfer_option_value['quantity'];
                                    $get_transfer_option['select_qty']       = $transfer_option_value['select_qty'];
                                    $get_transfer_option['total_amount']     = $transfer_option_value['total_amount'];
                                    $get_extra_data_arr['transfer_option'][] = $get_transfer_option;
                                } else {
                                    $error             = true;
                                    $output['status']  = false;
                                    $output['message'] = 'Please Transfer Option ' . $transfer_title . ' Select Qty';
                                    break;
                                }
                            }
                        }
                    }
                }
            }
            // Add Extra Options End


            // Add Food Beverage Data

            $get_extra_data_arr['water_sports'] = array();
            //Your Water Sports
            if ($water_sports != '') {
                foreach ($water_sports as $water_sports_key => $water_sports_value) {
                    if ($waterSportsCheck != '') {
                        $get_water_sports = array();
                        if (isset($waterSportsCheck[$water_sports_value['optionID']]) &&  $waterSportsCheck[$water_sports_value['optionID']] == 'true') {
                            $ProductOptions        = ProductOptions::where('id', $water_sports_value['optionID'])->first();
                            $ProductOptionLanguage = ProductOptionLanguage::where('option_id', $water_sports_value['optionID'])->where('language_id', $language_id)->first();
                            $water_sports_title                     = '';
                            if ($ProductOptionLanguage) {
                                $water_sports_title                 = $ProductOptionLanguage['title'];
                            }
                            if ($ProductOptions) {
                                if ($water_sports_value['adult_qty'] > 0 || $water_sports_value['child_qty'] > 0) {
                                    $get_water_sports['id']               = $water_sports_value['optionID'];
                                    $get_water_sports['adult_price']      = $water_sports_value['adult_price'];
                                    $get_water_sports['child_price']      = $water_sports_value['child_price'];
                                    $get_water_sports['infant_price']     = $water_sports_value['infant_price'];
                                    $get_water_sports['adult_qty']        = $water_sports_value['adult_qty'];
                                    $get_water_sports['child_qty']        = $water_sports_value['child_qty'];
                                    $get_water_sports['total_amount']     = $water_sports_value['total_amount'];
                                    $get_extra_data_arr['water_sports'][] = $get_water_sports;
                                } else {
                                    $error             = true;
                                    $output['status']  = false;
                                    $output['message'] = 'Please Food & Beverage ' . $water_sports_title . ' Select Qty';
                                    break;
                                }
                            }
                        }
                    }
                }
            }
            //Your Food Beverage  End


            // Add Watre Sports Data Start 
            $get_extra_data_arr['food_beverage'] = array();

            // Add Extra Options
            if ($food_beverage != '') {
                foreach ($food_beverage as $food_beverage_key => $food_beverage_value) {
                    if ($foodBeverageCheck != '') {
                        $get_food_beverage = array();
                        if (isset($foodBeverageCheck[$food_beverage_value['id']]) &&  $foodBeverageCheck[$food_beverage_value['id']] == 'true') {
                            $Productyachtwatersport         = Productyachtwatersport::where(['id' => $food_beverage_value['id']])->first();
                            $Productyachtwatersportlanguage = Productyachtwatersportlanguage::where(['product_yacht_water_sport_id' => $food_beverage_value['id']])->where('language_id', $language_id)->first();
                            $transfer_title                     = '';
                            if ($Productyachtwatersportlanguage) {
                                $transfer_title                 = $Productyachtwatersportlanguage['title'];
                            }
                            if ($Productyachtwatersport) {
                                if ($food_beverage_value['select_qty'] > 0) {
                                    $get_food_beverage['id']               = $food_beverage_value['id'];
                                    $get_food_beverage['title']            = $food_beverage_value['title'];
                                    $get_food_beverage['price']            = $food_beverage_value['price'];
                                    // $get_food_beverage['quantity']         = $food_beverage_value['quantity'];
                                    $get_food_beverage['select_qty']       = $food_beverage_value['select_qty'];
                                    $get_food_beverage['total_amount']     = $food_beverage_value['total_amount'];
                                    $get_extra_data_arr['food_beverage'][] = $get_food_beverage;
                                } else {
                                    $error             = true;
                                    $output['status']  = false;
                                    $output['message'] = 'Please Water Sports ' . $transfer_title . ' Select Qty';
                                    break;
                                }
                            }
                        }
                    }
                }
            }
            // Add Watre Sports Data End 



            // print_die($get_extra_data_arr);

            //Addto Cart 
            if ($error != true) {
                $ProductRequestForm                 = new ProductRequestForm();
                $ProductRequestForm['product_id']   = $product_id;
                $ProductRequestForm['product_type'] = "Yatch";
                $ProductRequestForm['user_id']      = $user_id;
                $ProductRequestForm['token']        = $request->token;
                $ProductRequestForm['extra']        = json_encode($get_extra_data_arr);
                $ProductRequestForm['status']       = "Active";
                $ProductRequestForm->save();
                $output['status'] = true;
                $output['message'] = 'Request Add Successfully...';
            }
        }

        return json_encode($output);
    }
}
