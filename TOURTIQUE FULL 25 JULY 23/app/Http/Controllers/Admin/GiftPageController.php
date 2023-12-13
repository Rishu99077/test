<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GiftPage;
use App\Models\GiftPageLanguage;
use App\Models\GiftPageSliderImage;

use App\Models\GiftPagefacilities;
use App\Models\GiftPagefacilitiesLanguage;

use App\Models\GiftPageCardImage;

use App\Models\PageSliders;
use App\Models\PageSlidersLanguage;


use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Str;

class GiftPageController extends Controller
{
    ///Add GiftPage
    public function add_giftcard_page(Request $request, $id = '')
    {
        $common = [];
        Session::put('TopMenu', 'Pages');
        Session::put('SubMenu', 'Gift Card');

        $common['title'] = translate('Add Gift Card');
        $common['button'] = translate('Save');
        $get_giftcard_page = getTableColumn('giftcard_page');
        $get_giftcard_page_language = '';
        $languages = Language::where(ConditionQuery())->get();

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $get_languages = Language::where(['status'=>'Active','is_delete' => 0])->get();
        
        $get_giftcard_page_slider_image = [];
        $get_giftcard_page_facilities = [];
        $get_giftcard_page_facilities_language = [];
        $GPF = getTableColumn('giftcard_page_facilities');

        $LSI                = getTableColumn('pages_slider');
        $get_slider_images              = [];
        $get_slider_images_language     = [];

        $get_giftcard_page_card_image = [];

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
                $GiftPage = GiftPage::find($request->id);
                GiftPageLanguage::where('gift_card_id', $request->id)->where('language_id',$lang_id)->delete();
            } else {
                $message = translate('Add Successfully');
                $status = 'success';
                $GiftPage = new GiftPage();
            }

            // $GiftPage['status']         = isset($request->status)  ? "Active" : "Deactive";
            // print_die($request->all());
            if ($request->hasFile('file')) {
                $image               = $request->file('file');
                $random_no           = Str::random(5);
                $newImage            = time() . $random_no . '.' . $image->getClientOriginalExtension();
                $destinationPath     = public_path('uploads/GiftCardPage');
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

                $destinationPath = public_path('uploads/GiftCardPage');
                $imgFile->save($destinationPath . '/' . $newImage);
                $GiftPage['image'] = $newImage;
            }
            $GiftPage->save();

            $gift_card_id = $GiftPage->id;

            if (!empty($request->title)) {

                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('giftcard_page_language',['language_id'=>$value['id'],'gift_card_id'=>$request->id],'row')) {    
                        $GiftPageLanguage = new GiftPageLanguage();
                        $GiftPageLanguage->title = isset($request->title[$value['id']]) ?  $request->title[$value['id']] : $request->title[$lang_id];
                        $GiftPageLanguage->description = isset($request->description[$value['id']]) ?  $request->description[$value['id']] : $request->description[$lang_id];
                        $GiftPageLanguage->language_id = $value['id'];
                        $GiftPageLanguage->gift_card_id = $GiftPage->id;
                        $GiftPageLanguage->save();
                    }
                }
            }

            // Facilities
            if ($request->facility_title) {
                // GiftPagefacilities::where(["gift_card_id" => $gift_card_id])->delete();
                GiftPagefacilitiesLanguage::where(['gift_card_id' => $gift_card_id])->where('language_id',$lang_id)->delete();

                foreach ($request->facility_id as $key => $value_7) {
                    if ($value_7 != '') {
                        $GiftPagefacilities = GiftPagefacilities::find($value_7);
                    } else {
                        $GiftPagefacilities = new GiftPagefacilities();
                    }

                    $GiftPagefacilities['gift_card_id'] = $gift_card_id;

                    if ($request->hasFile('facility_image')) {
                        if (isset($request->facility_image[$key])) {
                            $files = $request->file('facility_image')[$key];

                            $random_no = uniqid();
                            $img = $files;
                            $ext = $files->getClientOriginalExtension();
                            $new_name = $random_no . time() . '.' . $ext;
                            $destinationPath = public_path('uploads/GiftCardPage');
                            $img->move($destinationPath, $new_name);
                            $GiftPagefacilities['facility_image'] = $new_name;
                        }
                    }
                    $GiftPagefacilities->save();

                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('giftcard_page_facilities_language',['language_id'=>$value['id'],'gift_card_id' => $gift_card_id,'gift_card_facilities_id'=> $GiftPagefacilities->id ],'row')) {  

                            $GiftPagefacilitiesLanguage = new GiftPagefacilitiesLanguage();
                            $GiftPagefacilitiesLanguage['gift_card_id'] = $gift_card_id;
                            $GiftPagefacilitiesLanguage['language_id']  = $value['id'];
                            $GiftPagefacilitiesLanguage['gift_card_facilities_id'] = $GiftPagefacilities->id;
                            $GiftPagefacilitiesLanguage['facility_title'] = isset($request->facility_title[$value['id']][$key]) ?  $request->facility_title[$value['id']][$key] : $request->facility_title[$lang_id][$key];
                            $GiftPagefacilitiesLanguage['facility_description'] = isset($request->facility_description[$value['id']][$key]) ?  $request->facility_description[$value['id']][$key] : $request->facility_description[$lang_id][$key];    
                            $GiftPagefacilitiesLanguage->save();
                        }
                    }
                }
            }

            // Gift card Images
            //Muliple File
            if (isset($request->image_id)) {
                $GiftPageCardImage = GiftPageCardImage::where('gift_card_id', $request->id)->get();
                foreach ($GiftPageCardImage as $key => $image_delete) {
                    if (!in_array($image_delete['id'], $request->image_id)) {
                        GiftPageCardImage::where('id', $image_delete['id'])->delete();
                    }
                }
            }

            // Multiple IMages
            if ($request->hasFile('files_2')) {
                $files = $request->file('files_2');
                foreach ($files as $fileKey => $image) {
                    $GiftPageCardImage = new GiftPageCardImage();
                    $random_no = Str::random(5);
                    $GiftPageCardImage['card_images'] = $newImage = time() . $random_no . '.' . $image->getClientOriginalExtension();

                    $destinationPath = public_path('uploads/GiftCardPage');
                    $imgFile = Image::make($image->path());

                    $height = $imgFile->height();
                    $width = $imgFile->width();

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

                    $destinationPath = public_path('uploads/GiftCardPage');
                    $imgFile->save($destinationPath . '/' . $newImage);
                    $GiftPageCardImage['gift_card_id'] = $GiftPage->id;
                    $GiftPageCardImage->save();
                }
            }


            // Slider Images-------------------------------------------------------
            $get_pageSlider = PageSliders::where(['page' => 'giftcard_page'])->get();
            foreach ($get_pageSlider as $key => $val) {
                if (!in_array($val['id'], $request->over_view_id)) {
                    PageSliders::where('id', $val['id'])->delete();
                }
            }
            if (!empty($request->slider_title)) {
                if ($request->slider_title) {

                    PageSlidersLanguage::where(['page_id' => 1, 'page' => 'giftcard_page'])->where('language_id',$lang_id)->delete();

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
                                $PageSliders->page     = "giftcard_page";
                            }
                        }

                        $PageSliders->save();
                        $page_slider_id = $PageSliders->id;

                        foreach ($get_languages as $lang_key => $value) {
                            if (!getDataFromDB('pages_slider_language',['language_id'=>$value['id'],'pages_slider_id' => $page_slider_id,'page'=> 'giftcard_page' ],'row')) {  
                                $PageSlidersLanguage = new PageSlidersLanguage();
                                $PageSlidersLanguage['page_id']            = 1;
                                $PageSlidersLanguage['pages_slider_id']    = $page_slider_id;
                                $PageSlidersLanguage['page']               = 'giftcard_page';
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
                ->route('admin.giftcard_page.edit', encrypt(1))
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'No Record Found']);
            }
            $id = checkDecrypt($id);
            $common['title'] = 'Edit Gift Card';
            $common['button'] = 'Update';

            $get_giftcard_page = GiftPage::where('id', $id)->first();
            $get_giftcard_page_language = GiftPageLanguage::where('gift_card_id', $id)->get();
            // $get_giftcard_page_slider_image = GiftPageSliderImage::where('gift_card_id', $id)->get();

            $get_giftcard_page_facilities = GiftPagefacilities::where('gift_card_id', $id)->get();
            $get_giftcard_page_facilities_language = GiftPagefacilitiesLanguage::where('gift_card_id', $id)->get();

            $get_giftcard_page_card_image = GiftPageCardImage::where('gift_card_id', $id)->get();

            $get_slider_images           = PageSliders::where(['page_id' => $id, 'page' => 'giftcard_page'])->get();
            $get_slider_images_language  = PageSlidersLanguage::where(['page_id' => $id, 'page' => 'giftcard_page'])->get();

            if (!$get_giftcard_page) {
                return back()->withErrors(['error' => 'Something went wrong']);
            }
        }


        return view('admin.gift_card_page.add_giftcard_page', compact('common', 'get_giftcard_page', 'languages', 'get_giftcard_page_language', 'get_giftcard_page_slider_image', 'get_giftcard_page_facilities', 'get_giftcard_page_facilities_language', 'GPF', 'get_giftcard_page_card_image', 'get_slider_images', 'get_slider_images_language', 'LSI','lang_id'));
    }

    /*public function delete($id){
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_gift_card =  GiftPage::find($id);
        if ($get_gift_card) {
            $get_gift_card->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }*/
}
