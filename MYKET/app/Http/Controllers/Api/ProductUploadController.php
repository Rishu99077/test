<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\ProductLocation;
use App\Models\ProductDescription;
use App\Models\ProductType;
use App\Models\Transportation;
use App\Models\ProductFoodDrink;
use App\Models\ProductTransportation;
use App\Models\ProductFoodDescription;
use App\Models\ProductFood;
use App\Models\Gear;
use App\Models\Media;
use App\Models\Inclusion;
use App\Models\Restriction;
use App\Models\ProductHighlight;
use App\Models\ProductHighlightDescription;
use App\Models\ProductInclusion;
use App\Models\ProductRestriction;
use App\Models\ProductInformation;
use App\Models\ProductInformationDescription;
use App\Models\ProductOptionPricingDescription;
use App\Models\Categories;
use App\Models\Interests;
use App\Models\TransportationDescription;
use App\Models\ProductAboutActivity;
use App\Models\ProductAboutActivityDescription;
use App\Models\ProductOption;
use App\Models\ProductOptionPricing;
use App\Models\ProductOptionDescription;
use App\Models\ProductOptionPricingDetails;
use App\Models\ProductOptionAddOnTiers;
use App\Models\ProductOptionPricingTiers;
use App\Models\ProductOptionAddOn;
use App\Models\ProductOptionAvailability;
use App\Models\ProductOptionDiscount;
use App\Models\TopAttraction;
use App\Models\SideBanner;
use App\Models\SideBannerDescription;
use App\Models\Countries;
use App\Models\States;
use App\Models\Cities;
use App\Models\User;
use App\Models\Admin;
use App\Models\RecommendedThings;
use App\Models\RecommendedThingsDescription;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use Image;

class ProductUploadController extends Controller
{
    public function upload_product(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";

        $req_fields = array();

        $req_fields['language']   = "required";
        $req_fields['currency']   = "required";
        $req_fields['token']   = "required";
        $req_fields['user_id']   = "required";


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
            $req_fields['city']               = "required";
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
                    $req_fields['gears_media']   = "required";
                }
            }
            $req_fields['inclusion']   = "required";
            $req_fields['highlight.*']   = "required";
        }

        if ($request->step == "nine") {

            $req_fields['information_title.*']        = "required";
            $req_fields['information_decscription.*'] = "required";
        }

        if ($request->step == "about") {
            $req_fields['about_activity_title.*']        = "required";
        }



        // Product Option Setup
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
                }
            }
        }

        // Product Option pricing
        if ($request->step == "option_pricing") {



            $req_fields['minimum_participant'] = "required";
            $req_fields['price_name']          = "required";
        }


        $errormsg = [
            "language"                     => translate("Language"),
            "currency"                     => translate("Currency"),
            "token"                        => translate("Token"),
            "user_id"                      => translate("User ID"),
            "product_type"                 => translate("Product Type"),
            "title"                        => translate("Title"),
            "refrence_code"                => translate("Refrence Code"),
            "set_address"                  => translate("Location"),
            "category"                     => translate("Category"),
            "description"                  => translate("Description"),
            "gears"                        => translate("Gears"),
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
            "gears_media"                  => translate("Gears or Media"),
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
            return response()->json(
                [
                    'status'  => false,
                    'message' => $validation->errors()->first(),
                ],
                402,
            );
        }

        $language_id = $request->language;
        $data = [];
        // Step One
        if ($request->step == "one") {
            $product             = new Product();
            $product->type       = $request->product_type;
            $product->partner_id = $request->user_id;
            $product->added_by   = 'partner';
            $product->slug       = createSlug('products', "No title");
            $product->save();

            $productID    = $product->id;
        } else {
            $productID = $request->tourId;
        }
        $data['tour_id'] = $productID;
        $data['option_id'] = 0;
        $Product  = Product::find($productID);


        // Step Two
        if ($request->step == "two") {

            $checkChangeStatus = 1;

            $product_type =  isset($request->product_title_type) ?  implode(",", $request->product_title_type) : '';
            $option_type  =  isset($request->product_option_type) ? $request->product_option_type : $Product->option_type;
            $interest = isset($request->interest) ? implode(",", $request->interest) : "";

            $recommended_tour     = $request->recommended_tour     == 'true' ? 'yes' : 'no';
            $awaits_for_you       = $request->awaits_for_you       == 'true' ? 'yes' : 'no';
            $cultural_experiences = $request->cultural_experiences == 'true' ? 'yes' : 'no';
            $cultural_attractions = $request->cultural_attractions == 'true' ? 'yes' : 'no';
            // dd($Product->product_type, $product_type);
            if (
                $Product->category             != $request->category ||
                $Product->reference_code       != $request->refrence_code ||
                $Product->duration_text        != $request->duration_text ||
                $Product->activity_text        != $request->activity_text ||
                $Product->not_on_sale          != $request->note_on_sale_date ||
                $Product->option_type          != $option_type ||
                $Product->product_type         != $product_type ||
                $Product->interest             != $interest ||
                $Product->recommended_tour     != $recommended_tour ||
                $Product->awaits_for_you       != $awaits_for_you ||
                $Product->cultural_experiences != $cultural_experiences ||
                $Product->cultural_attractions != $cultural_attractions ||
                $Product->country              != $request->country ||
                $Product->state                != $request->state ||
                $Product->city                 != $request->city

            ) {
                $checkChangeStatus = 0;
            }


            $Product->category             = $request->category;
            $Product->country              = $request->country;
            $Product->status               = $request->status;
            $Product->state                = $request->state;
            $Product->city                 = $request->city;
            $Product->reference_code       = $request->refrence_code;
            $Product->duration_text        = $request->duration_text;
            $Product->activity_text        = $request->activity_text;
            $Product->not_on_sale          = $request->note_on_sale_date;
            $Product->option_type          = $request->product_option_type;
            $Product->product_type         = isset($request->product_title_type) ?  implode(",", $request->product_title_type) : '';
            $Product->top_attraction       = isset($request->top_attraction) ?  implode(",", $request->top_attraction) : '';
            $Product->interest             = isset($request->interest) ? implode(",", $request->interest) : "";
            $Product->recommended_tour     = $request->recommended_tour     == 'true' ? 'yes' : 'no';
            $Product->awaits_for_you       = $request->awaits_for_you       == 'true' ? 'yes' : 'no';
            $Product->cultural_experiences = $request->cultural_experiences == 'true' ? 'yes' : 'no';
            $Product->cultural_attractions = $request->cultural_attractions == 'true' ? 'yes' : 'no';


            // dd("data");

            $ProductDescription            = ProductDescription::where(["product_id" => $productID, 'language_id' => $language_id])->first();
            if (!$ProductDescription) {
                $ProductDescription              = new ProductDescription();
                $Product->slug = createSlug('products', $request->title);
            }



            if (isset($request->title)) {

                if (
                    $ProductDescription->title       != $request->title ||
                    $ProductDescription->description != $request->description ||
                    $ProductDescription->language_id != $language_id
                ) {
                    $checkChangeStatus = 0;
                }


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

            if ($checkChangeStatus == 0) {
                $Product->is_approved          = 'Not approved';

                // Upload Email ---------------------
                $get_user = User::where(['id' => $request->user_id, 'user_type' => 'Partner'])->first();

                $get_product_desc = ProductDescription::where(['product_id' => $productID])->first();
                $product_name = '';
                if ($get_product_desc) {
                    $product_name = $get_product_desc->title;
                }

                $data_mail = array();
                $url  = env('APP_URL');
                $data_mail['username']       = $get_user->first_name . ' ' . $get_user->last_name;
                $data_mail['email']          = $get_user->email;
                $data_mail['product_name']   = $product_name;
                $data_mail['product_url']    = $url . 'tours-files/title/' . $productID;
                $data_mail['page']           = 'email.product_upload';
                SendProductUploadMail($data_mail, $Product);
            }
            $Product->save();
        }


        // Step Three

        if ($request->step == "three") {

            $Product->is_approved          = 'Not approved';

            // Upload Email ---------------------
            $get_user = User::where(['id' => $request->user_id, 'user_type' => 'Partner'])->first();

            $get_product_desc = ProductDescription::where(['product_id' => $productID])->first();
            $product_name = '';
            if ($get_product_desc) {
                $product_name = $get_product_desc->title;
            }

            $data_mail = array();
            $url  = env('APP_URL');
            $data_mail['username']       = $get_user->first_name . ' ' . $get_user->last_name;
            $data_mail['email']          = $get_user->email;
            $data_mail['product_name']   = $product_name;
            $data_mail['product_url']    = $url . 'tours-files/title/' . $productID;
            $data_mail['page']           = 'email.product_upload';
            SendProductUploadMail($data_mail, $Product);


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
                    $ProductLocation->latitude   = $request->address_latitude[$Addkey];
                    $ProductLocation->longitude  = $request->address_longitude[$Addkey];
                    $ProductLocation->save();
                }
            }
        }


        // step Four
        if ($request->step == "four") {
            $Product->transportation = $request->transportation;
            $Product->is_approved          = 'Not approved';

            // Upload Email ---------------------
            $get_user = User::where(['id' => $request->user_id, 'user_type' => 'Partner'])->first();

            $get_product_desc = ProductDescription::where(['product_id' => $productID])->first();
            $product_name = '';
            if ($get_product_desc) {
                $product_name = $get_product_desc->title;
            }

            $data_mail = array();
            $url  = env('APP_URL');
            $data_mail['username']       = $get_user->first_name . ' ' . $get_user->last_name;
            $data_mail['email']          = $get_user->email;
            $data_mail['product_name']   = $product_name;
            $data_mail['product_url']    = $url . 'tours-files/title/' . $productID;
            $data_mail['page']           = 'email.product_upload';
            SendProductUploadMail($data_mail, $Product);
        }

        // step Five
        if ($request->step == "five") {
            $Product->interact                     = $request->interact;
            $Product->customers_sleep_overnight    = $request->customers_sleep_overnight;
            $Product->accommodation_included_price = $request->accommodation_included_price;
            $Product->is_approved          = 'Not approved';

            // Upload Email ---------------------
            $get_user = User::where(['id' => $request->user_id, 'user_type' => 'Partner'])->first();

            $get_product_desc = ProductDescription::where(['product_id' => $productID])->first();
            $product_name = '';
            if ($get_product_desc) {
                $product_name = $get_product_desc->title;
            }

            $data_mail = array();
            $url  = env('APP_URL');
            $data_mail['username']       = $get_user->first_name . ' ' . $get_user->last_name;
            $data_mail['email']          = $get_user->email;
            $data_mail['product_name']   = $product_name;
            $data_mail['product_url']    = $url . 'tours-files/title/' . $productID;
            $data_mail['page']           = 'email.product_upload';
            SendProductUploadMail($data_mail, $Product);
        }

        // step Six
        if ($request->step == "six") {
            $Product->food_drink = $request->food_drink;
            $Product->is_approved          = 'Not approved';

            // Upload Email ---------------------
            $get_user = User::where(['id' => $request->user_id, 'user_type' => 'Partner'])->first();

            $get_product_desc = ProductDescription::where(['product_id' => $productID])->first();
            $product_name = '';
            if ($get_product_desc) {
                $product_name = $get_product_desc->title;
            }

            $data_mail = array();
            $url  = env('APP_URL');
            $data_mail['username']       = $get_user->first_name . ' ' . $get_user->last_name;
            $data_mail['email']          = $get_user->email;
            $data_mail['product_name']   = $product_name;
            $data_mail['product_url']    = $url . 'tours-files/title/' . $productID;
            $data_mail['page']           = 'email.product_upload';
            SendProductUploadMail($data_mail, $Product);
        }

        // Step Seven
        if ($request->step == 'seven') {
            $Product->is_approved          = 'Not approved';

            // Upload Email ---------------------
            $get_user = User::where(['id' => $request->user_id, 'user_type' => 'Partner'])->first();

            $get_product_desc = ProductDescription::where(['product_id' => $productID])->first();
            $product_name = '';
            if ($get_product_desc) {
                $product_name = $get_product_desc->title;
            }

            $data_mail = array();
            $url  = env('APP_URL');
            $data_mail['username']       = $get_user->first_name . ' ' . $get_user->last_name;
            $data_mail['email']          = $get_user->email;
            $data_mail['product_name']   = $product_name;
            $data_mail['product_url']    = $url . 'tours-files/title/' . $productID;
            $data_mail['page']           = 'email.product_upload';
            SendProductUploadMail($data_mail, $Product);

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
            $Product->save();
        }

        // Step Eight
        if ($request->step == "eight") {
            if (isset($request->keyword)) {
                $Product->is_approved          = 'Not approved';

                // Upload Email ---------------------
                $get_user = User::where(['id' => $request->user_id, 'user_type' => 'Partner'])->first();

                $get_product_desc = ProductDescription::where(['product_id' => $productID])->first();
                $product_name = '';
                if ($get_product_desc) {
                    $product_name = $get_product_desc->title;
                }

                $data_mail = array();
                $url  = env('APP_URL');
                $data_mail['username']       = $get_user->first_name . ' ' . $get_user->last_name;
                $data_mail['email']          = $get_user->email;
                $data_mail['product_name']   = $product_name;
                $data_mail['product_url']    = $url . 'tours-files/title/' . $productID;
                $data_mail['page']           = 'email.product_upload';
                SendProductUploadMail($data_mail, $Product);

                $ProductDescription = ProductDescription::where(["product_id" => $productID, 'language_id' => $language_id])->first();
                if ($ProductDescription) {
                    $ProductDescription->keyword = implode(',', $request->keyword);
                } else {
                    $ProductDescription = new ProductDescription();
                    $ProductDescription->product_id  = $productID;
                    $ProductDescription->language_id  = $language_id;
                    $ProductDescription->keyword = implode(',', $request->keyword);
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
                $Product->is_approved          = 'Not approved';

                // Upload Email ---------------------
                $get_user = User::where(['id' => $request->user_id, 'user_type' => 'Partner'])->first();

                $get_product_desc = ProductDescription::where(['product_id' => $productID])->first();
                $product_name = '';
                if ($get_product_desc) {
                    $product_name = $get_product_desc->title;
                }

                $data_mail = array();
                $url  = env('APP_URL');
                $data_mail['username']       = $get_user->first_name . ' ' . $get_user->last_name;
                $data_mail['email']          = $get_user->email;
                $data_mail['product_name']   = $product_name;
                $data_mail['product_url']    = $url . 'tours-files/title/' . $productID;
                $data_mail['page']           = 'email.product_upload';
                SendProductUploadMail($data_mail, $Product);


                if ($IT != "") {

                    if ($request->information_id[$ITkey] != "") {
                        $ProductInformation             = ProductInformation::find($request->information_id[$ITkey]);
                        $ProductInformationDescription                 = ProductInformationDescription::where(['information_id' => $request->information_id[$ITkey]])->first();
                    } else {
                        $ProductInformation            = new ProductInformation();
                        $ProductInformationDescription = new ProductInformationDescription();
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
                $image_id  = explode(',', $request->image_id);
                foreach ($Get_ProductImages as $key => $Get_ProductImages_delete) {
                    if (!in_array($Get_ProductImages_delete['id'], $image_id)) {
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
                    $Product->is_approved          = 'Not approved';

                    // Upload Email ---------------------
                    $get_user = User::where(['id' => $request->user_id, 'user_type' => 'Partner'])->first();

                    $get_product_desc = ProductDescription::where(['product_id' => $productID])->first();
                    $product_name = '';
                    if ($get_product_desc) {
                        $product_name = $get_product_desc->title;
                    }

                    $data_mail = array();
                    $url  = env('APP_URL');
                    $data_mail['username']       = $get_user->first_name . ' ' . $get_user->last_name;
                    $data_mail['email']          = $get_user->email;
                    $data_mail['product_name']   = $product_name;
                    $data_mail['product_url']    = $url . 'tours-files/title/' . $productID;
                    $data_mail['page']           = 'email.product_upload';
                    SendProductUploadMail($data_mail, $Product);

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

        // Step others
        // setp Others
        if ($request->step == "others") {
            $Product->is_approved          = 'Not approved';

            // Upload Email ---------------------
            $get_user = User::where(['id' => $request->user_id, 'user_type' => 'Partner'])->first();

            $get_product_desc = ProductDescription::where(['product_id' => $productID])->first();
            $product_name = '';
            if ($get_product_desc) {
                $product_name = $get_product_desc->title;
            }

            $data_mail = array();
            $url  = env('APP_URL');
            $data_mail['username']       = $get_user->first_name . ' ' . $get_user->last_name;
            $data_mail['email']          = $get_user->email;
            $data_mail['product_name']   = $product_name;
            $data_mail['product_url']    = $url . 'tours-files/title/' . $productID;
            $data_mail['page']           = 'email.product_upload';
            SendProductUploadMail($data_mail, $Product);

            if ($request->tourId != '') {
                $SideBanner    = SideBanner::where('product_id', $request->tourId)->first();
                if (!$SideBanner) {
                    $SideBanner    = new SideBanner();
                }
            } else {
                $SideBanner    = new SideBanner();
            }
            $SideBanner->product_id = $request->tourId;

            if ($request->hasFile('image')) {

                $file        = $request->file('image');

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
            $SideBanner->link   =  $request->link;
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

                $Product->video_url = $request->video_url;
            }
        }





        // step Create Option
        if ($request->step == "create_option") {
            $Product->is_approved      = 'Not approved';

            // Upload Email ---------------------
            $get_user = User::where(['id' => $request->user_id, 'user_type' => 'Partner'])->first();

            $get_product_desc = ProductDescription::where(['product_id' => $productID])->first();
            $product_name = '';
            if ($get_product_desc) {
                $product_name = $get_product_desc->title;
            }

            $data_mail = array();
            $url  = env('APP_URL');
            $data_mail['username']       = $get_user->first_name . ' ' . $get_user->last_name;
            $data_mail['email']          = $get_user->email;
            $data_mail['product_name']   = $product_name;
            $data_mail['product_url']    = $url . 'tours-files/title/' . $productID;
            $data_mail['page']           = 'email.product_upload';
            SendProductUploadMail($data_mail, $Product);

            $Product->option_type      = $request->option_type;
            $ProductOption             = new ProductOption();
            $ProductOption->product_id = $request->tourId;
            $ProductOption->save();
            $data['option_id'] = $ProductOption->id;
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
                $Product->is_approved          = 'Not approved';

                // Upload Email ---------------------
                $get_user = User::where(['id' => $request->user_id, 'user_type' => 'Partner'])->first();

                $get_product_desc = ProductDescription::where(['product_id' => $productID])->first();
                $product_name = '';
                if ($get_product_desc) {
                    $product_name = $get_product_desc->title;
                }

                $data_mail = array();
                $url  = env('APP_URL');
                $data_mail['username']       = $get_user->first_name . ' ' . $get_user->last_name;
                $data_mail['email']          = $get_user->email;
                $data_mail['product_name']   = $product_name;
                $data_mail['product_url']    = $url . 'tours-files/title/' . $productID;
                $data_mail['page']           = 'email.product_upload';
                SendProductUploadMail($data_mail, $Product);

                if ($AAT != "") {

                    if ($request->about_activity_id[$AAkey] != "") {
                        $ProductAboutActivity             = ProductAboutActivity::find($request->about_activity_id[$AAkey]);
                        $ProductAboutActivityDescription                 = ProductAboutActivityDescription::where(['about_activity_id' => $request->about_activity_id[$AAkey]])->first();
                    } else {
                        $ProductAboutActivity             = new ProductAboutActivity();
                        $ProductAboutActivityDescription             = new ProductAboutActivityDescription();
                    }

                    $ProductAboutActivity->product_id = $productID;



                    $photo  = $request->input('about_activity_image.' . $AAkey);

                    if (strlen($photo) > 128) {
                        list($ext, $Photodata)   = explode(';', $photo);
                        list(, $Photodata)       = explode(',', $Photodata);
                        $Photodata = base64_decode($Photodata);
                        $ext = explode('/', $ext)[1];
                        $random_no  = uniqid();
                        $fileName =  $random_no . '.' . $ext;

                        file_put_contents(public_path() . '/uploads/products/' . $fileName, $Photodata);
                        // file_put_contents(public_path('uploads/products') . $fileName, $data);
                        $ProductAboutActivity->image      = $fileName;
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


        // step Option Setup
        if ($request->step == "option_setup") {
            $Product->is_approved          = 'Not approved';

            // Upload Email ---------------------
            $get_user = User::where(['id' => $request->user_id, 'user_type' => 'Partner'])->first();

            $get_product_desc = ProductDescription::where(['product_id' => $productID])->first();
            $product_name = '';
            if ($get_product_desc) {
                $product_name = $get_product_desc->title;
            }

            $data_mail = array();
            $url  = env('APP_URL');
            $data_mail['username']       = $get_user->first_name . ' ' . $get_user->last_name;
            $data_mail['email']          = $get_user->email;
            $data_mail['product_name']   = $product_name;
            $data_mail['product_url']    = $url . 'tours-files/title/' . $productID;
            $data_mail['page']           = 'email.product_upload';
            SendProductUploadMail($data_mail, $Product);

            $checkOption = 0;
            if (isset($request->option_id)) {
                $ProductOption = ProductOption::find($request->option_id);
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

            $data['option_id'] = $optionId;
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


            $ProductOption->wheelchair_accessibility = $request->wheelchair_accessibility;
            $ProductOption->is_cancelled             = $request->is_cancelled;
            $ProductOption->cancelled_time           = $request->cancelled_time;
            $ProductOption->cancelled_type           = $request->cancelled_type;


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


        // Step Option Pricing 

        if ($request->step == "option_pricing") {

            $optionId = $request->optionId;
            $productID = $request->tourId;
            $pricing_id = $request->pricing_id;


            $data['option_id'] = $optionId;

            $ProductOption = ProductOption::find($optionId);

            if (isset($pricing_id)) {

                ProductOptionPricingDetails::where(['pricing_id' => $pricing_id])->delete();
                ProductOptionPricingTiers::where(['pricing_id' => $pricing_id])->delete();
                ProductOptionAddOn::where(['pricing_id' => $pricing_id])->delete();
                ProductOptionAddOnTiers::where(['pricing_id' => $pricing_id])->delete();
                ProductOptionPricingDescription::where(['pricing_id' => $pricing_id])->delete();
            }


            if ($ProductOption) {
                $ProductOption->pricing_type = $request->pricing_type;
                $ProductOption->save();
            }

            $commission = 30;
            if (isset($request->pricing_id)) {
                $ProductOptionPricing                       = ProductOptionPricing::find($request->pricing_id);
                if (!$ProductOptionPricing) {
                    $ProductOptionPricing                       = new ProductOptionPricing();
                }
            }

            $ProductOptionPricing->product_id           = $productID;
            $ProductOptionPricing->option_id            = $optionId;
            $ProductOptionPricing->pricing_type         = $request->pricing_type;
            $ProductOptionPricing->minimum_participants = $request->minimum_participant;

            $ProductOptionPricing->save();



            if (isset($request->price_name)) {
                $ProductOptionPricingDescription = new ProductOptionPricingDescription();
                $ProductOptionPricingDescription->product_id = $productID;
                $ProductOptionPricingDescription->option_id = $optionId;
                $ProductOptionPricingDescription->pricing_id = $ProductOptionPricing->id;
                $ProductOptionPricingDescription->language_id = $language_id;
                $ProductOptionPricingDescription->title = $request->price_name;

                $ProductOptionPricingDescription->save();
            }

            if (isset($request->prices)) {
                foreach ($request->prices as $key => $value) {
                    if ($key != "group") {
                        // dd($value);
                        $ProductOptionPricingDetails                   = new ProductOptionPricingDetails();

                        $ProductOptionPricingDetails->product_id       = $productID;
                        $ProductOptionPricingDetails->option_id        = $optionId;
                        $ProductOptionPricingDetails->pricing_id       = $ProductOptionPricing->id;
                        $ProductOptionPricingDetails->person_type      = $key;
                        $ProductOptionPricingDetails->from_age_range   = $value['age_from'];
                        $ProductOptionPricingDetails->age_range        = $value['age_to'];
                        $ProductOptionPricingDetails->booking_category = $booking_category = $value['booking_category'];
                        $ProductOptionPricingDetails->save();


                        foreach ($value['no_of_people'] as $Nkey => $NOP) {

                            $checkData = 0;
                            $ProductOptionPricingTiersDetails  = ProductOptionPricingTiers::where(['product_id' => $productID, 'option_id' => $optionId, 'pricing_id' => $ProductOptionPricing->id, 'pricing_details_id' => $ProductOptionPricingDetails->id, 'type' => $key])->first();
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
                            $ProductOptionPricingTiers->type               = $key;


                            if ($booking_category != "free_no_ticket" && $booking_category != "not_permitted") {
                                $ProductOptionPricingTiers->no_of_people      = $NOP['to'];
                                $ProductOptionPricingTiers->from_no_of_people = $NOP['from'];
                                $ProductOptionPricingTiers->retail_price      = $value['retail_price'][$Nkey];
                                if ($booking_category != "free") {
                                    $ProductOptionPricingTiers->currency           = "INR";
                                    $ProductOptionPricingTiers->commission         = $commission;
                                    $payout_calculate = $commission / 100 * $value['retail_price'][$Nkey];
                                    $ProductOptionPricingTiers->payout_per_person  =  $value['retail_price'][$Nkey] - $payout_calculate;
                                }
                            } else {

                                $ProductOptionPricingTiers->no_of_people      = $NOP['to'] == "" ? 51 : $NOP['to'];
                                $ProductOptionPricingTiers->from_no_of_people =  $NOP['from'] == "" ? 1 :  $NOP['from'];
                            }
                            if ($checkData == 0) {
                                $ProductOptionPricingTiers->save();
                            }
                        }
                    } else {
                        $ProductOptionPricingDetails                   = new ProductOptionPricingDetails();

                        $ProductOptionPricingDetails->product_id       = $productID;
                        $ProductOptionPricingDetails->option_id        = $optionId;
                        $ProductOptionPricingDetails->pricing_id       = $ProductOptionPricing->id;
                        $ProductOptionPricingDetails->person_type      = $key;
                        $ProductOptionPricingDetails->from_age_range   = 0;
                        $ProductOptionPricingDetails->age_range        = 0;
                        $ProductOptionPricingDetails->booking_category = $booking_category = 'none';
                        $ProductOptionPricingDetails->save();


                        foreach ($value['no_of_people'] as $Nkey => $NOP) {



                            $ProductOptionPricingTiers                     = new ProductOptionPricingTiers();
                            $ProductOptionPricingTiers->product_id         = $productID;
                            $ProductOptionPricingTiers->option_id          = $optionId;
                            $ProductOptionPricingTiers->pricing_id         = $ProductOptionPricing->id;
                            $ProductOptionPricingTiers->pricing_details_id = $ProductOptionPricingDetails->id;
                            $ProductOptionPricingTiers->type               = $key;



                            $ProductOptionPricingTiers->no_of_people      = $NOP['to'];
                            $ProductOptionPricingTiers->from_no_of_people = $NOP['from'];
                            $ProductOptionPricingTiers->retail_price      = $value['retail_price'][$Nkey];
                            $ProductOptionPricingTiers->currency           = "INR";
                            $ProductOptionPricingTiers->commission         = $commission;
                            $payout_calculate = $commission / 100 * $value['retail_price'][$Nkey];
                            $ProductOptionPricingTiers->payout_per_person  =  $value['retail_price'][$Nkey] - $payout_calculate;
                            $ProductOptionPricingTiers->save();
                        }
                    }
                }
            }
        }

        // Option Price Discount

        if ($request->step == 'option_pricing_discount') {

            $optionId   = $request->optionId;
            $productID  = $request->tourId;
            $pricing_id = $request->discountId;
            $data['option_id'] = $optionId;
            $ProductOptionDiscount = ProductOptionDiscount::where(["product_id" => $productID, 'pricing_id' => $pricing_id, 'option_id' => $optionId])->first();
            if (!$ProductOptionDiscount) {

                $ProductOptionDiscount             = new ProductOptionDiscount();
            }


            $ProductOptionDiscount->product_id      = $productID;
            $ProductOptionDiscount->option_id       = $optionId;
            $ProductOptionDiscount->valid_from      = $request->validity_from;
            $ProductOptionDiscount->valid_to        = $request->validity_to;
            $ProductOptionDiscount->date_percentage = $request->discount_percentage;
            $ProductOptionDiscount->pricing_id      = $pricing_id;


            $TimeArr = [];
            if (isset($request->weekly_discount)) {
                foreach ($request->weekly_discount as $key => $DD) {
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
            if (isset($request->unique_date)) {
                foreach ($request->unique_date as $key => $AD) {
                    if (isset($AD['date'])) {
                        $dateArr[$AD['date']] = $AD['discount'];
                    }
                }
                $ProductOptionDiscount->date_json   = json_encode($dateArr);
            } else {
                $ProductOptionDiscount->date_json = "";
            }
            $ProductOptionDiscount->save();
        }


        // Option Price Availability
        if ($request->step == 'option_pricing_availability') {

            $optionId   = $request->optionId;
            $productID  = $request->tourId;
            $pricing_id = $request->availabilityId;
            $data['option_id'] = $optionId;


            $ProductOptionAvailability = ProductOptionAvailability::where(["product_id" => $productID, 'pricing_id' => $pricing_id, 'option_id' => $optionId])->first();
            if (!$ProductOptionAvailability) {

                $ProductOptionAvailability             = new ProductOptionAvailability();
            }
            $ProductOptionAvailability->product_id = $productID;
            $ProductOptionAvailability->option_id  = $optionId;
            $ProductOptionAvailability->pricing_id = $pricing_id;
            $ProductOptionAvailability->valid_from = $request->validity_from;
            $ProductOptionAvailability->valid_to   = $request->validity_to;
            $ProductOptionAvailability->save();

            $TimeArr = [];
            if (isset($request->weekly_discount)) {
                foreach ($request->weekly_discount as $key => $WD) {

                    foreach ($WD as $Skey => $value) {

                        $getTimeArr = [];
                        $getTimeArr = $value['hr'] . ':' . $value['mi'];
                        $TimeArr[$key][] = $getTimeArr;
                    }
                }

                $ProductOptionAvailability->time_json   = json_encode($TimeArr);
                $ProductOptionAvailability->save();
            }

            $DateArr = [];
            if (isset($request->unique_date)) {

                foreach ($request->unique_date as $key => $UD) {
                    $date = "";
                    foreach ($UD as $Skey => $value) {

                        if ($Skey == "date") {
                            $date = $value;
                        }


                        if ($Skey == "time") {
                            if ($date != "") {

                                foreach ($value as $Vkey => $TV) {
                                    $getDateArr = [];
                                    $getDateArr = $TV['hr'] . ':' . $TV['mi'];
                                    $DateArr[$date][] = $getDateArr;
                                }
                            }
                        }
                    }
                }



                $ProductOptionAvailability->date_json   = json_encode($DateArr);
                $ProductOptionAvailability->save();
            }
        }

        if ($request->step == 'send_for_approval') {

            $Product->for_approvel = '1';
            $get_user = User::where(['id' => $request->user_id, 'user_type' => 'Partner'])->first();


            $get_product_desc = ProductDescription::where(['product_id' => $productID])->first();
            $product_name = '';
            if ($get_product_desc) {
                $product_name = $get_product_desc->title;
            }

            $data_mail = array();
            $url  = env('APP_URL');
            $data_mail['username']       = $get_user->first_name . ' ' . $get_user->last_name;
            $data_mail['email']          = $get_user->email;
            $data_mail['product_name']   = $product_name;
            $data_mail['product_url']    = $url . 'tours-files/title/' . $productID;
            $data_mail['page']           = 'email.product_upload';

            SendProductUploadMail($data_mail, $Product);
        }
        $Product->save();

        $output['data']        = $data;
        $output['status']      = true;
        $output['status_code'] = 200;
        $output['message']     = "Data fetched Successfully";
        return json_encode($output);
    }

    public  function get_product_data(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";

        $req_fields['language'] = "required";
        $req_fields['currency'] = "required";
        $req_fields['token']    = "required";
        $req_fields['user_id']  = "required";
        $req_fields['tourId']   = "required";
        $req_fields['type']     = "required";



        if ($request->type == 'option_setup' || $request->type == 'option_pricing') {
            $req_fields['optionId']     = "required";
        }



        $errormsg = [
            "language" => translate("Language"),
            "currency" => translate("Currency"),
            "token"    => translate("Token"),
            "user_id"  => translate("User ID"),
            "tourId"   => translate("Product ID"),
            "type"     => translate("Type"),
            "optionId" => translate("Option ID"),
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
            return response()->json(
                [
                    'status'  => false,
                    'message' => $validation->errors()->first(),
                ],
                402,
            );
        }

        $language_id = $request->language;
        $productID   = $request->tourId;
        $user_id     = $request->user_id;
        $type        = $request->type;
        $data        = [];
        $Product     = Product::where(['id' => $productID, 'partner_id' => $user_id, 'added_by' => 'partner'])->first();

        if ($Product) {
            if ($type == 'title') {

                // Categaory Array
                $get_category = Categories::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
                    ->get();

                $data['categories'] = array();
                if (!empty($get_category)) {
                    foreach ($get_category as $key => $value) {
                        $row  = getLanguageData('category_descriptions', $language_id, $value['id'], 'category_id');
                        $row['id']     = $value['id'];
                        $row['status'] = $value['status'];
                        $data['categories'][] = $row;
                    }
                }

                // Interest
                $get_interest = Interests::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
                    ->get();

                $data['interests'] = array();
                if (!empty($get_interest)) {
                    foreach ($get_interest as $key => $value) {
                        $row  = getLanguageData('interest_descriptions', $language_id, $value['id'], 'interest_id');
                        $row['id']     = $value['id'];
                        $row['status'] = $value['status'];
                        $data['interests'][] = $row;
                    }
                }


                // Product Type Array
                $get_product_type = ProductType::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
                    ->get();

                $data['product_type'] = [];
                if (!empty($get_product_type)) {
                    foreach ($get_product_type as $key => $value) {
                        $row  = getLanguageData('product_type_description', $language_id, $value['id'], 'product_type_id');
                        $row['id']     = $value['id'];
                        $row['status'] = $value['status'];
                        $data['product_type'][] = $row;
                    }
                }


                // SIdeBanner Array
                $get_sidebanner = SideBanner::orderBy('id', 'desc')->where(['status' => 'Active'])->get();
                $data['side_banner'] = [];

                if (!empty($get_sidebanner)) {
                    foreach ($get_sidebanner as $key => $value) {
                        $row  = getLanguageData('side_banner_description', $language_id, $value['id'], 'side_banner_id');
                        $row['id']     = $value['id'];
                        $row['status'] = $value['status'];
                        $row['image'] =  isset($value['image']) ? asset('uploads/products/' . $value['image']) : asset('uploads/placeholder/placeholder.png');
                        $data['side_banner'][] = $row;
                    }
                }


                // Top Attraction
                $get_top_attraction = TopAttraction::orderBy('id', 'desc')->where(['status' => 'Active', 'is_delete' => null])->get();
                $data['top_attraction'] = [];
                if (!empty($get_top_attraction)) {
                    foreach ($get_top_attraction as $key => $value) {
                        $row  = getLanguageData('top_attraction_description', $language_id, $value['id'], 'attraction_id');
                        $row['id']     = $value['id'];
                        $row['status'] = $value['status'];
                        $data['top_attraction'][] = $row;
                    }
                }



                $data['status'] = ['Active', 'Draft', 'Deactive'];

                $data['blackout_date'] = explode(',', $Product->not_on_sale);

                $data['product_data']               = $Product;

                $data['product_data']['interest'] = array_map('intval', explode(',', $Product->interest));
                $data['product_data']['product_type'] = array_map('intval', explode(',', $Product->product_type));
                $data['product_data']['top_attraction'] = array_map('intval', explode(',', $Product->top_attraction));
                $ProductDescription = ProductDescription::where(["product_id" => $productID, 'language_id' => $language_id])->first();
                if ($ProductDescription) {
                    $data['product_data']['title']       = $ProductDescription->title;
                    $data['product_data']['description'] = $ProductDescription->description;
                }
            }

            if ($type == 'location') {
                $data['google_key'] = get_setting_data('google_key', 'content');
                $data['product_data'] = [];
                $ProductLocation              = ProductLocation::where(['product_id' => $productID])->get();
                foreach ($ProductLocation as $key => $PL) {
                    $ProductLocationArr              = [];
                    $ProductLocationArr['id']        = $PL['id'];
                    $ProductLocationArr['address']   = $PL['address'];
                    $ProductLocationArr['latitude']  = $PL['latitude'];
                    $ProductLocationArr['longitude'] = $PL['longitude'];
                    $data['product_data'][]          = $ProductLocationArr;
                }
            }

            if ($type == 'transportation') {

                $data['product_data']['transportation'] = $Product->transportation == "" ? "no" : $Product->transportation;

                $ProductTransportation = ProductTransportation::where(["product_id" => $productID])->get();
                $data['product_data']['save_transportation'] = [];
                foreach ($ProductTransportation as $PTkey => $PT) {
                    $Transportation = Transportation::find($PT['transportation_id']);
                    $private_shared = "";
                    $capacity = "";
                    $air_conditioning = "";
                    $wifi = "";
                    if ($Transportation) {
                        $private_shared   = $Transportation->private_shared   == "no" ? "" : $Transportation->private_shared;
                        $capacity         = $Transportation->capacity         == "no" ? "" : $Transportation->capacity;
                        $air_conditioning = $Transportation->air_conditioning == "no" ? "" : $Transportation->air_conditioning;
                        $wifi             = $Transportation->wifi             == "no" ? "" : $Transportation->wifi;
                    }
                    $TransportationDescription = TransportationDescription::where(['transportation_id' => $PT['transportation_id'], 'language_id' => $language_id])->first();
                    if ($TransportationDescription) {
                        $row['title'] = $TransportationDescription->title;
                    }
                    $row['id']                                     = $PT['id'];
                    $row['capacity']                               = $capacity != "" ?  $PT['capacity']  : "";
                    $row['air_conditioning']                       = $air_conditioning != "" ? $PT['air_conditioning'] : "";
                    $row['wifi']                                   = $wifi  != "" ? $PT['wifi'] : "";
                    $row['private_shared']                         = $private_shared != ""  ? ucfirst($PT['private_shared']) : "";
                    $data['product_data']['save_transportation'][] = $row;
                }


                // Transporation Array
                $get_transportation = Transportation::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
                    ->get();

                $data['transportation_list'] = [];
                if (!empty($get_transportation)) {
                    foreach ($get_transportation as $key => $value) {
                        $row  = getLanguageData('transportation_description', $language_id, $value['id'], 'transportation_id');
                        $row['id']     = $value['id'];
                        $row['status'] = $value['status'];
                        $data['transportation_list'][] = $row;
                    }
                }
            }

            if ($type == 'guide') {
                $data['product_data']['interact'] = $Product->interact == '' ? 'NONE' : $Product->interact;
                $data['product_data']['customers_sleep_overnight'] = $Product->customers_sleep_overnight == "" ? 'no' : $Product->customers_sleep_overnight;
                $data['product_data']['accommodation_included_price'] = $Product->accommodation_included_price == "" ? "no" : $Product->accommodation_included_price;
            }

            if ($type == 'food_drink') {
                $data['product_data']['food_drink']      = $Product->food_drink == '' ? "no" : $Product->food_drink;
                $data['product_data']['save_food_drink'] = [];
                $ProductFoodDrink                        = ProductFoodDrink::where(['product_id' => $productID])->get();


                foreach ($ProductFoodDrink as $PFDkey => $PFD) {
                    $row = [];
                    $type_of_meal_description = ProductFoodDescription::where(['product_food_id' => $PFD['type_of_meal'], 'language_id' => $language_id])->first();

                    $time_of_day_description = ProductFoodDescription::where(['product_food_id' => $PFD['time_of_day'], 'language_id' => $language_id])->first();
                    $row['type_of_meal'] = '';
                    $drinks = '';
                    $row['product_food_drink_id'] = $PFD['id'];
                    if ($PFD['drink'] == 'yes') {
                        $row['type_of_meal'] = 'Drinks';
                    }
                    $row['time_of_day'] = '';
                    $plus = '';
                    if ($PFD['food'] == 'yes' && $PFD['drink'] == 'yes') {
                        $plus = ' + ';
                    }
                    if ($type_of_meal_description) {
                        $row['type_of_meal'] = $row['type_of_meal'] . $plus .  $type_of_meal_description->title;
                        $row['time_of_day']  = $type_of_meal_description->title;
                    }

                    if ($time_of_day_description) {
                        $row['time_of_day'] = $time_of_day_description->title;
                    }
                    if (isset($PFD['food_tags'])) {

                        $food_tags =  explode(',', $PFD['food_tags']);
                        $foodTagsArr                               = [];
                        foreach ($food_tags as $key => $FT) {

                            $foogTags = ProductFoodDescription::where(['product_food_id' => $FT, 'language_id' => $language_id])->first();
                            if ($foogTags) {
                                $foodTagsArr[] = $foogTags->title;
                            }
                        }
                        $row['foodTagArr'] = implode(',', $foodTagsArr);
                    }

                    if (isset($PFD['drink_tags'])) {
                        $drink_tags = explode(',', $PFD['drink_tags']);
                        $drinkTagsArr                            = [];
                        foreach ($drink_tags as $key => $DT) {

                            $drinkTags = ProductFoodDescription::where(['product_food_id' => $DT, 'language_id' => $language_id])->first();
                            if ($drinkTags) {
                                $drinkTagsArr[] = $drinkTags->title;
                            }
                        }
                        $row['drink'] = $PFD['drink'];
                        $row['food'] = $PFD['food'];
                        $row['drinkTagArr'] = implode(',', $drinkTagsArr);
                    }

                    $data['product_data']['save_food_drink'][] = $row;
                }
            }

            if ($type == 'inclusion') {
                // Gear Array
                $get_gears = Gear::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
                    ->get();

                $data['gears'] = [];
                if (!empty($get_gears)) {
                    foreach ($get_gears as $key => $value) {
                        $row  = getLanguageData('gear_descriptions', $language_id, $value['id'], 'gear_id');
                        $row['id']     = $value['id'];
                        $row['status'] = $value['status'];
                        $data['gears'][] = $row;
                    }
                }

                // Media Array
                $get_media = Media::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
                    ->paginate(config('adminconfig.records_per_page'));

                $data['media'] = [];
                if (!empty($get_media)) {
                    foreach ($get_media as $key => $value) {
                        $row  = getLanguageData('media_descriptions', $language_id, $value['id'], 'media_id');
                        $row['id']     = $value['id'];
                        $row['status'] = $value['status'];
                        $data['media'][] = $row;
                    }
                }


                // Inclusion Array
                $get_inclusion = Inclusion::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
                    ->get();

                $data['inclusion'] = [];
                if (!empty($get_inclusion)) {
                    foreach ($get_inclusion as $key => $value) {
                        $row  = getLanguageData('inclusion_descriptions', $language_id, $value['id'], 'inclusion_id');
                        $row['id']     = $value['id'];
                        $row['status'] = $value['status'];
                        $data['inclusion'][] = $row;
                    }
                }

                // Restriction Array
                $get_restriction = Restriction::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
                    ->get();

                $data['restriction'] = [];
                if (!empty($get_restriction)) {
                    foreach ($get_restriction as $key => $value) {
                        $row  = getLanguageData('restriction_descriptions', $language_id, $value['id'], 'restriction_id');
                        $row['id']     = $value['id'];
                        $row['status'] = $value['status'];
                        $row['image']  = $value['image'];
                        $data['restriction'][] = $row;
                    }
                }
                $data['product_data'] = [];
                $ProductInclusion     = ProductInclusion::where(["product_id" => $productID])->get();
                $RestrictionData      = ProductRestriction::where(["product_id" => $productID])->get();
                $Gears                = [];
                $Media                = [];
                $Inclusion            = [];
                $Restriction          = [];
                foreach ($ProductInclusion as $PI) {
                    if ($PI['type'] == 'gear') {
                        $Gears[] = $PI['type_id'];
                    }

                    if ($PI['type'] == 'media') {
                        $Media[] = $PI['type_id'];
                    }

                    if ($PI['type'] == 'inclusion') {
                        $Inclusion[] = $PI['type_id'];
                    }
                }
                $data['product_data']['gears']     = $Gears;
                $data['product_data']['media']     = $Media;
                $data['product_data']['inclusion'] = $Inclusion;
                $data['product_data']['gear_media'] = $Product->gear_media == '' ? 'no' : $Product->gear_media;

                foreach ($RestrictionData as $RD) {
                    $Restriction[] = $RD['restriction_id'];
                }
                $data['product_data']['restriction'] = $Restriction;
                $data['product_data']['highlight_id'] = [];
                $data['product_data']['highlight'] = [];
                $ProductHighlight =  ProductHighlight::where(["product_id" => $productID])->get();

                if (count($ProductHighlight) == 0) {
                    $data['product_data']['highlight_id'] = [''];
                    $data['product_data']['highlight'] = ['Enter Highlight'];
                }

                foreach ($ProductHighlight as $key => $PH) {

                    $data['product_data']['highlight_id'][] = $PH['id'];
                    $ProductHighlightDescription = ProductHighlightDescription::where(['highlight_id' => $PH['id'], 'language_id' => $language_id])->first();
                    if ($ProductHighlightDescription) {
                        $data['product_data']['highlight'][] = $ProductHighlightDescription->title;
                    }

                    // getLanguageData('product_highlight_description', $language_id, $PH['id'], 'highlight_id');
                }
            }

            if ($type == 'keyword') {
                $ProductDescription = ProductDescription::where(["product_id" => $productID, 'language_id' => $language_id])->first();
                $data['product_data']['keyword'] = '';
                if ($ProductDescription) {

                    if ($ProductDescription->keyword != "") {
                        $data['product_data']['keyword'] = explode(',', $ProductDescription->keyword);
                    }
                }
            }

            if ($type == 'information') {

                $ProductInformation = ProductInformation::where(["product_id" => $productID])->get();
                $data['product_data']['information_id'] = [];
                $data['product_data']['information_title'] = [];
                $data['product_data']['information_decscription'] = [];
                if (count($ProductInformation) == 0) {
                    $data['product_data']['information_id'] = [''];
                    $data['product_data']['information_title'] = ['Enter Title'];
                    $data['product_data']['information_decscription'] = [''];
                }

                foreach ($ProductInformation as $key => $PI) {
                    $row  = getLanguageData('product_important_information_description', $language_id, $PI['id'], 'information_id');
                    $ProductInformationDescription = ProductInformationDescription::where(['information_id' => $PI['id'], 'language_id' => $language_id])->first();
                    $data['product_data']['information_id'][] =  $PI['id'];
                    if ($ProductInformationDescription) {

                        $data['product_data']['information_title'][]       = $ProductInformationDescription->title;
                        $data['product_data']['information_decscription'][] = $ProductInformationDescription->description;
                    }
                }
            }

            if ($type == "image") {

                $data['product_data']['image_text'] = '';
                $ProductDescription = ProductDescription::where(["product_id" => $productID, 'language_id' => $language_id])->first();
                if ($ProductDescription) {
                    $data['product_data']['image_text'] = $ProductDescription->image_text;
                }

                $cover_image = asset('uploads/placeholder/placeholder.png');
                if ($Product->cover_image != '') {
                    $cover_image = url('uploads/products', $Product->cover_image);
                }
                $data['product_data']['cover_image'] = $cover_image;

                $data['product_data']['images'] = [];


                $ProductImages = ProductImages::where(["product_id" => $productID])->get();

                foreach ($ProductImages as $key => $PI) {
                    $imageArr = [];
                    $imageArr['id'] = $PI['id'];
                    $imageArr['image'] = asset('uploads/products/' . $PI['image']);
                    $data['product_data']['images'][] = $imageArr;
                }
            }

            if ($type == "about") {
                $ProductAboutActivity =  ProductAboutActivity::where(["product_id" => $productID])->get();
                $data['product_data']['about_activity_id'] = [];
                $data['product_data']['about_activity_image'] = [];
                $data['product_data']['about_activity_title'] = [];
                $data['product_data']['about_activity_decscription'] = [];
                if (count($ProductAboutActivity) == 0) {
                    $data['product_data']['about_activity_id'] = [''];
                    $data['product_data']['about_activity_image'] = [''];
                    $data['product_data']['about_activity_title'] = ['Enter Title'];
                    $data['product_data']['about_activity_decscription'] = [''];
                }

                foreach ($ProductAboutActivity as $key => $PAA) {
                    $ProductAboutActivityDescription  = ProductAboutActivityDescription::where(['about_activity_id' => $PAA['id'], 'language_id' => $language_id])->first();
                    $about_image = asset('uploads/placeholder/placeholder.png');
                    if ($PAA['image'] != '') {
                        $about_image = url('uploads/products', $PAA['image']);
                    }
                    if ($ProductAboutActivityDescription) {
                        $data['product_data']['about_activity_title'][]        = $ProductAboutActivityDescription->title;
                        $data['product_data']['about_activity_decscription'][] = $ProductAboutActivityDescription->short_description;
                    }
                    $data['product_data']['about_activity_image'][] = $about_image;
                    $data['product_data']['about_activity_id'][]    = $PAA['id'];
                }
            }

            if ($type == "others") {
                $SideBanner = SideBanner::where(["product_id" => $productID])->first();
                $data['product_data']['side_banner_title'] = '';
                $data['product_data']['side_banner_description'] = '';
                $SideBannerDescription = SideBannerDescription::where(["product_id" => $productID, 'language_id' => $language_id])->first();
                if ($SideBannerDescription) {
                    $data['product_data']['side_banner_title'] = $SideBannerDescription->title;
                    $data['product_data']['side_banner_description'] = $SideBannerDescription->description;
                }

                $data['product_data']['image'] = asset('uploads/placeholder/placeholder.png');
                $data['product_data']['link'] = '';
                $data['product_data']['video_url'] = '';
                $data['product_data']['thumbnail_image'] = asset('uploads/placeholder/placeholder.png');
                if ($SideBanner) {
                    $data['product_data']['image']                 = url('uploads/products', $SideBanner->image);
                    $data['product_data']['link']                  = $SideBanner->link;
                    $data['product_data']['video_url']             = $Product->video_url;
                    $data['product_data']['thumbnail_image'] = url('uploads/products', $Product->video_thumbnail_image);
                }
            }

            if ($type == "option") {
                $data['product_data']['option_type'] = $Product->option_type == "" ? 'multiple' : $Product->option_type;
                $data['product_data']['option_list'] = [];
                $ProductOption =  ProductOption::where(["product_id" => $productID])->get();
                foreach ($ProductOption as $key => $PO) {
                    $ProductOptionDescription    = ProductOptionDescription::where(['product_id' => $PO['product_id'], 'option_id' => $PO['id'], 'language_id' => $language_id])->first();
                    $optionArr                   = [];
                    $optionArr['refrence_code']  = $PO['reference_code'] != "" ?  $PO['reference_code'] : 'Default';
                    $optionArr['title']          = $ProductOptionDescription  ? $ProductOptionDescription->title : 'Not specified';
                    $optionArr['option_id']      = $PO['id'];
                    $optionArr['status']         = 'Temprory';
                    $optionArr['booking_engine'] = 'Automatically accept new bookings';
                    $optionArr['cut_off_time']   = $PO['cut_off_time']   != '' ? $PO['cut_off_time'] . ' Minutes' : '';
                    $optionArr['type']           = $PO['is_private'];

                    $data['product_data']['option_list'][] = $optionArr;
                }
            }

            if ($type == 'option_setup') {
                $optionId = $request->optionId;
                $ProductOption = ProductOption::where(["id" => $optionId])->first();
                if ($ProductOption) {
                    $data['existing_line_type']['ticket_line']                    = 'Skip the line to get tickets';
                    $data['existing_line_type']['through_separate_entrance']      = 'Skip the line through a separate entrance';
                    $data['existing_line_type']['through_express_security_check'] = 'Skip the line through express security check';
                    $data['existing_line_type']['through_express_elevators']      = 'Skip the line through express elevators ';

                    $data['validity_type']['time_booked']    = 'Valid for a period of time from date booked';
                    $data['validity_type']['time_activated'] = 'Valid for a period of time from first activation';
                    $data['validity_type']['time_selected']  = 'Valid on the date booked';

                    $data['time_type']['minute'] = 'Minute(s)';
                    $data['time_type']['hour']   = 'Hour(s)';
                    $data['time_type']['day']    = 'Day(s)';

                    for ($i = 0; $i <= 18; $i++) {
                        $data['cut_off_time'][$i * 5] = $i * 5  . " Minutes";
                    }
                    $data['product_data']['option_setup'] = getTableColumn('product_option');
                    $data['product_data']['option_setup']['title'] = '';
                    $data['product_data']['option_setup']['descrpition'] = '';

                    $data['product_data']['option_setup'] =  $ProductOption;

                    $ProductOptionDescription     = ProductOptionDescription::where(['product_id' => $productID, 'option_id' => $optionId, 'language_id' => $language_id])->first();
                    if ($ProductOptionDescription) {
                        $data['product_data']['option_setup']['title'] = $ProductOptionDescription->title;
                        $data['product_data']['option_setup']['description'] = $ProductOptionDescription->description;
                    }
                } else {
                    $output['option'] = 0;
                }
            }

            if ($type == 'option_pricing') {
                $optionId = $request->optionId;
                $ProductOption = ProductOption::where(["id" => $optionId])->first();
                if ($ProductOption) {
                    $data['product_data']['option_pricing_list'] = '';
                    $data['product_data']['pricing_type'] = 'person';

                    $data['product_data']['pricing_type'] = $pricing_type = isset($ProductOption->pricing_type)  ? $ProductOption->pricing_type : 'person';
                    $ProductOptionPricingList          = ProductOptionPricing::where(['product_id' => $productID, 'option_id' => $optionId, 'pricing_type' => $pricing_type])->first();
                    if ($ProductOptionPricingList) {
                        $ProductOptionPricingDescription = ProductOptionPricingDescription::where(['pricing_id' => $ProductOptionPricingList->id, 'language_id' => $language_id])->first();
                        // $data['product_data']['option_pricing_list']['title'] = 'Data';
                        $data['product_data']['option_pricing_list'] = $ProductOptionPricingList;
                        $title = '';
                        if ($ProductOptionPricingDescription) {
                            $title = $ProductOptionPricingDescription->title;
                        }
                        $data['product_data']['option_pricing_list']['title'] = $title;
                    }
                } else {
                    $output['option'] = 0;
                }
            }

            if ($type == 'add_edit_option_pricing') {
                $optionId = $request->optionId;
                $option_pricing_id = 0;
                if (isset($request->option_pricing_id)) {
                    $option_pricing_id = $request->option_pricing_id;
                }

                $data['product_data']['title'] = '';
                $data['product_data']['minimum_participant'] = '';


                $data['product_data']['prices'] = [];

                if ($request->pricing_type == 'person') {

                    $age_group =  ['child', 'infant'];
                }
                $existing_age_group = [];

                $ProductOptionPricingDescription = ProductOptionPricingDescription::where(['pricing_id' => $option_pricing_id, 'language_id' => $language_id])->first();

                $ProductOptionPricing            = ProductOptionPricing::where(['id' => $option_pricing_id])->first();
                if ($ProductOptionPricing) {
                    $data['product_data']['minimum_participant'] = $ProductOptionPricing->minimum_participants;
                }
                if ($ProductOptionPricingDescription) {
                    $data['product_data']['title'] = $ProductOptionPricingDescription->title;
                }

                $data['product_data']['prices'] = [];
                if ($request->pricing_type == 'person') {
                    $data['product_data']['prices']['adult']['age_from'] = 0;
                    $data['product_data']['prices']['adult']['age_to'] = 99;
                    $data['product_data']['prices']['adult']['booking_category'] = 'standard';
                    $data['product_data']['prices']['adult']['no_of_people'][] =  [
                        'from' => 1,
                        'to' => 51
                    ];
                    $data['product_data']['prices']['adult']['retail_price'] =  [0];
                    $data['product_data']['prices']['adult']['commission'] =  [30];
                    $data['product_data']['prices']['adult']['payout_per_person'] =  [0];
                } else {
                    $data['product_data']['prices']['group']['age_from'] = 0;
                    $data['product_data']['prices']['group']['age_to'] = 0;
                    $data['product_data']['prices']['group']['booking_category'] = 'none';
                    $data['product_data']['prices']['group']['no_of_people'][] =  [
                        'from' => 1,
                        'to' => 51
                    ];
                    $data['product_data']['prices']['group']['retail_price'] =  [0];
                    $data['product_data']['prices']['group']['commission'] =  [30];
                    $data['product_data']['prices']['group']['payout_per_person'] =  [0];
                }



                $ProductOptionPricingDetails = ProductOptionPricingDetails::where(['product_id' => $productID, 'option_id' => $optionId, 'pricing_id' => $option_pricing_id])->orderBy('person_type', 'ASC')->get();


                // $ProductOptionPricingDetails = $ProductOptionPricingDetails->reverse();
                foreach ($ProductOptionPricingDetails as $POPDkey => $POPD) {
                    $PriceArr                                               = [];

                    if ($request->pricing_type == 'person') {
                        $PriceArr['age_from']                                   = (int)$POPD['from_age_range'];
                        $PriceArr['age_to']                                     = (int)$POPD['age_range'];
                        $PriceArr['booking_category']                           = $POPD['booking_category'];
                    } else {
                        $POPD['person_type'] = 'group';
                    }

                    $ProductOptionPricingTiers = ProductOptionPricingTiers::where(['product_id' => $productID, 'option_id' => $optionId, 'pricing_id' => $option_pricing_id, 'pricing_details_id' => $POPD['id']])->get();
                    $PriceArr['no_of_people'] = [];
                    $PriceArr['retail_price'] = [];

                    foreach ($ProductOptionPricingTiers as $POPTkey => $POPT) {
                        $PriceTierArr = [];

                        $PriceTierArr['from'] = $POPT['from_no_of_people'];
                        $PriceTierArr['to'] = $POPT['no_of_people'];
                        $PriceArr['no_of_people'][] = $PriceTierArr;


                        $PriceArr['retail_price'][] = $POPT['retail_price'] == "" ? 0 : $POPT['retail_price'];
                        $PriceArr['commission'][] = $POPT['commission'] == '' ? 30 : $POPT['commission'];
                        $PriceArr['payout_per_person'][] = $POPT['payout_per_person'] == '' ? 0 : $POPT['payout_per_person'];
                    }

                    $existing_age_group[] = $POPD['person_type'];
                    $data['product_data']['prices'][$POPD['person_type']] = $PriceArr;
                }
                $data['product_data']['prices']  = array_reverse($data['product_data']['prices']);
                if ($request->pricing_type == 'person') {
                    $data['product_data']['age_group'] = array_values(array_diff($age_group, $existing_age_group));
                }
            }

            if ($type == 'add_edit_option_discount') {

                $optionId = $request->optionId;
                $option_pricing_id = 0;
                if (isset($request->option_pricing_id)) {
                    $option_pricing_id = $request->option_pricing_id;
                }
                $data['product_data']['id'] = '';
                $data['product_data']['pricing_id'] = $option_pricing_id;
                $ProductOptionDiscount                       = $ProductOptionDiscount = ProductOptionDiscount::where(["product_id" => $productID, 'pricing_id' => $option_pricing_id, 'option_id' => $optionId])->first();
                $data['product_data']['validity_from']       = '';
                $data['product_data']['validity_to']         = '';
                $data['product_data']['discount_percentage'] = '';
                $data['product_data']['weekly_discount'] = '';
                $data['product_data']['unique_date'] = '';
                if ($ProductOptionDiscount) {

                    $data['product_data']['validity_from']       = date("Y-m-d", strtotime($ProductOptionDiscount->valid_from));
                    $data['product_data']['validity_to']         = date("Y-m-d", strtotime($ProductOptionDiscount->valid_to));
                    $data['product_data']['discount_percentage'] = $ProductOptionDiscount->date_percentage;
                    $data['product_data']['weekly_discount'] = json_decode($ProductOptionDiscount->time_json);
                    $date_json = json_decode($ProductOptionDiscount->date_json);
                    $dateJsonArr = [];
                    if ($date_json) {
                        foreach ($date_json as $DJkey => $DJ) {
                            $rowArr = [];
                            $rowArr['date'] = $DJkey;
                            $rowArr['discount'] = $DJ;
                            $dateJsonArr[] = $rowArr;
                        }
                    }
                    $data['product_data']['unique_date'] = $dateJsonArr;
                }
            }

            if ($type == "add_edit_option_availability") {
                $optionId = $request->optionId;
                $option_pricing_id = 0;
                if (isset($request->option_pricing_id)) {
                    $option_pricing_id = $request->option_pricing_id;
                }
                $data['product_data']['id'] = '';
                $data['product_data']['pricing_id'] = $option_pricing_id;
                $ProductOptionAvailability = ProductOptionAvailability::where(["product_id" => $productID, 'pricing_id' => $option_pricing_id, 'option_id' => $optionId])->first();
                if ($ProductOptionAvailability) {
                    $data['product_data']['validity_from']       = date("Y-m-d", strtotime($ProductOptionAvailability->valid_from));
                    $data['product_data']['validity_to']         = date("Y-m-d", strtotime($ProductOptionAvailability->valid_to));
                    $time_json  = json_decode($ProductOptionAvailability->time_json);

                    $timeJsonArr = [];
                    if ($time_json) {
                        foreach ($time_json as $TJkey => $TJ) {
                            $timeArr = [];
                            foreach ($TJ as $TJNkey => $TJN) {
                                $newTime = explode(":", $TJN);
                                $timeArr['hr'] = $newTime[0];
                                $timeArr['mi'] = $newTime[1];
                                $timeJsonArr[$TJkey][] = $timeArr;
                            }
                        }
                    }
                    $data['product_data']['weekly_discount'] = $timeJsonArr;

                    $date_json = json_decode($ProductOptionAvailability->date_json);
                    $dateJsonArr = [];
                    if ($date_json) {
                        foreach ($date_json as $DJkey => $DJ) {
                            $rowArr = [];
                            $newArr = [];
                            $newArr['date'] = $DJkey;
                            $newArr['time'] = [];

                            foreach ($DJ as $DJNkey => $DJN) {
                                $newDate = explode(":", $DJN);
                                $rowArr['hr'] = $newDate[0];
                                $rowArr['mi'] = $newDate[1];
                                $newArr['time'][] = $rowArr;
                            }
                            $dateJsonArr[] = $newArr;
                        }
                    }
                    $data['product_data']['unique_date'] = $dateJsonArr;
                }
            }
        }
        $output['status']      = true;
        if (count($data) == 0) {
            $data = '';
            $output['status']      = false;
        }
        // if(is_em)
        $output['data']        = $data;

        $output['status_code'] = 200;
        $output['message']     = "Data fetched Successfully";
        return json_encode($output);
    }


    // get Transportation Modal View
    public function get_transportation_modal_view(Request $request)
    {

        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";

        $req_fields['language']          = "required";
        $req_fields['currency']          = "required";
        $req_fields['token']             = "required";
        $req_fields['user_id']           = "required";
        $req_fields['tourId']            = "required";
        // $req_fields['transportation_id'] = "required";



        $errormsg = [
            "language"          => translate("Language"),
            "currency"          => translate("Currency"),
            "token"             => translate("Token"),
            "user_id"           => translate("User ID"),
            "tourId"            => translate("Product ID"),
            // "transportation_id" => translate("Select Transport"),

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
            return response()->json(
                [
                    'status'  => false,
                    'message' => $validation->errors()->first(),
                ],
                402,
            );
        }

        $language_id = $request->language;
        $productID   = $request->tourId;
        $user_id     = $request->user_id;
        $TransportationId = $request->transportation_id;
        $data['transportation'] = getTableColumn('transportation');
        $data['product_transportation'] =  getTableColumn('products_transportation');
        $data['transportation'] = $Transportation = Transportation::where('id', $TransportationId)->first();
        if (isset($request->product_transportation_id)) {
            $data['product_transportation'] = $ProductTransportation = ProductTransportation::find($request->product_transportation_id);
            if ($ProductTransportation) {
                if ($TransportationId > 0) {
                    $data['transportation'] = $Transportation = Transportation::where('id', $TransportationId)->first();
                    $data['product_transportation']['transportation_id'] = $TransportationId;
                } else {
                    $data['transportation'] = $Transportation = Transportation::where('id', $ProductTransportation->transportation_id)->first();
                }
            } else {
                $data['product_transportation'] =  getTableColumn('products_transportation');
                $data['product_transportation']['transportation_id'] = $TransportationId;
                $data['product_transportation']['private_shared'] = 'no';
                $data['product_transportation']['air_conditioning'] = 'no';
                $data['product_transportation']['wifi'] = 'no';
            }
        } else {
            $data['product_transportation']['transportation_id'] = $TransportationId;
            $data['product_transportation']['private_shared'] = 'no';
            $data['product_transportation']['air_conditioning'] = 'no';
            $data['product_transportation']['wifi'] = 'no';
        }

        $output['data']        = $data;
        $output['status']      = true;
        $output['status_code'] = 200;
        $output['message']     = "Data fetched Successfully";
        return json_encode($output);
    }

    // Add product Transportation

    public function add_product_transportation(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";

        $req_fields['language']          = "required";
        $req_fields['currency']          = "required";
        $req_fields['token']             = "required";
        $req_fields['user_id']           = "required";
        $req_fields['tourId']            = "required";
        if (!isset($request->is_remove)) {

            $req_fields['transportation_id'] = "required";
        }
        if (isset($request->capacity)) {
            $req_fields['capacity'] = "required";
        }



        $errormsg = [
            "language"          => translate("Language"),
            "currency"          => translate("Currency"),
            "token"             => translate("Token"),
            "user_id"           => translate("User ID"),
            "tourId"            => translate("Product ID"),
            "transportation_id" => translate("Select Transport"),
            "capacity"          => translate("Capacity"),

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
            return response()->json(
                [
                    'status'  => false,
                    'message' => $validation->errors()->first(),
                ],
                402,
            );
        }

        $language_id = $request->language;
        $productID   = $request->tourId;
        $user_id     = $request->user_id;


        $Product = Product::where(['id' => $productID, 'partner_id' => $user_id, 'added_by' => 'partner'])->first();
        $Product->is_approved          = 'Not approved';
        $Product->transportation = 'yes';
        $Product->save();

        $is_edit = 0;
        if (isset($request->is_remove)) {
            ProductTransportation::where("id", $request->product_transportation_id)->delete();
            $output['message']     = "Transport Delete Successfully...";
        } else {

            if ($request->product_transportation_id != "") {
                $is_edit = $request->product_transportation_id;
                $ProductTransportation                    =  ProductTransportation::find($request->product_transportation_id);
                $output['message']     = "Transport Update Successfully...";
                if (!$ProductTransportation) {
                    $ProductTransportation                    = new ProductTransportation();
                }
            } else {
                $ProductTransportation                    = new ProductTransportation();
                $output['message']     = "Transport Add Successfully...";
            }
            $ProductTransportation->product_id        = $request->tourId;
            $ProductTransportation->transportation_id = $request->transportation_id;
            $ProductTransportation->capacity          = isset($request->capacity) ? $request->capacity : 0;
            $ProductTransportation->air_conditioning  = isset($request->air_conditioning) ? $request->air_conditioning : "none";
            $ProductTransportation->wifi              = isset($request->wifi) ? $request->wifi : "none";
            $ProductTransportation->private_shared    = isset($request->private_shared) ? $request->private_shared : "none";
            $ProductTransportation->save();
        }
        $output['status']      = true;
        $output['status_code'] = 200;
        return json_encode($output);
    }


    // Get Food Drink Modal View
    public function get_food_drink_modal_view(Request $request)
    {

        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";

        $req_fields['language'] = "required";
        $req_fields['currency'] = "required";
        $req_fields['token']    = "required";
        $req_fields['user_id']  = "required";
        $req_fields['tourId']   = "required";
        $req_fields['fd_type']  = "required";

        $errormsg = [
            "language" => translate("Language"),
            "currency" => translate("Currency"),
            "token"    => translate("Token"),
            "user_id"  => translate("User ID"),
            "tourId"   => translate("Product ID"),
            "fd_type"  => translate("Choose Type"),

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
            return response()->json(
                [
                    'status'  => false,
                    'message' => $validation->errors()->first(),
                ],
                402,
            );
        }
        $language_id = $request->language;
        $productID   = $request->tourId;
        $user_id     = $request->user_id;
        $type        = $request->fd_type;
        $data = [];
        if ($type == 'food' || $type == 'edit') {
            $ProductFood = ProductFood::where(['type' => 'type_of_meal'])->where(['status' => 'Active'])->whereNull('is_delete')->get();
            $data['products_food_desc'] = [];
            if (!empty($ProductFood)) {
                foreach ($ProductFood as $key => $PF) {
                    $row  = getLanguageData('products_food_descriptions', $language_id, $PF['id'], 'product_food_id');
                    $data['products_food_desc'][] = $row;
                }
            }

            $ProductTime = ProductFood::where(['type' => 'time_of_day'])->where(['status' => 'Active'])->whereNull('is_delete')->get();
            $data['products_time_desc'] = [];
            if (!empty($ProductTime)) {
                foreach ($ProductTime as $key => $PT) {
                    $row  = getLanguageData('products_food_descriptions', $language_id, $PT['id'], 'product_food_id');
                    $data['products_time_desc'][] = $row;
                }
            }
            $ProductFoodTags = ProductFood::where(['type' => 'food_tags'])->where(['status' => 'Active'])->whereNull('is_delete')->get();
            $data['products_food_tags_desc'] = [];
            if (!empty($ProductFoodTags)) {
                foreach ($ProductFoodTags as $key => $PFT) {
                    $row  = getLanguageData('products_food_descriptions', $language_id, $PFT['id'], 'product_food_id');
                    $data['products_food_tags_desc'][] = $row;
                }
            }
        }


        if ($type == 'drink' || $type == 'edit') {
            $ProductDrinkTags = ProductFood::where(['type' => 'drink_tags'])->where(['status' => 'Active'])->whereNull('is_delete')->get();
            $data['products_drink_tags_desc'] = [];
            if (!empty($ProductDrinkTags)) {
                foreach ($ProductDrinkTags as $key => $PDT) {
                    $row  = getLanguageData('products_food_descriptions', $language_id, $PDT['id'], 'product_food_id');
                    $data['products_drink_tags_desc'][] = $row;
                }
            }
        }

        $data['product_food_drink'] =  getTableColumn('product_food_drink');
        if ($type == "edit" && isset($request->product_food_drink_id)) {
            $data['product_food_drink']                    = $ProductFoodDrink =   ProductFoodDrink::find($request->product_food_drink_id);
            if ($ProductFoodDrink) {
                $data['product_food_drink']['food_tags'] = array_map('intval', explode(',', $ProductFoodDrink->food_tags));
                $data['product_food_drink']['drink_tags'] =  array_map('intval', explode(',', $ProductFoodDrink->drink_tags));
            }
        }
        $output['data']        = $data;
        $output['status']      = true;
        $output['status_code'] = 200;
        $output['message']     = "Data fetched Successfully";
        return json_encode($output);
    }

    // Add Product Food Drink
    public function add_product_food_drink(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";

        $req_fields['language']          = "required";
        $req_fields['currency']          = "required";
        $req_fields['token']             = "required";
        $req_fields['user_id']           = "required";
        $req_fields['tourId']            = "required";

        if ($request->food == "yes") {
            $req_fields['type_of_meal'] = "required";
            $req_fields['time_of_day']  = "required";
            $req_fields['food_tags']    = "required";
        }
        if ($request->drink == "yes") {
            $req_fields['drink_tags']   = "required";
        }




        $errormsg = [
            "language"     => translate("Language"),
            "currency"     => translate("Currency"),
            "token"        => translate("Token"),
            "user_id"      => translate("User ID"),
            "tourId"       => translate("Product ID"),
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

        if ($validation->fails()) {
            return response()->json(
                [
                    'status'  => false,
                    'message' => $validation->errors()->first(),
                ],
                402,
            );
        }

        $language_id = $request->language;
        $productID   = $request->tourId;
        $user_id     = $request->user_id;


        $Product = Product::where(['id' => $productID, 'partner_id' => $user_id, 'added_by' => 'partner'])->first();

        $Product->food_drink  = 'yes';
        $Product->is_approved          = 'Not approved';
        $Product->save();
        $is_edit = 0;
        if (isset($request->is_remove)) {
            ProductFoodDrink::where("id", $request->product_food_drink_id)->delete();
            $output['message']     = "Delete Successfully...";
        } else {


            if ($request->product_food_drink_id != "") {
                $is_edit = $request->product_food_drink_id;
                $ProductFoodDrink                    =  ProductFoodDrink::find($request->product_food_drink_id);
                $output['message']     = "Food Drink Update Successfully...";
            } else {
                $ProductFoodDrink                    = new ProductFoodDrink();
                $output['message']     = "Food Drink Add Successfully...";
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
        }
        $output['status']      = true;
        $output['status_code'] = 200;
        return json_encode($output);
    }

    // Change OPtion Pricing Type
    public function change_option_pricing_type(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";

        $req_fields['language']          = "required";
        $req_fields['currency']          = "required";
        $req_fields['token']             = "required";
        $req_fields['user_id']           = "required";
        $req_fields['tourId']            = "required";
        $req_fields['optionId']            = "required";






        $errormsg = [
            "language"     => translate("Language"),
            "currency"     => translate("Currency"),
            "token"        => translate("Token"),
            "user_id"      => translate("User ID"),
            "tourId"       => translate("Product ID"),
            "optionId"   => translate("Option ID"),

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
            return response()->json(
                [
                    'status'  => false,
                    'message' => $validation->errors()->first(),
                ],
                402,
            );
        }

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
        $output['status']      = true;
        $output['status_code'] = 200;
        return json_encode($output);
    }
}
