<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerOverview;
use App\Models\BannerOverviewLanguage;

use App\Models\JoinPage;
use App\Models\JoinPageLanguage;

use App\Models\JoinPagechoose;
use App\Models\JoinPagechooseLanguage;

use App\Models\Language;

use App\Models\PageSliders;
use App\Models\PageSlidersLanguage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Str;

class JoinPageController extends Controller
{
    ///Add Join Us Page
    public function add_join_us_page(Request $request, $id = '')
    {
        $common = [];
        Session::put('TopMenu', 'Pages');
        Session::put('SubMenu', 'Join Us Page');

        $common['title']            = translate('Add Join Us');
        $common['button']           = translate('Save');
        $languages                  = Language::where(ConditionQuery())->get();

        $get_banner_over_view           = [];
        $get_banner_over_view_language  = [];
        $GBO                            = getTableColumn('banner_overview');

        $get_join_us_page           = getTableColumn('join_page');
        $get_join_us_page_language  = [];


        $get_join_choose            = [];
        $get_join_choose_language   = [];
        $CHO                        = getTableColumn('join_page_choose');

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
            //     die;
            if ($validation->fails()) {
                return back()
                    ->withErrors($validation)
                    ->withInput();
            }
            // print_die($request->all());

            if ($request->id != '') {
                $message            = translate('Update Successfully');
                $status             = 'success';
                $JoinPage   = JoinPage::find($request->id);
                JoinPageLanguage::where('join_page_id', $request->id)->where('language_id',$lang_id)->delete();
            } else {
                $message     = translate('Add Successfully');
                $status      = 'success';
                $JoinPage = new JoinPage();
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
                    $destinationPath = public_path('uploads/join_page');
                    $imgFile->save($destinationPath . '/' . $new_name);
                    $JoinPage['banner_image'] = $new_name;
                }
            }

            if ($request->hasFile('become_partner_image')) {
                if (isset($request->become_partner_image)) {
                    $files = $request->file('become_partner_image');
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
                    $destinationPath = public_path('uploads/join_page');
                    $imgFile->save($destinationPath . '/' . $new_name);
                    $JoinPage['become_partner_image'] = $new_name;
                }
            }

            $JoinPage['status'] = 'Active';
            $JoinPage->save();

            $join_us_page_id = $JoinPage->id;

            foreach ($get_languages as $lang_key => $value) {
                if (!getDataFromDB('join_page_language',['language_id'=>$value['id'],'join_page_id' => $join_us_page_id ],'row')) {     
                    $JoinPageLanguage = new JoinPageLanguage();
                
                    $JoinPageLanguage->join_page_id             = $join_us_page_id;
                    $JoinPageLanguage->title                    = isset($request->title[$value['id']]) ?  $request->title[$value['id']] : $request->title[$lang_id];
                    $JoinPageLanguage->short_description        = isset($request->short_description[$value['id']]) ?  $request->short_description[$value['id']] : $request->short_description[$lang_id];
                    
                    $JoinPageLanguage->description                = isset($request->description[$value['id']]) ? change_str($request->description[$value['id']]) : $request->description[$lang_id];
                    $JoinPageLanguage->become_partner_title       = isset($request->become_partner_title[$value['id']]) ?  $request->become_partner_title[$value['id']] : $request->become_partner_title[$lang_id]; 
                    $JoinPageLanguage->become_partner_description = isset($request->become_partner_description[$value['id']]) ? change_str($request->become_partner_description[$value['id']]) : $request->become_partner_description[$lang_id];
                    $JoinPageLanguage->language_id              = $value['id'];

                    $JoinPageLanguage->save();
                }
            }
            
            //Banner OverView
            if (isset(($request->over_view_id))) {
                if (!empty($request->over_view_id)) {
                    $BannerOverviewdelete = BannerOverview::whereNotIn('id', $request->over_view_id)->where('page', 'join_us_page')->delete();
                    BannerOverviewLanguage::where('page', 'join_us_page')->where('langauge_id',$lang_id)->delete();
                    foreach ($request->over_view_id as $over_key => $over_value) {

                        if ($over_value != '') {
                            $BannerOverview       = BannerOverview::find($over_value);
                        } else {
                            $BannerOverview       = new BannerOverview();
                        }
                        $BannerOverview->page     = "join_us_page";
                        if ($request->hasFile('overview_image')) {
                            if (isset($request->overview_image[$over_key])) {
                                $files = $request->file('overview_image')[$over_key];
                                $random_no       = uniqid();
                                $img             = $files;
                                $ext             = $files->getClientOriginalExtension();
                                $new_name        = $random_no . time() . '.' . $ext;
                                $destinationPath = public_path('uploads/join_page/banner_overview');
                                $img->move($destinationPath, $new_name);
                                $BannerOverview->image = $new_name;
                            }
                        }
                        $BannerOverview->save();

                        foreach ($get_languages as $lang_key => $value) {
                            if (!getDataFromDB('banner_overview_language',['langauge_id'=>$value['id'],'overview_id' => $BannerOverview->id,'page'=> 'join_us_page' ],'row')) {       
                                $BannerOverviewLanguage                  = new BannerOverviewLanguage();
                                $BannerOverviewLanguage->overview_id     = $BannerOverview->id;
                                $BannerOverviewLanguage->page            = "join_us_page";
                                $BannerOverviewLanguage->langauge_id     = $value['id'];
                                $BannerOverviewLanguage->title           = isset($request->over_view_title[$value['id']][$over_key]) ?  $request->over_view_title[$value['id']][$over_key] : $request->over_view_title[$lang_id][$over_key];
                                $BannerOverviewLanguage->save();
                            }
                        }
                    }
                }
            }

        
            if (isset($request->choose_id)) {
                $get_joinchoose = JoinPagechoose::where('join_page_id', $request->id)->get();
                foreach ($get_joinchoose as $key => $val_vou) {
                    if (!in_array($val_vou['id'], $request->choose_id)) {
                        JoinPagechoose::where('id', $val_vou['id'])->delete();
                    }
                }
            }

            // Why choose Us
            if ($request->choose_id) {
                JoinPagechooseLanguage::where(["join_page_id" => $join_us_page_id])->where('language_id',$lang_id)->delete();
                // JoinPagechooseLanguage::truncate();

                foreach ($request->choose_id as $key => $value_choose) {
                    if ($value_choose != '') {
                        $JoinPagechoose = JoinPagechoose::find($value_choose);
                    } else {
                        $JoinPagechoose = new JoinPagechoose();
                    }


                    if ($request->hasFile('choose_image')) {
                        if (isset($request->choose_image[$key])) {
                            $files = $request->file('choose_image')[$key];
                            $random_no       = uniqid();
                            $img             = $files;
                            $ext             = $files->getClientOriginalExtension();
                            $new_name        = $random_no . time() . '.' . $ext;
                            $destinationPath = public_path('uploads/join_page');
                            $img->move($destinationPath, $new_name);
                            $JoinPagechoose['choose_image'] = $new_name;
                        }
                    }


                    $JoinPagechoose['join_page_id']     = $join_us_page_id;
                    $JoinPagechoose['status'] = 'Active';

                    $JoinPagechoose->save();

                    
                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('join_page_choose_language',['language_id'=>$value['id'],'join_page_id' => $join_us_page_id,'join_choose_id'=> $JoinPagechoose->id ],'row')) {  
                            $JoinPagechooseLanguage = new JoinPagechooseLanguage();
                            $JoinPagechooseLanguage['join_page_id']        = $join_us_page_id;
                            $JoinPagechooseLanguage['language_id']         = $value['id'];
                            $JoinPagechooseLanguage['join_choose_id']      = $JoinPagechoose->id;
                            $JoinPagechooseLanguage['title']               = isset($request->choose_title[$value['id']][$key]) ?  $request->choose_title[$value['id']][$key] : $request->choose_title[$lang_id][$key];
                            $JoinPagechooseLanguage['description']         = isset($request->choose_description[$value['id']][$key]) ? change_str($request->choose_description[$value['id']][$key]) : $request->choose_description[$lang_id][$key];
                            $JoinPagechooseLanguage->save();
                        }
                    }
                }
            }

            // Slider Images
            $get_pageSlider = PageSliders::where(['page' => 'join_page'])->get();
            foreach ($get_pageSlider as $key => $val) {
                if (!in_array($val['id'], $request->image_v_id)) {
                    PageSliders::where('id', $val['id'])->delete();
                }
            }
            if (!empty($request->slider_title)) {
                if ($request->slider_title) {

                    PageSlidersLanguage::where(['page_id' => $join_us_page_id, 'page' => 'join_page'])->where('language_id',$lang_id)->delete();

                    foreach ($request->image_v_id as $key => $over_value) {

                        if ($over_value != '') {
                            $PageSliders       = PageSliders::find($over_value);
                        } else {
                            $PageSliders       = new PageSliders();
                        }

                        $PageSliders->page_id  = $join_us_page_id;
                        $PageSliders->page     = "join_page";

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
                            if (!getDataFromDB('pages_slider_language',['language_id'=>$value['id'],'pages_slider_id' => $page_slider_id,'page'=> 'join_page' ],'row')) {  
                                $PageSlidersLanguage = new PageSlidersLanguage();
                                $PageSlidersLanguage['page_id']            = 1;
                                $PageSlidersLanguage['pages_slider_id']    = $page_slider_id;
                                $PageSlidersLanguage['page']               = 'join_page';
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
                ->route('admin.join_us_page.edit', encrypt(1))
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'No Record Found']);
            }
            $id = checkDecrypt($id);
            $common['title'] = 'Edit join Us';
            $common['button'] = 'Update';

            $get_join_us_page           = JoinPage::where('id', $id)->first();
            $get_join_us_page_language  = JoinPageLanguage::where('join_page_id', $id)->get();

            $get_join_choose            = JoinPagechoose::where('join_page_id', $id)->get();
            $get_join_choose_language   = JoinPagechooseLanguage::where('join_page_id', $id)->get();

            $get_banner_over_view            = BannerOverview::where('page', 'join_us_page')->get();
            $get_banner_over_view_language   = BannerOverviewLanguage::where('page', 'join_us_page')->get();

            $get_slider_images           = PageSliders::where(['page_id' => $id, 'page' => 'join_page'])->get();
            $get_slider_images_language  = PageSlidersLanguage::where(['page_id' => $id, 'page' => 'join_page'])->get();

            if (!$get_join_us_page) {
                return back()->withErrors(['error' => 'Something went wrong']);
            }
        }
        return view('admin.join_page.add_join_page', compact('common', 'get_join_us_page', 'languages', 'get_join_us_page_language', 'get_banner_over_view_language', 'get_join_choose', 'get_join_choose_language', 'CHO', 'get_banner_over_view', 'GBO', 'get_slider_images_language', 'get_slider_images', 'LSI','lang_id'));
    }
}
