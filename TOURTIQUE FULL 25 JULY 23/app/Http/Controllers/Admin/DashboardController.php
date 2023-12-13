<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Blog;
use App\Models\Contact_us;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Service;
use App\Models\Country;
use App\Models\States;
use App\Models\City;
use App\Models\AirportModel;
use App\Models\Zones;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

use App\Models\ProductCheckout;
use App\Models\AffilliateCommission;
use Carbon\Carbon;
use App\Models\Supplier;



class DashboardController extends Controller
{
    //
    public function index()
    {
        $common = array();
        Session::put("TopMenu", "Dashboard");
        Session::put("SubMenu", "Dashboard");
        $common['title']             = "Dashboard";
        $user_id = Session::get('admin_id');
        $date    = date('Y-m-d');

        // Users Count 
        $user_count = 0;
        $user_count = User::where(['status' => 'Active', 'is_delete' => 0])->count();


        // Products
        $product_count = 0;
        $product_count = Product::where(['status' => 'Active', 'is_delete' => 0])->count();


        // Orders
        $get_product_checkout  = [];
        $get_product_checkout = ProductCheckout::where(['status' => 'Success'])->get();
        $total_checkout = 0;
        foreach ($get_product_checkout as $key => $value) {
            $total_checkout += $value['total'];
        }

        // Orders
        $get_orders = [];
        $ProductCheckout = ProductCheckout::orderBy('id', 'desc');
        $ProductCheckout = $ProductCheckout->limit(10);
        $get_orders = $ProductCheckout->paginate(config('adminconfig.records_per_page'));



        $get_best_seller = Product::select('products.*', 'product_language.description as title')
            ->where('products.is_delete', 0)
            ->leftjoin('product_language', 'products.id', '=', 'product_language.product_id')
            ->groupBy('products.id')
            ->where('products.sales_count', '!=', 0)
            ->orderBy('products.sales_count', 'desc')->paginate(config('adminconfig.records_per_page'));


        // Stff
        $staff_count = 0;
        $staff_count = User::orderBy('id', 'asc')->where(['is_delete' => 0, 'user_type' => "Affiliate"])->count();


        $partner_count = User::orderBy('id', 'asc')->where(['is_delete' => 0, 'user_type' => "Partner"])->count();

        // Supplier
        $supplier_count = 0;
        $supplier_count = Supplier::orderBy('id', 'desc')->where(['is_delete' => 0, 'status' => 'Active'])->count();


        $get_charts_items = ProductCheckout::select(
            ProductCheckout::raw("(COUNT(*)) as count"),
            ProductCheckout::raw("DATE(created_at) as month_name"),
            ProductCheckout::raw("sum(total) as totale")
        )

            ->groupBy('month_name')
            ->take(15)
            ->orderby('created_at', 'desc')
            ->get();
        $bestSellerChart = [];
        foreach ($get_best_seller as $key => $gbs) {
            $colorArr = ["#f5803e", "#e63757", '#2c7be5', '#00d27a', '#27bcfd', '#748194', '#92bbf1'];
            $bestSellerChartArr = [];
            $randomNo = rand(0, 6);

            $bestSellerChartArr['name'] = $gbs['title'];
            $bestSellerChartArr['value'] = $gbs['sales_count'];
            $bestSellerChartArr['itemStyle']['color'] = $colorArr[$randomNo];
            $bestSellerChart[] = $bestSellerChartArr;
        }


        $ProductCheckout = ProductCheckout::where('status', 'Success')->orderBy('id', "desc")->get();

        $optionArr = [];
        $currentDate = Carbon::now()->timestamp;

        $nextDate = Carbon::now()->addDays(7)->timestamp;

        foreach ($ProductCheckout as $key => $value) {
            foreach (json_decode($value['extra']) as $ekey => $extra) {

                if ($extra->type == "excursion") {
                    if (isset($extra->option[0]->private_tour)) {
                        foreach ($extra->option[0]->private_tour as $ptkey => $PT) {
                            $date = Carbon::parse($PT->date)->timestamp;
                            if ($date > $currentDate && $date < $nextDate) {
                                $arr                 = [];
                                $arr['title']        = $PT->title;
                                $arr['date']         = $PT->date;
                                $arr['total_amount'] = $PT->total_amount;
                                $arr['type']         = $extra->type;
                                $arr['order_id']     = $value->order_id;
                                $arr['id']           = $value->id;
                                $optionArr[]         = $arr;
                            }
                        }
                    }
                    if (isset($extra->option[0]->tour_transfer)) {
                        foreach ($extra->option[0]->tour_transfer as $tkey => $TT) {
                            $date = Carbon::parse($TT->date)->timestamp;
                            if ($date > $currentDate && $date < $nextDate) {
                                $arr                 = [];
                                $arr['title']        = $TT->title;
                                $arr['date']         = $TT->date;
                                $arr['total_amount'] = $TT->total_amount;
                                $arr['type']         = $extra->type;
                                $arr['order_id']     = $value->order_id;
                                $arr['id']           = $value->id;
                                $optionArr[]         = $arr;
                            }
                        }
                    }
                    if (isset($extra->option[0]->group_percentage)) {
                        foreach ($extra->option[0]->group_percentage as $tkey => $GP) {
                            $date = Carbon::parse($GP->date)->timestamp;
                            if ($date > $currentDate && $date < $nextDate) {
                                $arr                 = [];
                                $arr['title']        = $GP->title;
                                $arr['date']         = $GP->date;
                                $arr['total_amount'] = $GP->amount;
                                $arr['type']         = $extra->type;
                                $arr['order_id']     = $value->order_id;
                                $arr['id']           = $value->id;
                                $optionArr[]         = $arr;
                            }
                        }
                    }
                }

                if ($extra->type == "Yatch") {
                    if (isset($extra->option[0])) {
                        $date = Carbon::parse($extra->option[0]->date)->timestamp;
                        if ($date > $currentDate && $date < $nextDate) {
                            $arr                 = [];
                            $arr['title']        = $extra->title;
                            $arr['date']         = $extra->option[0]->date;
                            $arr['total_amount'] = $extra->total;
                            $arr['type']         = $extra->type;
                            $arr['order_id']     = $value->order_id;
                            $arr['id']           = $value->id;
                            $optionArr[]         = $arr;
                        }
                    }
                }

                if ($extra->type == "Limousine") {
                    if (isset($extra->option[0])) {
                        $date = Carbon::parse($extra->option[0]->date)->timestamp;
                        if ($date > $currentDate && $date < $nextDate) {
                            $arr                 = [];
                            $arr['title']        = $extra->title;
                            $arr['date']         = $extra->option[0]->date;
                            $arr['total_amount'] = $extra->total;
                            $arr['type']         = $extra->type;
                            $arr['order_id']     = $value->order_id;
                            $arr['id']           = $value->id;
                            $optionArr[]         = $arr;
                        }
                    }
                }

                if ($extra->type == "lodge") {
                    if (isset($extra->option[0])) {
                        foreach ($extra->option as $key => $lodgeData) {

                            $date = Carbon::parse($lodgeData->lodge_arrival_date)->timestamp;
                            if ($date > $currentDate && $date < $nextDate) {
                                $arr                 = [];
                                $arr['title']        = $lodgeData->title;
                                $arr['date']         = $lodgeData->lodge_arrival_date;
                                $arr['total_amount'] = $lodgeData->option_total;
                                $arr['type']         = $extra->type;
                                $arr['order_id']     = $value->order_id;
                                $arr['id']           = $value->id;
                                $optionArr[]         = $arr;
                            }
                        }
                    }
                }
            }
        }
        usort($optionArr, function ($a, $b) {

            return strtotime($a['date']) - strtotime($b['date']);
        });

        $affilliateCommission = AffilliateCommission::sum('total');



        $optionArr =  array_slice($optionArr, 0, 10);
        return view('admin.dashboard', compact('common', 'user_count', 'affilliateCommission', 'partner_count', 'get_best_seller', 'product_count', 'total_checkout', 'get_orders', 'staff_count',  'get_charts_items', 'bestSellerChart', 'optionArr'));
    }


    //Profile Update
    public function profile(Request $request)
    {
        $common = array();
        $common['main_menu']    = 'profile';
        $common['submain_menu'] = 'profile';
        $common['title']        = "Profile";
        $admin_id               = Session::get('admin_id');

        if (Session::get('user_type') == "admin") {
            $get_admin              = Admin::where('id', $admin_id)->first();
        } else {
            $get_admin              = User::where('id', $admin_id)->first();
        }

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
            if (Session::get('user_type') == "admin") {
                $Admin             = Admin::find($admin_id);
            } else {
                $Admin             = User::find($admin_id);
            }
            if ($Admin) {
                $Admin->first_name = $request->first_name;
                $Admin->last_name  = $request->last_name;
                $Admin->last_name  = $request->last_name;
                if ($request->hasFile('image')) {
                    $random_no  = uniqid();
                    $img = $request->file('image');
                    $ext = $img->getClientOriginalExtension();
                    $new_name = $random_no . '.' . $ext;
                    $destinationPath =  public_path('uploads/admin_image');
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


    ///change_password
    public function change_password(Request $request)
    {
        $common = array();
        $common['main_menu']    = 'change_password';
        $common['submain_menu'] = 'change_password';
        $common['title']        = "Change password";
        $admin_id               = Session::get('admin_id');
        if (Session::get('user_type') == "admin") {
            $get_admin              = Admin::where('id', $admin_id)->first();
        } else {
            $get_admin              = User::where('id', $admin_id)->first();
        }

        if ($request->isMethod('post')) {

            $req_fields                     =   array();
            $req_fields['current_password'] = 'required';
            $req_fields['new_password']     = 'required_with:confirm_password|same:confirm_password';
            $req_fields['confirm_password'] = 'required';

            $validation = Validator::make($request->all(), $req_fields);
            if ($validation->fails()) {
                return back()->withErrors($validation)->withInput();
            }

            $message           = "Something went wrong";
            $status            = "error";
            if (Session::get('user_type') == "admin") {
                $Admin             = Admin::find($admin_id);
            } else {
                $Admin             = User::find($admin_id);
            }
            if ($Admin) {
                if (Hash::check($request->current_password, $Admin->password)) {
                    $confirm_password        = Hash::make($request->confirm_password);
                    $Admin->password         = $confirm_password;
                    $Admin->decrypt_password = $request->confirm_password;
                    $Admin->save();
                    $message           = "Password Change Successfully";
                    $status            = "success";
                } else {
                    $message           = "Current password is wrong";
                }
            }
            return back()->withErrors([$status => $message]);
        } else {
            return view('admin.settings.change_password', compact('common'));
        }
    }

    // Contact Us List
    public function contact_us()
    {
        $common = array();
        $common['main_menu']         = 'contact_us';
        $common['submain_menu']      = 'contact_us';
        $common['title']             = "Contact Us";
        $get_contact_us              = array();
        $get_message                 = Contact_us::orderby('id', 'desc')->paginate(config('adminconfig.records_per_page'));
        foreach ($get_message as $key => $value) {
            $contact_arr                 = array();
            $contact_arr['name']         = "";
            $contact_arr['id']           = $value['id'];
            $contact_arr['email']        = "";
            $contact_arr['message']      = "";
            if ($value['name'] != "") {
                $contact_arr['name'] = $value['name'];
            }
            if ($value['email'] != "") {
                $contact_arr['email'] = $value['email'];
            }
            if ($value['message'] != "") {
                $contact_arr['message'] = $value['message'];
            }
            $get_contact_us[] = $contact_arr;
        }
        return view('admin.contact_us.index', compact('common', 'get_contact_us', 'get_message'));
    }



    ///Contact US Delete Message
    public function contact_us_delete($id)
    {
        $status  = 'error';
        $message = 'Something went wrong!';
        $get_contact_us =  Contact_us::find($id);
        if ($get_contact_us) {
            $get_contact_us->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }


    // Get State City

    public function get_state_city(Request $request)
    {
        $selectedCat = $request->selectedCat;
        if ($request->type == 'country') {
            $data = States::where('country_id', $request->country)->get();
        } elseif ($request->type == 'zone') {
            $get_zone =  Zones::where('id', $request->zone)->first();
            $data = Country::where('id', $get_zone->country)->get();
        } else {
            $data =  City::where('state_id', $request->state)->get();
        }

        return View::make('admin.append_page.select', compact('data', 'selectedCat'))->render();
    }



    // Get Airport by city

    public function get_airport(Request $request)
    {
        $selectedCat = $request->selectedCat;
        $data = array();
        if ($request->country != '') {
            $data = AirportModel::where('country', $request->country)->get();
        }
        return View::make('admin.append_page.select', compact('data', 'selectedCat'))->render();
    }


    // Get Zones by Airport

    public function get_zones(Request $request)
    {
        $selectedCat = $request->selectedCat;
        $selected_airport_id = '"' . $request->airport . '"';
        $data = array();
        if ($request->airport != '') {
            $data = Zones::where('airport', 'LIKE', '%' . $selected_airport_id . '%')->get();
        }
        return View::make('admin.append_page.select_zone', compact('data', 'selectedCat'))->render();
    }


    public function language_change(Request $request){
       
        if ($request->isMethod('post')) {
            Session::put('Lang', $request->lang_id);
        }     
    }


}
