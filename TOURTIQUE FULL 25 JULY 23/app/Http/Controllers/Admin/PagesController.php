<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\PageSliders;
use App\Models\PageSlidersLanguage;

use App\Models\Blogpagefeatured;
use App\Models\BlogpagefeaturedLanguage;
use App\Models\MetaGlobalLanguage;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Str;

class PagesController extends Controller
{
    // limousine_page
    public function add_limousine_page(Request $request, $id = '')
    {
        $common = [];
        Session::put('TopMenu', 'Pages');
        Session::put('SubMenu', 'Limousine Page');

        $common['title']                    = translate('Limousine Page');
        $common['button']                   = translate('Save');
        $get_slider_images                  = [];
        $MetaGlobalSideBanner               = [];
        $get_slider_images_language         = [];
        $LSI                                = getTableColumn('pages_slider');        
        $languages                          = Language::where(ConditionQuery())->get();

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];
        $get_languages = Language::where(['status'=>'Active','is_delete' => 0])->get();

        if ($request->isMethod('post')) {

            $message      = translate('Update Successfully');
            $status       = 'success';
            
            //Banner OverView
            if(isset(($request->slider_title))){
                if(!empty($request->over_view_id)){
                    $BannerOverviewdelete = PageSliders::whereNotIn('id',$request->over_view_id)->where('page','limousine_page')->delete();
                    PageSlidersLanguage::where(['page' => 'limousine_page'])->where('language_id',$lang_id)->delete();
                    
                    foreach ($request->over_view_id as $over_key => $over_value) {
                
                        if($over_value !=''){
                            $PageSliders       = PageSliders::find($over_value);
                        }else{
                            $PageSliders       = new PageSliders();
                        }
                        $PageSliders->page_id  = 1;
                        $PageSliders->page     = "limousine_page";

                        if ($request->hasFile('slider_image')) {
                            if (isset($request->slider_image[$over_key])) {
                                $files = $request->file('slider_image')[$over_key];
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
                            if (!getDataFromDB('pages_slider_language',['language_id'=>$value['id'],'pages_slider_id' => $page_slider_id,'page'=> 'limousine_page' ],'row')) { 
                                $PageSlidersLanguage = new PageSlidersLanguage();
                                $PageSlidersLanguage['page_id']            = 1;
                                $PageSlidersLanguage['pages_slider_id']    = $page_slider_id;
                                $PageSlidersLanguage['page']               = 'limousine_page';
                                $PageSlidersLanguage['language_id']        = $value['id'];
                                $PageSlidersLanguage['title']              = isset($request->slider_title[$value['id']][$over_key]) ?  $request->slider_title[$value['id']][$over_key] : $request->slider_title[$lang_id][$over_key];
                                $PageSlidersLanguage['description']        = isset($request->slider_description[$value['id']][$over_key]) ?  $request->slider_description[$value['id']][$over_key] : $request->slider_description[$lang_id][$over_key];
                                $PageSlidersLanguage->save();
                            }
                        }
                    }
                }
            }

            //Side Banner Start
            if ($request->hasFile('side_banner')) {
                $MetaGlobalSideBanner                  = MetaGlobalLanguage::where('meta_title', 'limousine_side_banner')->first();
                if(!$MetaGlobalSideBanner){
                    $MetaGlobalSideBanner              = new MetaGlobalLanguage();
                }
                $MetaGlobalSideBanner->meta_parent = 'limousine_page';
                $MetaGlobalSideBanner->meta_title  = 'limousine_side_banner';
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
            //Side Banner Start


            return redirect()
                ->route('admin.limousine_page.edit', encrypt(1))
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'No Record Found']);
            }
            $id               = checkDecrypt($id);
            $common['title']  = 'Edit Limousine Page';
            $common['button'] = 'Update';

            $get_slider_images              = PageSliders::where(['page_id'=> 1 ,'page' => 'limousine_page'])->get();
            $get_slider_images_language     = PageSlidersLanguage::where(['page_id'=> 1,'page' => 'limousine_page'])->get();
            $MetaGlobalSideBanner                  = MetaGlobalLanguage::where('meta_title', 'limousine_side_banner')->first();

        }

        return view('admin.limousine_page.limousine_page', compact('common','get_slider_images','LSI','get_slider_images_language','lang_id','MetaGlobalSideBanner'));
    }


     // yacht 
    public function add_yacht_page(Request $request, $id = '')
    {
        $common = [];
        Session::put('TopMenu', 'Pages');
        Session::put('SubMenu', 'Yacht Page');

        $common['title']                    = translate('Yacht Page');
        $common['button']                   = translate('Save');

        $get_slider_images_language         = [];
        $get_slider_images                  = [];
        $MetaGlobalSideBanner                  = [];

        $LSI                                = getTableColumn('pages_slider');        
        $languages                          = Language::where(ConditionQuery())->get();

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];
        $get_languages = Language::where(['status'=>'Active','is_delete' => 0])->get();

        if ($request->isMethod('post')) {
            $message      = translate('Update Successfully');
            $status       = 'success';

              //Banner OverView
            if(isset(($request->slider_title))){
                if(!empty($request->yatch_id)){
                    $BannerOverviewdelete = PageSliders::whereNotIn('id',$request->yatch_id)->where('page','yacht_page')->delete();
                    PageSlidersLanguage::where(['page' => 'yacht_page'])->where('language_id',$lang_id)->delete();
                    
                    foreach ($request->yatch_id as $over_key => $over_value) {
                
                        if($over_value !=''){
                            $PageSliders       = PageSliders::find($over_value);
                        }else{
                            $PageSliders       = new PageSliders();
                        }
                        $PageSliders->page_id  = 1;
                        $PageSliders->page     = "yacht_page";
                        if ($request->hasFile('slider_image')) {
                            if (isset($request->slider_image[$over_key])) {
                                $files = $request->file('slider_image')[$over_key];
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
                            if (!getDataFromDB('pages_slider_language',['language_id'=>$value['id'],'pages_slider_id' => $page_slider_id,'page'=> 'yacht_page' ],'row')) { 
                                $PageSlidersLanguage = new PageSlidersLanguage();
                                $PageSlidersLanguage['page_id']            = 1;
                                $PageSlidersLanguage['pages_slider_id']    = $page_slider_id;
                                $PageSlidersLanguage['page']               = 'yacht_page';
                                $PageSlidersLanguage['language_id']        = $value['id'];

                                $PageSlidersLanguage['title']              = isset($request->slider_title[$value['id']][$over_key]) ?  $request->slider_title[$value['id']][$over_key] : $request->slider_title[$lang_id][$over_key];
                                $PageSlidersLanguage['description']        = isset($request->slider_description[$value['id']][$over_key]) ?  $request->slider_description[$value['id']][$over_key] : $request->slider_description[$lang_id][$over_key];

                                $PageSlidersLanguage->save();
                            }
                        }
                    }
                }
            }


            //Side Banner
            if ($request->hasFile('side_banner')) {
                $MetaGlobalSideBanner                  = MetaGlobalLanguage::where('meta_title', 'yacht_side_banner')->first();
                if(!$MetaGlobalSideBanner){
                    $MetaGlobalSideBanner              = new MetaGlobalLanguage();
                }
                $MetaGlobalSideBanner->meta_parent = 'yacht_page';
                $MetaGlobalSideBanner->meta_title  = 'yacht_side_banner';
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
                ->route('admin.yacht_page.edit', encrypt(1))
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'No Record Found']);
            }
            $id               = checkDecrypt($id);
            $common['title']  = 'Edit Yacht Page';
            $common['button'] = 'Update';

            $get_slider_images              = PageSliders::where(['page_id'=> $id ,'page' => 'yacht_page'])->get();
            $get_slider_images_language     = PageSlidersLanguage::where(['page_id'=> $id,'page' => 'yacht_page'])->get();
            $MetaGlobalSideBanner           = MetaGlobalLanguage::where('meta_title', 'yacht_side_banner')->first();
            
        }

        return view('admin.yacht_page.yacht_page', compact('common','get_slider_images','LSI','get_slider_images_language','lang_id','MetaGlobalSideBanner'));
    }


    // Blog 
    public function add_blog_page(Request $request, $id = '')
    {
        $common = [];
        Session::put('TopMenu', 'Pages');
        Session::put('SubMenu', 'Blog page');

        $common['title']                    = translate('Blog page');
        $common['button']                   = translate('Save');

        $get_slider_images_language         = [];
        $get_slider_images                  = [];
        $LSI                                = getTableColumn('pages_slider'); 


        $get_blog_page_featured             = [];
        $get_blog_page_featured_language    = [];
        $BPF = getTableColumn('blog_page_featured');


        $languages   = Language::where(ConditionQuery())->get();

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];
        $get_languages = Language::where(['status'=>'Active','is_delete' => 0])->get();

        if ($request->isMethod('post')) {

            $message      = translate('Update Successfully');
            $status       = 'success';

            
            // Slider Images-------------------------------------------------------
            
            $get_pageSlider = PageSliders::where(['page'=>'blog_page'])->get();
            foreach ($get_pageSlider as $key => $val) {
                if (!in_array($val['id'], $request->blog_id)) {
                    PageSliders::where('id', $val['id'])->delete();
                }
            }
            if (!empty($request->slider_title)) {
                if ($request->slider_title) {

                    PageSlidersLanguage::where(['page_id' => 1,'page'=>'blog_page'])->where('language_id',$lang_id)->delete();

                    foreach ($request->blog_id as $key => $over_value) {
                
                        if($over_value !=''){
                            $PageSliders       = PageSliders::find($over_value);
                        }else{
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
                                $PageSliders->page     = "blog_page";
                            }
                        }

                        $PageSliders->save();
                        $page_slider_id = $PageSliders->id;

                        foreach ($get_languages as $lang_key => $value) {
                            if (!getDataFromDB('pages_slider_language',['language_id'=>$value['id'],'pages_slider_id' => $page_slider_id,'page'=> 'blog_page' ],'row')) {
                                $PageSlidersLanguage = new PageSlidersLanguage();
                                $PageSlidersLanguage['page_id']            = 1;
                                $PageSlidersLanguage['pages_slider_id']    = $page_slider_id;
                                $PageSlidersLanguage['page']               = 'blog_page';
                                $PageSlidersLanguage['language_id']        = $value['id'];
                                $PageSlidersLanguage['title']              = isset($request->slider_title[$value['id']][$key]) ?  $request->slider_title[$value['id']][$key] : $request->slider_title[$lang_id][$key];
                                $PageSlidersLanguage['description']        = isset($request->slider_description[$value['id']][$key]) ?  $request->slider_description[$value['id']][$key] : $request->slider_description[$lang_id][$key];
                                $PageSlidersLanguage->save();
                            }
                        }


                    }
                }
            }

            //Blogpagefeatured
            $get_Blogfeatured = Blogpagefeatured::where('blog_id', 1)->get();
            foreach ($get_Blogfeatured as $key => $get_delete) {
                if (!in_array($get_delete['id'], $request->featured_id)) {
                    Blogpagefeatured::where('id', $get_delete['id'])->delete();
                }
            }

            // Facilities
            if ($request->featured_title) {
                // Blogpagefeatured::where(["blog_id" => 1])->delete();
                BlogpagefeaturedLanguage::where(['blog_id' => 1])->where('language_id',$lang_id)->delete();

                foreach ($request->featured_id as $key => $value_7) {
                    if ($value_7 != '') {
                        $Blogpagefeatured = Blogpagefeatured::find($value_7);
                    } else {
                        $Blogpagefeatured = new Blogpagefeatured();
                    }

                    $Blogpagefeatured['blog_id'] = 1;
                    $Blogpagefeatured['featured_location'] = $request->featured_location[$key];
                    $Blogpagefeatured['featured_link']     = $request->featured_link[$key];

                    if ($request->hasFile('blog_featured_image')) {
                        if (isset($request->blog_featured_image[$key])) {
                            $files = $request->file('blog_featured_image')[$key];

                            $random_no = uniqid();
                            $img = $files;
                            $ext = $files->getClientOriginalExtension();
                            $new_name = $random_no . time() . '.' . $ext;
                            $destinationPath = public_path('uploads/BlogPage');
                            $img->move($destinationPath, $new_name);
                            $Blogpagefeatured['blog_featured_image'] = $new_name;
                        }
                    }
                    $Blogpagefeatured->save();


                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('blog_page_featured_language',['language_id'=>$value['id'],'blog_featured_id' => $Blogpagefeatured->id,'blog_id'=> 1 ],'row')) { 
                            $BlogpagefeaturedLanguage = new BlogpagefeaturedLanguage();
                            $BlogpagefeaturedLanguage['blog_id']          = 1;
                            $BlogpagefeaturedLanguage['language_id']      = $value['id'];
                            $BlogpagefeaturedLanguage['blog_featured_id'] = $Blogpagefeatured->id;
                            $BlogpagefeaturedLanguage['featured_title']   = isset($request->featured_title[$value['id']][$key]) ?  $request->featured_title[$value['id']][$key] : $request->featured_title[$lang_id][$key];
                            $BlogpagefeaturedLanguage->save();
                        }
                    }
                }
            }

            return redirect()
                ->route('admin.blog_page.edit', encrypt(1))
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'No Record Found']);
            }
            $id               = checkDecrypt($id);
            $common['title']  = 'Edit Blog page';
            $common['button'] = 'Update';

            $get_slider_images           = PageSliders::where(['page' => 'blog_page'])->get();
            $get_slider_images_language  = PageSlidersLanguage::where(['page' => 'blog_page'])->get();

            $get_blog_page_featured = Blogpagefeatured::where('blog_id', 1)->get();
            $get_blog_page_featured_language = BlogpagefeaturedLanguage::where('blog_id', 1)->get();
            
        }

        return view('admin.blog_page.blog_page', compact('common','get_slider_images','LSI','get_slider_images_language','get_blog_page_featured','get_blog_page_featured_language','BPF','lang_id'));
    }
}
