<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Models\PostLanguage;
use App\Models\Language;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index(){
        $common          = array();
        $common['title'] = "Posts";
        Session::put("TopMenu", "Posts");
        Session::put("SubMenu", "Posts");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $getPost = Posts::select('posts.*', 'post_language.description')->orderBy('posts.id', 'desc')->where(['posts.is_delete' => 0])
            ->join("post_language", 'posts.id', '=', 'post_language.post_id')
            ->groupBy('posts.id')
            ->paginate(config('adminconfig.records_per_page')); 
            
        return view('admin.posts.index', compact('common', 'getPost','lang_id'));
    }

    ///Add Posts
    public function addPost(Request $request, $id = ""){
        $common = array();
        Session::put("TopMenu", "Posts");
        Session::put("SubMenu", "Posts");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $common['title']              = translate("Add Posts");
        $common['button']             = translate("Save");
        $get_post                     = getTableColumn('posts');
        $get_post_language = "";
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

            $request->request->add(['user_id' => Session::get('admin_id')]);
            if ($request->id != "") {
                $message  = translate("Update Successfully");
                $status   = "success";
                $data     = $request->except('id', '_token', 'name');
                $Posts = Posts::find($request->id);
                PostLanguage::where("post_id", $request->id)->where('language_id',$lang_id)->delete();
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $data     = $request->except('_token', 'name');
                $Posts = new Posts();
            }

            // dd($request->all());
            foreach ($data as $key => $value) {
                $Posts->$key = $value;
            }

            $Posts->save();

            $get_languages = Language::where(['status'=>'Active','is_delete' => 0])->get();

            if (!empty($get_languages)) {
                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('rewards_language',['language_id'=>$value['id'],'reward_id'=>$request->id],'row')) {
                        $PostLanguage              = new PostLanguage();
                    
                        $PostLanguage->description = isset($request->name[$value['id']]) ?  $request->name[$value['id']] : $request->name[$lang_id];
                        $PostLanguage->language_id = $value['id'];
                        $PostLanguage->post_id     = $Posts->id;
                        $PostLanguage->save();
                    }
                }
            }



            return redirect()->route('admin.posts')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id           = checkDecrypt($id);
            $common['title']      = "Edit Post";
            $common['button']     = "Update";
            $get_post = Posts::where('id', $id)->first();
            $get_post_language = PostLanguage::where("post_id", $id)->get()->toArray();

            if (!$get_post) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.posts.addPost', compact('common', 'get_post','languages', 'get_post_language','lang_id'));
    }
    
    public function delete($id){
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_post =  Posts::find($id);
        if ($get_post) {
            $get_post->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }
}
