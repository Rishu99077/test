<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Guide;
use App\Models\Guideimages;
use App\Models\Guidedescriptions;
use App\Models\Guidehighlights;
use App\Models\Guidehighlightdescriptions;
use App\Models\Guidefaqs;
use App\Models\GuideFaqdescriptions;
use App\Models\Languages;
use App\Models\Countries;
use App\Models\States;
use App\Models\Cities;
use Illuminate\Support\Str;

class GuideController extends Controller
{
    public function index(Request $request)
    {
        $common          = array();
        $common['title'] = translate("Guide");
        Session::put("TopMenu", translate("Page Building"));
        Session::put("SubMenu", translate("Guide"));

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $get_guide = Guide::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
            ->paginate(config('adminconfig.records_per_page'));

        $Guide = array();
        if (!empty($get_guide)) {
            foreach ($get_guide as $key => $value) {
                $row  = getLanguageData('guide_descriptions', $language_id, $value['id'], 'guide_id');
                $row['id']              = $value['id'];
                $row['status']          = $value['status'];
                $row['image']           = $value['image'];
                $Guide[] = $row;
            }
        }

        return view('admin.guide.index', compact('common', 'get_guide', 'Guide'));
    }

    // Add Guide
    public function add_guide(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", translate("Page Building"));
        Session::put("SubMenu", translate("Guide"));

        $common['title']           = translate('Guide');
        $common['heading_title']   = translate('Add Guide');

        $common['button']          = translate("Save");
        $get_guide                 = getTableColumn('guides');
        $get_guide_language        = getTableColumn('guide_descriptions');

        $get_additional_highlights = [];
        $get_additional_faqs       = [];
        $get_additional_images     = [];

        $get_session_language      = getLang();
        $common['language_title']  = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $Countries = Countries::where(['is_delete' => null])->get();

        if ($request->isMethod('post')) {

            $req_fields = array();
            if ($request->id != '') {
                $req_fields['title']   = "required";
            } else {
                $req_fields['title']   = "required";
                $req_fields['image']   = "required|mimes:jpeg,jpg,png,svg,gif";
            }
            $req_fields['country']   = "required";

            $errormsg = [
                "title"   => translate("Title"),
                "country" => translate("Country"),
            ];

            $validation = Validator::make(
                $request->all(),
                $req_fields,
                [
                    'required' => 'The :attribute field is required.',
                ],
                $errormsg
            );

            if ($validation->fails()) {
                return back()->withErrors($validation)->withInput();
            }

            $request->request->add(['user_id' => Session::get('admin_id')]);

            if ($request->id != "") {
                $message    = translate("Update Successfully");
                $status     = "success";
                $Guide      = Guide::find($request->id);
                if ($Guide->slug == "") {
                    $Guide->slug  = createSlug('guides', $request->title);
                }
            } else {
                $message    = translate("Add Successfully");
                $status     = "success";
                $Guide      = new Guide();
                $Guide->slug =  createSlug('guides', $request->title);
            }

            $Guide->status  = $request->status;
            if ($request->hasFile('image')) {
                $random_no  = uniqid();
                $img        = $request->file('image');
                $mime_type  = $img->getMimeType();
                $ext        = $img->getClientOriginalExtension();
                $new_name   = $random_no . '.' . $ext;
                $destinationPath =  public_path('uploads/guide');
                $img->move($destinationPath, $new_name);
                $Guide->image = $new_name;
            }

            $Guide->country = $request->country;
            $Guide->state   = $request->state;
            $Guide->city    = $request->city;
            $Guide->save();

            Guidedescriptions::where(["guide_id" => $Guide->id, 'language_id' => $language_id])->delete();
            if (isset($request->title)) {
                $Guidedescriptions                = new Guidedescriptions();
                $Guidedescriptions->title         = $request->title;
                $Guidedescriptions->description   = $request->description;
                $Guidedescriptions->language_id   = $language_id;
                $Guidedescriptions->guide_id      = $Guide->id;
                $Guidedescriptions->save();
            }

            $Guidehighlights_exits = array();
            if (isset($request->add_highlight_id) && count($request->add_highlight_id) > 0) {
                foreach ($request->add_highlight_id as $key => $value_1) {
                    if ($value_1 != '') {
                        $Guidehighlights = Guidehighlights::find($value_1);
                    } else {
                        $Guidehighlights = new Guidehighlights();
                    }
                    $Guidehighlights['guide_id'] = $Guide->id;
                    $Guidehighlights->save();

                    $guide_id = $Guidehighlights->id;
                    $Guidehighlightdescriptions = Guidehighlightdescriptions::where(['guide_highlight_id' => $guide_id, 'language_id' => $language_id])->first();
                    if ($Guidehighlightdescriptions) {
                    } else {
                        $Guidehighlightdescriptions = new Guidehighlightdescriptions();
                        $Guidehighlightdescriptions['guide_highlight_id']  = $guide_id;
                        $Guidehighlightdescriptions['language_id']       = $language_id;
                    }
                    $Guidehighlightdescriptions['highlight_title']         = $request->highlight_title[$key];
                    $Guidehighlightdescriptions['highlight_description']   = $request->highlight_description[$key];
                    $Guidehighlightdescriptions->save();

                    $Guidehighlights_exits[] = $guide_id;
                }
            }

            $Guidehighlights = Guidehighlights::where('guide_id', $Guide->id)->get();
            foreach ($Guidehighlights as $key => $value1) {
                if (in_array($value1->id, $Guidehighlights_exits)) {
                    # code...
                } else {
                    Guidehighlights::where('id', $value1->id)->delete();
                    Guidehighlightdescriptions::where('guide_highlight_id', $value1->id)->delete();
                }
            }


            $Guideimage_exits = [];
            if (isset($request->add_image_id) && count($request->add_image_id) > 0) {
                foreach ($request->add_image_id as $key => $value_5) {
                    if ($value_5 != '') {
                        $Guideimages = Guideimages::find($value_5);
                    } else {
                        $Guideimages = new Guideimages();
                    }
                    $Guideimages['guide_id'] = $Guide->id;
                    if ($request->hasFile('guide_gallery_image')) {
                        if (isset($request->guide_gallery_image[$key]) && $request->guide_gallery_image[$key] != '') {
                            $files = $request->file('guide_gallery_image')[$key];
                            $random_no = uniqid();
                            $img = $files;
                            $ext = $files->getClientOriginalExtension();
                            $new_name = $random_no . time() . '.' . $ext;
                            $destinationPath = public_path('uploads/guide/gallery');
                            $img->move($destinationPath, $new_name);
                            $Guideimages['guide_gallery_image'] = $new_name;
                        }
                    }
                    $Guideimages->save();
                    $Guideimage_exits[] = $Guideimages->id;
                }
            }

            $Guideimages = Guideimages::where('guide_id', $Guide->id)->get();
            foreach ($Guideimages as $key => $value5) {
                if (in_array($value5->id, $Guideimage_exits)) {
                    # code...
                } else {
                    Guideimages::where('id', $value5->id)->delete();
                }
            }

            $Guidefaq_exits = [];
            if (isset($request->add_faq_id) && count($request->add_faq_id) > 0) {
                foreach ($request->add_faq_id as $key => $value_2) {
                    if ($value_2 != '') {
                        $Guidefaqs = Guidefaqs::find($value_2);
                    } else {
                        $Guidefaqs = new Guidefaqs();
                    }
                    $Guidefaqs['guide_id'] = $Guide->id;
                    $Guidefaqs->save();

                    $guidefaq_id = $Guidefaqs->id;
                    $GuideFaqdescriptions = GuideFaqdescriptions::where(['guide_faq_id' => $guidefaq_id, 'language_id' => $language_id])->first();
                    if ($GuideFaqdescriptions) {
                    } else {
                        $GuideFaqdescriptions = new GuideFaqdescriptions();
                        $GuideFaqdescriptions['guide_faq_id']        = $guidefaq_id;
                        $GuideFaqdescriptions['language_id']       = $language_id;
                    }
                    $GuideFaqdescriptions['faq_title']         = $request->faq_title[$key];
                    $GuideFaqdescriptions['faq_description']   = $request->faq_description[$key];
                    $GuideFaqdescriptions->save();

                    $Guidefaq_exits[] = $guidefaq_id;
                }
            }

            $GuideFaq = Guidefaqs::where('guide_id', $Guide->id)->get();
            foreach ($GuideFaq as $key => $value2) {
                if (in_array($value2->id, $Guidefaq_exits)) {
                    # code...
                } else {
                    Guidefaqs::where('id', $value2->id)->delete();
                    GuideFaqdescriptions::where('guide_faq_id', $value2->id)->delete();
                }
            }

            return redirect()->route('admin.guide')->withErrors([$status => $message]);
        }

        $highlights = array();
        $faqs       = [];
        $images     = [];

        $States = [];
        $Cities = [];
        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                         = checkDecrypt($id);
            $common['title']            = translate("Edit Guide");
            $common['heading_title']    = translate("Edit Guide");
            $common['button']           = translate("Update");
            $get_guide = Guide::where('id', $id)->first();

            if ($get_guide->country != "") {
                $States = States::where('country_id', $get_guide->country)->get();
                if ($get_guide->state != "") {
                    $Cities = Cities::where('state_id', $get_guide->state)->get();
                }
            }

            $get_guide_language  = getLanguageData('guide_descriptions', $language_id, $id, 'guide_id');

            $get_additional_highlights      = Guidehighlights::where('guide_id', $id)->get();
            if (!$get_additional_highlights->isEmpty()) {
                foreach ($get_additional_highlights as $key => $value) {
                    // $arr = [];
                    $arr  = getLanguageData('guide_highlight_descriptions', $language_id, $value['id'], 'guide_highlight_id');
                    $arr['id']                    = $value['id'];
                    $highlights[] = $arr;
                }
            }

            $get_additional_images      = Guideimages::where('guide_id', $id)->get();
            if (!$get_additional_images->isEmpty()) {
                foreach ($get_additional_images as $key => $value) {
                    $arr = [];
                    $arr['id']                    = $value['id'];
                    $arr['guide_gallery_image']   = $value['guide_gallery_image'];
                    $images[] = $arr;
                }
            }

            $get_additional_faqs      = Guidefaqs::where('guide_id', $id)->get();
            if (!$get_additional_faqs->isEmpty()) {
                foreach ($get_additional_faqs as $key => $value_5) {
                    // $arr = [];
                    $arr  = getLanguageData('guide_faqs_descriptions', $language_id, $value_5['id'], 'guide_faq_id');
                    $arr['id']                    = $value_5['id'];
                    $faqs[] = $arr;
                }
            }
            if (!$get_guide) {
                return back()->withErrors(["error" => translate("Something went wrong")]);
            }
        }
        return view('admin.guide.addguide', compact('common', 'get_guide', 'get_guide_language', 'highlights', 'faqs', 'images', 'Countries', 'States', 'Cities'));
    }


    // Delete Guide
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => translate("No Record Found")]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = translate('Something went wrong!');
        $get_guide   =  Guide::where(['id' => $id])->first();
        if ($get_guide) {
            $get_guide->is_delete = 1;
            $get_guide->save();
        }
        $status  = 'success';
        $message = translate('Delete Successfully');
        return back()->withErrors([$status => $message]);
    }
}
