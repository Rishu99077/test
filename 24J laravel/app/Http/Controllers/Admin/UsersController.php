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


class UsersController{

	public function index(Request $request){
        $common = [];
        $common['title'] = 'Users';
        $common['heading_title'] = 'Users';

        Session::put("TopMenu", "Users");
        Session::put("SubMenu", "Users");

        $get_users = [];
        $get_users = Users::orderBy('id', 'desc')->paginate(config('adminconfig.records_per_page'));

        return view('admin.users.index',compact('common','get_users'));
    }


     ///Add User
    public function add_user(Request $request, $id = ''){
        $common = [];
        $common['title'] = 'Users';
        $common['heading_title'] = 'Add Users';
        $common['button']       = 'Save';

        Session::put('TopMenu', 'Users');
        Session::put('SubMenu', 'Users');

        $get_user = getTableColumn('users');
  
        
        if ($request->isMethod('post')) {

            $req_fields          = [];
            $req_fields['first_name'] = 'required';
       
            $errormsg = [
                'first_name' => 'Title',
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
                $message   = 'Update Successfully';
                $status    = 'success';
                $Users     = Users::find($request->id);
            } else {
                $message = 'Add Successfully';
                $status  = 'success';
                $Users   = new Users();
            }

            $Users['prefix']            = $request->prefix;
            $Users['first_name']        = $request->first_name;
            $Users['last_name']         = $request->last_name;
            $Users['email']       		= $request->email;

            // $Users['password']       	= $request->password;
            $Users['company_name']      = $request->company_name;
            $Users['designation']      	= $request->designation;
            $Users['contact']       	= $request->contact;

            $Users['address']       	= $request->address;
            $Users['country']      		= $request->country;
            $Users['country_name']      = $request->country_name;
            $Users['town']       		= $request->town;

            $Users['create_group']      = $request->create_group;            
            $Users['status']            = $request->status;

            if ($request->hasFile('image')) {
                $image                  = $request->file('image');
                $random_no              = Str::random(5);
                $newImage               = time() . $random_no . '.' . $image->getClientOriginalExtension();
                $destinationPath        = public_path('uploads/users');
                $imgFile                = Image::make($image->path());
            
                $destinationPath = public_path('uploads/users');
                $imgFile->save($destinationPath . '/' . $newImage);
                $Users['image'] = $newImage;
            }

            $Users->save();

            return redirect()
                ->route('admin.users')
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
           
            $common['title'] = 'Users';
            $common['heading_title'] = 'Edit Users';
            $common['button'] = 'Update';

            $get_user = Users::where('id', $id)->first();

            if (!$get_user) {
                return back()->withErrors(['error' => 'Something went wrong']);
            }
        }
        return view('admin.users.add_user', compact('common','get_user'));
    }

    public function delete($id)
    {
        
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_plan =  Users::find($id);
        if ($get_plan) {
            $get_plan->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }

}
