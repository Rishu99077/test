<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Countries;
use App\Models\Categories;
use App\Models\Categorydescriptions;
use App\Models\Testimonials;
use App\Models\Testimonialdescriptions;
use App\Models\ProductType;
use App\Models\Product;
use App\Models\Partners;
use App\Models\TopDestination;
use App\Models\Faqs;
use App\Models\Blogs;
use App\Models\Interests;
use App\Models\Blogcategory;
use App\Models\Settings;
use App\Models\Services;
use App\Models\Pagemeta;
use Illuminate\Support\Facades\Validator;
use App\Models\Teams;
use App\Models\Teamdescriptions;
use App\Models\MetaData;

class PagesController extends Controller
{
    // Home API
    public function home_page(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language' => 'required',
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

        $language_id   = $request->language;
        $data  = [];
        $data['facebook_icon']  = asset('uploads/whyChooseUs/facebook_img.png');
        $data['Instagram_icon'] = asset('uploads/whyChooseUs/instagram_img.png');
        $data['Twitter_icon']   = asset('uploads/whyChooseUs/Twitter_img.png');
        $data['Likedln_icon']   = asset('uploads/whyChooseUs/linkdlen_img.png');

        $MetaData =  MetaData::where(['language_id' => $language_id, 'value' => '1', 'type' => 'page'])->first();

        $data['meta_data'] =
            [
                "keyword" => "No keyword",
                "description" =>  "No Description",
                "title" =>  "Home"
            ];

        if ($MetaData != "") {
            $data['meta_data'] =
                [
                    "keyword" => $MetaData->keyword,
                    "description" =>  $MetaData->description,
                    "title" =>  'Home'
                ];
        }



        $WhyTitle = ['why_choose_us_title'];
        $WhyChooseTitle = getPagemeta($WhyTitle, $language_id, 1);

        $data['why_choose_us_heading'] = $WhyChooseTitle['why_choose_us_title'];


        $data['settings'] = [];
        $get_setting = Settings::whereNull('child_meta_title')
            ->orderby('sort', 'Asc')
            ->get();
        if (!$get_setting->isEmpty()) {
            foreach ($get_setting as $key => $value) {
                if ($value['meta_title'] == 'header_logo' || $value['meta_title'] == 'favicon' || $value['meta_title'] == 'footer_logo' || $value['meta_title'] == 'sample_file') {
                    if ($value['content'] != '') {
                        // admin/uploads/setting/
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



        $data['countries'] = [];
        $countries = Countries::where(['is_delete' => null])->get();
        foreach ($countries as $Ckey => $C) {
            if (file_exists(public_path() . "/uploads/Flags/" . $C['sortname'] . ".png")) {
                $get_country_arr = [];
                $get_country_arr['id'] = $C['id'];
                $get_country_arr['label'] = $C['name'];
                $data['countries'][] = $get_country_arr;
            }
        }



        $data['categories'] = [];
        $get_categories = Categories::whereNull('is_delete')->where('status', 'Active')->orderby('id', 'desc')->take(5)->get();
        if (!$get_categories->isEmpty()) {
            $categoryArr['title'] = '';
            $categoryArr['image'] = '';
            foreach ($get_categories as $key => $value) {
                $categoryArr = [];
                $get_category_description = Categorydescriptions::where(['category_id' => $value['id'], 'language_id' => $language_id])->get();
                $categoryArr  = getLanguageData('category_descriptions', $language_id, $value['id'], 'category_id');

                if ($get_category_description) {

                    $categoryArr['image'] = $value['image'] != '' ? asset('uploads/categories/' . $value['image']) : asset('uploads/placeholder/placeholder.png');
                    $categoryArr['slug'] = $value['slug'];
                }
                $data['categories'][] = $categoryArr;
            }
        }

        // Testimonials
        $data['testimonials'] = [];
        $get_testimonial      = Testimonials::whereNull('is_delete')->where('status', 'Active')->orderby('id', 'desc')->get();

        if (!$get_testimonial->isEmpty()) {
            $testimonialArr['usericon']    = "";
            $testimonialArr['username']    = "";
            $testimonialArr['content']     = "";
            $testimonialArr['usercity']    = "";
            foreach ($get_testimonial as $key => $testimonial) {
                $testimonialArr = [];
                $get_testimonial_description = Testimonialdescriptions::where(['testimonial_id' => $testimonial['id'], 'language_id' => $language_id])->first();
                if ($get_testimonial_description) {
                    $testimonialArr  = getLanguageData('testimonial_descriptions', $language_id, $testimonial['id'], 'testimonial_id');
                    $testimonialArr['usericon']   = $testimonial['image'] != '' ? asset('uploads/testimonials/' . $testimonial['image']) : asset('uploads/placeholder/placeholder.png');
                }
                $data['testimonials'][] = $testimonialArr;
            }
        }

        //////////////////////////////////

        $recommended_tours_data = ['recommended_tours_title', 'recommended_tours_category'];
        $data['recommended_tours'] = $recommended_tours = getPagemeta($recommended_tours_data, $language_id, 1);

        $recommended_tours_category_arr = [];
        if (isset($recommended_tours['recommended_tours_category']) && $recommended_tours['recommended_tours_category'] != "") {
            foreach ($recommended_tours as  $RKEY => $RT) {
                if ($RKEY == 'recommended_tours_category') {
                    $recommended_tours_category = explode(',', $RT);
                    foreach ($recommended_tours_category as $RTCkey => $RTC) {
                        $ProductType = ProductType::find($RTC);
                        $product_type_description  = getLanguageData('product_type_description', $language_id, $RTC, 'product_type_id');
                        if ($product_type_description) {
                            $Product =  Product::where(['status' => 'Active', 'is_approved' => 'Approved', 'is_delete' => null, 'recommended_tour' => 'yes'])->whereRaw("find_in_set(" . $RTC . ",product_type)")->take(8)->get();
                            if (count($Product) > 0) {
                                $recommended_tours_category_arr[$product_type_description['title']] = getProductArr($Product, $language_id, $request->user_id);
                            }
                        }
                    }
                }
            }
        } else {
            $Product = Product::where(['status' => 'Active', 'is_approved' => 'Approved', 'is_delete' => null, 'recommended_tour' => 'yes'])->take(8)->get();
            $recommended_tours_category_arr['recommended_tours'] = getProductArr($Product, $language_id, $request->user_id);
        }

        $data['recommended_tours']['recommended_tours_category'] = $recommended_tours_category_arr;


        ////////////////////////////////////////////////////////

        $adventure_awaits_data = ['adventure_awaits_title', 'adventure_awaits_category'];
        $data['adventure_awaits'] = $adventure_awaits = getPagemeta($adventure_awaits_data, $language_id, 1);

        $adventure_awaits_category_arr = [];
        if (isset($adventure_awaits['adventure_awaits_category']) && $adventure_awaits['adventure_awaits_category'] != "") {
            foreach ($adventure_awaits as  $AKEY => $AA) {
                if ($AKEY == 'adventure_awaits_category') {
                    $adventure_awaits_category = explode(',', $AA);
                    foreach ($adventure_awaits_category as $AACkey => $AAC) {
                        $ProductType = ProductType::find($AAC);
                        $product_type_description  = getLanguageData('product_type_description', $language_id, $AAC, 'product_type_id');
                        if ($product_type_description) {
                            $Product =  Product::where(['status' => 'Active', 'is_approved' => 'Approved', 'is_delete' => null, 'awaits_for_you' => 'yes'])->whereRaw("find_in_set(" . $AAC . ",product_type)")->take(8)->get();
                            if (count($Product) > 0) {
                                $adventure_awaits_category_arr[$product_type_description['title']] = getProductArr($Product, $language_id, $request->user_id);
                            }
                        }
                    }
                }
            }
        } else {
            $Product = Product::where(['status' => 'Active', 'is_approved' => 'Approved', 'is_delete' => null, 'awaits_for_you' => 'yes'])->take(8)->get();
            $adventure_awaits_category_arr['adventure_awaits_tours'] = getProductArr($Product, $language_id, $request->user_id);
        }
        $data['adventure_awaits']['adventure_awaits_category'] = $adventure_awaits_category_arr;

        ////////////////////////

        $cultural_attractions_data = ['cultural_attractions_title', 'cultural_attractions_category'];
        $data['cultural_attractions'] = $cultural_attractions = getPagemeta($cultural_attractions_data, $language_id, 1);

        $cultural_attractions_category_arr = [];
        if (isset($cultural_attractions['cultural_attractions_category']) && $cultural_attractions['cultural_attractions_category'] != "") {
            foreach ($cultural_attractions as  $CAKEY => $CA) {
                if ($CAKEY == 'cultural_attractions_category') {
                    $cultural_attractions_category = explode(',', $CA);
                    foreach ($cultural_attractions_category as $CACkey => $CAC) {
                        $ProductType = ProductType::find($CAC);
                        $product_type_description  = getLanguageData('product_type_description', $language_id, $CAC, 'product_type_id');
                        if ($product_type_description) {
                            $Product =  Product::where(['status' => 'Active', 'is_approved' => 'Approved', 'is_delete' => null, 'cultural_attractions' => 'yes'])->whereRaw("find_in_set(" . $CAC . ",product_type)")->take(8)->get();
                            if (count($Product) > 0) {
                                $cultural_attractions_category_arr[$product_type_description['title']] = getProductArr($Product, $language_id, $request->user_id);
                            }
                        }
                    }
                }
            }
        } else {
            $Product = Product::where(['status' => 'Active', 'is_approved' => 'Approved', 'is_delete' => null, 'cultural_attractions' => 'yes'])->take(8)->get();
            $cultural_attractions_category_arr['cultural_attractions_tours'] = getProductArr($Product, $language_id, $request->user_id);
        }
        $data['cultural_attractions']['cultural_attractions_category'] = $cultural_attractions_category_arr;


        //////////////////////////////



        $data['cultural_experiences'] = [];

        $Product = Product::where(['status' => 'Active', 'is_approved' => 'Approved', 'is_delete' => null, 'cultural_experiences' => 'yes'])->take(8)->get();
        $data['cultural_experiences'] = getProductArr($Product, $language_id, $request->user_id);



        /////////////////////////

        // Top Destination

        $TopDestination = TopDestination::where(['is_delete' => null, 'status' => 'Active'])->take(6)->get();
        $data['top_destination'] = [];
        foreach ($TopDestination as $TDkey => $TD) {
            $TopDestinationArr = [];
            $TopDestinationArr  = getLanguageData('top_destination_description', $language_id, $TD['id'], 'destination_id');

            $TopDestinationArr['image']   = $TD['image'] != '' ? asset('uploads/top_destination/' . $TD['image']) : asset('uploads/placeholder/placeholder.png');

            $data['top_destination'][] = $TopDestinationArr;
        }

        $data['middle_slider'] = [];
        // Middle Slider
        $middle_slider_data = ['slider_image' => '', 'middle_slider_title' => '', 'middle_slider_link' => '', 'middle_slider_desc' => '', 'middle_slider_cloud' => ''];
        $data['middle_slider']  = getPagemeta_multi($middle_slider_data, $language_id, 1, 'middle_slider_data', true);


        $data['banner_title'] = [];
        $banner_title_data  = Pagemeta::where(['page_id' => 1])->where('language_id', $language_id)->where(['meta_key' => 'banner_title', 'child_row' => 'banner_title'])->get();

        foreach ($banner_title_data as  $BTD) {
            $data['banner_title'][] = $BTD['meta_value'];
        }

        // getPagemeta_multi($banner_data, $language_id, 1, 'banner_title');






        $data['faq'] = [];
        $get_faqs  = Faqs::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
            ->paginate(config('adminconfig.records_per_page'));
        if (!empty($get_faqs)) {
            foreach ($get_faqs as $key => $value) {
                $row  = getLanguageData('faq_descriptions', $language_id, $value['id'], 'faq_id');
                $row['id']           = $value['id'];
                $row['status']       = $value['status'];
                $data['faq'][] = $row;
            }
        }



        $dataTitle = ['recommended_tours_title', 'top_destination_title', 'adventure_awaits_title', 'unforgettable_cultural_title', 'cultural_attractions_title', 'travel_experiences_title', 'travel_experiences_desc', 'our_partners_title', 'our_partners_desc', 'recommended_tours_category', 'adventure_awaits_category', 'cultural_attractions_category'];
        $data['title'] = getPagemeta($dataTitle, $language_id, 1);



        // Why Choose Us
        $why_choose_val = ['why_choose_image' => '', 'why_choose_title' => '', 'why_choose_desc' => ''];
        $data['why_choose_us'] = getPagemeta_multi($why_choose_val, $language_id, 1, 'why_choose_data', true);



        // Partners
        $data['partners'] = [];
        $get_partners = Partners::whereNull('is_delete')->where('status', 'Active')->orderby('id', 'desc')->get();
        if (!$get_partners->isEmpty()) {
            $partnerArr['image'] = "";
            $partnerArr['title'] = "";
            foreach ($get_partners as $key => $partners) {

                $partnerArr = getLanguageData('partner_descriptions', $language_id, $partners['id'], 'partner_id');

                $partnerArr['image'] = $partners['image'] != '' ? asset('uploads/partners/' . $partners['image']) : asset('uploads/placeholder/placeholder.png');
                $data['partners'][] = $partnerArr;
            }
        }



        $output['data'] = $data;
        $output['status'] = true;
        $output['status_code'] = 200;
        $output['message'] = "Data Fetch Successfully";
        return json_encode($output);
    }

    // About Us Page
    public function about_us(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";


        $validation = Validator::make($request->all(), [
            'language' => 'required',
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

        $language_id   = $request->language;

        $data = array('banner_title', 'banner_description', 'banner_image', 'our_story_title', 'our_story_image', 'our_story_description', 'satisfied_customers', 'satisfied_customers_count', 'years_of_experience', 'years_of_experience_count', 'destinations', 'destinations_count', 'why_choose_us_heading', 'travel_experiences_title', 'travel_experiences_desc', 'our_partners_title', 'our_partners_desc', 'unleash_your_adventure_title', 'unleash_your_adventure_desc', 'our_service_title', 'our_service_descriptions');


        $about_data = getPagemeta($data, $language_id, 2, true);

        $why_choose_us_val = ['why_choose_us_image' => '', 'why_choose_us_title' => '', 'why_choose_us_desc' => ''];
        $about_data['why_choose_us'] = getPagemeta_multi($why_choose_us_val, $language_id, 2, 'why_choose_us', true);

        $our_services_val = ['our_services_image' => '', 'our_services__additional_title' => ''];
        $about_data['our_service'] = getPagemeta_multi($our_services_val, $language_id, 2, 'our_service', true);

        $get_adventure_img_val = ['adventure_image' => ''];
        $about_data['get_adventure_image'] = getPagemeta_multi($get_adventure_img_val, $language_id, 2, 'adventure_images', true);


        $get_teams = Teams::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
            ->get();

        $about_data['Teams'] = array();
        if (!empty($get_teams)) {
            foreach ($get_teams as $key => $value) {
                $row                   = getLanguageData('team_descriptions', $language_id, $value['id'], 'team_id');
                $row['id']             = $value['id'];
                $row['status']         = $value['status'];
                $row['image']          = $value['image'] != '' ? asset('uploads/teams/' . $value['image']) : asset('uploads/placeholder/placeholder.png');
                $row['date']           = date("Y, M d", strtotime($value['created_at']));
                $about_data['Teams'][] = $row;
            }
        }

        $MetaData =  MetaData::where(['language_id' => $language_id, 'value' => '2', 'type' => 'page'])->first();
        $about_data['meta_data'] =
            [
                "keyword" => "No keyword",
                "description" =>  "No Description",
                "title" =>  "About Us"
            ];

        if ($MetaData != "") {
            $about_data['meta_data'] =
                [
                    "keyword" => $MetaData->keyword,
                    "description" =>  $MetaData->description,
                    "title" =>  'About Us'
                ];
        }



        $output['data'] = $about_data;
        $output['status'] = true;
        $output['status_code'] = 200;
        $output['message'] = "Data Fetch Successfully";
        return json_encode($output);
    }


    // Blog Page
    public function blog(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language' => 'required',
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

        $language_id   = $request->language;

        $data = array('banner_title', 'banner_description', 'banner_image', 'new_activity_heading');
        $blog_data = getPagemeta($data, $language_id, 6, true);

        $blogs = Blogs::orderBy('id', 'desc')->where(['status' => 'Active'])->where('slug', '!=', '')->whereNull('is_delete')->take(3)->get();



        $blog_data['latest'] = [];
        if (!empty($blogs)) {
            foreach ($blogs as $key => $B) {
                $row  = getLanguageData('blog_descriptions', $language_id, $B['id'], 'blog_id');
                $row['id']     = $B['id'];
                $row['status'] = $B['status'];
                $row['slug'] = $B['slug'];
                $row['image']  =  $B['image'] != "" ? asset('uploads/blogs/' . $B['image']) : asset('uploads/products/dummyicon.png');
                $blog_data['latest'][] = $row;
            }
        }


        $blogcategory = Blogcategory::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')->get();
        $blog_data['category'] = [];
        if (!empty($blogcategory)) {
            foreach ($blogcategory as $key => $BC) {
                $row                     = getLanguageData('blogcategory_descriptions', $language_id, $BC['id'], 'blogcategory_id');
                $row['id']               = $BC['id'];
                $row['status']           = $BC['status'];
                $row['image']            = $BC['image'] != "" ? asset('uploads/blogcategory/' . $BC['image']) : asset('uploads/products/dummyicon.png');
                $blog_data['category'][] = $row;
            }
        }


        $top_post =   Blogs::orderBy('id', 'desc')->where(['status' => 'Active'])->where('slug', '!=', '')->whereNull('is_delete')->where('top_post', 1)->get();

        $blog_data['top_post'] = [];
        if (!empty($top_post)) {
            foreach ($top_post as $TPkey => $TP) {
                $row  = getLanguageData('blog_descriptions', $language_id, $TP['id'], 'blog_id');
                $row['id']     = $TP['id'];
                $row['status'] = $TP['status'];
                $row['slug'] = $TP['slug'];
                $row['image']  =  $TP['image'] != "" ? asset('uploads/blogs/' . $TP['image']) : asset('uploads/products/dummyicon.png');
                $blog_data['top_post'][] = $row;
            }
        }
        $MetaData =  MetaData::where(['language_id' => $language_id, 'value' => '6', 'type' => 'page'])->first();
        $blog_data['meta_data'] =
            [
                "keyword" => "No keyword",
                "description" =>  "No Description",
                "title" =>  "Blog"
            ];

        if ($MetaData != "") {
            $blog_data['meta_data'] =
                [
                    "keyword" => $MetaData->keyword,
                    "description" =>  $MetaData->description,
                    "title" =>  'Blog'
                ];
        }




        $output['data'] = $blog_data;
        $output['status'] = true;
        $output['status_code'] = 200;
        $output['message'] = "Data Fetch Successfully";
        return json_encode($output);
    }


    // Guide Page
    public function guide(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";

        $validation = Validator::make($request->all(), [
            'language' => 'required',
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
        $language_id   = $request->language;
        $data = array('banner_title', 'banner_description', 'banner_image', 'top_destination_heading');
        $guide_data = getPagemeta($data, $language_id, 7, true);


        $MetaData =  MetaData::where(['language_id' => $language_id, 'value' => '7', 'type' => 'page'])->first();
        $guide_data['meta_data'] =
            [
                "keyword" => "No keyword",
                "description" =>  "No Description",
                "title" =>  "Guide"
            ];

        if ($MetaData != "") {
            $guide_data['meta_data'] =
                [
                    "keyword" => $MetaData->keyword,
                    "description" =>  $MetaData->description,
                    "title" =>  'Guide'
                ];
        }

        $output['data'] = $guide_data;
        $output['status'] = true;
        $output['status_code'] = 200;
        $output['message'] = "Data Fetch Successfully";
        return json_encode($output);
    }


    // Contact Us
    public function contact_us(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";

        $validation = Validator::make($request->all(), [
            'language' => 'required',
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
        $language_id   = $request->language;
        $data = array('banner_title', 'banner_description', 'banner_image', 'contact_info_title', 'contact_info_description');

        $get_setting = Settings::whereNull('child_meta_title')
            ->orderby('sort', 'Asc')
            ->get();
        if (!$get_setting->isEmpty()) {
            foreach ($get_setting as $key => $value) {
                if ($value['meta_title'] == 'header_logo' || $value['meta_title'] == 'favicon' || $value['meta_title'] == 'footer_logo' || $value['meta_title'] == 'sample_file') {
                    if ($value['content'] != '') {
                        $get_settings[$value['meta_title']] = url('assets/uploads/setting', $value['content']);
                    } else {
                        $get_settings[$value['meta_title']] = url('assets/img/logo.png');
                    }
                } else {
                    $get_settings[$value['meta_title']] = $value['content'];
                }
            }
            $contact_us_data['setting'] = $get_settings;
        }


        $contact_us_data['banner'] = getPagemeta($data, $language_id, 3, true);


        $MetaData =  MetaData::where(['language_id' => $language_id, 'value' => '3', 'type' => 'page'])->first();
        $contact_us_data['meta_data'] =
            [
                "keyword" => "No keyword",
                "description" =>  "No Description",
                "title" =>  "Contact Us"
            ];

        if ($MetaData != "") {
            $contact_us_data['meta_data'] =
                [
                    "keyword" => $MetaData->keyword,
                    "description" =>  $MetaData->description,
                    "title" =>  'Contact Us'
                ];
        }

        $output['data'] = $contact_us_data;
        $output['status'] = true;
        $output['status_code'] = 200;
        $output['message'] = "Data Fetch Successfully";
        return json_encode($output);
    }

    // Affiliate Page 

    public function affiliate(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";

        $validation = Validator::make($request->all(), [
            'language' => 'required',
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
        $language_id   = $request->language;
        $data =  array('main_title', 'main_description', 'main_image', 'work_heading', 'work_description', 'why_choose_heading');
        $affiliate_data = getPagemeta($data, $language_id, 9, true);

        $how_it_work_val = array('work_image' => '', 'work_title' => '', 'work_desc' => '');
        $affiliate_data['how_it_work'] = getPagemeta_multi($how_it_work_val, $language_id, 9, 'how_it_work', true);


        $why_choose_val = array('choose_affiliate_image' => '', 'choose_title' => '', 'choose_desc' => '');
        $affiliate_data['why_choose_affiliate'] = getPagemeta_multi($why_choose_val, $language_id, 9, 'why_choose_affiliate', true);


        $MetaData =  MetaData::where(['language_id' => $language_id, 'value' => '9', 'type' => 'page'])->first();
        $affiliate_data['meta_data'] =
            [
                "keyword" => "No keyword",
                "description" =>  "No Description",
                "title" =>  "Affilliate"
            ];

        if ($MetaData != "") {
            $affiliate_data['meta_data'] =
                [
                    "keyword" => $MetaData->keyword,
                    "description" =>  $MetaData->description,
                    "title" =>  'Affilliate'
                ];
        }


        $output['data'] = $affiliate_data;
        $output['status'] = true;
        $output['status_code'] = 200;
        $output['message'] = "Data Fetch Successfully";
        return json_encode($output);
    }

    // Privacy Policy Page
    public function privacy_policy(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";

        $validation = Validator::make($request->all(), [
            'language' => 'required',
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
        $language_id   = $request->language;
        $data =  array('privacy_policy_title', 'privacy_policy_description');
        $privacy_policy_data = getPagemeta($data, $language_id, 4, false);

        $MetaData =  MetaData::where(['language_id' => $language_id, 'value' => '4', 'type' => 'page'])->first();
        $privacy_policy_data['meta_data'] =
            [
                "keyword" => "No keyword",
                "description" =>  "No Description",
                "title" =>  "Privacy Policy"
            ];

        if ($MetaData != "") {
            $privacy_policy_data['meta_data'] =
                [
                    "keyword" => $MetaData->keyword,
                    "description" =>  $MetaData->description,
                    "title" =>  'Privacy Policy'
                ];
        }

        $output['data'] = $privacy_policy_data;
        $output['status'] = true;
        $output['status_code'] = 200;
        $output['message'] = "Data Fetch Successfully";
        return json_encode($output);
    }

    // Terms Condition Page
    public function terms_condition(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";

        $validation = Validator::make($request->all(), [
            'language' => 'required',
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
        $language_id   = $request->language;
        $data =  array('terms_and_conditions_title', 'terms_and_conditions_description');
        $terms_condition_data = getPagemeta($data, $language_id, 5, false);


        $MetaData =  MetaData::where(['language_id' => $language_id, 'value' => '5', 'type' => 'page'])->first();
        $terms_condition_data['meta_data'] =
            [
                "keyword" => "No keyword",
                "description" =>  "No Description",
                "title" =>  "Terms & Condition"
            ];

        if ($MetaData != "") {
            $terms_condition_data['meta_data'] =
                [
                    "keyword" => $MetaData->keyword,
                    "description" =>  $MetaData->description,
                    "title" =>  'Terms & Condition'
                ];
        }


        $output['data'] = $terms_condition_data;
        $output['status'] = true;
        $output['status_code'] = 200;
        $output['message'] = "Data Fetch Successfully";
        return json_encode($output);
    }


    // Partners Page
    public function partners(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";

        $validation = Validator::make($request->all(), [
            'language' => 'required',
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
        $language_id   = $request->language;
        $data = array('main_title', 'main_description', 'main_image', 'join_us_heading', 'customers_service_title', 'number_of_customers', 'engaged_partners_title', 'number_of_partners', 'footer_description', 'part_title', 'part_description', 'our_company_heading', 'unparalleled_partner_title', 'unparalleled_partner_main_description', 'unparalleled_partner_main_image', 'team_members_heading');
        $partner_data = getPagemeta($data, $language_id, 8, true);


        $join_us_val = array('joinus_logo' => '', 'joinus_title' => '', 'joinus_desc' => '');
        $partner_data['why_join_us'] = getPagemeta_multi($join_us_val, $language_id, 8, 'why_join_us', true);

        $our_company_val = ['our_company_logo' => '', 'our_company_title' => '', 'our_company_desc' => ''];
        $partner_data['our_company'] = getPagemeta_multi($our_company_val, $language_id, 8, 'our_company_data', true);

        // $join_us_image_val = array('joinus_image' => '');
        // $partner_data['why_join_us_images'] = getPagemeta_multi($join_us_image_val, $language_id, 8, 'why_join_us_images');

        $slider_image_val = array('slider_image' => '');
        $partner_data['slider_images'] = getPagemeta_multi($slider_image_val, $language_id, 8, 'slider_images', true);



        $MetaData =  MetaData::where(['language_id' => $language_id, 'value' => '8', 'type' => 'page'])->first();
        $partner_data['meta_data'] =
            [
                "keyword" => "No keyword",
                "description" =>  "No Description",
                "title" =>  "Partners"
            ];

        if ($MetaData != "") {
            $partner_data['meta_data'] =
                [
                    "keyword" => $MetaData->keyword,
                    "description" =>  $MetaData->description,
                    "title" =>  'Partners'
                ];
        }

        $output['data'] = $partner_data;
        $output['status'] = true;
        $output['status_code'] = 200;
        $output['message'] = "Data Fetch Successfully";
        return json_encode($output);
    }

    // Listing Page

    public function listing(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";

        $validation = Validator::make($request->all(), [
            'language' => 'required',
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
        $listing_data = [];
        $language_id   = $request->language;
        $data = ['listing_banner_title', 'listing_banner_description', 'listing_banner_image'];
        $listing_data['page'] = getPagemeta($data, $language_id, 10, true);
        $listing_data['filter'] = [];

        // Interest
        $get_interest = Interests::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
            ->get();
        $listing_data['filter']['interests'] = [];
        if (!empty($get_interest)) {
            foreach ($get_interest as $key => $value) {
                $row  = getLanguageData('interest_descriptions', $language_id, $value['id'], 'interest_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $listing_data['filter']['interests'][] = $row;
            }
        }

        // Categaory Array
        $get_category = Categories::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
            ->get();

        $listing_data['filter']['category'] = [];
        if (!empty($get_category)) {
            foreach ($get_category as $key => $value) {
                $row  = getLanguageData('category_descriptions', $language_id, $value['id'], 'category_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $listing_data['filter']['category'][] = $row;
            }
        }

        $listing_data['filter']['price']['min_price'] = 0;
        $listing_data['filter']['price']['max_price'] = 15000;


        $service = Services::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
            ->get();

        $listing_data['filter']['service'] = [];
        if (!empty($service)) {
            foreach ($service as $key => $value) {

                $row  = getLanguageData('service_descriptions', $language_id, $value['id'], 'service_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $listing_data['filter']['service'][] = $row;
            }
        }


        $MetaData =  MetaData::where(['language_id' => $language_id, 'value' => '10', 'type' => 'page'])->first();
        $listing_data['meta_data'] =
            [
                "keyword" => "No keyword",
                "description" =>  "No Description",
                "title" =>  "Listing"
            ];

        if ($MetaData != "") {
            $listing_data['meta_data'] =
                [
                    "keyword" => $MetaData->keyword,
                    "description" =>  $MetaData->description,
                    "title" =>  'Listing'
                ];
        }

        $output['data'] = $listing_data;
        $output['status'] = true;
        $output['status_code'] = 200;
        $output['message'] = "Data Fetch Successfully";
        return json_encode($output);
    }
}
