<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Faqs;
use App\Models\Faqdescriptions;
use App\Models\Languages;
use Illuminate\Support\Str;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $common          = array();
        $common['title'] = translate("FAQ");
        Session::put("TopMenu", translate("Page Building"));
        Session::put("SubMenu", translate("FAQ"));

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $get_faqs  = Faqs::orderBy('id', 'desc')->whereNull('is_delete')
            ->paginate(config('adminconfig.records_per_page'));

        $Faqs = array();
        if (!empty($get_faqs)) {
            foreach ($get_faqs as $key => $value) {
                $row  = getLanguageData('faq_descriptions', $language_id, $value['id'], 'faq_id');
                $row['id']           = $value['id'];
                $row['status']       = $value['status'];
                $Faqs[] = $row;
            }
        }

        return view('admin.faqs.index', compact('common', 'get_faqs', 'Faqs'));
    }

    // Add Faqs
    public function add_faqs(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", translate("Page Building"));
        Session::put("SubMenu", translate("FAQ"));

        $common['title']         = translate('FAQ');
        $common['heading_title'] = translate('Add FAQ');

        $common['button']    = translate("Save");
        $get_faqs            = getTableColumn('faqs');
        $get_faq_language    = getTableColumn('faq_descriptions');

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
                $message  = translate("Update Successfully");
                $status   = "success";
                $Faqs     = Faqs::find($request->id);
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $Faqs     = new Faqs();
            }

            $Faqs->status = $request->status;
            $Faqs->save();

            Faqdescriptions::where(["faq_id" => $Faqs->id, 'language_id' => $language_id])->delete();
            if (isset($request->title)) {
                $Faqdescriptions                = new Faqdescriptions();
                $Faqdescriptions->title         = $request->title;
                $Faqdescriptions->description   = $request->description;
                $Faqdescriptions->language_id = $language_id;
                $Faqdescriptions->faq_id        = $Faqs->id;
                $Faqdescriptions->save();
            }
            return redirect()->route('admin.faqs')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                         = checkDecrypt($id);
            $common['title']            = translate("Edit FAQ");
            $common['heading_title']    = translate("Edit FAQ");
            $common['button']           = translate("Update");

            $get_faqs = Faqs::where('id', $id)->first();
            $get_faq_language  = getLanguageData('faq_descriptions', $language_id, $id, 'faq_id');

            if (!$get_faqs) {
                return back()->withErrors(["error" => translate("Something went wrong")]);
            }
        }
        return view('admin.faqs.addfaqs', compact('common', 'get_faqs', 'get_faq_language'));
    }


    // Delete Faqs
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => translate("No Record Found")]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = translate('Something went wrong!');
        $get_faqs =  Faqs::where(['id' => $id])->first();
        if ($get_faqs) {
            $get_faqs->is_delete = 1;
            $get_faqs->save();
        }
        $status  = 'success';
        $message = translate('Delete Successfully');
        return back()->withErrors([$status => $message]);
    }
}
