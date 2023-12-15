<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\WishlistActivity;
use App\Models\Languages;
use App\Models\Currency;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class WishlistApiController
{
    // Add or Remove Wishlist
    public function add_wishlist(Request $request)
    {

        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Something went Wrong";
        $validator = Validator::make($request->all(), [
            'product_id'  => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->errors()->first(),
                ],
                402,
            );
        }

        $Product = Product::where(['slug' => $request->product_id, 'is_delete' => null, 'status' => 'Active'])->first();
        if ($Product) {
            $ProductID = $Product->id;
            $wishlist = Wishlist::where('user_id', $request->user_id)->where('product_id', $ProductID)->first();
            if ($wishlist) {
                $wishlist->delete();
                $output['status']      = false;

                $output['message']     = "Removed from wishlist";
            } else {
                $wishlist              = new Wishlist;
                $wishlist->user_id     = $request->user_id;
                $wishlist->product_id  = $ProductID;
                $wishlist->save();
                $output['status']      = true;
                $output['status_code'] = 200;
                $output['message']     = "Added to wishlist";
            }
        }
        return json_encode($output);
    }

    // Get Wishlist List

    public function get_wishlist(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'No record found';

        $user_id     = $request->user_id;
        $language_id = $request->language;
        $activity_id = $request->activity_id;

        $Wishlist    = Wishlist::where(['user_id' => $user_id, 'activity_id' => $activity_id])->get();
        $Product     = [];
        $data        = [];

        foreach ($Wishlist as $Wkey => $W) {
            $ProductID = $W['product_id'];
            $ProductDetails = Product::where(['id' => $ProductID, 'is_delete' => null, 'status' => 'Active'])->first();
            if ($ProductDetails) {
                $Product[] = $ProductDetails;
            }
        }
        $data = getProductArr($Product, $language_id, $user_id, $short_dec_limit = 50);
        $output['status']      = true;
        $output['status_code'] = 200;
        $output['data']        = $data;
        $output['message']     = "Wishlist List";
        return json_encode($output);
    }


    // Add Wishlist Activity
    public function add_wishlist_activity(Request $request)
    {

        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Something went Wrong";
        $validator = Validator::make($request->all(), [
            'product_id'  => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->errors()->first(),
                ],
                402,
            );
        }


        $Product = Product::where(['id' => $request->product_id, 'is_delete' => null, 'status' => 'Active'])->first();
        if ($Product) {
            $ProductID    = $Product->id;
            if ($request->activity_id) {
                $wishlist_act = WishlistActivity::where('id', $request->activity_id)->first();
            } else {
                $wishlist_act  = WishlistActivity::where(['country' => $request->country, 'user_id' => $request->user_id])->first();
                if (!$wishlist_act) {
                    $wishlist_act              = new WishlistActivity;
                    $wishlist_act->user_id     = $request->user_id;
                    $wishlist_act->product_id  = $ProductID;
                    $wishlist_act->country     = $request->country;
                    $wishlist_act->save();
                }
            }

            $wishlist = Wishlist::where('user_id', $request->user_id)->where('product_id', $ProductID)->first();
            if ($wishlist) {
            } else {
                $wishlist              = new Wishlist;
                $wishlist->user_id     = $request->user_id;
                $wishlist->product_id  = $ProductID;
                $wishlist->activity_id = $wishlist_act->id;
                $wishlist->save();
            }


            $output['status']      = true;
            $output['status_code'] = 200;
            $output['message']     = "Wishlist Added Successfully";
        }
        return json_encode($output);
    }



    // Get Wishlist Activity List
    public function get_wishlist_activity_list(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['message'] = 'No record found';

        $user_id     = $request->user_id;
        $language_id = $request->language;

        $WishlistActivity   = WishlistActivity::where('user_id', $user_id)->get()->toArray();

        $data        = [];
        foreach ($WishlistActivity as $Wkey => $W) {
            $row = array();
            $row['id'] = $W['id'];
            $row['activity_count'] = '1';
            $get_wishlist = Wishlist::where('activity_id', $W['id'])->get();
            if ($get_wishlist) {
                $row['activity_count'] = count($get_wishlist);
            }

            $row['user_id']     = $W['user_id'];
            $row['product_id']  = $W['product_id'];
            $row['country']     = $W['country'];
            $row['image']       = asset('uploads/placeholder/placeholder.png');
            $ProductDetails = Product::where(['id' => $W['product_id'], 'is_delete' => null, 'status' => 'Active'])->first();
            if ($ProductDetails) {
                $row['image'] = asset('uploads/products/' . $ProductDetails->cover_image);;
            }
            $data[] = $row;
        }

        $output['status']      = true;
        $output['status_code'] = 200;
        $output['data_count']  = count($data);
        $output['data']        = $data;

        $output['message']     = "Wishlist Activity List";
        return json_encode($output);
    }


    // Remove Wishlist
    public function remove_wishlist(Request $request)
    {

        // dd($request->all());
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Something went Wrong";

        if (isset($request->product_id)) {
            $req_fields['product_id'] = "required";
        }
        if (isset($request->activity_id)) {
            $req_fields['activity_id'] = "required";
        }

        $errormsg = [
            "product_id"                     => translate("Product ID"),
            "activity_id"                     => translate("Wishlist Activity ID"),
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


        if (isset($request->activity_id)) {

            $wishlist_act = WishlistActivity::where(['id' => $request->activity_id, 'user_id' => $request->user_id])->delete();
            $wishlist = Wishlist::where('user_id', $request->user_id)->where('activity_id', $request->activity_id)->delete();

            $output['status']      = true;
            $output['message']     = "Removed wishlist activity";
        } else {

            $Product = Product::where(['slug' => $request->product_id, 'is_delete' => null, 'status' => 'Active'])->first();
            if ($Product) {
                $ProductID = $Product->id;
                $wishlist = Wishlist::where('user_id', $request->user_id)->where('product_id', $ProductID)->first();
                // $wishlist_act = WishlistActivity::where('user_id', $request->user_id)->where('product_id', $ProductID)->first();
                if ($wishlist) {
                    $wishlist->delete();
                    // $wishlist_act->delete();

                    $output['status']      = true;
                    $output['message']     = "Removed from wishlist";
                }
            }
        }
        return json_encode($output);
    }
}
