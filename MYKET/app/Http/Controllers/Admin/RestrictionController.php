<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Restriction;
use App\Models\Restrictiondescriptions;
use App\Models\Languages;
use Illuminate\Support\Str;

class RestrictionController extends Controller
{

    public function index(Request $request)
    {
        $common          = array();
        $common['title'] = "Restriction";
        Session::put("TopMenu", "Products");
        Session::put("SubMenu", "Restriction");

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $get_restriction = Restriction::orderBy('id', 'desc')->whereNull('is_delete')
            ->paginate(config('adminconfig.records_per_page'));

        $Restriction = [];
        if (!empty($get_restriction)) {
            foreach ($get_restriction as $key => $value) {
                $row  = getLanguageData('restriction_descriptions', $language_id, $value['id'], 'restriction_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $row['image']  = $value['image'];
                $Restriction[] = $row;
            }
        }

        return view('admin.restriction.index', compact('common', 'get_restriction', 'Restriction'));
    }

    // Add Restriction

    public function add_restriction(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Products");
        Session::put("SubMenu", "Restriction");

        $common['title']          = 'Restriction';
        $common['heading_title']  = 'Add Restriction';
        $common['button']         = translate("Save");

        $get_restriction              = getTableColumn('restrictions');
        $get_restriction_language     = getTableColumn('restriction_descriptions');

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
                $Restriction = Restriction::find($request->id);
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $Restriction = new Restriction();
            }

            $Restriction->status = $request->status;
            if ($request->hasFile('image')) {
                $random_no  = uniqid();
                $img        = $request->file('image');
                $mime_type  =  $img->getMimeType();
                $ext        = $img->getClientOriginalExtension();
                $new_name   = $random_no . '.' . $ext;
                $destinationPath =  public_path('uploads/restrictions');
                $img->move($destinationPath, $new_name);
                $Restriction->image = $new_name;
            }
            $Restriction->save();

            Restrictiondescriptions::where(["restriction_id" => $Restriction->id, 'language_id' => $language_id])->delete();
            if (isset($request->title)) {
                $Restrictiondescriptions                = new Restrictiondescriptions();
                $Restrictiondescriptions->title         = $request->title;
                $Restrictiondescriptions->language_id   = $language_id;
                $Restrictiondescriptions->restriction_id  = $Restriction->id;
                $Restrictiondescriptions->save();
            }
            return redirect()->route('admin.restriction')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                         = checkDecrypt($id);
            $common['title']            = "Edit Restriction";
            $common['heading_title']    = "Edit Restriction";
            $common['button']           = "Update";

            $get_restriction = Restriction::where('id', $id)->first();
            $get_restriction_language  = getLanguageData('restriction_descriptions', $language_id, $id, 'restriction_id');
            if (!$get_restriction) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.restriction.addrestrictions', compact('common', 'get_restriction', 'get_restriction_language'));
    }


    // Delete Inclusion
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_restriction =  Restriction::where(['id' => $id])->first();
        if ($get_restriction) {
            $get_restriction->is_delete = 1;
            $get_restriction->save();
        }
        $status     = 'success';
        $message    = 'Delete Successfully';
        return back()->withErrors([$status => $message]);
    }
}
