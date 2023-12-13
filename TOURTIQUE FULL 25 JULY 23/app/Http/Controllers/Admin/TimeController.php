<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductOptionTime;
use App\Models\Language;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TimeController extends Controller
{
    public function index(){
        $common          = array();
        $common['title'] = "Time Slot";
        Session::put("TopMenu", "Product");
        Session::put("SubMenu", "Excursion");
        Session::put("SubSubMenu", "Time Slot");
    

        $get_option_time = ProductOptionTime::paginate(config('adminconfig.records_per_page'));
            
        return view('admin.settings.time_slot', compact('common', 'get_option_time'));
    }

    ///Add ProductOptionTime
    public function addTime(Request $request, $id = ""){
        $common = array();
        Session::put("TopMenu", "Product");
        Session::put("SubMenu", "Excursion");
        Session::put("SubSubMenu", "Time Slot");

        $common['title']              = translate("Add Time Slot");
        $common['button']             = translate("Save");
        $get_option_time              = getTableColumn('product_option_time');
       
        if ($request->isMethod('post')) {

            $req_fields = array();
            $req_fields['name.*']   = "required";

            $errormsg = [
                "name.*" => translate("Title"),
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

            // $request->request->add(['user_id' => Session::get('admin_id')]);
            if ($request->id != "") {
                $message  = translate("Update Successfully");
                $status   = "success";
                $data     = $request->except('id', '_token');
                $ProductOptionTime = ProductOptionTime::find($request->id);
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $data     = $request->except('_token');
                $ProductOptionTime = new ProductOptionTime();
            }

            $ProductOptionTime['title']                = $request->title;
            $ProductOptionTime['status']              = isset($request->status) ? 'Active' : 'Deactive';
          

            $ProductOptionTime->save();


            return redirect()->route('admin.time_slot')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id           = checkDecrypt($id);
            $common['title']      = "Edit Time Slot";
            $common['button']     = "Update";
            $get_option_time = ProductOptionTime::where('id', $id)->first();

            if (!$get_option_time) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.settings.add_time_slot', compact('common', 'get_option_time'));
    }
    
    public function delete($id){
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_option_time =  ProductOptionTime::find($id);
        if ($get_option_time) {
            $get_option_time->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }
}
