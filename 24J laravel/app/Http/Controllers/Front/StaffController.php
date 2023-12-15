<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Staff;
use App\Models\Users;
use App\Models\Country;


use Image;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use JeroenDesloovere\VCard\VCard;
use Illuminate\Support\Facades\Crypt;

class StaffController extends Controller
{

    public function index(){
        $common = array();
        $common['title'] = 'My Staff';
        $common['heading_title'] = 'My Staff';

        $user_id = Session::get('em_user_id');

        $staff_query = Users::where(['user_id' => $user_id]);
        if(isset($_GET['search']) && $_GET['search'] !=""){
            $staff_query->where('first_name', 'like', '%' . $_GET['search'] . '%');
        }
        $get_staffs = $staff_query->latest()->paginate(config('adminconfig.records_per_page'));
        return view('front.staff.index', compact('common','get_staffs'));
    }

    public function add_staff(Request $request, $id=''){
        $common = array();
        $common['title'] = 'My Staff';
        $common['heading_title'] = 'My Staff';

        $get_country = Country::all();
        $user_id = Session::get('em_user_id');

        $get_last_staff = Users::where(['user_id' => $user_id])->first();
        if($get_last_staff){
            $get_staff = array();
            $get_staff['id'] = '';
            $get_staff['first_name']    = '';
            $get_staff['last_name']     = '';
            $get_staff['designation']   = '';
            $get_staff['company_name']  = $get_last_staff->company_name;
            $get_staff['contact']       = $get_last_staff->contact;
            $get_staff['email']         = '';

            $get_staff['avatar_img_url'] = '';
            $get_staff['avatar_file']    = '';

            $get_staff['company_logo_url'] = '';
            $get_staff['company_logo']     = $get_last_staff->company_logo;

            $get_staff['address']        = $get_last_staff->address;
            $get_staff['town']           = $get_last_staff->town;
            $get_staff['country']        = $get_last_staff->country;

            $get_staff['facebook']       = $get_last_staff->facebook;
            $get_staff['instagram']      = $get_last_staff->instagram;
            $get_staff['twitter']        = $get_last_staff->twitter;
            $get_staff['whatsapp_url']   = $get_last_staff->whatsapp_url;
            $get_staff['linkedin']       = $get_last_staff->linkedin;
            $get_staff['google_plus_url'] = $get_last_staff->google_plus_url;

            $get_staff['google_map']           =  '';
            $get_staff['qr_color']             = '';
        }else{
            $get_staff = array();
            $get_staff['id']                 = '';
            $get_staff['avatar_img_url']     = '';
            $get_staff['avatar_file']        = '';
            $get_staff['company_logo_url']   = '';
            $get_staff['company_logo']       = '';
            $get_staff['first_name']         = '';
            $get_staff['last_name']          = '';

            $get_staff['designation'] = '';
            $get_staff['company_name'] = '';

            $get_staff['address']   = '';
            $get_staff['town']      = '';
            $get_staff['country']   = '';
            $get_staff['contact']   = '';
            $get_staff['email']     = '';

            $get_staff['facebook']      = '';
            $get_staff['instagram']     = '';
            $get_staff['twitter']       = '';
            $get_staff['whatsapp_url']  = '';
            $get_staff['linkedin']      = '';
            $get_staff['google_plus_url'] = '';
            
            $get_staff['google_map']      = '';
            $get_staff['qr_color']        = '';
        }

        if($request->isMethod('post')){

            $response_arr = array();
            $response_arr['error'] = true;

            $req_fields = array();
            $req_fields['first_name']   = 'required';
            $req_fields['last_name']    = 'required';
            $req_fields['company_name'] = 'required';
            $req_fields['designation']  = 'required';
            $req_fields['contact']      = 'required';
            $req_fields['email']        = 'required|email|unique:users';
            $req_fields['password']     = 'required';
            $req_fields['address']      = 'required';
            $req_fields['town']         = 'required';
            $req_fields['country']      = 'required';
            //$req_fields['avatar_file']   = 'required';

            /*if( $request->id == "" || $request->password_change != "" ){
                $req_fields['password'] = 'required';
            }*/

            $errormsg = array(
                'first_name'    => 'First Name',
                'last_name'     => 'Last Name',
                'company_name'  => 'Company name',
                'designation'   => 'Designation',
                'contact'       => 'contact',
                'email'         => 'Email',
                'password'      => 'Password',
                'address'       => 'address',
                'town'          => 'City',
                'country'       => 'Country',
            );

            $validator = Validator::make(
                $request->all(),
                $req_fields,
                $errormsg,
            );
            
            if($validator->fails()) {
               return response()->json(array('error'=>$validator->getMessageBag()->toArray()));
            } 
            
            if($request->is_update !=""){
                $message   = "Update Successfull";
                $Users     =  Users::find($request->id);
            }else{ 
                $message   = "Add Successfull";
                $Users     = new Users();
            }

            $Users->user_id             = $user_id;
            $Users->first_name          = $request->first_name;
            $Users->last_name           = $request->last_name;
            $Users->company_name        = $request->company_name;
            $Users->designation         = $request->designation;
            $Users->contact             = $request->contact;
            $Users->email               = $request->email;
            $Users->password            = Hash::make($request->password);

            $Users->address             = $request->address;
            $Users->town                = $request->town;
            $Users->country             = $request->country;
            $Users->status              = 1;
            $Users->source              = 'WEB';

            if ($request->hasFile('company_logo')) {
                $files = $request->file('company_logo');
                $random_no = Str::random(5);
                $newImage = time() . $random_no . '.' . $files->getClientOriginalExtension();
                $destinationPath = public_path('uploads/staff');
                $imgFile = Image::make($files->path());
                $height = $imgFile->height();
                $width = $imgFile->width();
                if ($width > 600) {
                    $imgFile->resize(792, 450, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                if ($height > 600) {
                    $imgFile->resize(792, 450, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                $imgFile->save($destinationPath . '/' . $newImage);
                $Users->company_logo = $newImage;
            }else{
                $Users->company_logo = $request->company_logo_url;
            }


            if($request->twitter != ''){
                $Users->twitter = isset($request->twitter) ? $request->twitter : '';
            }

            if($request->facebook != ''){
                $Users->facebook = isset($request->facebook) ? $request->facebook : '';
            }

            if($request->instagram != ''){
                $Users->instagram = isset($request->instagram) ? $request->instagram : '';
            }

            if($request->linkedin != ''){
                $Users->linkedin = isset($request->linkedin) ? $request->linkedin : '';
            }

            if($request->whatsapp_url != ''){
                $Users->whatsapp_url = isset($request->whatsapp_url) ? $request->whatsapp_url : '';
            }

            if($request->google_plus_url != ''){
                $Users->google_plus_url = isset($request->google_plus_url) ? $request->google_plus_url : '';
            }

            if($request->google_map != ''){
                $Users->google_map = isset($request->google_map) ? $request->google_map : '';
            }


            if ($request->hasFile('avatar_file')) {
                $files = $request->file('avatar_file');
                $random_no = Str::random(5);
                $newImage = time() . $random_no . '.' . $files->getClientOriginalExtension();
                $destinationPath = public_path('uploads/staff');
                $imgFile = Image::make($files->path());
                $height = $imgFile->height();
                $width = $imgFile->width();
                if ($width > 600) {
                    $imgFile->resize(792, 450, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                if ($height > 600) {
                    $imgFile->resize(792, 450, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                $destinationPath = public_path('uploads/staff');
                $imgFile->save($destinationPath . '/' . $newImage);
                $Users->avatar_file = $newImage;
            }else{
                $Users->avatar_file = $request->avatar_img_url;
            }

            if($request->get_status_type == 'draft'){
                $Users->is_download = 'draft';
                $response_arr['download'] = false;
            }

            $Users->save();
            if($Users->id){

                if($request->get_status_type == 'download'){
                    $response_arr['download'] = true;
                    $UpdateStaff     =  Users::find($Users->id);
                    if(@$UpdateStaff->qr_code != ''){

                        if(file_exists(public_path('uploads/staff/qrcode-images/'.$UpdateStaff->qr_code))){
                            unlink(public_path('uploads/staff/qrcode-images/'.$UpdateStaff->qr_code));
                        }
                    }
                    $encrypt_staff_id = encrypt($Users->id);
                    $rand_number_img = 'staff-'.$Users->id.'-'.bin2hex(random_bytes(6)).'.png';


                    if($UpdateStaff->company_logo){
                        $qrcode_with_company_logo = '/public/uploads/staff/'.$UpdateStaff->company_logo;
                    }else{
                        $qrcode_with_company_logo = '/public/frontassets/image/company-logo.png';
                    }

                    if($request->qr_color != ''){
                        $UpdateStaff->qr_color = $request->qr_color;
                        $r = hexdec(substr($request->qr_color, 1, 2));
                        $g = hexdec(substr($request->qr_color, 3, 2));
                        $b = hexdec(substr($request->qr_color, 5, 2));
                        QrCode::size(300)->format('png')->merge($qrcode_with_company_logo)->backgroundColor($r,$g,$b)->generate(url('staff'.'/'.$encrypt_staff_id), public_path('uploads/staff/qrcode-images/'.$rand_number_img));
                    }else{
                        QrCode::size(300)->format('png')->merge($qrcode_with_company_logo)->generate(url('staff'.'/'.$encrypt_staff_id), public_path('uploads/staff/qrcode-images/'.$rand_number_img));
                    }

                    $UpdateStaff->qr_code = $rand_number_img;
                    $UpdateStaff->is_download = 'download';
                    $UpdateStaff->save();

                    $response_arr['qr_code_name'] = 'qr-code-'.$Users->id;
                    $response_arr['qr_code_link'] = asset('uploads/staff/qrcode-images/' . $rand_number_img);
                }

                $response_arr['error'] = false;
                $response_arr['msg']   = $message;
            }
            $response_arr['url'] = url('/my_staff');
            return json_encode($response_arr);
        }

        if ($id != '') {
            $staff_id =  Crypt::decrypt($id);
            $get_staff = Users::where(['id' => $staff_id])->first();
        }

        return view('front.staff.form',compact('common','get_staff','get_country'));
    }

    public function card_design(Request $request, $id=''){

        if($request->isMethod('post')){

            $company_logo_flag = 1;
            $get_staff  = $request->all();

            $response_arr['render_view'] = view('front.staff.card_design', compact('get_staff'))->render();
            return response()->json($response_arr);
        }
    }

    public function delete($id){

        if (Crypt::decrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }

        $staff_id =  Crypt::decrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_staff =  Users::find($staff_id);
        if ($get_staff) {

            if($get_staff->is_download == 'download'){
                if(@$get_staff->qr_code != ''){
                    if(file_exists(public_path('uploads/staff/qrcode-images/'.$get_staff->qr_code))){
                       unlink(public_path('uploads/staff/qrcode-images/'.$get_staff->qr_code));
                    }
                }
            }

            $get_staff->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }

   
}
