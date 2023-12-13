<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LanguageController extends Controller
{
    public function index(Request $request)
    {
        $common          = array();

        $common['title'] =  translate("Languages");

        Session::put("TopMenu", translate("Settings"));
        Session::put("SubMenu", translate("Languages"));


        $get_language = Language::orderBy('id', 'desc')->where(['is_delete' => 0])->paginate(config('adminconfig.records_per_page'));
        return view('admin.language.index', compact('common', 'get_language'));
    }

    public function store(Request $request, $id = "")
    {

        $common = array();
        Session::put("TopMenu", translate("Settings"));
        Session::put("SubMenu", translate("Languages"));


        $common['title']      = translate("Add Language");
        $common['button']     = translate("Save");
        $get_language         = getTableColumn('languages');


        if ($request->isMethod('post')) {


            $req_fields                       = array();
            if ($request->id == "") {
                $req_fields['title']              = "required|unique:languages";
                $req_fields['sort_code']          = "required|unique:languages|regex:/^[a-zA-Z]+$/u";
            }
            // $req_fields['flag_image']         = "required";

            $errormsg = [
                "title"      => translate("Title"),
                "sort_code"  => translate("Short Code"),
                "flag_image" => translate("Flag Image"),
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

            if ($request->id != "") {
                $message  = translate("Update Successfully");
                $status   = "success";
                $data     = $request->except('id', '_token');
                $Language = Language::find($request->id);
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $data                 = $request->except('_token');
                $Language = new Language();
            }
            foreach ($data as $key => $value) {
                if ($key == "flag_image") {
                    if ($request->hasFile('flag_image')) {
                        $random_no       = uniqid();
                        $img              = $request->file('flag_image');
                        $ext              = $img->getClientOriginalExtension();
                        $new_name          = $random_no . '.' . $ext;
                        $destinationPath =  public_path('uploads/language_flag');
                        $img->move($destinationPath, $new_name);
                        $value     = $new_name;
                    }
                }
                $Language->$key = $value;
            }
            $Language->save();
            return redirect()->route('admin.language')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => translate("No Record Found")]);
            }
            $id = checkDecrypt($id);
            $common['title']             = translate("Edit Category");
            $common['button']            = translate("Update");
            $get_language =  Language::where('id', $id)->first();

            if (!$get_language) {
                return back()->withErrors(["error" => translate("Something went wrong")]);
            }
        }

        return view('admin.language.form', compact('common', 'get_language'));
    }

    public function delete($id){
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_language =  Language::find($id);
        if ($get_language) {
            $get_language->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }
}
