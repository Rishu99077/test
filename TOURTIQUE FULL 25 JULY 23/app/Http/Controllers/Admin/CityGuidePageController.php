<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CityGuidePage;
use App\Models\CityGuidePageLanguage;
use App\Models\CityGuidePageSliderImage;

use App\Models\CityGuidePageLocations;

use App\Models\Language;

use App\Models\PageSliders;
use App\Models\PageSlidersLanguage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Str;

class CityGuidePageController extends Controller
{

    ///Add CityGuidePage
    public function add_city_guide_page(Request $request, $id = '')
    {
        $common = [];
        Session::put('TopMenu', 'Pages');
        Session::put('SubMenu', 'City Guide Page');

        $common['title']  = translate('Add City Guide List');
        $common['button'] = translate('Save');
        $get_city_guide_page = getTableColumn('city_guide_page');
        $get_city_guide_page_language = '';
        $languages = Language::where(ConditionQuery())->get();

        $get_city_guide_page_slider_image = [];
        $get_city_guide_page_locations = [];
        $LOCS = getTableColumn('city_guide_page_locations');

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
                $CityGuidePage = CityGuidePage::find($request->id);
                CityGuidePageLanguage::where('city_guide_id', $request->id)->where('language_id',$lang_id)->delete();
            } else {
                $message = translate('Add Successfully');
                $status = 'success';
                $CityGuidePage = new CityGuidePage();
            }

            // $CityGuidePage['status']         = isset($request->status)  ? "Active" : "Deactive";
            if ($request->hasFile('image')) {
                $image                  = $request->file('image');
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
                $CityGuidePage['image'] = $newImage;
            }
            $CityGuidePage->save();

            $city_guide_id = $CityGuidePage->id;

            if (!empty($request->location_heading)) {

                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('city_guide_page_language',['language_id'=>$value['id'],'city_guide_id'=>1],'row')) {    

                        $CityGuidePageLanguage = new CityGuidePageLanguage();
                    
                       /* $CityGuidePageLanguage->title                = isset($request->title[$value['id']]) ?  $request->title[$value['id']] : $request->title[$lang_id];
                        $CityGuidePageLanguage->description          = isset($request->description[$value['id']]) ? change_str($request->description[$value['id']]) : $request->description[$lang_id];*/
                        $CityGuidePageLanguage->location_heading     = isset($request->location_heading[$value['id']]) ?  $request->location_heading[$value['id']] : $request->location_heading[$lang_id];
                        $CityGuidePageLanguage->location_description = isset($request->location_description[$value['id']]) ? change_str($request->location_description[$value['id']]) : $request->location_description[$lang_id];
                        $CityGuidePageLanguage->language_id          = $value['id'];
                        $CityGuidePageLanguage->city_guide_id        = $CityGuidePage->id;
                        $CityGuidePageLanguage->save();
                    }
                }
            }

            // Slider Images
            $get_pageSlider = PageSliders::where(['page' => 'city_guide_page'])->get();
            foreach ($get_pageSlider as $key => $val) {
                if (!in_array($val['id'], $request->over_view_id)) {
                    PageSliders::where('id', $val['id'])->delete();
                }
            }
            if (!empty($request->slider_title)) {
                if ($request->slider_title) {

                    PageSlidersLanguage::where(['page_id' => $city_guide_id, 'page' => 'city_guide_page'])->where('language_id',$lang_id)->delete();

                    foreach ($request->over_view_id as $key => $over_value) {

                        if ($over_value != '') {
                            $PageSliders       = PageSliders::find($over_value);
                        } else {
                            $PageSliders       = new PageSliders();
                        }

                        $PageSliders->page_id  = $city_guide_id;
                        $PageSliders->page     = "city_guide_page";

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
                            if (!getDataFromDB('pages_slider_language',['language_id'=>$value['id'],'pages_slider_id' => $page_slider_id,'page'=> 'city_guide_page' ],'row')) {  
                                $PageSlidersLanguage = new PageSlidersLanguage();
                                $PageSlidersLanguage['page_id']            = $city_guide_id;
                                $PageSlidersLanguage['pages_slider_id']    = $page_slider_id;
                                $PageSlidersLanguage['page']               = 'city_guide_page';
                                $PageSlidersLanguage['language_id']        = $value['id'];
                                $PageSlidersLanguage['title']              = isset($request->slider_title[$value['id']][$key]) ?  $request->slider_title[$value['id']][$key] : $request->slider_title[$lang_id][$key];
                                $PageSlidersLanguage['description']        = isset($request->slider_description[$value['id']][$key]) ?  $request->slider_description[$value['id']][$key] : $request->slider_description[$lang_id][$key];
                                $PageSlidersLanguage->save();
                            }
                        }
                    }
                }
            }

            // Locations
            /* if ($request->location_label) {
                $CityGuidePageLocations_ = CityGuidePageLocations::where('city_guide_id', $city_guide_id)->get();
                foreach ($CityGuidePageLocations_ as $key_ => $image_delete) {
                    if (!in_array($image_delete['id'], $request->location_id)) {
                        CityGuidePageLocations::where('id', $image_delete['id'])->delete();
                    }
                }
                foreach ($request->location_id as $key => $value_loc) {
                    if ($value_loc != '') {
                        $CityGuidePageLocations = CityGuidePageLocations::find($value_loc);
                    } else {
                        $CityGuidePageLocations = new CityGuidePageLocations();
                    }

                    $CityGuidePageLocations['city_guide_id']  = $city_guide_id;
                    $CityGuidePageLocations['location_label'] = $request->location_label[$key];

                    if ($request->hasFile('location_image')) {
                        if (isset($request->location_image[$key])) {
                            $files = $request->file('location_image')[$key];

                            $random_no = uniqid();
                            $img = $files;
                            $ext = $files->getClientOriginalExtension();
                            $new_name = $random_no . time() . '.' . $ext;
                            $destinationPath = public_path('uploads/MediaPage');
                            $img->move($destinationPath, $new_name);
                            $CityGuidePageLocations['location_image'] = $new_name;
                        }
                    }
                    $CityGuidePageLocations->save();
                }
            }*/

            return redirect()
                ->route('admin.city_guide_page.edit', encrypt(1))
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'No Record Found']);
            }
            $id = checkDecrypt($id);
            $common['title'] = 'Edit City Guide List';
            $common['button'] = 'Update';

            $get_city_guide_page = CityGuidePage::where('id', $id)->first();
            $get_city_guide_page_language = CityGuidePageLanguage::where('city_guide_id', $id)->get();
            $get_city_guide_page_slider_image = CityGuidePageSliderImage::where('city_guide_id', $id)->get();

            $get_city_guide_page_locations = CityGuidePageLocations::where('city_guide_id', $id)->get();

            $get_slider_images           = PageSliders::where(['page_id' => $id, 'page' => 'city_guide_page'])->get();
            $get_slider_images_language  = PageSlidersLanguage::where(['page_id' => $id, 'page' => 'city_guide_page'])->get();

            if (!$get_city_guide_page) {
                return back()->withErrors(['error' => 'Something went wrong']);
            }
        }
        return view('admin.city_guide_page.add_cityguide_page', compact('common', 'get_city_guide_page', 'languages', 'get_city_guide_page_language', 'get_city_guide_page_slider_image', 'get_city_guide_page_locations', 'LOCS', 'get_slider_images', 'get_slider_images_language', 'LSI','lang_id'));
    }
}
