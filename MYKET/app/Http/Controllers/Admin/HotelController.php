<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Hotels;
use App\Models\Hoteldescriptions;
use App\Models\User;

use App\Models\Countries;
use App\Models\States;
use App\Models\Cities;

use App\Models\Languages;
use Illuminate\Support\Str;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        $common          = array();
        $common['title'] = "Hotels";
        Session::put("TopMenu", translate("Accounts"));
        Session::put("SubMenu", translate("Hotels"));

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id              = $get_session_language['id'];


        // Filter
        if ($request->isMethod('post')) {
            if (isset($request->filter)) {
                Session::put('hotel_name', $request->hotel_name);
                Session::put('hotel_status', $request->hotel_status);
                Session::put('hotel_date', $request->hotel_date);
                Session::put('hotel_email', $request->hotel_email);
            } elseif (isset($request->reset)) {
                Session::put('hotel_name', '');
                Session::put('hotel_status', '');
                Session::put('hotel_date', '');
                Session::put('hotel_email', '');
            }
            return redirect()->route('admin.hotels');
        }


        $hotel_name   = Session::get('hotel_name');
        $hotel_status = Session::get('hotel_status');
        $hotel_date   = Session::get('hotel_date');
        $hotel_email   = Session::get('hotel_email');

        $common['hotel_name']   = $hotel_name;
        $common['hotel_status']  = $hotel_status;
        $common['hotel_date']   = $hotel_date;
        $common['hotel_email']   = $hotel_email;



        $get_hotels = User::select('users.*', 'hotel_descriptions.hotel_name')->where(['status' => 'Active', 'user_type' => 'Hotel'])
            ->leftJoin('hotel_descriptions', 'hotel_descriptions.hotel_id', '=', 'users.id')->orderBy('id', 'desc');


        if ($hotel_name) {
            $get_hotels = $get_hotels->where('hotel_descriptions.hotel_name', 'like', '%' . $hotel_name . '%');
        }



        if ($hotel_status) {
            $get_hotels = $get_hotels->where('status', $hotel_status);
        }

        if ($hotel_email) {
            $get_hotels = $get_hotels->where('email',  'like', '%' . $hotel_email . '%');
        }

        if ($hotel_date) {

            $getordersDate = explode('to', $hotel_date);
            $formdate = '';
            $todate = '';
            if (isset($getordersDate[0])) {
                $formdate = $getordersDate[0] . " 00:00:00";

                $get_hotels->whereDate('users.created_at', '>=', $formdate);
            }
            if (isset($getordersDate[1])) {
                $todate = $getordersDate[1] . " 23:59:59";
                $get_hotels->whereDate('users.created_at', '<=', $todate);
            }
        }


        $get_hotels_count = $get_hotels->count();
        $get_hotels = $get_hotels->paginate(config('adminconfig.records_per_page'));

        $Hotels = array();
        if (!empty($get_hotels)) {
            foreach ($get_hotels as $key => $value) {
                $row               = getLanguageData('hotel_descriptions', $language_id, $value['id'], 'hotel_id');
                $row['id']         = $value['id'];
                $row['hotel_owner_name'] = $value['first_name'];
                $row['hotel_owner_email'] = $value['email'];
                $row['comission']  = $value['hotel_commission'];
                $row['status']     = $value['status'];
                $Hotels[]          = $row;
            }
        }

        return view('admin.hotel.index', compact('common', 'get_hotels', 'Hotels', 'get_hotels_count'));
    }

    // Add hotel

    public function add_hotel(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", translate("Hotels"));
        Session::put("SubMenu", translate("Hotels"));

        $common['title']          = translate('Hotels');
        $common['heading_title']  = translate('Add Hotels');

        $common['button']       = translate("Save");
        $get_hotels             = getTableColumn('users');
        $get_hotels_language    = getTableColumn('hotel_descriptions');

        $Countries = Countries::where(['is_delete' => null])->get();
        $States = [];
        $Cities = [];

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id              = $get_session_language['id'];

        if ($request->isMethod('post')) {

            $req_fields                     = array();
            $req_fields['hotel_name']       = "required";
            $req_fields['hotel_owner_name'] = "required";
            $req_fields['comission']        = "required";

            if ($request->id == '') {
                $req_fields['password']           = "required";
                $req_fields['confirm_password']   = "required|same:password";
                $req_fields['email']              = "required|email|unique:users";
            }



            $errormsg = [
                "hotel_name"       => translate("Title"),
                "hotel_owner_name" => translate("Hotel owner name"),
                "comission"        => translate("Comission"),
                "email"            => translate("Email"),
                "password"         => translate("Password"),
                "confirm_password" => translate("Confirm Password"),

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
                $message   = translate("Update Successfully");
                $status    = "success";
                $Hotels    = User::find($request->id);
            } else {
                $message   = translate("Add Successfully");
                $status    = "success";
                $Hotels    = new User();
                $Hotels->slug = createSlug('users', $request->hotel_name);
                $Hotels->password         = Hash::make($request->password);
                $Hotels->decrypt_password = $request->password;
            }

            $Hotels->first_name       = $request->hotel_owner_name;
            $Hotels->country          = $request->country;
            $Hotels->state            = $request->state;
            $Hotels->city             = $request->city;
            $Hotels->hotel_commission = $request->comission;
            $Hotels->status           = $request->status;
            $Hotels->email            = $request->email;
            $Hotels->user_type        = 'Hotel';

            $Hotels->save();

            Hoteldescriptions::where(["hotel_id" => $Hotels->id, 'language_id' => $language_id])->delete();
            if (isset($request->hotel_name)) {
                $Hoteldescriptions                = new Hoteldescriptions();
                $Hoteldescriptions->hotel_name    = $request->hotel_name;
                $Hoteldescriptions->language_id   = $language_id;
                $Hoteldescriptions->hotel_id      = $Hotels->id;
                $Hoteldescriptions->save();
            }
            return redirect()->route('admin.hotels')->withErrors([$status => $message]);
        }
        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                         = checkDecrypt($id);
            $common['title']            = translate("Edit Hotels");
            $common['heading_title']    = translate("Edit Hotels");
            $common['button']           = translate("Update");

            $get_hotels = User::where('id', $id)->first();

            if ($get_hotels->country != "") {
                $States = States::where('country_id', $get_hotels->country)->get();
                if ($get_hotels->state != "") {
                    $Cities = Cities::where('state_id', $get_hotels->state)->get();
                }
            }

            $get_hotels_language  = getLanguageData('hotel_descriptions', $language_id, $id, 'hotel_id');

            if (!$get_hotels) {
                return back()->withErrors(["error" => translate("Something went wrong")]);
            }
        }
        return view('admin.hotel.add_hotel', compact('common', 'get_hotels', 'get_hotels_language', 'Countries', 'States', 'Cities'));
    }


    // Delete Hotels
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => translate("No Record Found")]);
        }
        $id = checkDecrypt($id);
        $status       = 'error';
        $message      = translate('Something went wrong!');
        $get_hotels =  User::where(['id' => $id])->first();
        if ($get_hotels) {
            $get_hotels->is_delete = 1;
            $get_hotels->save();
        }
        $status  = 'success';
        $message = translate('Delete Successfully');
        return back()->withErrors([$status => $message]);
    }
}
