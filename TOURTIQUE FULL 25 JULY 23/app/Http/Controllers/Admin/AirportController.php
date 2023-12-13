<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AirportModel;
use App\Models\Language;

use App\Models\Country;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AirportController extends Controller
{
    public function index(){
        $common          = array();
        $common['title'] = "Airport";
        Session::put("TopMenu", "Product");
        Session::put("SubMenu", "Airport Transfer");
        Session::put("SubSubMenu", "Airport");

        $get_airport = AirportModel::orderBy('id', 'desc')->where(['is_delete' => 0])
            ->paginate(config('adminconfig.records_per_page'));
            
        return view('admin.airport.index', compact('common', 'get_airport'));
    }

    ///Add Airport
    public function addAirport(Request $request, $id = ""){
        $common = array();
        Session::put("TopMenu", "Product");
        Session::put("SubMenu", "Airport Transfer");
        Session::put("SubSubMenu", "Airport");

        $common['title']              = translate("Add Airport");
        $common['button']             = translate("Save");
        $get_airport                  = getTableColumn('airport_detail');
       
        $languages  = Language::where(ConditionQuery())->get();
        $country 	= Country::all();
        if ($request->isMethod('post')) {

            $req_fields = array();
            $req_fields['name']   = "required";
            $req_fields['country']   = "required";
            $req_fields['state']     = "required";
            $req_fields['city']      = "required";

            $errormsg = [
                "name" => translate("Location"),
                "country" => translate("Country"),
                "state"   => translate("State"),
                "city"    => translate("City"),
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
                $AirportModel = AirportModel::find($request->id);

            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $AirportModel = new AirportModel();
            }

            $AirportModel['name']                = $request->name;
            $AirportModel['address_lattitude']   = $request->address_lattitude;
            $AirportModel['address_longitude']   = $request->address_longitude;
            $AirportModel['country']             = $request->country;
            $AirportModel['state']               = $request->state;
            $AirportModel['city']                = $request->city;
            $AirportModel['status']              = isset($request->status) ? 'Active' : 'Deactive';

            $AirportModel->save();

            return redirect()->route('admin.airport')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id           = checkDecrypt($id);
            $common['title']      = "Edit Airport";
            $common['button']     = "Update";
            $get_airport = AirportModel::where('id', $id)->first();

            if (!$get_airport) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.airport.addAirport', compact('common', 'get_airport' ,'country'));
    }
    
    public function delete($id){
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_airport =  AirportModel::find($id);
        if ($get_airport) {
            $get_airport->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }
}
