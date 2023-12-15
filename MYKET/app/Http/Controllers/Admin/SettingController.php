<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\Models\Settings;

class SettingController
{
    //
    public function settings(Request $request)
    {
        $common = array();
        Session::put("TopMenu", "Settings");
        Session::put("SubMenu", "Settings");
        $common['title']             = "Settings";
        $common['button']            = "Update";

        $get_setting = Settings::whereNull('child_meta_title')->where('status', 'active')->orderby('sort', 'Asc')->get();
        foreach ($get_setting as $key => $value) {
            $get_settings[$value['meta_title']] = $value['content'];
        }

        // print_die($get_settings);

        if ($request->isMethod('post')) {

            // print_die($request->all());
            $req_fields                 = array();
            $req_fields['header_logo']  = "image|mimes:jpg,jpeg,png,gif";
            $req_fields['favicon']      = "image|mimes:jpg,jpeg,png,gif";
            $req_fields['footer_logo']  = "image|mimes:jpg,jpeg,png,gif";



            $errormsg = [
                "header_logo"      => "Header Logo",
                "favicon"          => "Favicon",
                "footer_logo"      => "Footer Logo",
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
            $rq_data = array();
            $rq_data = $request->except('_token');

            foreach ($rq_data as $key => $value) {
                $Settings =  Settings::where('meta_title', $key)->first();
                if ($Settings) {
                    if ($key == 'header_logo' || $key == 'favicon' || $key == 'footer_logo' || $key == 'nav_other_page_logo' || $key == 'login_backgound_image' || $key == 'login_logo_image' || $key == 'mail_logo') {
                        if ($request->hasFile($key)) {
                            $random_no  = uniqid();
                            $img = $request->file($key);
                            $ext = $img->getClientOriginalExtension();
                            $new_name = $random_no . '.' . $ext;
                            $destinationPath =  public_path('uploads/setting');
                            $img->move($destinationPath, $new_name);
                            $Settings->content = $new_name;
                        }
                    } else {
                        $Settings->content = $value;
                    }
                    $Settings->save();
                }
            }
            return back()->withErrors(["success" => "Update Successfully"]);
        }
        return view('admin.settings.setting', compact('common', 'get_settings'));
    }

    public function get_append_view(Request $request)
    {

        $data       = isset($request->params['data']) ? $request->params['data'] : "";
        $params_arr = isset($request->params) ? $request->params : "";
        $id = isset($request->params['id']) ? $request->params['id'] : "";
        $append = "1";
        return View::make($request->params['view'], compact('data', 'append', 'id', 'params_arr'))->render();
    }
}
