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

class CategoryPageController extends Controller
{

    ///Add CityGuidePage
    public function add_category_page(Request $request, $id = '')
    {
        $common = [];
        Session::put('TopMenu', 'Pages');
        Session::put('SubMenu', 'Category page');

        $common['title']     = translate('Add Category Page');
        $common['button']    = translate('Save');
        // $get_city_guide_page = getTableColumn('city_guide_page');
        // $get_city_guide_page_language = '';
        $languages           = Language::where(ConditionQuery())->get();
        $get_category_slider_image = [];

        $get_slider_images              = [];
        $get_slider_images_language     = [];
        $LSI                            = getTableColumn('pages_slider'); 

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $get_languages = Language::where(['status'=>'Active','is_delete' => 0])->get();


        if ($request->isMethod('post')) {
            $req_fields = [];
            $req_fields['title.*'] = 'required';

            // $errormsg = [
            //     'title.*' => translate('Title'),
            // ];

            // $validation = Validator::make(
            //     $request->all(),
            //     $req_fields,
            //     [
            //         'required' => 'The :attribute field is required.',
            //     ],
            //     $errormsg,
            // );

            // echo "<pre>";
            // print_r($request->all());
            // echo "</pre>";die();

            // if ($validation->fails()) {
            //     return back()
            //         ->withErrors($validation)
            //         ->withInput();
            // }
            $message = translate('Update Successfully');
            $status = 'success';

            // Slider Images
            if (isset($request->category_slider_id)) {
                    $category_slider_id_arr = array_filter($request->category_slider_id, fn($value) => !is_null($value) && $value !== '');
                    PageSliders::whereNotIn('id',$category_slider_id_arr)->where('page','category_page')->delete();
                    PageSlidersLanguage::where(['page_id' => 1,'page'=>'category_page'])->where('language_id',$lang_id)->delete(); 
                    foreach ($request->category_slider_id as $key => $over_value) {
                        if($over_value !=''){
                            $PageSliders       = PageSliders::find($over_value);
                        }else{
                            $PageSliders       = new PageSliders();
                        }
                        $PageSliders->page_id  = 1;
                        $PageSliders->page     = "category_page";

                        if ($request->hasFile('slider_image')) {
                            if (isset($request->slider_image[$key])) {
                                $files = $request->file('slider_image')[$key];
                                $random_no       = uniqid();
                                $img             = $files;
                                $ext             = $files->getClientOriginalExtension();
                                $new_name        = $random_no . time() . '.' . $ext;
                                $destinationPath = public_path('uploads/category_page/slider');
                                $img->move($destinationPath, $new_name);
                                $PageSliders->image = $new_name;
                            }
                        }
                        $PageSliders->save();
                        $page_slider_id = $PageSliders->id;

                        foreach ($get_languages as $lang_key => $value) {
                            if (!getDataFromDB('pages_slider_language',['language_id'=>$value['id'],'pages_slider_id' => $page_slider_id,'page'=> 'category_page' ],'row')) {
                                $PageSlidersLanguage = new PageSlidersLanguage();
                                $PageSlidersLanguage['page_id']            = 1;
                                $PageSlidersLanguage['pages_slider_id']    = $page_slider_id;
                                $PageSlidersLanguage['page']               = 'category_page';
                                $PageSlidersLanguage['language_id']        = $value['id'];
                                $PageSlidersLanguage['title']              = isset($request->slider_title[$value['id']][$key]) ?  $request->slider_title[$value['id']][$key] : $request->slider_title[$lang_id][$key];
                                $PageSlidersLanguage['description']        = isset($request->slider_description[$value['id']][$key]) ?  $request->slider_description[$value['id']][$key] : $request->slider_description[$lang_id][$key]; 
                                $PageSlidersLanguage->save();
                            }
                        }
                    }
            }
            return redirect()
                ->route('admin.category_page.edit', encrypt(1))
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

            $get_slider_images           = PageSliders::where(['page_id'=> $id ,'page' => 'category_page'])->get();
            $get_slider_images_language  = PageSlidersLanguage::where(['page_id'=> $id,'page' => 'category_page'])->get();

        }
        return view('admin.category_page.add_category_page', compact('common','LSI','get_slider_images','get_slider_images_language'));
    }

}
