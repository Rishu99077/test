<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\TransferPage;
use App\Models\TransferPageLanguage;
use App\Models\TransferPageWhyBook;
use App\Models\TransferPageWhyBookLanguage;

use App\Models\TransferPageTaxi;
use App\Models\TransferPageTaxiLanguage;

use App\Models\TransferPageWithus;
use App\Models\TransferPageWithusLanguage;

use App\Models\TransferPageHighlights;
use App\Models\TransferPageHighlightsLanguage;

use App\Models\MetaGlobalLanguage;

use App\Models\PageSliders;
use App\Models\PageSlidersLanguage;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Str;

class TransferPageController extends Controller
{
    //add_transfer_page
    public function add_transfer_page(Request $request, $id = '')
    {
        $common = [];
        Session::put('TopMenu', 'Pages');
        Session::put('SubMenu', 'Transfer Page');

        $common['title']                    = translate('Transfer Page');
        $common['button']                   = translate('Save');
        $get_transfer_page                  = getTableColumn('transfer_page');
        $get_transfer_page_language         = '';
        $languages                          = Language::where(ConditionQuery())->get();
        $get_transfer_page_wbt              = [];
        $get_transfer_page_wbt_language     = [];

        $TPT                  = getTableColumn('transfer_page_taxi');
        $get_transfer_page_premium_taxi              = [];
        $get_transfer_page_premium_taxi_language     = [];


        $TWU                  = getTableColumn('transfer_page_with_us');
        $get_transfer_page_with_us              = [];
        $get_transfer_page_with_us_language     = [];
        $get_transfer_privacy                    = [];
        $get_why_booking_heading                    = [];



        $TPH                  = getTableColumn('transfer_page_highlights');
        $get_transfer_page_highlights              = [];
        $get_transfer_page_highlights_language     = [];
        $MetaGlobalSideBanner                      = [];

        $LSI                = getTableColumn('pages_slider');
        $get_slider_images              = [];
        $get_slider_images_language     = [];

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

            if ($request->id != '') {
                $message      = translate('Update Successfully');
                $status       = 'success';
                $TransferPage = TransferPage::find($request->id);
                TransferPageLanguage::where('transfer_page_id', $request->id)->delete();



                $get_highlights = TransferPageHighlights::where('transfer_page_id', $request->id)->get();
                foreach ($get_highlights as $key => $high_delete) {
                    if (!in_array($high_delete['id'], $request->highlights_id)) {
                        TransferPageHighlights::where('id', $high_delete['id'])->delete();
                    }
                }

                $get_with_us = TransferPageWithus::where('transfer_page_id', $request->id)->get();
                foreach ($get_with_us as $key => $with_us_delete) {
                    if (!in_array($with_us_delete['id'], $request->with_us_id)) {
                        TransferPageWithus::where('id', $with_us_delete['id'])->delete();
                    }
                }

                $get_taxi = TransferPageTaxi::where('transfer_page_id', $request->id)->get();
                foreach ($get_taxi as $key => $taxi_delete) {
                    if (!in_array($taxi_delete['id'], $request->taxi_id)) {
                        TransferPageTaxi::where('id', $taxi_delete['id'])->delete();
                    }
                }
            } else {
                $message      = translate('Add Successfully');
                $status       = 'success';
                $TransferPage = new TransferPage();
            }

            if ($request->hasFile('file')) {
                $image               = $request->file('file');
                $random_no           = Str::random(5);
                $newImage            = time() . $random_no . '.' . $image->getClientOriginalExtension();
                $destinationPath     = public_path('uploads/TransferPageImage');
                $imgFile             = Image::make($image->path());
                $height              = $imgFile->height();
                $width               = $imgFile->width();
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

                $destinationPath = public_path('uploads/TransferPageImage');
                $imgFile->save($destinationPath . '/' . $newImage);
                $TransferPage['image'] = $newImage;
            }
            $TransferPage->save();
            $transfer_page_id = $TransferPage->id;

            if (!empty($request->title)) {
                foreach ($get_languages as $lang_key => $value) {
                    if (!getDataFromDB('transfer_language',['language_id'=>$value['id'],'transfer_page_id'=>$transfer_page_id],'row')) {    
                        $TransferPageLanguage = new TransferPageLanguage();
                   
                        $TransferPageLanguage->title            = isset($request->title[$value['id']]) ?  $request->title[$value['id']] : $request->title[$lang_id];
                        $TransferPageLanguage->description      = isset($request->description[$value['id']]) ?  $request->description[$value['id']] : $request->description[$lang_id]; 
                        $TransferPageLanguage->language_id      = $value['id'];
                        $TransferPageLanguage->transfer_page_id = $transfer_page_id;
                        $TransferPageLanguage->save();
                    }
                }
            }

            //Privacy POlicy 
            foreach ($get_languages as $key => $value) {
                if (!empty($request->transfer_terms_conditions)) {
                    $MetaGlobalLanguageTerms                  = MetaGlobalLanguage::where('meta_title', 'transfer_terms_conditions')->where('language_id',$value['id'])->first();
                    if(!$MetaGlobalLanguageTerms){
                        $MetaGlobalLanguageTerms              = new MetaGlobalLanguage();
                    }
                    if($lang_id == $value['id']){
                        $MetaGlobalLanguageTerms->title       = $request->transfer_terms_conditions[$lang_id];
                    }else{
                        if(!$MetaGlobalLanguageTerms->title){
                            $MetaGlobalLanguageTerms->title       = $request->transfer_terms_conditions[$lang_id];
                        }
                    }                    
                    $MetaGlobalLanguageTerms->meta_parent = 'transfer_page';
                    $MetaGlobalLanguageTerms->meta_title  = 'transfer_terms_conditions';
                    $MetaGlobalLanguageTerms->language_id = $value['id'];
                    $MetaGlobalLanguageTerms->product_id  = $transfer_page_id;
                    $MetaGlobalLanguageTerms->status      = 'Active';
                    $MetaGlobalLanguageTerms->save();
                }

                //Why Booking Heading
                if (!empty($request->why_booking_heading)) {
                    $MetaGlobalLanguageWhyBookingheading                  = MetaGlobalLanguage::where('meta_title', 'why_booking_heading')->where('language_id',$value['id'])->first();
                    if(!$MetaGlobalLanguageWhyBookingheading){
                        $MetaGlobalLanguageWhyBookingheading              = new MetaGlobalLanguage();
                    }
                    if($lang_id == $value['id']){
                        $MetaGlobalLanguageWhyBookingheading->title       = $request->why_booking_heading[$lang_id];
                    }else{
                        if($MetaGlobalLanguageWhyBookingheading->title){
                            if(isset($request->why_booking_heading[$value['id']])){
                                $MetaGlobalLanguageWhyBookingheading->title       = $request->why_booking_heading[$value['id']];
                            }
                        }else{
                            $MetaGlobalLanguageWhyBookingheading->title       = $request->why_booking_heading[$lang_id];
                        }
                    }                    
                    $MetaGlobalLanguageWhyBookingheading->meta_parent = 'transfer_page';
                    $MetaGlobalLanguageWhyBookingheading->meta_title  = 'why_booking_heading';
                    $MetaGlobalLanguageWhyBookingheading->language_id = $value['id'];
                    $MetaGlobalLanguageWhyBookingheading->product_id  = $transfer_page_id;
                    $MetaGlobalLanguageWhyBookingheading->status      = 'Active';
                    $MetaGlobalLanguageWhyBookingheading->save();
                }
            }
            //Privacy POlicy End


            //Side Banner 
            if ($request->hasFile('side_banner')) {
                $MetaGlobalSideBanner                  = MetaGlobalLanguage::where('meta_title', 'transfer_side_banner')->first();
                if(!$MetaGlobalSideBanner){
                    $MetaGlobalSideBanner              = new MetaGlobalLanguage();
                }
                $MetaGlobalSideBanner->meta_parent = 'transfer_page';
                $MetaGlobalSideBanner->meta_title  = 'transfer_side_banner';
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
                
                $MetaGlobalSideBanner->product_id  = $transfer_page_id;
                $MetaGlobalSideBanner->status      = 'Active';
                $MetaGlobalSideBanner->save();
            }



            if (!empty($request->premium_taxi_heading)) {
                MetaGlobalLanguage::where('meta_title', 'premium_taxi_heading')->where('language_id',$lang_id)->delete();
                
                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('meta_global_language',['language_id'=>$value['id'],'meta_title'=>'premium_taxi_heading','product_id' => $transfer_page_id],'row')) {     
                        $MetaGlobalLanguage             = new MetaGlobalLanguage();
                        $MetaGlobalLanguage->meta_title = 'premium_taxi_heading';
                        $MetaGlobalLanguage->title      = isset($request->premium_taxi_heading[$value['id']]) ?  $request->premium_taxi_heading[$value['id']] : $request->premium_taxi_heading[$lang_id];
                        // $MetaGlobalLanguage->content = $request->yatch_boat_specification_description[$key];
                        $MetaGlobalLanguage->language_id = $value['id'];
                        $MetaGlobalLanguage->product_id  = $transfer_page_id;
                        $MetaGlobalLanguage->status      = 'Active';
                        $MetaGlobalLanguage->save();
                    }
                }
            }

            // Slider Images-------------------------------------------------------

            $get_pageSlider = PageSliders::where(['page' => 'transfer_page'])->get();
            foreach ($get_pageSlider as $key => $val) {
                if (!in_array($val['id'], $request->over_view_id)) {
                    PageSliders::where('id', $val['id'])->delete();
                }
            }
            if (!empty($request->slider_title)) {
                if ($request->slider_title) {

                    PageSlidersLanguage::where(['page_id' => 1, 'page' => 'transfer_page'])->where('language_id',$lang_id)->delete();

                    foreach ($request->over_view_id as $key => $over_value) {

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
                                $PageSliders->page     = "transfer_page";
                            }
                        }

                        $PageSliders->save();
                        $page_slider_id = $PageSliders->id;
                        
                        foreach ($get_languages as $lang_key => $value) {
                            if (!getDataFromDB('pages_slider_language',['language_id'=>$value['id'],'pages_slider_id' => $page_slider_id,'page'=> 'transfer_page' ],'row')) { 
                                $PageSlidersLanguage = new PageSlidersLanguage();
                                $PageSlidersLanguage['page_id']            = 1;
                                $PageSlidersLanguage['pages_slider_id']    = $page_slider_id;
                                $PageSlidersLanguage['page']               = 'transfer_page';
                                $PageSlidersLanguage['language_id']        = $value['id'];
                                $PageSlidersLanguage['title']              = isset($request->slider_title[$value['id']][$key]) ?  $request->slider_title[$value['id']][$key] : $request->slider_title[$lang_id][$key];
                                $PageSlidersLanguage['description']        = isset($request->slider_description[$value['id']][$key]) ?  $request->slider_description[$value['id']][$key] : $request->slider_description[$lang_id][$key];
                                $PageSlidersLanguage->save();
                            }
                        }
                    }
                }
            }

            // Why book Tranfer
            if ($request->why_book_title) {
                TransferPageWhyBookLanguage::where(['transfer_page_id' => $transfer_page_id])->where('language_id',$lang_id)->delete();

                foreach ($request->transfer_why_book_id as $key => $value_7) {
                    if ($value_7 != '') {
                        $TransferPageWhyBook = TransferPageWhyBook::find($value_7);
                    } else {
                        $TransferPageWhyBook = new TransferPageWhyBook();
                    }

                    $TransferPageWhyBook['transfer_page_id'] = $transfer_page_id;

                    if ($request->hasFile('why_book_icon')) {
                        if (isset($request->why_book_icon[$key])) {
                            $files = $request->file('why_book_icon')[$key];

                            $random_no = uniqid();
                            $img = $files;
                            $ext = $files->getClientOriginalExtension();
                            $new_name = $random_no . time() . '.' . $ext;
                            $destinationPath = public_path('uploads/TransferPageImage');
                            $img->move($destinationPath, $new_name);
                            $TransferPageWhyBook['image'] = $new_name;
                        }
                    }
                    $TransferPageWhyBook->save();
                    
                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('transfer_page_why_book_transfer_language',['language_id'=>$value['id'],'why_book_id' => $TransferPageWhyBook->id,'transfer_page_id'=> $transfer_page_id ],'row')) {  
                            $TransferPageWhyBookLanguage                       = new TransferPageWhyBookLanguage();
                            $TransferPageWhyBookLanguage['transfer_page_id']   = $transfer_page_id;
                            $TransferPageWhyBookLanguage['language_id']        = $value['id'];
                            $TransferPageWhyBookLanguage['why_book_id']        = $TransferPageWhyBook->id;
                            $TransferPageWhyBookLanguage['title']              = isset($request->why_book_title[$value['id']][$key]) ?  $request->why_book_title[$value['id']][$key] : $request->why_book_title[$lang_id][$key];
                            $TransferPageWhyBookLanguage['description']        = isset($request->why_book_description[$value['id']][$key]) ?  $request->why_book_description[$value['id']][$key] : $request->why_book_description[$lang_id][$key];  
                            $TransferPageWhyBookLanguage->save();
                        }
                    }
                }
            }


            // PREMIUM TAXI
            if ($request->taxi_title) {
                TransferPageTaxiLanguage::where(['transfer_page_id' => $transfer_page_id])->where('language_id',$lang_id)->delete();

                foreach ($request->taxi_id as $key => $value_taxi) {
                    if ($value_taxi != '') {
                        $TransferPageTaxi = TransferPageTaxi::find($value_taxi);
                    } else {
                        $TransferPageTaxi = new TransferPageTaxi();
                    }

                    $TransferPageTaxi['transfer_page_id'] = $transfer_page_id;
                    $TransferPageTaxi['sort']             = $request->sort[$key];

                    if ($request->hasFile('taxi_image')) {
                        if (isset($request->taxi_image[$key])) {
                            $files = $request->file('taxi_image')[$key];

                            $random_no = uniqid();
                            $img = $files;
                            $ext = $files->getClientOriginalExtension();
                            $new_name = $random_no . time() . '.' . $ext;
                            $destinationPath = public_path('uploads/TransferPageImage');
                            $img->move($destinationPath, $new_name);
                            $TransferPageTaxi['image'] = $new_name;
                        }
                    }
                    $TransferPageTaxi->save();

                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('transfer_page_taxi_language',['language_id'=>$value['id'],'transfer_page_taxi_id' => $TransferPageTaxi->id,'transfer_page_id'=> $transfer_page_id ],'row')) {
                            $TransferPageTaxiLanguage                           = new TransferPageTaxiLanguage();
                            $TransferPageTaxiLanguage['transfer_page_id']       = $transfer_page_id;
                            $TransferPageTaxiLanguage['language_id']            = $value['id'];
                            $TransferPageTaxiLanguage['transfer_page_taxi_id']  = $TransferPageTaxi->id;
                            $TransferPageTaxiLanguage['title']                  = isset($request->taxi_title[$value['id']][$key]) ?  $request->taxi_title[$value['id']][$key] : $request->taxi_title[$lang_id][$key];
                            $TransferPageTaxiLanguage['information']            = isset($request->taxi_info[$value['id']][$key]) ?  $request->taxi_info[$value['id']][$key] : $request->taxi_info[$lang_id][$key];  
                            $TransferPageTaxiLanguage->save();
                        }
                    }
                }
            }


            // Book with us
            if ($request->with_title) {
                TransferPageWithusLanguage::where(['transfer_page_id' => $transfer_page_id])->where('language_id',$lang_id)->delete();

                foreach ($request->with_us_id as $key => $value_with) {
                    if ($value_with != '') {
                        $TransferPageWithus = TransferPageWithus::find($value_with);
                    } else {
                        $TransferPageWithus = new TransferPageWithus();
                    }

                    $TransferPageWithus['transfer_page_id'] = $transfer_page_id;

                    if ($request->hasFile('with_us_image')) {
                        if (isset($request->with_us_image[$key])) {
                            $files = $request->file('with_us_image')[$key];

                            $random_no = uniqid();
                            $img = $files;
                            $ext = $files->getClientOriginalExtension();
                            $new_name = $random_no . time() . '.' . $ext;
                            $destinationPath = public_path('uploads/TransferPageImage');
                            $img->move($destinationPath, $new_name);
                            $TransferPageWithus['image'] = $new_name;
                        }
                    }
                    $TransferPageWithus->save();


                    
                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('transfer_page_with_us_language',['language_id'=>$value['id'],'with_us_id' => $TransferPageWithus->id,'transfer_page_id'=> $transfer_page_id ],'row')) {
                            $TransferPageWithusLanguage                           = new TransferPageWithusLanguage();
                            $TransferPageWithusLanguage['transfer_page_id']       = $transfer_page_id;
                            $TransferPageWithusLanguage['language_id']            = $value['id'];
                            $TransferPageWithusLanguage['with_us_id']             = $TransferPageWithus->id;
                            $TransferPageWithusLanguage['title']                  = isset($request->with_title[$value['id']][$key]) ?  $request->with_title[$value['id']][$key] : $request->with_title[$lang_id][$key];
                            $TransferPageWithusLanguage->save();
                        }
                    }
                }
            }


            // Highlights
            if ($request->highlights_title) {
                TransferPageHighlightsLanguage::where(['transfer_page_id' => $transfer_page_id])->where('language_id',$lang_id)->delete();

                foreach ($request->highlights_id as $key => $value_high) {
                    if ($value_high != '') {
                        $TransferPageHighlights = TransferPageHighlights::find($value_high);
                    } else {
                        $TransferPageHighlights = new TransferPageHighlights();
                    }

                    $TransferPageHighlights['transfer_page_id'] = $transfer_page_id;
                    $TransferPageHighlights['sort_order'] = $request->sort_order[$key];

                    if ($request->hasFile('high_image')) {
                        if (isset($request->high_image[$key])) {
                            $files = $request->file('high_image')[$key];

                            $random_no = uniqid();
                            $img = $files;
                            $ext = $files->getClientOriginalExtension();
                            $new_name = $random_no . time() . '.' . $ext;
                            $destinationPath = public_path('uploads/TransferPageImage');
                            $img->move($destinationPath, $new_name);
                            $TransferPageHighlights['image'] = $new_name;
                        }
                    }
                    $TransferPageHighlights->save();

                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('transfer_page_highlights_language',['language_id'=>$value['id'],'transfer_page_highlight_id' => $TransferPageHighlights->id,'transfer_page_id'=> $transfer_page_id ],'row')) {
                            $TransferPageHighlightsLanguage                                 = new TransferPageHighlightsLanguage();
                            $TransferPageHighlightsLanguage['transfer_page_id']             = $transfer_page_id;
                            $TransferPageHighlightsLanguage['language_id']                  = $value['id'];
                            $TransferPageHighlightsLanguage['transfer_page_highlight_id']   = $TransferPageHighlights->id;
                            $TransferPageHighlightsLanguage['title']                  = isset($request->highlights_title[$value['id']][$key]) ?  $request->highlights_title[$value['id']][$key] : $request->highlights_title[$lang_id][$key];
                            $TransferPageHighlightsLanguage['description']            = isset($request->highlights_description[$value['id']][$key]) ? change_str($request->highlights_description[$value['id']][$key]) : $request->highlights_description[$lang_id][$key];
                            $TransferPageHighlightsLanguage->save();
                        }
                    }
                }
            }


            return redirect()
                ->route('admin.transfer_page.edit', encrypt(1))
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'No Record Found']);
            }
            $id               = checkDecrypt($id);
            $common['title']  = 'Edit Transfer Page';
            $common['button'] = 'Update';

            $get_transfer_page              = TransferPage::where('id', $id)->first();
            $get_transfer_page_language     = TransferPageLanguage::where('transfer_page_id', $id)->get();

            $get_transfer_page_wbt           = TransferPageWhyBook::where('transfer_page_id', $id)->get();
            $get_transfer_page_wbt_language  = TransferPageWhyBookLanguage::where('transfer_page_id', $id)->get();

            $get_transfer_page_premium_taxi           = TransferPageTaxi::where('transfer_page_id', $id)->get();
            $get_transfer_page_premium_taxi_language  = TransferPageTaxiLanguage::where('transfer_page_id', $id)->get();

            $get_transfer_page_with_us           = TransferPageWithus::where('transfer_page_id', $id)->get();
            $get_transfer_page_with_us_language  = TransferPageWithusLanguage::where('transfer_page_id', $id)->get();

            $get_transfer_page_highlights           = TransferPageHighlights::where('transfer_page_id', $id)->get();
            $get_transfer_page_highlights_language  = TransferPageHighlightsLanguage::where('transfer_page_id', $id)->get();

            $get_slider_images           = PageSliders::where(['page_id' => $id, 'page' => 'transfer_page'])->get();
            $get_slider_images_language  = PageSlidersLanguage::where(['page_id' => $id, 'page' => 'transfer_page'])->get();

            $get_peremium_taxi_heading = MetaGlobalLanguage::where(['meta_title' => 'premium_taxi_heading'])->get();
            $get_transfer_privacy      = MetaGlobalLanguage::where(['meta_title' => 'transfer_terms_conditions'])->get();
            $get_why_booking_heading      = MetaGlobalLanguage::where(['meta_title' => 'why_booking_heading'])->get();
            $MetaGlobalSideBanner                  = MetaGlobalLanguage::where('meta_title', 'transfer_side_banner')->first();

            if (!$get_transfer_page) {
                return back()->withErrors(['error' => 'Something went wrong']);
            }
        }

        return view('admin.transfer_page.transfer_page', compact('common', 'get_transfer_page', 'languages', 'get_transfer_page_language', 'get_transfer_page_wbt', 'get_transfer_page_wbt_language', 'TPT', 'get_transfer_page_premium_taxi', 'get_transfer_page_premium_taxi_language', 'TWU', 'get_transfer_page_with_us', 'get_transfer_page_with_us_language', 'TPH', 'get_transfer_page_highlights', 'get_transfer_page_highlights_language', 'get_peremium_taxi_heading', 'get_slider_images', 'get_slider_images_language', 'LSI','lang_id','get_transfer_privacy','MetaGlobalSideBanner','get_why_booking_heading'));
    }
}
