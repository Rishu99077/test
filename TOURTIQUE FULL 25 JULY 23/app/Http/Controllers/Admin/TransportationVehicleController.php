<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\TransportationVehicle;
use App\Models\TransportationVehicleLanguage;
use App\Models\Language;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TransportationVehicleController extends Controller
{
    public function index()
    {
        $common = [];
        $common['title'] = 'Transportation Vehicle';
        Session::put('TopMenu', 'Product');
        Session::put('SubMenu', 'Yacht');
        Session::put('SubSubMenu', 'Transportation Vehicle');

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];


        $get_transportation_vehicle = TransportationVehicle::select('transportation_vehicle.*', 'transportation_vehicle_language.title')
            ->orderBy('transportation_vehicle.id', 'desc')
            ->where(['transportation_vehicle.is_delete' => 0])
            ->leftjoin('transportation_vehicle_language', 'transportation_vehicle.id', '=', 'transportation_vehicle_language.transportation_vehicle_id')
            ->groupBy('transportation_vehicle.id')
            ->paginate(config('adminconfig.records_per_page'));

        return view('admin.transportation_vehicle.index', compact('common', 'get_transportation_vehicle','lang_id'));
    }

    ///Add TransportationVehicle
    public function add_transportation_vehicle(Request $request, $id = '')
    {
        $common = [];
        Session::put('TopMenu', 'Product');
        Session::put('SubMenu', 'Yacht');
        Session::put('SubSubMenu', 'Transportation Vehicle');

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $common['title'] = translate('Add Transportation Vehicle');
        $common['button'] = translate('Save');
        $get_transportation_vehicle = getTableColumn('transportation_vehicle');
        $get_transportation_vehicle_language = '';
        $languages = Language::where(ConditionQuery())->get();

        if ($request->isMethod('post')) {
            $req_fields = [];
            $req_fields['title.*'] = 'required';
            $req_fields['quantity'] = 'required';
            $req_fields['one_way_price'] = 'required';
            $req_fields['two_way_price'] = 'required';

            $errormsg = [
                'quantity' => translate('Quantity'),
                'one_way_price' => translate('One Way Price'),
                'two_way_price' => translate('Two Way Price'),
                'title.*' => translate('Transportation Vehicle'),
            ];

            $validation = Validator::make(
                $request->all(),
                $req_fields,
                [
                    'required' => 'The :attribute field is required.',
                ],
                $errormsg,
            );

            if ($validation->fails()) {
                return back()
                    ->withErrors($validation)
                    ->withInput();
            }

            if ($request->id != '') {
                $message = translate('Update Successfully');
                $status = 'success';
                $TransportationVehicle = TransportationVehicle::find($request->id);
                TransportationVehicleLanguage::where('transportation_vehicle_id', $request->id)->where('language_id',$lang_id)->delete();
            } else {
                $message = translate('Add Successfully');
                $status = 'success';
                $TransportationVehicle = new TransportationVehicle();
            }

            $TransportationVehicle['one_way_price'] = $request->one_way_price;
            $TransportationVehicle['two_way_price'] = $request->two_way_price;
            $TransportationVehicle['quantity'] = $request->quantity;
            $TransportationVehicle['status'] = isset($request->status) ? 'Active' : 'Deactive';
            $TransportationVehicle->save();

            $get_languages = Language::where(['status'=>'Active','is_delete'=>0])->get();

            if (!empty($get_languages)) {
                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('transportation_vehicle_language',['language_id'=>$value['id'],'transportation_vehicle_id'=>$request->id],'row')) {
                        $TransportationVehicleLanguage = new TransportationVehicleLanguage();
                   
                        $TransportationVehicleLanguage->title = isset($request->title[$value['id']]) ?  $request->title[$value['id']] : $request->title[$lang_id];;
                        $TransportationVehicleLanguage->language_id = $value['id'];
                        $TransportationVehicleLanguage->transportation_vehicle_id = $TransportationVehicle->id;
                        $TransportationVehicleLanguage->save();
                    }
                }
            }

            return redirect()
                ->route('admin.transportation_vehicle')
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'No Record Found']);
            }
            $id = checkDecrypt($id);
            $common['title'] = 'Edit Transportation Vehicle';
            $common['button'] = 'Update';
            $get_transportation_vehicle = TransportationVehicle::where('id', $id)->first();
            $get_transportation_vehicle_language = TransportationVehicleLanguage::where('transportation_vehicle_id', $id)->get();

            if (!$get_transportation_vehicle) {
                return back()->withErrors(['error' => 'Something went wrong']);
            }
        }
        return view('admin.transportation_vehicle.add', compact('common', 'get_transportation_vehicle', 'languages', 'get_transportation_vehicle_language','lang_id'));
    }

    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'No Record Found']);
        }
        $id = checkDecrypt($id);

        $status = 'error';
        $message = 'Something went wrong!';
        $get_transportation_vehicle = TransportationVehicle::find($id);
        if ($get_transportation_vehicle) {
            $get_transportation_vehicle->delete();
            TransportationVehicleLanguage::where('transportation_vehicle_id', $id)->delete();
            $status = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }
}
