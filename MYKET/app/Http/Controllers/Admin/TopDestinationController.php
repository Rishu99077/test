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
use App\Models\TopDestination;
use App\Models\TopDestinationDescription;
use Illuminate\Support\Str;

class TopDestinationController extends Controller
{
    // List Product Type
    public function index()
    {
        $common          = array();
        $common['title'] = "Top Destination";
        Session::put("TopMenu", "Page Building");
        Session::put("SubMenu", "Top Destination");

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];


        $get_top_destination = TopDestination::orderBy('id', 'desc')->whereNull('is_delete')
            ->paginate(config('adminconfig.records_per_page'));

        $TopDestination = [];
        if (!empty($get_top_destination)) {
            foreach ($get_top_destination as $key => $value) {
                $row              = getLanguageData('top_destination_description', $language_id, $value['id'], 'destination_id');
                $row['id']        = $value['id'];
                $row['image']     = $value['image'];
                $row['status']    = $value['status'];
                $TopDestination[] = $row;
            }
        }

        return view('admin.top_destination.index', compact('common', 'get_top_destination', 'TopDestination'));
    }

    // Add Edit top Destination
    public function add_top_destination(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Page Building");
        Session::put("SubMenu", "Top Destination");

        $common['title']          = 'Top Destination';
        $common['heading_title']  = 'Add Top Destination';

        $common['button']          = translate("Save");
        $get_top_destination          = getTableColumn('top_destination');
        $get_top_destination_language = getTableColumn('top_destination_description');

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id              = $get_session_language['id'];

        $Countries = Countries::where(['is_delete' => null])->get();

        if ($request->isMethod('post')) {

            $req_fields                      = array();
            $req_fields['title']             = "required";
            $req_fields['short_description'] = "required";
            if ($request->id == "") {
                $req_fields['image']             = "required";
            }

            $req_fields['country']           = "required";

            $errormsg = [
                "title"             => translate("Title"),
                "short_description" => translate("Short Description"),
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
                $TopDestination = TopDestination::find($request->id);
            } else {
                $message     = translate("Add Successfully");
                $status      = "success";
                $TopDestination = new TopDestination();
            }

            $TopDestination->status  = $request->status;
            $TopDestination->country = $request->country;
            $TopDestination->state   = $request->state;
            $TopDestination->city    = $request->city;

            if ($request->hasFile('image')) {
                $random_no  = uniqid();
                $img        = $request->file('image');
                $mime_type  =  $img->getMimeType();
                $ext        = $img->getClientOriginalExtension();
                $new_name   = $random_no . '.' . $ext;
                $destinationPath =  public_path('uploads/top_destination');
                $img->move($destinationPath, $new_name);
                $TopDestination->image = $new_name;
            }


            $TopDestination->save();

            TopDestinationDescription::where(["destination_id" => $TopDestination->id, 'language_id' => $language_id])->delete();
            if (isset($request->title)) {
                $TopDestinationDescription                    = new TopDestinationDescription();
                $TopDestinationDescription->title             = $request->title;
                $TopDestinationDescription->short_description = $request->short_description;
                $TopDestinationDescription->language_id       = $language_id;
                $TopDestinationDescription->destination_id    = $TopDestination->id;
                $TopDestinationDescription->save();
            }
            return redirect()->route('admin.top_destination')->withErrors([$status => $message]);
        }
        $States = [];
        $Cities = [];
        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                         = checkDecrypt($id);
            $common['title']            = "Edit Top Destination";
            $common['heading_title']    = "Edit Top Destination";
            $common['button']           = "Update";

            $get_top_destination = TopDestination::where('id', $id)->first();

            if ($get_top_destination->country != "") {
                $States = States::where('country_id', $get_top_destination->country)->get();
                if ($get_top_destination->state != "") {
                    $Cities = Cities::where('state_id', $get_top_destination->state)->get();
                }
            }

            $get_top_destination_language  = getLanguageData('top_destination_description', $language_id, $id, 'destination_id');

            if (!$get_top_destination) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.top_destination.add', compact('common', 'get_top_destination', 'get_top_destination_language', 'Countries', 'States', 'Cities'));
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
        $get_top_destination =  TopDestination::where(['id' => $id])->first();
        if ($get_top_destination) {
            $get_top_destination->is_delete = 1;
            $get_top_destination->save();
        }
        $status  = 'success';
        $message = 'Delete Successfully';
        return back()->withErrors([$status => $message]);
    }
}
