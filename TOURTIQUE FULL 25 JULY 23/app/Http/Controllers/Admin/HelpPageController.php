<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSliders;
use App\Models\PageSlidersLanguage;
use App\Models\HelpPageLanguage;
use App\Models\HelpPageHighlights;
use App\Models\HelpPageHighlightsLanguage;
use App\Models\HelpPageDescriptionLanguage;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Str;

class HelpPageController extends Controller
{
    //add_transfer_page
    public function add_help_page(Request $request, $id = '')
    {
        $common = [];
        Session::put('TopMenu', 'Pages');
        Session::put('SubMenu', 'Help');

        $common['title']            = translate('Help Page');
        $common['button']           = translate('Save');
        $get_transfer_page          = getTableColumn('transfer_page');
        $get_transfer_page_language = '';
        $languages                  = Language::where(ConditionQuery())->get();

        $LSI                        = getTableColumn('pages_slider');
        $help_pages_slider          = [];
        $help_pages_slider_language = [];
        $HelpPageLanguageDescription       = [];
        $HPL                               = getTableColumn('help_faq_descriptions');
        $TPH                               = getTableColumn('transfer_page_highlights');
        $get_help_page_highlights          = [];
        $get_help_page_highlights_language = [];

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
            if ($validation->fails()) {
                return back()
                    ->withErrors($validation)
                    ->withInput();
            }

            $message = translate('Update Successfully');
            $status = 'success';

             // Slider Images-------------------------------------------------------
           
            $get_pageSlider = PageSliders::where(['page'=>'help_page'])->get();
            foreach ($get_pageSlider as $key => $val) {
                if (!in_array($val['id'], $request->help_banner_id)) {
                    PageSliders::where('id', $val['id'])->delete();
                }
            }
            if (!empty($request->slider_title)) {
                if ($request->slider_title) {

                    PageSlidersLanguage::where(['page_id' => 1,'page'=>'help_page'])->where('language_id',$lang_id)->delete();

                    foreach ($request->help_banner_id as $key => $over_value) {
                
                        if($over_value !=''){
                            $PageSliders       = PageSliders::find($over_value);
                        }else{
                            $PageSliders       = new PageSliders();
                        }


                        if ($request->hasFile('image')) {
                            if (isset($request->image[$key])) {
                                $files = $request->file('image')[$key];
                                $random_no       = uniqid();
                                $img             = $files;
                                $ext             = $files->getClientOriginalExtension();
                                $new_name        = $random_no . time() . '.' . $ext;
                                $destinationPath = public_path('uploads/slider_images');
                                $img->move($destinationPath, $new_name);
                                $PageSliders->image = $new_name;
                                $PageSliders->page_id  = 1;
                                $PageSliders->page     = "help_page";
                            }
                        }

                        $PageSliders->save();
                        $page_slider_id = $PageSliders->id;

                        foreach ($get_languages as $lang_key => $value) {
                            if (!getDataFromDB('pages_slider_language',['language_id'=>$value['id'],'pages_slider_id' => $page_slider_id,'page'=> 'help_page' ],'row')) {  
                                $PageSlidersLanguage = new PageSlidersLanguage();
                                $PageSlidersLanguage['page_id']            = 1;
                                $PageSlidersLanguage['pages_slider_id']    = $page_slider_id;
                                $PageSlidersLanguage['page']               = 'help_page';
                                $PageSlidersLanguage['language_id']        = $value['id'];
                                $PageSlidersLanguage['title']              = isset($request->slider_title[$value['id']][$key]) ?  $request->slider_title[$value['id']][$key] : $request->slider_title[$lang_id][$key];
                                $PageSlidersLanguage['description']        = isset($request->slider_description[$value['id']][$key]) ?  $request->slider_description[$value['id']][$key] : $request->slider_description[$lang_id][$key];  
                                $PageSlidersLanguage->save();
                            }
                        }


                    }
                }
            }


            // Highlights
            if ($request->help_highlight_id) {
                HelpPageHighlights::whereNotIn('id',$request->help_highlight_id)->where(['help_page_id' => 1])->delete();
                HelpPageHighlightsLanguage::where(['help_page_id' => 1])->where('language_id',$lang_id)->delete();
                foreach ($request->help_highlight_id as $key => $value) {
                    if($value!=''){
                        $HelpPageHighlights = HelpPageHighlights::find($value);
                    }else{
                        $HelpPageHighlights = new HelpPageHighlights();
                    }
                    $HelpPageHighlights['help_page_id'] = 1;                   
                    $HelpPageHighlights->save();
                    $highlight_id  = $HelpPageHighlights->id;

                    foreach ($request->heading[$key] as $key1 => $value1) {
                        $HelpPageHighlightsLanguage                           = new HelpPageHighlightsLanguage();
                        $HelpPageHighlightsLanguage['help_page_id']           = 1;
                        $HelpPageHighlightsLanguage['highlights_id']          = $HelpPageHighlights->id;
                        $HelpPageHighlightsLanguage['language_id']            = $key1;
                        $HelpPageHighlightsLanguage['title']                  = $value1;
                        $HelpPageHighlightsLanguage->save();
                    }
                    if (isset($request->get_help_page_descripton_language_id)) {
                        if(isset($request->get_help_page_descripton_language_id[$key])){
                            $get_help_page_descripton_language_id_arr = array_filter($request->get_help_page_descripton_language_id[$key], fn($value) => !is_null($value) && $value !== '');
                            HelpPageLanguage::whereNotIn('id',$get_help_page_descripton_language_id_arr)->where('highlights_id',$highlight_id)->where('help_page_id',1)->delete();
                            HelpPageDescriptionLanguage::where('highlights_id',$highlight_id)->where('help_page_id',1)->where('language_id',$lang_id)->delete();
                            foreach($request->get_help_page_descripton_language_id[$key] as $g_key => $g_value){
                                if($g_value !=''){
                                    $HelpPageLanguage                  = HelpPageLanguage::find($g_value);
                                }else{
                                    $HelpPageLanguage                  = new HelpPageLanguage();
                                }
                                $HelpPageLanguage['help_page_id']  = 1;
                                $HelpPageLanguage['highlights_id'] = $highlight_id;
                                $HelpPageLanguage->save();
                                foreach ($request->title[$key] as $key2 => $value2) {
                                    foreach ($value2 as $key3 => $value3) {
                                        if ($g_key == $key3) {
                                            $HelpPageDescriptionLanguage                          = new HelpPageDescriptionLanguage();
                                            $HelpPageDescriptionLanguage->highlights_id           = $highlight_id;
                                            $HelpPageDescriptionLanguage->help_page_id            = 1;
                                            $HelpPageDescriptionLanguage->help_faq_description_id = $HelpPageLanguage->id;
                                            $HelpPageDescriptionLanguage->language_id             = $key2;
                                            $HelpPageDescriptionLanguage->title                   = $value3;
                                            $HelpPageDescriptionLanguage['description']           = $request->description[$key][$key2][$key3];
                                            $HelpPageDescriptionLanguage->save();
                                        }
                                    }
                                }
                            }
                        }                        

                    }
                }
            }
            return redirect()
                ->route('admin.help_page.edit', encrypt(1))
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'No Record Found']);
            }
            $id                 = checkDecrypt($id);
            $common['title']    = 'Edit Transfer Page';
            $common['button']   = 'Update';

            $help_pages_slider                 = PageSliders::where(['page' => 'help_page'])->get();
            $help_pages_slider_language        = PageSlidersLanguage::where(['page' => 'help_page'])->get();

            $get_help_page_highlights          = HelpPageHighlights::where('help_page_id', 1)->get();
            $get_help_page_highlights_language = HelpPageHighlightsLanguage::where('help_page_id', 1)->get();
            $HelpPageLanguage                  = HelpPageLanguage::where('help_page_id', 1)->get();
            $HelpPageLanguageDescription       = HelpPageDescriptionLanguage::where('help_page_id', 1)->get();

            if (!$get_transfer_page) {
                return back()->withErrors(['error' => 'Something went wrong']);
            }
        } else {
            return back()->withErrors(['error' => 'Something went wrong']);
        }

        return view('admin.help_page.help_page', compact('common', 'languages', 'help_pages_slider', 'help_pages_slider_language', 'LSI', 'TPH', 'get_help_page_highlights', 'get_help_page_highlights_language', 'HelpPageLanguage', 'HPL', 'HelpPageLanguageDescription'));
    }
}
