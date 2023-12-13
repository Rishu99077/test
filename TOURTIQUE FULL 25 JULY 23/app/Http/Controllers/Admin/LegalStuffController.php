<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\LegalStuff;
use App\Models\LegalStuffLanguage;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LegalStuffController extends Controller
{
    public function index()
    {
        $common          = array();
        $common['title'] = "Legal Stuff";
        Session::put("TopMenu", "Contents");
        Session::put("SubMenu", "Legal Stuff");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];
        $get_languages = Language::where(['status'=>'Active','is_delete' => 0])->get();

        $getLegalStuff = LegalStuff::select('legal_stuff.*', 'legal_stuff_language.name')->orderBy('legal_stuff.id', 'desc')->where(['legal_stuff.is_delete' => 0])
            ->leftjoin("legal_stuff_language", 'legal_stuff.id', '=', 'legal_stuff_language.legal_stuff_id')
            ->groupBy('legal_stuff.id')
            ->paginate(config('adminconfig.records_per_page'));

        $get_legal_stuff_language = LegalStuffLanguage::get();    

        return view('admin.legal_stuff.index', compact('common', 'getLegalStuff','get_legal_stuff_language','lang_id'));
    }

    ///Add LegalStuff
    public function addLegalstuff(Request $request, $id = "")
    {

        $common = array();
        Session::put("TopMenu", "Contents");
        Session::put("SubMenu", "Legal Stuff");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];
        $get_languages = Language::where(['status'=>'Active','is_delete' => 0])->get();

        $common['title']              = translate("Add Legal Stuff");
        $common['button']             = translate("Save");
        $get_legal_stuff              = getTableColumn('legal_stuff');
        $get_legal_stuff_language = "";
        $languages             = Language::where(ConditionQuery())->get();

        $parent                = LegalStuff::where(ConditionQuery())->get();


        if ($request->isMethod('post')) {

            $req_fields = array();
            $req_fields['name.*']   = "required";

            $errormsg = [
                "name.*" => translate("Title"),
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
                $data     = $request->except('id', '_token', 'name', 'description');
                $LegalStuff = LegalStuff::find($request->id);
                LegalStuffLanguage::where("legal_stuff_id", $request->id)->where('language_id',$lang_id)->delete();
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $data     = $request->except('_token', 'name', 'description');
                $LegalStuff = new LegalStuff();
            }



            foreach ($data as $key => $value) {
                $LegalStuff->$key = $value;
            }

            $LegalStuff->save();

            if (!empty($request->name)) {

                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('legal_stuff_language',['language_id'=>$value['id'],'legal_stuff_id'=>$LegalStuff->id],'row')) {    
                        $LegalStuffLanguage              = new LegalStuffLanguage();
                    
                        $LegalStuffLanguage->name = isset($request->name[$value['id']]) ?  $request->name[$value['id']] : $request->name[$lang_id];
                        $LegalStuffLanguage->description = isset($request->description[$value['id']]) ? change_str($request->description[$value['id']]) : $request->description[$lang_id]; 
                        $LegalStuffLanguage->language_id = $value['id'];
                        $LegalStuffLanguage->legal_stuff_id     = $LegalStuff->id;
                        $LegalStuffLanguage->save();
                    }
                }
            }



            return redirect()->route('admin.legal_stuff')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id           = checkDecrypt($id);
            $common['title']      = "Edit legal stuff";
            $common['button']     = "Update";
            $get_legal_stuff = LegalStuff::where('id', $id)->first();
            $get_legal_stuff_language = LegalStuffLanguage::where("legal_stuff_id", $id)->get()->toArray();

            if (!$get_legal_stuff) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }

        return view('admin.legal_stuff.add_legal_stuff', compact('common', 'get_legal_stuff', 'parent', 'languages', 'get_legal_stuff_language','lang_id'));
    }

    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_legal_stuff =  LegalStuff::find($id);
        if ($get_legal_stuff) {
            $get_legal_stuff->delete();
            LegalStuffLanguage::where("legal_stuff_id", $id)->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }
}
