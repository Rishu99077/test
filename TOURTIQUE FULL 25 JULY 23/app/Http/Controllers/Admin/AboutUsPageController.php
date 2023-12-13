<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\AboutUsPage;
use App\Models\AboutUsPageLanguage;
use App\Models\AboutUsPageSliderImage;
use App\Models\AboutUsPagefacility;
use App\Models\AboutUsPagefacilityLanguage;
use App\Models\AboutUsPagechoose;
use App\Models\AboutUsPagechooseLanguage;
use App\Models\BannerOverview;
use App\Models\BannerOverviewLanguage;
use App\Models\PageSliders;
use App\Models\PageSlidersLanguage;
use App\Models\AboutUsPageService;
use App\Models\AboutUsPageServiceLanguage;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Str;

class AboutUsPageController extends Controller
{
    ///Add About Us Page
    public function add_about_us_page(Request $request, $id = '')
    {
        $common = [];
        Session::put('TopMenu', 'Pages');
        Session::put('SubMenu', 'About Us Page');

        $common['title']                = translate('Add About Us');
        $common['button']               = translate('Save');
        $get_about_us_page              = getTableColumn('about_us_page');
        $get_about_us_page_language     = '';
        $languages                      = Language::where(ConditionQuery())->get();
        $get_about_us_page_slider_image = [];
        $get_banner_over_view           = [];
        $get_about_us_facility          = [];
        $get_banner_over_view_language  = [];
        $get_about_us_facility_language = [];
        $GPF                            = getTableColumn('about_us_page_facility');
        $GBO                            = getTableColumn('banner_overview');

        $get_about_us_choose            = [];
        $get_about_us_choose_language   = [];
        $CHO                            = getTableColumn('about_us_page_choose');

        $get_about_us_service            = [];
        $get_about_us_service_language   = [];
        $APS                             = getTableColumn('about_us_services');

        $get_slider_images              = [];
        $get_slider_images_language     = [];
        $LSI                = getTableColumn('pages_slider');

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];
        $get_languages = Language::where(['status'=>'Active','is_delete' => 0])->get();

        if ($request->isMethod('post')) {
            $req_fields = [];
            $req_fields['title.*'] = 'required';

            $errormsg = [
                'title.*' => translate('Title'),
            ];

            $validation = Validator::make(
                $request->all(),
                $req_fields,
                [
                    'required' => 'The :attribute field is required.',
                ],
                $errormsg,
            );

            // echo "<pre>";
            // print_r($request->all());
            // echo "</pre>";die();

            if ($validation->fails()) {
                return back()
                    ->withErrors($validation)
                    ->withInput();
            }

            if ($request->id != '') {
                $message = translate('Update Successfully');
                $status = 'success';
                $AboutUsPage = AboutUsPage::find($request->id);
                AboutUsPageLanguage::where('about_us_page_id', $request->id)->where('language_id',$lang_id)->delete();
            } else {
                $message     = translate('Add Successfully');
                $status      = 'success';
                $AboutUsPage = new AboutUsPage();
            }

            if ($request->hasFile('vision_image')) {
                if (isset($request->vision_image)) {
                    $files = $request->file('vision_image');
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
                    $destinationPath = public_path('uploads/AboutUsPage');
                    $imgFile->save($destinationPath . '/' . $new_name);
                    $AboutUsPage['vision_image'] = $new_name;
                }
            }

            if ($request->hasFile('detail_image')) {
                if (isset($request->detail_image)) {
                    $files = $request->file('detail_image');

                    $random_no = uniqid();
                    $img       = $files;
                    $ext       = $files->getClientOriginalExtension();
                    $new_name  = $random_no . time() . '.' . $ext;
                    $imgFile   = Image::make($files->path());
                    $height    = $imgFile->height();
                    $width     = $imgFile->width();
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
                    $destinationPath = public_path('uploads/AboutUsPage');
                    $imgFile->save($destinationPath . '/' . $new_name);
                    $AboutUsPage['detail_image'] = $new_name;
                }
            }

            if ($request->hasFile('banner_image')) {
                if (isset($request->banner_image)) {
                    $files = $request->file('banner_image');
                    $random_no       = uniqid();
                    $img             = $files;
                    $ext             = $files->getClientOriginalExtension();
                    $new_name        = $random_no . time() . '.' . $ext;
                    $destinationPath = public_path('uploads/AboutUsPage');
                    $img->move($destinationPath, $new_name);
                    $AboutUsPage['banner_image'] = $new_name;
                }
            }

            $AboutUsPage['status'] = 'Active';
            $AboutUsPage->save();

            $about_us_page_id = $AboutUsPage->id;

            

            if (!empty($request->title)) {

                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('about_us_page_language',['language_id'=>$value['id'],'about_us_page_id'=>$AboutUsPage->id],'row')) {    

                        $AboutUsPageLanguage = new AboutUsPageLanguage();
                    
                        $AboutUsPageLanguage->title = isset($request->title[$value['id']]) ?  $request->title[$value['id']] : $request->title[$lang_id];
                        $AboutUsPageLanguage->description = isset($request->description[$value['id']]) ? change_str($request->description[$value['id']]) : $request->description[$lang_id];

                        $AboutUsPageLanguage->vision_title = isset($request->vision_title[$value['id']]) ?  $request->vision_title[$value['id']] : $request->vision_title[$lang_id];   
                        $AboutUsPageLanguage->vision_description = isset($request->vision_description[$value['id']]) ? change_str($request->vision_description[$value['id']]) : $request->vision_description[$lang_id]; 

                        $AboutUsPageLanguage->detail_title = isset($request->detail_title[$value['id']]) ?  $request->detail_title[$value['id']] : $request->detail_title[$lang_id];  
                        $AboutUsPageLanguage->detail_description = isset($request->detail_description[$value['id']]) ? change_str($request->detail_description[$value['id']]) : $request->detail_description[$lang_id];  

                        $AboutUsPageLanguage->service_heading_title = isset($request->service_heading_title[$value['id']]) ?  $request->service_heading_title[$value['id']] : $request->service_heading_title[$lang_id]; 

                        $AboutUsPageLanguage->language_id = $value['id'];
                        $AboutUsPageLanguage->about_us_page_id = $AboutUsPage->id;
                        $AboutUsPageLanguage->save();
                    }
                }
            }

            //Banner OverViwe
            if (isset(($request->over_view_id))) {
                if (!empty($request->over_view_id)) {
                    $BannerOverviewdelete = BannerOverview::whereNotIn('id', $request->over_view_id)->where('page', 'about_us_page')->delete();
                    BannerOverviewLanguage::where('page', 'about_us_page')->orderBy('overview_id', 'desc')->where('langauge_id',$lang_id)->delete();
                    foreach ($request->over_view_id as $over_key => $over_value) {

                        if ($over_value != '') {
                            $BannerOverview       = BannerOverview::find($over_value);
                        } else {
                            $BannerOverview       = new BannerOverview();
                        }
                        $BannerOverview->page     = "about_us_page";
                        if ($request->hasFile('overview_image')) {
                            if (isset($request->overview_image[$over_key])) {
                                $files = $request->file('overview_image')[$over_key];
                                $random_no       = uniqid();
                                $img             = $files;
                                $ext             = $files->getClientOriginalExtension();
                                $new_name        = $random_no . time() . '.' . $ext;
                                $destinationPath = public_path('uploads/AboutUsPage');
                                $img->move($destinationPath, $new_name);
                                $BannerOverview->image = $new_name;
                            }
                        }
                        $BannerOverview->save();

                        foreach ($get_languages as $lang_key => $value) {
                            if (!getDataFromDB('banner_overview_language',['langauge_id'=>$value['id'],'overview_id' => $BannerOverview->id,'page'=> 'about_us_page' ],'row')) {     
                                $BannerOverviewLanguage                  = new BannerOverviewLanguage();
                                $BannerOverviewLanguage->overview_id     = $BannerOverview->id;
                                $BannerOverviewLanguage->page            = "about_us_page";
                                $BannerOverviewLanguage->langauge_id     = $value['id'];
                                $BannerOverviewLanguage->title           = isset($request->over_view_title[$value['id']][$over_key]) ?  $request->over_view_title[$value['id']][$over_key] : $request->over_view_title[$lang_id][$over_key];
                                $BannerOverviewLanguage->save();
                            }
                        }
                    }
                }
            }


            // Article
            if ($request->facility_title) {
                // AboutUsPagefacility::where(["about_us_page_id" => $about_us_page_id])->delete();
                AboutUsPagefacilityLanguage::where(['about_us_page_id' => $about_us_page_id])->where('language_id',$lang_id)->delete();

                foreach ($request->facility_id as $key => $value_7) {
                    if ($value_7 != '') {
                        $AboutUsPagefacility = AboutUsPagefacility::find($value_7);
                    } else {
                        $AboutUsPagefacility = new AboutUsPagefacility();
                    }

                    $AboutUsPagefacility['about_us_page_id'] = $about_us_page_id;
                    if ($request->hasFile('facility_image')) {
                        if (isset($request->facility_image[$key])) {
                            $files = $request->file('facility_image')[$key];

                            $random_no = uniqid();
                            $img = $files;
                            $ext = $files->getClientOriginalExtension();
                            $new_name = $random_no . time() . '.' . $ext;
                            $destinationPath = public_path('uploads/AboutUsPage');
                            $img->move($destinationPath, $new_name);
                            $AboutUsPagefacility['facility_image'] = $new_name;
                        }
                    }

                    $AboutUsPagefacility->save();

                    
                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('about_us_page_facility_language',['language_id'=>$value['id'],'about_us_page_id' => $about_us_page_id,'about_page_facility_id'=> $AboutUsPagefacility->id ],'row')) {   
                            $AboutUsPagefacilityLanguage = new AboutUsPagefacilityLanguage();
                            $AboutUsPagefacilityLanguage['about_us_page_id'] = $about_us_page_id;
                            $AboutUsPagefacilityLanguage['language_id'] = $value['id'];
                            $AboutUsPagefacilityLanguage['about_page_facility_id'] = $AboutUsPagefacility->id;
                            $AboutUsPagefacilityLanguage['facility_title'] = isset($request->facility_title[$value['id']][$key]) ?  $request->facility_title[$value['id']][$key] : $request->facility_title[$lang_id][$key];
                            $AboutUsPagefacilityLanguage['facility_description'] = isset($request->facility_description[$value['id']][$key]) ? change_str($request->facility_description[$value['id']][$key]) : $request->facility_description[$lang_id][$key];
                            $AboutUsPagefacilityLanguage->save();
                        }
                    }
                }
            }

            // Why choose Us
            if ($request->choose_title) {
                // AboutUsPagechoose::where(["about_us_page_id" => $about_us_page_id])->delete();
                AboutUsPagechooseLanguage::where(['about_us_page_id' => $about_us_page_id])->where('language_id',$lang_id)->delete();

                foreach ($request->choose_id as $key => $value_choose) {
                    if ($value_choose != '') {
                        $AboutUsPagechoose = AboutUsPagechoose::find($value_choose);
                    } else {
                        $AboutUsPagechoose = new AboutUsPagechoose();
                    }

                    $AboutUsPagechoose['about_us_page_id'] = $about_us_page_id;
                    if ($request->hasFile('choose_image')) {
                        if (isset($request->choose_image[$key])) {
                            $files = $request->file('choose_image')[$key];

                            $random_no = uniqid();
                            $img = $files;
                            $ext = $files->getClientOriginalExtension();
                            $new_name = $random_no . time() . '.' . $ext;
                            $destinationPath = public_path('uploads/AboutUsPage');
                            $img->move($destinationPath, $new_name);
                            $AboutUsPagechoose['choose_image'] = $new_name;
                        }
                    }

                    $AboutUsPagechoose->save();
                    
                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('about_us_page_choose_language',['language_id'=>$value['id'],'about_us_page_id' => $about_us_page_id,'about_page_choose_id'=> $AboutUsPagechoose->id ],'row')) {  
                            $AboutUsPagechooseLanguage = new AboutUsPagechooseLanguage();
                            $AboutUsPagechooseLanguage['about_us_page_id'] = $about_us_page_id;
                            $AboutUsPagechooseLanguage['language_id'] = $value['id'];
                            $AboutUsPagechooseLanguage['about_page_choose_id'] = $AboutUsPagechoose->id;
                            $AboutUsPagechooseLanguage['choose_title'] = isset($request->choose_title[$value['id']][$key]) ?  $request->choose_title[$value['id']][$key] : $request->choose_title[$lang_id][$key];
                            $AboutUsPagechooseLanguage['choose_description'] = isset($request->choose_description[$value['id']][$key]) ? change_str($request->choose_description[$value['id']][$key]) : $request->choose_description[$lang_id][$key];
                            $AboutUsPagechooseLanguage->save();
                        }
                    }
                }
            }

            // Slider Images
            $get_pageSlider = PageSliders::where(['page' => 'about_us_page'])->get();
            foreach ($get_pageSlider as $key => $val) {
                if (!in_array($val['id'], $request->slider_image_id)) {
                    PageSliders::where('id', $val['id'])->delete();
                }
            }
            if (!empty($request->slider_title)) {
                if ($request->slider_title) {

                    PageSlidersLanguage::where(['page_id' => $about_us_page_id, 'page' => 'about_us_page'])->where('language_id',$lang_id)->delete();

                    foreach ($request->slider_image_id as $key => $over_value) {

                        if ($over_value != '') {
                            $PageSliders       = PageSliders::find($over_value);
                        } else {
                            $PageSliders       = new PageSliders();
                        }

                        $PageSliders->page_id  = $about_us_page_id;
                        $PageSliders->page     = "about_us_page";

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
                            if (!getDataFromDB('pages_slider_language',['language_id'=>$value['id'],'pages_slider_id' => $page_slider_id,'page'=> 'about_us_page','page_id'=> $about_us_page_id],'row')) {  
                        
                                $PageSlidersLanguage = new PageSlidersLanguage();
                                $PageSlidersLanguage['page_id']            = $about_us_page_id;
                                $PageSlidersLanguage['pages_slider_id']    = $page_slider_id;
                                $PageSlidersLanguage['page']               = 'about_us_page';
                                $PageSlidersLanguage['language_id']        = $value['id'];
                                $PageSlidersLanguage['title']              = isset($request->slider_title[$value['id']][$key]) ?  $request->slider_title[$value['id']][$key] : $request->slider_title[$lang_id][$key];
                                $PageSlidersLanguage['description']        = isset($request->slider_description[$value['id']][$key]) ?  $request->slider_description[$value['id']][$key] : $request->slider_description[$lang_id][$key];  
                            
                                $PageSlidersLanguage->save();
                            }
                        }
                    }
                }
            }



            // Services -----------------------
            if ($request->service_title) {
                // AboutUsPageService::where(["about_us_page_id" => $about_us_page_id])->delete();
                AboutUsPageServiceLanguage::where(['about_us_page_id' => $about_us_page_id])->where('language_id',$lang_id)->delete();

                foreach ($request->service_id as $key => $value_service) {

                    if ($value_service != '') {
                        $AboutUsPageService       = AboutUsPageService::find($value_service);
                    } else {
                        $AboutUsPageService       = new AboutUsPageService();
                    }

                    $AboutUsPageService['about_us_page_id'] = $about_us_page_id;

                    $AboutUsPageService->save();
                    
                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('about_us_services_language',['language_id'=>$value['id'],'about_us_page_id' => $about_us_page_id,'about_us_services_id'=> $AboutUsPageService->id ],'row')) { 
                            $AboutUsPageServiceLanguage = new AboutUsPageServiceLanguage();
                            $AboutUsPageServiceLanguage['about_us_page_id'] = $about_us_page_id;
                            $AboutUsPageServiceLanguage['language_id'] = $value['id'];
                            $AboutUsPageServiceLanguage['about_us_services_id'] = $AboutUsPageService->id;
                            $AboutUsPageServiceLanguage['service_title'] = isset($request->service_title[$value['id']][$key]) ?  $request->service_title[$value['id']][$key] : $request->service_title[$lang_id][$key];
                            $AboutUsPageServiceLanguage->save();
                        }
                    }
                }
            }


            return redirect()
                ->route('admin.about_us_page.edit', encrypt(1))
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'No Record Found']);
            }
            $id = checkDecrypt($id);
            $common['title'] = 'Edit About Us';
            $common['button'] = 'Update';

            $get_about_us_page              = AboutUsPage::where('id', $id)->first();
            $get_about_us_page_language     = AboutUsPageLanguage::where('about_us_page_id', $id)->get();
            $get_about_us_facility          = AboutUsPagefacility::where('about_us_page_id', $id)->get();
            $get_about_us_facility_language = AboutUsPagefacilityLanguage::where('about_us_page_id', $id)->get();
            $get_about_us_choose            = AboutUsPagechoose::where('about_us_page_id', $id)->get();
            $get_about_us_choose_language   = AboutUsPagechooseLanguage::where('about_us_page_id', $id)->get();
            $get_banner_over_view           = BannerOverview::where('page', 'about_us_page')->get();
            $get_banner_over_view_language  = BannerOverviewLanguage::where('page', 'advertisment_us_page')->get();


            $get_about_us_service            = AboutUsPageService::where('about_us_page_id', $id)->get();
            $get_about_us_service_language   = AboutUsPageServiceLanguage::where('about_us_page_id', $id)->get();

            $get_slider_images           = PageSliders::where(['page_id' => $id, 'page' => 'about_us_page'])->get();
            $get_slider_images_language  = PageSlidersLanguage::where(['page_id' => $id, 'page' => 'about_us_page'])->get();

            if (!$get_about_us_page) {
                return back()->withErrors(['error' => 'Something went wrong']);
            }
        }
        return view('admin.aboutus_page.add_aboutus_page', compact('common', 'get_about_us_page', 'GBO', 'languages', 'get_about_us_page_language', 'get_about_us_page_slider_image', 'get_about_us_facility', 'get_about_us_facility_language', 'get_banner_over_view_language', 'GPF', 'get_about_us_choose', 'get_about_us_choose_language', 'CHO', 'get_banner_over_view', 'get_slider_images', 'get_slider_images_language', 'LSI', 'get_about_us_service', 'get_about_us_service_language', 'APS','lang_id' ));
    }
}
