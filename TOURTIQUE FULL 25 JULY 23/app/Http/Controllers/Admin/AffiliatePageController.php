<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\AffiliatePage;
use App\Models\AffiliatePageLanguage;
use App\Models\AffiliatePageSliderImage;
use App\Models\AffiliatePageWork;
use App\Models\AffiliatePageWorkLanguage;
use App\Models\AffiliatePageChoose;
use App\Models\AffiliatePageChooseLanguage;
use App\Models\MetaGlobalLanguage;
use App\Models\PagesFaqs;
use App\Models\PagesFaqLanguage;
use App\Models\Language;

use App\Models\PageSliders;
use App\Models\PageSlidersLanguage;    

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Str;

class AffiliatePageController extends Controller
{
   
    ///Add AffiliatePage
    public function add_affiliate_page(Request $request, $id = ""){
        $common = array();
        Session::put("TopMenu", "Pages");
        Session::put("SubMenu", "Affiliate Page");

        $common['title']              = translate("Add Affiliate Page");
        $common['button']             = translate("Save");
        $get_affiliate_page           = getTableColumn('affiliate_page');
        $get_affiliate_page_language  = "";
        $languages                    = Language::where(ConditionQuery())->get();

        $get_affiliate_page_slider_image    = [];
        $get_affiliate_page_work            = [];
        $get_affiliate_page_work_language   = [];
        $GPF                                = getTableColumn('affiliate_page_work');

        $get_affiliate_page_choose            = [];
        $get_affiliate_page_choose_language   = [];
        $WCU                                  = getTableColumn('affiliate_page_choose');

        $get_affiliate_page_faq               = [];
        $get_affiliate_page_faq_language      = [];
        $FAQS                                 = getTableColumn('pages_faq');

        // slider images
        $get_slider_images                 = [];
        $get_slider_images_language        = [];
        $get_faq_heading                   = [];
        $get_HiW_heading                   = [];
        $get_choose_heading                = [];
        $HSI                               = getTableColumn('pages_slider');

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $get_languages = Language::where(['status'=>'Active','is_delete' => 0])->get();


        if ($request->isMethod('post')) {

            $req_fields = array();
            // $req_fields['title.*']   = "required";

            // $req_fields['about_title.*']   = "required";
            // $req_fields['about_description.*']   = "required";

            // $req_fields['work_title.*']   = "required";
            // $req_fields['work_description.*']   = "required";

            $errormsg = [
                "title.*" => translate("Title"),

                "about_title.*" => translate("About Title"),
                "about_description.*" => translate("About description"),

                "work_title.*" => translate("Work Title"),
                "work_description.*" => translate("Work description"),
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
                $message           = translate("Update Successfully");
                $status            = "success";
                $AffiliatePage     = AffiliatePage::find($request->id);
                $AffiliatePageWork = AffiliatePageWork::find($request->id);
                AffiliatePageLanguage::where("affiliate_page_id", $request->id)->where('language_id',$lang_id)->delete();
            } else{ 
                $message  = translate("Add Successfully");
                $status   = "success";
                $AffiliatePage      = new AffiliatePage();
                $AffiliatePageWork  = new AffiliatePageWork();
            }

            if ($request->hasFile('about_image_1')) {
                $files = $request->file('about_image_1');
                $random_no  = Str::random(5);
                $newImage = time() . $random_no  . '.' . $files->getClientOriginalExtension();
                $destinationPath = public_path('uploads/Affiliate_Page');
                $imgFile = Image::make($files->path());
                $height =  $imgFile->height();
                $width  =  $imgFile->width();
                if ($width > 600) {
                    $imgFile->resize(385, 260, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                if ($height > 600) {
                    $imgFile->resize(385, 260, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                $destinationPath =  public_path('uploads/Affiliate_Page');
                $imgFile->save($destinationPath . '/' . $newImage);
                // $image->move($destinationPath, $ProductImages['product_images']);
                $AffiliatePage['about_image_1']    =   $newImage;
            }

            if ($request->hasFile('about_image_2')) {
                $files = $request->file('about_image_2');
                $random_no  = Str::random(5);
                $newImage = time() . $random_no  . '.' . $files->getClientOriginalExtension();
                $destinationPath = public_path('uploads/Affiliate_Page');
                $imgFile = Image::make($files->path());
                $height =  $imgFile->height();
                $width  =  $imgFile->width();
                if ($width > 600) {
                    $imgFile->resize(832, 804, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                if ($height > 600) {
                    $imgFile->resize(832, 804, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                $destinationPath =  public_path('uploads/Affiliate_Page');
                $imgFile->save($destinationPath . '/' . $newImage);
                // $image->move($destinationPath, $ProductImages['product_images']);
                $AffiliatePage['about_image_2']    =   $newImage;
            }

            // $AffiliatePage['status']         = "isset($request->status)  ? "Active" : "Deactive"";
            $AffiliatePage->save();

            $affiliate_page_id = $AffiliatePage->id;

            //Muliple File
            if (isset($request->image_id)) {                
                $AffiliatePageSliderImage = AffiliatePageSliderImage::where('affiliate_page_id', $request->id)->get();
                foreach ($AffiliatePageSliderImage as $key => $image_delete) {
                    if (!in_array($image_delete['id'], $request->image_id)) {
                        AffiliatePageSliderImage::where('id', $image_delete['id'])->delete();
                    }
                }
            }else{
                 AffiliatePageSliderImage::where('affiliate_page_id', $request->id)->delete();
            }
            
            // Multiple IMages
            if ($request->hasFile('files')) {
                $files = $request->file('files');
                foreach ($files as $fileKey => $image) {
                    $AffiliatePageSliderImage = new AffiliatePageSliderImage();
                    $random_no  = Str::random(5);
                    $AffiliatePageSliderImage['slider_images'] = $newImage = time() . $random_no  . '.' . $image->getClientOriginalExtension();

                    $destinationPath = public_path('uploads/Affiliate_Page');
                    $imgFile = Image::make($image->path());

                    $height =  $imgFile->height();
                    $width  =  $imgFile->width();

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

                    $destinationPath =  public_path('uploads/Affiliate_Page');
                    $imgFile->save($destinationPath . '/' . $newImage);
                    $AffiliatePageSliderImage['affiliate_page_id']    =   $AffiliatePage->id;
                    $AffiliatePageSliderImage->save();
                }
            }




            foreach ($get_languages as $key => $value) {
                //Faq Heading
                if (!empty($request->faq_heading)) {
                    $MetaGlobalLanguageFaqHeading                  = MetaGlobalLanguage::where('meta_title', 'affilate_page_faq_heading')->where('language_id',$value['id'])->first();
                    if(!$MetaGlobalLanguageFaqHeading){
                        $MetaGlobalLanguageFaqHeading              = new MetaGlobalLanguage();
                    }
                    if($lang_id == $value['id']){
                        $MetaGlobalLanguageFaqHeading->title       = $request->faq_heading[$lang_id];
                    }else{
                        if(!$MetaGlobalLanguageFaqHeading->title){
                            $MetaGlobalLanguageFaqHeading->title       = $request->faq_heading[$lang_id];
                        }
                    }                    
                    $MetaGlobalLanguageFaqHeading->meta_parent = 'affilate_page';
                    $MetaGlobalLanguageFaqHeading->meta_title  = 'affilate_page_faq_heading';
                    $MetaGlobalLanguageFaqHeading->language_id = $value['id'];
                    $MetaGlobalLanguageFaqHeading->status      = 'Active';
                    $MetaGlobalLanguageFaqHeading->save();
                }

                //How iTs Work HEading
                if (!empty($request->how_its_work_heading)) {
                    $MetaGlobalLanguageHIWHeading                  = MetaGlobalLanguage::where('meta_title', 'affilat_page_how_its_work_heading')->where('language_id',$value['id'])->first();
                    if(!$MetaGlobalLanguageHIWHeading){
                        $MetaGlobalLanguageHIWHeading              = new MetaGlobalLanguage();
                    }
                    if($lang_id == $value['id']){
                        $MetaGlobalLanguageHIWHeading->title       = $request->how_its_work_heading[$lang_id];
                    }else{
                        if(!$MetaGlobalLanguageHIWHeading->title){
                            $MetaGlobalLanguageHIWHeading->title       = $request->how_its_work_heading[$lang_id];
                        }
                    }                    
                    $MetaGlobalLanguageHIWHeading->meta_parent = 'affilate_page';
                    $MetaGlobalLanguageHIWHeading->meta_title  = 'affilat_page_how_its_work_heading';
                    $MetaGlobalLanguageHIWHeading->language_id = $value['id'];
                    $MetaGlobalLanguageHIWHeading->status      = 'Active';
                    $MetaGlobalLanguageHIWHeading->save();
                }

                //Why Choose HEading
                if (!empty($request->why_choose_heading)) {
                    $MetaGlobalLanguageChooseHeading                  = MetaGlobalLanguage::where('meta_title', 'affilat_page_choose_heading')->where('language_id',$value['id'])->first();
                    if(!$MetaGlobalLanguageChooseHeading){
                        $MetaGlobalLanguageChooseHeading              = new MetaGlobalLanguage();
                    }
                    if($lang_id == $value['id']){
                        $MetaGlobalLanguageChooseHeading->title       = $request->why_choose_heading[$lang_id];
                    }else{
                        if(!$MetaGlobalLanguageChooseHeading->title){
                            $MetaGlobalLanguageChooseHeading->title       = $request->why_choose_heading[$lang_id];
                        }
                    }                    
                    $MetaGlobalLanguageChooseHeading->meta_parent = 'affilate_page';
                    $MetaGlobalLanguageChooseHeading->meta_title  = 'affilat_page_choose_heading';
                    $MetaGlobalLanguageChooseHeading->language_id = $value['id'];
                    $MetaGlobalLanguageChooseHeading->status      = 'Active';
                    $MetaGlobalLanguageChooseHeading->save();
                }

                
            }

            // Affiliate about details
            if (!empty($request->about_title)) {

                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('affiliate_page_language',['language_id'=>$value['id'],'affiliate_page_id'=>$AffiliatePage->id],'row')) {     
                        $AffiliatePageLanguage              = new AffiliatePageLanguage();
                    
                        $AffiliatePageLanguage->affiliate_page_id   = $AffiliatePage->id;
                        // $AffiliatePageLanguage->title               = isset($request->title[$value['id']]) ?  $request->title[$value['id']] : $request->title[$lang_id];

                        $AffiliatePageLanguage->about_title         = isset($request->about_title[$value['id']]) ?  $request->about_title[$value['id']] : $request->about_title[$lang_id];

                        $AffiliatePageLanguage->about_description   = isset($request->about_description[$value['id']]) ?  $request->about_description[$value['id']] : $request->about_description[$lang_id];

                        $AffiliatePageLanguage->language_id         = $value['id'];
                        $AffiliatePageLanguage->save();
                    }
                }
            }

            // How it Work
            if ($request->work_id) {
                $work_id_arr = array_filter($request->work_id, fn($value) => !is_null($value) && $value !== '');
                AffiliatePageWork::whereNotIn('id', $work_id_arr)->where("affiliate_page_id" ,$affiliate_page_id)->delete();

                AffiliatePageWorkLanguage::where(["affiliate_page_id" => $affiliate_page_id])->where('language_id',$lang_id)->delete();
                foreach ($request->work_id as $key => $value_work) {

                    if ($value_work != '') {
                        $AffiliatePageWork = AffiliatePageWork::find($value_work);
                    } else {
                        $AffiliatePageWork = new AffiliatePageWork();
                    }

                    $AffiliatePageWork['affiliate_page_id'] = $affiliate_page_id;

                    if ($request->hasFile('work_image')) {
                        if (isset($request->work_image[$key])) {
                            $files = $request->file('work_image')[$key];

                            $random_no       = uniqid();
                            $img             = $files;
                            $ext             = $files->getClientOriginalExtension();
                            $new_name        = $random_no . time() . '.' . $ext;
                            $destinationPath =  public_path('uploads/Affiliate_Page');
                            $img->move($destinationPath, $new_name);
                            $AffiliatePageWork['work_image'] = $new_name;
                        }
                    }
                    $AffiliatePageWork->save();

                    foreach ($get_languages as $value_key => $value) {
                        if (!getDataFromDB('affiliate_page_work_language',['language_id'=>$value['id'],'affiliate_page_id'=>$affiliate_page_id,'affiliate_page_work_id'=>$AffiliatePageWork->id],'row')) {   

                            $AffiliatePageWorkLanguage = new AffiliatePageWorkLanguage();
                            $AffiliatePageWorkLanguage['affiliate_page_id']              = $affiliate_page_id;
                            $AffiliatePageWorkLanguage['language_id']                    = $value['id'];
                            $AffiliatePageWorkLanguage['affiliate_page_work_id']         = $AffiliatePageWork->id;
                            $AffiliatePageWorkLanguage['work_title']                     = isset($request->work_title[$value['id']][$key]) ?  $request->work_title[$value['id']][$key] : $request->work_title[$lang_id][$key];
                            $AffiliatePageWorkLanguage['work_description']               = isset($request->work_description[$value['id']][$key]) ?  $request->work_description[$value['id']][$key] : $request->work_description[$lang_id][$key];
                            $AffiliatePageWorkLanguage->save();
                        }
                    }
                }
            }

            // Why choose Us
            if ($request->affiliate_choose_id) {
                $affiliate_choose_id = array_filter($request->affiliate_choose_id, fn($value) => !is_null($value) && $value !== '');
                AffiliatePageChoose::whereNotIn('id', $affiliate_choose_id)->where("affiliate_page_id" ,$affiliate_page_id)->delete();
                AffiliatePageChooseLanguage::where(["affiliate_page_id" => $affiliate_page_id])->where('language_id',$lang_id)->delete();
                foreach ($request->affiliate_choose_id as $key => $value_choose) {

                    if ($value_choose != '') {
                        $AffiliatePageChoose = AffiliatePageChoose::find($value_choose);
                    } else {
                        $AffiliatePageChoose = new AffiliatePageChoose();
                    }

                    $AffiliatePageChoose['affiliate_page_id'] = $affiliate_page_id;

                    if ($request->hasFile('choose_image')) {
                        if (isset($request->choose_image[$key])) {
                            $files = $request->file('choose_image')[$key];

                            $random_no       = uniqid();
                            $img             = $files;
                            $ext             = $files->getClientOriginalExtension();
                            $new_name        = $random_no . time() . '.' . $ext;
                            $destinationPath =  public_path('uploads/Affiliate_Page');
                            $img->move($destinationPath, $new_name);
                            $AffiliatePageChoose['choose_image'] = $new_name;
                        }
                    }
                    $AffiliatePageChoose->save();

                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('affiliate_page_choose_language',['language_id'=>$value['id'],'affiliate_page_id' => $affiliate_page_id,'affiliate_page_choose_id'=> $AffiliatePageChoose->id ],'row')) {
                            $AffiliatePageChooseLanguage = new AffiliatePageChooseLanguage();
                            $AffiliatePageChooseLanguage['affiliate_page_id']              = $affiliate_page_id;
                            $AffiliatePageChooseLanguage['language_id']                    = $value['id'];
                            $AffiliatePageChooseLanguage['affiliate_page_choose_id']       = $AffiliatePageChoose->id;
                            $AffiliatePageChooseLanguage['choose_description']             = isset($request->choose_description[$value['id']][$key]) ?  $request->choose_description[$value['id']][$key] : $request->choose_description[$lang_id][$key];
                            $AffiliatePageChooseLanguage->save();
                        }
                    }
                }
            }


            // Faqss

            if (isset($request->faq_id)) {
                $get_page_faq = PagesFaqs::where('affiliate_page_id', $request->id)->get();
                foreach ($get_page_faq as $key => $get_faq_delete) {
                    if (!in_array($get_faq_delete['id'], $request->faq_id)) {
                        PagesFaqs::where('id', $get_faq_delete['id'])->delete();
                    }
                }
            }
            if ($request->question) {
                // PagesFaqs::where(["affiliate_page_id" => $affiliate_page_id])->delete();
                PagesFaqLanguage::where(["affiliate_page_id" => $affiliate_page_id])->where('language_id',$lang_id)->delete();
                foreach ($request->faq_id as $key => $value_faq) {
                    
                    if ($value_faq != '') {
                        $PagesFaqs = PagesFaqs::find($value_faq);
                    } else {
                        $PagesFaqs = new PagesFaqs();
                    }

                    $PagesFaqs['affiliate_page_id'] = $affiliate_page_id;
                    $PagesFaqs['page_name']         = 'affiliate page';
                    $PagesFaqs->save();

                    
                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('pages_faq_language',['language_id'=>$value['id'],'affiliate_page_id' => $affiliate_page_id,'page_faq_id'=> $PagesFaqs->id ],'row')) {
                            $PagesFaqLanguage = new PagesFaqLanguage();
                            $PagesFaqLanguage['affiliate_page_id']          = $affiliate_page_id;
                            $PagesFaqLanguage['page_faq_id']                = $PagesFaqs->id;
                            $PagesFaqLanguage['language_id']                = $value['id'];
                            $PagesFaqLanguage['question']                   = isset($request->question[$value['id']][$key]) ?  $request->question[$value['id']][$key] : $request->question[$lang_id][$key];
                            $PagesFaqLanguage['answer']                     = isset($request->answer[$value['id']][$key]) ?  $request->answer[$value['id']][$key] : $request->answer[$lang_id][$key];
                            $PagesFaqLanguage->save();
                        }
                    }
                }
            }

             // Slider Images
            $get_pageSlider = PageSliders::where(['page_id'=> 1,'page'=>'affiliate_page_slider'])->get();
            foreach ($get_pageSlider as $key => $val) {
                if (!in_array($val['id'], $request->slider_img_id)) {
                    PageSliders::where('id', $val['id'])->delete();
                }
            }

            if (!empty($request->slider_title)) {
                if ($request->slider_title) {

                    PageSlidersLanguage::where(['page_id' => 1,'page'=>'affiliate_page_slider'])->where('language_id',$lang_id)->delete();

                    foreach ($request->slider_img_id as $key => $over_value) {
                
                        if($over_value !=''){
                            $PageSliders       = PageSliders::find($over_value);
                        }else{
                            $PageSliders       = new PageSliders();
                        }

                        $PageSliders->page_id  = 1;
                        $PageSliders->page     = "affiliate_page_slider";

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
                            if (!getDataFromDB('pages_slider_language',['language_id'=>$value['id'],'pages_slider_id'=>$page_slider_id,'page'=>'affiliate_page_slider'],'row')) {  
                                $PageSlidersLanguage = new PageSlidersLanguage();
                                $PageSlidersLanguage['page_id']            = 1;
                                $PageSlidersLanguage['pages_slider_id']    = $page_slider_id;
                                $PageSlidersLanguage['page']               = 'affiliate_page_slider';
                                $PageSlidersLanguage['language_id']        = $value['id'];
                                $PageSlidersLanguage['title']              = isset($request->slider_title[$value['id']][$key]) ?  $request->slider_title[$value['id']][$key] : $request->slider_title[$lang_id][$key];
                                $PageSlidersLanguage['description']        = isset($request->slider_description[$value['id']][$key]) ?  $request->slider_description[$value['id']][$key] : $request->slider_description[$lang_id][$key];
                                $PageSlidersLanguage->save();
                            }
                        }


                    }
                }
            }



            return redirect()->route('admin.affiliate_page.edit',encrypt(1))->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id           = checkDecrypt($id);
            $common['title']      = "Edit Affiliate Page";
            $common['button']     = "Update";
            $get_affiliate_page              = AffiliatePage::where('id', $id)->first();
            $get_affiliate_page_language     = AffiliatePageLanguage::where("affiliate_page_id", $id)->get();
            $get_affiliate_page_slider_image = AffiliatePageSliderImage::where("affiliate_page_id", $id)->get();

            $get_affiliate_page_work          = AffiliatePageWork::get();
            $get_affiliate_page_work_language = AffiliatePageWorkLanguage::where("affiliate_page_id", $id)->get();

            $get_affiliate_page_choose          = AffiliatePageChoose::where("affiliate_page_id", $id)->get();
            $get_affiliate_page_choose_language = AffiliatePageChooseLanguage::where("affiliate_page_id", $id)->get();

            $get_affiliate_page_faq          = PagesFaqs::where("affiliate_page_id", $id)->get();
            $get_affiliate_page_faq_language = PagesFaqLanguage::where("affiliate_page_id", $id)->get();

            $get_slider_images          = PageSliders::where(['page_id'=> 1,'page' => 'affiliate_page_slider','status'=>'Active'])->get();
            $get_slider_images_language = PageSlidersLanguage::where(['page_id'=> 1,'page' => 'affiliate_page_slider'])->get();

            $get_faq_heading           = MetaGlobalLanguage::where(['meta_title' => 'affilate_page_faq_heading'])->get();
            $get_HiW_heading           = MetaGlobalLanguage::where(['meta_title' => 'affilat_page_how_its_work_heading'])->get();
            $get_choose_heading        = MetaGlobalLanguage::where(['meta_title' => 'affilat_page_choose_heading'])->get();
            // print_die($get_faq_heading->toArray());
            if (!$get_affiliate_page) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.affiliate_page.add_affiliate_page', compact('common', 'get_affiliate_page','languages','get_affiliate_page_language','get_affiliate_page_slider_image','get_affiliate_page_work','get_affiliate_page_work_language','GPF','get_affiliate_page_choose','get_affiliate_page_choose_language','WCU','get_affiliate_page_faq','get_affiliate_page_faq_language','FAQS','get_slider_images','HSI','get_slider_images_language','lang_id','get_faq_heading','get_HiW_heading','get_choose_heading'));
    }
}
