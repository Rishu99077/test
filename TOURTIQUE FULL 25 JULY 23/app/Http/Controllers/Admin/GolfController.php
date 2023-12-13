<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\ProductAdditionalInfoLanguage;
use App\Models\ProductHighlightLanguage;
use App\Models\ProductOptionLanguage;
use App\Models\ProductSetting;
use App\Models\ProductFaqLanguage;
use App\Models\ProductVoucher;
use App\Models\ProductVoucherLanguage;
use App\Models\Language;
use App\Models\ProductHighlights;
use App\Models\ProductTimings;
use App\Models\ProductOptions;
use App\Models\ProductAddtionalInfo;
use App\Models\ProductFaqs;
use App\Models\Country;
use App\Models\ProductLanguage;
use App\Models\ProductImages;
use App\Models\ProductSiteAdvertisement;
use App\Models\ProductSiteAdvertisementLanguage;
use App\Models\ProductOptionDetails;
use App\Models\Supplier;
use App\Models\ProductOptionWeekTour;
use App\Models\ProductOptionPeriodPricing;
use App\Models\ProductTourPriceDetails;
use App\Models\ProductTourRoom;
use App\Models\ProductCategory;
use App\Models\ProductInfo;
use App\Models\ProductOptionTourUpgrade;
use App\Models\ProductOptionTaxServiceCharge;
use App\Models\ProductOptionTime;
use App\Models\CustomerGroup;
use App\Models\ProductLodge;
use App\Models\ProductLodgeLanguage;
use App\Models\ProductLodgePrice;
use App\Models\ProuductCustomerGroupDiscount;
use App\Models\Timing;
use App\Models\CarDetails;
use App\Models\CarDetailLanguage;
use App\Models\ProductPrivateTransferCars;
use App\Models\ProductToolTip;
use App\Models\ProductToolTipLanguage;
use App\Models\DefaultToolTipTitle;
use App\Models\ProductOptionPrivateTourPrice;
use App\Models\ProductOptionGroupPercentage;
use App\Models\MetaGlobalLanguage;
use App\Models\YachtFeatureHighlight;
use App\Models\YachtFeatureHighlightLanguage;
use App\Models\YachtAmenitiesLanguage;
use App\Models\YachtAmenities;
use App\Models\YachtAmenitiesPoints;
use App\Models\YachtAmenitiesPointsLanguage;
use App\Models\YachtBoatSpecification;
use App\Models\YachtBoatSpecificationLanguage;
use App\Models\TransportationVehicle;
use App\Models\TransportationVehicleLanguage;
use App\Models\Productyachttransferoption;
use App\Models\Productyachttransferoptionlanguage;

use App\Models\GolfRoomLanguage;
use App\Models\GolfRoom;

use App\Models\BoatTypes;
use App\Models\BoatLocations;

use App\Models\HotelPage;

use App\Models\ProductRequestPopup;
use App\Models\ProductRequestPopupLanguage;

use App\Models\ProductExprienceIcon;
use App\Models\ProductExprienceIconLanguage;

use App\Models\GolfTimeSlot;


use Carbon\Carbon;
use App\Models\Productyachtrelatedboats;
use Illuminate\Support\Facades\View;
use Image;
use Illuminate\Support\Str;

class GolfController extends Controller
{
    public function index(Request $request)
    {

        $common          = [];
        $common['title'] = 'Golf';
        $country         = Country::all();

        Session::put('TopMenu', 'Product');
        Session::put('SubMenu', 'Golf');

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $addDaysDate     = Carbon::now()->addDays(14);
        $expired_Product =  Product::select('products.*', 'product_language.description as title')->join('product_language', 'products.id', '=', 'product_language.product_id')->where('products.rate_valid_until', "<=", $addDaysDate)->where('products.rate_valid_until', ">=", Carbon::now())->where('products.product_type', 'golf')->groupBy('products.id')->get();

        $get_product    = Product::select('products.*', 'product_language.description as title')
            ->where('products.is_delete', 0)
            ->where('products.product_type', 'golf')
            ->leftjoin('product_language', 'products.id', '=', 'product_language.product_id')
            ->groupBy('products.id')
            ->orderBy('products.id', 'desc');

        if ($request->ajax()) {
            $page = $request->page;
            if (isset($request->product_name)) {
                $get_product = $get_product->where('product_language.description', 'like', '%' . $request->product_name . '%');
            }
            if (isset($request->country)) {
                $get_product = $get_product->where('products.country', $request->country);
            }
            if (isset($request->state)) {
                $get_product = $get_product->where('products.state', $request->state);
            }
            if (isset($request->city)) {
                $get_product = $get_product->where('products.city', $request->city);
            }

            $get_product = $get_product->offset($page * config('adminconfig.records_per_page'))->paginate(config('adminconfig.records_per_page'));
            return view('admin.product.golf._listing', compact('common', 'get_product','lang_id'))->render();
        } else {
            $get_product = $get_product->paginate(config('adminconfig.records_per_page'));
            return view('admin.product.golf.index', compact('common', 'get_product', 'country', 'expired_Product','lang_id'));
        }
    }

    //Add Golf
    public function addGolf(Request $request, $id = '')
    {
        Session::put('TopMenu', 'Product');
        Session::put('SubMenu', 'Golf');

        $common            = [];
        $common['title']   = translate('Add Golf');
        $common['button']  = translate('Save');
        $user_id           = Session::get('admin_id');
        $get_product       = getTableColumn('products');
        $languages         = Language::where(['is_delete' => 0, 'status' => 'Active'])->get();

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        //
        $categories                            = [];
        $get_product_language                  = [];
        $opening_time_heading                  = [];
        $additional_heading                    = [];


        $get_product_additional_info_language  = [];
        $get_product_highlight_language        = [];
        $get_product_voucher_language          = [];
        $get_golf_rooms_language               = [];
        $experience_icon_heading               = [];
        $experience_icon_upper_heading         = [];
        $get_product_option_language           = [];
        $get_product_faq_language              = [];
        $get_product_site_adver_language       = [];
        $get_product_lodge_language            = [];
        $get_product_additional_info           = [];
        $get_product_highlight                 = [];
        $get_product_voucher                   = [];
        $get_product_faq                       = [];
        $get_product_site_adver                = [];
        $get_product_option_details            = [['id' => 0]];
        $get_product_option                    = [];
        $get_product_images                    = [];
        $get_product_option_week_tour          = [];
        $get_product_option_general_week_tour  = [];
        $get_product_option_period_pricing     = [];
        $get_product_option_tour_upgrade       = [];
        $get_product_option_group_percentage   = [];
        $get_product_category                  = [];
        $get_product_lodge                     = [];
        $get_product_tooltip                   = [];
        $get_product_tooltip_language          = [];
        $get_product_tooltip_title_language    = [];
        $get_yatch_fetaure_highlight_heading   = [];
        $get_yatch_fetaure_highlight_language  = [];
        $get_yatch_amenities_heading           = [];
        $get_yatch_amenities_language          = [];
        $get_yatch_amenities_language          = [];
        $get_yatch_amenities_points            = [];
        $get_yatch_fetaure_highlight           = [];
        $get_yatch_boat_specification_heading  = [];
        $get_yatch_boat_specification          = [];
        $get_yatch_boat_specification_language = [];
        $get_yatch_amenities                   = [];
        $get_yatch_amenities_points_language   = [];
        $get_product_transfer_option           = [];
        $get_product_transfer_option_language  = [];
        $get_yatch_transfer_option             = [];
        $get_product_related_boats             = [];
        $get_golf_rooms                        = [];
        $get_golf_rooms_langauge               = [];

        $get_golf_time_slot                    = [];

        $get_product_deafault_title            = DefaultToolTipTitle::get()->toArray();
        $get_product_setting                   = '';
        $get_limousine_locations               = [];
        $get_limousine_types                   = [];
        $get_limousine_locations               = BoatLocations::where('type', 'golf')->where(['status' => 'Active'])->get();
        $get_limousine_types                   = BoatTypes::where('type', 'golf')->where(['status' => 'Active'])->get();
        $get_hotels                            = [];

        $get_product_request_popup              = [];
        $get_product_request_popup_language     = [];
        $POPUP = getTableColumn('product_request_popup');

        $GPO   = getTableColumn('products_options');
        $GPH   = getTableColumn('products_highlights');
        $GPV   = getTableColumn('products_voucher');
        $GPF   = getTableColumn('products_faqs');
        $GPSD  = getTableColumn('product_site_advertisement');
        $GPC   = getTableColumn('product_categories');
        $GPL   = getTableColumn('product_lodge');
        $PTT   = getTableColumn('product_tooltip');
        $GPAI  = getTableColumn('products_addtional_info');
        $GYFH  = getTableColumn('yacht_feature_highlight');
        $GYA   = getTableColumn('yacht_amenities');
        $GYAPl = getTableColumn('yacht_amenities_points_language');
        $GYAP  = getTableColumn('yacht_amenities_points');
        $GYTO  = getTableColumn('product_yacht_transfer_option');
        $GYRB  = getTableColumn('product_yacht_relatedboats');
        $GGR   = getTableColumn('golf_rooms');
        $GTS   = getTableColumn('golf_time_slots');

       $PEIH                = getTableColumn('product_experience_icon');

        // Experience Icon
        $get_product_experience_icon                = [];
        $get_product_experience_icon_language       = [];
        $get_product_experience_icon_language_upper = [];
        $get_product_experience_icon_upper          = [];
        $PEI                                        = getTableColumn('product_experience_icon');

        // $GYRB = getTableColumn('product_yacht_relatedboats');

        $country             = Country::all();
        $get_supplier        = Supplier::where(['added_by' => 'admin','status'=>'Active'])->get();
        $product_option_time = ProductOptionTime::where(['status' => 1])->get();
        $get_timings         = Timing::all();

        $customerGroup = CustomerGroup::select('customer_group.*', 'customer_group_language.title as title')
            ->where('customer_group.is_delete', 0)
            ->join('customer_group_language', 'customer_group.id', '=', 'customer_group_language.customer_group_id')
            ->groupBy('customer_group.id')
            ->orderBy('customer_group.id', 'desc')
            ->get();


        $transportation_vehicle = TransportationVehicle::select('transportation_vehicle.*', 'transportation_vehicle_language.title')->orderBy('transportation_vehicle.id', 'desc')->where(['transportation_vehicle.is_delete' => 0])
            ->join("transportation_vehicle_language", 'transportation_vehicle.id', '=', 'transportation_vehicle_language.transportation_vehicle_id')->where('status', 'Active')->groupBy('transportation_vehicle.id')
            ->get();

        $get_boats = Product::select('products.*', 'product_language.description as title')
            ->where('products.is_delete', 0)
            ->where('products.status', 'Active')
            ->where('products.product_type', 'golf')
            ->leftjoin('product_language', 'products.id', '=', 'product_language.product_id')
            ->where('product_language.language_id',$lang_id)
            ->groupBy('products.id')->get();


        if ($request->isMethod('post')) {

            // echo "<pre>"; 
            // print_r($request->all());
            // echo "</pre>";die();

            $req_fields             = [];
            $req_fields['title.*']  = 'required';
            $req_fields['short_description.*'] = 'required';
            $req_fields['address']  = 'required';
            $req_fields['country']  = 'required';
            $req_fields['state']    = 'required';
            $req_fields['city']     = 'required';
            // $req_fields['duration'] = 'required';

            // if ($request->id == '') {
            //     $req_fields['image'] = 'required';
            // }

            if (isset($request->image_id)) {
                $count_img =  count($request->image_id);
                if($count_img > 10){
                    $req_fields['files_count'] = 'required';
                }
            }

            $errormsg = [
                'title.*'  => translate('Title'),
                'short_description.*' => translate('Short Description'),
                'address'  => translate('Address'),
                'country'  => translate('Country'),
                // 'duration' => translate('Duration'),
                'state'    => translate('State'),
                'city'     => translate('City'),
                'image'    => translate('Image'),
                'files_count' => translate('Image count less than 10'),
                
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
                return response()->json(['error' => $validation->getMessageBag()->toArray()]);
            }

            if ($request->id != '') {
                $message = translate('Update Successfully');
                $status  = 'success';
                $Product = Product::find($request->id);
                $slug    = $this->createSlug($request->title[$lang_id], $request->id);



                //ProductAddtionalInfo
                $get_ProductAddInInfo = ProductAddtionalInfo::where('product_id', $request->id)->get();
                foreach ($get_ProductAddInInfo as $key => $get_addInfo_delete) {
                    if (!in_array($get_addInfo_delete['id'], $request->info_id)) {
                        ProductAddtionalInfo::where('id', $get_addInfo_delete['id'])->delete();
                    }
                }

                // Product Site Advertisement
                $get_ProductSideAdv = ProductSiteAdvertisement::where('product_id', $request->id)->get();
                foreach ($get_ProductSideAdv as $key => $get_siteadv_delete) {
                    if (!in_array($get_siteadv_delete['id'], $request->adver_id)) {
                        ProductSiteAdvertisement::where('id', $get_siteadv_delete['id'])->delete();
                    }
                }
            } else {
                $message = translate('Add Successfully');
                $status  = 'success';
                $Product = new Product();
                $slug    = $this->createSlug($request->title[$lang_id]);
            }

            $transportationvehicle = NULL;
            if (isset($request->transportation_vehicle)) {
                if (!empty($request->transportation_vehicle)) {
                    $transportationvehicle = implode(',', $request->transportation_vehicle);
                }
            }
            $Product['random_rating']                  = $request->rating;
            $Product['availability']                   = $request->availability;
            $Product['slug']                           = $slug;
            $Product['description']                    = $request->description;
            $Product['can_be_booked_up_to_advance']    = $request->can_be_booked_up_to_advance;
            $Product['can_be_cancelled_up_to_advance'] = $request->can_be_cancelled_up_to_advance;
            $Product['excursion_type']                 = $request->golf_type;
            $Product['address']                        = $request->address;
            $Product['address_lattitude']              = $request->address_lattitude;
            $Product['address_longitude']              = $request->address_longitude;
            $Product['status']                         = isset($request->excertion_status) ? 'Active' : 'Deactive';
            $Product['per_modifi_or_cancellation']     = isset($request->per_modifi_or_cancellation) ? 1 : 0;
            $Product['product_bookable_type']          = $request->product_bookable_type;
            $Product['video']                          = $request->video;
            $Product['opening_hours']                  = $request->opening_hours;
            $Product['closing_hours']                  = $request->closing_hours;
            $Product['country']                        = $request->country;
            $Product['infant_age_limit']               = $request->infant_age_limit;
            $Product['child_age_limit']                = $request->child_age_limit;
            $Product['rate_valid_until']               = $request->rate_valid_until;
            $Product['state']                          = $request->state;
            $Product['city']                           = $request->city;
            $Product['note_on_sale_date']              = $request->note_on_sale_date;
            $Product['image_text']                     = $request->image_text;
            $Product['client_reward_point']            = $request->client_reward_point;
            $Product['client_reward_point_type']       = $request->client_reward_point_type;
            $Product['point_to_purchase_product']      = $request->point_to_purchase_product;
            $Product['how_many_are_sold']              = $request->how_many_are_sold;

            // $Product['pick_option']                    = $request->pick_option;
            // $Product['duration_text']                  = $request->duration_text;
            // $Product['duration']                       = $request->duration;
            // $Product['boat_location']                  = $request->boat_location;
            // $Product['boat_type']                      = $request->boat_type;
            // $Product['boat_maximum_capacity']          = $request->boat_maximum_capacity;
            // $Product['minimum_booking']                = $request->minimum_booking;
            // $Product['selling_price']                  = $request->selling_price;
            // $Product['original_price']                 = $request->original_price;
            // $Product['per_value']                      = $request->per_value;
            // $Product['minimum_people']                 = $request->minimum_people;
            // $Product['maximum_people']                 = $request->maximum_people;
            // $Product['affiliate_commission']      = $request->affiliate_commission;
            // $Product['option_note']               = $request->option_note;
            // $Product['booking_policy']            = $request->booking_policy;
            // $Product['tax_percentage']            = $request->tax_percentage;
            // $Product['service_amount']            = $request->service_amount;

            $Product['approx']                    = isset($request->approx) ? 1 : 0;
            $Product['timing_status']             = isset($request->timing_status) ? 1 : 0;
            $Product['tax_allowed']               = isset($request->tax_allowed) ? 1 : 0;
            $Product['service_allowed']           = isset($request->service_allowed) ? 1 : 0;
            $Product['is_recently']               = isset($request->is_recently) ? 1 : 0;
            $Product['holes']                     = $request->holes;
            $Product['yards']                     = $request->yards;
            $Product['pars']                      = $request->pars;
            $Product['blackout_date']             = json_encode(explode(',', $request->blackout_date));
            $Product['product_type']              = 'golf';
            $Product['transportation_vehicle']    = $transportationvehicle;
            if (!empty($request->suppliers)) {
                $Product['supplier'] = implode(',', $request->suppliers);
            }

            // print_die($request->all());
            if ($request->hasFile('image')) {
                $files           = $request->file('image');
                $random_no       = Str::random(5);
                $newImage        = time() . $random_no . '.' . $files->getClientOriginalExtension();
                $destinationPath = public_path('uploads/product_images');
                $imgFile         = Image::make($files->path());
                $height          = $imgFile->height();
                $width           = $imgFile->width();
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
                $destinationPath = public_path('uploads/product_images');
                $imgFile->save($destinationPath . '/' . $newImage);
                $Product['image'] = $newImage;
            }

            if ($request->hasFile('logo')) {
                $files           = $request->file('logo');
                $random_no       = Str::random(5);
                $newImage        = time() . $random_no . '.' . $files->getClientOriginalExtension();
                $destinationPath = public_path('uploads/product_images');
                $imgFile         = Image::make($files->path());
                $height          = $imgFile->height();
                $width           = $imgFile->width();
                $imgFile->resize(54, 54, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $imgFile->resize(54, 54, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $destinationPath = public_path('uploads/product_images');
                $imgFile->save($destinationPath . '/' . $newImage);
                $Product['logo'] = $newImage;
            }

            if ($request->video_thumbnail_dlt=='') {
                $Product['video_thumbnail'] = $request->video_thumbnail_dlt;
            }
            if ($request->hasFile('video_thumbnail')) {
                $files           = $request->file('video_thumbnail');
                $random_no       = Str::random(5);
                $newImage        = time() . $random_no . '.' . $files->getClientOriginalExtension();
                $destinationPath = public_path('uploads/product_images');
                $imgFile         = Image::make($files->path());
                $height          = $imgFile->height();
                $width           = $imgFile->width();
                $imgFile->resize(400, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $imgFile->resize(400, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $destinationPath = public_path('uploads/product_images');
                $imgFile->save($destinationPath . '/' . $newImage);
                $Product['video_thumbnail'] = $newImage;
            }

            if ($request->hasFile('popup_image')) {
                $files = $request->file('popup_image');
                $random_no = Str::random(5);
                $newImage = time() . $random_no . '.' . $files->getClientOriginalExtension();
                $destinationPath = public_path('uploads/product_images');
                $imgFile = Image::make($files->path());

                $destinationPath = public_path('uploads/product_images');
                $imgFile->save($destinationPath . '/' . $newImage);
                $Product['popup_image'] = $newImage;
            }

             // Product POp up
            if ($request->hasFile('pro_popup_image')) {
                $files = $request->file('pro_popup_image');
                $random_no = Str::random(5);
                $newImage = time() . $random_no . '.' . $files->getClientOriginalExtension();
                $destinationPath = public_path('uploads/product_images');
                $imgFile = Image::make($files->path());
                $height = $imgFile->height();
                $width = $imgFile->width();
                $imgFile->resize(400, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $imgFile->resize(400, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $destinationPath = public_path('uploads/product_images');
                $imgFile->save($destinationPath . '/' . $newImage);
                $Product['pro_popup_image'] = $newImage;
            }
             //ThumNail IMage
            if ($request->hasFile('pro_popup_thumnail_image')) {
                $files           = $request->file('pro_popup_thumnail_image');
                $random_no       = Str::random(5);
                $newImage        = time() . $random_no . '.' . $files->getClientOriginalExtension();
                $destinationPath = public_path('uploads/product_images/popup_image');
                $imgFile         = Image::make($files->path());
                $height          = $imgFile->height();
                $width           = $imgFile->width();
                $imgFile->resize(400, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $imgFile->resize(400, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $destinationPath = public_path('uploads/product_images/popup_image');
                $imgFile->save($destinationPath . '/' . $newImage);
                $Product['pro_popup_thumnail_image'] = $newImage;
            }
            // Popup Video
            if ($request->hasFile('pro_popup_video')) {
                $files = $request->file('pro_popup_video');
                    $random_no       = uniqid();
                    $img             = $files;
                    $ext             = $files->getClientOriginalExtension();
                    $new_name        = $random_no . time() . '.' . $ext;
                    $destinationPath =  public_path('uploads/product_images/popup_image');
                    $img->move($destinationPath, $new_name);
                    $Product['pro_popup_video'] = $new_name;

                
            }
            // $Product['pro_popup_link']     = $request->pro_popup_link;
            
            $Product->save();
            $product_id = $Product->id;

            // Product Language
            if (!empty($request->category)) {
                ProductCategory::where('product_id', $request->id)->delete();
                foreach ($request->category as $key => $value) {
                    $ProductCategory = new ProductCategory();
                    if ($value != '') {
                        $ProductCategory->category = $value;
                        $ProductCategory->sub_category = $request->sub_category[$key];
                        $ProductCategory->product_id = $product_id;
                        $ProductCategory->save();
                    }
                }
            }




            // Product Language
            $get_languages = Language::where(['status'=>'Active','is_delete'=>0])->get();

            if (!empty($get_languages)) {
                ProductLanguage::where('product_id', $request->id)->where('language_id',$lang_id)->delete();
                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('product_language',['language_id'=>$value['id'],'product_id'=>$request->id],'row')) {

                    $ProductLanguage = new ProductLanguage();

                        $ProductLanguage->description       = isset($request->title[$value['id']]) ?  $request->title[$value['id']] : $request->title[$lang_id];
                        $ProductLanguage->short_description = isset($request->short_description[$value['id']]) ?  $request->short_description[$value['id']] : $request->short_description[$lang_id];
                        $ProductLanguage->main_description  = isset($request->main_description[$value['id']]) ? change_str($request->main_description[$value['id']]) : $request->main_description[$lang_id];
                        
                        // Experice Icon
                        $ProductLanguage->experience_heading = isset($request->experience_heading[$value['id']]) ?  $request->experience_heading[$value['id']] : $request->experience_heading[$lang_id];
                        //  // Product Pop up
                        $ProductLanguage->pro_popup_title     = isset($request->pro_popup_title[$value['id']]) ?  $request->pro_popup_title[$value['id']] : $request->pro_popup_title[$lang_id];
                        $ProductLanguage->pro_popup_desc      = isset($request->pro_popup_desc[$value['id']]) ?  $request->pro_popup_desc[$value['id']] : $request->pro_popup_desc[$lang_id];  

                        $ProductLanguage->option_note         = isset($request->option_note[$value['id']]) ? change_str($request->option_note[$value['id']]) : $request->option_note[$lang_id];
                        $ProductLanguage->booking_policy      = isset($request->booking_policy[$value['id']]) ? change_str($request->booking_policy[$value['id']]) : $request->booking_policy[$lang_id];

                        $ProductLanguage->related_product_title = isset($request->related_product_title[$value['id']]) ?  $request->related_product_title[$value['id']] : $request->related_product_title[$lang_id];

                        $ProductLanguage->rantel_tip         = isset($request->rantel_tip[$value['id']]) ? change_str($request->rantel_tip[$value['id']]) : $request->rantel_tip[$lang_id];
                        $ProductLanguage->transfer_tip      = isset($request->transfer_tip[$value['id']]) ? change_str($request->transfer_tip[$value['id']]) : $request->transfer_tip[$lang_id];

                        $ProductLanguage->language_id = $value['id'];
                        $ProductLanguage->product_id = $product_id;
                        $ProductLanguage->save();
                    }
                }
            }

            // Product Setting
            ProductSetting::where(['product_id' => $product_id, 'type' => 'golf'])->delete();
            if (!empty($request->product_setting)) {
                foreach ($request->product_setting as $key => $PS) {
                    if($key == 'add_to_recom_tours' || $key == 'recom_tours_main_page_big_picture' || $key == 'recom_tours_main_page_small_picture' || $key == 'recom_tours_main_page_small_picture'){
                        $get_check_ = ProductSetting::where(['country_id'=> $request->country,'meta_title'=>$key])->count();
                        if($key == 'recom_tours_main_page_small_picture'){
                            if($get_check_ >= 2){
                                ProductSetting::where(['country_id'=> $request->country,'meta_title'=>$key])->first()->delete();
                            }
                        }else{
                            if($get_check_ > 0){
                                ProductSetting::where(['country_id'=> $request->country,'meta_title'=>$key])->delete();
                            }
                        }
                    }

                    $ProductSetting = new ProductSetting();
                    $ProductSetting['product_id']   = $product_id;
                    $ProductSetting['type']         = 'golf';
                    $ProductSetting['meta_title']   = $key;
                    $ProductSetting['country_id'] = $request->country;
                    if($key == 'recom_tours_main_page_big_picture'){
                        if($PS == 'on'){
                            if ($request->hasFile('recom_big_pic')) {
                                $files           = $request->file('recom_big_pic');
                                $random_no       = Str::random(5);
                                $newImage        = time() . $random_no . '.' . $files->getClientOriginalExtension();
                                $destinationPath = public_path('uploads/product_images/recom_big_pic');
                                $imgFile         = Image::make($files->path());
                                $height          = $imgFile->height();
                                $width           = $imgFile->width();
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
                                $product_update  = Product::where('id',$product_id)->first();
                                if($product_update){
                                    $product_update['recommend_pic'] = $newImage;
                                    $product_update->save();

                                }
                            }
                        }
                    }
                    $ProductSetting['meta_type']    = $PS == 'on' ? 'radio' : 'value';
                    $ProductSetting['meta_value']   = $PS == 'on' ? 1 : $PS;
                    $ProductSetting->save();
                    // print_die($ProductSetting);
                }
            }

            // Product Information
            ProductInfo::where(['product_id' => $product_id])->delete();
            if (!empty($request->product_info)) {
                foreach ($request->product_info as $key => $PI) {
                    $ProductInfo               = new ProductInfo();
                    $ProductInfo['product_id'] = $product_id;
                    $ProductInfo['title']      = $key;
                    $ProductInfo['value']      = $PI;
                    $ProductInfo->save();
                }
            }

            if (isset($request->info_title)) {
                if (count($request->info_title) > 0) {
                    if ($request->info_title) {
                        // ProductAddtionalInfo::where(['product_id' => $product_id])->delete();
                        ProductAdditionalInfoLanguage::where(['product_id' => $product_id])->where('language_id',$lang_id)->delete();
                        $info_doc = $request->info_doc;
                        foreach ($request->info_id as $key => $value_5) {
                            if ($value_5 != '') {
                                $product_info = ProductAddtionalInfo::find($value_5);
                            } else {
                                $product_info = new ProductAddtionalInfo();
                            }

                            $product_info['product_id'] = $product_id;
                            if ($request->hasFile('info_doc')) {
                                if (isset($request->info_doc[$key]) && $request->info_doc[$key] != '') {
                                    $files = $request->file('info_doc')[$key];

                                    $random_no = uniqid();
                                    $img = $files;
                                    $ext = $files->getClientOriginalExtension();
                                    $new_name = $random_no . time() . '.' . $ext;
                                    $destinationPath = public_path('uploads/product');

                                    $img->move($destinationPath, $new_name);
                                    $product_info['image'] = $new_name;
                                }
                            }
                            $product_info->save();

                            foreach ($get_languages as $lang_key => $value) {
                                if (!getDataFromDB('product_additional_info_language',['language_id'=>$value['id'],'product_id' => $request->id,'product_additional_info_id'=> $product_info->id ],'row')) {    

                                    $ProductAdditionalInfoLanguage = new ProductAdditionalInfoLanguage();
                                    $ProductAdditionalInfoLanguage['product_id']  = $product_id;
                                    $ProductAdditionalInfoLanguage['product_additional_info_id'] = $product_info->id;
                                    $ProductAdditionalInfoLanguage['language_id'] = $value['id'];
                                    $ProductAdditionalInfoLanguage['description'] = isset($request->info_title[$value['id']][$key]) ?  $request->info_title[$value['id']][$key] : $request->info_title[$lang_id][$key];  
                                

                                    $ProductAdditionalInfoLanguage->save();
                                }
                            }
                        }
                    }
                }
            }

            //  Week Tour Price
            if (isset($request->general_tour_week)) {
                foreach ($request->general_tour_week as $gweekKey => $GTW) {
                    $ProductOptionWeekTour_ = ProductOptionWeekTour::where(['product_id' => $product_id, 'for_general' => 1])->get();
                    foreach ($ProductOptionWeekTour_ as $WeekTour_key => $get_productoptionweektour_delete) {
                        if (!in_array($get_productoptionweektour_delete['id'], $request->general_week_tour_id)) {
                            ProductOptionWeekTour::where('id', $get_productoptionweektour_delete['id'])->delete();
                        }
                    }

                    if ($request->general_week_tour_id[$gweekKey] != '') {
                        $ProductOptionWeekTour = ProductOptionWeekTour::find($request->general_week_tour_id[$gweekKey]);
                    } else {
                        $ProductOptionWeekTour = new ProductOptionWeekTour();
                    }
                    $ProductOptionWeekTour['product_id'] = $product_id;
                    $ProductOptionWeekTour['product_option_id'] = "";
                    $ProductOptionWeekTour['week_day'] = $GTW;
                    $ProductOptionWeekTour['for_general'] = 1;
                    $ProductOptionWeekTour['adult'] = $request->general_tour_price[$gweekKey];
                    $ProductOptionWeekTour->save();
                }
            }

            // {{ Second Highlight Tab Start }}
            // Feature Higlight Heading Language
            if (!empty($request->facilities_title)) {
                MetaGlobalLanguage::where('meta_title', 'golf_facilities_heading')->where('language_id',$lang_id)->where('product_id', $product_id)->delete();
                foreach ($request->facilities_title as $key => $value) {
                    $MetaGlobalLanguage = new MetaGlobalLanguage();
                    if ($value != '') {
                        $MetaGlobalLanguage->meta_title  = 'golf_facilities_heading';
                        $MetaGlobalLanguage->meta_parent = 'golf_facilities';
                        $MetaGlobalLanguage->title       = $request->facilities_title[$key];
                        $MetaGlobalLanguage->language_id = $key;
                        $MetaGlobalLanguage->product_id  = $product_id;
                        $MetaGlobalLanguage->status      = 'Active';
                        $MetaGlobalLanguage->save();
                    }
                }
            }

            // print_die($request->all());


            //YachtFeatureHighlight
            $get_yatch_fetaure_high = YachtFeatureHighlight::where('product_id', $request->id)->get();
            foreach ($get_yatch_fetaure_high as $key => $get_feat_delete) {
                if (!in_array($get_feat_delete['id'], $request->facilites_highlight_id)) {
                    YachtFeatureHighlight::where('id', $get_feat_delete['id'])->delete();
                }
            }


            // Feature highlight Key Languag
            if (!empty($request->facilites_highlight_id)) {
                // YachtFeatureHighlight::where('product_id', $product_id)->whereNotIn('id', $request->facilites_highlight_id)->delete();
                YachtFeatureHighlightLanguage::where('product_id', $product_id)->where('language_id',$lang_id)->delete();
                foreach ($request->facilites_highlight_id as $key => $FHT) {
                    if ($FHT != '') {
                        $YachtFeatureHighlight               = YachtFeatureHighlight::find($FHT);
                    } else {
                        $YachtFeatureHighlight               = new YachtFeatureHighlight();
                    }


                    $YachtFeatureHighlight['product_id'] = $product_id;
                    $YachtFeatureHighlight['type']       = "golf";
                    $YachtFeatureHighlight['status']     = isset($request->highlight_status[$key]) ? $request->highlight_status[$key] : "Deactive";
                    if ($request->hasFile('facilities_image')) {
                        if (isset($request->facilities_image[$key])) {
                            $files           = $request->file('facilities_image')[$key];
                            $random_no       = Str::random(5);
                            $newImage        = time() . $random_no . '.' . $files->getClientOriginalExtension();
                            $destinationPath = public_path('uploads/product_images');
                            $imgFile         = Image::make($files->path());
                            $height          = $imgFile->height();
                            $width           = $imgFile->width();
                            $imgFile->resize(400, 300, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $imgFile->resize(400, 300, function ($constraint) {
                                $constraint->aspectRatio();
                            });

                            $destinationPath = public_path('uploads/product_images');
                            $imgFile->save($destinationPath . '/' . $newImage);
                            $YachtFeatureHighlight['image'] = $newImage;
                        }
                    }

                    $YachtFeatureHighlight->save();

                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('yacht_feature_highlight_language',['language_id'=>$value['id'],'product_id' => $request->id,'feature_highlight_id'=> $YachtFeatureHighlight->id ],'row')) { 

                            $YachtFeatureHighlightLanguage = new YachtFeatureHighlightLanguage();
                       
                            $YachtFeatureHighlightLanguage->title                = isset($request->facilites_highlight_title[$value['id']][$key]) ?  $request->facilites_highlight_title[$value['id']][$key] : $request->facilites_highlight_title[$lang_id][$key];
                            $YachtFeatureHighlightLanguage->description          =  isset($request->facilites_highlight_text[$value['id']][$key]) ?  $request->facilites_highlight_text[$value['id']][$key] : $request->facilites_highlight_text[$lang_id][$key];

                            $YachtFeatureHighlightLanguage->language_id          = $value['id'];
                            $YachtFeatureHighlightLanguage->product_id           = $product_id;
                            $YachtFeatureHighlightLanguage->feature_highlight_id = $YachtFeatureHighlight->id;
                            $YachtFeatureHighlightLanguage->save();
                        }
                    }
                }
            }

            // Highlights
            $get_Producthigh = ProductHighlights::where('product_id', $request->id)->get();
            foreach ($get_Producthigh as $key => $get_highlight_delete) {
                if (!in_array($get_highlight_delete['id'], $request->highlights_id)) {
                    ProductHighlights::where('id', $get_highlight_delete['id'])->delete();
                }
            }
            if (isset($request->highlights_title)) {
                if (count($request->highlights_title) > 0) {
                    if ($request->highlights_title) {
                        
                        // ProductHighlights::where(['product_id' => $product_id])->delete();
                        ProductHighlightLanguage::where(['product_id' => $product_id])->where('language_id',$lang_id)->delete();
                        foreach ($request->highlights_id as $key => $value_2) {

                            if ($value_2 != '') {
                                $product_highlights = ProductHighlights::find($value_2);
                            } else {
                                $product_highlights = new ProductHighlights();
                            }

                            $product_highlights['product_id'] = $product_id;
                            $product_highlights->save();

                        
                            foreach ($get_languages as $lang_key => $value) {
                                if (!getDataFromDB('product_highlight_language',['language_id'=>$value['id'],'product_id' => $request->id,'highlight_id'=> $product_highlights->id ],'row')) {     
                               
                                    $ProductHighlightLanguage = new ProductHighlightLanguage();
                                    $ProductHighlightLanguage['product_id']  = $product_id;
                                    $ProductHighlightLanguage['language_id'] = $value['id'];
                                    $ProductHighlightLanguage['highlight_id'] = $product_highlights->id;
                                    $ProductHighlightLanguage['title']       = isset($request->highlights_title[$value['id']][$key]) ?  $request->highlights_title[$value['id']][$key] : $request->highlights_title[$lang_id][$key];
                                    $ProductHighlightLanguage['description'] = isset($request->highlights_description[$value['id']][$key]) ?  $request->highlights_description[$value['id']][$key] : $request->highlights_description[$lang_id][$key];
                                    $ProductHighlightLanguage->save();
                                }
                            }
                        }
                    }
                }
            }
            // {{ Second Highlight Tab End }}

            // {{ Third Timing Tab Start }}
            // Timings
            if ($request->day) {
                $Day      = $request->day;
                $Timefrom = $request->time_from;
                $Timeto   = $request->time_to;

                if ($request->id != '') {
                    $get_timings = ProductTimings::where('product_id', $request->id)->delete();
                }
                foreach ($request->day as $key => $value_3) {
                    if ($value_3 != '') {
                        $product_timings               = new ProductTimings();
                        $product_timings['product_id'] = $product_id;
                        $product_timings['day']        = $Day[$key];
                        $product_timings['time_from']  = isset($Timefrom[$key]) ? $Timefrom[$key] : '';
                        $product_timings['time_to']    = isset($Timeto[$key]) ? $Timeto[$key] : '';
                        $product_timings['is_close']   = isset($request->is_close[$Day[$key]]) ? 1 : 0;
                        if ($product_timings['time_from'] == '' || $product_timings['time_to'] == '') {
                            // $product_timings['is_close']   = 1;
                        }
                        $product_timings->save();
                    }
                }
            }
            // {{ Third Timing Tab End }}

            // {{ Fifth Image Tab Start }}
            //Muliple File
            $ProductImage = ProductImages::where('product_id', $request->id)->get();
            if (isset($request->image_id)) {
                foreach ($ProductImage as $key => $image_delete) {
                    if (!in_array($image_delete['id'], $request->image_id)) {
                        ProductImages::where('id', $image_delete['id'])->delete();
                    }
                }
            } else {
                if ($request->id != '') {
                    foreach ($ProductImage as $key => $image_delete) {
                        ProductImages::where('id', $image_delete['id'])->delete();
                    }
                }
            }

            $Sort_order_images = $request->sort_order_images;
            $get_pro_images    = ProductImages::where('product_id', $request->id)->get();
            foreach ($get_pro_images as $key => $image_val) {
                $updatedta = [];
                $updatedta['sort_order_images'] = $request->sort_order_images[$key];
                ProductImages::where('id', $image_val['id'])->update($updatedta);
            }

            // Multiple IMages
            if ($request->hasFile('files')) {
                $files = $request->file('files');
                foreach ($files as $fileKey => $image) {
                    $ProductImages                      = new ProductImages();
                    $random_no                          = Str::random(5);
                    $ProductImages['product_images']    = $newImage = time() . $random_no . '.' . $image->getClientOriginalExtension();
                    $ProductImages['sort_order_images'] = $request->sort_order_images[$fileKey];
                    $ProductImages['product_id']        = $product_id;
                    $destinationPath                    = public_path('uploads/product_images');
                    $imgFile                            = Image::make($image->path());
                    $height                             = $imgFile->height();
                    $width                              = $imgFile->width();
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
                    $destinationPath = public_path('uploads/product_images');
                    $imgFile->save($destinationPath . '/' . $newImage);
                    $ProductImages->save();
                }
            }
            // {{ Fifth Image Tab End }}




            //{{ Hotels }}
            if (!empty($request->hotels_id)) {
                Productyachttransferoption::where('id', $product_id)->where('type', 'golf')->whereNotIn('id', $request->hotels_id)->delete();
                Productyachttransferoptionlanguage::where('id', $product_id)->whereNotIn('product_yacht_transfer_option_id', $request->hotels_id)->where('language_id',$lang_id)->delete();
                foreach ($request->hotels_id as $hotel_key => $hotel_value) {
                    if ($hotel_value != "") {
                        $Productyachttransferoption = Productyachttransferoption::find($hotel_value);
                    } else {
                        $Productyachttransferoption = new Productyachttransferoption();
                    }
                    $Productyachttransferoption->hotel      = $request->hotel[$hotel_key];
                    $Productyachttransferoption->link       = $request->link[$hotel_key];
                    $Productyachttransferoption->product_id = $product_id;
                    $Productyachttransferoption->price     = $request->hotel_price[$hotel_key];
                    $Productyachttransferoption->location  = $request->location[$hotel_key];
                    $Productyachttransferoption->latitude  = $request->location_lat[$hotel_key];
                    $Productyachttransferoption->langitude = $request->location_lag[$hotel_key];
                    $Productyachttransferoption->type      = "golf";
                    $Productyachttransferoption->save();

                    // foreach ($request->hotel_title as $ProKey => $Q) {
                    //     $Productyachttransferoptionlanguage = new Productyachttransferoptionlanguage();
                    //     $Productyachttransferoptionlanguage['product_id']  = $product_id;
                    //     $Productyachttransferoptionlanguage['language_id'] = $ProKey;
                    //     $Productyachttransferoptionlanguage['product_yacht_transfer_option_id'] = $Productyachttransferoption->id;
                    //     $Productyachttransferoptionlanguage['title'] = $Q[$hotel_key];
                    //     $Productyachttransferoptionlanguage->save();
                    // }
                }
            }
            //{{ Hotels End }}

            // print_die($request->all());
            // {{Rooms}}
            if (!empty($request->room_id)) {
                GolfRoom::where('id', $product_id)->whereNotIn('id', $request->room_id)->delete();
                GolfRoomLanguage::where('product_id', $product_id)->where('language_id',$lang_id)->delete();
                foreach ($request->room_id as $room_key => $room_value) {
                    if ($room_value != "") {
                        $GolfRoom = GolfRoom::find($room_value);
                    } else {
                        $GolfRoom = new GolfRoom();
                    }
                    $GolfRoom->product_id = $product_id;
                    $GolfRoom->status     = "Active";
                    $GolfRoom->save();
                    foreach ($request->room_name as $room_name_key => $room_name_value) {
                        $GolfRoomLanguage = new GolfRoomLanguage();
                        $GolfRoomLanguage['product_id']  = $product_id;
                        $GolfRoomLanguage['language_id'] = $room_name_key;
                        $GolfRoomLanguage['golf_room_id'] = $GolfRoom->id;
                        $GolfRoomLanguage['title']       = $room_name_value[$room_key];
                        $GolfRoomLanguage['description'] = change_str($request->room_description[$room_name_key][$room_key]);
                        $GolfRoomLanguage->save();
                    }
                }
            }
            // {{Rooms Ens}}


            // {{ Seventh ADV Tab Start }}
            //Site Advertisement
            if (isset($request->adver_id) && count($request->adver_id) > 0) {
                if ($request->adver_id) {
                    // ProductSiteAdvertisement::where(['product_id' => $product_id])->delete();
                    ProductSiteAdvertisementLanguage::where(['product_id' => $product_id])->where('language_id',$lang_id)->delete();

                    foreach ($request->adver_id as $key => $value_7) {
                        if ($value_7 != '') {
                            $product_advertisement = ProductSiteAdvertisement::find($value_7);
                        } else {
                            $product_advertisement = new ProductSiteAdvertisement();
                        }

                        $product_advertisement['product_id'] = $product_id;
                        $product_advertisement['link'] = $request->adver_link[$key];

                        if ($request->hasFile('adver_image')) {
                            if (isset($request->adver_image[$key]) && $request->adver_image[$key] != '') {
                                $files = $request->file('adver_image')[$key];

                                $random_no = uniqid();
                                $img = $files;
                                $ext = $files->getClientOriginalExtension();
                                $new_name = $random_no . time() . '.' . $ext;
                                $destinationPath = public_path('uploads/product');
                                $img->move($destinationPath, $new_name);
                                $product_advertisement['image'] = $new_name;
                            }
                        }
                        $product_advertisement->save();
                        foreach ($get_languages as $lang_key => $value) {
                            if (!getDataFromDB('product_site_advertisement_langauge',['language_id'=>$value['id'],'product_id' => $request->id,'site_advertisement_id'=> $product_advertisement->id ],'row')) {    
                                $ProductSiteAdvertisementLanguage = new ProductSiteAdvertisementLanguage();
                                $ProductSiteAdvertisementLanguage['product_id'] = $product_id;
                                $ProductSiteAdvertisementLanguage['language_id'] = $value['id'];
                                $ProductSiteAdvertisementLanguage['site_advertisement_id'] = $product_advertisement->id;
                                $ProductSiteAdvertisementLanguage['title'] = isset($request->adver_title[$value['id']][$key]) ?  $request->adver_title[$value['id']][$key] : $request->adver_title[$lang_id][$key];
                                $ProductSiteAdvertisementLanguage['description'] = isset($request->adver_desc[$value['id']][$key]) ?  $request->adver_desc[$value['id']][$key] : $request->adver_desc[$lang_id][$key];
                                $ProductSiteAdvertisementLanguage->save();
                            }
                        }

                    }
                }
            }
            // {{ Seventh ADV Tab End }}        


            //REQUEST POPUP
            if (isset($request->request_description) && count($request->request_description) > 0) {
                if ($request->request_description) {
                    // ProductRequestPopup::where(['product_id' => $product_id,'type'=>'golf'])->delete();
                    ProductRequestPopupLanguage::where(['product_id' => $product_id,'type'=>'golf'])->where('language_id',$lang_id)->delete();

                    foreach ($request->popup_id as $key => $value_7) {
                       
                        if ($value_7 != '') {
                            $ProductRequestPopup = ProductRequestPopup::find($value_7);
                        } else {
                            $ProductRequestPopup = new ProductRequestPopup();
                        }    
                        

                        $ProductRequestPopup['product_id'] = $product_id;
                        $ProductRequestPopup['type']       = 'golf';
                       
                        $ProductRequestPopup->save();

                        foreach ($get_languages as $lang_key => $value) {
                            if (!getDataFromDB('product_request_popup_language',['language_id'=>$value['id'],'product_id' => $request->id,'request_popup_id'=> $ProductRequestPopup->id ],'row')) {       
                            
                                $ProductRequestPopupLanguage = new ProductRequestPopupLanguage();
                                $ProductRequestPopupLanguage['product_id']  = $product_id;
                                $ProductRequestPopupLanguage['language_id'] = $value['id'];
                                $ProductRequestPopupLanguage['request_popup_id'] = $ProductRequestPopup->id;
                                
                                $ProductRequestPopupLanguage['description'] = isset($request->request_description[$value['id']][$key]) ?  $request->request_description[$value['id']][$key] : $request->request_description[$lang_id][$key];

                                $ProductRequestPopupLanguage['type']        = 'golf';

                                $ProductRequestPopupLanguage->save();
                            }
                        }
                    }
                }
            }


            // Expireance Icon middle heading start
            if (!empty($request->experience_heading)) {
                MetaGlobalLanguage::where('meta_parent', 'middle_experience_heading')->where('product_id',$product_id)->where('language_id',$lang_id)->delete();
                

                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('meta_global_language',['language_id'=>$value['id'],'meta_parent'=>'middle_experience_heading','product_id' => $product_id],'row')) {      
                        $MetaGlobalLanguage = new MetaGlobalLanguage();
                    
                        $MetaGlobalLanguage->meta_parent = 'middle_experience_heading';
                        $MetaGlobalLanguage->meta_title  = 'heading_title';
                        $MetaGlobalLanguage->title       = isset($request->experience_heading[$value['id']]) ?  $request->experience_heading[$value['id']] : $request->experience_heading[$lang_id];
                        $MetaGlobalLanguage->product_id  = $product_id;
                        $MetaGlobalLanguage->language_id = $value['id'];
                        $MetaGlobalLanguage->status      = 'Active';
                        $MetaGlobalLanguage->save();
                    }
                }
            }
            
            // Expireance Icon middle heading End

            // EXPERIENECE ICON
            $get_ExpIcon = ProductExprienceIcon::where(['product_id'=> $product_id,'type'=>'golf'])->where('position_type','middel')->get();
            foreach ($get_ExpIcon as $key => $val) {
                if (!in_array($val['id'], $request->exper_id)) {
                    ProductExprienceIcon::where('id', $val['id'])->delete();
                }
            }
            // Expireance Icon Middle
            if (!empty($request->exper_id)) {
                if ($request->exper_id) {
                    
                    ProductExprienceIconLanguage::where(['product_id'=> $product_id,'type'=>'golf'])->where('language_id',$lang_id)->where('position_type','middel')->delete();
                    foreach ($request->exper_id as $key => $over_value) {                
                        if($over_value !=''){
                            $ProductExprienceIcon       = ProductExprienceIcon::find($over_value);
                        }else{
                            $ProductExprienceIcon       = new ProductExprienceIcon();
                        }
                        $ProductExprienceIcon->product_id  = $product_id;
                        $ProductExprienceIcon->type        = "golf";
                        $ProductExprienceIcon->position_type = "middel";
                        if ($request->hasFile('exp_icon')) {
                            if (isset($request->exp_icon[$key])) {
                                $files           = $request->file('exp_icon')[$key];
                                $random_no       = uniqid();
                                $img             = $files;
                                $ext             = $files->getClientOriginalExtension();
                                $new_name        = $random_no . time() . '.' . $ext;
                                $destinationPath = public_path('uploads/expericence_icons');
                                $img->move($destinationPath, $new_name);
                                $ProductExprienceIcon->image  = $new_name;
                                $ProductExprienceIcon->status = 'Active';
                            }
                        }
                        $ProductExprienceIcon->save();
                        $exp_id = $ProductExprienceIcon->id;

                        foreach ($get_languages as $lang_key => $value) {
                            if (!getDataFromDB('product_experience_icon_language',['language_id'=>$value['id'],'product_id' => $request->id,'experience_icon_id'=> $ProductExprienceIcon->id ,'position_type'=>'middel'],'row')) {   

                                $ProductExprienceIconLanguage = new ProductExprienceIconLanguage();
                                $ProductExprienceIconLanguage['product_id']         = $product_id;
                                $ProductExprienceIconLanguage['experience_icon_id'] = $exp_id;
                                $ProductExprienceIconLanguage['language_id']        = $value['id'];
                                $ProductExprienceIconLanguage['title']              = isset($request->exp_title[$value['id']][$key]) ?  $request->exp_title[$value['id']][$key] : $request->exp_title[$lang_id][$key];
                                $ProductExprienceIconLanguage['position_type']       = 'middel';

                                
                                $ProductExprienceIconLanguage['type']               = 'golf';
                                $ProductExprienceIconLanguage->save();
                            }
                        }
                    }
                }
            }

            // Expireance Icon Header

                // Expireance Icon Header heading start
                    if (!empty($request->header_experience_heading)) {
                        MetaGlobalLanguage::where('meta_parent', 'header_experience_heading')->where('product_id',$product_id)->delete();
                       

                        foreach ($get_languages as $key => $value) {
                            if (!getDataFromDB('meta_global_language',['language_id'=>$value['id'],'meta_parent'=>'header_experience_heading','product_id' => $product_id],'row')) {     
                                $MetaGlobalLanguage = new MetaGlobalLanguage();
                            
                                $MetaGlobalLanguage->meta_parent = 'header_experience_heading';
                                $MetaGlobalLanguage->meta_title  = 'heading_title';
                                $MetaGlobalLanguage->product_id  = $product_id;
                                $MetaGlobalLanguage->title       = isset($request->header_experience_heading[$value['id']]) ?  $request->header_experience_heading[$value['id']] : $request->header_experience_heading[$lang_id];
                                $MetaGlobalLanguage->language_id = $value['id'];
                                $MetaGlobalLanguage->status      = 'Active';
                                $MetaGlobalLanguage->save();
                            }
                        }
                    }
                // Expireance Icon Header heading End

                if (!empty($request->header_exper_id)) {
                    if ($request->header_exper_id) {
                        $header_exper_id_arr = array_filter($request->header_exper_id, fn($value) => !is_null($value) && $value !== '');
                        // return $header_exper_id_arr;
                        ProductExprienceIcon::whereNotIn('id', $header_exper_id_arr)->where('product_id',$product_id)->where('type','golf')->where('position_type','upper')->delete();
                        ProductExprienceIconLanguage::where(['product_id'=> $product_id,'type'=>'golf'])->where('position_type','upper')->where('language_id',$lang_id)->delete();
                        foreach ($request->header_exper_id as $value_key => $header_exper_value) {                
                            if($header_exper_value !=''){
                                $ProductExprienceIconHeader       = ProductExprienceIcon::find($header_exper_value);
                            }else{
                                $ProductExprienceIconHeader       = new ProductExprienceIcon();
                            }
                            $ProductExprienceIconHeader->product_id    = $product_id;
                            $ProductExprienceIconHeader->type          = "golf";
                            $ProductExprienceIconHeader->position_type = "upper";
                            if ($request->hasFile('header_exp_icon')) {
                                if (isset($request->header_exp_icon[$value_key])) {
                                    $files           = $request->file('header_exp_icon')[$value_key];
                                    $random_no       = uniqid();
                                    $img             = $files;
                                    $ext             = $files->getClientOriginalExtension();
                                    $new_name        = $random_no . time() . '.' . $ext;
                                    $destinationPath = public_path('uploads/header_expericence_icons');
                                    $img->move($destinationPath, $new_name);
                                    $ProductExprienceIconHeader->image  = $new_name;
                                    $ProductExprienceIconHeader->status = 'Active';
                                }
                            }
                            $ProductExprienceIconHeader->save();
                            $exp_id = $ProductExprienceIconHeader->id;
                            
                            foreach ($get_languages as $lang_key => $value) {
                                if (!getDataFromDB('product_experience_icon_language',['language_id'=>$value['id'],'product_id' => $request->id,'experience_icon_id'=> $ProductExprienceIconHeader->id ,'position_type'=>'upper'],'row')) {    

                                    $ProductExprienceIconLanguageHeader                       = new ProductExprienceIconLanguage();
                                    $ProductExprienceIconLanguageHeader['product_id']         = $product_id;
                                    $ProductExprienceIconLanguageHeader['experience_icon_id'] = $ProductExprienceIconHeader->id;
                                    $ProductExprienceIconLanguageHeader['position_type']      = 'upper';
                                    $ProductExprienceIconLanguageHeader['language_id']        = $value['id'];
                                    $ProductExprienceIconLanguageHeader['title']              = isset($request->header_exp_title[$value['id']][$value_key]) ?  $request->header_exp_title[$value['id']][$value_key] : $request->header_exp_title[$lang_id][$value_key];
                                    $ProductExprienceIconLanguageHeader['information']        = isset($request->header_exp_info[$value['id']][$value_key]) ?  $request->header_exp_info[$value['id']][$value_key] : $request->header_exp_info[$lang_id][$value_key];
                                    $ProductExprienceIconLanguageHeader['type']               = 'golf';
                                    $ProductExprienceIconLanguageHeader->save();
                                }
                            }


                        }
                    }
                }


                // Opening Time heading start
                if (!empty($request->opening_time_heading)) {
                    MetaGlobalLanguage::where('meta_parent', 'golf_opening_heading')->where('product_id',$product_id)->where('language_id',$lang_id)->delete();
                  

                    foreach ($get_languages as $key => $value) {
                        if (!getDataFromDB('meta_global_language',['language_id'=>$value['id'],'meta_parent'=>'golf_opening_heading','product_id' => $product_id],'row')) {       
                           $MetaGlobalLanguage = new MetaGlobalLanguage();
                        
                            $MetaGlobalLanguage->meta_parent = 'golf_opening_heading';
                            $MetaGlobalLanguage->meta_title  = 'heading_title';
                            $MetaGlobalLanguage->title       = isset($request->opening_time_heading[$value['id']]) ?  $request->opening_time_heading[$value['id']] : $request->opening_time_heading[$lang_id];
                            $MetaGlobalLanguage->product_id  = $product_id;
                            $MetaGlobalLanguage->language_id = $value['id'];
                            $MetaGlobalLanguage->status      = 'Active';
                            $MetaGlobalLanguage->save();
                        }
                    }
                }

                ///Addtionaol Heading
                if (!empty($request->additional_heading)) {
                    MetaGlobalLanguage::where('meta_parent', 'golf_additional_heading')->where('product_id',$product_id)->where('language_id',$lang_id)->delete();
                   
                    foreach ($get_languages as $key => $value) {
                        if (!getDataFromDB('meta_global_language',['language_id'=>$value['id'],'meta_parent'=>'golf_additional_heading','product_id' => $product_id],'row')) {     
                           $MetaGlobalLanguage = new MetaGlobalLanguage();
                       
                            $MetaGlobalLanguage->meta_parent = 'golf_additional_heading';
                            $MetaGlobalLanguage->meta_title  = 'heading_title';
                            $MetaGlobalLanguage->title       = isset($request->additional_heading[$value['id']]) ?  $request->additional_heading[$value['id']] : $request->additional_heading[$lang_id];
                            $MetaGlobalLanguage->product_id  = $product_id;
                            $MetaGlobalLanguage->language_id = $value['id'];
                            $MetaGlobalLanguage->status      = 'Active';
                            $MetaGlobalLanguage->save();
                        }
                    }
                }

            // Expireance Icon Header end


            //Time Slot 
           
            $get_GolfTime = GolfTimeSlot::where('product_id', $request->id)->get();
            foreach ($get_GolfTime as $key => $get_time_delete) {
                if (!in_array($get_time_delete['id'], $request->time_slot_id)) {
                    GolfTimeSlot::where('id', $get_time_delete['id'])->delete();
                }
            }
            if (isset($request->slot_day)) {
                if (count($request->slot_day) > 0) {
                        
                    foreach ($request->time_slot_id as $key => $value_42) {
                        if (!getDataFromDB('golf_time_slots',['slot_day'=>$request->slot_day[$key],'slot_from_time'=>$request->slot_from_time[$key],'slot_to_time'=>$request->slot_to_time[$key],'product_id' => $product_id],'row')) { 
                            if ($value_42 != '') {
                                $GolfTimeSlot = GolfTimeSlot::find($value_42);
                            } else {
                                $GolfTimeSlot = new GolfTimeSlot();
                            }

                            $GolfTimeSlot['slot_day']        = $request->slot_day[$key];
                            $GolfTimeSlot['slot_from_time']  = $request->slot_from_time[$key];
                            $GolfTimeSlot['slot_to_time']    = $request->slot_to_time[$key];
                            $GolfTimeSlot['product_id']      = $product_id;
                            $GolfTimeSlot->save();
                        }
                        
                    }
                    
                }
            }   
            

            //   Related Products
            Productyachtrelatedboats::where(['product_id' => $product_id, 'type' => 'golf'])->delete();
            if (isset($request->boat) && count($request->boat) > 0) {
                if ($request->boat) {
                    foreach ($request->boat as $key => $value_boats) {


                        $Productyachtrelatedboats = new Productyachtrelatedboats();

                        $Productyachtrelatedboats['boat_id']    = $value_boats;
                        $Productyachtrelatedboats['product_id'] = $product_id;
                        $Productyachtrelatedboats['type']       = 'golf';

                        $Productyachtrelatedboats->save();
                    }
                }
            } 

            return redirect()->route('admin.golf')->withErrors([$status => $message]);
        }

        Session::forget('addcars');
        $get_higlights = [];
        $get_options   = [];
        $get_add_info  = [];
        $get_faqs      = [];
        $data          = [];
        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => translate('No Record Found')]);
            }
            $id               = checkDecrypt($id);
            $common['title']  = translate('Edit Golf');
            $common['button'] = translate('Update');

            $get_product                           = Product::where('id', $id)->first();
            $get_product_language                  = ProductLanguage::where('product_id', $id)->get();
            $get_product_highlight                 = ProductHighlights::where('product_id', $id)->get();
            $get_product_highlight_language        = ProductHighlightLanguage::where('product_id', $id)->get();
            $get_yatch_fetaure_highlight           = YachtFeatureHighlight::where('product_id', $id)->get();
            $get_yatch_fetaure_highlight_language  = YachtFeatureHighlightLanguage::where('product_id', $id)->get();
            $get_product_option                    = ProductOptions::with('get_product_option_details')
                ->where('product_id', $id)
                ->get();
            $get_product_site_adver               = ProductSiteAdvertisement::where('product_id', $id)->get();
            $get_product_site_adver_language      = ProductSiteAdvertisementLanguage::where('product_id', $id)->get();
            $get_product_option_language          = ProductOptionLanguage::where('product_id', $id)->get();
            $get_product_option_general_week_tour = ProductOptionWeekTour::where(['product_id' => $id, 'for_general' => 1])->get();
            $get_yatch_fetaure_highlight_heading  = MetaGlobalLanguage::where(['product_id' => $id, 'meta_title' => 'golf_facilities_heading'])->get();
            $get_product_setting                  = ProductSetting::where('product_id', $id)->get();
            $get_product_images                   = ProductImages::where('product_id', $id)->get();
            $get_product_additional_info          = ProductAddtionalInfo::where('product_id', $id)->get();
            $get_product_additional_info_language = ProductAdditionalInfoLanguage::where('product_id', $id)->get();
            $get_product_transfer_option          = Productyachttransferoption::where('type', 'golf')->where('product_id', $id)->get();
            $get_product_transfer_option_language = Productyachttransferoptionlanguage::where('product_id', $id)->get();
            $get_golf_rooms                       = GolfRoom::where('product_id', $id)->get();
            $get_golf_rooms_language              = GolfRoomLanguage::where('product_id', $id)->get();

            $get_golf_time_slot                   = GolfTimeSlot::where('product_id', $id)->get();


            $get_product_request_popup          = ProductRequestPopup::where(['product_id' => $id ,'type'=>'golf'])->get();
            $get_product_request_popup_language = ProductRequestPopupLanguage::where(['product_id' => $id ,'type'=>'golf'])->get();

            $get_product_experience_icon           = ProductExprienceIcon::where(['product_id'=> $id,'type' => 'golf','status'=>'Active'])->where('position_type','middel')->get();
            $get_product_experience_icon_language  = ProductExprienceIconLanguage::where(['product_id'=> $id,'type' => 'golf'])->where('position_type','middel')->get();
            $experience_icon_heading         = MetaGlobalLanguage::where('meta_parent', 'middle_experience_heading')->where('product_id',$id)->get();
            //Ecpireance Icon HEader
                $get_product_experience_icon_upper          = ProductExprienceIcon::where(['product_id'=> $id,'type' => 'golf','status'=>'Active'])->where('position_type','upper')->get();
                $get_product_experience_icon_language_upper = ProductExprienceIconLanguage::where(['product_id'=> $id,'type' => 'golf'])->where('position_type','upper')->get();
                $experience_icon_upper_heading              = MetaGlobalLanguage::where('meta_parent', 'header_experience_heading')->where('product_id',$id)->get();
            //Ecpireance Icon HEader

            $opening_time_heading               = MetaGlobalLanguage::where('meta_parent', 'golf_opening_heading')->where('product_id',$id)->get();
            $additional_heading                 = MetaGlobalLanguage::where('meta_parent', 'golf_additional_heading')->where('product_id',$id)->get();
            $get_product_related_boats          = Productyachtrelatedboats::where(['product_id' => $id, 'type' => 'golf'])->get();

            $get_timings                          = ProductTimings::where('product_id', $id)
                ->get()
                ->toArray();

            if (count($get_timings) == 0) {
                $get_timings = Timing::all();
            }
            $categories = Category::select('categories.*', 'category_language.description as name')
                ->orWhere('country', null)
                ->where('categories.parent', 0)
                ->join('category_language', 'categories.id', '=', 'category_language.category_id')
                ->groupBy('categories.id')
                ->get();

            $get_hotels = HotelPage::select('hotel_page.*', 'hotel_page_language.title','hotel_page_language.hotel_room','hotel_page_language.hotel_view','hotel_page_language.hotel_bars')
                        ->orderBy('hotel_page.id', 'desc')
                        ->where(['hotel_page.is_delete' => 0])
                        ->join("hotel_page_language", 'hotel_page.id', '=', 'hotel_page_language.hotel_id')
                        ->groupBy('hotel_page.id')
                        ->get();
                            

            if (!$get_product) {
                return back()->withErrors(['error' => translate('Something went wrong')]);
            }
        }

        // print_die($get_product_option->toArray());
        // print_die($get_product_option_week_tour->toArray());

        return view(
            'admin.product.golf.addProduct',
            compact(
                'common',
                'get_yatch_fetaure_highlight_heading',
                'get_yatch_amenities_heading',
                'get_yatch_fetaure_highlight',
                'get_yatch_fetaure_highlight_language',
                'get_yatch_amenities',
                'get_yatch_amenities_language',
                'get_yatch_amenities_points',
                'get_yatch_amenities_points_language',
                'get_yatch_boat_specification_heading',
                'get_yatch_boat_specification',
                'get_yatch_boat_specification_language',
                'get_product',
                'country',
                'get_product_additional_info',
                'get_product_additional_info_language',
                'get_product_language',
                'get_product_highlight',
                'get_product_highlight_language',
                'get_product_setting',
                'get_timings',
                'languages',
                'get_product_faq',
                'get_product_faq_language',
                'get_product_images',
                'get_product_option',
                'get_product_option_language',
                'get_product_site_adver_language',
                'get_product_site_adver',
                'GPO',
                'GYA',
                'GYAP',
                'GYAPl',
                'get_product_option_details',
                'GYFH',
                'GPH',
                'get_supplier',
                'GPSD',
                'get_product_voucher_language',
                'get_product_voucher',
                'GPV',
                'GPF',
                'get_product_option_week_tour',
                'get_product_option_general_week_tour',
                'get_product_category',
                'categories',
                'GPC',
                'get_product_option_tour_upgrade',
                'product_option_time',
                'customerGroup',
                'get_product_lodge',
                'get_product_lodge_language',
                'GPL',
                'get_product_tooltip',
                'get_product_tooltip_language',
                'PTT',
                'get_product_tooltip_title_language',
                'get_product_deafault_title',
                'get_product_option_period_pricing',
                'GPAI',
                'get_product_option_group_percentage',
                'transportation_vehicle',
                'get_yatch_transfer_option',
                'GYTO',
                'get_product_transfer_option',
                'get_product_transfer_option_language',
                'get_boats',
                'get_product_related_boats',
                'GYRB',
                'get_limousine_locations',
                'get_limousine_types',
                'get_golf_rooms',
                'get_golf_rooms_language',
                'GGR',
                'get_hotels',
                'get_product_request_popup',
                'get_product_request_popup_language',
                'POPUP',
                'experience_icon_heading',
                'get_product_experience_icon',
                'get_product_experience_icon_language',
                'PEIH',
                'get_product_experience_icon_upper',
                'get_product_experience_icon_language_upper',
                'experience_icon_upper_heading',
                'additional_heading',
                'opening_time_heading',
                'PEI',
                'lang_id',
                'get_golf_time_slot',
                'GTS',
            ),
        );
    }

    public function createSlug($title, $id = 0)
    {
        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($title)));
        $allSlugs = $this->getRelatedSlugs($slug, $id);
        if (!$allSlugs->contains('slug', $slug)) {
            return $slug;
        }
        $i = 1;
        $is_contain = true;
        do {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                $is_contain = false;
                return $newSlug;
            }
            $i++;
        } while ($is_contain);
    }

    protected function getRelatedSlugs($slug, $id = 0)
    {
        return Product::select('slug')
            ->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }

    ///Delete Product
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'No Record Found']);
        }
        $id = checkDecrypt($id);
        $status = 'error';
        $message = translate('Something went wrong!');
        $get_product = Product::find($id);
        if ($get_product) {
            $get_product->delete();
            ProductOptions::where('product_id', $id)->delete();
            ProductCategory::where('product_id', $id)->delete();
            ProductLanguage::where('product_id', $id)->delete();
            ProductSetting::where('product_id', $id)->delete();
            ProductInfo::where('product_id', $id)->delete();
            ProductImages::where('product_id', $id)->delete();
            ProductAddtionalInfo::where('product_id', $id)->delete();
            ProductAdditionalInfoLanguage::where('product_id', $id)->delete();
            ProductHighlights::where('product_id', $id)->delete();
            ProductHighlightLanguage::where('product_id', $id)->delete();
            // ProductLodge::where('product_id', $id)->delete();
            // ProductLodgeLanguage::where('product_id', $id)->delete();
            // ProductLodgePrice::where('product_id', $id)->delete();
            ProductVoucherLanguage::where('product_id', $id)->delete();
            ProductTimings::where('product_id', $id)->delete();
            ProductOptionLanguage::where('product_id', $id)->delete();
            ProductPrivateTransferCars::where('product_id', $id)->delete();
            ProductOptionWeekTour::where('product_id', $id)->delete();
            ProductOptionTourUpgrade::where('product_id', $id)->delete();
            ProductTourPriceDetails::where('product_id', $id)->delete();
            ProductTourRoom::where('product_id', $id)->delete();
            ProductOptionTaxServiceCharge::where('product_id', $id)->delete();
            ProductOptionDetails::where('product_id', $id)->delete();
            ProuductCustomerGroupDiscount::where('product_id', $id)->delete();
            ProductFaqs::where('product_id', $id)->delete();
            ProductFaqLanguage::where('product_id', $id)->delete();
            ProductSiteAdvertisementLanguage::where('product_id', $id)->delete();
            ProductSiteAdvertisement::where('product_id', $id)->delete();
            ProductToolTip::where('product_id', $id)->delete();
            ProductToolTipLanguage::where('product_id', $id)->delete();


            ProductRequestPopup::where(['product_id' => $id ,'type'=>'golf'])->delete();
            ProductRequestPopupLanguage::where(['product_id' => $id ,'type'=>'golf'])->delete();

            ProductExprienceIcon::where(['product_id' => $id, 'type' => "golf"])->delete();
            ProductExprienceIconLanguage::where(['product_id' => $id, 'type' => "golf"])->delete();

            $status = 'success';
            $message = translate('Delete Successfully');
        }
        return back()->withErrors([$status => $message]);
    }


    // Duplicate Golf 
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
        $get_product = Product::find($id);
        if ($get_product) {
            $get_product         = $get_product->replicate();
            $get_product->slug   = createSlug('products', $get_product->slug);
            $get_product->status = "Deactive";
            $get_product->save();

            $NewId = $get_product->id;

            // // Product Category 
            $ProductCategory = ProductCategory::where('product_id', $id)->get();
            $ProductCategory->each(function ($item, $key) use ($NewId) {
                $category             = $item->replicate();
                $category->product_id = $NewId;
                $category->save();
            });

            // // Product Category 
            $ProductLanguage = ProductLanguage::where('product_id', $id)->get();
            $ProductLanguage->each(function ($item, $key) use ($NewId) {
                $Language             = $item->replicate();
                $Language->product_id = $NewId;
                $Language->save();
            });

            // // Product ProductSetting 
            $ProductSetting = ProductSetting::where(['product_id' => $id, 'type' => 'Excursion'])->get();
            $ProductSetting->each(function ($item, $key) use ($NewId) {
                $Setting             = $item->replicate();
                $Setting->product_id = $NewId;
                $Setting->save();
            });

            // // Product ProductInfo 
            $ProductInfo = ProductInfo::where(['product_id' => $id])->get();
            $ProductInfo->each(function ($item, $key) use ($NewId) {
                $Info             = $item->replicate();
                $Info->product_id = $NewId;
                $Info->save();
            });

            // // Product ProductImages 
            $ProductImages = ProductImages::where(['product_id' => $id])->get();
            $ProductImages->each(function ($item, $key) use ($NewId) {
                $Images             = $item->replicate();
                $Images->product_id = $NewId;
                $Images->save();
            });


            // Product ProductAddtionalInfo 
            $ProductAddtionalInfo = ProductAddtionalInfo::where(['product_id' => $id])->get();
            $ProductAddtionalInfo->each(function ($item, $key) use ($NewId, $id) {
                $AddtionalInfo             = $item->replicate();
                $AddtionalInfo->product_id = $NewId;
                $AddtionalInfo->save();

                $ProductAdditionalInfoLanguage = ProductAdditionalInfoLanguage::where(['product_id' => $id, 'product_additional_info_id' => $item->id])->get();
                $ProductAdditionalInfoLanguage->each(function ($item, $key) use ($NewId, $AddtionalInfo) {
                    $AdditionalInfoLanguage                             = $item->replicate();
                    $AdditionalInfoLanguage->product_id                 = $NewId;
                    $AdditionalInfoLanguage->product_additional_info_id = $AddtionalInfo->id;
                    $AdditionalInfoLanguage->save();
                });
            });

            // Product ProductAddtionalInfo 
            $ProductHighlights = ProductHighlights::where(['product_id' => $id])->get();
            $ProductHighlights->each(function ($item, $key) use ($NewId, $id) {
                $Highlights             = $item->replicate();
                $Highlights->product_id = $NewId;
                $Highlights->save();

                $ProductHighlightLanguage = ProductHighlightLanguage::where(['product_id' => $id, 'highlight_id' => $item->id])->get();
                $ProductHighlightLanguage->each(function ($item, $key) use ($NewId, $Highlights) {
                    $HighlightLanguage               = $item->replicate();
                    $HighlightLanguage->product_id   = $NewId;
                    $HighlightLanguage->highlight_id = $Highlights->id;
                    $HighlightLanguage->save();
                });
            });


            // Product ProductAddtionalInfo 
            $ProductVoucher = ProductVoucher::where(['product_id' => $id])->get();
            $ProductVoucher->each(function ($item, $key) use ($NewId, $id) {
                $Voucher             = $item->replicate();
                $Voucher->product_id = $NewId;
                $Voucher->save();

                $ProductVoucherLanguage = ProductVoucherLanguage::where(['product_id' => $id, 'voucher_id' => $item->id])->get();
                $ProductVoucherLanguage->each(function ($item, $key) use ($NewId, $Voucher) {
                    $VoucherLanguage               = $item->replicate();
                    $VoucherLanguage->product_id   = $NewId;
                    $VoucherLanguage->voucher_id = $Voucher->id;
                    $VoucherLanguage->save();
                });
            });

            // Product ProductTimings 
            $ProductTimings = ProductTimings::where(['product_id' => $id])->get();
            $ProductTimings->each(function ($item, $key) use ($NewId) {
                $Timings             = $item->replicate();
                $Timings->product_id = $NewId;
                $Timings->save();
            });


            $ProductLodge = ProductLodge::where(['product_id' => $id])->get();
            $ProductLodge->each(function ($item, $key) use ($NewId, $id) {
                $Lodge             = $item->replicate();
                $Lodge->product_id = $NewId;
                $Lodge->save();

                $ProductLodgeLanguage = ProductLodgeLanguage::where(['product_id' => $id, 'lodge_id' => $item->id])->get();
                $ProductLodgeLanguage->each(function ($item, $key) use ($NewId, $Lodge) {
                    $LodgeLanguage             = $item->replicate();
                    $LodgeLanguage->product_id = $NewId;
                    $LodgeLanguage->lodge_id = $Lodge->id;
                    $LodgeLanguage->save();
                });


                $ProductOptionTaxServiceCharge = ProductOptionTaxServiceCharge::where(['product_id' => $id, 'product_option_id' => $item->id])->get();
                $ProductOptionTaxServiceCharge->each(function ($item, $key) use ($NewId, $Lodge) {
                    $OptionTaxServiceCharge               = $item->replicate();
                    $OptionTaxServiceCharge->product_id   = $NewId;
                    $OptionTaxServiceCharge->product_option_id = $Lodge->id;
                    $OptionTaxServiceCharge->save();
                });

                $ProductLodgePrice = ProductLodgePrice::where(['product_id' => $id, 'product_lodge_id' => $item->id])->get();
                $ProductLodgePrice->each(function ($item, $key) use ($NewId, $Lodge) {
                    $LodgePrice                   = $item->replicate();
                    $LodgePrice->product_id       = $NewId;
                    $LodgePrice->product_lodge_id = $Lodge->id;
                    $LodgePrice->save();
                });
            });



            // Product ProuductCustomerGroupDiscount 
            $ProuductCustomerGroupDiscount = ProuductCustomerGroupDiscount::where(['product_id' => $id])->get();
            $ProuductCustomerGroupDiscount->each(function ($item, $key) use ($NewId) {
                $CustomerGroupDiscount               = $item->replicate();
                $CustomerGroupDiscount->product_id   = $NewId;
                $CustomerGroupDiscount->save();
            });



            // Product ProductFaqs 
            $ProductFaqs = ProductFaqs::where(['product_id' => $id])->get();
            $ProductFaqs->each(function ($item, $key) use ($NewId, $id) {
                $Faqs             = $item->replicate();
                $Faqs->product_id = $NewId;
                $Faqs->save();

                $ProductFaqLanguage = ProductFaqLanguage::where(['product_id' => $id, 'faq_id' => $item->id])->get();
                $ProductFaqLanguage->each(function ($item, $key) use ($NewId, $Faqs) {
                    $FaqLanguage               = $item->replicate();
                    $FaqLanguage->product_id   = $NewId;
                    $FaqLanguage->faq_id = $Faqs->id;
                    $FaqLanguage->save();
                });
            });


            // Product ProductSiteAdvertisement 
            $ProductSiteAdvertisement = ProductSiteAdvertisement::where(['product_id' => $id])->get();
            $ProductSiteAdvertisement->each(function ($item, $key) use ($NewId, $id) {
                $SiteAdvertisement             = $item->replicate();
                $SiteAdvertisement->product_id = $NewId;
                $SiteAdvertisement->save();

                $ProductSiteAdvertisementLanguage = ProductSiteAdvertisementLanguage::where(['product_id' => $id, 'site_advertisement_id' => $item->id])->get();
                $ProductSiteAdvertisementLanguage->each(function ($item, $key) use ($NewId, $SiteAdvertisement) {
                    $SiteAdvertisementLanguage               = $item->replicate();
                    $SiteAdvertisementLanguage->product_id   = $NewId;
                    $SiteAdvertisementLanguage->site_advertisement_id = $SiteAdvertisement->id;
                    $SiteAdvertisementLanguage->save();
                });
            });


            // Product ProductToolTip 
            $ProductToolTip = ProductToolTip::where(['product_id' => $id])->get();
            $ProductToolTip->each(function ($item, $key) use ($NewId, $id) {
                $ToolTip             = $item->replicate();
                $ToolTip->product_id = $NewId;
                $ToolTip->save();

                $ProductToolTipLanguage = ProductToolTipLanguage::where(['product_id' => $id, 'tooltip_id' => $item->id])->get();
                $ProductToolTipLanguage->each(function ($item, $key) use ($NewId, $ToolTip) {
                    $ToolTipLanguage               = $item->replicate();
                    $ToolTipLanguage->product_id   = $NewId;
                    $ToolTipLanguage->tooltip_id = $ToolTip->id;
                    $ToolTipLanguage->save();
                });
            });


            // Yatch Featured Highlight
            $YachtFeatureHighlight = YachtFeatureHighlight::where(['product_id' => $id])->get();
            $YachtFeatureHighlight->each(function ($item, $key) use ($NewId, $id) {
                $Featured             = $item->replicate();
                $Featured->product_id = $NewId;
                $Featured->save();

                $YachtFeatureHighlightLanguage = YachtFeatureHighlightLanguage::where(['product_id' => $id, 'feature_highlight_id' => $item->id])->get();
                $YachtFeatureHighlightLanguage->each(function ($item, $key) use ($NewId, $Featured) {
                    $FeaturedLanguage               = $item->replicate();
                    $FeaturedLanguage->product_id   = $NewId;
                    $FeaturedLanguage->feature_highlight_id = $Featured->id;
                    $FeaturedLanguage->save();
                });
            });

            $ProductOptionWeekTour = ProductOptionWeekTour::where(['product_id' => $id])->get();
            $ProductOptionWeekTour->each(function ($item, $key) use ($NewId) {
                $OptionWeekTour               = $item->replicate();
                $OptionWeekTour->product_id   = $NewId;
                $OptionWeekTour->save();
            });


            // Feature light 
            $MetaGlobalLanguage = MetaGlobalLanguage::where('product_id', $id)->where(['meta_title' => 'golf_feature_highlight'])->get();
            $MetaGlobalLanguage->each(function ($item, $key) use ($NewId, $id) {
                $FeaturedHighlight             = $item->replicate();
                $FeaturedHighlight->product_id = $NewId;
                $FeaturedHighlight->save();
            });


            // Feature Amenities
            $MetaGlobalLanguage = MetaGlobalLanguage::where('product_id', $id)->where(['meta_title' => 'golf_amenities'])->get();
            $MetaGlobalLanguage->each(function ($item, $key) use ($NewId, $id) {
                $Featuredamenities             = $item->replicate();
                $Featuredamenities->product_id = $NewId;
                $Featuredamenities->save();
            });


            // Feature Boat specification
            $MetaGlobalLanguage = MetaGlobalLanguage::where('product_id', $id)->where(['meta_title' => 'golf_boat_specification'])->get();
            $MetaGlobalLanguage->each(function ($item, $key) use ($NewId, $id) {
                $Featuredboat             = $item->replicate();
                $Featuredboat->product_id = $NewId;
                $Featuredboat->save();
            });


            // Yacht Boat Specification
            $YachtBoatSpecification = YachtBoatSpecification::where(['product_id' => $id])->get();
            $YachtBoatSpecification->each(function ($item, $key) use ($NewId, $id) {
                $BoatSpecification             = $item->replicate();
                $BoatSpecification->product_id = $NewId;
                $BoatSpecification->save();

                $YachtBoatSpecificationLanguage = YachtBoatSpecificationLanguage::where(['product_id' => $id, 'boat_specification_id' => $item->id])->get();
                $YachtBoatSpecificationLanguage->each(function ($item, $key) use ($NewId, $BoatSpecification) {
                    $BoatSpecificationLang               = $item->replicate();
                    $BoatSpecificationLang->product_id   = $NewId;
                    $BoatSpecificationLang->boat_specification_id = $BoatSpecification->id;
                    $BoatSpecificationLang->save();
                });
            });



            // Yacht Product Options
            $ProductOptions = ProductOptions::where(['product_id' => $id])->get();
            $ProductOptions->each(function ($item, $key) use ($NewId, $id) {
                $Options             = $item->replicate();
                $Options->product_id = $NewId;
                $Options->save();

                $ProductOptionLanguage = ProductOptionLanguage::where(['product_id' => $id, 'option_id' => $item->id])->get();
                $ProductOptionLanguage->each(function ($item, $key) use ($NewId, $Options) {
                    $OptionLanguage               = $item->replicate();
                    $OptionLanguage->product_id   = $NewId;
                    $OptionLanguage->option_id = $Options->id;
                    $OptionLanguage->save();
                });

                $ProductOptionWeekTour = ProductOptionWeekTour::where(['product_id' => $id, 'product_option_id' => $item->id])->get();
                $ProductOptionWeekTour->each(function ($item, $key) use ($NewId, $Options) {
                    $OptionWeekTour               = $item->replicate();
                    $OptionWeekTour->product_id   = $NewId;
                    $OptionWeekTour->product_option_id = $Options->id;
                    $OptionWeekTour->save();
                });

                $ProductTourPriceDetails = ProductTourPriceDetails::where(['product_id' => $id, 'product_option_id' => $item->id])->get();
                $ProductTourPriceDetails->each(function ($item, $key) use ($NewId, $Options) {
                    $TourPriceDetails               = $item->replicate();
                    $TourPriceDetails->product_id   = $NewId;
                    $TourPriceDetails->product_option_id = $Options->id;
                    $TourPriceDetails->save();
                });

                $ProductTourRoom = ProductTourRoom::where(['product_id' => $id, 'product_option_id' => $item->id])->get();
                $ProductTourRoom->each(function ($item, $key) use ($NewId, $Options) {
                    $TourRoom               = $item->replicate();
                    $TourRoom->product_id   = $NewId;
                    $TourRoom->product_option_id = $Options->id;
                    $TourRoom->save();
                });

                $ProductOptionDetails = ProductOptionDetails::where(['product_id' => $id, 'product_option_id' => $item->id])->get();
                $ProductOptionDetails->each(function ($item, $key) use ($NewId, $Options) {
                    $OptionDetails               = $item->replicate();
                    $OptionDetails->product_id   = $NewId;
                    $OptionDetails->product_option_id = $Options->id;
                    $OptionDetails->save();
                });

                $ProductOptionPrivateTourPrice = ProductOptionPrivateTourPrice::where(['product_id' => $id, 'product_option_id' => $item->id])->get();
                $ProductOptionPrivateTourPrice->each(function ($item, $key) use ($NewId, $Options) {
                    $OptionPrivateTourPrice               = $item->replicate();
                    $OptionPrivateTourPrice->product_id   = $NewId;
                    $OptionPrivateTourPrice->product_option_id = $Options->id;
                    $OptionPrivateTourPrice->save();
                });
            });


            // Yatch Amenities
            $YachtAmenities = YachtAmenities::where(['product_id' => $id])->get();
            $YachtAmenities->each(function ($item, $key) use ($NewId, $id) {
                $YachtAmi             = $item->replicate();
                $YachtAmi->product_id = $NewId;
                $YachtAmi->save();

                $YachtAmenitiesLanguage = YachtAmenitiesLanguage::where(['product_id' => $id, 'amenities_id' => $item->id])->get();
                $YachtAmenitiesLanguage->each(function ($item, $key) use ($NewId, $YachtAmi) {
                    $YachtAmiLang               = $item->replicate();
                    $YachtAmiLang->product_id   = $NewId;
                    $YachtAmiLang->amenities_id = $YachtAmi->id;
                    $YachtAmiLang->save();
                });


                // Yatch Amenities Point 
                $YachtAmenitiesPoints = YachtAmenitiesPoints::where(['product_id' => $id, 'amenti_id' => $item->id])->get();
                $YachtAmenitiesPoints->each(function ($item, $key) use ($NewId, $id, $YachtAmi) {
                    $YachtAmiPoint             = $item->replicate();
                    $YachtAmiPoint->product_id = $NewId;
                    $YachtAmiPoint->amenti_id  = $YachtAmi->id;
                    $YachtAmiPoint->save();

                    $YachtAmenitiesPointsLanguage = YachtAmenitiesPointsLanguage::where(['product_id' => $id, 'point_amenities_id' => $item->id])->get();
                    $YachtAmenitiesPointsLanguage->each(function ($item, $key) use ($NewId, $YachtAmiPoint, $YachtAmi) {
                        $YachtAmiPointLang               = $item->replicate();
                        $YachtAmiPointLang->product_id          = $NewId;
                        $YachtAmiPointLang->amenities_id        = $YachtAmi->id;
                        $YachtAmiPointLang->point_amenities_id  = $YachtAmiPoint->id;
                        $YachtAmiPointLang->save();
                    });
                });
            });

            // Yacht Transfer option
            $Productyachttransferoption = Productyachttransferoption::where(['product_id' => $id])->get();
            $Productyachttransferoption->each(function ($item, $key) use ($NewId, $id) {
                $YatchTransferOption             = $item->replicate();
                $YatchTransferOption->product_id = $NewId;
                $YatchTransferOption->save();

                $Productyachttransferoptionlanguage = Productyachttransferoptionlanguage::where(['product_id' => $id, 'product_yacht_transfer_option_id' => $item->id])->get();
                $Productyachttransferoptionlanguage->each(function ($item, $key) use ($NewId, $YatchTransferOption) {
                    $YatchTransferOptionLang               = $item->replicate();
                    $YatchTransferOptionLang->product_id   = $NewId;
                    $YatchTransferOptionLang->product_yacht_transfer_option_id = $YatchTransferOption->id;
                    $YatchTransferOptionLang->save();
                });
            });


             // Product ProductExprienceIcon 
            $ProductExprienceIcon = ProductExprienceIcon::where(['product_id' => $id,'type' => 'golf'])->get();
            $ProductExprienceIcon->each(function ($item, $key) use ($NewId, $id) {
                $ExpIcon             = $item->replicate();
                $ExpIcon->product_id = $NewId;
                $ExpIcon->save();

                $ProductExprienceIconLanguage = ProductExprienceIconLanguage::where(['product_id' => $id, 'experience_icon_id' => $item->id])->get();
                $ProductExprienceIconLanguage->each(function ($item, $key) use ($NewId, $ExpIcon) {
                    $ExpIconLanguage               = $item->replicate();
                    $ExpIconLanguage->product_id   = $NewId;
                    $ExpIconLanguage->experience_icon_id = $ExpIcon->id;
                    $ExpIconLanguage->save();
                });
            });

        }
        return redirect()->back()->with(['success' => "Product Duplicate Succssfully..."]);
    }
}
