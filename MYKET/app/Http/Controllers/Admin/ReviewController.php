<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\UserReview;
use App\Models\User;
use App\Models\UserReviewDescription;
use App\Models\ProductDescription;
use App\Models\Languages;
use Illuminate\Support\Str;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $common          = array();
        $common['title'] = "Reviews";
        Session::put("TopMenu", "Products");
        Session::put("SubMenu", "Reviews");

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $get_review = UserReview::orderBy('id', 'desc')->paginate(config('adminconfig.records_per_page'));

        $Reviews = [];
        if (!empty($get_review)) {
            foreach ($get_review as $key => $value) {
                $row  = getLanguageData('user_review_description', $language_id, $value['id'], 'review_id');
                $ProductDescription = ProductDescription::where(['product_id' => $value['product_id'], 'language_id' => $language_id])->first();
                $row['product_name']  = "No title";
                if ($ProductDescription) {
                    $row['product_name'] = $ProductDescription->title;
                }

                $User = User::find($value['user_id']);
                $row['user_name'] = '';
                $row['email'] = '';
                if ($User) {
                    $row['user_name'] = $User->first_name . " " . $User->last_name;
                    $row['email'] = $User->email;
                }
                $row['id']          = $value['id'];
                $row['user_id']     = $value['user_id'];
                $row['product_id']  = $value['product_id'];
                $row['order_id']    = $value['order_id'];
                $row['option_id']   = $value['option_id'];
                $row['rating']      = $value['rating'];
                $row['status']      = $value['status'];
                $Reviews[] = $row;
            }
        }

        return view('admin.reviews.index', compact('common', 'get_review', 'Reviews'));
    }


    public function change_status(Request $request)
    {
        $id = $request->id;
        $is_approved = $request->is_approved;

        $UserReview = UserReview::find($id);
        if ($UserReview) {
            $UserReview->status = $is_approved;
            $UserReview->save();
        }
    }
}
