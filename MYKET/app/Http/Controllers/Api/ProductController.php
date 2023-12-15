<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\ProductLocation;
use App\Models\ProductDescription;
use App\Models\ProductHighlight;
use App\Models\ProductInclusion;
use App\Models\ProductRestriction;
use App\Models\ProductInformation;
use App\Models\Categories;
use App\Models\Wishlist;
use App\Models\ProductAboutActivity;
use App\Models\ProductOption;
use App\Models\ProductOptionPricing;
use App\Models\ProductOptionPricingDetails;
use App\Models\ProductOptionAddOnTiers;
use App\Models\ProductOptionPricingTiers;
use App\Models\ProductOptionAvailability;
use App\Models\ProductOptionDiscount;
use App\Models\Countries;
use App\Models\States;
use App\Models\User;
use App\Models\Cities;
use App\Models\RecommendedThings;
use App\Models\TopAttraction;
use App\Models\TopAttractionDescription;
use App\Models\SideBanner;
use App\Models\SideBannerDescription;
use App\Models\UserReview;
use App\Models\UserReviewDescription;
use App\Models\MetaData;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ProductController extends Controller
{
    // Get Product List
    public function product_list(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language' => 'required',
            'currency' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(
                [
                    'status'  => false,
                    'message' => $validation->errors()->first(),
                ],
                402,
            );
        }

        $language_id  = $request->language;
        $setLimit     = 9;
        $offset       = $request->offset;
        $limit        = $offset * $setLimit;
        $data  = [];
        $category_id = "";
        if (isset($request->category)) {
            $Categories =  Categories::where(['slug' => $request->category])->first();
            if ($Categories) {
                $category_id = $Categories->id;
            }
        }
        $where = '';
        if ($category_id == "") {
            $where = ['products.is_delete' => null, 'products.status' => 'Active', 'products.is_approved' => 'Approved'];
        } else {
            $where = ['products.is_delete' => null, 'products.status' => 'Active', 'products.is_approved' => 'Approved', 'products.category' => $category_id];
        }


        $Product  = Product::where($where)->where('slug', '!=', '')

            ->select('products.*', 'product_option.wheelchair_accessibility', 'product_option.existing_line', 'product_not_suitable.product_id', 'product_option_pricing_tiers.retail_price', 'product_option_availability.time_json', 'product_option_availability.product_id')
            ->leftJoin('products_description', 'products.id', '=', 'products_description.product_id')
            ->leftJoin('product_option_availability', 'products.id', '=', 'product_option_availability.product_id')
            ->leftJoin('product_option', 'product_option.product_id', '=', 'products.id')
            ->leftJoin('product_option_pricing_tiers', 'product_option_pricing_tiers.product_id', '=', 'products.id')
            ->leftJoin('product_not_suitable', 'product_not_suitable.product_id', '=', 'products.id');





        $productIds = [];
        if (isset($request->is_filter) && $request->is_filter == 1) {


            $time_filter = $request->time_filter;

            if (isset($time_filter)) {

                foreach ($time_filter as $key => $value) {
                    $time_arr  = explode('-', $value);
                    $time1 = $time_arr[0];
                    $time2 = $time_arr[1];

                    $CheckAvailabileProduct =   Product::where($where)->where('slug', '!=', '')
                        ->select('products.*', 'product_option_availability.time_json', 'product_option_availability.date_json', 'product_option_availability.product_id')
                        ->leftJoin('product_option_availability', 'products.id', '=', 'product_option_availability.product_id')
                        ->whereDate('product_option_availability.valid_to', '>=', date('Y-m-d'))
                        ->get();

                    if (!$CheckAvailabileProduct->isEmpty()) {
                        foreach ($CheckAvailabileProduct as $AvailabileProductkey => $AvailabileProductvalue) {

                            if ($AvailabileProductvalue['time_json'] && $AvailabileProductvalue['time_json'] != null) {
                                foreach (json_decode($AvailabileProductvalue['time_json']) as $key => $value) {
                                    # code...

                                    if (!is_int($key)) {


                                        $new = array_filter($value, function ($var) use ($time1, $time2, $AvailabileProductvalue) {

                                            return ((int)$var >= (int)$time1 && (int)$var <= (int)$time2);
                                        });
                                        if (count($new) > 0) {
                                            $productIds[] = $AvailabileProductvalue['product_id'];
                                        }
                                    }
                                }
                            } else {
                                $productIds[] = $AvailabileProductvalue['product_id'];
                            }


                            if ($AvailabileProductvalue['date_json'] && $AvailabileProductvalue['date_json'] != null) {
                                foreach (json_decode($AvailabileProductvalue['date_json']) as $dkey => $dvalue) {
                                    # code...

                                    if ($dkey >= date("Y-m-d")) {


                                        $new = array_filter($dvalue, function ($var) use ($time1, $time2, $AvailabileProductvalue) {

                                            return ((int)$var >= (int)$time1 && (int)$var <= (int)$time2);
                                        });
                                        if (count($new) > 0) {
                                            $productIds[] = $AvailabileProductvalue['product_id'];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $productIds = array_unique($productIds);


            // Category Filter
            $category_filter = $request->category_filter;
            if (isset($category_filter)) {
                $Product = $Product->where(function ($data) use ($category_filter) {
                    foreach ($category_filter  as $CF) {
                        $data->orWhere('category', $CF);
                    }
                });
            }

            // interest Filter
            $interest_filter = $request->interest_filter;
            if (isset($interest_filter)) {
                $Product = $Product->where(function ($data) use ($interest_filter) {
                    foreach ($interest_filter  as $IF) {
                        $data->orWhereRaw('FIND_IN_SET(?, interest)', [$IF]);
                    }
                });
            }


            // Service Filter
            $service_filter = $request->service_filter;
            if (isset($service_filter)) {
                $Product = $Product->where(function ($data) use ($service_filter) {
                    foreach ($service_filter  as $SF) {
                        if ($SF == 20) {
                            $data->orWhere('product_option.wheelchair_accessibility', 'yes');
                        }
                        if ($SF == 19) {
                            $data->orWhere('product_option.is_private', 'Private');
                        }
                        if ($SF == 17) {
                            $data->orWhere('product_not_suitable.product_id', '=', 'products.id');
                        }

                        if ($SF == 16) {
                            $data->orWhere('product_option.existing_line', 'yes');
                        }
                    }
                });
            }

            // Price Filter
            $min_price_filter = $request->min_price_filter;
            if (isset($min_price_filter)) {

                $Product = $Product->where(function ($data) use ($min_price_filter) {

                    $data->where('product_option_pricing_tiers.retail_price', '>=', $min_price_filter);
                });
            }

            if (isset($max_price_filter)) {

                $Product = $Product->where(function ($data) use ($max_price_filter) {

                    $data->where('product_option_pricing_tiers.retail_price', '>=', $max_price_filter)->orderBy('product_option_pricing_tiers.retail_price', 'desc');
                });
            }
        }

        $Product = $Product->groupBy('products.id');

        if (count($productIds) > 0) {
            $Product = $Product->whereIn('products.id', $productIds);
        }

        $ProductCount = count($Product->get());

        // Sort Code Filter
        // if (isset($request->is_filter) && $request->is_filter == 1) {

        //     if (isset($request->sort)) {
        //         if ($request->sort == "atz") {
        //             $Product = $Product->orderBy('products_description.title', 'ASC');
        //         }

        //         if ($request->sort == "zta") {
        //             $Product = $Product->orderBy('products_description.title', 'DESC');
        //         }
        //     }
        // } else {
        $Product = $Product->orderBy('products.id', 'DESC');
        // }

        $Product = $Product->get();



        $data =  getProductArr($Product, $language_id, $request->user_id, 1);

        $ProductCount = count($data);
        if (isset($request->is_filter) && $request->is_filter == 1) {
            if (isset($request->sort)) {
                $price = array_column($data, 'price_val');
                $title = array_column($data, 'title');
                if ($request->sort == "htl") {
                    array_multisort($price, SORT_DESC, $data);
                } elseif ($request->sort == "atz") {
                    array_multisort($title, SORT_ASC, $data);
                } elseif ($request->sort == "zta") {
                    array_multisort($title, SORT_DESC, $data);
                } else {
                    array_multisort($price, SORT_ASC, $data);
                }
            }
        }




        $data = array_slice($data, $limit, $setLimit);




        $output['page_count']    = ceil($ProductCount / $setLimit);
        $output['product_count'] = $ProductCount;
        $output['data']          = $data;
        $output['status']        = true;
        $output['status_code']   = 200;
        $output['message']       = "Data Fetch Successfully";
        return json_encode($output);
    }


    // Get product Destination List
    public function destination_product_list(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language' => 'required',
            'currency' => 'required',
            'slug'     => 'required',
            // 'type'     => 'required',
        ]);

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
        $slug        = $request->slug;
        $type        = '';

        $setLimit     = 9;
        $offset       = $request->offset;
        $limit        = $offset * $setLimit;
        $RecommendedThingsID = 0;
        $data  = [];
        $productArr = [];
        $productDataArr = [];

        if ($slug != "") {
            $translator = new GoogleTranslate();
            $translator->setSource(); // Detect language automatically
            // $tr;
            $translator->setTarget('en');

            // Translate the text
            $translatedText = $translator->translate($slug);

            if ($translator->getLastDetectedSource() != "en") {
                $slug = $translatedText;
            }
        }



        $Countries = Countries::where(['name' => $slug])->first();
        if ($Countries) {
            $RecommendedThingsID = $Countries->id;
            $type = 'country';
        }


        if ($type == '' && $RecommendedThingsID == 0) {
            $States = States::where(['name' => $slug])->first();
            if ($States) {
                $RecommendedThingsID = $States->id;
                $type = 'state';
            }
        }

        if ($type == '' && $RecommendedThingsID == 0) {
            $Cities = Cities::where(['name' => $slug])->first();
            if ($Cities) {
                $RecommendedThingsID = $Cities->id;
                $type = 'city';
            }
        }

        $data['recommended_things'] = [];
        if ($type != "" && $RecommendedThingsID > 0) {
            $RecommendedThings = RecommendedThings::where([$type => $RecommendedThingsID, 'status' => 'Active', 'is_delete' => null])->get();
            foreach ($RecommendedThings as $RTkey => $RT) {
                $arr = [];
                $arr = getLanguageData('recommended_things_description', $language_id, $RT['id'], 'recommended_thing_id');
                $arr['image'] = $RT['image'] != "" ? asset('uploads/recommended_things/' . $RT['image']) : asset('uploads/products/dummyproduct.png');
                $data['recommended_things'][] = $arr;
            }
        }


        // Top Attraction
        $data['footer_data'] = [];
        $TopAttraction = "";
        if ($type != "" && $RecommendedThingsID > 0) {
            $TopAttraction = TopAttraction::where([$type => $RecommendedThingsID, 'status' => 'Active', 'is_delete' => null])->get();
            if (count($TopAttraction) > 0) {

                $TopAttractionData = TopAttraction::where([$type => $RecommendedThingsID, 'status' => 'Active', 'is_delete' => null])->get();
                foreach ($TopAttractionData as $key => $TAD) {
                    $TopAttractionDescription = TopAttractionDescription::where("attraction_id", $TAD['id'])->first();
                    if ($TopAttractionDescription) {
                        $top_attraction_arr = $TAD;
                        $top_attraction_arr['title'] = $TopAttractionDescription->title;
                        $top_attraction_arr['slug'] = 'attraction-listing/' . $TAD['slug'];
                        $data['footer_data']['Top Attractions in ' . $slug][] = $top_attraction_arr;
                    }
                }
            }

            if ($type == "country" || $type == "state") {
                if ($type == "country") {
                    $stateData = ProductLocation::where('country',  $slug)->groupBy('product_id', 'state')->get();

                    foreach ($stateData as $key => $SD) {
                        $stateArr          = [];
                        $stateArr['id']    = $SD['id'];
                        $stateArr['title'] = $SD['state'];
                        $stateArr['slug']  = "destination-listing/" . $SD['state'];
                        if ($SD['state'] != "") {
                            $data['footer_data']['Region in ' . $slug][] = $stateArr;
                        }
                    }
                }

                $cityData = ProductLocation::where($type,  $slug)->groupBy('product_id', 'city')->get();
                foreach ($cityData as $key => $CD) {
                    $stateArr         = [];
                    $stateArr['id']   = $CD['id'];
                    $stateArr['title'] = $CD['city'];
                    $stateArr['slug']  = "destination-listing/" . $CD['city'];
                    if ($CD['city'] != "") {
                        $data['footer_data']['City in ' . $slug][] = $stateArr;
                    }
                }
            }
        }

        if (count($data['footer_data']) == 0) {
            $data['footer_data'] = "";
        }


        $ProductLocation = ProductLocation::where('address', 'like', '%' . $slug . '%')
            ->leftJoin('products', 'products.id', '=', 'products_locations.product_id');
        if ($type != "") {
            $ProductLocation = $ProductLocation->orWhere("products." . $type, $RecommendedThingsID);
        }

        $ProductLocation = $ProductLocation->groupBy('product_id')->get();

        foreach ($ProductLocation as $key => $PL) {
            $where = ['products.is_delete' => null, 'products.status' => 'Active', 'products.id' => $PL['product_id']];

            $Product  = Product::select('products.*', 'product_option.wheelchair_accessibility', 'product_option.existing_line', 'product_not_suitable.product_id', 'product_option_pricing_tiers.retail_price', 'product_option_availability.time_json', 'product_option_availability.product_id')
                ->where($where)

                ->leftJoin('products_description', 'products.id', '=', 'products_description.product_id')
                ->leftJoin('product_option_availability', 'products.id', '=', 'product_option_availability.product_id')
                ->leftJoin('product_option', 'product_option.product_id', '=', 'products.id')
                ->leftJoin('product_option_pricing_tiers', 'product_option_pricing_tiers.product_id', '=', 'products.id')
                ->leftJoin('product_not_suitable', 'product_not_suitable.product_id', '=', 'products.id');

            $productIds = [];
            if (isset($request->is_filter) && $request->is_filter == 1) {


                $time_filter = $request->time_filter;

                if (isset($time_filter)) {

                    foreach ($time_filter as $key => $value) {
                        $time_arr  = explode('-', $value);
                        $time1 = $time_arr[0];
                        $time2 = $time_arr[1];

                        $CheckAvailabileProduct =   Product::where($where)->where('slug', '!=', '')
                            ->select('products.*', 'product_option_availability.time_json', 'product_option_availability.date_json', 'product_option_availability.product_id')
                            ->leftJoin('product_option_availability', 'products.id', '=', 'product_option_availability.product_id')
                            ->whereDate('product_option_availability.valid_to', '>=', date('Y-m-d'))
                            ->get();

                        if (!$CheckAvailabileProduct->isEmpty()) {
                            foreach ($CheckAvailabileProduct as $AvailabileProductkey => $AvailabileProductvalue) {

                                if ($AvailabileProductvalue['time_json'] && $AvailabileProductvalue['time_json'] != null) {
                                    foreach (json_decode($AvailabileProductvalue['time_json']) as $key => $value) {
                                        # code...

                                        if (!is_int($key)) {


                                            $new = array_filter($value, function ($var) use ($time1, $time2, $AvailabileProductvalue) {

                                                return ((int)$var >= (int)$time1 && (int)$var <= (int)$time2);
                                            });
                                            if (count($new) > 0) {
                                                $productIds[] = $AvailabileProductvalue['product_id'];
                                            }
                                        }
                                    }
                                } else {
                                    $productIds[] = $AvailabileProductvalue['product_id'];
                                }


                                if ($AvailabileProductvalue['date_json'] && $AvailabileProductvalue['date_json'] != null) {
                                    foreach (json_decode($AvailabileProductvalue['date_json']) as $dkey => $dvalue) {
                                        # code...

                                        if ($dkey >= date("Y-m-d")) {


                                            $new = array_filter($dvalue, function ($var) use ($time1, $time2, $AvailabileProductvalue) {

                                                return ((int)$var >= (int)$time1 && (int)$var <= (int)$time2);
                                            });
                                            if (count($new) > 0) {
                                                $productIds[] = $AvailabileProductvalue['product_id'];
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                $productIds = array_unique($productIds);


                // Category Filter
                $category_filter = $request->category_filter;
                if (isset($category_filter)) {
                    $Product = $Product->where(function ($data) use ($category_filter) {
                        foreach ($category_filter  as $CF) {
                            $data->orWhere('category', $CF);
                        }
                    });
                }

                // interest Filter
                $interest_filter = $request->interest_filter;
                if (isset($interest_filter)) {
                    $Product = $Product->where(function ($data) use ($interest_filter) {
                        foreach ($interest_filter  as $IF) {
                            $data->orWhereRaw('FIND_IN_SET(?, interest)', [$IF]);
                        }
                    });
                }


                // Service Filter
                $service_filter = $request->service_filter;
                if (isset($service_filter)) {
                    $Product = $Product->where(function ($data) use ($service_filter) {
                        foreach ($service_filter  as $SF) {
                            if ($SF == 20) {
                                $data->orWhere('product_option.wheelchair_accessibility', 'yes');
                            }
                            if ($SF == 19) {
                                $data->orWhere('product_option.is_private', 'Private');
                            }
                            if ($SF == 17) {
                                $data->orWhere('product_not_suitable.product_id', '=', 'products.id');
                            }

                            if ($SF == 16) {
                                $data->orWhere('product_option.existing_line', 'yes');
                            }
                        }
                    });
                }

                // Price Filter
                $min_price_filter = $request->min_price_filter;
                if (isset($min_price_filter)) {

                    $Product = $Product->where(function ($data) use ($min_price_filter) {

                        $data->where('product_option_pricing_tiers.retail_price', '>=', $min_price_filter);
                    });
                }

                if (isset($max_price_filter)) {

                    $Product = $Product->where(function ($data) use ($max_price_filter) {

                        $data->where('product_option_pricing_tiers.retail_price', '>=', $max_price_filter)->orderBy('product_option_pricing_tiers.retail_price', 'desc');
                    });
                }
            }
            // dd($productIds);



            if (count($productIds) > 0) {
                $Product = $Product->whereIn('products.id', $productIds);
            }
            $productArr[] = $Product->first();
        }

        $list = getProductArr($productArr, $language_id, $request->user_id);
        if (isset($request->is_filter) && $request->is_filter == 1) {
            if (isset($request->sort)) {
                $price = array_column($list, 'price_val');
                $title = array_column($list, 'title');
                if ($request->sort == "htl") {
                    array_multisort($price, SORT_DESC, $list);
                } elseif ($request->sort == "atz") {
                    array_multisort($title, SORT_ASC, $list);
                } elseif ($request->sort == "zta") {
                    array_multisort($title, SORT_DESC, $list);
                } else {
                    array_multisort($price, SORT_ASC, $list);
                }
            }
        }



        $productDataArr        = array_slice($list, $limit, $setLimit);
        $data['list']          = $productDataArr;
        $output['page_count']  = ceil(count($list) / $setLimit);
        $output['product_count'] = count($list);
        $output['data']        = $data;
        $output['status']      = true;
        $output['status_code'] = 200;
        $output['message']     = "Data Fetch Successfully";
        return json_encode($output);
    }


    // Get Product Details
    public function product_details(Request $request)
    {

        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language' => 'required',
            'currency' => 'required',
            'product_id' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(
                [
                    'status'  => false,
                    'message' => $validation->errors()->first(),
                ],
                402,
            );
        }

        $language_id  = $request->language;
        $product_slug = $request->product_id;
        $user_id = checkDecrypt($request->user_id);
        $data = [];
        $Product = Product::where(['slug' => $product_slug, 'is_delete' => null, 'status' => 'Active', 'is_approved' => "Approved"])->first();
        if ($Product) {

            $data['weather_details']  = "";
            $weather = "";


            if ($Product->country != "") {
                $country      = getDataFromDB('countries', ['id' => $Product->country], 'row', 'name');
                if ($country != "") {
                    $weather = $country;
                }
            }

            if ($Product->state != "") {
                $state      = getDataFromDB('states', ['id' => $Product->state], 'row', 'name');
                if ($state != "") {
                    $weather = $state;
                }
            }

            if ($Product->city != "") {
                $city      = getDataFromDB('cities', ['id' => $Product->city], 'row', 'name');
                if ($city != "") {
                    $weather = $city;
                }
            }



            if ($weather != "") {
                $data['weather_details']  = getWeatherDetails($weather);
            }

            $data['provider'] = '';
            $data['provider_slug'] = '';
            $data['generated_link'] = '';



            if ($request->user_id) {
                $data['generated_link'] = generate_product_link("affilliate_generated_links", $Product->id, $user_id, "culture-details");
            }

            if ($Product->added_by == 'partner') {
                $User = User::find($Product->partner_id);
                if ($User) {
                    $data['provider'] = $User->first_name . " " . $User->last_name;
                    $data['provider_slug'] = $User->slug;
                }
            }
            $product_id = $Product->id;
            $ProductImages = ProductImages::where(['product_id' => $product_id, 'is_delete' => null])->get();
            $ProductImagesCount = ProductImages::where(['product_id' => $product_id, 'is_delete' => null])->count();

            $data['side_banner_title'] = "";
            $data['side_banner_image'] = "";
            $data['side_banner_description'] = "";
            $data['side_banner_link'] = "";
            // Side Banner 
            $SideBanner    = SideBanner::where('product_id', $product_id)->first();
            if ($SideBanner) {
                if ($SideBanner->image != "") {
                    $data['side_banner_image'] = asset('uploads/products/' . $SideBanner->image);
                }
                $data['side_banner_link'] = $SideBanner->link;

                $SideBannerDescription = SideBannerDescription::where(['side_banner_id' => $SideBanner->id, "product_id" => $product_id, 'language_id' => $language_id])->first();
                if ($SideBannerDescription) {
                    $data['side_banner_title'] = $SideBannerDescription->title;
                    $data['side_banner_description'] = $SideBannerDescription->description;
                }
            }
            $data['video_url'] = "";
            $data['video_thumbnail_image'] = "";
            if ($Product->video_url != "") {
                $data['video_url'] = $Product->video_url;
                $data['video_thumbnail_image'] = $Product->video_thumbnail_image != "" ? asset('uploads/products/' .  $Product->video_thumbnail_image) : asset('uploads/demo_thumb.png');
            }


            $data['enable_date'] = [];
            $data['pricingCategories'] = [];
            $data['age_note'] = '';
            $data['product_id'] = $product_id;
            $ProductOption = ProductOption::where(['product_id' => $product_id, 'status' => 'Active', 'is_delete' => null])->get();

            $enable_date = [];
            foreach ($ProductOption as $POkey => $PO) {
                $ProductOptionPricing = ProductOptionPricing::where(['product_id' => $product_id, 'option_id' => $PO['id'], 'is_delete' => null])->first();

                if ($ProductOptionPricing) {
                    $note_on_sale_date = [];
                    $ProductOptionAvailability = ProductOptionAvailability::where(["product_id" => $product_id, 'pricing_id' => $ProductOptionPricing->id, 'option_id' => $PO['id']])->first();

                    if ($ProductOptionAvailability) {
                        if ($ProductOptionAvailability->valid_from != "" && $ProductOptionAvailability->valid_to != "") {
                            $period = CarbonPeriod::create(date("Y-m-d", strtotime($ProductOptionAvailability->valid_from)), date("Y-m-d", strtotime($ProductOptionAvailability->valid_to)));
                            // Iterate over the period
                            $note_on_sale_date_old =  explode(',', $Product->not_on_sale);
                            foreach ($note_on_sale_date_old as $key => $NOSD) {
                                $note_on_sale_date[] = date("Y/m/d", strtotime($NOSD));
                            }
                            foreach ($period as $date) {
                                if ($date >= date("Y-m-d")) {
                                    $myDate =  $date->format('Y/m/d');
                                    $newDate =  $date->format('m/d/Y');

                                    $day =   Carbon::parse($myDate)->format('l');
                                    $day =  Str::lower(substr($day, 0, 3));
                                    $time_json = json_decode($ProductOptionAvailability->time_json);
                                    if ($time_json != '') {
                                        foreach ($time_json as $TJkey => $TJ) {
                                            if ($TJkey == $day) {
                                                if ($TJ > 0 && $TJ != "") {
                                                    $newDate = date("Y-m-d", strtotime($myDate));
                                                    // if (!in_array($newDate, $note_on_sale_date)) {
                                                    $enable_date[] =  $myDate;
                                                    // }
                                                }
                                            }
                                        }
                                    }



                                    if ($ProductOptionAvailability->date_json != "") {
                                        $date_json = json_decode($ProductOptionAvailability->date_json);
                                        if ($date_json != '') {
                                            foreach ($date_json as $DJkey => $DJ) {
                                                if ($DJkey == date("Y-m-d", strtotime($myDate))) {
                                                    if ($DJ > 0 && $DJ != "") {
                                                        $newDate = date("Y-m-d", strtotime($myDate));

                                                        // if (!in_array($newDate, $note_on_sale_date)) {
                                                        $enable_date[] =  $myDate;
                                                        // }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            if (count($enable_date) == 0) {
                                foreach ($period as $date) {
                                    if ($date >= date("Y-m-d")) {
                                        $enable_date[] = $date->format('Y/m/d');
                                    }
                                }
                            }
                        }
                    }

                    // print_die($period->toArray());

                    // Convert the period to an array of dates
                    // dd($enable_date, $note_on_sale_date);
                    $data['enable_date'] = array_values(array_unique(array_diff($enable_date, $note_on_sale_date)));


                    // Get Pricing Categories
                    // $ProductOptionPricingDetails = ProductOptionPricingDetails::where(['product_id' => $product_id, 'option_id' => $PO['id'], 'pricing_id' => $ProductOptionPricing->id])->get();
                    // $age_note = '';
                    // foreach ($ProductOptionPricingDetails as $POPDkey => $POPD) {
                    //     $Categories  = [];
                    //     if ($POPD['person_type']) {

                    //         if ($POPD['booking_category'] ==     'not_permitted') {

                    //             $age_note = "(Age " . $POPD['age_range'] . " and younger not permitted)";
                    //         } else {
                    //             $Categories['title'] = $POPD['person_type'];
                    //             if ($POPD['person_type'] == "infant") {
                    //                 $Categories['participantsCategoryIdentifier'] = "(Age " . $POPD['age_range'] . " and younger )";
                    //             } else {

                    //                 $Categories['participantsCategoryIdentifier'] = "(Age " . $POPD['from_age_range'] . "-" . $POPD['age_range'] . ")";
                    //             }
                    //         }
                    //         if (!empty($Categories)) {
                    //             $data['pricingCategories'][] = $Categories;
                    //         }
                    //         $data['age_note'] = $age_note;
                    //     }
                    // }
                }
            }



            $data['images'] = [];
            $data['duration_text'] = $Product->duration_text;
            $data['activity_text'] = $Product->activity_text;

            $data['country']  = "Country";
            $country = $Product->country;
            if ($country != "") {
                $data['country']      = getDataFromDB('countries', ['id' => $country], 'row', 'name');
            }
            $data['price']          =  get_price_front($product_id, 'details');
            if ($Product->cover_image != "") {
                $ProductImagesCount = $ProductImagesCount + 1;
                $data['images'][0] = asset('uploads/products/' . $Product->cover_image);
            }
            foreach ($ProductImages as $Ikey => $PI) {
                $data['images'][] = asset('uploads/products/' . $PI['image']);
            }


            $data['image_count'] = 0;
            if ($ProductImagesCount > 3) {
                $data['image_count'] = $ProductImagesCount - 3;
            }
            $ProductLocation = ProductLocation::where('product_id', $product_id)->get();
            $location = [];
            foreach ($ProductLocation as $PLkey => $PL) {

                $location[] = $PL['address'];
            }

            $data['location']     = implode(" | ", $location);
            $data['trip_details'] = ucfirst(str_replace('_', ' ', $Product->type));





            $MetaData =  MetaData::where(['language_id' => $language_id, 'value' => $Product->id, 'type' => 'product'])->first();


            $ProductDescription   = ProductDescription::where(["product_id" => $product_id])->first();
            $meta_description = "No title";
            $data['description'] = [];
            if ($ProductDescription) {
                $row  = getLanguageData('products_description', $language_id, $product_id, 'product_id');

                $data['description'] =  $row;
                if ($row) {
                    $meta_description = $row['title'];
                }
            }

            $data['meta_data'] =
                [
                    "keyword" => "No keyword",
                    "description" =>  "No Description",
                    "title" =>  $meta_description
                ];

            if ($MetaData != "") {
                $data['meta_data'] =
                    [
                        "keyword" => $MetaData->keyword,
                        "description" =>  $MetaData->description,
                        "title" =>  $meta_description
                    ];
            }

            $data['activity_list']  = [];

            $data['tab_details'] = [];
            $ProductHighlight  = ProductHighlight::where(["product_id" => $product_id])->get();

            foreach ($ProductHighlight as $PHkey => $PH) {
                $row  = getLanguageData('product_highlight_description', $language_id, $PH['id'], 'highlight_id');
                $data['tab_details']['highlights'][] = $row;
            }

            $ProductInclusion  = ProductInclusion::where(["product_id" => $product_id])->get();
            foreach ($ProductInclusion as $PIkey => $PI) {
                if ($PI['type'] == "gear") {
                    $row  = getLanguageData('gear_descriptions', $language_id, $PI['type_id'], 'gear_id');
                    if ($row['title'] != "") {
                        $data['tab_details']['includes'][] = $row;
                    }
                }

                if ($PI['type'] == "media") {
                    $row  = getLanguageData('media_descriptions', $language_id, $PI['type_id'], 'media_id');
                    if ($row['title'] != "") {
                        $data['tab_details']['includes'][] = $row;
                    }
                }

                if ($PI['type'] == "inclusion") {
                    $row  = getLanguageData('inclusion_descriptions', $language_id, $PI['type_id'], 'inclusion_id');
                    if ($row['title'] != "") {
                        $data['tab_details']['includes'][] = $row;
                    }
                }
            }


            $ProductRestriction  = ProductRestriction::where(["product_id" => $product_id])->get();
            foreach ($ProductRestriction as $PRkey => $PR) {
                $row  = getLanguageData('restriction_descriptions', $language_id, $PR['restriction_id'], 'restriction_id');
                if ($row['title'] != "") {
                    $data['tab_details']['suitable'][] = $row;
                }
            }

            $ProductInformation  = ProductInformation::where(["product_id" => $product_id])->get();

            foreach ($ProductInformation as $PIkey => $PI) {

                $row  = getLanguageData('product_important_information_description', $language_id, $PI['id'], 'information_id');
                $data['tab_details']['Important Information'][] = $row;
            }


            $ProductAboutActivity  = ProductAboutActivity::where(["product_id" => $product_id])->get();
            $data['about_activity']  = [];
            foreach ($ProductAboutActivity as $PAAkey => $PAA) {
                $row  = getLanguageData('product_about_activity_description', $language_id, $PAA['id'], 'about_activity_id');
                $row['image'] = $PAA['image'] != "" ? asset('uploads/products/' . $PAA['image']) : asset('uploads/products/dummyicon.png');
                $data['about_activity'][] = $row;
            }




            $data['is_wishlist'] = Wishlist::where(['product_id' => $product_id, 'user_id' => $user_id])->count();

            $data['review_list'] = [];
            // Review Details
            $review_list = UserReview::where(['product_id' => $product_id, 'status' => 'Active'])->get();

            foreach ($review_list as $key => $value) {
                $reviewArr                = [];
                $user_id                  = $value['user_id'];
                $User                     = User::find($user_id);
                $reviewArr['image']       = $User->image != '' ? url('uploads/user_image', $User->image) : asset('public/uploads/img_avatar.png');
                $reviewArr['name']        = "Anonymous";
                $reviewArr['rating']      = $value['rating'];
                $reviewArr['title']       = "No Title";
                $reviewArr['description'] = "No Description";
                if ($User) {
                    $reviewArr['name'] = $User->first_name . " " . $User->last_name;
                }
                $UserReviewDescription =  UserReviewDescription::where(['review_id' => $value['id'], 'language_id' => $language_id])->first();
                if ($UserReviewDescription) {
                    $reviewArr['title']       = $UserReviewDescription->title;
                    $reviewArr['description'] =  $UserReviewDescription->description;
                }
                $data['review_list'][] = $reviewArr;
            }

            $data['ratings']           = get_rating($product_id);
            $data['total_review'] = UserReview::where('product_id', $product_id)->where('status', 'Active')
                ->count();

            $data['ratings_count'] = get_ratings_count($product_id);

            $output['status']        = true;
            // title
        }
        $output['data']          = $data;

        $output['status_code']   = 200;
        $output['message']       = "Data Fetch Successfully";
        return json_encode($output);
    }


    // Product Available Options
    public function  available_options(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language'   => 'required',
            'currency'   => 'required',
            'product_id' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(
                [
                    'status'  => false,
                    'message' => $validation->errors()->first(),
                ],
                402,
            );
        }

        $date         = $request->date;
        $adult        = $request->adult;
        $child        = $request->child;
        $infant       = $request->infant;
        $total        = $request->total;
        $language_id  = $request->language;
        $product_slug = $request->product_id;
        $get_option_id = $request->option_id;
        $adultPrice   = 0;
        $childPrice   = 0;
        $infantPrice  = 0;
        $groupPrice  = 0;
        $user_id      = checkDecrypt($request->user_id);
        $data         = [];
        $Product      = Product::where(['slug' => $product_slug, 'is_delete' => null, 'status' => 'Active'])->first();
        if ($Product) {

            $day = "";
            if (isset($date)) {
                $timestampDate =  strtotime($date);
                $fullday =  Carbon::parse($date)->format('l');
                $day  = Str::lower(substr($fullday, 0, 3));
            }

            if (isset($adult)) {

                $total = $adult + $child + $infant;
            }


            $product_id = $Product->id;
            // Product Option
            $count  = 1;
            $ProductOption = ProductOption::where(['product_id' => $product_id, 'status' => 'Active', 'is_delete' => null])->get();
            foreach ($ProductOption as $POkey => $PO) {

                $ProductOptionPricing = ProductOptionPricing::where(['product_id' => $product_id, 'option_id' => $PO['id'], 'is_delete' => null])->first();

                if ($ProductOptionPricing) {
                    $row                                 = getLanguageData('product_option_descriptions', $language_id, $PO['id'], 'option_id');
                    $row['duration_text']  = "";
                    if ($PO['time_length'] == "duration") {
                        $row['duration_text'] = $PO['duration_time'] . " " . $PO['duration_time_type'];
                    }
                    $row['reference_code']               = $PO['reference_code'];
                    $row['likely_to_sell_out']           = $PO['likely_to_sell_out'];
                    $row['guide_headphone']              = $PO['guide_headphone'];
                    $row['guide_headphone_language']     = $PO['guide_headphone_language'];
                    $row['information_booklet_language'] = $PO['information_booklet_language'];
                    $row['information_booklet']          = $PO['information_booklet'];
                    $row['existing_line']                = $PO['existing_line'];
                    $row['existing_line_type']           = $PO['existing_line_type'];
                    $row['wheelchair_accessibility']     = $PO['wheelchair_accessibility'];
                    $row['time_length']                  = $PO['time_length'];
                    $row['duration_time']                = $PO['duration_time'];
                    $row['duration_time_type']           = $PO['duration_time_type'];
                    $row['validity_type']                = $PO['validity_type'];
                    $row['validity_time_type']           = $PO['validity_time_type'];
                    $row['is_private']                   = $PO['is_private'];
                    $row['pricing_type']                 = $ProductOptionPricing->pricing_type;
                    $row['minimum_participants']         = $minimum_participants = $ProductOptionPricing->minimum_participants;
                    $row['require_participants']         = true;
                    $row['require_participants_msg']     = '';

                    $ProductOptionPricingDetails = ProductOptionPricingDetails::where(['product_id' => $product_id, 'option_id' => $PO['id'], 'pricing_id' => $ProductOptionPricing->id])->get();
                    $row['max_participants'] = 0;
                    $max_participants =   ProductOptionPricingTiers::where(['product_id' => $product_id, 'option_id' => $PO['id'], 'pricing_id' => $ProductOptionPricing->id])->where('retail_price', '!=', '')->orderBy('no_of_people', 'DESC')->first();


                    $ProductOptionDiscount =  ProductOptionDiscount::where(['product_id' => $product_id, 'option_id' => $PO['id'], 'pricing_id' => $ProductOptionPricing->id])
                        ->where('valid_from', '<=', date('Y-m-d', strtotime($date)))->where('valid_to', '>=',  date('Y-m-d', strtotime($date)))->first();
                    $percentage = 0;
                    if ($ProductOptionDiscount) {

                        if (strtotime($ProductOptionDiscount->valid_from) <=  $timestampDate && strtotime($ProductOptionDiscount->valid_to) >=  $timestampDate) {
                            $percentage = $ProductOptionDiscount->date_percentage;
                        }


                        if ($ProductOptionDiscount->time_json != "") {
                            $time_json = json_decode($ProductOptionDiscount->time_json);
                            foreach ($time_json as $TJkey => $TJ) {
                                if ($TJkey == $day) {
                                    if ($TJ > 0 && $TJ != "") {
                                        $percentage = $TJ;
                                    }
                                }
                            }
                        }

                        if ($ProductOptionDiscount->date_json != "") {
                            $date_json = json_decode($ProductOptionDiscount->date_json);
                            foreach ($date_json as $DJkey => $DJ) {

                                if ($DJkey == date("Y-m-d", strtotime($date))) {
                                    if ($DJ > 0 && $DJ != "") {
                                        $percentage = $DJ;
                                    }
                                }
                            }
                        }
                    }

                    if ($minimum_participants > $total) {
                        $row['require_participants_msg']  = 'Please select ' . $minimum_participants . ' participants or more for this activity.';
                        $row['require_participants']         = false;
                    }

                    $row['max_participants'] = $max_participants->no_of_people;

                    if ($max_participants && $row['require_participants'] == true) {
                        if (isset($total)) {
                            if ($total > $max_participants->no_of_people) {
                                $row['require_participants_msg']  = 'Please select ' . $max_participants->no_of_people . ' participants or fewer for this activity.';
                                $row['require_participants']         = false;
                            }
                            if ($total == 0) {
                                $row['require_participants_msg']  = 'At least 1 participants are required for this activity.';
                                $row['require_participants']         = false;
                            }
                        }
                    }
                    $row['price_brakdown'] = [];
                    $row['deal'] = [];
                    $row['cancelation_msg'] = '';


                    $price_brakdown = [];
                    $beforeDiscountAmount = 0;
                    $totalAmount = 0;
                    foreach ($ProductOptionPricingDetails as $POPDkey => $POPD) {
                        $ProductOptionAvailability = ProductOptionAvailability::where(["product_id" => $product_id, 'pricing_id' => $ProductOptionPricing->id, 'option_id' => $PO['id']])->where('valid_from', '<=', date('Y-m-d', strtotime($date)))
                            ->where('valid_to', '>=', date('Y-m-d', strtotime($date)))
                            ->first();

                        if ($ProductOptionAvailability) {
                            if ($ProductOptionPricing->pricing_type == "person") {

                                if (isset($adult) && $adult > 0 && $POPD['person_type']  == 'adult') {

                                    if ($POPD['booking_category'] == 'not_permitted') {
                                        $row['require_participants_msg']  = 'Adult not permitted for this activity.';
                                        $row['require_participants']         = false;
                                    } else {
                                        $ProductOptionPricingTiers = ProductOptionPricingTiers::where(['product_id' => $product_id, 'option_id' => $PO['id'], 'pricing_id' => $ProductOptionPricing->id, 'pricing_details_id' => $POPD['id'], 'type' => 'adult'])->where('from_no_of_people', '<=', $adult)->where('no_of_people', '>=', $adult)->first();
                                        if (!$ProductOptionPricingTiers) {
                                            $ProductOptionPricingTiers = ProductOptionPricingTiers::where(['product_id' => $product_id, 'option_id' => $PO['id'], 'pricing_id' => $ProductOptionPricing->id, 'pricing_details_id' => $POPD['id'], 'type' => 'adult'])->orderBy('no_of_people', 'DESC')->first();
                                        }

                                        if ($ProductOptionPricingTiers) {
                                            $adultData = [];
                                            $adultData['title'] = "Adult";
                                            $adultData['totalParticipants'] = $adult;
                                            $retail_price = $ProductOptionPricingTiers->retail_price;

                                            $adultData['booking_category'] = $POPD['booking_category'];


                                            if ($POPD['booking_category'] == 'free' || $POPD['booking_category'] == 'free_no_ticket') {
                                                $retail_price = 0;
                                            }
                                            $beforeDiscountAdultPrice = $retail_price * $adult;
                                            $beforeDiscountAmount += $beforeDiscountAdultPrice;
                                            if ($percentage > 0) {
                                                $percentageAmount = ($retail_price * $percentage) / 100;
                                                $retail_price  = $retail_price - $percentageAmount;
                                            }
                                            $adultPrice = $retail_price * $adult;
                                            $adultData['pricePerPerson'] = $retail_price;

                                            $adultData['totalPrice'] = $adultPrice;
                                            $totalAmount += $adultPrice;
                                            $adultData['formattedValue'] = get_price_front($product_id, '', '', '', $adultPrice);
                                            $price_brakdown[] = $adultData;
                                        }
                                    }
                                }
                                if (isset($child) && $child > 0 && $POPD['person_type']  == 'child') {

                                    if ($POPD['booking_category'] == 'not_permitted') {
                                        $row['require_participants_msg']  = 'Child not permitted for this activity.';
                                        $row['require_participants']         = false;
                                    } else {
                                        $ProductOptionPricingTiersChild = ProductOptionPricingTiers::where(['product_id' => $product_id, 'option_id' => $PO['id'], 'pricing_id' => $ProductOptionPricing->id, 'type' => 'child'])->where('from_no_of_people', '<=', $child)->where('no_of_people', '>=', $child)->first();


                                        if (!$ProductOptionPricingTiersChild) {

                                            $ProductOptionPricingTiersChild = ProductOptionPricingTiers::where(['product_id' => $product_id, 'option_id' => $PO['id'], 'pricing_id' => $ProductOptionPricing->id, 'type' => 'child'])->orderBy('no_of_people', 'DESC')->first();

                                            if (!$ProductOptionPricingTiersChild) {
                                                $ProductOptionPricingTiersChild = ProductOptionPricingTiers::where(['product_id' => $product_id, 'option_id' => $PO['id'], 'pricing_id' => $ProductOptionPricing->id, 'type' => 'adult'])->where('from_no_of_people', '<=', $child)->where('no_of_people', '>=', $child)->first();
                                            }
                                        }

                                        if ($ProductOptionPricingTiersChild) {
                                            $childData = [];
                                            $childData['title'] = "Children";
                                            $childData['totalParticipants'] = $child;

                                            $childData['booking_category'] = $POPD['booking_category'];



                                            $retail_price = $ProductOptionPricingTiersChild->retail_price;
                                            if ($POPD['booking_category'] == 'free' || $POPD['booking_category'] == 'free_no_ticket') {
                                                $retail_price = 0;
                                            }
                                            $beforeDiscountChildPrice = $retail_price * $child;
                                            $beforeDiscountAmount += $beforeDiscountChildPrice;


                                            if ($percentage > 0) {
                                                $percentageAmount = ($retail_price * $percentage) / 100;
                                                $retail_price  = $retail_price - $percentageAmount;
                                            }
                                            $childPrice = $retail_price * $child;
                                            $childData['pricePerPerson'] = $retail_price;

                                            $childData['totalPrice'] = $childPrice;
                                            $totalAmount += $childPrice;
                                            $childData['formattedValue'] = get_price_front($product_id, '', '', '', $childPrice);
                                            $price_brakdown[] = $childData;
                                        }
                                    }
                                }

                                if (isset($infant) && $infant > 0 && $POPD['person_type']  == 'infant') {

                                    if ($POPD['booking_category'] == 'not_permitted') {
                                        $row['require_participants_msg']  = 'Infant not permitted for this activity.';
                                        $row['require_participants']         = false;
                                    } else {
                                        $ProductOptionPricingTiersInfant = ProductOptionPricingTiers::where(['product_id' => $product_id, 'option_id' => $PO['id'], 'pricing_id' => $ProductOptionPricing->id, 'type' => 'infant'])->where('from_no_of_people', '<=', $infant)->where('no_of_people', '>=', $infant)->first();

                                        if (!$ProductOptionPricingTiersInfant) {
                                            $ProductOptionPricingTiersInfant = ProductOptionPricingTiers::where(['product_id' => $product_id, 'option_id' => $PO['id'], 'pricing_id' => $ProductOptionPricing->id, 'type' => 'infant'])->orderBy('no_of_people', 'DESC')->first();

                                            if (!$ProductOptionPricingTiersInfant) {
                                                $ProductOptionPricingTiersInfant = ProductOptionPricingTiers::where(['product_id' => $product_id, 'option_id' => $PO['id'], 'pricing_id' => $ProductOptionPricing->id, 'type' => 'adult'])->where('from_no_of_people', '<=', $infant)->where('no_of_people', '>=', $infant)->first();
                                            }
                                        }

                                        if ($ProductOptionPricingTiersInfant) {
                                            $infantData = [];
                                            $infantData['title'] = "Infant";
                                            $infantData['totalParticipants'] = $infant;

                                            $infantData['booking_category'] = $POPD['booking_category'];



                                            $retail_price = $ProductOptionPricingTiersInfant->retail_price;
                                            if ($POPD['booking_category'] == 'free' || $POPD['booking_category'] == 'free_no_ticket') {
                                                $retail_price = 0;
                                            }
                                            $beforeDiscountinfantPrice = $retail_price * $infant;
                                            $beforeDiscountAmount += $beforeDiscountinfantPrice;

                                            if ($percentage > 0) {
                                                $percentageAmount = ($retail_price * $percentage) / 100;
                                                $retail_price  = $retail_price - $percentageAmount;
                                            }
                                            $infantPrice = $retail_price * $infant;
                                            $infantData['pricePerPerson'] = $retail_price;



                                            $infantData['totalPrice'] = $infantPrice;
                                            $totalAmount += $infantPrice;
                                            $infantData['formattedValue'] = get_price_front($product_id, '', '', '', $infantPrice);
                                            $price_brakdown[] = $infantData;
                                        }
                                    }
                                }
                            } else {

                                $ProductOptionPricingTiers = ProductOptionPricingTiers::where(['product_id' => $product_id, 'option_id' => $PO['id'], 'pricing_id' => $ProductOptionPricing->id, 'pricing_details_id' => $POPD['id'], 'type' => 'group'])->where('from_no_of_people', '<=', $total)->where('no_of_people', '>=', $total)->first();

                                if ($ProductOptionPricingTiers) {
                                    $groupData = [];
                                    $groupData['title'] = "Participants";
                                    $groupData['totalParticipants'] = $total;

                                    $retail_price = $ProductOptionPricingTiers->retail_price;
                                    $beforeDiscountGroupPrice = $retail_price;
                                    $beforeDiscountAmount += $beforeDiscountGroupPrice;
                                    if ($percentage > 0) {
                                        $percentageAmount = ($retail_price * $percentage) / 100;
                                        $retail_price  = $retail_price - $percentageAmount;
                                    }
                                    $groupPrice = $retail_price;
                                    $groupData['pricePerPerson'] = $retail_price;

                                    $groupData['totalPrice'] = $groupPrice;
                                    $totalAmount += $groupPrice;
                                    $groupData['formattedValue'] = get_price_front($product_id, '', '', '', $groupPrice);
                                    $price_brakdown[] = $groupData;
                                }
                            }
                        } else {
                            $row['require_participants_msg']  = 'Booking for this date is not available, please select a different date.';
                            $row['require_participants']         = false;
                        }
                    }



                    $row['price_brakdown'] = $price_brakdown;
                    $row['totalAmount'] = $totalAmount;
                    $row['formatTotalAmount'] = get_price_front($product_id, '', '', '', $totalAmount);

                    if ($percentage > 0) {
                        $row['deal']['originalPrice'] = $beforeDiscountAmount;
                        $row['deal']['percentage'] = $percentage;
                        $percentageAmount = ($beforeDiscountAmount * $percentage) / 100;
                        $totalAmount  = $beforeDiscountAmount - $percentageAmount;
                        $row['deal']['formatTotalAmount'] = get_price_front($product_id, '', '', '', $totalAmount);
                        $row['deal']['formatoriginalPrice'] = get_price_front($product_id, '', '', '', $beforeDiscountAmount);
                    } else {
                        $row['deal'] = '';
                    }



                    $ProductOptionAvailability = ProductOptionAvailability::where(["product_id" => $product_id, 'pricing_id' => $ProductOptionPricing->id, 'option_id' => $PO['id']])->first();
                    $row['time_slot'] = [];
                    if ($ProductOptionAvailability) {
                        $TimeSlot = [];
                        if ($date != "") {
                            if ($ProductOptionAvailability->time_json != "") {
                                $time_json = json_decode($ProductOptionAvailability->time_json);

                                foreach ($time_json as $TJkey => $TJ) {
                                    if ($TJkey == $day) {

                                        if ($TJ > 0 && $TJ != "") {
                                            foreach ($TJ as $TJkey1 => $TJvalue) {
                                                if ($TJkey1 == 0) {
                                                    $TimeSlot = [];
                                                }
                                                $TimeSlot[] = Carbon::parse($TJvalue)->format('g:i A');
                                            }
                                        }
                                    }
                                }
                            }



                            if ($ProductOptionAvailability->date_json != "") {
                                $date_json = json_decode($ProductOptionAvailability->date_json);
                                foreach ($date_json as $DJkey => $DJ) {
                                    // dd($date, $DJkey);
                                    if ($DJkey == date('Y-m-d', strtotime($date))) {
                                        if ($DJkey == 0) {
                                            $TimeSlot = [];
                                        }
                                        if ($DJ > 0 && $DJ != "") {
                                            foreach ($DJ as $DJkey1 => $DJvalue) {
                                                if ($DJkey1 == 0) {
                                                    $TimeSlot = [];
                                                }
                                                $TimeSlot[] = Carbon::parse($DJvalue)->format('g:i A');
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $row['time_slot'] =  $TimeSlot;
                    }
                    $cancel_msg = "";
                    if ($PO['is_cancelled'] == true) {
                        $new_date_time = "";
                        $cancel_msg = "";
                        $cancel_time = "";
                        if ($request->time_slot != "") {
                            $new_time =  Carbon::parse($request->time_slot)->format('H:i:s');

                            $new_date_time = date('Y-m-d H:i:s', strtotime($request->date . " " . $new_time));
                        } else {
                            $Parsedate = Carbon::parse($request->date)->subDay(1)->format('Y-m-d');

                            $new_date_time = date('Y-m-d H:i:s', strtotime($Parsedate . " " . "23:59:59"));
                        }





                        if ($new_date_time != "") {
                            if ($PO['cancelled_type'] == "hour") {
                                $cancel_time = date('Y-m-d H:i:s', strtotime($new_date_time . " -" . $PO['cancelled_time'] . " hour"));
                            }
                            if ($PO['cancelled_type'] == "day") {
                                $cancel_time = date('Y-m-d H:i:s', strtotime($new_date_time . ' -' . $PO['cancelled_time'] . ' day'));
                            }
                        }
                        // }    
                        if ($cancel_time != "") {
                            $cancel_msg = "Cancel before " . Carbon::parse($cancel_time)->format('g:i A') . " on " . date('M d', strtotime($cancel_time)) . " for a full refund";
                        }



                        if (strtotime($cancel_time) < strtotime(date("Y-m-d H:i:s"))) {
                            $cancel_time = "";
                            $cancel_msg = "";
                        }
                        if ($get_option_id != $PO['id']) {
                            $cancel_msg = "";
                        }
                    }

                    $row['cancel_msg'] =  $cancel_msg;

                    $data[]                    = $row;
                }
            }
            $output['status']        = true;
        }

        $output['data']          = $data;

        $output['status_code']   = 200;
        $output['message']       = "Data Fetch Successfully";
        return json_encode($output);
    }



    // Product Top Attraction Listing
    public function top_attraction_listing(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language' => 'required',
            'currency' => 'required',
            'attraction_slug' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(
                [
                    'status'  => false,
                    'message' => $validation->errors()->first(),
                ],
                402,
            );
        }

        $language_id  = $request->language;
        $setLimit     = 9;
        $offset       = $request->offset;
        $limit        = $offset * $setLimit;
        $data  = [];
        $attraction_slug = $request->attraction_slug;
        $attraction = TopAttraction::where(['slug' => $attraction_slug, 'is_delete' => null, 'status' => 'Active'])->first();

        if ($attraction) {
            $top_attraction_title = "No title";
            $where = ['products.is_delete' => null, 'products.status' => 'Active', 'products.is_approved' => 'Approved'];
            $Product  = Product::where($where)->where('slug', '!=', '')->whereRaw("FIND_IN_SET($attraction->id, top_attraction)")

                ->select('products.*', 'product_option.wheelchair_accessibility', 'product_option.existing_line', 'product_not_suitable.product_id', 'product_option_pricing_tiers.retail_price', 'product_option_availability.time_json', 'product_option_availability.product_id')
                ->leftJoin('products_description', 'products.id', '=', 'products_description.product_id')
                ->leftJoin('product_option_availability', 'products.id', '=', 'product_option_availability.product_id')
                ->leftJoin('product_option', 'product_option.product_id', '=', 'products.id')
                ->leftJoin('product_option_pricing_tiers', 'product_option_pricing_tiers.product_id', '=', 'products.id')
                ->leftJoin('product_not_suitable', 'product_not_suitable.product_id', '=', 'products.id');





            $productIds = [];
            if (isset($request->is_filter) && $request->is_filter == 1) {


                $time_filter = $request->time_filter;

                if (isset($time_filter)) {

                    foreach ($time_filter as $key => $value) {
                        $time_arr  = explode('-', $value);
                        $time1 = $time_arr[0];
                        $time2 = $time_arr[1];

                        $CheckAvailabileProduct =   Product::where($where)->where('slug', '!=', '')
                            ->select('products.*', 'product_option_availability.time_json', 'product_option_availability.date_json', 'product_option_availability.product_id')
                            ->leftJoin('product_option_availability', 'products.id', '=', 'product_option_availability.product_id')
                            ->whereDate('product_option_availability.valid_to', '>=', date('Y-m-d'))
                            ->get();

                        if (!$CheckAvailabileProduct->isEmpty()) {
                            foreach ($CheckAvailabileProduct as $AvailabileProductkey => $AvailabileProductvalue) {

                                if ($AvailabileProductvalue['time_json'] && $AvailabileProductvalue['time_json'] != null) {
                                    foreach (json_decode($AvailabileProductvalue['time_json']) as $key => $value) {
                                        # code...

                                        if (!is_int($key)) {


                                            $new = array_filter($value, function ($var) use ($time1, $time2, $AvailabileProductvalue) {

                                                return ((int)$var >= (int)$time1 && (int)$var <= (int)$time2);
                                            });
                                            if (count($new) > 0) {
                                                $productIds[] = $AvailabileProductvalue['product_id'];
                                            }
                                        }
                                    }
                                } else {
                                    $productIds[] = $AvailabileProductvalue['product_id'];
                                }


                                if ($AvailabileProductvalue['date_json'] && $AvailabileProductvalue['date_json'] != null) {
                                    foreach (json_decode($AvailabileProductvalue['date_json']) as $dkey => $dvalue) {
                                        # code...

                                        if ($dkey >= date("Y-m-d")) {


                                            $new = array_filter($dvalue, function ($var) use ($time1, $time2, $AvailabileProductvalue) {

                                                return ((int)$var >= (int)$time1 && (int)$var <= (int)$time2);
                                            });
                                            if (count($new) > 0) {
                                                $productIds[] = $AvailabileProductvalue['product_id'];
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                $productIds = array_unique($productIds);


                // Category Filter
                $category_filter = $request->category_filter;
                if (isset($category_filter)) {
                    $Product = $Product->where(function ($data) use ($category_filter) {
                        foreach ($category_filter  as $CF) {
                            $data->orWhere('category', $CF);
                        }
                    });
                }

                // interest Filter
                $interest_filter = $request->interest_filter;
                if (isset($interest_filter)) {
                    $Product = $Product->where(function ($data) use ($interest_filter) {
                        foreach ($interest_filter  as $IF) {
                            $data->orWhereRaw('FIND_IN_SET(?, interest)', [$IF]);
                        }
                    });
                }


                // Service Filter
                $service_filter = $request->service_filter;
                if (isset($service_filter)) {
                    $Product = $Product->where(function ($data) use ($service_filter) {
                        foreach ($service_filter  as $SF) {
                            if ($SF == 20) {
                                $data->orWhere('product_option.wheelchair_accessibility', 'yes');
                            }
                            if ($SF == 19) {
                                $data->orWhere('product_option.is_private', 'Private');
                            }
                            if ($SF == 17) {
                                $data->orWhere('product_not_suitable.product_id', '=', 'products.id');
                            }

                            if ($SF == 16) {
                                $data->orWhere('product_option.existing_line', 'yes');
                            }
                        }
                    });
                }

                // Price Filter
                $min_price_filter = $request->min_price_filter;
                if (isset($min_price_filter)) {

                    $Product = $Product->where(function ($data) use ($min_price_filter) {

                        $data->where('product_option_pricing_tiers.retail_price', '>=', $min_price_filter);
                    });
                }

                if (isset($max_price_filter)) {

                    $Product = $Product->where(function ($data) use ($max_price_filter) {

                        $data->where('product_option_pricing_tiers.retail_price', '>=', $max_price_filter)->orderBy('product_option_pricing_tiers.retail_price', 'desc');
                    });
                }
            }

            $Product = $Product->groupBy('products.id');

            if (count($productIds) > 0) {
                $Product = $Product->whereIn('products.id', $productIds);
            }

            $ProductCount = count($Product->get());

            // Sort Code Filter
            // if (isset($request->is_filter) && $request->is_filter == 1) {

            //     if (isset($request->sort)) {
            //         if ($request->sort == "atz") {
            //             $Product = $Product->orderBy('products_description.title', 'ASC');
            //         }

            //         if ($request->sort == "zta") {
            //             $Product = $Product->orderBy('products_description.title', 'DESC');
            //         }
            //     }
            // } else {
            $Product = $Product->orderBy('products.id', 'DESC');
            // }

            $Product = $Product->get();



            $list =  getProductArr($Product, $language_id, $request->user_id);

            $ProductCount = count($list);
            if (isset($request->is_filter) && $request->is_filter == 1) {
                if (isset($request->sort)) {
                    $price = array_column($list, 'price_val');
                    $title = array_column($list, 'title');
                    if ($request->sort == "htl") {
                        array_multisort($price, SORT_DESC, $list);
                    } elseif ($request->sort == "atz") {
                        array_multisort($title, SORT_ASC, $list);
                    } elseif ($request->sort == "zta") {
                        array_multisort($title, SORT_DESC, $list);
                    } else {
                        array_multisort($price, SORT_ASC, $list);
                    }
                }
            }


            $list = array_slice($list, $limit, $setLimit);
            $data['list'] = $list;
            $Countries = Countries::find($attraction->country);
            $country_name = "";
            if ($Countries) {
                $country_name = $Countries->name;
            }
            $data['footer_data'] = [];
            $slug = "";
            $GetTopAttraction = TopAttraction::where(['city' => $attraction->city, 'is_delete' => null])->where('id', '!=', $attraction->id)->get();
            if (count($GetTopAttraction) == 0) {
                $GetTopAttraction = TopAttraction::where(['state' => $attraction->state, 'is_delete' => null])->where('id', '!=', $attraction->id)->get();
                if (count($GetTopAttraction) == 0) {
                    $GetTopAttraction = TopAttraction::where(['country' => $attraction->country, 'is_delete' => null])->where('id', '!=', $attraction->id)->get();
                    if (count($GetTopAttraction) > 0) {
                        $Countries = Countries::find($attraction->country);
                        if ($Countries) {
                            $slug = $Countries->name;
                        }
                    }
                } else {
                    $States = States::find($attraction->state);
                    if ($States) {
                        $slug = $States->name;
                    }
                }
            } else {
                $Cities = Cities::find($attraction->city);
                if ($Cities) {
                    $slug = $Cities->name;
                }
            }
            if (count($GetTopAttraction) > 0) {

                $TopAttractionData = $GetTopAttraction;
                foreach ($TopAttractionData as $key => $TAD) {
                    $TopAttractionDescription = TopAttractionDescription::where("attraction_id", $TAD['id'])->first();
                    if ($TopAttractionDescription) {
                        $top_attraction_arr = $TAD;
                        $top_attraction_arr['title'] =   $TopAttractionDescription->title;
                        $top_attraction_arr['slug'] = 'attraction-listing/' . $TAD['slug'];
                        $data['footer_data']['Top Attractions in ' . $slug][] = $top_attraction_arr;
                    }
                }
            }
            if ($country_name != "") {
                $stateData = ProductLocation::where('country',  $country_name)->groupBy('product_id', 'state')->get();
                foreach ($stateData as $key => $SD) {
                    $stateArr          = [];
                    $stateArr['id']    = $SD['id'];
                    $stateArr['title'] = $SD['state'];
                    $stateArr['slug']  = "destination-listing/" . $SD['state'];
                    if ($SD['state'] != "") {
                        $data['footer_data']['Cities in ' . $slug][] = $stateArr;
                    }
                }
            }

            $TopDesc = TopAttractionDescription::where("attraction_id", $attraction->id)->first();
            if ($TopDesc) {

                $top_attraction_title = $TopDesc->title;
            }

            $data['page_data']['title'] = $top_attraction_title;
            $data['page_data']['image'] = asset("uploads/top_attraction/" . $attraction->image);



            $output['page_count']    = ceil($ProductCount / $setLimit);
            $output['product_count'] = $ProductCount;
            $output['data']          = $data;
            $output['status']        = true;
            $output['status_code']   = 200;
            $output['message']       = "Data Fetch Successfully";
        }
        return json_encode($output);
    }
}
