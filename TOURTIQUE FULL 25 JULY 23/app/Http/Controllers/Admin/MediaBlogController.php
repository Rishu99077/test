<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaBlog;
use App\Models\MediaBlogLanguage;
use App\Models\Language;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use Image;
use Illuminate\Support\Str;

class MediaBlogController extends Controller
{
    public function index()
    {
        $common          = array();
        $common['title'] = "Media blog";
        Session::put("TopMenu", "Media blog");
        Session::put("SubMenu", "Media blog");

        $get_media_blog = MediaBlog::select('media_blog.*', 'media_blog_language.description')->orderBy('media_blog.id', 'desc')->where(['media_blog.is_delete' => 0])->join("media_blog_language", 'media_blog.id', '=', 'media_blog_language.media_blog_id')->groupBy('media_blog.id')->paginate(config('adminconfig.records_per_page'));

        return view('admin.mediaBlog.index', compact('common', 'get_media_blog'));
    }

    ///Add Media blog
    public function addMedia_blog(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Media blog");
        Session::put("SubMenu", "Media blog");

        $common['title']              = translate("Add Media blog");
        $common['button']             = translate("Save");
        $get_media_blog                     = getTableColumn('media_blog');
        $get_media_blog_language = "";
        $languages             = Language::where(ConditionQuery())->get();

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

            if ($request->id != "") {
                $message  = translate("Update Successfully");
                $status   = "success";
                $MediaBlog = MediaBlog::find($request->id);
                MediaBlogLanguage::where("media_blog_id", $request->id)->delete();
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $MediaBlog = new MediaBlog();
            }

            $MediaBlog['added_by']  = 'Admin';
            $MediaBlog['status']    = isset($request->status)  ? "Active" : "Deactive";

            if ($request->hasFile('media_image')) {
                if (isset($request->media_image)) {
                    $image                             = $request->file('media_image');

                    $random_no                         = Str::random(5);
                    $MediaBlog['media_image']          = $newImage = time() . $random_no . '.' . $image->getClientOriginalExtension();
                    $imgFile                           = Image::make($image->path());
                    $height                            = $imgFile->height();
                    $width                             = $imgFile->width();
                    if ($width > 600) {
                        $imgFile->resize(792, 450, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                    if ($height > 600) {
                        $imgFile->resize(792, 450, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                    $destinationPath = public_path('uploads/MediaBlog');
                    $imgFile->save($destinationPath . '/' . $newImage);
                }
            }

            if ($request->hasFile('media_video')) {
                if (isset($request->media_video)) {
                    $files = $request->file('media_video');
                    $random_no       = uniqid();
                    $img             = $files;
                    $ext             = $files->getClientOriginalExtension();
                    $new_name        = $random_no . time() . '.' . $ext;
                    $destinationPath =  public_path('uploads/MediaBlog');
                    $img->move($destinationPath, $new_name);
                    $MediaBlog['media_video'] = $new_name;
                }
            }

            $MediaBlog->save();

            if (!empty($request->description)) {
                foreach ($request->description as $key => $value) {

                    $MediaBlogLanguage              = new MediaBlogLanguage();
                    if ($value != "") {
                        $MediaBlogLanguage->description   = $value;
                        $MediaBlogLanguage->language_id   = $key;
                        $MediaBlogLanguage->media_blog_id = $MediaBlog->id;
                        $MediaBlogLanguage->save();
                    }
                }
            }



            return redirect()->route('admin.media_blogs')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id           = checkDecrypt($id);
            $common['title']      = "Edit Media blog";
            $common['button']     = "Update";
            $get_media_blog = MediaBlog::where('id', $id)->first();
            $get_media_blog_language = MediaBlogLanguage::where("media_blog_id", $id)->get()->toArray();

            if (!$get_media_blog) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.mediaBlog.add_media_blog', compact('common', 'get_media_blog', 'languages', 'get_media_blog_language'));
    }

    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_media_blog =  MediaBlog::find($id);
        if ($get_media_blog) {
            $get_media_blog->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }
}
