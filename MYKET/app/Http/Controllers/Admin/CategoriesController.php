<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Categories;
use App\Models\Categorydescriptions;
use App\Models\Languages;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    //
    public function index(Request $request)
    {
        $common          = array();
        $common['title'] = translate("Categories");
        Session::put("TopMenu", translate("Products"));
        Session::put("SubMenu", translate("Categories"));

        $get_session_language  = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $get_category = Categories::orderBy('id', 'desc')->whereNull('is_delete')
            ->paginate(config('adminconfig.records_per_page'));

        $categories = array();
        if (!empty($get_category)) {
            foreach ($get_category as $key => $value) {
                $row  = getLanguageData('category_descriptions', $language_id, $value['id'], 'category_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $row['image']  = $value['image'];
                $categories[] = $row;
            }
        }

        return view('admin.category.index', compact('common', 'get_category', 'categories'));
    }


    // Add Categroy
    public function add_category(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", translate("Products"));
        Session::put("SubMenu", translate("Categories"));

        $common['title']          = translate('Categories');
        $common['heading_title']  = translate('Add Categories');

        $common['button']         = translate("Save");
        $get_category             = getTableColumn('categories');
        $get_category_language    = getTableColumn('category_descriptions');

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
                $message    = translate("Update Successfully");
                $status     = "success";
                $Categories = Categories::find($request->id);
                if ($Categories->slug == "") {
                    $Categories->slug  = createSlug('categories', $request->title);
                }
            } else {
                $message    = translate("Add Successfully");
                $status     = "success";
                $Categories = new Categories();
                $Categories->slug = createSlug('categories', $request->title);
            }

            $Categories->status = $request->status;

            if ($request->hasFile('image')) {
                $random_no  = uniqid();
                $img        = $request->file('image');
                $mime_type  =  $img->getMimeType();
                $ext        = $img->getClientOriginalExtension();
                $new_name   = $random_no . '.' . $ext;
                $destinationPath =  public_path('uploads/categories');
                $img->move($destinationPath, $new_name);
                $Categories->image = $new_name;
            }
            $Categories->save();

            Categorydescriptions::where(["category_id" => $Categories->id, 'language_id' => $language_id])->delete();
            if (isset($request->title)) {
                $Categorydescriptions                = new Categorydescriptions();
                $Categorydescriptions->title         = $request->title;
                $Categorydescriptions->language_id = $language_id;
                $Categorydescriptions->category_id   = $Categories->id;
                $Categorydescriptions->save();
            }
            return redirect()->route('admin.categories')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id  = checkDecrypt($id);
            $common['title']            = translate("Edit Categories");
            $common['heading_title']    = translate("Edit Categories");
            $common['button']           = translate("Update");

            $get_category = Categories::where('id', $id)->first();
            $get_category_language  = getLanguageData('category_descriptions', $language_id, $id, 'category_id');

            if (!$get_category) {
                return back()->withErrors(["error" => translate("Something went wrong")]);
            }
        }

        return view('admin.category.add_category', compact('common', 'get_category', 'get_category_language'));
    }


    // Delete Categories
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => translate("No Record Found")]);
        }
        $id = checkDecrypt($id);
        $status       = 'error';
        $message      = translate('Something went wrong!');
        $get_category =  Categories::where(['id' => $id])->whereNull('is_delete')->first();
        if ($get_category) {
            $get_category->is_delete = 1;
            $get_category->save();
        }
        $status  = 'success';
        $message = translate('Delete Successfully');
        return back()->withErrors([$status => $message]);
    }
}
