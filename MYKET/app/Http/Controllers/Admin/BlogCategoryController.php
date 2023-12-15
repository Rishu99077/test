<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Blogcategory;
use App\Models\Blogcategorydescriptions;
use App\Models\Languages;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function index(Request $request)
    {
        $common = [];
        $common['title'] = translate('Blog Category');
        Session::put('TopMenu', translate('Page Building'));
        Session::put('SubMenu', translate('Blog Category'));

        $get_session_language = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $get_blogcategory = Blogcategory::orderBy('id', 'desc')
            ->where(['status' => 'Active'])
            ->whereNull('is_delete')
            ->paginate(config('adminconfig.records_per_page'));

        $Blogcategory = [];
        if (!empty($get_blogcategory)) {
            foreach ($get_blogcategory as $key => $value) {
                $row = getLanguageData('blogcategory_descriptions', $language_id, $value['id'], 'blogcategory_id');
                $row['id'] = $value['id'];
                $row['status'] = $value['status'];
                $row['image'] = $value['image'];
                $Blogcategory[] = $row;
            }
        }

        return view('admin.blogcategory.index', compact('common', 'Blogcategory', 'get_blogcategory'));
    }

    // Add Blogs
    public function add_blogcategory(Request $request, $id = '')
    {
        $common = [];
        Session::put('TopMenu', translate('Page Building'));
        Session::put('SubMenu', translate('Blog Category'));

        $common['title'] = translate('Blog Category');
        $common['heading_title'] = translate('Add Blog Category');

        $common['button'] = translate('Save');
        $get_blogcategory = getTableColumn('blogcategory');
        $get_blogcategory_language = getTableColumn('blogcategory_descriptions');

        $get_session_language = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        if ($request->isMethod('post')) {
            $req_fields = [];
            if ($request->id != '') {
                $req_fields['title'] = 'required';
            } else {
                $req_fields['title'] = 'required';
            }
            $errormsg = [
                'title' => translate('Title'),
            ];

            $validation = Validator::make(
                $request->all(),
                $req_fields,
                [
                    'required' => 'The :attribute field is required.',
                ],
                $errormsg,
            );

            if ($validation->fails()) {
                return back()
                    ->withErrors($validation)
                    ->withInput();
            }

            $request->request->add(['user_id' => Session::get('admin_id')]);

            if ($request->id != '') {
                $message = translate('Update Successfully');
                $status = 'success';
                $Blogcategory = Blogcategory::find($request->id);
            } else {
                $message = translate('Add Successfully');
                $status = 'success';
                $Blogcategory = new Blogcategory();
            }

            $Blogcategory->status = $request->status;
            if ($request->hasFile('image')) {
                $random_no = uniqid();
                $img = $request->file('image');
                $mime_type = $img->getMimeType();
                $ext = $img->getClientOriginalExtension();
                $new_name = $random_no . '.' . $ext;
                $destinationPath = public_path('uploads/blogcategory');
                $img->move($destinationPath, $new_name);
                $Blogcategory->image = $new_name;
            }
            $Blogcategory->save();

            Blogcategorydescriptions::where(['blogcategory_id' => $Blogcategory->id, 'language_id' => $language_id])->delete();
            if (isset($request->title)) {
                $Blogcategorydescriptions = new Blogcategorydescriptions();
                $Blogcategorydescriptions->title = $request->title;
                $Blogcategorydescriptions->language_id = $language_id;
                $Blogcategorydescriptions->blogcategory_id = $Blogcategory->id;
                $Blogcategorydescriptions->save();
            }
            return redirect()
                ->route('admin.blogcategory')
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => translate('No Record Found')]);
            }
            $id = checkDecrypt($id);
            $common['title'] = translate('Edit Blog Category');
            $common['heading_title'] = translate('Edit Blog Category');
            $common['button'] = translate('Update');

            $get_blogcategory = Blogcategory::where('id', $id)->first();
            $get_blogcategory_language = getLanguageData('blogcategory_descriptions', $language_id, $id, 'blogcategory_id');

            if (!$get_blogcategory) {
                return back()->withErrors(['error' => translate('Something went wrong')]);
            }
        }
        return view('admin.blogcategory.addblogcategory', compact('common', 'get_blogcategory', 'get_blogcategory_language'));
    }

    // Delete Blogs
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()
                ->back()
                ->withErrors(['error' => translate('No Record Found')]);
        }
        $id = checkDecrypt($id);
        $status = 'error';
        $message = 'Something went wrong!';
        $get_blogcategory = Blogcategory::where(['id' => $id])->first();
        if ($get_blogcategory) {
            $get_blogcategory->is_delete = 1;
            $get_blogcategory->save();
        }
        $status = 'success';
        $message = translate('Delete Successfully');
        return back()->withErrors([$status => $message]);
    }
}
