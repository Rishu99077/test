<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faqs;
use App\Models\FaqLanguage;
use App\Models\Language;

use App\Models\FaqCategory;
use App\Models\FaqCategoryLanguage;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Str;

class FaqsController extends Controller
{
    public function index()
    {
        $common          = array();
        $common['title'] = "Faqs";
        Session::put("TopMenu", "Contents");
        Session::put("SubMenu", "Faqs");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];


        $get_faqs = array();
        $get_faq_category_language = array();

        $get_faqs_details = Faqs::select('faqs.*', 'faqs_language.question')->orderBy('faqs.id', 'desc')->where(['faqs.is_delete' => 0])
            ->leftjoin("faqs_language", 'faqs.id', '=', 'faqs_language.faq_id')
            ->groupBy('faqs.id')
            ->paginate(config('adminconfig.records_per_page'));   

        foreach ($get_faqs_details as $key => $value) {
            $row['id']            = $value['id'];
            $row['category_name'] = "";
            $row['question']      = $value['question'];
            $row['category']      = $value['category'];
            $row['status']        = $value['status'];

            $get_faq_category = FaqCategory::select('faq_category.*', 'faq_category_language.category_name')
                ->where(['faq_category.status' => 1])
                ->where(['faq_category.id' => $value['category']])
                ->leftjoin("faq_category_language", 'faq_category.id', '=', 'faq_category_language.faq_category_id')
                ->groupBy('faq_category.id')->first();
            if ($get_faq_category) {
                $get_faq_category_language = FaqCategoryLanguage::get();    
                $row['category_name'] = $get_faq_category['category_name'];
            }
            $get_faqs[] = $row;
        }



        // echo "<pre>"; 
        //   print_r($get_faqs);
        //   echo "</pre>";die();    

        return view('admin.faqs.index', compact('common', 'get_faqs', 'get_faqs_details','lang_id','get_faq_category_language'));
    }

    ///Add Faqs
    public function addFaqs(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Contents");
        Session::put("SubMenu", "Faqs");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];
        $get_languages = Language::where(['status'=>'Active','is_delete' => 0])->get();

        $get_faq_category = FaqCategory::select('faq_category.*', 'faq_category_language.category_name')->orderBy('faq_category.id', 'desc')->where(['faq_category.is_delete' => 0])
            ->leftjoin("faq_category_language", 'faq_category.id', '=', 'faq_category_language.faq_category_id')->where('faq_category_language.language_id',$lang_id)->groupBy('faq_category.id')->get();

        $common['title']       = translate("Add Faqs");
        $common['button']      = translate("Save");
        $get_faqs              = getTableColumn('faqs');
        $get_faqs_language = "";
        $languages             = Language::where(ConditionQuery())->get();


        if ($request->isMethod('post')) {

            $req_fields = array();
            $req_fields['category']    = "required";
            $req_fields['question.*']  = "required";
            $req_fields['answer.*']    = "required";

            $errormsg = [
                "category"   => translate("Category"),
                "question.*" => translate("Questions"),
                "answer.*"   => translate("Answer"),
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

            // echo "<pre>"; 
            // print_r($request->all());
            // echo "</pre>";

            if ($request->id != "") {
                $message  = translate("Update Successfully");
                $status   = "success";
                $Faqs = Faqs::find($request->id);
                FaqLanguage::where("faq_id", $request->id)->where('language_id',$lang_id)->delete();
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $Faqs = new Faqs();
            }

            $Faqs['category']  = $request->category;
            $Faqs['status']  = isset($request->status)  ? "Active" : "Deactive";

            $Faqs->save();

            if (!empty($request->question)) {

                 foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('faqs_language',['language_id'=>$value['id'],'faq_id'=>$Faqs->id],'row')) {    

                       $FaqLanguage              = new FaqLanguage();
                   
                        $FaqLanguage->question       = isset($request->question[$value['id']]) ? change_str($request->question[$value['id']]) : $request->question[$lang_id];
                        $FaqLanguage->answer         = isset($request->answer[$value['id']]) ? change_str($request->answer[$value['id']]) : $request->answer[$lang_id]; 
                        $FaqLanguage->language_id = $value['id'];
                        $FaqLanguage->faq_id      = $Faqs->id;
                        $FaqLanguage->save();
                    }
                }
            }



            return redirect()->route('admin.faqs')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id           = checkDecrypt($id);
            $common['title']      = "Edit Faqs";
            $common['button']     = "Update";
            $get_faqs = Faqs::where('id', $id)->first();
            $get_faqs_language = FaqLanguage::where("faq_id", $id)->get()->toArray();

            if (!$get_faqs) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }


        return view('admin.faqs.add_faq', compact('common', 'get_faqs', 'languages', 'get_faqs_language', 'get_faq_category','lang_id'));
    }

    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_faqs =  Faqs::find($id);
        if ($get_faqs) {
            $get_faqs->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }


    // FAQS CATEGORY---------------------------
    public function faq_category()
    {
        $common          = array();
        $common['title'] = "Faqs category";
        Session::put("TopMenu", "Contents");
        Session::put("SubMenu", "Faqs Category");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $get_faq_category = FaqCategory::select('faq_category.*', 'faq_category_language.category_name')->orderBy('faq_category.id', 'desc')->where(['faq_category.is_delete' => 0])
            ->leftjoin("faq_category_language", 'faq_category.id', '=', 'faq_category_language.faq_category_id')
            ->groupBy('faq_category.id')
            ->paginate(config('adminconfig.records_per_page'));

        return view('admin.faq_category.index', compact('common', 'get_faq_category','lang_id'));
    }

    ///Add Faqs category
    public function add_faq_category(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Contents");
        Session::put("SubMenu", "Faqs Category");

        $common['title']       = translate("Add Faqs Category");
        $common['button']      = translate("Save");
        $get_faq_category      = getTableColumn('faq_category');

        $get_faq_category_language = "";
        $languages             = Language::where(ConditionQuery())->get();

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];
        $get_languages = Language::where(['status'=>'Active','is_delete' => 0])->get();


        if ($request->isMethod('post')) {

            $req_fields = array();
            $req_fields['category_name.*']   = "required";

            $errormsg = [
                "category_name.*" => translate("Category Name"),
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

            // echo "<pre>"; 
            // print_r($request->all());
            // echo "</pre>";

            if ($request->id != "") {
                $message  = translate("Update Successfully");
                $status   = "success";
                $FaqCategory = FaqCategory::find($request->id);
                FaqCategoryLanguage::where("faq_category_id", $request->id)->where('language_id',$lang_id)->delete();
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $FaqCategory = new FaqCategory();
            }


            $FaqCategory['status']  = isset($request->status)  ? "Active" : "Deactive";

            $FaqCategory->save();

            if (!empty($request->category_name)) {

                 foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('faq_category_language',['language_id'=>$value['id'],'faq_category_id'=>$FaqCategory->id],'row')) {    
                       $FaqCategoryLanguage              = new FaqCategoryLanguage();
                   
                        $FaqCategoryLanguage->category_name     = isset($request->category_name[$value['id']]) ?  $request->category_name[$value['id']] : $request->category_name[$lang_id];
                        $FaqCategoryLanguage->language_id       = $value['id'];
                        $FaqCategoryLanguage->faq_category_id   = $FaqCategory->id;
                        $FaqCategoryLanguage->save();
                    }
                }
            }



            return redirect()->route('admin.faq_category')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id           = checkDecrypt($id);
            $common['title']      = "Edit Faqs Category";
            $common['button']     = "Update";
            $get_faq_category          = FaqCategory::where('id', $id)->first();
            $get_faq_category_language = FaqCategoryLanguage::where("faq_category_id", $id)->get()->toArray();

            if (!$get_faq_category) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.faq_category.add_faq_category', compact('common', 'get_faq_category', 'languages', 'get_faq_category_language','lang_id'));
    }

    public function category_delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_faq_category =  FaqCategory::find($id);
        if ($get_faq_category) {
            $get_faq_category->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }
}
