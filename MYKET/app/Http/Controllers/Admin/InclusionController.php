<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Inclusion;
use App\Models\Inclusiondescriptions;
use App\Models\Languages;
use Illuminate\Support\Str;

class InclusionController extends Controller
{

    public function index(Request $request)
    {
        $common          = array();
        $common['title'] = translate("Inclusion");
        Session::put("TopMenu", translate("Products"));
        Session::put("SubMenu", translate("Inclusion"));

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $get_inclusion = Inclusion::orderBy('id', 'desc')->whereNull('is_delete')
            ->paginate(config('adminconfig.records_per_page'));

        $Inclusion = [];
        if (!empty($get_inclusion)) {
            foreach ($get_inclusion as $key => $value) {
                $row  = getLanguageData('inclusion_descriptions', $language_id, $value['id'], 'inclusion_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $row['image']  = $value['image'];
                $Inclusion[] = $row;
            }
        }

        return view('admin.inclusion.index', compact('common', 'get_inclusion', 'Inclusion'));
    }

    // Add Inclusion

    public function add_inclusion(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", translate("Products"));
        Session::put("SubMenu", translate("Inclusion"));

        $common['title']          = translate('Inclusion');
        $common['heading_title']  = translate('Add Inclusion');
        $common['button']         = translate("Save");

        $get_inclusion              = getTableColumn('inclusions');
        $get_inclusion_language     = getTableColumn('inclusion_descriptions');

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        if ($request->isMethod('post')) {

            $req_fields = array();
            if ($request->id != '') {
                $req_fields['title']   = "required";
            } else {
                $req_fields['title']   = "required";
                $req_fields['image']   = "required|mimes:jpg,jpeg,png,gif,svg";
            }

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
                $message  = translate("Update Successfully");
                $status   = "success";
                $Inclusion = Inclusion::find($request->id);
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $Inclusion = new Inclusion();
            }

            $Inclusion->status = $request->status;
            if ($request->hasFile('image')) {
                $random_no  = uniqid();
                $img        = $request->file('image');
                $mime_type  =  $img->getMimeType();
                $ext        = $img->getClientOriginalExtension();
                $new_name   = $random_no . '.' . $ext;
                $destinationPath =  public_path('uploads/inclusions');
                $img->move($destinationPath, $new_name);
                $Inclusion->image = $new_name;
            }
            $Inclusion->save();

            Inclusiondescriptions::where(["inclusion_id" => $Inclusion->id, 'language_id' => $language_id])->delete();
            if (isset($request->title)) {
                $Inclusiondescriptions                = new Inclusiondescriptions();
                $Inclusiondescriptions->title         = $request->title;
                $Inclusiondescriptions->language_id   = $language_id;
                $Inclusiondescriptions->inclusion_id  = $Inclusion->id;
                $Inclusiondescriptions->save();
            }
            return redirect()->route('admin.inclusion')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                         = checkDecrypt($id);
            $common['title']            = translate("Edit Inclusion");
            $common['heading_title']    = translate("Edit Inclusion");
            $common['button']           = translate("Update");

            $get_inclusion = Inclusion::where('id', $id)->first();
            $get_inclusion_language  = getLanguageData('inclusion_descriptions', $language_id, $id, 'inclusion_id');
            if (!$get_inclusion) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.inclusion.addinclusions', compact('common', 'get_inclusion', 'get_inclusion_language'));
    }


    // Delete Inclusion
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => translate("No Record Found")]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = translate('Something went wrong!');
        $get_inclusion =  Inclusion::where(['id' => $id])->first();
        if ($get_inclusion) {
            $get_inclusion->is_delete = 1;
            $get_inclusion->save();
        }
        $status     = 'success';
        $message    = translate('Delete Successfully');
        return back()->withErrors([$status => $message]);
    }
}
