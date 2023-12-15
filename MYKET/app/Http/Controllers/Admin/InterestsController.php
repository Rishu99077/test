<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Interests;
use App\Models\Interestdescriptions;
use App\Models\Languages;
use Illuminate\Support\Str;

class InterestsController extends Controller
{
    public function index(Request $request)
    {
        $common          = array();
        $common['title'] = translate("Interests");
        Session::put("TopMenu", translate("Page Building"));
        Session::put("SubMenu", translate("Interests"));

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $get_interest = Interests::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
            ->paginate(config('adminconfig.records_per_page'));

        $interests = array();
        if (!empty($get_interest)) {
            foreach ($get_interest as $key => $value) {
                $row  = getLanguageData('interest_descriptions', $language_id, $value['id'], 'interest_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $interests[] = $row;
            }
        }

        return view('admin.interest.index', compact('common', 'get_interest', 'interests'));
    }

    // Add Interest

    public function add_interest(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", translate("Page Building"));
        Session::put("SubMenu", translate("Interests"));

        $common['title']          = translate('Interests');
        $common['heading_title']  = translate('Add Interests');

        $common['button']         = translate("Save");
        $get_interest             = getTableColumn('interests');
        $get_interest_language    = getTableColumn('interest_descriptions');

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
                $Interests = Interests::find($request->id);
            } else {
                $message   = translate("Add Successfully");
                $status    = "success";
                $Interests = new Interests();
            }

            $Interests->status = $request->status;
            $Interests->save();

            Interestdescriptions::where(["interest_id" => $Interests->id, 'language_id' => $language_id])->delete();
            if (isset($request->title)) {
                $Interestdescriptions                = new Interestdescriptions();
                $Interestdescriptions->title         = $request->title;
                $Interestdescriptions->language_id = $language_id;
                $Interestdescriptions->interest_id   = $Interests->id;
                $Interestdescriptions->save();
            }
            return redirect()->route('admin.interests')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                         = checkDecrypt($id);
            $common['title']            = translate("Edit Interests");
            $common['heading_title']    = translate("Edit Interests");
            $common['button']           = translate("Update");

            $get_interest = Interests::where('id', $id)->first();
            $get_interest_language  = getLanguageData('interest_descriptions', $language_id, $id, 'interest_id');

            if (!$get_interest) {
                return back()->withErrors(["error" => translate("Something went wrong")]);
            }
        }
        return view('admin.interest.add_interest', compact('common', 'get_interest', 'get_interest_language'));
    }


    // Delete Interests

    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => translate("No Record Found")]);
        }
        $id = checkDecrypt($id);
        $status       = 'error';
        $message      = translate('Something went wrong!');
        $get_interest =  Interests::where(['id' => $id])->first();
        if ($get_interest) {
            $get_interest->is_delete = 1;
            $get_interest->save();
        }
        $status  = 'success';
        $message = translate('Delete Successfully');
        return back()->withErrors([$status => $message]);
    }
}
