<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerOverview;
use App\Models\BannerOverviewLanguage;

use App\Models\AdvertismentPage;
use App\Models\AdvertismentPageLanguage;

use App\Models\AdvertiseWithUs;
use App\Models\AdvertiseWithUsLanguage;

use App\Models\AdvertisePagechoose;
use App\Models\AdvertisePagechooseLanguage;

use App\Models\PageSliders;
use App\Models\PageSlidersLanguage;

use App\Models\Language;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Str;

class AdvertismentPageController extends Controller
{
    ///Add Advertisment Us Page
    public function add_adv_us_page(Request $request, $id = '')
    {
        $common = [];
        Session::put('TopMenu', 'Pages');
        Session::put('SubMenu', 'Advertise Us Page');

        $common['title']                = translate('Add Advertise Us');
        $common['button']               = translate('Save');

        $get_banner_over_view           = [];
        $get_banner_over_view_language  = [];

        $get_advertise_us_page_language = [];
        $get_advertise_us_page          = getTableColumn('advertisment_page');
        $languages                      = Language::where(ConditionQuery())->get();

        $get_about_us_page_slider_image = [];
        $GBO                            = getTableColumn('banner_overview');

        $get_advertise_choose            = [];
        $get_advertise_choose_language   = [];
        $CHO                             = getTableColumn('advertise_choose_us');

        $GAWU                            = getTableColumn('advertise_with_us');
        $get_advertise_with_us          = [];
        $get_advertise_with_us_language = [];

        $get_slider_images              = [];
        $get_slider_images_language     = [];
        $LSI                = getTableColumn('pages_slider');

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];
        $get_languages = Language::where(['status'=>'Active','is_delete' => 0])->get();


        if ($request->isMethod('post')) {

            // echo "<pre>";
            // print_r($request->all());
            // echo "</pre>";die();


            $req_fields = [];
            $req_fields['description.*'] = 'required';

            $errormsg = [
                'description.*' => translate('Title'),
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
            // print_die($request->all());

            if ($request->id != '') {
                $message            = translate('Update Successfully');
                $status             = 'success';
                $AdvertismentPage   = AdvertismentPage::find($request->id);
                AdvertismentPageLanguage::where('advertisment_page_id', $request->id)->where('language_id',$lang_id)->delete();
            } else {
                $message     = translate('Add Successfully');
                $status      = 'success';
                $AdvertismentPage = new AdvertismentPage();
            }


            if ($request->hasFile('choose_image')) {
                if (isset($request->choose_image)) {
                    $files = $request->file('choose_image');
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
                    $destinationPath = public_path('uploads/advertisment_page');
                    $imgFile->save($destinationPath . '/' . $new_name);
                    $AdvertismentPage['choose_image'] = $new_name;
                }
            }

            $AdvertismentPage['status'] = 'Active';
            $AdvertismentPage->save();

            $advertisment_us_page_id = $AdvertismentPage->id;

            //Banner OverView
            if (isset(($request->over_view_id))) {
                if (!empty($request->over_view_id)) {
                    $BannerOverviewdelete = BannerOverview::whereNotIn('id', $request->over_view_id)->where('page', 'advertisment_us_page')->delete();
                    BannerOverviewLanguage::where('page', 'advertisment_us_page')->where('langauge_id',$lang_id)->delete();
                    foreach ($request->over_view_id as $over_key => $over_value) {

                        if ($over_value != '') {
                            $BannerOverview       = BannerOverview::find($over_value);
                        } else {
                            $BannerOverview       = new BannerOverview();
                        }
                        $BannerOverview->page     = "advertisment_us_page";
                        if ($request->hasFile('overview_image')) {
                            if (isset($request->overview_image[$over_key])) {
                                $files = $request->file('overview_image')[$over_key];
                                $random_no       = uniqid();
                                $img             = $files;
                                $ext             = $files->getClientOriginalExtension();
                                $new_name        = $random_no . time() . '.' . $ext;
                                $destinationPath = public_path('uploads/advertisment_page/banner_overview');
                                $img->move($destinationPath, $new_name);
                                $BannerOverview->image = $new_name;
                            }
                        }
                        $BannerOverview->save();

                        foreach ($get_languages as $lang_key => $value) {
                            if (!getDataFromDB('banner_overview_language',['langauge_id'=>$value['id'],'overview_id' => $BannerOverview->id,'page'=> 'advertisment_us_page' ],'row')) {   
                                $BannerOverviewLanguage                  = new BannerOverviewLanguage();
                                $BannerOverviewLanguage->overview_id     = $BannerOverview->id;
                                $BannerOverviewLanguage->page            = "advertisment_us_page";
                                $BannerOverviewLanguage->langauge_id     = $value['id'];
                                $BannerOverviewLanguage->title           = isset($request->over_view_title[$value['id']][$over_key]) ?  $request->over_view_title[$value['id']][$over_key] : $request->over_view_title[$lang_id][$over_key]; 
                                $BannerOverviewLanguage->save();
                            }
                        }
                    }
                }
            }

            if (!empty($request->description)) {

                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('advertisment_page_language',['language_id'=>$value['id'],'advertisment_page_id'=>$advertisment_us_page_id ],'row')) {    
                        $AdvertismentPageLanguage = new AdvertismentPageLanguage();
                   
                        $AdvertismentPageLanguage->advertisment_page_id     = $advertisment_us_page_id;
                        // $AdvertismentPageLanguage->title                    = $value;
                        // $AdvertismentPageLanguage->short_description        = $request->short_description[$key];
                        $AdvertismentPageLanguage->description              = isset($request->description[$value['id']]) ? change_str($request->description[$value['id']]) : $request->description[$lang_id];

                        $AdvertismentPageLanguage->advertise_with_us_title  = isset($request->advertise_with_us_title[$value['id']]) ?  $request->advertise_with_us_title[$value['id']] : $request->advertise_with_us_title[$lang_id]; 
                        $AdvertismentPageLanguage->advertise_with_us_desc   = isset($request->advertise_with_us_desc[$value['id']]) ?  $request->advertise_with_us_desc[$value['id']] : $request->advertise_with_us_desc[$lang_id]; 
                        $AdvertismentPageLanguage->why_choose_title         = isset($request->why_choose_title[$value['id']]) ?  $request->why_choose_title[$value['id']] : $request->why_choose_title[$lang_id]; 

                        $AdvertismentPageLanguage->footer_text              = isset($request->footer_text[$value['id']]) ?  $request->footer_text[$value['id']] : $request->footer_text[$lang_id]; 
                        $AdvertismentPageLanguage->footer_description       = isset($request->footer_description[$value['id']]) ? change_str($request->footer_description[$value['id']]) : $request->footer_description[$lang_id];
                        $AdvertismentPageLanguage->language_id              = $value['id'];

                        $AdvertismentPageLanguage->save();
                    }
                }
            }

            // Article
            if ($request->facility_id) {

                $get_AdvertiseWith = AdvertiseWithUs::get();
                foreach ($get_AdvertiseWith as $key => $get_delete) {
                    if (!in_array($get_delete['id'], $request->facility_id)) {
                        AdvertiseWithUs::where('id', $get_delete['id'])->delete();
                    }
                }
                // AdvertiseWithUsLanguage::truncate();
                AdvertiseWithUsLanguage::where('advertisment_page_id', $advertisment_us_page_id)->where('language_id',$lang_id)->delete();

                foreach ($request->facility_id as $key => $value_7) {
                    if ($value_7 != '') {
                        $AdvertiseWithUs = AdvertiseWithUs::find($value_7);
                    } else {
                        $AdvertiseWithUs = new AdvertiseWithUs();
                    }

                    if ($request->hasFile('facility_image')) {
                        if (isset($request->facility_image[$key])) {
                            $files = $request->file('facility_image')[$key];

                            $random_no = uniqid();
                            $img = $files;
                            $ext = $files->getClientOriginalExtension();
                            $new_name = $random_no . time() . '.' . $ext;
                            $destinationPath = public_path('uploads/advertisment_page');
                            $img->move($destinationPath, $new_name);
                            $AdvertiseWithUs['image'] = $new_name;
                        }
                    }
                    $AdvertiseWithUs['advertisment_page_id']     = $advertisment_us_page_id;
                    $AdvertiseWithUs['status'] = 'Active';
                    $AdvertiseWithUs['sort_order'] = $request->sort_order[$key];

                    $AdvertiseWithUs->save();
                    
                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('advertise_with_us_languge',['language_id'=>$value['id'],'advertisment_page_id'=>$advertisment_us_page_id ,'advertise_with_us_id'=>$AdvertiseWithUs->id],'row')) {     
                            $AdvertiseWithUsLanguage = new AdvertiseWithUsLanguage();
                            $AdvertiseWithUsLanguage['advertisment_page_id'] = $advertisment_us_page_id;
                            $AdvertiseWithUsLanguage['advertise_with_us_id'] = $AdvertiseWithUs->id;
                            $AdvertiseWithUsLanguage['language_id']          = $value['id'];
                            $AdvertiseWithUsLanguage['title']                = isset($request->facility_title[$value['id']][$key]) ? change_str($request->facility_title[$value['id']][$key]) : $request->facility_title[$lang_id][$key];
                            $AdvertiseWithUsLanguage['description']          = isset($request->facility_description[$value['id']][$key]) ? change_str($request->facility_description[$value['id']][$key]) : $request->facility_description[$lang_id][$key];
                            $AdvertiseWithUsLanguage->save();
                        }
                    }
                }
            }

            // Why choose Us
            if ($request->choose_id) {

                $get_Advertisechoose = AdvertisePagechoose::get();
                foreach ($get_Advertisechoose as $key => $get_delete) {
                    if (!in_array($get_delete['id'], $request->choose_id)) {
                        AdvertisePagechoose::where('id', $get_delete['id'])->delete();
                    }
                }

                AdvertisePagechooseLanguage::where('advertisment_page_id', $advertisment_us_page_id)->where('language_id',$lang_id)->delete();
                // AdvertisePagechooseLanguage::truncate();

                foreach ($request->choose_id as $key => $value_choose) {
                    if ($value_choose != '') {
                        $AdvertisePagechoose = AdvertisePagechoose::find($value_choose);
                    } else {
                        $AdvertisePagechoose = new AdvertisePagechoose();
                    }

                    $AdvertisePagechoose['advertisment_page_id']     = $advertisment_us_page_id;
                    $AdvertisePagechoose['status'] = 'Active';
                    $AdvertisePagechoose['choose_sort_order'] = $request->choose_sort_order[$key];


                    $AdvertisePagechoose->save();
                    
                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('advertise_choose_us_language',['language_id'=>$value['id'],'advertisment_page_id'=>$advertisment_us_page_id ,'advertise_choose_id'=>$AdvertisePagechoose->id],'row')) {   
                            $AdvertisePagechooseLanguage = new AdvertisePagechooseLanguage();
                            $AdvertisePagechooseLanguage['advertisment_page_id']= $advertisment_us_page_id;
                            $AdvertisePagechooseLanguage['language_id']         = $value['id'];
                            $AdvertisePagechooseLanguage['advertise_choose_id'] = $AdvertisePagechoose->id;
                            $AdvertisePagechooseLanguage['description']         = isset($request->choose_description[$value['id']][$key]) ? change_str($request->choose_description[$value['id']][$key]) : $request->choose_description[$lang_id][$key];
                            $AdvertisePagechooseLanguage->save();
                        }
                    }
                }
            }

            // Slider Images
            $get_pageSlider = PageSliders::where(['page' => 'advertisement_page'])->get();
            foreach ($get_pageSlider as $key => $val) {
                if (!in_array($val['id'], $request->slider_image_id)) {
                    PageSliders::where('id', $val['id'])->delete();
                }
            }
            if (!empty($request->slider_title)) {
                if ($request->slider_title) {

                    PageSlidersLanguage::where(['page_id' => $advertisment_us_page_id, 'page' => 'advertisement_page'])->where('language_id',$lang_id)->delete();

                    foreach ($request->slider_image_id as $key => $over_value) {

                        if ($over_value != '') {
                            $PageSliders       = PageSliders::find($over_value);
                        } else {
                            $PageSliders       = new PageSliders();
                        }

                        $PageSliders->page_id  = $advertisment_us_page_id;
                        $PageSliders->page     = "advertisement_page";

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
                            if (!getDataFromDB('pages_slider_language',['language_id'=>$value['id'],'pages_slider_id' => $page_slider_id,'page'=> 'advertisement_page' ],'row')) {  
                                $PageSlidersLanguage = new PageSlidersLanguage();
                                $PageSlidersLanguage['page_id']            = 1;
                                $PageSlidersLanguage['pages_slider_id']    = $page_slider_id;
                                $PageSlidersLanguage['page']               = 'advertisement_page';
                                $PageSlidersLanguage['language_id']        = $value['id'];
                                $PageSlidersLanguage['title']              = isset($request->slider_title[$value['id']][$key]) ?  $request->slider_title[$value['id']][$key] : $request->slider_title[$lang_id][$key];
                                $PageSlidersLanguage['description']        = isset($request->slider_description[$value['id']][$key]) ?  $request->slider_description[$value['id']][$key] : $request->slider_description[$lang_id][$key];  
                                $PageSlidersLanguage->save();
                            }
                        }

                    }
                }
            }

            return redirect()
                ->route('admin.advertise_us_page.edit', encrypt(1))
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'No Record Found']);
            }
            $id = checkDecrypt($id);
            $common['title'] = 'Edit Advertise Us';
            $common['button'] = 'Update';

            $get_advertise_us_page              = AdvertismentPage::where('id', $id)->first();
            $get_advertise_us_page_language     = AdvertismentPageLanguage::where('advertisment_page_id', $id)->get();

            $get_advertise_with_us              = AdvertiseWithUs::orderBy('id', 'desc')->get();
            $get_advertise_with_us_language     = AdvertiseWithUsLanguage::orderBy('id', 'desc')->get();

            $get_advertise_choose            = AdvertisePagechoose::get();
            $get_advertise_choose_language   = AdvertisePagechooseLanguage::get();

            $get_banner_over_view           = BannerOverview::where('page', 'advertisment_us_page')->get();
            $get_banner_over_view_language  = BannerOverviewLanguage::where('page', 'advertisment_us_page')->get();


            $get_slider_images           = PageSliders::where(['page_id' => $id, 'page' => 'advertisement_page'])->get();
            $get_slider_images_language  = PageSlidersLanguage::where(['page_id' => $id, 'page' => 'advertisement_page'])->get();
            if (!$get_advertise_us_page) {
                return back()->withErrors(['error' => 'Something went wrong']);
            }
        }
        return view('admin.advertisment_page.add_advertisment_page', compact('common', 'get_advertise_us_page', 'GAWU', 'languages', 'get_advertise_us_page_language', 'get_advertise_with_us_language', 'get_advertise_with_us', 'get_banner_over_view_language', 'get_advertise_choose', 'get_advertise_choose_language', 'CHO', 'get_banner_over_view', 'GBO', 'get_slider_images', 'get_slider_images_language', 'LSI','lang_id'));
    }
}
