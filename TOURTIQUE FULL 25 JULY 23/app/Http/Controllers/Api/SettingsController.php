<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
use App\Models\CityGuidePage;
use App\Models\CityGuidePageLanguage;
use App\Models\CityGuidePageLocations;
use App\Models\MediaPage;
use App\Models\MediaPageLanguage;
use App\Models\MediaMensionSocial;
use App\Models\MediaMensionSocialLanguage;
use App\Models\MediaBlog;
use App\Models\MediaBlogLanguage;
use App\Models\MediaPageArticle;
use App\Models\MediaPageArticleLanguage;
use App\Models\ContactSetting;
use App\Models\ContactSettingLanguage;
use App\Models\MetaGlobalLanguage;
use App\Models\BannerOverview;
use App\Models\BannerOverviewLanguage;
use App\Models\ProductCheckoutGiftCard;

use App\Models\Partners;
use App\Models\PartnerImage;
use App\Models\PartnerLanguage;

use App\Models\Testimonials;
use App\Models\TestimonialsLanguage;

use App\Models\CouponCode;
use App\Models\ProductCheckout;

use App\Models\SupportDetails;
use App\Models\JoinUsDetails;
use App\Models\FireBaseToken;


use Carbon\Carbon;

class SettingsController extends Controller
{

    //Setting Why Book With Us && Need Help Contacts
    public function  get_information(Request $request)
    {
        $output            = [];
        $output['status']  = false;
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
        $language        = $request->language;
        $get_information = [];
        $get_contact     = ContactSetting::where('status', 'Active')->first();
        if ($get_contact) {
            $get_information['contact_number_1']  = $get_contact['contact_number_1']  != '' ? $get_contact['contact_number_1']  : '';
            $get_information['contact_number_2']  = $get_contact['contact_number_2']  != '' ? $get_contact['contact_number_2']  : '';
            $get_information['whatsapp_number_1'] = $get_contact['whatsapp_number_1'] != '' ? $get_contact['whatsapp_number_1'] : '';
            $get_information['whatsapp_number_2'] = $get_contact['whatsapp_number_2'] != '' ? $get_contact['whatsapp_number_2'] : '';
            $get_information['email_address_1']   = $get_contact['email_address_1']   != '' ? $get_contact['email_address_1']   : '';
            $get_information['email_address_2']   = $get_contact['email_address_2']   != '' ? $get_contact['email_address_2']   : '';
            $get_information['address']           = '';
            $get_information['why_book_with_us']  = '';

            $get_contact_lang  = ContactSettingLanguage::where('contact_setting_id', $get_contact['id'])->where('language_id', $language)->first();
            if ($get_contact_lang) {
                $get_information['address']           = $get_contact_lang['address']     != '' ? $get_contact_lang['address'] : "";
                $get_information['why_book_with_us']  = $get_contact_lang['description'] != '' ? $get_contact_lang['description'] : "";
            }

            $get_information['why_book_with_us_heading'] = '';
            $why_book_with_us_heading                        = MetaGlobalLanguage::where('meta_parent', 'why_book_with_us_heading')
                ->where('meta_title', 'heading_title')
                ->where('language_id', $language)
                ->first();
            if ($why_book_with_us_heading) {
                $get_information['why_book_with_us_heading'] = $why_book_with_us_heading['title'];
            }

            $get_information['need_help_contact_heading'] = '';
            $need_help_contact_heading                        = MetaGlobalLanguage::where('meta_parent', 'need_help_contact_heading')
                ->where('meta_title', 'heading_title')
                ->where('language_id', $language)
                ->first();
            if ($need_help_contact_heading) {
                $get_information['need_help_contact_heading'] = $need_help_contact_heading['title'];
            }
        }


        $output['status']  = true;
        $output['message'] = 'Data fetch Successfully';
        $output['data']    = $get_information;
        return json_encode($output);
    }

    //Get Partner Page
    public function get_partners(Request $request)
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
        $language_id           = $request->language;
        $data                  = array();
        $data['heading_title'] = '';
        $data['heading_text']  = '';
        $data['partners']      = [];
        $get_partner_heading_title     = MetaGlobalLanguage::where('meta_parent', 'partners')->where('meta_title', 'partners_heading_title')->where('language_id', $language_id)->first();
        if ($get_partner_heading_title) {
            $data['heading_title'] = $get_partner_heading_title['title'];
            $data['heading_text']  = $get_partner_heading_title['content'];
        }
        $get_partners = $get_partner = Partners::select('partners.*', 'partners_language.title')->orderBy('partners.id', 'desc')->where(['partners.is_delete' => 0, 'partners_language.language_id' => $request->language])
            ->join("partners_language", 'partners.id', '=', 'partners_language.partner_id')->groupBy('partners.id')->get();
        if (!$get_partners->isEmpty()) {
            foreach ($get_partners as $key => $value) {
                $row['id']      = $value['id'];
                $row['title']   = $value['title'];
                $row['link']    = $value['link'] != '' ?  $value['link'] : '';
                $row['image']   = $value['image'] != '' ? url('uploads/partner_images', $value['image']) : asset('uploads/placeholder/placeholder.png');
                $data['partners'][] = $row;
            }
        }

        $data['gift_expirence']  = '';
        //gift Expirence 
        $get_gift_expirence       = BannerOverview::where('page', 'gift_an_expirence_section')->where('status', 'Active')->first();
        if ($get_gift_expirence) {
            $get_gift_arr                      = [];
            $get_gift_arr['title']       = '';
            $get_gift_arr['description'] = '';
            $get_gift_an_expirence_language  = BannerOverviewLanguage::where('page', 'gift_an_expirence_section')
                ->where('overview_id', $get_gift_expirence['id'])
                ->where('langauge_id', $language_id)
                ->first();
            if ($get_gift_an_expirence_language) {
                $get_gift_arr['title']        = $get_gift_an_expirence_language['title'];
                $get_gift_arr['description']  = $get_gift_an_expirence_language['description'];
            }
            $get_gift_arr['_link']   = $get_gift_expirence['link'];
            $get_gift_arr['image']  = $get_gift_expirence['image'] != '' ? url('uploads/gift_an_expirence', $get_gift_expirence['image']) : asset('uploads/placeholder/placeholder.png');
            $data['gift_expirence']  = $get_gift_arr;
        }




        $output['status']   = true;
        $output['data']     = $data;
        $output['message']  = 'Partner Page';
        return json_encode($output);
    }


    //Get testimonials Page
    public function get_testimonials(Request $request)
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
        $language_id = $request->language;

        $data = array();
        $data['heading_title'] = '';
        $data['testimonials']  = [];
        $get_heading_title     = MetaGlobalLanguage::where('meta_parent', 'testimonial')->where('meta_title', 'testimonial_heading_title')->where('language_id', $language_id)->first();
        if ($get_heading_title) {
            $data['heading_title'] = $get_heading_title['title'];
        }

        $get_testimonials  = Testimonials::select('testimonials.*', 'testimonials_language.description')->orderBy('testimonials.id', 'desc')->where(['testimonials.is_delete' => 0, 'testimonials_language.language_id' => $request->language])
            ->join("testimonials_language", 'testimonials.id', '=', 'testimonials_language.testimonials_id')->groupBy('testimonials.id')->get();
        if (!$get_testimonials->isEmpty()) {
            foreach ($get_testimonials as $key => $value) {
                $row['id']            = $value['id'];
                $row['name']          = $value['name'];
                $row['designation']   = $value['designation'];
                $row['image']         = $value['image'] != '' ? url('uploads/Testimonials', $value['image']) : asset('uploads/placeholder/placeholder.png');
                $row['description']   = $value['description'];
                $data['testimonials'][] = $row;
            }

            $output['status']   = true;
            $output['data']     = $data;
            $output['message']  = 'Testimonials Page';
        } else {
            $output['status']  = false;
            $output['message'] = 'No data found';
        }

        return json_encode($output);
    }


    //Check copoun code
    public function check_coupon_code(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'Data Not Found';
        $output['data']    = [];
        $validation = Validator::make($request->all(), [
            'coupon_code' => 'required',
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
        $total_amount = $request->total_amount;
        $language_id  = $request->language;
        $user_id      = $request->user_id;
        $status       = false;
        $data         = [];
        $get_coupon_code  = CouponCode::where(['coupon_code' => $request->coupon_code, 'status' => 'Active'])->first();
        if ($get_coupon_code) {
            $current_date = date('Y-m-d');
            if ($current_date >= $get_coupon_code['start_date'] && $current_date <= $get_coupon_code['end_date']) {
                $get_uses          = ProductCheckout::where(['coupon_code_id' => $get_coupon_code['id']])->get();
                $get_customer_uses = ProductCheckout::where(['coupon_code_id' => $get_coupon_code['id'], 'user_id' => $user_id])->get();
                $customers         = json_decode($get_coupon_code['customers']);

                if (count($get_uses) <= $get_coupon_code['number_of_uses'] && count($get_customer_uses) <= $get_coupon_code['how_many']) {
                    if ($get_coupon_code['customer_selection'] == 'All') {

                        $output['status']  = true;
                        $status            = true;
                        $output['message'] = 'Applied Successfully';
                    } elseif ($get_coupon_code['customer_selection'] == 'Includes') {
                        if ($customers != null) {
                            if (in_array($user_id, $customers)) {
                                $output['status']  = true;
                                $status            = true;
                                $output['message'] = 'Applied Successfully';
                            } else {
                                $output['message'] = 'Not validate for this offers';
                            }
                        } else {
                            $output['message'] = 'Not validate for this offers';
                        }
                    } elseif ($get_coupon_code['customer_selection'] == 'Excludes') {

                        if ($customers != null) {
                            if (in_array($user_id, $customers)) {
                                $output['message'] = 'Not validate for this offers';
                            } else {
                                $output['status']  = true;
                                $status            = true;
                                $output['message'] = 'Applied Successfully';
                            }
                        } else {
                            $output['status']  = true;
                            $status            = true;
                            $output['message'] = 'Applied Successfully';
                        }
                    }
                } else {
                    $output['message'] = 'limit over';
                }
            } else {
                $output['message'] = 'Invalid date';
            }
        } else {
            $output['message'] = 'No Offer found';
        }

        if ($status   == true) {
            // coupon_type
            $coupon_amount = 0;
            $total         = 0;
            if ($get_coupon_code['coupon_value'] > 0) {
                $coupon_value  = ConvertCurrency($get_coupon_code['coupon_value']);
                $total_amount =  str_replace(',', '', $total_amount);
                if ($get_coupon_code['coupon_type'] == 'percent') {
                    if ($total_amount > 0) {
                        $coupon_value_amount = $coupon_value > 0  ? $coupon_value : 0;
                        $coupon_value        = ($total_amount / 100) * $coupon_value_amount;
                    }
                }
                $total = $total_amount - $coupon_value;
                if ($total < 0) {
                    $total = 0;
                }
            }
            $data['coupon_id']    = $get_coupon_code['id'];
            $data['sub_total']    = $total_amount;
            $data['total']        = $total;
            $data['coupon_value'] = number_format($coupon_value, 2);
            $data['code']         = $get_coupon_code['coupon_code'];
            $output['data']       = $data;
        }
        return json_encode($output);
    }



    //Support
    public function add_support_detail(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'Data Not Found';
        $validation = Validator::make($request->all(), [
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

        $SupportDetails                    = new SupportDetails();
        $SupportDetails->name              = $request->name;
        $SupportDetails->phone_number      = $request->phone_number;
        $SupportDetails->alt_phone_number  = $request->alt_phone_number;
        $SupportDetails->email         = $request->email;
        $SupportDetails->travel_date   = $request->travel_date;
        $SupportDetails->pnr_number    = $request->pnr_number;
        $SupportDetails->issue_type    = $request->issue_type;
        $SupportDetails->subject       = $request->subject;
        $SupportDetails->save();

        $output['status']   = true;
        $output['message']  = 'Submit Successfully';
        return json_encode($output);
    }


    // Join Us Form
    public function add_join_us(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'Data Not Found';
        $validation = Validator::make($request->all(), [
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

        $JoinUsDetails                   = new JoinUsDetails();
        $JoinUsDetails->company_name     = $request->company_name;
        $JoinUsDetails->company_address  = $request->company_address;
        $JoinUsDetails->web_address      = $request->web_address;
        $JoinUsDetails->email            = $request->email;
        $JoinUsDetails->message          = $request->message;
        $JoinUsDetails->tour_days        = $request->tour_days;
        $JoinUsDetails->save();

        $output['status']   = true;
        $output['message']  = 'Submit Successfully';
        return json_encode($output);
    }

    // function Firbase Toke Save 
    public function add_firebase_token(Request $request)
    {
        $validation        = Validator::make($request->all(), [
            'firebase_token' => 'required',
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
        $firebase_token   = $request->firebase_token;
        $GetFireBaseToken = FireBaseToken::where('token', $firebase_token)->first();
        if (!$GetFireBaseToken) {
            $FireBaseToken                   = new FireBaseToken();
            $FireBaseToken->token            = $request->firebase_token;
            $FireBaseToken->save();;
        }
    }


    //Gift Card Check copoun code
    public function gift_card_check_coupon_code(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'Data Not Found';
        $output['data']    = [];
        $validation = Validator::make($request->all(), [
            'coupon_code' => 'required',
            'language'    => 'required',
            'currency'    => 'required',
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
        $language_id  = $request->language;
        $currency     = $request->currency;
        $user_id      = $request->user_id;


        $status       = false;
        $data         = [];
        $get_coupon_code  = ProductCheckoutGiftCard::where(['gift_card_code' => $request->coupon_code, 'gift_card_status' => 'Pending'])->first();
        if ($get_coupon_code) {
            $current_date        = date('Y-m-d');
            $data['coupon_id']   = $get_coupon_code['id'];
            $data['gift_amount'] = ConvertCurrency($get_coupon_code['gift_amount'],$get_coupon_code['currency']);
            $data['code']        = $get_coupon_code['gift_card_code'];
            $output['data']      = $data;
            $output['status']    = true;
            
        } else {
            $output['message'] = 'Sorry this gift card was not valid';
        }     
            
        
        return json_encode($output);
    }
}
