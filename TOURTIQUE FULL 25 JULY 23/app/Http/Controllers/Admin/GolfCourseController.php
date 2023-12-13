<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\GolfCourse;
use App\Models\GolfCourseLanguage;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class GolfCourseController extends Controller
{
    public function index(){
        $common          = array();
        $common['title'] = "Golf Course";
       
        Session::put("TopMenu", "Product");
        Session::put("SubMenu", "Golf");
        Session::put("SubSubMenu", "Golf Course");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];


        $GolfCourse = GolfCourse::select('golf_course.*', 'golf_course_language.title')->orderBy('golf_course.id', 'desc')->where(['golf_course.is_delete' => 0])
            ->join("golf_course_language", 'golf_course.id', '=', 'golf_course_language.golf_course_id')->groupBy('golf_course.id');

        $get_golf_courses  =  $GolfCourse->paginate(config('adminconfig.records_per_page'));
            
        return view('admin.golf_course.index', compact('common', 'get_golf_courses','lang_id'));
    }

    ///Add GolfCourse
    public function add_golf_courses(Request $request, $id = ""){
        $common = array();
        Session::put("TopMenu", "Product");
        Session::put("SubMenu", "Golf");
        Session::put("SubSubMenu", "Golf Course");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];


        $common['title']     = translate("Add Golf Course");
        $common['button']    = translate("Save");

        $languages = Language::where(ConditionQuery())->get();


        $get_golf_courses    = getTableColumn('golf_course');
        $get_golf_courses_language    = [];

        if ($request->isMethod('post')) {
            $req_fields = [];
            
            $req_fields['title']   = "required";


            $errormsg = [
                "title" => translate("Golf Course"),
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
                return response()->json(['error' => $validation->getMessageBag()->toArray()]);
            }

            if ($request->id != "") {
                $message  = translate("Update Successfully");
                $status   = "success";
                $GolfCourse    = GolfCourse::find($request->id);
                GolfCourseLanguage::where("golf_course_id", $request->id)->where('language_id',$lang_id)->delete();

            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $GolfCourse    = new GolfCourse();
            }
           

            $GolfCourse['location']          = $request->location;
            $GolfCourse['yards']             = $request->yards;
            $GolfCourse['pars']              = $request->pars;
            $GolfCourse['holes']             = $request->holes;
            $GolfCourse['status']            = isset($request->status) ? 'Active' : 'Deactive';
            $GolfCourse->save();

            $get_languages = Language::where(['status'=>'Active','is_delete'=>0])->get();

            if (!empty($get_languages)) {
                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('golf_course_language',['language_id'=>$value['id'],'golf_course_id'=>$request->id],'row')) {
                
                        $GolfCourseLanguage                      = new GolfCourseLanguage();
                        $GolfCourseLanguage->title 	  			 = isset($request->title[$value['id']]) ?  $request->title[$value['id']] : $request->title[$lang_id];
                        $GolfCourseLanguage->language_id 	     = $value['id'];
                        $GolfCourseLanguage->golf_course_id      = $GolfCourse->id;
                        $GolfCourseLanguage->save();
                    }
                }
            }

            return redirect()->route('admin.golf_courses')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id           = checkDecrypt($id);
            $common['title']      = "Edit Golf Course";
            $common['button']     = "Update";
            $get_golf_courses  = GolfCourse::where('id', $id)->first();
            $get_golf_courses_language = GolfCourseLanguage::where("golf_course_id", $id)->get();

            if (!$get_golf_courses) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }

       
        return view('admin.golf_course.add_golf_course', compact('common', 'get_golf_courses','get_golf_courses_language','languages','lang_id'));
    }
   

    public function delete($id){
        
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
       
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_car_type =  GolfCourse::find($id);
        if ($get_car_type) {
            $get_car_type->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }

}
