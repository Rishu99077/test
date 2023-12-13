<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaPage;
use App\Models\MediaPageLanguage;
use App\Models\MediaPageSliderImage;
use App\Models\MediaPageArticle;
use App\Models\MediaPageArticleLanguage;
use App\Models\Language;
use App\Models\MediaMensionSocial;
use App\Models\MediaMensionSocialLanguage;
use App\Models\PageSliders;
use App\Models\PageSlidersLanguage;

use App\Models\MediaBlog;
use App\Models\MediaBlogLanguage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Str;

class MediaPageController extends Controller
{

    ///Add MediaPage
    public function add_media_mension_page(Request $request, $id = '')
    {
        $common = [];
        Session::put('TopMenu', 'Pages');
        Session::put('SubMenu', 'Media Mensions Page');

        $common['title']                     = translate('Add Media Mensions Page');
        $common['button']                    = translate('Save');
        $get_media_mension_page              = getTableColumn('media_mension_page');
        $get_media_mension_page_language     = '';
        $languages                           = Language::where(ConditionQuery())->get();

        $get_media_mension_page_slider_image = [];
        $get_media_page_article              = [];
        $get_medial_social                   = [];
        $get_medial_social_language          = [];
        $GPF                                 = getTableColumn('media_mension_page_article');
        $media_mension_social                = getTableColumn('media_mension_social');

        $get_media_blog                      = [];
        $get_media_blog_language             = [];
        $MBD                                 = getTableColumn('media_blog');

        $get_slider_images              = [];
        $get_slider_images_language     = [];
        $LSI                = getTableColumn('pages_slider');

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];
        $get_languages = Language::where(['status'=>'Active','is_delete' => 0])->get();

        if ($request->isMethod('post')) {
            //   echo "<pre>"; 
            // print_r($request->all());
            // echo "</pre>";die();
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
                $message = translate('Update Successfully');
                $status = 'success';
                $MediaPage = MediaPage::find($request->id);
                MediaPageLanguage::where('media_mension_id', $request->id)->where('language_id',$lang_id)->delete();

                if (isset($request->article_id)) {
                    $get_media_article = MediaPageArticle::where('media_mension_id', $request->id)->get();
                    foreach ($get_media_article as $key => $get_productoptions_delete) {
                        if (!in_array($get_productoptions_delete['id'], $request->article_id)) {
                            MediaPageArticle::where('id', $get_productoptions_delete['id'])->delete();
                        }
                    }
                }


                if (isset($request->social_id)) {
                    $get_media_socail = MediaMensionSocial::where('media_mension_id', $request->id)->get();
                    foreach ($get_media_socail as $key => $get_medi_soc_delete) {
                        if (!in_array($get_medi_soc_delete['id'], $request->social_id)) {
                            MediaMensionSocial::where('id', $get_medi_soc_delete['id'])->delete();
                        }
                    }
                }
            } else {
                $message = translate('Add Successfully');
                $status = 'success';
                $MediaPage = new MediaPage();
            }


            if ($request->hasFile('file')) {
                $image = $request->file('file');
                $random_no = Str::random(5);
                $newImage = time() . $random_no . '.' . $image->getClientOriginalExtension();

                $destinationPath = public_path('uploads/MediaPage');
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

                $destinationPath = public_path('uploads/MediaPage');
                $imgFile->save($destinationPath . '/' . $newImage);
                $MediaPage['image'] = $newImage;
            }
            $MediaPage->save();
            $media_mension_id = $MediaPage->id;

            if (!empty($request->article_heading_title)) {

                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('media_mension_page_language',['language_id'=>$value['id'],'media_mension_id'=>$MediaPage->id],'row')) {    
                        $MediaPageLanguage = new MediaPageLanguage();
                        $MediaPageLanguage->article_heading_title = isset($request->article_heading_title[$value['id']]) ?  $request->article_heading_title[$value['id']] : $request->article_heading_title[$lang_id];
                        $MediaPageLanguage->blog_heading_title    = isset($request->blog_heading_title[$value['id']]) ?  $request->blog_heading_title[$value['id']] : $request->blog_heading_title[$lang_id];
                        $MediaPageLanguage->language_id           = $value['id'];
                        $MediaPageLanguage->media_mension_id      = $MediaPage->id;
                        $MediaPageLanguage->save();
                    }
                }

            }

            // Slider Images
            $get_pageSlider = PageSliders::where(['page' => 'media_page'])->get();
            foreach ($get_pageSlider as $key => $val) {
                if (!in_array($val['id'], $request->over_view_id)) {
                    PageSliders::where('id', $val['id'])->delete();
                }
            }
            if (!empty($request->slider_title)) {
                if ($request->slider_title) {

                    PageSlidersLanguage::where(['page_id' => 1, 'page' => 'media_page'])->where('language_id',$lang_id)->delete();

                    foreach ($request->over_view_id as $key => $over_value) {

                        if ($over_value != '') {
                            $PageSliders       = PageSliders::find($over_value);
                        } else {
                            $PageSliders       = new PageSliders();
                        }

                        $PageSliders->page_id  = 1;
                        $PageSliders->page     = "media_page";

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
                            if (!getDataFromDB('pages_slider_language',['language_id'=>$value['id'],'pages_slider_id' => $page_slider_id,'page'=> 'media_page' ],'row')) {          
                                $PageSlidersLanguage = new PageSlidersLanguage();
                                $PageSlidersLanguage['page_id']            = 1;
                                $PageSlidersLanguage['pages_slider_id']    = $page_slider_id;
                                $PageSlidersLanguage['page']               = 'media_page';
                                $PageSlidersLanguage['language_id']        = $value['id'];
                                $PageSlidersLanguage['title']              = isset($request->slider_title[$value['id']][$key]) ?  $request->slider_title[$value['id']][$key] : $request->slider_title[$lang_id][$key];
                                $PageSlidersLanguage['description']        = isset($request->slider_description[$value['id']][$key]) ?  $request->slider_description[$value['id']][$key] : $request->slider_description[$lang_id][$key];
                                $PageSlidersLanguage->save();
                            }
                        }
                    }
                }
            }

            // Article
            if ($request->article_title) {
                MediaPageArticleLanguage::where(['media_mension_id' => 1])->where('language_id',$lang_id)->delete();

                foreach ($request->article_id as $key => $value_7) {
                    if ($value_7 != '') {
                        $MediaPageArticle = MediaPageArticle::find($value_7);
                    } else {
                        $MediaPageArticle = new MediaPageArticle();
                    }

                    $MediaPageArticle['media_mension_id'] = 1;
                    $MediaPageArticle['city'] = $request->city[$key];

                    $MediaPageArticle->save();

                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('media_mension_page_article_language',['language_id'=>$value['id'],'media_mension_id' => 1,'media_mension_article_id'=> $MediaPageArticle->id ],'row')) {    
                            $MediaPageArticleLanguage                             = new MediaPageArticleLanguage();
                            $MediaPageArticleLanguage['media_mension_id']         = 1;
                            $MediaPageArticleLanguage['language_id']              = $value['id'];
                            $MediaPageArticleLanguage['media_mension_article_id'] = $MediaPageArticle->id;
                            $MediaPageArticleLanguage['article_title']            = isset($request->article_title[$value['id']][$key]) ?  $request->article_title[$value['id']][$key] : $request->article_title[$lang_id][$key];
                            $MediaPageArticleLanguage['article_description']      = isset($request->article_description[$value['id']][$key]) ?  $request->article_description[$value['id']][$key] : $request->article_description[$lang_id][$key];   
                            $MediaPageArticleLanguage->save();
                        }
                    }
                }
            }

            //Social icons
            if ($request->social_id) {
                // MediaMensionSocial::where(['media_mension_id' => 1])->delete();
                MediaMensionSocialLanguage::where(['media_mension_id' => 1])->where('language_id',$lang_id)->delete();

                foreach ($request->social_id as $social_id_key => $social_id_value) {
                    if ($social_id_value != '') {
                        $MediaMensionSocial = MediaMensionSocial::find($social_id_value);
                    } else {
                        $MediaMensionSocial = new MediaMensionSocial();
                    }

                    $MediaMensionSocial['media_mension_id'] = 1;
                    $MediaMensionSocial['link']   = $request->link[$social_id_key];
                    $MediaMensionSocial['status'] = isset($request->status[$social_id_key]) ?  $request->status[$social_id_key] : "Deactive";

                    if ($request->hasFile('icons')) {
                        if (isset($request->icons[$social_id_key])) {
                            $random_no                         = uniqid();
                            $img                                = $request->icons[$social_id_key];
                            $ext                                = $img->getClientOriginalExtension();
                            $new_name                            = time() . $random_no . '.' . $ext;
                            $destinationPath                   =  public_path('uploads/MediaPage/media_mension_slider');
                            $img->move($destinationPath, $new_name);
                            $MediaMensionSocial['image']      = $new_name;
                        }
                    }
                    $MediaMensionSocial->save();

                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('media_mension_social_language',['language_id'=>$value['id'],'media_mension_id' => 1,'social_id'=> $MediaMensionSocial->id ],'row')) {       
                            $MediaPageArticleLanguage                             = new MediaMensionSocialLanguage();
                            $MediaPageArticleLanguage['media_mension_id']         = 1;
                            $MediaPageArticleLanguage['language_id']              = $value['id'];
                            $MediaPageArticleLanguage['social_id']                = $MediaMensionSocial->id;
                            $MediaPageArticleLanguage['title']                    = isset($request->social_title[$value['id']][$social_id_key]) ?  $request->social_title[$value['id']][$social_id_key] : $request->social_title[$lang_id][$social_id_key];
                            $MediaPageArticleLanguage->save();
                        }
                    }
                }
            }


            // BLOGGGS--------------------

            if (isset($request->media_blog_id)) {
                $get_media_blog_d = MediaBlog::where(['media_mension_id' => 1])->get();
                foreach ($get_media_blog_d as $key => $val) {
                    if (!in_array($val['id'], $request->media_blog_id)) {
                        MediaBlog::where('id', $val['id'])->delete();
                    }
                }
            }

            if ($request->article_title) {
                MediaBlogLanguage::where(['media_mension_id' => 1])->where('language_id',$lang_id)->delete();

                foreach ($request->media_blog_id as $key => $value_8) {
                    if ($value_8 != '') {
                        $MediaBlog = MediaBlog::find($value_8);
                    } else {
                        $MediaBlog = new MediaBlog();
                    }

                    $MediaBlog['media_mension_id'] = 1;

                    if ($request->hasFile('media_image')) {
                        if (isset($request->media_image[$key])) {
                            $random_no                        = uniqid();
                            $img                              = $request->media_image[$key];
                            $ext                              = $img->getClientOriginalExtension();
                            $new_name                         = time() . $random_no . '.' . $ext;
                            $destinationPath                  =  public_path('uploads/MediaBlog/');
                            $img->move($destinationPath, $new_name);
                            $MediaBlog['media_image']      = $new_name;
                        }
                    }

                    // if ($request->hasFile('media_video')) {
                    //     if (isset($request->media_video[$key])){
                    //         $random_no                        = uniqid();
                    //         $img                              = $request->media_video[$key];
                    //         $ext                              = $img->getClientOriginalExtension();
                    //         $new_name                         = time().$random_no . '.' . $ext;
                    //         $destinationPath                  =  public_path('uploads/MediaBlog/');
                    //         $img->move($destinationPath, $new_name);
                    //         $MediaBlog['media_video']      = $new_name;
                    //     }
                    // }   
                    $MediaBlog['media_video']      = $request->media_video[$key];
                    $MediaBlog['added_by']  = 'Admin';
                    $MediaBlog['status']    =  "Active";

                    $MediaBlog->save();


                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('media_blog_language',['language_id'=>$value['id'],'media_mension_id' => 1,'media_blog_id'=> $MediaBlog->id ],'row')) {      
                            $MediaBlogLanguage                             = new MediaBlogLanguage();
                            $MediaBlogLanguage['media_mension_id']         = 1;
                            $MediaBlogLanguage['media_blog_id']            = $MediaBlog->id;
                            $MediaBlogLanguage['language_id']              = $value['id'];
                            $MediaBlogLanguage['description']              = isset($request->blog_description[$value['id']][$key]) ?  $request->blog_description[$value['id']][$key] : $request->blog_description[$lang_id][$key];   
                            $MediaBlogLanguage->save();
                        }
                    }
                }
            }

            return redirect()
                ->route('admin.media_mension_page.edit', encrypt(1))
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'No Record Found']);
            }
            $id = checkDecrypt($id);
            $common['title'] = 'Edit Media Mensions Page';
            $common['button'] = 'Update';

            $get_media_mension_page = MediaPage::where('id', $id)->first();
            $get_media_mension_page_language = MediaPageLanguage::where('media_mension_id', $id)->get();
            // $get_media_mension_page_slider_image = MediaPageSliderImage::where('media_mension_id', $id)->get();

            $get_media_page_article = MediaPageArticle::where('media_mension_id', $id)->get();
            $get_media_page_article_language = MediaPageArticleLanguage::where('media_mension_id', $id)->get();

            $get_medial_social = MediaMensionSocial::where('media_mension_id', $id)->get();
            $get_medial_social_language = MediaMensionSocialLanguage::where('media_mension_id', $id)->get();

            $get_slider_images           = PageSliders::where(['page_id' => $id, 'page' => 'media_page'])->get();
            $get_slider_images_language  = PageSlidersLanguage::where(['page_id' => $id, 'page' => 'media_page'])->get();

            $get_media_blog = MediaBlog::where('media_mension_id', $id)->get();
            $get_media_blog_language = MediaBlogLanguage::where('media_mension_id', $id)->get();

            if (!$get_media_mension_page) {
                return back()->withErrors(['error' => 'Something went wrong']);
            }
        }

        return view('admin.media_mension_page.add_mediamension_page', compact('common', 'get_media_mension_page', 'languages', 'get_media_mension_page_language', 'get_media_mension_page_slider_image', 'get_media_page_article', 'get_media_page_article_language', 'GPF', 'get_medial_social', 'get_medial_social_language', 'media_mension_social', 'get_slider_images', 'get_slider_images_language', 'LSI', 'get_media_blog', 'get_media_blog_language', 'MBD','lang_id'));
    }


}
