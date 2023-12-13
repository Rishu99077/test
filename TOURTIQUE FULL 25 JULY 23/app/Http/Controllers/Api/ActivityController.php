<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarDetails;
use App\Models\Language;
use App\Models\Product;
use App\Models\ProductAdditionalInfoLanguage;
use App\Models\ProductAddtionalInfo;
use App\Models\ProductFaqLanguage;
use App\Models\ProductFaqs;
use App\Models\ProductGroupPercentage;
use App\Models\ProductGroupPercentageDetails;
use App\Models\ProductGroupPercentageLanguage;
use App\Models\ProductHighlightLanguage;
use App\Models\ProductHighlights;
use App\Models\ProductImages;
use App\Models\ProductInfo;
use App\Models\ProductLanguage;
use App\Models\ProductLodge;
use App\Models\ProductLodgeLanguage;
use App\Models\ProductOptionDetails;
use App\Models\ProductCategory;
use App\Models\OverRideBanner;
use App\Models\ProductOptionGroupPercentage;
use App\Models\ProductOptionLanguage;
use App\Models\ProductOptionPeriodPricing;
use App\Models\ProductOptionPrivateTourPrice;
use App\Models\ProductOptions;
use App\Models\ProductOptionTaxServiceCharge;
use App\Models\ProductOptionTourUpgrade;
use App\Models\ProductOptionWeekTour;
use App\Models\ProductPrivateTransferCars;
use App\Models\ProductSiteAdvertisement;
use App\Models\ProductSiteAdvertisementLanguage;
use App\Models\ProductTimings;
use App\Models\ProductToolTipLanguage;
use App\Models\ProductTourPriceDetails;
use App\Models\OverRideBannerLanguage;
use App\Models\Wishlist;
use App\Models\Timing;
use App\Models\AddToCart;
use App\Models\Category;
use App\Models\ProductRequestForm;
use App\Models\UserReview;
use App\Models\User;
use App\Models\Customers;
use App\Models\ProuductCustomerGroupDiscount;
use App\Models\MetaGlobalLanguage;
use App\Models\CarDetailLanguage;

use App\Models\ProductExprienceIcon;
use App\Models\ProductExprienceIconLanguage;

use App\Models\Productyachtrelatedboats;
use DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ActivityController extends Controller
{
    // activity Product List
    public function activity_product_list(Request $request)
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
        $language     = $request->language;
        $setLimit     = 9;
        $offset       = $request->offset;
        $limit        = $offset * $setLimit;
        $is_filter    = false;
        $ProductCount = Product::select('products.*')
            ->join('product_language', 'product_language.product_id', '=', 'products.id')
            ->join('product_categories', 'product_categories.product_id', '=', 'products.id')
            ->where(['status' => 'Active', 'is_delete' => 0, 'product_type' => 'excursion'])
            ->where('product_language.language_id', $language)

            ->where('slug', '!=', '');

        $Product = Product::select('products.*')
            ->join('product_language', 'product_language.product_id', '=', 'products.id')
            ->join('product_categories', 'product_categories.product_id', '=', 'products.id')
            ->where(['status' => 'Active', 'is_delete' => 0, 'product_type' => 'excursion'])
            ->where('product_language.language_id', $language)
            ->where('slug', '!=', '');
        if (isset($request->country)) {
            $is_filter = true;
            $country   = $request->country;
            if ($country > 0 && $country != '') {
                $ProductCount = $ProductCount->where('country', $country);
                $Product      = $Product->where('country', $country);
            }
        }

        if (isset($request->city)) {
            $is_filter = true;
            $city = $request->city;
            if ($city > 0 && $city != '' && is_numeric($city)) {

                $ProductCount = $ProductCount->where('city', $city);
                $Product = $Product->where('city', $city);
            }
        }

        if (isset($request->name)) {
            $is_filter = true;
            $name = $request->name;

            if ($name != '') {
                $ProductCount = $ProductCount->where('product_language.description', 'like', '%' . $name . '%');
                $Product = $Product->where('product_language.description', 'like', '%' . $name . '%');
            }
        }




        $CategoryProduct = $Product;
        $output['categories'] = [];
        $CategoryProductArr = [];

        if ($is_filter) {
            $CategoryProduct = $CategoryProduct->get();
            $categoryArr = [];
            foreach ($CategoryProduct as $ckey => $CP) {
                $ProductCategory = ProductCategory::where('product_id', $CP['id'])->get();
                foreach ($ProductCategory as $pkey => $PC) {
                    $getArr = [];
                    $Category = Category::select('categories.*', 'category_language.description as name')
                        ->where('categories.id', $PC['category'])
                        ->where('categories.status', 'Active')
                        ->join('category_language', 'categories.id', '=', 'category_language.category_id')
                        ->first();

                    if ($Category != '' && !in_array($PC['category'], $categoryArr)) {
                        $CategoryProductArr[] = $Category;
                        $categoryArr[] = $PC['category'];
                    }
                }
            }
        }
        $output['categories'] = $CategoryProductArr;

        if (isset($request->checkedCategory)) {
            $is_filter = true;
            $checkedCategory = $request->checkedCategory;
            $Product = $Product->where(function ($data) use ($checkedCategory) {
                foreach ($checkedCategory as $IBL => $case) {
                    if ($case == 'true') {
                        $Product = $data->orWhere('product_categories.category', $IBL);
                        $ProductCount = $data->orWhere('product_categories.category', $IBL);
                    }
                }
            });
        }

        if (isset($request->checkedSubCategory)) {
            $is_filter = true;
            $checkedSubCategory = $request->checkedSubCategory;
            $Product = $Product->where(function ($data) use ($checkedSubCategory) {
                foreach ($checkedSubCategory as $IBL => $case) {
                    if ($case == 'true') {
                        $Product = $data->orWhere('product_categories.sub_category', $IBL);
                        $ProductCount = $data->orWhere('product_categories.sub_category', $IBL);
                    }
                }
            });
        }
        // return $Product->get();

        $ProductCount = $Product
            ->orderBy('id', 'DESC')
            ->groupBy('product_categories.product_id')
            ->get();



        $Product = $Product
            ->orderBy('id', 'DESC')
            ->offset($limit)
            ->groupBy('product_categories.product_id')
            ->limit($setLimit)

            ->get();

        $ProductCount = $ProductCount->count();

        //       echo "<pre>"; 
        // print_r($Product);
        // echo "</pre>";die();


        $ProductArr = [];
        $product_id_arr = [];
        $output['page_count'] = ceil($ProductCount / $setLimit);
        foreach ($Product as $key => $P) {
            $product_id_arr[] = $P['id'];
            $productLang = ProductLanguage::where(['product_id' => $P['id'], 'language_id' => $language])->first();
            $title = '';
            $short_description = '';
            $main_description  = '';
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
            // return $duration;
            $dura = '';
            foreach ($duration as $k => $D) {
                if ($k < 3) {
                    if ($k == 0) {
                        $val = 'D ';
                    } elseif ($k == 1) {
                        $val = 'H ';
                    } elseif ($k == 2) {
                        $val = 'M ';
                    }
                    if ($D > 0) {
                        $dura .= $D . $val;
                    }
                }
            }
            $duration                           = $dura . $approx;
            $city                               = getAllInfo('cities', ['id' => $P['city']], 'name');
            $getProductArr                      = [];
            $getProductArr['id']                = $P['id'];
            $getProductArr['image']             = $P['image']              != '' ? asset('public/uploads/product_images/' . $P['image']) : asset('public/assets/img/no_image.jpeg');
            $getProductArr['name']              = short_description_limit($title, 55);
            $getProductArr['full_name']         = $title;
            $getProductArr['short_description'] = short_description_limit($short_description, 50);
            $getProductArr['main_description']  = Str::limit($main_description, 60);
            $getProductArr['duration']          = $duration;
            $getProductArr['city']              = $city;
            $getProductArr['slug']              = $P['slug'];
            $getProductArr['total_sold']        = $P['how_many_are_sold'] !== '' ? $P['how_many_are_sold'] : 0;
            $getProductArr['per_value']         = $P['per_value'];
            $getProductArr['image_text']        = $P['image_text'] ?? null;
            $getProductArr['price']             = $P['original_price'] ?? 0;
            $getProductArr['selling_price']     = $P['selling_price'] ?? 0;
            // $getProductArr['price_html'] = get_price_front($P['id']);
            $getProductArr['price_html']        = get_price_front($P['id'], $request->user_id, 'excursion');

            $getProductArr['ratings'] = get_rating($P['id']);

            // Partner
            // $user_id = $request->user_id;
            // if ($user_id) {

            //     $get_partner = User::where(['id' => $user_id, 'user_type' => 'Partner'])->first();
            //     if ($get_partner) {
            //         $customer_group = $get_partner['customer_group'];
            //         if ($customer_group) {
            //             $customer_group_discount = ProuductCustomerGroupDiscount::where(['product_id' => $P['id'], 'customer_group_id' => $customer_group, 'type' => 'excursion'])->first();

            //             if ($customer_group_discount) {
            //                 $base_price_percent = $customer_group_discount['base_price'];

            //                 $dicounted_amount  =  ($base_price_percent / 100) * $P['selling_price'];

            //                 if ($dicounted_amount) {
            //                     $getProductArr['partner_original_price'] = $P['selling_price'] ?? 0;

            //                     $getProductArr['partner_selling_price'] = $P['selling_price'] - $dicounted_amount;
            //                 }
            //             }
            //         }
            //     }
            // }
            // Partner


            $getProductArr['button'] = $P['product_bookable_type'] === 'bookable' ? 'Book Now' : 'On Request';
            $ProductArr[] = $getProductArr;
        }

        $output['slider_categories'] = [];
        $get_categories = ProductCategory::whereIn('product_id', $product_id_arr)
            ->groupby('category')
            ->get();
        foreach ($get_categories as $gckey => $gc_value) {
            $Category = Category::select('categories.*', 'category_language.description as name')
                ->where('categories.id', $gc_value['category'])
                ->where('categories.status', 'Active')
                ->join('category_language', 'categories.id', '=', 'category_language.category_id')
                ->first();
            if ($Category) {
                $get_cat = [];
                $get_cat['id'] = $Category['id'];
                $get_cat['title'] = $Category['name'];
                $get_cat['slug'] = $Category['slug'];
                $get_cat['image'] = $Category['icon'] != '' ? asset('public/uploads/category/' . $Category['icon']) : asset('public/assets/img/no_image.jpg');
                $output['slider_categories'][] = $get_cat;
            }
        }

        $output['count'] = $ProductCount;
        $output['data'] = $ProductArr;
        $output['status'] = true;
        $output['msg'] = 'Data Fetched Successfully...';
        return json_encode($output);
    }

    // Get Dates Range
    public function getDatesFromRange($start, $end, $format = 'Y-m-d')
    {
        return array_map(function ($timestamp) use ($format) {
            return date($format, $timestamp);
        }, range(strtotime($start) + ($start < $end ? 4000 : 8000), strtotime($end) + ($start < $end ? 8000 : 4000), 86400));
    }




    // Activity Details
    public function activity_details(Request $request)
    {
        $output = [];
        $output['status'] = false;
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
        $output['data'] = $output;
        $activity_id    = $request->activity_id;
        $language       = $request->language;
        $Product        = Product::where('slug', $activity_id)->first();
        $productDeatils = [];
        if ($Product) {
            $activity_id    = $Product->id;
            //Price
            $productDeatils['price_html']         = get_price_front_detail($Product['id'], $request->user_id, $Product['product_type']);
            //Price


            //Wishlist Check Strt
            $productDeatils['ratings']            = get_rating($Product['id']);
            $productDeatils['total_rating_count'] = DB::table('user_review')->where('product_id', $Product['id'])->count();
            $productDeatils['total_ratings']      = get_ratings_count($Product['id']);
            $productDeatils['isWishlist']         = false;
            $productDeatils['generated_link']     = '';
            if ($request->user_id) {
                $user_id     = checkDecrypt($request->user_id);
                $getWishlist = Wishlist::where('user_id', $user_id)->where('product_id', $activity_id)->first();
                if ($getWishlist) {
                    $productDeatils['isWishlist'] = true;
                }
                $productDeatils['generated_link'] = generate_product_link("affilliate_generated_links", $Product['id'], $user_id, "activities-detail");
            }
            //Wishlist Check End

            $from_date = '';
            $to_date   = '';
            if ($Product->note_on_sale_date != '') {
                $dateArr = explode('to', $Product->note_on_sale_date);
                if (isset($dateArr[0]) && isset($dateArr[1])) {
                    $from_date = trim($dateArr[0]);
                    $to_date   = trim($dateArr[1]);
                }
            }
            $category       = $Product->category;
            $catArr         = explode(',', $category);
            $catArr         = array_unique($catArr);
            $newCategory    = '';

            $categrory_slug = [];
            $coma           = ' >> ';
            $coma1          = ' ';
            $class          = "";

            foreach ($catArr as $Ckey => $Cvalue) {

                if ($Ckey == count($catArr) - 1) {
                    if (count($catArr) > 1) {
                        $class          = "d-block";
                    }
                    $coma = ' >> ';
                    $coma1           = '';
                } else {
                    if ($Ckey > 0) {
                        $class          = "d-block";
                    }
                }

                $category_arr                  = [];
                $newCategory .= getAllInfo('category_language', ['category_id' => $Cvalue, 'language_id' => $language], 'description') . $coma;
                $ProductCategoryarr = ProductCategory::where(["category" => $Cvalue, 'product_id' => $activity_id])->groupBy('category')->get();
                // return $ProductCategoryarr->toArray();

                foreach ($ProductCategoryarr as $PCA) {
                    $newSubCategory    = '';
                    $SubcatArr         = ProductCategory::where(["category" => $Cvalue, 'product_id' => $activity_id])->get();
                    if (count($SubcatArr) > 0) {
                        foreach ($SubcatArr as $skey => $SCA) {
                            if ($skey == count($SubcatArr) - 1) {
                                $newcoma = $coma1;
                            } else {
                                $newcoma = ' / ';
                            }
                            $sub_category_arr                  = [];
                            $newSubCategory .= getAllInfo('category_language', ['category_id' => $SCA['sub_category'], 'language_id' => $language], 'description') . $newcoma;
                            $newCategory .= $newSubCategory;
                        }
                    }
                }


                $category_arr['category_name'] =  '<span class=' . $class   . '>' . getAllInfo('category_language', ['category_id' => $Cvalue, 'language_id' => $language], 'description');
                if (count($ProductCategoryarr) > 0 && $newSubCategory != "") {
                    $category_arr['category_name'] .= $coma . '<span style="color:#baad85;">' . $newSubCategory . '</span>' . '</span>';
                }
                $category_arr['category_slug'] = getAllInfo('categories', ['id' => $Cvalue], 'slug');
                $categrory_slug[]              = $category_arr;
            }
            $productDeatils['categrory_slug'] = $categrory_slug;

            $description_heading =  MetaGlobalLanguage::where('product_id', $activity_id)->where('meta_title', 'excursion_description_title')
                ->where('language_id', $language)
                ->where('status', 'Active')
                ->first();
            if ($description_heading) {
                $productDeatils['description_heading'] = $description_heading['title'];
            } else {
                $productDeatils['description_heading'] = '';
            }


            $currentDateTime = Carbon::now();
            $bookable_up_to  = '';
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
                $period         = CarbonPeriod::create(Carbon::now(), $currentDateTime);
                $bookable_up_to = collect();
                foreach ($period as $date) {
                    $bookable_up_to->add($date->format('Y-m-d'));
                }
            }
            $productLang   = ProductLanguage::where(['product_id' => $activity_id])->get();
            $ll  = getLanguageTranslate($productLang, $language, $activity_id, 'description', 'product_id');
            $productImages = ProductImages::where(['product_id' => $activity_id])
                ->orderBy('sort_order_images', 'asc')
                ->get()->toArray();
            $ProductDetails = (array) $Product->toArray();
            // Highlight Code
            $ProductHighlights        = ProductHighlights::where(['product_id' => $activity_id])->get();
            $ProductHighlightLanguage = ProductHighlightLanguage::where(['product_id' => $activity_id])->get();
            $title                    = '';
            $main_description         = '';
            $extra_option_note        = '';
            $option_note              = '';
            $booking_policy           = '';
            $related_product_title    = '';
            if (!$productLang->isEmpty()) {
                foreach ($productLang as $key => $value_lang) {
                    $title             = $ll;
                    $main_description  = $value_lang->main_description;
                    $extra_option_note = $value_lang->extra_option_note;
                    $option_note       = $value_lang->option_note;
                    $booking_policy    = $value_lang->booking_policy;
                    $related_product_title  = $value_lang->related_product_title;
                }
            }
            $ProductHighlightsArr = [];
            foreach ($ProductHighlights as $key => $PH) {
                $getProductHighlight = [];
                $hightitle = getLanguageTranslate($ProductHighlightLanguage, $language, $PH['id'], 'title', 'highlight_id');
                if ($hightitle != '') {
                    $getProductHighlight['title']       = getLanguageTranslate($ProductHighlightLanguage, $language, $PH['id'], 'title', 'highlight_id');
                    $getProductHighlight['description'] = getLanguageTranslate($ProductHighlightLanguage, $language, $PH['id'], 'description', 'highlight_id');
                    $ProductHighlightsArr[]             = $getProductHighlight;
                }
            }
            // Product Timing Code
            $ProductTimingsArr = [];
            $checkDaily = 0;
            if ($Product->timing_status == 1) {
                $ProductTimings = ProductTimings::where(['product_id' => $activity_id])->get();

                foreach ($ProductTimings as $timeKey => $PT) {
                    if ($PT['time_from'] != '' && $PT['time_to'] != '') {
                        $getProductTiming = [];
                    }
                    $getProductTimingDaily = [];
                    if ($PT['day'] == "Daily") {
                        if ($PT['is_close'] == 0) {
                            $checkDaily = 1;

                            $getProductTimingDaily['day'] = $PT['day'];
                            if ($PT['time_from'] != '' && $PT['time_to'] != '') {
                                $getProductTimingDaily['time_from'] = date('g:i a', strtotime($PT['time_from']));
                                $getProductTimingDaily['time_to'] = date('g:i a', strtotime($PT['time_to']));
                            } else {
                                $getProductTimingDaily['time_from'] = '5:30 am';
                                $getProductTimingDaily['time_to'] = '5:30 pm';
                            }
                            $getProductTimingDaily['is_close'] = $PT['is_close'];
                        }
                    } else {
                        if ($PT['time_from'] != '' && $PT['time_to'] != '') {
                            $getProductTiming['day'] = $PT['day'];
                            $getProductTiming['time_from'] = date('g:i a', strtotime($PT['time_from']));
                            $getProductTiming['time_to'] = date('g:i a', strtotime($PT['time_to']));
                            $getProductTiming['is_close'] = $PT['is_close'];
                        }
                    }
                    if ($checkDaily == 1) {
                        $ProductTimingsArr = [];
                        $ProductTimingsArr[] = $getProductTimingDaily;
                        break;
                    } else {
                        if ($PT['time_from'] != '' && $PT['time_to'] != '') {
                            $ProductTimingsArr[] = $getProductTiming;
                        }
                    }
                }
            }
            // Product Additinal information
            $ProductAddtionalInfo          = ProductAddtionalInfo::where(['product_id' => $activity_id])->get();
            $ProductAdditionalInfoLanguage = ProductAdditionalInfoLanguage::where(['product_id' => $activity_id])->get();
            $ProductAdditionalInfoArr      = [];
            foreach ($ProductAddtionalInfo as $PAIkey => $PAI) {
                $getProductAdditionalInfo = [];
                $addtitle = getLanguageTranslate($ProductAdditionalInfoLanguage, $language, $PAI['id'], 'description', 'product_additional_info_id');
                if ($addtitle != '') {
                    $getProductAdditionalInfo['title'] = $addtitle;
                    $file                              = '';
                    if ($PAI['image'] != '') {
                        $file = asset('uploads/product/' . $PAI['image']);
                    }
                    $getProductAdditionalInfo['file'] = $file;
                    $ProductAdditionalInfoArr[]       = $getProductAdditionalInfo;
                }
            }
            // Product Site Advertisement
            $ProductSiteAdvertisement         = ProductSiteAdvertisement::where(['product_id' => $activity_id])->get();
            $ProductSiteAdvertisementLanguage = ProductSiteAdvertisementLanguage::where(['product_id' => $activity_id])->get();
            $ProductSiteAdvertisementArr      = [];

            $OverRideBanner = OverRideBanner::select('over_ride_banner.*')->whereRaw('FIND_IN_SET(?, country)', [$Product->country])
                ->join('over_ride', 'over_ride.id', '=', 'over_ride_banner.over_ride_id')
                ->where(['over_ride.status' => 'Active', 'is_delete' => 0])
                ->get();


            foreach ($ProductSiteAdvertisement as $PSAkey => $PSA) {
                $getProductSiteAdver = [];
                $sitetitle           = getLanguageTranslate($ProductSiteAdvertisementLanguage, $language, $PSA['id'], 'title', 'site_advertisement_id');
                if ($sitetitle != '') {
                    $getProductSiteAdver['title']       = getLanguageTranslate($ProductSiteAdvertisementLanguage, $language, $PSA['id'], 'title', 'site_advertisement_id');
                    $getProductSiteAdver['description'] = getLanguageTranslate($ProductSiteAdvertisementLanguage, $language, $PSA['id'], 'description', 'site_advertisement_id');
                    $file                               = '';
                    if ($PSA['image'] != '') {
                        $file = asset('uploads/product/' . $PSA['image']);
                    }
                    $getProductSiteAdver['file']   = $file;
                    $getProductSiteAdver['link56']   = $PSA['link'];
                    $getProductSiteAdver['link']   = $PSA['link'];
                    $ProductSiteAdvertisementArr[] = $getProductSiteAdver;
                }
            }


            $OverRideBannerArr = [];
            foreach ($OverRideBanner as $ORB) {
                $OverRideBannerLanguage = OverRideBannerLanguage::where(['over_ride_id' => $ORB['over_ride_id']])->get();

                $getProductSiteAdver = [];
                $sitetitle = getLanguageTranslate($OverRideBannerLanguage, $language, $ORB['id'], 'banner_title', 'over_ride_banner_id');
                if ($sitetitle != '') {
                    $getProductSiteAdver['title'] = getLanguageTranslate($OverRideBannerLanguage, $language, $ORB['id'], 'banner_title', 'over_ride_banner_id');
                    $getProductSiteAdver['description'] = getLanguageTranslate($OverRideBannerLanguage, $language, $ORB['id'], 'banner_description', 'over_ride_banner_id');
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

            // Product Frequently Asked Question
            $ProductFaqs = ProductFaqs::where(['product_id' => $activity_id])->get();
            $ProductFaqLanguage = ProductFaqLanguage::where(['product_id' => $activity_id])->get();
            $ProductFAQArr = [];
            foreach ($ProductFaqs as $PFkey => $PF) {
                $getProductFAQ = [];
                $faqtitle = getLanguageTranslate($ProductFaqLanguage, $language, $PF['id'], 'question', 'faq_id');
                if ($faqtitle != '') {
                    $getProductFAQ['question'] = getLanguageTranslate($ProductFaqLanguage, $language, $PF['id'], 'question', 'faq_id');
                    $getProductFAQ['answer'] = getLanguageTranslate($ProductFaqLanguage, $language, $PF['id'], 'answer', 'faq_id');
                    $ProductFAQArr[] = $getProductFAQ;
                }
            }
            // Product Images Code
            $imagesArr = [];
            foreach ($productImages as $PI) {
                $imagesArr[] = asset('uploads/product_images/' . $PI['product_images']);
            }
            // Product Tool Tip
            $get_tool_tip = [];
            $get_product_tool_tip = ProductToolTipLanguage::where('product_id', $activity_id)
                ->where('language_id', $language)
                ->get();
            foreach ($get_product_tool_tip as $tool_tip_key => $tool_tip_value) {
                $get_tool_tip[$tool_tip_value['tooltip_title']] = $tool_tip_value['tooltip_description'];
            }

            $productDeatils['tour_option_heading'] = '';
            $heading_title     = MetaGlobalLanguage::where('product_id', $activity_id)->where('meta_parent', 'tour_option_heading')
                ->where('meta_title', 'heading_title')
                ->where('language_id', $language)
                ->where('product_id', $activity_id)
                ->first();

            if ($heading_title) {
                $productDeatils['tour_option_heading'] = $heading_title['title'] != '' ? $heading_title['title'] : '';
            }


            // Product Option Code
            $ProductOptions = ProductOptions::where(['product_id' => $activity_id, 'is_private_tour' => 0])->get();
            $ProductOptionLanguage = ProductOptionLanguage::where(['product_id' => $activity_id])->get();
            $ProductOptionArr = [];
            foreach ($ProductOptions as $POkey => $PO) {
                $product_option_title = getLanguageTranslate($ProductOptionLanguage, $language, $PO['id'], 'title', 'option_id');
                if ($product_option_title) {

                    $getProductOption                      = [];
                    $ProductTourPriceDetails               = ProductTourPriceDetails::where(['product_id' => $activity_id, 'product_option_id' => $PO['id']])->first();
                    $WeekDay                               = Carbon::now()->dayName;
                    $ProductOptionWeekTour                 = ProductOptionWeekTour::where(['product_id' => $activity_id, 'product_option_id' => $PO['id'], 'week_day' => $WeekDay])->first();
                    $ProductOptionTaxServiceCharge         = ProductOptionTaxServiceCharge::where(['product_id' => $activity_id, 'product_option_id' => $PO['id']])->first();
                    $getProductOption['tour_adult_price']  = 'N/A';
                    $getProductOption['tour_child_price']  = 'N/A';
                    $getProductOption['tour_infant_price'] = 'N/A';
                    $getProductOption['is_week_days_id']   = 0;
                    $adult_price                           = $ProductTourPriceDetails            != '' ? get_partners_dis_price(ConvertCurrency($ProductTourPriceDetails->adult_price), $activity_id, $request->user_id, 'tour_price', 'excursion') : 0;
                    $infant_price                          = $ProductTourPriceDetails            != '' ? get_partners_dis_price(ConvertCurrency($ProductTourPriceDetails->infant_price), $activity_id, $request->user_id, 'tour_price', 'excursion') : 0;
                    $child_price                           = $ProductTourPriceDetails            != '' ? get_partners_dis_price(ConvertCurrency($ProductTourPriceDetails->child_price), $activity_id, $request->user_id, 'tour_price', 'excursion') : 0;
                    $infant_allowed                        = $ProductTourPriceDetails            != '' ? $ProductTourPriceDetails->infant_allowed : 0;
                    $child_allowed                         = $ProductTourPriceDetails            != '' ? $ProductTourPriceDetails->child_allowed : 0;

                    $maximum_people                        = $getProductOption['maximum_people']  = $PO['maximum_people'];
                    $minimum_people                        = $getProductOption['minimum_people']  = $PO['minimum_people'];
                    if ($ProductOptionWeekTour != '') {
                        $adult_price = get_partners_dis_price(ConvertCurrency($ProductOptionWeekTour->adult), $activity_id, $request->user_id, 'weekdays', 'excursion');
                        $child_price =  get_partners_dis_price(ConvertCurrency($ProductOptionWeekTour->child_price), $activity_id, $request->user_id, 'weekdays', 'excursion');
                        $infant_price =  get_partners_dis_price(ConvertCurrency($ProductOptionWeekTour->infant_price), $activity_id, $request->user_id, 'weekdays', 'excursion');
                        $infant_price = $ProductOptionWeekTour->infant_price;
                        $child_allowed = $ProductOptionWeekTour->child_allowed;
                        $infant_allowed = $ProductOptionWeekTour->infant_allowed;
                        $getProductOption['is_week_days_id'] = $ProductOptionWeekTour->id;
                    }
                    $getProductOption['is_period_pricing'] = 0;
                    $date = Carbon::now();
                    $ProductOptionPeriodPricing = ProductOptionPeriodPricing::where(['product_id' => $activity_id, 'product_option_id' => $PO['id']])
                        ->whereDate('from_date', '<=', date('Y-m-d'))
                        ->whereDate('to_date', '>=', date('Y-m-d'))
                        ->first();
                    if ($ProductOptionPeriodPricing != '') {
                        $adult_price = ConvertCurrency($ProductOptionPeriodPricing->adult_price);
                        $child_price = ConvertCurrency($ProductOptionPeriodPricing->child_price);
                        $infant_price = ConvertCurrency($ProductOptionPeriodPricing->infant_price);

                        $child_allowed = $ProductOptionPeriodPricing->child_allowed;
                        $infant_allowed = $ProductOptionPeriodPricing->infant_allowed;
                        $getProductOption['is_period_pricing'] = $ProductOptionPeriodPricing->id;
                        $getProductOption['is_week_days_id'] = 0;
                    }
                    if ($minimum_people > 0) {
                        $ProductOptionGroupPercentage = ProductOptionGroupPercentage::where(['product_id' => $activity_id, 'product_option_id' => $PO['id'], 'number_of_passenger' => $minimum_people])->first();
                        $adult_price = $ProductOptionGroupPercentage != '' ? ConvertCurrency($ProductOptionGroupPercentage->default_percentage) : $adult_price;
                        $child_price = $ProductOptionGroupPercentage != '' ? ConvertCurrency($ProductOptionGroupPercentage->weekdays_percentage) : $child_price;
                        $infant_price = $ProductOptionGroupPercentage != '' ? ConvertCurrency($ProductOptionGroupPercentage->period_percentage) : $infant_price;
                    }
                    $getProductOption['tour_infant_allowed'] = $infant_allowed;
                    $getProductOption['tour_child_allowed']  = $child_allowed;
                    $getProductOption['tour_adult_price']    = $adult_price;
                    // $getProductOption['tour_adult_price252']    = get_partners_dis_price($adult_price, $activity_id, $request->user_id, 'tour_upgrade_option');
                    if ($child_allowed == 1) {
                        $getProductOption['tour_child_price'] = $child_price;
                    }
                    if ($infant_allowed == 1) {
                        $getProductOption['tour_infant_price'] = $infant_price;
                    }
                    $getProductOption['optionID'] = $PO['id'];
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
                    // getLanguageTranslate($ProductOptionLanguage, $language, $PO['id'], 'title', 'option_id');
                    $getProductOption['title'] = $product_option_title;
                    $getProductOption['description'] = getLanguageTranslate($ProductOptionLanguage, $language, $PO['id'], 'description', 'option_id');
                    ///////////////////////////////////
                    $getProductOption['tax_allowed'] = $ProductOptionTaxServiceCharge != '' ? $ProductOptionTaxServiceCharge->tax_allowed : 0;
                    $getProductOption['service_charge_allowed'] = $ProductOptionTaxServiceCharge != '' ? $ProductOptionTaxServiceCharge->service_charge_allowed : 0;
                    $getProductOption['tax_percentage'] = $ProductOptionTaxServiceCharge != '' ? $ProductOptionTaxServiceCharge->tax_percentage : 0;
                    $getProductOption['service_charge_amount'] = $ProductOptionTaxServiceCharge != '' ? ConvertCurrency($ProductOptionTaxServiceCharge->service_charge_amount) : 0;
                    // Tour Upgrade
                    $ProductOptionTourUpgrade = ProductOptionTourUpgrade::where(['product_option_id' => $PO['id'], 'product_id' => $activity_id])->get();
                    if (count($ProductOptionTourUpgrade) > 0) {
                        foreach ($ProductOptionTourUpgrade as $key => $POTU) {
                            if ($POTU['title'] != '') {
                                $getProductTourTourArr                      = [];
                                $getProductTourTourArr['id']                = $POTU['id'];
                                $getProductTourTourArr['title']             = $POTU['title'];
                                $getProductTourTourArr['tour_adult_price']  =  get_partners_dis_price(ConvertCurrency($POTU['adult_price']), $activity_id, $request->user_id, 'tour_upgrade_option', 'excursion');
                                $getProductTourTourArr['tour_child_price']  = get_partners_dis_price(ConvertCurrency($POTU['child_price']), $activity_id, $request->user_id, 'tour_upgrade_option', 'excursion');
                                $getProductTourTourArr['tour_infant_price'] = get_partners_dis_price(ConvertCurrency($POTU['infant_price']), $activity_id, $request->user_id, 'tour_upgrade_option', 'excursion');
                                $getProductTourTourArr['child_allowed']     = $POTU['child_allowed'];
                                $getProductTourTourArr['infant_allowed']    = $POTU['infant_allowed'];
                                $getProductOption['tourUpgrade'][]          = $getProductTourTourArr;
                            }
                        }
                    } else {
                        $getProductOption['tourUpgrade'] = [];
                    }
                    // Private Cars
                    $ProductPrivateTransferCars = ProductPrivateTransferCars::where(['product_option_id' => $PO['id'], 'product_id' => $activity_id])->get();
                    if (count($ProductPrivateTransferCars) > 0) {
                        foreach ($ProductPrivateTransferCars as $key => $PPTC) {
                            $getPrivateTransferCarsArr = [];
                            $getPrivateTransferCarsArr['car_id'] = $PPTC['car_id'];
                            // $getPrivateTransferCarsArr['car_id']                  = $PPTC['car_id'];
                            $getPrivateTransferCarsArr['option_id'] = $PO['id'];
                            $getPrivateTransferCarsArr['car_name'] = $PPTC['car_name'];
                            $getPrivateTransferCarsArr['number_of_passenger'] = $PPTC['number_of_passenger'];
                            $getPrivateTransferCarsArr['price'] = ConvertCurrency($PPTC['price']);
                            $getPrivateTransferCarsArr['qty'] = 0;
                            $getProductOption['private_cars'][] = $getPrivateTransferCarsArr;
                        }
                    } else {
                        $getProductOption['private_cars'] = [];
                    }
                    $getProductOption['private_tour'] = 0;
                    $ProductOptionDetails = ProductOptionDetails::where(['product_option_id' => $PO['id'], 'product_id' => $activity_id, 'status' => 1])
                        ->orderBy('sort')
                        ->get();
                    if (count($ProductOptionDetails) > 0) {
                        foreach ($ProductOptionDetails as $key => $POD) {
                            $checkCar = 0;
                            if ($POD['is_input'] == 0) {
                                $checkCarCount =  ProductPrivateTransferCars::where(['product_option_id' => $PO['id'], 'product_id' => $activity_id])->count();
                                if ($checkCarCount > 0) {
                                    $checkCar = 1;
                                }
                            } else {
                                $checkCar = 1;
                            }
                            if ($checkCar == 1) {
                                if ($POD['transfer_option'] != '') {

                                    $getProductTourOptionArr = [];
                                    $getProductTourOptionArr['optionDetailsID'] = $POD['id'];
                                    $getProductTourOptionArr['title'] = $POD['transfer_option'];
                                    $getProductTourOptionArr['type'] = $type = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $POD['transfer_option']));
                                    $getProductTourOptionArr['tour_adult_price'] = get_partners_dis_price(ConvertCurrency($POD['edult']), $activity_id, $request->user_id, 'transfer_option', 'excursion') ?? 0;
                                    $getProductTourOptionArr['tour_child_price'] =  get_partners_dis_price(ConvertCurrency($POD['child_price']), $activity_id, $request->user_id, 'transfer_option', 'excursion') ?? 0;
                                    $getProductTourOptionArr['tour_infant_price'] = get_partners_dis_price(ConvertCurrency($POD['infant']), $activity_id, $request->user_id, 'transfer_option', 'excursion') ?? 0;
                                    $getProductTourOptionArr['is_private'] = $POD['is_input'] == 0 ? 1 : 0;
                                    $getProductOption['optionDetails'][] = $getProductTourOptionArr;
                                }
                            }
                        }
                    } else {
                        $getProductOption['optionDetails'] = [];
                    }
                    $ProductOptionArr[] = $getProductOption;
                }
            }
            // Product Lodge
            $ProductLodge = ProductLodge::where(['product_id' => $activity_id])->get();
            $ProductLodgeLanguage = ProductLodgeLanguage::where(['product_id' => $activity_id])->get();
            $ProductLodgeArr = [];
            foreach ($ProductLodge as $PLkey => $PL) {
                $getProductLodge                         = [];
                $adult_price                             = $PL['adult_price']    != '' ? ConvertCurrency($PL['adult_price']) : 'N/A';
                $infant_price                            = $PL['infant_price']   != '' ? ConvertCurrency($PL['infant_price']) : 'N/A';
                $child_price                             = $PL['child_price']    != '' ? ConvertCurrency($PL['child_price']) : 'N/A';
                $infant_allowed                          = $PL['infant_allowed'] != '' ? $PL['infant_allowed'] : '0';
                $child_allowed                           = $PL['child_allowed']  != '' ? $PL['child_allowed'] : '0';
                $getProductLodge['lodge_adult_price']    = $adult_price;
                $getProductLodge['lodge_child_price']    = $child_price;
                $getProductLodge['lodge_infant_price']   = $infant_price;
                $getProductLodge['lodge_child_allowed']  = $child_allowed;
                $getProductLodge['lodge_infant_allowed'] = $infant_allowed;
                $getProductLodge['lodgeID']              = $PL['id'];
                $getProductLodge['title'] = getLanguageTranslate($ProductLodgeLanguage, $language, $PL['id'], 'title', 'lodge_id');
                $getProductLodge['description'] = getLanguageTranslate($ProductLodgeLanguage, $language, $PL['id'], 'description', 'option_id');
                $ProductLodgeArr[] = $getProductLodge;
            }
            // Product Tour Price
            $ProductTourOptions = ProductOptions::where(['product_id' => $activity_id, 'is_private_tour' => 1])->get();
            $ProductPrivateTourOptionArr = [];
            foreach ($ProductTourOptions as $PTO) {
                /////////////////////////
                $option_title = getLanguageTranslate($ProductOptionLanguage, $language, $PTO['id'], 'title', 'option_id');
                if ($option_title != '') {
                    $getProductTouroption = [];
                    $ProductTourPriceDetails = ProductTourPriceDetails::where(['product_id' => $activity_id, 'product_option_id' => $PTO['id']])->first();
                    $ProductOptionPrivateTourPrice = ProductOptionPrivateTourPrice::where(['product_option_id' => $PTO['id'], 'product_id' => $activity_id])->first();

                    if ($ProductOptionPrivateTourPrice != '') {
                        $ProductOptionTaxServiceCharge               = ProductOptionTaxServiceCharge::where(['product_id' => $activity_id, 'product_option_id' => $PTO['id']])->first();
                        $adult_price                                 = $ProductTourPriceDetails != '' ? get_partners_dis_price(ConvertCurrency($ProductTourPriceDetails->adult_price), $activity_id, $request->user_id, 'tour_price', 'excursion') : 'N/A';
                        $infant_price                                = $ProductTourPriceDetails != '' ?  get_partners_dis_price(ConvertCurrency($ProductTourPriceDetails->infant_price), $activity_id, $request->user_id, 'tour_price', 'excursion') : 'N/A';
                        $child_price                                 = $ProductTourPriceDetails != '' ? get_partners_dis_price(ConvertCurrency($ProductTourPriceDetails->child_price), $activity_id, $request->user_id, 'tour_price', 'excursion') : 'N/A';
                        $infant_allowed                              = $ProductTourPriceDetails != '' ? $ProductTourPriceDetails->infant_allowed : 0;
                        $child_allowed                               = $ProductTourPriceDetails != '' ? $ProductTourPriceDetails->child_allowed : 0;
                        $getProductTouroption['tour_infant_allowed'] = $infant_allowed;
                        $getProductTouroption['tour_child_allowed']  = $child_allowed;
                        $getProductTouroption['tour_adult_price']    = $adult_price;
                        if ($child_allowed == 1) {
                            $getProductTouroption['tour_child_price'] = $child_price;
                        }
                        if ($infant_allowed == 1) {
                            $getProductTouroption['tour_infant_price'] = $infant_price;
                        }
                        $getProductTouroption['optionID']       = $PTO['id'];
                        $getProductTouroption['available_type'] = $available_type = $PTO['available_type'];
                        $DAArr = [];
                        if ($available_type == 'days_available') {
                            $days_available = json_decode($PTO['days_available']);
                            foreach ($days_available as $DAKey => $DA) {
                                $Timing = Timing::where('day', $DAKey)->first();
                                if ($Timing) {
                                    $DAArr[] = $Timing->value;
                                }
                            }
                        } elseif ($available_type == 'date_available') {
                            $date_available = json_decode($PTO['date_available']);
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
                        $getProductTouroption['available_days'] = $DAArr;
                        $getProductTouroption['title']          = $option_title;
                        $getProductTouroption['description']    = getLanguageTranslate($ProductOptionLanguage, $language, $PTO['id'], 'description', 'option_id');
                        $getProductTouroption['tax_allowed'] = $ProductOptionTaxServiceCharge != '' ? $ProductOptionTaxServiceCharge->tax_allowed : 0;
                        $getProductTouroption['service_charge_allowed'] = $ProductOptionTaxServiceCharge != '' ? $ProductOptionTaxServiceCharge->service_charge_allowed : 0;
                        $getProductTouroption['tax_percentage'] = $ProductOptionTaxServiceCharge != '' ? $ProductOptionTaxServiceCharge->tax_percentage : 0;
                        $getProductTouroption['service_charge_amount'] = $ProductOptionTaxServiceCharge != '' ? ConvertCurrency($ProductOptionTaxServiceCharge->service_charge_amount) : 0;
                        // Tour Upgrade
                        $ProductOptionTourUpgrade = ProductOptionTourUpgrade::where(['product_option_id' => $PTO['id'], 'product_id' => $activity_id])->get();

                        if (count($ProductOptionTourUpgrade) > 0) {
                            foreach ($ProductOptionTourUpgrade as $key => $POTU) {
                                $getProductTourTourArr = [];
                                $getProductTourTourArr['id'] = $POTU['id'];
                                $getProductTourTourArr['title'] = $POTU['title'];
                                $getProductTourTourArr['tour_adult_price'] = get_partners_dis_price(ConvertCurrency($POTU['adult_price']), $activity_id, $request->user_id, 'tour_upgrade_option', 'excursion');
                                $getProductTourTourArr['tour_child_price'] = get_partners_dis_price(ConvertCurrency($POTU['child_price']), $activity_id, $request->user_id, 'tour_upgrade_option', 'excursion');
                                $getProductTourTourArr['tour_infant_price'] = get_partners_dis_price(ConvertCurrency($POTU['infant_price']), $activity_id, $request->user_id, 'tour_upgrade_option', 'excursion');
                                $getProductTourTourArr['child_allowed'] = $POTU['child_allowed'];
                                $getProductTourTourArr['infant_allowed'] = $POTU['infant_allowed'];
                                $getProductTouroption['tourUpgrade'][] = $getProductTourTourArr;
                            }
                        } else {
                            $getProductTouroption['tourUpgrade'] = [];
                        }
                        // Product Option Tour Price
                        $price_per_car = 0;
                        $max_adult = 0;
                        $max_child = 0;
                        $total_allowed = 0;
                        if ($ProductOptionPrivateTourPrice != '') {
                            $price_per_car = ConvertCurrency($ProductOptionPrivateTourPrice->private_per_price);
                            $max_adult = $ProductOptionPrivateTourPrice->max_adult;
                            $max_child = $ProductOptionPrivateTourPrice->max_child;
                            $total_allowed = $ProductOptionPrivateTourPrice->total_allowed;
                        }
                        $getProductTouroption['price_per_car'] = $price_per_car;
                        $getProductTouroption['total_allowed'] = $total_allowed;
                        $getProductTouroption['private_tour'] = 1;
                        $ProductPrivateTourOptionArr[] = $getProductTouroption;
                    }
                }
            }
            // Product Group Percentage
            $ProductGroupPercentage = ProductGroupPercentage::where(['product_id' => $activity_id])->get();
            $ProductGroupPercentageArr = [];
            foreach ($ProductGroupPercentage as $PGP) {

                $ProductGroupPercentageLanguage = ProductGroupPercentageLanguage::where(['product_id' => $activity_id, 'group_percentage_id' => $PGP['id']])->get();
                $group_per_title = getLanguageTranslate($ProductGroupPercentageLanguage, $language, $PGP['id'], 'title', 'group_percentage_id');
                if ($group_per_title) {
                    $getProductGroupPercentage = [];
                    $getDropDownCount = ProductGroupPercentageDetails::where(['product_id' => $activity_id, 'group_percentage_id' => $PGP['id']])->get();
                    $getDropDownCountArr = [];
                    foreach ($getDropDownCount as $k => $GDDC) {
                        $getDropDownCountArr[] = $GDDC['number_of_pax'];
                    }
                    $getProductGroupPercentage['available_type'] = $available_type = $PGP['available_type'];
                    $DAArr = [];
                    if ($available_type == 'days_available') {
                        $days_available = json_decode($PGP['days_available']);
                        foreach ($days_available as $DAKey => $DA) {
                            $Timing = Timing::where('day', $DAKey)->first();
                            if ($Timing) {
                                $DAArr[] = $Timing->value;
                            }
                        }
                    } elseif ($available_type == 'date_available') {
                        $date_available = json_decode($PGP['date_available']);
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
                    $getProductGroupPercentage['id'] = $PGP['id'];
                    $getProductGroupPercentage['group_price'] = ConvertCurrency($PGP['group_price']);
                    $getProductGroupPercentage['number_of_pax'] = $PGP['number_of_pax'];
                    $getProductGroupPercentage['dropdown_count'] = $getDropDownCountArr;
                    $getProductGroupPercentage['available_days'] = $DAArr;
                    $getProductGroupPercentage['title'] = $group_per_title;
                    $getProductGroupPercentage['description'] = getLanguageTranslate($ProductGroupPercentageLanguage, $language, $PGP['id'], 'description', 'group_percentage_id');
                    $main_title = getLanguageTranslate($ProductGroupPercentageLanguage, $language, $PGP['id'], 'main_title', 'group_percentage_id');

                    $getProductGroupPercentage['main_title']   = $main_title  != '' ? $main_title  : '';
                    $ProductGroupPercentageArr[] = $getProductGroupPercentage;
                }
            }
            $approx = '';
            if ($ProductDetails['approx'] == 1) {
                $approx = '(Approx)';
            }
            $ProductInfo = ProductInfo::where('title', 'excursion_type')
                ->where('product_id', $activity_id)
                ->first();


            foreach ($ProductDetails as $Pkey => $P) {
                if ($Pkey == 'image' || $Pkey == 'logo' || $Pkey == 'video_thumbnail') {
                    if ($P != '') {
                        $P = $P != '' ? asset('uploads/product_images/' . $P) : asset('uploads/placeholder/placeholder.png');
                    } else {
                        if ($Pkey == 'video_thumbnail') {
                            $P = asset('uploads/product_images/video_thumb.png');
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

            $productDeatils['option']             = $ProductOptionArr;
            $productDeatils['category_name']      = $newCategory;
            $productDeatils['private_tour_price'] = $ProductPrivateTourOptionArr;
            $productDeatils['group_percentage']   = $ProductGroupPercentageArr;
            $productDeatils['lodge']              = $ProductLodgeArr;
            $productDeatils['images']             = $imagesArr;
            $productDeatils['title']              = $title;
            $productDeatils['main_description']   = $main_description;
            $productDeatils['extra_option_note']  = $extra_option_note;
            $productDeatils['booking_policy']     = $booking_policy;
            $productDeatils['related_product_title']  = $related_product_title;
            $productDeatils['option_note']        = $option_note;
            $productDeatils['highlight']          = $ProductHighlightsArr;
            $productDeatils['product_timing']     = $ProductTimingsArr;
            $productDeatils['additional_info']    = $ProductAdditionalInfoArr;
            $productDeatils['site_advertisement'] = $ProductSiteAdvertisementArr;
            $productDeatils['faq']                = $ProductFAQArr;
            $productDeatils['bookable_up_to']     = $bookable_up_to;
            $productDeatils['from_date']          = $from_date;
            $productDeatils['to_date']            = $to_date;
            $productDeatils['product_tool_tip']   = $get_tool_tip;
            $productDeatils['free_cancellation']  = $ProductInfo != '' ? $ProductInfo->value : 0;





            ///Review For This Product
            $productDeatils['reviews'] = [];
            $get_review                = UserReview::where('product_id', $activity_id)->orderBy('id', 'desc')->limit(6)->get();
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

                $productDeatils['product_popup']['link']        = $Product->pro_popup_link != '' ? $Product->pro_popup_link : '';
                $productDeatils['product_popup']['redirect_link'] = $Product->redirection_link;

                $productDeatils['product_popup']['product_image']       = $Product->image != '' ? url('uploads/product_images/', $Product->image) : asset('uploads/placeholder/placeholder.png');

                $productDeatils['product_popup']['image']       = $Product->pro_popup_image != '' ? url('uploads/product_images', $Product->pro_popup_image) : '';

                $productDeatils['product_popup']['video']        = $Product->pro_popup_video != '' ? url('uploads/product_images/popup_image', $Product->pro_popup_video) : '';
                $productDeatils['product_popup']['thumnail']     = $Product->pro_popup_thumnail_image != '' ? url('uploads/product_images/popup_image', $Product->pro_popup_thumnail_image) : ($Product->image != '' ? url('uploads/product_images/', $Product->image) : asset('uploads/placeholder/placeholder.png'));
            }





            // return  $activity_id
            $productDeatils['experience_heading'] = '';
            $heading_title                        = MetaGlobalLanguage::where('product_id', $activity_id)->where('meta_parent', 'middle_experience_heading')
                ->where('meta_title', 'heading_title')
                ->where('language_id', $language)
                ->where('product_id', $activity_id)
                ->first();
            if ($heading_title) {
                $productDeatils['experience_heading'] = $heading_title['title'];
            }


            $productDeatils['opening_heading'] = '';
            $heading_title                        = MetaGlobalLanguage::where('product_id', $activity_id)->where('meta_parent', 'excursion_opening_heading')
                ->where('meta_title', 'heading_title')
                ->where('language_id', $language)
                ->where('product_id', $activity_id)
                ->first();
            if ($heading_title) {
                $productDeatils['opening_heading'] = $heading_title['title'];
            }

            $productDeatils['additional_heading'] = '';
            $heading_title                        = MetaGlobalLanguage::where('product_id', $activity_id)->where('meta_parent', 'excursion_additional_heading')
                ->where('meta_title', 'heading_title')
                ->where('language_id', $language)
                ->where('product_id', $activity_id)
                ->first();
            if ($heading_title) {
                $productDeatils['additional_heading'] = $heading_title['title'];
            }


            $productDeatils['faq_heading'] = '';
            $heading_title                        = MetaGlobalLanguage::where('product_id', $activity_id)->where('meta_parent', 'excursion_faq_heading')
                ->where('meta_title', 'heading_title')
                ->where('language_id', $language)
                ->where('product_id', $activity_id)
                ->first();
            if ($heading_title) {
                $productDeatils['faq_heading'] = $heading_title['title'];
            }

            // Product Experience ICon
            $productDeatils['experience_icon'] = [];
            $ProductExprienceIcon              = ProductExprienceIcon::where(['product_id' => $activity_id, 'type' => 'excursion'])->where('position_type', 'middel')->get();
            $ProductExprienceIconLanguage      = ProductExprienceIconLanguage::where(['product_id' => $activity_id, 'type' => 'excursion'])->where('position_type', 'middel')->get();
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
            $experience_heading = MetaGlobalLanguage::where('product_id', $activity_id)->where('meta_parent', 'header_experience_heading')
                ->where('meta_title', 'heading_title')
                ->where('language_id', $language)
                ->where('product_id', $activity_id)
                ->first();
            if ($experience_heading) {
                $productDeatils['header_experience_heading'] = $experience_heading['title'];
            }


            // Product Experience ICon
            $productDeatils['header_experience_icon'] = [];
            $ProductExprienceIconHeader              = ProductExprienceIcon::where(['product_id' => $activity_id, 'type' => 'excursion'])->where('position_type', 'upper')->get();
            $ProductExprienceIconLanguageHeader      = ProductExprienceIconLanguage::where(['product_id' => $activity_id, 'type' => 'excursion'])->where('position_type', 'upper')->get();
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

            // Releated Product 
            $Productyachtrelatedboats = Productyachtrelatedboats::where(['product_id' => $activity_id, 'type' => "excursion"])->get();
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
                    if ($P['product_type'] == 'excursion') {
                        $getProductArr['link'] = 'activities-detail/' . $P['slug'];
                    } elseif ($P['product_type'] == 'yacht') {
                        $getProductArr['link'] = 'yacht-charts-details/' . $P['slug'];
                    } elseif ($P['product_type'] == 'lodge') {
                        $getProductArr['link'] = 'lodge-detail/' . $P['slug'];
                    } elseif ($P['product_type'] == 'limousine') {
                        $getProductArr['link'] = 'limousine-detail/' . $P['slug'];
                    }

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

    // Get Group Pacenger Amount
    public function get_group_passenger_amount(Request $request)
    {
        $output = [];
        $output['status'] = false;
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
        $activity_id      = $request->activity_id;
        $language         = $request->language;
        $tour_transfer_id = $request->tour_transfer_id;
        $productArr       = [];
        $Product          = Product::where('slug', $activity_id)->first();
        $activity_id      = $Product->id;
        $IsSave           = 0;
        $SaveMessage      = '';
        $ProductOptionGroupPercentage = ProductOptionGroupPercentage::where(['product_id' => $activity_id, 'product_option_id' => $request->option_id]);
        $productOption = ProductOptions::where(['product_id' => $activity_id, 'id' => $request->option_id])->first();
        $Arr = ['tour_adult_price', 'tour_child_price', 'tour_infant_price'];
        // foreach ($request->data['qty'] as $qtykey => $QT) {
        $ProductOptionGroupPercentage = '';
        if (isset($request->data['total_qty'])) {
            $qty = $request->data['total_qty'];
            $ProductOptionGroupPercentage = ProductOptionGroupPercentage::where(['product_id' => $activity_id, 'product_option_id' => $request->option_id, 'number_of_passenger' => $qty])->first();
        }
        $get_option_tour_detail = ProductTourPriceDetails::where('product_option_id', $request->option_id)
            ->where('product_id', $activity_id)
            ->first();
        $percentageType = 0;
        if ($get_option_tour_detail) {
            $adult_price = get_partners_dis_price(ConvertCurrency($get_option_tour_detail['adult_price']), $activity_id, $request->user_id, 'tour_price', 'excursion');
            $child_price = get_partners_dis_price(ConvertCurrency($get_option_tour_detail['child_price']), $activity_id, $request->user_id, 'tour_price', 'excursion');
            $infant_price = get_partners_dis_price(ConvertCurrency($get_option_tour_detail['infant_price']), $activity_id, $request->user_id, 'tour_price', 'excursion');
            // is_week_days_id
        }
        if ($request->is_reset == 1) {
            $WeekDay = Carbon::now()->dayName;
            $ProductOptionWeekTour = ProductOptionWeekTour::where(['product_id' => $activity_id, 'product_option_id' => $request->option_id, 'week_day' => $WeekDay])->first();

            if ($ProductOptionWeekTour != '') {
                $adult_price = get_partners_dis_price(ConvertCurrency($ProductOptionWeekTour->adult), $activity_id, $request->user_id, 'weekdays', 'excursion');
                $child_price = get_partners_dis_price(ConvertCurrency($ProductOptionWeekTour->child_price), $activity_id, $request->user_id, 'weekdays', 'excursion');
                $infant_price = get_partners_dis_price(ConvertCurrency($ProductOptionWeekTour->infant_price), $activity_id, $request->user_id, 'weekdays', 'excursion');
            }

            $date = Carbon::now();
            $ProductOptionPeriodPricing = ProductOptionPeriodPricing::where(['product_id' => $activity_id, 'product_option_id' => $request->option_id])
                ->whereDate('from_date', '<=', date('Y-m-d'))
                ->whereDate('to_date', '>=', date('Y-m-d'))
                ->first();
            if ($ProductOptionPeriodPricing != '') {
                $adult_price = ConvertCurrency($ProductOptionPeriodPricing->adult_price);
                $child_price = ConvertCurrency($ProductOptionPeriodPricing->child_price);
                $infant_price = ConvertCurrency($ProductOptionPeriodPricing->infant_price);
            }
        } else {
            $is_week_days_id = $request->is_week_days_id;
            if ($is_week_days_id > 0) {
                $get_week_tour = ProductOptionWeekTour::where(['id' => $is_week_days_id])->first();
                if ($get_week_tour) {
                    $adult_price = get_partners_dis_price(ConvertCurrency($get_week_tour['adult']), $activity_id, $request->user_id, 'weekdays', 'excursion');
                    $child_price =  get_partners_dis_price(ConvertCurrency($get_week_tour['child_price']), $activity_id, $request->user_id, 'weekdays', 'excursion');
                    $infant_price = get_partners_dis_price(ConvertCurrency($get_week_tour['infant_price']), $activity_id, $request->user_id, 'weekdays', 'excursion');
                }
            }

            $is_period_pricing = $request->is_period_pricing;
            if ($is_period_pricing > 0) {
                $get_period_pricing = ProductOptionPeriodPricing::where(['id' => $is_period_pricing])->first();
                if ($get_period_pricing) {
                    $adult_price = ConvertCurrency($get_period_pricing['adult_price']);
                    $child_price = ConvertCurrency($get_period_pricing['child_price']);
                    $infant_price = ConvertCurrency($get_period_pricing['infant_price']);
                }
            }
        }

        if ($ProductOptionGroupPercentage != '') {
            $IsSave            = 1;
            $save_child_price  = 0;
            $save_infant_price = 0;
            $save_adult_price  = $adult_price - ConvertCurrency($ProductOptionGroupPercentage->default_percentage);
            if ($save_adult_price < 0) {
                $save_adult_price = 0;
            }
            if ($get_option_tour_detail['child_allowed'] == 1) {
                $save_child_price = $child_price - ConvertCurrency($ProductOptionGroupPercentage->weekdays_percentage);
                if ($save_child_price < 0) {
                    $save_child_price = 0;
                }
            }
            if ($get_option_tour_detail['infant_allowed'] == 1) {
                $save_infant_price = $infant_price - ConvertCurrency($ProductOptionGroupPercentage->period_percentage);
                if ($save_infant_price < 0) {
                    $save_infant_price = 0;
                }
            }
            $totalDiscountPrice = $save_adult_price + $save_child_price + $save_infant_price;
            $SaveMessage = ' You will save  ' . getAmount($totalDiscountPrice) . ' when booking ' . $qty . ' guests';
        }

        $adultpercentageType  = $ProductOptionGroupPercentage != '' ? ConvertCurrency($ProductOptionGroupPercentage->default_percentage) : $adult_price;
        $childpercentageType  = $ProductOptionGroupPercentage != '' ? ConvertCurrency($ProductOptionGroupPercentage->weekdays_percentage) : $child_price;
        $infantpercentageType = $ProductOptionGroupPercentage != '' ? ConvertCurrency($ProductOptionGroupPercentage->period_percentage) : $infant_price;
        // return $adultpercentageType ."-".$childpercentageType."-".
        $total          = 0;
        $minimum_people = 0;
        if ($productOption) {
            if ($productOption->minimum_people > 0) {
                $total          = $adultpercentageType * $productOption->minimum_people;
                $minimum_people = $productOption->minimum_people;
            }
        }

        $tour_transfer_adult_price  = 0;
        $tour_transfer_child_price  = 0;
        $tour_transfer_infant_price = 0;
        $get_option_details         = ProductOptionDetails::where('id', $tour_transfer_id)->first();
        if ($get_option_details) {
            if ($get_option_details->is_input == 1) {
                $tour_transfer_adult_price  = $get_option_details->edult > 0 ? get_partners_dis_price(ConvertCurrency($get_option_details->edult), $activity_id, $request->user_id, 'transfer_option', 'excursion') : 0;
                $tour_transfer_child_price  = $get_option_details->child_price > 0 ? get_partners_dis_price(ConvertCurrency($get_option_details->child_price), $activity_id, $request->user_id, 'transfer_option', 'excursion')  : 0;
                $tour_transfer_infant_price = $get_option_details->infant > 0 ? get_partners_dis_price(ConvertCurrency($get_option_details->infant), $activity_id, $request->user_id, 'transfer_option', 'excursion')  : 0;
            }
        }

        $data['tour_transfer_adult_price']  = $tour_transfer_adult_price;
        $data['tour_transfer_child_price']  = $tour_transfer_child_price;
        $data['tour_transfer_infant_price'] = $tour_transfer_infant_price;

        foreach ($Arr as $key => $value) {
            if ($value == 'tour_adult_price') {
                // $data[$value] = $adult_price - ($adult_price / 100) * $adultpercentageType;
                $data[$value] = $adultpercentageType;
            }
            if ($value == 'tour_child_price') {
                // $data[$value] = $child_price - ($child_price / 100) * $childpercentageType;
                $data[$value] = $childpercentageType;
            }
            if ($value == 'tour_infant_price') {
                // $data[$value] = $infant_price - ($infant_price / 100) * $infantpercentageType;
                $data[$value] = $infantpercentageType;
            }
            $data['is_save'] = $IsSave;
            $data['total'] = $total;
            $data['minimum_people'] = $minimum_people;
            $data['save_msg'] = $SaveMessage;
            $productArr[] = $data;
        }
        // if ($request->data['type'] == 'tour_adult_price') {
        //     $data[$request->data['type']] = $adult_price - ($adult_price / 100) * $percentageType;
        // }
        // if ($request->data['type'] == 'tour_child_price') {
        //     $data[$request->data['type']] = $child_price - ($child_price / 100) * $percentageType;
        // }
        // if ($request->data['type'] == 'tour_infant_price') {
        //     $data[$request->data['type']] = $infant_price - ($infant_price / 100) * $percentageType;
        // }
        $output['data']   = $data;
        $output['status'] = true;
        $output['msg']    = 'Data Fetched Successfully...';
        return json_encode($output);
    }

    // Get Group Percentage Amouny
    public function get_group_percentage_amount(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $validation = Validator::make($request->all(), [
            'activity_id' => 'required',
            'group_id' => 'required',
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
        $qty                           = $request->qty;
        $Product                       = Product::where('slug', $request->activity_id)->first();
        $activity_id                   = $Product->id;
        $ProductGroupPercentage        = ProductGroupPercentage::where(['product_id' => $activity_id])->first();
        $ProductGroupPercentageDetails = ProductGroupPercentageDetails::where(['product_id' => $activity_id])
            ->where('number_of_pax', '>=', $qty)
            ->where('number_of_pax', '<=', $qty)
            ->orderBy('number_of_pax', 'asc')
            ->first();
        $amount = ConvertCurrency($ProductGroupPercentage->group_price);
        if ($ProductGroupPercentageDetails) {
            $amount = ConvertCurrency($ProductGroupPercentageDetails->group_price);
        } else {
            $ProductGroupPercentageDetails = ProductGroupPercentageDetails::where(['product_id' => $activity_id])
                ->where('number_of_pax', '>=', $qty)
                ->orderBy('number_of_pax', 'asc')
                ->first();
            if ($ProductGroupPercentageDetails) {
                $amount = ConvertCurrency($ProductGroupPercentageDetails->group_price);
            }
        }

        $service_charge = 0;
        $tax            = 0;
        $tax_amount     = 0;

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




        $total_amount = 0;
        $total_amount = $amount + $service_charge + $tax_amount;

        $group_price         = $amount / $qty;
        $data['amount']      = number_format($total_amount, 2);
        $data['group_price'] = $group_price;
        $output['data']      = $data;
        $output['status']    = true;
        $output['msg']       = 'Data Fetched  Successfully...';
        return json_encode($output);
    }

    //Add To Cart
    public function activity_add_to_cart(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['msg'] = 'Record Not Found';
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

        $data                 = [];
        $total_amount         = 0;
        $get_total            = 0;
        $activity_id          = $request->activity_id;
        $Product              = Product::where('slug', $activity_id)->first();
        $activity_id          = $Product->id;
        $optionID             = $request->optionID;
        $tourCheck            = $request->tourcheck;
        $grouppercentagecheck = $request->grouppercentagecheck;
        $Date                 = $request->date;
        $ActivityData         = $request->data;
        $Timeslot             = $request->timeslot;
        $user_id              = $request->user_id != '' ? checkDecrypt($request->user_id) : 0;
        $checkAllData         = 0;

        if ($tourCheck != '') {
            $tourCheck = \array_filter($tourCheck, static function ($element) {
                return $element !== 'false';
                //                   ↑
                // Array value which you want to delete
            });

            foreach ($tourCheck as $key => $index) {
                // if ($index == 'false') {
                //     $output['status'] = false;
                //     $output['msg']    = 'Check Any Tour Option';
                //     break;
                // }

                $get_product_options = ProductOptions::where('product_id', $activity_id)
                    ->where('id', $key)
                    ->where('status', 1)
                    ->first();
                if (isset($key)) {
                    if (isset($request->data[$key])) {
                        $data = $request->data[$key];
                    } else {
                        if ($get_product_options->is_private_tour == 1) {
                            $output['status'] = false;
                            $output['msg'] = 'Select Private Tour Date';
                            break;
                        } else {
                            $data = [];
                        }
                    }
                }
                $req_adult_qty  = 0;
                $req_child_qty  = 0;
                $req_infant_qty = 0;
                $language       = $request->language;
                if (isset($data['data']['tour_adult_price']['qty'])) {
                    $req_adult_qty = $data['data']['tour_adult_price']['qty'];
                }
                if (isset($data['data']['tour_child_price']['qty'])) {
                    $req_child_qty = $data['data']['tour_child_price']['qty'];
                }
                if (isset($data['data']['tour_infant_price']['qty'])) {
                    $req_infant_qty = $data['data']['tour_infant_price']['qty'];
                }
                if (isset($data['data']['tour_infant_price']['qty'])) {
                    $req_infant_qty = $data['data']['tour_infant_price']['qty'];
                }
                $totalQty       = $req_adult_qty + $req_child_qty + $req_infant_qty;
                $resoponse      = [];
                $PriceBreakDown = [];

                if ($get_product_options && count($data) > 0) {
                    $adult_price           = 0;
                    $total_child_price     = 0;
                    $total_infant_price    = 0;
                    $adult_price           = 0;
                    $child_price           = 0;
                    $infant_price          = 0;
                    $get_main_option_data  = [];
                    $ProductOptionLanguage = ProductOptionLanguage::where('option_id', $get_product_options['id'])->first();
                    //option
                    $get_main_option_data['option_name'] = '';
                    if ($ProductOptionLanguage) {
                        $get_main_option_data['option_name'] = $ProductOptionLanguage['title'];
                    }

                    if (isset($data['tour_transfer_id']) && $data['tour_transfer_id'] > 0) {
                        $checkAllData = 0;
                        $get_option_details = ProductOptionDetails::where('product_id', $activity_id)
                            ->where('product_option_id', $key)
                            ->where('id', $data['tour_transfer_id'])
                            ->first();

                        $checkPrivateCar = 1;

                        if ($get_option_details) {
                            if ($get_option_details->is_input == 0) {
                                $checkPrivateCar = 0;

                                if (isset($data['private_car'])) {
                                    $get_car_detail = CarDetails::where('id', $data['private_car'])
                                        ->where('status', 'Active')
                                        ->first();
                                    if ($get_car_detail) {
                                        $checkPrivateCar = 1;
                                    }
                                }
                            }
                        }

                        if ($checkPrivateCar == 1) {
                            if (isset($Date[$key]) && $Date[$key] != '') {
                                if ($totalQty > 0) {
                                    $get_time_id = [];
                                    if ($get_product_options->available_type == 'daily') {
                                        if ($get_product_options->time_available) {
                                            $get_time_id = explode(',', $get_product_options->time_available);
                                        }
                                    }

                                    if ($get_product_options->available_type == 'date_available') {
                                        if ($get_product_options->date_available) {
                                            $get_dates = (array) json_decode($get_product_options->date_available, true);
                                            if (array_key_exists($Date[$key], $get_dates)) {
                                                if (isset($get_dates[$Date[$key]]) && $get_dates[$Date[$key]] != '') {
                                                    $get_time_id = explode(',', $get_dates[$Date[$key]]);
                                                }
                                            }
                                        }
                                    }

                                    if ($get_product_options->available_type == 'days_available') {
                                        $day = date('l', strtotime($Date[$key]));
                                        if ($get_product_options->days_available) {
                                            $get_days = (array) json_decode($get_product_options->days_available, true);
                                            if (array_key_exists($day, $get_days)) {
                                                if (isset($get_days[$day]) && $get_days[$day] != '') {
                                                    $get_time_id = explode(',', $get_days[$day]);
                                                }
                                            }
                                        }
                                    }

                                    $checkTimeSlot = 0;
                                    if (count($get_time_id) > 0) {
                                        if (isset($Timeslot[$key])) {
                                            $checkTimeSlot = 1;
                                        } else {
                                            $checkTimeSlot = 0;
                                        }
                                    } else {
                                        $checkTimeSlot = 1;
                                    }
                                    if ($checkTimeSlot == 1) {
                                        $checkTourUpgrade = 0;
                                        $totalUpgradeQty = 0;
                                        if (isset($data['data']['tour_adult_price']['tour_upgrade_arr'])) {
                                            $tour_upgrade_arr = $data['data']['tour_adult_price']['tour_upgrade_arr'];

                                            foreach ($tour_upgrade_arr as $upgrade_key => $tour_upgrade_value) {
                                                $get_product_option_tour_upgrade = ProductOptionTourUpgrade::where('id', $tour_upgrade_value['id'])->first();

                                                $totalUpgradeQty = 0;
                                                if ($get_product_option_tour_upgrade) {
                                                    if ($tour_upgrade_value['qty'] != '') {
                                                        $req_adult_qty = $tour_upgrade_value['qty'];
                                                        $totalUpgradeQty += $req_adult_qty;
                                                    }
                                                    if (isset($data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                                                        $req_child_qty = $data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                                                        $totalUpgradeQty += $req_child_qty;
                                                    }
                                                    if (isset($data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                                                        $req_infant_qty = $data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                                                        $totalUpgradeQty += $req_infant_qty;
                                                    }
                                                }
                                            }
                                            if ($totalUpgradeQty > 0) {
                                                $checkTourUpgrade = 1;
                                            }
                                        } else {
                                            $checkTourUpgrade = 1;
                                        }
                                        if ($checkTourUpgrade == 1) {
                                            $checkAllData = 1;
                                        } else {
                                            $output['status'] = false;
                                            $output['msg'] = 'Select Upgrade Option Qty';
                                            break;
                                        }
                                    } else {
                                        $output['status'] = false;
                                        $output['msg'] = 'Select Timeslot Of Option';
                                        break;
                                    }
                                } else {
                                    $output['status'] = false;
                                    $output['msg'] = 'Select Adult, Child or Infant Qty';
                                    break;
                                }
                            } else {
                                $output['status'] = false;
                                $output['msg'] = 'Select Date Of Tranfer Option';
                                break;
                            }
                        } else {
                            $output['status'] = false;
                            $output['msg'] = 'Select Private Car';
                            break;
                        }
                    } else {
                        if ($get_product_options->is_private_tour == 1) {
                            $checkAllData = 0;
                            if (isset($Date[$key]) && $Date[$key] != '') {
                                if ($totalQty > 0) {
                                    $get_time_id = [];
                                    if ($get_product_options->available_type == 'daily') {
                                        if ($get_product_options->time_available) {
                                            $get_time_id = explode(',', $get_product_options->time_available);
                                        }
                                    }

                                    if ($get_product_options->available_type == 'date_available') {
                                        if ($get_product_options->date_available) {
                                            $get_dates = (array) json_decode($get_product_options->date_available, true);
                                            if (array_key_exists($Date[$key], $get_dates)) {
                                                if (isset($get_dates[$Date[$key]]) && $get_dates[$Date[$key]] != '') {
                                                    $get_time_id = explode(',', $get_dates[$Date[$key]]);
                                                }
                                            }
                                        }
                                    }

                                    if ($get_product_options->available_type == 'days_available') {
                                        $day = date('l', strtotime($Date[$key]));
                                        if ($get_product_options->days_available) {
                                            $get_days = (array) json_decode($get_product_options->days_available, true);
                                            if (array_key_exists($day, $get_days)) {
                                                if (isset($get_days[$day]) && $get_days[$day] != '') {
                                                    $get_time_id = explode(',', $get_days[$day]);
                                                }
                                            }
                                        }
                                    }

                                    $checkTimeSlot = 0;
                                    if (count($get_time_id) > 0) {
                                        if (isset($Timeslot[$key])) {
                                            $checkTimeSlot = 1;
                                        } else {
                                            $checkTimeSlot = 0;
                                        }
                                    } else {
                                        $checkTimeSlot = 1;
                                    }

                                    if ($checkTimeSlot == 1) {
                                        $checkTourUpgrade = 0;
                                        $totalUpgradeQty = 0;
                                        if (isset($data['data']['tour_adult_price']['tour_upgrade_arr'])) {
                                            $tour_upgrade_arr = $data['data']['tour_adult_price']['tour_upgrade_arr'];

                                            foreach ($tour_upgrade_arr as $upgrade_key => $tour_upgrade_value) {
                                                $get_product_option_tour_upgrade = ProductOptionTourUpgrade::where('id', $tour_upgrade_value['id'])->first();
                                                $totalUpgradeQty = 0;
                                                if ($get_product_option_tour_upgrade) {
                                                    if ($tour_upgrade_value['qty'] != '') {
                                                        $req_adult_qty    = $tour_upgrade_value['qty'];
                                                        $totalUpgradeQty += $req_adult_qty;
                                                    }
                                                    if (isset($data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                                                        $req_child_qty   = $data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                                                        $totalUpgradeQty += $req_child_qty;
                                                    }
                                                    if (isset($data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                                                        $req_infant_qty  = $data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                                                        $totalUpgradeQty += $req_infant_qty;
                                                    }
                                                }
                                            }
                                            if ($totalUpgradeQty > 0) {
                                                $checkTourUpgrade = 1;
                                            }
                                        } else {
                                            $checkTourUpgrade = 1;
                                        }

                                        if ($checkTourUpgrade == 1) {
                                            $checkAllData = 1;
                                        } else {
                                            $output['status'] = false;
                                            $output['msg'] = 'Select Private Tour Upgrade Option Qty';
                                            break;
                                        }
                                    } else {
                                        $output['status'] = false;
                                        $output['msg'] = 'Select Private Tour Time Slot';
                                        break;
                                    }
                                } else {
                                    $output['status'] = false;
                                    $output['msg'] = 'Select Private Tour Adult, Child or Infant Qty';
                                    break;
                                }
                            } else {
                                $output['status'] = false;
                                $output['msg'] = 'Select Date Of Private Tour';
                                break;
                            }
                        } else {
                            $output['status'] = false;
                            $output['msg'] = 'Select Any Transfer Option';
                            break;
                        }
                    }
                } else {
                    if (count($data) == 0) {
                        $output['status'] = false;
                        $output['msg'] = 'Select Private Tour Transfer';
                        break;
                    }
                }
            }
        }

        if ($grouppercentagecheck != '') {
            $checkAllData = 0;

            foreach ($grouppercentagecheck as $gkey => $GH) {
                // if (!isset($Date[$gkey])) {
                //     $output['status'] = false;
                //     $output['msg']    = 'Select Group Rates Date';
                //     break;
                // }

                if ($GH == 'true') {
                    if (isset($request->groupdropdown[$gkey])) {
                        if ($request->groupdropdown[$gkey] > 0) {
                            $checkAllData = 1;
                        } else {
                            $output['status'] = false;
                            $output['msg'] = 'Select Group Rates No Of Guest';
                        }
                    } else {
                        $output['status'] = false;
                        $output['msg'] = 'Select Group Rates No Of Guest';
                    }
                } else {
                    $checkAllData = 1;
                }
            }
        }

        if ($tourCheck == '' && $grouppercentagecheck == '' && $checkAllData == 0) {
            $output['status'] = false;
            $output['msg'] = 'Check Any Tour Option';
        } else {
            if ($checkAllData == 1) {
                $AddToCart = new AddToCart();
                $tourTransferArr = [];
                if ($tourCheck != "") {
                    foreach ($tourCheck as $key => $index) {
                        if ($index == 'true') {
                            $get_product_options = ProductOptions::where('product_id', $activity_id)
                                ->where('id', $key)
                                ->where('status', 1)
                                ->first();
                            $get_tour_transfer_arr = [];
                            $get_private_tour_arr = [];

                            $Data = isset($ActivityData[$key]) ? $ActivityData[$key] : [];

                            if ($get_product_options->is_private_tour == 1) {
                                $get_private_tour_arr['id'] = $key;
                                $get_private_tour_arr['is_private_tour'] = 1;
                                $get_private_tour_arr['date'] = $Date[$key];
                                $get_private_tour_arr['timeslot'] = isset($Timeslot[$key]) ? $Timeslot[$key] : '';
                                $get_private_tour_arr['qty'] = $Data['data']['tour_adult_price']['qty'];
                                $get_private_tour_arr['tour_adult_qty'] = isset($request->dropdown[$key]['tour_adult_price']) ? $request->dropdown[$key]['tour_adult_price'] : 0;
                                $get_private_tour_arr['tour_child_qty'] = isset($request->dropdown[$key]['tour_child_price']) ? $request->dropdown[$key]['tour_child_price'] : 0;
                                $get_private_tour_arr['tour_infant_qty'] = isset($request->dropdown[$key]['tour_infant_price']) ? $request->dropdown[$key]['tour_infant_price'] : 0;

                                if (isset($Data['data']['tour_adult_price']['tour_upgrade_arr'])) {
                                    $tour_upgrade_arr = $Data['data']['tour_adult_price']['tour_upgrade_arr'];
                                    foreach ($tour_upgrade_arr as $upgrade_key => $tour_upgrade_value) {
                                        $get_private_tour_upgrade_arr = [];
                                        if ($tour_upgrade_value['qty']) {
                                            $req_adult_qty = $tour_upgrade_value['qty'];
                                        }
                                        if (isset($Data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                                            $req_child_qty = $Data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                                        }
                                        if (isset($Data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                                            $req_infant_qty = $Data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                                        }
                                        $get_private_tour_upgrade_arr['id'] = $tour_upgrade_value['id'];
                                        $get_private_tour_upgrade_arr['adult_qty'] = $req_adult_qty;
                                        $get_private_tour_upgrade_arr['child_qty'] = $req_child_qty;
                                        $get_private_tour_upgrade_arr['infant_qty'] = $req_infant_qty;
                                        $get_private_tour_arr['tour_upgrade'][] = $get_private_tour_upgrade_arr;
                                    }
                                }
                                $tourTransferArr['private_tour'][] = $get_private_tour_arr;
                            } else {
                                if (isset($Data['tour_transfer_id']) && $Data['tour_transfer_id'] > 0) {
                                    $get_option_details = ProductOptionDetails::where('product_id', $activity_id)
                                        ->where('id', $Data['tour_transfer_id'])
                                        ->first();

                                    if ($get_option_details) {
                                        if ($get_option_details->is_input == 0) {
                                            if (isset($Data['private_car'])) {
                                                $get_car_detail = CarDetails::where('id', $Data['private_car'])
                                                    ->where('status', 'Active')
                                                    ->first();
                                                if ($get_car_detail) {
                                                    $get_tour_transfer_arr['id'] = $key;
                                                    $get_tour_transfer_arr['is_private_transfer'] = 1;
                                                    $get_tour_transfer_arr['transfer_option'] = $Data['tour_transfer_id'];
                                                    $get_tour_transfer_arr['date'] = $Date[$key];
                                                    $get_tour_transfer_arr['car_id'] = $Data['private_car'];
                                                    $get_tour_transfer_arr['timeslot'] = isset($Timeslot[$key]) ? $Timeslot[$key] : '';
                                                    $get_tour_transfer_arr['tour_adult_qty'] = $Data['data']['tour_adult_price']['qty'];
                                                    $get_tour_transfer_arr['tour_child_qty'] = $Data['data']['tour_child_price']['qty'];
                                                    $get_tour_transfer_arr['tour_infant_qty'] = $Data['data']['tour_infant_price']['qty'];
                                                }
                                            }
                                        } else {
                                            $get_tour_transfer_arr['id'] = $key;
                                            $get_tour_transfer_arr['transfer_option'] = $Data['tour_transfer_id'];
                                            $get_tour_transfer_arr['is_private_transfer'] = 0;
                                            $get_tour_transfer_arr['date'] = $Date[$key];
                                            $get_tour_transfer_arr['timeslot'] = isset($Timeslot[$key]) ? $Timeslot[$key] : '';
                                            $get_tour_transfer_arr['tour_adult_qty'] = isset($Data['data']['tour_adult_price']['qty']) ? $Data['data']['tour_adult_price']['qty'] : 0;
                                            $get_tour_transfer_arr['tour_child_qty'] =  isset($Data['data']['tour_child_price']['qty']) ? $Data['data']['tour_child_price']['qty'] : 0;
                                            $get_tour_transfer_arr['tour_infant_qty'] = isset($Data['data']['tour_infant_price']['qty']) ?  $Data['data']['tour_infant_price']['qty'] : 0;
                                        }

                                        if (isset($Data['data']['tour_adult_price']['tour_upgrade_arr'])) {
                                            $tour_upgrade_arr = $Data['data']['tour_adult_price']['tour_upgrade_arr'];
                                            foreach ($tour_upgrade_arr as $upgrade_key => $tour_upgrade_value) {
                                                $get_tour_upgrade_arr = [];
                                                if ($tour_upgrade_value['qty']) {
                                                    $req_adult_qty = $tour_upgrade_value['qty'];
                                                }
                                                if (isset($Data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                                                    $req_child_qty = $Data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                                                }
                                                if (isset($Data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                                                    $req_infant_qty = $Data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                                                }

                                                $get_tour_upgrade_arr['id'] = $tour_upgrade_value['id'];
                                                $get_tour_upgrade_arr['adult_qty'] = $req_adult_qty;
                                                $get_tour_upgrade_arr['child_qty'] = $req_child_qty;
                                                $get_tour_upgrade_arr['infant_qty'] = $req_infant_qty;
                                                $get_tour_transfer_arr['tour_upgrade'][] = $get_tour_upgrade_arr;
                                            }
                                        }
                                        $tourTransferArr['tour_transfer'][] = $get_tour_transfer_arr;
                                    }
                                }
                            }
                        }
                    }
                }

                $get_group_percentage_arr = [];
                if ($grouppercentagecheck != '') {
                    foreach ($grouppercentagecheck as $gkey => $GH) {
                        if ($GH == 'true') {
                            $get_group_percentage_arr['id'] = $gkey;
                            $get_group_percentage_arr['is_group_percentage'] = 1;
                            $get_group_percentage_arr['date'] = $Date[$gkey];
                            $get_group_percentage_arr['qty'] = $request->groupdropdown[$gkey];
                            $tourTransferArr['group_percentage'][] = $get_group_percentage_arr;
                        }
                    }
                }
                $AddToCart['product_id'] = $activity_id;
                $AddToCart['product_type'] = 'excursion';
                $AddToCart['user_id'] = $user_id;
                $AddToCart['token'] = $request->token;
                $AddToCart['extra'] = json_encode($tourTransferArr);
                $AddToCart['status'] = 'Active';
                $AddToCart['total'] = 0;

                // return $AddToCart;
                $AddToCart->save();
                $output['status'] = true;
                $output['msg'] = 'Add To Cart Successfully...';
            }
        }

        return json_encode($output);
    }

    public function get_sub_category(Request $request)
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
        $offset = $request->offset;
        $limit = $offset * $setLimit;
        $is_filter = false;
        $ProductCount = Product::where(['status' => 'Active', 'is_delete' => 0, 'product_type' => 'excursion'])->where('slug', '!=', '');

        $Product = Product::where(['status' => 'Active', 'is_delete' => 0, 'product_type' => 'excursion'])->where('slug', '!=', '');

        $CategoryProductArr = [];

        $CategoryProduct = $Product->get();

        $category = $request->category;

        $checkSUb = [];
        foreach ($CategoryProduct as $ckey => $CP) {

            $ProductCategory = ProductCategory::where('product_id', $CP['id'])->groupBy('category')->get();

            foreach ($ProductCategory as $pkey => $PC) {
                $getArr = [];
                $Category = Category::select('categories.*', 'category_language.description as name')
                    ->where('categories.id', $PC['sub_category'])
                    ->where('categories.parent', $category)
                    ->where('categories.status', 'Active')
                    ->join('category_language', 'categories.id', '=', 'category_language.category_id')
                    ->groupBy('categories.id')
                    ->first();

                if ($Category != '' && !in_array($PC['sub_category'], $checkSUb)) {
                    $CategoryProductArr[] = $Category;
                    $checkSUb[] = $PC['sub_category'];
                }
            }
        }

        $sub_category = $CategoryProductArr;
        $output['status'] = true;
        $output['data'] = $sub_category;
        $output['msg'] = 'Add To Cart Successfully...';
        return json_encode($output);
    }

    //GEt Category Product
    public function get_category_product(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $validation = Validator::make($request->all(), [
            'language'      => 'required',
            'category_slug' => 'required',
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
        $language = $request->language;
        $category_slug = $request->category_slug;
        $Category = Category::select('categories.*', 'category_language.description as name')
            ->where('categories.slug', $category_slug)
            ->where('categories.status', 'Active')
            ->join('category_language', 'categories.id', '=', 'category_language.category_id')
            ->first();
        if ($Category) {
            $category_id = $Category['id'];
            // return $category_id;
            $setLimit    = 9;
            $offset      = $request->offset;
            $limit       = $offset * $setLimit;
            $is_filter   = false;
            $cat_product_id_arr   = [];

            $get_cate_product_id = ProductCategory::where('category', $category_id)->get();
            foreach ($get_cate_product_id as $key => $value_id) {
                # code...
                $cat_product_id_arr[] = $value_id['product_id'];
            }

            // return $cat_product_id_arr;

            $Product = Product::select('products.*')
                ->leftjoin('product_language', 'product_language.product_id', '=', 'products.id')
                ->where(['status' => 'Active', 'is_delete' => 0])
                ->whereIn('products.id', $cat_product_id_arr)
                // ->where('product_type', 'excursion')
                // ->orWhere('product_type', 'lodge')
                ->where('product_language.language_id', $language)
                ->where('slug', '!=', '')
                ->orderBy('products.id', 'DESC');
            $ProductCount = $Product->count();
            $Product = $Product->offset($limit)
                ->limit($setLimit)
                ->get();
            $ProductArr = [];
            $output['page_count'] = ceil($ProductCount / $setLimit);
            if (!$Product->isEmpty()) {
                foreach ($Product as $key => $P) {
                    $product_id_arr[] = $P['id'];
                    $productLang      = ProductLanguage::where(['product_id' => $P['id'], 'language_id' => $language])->first();
                    $title            = '';
                    $main_description = '';
                    $short_description = '';
                    if ($productLang) {
                        $title             = $productLang->description;
                        $main_description  = $productLang->main_description;
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
                    $getProductArr = [];
                    $getProductArr['ratings'] = get_rating($P['id']);

                    $getProductArr['id']                = $P['id'];
                    $getProductArr['image']             = $P['image']                  != '' ? asset('public/uploads/product_images/' . $P['image']) : asset('public/assets/img/no_image.jpeg');
                    $getProductArr['name']              = short_description_limit($title, 50);
                    $getProductArr['full_name']            = $title;
                    $getProductArr['main_description']  = Str::limit($main_description, 60);
                    $getProductArr['short_description'] = short_description_limit($short_description, 50);
                    $getProductArr['duration']          = $duration;
                    $getProductArr['city']              = $city;
                    $getProductArr['slug']              = $P['slug'];
                    $getProductArr['product_type']      = $P['product_type'];
                    $getProductArr['total_sold']        = $P['how_many_are_sold']     !== '' ? $P['how_many_are_sold'] : 0;
                    $getProductArr['per_value']         = $P['per_value'];
                    $getProductArr['image_text']        = $P['image_text'] ?? null;
                    $getProductArr['price']             = $P['original_price'] ?? 0;
                    $getProductArr['selling_price']     = $P['selling_price'] ?? 0;
                    $getProductArr['button']            = $P['product_bookable_type'] === 'bookable' ? 'Book Now' : 'On Request';
                    $getProductArr['price_html']        = get_price_front($P['id'], $request->user_id, $P['product_type']);

                    $ProductArr[] = $getProductArr;
                }
                // return  $product_id_arr;
                $data['products'] = $ProductArr;
                $data['category_name'] = 'Explore ' . $Category['name'] . ' Activities';
                $output['data'] = $data;
                $output['status'] = true;
                $output['message'] = 'Data Fetched Successfully...';
            }
        }
        return json_encode($output);
    }

    //Excursion Request
    public function activity_request(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['msg'] = 'Record Not Found';
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
        $tourCheck = $request->tourcheck;
        $grouppercentagecheck = $request->grouppercentagecheck;
        $Date = $request->date;
        $ActivityData = $request->data;
        $Timeslot = $request->timeslot;
        $user_id = $request->user_id != '' ? checkDecrypt($request->user_id) : 0;
        $checkAllData = 0;

        if ($tourCheck != '') {
            $tourCheck = \array_filter($tourCheck, static function ($element) {
                return $element !== 'false';
                //                   ↑
                // Array value which you want to delete
            });

            foreach ($tourCheck as $key => $index) {
                // if ($index == 'false') {
                //     $output['status'] = false;
                //     $output['msg']    = 'Check Any Tour Option';
                //     break;
                // }

                $get_product_options = ProductOptions::where('product_id', $activity_id)
                    ->where('id', $key)
                    ->where('status', 1)
                    ->first();
                if (isset($key)) {
                    if (isset($request->data[$key])) {
                        $data = $request->data[$key];
                    } else {
                        if ($get_product_options->is_private_tour == 1) {
                            $output['status'] = false;
                            $output['msg'] = 'Select Private Tour Date';
                            break;
                        } else {
                            $data = [];
                        }
                    }
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
                if (isset($data['data']['tour_infant_price']['qty'])) {
                    $req_infant_qty = $data['data']['tour_infant_price']['qty'];
                }
                $totalQty = $req_adult_qty + $req_child_qty + $req_infant_qty;
                $resoponse = [];
                $PriceBreakDown = [];

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

                    if (isset($data['tour_transfer_id']) && $data['tour_transfer_id'] > 0) {
                        $checkAllData = 0;
                        $get_option_details = ProductOptionDetails::where('product_id', $activity_id)
                            ->where('product_option_id', $key)
                            ->where('id', $data['tour_transfer_id'])
                            ->first();

                        $checkPrivateCar = 1;

                        if ($get_option_details) {
                            if ($get_option_details->is_input == 0) {
                                $checkPrivateCar = 0;

                                if (isset($data['private_car'])) {
                                    $get_car_detail = CarDetails::where('id', $data['private_car'])
                                        ->where('status', 'Active')
                                        ->first();
                                    if ($get_car_detail) {
                                        $checkPrivateCar = 1;
                                    }
                                }
                            }
                        }

                        if ($checkPrivateCar == 1) {
                            if (isset($Date[$key]) && $Date[$key] != '') {
                                if ($totalQty > 0) {
                                    $get_time_id = [];
                                    if ($get_product_options->available_type == 'daily') {
                                        if ($get_product_options->time_available) {
                                            $get_time_id = explode(',', $get_product_options->time_available);
                                        }
                                    }

                                    if ($get_product_options->available_type == 'date_available') {
                                        if ($get_product_options->date_available) {
                                            $get_dates = (array) json_decode($get_product_options->date_available, true);
                                            if (array_key_exists($Date[$key], $get_dates)) {
                                                if (isset($get_dates[$Date[$key]]) && $get_dates[$Date[$key]] != '') {
                                                    $get_time_id = explode(',', $get_dates[$Date[$key]]);
                                                }
                                            }
                                        }
                                    }

                                    if ($get_product_options->available_type == 'days_available') {
                                        $day = date('l', strtotime($Date[$key]));
                                        if ($get_product_options->days_available) {
                                            $get_days = (array) json_decode($get_product_options->days_available, true);
                                            if (array_key_exists($day, $get_days)) {
                                                if (isset($get_days[$day]) && $get_days[$day] != '') {
                                                    $get_time_id = explode(',', $get_days[$day]);
                                                }
                                            }
                                        }
                                    }

                                    $checkTimeSlot = 0;
                                    if (count($get_time_id) > 0) {
                                        if (isset($Timeslot[$key])) {
                                            $checkTimeSlot = 1;
                                        } else {
                                            $checkTimeSlot = 0;
                                        }
                                    } else {
                                        $checkTimeSlot = 1;
                                    }
                                    if ($checkTimeSlot == 1) {
                                        $checkTourUpgrade = 0;
                                        $totalUpgradeQty = 0;
                                        if (isset($data['data']['tour_adult_price']['tour_upgrade_arr'])) {
                                            $tour_upgrade_arr = $data['data']['tour_adult_price']['tour_upgrade_arr'];

                                            foreach ($tour_upgrade_arr as $upgrade_key => $tour_upgrade_value) {
                                                $get_product_option_tour_upgrade = ProductOptionTourUpgrade::where('id', $tour_upgrade_value['id'])->first();

                                                $totalUpgradeQty = 0;
                                                if ($get_product_option_tour_upgrade) {
                                                    if ($tour_upgrade_value['qty'] != '') {
                                                        $req_adult_qty = $tour_upgrade_value['qty'];
                                                        $totalUpgradeQty += $req_adult_qty;
                                                    }
                                                    if (isset($data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                                                        $req_child_qty = $data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                                                        $totalUpgradeQty += $req_child_qty;
                                                    }
                                                    if (isset($data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                                                        $req_infant_qty = $data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                                                        $totalUpgradeQty += $req_infant_qty;
                                                    }
                                                }
                                            }
                                            if ($totalUpgradeQty > 0) {
                                                $checkTourUpgrade = 1;
                                            }
                                        } else {
                                            $checkTourUpgrade = 1;
                                        }
                                        if ($checkTourUpgrade == 1) {
                                            $checkAllData = 1;
                                        } else {
                                            $output['status'] = false;
                                            $output['msg'] = 'Select Upgrade Option Qty';
                                            break;
                                        }
                                    } else {
                                        $output['status'] = false;
                                        $output['msg'] = 'Select Timeslot Of Option';
                                        break;
                                    }
                                } else {
                                    $output['status'] = false;
                                    $output['msg'] = 'Select Adult, Child or Infant Qty';
                                    break;
                                }
                            } else {
                                $output['status'] = false;
                                $output['msg'] = 'Select Date Of Tranfer Option';
                                break;
                            }
                        } else {
                            $output['status'] = false;
                            $output['msg'] = 'Select Private Car';
                            break;
                        }
                    } else {
                        if ($get_product_options->is_private_tour == 1) {
                            $checkAllData = 0;
                            if (isset($Date[$key]) && $Date[$key] != '') {
                                if ($totalQty > 0) {
                                    $get_time_id = [];
                                    if ($get_product_options->available_type == 'daily') {
                                        if ($get_product_options->time_available) {
                                            $get_time_id = explode(',', $get_product_options->time_available);
                                        }
                                    }

                                    if ($get_product_options->available_type == 'date_available') {
                                        if ($get_product_options->date_available) {
                                            $get_dates = (array) json_decode($get_product_options->date_available, true);
                                            if (array_key_exists($Date[$key], $get_dates)) {
                                                if (isset($get_dates[$Date[$key]]) && $get_dates[$Date[$key]] != '') {
                                                    $get_time_id = explode(',', $get_dates[$Date[$key]]);
                                                }
                                            }
                                        }
                                    }

                                    if ($get_product_options->available_type == 'days_available') {
                                        $day = date('l', strtotime($Date[$key]));
                                        if ($get_product_options->days_available) {
                                            $get_days = (array) json_decode($get_product_options->days_available, true);
                                            if (array_key_exists($day, $get_days)) {
                                                if (isset($get_days[$day]) && $get_days[$day] != '') {
                                                    $get_time_id = explode(',', $get_days[$day]);
                                                }
                                            }
                                        }
                                    }

                                    $checkTimeSlot = 0;
                                    if (count($get_time_id) > 0) {
                                        if (isset($Timeslot[$key])) {
                                            $checkTimeSlot = 1;
                                        } else {
                                            $checkTimeSlot = 0;
                                        }
                                    } else {
                                        $checkTimeSlot = 1;
                                    }

                                    if ($checkTimeSlot == 1) {
                                        $checkTourUpgrade = 0;
                                        $totalUpgradeQty = 0;
                                        if (isset($data['data']['tour_adult_price']['tour_upgrade_arr'])) {
                                            $tour_upgrade_arr = $data['data']['tour_adult_price']['tour_upgrade_arr'];

                                            foreach ($tour_upgrade_arr as $upgrade_key => $tour_upgrade_value) {
                                                $get_product_option_tour_upgrade = ProductOptionTourUpgrade::where('id', $tour_upgrade_value['id'])->first();
                                                $totalUpgradeQty = 0;
                                                if ($get_product_option_tour_upgrade) {
                                                    if ($tour_upgrade_value['qty'] != '') {
                                                        $req_adult_qty = $tour_upgrade_value['qty'];
                                                        $totalUpgradeQty += $req_adult_qty;
                                                    }
                                                    if (isset($data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                                                        $req_child_qty = $data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                                                        $totalUpgradeQty += $req_child_qty;
                                                    }
                                                    if (isset($data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                                                        $req_infant_qty = $data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                                                        $totalUpgradeQty += $req_infant_qty;
                                                    }
                                                }
                                            }

                                            if ($totalUpgradeQty > 0) {
                                                $checkTourUpgrade = 1;
                                            }
                                        } else {
                                            $checkTourUpgrade = 1;
                                        }

                                        if ($checkTourUpgrade == 1) {
                                            $checkAllData = 1;
                                        } else {
                                            $output['status'] = false;
                                            $output['msg'] = 'Select Private Tour Upgrade Option Qty';
                                            break;
                                        }
                                    } else {
                                        $output['status'] = false;
                                        $output['msg'] = 'Select Private Tour Time Slot';
                                        break;
                                    }
                                } else {
                                    $output['status'] = false;
                                    $output['msg'] = 'Select Private Tour Adult, Child or Infant Qty';
                                    break;
                                }
                            } else {
                                $output['status'] = false;
                                $output['msg'] = 'Select Date Of Private Tour';
                                break;
                            }
                        } else {
                            $output['status'] = false;
                            $output['msg'] = 'Select Any Transfer Option';
                            break;
                        }
                    }
                } else {
                    if (count($data) == 0) {
                        $output['status'] = false;
                        $output['msg'] = 'Select Private Tour Transfer';
                        break;
                    }
                }
            }
        }

        if ($grouppercentagecheck != '') {
            $checkAllData = 0;

            foreach ($grouppercentagecheck as $gkey => $GH) {
                // if (!isset($Date[$gkey])) {
                //     $output['status'] = false;
                //     $output['msg']    = 'Select Group Rates Date';
                //     break;
                // }

                if ($GH == 'true') {
                    if (isset($request->groupdropdown[$gkey])) {
                        if ($request->groupdropdown[$gkey] > 0) {
                            $checkAllData = 1;
                        } else {
                            $output['status'] = false;
                            $output['msg'] = 'Select Group Rates No Of Guest';
                        }
                    } else {
                        $output['status'] = false;
                        $output['msg'] = 'Select Group Rates No Of Guest';
                    }
                } else {
                    $checkAllData = 1;
                }
            }
        }

        if ($tourCheck == '' && $grouppercentagecheck == '' && $checkAllData == 0) {
            $output['status'] = false;
            $output['msg'] = 'Check Any Tour Option';
        } else {
            if ($checkAllData == 1) {
                $ProductRequestForm = new ProductRequestForm();
                $tourTransferArr = [];

                foreach ($tourCheck as $key => $index) {
                    if ($index == 'true') {
                        $get_product_options = ProductOptions::where('product_id', $activity_id)
                            ->where('id', $key)
                            ->where('status', 1)
                            ->first();
                        $get_tour_transfer_arr = [];
                        $get_private_tour_arr = [];

                        $Data = isset($ActivityData[$key]) ? $ActivityData[$key] : [];

                        if ($get_product_options->is_private_tour == 1) {
                            $get_private_tour_arr['id'] = $key;
                            $get_private_tour_arr['is_private_tour'] = 1;
                            $get_private_tour_arr['date'] = $Date[$key];
                            $get_private_tour_arr['timeslot'] = isset($Timeslot[$key]) ? $Timeslot[$key] : '';
                            $get_private_tour_arr['qty'] = $Data['data']['tour_adult_price']['qty'];
                            $get_private_tour_arr['tour_adult_qty'] = isset($request->dropdown[$key]['tour_adult_price']) ? $request->dropdown[$key]['tour_adult_price'] : 0;
                            $get_private_tour_arr['tour_child_qty'] = isset($request->dropdown[$key]['tour_child_price']) ? $request->dropdown[$key]['tour_child_price'] : 0;
                            $get_private_tour_arr['tour_infant_qty'] = isset($request->dropdown[$key]['tour_infant_price']) ? $request->dropdown[$key]['tour_infant_price'] : 0;

                            if (isset($Data['data']['tour_adult_price']['tour_upgrade_arr'])) {
                                $tour_upgrade_arr = $Data['data']['tour_adult_price']['tour_upgrade_arr'];
                                foreach ($tour_upgrade_arr as $upgrade_key => $tour_upgrade_value) {
                                    $get_private_tour_upgrade_arr = [];
                                    if ($tour_upgrade_value['qty']) {
                                        $req_adult_qty = $tour_upgrade_value['qty'];
                                    }
                                    if (isset($Data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                                        $req_child_qty = $Data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                                    }
                                    if (isset($Data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                                        $req_infant_qty = $Data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                                    }
                                    $get_private_tour_upgrade_arr['id'] = $tour_upgrade_value['id'];
                                    $get_private_tour_upgrade_arr['adult_qty'] = $req_adult_qty;
                                    $get_private_tour_upgrade_arr['child_qty'] = $req_child_qty;
                                    $get_private_tour_upgrade_arr['infant_qty'] = $req_infant_qty;
                                    $get_private_tour_arr['tour_upgrade'][] = $get_private_tour_upgrade_arr;
                                }
                            }
                            $tourTransferArr['private_tour'][] = $get_private_tour_arr;
                        } else {
                            if (isset($Data['tour_transfer_id']) && $Data['tour_transfer_id'] > 0) {
                                $get_option_details = ProductOptionDetails::where('product_id', $activity_id)
                                    ->where('id', $Data['tour_transfer_id'])
                                    ->first();

                                if ($get_option_details) {
                                    if ($get_option_details->is_input == 0) {
                                        if (isset($Data['private_car'])) {
                                            $get_car_detail = CarDetails::where('id', $Data['private_car'])
                                                ->where('status', 'Active')
                                                ->first();
                                            if ($get_car_detail) {
                                                $get_tour_transfer_arr['id'] = $key;
                                                $get_tour_transfer_arr['is_private_transfer'] = 1;
                                                $get_tour_transfer_arr['transfer_option'] = $Data['tour_transfer_id'];
                                                $get_tour_transfer_arr['date'] = $Date[$key];
                                                $get_tour_transfer_arr['car_id'] = $Data['private_car'];
                                                $get_tour_transfer_arr['timeslot'] = isset($Timeslot[$key]) ? $Timeslot[$key] : '';
                                                $get_tour_transfer_arr['tour_adult_qty'] = $Data['data']['tour_adult_price']['qty'];
                                                $get_tour_transfer_arr['tour_child_qty'] = $Data['data']['tour_child_price']['qty'];
                                                $get_tour_transfer_arr['tour_infant_qty'] = $Data['data']['tour_infant_price']['qty'];
                                            }
                                        }
                                    } else {
                                        $get_tour_transfer_arr['id'] = $key;
                                        $get_tour_transfer_arr['transfer_option'] = $Data['tour_transfer_id'];
                                        $get_tour_transfer_arr['is_private_transfer'] = 0;
                                        $get_tour_transfer_arr['date'] = $Date[$key];
                                        $get_tour_transfer_arr['timeslot'] = isset($Timeslot[$key]) ? $Timeslot[$key] : '';
                                        $get_tour_transfer_arr['tour_adult_qty'] = $Data['data']['tour_adult_price']['qty'];
                                        $get_tour_transfer_arr['tour_child_qty'] = $Data['data']['tour_child_price']['qty'];
                                        $get_tour_transfer_arr['tour_infant_qty'] = $Data['data']['tour_infant_price']['qty'];
                                    }

                                    if (isset($Data['data']['tour_adult_price']['tour_upgrade_arr'])) {
                                        $tour_upgrade_arr = $Data['data']['tour_adult_price']['tour_upgrade_arr'];
                                        foreach ($tour_upgrade_arr as $upgrade_key => $tour_upgrade_value) {
                                            $get_tour_upgrade_arr = [];
                                            if ($tour_upgrade_value['qty']) {
                                                $req_adult_qty = $tour_upgrade_value['qty'];
                                            }
                                            if (isset($Data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                                                $req_child_qty = $Data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                                            }
                                            if (isset($Data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                                                $req_infant_qty = $Data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                                            }

                                            $get_tour_upgrade_arr['id'] = $tour_upgrade_value['id'];
                                            $get_tour_upgrade_arr['adult_qty'] = $req_adult_qty;
                                            $get_tour_upgrade_arr['child_qty'] = $req_child_qty;
                                            $get_tour_upgrade_arr['infant_qty'] = $req_infant_qty;
                                            $get_tour_transfer_arr['tour_upgrade'][] = $get_tour_upgrade_arr;
                                        }
                                    }
                                    $tourTransferArr['tour_transfer'][] = $get_tour_transfer_arr;
                                }
                            }
                        }
                    }
                }

                $get_group_percentage_arr = [];
                if ($grouppercentagecheck != '') {
                    foreach ($grouppercentagecheck as $gkey => $GH) {
                        if ($GH == 'true') {
                            $get_group_percentage_arr['id'] = $gkey;
                            $get_group_percentage_arr['is_group_percentage'] = 1;
                            $get_group_percentage_arr['date'] = $Date[$gkey];
                            $get_group_percentage_arr['qty'] = $request->groupdropdown[$gkey];
                            $tourTransferArr['group_percentage'][] = $get_group_percentage_arr;
                        }
                    }
                }
                $ProductRequestForm['product_id'] = $activity_id;
                $ProductRequestForm['product_type'] = 'excursion';
                $ProductRequestForm['user_id'] = $user_id;
                $ProductRequestForm['token'] = $request->token;
                $ProductRequestForm['extra'] = json_encode($tourTransferArr);
                $ProductRequestForm['status'] = 'Active';
                $ProductRequestForm['total'] = 0;

                // return $ProductRequestForm;
                $ProductRequestForm->save();
                $output['status'] = true;
                $output['msg'] = 'Request Add Successfully...';
            }
        }

        return json_encode($output);
    }


    //Send REquest Validation 
    //Add To Cart
    public function activity_request_validation(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['msg'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            'activity_id' => 'required',
            'language'    => 'required',
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

        $data                 = [];
        $total_amount         = 0;
        $get_total            = 0;
        $activity_id          = $request->activity_id;
        $language             = $request->language;
        $Product              = Product::where('slug', $activity_id)->first();
        $activity_id          = $Product->id;
        $optionID             = $request->optionID;
        $tourCheck            = $request->tourcheck;
        $grouppercentagecheck = $request->grouppercentagecheck;
        $Date                 = $request->date;
        $ActivityData         = $request->data;
        $Timeslot             = $request->timeslot;
        $user_id              = $request->user_id != '' ? checkDecrypt($request->user_id) : 0;
        $checkAllData         = 0;

        if ($tourCheck != '') {
            $tourCheck = \array_filter($tourCheck, static function ($element) {
                return $element !== 'false';
                //                   ↑
                // Array value which you want to delete
            });

            foreach ($tourCheck as $key => $index) {
                $get_product_options = ProductOptions::where('product_id', $activity_id)
                    ->where('id', $key)
                    ->where('status', 1)
                    ->first();
                if (isset($key)) {
                    if (isset($request->data[$key])) {
                        $data = $request->data[$key];
                    } else {
                        if ($get_product_options->is_private_tour == 1) {
                            $output['status'] = false;
                            $output['msg'] = 'Select Private Tour Date';
                            break;
                        } else {
                            $data = [];
                        }
                    }
                }
                $req_adult_qty  = 0;
                $req_child_qty  = 0;
                $req_infant_qty = 0;
                $language       = $request->language;
                if (isset($data['data']['tour_adult_price']['qty'])) {
                    $req_adult_qty = $data['data']['tour_adult_price']['qty'];
                }
                if (isset($data['data']['tour_child_price']['qty'])) {
                    $req_child_qty = $data['data']['tour_child_price']['qty'];
                }
                if (isset($data['data']['tour_infant_price']['qty'])) {
                    $req_infant_qty = $data['data']['tour_infant_price']['qty'];
                }
                if (isset($data['data']['tour_infant_price']['qty'])) {
                    $req_infant_qty = $data['data']['tour_infant_price']['qty'];
                }
                $totalQty       = $req_adult_qty + $req_child_qty + $req_infant_qty;
                $resoponse      = [];
                $PriceBreakDown = [];

                if ($get_product_options && count($data) > 0) {
                    $adult_price           = 0;
                    $total_child_price     = 0;
                    $total_infant_price    = 0;
                    $adult_price           = 0;
                    $child_price           = 0;
                    $infant_price          = 0;
                    $get_main_option_data  = [];
                    $ProductOptionLanguage = ProductOptionLanguage::where('option_id', $get_product_options['id'])->first();
                    //option
                    $get_main_option_data['option_name'] = '';
                    if ($ProductOptionLanguage) {
                        $get_main_option_data['option_name'] = $ProductOptionLanguage['title'];
                    }

                    if (isset($data['tour_transfer_id']) && $data['tour_transfer_id'] > 0) {
                        $checkAllData = 0;
                        $get_option_details = ProductOptionDetails::where('product_id', $activity_id)
                            ->where('product_option_id', $key)
                            ->where('id', $data['tour_transfer_id'])
                            ->first();

                        $checkPrivateCar = 1;

                        if ($get_option_details) {
                            if ($get_option_details->is_input == 0) {
                                $checkPrivateCar = 0;

                                if (isset($data['private_car'])) {
                                    $get_car_detail = CarDetails::where('id', $data['private_car'])
                                        ->where('status', 'Active')
                                        ->first();
                                    if ($get_car_detail) {
                                        $checkPrivateCar = 1;
                                    }
                                }
                            }
                        }

                        if ($checkPrivateCar == 1) {
                            if (isset($Date[$key]) && $Date[$key] != '') {
                                if ($totalQty > 0) {
                                    $get_time_id = [];
                                    if ($get_product_options->available_type == 'daily') {
                                        if ($get_product_options->time_available) {
                                            $get_time_id = explode(',', $get_product_options->time_available);
                                        }
                                    }

                                    if ($get_product_options->available_type == 'date_available') {
                                        if ($get_product_options->date_available) {
                                            $get_dates = (array) json_decode($get_product_options->date_available, true);
                                            if (array_key_exists($Date[$key], $get_dates)) {
                                                if (isset($get_dates[$Date[$key]]) && $get_dates[$Date[$key]] != '') {
                                                    $get_time_id = explode(',', $get_dates[$Date[$key]]);
                                                }
                                            }
                                        }
                                    }

                                    if ($get_product_options->available_type == 'days_available') {
                                        $day = date('l', strtotime($Date[$key]));
                                        if ($get_product_options->days_available) {
                                            $get_days = (array) json_decode($get_product_options->days_available, true);
                                            if (array_key_exists($day, $get_days)) {
                                                if (isset($get_days[$day]) && $get_days[$day] != '') {
                                                    $get_time_id = explode(',', $get_days[$day]);
                                                }
                                            }
                                        }
                                    }

                                    $checkTimeSlot = 0;
                                    if (count($get_time_id) > 0) {
                                        if (isset($Timeslot[$key])) {
                                            $checkTimeSlot = 1;
                                        } else {
                                            $checkTimeSlot = 0;
                                        }
                                    } else {
                                        $checkTimeSlot = 1;
                                    }
                                    if ($checkTimeSlot == 1) {
                                        $checkTourUpgrade = 0;
                                        $totalUpgradeQty = 0;
                                        if (isset($data['data']['tour_adult_price']['tour_upgrade_arr'])) {
                                            $tour_upgrade_arr = $data['data']['tour_adult_price']['tour_upgrade_arr'];

                                            foreach ($tour_upgrade_arr as $upgrade_key => $tour_upgrade_value) {
                                                $get_product_option_tour_upgrade = ProductOptionTourUpgrade::where('id', $tour_upgrade_value['id'])->first();

                                                $totalUpgradeQty = 0;
                                                if ($get_product_option_tour_upgrade) {
                                                    if ($tour_upgrade_value['qty'] != '') {
                                                        $req_adult_qty = $tour_upgrade_value['qty'];
                                                        $totalUpgradeQty += $req_adult_qty;
                                                    }
                                                    if (isset($data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                                                        $req_child_qty = $data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                                                        $totalUpgradeQty += $req_child_qty;
                                                    }
                                                    if (isset($data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                                                        $req_infant_qty = $data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                                                        $totalUpgradeQty += $req_infant_qty;
                                                    }
                                                }
                                            }
                                            if ($totalUpgradeQty > 0) {
                                                $checkTourUpgrade = 1;
                                            }
                                        } else {
                                            $checkTourUpgrade = 1;
                                        }
                                        if ($checkTourUpgrade == 1) {
                                            $checkAllData = 1;
                                        } else {
                                            $output['status'] = false;
                                            $output['msg'] = 'Select Upgrade Option Qty';
                                            break;
                                        }
                                    } else {
                                        $output['status'] = false;
                                        $output['msg'] = 'Select Timeslot Of Option';
                                        break;
                                    }
                                } else {
                                    $output['status'] = false;
                                    $output['msg'] = 'Select Adult, Child or Infant Qty';
                                    break;
                                }
                            } else {
                                $output['status'] = false;
                                $output['msg'] = 'Select Date Of Tranfer Option';
                                break;
                            }
                        } else {
                            $output['status'] = false;
                            $output['msg'] = 'Select Private Car';
                            break;
                        }
                    } else {
                        if ($get_product_options->is_private_tour == 1) {
                            $checkAllData = 0;
                            if (isset($Date[$key]) && $Date[$key] != '') {
                                if ($totalQty > 0) {
                                    $get_time_id = [];
                                    if ($get_product_options->available_type == 'daily') {
                                        if ($get_product_options->time_available) {
                                            $get_time_id = explode(',', $get_product_options->time_available);
                                        }
                                    }

                                    if ($get_product_options->available_type == 'date_available') {
                                        if ($get_product_options->date_available) {
                                            $get_dates = (array) json_decode($get_product_options->date_available, true);
                                            if (array_key_exists($Date[$key], $get_dates)) {
                                                if (isset($get_dates[$Date[$key]]) && $get_dates[$Date[$key]] != '') {
                                                    $get_time_id = explode(',', $get_dates[$Date[$key]]);
                                                }
                                            }
                                        }
                                    }

                                    if ($get_product_options->available_type == 'days_available') {
                                        $day = date('l', strtotime($Date[$key]));
                                        if ($get_product_options->days_available) {
                                            $get_days = (array) json_decode($get_product_options->days_available, true);
                                            if (array_key_exists($day, $get_days)) {
                                                if (isset($get_days[$day]) && $get_days[$day] != '') {
                                                    $get_time_id = explode(',', $get_days[$day]);
                                                }
                                            }
                                        }
                                    }

                                    $checkTimeSlot = 0;
                                    if (count($get_time_id) > 0) {
                                        if (isset($Timeslot[$key])) {
                                            $checkTimeSlot = 1;
                                        } else {
                                            $checkTimeSlot = 0;
                                        }
                                    } else {
                                        $checkTimeSlot = 1;
                                    }

                                    if ($checkTimeSlot == 1) {
                                        $checkTourUpgrade = 0;
                                        $totalUpgradeQty = 0;
                                        if (isset($data['data']['tour_adult_price']['tour_upgrade_arr'])) {
                                            $tour_upgrade_arr = $data['data']['tour_adult_price']['tour_upgrade_arr'];

                                            foreach ($tour_upgrade_arr as $upgrade_key => $tour_upgrade_value) {
                                                $get_product_option_tour_upgrade = ProductOptionTourUpgrade::where('id', $tour_upgrade_value['id'])->first();
                                                $totalUpgradeQty = 0;
                                                if ($get_product_option_tour_upgrade) {
                                                    if ($tour_upgrade_value['qty'] != '') {
                                                        $req_adult_qty    = $tour_upgrade_value['qty'];
                                                        $totalUpgradeQty += $req_adult_qty;
                                                    }
                                                    if (isset($data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                                                        $req_child_qty   = $data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                                                        $totalUpgradeQty += $req_child_qty;
                                                    }
                                                    if (isset($data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                                                        $req_infant_qty  = $data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                                                        $totalUpgradeQty += $req_infant_qty;
                                                    }
                                                }
                                            }
                                            if ($totalUpgradeQty > 0) {
                                                $checkTourUpgrade = 1;
                                            }
                                        } else {
                                            $checkTourUpgrade = 1;
                                        }

                                        if ($checkTourUpgrade == 1) {
                                            $checkAllData = 1;
                                        } else {
                                            $output['status'] = false;
                                            $output['msg'] = 'Select Private Tour Upgrade Option Qty';
                                            break;
                                        }
                                    } else {
                                        $output['status'] = false;
                                        $output['msg'] = 'Select Private Tour Time Slot';
                                        break;
                                    }
                                } else {
                                    $output['status'] = false;
                                    $output['msg'] = 'Select Private Tour Adult, Child or Infant Qty';
                                    break;
                                }
                            } else {
                                $output['status'] = false;
                                $output['msg'] = 'Select Date Of Private Tour';
                                break;
                            }
                        } else {
                            $output['status'] = false;
                            $output['msg'] = 'Select Any Transfer Option';
                            break;
                        }
                    }
                } else {
                    if (count($data) == 0) {
                        $output['status'] = false;
                        $output['msg'] = 'Select Private Tour Transfer';
                        break;
                    }
                }
            }
        }

        if ($grouppercentagecheck != '') {
            $checkAllData = 0;

            foreach ($grouppercentagecheck as $gkey => $GH) {
                if ($GH == 'true') {
                    if (isset($request->groupdropdown[$gkey])) {
                        if ($request->groupdropdown[$gkey] > 0) {
                            $checkAllData = 1;
                        } else {
                            $output['status'] = false;
                            $output['msg'] = 'Select Group Rates No Of Guest';
                        }
                    } else {
                        $output['status'] = false;
                        $output['msg'] = 'Select Group Rates No Of Guest';
                    }
                } else {
                    $checkAllData = 1;
                }
            }
        }

        if ($tourCheck == '' && $grouppercentagecheck == '' && $checkAllData == 0) {
            $output['status'] = false;
            $output['msg'] = 'Check Any Tour Option';
        } else {
            if ($checkAllData == 1) {
                $get_detail      = array();
                $tourTransferArr                     = [];
                $tourTransferArr['tour_transfer']    = [];
                $tourTransferArr['private_tour']     = [];
                $tourTransferArr['group_percentage'] = [];
                if ($tourCheck != "") {
                    foreach ($tourCheck as $key => $index) {
                        if ($index == 'true') {
                            $get_product_options = ProductOptions::where('product_id', $activity_id)
                                ->where('id', $key)
                                ->where('status', 1)
                                ->first();
                            $ProductOptionLanguage = ProductOptionLanguage::where('product_id', $activity_id)->get();
                            $get_tour_transfer_arr  = [];
                            $get_private_tour_arr   = [];


                            $Data = isset($ActivityData[$key]) ? $ActivityData[$key] : [];

                            if ($get_product_options->is_private_tour == 1) {
                                $get_private_tour_arr['id']              = $key;
                                $get_private_tour_arr['title']           = getLanguageTranslate($ProductOptionLanguage, $language, $key, 'title', 'option_id');
                                $get_private_tour_arr['is_private_tour'] = 1;
                                $get_private_tour_arr['date']            = $Date[$key];
                                $get_private_tour_arr['timeslot']        = isset($Timeslot[$key]) ? $Timeslot[$key] : '';
                                $get_private_tour_arr['qty']             = $Data['data']['tour_adult_price']['qty'];
                                $get_private_tour_arr['tour_adult_qty']  = isset($request->dropdown[$key]['tour_adult_price']) ? $request->dropdown[$key]['tour_adult_price'] : 0;
                                $get_private_tour_arr['tour_child_qty']  = isset($request->dropdown[$key]['tour_child_price']) ? $request->dropdown[$key]['tour_child_price'] : 0;
                                $get_private_tour_arr['tour_infant_qty'] = isset($request->dropdown[$key]['tour_infant_price']) ? $request->dropdown[$key]['tour_infant_price'] : 0;
                                $get_private_tour_arr['tour_upgrade']    = [];
                                if (isset($Data['data']['tour_adult_price']['tour_upgrade_arr'])) {
                                    $tour_upgrade_arr = $Data['data']['tour_adult_price']['tour_upgrade_arr'];
                                    foreach ($tour_upgrade_arr as $upgrade_key => $tour_upgrade_value) {
                                        $ProductOptionLodgeUpgrade                       = ProductOptionTourUpgrade::where(['id' =>  $tour_upgrade_value['id']])->first();
                                        $get_private_tour_upgrade_arr = [];
                                        if ($tour_upgrade_value['qty']) {
                                            $req_adult_qty = $tour_upgrade_value['qty'];
                                        }
                                        if (isset($Data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                                            $req_child_qty = $Data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                                        }
                                        if (isset($Data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                                            $req_infant_qty = $Data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                                        }
                                        $get_private_tour_upgrade_arr['title']           = '';
                                        if ($ProductOptionLodgeUpgrade) {
                                            $get_private_tour_upgrade_arr['title']           = $ProductOptionLodgeUpgrade['title'];;
                                        }
                                        $get_private_tour_upgrade_arr['id'] = $tour_upgrade_value['id'];
                                        $get_private_tour_upgrade_arr['adult_qty'] = $req_adult_qty;
                                        $get_private_tour_upgrade_arr['child_qty'] = $req_child_qty;
                                        $get_private_tour_upgrade_arr['infant_qty'] = $req_infant_qty;
                                        $get_private_tour_arr['tour_upgrade'][] = $get_private_tour_upgrade_arr;
                                    }
                                }
                                $tourTransferArr['private_tour'][] = $get_private_tour_arr;
                            } else {
                                if (isset($Data['tour_transfer_id']) && $Data['tour_transfer_id'] > 0) {
                                    $get_option_details = ProductOptionDetails::where('product_id', $activity_id)
                                        ->where('id', $Data['tour_transfer_id'])
                                        ->first();

                                    if ($get_option_details) {
                                        if ($get_option_details->is_input == 0) {
                                            if (isset($Data['private_car'])) {
                                                $get_car_detail = CarDetails::where('id', $Data['private_car'])
                                                    ->where('status', 'Active')
                                                    ->first();
                                                if ($get_car_detail) {
                                                    $get_tour_transfer_arr['id']                  = $key;
                                                    $get_tour_transfer_arr['is_private_transfer'] = 1;
                                                    $get_tour_transfer_arr['title']                = getLanguageTranslate($ProductOptionLanguage, $language, $key, 'title', 'option_id');
                                                    $get_tour_transfer_arr['transfer_option']     = $Data['tour_transfer_id'];
                                                    $get_tour_transfer_arr['transfer_option_name']     = $get_option_details['transfer_option'];
                                                    $get_tour_transfer_arr['date']                = $Date[$key];
                                                    $get_tour_transfer_arr['car_id']              = $Data['private_car'];
                                                    $get_tour_transfer_arr['car_price']           = ConvertCurrency($get_car_detail['price']);
                                                    $CarDetailLanguage                            = CarDetailLanguage::where('car_details_id',$Data['private_car'])->get();
                                                    $get_tour_transfer_arr['car_title']           = getLanguageTranslate($CarDetailLanguage, $language, $Data['private_car'], 'title', 'car_details_id');
                                                    $get_tour_transfer_arr['timeslot']            = isset($Timeslot[$key]) ? $Timeslot[$key] : '';
                                                    $get_tour_transfer_arr['tour_adult_qty']      = $Data['data']['tour_adult_price']['qty'];
                                                    $get_tour_transfer_arr['tour_child_qty']      = $Data['data']['tour_child_price']['qty'];
                                                    $get_tour_transfer_arr['tour_infant_qty']     = $Data['data']['tour_infant_price']['qty'];
                                                }
                                            }
                                        } else {
                                            $get_tour_transfer_arr['id']                  = $key;
                                            $get_tour_transfer_arr['title']                = getLanguageTranslate($ProductOptionLanguage, $language, $key, 'title', 'option_id');
                                            $get_tour_transfer_arr['transfer_option']     = $Data['tour_transfer_id'];
                                            $get_tour_transfer_arr['transfer_option_name']     = $get_option_details['transfer_option'];
                                            $get_tour_transfer_arr['is_private_transfer'] = 0;
                                            $get_tour_transfer_arr['date']                = $Date[$key];
                                            $get_tour_transfer_arr['timeslot']            = isset($Timeslot[$key]) ? $Timeslot[$key] : '';
                                            $get_tour_transfer_arr['tour_adult_qty']      = isset($Data['data']['tour_adult_price']['qty']) ? $Data['data']['tour_adult_price']['qty'] : 0;
                                            $get_tour_transfer_arr['tour_child_qty']      = isset($Data['data']['tour_child_price']['qty']) ? $Data['data']['tour_child_price']['qty'] : 0;
                                            $get_tour_transfer_arr['tour_infant_qty']     = isset($Data['data']['tour_infant_price']['qty']) ?  $Data['data']['tour_infant_price']['qty'] : 0;
                                        }
                                        $get_tour_transfer_arr['tour_upgrade'] = [];
                                        if (isset($Data['data']['tour_adult_price']['tour_upgrade_arr'])) {
                                            $tour_upgrade_arr = $Data['data']['tour_adult_price']['tour_upgrade_arr'];
                                            foreach ($tour_upgrade_arr as $upgrade_key => $tour_upgrade_value) {
                                                $get_tour_upgrade_arr = [];
                                                $ProductOptionLodgeUpgrade                       = ProductOptionTourUpgrade::where(['id' =>  $tour_upgrade_value['id']])->first();
                                                if ($tour_upgrade_value['qty']) {
                                                    $req_adult_qty = $tour_upgrade_value['qty'];
                                                }
                                                if (isset($Data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                                                    $req_child_qty = $Data['data']['tour_child_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                                                }
                                                if (isset($Data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'])) {
                                                    $req_infant_qty = $Data['data']['tour_infant_price']['tour_upgrade_arr'][$upgrade_key]['qty'];
                                                }
                                                $get_tour_upgrade_arr['title']           = '';
                                                if ($ProductOptionLodgeUpgrade) {
                                                    $get_tour_upgrade_arr['title']           = $ProductOptionLodgeUpgrade['title'];;
                                                }
                                                $get_tour_upgrade_arr['id']              = $tour_upgrade_value['id'];
                                                $get_tour_upgrade_arr['adult_qty']       = $req_adult_qty;
                                                $get_tour_upgrade_arr['child_qty']       = $req_child_qty;
                                                $get_tour_upgrade_arr['infant_qty']      = $req_infant_qty;
                                                $get_tour_transfer_arr['tour_upgrade'][] = $get_tour_upgrade_arr;
                                            }
                                        }
                                        $tourTransferArr['tour_transfer'][] = $get_tour_transfer_arr;
                                    }
                                }
                            }
                        }
                    }
                }

                $get_group_percentage_arr = [];
                if ($grouppercentagecheck != '') {
                    foreach ($grouppercentagecheck as $gkey => $GH) {
                        if ($GH == 'true') {
                            $ProductGroupPercentageLanguage = ProductGroupPercentageLanguage::where(['product_id' => $activity_id])->get();
                            $get_group_percentage_arr['title']               = getLanguageTranslate($ProductGroupPercentageLanguage, $language, $gkey, 'title', 'group_percentage_id');
                            $get_group_percentage_arr['id'] = $gkey;
                            $get_group_percentage_arr['is_group_percentage'] = 1;
                            $get_group_percentage_arr['date'] = $Date[$gkey];
                            $get_group_percentage_arr['qty'] = $request->groupdropdown[$gkey];
                            $tourTransferArr['group_percentage'][] = $get_group_percentage_arr;
                        }
                    }
                }
                $get_detail['product_id']   = $activity_id;
                $get_detail['product_type'] = 'excursion';
                $get_detail['extra']        = $tourTransferArr;
                $output['status']          = true;
                $output['data']            = $get_detail;
                $output['msg']             = 'Send Request';
            }
        }
        return json_encode($output);
    }
}
