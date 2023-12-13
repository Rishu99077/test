<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CityGuide;
use App\Models\CityGuideLanguage;

use App\Models\Language;

use App\Models\CityGuideHighlight;
use App\Models\CityGuideHighlightLanguage;

use App\Models\CityGuidefaq;
use App\Models\CityGuidefaqLanguage;

use App\Models\PageSliders;
use App\Models\PageSlidersLanguage;
use App\Models\Country;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Str;

class CityGuideController extends Controller
{
    // CityGuide
    public function index()
    {
        $common          = array();
        $common['title'] = "City Guide List";
        Session::put("TopMenu", "City Guide List");
        Session::put("SubMenu", "City Guide List");

        $get_session_language     = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id                  = $get_session_language['id'];

        $get_city_guide = CityGuide::select('city_guide.*', 'city_guide_language.title')
                            ->leftjoin("city_guide_language", 'city_guide.id', '=', 'city_guide_language.city_guide_id')
                            ->where(['city_guide.is_delete' => 0])
                            ->orderBy('city_guide.sort_order', 'asc')
                            ->groupBy('city_guide.id')
                            ->paginate(config('adminconfig.records_per_page'));             

        return view('admin.City_guide.index', compact('common', 'get_city_guide','lang_id'));
    }

    ///Add CityGuide
    public function add_city_guide(Request $request, $id = '')
    {
        $common = [];
        Session::put('TopMenu', 'City Guide List');
        Session::put('SubMenu', 'City Guide List');

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $common['title'] = translate('Add City Guide List');
        $common['button'] = translate('Save');

        $get_city_guide = getTableColumn('city_guide');
        $get_city_guide_language = '';

        $languages = Language::where(ConditionQuery())->get();

        $get_city_guide_slider_image = [];

        $get_slider_images              = [];
        $get_slider_images_language     = [];
        $LSI                = getTableColumn('pages_slider');

        $get_city_highlights            = [];
        $get_city_highlights_language   = [];
        $HHL                   = getTableColumn('city_guide_highlight');

        $get_city_faqs            = [];
        $get_city_faqs_language   = [];
        $CGF                   = getTableColumn('city_guide_faq');
        $country                 = Country::all();
        if ($request->isMethod('post')) {

            $req_fields = [];
            $req_fields['title.*'] = 'required';
            $req_fields['country']             = 'required';
            $req_fields['state']               = 'required';
            $req_fields['city']                = 'required';

            $errormsg = [
                'title.*' => translate('Title'),
                'country' => translate('Country'),
                'state' => translate('State'),
                'city' => translate('City'),
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
                $message   = translate('Update Successfully');
                $status    = 'success';
                $CityGuide = CityGuide::find($request->id);
                CityGuideLanguage::where('city_guide_id', $request->id)->where('language_id',$lang_id)->delete();
                $slug = createSlug('city_guide', $request->title[$lang_id], $request->id);
            } else {
                $message = translate('Add Successfully');
                $status = 'success';
                $CityGuide = new CityGuide();

                $slug = createSlug('city_guide', $request->title[$lang_id]);
            }

            // $CityGuide['status']      = isset($request->status)  ? "Active" : "Deactive";
            $CityGuide['slug']              = $slug;
            $CityGuide['video_url']         = $request->video_url;
            $CityGuide['google_address']    = $request->google_address;
            $CityGuide['address_lattitude'] = $request->address_lattitude;
            $CityGuide['address_longitude'] = $request->address_longitude;
            $CityGuide['city']              = $request->city;
            $CityGuide['country']           = $request->country;
            $CityGuide['state']             = $request->state;
            $CityGuide['link']              = $request->link;
            $CityGuide['button_link']       = $request->button_link;
            $CityGuide['sort_order']        = $request->sort_order;

            $CityGuide['status']              = isset($request->status) ? 'Active' : 'Deactive';

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
                $CityGuide['image'] = $newImage;
            }

            if ($request->hasFile('bottom_image')) {
                $image                  = $request->file('bottom_image');
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
                $CityGuide['bottom_image'] = $newImage;
            }

            if ($request->hasFile('side_banner_image')) {
                $image                  = $request->file('side_banner_image');
                $random_no              = Str::random(5);
                $newImage               = time() . $random_no . '.' . $image->getClientOriginalExtension();
                $destinationPath        = public_path('uploads/MediaPage');
                $imgFile                = Image::make($image->path());
                $height                 = $imgFile->height();
                $width                  = $imgFile->width();
                // if ($width > 600) {
                //     $imgFile->resize(792, 450, function ($constraint) {
                //         $constraint->aspectRatio();
                //     });
                // }
                // if ($height > 600) {
                //     $imgFile->resize(792, 450, function ($constraint) {
                //         $constraint->aspectRatio();
                //     });
                // }
                $destinationPath = public_path('uploads/MediaPage');
                $imgFile->save($destinationPath . '/' . $newImage);
                $CityGuide['side_banner'] = $newImage;
            }

            if ($request->hasFile('video_thumbnail')) {
                $image                  = $request->file('video_thumbnail');
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
                $CityGuide['video_thumbnail'] = $newImage;
            }

            $CityGuide->save();

            $city_guide_id = $CityGuide->id;

            $get_languages = Language::where(['status'=>'Active','is_delete'=>0])->get();

            if (!empty($get_languages)) {
                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('city_guide_language',['language_id'=>$value['id'],'city_guide_id'=>$request->id],'row')) {
                        $CityGuideLanguage = new CityGuideLanguage();
                   
                        $CityGuideLanguage->button_text          = isset($request->button_text[$value['id']]) ?  $request->button_text[$value['id']] : $request->button_text[$lang_id];
                        $CityGuideLanguage->title                = isset($request->title[$value['id']]) ?  $request->title[$value['id']] : $request->title[$lang_id];
                        $CityGuideLanguage->description          = isset($request->description[$value['id']]) ? change_str($request->description[$value['id']]) : $request->description[$lang_id]; 
                        $CityGuideLanguage->location_heading     = isset($request->location_heading[$value['id']]) ?  $request->location_heading[$value['id']] : $request->location_heading[$lang_id];
                        $CityGuideLanguage->location_description = isset($request->location_description[$value['id']]) ? change_str($request->location_description[$value['id']]) : $request->location_description[$lang_id]; 
                        $CityGuideLanguage->faq_heading          = isset($request->faq_heading[$value['id']]) ?  $request->faq_heading[$value['id']] : $request->faq_heading[$lang_id];
                        $CityGuideLanguage->language_id     = $value['id'];
                        $CityGuideLanguage->city_guide_id   = $CityGuide->id;
                        $CityGuideLanguage->save();
                    }
                }
            }

            // Slider Images
            $get_pageSlider = PageSliders::where(['page_id' => $city_guide_id, 'page' => 'city_guide'])->get();
            foreach ($get_pageSlider as $key => $val) {
                if (!in_array($val['id'], $request->over_view_id)) {
                    PageSliders::where('id', $val['id'])->delete();
                }
            }
            if (!empty($request->slider_title)) {
                if ($request->slider_title) {

                    PageSlidersLanguage::where(['page_id' => $city_guide_id, 'page' => 'city_guide'])->where('language_id',$lang_id)->delete();

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
                            }
                            $PageSliders->page_id  = $city_guide_id;
                            $PageSliders->page     = "city_guide";
                        }
                        $PageSliders->save();
                        $page_slider_id = $PageSliders->id;

                        foreach ($get_languages as $lang_key => $value) {
                            if (!getDataFromDB('pages_slider_language',['language_id'=>$value['id'],'page_id' => $city_guide_id,'page'=> 'city_guide','pages_slider_id' => $page_slider_id],'row')) {

                                $PageSlidersLanguage = new PageSlidersLanguage();
                                $PageSlidersLanguage['page_id']            = $city_guide_id;
                                $PageSlidersLanguage['pages_slider_id']    = $page_slider_id;
                                $PageSlidersLanguage['page']               = 'city_guide';
                                $PageSlidersLanguage['language_id']        = $value['id'];
                                $PageSlidersLanguage['title']              = isset($request->slider_title[$value['id']][$key]) ?  $request->slider_title[$value['id']][$key] : $request->slider_title[$lang_id][$key];
                                $PageSlidersLanguage['description']        = isset($request->slider_description[$value['id']][$key]) ?  $request->slider_description[$value['id']][$key] : $request->slider_description[$lang_id][$key]; 
                                $PageSlidersLanguage->save();
                            }
                        }
                    }
                }
            }



            // City Guide Highlights
            $CityGuideHighlight = CityGuideHighlight::where('city_guide_id', $city_guide_id)->get();
            foreach ($CityGuideHighlight as $key => $CityHighlight_delete) {
                if (!in_array($CityHighlight_delete['id'], $request->highlight_id)) {
                    CityGuideHighlight::where('id', $CityHighlight_delete['id'])->delete();
                }
            }

            CityGuideHighlightLanguage::where('city_guide_id', $city_guide_id)->where('language_id',$lang_id)->delete();
            if (isset($request->highlight_title)) {
                foreach ($request->highlight_id as $key => $value_choose) {

                    if ($value_choose != '') {
                        $CityGuideHighlight = CityGuideHighlight::find($value_choose);
                    } else {
                        $CityGuideHighlight = new CityGuideHighlight();
                    }

                    $CityGuideHighlight->city_guide_id = $city_guide_id;
                    $CityGuideHighlight->save();

                        
                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('city_guide_highlight_language',['language_id'=>$value['id'],'city_guide_id' => $city_guide_id,'highlight_id'=> $CityGuideHighlight->id ],'row')) {          

                            $CityGuideHighlightLanguage = new CityGuideHighlightLanguage();
                            $CityGuideHighlightLanguage['city_guide_id']   = $city_guide_id;
                            $CityGuideHighlightLanguage['highlight_id']    = $CityGuideHighlight->id;
                            $CityGuideHighlightLanguage['language_id']     = $value['id'];
                            $CityGuideHighlightLanguage['title']           = isset($request->highlight_title[$value['id']][$key]) ?  $request->highlight_title[$value['id']][$key] : $request->highlight_title[$lang_id][$key];
                            $CityGuideHighlightLanguage['description']     = isset($request->highlight_description[$value['id']][$key]) ? change_str($request->highlight_description[$value['id']][$key]) : $request->highlight_description[$lang_id][$key];

                            $CityGuideHighlightLanguage->save();
                        }
                    }
                }
            }



            // City Guide FAQS
            $CityGuidefaq = CityGuidefaq::where('city_guide_id', $city_guide_id)->get();
            foreach ($CityGuidefaq as $key => $CityHighlight_delete) {
                if (!in_array($CityHighlight_delete['id'], $request->faq_id)) {
                    CityGuidefaq::where('id', $CityHighlight_delete['id'])->delete();
                }
            }

            CityGuidefaqLanguage::where('city_guide_id', $city_guide_id)->where('language_id',$lang_id)->delete();
            if ($request->faq_title) {
                foreach ($request->faq_id as $key => $value_choose) {

                    if ($value_choose != '') {
                        $CityGuidefaq = CityGuidefaq::find($value_choose);
                    } else {
                        $CityGuidefaq = new CityGuidefaq();
                    }

                    $CityGuidefaq->city_guide_id = $city_guide_id;
                    $CityGuidefaq->save();

                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('city_guide_faq_language',['language_id'=>$value['id'],'city_guide_id' => $city_guide_id,'faq_id'=> $CityGuidefaq->id ],'row')) { 

                            $CityGuidefaqLanguage = new CityGuidefaqLanguage();
                            $CityGuidefaqLanguage['city_guide_id']   = $city_guide_id;
                            $CityGuidefaqLanguage['faq_id']          = $CityGuidefaq->id;
                            $CityGuidefaqLanguage['language_id']     = $value['id'];
                            $CityGuidefaqLanguage['title']           = isset($request->faq_title[$value['id']][$key]) ?  $request->faq_title[$value['id']][$key] : $request->faq_title[$lang_id][$key]; 
                            $CityGuidefaqLanguage['description']     = isset($request->faq_description[$value['id']][$key]) ?  $request->faq_description[$value['id']][$key] : $request->faq_description[$lang_id][$key];
                            
                            $CityGuidefaqLanguage->save();
                        }
                    }
                }
            }

            return redirect()
                ->route('admin.city_guide')
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

            $get_city_guide = CityGuide::where('id', $id)->first();
            $get_city_guide_language = CityGuideLanguage::where('city_guide_id', $id)->get();

            $get_slider_images           = PageSliders::where(['page_id' => $id, 'page' => 'city_guide'])->get();
            $get_slider_images_language  = PageSlidersLanguage::where(['page_id' => $id, 'page' => 'city_guide'])->get();

            $get_city_highlights          = CityGuideHighlight::where('city_guide_id', $id)->get();
            $get_city_highlights_language = CityGuideHighlightLanguage::where('city_guide_id', $id)->get();


            $get_city_faqs          = CityGuidefaq::where('city_guide_id', $id)->get();
            $get_city_faqs_language = CityGuidefaqLanguage::where('city_guide_id', $id)->get();

            if (!$get_city_guide) {
                return back()->withErrors(['error' => 'Something went wrong']);
            }
        }
        return view('admin.City_guide.add_city_guide', compact('common', 'country', 'get_city_guide', 'languages', 'get_city_guide_language', 'get_city_guide_slider_image', 'get_slider_images', 'get_slider_images_language', 'LSI', 'get_city_highlights', 'get_city_highlights_language', 'HHL', 'get_city_faqs', 'get_city_faqs_language', 'CGF','lang_id'));
    }

    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_city_guide =  CityGuide::find($id);
        if ($get_city_guide) {
            $get_city_guide->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }


    // Duplicate Product 
    public function duplicate($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'No Record Found']);
        }
        $id = checkDecrypt($id);
        $status = 'error';
        $message = translate('Something went wrong!');

        $get_city_guide = CityGuide::find($id);
        if ($get_city_guide) {
            $get_city_guide         = $get_city_guide->replicate();
            $get_city_guide->slug   = createSlug('city_guide', $get_city_guide->slug);
            $get_city_guide->status = 'Deactive';
            $get_city_guide->save();

            $NewId = $get_city_guide->id;

          
            // city guide language
            $CityGuideLanguage = CityGuideLanguage::where('city_guide_id', $id)->get();
            $CityGuideLanguage->each(function ($item, $key) use ($NewId) {
                $Language             = $item->replicate();
                $Language->city_guide_id = $NewId;
                $Language->save();
            });

           
            // Product ProductAddtionalInfo 
            $PageSliders = PageSliders::where(['page_id' => $id,'page'=>'city_guide'])->get();
            $PageSliders->each(function ($item, $key) use ($NewId, $id) {
                $PagesSliders             = $item->replicate();
                $PagesSliders->page_id = $NewId;
                $PagesSliders->save();

                $PageSlidersLanguage = PageSlidersLanguage::where(['page_id' => $id, 'page' => 'city_guide'])->get();
                $PageSlidersLanguage->each(function ($item, $key) use ($NewId, $PagesSliders) {
                    $HighlightLanguage               = $item->replicate();
                    $HighlightLanguage->page_id   = $NewId;
                    $HighlightLanguage->pages_slider_id = $PagesSliders->id;
                    $HighlightLanguage->save();
                });
            });

            $CityGuidefaq = CityGuidefaq::where(['city_guide_id' => $id])->get();
            $CityGuidefaq->each(function ($item, $key) use ($NewId, $id) {
                $Faqs             = $item->replicate();
                $Faqs->city_guide_id = $NewId;
                $Faqs->save();

                $CityGuidefaqLanguage = CityGuidefaqLanguage::where(['city_guide_id' => $id, 'faq_id' => $item->id])->get();
                $CityGuidefaqLanguage->each(function ($item, $key) use ($NewId, $Faqs) {
                    $FaqLanguage                = $item->replicate();
                    $FaqLanguage->city_guide_id = $NewId;
                    $FaqLanguage->faq_id        = $Faqs->id;
                    $FaqLanguage->save();
                });
            });


            // Product CityGuideHighlight 
            $CityGuideHighlight = CityGuideHighlight::where(['city_guide_id' => $id])->get();
            $CityGuideHighlight->each(function ($item, $key) use ($NewId, $id) {
                $CityGuideHigh             = $item->replicate();
                $CityGuideHigh->city_guide_id = $NewId;
                $CityGuideHigh->save();

                $CityGuideHighlightLanguage = CityGuideHighlightLanguage::where(['city_guide_id' => $id, 'highlight_id' => $item->id])->get();
                $CityGuideHighlightLanguage->each(function ($item, $key) use ($NewId, $CityGuideHigh) {
                    $SiteAdvertisementLanguage                  = $item->replicate();
                    $SiteAdvertisementLanguage->city_guide_id   = $NewId;
                    $SiteAdvertisementLanguage->highlight_id    = $CityGuideHigh->id;
                    $SiteAdvertisementLanguage->save();
                });
            });
            $status = 'success';
            $message = translate('City guide Duplicate Succssfully...');
        }
        return redirect()
                ->back()
                ->withErrors([$status => $message]);
    }




}
