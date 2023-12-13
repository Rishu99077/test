<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Locations;
use App\Models\Zones;
use App\Models\Country;
use App\Models\Language;
use App\Export\ExportLocation;

use App\Models\AirportModel;

use App\Models\LocationDistanceTiming; 

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function index(){
        $common          = array();
        $common['title'] = "Locations";
        
        
        Session::put("TopMenu", "Product");
        Session::put("SubMenu", "Airport Transfer");
        Session::put("SubSubMenu", "Locations");

        $zones    = Zones::where(['is_delete' => 0])->orderBy('id', 'desc')->get();
        $Location = @$_GET['Location'];
        $Zone     = @$_GET['Zone'];

        $Locations = Locations::select('locations.*', 'zones.zone_title')->orderBy('locations.id', 'desc')->where(['locations.is_delete' => 0])
            ->join("zones", 'locations.zone', '=', 'zones.id')->groupBy('locations.id');


        if(@$_GET['Location']){
           $Locations = $Locations->where('locations.location_title', 'LIKE', '%'.$Location.'%');                      
        }   

        if(@$_GET['Zone']){
           $Locations = $Locations->where('locations.zone',$Zone);
        }   

        $get_locations  =  $Locations->paginate(config('adminconfig.records_per_page'));
            
        return view('admin.Locations.index', compact('common', 'get_locations','zones'));
    }

    public function exportLocation(Request $request){
        return Excel::download(new ExportLocation($request), 'Location.csv');
    }

    ///Add Locations
    public function add_locations(Request $request, $id = ""){
        $common = array();
        Session::put("TopMenu", "Product");
        Session::put("SubMenu", "Airport Transfer");
        Session::put("SubSubMenu", "Locations");

        $common['title']     = translate("Add Location");
        $common['button']    = translate("Save");

        $get_locations       = getTableColumn('locations');
        $zones 			 	 = Zones::where(['is_delete' => 0])->orderBy('id', 'desc')->get();

        if ($request->isMethod('post')) {
            $req_fields = [];
            
            $req_fields['location_title']   = "required";
            $req_fields['zone']             = "required";
            $req_fields['google_address']   = "required";


            $errormsg = [
                "location_title" => translate("Location"),
                "zone"           => translate("Zone"),
                "google_address" => translate("Google Address"),
            ];

            $validation = Validator::make(
                $request->all(),
                $req_fields,
                [
                    'required' => 'The :attribute field is required.',
                ],
                $errormsg
            );

            // if ($validation->fails()) {
            //     return back()->withErrors($validation)->withInput();
            // }

            if ($validation->fails()) {
                return response()->json(['error' => $validation->getMessageBag()->toArray()]);
            }

            if ($request->id != "") {
                $message  = translate("Update Successfully");
                $status   = "success";
                $Locations    = Locations::find($request->id);

                $get_locations = locations::where('id',$request->id)->first();

                $address_lattitude = $get_locations['address_lattitude'];
                $address_longitude = $get_locations['address_longitude'];

                $destination_addresses = $address_lattitude.'%2C'.$address_longitude;

                $origins_arr = array();
                $get_location_timing = LocationDistanceTiming::where(['location_id' => $request->id])->first();
                if ($get_location_timing) {
                    $get_airport = AirportModel::where('id',$get_location_timing['airport_id'])->get();
                    foreach ($get_airport as $key => $value2) {
                        $row = array();
                        $row = $value2["address_lattitude"].'%2C'.$value2["address_longitude"];
                        $origins_arr[] = $row;
                    }
                }
                  
                   
                $List = implode('%7C', $origins_arr);

                if (isset($List)) {
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                      CURLOPT_URL => 'https://maps.googleapis.com/maps/api/distancematrix/json?destinations='.$destination_addresses.'&origins='.$List.'&units=imperial&key=AIzaSyCpqoRKJ3CM7GGiFWTEY0qCKYYRh00ULF0',
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => '',
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 0,
                      CURLOPT_FOLLOWLOCATION => true,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => 'GET',
                    ));

                    $response = curl_exec($curl);

                    $decode_res = json_decode($response);
              
                    curl_close($curl);
                }
                if ($get_location_timing) {
                    LocationDistanceTiming::where(['airport_id' => $get_location_timing['airport_id'] , 'location_id' => $get_locations['id']])->delete();
                }
                $loc_array = array();
                if ($decode_res->status=='OK') {
                    foreach ($decode_res->rows as $key => $value) {
                        $LocationDistanceTiming = new LocationDistanceTiming();
                        if ($value != '') {
                            $LocationDistanceTiming->airport_id     = $get_location_timing['airport_id'];
                            $LocationDistanceTiming->location_id    = $get_locations['id'];
                            $LocationDistanceTiming->distance       = $value->elements[0]->distance->text;
                            $LocationDistanceTiming->duration       = $value->elements[0]->duration->text;
                            $LocationDistanceTiming->save();
                        }
                    }
                }

            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $Locations    = new Locations();
            }

            $Locations['location_title']        = $request->location_title;
            $Locations['zone']             		= $request->zone;
            $Locations['google_address']        = $request->google_address;
            $Locations['address_lattitude']     = $request->address_lattitude;
            $Locations['address_longitude']     = $request->address_longitude;
           

            $Locations['status']              = isset($request->status) ? 'Active' : 'Deactive';
            $Locations->save();

            return redirect()->route('admin.locations')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id           = checkDecrypt($id);
            $common['title']      = "Edit Location";
            $common['button']     = "Update";
            $get_locations = Locations::where('id', $id)->first();

            if (!$get_locations) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }

       
        return view('admin.Locations.add_location', compact('common', 'get_locations' ,'zones'));
    }
    

    ///Add BULK Locations
    public function bulk_location_add(Request $request, $id = ""){
        $common = array();
        Session::put("TopMenu", "Settings");
        Session::put("SubMenu", "Locations");

        $common['title']     = translate("Add Location");
        $common['button']    = translate("Save");

        $get_locations       = getTableColumn('locations');
        $zones               = Zones::where(['is_delete' => 0])->orderBy('id', 'desc')->get();
       
        return view('admin.Locations.add_bulk_location', compact('common', 'get_locations' ,'zones'));
    }

    public function delete($id){
        
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
       
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_car_type =  Locations::find($id);
        if ($get_car_type) {
            $get_car_type->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }

}
