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
use App\Models\Language;

use App\Models\HotelHighlight;
use App\Models\HotelHighlightLanguage;
use App\Models\HotelAmenityLanguage;
use App\Models\HotelAmenity;
use App\Models\HotelPage;

use App\Models\HotelFaqsLanguage;
use App\Models\HotelFaqHeadingLanguage;
use App\Models\HotelPageLanguage;

use App\Models\{HotelFaqLanguage, HotelFaq, HotelFaqHeading, HotelFAQS};

use App\Models\PageSliders;
use App\Models\PageSlidersLanguage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Str;

class HotelPageController extends Controller
{

    public function index()
    {
        $common          = array();
        $common['title'] = translate("Hotels");
        Session::put("TopMenu", "Hotel");
        Session::put("SubMenu", "Hotel");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $get_hotel_data = HotelPage::select('hotel_page.*', 'hotel_page_language.title', 'hotel_page_language.hotel_room', 'hotel_page_language.hotel_view', 'hotel_page_language.hotel_bars')
            ->orderBy('hotel_page.id', 'desc')
            ->where(['hotel_page.is_delete' => 0])
            ->leftjoin("hotel_page_language", 'hotel_page.id', '=', 'hotel_page_language.hotel_id')
            ->groupBy('hotel_page.id')
            ->paginate(config('adminconfig.records_per_page'));
            
        return view('admin.hotel_page.index', compact('common', 'get_hotel_data','lang_id'));
    }



    ///Add AffiliatePage
    public function add_hotel_page(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Hotel");
        Session::put("SubMenu", "Hotel");

        $common['title']              = translate("Add Hotel Page");
        $common['button']             = translate("Save");

        $languages             = Language::where(ConditionQuery())->get();

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $get_hotel_highlights            = [];
        $get_hotel_highlights_language   = [];

        $HotelPage                    = getTableColumn('hotel_page');
        $HotelPageLanguage_hotel_page =   [];
        $HHL                   = getTableColumn('hotel_highlight');
        $HA                    = getTableColumn('hotel_amenities');
        $FAQ_data              = getTableColumn('hotel_faq');

        $FAQS                                 = getTableColumn('pages_faq');
        $get_hotel_amenities          = [];
        $get_hotel_amenities_language = [];

        // slider images
        $get_slider_images                 = [];
        $get_slider_images_language        = [];
        $HSI                               = getTableColumn('pages_slider');

        $get_HotelFaqLanguage = [];
        $get_HotelFaqHeading = [];
        $getHotelFaq = [];


        if ($request->isMethod('post')) {

            // echo "<pre>"; 
            //   print_r($request->all());
            //   echo "</pre>";die();

            $req_fields = array();
            $req_fields['title.*']   = "required";

            $req_fields['hotel_view.*']   = "required";
            $req_fields['hotel_rooms.*']   = "required";

            $req_fields['hotel_bars.*']   = "required";


            $errormsg = [
                "title.*" => translate("Title"),
                "hotel_view.*" => translate("Hotel View"),
                "hotel_rooms.*" => translate("Hotel Rooms"),
                "hotel_bars.*" => translate("Hotel Bars"),

            ];

            $validation = Validator::make(
                $request->all(),
                $req_fields,
                [
                    'required' => 'The :attribute field is required.',
                ],
                $errormsg
            );

            // dd($request->all());

            // echo "<pre>"; 
            // print_r($request->all());
            // echo "</pre>";die();

            if ($validation->fails()) {
                return back()->withErrors($validation)->withInput();
            }


            if ($request->id != "") {
                $message  = translate("Update Successfully");
                $status   = "success";
                $HotelPage      = HotelPage::find($request->id);

                $slug = createSlug('hotel_page', $request->title[$lang_id], $request->id);
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $HotelPage      = new HotelPage();

                $slug = createSlug('hotel_page', $request->title[$lang_id]);
            }

            $HotelPage->slug              = $slug;
            $HotelPage->address           = $request->hotel_address;
            $HotelPage->status            = "Active";
            $HotelPage->address_lattitude = $request->address_lattitude;
            $HotelPage->address_longitude = $request->address_longitude;
            $HotelPage->address_longitude = $request->address_longitude;
            $HotelPage->video_url         = $request->video_url;

            if ($request->hasFile('title_icon')) {
                $image                  = $request->file('title_icon');
                $random_no              = Str::random(5);
                $newImage               = time() . $random_no . '.' . $image->getClientOriginalExtension();
                $destinationPath        = public_path('uploads/MediaPage');
                $imgFile                = Image::make($image->path());

                $destinationPath = public_path('uploads/MediaPage');
                $imgFile->save($destinationPath . '/' . $newImage);
                $HotelPage['title_icon'] = $newImage;
            }

            if ($request->hasFile('hotel_view_icon')) {
                $image                  = $request->file('hotel_view_icon');
                $random_no              = Str::random(5);
                $newImage               = time() . $random_no . '.' . $image->getClientOriginalExtension();
                $destinationPath        = public_path('uploads/MediaPage');
                $imgFile                = Image::make($image->path());

                $destinationPath = public_path('uploads/MediaPage');
                $imgFile->save($destinationPath . '/' . $newImage);
                $HotelPage['hotel_view_icon'] = $newImage;
            }

            if ($request->hasFile('hotel_room_icon')) {
                $image                  = $request->file('hotel_room_icon');
                $random_no              = Str::random(5);
                $newImage               = time() . $random_no . '.' . $image->getClientOriginalExtension();
                $destinationPath        = public_path('uploads/MediaPage');
                $imgFile                = Image::make($image->path());

                $destinationPath = public_path('uploads/MediaPage');
                $imgFile->save($destinationPath . '/' . $newImage);
                $HotelPage['hotel_room_icon'] = $newImage;
            }

            if ($request->hasFile('hotel_bar_icon')) {
                $image                  = $request->file('hotel_bar_icon');
                $random_no              = Str::random(5);
                $newImage               = time() . $random_no . '.' . $image->getClientOriginalExtension();
                $destinationPath        = public_path('uploads/MediaPage');
                $imgFile                = Image::make($image->path());

                $destinationPath = public_path('uploads/MediaPage');
                $imgFile->save($destinationPath . '/' . $newImage);
                $HotelPage['hotel_bar_icon'] = $newImage;
            }

            if ($request->hasFile('side_image')) {
                $image                  = $request->file('side_image');
                $random_no              = Str::random(5);
                $newImage               = time() . $random_no . '.' . $image->getClientOriginalExtension();
                $destinationPath        = public_path('uploads/MediaPage');
                $imgFile                = Image::make($image->path());
                $height                 = $imgFile->height();
                $width                  = $imgFile->width();
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
                $destinationPath = public_path('uploads/MediaPage');
                $imgFile->save($destinationPath . '/' . $newImage);
                $HotelPage['side_image'] = $newImage;
            }


            if ($request->hasFile('video_thumbnail')) {
                $image                  = $request->file('video_thumbnail');
                $random_no              = Str::random(5);
                $newImage               = time() . $random_no . '.' . $image->getClientOriginalExtension();
                $destinationPath        = public_path('uploads/MediaPage');
                $imgFile                = Image::make($image->path());
                $height                 = $imgFile->height();
                $width                  = $imgFile->width();
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
                $destinationPath = public_path('uploads/MediaPage');
                $imgFile->save($destinationPath . '/' . $newImage);
                $HotelPage['video_thumbnail'] = $newImage;
            }


            $HotelPage->save();
            $HotelPageID = $HotelPage->id;

            HotelPageLanguage::where('hotel_id', $HotelPageID)->where('language_id',$lang_id)->delete();

            $get_languages = Language::where(['status'=>'Active','is_delete'=>0])->get();

            if (!empty($get_languages)) {
                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('hotel_page_language',['language_id'=>$value['id'],'hotel_id'=>$request->id],'row')) {
                        $HotelPageLanguage                     = new HotelPageLanguage();
                        $HotelPageLanguage['title']            = isset($request->title[$value['id']]) ?  $request->title[$value['id']] : $request->title[$lang_id];
                        $HotelPageLanguage['hotel_id']         = $HotelPageID;
                        $HotelPageLanguage['language_id']      = $value['id'];
                        $HotelPageLanguage['hotel_bars']       = isset($request->hotel_bars[$value['id']]) ?  $request->hotel_bars[$value['id']] : $request->hotel_bars[$lang_id];

                        $HotelPageLanguage['hotel_view']       = isset($request->hotel_view[$value['id']]) ?  $request->hotel_view[$value['id']] : $request->hotel_view[$lang_id];

                        $HotelPageLanguage['hotel_room']       = isset($request->hotel_rooms[$value['id']]) ?  $request->hotel_rooms[$value['id']] : $request->hotel_rooms[$lang_id];
                        $HotelPageLanguage->save();
                    }
                }
            }

            // Hotel Highlights
            $HotelHighlight = HotelHighlight::where('hotel_id', $HotelPageID)->get();
            foreach ($HotelHighlight as $key => $HotelHighlight_delete) {
                if (!in_array($HotelHighlight_delete['id'], $request->highlight_id)) {
                    HotelHighlight::where('id', $HotelHighlight_delete['id'])->delete();
                }
            }

            if (isset($request->highlight_id)) {
              
                HotelHighlightLanguage::where('hotel_id', $HotelPageID)->where('language_id',$lang_id)->delete();
                foreach ($request->highlight_id as $key => $value_choose) {

                    if ($value_choose != '') {
                        $HotelHighlight = HotelHighlight::find($value_choose);
                    } else {
                        $HotelHighlight = new HotelHighlight();
                    }

                    $HotelHighlight->hotel_id = $HotelPageID;
                    $HotelHighlight->save();

                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('hotel_highlits_language',['language_id'=>$value['id'],'hotel_id' => $request->id,'highlight_id'=> $HotelHighlight->id ],'row')) {          
                            $HotelHighlightLanguage = new HotelHighlightLanguage();
                            $HotelHighlightLanguage['hotel_id']        = $HotelPageID;
                            $HotelHighlightLanguage['highlight_id']    = $HotelHighlight->id;
                            $HotelHighlightLanguage['language_id']     = $value['id'];
                            $HotelHighlightLanguage['title']           = isset($request->highlight_title[$value['id']][$key]) ?  $request->highlight_title[$value['id']][$key] : $request->highlight_title[$lang_id][$key];
                            $HotelHighlightLanguage['description']     = isset($request->highlight_description[$value['id']][$key]) ?  $request->highlight_description[$value['id']][$key] : $request->highlight_description[$lang_id][$key];
                            $HotelHighlightLanguage->save();
                        }
                    }
                }

            }


            // Hotel Amenity
            $HotelAmenity = HotelAmenity::where('hotel_id', $HotelPageID)->get();
            foreach ($HotelAmenity as $key => $HotelAmenity_delete) {
                if (!in_array($HotelAmenity_delete['id'], $request->Amenity_id)) {
                    HotelAmenity::where('id', $HotelAmenity_delete['id'])->delete();
                }
            }


            if (isset($request->Amenity_id)) {

                HotelAmenityLanguage::where('hotel_id', $HotelPageID)->where('language_id',$lang_id)->delete();
                foreach ($request->Amenity_id as $key => $value_choose) {

                    if ($value_choose != '') {
                        $HotelAmenity = HotelAmenity::find($value_choose);
                    } else {
                        $HotelAmenity = new HotelAmenity();
                    }

                    $HotelAmenity->hotel_id = $HotelPageID;
                    $HotelAmenity->save();

                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('hotel_amenities_language',['language_id'=>$value['id'],'hotel_id' => $request->id,'amenity_id'=> $HotelAmenity->id ],'row')) {           
                            $HotelAmenityLanguage = new HotelAmenityLanguage();
                            $HotelAmenityLanguage['hotel_id']        = $HotelPageID;
                            $HotelAmenityLanguage['amenity_id']      = $HotelAmenity->id;
                            $HotelAmenityLanguage['language_id']     = $value['id'];
                            $HotelAmenityLanguage['title']           = isset($request->amenity_title[$value['id']][$key]) ?  $request->amenity_title[$value['id']][$key] : $request->amenity_title[$lang_id][$key];
                            $HotelAmenityLanguage->save();
                        }
                    }
                }
                
            }


            HotelFaqHeading::where('hotel_id', $HotelPageID)->where('language_id',$lang_id)->delete();
            HotelFAQS::where('hotel_id', $HotelPageID)->delete();


            // HotelFaq::where('hotel_id', $HotelPageID)->delete();
            HotelFaqLanguage::where('hotel_id', $HotelPageID)->where('language_id',$lang_id)->delete();

            if ($request->faq_id) {

                foreach ($request->faq_id as $key => $value_high) {
                    if ($value_high != '') {
                        $HotelFAQ = HotelFaq::find($value_high);
                    } else {
                        $HotelFAQ = new HotelFaq();
                    }

                    $HotelFAQ['hotel_id'] = $HotelPageID;

                    if (isset($request->faq_icon[$key])) {
                        $files = $request->file('faq_icon')[$key];

                        $random_no = uniqid();
                        $img = $files;
                        $ext = $files->getClientOriginalExtension();
                        $new_name = $random_no . time() . '.' . $ext;
                        $destinationPath = public_path('uploads/MediaPage');
                        $img->move($destinationPath, $new_name);
                        $HotelFAQ['faq_icon'] = $new_name;
                    } elseif (isset($request->faq_icon_value[$key])) {
                        $HotelFAQ['faq_icon'] = $request->faq_icon_value[$key];
                    }
                    $HotelFAQ->save();

                    if ($request->heading) {
                        foreach ($get_languages as $lang_key => $value) {
                            if (!getDataFromDB('hotel_faq_heading_language',['language_id'=>$value['id'],'hotel_id' => $request->id,'faq_id'=> $HotelFAQ->id ],'row')) {  

                                $HotelFaqHeadingLanguage                 = new HotelFaqHeading();
                                $HotelFaqHeadingLanguage['language_id']  = $value['id'];
                                $HotelFaqHeadingLanguage['hotel_id']     = $HotelPageID;
                                $HotelFaqHeadingLanguage['faq_id']       = $HotelFAQ->id;
                                $HotelFaqHeadingLanguage['title']        = isset($request->heading[$key][$value['id']]) ?  $request->heading[$key][$value['id']] : $request->heading[$key][$lang_id];
                                $HotelFaqHeadingLanguage->save();
                            }
                        }


                        if (isset($request->faq_title[$key])) {

                            foreach ($request->faq_title[$key] as $FLID => $FAQT) {

                                $languages    = Language::where(ConditionQuery())->count();

                                if ($FLID  % $languages == 0 && $languages > 1) {
                                    $HotelFAQS =   new  HotelFAQS();
                                    $HotelFAQS->hotel_id = $HotelPageID;
                                    $HotelFAQS->faq_id = $HotelFAQ->id;
                                    $HotelFAQS->save();
                                } else if ($languages == 1) {
                                    $HotelFAQS =   new  HotelFAQS();
                                    $HotelFAQS->hotel_id = $HotelPageID;
                                    $HotelFAQS->faq_id = $HotelFAQ->id;
                                    $HotelFAQS->save();
                                }


                                foreach ($get_languages as $lang_key => $value) {
                                    if (!getDataFromDB('hotel_faq_language',['language_id'=>$value['id'],'hotel_id' => $request->id,'faq_id'=> $HotelFAQ->id,'faqs_id'=> $HotelFAQS->id ],'row')) {     

                                        $HotelFaqsLanguage                     = new HotelFaqLanguage();
                                        $HotelFaqsLanguage['language_id'] = $value['id'];
                                        $HotelFaqsLanguage['faq_id']     = $HotelFAQ->id;
                                        $HotelFaqsLanguage['hotel_id']   = $HotelPageID;
                                        $HotelFaqsLanguage['faqs_id']    = $HotelFAQS->id ?? '';
                                        $HotelFaqsLanguage['title']      = isset($FAQT[$value['id']]) ?  $FAQT[$value['id']] : $FAQT[$lang_id];
                                        $HotelFaqsLanguage->save();
                                    }
                                }
                            }
                        }
                    }
                }
            }


            // Slider Images
            $get_pageSlider = PageSliders::where(['page_id' => $HotelPageID, 'page' => 'hotel_slider_img'])->get();
            foreach ($get_pageSlider as $key => $val) {
                if (!in_array($val['id'], $request->slider_img_id)) {
                    PageSliders::where(['id' => $val['id'], 'page' => 'hotel_slider_img'])->delete();
                }
            }

            foreach ($request->slider_img_id as $key => $over_value) {

                if ($over_value != '') {
                    $PageSliders       = PageSliders::find($over_value);
                } else {
                    $PageSliders       = new PageSliders();
                }
                if ($request->hasFile('slider_image')) {
                    if (isset($request->slider_image[$key])) {
                        $files = $request->file('slider_image')[$key];
                        $random_no       = uniqid();
                        $img             = $files;
                        $ext             = $files->getClientOriginalExtension();
                        $new_name        = $random_no . time() . '.' . $ext;
                        $destinationPath = public_path('uploads/slider_images');
                        $img->move($destinationPath, $new_name);

                        $PageSliders->image    = $new_name;
                        $PageSliders->page_id  = $HotelPageID;
                        $PageSliders->page     = "hotel_slider_img";
                    }
                }
                $PageSliders->save();
            }

            return redirect()->route('admin.hotel_page')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }

            $id           = checkDecrypt($id);

            $common['title']      = "Edit Hotel Page";
            $common['button']     = "Update";


            $HotelPage = HotelPage::where('id', $id)->first();
            $HotelPageLanguage_hotel_page = HotelPageLanguage::where('hotel_id', $id)->get();

            $get_hotel_highlights          = HotelHighlight::where('hotel_id', $id)->get();
            $get_hotel_highlights_language = HotelHighlightLanguage::where('hotel_id', $id)->get();

            $get_hotel_amenities          = HotelAmenity::where('hotel_id', $id)->get();
            $get_hotel_amenities_language = HotelAmenityLanguage::where('hotel_id', $id)->get();

            $get_affiliate_page_faq       = PagesFaqs::where("affiliate_page_id", $id)->get();

            $getHotelFaq          = HotelFaq::where('hotel_id', $id)->get();
            $get_HotelFaqHeading  = HotelFaqHeading::get();
            $get_HotelFaqLanguage = HotelFaqLanguage::get();

            $get_slider_images          = PageSliders::where(['page_id' => $id, 'page' => 'hotel_slider_img', 'status' => 'Active'])->get();
            $get_slider_images_language = PageSlidersLanguage::where(['page_id' => $id, 'page' => 'affiliate_page_slider'])->get();
        }
        return view('admin.hotel_page.add_hotel_page', compact('common', 'get_HotelFaqLanguage', 'getHotelFaq', 'get_HotelFaqHeading', 'HotelPageLanguage_hotel_page', 'HotelPage', 'get_hotel_amenities', 'get_hotel_amenities_language', 'languages', 'get_hotel_highlights', 'get_hotel_highlights_language', 'FAQS', 'get_slider_images', 'HSI', 'get_slider_images_language', 'HHL', 'HA', 'FAQ_data','lang_id'));
    }


    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $HotelPage =  HotelPage::find($id);
        if ($HotelPage) {
            $HotelPage->delete();
            HotelFaqHeading::where('hotel_id', $id)->delete();
            HotelFaq::where('hotel_id', $id)->delete();
            HotelFaqLanguage::where('hotel_id', $id)->delete();
            HotelFAQS::where('hotel_id', $id)->delete();
            PageSliders::where(['page_id' => $id, 'page' => 'hotel_slider_img', 'status' => 'Active'])->delete();
            HotelAmenity::where('hotel_id', $id)->delete();
            HotelAmenityLanguage::where('hotel_id', $id)->delete();
            HotelHighlight::where('hotel_id', $id)->delete();
            HotelHighlightLanguage::where('hotel_id', $id)->delete();
            HotelPageLanguage::where('hotel_id', $id)->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }
}
