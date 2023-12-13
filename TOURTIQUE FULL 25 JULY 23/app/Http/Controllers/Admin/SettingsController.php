<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;

use App\Models\Country;
use App\Models\States;
use App\Models\City;

use App\Models\ContactSetting;
use App\Models\ContactSettingLanguage;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

use App\Models\Language;
use App\Models\BoatLocations;
use App\Models\BoatTypes;

use App\Models\SocialMedia;
use App\Models\SocialMediaLinks;

use App\Models\AdvertismentBanner;
use App\Models\MetaGlobalLanguage;
use App\Models\Notification;


class SettingsController extends Controller
{
    //
    public function settings(Request $request)
    {
        $common = array();
        Session::put("TopMenu", "Settings");
        Session::put("SubMenu", "Settings");
        $common['title']             = "Settings";
        $common['button']            = "Update";

        $get_setting = Settings::whereNull('child_meta_title')->where('status','active')->orderby('sort', 'Asc')->get();
        foreach ($get_setting as $key => $value) {
            $get_settings[$value['meta_title']] = $value['content'];
        }
        // print_die($get_settings);

        if ($request->isMethod('post')) {

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
                    if ($key == 'header_logo' || $key == 'favicon' || $key == 'footer_logo' || $key == 'nav_other_page_logo') {
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

    ///PageSettings
    public function page_setting(Request $request, $id = '')
    {
        $common = array();
        $common['main_menu']         = 'page_setting';
        $common['submain_menu']      = 'page_setting';
        $common['title']             = "Section Settings";
        $common['button']            = "Update";
        $get_contact_us              = array();
        $get_contact                 = array();
        $get_setting                 = array();
        $get_hows_its_work           = array();

        $get_setting_list = Settings::where('child_meta_title', '!=', '')->where('status', 'active')->groupBy('meta_title')->orderby('id', 'desc')->paginate(10);

        if ($id != "") {
            $get_main_setting = Settings::where('meta_title', $id)->where('child_meta_title', 'main')->first();
            if ($get_main_setting) {
                $get_main                           = array();
                $get_main['title']                  = $get_main_setting['title'];
                $get_main['content']                = $get_main_setting['content'];
                $get_main['file']                   = $get_main_setting['file'];
                $get_main['image']                  = $get_main_setting['image'];
                $get_main['banner_image']           = $get_main_setting['banner_image'];
                $get_main['child_meta_title']       = $get_main_setting['child_meta_title'];
                $get_main['meta_title']             = $get_main_setting['meta_title'];
                $get_main['sections']               = array();

                $get_contact_us = Settings::where('meta_title', $id)->where('child_meta_title', '!=', 'main')->get();
                foreach ($get_contact_us as $key => $value) {
                    // code...
                    $get_column                           = array();
                    $get_column['title']                  = $value['title'];
                    $get_column['content']                = $value['content'];
                    $get_column['file']                   = $value['file'];
                    $get_column['child_meta_title']       = $value['child_meta_title'];
                    $get_column['meta_title']             = $value['meta_title'];


                    $get_main['sections'][]             =  $get_column;
                }
            }
            return view('admin.settings.section_setting.edit_section', compact('common', 'id', 'get_contact', 'get_setting', 'get_hows_its_work', 'get_main'));
        }


        if ($request->isMethod('post')) {


            $meta_title     = $request->id;
            $req_data       = $request->except('id', '_token');


            foreach ($req_data as $key => $value) {
                // code...
                // print_die($value);
                $Settings = Settings::where('meta_title', $meta_title)->where('child_meta_title', $key)->first();
                if ($Settings) {
                    if (array_key_exists("file", $value) || array_key_exists("image", $value) || array_key_exists("banner_image", $value)) {
                        if ($request->hasFile($key . '.file')) {
                            $random_no  = uniqid();

                            $img = $request->file($key . '.file');

                            $ext = $img->getClientOriginalExtension();
                            $new_name = $random_no . '.' . $ext;
                            $destinationPath =  public_path('uploads/setting');
                            $img->move($destinationPath, $new_name);
                            $Settings->file = $new_name;
                        }
                    }
                    if (array_key_exists("image", $value) || array_key_exists("banner_image", $value)) {
                        if ($request->hasFile($key . '.image')) {
                            $random_no  = uniqid();

                            $img = $request->file($key . '.image');

                            $ext = $img->getClientOriginalExtension();
                            $new_name = $random_no . '.' . $ext;
                            $destinationPath =  public_path('uploads/setting');
                            $img->move($destinationPath, $new_name);
                            $Settings->image = $new_name;
                        }
                    }
                    if (array_key_exists("banner_image", $value)) {
                        if ($request->hasFile($key . '.banner_image')) {
                            $random_no  = uniqid();

                            $img = $request->file($key . '.banner_image');

                            $ext = $img->getClientOriginalExtension();
                            $new_name = $random_no . '.' . $ext;
                            $destinationPath =  public_path('uploads/setting');
                            $img->move($destinationPath, $new_name);
                            $Settings->banner_image = $new_name;
                        }
                    }

                    if (array_key_exists("content", $value)) {
                        $Settings->content = $value['content'];
                    }
                    if (array_key_exists("title", $value)) {
                        $Settings->title   = $value['title'];
                    }
                    $Settings->update();
                }
            }


            return redirect()->route('admin.page_setting')->withErrors(["success" => "Update Successfully"]);
        }

        return view('admin.settings.section_setting.section_list', compact('common', 'id', 'get_setting_list'));
    }

    public function get_append_view(Request $request)
    {

        $data       = isset($request->params['data']) ? $request->params['data'] : "";
        $params_arr = isset($request->params) ? $request->params : "";
        $id = isset($request->params['id']) ? $request->params['id'] : "";
        $append = "1";
        return View::make($request->params['view'], compact('data', 'append', 'id', 'params_arr'))->render();
    }


    // Countries -----------------------------------------------------------------------

    public function countries()
    {
        $common          = array();
        $common['title'] = "Countries";
        Session::put("TopMenu", "Settings");
        Session::put("SubMenu", "Countries");

        $get_country = Country::paginate(config('adminconfig.records_per_page'));

        return view('admin.Countries.index', compact('common', 'get_country'));
    }

    ///Add Countries
    public function add_countries(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Settings");
        Session::put("SubMenu", "Countries");

        $common['title']     = translate("Add Country");
        $common['button']    = translate("Save");

        $get_country       = getTableColumn('countries');

        if ($request->isMethod('post')) {
            $req_fields = [];

            $req_fields['name']         = "required";
            $req_fields['sortname']     = "required";
            $req_fields['phonecode']    = "required";


            $errormsg = [
                "name"      => translate("Country"),
                "sortname"  => translate("Short name"),
                "phonecode" => translate("Phone Code"),
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

            // if ($validation->fails()) {
            //     return response()->json(['error' => $validation->getMessageBag()->toArray()]);
            // }

            if ($request->id != "") {
                $message  = translate("Update Successfully");
                $status   = "success";
                $Country    = Country::find($request->id);
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $Country    = new Country();
            }

            $Country['name']             = $request->name;
            $Country['sortname']         = $request->sortname;
            $Country['phonecode']        = $request->phonecode;

            $Country->save();

            return redirect()->route('admin.countries')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                   = checkDecrypt($id);
            $common['title']      = "Edit Country";
            $common['button']     = "Update";
            $get_country          = Country::where('id', $id)->first();

            if (!$get_country) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }


        return view('admin.Countries.add_country', compact('common', 'get_country'));
    }

    public function delete_countries($id)
    {

        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);

        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_country =  Country::find($id);
        if ($get_country) {
            $get_country->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }


    // States ----------------------------------------------------------------------------

    public function states()
    {
        $common          = array();
        $common['title'] = "States";
        Session::put("TopMenu", "Settings");
        Session::put("SubMenu", "States");

        $get_state = States::paginate(config('adminconfig.records_per_page'));

        return view('admin.States.index', compact('common', 'get_state'));
    }

    ///Add States
    public function add_states(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Settings");
        Session::put("SubMenu", "States");

        $common['title']     = translate("Add State");
        $common['button']    = translate("Save");

        $get_state         = getTableColumn('states');
        $country           = Country::all();



        if ($request->isMethod('post')) {
            $req_fields = [];

            $req_fields['country']      = "required";
            $req_fields['name']         = "required";


            $errormsg = [
                "country"   => translate("Country"),
                "name"      => translate("State"),
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
                $States    = States::find($request->id);
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $States    = new States();
            }

            $States['name']             = $request->name;
            $States['country_id']       = $request->country;

            $States->save();

            return redirect()->route('admin.states')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                   = checkDecrypt($id);
            $common['title']      = "Edit States";
            $common['button']     = "Update";
            $get_state            = States::where('id', $id)->first();


            if (!$get_state) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }


        return view('admin.States.add_state', compact('common', 'get_state', 'country'));
    }

    public function delete_states($id)
    {

        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);

        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_state   =  States::find($id);
        if ($get_state) {
            $get_state->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }



    // CITY -----------------------------------------------------------------------------

    public function cities()
    {
        $common          = array();
        $common['title'] = "Cities";
        Session::put("TopMenu", "Settings");
        Session::put("SubMenu", "Cities");

        $country  = Country::all();

        $Country = @$_GET['country'];
        $State   = @$_GET['state'];
        $Cities  = @$_GET['city'];

        $City = City::select('cities.*', 'states.name as state_name', 'countries.name as country_name')
            ->join("states", 'cities.state_id', '=', 'states.id')
            ->join("countries", 'states.country_id', '=', 'countries.id');

        if (@$_GET['country']) {
            $City = $City->where('countries.id', $Country);
        }

        if (@$_GET['state']) {
            $City = $City->where('states.id', $State);
        }

        if (@$_GET['city']) {
            $City = $City->where('cities.id', $Cities);
        }


        $get_city  =  $City->paginate(config('adminconfig.records_per_page'));

        return view('admin.Cities.index', compact('common', 'get_city', 'country'));
    }

    ///Add Cities
    public function add_cities(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Settings");
        Session::put("SubMenu", "Cities");

        $common['title']     = translate("Add City");
        $common['button']    = translate("Save");

        $get_city       = getTableColumn('cities');
        $country        = Country::all();

        if ($request->isMethod('post')) {
            $req_fields = [];

            $req_fields['name']      = "required";
            $req_fields['country']   = "required";
            $req_fields['state']     = "required";


            $errormsg = [
                "name"      => translate("City"),
                "country"   => translate("Country"),
                "state"     => translate("State"),
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
                $City     = City::find($request->id);
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $City     = new City();
            }

            $City['state_id']         = $request->state;
            $City['name']             = $request->name;

            $City->save();

            return redirect()->route('admin.cities')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                   = checkDecrypt($id);
            $common['title']      = "Edit City";
            $common['button']     = "Update";
            $get_city_details     = City::where('id', $id)->first();

            $get_state            = States::where('id', $get_city_details['state_id'])->first();
            $get_country          = Country::where('id', $get_state['country_id'])->first();

            $get_city = array();
            $get_city['id']         = $get_city_details['id'];
            $get_city['name']       = $get_city_details['name'];
            $get_city['state_id']   = $get_city_details['state_id'];
            $get_city['country']    = $get_country['id'];


            // echo "<pre>"; 
            //   print_r($get_city);
            //   echo "</pre>";die();

            if (!$get_city) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }


        return view('admin.Cities.add_city', compact('common', 'get_city', 'country'));
    }

    public function delete_cities($id)
    {

        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);

        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_city =  City::find($id);
        if ($get_city) {
            $get_city->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }


    // CONTACT SETTING -----------------------------------------------------------------

    public function add_contact_setting(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Settings");
        Session::put("SubMenu", "Contact setting");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $common['title']              = translate("Add Contact setting");
        $common['button']             = translate("Save");
        $get_contact_setting          = getTableColumn('contact_setting');
        $get_contact_setting_language = "";

        $languages             = Language::where(ConditionQuery())->get();

        //        echo "<pre>"; 
        // print_r($request->all());
        // echo "</pre>";die();

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

            if ($request->id != "") {
                $message  = translate("Update Successfully");
                $status   = "success";
                $ContactSetting = ContactSetting::find($request->id);
                ContactSettingLanguage::where(["contact_setting_id"=> $request->id , 'language_id' => $lang_id])->delete();
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $ContactSetting = new ContactSetting();
            }

            $ContactSetting['contact_number_1']         = $request->contact_number_1;
            $ContactSetting['contact_number_2']         = $request->contact_number_2;
            $ContactSetting['whatsapp_number_1']        = $request->whatsapp_number_1;
            $ContactSetting['whatsapp_number_2']        = $request->whatsapp_number_2;
            $ContactSetting['email_address_1']          = $request->email_address_1;
            $ContactSetting['email_address_2']          = $request->email_address_2;
            $ContactSetting['status']                   = isset($request->status)  ? "Active" : "Deactive";

            $ContactSetting->save();

            if (!empty($request->description)) {
                foreach ($request->description as $key => $value) {

                    $ContactSettingLanguage              = new ContactSettingLanguage();
                    if ($value != "") {
                        $ContactSettingLanguage->description            = change_str($value);
                        $ContactSettingLanguage->address                = change_str($request->address[$key]);
                        $ContactSettingLanguage->language_id            = $key;
                        $ContactSettingLanguage->contact_setting_id     = $ContactSetting->id;
                        $ContactSettingLanguage->save();
                    }
                }
            }

            ///why_book_with_us Heading
            if (!empty($request->why_book_with_us)) {
                MetaGlobalLanguage::where(['meta_parent'=>'why_book_with_us_heading','language_id' => $lang_id])->delete();
                foreach ($request->why_book_with_us as $key => $value) {
                    $MetaGlobalLanguage = new MetaGlobalLanguage();
                    if ($value != '') {
                        $MetaGlobalLanguage->meta_parent = 'why_book_with_us_heading';
                        $MetaGlobalLanguage->meta_title  = 'heading_title';
                        $MetaGlobalLanguage->title       = $request->why_book_with_us[$key];

                        $MetaGlobalLanguage->language_id = $key;
                        $MetaGlobalLanguage->status      = 'Active';
                        $MetaGlobalLanguage->save();
                    }
                }
            }

            ///need_help_contact_heading Heading
            if (!empty($request->need_help_contact_heading)) {
                MetaGlobalLanguage::where(['meta_parent'=>'need_help_contact_heading','language_id' => $lang_id])->delete();
                foreach ($request->need_help_contact_heading as $key => $value) {
                    $MetaGlobalLanguage = new MetaGlobalLanguage();
                    if ($value != '') {
                        $MetaGlobalLanguage->meta_parent = 'need_help_contact_heading';
                        $MetaGlobalLanguage->meta_title  = 'heading_title';
                        $MetaGlobalLanguage->title       = $request->need_help_contact_heading[$key];
                        // $MetaGlobalLanguage->product_id  = $product_id;
                        $MetaGlobalLanguage->language_id = $key;
                        $MetaGlobalLanguage->status      = 'Active';
                        $MetaGlobalLanguage->save();
                    }
                }
            }



            return redirect()
                ->route('admin.contact_setting.edit', encrypt(1))
                ->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id           = checkDecrypt($id);
            $common['title']      = "Edit Contact setting";
            $common['button']     = "Update";
            $get_contact_setting = ContactSetting::where('id', $id)->first();
            $get_contact_setting_language = ContactSettingLanguage::where("contact_setting_id", $id)->get();
            $why_book_with_us_heading = MetaGlobalLanguage::where('meta_parent', 'why_book_with_us_heading')->get();
            $need_help_contact_heading = MetaGlobalLanguage::where('meta_parent', 'need_help_contact_heading')->get();

            if (!$get_contact_setting) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.Contact_setting.add_contact', compact(
            'common',
            'get_contact_setting',
            'languages',
            'get_contact_setting_language',
            'why_book_with_us_heading',
            'need_help_contact_heading',
            'lang_id'
        ));
    }


    // Boat Boat Locations -----------------------------------------------------------------------

    public function boat_locations()
    {
        $common          = array();
        $common['title'] = "Boat Locations";
        Session::put("TopMenu", "Product");
        Session::put("SubMenu", "Yacht");
        Session::put("SubSubMenu", "Boat Locations");
        $get_boat_locations = BoatLocations::where('type', 'yacht')->paginate(config('adminconfig.records_per_page'));
        return view('admin.boat_locations.index', compact('common', 'get_boat_locations'));
    }

    ///Add Boat Locations
    public function add_boat_locations(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Product");
        Session::put("SubMenu", "Yacht");
        Session::put("SubSubMenu", "Boat Locations");

        $common['title']     = translate("Add Boat Location");
        $common['button']    = translate("Save");

        $get_boat_locations       = getTableColumn('boat_locations');

        if ($request->isMethod('post')) {
            $req_fields = [];

            $req_fields['boat_location']  = "required";

            $errormsg = [
                "boat_location"      => translate("Boat Location"),
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

            // if ($validation->fails()) {
            //     return response()->json(['error' => $validation->getMessageBag()->toArray()]);
            // }

            if ($request->id != "") {
                $message  = translate("Update Successfully");
                $status   = "success";
                $BoatLocations    = BoatLocations::find($request->id);
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $BoatLocations    = new BoatLocations();
            }

            $BoatLocations['boat_location']   = $request->boat_location;
            $BoatLocations['type']            = "yacht";
            $BoatLocations['status']          = isset($request->status) ? 'Active' : 'Deactive';

            $BoatLocations->save();
            return redirect()->route('admin.boat_locations')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                   = checkDecrypt($id);
            $common['title']      = "Edit Boat Locations";
            $common['button']     = "Update";
            $get_boat_locations          = BoatLocations::where('type', 'yacht')->where('id', $id)->first();

            if (!$get_boat_locations) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }


        return view('admin.boat_locations.add_boat_location', compact('common', 'get_boat_locations'));
    }

    public function delete_boat_locations($id)
    {

        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);

        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_boat_locations =  BoatLocations::where('id', $id)->where('type', 'yacht')->first();
        if ($get_boat_locations) {
            $get_boat_locations->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }



    // Boat Types -----------------------------------------------------------------------

    public function boat_types()
    {
        $common          = array();
        $common['title'] = "Boat Types";
        Session::put("TopMenu", "Product");
        Session::put("SubMenu", "Yacht");
        Session::put("SubSubMenu", "Boat Types");

        $get_boat_types = BoatTypes::where('type', 'yacht')->paginate(config('adminconfig.records_per_page'));

        return view('admin.boat_types.index', compact('common', 'get_boat_types'));
    }

    ///Add Countries
    public function add_boat_types(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Product");
        Session::put("SubMenu", "Yacht");
        Session::put("SubSubMenu", "Boat Types");

        $common['title']     = translate("Add Boat Types");
        $common['button']    = translate("Save");

        $get_boat_types       = getTableColumn('boat_types');

        if ($request->isMethod('post')) {
            $req_fields = [];

            $req_fields['boat_type']  = "required";


            $errormsg = [
                "boat_type"      => translate("Boat Types"),
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

            // if ($validation->fails()) {
            //     return response()->json(['error' => $validation->getMessageBag()->toArray()]);
            // }

            if ($request->id != "") {
                $message   = translate("Update Successfully");
                $status    = "success";
                $BoatTypes = BoatTypes::find($request->id);
            } else {
                $message   = translate("Add Successfully");
                $status    = "success";
                $BoatTypes = new BoatTypes();
            }
            $BoatTypes['boat_type']   = $request->boat_type;
            $BoatTypes['type']        = "yacht";
            $BoatTypes['status']      = isset($request->status) ? 'Active' : 'Deactive';

            $BoatTypes->save();

            return redirect()->route('admin.boat_types')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                   = checkDecrypt($id);
            $common['title']      = "Edit Boat Types";
            $common['button']     = "Update";
            $get_boat_types          = BoatTypes::where('type', 'yacht')->where('id', $id)->first();

            if (!$get_boat_types) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }


        return view('admin.boat_types.add_boat_type', compact('common', 'get_boat_types'));
    }

    public function delete_boat_types($id)
    {

        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);

        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_boat_types =  BoatTypes::where('id', $id)->where('type', 'yacht')->first();
        if ($get_boat_types) {
            $get_boat_types->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }


    // SOCIAL MEDIA LINKS

    ///Add Social media 
    public function addSocialMedia(Request $request, $id = '')
    {
        $common = [];
        Session::put('TopMenu', 'Settings');
        Session::put('SubMenu', 'Social Media Links');

        $common['title'] = translate('Add Social Media Links');
        $common['button'] = translate('Save');

        $get_social_media = getTableColumn('social_media');

        $languages = Language::where(ConditionQuery())->get();
        $country   = Country::all();

        $get_social_media_links = [];

        $SML = getTableColumn('social_media_links');


        if ($request->isMethod('post')) {
            // echo "<pre>";
            // print_r($request->all());
            // echo "</pre>";die();

            $req_fields = [];
            $req_fields['title.*'] = 'required';

            $errormsg = [
                'title.*' => translate('Title'),
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
                $SocialMedia = SocialMedia::find($request->id);

                if (isset($request->link_id)) {
                    $get_soccial = SocialMediaLinks::where('social_media_id', $request->id)->get();
                    foreach ($get_soccial as $key => $val_vou) {
                        if (!in_array($val_vou['id'], $request->link_id)) {
                            SocialMediaLinks::where('id', $val_vou['id'])->delete();
                        }
                    }
                }
            } else {
                $message = translate('Add Successfully');
                $status = 'success';
                $SocialMedia = new SocialMedia();
            }

            $SocialMedia['copyright_title'] = $request->copyright_title;
            $SocialMedia['status']          = 'Active';

            $SocialMedia->save();

            $social_media_id = $SocialMedia->id;

            if ($request->link) {

                foreach ($request->link_id as $key => $value_2) {
                    if ($value_2 != '') {
                        $SocialMediaLinks = SocialMediaLinks::find($value_2);
                    } else {
                        $SocialMediaLinks = new SocialMediaLinks();
                    }

                    if ($request->hasFile('media_icon')) {
                        if (isset($request->media_icon[$key]) && $request->media_icon[$key] != '') {
                            $files = $request->file('media_icon')[$key];
                            $random_no = uniqid();
                            $img = $files;
                            $ext = $files->getClientOriginalExtension();
                            $new_name = $random_no . time() . '.' . $ext;
                            $destinationPath = public_path('uploads/setting');
                            $img->move($destinationPath, $new_name);
                            $SocialMediaLinks['media_icon'] = $new_name;
                        }
                    }

                    $SocialMediaLinks['media_status']    = $request->media_status[$key];
                    $SocialMediaLinks['social_media_id'] = $social_media_id;
                    $SocialMediaLinks['link']            = $request->link[$key];
                    $SocialMediaLinks->save();
                }
            }

            return redirect()
                ->route('admin.social_media.edit', encrypt(1))
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'No Record Found']);
            }
            $id = checkDecrypt($id);
            $common['title']  = 'Edit Social Media Links';
            $common['button'] = 'Update';

            $get_social_media = SocialMedia::where('id', $id)->first();

            $get_social_media_links = SocialMediaLinks::where('social_media_id', $id)->get();

            if (!$get_social_media) {
                return back()->withErrors(['error' => 'Something went wrong']);
            }
        }
        return view('admin.settings.addSocialMedia', compact('common', 'get_social_media', 'languages', 'get_social_media_links', 'SML', 'country'));
    }

    // Advertsiment banner

    ///Add ADV banner
    public function addAdvertisment(Request $request, $id = '')
    {
        $common = [];
        Session::put('TopMenu', 'Settings');
        Session::put('SubMenu', 'Advertisment Banner');

        $common['title']  = translate('Add Advertisment Banner');
        $common['button'] = translate('Save');
        $languages                      = Language::where(ConditionQuery())->get();
        $get_advertisment_banner        = getTableColumn('advertisment_banner');
        $get_languge_title              = MetaGlobalLanguage::where('meta_parent', 'home_page_popup')->where('meta_title', 'heading_title')->get();

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];


        if ($request->isMethod('post')) {
            // echo "<pre>";
            // print_r($request->all());
            // echo "</pre>";die();

            $req_fields = [];
            $req_fields['title.*'] = 'required';

            $errormsg = [
                'title.*' => translate('Title'),
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
                $AdvertismentBanner = AdvertismentBanner::find($request->id);
            } else {
                $message = translate('Add Successfully');
                $status = 'success';
                $AdvertismentBanner = new AdvertismentBanner();
            }

            if ($request->title) {
                if (!empty($request->title)) {
                    MetaGlobalLanguage::where('meta_parent', 'home_page_popup')->where('meta_title', 'heading_title')->where('language_id',$lang_id)->delete();
                    foreach ($request->title as $key2 => $value2) {
                        $MetaGlobalLanguage = new MetaGlobalLanguage();
                        if ($value2 != '') {
                            $MetaGlobalLanguage->meta_parent = 'home_page_popup';
                            $MetaGlobalLanguage->meta_title  = 'heading_title';
                            $MetaGlobalLanguage->title       = $request->title[$key2];
                            $MetaGlobalLanguage->language_id = $key2;
                            $MetaGlobalLanguage->status      = 'Active';
                            $MetaGlobalLanguage->save();
                        }
                    }
                }
            }

            $AdvertismentBanner['link']       = $request->link;

            $AdvertismentBanner['start_date'] = $request->start_date;
            $AdvertismentBanner['end_date']   = $request->end_date;
            $AdvertismentBanner['status']     = $request->status;
            $AdvertismentBanner['video_link'] = $request->video_link;

            if ($request->hasFile('image')) {
                if (isset($request->image) && $request->image != '') {
                    $files     = $request->file('image');
                    $random_no = uniqid();
                    $img       = $files;
                    $ext       = $files->getClientOriginalExtension();
                    $new_name  = $random_no . time() . '.' . $ext;
                    $destinationPath = public_path('uploads/setting');
                    $img->move($destinationPath, $new_name);
                    $AdvertismentBanner['image'] = $new_name;
                }
            }

            $AdvertismentBanner->save();

            return redirect()
                ->route('admin.advertisment_banner.edit', encrypt(1))
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'No Record Found']);
            }
            $id = checkDecrypt($id);
            $common['title'] = 'Edit Advertisment Banner';
            $common['button'] = 'Update';

            $get_advertisment_banner = AdvertismentBanner::where('id', $id)->first();

            if (!$get_advertisment_banner) {
                return back()->withErrors(['error' => 'Something went wrong']);
            }
        }
        return view('admin.settings.addAdvertisment', compact('common', 'get_advertisment_banner', 'languages', 'get_languge_title','lang_id'));
    }



    //Send Notifcatin
    public function send_notification(Request $request){
        $common = [];
        Session::put('TopMenu', 'Settings');
        Session::put('SubMenu', 'Send Notification');

        $common['title']  = translate('Send Notification');
        $common['button'] = translate('Send');
        $id               = encrypt(1);
        $get_notification = getTableColumn('notification');
        
        if ($request->isMethod('post')) {
            // echo "<pre>";
            // print_r($request->all());
            // echo "</pre>";die();

            $req_fields                      = [];
            $req_fields['title']             = 'required';
            $req_fields['description']       = 'required';
            $req_fields['notifcation_icon']  = 'mimes:jpeg,png,jpg';
            $req_fields['notifcation_image'] = 'mimes:jpeg,png,jpg';

            $errormsg = [
                'title.*' => translate('Title'),
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
            
            $message      = translate('Send Successfully');
            $status       = 'success';
            $Notification = Notification::find(1);
            if(!$Notification){
                $Notification = new Notification();
            }
            $Notification->title       = $request->title;
            $Notification->description = $request->description;
            $Notification->link        = $request->link;
            if ($request->hasFile('notifcation_image')) {
                $files     = $request->file('notifcation_image');
                $random_no = uniqid();
                $img       = $files;
                $ext       = $files->getClientOriginalExtension();
                $new_name  = $random_no . time() . '.' . $ext;
                $destinationPath = public_path('uploads/notification');
                $img->move($destinationPath, $new_name);
                $Notification->image = $new_name;
            }
            if ($request->hasFile('notifcation_icon')) {
                $files     = $request->file('notifcation_icon');
                $random_no = uniqid();
                $img       = $files;
                $ext       = $files->getClientOriginalExtension();
                $new_name  = $random_no . time() . '.' . $ext;
                $destinationPath = public_path('uploads/notification');
                $img->move($destinationPath, $new_name);
                $Notification->icon = $new_name;
            }
            $Notification->save();
            send_notification_firebase($Notification->id);

            return redirect()
                ->route('admin.send_notification.send')
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'No Record Found']);
            }
            $id = checkDecrypt($id);
            $common['title']  = 'Send Notification';
            $common['button'] = 'Send';

            $get_notification = Notification::where('id', $id)->first();

            if (!$get_notification) {
                return back()->withErrors(['error' => 'Something went wrong']);
            }
        }
        return view('admin.settings.notification.addNotification', compact('common','get_notification'));
    }
}
