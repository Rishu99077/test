<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarType;
use App\Models\CarTypeLanguage;
use App\Models\Language;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CarTypeController extends Controller
{
    public function index(){
        $common          = array();
        $common['title'] = "Car type";
 
        Session::put("TopMenu", "Product");
        Session::put("SubMenu", "Airport Transfer");
        Session::put("SubSubMenu", "Car type");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $get_car_type = CarType::select('car_type.*', 'car_type_language.title')->orderBy('car_type.id', 'desc')->where(['car_type.is_delete' => 0])
            ->join("car_type_language", 'car_type.id', '=', 'car_type_language.car_type_id')->groupBy('car_type.id')
            ->paginate(config('adminconfig.records_per_page'));
            
        return view('admin.car_type.index', compact('common', 'get_car_type','lang_id'));
    }

    ///Add CarType
    public function add_car_type(Request $request, $id = ""){
        $common = array();
        Session::put("TopMenu", "Product");
        Session::put("SubMenu", "Airport Transfer");
        Session::put("SubSubMenu", "Car type");

        $common['title']              = translate("Add Car Type");
        $common['button']             = translate("Save");
        $get_car_type                 = getTableColumn('car_type');
        $get_car_type_language = "";
        $languages             = Language::where(ConditionQuery())->get();

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        if ($request->isMethod('post')) {
            $req_fields = array();
            $req_fields['title.*']   = "required";

            $errormsg = [
                "title.*" => translate("Car type"),
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
                $CarType = CarType::find($request->id);
                CarTypeLanguage::where("car_type_id", $request->id)->where('language_id',$lang_id)->delete();
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $CarType  = new CarType();
            }

            $CarType['status']              = isset($request->status) ? 'Active' : 'Deactive';
            $CarType->save();

            $get_languages = Language::where(['status'=>'Active','is_delete'=>0])->get();
            if (!empty($get_languages)) {
                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('car_type_language',['language_id'=>$value['id'],'car_type_id'=>$request->id],'row')) {

                        $CarTypeLanguage              = new CarTypeLanguage();
                        $CarTypeLanguage->title       = isset($request->title[$value['id']]) ?  $request->title[$value['id']] : $request->title[$lang_id];
                        $CarTypeLanguage->language_id = $value['id'];
                        $CarTypeLanguage->car_type_id = $CarType->id;
                        $CarTypeLanguage->save();

                    }
                }
            }

            return redirect()->route('admin.car_type')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id           = checkDecrypt($id);
            $common['title']      = "Edit car type";
            $common['button']     = "Update";
            $get_car_type = CarType::where('id', $id)->first();
            $get_car_type_language = CarTypeLanguage::where("car_type_id", $id)->get();

            if (!$get_car_type) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.car_type.addCartype', compact('common', 'get_car_type','languages', 'get_car_type_language','lang_id'));
    }
    
    public function delete($id){
        
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
       
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_car_type =  CarType::find($id);
        if ($get_car_type) {
            $get_car_type->delete();
            CarTypeLanguage::where('car_type_id',$id)->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }
}
