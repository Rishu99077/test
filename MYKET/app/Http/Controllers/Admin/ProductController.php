<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\ProductDescription;
use App\Models\ProductLocation;
use App\Models\Categories;
use App\Models\ProductTransportation;
use App\Models\Transportation;
use App\Models\TransportationDescription;
use App\Models\ProductFood;
use App\Models\Gear;
use App\Models\Countries;
use App\Models\States;
use App\Models\Cities;
use App\Models\User;
use App\Models\Media;
use App\Models\Inclusion;
use App\Models\ProductInclusion;
use App\Models\ProductFoodDrink;
use App\Models\ProductHighlight;
use App\Models\ProductHighlightDescription;
use App\Models\ProductFoodDescription;
use App\Models\Restriction;
use App\Models\ProductRestriction;
use App\Models\ProductInformation;
use App\Models\ProductInformationDescription;
use App\Models\ProductOption;
use App\Models\ProductImages;
use App\Models\AddOn;
use App\Models\ProductOptionDescription;
use App\Models\ProductOptionPricing;
use App\Models\ProductOptionPricingTiers;
use App\Models\ProductOptionPricingDetails;
use App\Models\ProductOptionAddOn;
use App\Models\ProductOptionAddOnTiers;
use App\Models\ProductOptionPricingDescription;
use App\Models\ProductOptionAvailability;
use App\Models\ProductOptionAvailabilityDescription;
use App\Models\ProductOptionDiscount;
use App\Models\ProductType;
use App\Models\ProductAboutActivity;
use App\Models\ProductAboutActivityDescription;
use App\Models\Interests;
use App\Models\SideBanner;
use App\Models\SideBannerDescription;
use App\Models\PartnerProductReason;
use App\Models\TopAttraction;
use App\Models\Admin;
use App\Models\MetaData;
use Image;

use Illuminate\Support\Facades\View;


class ProductController extends Controller
{

    // All Products Listing
    public function get_products(Request $request)
    {

        $common          = array();
        $common['title'] = "Products";
        Session::put("TopMenu", "Products");
        Session::put("SubMenu", "Products");
        $get_session_language  = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];



        // Categaory Array
        $get_category = Categories::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
            ->get();

        $categories = array();
        if (!empty($get_category)) {
            foreach ($get_category as $key => $value) {
                $row  = getLanguageData('category_descriptions', $language_id, $value['id'], 'category_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $categories[] = $row;
            }
        }

        // Partner Array
        $get_partner = User::orderBy('id', 'desc')->where(['status' => 'Active', 'user_type' => "Partner"])->whereNull('is_delete')
            ->get();



        $get_products = Product::select('products.*', 'users.email as partner_email')
            ->where('products.is_delete', null)
            ->leftjoin('products_description', 'products.id', '=', 'products_description.product_id')
            ->leftjoin('users', 'products.partner_id', '=', 'users.id')
            ->groupBy('products.id')
            ->orderBy('products.id', 'desc')->orderBy('products.id');
        if ($request->ajax()) {
            $page = $request->page;

            if (isset($request->product_name)) {
                $get_product = $get_products->where('products_description.title', 'like', '%' . $request->product_name . '%');
            }
            if (isset($request->categories)) {
                $get_product = $get_products->where('products.category', $request->categories);
            }

            if (isset($request->approved)) {
                $get_product = $get_products->where('products.is_approved', $request->approved);
            }
            if (isset($request->status)) {
                $get_product = $get_products->where('products.status', $request->status);
            }
            if (isset($request->partner)) {
                $get_product = $get_products->where(['products.partner_id' => $request->partner, 'added_by' => 'partner']);
            }
            $get_products = $get_products->offset($page * 10)->paginate(10);
        } else {
            $get_products = $get_products->paginate(10);
        }

        $products = array();
        if (!empty($get_products)) {
            foreach ($get_products as $key => $value) {
                $category_desc  = getLanguageData('category_descriptions', $language_id, $value['category'], 'category_id');
                $product_desc  = getLanguageData('products_description', $language_id, $value['id'], 'product_id');

                $ProductLocation              = ProductLocation::where(['product_id' => $value['id']])->get();
                $ProductLocationArr           = [];
                foreach ($ProductLocation as $key => $PL) {
                    $get_location         = [];
                    $get_location       = explode(",", $PL['address']);
                    $ProductLocationArr[] = $get_location[0];
                }
                $row['location'] = implode(",", $ProductLocationArr);

                $row['id']                 = $value['id'];
                $row['partner_id']         = $value['partner_id'];
                $row['category_title']     = $category_desc['title'];
                $row['slug']               = $value['slug'];
                $row['status']             = $value['status'];
                $row['duration_text']      = $value['duration_text'];
                $row['reference_code']     = $value['reference_code'];
                $row['activity_text']      = $value['activity_text'];
                $row['likely_to_sell_out'] = $value['likely_to_sell_out'];
                $row['added_by']           = $value['added_by'];
                $row['is_approved']        = $value['is_approved'];
                $row['partner_email']      = $value['partner_email'];
                $row['product_title']      = $product_desc['title'];
                $row['trip_details']       = ucfirst(str_replace('_', ' ', $value['type']));
                $ProductImages             = ProductImages::where(['product_id' => $value['id']])->first();

                $row['message']              = "";
                $countProductOption = ProductOption::where(['product_id' => $value['id'], 'is_delete' => null])->count();
                $countProductOptionPricingDetails = ProductOptionPricingDetails::where(['product_id' => $value['id']])->count();
                $countProductProductOptionAvailability = ProductOptionAvailability::where(['product_id' => $value['id']])->whereDate('valid_to', '>=', date('Y-m-d'))->count();

                if ($countProductOption == 0 || $countProductOptionPricingDetails == 0 || $countProductProductOptionAvailability == 0) {
                    $row['message'] = "This product option ,availablity & pricing is incomplete.";
                }

                $file = 'dummyproduct.png';
                if ($value['cover_image'] != "") {
                    $file = $value['cover_image'];
                } else {
                    if ($ProductImages) {
                        $file = $ProductImages->image;
                    }
                }
                $row['user_status'] = 1;
                if ($value['added_by'] == "partner") {
                    $User = User::find($value['partner_id']);
                    if ($User) {
                        if ($User->status == "Active") {
                            $row['user_status'] = 1;
                        } else {
                            $row['user_status'] = 0;
                        }
                    } else {
                        $row['user_status'] = 0;
                    }
                }
                $row['image']          = $file;
                $products[]             = $row;
            }
        }


        if ($request->ajax()) {
            return view('admin.products._listing', compact('common', 'get_products', 'products', 'categories', 'get_partner'));
        } else {
            return view('admin.products.index', compact('common', 'get_products', 'products', 'categories', 'get_partner'));
        }
    }

    // Add Or Edit product
    public function add_product(Request $request, $tab = "")
    {

        $common           = array();
        $common['title']  = translate("Products");
        $common['button'] = translate("Save");
        Session::put("TopMenu", "Products");
        Session::put("SubMenu", "Product");

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];


        // Categaory Array
        $get_category = Categories::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
            ->get();

        $categories = array();
        if (!empty($get_category)) {
            foreach ($get_category as $key => $value) {
                $row  = getLanguageData('category_descriptions', $language_id, $value['id'], 'category_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $categories[] = $row;
            }
        }

        // Gear Array
        $get_gears = Gear::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
            ->get();

        $Gears = [];
        if (!empty($get_gears)) {
            foreach ($get_gears as $key => $value) {
                $row  = getLanguageData('gear_descriptions', $language_id, $value['id'], 'gear_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $Gears[] = $row;
            }
        }



        // Media Array
        $get_media = Media::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
            ->paginate(config('adminconfig.records_per_page'));

        $Media = [];
        if (!empty($get_media)) {
            foreach ($get_media as $key => $value) {
                $row  = getLanguageData('media_descriptions', $language_id, $value['id'], 'media_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $Media[] = $row;
            }
        }


        // Inclusion Array
        $get_inclusion = Inclusion::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
            ->get();

        $Inclusion = [];
        if (!empty($get_inclusion)) {
            foreach ($get_inclusion as $key => $value) {
                $row  = getLanguageData('inclusion_descriptions', $language_id, $value['id'], 'inclusion_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $Inclusion[] = $row;
            }
        }

        // Restriction Array
        $get_restriction = Restriction::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
            ->get();

        $Restriction = [];
        if (!empty($get_restriction)) {
            foreach ($get_restriction as $key => $value) {
                $row  = getLanguageData('restriction_descriptions', $language_id, $value['id'], 'restriction_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $row['image']  = $value['image'];
                $Restriction[] = $row;
            }
        }

        // Transporation Array
        $get_transportation = Transportation::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
            ->get();

        $Transportation = [];
        if (!empty($get_transportation)) {
            foreach ($get_transportation as $key => $value) {
                $row  = getLanguageData('transportation_description', $language_id, $value['id'], 'transportation_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $Transportation[] = $row;
            }
        }


        // Add On Array
        $get_add_on = AddOn::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
            ->get();

        $AddOn = [];
        if (!empty($get_add_on)) {
            foreach ($get_add_on as $key => $value) {
                $row  = getLanguageData('add_on_description', $language_id, $value['id'], 'add_on_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $AddOn[] = $row;
            }
        }


        // Product Type Array
        $get_product_type = ProductType::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
            ->get();

        $ProductType = [];
        if (!empty($get_product_type)) {
            foreach ($get_product_type as $key => $value) {
                $row  = getLanguageData('product_type_description', $language_id, $value['id'], 'product_type_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $ProductType[] = $row;
            }
        }

        // Interest
        $get_interest = Interests::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
            ->get();

        $interests = array();
        if (!empty($get_interest)) {
            foreach ($get_interest as $key => $value) {
                $row  = getLanguageData('interest_descriptions', $language_id, $value['id'], 'interest_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $interests[] = $row;
            }
        }


        // SIdeBanner Array
        $get_sidebanner = SideBanner::orderBy('id', 'desc')->where(['status' => 'Active'])->get();

        $banners = array();
        if (!empty($get_sidebanner)) {
            foreach ($get_sidebanner as $key => $value) {
                $row  = getLanguageData('side_banner_description', $language_id, $value['id'], 'side_banner_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $banners[] = $row;
            }
        }


        // Top Attraction
        $get_top_attraction = TopAttraction::orderBy('id', 'desc')->where(['status' => 'Active', 'is_delete' => null])->get();

        $topAttraction = array();
        if (!empty($get_top_attraction)) {
            foreach ($get_top_attraction as $key => $value) {
                $row  = getLanguageData('top_attraction_description', $language_id, $value['id'], 'attraction_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $topAttraction[] = $row;
            }
        }
        // echo "<pre>"; 
        // print_r($banners);
        // echo "</pre>";die();

        $Countries = Countries::where(['is_delete' => null])->get();
        $States = [];
        $Cities = [];
        if ($request->isMethod('post')) {

            $req_fields = array();
            if ($request->step == "one") {
                $req_fields['product_type']   = "required";
            }

            if ($request->step == "two") {
                $req_fields['title']              = "required";
                $req_fields['refrence_code']      = "required";
                $req_fields['category']           = "required";
                $req_fields['description']        = "required";
                $req_fields['product_title_type'] = "required";
                $req_fields['country']            = "required";
                $req_fields['state']              = "required";
            }

            if ($request->step == "three") {
                $req_fields['set_address']   = "required";
            }

            if ($request->step == "seven") {
                if ($request->gear_media == "yes") {
                    $gear_media = 0;
                    if (isset($request->gears) || isset($request->media)) {
                        $gear_media = 1;
                    }
                    if ($gear_media == 0) {
                        $req_fields['gears']   = "required";
                    }
                }
                $req_fields['inclusion']   = "required";
                $req_fields['highlight.*'] = "required";
            }


            if ($request->step == "nine") {

                $req_fields['information_title.*']        = "required";
                $req_fields['information_decscription.*'] = "required";
            }

            if ($request->step == "about") {
                $req_fields['about_activity_title.*']        = "required";
            }

            if ($request->step == "create_option") {
                if ($request->option_type) {
                    if ($request->option_type == 'single') {
                        $req_fields['create_option']        = "required";
                    }
                } else {

                    $Product  = Product::find($request->tourId);
                    if ($Product->option_type  == "single") {
                        $req_fields['create_option']        = "required";
                    }
                }
            }

            if ($request->step == "option_setup") {

                $req_fields['option_title']       = "required";
                $req_fields['reference_code']     = "required";
                $req_fields['option_description'] = "required";
                $req_fields['cut_off_time']       = "required";


                if (isset($request->guide_headphone)) {
                    $req_fields['guide_headphone_language'] = "required";
                }

                if (isset($request->information_booklet)) {
                    $req_fields['information_booklet_language'] = "required";
                }

                if ($request->existing_line == "yes") {
                    $req_fields['existing_line_type'] = "required";
                }

                if (isset($request->time_length)) {
                    if ($request->time_length == "duration") {
                        $req_fields['duration_time'] = "required";
                        $req_fields['duration_time_type'] = "required";
                    } else {
                        $req_fields['validity_type'] = "required";

                        if (isset($request->validity_type)) {

                            if ($request->validity_type != "time_selected") {
                                $req_fields['validity_time'] = "required";
                                $req_fields['validity_time_type'] = "required";
                            }
                        }
                    }
                }
            }

            if ($request->step == "option_pricing") {
                if ($request->pricing_type == 'person') {

                    $req_fields['minimum_participant'] = "required";
                    $req_fields['price_name']          = "required";
                } else {
                    $req_fields['minimum_group_participant'] = "required";
                    $req_fields['price_group_name']          = "required";
                }
            }


            if ($request->step == "availability") {

                // $req_fields['availability_name'] = "required";/
                $req_fields['valid_from']        = "required";
                $req_fields['valid_to']          = "required";
            }



            $errormsg = [
                "product_type"                 => translate("Product Type"),
                "title"                        => translate("Title"),
                "refrence_code"                => translate("Refrence Code"),
                "set_address"                  => translate("Location"),
                "category"                     => translate("Category"),
                "description"                  => translate("Description"),
                "gears"                        => translate("Gears or Media"),
                "media"                        => translate("Media"),
                "inclusion"                    => translate("Inclusion"),
                "highlight.*"                  => translate("Highlight"),
                "information_title.*"          => translate("Information title"),
                "about_activity_title.*"       => translate("About Activity title"),
                "information_decscription.*"   => translate("Information description"),
                "option_title"                 => translate("Option Title"),
                "reference_code"               => translate("Reference Code"),
                "option_description"           => translate("Option Description"),
                "guide_headphone_language"     => translate("Language"),
                "information_booklet_language" => translate("Language"),
                "existing_line_type"           => translate("Existing line type"),
                "duration_time"                => translate("Duration time & type"),
                "duration_time_type"           => translate("Duration time & type"),
                "validity_type"                => translate("Validity type"),
                "validity_time"                => translate("Validity time & type"),
                "validity_time_type"           => translate("Validity time & type"),
                "cut_off_time"                 => translate("Cut-off time"),
                "minimum_participant"          => translate("Minimum Participant"),
                "minimum_group_participant"    => translate("Minimum Participant"),
                "price_name"                   => translate("Price Title"),
                "price_group_name"             => translate("Price Title"),
                "availability_name"            => translate("Title"),
                "valid_from"                   => translate("From Date"),
                "valid_to"                     => translate("To Date"),
                "product_title_type"           => translate("Product Type"),
                "cover_image"                  => translate("Cover Image"),
                "create_option"                => translate("Create Option"),
                "country"                      => translate("Country"),
                "state"                        => translate("State"),
                "city"                         => translate("City"),

            ];

            $validation = Validator::make(
                $request->all(),
                $req_fields,
                [
                    'required' => 'The :attribute field is required.',
                ],
                $errormsg
            );

            $productID = "";
            if ($validation->fails()) {
                return response()->json(['error' => array_reverse($validation->getMessageBag()->toArray())]);
            }

            // Step One
            if ($request->step == "one") {
                $product             = new Product();
                $product->type       = $request->product_type;
                $product->partner_id = 1;
                $product->slug       = createSlug('products', "No title");
                $product->save();
                $output['id'] = $product->id;
                $productID    = $product->id;
            } else {
                $productID = $request->tourId;
            }


            $Product  = Product::find($productID);


            // Step Two
            if ($request->step == "two") {
                $Product->category             = $request->category;
                $Product->country              = $request->country;
                $Product->state                = $request->state;
                $Product->city                 = $request->city;
                // $Product->is_approved          = $request->is_approved;
                $Product->reference_code       = $request->refrence_code;
                $Product->duration_text        = $request->duration_text;
                $Product->activity_text        = $request->activity_text;
                $Product->not_on_sale          = $request->note_on_sale_date;
                $Product->option_type          = $request->product_option_type;
                $Product->product_type         = isset($request->product_title_type) ?  implode(",", $request->product_title_type) : '';
                $Product->top_attraction       = isset($request->top_attraction) ?  implode(",", $request->top_attraction) : '';
                $Product->interest             = isset($request->interest) ? implode(",", $request->interest) : "";
                $Product->recommended_tour     = isset($request->recommended_tour) ? $request->recommended_tour : 'no';
                $Product->awaits_for_you       = isset($request->awaits_for_you) ? $request->awaits_for_you : 'no';
                $Product->cultural_experiences = isset($request->cultural_experiences) ? $request->cultural_experiences : 'no';
                $Product->cultural_attractions = isset($request->cultural_attractions) ? $request->cultural_attractions : 'no';



                $ProductDescription            = ProductDescription::where(["product_id" => $productID, 'language_id' => $language_id])->first();
                if (!$ProductDescription) {
                    $ProductDescription              = new ProductDescription();
                    $Product->slug = createSlug('products', $request->title);
                }
                if (isset($request->title)) {
                    $ProductDescription->title       = $request->title;
                    $ProductDescription->description = $request->description;
                    $ProductDescription->language_id = $language_id;
                    $ProductDescription->product_id  = $productID;



                    $ProductDescription->save();
                }
                $ProductOptionPricingCount = ProductOptionPricing::where('product_id', $productID)->count();
                if ($ProductOptionPricingCount > 0) {
                    $Product->status = $request->product_status;
                } else {
                    $Product->status = 'Draft';
                }


                $Product->save();
            }

            // Step option Type
            if ($request->step == 'option_type') {
                $Product  = Product::find($request->tourId);
                $Product->option_type          = $request->value;
                $Product->save();
            }


            // Step Three

            if ($request->step == "three") {

                $Get_ProductLocation = ProductLocation::where('product_id', $productID)->get();
                if (isset($request->location_id)) {
                    foreach ($Get_ProductLocation as $key => $Get_ProductLocation_delete) {
                        if (!in_array($Get_ProductLocation_delete['id'], $request->location_id)) {
                            ProductLocation::where('id', $Get_ProductLocation_delete['id'])->delete();
                        }
                    }
                } else {
                    ProductLocation::where('product_id', $productID)->delete();
                }




                if (isset($request->set_address)) {
                    foreach ($request->set_address as $Addkey => $add) {

                        if ($request->location_id[$Addkey] != "") {
                            $ProductLocation             = ProductLocation::find($request->location_id[$Addkey]);
                        } else {
                            $ProductLocation             = new ProductLocation();
                        }

                        $ProductLocation->address    = $add;
                        $ProductLocation->product_id = $productID;
                        $ProductLocation->country    = $request->country[$Addkey];
                        $ProductLocation->state      = $request->state[$Addkey];
                        $ProductLocation->city       = $request->city[$Addkey];
                        $ProductLocation->latitude   = $request->address_latitude[$Addkey];
                        $ProductLocation->longitude  = $request->address_longitude[$Addkey];
                        $ProductLocation->save();
                    }
                }
            }


            // step Four
            if ($request->step == "four") {
                $Product->transportation = $request->transportation;
            }

            // step Five
            if ($request->step == "five") {
                $Product->interact                     = $request->interact;
                $Product->customers_sleep_overnight    = $request->customers_sleep_overnight;
                $Product->accommodation_included_price = $request->accommodation_included_price;
            }

            // step Six
            if ($request->step == "six") {
                $Product->food_drink = $request->food_drink;
            }

            // step Seven
            if ($request->step == "seven") {
                ProductInclusion::where('product_id', $productID)->delete();
                $Product->gear_media = $request->gear_media;
                if ($request->gear_media == "yes") {
                    if (isset($request->gears)) {
                        foreach ($request->gears as $key => $G) {
                            $ProductInclusion             = new ProductInclusion();
                            $ProductInclusion->type       = "gear";
                            $ProductInclusion->product_id = $productID;
                            $ProductInclusion->type_id    = $G;
                            $ProductInclusion->save();
                        }
                    }
                    if (isset($request->media)) {

                        foreach ($request->media as $key => $M) {
                            $ProductInclusion             = new ProductInclusion();
                            $ProductInclusion->type       = "media";
                            $ProductInclusion->product_id = $productID;
                            $ProductInclusion->type_id    = $M;
                            $ProductInclusion->save();
                        }
                    }
                }

                foreach ($request->inclusion as $key => $I) {
                    $ProductInclusion             = new ProductInclusion();
                    $ProductInclusion->type       = "inclusion";
                    $ProductInclusion->product_id = $productID;
                    $ProductInclusion->type_id    = $I;
                    $ProductInclusion->save();
                }



                $Get_ProductHighlight = ProductHighlight::where('product_id', $productID)->get();
                if (isset($request->highlight_id)) {
                    foreach ($Get_ProductHighlight as $key => $Get_ProductHighlight_delete) {
                        if (!in_array($Get_ProductHighlight_delete['id'], $request->highlight_id)) {
                            ProductHighlight::where('id', $Get_ProductHighlight_delete['id'])->delete();
                            ProductHighlightDescription::where('id', $Get_ProductHighlight_delete['id'])->delete();
                        }
                    }
                } else {
                    ProductHighlight::where('product_id', $productID)->delete();
                    ProductHighlightDescription::where('product_id', $productID)->delete();
                }


                foreach ($request->highlight as $key => $H) {
                    if ($H != "") {

                        if ($request->highlight_id[$key] != "") {
                            $ProductHighlight             = ProductHighlight::find($request->highlight_id[$key]);
                        } else {
                            $ProductHighlight             = new ProductHighlight();
                        }

                        $ProductHighlight->product_id = $productID;
                        $ProductHighlight->save();

                        $ProductHighlightDescription = ProductHighlightDescription::where(['highlight_id' => $ProductHighlight->id, 'language_id' => $language_id])->first();
                        // description
                        if (!$ProductHighlightDescription) {
                            $ProductHighlightDescription = new ProductHighlightDescription();
                        }
                        $ProductHighlightDescription->title = $H;
                        $ProductHighlightDescription->highlight_id = $ProductHighlight->id;
                        $ProductHighlightDescription->language_id = $language_id;
                        $ProductHighlightDescription->save();
                    }
                }


                $Get_ProductRestriction = ProductRestriction::where('product_id', $productID)->get();
                if (isset($request->restriction)) {
                    foreach ($Get_ProductRestriction as $key => $Get_ProductRestriction_delete) {
                        if (!in_array($Get_ProductRestriction_delete['id'], $request->restriction)) {
                            ProductRestriction::where('id', $Get_ProductRestriction_delete['id'])->delete();
                        }
                    }
                } else {
                    ProductRestriction::where('product_id', $productID)->delete();
                }
                if (isset($request->restriction)) {
                    foreach ($request->restriction as $key => $R) {
                        if ($H != "") {
                            $ProductRestriction                 = new ProductRestriction();
                            $ProductRestriction->product_id     = $productID;
                            $ProductRestriction->restriction_id = $R;
                            $ProductRestriction->save();
                        }
                    }
                }
            }
            // step Eight
            if ($request->step == "eight") {
                if (isset($request->keyword)) {
                    $ProductDescription = ProductDescription::where(["product_id" => $productID, 'language_id' => $language_id])->first();
                    if ($ProductDescription) {
                        $ProductDescription->keyword = $request->keyword;
                    } else {
                        $ProductDescription = new ProductDescription();
                        $ProductDescription->product_id  = $productID;
                        $ProductDescription->language_id  = $language_id;
                        $ProductDescription->keyword = $request->keyword;
                    }
                    $ProductDescription->save();
                }
            }

            // step Nine
            if ($request->step == "nine") {

                $Get_ProductInformation = ProductInformation::where('product_id', $productID)->get();
                if (isset($request->information_id)) {
                    foreach ($Get_ProductInformation as $key => $Get_ProductInformation_delete) {
                        if (!in_array($Get_ProductInformation_delete['id'], $request->information_id)) {
                            ProductInformation::where('id', $Get_ProductInformation_delete['id'])->delete();
                            ProductInformationDescription::where('information_id', $Get_ProductInformation_delete['id'])->delete();
                        }
                    }
                } else {
                    ProductInformation::where('product_id', $productID)->delete();
                }


                foreach ($request->information_title as $ITkey => $IT) {
                    if ($IT != "") {

                        if ($request->information_id[$ITkey] != "") {
                            $ProductInformation             = ProductInformation::find($request->information_id[$ITkey]);
                            $ProductInformationDescription                 = ProductInformationDescription::where(['information_id' => $request->information_id[$ITkey]])->first();
                        } else {
                            $ProductInformation             = new ProductInformation();
                            $ProductInformationDescription             = new ProductInformationDescription();
                        }

                        $ProductInformation->product_id = $productID;
                        $ProductInformation->save();


                        // description

                        $ProductInformationDescription->title          = $IT;
                        $ProductInformationDescription->description    = $request->information_decscription[$ITkey];
                        $ProductInformationDescription->information_id = $ProductInformation->id;
                        $ProductInformationDescription->language_id    = $language_id;
                        $ProductInformationDescription->save();
                    }
                }
            }

            // step Ten
            if ($request->step == "ten") {

                $ProductDescription            = ProductDescription::where(["product_id" => $productID, 'language_id' => $language_id])->first();
                if ($ProductDescription) {
                    $ProductDescription->image_text = $request->image_text;
                } else {
                    $ProductDescription = new ProductDescription();
                    $ProductDescription->product_id  = $productID;
                    $ProductDescription->language_id  = $language_id;
                    $ProductDescription->image_text = $request->image_text;
                }
                $ProductDescription->save();



                $Get_ProductImages = ProductImages::where('product_id', $productID)->get();
                if (isset($request->image_id)) {
                    foreach ($Get_ProductImages as $key => $Get_ProductImages_delete) {
                        if (!in_array($Get_ProductImages_delete['id'], $request->image_id)) {
                            ProductImages::where('id', $Get_ProductImages_delete['id'])->delete();
                        }
                    }
                } else {
                    ProductImages::where('product_id', $productID)->delete();
                }


                if ($request->hasFile('cover_image')) {

                    $Product = Product::find($productID);
                    if ($Product) {
                        $file        = $request->file('cover_image');

                        $random_no          = uniqid();
                        $mime_type       = $file->getMimeType();
                        $ext             = $file->getClientOriginalExtension();
                        $new_name        = $random_no . '.' . $ext;


                        $imgFile         = Image::make($file->path());
                        $height          = $imgFile->height();
                        $width           = $imgFile->width();
                        $imgFile->resize(1500, 700, function ($constraint) {
                            $constraint->aspectRatio();
                        });

                        $destinationPath = public_path('uploads/products');
                        $imgFile->save($destinationPath . '/' . $new_name);
                        // $file->move($destinationPath, $new_name);

                        $Product->cover_image = $new_name;
                        thumbnail_images($file, $new_name, 730, 487);
                    }
                }


                if ($request->hasFile('files')) {

                    $imges        = $request->file('files');

                    foreach ($imges as $key => $file) {
                        $random_no  = uniqid();
                        $mime_type       = $file->getMimeType();
                        $ext             = $file->getClientOriginalExtension();
                        $new_name        = $random_no . '.' . $ext;



                        $imgFile         = Image::make($file->path());
                        $height          = $imgFile->height();
                        $width           = $imgFile->width();
                        $imgFile->resize(730, 487, function ($constraint) {
                            $constraint->aspectRatio();
                        });

                        $destinationPath = public_path('uploads/products');
                        $imgFile->save($destinationPath . '/' . $new_name);

                        // $file->move($destinationPath, $new_name);
                        $ProductImages             = new ProductImages();
                        $ProductImages->image      = $new_name;
                        $ProductImages->product_id = $productID;
                        $ProductImages->save();
                        if ($key == 0) {
                            thumbnail_images($file, $new_name, 310, 180);
                        }
                    }
                }
            }

            // // step About Activity
            if ($request->step == "about") {

                $Get_ProductAboutActivity = ProductAboutActivity::where('product_id', $productID)->get();
                if (isset($request->about_activity_id)) {
                    foreach ($Get_ProductAboutActivity as $key => $Get_ProductAboutActivity_delete) {
                        if (!in_array($Get_ProductAboutActivity_delete['id'], $request->about_activity_id)) {
                            ProductAboutActivity::where('id', $Get_ProductAboutActivity_delete['id'])->delete();
                            ProductAboutActivityDescription::where('about_activity_id', $Get_ProductAboutActivity_delete['id'])->delete();
                        }
                    }
                } else {
                    ProductAboutActivity::where('product_id', $productID)->delete();
                    ProductAboutActivityDescription::where('product_id', $productID)->delete();
                }


                foreach ($request->about_activity_title as $AAkey => $AAT) {
                    if ($AAT != "") {

                        if ($request->about_activity_id[$AAkey] != "") {
                            $ProductAboutActivity             = ProductAboutActivity::find($request->about_activity_id[$AAkey]);
                            $ProductAboutActivityDescription                 = ProductAboutActivityDescription::where(['about_activity_id' => $request->about_activity_id[$AAkey]])->first();
                        } else {
                            $ProductAboutActivity             = new ProductAboutActivity();
                            $ProductAboutActivityDescription             = new ProductAboutActivityDescription();
                        }

                        $ProductAboutActivity->product_id = $productID;

                        if ($request->hasFile('about_activity_image.' . $AAkey)) {
                            $file        = $request->file('about_activity_image.' . $AAkey);
                            $random_no  = uniqid();
                            $mime_type       = $file->getMimeType();
                            $ext             = $file->getClientOriginalExtension();
                            $new_name        = $random_no . '.' . $ext;
                            $destinationPath = public_path('uploads/products');
                            $file->move($destinationPath, $new_name);

                            $ProductAboutActivity->image      = $new_name;
                        }


                        $ProductAboutActivity->save();


                        // description

                        $ProductAboutActivityDescription->title             = $AAT;
                        $ProductAboutActivityDescription->short_description = $request->about_activity_decscription[$AAkey];
                        $ProductAboutActivityDescription->about_activity_id = $ProductAboutActivity->id;
                        $ProductAboutActivityDescription->language_id       = $language_id;
                        $ProductAboutActivityDescription->save();
                    }
                }
            }

            // setp Others
            if ($request->step == "others") {

                if ($request->tourId != '') {
                    $SideBanner    = SideBanner::where('product_id', $request->tourId)->first();
                    if (!$SideBanner) {
                        $SideBanner    = new SideBanner();
                    }
                } else {
                    $SideBanner    = new SideBanner();
                }
                $SideBanner->product_id = $request->tourId;

                if ($request->hasFile('banner_image')) {

                    $file        = $request->file('banner_image');

                    $random_no          = uniqid();
                    $mime_type       = $file->getMimeType();
                    $ext             = $file->getClientOriginalExtension();
                    $new_name        = $random_no . '.' . $ext;


                    $imgFile         = Image::make($file->path());
                    $height          = $imgFile->height();
                    $width           = $imgFile->width();
                    $imgFile->resize(1500, 700, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $destinationPath = public_path('uploads/products');
                    $imgFile->save($destinationPath . '/' . $new_name);
                    // $file->move($destinationPath, $new_name);

                    $SideBanner->image = $new_name;
                    thumbnail_images($file, $new_name, 730, 487);
                }
                $SideBanner->link   =  $request->side_banner_link;
                $SideBanner->status =  'Active';
                $SideBanner->save();


                $sideBannerId = $SideBanner->id;

                $SideBannerDescription = SideBannerDescription::where(['side_banner_id' => $sideBannerId, "product_id" => $productID, 'language_id' => $language_id])->first();
                if (!$SideBannerDescription) {
                    $SideBannerDescription              = new SideBannerDescription();
                }
                if (isset($request->side_banner_title)) {
                    $SideBannerDescription->title            = $request->side_banner_title;
                    $SideBannerDescription->description      = $request->side_banner_description;
                    $SideBannerDescription->language_id      = $language_id;
                    $SideBannerDescription->product_id       = $productID;
                    $SideBannerDescription->side_banner_id   = $sideBannerId;
                    $SideBannerDescription->save();
                }


                $Product = Product::find($productID);
                if ($Product) {
                    if ($request->hasFile('thumbnail_image')) {

                        $file        = $request->file('thumbnail_image');

                        $random_no          = uniqid();
                        $mime_type       = $file->getMimeType();
                        $ext             = $file->getClientOriginalExtension();
                        $new_name        = $random_no . '.' . $ext;


                        $imgFile         = Image::make($file->path());
                        $height          = $imgFile->height();
                        $width           = $imgFile->width();
                        $imgFile->resize(1500, 700, function ($constraint) {
                            $constraint->aspectRatio();
                        });

                        $destinationPath = public_path('uploads/products');
                        $imgFile->save($destinationPath . '/' . $new_name);
                        // $file->move($destinationPath, $new_name);

                        $Product->video_thumbnail_image = $new_name;
                        thumbnail_images($file, $new_name, 730, 487);
                    }
                    $Product->affiliate_commission = $request->affiliate_commission;
                    $Product->video_url = $request->video_url;
                }

                if (isset($request->meta_keyword) || isset($request->meta_description)) {
                    $MetaData = MetaData::where(['language_id' => $language_id, 'value' => $productID, 'type' => 'product'])->first();
                    if (!$MetaData) {

                        $MetaData                = new MetaData();
                    }

                    $MetaData['value']       = $productID;
                    $MetaData['language_id'] = $language_id;
                    $MetaData['keyword']     = $request->meta_keyword;
                    $MetaData['description'] = $request->meta_description;
                    $MetaData['type']        = 'product';

                    $MetaData->save();
                }
            }


            // step Create Option
            if ($request->step == "create_option") {

                $ProductOption  = new ProductOption();
                $ProductOption->product_id = $request->tourId;
                $ProductOption->save();
                $output['optionId'] = $ProductOption->id;
            }

            // step Option Setup
            if ($request->step == "option_setup") {
                $checkOption = 0;
                if (isset($request->optionId)) {
                    $ProductOption = ProductOption::find($request->optionId);
                    if ($ProductOption) {
                        $checkOption = 1;
                    }
                }

                if ($checkOption == 0) {
                    $ProductOption  = new ProductOption();
                    $ProductOption->product_id = $request->tourId;
                    $ProductOption->save();
                    $output['optionId'] = $ProductOption->id;
                }

                $optionId = $ProductOption->id;

                $ProductOptionDescription = ProductOptionDescription::where(['option_id' => $optionId, "product_id" => $productID, 'language_id' => $language_id])->first();
                if (!$ProductOptionDescription) {
                    $ProductOptionDescription              = new ProductOptionDescription();
                }
                if (isset($request->option_title)) {
                    $ProductOptionDescription->title       = $request->option_title;
                    $ProductOptionDescription->description = $request->option_description;
                    $ProductOptionDescription->language_id = $language_id;
                    $ProductOptionDescription->product_id  = $productID;
                    $ProductOptionDescription->option_id   = $optionId;
                    $ProductOptionDescription->save();
                }

                $ProductOption->reference_code = $request->reference_code;
                $ProductOption->is_private     = $request->private_activity;
                $ProductOption->likely_to_sell_out   = isset($request->likely_to_sell_out) ? $request->likely_to_sell_out : 'no';
                if (isset($request->guide_headphone)) {
                    $ProductOption->guide_headphone =  'yes';
                    $ProductOption->guide_headphone_language =  $request->guide_headphone_language;
                }

                if (isset($request->information_booklet)) {
                    $ProductOption->information_booklet =  'yes';
                    $ProductOption->information_booklet_language =  $request->information_booklet_language;
                }

                if ($request->existing_line == "yes") {
                    $ProductOption->existing_line =  'yes';
                    $ProductOption->existing_line_type = $request->existing_line_type;
                }


                $ProductOption->wheelchair_accessibility =  $request->wheelchair_accessibility;


                if (isset($request->time_length)) {
                    $ProductOption->time_length = $request->time_length;
                    if ($request->time_length == 'duration') {
                        $ProductOption->duration_time      = $request->duration_time;
                        $ProductOption->duration_time_type = $request->duration_time_type;
                    } else {
                        $ProductOption->validity_type      = $request->validity_type;

                        if ($request->validity_type != "time_selected") {
                            $ProductOption->validity_time      = $request->validity_time;
                            $ProductOption->validity_time_type = $request->validity_time_type;
                        }
                    }
                }

                $ProductOption->cut_off_time =  $request->cut_off_time;
                $ProductOption->status =  'Active';
                $ProductOption->save();
            }

            // step Option Pricing
            if ($request->step == "option_pricing") {

                $optionId = $request->optionId;
                $productID = $request->tourId;
                $pricing_id = $request->pricing_id;
                $group_pricing_id = $request->group_pricing_id;


                $ProductOption = ProductOption::find($optionId);
                if ($ProductOption) {
                    $ProductOption->pricing_type = $request->pricing_type;
                    $ProductOption->save();
                }

                if (isset($pricing_id)) {

                    ProductOptionPricingDetails::where(['pricing_id' => $pricing_id])->delete();
                    ProductOptionPricingTiers::where(['pricing_id' => $pricing_id])->delete();
                    ProductOptionAddOn::where(['pricing_id' => $pricing_id])->delete();
                    ProductOptionAddOnTiers::where(['pricing_id' => $pricing_id])->delete();
                    ProductOptionPricingDescription::where(['pricing_id' => $pricing_id])->delete();
                }

                if (isset($group_pricing_id)) {

                    ProductOptionPricingDetails::where(['pricing_id' => $group_pricing_id])->delete();
                    ProductOptionPricingTiers::where(['pricing_id' => $group_pricing_id])->delete();
                    ProductOptionAddOn::where(['pricing_id' => $group_pricing_id])->delete();
                    ProductOptionAddOnTiers::where(['pricing_id' => $group_pricing_id])->delete();
                    ProductOptionPricingDescription::where(['pricing_id' => $group_pricing_id])->delete();
                }






                $commission = 30;
                if (isset($request->pricing_id)) {
                    $ProductOptionPricing                       = ProductOptionPricing::find($request->pricing_id);
                } else {
                    if (isset($request->group_pricing_id)) {
                        $ProductOptionPricing                       = ProductOptionPricing::find($request->group_pricing_id);
                        if (!$ProductOptionPricing) {
                            $ProductOptionPricing                       = new ProductOptionPricing();
                        }
                    } else {

                        $ProductOptionPricing                       = new ProductOptionPricing();
                    }
                }
                $ProductOptionPricing->product_id           = $productID;
                $ProductOptionPricing->option_id            = $optionId;
                $ProductOptionPricing->pricing_type         = $request->pricing_type;
                $ProductOptionPricing->minimum_participants = $request->pricing_type == "person" ? $request->minimum_participant : $request->minimum_group_participant;
                $ProductOptionPricing->save();




                if ($request->pricing_type == "person") {
                    if (isset($request->price_name)) {
                        $ProductOptionPricingDescription = new ProductOptionPricingDescription();
                        $ProductOptionPricingDescription->product_id = $productID;
                        $ProductOptionPricingDescription->option_id = $optionId;
                        $ProductOptionPricingDescription->pricing_id = $ProductOptionPricing->id;
                        $ProductOptionPricingDescription->language_id = $language_id;
                        $ProductOptionPricingDescription->title = $request->price_name;
                        $ProductOptionPricingDescription->save();
                    }

                    if (isset($request->age_group_type_value)) {
                        foreach ($request->age_group_type_value as $key => $value) {
                            if ($value != "group") {

                                $ProductOptionPricingDetails                   = new ProductOptionPricingDetails();

                                $ProductOptionPricingDetails->product_id       = $productID;
                                $ProductOptionPricingDetails->option_id        = $optionId;
                                $ProductOptionPricingDetails->pricing_id       = $ProductOptionPricing->id;
                                $ProductOptionPricingDetails->person_type      = $value;
                                $ProductOptionPricingDetails->from_age_range   = $request->age_to[$value];
                                $ProductOptionPricingDetails->age_range        = $request->age_from[$value];
                                $ProductOptionPricingDetails->booking_category = $booking_category = $request->input($value . '_booking_category');
                                $ProductOptionPricingDetails->save();

                                foreach ($request->no_of_people[$value] as $Nkey => $NOP) {

                                    $checkData = 0;
                                    $ProductOptionPricingTiersDetails  = ProductOptionPricingTiers::where(['product_id' => $productID, 'option_id' => $optionId, 'pricing_id' => $ProductOptionPricing->id, 'pricing_details_id' => $ProductOptionPricingDetails->id, 'type' => $value])->first();
                                    if ($ProductOptionPricingTiersDetails) {
                                        if ($booking_category == "free_no_ticket" || $booking_category == "not_permitted") {
                                            $checkData = 1;
                                        }
                                    }

                                    $ProductOptionPricingTiers                     = new ProductOptionPricingTiers();
                                    $ProductOptionPricingTiers->product_id         = $productID;
                                    $ProductOptionPricingTiers->option_id          = $optionId;
                                    $ProductOptionPricingTiers->pricing_id         = $ProductOptionPricing->id;
                                    $ProductOptionPricingTiers->pricing_details_id = $ProductOptionPricingDetails->id;
                                    $ProductOptionPricingTiers->type               = $value;


                                    if ($booking_category != "free_no_ticket" && $booking_category != "not_permitted") {
                                        $ProductOptionPricingTiers->no_of_people      = $NOP;
                                        $ProductOptionPricingTiers->from_no_of_people = $request->no_of_to_people[$value][$Nkey];
                                        $ProductOptionPricingTiers->retail_price      = $request->retail_price[$value][$Nkey];
                                        if ($booking_category != "free") {
                                            $ProductOptionPricingTiers->currency           = "INR";
                                            $ProductOptionPricingTiers->commission         = $commission;
                                            $payout_calculate = $commission / 100 * $request->retail_price[$value][$Nkey];
                                            $ProductOptionPricingTiers->payout_per_person  = $request->retail_price[$value][$Nkey] - $payout_calculate;
                                        }
                                    } else {

                                        $ProductOptionPricingTiers->no_of_people      = $NOP == "" ? 51 : $NOP;
                                        $ProductOptionPricingTiers->from_no_of_people = $request->no_of_to_people[$value][$Nkey] == "" ? 1 : $request->no_of_to_people[$value][$Nkey];
                                    }
                                    if ($checkData == 0) {
                                        $ProductOptionPricingTiers->save();
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if (isset($request->price_group_name)) {
                        $ProductOptionPricingDescription = new ProductOptionPricingDescription();
                        $ProductOptionPricingDescription->product_id = $productID;
                        $ProductOptionPricingDescription->option_id = $optionId;
                        $ProductOptionPricingDescription->pricing_id = $ProductOptionPricing->id;
                        $ProductOptionPricingDescription->language_id = $language_id;
                        $ProductOptionPricingDescription->title = $request->price_group_name;
                        $ProductOptionPricingDescription->save();
                    }


                    $ProductOptionPricingDetails                   = new ProductOptionPricingDetails();
                    $ProductOptionPricingDetails->product_id       = $productID;
                    $ProductOptionPricingDetails->option_id        = $optionId;
                    $ProductOptionPricingDetails->pricing_id       = $ProductOptionPricing->id;
                    $ProductOptionPricingDetails->person_type      = $value;
                    $ProductOptionPricingDetails->from_age_range   = 0;
                    $ProductOptionPricingDetails->age_range        = 0;
                    $ProductOptionPricingDetails->booking_category = 'none';
                    $ProductOptionPricingDetails->save();
                    $value = 'group';
                    foreach ($request->no_of_people[$value] as $Nkey => $NOP) {




                        $ProductOptionPricingTiers                     = new ProductOptionPricingTiers();
                        $ProductOptionPricingTiers->product_id         = $productID;
                        $ProductOptionPricingTiers->option_id          = $optionId;
                        $ProductOptionPricingTiers->pricing_id         = $ProductOptionPricing->id;
                        $ProductOptionPricingTiers->pricing_details_id = $ProductOptionPricingDetails->id;
                        $ProductOptionPricingTiers->type               = $value;



                        $ProductOptionPricingTiers->no_of_people      = $NOP;
                        $ProductOptionPricingTiers->from_no_of_people = $request->no_of_to_people[$value][$Nkey];
                        $ProductOptionPricingTiers->retail_price      = $request->retail_price[$value][$Nkey];
                        $ProductOptionPricingTiers->currency          = "INR";
                        $ProductOptionPricingTiers->commission        = $commission;
                        $payout_calculate                             = $commission / 100 * $request->retail_price[$value][$Nkey];
                        $ProductOptionPricingTiers->payout_per_person = $request->retail_price[$value][$Nkey] - $payout_calculate;


                        $ProductOptionPricingTiers->save();
                    }
                }

                if (isset($request->add_on)) {
                    foreach ($request->add_on as $Akey => $AO) {
                        $ProductOptionAddOn               = new ProductOptionAddOn();
                        $ProductOptionAddOn->product_id   = $productID;
                        $ProductOptionAddOn->option_id    = $optionId;
                        $ProductOptionAddOn->pricing_type = $request->pricing_type;
                        $ProductOptionAddOn->pricing_id   = $ProductOptionPricing->id;
                        $ProductOptionAddOn->add_on_id    = $AO;
                        $ProductOptionAddOn->save();


                        foreach ($request->add_on_no_of_people[$Akey] as $AOkey => $AON) {




                            $ProductOptionAddOnTiers                    = new ProductOptionAddOnTiers();
                            $ProductOptionAddOnTiers->product_id        = $productID;
                            $ProductOptionAddOnTiers->option_id         = $optionId;
                            $ProductOptionAddOnTiers->add_on_id         = $ProductOptionAddOn->id;
                            $ProductOptionAddOnTiers->no_of_people      = $AON;
                            $ProductOptionAddOnTiers->from_no_of_people = $request->add_on_no_of_to_people[$Akey][$AOkey];
                            $ProductOptionAddOnTiers->retail_price      = $request->add_on_retail_price[$Akey][$AOkey];
                            $ProductOptionAddOnTiers->currency          = "INR";
                            $ProductOptionAddOnTiers->pricing_id        = $ProductOptionPricing->id;
                            $ProductOptionAddOnTiers->commission        = $commission;
                            $payout_calculate                           = $commission / 100 * $request->add_on_retail_price[$Akey][$AOkey];
                            $ProductOptionAddOnTiers->payout_per_person = $request->add_on_retail_price[$Akey][$AOkey] - $payout_calculate;
                            $ProductOptionAddOnTiers->save();
                        }
                    }
                }





                $ProductOptionPricingList = ProductOptionPricing::where(['option_id' => $optionId, 'product_id' => $productID])->get();
                $view  = view('admin.products.option.pricing._saved_pricing_list', compact('ProductOptionPricingList', 'language_id', 'optionId', 'productID'))->render();
                $output['view'] = $view;
            }

            // step option

            if ($request->step == 'option') {
                $optionId = $request->optionId;
                $productID = $request->tourId;
                $ProductOption = ProductOption::where(["product_id" => $productID])->get();
                $view  = view('admin.products.option._option_list', compact('ProductOption', 'language_id', 'optionId', 'productID'))->render();
                $output['view'] = $view;
            }


            // step option availablity

            if ($request->step == 'availability') {

                $optionId                              = $request->optionId;
                $productID                             = $request->tourId;
                $pricing_id                             = $request->price_availability_id;
                $ProductOptionAvailability = ProductOptionAvailability::where(["product_id" => $productID, 'pricing_id' => $pricing_id, 'option_id' => $optionId])->first();
                if (!$ProductOptionAvailability) {

                    $ProductOptionAvailability             = new ProductOptionAvailability();
                }
                $ProductOptionAvailability->product_id = $productID;
                $ProductOptionAvailability->option_id  = $optionId;
                $ProductOptionAvailability->pricing_id  = $pricing_id;
                $ProductOptionAvailability->valid_from  = $request->valid_from;
                $ProductOptionAvailability->valid_to  = $request->valid_to;
                $ProductOptionAvailability->save();

                $ProductOptionAvailabilityDescription = ProductOptionAvailabilityDescription::where(["product_id" => $productID, 'pricing_id' => $pricing_id, 'option_id' => $optionId, 'language_id' => $language_id])->first();
                if (!$ProductOptionAvailabilityDescription) {
                    $ProductOptionAvailabilityDescription              = new ProductOptionAvailabilityDescription();
                }
                if (isset($request->availability_name)) {
                    $ProductOptionAvailabilityDescription->title           = $request->availability_name;
                    $ProductOptionAvailabilityDescription->language_id     = $language_id;
                    $ProductOptionAvailabilityDescription->product_id      = $productID;
                    $ProductOptionAvailabilityDescription->option_id       = $optionId;
                    $ProductOptionAvailabilityDescription->pricing_id       = $pricing_id;
                    $ProductOptionAvailabilityDescription->availability_id = $ProductOptionAvailability->id;
                    $ProductOptionAvailabilityDescription->save();
                }
                $TimeArr = [];
                if (isset($request->start_time_hour)) {
                    foreach ($request->start_time_hour as $key => $STH) {
                        if (!is_int($key)) {
                            foreach ($STH as $Skey => $value) {
                                $getTimeArr = [];
                                $getTimeArr = $value . ':' . $request->start_time_minute[$key][$Skey];
                                $TimeArr[$key][] = $getTimeArr;
                            }
                        }
                    }
                    $ProductOptionAvailability->time_json   = json_encode($TimeArr);
                } else {
                    $ProductOptionAvailability->time_json  = "";
                }
                $dateArr = [];
                if (isset($request->available_date)) {
                    foreach ($request->available_date as $key => $AD) {
                        if (isset($request->start_time_hour[$key])) {
                            foreach ($request->start_time_hour[$key] as $STHkey => $V) {
                                $getdateArr = [];
                                $getdateArr = $V . ':' . $request->start_time_minute[$key][$STHkey];
                                $dateArr[$AD][] = $getdateArr;
                            }
                        } else {
                            $dateArr[$AD][] = [];
                        }
                    }
                    $ProductOptionAvailability->date_json   = json_encode($dateArr);
                } else {
                    $ProductOptionAvailability->date_json  = "";
                }
                $ProductOptionAvailability->save();
            }

            // step option price discount

            if ($request->step == 'discount') {

                $optionId   = $request->optionId;
                $productID  = $request->tourId;
                $pricing_id = $request->price_discount_id;

                $ProductOptionDiscount = ProductOptionDiscount::where(["product_id" => $productID, 'pricing_id' => $pricing_id, 'option_id' => $optionId])->first();
                if (!$ProductOptionDiscount) {

                    $ProductOptionDiscount             = new ProductOptionDiscount();
                }

                $ProductOptionDiscount->product_id      = $productID;
                $ProductOptionDiscount->option_id       = $optionId;
                $ProductOptionDiscount->valid_from      = $request->discount_valid_from;
                $ProductOptionDiscount->valid_to        = $request->discount_valid_to;
                $ProductOptionDiscount->date_percentage = $request->discount_date_percentage;
                $ProductOptionDiscount->pricing_id      = $pricing_id;



                $TimeArr = [];
                if (isset($request->discount_day)) {
                    foreach ($request->discount_day as $key => $DD) {
                        if ($DD) {
                            $TimeArr[$key] = $DD;
                        }
                    }
                    if ($TimeArr) {
                        $ProductOptionDiscount->time_json   = json_encode($TimeArr);
                    } else {
                        $ProductOptionDiscount->time_json = '';
                    }
                } else {
                    $ProductOptionDiscount->time_json = '';
                }

                $dateArr = [];
                if (isset($request->available_date)) {
                    foreach ($request->available_date as $key => $AD) {
                        if (isset($request->discount_date[$key])) {
                            $dateArr[$AD] = $request->discount_date[$key];
                        }
                    }
                    $ProductOptionDiscount->date_json   = json_encode($dateArr);
                } else {
                    $ProductOptionDiscount->date_json = "";
                }
                $ProductOptionDiscount->save();
            }


            if ($request->step == 'likely_sell_out') {
                $productID                             = $request->id;
                $likely_sell_out                             = $request->value == 'true' ? 'yes' : 'no';

                $Product = Product::find($productID);
                if ($Product) {
                    $Product->likely_to_sell_out = $likely_sell_out;
                }
            }



            $Product->save();
            $output['status'] = true;
            return $output;
        }

        // Get data By Tour Id On Page Reload
        $data = [];
        if (isset($_GET['tourId'])) {
            $productID                     = $_GET['tourId'];
            $data['product']               = Product::find($productID);
            $data['ProductDescription']    = $ProductDescription = ProductDescription::where(["product_id" => $productID, 'language_id' => $language_id])->first();
            $data['ProductLocation']       = ProductLocation::where(["product_id" => $productID])->get();
            $data['ProductTransportation'] = ProductTransportation::where(["product_id" => $productID])->get();
            $data['ProductFoodDrink']      = ProductFoodDrink::where(["product_id" => $productID])->get();
            $ProductInclusions             = ProductInclusion::where(["product_id" => $productID])->get();
            $RestrictionData               = ProductRestriction::where(["product_id" => $productID])->get();
            $data['ProductHighlight']      = ProductHighlight::where(["product_id" => $productID])->get();
            $data['ProductInformation']    = ProductInformation::where(["product_id" => $productID])->get();
            $data['AboutActivity']         = ProductAboutActivity::where(["product_id" => $productID])->get();
            $data['ProductImages']         = ProductImages::where(["product_id" => $productID])->get();
            $data['ProductOption']         = ProductOption::where(["product_id" => $productID])->get();
            $data['SideBanner']            = SideBanner::where(["product_id" => $productID])->first();
            $data['SideBannerDescription'] = SideBannerDescription::where(["product_id" => $productID, 'language_id' => $language_id])->first();
            $data['MetaData'] = MetaData::where(["value" => $productID, 'language_id' => $language_id, 'type' => 'product'])->first();

            if (isset($_GET['optionId'])) {
                $optionId = $_GET['optionId'];
                $data['ProductOptionSetup'] = $ProductOptionSetup = ProductOption::where(['id' => $optionId])->first();
                $data['ProductOptionDescription'] =  ProductOptionDescription::where(['product_id' => $productID, 'option_id' => $optionId, 'language_id' => $language_id])->first();

                $data['ProductOptionPricingList'] = [];
                if ($ProductOptionSetup) {
                    $pricing_type =  $ProductOptionSetup->pricing_type;
                    $data['ProductOptionPricingList']          = ProductOptionPricing::where(['product_id' => $productID, 'option_id' => $optionId, 'pricing_type' => $pricing_type])->get();
                }

                $data['ProductOptionAvailability'] = [];
                $data['ProductOptionAvailabilityDescription'] = '';

                $data['ProductOptionAvailability'] = $ProductOptionAvailability = ProductOptionAvailability::where(["product_id" => $productID, 'option_id' => $optionId])->first();
                if ($ProductOptionAvailability) {
                    $data['ProductOptionAvailabilityDescription'] = ProductOptionAvailabilityDescription::where(["product_id" => $productID, 'option_id' => $optionId, 'language_id' => $language_id])->first();
                }
            }


            if ($data['product']->country != "") {
                $States = States::where('country_id', $data['product']->country)->get();
                if ($data['product']->state != "") {
                    $Cities = Cities::where('state_id', $data['product']->state)->get();
                }
            }



            $ProductGears       = [];
            $ProductMedia       = [];
            $ProductInclusion   = [];
            $ProductRestriction = [];
            $ProductKeyword     = [];

            if ($ProductDescription) {
                $ProductKeyword = $ProductDescription->keyword;
                $data['ProductKeyword'] = $ProductKeyword;
            }

            foreach ($ProductInclusions as $PI) {
                if ($PI['type'] == 'gear') {
                    $ProductGears[] = $PI['type_id'];
                }

                if ($PI['type'] == 'media') {
                    $ProductMedia[] = $PI['type_id'];
                }

                if ($PI['type'] == 'inclusion') {
                    $ProductInclusion[] = $PI['type_id'];
                }
            }
            $data['ProductGears']     = $ProductGears;
            $data['ProductMedia']     = $ProductMedia;
            $data['ProductInclusion'] = $ProductInclusion;

            foreach ($RestrictionData as $RD) {
                $ProductRestriction[] = $RD['restriction_id'];
            }
            $data['ProductRestriction'] = $ProductRestriction;
        }


        return view('admin.products.add_product', compact('common', 'categories', 'Gears', 'Media', 'Inclusion', 'Restriction', 'AddOn', 'data', 'language_id', 'Transportation', 'ProductType', 'interests', 'topAttraction', 'Countries', 'States', 'Cities'));
    }


    // Get transportation View
    public function get_transportation_modal_view(Request $request)
    {
        $TransportationId = $request->id;
        $Transportation = Transportation::where('id', $request->id)->first();
        $ProductTransportation = "";
        if (isset($request->product_transportation_id)) {
            $ProductTransportation = ProductTransportation::find($request->product_transportation_id);
            if ($ProductTransportation) {
                if ($TransportationId > 0) {
                    $Transportation = Transportation::where('id', $TransportationId)->first();
                } else {
                    $Transportation = Transportation::where('id', $ProductTransportation->transportation_id)->first();
                }
            }
        }
        if (!$Transportation) {
            $Transportation = getTableColumn('transportation');
        }
        $view =  View::make('admin.products._transportation_modal', compact('Transportation', 'ProductTransportation', 'TransportationId'))->render();
        return [
            'transportation_id' => $ProductTransportation  ? $ProductTransportation->transportation_id : "",
            'view' => $view
        ];
    }

    // Add Product Transportation
    public function add_product_transportation(Request $request)
    {
        $req_fields = array();
        if (isset($request->capacity)) {
            $req_fields['capacity']   = "required";
        }
        $errormsg = [
            "capacity"  => translate("Capacity"),
        ];

        $validation = Validator::make(
            $request->all(),
            $req_fields,
            [
                'required' => 'The :attribute field is required.',
            ],
            $errormsg
        );

        $productID = "";
        if ($validation->fails()) {
            return response()->json(['error' => $validation->getMessageBag()->toArray()]);
        }
        $get_session_language     = getLang();

        $language_id = $get_session_language['id'];
        $is_edit = 0;
        if ($request->ProductTransportationId != "") {
            $is_edit = $request->ProductTransportationId;
            $ProductTransportation                    =  ProductTransportation::find($request->ProductTransportationId);
        } else {
            $ProductTransportation                    = new ProductTransportation();
        }
        $ProductTransportation->product_id        = $request->tourId;
        $ProductTransportation->transportation_id = $request->transportation;
        $ProductTransportation->capacity          = isset($request->capacity) ? $request->capacity : 0;
        $ProductTransportation->air_conditioning  = isset($request->air_conditioning) ? $request->air_conditioning : "none";
        $ProductTransportation->wifi              = isset($request->wifi) ? $request->wifi : "none";
        $ProductTransportation->private_shared    = isset($request->private_shared) ? $request->private_shared : "none";
        $ProductTransportation->save();

        $TransportationData = Transportation::find($request->transportation);
        $private_shared = '';
        if ($TransportationData) {
            $private_shared = $TransportationData->private_shared == 'no' ? '' : $TransportationData->private_shared;
        }

        $TransportationDescription  = TransportationDescription::where(['transportation_id' => $request->transportation, 'language_id' => $language_id])->first();
        $view = View::make('admin.products._transportation_entry', compact('ProductTransportation', 'TransportationDescription', 'is_edit', 'private_shared'))->render();
        return
            ['is_edit' => $is_edit, 'view' => $view];
    }

    // Remove Product Transportation
    public function remove_product_transportation(Request $request)
    {
        ProductTransportation::where("id", $request->id)->delete();
        return $request->id;
    }




    // Get Food View
    public function get_food_modal_view(Request $request)
    {
        $ProductFoodDrink = getTableColumn('product_food_drink');
        $get_session_language     = getLang();
        $language_id = $get_session_language['id'];
        $ProductFood = ProductFood::where(['type' => 'type_of_meal'])->where(['status' => 'Active'])->whereNull('is_delete')->get();
        $products_food_desc = [];
        if (!empty($ProductFood)) {
            foreach ($ProductFood as $key => $PF) {
                $row  = getLanguageData('products_food_descriptions', $language_id, $PF['id'], 'product_food_id');
                $products_food_desc[] = $row;
            }
        }
        $ProductTime = ProductFood::where(['type' => 'time_of_day'])->where(['status' => 'Active'])->whereNull('is_delete')->get();
        $products_time_desc = [];
        if (!empty($ProductTime)) {
            foreach ($ProductTime as $key => $PT) {
                $row  = getLanguageData('products_food_descriptions', $language_id, $PT['id'], 'product_food_id');
                $products_time_desc[] = $row;
            }
        }
        $ProductFoodTags = ProductFood::where(['type' => 'food_tags'])->where(['status' => 'Active'])->whereNull('is_delete')->get();
        $products_food_tags_desc = [];
        if (!empty($ProductFoodTags)) {
            foreach ($ProductFoodTags as $key => $PFT) {
                $row  = getLanguageData('products_food_descriptions', $language_id, $PFT['id'], 'product_food_id');
                $products_food_tags_desc[] = $row;
            }
        }
        $view =  View::make('admin.products._food_modal', compact('products_food_desc', 'ProductFoodDrink', 'products_time_desc', 'products_food_tags_desc'))->render();
        return [
            'view' => $view
        ];
    }

    // Get Drink View
    public function get_drink_modal_view(Request $request)
    {
        $ProductFoodDrink = getTableColumn('product_food_drink');

        $get_session_language     = getLang();
        $language_id = $get_session_language['id'];
        $ProductDrinkTags = ProductFood::where(['type' => 'drink_tags'])->where(['status' => 'Active'])->whereNull('is_delete')->get();
        $products_drink_tags_desc = [];
        if (!empty($ProductDrinkTags)) {
            foreach ($ProductDrinkTags as $key => $PDT) {
                $row  = getLanguageData('products_food_descriptions', $language_id, $PDT['id'], 'product_food_id');
                $products_drink_tags_desc[] = $row;
            }
        }
        $view =  View::make('admin.products._drink_modal', compact('products_drink_tags_desc', 'ProductFoodDrink'))->render();
        return [
            'view' => $view
        ];
    }

    // get Food Drink modal View
    public function get_food_drink_modal_view(Request $request)
    {
        $get_session_language     = getLang();
        $language_id = $get_session_language['id'];
        $ProductFoodDrink                    =  ProductFoodDrink::find($request->product_food_drink_id);
        $ProductFood = ProductFood::where(['type' => 'type_of_meal'])->where(['status' => 'Active'])->whereNull('is_delete')->get();
        $products_food_desc = [];
        if (!empty($ProductFood)) {
            foreach ($ProductFood as $key => $PF) {
                $row  = getLanguageData('products_food_descriptions', $language_id, $PF['id'], 'product_food_id');
                $products_food_desc[] = $row;
            }
        }
        $ProductTime = ProductFood::where(['type' => 'time_of_day'])->where(['status' => 'Active'])->whereNull('is_delete')->get();
        $products_time_desc = [];
        if (!empty($ProductTime)) {
            foreach ($ProductTime as $key => $PT) {
                $row  = getLanguageData('products_food_descriptions', $language_id, $PT['id'], 'product_food_id');
                $products_time_desc[] = $row;
            }
        }
        $ProductFoodTags = ProductFood::where(['type' => 'food_tags'])->where(['status' => 'Active'])->whereNull('is_delete')->get();
        $products_food_tags_desc = [];
        if (!empty($ProductFoodTags)) {
            foreach ($ProductFoodTags as $key => $PFT) {
                $row  = getLanguageData('products_food_descriptions', $language_id, $PFT['id'], 'product_food_id');
                $products_food_tags_desc[] = $row;
            }
        }

        $ProductDrinkTags = ProductFood::where(['type' => 'drink_tags'])->where(['status' => 'Active'])->whereNull('is_delete')->get();
        $products_drink_tags_desc = [];
        if (!empty($ProductDrinkTags)) {
            foreach ($ProductDrinkTags as $key => $PDT) {
                $row  = getLanguageData('products_food_descriptions', $language_id, $PDT['id'], 'product_food_id');
                $products_drink_tags_desc[] = $row;
            }
        }
        $drink_view = "";
        if ($ProductFoodDrink->drink == "yes") {
            $drink_view =  View::make('admin.products._drink_modal', compact('products_drink_tags_desc', 'ProductFoodDrink'))->render();
        }
        $food_view = "";
        if ($ProductFoodDrink->food == "yes") {
            $food_view =  View::make('admin.products._food_modal', compact('products_food_desc', 'products_time_desc', 'products_food_tags_desc', 'ProductFoodDrink'))->render();
        }

        return [
            'food_view' => $food_view,
            'drink_view' => $drink_view,
            'food' => $ProductFoodDrink['food'],
            'drink' => $ProductFoodDrink['drink']
        ];
    }

    // Add Product Food Drink
    public function add_product_food_drink(Request $request)
    {
        $req_fields = array();
        if ($request->food == "yes") {
            $req_fields['type_of_meal'] = "required";
            $req_fields['time_of_day']  = "required";
            $req_fields['food_tags']    = "required";
        }
        if ($request->drink == "yes") {
            $req_fields['drink_tags']   = "required";
        }


        $errormsg = [
            "type_of_meal" => translate("Type of meal"),
            "time_of_day"  => translate("Type of day"),
            "food_tags"    => translate("Food tags"),
            "drink_tags"   => translate("Drink tags"),
        ];


        $validation = Validator::make(
            $request->all(),
            $req_fields,
            [
                'required' => 'The :attribute field is required.',
            ],
            $errormsg
        );

        $productID = "";
        if ($validation->fails()) {
            return response()->json(['error' => $validation->getMessageBag()->toArray()]);
        }
        $get_session_language     = getLang();


        $language_id = $get_session_language['id'];
        $is_edit = 0;
        if ($request->id != "") {
            $is_edit = $request->id;
            $ProductFoodDrink                    =  ProductFoodDrink::find($request->id);
        } else {
            $ProductFoodDrink                    = new ProductFoodDrink();
        }
        $ProductFoodDrink->product_id   = $request->tourId;
        $ProductFoodDrink->food         = $request->food;
        $ProductFoodDrink->drink        = $request->drink;
        $ProductFoodDrink->type_of_meal = isset($request->type_of_meal) ? $request->type_of_meal : "";
        $ProductFoodDrink->time_of_day  = isset($request->time_of_day) ? $request->time_of_day : "";
        $ProductFoodDrink->food_tags    = isset($request->food_tags) ? implode(",", $request->food_tags) : "";
        $ProductFoodDrink->drink_tags   = isset($request->drink_tags) ? implode(",", $request->drink_tags) : "";

        $ProductFoodDrink->save();
        $foodTagsArr              = [];
        $foodTagArr               = "";
        $drinkTagsArr             = [];
        $drinkTagArr              = '';
        $type_of_meal_description = ProductFoodDescription::where(['product_food_id' => $request->type_of_meal, 'language_id' => $language_id])->first();

        $time_of_day_description = ProductFoodDescription::where(['product_food_id' => $request->time_of_day, 'language_id' => $language_id])->first();
        if (isset($request->food_tags)) {
            foreach ($request->food_tags as $key => $FT) {

                $foogTags = ProductFoodDescription::where(['product_food_id' => $FT, 'language_id' => $language_id])->first();
                if ($foogTags) {
                    $foodTagsArr[] = $foogTags->title;
                }
            }
            $foodTagArr = implode(',', $foodTagsArr);
        }

        if (isset($request->drink_tags)) {
            foreach ($request->drink_tags as $key => $DT) {

                $drinkTags = ProductFoodDescription::where(['product_food_id' => $DT, 'language_id' => $language_id])->first();
                if ($drinkTags) {
                    $drinkTagsArr[] = $drinkTags->title;
                }
            }
            $drinkTagArr = implode(',', $drinkTagsArr);
        }

        $view = View::make('admin.products._food_drink_entry', compact('ProductFoodDrink', 'drinkTagArr', 'foodTagArr', 'time_of_day_description', 'type_of_meal_description', 'is_edit'))->render();
        return
            ['is_edit' => $is_edit, 'view' => $view];
    }

    // Remove Food Drink
    public function remove_product_food_drink(Request $request)
    {
        ProductFoodDrink::where("id", $request->id)->delete();
        return $request->id;
    }

    // Remove Highligh
    public function remove_product_highlight(Request $request)
    {
        ProductHighlight::where("id", $request->id)->delete();
        return $request->id;
    }

    // Remove Highligh
    public function remove_product_information(Request $request)
    {
        ProductInformation::where("id", $request->id)->delete();
        return $request->id;
    }

    // Remove About Activity
    public function remove_about_activity(Request $request)
    {
        ProductAboutActivity::where("id", $request->id)->delete();
        return $request->id;
    }


    // Edit Option Pricing
    public function edit_option_pricing(Request $request)
    {
        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id              = $get_session_language['id'];
        $tourId                   = $request->tourId;
        $optionId                 = $request->optionId;
        $optionPricingId          = $request->optionPricingId;
        $type                     = $request->type;

        $ProductOptionPricing            = ProductOptionPricing::where(['id' => $optionPricingId])->first();
        $ProductOptionPricingDescription = ProductOptionPricingDescription::where(['pricing_id' => $optionPricingId, 'language_id' => $language_id])->first();
        $ProductOptionPricingDetails     = ProductOptionPricingDetails::where(['pricing_id' => $optionPricingId, 'option_id' => $optionId, 'product_id' => $tourId])->get();
        $ProductOptionPricingTiers       = ProductOptionPricingTiers::where(['pricing_id' => $optionPricingId, 'option_id' => $optionId, 'product_id' => $tourId])->get();
        $ProductOptionAddOn              = ProductOptionAddOn::where(['option_id' => $optionId, 'product_id' => $tourId, 'pricing_id' => $optionPricingId])->get();
        $ProductOptionAddOnTiers         = ProductOptionAddOnTiers::where(['option_id' => $optionId, 'product_id' => $tourId, 'pricing_id' => $optionPricingId])->get();

        if ($type == "person") {
            $view_file = 'admin.products.option._price_per_person';
        } else {
            $view_file = 'admin.products.option._price_per_group';
        }
        $view  = view($view_file, compact('ProductOptionPricing', 'ProductOptionPricingDetails', 'ProductOptionPricingTiers', 'ProductOptionAddOn', 'ProductOptionAddOnTiers', 'optionPricingId', 'tourId', 'optionId', 'ProductOptionPricingDescription'))->render();
        return $view;
    }


    // Edit Product Option 
    public function edit_product_option(Request $request)
    {
        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id              = $get_session_language['id'];
        $tourId                   = $request->tourId;
        $optionId                 = $request->optionId;
        $ProductOptionSetup       = ProductOption::where(["id" => $optionId])->first();
        $ProductOptionPricingList = [];
        if ($ProductOptionSetup) {
            $pricing_type =  $ProductOptionSetup->pricing_type;
            $ProductOptionPricingList          = ProductOptionPricing::where(['product_id' => $tourId, 'option_id' => $optionId, 'pricing_type' => $pricing_type])->get();
        }



        $ProductOptionDescription     = ProductOptionDescription::where(['product_id' => $tourId, 'option_id' => $optionId, 'language_id' => $language_id])->first();

        $ProductOptionAvailability = $ProductOptionAvailability = ProductOptionAvailability::where(["product_id" => $tourId, 'option_id' => $optionId])->first();
        $ProductOptionAvailabilityDescription = "";
        if ($ProductOptionAvailability) {
            $ProductOptionAvailabilityDescription = ProductOptionAvailabilityDescription::where(["product_id" => $tourId, 'option_id' => $optionId, 'language_id' => $language_id])->first();
        }


        $view_file = 'admin.products.option._edit_option';
        $view  = view($view_file, compact('ProductOptionDescription', 'ProductOptionSetup', 'ProductOptionPricingList', 'language_id', 'ProductOptionAvailability', 'ProductOptionAvailabilityDescription'))->render();
        return $view;
    }




    // Remove option Pricing
    public function remove_option_pricing(Request $request)
    {
        $tourId   = $request->tourId;
        $optionId   = $request->optionId;
        if (isset($request->optionPricingId)) {
            $optionPricingId   = $request->optionPricingId;


            ProductOptionPricing::where(['id' => $optionPricingId])->delete();
            ProductOptionPricingDetails::where(['pricing_id' => $optionPricingId])->delete();
            ProductOptionPricingTiers::where(['pricing_id' => $optionPricingId])->delete();
            ProductOptionPricingDescription::where(['pricing_id' => $optionPricingId])->delete();
            ProductOptionAddOn::where(['pricing_id' => $optionPricingId])->delete();
            ProductOptionAddOnTiers::where(['pricing_id' => $optionPricingId])->delete();
        } else {
            ProductOptionPricing::where(['option_id' => $optionId, 'product_id' => $tourId])->delete();
            ProductOptionPricingDetails::where(['option_id' => $optionId, 'product_id' => $tourId])->delete();
            ProductOptionPricingTiers::where(['option_id' => $optionId, 'product_id' => $tourId])->delete();
            ProductOptionPricingDescription::where(['option_id' => $optionId, 'product_id' => $tourId])->delete();
            ProductOptionAddOn::where(['option_id' => $optionId, 'product_id' => $tourId])->delete();
            ProductOptionAddOnTiers::where(['option_id' => $optionId, 'product_id' => $tourId])->delete();
        }

        $ProductOptionPricingCount = ProductOptionPricing::where('product_id', $tourId)->count();
        $Product = Product::find($tourId);
        if ($ProductOptionPricingCount ==  0) {
            $Product->status = 'Draft';
        }
        $Product->save();
        return true;
    }

    // Remove option 
    public function remove_product_option(Request $request)
    {
        $tourId   = $request->tourId;
        $optionId   = $request->id;


        ProductOption::where(['id' => $optionId])->delete();
        ProductOptionPricing::where(['option_id' => $optionId, 'product_id' => $tourId])->delete();
        ProductOptionPricingDetails::where(['option_id' => $optionId, 'product_id' => $tourId])->delete();
        ProductOptionPricingTiers::where(['option_id' => $optionId, 'product_id' => $tourId])->delete();
        ProductOptionPricingDescription::where(['option_id' => $optionId, 'product_id' => $tourId])->delete();
        ProductOptionAddOn::where(['option_id' => $optionId, 'product_id' => $tourId])->delete();
        ProductOptionAddOnTiers::where(['option_id' => $optionId, 'product_id' => $tourId])->delete();


        $ProductOptionPricingCount = ProductOptionPricing::where('product_id', $tourId)->count();
        $Product = Product::find($tourId);
        if ($ProductOptionPricingCount ==  0) {
            $Product->status = 'Draft';
        }
        $Product->save();

        return true;
    }


    // Edit Option Price Availablity
    public function edit_price_availability(Request $request)
    {

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id              = $get_session_language['id'];
        $tourId                   = $request->tourId;
        $optionId                 = $request->optionId;
        $PricingId                = $request->PricingId;

        $ProductOptionAvailability = [];
        $ProductOptionAvailabilityDescription = '';
        $ProductOptionAvailability = $ProductOptionAvailability = ProductOptionAvailability::where(["product_id" => $tourId, 'pricing_id' => $PricingId, 'option_id' => $optionId])->first();
        if ($ProductOptionAvailability) {
            $ProductOptionAvailabilityDescription = ProductOptionAvailabilityDescription::where(["product_id" => $tourId, 'pricing_id' => $PricingId, 'option_id' => $optionId, 'language_id' => $language_id])->first();
        }
        $view_file = 'admin.products.option._optionAvailability';
        $view  = view($view_file, compact('ProductOptionAvailability', 'ProductOptionAvailabilityDescription', 'PricingId'))->render();
        return $view;
    }

    // Edit Option Price Availablity
    public function edit_price_discount(Request $request)
    {

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id              = $get_session_language['id'];
        $tourId                   = $request->tourId;
        $optionId                 = $request->optionId;
        $PricingId                = $request->PricingId;

        $ProductOptionDiscount = [];
        $ProductOptionDiscount = $ProductOptionDiscount = ProductOptionDiscount::where(["product_id" => $tourId, 'pricing_id' => $PricingId, 'option_id' => $optionId])->first();

        $view_file = 'admin.products.option._optionDiscount';
        $view  = view($view_file, compact('ProductOptionDiscount', 'PricingId'))->render();
        return $view;
    }

    public function change_product_approved(Request $request)
    {
        $id = $request->id;
        $view = false;
        $Product = Product::find($id);

        $get_products_desc = ProductDescription::where('product_id', $Product->id)->first();
        $product_title  = '';
        if ($get_products_desc) {
            $product_title  = $get_products_desc->title;
        }

        $get_partner       = User::where(['id' => $Product->partner_id, 'status' => 'Active'])->first();
        $username       = '';
        $user_email     = '';
        if ($get_partner) {
            $username       = $get_partner->first_name . ' ' . $get_partner->last_name;
            $user_email     = $get_partner->email;
        }

        $countProductOption = ProductOption::where(['product_id' => $id, 'is_delete' => null])->count();
        $countProductOptionPricingDetails = ProductOptionPricingDetails::where(['product_id' => $id])->count();


        if ($Product) {

            if ($countProductOption == 0 || $countProductOptionPricingDetails == 0) {
                $view = 0;
            } else {
                if ($get_partner) {

                    PartnerProductReason::where(['product_id' => $id, 'partner_id' => $Product->partner_id])->delete();


                    $Product->is_approved = "Approved";
                    $get_partner->send_for_approval = '2';
                    $view = '<button class="btn btn-success btn-sm ml-5 mt-1"
                onclick="ChangeApproved(' . $id . ')">  <span class="fa fa-check"></span>
                Approved</button>';

                    $Product->save();
                } else {
                    if ($Product->added_by == "admin") {
                        $Product->is_approved = "Approved";
                        $get_partner->send_for_approval = '2';
                        $view = '<button class="btn btn-success btn-sm ml-5 mt-1"
                onclick="ChangeApproved(' . $id . ')">  <span class="fa fa-check"></span>
                Approved</button>';

                        $Product->save();
                    } else {

                        return 1;
                    }
                }
            }
            return $view;
        }
    }


    ///Send Reason
    public function send_reason(Request $request)
    {

        if ($request->isMethod('post')) {

            $User = User::find($request->partner_id);
            $email         = $request->partner_email;
            $data = array('subject' => "Product Not Approval Reason", 'title' => "Product Not Approval Reason", 'email' => $request->partner_email, 'description' => $request->description, 'page' => 'email.product_reason', 'url' => env('APP_URL'));
            $partner_id = 0;
            if ($User) {
                $partner_id = $User->id;
            }

            $PartnerProductReason = new PartnerProductReason();
            $PartnerProductReason->product_id = $request->product_id;
            $PartnerProductReason->partner_id = $partner_id;
            $PartnerProductReason->reason =  $request->description;
            $PartnerProductReason->save();


            $send_mail = Admin::send_mail($data);

            return redirect(route('admin.get_products'))->withErrors(["success" => "Mail Send Successfully"]);
        } else {
            return view('admin.get_products');
        }
    }
}
