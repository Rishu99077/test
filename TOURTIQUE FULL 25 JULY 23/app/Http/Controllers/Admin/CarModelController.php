<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarModels;
use App\Models\Language;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CarModelController extends Controller
{
    public function index(){
        $common          = array();
        $common['title'] = "Car Models";
       
        Session::put("TopMenu", "Product");
        Session::put("SubMenu", "Airport Transfer");
        Session::put("SubSubMenu", "Car Models");

        $get_car_models = CarModels::orderBy('id', 'desc')->where(['is_delete' => 0])
            ->paginate(config('adminconfig.records_per_page'));
            
        return view('admin.car_model.index', compact('common', 'get_car_models'));
    }

    ///Add CarModels
    public function addCarmodels(Request $request, $id = ""){
        $common = array();
        Session::put("TopMenu", "Product");
        Session::put("SubMenu", "Airport Transfer");
        Session::put("SubSubMenu", "Car Models");

        $common['title']              = translate("Add Car Models");
        $common['button']             = translate("Save");
        $get_car_models               = getTableColumn('car_models');
        
        $languages             = Language::where(ConditionQuery())->get();

        if ($request->isMethod('post')) {

            $req_fields = array();
            $req_fields['name']   = "required";

            $errormsg = [
                "name" => translate("Car Model"),
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
                $CarModels = CarModels::find($request->id);
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $CarModels = new CarModels();
            }
            $CarModels['name']                = $request->name;
            $CarModels['status']              = isset($request->status) ? 'Active' : 'Deactive';
            $CarModels->save();

            return redirect()->route('admin.car_model')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id           = checkDecrypt($id);
            $common['title']      = "Edit Car Models";
            $common['button']     = "Update";
            $get_car_models = CarModels::where('id', $id)->first();

            if (!$get_car_models) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.car_model.addCarModel', compact('common', 'get_car_models'));
    }
    
    public function delete($id){
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_car_models =  CarModels::find($id);
        if ($get_car_models) {
            $get_car_models->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }
}
