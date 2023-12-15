<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Services;
use App\Models\Servicedescriptions;
use App\Models\Languages;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $common          = array();
        $common['title'] = "Services";
        Session::put("TopMenu", "Page Building");
        Session::put("SubMenu", "Services");

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $get_services = Services::orderBy('id', 'desc')->whereNull('is_delete')
            ->paginate(config('adminconfig.records_per_page'));

        $services = array();
        if (!empty($get_services)) {
            foreach ($get_services as $key => $value) {
                $row  = getLanguageData('service_descriptions', $language_id, $value['id'], 'service_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $services[] = $row;
            }
        }    

        return view('admin.services.index', compact('common', 'get_services','services'));
    }

    // Add Services
    public function add_services(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Page Building");
        Session::put("SubMenu", "Services");

        $common['title']          = 'Services';
        $common['heading_title']  = 'Add Services';
        $common['button']         = translate("Save");

        $get_services             = getTableColumn('services');
        $get_service_language     = getTableColumn('service_descriptions');
        
        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        if ($request->isMethod('post')) {

            $req_fields = array();
            $req_fields['title']   = "required";

            $errormsg = [
                "title" => translate("Title"),
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
                $services = Services::find($request->id);
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $services = new Services();
            }

            $services->status = $request->status;
            $services->save();

            Servicedescriptions::where(["service_id" => $services->id ,'language_id' => $language_id])->delete();
            if (isset($request->title)) {
                $servicesdescriptions                = new Servicedescriptions();
                $servicesdescriptions->title         = $request->title;
                $servicesdescriptions->language_id = $language_id;
                $servicesdescriptions->service_id    = $services->id;
                $servicesdescriptions->save();
                
            }
            return redirect()->route('admin.services')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                         = checkDecrypt($id);
            $common['title']            = "Edit Services";
            $common['heading_title']    = "Edit Services";
            $common['button']           = "Update";

            $get_services = Services::where('id', $id)->first();
            $get_service_language  = getLanguageData('service_descriptions', $language_id, $id, 'service_id');
            if (!$get_services) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.services.addservices', compact('common', 'get_services','get_service_language'));
    }


    // Delete Services
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status       = 'error';
        $message      = 'Something went wrong!';
        $get_services =  Services::where(['id' => $id])->first();
        if ($get_services) {
            $get_services->is_delete = 1;
            $get_services->save();
        }
        $status  = 'success';
        $message = 'Delete Successfully';
        return back()->withErrors([$status => $message]);
    }
}
