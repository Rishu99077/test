<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductSetting;
use App\Models\ProductLanguage;
use App\Models\MetaGlobalLanguage;
use App\Models\{MetaPageSetting, MetaPageSettingLanguage};
use App\Models\{Insider, InsiderLanguage};

use App\Models\Language;
use App\Models\CityGuide;
use App\Models\CityGuideLanguage;

use App\Models\PageSliders;
use App\Models\PageSlidersLanguage;

use App\Models\CityGuideHighlight;
use App\Models\CityGuideHighlightLanguage;

use App\Models\CityGuidefaq;
use App\Models\CityGuidefaqLanguage;

use Illuminate\Support\Str;

use Carbon\Carbon;

class CityGuideController extends Controller
{


    //Get City Guide Page Details
    public function get_city_guide_details(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'Data Not Found';
        $validation = Validator::make($request->all(), [
            'slug' => 'required',
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
        $language_id = $request->language;
        $get_city_guide_data = [];
        $get_city_guides = CityGuide::where(['slug' => $request->slug, 'status' => 'Active'])->first();
        if ($get_city_guides) {
            $get_city_guide_data['id']                = $get_city_guides['id'];
            $get_city_guide_data['slug']              = $get_city_guides['slug'];
            $get_city_guide_data['video_url']         = $get_city_guides['video_url'];
            $get_city_guide_data['google_address']    = $get_city_guides['google_address'];
            $get_city_guide_data['address_lattitude'] = $get_city_guides['address_lattitude'];
            $get_city_guide_data['address_longitude'] = $get_city_guides['address_longitude'];
            $get_city_guide_data['link']              = $get_city_guides['link'];
            $get_city_guide_data['button_link']       = $get_city_guides['button_link'];
            $get_city_guide_data['wather_details']    = getWeatherDetails($get_city_guides['google_address']);
            $get_city_guide_data['start_position']    = date("H");

            $get_city_guide_data['title']       = '';
            $get_city_guide_data['description'] = '';
            $get_city_guide_data['about_heading'] = '';
            $get_city_guide_data['about_description'] = '';
            $get_city_guide_data['faq_heading'] = '';

            $get_city_guide_data['image']           = $get_city_guides['image']             != '' ? url('uploads/MediaPage', $get_city_guides['image']) : asset('uploads/placeholder/placeholder.png');
            $get_city_guide_data['bottom_image']    = $get_city_guides['bottom_image']      != '' ? url('uploads/MediaPage', $get_city_guides['bottom_image']) : asset('uploads/placeholder/placeholder.png');
            $get_city_guide_data['side_banner']     = $get_city_guides['side_banner'] != '' ? url('uploads/MediaPage', $get_city_guides['side_banner']) : asset('uploads/placeholder/placeholder.png');
            $get_city_guide_data['video_thumbnail'] = $get_city_guides['video_thumbnail']   != '' ? url('uploads/MediaPage', $get_city_guides['video_thumbnail']) : asset('uploads/placeholder/placeholder.png');
            $get_city_guide_language = CityGuideLanguage::where('city_guide_id', $get_city_guides->id)
                ->where('language_id', $request->language)
                ->first();
            if ($get_city_guide_language) {
                $get_city_guide_data['title']             = $get_city_guide_language['title']                != '' ? $get_city_guide_language['title'] : '';
                $get_city_guide_data['description']       = $get_city_guide_language['description']          != '' ? $get_city_guide_language['description'] : '';
                $get_city_guide_data['button_text']       = $get_city_guide_language['button_text']          != '' ? $get_city_guide_language['button_text'] : '';
                $get_city_guide_data['about_heading']     = $get_city_guide_language['location_heading']     != '' ? $get_city_guide_language['location_heading'] : '';
                $get_city_guide_data['about_description'] = $get_city_guide_language['location_description'] != '' ? $get_city_guide_language['location_description'] : '';

                $get_city_guide_data['faq_heading'] = $get_city_guide_language['faq_heading'] != '' ? $get_city_guide_language['faq_heading'] : '';
            }

            // Slider images
            $get_city_guide_data['slider_images'] = [];
            $get_sliders = PageSliders::where(['page' => 'city_guide', 'page_id' => $get_city_guides['id']])
                ->get();
            if (!$get_sliders->isEmpty()) {
                foreach ($get_sliders as $key => $slider_value) {
                    $get_slider          = [];
                    $get_slider['id']    = $slider_value['id'];
                    $get_slider['image'] = $slider_value['image'] != '' ? url('uploads/slider_images', $slider_value['image']) : asset('uploads/placeholder/placeholder.png');
                    $get_slider_language = PageSlidersLanguage::where('pages_slider_id', $slider_value['id'])
                        ->where('language_id', $request->language)
                        ->where('page', 'city_guide')
                        ->first();
                    $get_slider['title'] = '';
                    $get_slider['description'] = '';
                    if ($get_slider_language) {
                        $get_slider['title']       = $get_slider_language['title'] != '' ? $get_slider_language['title'] : '';
                        $get_slider['description'] = $get_slider_language['description'] != '' ? $get_slider_language['description'] : '';
                    }
                    $get_city_guide_data['slider_images'][] = $get_slider;
                }
            }
            // Slider images End


            // Highlights
            $get_city_guide_data['highlights'] = [];
            $get_city_guide = CityGuideHighlight::where('city_guide_id', $get_city_guides->id)
                ->get();
            if (!$get_city_guide->isEmpty()) {
                foreach ($get_city_guide as $high_key => $high_value) {
                    $get_city_guide_arr = [];
                    $get_city_guide_arr['id']               = $high_value['id'];
                    $get_city_guide_arr['title'] = '';
                    $get_city_guide_arr['description'] = '';

                    $get_city_guide_language = CityGuideHighlightLanguage::where('city_guide_id', $get_city_guides->id)
                        ->where('highlight_id', $high_value['id'])
                        ->where('language_id', $request->language)
                        ->first();
                    if ($get_city_guide_language) {
                        $get_city_guide_arr['title'] = $get_city_guide_language['title'] != '' ? $get_city_guide_language['title'] : '';
                        $get_city_guide_arr['description'] = $get_city_guide_language['description'] != '' ? $get_city_guide_language['description'] : '';
                    }
                    $get_city_guide_data['highlights'][] = $get_city_guide_arr;
                }
            }


            // Faqs
            $get_city_guide_data['faqs'] = [];
            $get_city_guide_faq = CityGuidefaq::where('city_guide_id', $get_city_guides->id)
                // ->orderBy('id', 'desc')
                ->get();
            if (!$get_city_guide_faq->isEmpty()) {
                foreach ($get_city_guide_faq as $high_key => $faq_value) {
                    $get_city_guide_faq_arr = [];
                    $get_city_guide_faq_arr['id']               = $faq_value['id'];
                    $get_city_guide_faq_arr['question'] = '';
                    $get_city_guide_faq_arr['answer'] = '';

                    $get_city_guide_language = CityGuidefaqLanguage::where('city_guide_id', $get_city_guides->id)
                        ->where('faq_id', $faq_value['id'])
                        ->where('language_id', $request->language)
                        ->first();
                    if ($get_city_guide_language) {
                        $get_city_guide_faq_arr['question'] = $get_city_guide_language['title'] != '' ? $get_city_guide_language['title'] : '';
                        $get_city_guide_faq_arr['answer'] = $get_city_guide_language['description'] != '' ? $get_city_guide_language['description'] : '';
                    }
                    $get_city_guide_data['faqs'][] = $get_city_guide_faq_arr;
                }
            }
            
            // Related
            $get_city_guide_data['citycitycity'] = $get_city_guides['city'];
            $get_city_guide_data['related_top_activities'] = [];
            if ($get_city_guides['city']) {
                $related_top_activities = ProductSetting::select('product_settings.product_id', 'products.*')
                    ->leftJoin('products', 'products.id', 'product_settings.product_id')
                    ->where('product_settings.meta_title', 'related_top_rated_activity')
                    ->where('status', 'Active')
                    ->where('products.city', $get_city_guides['city'])
                    ->orderBy('products.id', 'desc')
                    ->groupBy('product_id')
                    ->get();
                if (!$related_top_activities->isEmpty()) {
                    foreach ($related_top_activities as $key => $value) {
                        # code...
                        $get_realated = [];
                        $get_city_guide_data['related_top_activities'] =  $this->getProductArr($related_top_activities, $language_id, $request->user_id, 50);
                    }
                }
            }
            $output['status'] = true;
            $output['message'] = 'City Guide Page Details';
        }

        $output['data'] = $get_city_guide_data;
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
                $title            = $value_productLang->description;
                $main_description  = $value_productLang->main_description;
                $short_description = $value_productLang->short_description;
                if ($value_productLang->short_description != '') {

                    // $get_product['short_description']  = $value_productLang->short_description;

                }
            }
            $city                            = getAllInfo('cities', ['id' => $value['city']], 'name');
            $get_product['id']               = $value['id'];
            $get_product['image']            = $value['image']                  != '' ? asset('public/uploads/product_images/' . $value['image']) : asset('public/assets/img/no_image.jpeg');
            $get_product['name']              = short_description_limit($title, 35);
            $get_product['short_description'] = short_description_limit($short_description, $short_dec_limit);
            $get_product['main_description']  = Str::limit($main_description, 60);
            $get_product['city']             = $city;
            $get_product['slug']             = $value['slug'];
            $get_product['total_sold']       = $value['how_many_are_sold']     !== '' ? $value['how_many_are_sold'] : 0;
            $get_product['per_value']        = $value['per_value'];
            $get_product['image_text']       = $value['image_text'] ?? null;
            $get_product['price']            = $value['original_price'] ?? 0;
            $get_product['selling_price']    = $value['selling_price'] ?? 0;
            $get_product['product_type']     = $value['product_type'];
            $get_product['ratings']          = get_rating($value['id']);
            $get_product['button']           = $value['product_bookable_type'] === 'bookable' ? 'Book Now' : 'On Request';
            $get_product['price_html']       = get_price_front($value['id'], $user_id, $value['product_type']);
            $get_product['link']             = '';
            if ($value['product_type'] == 'excursion') {
                $get_product['link'] = 'activities-detail/' . $value['slug'];
            } elseif ($value['product_type'] == 'yacht') {
                $get_product['link'] = 'yacht-charts-details/' . $value['slug'];
            } elseif ($value['product_type'] == 'lodge') {
                $get_product['link'] = 'lodge-detail/' . $value['slug'];
            } elseif ($value['product_type'] == 'limousine') {
                $get_product['link'] = 'limousine-detail/' . $value['slug'];
            }
            $get_product['ratings']          = get_rating($value['id']);
            $approx = '';
            if ($value['approx'] == 1) {
                $approx = '(Approx)';
            }
            $duration = explode('-', $value['duration']);
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
            $duration                                       = $dura . $approx;
            $get_product['duration']              = $duration;
            $get_product['boat_maximum_capacity'] = $value['boat_maximum_capacity'];
            $get_product['minimum_booking']       = $value['minimum_booking'];
            $get_arr[]                            = $get_product;
        }
        return $get_arr;
    }
}
