<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonials;
use App\Models\TestimonialsLanguage;
use App\Models\Language;
use App\Models\MetaGlobalLanguage;
use App\Models\BannerOverview;
use App\Models\BannerOverviewLanguage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Str;

class TestimonialsController extends Controller
{
    public function index()
    {
        $common = [];
        $common['title'] = 'Testimonials';
        Session::put('TopMenu', 'Contents');
        Session::put('SubMenu', 'Testimonials');

        $get_testimonial = Testimonials::select('testimonials.*', 'testimonials_language.description')
            ->orderBy('testimonials.id', 'desc')
            ->where(['testimonials.is_delete' => 0])
            ->join('testimonials_language', 'testimonials.id', '=', 'testimonials_language.testimonials_id')
            ->groupBy('testimonials.id')
            ->paginate(config('adminconfig.records_per_page'));

        return view('admin.testimonials.index', compact('common', 'get_testimonial'));
    }

    ///Add Testimonials
    public function addTestimonials(Request $request, $id = '')
    {
        $common = [];
        Session::put('TopMenu', 'Contents');
        Session::put('SubMenu', 'Testimonials');

        $common['title']          = translate('Add Testimonials');
        $common['button']         = translate('Save');
        $get_testimonial          = getTableColumn('testimonials');
        $get_testimonial_language = [];
        $languages                = Language::where(ConditionQuery())->get();

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];
        $get_languages = Language::where(['status'=>'Active','is_delete' => 0])->get();

        if ($request->isMethod('post')) {
            $req_fields = [];
            $req_fields['name.*'] = 'required';
            $req_fields['designation.*'] = 'required';
            $req_fields['description.*'] = 'required';

            $errormsg = [
                'name' => translate('Title'),
                'designation' => translate('Designation'),
                'description.*' => translate('Description'),
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

            // print_die($request->all());
            //Testimonial Add
            if (isset($request->id)) {
                if (is_array($request->id)) {
                    $TestimonialsDelete         = Testimonials::whereNotIn('id', $request->id)->delete();
                    $TestimonialsLanguageDelete = TestimonialsLanguage::orderby('id', 'desc')->where('language_id',$lang_id)->delete();
                    $MetaGlobalLanguagedelete   = MetaGlobalLanguage::where('meta_parent', 'testimonial')
                        ->where('meta_title', 'testimonial_heading_title')->where('language_id',$lang_id)
                        ->delete();
                    foreach ($request->id as $key => $value) {
                        if ($value != '') {
                            $Testimonials = Testimonials::find($value);
                        } else {
                            $Testimonials = new Testimonials();
                        }
                        if ($request->hasFile('image')) {
                            if (isset($request->image[$key])) {
                                $files     = $request->file('image')[$key];
                                $random_no = uniqid();
                                $image     = $files;
                                $imgFile   = Image::make($image->path());
                                $height    = $imgFile->height();
                                $width     = $imgFile->width();
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
                                $ext             = $files->getClientOriginalExtension();
                                $new_name        = time() . $random_no . '.' . $ext;
                                $destinationPath = public_path('uploads/Testimonials');
                                $imgFile->save($destinationPath . '/' . $new_name);
                                $Testimonials->image = $new_name;
                            }
                        }
                        $Testimonials->status      = $request->status[$key];
                        $Testimonials->name        = $request->name[$key];
                        $Testimonials->designation = $request->designation[$key];
                        $Testimonials->save();
                        $testimonial_id = $Testimonials->id;

                        if (!empty($request->description)) {
                            foreach ($request->description as $lang_key => $lang_value) {
                                $TestimonialsLanguage = new TestimonialsLanguage();
                                $TestimonialsLanguage->description = change_str($lang_value[$key]);
                                $TestimonialsLanguage->language_id = $lang_key;
                                $TestimonialsLanguage->testimonials_id = $testimonial_id;
                                $TestimonialsLanguage->save();
                            }
                        }
                    }
                }
            }
            //Testimonial Add End
            // print_die($request->testionial_heading);
            //Testimonial Heading
            if (isset($request->testionial_heading)) {
                if (!empty($request->testionial_heading)) {
                    foreach ($request->testionial_heading as $testionial_key => $testionial_value) {
                        $MetaGlobalLanguage = new MetaGlobalLanguage();
                        $MetaGlobalLanguage->meta_parent = 'testimonial';
                        $MetaGlobalLanguage->meta_title = 'testimonial_heading_title';
                        $MetaGlobalLanguage->language_id = $testionial_key;
                        $MetaGlobalLanguage->title       = $testionial_value;
                        $MetaGlobalLanguage->status       = 'Active';
                        $MetaGlobalLanguage->save();
                    }
                }
            }
            //PartTestimonialners Heading End

            return redirect()
                ->route('admin.testimonials.add')
                ->withErrors([$status => $message]);
        }
        $get_testimonial    = Testimonials::orderBy('id', 'desc')->get();
        $get_heading_title  = MetaGlobalLanguage::where('meta_parent', 'testimonial')->where('meta_title', 'testimonial_heading_title')->get();
        return view('admin.testimonials.add_testimonial', compact('common', 'get_testimonial', 'get_heading_title', 'languages','lang_id'));
    }

    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'No Record Found']);
        }
        $id = checkDecrypt($id);
        $status = 'error';
        $message = 'Something went wrong!';
        $get_testimonial = Testimonials::find($id);
        if ($get_testimonial) {
            $get_testimonial->delete();
            $status = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }




    // Gift Ad Expirence
    public function giftAnexpirence(Request $request)
    {
        $common = [];
        Session::put('TopMenu', 'Contents');
        Session::put('SubMenu', 'Gift an Experience');

        $common['title']                = translate('Add Gift Experience');
        $common['button']               = translate('Update');
        $get_gift_an_expirence          = getTableColumn('banner_overview');
        $get_gift_an_expirence_language = [];
        $languages                      = Language::where(ConditionQuery())->get();

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];
        $get_languages = Language::where(['status'=>'Active','is_delete' => 0])->get();

        if ($request->isMethod('post')) {
            $req_fields = [];
            $req_fields['link'] = 'required';
            $req_fields['gift_an_exp_heading.*'] = 'required';
            $req_fields['description.*'] = 'required';

            $errormsg = [
                'link' => translate('link'),
                'gift_an_exp_heading' => translate('Heading Title'),
                'description.*' => translate('Description'),
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
            if (isset(($request->id))) {
                BannerOverviewLanguage::where('page', 'gift_an_expirence_section')->orderBy('overview_id', 'desc')->where('langauge_id',$lang_id)->delete();
                if ($request->id != '') {
                    $BannerOverview       = BannerOverview::where('page', 'gift_an_expirence_section')->first();

                    if ($request->hasFile('image')) {
                        if (isset($request->image)) {
                            $files = $request->file('image');
                            $random_no       = uniqid();
                            $img             = $files;
                            $ext             = $files->getClientOriginalExtension();
                            $new_name        = $random_no . time() . '.' . $ext;
                            $destinationPath = public_path('uploads/gift_an_expirence');
                            $img->move($destinationPath, $new_name);
                            $BannerOverview->image = $new_name;
                        }
                    }
                    $BannerOverview->page     = "gift_an_expirence_section";
                    $BannerOverview->link     = $request->link;
                    $BannerOverview->status     = $request->status;
                    // print_die($BannerOverview);
                    $BannerOverview->save();

                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('banner_overview_language',['langauge_id'=>$value['id'],'overview_id' => $BannerOverview->id,'page'=> 'gift_an_expirence_section' ],'row')) {      
                            $BannerOverviewLanguage                  = new BannerOverviewLanguage();
                            $BannerOverviewLanguage->overview_id     = $BannerOverview->id;
                            $BannerOverviewLanguage->page            = "gift_an_expirence_section";
                            $BannerOverviewLanguage->langauge_id     = $value['id'];
                            $BannerOverviewLanguage->title           = isset($request->gift_an_exp_heading[$value['id']]) ?  $request->gift_an_exp_heading[$value['id']] : $request->gift_an_exp_heading[$lang_id];
                            $BannerOverviewLanguage->description     = isset($request->description[$value['id']]) ? change_str($request->description[$value['id']]) : $request->description[$lang_id]; 
                            $BannerOverviewLanguage->save();
                        }
                    }
                }
            }
            return redirect()
                ->route('admin.gift_an_expirence.add')
                ->withErrors([$status => $message]);
        }
        $get_gift_an_expirence             = BannerOverview::where('page', 'gift_an_expirence_section')->orderBy('id', 'desc')->first();
        $get_gift_an_expirence_language    = BannerOverviewLanguage::where('page', 'gift_an_expirence_section')->get()->toArray();
        return view('admin.gift_an_expirence.add_gift_expirence', compact('common', 'get_gift_an_expirence', 'get_gift_an_expirence_language', 'languages','lang_id'));
    }
}
