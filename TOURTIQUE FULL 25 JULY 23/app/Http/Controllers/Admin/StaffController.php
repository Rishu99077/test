<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    //  Staff List 
    public function index(Request $request)
    {
        $common = array();
        Session::put("TopMenu", "Staff");
        Session::put("SubMenu", "Staff");
        $common['title']             = "Staff";
        $get_staff = Admin::orderBy('id', 'asc')->where(['is_delete' => 0, 'role' => "Staff"])->paginate(config('adminconfig.records_per_page'));
        return view('admin.staff.index', compact('common', 'get_staff'));
    }

    // Store Staff
    public function store(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Staff");
        Session::put("SubMenu", "Staff");
        $common['title']      = "Add Staff";
        $common['button']     = "Save";
        $get_staff = getTableColumn('admin');

        if ($request->isMethod('post')) {

            $req_fields     = array();
            $req_fields['first_name']   = "required";
            $req_fields['last_name']   = "required";

            if ($request->id == "") {
                $req_fields['email']        = "required|unique:admin,email";
                $req_fields['password']   = "required";
            } else {
                $req_fields['email']        = "required|unique:admin,email," . $request->id;
                if (isset($request->chk_password)) {
                    $req_fields['password']   = "required";
                }
            }

            $errormsg = [
                "first_name"=> "First Name",
                "last_name"   => "Last Name",
                "email"        => "Email",
                "password" => "Password",
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
                $message  = "Update Successfully";
                $status   = "success";
                $Staff = Admin::find($request->id);
            } else {
                $message  = "Add Successfully";
                $status   = "success";
                $Staff = new Admin();
            }


            $Staff->first_name       = $request->first_name;
            $Staff->last_name        = $request->last_name;
            $Staff->email            = $request->email;
            $Staff->status           = $request->status;
            if ($request->id == "") {
                $Staff->added_by         = Session::get('admin_id');
            }
            if (isset($request->password)) {
                $Staff->password         = Hash::make($request->password);
                $Staff->decrypt_password = $request->password;
            }
            $Staff->role             = "Staff";
            $Staff->save();
            return redirect()->route('admin.staff')->withErrors([$status => $message]);
        }
        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id = checkDecrypt($id);
            $common['title']             = "Edit Staff";
            $common['button']            = "Update";
            $get_staff =  Admin::where('id', $id)->first();
            if (!$get_staff) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.staff.form', compact('common', 'get_staff'));
    }

    ///Delete Prodcuct
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_staff =  Admin::where(['id'=>$id,'role'=>"Staff"])->first();
        if ($get_staff) {
            $get_staff->is_delete = 1;
            $get_staff->save();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }
}
