<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Zones;
use App\Models\Country;
use App\Models\Language;
use App\Models\AirportModel;

use App\Export\ExportZone;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ZoneController extends Controller
{
    public function index(){
        $common          = array();
        $common['title'] = "Zones";
      

        Session::put("TopMenu", "Product");
        Session::put("SubMenu", "Airport Transfer");
        Session::put("SubSubMenu", "Zones");

        $Zone     = @$_GET['Zone'];

        $Zones = Zones::where(['is_delete' => 0])->orderBy('id', 'desc');
       
        if(@$_GET['Zone']){
           $Zones = $Zones->where('zone_title','LIKE', '%'.$Zone.'%');
        }   
        
        $get_zones  =  $Zones->paginate(config('adminconfig.records_per_page'));

        return view('admin.Zones.index', compact('common', 'get_zones'));
    }

    public function zoneExport(Request $request){
        return Excel::download(new ExportZone($request), 'Zone.csv');
    }

    ///Add Zones
    public function add_zones(Request $request, $id = ""){
        $common = array();
      
        Session::put("TopMenu", "Product");
        Session::put("SubMenu", "Airport Transfer");
        Session::put("SubSubMenu", "Zones");

        $common['title']     = translate("Add Zone");
        $common['button']    = translate("Save");

        $get_zones           = getTableColumn('zones');
        $country             = Country::all();
        $airport 			 = AirportModel::all();


        if ($request->isMethod('post')) {
            $req_fields = array();
            $req_fields['zone_title']   = "required";
            $req_fields['zone_country'] = "required";
            $req_fields['zone_state']   = "required";
            $req_fields['zone_city']    = "required";

            $errormsg = [
                "zone_title"   => translate("Zone title"),
                "zone_country" => translate("Country"),
                "zone_state"   => translate("State"),
                "zone_city"    => translate("City"),
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
                $Zones    = Zones::find($request->id);
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $Zones    = new Zones();
            }

            $Zones['zone_title']          = $request->zone_title;
            $Zones['country']             = $request->zone_country;
            $Zones['state']               = $request->zone_state;
            $Zones['city']                = $request->zone_city;
            
            if ($request->zone_airport) {
                foreach ($request->zone_airport as $key => $value_ar) {
                  
                   $arr = $value_ar;

                   $post[] = $arr;
                   
                }

                $Zones['airport'] = json_encode($post);
            }
            $Zones['status']              = isset($request->status) ? 'Active' : 'Deactive';
            $Zones->save();

            return redirect()->route('admin.zones')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id           = checkDecrypt($id);
            $common['title']      = "Edit Zone";
            $common['button']     = "Update";
            $get_zones = Zones::where('id', $id)->first();

            if (!$get_zones) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.Zones.add_zone', compact('common', 'get_zones' ,'country','airport'));
    }
    
    public function delete($id){
        
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
       
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_car_type =  Zones::find($id);
        if ($get_car_type) {
            $get_car_type->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }
}
