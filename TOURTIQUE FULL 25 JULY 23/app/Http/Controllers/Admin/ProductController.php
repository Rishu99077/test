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
use App\Models\ProductGroupPercentage;
use App\Models\ProductLodgePrice;
use App\Models\ProuductCustomerGroupDiscount;
use App\Models\ProductGroupPercentageLanguage;
use App\Models\Timing;
use App\Models\CarDetails;
use App\Models\CarDetailLanguage;
use App\Models\ProductPrivateTransferCars;
use App\Models\ProductToolTip;
use App\Models\ProductToolTipLanguage;
use App\Models\DefaultToolTipTitle;
use App\Models\ProductOptionPrivateTourPrice;
use App\Models\ProductGroupPercentageDetails;
use App\Models\ProductOptionGroupPercentage;
use App\Models\MetaGlobalLanguage;

use App\Models\ProductRequestPopup;
use App\Models\ProductRequestPopupLanguage;

use App\Models\Productyachtrelatedboats;

use App\Models\ProductExprienceIcon;
use App\Models\ProductExprienceIconLanguage; 

use Illuminate\Support\Facades\View;
use Image;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProductController extends Controller
{
    //Product
    public function index(Request $request)
    {
        $common = [];
        $common['title'] = 'Excursion';
        $country = Country::all();

        Session::put('TopMenu', 'Product');
        Session::put('SubMenu', 'Excursion');
        Session::put("SubSubMenu", "Add Excursion");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $addDaysDate = Carbon::now()->addDays(14);
        // rate_valid_until
        $expired_Product =  Product::select('products.*', 'product_language.description as title')->join('product_language', 'products.id', '=', 'product_language.product_id')->where('products.rate_valid_until', "<=", $addDaysDate)->where('products.rate_valid_until', ">=", Carbon::now())->where('products.product_type', 'excursion')->groupBy('products.id')->get();

        $get_product = Product::select('products.*', 'product_language.description as title', 'category_language.description as category_name')
            ->where('products.is_delete', 0)
            ->where('products.product_type', 'excursion')
            ->leftjoin('product_language', 'products.id', '=', 'product_language.product_id')
            ->groupBy('products.id')
            ->orderBy('products.id', 'desc')
            ->join('category_language', 'category_language.category_id', '=', 'products.category');

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

            if (isset($request->status)) {
                $get_product = $get_product->where('products.status', $request->status);
            }

            $get_product = $get_product->offset($page * config('adminconfig.records_per_page'))->paginate(config('adminconfig.records_per_page'));
            return view('admin.product.excursion._listing', compact('common', 'get_product','lang_id'))->render();
        } else {
            $get_product = $get_product->paginate(config('adminconfig.records_per_page'));
            return view('admin.product.excursion.index', compact('common', 'get_product', 'country', 'expired_Product','lang_id'));
        }
    }

    ///Add Product
    public function addProduct(Request $request, $id = '')
    {
        Session::put('TopMenu', 'Product');
        Session::put('SubMenu', 'Excursion');

        $common                                = [];

        $common['title']                       = translate('Add Excursion');
        $common['button']                      = translate('Save');
        $user_id                               = Session::get('admin_id');
        $get_product                           = getTableColumn('products');
        $languages                             = Language::where(['is_delete' => 0, 'status' => 'Active'])->get();

        // Language
        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $get_product_language                  = [];
        $get_product_additional_info_language  = [];
        $meta_global_language_description  = [];
        $get_product_highlight_language        = [];
        $get_product_voucher_language          = [];
        $get_product_group_percentage_language = [];
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
        $get_product_option_period_pricing     = [];
        $get_product_option_tour_upgrade       = [];
        $get_product_option_group_percentage   = [];
        $get_product_group_percentage          = [];
        $get_product_category                  = [];
        $get_product_lodge                     = [];
        $get_product_tooltip                   = [];
        $get_product_tooltip_language          = [];
        $get_product_tooltip_title_language    = [];
        $experience_icon_heading               = [];
        $experience_icon_upper_heading         = [];
        $tour_option_heading                   = [];

        $get_product_deafault_title            = DefaultToolTipTitle::where('type', 'excursion')->get()->toArray();
        $categories                            = [];
        $get_product_group_percentage_details  = [];
        $get_product_group_percentage          = getTableColumn('product_group_percentage');
        
        $get_product_request_popup          = [];
        $get_product_request_popup_language = [];
        $POPUP                              = getTableColumn('product_request_popup');
        $opening_time_heading                  = [];
        $additional_heading                    = [];
        $faq_heading                           = [];
        
        $get_product_setting = '';
        $GPO                 = getTableColumn('products_options');
        $GPH                 = getTableColumn('products_highlights');
        $GPV                 = getTableColumn('products_voucher');
        $GPF                 = getTableColumn('products_faqs');
        $GPSD                = getTableColumn('product_site_advertisement');
        $GPC                 = getTableColumn('product_categories');
        $GPL                 = getTableColumn('product_lodge');
        $PTT                 = getTableColumn('product_tooltip');
        $GPGP                = getTableColumn('product_group_percentage');
        $GPAI                = getTableColumn('products_addtional_info');
        $GPGPD               = getTableColumn('product_group_percentage_details');
        $PEIH                = getTableColumn('product_experience_icon');

        // Experience Icon
        $get_product_experience_icon                = [];
        $get_product_experience_icon_language       = [];
        $get_product_experience_icon_language_upper = [];
        $get_product_experience_icon_upper          = [];
        $PEI                                        = getTableColumn('product_experience_icon');

        $get_product_related_boats =            [];
        $GYRB = getTableColumn('product_yacht_relatedboats');

        $country             = Country::all();
        $get_supplier        = Supplier::where(['added_by' => 'admin','status'=>'Active'])->get();
        $product_option_time = ProductOptionTime::where(['status' => 1])->get();

        $customerGroup = CustomerGroup::select('customer_group.*', 'customer_group_language.title as title')
            ->where('customer_group.is_delete', 0)
            ->where('customer_group.status', 'Active')
            ->join('customer_group_language', 'customer_group.id', '=', 'customer_group_language.customer_group_id')
            ->groupBy('customer_group.id')
            ->orderBy('customer_group.id', 'desc')
            ->get();

        $get_timings = Timing::all();

        $get_boats = Product::select('products.*', 'product_language.description as title')
            ->where('products.is_delete', 0)
            ->where('products.status', 'Active')
            ->where('products.product_type', 'excursion')
            ->leftjoin('product_language', 'products.id', '=', 'product_language.product_id')
            ->where('product_language.language_id',$lang_id)
            ->groupBy('products.id')->get();

        if ($request->isMethod('post')) {
            //  echo "<pre>"; 
            //   print_r($request->all());
            //   echo "</pre>";die();

            $req_fields = [];
            $req_fields['title.*'] = 'required';
            // $req_fields['main_title.*'] = 'required';
            $req_fields['short_description.*'] = 'required';
            $req_fields['main_description.*']  = 'required';
            $req_fields['category.*']          = 'required';
            $req_fields['duration']            = 'required';
            $req_fields['pick_option']         = 'required';
            $req_fields['address']             = 'required';
            $req_fields['country']             = 'required';
            $req_fields['state']               = 'required';
            $req_fields['city']                = 'required';
            $req_fields['selling_price']       = 'required';
            


            
            if ($request->id == '') {
                $req_fields['image'] = 'required';
            }

            // if (isset($request->image_id)) {
            //     $count_img =  count($request->image_id);
            //     if($count_img > 10){
            //         $req_fields['files_count'] = 'required';
            //     }
            // }
           

            $errormsg = [
                'title.*' => translate('Title'),
                // 'main_title.*' => translate('Main Title'),
                'short_description.*' => translate('Short Description'),
                'main_description.*' => translate('Description'),
                'category.*' => translate('Category'),
                'duration' => translate('Duration'),
                'pick_option' => translate('Pick Option'),
                'address' => translate('Address'),
                'country' => translate('Country'),
                'state' => translate('State'),
                'city' => translate('City'),
                'category' => translate('Category'),
                'image' => translate('Image'),
                'selling_price' => translate('Selling Price'),
                
                "popup_heading.*"       => translate("Pop up heading"),
                "popup_title.*"         => translate("Pop up heading"),
                "experience_heading.*"  => translate("Experience heading"),
                "header_experience_heading.*"  => translate("Experience heading"),
                "pro_popup_title.*"  => translate("Product Pop-up title"),
                "pro_popup_desc.*"  => translate("Product Pop-up Description"),


                // 'files_count' => translate('Image count less than 10'),

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


            ///Start Validation
                // Highlights Validation
                // $req_fields['highlights_title.*.*']        = 'required';
                // $req_fields['highlights_description.*.*']  = 'required';
                // Addtional Info
                // $req_fields['info_title.*.*']              = 'required';
                // Tour Option
                // $req_fields['tour_option.*.*']              = 'required';
                // $req_fields['addtional_info.*.*']              = 'required';

                // $req_fields['question.*.*']              = 'required';
                // $req_fields['answer.*.*']                = 'required';

                // $req_fields['adver_title.*.*']           = 'required';
                // $req_fields['adver_desc.*.*']            = 'required';

                // $req_fields['voucher_title.*.*']           = 'required';
                // $req_fields['voucher_description.*.*']     = 'required';

                // $req_fields['request_description.*.*']            = 'required';
                // $req_fields['exp_title.*.*']            = 'required';
                // 
                // $req_fields['header_exp_title.*.*']            = 'required';
                // $req_fields['header_exp_info.*.*']            = 'required';

                

                $errormsg = [
                    // Highlights Validation
                    'highlights_title.*.*' => translate('HighLight Title'),
                    'highlights_description.*.*' => translate('HighLight Description'),
                    // Addtional Info
                    'info_title.*.*' => translate('Addtional Info Title'),
                    // Tour Option
                    // 'tour_option.*.*' => translate('Addtional Info Title'),
                    // 'addtional_info.*.*' => translate('Addtional Info Title'),

                    'question.*.*' => translate('Question'),
                    'answer.*.*' => translate('Answer'),

                    // 'adver_title.*.*' => translate('Advertisment Title'),
                    // 'adver_desc.*.*' => translate('Advertisment Description'),

                    'voucher_title.*.*' => translate('Voucher Title'),
                    'voucher_description.*.*' => translate('Voucher Description'),

                    'request_description.*.*' => translate('Request Description'),
                    'exp_title.*.*' => translate('Experience title'),

                    'header_exp_title.*.*' => translate('header exp title '),
                    // 'header_exp_info.*.*' => translate('header exp info '),


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
            // End Validations   
        
            if ($request->id != '') {
                $message = translate('Update Successfully');
                $status = 'success';
                $Product = Product::find($request->id);

                $slug = createSlug('products', $request->title[$lang_id], $request->id);

                //option Delete
                $get_ProductOptions = ProductOptions::where('product_id', $request->id)->get();
                foreach ($get_ProductOptions as $key => $get_productoptions_delete) {
                    if (!in_array($get_productoptions_delete['id'], $request->options_id)) {
                        ProductOptions::where('id', $get_productoptions_delete['id'])->delete();
                    }
                }

                // Group Percentage Delete
                $get_ProductGroupPercentage = ProductGroupPercentageDetails::where('product_id', $request->id)->get();
                foreach ($get_ProductGroupPercentage as $key => $get_ProductGroupPercentage_delete) {
                    if (!in_array($get_ProductGroupPercentage_delete['id'], $request->single_group_percentage_details_id)) {
                        ProductGroupPercentageDetails::where('id', $get_ProductGroupPercentage_delete['id'])->delete();
                    }
                }

                $get_ProductAddInInfo = ProductAddtionalInfo::where('product_id', $request->id)->get();
                if( isset( $request->info_id)){
                    foreach ($get_ProductAddInInfo as $key => $get_addInfo_delete) {
                        if (!in_array($get_addInfo_delete['id'], $request->info_id)) {
                            ProductAddtionalInfo::where('id', $get_addInfo_delete['id'])->delete();
                        }
                    }
                }else{
                    ProductAddtionalInfo::where('product_id', $request->id)->delete();
                }

                // Product Site Advertisement
                $get_ProductSideAdv = ProductSiteAdvertisement::where('product_id', $request->id)->get();
                foreach ($get_ProductSideAdv as $key => $get_siteadv_delete) {
                    if (!in_array($get_siteadv_delete['id'], $request->adver_id)) {
                        ProductSiteAdvertisement::where('id', $get_siteadv_delete['id'])->delete();
                    }
                }

                // Product Voucher
                $get_ProductVoucher = ProductVoucher::where(['product_id' => $request->id, 'type' => "excursion"])->get();
                foreach ($get_ProductVoucher as $key => $get_voucher_delete) {
                    if (!in_array($get_voucher_delete['id'], $request->voucher_id)) {
                        ProductVoucher::where(['id' => $get_voucher_delete['id'], 'type' => "excursion"])->delete();
                    }
                }
            } else {
                $message = translate('Add Successfully');
                $status = 'success';
                $Product = new Product();
                $slug = createSlug('products', $request->title[$lang_id]);
            }
            $Product['random_rating']                  = $request->rating;
            $Product['availability']                   = $request->availability;
            $Product['slug']                           = $slug;
            $Product['duration']                       = $request->duration;
            $Product['duration_text']                  = $request->duration_text;
            $Product['description']                    = $request->description;
            $Product['can_be_booked_up_to_advance']    = $request->can_be_booked_up_to_advance;
            $Product['can_be_cancelled_up_to_advance'] = $request->can_be_cancelled_up_to_advance;
            $Product['excursion_type']                 = $request->excursion_type;
            $Product['pick_option']                    = $request->pick_option;
            $Product['address']                        = $request->address;
            $Product['address_lattitude']              = $request->address_lattitude;
            $Product['address_longitude']              = $request->address_longitude;
            $Product['status']                         = isset($request->excertion_status) ? 'Active' : 'Deactive';
            $Product['per_modifi_or_cancellation']     = isset($request->per_modifi_or_cancellation) ? 1 : 0;
            $Product['product_bookable_type']          = $request->product_bookable_type;
            $Product['video']                          = $request->video;
            $Product['country']                        = $request->country;
            $Product['category']                       = implode(',', $request->category);
            $Product['selling_price']                  = $request->selling_price;
            $Product['original_price']                 = $request->original_price;
            $Product['per_value']                      = $request->per_value;
            $Product['infant_age_limit']               = $request->infant_age_limit;
            $Product['child_age_limit']                = $request->child_age_limit;
            // $Product['minimum_people']                 = $request->minimum_people;
            // $Product['maximum_people']                 = $request->maximum_people;
            $Product['rate_valid_until']          = $request->rate_valid_until;
            $Product['state']                     = $request->state;
            $Product['city']                      = $request->city;
            $Product['affiliate_commission']      = $request->affiliate_commission;
            $Product['how_many_are_sold']         = $request->how_many_are_sold;
            $Product['note_on_sale_date']         = $request->note_on_sale_date;
            $Product['image_text']                = $request->image_text;
            $Product['client_reward_point']       = $request->client_reward_point;
            $Product['client_reward_point_type']  = $request->client_reward_point_type;
            $Product['point_to_purchase_product'] = $request->point_to_purchase_product;
            // $Product['option_note']               = $request->option_note;
            // $Product['booking_policy']                 = $request->booking_policy;
            $Product['approx']                    = isset($request->approx) ? 1 : 0;
            $Product['is_recently']               = isset($request->is_recently) ? 1 : 0;
            $Product['timing_status']             = isset($request->timing_status) ? 1 : 0;
            $Product['popup_status']              = $request->popup_status;
            $Product['blackout_date']             = json_encode(explode(',', $request->blackout_date));


            
            $Product['product_type']              = 'excursion';
            if (!empty($request->suppliers)) {
                $Product['supplier'] = implode(',', $request->suppliers);
            }

            if ($request->hasFile('image')) {
                $files = $request->file('image');
                $random_no = Str::random(5);
                $newImage = time() . $random_no . '.' . $files->getClientOriginalExtension();
                $destinationPath = public_path('uploads/product_images');
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
                $destinationPath = public_path('uploads/product_images');
                $imgFile->save($destinationPath . '/' . $newImage);
                $Product['image'] = $newImage;
            }

            if ($request->hasFile('logo')) {
                $files = $request->file('logo');
                $random_no = Str::random(5);
                $newImage = time() . $random_no . '.' . $files->getClientOriginalExtension();
                $destinationPath = public_path('uploads/product_images');
                $imgFile = Image::make($files->path());
                $height = $imgFile->height();
                $width = $imgFile->width();
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
                $files = $request->file('video_thumbnail');
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
                $Product['video_thumbnail'] = $newImage;
            }

            if ($request->popup_image_dlt=='') {
                $Product['popup_image'] = $request->popup_image_dlt;
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
            if ($request->pro_popup_image_dlt=='') {
                $Product['pro_popup_image'] = $request->pro_popup_image_dlt;
            }
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

            if ($request->pro_popup_thumnail_image_dlt=='') {
                $Product['pro_popup_thumnail_image'] = $request->pro_popup_thumnail_image_dlt;
            }

           
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
            if ($request->pro_popup_video_dlt =='') {
                $Product['pro_popup_video'] = $request->pro_popup_video_dlt;
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
            $Product['pro_popup_link']     = $request->pro_popup_link;   
            $Product['redirection_link']   = $request->redirection_link;   

            $Product->save();
            $product_id = $Product->id;
            // Product Language
            if (!empty($request->category)) {
                ProductCategory::where('product_id', $request->id)->delete();
                foreach ($request->category as $key => $value) {
                  
                    if ($value != '') {
                      
                        $sub_category = $request->sub_category;
                        
                            if (isset($sub_category[$key])) {
                                foreach ($sub_category[$key] as $key2 => $value2) {
                                    $ProductCategory = new ProductCategory();

                                    $ProductCategory->sub_category = $value2;
                                    $ProductCategory->category     = $value;
                                    $ProductCategory->product_id   = $product_id;
                                    $ProductCategory->save();
                                    
                                }
                            }else{
                                    $ProductCategory = new ProductCategory();
                                    $ProductCategory->category  = $value;
                                    $ProductCategory->product_id = $product_id;
                                    $ProductCategory->save();
                            }
                        
                        // $ProductCategory->product_id = $product_id;
                        // $ProductCategory->save();
                    }
                }
            }

            $get_languages = Language::where(['status'=>'Active','is_delete'=>0])->get();

            ProductLanguage::where('product_id', $request->id)->where('language_id',$lang_id)->delete();
            foreach ($get_languages as $key => $value) {
                if (!getDataFromDB('product_language',['language_id'=>$value['id'],'product_id'=>$request->id],'row')) {
                    // Product Language
       
                    $ProductLanguage = new ProductLanguage();

                    $ProductLanguage->description        = isset($request->title[$value['id']]) ?  $request->title[$value['id']] : $request->title[$lang_id];
                    $ProductLanguage->short_description  = isset($request->short_description[$value['id']]) ?  $request->short_description[$value['id']] : $request->short_description[$lang_id];
                    $ProductLanguage->main_description   = isset($request->main_description[$value['id']]) ? change_str($request->main_description[$value['id']]) : $request->main_description[$lang_id];

                    $ProductLanguage->popup_heading      = isset($request->popup_heading[$value['id']]) ?  $request->popup_heading[$value['id']] : $request->popup_heading[$lang_id];
                    $ProductLanguage->popup_title        = isset($request->popup_title[$value['id']]) ?  $request->popup_title[$value['id']] : $request->popup_title[$lang_id];
                    // Experice Icon
                    
                    // // Product Pop up
                    $ProductLanguage->pro_popup_title     = isset($request->pro_popup_title[$value['id']]) ?  $request->pro_popup_title[$value['id']] : $request->pro_popup_title[$lang_id];

                    $ProductLanguage->pro_popup_desc      = isset($request->pro_popup_desc[$value['id']]) ? change_str($request->pro_popup_desc[$value['id']]) : $request->pro_popup_desc[$lang_id];    
                    
                    // // Extra option Note
                    $ProductLanguage->extra_option_note   = isset($request->extra_option_note[$value['id']]) ? change_str($request->extra_option_note[$value['id']]) : $request->extra_option_note[$lang_id];  

                    $ProductLanguage->option_note         = isset($request->option_note[$value['id']]) ? change_str($request->option_note[$value['id']]) : $request->option_note[$lang_id];

                    $ProductLanguage->booking_policy      = isset($request->booking_policy[$value['id']]) ? change_str($request->booking_policy[$value['id']]) : $request->booking_policy[$lang_id];

                    // Related Pro
                    $ProductLanguage->related_product_title = isset($request->related_product_title[$value['id']]) ?  $request->related_product_title[$value['id']] : $request->related_product_title[$lang_id];

                    $ProductLanguage->language_id       = $value['id'];
                    $ProductLanguage->product_id        = $product_id;
                    $ProductLanguage->save();
                }
            }
            
            if ($request->description_title) {            
                MetaGlobalLanguage::where('meta_title','excursion_description_title')->where('meta_parent','excursion_description')->where('product_id',$product_id)->where('language_id',$lang_id)->delete();

                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('meta_global_language',['language_id'=>$value['id'],'meta_parent'=>'excursion_description','meta_title'=>'excursion_description_title','product_id' => $product_id],'row')) {       

                        $MetaGlobalLanguageDescription  = new MetaGlobalLanguage();
                    
                        $MetaGlobalLanguageDescription->meta_parent = 'excursion_description';
                        $MetaGlobalLanguageDescription->meta_title  = 'excursion_description_title';
                        $MetaGlobalLanguageDescription->title       =  isset($request->description_title[$value['id']]) ?  $request->description_title[$value['id']] : $request->description_title[$lang_id];
                        $MetaGlobalLanguageDescription->language_id = $value['id'];
                        $MetaGlobalLanguageDescription->product_id  = $product_id;
                        $MetaGlobalLanguageDescription->status      = 'Active';
                        $MetaGlobalLanguageDescription->save();
                    }
                }
            }
            
                        
               
            // print_die($request->recom_big_pic);
            // Product Setting
            
            ProductSetting::where(['product_id' => $product_id, 'type' => 'Excursion'])->delete();
            if (!empty($request->product_setting)) {
                foreach ($request->product_setting as $key => $PS) {
                    if($key == 'add_to_recom_tours' || $key == 'recom_tours_main_page_big_picture' || $key == 'recom_tours_main_page_small_picture' || $key == 'recom_tours_main_page_small_picture'){
                        $get_check_ = ProductSetting::where(['country_id'=> $request->country,'meta_title'=>$key])->count();
                        if($key == 'recom_tours_main_page_small_picture'){
                            if($get_check_ >= 2){
                                // print_die()
                                ProductSetting::where(['country_id'=> $request->country,'meta_title'=>$key])->first()->delete();
                            }
                        }else{
                            // print_die($get_check_);
                            if($get_check_ > 0){
                                ProductSetting::where(['country_id'=> $request->country,'meta_title'=>$key])->delete();
                            }
                        }
                    }
                    $ProductSetting               = new ProductSetting();
                    $ProductSetting['product_id'] = $product_id;
                    $ProductSetting['country_id'] = $request->country;
                    $ProductSetting['type']       = 'Excursion';
                    $ProductSetting['meta_title'] = $key;

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
                    $ProductSetting['meta_type']  = $PS == 'on' ? 'radio' : 'value';
                    $ProductSetting['meta_value'] = $PS == 'on' ? 1 : $PS;
                    $ProductSetting->save();
                }
            }

            // Product Information
            ProductInfo::where(['product_id' => $product_id])->delete();
            if (!empty($request->product_info)) {
                foreach ($request->product_info as $key => $PI) {
                    $ProductInfo = new ProductInfo();
                    $ProductInfo['product_id'] = $product_id;
                    $ProductInfo['title'] = $key;
                    $ProductInfo['value'] = $PI;
                    $ProductInfo->save();
                }
            }

            //Muliple File
            $ProductImage = ProductImages::where('product_id', $request->id)->get();
            
            if (isset($request->image_id)) {
                $count_img =  count($request->image_id);
            
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
            $get_pro_images = ProductImages::where('product_id', $request->id)->get();
            foreach ($get_pro_images as $key => $image_val) {
                $updatedta = [];
                $updatedta['sort_order_images'] = @$request->sort_order_images[$key];
                ProductImages::where('id', $image_val['id'])->update($updatedta);
            }


            // Multiple IMages
            if ($request->hasFile('files')) {
                $files = $request->file('files');
                foreach ($files as $fileKey => $image) {

                    $ProductImages = new ProductImages();
                    $random_no = Str::random(5);
                    $ProductImages['product_images'] = $newImage = time() . $random_no . '.' . $image->getClientOriginalExtension();
                    $ProductImages['sort_order_images'] = $request->sort_order_images[$fileKey];
                    $destinationPath = public_path('uploads/product_images');
                    $imgFile = Image::make($image->path());
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

                    $destinationPath = public_path('uploads/product_images');
                    $imgFile->save($destinationPath . '/' . $newImage);
                    // $image->move($destinationPath, $ProductImages['product_images']);
                    $ProductImages['product_id'] = $product_id;
                    $ProductImages->save();
                    
                }
            }

            if (isset($request->info_title) && count($request->info_title) > 0) {
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

            // Highlights
            $get_Producthigh = ProductHighlights::where('product_id', $request->id)->get();
            foreach ($get_Producthigh as $key => $get_highlight_delete) {
                if (!in_array($get_highlight_delete['id'], $request->highlights_id)) {
                    ProductHighlights::where('id', $get_highlight_delete['id'])->delete();
                }
            }
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

            // Voucher
            if (isset($request->voucher_title)) {
                if ($request->voucher_title) {
                    $VoucherTitle = $request->voucher_title;
                    $VoucherDescription = $request->voucher_description;

                    // ProductVoucher::where(['product_id' => $product_id])->delete();
                    ProductVoucherLanguage::where(['product_id' => $product_id, 'type' => "excursion"])->where('language_id',$lang_id)->delete();

                    foreach ($request->voucher_id as $key => $value_2) {
                        if ($value_2 != '') {
                            $product_voucher = ProductVoucher::where(['id' => $value_2, 'type' => 'excursion'])->first();
                        } else {
                            $product_voucher = new ProductVoucher();
                        }

                        if ($request->hasFile('voucher_image')) {
                            if (isset($request->voucher_image[$key]) && $request->voucher_image[$key] != '') {
                                $files = $request->file('voucher_image')[$key];
                                $random_no = uniqid();
                                $img = $files;
                                $ext = $files->getClientOriginalExtension();
                                $new_name = $random_no . time() . '.' . $ext;
                                // $destinationPath = public_path('uploads/product_images');
                                // $img->move($destinationPath, $new_name);

                                $imgFile             = Image::make($files);
                                $height              = $imgFile->height();
                                $width               = $imgFile->width();
                                $imgFile->resize(760, 320, function ($constraint) {
                                    $constraint->aspectRatio();
                                });

                                $destinationPath = public_path('uploads/product_images');
                                $imgFile->save($destinationPath . '/' . $new_name);
                                
                                $product_voucher['voucher_image'] = $new_name;
                            }
                        }

                        if ($request->hasFile('client_logo')) {
                            if (isset($request->client_logo[$key]) && $request->client_logo[$key] != '') {
                                $files = $request->file('client_logo')[$key];

                                $random_no = uniqid();
                                $img = $files;
                                $ext = $files->getClientOriginalExtension();
                                $new_name = $random_no . time() . '.' . $ext;
                                $destinationPath = public_path('uploads/product_images');
                                $img->move($destinationPath, $new_name);
                                $product_voucher['client_logo'] = $new_name;
                            }
                        }

                        if ($request->hasFile('our_logo')) {
                            if (isset($request->our_logo[$key]) && $request->our_logo[$key] != '') {
                                $files = $request->file('our_logo')[$key];

                                $random_no = uniqid();
                                $img = $files;
                                $ext = $files->getClientOriginalExtension();
                                $new_name = $random_no . time() . '.' . $ext;
                                $destinationPath = public_path('uploads/product_images');
                                $img->move($destinationPath, $new_name);
                                $product_voucher['our_logo'] = $new_name;
                            }
                        }

                        $product_voucher['voucher_amount'] = $request->voucher_amount[$key];

                        $product_voucher['meeting_point']  = $request->meeting_point[$key];
                        $product_voucher['phone_number']   = $request->phone_number[$key];

                        $product_voucher['product_id']     = $product_id;
                        $product_voucher['type']           = "excursion";
                        $product_voucher['amount_type']    = $request->amount_type[$key];
                        
                        $product_voucher->save();


                        foreach ($get_languages as $lang_key => $value) {
                            if (!getDataFromDB('product_voucher_language',['language_id'=>$value['id'],'product_id' => $request->id,'voucher_id'=> $product_voucher->id ],'row')) {   

                                $ProductVoucherLanguage = new ProductVoucherLanguage();
                                $ProductVoucherLanguage['product_id']  = $product_id;
                                $ProductVoucherLanguage['language_id'] = $value['id'];
                                $ProductVoucherLanguage['type']        = "excursion";
                                $ProductVoucherLanguage['voucher_id']  = $product_voucher->id;
                                $ProductVoucherLanguage['title']       = isset($request->voucher_title[$value['id']][$key]) ?  $request->voucher_title[$value['id']][$key] : $request->voucher_title[$lang_id][$key];
                                $ProductVoucherLanguage['description']  = isset($request->voucher_description[$value['id']][$key]) ?  $request->voucher_description[$value['id']][$key] : $request->voucher_description[$lang_id][$key];
                                $ProductVoucherLanguage['voucher_remark'] = $request->voucher_remark[$lang_id][$key];
                                $ProductVoucherLanguage->save();
                            }
                        }
                    }
                }
            }

            // Timings
            if ($request->day) {
                $Day = $request->day;
                $Timefrom = $request->time_from;
                $Timeto = $request->time_to;

                if ($request->id != '') {
                    $get_timings = ProductTimings::where('product_id', $request->id)->delete();
                }
                foreach ($request->day as $key => $value_3) {
                    if ($value_3 != '') {
                        $product_timings = new ProductTimings();
                        $product_timings['product_id'] = $product_id;
                        $product_timings['day'] = $Day[$key];
                        $product_timings['time_from'] = isset($Timefrom[$key]) ? $Timefrom[$key] : '';
                        $product_timings['time_to'] = isset($Timeto[$key]) ? $Timeto[$key] : '';
                        $product_timings['is_close'] = isset($request->is_close[$Day[$key]]) ? 1 : 0;
                        if ($product_timings['time_from'] == '' || $product_timings['time_to'] == '') {
                            // $product_timings['is_close']   = 1;
                        }
                        $product_timings->save();
                    }
                }
            }


            // Tour Option heading start
                if (!empty($request->tour_option_heading)) {
                    MetaGlobalLanguage::where('meta_parent', 'tour_option_heading')->where('product_id',$product_id)->where('language_id',$lang_id)->delete();

                    foreach ($get_languages as $key => $value) {
                        if (!getDataFromDB('meta_global_language',['language_id'=>$value['id'],'meta_parent'=>'tour_option_heading','product_id' => $product_id],'row')) {       

                            $MetaGlobalLanguage = new MetaGlobalLanguage();
                            $MetaGlobalLanguage->meta_parent = 'tour_option_heading';
                            $MetaGlobalLanguage->meta_title  = 'heading_title';
                            $MetaGlobalLanguage->product_id  = $product_id;
                            $MetaGlobalLanguage->title       = isset($request->tour_option_heading[$value['id']]) ?  $request->tour_option_heading[$value['id']] : $request->tour_option_heading[$lang_id];
                            $MetaGlobalLanguage->language_id = $value['id'];
                            $MetaGlobalLanguage->status      = 'Active';
                            $MetaGlobalLanguage->save();
                        }
                    }
                }
            // Tour Option heading End


            // Options Table
            if ($request->tour_option) {
                $touroption = $request->tour_option;
                $addtionalinfo = $request->addtional_info;
                $transferoption = $request->transfer_option;
                $adult = $request->adult;
                $childprice = $request->child_price;
                $infant = $request->infant;
                $roomprice = $request->room_price;

                ProductOptionLanguage::where(['product_id' => $product_id])->where('language_id',$lang_id)->delete();
              
                foreach ($request->options_id as $key => $value_4) {
                    if ($value_4 != '') {
                        $ProductOptions = ProductOptions::find($value_4);
                    } else {
                        $ProductOptions = new ProductOptions();
                    }
                    $ProductOptions['status'] = 1;
                    $ProductOptions['product_id'] = $product_id;
                    $ProductOptions['available_type'] = $avaType = $request->available_type[$key];
                    $ProductOptions['time_available'] = isset($request->option_available_time[$key]) ? implode(',', $request->option_available_time[$key]) : '';
                    if ($avaType == 'date_available') {
                        if (isset($request->time_for_all_dates[$key])) {
                            $datesArr = [];
                            $arr = [];
                            foreach ($request->tour_avaliable_date[$key] as $DKey => $TAD) {
                                $arr[$TAD] = implode(',', $request->option_available_time[$key]);
                            }
                        } else {
                            $datesArr = [];
                            $arr = [];
                            foreach ($request->tour_avaliable_date[$key] as $DKey => $TAD) {
                                $arr[$TAD] = isset($request->available_tour_date_time[$key][$DKey]) ? implode(',', $request->available_tour_date_time[$key][$DKey]) : '';
                            }
                        }
                        $ProductOptions['date_available'] = json_encode($arr);
                        $ProductOptions['same_time_for_dates'] = isset($request->time_for_all_dates[$key]) ? 1 : 0;
                    } elseif ($avaType == 'days_available') {
                        if (isset($request->time_for_all_weekdays[$key])) {
                            $weekdaysArr = [];
                            $arr = [];
                            if (isset($request->available_tour_week_time_status[$key])) {
                                foreach ($request->available_tour_week_time_status[$key] as $ATKey => $ATVTS) {
                                    $arr[$ATKey] = implode(',', $request->option_available_time[$key]);
                                }
                            }
                        } else {
                            $weekdaysArr = [];
                            $arr = [];
                            foreach ($request->available_tour_week_time_status[$key] as $ATKey => $ATVTS) {
                                $arr[$ATKey] = isset($request->available_tour_week_time[$key][$ATKey]) ? implode(',', $request->available_tour_week_time[$key][$ATKey]) : '';
                            }
                        }
                        $ProductOptions['days_available'] = json_encode($arr);
                        $ProductOptions['same_time_for_weekdays'] = isset($request->time_for_all_weekdays[$key]) ? 1 : 0;
                    }

                    $ProductOptions->save();

                    // ProductOptionLanguage

                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('product_option_language',['language_id'=>$value['id'],'product_id' => $request->id,'option_id'=> $ProductOptions->id ],'row')) { 
                            $ProductOptionLanguage = new ProductOptionLanguage();
                            $ProductOptionLanguage['product_id']  = $product_id;
                            $ProductOptionLanguage['language_id'] = $value['id'];
                            $ProductOptionLanguage['option_id']   = $ProductOptions->id;
                            $ProductOptionLanguage['title']       = isset($request->tour_option[$value['id']][$key]) ?  $request->tour_option[$value['id']][$key] : $request->tour_option[$lang_id][$key];
                            $ProductOptionLanguage['description'] = isset($request->addtional_info[$value['id']][$key]) ?  $request->addtional_info[$value['id']][$key] : $request->addtional_info[$lang_id][$key];
                            $ProductOptionLanguage->save();
                        }
                    }

                    if (!isset($_POST['private_tour_price'][$key])) {
                        $minumum_data = [];
                        $minumum_data['minimum_people'] = $request->minimum_people[$key];
                        $minumum_data['maximum_people'] = $request->maximum_people[$key];
                        $minumum_data['is_private_tour'] = 0;

                        ProductOptions::where(['product_id' => $product_id, 'id' => $ProductOptions->id])->update($minumum_data);


                        $ProductOptionWeekTour_ = ProductOptionWeekTour::where('product_option_id', $ProductOptions->id)->get();
                        // dd($request->week_tour_id []);
                        if (count($ProductOptionWeekTour_) > 0) {
                            // if()
                            foreach ($ProductOptionWeekTour_ as $WeekTour_key => $get_productoptionweektour_delete) {
                                if (!in_array($get_productoptionweektour_delete['id'], Arr::flatten($request->week_tour_id ?? []))) {
                                    ProductOptionWeekTour::where('id', $get_productoptionweektour_delete['id'])->delete();
                                }
                            }
                        }

                        // ///////////////// hide
                        // Add Week Days
                        if (!empty($request->tour_week)) {
                            foreach ($request->tour_week as $weekKey => $TW) {
                                if ($weekKey == $key) {

                                    foreach ($TW as $k => $WK) {
                                        if ($request->week_tour_id[$weekKey][$k] != '') {
                                            $ProductOptionWeekTour = ProductOptionWeekTour::find($request->week_tour_id[$weekKey][$k]);
                                        } else {
                                            $ProductOptionWeekTour = new ProductOptionWeekTour();
                                        }
                                        $ProductOptionWeekTour['product_id'] = $product_id;
                                        $ProductOptionWeekTour['product_option_id'] = $ProductOptions->id;
                                        $ProductOptionWeekTour['week_day'] = $WK;
                                        $ProductOptionWeekTour['adult'] = $request->tour_week_price_adult[$weekKey][$k];
                                        $ProductOptionWeekTour['child_price'] = isset($request->tour_week_price_child[$weekKey][$k]) ? $request->tour_week_price_child[$weekKey][$k] : 'N/A';
                                        $ProductOptionWeekTour['child_allowed'] = $request->tour_week_child_allowed[$weekKey][$k] == 1 ? 1 : 0;
                                        $ProductOptionWeekTour['infant_price'] = isset($request->tour_week_price_infant[$weekKey][$k]) ? $request->tour_week_price_infant[$weekKey][$k] : 'N/A';
                                        $ProductOptionWeekTour['infant_allowed'] = $request->tour_week_infant_allowed[$weekKey][$k] == 1 ? 1 : 0;
                                        $ProductOptionWeekTour->save();
                                    }
                                }
                            }
                        }

                        // ///////////////// hide
                        // Product Tour Price Details
                        foreach ($request->tour_price_adult as $tourKey => $TPA) {
                            // dd($request->tour_price_child);
                            if ($tourKey == $key) {
                                if ($TPA != '') {
                                    if ($request->tour_price_details_id[$tourKey] != '') {
                                        $ProductTourPriceDetails = ProductTourPriceDetails::find($request->tour_price_details_id[$tourKey]);
                                    } else {
                                        $ProductTourPriceDetails = new ProductTourPriceDetails();
                                    }
                                    $ProductTourPriceDetails['product_id'] = $product_id;
                                    $ProductTourPriceDetails['product_option_id'] = $ProductOptions->id;
                                    $ProductTourPriceDetails['adult_price'] = $TPA;
                                    $ProductTourPriceDetails['child_price'] = isset($request->tour_price_child[$tourKey]) ? $request->tour_price_child[$tourKey] : 'N/A';
                                    $ProductTourPriceDetails['child_allowed'] = isset($request->tour_child_allowed[$tourKey]) ? 1 : 0;
                                    $ProductTourPriceDetails['infant_allowed'] = isset($request->tour_infant_allowed[$tourKey]) ? 1 : 0;
                                    $ProductTourPriceDetails['infant_price'] = isset($request->tour_price_infant[$tourKey]) ? $request->tour_price_infant[$tourKey] : 'N/A';
                                    $ProductTourPriceDetails->save();
                                }
                            }
                        }

                        // ///////////////// hide
                        // Product Room Price Details
                        foreach ($request->tour_room_adult as $roomKey => $TRD) {
                            if ($roomKey == $key) {
                                if ($TRD != '') {
                                    if ($request->product_tour_room_id[$roomKey] != '') {
                                        $ProductTourRoom = ProductTourRoom::find($request->product_tour_room_id[$roomKey]);
                                    } else {
                                        $ProductTourRoom = new ProductTourRoom();
                                    }
                                    $ProductTourRoom['product_id'] = $product_id;
                                    $ProductTourRoom['product_option_id'] = $ProductOptions->id;
                                    $ProductTourRoom['adult'] = $TRD;
                                    $ProductTourRoom['child'] = $request->tour_room_child[$roomKey];
                                    $ProductTourRoom['infant'] = isset($request->tour_infant_limit[$roomKey]) ? 'No Limit' : $request->tour_room_infant[$roomKey];
                                    $ProductTourRoom['price'] = $request->tour_room_price[$roomKey];
                                    $ProductTourRoom['infant_limit'] = isset($request->tour_infant_limit[$roomKey]) ? 1 : 0;
                                    $ProductTourRoom->save();
                                }
                            }
                        }
                    }

                    // Add Tour  Upgrade
                    $ProductOptionTourUpgrade_ = ProductOptionTourUpgrade::where('product_option_id', $ProductOptions->id)->get();
                    if (count($ProductOptionTourUpgrade_) > 0) {

                        if ($request->option_tour_upgrade_id_ != null) {
                            foreach ($ProductOptionTourUpgrade_ as $TourUpgrade_key => $get_ProductOptionTourUpgrade_delete) {
                                if (!in_array($get_ProductOptionTourUpgrade_delete['id'], Arr::flatten($request->option_tour_upgrade_id_))) {
                                    ProductOptionTourUpgrade::where('id', $get_ProductOptionTourUpgrade_delete['id'])->delete();
                                }
                            }
                        } else {
                            ProductOptionTourUpgrade::where('product_id', $product_id)->delete();
                        }
                    }
                    if (!empty($request->tour_upgrade_title)) {
                        foreach ($request->tour_upgrade_title as $upgradeKey => $TU) {

                            if ($upgradeKey == $key) {
                                foreach ($TU as $k => $TUK) {
                                    if ($request->option_tour_upgrade_id_[$upgradeKey][$k] != '') {
                                        $ProductOptionTourUpgrade = ProductOptionTourUpgrade::find($request->option_tour_upgrade_id_[$upgradeKey][$k]);
                                    } else {
                                        $ProductOptionTourUpgrade = new ProductOptionTourUpgrade();
                                    }

                                    $ProductOptionTourUpgrade['product_id'] = $product_id;
                                    $ProductOptionTourUpgrade['product_option_id'] = $ProductOptions->id;
                                    $ProductOptionTourUpgrade['title'] = $TUK;
                                    $ProductOptionTourUpgrade['type'] = 'excursion';
                                    $ProductOptionTourUpgrade['adult_price'] = $request->tour_upgrade_price_adult[$upgradeKey][$k];
                                    $ProductOptionTourUpgrade['child_price'] = isset($request->tour_upgrade_price_child[$upgradeKey][$k]) ? $request->tour_upgrade_price_child[$upgradeKey][$k] : 'N/A';
                                    $ProductOptionTourUpgrade['child_allowed'] = $request->tour_upgrade_child_allowed[$upgradeKey][$k] == 1 ? 1 : 0;
                                    $ProductOptionTourUpgrade['infant_price'] = isset($request->tour_upgrade_price_infant[$upgradeKey][$k]) ? $request->tour_upgrade_price_infant[$upgradeKey][$k] : 'N/A';
                                    $ProductOptionTourUpgrade['infant_allowed'] = $request->tour_upgrade_infant_allowed[$upgradeKey][$k] == 1 ? 1 : 0;

                                    $ProductOptionTourUpgrade->save();
                                }
                            } else {
                                //    dd('safaf');
                                //     $ProductOptionTourUpgrade_ = ProductOptionTourUpgrade::where('product_option_id', $ProductOptions->id)->get();
                                //     foreach ($ProductOptionTourUpgrade_ as $TourUpgrade_key => $get_ProductOptionTourUpgrade_delete) {
                                //         if (!in_array($get_ProductOptionTourUpgrade_delete['id'], $request->option_tour_upgrade_id_[$upgradeKey])) {
                                //             ProductOptionTourUpgrade::where('id', $get_ProductOptionTourUpgrade_delete['id'])->delete();
                                //         }
                                //     }
                            }
                        }
                    }


                    $ProductOptionGroupPercentage_ = ProductOptionGroupPercentage::where('product_option_id', $ProductOptions->id)->get();
                    if (count($ProductOptionGroupPercentage_) > 0) {
                        foreach ($ProductOptionGroupPercentage_ as $GroupPer_key => $get_ProductOptionGroupPercentage_delete) {
                            if (!in_array($get_ProductOptionGroupPercentage_delete['id'], Arr::flatten($request->option_group_percentage_id_ ?? []))) {
                                ProductOptionGroupPercentage::where('id', $get_ProductOptionGroupPercentage_delete['id'])->delete();
                            }
                        }
                    }

                    // Add Group Percentage
                    if (!empty($request->group_percentage_no_passenger)) {
                        foreach ($request->group_percentage_no_passenger as $perKey => $GPNP) {
                            // print_die($request->option_tour_upgrade_id_);
                            if ($perKey == $key) {

                                foreach ($GPNP as $k => $GPNPA) {
                                    if ($request->option_group_percentage_id_[$perKey][$k] != '') {
                                        $ProductOptionGroupPercentage = ProductOptionGroupPercentage::find($request->option_group_percentage_id_[$perKey][$k]);
                                    } else {
                                        $ProductOptionGroupPercentage = new ProductOptionGroupPercentage();
                                    }

                                    $ProductOptionGroupPercentage['product_id'] = $product_id;
                                    $ProductOptionGroupPercentage['product_option_id'] = $ProductOptions->id;
                                    $ProductOptionGroupPercentage['number_of_passenger'] = $GPNPA;
                                    $ProductOptionGroupPercentage['default_percentage'] = $request->group_percentage_default_price[$perKey][$k];

                                    $ProductOptionGroupPercentage['weekdays_percentage'] = $request->group_percent_week_set_default[$perKey][$k] == 0 ? $request->group_percentage_weekdays_price[$perKey][$k] : $request->group_percentage_default_price[$perKey][$k];

                                    $ProductOptionGroupPercentage['weekdays_set_default'] = $request->group_percent_week_set_default[$perKey][$k] == 1 ? 1 : 0;

                                    $ProductOptionGroupPercentage['period_percentage'] = $request->group_percent_period_set_default[$perKey][$k] == 0 ? $request->group_percentage_period_price[$perKey][$k] : $request->group_percentage_default_price[$perKey][$k];
                                    $ProductOptionGroupPercentage['period_set_default'] = $request->group_percent_period_set_default[$perKey][$k] == 1 ? 1 : 0;
                                    $ProductOptionGroupPercentage->save();
                                }
                            }
                        }
                    }

                    // Add Period Pricing
                    // Add Tour  Upgrade
                   
                    if (!empty($request->option_period_pricing_id_)) {
                        foreach ($request->option_period_pricing_id_ as $periodKey => $PP) {
                            // print_die($request->option_tour_upgrade_id_);
                            if ($periodKey == $key) {
                                $ProductOptionPeriodPricing_ = ProductOptionPeriodPricing::where('product_option_id', $ProductOptions->id)->get();
                                foreach ($ProductOptionPeriodPricing_ as $PeriodPrincing_key => $get_ProductOptionPeriodPricing_delete) {
                                    if (!in_array($get_ProductOptionPeriodPricing_delete['id'], $request->option_period_pricing_id_[$periodKey])) {
                                        ProductOptionPeriodPricing::where('id', $get_ProductOptionPeriodPricing_delete['id'])->delete();
                                    }
                                }
                                foreach ($PP as $k => $PPK) {
                                    if ($request->option_period_pricing_id_[$periodKey][$k] != '') {
                                        $ProductOptionPeriodPricing = ProductOptionPeriodPricing::find($request->option_period_pricing_id_[$periodKey][$k]);
                                    } else {
                                        $ProductOptionPeriodPricing = new ProductOptionPeriodPricing();
                                    }

                                    $ProductOptionPeriodPricing['product_id'] = $product_id;
                                    $ProductOptionPeriodPricing['product_option_id'] = $ProductOptions->id;
                                    $ProductOptionPeriodPricing['from_date'] = $request->period_pricing_from_date[$periodKey][$k];
                                    $ProductOptionPeriodPricing['to_date'] = $request->period_pricing_to_date[$periodKey][$k];
                                    $ProductOptionPeriodPricing['adult_price'] = $request->tour_period_price_adult[$periodKey][$k];
                                    $ProductOptionPeriodPricing['child_price'] = isset($request->tour_period_price_child[$periodKey][$k]) ? $request->tour_period_price_child[$periodKey][$k] : 'N/A';
                                    $ProductOptionPeriodPricing['child_allowed'] = $request->period_pricing_child_allowed[$periodKey][$k] == 1 ? 1 : 0;
                                    $ProductOptionPeriodPricing['infant_price'] = isset($request->period_price_infant[$periodKey][$k]) ? $request->period_price_infant[$periodKey][$k] : 'N/A';
                                    $ProductOptionPeriodPricing['infant_allowed'] = $request->period_pricing_infant_allowed[$periodKey][$k] == 1 ? 1 : 0;

                                    $ProductOptionPeriodPricing->save();
                                }
                            }
                        }
                    }else{
                        ProductOptionPeriodPricing::where('product_option_id', $ProductOptions->id)->delete();
                    }
                
          
                    // Private Cars
                    if (Session::has('addcars')) {
                         ProductPrivateTransferCars::where(['product_id' => $product_id,'product_option_id'=>$value_4])->delete();
                        $carsList = Session::get('addcars');
                         
                        foreach ($carsList as $CLKey => $CL) {
                            if ($CLKey == $key) {
                               
                                foreach ($CL as $k => $CLD) {
                                    $carDetails = CarDetails::find($CLD);
                                
                                    $carName = getDataFromDB('car_details_language', ['car_details_id' => $CLD], 'row');

                                    $ProductPrivateTransferCars = new ProductPrivateTransferCars();
                                    $ProductPrivateTransferCars['product_id'] = $product_id;
                                    $ProductPrivateTransferCars['product_option_id'] = $ProductOptions->id;
                                    $ProductPrivateTransferCars['car_id'] = $CLD;
                                    $ProductPrivateTransferCars['car_name'] = @$carName->title;
                                    $ProductPrivateTransferCars['number_of_passenger'] = $carDetails->number_of_passengers;
                                    $ProductPrivateTransferCars['price'] = $carDetails->price;
                                    $ProductPrivateTransferCars->save();
                                }
                            }
                        }
                    }

                    // Product Tax And Service
                    foreach ($request->tax_serivce as $taxKey => $TS) {
                        if ($taxKey == $key) {
                            if ($request->tax_service_id[$taxKey] != '') {
                                $ProductOptionTaxServiceCharge = ProductOptionTaxServiceCharge::find($request->tax_service_id[$taxKey]);
                            } else {
                                $ProductOptionTaxServiceCharge = new ProductOptionTaxServiceCharge();
                            }
                            $ProductOptionTaxServiceCharge['product_id'] = $product_id;
                            $ProductOptionTaxServiceCharge['product_option_id'] = $ProductOptions->id;
                            $ProductOptionTaxServiceCharge['tax_allowed'] = isset($request->option_tax_allowed[$taxKey]) ? 1 : 0;
                            $ProductOptionTaxServiceCharge['tax_percentage'] = $request->option_tax_paercentage[$taxKey];
                            $ProductOptionTaxServiceCharge['service_charge_allowed'] = isset($request->option_service_allowed[$taxKey]) ? 1 : 0;
                            $ProductOptionTaxServiceCharge['service_charge_amount'] = $request->option_service_amount[$taxKey];
                            $ProductOptionTaxServiceCharge['type'] = 'excursion';
                            $ProductOptionTaxServiceCharge->save();
                        }
                    }

                    if (!empty($request->adult)) {
                        foreach ($request->adult as $statuskey => $OS) {
                            if ($statuskey == $key) {
                                $ProductOptionDetails_ = ProductOptionDetails::where('product_option_id', $ProductOptions->id)->get();
                                foreach ($ProductOptionDetails_ as $OptionDetails_key => $get_optiondetails_delete) {
                                    if (!in_array($get_optiondetails_delete['id'], $request->get_product_option_details_id[$statuskey])) {
                                        ProductOptionDetails::where('id', $get_optiondetails_delete['id'])->delete();
                                    }
                                }
                                foreach ($OS as $k => $SK) {
                                    if ($request->get_product_option_details_id[$statuskey][$k] != '') {
                                        $ProductOptionDetails = ProductOptionDetails::find($request->get_product_option_details_id[$statuskey][$k]);
                                    } else {
                                        $ProductOptionDetails = new ProductOptionDetails();
                                    }
                                    $ProductOptionDetails['product_id'] = $product_id;
                                    $ProductOptionDetails['product_option_id'] = $ProductOptions->id;
                                    $ProductOptionDetails['transfer_option'] = $request->transfer_option_name[$statuskey][$k];
                                    $ProductOptionDetails['edult'] = $SK;
                                    $ProductOptionDetails['child_price'] = $childprice[$statuskey][$k];
                                    $ProductOptionDetails['infant'] = $infant[$statuskey][$k];
                                    $ProductOptionDetails['is_input'] = $request->is_input[$statuskey][$k];
                                    $ProductOptionDetails['sort'] = $request->sort[$statuskey][$k] == '' ? 0 : $request->sort[$statuskey][$k];
                                    // $ProductOptionDetails['room_price']      = $roomprice[$statuskey][$k];
                                    $ProductOptionDetails['status'] = isset($request->option_status[$statuskey][$k]) ? 1 : 0;
                                    $ProductOptionDetails->save();
                                }
                            }
                        }
                    }

                    // Product Option Private Tour Price
                    if (isset($request->private_tour_price)) {
                        ProductOptionPrivateTourPrice::whereNotIn('id', $request->private_tour_price)
                            ->where('product_id', $product_id)
                            ->delete();
                        foreach ($request->private_tour_price as $private_tour_key => $private_value) {
                            if ($private_tour_key == $key) {
                                if ($request->private_tour_price_id[$private_tour_key] != '') {
                                    $ProductOptionPrivateTourPrice = ProductOptionPrivateTourPrice::find($request->private_tour_price_id[$private_tour_key]);
                                } else {
                                    $ProductOptionPrivateTourPrice = new ProductOptionPrivateTourPrice();
                                }
                                $ProductOptionPrivateTourPrice['product_id'] = $product_id;
                                $ProductOptionPrivateTourPrice['product_option_id'] = $ProductOptions->id;
                                $ProductOptionPrivateTourPrice['private_per_price'] = $request->price_per_car[$private_tour_key];
                                $ProductOptionPrivateTourPrice['total_allowed'] = $request->total_allowed[$private_tour_key];
                                $ProductOptionPrivateTourPrice->save();
                                $ProductOptions->is_private_tour = 1;
                                $ProductOptions->save();
                            }
                        }
                    } else {
                        $ProductOptions->is_private_tour = 0;
                        $ProductOptions->save();
                        ProductOptionPrivateTourPrice::where(['product_id' => $product_id])->delete();
                    }

                    
                }
            }

            ProuductCustomerGroupDiscount::where('product_id', $product_id)->delete();
            if(isset($request->product_customer_group_id)){
                foreach ($request->product_customer_group_id as $CGKey => $PCGI) {
                    $ProuductCustomerGroupDiscount                        = new ProuductCustomerGroupDiscount();
                    $ProuductCustomerGroupDiscount['product_id']          = $product_id;
                    $ProuductCustomerGroupDiscount['type']                = "excursion";
                    $ProuductCustomerGroupDiscount['customer_group_id']   = $PCGI;
                    $ProuductCustomerGroupDiscount['tour_price']          = $request->tour_price[$CGKey];
                    $ProuductCustomerGroupDiscount['tour_upgrade_option'] = $request->tour_upgrade_option[$CGKey];
                    $ProuductCustomerGroupDiscount['transfer_option']     = $request->transfer_option[$CGKey];
                    $ProuductCustomerGroupDiscount['weekdays']            = $request->weekdays[$CGKey];
                    $ProuductCustomerGroupDiscount['base_price']          = $request->base_price[$CGKey];
                    $ProuductCustomerGroupDiscount->save();
                }
            }

            // Single Group Percentage
            if ($request->single_group_percentage_id != '') {

                $ProductGroupPercentage = ProductGroupPercentage::find($request->single_group_percentage_id);
            } else {
                $ProductGroupPercentage = new ProductGroupPercentage();
            }

            ProductGroupPercentageLanguage::where("product_id", $product_id)->where('language_id',$lang_id)->delete();
            $ProductGroupPercentage['status']                 = 1;
            $ProductGroupPercentage['product_id']             = $product_id;
            $ProductGroupPercentage['available_type']         = $avaType = $request->group_available_type;
            $ProductGroupPercentage['group_price']            = $request->deafult_group_price;
            $ProductGroupPercentage['tax_allowed']            = isset($request->group_per_tax_allowed) ? 1 : 0;
            $ProductGroupPercentage['tax_percentage']         = $request->group_per_tax;
            $ProductGroupPercentage['service_charge_allowed'] = isset($request->group_per_service_charge) ? 1 : 0;
            $ProductGroupPercentage['service_charge_amount']  = $request->group_per_service_amount;

            $ProductGroupPercentage['time_available'] = isset($request->group_option_available_time) ? implode(',', $request->group_option_available_time) : '';
            if ($avaType == 'date_available') {
                if (isset($request->group_time_for_all_dates)) {
                    $datesArr = [];
                    $arr = [];
                    foreach ($request->group_tour_avaliable_date as $DKey => $TAD) {
                        $arr[$TAD] = implode(',', $request->group_option_available_time);
                    }
                } else {
                    $datesArr = [];
                    $arr = [];
                    foreach ($request->group_tour_avaliable_date as $DKey => $TAD) {
                        $arr[$TAD] = isset($request->group_available_tour_date_time[$DKey]) ? implode(',', $request->group_available_tour_date_time[$DKey]) : '';
                    }
                }
                $ProductGroupPercentage['date_available'] = json_encode($arr);
                $ProductGroupPercentage['same_time_for_dates'] = isset($request->group_time_for_all_dates) ? 1 : 0;
            } elseif ($avaType == 'days_available') {
                if (isset($request->group_time_for_all_weekdays)) {
                    $weekdaysArr = [];
                    $arr = [];
                    if (isset($request->group_available_tour_week_time_status)) {
                        foreach ($request->group_available_tour_week_time_status as $ATKey => $ATVTS) {
                            $arr[$ATKey] = implode(',', $request->group_option_available_time);
                        }
                    }
                } else {
                    $weekdaysArr = [];
                    $arr = [];
                    foreach ($request->group_available_tour_week_time_status as $ATKey => $ATVTS) {
                        $arr[$ATKey] = isset($request->group_available_tour_week_time[$ATKey]) ? implode(',', $request->group_available_tour_week_time[$ATKey]) : '';
                    }
                }
                $ProductGroupPercentage['days_available'] = json_encode($arr);
                $ProductGroupPercentage['same_time_for_weekdays'] = isset($request->group_time_for_all_weekdays) ? 1 : 0;
            }

            $ProductGroupPercentage->save();


            // ProductGroupPercentageDetails::where("product_id", $product_id)->delete();
            foreach ($request->single_group_percentage_details_id as $GPkey => $GP) {

                if ($GP != '') {
                    $ProductGroupPercentageDetails = ProductGroupPercentageDetails::find($GP);
                } else {
                    $ProductGroupPercentageDetails = new ProductGroupPercentageDetails();
                }

                // $ProductGroupPercentageDetails = new ProductGroupPercentageDetails();
                $ProductGroupPercentageDetails['group_price'] = $request->group_price[$GPkey];
                $ProductGroupPercentageDetails['product_id'] = $product_id;
                $ProductGroupPercentageDetails['group_percentage_id'] = $ProductGroupPercentage->id;
                $ProductGroupPercentageDetails['number_of_pax'] = $request->number_of_pax[$GPkey];

                $ProductGroupPercentageDetails->save();
            }


            foreach ($get_languages as $lang_key => $value) {
                if (!getDataFromDB('product_group_percentage_language',['language_id'=>$value['id'],'product_id' => $request->id,'group_percentage_id'=> $ProductGroupPercentage->id ],'row')) {    
                    $ProductGroupPercentageLanguage = new ProductGroupPercentageLanguage();
                    $ProductGroupPercentageLanguage['product_id']          = $product_id;
                    $ProductGroupPercentageLanguage['language_id']         = $value['id'];
                    $ProductGroupPercentageLanguage['group_percentage_id'] = $ProductGroupPercentage->id;
                    $ProductGroupPercentageLanguage['main_title']          = isset($request->main_title[$value['id']]) ?  $request->main_title[$value['id']] : $request->main_title[$lang_id];
                    $ProductGroupPercentageLanguage['title']               = isset($request->group_single_group_percentage[$value['id']]) ?  $request->group_single_group_percentage[$value['id']] : $request->group_single_group_percentage[$lang_id];
                    $ProductGroupPercentageLanguage['description']         = isset($request->group_single_group_addtional_info[$value['id']]) ?  $request->group_single_group_addtional_info[$value['id']] : $request->group_single_group_addtional_info[$lang_id];
                    $ProductGroupPercentageLanguage->save();
                }
            }



            // Faqs

            $get_Productfaq = ProductFaqs::where('product_id', $request->id)->get();
            foreach ($get_Productfaq as $key => $faq_delete) {
                if (!in_array($faq_delete['id'], $request->faq_id)) {
                    ProductFaqs::where('id', $faq_delete['id'])->delete();
                }
            }

            if (isset($request->question) && count($request->question) > 0) {
                if ($request->question) {
                    
                    // ProductFaqs::where(['product_id' => $product_id])->delete();
                    ProductFaqLanguage::where(['product_id' => $product_id])->where('language_id',$lang_id)->delete();

                    foreach ($request->faq_id as $key => $value_6) {

                        if ($value_6 != '') {
                            $product_faqs = ProductFaqs::find($value_6);
                        } else {
                            $product_faqs = new ProductFaqs();
                        }

                        $product_faqs['product_id'] = $product_id;
                        $product_faqs->save();


                        foreach ($get_languages as $lang_key => $value) {
                            if (!getDataFromDB('product_faq_language',['language_id'=>$value['id'],'product_id' => $request->id,'faq_id'=> $product_faqs->id ],'row')) {  
                                $ProductFaqLanguage = new ProductFaqLanguage();
                                $ProductFaqLanguage['product_id'] = $product_id;
                                $ProductFaqLanguage['language_id'] = $value['id'];
                                $ProductFaqLanguage['faq_id'] = $product_faqs->id;
                                $ProductFaqLanguage['question'] = isset($request->question[$value['id']][$key]) ?  $request->question[$value['id']][$key] : $request->question[$lang_id][$key];
                                $ProductFaqLanguage['answer'] = isset($request->answer[$value['id']][$key]) ?  $request->answer[$value['id']][$key] : $request->answer[$lang_id][$key];
                                $ProductFaqLanguage->save();
                            }
                        }
                    }
                }
            }

            //Site Advertisement
            if (isset($request->adver_title) && count($request->adver_title) > 0) {
                if ($request->adver_title) {
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

                        if ($request->adver_image_dlt[$key]=='') {
                            $product_advertisement['image'] = $request->adver_image_dlt[$key];
                        }
                        
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

            // Tootip
            if ($request->tooltip_title) {
                $TooltipTitle = $request->tooltip_title;
                $TooltipDescription = $request->tooltip_description;
                ProductToolTip::where(['product_id' => $product_id, 'type' => "excursion"])->delete();
                ProductToolTipLanguage::where(['product_id' => $product_id, 'type' => "excursion"])->where('language_id',$lang_id)->delete();

                foreach ($request->tooltip_title as $key => $value_2) {
                    $product_tooltip = new ProductToolTip();

                    $product_tooltip['product_id'] = $product_id;
                    $product_tooltip['type'] = "excursion";
                    $product_tooltip['default_tooltip_id'] = $request->default_tooltip_id[$key];
                    $product_tooltip->save();


                    foreach ($get_languages as $lang_key => $value) {
                        if (!getDataFromDB('product_tooltip_language',['language_id'=>$value['id'],'product_id' => $product_id,'tooltip_id'=> $product_tooltip->id ,'type'=>'excursion'],'row')) {     

                            $ProductToolTipLanguage                        = new ProductToolTipLanguage();
                            $ProductToolTipLanguage['product_id']          = $product_id;
                            $ProductToolTipLanguage['type']                = "excursion";
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

            //REQUEST POPUP
            if (isset($request->popup_id)) {
                $get_Product_req_pop = ProductRequestPopup::where('product_id', $request->id)->get();
                foreach ($get_Product_req_pop as $key => $pop_delete) {
                    if (!in_array($pop_delete['id'], $request->popup_id)) {
                        ProductRequestPopup::where('id', $pop_delete['id'])->delete();
                    }
                }
            }

            if (isset($request->request_description) && count($request->request_description) > 0) {
                if ($request->request_description) {
                    // ProductRequestPopup::where(['product_id' => $product_id ,'type'=>'excursion'])->delete();
                    ProductRequestPopupLanguage::where(['product_id' => $product_id, 'type'=>'excursion'])->where('language_id',$lang_id)->delete();

                    foreach ($request->popup_id as $key => $value_7) {

                        if ($value_7 != '') {
                            $ProductRequestPopup = ProductRequestPopup::find($value_7);
                        } else {
                            $ProductRequestPopup = new ProductRequestPopup();
                        }
                        

                        $ProductRequestPopup['product_id'] = $product_id;
                        $ProductRequestPopup['type']       = 'excursion';
                       
                        $ProductRequestPopup->save();


                        foreach ($get_languages as $lang_key => $value) {
                            if (!getDataFromDB('product_request_popup_language',['language_id'=>$value['id'],'product_id' => $request->id,'request_popup_id'=> $ProductRequestPopup->id ],'row')) {       
                            
                                $ProductRequestPopupLanguage = new ProductRequestPopupLanguage();
                                $ProductRequestPopupLanguage['product_id']  = $product_id;
                                $ProductRequestPopupLanguage['language_id'] = $value['id'];
                                $ProductRequestPopupLanguage['request_popup_id'] = $ProductRequestPopup->id;
                                
                                $ProductRequestPopupLanguage['description'] = isset($request->request_description[$value['id']][$key]) ?  $request->request_description[$value['id']][$key] : $request->request_description[$lang_id][$key];

                                $ProductRequestPopupLanguage['type']        = 'excursion';

                                $ProductRequestPopupLanguage->save();
                            }
                        }
                    }
                }
            }



             // Expireance Icon middle heading start
            if (!empty($request->experience_heading)) {
                MetaGlobalLanguage::where('meta_parent', 'middle_experience_heading')->where('language_id',$lang_id)->where('product_id',$product_id)->delete();

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
            $get_ExpIcon = ProductExprienceIcon::where(['product_id'=> $product_id,'type'=>'excursion'])->where('position_type','middel')->get();
            foreach ($get_ExpIcon as $key => $val) {
                if (!in_array($val['id'], $request->exper_id)) {
                    ProductExprienceIcon::where('id', $val['id'])->delete();
                }
            }
            // Expireance Icon Middle
            if (!empty($request->exper_id)) {
                if ($request->exper_id) {
                    
                    ProductExprienceIconLanguage::where(['product_id'=> $product_id,'type'=>'excursion'])->where('position_type','middel')->where('language_id',$lang_id)->delete();
                    foreach ($request->exper_id as $key => $over_value) {                
                        if($over_value !=''){
                            $ProductExprienceIcon       = ProductExprienceIcon::find($over_value);
                        }else{
                            $ProductExprienceIcon       = new ProductExprienceIcon();
                        }
                        $ProductExprienceIcon->product_id  = $product_id;
                        $ProductExprienceIcon->type        = "excursion";
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

                                
                                $ProductExprienceIconLanguage['type']               = 'excursion';
                                $ProductExprienceIconLanguage->save();
                            }
                        }


                    }
                }
            }

            // Expireance Icon Header

            // Expireance Icon Header heading start
                if (!empty($request->header_experience_heading)) {
                    MetaGlobalLanguage::where('meta_parent', 'header_experience_heading')->where('product_id',$product_id)->where('language_id',$lang_id)->delete();

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
                        ProductExprienceIcon::whereNotIn('id', $header_exper_id_arr)->where('product_id',$product_id)->where('type','excursion')->where('position_type','upper')->delete();
                        ProductExprienceIconLanguage::where(['product_id'=> $product_id,'type'=>'excursion'])->where('position_type','upper')->where('language_id',$lang_id)->delete();
                        foreach ($request->header_exper_id as $value_key => $header_exper_value) {                
                            if($header_exper_value !=''){
                                $ProductExprienceIconHeader       = ProductExprienceIcon::find($header_exper_value);
                            }else{
                                $ProductExprienceIconHeader       = new ProductExprienceIcon();
                            }
                            $ProductExprienceIconHeader->product_id    = $product_id;
                            $ProductExprienceIconHeader->type          = "excursion";
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
                                    $ProductExprienceIconLanguageHeader['type']               = 'excursion';
                                    $ProductExprienceIconLanguageHeader->save();
                                }
                            }


                        }
                    }
                }

                // Expireance Icon Header end


                // Product boats 
                Productyachtrelatedboats::where(['product_id' => $product_id, 'type' => 'excursion'])->delete();
                if (isset($request->boat) && count($request->boat) > 0) {
                    if ($request->boat) {
                        foreach ($request->boat as $key => $value_boats) {
                            $Productyachtrelatedboats = new Productyachtrelatedboats();

                            $Productyachtrelatedboats['boat_id']    = $value_boats;
                            $Productyachtrelatedboats['product_id'] = $product_id;
                            $Productyachtrelatedboats['type']       = 'excursion';

                            $Productyachtrelatedboats->save();
                        }
                    }
                }


                // Opening Time heading start
                if (!empty($request->opening_time_heading)) {
                    MetaGlobalLanguage::where('meta_parent', 'excursion_opening_heading')->where('product_id',$product_id)->where('language_id',$lang_id)->delete();

                    foreach ($get_languages as $key => $value) {
                        if (!getDataFromDB('meta_global_language',['language_id'=>$value['id'],'meta_parent'=>'excursion_opening_heading','product_id' => $product_id],'row')) {    
                        
                            $MetaGlobalLanguage = new MetaGlobalLanguage();
                       
                            $MetaGlobalLanguage->meta_parent = 'excursion_opening_heading';
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
                    MetaGlobalLanguage::where('meta_parent', 'excursion_additional_heading')->where('language_id',$lang_id)->where('product_id',$product_id)->delete();

                    foreach ($get_languages as $key => $value) {
                        if (!getDataFromDB('meta_global_language',['language_id'=>$value['id'],'meta_parent'=>'excursion_additional_heading','product_id' => $product_id],'row')) { 
                            
                            $MetaGlobalLanguage = new MetaGlobalLanguage();
                        
                            $MetaGlobalLanguage->meta_parent = 'excursion_additional_heading';
                            $MetaGlobalLanguage->meta_title  = 'heading_title';
                            $MetaGlobalLanguage->title       = isset($request->additional_heading[$value['id']]) ?  $request->additional_heading[$value['id']] : $request->additional_heading[$lang_id];
                            $MetaGlobalLanguage->product_id  = $product_id;
                            $MetaGlobalLanguage->language_id = $value['id'];
                            $MetaGlobalLanguage->status      = 'Active';
                            $MetaGlobalLanguage->save();
                        }
                    }
                }

                ///faq_heading Heading
                if (!empty($request->faq_heading)) {
                    MetaGlobalLanguage::where('meta_parent', 'excursion_faq_heading')->where('language_id',$lang_id)->where('product_id',$product_id)->delete();

                    foreach ($get_languages as $key => $value) {
                        if (!getDataFromDB('meta_global_language',['language_id'=>$value['id'],'meta_parent'=>'excursion_faq_heading','product_id' => $product_id],'row')) { 
                            
                            $MetaGlobalLanguage = new MetaGlobalLanguage();
                        
                            $MetaGlobalLanguage->meta_parent = 'excursion_faq_heading';
                            $MetaGlobalLanguage->meta_title  = 'heading_title';
                            $MetaGlobalLanguage->title       = isset($request->faq_heading[$value['id']]) ?  $request->faq_heading[$value['id']] : $request->faq_heading[$lang_id];
                            $MetaGlobalLanguage->product_id  = $product_id;
                            $MetaGlobalLanguage->language_id = $value['id'];
                            $MetaGlobalLanguage->status      = 'Active';
                            $MetaGlobalLanguage->save();
                        }
                    }
                }

            return redirect()
                ->route('admin.excursion')
                ->withErrors([$status => $message]);
        }

        Session::forget('addcars');

        $get_higlights = [];

        $get_options = [];
        $get_add_info = [];
        $get_faqs = [];
        $data = [];

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => translate('No Record Found')]);
            }
            $id = checkDecrypt($id);
            $common['title'] = translate('Edit Product');
            $common['button'] = translate('Update');

            $get_product           = Product::where('id', $id)->first();
            $get_product_language  = ProductLanguage::where('product_id', $id)->get();
            $get_product_highlight = ProductHighlights::where('product_id', $id)->get();
            $get_product_tooltip   = ProductToolTip::where(['product_id' => $id, 'type' => "excursion"])->get();
            $get_product_option    = ProductOptions::with('get_product_option_details')
                ->where('product_id', $id)
                ->get();
            $get_product_faq                      = ProductFaqs::where('product_id', $id)->get();
            $get_product_voucher                  = ProductVoucher::where(['product_id' => $id, 'type' => "excursion"])->get();
            $get_product_site_adver               = ProductSiteAdvertisement::where('product_id', $id)->get();
            $get_product_images                   = ProductImages::where('product_id', $id)->get();
            $get_product_lodge                    = ProductLodge::where('product_id', $id)->get();
            $get_product_additional_info_language = ProductAdditionalInfoLanguage::where('product_id', $id)->get();
            $get_product_highlight_language       = ProductHighlightLanguage::where('product_id', $id)->get();
            $get_product_tooltip_language         = ProductToolTipLanguage::where(['product_id' => $id, 'type' => "excursion"])->get();
            $get_product_option_language          = ProductOptionLanguage::where('product_id', $id)->get();
            $get_product_faq_language             = ProductFaqLanguage::where('product_id', $id)->get();
            $get_product_site_adver_language      = ProductSiteAdvertisementLanguage::where('product_id', $id)->get();
            $get_product_voucher_language         = ProductVoucherLanguage::where(['product_id' => $id, 'type' => "excursion"])->get();
            $get_product_option_week_tour         = ProductOptionWeekTour::where('product_id', $id)->get();
            $get_product_option_period_pricing    = ProductOptionPeriodPricing::where('product_id', $id)->get();
            $get_product_option_tour_upgrade      = ProductOptionTourUpgrade::where(['product_id' => $id, 'type' => 'excursion'])->get();
            $get_product_option_group_percentage  = ProductOptionGroupPercentage::where('product_id', $id)->get();
            $get_product_group_percentage         = ProductGroupPercentage::where('product_id', $id)->first();
            if ($get_product_group_percentage == "") {
                $get_product_group_percentage = getTableColumn('product_group_percentage');
            }
            $get_product_group_percentage_details  = ProductGroupPercentageDetails::where(['product_id' => $id])->get();
            $get_product_group_percentage_language = ProductGroupPercentageLanguage::where('product_id', $id)->get();
            $get_product_lodge_language            = ProductLodgeLanguage::where('product_id', $id)->get();
            $get_product_option_details            = ProductOptionDetails::where('product_id', $id)->get();
            $get_product_category                  = ProductCategory::where('product_id', $id)->groupby('category')->get();
            $get_product_deafault_title            = DefaultToolTipTitle::where('type', 'excursion')->get()->toArray();
            $get_product_request_popup             = ProductRequestPopup::where(['product_id' => $id ,'type'=>'excursion'])->get();
            $get_product_request_popup_language    = ProductRequestPopupLanguage::where(['product_id' => $id ,'type'=>'excursion'])->get();

            $get_product_experience_icon           = ProductExprienceIcon::where(['product_id'=> $id,'type' => 'excursion','status'=>'Active'])->where('position_type','middel')->get();
            $get_product_experience_icon_language  = ProductExprienceIconLanguage::where(['product_id'=> $id,'type' => 'excursion'])->where('position_type','middel')->get();
            $experience_icon_heading               = MetaGlobalLanguage::where('meta_parent', 'middle_experience_heading')->where('product_id',$id)->get();
            //Ecpireance Icon HEader
                $get_product_experience_icon_upper          = ProductExprienceIcon::where(['product_id'=> $id,'type' => 'excursion','status'=>'Active'])->where('position_type','upper')->get();
                $get_product_experience_icon_language_upper = ProductExprienceIconLanguage::where(['product_id'=> $id,'type' => 'excursion'])->where('position_type','upper')->get();
                $experience_icon_upper_heading              = MetaGlobalLanguage::where('meta_parent', 'header_experience_heading')->where('product_id',$id)->get();
                $tour_option_heading              = MetaGlobalLanguage::where('meta_parent', 'tour_option_heading')->where('product_id',$id)->get();
                
            //Ecpireance Icon HEader
            $get_product_related_boats = Productyachtrelatedboats::where(['product_id' => $id, 'type' => 'excursion'])->get();

            $meta_global_language_description =  MetaGlobalLanguage::where('meta_title','excursion_description_title')->where('meta_parent','excursion_description')->where('product_id',$id)->get();


            //Heding Oprning Tme 
            $opening_time_heading               = MetaGlobalLanguage::where('meta_parent', 'excursion_opening_heading')->where('product_id',$id)->get();
            $additional_heading                 = MetaGlobalLanguage::where('meta_parent', 'excursion_additional_heading')->where('product_id',$id)->get();
            $faq_heading                        = MetaGlobalLanguage::where('meta_parent', 'excursion_faq_heading')->where('product_id',$id)->get();
            
            $get_product_tooltip_title_language = [];
            foreach ($get_product_deafault_title as $key => $value_de) {
                $get_default = ProductToolTipLanguage::where(['product_id' => $id, 'tooltip_title' => $value_de['default_title'], 'type' => "excursion"])
                    ->get()
                    ->toArray();

                $get_product_tooltip_title_language[] = $get_default;
            }

            foreach ($get_product_option as $k => $GPO) {
                $ProductPrivateTransferCars = ProductPrivateTransferCars::where(['product_id' => $id, 'product_option_id' => $GPO['id']])->get();
                foreach ($ProductPrivateTransferCars as $PPTC) {
                    $prkey = $k +1;
                    $data[$prkey][] = $PPTC['car_id'];
                }
            }
                          
           


            Session::put(['addcars' => $data]);

            $get_product_setting = ProductSetting::where('product_id', $id)->get();
            $get_product_additional_info = ProductAddtionalInfo::where('product_id', $id)->get();

            $get_timings = ProductTimings::where('product_id', $id)
                ->get()
                ->toArray();
                // $get_product['country']
            $categories = Category::select('categories.*', 'category_language.description as name');
            $categories = $categories
                ->orWhere(function ($query) use ($get_product) {
                    $query->where('categories.country', 'Like', '%' . $get_product['country'] . '%');
                    $query->orwhere('categories.country', null);
                });
            $categories =  $categories->where('categories.parent', 0)
                ->where('categories.status', 'Active')
                ->join('category_language', 'categories.id', '=', 'category_language.category_id')
                ->groupBy('categories.id')
                ->get();
                // die;

            if (!$get_product) {
                return back()->withErrors(['error' => translate('Something went wrong')]);
            }
        }

        // print_die($get_product_option->toArray());
        // print_die($meta_global_language_description->toArray());

        return view(
            'admin.product.excursion.addProduct',
            compact(
                'common',
                'get_product',
                'meta_global_language_description',
                'get_product_group_percentage_details',
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
                'get_product_option_details',
                'GPH',
                'get_supplier',
                'GPSD',
                'get_product_voucher_language',
                'get_product_group_percentage_language',
                'GPGP',
                'get_product_voucher',
                'GPV',
                'GPF',
                'get_product_option_week_tour',
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
                'GPGPD',
                'get_product_option_group_percentage',
                'get_product_group_percentage',
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
                'tour_option_heading',
                'PEI',
                'get_product_related_boats',
                'GYRB',
                'opening_time_heading',
                'additional_heading',
                'faq_heading',
                'get_boats',
                'lang_id',
            ),
        );
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
            ProductVoucherLanguage::where(['product_id' => $id, 'type' => "excursion"])->delete();
            ProductTimings::where('product_id', $id)->delete();
            ProductOptionLanguage::where('product_id', $id)->delete();
            ProductPrivateTransferCars::where('product_id', $id)->delete();
            ProductOptionWeekTour::where('product_id', $id)->delete();
            ProductOptionTourUpgrade::where('product_id', $id)->delete();
            ProductTourPriceDetails::where('product_id', $id)->delete();
            ProductTourRoom::where('product_id', $id)->delete();
            ProductOptionTaxServiceCharge::where('product_id', $id)->delete();
            ProductOptionDetails::where('product_id', $id)->delete();
            ProuductCustomerGroupDiscount::where(['product_id' => $id, 'type' => "excursion"])->delete();
            ProductFaqs::where('product_id', $id)->delete();
            ProductFaqLanguage::where('product_id', $id)->delete();
            ProductSiteAdvertisementLanguage::where('product_id', $id)->delete();
            ProductSiteAdvertisement::where('product_id', $id)->delete();
            ProductToolTip::where(['product_id' => $id, 'type' => "excursion"])->delete();
            ProductToolTipLanguage::where(['product_id' => $id, 'type' => "excursion"])->delete();
            ProductOptionGroupPercentage::where('product_id', $id)->delete();
            ProductOptionPrivateTourPrice::where('product_id', $id)->delete();

            ProductExprienceIcon::where(['product_id' => $id, 'type' => "excursion"])->delete();
            ProductExprienceIconLanguage::where(['product_id' => $id, 'type' => "excursion"])->delete();

            ProductRequestPopup::where(['product_id' => $id ,'type'=>'excursion'])->delete();
            ProductRequestPopupLanguage::where(['product_id' => $id ,'type'=>'excursion'])->delete();

            Productyachtrelatedboats::where(['product_id' => $id, 'type' => "excursion"])->delete();
            $status = 'success';
            $message = translate('Delete Successfully');
        }
        return back()->withErrors([$status => $message]);
    }


    // Duplicate Product 
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
            $get_product->status = 'Deactive';
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
            $ProductVoucher = ProductVoucher::where(['product_id' => $id, 'type' => "excursion"])->get();
            $ProductVoucher->each(function ($item, $key) use ($NewId, $id) {
                $Voucher             = $item->replicate();
                $Voucher->product_id = $NewId;
                $Voucher->save();

                $ProductVoucherLanguage = ProductVoucherLanguage::where(['product_id' => $id, 'voucher_id' => $item->id, 'type' => "excursion"])->get();
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


            // Product ProductAddtionalInfo 
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

                $ProductOptionTourUpgrade = ProductOptionTourUpgrade::where(['product_id' => $id, 'product_option_id' => $item->id])->get();
                $ProductOptionTourUpgrade->each(function ($item, $key) use ($NewId, $Options) {
                    $OptionTourUpgrade               = $item->replicate();
                    $OptionTourUpgrade->product_id   = $NewId;
                    $OptionTourUpgrade->product_option_id = $Options->id;
                    $OptionTourUpgrade->save();
                });


                $ProductOptionGroupPercentage = ProductOptionGroupPercentage::where(['product_id' => $id, 'product_option_id' => $item->id])->get();
                $ProductOptionGroupPercentage->each(function ($item, $key) use ($NewId, $Options) {
                    $OptionGroupPercentage               = $item->replicate();
                    $OptionGroupPercentage->product_id   = $NewId;
                    $OptionGroupPercentage->product_option_id = $Options->id;
                    $OptionGroupPercentage->save();
                });

                $ProductOptionPeriodPricing = ProductOptionPeriodPricing::where(['product_id' => $id, 'product_option_id' => $item->id])->get();
                $ProductOptionPeriodPricing->each(function ($item, $key) use ($NewId, $Options) {
                    $OptionPeriodPricing               = $item->replicate();
                    $OptionPeriodPricing->product_id   = $NewId;
                    $OptionPeriodPricing->product_option_id = $Options->id;
                    $OptionPeriodPricing->save();
                });

                $ProductPrivateTransferCars = ProductPrivateTransferCars::where(['product_id' => $id, 'product_option_id' => $item->id])->get();
                $ProductPrivateTransferCars->each(function ($item, $key) use ($NewId, $Options) {
                    $PrivateTransferCars               = $item->replicate();
                    $PrivateTransferCars->product_id   = $NewId;
                    $PrivateTransferCars->product_option_id = $Options->id;
                    $PrivateTransferCars->save();
                });


                $ProductOptionTaxServiceCharge = ProductOptionTaxServiceCharge::where(['product_id' => $id, 'product_option_id' => $item->id])->get();
                $ProductOptionTaxServiceCharge->each(function ($item, $key) use ($NewId, $Options) {
                    $OptionTaxServiceCharge               = $item->replicate();
                    $OptionTaxServiceCharge->product_id   = $NewId;
                    $OptionTaxServiceCharge->product_option_id = $Options->id;
                    $OptionTaxServiceCharge->save();
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

            // Product ProuductCustomerGroupDiscount 
            $ProuductCustomerGroupDiscount = ProuductCustomerGroupDiscount::where(['product_id' => $id, 'type' => "excursion"])->get();
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


            // Product ProductGroupPercentage 
            $ProductGroupPercentageDetails = ProductGroupPercentageDetails::where(['product_id' => $id])->get();
            $ProductGroupPercentageDetails->each(function ($item, $key) use ($NewId, $id) {
                $ProductGroupPercentageDetailsSave             = $item->replicate();
                $ProductGroupPercentageDetailsSave->product_id = $NewId;
                $ProductGroupPercentageDetailsSave->save();
            });

            $ProductGroupPercentage = ProductGroupPercentage::where(['product_id' => $id])->get();
            $ProductGroupPercentage->each(function ($item, $key) use ($NewId, $id) {
                $ProductGroupPercentageSave             = $item->replicate();
                $ProductGroupPercentageSave->product_id = $NewId;
                $ProductGroupPercentageSave->save();

                $ProductGroupPercentageLanguage = ProductGroupPercentageLanguage::where(['product_id' => $id, 'group_percentage_id' => $item->id])->get();
                $ProductGroupPercentageLanguage->each(function ($item, $key) use ($NewId, $ProductGroupPercentageSave) {
                    $ProductGroupPercentageLang                         = $item->replicate();
                    $ProductGroupPercentageLang->product_id             = $NewId;
                    $ProductGroupPercentageLang->group_percentage_id    = $ProductGroupPercentageSave->id;
                    $ProductGroupPercentageLang->save();
                });
            });


             // Product ProductExprienceIcon  Middel
                $ProductExprienceIcon = ProductExprienceIcon::where(['product_id' => $id,'type' => 'excursion'])->where('position_type','middel')->get();
                $ProductExprienceIcon->each(function ($item, $key) use ($NewId, $id) {
                    $ExpIcon             = $item->replicate();
                    $ExpIcon->product_id = $NewId;
                    $ExpIcon->save();

                    $ProductExprienceIconLanguage = ProductExprienceIconLanguage::where(['product_id' => $id, 'experience_icon_id' => $item->id])->where('position_type','middel')->get();
                    $ProductExprienceIconLanguage->each(function ($item, $key) use ($NewId, $ExpIcon) {
                        $ExpIconLanguage               = $item->replicate();
                        $ExpIconLanguage->product_id   = $NewId;
                        $ExpIconLanguage->experience_icon_id = $ExpIcon->id;
                        $ExpIconLanguage->save();
                    });
                });
                $MetaGlobalLanguage = MetaGlobalLanguage::where(['product_id' => $id])->where('meta_parent', 'middle_experience_heading')->get();
                $MetaGlobalLanguage->each(function ($item, $key) use ($NewId, $id) {
                    $ProductGroupPercentageDetailsSave             = $item->replicate();
                    $ProductGroupPercentageDetailsSave->product_id = $NewId;
                    $ProductGroupPercentageDetailsSave->save();
                });


            // Product ProductExprienceIcon Header
                $ProductExprienceIcon = ProductExprienceIcon::where(['product_id' => $id,'type' => 'excursion'])->where('position_type','upper')->get();
                $ProductExprienceIcon->each(function ($item, $key) use ($NewId, $id) {
                    $ExpIcon             = $item->replicate();
                    $ExpIcon->product_id = $NewId;
                    $ExpIcon->save();

                    $ProductExprienceIconLanguage = ProductExprienceIconLanguage::where(['product_id' => $id, 'experience_icon_id' => $item->id])->where('position_type','upper')->get();
                    $ProductExprienceIconLanguage->each(function ($item, $key) use ($NewId, $ExpIcon) {
                        $ExpIconLanguage               = $item->replicate();
                        $ExpIconLanguage->product_id   = $NewId;
                        $ExpIconLanguage->experience_icon_id = $ExpIcon->id;
                        $ExpIconLanguage->save();
                    });

                });
                $MetaGlobalLanguage = MetaGlobalLanguage::where(['product_id' => $id])->where('meta_parent', 'header_experience_heading')->get();
                $MetaGlobalLanguage->each(function ($item, $key) use ($NewId, $id) {
                    $ProductGroupPercentageDetailsSave             = $item->replicate();
                    $ProductGroupPercentageDetailsSave->product_id = $NewId;
                    $ProductGroupPercentageDetailsSave->save();
                });


                // // Product Productyachtrelatedboats 
                $Productyachtrelatedboats = Productyachtrelatedboats::where(['product_id' => $id, 'type' => 'excursion'])->get();
                $Productyachtrelatedboats->each(function ($item, $key) use ($NewId) {
                    $Setting             = $item->replicate();
                    $Setting->product_id = $NewId;
                    $Setting->save();
                });

            


        }
        return redirect()->back()->with(['success' => "Product Duplicate Succssfully..."]);
    }

    public function get_category_by_country(Request $request)
    {
        $country     = $request->country;
        $categoryArr = isset($request->data) ? $request->data : '';
        $selectedCat = $request->selectedCat;
        if (isset($request->array)) {
            $array = $request->array;
        } else {
            $array = '';
        }
        $data = Category::select('categories.*', 'category_language.description as name');
        $data = $data
            ->orWhere(function ($query) use ($country) {
                $query->where('categories.country', 'Like', '%' . $country . '%');
                $query->orwhere('categories.country', null);
            });
        if ($categoryArr != '') {
            $data = $data->whereNotIn('categories.id', $categoryArr);
        }
        $data =  $data->where('categories.parent', 0)
                ->where('categories.status', 'Active')
                ->join('category_language', 'categories.id', '=', 'category_language.category_id')
                ->groupBy('categories.id')
                ->get();
        return View::make('admin.append_page.select', compact('data', 'selectedCat'))->render();
        // return $category;
    }

    public function get_subcategory_by_category(Request $request)
    {
        $category= $request->category;
        $country  = $request->country;
        $selectedCat = $request->selectedSubCategory;
        if (isset($request->array)) {
            $array = $request->array;
        } else {
            $array = '';
        }
        $subacategory = Category::select('categories.*', 'category_language.description as name')
            ->where('categories.parent', $category)
            ->join('category_language', 'categories.id', '=', 'category_language.category_id')
            ->groupBy('categories.id')
            ->get();

        


        $get_category = Category::select('categories.*', 'category_language.description as name');
        $get_category = $get_category->orWhere(function ($query) use ($country) {
                $query->where('categories.country', 'Like', '%' . $country . '%');
                $query->orwhere('categories.country', null);
            });
        $get_category = $get_category->where('categories.id','!=',$category)->where('categories.parent', 0)
                ->join('category_language', 'categories.id', '=', 'category_language.category_id')
                ->groupBy('categories.id')
                ->get();
        
        
        $data = $subacategory;
        $arr = [
            'view' => View::make('admin.append_page.select', compact('data', 'selectedCat', 'array'))->render(),
            'category' => $get_category,
        ];

        return $arr;
    }

    public function get_car_list(Request $request)
    {
        // dd(Session::get('addcars'));
        $data = $request->count ;
        $optionid = $request->optionid;
        $alreadyAdded = [];
      
        if (Session::has('addcars.' . $data)) {
            $alreadyAdded = Session::get('addcars.' . $data);
        }

        $car = CarDetails::select('car_details.*', 'car_details_language.title')
            ->orderBy('car_details.id', 'desc')
            ->where(['car_details.is_delete' => 0])
            ->where(ConditionQuery())
            ->join('car_details_language', 'car_details.id', '=', 'car_details_language.car_details_id')
            ->groupBy('car_details.id')
            ->get();

        return View::make('admin.product.excursion._car_list', compact('data', 'car', 'alreadyAdded','optionid'))->render();
    }

    public function add_car_session(Request $request)
    {
        if (Session::has('addcars')) {
            $session = Session::get('addcars');
            foreach ($session as $key => $CH) {
                foreach ($CH as $k => $val) {
                    $data[$key][] = $val;
                }
            }
        }

        if (isset($request->car_check)) {
            foreach ($request->car_check as $key => $CH) {
                if (Session::has('addcars.' . $key)) {
                    $session = Session::get('addcars');
                    unset($session[$key]);
                    Session::put(['addcars' => $session]);
                }
                $data[$key] = $request->car_check[$key];
            }
        } else {
            unset($data[$request->CarOptionId]);
            Session::put(['addcars' => $data]);
        }
        Session::put(['addcars' => $data]);
        return $data;
        
    }
}
