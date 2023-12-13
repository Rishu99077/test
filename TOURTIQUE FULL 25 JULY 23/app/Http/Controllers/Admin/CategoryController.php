<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\Category;
use App\Models\CategoryLanguage;
use App\Models\Language;
use App\Models\Country;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    //
    public function index(Request $request)
    {
        $common          = array();
        $common['title'] = "Category";
        Session::put("TopMenu", "Category");
        Session::put("SubMenu", "Category");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $get_category = Category::select('categories.*', 'category_language.description')->orderBy('categories.id', 'desc')->where(['categories.is_delete' => 0])
            ->leftjoin("category_language", 'categories.id', '=', 'category_language.category_id')->groupBy('categories.id')
            ->paginate(config('adminconfig.records_per_page')); 
        
        return view('admin.category.index', compact('common', 'get_category','lang_id'));
    }


    ///Add Categroy
    public function addCategory(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Category");
        Session::put("SubMenu", "Category");
        
        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $common['title']               = translate("Add Category");
        $common['button']              = translate("Save");
        $get_category          = getTableColumn('categories');
        $get_category_language = "";
        $languages             = Language::where(ConditionQuery())->get();
        $country               = Country::all();
        $parent                = Category::where(ConditionQuery())->where('parent', 0)->get();


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
                $data     = $request->except('id', '_token', 'name');
                $Category = Category::find($request->id);
                $slug     = createSlug('city_guide', $request->name[$lang_id], $request->id);
                CategoryLanguage::where(["category_id" => $request->id ,'language_id' => $lang_id])->delete();
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $data     = $request->except('_token', 'name');
                $Category = new Category();
                $slug     = createSlug('city_guide', $request->name[$lang_id]);
            }


            foreach ($data as $key => $value) {
                if ($key ==  "country") {
                    $value = implode(",", $value);
                }

                if ($key ==  "icon") {
                    if ($request->hasFile('icon')) {
                        $random_no  = Str::random(5);
                        $img = $request->file('icon');
                        $ext = $img->getClientOriginalExtension();
                        $new_name = time() . $random_no . '.' . $ext;
                        $destinationPath =  public_path('uploads/category/');


                        $img->move($destinationPath, $new_name);
                        $value    = $new_name;
                    }
                }



                $Category->$key = $value;
            }

            $Category->slug = $slug;
            $Category->save();

            $get_languages = Language::where(['status'=>'Active','is_delete'=>0])->get();

            if (!empty($get_languages)) {
                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('category_language',['language_id'=>$value['id'],'category_id'=>$request->id],'row')) {

                        $CategoryLanguage              = new CategoryLanguage();
                    
                        $CategoryLanguage->description = isset($request->name[$value['id']]) ?  $request->name[$value['id']] : $request->name[$lang_id];
                        $CategoryLanguage->language_id = $value['id'];
                        $CategoryLanguage->category_id = $Category->id;
                        $CategoryLanguage->save();
                    
                    }

                }
            }



            return redirect()->route('admin.category')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id           = checkDecrypt($id);
            $common['title']      = "Edit Category";
            $common['button']     = "Update";
            $get_category = Category::where('id', $id)->first();
            $get_category_language = CategoryLanguage::where("category_id", $id)->get()->toArray();

            if (!$get_category) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.category.addCategory', compact('common', 'get_category', 'parent', 'languages', 'country', 'get_category_language','lang_id'));
    }


    ///Delete Category
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_category =  Category::find($id);
        if ($get_category) {
            $get_category->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }
}
