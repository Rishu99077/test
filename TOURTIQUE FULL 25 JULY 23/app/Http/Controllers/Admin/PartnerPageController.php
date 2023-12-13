<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerPage;
use App\Models\PartnerPageLanguage;

use App\Models\PartnerPageSliderImage;

use App\Models\PartnerPageFacility;
use App\Models\PartnerPageFacilityLanguage;

use App\Models\PartnerPageBook;
use App\Models\PartnerPageBookLanguage;

use App\Models\PartnerPageActivitiesImage;

use App\Models\PageSliders;
use App\Models\PageSlidersLanguage;

use App\Models\Language;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Str;

class PartnerPageController extends Controller
{

    ///Add PartnerPage
    public function add_partner_page(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Pages");
        Session::put("SubMenu", "Partners Login Page");

        $common['title']            = translate("Add Partners Login");
        $common['button']           = translate("Save");
        $get_partner_page           = getTableColumn('partner_page');
        $get_partner_page_language  = "";
        $languages                     = Language::where(ConditionQuery())->get();

        $get_partner_page_slider_image             = [];
        $get_partner_page_facility                = [];
        $get_partner_page_facility_language       = [];
        $FAC                                    = getTableColumn('partner_page_facility');


        $get_partner_page_book                    = [];
        $get_partner_page_book_language           = [];
        $BOO                                    = getTableColumn('partner_page_book');

        $get_slider_images              = [];
        $get_slider_images_language     = [];
        $LSI                = getTableColumn('pages_slider');

        $get_partner_page_activity_image        = [];

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $get_languages = Language::where(['status'=>'Active','is_delete' => 0])->get();


        if ($request->isMethod('post')) {

            $req_fields = array();
            $req_fields['title.*']   = "required";

            $errormsg = [
                "title.*" => translate("Title"),
            ];

            $validation = Validator::make(
                $request->all(),
                $req_fields,
                [
                    'required' => 'The :attribute field is required.',
                ],
                $errormsg
            );

            // echo "<pre>"; 
            // print_r($request->all());
            // echo "</pre>";die();

            if ($validation->fails()) {
                return back()->withErrors($validation)->withInput();
            }


            if ($request->id != "") {
                $message  = translate("Update Successfully");
                $status   = "success";
                $PartnerPage      = PartnerPage::find($request->id);
                PartnerPageLanguage::where("partner_page_id", $request->id)->where('language_id',$lang_id)->delete();

                $get_page_book = PartnerPageBook::where('partner_page_id', $request->id)->get();
                foreach ($get_page_book as $key => $get_pagefacility_delete) {
                    if (!in_array($get_pagefacility_delete['id'], $request->book_id)) {
                        PartnerPageBook::where('id', $get_pagefacility_delete['id'])->delete();
                    }
                }
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $PartnerPage      = new PartnerPage();
            }

            if ($request->hasFile('banner_image')) {
                if (isset($request->banner_image)) {
                    $files = $request->file('banner_image');
                    $random_no       = uniqid();
                    $img             = $files;
                    $ext             = $files->getClientOriginalExtension();
                    $new_name        = $random_no . time() . '.' . $ext;
                    $imgFile         = Image::make($files->path());
                    $height          =  $imgFile->height();
                    $width           =  $imgFile->width();
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
                    $destinationPath = public_path('uploads/PartnerPage');
                    $imgFile->save($destinationPath . '/' . $new_name);
                    $PartnerPage['banner_image'] = $new_name;
                }
            }

            $PartnerPage['status']         = "Active";
            $PartnerPage->save();

            $partner_page_id = $PartnerPage->id;

            if (!empty($request->activity_title)) {

                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('partner_page_language',['language_id'=>$value['id'],'partner_page_id'=>$PartnerPage->id],'row')) {    
                        $PartnerPageLanguage                             = new PartnerPageLanguage();
                        // $PartnerPageLanguage->title                = $value;
                        // $PartnerPageLanguage->description          = $request->description[$key];
                        $PartnerPageLanguage->language_id          = $value['id'];
                        $PartnerPageLanguage->partner_page_id      = $PartnerPage->id;
                        $PartnerPageLanguage->activity_title       = isset($request->activity_title[$value['id']]) ?  $request->activity_title[$value['id']] : $request->activity_title[$lang_id];  
                        $PartnerPageLanguage->why_book_title       = isset($request->why_book_title[$value['id']]) ?  $request->why_book_title[$value['id']] : $request->why_book_title[$lang_id]; 
                        $PartnerPageLanguage->facilities_heading_title       = isset($request->facilities_heading_title[$value['id']]) ?  $request->facilities_heading_title[$value['id']] : $request->facilities_heading_title[$lang_id]; 
                        $PartnerPageLanguage->facilities_heading_description = isset($request->facilities_heading_description[$value['id']]) ? change_str($request->facilities_heading_description[$value['id']]) : $request->facilities_heading_description[$lang_id];


                        $PartnerPageLanguage->save();
                    }
                }
            }


            // Slider  Images 
            $get_pageSlider = PageSliders::where(['page' => 'partner_Page'])->get();
            foreach ($get_pageSlider as $key => $val) {
                if (!in_array($val['id'], $request->over_view_id)) {
                    PageSliders::where('id', $val['id'])->delete();
                }
            }
            if (!empty($request->slider_title)) {
                if ($request->slider_title) {

                    PageSlidersLanguage::where(['page_id' => $partner_page_id, 'page' => 'partner_Page'])->where('language_id',$lang_id)->delete();

                    foreach ($request->over_view_id as $key => $over_value) {

                        if ($over_value != '') {
                            $PageSliders       = PageSliders::find($over_value);
                        } else {
                            $PageSliders       = new PageSliders();
                        }

                        $PageSliders->page_id  = $partner_page_id;
                        $PageSliders->page     = "partner_Page";

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

                        $PageSliders->save();
                        $page_slider_id = $PageSliders->id;
                        
                        foreach ($get_languages as $lang_key => $value) {
                            if (!getDataFromDB('pages_slider_language',['language_id'=>$value['id'],'pages_slider_id' => $page_slider_id,'page'=> 'partner_Page','page_id'=>$partner_page_id ],'row')) {      

                                $PageSlidersLanguage = new PageSlidersLanguage();
                                $PageSlidersLanguage['page_id']            = $partner_page_id;
                                $PageSlidersLanguage['pages_slider_id']    = $page_slider_id;
                                $PageSlidersLanguage['page']               = 'partner_Page';
                                $PageSlidersLanguage['language_id']        = $value['id'];
                                $PageSlidersLanguage['title']              = isset($request->slider_title[$value['id']][$key]) ?  $request->slider_title[$value['id']][$key] : $request->slider_title[$lang_id][$key];
                                $PageSlidersLanguage['description']        = isset($request->slider_description[$value['id']][$key]) ?  $request->slider_description[$value['id']][$key] : $request->slider_description[$lang_id][$key];  
                                $PageSlidersLanguage->save();
                            }
                        }
                    }
                }
            }

            // Article-------------------------------------------------------------
            if ($request->facility_title) {
                // PartnerPageFacility::where(["partner_page_id" => $partner_page_id])->delete();
                PartnerPageFacilityLanguage::where(["partner_page_id" => $partner_page_id])->where('language_id',$lang_id)->delete();


                foreach ($request->facility_id as $key => $value_fac) {

                    if ($value_fac != "") {
                        $PartnerPageFacility = PartnerPageFacility::find($value_fac);
                    } else {
                        $PartnerPageFacility = new PartnerPageFacility();
                    }


                    $PartnerPageFacility['partner_page_id'] = $partner_page_id;

                    $PartnerPageFacility->save();

                    
                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('partner_page_facility_language',['language_id'=>$value['id'],'partner_page_id' => $partner_page_id,'partner_page_facility_id'=> $PartnerPageFacility->id ],'row')) {   
                            $PartnerPageFacilityLanguage = new PartnerPageFacilityLanguage();
                            $PartnerPageFacilityLanguage['partner_page_id']          = $partner_page_id;
                            $PartnerPageFacilityLanguage['language_id']              = $value['id'];
                            $PartnerPageFacilityLanguage['partner_page_facility_id'] = $PartnerPageFacility->id;
                            $PartnerPageFacilityLanguage['facility_title']           = isset($request->facility_title[$value['id']][$key]) ?  $request->facility_title[$value['id']][$key] : $request->facility_title[$lang_id][$key];
                            $PartnerPageFacilityLanguage->save();
                        }
                    }
                }
            }


            // Why Book-------------------------------------------------------------
            if ($request->book_title) {
                // PartnerPageBook::where(["partner_page_id" => $partner_page_id])->delete();
                PartnerPageBookLanguage::where(["partner_page_id" => $partner_page_id])->where('language_id',$lang_id)->delete();


                foreach ($request->book_id as $key => $value_book) {

                    if ($value_book != "") {
                        $PartnerPageBook = PartnerPageBook::find($value_book);
                    } else {
                        $PartnerPageBook = new PartnerPageBook();
                    }

                    if ($request->hasFile('book_image')) {
                        if (isset($request->book_image[$key])) {
                            $files = $request->file('book_image')[$key];

                            $random_no       = uniqid();
                            $img             = $files;
                            $ext             = $files->getClientOriginalExtension();
                            $new_name        = $random_no . time() . '.' . $ext;
                            $destinationPath =  public_path('uploads/PartnerPage');
                            $img->move($destinationPath, $new_name);
                            $PartnerPageBook['book_image'] = $new_name;
                        }
                    }


                    $PartnerPageBook['partner_page_id'] = $partner_page_id;

                    $PartnerPageBook->save();

                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('partner_page_book_language',['language_id'=>$value['id'],'partner_page_id' => $partner_page_id,'partner_page_book_id'=> $PartnerPageBook->id ],'row')) {  

                            $PartnerPageBookLanguage = new PartnerPageBookLanguage();
                            $PartnerPageBookLanguage['partner_page_id']          = $partner_page_id;
                            $PartnerPageBookLanguage['language_id']              = $value['id'];
                            $PartnerPageBookLanguage['partner_page_book_id']     = $PartnerPageBook->id;
                            $PartnerPageBookLanguage['book_title']               = isset($request->book_title[$value['id']][$key]) ?  $request->book_title[$value['id']][$key] : $request->book_title[$lang_id][$key];   
                            $PartnerPageBookLanguage['book_description']         = isset($request->book_description[$value['id']][$key]) ?  $request->book_description[$value['id']][$key] : $request->book_description[$lang_id][$key]; 
                            $PartnerPageBookLanguage->save();
                        }
                    }
                }
            }

            // Activities Images----------------------------------------------------
            if (isset($request->activity_image_id)) {

                $PartnerPageActivitiesImage = PartnerPageActivitiesImage::where('partner_page_id', $request->id)->get();
                foreach ($PartnerPageActivitiesImage as $key => $image_delete) {
                    if (!in_array($image_delete['id'], $request->activity_image_id)) {
                        PartnerPageActivitiesImage::where('id', $image_delete['id'])->delete();
                    }
                }
            }
            if ($request->hasFile('files_act')) {
                $files = $request->file('files_act');
                foreach ($files as $fileKey => $image) {
                    $PartnerPageActivitiesImage = new PartnerPageActivitiesImage();
                    $random_no  = Str::random(5);
                    $PartnerPageActivitiesImage['activity_images'] = $newImage = time() . $random_no  . '.' . $image->getClientOriginalExtension();

                    $destinationPath = public_path('uploads/PartnerPage');
                    $imgFile = Image::make($image->path());

                    $height =  $imgFile->height();
                    $width  =  $imgFile->width();

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

                    $destinationPath =  public_path('uploads/PartnerPage');
                    $imgFile->save($destinationPath . '/' . $newImage);
                    $PartnerPageActivitiesImage['partner_page_id']    =   $PartnerPage->id;
                    $PartnerPageActivitiesImage->save();
                }
            }


            return redirect()->route('admin.partner_page.edit', encrypt(1))->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                   = checkDecrypt($id);
            $common['title']     = "Edit Partners Login";
            $common['button']    = "Update";

            $get_partner_page                = PartnerPage::where('id', $id)->first();
            $get_partner_page_language       = PartnerPageLanguage::where("partner_page_id", $id)->get();

            $get_partner_page_slider_image   = PartnerPageSliderImage::where("partner_page_id", $id)->get();

            $get_partner_page_facility          = PartnerPageFacility::where("partner_page_id", $id)->get();
            $get_partner_page_facility_language = PartnerPageFacilityLanguage::where("partner_page_id", $id)->get();

            $get_partner_page_book          = PartnerPageBook::where("partner_page_id", $id)->get();
            $get_partner_page_book_language = PartnerPageBookLanguage::where("partner_page_id", $id)->get();

            $get_partner_page_activity_image   = PartnerPageActivitiesImage::where("partner_page_id", $id)->get();

            $get_slider_images           = PageSliders::where(['page_id' => $id, 'page' => 'partner_Page'])->get();
            $get_slider_images_language  = PageSlidersLanguage::where(['page_id' => $id, 'page' => 'partner_Page'])->get();

            if (!$get_partner_page) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.Partner_Page.add_partner_page', compact('common', 'get_partner_page', 'languages', 'get_partner_page_language', 'get_partner_page_slider_image', 'get_partner_page_facility', 'get_partner_page_facility_language', 'FAC', 'get_partner_page_book', 'get_partner_page_book_language', 'BOO', 'get_partner_page_activity_image', 'get_slider_images', 'get_slider_images_language', 'LSI','lang_id'));
    }
}
