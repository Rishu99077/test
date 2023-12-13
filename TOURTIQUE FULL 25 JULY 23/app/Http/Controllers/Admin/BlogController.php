<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\BlogCategory;
use App\Models\BlogCategoryLanguage;
use App\Models\Language;
use App\Models\BlogAditionalLanguage;
use App\Models\BlogAditionalHeadline;
use App\Models\Blog;
use App\Models\BlogLanguage;


class BlogController extends Controller
{

    // ----------------------------------------------- Blogs -----------------------------------------------------------------

    //Blogs List
    public function blogs()
    {
        $common          = array();
        $common['title'] = "Blogs";
        Session::put("TopMenu", "Blog");
        Session::put("SubMenu", "Blogs");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $get_blog = Blog::select('blogs.*', 'blog_language.title')->orderBy('blogs.id', 'desc')->where(['blogs.is_delete' => 0])
            ->leftjoin("blog_language", 'blogs.id', '=', 'blog_language.blog_id')
            ->groupBy('blogs.id')
            ->paginate(config('adminconfig.records_per_page'));

        return view('admin.blogs.index', compact('common', 'get_blog','lang_id'));
    }


    //Add Blog 
    public function addBlog(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Blog");
        Session::put("SubMenu", "Blogs");
        $common['title']                    = "Add Blog";
        $common['button']                   = "Save";

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $get_blog                           = getTableColumn('blogs');
        $get_blog['additional']             = array();
        $get_blog['image']                  = url('uploads/placeholder/placeholder.png');

        $get_blog_category = BlogCategory::select('blog_category.*', 'blog_category_language.name')->orderBy('blog_category.id', 'desc')->where(['blog_category.is_delete' => 0, 'blog_category.status' => 'active'])
            ->join("blog_category_language", 'blog_category.id', '=', 'blog_category_language.blog_cetegory_id')->groupBy('blog_category.id')
            ->paginate(config('adminconfig.records_per_page'));


        $get_blog_language            = "";

        $languages                       = Language::where(ConditionQuery())->get();

        $get_blog_additional             = [];
        $get_blog_additional_language    = [];
        $BAV                             = getTableColumn('blogs_aditional_headline');


        if ($request->isMethod('post')) {

            $req_fields                        = array();
            $req_fields['category_id']         = "required";
            $req_fields['title']               = "required";
            $req_fields['description']         = "required";
            $req_fields['video']               = "required";

            $errormsg = [
                "category_id"            => "Blog Category",
                "title"                  => "Title",
                "description"            => "Description",
                "image"                  => "Image",
                "video"                  => "Video",
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
                $message        = "Update Successfully";
                $status         = "success";

                $Blog           = Blog::find($request->id);
                BlogLanguage::where("blog_id", $request->id)->where('language_id',$lang_id)->delete();

                $get_additional_blog = BlogAditionalHeadline::where('blog_id', $request->id)->get();
                foreach ($get_additional_blog as $key => $get_additional_blog_delete) {
                    if (isset($request->addtional_headline_id)) {
                        if (!in_array($get_additional_blog_delete['id'], $request->addtional_headline_id)) {
                            BlogAditionalHeadline::where('id', $get_additional_blog_delete['id'])->delete();
                        }
                    } else {
                        BlogAditionalHeadline::where('blog_id', $request->id)->delete();
                    }
                }

                $slug = createSlug('blogs', $request->title[$lang_id], $request->id);
            } else {
                $message        = "Add Successfully";
                $status         = "success";

                $Blog           = new Blog();
                $slug           = createSlug('blogs', $request->title[$lang_id]);
            }

            // $Blog->title 	   = $request->title;
            $Blog->category_id  = $request->category_id;
            $Blog->date         = $request->date;
            $Blog->slug         = $slug;
            $Blog->video = $request->video;


            // $Blog->description = $request->description;
            if ($request->hasFile('image')) {
                $random_no       = uniqid();
                $img              = $request->file('image');
                $ext              = $img->getClientOriginalExtension();
                $new_name          = $random_no . '.' . $ext;
                $destinationPath =  public_path('uploads/blogs');
                $img->move($destinationPath, $new_name);
                $Blog->image     = $new_name;
            }
            if ($request->hasFile('thumnail_image')) {
                $random_no       = uniqid();
                $img              = $request->file('thumnail_image');
                $ext              = $img->getClientOriginalExtension();
                $new_name          = $random_no . '.' . $ext;
                $destinationPath =  public_path('uploads/blogs');
                $img->move($destinationPath, $new_name);
                $Blog->thumnail_image     = $new_name;
            }
            
            $Blog->status   = $request->status;
            
            $Blog->save();
            $blog_id = $Blog->id;

            $get_languages = Language::where(['status'=>'Active','is_delete' => 0])->get();

            if (!empty($get_languages)) {
                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('rewards_language',['language_id'=>$value['id'],'reward_id'=>$request->id],'row')) {

                        $BlogLanguage              = new BlogLanguage();
                        $BlogLanguage->title       = isset($request->title[$value['id']]) ?  $request->title[$value['id']] : $request->title[$lang_id];
                        $BlogLanguage->description = isset($request->description[$value['id']]) ?  $request->description[$value['id']] : $request->description[$lang_id];
                        $BlogLanguage->language_id = $value['id'];
                        $BlogLanguage->blog_id     = $Blog->id;
                        $BlogLanguage->save();

                    }
                }
            }


            ///Additional
            if ($request->additional_title && count($request->additional_title) > 0) {
                // BlogAditionalHeadline::where(["blog_id" => $blog_id])->delete();
                BlogAditionalLanguage::where(["blog_id" => $blog_id])->where('language_id',$lang_id)->delete();
                foreach ($request->addtional_headline_id as $key => $value) {

                    if ($request->addtional_headline_id[$key] != "") {
                        $BlogAditionalHeadline               = BlogAditionalHeadline::find($request->addtional_headline_id[$key]);
                    } else {
                        $BlogAditionalHeadline               = new BlogAditionalHeadline();
                    }

                    $BlogAditionalHeadline->blog_id       = $blog_id;

                    if ($request->hasFile('additional_image')) {
                        if (isset($request->additional_image[$key])) {
                            $random_no                         = uniqid();
                            $img                                = $request->additional_image[$key];
                            $ext                                = $img->getClientOriginalExtension();
                            $additional_new_name                = $random_no . '.' . $ext;
                            $destinationPath                   =  public_path('uploads/blogs');
                            $img->move($destinationPath, $additional_new_name);
                            $BlogAditionalHeadline->image     = $additional_new_name;
                        }
                    }
                    $BlogAditionalHeadline->save();

                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('blog_aditional_language',['language_id'=>$value['id'],'blog_id' => $Blog->id,'blog_aditional_id'=> $BlogAditionalHeadline->id ],'row')) { 
                            $BlogAditionalLanguage              = new BlogAditionalLanguage();
                            $BlogAditionalLanguage->title       = isset($request->additional_title[$value['id']][$key]) ?  $request->additional_title[$value['id']][$key] : $request->additional_title[$lang_id][$key];
                            $BlogAditionalLanguage->description = isset($request->additional_description[$value['id']][$key]) ?  $request->additional_description[$value['id']][$key] : $request->additional_description[$lang_id][$key];   
                            $BlogAditionalLanguage->language_id = $value['id'];
                            $BlogAditionalLanguage->blog_id     = $Blog->id;
                            $BlogAditionalLanguage->blog_aditional_id     = $BlogAditionalHeadline->id;
                            $BlogAditionalLanguage->save();
                            
                        }
                    }
                }

                // print_die($request->all());
            }
            return redirect()->route('admin.blogs')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                          = checkDecrypt($id);
            $common['title']             = "Edit Blog";
            $common['button']            = "Update";
            $getBlog                       =  Blog::where('id', $id)->first();

            $get_blog_language            = BlogLanguage::where("blog_id", $id)->get();

            $get_blog_additional          = BlogAditionalHeadline::where("blog_id", $id)->get();
            $get_blog_additional_language = BlogAditionalLanguage::where("blog_id", $id)->get();

            if ($getBlog) {
                $get_blog['category_id']    = $getBlog['category_id'];
                $get_blog['image']          = $getBlog['image']          != '' ? url('uploads/blogs', $getBlog['image']) : url('uploads/placeholder/placeholder.png');;
                $get_blog['thumnail_image'] = $getBlog['thumnail_image'] != '' ? url('uploads/blogs', $getBlog['thumnail_image']) : url('uploads/placeholder/placeholder.png');;
                $get_blog['video']          = $getBlog['video'];
                $get_blog['title']          = $getBlog['title'];
                $get_blog['description']    = $getBlog['description'];
                $get_blog['date']           = $getBlog['date'];
                $get_blog['views']          = $getBlog['views'];
                $get_blog['status']         = $getBlog['status'];
                $get_blog['id']             = $getBlog['id'];

                $get_blog_detail         =  BlogAditionalHeadline::where('blog_id', $id)->get();
                if (!$get_blog_detail->isEmpty()) {
                    foreach ($get_blog_detail as $key => $value) {
                        $get_detail                         = array();
                        $get_detail['id']                    = $value['id'];
                        $get_detail['title']                = $value['title'];
                        $get_detail['description']        = $value['description'];
                        $get_detail['image']                = $value['image'] != '' ? url('uploads/blogs', $value['image']) : url('uploads/placeholder/placeholder.png');

                        $get_detail['headline']           = BlogAditionalLanguage::where(["blog_aditional_id" => $value['id']])->get()->toArray();
                        $get_blog['additional'][] = $get_detail;
                    }
                }
            } else {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
            // print_die($get_blog);
        }
        return view('admin.blogs.addBlog', compact('common', 'get_blog', 'get_blog_category', 'get_blog_language', 'languages', 'get_blog_additional', 'get_blog_additional_language', 'BAV','lang_id'));
    }



    ///Delete Blog
    public function deleteBlog($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $Blog =  Blog::find($id);
        if ($Blog) {
            BlogAditionalHeadline::where('blog_id', $id)->delete();
            BlogLanguage::where('blog_id', $id)->delete();
            BlogAditionalLanguage::where('blog_id', $id)->delete();
            $Blog->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }


    // ----------------------------------------------- Blogs -----------------------------------------------------------------

    //
    public function blogsCategory(Request $request)
    {
        $common          = array();
        $common['title'] = "Blog Category";
        Session::put("TopMenu", "Blog");
        Session::put("SubMenu", "Blog Category");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $get_blog_category = BlogCategory::select('blog_category.*', 'blog_category_language.name')->orderBy('blog_category.id', 'desc')->where(['blog_category.is_delete' => 0])
            ->leftjoin("blog_category_language", 'blog_category.id', '=', 'blog_category_language.blog_cetegory_id')
            ->groupBy('blog_category.id')
            ->paginate(config('adminconfig.records_per_page'));
     

        return view('admin.blogs_category.index', compact('common', 'get_blog_category','lang_id'));
    }


    ///Add Categroy
    public function addBlogCategory(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Blog");
        Session::put("SubMenu", "Blog Category");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $common['title']      = "Add Blog Category";
        $common['button']     = "Save";

        $get_blog_category    = getTableColumn('blog_category');
        $get_blog_category_language = "";

        $languages             = Language::where(ConditionQuery())->get();

        if ($request->isMethod('post')) {

            $req_fields                 = array();
            $req_fields['name']         = "required";

            $errormsg = [
                "name"                  => "Title",
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
                $message        = "Update Successfully";
                $status         = "success";
                $data           = $request->except('id', '_token', 'name', 'description');

                $BlogCategory = BlogCategory::find($request->id);
                BlogCategoryLanguage::where("blog_cetegory_id", $request->id)->where('language_id',$lang_id)->delete();
            } else {
                $message        = "Add Successfully";
                $status         = "success";
                $data         = $request->except('_token', 'name', 'description');
                $BlogCategory = new BlogCategory();
            }


            foreach ($data as $key => $value) {
                $BlogCategory->$key = $value;
            }


            $BlogCategory->save();


            $get_languages = Language::where(['status'=>'Active','is_delete' => 0])->get();

            if (!empty($get_languages)) {
                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('blog_category_language',['language_id'=>$value['id'],'blog_cetegory_id'=>$request->id],'row')) {

                        $BlogCategoryLanguage              = new BlogCategoryLanguage();
                        $BlogCategoryLanguage->name        = isset($request->name[$value['id']]) ?  $request->name[$value['id']] : $request->name[$lang_id];
                        $BlogCategoryLanguage->description = isset($request->description[$value['id']]) ? change_str($request->description[$value['id']]) : $request->description[$lang_id]; 
                        $BlogCategoryLanguage->language_id = $value['id'];
                        $BlogCategoryLanguage->blog_cetegory_id  = $BlogCategory->id;
                        $BlogCategoryLanguage->save();

                    }
                }
            }
            return redirect()->route('admin.blogsCategory')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id = checkDecrypt($id);

            $common['title']             = "Edit Blog Category";
            $common['button']            = "Update";
            $get_blog_category           =  BlogCategory::where('id', $id)->first();
            $get_blog_category_language  =  BlogCategoryLanguage::where("blog_cetegory_id", $id)->get();

            if (!$get_blog_category) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.blogs_category.addblogcategory', compact('common', 'get_blog_category', 'languages', 'get_blog_category_language','lang_id'));
    }


    ///Delete Category
    public function deleteBlogCategory($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $BlogCategory =  BlogCategory::find($id);
        if ($BlogCategory) {
            $BlogCategory->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }


}
