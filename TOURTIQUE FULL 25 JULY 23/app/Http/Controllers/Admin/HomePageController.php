<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliatePage;
use App\Models\AffiliatePageLanguage;
use App\Models\AffiliatePageSliderImage;
use App\Models\AffiliatePageWork;
use App\Models\AffiliatePageWorkLanguage;
use App\Models\AffiliatePageChoose;
use App\Models\AffiliatePageChooseLanguage;
use App\Models\PagesFaqs;
use App\Models\PagesFaqLanguage;
use App\Models\TopDestination;
use App\Models\Homepopup;
use App\Models\TopDestinationLanguage;
use App\Models\Language;
use App\Models\MetaGlobalLanguage;
use App\Models\Country;
use App\Models\City;
use App\Models\States;
use App\Models\ProductLanguage;
use App\Models\Product;
use App\Models\HomeCountLanguage;
use App\Models\HomeCount;
use App\Models\TopTenSeller;
use App\Models\TopTenSellerLanguage;
use App\Models\HomeSliderImages;
use App\Models\HomeDestinationOverview;
use App\Models\HomeDestinationOverviewLanguage;
use App\Models\BannerOverview;
use App\Models\BannerOverviewLanguage;
use App\Models\SideBanner;
use App\Models\ProfileBanner;
use App\Models\HomeCountry;

use App\Models\HomeZone;

use App\Models\PageSliders;
use App\Models\PageSlidersLanguage;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Str;

class HomePageController extends Controller
{
    ///Add HomePage
    public function add_home_page(Request $request, $id = ''){

        $common = [];
        Session::put('TopMenu', 'Pages');
        Session::put('SubMenu', 'Home Page');

        $common['title'] = translate('Home Page');
        $common['button'] = translate('Save');

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $get_country = Country::get();
        $get_city    = Product::select("*")->where(['product_type' => 'excursion', 'status' => 'Active'])->groupBy('city')
            ->get();
        $get_product = Product::select('products.*', 'product_language.description')
            ->leftJoin('product_language', 'products.id', 'product_language.product_id')
            ->where('product_language.language_id',$lang_id)
            ->where('status', 'Active')
            ->orderBy('id', 'desc')
            ->groupBy('products.id')
            ->get();

        $get_affiliate_page                = getTableColumn('affiliate_page');
        $get_affiliate_page_language       = '';
        $languages                         = Language::where(ConditionQuery())->get();
        $top_destinations                  = [];
        $get_affiliate_page_work_language  = [];
        $GPF                               = getTableColumn('top_destinations');
        $GHC                               = getTableColumn('home_count');
        $get_home_count_language           = [];
        $get_top_ten_language              = [];
        $get_topTen_seller                 = [];
        $get_top_destination_title         = [];
        $get_recommend_title               = [];
        $get_special_offer_title           = [];
        $get_adventure_title               = [];
        $get_main_banner_title             = [];
        $get_top_destination_language      = [];
        $get_aiport_transfer_text_langauge = [];
        $GBO                               = getTableColumn('banner_overview');

        $HDO                               = getTableColumn('home_destination_overview');
        $get_destination_overview          = [];
        $get_destination_overview_language = [];
        $get_destination_overview_title    = [];
        $get_banner_over_view              = [];
        $get_banner_over_view_language     = [];
        $get_home_country                  = [];
        $GCC                               = getTableColumn('home_country');

        // slider images
        $get_slider_images                 = [];
        $get_slider_images_language        = [];
        $HSI                               = getTableColumn('pages_slider');

        // middle slider 
        $get_middle_slider_images                 = [];
        $get_middle_slider_images_language        = [];
        $MSI                               = getTableColumn('pages_slider');

        $TTS                               = getTableColumn('top_ten_seller');

        $get_home_zone                     = [];
        $GHZ                               = getTableColumn('home_zones');

        $get_languages = Language::where(['status'=>'Active','is_delete' => 0])->get();


        if ($request->isMethod('post')) {
            // print_die($request->all());

            // echo "<pre>"; 
            // print_r($request->all());
            // echo "</pre>";

            $req_fields = [];
            // $req_fields['title.*']             = "required";
            // $req_fields['about_title.*']       = "required";
            // $req_fields['about_description.*'] = "required";
            // $req_fields['work_title.*']        = "required";
            // $req_fields['adventures_country.*']  = "required";

            $errormsg = [
                'title.*'             => translate('Title'),
                'about_title.*'       => translate('Title'),
                'about_description.*' => translate('Title'),
                'work_title.*'        => translate('Title'),
                'work_description.*'  => translate('Title'),
            ];

            $validation = Validator::make(
                $request->all(),
                $req_fields,
                [
                    'required' => 'The :attribute field is required.',
                ],
                $errormsg,
            );

            if ($validation->fails()) {
                return back()
                    ->withErrors($validation)
                    ->withInput();
            }

            $message = translate('Add Successfully');
            $status  = 'success';

            // print_die($request->all());


            // Search top destination
            if (!empty($request->airport_transfer_search_text)) {
                MetaGlobalLanguage::where('meta_parent', 'home_page')->where('meta_title', 'airport_transfer_search_text')->where('language_id',$lang_id)->delete();

                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('meta_global_language',['language_id'=>$value['id'],'meta_title'=>'airport_transfer_search_text','meta_parent' => 'home_page'],'row')) {   
                        $MetaGlobalLanguage = new MetaGlobalLanguage();
                        $MetaGlobalLanguage->meta_parent = 'home_page';
                        $MetaGlobalLanguage->meta_title  = 'airport_transfer_search_text';
                        $MetaGlobalLanguage->title       = isset($request->airport_transfer_search_text[$value['id']]) ? change_str($request->airport_transfer_search_text[$value['id']]) : $request->airport_transfer_search_text[$lang_id];
                        $MetaGlobalLanguage->language_id = $value['id'];
                        $MetaGlobalLanguage->status      = 'Active';
                        $MetaGlobalLanguage->save();
                    }
                }
            }
            // Search top destination End



            // Top Destination
            if (!empty($request->top_destination_title)) {
                MetaGlobalLanguage::where('meta_parent', 'top_destination')->where('language_id',$lang_id)->delete();
        
                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('meta_global_language',['language_id'=>$value['id'],'meta_title'=>'heading_title','meta_parent' => 'top_destination'],'row')) { 

                        $MetaGlobalLanguage = new MetaGlobalLanguage();
                        $MetaGlobalLanguage->meta_parent = 'top_destination';
                        $MetaGlobalLanguage->meta_title = 'heading_title';
                        $MetaGlobalLanguage->title = isset($request->top_destination_title[$value['id']]) ?  $request->top_destination_title[$value['id']] : $request->top_destination_title[$lang_id];
                        $MetaGlobalLanguage->language_id = $value['id'];
                        $MetaGlobalLanguage->status = 'Active';
                        $MetaGlobalLanguage->save();
                    }
                }
            }

            //Top Desctination Start
            if (count($request->top_destination_id) > 0) {
                TopDestination::whereNotIn('id', $request->top_destination_id)->delete();
                TopDestinationLanguage::where('language_id',$lang_id)->delete();

                foreach ($request->top_destination_id as $key => $value) {
                    if ($value != '') {
                        $TopDestination = TopDestination::where('id', $value)->first();
                    } else {
                        $TopDestination = new TopDestination();
                    }
                    $TopDestination->location = $request->location[$key];
                    $TopDestination->country = $request->country[$key];
                    $TopDestination->state = $request->state[$key];
                    $TopDestination->city = $request->city[$key];
                    $TopDestination->link = $request->link[$key];
                    if ($request->hasFile('top_destination_image')) {
                        if (isset($request->top_destination_image[$key])) {
                            $files = $request->file('top_destination_image')[$key];
                            $random_no = uniqid();
                            $img = $files;
                            $ext = $files->getClientOriginalExtension();
                            $new_name = $random_no . time() . '.' . $ext;
                            $destinationPath = public_path('uploads/home_page/top_destinations');
                            $img->move($destinationPath, $new_name);
                            $TopDestination->image = $new_name;
                        }
                    }
                    $TopDestination->save();
                    if (isset($request->destination_title)) {
                        foreach ($request->destination_title as $destination_key => $destination_value) {
                            # code...
                            $TopDestinationLanguage = new TopDestinationLanguage();
                            $TopDestinationLanguage->title = $destination_value[$key];
                            $TopDestinationLanguage->language_id = $destination_key;
                            $TopDestinationLanguage->top_destination_id = $TopDestination->id;
                            $TopDestinationLanguage->save();
                        }
                    }
                }
            }
            //Top Desctination End

            //Home Counts Start
            if ($request->home_counts_id) {
                if (count($request->home_counts_id) > 0) {
                    foreach ($request->home_counts_id as $Home_count_key => $count_value) {
                        if ($count_value != '') {
                            $HomeCount = HomeCount::find($count_value);
                            HomeCountLanguage::where('home_count_id', $count_value)->where('language_id',$lang_id)->delete();
                        } else {
                            $HomeCount = new HomeCount();
                        }
                        if (isset($request->home_counts_image[$Home_count_key])) {
                            $files = $request->file('home_counts_image')[$Home_count_key];
                            $random_no = uniqid();
                            $img = $files;
                            $ext = $files->getClientOriginalExtension();
                            $new_name = $random_no . time() . '.' . $ext;
                            $destinationPath = public_path('uploads/home_page/home_counts');
                            $img->move($destinationPath, $new_name);
                            $HomeCount->image = $new_name;
                        }
                        $HomeCount->number = $request->home_counts_number[$Home_count_key];
                        $HomeCount->status = 'Active';
                        $HomeCount->save();
                        if ($request->home_counts_title) {
                            foreach ($request->home_counts_title as $title_key => $title_value) {
                                $HomeCountLanguage = new HomeCountLanguage();
                                $HomeCountLanguage->home_count_id = $HomeCount->id;
                                $HomeCountLanguage->title = $title_value[$Home_count_key];
                                $HomeCountLanguage->language_id = $title_key;
                                $HomeCountLanguage->save();
                            }
                        }
                    }
                }
            }
            //Home Counts End
            
            //Top TEn SEller
            if ($request->top_ten_id) {
                if (count($request->top_ten_id) > 0) {
                    TopTenSeller::whereNotIn('id', $request->top_ten_id)->delete();
                    TopTenSellerLanguage::whereIn('top_ten_seller_id', $request->top_ten_id)->where('language_id',$lang_id)->delete();
                    foreach ($request->top_ten_id as $top_ten_key => $top_ten_value) {
                        if ($top_ten_value != '') {
                            $TopTenSeller = TopTenSeller::find($top_ten_value);
                        } else {
                            $TopTenSeller = new TopTenSeller();
                        }
                        $TopTenSeller->sort_order = $request->top_ten_sort_order[$top_ten_key];
                        $TopTenSeller->product_id = $request->top_ten_products[$top_ten_key];
                        if ($request->hasFile('top_ten_image')) {
                            if (isset($request->top_ten_image[$top_ten_key])) {
                                $files = $request->file('top_ten_image')[$top_ten_key];
                                $random_no = uniqid();
                                $img = $files;
                                $ext = $files->getClientOriginalExtension();
                                $new_name = $random_no . time() . '.' . $ext;
                                $destinationPath = public_path('uploads/home_page/top_ten_seller');
                                $img->move($destinationPath, $new_name);
                                $TopTenSeller->image = $new_name;
                            }
                        }
                        $TopTenSeller->save();
                        if ($request->top_ten_title) {
                            foreach ($request->top_ten_title as $title_key => $title_value) {
                                $TopTenSellerLanguage = new TopTenSellerLanguage();
                                $TopTenSellerLanguage->top_ten_seller_id = $TopTenSeller->id;
                                $TopTenSellerLanguage->language_id = $title_key;
                                $TopTenSellerLanguage->title = $title_value[$top_ten_key];
                                $TopTenSellerLanguage->save();
                            }
                        }
                    }
                }
            }
            //Top TEn SEller

            // Top 10 
            if (!empty($request->top_ten_main_title)) {
                MetaGlobalLanguage::where('meta_parent', 'top_10_uae_heading')->where('language_id',$lang_id)->delete();
                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('meta_global_language',['language_id'=>$value['id'],'meta_title'=>'heading_title','meta_parent' => 'top_10_uae_heading'],'row')) { 

                        $MetaGlobalLanguage = new MetaGlobalLanguage();
                    
                        $MetaGlobalLanguage->meta_parent = 'top_10_uae_heading';
                        $MetaGlobalLanguage->meta_title  = 'heading_title';
                        $MetaGlobalLanguage->title       = isset($request->top_ten_main_title[$value['id']]) ?  $request->top_ten_main_title[$value['id']] : $request->top_ten_main_title[$lang_id];
                        $MetaGlobalLanguage->language_id = $value['id'];
                        $MetaGlobalLanguage->status      = 'Active';
                        $MetaGlobalLanguage->save();
                    }
                }
            }
            // Top 10
            
            // luxuary_treats_heading
            if (!empty($request->luxuary_treats_heading)) {
                MetaGlobalLanguage::where('meta_parent', 'luxuary_treats_heading')->where('language_id',$lang_id)->delete();


                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('meta_global_language',['language_id'=>$value['id'],'meta_title'=>'heading_title','meta_parent' => 'luxuary_treats_heading'],'row')) {    
                
                        $MetaGlobalLanguage = new MetaGlobalLanguage();
                    
                        $MetaGlobalLanguage->meta_parent = 'luxuary_treats_heading';
                        $MetaGlobalLanguage->meta_title  = 'heading_title';
                        $MetaGlobalLanguage->title       = isset($request->luxuary_treats_heading[$value['id']]) ?  $request->luxuary_treats_heading[$value['id']] : $request->luxuary_treats_heading[$lang_id];
                        $MetaGlobalLanguage->language_id = $value['id'];
                        $MetaGlobalLanguage->status      = 'Active';
                        $MetaGlobalLanguage->save();
                    }
                }
            }
            // Tluxuary_treats_heading

            // recently_main_heading
            if (!empty($request->recently_main_heading)) {
                MetaGlobalLanguage::where('meta_parent', 'recently_main_heading')->where('language_id',$lang_id)->delete();
               

                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('meta_global_language',['language_id'=>$value['id'],'meta_title'=>'heading_title','meta_parent' => 'recently_main_heading'],'row')) {      
                        $MetaGlobalLanguage = new MetaGlobalLanguage();
                        $MetaGlobalLanguage->meta_parent = 'recently_main_heading';
                        $MetaGlobalLanguage->meta_title  = 'heading_title';
                        $MetaGlobalLanguage->title       = isset($request->recently_main_heading[$value['id']]) ?  $request->recently_main_heading[$value['id']] : $request->recently_main_heading[$lang_id];
                        $MetaGlobalLanguage->language_id = $value['id'];
                        $MetaGlobalLanguage->status      = 'Active';
                        $MetaGlobalLanguage->save();
                    }
                }
            }
            // recently_main_heading

            // Recommended Tours
            if (!empty($request->recommend_product_title)) {
                MetaGlobalLanguage::where('meta_parent', 'recommended_tours')->where('language_id',$lang_id)->delete();
                
                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('meta_global_language',['language_id'=>$value['id'],'meta_title'=>'heading_title','meta_parent' => 'recommended_tours'],'row')) {      
                        $MetaGlobalLanguage = new MetaGlobalLanguage();
                   
                        $MetaGlobalLanguage->meta_parent = 'recommended_tours';
                        $MetaGlobalLanguage->meta_title = 'heading_title';
                        $MetaGlobalLanguage->title = isset($request->recommend_product_title[$value['id']]) ?  $request->recommend_product_title[$value['id']] : $request->recommend_product_title[$lang_id];
                        $MetaGlobalLanguage->content = implode(',', $request->recom_country);
                        $MetaGlobalLanguage->language_id = $value['id'];
                        $MetaGlobalLanguage->status = 'Active';
                        $MetaGlobalLanguage->save();
                    }
                }
            }
            // Recommended Tours End

            //World Of Adventures
            if (!empty($request->adventures_awaits)) {
                MetaGlobalLanguage::where('meta_parent', 'world_of_adventure')->where('language_id',$lang_id)->delete();
                

                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('meta_global_language',['language_id'=>$value['id'],'meta_title'=>'heading_title','meta_parent' => 'world_of_adventure'],'row')) {    
                        $MetaGlobalLanguage = new MetaGlobalLanguage();
                    
                        $MetaGlobalLanguage->meta_parent = 'world_of_adventure';
                        $MetaGlobalLanguage->meta_title  = 'heading_title';
                        $MetaGlobalLanguage->title       = isset($request->adventures_awaits[$value['id']]) ?  $request->adventures_awaits[$value['id']] : $request->adventures_awaits[$lang_id];
                        $MetaGlobalLanguage->content     = implode(',', $request->adventures_country);
                        $MetaGlobalLanguage->language_id = $value['id'];
                        $MetaGlobalLanguage->status      = 'Active';
                        $MetaGlobalLanguage->save();
                    }
                }
            }
            //World Of AdventuresEnd



            //Main Banner
            // if (!empty($request->main_banner_title)) {
            //     MetaGlobalLanguage::where('meta_parent', 'home_main_banner')->where('language_id',$lang_id)->delete();
               
            //     foreach ($get_languages as $key => $value) {
            //         if (!getDataFromDB('meta_global_language',['language_id'=>$value['id'],'meta_title'=>'home_main_banner_heading_title','meta_parent' => 'home_main_banner'],'row')) {    
            //             $MetaGlobalLanguage = new MetaGlobalLanguage();
                    
            //             $MetaGlobalLanguage->meta_title  = 'home_main_banner_heading_title';
            //             $MetaGlobalLanguage->meta_parent = 'home_main_banner';
            //             $MetaGlobalLanguage->title       = isset($request->main_banner_title[$value['id']]) ?  $request->main_banner_title[$value['id']] : $request->main_banner_title[$lang_id];
            //             $MetaGlobalLanguage->content     = isset($request->main_banner_text[$value['id']]) ?  $request->main_banner_text[$value['id']] : $request->main_banner_text[$lang_id];
            //             $MetaGlobalLanguage->language_id = $value['id'];
            //             $MetaGlobalLanguage->status      = 'Active';
            //             $MetaGlobalLanguage->save();
            //         }
            //     }
            // }
            //Main Banner




            //Main Banner Muliple File
            $SliderImages = HomeSliderImages::orderBy('id', 'desc')->get();
            if (isset($request->image_id)) {
                foreach ($SliderImages as $key => $image_delete) {
                    if (!in_array($image_delete['id'], $request->image_id)) {
                        HomeSliderImages::where('type', 'home_main_banner')->where('id', $image_delete['id'])->delete();
                    }
                }
            } else {
                if ($request->id != '') {
                    foreach ($SliderImages as $key => $image_delete) {
                        HomeSliderImages::where('type', 'home_main_banner')->where('id', $image_delete['id'])->delete();
                    }
                }
            }

            ///Main Banner Muliple File
            if ($request->hasFile('files')) {
                $files = $request->file('files');
                foreach ($files as $fileKey => $image) {
                    $HomeSliderImages                  = new HomeSliderImages();
                    $random_no                         = Str::random(5);
                    $HomeSliderImages['slider_images'] = $newImage = time() . $random_no . '.' . $image->getClientOriginalExtension();
                    $destinationPath                   = public_path('uploads/home_page/slider_images');
                    $imgFile                           = Image::make($image->path());
                    $height                            = $imgFile->height();
                    $width                             = $imgFile->width();

                    if ($width > 1000) {
                        $imgFile->resize(1800, 1000, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                    if ($height > 800) {
                        $imgFile->resize(1800, 1000, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                    $destinationPath = public_path('uploads/home_page/main_banner');
                    $imgFile->save($destinationPath . '/' . $newImage);
                    $HomeSliderImages->type    = "home_main_banner";
                    $HomeSliderImages->save();
                }
            }


            // Top Destination
            if (!empty($request->destination_overview_title)) {
                MetaGlobalLanguage::where('meta_parent', 'destination_overview')->where('language_id',$lang_id)->delete();

                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('meta_global_language',['language_id'=>$value['id'],'meta_title'=>'heading_title','meta_parent' => 'destination_overview'],'row')) {     
                        $MetaGlobalLanguage = new MetaGlobalLanguage();
                    
                        $MetaGlobalLanguage->meta_parent = 'destination_overview';
                        $MetaGlobalLanguage->meta_title = 'heading_title';
                        $MetaGlobalLanguage->title = isset($request->destination_overview_title[$value['id']]) ?  $request->destination_overview_title[$value['id']] : $request->destination_overview_title[$lang_id];
                        $MetaGlobalLanguage->language_id = $value['id'];
                        $MetaGlobalLanguage->status = 'Active';
                        $MetaGlobalLanguage->save();
                    }
                }
            }

            //Home Counts Start
            if ($request->overview_id) {
                if (count($request->overview_id) > 0) {

                    $get_homeDestination = HomeDestinationOverview::get();
                    foreach ($get_homeDestination as $key => $get_overview_delete) {
                        if (!in_array($get_overview_delete['id'], $request->overview_id)) {
                            HomeDestinationOverview::where('id', $get_overview_delete['id'])->delete();
                        }
                    }
                    HomeDestinationOverviewLanguage::where('language_id',$lang_id)->delete();
                    foreach ($request->overview_id as $Overview_key => $overview_value) {

                        if ($overview_value != '') {
                            $HomeDestinationOverview = HomeDestinationOverview::find($overview_value);
                        } else {
                            $HomeDestinationOverview = new HomeDestinationOverview();
                        }
                        if (isset($request->overview_image[$Overview_key])) {
                            $files     = $request->file('overview_image')[$Overview_key];
                            $random_no = uniqid();
                            $img       = $files;
                            $ext       = $files->getClientOriginalExtension();
                            $imgFile   = Image::make($files->path());

                            $height = $imgFile->height();
                            $width  = $imgFile->width();
                            // 255 × 355 px
                            
                            // if ($width > 255 ) {
                                $imgFile->resize(255, 355, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                            // }

                            // if ($height > 355) {
                                $imgFile->resize($width, 355, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                            // }


                            $new_name = $random_no . time() . '.' . $ext;
                            $destinationPath = public_path('uploads/home_page/destination_overview');
                            $imgFile->save($destinationPath. '/' . $new_name);
                            $HomeDestinationOverview->image = $new_name;
                        }

                        $HomeDestinationOverview->link     = $request->overview_link[$Overview_key];
                        $HomeDestinationOverview->location = $request->overview_location[$Overview_key];

                        $HomeDestinationOverview->save();

                        if ($request->overview_title) {

                            foreach ($get_languages as $key => $value) {
                                if (!getDataFromDB('home_destination_overview_language',['language_id'=>$value['id'],'destination_overview_id'=>$HomeDestinationOverview->id],'row')) {    

                                    $HomeDestinationOverviewLanguage = new HomeDestinationOverviewLanguage();
                                    $HomeDestinationOverviewLanguage->destination_overview_id = $HomeDestinationOverview->id;
                                    $HomeDestinationOverviewLanguage->title = isset($request->overview_title[$value['id']][$Overview_key]) ?  $request->overview_title[$value['id']][$Overview_key] : $request->overview_title[$lang_id][$Overview_key];

                                    $HomeDestinationOverviewLanguage->language_id = $value['id'];
                                    $HomeDestinationOverviewLanguage->save();
                                }
                            }
                        }
                    }
                }
            }
            //Home Counts End



            // Special Offer Tours
            /* if (!empty($request->special_offer_title)) {
                MetaGlobalLanguage::where('meta_parent', 'special_offers_tours')->delete();
                foreach ($request->special_offer_title as $key => $value) {
                    $MetaGlobalLanguage = new MetaGlobalLanguage();
                    if ($value != '') {
                        $MetaGlobalLanguage->meta_parent = 'special_offers_tours';
                        $MetaGlobalLanguage->meta_title  = 'special_offer_heading_title';
                        $MetaGlobalLanguage->title       = $request->special_offer_title[$key];
                        $MetaGlobalLanguage->content     = implode(',', $request->special_offer_county);
                        $MetaGlobalLanguage->language_id = $key;
                        $MetaGlobalLanguage->status      = 'Active';
                        $MetaGlobalLanguage->save();
                    }
                }
            }*/
            // Special Offer End

            // Search top destination
            // if (!empty($request->top_destination_city)) {
            //     MetaGlobalLanguage::where('meta_parent', 'search_top_destination')->delete();

            //     $MetaGlobalLanguage = new MetaGlobalLanguage();

            //     $MetaGlobalLanguage->meta_parent = 'search_top_destination';
            //     $MetaGlobalLanguage->meta_title = 'search';
            //     $MetaGlobalLanguage->content = implode(',', $request->top_destination_city);
            //     $MetaGlobalLanguage->language_id = $key;
            //     $MetaGlobalLanguage->status = 'Active';
            //     $MetaGlobalLanguage->save();
            // }
            // Search top destination End


            //Banner OverViwe
            if (isset(($request->over_view_id))) {
                if (!empty($request->over_view_id)) {
                    $BannerOverviewdelete = BannerOverview::whereNotIn('id', $request->over_view_id)->where('page', 'home_page')->delete();
                    BannerOverviewLanguage::where('page', 'home_page')->where('langauge_id',$lang_id)->delete();
                    foreach ($request->over_view_id as $over_key => $over_value) {
                        if ($over_value != '') {
                            $BannerOverview       = BannerOverview::find($over_value);
                        } else {
                            $BannerOverview       = new BannerOverview();
                        }
                        $BannerOverview->page     = "home_page";
                        if ($request->hasFile('banner_overview_image')) {
                            if (isset($request->banner_overview_image[$over_key])) {
                                $files = $request->file('banner_overview_image')[$over_key];
                                $random_no       = uniqid();
                                $img             = $files;
                                $ext             = $files->getClientOriginalExtension();
                                $new_name        = $random_no . time() . '.' . $ext;
                                $destinationPath = public_path('uploads/home_page/banner_overview');
                                $img->move($destinationPath, $new_name);
                                $BannerOverview->image = $new_name;
                            }
                        }
                        $BannerOverview->save();

                        foreach ($request->over_view_title as $over_view_title_key => $over_view_title_value) {
                            $BannerOverviewLanguage                  = new BannerOverviewLanguage();
                            $BannerOverviewLanguage->overview_id     = $BannerOverview->id;
                            $BannerOverviewLanguage->page            = "home_page";
                            $BannerOverviewLanguage->langauge_id     = $over_view_title_key;
                            $BannerOverviewLanguage->title           = $over_view_title_value[$over_key];
                            $BannerOverviewLanguage->save();
                        }
                    }
                }
            }


            //Main Banner Muliple File
            $MiddleSliderImages = HomeSliderImages::orderBy('id', 'desc')->get();
            if (isset($request->middle_image_id)) {
                foreach ($MiddleSliderImages as $key => $image_delete) {
                    if (!in_array($image_delete['id'], $request->middle_image_id)) {
                        HomeSliderImages::where('type', 'home_middle_slider')->where('id', $image_delete['id'])->delete();
                    }
                }
            }

            ///Main Banner Muliple File
            if ($request->hasFile('slider_images')) {
                $files = $request->slider_images;
                // print_die($request->slider_images);
                foreach ($request->slider_images as $fileKey => $image) {
                    $HomeSliderImages                  = new HomeSliderImages();
                    $random_no                         = Str::random(5);
                    $HomeSliderImages['slider_images'] = $newImage = time() . $random_no . '.' . $image->getClientOriginalExtension();
                    $destinationPath                   = public_path('uploads/home_page/slider_images');
                    $imgFile                           = Image::make($image->path());
                    $height                            = $imgFile->height();
                    $width                             = $imgFile->width();

                    // if ($width > 1000) {
                    //     $imgFile->resize(1800, 1000, function ($constraint) {
                    //         $constraint->aspectRatio();
                    //     });
                    // }
                    // if ($height > 800) {
                    //     $imgFile->resize(1800, 1000, function ($constraint) {
                    //         $constraint->aspectRatio();
                    //     });
                    // }
                    $destinationPath = public_path('uploads/home_page/slider_images');
                    $imgFile->save($destinationPath . '/' . $newImage);
                    $HomeSliderImages->type    = "home_middle_slider";
                    $HomeSliderImages->save();
                }
            }


            // Slider Images
            $get_pageSlider = PageSliders::where(['page_id' => 1, 'page' => 'home_page_slider'])->get();
            foreach ($get_pageSlider as $key => $val) {
                if (!in_array($val['id'], $request->slider_img_id)) {
                    PageSliders::where('id', $val['id'])->delete();
                }
            }

            if (!empty($request->slider_title)) {
                if ($request->slider_title) {

                    PageSlidersLanguage::where(['page_id' => 1, 'page' => 'home_page_slider'])->where('language_id',$lang_id)->delete();

                    foreach ($request->slider_img_id as $key => $over_value) {

                        if ($over_value != '') {
                            $PageSliders       = PageSliders::find($over_value);
                        } else {
                            $PageSliders       = new PageSliders();
                        }

                        $PageSliders->page_id  = 1;
                        $PageSliders->page     = "home_page_slider";

                        if ($request->hasFile('slider_image')) {
                            if (isset($request->slider_image[$key])) {
                                $files = $request->file('slider_image')[$key];
                                $random_no       = uniqid();
                                $img             = $files;
                                $ext             = $files->getClientOriginalExtension();
                                $new_name        = $random_no . time() . '.' . $ext;
                                $destinationPath = public_path('uploads/slider_images');
                                $img->move($destinationPath, $new_name);
                                $PageSliders->image = $new_name;
                            }
                        }

                        if ($request->hasFile('logo_main')) {
                            if (isset($request->logo_main[$key])) {
                                $files = $request->file('logo_main')[$key];
                                $random_no       = uniqid();
                                $img             = $files;
                                $ext             = $files->getClientOriginalExtension();
                                $new_name        = $random_no . time() . '.' . $ext;
                                $destinationPath = public_path('uploads/slider_images/main_logo');
                                $img->move($destinationPath, $new_name);
                                $PageSliders->main_logo = $new_name;
                            }
                        }

                        $PageSliders->save();
                        $page_slider_id = $PageSliders->id;

                        foreach ($request->slider_title as $slideKey => $SL) {
                            if ($SL[$key] != '') {
                                $PageSlidersLanguage = new PageSlidersLanguage();
                                $PageSlidersLanguage['page_id']            = 1;
                                $PageSlidersLanguage['pages_slider_id']    = $page_slider_id;
                                $PageSlidersLanguage['page']               = 'home_page_slider';
                                $PageSlidersLanguage['language_id']        = $slideKey;
                                $PageSlidersLanguage['title']              = $SL[$key];
                                $PageSlidersLanguage['description']        = $request->slider_description[$slideKey][$key];
                                $PageSlidersLanguage->save();
                            }
                        }
                    }
                }
            }


            // Middle Slider Images
            $get_pagemiddleSlider = PageSliders::where(['page_id' => 1, 'page' => 'home_page_middle_slider'])->get();
            foreach ($get_pagemiddleSlider as $key => $val) {
                if (!in_array($val['id'], $request->middle_slider_id)) {
                    PageSliders::where('id', $val['id'])->delete();
                }
            }

            // if (!empty($request->middle_slider_title)) {
            //     if ($request->middle_slider_title) {

                    // PageSlidersLanguage::where(['page_id' => 1, 'page' => 'home_page_middle_slider'])->where('language_id',$lang_id)->delete();

                    foreach ($request->middle_slider_id as $key => $mid_value) {

                        if ($mid_value != '') {
                            $PageSliders       = PageSliders::find($mid_value);
                        } else {
                            $PageSliders       = new PageSliders();
                        }

                        $PageSliders->page_id  = 1;
                        $PageSliders->page     = "home_page_middle_slider";

                        if ($request->hasFile('middle_slider_image')) {
                            if (isset($request->middle_slider_image[$key])) {
                                $files = $request->file('middle_slider_image')[$key];
                                $random_no       = uniqid();
                                $img             = $files;
                                $ext             = $files->getClientOriginalExtension();
                                $new_name        = $random_no . time() . '.' . $ext;
                                $destinationPath = public_path('uploads/slider_images');
                                $img->move($destinationPath, $new_name);
                                $PageSliders->image = $new_name;
                            }
                        }

                        $PageSliders->save();
                        $page_slider_id = $PageSliders->id;

                        // foreach ($request->middle_slider_title as $slideKey => $SL) {
                        //     if ($SL[$key] != '') {
                        //         $PageSlidersLanguage = new PageSlidersLanguage();
                        //         $PageSlidersLanguage['page_id']            = 1;
                        //         $PageSlidersLanguage['pages_slider_id']    = $page_slider_id;
                        //         $PageSlidersLanguage['page']               = 'home_page_middle_slider';
                        //         $PageSlidersLanguage['language_id']        = $slideKey;
                        //         $PageSlidersLanguage['title']              = $SL[$key];
                        //         $PageSlidersLanguage['description']        = $request->middle_slider_description[$slideKey][$key];
                        //         $PageSlidersLanguage->save();
                        //     }
                        // }
                    }
            //     }
            // }


            //Home ZONES Start
            if ($request->zone_id) {
                HomeZone::where('home_page_id', 1)->delete();
                HomeCountry::where('home_page_id', 1)->delete();
                foreach ($request->zone_id as $key => $z_value) {
                    $HomeZone = new HomeZone();
                    $HomeZone->home_page_id    = 1;
                    $HomeZone->number          = $request->sort_order[$key];
                    $HomeZone->zone_name       = $request->zone_name[$key];
                    $HomeZone->save();

                    $zones_id = $HomeZone->id;

                    if (isset($request->search_country[$key])) {
                        foreach ($request->search_country[$key] as $country_key => $con_value) {

                            $HomeCountry = new HomeCountry();
                            $HomeCountry->home_page_id      = 1;
                            $HomeCountry->home_zone_id      = $zones_id;
                            $HomeCountry->search_country    = $request->search_country[$key][$country_key];
                            $HomeCountry->search_state      = $request->search_state[$key][$country_key];
                            $HomeCountry->search_city       = $request->search_city[$key][$country_key];

                            if (isset($request->city_image[$key][$country_key])) {
                                $files = $request->file('city_image')[$key][$country_key];
                                $random_no = uniqid();
                                $img = $files;
                                $ext = $files->getClientOriginalExtension();
                                $new_name = $random_no . time() . '.' . $ext;
                                $destinationPath = public_path('uploads/home_page/zone');
                                $img->move($destinationPath, $new_name);
                                $HomeCountry->image = $new_name;
                            } elseif (isset($request->city_image_value[$key][$country_key])) {
                                $HomeCountry->image = $request->city_image_value[$key][$country_key];
                            }

                            $HomeCountry->save();
                        }
                    }
                }
            }
            // die();
            //Home ZONES End


            return redirect()
                ->route('admin.home_page.edit', encrypt(1))
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'No Record Found']);
            }
            $id = checkDecrypt($id);
            // echo $id;
            // die;
            $common['title']  = 'Edit Home Page';
            $common['button'] = 'Update';

            $get_top_destination_title      = MetaGlobalLanguage::where('meta_title', 'heading_title')
                ->where('meta_parent', 'top_destination')
                ->get();
            $get_aiport_transfer_text_langauge = MetaGlobalLanguage::where('meta_parent', 'home_page')
                ->where('meta_title', 'airport_transfer_search_text')
                ->get();
            $get_recommend_title = MetaGlobalLanguage::where('meta_title', 'heading_title')
                ->where('meta_parent', 'recommended_tours')
                ->get();
            $get_top_10_uae_heading = MetaGlobalLanguage::where('meta_title', 'heading_title')
                ->where('meta_parent', 'top_10_uae_heading')
                ->get();

            $get_luxuary_treats_heading = MetaGlobalLanguage::where('meta_title', 'heading_title')
                ->where('meta_parent', 'luxuary_treats_heading')
                ->get();
            $get_recently_main_heading = MetaGlobalLanguage::where('meta_title', 'heading_title')
                ->where('meta_parent', 'recently_main_heading')
                ->get();

            $get_special_offer_title = MetaGlobalLanguage::where('meta_title', 'special_offer_heading_title')
                ->where('meta_parent', 'special_offers_tours')
                ->get();
            $get_adventure_title = MetaGlobalLanguage::where('meta_title', 'heading_title')
                ->where('meta_parent', 'world_of_adventure')
                ->get();
            $get_main_banner_title = MetaGlobalLanguage::where('meta_title', 'home_main_banner_heading_title')
                ->where('meta_parent', 'home_main_banner')
                ->get();
            $get_destination_overview_title = MetaGlobalLanguage::where('meta_title', 'heading_title')
                ->where('meta_parent', 'destination_overview')
                ->get();
            $get_banner_over_view          = BannerOverview::where('page', 'home_page')->get();
            $get_banner_over_view_language = BannerOverviewLanguage::where('page', 'home_page')->get();


            $get_home_count           = HomeCount::get();
            $get_home_count_language  = HomeCountLanguage::get();
            $get_top_ten_language     = TopTenSellerLanguage::get();
            $top_destinations         = TopDestination::orderBy('id', 'desc')->get();
            $get_topTen_seller        = TopTenSeller::orderBy('id', 'desc')->get();
            // $get_middle_slider_images = HomeSliderImages::where('type', 'home_middle_slider')->orderBy('id', 'desc')->get();

            $get_slider_images          = PageSliders::where(['page_id' => 1, 'page' => 'home_page_slider', 'status' => 'Active'])->get();
            $get_slider_images_language = PageSlidersLanguage::where(['page_id' => 1, 'page' => 'home_page_slider'])->get();

            $get_middle_slider_images          = PageSliders::where(['page_id' => 1, 'page' => 'home_page_middle_slider', 'status' => 'Active'])->get();
            $get_middle_slider_images_language = PageSlidersLanguage::where(['page_id' => 1, 'page' => 'home_page_middle_slider'])->get();

            $get_destination_overview = HomeDestinationOverview::get();
            $get_destination_overview_language = HomeDestinationOverviewLanguage::get();

            $get_home_country      = HomeCountry::where('home_page_id', 1)->get();
            $get_home_zone         = HomeZone::where('home_page_id', 1)->get();


            if (!$get_affiliate_page) {
                return back()->withErrors(['error' => 'Something went wrong']);
            }
        }
        return view('admin.home_page.add_home_page', compact('common', 'get_country', 'get_topTen_seller', 'get_product', 'get_top_ten_language', 'get_home_count_language', 'top_destinations', 'languages', 'TTS', 'GPF', 'GHC', 'get_recommend_title', 'get_special_offer_title', 'get_adventure_title', 'get_main_banner_title', 'get_top_destination_title', 'get_top_destination_language', 'get_home_count', 'get_slider_images', 'HSI', 'get_slider_images_language', 'get_destination_overview', 'get_destination_overview_language', 'HDO', 'get_destination_overview_title', 'get_banner_over_view', 'get_banner_over_view_language', 'GBO', 'get_middle_slider_images', 'get_middle_slider_images_language', 'MSI', 'get_city', 'get_home_country', 'GCC', 'get_home_zone', 'GHZ', 'get_aiport_transfer_text_langauge','get_top_10_uae_heading','get_luxuary_treats_heading','get_recently_main_heading','lang_id'));
    }


    public function addSideBanner(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Contents");
        Session::put("SubMenu", "Side Banner");

        $common['title']      = translate("Add Side Banner");
        $common['button']     = translate("Save");

        $get_sidebanner       = getTableColumn('side_banner');



        if ($request->isMethod('post')) {
            $req_fields             = array();
            $req_fields['name.*']   = "required";

            $errormsg = [
                "name.*" => translate("Title"),
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
                return back()->withErrors($validation)->withInput();
            }


            if ($request->id != '') {
                $message = translate('Update Successfully');
                $status = 'success';
                $SideBanner = SideBanner::find($request->id);
            } else {
                $message = translate('Add Successfully');
                $status = 'success';
                $SideBanner = new SideBanner();
            }


            if ($request->hasFile('image')) {
                $files = $request->file('image');
                $random_no = Str::random(5);
                $newImage = time() . $random_no . '.' . $files->getClientOriginalExtension();
                $destinationPath = public_path('uploads/side_banner');
                $imgFile = Image::make($files->path());
                $height = $imgFile->height();
                $width = $imgFile->width();
                if ($width > 600) {
                    $imgFile->resize(792, 450, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                if ($height > 600) {
                    $imgFile->resize(792, 450, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                $destinationPath = public_path('uploads/side_banner');
                $imgFile->save($destinationPath . '/' . $newImage);
                $SideBanner['image'] = $newImage;
            }


            if ($request->hasFile('special_side_banner')) {
                $files = $request->file('special_side_banner');
                $random_no = Str::random(5);
                $newImage = time() . $random_no . '.' . $files->getClientOriginalExtension();
                $destinationPath = public_path('uploads/side_banner');
                $imgFile = Image::make($files->path());
                // $height = $imgFile->height();
                // $width = $imgFile->width();
                // if ($width > 600) {
                //     $imgFile->resize(792, 450, function ($constraint) {
                //         $constraint->aspectRatio();
                //     });
                // }
                // if ($height > 600) {
                //     $imgFile->resize(792, 450, function ($constraint) {
                //         $constraint->aspectRatio();
                //     });
                // }
                $destinationPath = public_path('uploads/side_banner');
                $imgFile->save($destinationPath . '/' . $newImage);
                $SideBanner['special_side_banner'] = $newImage;
            }

            $SideBanner['status']              = isset($request->status) ? 'Active' : 'Deactive';
            $SideBanner->save();

            return redirect()->route('admin.side_banner.add')->withErrors([$status => $message]);
        }

        $get_sidebanner    = SideBanner::orderBy('id', 'desc')->first();

        return view('admin.side_banner.add_side_banner', compact('common', 'get_sidebanner'));
    }


    public function home_popup(Request $request)
    {
        $common = array();
        Session::put("TopMenu", "Settings");
        Session::put("SubMenu", "Home Popup");
        $common['title']      = translate("Home Popup");
        $common['button']     = translate("Save");
        $languages                             = Language::where(['is_delete' => 0, 'status' => 'Active'])->get();

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];


        $Homepopup = Homepopup::where('language_id',$lang_id)->first();
        if (!$Homepopup) {
            $Homepopup       = getTableColumn('homepopup');
        }
        $HomepopupLanguage = Homepopup::where('language_id',$lang_id)->get();
        if ($request->isMethod('post')) {
            Homepopup::where('language_id',$lang_id)->delete();
            // if ($request->pro_popup_image_dlt == '') {
            $popup_image = $request->pro_popup_image_dlt;
            // }
            if ($request->hasFile('pro_popup_image')) {
                $files = $request->file('pro_popup_image');
                $random_no = Str::random(5);
                $newImage = time() . $random_no . '.' . $files->getClientOriginalExtension();
                $destinationPath = public_path('uploads/product_images');
                $imgFile = Image::make($files->path());
                $height = $imgFile->height();
                $width = $imgFile->width();
                $imgFile->resize(350, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $destinationPath = public_path('uploads/product_images');
                $imgFile->save($destinationPath . '/' . $newImage);
                $popup_image = $newImage;
            }
            // if ($request->pro_popup_thumnail_image_dlt == '') {
            $thumbnail_image = $request->pro_popup_thumnail_image_dlt;
            // }
            if ($request->hasFile('pro_popup_thumnail_image')) {
                $files           = $request->file('pro_popup_thumnail_image');
                $random_no       = Str::random(5);
                $newImage        = time() . $random_no . '.' . $files->getClientOriginalExtension();
                $destinationPath = public_path('uploads/product_images/popup_image');
                $imgFile         = Image::make($files->path());
                $height          = $imgFile->height();
                $width           = $imgFile->width();
                $imgFile->resize(350, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $destinationPath = public_path('uploads/product_images/popup_image');
                $imgFile->save($destinationPath . '/' . $newImage);
                $thumbnail_image = $newImage;
            }
            // if ($request->pro_popup_video_dlt == '') {
            $video = $request->pro_popup_video_dlt;
            // }
            // Popup Video
            if ($request->hasFile('pro_popup_video')) {
                $files = $request->file('pro_popup_video');
                $random_no       = uniqid();
                $img             = $files;
                $ext             = $files->getClientOriginalExtension();
                $new_name        = $random_no . time() . '.' . $ext;
                $destinationPath =  public_path('uploads/product_images/popup_image');
                $img->move($destinationPath, $new_name);
                $video = $new_name;
            }
            foreach ($request->title as $key => $value) {
                $Homepopup = new Homepopup();
                // Product POp up
                $Homepopup['thumbnail_image'] = $thumbnail_image;
                $Homepopup['video']           = $video;
                $Homepopup['popup_image']     = $popup_image;
                $Homepopup['popup_link']      = $request->pro_popup_link;
                $Homepopup['link']            = $request->redirection_link;
                $Homepopup['title']           = $value;
                $Homepopup['description']     = $request->description[$key];
                $Homepopup['language_id']     = $key;
                $Homepopup['popup_status']    = isset($request->popup_status) ? "Active" : "Deactive";
                $Homepopup->save();
            }
            $message = translate('Add Successfully');
            $status = 'success';
            return redirect()
                ->route('admin.home_popup')
                ->withErrors([$status => $message]);
        }

        
        return view('admin.settings.home_popup', compact('common', 'HomepopupLanguage', 'Homepopup', 'languages','lang_id'));
    }


    // Profile Banner
    public function addProfileBanner(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Contents");
        Session::put("SubMenu", "My Profile Banner");

        $common['title']      = translate("Add Profile Banner");
        $common['button']     = translate("Save");

        $get_profilebanner       = getTableColumn('profile_banner');

        if ($request->isMethod('post')) {
            $req_fields             = array();
            $req_fields['name.*']   = "required";

            $errormsg = [
                "name.*" => translate("Title"),
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
                return back()->withErrors($validation)->withInput();
            }


            if ($request->id != '') {
                $message = translate('Update Successfully');
                $status = 'success';
                $ProfileBanner = ProfileBanner::find($request->id);
            } else {
                $message = translate('Add Successfully');
                $status = 'success';
                $ProfileBanner = new ProfileBanner();
            }


            if ($request->hasFile('image')) {
                $files = $request->file('image');
                $random_no = Str::random(5);
                $newImage = time() . $random_no . '.' . $files->getClientOriginalExtension();
                $destinationPath = public_path('uploads/profile_banner');
                $imgFile = Image::make($files->path());
                $height = $imgFile->height();
                $width = $imgFile->width();
                if ($width > 600) {
                    $imgFile->resize(792, 450, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                if ($height > 600) {
                    $imgFile->resize(792, 450, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                $destinationPath = public_path('uploads/profile_banner');
                $imgFile->save($destinationPath . '/' . $newImage);
                $ProfileBanner['image'] = $newImage;
            }

            $ProfileBanner['status']              = isset($request->status) ? 'Active' : 'Deactive';
            $ProfileBanner->save();

            return redirect()->route('admin.profile_banner.add')->withErrors([$status => $message]);
        }

        $get_profilebanner    = ProfileBanner::orderBy('id', 'desc')->first();

        return view('admin.side_banner.add_profile_banner', compact('common', 'get_profilebanner'));
    }

}
