<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Blogs;
use App\Models\Blogdescriptions;
use App\Models\Blogcategorydescriptions;
use App\Models\Blogtocategories;
use App\Models\Blogcategory;
use App\Models\Languages;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $common = [];
        $common['title'] = translate('Blogs');
        Session::put('TopMenu', translate('Page Building'));
        Session::put('SubMenu', translate('Blogs'));

        $get_session_language = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $get_blogs = Blogs::orderBy('id', 'desc')
            ->where(['status' => 'Active'])
            ->whereNull('is_delete')
            ->paginate(config('adminconfig.records_per_page'));

        $Blogs = [];
        if (!empty($get_blogs)) {
            foreach ($get_blogs as $key => $value) {
                $row = getLanguageData('blog_descriptions', $language_id, $value['id'], 'blog_id');
                $row['id'] = $value['id'];
                $row['status'] = $value['status'];
                $row['image'] = $value['image'];
                $Blogs[] = $row;
            }
        }
        return view('admin.blogs.index', compact('common', 'get_blogs', 'Blogs'));
    }

    // Add Blogs
    public function add_blogs(Request $request, $id = '')
    {
        $common = [];
        Session::put('TopMenu', translate('Page Building'));
        Session::put('SubMenu', translate('Blogs'));

        $common['title'] = translate('Blogs');
        $common['heading_title'] = translate('Add Blogs');

        $common['button'] = translate('Save');
        $get_blogs = getTableColumn('blogs');
        $get_blog_language = getTableColumn('blog_descriptions');

        $get_category = Blogcategorydescriptions::get();
        $get_session_language = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        if ($request->isMethod('post')) {
            $req_fields = [];
            if ($request->id != '') {
                $req_fields['title'] = 'required';
            } else {
                $req_fields['title'] = 'required';
                $req_fields['image'] = 'required|mimes:jpeg,jpg,png,svg,gif';
                $req_fields['blogcategory_id'] = 'required|array';
            }
            $errormsg = [
                'title' => translate('Title'),
                'blogcategory_id' => translate('Blog Category'),
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
                $Blogs = Blogs::find($request->id);
                if ($Blogs->slug == '') {
                    $Blogs->slug = createSlug('blogs', $request->title);
                }
            } else {
                $message = translate('Add Successfully');
                $status = 'success';
                $Blogs = new Blogs();
                $Blogs->slug = createSlug('blogs', $request->title);
            }

            $Blogs->status = $request->status;
            if ($request->hasFile('image')) {
                $random_no = uniqid();
                $img = $request->file('image');
                $mime_type = $img->getMimeType();
                $ext = $img->getClientOriginalExtension();
                $new_name = $random_no . '.' . $ext;
                $destinationPath = public_path('uploads/blogs');
                $img->move($destinationPath, $new_name);
                $Blogs->image = $new_name;
            }
            $Blogs->save();

            Blogdescriptions::where(['blog_id' => $Blogs->id, 'language_id' => $language_id])->delete();
            if (isset($request->title)) {
                $Blogdescriptions = new Blogdescriptions();
                $Blogdescriptions->title = $request->title;
                $Blogdescriptions->description = $request->description;
                $Blogdescriptions->short_description = $request->short_description;
                $Blogdescriptions->language_id = $language_id;
                $Blogdescriptions->blog_id = $Blogs->id;
                $Blogdescriptions->save();
            }
            Blogtocategories::where(['blog_id' => $Blogs->id])->delete();
            if (isset($request->blogcategory_id)) {
                foreach ($request->blogcategory_id as $key => $value) {
                    $Blogtocategories = new Blogtocategories();
                    $Blogtocategories->blog_id = $Blogs->id;
                    $Blogtocategories->blogcategory_id = $value;
                    $Blogtocategories->save();
                }
            }

            return redirect()
                ->route('admin.blogs')
                ->withErrors([$status => $message]);
        }

        $get_blogcategory = Blogcategory::orderBy('id', 'desc')
            ->where(['status' => 'Active'])
            ->whereNull('is_delete')
            ->get();

        $get_category = [];
        if (!empty($get_blogcategory)) {
            foreach ($get_blogcategory as $key => $value) {
                $row = getLanguageData('blogcategory_descriptions', $language_id, $value['id'], 'blogcategory_id');
                $row['id'] = $value['id'];
                $row['status'] = $value['status'];
                $get_category[] = $row;
            }
        }

        $Blog_to_categories = [];
        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => translate('No Record Found')]);
            }
            $id = checkDecrypt($id);
            $common['title'] = translate('Edit Blogs');
            $common['heading_title'] = translate('Edit Blogs');
            $common['button'] = translate('Update');

            $get_blogs = Blogs::where('id', $id)->first();
            $get_blog_language = getLanguageData('blog_descriptions', $language_id, $id, 'blog_id');

            if (!$get_blogs) {
                return back()->withErrors(['error' => 'Something went wrong']);
            }
            $Blogtocategories = Blogtocategories::where(['blog_id' => $id])->get();
            foreach ($Blogtocategories as $key => $value) {
                $Blog_to_categories[] = $value->blogcategory_id;
            }
        }
        return view('admin.blogs.addblog', compact('common', 'get_blogs', 'get_blog_language', 'get_category', 'Blog_to_categories'));
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
        $get_blogs = Blogs::where(['id' => $id])->first();
        if ($get_blogs) {
            $get_blogs->is_delete = 1;
            $get_blogs->save();
        }
        $status = 'success';
        $message = translate('Delete Successfully');
        return back()->withErrors([$status => $message]);
    }
}
