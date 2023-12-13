<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarDetails;
use App\Models\CarDetailLanguage;
use App\Models\Language;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CarDetailsController extends Controller
{
    public function index()
    {
        $common          = array();
        $common['title'] = "Car details";
        Session::put("TopMenu", "Product");
        Session::put("SubMenu", "Excursion");
        Session::put("SubSubMenu", "Car details");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $get_details = CarDetails::select('car_details.*', 'car_details_language.title')->orderBy('car_details.id', 'desc')->where(['car_details.is_delete' => 0])
            ->join("car_details_language", 'car_details.id', '=', 'car_details_language.car_details_id')->groupBy('car_details.id')
            ->paginate(config('adminconfig.records_per_page'));

        return view('admin.product.car_details.index', compact('common', 'get_details','lang_id'));
    }

    ///Add CarDetails
    public function addCarDetails(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Product");
        Session::put("SubMenu", "Excursion");
        Session::put("SubSubMenu", "Car details");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $common['title']              = translate("Add Car details");
        $common['button']             = translate("Save");
        $get_car_details              = getTableColumn('car_details');
        $get_car_details_language = "";
        $languages             = Language::where(ConditionQuery())->get();


        if ($request->isMethod('post')) {

            $req_fields               = array();
            $req_fields['title.*']                = "required";
            $req_fields['title_information.*']    = "required";
            $req_fields['car_name.*']             = "required";
            $req_fields['additional_info.*']      = "required";
            $req_fields['number_of_passengers.*'] = "required";
            $req_fields['price.*']                = "required";

            $errormsg = [
                "title.*"             => translate("Title"),
                "title_information.*" => translate("Title information"),
                "car_name.*"          => translate("car name"),
                "additional_info.*"   => translate("additional info"),
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
                $data     = $request->except('id', '_token', 'title', 'title_information', 'car_name', 'additional_info');
                $CarDetails = CarDetails::find($request->id);
                CarDetailLanguage::where("car_details_id", $request->id)->where('language_id',$lang_id)->delete();
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $data     = $request->except('_token', 'title', 'title_information', 'car_name', 'additional_info');
                $CarDetails = new CarDetails();
            }


            foreach ($data as $key => $value) {
                $CarDetails->$key = $value;
            }

            $CarDetails->save();

            $get_languages = Language::where(['status'=>'Active','is_delete'=>0])->get();

            if (!empty($get_languages)) {
                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('rewards_language',['language_id'=>$value['id'],'reward_id'=>$request->id],'row')) {

                        $CarDetailLanguage              = new CarDetailLanguage();
                        $CarDetailLanguage->title           = isset($request->title[$value['id']]) ?  $request->title[$value['id']] : $request->title[$lang_id];
                        $CarDetailLanguage->title_information = isset($request->title_information[$value['id']]) ?  $request->title_information[$value['id']] : $request->title_information[$lang_id];
                        $CarDetailLanguage->car_name        = isset($request->car_name[$value['id']]) ?  $request->car_name[$value['id']] : $request->car_name[$lang_id];
                        $CarDetailLanguage->additional_info = isset($request->additional_info[$value['id']]) ?  $request->additional_info[$value['id']] : $request->additional_info[$lang_id];
                        $CarDetailLanguage->language_id     = $value['id'];
                        $CarDetailLanguage->car_details_id  = $CarDetails->id;
                        $CarDetailLanguage->save();
                    }
                }
            }



            return redirect()->route('admin.car_details')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id           = checkDecrypt($id);
            $common['title']      = "Edit  car details";
            $common['button']     = "Update";
            $get_car_details = CarDetails::where('id', $id)->first();
            $get_car_details_language = CarDetailLanguage::where("car_details_id", $id)->get()->toArray();

            if (!$get_car_details) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.product.car_details.add_car_details', compact('common', 'get_car_details',  'languages', 'get_car_details_language','lang_id'));
    }

    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_car_details =  CarDetails::find($id);
        if ($get_car_details) {
            $get_car_details->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }
}
