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
use App\Models\AffiliatePage;
use App\Models\AffiliatePageLanguage;
use App\Models\AffiliatePageSliderImage;
use App\Models\AffiliatePageWork;
use App\Models\AffiliatePageWorkLanguage;
use App\Models\AffiliatePageChoose;
use App\Models\AffiliatePageChooseLanguage;
use App\Models\PagesFaqs;
use App\Models\PagesFaqLanguage;
use App\Models\GiftPage;
use App\Models\GiftPageLanguage;
use App\Models\GiftPagefacilities;
use App\Models\GiftPagefacilitiesLanguage;
use App\Models\GiftPageCardImage;

use App\Models\CityGuide;
use App\Models\CityGuideLanguage;
use App\Models\CityGuidePage;
use App\Models\CityGuidePageLanguage;
// use App\Models\CityGuidePageLocations;
use App\Models\MediaPage;
use App\Models\MediaPageLanguage;
use App\Models\MediaMensionSocial;
use App\Models\MediaMensionSocialLanguage;
use App\Models\MediaBlog;

use App\Models\MediaBlogLanguage;
use App\Models\MediaPageArticle;
use App\Models\MediaPageArticleLanguage;

use App\Models\TransferPage;
use App\Models\TransferPageLanguage;
use App\Models\TransferPageWhyBook;
use App\Models\TransferPageWhyBookLanguage;
use App\Models\TransferPageTaxi;
use App\Models\TransferPageTaxiLanguage;
use App\Models\TransferPageWithus;
use App\Models\TransferPageWithusLanguage;

use App\Models\TransferPageHighlights;
use App\Models\TransferPageHighlightsLanguage;

use App\Models\BlogCategory;
use App\Models\BlogCategoryLanguage;
use App\Models\BlogAditionalLanguage;
use App\Models\BlogAditionalHeadline;
use App\Models\Blog;
use App\Models\BlogLanguage;

use App\Models\AboutUsPage;
use App\Models\AboutUsPageLanguage;
use App\Models\AboutUsPageSliderImage;
use App\Models\AboutUsPagefacility;
use App\Models\AboutUsPagefacilityLanguage;
use App\Models\AboutUsPagechoose;
use App\Models\AboutUsPagechooseLanguage;

use App\Models\BannerOverview;
use App\Models\BannerOverviewLanguage;

use App\Models\AdvertismentPage;
use App\Models\AdvertismentPageLanguage;
use App\Models\AdvertiseWithUs;
use App\Models\AdvertiseWithUsLanguage;
use App\Models\AdvertisePagechoose;
use App\Models\AdvertisePagechooseLanguage;

use App\Models\JoinPage;
use App\Models\JoinPageLanguage;
use App\Models\JoinPagechoose;
use App\Models\JoinPagechooseLanguage;

use App\Models\LodgeTour;
use App\Models\LodgeTourLanguage;

use App\Models\PageSliders;
use App\Models\PageSlidersLanguage;

use App\Models\PartnerPage;
use App\Models\PartnerPageLanguage;
use App\Models\PartnerPageFacility;
use App\Models\PartnerPageFacilityLanguage;
use App\Models\PartnerPageBook;
use App\Models\PartnerPageBookLanguage;
use App\Models\PartnerPageActivitiesImage;

use App\Models\GolfPage;
use App\Models\GolfPageLanguage;
use App\Models\GolfPageFacility;
use App\Models\GolfPageFacilityLanguage;

use App\Models\HelpPageHighlights;
use App\Models\HelpPageHighlightsLanguage;
use App\Models\HelpPageLanguage;
use App\Models\HelpPageDescriptionLanguage;

use App\Models\Product;
use App\Models\Category;

use App\Models\ProductRequestPopup;
use App\Models\ProductRequestPopupLanguage;

use App\Models\Blogpagefeatured;
use App\Models\BlogpagefeaturedLanguage;

use App\Models\AboutUsPageService;
use App\Models\AboutUsPageServiceLanguage;

use Illuminate\Support\Str;

use Carbon\Carbon;

class PagesController extends Controller
{
    //Get Affilate Page
    public function get_affiliate_page_data(Request $request)
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

        $get_affilate_page_data = [];
        $get_affiliatepage = AffiliatePage::where('status', 'Active')->first();
        if ($get_affiliatepage) {

            $get_affilate_page_data['about_image_1'] = $get_affiliatepage['about_image_1'] != '' ? url('uploads/Affiliate_Page', $get_affiliatepage['about_image_1']) : asset('uploads/placeholder/placeholder.png');
            $get_affilate_page_data['about_image_2'] = $get_affiliatepage['about_image_2'] != '' ? url('uploads/Affiliate_Page', $get_affiliatepage['about_image_2']) : asset('uploads/placeholder/placeholder.png');

            $get_affiliate_page_language = AffiliatePageLanguage::where('affiliate_page_id', $get_affiliatepage->id)
                ->where('language_id', $request->language)
                ->first();
            if ($get_affiliate_page_language) {
                $get_affilate_page_data['slider_title'] = $get_affiliate_page_language['title'] != '' ? $get_affiliate_page_language['title'] : '';
                $get_affilate_page_data['about_title'] = $get_affiliate_page_language['about_title'] != '' ? $get_affiliate_page_language['about_title'] : '';
                $get_affilate_page_data['about_description'] = $get_affiliate_page_language['about_description'] != '' ? $get_affiliate_page_language['about_description'] : '';
            }

            $get_affilate_page_data['banners'] = [];
            $get_affilate_banners = AffiliatePageSliderImage::where('affiliate_page_id', $get_affiliatepage->id)->get();
            if (!$get_affilate_banners->isEmpty()) {
                foreach ($get_affilate_banners as $key => $value) {
                    $get_affilate_page_data['banners'][] = $value['slider_images'] != '' ? url('uploads/Affiliate_Page', $value['slider_images']) : asset('uploads/placeholder/placeholder.png');
                }
            }

            // How it work
            $get_affilate_page_data['how_its_work_heading'] = '';
            $get_HIW_heading           = MetaGlobalLanguage::where(['meta_title' => 'affilat_page_how_its_work_heading'])->where('language_id', $request->language)->first();
            if($get_HIW_heading){
                $get_affilate_page_data['how_its_work_heading'] = $get_HIW_heading['title'];  
            }


            // Why Choose Heading
            $get_affilate_page_data['why_choose_heading'] = '';
            $get_choose_heading           = MetaGlobalLanguage::where(['meta_title' => 'affilat_page_choose_heading'])->where('language_id', $request->language)->first();
            if($get_choose_heading){
                $get_affilate_page_data['why_choose_heading'] = $get_choose_heading['title'];  
            }


            $get_affilate_page_data['how_its_work'] = [];
            $get_affilate_how_to_work = AffiliatePageWork::get();
            if (!$get_affilate_how_to_work->isEmpty()) {
                foreach ($get_affilate_how_to_work as $how_work_key => $how_work_value) {
                    $get_how_its_work = [];
                    $get_how_its_work['id'] = $how_work_value['id'];
                    $get_how_its_work['title'] = '';
                    $get_how_its_work['description'] = '';
                    $get_how_its_work['icon'] = $how_work_value['work_image'] != '' ? url('uploads/Affiliate_Page', $how_work_value['work_image']) : asset('uploads/placeholder/placeholder.png');
                    $get_how_work_language = AffiliatePageWorkLanguage::where('affiliate_page_id', $get_affiliatepage->id)
                        ->where('affiliate_page_work_id', $how_work_value['id'])
                        ->where('language_id', $request->language)
                        ->first();
                    if ($get_how_work_language) {
                        $get_how_its_work['title'] = $get_how_work_language['work_title'] != '' ? $get_how_work_language['work_title'] : '';
                        $get_how_its_work['description'] = $get_how_work_language['work_description'] != '' ? $get_how_work_language['work_description'] : '';
                    }
                    $get_affilate_page_data['how_its_work'][] = $get_how_its_work;
                }
            }

            // Why choose affiliate
            $get_affilate_page_data['why_choose'] = [];
            $get_affilate_why_choose = AffiliatePageChoose::where('affiliate_page_id', $get_affiliatepage->id)->get();
            if (!$get_affilate_why_choose->isEmpty()) {
                foreach ($get_affilate_why_choose as $why_choose_key => $why_choose_value) {
                    $get_why_choose = [];
                    $get_why_choose['id'] = $why_choose_value['id'];
                    $get_why_choose['description'] = '';
                    $get_why_choose['icon'] = $why_choose_value['choose_image'] != '' ? url('uploads/Affiliate_Page', $why_choose_value['choose_image']) : asset('uploads/placeholder/placeholder.png');
                    $why_choose_language = AffiliatePageChooseLanguage::where(['affiliate_page_id' => $get_affiliatepage->id, 'affiliate_page_choose_id' => $why_choose_value['id'], 'language_id' => $request->language])->first();
                    if ($why_choose_language) {
                        $get_why_choose['description'] = $why_choose_language['choose_description'];
                    }
                    $get_affilate_page_data['why_choose'][] = $get_why_choose;
                }
            }

            // Frequently Asked Question
            $get_affilate_page_data['faqs_heading'] = '';
            $get_faq_heading           = MetaGlobalLanguage::where(['meta_title' => 'affilate_page_faq_heading'])->where('language_id', $request->language)->first();
            if($get_faq_heading){
                $get_affilate_page_data['faqs_heading'] = $get_faq_heading['title'];  
            }
            $get_affilate_page_data['faqs'] = [];
            $get_faqs = PagesFaqs::where('affiliate_page_id', $get_affiliatepage->id)
                ->where('page_name', 'affiliate page')
                ->get();
            if (!$get_faqs->isEmpty()) {
                foreach ($get_faqs as $faq_key => $faq_value) {
                    $get_faq = [];
                    $get_faq['id'] = $faq_value['id'];
                    $get_faq['questions'] = '';
                    $get_faq['answer'] = '';
                    $get_faq_language = PagesFaqLanguage::where(['affiliate_page_id' => $get_affiliatepage->id, 'page_faq_id' => $faq_value['id'], 'language_id' => $request->language])->first();
                    if ($get_faq_language) {
                        $get_faq['questions'] = $get_faq_language['question'] != '' ? $get_faq_language['question'] : '';
                        $get_faq['answer'] = $get_faq_language['answer'] != '' ? $get_faq_language['answer'] : '';
                    }
                    $get_affilate_page_data['faqs'][] = $get_faq;
                }
            }

            // Slider images
            $get_affilate_page_data['slider_images'] = [];
            $get_sliders = PageSliders::where('page', 'affiliate_page_slider')
                ->get();
            if (!$get_sliders->isEmpty()) {
                foreach ($get_sliders as $key => $slider_value) {
                    $get_slider          = [];
                    $get_slider['id']    = $slider_value['id'];
                    $get_slider['image'] = $slider_value['image'] != '' ? url('uploads/slider_images', $slider_value['image']) : asset('uploads/placeholder/placeholder.png');
                    $get_slider_language = PageSlidersLanguage::where('pages_slider_id', $slider_value['id'])
                        ->where('language_id', $request->language)
                        ->where('page', 'affiliate_page_slider')
                        ->first();
                    $get_slider['title'] = '';
                    $get_slider['description'] = '';
                    if ($get_slider_language) {
                        $get_slider['title']       = $get_slider_language['title'] != '' ? $get_slider_language['title'] : '';
                        $get_slider['description'] = $get_slider_language['description'] != '' ? $get_slider_language['description'] : '';
                    }
                    $get_affilate_page_data['slider_images'][] = $get_slider;
                }
            }
            // Slider images End



            $output['status'] = true;
            $output['message'] = 'Affilate Page Data ';
        }

        $output['data'] = $get_affilate_page_data;
        return json_encode($output);
    }

    //Get Gift Card Page Data
    public function get_gift_card_page_data(Request $request)
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

        $get_giftcard_page_data = [];
        $get_gift_card = GiftPage::where('status', 'Active')->first();
        if ($get_gift_card) {
            $get_banner_arr = [];
            $get_banner_arr['id'] = $get_gift_card['id'];
            $get_banner_arr['title'] = '';
            $get_banner_arr['description'] = '';
            $get_banner_arr['image'] = $get_gift_card['image'] != '' ? url('uploads/GiftCardPage', $get_gift_card['image']) : asset('uploads/placeholder/placeholder.png');

            $get_giftcard_language = GiftPageLanguage::where('gift_card_id', $get_gift_card->id)
                ->where('language_id', $request->language)
                ->first();
            if ($get_giftcard_language) {
                $get_banner_arr['title'] = $get_giftcard_language['title'] != '' ? $get_giftcard_language['title'] : '';
                $get_banner_arr['description'] = $get_giftcard_language['description'] != '' ? $get_giftcard_language['description'] : '';
            }

            $get_giftcard_page_data['banner'] = $get_banner_arr;
            // Facilities
            $get_giftcard_page_data['facilities'] = [];
            $get_gift_card_facility = GiftPagefacilities::where('gift_card_id', $get_gift_card['id'])->get();
            if (!$get_gift_card_facility->isEmpty()) {
                foreach ($get_gift_card_facility as $facilty_key => $facilty_value) {
                    # code...
                    $get_facilty = [];
                    $get_facilty['id'] = $facilty_value['id'];
                    $get_facilty['title'] = '';
                    $get_facilty['description'] = '';
                    $get_facilty['image'] = $facilty_value['facility_image'] != '' ? url('uploads/GiftCardPage', $facilty_value['facility_image']) : asset('uploads/placeholder/placeholder.png');
                    $get_facility_language = GiftPagefacilitiesLanguage::where(['gift_card_id' => $get_gift_card['id'], 'gift_card_facilities_id' => $facilty_value['id'], 'language_id' => $request->language])->first();
                    if ($get_facility_language) {
                        $get_facilty['title'] = $get_facility_language['facility_title'] != '' ? $get_facility_language['facility_title'] : '';
                        $get_facilty['description'] = $get_facility_language['facility_description'] != '' ? $get_facility_language['facility_description'] : '';
                    }
                    $get_giftcard_page_data['facilities'][] = $get_facilty;
                }
            }

            // Gift Cards
            $get_giftcard_page_data['gift_cards_image'] = [];
            $get_gift_card_image = GiftPageCardImage::where('gift_card_id', $get_gift_card['id'])->get();
            if (!$get_gift_card_image->isEmpty()) {
                foreach ($get_gift_card_image as $image_key => $image_value) {
                    # code...
                    $get_card_image = [];
                    $get_card_image['id'] = $image_value['id'];
                    $get_card_image['image'] = $image_value['card_images'] != '' ? url('uploads/GiftCardPage', $image_value['card_images']) : asset('uploads/placeholder/placeholder.png');
                    $get_giftcard_page_data['gift_cards_image'][] = $get_card_image;
                }
            }



            // Slider images
            $get_giftcard_page_data['slider_images'] = [];
            $get_sliders = PageSliders::where('page', 'giftcard_page')
                ->get();
            if (!$get_sliders->isEmpty()) {
                foreach ($get_sliders as $key => $slider_value) {
                    $get_slider          = [];
                    $get_slider['id']    = $slider_value['id'];
                    $get_slider['image'] = $slider_value['image'] != '' ? url('uploads/slider_images', $slider_value['image']) : asset('uploads/placeholder/placeholder.png');
                    $get_slider_language = PageSlidersLanguage::where('pages_slider_id', $slider_value['id'])
                        ->where('language_id', $request->language)
                        ->where('page', 'giftcard_page')
                        ->first();
                    $get_slider['title'] = '';
                    $get_slider['description'] = '';
                    if ($get_slider_language) {
                        $get_slider['title']       = $get_slider_language['title'] != '' ? $get_slider_language['title'] : '';
                        $get_slider['description'] = $get_slider_language['description'] != '' ? $get_slider_language['description'] : '';
                    }
                    $get_giftcard_page_data['slider_images'][] = $get_slider;
                }
            }
            // Slider images End


            $output['status'] = true;
            $output['message'] = 'Gift Card Page';
        }

        $output['data'] = $get_giftcard_page_data;
        return json_encode($output);
    }


    //Get City Guide Page Data
    public function get_city_guide_page_data(Request $request)
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

        $get_city_guide_page_data = [];
        $get_city_guides = CityGuidePage::where('status', 'Active')->first();
        if ($get_city_guides) {
            $get_city_guide_page_data['id'] = $get_city_guides['id'];
            $get_city_guide_page_data['location_heading'] = '';
            $get_city_guide_page_data['location_description'] = '';
            $get_city_guide_page_data['title'] = '';
            $get_city_guide_page_data['description'] = '';
            $get_city_guide_page_data['image'] = $get_city_guides['image'] != '' ? url('uploads/MediaPage', $get_city_guides['image']) : asset('uploads/placeholder/placeholder.png');
            $get_city_guide_language = CityGuidePageLanguage::where('city_guide_id', $get_city_guides->id)
                ->where('language_id', $request->language)
                ->first();
            if ($get_city_guide_language) {
                $get_city_guide_page_data['location_heading'] = $get_city_guide_language['location_heading'] != '' ? $get_city_guide_language['location_heading'] : '';
                $get_city_guide_page_data['location_description'] = $get_city_guide_language['location_description'] != '' ? $get_city_guide_language['location_description'] : '';
                $get_city_guide_page_data['title'] = $get_city_guide_language['title'] != '' ? $get_city_guide_language['title'] : '';
                $get_city_guide_page_data['description'] = $get_city_guide_language['description'] != '' ? $get_city_guide_language['description'] : '';
            }

            // Slider images
            $get_city_guide_page_data['slider_images'] = [];
            $get_sliders = PageSliders::where('page', 'city_guide_page')
                ->get();
            if (!$get_sliders->isEmpty()) {
                foreach ($get_sliders as $key => $slider_value) {
                    $get_slider          = [];
                    $get_slider['id']    = $slider_value['id'];
                    $get_slider['image'] = $slider_value['image'] != '' ? url('uploads/slider_images', $slider_value['image']) : asset('uploads/placeholder/placeholder.png');
                    $get_slider_language = PageSlidersLanguage::where('pages_slider_id', $slider_value['id'])
                        ->where('language_id', $request->language)
                        ->where('page', 'city_guide_page')
                        ->first();
                    $get_slider['title'] = '';
                    $get_slider['description'] = '';
                    if ($get_slider_language) {
                        $get_slider['title']       = $get_slider_language['title'] != '' ? $get_slider_language['title'] : '';
                        $get_slider['description'] = $get_slider_language['description'] != '' ? $get_slider_language['description'] : '';
                    }
                    $get_city_guide_page_data['slider_images'][] = $get_slider;
                }
            }
            // Slider images End

            // City List
            $get_city_guide_page_data['city_list'] = [];
            $get_city_guides = CityGuide::select('city_guide.*', 'city_guide_language.title')->orderBy('city_guide.sort_order', 'asc')->where(['city_guide.is_delete' => 0])->where(['city_guide.status' => 'Active'])->join("city_guide_language", 'city_guide.id', '=', 'city_guide_language.city_guide_id')->groupBy('city_guide.id')->get();
            if (!$get_city_guides->isEmpty()) {

                foreach ($get_city_guides as $key => $value) {
                    $get_city_guide_data = array();
                    $get_city_guide_data['id']      = $value['id'];
                    $get_city_guide_data['slug']    = $value['slug'];
                    $get_city_guide_data['image']   = $value['image'] != '' ? url('uploads/MediaPage', $value['image']) : asset('uploads/placeholder/placeholder.png');

                    $get_city_guide_data['title'] = '';
                    $get_city_guide_data['description'] = '';
                    $get_city_guide_language = CityGuideLanguage::where('city_guide_id', $value['id'])
                        ->where('language_id', $request->language)
                        ->first();

                    if ($get_city_guide_language) {
                        $get_city_guide_data['title'] = $get_city_guide_language['title'] != '' ? $get_city_guide_language['title'] : '';
                        $get_city_guide_data['description'] = $get_city_guide_language['description'] != '' ? $get_city_guide_language['description'] : '';
                    }


                    $get_city_guide_page_data['city_list'][] = $get_city_guide_data;
                }
            }

            $output['status'] = true;
            $output['message'] = 'City Guide Page';
        }

        $output['data'] = $get_city_guide_page_data;
        return json_encode($output);
    }


    //Media-Mention Page Data
    public function get_media_mention_page_data(Request $request)
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

        $get_media_mention_page_data = [];
        $get_media_page = MediaPage::where('status', 'Active')->first();
        if ($get_media_page) {
            $get_media_mention_page_data['id'] = $get_media_page['id'];
            $get_media_mention_page_data['banner_image'] = $get_media_page['image'] != '' ? url('uploads/MediaPage', $get_media_page['image']) : asset('uploads/placeholder/placeholder.png');
            $get_media_mention_page_data['title'] = '';
            $get_media_mention_page_data['description'] = '';
            $get_media_mention_page_data['article_heading_title'] = '';
            $get_media_mention_language = MediaPageLanguage::where('media_mension_id', $get_media_page['id'])
                ->where('language_id', $request->language)
                ->first();

            if ($get_media_mention_language) {
                $get_media_mention_page_data['title'] = $get_media_mention_language['title'] != '' ? $get_media_mention_language['title'] : '';
                $get_media_mention_page_data['description'] = $get_media_mention_language['description'] != '' ? $get_media_mention_language['description'] : '';
                $get_media_mention_page_data['article_heading_title'] = $get_media_mention_language['article_heading_title'] != '' ? $get_media_mention_language['article_heading_title'] : '';
                $get_media_mention_page_data['blog_heading_title'] = $get_media_mention_language['blog_heading_title'] != '' ? $get_media_mention_language['blog_heading_title'] : '';
            }

            //Middle Slider
            $get_media_mention_page_data['middle_slider'] = [];
            $get_media_mention_middle_slider = MediaMensionSocial::where('media_mension_id', $get_media_page['id'])

                ->where('status', 'Active')
                ->get();
            if (!$get_media_mention_middle_slider->isEmpty()) {
                foreach ($get_media_mention_middle_slider as $slider_key => $slider_value) {
                    # code...
                    $get_middle_slider = [];
                    $get_middle_slider['id'] = $slider_value['id'];
                    $get_middle_slider['icon'] = $slider_value['image'] != '' ? url('uploads/MediaPage/media_mension_slider', $slider_value['image']) : asset('uploads/placeholder/placeholder.png');
                    $get_middle_slider['link'] = $slider_value['link'] != '' ? $slider_value['link'] : '';
                    $get_middle_slider['title'] = '';
                    $get_middle_language = MediaMensionSocialLanguage::where('social_id', $slider_value['id'])
                        ->where('language_id', $request->language)
                        ->first();
                    if ($get_middle_language) {
                        $get_middle_slider['title'] = $get_middle_language['title'] != '' ? $get_middle_language['title'] : '';
                    }
                    $get_media_mention_page_data['middle_slider'][] = $get_middle_slider;
                }
            }

            //Media Blog
            $get_media_mention_page_data['media_blog'] = [];
            $get_media_mention_page_data['new_blog'] = [];
            $get_media_blog = MediaBlog::where('status', 'Active')
                ->orderby('id', 'asc')
                ->get();
            if (!$get_media_blog->isEmpty()) {
                foreach ($get_media_blog as $media_blog_key => $media_blog_value) {
                    $get_blog                 = [];
                    $get_blog['id']           = $media_blog_value['id'];
                    $get_blog['added_by']     = $media_blog_value['added_by']    != '' ? $media_blog_value['added_by'] : '';
                    $get_blog['view']         = $media_blog_value['views']       != '' ? $media_blog_value['views'] : '0';
                    $get_blog['media_image'] = $media_blog_value['media_image'] != '' ? url('uploads/MediaBlog', $media_blog_value['media_image']) : asset('uploads/placeholder/placeholder.png');
                    $get_blog['media_video'] = $media_blog_value['media_video'];
                    $get_blog['description']  = '';
                    $get_blog_language = MediaBlogLanguage::where('media_blog_id', $media_blog_value['id'])
                        ->where('language_id', $request->language)
                        ->first();
                    if ($get_blog_language) {
                        $get_blog['description'] = $get_blog_language['description'] != '' ? $get_blog_language['description'] : '';
                    }
                    $get_media_mention_page_data['media_blog'][] = $get_blog;
                }
                $new_get_blog = [];
                $new_get_media_blog = MediaBlog::where('status', 'Active')
                    ->orderby('id', 'asc')
                    ->first();
                $new_get_blog['id'] = $new_get_media_blog['id'];
                $new_get_blog['added_by'] = $new_get_media_blog['added_by'] != '' ? $new_get_media_blog['added_by'] : '';
                $new_get_blog['view'] = $new_get_media_blog['views'] != '' ? $new_get_media_blog['views'] : '0';
                $new_get_blog['media_image'] = $new_get_media_blog['media_image'] != '' ? url('uploads/MediaBlog', $new_get_media_blog['media_image']) : asset('uploads/placeholder/placeholder.png');
                $new_get_blog['media_video'] = $new_get_media_blog['media_video'];
                $new_get_blog['description'] = '';
                $get_blog_language_ = MediaBlogLanguage::where('media_blog_id', $new_get_media_blog['id'])
                    ->where('language_id', $request->language)
                    ->first();
                if ($get_blog_language_) {
                    $new_get_blog['description'] = $get_blog_language_['description'] != '' ? $get_blog_language_['description'] : '';
                }
                $get_media_mention_page_data['new_blog'] = $new_get_blog;
            }

            // Articles
            $get_media_mention_page_data['articles'] = [];
            $get_media_mention_articles = MediaPageArticle::where('media_mension_id', $get_media_page['id'])->get();
            if (!$get_media_mention_articles->isEmpty()) {
                foreach ($get_media_mention_articles as $article_key => $article_value) {
                    $get_article_arr = [];
                    $get_article_arr['id'] = $article_value['id'];
                    $get_article_arr['city'] = $article_value['city'] != '' ? $article_value['city'] : '';
                    $get_article_arr['title'] = '';
                    $get_article_arr['description'] = '';
                    $get_article_language = MediaPageArticleLanguage::where('media_mension_article_id', $article_value['id'])
                        ->where('language_id', $request->language)
                        ->first();
                    if ($get_article_language) {
                        $get_article_arr['title'] = $get_article_language['article_title'] != '' ? $get_article_language['article_title'] : '';
                        $get_article_arr['description'] = $get_article_language['article_description'] != '' ? $get_article_language['article_description'] : '';
                    }
                    $get_article_arr['date'] = date('F d,Y', strtotime($article_value['created_at']));
                    $get_media_mention_page_data['articles'][] = $get_article_arr;
                }
            }


            // Slider images
            $get_media_mention_page_data['slider_images'] = [];
            $get_sliders = PageSliders::where('page', 'media_page')
                ->get();
            if (!$get_sliders->isEmpty()) {
                foreach ($get_sliders as $key => $slider_value) {
                    $get_slider_arr          = [];
                    $get_slider_arr['id']    = $slider_value['id'];
                    $get_slider_arr['image'] = $slider_value['image'] != '' ? url('uploads/slider_images', $slider_value['image']) : asset('uploads/placeholder/placeholder.png');
                    $get_slider_language = PageSlidersLanguage::where('pages_slider_id', $slider_value['id'])
                        ->where('language_id', $request->language)
                        ->where('page', 'media_page')
                        ->first();
                    $get_slider_arr['title'] = '';
                    $get_slider_arr['description'] = '';
                    if ($get_slider_language) {
                        $get_slider_arr['title']       = $get_slider_language['title'] != '' ? $get_slider_language['title'] : '';
                        $get_slider_arr['description'] = $get_slider_language['description'] != '' ? $get_slider_language['description'] : '';
                    }
                    $get_media_mention_page_data['slider_images'][] = $get_slider_arr;
                }
            }
            // Slider images End


            $output['status'] = true;
            $output['message'] = 'Media Mention Page';
        }

        $output['data'] = $get_media_mention_page_data;
        return json_encode($output);
    }

    //Transfer Page Detail
    public function get_transfer_page(Request $request)
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
        $get_transfer = TransferPage::where('status', 'Active')->first();
        if ($get_transfer) {
            $settings = [];
            $settings['banner_image'] = url('uploads/TransferPageImage/' . $get_transfer['image']);

            $get_transfer_page_language = TransferPageLanguage::where('transfer_page_id', $get_transfer->id)
                ->where('language_id', $request->language)
                ->first();

            $settings['title'] = '';
            $settings['description'] = '';

            if ($get_transfer_page_language) {
                $settings['title']       = $get_transfer_page_language['title'];
                $settings['description'] = $get_transfer_page_language['description'];
            }

            $data['settings'] = $settings;

            $premium_taxi_heading = MetaGlobalLanguage::where('meta_title', 'premium_taxi_heading')
                ->where('language_id', $request->language)
                ->first();
            if ($premium_taxi_heading) {
                $data['premium_taxi_heading'] = $premium_taxi_heading['title'];
            } else {
                $data['premium_taxi_heading'] = 'Premium Taxi';
            }

            // why choose
            $data['why_book'] = [];
            $get_transfer_page_why_book = TransferPageWhyBook::where('transfer_page_id', $get_transfer->id)
                ->orderBy('id', 'desc')
                ->get();

            if (!$get_transfer_page_why_book->isEmpty()) {
                foreach ($get_transfer_page_why_book as $key => $book_value) {
                    $get_why_book = [];
                    $get_why_book['id'] = $book_value['id'];
                    $get_why_book['image'] = url('uploads/TransferPageImage/' . $book_value['image']);
                    $get_page_book_language = TransferPageWhyBookLanguage::where('transfer_page_id', $get_transfer->id)
                        ->where('why_book_id', $book_value['id'])
                        ->where('language_id', $request->language)
                        ->first();
                    $get_why_book['description'] = '';
                    if ($get_page_book_language) {
                        $get_why_book['title'] = $get_page_book_language['title'] != '' ? $get_page_book_language['title'] : '';
                        $get_why_book['description'] = $get_page_book_language['description'] != '' ? $get_page_book_language['description'] : '';
                    }
                    $data['why_book'][] = $get_why_book;
                }
            }

            // Premium taxi
            $data['premium_taxi'] = [];
            $get_transfer_page_premium_taxi = TransferPageTaxi::where('transfer_page_id', $get_transfer->id)
                ->orderBy('sort', 'asc')
                ->get();

            if (!$get_transfer_page_premium_taxi->isEmpty()) {
                foreach ($get_transfer_page_premium_taxi as $key => $taxi_value) {
                    $get_premium_taxi = [];
                    $get_premium_taxi['id'] = $taxi_value['id'];
                    $get_premium_taxi['image'] = url('uploads/TransferPageImage/' . $taxi_value['image']);
                    $get_page_taxi_language = TransferPageTaxiLanguage::where('transfer_page_id', $get_transfer->id)
                        ->where('transfer_page_taxi_id', $taxi_value['id'])
                        ->where('language_id', $request->language)
                        ->first();
                    $get_premium_taxi['title'] = '';
                    if ($get_page_taxi_language) {
                        $get_premium_taxi['title']       = $get_page_taxi_language['title'] != '' ? $get_page_taxi_language['title'] : '';
                        $get_premium_taxi['information'] = $get_page_taxi_language['information'] != '' ? $get_page_taxi_language['information'] : '';
                    }
                    $data['premium_taxi'][] = $get_premium_taxi;
                }
            }

            // Book With us
            $data['book_with_us'] = [];
            $get_transfer_page_with_us = TransferPageWithus::where('transfer_page_id', $get_transfer->id)
                ->orderBy('id', 'desc')
                ->get();

            if (!$get_transfer_page_with_us->isEmpty()) {
                foreach ($get_transfer_page_with_us as $key => $with_us_value) {
                    $get_with_us = [];
                    $get_with_us['id'] = $with_us_value['id'];
                    $get_with_us['image'] = url('uploads/TransferPageImage/' . $with_us_value['image']);
                    $get_page_with_us_language = TransferPageWithusLanguage::where('transfer_page_id', $get_transfer->id)
                        ->where('with_us_id', $with_us_value['id'])
                        ->where('language_id', $request->language)
                        ->first();
                    $get_with_us['title'] = '';
                    if ($get_page_with_us_language) {
                        $get_with_us['title'] = $get_page_with_us_language['title'] != '' ? $get_page_with_us_language['title'] : '';
                    }
                    $data['book_with_us'][] = $get_with_us;
                }
            }


            // Highlights
            $data['highlights'] = [];
            $get_transfer_highlights = TransferPageHighlights::where('transfer_page_id', $get_transfer->id)
                ->orderBy('sort_order', 'asc')
                ->get();

            if (!$get_transfer_highlights->isEmpty()) {
                foreach ($get_transfer_highlights as $key => $_value) {
                    $get_high = [];
                    $get_high['id']         = $_value['id'];
                    $get_high['sort_order'] = $_value['sort_order'];
                    $get_high['image']      = url('uploads/TransferPageImage/' . $_value['image']);
                    $get_highlight_language = TransferPageHighlightsLanguage::where('transfer_page_id', $get_transfer->id)
                        ->where('transfer_page_highlight_id', $_value['id'])
                        ->where('language_id', $request->language)
                        ->first();
                    $get_high['title']       = '';
                    $get_high['description'] = '';
                    if ($get_highlight_language) {
                        $get_high['title'] = $get_highlight_language['title'] != '' ? $get_highlight_language['title'] : '';
                        $get_high['description'] = $get_highlight_language['description'] != '' ? $get_highlight_language['description'] : '';
                    }
                    $data['highlights'][] = $get_high;
                }
            }


            // Slider images
            $data['slider_images'] = [];
            $get_sliders = PageSliders::where('page', 'transfer_page')
                ->get();
            if (!$get_sliders->isEmpty()) {
                foreach ($get_sliders as $key => $slider_value) {
                    $get_slider          = [];
                    $get_slider['id']    = $slider_value['id'];
                    $get_slider['image'] = $slider_value['image'] != '' ? url('uploads/slider_images', $slider_value['image']) : asset('uploads/placeholder/placeholder.png');
                    $get_slider_language = PageSlidersLanguage::where('pages_slider_id', $slider_value['id'])
                        ->where('language_id', $request->language)
                        ->where('page', 'transfer_page')
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
            $data['terms_conditions'] = '';
            $terms_conditions = MetaGlobalLanguage::where('meta_title', 'transfer_terms_conditions')
                    ->where('language_id', $request->language)
                    ->first();
            if($terms_conditions){
                $data['terms_conditions'] = $terms_conditions['title'];
            }

            // why_booking_heading
            $data['why_booking_heading'] = '';
            $terms_conditions = MetaGlobalLanguage::where('meta_title', 'why_booking_heading')
                    ->where('language_id', $request->language)
                    ->first();
            if($terms_conditions){
                $data['why_booking_heading'] = $terms_conditions['title'];
            }


            $data['side_banner']   = '';
            $SideBanner            = MetaGlobalLanguage::where('meta_title', 'transfer_side_banner')->where('status','Active')->first();
            if($SideBanner){
                $data['side_banner']            = url('uploads/side_banner',$SideBanner['image']);
            }

            $output['status'] = true;
            $output['data'] = $data;
            $output['message'] = 'Transfer Page Data ';
        } else {
            $output['status'] = false;
            $output['message'] = 'No Data Found';
        }

        return json_encode($output);
    }

    //Blogs Page
    public function get_blogs_page(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'Blogs Page';
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
        $language_id = $request->language;
        $get_blogs_page = [];
        $get_blogs_page['blogs'] = [];
        $get_blog_category = BlogCategory::select('blog_category.*', 'blog_category_language.name')
            ->orderBy('blog_category.id', 'desc')
            ->where(['blog_category.is_delete' => 0])
            ->join('blog_category_language', 'blog_category.id', '=', 'blog_category_language.blog_cetegory_id')
            ->groupBy('blog_category.id')
            ->where('status', 'Active')
            ->where('language_id', $language_id)
            ->get();

        if (!$get_blog_category->isEmpty()) {
            foreach ($get_blog_category as $key => $value) {
                $get_blogs = Blog::select('blogs.*', 'blog_language.title')
                    ->orderBy('blogs.date', 'desc')
                    ->where(['blogs.is_delete' => 0])
                    ->join('blog_language', 'blogs.id', '=', 'blog_language.blog_id')
                    ->where('language_id', $language_id)
                    ->where('category_id', $value['id'])
                    ->where('status', 'Active')
                    ->groupBy('blogs.id')
                    ->get();
                if (!$get_blogs->isEmpty()) {
                    $get_blog = [];
                    $get_blog['category'] = $value['name'] != '' ? $value['name'] : '';
                    $get_blog['blogs'] = [];
                    foreach ($get_blogs as $Blog_key => $Blog_value) {
                        # code...
                        $get_cat_blogs = [];
                        $get_cat_blogs['id']    = $Blog_value['id'];
                        $get_cat_blogs['slug']  = $Blog_value['slug'];
                        $get_cat_blogs['title'] = $Blog_value['title'] != '' ? $Blog_value['title'] : '';
                        $get_cat_blogs['date']  = date('d-m-Y', strtotime($Blog_value['date']));
                        $get_cat_blogs['image'] = $Blog_value['image'] != '' ? url('uploads/blogs', $Blog_value['image']) : url('uploads/placeholder/placeholder.png');
                        $get_blog['blogs'][]    = $get_cat_blogs;
                    }
                    $get_blogs_page['blogs'][] = $get_blog;
                }
            }
        }

        $get_blogs_page['latest_blog'] = [];
        $latest_blog = Blog::select('blogs.*', 'blog_language.title', 'blog_language.description')

            ->where(['blogs.is_delete' => 0])
            ->join('blog_language', 'blogs.id', '=', 'blog_language.blog_id')
            ->where('language_id', $language_id)
            ->where('status', 'Active')
            ->groupBy('blogs.id')
            ->orderBy('blogs.date', 'desc')
            ->get();

        if (!$latest_blog->isEmpty()) {
            foreach ($latest_blog as $Blog_key => $Blog_value) {

                $get_latest_blog                 = [];
                $get_latest_blog['id']           = $Blog_value['id'];
                $get_latest_blog['slug']          = $Blog_value['slug'];
                $get_latest_blog['title']        = $Blog_value['title']       != '' ? $Blog_value['title'] : '';
                $get_latest_blog['description']  = $Blog_value['description'] != '' ?  (strlen($Blog_value['description']) > 200) ? Str::limit($Blog_value['description'], 200)  : $Blog_value['description']  : '';
                $get_latest_blog['date']         = date('d-m-Y', strtotime($Blog_value['date']));
                $get_latest_blog['image']        = $Blog_value['image']       != '' ? url('uploads/blogs', $Blog_value['image']) : url('uploads/placeholder/placeholder.png');
                $get_blogs_page['latest_blog'][] = $get_latest_blog;
            }
        }
        // Slider images
        $get_blogs_page['slider_images'] = [];
        $get_sliders = PageSliders::where('page', 'blog_page')
            ->get();
        if (!$get_sliders->isEmpty()) {
            foreach ($get_sliders as $key => $slider_value) {
                $get_slider          = [];
                $get_slider['id']    = $slider_value['id'];
                $get_slider['image'] = $slider_value['image'] != '' ? url('uploads/slider_images', $slider_value['image']) : asset('uploads/placeholder/placeholder.png');
                $get_slider_language = PageSlidersLanguage::where('pages_slider_id', $slider_value['id'])
                    ->where('language_id', $request->language)
                    ->where('page', 'blog_page')
                    ->first();
                $get_slider['title']       = '';
                $get_slider['description'] = '';
                if ($get_slider_language) {
                    $get_slider['title']       = $get_slider_language['title'] != '' ? $get_slider_language['title'] : '';
                    $get_slider['description'] = $get_slider_language['description'] != '' ? $get_slider_language['description'] : '';
                }
                $get_blogs_page['slider_images'][] = $get_slider;
            }
        }
        // Slider images End


        /*Featured Destination*/
        $get_blogs_page['featured_destination'] = [];
        $get_featured_dest = Blogpagefeatured::where('blog_id', 1)
            ->orderBy('id', 'desc')
            ->limit(6)
            ->get();
        if (!$get_featured_dest->isEmpty()) {
            foreach ($get_featured_dest as $Blog_key => $Blog_value) {

                $get_feature          = [];
                $get_feature['id']    = $Blog_value['id'];
                $get_feature['key']   = $Blog_key;
                $get_feature['image'] = $Blog_value['blog_featured_image'] != '' ? url('uploads/BlogPage', $Blog_value['blog_featured_image']) : '';
                $get_feature_language = BlogpagefeaturedLanguage::where('blog_featured_id', $Blog_value['id'])
                    ->where('language_id', $request->language)
                    ->first();
                $get_feature['title']       = '';
                if ($get_feature_language) {
                    $get_feature['title']       = $get_feature_language['featured_title'] != '' ? $get_feature_language['featured_title'] : '';
                }
                $get_blogs_page['featured_destination'][] = $get_feature;
            }
        }


        /*Featured Destination*/

        $output['status'] = true;
        $output['data'] = $get_blogs_page;
        return json_encode($output);
    }

    //Blogs Page Detail
    public function get_blogs_page_details(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'Data Not Found';
        $validation = Validator::make($request->all(), [
            'language' => 'required',
            'blog_id' => 'required',
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
        $get_blog = Blog::where(['slug' => $request->blog_id, 'status' => 'Active'])->first();
        if ($get_blog) {
            $settings = [];
            $settings['blog_image'] = $get_blog['image'] != '' ? url('uploads/blogs/' . $get_blog['image']) : asset('uploads/placeholder/placeholder.png');
            $settings['thumnail_image'] = $get_blog['thumnail_image'] != '' ? url('uploads/blogs/' . $get_blog['thumnail_image']) : asset('uploads/placeholder/placeholder.png');
            $settings['video']      =  $get_blog['video'] != '' ? url('uploads/blogs/' . $get_blog['video']) : '';

            $get_blog_page_language = BlogLanguage::where('blog_id', $get_blog->id)
                ->where('language_id', $request->language)
                ->first();

            $settings['title'] = '';
            $settings['description'] = '';
            $settings['date'] = date('M d,Y', strtotime($get_blog['date']));

            if ($get_blog_page_language) {
                $settings['title'] = $get_blog_page_language['title'];
                $settings['description'] = $get_blog_page_language['description'];
            }

            $data['settings'] = $settings;

            // Addtional details
            $data['blog_additional_details'] = [];
            $get_addtional_details = BlogAditionalHeadline::where('blog_id', $get_blog->id)
                ->get();
            if (!$get_addtional_details->isEmpty()) {
                foreach ($get_addtional_details as $key => $value) {
                    $get_add = [];
                    $get_add['id'] = $value['id'];
                    $get_add['image'] = $value['image'] != '' ? url('uploads/blogs', $value['image']) : asset('uploads/placeholder/placeholder.png');

                    $get_addtional_language = BlogAditionalLanguage::where('blog_id', $get_blog->id)
                        ->where('blog_aditional_id', $value['id'])
                        ->where('language_id', $request->language)
                        ->first();
                    $get_add['title'] = '';
                    $get_add['description'] = '';
                    if ($get_addtional_language) {
                        $get_add['title'] = $get_addtional_language['title'] != '' ? $get_addtional_language['title'] : '';
                        $get_add['description'] = $get_addtional_language['description'] != '' ? $get_addtional_language['description'] : '';
                    }
                    $data['blog_additional_details'][] = $get_add;
                }
            }

            // Popular posts
            $data['popular_posts'] = [];
            $popular_posts = Blog::orderBy('id', 'desc')
                ->limit(5)
                ->get();
            if (!$popular_posts->isEmpty()) {
                foreach ($popular_posts as $key => $value) {
                    $get_add = [];
                    $get_add['id']    = $value['id'];
                    $get_add['slug']  = $value['slug'];
                    $get_add['image'] = $value['image'] != '' ? url('uploads/blogs', $value['image']) : asset('uploads/placeholder/placeholder.png');

                    $popular_posts_language = BlogLanguage::where('blog_id', $value['id'])
                        ->where('language_id', $request->language)
                        ->first();
                    $get_add['date']  = date('d-m-Y', strtotime($value['date']));
                    $get_add['title'] = '';
                    if ($popular_posts_language) {
                        $get_add['title'] = $popular_posts_language['title'] != '' ? $popular_posts_language['title'] : '';
                    }
                    $data['popular_posts'][] = $get_add;
                }
            }

            $output['status'] = true;
            $output['data'] = $data;
            $output['message'] = 'Single Blog details';
        } else {
            $output['status'] = false;
            $output['message'] = 'No Data Found';
        }

        return json_encode($output);
    }

    //Get About us Page
    public function get_about_us_page_data(Request $request)
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
        $get_aboutpage = AboutUsPage::where('status', 'Active')->first();
        if ($get_aboutpage) {
            $settings = [];
            $settings['banner_image'] = url('uploads/AboutUsPage/' . $get_aboutpage['banner_image']);
            $settings['vision_image'] = url('uploads/AboutUsPage/' . $get_aboutpage['vision_image']);
            $settings['detail_image'] = url('uploads/AboutUsPage/' . $get_aboutpage['detail_image']);

            $get_about_page_language = AboutUsPageLanguage::where('about_us_page_id', $get_aboutpage->id)
                ->where('language_id', $request->language)
                ->first();

            $settings['title'] = '';
            $settings['description'] = '';
            $settings['vision_title'] = '';
            $settings['vision_description'] = '';
            $settings['detail_title'] = '';
            $settings['detail_description'] = '';
            $settings['service_heading_title'] = '';

            if ($get_about_page_language) {
                $settings['title'] = $get_about_page_language['title'];
                $settings['description'] = $get_about_page_language['description'];
                $settings['vision_title'] = $get_about_page_language['vision_title'];
                $settings['vision_description'] = $get_about_page_language['vision_description'];
                $settings['detail_title'] = $get_about_page_language['detail_title'];
                $settings['detail_description'] = $get_about_page_language['detail_description'];

                $settings['service_heading_title'] = $get_about_page_language['service_heading_title'];
            }

            $data['settings'] = $settings;

            // Slider Images
            // $data['banners'] = [];
            // $get_about_banners = AboutUsPageSliderImage::where('about_us_page_id', $get_aboutpage->id)->get();
            // if (!$get_about_banners->isEmpty()) {
            //     foreach ($get_about_banners as $key => $value) {
            //         $data['banners'][] = $value['slider_images'] != '' ? url('uploads/AboutUsPage', $value['slider_images']) : asset('uploads/placeholder/placeholder.png');
            //     }
            // }

            // Facility
            $data['facilities'] = [];
            $get_about_page_facility = AboutUsPagefacility::where('about_us_page_id', $get_aboutpage->id)
                ->orderBy('id', 'desc')
                ->get();
            if (!$get_about_page_facility->isEmpty()) {
                foreach ($get_about_page_facility as $key => $facility_value) {
                    $get_facility = [];
                    $get_facility['id'] = $facility_value['id'];
                    $get_facility['icon'] = $facility_value['facility_image'] != '' ? url('uploads/AboutUsPage', $facility_value['facility_image']) : asset('uploads/placeholder/placeholder.png');
                    $get_page_facility_language = AboutUsPagefacilityLanguage::where('about_us_page_id', $get_aboutpage->id)
                        ->where('about_page_facility_id', $facility_value['id'])
                        ->where('language_id', $request->language)
                        ->first();
                    $get_facility['title'] = '';
                    $get_facility['description'] = '';

                    if ($get_page_facility_language) {
                        $get_facility['title'] = $get_page_facility_language['facility_title'] != '' ? $get_page_facility_language['facility_title'] : '';
                        $get_facility['description'] = $get_page_facility_language['facility_description'] != '' ? $get_page_facility_language['facility_description'] : '';
                    }
                    $data['facilities'][] = $get_facility;
                }
            }

            // why choose
            $data['choose'] = [];
            $get_about_page_choose = AboutUsPagechoose::where('about_us_page_id', $get_aboutpage->id)
                ->orderBy('id', 'desc')
                ->get();
            if (!$get_about_page_choose->isEmpty()) {
                foreach ($get_about_page_choose as $key => $choose_value) {
                    $get_choose = [];
                    $get_choose['id'] = $choose_value['id'];
                    $get_choose['icon'] = $choose_value['choose_image'] != '' ? url('uploads/AboutUsPage', $choose_value['choose_image']) : asset('uploads/placeholder/placeholder.png');
                    $get_page_choose_language = AboutUsPagechooseLanguage::where('about_us_page_id', $get_aboutpage->id)
                        ->where('about_page_choose_id', $choose_value['id'])
                        ->where('language_id', $request->language)
                        ->first();
                    $get_choose['title'] = '';
                    $get_choose['description'] = '';
                    if ($get_page_choose_language) {
                        $get_choose['title'] = $get_page_choose_language['choose_title'] != '' ? $get_page_choose_language['choose_title'] : '';
                        $get_choose['description'] = $get_page_choose_language['choose_description'] != '' ? $get_page_choose_language['choose_description'] : '';
                    }
                    $data['choose'][] = $get_choose;
                }
            }

            // Banner Overview
            $data['banner_overview'] = [];
            $get_about_banner_overview = BannerOverview::where('page', 'about_us_page')->get();
            if (!$get_about_banner_overview->isEmpty()) {
                foreach ($get_about_banner_overview as $key => $banner_value) {
                    $get_choose = [];
                    $get_choose['id'] = $banner_value['id'];
                    $get_choose['image'] = $banner_value['image'] != '' ? url('uploads/AboutUsPage', $banner_value['image']) : asset('uploads/placeholder/placeholder.png');
                    $get_banner_language = BannerOverviewLanguage::where('overview_id', $banner_value['id'])
                        ->where('langauge_id', $request->language)
                        ->first();
                    $get_choose['title'] = '';
                    if ($get_banner_language) {
                        $get_choose['title'] = $get_banner_language['title'] != '' ? $get_banner_language['title'] : '';
                    }
                    $data['banner_overview'][] = $get_choose;
                }
            }


            // Slider images
            $data['slider_images'] = [];
            $get_sliders = PageSliders::where('page', 'about_us_page')
                ->get();
            if (!$get_sliders->isEmpty()) {
                foreach ($get_sliders as $key => $slider_value) {
                    $get_slider          = [];
                    $get_slider['id']    = $slider_value['id'];
                    $get_slider['image'] = $slider_value['image'] != '' ? url('uploads/slider_images', $slider_value['image']) : asset('uploads/placeholder/placeholder.png');
                    $get_slider_language = PageSlidersLanguage::where('pages_slider_id', $slider_value['id'])
                        ->where('language_id', $request->language)
                        ->where('page', 'about_us_page')
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


            // Services
            $data['services'] = [];
            $get_about_page_choose = AboutUsPageService::where('about_us_page_id', $get_aboutpage->id)
                ->orderBy('id', 'desc')
                ->get();
            if (!$get_about_page_choose->isEmpty()) {
                foreach ($get_about_page_choose as $key => $service_value) {
                    $get_service = [];
                    $get_service['id'] = $service_value['id'];

                    $get_page_service_language = AboutUsPageServiceLanguage::where('about_us_page_id', $get_aboutpage->id)
                        ->where('about_us_services_id', $service_value['id'])
                        ->where('language_id', $request->language)
                        ->first();
                    $get_service['title'] = '';
                    if ($get_page_service_language) {
                        $get_service['title'] = $get_page_service_language['service_title'] != '' ? $get_page_service_language['service_title'] : '';
                    }
                    $data['services'][] = $get_service;
                }
            }


            $output['status'] = true;
            $output['data'] = $data;
            $output['message'] = 'About Page Data ';
        } else {
            $output['status'] = false;
            $output['message'] = 'No Data Found';
        }

        return json_encode($output);
    }

    //Get Adverisment us Page
    public function get_advertisment_us_page_data(Request $request)
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
        $get_advertisment = AdvertismentPage::where('status', 'Active')->first();
        if ($get_advertisment) {
            $settings = [];
            $settings['banner_image'] = url('uploads/advertisment_page/' . $get_advertisment['banner_image']);
            $settings['choose_image'] = url('uploads/advertisment_page/' . $get_advertisment['choose_image']);

            $get_advertisment_page_language = AdvertismentPageLanguage::where('advertisment_page_id', $get_advertisment->id)
                ->where('language_id', $request->language)
                ->first();

            $settings['title'] = '';
            $settings['short_description'] = '';
            $settings['description'] = '';
            $settings['advertise_with_us_title'] = '';
            $settings['advertise_with_us_desc'] = '';
            $settings['why_choose_title']       = '';
            $settings['footer_text']            = '';
            $settings['footer_description']     = '';

            if ($get_advertisment_page_language) {
                $settings['title']                   = $get_advertisment_page_language['title'];
                $settings['short_description']       = $get_advertisment_page_language['short_description'];
                $settings['description']             = $get_advertisment_page_language['description'];
                $settings['advertise_with_us_title'] = $get_advertisment_page_language['advertise_with_us_title'];
                $settings['advertise_with_us_desc']  = $get_advertisment_page_language['advertise_with_us_desc'];
                $settings['why_choose_title']        = $get_advertisment_page_language['why_choose_title'];
                $settings['footer_text']             = $get_advertisment_page_language['footer_text'];
                $settings['footer_description']      = $get_advertisment_page_language['footer_description'];
            }

            $data['settings'] = $settings;

            // Banner Overview
            $data['banner_overview'] = [];
            $get_advertisment_banner_overview = BannerOverview::where('page', 'advertisment_us_page')->get();
            if (!$get_advertisment_banner_overview->isEmpty()) {
                foreach ($get_advertisment_banner_overview as $key => $banner_value) {
                    $get_banner = [];
                    $get_banner['id'] = $banner_value['id'];
                    $get_banner['image'] = $banner_value['image'] != '' ? url('uploads/advertisment_page/banner_overview', $banner_value['image']) : asset('uploads/placeholder/placeholder.png');
                    $get_banner_language = BannerOverviewLanguage::where('overview_id', $banner_value['id'])
                        ->where('langauge_id', $request->language)
                        ->first();
                    $get_banner['title'] = '';
                    if ($get_banner_language) {
                        $get_banner['title'] = $get_banner_language['title'] != '' ? $get_banner_language['title'] : '';
                    }
                    $data['banner_overview'][] = $get_banner;
                }
            }

            // Facility
            $data['facilities'] = [];
            $get_advertisment_page_facility = AdvertiseWithUs::where('advertisment_page_id', $get_advertisment->id)
                ->orderBy('sort_order', 'asc')
                ->get();

            foreach ($get_advertisment_page_facility as $key => $facility_value) {
                $get_facility = [];
                $get_facility['id']           = $facility_value['id'];
                $get_facility['sort_order']   = $facility_value['sort_order'];
                $get_facility['icon'] = $facility_value['image'] != '' ? url('uploads/advertisment_page', $facility_value['image']) : asset('uploads/placeholder/placeholder.png');
                $get_page_facility_language = AdvertiseWithUsLanguage::where('advertisment_page_id', $get_advertisment->id)
                    ->where('advertise_with_us_id', $facility_value['id'])
                    ->where('language_id', $request->language)
                    ->first();

                $get_facility['title'] = '';
                $get_facility['description'] = '';

                if ($get_page_facility_language) {
                    $get_facility['title'] = $get_page_facility_language['title'] != '' ? $get_page_facility_language['title'] : '';
                    $get_facility['description'] = $get_page_facility_language['description'] != '' ? $get_page_facility_language['description'] : '';
                }
                $data['facilities'][] = $get_facility;
            }

            // why choose
            $data['choose'] = [];
            $get_advertise_page_choose = AdvertisePagechoose::where('advertisment_page_id', $get_advertisment->id)
                ->orderBy('choose_sort_order', 'asc')
                ->get();
            if (!$get_advertise_page_choose->isEmpty()) {
                foreach ($get_advertise_page_choose as $key => $choose_value) {
                    $get_choose = [];
                    $get_choose['id']               = $choose_value['id'];
                    $get_choose['sort_order']       = $choose_value['choose_sort_order'];
                    $get_page_choose_language = AdvertisePagechooseLanguage::where('advertisment_page_id', $get_advertisment->id)
                        ->where('advertise_choose_id', $choose_value['id'])
                        ->where('language_id', $request->language)
                        ->first();
                    $get_choose['description'] = '';
                    if ($get_page_choose_language) {
                        $get_choose['description'] = $get_page_choose_language['description'] != '' ? $get_page_choose_language['description'] : '';
                    }
                    $data['choose'][] = $get_choose;
                }
            }

            // Slider images
            $data['slider_images'] = [];
            $get_sliders = PageSliders::where('page', 'advertisement_page')
                ->get();
            if (!$get_sliders->isEmpty()) {
                foreach ($get_sliders as $key => $slider_value) {
                    $get_slider          = [];
                    $get_slider['id']    = $slider_value['id'];
                    $get_slider['image'] = $slider_value['image'] != '' ? url('uploads/slider_images', $slider_value['image']) : asset('uploads/placeholder/placeholder.png');
                    $get_slider_language = PageSlidersLanguage::where('pages_slider_id', $slider_value['id'])
                        ->where('language_id', $request->language)
                        ->where('page', 'advertisement_page')
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

            $output['status'] = true;
            $output['data'] = $data;
            $output['message'] = 'Advertisment Page Data ';
        } else {
            $output['status'] = false;
            $output['message'] = 'No Data Found';
        }

        return json_encode($output);
    }

    //Get Join us Page
    public function get_join_us_page_data(Request $request)
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
        $get_joinus = JoinPage::where('status', 'Active')->first();
        if ($get_joinus) {
            $settings = [];
            $settings['banner_image'] = url('uploads/join_page/' . $get_joinus['banner_image']);
            $settings['become_partner_image'] = url('uploads/join_page/' . $get_joinus['become_partner_image']);

            $get_join_page_language = JoinPageLanguage::where('join_page_id', $get_joinus->id)
                ->where('language_id', $request->language)
                ->first();

            $settings['title'] = '';
            $settings['short_description'] = '';
            $settings['description'] = '';
            $settings['become_partner_title'] = '';
            $settings['become_partner_description'] = '';

            if ($get_join_page_language) {
                $settings['title'] = $get_join_page_language['title'];
                $settings['short_description'] = $get_join_page_language['short_description'];
                $settings['description'] = $get_join_page_language['description'];
                $settings['become_partner_title'] = $get_join_page_language['become_partner_title'];
                $settings['become_partner_description'] = $get_join_page_language['become_partner_description'];
            }

            $data['settings'] = $settings;

            // Banner Overview
            $data['banner_overview'] = [];
            $get_join_banner_overview = BannerOverview::where('page', 'join_us_page')->get();
            if (!$get_join_banner_overview->isEmpty()) {
                foreach ($get_join_banner_overview as $key => $banner_value) {
                    $get_banner = [];
                    $get_banner['id'] = $banner_value['id'];
                    $get_banner['image'] = $banner_value['image'] != '' ? url('uploads/join_page/banner_overview', $banner_value['image']) : asset('uploads/placeholder/placeholder.png');
                    $get_banner_language = BannerOverviewLanguage::where('overview_id', $banner_value['id'])
                        ->where('langauge_id', $request->language)
                        ->first();
                    $get_banner['title'] = '';
                    if ($get_banner_language) {
                        $get_banner['title'] = $get_banner_language['title'] != '' ? $get_banner_language['title'] : '';
                    }
                    $data['banner_overview'][] = $get_banner;
                }
            }

            // why choose
            $data['why_join'] = [];
            $get_join_page_choose = JoinPagechoose::where('join_page_id', $get_joinus->id)
                ->orderBy('id', 'asc')
                ->limit(3)
                ->get();
            if (!$get_join_page_choose->isEmpty()) {
                foreach ($get_join_page_choose as $key => $choose_value) {
                    $get_choose = [];
                    $get_choose['id']    = $choose_value['id'];
                    $get_choose['image'] = $choose_value['choose_image'] != '' ? url('uploads/join_page', $choose_value['choose_image']) : asset('uploads/placeholder/placeholder.png');

                    $get_page_choose_language = JoinPagechooseLanguage::where('join_page_id', $get_joinus->id)
                        ->where('join_choose_id', $choose_value['id'])
                        ->where('language_id', $request->language)
                        ->first();
                    $get_choose['description'] = '';
                    if ($get_page_choose_language) {
                        $get_choose['title'] = $get_page_choose_language['title'] != '' ? $get_page_choose_language['title'] : '';
                        $get_choose['description'] = $get_page_choose_language['description'] != '' ? $get_page_choose_language['description'] : '';
                    }
                    $data['why_join'][] = $get_choose;
                }
            }

            // Slider images
            $data['slider_images'] = [];
            $get_sliders = PageSliders::where('page', 'join_page')
                ->get();
            if (!$get_sliders->isEmpty()) {
                foreach ($get_sliders as $key => $slider_value) {
                    $get_slider          = [];
                    $get_slider['id']    = $slider_value['id'];
                    $get_slider['image'] = $slider_value['image'] != '' ? url('uploads/slider_images', $slider_value['image']) : asset('uploads/placeholder/placeholder.png');
                    $get_slider_language = PageSlidersLanguage::where('pages_slider_id', $slider_value['id'])
                        ->where('language_id', $request->language)
                        ->where('page', 'join_page')
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


            $output['status'] = true;
            $output['data'] = $data;
            $output['message'] = 'Join Page Data ';
        } else {
            $output['status'] = false;
            $output['message'] = 'No Data Found';
        }

        return json_encode($output);
    }

    //Get LImousine  Page
    public function get_limousine_page_data(Request $request)
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
        $data['side_banner']   = '';
        $SideBanner            = MetaGlobalLanguage::where('meta_title', 'limousine_side_banner')->where('status','Active')->first();
        if($SideBanner){
            $data['side_banner']            = url('uploads/side_banner',$SideBanner['image']);
        }

        // Slider images
        $data['slider_images'] = [];
        $get_sliders = PageSliders::where('page', 'limousine_page')
            ->get();
        if (!$get_sliders->isEmpty()) {

            foreach ($get_sliders as $key => $slider_value) {
                $get_slider          = [];
                $get_slider['id']    = $slider_value['id'];
                $get_slider['image'] = $slider_value['image'] != '' ? url('uploads/slider_images', $slider_value['image']) : asset('uploads/placeholder/placeholder.png');
                $get_slider_language = PageSlidersLanguage::where('pages_slider_id', $slider_value['id'])
                    ->where('language_id', $request->language)
                    ->where('page', 'limousine_page')
                    ->first();
                $get_slider['title'] = '';
                $get_slider['description'] = '';
                if ($get_slider_language) {
                    $get_slider['title']       = $get_slider_language['title'] != '' ? $get_slider_language['title'] : '';
                    $get_slider['description'] = $get_slider_language['description'] != '' ? $get_slider_language['description'] : '';
                }
                $data['slider_images'][] = $get_slider;
            }


            $output['status'] = true;
            $output['data'] = $data;
            $output['message'] = 'Limousine Page Data ';
        } 
        // Slider images End


        return json_encode($output);
    }

    //Get Yacht  Page
    public function get_yacht_page_data(Request $request)
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

        $data['side_banner']   = '';
        $SideBanner            = MetaGlobalLanguage::where('meta_title', 'yacht_side_banner')->where('status','Active')->first();
        if($SideBanner){
            $data['side_banner']            = url('uploads/side_banner',$SideBanner['image']);
        }

        // Slider images
        $data['slider_images'] = [];
        $get_sliders = PageSliders::where('page', 'yacht_page')
            ->get();
        if (!$get_sliders->isEmpty()) {
            foreach ($get_sliders as $key => $slider_value) {
                $get_slider          = [];
                $get_slider['id']    = $slider_value['id'];
                $get_slider['image'] = $slider_value['image'] != '' ? url('uploads/slider_images', $slider_value['image']) : asset('uploads/placeholder/placeholder.png');
                $get_slider_language = PageSlidersLanguage::where('pages_slider_id', $slider_value['id'])
                    ->where('language_id', $request->language)
                    ->where('page', 'yacht_page')
                    ->first();
                $get_slider['title'] = '';
                $get_slider['description'] = '';
                if ($get_slider_language) {
                    $get_slider['title']       = $get_slider_language['title'] != '' ? $get_slider_language['title'] : '';
                    $get_slider['description'] = $get_slider_language['description'] != '' ? $get_slider_language['description'] : '';
                }
                $data['slider_images'][] = $get_slider;
            }

            $output['status'] = true;
            $output['data'] = $data;
            $output['message'] = 'Yacht Page Data ';
        } else {
            $output['status'] = false;
            $output['message'] = 'No Data Found';
        }

        // Slider images End



        return json_encode($output);
    }

    //Get Partner us Page
    public function get_partner_page_data(Request $request)
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
        $get_partnerpage = PartnerPage::where('status', 'Active')->first();
        if ($get_partnerpage) {
            $settings = [];
            $settings['banner_image'] = url('uploads/PartnerPage/' . $get_partnerpage['banner_image']);

            $get_partner_page_language = PartnerPageLanguage::where('partner_page_id', $get_partnerpage->id)
                ->where('language_id', $request->language)
                ->first();

            $settings['title'] = '';
            $settings['description'] = '';
            $settings['activity_title'] = '';
            $settings['why_book_title'] = '';
            $settings['facilities_heading_title'] = '';
            $settings['facilities_heading_description'] = '';

            if ($get_partner_page_language) {
                $settings['title'] = $get_partner_page_language['title'];
                $settings['description'] = $get_partner_page_language['description'];
                $settings['activity_title'] = $get_partner_page_language['activity_title'];
                $settings['why_book_title'] = $get_partner_page_language['why_book_title'];
                $settings['facilities_heading_title'] = $get_partner_page_language['facilities_heading_title'];
                $settings['facilities_heading_description'] = $get_partner_page_language['facilities_heading_description'];
            }

            $data['settings'] = $settings;

            // Facility
            $data['facilities'] = [];
            $get_partner_page_facility = PartnerPageFacility::where('partner_page_id', $get_partnerpage->id)
                ->orderBy('id', 'desc')
                ->get();
            if (!$get_partner_page_facility->isEmpty()) {
                foreach ($get_partner_page_facility as $key => $facility_value) {
                    $get_facility = [];
                    $get_facility['id'] = $facility_value['id'];

                    $get_page_facility_language = PartnerPageFacilityLanguage::where('partner_page_id', $get_partnerpage->id)
                        ->where('partner_page_facility_id', $facility_value['id'])
                        ->where('language_id', $request->language)
                        ->first();
                    $get_facility['title'] = '';

                    if ($get_page_facility_language) {
                        $get_facility['title'] = $get_page_facility_language['facility_title'] != '' ? $get_page_facility_language['facility_title'] : '';
                    }
                    $data['facilities'][] = $get_facility;
                }
            }

            // why book
            $data['book'] = [];
            $get_partner_page_book = PartnerPageBook::where('partner_page_id', $get_partnerpage->id)
                ->orderBy('id', 'desc')
                ->get();
            if (!$get_partner_page_book->isEmpty()) {
                foreach ($get_partner_page_book as $key => $choose_value) {
                    $get_choose = [];
                    $get_choose['id'] = $choose_value['id'];
                    $get_choose['book_image'] = $choose_value['book_image'] != '' ? url('uploads/PartnerPage', $choose_value['book_image']) : asset('uploads/placeholder/placeholder.png');
                    $get_page_choose_language = PartnerPageBookLanguage::where('partner_page_id', $get_partnerpage->id)
                        ->where('partner_page_book_id', $choose_value['id'])
                        ->where('language_id', $request->language)
                        ->first();
                    $get_choose['title'] = '';
                    $get_choose['description'] = '';
                    if ($get_page_choose_language) {
                        $get_choose['title'] = $get_page_choose_language['book_title'] != '' ? $get_page_choose_language['book_title'] : '';
                        $get_choose['description'] = $get_page_choose_language['book_description'] != '' ? $get_page_choose_language['book_description'] : '';
                    }
                    $data['book'][] = $get_choose;
                }
            }

            $data['activities_images'] = [];
            $get_page_activities_images = PartnerPageActivitiesImage::where('partner_page_id', $get_partnerpage->id)->get();
            if (!$get_page_activities_images->isEmpty()) {
                foreach ($get_page_activities_images as $key => $value) {
                    $data['activities_images'][] = $value['activity_images'] != '' ? url('uploads/PartnerPage', $value['activity_images']) : asset('uploads/placeholder/placeholder.png');
                }
            }

            // Slider images
            $data['slider_images'] = [];
            $get_sliders = PageSliders::where('page', 'partner_Page')
                ->get();
            if (!$get_sliders->isEmpty()) {
                foreach ($get_sliders as $key => $slider_value) {
                    $get_slider          = [];
                    $get_slider['id']    = $slider_value['id'];
                    $get_slider['image'] = $slider_value['image'] != '' ? url('uploads/slider_images', $slider_value['image']) : asset('uploads/placeholder/placeholder.png');
                    $get_slider_language = PageSlidersLanguage::where('pages_slider_id', $slider_value['id'])
                        ->where('language_id', $request->language)
                        ->where('page', 'partner_Page')
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

            $output['status'] = true;
            $output['data'] = $data;
            $output['message'] = 'Partner Page Data ';
        } else {
            $output['status'] = false;
            $output['message'] = 'No Data Found';
        }

        return json_encode($output);
    }

    public function getProductArr($arr, $language_id, $user_id = '')
    {
        $get_arr = [];
        foreach ($arr as $key => $value) {
            $get_product = [];
            $title = '';
            $main_description = '';
            $short_description = '';
            $value_productLang = ProductLanguage::where(['product_id' => $value['id'], 'language_id' => $language_id])->first();
            if ($value_productLang) {
                $title = $value_productLang->description;
                $main_description = $value_productLang->main_description;
                $short_description = $value_productLang->short_description;
            }
            $city = getAllInfo('cities', ['id' => $value['city']], 'name');
            $get_product['id'] = $value['id'];
            $get_product['ratings']        = get_rating($value['id']);
            $get_product['image'] = $value['image'] != '' ? asset('public/uploads/product_images/' . $value['image']) : asset('public/assets/img/no_image.jpeg');
            // $get_product['name'] = $title;
            $get_product['name']              = short_description_limit($title, 35);
            $get_product['short_description'] = short_description_limit($short_description, 50);
            $get_product['full_name']         = $title;

            $get_product['main_description'] = Str::limit($main_description, 60);
            $get_product['city']             = $city;
            $get_product['slug']             = $value['slug'];
            $get_product['total_sold']       = $value['how_many_are_sold']     !== '' ? $value['how_many_are_sold'] : 0;
            $get_product['per_value']        = $value['per_value'];
            $get_product['image_text']       = $value['image_text'] ?? null;
            $get_product['price']            = $value['original_price'] ?? 0;
            $get_product['selling_price']    = $value['selling_price'] ?? 0;
            $get_product['product_type']     = $value['product_type'];
            $get_product['button']           = $value['product_bookable_type'] === 'bookable' ? 'Book Now' : 'On Request';
            $get_product['price_html']       = get_price_front($value['id'], $user_id, $value['product_type']);
            $get_product['link'] = '';
            if ($value['product_type'] == 'excursion') {
                $get_product['link'] = 'activities-detail/' . $value['slug'];
            } elseif ($value['product_type'] == 'yacht') {
                $get_product['link'] = 'yacht-charts-details/' . $value['slug'];
            } elseif ($value['product_type'] == 'lodge') {
                $get_product['link'] = 'lodge-detail/' . $value['slug'];
            } elseif ($value['product_type'] == 'limousine') {
                $get_product['link'] = 'limousine-detail/' . $value['slug'];
            }
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
            $duration = $dura . $approx;
            $get_product['duration'] = $duration;
            $get_product['boat_maximum_capacity'] = $value['boat_maximum_capacity'];
            $get_product['minimum_booking'] = $value['minimum_booking'];
            $get_arr[] = $get_product;
        }
        return $get_arr;
    }

    //GOLF PACKAGE Page Detail
    public function get_golf_page_data(Request $request)
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
        $get_golf_page = GolfPage::where('status', 'Active')->first();
        if ($get_golf_page) {
            $settings = [];

            $get_golf_page_language = GolfPageLanguage::where('golf_page_id', $get_golf_page->id)
                ->where('language_id', $request->language)
                ->first();

            $settings['title'] = '';
            $settings['short_description'] = '';
            $settings['description'] = '';

            if ($get_golf_page_language) {
                $settings['title'] = $get_golf_page_language['title'];
                $settings['short_description'] = $get_golf_page_language['short_description'];
                $settings['description'] = $get_golf_page_language['description'];
            }

            $data['settings'] = $settings;

            // SLIder Images
            $data['slider_images'] = [];
            $get_golf_page_slider = PageSliders::where(['page_id' => $get_golf_page->id, 'page' => 'golf_page'])->get();

            if (!$get_golf_page_slider->isEmpty()) {
                foreach ($get_golf_page_slider as $key => $s_value) {
                    $get_slider = [];
                    $get_slider['id'] = $s_value['id'];
                    $get_slider['image'] = $s_value['image'] != '' ? url('uploads/slider_images', $s_value['image']) : asset('uploads/placeholder/placeholder.png');

                    $data['slider_images'][] = $get_slider;
                }
            }

            // Facility
            $data['golf_page_facilities'] = [];
            $get_golf_page_facility = GolfPageFacility::where('golf_page_id', $get_golf_page->id)
                ->orderBy('id', 'desc')
                ->get();

            if (!$get_golf_page_facility->isEmpty()) {
                foreach ($get_golf_page_facility as $key => $fac_value) {
                    $get_facility = [];
                    $get_facility['id'] = $fac_value['id'];
                    $get_facility['image'] = url('uploads/GolfPage/' . $fac_value['facility_image']);
                    $get_page_facility_language = GolfPageFacilityLanguage::where('golf_page_id', $get_golf_page->id)
                        ->where('golf_page_facility_id', $fac_value['id'])
                        ->where('language_id', $request->language)
                        ->first();
                    $get_facility['title'] = '';
                    $get_facility['description'] = '';
                    if ($get_page_facility_language) {
                        $get_facility['title'] = $get_page_facility_language['facility_title'] != '' ? $get_page_facility_language['facility_title'] : '';
                        $get_facility['description'] = $get_page_facility_language['facility_description'] != '' ? $get_page_facility_language['facility_description'] : '';
                    }
                    $data['golf_page_facilities'][] = $get_facility;
                }
            }

            // Slider images
            $data['slider_images'] = [];
            $get_sliders = PageSliders::where('page', 'golf_page')
                ->get();
            if (!$get_sliders->isEmpty()) {
                foreach ($get_sliders as $key => $slider_value) {
                    $get_slider          = [];
                    $get_slider['id']    = $slider_value['id'];
                    $get_slider['image'] = $slider_value['image'] != '' ? url('uploads/slider_images', $slider_value['image']) : asset('uploads/placeholder/placeholder.png');
                    $get_slider_language = PageSlidersLanguage::where('pages_slider_id', $slider_value['id'])
                        ->where('language_id', $request->language)
                        ->where('page', 'golf_page')
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



            $output['status'] = true;
            $output['data'] = $data;
            $output['message'] = 'Golf Page Data ';
        } else {
            $output['status'] = false;
            $output['message'] = 'No Data Found';
        }

        return json_encode($output);
    }

    // STATIC -----------------------------------------------------------------

    //Get Tour list Page
    public function get_tour_list_page_data(Request $request)
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

        $language = $request->language;

        // $data = [];
        // $get_joinus = JoinPage::where('status', 'Active')->first();
        // if ($get_joinus) {
        $settings = [];

        $LodgeTour = LodgeTour::where('page', 'tour')->first();
        $GetBannerOverviewLanguage = BannerOverviewLanguage::where(['page' => 'tour_banner', 'langauge_id' => $language])->first();
        if ($GetBannerOverviewLanguage) {
            $banner_img = BannerOverview::where('page', 'tour_banner')->first()->image ?? '';
            $settings['banner_image'] = url('uploads/placeholder/placeholder.png');
            if ($banner_img != '') {
                $settings['banner_image'] = asset('uploads/tour_banner/banner_overview/' . $banner_img);
            }
            $settings['title']             = $GetBannerOverviewLanguage->title ?? '';
            $settings['short_description'] = $GetBannerOverviewLanguage->description ?? '';
            $description                   = LodgeTourLanguage::where(['page' => 'tour', 'langauge_id' => $language])->first()->description ?? '';
            $settings['description']       = $description;
            $settings['link']              = $LodgeTour->link ?? '';
        }

        $get_best_selling_tour = ProductSetting::select('product_settings.*', 'products.*')
            ->leftJoin('products', 'products.id', 'product_settings.product_id')
            ->where('status', 'Active')
            ->where(['meta_title' => 'city_best_selling_tour', 'meta_value' => 1]);



        if (isset($request->country)) {
            $is_filter = true;
            $country   = $request->country;
            if ($country > 0 && $country != '') {
                $get_best_selling_tour      = $get_best_selling_tour->where('products.country', $country);
            }
        }

        if (isset($request->city)) {
            $is_filter = true;
            $city      = $request->city;
            if ($city > 0 && $city != '' && is_numeric($city)) {
                $get_best_selling_tour = $get_best_selling_tour->where('products.city', $city);
            }
        }

        $get_best_selling_tour = $get_best_selling_tour->orderBy('products.id', 'desc')
            ->groupBy('product_id')
            ->get();
        $data['best_selling_tour'] = [];

        if (!$get_best_selling_tour->isEmpty()) {
            $data['best_selling_tour'] = $this->getProductArr($get_best_selling_tour, $language, $request->user_id);
        }

        $MetaGlobalLanguageBEST_SELLING = MetaGlobalLanguage::where(['meta_title' => 'best_selling_tour', 'language_id' => $language])->first()->title ?? '';
        $data['best_selling_tour_heading'] = $MetaGlobalLanguageBEST_SELLING;

        // $data['best_selling_tour'] = $get_best_selling_tour;

        // $get_join_page_language = JoinPageLanguage::where('join_page_id', $get_joinus->id)
        //     ->where('language_id', $request->language)
        //     ->first();

        // if ($get_join_page_language) {
        //     $settings['title']                  = $get_join_page_language['title'];
        //     $settings['short_description']      = $get_join_page_language['short_description'];
        //     $settings['description']            = $get_join_page_language['description'];
        //     $settings['become_partner_title']   = $get_join_page_language['become_partner_title'];
        //     $settings['become_partner_description'] = $get_join_page_language['become_partner_description'];
        // }

        $data['settings'] = $settings;

        // why choose
        $data['journey_slider'] = [];

        $journey_arr = [];
        $journey = [];
        $journey['id'] = 1;
        $journey['image'] = url('uploads/placeholder/placeholder.png');
        $journey['title'] = 'Excursions';
        $journey_arr[] = $journey;

        $journey = [];
        $journey['id'] = 2;
        $journey['image'] = url('uploads/placeholder/placeholder.png');
        $journey['title'] = 'Excursions 2';
        $journey_arr[] = $journey;

        $journey = [];
        $journey['id'] = 3;
        $journey['image'] = url('uploads/placeholder/placeholder.png');
        $journey['title'] = 'Desert 3';
        $journey_arr[] = $journey;

        $data['journey_slider'] = $journey_arr;


        // Slider images
        $data['slider_images'] = [];
        $get_sliders = PageSliders::where('page', 'tour_page')
            ->get();
        if (!$get_sliders->isEmpty()) {
            foreach ($get_sliders as $key => $slider_value) {
                $get_slider          = [];
                $get_slider['id']    = $slider_value['id'];
                $get_slider['image'] = $slider_value['image'] != '' ? url('uploads/slider_images', $slider_value['image']) : asset('uploads/placeholder/placeholder.png');
                $get_slider_language = PageSlidersLanguage::where('pages_slider_id', $slider_value['id'])
                    ->where('language_id', $request->language)
                    ->where('page', 'tour_page')
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


        $data['side_banner']   = '';
        $SideBanner            = MetaGlobalLanguage::where('meta_title', 'tourpage_side_banner')->where('status','Active')->first();
        if($SideBanner){
            $data['side_banner']            = url('uploads/side_banner',$SideBanner['image']);
        }


        $output['status'] = true;
        $output['data'] = $data;
        $output['message'] = 'Tour List Page Data ';
        // } else {
        //     $output['status'] = false;
        //     $output['message'] = 'No Data Found';
        // }

        return json_encode($output);
    }

    //Get Lodge list Page
    public function get_lodge_list_page_data(Request $request)
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
        $language = $request->language;

        $settings = [];

        $LodgeTour = LodgeTour::where('page', 'lodge')->first();
        if ($LodgeTour) {
            $description = LodgeTourLanguage::where(['page' => 'lodge', 'langauge_id' => $language])->first()->description ?? '';
            $settings['description'] = $description;
            $settings['link'] = $LodgeTour->link ?? '';
            $settings['link'] = $LodgeTour->link ?? '';
        }
        $GetBannerOverviewLanguage = BannerOverviewLanguage::where(['page' => 'lodge_banner', 'langauge_id' => $language])->first();
        if ($GetBannerOverviewLanguage) {
            $banner_img = BannerOverview::where('page', 'lodge_banner')->first()->image ?? '';
            $settings['banner_image'] = url('uploads/placeholder/placeholder.png');
            if ($banner_img != '') {
                $settings['banner_image'] = asset('uploads/lodge_banner/banner_overview/' . $banner_img);
            }
            $settings['title'] = $GetBannerOverviewLanguage->title ?? '';
            $settings['short_description'] = $GetBannerOverviewLanguage->description ?? '';
        }

        $data['settings'] = $settings;

        // why choose
        $data['journey_slider'] = [];

        $journey_arr = [];
        $journey = [];
        $journey['id'] = 1;
        $journey['image'] = url('uploads/placeholder/placeholder.png');
        $journey['title'] = 'Lodge';
        $journey_arr[] = $journey;

        $journey = [];
        $journey['id'] = 2;
        $journey['image'] = url('uploads/placeholder/placeholder.png');
        $journey['title'] = 'Lodge 2';
        $journey_arr[] = $journey;

        $journey = [];
        $journey['id'] = 3;
        $journey['image'] = url('uploads/placeholder/placeholder.png');
        $journey['title'] = 'Lodge 3';
        $journey_arr[] = $journey;

        $data['journey_slider'] = $journey_arr;

        $best_selling_lodge = ProductSetting::select('product_settings.*', 'products.*')
            ->leftJoin('products', 'products.id', 'product_settings.product_id')
            ->where('status', 'Active')
            ->where('meta_title', 'best_selling_lodge')
            ->orderBy('products.id', 'desc')
            ->groupBy('product_id')
            ->get();

        $data['best_selling_lodge'] = [];
        $MetaGlobalLanguageBEST_SELLING = MetaGlobalLanguage::where(['meta_title' => 'best_selling_lodge', 'language_id' => $language])->first()->title ?? '';
        $data['best_selling_lodge_heading'] = $MetaGlobalLanguageBEST_SELLING;

        if (!$best_selling_lodge->isEmpty()) {
            $data['best_selling_lodge'] = $this->getProductArr($best_selling_lodge, $language, $request->user_id);
        }


        // Slider images
        $data['slider_images'] = [];
        $get_sliders = PageSliders::where('page', 'lodge_page')
            ->get();
        if (!$get_sliders->isEmpty()) {
            foreach ($get_sliders as $key => $slider_value) {
                $get_slider          = [];
                $get_slider['id']    = $slider_value['id'];
                $get_slider['image'] = $slider_value['image'] != '' ? url('uploads/slider_images', $slider_value['image']) : asset('uploads/placeholder/placeholder.png');
                $get_slider_language = PageSlidersLanguage::where('pages_slider_id', $slider_value['id'])
                    ->where('language_id', $request->language)
                    ->where('page', 'lodge_page')
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


        $data['side_banner']   = '';
        $SideBanner            = MetaGlobalLanguage::where('meta_title', 'lodge_page_side_banner')->where('status','Active')->first();
        if($SideBanner){
            $data['side_banner']            = url('uploads/side_banner',$SideBanner['image']);
        }



        $output['status'] = true;
        $output['data'] = $data;
        $output['message'] = 'Lodge List Page Data';

        return json_encode($output);
    }

    //Get Help Page
    public function help_page_data(Request $request)
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

        $data = array();

        // Slider images
        $data['slides'] = [];
        $get_sliders = PageSliders::where('page', 'help_page')
            ->get();
        if (!$get_sliders->isEmpty()) {
            foreach ($get_sliders as $key => $slider_value) {
                $get_slider          = [];
                $get_slider['id']    = $slider_value['id'];
                $get_slider['image'] = $slider_value['image'] != '' ? url('uploads/slider_images', $slider_value['image']) : asset('uploads/placeholder/placeholder.png');
                $get_slider_language = PageSlidersLanguage::where('pages_slider_id', $slider_value['id'])
                    ->where('language_id', $request->language)
                    ->where('page', 'help_page')
                    ->first();
                $get_slider['title'] = '';
                $get_slider['description'] = '';
                if ($get_slider_language) {
                    $get_slider['title']       = $get_slider_language['title'] != '' ? $get_slider_language['title'] : '';
                    $get_slider['description'] = $get_slider_language['description'] != '' ? $get_slider_language['description'] : '';
                }
                $data['slides'][] = $get_slider;
            }
        }
        // Slider images End

        // $faqs = array();

        // for ($i = 1; $i < 5; $i++) {
        //     $faq = array();
        //     $faq['id'] = (string)$i;
        //     $faq['title'] = 'Booking/site Question';
        //     $faq_datas = array();
        //     for ($j = 1; $j < 6; $j++) {
        //         $faq_data = array();
        //         $faq_data['id'] = (string)$j;
        //         $faq_data['title'] = 'Hi,How we can help you?';
        //         $faq_data['description'] = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.';
        //         $faq_datas[] = $faq_data;
        //     }
        //     $faq['data'] = $faq_datas;
        //     $faqs[] = $faq;
        // }
        // $data['faqs'] = $faqs;

        // HELP FAQS
        $data['help_faqs'] = [];
        $get_help_page_high = HelpPageHighlights::where('help_page_id', 1)
            ->orderBy('id', 'desc')
            ->get();

        if (!$get_help_page_high->isEmpty()) {
            foreach ($get_help_page_high as $key => $fac_value) {
                $get_highlights_arr = [];
                $get_highlights_arr['id'] = $fac_value['id'];
                $get_highlights_language = HelpPageHighlightsLanguage::where('help_page_id', 1)
                    ->where('highlights_id', $fac_value['id'])
                    ->where('language_id', $request->language)
                    ->first();
                $get_highlights_arr['title'] = '';
                if ($get_highlights_language) {
                    $get_highlights_arr['title'] = $get_highlights_language['title'] != '' ? $get_highlights_language['title'] : '';
                }

                // HELP FAQS
                $get_faq_desc = HelpPageLanguage::where('help_page_id', 1)
                    ->where('highlights_id', $fac_value['id'])
                    ->get();

                $get_highlights_arr['help_faqs_description'] = [];
                if (!$get_faq_desc->isEmpty()) {
                    foreach ($get_faq_desc as $key => $faq_value) {
                        $get_faqs_arr = [];
                        $get_faqs_arr['id'] = $faq_value['id'];
                        $get_faqs_language = HelpPageDescriptionLanguage::where('help_page_id', 1)
                            ->where('help_faq_description_id', $faq_value['id'])
                            ->where('language_id', $request->language)
                            ->first();
                        $get_faqs_arr['question'] = '';
                        $get_faqs_arr['answer'] = '';
                        if ($get_faqs_language) {
                            $get_faqs_arr['question']   = $get_faqs_language['title'] != '' ? $get_faqs_language['title'] : '';
                            $get_faqs_arr['answer']     = $get_faqs_language['description'] != '' ? $get_faqs_language['description'] : '';
                        }
                        $get_highlights_arr['help_faqs_description'][] = $get_faqs_arr;
                    }
                }

                $data['help_faqs'][] = $get_highlights_arr;
            }
        }

        $data['heading'] = 'Knowledge base';
        $data['ticket_title'] = 'Submit a ticket';
        $data['ticket_description'] = 'Lorem Ipsum is simply dummy text of the printing';
        $data['ticket_image'] = url('uploads/helppage') . '/ticket_image.png';

        $output['status'] = true;
        $output['data'] = $data;
        $output['message'] = 'Help Page Data ';
        return json_encode($output);
    }


    public function website_information(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = "Data Not Found";
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


        $meta_title =  request()->meta_title;
        $language   = $request->language;

        if ($meta_title == "") {
            $MetaGlobalLanguage = MetaGlobalLanguage::select('meta_title', 'title', 'content')->where(['language_id' => $language, 'meta_parent' => 'pages'])->first();
        } else {
            $MetaGlobalLanguage = MetaGlobalLanguage::select('meta_title', 'title', 'content')->where(['meta_title' => $meta_title, 'language_id' => $language, 'meta_parent' => 'pages'])->get();
        }

        $meta_title =  MetaGlobalLanguage::where(['meta_parent' => 'pages', 'language_id' => 3])->get()->pluck('title', 'meta_title')->toArray();
        if (!empty($MetaGlobalLanguage) > 0 && count($meta_title) > 0) {
            $output['status'] = true;
            $output['message'] = "Data Found";
        }

        $output['data']       = $MetaGlobalLanguage;
        $output['meta_title'] = $meta_title;
        return json_encode($output);
    }

    public function the_insider(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = "Data Not Found";

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

        $Insiders =  Insider::get();
        $all_insiderImages = PageSliders::where('page', 'insider_imgl')->get();
        $language   = $request->language;
        $insider_arr = [];
        if (!empty($Insiders)) {
            foreach ($Insiders as $Insider) {
                $InsiderLanguage =  InsiderLanguage::where(['insider_id' => $Insider['id'], 'language_id' => $language])->first();
                if ($InsiderLanguage) {
                    $get_insider                = [];
                    $get_insider['video']       = $Insider['video_link'] != '' ? $Insider['video_link'] : '';
                    $get_insider['thumnail']    = '';
                    $img =  $Insider['image'] != '' ? asset('uploads/insider/' . $Insider['image']) : asset('uploads/placeholder/placeholder.png');

                    $get_insider['image']       = $img;
                    $get_insider['title']       = '';
                    $get_insider['description'] = '';
                    if ($InsiderLanguage) {
                        $get_insider['title']       = $InsiderLanguage->title;
                        $get_insider['description'] = $InsiderLanguage->description;
                    }
                    $insider_arr[] = $get_insider;
                }
            }
            $output['status'] = true;
            $output['message'] = "Data Found";
        }

        $all_insiderImages = PageSliders::where('page', 'insider_img')->get()->map(function ($insiderImg) {
            return asset('uploads/insider/' . $insiderImg['image']);
        });


        if (!empty($all_insiderImages)) {
            $output['status'] = true;
            $output['message'] = "Data Found";
        }



        $output['data'] = $insider_arr;
        $output['insider_img'] = $all_insiderImages;

        return json_encode($output);
    }



    //Caegory Page
    //Get Category Page
    public function get_category_page(Request $request)
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
        $get_category_data = [];

        // Slider images
        $get_category_data['slider_images'] = [];
        $get_sliders = PageSliders::where('page', 'category_page')
            ->get();
        if (!$get_sliders->isEmpty()) {
            foreach ($get_sliders as $key => $slider_value) {
                $get_slider          = [];
                $get_slider['id']    = $slider_value['id'];
                $get_slider['image'] = $slider_value['image'] != '' ? url('uploads/category_page/slider', $slider_value['image']) : asset('uploads/placeholder/placeholder.png');
                $get_slider_language = PageSlidersLanguage::where('pages_slider_id', $slider_value['id'])
                    ->where('language_id', $request->language)
                    ->where('page', 'category_page')
                    ->first();
                $get_slider['title']       = '';
                $get_slider['description'] = '';
                if ($get_slider_language) {
                    $get_slider['title']       = $get_slider_language['title']       != '' ? $get_slider_language['title'] : '';
                    $get_slider['description'] = $get_slider_language['description'] != '' ? $get_slider_language['description'] : '';
                }
                $get_category_data['slider_images'][] = $get_slider;
            }
        }
        // Slider images End    

        //Excursion Category 
        $get_category_data['categories'] = [];
        $get_categories;
        $get_categories = Product::select('products.id', 'product_categories.category')->join('product_categories', 'product_categories.product_id', '=', 'products.id')->where(['status' => 'Active', 'is_delete' => 0, 'product_type' => 'excursion'])->groupby('product_categories.category')->get();
        foreach ($get_categories as $gckey => $gc_value) {
            $get_cat = [];
            $Category = Category::select('categories.*', 'category_language.description as name')
                ->where('categories.id', $gc_value['category'])
                ->where('categories.status', 'Active')
                ->join('category_language', 'categories.id', '=', 'category_language.category_id')
                ->first();
            if ($Category) {
                $get_cat['id']    = $Category['id'];
                $get_cat['slug']  = $Category['slug'];
                $get_cat['title'] = $Category['name'];
                $get_cat['image'] = $Category['icon'] != '' ? asset('public/uploads/category/' . $Category['icon']) : asset('public/assets/img/no_image.jpg');
                $get_category_data['categories'][] = $get_cat;
            }
        }
        $output['status']  = true;
        $output['data']    = $get_category_data;
        $output['message'] = 'Category Page Data ';
        return json_encode($output);
    }



    //Request Modal Content 
    public function OnRequestModal(Request $request)
    {
        $output = [];

        $validation = Validator::make($request->all(), [
            'product_id' => 'required',
            'type'       => 'required',
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

        $data                   = [];
        $get_product = Product::where('id', $request->product_id)->first();
        if ($get_product) {
            $data['back_image']     = $get_product['popup_image'] != '' ? url('uploads/product_images', $get_product['popup_image']) : asset('uploads/placeholder/placeholder.png');
            $get_product_request_pop_up = ProductRequestPopup::where('type', $request->type)->where('product_id', $request->product_id)->get();

            $data['heading'] = '';
            $data['title'] = '';
            $value_productLang = ProductLanguage::where(['product_id' => $get_product['id'], 'language_id' => $request->language])->first();
            if ($value_productLang->popup_heading) {
                $data['heading'] = $value_productLang->popup_heading;
                $data['title']   = $value_productLang->popup_title;
            }

            $data['bullet_points'] =  [];
            if (!$get_product_request_pop_up->isEmpty()) {
                foreach ($get_product_request_pop_up as $key => $value) {
                    $value_popup_language  = ProductRequestPopupLanguage::where(['request_popup_id' => $value['id'], 'language_id' => $request->language])->first();
                    if ($value_popup_language) {
                        $points                = [];
                        $points                = $value_popup_language['description'];
                        $data['bullet_points'][] = $points;
                    }
                }
            }
            $output['status']       = true;
            $output['data']         = $data;
            $output['messge']       = "Data Fetch Successfully";
        } else {
            $output['status']  = false;
            $output['message'] = 'Record Not Found';
        }


        // $data                   = [];
        // $data['back_image']     = asset('public/uploads/requestModal/image.png');
        // $data['heading']        = "Join Us & Explore A World Of Endless Possibilities.sd";
        // $data['title']          = "Why to sign up with tourtastic?";
        // $points                 = [];
        // $points[]               = "Manage Your Account";
        // $points[]               = "Make Booking";
        // $points[]               = "View / Cancel Booking";
        // $points[]               = "Check Boking History";
        // $points[]               = "Print eTickets";
        // $points[]               = "Access Your Loyalty Point";
        // $data['bullet_points'] = $points;

        return json_encode($output);
    }
}
