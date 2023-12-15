<?php


namespace App\Http\Controllers\Admin;
use App\Models\Admin;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;


class DashboardController
{
    //
    public function index(Request $request){
        $common = [];
        $common['title'] = 'Dashboard';
        $common['heading_title'] = 'Dashboard';

        Session::put("TopMenu", "Dashboard");
        Session::put("SubMenu", "Dashboard");

        return view('admin.dashboard',compact('common'));
    }

    public function profileUpdate(Request $request){
        $common = array();
        $common['main_menu']    = 'profile';
        $common['submain_menu'] = 'profile';
        $common['title']        = "Profile";
        $admin_id               = Session::get('em_admin_id');

        $get_admin              = Admin::where('id', $admin_id)->first();

        if ($request->isMethod('post')) {
            $req_filed                =   array();
            $req_filed['first_name']  =   "required";
            $req_filed['last_name']   =   "required";
            $validation = Validator::make($request->all(), $req_filed);
            if ($validation->fails()) {
                return back()->withErrors($validation)->withInput();
            }


            $message           = "Something went wrong";
            $status            = "error";
            $data              = $request->except('id', '_token');
            $Admin             = Admin::find($admin_id);

            if ($Admin) {
                $Admin->first_name = $request->first_name;
                $Admin->last_name  = $request->last_name;
                if ($request->hasFile('image')) {
                    $random_no  = uniqid();
                    $img = $request->file('image');
                    $ext = $img->getClientOriginalExtension();
                    $new_name = $random_no . '.' . $ext;
                    $destinationPath =  public_path('assets/uploads/admin_image');
                    $img->move($destinationPath, $new_name);
                    $Admin->image = $new_name;
                }
                $message           = "Update Successfully";
                $status            = "success";
                $Admin->save();
            }
            return back()->withErrors([$status => $message]);
        }
        return view('admin.settings.profile', compact('common', 'get_admin'));
    }

    public function change_password(Request $request){
        $common = array();
        $common['main_menu']    = 'profile';
        $common['submain_menu'] = 'profile';
        $common['title']        = "Change password";
        $admin_id               = Session::get('em_admin_id');

        $get_admin              = Admin::where('id', $admin_id)->first();

        if ($request->isMethod('post')){
          $validation = Validator::make($request->all(), [
              'current_password'    => 'required',
              'new_password'        => 'required',
              'confirm_password'    => 'required_with:new_password|same:new_password',
          ]);

          if ($validation->fails()) {
              return back()->withErrors($validation)->withInput();
          }


          $user_data = Admin::where(['id' => $admin_id ])->first();          
          if (Hash::check($request->current_password, $user_data->password)) {
              $UpdateData['password']     =  Hash::make($request->confirm_password);
              Admin::where(['id' => $admin_id])->update($UpdateData);
              $message           = "Password Update Successfully";
              $status            = "success";
          }else{
              $message           = "Password not match";
              $status            = "error";  
          }
          return back()->withErrors([$status => $message]);
        }
        return view('admin.settings.change_password',compact('common'));
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

