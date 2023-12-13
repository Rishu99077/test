<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transfer;
use App\Models\TransferLanguage;
use App\Models\TransferCarType;
use App\Models\TransferCarTypeLanguage;
use App\Models\TransferAdvertisingBanner;
use App\Models\TransferCarScrollingBanner;
use App\Models\TransferHighlights;
use App\Models\TransferHighlightsLanguage;
use App\Models\TransferWhyBook;
use App\Models\TransferWhyBookLanguage;
use App\Models\TransferVoucher;
use App\Models\TransferVoucherLanguage;
use App\Models\TransferBusTypeLanguage;
use App\Models\TransferPricing;
use App\Models\Language;
use App\Models\Country;
use App\Models\CarType;
use App\Models\CarTypeLanguage;
use App\Models\CarModels;
use App\Models\CustomerGroup;
use App\Models\TransferCustomerGroupDiscount;
use App\Models\Supplier;
use App\Models\ProductToolTip;
use App\Models\ProductToolTipLanguage;
use App\Models\TransferBusType;

use App\Models\ProductVoucher;
use App\Models\ProductVoucherLanguage;
use App\Models\TransferExtras;
use App\Models\TransferExtrasLanguage;

use App\Models\TransferZones;
use App\Models\DefaultToolTipTitle;

use App\Models\AirportModel;
use App\Models\Locations;

use App\Models\TransferExtrasOptions;
use App\Models\TransferExtrasOptionsLanguage;
use App\Models\Zones;
use App\Models\ProuductCustomerGroupDiscount;

use App\Models\ProductExprienceIcon;
use App\Models\ProductExprienceIconLanguage; 

use App\Models\LocationDistanceTiming; 


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Str;
use Carbon\Carbon;


class TransferController extends Controller
{

    public function index(Request $request)
    {
        $common          = array();
        $common['title'] = "Airport Transfer";
        Session::put("TopMenu", "Product");
        Session::put("SubMenu", "Airport Transfer");
        Session::put("SubSubMenu", "Add Airport Transfer");
        $country = Country::all();

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];
        
        
        $addDaysDate = Carbon::now()->addDays(14);
        // rate_valid_until
        $expired_Product =  Transfer::select('transfer.*', 'transfer_language.title as title')->join('transfer_language', 'transfer.id', '=', 'transfer_language.transfer_id')->where('transfer.rate_valid_until', "<=", $addDaysDate)->where('transfer.rate_valid_until', ">=", Carbon::now())->groupBy('transfer.id')->get();
       

        $get_transfer = Transfer::select('transfer.*', 'transfer_language.title', 'transfer_language.description', 'transfer_car_types.passengers', 'car_type_language.title as car_type', 'transfer_car_types.car_model','transfer_bus_types.passengers as bus_passenger','transfer_bus_types.car_model as bus_model',)
            ->orderBy('transfer.id', 'desc')->where(['transfer.is_delete' => 0])
            ->leftJoin("transfer_language", 'transfer.id', '=', 'transfer_language.transfer_id')
            ->leftJoin("transfer_car_types", 'transfer.id', '=', 'transfer_car_types.transfer_id')
            ->leftJoin("transfer_bus_types", 'transfer.id', '=', 'transfer_bus_types.transfer_id')
            ->leftjoin("car_type_language", 'transfer_car_types.car_type', '=', 'car_type_language.car_type_id')->groupBy('transfer.id');
    

        $common['product_name'] =  '';
        $common['country']      =  '';
        $common['state']        =  '';
        $common['city']         =  '';
        $common['status']       =  '';
        $common['car_models']   =  '';

        if (isset($request->product_name)) {
            $common['product_name'] = $request->product_name;
            $get_transfer = $get_transfer->where('transfer_language.title', 'like', '%' . $request->product_name . '%');
        }
        if (isset($request->country)) {
            $common['country'] = $request->country;
            $get_transfer = $get_transfer->where('transfer.country', $request->country);
        }
        if (isset($request->state)) {
            $common['state'] = $request->state;
            $get_transfer = $get_transfer->where('transfer.state', $request->state);
        }
        if (isset($request->city)) {
            $common['city'] = $request->city;
            $get_transfer = $get_transfer->where('transfer.city', $request->city);
        }
        if (isset($request->status)) {
            $common['status'] = $request->status;
            $get_transfer = $get_transfer->where('transfer.status', $request->status);
        }
        if (isset($request->car_models)) {
            $common['car_models'] = $request->car_models;
            $get_transfer = $get_transfer->where('transfer_car_types.car_model', 'like', '%' . $request->car_models . '%');
        }
      
        // print_die($get_transfer->get()->toArray());
        $get_transfer = $get_transfer->paginate(config('adminconfig.records_per_page'));

        return view('admin.product.transfer.index', compact('common', 'get_transfer', 'country','expired_Product','lang_id'));
    }

    ///Add Transfer
    public function addTransfer(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Product");
        Session::put("SubMenu", "Airport Transfer");
        Session::put("SubSubMenu", "Add Airport Transfer");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $common['title']              = translate("Add Transfer");
        $common['button']             = translate("Save");
        $get_transfer                 = getTableColumn('transfer');
        $get_transfer_language        = "";
        $get_bus_transfer_language    = "";
        $languages             = Language::where(ConditionQuery())->get();

        $get_transfer_car_type            = [];
        $get_transfer_car_type_language   = []; 
        
        $get_transfer_bus_type            = [];
        $get_transfer_bus_type_language   = [];

        $get_advertising_banner_image     = [];
        $get_car_scrolling_banner_image   = [];

        $get_transfer_highlights          = [];
        $get_transfer_highlights_language = [];

        $get_transfer_why_book            = [];
        $get_transfer_why_book_language   = [];

        $get_transfer_voucher             = [];
        $get_transfer_voucher_language    = [];
        $customerGroup                    = [];

        $get_transfer_pricing             = [];

        $get_transfer_extras              = [];
        $get_transfer_extras_language     = [];
        $get_transfer_voucher_language    = [];
        $get_transfer_voucher             = [];


        $get_transfer_zones = [];
        $get_bus_transfer_zones = [];

        $get_transfer_extras_options              = [];
        $get_transfer_extras_options_language     = [];
        $get_product_tooltip_language = [];
        $get_product_deafault_title = DefaultToolTipTitle::where('type', 'transfer')->get();

        $CRT  = getTableColumn('transfer_car_types');
        $CBT  = getTableColumn('transfer_bus_types');
        $THS  = getTableColumn('transfer_highlights');
        $WBT  = getTableColumn('transfer_why_book');
        $TVS  = getTableColumn('transfer_voucher');
        $TPC  = getTableColumn('transfer_pricing');
        $TXX  = getTableColumn('transfer_extras');
        $EXO  = getTableColumn('transfer_extras_options');
        $TZZ  = getTableColumn('transfer_zones');
        $TBZZ = getTableColumn('transfer_zones');

        // Experience Icon
        $get_product_experience_icon              = [];
        $get_product_experience_icon_language     = [];
        $PEI                              = getTableColumn('product_experience_icon');


        $country      = Country::all();
        $get_airport  = AirportModel::all();
        $get_zone     = Zones::all();
        $get_car_type = CarType::select('car_type.*', 'car_type_language.title')->orderBy('car_type.id', 'desc')->where(['car_type.status' => 'Active'])
            ->join("car_type_language", 'car_type.id', '=', 'car_type_language.car_type_id')->groupBy('car_type.id')->get();
        $get_car_model = CarModels::where('status', 'Active')->get();
        $get_supplier = Supplier::where(['added_by' => 'admin'])->get();

        $customerGroup = CustomerGroup::select('customer_group.*', 'customer_group_language.title as title')
            ->where('customer_group.is_delete', 0)
            ->where('customer_group.status', 'Active')
            ->join('customer_group_language', 'customer_group.id', '=', 'customer_group_language.customer_group_id')
            ->groupBy('customer_group.id')
            ->orderBy('customer_group.id', 'desc')
            ->get();




        $get_supplier = Supplier::where(['added_by' => 'admin'])->get();

        if ($request->isMethod('post')) {
            // echo "<pre>";
            // print_r($request->all());
            // echo "</pre>";
            // die();

            $req_fields = [];
            $req_fields['title.*']            = "required";
            $req_fields['description.*']      = "required";
            $req_fields['price']              = "required";

            $errormsg = [
                "title.*"           => translate("Title"),
                "description.*"     => translate("Description"),
                "price"             => translate("price"),
            ];

            $validation = Validator::make(
                $request->all(),
                $req_fields,
                [
                    'required' => 'The :attribute field is required.',
                ],
                $errormsg
            );


            if ($request->id != "") {
                $message  = translate("Update Successfully");
                $status   = "success";
                $Transfer = Transfer::find($request->id);
                $TransferCarType  = TransferCarType::where(['transfer_id' => $request->id])->first();
                $TransferBusType  = TransferBusType::where(['transfer_id' => $request->id])->first();
                if($TransferBusType == "")
                {
                    $TransferBusType = new TransferBusType();
                }
                TransferCarTypeLanguage::where(['transfer_id' => $request->id])->where('language_id',$lang_id)->delete();
                $transfer_id = $request->id;
            } else {
                $message         = translate("Add Successfully");
                $status          = "success";
                $Transfer        = new Transfer();
                $TransferCarType = new TransferCarType();
                $TransferBusType = new TransferBusType();
            }

            $Transfer['country']    = $request->country;
            if (!empty($request->suppliers)) {
                $Transfer['supplier'] = implode(',', $request->suppliers);
            }
            $Transfer['rate_valid_until']               = $request->rate_valid_until;
            $Transfer['client_reward_point']            = $request->client_reward_point;
            $Transfer['point_to_purchase_product']      = $request->point_to_purchase_product;
            // $Transfer['option_note']                    = $request->option_note;
            // $Transfer['booking_policy']                 = $request->booking_policy;
            $Transfer['can_be_booked_up_to_advance']    = $request->can_be_booked_up_to_advance;
            $Transfer['can_be_cancelled_up_to_advance'] = $request->can_be_cancelled_up_to_advance;
            $Transfer['per_modifi_or_cancellation']     = isset($request->per_modifi_or_cancellation) ? 1 : 0;
            $Transfer['product_bookable_type']          = $request->product_bookable_type;
            $Transfer['tax_allowed']                    = isset($request->tax_allowed) ? 1 : 0;
            $Transfer['service_allowed']                = isset($request->service_allowed) ? 1 : 0;
            $Transfer['tax_percentage']                 = $request->tax_percentage;
            $Transfer['affilate_commision']             = $request->affilate_commision;
            $Transfer['service_amount']                 = $request->service_amount;
            $Transfer['country']                        = $request->country;
            $Transfer['state']                          = $request->state;
            $Transfer['city']                           = $request->city;
            $Transfer['extra_top_text']                 = $request->extra_top_text;
            $Transfer['product_type']                   = $request->product_type;
            // $Transfer['airport']                        = $request->airport;
            $Transfer['journey_time']                   = $request->journey_time;
            $Transfer['status']                         = isset($request->transfer_status) ? 'Active' : 'Deactive';


            // CAR TYPE
            if ($request->hasFile('car_image')) {
                if (isset($request->car_image) && $request->car_image != '') {
                    $files = $request->file('car_image');
                    $random_no = uniqid();
                    $img = $files;
                    $ext = $files->getClientOriginalExtension();
                    $new_name = $random_no . time() . '.' . $ext;
                    $destinationPath = public_path('uploads/Transfer_images');
                    $img->move($destinationPath, $new_name);
                    $TransferCarType['car_image'] = $new_name;
                    $Transfer['main_image']       = $new_name;
                }
            }
             // CAR TYPE
            if ($request->hasFile('bus_image')) {
                if (isset($request->bus_image) && $request->bus_image != '') {
                    $files = $request->file('bus_image');
                    $random_no = uniqid();
                    $img = $files;
                    $ext = $files->getClientOriginalExtension();
                    $new_name = $random_no . time() . '.' . $ext;
                    $destinationPath = public_path('uploads/Transfer_images');
                    $img->move($destinationPath, $new_name);
                    $TransferBusType['car_image'] = $new_name;
                    $Transfer['main_image']       = $new_name;
                }
            }

            if ($request->hasFile('transfer_pdf')) {
                if (isset($request->transfer_pdf) && $request->transfer_pdf != '') {
                    $files = $request->file('transfer_pdf');
                    $random_no = uniqid();
                    $img = $files;
                    $ext = $files->getClientOriginalExtension();
                    $new_name = $random_no . time() . '.' . $ext;
                    $destinationPath = public_path('uploads/Transfer_PDF');
                    $img->move($destinationPath, $new_name);
                    $Transfer['transfer_pdf'] = $new_name;
                }
            }

            if ($request->image_pdf == 0) {
                $Transfer['transfer_pdf'] = '';
            }

            $Transfer->save();
            $transfer_id = $Transfer->id;
            


            $TransferCarType['transfer_id']                    = $transfer_id;
            $TransferCarType['car_type']                       = $request->car_type;
          
            $TransferCarType['car_model']                      = $request->car_model;
            $TransferCarType['passengers']                     = $request->passengers;
            $TransferCarType['luggage_allowed']                = $request->luggage_allowed;
            $TransferCarType['product_bookable']               = isset($request->product_bookable) ? 1 : 0;
            $TransferCarType['meet_greet']                     = isset($request->meet_greet) ? 1 : 0;
            $TransferCarType['can_be_booked_up_to_advance']    = $request->can_be_booked_up_to_advance;
            $TransferCarType['can_be_cancelled_up_to_advance'] = $request->can_be_cancelled_up_to_advance;
            $TransferCarType['cancelation_info']               = $request->cancelation_info;
            $TransferCarType['cancelation_icon']               = $request->cancelation_icon;
            $TransferCarType['upgrade_icon']                   = $request->upgrade_icon;
            $TransferCarType['country']                        = $request->country;
            $TransferCarType['state']                          = $request->state;
            // $TransferCarType['airport_id']                     = $request->airport;
            // $TransferCarType['zone_id']                        = $request->zone;
            $TransferCarType['city']                           = $request->city;
            // $TransferCarType['price']                          = $request->price;
            $TransferCarType['no_hidden_cost']                 = $request->no_hidden_cost;
            if (isset($request->free_cancelation)) {
                $TransferCarType['free_cancelation']           = $request->free_cancelation;
            } else {
                $TransferCarType['free_cancelation']           = 0;
            }

            if (isset($request->free_upgrade)) {
                $TransferCarType['free_upgrade']           = $request->free_upgrade;
            } else {
                $TransferCarType['free_upgrade']           = 0;
            }

            $TransferCarType->save();

            
            $TransferBusType['transfer_id']                    = $transfer_id;
            $TransferBusType['car_type']                       = $request->bus_type;
            $TransferBusType['car_model']                      = $request->bus_model;
            $TransferBusType['passengers']                     = $request->bus_passengers;
            $TransferBusType['luggage_allowed']                = $request->bus_luggage_allowed;
            // $TransferBusType['product_bookable']               = isset($request->product_bookable) ? 1 : 0;
            $TransferBusType['meet_greet']                     = isset($request->bus_meet_greet) ? 1 : 0;
            // $TransferBusType['can_be_booked_up_to_advance']    = $request->can_be_booked_up_to_advance;
            // $TransferBusType['can_be_cancelled_up_to_advance'] = $request->can_be_cancelled_up_to_advance;
            // $TransferBusType['cancelation_info']               = $request->cancelation_info;
            $TransferBusType['cancelation_icon']               = $request->bus_cancelation_icon;
            $TransferBusType['upgrade_icon']                   = $request->bus_upgrade_icon;
            $TransferBusType['country']                        = $request->bus_country;
            $TransferBusType['state']                          = $request->bus_state; 
            // $TransferCarType['airport_id']                     = $request->airport;
            // $TransferCarType['zone_id']                        = $request->zone;
            $TransferBusType['city']                           = $request->bus_city;
            // $TransferCarType['price']                          = $request->price;
            $TransferBusType['no_hidden_cost']                 = $request->bus_no_hidden_cost;
            if (isset($request->bus_free_cancelation)) {
                $TransferBusType['free_cancelation']           = $request->bus_free_cancelation;
            } else {
                $TransferBusType['free_cancelation']           = 0;
            }

            if (isset($request->bus_free_upgrade)) {
                $TransferBusType['free_upgrade']           = $request->bus_free_upgrade;
            } else {
                $TransferBusType['free_upgrade']           = 0;
            }

            $TransferBusType->save();

            $get_languages = Language::where(['status'=>'Active','is_delete'=> 0])->get();

            if (!empty($get_languages)) {
                TransferLanguage::where("transfer_id", $request->id)->where('vehicle_type','car')->where('language_id',$lang_id)->delete();
                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('transfer_language',['language_id'=>$value['id'],'transfer_id'=>$request->id,'vehicle_type'=>'car'],'row')) {

                        $TransferCarTypeLanguage                      = new TransferLanguage();
                        $TransferCarTypeLanguage['transfer_id']       = $transfer_id;
                        $TransferCarTypeLanguage['language_id']       = $value['id'];
                        $TransferCarTypeLanguage['title']             = isset($request->title[$value['id']]) ?  $request->title[$value['id']] : $request->title[$lang_id];
                        $TransferCarTypeLanguage['short_description'] = isset($request->short_description[$value['id']]) ?  $request->short_description[$value['id']] : $request->short_description[$lang_id];
                        $TransferCarTypeLanguage['option_note']       = isset($request->option_note[$value['id']]) ? change_str($request->option_note[$value['id']]) : $request->option_note[$lang_id];
                        $TransferCarTypeLanguage['booking_policy']    = isset($request->booking_policy[$value['id']]) ? change_str($request->booking_policy[$value['id']]) : $request->booking_policy[$lang_id];
                        $TransferCarTypeLanguage['description']       = isset($request->information[$value['id']]) ? change_str($request->information[$value['id']]) : $request->information[$lang_id];
                        $TransferCarTypeLanguage->save();
                    }
                }
            }

            if (isset($request->bus_information)) {
                TransferLanguage::where("transfer_id", $request->id)->where('vehicle_type','bus')->where('language_id',$lang_id)->delete();
                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('transfer_language',['language_id'=>$value['id'],'transfer_id'=>$request->id,'vehicle_type'=>'bus'],'row')) {
                        $TransferCarTypeLanguage                      = new TransferLanguage();
                        $TransferCarTypeLanguage['transfer_id']       = $transfer_id;
                        $TransferCarTypeLanguage['language_id']       = $value['id'];
                        $TransferCarTypeLanguage['title']             = isset($request->bus_title[$value['id']]) ?  $request->bus_title[$value['id']] : $request->bus_title[$lang_id];
                        $TransferCarTypeLanguage['short_description'] = isset($request->bus_short_description[$value['id']]) ?  $request->bus_short_description[$value['id']] : $request->bus_short_description[$lang_id];
                        $TransferCarTypeLanguage['option_note']       = isset($request->option_note[$value['id']]) ? change_str($request->option_note[$value['id']]) : $request->option_note[$lang_id];
                        $TransferCarTypeLanguage['booking_policy']    = isset($request->booking_policy[$value['id']]) ? change_str($request->booking_policy[$value['id']]) : $request->booking_policy[$lang_id];
                        $TransferCarTypeLanguage['vehicle_type']      = "bus";

                        $TransferCarTypeLanguage['description']       = isset($request->bus_information[$value['id']]) ? change_str($request->bus_information[$value['id']]) : $request->bus_information[$lang_id];
                        $TransferCarTypeLanguage->save();
                    }
                }
            }

            // Transfer Extras Needs
            if ($request->extra_id) {                
                $extra_arr = array_filter($request->extra_id, fn($value) => !is_null($value) && $value !== '');
                TransferExtras::whereNotIn('id', $extra_arr)->where('transfer_id', $transfer_id)->delete();
                TransferExtrasLanguage::where('transfer_id', $transfer_id)->where('language_id',$lang_id)->delete();                
                foreach ($request->extra_id as $key => $value_high) {
                    if ($value_high != '') {
                        $TransferExtras = TransferExtras::find($value_high);
                    } else {
                        $TransferExtras = new TransferExtras();
                    }

                    $TransferExtras['transfer_id']         = $transfer_id;
                    $TransferExtras['adult_price']         = isset($request->adult_price[$key]) ? $request->adult_price[$key] : 'N/A';
                    $TransferExtras['child_price']         = isset($request->child_price[$key]) ? $request->child_price[$key] : 'N/A';
                    $TransferExtras['child_allowed']       = isset($request->child_allowed[$key]) ? 1 : 0;
                    $TransferExtras->save();

                    foreach ($request->extra_title as $exx_Key => $val_extra) {
                        if ($val_extra[$key] != '') {
                            $TransferExtrasLanguage = new TransferExtrasLanguage();
                            $TransferExtrasLanguage['transfer_id']         = $transfer_id;
                            $TransferExtrasLanguage['language_id']         = $exx_Key;
                            $TransferExtrasLanguage['extras_id']           = $TransferExtras->id;
                            $TransferExtrasLanguage['extra_title']         = $val_extra[$key];
                            $TransferExtrasLanguage['extra_information']   = change_str($request->extra_information[$exx_Key][$key]);
                            $TransferExtrasLanguage->save();
                        }
                    }
                }
            } 
            else {
                TransferExtras::where(['transfer_id' => $transfer_id])->delete();
                TransferExtrasLanguage::where(['transfer_id' => $transfer_id])->where('language_id',$lang_id)->delete();
            }

            // Tootip
            if ($request->tooltip_title) {
                $TooltipTitle       = $request->tooltip_title;
                $TooltipDescription = $request->tooltip_description;
                ProductToolTip::where(['product_id' => $transfer_id, 'type' => 'transfer'])->delete();
                ProductToolTipLanguage::where(['product_id' => $transfer_id, 'type' => 'transfer'])->where('language_id',$lang_id)->delete();

                foreach ($request->tooltip_title as $key => $value_2) {
                    $product_tooltip = new ProductToolTip();
                    $product_tooltip['product_id'] = $transfer_id;
                    $product_tooltip['type'] = "transfer";
                    $product_tooltip['default_tooltip_id'] = $request->default_tooltip_id[$key];
                    $product_tooltip->save();

                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('product_tooltip_language',['language_id'=>$value['id'],'product_id' => $transfer_id,'tooltip_id'=> $product_tooltip->id ,'type'=>'transfer'],'row')) {     

                            $ProductToolTipLanguage                        = new ProductToolTipLanguage();
                            $ProductToolTipLanguage['product_id']          = $transfer_id;
                            $ProductToolTipLanguage['type']                = "transfer";
                            $ProductToolTipLanguage['language_id']         = $value['id'];
                            $ProductToolTipLanguage['tooltip_id']          = $product_tooltip->id;
                            $ProductToolTipLanguage['tooltip_title']       = $request->tooltip_title[$key];
                            $ProductToolTipLanguage['default_tooltip_id']  = $request->default_tooltip_id[$key];
                            $ProductToolTipLanguage['tooltip_description'] = isset($request->tooltip_description[$value['id']][$key]) ?  $request->tooltip_description[$value['id']][$key] : $request->tooltip_description[$lang_id][$key];   
                            $ProductToolTipLanguage->save();
                        }
                    }

                  
                }
            }


            // Voucher
            if (isset($request->voucher_id)) {
                $get_ProductVoucher = ProductVoucher::where(['product_id'=> $request->id , 'type' => 'transfer'])->get();
                foreach ($get_ProductVoucher as $key => $get_productvoucher_delete) {
                    if (!in_array($get_productvoucher_delete['id'], $request->voucher_id)) {
                        ProductVoucher::where('id', $get_productvoucher_delete['id'])->delete();
                    }
                }
            }

            if (!empty($request->voucher_title)) {
                if ($request->voucher_title) {
                    $VoucherTitle = $request->voucher_title;
                    $VoucherDescription = $request->voucher_description;

                    // ProductVoucher::where(['product_id' => $product_id])->delete();
                    ProductVoucherLanguage::where(['product_id' => $transfer_id, 'type' => 'transfer'])->where('language_id',$lang_id)->delete();

                    foreach ($request->voucher_id as $key => $value_2) {
                        if ($value_2 != '') {
                            $transfer_voucher = ProductVoucher::where(['id' => $value_2, 'type' => "transfer"])->first();
                        } else {
                            $transfer_voucher = new ProductVoucher();
                        }

                        if ($request->hasFile('voucher_image')) {
                            if (isset($request->voucher_image[$key]) && $request->voucher_image[$key] != '') {
                                $files = $request->file('voucher_image')[$key];
                                $random_no = uniqid();
                                $img = $files;
                                $ext = $files->getClientOriginalExtension();
                                $imgFile             = Image::make($files);
                                $height              = $imgFile->height();
                                $width               = $imgFile->width();
                                $imgFile->resize(760, 320, function ($constraint) {
                                    $constraint->aspectRatio();
                                });

                                $new_name = $random_no . time() . '.' . $ext;
                                $destinationPath = public_path('uploads/Transfer_images');
                                $imgFile->save($destinationPath . '/' . $new_name);
                                
                                // $img->move($destinationPath, $new_name);
                                $transfer_voucher['voucher_image'] = $new_name;
                            }
                        }

                        if ($request->hasFile('client_logo')) {
                            if (isset($request->client_logo[$key]) && $request->client_logo[$key] != '') {
                                $files = $request->file('client_logo')[$key];

                                $random_no = uniqid();
                                $img = $files;
                                $ext = $files->getClientOriginalExtension();
                                $new_name = $random_no . time() . '.' . $ext;
                                $destinationPath = public_path('uploads/Transfer_images');
                                $img->move($destinationPath, $new_name);
                                $transfer_voucher['client_logo'] = $new_name;
                            }
                        }

                        if ($request->hasFile('our_logo')) {
                            if (isset($request->our_logo[$key]) && $request->our_logo[$key] != '') {
                                $files = $request->file('our_logo')[$key];

                                $random_no = uniqid();
                                $img = $files;
                                $ext = $files->getClientOriginalExtension();
                                $new_name = $random_no . time() . '.' . $ext;
                                $destinationPath = public_path('uploads/Transfer_images');
                                $img->move($destinationPath, $new_name);
                                $transfer_voucher['our_logo'] = $new_name;
                            }
                        }

                        $transfer_voucher['voucher_amount'] = $request->voucher_amount[$key];
                        $transfer_voucher['meeting_point']  = $request->meeting_point[$key];
                        $transfer_voucher['phone_number']   = $request->phone_number[$key];
                        $transfer_voucher['product_id']     = $transfer_id;
                        $transfer_voucher['type']           = "transfer";
                        $transfer_voucher['amount_type']     = $request->amount_type[$key];

                        $transfer_voucher->save();

                        foreach ($request->voucher_title as $VKey => $HL) {
                            if ($HL[$key] != '') {
                                // dd($request->voucher_title);
                                $ProductVoucherLanguage = new ProductVoucherLanguage();
                                $ProductVoucherLanguage['product_id'] = $transfer_id;
                                $ProductVoucherLanguage['language_id'] = $VKey;
                                $ProductVoucherLanguage['type'] = "transfer";
                                $ProductVoucherLanguage['voucher_id'] = $transfer_voucher->id;
                                $ProductVoucherLanguage['title'] = $HL[$key];
                                $ProductVoucherLanguage['description']    = change_str($request->voucher_description[$VKey][$key]);
                                $ProductVoucherLanguage['voucher_remark'] = $request->voucher_remark[$VKey][$key];
                                $ProductVoucherLanguage->save();
                            }
                        }
                    }
                }
            }

            ProuductCustomerGroupDiscount::where('product_id', $transfer_id)->where('type','transfer')->delete();
            foreach ($request->product_customer_group_id as $CGKey => $PCGI) {
                // if ($request->product_customer_group_discount_id[$CGKey] != '') {
                //     $ProuductCustomerGroupDiscount = ProuductCustomerGroupDiscount::where(['id' => $request->product_customer_group_discount_id[$CGKey], 'type' => "transfer"])->first();
                // } else {
                // }
                $ProuductCustomerGroupDiscount               = new ProuductCustomerGroupDiscount();
                $ProuductCustomerGroupDiscount['product_id'] = $transfer_id;
                $ProuductCustomerGroupDiscount['type']       = "transfer";

                $ProuductCustomerGroupDiscount['customer_group_id'] = $PCGI;
                $ProuductCustomerGroupDiscount['tour_price']        = $request->tour_price[$CGKey];
                $ProuductCustomerGroupDiscount['room_details']      = $request->room_details[$CGKey];
                $ProuductCustomerGroupDiscount['transfer_option']   = $request->transfer_option[$CGKey];
                $ProuductCustomerGroupDiscount['weekdays']          = $request->weekdays[$CGKey];
                $ProuductCustomerGroupDiscount['base_price']        = $request->base_price[$CGKey];
                $ProuductCustomerGroupDiscount->save();
            }


            // Transfer Zones
            if ($request->airport) {
                TransferZones::where(['transfer_id' => $transfer_id])->where('vehicle_type','car')->delete();
                foreach ($request->airport as $key => $value_zone) {
                    if ($value_zone != '') {
                        $TransferZones = new TransferZones();

                        $TransferZones['transfer_id']         = $transfer_id;
                        $TransferZones['airport_id']          = $request->airport[$key];
                        $TransferZones['zone_id']             = $request->zone[$key];
                        $TransferZones['price']               = $request->price[$key];
                        $TransferZones['airport_parking_fee'] = $request->airport_parking_fee[$key];
                        $TransferZones['zone_status']         = isset($request->zone_status[$key]) ? 1 : 0;


                        $TransferZones->save();
                    }
                }
            }

          
            // Transfer Zones
            if ($request->bus_airport) {
                TransferZones::where(['transfer_id' => $transfer_id])->where('vehicle_type','bus')->delete();
                foreach ($request->bus_airport as $key => $value_bus_zone) {
                    if ($value_bus_zone != '') {
                        $TransferZones = new TransferZones();
                        $TransferZones['transfer_id']         = $transfer_id;
                        $TransferZones['airport_id']          = $request->bus_airport[$key];
                        $TransferZones['zone_id']             = $request->bus_zone[$key];
                        $TransferZones['adult_price']         = $request->bus_adult_price[$key];
                        $TransferZones['child_price']         = $request->bus_child_price[$key];
                        $TransferZones['airport_parking_fee'] = $request->bus_airport_parking_fee[$key];
                        $TransferZones['vehicle_type']        = "bus";
                        $TransferZones['zone_status']         = isset($request->bus_zone_status[$key]) ? 1 : 0;
                        $TransferZones->save();
                    }
                }
            }


            // Transfer Extras OPtions
            if ($request->extra_option_id) {
                // dd($request->option_title);
                $extra_option_id_arr = array_filter($request->extra_option_id, fn($value) => !is_null($value) && $value !== '');
                TransferExtrasOptions::whereNotIn('id', $extra_option_id_arr)->where('transfer_id',$transfer_id)->delete();
                TransferExtrasOptionsLanguage::where('transfer_id', $transfer_id)->where('language_id',$lang_id)->delete();
                foreach ($request->extra_option_id as $key => $value_opt) {

                    if ($value_opt != '') {
                        $TransferExtrasOptions = TransferExtrasOptions::find($value_opt);
                    } else {
                        $TransferExtrasOptions = new TransferExtrasOptions();
                    }
                    $TransferExtrasOptions['arrival']     = 0;
                    $TransferExtrasOptions['departure']   = 0;
                    $TransferExtrasOptions['transfer_id'] = $transfer_id;
                    $TransferExtrasOptions['extra_price'] = isset($request->extra_price[$key]) ? $request->extra_price[$key] : 'N/A';
                    if (isset($request->arrival)) {
                        foreach ($request->arrival as $Akey => $AR) {
                            if (isset($request->arrival[$key])) {
                                if ($Akey == $key) {
                                    $TransferExtrasOptions['arrival']     = isset($request->arrival[$key][0]) ? $request->arrival[$key][0] : 0;
                                }
                            }
                        }
                    }

                    if (isset($request->departure)) {
                        foreach ($request->departure as $Akey => $AR) {
                            if (isset($request->departure[$key])) {
                                if ($Akey == $key) {
                                    $TransferExtrasOptions['departure']     = isset($request->departure[$key][0]) ? $request->departure[$key][0] : 0;
                                }
                            }
                        }
                    }



                    // $TransferExtrasOptions['departure']   = isset($request->departure[$key]) ? $request->departure[$key] : 0;

                    $TransferExtrasOptions->save();

                    foreach ($request->option_title as $exx_Key => $val_extra) {
                        if ($val_extra[$key] != '') {
                            $TransferExtrasOptionsLanguage = new TransferExtrasOptionsLanguage();
                            $TransferExtrasOptionsLanguage['transfer_id']          = $transfer_id;
                            $TransferExtrasOptionsLanguage['language_id']          = $exx_Key;
                            $TransferExtrasOptionsLanguage['extra_option_id']      = $TransferExtrasOptions->id;
                            $TransferExtrasOptionsLanguage['option_title']         = $val_extra[$key];
                            $TransferExtrasOptionsLanguage['option_description']   = change_str($request->option_description[$exx_Key][$key]);
                            $TransferExtrasOptionsLanguage->save();
                        }
                    }
                }
            } else {
                TransferExtrasOptions::where(['transfer_id' => $transfer_id])->delete();
                TransferExtrasOptionsLanguage::where(['transfer_id' => $transfer_id])->where('language_id',$lang_id)->delete();
            }

            return redirect()->route('admin.transfer')->withErrors([$status => $message]);
        }

        $data = [];

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id           = checkDecrypt($id);
            $common['title']      = "Edit transfer";
            $common['button']     = "Update";
            $get_transfer = Transfer::where('id', $id)->first();
            $get_transfer_language = TransferLanguage::where("transfer_id", $id)->where('vehicle_type','car')->get();
            $get_bus_transfer_language = TransferLanguage::where("transfer_id", $id)->where('vehicle_type','bus')->get();

            $get_transfer_car_type = TransferCarType::where('transfer_id', $id)->get();
            $get_transfer_car_type_language = TransferCarTypeLanguage::where('transfer_id', $id)->get();  
            
            $get_transfer_bus_type = TransferBusType::where('transfer_id', $id)->get();
            $get_transfer_bus_type_language = TransferBusTypeLanguage::where('transfer_id', $id)->get();

            $get_transfer_highlights = TransferHighlights::where('transfer_id', $id)->get();
            $get_transfer_highlights_language = TransferHighlightsLanguage::where('transfer_id', $id)->get();

            $get_advertising_banner_image = TransferAdvertisingBanner::where("transfer_id", $id)->get();
            $get_car_scrolling_banner_image = TransferCarScrollingBanner::where("transfer_id", $id)->get();

            $get_transfer_why_book = TransferWhyBook::where('transfer_id', $id)->get();
            $get_transfer_why_book_language = TransferWhyBookLanguage::where('transfer_id', $id)->get();

            // $get_transfer_voucher = TransferVoucher::where('transfer_id', $id)->get();
            // $get_transfer_voucher_language = TransferVoucherLanguage::where('transfer_id', $id)->get();

            $get_transfer_voucher = ProductVoucher::where(['product_id' => $id, 'type' => 'transfer'])->get();
            $get_transfer_voucher_language = ProductVoucherLanguage::where(['product_id' => $id, 'type' => 'transfer'])->get();

            $get_transfer_pricing = TransferPricing::where('transfer_id', $id)->get();

            $get_transfer_extras          = TransferExtras::where('transfer_id', $id)->get();
            $get_transfer_extras_language = TransferExtrasLanguage::where('transfer_id', $id)->get();

            // dd($get_transfer_voucher_language);

            $get_transfer_extras_options          = TransferExtrasOptions::where('transfer_id', $id)->get();
            $get_transfer_extras_options_language = TransferExtrasOptionsLanguage::where('transfer_id', $id)->get();

            $get_product_tooltip_language = ProductToolTipLanguage::where(['product_id' => $id, 'type' => 'transfer'])->get();

            $get_product_experience_icon          = ProductExprienceIcon::where(['product_id'=> $id,'type' => 'transfer','status'=>'Active'])->get();
            $get_product_experience_icon_language = ProductExprienceIconLanguage::where(['product_id'=> $id,'type' => 'transfer'])->get();

            $get_product_tooltip_title_language = [];
            foreach ($get_product_deafault_title as $key => $value_de) {
                $get_default = ProductToolTipLanguage::where(['product_id' => $id, 'tooltip_title' => $value_de['default_title']])
                    ->get()
                    ->toArray();

                $get_product_tooltip_title_language[] = $get_default;
            }
            $get_transfer_zones         = TransferZones::where('transfer_id', $id)->where('vehicle_type','car')->get();
            $get_bus_transfer_zones     = TransferZones::where('transfer_id', $id)->where('vehicle_type','bus')->get();

    


            if (!$get_transfer) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }

        //        echo "<pre>"; 
        // print_r($TXX);
        // echo "</pre>";die();
        return view('admin.product.transfer.addTransfer', compact('get_transfer_voucher_language', 'get_transfer_voucher', 'get_supplier', 'get_product_deafault_title', 'get_product_tooltip_language', 'common', 'country', 'get_supplier', 'get_transfer', 'languages', 'get_transfer_language', 'get_transfer_car_type', 'get_transfer_car_type_language', 'CRT', 'get_car_type', 'get_car_model', 'get_advertising_banner_image', 'get_car_scrolling_banner_image', 'get_transfer_highlights', 'get_transfer_highlights_language', 'THS', 'get_transfer_why_book', 'get_transfer_why_book_language', 'WBT', 'get_transfer_voucher', 'get_transfer_voucher_language', 'TVS', 'customerGroup', 'get_transfer_pricing', 'TPC', 'get_transfer_extras', 'get_transfer_extras_language', 'TXX', 'get_transfer_extras_options', 'get_transfer_extras_options_language', 'EXO', 'get_airport', 'get_zone', 'get_transfer_zones', 'TZZ','get_product_experience_icon','get_product_experience_icon_language','PEI','get_bus_transfer_language','CBT','get_bus_transfer_zones','get_transfer_bus_type','get_transfer_bus_type_language','TBZZ','lang_id'));
    }

    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_transfer =  Transfer::find($id);

        if ($get_transfer) {
            $get_transfer->delete();

            TransferLanguage::where("transfer_id", $id)->delete();

            TransferCarType::where('transfer_id', $id)->delete();
            TransferCarTypeLanguage::where('transfer_id', $id)->delete();

            TransferHighlights::where('transfer_id', $id)->delete();
            TransferHighlightsLanguage::where('transfer_id', $id)->delete();

            TransferAdvertisingBanner::where("transfer_id", $id)->delete();
            TransferCarScrollingBanner::where("transfer_id", $id)->delete();

            TransferWhyBook::where('transfer_id', $id)->delete();
            TransferWhyBookLanguage::where('transfer_id', $id)->delete();

            ProductVoucherLanguage::where(['product_id' => $id, 'type' => "transfer"])->delete();
            ProductVoucher::where(['product_id' => $id, 'type' => "transfer"])->delete();

            TransferPricing::where('transfer_id', $id)->delete();
            TransferCustomerGroupDiscount::where('transfer_id', $id)->delete();

            TransferExtras::where('transfer_id', $id)->delete();
            TransferExtrasLanguage::where('transfer_id', $id)->delete();

            TransferExtrasOptions::where('transfer_id', $id)->delete();
            TransferExtrasOptionsLanguage::where('transfer_id', $id)->delete();

            ProductExprienceIcon::where(['product_id' => $id, 'type' => "transfer"])->delete();
            ProductExprienceIconLanguage::where(['product_id' => $id, 'type' => "transfer"])->delete();

            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }


    // Duplicate Transfer 
    public function duplicate($id)
    {

        if (checkDecrypt($id) == false) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'No Record Found']);
        }
        $id = checkDecrypt($id);
        $status = 'error';
        $message = translate('Something went wrong!');
        $get_transfer = Transfer::find($id);
        if ($get_transfer) {
            $get_transfer         = $get_transfer->replicate();
            $get_transfer->status = 'Deactive';
            $get_transfer->save();

            $NewId = $get_transfer->id;

            // Transfer Language 
            $TransferLanguage = TransferLanguage::where(['transfer_id'=> $id , 'vehicle_type' => 'car'])->get();
            $TransferLanguage->each(function ($item, $key) use ($NewId) {
                $Language             = $item->replicate();
                $Language->transfer_id = $NewId;
                $Language->save();
            });

             // Transfer Language 
            $TransferLanguage = TransferLanguage::where(['transfer_id'=> $id , 'vehicle_type' => 'bus'])->get();
            $TransferLanguage->each(function ($item, $key) use ($NewId) {
                $Language             = $item->replicate();
                $Language->transfer_id = $NewId;
                $Language->save();
            });


            // Transfer car Type 
            $TransferCarType = TransferCarType::where('transfer_id', $id)->get();
            $TransferCarType->each(function ($item, $key) use ($NewId) {
                $category             = $item->replicate();
                $category->transfer_id = $NewId;
                $category->save();
            });


            // Transfer Bus Type 
            $TransferBusType = TransferBusType::where('transfer_id', $id)->get();
            $TransferBusType->each(function ($item, $key) use ($NewId) {
                $category             = $item->replicate();
                $category->transfer_id = $NewId;
                $category->save();
            });

            // Transfer Car Type Language 
            /*$TransferCarTypeLanguage = TransferCarTypeLanguage::where('transfer_id', $id)->get();
            $TransferCarTypeLanguage->each(function ($item, $key) use ($NewId) {
                $TransferCarTypeLanguageSave                = $item->replicate();
                $TransferCarTypeLanguageSave->transfer_id   = $NewId;
                $TransferCarTypeLanguageSave->save();
            });*/



            // Transfer TransferExtrasOptions 
            $TransferExtrasOptions = TransferExtrasOptions::where(['transfer_id' => $id])->get();
            $TransferExtrasOptions->each(function ($item, $key) use ($NewId, $id) {
                $Options             = $item->replicate();
                $Options->transfer_id = $NewId;
                $Options->save();

                $TransferExtrasOptionsLanguage = TransferExtrasOptionsLanguage::where(['transfer_id' => $id, 'extra_option_id' => $item->id])->get();
                $TransferExtrasOptionsLanguage->each(function ($item, $key) use ($NewId, $Options) {
                    $OptionLanguage               = $item->replicate();
                    $OptionLanguage->transfer_id        = $NewId;
                    $OptionLanguage->extra_option_id    = $Options->id;
                    $OptionLanguage->save();
                });
            });


            // Transfer TransferExtras 
            $TransferExtras = TransferExtras::where(['transfer_id' => $id])->get();
            $TransferExtras->each(function ($item, $key) use ($NewId, $id) {
                $Extras             = $item->replicate();
                $Extras->transfer_id = $NewId;
                $Extras->save();

                $TransferExtrasLanguage = TransferExtrasLanguage::where(['transfer_id' => $id, 'extras_id' => $item->id])->get();
                $TransferExtrasLanguage->each(function ($item, $key) use ($NewId, $Extras) {
                    $ExtraLanguage               = $item->replicate();
                    $ExtraLanguage->transfer_id  = $NewId;
                    $ExtraLanguage->extras_id    = $Extras->id;
                    $ExtraLanguage->save();
                });
            });


            // Transfer Zone 
            $TransferZones = TransferZones::where(['transfer_id'=> $id , 'vehicle_type' => 'car'])->get();
            $TransferZones->each(function ($item, $key) use ($NewId) {
                $Zone             = $item->replicate();
                $Zone->transfer_id = $NewId;
                $Zone->save();
            });

            // Transfer Zone 
            $TransferZones = TransferZones::where(['transfer_id'=> $id , 'vehicle_type' => 'bus'])->get();
            $TransferZones->each(function ($item, $key) use ($NewId) {
                $Zone             = $item->replicate();
                $Zone->transfer_id = $NewId;
                $Zone->save();
            });

            
            // Product ProuductCustomerGroupDiscount 
            $ProuductCustomerGroupDiscount = ProuductCustomerGroupDiscount::where(['product_id' => $id,'type'=>"transfer"])->get();
            $ProuductCustomerGroupDiscount->each(function ($item, $key) use ($NewId) {
                $CustomerGroupDiscount               = $item->replicate();
                $CustomerGroupDiscount->product_id   = $NewId;
                $CustomerGroupDiscount->save();
            });


             // Transfer Vocher
            $ProductVoucher = ProductVoucher::where(['product_id' => $id, 'type' => 'transfer'])->get();
            $ProductVoucher->each(function ($item, $key) use ($NewId, $id) {
                $Voucher             = $item->replicate();
                $Voucher->product_id = $NewId;
                $Voucher->save();

                $ProductVoucherLanguage = ProductVoucherLanguage::where(['product_id' => $id, 'voucher_id' => $item->id])->get();
                $ProductVoucherLanguage->each(function ($item, $key) use ($NewId, $Voucher) {
                    $ExtraLanguage               = $item->replicate();
                    $ExtraLanguage->product_id  = $NewId;
                    $ExtraLanguage->voucher_id   = $Voucher->id;
                    $ExtraLanguage->save();
                });
            });


            // Transfer ProductToolTip 
            $ProductToolTip = ProductToolTip::where(['product_id' => $id, 'type' => 'transfer'])->get();
            $ProductToolTip->each(function ($item, $key) use ($NewId, $id) {
                $Tooltip             = $item->replicate();
                $Tooltip->product_id = $NewId;
                $Tooltip->save();

                $ProductToolTipLanguage = ProductToolTipLanguage::where(['product_id' => $id, 'tooltip_id' => $item->id])->get();
                $ProductToolTipLanguage->each(function ($item, $key) use ($NewId, $Tooltip) {
                    $ExtraLanguage               = $item->replicate();
                    $ExtraLanguage->product_id   = $NewId;
                    $ExtraLanguage->tooltip_id   = $Tooltip->id;
                    $ExtraLanguage->save();
                });
            });

        }
        return redirect()->back()->with(['success' => "Transfer Duplicate Succssfully..."]);
    }


    public function get_locations(Request $request)
    {   
        $zone_id = $request->zone_id;
        $airport_id = $request->airport_id;
        
        $get_airport = AirportModel::where('id',$airport_id)->first();

        $address_lattitude = $get_airport['address_lattitude'];
        $address_longitude = $get_airport['address_longitude'];

        $decode_res = [];
        $destination_addresses = $address_lattitude.'%2C'.$address_longitude;

        $get_count = Locations::where('zone',$zone_id)->count();
        
        if ($get_count>0) {
           
            $get_limit = round($get_count/25+1);
        
            $Locations = Locations::where('zone',$zone_id);

            $new_arr   = array();
            for ($i=0; $i < $get_limit; $i++) { 

                $AddVer = 1;
                if($i == 0){
                    $AddVer = 0;
                }
                $skip_limit = $i*25;

                $get_loc_details = $Locations->skip($skip_limit)->take(25)->get(); //get first 10 rows

                $new_arr[] = $get_loc_details;
            }

        
            foreach ($new_arr as $key_2 => $value_new) {

                $origins_arr = array();
                foreach ($value_new as $key => $value) {

                    $row = array();
                    $new_row = array();
                    $get_distace_timing = LocationDistanceTiming::where(['airport_id' => $airport_id , 'location_id' => $value['id']])->first();
                    if ($get_distace_timing=='') {
                        $row = $value["address_lattitude"].'%2C'.$value["address_longitude"];
                        
                        $origins_arr[] = $row;
                        
                    }
                }

                $List = implode('%7C', $origins_arr);
                
              
                if (count($origins_arr)>0) {
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                      CURLOPT_URL => 'https://maps.googleapis.com/maps/api/distancematrix/json?destinations='.$destination_addresses.'&origins='.$List.'&units=imperial&key=AIzaSyAELluF20dF7ItbE0y2efe500Lbc8kesKI',
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => '',
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 0,
                      CURLOPT_FOLLOWLOCATION => true,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => 'GET',
                    ));

                    $response = curl_exec($curl);

                    $decode_res = json_decode($response);
              
                    curl_close($curl);
                }   

               
                        
                // echo $response;
                $loc_array = array();
                foreach ($decode_res->rows as $key_t => $value) {
                    $LocationDistanceTiming = new LocationDistanceTiming();
                    if ($value != '') {
                        $LocationDistanceTiming->airport_id     = $airport_id;
                        $LocationDistanceTiming->location_id    = $value_new[$key_t]['id'];
                        $LocationDistanceTiming->distance       = $value->elements[0]->distance->text;
                        $LocationDistanceTiming->duration       = $value->elements[0]->duration->text;
                        $LocationDistanceTiming->save();
                    }
                }
            }

        }

  

    }
}
