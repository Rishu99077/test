<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Gear;
use App\Models\Geardescriptions;
use App\Models\Languages;
use Illuminate\Support\Str;

class GearController extends Controller
{
    public function index(Request $request)
    {
        $common          = array();
        $common['title'] = translate("Gears");
        Session::put("TopMenu", translate("Products"));
        Session::put("SubMenu", translate("Gears"));

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $get_gears = Gear::orderBy('id', 'desc')->whereNull('is_delete')
            ->paginate(config('adminconfig.records_per_page'));

        $Gears = [];
        if (!empty($get_gears)) {
            foreach ($get_gears as $key => $value) {
                $row  = getLanguageData('gear_descriptions', $language_id, $value['id'], 'gear_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $Gears[] = $row;
            }
        }

        return view('admin.gears.index', compact('common', 'get_gears', 'Gears'));
    }

    // Add Gears

    public function add_gears(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", translate("Products"));
        Session::put("SubMenu", translate("Gears"));

        $common['title']          = translate('Gears');
        $common['heading_title']  = translate('Add Gears');

        $common['button']         = translate("Save");
        $get_gears             = getTableColumn('gears');
        $get_gear_language     = getTableColumn('gear_descriptions');

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        if ($request->isMethod('post')) {

            $req_fields = array();
            $req_fields['title']   = "required";

            $errormsg = [
                "title" => translate("Title"),
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
                $message   = translate("Update Successfully");
                $status    = "success";
                $Gear     = Gear::find($request->id);
            } else {
                $message   = translate("Add Successfully");
                $status    = "success";
                $Gear      = new Gear();
            }

            $Gear->status = $request->status;
            $Gear->save();

            Geardescriptions::where(["gear_id" => $Gear->id, 'language_id' => $language_id])->delete();
            if (isset($request->title)) {
                $Geardescriptions                = new Geardescriptions();
                $Geardescriptions->title         = $request->title;
                $Geardescriptions->language_id   = $language_id;
                $Geardescriptions->gear_id       = $Gear->id;
                $Geardescriptions->save();
            }
            return redirect()->route('admin.gears')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                         = checkDecrypt($id);
            $common['title']            = translate("Edit Gears");
            $common['heading_title']    = translate("Edit Gears");
            $common['button']           = translate("Update");

            $get_gears = Gear::where('id', $id)->first();
            $get_gear_language  = getLanguageData('gear_descriptions', $language_id, $id, 'gear_id');

            if (!$get_gears) {
                return back()->withErrors(["error" => translate("Something went wrong")]);
            }
        }
        return view('admin.gears.addgears', compact('common', 'get_gears', 'get_gear_language'));
    }


    // Delete Gears

    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => translate("No Record Found")]);
        }
        $id = checkDecrypt($id);
        $status       = 'error';
        $message      = translate('Something went wrong!');
        $get_gears =  Gear::where(['id' => $id])->first();
        if ($get_gears) {
            $get_gears->is_delete = 1;
            $get_gears->save();
        }
        $status  = 'success';
        $message = translate('Delete Successfully');
        return back()->withErrors([$status => $message]);
    }
}
