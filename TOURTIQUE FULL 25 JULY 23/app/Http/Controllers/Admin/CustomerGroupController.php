<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

use App\Models\Language;
use App\Models\CustomerGroup;
use App\Models\CustomerGroupLanguage;

class CustomerGroupController extends Controller
{
    //
    public function index()
    {
        $common          = array();
        $common['title'] =  translate('Customer Group');
        Session::put("TopMenu", "Customer Group");
        Session::put("SubMenu", "Customer Group");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $user_id            = Session::get('admin_id');
        $date               = date('Y-m-d');

        $get_customer_group = CustomerGroup::select('customer_group.*','customer_group_language.title')
                                ->leftjoin("customer_group_language", 'customer_group.id', '=', 'customer_group_language.customer_group_id')
                                ->groupBy('customer_group.id')
                                ->orderBy('id', 'desc')
                                ->where(['is_delete' => 0])
                                ->paginate(config('adminconfig.records_per_page'));
                              
        return view('admin.customerGroup.index', compact('common', 'get_customer_group','lang_id'));
    }


    //Add Group
    public function addCustomerGroup(Request $request, $id = '')
    {
        $common = array();
        Session::put("TopMenu", "Customer Group");
        Session::put("SubMenu", "Customer Group");

        $common['title']               = translate("Add Customer Group");
        $common['button']              = translate("Save");
        $get_customer_group            = getTableColumn('customer_group');
        $get_customer_group_language   = "";
        $languages                     = Language::where(ConditionQuery())->get();

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        if ($request->isMethod('post')) {

            $req_fields = array();
            $req_fields['name.*']   = "required";

            $errormsg = [
                "title.*" => translate("Title"),
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
                $data     = $request->except('id', '_token', 'title');
                $CustomerGroup = CustomerGroup::find($request->id);
                CustomerGroupLanguage::where("customer_group_id", $request->id)->where('language_id',$lang_id)->delete();
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $data     = $request->except('_token', 'title');
                $CustomerGroup = new CustomerGroup();
            }

            foreach ($data as $key => $value) {
                $CustomerGroup->$key = $value;
            }
            $CustomerGroup->save();
            $last_insert_id = $CustomerGroup->id;

            $get_languages = Language::where(['status'=>'Active','is_delete'=>0])->get();
            if (!empty($get_languages)) {
                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('customer_group_language',['language_id'=>$value['id'],'customer_group_id'=> $request->id],'row')) {

                        $CustomerGroupLanguage              = new CustomerGroupLanguage();
                        
                        $CustomerGroupLanguage->title               = isset($request->title[$value['id']]) ?  $request->title[$value['id']] : $request->title[$lang_id];        
                        $CustomerGroupLanguage->language_id         = $value['id'];
                        $CustomerGroupLanguage->customer_group_id   = $last_insert_id;
                        $CustomerGroupLanguage->save();
                    }
                   
                }
            }
            return redirect()->route('admin.customerGroup')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => translate("No Record Found")]);
            }
            $id                          = checkDecrypt($id);
            $common['title']             = translate('Edit Customer Group');
            $common['button']            = translate('Update');
            $get_customer_group          = CustomerGroup::where('id', $id)->first();
            $get_customer_group_language = CustomerGroupLanguage::where("customer_group_id", $id)->get()->toArray();

            if (!$get_customer_group) {
                return back()->withErrors(["error" => translate('"Something went wrong"')]);
            }
        }
        return view('admin.customerGroup.addCustomerGroup', compact('common', 'get_customer_group','languages', 'get_customer_group_language','lang_id'));
    }


    ///Delete Customer Group
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id             = checkDecrypt($id);
        $status         = 'error';
        $message        = translate('Something went wrong!');
        $CustomerGroup  =  CustomerGroup::find($id);
        if ($CustomerGroup) {
            CustomerGroupLanguage::where('customer_group_id',$id)->delete();
            $CustomerGroup->delete();
            $status     = 'success';
            $message    = translate('Delete Successfully');
        }
        return back()->withErrors([$status => $message]);
    }
}
