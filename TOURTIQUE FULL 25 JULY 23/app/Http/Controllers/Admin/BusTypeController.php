<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusType;
use App\Models\BusTypeLanguage;
use App\Models\Language;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BusTypeController extends Controller
{
    public function index()
    {
        $common          = array();
        $common['title'] = "Bus type";

        Session::put("TopMenu", "Product");
        Session::put("SubMenu", "Airport Transfer");
        Session::put("SubSubMenu", "Bus type");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $get_bus_type = BusType::select('bus_type.*', 'bus_type_language.title')->orderBy('bus_type.id', 'desc')->where(['bus_type.is_delete' => 0])
            ->join("bus_type_language", 'bus_type.id', '=', 'bus_type_language.bus_type_id')->groupBy('bus_type.id')
            ->paginate(config('adminconfig.records_per_page'));

        return view('admin.bus_type.index', compact('common', 'get_bus_type','lang_id'));
    }

    ///Add BusType
    public function add_bus_type(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Product");
        Session::put("SubMenu", "Airport Transfer");
        Session::put("SubSubMenu", "Bus type");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $common['title']              = translate("Add Bus Type");
        $common['button']             = translate("Save");

        $get_bus_type                 = getTableColumn('bus_type');
        $get_bus_type_language        = "";
        $languages             = Language::where(ConditionQuery())->get();

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
                $BusType = BusType::find($request->id);
                BusTypeLanguage::where("bus_type_id", $request->id)->where('language_id',$lang_id)->delete();
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $BusType  = new BusType();
            }

            $BusType['status']              = isset($request->status) ? 'Active' : 'Deactive';
            $BusType->save();

            $get_languages = Language::where(['status'=>'Active','is_delete'=>0])->get();

            if (!empty($get_languages)) {
                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('bus_type_language',['language_id'=>$value['id'],'bus_type_id'=>$request->id],'row')) {

                        $BusTypeLanguage              = new BusTypeLanguage();
                    
                        $BusTypeLanguage->title       = isset($request->title[$value['id']]) ?  $request->title[$value['id']] : $request->title[$lang_id];
                        $BusTypeLanguage->language_id = $value['id'];
                        $BusTypeLanguage->bus_type_id = $BusType->id;
                        $BusTypeLanguage->save();
                    }
                }
            }



            return redirect()->route('admin.bus_type')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id           = checkDecrypt($id);
            $common['title']      = "Edit Bus type";
            $common['button']     = "Update";
            $get_bus_type = BusType::where('id', $id)->first();
            $get_bus_type_language = BusTypeLanguage::where("bus_type_id", $id)->get()->toArray();

            if (!$get_bus_type) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.bus_type.addBustype', compact('common', 'get_bus_type', 'languages', 'get_bus_type_language','lang_id'));
    }

    public function delete($id)
    {

        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);

        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_bus_type =  BusType::find($id);
        if ($get_bus_type) {
            $get_bus_type->delete();
            BusTypeLanguage::where('bus_type_id', $id)->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }
}
