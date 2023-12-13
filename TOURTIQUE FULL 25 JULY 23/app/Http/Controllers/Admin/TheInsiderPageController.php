<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GolfPage;
use App\Models\GolfPageLanguage;

use App\Models\Insider;
use App\Models\InsiderLanguage;

use App\Models\PageSliders;

use App\Models\Language;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Str;

class TheInsiderPageController extends Controller
{

    ///Add GolfPage
    public function add_the_insider_page(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Pages");
        Session::put("SubMenu", "The Insider");

        $common['title']            = translate("Add Insider");
        $common['button']           = translate("Save");



        $languages = Language::where(ConditionQuery())->get();

        $get_slider_images = [];
        $LSI               = getTableColumn('pages_slider');

        $insider          = [];
        $insider_language = [];
        $FAC              = getTableColumn('insider');
        $PageSliders      = [];

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];
        $get_languages = Language::where(['status'=>'Active','is_delete' => 0])->get();

        if ($request->isMethod('post')) {


            // Facility-------------------------------------------------------------

            $get_page_insider = insider::get();
            // dd($request->all());
            foreach ($get_page_insider as $key => $get_pageInsider_delete) {
                if (!in_array($get_pageInsider_delete['id'], $request->facility_id)) {
                    Insider::where('id', $get_pageInsider_delete['id'])->delete();
                    InsiderLanguage::where(["insider_id" => $get_pageInsider_delete['id']])->delete();
                }
            }

            if ($request->title) {

                // print_die($request->all());

                // InsiderLanguage::truncate();
                foreach ($request->facility_id as $key => $value_fac) {
                    if ($value_fac != "") {
                        $Insider = Insider::find($value_fac);
                    } else {
                        $Insider = new Insider();
                    }

                    if ($request->hasFile('image')) {
                        if (isset($request->image[$key])) {
                            $files = $request->file('image')[$key];
                            $random_no       = uniqid();
                            $img             = $files;
                            $ext             = $files->getClientOriginalExtension();
                            $new_name        = $random_no . time() . '.' . $ext;
                            $destinationPath =  public_path('uploads/insider');
                            $img->move($destinationPath, $new_name);
                            $Insider['image'] = $new_name;
                        }
                    }
                    if (isset($request->video_link[$key])) {
                        $Insider->video_link  = $request->video_link[$key];
                    } else {
                        $Insider->video_link = "";
                    }
                    $Insider->save();
                    InsiderLanguage::where('insider_id', $Insider->id)->where('language_id',$lang_id)->delete();
                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('insider_language',['language_id'=>$value['id'],'insider_id' => $Insider->id ],'row')) { 
                            $InsiderLanguage = new InsiderLanguage();
                            $InsiderLanguage['language_id']   = $value['id'];
                            $InsiderLanguage['insider_id']    = $Insider->id;
                            $InsiderLanguage['title']         = isset($request->title[$value['id']][$key]) ?  $request->title[$value['id']][$key] : $request->title[$lang_id][$key];  
                            $InsiderLanguage['description']   = isset($request->description[$value['id']][$key]) ? change_str($request->description[$value['id']][$key]) : $request->description[$lang_id][$key];  
                            $InsiderLanguage->save();
                        }
                    }
                }
            }

            if (isset($request->image_id)) {
                $PageSliders = PageSliders::where('page', 'insider_img')->get();
                foreach ($PageSliders as $key => $image_delete) {
                    if (!in_array($image_delete['id'], $request->image_id)) {
                        PageSliders::where(['id' => $image_delete['id'], 'page' => 'insider_img'])->delete();
                    }
                }
            } else {
                PageSliders::where('page', 'insider_img')->delete();
            }

            // Multiple IMages
            if ($request->hasFile('files')) {
                $files = $request->file('files');
                foreach ($files as $fileKey => $image) {
                    $PageSliders = new PageSliders();

                    $random_no  = Str::random(5);
                    $PageSliders['page'] = 'insider_img';
                    $PageSliders['image'] = $newImage = time() . $random_no  . '.' . $image->getClientOriginalExtension();

                    $destinationPath = public_path('uploads/insider');
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

                    $destinationPath =  public_path('uploads/insider');
                    $imgFile->save($destinationPath . '/' . $newImage);
                    $PageSliders->save();
                    // dd($image->path(),$imgFile);
                }
            }



            return redirect()->route('admin.the_insider_page.edit', encrypt(1))->withErrors(['success' => translate("Update Successfully")]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                   = checkDecrypt($id);
            $common['title']     = "Edit Insider";
            $common['button']    = "Update";

            $insider          = Insider::get();
            $insider_language = InsiderLanguage::get();
            $PageSliders      = PageSliders::where(['page' => 'insider_img'])->get();


            if (!$insider) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }

        return view('admin.insider_page.insider_page', compact('common', 'insider', 'languages', 'insider_language', 'FAC', 'PageSliders','lang_id'));
    }
}
