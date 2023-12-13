<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarDetails;
use App\Models\Language;
use App\Models\Product;
use App\Models\ProductAdditionalInfoLanguage;
use App\Models\ProductAddtionalInfo;
use App\Models\ProductFaqLanguage;
use App\Models\ProductFaqs;
use App\Models\ProductGroupPercentage;
use App\Models\ProductGroupPercentageDetails;
use App\Models\ProductGroupPercentageLanguage;
use App\Models\ProductHighlightLanguage;
use App\Models\ProductHighlights;
use App\Models\ProductImages;
use App\Models\ProductInfo;
use App\Models\ProductLanguage;
use App\Models\ProductLodge;
use App\Models\ProductLodgeLanguage;
use App\Models\ProductOptionDetails;
use App\Models\ProductCategory;
use App\Models\OverRideBanner;
use App\Models\ProductOptionGroupPercentage;
use App\Models\ProductOptionLanguage;
use App\Models\ProductOptionPeriodPricing;
use App\Models\ProductOptionPrivateTourPrice;
use App\Models\ProductOptions;
use App\Models\ProductOptionTaxServiceCharge;
use App\Models\ProductOptionTourUpgrade;
use App\Models\ProductOptionWeekTour;
use App\Models\ProductPrivateTransferCars;
use App\Models\ProductSiteAdvertisement;
use App\Models\ProductSiteAdvertisementLanguage;
use App\Models\ProductTimings;
use App\Models\ProductToolTipLanguage;
use App\Models\ProductTourPriceDetails;
use App\Models\OverRideBannerLanguage;
use App\Models\Timing;
use App\Models\AddToCart;
use App\Models\Category;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Models\Wishlist;

class WishlistController extends Controller
{
    //Add WishList
    public function add_wishlist(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $validation = Validator::make($request->all(), [
            // 'language'    => 'required',
            'user_id'     => 'required',
            'product_id'  => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validation->errors()->first(),
                ],
                402,
            );
        }
        $getWishlist = Wishlist::where('user_id',$request->user_id)->where('product_id',$request->product_id)->first();
        if($getWishlist){
            $getWishlist->delete();
            $output['status']      = false;
            $output['message']     = 'Remove Wishlist Successfully...';
        }else{

            $Wishlist             = new Wishlist();
            $Wishlist->user_id    = $request->user_id;
            $Wishlist->product_id = $request->product_id;
            $Wishlist->save();
            $output['status']     = true;
            $output['message']    = 'Add Wishlist Successfully...';
        }
        return json_encode($output);
    }


    //Wislist List
    public function wishlist_list(Request $request)
    {
        $output            = [];
        $output['status']  = false;
        $output['message'] = "Record Not Found";
        $validation = Validator::make($request->all(), [
            'language'    => 'required',
            'user_id'     => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validation->errors()->first(),
                ],
                402,
            );
        }
        $data        = [];
        $language    = $request->language;
        $user_id     = $request->user_id;
        $setLimit    = 10;
        $offset      = 0;
        if($request->offset){
            $offset      = $request->offset ;
        }
        $limit       = $offset * $setLimit;
        
        $getWishlist = Wishlist::where('user_id',$request->user_id)->orderBy('id','desc');
        $getWishlistCount = $getWishlist->count();
        $getWishlist = $getWishlist->offset($limit)->limit($setLimit)->get();
        if(!$getWishlist->isEmpty()){
            foreach($getWishlist as $key => $value) {
                # code...
                $Product                        = Product::where(['status' => 'Active', 'is_delete' => 0,])->where('slug', '!=', '')->where('products.id',$value['product_id'])->first();
                if($Product){
                    $get_wishlist_arr                 = [];
                    $get_wishlist_arr['title']        = '';
                    $get_wishlist_arr['description']  = '';
                    $productLang                      = ProductLanguage::where(['product_id' => $Product['id'], 'language_id' => $language])->first();
                    if($productLang){
                        $get_wishlist_arr['title']        = $productLang['description']      != '' ? $productLang['description'] : '';
                        $get_wishlist_arr['description']  = $productLang['main_description'] != '' ?Str::limit($productLang['main_description'], 60) : '';

                    }
                    $get_wishlist_arr['id']         = $value['id'];
                    $get_wishlist_arr['product_id'] = $Product['id'];
                    $get_wishlist_arr['slug']       = $Product['slug'];
                    if ($Product['product_type'] == 'excursion') {
                        $get_wishlist_arr['slug'] = '/activities-detail/' . $Product['slug'];
                    } elseif ($Product['product_type'] == 'yacht') {
                        $get_wishlist_arr['slug'] = '/yacht-charts-details/' . $Product['slug'];
                    } elseif ($Product['product_type'] == 'lodge') {
                        $get_wishlist_arr['slug'] = '/lodge-detail/' . $Product['slug'];
                    } elseif ($Product['product_type'] == 'limousine') {
                        $get_wishlist_arr['slug'] = '/limousine-detail/' . $Product['slug'];
                    }
                    $get_wishlist_arr['product_type'] = $Product['product_type'];
                    $get_wishlist_arr['image']        = $Product['image']            != '' ? asset('public/uploads/product_images/' . $Product['image']) : asset('public/assets/img/no_image.jpeg');
                    $data[]                           = $get_wishlist_arr;
                }

            }
            $output['data']       = $data;
            $output['page_count'] = ceil($getWishlistCount / $setLimit);
            $output['status']     = true;
            $output['message']    = "Wishlist Product List";
        }  
        return json_encode($output);
    }

}
