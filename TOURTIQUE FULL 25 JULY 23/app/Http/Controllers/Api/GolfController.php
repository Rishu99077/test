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
use App\Models\Productyachtrelatedboats;
use App\Models\AddToCart;
use Illuminate\Support\Arr;
use App\Models\Country;
use App\Models\BoatTypes;
use App\Models\BoatLocations;
use App\Models\GolfRoom;
use App\Models\GolfRoomLanguage;
use App\Models\UserReview;
use App\Models\Wishlist;
use App\Models\User;
use App\Models\GolfTimeSlot;

use App\Models\ProductExprienceIcon;
use App\Models\ProductExprienceIconLanguage;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use DB;

class GolfController extends Controller
{
    //  golf List
    public function golf_list(Request $request)
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
        $setLimit = 3;
        $offset   = $request->offset;
        $limit    = $offset * $setLimit;
        $is_filter = false;
        $ProductCount = Product::where(['status' => 'Active', 'is_delete' => 0, 'product_type' => 'golf'])
            ->where('slug', '!=', '');
        $Product = Product::select("*")->addSelect(DB::raw('IF(selling_price > 0, selling_price, original_price ) AS current_price'))->where(['status' => 'Active', 'is_delete' => 0, 'product_type' => 'golf'])
            ->where('slug', '!=', '');

            if (isset($request->country)) {
                $is_filter = true;
                $country = $request->country;
                if ($country > 0 && $country != '') {
                    $ProductCount = $ProductCount->where("country", $country);
                    $Product      = $Product->where("country", $country);
                }
            }
            if (isset($request->state)) {
                $is_filter = true;
                $state = $request->state;
                if ($state  > 0 && $state != '') {
                    $ProductCount = $ProductCount->where("state", $state);
                    $Product = $Product->where("state", $state);
                }
            }
            if (isset($request->city)) {
                $city = $request->city;
                $is_filter = true;
                if ($city && $city != '') {
                    $ProductCount = $ProductCount->where("city", $city);
                    $Product = $Product->where("city", $city);
                }
            }
            if (isset($request->number_of_passenger)) {
                $is_filter = true;
                $guest = $request->number_of_passenger;
                if ($guest > 0 && $guest != '') {
                    $ProductCount = $ProductCount->where("boat_maximum_capacity", '>=', $guest);
                    $Product = $Product->where("boat_maximum_capacity", '>=', $guest);
                }
            }

            // if (isset($request->limousine_type)) {
            //     $is_filter = true;
            //     $limousine_type = $request->limousine_type;
            //     if ($limousine_type != '') {
            //         if ($limousine_type > 0) {
            //             $ProductCount = $ProductCount->where("boat_type", $limousine_type);
            //             $Product = $Product->where("boat_type", $limousine_type);
            //         }
            //     }
            // }

            if (isset($request->sort) && $request->sort != '') {
                $sort = $request->sort;
                if ($sort == "high_low") {
                    $Product = $Product->orderBy('current_price', 'desc');
                } else if ($sort == "capacity_high") {
                    $Product = $Product->orderBy("boat_maximum_capacity", "DESC");
                } else if ($sort == "capacity_low") {
                    $Product = $Product->orderBy("boat_maximum_capacity", "asc");
                } else {
                    $Product = $Product->orderBy("current_price", "asc");
                }
            } else {
                $Product = $Product->orderBy("id", "desc");
            }
            $forLocationProduct =  $Product->get();
            $ProductCount = $ProductCount->count();
            $Product      = $Product->offset($limit)->limit($setLimit)->get();


            $language             = $request->language;
            $output['page_count'] = ceil($ProductCount / $setLimit);
            if (!$Product->isEmpty()) {
                foreach ($Product as $key => $P) {
                    $limousine_location_id_arr[] = $P['boat_location'];
                    $productLang      = ProductLanguage::where(['product_id' => $P['id'], 'language_id' => $language])->first();
                    $title            = '';
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

                    $getProductArr = [];
                    $getProductArr['id'] = $P['id'];
                    $getProductArr['image'] = $P['image'] != '' ? asset('public/uploads/product_images/' . $P['image']) : asset('public/assets/img/no_image.jpeg');
                    $getProductArr['name']              = short_description_limit($title,35);
                    $getProductArr['short_description'] = short_description_limit($short_description,60);
                    // $getProductArr['name'] = $title;
                    // $getProductArr['short_description'] = $short_description;
                    $getProductArr['main_description'] = Str::limit($main_description, 60);
                    $getProductArr['duration'] = $duration;
                    $getProductArr['city'] = $city;
                    $getProductArr['slug'] = $P['slug'];
                    $getProductArr['boat_maximum_capacity'] = $P['boat_maximum_capacity'];
                    $getProductArr['minimum_booking'] = $P['minimum_booking'];
                    $getProductArr['total_sold'] = $P['how_many_are_sold'] !== '' ? $P['how_many_are_sold'] : 0;
                    $getProductArr['per_value'] = $P['per_value'];
                    $getProductArr['boat_type'] = $P['boat_type'];
                    if($P['boat_type'] != ""){
                        $LocationID[] = explode(",",$P['boat_type']);
                    }
                    $getProductArr['image_text'] = $P['image_text'] ?? null;
                    $getProductArr['price'] = $P['original_price'] ?? 0;
                    $getProductArr['selling_price'] = $P['selling_price'] ?? 0;
                    $getProductArr['ratings'] = get_rating($P['id']);
                    $getProductArr['price_html']        = get_price_front($P['id'],$request->user_id,$P['product_type']);
                    $ProductArr[] = $getProductArr;
                }
                $output['data']   = $ProductArr;
                $output['status'] = true;
            }
            $output['msg']  = 'Data Fetched Successfully...';
            return json_encode($output);
    }

    //  golf Details
    public function golf_detail(Request $request)
    {
        $output            = [];
        $output['status']  = false;
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

        $activity_id = $request->product_id;
        $Product     = Product::where('slug', $activity_id)->first();

        if ($Product) {
            $WeekDay      = Carbon::now()->dayName;
            $product_id   = $Product->id;

            $product_slug = $Product->slug;
            $language     = $request->language;
            $Product      = Product::where('id', $product_id)
                            ->where('product_type', 'golf')
                            ->where('status', 'Active')
                            ->first();
            $productDeatils = [];
            if ($Product) {
                //Price
                $productDeatils['price_html']         = get_price_front_detail($Product['id'],$request->user_id,$Product['product_type']);
                //Price
                
                $productDeatils['product_id'] = $Product['id'];

                // Wishlist
                $product_id                   = $Product->id;
                $productDeatils['isWishlist'] = false;
                if ($request->user_id) {
                    $user_id     = checkDecrypt($request->user_id);
                    $getWishlist = Wishlist::where('user_id', $user_id)->where('product_id', $product_id)->first();
                    if ($getWishlist) {
                        $productDeatils['isWishlist'] = true;
                    }
                }

                $productDeatils['ratings']               = get_rating($Product['id']);
                $productDeatils['total_rating_count']    = DB::table('user_review')->where('product_id', $Product['id'])->count();
                $productDeatils['total_ratings']         = get_ratings_count($Product['id']);
                
                
                //product Detail
                $ProductDetails = (array) $Product->toArray();
                $approx         = '';
                if ($ProductDetails['approx'] == 1) {
                    $approx     = '(Approx)';
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

                $from_date = '';
                $to_date   = '';
                if ($Product->note_on_sale_date != '') {
                    $dateArr = explode('to', $Product->note_on_sale_date);
                    if (isset($dateArr[0]) && isset($dateArr[1])) {
                        $from_date = trim($dateArr[0]);
                        $to_date   = trim($dateArr[1]);
                    }
                }
                $productDeatils['from_date'] = $from_date;
                $productDeatils['to_date']   = $to_date;

                $currentDateTime             = Carbon::now();
                $bookable_up_to              = '';
                if ($Product->can_be_booked_up_to_advance != '') {
                    $duration = explode('-', $Product->can_be_booked_up_to_advance);
                    $dura     = '';
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
                $productLang      = ProductLanguage::where(['product_id' => $product_id, 'language_id' => $language])->first();
                $title            = '';
                $main_description = '';
                $rantel_tip         = '';
                $transfer_tip       = '';
                $related_product_title     = '';
                if ($productLang) {
                    $title            = $productLang->description;
                    $main_description = $productLang->main_description;
                    if ($productLang->rantel_tip) {
                        $rantel_tip = $productLang->rantel_tip;
                    }
                    if ($productLang->transfer_tip) {
                        $transfer_tip = $productLang->transfer_tip;
                    }
                    if ($productLang->related_product_title) {
                        $related_product_title = $productLang->related_product_title;
                    }
                }
                $productDeatils['title']            = $title;
                $productDeatils['main_description'] = $main_description;
                $productDeatils['rantel_tip']       = $rantel_tip;
                $productDeatils['transfer_tip']     = $transfer_tip;
                $productDeatils['related_product_title']  = $related_product_title;

                // // Product Timing Code
                $ProductTimingsArr  = [];
                $checkDaily         = 0;
                if ($Product->timing_status == 1) {
                    $ProductTimings = ProductTimings::where(['product_id' => $product_id])->get();
                    foreach ($ProductTimings as $timeKey => $PT) {
                        $getProductTiming = [];
                        $getProductTimingDaily = [];
                        if ($PT['day'] == "Daily") {
                            if ($PT['is_close'] == 0) {
                                $checkDaily = 1;
                                $getProductTimingDaily['day']       = $PT['day'];
                                $getProductTimingDaily['time_from'] = date('g:i a', strtotime($PT['time_from']));
                                $getProductTimingDaily['time_to']   = date('g:i a', strtotime($PT['time_to']));
                                $getProductTimingDaily['is_close']  = $PT['is_close'];
                            }
                        } else {
                            $getProductTiming['day']       = $PT['day'];
                            $getProductTiming['time_from'] = date('g:i a', strtotime($PT['time_from']));
                            $getProductTiming['time_to']   = date('g:i a', strtotime($PT['time_to']));
                            $getProductTiming['is_close']  = $PT['is_close'];
                        }
                        
                        if ($checkDaily == 1) {
                            $ProductTimingsArr   = [];
                            $ProductTimingsArr[] = $getProductTimingDaily;
                            break;
                        } else {
                            $ProductTimingsArr[] = $getProductTiming;
                        }
                    }
                }
                // print_die($ProductTimingsArr);
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



                //Facilities
                $productDeatils['facilities']            = [];
                $productDeatils['facilities']['heading'] = '';
                $productDeatils['facilities']['content'] = [];
                $heading_title      = MetaGlobalLanguage::where('product_id',$product_id)->where('meta_parent','golf_facilities')->where('meta_title', 'golf_facilities_heading')->where('language_id', $language)->first();
                
                if ($heading_title) {
                    $productDeatils['facilities']['heading'] = $heading_title['title'];
                }

                
                $product_facilities_Arr = [];
                $get_product_facilities = YachtFeatureHighlight::where(['product_id' => $product_id,'status'=>'Active'])->get();
                if(!$get_product_facilities->isEmpty()){
                    foreach ($get_product_facilities as $facilities_key => $facilities_value) {
                
                        $facilites_arr  = [];
                        $facilites_arr['title']  = '';
                        $facilites_arr['test']   = '';
                        $YachtFeatureHighlightLanguage = YachtFeatureHighlightLanguage::where('language_id',$language)->where('feature_highlight_id',$facilities_value['id'])->first();
                        if($YachtFeatureHighlightLanguage){
                            $facilites_arr['title']  = $YachtFeatureHighlightLanguage['title']       !='' ? $YachtFeatureHighlightLanguage['title'] :'';
                            $facilites_arr['text']   = $YachtFeatureHighlightLanguage['description'] !='' ? $YachtFeatureHighlightLanguage['description'] :'';
                        }
                        $facilites_arr['image']      = $facilities_value['image'] !='' ? url('uploads/product_images',$facilities_value['image']) : asset('uploads/placeholder/placeholder.png');
                        $productDeatils['facilities']['content'][] = $facilites_arr;
                    }
                }


                //Highlight Code
                $ProductHighlightsArr = [];
                $ProductHighlights        = ProductHighlights::where(['product_id' => $product_id])->get();
                $ProductHighlightLanguage = ProductHighlightLanguage::where(['product_id' => $product_id])->get();
                foreach ($ProductHighlights as $key => $PH) {
                    $getProductHighlight  = [];
                    $hightitle            = getLanguageTranslate($ProductHighlightLanguage, $language, $PH['id'], 'title', 'highlight_id');
                    if ($hightitle != '') {
                        $getProductHighlight['title'] = getLanguageTranslate($ProductHighlightLanguage, $language, $PH['id'], 'title', 'highlight_id');
                        $getProductHighlight['description'] = getLanguageTranslate($ProductHighlightLanguage, $language, $PH['id'], 'description', 'highlight_id');
                        $ProductHighlightsArr[] = $getProductHighlight;
                    }
                }
                $productDeatils['highlight'] = $ProductHighlightsArr;

                // Product Additinal information
                $ProductAddtionalInfo          = ProductAddtionalInfo::where(['product_id' => $product_id])->get();
                $ProductAdditionalInfoLanguage = ProductAdditionalInfoLanguage::where(['product_id' => $product_id])->get();
                $ProductAdditionalInfoArr      = [];
                foreach ($ProductAddtionalInfo as $PAIkey => $PAI) {
                    $getProductAdditionalInfo  = [];
                    $addtitle                  = getLanguageTranslate($ProductAdditionalInfoLanguage, $language, $PAI['id'], 'description', 'product_additional_info_id');
                    if ($addtitle != '') {
                        $getProductAdditionalInfo['title'] = $addtitle;
                        $getProductAdditionalInfo['file'] = $PAI['image'] != '' ? asset('uploads/product/' . $PAI['image']) : asset('uploads/placeholder/placeholder.png');
                        $ProductAdditionalInfoArr[] = $getProductAdditionalInfo;
                    }
                }
                $productDeatils['additional_info'] = $ProductAdditionalInfoArr;

                //Product Site Advertisement
                $ProductSiteAdvertisement         = ProductSiteAdvertisement::where(['product_id' => $product_id])->get();
                $ProductSiteAdvertisementLanguage = ProductSiteAdvertisementLanguage::where(['product_id' => $product_id])->get();
                $ProductSiteAdvertisementArr      = [];
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
                $productDeatils['site_advertisement'] = $ProductSiteAdvertisementArr;

                
                
                $productDeatils['hotels'] = [];
                $Productyachttransferoption = Productyachttransferoption::where('product_id',$product_id)->where('type','golf')->get();
                if(!$Productyachttransferoption->isEmpty()){
                    foreach ($Productyachttransferoption as $hotels_key => $hotels_value) {
                        # code...
                        $hotel_arr = [];
                        $hotel_arr['link']     = $hotels_value['link']     != '' ? $hotels_value['link'] : '';
                        $hotel_arr['price']    = $hotels_value['price']    != '' ? $hotels_value['price'] : '';
                        $hotel_arr['location'] = $hotels_value['location'] != '' ? $hotels_value['location'] : '';
                        $hotel_arr['title']    = '';
                        $Productyachttransferoptionlanguage = Productyachttransferoptionlanguage::where('product_id',$product_id)->where('language_id',$language)->where('product_yacht_transfer_option_id',$hotels_value['id'])->first();
                        if($Productyachttransferoptionlanguage){
                            $hotel_arr['title']    = $Productyachttransferoptionlanguage['title'] !='' ? $Productyachttransferoptionlanguage['title'] : '';   
                        }
                        $productDeatils['hotels'][] = $hotel_arr;                        
                    }
                }


                $productDeatils['opening_heading'] = '';
                $heading_title                        = MetaGlobalLanguage::where('product_id', $product_id)->where('meta_parent', 'golf_opening_heading')
                    ->where('meta_title', 'heading_title')
                    ->where('language_id', $language)
                    ->first();
                if ($heading_title) {
                    $productDeatils['opening_heading'] = $heading_title['title'];
                }

                $productDeatils['additional_heading'] = '';
                $heading_title    = MetaGlobalLanguage::where('product_id', $product_id)->where('meta_parent', 'golf_additional_heading')
                    ->where('meta_title', 'heading_title')
                    ->where('language_id', $language)
                    ->first();
                if ($heading_title) {
                    $productDeatils['additional_heading'] = $heading_title['title'];
                }
                  

                ///Review For This Product
                $productDeatils['reviews'] = [];
                $get_review                = UserReview::where('product_id', $product_id)->orderBy('id', 'desc')->limit(6)->get();
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
                            $get_review_arr['user_image'] = $get_user['image'] != '' ? url('uploads/user_image/', $get_user['image']) : url('uploads/img_avatar.png');
                        }
                        $productDeatils['reviews'][] = $get_review_arr;
                    }
                }

                if ($request->user_id) {
                    $user_id     = checkDecrypt($request->user_id);
                    $getWishlist = Wishlist::where('user_id', $user_id)->where('product_id', $activity_id)->first();
                    if ($getWishlist) {
                        $productDeatils['isWishlist'] = true;
                    }
                    // $productDeatils['generated_link'] = generate_product_link("affilliate_generated_links", $Product['id'], $user_id, "activities-detail");
                }

                $productDeatils['rooms'] = [];
                $GolfRoom = GolfRoom::where('product_id',$product_id)->orderBy('id','desc')->get();
                if(!$GolfRoom->isEmpty()){
                    foreach ($GolfRoom as $rooms_key => $rooms_value) {
                        # code...
                        $rooms_arr = [];
                        $rooms_arr['id']             = $rooms_value['id'];
                        $rooms_arr['title']          = '';
                        $rooms_arr['description']    = '';
                        $GolfRoomLanguage            = GolfRoomLanguage::where('product_id',$product_id)->where('language_id',$language)->where('golf_room_id',$rooms_value['id'])->first();
                        if($GolfRoomLanguage){
                            $rooms_arr['title']         = $GolfRoomLanguage['title'] !='' ? $GolfRoomLanguage['title'] : '';   
                            $rooms_arr['description']   = $GolfRoomLanguage['description'] !='' ? $GolfRoomLanguage['description'] : '';   
                        }
                        $productDeatils['rooms'][] = $rooms_arr;                        
                    }
                }


                // Expireance Icon middle
                $productDeatils['middle_experience_heading'] = '';
                $productDeatils['middle_experience'] = [];
                $heading_title    = MetaGlobalLanguage::where('product_id', $product_id)->where('meta_parent', 'middle_experience_heading')
                    ->where('meta_title', 'heading_title')
                    ->where('language_id', $language)
                    ->first();
                if ($heading_title) {
                    $productDeatils['middle_experience_heading'] = $heading_title['title'];
                }

                $get_product_exp_icon = ProductExprienceIcon::where(['product_id' => $product_id])->where('position_type','middel')->get();
                if(!$get_product_exp_icon->isEmpty()){
                    foreach ($get_product_exp_icon as $facilities_key => $exp_value) {
        
                        $exp_arr  = [];
                        $exp_arr['file']      = $exp_value['image'] !='' ? url('uploads/expericence_icons',$exp_value['image']) : asset('uploads/placeholder/placeholder.png');

                        $exp_arr['title']  = '';
                        $ProductExprienceIconLanguage = ProductExprienceIconLanguage::where('language_id',$language)->where('position_type','middel')->where('experience_icon_id',$exp_value['id'])->first();
                        if($ProductExprienceIconLanguage){
                            $exp_arr['title']  = $ProductExprienceIconLanguage['title']       !='' ? $ProductExprienceIconLanguage['title'] :'';
                        }
                        $productDeatils['middle_experience'][] = $exp_arr;
                    }
                }


                // Expireance Icon middle
                $productDeatils['header_experience_heading'] = '';
                $productDeatils['header_experience'] = [];
                $heading_title    = MetaGlobalLanguage::where('product_id', $product_id)->where('meta_parent', 'header_experience_heading')
                    ->where('meta_title', 'heading_title')
                    ->where('language_id', $language)
                    ->first();
                if ($heading_title) {
                    $productDeatils['header_experience_heading'] = $heading_title['title'];
                }

                $get_product_exp_icon = ProductExprienceIcon::where(['product_id' => $product_id])->where('position_type','upper')->get();
                if(!$get_product_exp_icon->isEmpty()){
                    foreach ($get_product_exp_icon as $facilities_key => $exp_value) {
        
                        $exp_arr  = [];
                        $exp_arr['file']      = $exp_value['image'] !='' ? url('uploads/header_expericence_icons',$exp_value['image']) : asset('uploads/placeholder/placeholder.png');

                        $exp_arr['title']        = '';
                        $exp_arr['information']  = '';
                        $ProductExprienceIconLanguage = ProductExprienceIconLanguage::where('language_id',$language)->where('experience_icon_id',$exp_value['id'])->where('position_type','upper')->first();
                        if($ProductExprienceIconLanguage){
                            $exp_arr['title']  = $ProductExprienceIconLanguage['title']  !='' ? $ProductExprienceIconLanguage['title'] :'';
                            $exp_arr['information']  = $ProductExprienceIconLanguage['information']  !='' ? $ProductExprienceIconLanguage['information'] :'';
                        }
                        $productDeatils['header_experience'][] = $exp_arr;
                    }
                }


                
                $minimum_booking        = $Product->minimum_booking > 0 ? $Product->minimum_booking : 1;
                $ProductOptionWeekTour  = ProductOptionWeekTour::where(['product_id' => $Product->id, 'for_general' => 1, 'week_day' => $WeekDay])->first();
                if ($ProductOptionWeekTour) {
                    $getamount = $ProductOptionWeekTour->adult;
                    $productDeatils['selling_price'] = $getamount;
                    $productDeatils['original_price'] = 0;
                } else {
                    $getamount = $Product->selling_price !== '' ? $Product->selling_price : $Product->original_price;
                }
                $amount        = $getamount * $minimum_booking;

                $tax_amount = 0;
                $service_charge = 0;
                if ($Product->tax_allowed == 1) {
                    if ($Product->tax_percentage > 0) {
                        $tax_amount = ($amount / 100) * $Product->tax_percentage;
                    }
                }

                if ($Product->service_allowed == 1) {
                    if ($Product->service_amount > 0) {
                        $service_charge = $Product->service_amount;
                    }
                }


                // Releated Product
                $Productyachtrelatedboats = Productyachtrelatedboats::where(['product_id' => $product_id, 'type' => 'golf'])->get();
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
                           
                            // if($productLang->short_description !=''){
                            //     $getProductArr['short_description'] = short_description_limit($productLang->short_description);
                            //     // $get_product['short_description']  = $value_productLang->short_description;

                            // }
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
                        // $getProductArr['name'] = $title;
                        // $getProductArr['main_description'] = Str::limit($main_description, 60);

                        $getProductArr['name']                  = short_description_limit($title, 50);
                        $getProductArr['full_name']              = $title;
                        $getProductArr['short_description']     = short_description_limit($short_description, 50);
                        $getProductArr['main_description']      = Str::limit($main_description, 60);
                        $getProductArr['duration']              = $duration;
                        $getProductArr['city']                  = $city;
                        $getProductArr['slug']                  = $P['slug'];
                        $getProductArr['boat_maximum_capacity'] = $P['boat_maximum_capacity'];
                        $getProductArr['minimum_booking']       = $P['minimum_booking'];
                        $getProductArr['total_sold']            = $P['how_many_are_sold']     !== '' ? $P['how_many_are_sold'] : 0;
                        $getProductArr['per_value']             = $P['per_value'];
                        $getProductArr['image_text']            = $P['image_text'] ?? null;
                        $getProductArr['price']                 = get_partners_dis_price($P['original_price'], $product_id, $request->user_id, 'base_price', 'limousine') ?? 0;
                        $getProductArr['selling_price']         =  get_partners_dis_price($P['selling_price'], $product_id, $request->user_id, 'base_price', 'limousine') ?? 0;
                        $getProductArr['button']                = $P['product_bookable_type'] === 'bookable' ? 'Book Now' : 'On Request';
                        $getProductArr['ratings']               = get_rating($P['id']);
                        $getProductArr['price_html']            = get_price_front($P['id'], $request->user_id, $P['product_type']);

                        $ProductArr[] = $getProductArr;
                    }
                }
                $productDeatils['releated'] = $ProductArr;


                $totalAmount = 0;
                $productDeatils['total_amount'] = $totalAmount;
                
                
                $output['data'] = $productDeatils;
                $output['status'] = true;
                $output['message'] = 'Data Fetched Successfully...';
            }
        }

        return json_encode($output);
    }


    //  golf Time slots
    public function golf_time_slots(Request $request)
    {
        $output            = [];
        $output['status']  = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            'product_id' => 'required',
            'date'       => 'required',
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

        $timestamp = strtotime($request->date);
        $day = date('l', $timestamp);
      
        $get_day = Timing::where('day', $day)->first();
        if ($get_day) {
            $get_time_slot   = GolfTimeSlot::where(['product_id'=>$activity_id , 'slot_day'=>$get_day['id']])->get();
            if (!$get_time_slot->isEmpty()) {
                $timeDetails = [];
                foreach ($get_time_slot as $key => $value) {
                   $row = [];
                   $row['id']         = $value['id'];
                   $row['product_id'] = $value['product_id'];
                   $row['day']        = $get_day['day'];
                   $row['time']       = $value['slot_from_time'].'-'.$value['slot_to_time'];

                   $timeDetails[] = $row;
                }

                $output['data']    = $timeDetails;
                $output['status']  = true;
                $output['message'] = 'Golf Available time slots...';

            }
        }

        return response()->json($output); 

    }

}
