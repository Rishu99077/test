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
use App\Models\ProductCategory;
use App\Models\Category;
use App\Models\Timing;
use App\Models\MetaGlobalLanguage;
use App\Models\ProductPrivateTransferCars;
use App\Models\ProductTourPriceDetails;
use App\Models\ProductToolTipLanguage;
use App\Models\ProductOptionWeekTour;
use App\Models\ProductOptionTaxServiceCharge;
use App\Models\ProductInfo;
use App\Models\Language;
use App\Models\ProductLodge;
use App\Models\ProductLodgeLanguage;
use App\Models\ProductOptionPrivateTourPrice;
use App\Models\ProductLodgePrice;
use App\Models\Wishlist;
use App\Models\AddToCart;
use App\Models\ProductRequestForm;

use App\Models\Productyachtrelatedboats;


use App\Models\UserReview;
use App\Models\User;
use Carbon\Carbon;
use DB;

use App\Models\ProductExprienceIcon;
use App\Models\ProductExprienceIconLanguage;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;

class LodgeController extends Controller
{
    // lodge Product List
    public function lodge_product_list(Request $request)
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
        $offset  = $request->offset;
        $limit =  $offset * $setLimit;
        $language = $request->language;

        $is_filter    = false;
        $ProductCount = Product::select('products.*')->join("product_language", "product_language.product_id", '=', 'products.id')->join('product_categories', 'product_categories.product_id', '=', 'products.id')->where(['status' => 'Active', 'is_delete' => 0, 'product_type' => 'lodge'])->where("product_language.language_id", $language)
            ->where('slug', '!=', '');

        $Product = Product::select('products.*')->join("product_language", "product_language.product_id", '=', 'products.id')->join('product_categories', 'product_categories.product_id', '=', 'products.id')->where(['status' => 'Active', 'is_delete' => 0, 'product_type' => 'lodge'])->where("product_language.language_id", $language)
            ->where('slug', '!=', '');

        if (isset($request->country)) {
            $is_filter = true;
            $country = $request->country;
            if ($country > 0 && $country != '') {
                $ProductCount = $ProductCount->where("country", $country);
                $Product      = $Product->where("country", $country);
            }
        }

        if (isset($request->city)) {
            $is_filter = true;
            $city = $request->city;
            if ($city > 0 && $city != '') {
                $ProductCount = $ProductCount->where("city", $city);
                $Product      = $Product->where("city", $city);
            }
        }



        if (isset($request->name)) {
            $is_filter = true;
            $name = $request->name;
            if ($name != '') {
                $ProductCount = $ProductCount->where("product_language.description", 'like', '%' . $name . '%');
                $Product      = $Product->where("product_language.description", 'like', '%' . $name . '%');
            }
        }


        $CategoryProduct = $Product;

        $output['categories'] = [];


        $CategoryProductArr = [];
        if ($is_filter) {
            $CategoryProduct = $CategoryProduct->get();

            $categoryArr = [];
            foreach ($CategoryProduct as $ckey => $CP) {

                $ProductCategory = ProductCategory::where("product_id", $CP['id'])->get();

                foreach ($ProductCategory as $pkey => $PC) {
                    $getArr = [];
                    $Category = Category::select('categories.*', 'category_language.description as name')
                        ->where('categories.id', $PC['category'])
                        ->where('categories.status', 'Active')
                        ->join('category_language', 'categories.id', '=', 'category_language.category_id')
                        ->first();



                    if ($Category != "" && !in_array($PC['category'], $categoryArr)) {
                        $CategoryProductArr[] = $Category;

                        $categoryArr[] = $PC['category'];
                    }
                }
            }
        }

        $output['categories']  = $CategoryProductArr;




        if (isset($request->checkedCategory)) {
            $is_filter       = true;
            $checkedCategory = $request->checkedCategory;


            $Product = $Product->where(function ($data) use ($checkedCategory) {
                foreach ($checkedCategory as $IBL => $case) {
                    if ($case == "true") {
                        $Product = $data->orWhere("product_categories.category", $IBL);
                        $ProductCount = $data->orWhere("product_categories.category", $IBL);
                    }
                }
            });
        }

        if (isset($request->checkedSubCategory)) {
            $is_filter       = true;
            $checkedSubCategory = $request->checkedSubCategory;


            $Product = $Product->where(function ($data) use ($checkedSubCategory) {
                foreach ($checkedSubCategory as $IBL => $case) {
                    if ($case == "true") {
                        $Product = $data->orWhere("product_categories.sub_category", $IBL);
                        $ProductCount = $data->orWhere("product_categories.sub_category", $IBL);
                    }
                }
            });
        }
        // return $Product->get();



        // $ProductCount =    $Product->groupBy("product_categories.product_id")->count();
        $ProductCount  =  $Product->get()->count();
        
        $Product = $Product->orderBy('id', 'DESC')->offset($limit)
            ->groupBy("product_categories.product_id")
            ->limit($setLimit)
            ->get();




        $output['page_count'] = ceil($ProductCount / $setLimit);
        $ProductArr = [];
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

            $getProductArr                     = [];
            $getProductArr['id']               = $P['id'];
            $getProductArr['image']            = $P['image']                  != '' ? asset('public/uploads/product_images/' . $P['image']) : asset('public/assets/img/no_image.jpeg');
            $getProductArr['name']              = short_description_limit($title, 50);
            $getProductArr['full_name']          = $title;
            $getProductArr['short_description'] = short_description_limit($short_description, 60);
            $getProductArr['main_description'] = Str::limit($main_description, 60);
            $getProductArr['duration']         = $duration;
            $getProductArr['city']             = $city;
            $getProductArr['slug']             = $P['slug'];
            $getProductArr['total_sold']       = $P['how_many_are_sold']     !== '' ? $P['how_many_are_sold'] : 0;
            $getProductArr['per_value']        = $P['per_value'];
            $getProductArr['image_text']       = $P['image_text'] ?? null;
            $getProductArr['price']            = $P['original_price'] ?? 0;
            $getProductArr['selling_price']    = $P['selling_price'] ?? 0;
            $getProductArr['button']           = $P['product_bookable_type'] === 'bookable' ? 'Book Now' : 'On Request';
            $getProductArr['ratings']          = get_rating($P['id']);
            $getProductArr['price_html']        = get_price_front($P['id'], $request->user_id, $P['product_type']);
            $ProductArr[] = $getProductArr;
        }
        $output['data']          = $ProductArr;
        $output['product_count'] = $ProductCount;
        $output['status']        = true;
        $output['msg']           = 'Data Fetched Successfully...';
        return json_encode($output);
    }
    public function getDatesFromRange($start, $end, $format = 'Y-m-d')
    {
        return array_map(function ($timestamp) use ($format) {
            return date($format, $timestamp);
        }, range(strtotime($start) + ($start < $end ? 4000 : 8000), strtotime($end) + ($start < $end ? 8000 : 4000), 86400));
    }

    // Lodge Details
    public function lodge_details(Request $request)
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

        $activity_id  = $request->product_id;
        $Product      = Product::where('slug', $activity_id)->first();
        $product_id   = $Product->id;
        $activity_id  = $Product->id;
        $product_slug = $Product->slug;
        $language     = $request->language;
        $Product      = Product::where('id', $product_id)
            ->where('product_type', 'lodge')
            ->where('status', 'Active')
            ->first();


        $productDeatils = [];
        if ($Product) {
            //Price
            $productDeatils['price_html']         = get_price_front_detail($Product['id'], $request->user_id, $Product['product_type']);
            //Price

            $productDeatils['ratings']          = get_rating($Product['id']);
            $productDeatils['total_rating_count']    = DB::table('user_review')->where('product_id', $Product['id'])->count();

            $productDeatils['total_ratings']    = get_ratings_count($Product['id']);
            $productDeatils['product_id'] = $Product['id'];
            //Check Wishlist
            $productDeatils['isWishlist']      = false;
            $productDeatils['generated_link']  = '';
            if ($request->user_id) {
                $user_id     = checkDecrypt($request->user_id);
                $getWishlist = Wishlist::where('user_id', $user_id)->where('product_id', $product_id)->first();
                if ($getWishlist) {
                    $productDeatils['isWishlist'] = true;
                }
                $productDeatils['generated_link'] = generate_product_link("affilliate_generated_links", $product_id, $user_id, "lodge-detail");
            }
            //Check Wishlist

            //product Detail
            $ProductDetails = (array) $Product->toArray();
            $approx         = '';
            if ($ProductDetails['approx'] == 1) {
                $approx = '(Approx)';
            }

            //Category 
            $category       = $Product->category;
            $catArr         = explode(',', $category);
            $newCategory    = '';
            $categrory_slug = [];
            $coma           = ' / ';
            foreach ($catArr as $Ckey => $Cvalue) {
                if ($Ckey == count($catArr) - 1) {
                    $coma = '';
                }
                $category_arr = [];
                $category_arr['category_name']  = getAllInfo('category_language', ['category_id' => $Cvalue, 'language_id' => 3], 'description') . $coma;
                $category_arr['category_slug']  = getAllInfo('categories', ['id' => $Cvalue], 'slug');
                $categrory_slug[]               = $category_arr;
            }
            $productDeatils['categrory_slug'] = $categrory_slug;

            foreach ($ProductDetails as $Pkey => $P) {
                if ($Pkey == 'image' || $Pkey == 'logo' || $Pkey == 'video_thumbnail') {


                    if ($P != '') {
                        $P =  asset('uploads/product_images/' . $P);
                    } else {
                        if ($Pkey == 'video_thumbnail') {
                            $P = asset('uploads/product_images/video_thumb.png');
                        } else {
                            $P = asset('uploads/placeholder/placeholder.png');
                        }
                    }
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
                    $P = json_decode($P, true);
                    $PNew = [];
                    foreach ($P as $Pval) {
                        $PNew[] = trim($Pval);
                    }
                    $P = $PNew;
                }
                $productDeatils[$Pkey] = $P != '' ? $P : '';
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

            $description_heading =  MetaGlobalLanguage::where('product_id', $activity_id)->where('meta_title', 'lodge_description_title')
                                    ->where('language_id', $language)
                                    ->where('status', 'Active')
                                    ->first();
            if($description_heading){
                $productDeatils['description_heading'] =$description_heading['title'];
            }else{
                $productDeatils['description_heading'] ='';
            }


            $productLang = ProductLanguage::where(['product_id' => $product_id, 'language_id' => $language])->first();
            $title = '';
            $main_description = '';
            if ($productLang) {
                $title = $productLang->description;
                $main_description = $productLang->main_description;
            }
            $productDeatils['title'] = $title;
            $productDeatils['main_description'] = $main_description;

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
            $ProductInfo = ProductInfo::where('title', 'lodge_type')
                ->where('product_id', $product_id)
                ->first();
            $productDeatils['free_cancellation'] = $ProductInfo != '' ? $ProductInfo->value : 0;

            // Product Lodge
            $ProductLodgeArr = [];
            $ProductLodge = ProductLodge::where(['product_id' => $product_id])->get();
            $ProductLodgeLanguage = ProductLodgeLanguage::where(['product_id' => $product_id])->get();
            foreach ($ProductLodge as $PLkey => $PL) {
                $getProductLodge = [];
                $adult_price     = $PL['adult_price']    != '' ? ConvertCurrency($PL['adult_price']) : 'N/A';
                $infant_price    = $PL['infant_price']   != '' ? ConvertCurrency($PL['infant_price']) : 'N/A';
                $child_price     = $PL['child_price']    != '' ? ConvertCurrency($PL['child_price']) : 'N/A';
                $infant_allowed  = $PL['infant_allowed'] != '' ? $PL['infant_allowed'] : '0';
                $child_allowed   = $PL['child_allowed']  != '' ? $PL['child_allowed'] : '0';

                $getProductLodge['lodgeID']              = $PL['id'];
                $getProductLodge['lodge_adult_price']    = $adult_price;
                $getProductLodge['lodge_child_price']    = $child_price;
                $getProductLodge['lodge_infant_price']   = $infant_price;
                $getProductLodge['lodge_adult_qty']      = 0;
                $getProductLodge['lodge_child_qty']      = 0;
                $getProductLodge['lodge_infant_qty']     = 0;
                $getProductLodge['lodge_child_allowed']  = $child_allowed;
                $getProductLodge['lodge_infant_allowed'] = $infant_allowed;
                $getProductLodge['lodge_arrival_date']   = '';
                $getProductLodge['lodge_departure_date'] = '';
                $getProductLodge['lodge_qty']            = 0;
                $getProductLodge['total_lodge_amount']   = 0;
                $getProductLodge['service_charge']       = 0;
                $getProductLodge['upgrade_amount']       = 0;
                $getProductLodge['tax']                  = 0;
                $getProductLodge['is_reset']             = 0;
                $getProductLodge['is_check']             = 0;
                $getProductLodge['title']                = getLanguageTranslate($ProductLodgeLanguage, $language, $PL['id'], 'title', 'lodge_id');
                $getProductLodge['description']          = getLanguageTranslate($ProductLodgeLanguage, $language, $PL['id'], 'description', 'option_id');

                $deafult_lodge_price  = $PL['lodge_price'] != '' ? ConvertCurrency($PL['lodge_price']) : 0;
                $date = date('Y-m-d');
                $getProductLodgePrice = ProductLodgePrice::where('product_id', $product_id)
                    ->where('product_lodge_id', $PL['id'])
                    ->whereDate('from_date', '<=', $date)
                    ->whereDate('to_date', '>=', $date)
                    ->orderBy('id', 'desc')
                    ->first();
                $getProductLodge['deafult_lodge_price']     = get_partners_dis_price($deafult_lodge_price, $product_id, $request->user_id, 'tour_price', 'lodge');
                if ($getProductLodgePrice) {
                    // $getProductLodge['title'] = $getProductLodgePrice['title'] != '' ? $getProductLodgePrice['title'] : '';
                    $deafult_lodge_price = $getProductLodgePrice['price'] != '' ? ConvertCurrency($getProductLodgePrice['price']) : 0;
                    $getProductLodge['deafult_lodge_price']     = get_partners_dis_price($deafult_lodge_price, $product_id, $request->user_id, 'room_details', 'lodge');
                }


                // $getProductLodge['deafult_lodge_price123']  = get_partners_dis_price($deafult_lodge_price,$product_id,$request->user_id,'tour_price','lodge');
                // Tour Upgrade
                $ProductOptionLodgeUpgrade = ProductOptionTourUpgrade::where(['product_option_id' => $PL['id'], 'product_id' => $product_id])->get();

                if (count($ProductOptionLodgeUpgrade) > 0) {
                    foreach ($ProductOptionLodgeUpgrade as $key => $POLU) {
                        $getProductTourTourArr = [];
                        $getProductTourTourArr['id'] = $POLU['id'];
                        $getProductTourTourArr['title'] = $POLU['title'];
                        $getProductTourTourArr['lodge_adult_price'] = get_partners_dis_price(ConvertCurrency($POLU['adult_price']), $product_id, $request->user_id, 'tour_upgrade_option', 'lodge');
                        $getProductTourTourArr['lodge_child_price'] = get_partners_dis_price(ConvertCurrency($POLU['child_price']), $product_id, $request->user_id, 'tour_upgrade_option', 'lodge');
                        $getProductTourTourArr['lodge_infant_price'] = get_partners_dis_price(ConvertCurrency($POLU['infant_price']), $product_id, $request->user_id, 'tour_upgrade_option', 'lodge');
                        $getProductTourTourArr['child_allowed'] = $POLU['child_allowed'];
                        $getProductTourTourArr['infant_allowed'] = $POLU['infant_allowed'];
                        $getProductTourTourArr['lodge_adult_qty'] = 0;
                        $getProductTourTourArr['lodge_child_qty'] = 0;
                        $getProductTourTourArr['lodge_infant_qty'] = 0;
                        $getProductTourTourArr['is_check'] = 0;
                        $getProductLodge['lodgeUpgrade'][] = $getProductTourTourArr;
                    }
                } else {
                    $getProductLodge['lodgeUpgrade'] = [];
                }
                $ProductLodgeArr[] = $getProductLodge;
            }
            $productDeatils['lodge'] = $ProductLodgeArr;

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
            $productDeatils['site_advertisement'] = $ProductSiteAdvertisementArr;

            // // Product Frequently Asked Question
            $ProductFAQArr = [];
            $ProductFaqs = ProductFaqs::where(['product_id' => $product_id])->get();
            $ProductFaqLanguage = ProductFaqLanguage::where(['product_id' => $product_id])->get();
            foreach ($ProductFaqs as $PFkey => $PF) {
                $getProductFAQ = [];
                $faqtitle = getLanguageTranslate($ProductFaqLanguage, $language, $PF['id'], 'question', 'faq_id');
                if ($faqtitle != '') {
                    $getProductFAQ['question'] = getLanguageTranslate($ProductFaqLanguage, $language, $PF['id'], 'question', 'faq_id');
                    $getProductFAQ['answer'] = getLanguageTranslate($ProductFaqLanguage, $language, $PF['id'], 'answer', 'faq_id');
                    $ProductFAQArr[] = $getProductFAQ;
                }
            }
            $productDeatils['faq'] = $ProductFAQArr;

            // // Product Tool Tip
            $get_tool_tip = [];
            $get_product_tool_tip = ProductToolTipLanguage::where('product_id', $product_id)
                ->where('language_id', $language)
                ->get();
            foreach ($get_product_tool_tip as $tool_tip_key => $tool_tip_value) {
                $get_tool_tip[$tool_tip_value['tooltip_title']] = $tool_tip_value['tooltip_description'];
            }
            $productDeatils['product_tool_tip'] = $get_tool_tip;

            // // Product Timing Code
            $ProductTimingsArr = [];
            if ($Product->timing_status == 1) {
                $ProductTimings = ProductTimings::where(['product_id' => $product_id])->get();
                foreach ($ProductTimings as $timeKey => $PT) {
                    $getProductTiming = [];
                    $getProductTiming['day'] = $PT['day'];
                    $getProductTiming['time_from'] = date('g:i a', strtotime($PT['time_from']));
                    $getProductTiming['time_to'] = date('g:i a', strtotime($PT['time_to']));
                    $getProductTiming['is_close'] = $PT['is_close'];
                    $ProductTimingsArr[] = $getProductTiming;
                }
            }
            $productDeatils['products_timming'] = $ProductTimingsArr;



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
            $heading_title                        = MetaGlobalLanguage::where('product_id', $activity_id)->where('meta_parent', 'lodge_opening_heading')
                ->where('meta_title', 'heading_title')
                ->where('language_id', $language)
                ->where('product_id', $activity_id)
                ->first();
            if ($heading_title) {
                $productDeatils['opening_heading'] = $heading_title['title'];
            }

            $productDeatils['additional_heading'] = '';
            $heading_title                        = MetaGlobalLanguage::where('product_id', $activity_id)->where('meta_parent', 'lodge_additional_heading')
                ->where('meta_title', 'heading_title')
                ->where('language_id', $language)
                ->where('product_id', $activity_id)
                ->first();
            if ($heading_title) {
                $productDeatils['additional_heading'] = $heading_title['title'];
            }


            $productDeatils['faq_heading'] = '';
            $heading_title                        = MetaGlobalLanguage::where('product_id', $activity_id)->where('meta_parent', 'lodge_faq_heading')
                ->where('meta_title', 'heading_title')
                ->where('language_id', $language)
                ->where('product_id', $activity_id)
                ->first();
            if ($heading_title) {
                $productDeatils['faq_heading'] = $heading_title['title'];
            }

            // Product Experience ICon
            $productDeatils['experience_icon'] = [];
            $ProductExprienceIcon              = ProductExprienceIcon::where(['product_id' => $product_id, 'type' => 'lodge'])->where('position_type', 'middel')->get();
            $ProductExprienceIconLanguage      = ProductExprienceIconLanguage::where(['product_id' => $product_id, 'type' => 'lodge'])->where('position_type', 'middel')->get();
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
            $ProductExprienceIconHeader              = ProductExprienceIcon::where(['product_id' => $product_id, 'type' => 'lodge'])->where('position_type', 'upper')->get();
            $ProductExprienceIconLanguageHeader      = ProductExprienceIconLanguage::where(['product_id' => $product_id, 'type' => 'lodge'])->where('position_type', 'upper')->get();
            $ProductExperienceArr              = [];
            foreach ($ProductExprienceIconHeader as $PAIkey => $PEIH) {
                $getProductExperience = [];
                $addtitle             = getLanguageTranslate($ProductExprienceIconLanguageHeader, $language, $PEIH['id'], 'title', 'experience_icon_id');
                $information             = getLanguageTranslate($ProductExprienceIconLanguageHeader, $language, $PEIH['id'], 'information', 'experience_icon_id');
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
                $productDeatils['product_popup']['link']            = $Product->pro_popup_link;
                $productDeatils['product_popup']['redirect_link'] = $Product->redirection_link;
                $productDeatils['product_popup']['product_image']   = $Product->image != '' ? url('uploads/product_images', $Product->image) : asset('uploads/placeholder/placeholder.png');
                $productDeatils['product_popup']['image']       = $Product->pro_popup_image != '' ? url('uploads/product_images', $Product->pro_popup_image) : '';
                $productDeatils['product_popup']['video']        = $Product->pro_popup_video != '' ? url('uploads/product_images/popup_image', $Product->pro_popup_video) : '';
                $productDeatils['product_popup']['thumnail']     = $Product->pro_popup_thumnail_image != '' ? url('uploads/product_images/popup_image', $Product->pro_popup_thumnail_image) : ($Product->image != '' ? url('uploads/product_images/', $Product->image) : asset('uploads/placeholder/placeholder.png'));
            }

            // Releated Product 
            $Productyachtrelatedboats = Productyachtrelatedboats::where(['product_id' => $product_id, 'type' => "lodge"])->get();
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
                    $getProductArr['price'] = ConvertCurrency($P['original_price']) ?? 0;
                    $getProductArr['selling_price'] = ConvertCurrency($P['selling_price']) ?? 0;
                    $getProductArr['button']        = $P['product_bookable_type'] === 'bookable' ? 'Book Now' : 'On Request';
                    $getProductArr['ratings']       = get_rating($P['id']);
                    $getProductArr['price_html']        = get_price_front($P['id'], $request->user_id, $P['product_type']);

                    $ProductArr[] = $getProductArr;
                }
            }
            $productDeatils['releated'] = $ProductArr;


            $output['data'] = $productDeatils;
            $output['status'] = true;
            $output['msg'] = 'Data Fetched Successfully...';
        }

        return json_encode($output);
    }

    // Get Lodge Price By Date

    public function lodge_price_by_date(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            'product_id' => 'required',
            'lodge_id' => 'required',
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

        $activity_id = $request->product_id;
        $lodge_id    = $request->lodge_id;
        $Product     = Product::where('slug', $activity_id)->first();
        $product_id  = $Product->id;
        $language    = $request->language;
        $PriceArr    = [];
        if ($Product) {
            if ($request->details != '') {
                $Details       = $request->details;
                $arrivalDate   = $Details['lodge_arrival_date'];
                $date          = Carbon::createFromFormat('Y-m-d', $Details['lodge_departure_date']);
                $departureDate = $date->subDay(1);
                $departureDate = date('Y-m-d', strtotime($departureDate));
                // $departureDate = date('Y-m-d', strtotime($Details['lodge_departure_date'], '-1 days'));
                // return $arrivalDate . '--' . $departureDate;
                $ProductLodge = ProductLodge::where(['product_id' => $product_id, 'id' => $lodge_id])->first();

                $getArrivalProductLodgePrice = ProductLodgePrice::where('product_id', $product_id)
                    ->where('product_lodge_id', $lodge_id)
                    ->whereDate('from_date', '<=', $arrivalDate)
                    ->whereDate('to_date', '>=', $arrivalDate)
                    ->orderBy('id', 'desc')
                    ->first();

                $getDepartureProductLodgePrice = ProductLodgePrice::where('product_id', $product_id)
                    ->where('product_lodge_id', $lodge_id)
                    ->whereDate('from_date', '<=', $departureDate)
                    ->whereDate('to_date', '>=', $departureDate)
                    ->orderBy('id', 'desc')
                    ->first();





                $getArrivalPrice   = $getArrivalProductLodgePrice ?
                    get_partners_dis_price(ConvertCurrency($getArrivalProductLodgePrice->price), $product_id, $request->user_id, 'room_details', 'lodge')

                    :
                    get_partners_dis_price(ConvertCurrency($ProductLodge->lodge_price), $product_id, $request->user_id, 'tour_price', 'lodge');

                $getDeparturePrice = $getDepartureProductLodgePrice ?   get_partners_dis_price(ConvertCurrency($getDepartureProductLodgePrice->price), $product_id, $request->user_id, 'room_details', 'lodge')  : get_partners_dis_price(ConvertCurrency($ProductLodge->lodge_price), $product_id, $request->user_id, 'tour_price', 'lodge');

                if ($getArrivalPrice == $getDeparturePrice) {
                    $price          = $getArrivalPrice;
                } else {

                    $price           = $getArrivalPrice . '-' . $getDeparturePrice;
                }

                $PriceArr['price'] = $price;
                $output['data']    = $PriceArr;
                $output['status']  = true;
                $output['message']     = 'Data Fetched Successfully...';
            }
        }
        return json_encode($output);
    }

    public function get_lodge_total_calculation(Request $request)
    {
        $output            = [];
        $output['status']  = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            'product_id' => 'required',
            'lodge_id'   => 'required',
            'language'   => 'required',
            'details'    => 'required',
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

        $activity_id          = $request->product_id;
        $lodge_id             = $request->lodge_id;
        $Product              = Product::where('slug', $activity_id)->first();
        $product_id           = $Product->id;
        $language             = $request->language;
        $service_charge       = 0;
        $check_service_charge = 0;
        $tax_amount           = 0;
        $tax                  = 0;
        $room_qty             = 0;

        $PriceArr = [];
        if ($Product) {
            if ($request->details != '') {
                $ProductLodge = ProductLodge::where(['product_id' => $product_id, 'id' => $lodge_id])->first();
                $ProductOptionTaxServiceCharge = ProductOptionTaxServiceCharge::where(['product_id' => $product_id, 'product_option_id' => $lodge_id])->first();
                if ($ProductOptionTaxServiceCharge) {
                    if ($ProductOptionTaxServiceCharge->service_charge_allowed == 1) {
                        $service_charge = $ProductOptionTaxServiceCharge->service_charge_amount != '' ? ConvertCurrency($ProductOptionTaxServiceCharge->service_charge_amount) : 0;
                    }
                    if ($ProductOptionTaxServiceCharge->tax_allowed == 1) {
                        $tax = $ProductOptionTaxServiceCharge->tax_percentage != '' ? $ProductOptionTaxServiceCharge->tax_percentage : 0;
                    }
                }

                $Details       = $request->details;
                $arrivalDate   = $Details['lodge_arrival_date'];
                $departureDate = $Details['lodge_departure_date'];

                $adultQty    = $Details['lodge_adult_qty'];
                $childQty    = $Details['lodge_child_qty'];
                $infantQty   = $Details['lodge_infant_qty'];
                $totalAmount =    get_partners_dis_price(ConvertCurrency($ProductLodge->lodge_price), $product_id, $request->user_id, 'tour_price', 'lodge');
                if ($arrivalDate != '' && $departureDate != '') {
                    $date = Carbon::createFromFormat('Y-m-d', $Details['lodge_departure_date']);
                    $departureDate = $date->subDay(1);
                    $departureDate = date('Y-m-d', strtotime($departureDate));

                    if ($arrivalDate == $departureDate) {
                        $dateArr = [$arrivalDate];
                    } else {
                        $dateArr = $this->getDatesFromRange($arrivalDate, $departureDate);
                    }
                    $totalAmount = 0;
                } else {
                    $dateArr = [];
                    $getProductLodgePrice = ProductLodgePrice::where('product_id', $product_id)
                        ->where('product_lodge_id', $lodge_id)
                        ->whereDate('from_date', '<=', date('Y-m-d'))
                        ->whereDate('to_date', '>=', date('Y-m-d'))
                        ->orderBy('id', 'desc')
                        ->first();
                    if ($getProductLodgePrice) {
                        $totalAmount = get_partners_dis_price(ConvertCurrency($getProductLodgePrice->price), $product_id, $request->user_id, 'room_details', 'lodge');
                    }
                }



                $total_nights    = count($dateArr);
                $totalAdultRoom  = 1;
                $totalChildRoom  = 1;
                $totalInfantRoom = 0;
                $is_more         = 0;
                $limitAdult      = $ProductLodge->adult;
                $limitChild      = $ProductLodge->child;
                $limitInfant     = $ProductLodge->infant;

                if ($adultQty > $limitAdult) {
                    $totalAdultRoom = ceil($adultQty / $limitAdult);
                    $is_more        = 1;
                }
                if ($childQty > $limitChild) {
                    $totalChildRoom = ceil($childQty / $limitChild);
                    $is_more        = 1;
                }

                if ($ProductLodge->infant_limit == 0) {
                    $limitInfant = $limitInfant != '' ? $limitInfant : 0;
                    if ($infantQty > $limitInfant) {
                        $totalInfantRoom = ceil($infantQty / $limitInfant);
                        $is_more         = 1;
                    }
                }

                $totalQty = max($totalAdultRoom, $totalChildRoom, $totalInfantRoom);

                if ($adultQty > 0 || $childQty > 0 || $infantQty > 0) {
                    foreach ($dateArr as $key => $DA) {
                        $price = get_partners_dis_price(ConvertCurrency($ProductLodge->lodge_price), $product_id, $request->user_id, 'tour_price', 'lodge');
                        $getProductLodgePrice = ProductLodgePrice::where('product_id', $product_id)
                            ->where('product_lodge_id', $lodge_id)
                            ->whereDate('from_date', '<=', $DA)
                            ->whereDate('to_date', '>=', $DA)
                            ->orderBy('id', 'desc')
                            ->first();

                        if ($getProductLodgePrice != '') {
                            $price = get_partners_dis_price(ConvertCurrency($getProductLodgePrice->price), $product_id, $request->user_id, 'room_details', 'lodge');
                        }
                        $totalAmount += $price;
                    }
                }

                $TourUpgradeTotal = 0;
                if (isset($Details['lodgeUpgrade'])) {
                    foreach ($Details['lodgeUpgrade'] as $key => $DL) {
                        if ($DL['lodge_adult_qty'] > 0) {
                            $check_service_charge = 1;
                            if (isset($DL['lodge_adult_price'])) {
                                $TourUpgradeTotal += $DL['lodge_adult_qty'] * $DL['lodge_adult_price'] * $total_nights;
                            } else {
                                $TourUpgradeTotal += 0;
                            }
                        }
                        if ($DL['lodge_child_qty'] > 0) {
                            $check_service_charge = 1;

                            if (isset($DL['lodge_child_qty'])) {
                                $TourUpgradeTotal += $DL['lodge_child_qty'] * $DL['lodge_child_price'] * $total_nights;
                            } else {
                                $TourUpgradeTotal += 0;
                            }
                        }
                        if ($DL['lodge_infant_qty'] > 0) {
                            $check_service_charge = 1;
                            if (isset($DL['lodge_child_qty'])) {
                                $TourUpgradeTotal += $DL['lodge_infant_qty'] * $DL['lodge_infant_price'] * $total_nights;
                            } else {
                                $TourUpgradeTotal += 0;
                            }
                        }
                    }
                }

                if ($adultQty > 0 || $childQty > 0 || $infantQty > 0 || $check_service_charge == 1) {
                } else {
                    $service_charge = 0;
                }

                if (isset($request->is_upgrade)) {
                    $totalQty = isset($Details['room_qty']) ? $Details['room_qty'] : $totalQty;
                }


                $NewTotal = $totalAmount * $totalQty;

                $NewTotalForTax = $TourUpgradeTotal + $totalAmount * $totalQty;

                if ($tax != 0 && $NewTotalForTax != 0) {
                    $tax_amount = ($NewTotalForTax / 100) * $tax;
                }

                $deafult_lodge_price = ConvertCurrency($Details['deafult_lodge_price']);
                if ($Details['is_reset'] == 1) {
                    $NewTotal = 0;
                    $service_charge = 0;
                    $tax_amount = 0;
                    $TourUpgradeTotal = 0;

                    $date = date('Y-m-d');
                    $getProductLodgePrice = ProductLodgePrice::where('product_id', $product_id)
                        ->where('product_lodge_id', $lodge_id)
                        ->whereDate('from_date', '<=', $date)
                        ->whereDate('to_date', '>=', $date)
                        ->orderBy('id', 'desc')
                        ->first();
                    if ($getProductLodgePrice) {
                        // $getProductLodge['title'] = $getProductLodgePrice['title'] != '' ? $getProductLodgePrice['title'] : '';
                        $deafult_lodge_price = $getProductLodgePrice['price'] != '' ? get_partners_dis_price(ConvertCurrency($getProductLodgePrice['price']), $product_id, $request->user_id, 'room_details', 'lodge') : 0;
                    }
                }
                $PriceArr['deafult_lodge_price'] = $deafult_lodge_price;
                $PriceArr['total']               = $NewTotal;
                $PriceArr['service_charge']      = $service_charge;
                $PriceArr['tax']                 = $tax_amount;
                $PriceArr['tax_percentage']      = $tax;
                $PriceArr['upgrade_amount']      = $TourUpgradeTotal;

                $PriceArr['is_reset']  = 0;
                $PriceArr['msg']       = 'Only ' . $limitAdult . ' Adult , ' . $limitChild . ' Child Or ' . $limitInfant . ' infant Allowed';
                $PriceArr['is_more']   = $is_more;
                $PriceArr['lodge_qty'] = $totalQty;

                $output['data']    = $PriceArr;
                $output['status']  = true;
                $output['message'] = 'Data Fetched Successfully...';
            }
        }

        return json_encode($output);
    }

    //Lodge Price BreakDown
    public function lodge_price_breakdown(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['msg'] = 'Data Not Found';
        $validation = Validator::make($request->all(), [
            'language' => 'required',
            'product_id' => 'required',
            'lodgeID' => 'required',
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

        $child_qty        = 0;
        $adult_qty        = 0;
        $infant_qty       = 0;
        $room_qty         = 0;
        $product_slug     = $request->product_id;
        $lodge_id         = $request->lodgeID;
        $lodgeUpgrade     = $request->lodgeUpgrade;
        $arrival_date     = '';
        $departure_date   = '';
        $oldDepartureDate = '';

        if ($request->lodge_arrival_date) {
            $arrival_date = $request->lodge_arrival_date;
        }
        if ($request->lodge_departure_date) {
            $departure_date   = $request->lodge_departure_date;
            $oldDepartureDate = $departure_date;
            $date             = Carbon::createFromFormat('Y-m-d', $departure_date);
            $departureDate    = $date->subDay(1);
            $departure_date   = date('Y-m-d', strtotime($departureDate));
        }
        if ($request->lodge_adult_qty) {
            $adult_qty = $request->lodge_adult_qty;
        }
        if ($request->lodge_infant_qty) {
            $infant_qty = $request->lodge_infant_qty;
        }
        if ($request->lodge_child_qty) {
            $child_qty = $request->lodge_child_qty;
        }
        if ($request->room_qty) {
            if ($adult_qty > 0 || $child_qty > 0 || $infant_qty > 0) {
                $room_qty = $request->room_qty;
            }
        }

        $lodge_detail_arr     = [];
        $total                = 0;
        $tax_amount           = 0;
        $tax                  = 0;
        $service_charge       = 0;
        $check_service_charge = 0;
        $new_arr              = [];
        $Product              = Product::where('slug', $product_slug)->first();
        if ($Product) {
            $product_id = $Product->id;
            $product_slug = $Product->slug;
            $language = $request->language;
            $get_product = Product::where('id', $product_id)
                ->where('product_type', 'lodge')
                ->where('status', 'Active')
                ->first();
            if ($get_product) {
                $get_lodge_arr = [];
                $get_product_lodge_language = ProductLodgeLanguage::where(['product_id' => $product_id])->get();
                // if ($adult_qty > 0 || $child_qty > 0 || $infant_qty > 0) {

                $get_lodge_detail = ProductLodge::where(['product_id' => $product_id, 'id' => $lodge_id])->first();

                $ProductOptionTaxServiceCharge = ProductOptionTaxServiceCharge::where(['product_id' => $product_id, 'product_option_id' => $lodge_id])->first();
                if ($ProductOptionTaxServiceCharge) {
                    if ($ProductOptionTaxServiceCharge->service_charge_allowed == 1) {
                        $service_charge = $ProductOptionTaxServiceCharge->service_charge_amount != '' ? ConvertCurrency($ProductOptionTaxServiceCharge->service_charge_amount) : 0;
                    }
                    if ($ProductOptionTaxServiceCharge->tax_allowed == 1) {
                        $tax = $ProductOptionTaxServiceCharge->tax_percentage != '' ? $ProductOptionTaxServiceCharge->tax_percentage : 0;
                    }
                }

                if ($get_lodge_detail) {
                    $get_lodge_arr['lodgeID'] = $get_lodge_detail['id'];
                    $get_lodge_arr['title'] = getLanguageTranslate($get_product_lodge_language, $language, $get_lodge_detail['id'], 'title', 'lodge_id');

                    $get_lodge_arr['limit_adult']  = $limitAdult                       = $get_lodge_detail->adult;
                    $get_lodge_arr['limit_child']  = $limitChild                       = $get_lodge_detail->child;
                    $get_lodge_arr['limit_infant'] = $limitInfant                      = $get_lodge_detail->infant;
                    $get_lodge_arr['adult_qty']    = $adult_qty                       != '' ? $adult_qty : 'N/A';
                    $get_lodge_arr['infant_qty']   = $infant_qty                      != '' ? $infant_qty : 'N/A';
                    $get_lodge_arr['child_qty']    = $child_qty                       != '' ? $child_qty : 'N/A';
                    $get_lodge_arr['price']        = $get_lodge_detail['lodge_price'] != '' ?

                        get_partners_dis_price(ConvertCurrency($get_lodge_detail['lodge_price']), $product_id, $request->user_id, 'tour_price', 'lodge')
                        : 0;

                    $dateArr = [];
                    $total_days_room_price =
                        get_partners_dis_price(ConvertCurrency($get_lodge_detail['lodge_price']), $product_id, $request->user_id, 'tour_price', 'lodge');
                    $get_price_detail_arr = [];
                    if ($arrival_date != '' && $departure_date != '') {
                        $total_days_room_price = 0;
                        if ($arrival_date == $departure_date) {
                            $dateArr = [$arrival_date];
                        } else {
                            $dateArr = $this->getDatesFromRange($arrival_date, $departure_date);
                        }
                        // $dateArr = $this->getDatesFromRange($arrival_date, $departure_date);
                        foreach ($dateArr as $key => $date) {
                            $get_date_arr = [];
                            $getProductLodgePrice = ProductLodgePrice::where('product_id', $product_id)
                                ->where('product_lodge_id', $lodge_id)
                                ->whereDate('from_date', '<=', $date)
                                ->whereDate('to_date', '>=', $date)
                                ->orderBy('id', 'desc')
                                ->first();
                            if ($getProductLodgePrice) {
                                $get_date_arr['from_date'] = $date;
                                $get_date_arr['to_date'] = $oldDepartureDate;
                                $get_date_arr['default_price'] = false;
                                $get_date_arr['default_title'] = '';
                                $get_date_arr['price'] = get_partners_dis_price(ConvertCurrency($getProductLodgePrice->price), $product_id, $request->user_id, 'room_details', 'lodge');
                                $get_date_arr['title'] = $getProductLodgePrice->title;
                                if (!array_key_exists($getProductLodgePrice->id, $get_price_detail_arr)) {
                                    $get_price_detail_arr[$getProductLodgePrice->id] = $get_date_arr;
                                } else {
                                    $get_price_detail_arr[$getProductLodgePrice->id]['to_date'] = $oldDepartureDate;
                                }
                            } else {
                                $get_date_arr['from_date'] = $date;
                                $get_date_arr['to_date'] = $oldDepartureDate;
                                $get_date_arr['price'] =  get_partners_dis_price(ConvertCurrency($get_lodge_detail['lodge_price']), $product_id, $request->user_id, 'tour_price', 'lodge');
                                $get_date_arr['default_price'] = true;
                                $get_date_arr['default_title'] = 'Default Room Price';
                                $get_date_arr['title'] = $get_lodge_arr['title'];
                                if (!array_key_exists($get_lodge_detail['id'], $get_price_detail_arr)) {
                                    $get_price_detail_arr[$get_lodge_detail['id']] = $get_date_arr;
                                } else {
                                    $get_price_detail_arr[$get_lodge_detail['id']]['to_date'] = $oldDepartureDate;
                                }
                            }
                            $total_days_room_price += $get_date_arr['price'];
                        }
                    } else {
                        $get_date_arr = [];
                        $get_date_arr['from_date'] = '';
                        $get_date_arr['to_date'] = '';
                        $get_date_arr['price'] = get_partners_dis_price(ConvertCurrency($get_lodge_detail['lodge_price']), $product_id, $request->user_id, 'tour_price', 'lodge');
                        $get_date_arr['default_price'] = true;
                        $get_date_arr['default_title'] = 'Default Room Price';
                        $get_date_arr['title'] = $get_lodge_arr['title'];
                        $get_price_detail_arr[] = $get_date_arr;

                        $getProductLodgePrice = ProductLodgePrice::where('product_id', $product_id)
                            ->where('product_lodge_id', $lodge_id)
                            ->whereDate('from_date', '<=', date('Y-m-d'))
                            ->whereDate('to_date', '>=', date('Y-m-d'))
                            ->orderBy('id', 'desc')
                            ->first();
                        if ($getProductLodgePrice) {
                            $total_days_room_price = get_partners_dis_price(ConvertCurrency($getProductLodgePrice->price), $product_id, $request->user_id, 'room_details', 'lodge');
                        }
                    }

                    $total_nights = count($dateArr);

                    // return $get_price_detail_arr;
                    $new_date_price = [];
                    foreach ($get_price_detail_arr as $price_key => $value_) {
                        $new_date_price[] = $value_;
                    }
                    $get_lodge_arr['date_price']            = array_reverse($new_date_price);
                    $get_lodge_arr['total_days_room_price'] = $total_days_room_price;

                    $totalAdultRoom = 0;
                    $totalChildRoom = 0;
                    $totalInfantRoom = 0;
                    $total_amount = 0;
                    if ($adult_qty > $limitAdult) {
                        $totalAdultRoom = ceil($adult_qty / $limitAdult);
                    }
                    if ($child_qty > $limitChild) {
                        $totalChildRoom = ceil($child_qty / $limitChild);
                    }

                    if ($get_lodge_detail->infant_limit == 0) {
                        if ($infant_qty > $limitInfant) {
                            $totalInfantRoom = ceil($infant_qty / $limitInfant);
                        }
                    }
                    $total_rooms = max($totalAdultRoom, $totalChildRoom, $totalInfantRoom);
                    // return $total_rooms;


                    $get_lodge_arr['total_rooms'] = $total_rooms;
                    $total_amount = $total_days_room_price * $total_rooms;
                    if ($room_qty > $total_rooms) {
                        $total_amount = $total_days_room_price * $room_qty;
                        $get_lodge_arr['total_rooms'] = $room_qty;
                    }
                    $get_lodge_arr['total_amount'] = $total_amount;
                    $total += $total_amount;
                    $new_arr[] = $get_lodge_arr;
                }
                // }
                if (isset($lodgeUpgrade)) {
                    foreach ($lodgeUpgrade as $key => $LU) {
                        if ($LU['lodge_adult_qty'] > 0 || $LU['lodge_child_qty'] > 0 || $LU['lodge_infant_qty'] > 0) {
                            $check_service_charge = 1;
                            $upgrade_arr          = [];
                            $req_adult_qty        = 0;
                            $req_child_qty        = 0;
                            $req_infant_qty       = 0;
                            $adult_price          = $LU['lodge_adult_price'] ?? 0;
                            $child_price          = $LU['lodge_child_price'] ?? 0;
                            $infant_price         = $LU['lodge_infant_price'] ?? 0;

                            if ($LU['lodge_adult_qty'] > 0) {
                                $req_adult_qty = $LU['lodge_adult_qty'];
                            }

                            if ($LU['lodge_child_qty'] > 0) {
                                $req_child_qty = $LU['lodge_child_qty'];
                            }

                            if ($LU['lodge_infant_qty'] > 0) {
                                $req_infant_qty = $LU['lodge_infant_qty'];
                            }

                            $total_adult_price   = $adult_price  * $req_adult_qty     * $total_nights;
                            $total_child_price   = $child_price  * $req_child_qty     * $total_nights;
                            $total_infant_price  = $infant_price * $req_infant_qty    * $total_nights;
                            $total_amount       += $get_total    = $total_adult_price + $total_child_price + $total_infant_price;

                            $upgrade_arr['title']              = $LU['title'] ?? '';
                            $upgrade_arr['total_nights']              = $total_nights;
                            $upgrade_arr['adult_price']        = $adult_price > 0 ? $adult_price : 'N/A';
                            $upgrade_arr['child_price']        = $child_price > 0 ? $child_price : 'N/A';
                            $upgrade_arr['infant_price']       = $infant_price > 0 ? $infant_price : 'N/A';
                            $upgrade_arr['req_adult_qty']      = $req_adult_qty > 0 ? $req_adult_qty : 'N/A';
                            $upgrade_arr['req_child_qty']      = $req_child_qty > 0 ? $req_child_qty : 'N/A';
                            $upgrade_arr['req_infant_qty']     = $req_infant_qty > 0 ? $req_infant_qty : 'N/A';
                            $upgrade_arr['total_adult_price']  = $total_adult_price;
                            $upgrade_arr['total_child_price']  = $total_child_price;
                            $upgrade_arr['total_infant_price'] = $total_infant_price;
                            $upgrade_arr['car_status'] = 0;
                            $upgrade_arr['total'] = $get_total;
                            $new_arr[] = $upgrade_arr;
                        }
                    }
                }

                if ($adult_qty > 0 || $child_qty > 0 || $infant_qty > 0 || $check_service_charge == 1) {
                } else {
                    $service_charge = 0;
                }

                $NewTotal = $total_amount;
                if ($tax != 0 && $NewTotal != 0) {
                    $tax_amount = ($NewTotal / 100) * $tax;
                }

                if ($request->is_reset == 1 || $total_amount == 0) {
                    $total_amount = 0;
                    $service_charge = 0;
                    $tax_amount = 0;
                    $TourUpgradeTotal = 0;
                }

                // $lodge_detail_arr['lodge_detail'][] = $get_lodge_arr;
                $lodge_detail_arr['lodge_detail'] = $new_arr;

                $lodge_detail_arr['total_amount'] = $total_amount;
                $lodge_detail_arr['tax'] = $tax_amount;
                $lodge_detail_arr['tax_percentage'] = $tax;
                $lodge_detail_arr['service_charge'] = $service_charge;

                $output['data'] = $lodge_detail_arr;
                $output['status'] = true;
                $output['msg'] = 'Data Fetched Successfully...';
            }
        }
        return json_encode($output);
    }

    // Lodge Total Room Count get_room_count_total
    public function get_room_count_total(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['msg'] = 'Data Not Found';
        $validation = Validator::make($request->all(), [
            'language' => 'required',
            'product_id' => 'required',
            'lodgeID' => 'required',
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

        $child_qty = 0;
        $adult_qty = 0;
        $infant_qty = 0;
        $room_qty = 0;
        $product_slug = $request->product_id;
        $lodge_id = $request->lodgeID;
        $lodgeUpgrade = $request->lodgeUpgrade;
        $arrival_date = '';
        $departure_date = '';
        $oldDepartureDate = '';

        if ($request->lodge_arrival_date) {
            $arrival_date = $request->lodge_arrival_date;
        }
        if ($request->lodge_departure_date) {
            $departure_date = $request->lodge_departure_date;
            $oldDepartureDate = $departure_date;
            $date = Carbon::createFromFormat('Y-m-d', $departure_date);
            $departureDate = $date->subDay(1);
            $departure_date = date('Y-m-d', strtotime($departureDate));
        }
        if ($request->lodge_adult_qty) {
            $adult_qty = $request->lodge_adult_qty;
        }
        if ($request->lodge_infant_qty) {
            $infant_qty = $request->lodge_infant_qty;
        }
        if ($request->lodge_child_qty) {
            $child_qty = $request->lodge_child_qty;
        }
        if ($request->room_qty) {
            $room_qty = $request->room_qty;
        }

        $lodge_detail_arr = [];
        $total            = 0;
        $tax_amount       = 0;
        $service_charge   = 0;
        $get_total        = 0;
        $tax              = 0;
        $upgrade_total    = 0;

        $new_arr = [];
        $Product = Product::where('slug', $product_slug)->first();
        if ($Product) {
            $product_id = $Product->id;
            $product_slug = $Product->slug;
            $language = $request->language;
            $get_product = Product::where('id', $product_id)
                ->where('product_type', 'lodge')
                ->where('status', 'Active')
                ->first();
            if ($get_product) {
                $get_lodge_arr = [];
                $get_product_lodge_language = ProductLodgeLanguage::where(['product_id' => $product_id])->get();
                if ($adult_qty > 0 || $child_qty > 0 || $infant_qty > 0) {
                    $get_lodge_detail = ProductLodge::where(['product_id' => $product_id, 'id' => $lodge_id])->first();

                    $ProductOptionTaxServiceCharge = ProductOptionTaxServiceCharge::where(['product_id' => $product_id, 'product_option_id' => $lodge_id])->first();
                    if ($ProductOptionTaxServiceCharge) {
                        if ($ProductOptionTaxServiceCharge->service_charge_allowed == 1) {
                            $service_charge = $ProductOptionTaxServiceCharge->service_charge_amount != '' ? ConvertCurrency($ProductOptionTaxServiceCharge->service_charge_amount) : 0;
                        }
                        if ($ProductOptionTaxServiceCharge->tax_allowed == 1) {
                            $tax = $ProductOptionTaxServiceCharge->tax_percentage != '' ? $ProductOptionTaxServiceCharge->tax_percentage : 0;
                        }
                    }

                    if ($get_lodge_detail) {
                        $get_lodge_arr['lodgeID'] = $get_lodge_detail['id'];
                        $get_lodge_arr['title'] = getLanguageTranslate($get_product_lodge_language, $language, $get_lodge_detail['id'], 'title', 'lodge_id');

                        $get_lodge_arr['limit_adult'] = $limitAdult = $get_lodge_detail->adult;
                        $get_lodge_arr['limit_child'] = $limitChild = $get_lodge_detail->child;
                        $get_lodge_arr['limit_infant'] = $limitInfant = $get_lodge_detail->infant;
                        $get_lodge_arr['adult_qty'] = $adult_qty != '' ? $adult_qty : 'N/A';
                        $get_lodge_arr['infant_qty'] = $infant_qty != '' ? $infant_qty : 'N/A';
                        $get_lodge_arr['child_qty'] = $child_qty != '' ? $child_qty : 'N/A';
                        $get_lodge_arr['price'] = $get_lodge_detail['lodge_price'] != '' ?
                            get_partners_dis_price(ConvertCurrency($get_lodge_detail['lodge_price']), $product_id, $request->user_id, 'tour_price', 'lodge')
                            : 0;

                        $dateArr = [];
                        $total_days_room_price =                             get_partners_dis_price(ConvertCurrency($get_lodge_detail['lodge_price']), $product_id, $request->user_id, 'tour_price', 'lodge');
                        $get_price_detail_arr = [];
                        if ($arrival_date != '' && $departure_date != '') {
                            $total_days_room_price = 0;
                            if ($arrival_date == $departure_date) {
                                $dateArr = [$arrival_date];
                            } else {
                                $dateArr = $this->getDatesFromRange($arrival_date, $departure_date);
                            }
                            // $dateArr = $this->getDatesFromRange($arrival_date, $departure_date);
                            foreach ($dateArr as $key => $date) {
                                $get_date_arr = [];
                                $getProductLodgePrice = ProductLodgePrice::where('product_id', $product_id)
                                    ->where('product_lodge_id', $lodge_id)
                                    ->whereDate('from_date', '<=', $date)
                                    ->whereDate('to_date', '>=', $date)
                                    ->orderBy('id', 'desc')
                                    ->first();
                                if ($getProductLodgePrice) {
                                    $get_date_arr['from_date'] = $date;
                                    $get_date_arr['to_date'] = $oldDepartureDate;
                                    $get_date_arr['default_price'] = false;
                                    $get_date_arr['default_title'] = '';
                                    $get_date_arr['price'] = get_partners_dis_price(ConvertCurrency($getProductLodgePrice->price), $product_id, $request->user_id, 'room_details', 'lodge');
                                    $get_date_arr['title'] = $getProductLodgePrice->title;
                                    if (!array_key_exists($getProductLodgePrice->id, $get_price_detail_arr)) {
                                        $get_price_detail_arr[$getProductLodgePrice->id] = $get_date_arr;
                                    } else {
                                        $get_price_detail_arr[$getProductLodgePrice->id]['to_date'] = $oldDepartureDate;
                                    }
                                } else {
                                    $get_date_arr['from_date'] = $date;
                                    $get_date_arr['to_date'] = $oldDepartureDate;
                                    $get_date_arr['price'] = get_partners_dis_price(ConvertCurrency($get_lodge_detail['lodge_price']), $product_id, $request->user_id, 'tour_price', 'lodge');
                                    $get_date_arr['default_price'] = true;
                                    $get_date_arr['default_title'] = 'Default Room Price';
                                    $get_date_arr['title'] = $get_lodge_arr['title'];
                                    if (!array_key_exists($get_lodge_detail['id'], $get_price_detail_arr)) {
                                        $get_price_detail_arr[$get_lodge_detail['id']] = $get_date_arr;
                                    } else {
                                        $get_price_detail_arr[$get_lodge_detail['id']]['to_date'] = $oldDepartureDate;
                                    }
                                }
                                $total_days_room_price += $get_date_arr['price'];
                            }
                        } else {
                            $get_date_arr = [];
                            $get_date_arr['from_date'] = '';
                            $get_date_arr['to_date'] = '';
                            $get_date_arr['price'] = get_partners_dis_price(ConvertCurrency($get_lodge_detail['lodge_price']), $product_id, $request->user_id, 'tour_price', 'lodge');
                            $get_date_arr['default_price'] = true;
                            $get_date_arr['default_title'] = 'Default Room Price';
                            $get_date_arr['title'] = $get_lodge_arr['title'];
                            $get_price_detail_arr[] = $get_date_arr;

                            $getProductLodgePrice = ProductLodgePrice::where('product_id', $product_id)
                                ->where('product_lodge_id', $lodge_id)
                                ->whereDate('from_date', '<=', date('Y-m-d'))
                                ->whereDate('to_date', '>=', date('Y-m-d'))
                                ->orderBy('id', 'desc')
                                ->first();
                            if ($getProductLodgePrice) {
                                $total_days_room_price = get_partners_dis_price(ConvertCurrency($getProductLodgePrice->price), $product_id, $request->user_id, 'room_details', 'lodge');
                            }
                        }

                        $total_nights = count($dateArr);
                        // return $get_price_detail_arr;
                        $new_date_price = [];
                        foreach ($get_price_detail_arr as $price_key => $value_) {
                            $new_date_price[] = $value_;
                        }
                        $get_lodge_arr['date_price'] = array_reverse($new_date_price);
                        $get_lodge_arr['total_days_room_price'] = $total_days_room_price;

                        $totalAdultRoom = 1;
                        $totalChildRoom = 1;
                        $totalInfantRoom = 0;
                        $total_amount = 0;
                        if ($adult_qty > $limitAdult) {
                            $totalAdultRoom = ceil($adult_qty / $limitAdult);
                        }
                        if ($child_qty > $limitChild) {
                            $totalChildRoom = ceil($child_qty / $limitChild);
                        }

                        if ($get_lodge_detail->infant_limit == 0) {
                            if ($infant_qty > $limitInfant) {
                                $totalInfantRoom = ceil($infant_qty / $limitInfant);
                            }
                        }
                        $total_rooms = max($totalAdultRoom, $totalChildRoom, $totalInfantRoom);
                        $get_lodge_arr['total_rooms'] = $total_rooms;
                        $total_amount = $total_days_room_price * $total_rooms;
                        if ($room_qty > $total_rooms) {
                            $total_amount = $total_days_room_price * $room_qty;
                            $get_lodge_arr['total_rooms'] = $room_qty;
                        }
                        $get_lodge_arr['total_amount'] = $total_amount;
                        $total += $total_amount;
                        $new_arr[] = $get_lodge_arr;
                    }
                    if (isset($lodgeUpgrade)) {
                        foreach ($lodgeUpgrade as $key => $LU) {
                            if ($LU['lodge_adult_qty'] > 0 || $LU['lodge_child_qty'] > 0 || $LU['lodge_infant_qty'] > 0) {
                                $upgrade_arr = [];
                                $req_adult_qty = 0;
                                $req_child_qty = 0;
                                $req_infant_qty = 0;
                                $adult_price = $LU['lodge_adult_price'] ?? 0;
                                $child_price = $LU['lodge_child_price'] ?? 0;
                                $infant_price = $LU['lodge_infant_price'] ?? 0;

                                if ($LU['lodge_adult_qty'] > 0) {
                                    $req_adult_qty = $LU['lodge_adult_qty'];
                                }

                                if ($LU['lodge_child_qty'] > 0) {
                                    $req_child_qty = $LU['lodge_child_qty'];
                                }

                                if ($LU['lodge_infant_qty'] > 0) {
                                    $req_infant_qty = $LU['lodge_infant_qty'];
                                }

                                $total_adult_price = $adult_price * $req_adult_qty * $total_nights;
                                $total_child_price = $child_price * $req_child_qty * $total_nights;
                                $total_infant_price = $infant_price * $req_infant_qty * $total_nights;
                                $total_amount += $get_total = $total_adult_price + $total_child_price + $total_infant_price;
                                $upgrade_total += $total_adult_price + $total_child_price + $total_infant_price;

                                $upgrade_arr['title'] = $LU['title'] ?? '';
                                $upgrade_arr['adult_price'] = $adult_price > 0 ? $adult_price : 'N/A';
                                $upgrade_arr['child_price'] = $child_price > 0 ? $child_price : 'N/A';
                                $upgrade_arr['infant_price'] = $infant_price > 0 ? $infant_price : 'N/A';
                                $upgrade_arr['req_adult_qty'] = $req_adult_qty > 0 ? $req_adult_qty : 'N/A';
                                $upgrade_arr['req_child_qty'] = $req_child_qty > 0 ? $req_child_qty : 'N/A';
                                $upgrade_arr['req_infant_qty'] = $req_infant_qty > 0 ? $req_infant_qty : 'N/A';
                                $upgrade_arr['total_adult_price'] = $total_adult_price;
                                $upgrade_arr['total_child_price'] = $total_child_price;
                                $upgrade_arr['total_infant_price'] = $total_infant_price;
                                $upgrade_arr['car_status'] = 0;
                                $upgrade_arr['total'] = $get_total;
                                $new_arr[] = $upgrade_arr;
                            }
                        }
                    }

                    $NewTotal = $total_amount;
                    if ($tax != 0 && $NewTotal != 0) {
                        $tax_amount = ($NewTotal / 100) * $tax;
                    }

                    // $lodge_detail_arr['lodge_detail'][] = $get_lodge_arr;
                    $lodge_detail_arr['lodge_detail'] = $new_arr;

                    $lodge_detail_arr['total_amount']   = $total_amount;
                    $lodge_detail_arr['total']          = $total;
                    $lodge_detail_arr['upgrade_amount'] = $upgrade_total;
                    $lodge_detail_arr['tax']            = $tax_amount;
                    $lodge_detail_arr['tax_percentage'] = $tax;
                    $lodge_detail_arr['service_charge'] = $service_charge;

                    $output['data'] = $lodge_detail_arr;
                    $output['status'] = true;
                    $output['msg'] = 'Data Fetched Successfully...';
                }
            }
        }
        return json_encode($output);
    }


    // Add TO cART
    public function lodge_add_to_cart(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['msg'] = 'Data Not Found';
        $validation = Validator::make($request->all(), [
            'language' => 'required',
            'lodge_id' => 'required',
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

        $lodgeCheck = $request->lodgecheck;

        $child_qty  = 0;
        $adult_qty  = 0;
        $infant_qty = 0;
        $room_qty   = 0;
        $lodge_id   = $request->lodge_id;
        $Product    = Product::where('slug', $lodge_id)->first();
        $product_id = $Product->id;

        $arrival_date     = '';
        $departure_date   = '';
        $oldDepartureDate = '';
        $checkUpgrade     = 0;
        $LodgeData        = $request->data;
        $lodgeUpgradeArr  = [];
        $user_id     = $request->user_id != "" ? checkDecrypt($request->user_id) : 0;
        // return $lodgeCheck;
        if ($lodgeCheck != "") {


            // foreach ($lodgeCheck as $key => $index) {
            //     if ($index == 'false') {
            //         $output['status'] = false;
            //         $output['msg'] = 'Check Any Lodge Option';
            //         break;
            //     }
            // }
            // return $lodgeCheck;
            // $lodgeCheck = \array_diff($lodgeCheck, ["false"]);



            $lodgeCheck = \array_filter($lodgeCheck, static function ($element) {
                return $element !== "false";
                //                   ↑
                // Array value which you want to delete
            });

            foreach ($lodgeCheck as $key => $index) {
                $AllCheck =  0;

                // if ($index == 'false') {
                //     if ($LodgeData[$key]['total_lodge_amount'] > 0) {
                //         $output['status'] = false;
                //         $output['msg'] = 'Check Any Lodge Option';
                //         break;
                //     }
                // }
                $Data = $LodgeData[$key];

                if ($checkUpgrade == 0) {
                    if ($Data['lodge_arrival_date'] != "") {

                        if ($Data['lodge_departure_date'] != "") {

                            $adult_qty = isset($Data['lodge_adult_qty']) ? $Data['lodge_adult_qty'] : 0;
                            $infant_qty = isset($Data['lodge_infant_qty']) ? $Data['lodge_infant_qty'] : 0;
                            $child_qty = isset($Data['lodge_child_qty']) ? $Data['lodge_child_qty'] : 0;

                            $totalQty = $adult_qty + $infant_qty + $child_qty;

                            if ($totalQty > 0) {
                                if ($adult_qty) {
                                    $AllCheck = 1;
                                    $UpgradeData  = isset($Data['lodgeUpgrade']) ? $Data['lodgeUpgrade'] : [];
                                    $alreadyCheck = [];

                                    foreach ($UpgradeData as $udKey => $UPD) {
                                       
                                        if ($UPD['is_check'] == "1") {
                                            $totalUpgradeQty = 0;

                                            $totalUpgradeQty += $UPD['lodge_adult_qty'];
                                            $totalUpgradeQty += $UPD['lodge_child_qty'];
                                            $totalUpgradeQty += $UPD['lodge_infant_qty'];
                                            $alreadyCheck[] = $UPD['id'];

                                            if ($totalUpgradeQty > 0) {
                                                $checkUpgrade = 0;
                                                $AllCheck = 1;
                                            } else {
                                                $AllCheck = 0;
                                                $checkUpgrade = 1;
                                                $output['status'] = false;
                                                $output['msg'] = 'Select Lodge Upgrade Adult,Child Or Infant';
                                                // print_die($totalUpgradeQty);
                                                break;
                                            }
                                        } else {
                                            $checkUpgrade = 0;
                                            $AllCheck = 1;
                                        }
                                    }
                                    
                                } else {
                                    $output['status'] = false;
                                    $output['msg']    = 'Select Any Adult';
                                    break;
                                }
                            } else {
                                $output['status'] = false;
                                $output['msg'] = 'Select Any Adult,Child Or Infant';
                                break;
                            }
                        } else {
                            $output['status'] = false;
                            $output['msg'] = 'Select Lodge Departure  Date';
                            break;
                        }
                    } else {

                        $output['status'] = false;
                        $output['msg'] = 'Select Lodge Arrival Date';
                        break;
                    }
                } else {

                    $output['status'] = false;
                    $output['msg'] = 'Select Lodge Upgrade Adult,Child Or Infant';
                    break;
                }
            }


            if ($AllCheck == 1) {
                $AddToCart                   = new AddToCart();
                foreach ($lodgeCheck as $key => $index) {
                    $get_upgrade_arr = [];
                    $Data = $LodgeData[$key];

                    $get_upgrade_arr['lodge_option_id']      = $key;
                    $get_upgrade_arr['lodge_option_adult']   = isset($Data['lodge_adult_qty']) ? $Data['lodge_adult_qty'] : 0;
                    $get_upgrade_arr['lodge_option_child']   = isset($Data['lodge_child_qty']) ? $Data['lodge_child_qty'] : 0;
                    $get_upgrade_arr['lodge_option_infant']  = isset($Data['lodge_infant_qty']) ? $Data['lodge_infant_qty'] : 0;
                    $get_upgrade_arr['no_of_rooms']          = isset($Data['room_qty']) ? $Data['room_qty'] : $Data['lodge_qty'];
                    $get_upgrade_arr['lodge_arrival_date']   = $Data['lodge_arrival_date'];
                    $get_upgrade_arr['lodge_departure_date'] = $Data['lodge_departure_date'];

                    if (isset($index['lodge_upgrade_check'])) {

                        foreach ($index['lodge_upgrade_check'] as $ukey => $LUC) {
                            $totalUpgradeQty = 0;
                            if ($LUC) {

                                $UpgradeData = $Data['lodgeUpgrade'];
                                foreach ($UpgradeData as $udKey => $UPD) {
                                    $get_lodge_upgrade_arr = [];
                                    if ($UPD['id'] == $ukey) {
                                        if ($UPD['lodge_adult_qty'] > 0 || $UPD['lodge_child_qty'] > 0 || $UPD['lodge_infant_qty'] > 0) {
                                            $get_lodge_upgrade_arr['lodge_adult_qty']  = $UPD['lodge_adult_qty'];
                                            $get_lodge_upgrade_arr['lodge_child_qty']  = $UPD['lodge_child_qty'];
                                            $get_lodge_upgrade_arr['lodge_infant_qty'] = $UPD['lodge_infant_qty'];
                                            $get_lodge_upgrade_arr['upgrade_id']       = $UPD['id'];
                                            $get_upgrade_arr['lodgeupgrade'][]         = $get_lodge_upgrade_arr;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $lodgeUpgradeArr[] = $get_upgrade_arr;
                }

                $AddToCart['product_id']     = $product_id;
                $AddToCart['product_type']   = "lodge";
                $AddToCart['user_id']        = $user_id;
                $AddToCart['service_charge'] = $Data['service_charge'];
                $AddToCart['tax']            = $Data['tax'];
                $AddToCart['tax_percentage'] = $Data['tax_percentage'];
                $AddToCart['upgrade_amount'] = $Data['upgrade_amount'];
                $AddToCart['lodge_amount']   = $Data['total_lodge_amount'];
                $AddToCart['token']          = $request->token;
                $AddToCart['extra']          = json_encode($lodgeUpgradeArr);
                $AddToCart['status']         = "Active";
                $AddToCart['total']          = $Data['total_lodge_amount'] + $Data['tax'] + $Data['service_charge'] + $Data['upgrade_amount'];



                // return $AddToCart;
                $AddToCart->save();
                $output['status'] = true;
                $output['msg'] = 'Add To Cart Successfully...';
            }
        } else {
            $output['status'] = false;
            $output['msg'] = 'Check Any Lodge Option';
        }
        return json_encode($output);
    }

    //Lodge Request
    public function lodge_request(Request $request)
    {

        $output = [];
        $output['status'] = false;
        $output['msg'] = 'Data Not Found';
        $validation = Validator::make($request->all(), [
            'language' => 'required',
            'lodge_id' => 'required',
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

        $lodgeCheck = $request->lodgecheck;

        $child_qty  = 0;
        $adult_qty  = 0;
        $infant_qty = 0;
        $room_qty   = 0;
        $lodge_id   = $request->lodge_id;
        $Product    = Product::where('slug', $lodge_id)->first();
        $product_id = $Product->id;

        $arrival_date     = '';
        $departure_date   = '';
        $oldDepartureDate = '';
        $checkUpgrade     = 0;
        $LodgeData        = $request->data;
        $lodgeUpgradeArr  = [];
        $user_id     = $request->user_id != "" ? checkDecrypt($request->user_id) : 0;
        // return $lodgeCheck;
        if ($lodgeCheck != "") {


            // foreach ($lodgeCheck as $key => $index) {
            //     if ($index == 'false') {
            //         $output['status'] = false;
            //         $output['msg'] = 'Check Any Lodge Option';
            //         break;
            //     }
            // }
            // return $lodgeCheck;
            // $lodgeCheck = \array_diff($lodgeCheck, ["false"]);



            $lodgeCheck = \array_filter($lodgeCheck, static function ($element) {
                return $element !== "false";
                //                   ↑
                // Array value which you want to delete
            });

            foreach ($lodgeCheck as $key => $index) {
                $AllCheck =  0;

                // if ($index == 'false') {
                //     if ($LodgeData[$key]['total_lodge_amount'] > 0) {
                //         $output['status'] = false;
                //         $output['msg'] = 'Check Any Lodge Option';
                //         break;
                //     }
                // }
                $Data = $LodgeData[$key];

                if ($checkUpgrade == 0) {
                    if ($Data['lodge_arrival_date'] != "") {

                        if ($Data['lodge_departure_date'] != "") {

                            $adult_qty = isset($Data['lodge_adult_qty']) ? $Data['lodge_adult_qty'] : 0;
                            $infant_qty = isset($Data['lodge_infant_qty']) ? $Data['lodge_infant_qty'] : 0;
                            $child_qty = isset($Data['lodge_child_qty']) ? $Data['lodge_child_qty'] : 0;

                            $totalQty = $adult_qty + $infant_qty + $child_qty;

                            if ($totalQty > 0) {
                                if ($adult_qty) {

                                    $UpgradeData  = isset($Data['lodgeUpgrade']) ? $Data['lodgeUpgrade'] : [];
                                    $alreadyCheck = [];
                                    foreach ($UpgradeData as $udKey => $UPD) {

                                        if ($UPD['is_check'] == "1") {
                                            $totalUpgradeQty = 0;

                                            $totalUpgradeQty += $UPD['lodge_adult_qty'];
                                            $totalUpgradeQty += $UPD['lodge_child_qty'];
                                            $totalUpgradeQty += $UPD['lodge_infant_qty'];
                                            $alreadyCheck[] = $UPD['id'];


                                            if ($totalUpgradeQty > 0) {
                                                $checkUpgrade = 0;
                                                $AllCheck = 1;
                                            } else {
                                                $AllCheck = 0;
                                                $checkUpgrade = 1;
                                                $output['status'] = false;
                                                $output['msg'] = 'Select Lodge Upgrade Adult,Child Or Infant';
                                                break;
                                            }
                                        } else {
                                            $checkUpgrade = 0;
                                            $AllCheck = 1;
                                        }
                                    }
                                } else {
                                    $output['status'] = false;
                                    $output['msg']    = 'Select Any Adult';
                                    break;
                                }
                            } else {
                                $output['status'] = false;
                                $output['msg'] = 'Select Any Adult,Child Or Infant';
                                break;
                            }
                        } else {
                            $output['status'] = false;
                            $output['msg'] = 'Select Lodge Departure  Date';
                            break;
                        }
                    } else {

                        $output['status'] = false;
                        $output['msg'] = 'Select Lodge Arrival Date';
                        break;
                    }
                } else {
                    print_r($Data);
                    $output['status'] = false;
                    $output['msg'] = 'Select Lodge Upgrade Adult,Child Or Infant';
                    break;
                }
            }


            if ($AllCheck == 1) {
                $ProductRequestForm                   = new ProductRequestForm();
                foreach ($lodgeCheck as $key => $index) {
                    $get_upgrade_arr = [];
                    $Data = $LodgeData[$key];

                    $get_upgrade_arr['lodge_option_id']      = $key;
                    $get_upgrade_arr['lodge_option_adult']   = isset($Data['lodge_adult_qty']) ? $Data['lodge_adult_qty'] : 0;
                    $get_upgrade_arr['lodge_option_child']   = isset($Data['lodge_child_qty']) ? $Data['lodge_child_qty'] : 0;
                    $get_upgrade_arr['lodge_option_infant']  = isset($Data['lodge_infant_qty']) ? $Data['lodge_infant_qty'] : 0;
                    $get_upgrade_arr['no_of_rooms']          = isset($Data['room_qty']) ? $Data['room_qty'] : $Data['lodge_qty'];
                    $get_upgrade_arr['lodge_arrival_date']   = $Data['lodge_arrival_date'];
                    $get_upgrade_arr['lodge_departure_date'] = $Data['lodge_departure_date'];

                    if (isset($index['lodge_upgrade_check'])) {

                        foreach ($index['lodge_upgrade_check'] as $ukey => $LUC) {
                            $totalUpgradeQty = 0;
                            if ($LUC) {

                                $UpgradeData = $Data['lodgeUpgrade'];
                                foreach ($UpgradeData as $udKey => $UPD) {
                                    $get_lodge_upgrade_arr = [];
                                    if ($UPD['id'] == $ukey) {
                                        if ($UPD['lodge_adult_qty'] > 0 || $UPD['lodge_child_qty'] > 0 || $UPD['lodge_infant_qty'] > 0) {
                                            $get_lodge_upgrade_arr['lodge_adult_qty']  = $UPD['lodge_adult_qty'];
                                            $get_lodge_upgrade_arr['lodge_child_qty']  = $UPD['lodge_child_qty'];
                                            $get_lodge_upgrade_arr['lodge_infant_qty'] = $UPD['lodge_infant_qty'];
                                            $get_lodge_upgrade_arr['upgrade_id']       = $UPD['id'];
                                            $get_upgrade_arr['lodgeupgrade'][]         = $get_lodge_upgrade_arr;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $lodgeUpgradeArr[] = $get_upgrade_arr;
                }

                $ProductRequestForm['product_id']     = $product_id;
                $ProductRequestForm['product_type']   = "lodge";
                $ProductRequestForm['user_id']        = $user_id;
                $ProductRequestForm['service_charge'] = $Data['service_charge'];
                $ProductRequestForm['tax']            = $Data['tax'];
                $ProductRequestForm['tax_percentage'] = $Data['tax_percentage'];
                $ProductRequestForm['upgrade_amount'] = $Data['upgrade_amount'];
                $ProductRequestForm['lodge_amount']   = $Data['total_lodge_amount'];
                $ProductRequestForm['token']          = $request->token;
                $ProductRequestForm['extra']          = json_encode($lodgeUpgradeArr);
                $ProductRequestForm['status']         = "Active";
                $ProductRequestForm['total']          = $Data['total_lodge_amount'] + $Data['tax'] + $Data['service_charge'] + $Data['upgrade_amount'];

                $ProductRequestForm->save();
                $output['status'] = true;
                $output['msg'] = 'Request Add Successfully...';
            }
        } else {
            $output['status'] = false;
            $output['msg'] = 'Check Any Lodge Option';
        }
        return json_encode($output);
    }
}
