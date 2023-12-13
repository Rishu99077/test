<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\Language;
use App\Models\SideBanner;
use App\Models\Product;
use App\Models\Currency;
use App\Models\MetaGlobalLanguage;
use App\Models\TopDestinationLanguage;
use App\Models\ProductLanguage;
use App\Models\TopDestination;
use App\Models\HomeCount;
use App\Models\HomeCountLanguage;
use App\Models\TopTenSellerLanguage;
use App\Models\ProductSetting;
use App\Models\CarDetails;
use App\Models\ProductGroupPercentage;
use App\Models\CouponCode;
use App\Models\ProductGroupPercentageDetails;
use App\Models\CarDetailLanguage;
use App\Models\TopTenSeller;
use App\Models\AddToCart;
use App\Models\ProductLodge;
use App\Models\ProductLodgePrice;
use App\Models\ProductLodgeLanguage;
use App\Models\ProductOptionTourUpgrade;
use App\Models\TransportationVehicleLanguage;
use App\Models\ProductOptionTaxServiceCharge;
use App\Models\ProductOptionPrivateTourPrice;
use App\Models\ProductOptionLanguage;
use App\Models\ProductTourPriceDetails;
use App\Models\ProductOptionGroupPercentage;
use App\Models\ProductOptionPeriodPricing;
use App\Models\Productyachtwatersportlanguage;
use App\Models\Homepopup;
use App\Models\HomeCountry;
use App\Models\HomeZone;
use App\Models\ProductCategory;
use App\Models\User;
use App\Models\ProfileBanner;


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
use App\Models\Productyachttransferoptionlanguage;

use App\Models\HomeSliderImages;

use App\Models\BannerOverview;
use App\Models\BannerOverviewLanguage;

use App\Models\HomeDestinationOverview;
use App\Models\HomeDestinationOverviewLanguage;

use App\Models\PageSliders;
use App\Models\PageSlidersLanguage;
use App\Models\Category;

use App\Models\SocialMedia;
use App\Models\SocialMediaLinks;

use App\Models\AdvertismentBanner;
use App\Models\CurrencySymbol;
use App\Models\ProductCheckoutGiftCard;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Carbon\CarbonPeriod;



class HomeController extends Controller
{
    // Home
    public function index(Request $request)
    {
        $output = [];
        $output['status'] = true;
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

        $data = [];
        $language_id = $request->language;

        // /Settings
        $data['settings'] = [];
        $get_setting = Settings::whereNull('child_meta_title')
            ->orderby('sort', 'Asc')
            ->get();
        if (!$get_setting->isEmpty()) {
            foreach ($get_setting as $key => $value) {
                if ($value['meta_title'] == 'header_logo' || $value['meta_title'] == 'favicon' || $value['meta_title'] == 'footer_logo') {
                    if ($value['content'] != '') {
                        $get_settings[$value['meta_title']] = url('uploads/setting', $value['content']);
                    } else {
                        $get_settings[$value['meta_title']] = url('assets/img/logo.png');
                    }
                } else {
                    $get_settings[$value['meta_title']] = $value['content'];
                }
            }
            $data['settings'] = $get_settings;
        }
        $to             = request()->currency;
        $CurrencySymbol = CurrencySymbol::where('code', $to)->first();

        $currency = $to;
        if ($CurrencySymbol) {
            $currency = $CurrencySymbol->symbol;
        }
        $data['is_special_offer']   = false;
        $get_special_offer_products = Product::where(['status' => 'Active', 'is_delete' => 0])->where('slug', '!=', '')->where('original_price', '>', 'selling_price')->count();
        if ($get_special_offer_products) {
            $data['is_special_offer'] = true;
        }


        $data['side_banner']   = '';
        $data['special_side_banner']   = '';
        $SideBanner            = SideBanner::where('status', 'Active')->first();
        if ($SideBanner) {
            $data['side_banner']            = url('uploads/side_banner', $SideBanner['image']);
            $data['special_side_banner']            = url('uploads/side_banner', $SideBanner['special_side_banner']);
        }


        $data['profile_banner']   = '';
        $ProfileBanner            = ProfileBanner::where('status', 'Active')->first();
        if ($ProfileBanner) {
            $data['profile_banner']            = url('uploads/profile_banner', $ProfileBanner['image']);
        }



        //Advertizement Popup Start
        $data['currency_symbol']            = $currency;
        $data['currency_name']              = $to;
        $data['adv_popup']                  = [];
        $data['adv_popup']['status']        = false;
        $data['adv_popup']['heading_title'] = '';
        $data['adv_popup']['image']         = '';
        $data['adv_popup']['link']          = '';
        $getAdvPopup                        = AdvertismentBanner::where('status', 'Active')->first();
        if ($getAdvPopup) {
            $current_date                   = date('d-m-Y H:i');
            $start_date                     = $getAdvPopup['start_date'];
            $end_date                       = $getAdvPopup['end_date'];
            if (strtotime($current_date) >= strtotime($start_date) && strtotime($current_date) <= strtotime($end_date)) {
                $popup_heading = MetaGlobalLanguage::where('meta_parent', 'home_page_popup')
                    ->where('meta_title', 'heading_title')
                    ->where('language_id', $language_id)
                    ->first();
                if ($popup_heading) {
                    $data['adv_popup']['heading_title']              = $popup_heading['title'] != '' ? $popup_heading['title'] : '';
                }
                $data['adv_popup']['link']         = $getAdvPopup['link'];
                $data['adv_popup']['image']        = $getAdvPopup['image'] != '' ? url('uploads/setting', $getAdvPopup['image']) : asset('uploads/placeholder/placeholder.png');
                $data['adv_popup']['status']       = true;
            }
        }
        //Advertizement Popup Start

        $data['top_10_uae_heading']                               =  '';
        $get_top_10_uae_heading = MetaGlobalLanguage::where('meta_title', 'heading_title')
            ->where('meta_parent', 'top_10_uae_heading')
            ->where('language_id', $language_id)
            ->first();
        if ($get_top_10_uae_heading) {
            $data['top_10_uae_heading']                               =  $get_top_10_uae_heading['title'];
        }

        $data['luxuary_treats_heading']                               =  '';
        $get_luxuary_treats_heading = MetaGlobalLanguage::where('meta_title', 'heading_title')
            ->where('meta_parent', 'luxuary_treats_heading')
            ->where('language_id', $language_id)
            ->first();
        if ($get_luxuary_treats_heading) {
            $data['luxuary_treats_heading']                               =  $get_luxuary_treats_heading['title'];
        }

        $data['recently_main_heading']                               =  '';
        $get_recently_main_heading = MetaGlobalLanguage::where('meta_title', 'heading_title')
            ->where('meta_parent', 'recently_main_heading')
            ->where('language_id', $language_id)
            ->first();
        if ($get_recently_main_heading) {
            $data['recently_main_heading']                               =  $get_recently_main_heading['title'];
        }


        //
        $data['text_content']                               =  [];
        $data['text_content']['airport_transfer_search']    =  '';
        $aiport_text = MetaGlobalLanguage::where('meta_parent', 'home_page')
            ->where('meta_title', 'airport_transfer_search_text')
            ->where('language_id', $language_id)
            ->first();
        if ($aiport_text) {
            $data['text_content']['airport_transfer_search'] = $aiport_text['title'];
        }

        //Main Banner
        $data['main_banner']                = [];
        $data['main_banner']['main_title']  = '';
        $data['main_banner']['title']       = '';
        $data['main_banner']['content']     = [];
        $heading_title = MetaGlobalLanguage::where('meta_parent', 'home_main_banner')
            ->where('meta_title', 'home_main_banner_heading_title')
            ->where('language_id', $language_id)
            ->first();
        if ($heading_title) {
            $data['main_banner']['main_title'] = $heading_title['title'];
            $data['main_banner']['title']      = $heading_title['content'];
        }


        $get_slider_images = HomeSliderImages::where('type', 'home_main_banner')->get();
        if (!$get_slider_images->isEmpty()) {
            foreach ($get_slider_images as $slider_key => $slider_value) {
                $get_slider_images = [];
                $get_slider_images = $slider_value['slider_images'] != '' ? url('uploads/home_page/main_banner', $slider_value['slider_images']) : asset('uploads/placeholder/placeholder.png');

                $data['main_banner']['content'][] = $get_slider_images;
            }
        }
        //Main Banner End

        // Top Destination Searhc
        $data['top_destination_for_search'] = [];
        $top_destination_city = MetaGlobalLanguage::where("meta_parent", "search_top_destination")->first();
        if ($top_destination_city) {
            if ($top_destination_city->content !== "") {
                $cities = explode(",", $top_destination_city->content);
                $keydata = 1;
                foreach ($cities as $Ckey => $CT) {
                    $top_destination_arr = [];
                    $cityData = City::find($CT);
                    if ($cityData) {
                        $countryData = City::select("countries.*")->where("cities.id", $CT)
                            ->leftJoin("states", 'states.id', '=', 'cities.state_id')
                            ->leftJoin("countries", 'countries.id', '=', 'states.country_id')
                            ->first();
                        if ($keydata > 1) {
                            if ($keydata % 6  === 0) {
                                $keydata = 1;
                            }
                        }
                        $top_destination_arr['city_id']    = $CT;
                        $top_destination_arr['city_name']  = $cityData->name;
                        $top_destination_arr['country_id'] = $countryData != "" ? $countryData->id : 0;
                        $top_destination_arr['image']      = asset("assets/img/city/city{$keydata}.jpg");
                        $keydata++;
                    }
                    $data['top_destination_for_search'][] = $top_destination_arr;
                }
            }
        }


        // Home Page Remaing Search

        $data['home_country'] = [];
        $HomeZone = HomeZone::orderby('number', 'asc')->get();

        foreach ($HomeZone as $hzkey => $HZ) {
            $get_zone_country_arr = [];
            $get_zone_country_arr['zone_name'] =  $HZ['zone_name'];
            $get_zone_country_arr['zone_id']   =  $HZ['id'];

            $HomeCountry =  HomeCountry::where('home_zone_id', $HZ['id'])->get();
            // $get_home_country_arr = [];
            $get_zone_country_arr['city']   = array();
            foreach ($HomeCountry as $hkey => $HC) {
                // return $HC;
                $countryDetails = Country::find($HC['search_country']);
                $get_city_arr                   = [];
                $cityData                       = getDataFromDB("cities", ["id" => $HC['search_city']], 'row');
                $get_city_arr['city_id']        = $HC['search_city'];
                $get_city_arr['city_name']      = $cityData    != "" ?  $cityData->name : "";
                $get_city_arr['country_id']     = $HC['search_country'];
                $get_city_arr['country_name']   = $countryDetails != "" ? $countryDetails->name : "";
                $get_city_arr['image']          = $HC['image'] != '' ? url("uploads/home_page/zone", $HC['image']) : asset("assets/img/city/city{$keydata}.jpg");
                $get_zone_country_arr['city'][] = $get_city_arr;
            }
            $data['home_country'][] = $get_zone_country_arr;
        }


        // Banner Overview
        $data['banner_overview'] = [];
        $banner_overview = BannerOverview::where('page', 'home_page')
            ->get();
        if (!$banner_overview->isEmpty()) {
            foreach ($banner_overview as $key => $banner_value) {
                $get_banner_over_view          = [];
                $get_banner_over_view['id']    = $banner_value['id'];
                $get_banner_over_view['image'] = $banner_value['image'] != '' ? url('uploads/home_page/banner_overview', $banner_value['image']) : asset('uploads/placeholder/placeholder.png');
                $get_banner_language = BannerOverviewLanguage::where('overview_id', $banner_value['id'])
                    ->where('langauge_id', $request->language)
                    ->where('page', 'home_page')
                    ->first();
                $get_banner_over_view['title'] = '';
                if ($get_banner_language) {
                    $get_banner_over_view['title'] = $get_banner_language['title'] != '' ? $get_banner_language['title'] : '';
                }
                $data['banner_overview'][] = $get_banner_over_view;
            }
        }
        // Banner Overview End

        ///Top Destination
        $data['top_destination'] = [];
        $data['top_destination']['heading_title'] = '';
        $data['top_destination']['content'] = [];
        $heading_title = MetaGlobalLanguage::where('meta_parent', 'top_destination')
            ->where('meta_title', 'heading_title')
            ->where('language_id', $language_id)
            ->first();

        if ($heading_title) {
            $data['top_destination']['heading_title'] = $heading_title['title'];
        }

        $TopDestination = TopDestination::orderBy('id', 'desc')->get();
        foreach ($TopDestination as $top_key => $top_value) {
            # code...
            $get_top_destination          = [];
            $get_top_destination_language = TopDestinationLanguage::where('top_destination_id', $top_value['id'])->get();
            $get_top_destination['title'] = '';
            if ($get_top_destination_language) {
                $langauge_title               = getLanguageTranslate($get_top_destination_language, $language_id, $top_value['id'], 'title', 'top_destination_id');
                $get_top_destination['title'] = $langauge_title != '' ? $langauge_title : '';
            }
            $get_top_destination['location']      = $top_value['location'];
            $get_top_destination['link']          = $top_value['link'];
            $get_top_destination['country']       = get_table_data('countries', 'name', $top_value['country']);
            $get_top_destination['state']         = get_table_data('states', 'name', $top_value['state']);
            $get_top_destination['city']          = get_table_data('cities', 'name', $top_value['city']);


            $get_top_destination['country_id']       = $top_value['country'];
            $get_top_destination['state_id']         = $top_value['state'];
            $get_top_destination['city_id']          = $top_value['city'];


            $get_top_destination['image']         = $top_value['image'] != '' ? asset('uploads/home_page/top_destinations/' . $top_value['image']) : asset('uploads/placeholder/placeholder.png');
            $data['top_destination']['content'][] = $get_top_destination;
        }



        //Recently Added
        $data['recently_added'] = [];
        $get_recently_product = Product::where('is_recently', 1)
            ->where('status', 'Active')
            ->orderBy('id', 'desc')
            ->get();
        if (!$get_recently_product->isEmpty()) {
            $data['recently_added'] = $this->getProductArr($get_recently_product, $language_id, $request->user_id, 50);
        }

        //Hoome Count
        $data['home_count'] = [];
        $get_home_count = HomeCount::orderBy('id', 'desc')->get();
        if (!$get_home_count->isEmpty()) {
            foreach ($get_home_count as $home_key => $home_value) {
                # code...
                $get_home_count = [];
                $get_home_count['image'] = $home_value['image'] != '' ? url('uploads/home_page/home_counts', $home_value['image']) : asset('uploads/placeholder/placeholder.png');
                $get_home_count['number'] = $home_value['number'] != '' ? $home_value['number'] : 0;
                $get_home_count['title'] = '';
                $HomeCountLanguage = HomeCountLanguage::where('home_count_id', $home_value['id'])
                    ->where('language_id', $language_id)
                    ->first();
                if ($HomeCountLanguage) {
                    $get_home_count['title'] = $HomeCountLanguage->title != '' ? $HomeCountLanguage->title : '';
                }
                $data['home_count'][] = $get_home_count;
            }
        }


        //Top 10 Sellers in the UAE
        $data['top_ten_seller'] = [];
        $get_top_ten_selller = TopTenSeller::orderBy('sort_order', 'asc')->get();
        if (!$get_top_ten_selller->isEmpty()) {
            foreach ($get_top_ten_selller as $top_ten_key => $top_ten_value) {
                # code...
                $get_top_ten_seller = [];
                $get_top_ten_seller['title'] = '';
                $TopTenSellerLanguage = TopTenSellerLanguage::where('top_ten_seller_id', $top_ten_value['id'])->where('language_id', $language_id)->first();
                if ($TopTenSellerLanguage) {
                    $get_top_ten_seller['title'] = $TopTenSellerLanguage->title != '' ? $TopTenSellerLanguage->title : '';
                }
                $get_top_ten_seller['image'] = $top_ten_value['image'] != '' ? asset('uploads/home_page/top_ten_seller/' . $top_ten_value['image']) : asset('public/assets/img/no_image.jpeg');

                $get_product = Product::where('id', $top_ten_value['product_id'])->first();
                if ($get_product) {
                    if ($get_product['product_type'] == 'excursion') {
                        $get_top_ten_seller['link'] = 'activities-detail/' . $get_product['slug'];
                    } elseif ($get_product['product_type'] == 'yacht') {
                        $get_top_ten_seller['link'] = 'yacht-charts-details/' . $get_product['slug'];
                    } elseif ($get_product['product_type'] == 'lodge') {
                        $get_top_ten_seller['link'] = 'lodge-detail/' . $get_product['slug'];
                    } elseif ($get_product['product_type'] == 'limousine') {
                        $get_top_ten_seller['link'] = 'limousine-detail/' . $get_product['slug'];
                    }
                }
                $data['top_ten_seller'][] = $get_top_ten_seller;
            }
        }



        //Luxury Treats Product
        $data['luxuary_product'] = [];
        $get_luxuary_products = ProductSetting::select('product_settings.product_id', 'products.*')
            ->leftJoin('products', 'products.id', 'product_settings.product_id')
            ->where('product_settings.meta_title', 'add_to_luxury_main_page')
            ->where('status', 'Active')
            ->orderBy('products.id', 'desc')
            ->groupBy('product_id')
            ->get();
        if (!$get_luxuary_products->isEmpty()) {
            $data['luxuary_product'] =  $this->getProductArr($get_luxuary_products, $language_id, $request->user_id, 50);
        }
        //Luxury Treats Product


        //Recommended Tours
        $data['recommemded_tours'] = [];
        $data['recommemded_tours']['heading_title'] = '';
        $data['recommemded_tours']['content']       = array();
        $heading_title = MetaGlobalLanguage::where('meta_parent', 'recommended_tours')
            ->where('meta_title', 'heading_title')
            ->where('language_id', $language_id)
            ->first();
        if ($heading_title) {
            $data['recommemded_tours']['heading_title'] = $heading_title['title'];
        }

        $get_recomm_country_arr = array();
        // $get_recomm_country     = get_table_data('meta_global_language', 'content', 'recommended_tours', 'meta_parent');

        $get_recomm_country = [];
        if ($heading_title) {
            $get_recomm_country = $heading_title['content'];
        }


        if ($get_recomm_country) {
            $get_recomm_country_arr = explode(",", $get_recomm_country);
        }
        // $get_recomm_country_arr  = array_reverse($get_recomm_country_arr);
        foreach ($get_recomm_country_arr as $reccom_key => $reccom_value) {
            # code...
            $get_recommemded_tours   = array();
            if ($reccom_value != '') {
                $get_reccom_product = [];
                $get_recommemded_tours['country']  = '';
                $get_recommemded_tours['products'] = [];
                //recom_tours_main_page_big_picture
                $recom_tours_main_page_big_picture = ProductSetting::select('product_settings.product_id', 'products.*')
                    ->leftJoin('products', 'products.id', 'product_settings.product_id')
                    ->where('product_settings.meta_title', 'recom_tours_main_page_big_picture')
                    ->where('status', 'Active')
                    ->where('products.country', $reccom_value)
                    ->orderBy('products.id', 'desc')
                    ->groupBy('product_id')
                    ->first();
                if ($recom_tours_main_page_big_picture) {
                    $title                     = '';
                    $value_productLang = ProductLanguage::where(['product_id' => $recom_tours_main_page_big_picture['id'], 'language_id' => $language_id])->first();
                    if ($value_productLang) {
                        $title            = $value_productLang->description;
                    }
                    $get_reccom_product['id']               = $recom_tours_main_page_big_picture['id'];
                    $get_reccom_product['image']            = $recom_tours_main_page_big_picture['recommend_pic'] != '' ? asset('uploads/product_images/recom_big_pic/' . $recom_tours_main_page_big_picture['recommend_pic']) : ($recom_tours_main_page_big_picture['image']              != '' ? asset('public/uploads/product_images/' . $recom_tours_main_page_big_picture['image']) : asset('public/assets/img/no_image.jpeg'));

                    // $recom_tours_main_page_big_picture['image']              != '' ? asset('public/uploads/product_images/' . $recom_tours_main_page_big_picture['image']) : asset('public/assets/img/no_image.jpeg')
                    $get_reccom_product['name']             = $title;
                    $get_reccom_product['slug']             = $recom_tours_main_page_big_picture['slug'];
                    $get_reccom_product['location']         = $recom_tours_main_page_big_picture['address'] != '' ? $recom_tours_main_page_big_picture['address'] : '';
                    $get_reccom_product['link']             = '';
                    if ($recom_tours_main_page_big_picture['product_type'] == 'excursion') {
                        $get_reccom_product['link'] = 'activities-detail/' . $recom_tours_main_page_big_picture['slug'];
                    } elseif ($recom_tours_main_page_big_picture['product_type'] == 'yacht') {
                        $get_reccom_product['link'] = 'yacht-charts-details/' . $recom_tours_main_page_big_picture['slug'];
                    } elseif ($recom_tours_main_page_big_picture['product_type'] == 'lodge') {
                        $get_reccom_product['link'] = 'lodge-detail/' . $recom_tours_main_page_big_picture['slug'];
                    } elseif ($recom_tours_main_page_big_picture['product_type'] == 'limousine') {
                        $get_reccom_product['link'] = 'limousine-detail/' . $recom_tours_main_page_big_picture['slug'];
                    }
                    // $get_recommemded_tours['products'][]    = $get_reccom_product;
                    $get_reccom_product['product_position']     = 'recom_tours_main_page_big_picture';
                    $get_recommemded_tours['products'][]        = $get_reccom_product;
                }

                //add_to_recom_tours
                $get_reccom_product = [];
                $add_to_recom_tours = ProductSetting::select('product_settings.product_id', 'products.*')
                    ->leftJoin('products', 'products.id', 'product_settings.product_id')
                    ->where('product_settings.meta_title', 'add_to_recom_tours')
                    ->where('status', 'Active')
                    ->where('products.country', $reccom_value)
                    ->orderBy('products.id', 'desc')
                    ->groupBy('product_id')
                    ->first();
                if ($add_to_recom_tours) {
                    $title                     = '';
                    $value_productLang = ProductLanguage::where(['product_id' => $add_to_recom_tours['id'], 'language_id' => $language_id])->first();
                    if ($value_productLang) {
                        $title            = $value_productLang->description;
                    }
                    $get_reccom_product['id']               = $add_to_recom_tours['id'];
                    $get_reccom_product['image']            = $add_to_recom_tours['image']              != '' ? asset('public/uploads/product_images/' . $add_to_recom_tours['image']) : asset('public/assets/img/no_image.jpeg');
                    $get_reccom_product['name']             = $title;
                    $get_reccom_product['slug']             = $add_to_recom_tours['slug'];
                    $get_reccom_product['location']         = $add_to_recom_tours['address'] != '' ? $add_to_recom_tours['address'] : '';
                    $get_reccom_product['link']             = '';
                    if ($add_to_recom_tours['product_type'] == 'excursion') {
                        $get_reccom_product['link'] = 'activities-detail/' . $add_to_recom_tours['slug'];
                    } elseif ($add_to_recom_tours['product_type'] == 'yacht') {
                        $get_reccom_product['link'] = 'yacht-charts-details/' . $add_to_recom_tours['slug'];
                    } elseif ($add_to_recom_tours['product_type'] == 'lodge') {
                        $get_reccom_product['link'] = 'lodge-detail/' . $add_to_recom_tours['slug'];
                    } elseif ($add_to_recom_tours['product_type'] == 'limousine') {
                        $get_reccom_product['link'] = 'limousine-detail/' . $add_to_recom_tours['slug'];
                    }
                    // $get_recommemded_tours['products'][]    = $get_reccom_product;
                    $get_reccom_product['product_position']     = 'add_to_recom_tours';
                    $get_recommemded_tours['products'][]        = $get_reccom_product;
                }

                //recom_tours_main_page_small_picture
                $recom_tours_main_page_small_picture = ProductSetting::select('product_settings.product_id', 'products.*')
                    ->leftJoin('products', 'products.id', 'product_settings.product_id')
                    ->where('product_settings.meta_title', 'recom_tours_main_page_small_picture')
                    ->where('status', 'Active')
                    ->where('products.country', $reccom_value)
                    ->orderBy('products.id', 'desc')
                    ->groupBy('product_id')
                    ->limit(2)
                    ->get();
                if (!$recom_tours_main_page_small_picture->isEmpty()) {
                    foreach ($recom_tours_main_page_small_picture as $key => $value) {
                        # code...

                        $get_reccom_product = [];
                        $title                     = '';
                        $value_productLang = ProductLanguage::where(['product_id' => $value['id'], 'language_id' => $language_id])->first();
                        if ($value_productLang) {
                            $title            = $value_productLang->description;
                        }
                        $get_reccom_product['id']               = $value['id'];
                        $get_reccom_product['image']            = $value['image']              != '' ? asset('public/uploads/product_images/' . $value['image']) : asset('public/assets/img/no_image.jpeg');
                        $get_reccom_product['name']             = $title;
                        $get_reccom_product['slug']             = $value['slug'];
                        $get_reccom_product['location']         = $value['address'] != '' ? $value['address'] : '';
                        $get_reccom_product['link']             = '';
                        if ($value['product_type'] == 'excursion') {
                            $get_reccom_product['link'] = 'activities-detail/' . $value['slug'];
                        } elseif ($value['product_type'] == 'yacht') {
                            $get_reccom_product['link'] = 'yacht-charts-details/' . $value['slug'];
                        } elseif ($value['product_type'] == 'lodge') {
                            $get_reccom_product['link'] = 'lodge-detail/' . $value['slug'];
                        } elseif ($value['product_type'] == 'limousine') {
                            $get_reccom_product['link'] = 'limousine-detail/' . $value['slug'];
                        }
                        $get_reccom_product['product_position']     = 'recom_tours_main_page_small_picture';
                        $get_recommemded_tours['products'][]    = $get_reccom_product;
                    }
                }

                if (count($get_recommemded_tours['products']) > 0) {
                    $get_recommemded_tours['country']  = get_table_data('countries', 'name', $reccom_value) != '' ? get_table_data('countries', 'name', $reccom_value) : '';
                    $data['recommemded_tours']['content'][] = $get_recommemded_tours;
                }
            }
        }
        // Recommended Tours End

        $data['add_to_cart']                  = AddToCart::where(["token" => $request->token])->count();
        //Adventures Awaits

        $data['adventure_product']                  = [];
        $data['adventure_product']['heading_title'] = '';
        $data['adventure_product']['content']       = array();
        $heading_title = MetaGlobalLanguage::where('meta_parent', 'world_of_adventure')
            ->where('meta_title', 'heading_title')
            ->where('language_id', $language_id)
            ->first();
        if ($heading_title) {
            $data['adventure_product']['heading_title'] = $heading_title['title'];
        }
        $get_adventure_country_arr = array();
        // $get_adventure_country     = get_table_data('meta_global_language', 'content', 'world_of_adventure', 'meta_parent');


        $get_adventure_country = [];
        if ($heading_title) {
            $get_adventure_country = $heading_title['content'];
        }

        if ($get_adventure_country) {
            $get_adventure_country_arr = explode(",", $get_adventure_country);
        }
        // $get_adventure_country_arr = array_reverse($get_adventure_country_arr);
        foreach ($get_adventure_country_arr as $adven_key => $adven_value) {

            if ($adven_value != '') {
                $get_adventure_arr              = array();
                $get_adventures_products        = ProductSetting::select('product_settings.product_id', 'products.*')
                    ->leftJoin('products', 'products.id', 'product_settings.product_id')
                    ->where('product_settings.meta_title', 'add_to_world_adventure_main_page')
                    ->where('status', 'Active')
                    ->where('products.country', $adven_value)
                    ->orderBy('products.id', 'desc')
                    ->groupBy('product_id');



                $get_adventures_products_count   = $get_adventures_products->count();
                $get_adventures_products   = $get_adventures_products->limit(9)->get();
                if (!$get_adventures_products->isEmpty()) {
                    $get_adventure_arr['products']  =  array();
                    $get_adventure_arr['country']   = get_table_data('countries', 'name', $adven_value) != '' ? get_table_data('countries', 'name', $adven_value) : '';
                    $get_adventure_arr['products']  = $this->getProductArr($get_adventures_products, $language_id, $request->user_id, 70);
                    $get_adventure_arr['count']     = count($get_adventure_arr['products']);
                    $data['adventure_product']['content'][] = $get_adventure_arr;
                }
            }
        }
        //Adventures Awaits End

        //middle Banner
        // $data['banner_images'] = array();
        // $get_slider_images = HomeSliderImages::where('type', 'home_middle_slider')->get();
        // if (!$get_slider_images->isEmpty()) {
        //     foreach ($get_slider_images as $slider_key => $slider_value) {

        //         $get_slider_images = [];
        //         $get_slider_images = $slider_value['slider_images'] != '' ? url('uploads/home_page/slider_images', $slider_value['slider_images']) : asset('uploads/placeholder/placeholder.png');

        //         $data['banner_images'][] = $get_slider_images;
        //     }
        // }

        //Destination overview
        $data['destination_overview'] = [];
        $data['destination_overview']['heading_title'] = '';
        $data['destination_overview']['content']       = array();
        $heading_title = MetaGlobalLanguage::where('meta_parent', 'destination_overview')
            ->where('meta_title', 'heading_title')
            ->where('language_id', $language_id)
            ->first();
        if ($heading_title) {
            $data['destination_overview']['heading_title'] = $heading_title['title'];
        }

        $get_destination_overview = HomeDestinationOverview::orderBy('id', 'desc')->get();
        if (!$get_destination_overview->isEmpty()) {
            foreach ($get_destination_overview as $home_key => $overview_value) {

                $get_destination_overview = [];
                $get_destination_overview['image'] = $overview_value['image'] != '' ? url('uploads/home_page/destination_overview', $overview_value['image']) : asset('uploads/placeholder/placeholder.png');
                $get_destination_overview['link'] = $overview_value['link'];
                $get_destination_overview['location'] = $overview_value['location'];
                $get_destination_overview['title'] = '';
                $HomeDestinationOverviewLanguage = HomeDestinationOverviewLanguage::where('destination_overview_id', $overview_value['id'])
                    ->where('language_id', $language_id)
                    ->first();
                if ($HomeDestinationOverviewLanguage) {
                    $get_destination_overview['title'] = $HomeDestinationOverviewLanguage->title != '' ? $HomeDestinationOverviewLanguage->title : '';
                }
                $data['destination_overview']['content'][] = $get_destination_overview;
            }
        }

        // Social Media Links
        $data['media_links'] = [];
        $data['media_links']['copyright_title'] = '';
        $data['media_links']['content']   = array();

        $get_social_media = SocialMedia::where('status', 'Active')->first();
        if ($get_social_media) {
            $data['media_links']['copyright_title']  = $get_social_media['copyright_title'];
        }

        $get_social_media_links = SocialMediaLinks::where(['social_media_id' => $get_social_media['id'], 'media_status' => 'Active'])->get();
        if (!$get_social_media_links->isEmpty()) {
            foreach ($get_social_media_links as $key => $s_value) {
                $media_link = [];
                $media_link['image']      = $s_value['media_icon'] != '' ? url('uploads/setting', $s_value['media_icon']) : asset('uploads/placeholder/placeholder.png');
                $media_link['link']       = $s_value['link'] != '' ? $s_value['link'] : '';
                $data['media_links']['content'][] = $media_link;
            }
        }

        // Social Media Links End


        // ADV BANNER Links
        $data['advertisment_banner'] = [];
        $current_time   = date('d-m-Y');

        $get_adv_banner = AdvertismentBanner::where('status', 'Active')->first();
        $row = array();
        if ($get_adv_banner) {
            $row['link']         = $get_adv_banner['link'];
            $row['image']        = $get_adv_banner['image'] != '' ? url('uploads/setting', $get_adv_banner['image']) : asset('uploads/placeholder/placeholder.png');
            $row['start_date']   = $get_adv_banner['start_date'];
            $row['end_date']     = $get_adv_banner['end_date'];
            $row['status']     = $get_adv_banner['status'];
        }
        $data['advertisment_banner'] = $row;
        // ADV BANNER End



        // Slider images
        $data['slider_images'] = [];
        $get_sliders = PageSliders::where('page', 'home_page_slider')
            ->get();
        if (!$get_sliders->isEmpty()) {
            foreach ($get_sliders as $key => $slider_value) {
                $get_slider          = [];
                $get_slider['id']    = $slider_value['id'];
                $get_slider['image'] = $slider_value['image'] != '' ? url('uploads/slider_images', $slider_value['image']) : asset('uploads/placeholder/placeholder.png');
                $get_slider['logo_image'] = $slider_value['main_logo'] != '' ? url('uploads/slider_images/main_logo', $slider_value['main_logo']) : asset('uploads/placeholder/placeholder.png');
                $get_slider_language = PageSlidersLanguage::where('pages_slider_id', $slider_value['id'])
                    ->where('language_id', $request->language)
                    ->where('page', 'home_page_slider')
                    ->first();
                $get_slider['title'] = '';
                $get_slider['description'] = '';
                if ($get_slider_language) {
                    $get_slider['title']       = $get_slider_language['title'] != '' ? $get_slider_language['title'] : '';
                    $get_slider['description'] = $get_slider_language['description'] != '' ? $get_slider_language['description'] : '';
                }
                $data['slider_images'][] = $get_slider;
            }
        }
        // Slider images End


        // Middle Slider images
        $data['middle_slider_images'] = [];
        $get_middle_sliders = PageSliders::where('page', 'home_page_middle_slider')
            ->get();
        if (!$get_middle_sliders->isEmpty()) {
            foreach ($get_middle_sliders as $key => $middle_slider_value) {
                $get_slider          = [];
                $get_slider['id']    = $middle_slider_value['id'];
                $get_slider['image'] = $middle_slider_value['image'] != '' ? url('uploads/slider_images', $middle_slider_value['image']) : asset('uploads/placeholder/placeholder.png');
                $get_middle_slider_language = PageSlidersLanguage::where('pages_slider_id', $middle_slider_value['id'])
                    ->where('language_id', $request->language)
                    ->where('page', 'home_page_middle_slider')
                    ->first();
                $get_slider['title'] = '';
                $get_slider['description'] = '';
                if ($get_middle_slider_language) {
                    $get_slider['title']       = $get_middle_slider_language['title'] != '' ? $get_middle_slider_language['title'] : '';
                    $get_slider['description'] = $get_middle_slider_language['description'] != '' ? $get_middle_slider_language['description'] : '';
                }
                $data['middle_slider_images'][] = $get_slider;
            }
        }
        // Middle Slider images End


        $data['categories'] = [];
        $CategoryProductArr   = [];

        $categoryArr = [];
        $ProductCategory = ProductCategory::take(7)->orderBy('id', 'desc')->get();
        foreach ($ProductCategory as $pkey => $PC) {
            $getArr = [];
            $Category = Category::select('categories.*', 'category_language.description as name')
                ->where('categories.id', $PC['category'])
                ->where('categories.status', 'Active')
                ->join('category_language', 'categories.id', '=', 'category_language.category_id')
                ->first();



            if ($Category != "" && !in_array($PC['category'], $categoryArr)) {
                $CategoryProductArr[] = $Category;
                $categoryArr[]        = $PC['category'];
            }
        }
        $data['categories']  = $CategoryProductArr;

        // $data['homepopup'] = [];
        $homepopup['product_popup']                 = [];

        $HomepopupData = Homepopup::where('language_id', $language_id)->first();
        if ($HomepopupData) {

            $homepopup['product_popup']['title']        = '';
            $homepopup['product_popup']['description']  = '';
            $homepopup['product_popup']['popup_status'] = $HomepopupData->popup_status == 'Active' ? true : false;
            if ($HomepopupData->popup_status == 'Active') {


                $homepopup['product_popup']['title']       = $HomepopupData->title;
                $homepopup['product_popup']['description'] = $HomepopupData->description;

                $homepopup['product_popup']['link']          = $HomepopupData->popup_link;
                $homepopup['product_popup']['redirect_link'] = $HomepopupData->link;
                $homepopup['product_popup']['product_image'] = $HomepopupData->popup_image != '' ? url('uploads/product_images', $HomepopupData->popup_image) : '';
                $homepopup['product_popup']['image']         = $HomepopupData->popup_image != '' ? url('uploads/product_images', $HomepopupData->popup_image) : '';
                $homepopup['product_popup']['video']        = $HomepopupData->video != '' ? url('uploads/product_images/popup_image', $HomepopupData->video) : '';
                $homepopup['product_popup']['thumnail']     = $HomepopupData->thumbnail_image != '' ? url('uploads/product_images/popup_image', $HomepopupData->thumbnail_image) : ($HomepopupData->popup_image != '' ? url('uploads/product_images/', $HomepopupData->popup_image) : asset('uploads/placeholder/placeholder.png'));
            }
        }
        $data['homepopup'] = $homepopup;


        $output['data'] = $data;
        return json_encode($output);
    }

    // Get Date Range
    public function getDatesFromRange($start, $end, $format = 'Y-m-d')
    {
        return array_map(function ($timestamp) use ($format) {
            return date($format, $timestamp);
        }, range(strtotime($start) + ($start < $end ? 4000 : 8000), strtotime($end) + ($start < $end ? 8000 : 4000), 86400));
    }
    //Get Languages
    public function get_languages(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['msg'] = 'Not Data Found';
        $get_languages = [];

        $languages = Language::where('status', 'Active')
            ->where('is_delete', 0)
            ->get();
        if (!$languages->isEmpty()) {
            foreach ($languages as $key => $value) {
                # code...
                $get_language = [];
                $get_language['id'] = $value['id'];
                $get_language['title'] = $value['title'] != '' ? $value['title'] : '';
                $get_language['sort_code'] = $value['sort_code'] != '' ? strtolower($value['sort_code']) : 'en';
                $get_language['direction'] = $value['direction'] != '' ? $value['direction'] : '';
                $get_language['flag'] = $value['flag_image'] != '' ? asset('uploads/language_flag/' . $value['flag_image']) : asset('uploads/placeholder/placeholder.png');
                $get_languages[] = $get_language;
            }

            $output['msg'] = 'Language List';
            $output['status'] = true;
        }
        $output['data'] = $get_languages;
        return json_encode($output);
    }

    //Get Languages
    public function get_currency(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['msg'] = 'Not Data Found';
        $get_currency = [];

        $Currency = Currency::where('status', 'Active')
            ->where('is_delete', 0)
            ->get();
        if (!$Currency->isEmpty()) {
            foreach ($Currency as $key => $value) {
                # code...
                $get_currency_arr = [];
                $get_currency_arr['id'] = $value['id'];
                $get_currency_arr['title'] = $value['title'] != '' ? $value['title'] : '';
                $get_currency_arr['sort_code'] = $value['sort_code'] != '' ? $value['sort_code'] : 'AED';
                $get_currency_arr['flag'] = $value['flag_image'] != '' ? asset('uploads/language_flag/' . $value['flag_image']) : asset('uploads/placeholder/placeholder.png');
                $get_currency[] = $get_currency_arr;
            }

            $output['msg'] = 'Currency List';
            $output['status'] = true;
        }
        $output['data'] = $get_currency;
        return json_encode($output);
    }


    //Get Languages
    public function set_language(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['msg'] = 'Not Data Found';
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
        $get_language = [];
        if ($request->language == 'deafult') {
            $languages = Language::where('is_default', 1)->first();
        } else {
            $languages = Language::where('status', 'Active')
                ->where('is_delete', 0)
                ->where('id', $request->language)
                ->first();
        }

        if (!isset($request->currency) || $request->currency == 'deafult') {
            $currency = Currency::where('is_default', 1)->first();
        } else {
            $currency = Currency::where('status', 'Active')
                ->where('is_delete', 0)
                ->where('sort_code', $request->currency)
                ->first();
        }


        if ($languages) {
            $get_language['id']         = $languages['id'];
            $get_language['currency']   = $currency['sort_code'];
            $get_language['title']      = $languages['title']      != ''  ? $languages['title'] : '';
            $get_language['short_code'] = $languages['sort_code']  != '' ? strtolower($languages['sort_code']) : 'en';
            $get_language['direction']  = $languages['direction']  != '' ? $languages['direction'] : '';
            $get_language['flag']       = $languages['flag_image'] != '' ? asset('uploads/language_flag/' . $languages['flag_image']) : asset('uploads/placeholder/placeholder.png');
            $output['msg']              = 'Language';
            $output['status']           = true;
        }

        $output['data'] = $get_language;
        return json_encode($output);
    }





    //Customer Funtion Public Get Prodcut Array
    public function getProductArr($arr, $language_id, $user_id = '', $short_dec_limit = 50)
    {
        $get_arr = array();
        foreach ($arr as $key => $value) {
            $get_product = [];
            $title                     = '';
            $main_description          = '';
            $short_description = '';
            $value_productLang = ProductLanguage::where(['product_id' => $value['id'], 'language_id' => $language_id])->first();
            if ($value_productLang) {
                $title              = $value_productLang->description;
                $main_description   = $value_productLang->main_description;
                $short_description  = $value_productLang->short_description;
                if ($value_productLang->short_description != '') {

                    // $get_product['short_description']  = $value_productLang->short_description;

                }
            }
            $city                            = getAllInfo('cities', ['id' => $value['city']], 'name');
            $get_product['id']               = $value['id'];
            $get_product['image']            = $value['image']                  != '' ? asset('public/uploads/product_images/' . $value['image']) : asset('public/assets/img/no_image.jpeg');
            $get_product['name']              = short_description_limit($title, 35);
            $get_product['full_name']         = $title;
            $get_product['short_description'] = short_description_limit($short_description, $short_dec_limit);
            $get_product['main_description']  = Str::limit($main_description, 60);
            $get_product['city']             = $city;
            $get_product['slug']             = $value['slug'];
            $get_product['total_sold']       = $value['how_many_are_sold']     !== '' ? $value['how_many_are_sold'] : 0;
            $get_product['per_value']        = $value['per_value'];
            $get_product['image_text']       = $value['image_text'] ?? null;
            $get_product['price']            = ConvertCurrency($value['original_price']) ?? 0;
            $get_product['selling_price']    = ConvertCurrency($value['selling_price']) ?? 0;
            $get_product['product_type']     = $value['product_type'];
            $get_product['ratings']          = get_rating($value['id']);
            $get_product['button']           = $value['product_bookable_type'] === 'bookable' ? 'Book Now' : 'On Request';
            $get_product['price_html']       = get_price_front($value['id'], $user_id, $value['product_type']);
            $get_product['link']             = '';
            if ($value['product_type'] == 'excursion') {
                $get_product['link'] = '/activities-detail/' . $value['slug'];
            } elseif ($value['product_type'] == 'yacht') {
                $get_product['link'] = '/yacht-charts-details/' . $value['slug'];
            } elseif ($value['product_type'] == 'lodge') {
                $get_product['link'] = '/lodge-detail/' . $value['slug'];
            } elseif ($value['product_type'] == 'limousine') {
                $get_product['link'] = '/limousine-detail/' . $value['slug'];
            }
            $get_product['ratings']          = get_rating($value['id']);
            $approx = '';
            if ($value['approx'] == 1) {
                $approx = '(Approx)';
            }
            if ($value['duration_text']) {
                $duration = $value['duration_text'];
            } else {
                $dura = '';
                $duration = explode('-', $value['duration']);
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
                $duration   = $dura . $approx;
            }
            $get_product['duration']              = $duration;
            $get_product['boat_maximum_capacity'] = $value['boat_maximum_capacity'];
            $get_product['minimum_booking']       = $value['minimum_booking'];
            $get_arr[]                            = $get_product;
        }
        return $get_arr;
    }

    public  function get_cart_item(Request $request)
    {
        $output            = [];
        $output['status']  = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            'language' => 'required',
            'token'    => 'required',
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
        $token                 = $request->token;
        $language              = $request->language;
        $reward_point_apply    = $request->reward_point_apply;
        $giftcard_wallet_apply = $request->giftcard_wallet_apply;
        $cartItemArr           = [];
        if ($request->user_id) {
            $user_id      = checkDecrypt($request->user_id);
            AddToCart::where("token", $token)->where("user_id", 0)->update(array('user_id' => $user_id, 'token' => ''));
        }
        $CartItem          = AddToCart::select('add_to_cart.*', 'products.point_to_purchase_product')
            ->leftjoin('products', 'products.id', '=', 'add_to_cart.product_id');

        if ($request->user_id) {
            $CartItem      =  $CartItem->where('user_id', $user_id);
        } else {
            $CartItem      =  $CartItem->where('token', $token);
        }
        $CartItem          = $CartItem->orderBy("products.point_to_purchase_product", "desc")->get();
        // $CartItem          = $CartItem->get();


        $tax                                = 0;
        $user_id                            = 0;
        $total_amount                       = 0;
        $totalYachtAmount                   = 0;
        $get_total                          = 0;
        $reward_point                       = 0;
        $total_service_charge               = 0;
        $total_tax_charge                   = 0;
        $get_total_amnt                     = 0;
        $no_tax_service_total_amnt          = 0;
        $user_current_reward_points         = 0;
        $get_user_current_reward_point      = 0;
        $total_reddem_client_rewards_points = 0;
        if ($request->user_id) {
            $user_id      = checkDecrypt($request->user_id);
            $get_user                  = User::where('id', $user_id)->where('status', 'Active')->where('is_verified', 1)->first();
            if ($get_user) {
                $user_current_reward_points    = $get_user['current_reward_points'];
                $get_user_current_reward_point = $get_user['current_reward_points'];
            }
        }
        $output['user_current_reward_points'] = $user_current_reward_points;

        $reward_point = 0;

        if ($token  != "" && $token  != 'null') {
            if (count($CartItem) > 0) {

                foreach ($CartItem as $key => $CI) {
                    $tax_amount                            = 0;
                    $service_charge                        = 0;
                    $totalAmount                           = 0;
                    $totalLimousinAmount                   = 0;
                    $total_lodge_amount                    = 0;
                    $totalexcursionAmount                  = 0;
                    $totalYachtAmount                      = 0;
                    $totalgiftamount                       = 0;
                    $total_tax_per_product                 = 0;
                    $total_tax_percentage_per_product      = 0;
                    $total_service_per_product             = 0;
                    $getTotalAmntProduct                   = 0;
                    $no_tax_service_total_amnt_per_product = 0;


                    $title                = '';
                    $main_description     = '';
                    $get_cart_item        = [];

                    $get_cart_item['price']    = 0;
                    $get_cart_item['option']   = [];

                    $product_id  = $CI['product_id'];
                    $activity_id = $CI['product_id'];
                    $Product     = Product::where('id', $product_id)->first();
                    if ($Product) {

                        $productLang      = ProductLanguage::where(['product_id' => $product_id, 'language_id' => $language])->first();
                        if ($productLang) {
                            $title            = $productLang->description;
                            $main_description = $productLang->main_description;
                        }



                        $point_to_purchase_product           =  $Product['point_to_purchase_product'];


                        //GEt Rewar POint in product
                        $get_cart_item['product_id']                = $Product->id;
                        $get_cart_item['buy_on_reward_point']       = false;
                        $get_cart_item['reward_point_apply']        = false;
                        $get_cart_item['buy_on_reward_point_text']  = '';
                        $get_cart_item['reward_point_apply_text']    = '';
                        $get_cart_item['point_to_purchase_product'] = $point_to_purchase_product;

                        if ($user_current_reward_points > 0 && $point_to_purchase_product > 0) {
                            if ($user_current_reward_points >= $point_to_purchase_product) {
                                $user_current_reward_points                = $user_current_reward_points - $point_to_purchase_product;
                                $get_cart_item['buy_on_reward_point']      = true;
                                $get_cart_item['buy_on_reward_point_text'] = "<p class='reward_point_text'> Book this product with <span class='rewardpoints'>" . $point_to_purchase_product . "</span>
                                 Rewards points</p>    ";
                                if ($reward_point_apply == 'true') {
                                    $get_cart_item['reward_point_apply']        = true;
                                    $total_reddem_client_rewards_points         += $point_to_purchase_product;
                                    $get_cart_item['reward_point_apply_text']   = "<p class='reward_apply_point_text'> Purchase This Product in <span class='apply_rewardpoints'>" . $point_to_purchase_product . "</span>";
                                }
                            }
                        }
                        $get_cart_item['product_user_current_reward_points']  = $user_current_reward_points;
                        //GEt Rewar POint in product

                        if ($CI['product_type'] != "GiftCard") {
                            $get_cart_item['image'] = asset('uploads/product_images/' . $Product['image']);
                            $productPrice = $Product['selling_price'] !== '' ?
                                get_partners_dis_price(ConvertCurrency($Product['selling_price']), $product_id, $request->user_id, 'base_price', 'lodge')

                                :  get_partners_dis_price(ConvertCurrency($Product['original_price']), $product_id, $request->user_id, 'base_price', 'lodge');
                            $get_cart_item['price'] = $productPrice;
                        }

                        if ($CI['product_type'] == "lodge") {
                            $service_charge = 0;
                            // $total_lodge_amount          = $Product['selling_price'] !== '' ?
                            // get_partners_dis_price($Product['selling_price'], $product_id, $request->user_id, 'base_price', 'lodge')

                            // :  get_partners_dis_price($Product['original_price'], $product_id, $request->user_id, 'base_price', 'lodge');
                            // $no_tax_service_total_amnt  += $total_lodge_amount;

                            $lodge_option       = json_decode($CI['extra']);
                            foreach ($lodge_option as $LO) {
                                $tax            = 0;
                                $tax_amount     = 0;
                                $totalOptionAmount = 0;
                                $service_charge    = 0;
                                $get_lodge_upgrade = [];
                                $lodge_option_id   = $LO->lodge_option_id;

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


                                $arrivalDate   = $LO->lodge_arrival_date;
                                $departureDate = $LO->lodge_departure_date;
                                $adultQty      = $LO->lodge_option_adult;
                                $childQty      = $LO->lodge_option_child;
                                $infantQty     = $LO->lodge_option_infant;
                                $ProductPrice  =  get_partners_dis_price(ConvertCurrency($ProductLodge->lodge_price), $product_id, $request->user_id, 'tour_price', 'lodge');
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


                                // $totalOptionAmount += $ProductPrice ;



                                $total_nights = count($dateArr);


                                $is_more     = 0;
                                $limitAdult  = $ProductLodge->adult;
                                $limitChild  = $ProductLodge->child;
                                $limitInfant = $ProductLodge->infant;





                                if ($adultQty > 0 || $childQty  > 0 || $infantQty > 0) {
                                    foreach ($dateArr as $key => $DA) {
                                        $price =  get_partners_dis_price(ConvertCurrency($ProductLodge->lodge_price), $product_id, $request->user_id, 'tour_price', 'lodge');
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
                                                $TourUpgradeTotal += $DL->lodge_adult_qty *
                                                    get_partners_dis_price(ConvertCurrency($ProductOptionLodgeUpgrade->adult_price), $product_id, $request->user_id, 'tour_upgrade_option', 'lodge')

                                                    * $total_nights;
                                            } else {
                                                $TourUpgradeTotal += 0;
                                            }
                                        }
                                        if ($DL->lodge_child_qty > 0) {
                                            $check_service_charge = 1;

                                            if (isset($DL->lodge_child_qty)) {
                                                $TourUpgradeTotal += $DL->lodge_child_qty *
                                                    get_partners_dis_price(ConvertCurrency($ProductOptionLodgeUpgrade->child_price), $product_id, $request->user_id, 'tour_upgrade_option', 'lodge') * $total_nights;
                                            } else {
                                                $TourUpgradeTotal += 0;
                                            }
                                        }
                                        if ($DL->lodge_infant_qty > 0) {
                                            $check_service_charge = 1;
                                            if (isset($DL->lodge_child_qty)) {
                                                $TourUpgradeTotal += $DL->lodge_infant_qty *
                                                    get_partners_dis_price(ConvertCurrency($ProductOptionLodgeUpgrade->infant_price), $product_id, $request->user_id, 'tour_upgrade_option', 'lodge') * $total_nights;
                                            } else {
                                                $TourUpgradeTotal += 0;
                                            }
                                        }
                                    }
                                }


                                // }

                                if ($adultQty > 0 || $childQty > 0 || $infantQty > 0 || $check_service_charge == 1) {
                                } else {
                                    $service_charge = 0;
                                }

                                // if (isset($request->is_upgrade)) {
                                $totalQty =  $LO->no_of_rooms;
                                // }
                                $totalOptionAmount  = $totalOptionAmount * $totalQty;

                                $NewTotalForTax     = $totalOptionAmount + $TourUpgradeTotal;


                                if ($tax != 0 && $NewTotalForTax != 0) {
                                    $tax_amount = ($NewTotalForTax / 100) * $tax;
                                }

                                // Tax And Service Charge--------------------------------------------------------------
                                $total_tax_charge          += $tax_amount;
                                $total_service_charge      += $service_charge;

                                $total_tax_per_product            += $tax_amount;
                                $total_tax_percentage_per_product += $tax;
                                $total_service_per_product        += $service_charge;

                                if ($get_cart_item['reward_point_apply'] != true) {
                                    $no_tax_service_total_amnt             += $NewTotalForTax;
                                    $no_tax_service_total_amnt_per_product += $NewTotalForTax;
                                }


                                $total_lodge_amount        += $totalOptionAmount = $NewTotalForTax + $tax_amount + $service_charge;
                                // Tax And Service Charge Lodge --------------------------------------------------------------

                                ////////////////////////////////////
                                $ProductLodgeLanguage                      = ProductLodgeLanguage::where(['product_id' => $product_id])->get();
                                $get_lodge_upgrade['title']                = getLanguageTranslate($ProductLodgeLanguage, $language, $lodge_option_id, 'title', 'lodge_id');
                                $get_lodge_upgrade['adult']                = $LO->lodge_option_adult;
                                $get_lodge_upgrade['child']                = $LO->lodge_option_child;
                                $get_lodge_upgrade['infant']               = $LO->lodge_option_infant;
                                $get_lodge_upgrade['lodge_arrival_date']   = $LO->lodge_arrival_date;
                                $get_lodge_upgrade['lodge_departure_date'] = $LO->lodge_departure_date;
                                $get_lodge_upgrade['no_of_rooms']          = $LO->no_of_rooms;
                                $get_lodge_upgrade['tax']                  = $tax;
                                $get_lodge_upgrade['tax_amount']           = $tax_amount;
                                $get_lodge_upgrade['with_out_tax_and_service_amount']         = $NewTotalForTax;

                                $get_lodge_upgrade['service_amount']       = $service_charge;

                                $get_lodge_upgrade['option_total']         = $totalOptionAmount;
                                if (isset($LO->lodgeupgrade)) {
                                    foreach ($LO->lodgeupgrade as $k => $LOU) {
                                        $get_option_lodge_upgrade_arr = [];
                                        $lodge_option_upgrade_id                          = $LOU->upgrade_id;
                                        $ProductOptionLodgeUpgrade                        = ProductOptionTourUpgrade::where(['id' => $lodge_option_upgrade_id])->first();
                                        $get_option_lodge_upgrade_arr['title']            = $ProductOptionLodgeUpgrade->title;
                                        $get_option_lodge_upgrade_arr['adult_price']      =    get_partners_dis_price(ConvertCurrency($ProductOptionLodgeUpgrade->adult_price), $product_id, $request->user_id, 'tour_upgrade_option', 'lodge');
                                        $get_option_lodge_upgrade_arr['lodge_adult_qty']  = $LOU->lodge_adult_qty;
                                        $get_option_lodge_upgrade_arr['child_price']      = get_partners_dis_price(ConvertCurrency($ProductOptionLodgeUpgrade->child_price), $product_id, $request->user_id, 'tour_upgrade_option', 'lodge');
                                        $get_option_lodge_upgrade_arr['lodge_child_qty']  = $LOU->lodge_child_qty;
                                        $get_option_lodge_upgrade_arr['infant_price']     = get_partners_dis_price(ConvertCurrency($ProductOptionLodgeUpgrade->infant_price), $product_id, $request->user_id, 'tour_upgrade_option', 'lodge');
                                        $get_option_lodge_upgrade_arr['lodge_infant_qty'] = $LOU->lodge_infant_qty;
                                        $get_lodge_upgrade['lodge_upgrade_option'][]      = $get_option_lodge_upgrade_arr;
                                    }
                                }
                                $get_cart_item['option'][] = $get_lodge_upgrade;
                            }
                            $getTotalAmntProduct            = $total_lodge_amount;
                        }


                        if ($CI['product_type'] == "excursion") {
                            $total_adult_price    = 0;
                            $total_child_price    = 0;
                            $total_infant_price   = 0;


                            // $totalexcursionAmount       =  $Product['selling_price'] !== '' ? $Product['selling_price'] : $Product['original_price'];
                            // $no_tax_service_total_amnt +=  $Product['selling_price'] !== '' ? $Product['selling_price'] : $Product['original_price'];

                            $excursion_option = json_decode($CI['extra']);
                            $ProductOptionArr = [];

                            foreach ($excursion_option as $key => $EO) {
                                $service_charge = 0;
                                $tax = 0;
                                $tax_amount = 0;
                                if ($key == "private_tour") {
                                    $ProductOptionArr['private_tour'] = array();
                                    foreach ($EO as $ptkey => $PT) {
                                        $total_tour_transfer_amount = 0;
                                        $service_charge             = 0;
                                        $tax                        = 0;
                                        $tax_amount                 = 0;
                                        $total_amount               = 0;
                                        $get_private_tour_arr       = [];
                                        $ProductOptionPrivateTourPrice = ProductOptionPrivateTourPrice::where('product_id', $product_id)
                                            ->where('product_option_id', $PT->id)
                                            ->first();
                                        $ProductOptionLanguage     = ProductOptionLanguage::where('product_id', $product_id)->get();
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
                                            $private_per_price             = ConvertCurrency($ProductOptionPrivateTourPrice['private_per_price']);
                                            $total_allowed                 = $ProductOptionPrivateTourPrice['total_allowed'];
                                            $private_tour_pasenger         = $PT->qty;
                                            $private_tour_total_passanger_ = 0;
                                            $total_private_per_price       = 0;

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



                                            $get_private_tour_arr['title']          = getLanguageTranslate($ProductOptionLanguage, $language, $PT->id, 'title', 'option_id');
                                            $get_private_tour_arr['adult']          = $PT->tour_adult_qty;
                                            $get_private_tour_arr['child']          = $PT->tour_child_qty;
                                            $get_private_tour_arr['infant']         = $PT->tour_infant_qty;
                                            $get_private_tour_arr['car_seats']      = $total_allowed;
                                            $get_private_tour_arr['date']           = date("Y-m-d", strtotime($PT->date));
                                            $get_private_tour_arr['total_cars']     = $private_tour_total_passanger_;
                                            $get_private_tour_arr['total_pasenger'] = $private_tour_pasenger;
                                            $get_private_tour_arr['price']          = $total_private_per_price;


                                            $private_tour_upgrade_total_amount = 0;
                                            $private_tour_total = 0;
                                            if (isset($PT->tour_upgrade)) {

                                                foreach ($PT->tour_upgrade as $k => $TU) {
                                                    if ($TU != "") {

                                                        $req_adult_qty = 0;
                                                        $req_child_qty = 0;
                                                        $req_infant_qty = 0;
                                                        $adult_price =  0;
                                                        $child_price =  0;
                                                        $infant_price =  0;
                                                        $get_option_tour_upgrade_arr                     = [];
                                                        $tour_option_upgrade_id                          = $TU->id;
                                                        $ProductOptionLodgeUpgrade                       = ProductOptionTourUpgrade::where(['id' => $tour_option_upgrade_id])->first();
                                                        if ($ProductOptionLodgeUpgrade) {
                                                            $get_option_tour_upgrade_arr['title']            = $ProductOptionLodgeUpgrade != "" ? $ProductOptionLodgeUpgrade->title : "";
                                                            $get_option_tour_upgrade_arr['adult_price']      = $adult_price    = get_partners_dis_price(ConvertCurrency($ProductOptionLodgeUpgrade->adult_price), $activity_id, $request->user_id, 'tour_upgrade_option', 'excursion');
                                                            $get_option_tour_upgrade_arr['lodge_adult_qty']  = $req_adult_qty  = $TU->adult_qty;

                                                            $get_option_tour_upgrade_arr['child_price']      = $child_price    = get_partners_dis_price(ConvertCurrency($ProductOptionLodgeUpgrade->child_price), $activity_id, $request->user_id, 'tour_upgrade_option', 'excursion');
                                                            $get_option_tour_upgrade_arr['lodge_child_qty']  = $req_child_qty  = $TU->child_qty;

                                                            $get_option_tour_upgrade_arr['infant_price']     = $infant_price   =  get_partners_dis_price(ConvertCurrency($ProductOptionLodgeUpgrade->infant_price), $activity_id, $request->user_id, 'tour_upgrade_option', 'excursion');
                                                            $get_option_tour_upgrade_arr['lodge_infant_qty'] = $req_infant_qty = $TU->infant_qty;



                                                            $total_adult_price = $adult_price * $req_adult_qty;
                                                            $total_child_price = $child_price * $req_child_qty;
                                                            $total_infant_price = $infant_price * $req_infant_qty;
                                                            $private_tour_upgrade_total_amount +=   $total_adult_price + $total_child_price + $total_infant_price;
                                                            $get_private_tour_arr['tour_upgrade_option'][]   = $get_option_tour_upgrade_arr;
                                                        }
                                                    }
                                                }
                                            }
                                            $private_tour_total = $total_private_per_price + $private_tour_upgrade_total_amount;
                                            if ($tax != 0 && $private_tour_total != 0) {
                                                $tax_amount = ($private_tour_total / 100) * $tax;
                                            }
                                            if ($total_private_per_price != 0) {
                                                $total_service_charge                   += $service_charge;
                                                $total_tax_charge                       += $tax_amount;

                                                // Tax Amd Servce Charge Private Excursion ----------------------------------------------------------------------------
                                                $total_tax_per_product                       += $tax_amount;
                                                $total_service_per_product                   += $service_charge;
                                                $total_tax_percentage_per_product                   += $tax;
                                                // Tax Amd Servce Charge Private Excursion ----------------------------------------------------------------------------

                                                $get_private_tour_arr['service_charge']  = $service_charge;
                                                $get_private_tour_arr['tax_amount']      = $tax_amount;
                                                $get_private_tour_arr['tax']             = number_format($tax, 2);
                                                if ($get_cart_item['reward_point_apply'] != true) {
                                                    $no_tax_service_total_amnt             += $private_tour_total;
                                                    $no_tax_service_total_amnt_per_product += $private_tour_total;
                                                }


                                                $totalexcursionAmount                   += $private_tour_total + $service_charge + $tax_amount;
                                                $get_private_tour_arr['with_out_tax_and_service_amount']              = $private_tour_total;
                                                $get_private_tour_arr['total_amount']   =  number_format($private_tour_total + $service_charge + $tax_amount, 2);
                                            }
                                        }

                                        $ProductOptionArr['private_tour'][] = $get_private_tour_arr;
                                    }
                                    // print_die($ProductOptionArr);
                                }

                                if ($key == "tour_transfer") {
                                    $ProductOptionArr['tour_transfer'] = [];
                                    foreach ($EO as $ttkey => $TT) {
                                        $get_tour_transfer_arr                   = [];
                                        $ProductOptionLanguage                   = ProductOptionLanguage::where('product_id', $product_id)->get();
                                        $get_tour_transfer_arr['title']          = getLanguageTranslate($ProductOptionLanguage, $language, $TT->id, 'title', 'option_id');
                                        $get_tour_transfer_arr['adult']          = $TT->tour_adult_qty;
                                        $get_tour_transfer_arr['child']          = $TT->tour_child_qty;
                                        $get_tour_transfer_arr['infant']         = $TT->tour_infant_qty;

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

                                            $get_tour_transfer_arr['per_adult_price']          = $adult_price;
                                            $get_tour_transfer_arr['per_child_price']          = $child_price;
                                            $get_tour_transfer_arr['per_infant_price']         = $infant_price;

                                            $adult_price = $AdultpercentageType;
                                            $child_price = $ChildpercentageType;
                                            $infant_price = $infantpercentageType;




                                            $total_adult_price  = $adult_price * $TT->tour_adult_qty;
                                            $total_child_price  = $child_price * $TT->tour_child_qty;
                                            $total_infant_price = $infant_price * $TT->tour_infant_qty;

                                            $get_tour_transfer_arr['total_adult_price']  = $total_adult_price;
                                            $get_tour_transfer_arr['total_child_price']  = $total_child_price;
                                            $get_tour_transfer_arr['total_infant_price'] = $total_infant_price;

                                            $total_tour_transfer_amount +=  $total_adult_price + $total_child_price + $total_infant_price;
                                        }




                                        if ($TT->is_private_transfer == 1) {
                                            $get_option_details = ProductOptionDetails::where('product_id', $product_id)
                                                ->where('product_option_id', $TT->id)
                                                ->where('id', $TT->transfer_option)
                                                ->first();
                                            // $adult_price  = 0;
                                            // $child_price  = 0;
                                            // $infant_price  = 0;
                                            if ($get_option_details) {
                                                // $adult_price = get_partners_dis_price(ConvertCurrency($get_option_details['edult']), $activity_id, $request->user_id, 'transfer_option', 'excursion');
                                                // $child_price = get_partners_dis_price(ConvertCurrency($get_option_details['child_price']), $activity_id, $request->user_id, 'transfer_option', 'excursion');
                                                // $infant_price = get_partners_dis_price(ConvertCurrency($get_option_details['infant']), $activity_id, $request->user_id, 'transfer_option', 'excursion');

                                                // $total_adult_price = $adult_price * $TT->tour_adult_qty;
                                                // $total_child_price = $child_price * $TT->tour_child_qty;
                                                // $total_infant_price = $infant_price * $TT->tour_infant_qty;
                                            }

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


                                                $car_price = ConvertCurrency($get_car_detail['price']);
                                                $car_seats = $get_car_detail['number_of_passengers'];

                                                if ($total_pasenger == 0) {
                                                    $car_price = 0;
                                                }
                                                if ($get_option_details['transfer_option']) {
                                                    $get_tour_transfer_arr['option_name'] = $get_option_details['transfer_option'];
                                                }

                                                $get_tour_transfer_arr['car_name']   = isset($get_car_name['title'])  ? $get_car_name['title'] : '';
                                                $get_tour_transfer_arr['adult']          = $TT->tour_adult_qty;
                                                $get_tour_transfer_arr['adult_price']    = $adult_price;
                                                $get_tour_transfer_arr['child_price']    = $child_price;
                                                $get_tour_transfer_arr['infant_price']   = $infant_price;
                                                $get_tour_transfer_arr['is_private_car'] = 1;
                                                $get_tour_transfer_arr['child']          = $TT->tour_child_qty;
                                                $get_tour_transfer_arr['infant']         = $TT->tour_infant_qty;
                                                $get_tour_transfer_arr['car_seats']      = $car_seats;
                                                $get_tour_transfer_arr['date']           = date("Y-m-d", strtotime($TT->date));
                                                $get_tour_transfer_arr['car_price']      = $car_price;
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
                                            $transfer_child_price =  get_partners_dis_price(ConvertCurrency($get_option_details['child_price']), $activity_id, $request->user_id, 'transfer_option', 'excursion');
                                            $transfer_infant_price = get_partners_dis_price(ConvertCurrency($get_option_details['infant']), $activity_id, $request->user_id, 'transfer_option', 'excursion');
                                            $transfer_total_adult_price  = $transfer_adult_price * $TT->tour_adult_qty;
                                            $transfer_total_child_price  = $transfer_child_price * $TT->tour_child_qty;
                                            $transfer_total_infant_price = $transfer_infant_price * $TT->tour_infant_qty;

                                            $total_transfer = $transfer_total_adult_price + $transfer_total_child_price + $transfer_total_infant_price;

                                            $get_tour_transfer_arr['adult_price']        = $get_option_details['edult'] > 0 ? get_partners_dis_price(ConvertCurrency($get_option_details['edult']), $activity_id, $request->user_id, 'transfer_option', 'excursion') : 'N/A';
                                            $get_tour_transfer_arr['child_price']        = $get_option_details['child_price'] > 0 ? get_partners_dis_price(ConvertCurrency($get_option_details['child_price']), $activity_id, $request->user_id, 'transfer_option', 'excursion') : 'N/A';
                                            $get_tour_transfer_arr['infant_price']       = $get_option_details['infant'] > 0 ?  get_partners_dis_price(ConvertCurrency($get_option_details['infant']), $activity_id, $request->user_id, 'transfer_option', 'excursion') : 'N/A';
                                            if ($get_option_details['transfer_option']) {
                                                $get_tour_transfer_arr['option_name'] = $get_option_details['transfer_option'];
                                            }
                                            $get_tour_transfer_arr['is_private_car']     = 1;
                                            $get_tour_transfer_arr['adult']              = $TT->tour_adult_qty;
                                            $get_tour_transfer_arr['date']              = date("Y-m-d", strtotime($TT->date));
                                            $get_tour_transfer_arr['child']              = $TT->tour_child_qty;
                                            $get_tour_transfer_arr['infant']             = $TT->tour_infant_qty;
                                            $get_tour_transfer_arr['total_adult_price']  = $total_adult_price;
                                            $get_tour_transfer_arr['total_child_price']  = $total_child_price;
                                            $get_tour_transfer_arr['total_infant_price'] = $total_infant_price;

                                            $get_tour_transfer_arr['total']              = $total_tour_transfer_amount = $total_tour_transfer_amount + $total_transfer;
                                        }


                                        $tour_transfer_upgrade_total_amount = 0;
                                        $private_tour_total = 0;
                                        if (isset($TT->tour_upgrade)) {

                                            foreach ($TT->tour_upgrade as $k => $TU) {
                                                if ($TU != "") {

                                                    $req_adult_qty = 0;
                                                    $req_child_qty = 0;
                                                    $req_infant_qty = 0;
                                                    $adult_price =  0;
                                                    $child_price =  0;
                                                    $infant_price =  0;
                                                    $get_option_tour_upgrade_arr                     = [];
                                                    $tour_option_upgrade_id                          = $TU->id;

                                                    $ProductOptionLodgeUpgrade                       = ProductOptionTourUpgrade::where(['id' => $tour_option_upgrade_id])->first();
                                                    if ($ProductOptionLodgeUpgrade) {
                                                        $get_option_tour_upgrade_arr['title']            = $ProductOptionLodgeUpgrade->title;
                                                        $get_option_tour_upgrade_arr['adult_price']      = $adult_price    = get_partners_dis_price(ConvertCurrency($ProductOptionLodgeUpgrade->adult_price), $activity_id, $request->user_id, 'tour_upgrade_option', 'excursion');
                                                        $get_option_tour_upgrade_arr['lodge_adult_qty']  = $req_adult_qty  = $TU->adult_qty;
                                                        $get_option_tour_upgrade_arr['child_price']      = $child_price    = get_partners_dis_price(ConvertCurrency($ProductOptionLodgeUpgrade->child_price), $activity_id, $request->user_id, 'tour_upgrade_option', 'excursion');
                                                        $get_option_tour_upgrade_arr['lodge_child_qty']  = $req_child_qty  = $TU->child_qty;
                                                        $get_option_tour_upgrade_arr['infant_price']     = $infant_price   = get_partners_dis_price(ConvertCurrency($ProductOptionLodgeUpgrade->infant_price), $activity_id, $request->user_id, 'tour_upgrade_option', 'excursion');
                                                        $get_option_tour_upgrade_arr['lodge_infant_qty'] = $req_infant_qty = $TU->infant_qty;




                                                        $total_adult_price = $adult_price * $req_adult_qty;
                                                        $total_child_price = $child_price * $req_child_qty;
                                                        $total_infant_price = $infant_price * $req_infant_qty;
                                                        $tour_transfer_upgrade_total_amount +=   $total_adult_price + $total_child_price + $total_infant_price;
                                                        $get_tour_transfer_arr['tour_upgrade_option'][]   = $get_option_tour_upgrade_arr;
                                                    }
                                                }
                                            }
                                        }
                                        $total_tour_transfer_amount = $total_tour_transfer_amount + $tour_transfer_upgrade_total_amount;

                                        if ($tax != 0 && $total_tour_transfer_amount != 0) {
                                            $tax_amount = ($total_tour_transfer_amount / 100) * $tax;
                                        }
                                        if ($total_tour_transfer_amount != 0) {
                                            $get_tour_transfer_arr['service_charge'] = $service_charge;
                                            $get_tour_transfer_arr['tax']            = $tax;
                                            $get_tour_transfer_arr['tax_amount']     = number_format($tax_amount, 2);
                                            $get_tour_transfer_arr['total_amount']   = number_format($total_tour_transfer_amount + $service_charge + $tax_amount, 2);
                                        }
                                        // TAX And SERvice  ----------------------------------------------------------------------------------
                                        $total_service_charge           += $service_charge;
                                        $total_tax_charge               += $tax_amount;

                                        $total_service_per_product      += $service_charge;
                                        $total_tax_per_product          += $tax_amount;
                                        $total_tax_percentage_per_product          += $tax;

                                        // TAX And SERvice Excursion ----------------------------------------------------------------------------------
                                        if ($get_cart_item['reward_point_apply'] != true) {
                                            $no_tax_service_total_amnt             += $total_tour_transfer_amount;
                                            $no_tax_service_total_amnt_per_product += $total_tour_transfer_amount;
                                        }

                                        $totalexcursionAmount                += $total_tour_transfer_amount + $service_charge + $tax_amount;
                                        $get_tour_transfer_arr['with_out_tax_and_service_amount']              = $total_tour_transfer_amount;
                                        $ProductOptionArr['tour_transfer'][] = $get_tour_transfer_arr;
                                    }
                                }

                                if ($key == "group_percentage") {

                                    foreach ($EO as $gpkey => $GP) {
                                        $tour_group_percentage_arr      = [];
                                        $ProductGroupPercentageLanguage = ProductGroupPercentageLanguage::where(['product_id' => $product_id])->get();
                                        $ProductGroupPercentage         = ProductGroupPercentage::where(['id' => $GP->id, 'product_id' => $product_id])->first();

                                        $ProductGroupPercentageDetails = ProductGroupPercentageDetails::where(['product_id' => $product_id])
                                            ->where('number_of_pax', '>=',  $GP->qty)
                                            ->where('number_of_pax', '<=',  $GP->qty)
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
                                        $group_price                              = 0;
                                        if ($GP->qty <= 0) {
                                            $amount = 0;
                                        } else {
                                            $group_price = $amount /  $GP->qty;
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

                                        $tour_group_percentage_arr['service_charge_allowed']         = $ProductGroupPercentage['service_charge_allowed'];
                                        $tour_group_percentage_arr['tax_allowed']                    = $ProductGroupPercentage['tax_allowed'];
                                        $tour_group_percentage_arr['tax_percentage']                 = $ProductGroupPercentage['tax_percentage'];
                                        $tour_group_percentage_arr['tax_amount']                     = $tax_amount;
                                        $tour_group_percentage_arr['service_charge']                 = $service_charge;

                                        // Tax Service Excusrion---------------------------------------------------------
                                        $total_tax_per_product     += $tax_amount;
                                        $total_service_per_product += $service_charge;
                                        $total_tax_percentage_per_product += $tax;

                                        $total_service_charge      += $service_charge;
                                        $total_tax_charge          += $tax_amount;
                                        // Tax Service Excusrion---------------------------------------------------------

                                        $total_amount               = 0;
                                        if ($get_cart_item['reward_point_apply'] != true) {
                                            $no_tax_service_total_amnt             += $amount;
                                            $no_tax_service_total_amnt_per_product += $amount;
                                        }
                                        $total_amount               = $amount + $service_charge + $tax_amount;

                                        $tour_group_percentage_arr['title']               = getLanguageTranslate($ProductGroupPercentageLanguage, $language, $GP->id, 'title', 'group_percentage_id');
                                        $tour_group_percentage_arr['date']                = date("Y-m-d", strtotime($GP->date));
                                        $tour_group_percentage_arr['qty']                 = $GP->qty;
                                        $tour_group_percentage_arr['with_out_tax_and_service_amount']              = $amount;
                                        $tour_group_percentage_arr['amount']              = $total_amount;
                                        $tour_group_percentage_arr['is_group_percentage'] = 1;
                                        $tour_group_percentage_arr['group_price']         = number_format($group_price, 2);
                                        $totalexcursionAmount +=  $total_amount;
                                        $ProductOptionArr['group_percentage'][] = $tour_group_percentage_arr;
                                    }
                                }
                            }

                            $get_cart_item['option'][] =  $ProductOptionArr;
                            $getTotalAmntProduct       = $totalexcursionAmount;
                        }

                        if ($CI['product_type'] == "Yatch") {
                            $get_yacht_arr  = [];
                            $yacht_option   = json_decode($CI['extra']);

                            $price = $Product->selling_price !== '' ?  get_partners_dis_price(ConvertCurrency($Product->selling_price), $product_id, $request->user_id, 'base_price', 'yacht')
                                : get_partners_dis_price(ConvertCurrency($Product->original_price), $product_id, $request->user_id, 'base_price', 'yacht');
                            if (isset($yacht_option->date)) {

                                if ($yacht_option->date != "") {
                                    $WeekDay = date('l', strtotime($yacht_option->date));
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

                            if (isset($yacht_option->start_time)) {
                                $startTime = $yacht_option->start_time;
                            } else {
                                $startTime = date("H");
                            }
                            if (isset($yacht_option->end_time)) {
                                $endTime = $yacht_option->end_time;
                            } else {
                                $endTime = $startTime + $yacht_option->get_hours;
                            }
                            // Hour Price
                            $get_yacht_arr['title']       = "Yacht Charter Price";
                            $get_yacht_arr['date']        = $yacht_option->date;
                            $get_yacht_arr['start_time']  = $startTime;
                            $get_yacht_arr['end_time']    = $endTime;
                            $get_yacht_arr['price']       = $price;
                            $get_cart_item['price']       = $price;
                            $get_yacht_arr['get_hours']   = $yacht_option->get_hours;
                            $hprice                       = $price * $yacht_option->get_hours;
                            $get_yacht_arr['total_price'] = $hprice;
                            $get_yacht_arr['guest']       = $yacht_option->guest;
                            $get_yacht_arr['hour_price']  = 1;
                            $get_yacht_arr['way']         = 0;

                            $totalYachtAmount            += $price * $yacht_option->get_hours;

                            foreach ($yacht_option as $yokey => $YO) {
                                if ($yokey == 'transportaion') {
                                    $get_yacht_arr['transportaion'] = [];
                                    foreach ($YO as $tkey => $TP) {
                                        $TransportationVehicle = TransportationVehicle::where(['id' => $TP->id])->first();
                                        $ProductTransportationVehicle = $Product->transportation_vehicle;
                                        $ProductTransportationVehicleArr = explode(",", $ProductTransportationVehicle);
                                        if (in_array($TP->id, $ProductTransportationVehicleArr)) {
                                            if ($TransportationVehicle) {


                                                $TransportationVehiclelanguage = TransportationVehicleLanguage::where(['transportation_vehicle_id' =>  $TP->id])->get();
                                                $TransportationVehicleLanguage = getLanguageTranslate($TransportationVehiclelanguage, $language, $TP->id, 'title', 'transportation_vehicle_id');
                                                $transportationArr = [];

                                                if ($TP->two_way == 1) {
                                                    $price = get_partners_dis_price(ConvertCurrency($TransportationVehicle->two_way_price), $product_id, $request->user_id, 'transportation', 'yacht');
                                                } else {
                                                    $price = get_partners_dis_price(ConvertCurrency($TransportationVehicle->one_way_price), $product_id, $request->user_id, 'transportation', 'yacht');
                                                }

                                                $transportationArr['title']        = $TransportationVehicleLanguage != "" ? $TransportationVehicleLanguage : $TP->title;
                                                $transportationArr['way']          = $TP->two_way == 1 ? "Two Way" : "One Way";
                                                $transportationArr['price']        = $price;
                                                $transportationArr['get_hours']    = $TP->select_qty;
                                                $trprice                           = $price  * $TP->select_qty;
                                                $totalYachtAmount                 += $trprice;
                                                $transportationArr['total_price']  = $trprice;

                                                $transportationArr['hour_price']  = 1;
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
                                        $ProductyachttransferoptionLanguage = Productyachttransferoptionlanguage::where(['product_yacht_transfer_option_id' => $TP->id])->where('language_id', $language)->first();

                                        if ($Productyachttransferoption) {
                                            $get_transfer_arr                 = [];
                                            $get_transfer_arr['title']        = $ProductyachttransferoptionLanguage != "" ? $ProductyachttransferoptionLanguage->title : $TP->title;
                                            $get_transfer_arr['way']          = 1;
                                            $get_transfer_arr['price']        = get_partners_dis_price(ConvertCurrency($Productyachttransferoption->price), $product_id, $request->user_id, 'transfer_option', 'yacht');
                                            $get_transfer_arr['get_hours']    = $TP->select_qty;
                                            $tprice                           = get_partners_dis_price(ConvertCurrency($Productyachttransferoption->price), $product_id, $request->user_id, 'transfer_option', 'yacht')  * $TP->select_qty;
                                            $totalYachtAmount                += $tprice;
                                            $get_transfer_arr['total_price']  = $tprice;


                                            $get_transfer_arr['hour_price']     = 1;
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
                                        $ProductTourPriceDetails             = ProductTourPriceDetails::where(['product_id' => $product_id, 'product_option_id' => $WSA->id])->first();
                                        $ProductOptionWeekTour               = ProductOptionWeekTour::where(['product_id' => $product_id, 'product_option_id' => $WSA->id, 'week_day' => $WeekDay])->first();

                                        $adult_price                         = $ProductTourPriceDetails            != '' ?  get_partners_dis_price(ConvertCurrency($ProductTourPriceDetails->adult_price), $product_id, $request->user_id, 'food_beverage', 'yacht') : 0;
                                        $infant_price                        = $ProductTourPriceDetails            != '' ? get_partners_dis_price(ConvertCurrency($ProductTourPriceDetails->infant_price), $product_id, $request->user_id, 'food_beverage', 'yacht')  : 0;
                                        $child_price                         = $ProductTourPriceDetails            != '' ? get_partners_dis_price(ConvertCurrency($ProductTourPriceDetails->child_price), $product_id, $request->user_id, 'food_beverage', 'yacht')  : 0;
                                        if ($ProductOptionWeekTour != '') {
                                            $adult_price                         = get_partners_dis_price(ConvertCurrency($ProductOptionWeekTour->adult), $product_id, $request->user_id, 'food_beverage', 'yacht');
                                            $child_price                         =  get_partners_dis_price(ConvertCurrency($ProductOptionWeekTour->child_price), $product_id, $request->user_id, 'food_beverage', 'yacht');
                                            $infant_price                        = get_partners_dis_price(ConvertCurrency($ProductOptionWeekTour->infant_price), $product_id, $request->user_id, 'food_beverage', 'yacht');
                                        }

                                        if ($adult_qty > 0 || $child_qty > 0) {



                                            $get_water_sports_arr['title']       =  getLanguageTranslate($ProductOptionLanguage, $language, $WSA->id, 'title', 'option_id');
                                            $get_water_sports_arr['hour_price']  = 0;
                                            $get_water_sports_arr['way']         = 0;
                                            $get_water_sports_arr['adult_price'] = $adult_price;
                                            $get_water_sports_arr['adult_qty']   = $adult_qty;
                                            $get_water_sports_arr['child_price'] = $child_price;
                                            $get_water_sports_arr['child_qty']   = $child_qty;
                                            $wprice  =  ($child_price *  $child_qty) + ($adult_qty *  $adult_price);
                                            $totalYachtAmount += $wprice;
                                            $get_water_sports_arr['total_price'] = $wprice;
                                            if ($wprice > 0) {
                                                $get_yacht_arr['food_beverage'][]                      = $get_water_sports_arr;
                                            }
                                        }
                                    }
                                }


                                if ($yokey == 'food_beverage') {
                                    $get_yacht_arr['water_sports'] = [];
                                    foreach ($YO as $tkey => $TPA) {
                                        $Productyachtwatersport = Productyachtwatersport::where(['id' => $TPA->id])->first();

                                        $Productyachtwatersport         = Productyachtwatersport::where(['id' => $TPA->id])->first();
                                        $Productyachtwatersportlanguage = Productyachtwatersportlanguage::where(['product_yacht_water_sport_id' => $TPA->id])->where('language_id', $language)->first();

                                        if ($Productyachtwatersport) {
                                            $get_water_arr                 = [];
                                            $get_water_arr['title']        = $Productyachtwatersportlanguage != "" ? $Productyachtwatersportlanguage->title  : $TPA->title;
                                            $get_water_arr['way']          = 1;
                                            $get_water_arr['price']        = get_partners_dis_price(ConvertCurrency($Productyachtwatersport->price), $product_id, $request->user_id, 'water_sports', 'yacht');
                                            $get_water_arr['get_hours']    = $TPA->select_qty;
                                            $tprice                           =  get_partners_dis_price(ConvertCurrency($Productyachtwatersport->price), $product_id, $request->user_id, 'water_sports', 'yacht') * $TPA->select_qty;
                                            $totalYachtAmount                += $tprice;
                                            $get_water_arr['total_price']  = $tprice;


                                            $get_water_arr['hour_price']     = 1;
                                            if ($tprice > 0) {

                                                $get_yacht_arr['water_sports'][] = $get_water_arr;
                                            }
                                        }
                                    }
                                }
                            }

                            if ($get_cart_item['reward_point_apply'] != true) {
                                $no_tax_service_total_amnt    += $totalYachtAmount;
                                $no_tax_service_total_amnt_per_product    += $totalYachtAmount;
                            }

                            $get_yacht_arr['sub_total']    = $totalYachtAmount;


                            $tax_amount = 0;
                            $service_charge = 0;
                            $tax_percentage = 0;
                            if ($Product->tax_allowed == 1) {
                                if ($Product->tax_percentage > 0) {
                                    $tax_percentage = $Product->tax_percentage;
                                    $tax_amount = ($totalYachtAmount / 100) * $Product->tax_percentage;
                                }
                            }
                            $get_cart_item['tax_amount'] = $tax_amount;
                            $get_cart_item['tax']        = $tax_percentage;

                            if ($Product->service_allowed == 1) {
                                if ($Product->service_amount > 0) {
                                    $service_charge = ConvertCurrency($Product->service_amount);
                                }
                            }
                            // Tax Service Yacht  ---------------------------------------------------------------
                            $total_service_charge += $service_charge;
                            $total_tax_charge     += $tax_amount;

                            $total_service_per_product += $service_charge;
                            $total_tax_per_product     += $tax_amount;
                            $total_tax_percentage_per_product     += $tax;

                            // Tax Service Yacht ---------------------------------------------------------------
                            $get_cart_item['service_charge'] = $service_charge;

                            $get_yacht_arr['total_amount'] = $totalYachtAmount = $totalYachtAmount + $service_charge + $tax_amount;
                            $get_cart_item['option'][]     = $get_yacht_arr;

                            $getTotalAmntProduct           = $totalYachtAmount;
                        }

                        if ($CI['product_type'] == "Limousine") {
                            $get_yacht_arr = [];
                            $yacht_option = json_decode($CI['extra']);


                            $price = $Product->selling_price !== '' ? get_partners_dis_price(ConvertCurrency($Product->selling_price), $product_id, $request->user_id, 'base_price', 'limousine') : get_partners_dis_price(ConvertCurrency($Product->original_price), $product_id, $request->user_id, 'base_price', 'limousine');
                            if (isset($yacht_option->date)) {

                                if ($yacht_option->date != "") {
                                    $WeekDay = date('l', strtotime($yacht_option->date));
                                    $ProductPrice = ProductOptionWeekTour::where(['product_id' => $product_id, 'week_day' => $WeekDay, 'for_general' => 1])->first();
                                    if ($ProductPrice) {
                                        $price = get_partners_dis_price(ConvertCurrency($ProductPrice->adult), $product_id, $request->user_id, 'weekdays', 'limousine');
                                    }
                                } else {
                                    $date = date("Y-m-d");
                                    $WeekDay = date('l', strtotime($date));
                                    $ProductPrice = ProductOptionWeekTour::where(['product_id' => $product_id, 'week_day' => $WeekDay, 'for_general' => 1])->first();
                                    if ($ProductPrice) {
                                        $price = get_partners_dis_price(ConvertCurrency($ProductPrice->adult), $product_id, $request->user_id, 'weekdays', 'limousine');
                                    }
                                }
                            } else {
                                $date = date("Y-m-d");
                                $WeekDay = date('l', strtotime($date));
                                $ProductPrice = ProductOptionWeekTour::where(['product_id' => $product_id, 'week_day' => $WeekDay, 'for_general' => 1])->first();
                                if ($ProductPrice) {
                                    $price =  get_partners_dis_price(ConvertCurrency($ProductPrice->adult), $product_id, $request->user_id, 'weekdays', 'limousine');
                                }
                            }

                            if (isset($yacht_option->start_time)) {
                                $startTime = $yacht_option->start_time;
                            } else {
                                $startTime = date("H");
                            }
                            if (isset($yacht_option->end_time)) {
                                $endTime = $yacht_option->end_time;
                            } else {
                                $endTime = $startTime + $yacht_option->get_hours;
                            }
                            $get_yacht_arr['title']       = "Hour Price";
                            $get_yacht_arr['date']        = $yacht_option->date;
                            $get_yacht_arr['start_time']  = $startTime;
                            $get_yacht_arr['end_time']    = $endTime;
                            $get_yacht_arr['price']       = $price;
                            $get_cart_item['price']       = $price;
                            $get_yacht_arr['get_hours']   = $yacht_option->get_hours;
                            $hprice                       = $price * $yacht_option->get_hours;
                            $get_yacht_arr['total_price'] = $hprice;
                            $get_yacht_arr['guest']       = $yacht_option->guest;
                            $get_yacht_arr['hour_price']  = 1;
                            $get_yacht_arr['way']         = 0;

                            $totalLimousinAmount            += $price * $yacht_option->get_hours;

                            foreach ($yacht_option as $yokey => $YO) {
                                if ($yokey == 'transfer_option') {
                                    $get_yacht_arr['transfer_option'] = [];
                                    foreach ($YO as $tkey => $TP) {
                                        $Productyachttransferoption         = Productyachttransferoption::where(['id' => $TP->id])->first();
                                        $ProductyachttransferoptionLanguage = Productyachttransferoptionlanguage::where(['product_id' => $product_id])->get();
                                        if ($Productyachttransferoption) {
                                            $ProductyachttransferoptionLanguagetitle = getLanguageTranslate($ProductyachttransferoptionLanguage, $language, $TP->id, 'title', 'product_yacht_transfer_option_id');

                                            $get_transfer_arr                 = [];
                                            $get_transfer_arr['title']        = $ProductyachttransferoptionLanguagetitle != "" ? $ProductyachttransferoptionLanguagetitle : $TP->title;
                                            $get_transfer_arr['way']          = 1;
                                            $get_transfer_arr['price']        = get_partners_dis_price(ConvertCurrency($Productyachttransferoption->price), $product_id, $request->user_id, 'transfer_option', 'limousine');
                                            $get_transfer_arr['get_hours']    = $TP->select_qty;
                                            $tprice                           = get_partners_dis_price(ConvertCurrency($Productyachttransferoption->price), $product_id, $request->user_id, 'transfer_option', 'limousine')  * $TP->select_qty;
                                            $totalLimousinAmount                += $tprice;
                                            $get_transfer_arr['total_price']  = $tprice;


                                            $get_transfer_arr['hour_price']     = 1;
                                            if ($tprice > 0) {
                                                $get_yacht_arr['transfer_option'][] = $get_transfer_arr;
                                            }
                                        }
                                    }
                                }
                            }

                            $get_yacht_arr['sub_total'] = $totalLimousinAmount;
                            if ($get_cart_item['reward_point_apply'] != true) {
                                $no_tax_service_total_amnt  += $totalLimousinAmount;
                                $no_tax_service_total_amnt_per_product  += $totalLimousinAmount;
                            }


                            $tax_amount = 0;
                            $service_charge = 0;
                            $tax_percentage = 0;
                            if ($Product->tax_allowed == 1) {
                                if ($Product->tax_percentage > 0) {
                                    $tax_percentage = $Product->tax_percentage;
                                    $tax_amount = ($totalLimousinAmount / 100) * $Product->tax_percentage;
                                }
                            }
                            $get_cart_item['tax_amount'] = $tax_amount;
                            $get_cart_item['tax']        = $tax_percentage;

                            if ($Product->service_allowed == 1) {
                                if ($Product->service_amount > 0) {
                                    $service_charge = ConvertCurrency($Product->service_amount);
                                }
                            }

                            $get_cart_item['service_charge']        = $service_charge;



                            // Tax Service Yacht  ---------------------------------------------------------------
                            $total_service_charge += $service_charge;
                            $total_tax_charge     += $tax_amount;

                            $total_service_per_product += $service_charge;
                            $total_tax_per_product     += $tax_amount;
                            $total_tax_percentage_per_product     += $tax_percentage;
                            // Tax Service Yacht ---------------------------------------------------------------

                            $get_yacht_arr['total_amount'] = $totalLimousinAmount =  $totalLimousinAmount + $service_charge + $tax_amount;
                            $get_cart_item['option'][]     = $get_yacht_arr;

                            $getTotalAmntProduct             = $totalLimousinAmount;
                        }


                        //Reward Points Add
                        if (isset($Product['client_reward_point'])) {
                            $product_reward_point =  $Product['client_reward_point'];
                            if ($Product['client_reward_point_type'] == 'Percentage') {
                                // $reward_point    +=  $Product['client_reward_point'];
                                $product_reward_point  = ($no_tax_service_total_amnt_per_product * $Product['client_reward_point']) / 100;
                            }

                            //Reward Points Add                
                            $reward_point    +=  $product_reward_point;
                        }
                    }

                    if ($CI['product_type'] == "GiftCard") {
                        $gift_option                            = json_decode($CI['extra']);
                        $get_gift_arr                           = [];
                        $get_gift_arr['name']                   = $gift_option->name;
                        $get_gift_arr['email']                  = $gift_option->email;
                        $get_gift_arr['phone_code']             = $gift_option->phone_code;
                        $get_gift_arr['phone_number']           = $gift_option->phone_number;
                        $get_gift_arr['recipient_name']         = $gift_option->recipient_name;
                        $get_gift_arr['recipient_phone_number'] = $gift_option->recipient_phone_number;
                        $get_gift_arr['recipient_phone_code']   = $gift_option->recipient_phone_code;
                        $get_gift_arr['recipient_email']        = $gift_option->recipient_email;
                        $get_gift_arr['note']                   = $gift_option->gift_title;
                        $get_gift_arr['total']                  = ConvertCurrency($gift_option->amount, $gift_option->currency);
                        $totalgiftamount                        = ConvertCurrency($gift_option->amount, $gift_option->currency);

                        // $get_cart_item['price']                 = $gift_option->amount > 0 ? $gift_option->amount : 0;
                        $get_gift_arr['image']                  = asset("public/uploads/user_gift_card/" . $gift_option->image);
                        $get_cart_item['option'][]              = $get_gift_arr;
                        $no_tax_service_total_amnt             += $totalgiftamount;
                        $getTotalAmntProduct                    = $totalgiftamount;
                        $no_tax_service_total_amnt_per_product                    = $totalgiftamount;
                    }






                    $get_total_amnt                                         += $totalgiftamount + $totalYachtAmount + $totalLimousinAmount + $totalexcursionAmount + $total_lodge_amount;
                    $get_cart_item['id']                                     = $CI['id'];
                    $get_cart_item['title']                                  = $title;
                    $get_cart_item['type']                                   = $CI['product_type'];
                    $get_cart_item['description']                            = $main_description;
                    $get_cart_item['total_lodge_amount']                     = $total_lodge_amount;
                    $get_cart_item['totalexcursionamount']                   = $totalexcursionAmount;
                    $get_cart_item['totalLimousinAmount']                    = $totalLimousinAmount;
                    $get_cart_item['totalyachtamount']                       = $totalYachtAmount;
                    $get_cart_item['totalgiftamount']                        = $totalgiftamount;
                    $get_cart_item['getTotalAmntProduct']                    = $getTotalAmntProduct;
                    $get_cart_item['no_tax_service_total_amnt_per_product']  = $no_tax_service_total_amnt_per_product;
                    $get_cart_item['total_tax_per_product']                  = $total_tax_per_product;
                    $get_cart_item['total_tax_percentage_per_product']       = $total_tax_percentage_per_product;
                    $get_cart_item['total_service_per_product']              = $total_service_per_product;
                    $get_cart_item['sum_tax_service_per_product']            = $total_service_per_product + $total_tax_per_product;
                    $cartItemArr[]                                           = $get_cart_item;
                }
                $msg = "Cart Item";
            } else {
                $msg = "No item in cart";
            }
        } else {
            $msg = "No item in cart";
        }
        $output['is_coupon_appply']  = 0;
        $output['is_gift_card_coupon_appply']  = 0;
        $get_total_amnt              = $no_tax_service_total_amnt;
        if (isset($request->coupon_code)) {
            $get_coupon_code  = CouponCode::where(['coupon_code' => $request->coupon_code, 'status' => 'Active'])->first();
            $coupon_amount = 0;
            $total         = 0;
            if ($get_coupon_code['coupon_value'] > 0) {
                $coupon_value  = ConvertCurrency($get_coupon_code['coupon_value']);
                $no_tax_service_total_amnt =  str_replace(',', '', $no_tax_service_total_amnt);
                if ($get_coupon_code['coupon_type'] == 'percent') {
                    if ($no_tax_service_total_amnt > 0) {
                        $coupon_value_amount = $coupon_value > 0  ? $coupon_value : 0;
                        $coupon_value        = ($no_tax_service_total_amnt / 100) * $coupon_value_amount;
                    }
                }
                $get_total_amnt              = $no_tax_service_total_amnt - $coupon_value;
                if ($get_total_amnt < 0) {
                    $get_total_amnt = 0;
                }
                $output['coupon_id']        = $get_coupon_code['id'];
                $output['coupon_value']     = number_format($coupon_value, 2);
                $output['code']             = $get_coupon_code['coupon_code'];
                $output['is_coupon_appply'] = 1;
            }
        }




        usort($cartItemArr, function ($a, $b) {
            return ($a["id"] > $b["id"]) ? -1 : 1;
        });

        $get_total_amnt                               = $get_total_amnt + $total_tax_charge + $total_service_charge;

        //GiftCard Code Start
        if (isset($request->giftCardCode)) {
            $get_gift_coupon_code  = ProductCheckoutGiftCard::where(['gift_card_code' => $request->giftCardCode, 'gift_card_status' => 'Pending'])->first();
            $coupon_amount = 0;
            $total         = 0;
            if ($get_gift_coupon_code['gift_amount'] > 0) {
                $gift_card_amount                     = ConvertCurrency($get_gift_coupon_code['gift_amount'], $get_gift_coupon_code['currency']);
                // $gift_card_amount                     = ConvertCurrency($get_gift_coupon_code['gift_amount']);

                $AfterGiftCardTotal                   = $get_total_amnt - $gift_card_amount;
                $output['gift_card_coupon_id']        = $get_gift_coupon_code['id'];
                $output['gift_amount']                = number_format($gift_card_amount, 2);
                $output['gift_card_code']             = $get_gift_coupon_code['gift_card_code'];
                $output['is_gift_card_coupon_appply'] = 1;
            }

            if ($gift_card_amount > $get_total_amnt) {
                $AfterGiftCardTotal = 0;
            }
            $get_total_amnt  = $AfterGiftCardTotal;
        }
        //GiftCard Code 

        //GiftCard Wallet Amount
        $output['gift_wallet_amount']         = 0;
        $output['is_gift_card_wallet_appply'] = false;
        $user_gift_card_wallet = 0;
        if ($giftcard_wallet_apply == 'true') {
            if ($user_id > 0) {
                $CheckWalletUser = User::where('id', $user_id)->first();
                if ($CheckWalletUser) {
                    $user_gift_card_wallet =  $CheckWalletUser['giftcard_wallet'];
                    if ($user_gift_card_wallet > 0) {
                        $user_gift_card_wallet       = ConvertCurrency($user_gift_card_wallet);
                        $after_gift_card_wallet_amnt = $get_total_amnt - $user_gift_card_wallet;



                        if ($user_gift_card_wallet > $get_total_amnt) {
                            $after_gift_card_wallet_amnt = $user_gift_card_wallet - $get_total_amnt;
                        }
                        $get_total_amnt  = $after_gift_card_wallet_amnt;
                        $output['is_gift_card_wallet_appply']  = true;
                        $output['gift_wallet_amount']          = $user_gift_card_wallet;
                    }
                }
            }
        }
        //GiftCard Wallet Amount End




        $output['total_reddem_client_rewards_points'] = $total_reddem_client_rewards_points;
        $output['remaining_points']                   = $get_user_current_reward_point - $total_reddem_client_rewards_points;
        $output['data']                               = $cartItemArr;
        $output['sub_total']                          = $no_tax_service_total_amnt;
        $output['total_service_charge']               = $total_service_charge;
        $output['total_tax_charge']                   = $total_tax_charge;
        $output['total_amount']                       = $get_total_amnt;
        $output['reward_point']                       = round($reward_point);
        $output['status']                             = true;
        $output['message']                            = $msg;
        return json_encode($output);
    }

    public function remove_cart_item(Request $request)
    {

        $output = [];
        $output['status'] = false;
        $output['msg'] = 'Not Data Found';

        $validation = Validator::make($request->all(), [
            'language' => 'required',
            'token'    => 'required',
            'cart_id'  => 'required',
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
        $cartID = $request->cart_id;

        AddToCart::where(["id" => $cartID])->delete();

        $token            = $request->token;
        $cartItemArr      = [];
        if ($request->user_id) {
            $user_id      = checkDecrypt($request->user_id);
            $CartItem      = AddToCart::where("token", $token)->update(array('user_id' => $user_id));
        }
        $CartItem          = AddToCart::select();
        if ($request->user_id) {
            $CartItem      =  $CartItem->where('user_id', $user_id);
        } else {
            $CartItem      =  $CartItem->where('token', $token);
        }
        $CartItem          = $CartItem->orderBy("id", "DESC")->get();
        $reward_point = 0;
        if (count($CartItem) > 0) {
            foreach ($CartItem as $key => $CI) {
                $product_id       = $CI['product_id'];
                $Product          = Product::where('id', $product_id)->first();
                if ($Product) {
                    $reward_point          +=  $Product['client_reward_point'];
                }
            }
        }
        $token = $request->token;
        if ($token  != "" && $token  != 'null') {

            $data['cart_count']                  = AddToCart::where(["token" => $request->token])->count();
        } else {
            $data['cart_count']  = 0;
        }

        $output['status']       = true;
        $output['data']         = $data;
        $output['reward_point'] = $reward_point;
        $output['message']      = 'Remove From Cart Successfully...';
        return json_encode($output);
    }


    public function get_airport_list(Request $request)
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

        $AirportArr = [];
        $AirportModel = AirportModel::where(['status' => "Active", 'is_delete' => 0]);

        if (isset($request->term)) {
            $AirportModel = $AirportModel->where('name', 'like', '%' . $request->term . '%');
        }
        $AirportModel = $AirportModel->get();

        foreach ($AirportModel as $key => $A) {
            $get_airport_list         = [];
            $get_airport_list['id']   = $A['id'] ?? 0;
            $get_airport_list['name'] = $A['name'];
            $AirportArr[]             = $get_airport_list;
        }
        $output['data'] = $AirportArr;
        $output['status'] = true;
        $output['msg'] = 'Data Fetched Successfully...';
        return json_encode($output);
    }

    public function get_airport_location(Request $request)
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
        $airportdata   = $request->airportdata;
        $airport_id    = $airportdata['airport_id'];
        $going_to_name = $airportdata['going_to_name'];
        $TransferZones = TransferZones::where("airport_id", $airport_id)->where('zone_status', '!=', '1')->groupBy("zone_id")->get();
        $location = [];
        foreach ($TransferZones as $key => $TZ) {
            $get_zones = [];
            $Zones = Zones::where(["id" => $TZ['zone_id']]);
            if ($going_to_name != "") {
                $Zones = $Zones->where('zone_title', 'like', '%' . $going_to_name . '%');
            }
            $Zones = $Zones->get();

            foreach ($Zones as $zkey => $Z) {
                if ($Z != "") {
                    $get_zones['id']    = $Z['id'];
                    $get_zones['name']  = $Z['zone_title'];
                    $get_zones['price'] = $TZ['price'];
                    $get_zones['type']    = "zone";
                    $location[] = $get_zones;
                }
            }

            $Locations = Locations::where(['zone' => $TZ['zone_id']]);
            if ($going_to_name != "") {
                $Locations = $Locations->where('location_title', 'like', '%' . $going_to_name . '%');
            }

            $Locations = $Locations->get();
            // return $Locations;
            foreach ($Locations as $key => $L) {
                if ($L != "") {
                    $get_location          = [];
                    $get_location['id']    = $L['id'];
                    $get_location['name']  = $L['location_title'];
                    $get_location['price'] = $TZ['price'];
                    $get_location['type']  = "location";

                    $location[]            = $get_location;
                }
            }
        }
        $output['data']   = $location;
        $output['status'] = true;
        $output['msg']    = 'Data Fetched Successfully...';
        return json_encode($output);
    }



    //get_special_offers
    public function get_special_offers(Request $request)
    {
        $output           = [];
        $output['status'] = false;
        $validation       = Validator::make($request->all(), [
            'language' => 'required',
            'offset'   => 'required',
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

        $language_id = $request->language;
        $setLimit    = 9;
        $offset      = $request->offset;
        $limit       = $offset * $setLimit;
        $is_filter   = false;

        $get_special_offer_products = Product::select('products.*')->join("product_language", "product_language.product_id", '=', 'products.id')->join('product_categories', 'product_categories.product_id', '=', 'products.id')->where(['status' => 'Active', 'is_delete' => 0])->where("product_language.language_id", $language_id)->where('slug', '!=', '')->where('original_price', '>', 'selling_price');

        if (isset($request->country)) {
            $is_filter = true;

            $country = $request->country;
            if ($country > 0 && $country != '') {
                $get_special_offer_products      = $get_special_offer_products->where("country", $country);
            }
        }

        if (isset($request->city)) {
            $is_filter = true;


            $city = $request->city;
            if ($city > 0 && $city != '') {
                $get_special_offer_products      = $get_special_offer_products->where("city", $city);
            }
        }

        if (isset($request->name)) {
            $is_filter        = true;


            $name             = $request->name;
            if ($name != '') {
                $get_special_offer_products       = $get_special_offer_products->where("product_language.description", 'like', '%' . $name . '%');
            }
        }



        //Category Filter
        $CategoryProduct      = $get_special_offer_products;
        $output['categories'] = [];
        $CategoryProductArr   = [];

        if ($is_filter) {
            $CategoryProduct = $CategoryProduct->get();
            $categoryArr     = [];
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
                        $categoryArr[]        = $PC['category'];
                    }
                }
            }
        }
        $output['categories']  = $CategoryProductArr;


        if (isset($request->checkedCategory)) {


            $is_filter       = true;
            $checkedCategory = $request->checkedCategory;
            $get_special_offer_products         = $get_special_offer_products->where(function ($data) use ($checkedCategory) {
                foreach ($checkedCategory as $IBL => $case) {
                    if ($case == "true") {
                        $get_special_offer_products      = $data->orWhere("product_categories.category", $IBL);
                    }
                }
            });
        }

        if (isset($request->checkedSubCategory)) {


            $is_filter          = true;
            $checkedSubCategory = $request->checkedSubCategory;
            $get_special_offer_products              = $get_special_offer_products->where(function ($data) use ($checkedSubCategory) {
                foreach ($checkedSubCategory as $IBL => $case) {
                    if ($case == "true") {
                        $get_special_offer_products  = $data->orWhere("product_categories.sub_category", $IBL);
                    }
                }
            });
        }

        $limit       = $offset * $setLimit;
        //Category Filter End
        $get_special_offer_products_count = $get_special_offer_products->groupBy("product_categories.product_id")->get()->count();
        $get_special_offer_products       = $get_special_offer_products->orderBy('products.id', 'desc')->offset($limit)->groupBy("product_categories.product_id")->limit($setLimit)->get();


        $output['page_count']             = ceil($get_special_offer_products_count / $setLimit);

        if (!$get_special_offer_products->isEmpty()) {
            $data              = $this->getProductArr($get_special_offer_products, $language_id, $request->user_id, 50);
            $output['data']    = $data;
            $output['status']  = true;
            $output['message'] = "Special Offers List";
        }
        // Special offers



        return json_encode($output);
    }

    // Get City For Product
    public function get_city_for_product(Request $request)
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

        $country = $request->country;
        $type    = $request->type;

        $Product = Product::where(['status' => 'Active', 'is_delete' => 0, 'product_type' => $type])
            ->where('slug', '!=', '')
            ->where("country", $country)
            ->groupBy('city')
            ->orderBy('id', 'DESC')
            ->get();

        if (!$Product->isEmpty()) {
            foreach ($Product as $key => $value) {
                # code...
                $get_country = array();
                $get_country['value'] = $value['city'];
                $get_country['label'] = '';
                $Country     = City::where('id', $value['city'])->first();
                if ($Country) {
                    $get_country['label'] = $Country['name'] != '' ? $Country['name'] : '';
                }
                $data[] = $get_country;
            }
            $output['status'] = true;
            $output['data'] = $data;
        }

        $output['msg'] = 'Data Fetched Successfully...';
        return json_encode($output);
    }

    public function get_cart_count(Request $request)
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

        $cart_count = 0;
        $token      = $request->token;
        if ($request->user_id) {
            $user_id       = checkDecrypt($request->user_id);
            $cart_count    = AddToCart::where("user_id", $user_id)->orWhere('token', $request->token)->count();
        } else {
            if ($token  != "" && $token  != 'null') {
                $cart_count                  = AddToCart::where(["token" => $request->token])->count();
            } else {
                $cart_count  = 0;
            }
        }
        $data['cart_count'] = $cart_count;
        $output['status']   = true;
        $output['data']     = $data;
        $output['msg']      = 'Data Fetched Successfully...';
        return json_encode($output);
    }

    public function get_phone_code(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['msg'] = 'Not Data Found';
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
        $get_phonecodes = [];
        $languages = $request->language;

        $phonecode = Country::where("phonecode", ">", "0")
            ->groupBy('phonecode')
            ->orderBy("name", "ASC")
            ->get();
        foreach ($phonecode as $key => $value) {
            # code...
            $get_phonecode = [];
            $get_phonecode['id'] = $value['id'];
            $get_phonecode['sortname'] = $value['sortname'] != '' ? $value['sortname'] : '';
            $get_phonecode['name'] = $value['name'] != '' ?  $value['name'] : '';
            $get_phonecode['phonecode'] = $value['phonecode'] != '' ?  $value['phonecode'] : '';

            $get_phonecodes[] = $get_phonecode;
        }

        $output['msg'] = 'Phone Code List';
        $output['status'] = true;

        $output['data'] = $get_phonecodes;
        return json_encode($output);
    }

    public function home_search_product(Request $request)
    {
        $output           = [];
        $output['status'] = false;
        $output['msg']    = 'Not Data Found';
        $validation = Validator::make($request->all(), [
            'language' => 'required',
            // 'term'     => 'required',
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
        // return $request->term;
        $searchTerm   = $request->term;
        $language     = $request->language;
        $setLimit     = 12;
        $offset       = $request->offset;
        $limit        = $offset * $setLimit;

        $ProductCount = Product::select('products.*')->join("product_language", "product_language.product_id", '=', 'products.id')->where(['status' => 'Active', 'is_delete' => 0])->where("product_language.language_id", $language)
            ->where('slug', '!=', '');

        $Product = Product::select('products.*')->join("product_language", "product_language.product_id", '=', 'products.id')->where(['status' => 'Active', 'is_delete' => 0])->where("product_language.language_id", $language)
            ->where('slug', '!=', '');



        if (isset($request->term)) {
            if ($searchTerm != '') {
                $ProductCount = $ProductCount->where("product_language.description", 'like', '%' . $searchTerm . '%');
                $Product      = $Product->where("product_language.description", 'like', '%' . $searchTerm . '%');
            }
        }


        $ProductCount = $Product->orderBy('id', 'DESC')
            ->get();

        if (isset($request->offset)) {
            $Product = $Product->orderBy('id', 'DESC')->offset($limit)

                ->limit($setLimit);
        }
        $Product =  $Product->get();

        if (!$Product->isEmpty()) {
            $ProductArr           = $this->getProductArr($Product, $language, $request->user_id, 50);
            $ProductCount         = $ProductCount->count();
            $output['page_count'] = ceil($ProductCount / $setLimit);
            $output['data']       = $ProductArr;
            $output['status']     = true;
            $output['msg']        = 'Data Fetched Successfully...';
        }
        // $output['data'] = $get_phonecodes;
        return json_encode($output);
    }
}
