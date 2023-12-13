<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarDetails;
use App\Models\Language;
use App\Models\PageSliders;

use App\Models\{HotelPage,HotelPageLanguage};
use App\Models\{HotelHighlight,HotelHighlightLanguage};
use App\Models\{HotelAmenity,HotelAmenityLanguage};
use App\Models\{HotelFaq,HotelFaqLanguage,HotelFaqHeading,HotelFAQS};

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class HotelController extends Controller
{
  //Get hotel list
  public function get_hotel_list(Request $request)
  {
      $output = [];
      $output['status'] = false;
      $output['message'] = 'Data Not Found';
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
      $get_hotel_list = HotelPage::where(['status' => 'Active'])->orderBy('id', 'desc')->get();
      if (!$get_hotel_list->isEmpty()) {

          foreach ($get_hotel_list as $key => $value) {
              $get_hotel_data = array();
              $get_hotel_data['id']                   = $value['slug'];
              $get_hotel_data['slug']                 = $value['slug'];
              $get_hotel_data['address']              = $value['address'];
              $get_hotel_data['address_longitude']    = $value['address_longitude'];
              $get_hotel_data['address_lattitude']    = $value['address_lattitude'];
              $get_hotel_data['video_url']            = $value['video_url'];
              $get_hotel_data['title_icon']           = $value['title_icon'] != '' ? url('uploads/MediaPage', $value['title_icon']) : asset('uploads/placeholder/placeholder.png');
              $get_hotel_data['side_image']           = $value['side_image'] != '' ? url('uploads/MediaPage', $value['side_image']) : asset('uploads/placeholder/placeholder.png');
              $get_hotel_data['video_thumbnail']      = $value['video_thumbnail'] != '' ? url('uploads/MediaPage', $value['video_thumbnail']) : asset('uploads/placeholder/placeholder.png');

              $get_hotel_data['title'] = '';
              $get_hotel_data['hotel_bars'] = [];
              $get_hotel_data['hotel_view'] = [];
              $get_hotel_data['hotel_room'] = [];
              $get_hotel_language = HotelPageLanguage::where('hotel_id', $value['id'])
                  ->where('language_id', $request->language)
                  ->first();
              if ($get_hotel_language) {

                  $get_hotel_data['title']      = $get_hotel_language['title'] != '' ? $get_hotel_language['title'] : '';

                  $get_hotel_data['hotel_bars']['title'] = $get_hotel_language['hotel_bars'] != '' ? $get_hotel_language['hotel_bars'] : '';
                  $get_hotel_data['hotel_bars']['image'] = $value['hotel_bar_icon'] != '' ? url('uploads/MediaPage', $value['hotel_bar_icon']) : asset('uploads/placeholder/placeholder.png');

                  $get_hotel_data['hotel_view']['title'] = $get_hotel_language['hotel_view'] != '' ? $get_hotel_language['hotel_view'] : '';
                  $get_hotel_data['hotel_view']['image'] = $value['hotel_view_icon'] != '' ? url('uploads/MediaPage', $value['hotel_view_icon']) : asset('uploads/placeholder/placeholder.png');

                  $get_hotel_data['hotel_room']['title'] = $get_hotel_language['hotel_room'] != '' ? $get_hotel_language['hotel_room'] : '';
                  $get_hotel_data['hotel_room']['image'] = $value['hotel_room_icon'] != '' ? url('uploads/MediaPage', $value['hotel_room_icon']) : asset('uploads/placeholder/placeholder.png');

              }

              // Highlight
              $get_hotel_data['Highlight'] = [];
              $get_hotel_highlight = HotelHighlight::where('hotel_id', $value['id'])->get();
              if (!$get_hotel_highlight->isEmpty()) {
                $get_hotel_highlight_language = HotelHighlightLanguage::where('hotel_id', $value['id'])
                 ->where('language_id', $request->language)->get();
                
                  foreach ($get_hotel_highlight_language as $hotel_key => $hotel_value) {
                      $get_hotel_highlight_arr = [];
                      $get_hotel_highlight_arr['title'] = $hotel_value['title'];
                      $get_hotel_highlight_arr['description'] = $hotel_value['description'];
                      $get_hotel_data['Highlight'][] = $get_hotel_highlight_arr;
                  }
              }


              // Amenities
              $get_hotel_data['Amenities'] = [];
              $get_hotel_amenities = HotelAmenity::where('hotel_id', $value['id'])->get();
              if (!$get_hotel_amenities->isEmpty()) {
              $get_hotel_amenities_language = HotelAmenityLanguage::where('hotel_id', $value['id'])
              ->where('language_id', $request->language)->get();
              
                  foreach ($get_hotel_amenities_language as $key => $amenity_value) {
                      $get_hotel_amenity_arr = [];
                      $get_hotel_amenity_arr['title'] = $amenity_value['title'];
                      $get_hotel_data['Amenities'][] = $get_hotel_amenity_arr;
                  }
              }

              // Slider images
              $get_hotel_data['slider_images'] = [];
              $get_sliders = PageSliders::where('page', 'hotel_slider_img')
                  ->get();
              if (!$get_sliders->isEmpty()) {
                  foreach ($get_sliders as $key => $slider_value) {
                      $get_slider          = [];
                      $get_slider['id']    = $slider_value['id'];
                      $get_slider['image'] = $slider_value['image'] != '' ? url('uploads/slider_images', $slider_value['image']) : asset('uploads/placeholder/placeholder.png');
                      $get_hotel_data['slider_images'][] = $get_slider;
                  }
              }
              // Slider images End

              // FAQS
              $get_hotel_data['FAQs'] = [];
              $get_Faqs = HotelFaq::where(['hotel_id'=>$value['id']])->get();

              foreach ($get_Faqs as $hzkey => $HZ) {
                  $get_head_arr = [];
                  $HotelFaqHeading =  HotelFaqHeading::where(['hotel_id'=>$value['id'],'faq_id'=>$HZ['id'],'language_id'=>$request->language])->first();
                  if($HotelFaqHeading){
                      $get_head_arr['heading']  = $HotelFaqHeading->title;
                      $get_head_arr['faq_icon'] = $HZ['faq_icon'] != '' ? url('uploads/MediaPage', $HZ['faq_icon']) : asset('uploads/placeholder/placeholder.png');
                  }

                  $HotelFAQS = HotelFAQS::where(['faq_id'=>$HZ['id'],'hotel_id'=>$value['id']])->get();
                  // $get_home_country_arr = [];
                  $get_head_arr['content'] = [];
                  foreach ($HotelFAQS as $hkey => $HC) {
                      
                      $get_faq_arr = [];
                          
                      $HotelFaqLanguage =  HotelFaqLanguage::where(['faq_id'=>$HZ['id'],'hotel_id'=>$value['id'],'faqs_id'=>$HC['id'],'language_id'=>$request->language])->first();
                      
                      $get_faq_arr['title'] = $HotelFaqLanguage->title;
                      $get_head_arr['content'][] = $get_faq_arr;
                       
                  }
                  $get_hotel_data['FAQs'][] = $get_head_arr;
              }

              $data[] = $get_hotel_data;
              
          }
          $output['status'] = true;
          $output['message'] = 'Hotel List';
      }

      $output['data'] = $data;
      return json_encode($output);
  }

  //Get hotel details
  public function get_hotel_details(Request $request)
  {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'Data Not Found';
        $validation = Validator::make($request->all(), [
            'id' => 'required',
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

        $get_hotel_data_arr = [];
        $get_hotel_data = HotelPage::where(['slug'=>$request->id , 'status'=>'Active'])->first();
        if ($get_hotel_data) {
            $get_hotel_data_arr['id']      = $get_hotel_data['id'];
            $get_hotel_data_arr['slug']    = $get_hotel_data['slug'];
            $get_hotel_data_arr['address'] = $get_hotel_data['address'];
            $get_hotel_data_arr['address_longitude'] = $get_hotel_data['address_longitude'];
            $get_hotel_data_arr['address_lattitude'] = $get_hotel_data['address_lattitude'];
            $get_hotel_data_arr['video_url']            = $get_hotel_data['video_url'];

            $get_hotel_data_arr['title_icon']           = $get_hotel_data['title_icon'] != '' ? url('uploads/MediaPage', $get_hotel_data['title_icon']) : asset('uploads/placeholder/placeholder.png');
            $get_hotel_data_arr['side_image']           = $get_hotel_data['side_image'] != '' ? url('uploads/MediaPage', $get_hotel_data['side_image']) : asset('uploads/placeholder/placeholder.png');
            $get_hotel_data_arr['video_thumbnail']      = $get_hotel_data['video_thumbnail'] != '' ? url('uploads/MediaPage', $get_hotel_data['video_thumbnail']) : asset('uploads/placeholder/placeholder.png');

            $get_hotel_data_arr['hotel_bars'] = [];
            $get_hotel_data_arr['hotel_view'] = [];
            $get_hotel_data_arr['hotel_room'] = [];
            $get_hotel_data_arr['title']      = '';
  
            $get_hotel_language = HotelPageLanguage::where('hotel_id', $get_hotel_data->id)
                ->where('language_id', $request->language)
                ->first();

            if ($get_hotel_language) {

                $get_hotel_data_arr['hotel_bars']['title'] = $get_hotel_language['hotel_bars'] != '' ? $get_hotel_language['hotel_bars'] : '';
                $get_hotel_data_arr['hotel_bars']['image'] = $get_hotel_data['hotel_bar_icon'] != '' ? url('uploads/MediaPage', $get_hotel_data['hotel_bar_icon']) : asset('uploads/placeholder/placeholder.png');


                $get_hotel_data_arr['hotel_view']['title'] = $get_hotel_language['hotel_view'] != '' ? $get_hotel_language['hotel_view'] : '';
                $get_hotel_data_arr['hotel_view']['image'] = $get_hotel_data['hotel_view_icon'] != '' ? url('uploads/MediaPage', $get_hotel_data['hotel_view_icon']) : asset('uploads/placeholder/placeholder.png');


                $get_hotel_data_arr['hotel_room']['title'] = $get_hotel_language['hotel_room'] != '' ? $get_hotel_language['hotel_room'] : '';
                $get_hotel_data_arr['hotel_room']['image'] = $get_hotel_data['hotel_room_icon'] != '' ? url('uploads/MediaPage', $get_hotel_data['hotel_room_icon']) : asset('uploads/placeholder/placeholder.png');

                $get_hotel_data_arr['title']      = $get_hotel_language['title'] != '' ? $get_hotel_language['title'] : '';
            }

            // Higlights
            $get_hotel_data_arr['Highlight'] = [];
            $get_hotel_highlight = HotelHighlight::where('hotel_id', $get_hotel_data['id'])->get();

            $get_hotel_highlight_arr = [];
            $get_hotel_highlight_arr['title']        = '';
            $get_hotel_highlight_arr['description']  = '';

            $get_hotel_highlight_language = HotelHighlightLanguage::where('hotel_id', $get_hotel_data['id'])
             ->where('language_id', $request->language)->get();

            if (!$get_hotel_highlight_language->isEmpty()) {
              foreach ($get_hotel_highlight_language as $hotel_key => $hotel_value) {
                  $get_hotel_highlight_arr['title']        = $hotel_value['title'];
                  $get_hotel_highlight_arr['description']  = $hotel_value['description'];

                  $get_hotel_data_arr['Highlight'][] = $get_hotel_highlight_arr;
              }
            }

            // Amenities
            $get_hotel_data_arr['Amenities'] = [];
            $get_hotel_amenities = HotelAmenity::where('hotel_id', $get_hotel_data['id'])->get();
            $get_hotel_amenity_arr = [];
            $get_hotel_amenity_arr['title']       = '';

            if (!$get_hotel_amenities->isEmpty()) {
            $get_hotel_amenities_language = HotelAmenityLanguage::where('hotel_id', $get_hotel_data['id'])
            ->where('language_id', $request->language)->get();
            
                foreach ($get_hotel_amenities_language as $key => $amenity_value) {
                    $get_hotel_amenity_arr['title'] = $amenity_value['title'];
                    $get_hotel_data_arr['Amenities'][] = $get_hotel_amenity_arr;
                }
            }

            // Slider images
            $get_hotel_data_arr['slider_images'] = [];
            $get_sliders = PageSliders::where(['page'=>'hotel_slider_img','page_id'=> $get_hotel_data['id']])
                ->get();
            if (!$get_sliders->isEmpty()) {
                foreach ($get_sliders as $key => $slider_value) {
                    $get_slider          = [];
                    $get_slider['id']    = $slider_value['id'];
                    $get_slider['image'] = $slider_value['image'] != '' ? url('uploads/slider_images', $slider_value['image']) : asset('uploads/placeholder/placeholder.png');
                    $get_hotel_data_arr['slider_images'][] = $get_slider;
                }
            }
            // Slider images End

            // FAQS
            $get_hotel_data_arr['FAQs'] = [];
            $get_Faqs = HotelFaq::where(['hotel_id'=>$get_hotel_data['id']])->get();

            foreach ($get_Faqs as $hzkey => $HZ) {
                $get_head_arr = [];
                $HotelFaqHeading =  HotelFaqHeading::where(['hotel_id'=>$get_hotel_data['id'],'faq_id'=>$HZ['id'],'language_id'=>$request->language])->first();
                if($HotelFaqHeading){
                    $get_head_arr['heading']  = $HotelFaqHeading->title;
                    $get_head_arr['faq_icon'] = $HZ['faq_icon'] != '' ? url('uploads/MediaPage', $HZ['faq_icon']) : asset('uploads/placeholder/placeholder.png');
                }

                $HotelFAQS = HotelFAQS::where(['faq_id'=>$HZ['id'],'hotel_id'=>$get_hotel_data['id']])->get();
                // $get_home_country_arr = [];
                $get_head_arr['content'] = [];
                foreach ($HotelFAQS as $hkey => $HC) {
                    
                    $get_faq_arr = [];
                        
                    $HotelFaqLanguage =  HotelFaqLanguage::where(['faq_id'=>$HZ['id'],'hotel_id'=>$get_hotel_data['id'],'faqs_id'=>$HC['id'],'language_id'=>$request->language])->first();
                    
                    $get_faq_arr['title'] = $HotelFaqLanguage->title;
                    $get_head_arr['content'][] = $get_faq_arr;
                     
                }
                $get_hotel_data_arr['FAQs'][] = $get_head_arr;
            }

            $output['status'] = true;
            $output['message'] = 'Hotel Details';
        }

        $output['data'] = $get_hotel_data_arr;
        return json_encode($output);
    }
}
