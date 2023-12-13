<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Language;
use App\Models\MetaGlobalLanguage;
use App\Models\Country;

use App\Models\BannerOverview;
use App\Models\BannerOverviewLanguage;

use App\Models\LodgeTour;
use App\Models\LodgeTourLanguage;

use App\Models\PageSliders;
use App\Models\PageSlidersLanguage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Str;

class TourPageController extends Controller
{

    ///Add HomePage
    public function add_tour_page(Request $request, $id = '')
    {
        $common = [];
        Session::put('TopMenu', 'Pages');
        Session::put('SubMenu', 'Tour Page');

        $common['title']  = translate('Tour Page');
        $common['button'] = translate('Save');
        $languages        = Language::where(ConditionQuery())->get();

        $get_slider_images              = [];
        $get_slider_images_language     = [];
        $MetaGlobalSideBanner                  = [];
        $LSI                = getTableColumn('pages_slider');

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $get_languages = Language::where(['status'=>'Active','is_delete' => 0])->get();

        if ($request->isMethod('post')) {
            // dd($request->all());

            // print_die($request->all());
            $req_fields = [];
            // $req_fields['title.*']             = "required";
            // $req_fields['about_title.*']       = "required";
            // $req_fields['about_description.*'] = "required";
            // $req_fields['work_title.*']        = "required";
            // $req_fields['adventures_country.*']  = "required";

            $errormsg = [
                'title.*'             => translate('Title'),
                'about_title.*'       => translate('Title'),
                'about_description.*' => translate('Title'),
                'work_title.*'        => translate('Title'),
                'work_description.*'  => translate('Title'),
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

            $message = translate('Add Successfully');
            $status = 'success';

            // print_die($request->all());

            LodgeTour::where(['page' => "tour"])->delete();
            LodgeTourLanguage::where(['page' => "tour"])->where('langauge_id',$lang_id)->delete();
            $LodgeTour = new LodgeTour();
            $LodgeTour->link = $request->city_guide_link;
            $LodgeTour->page = "tour";
            $LodgeTour->save();

            // Removed by client
            // foreach ($get_languages as $key => $value) {
            //     if (!getDataFromDB('lodge_tour_language',['langauge_id'=>$value['id'],'lodge_tour_id'=>$LodgeTour->id ,'page'=>'tour'],'row')) {
            //         $LodgeTourLanguage                  = new LodgeTourLanguage();
            //         $LodgeTourLanguage->lodge_tour_id   = $LodgeTour->id;
            //         $LodgeTourLanguage->page            = "tour";
            //         $LodgeTourLanguage->langauge_id     = $value['id'];
            //         $LodgeTourLanguage->description     = isset($request->tour_description[$value['id']]) ? change_str($request->tour_description[$value['id']]) : $request->tour_description[$lang_id];
            //         $LodgeTourLanguage->save();
            //     }
            // }


            // Banner OverViwe
            BannerOverviewLanguage::where('page', 'tour_banner')->where('langauge_id',$lang_id)->delete();
            $BannerOverview = BannerOverview::where("page", "tour_banner")->first();
            if (!$BannerOverview) {
                $BannerOverview       = new BannerOverview();
            }
            $BannerOverview->page     = "tour_banner";
            if ($request->hasFile('tour_banner')) {

                $files = $request->file('tour_banner');
                $random_no       = uniqid();
                $img             = $files;
                $ext             = $files->getClientOriginalExtension();
                $new_name        = $random_no . time() . '.' . $ext;
                $destinationPath = public_path('uploads/tour_banner/banner_overview');
                $img->move($destinationPath, $new_name);
                $BannerOverview->image = $new_name;
            }
            $BannerOverview->save();

            // Removed by client
                
            /*foreach ($get_languages as $key => $value) {
                if (!getDataFromDB('banner_overview_language',['langauge_id'=>$value['id'],'overview_id'=>$BannerOverview->id,'page'=>'tour_banner'],'row')) {    
                    $BannerOverviewLanguage                  = new BannerOverviewLanguage();
                    $BannerOverviewLanguage->overview_id     = $BannerOverview->id;
                    $BannerOverviewLanguage->page            = "tour_banner";
                    $BannerOverviewLanguage->langauge_id     = $value['id'];
                    $BannerOverviewLanguage->title           = isset($request->banner_title[$value['id']]) ?  $request->banner_title[$value['id']] : $request->banner_title[$lang_id];
                    $BannerOverviewLanguage->description     = isset($request->banner_description[$value['id']]) ?  $request->banner_description[$value['id']] : $request->banner_description[$lang_id]; 
                    $BannerOverviewLanguage->save();
                }
            }*/

            ///Best Selling
            foreach ($request->best_selling_heading as $language_id => $BSH) {
                $MetaGlobalLanguageBS = MetaGlobalLanguage::where(['meta_title' => 'best_selling_tour', "language_id" => $language_id])->first();
                if (!$MetaGlobalLanguageBS) {
                    $MetaGlobalLanguageBS = new MetaGlobalLanguage();
                }

                $MetaGlobalLanguageBS->language_id  = $language_id;
                $MetaGlobalLanguageBS->meta_title   = "best_selling_tour";
                $MetaGlobalLanguageBS->title        = $BSH;
                $MetaGlobalLanguageBS->save();
            }


            // Slider Images
            $get_pageSlider = PageSliders::where(['page' => 'tour_page'])->get();
            foreach ($get_pageSlider as $key => $val) {
                if (!in_array($val['id'], $request->image_v_id)) {
                    PageSliders::where('id', $val['id'])->delete();
                }
            }
            if (!empty($request->slider_title)) {
                if ($request->slider_title) {

                    PageSlidersLanguage::where(['page_id' => 1, 'page' => 'tour_page'])->where('language_id',$lang_id)->delete();

                    foreach ($request->image_v_id as $key => $over_value) {

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
                                $PageSliders->image = $new_name;
                                $PageSliders->page_id  = 1;
                                $PageSliders->page     = "tour_page";
                            }
                        }

                        $PageSliders->save();
                        $page_slider_id = $PageSliders->id;

                        foreach ($get_languages as $lang_key => $value) {
                            if (!getDataFromDB('pages_slider_language',['language_id'=>$value['id'],'pages_slider_id'=>$page_slider_id,'page'=>'tour_page'],'row')) {  
                           
                                $PageSlidersLanguage = new PageSlidersLanguage();
                                $PageSlidersLanguage['page_id']            = 1;
                                $PageSlidersLanguage['pages_slider_id']    = $page_slider_id;
                                $PageSlidersLanguage['page']               = 'tour_page';
                                $PageSlidersLanguage['language_id']        = $value['id'];
                                $PageSlidersLanguage['title']              = isset($request->slider_title[$value['id']][$key]) ?  $request->slider_title[$value['id']][$key] : $request->slider_title[$lang_id][$key];
                                $PageSlidersLanguage['description']        = isset($request->slider_description[$value['id']][$key]) ?  $request->slider_description[$value['id']][$key] : $request->slider_description[$lang_id][$key];
                                $PageSlidersLanguage->save();
                            }
                        }
                    }
                }
            }




            //Sider Banner
            if ($request->hasFile('side_banner')) {
                $MetaGlobalSideBanner                  = MetaGlobalLanguage::where('meta_title', 'tourpage_side_banner')->first();
                if(!$MetaGlobalSideBanner){
                    $MetaGlobalSideBanner              = new MetaGlobalLanguage();
                }
                $MetaGlobalSideBanner->meta_parent = 'tour_page';
                $MetaGlobalSideBanner->meta_title  = 'tourpage_side_banner';
                $random_no = Str::random(5);
                $image     = $request->file('side_banner');
                $new_name  =  time() . $random_no . '.' . $image->getClientOriginalExtension();
                $imgFile   = Image::make($image->path());
                $height    = $imgFile->height();
                $width     = $imgFile->width();

                $imgFile->resize(350, 780, function ($constraint) {
                    $constraint->aspectRatio();
                });
                
                
                $destinationPath = public_path('uploads/side_banner');
                $imgFile->save($destinationPath . '/' . $new_name);
                $MetaGlobalSideBanner->image = $new_name;
                $MetaGlobalSideBanner->status      = 'Active';
                $MetaGlobalSideBanner->save();
            }


            return redirect()
                ->route('admin.tour_page.edit', encrypt(1))
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'No Record Found']);
            }
            $id = checkDecrypt($id);
            // echo $id;
            // die;
            $common['title'] = 'Edit Tour Page';
            $common['button'] = 'Update';

            $banner_img                     = BannerOverview::where('page', 'tour_banner')->first();
            $LodgeTour                      = LodgeTour::where('page', 'tour')->first();
            $LodgeTourLanguage              = LodgeTourLanguage::where('page', 'tour')->pluck('description', 'langauge_id')->toArray();

            $get_banner_over_view_language  = BannerOverviewLanguage::where('page', 'tour_banner')->get();
            $MetaGlobalLanguageBEST_SELLING = MetaGlobalLanguage::where(['meta_title' => 'best_selling_tour'])->pluck('title', 'language_id')->toArray();

            $get_slider_images           = PageSliders::where(['page_id' => 1, 'page' => 'tour_page'])->get();
            $get_slider_images_language  = PageSlidersLanguage::where(['page_id' => 1, 'page' => 'tour_page'])->get();
            $MetaGlobalSideBanner           = MetaGlobalLanguage::where('meta_title', 'tourpage_side_banner')->first();
        }
        return view('admin.tour_page.add_tour_page', compact('common', 'MetaGlobalLanguageBEST_SELLING', 'LodgeTour', 'LodgeTourLanguage', 'banner_img', 'languages', 'get_slider_images', 'get_slider_images_language', 'LSI','lang_id','MetaGlobalSideBanner'));
    }
}
