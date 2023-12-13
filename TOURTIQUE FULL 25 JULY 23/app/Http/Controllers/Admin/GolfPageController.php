<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GolfPage;
use App\Models\GolfPageLanguage;

use App\Models\GolfPageFacility;
use App\Models\GolfPageFacilityLanguage;

use App\Models\PageSliders;
use App\Models\PageSlidersLanguage;


use App\Models\Language;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Str;

class GolfPageController extends Controller
{

    ///Add GolfPage
    public function add_golf_page(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Pages");
        Session::put("SubMenu", "Golf Page");

        $common['title']            = translate("Add Golf Page");
        $common['button']           = translate("Save");

        $get_golf_page              = getTableColumn('golf_page');
        $get_golf_page_language     = "";

        $languages                     = Language::where(ConditionQuery())->get();

        $get_slider_images              = [];
        $get_slider_images_language     = [];
        $LSI                = getTableColumn('pages_slider');

        $get_golf_page_facility                = [];
        $get_golf_page_facility_language       = [];
        $FAC                                = getTableColumn('golf_page_facility');

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
                $GolfPage = GolfPage::find($request->id);
                GolfPageLanguage::where("golf_page_id", $request->id)->where('language_id',$lang_id)->delete();

                $get_page_facility = GolfPageFacility::where('golf_page_id', $request->id)->get();
                foreach ($get_page_facility as $key => $get_pagefacility_delete) {
                    if (!in_array($get_pagefacility_delete['id'], $request->facility_id)) {
                        GolfPageFacility::where('id', $get_pagefacility_delete['id'])->delete();
                    }
                }
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $GolfPage = new GolfPage();
            }


            $GolfPage['status']    = isset($request->status)  ? "Active" : "Deactive";
            $GolfPage->save();

            $golf_page_id = $GolfPage->id;

            if (!empty($request->title)) {

                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('golf_page_language',['language_id'=>$value['id'],'golf_page_id'=>$GolfPage->id],'row')) {        
                        $GolfPageLanguage                             = new GolfPageLanguage();
                        $GolfPageLanguage->title                = isset($request->title[$value['id']]) ?  $request->title[$value['id']] : $request->title[$lang_id];
                        $GolfPageLanguage->description          = isset($request->description[$value['id']]) ? change_str($request->description[$value['id']]) : $request->description[$lang_id];
                        $GolfPageLanguage->short_description    = isset($request->short_description[$value['id']]) ?  $request->short_description[$value['id']] : $request->short_description[$lang_id];
                        $GolfPageLanguage->language_id          = $value['id'];
                        $GolfPageLanguage->golf_page_id         = $GolfPage->id;
                        $GolfPageLanguage->save();
                    }
                }
            }

            // Slider Images
            $get_pageSlider = PageSliders::where(['page' => 'golf_page'])->get();
            foreach ($get_pageSlider as $key => $val) {
                if (!in_array($val['id'], $request->over_view_id)) {
                    PageSliders::where('id', $val['id'])->delete();
                }
            }
            if (!empty($request->slider_title)) {
                if ($request->slider_title) {

                    PageSlidersLanguage::where(['page_id' => $golf_page_id, 'page' => 'golf_page'])->where('language_id',$lang_id)->delete();

                    foreach ($request->over_view_id as $key => $over_value) {

                        if ($over_value != '') {
                            $PageSliders       = PageSliders::find($over_value);
                        } else {
                            $PageSliders       = new PageSliders();
                        }

                        $PageSliders->page_id  = $golf_page_id;
                        $PageSliders->page     = "golf_page";

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
                            if (!getDataFromDB('pages_slider_language',['language_id'=>$value['id'],'pages_slider_id' => $page_slider_id,'page'=> 'golf_page' ],'row')) {  
                                $PageSlidersLanguage = new PageSlidersLanguage();
                                $PageSlidersLanguage['page_id']            = $golf_page_id;
                                $PageSlidersLanguage['pages_slider_id']    = $page_slider_id;
                                $PageSlidersLanguage['page']               = 'golf_page';
                                $PageSlidersLanguage['language_id']        = $value['id'];
                                $PageSlidersLanguage['title']              = isset($request->slider_title[$value['id']][$key]) ?  $request->slider_title[$value['id']][$key] : $request->slider_title[$lang_id][$key];
                                $PageSlidersLanguage['description']        = isset($request->slider_description[$value['id']][$key]) ?  $request->slider_description[$value['id']][$key] : $request->slider_description[$lang_id][$key];  
                                $PageSlidersLanguage->save();
                            }
                        }

                    }
                }
            }

            // Facility-------------------------------------------------------------


            if ($request->facility_title) {
                // GolfPageFacility::where(["golf_page_id" => $golf_page_id])->delete();
                GolfPageFacilityLanguage::where(["golf_page_id" => $golf_page_id])->where('language_id',$lang_id)->delete();


                foreach ($request->facility_id as $key => $value_fac) {

                    if ($value_fac != "") {
                        $GolfPageFacility = GolfPageFacility::find($value_fac);
                    } else {
                        $GolfPageFacility = new GolfPageFacility();
                    }

                    if ($request->hasFile('facility_image')) {
                        if (isset($request->facility_image[$key])) {
                            $files = $request->file('facility_image')[$key];

                            $random_no       = uniqid();
                            $img             = $files;
                            $ext             = $files->getClientOriginalExtension();
                            $new_name        = $random_no . time() . '.' . $ext;
                            $destinationPath =  public_path('uploads/GolfPage');
                            $img->move($destinationPath, $new_name);
                            $GolfPageFacility['facility_image'] = $new_name;
                        }
                    }

                    $GolfPageFacility['golf_page_id'] = $golf_page_id;

                    $GolfPageFacility->save();


                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('golf_page_facility_language',['language_id'=>$value['id'],'golf_page_id' => $golf_page_id,'golf_page_facility_id'=> $GolfPageFacility->id ],'row')) {    
                            $GolfPageFacilityLanguage = new GolfPageFacilityLanguage();
                            $GolfPageFacilityLanguage['golf_page_id']           = $golf_page_id;
                            $GolfPageFacilityLanguage['language_id']            = $value['id'];
                            $GolfPageFacilityLanguage['golf_page_facility_id']  = $GolfPageFacility->id;
                            $GolfPageFacilityLanguage['facility_title']         = isset($request->facility_title[$value['id']][$key]) ?  $request->facility_title[$value['id']][$key] : $request->facility_title[$lang_id][$key];
                            $GolfPageFacilityLanguage['facility_description']   = isset($request->facility_description[$value['id']][$key]) ? change_str($request->facility_description[$value['id']][$key]) : $request->facility_description[$lang_id][$key];
                            $GolfPageFacilityLanguage->save();
                        }
                    }
                }
            }

            return redirect()->route('admin.golf_page.edit', encrypt(1))->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                   = checkDecrypt($id);
            $common['title']     = "Edit Golf page";
            $common['button']    = "Update";

            $get_golf_page                = GolfPage::where('id', $id)->first();
            $get_golf_page_language       = GolfPageLanguage::where("golf_page_id", $id)->get();

            $get_slider_images           = PageSliders::where(['page_id' => $id, 'page' => 'golf_page'])->get();
            $get_slider_images_language  = PageSlidersLanguage::where(['page_id' => $id, 'page' => 'golf_page'])->get();

            $get_golf_page_facility          = GolfPageFacility::where("golf_page_id", $id)->get();
            $get_golf_page_facility_language = GolfPageFacilityLanguage::where("golf_page_id", $id)->get();


            if (!$get_golf_page) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.golf_page.add_golf_page', compact('common', 'get_golf_page', 'languages', 'get_golf_page_language', 'get_slider_images', 'get_golf_page_facility', 'get_golf_page_facility_language', 'FAC', 'LSI', 'get_slider_images_language','lang_id'));
    }
}
