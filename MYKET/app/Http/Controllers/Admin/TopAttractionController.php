<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Countries;
use App\Models\States;
use App\Models\Cities;
use App\Models\TopAttraction;
use App\Models\TopAttractionDescription;
use Illuminate\Support\Str;

class TopAttractionController extends Controller
{
    // List Top Attraction
    public function index()
    {
        $common          = array();
        $common['title'] = "Top Attraction";
        Session::put("TopMenu", "Page Building");
        Session::put("SubMenu", "Top Destination");

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];


        $get_top_attraction = TopAttraction::orderBy('id', 'desc')->whereNull('is_delete')
            ->paginate(config('adminconfig.records_per_page'));

        $TopAttraction = [];
        if (!empty($get_top_attraction)) {
            foreach ($get_top_attraction as $key => $value) {
                $row              = getLanguageData('top_attraction_description', $language_id, $value['id'], 'attraction_id');
                $row['id']        = $value['id'];
                $row['image']     = $value['image'];
                $row['status']    = $value['status'];
                $TopAttraction[] = $row;
            }
        }

        return view('admin.top_attraction.index', compact('common', 'get_top_attraction', 'TopAttraction'));
    }

    // Add Edit top Attraction
    public function add_top_attraction(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Products");
        Session::put("SubMenu", "Top Attraction");

        $common['title']          = 'Top Attraction';
        $common['heading_title']  = 'Add Top Attraction';

        $common['button']          = translate("Save");
        $get_top_attraction          = getTableColumn('top_attraction');
        $get_top_attraction_language = getTableColumn('top_attraction_description');

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id              = $get_session_language['id'];

        $Countries = Countries::where(['is_delete' => null])->get();

        if ($request->isMethod('post')) {

            $req_fields                      = array();
            $req_fields['title']             = "required";
            if ($request->id == "") {
                $req_fields['image']             = "required";
            }

            $req_fields['country']           = "required";

            $errormsg = [
                "title"             => translate("Title"),
                "image"             => translate("Image"),
                "country"           => translate("Country"),
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
                $TopAttraction = TopAttraction::find($request->id);
            } else {
                $message     = translate("Add Successfully");
                $status      = "success";
                $TopAttraction = new TopAttraction();
                $TopAttraction->slug = createSlug('top_attraction', $request->title);
            }

            $TopAttraction->status  = $request->status;
            $TopAttraction->country = $request->country;
            $TopAttraction->state   = $request->state;
            $TopAttraction->city    = $request->city;

            if ($request->hasFile('image')) {
                $random_no  = uniqid();
                $img        = $request->file('image');
                $mime_type  =  $img->getMimeType();
                $ext        = $img->getClientOriginalExtension();
                $new_name   = $random_no . '.' . $ext;
                $destinationPath =  public_path('uploads/top_attraction');
                $img->move($destinationPath, $new_name);
                $TopAttraction->image = $new_name;
            }


            $TopAttraction->save();

            TopAttractionDescription::where(["attraction_id" => $TopAttraction->id, 'language_id' => $language_id])->delete();
            if (isset($request->title)) {
                $TopAttractionDescription                    = new TopAttractionDescription();
                $TopAttractionDescription->title             = $request->title;
                $TopAttractionDescription->language_id       = $language_id;
                $TopAttractionDescription->attraction_id    = $TopAttraction->id;
                $TopAttractionDescription->save();
            }
            return redirect()->route('admin.top_attraction')->withErrors([$status => $message]);
        }
        $States = [];
        $Cities = [];
        if ($id != "") {

            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                         = checkDecrypt($id);
            $common['title']            = "Edit Top Attraction";
            $common['heading_title']    = "Edit Top Attraction";
            $common['button']           = "Update";

            $get_top_attraction = TopAttraction::where('id', $id)->first();

            if ($get_top_attraction->country != "") {
                $States = States::where('country_id', $get_top_attraction->country)->get();
                if ($get_top_attraction->state != "") {
                    $Cities = Cities::where('state_id', $get_top_attraction->state)->get();
                }
            }

            $get_top_attraction_language  = getLanguageData('top_attraction_description', $language_id, $id, 'attraction_id');

            if (!$get_top_attraction) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.top_attraction.add', compact('common', 'get_top_attraction', 'get_top_attraction_language', 'Countries', 'States', 'Cities'));
    }

    // Delete Top Attraction
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status       = 'error';
        $message      = 'Something went wrong!';
        $get_top_attraction =  TopAttraction::where(['id' => $id])->first();
        if ($get_top_attraction) {
            $get_top_attraction->is_delete = 1;
            $get_top_attraction->save();
        }
        $status  = 'success';
        $message = 'Delete Successfully';
        return back()->withErrors([$status => $message]);
    }
}
