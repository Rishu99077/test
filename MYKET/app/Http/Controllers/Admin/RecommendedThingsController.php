<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\RecommendedThings;
use App\Models\RecommendedThingsDescription;
use App\Models\Countries;
use App\Models\States;
use App\Models\Cities;
use Illuminate\Support\Facades\View;


class RecommendedThingsController extends Controller
{

    // List Recommended Things 
    public function index()
    {
        $common          = array();
        $common['title'] = "Recommended Things";
        Session::put("TopMenu", "Page Building");
        Session::put("SubMenu", "Recommended Things");

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];


        $get_recommended_things = RecommendedThings::orderBy('id', 'desc')->whereNull('is_delete')
            ->paginate(config('adminconfig.records_per_page'));

        $RecommendedThings = [];
        if (!empty($get_recommended_things)) {
            foreach ($get_recommended_things as $key => $value) {
                $row  = getLanguageData('recommended_things_description', $language_id, $value['id'], 'recommended_thing_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $RecommendedThings[] = $row;
            }
        }

        return view('admin.recommended_things.index', compact('common', 'get_recommended_things', 'RecommendedThings'));
    }

    // Add Edit top Destination
    public function add_recommended_things(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Page Building");
        Session::put("SubMenu", "Recommended Things");

        $common['title']          = 'Recommended Things';
        $common['heading_title']  = 'Add Recommended Things';

        $common['button']                = translate("Save");
        $get_recommended_things          = getTableColumn('recommended_things');
        $get_recommended_things_language = getTableColumn('recommended_things_description');

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id              = $get_session_language['id'];

        $Countries = Countries::where(['is_delete' => null])->get();

        if ($request->isMethod('post')) {

            $req_fields                = array();
            $req_fields['title']       = "required";
            $req_fields['description'] = "required";
            if ($request->id == "") {
                $req_fields['image']             = "required";
            }

            $req_fields['country']           = "required";

            $errormsg = [
                "title"       => translate("Title"),
                "description" => translate("Description"),
                "image"       => translate("Image"),
                "country"     => translate("Country"),
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
                $message     = translate("Update Successfully");
                $status      = "success";
                $RecommendedThings = RecommendedThings::find($request->id);
            } else {
                $message     = translate("Add Successfully");
                $status      = "success";
                $RecommendedThings = new RecommendedThings();
            }

            $RecommendedThings->status  = $request->status;
            $RecommendedThings->country = $request->country;
            $RecommendedThings->state   = $request->state;
            $RecommendedThings->city    = $request->city;

            if ($request->hasFile('image')) {
                $random_no  = uniqid();
                $img        = $request->file('image');
                $mime_type  =  $img->getMimeType();
                $ext        = $img->getClientOriginalExtension();
                $new_name   = $random_no . '.' . $ext;
                $destinationPath =  public_path('uploads/recommended_things');
                $img->move($destinationPath, $new_name);
                $RecommendedThings->image = $new_name;
            }


            $RecommendedThings->save();

            RecommendedThingsDescription::where(["recommended_thing_id" => $RecommendedThings->id, 'language_id' => $language_id])->delete();
            if (isset($request->title)) {
                $RecommendedThingsDescription                 = new RecommendedThingsDescription();
                $RecommendedThingsDescription->title          = $request->title;
                $RecommendedThingsDescription->description    = $request->description;
                $RecommendedThingsDescription->language_id    = $language_id;
                $RecommendedThingsDescription->recommended_thing_id = $RecommendedThings->id;
                $RecommendedThingsDescription->save();
            }
            return redirect()->route('admin.recommended_things')->withErrors([$status => $message]);
        }
        $States = [];
        $Cities = [];
        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                         = checkDecrypt($id);
            $common['title']            = "Edit Recommended Things";
            $common['heading_title']    = "Edit Recommended Things";
            $common['button']           = "Update";

            $get_recommended_things = RecommendedThings::where('id', $id)->first();

            if ($get_recommended_things->country != "") {
                $States = States::where('country_id', $get_recommended_things->country)->get();
                if ($get_recommended_things->state != "") {
                    $Cities = Cities::where('state_id', $get_recommended_things->state)->get();
                }
            }

            $get_recommended_things_language  = getLanguageData('recommended_things_description', $language_id, $id, 'recommended_thing_id');

            if (!$get_recommended_things) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.recommended_things.add_recommended_things', compact('common', 'get_recommended_things', 'get_recommended_things_language', 'Countries', 'States', 'Cities'));
    }

    // Delete Product Type
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status       = 'error';
        $message      = 'Something went wrong!';
        $get_recommended_things =  RecommendedThings::where(['id' => $id])->first();
        if ($get_recommended_things) {
            $get_recommended_things->is_delete = 1;
            $get_recommended_things->save();
        }
        $status  = 'success';
        $message = 'Delete Successfully';
        return back()->withErrors([$status => $message]);
    }
}
