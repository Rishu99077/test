<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\UserReview;
use App\Models\Customers;

use App\Models\Country;
use App\Models\City;

use App\Models\Rewards;
use App\Models\RewardsLanguage;
use App\Models\Language;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;

class RewardController extends Controller
{
    
    public function reward_list(Request $request)
    {
        $output            = [];
        $output['status']  = false;
        $output['message'] = 'Record Not Found';
        $validation = Validator::make($request->all(), [
            'language' => 'required',
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


        $get_list_arr  = [];
        $language      = $request->language;

        $setLimit     = 10;
        $offset       = $request->offset;
        $limit        = $offset * $setLimit;
        
        //Products
        $get_list_arr  = [];
        $RewardCount = Rewards::where('status', 'Active')->orderBy('id', 'DESC')->get();

        $RewardCount = $RewardCount->count();

        $get_reward_details = Rewards::where('status', 'Active')->offset($limit)->orderBy('id', 'desc')->limit($setLimit)->get();

        if (!$get_reward_details->isEmpty()) {
            foreach ($get_reward_details as $key => $get_detail) {
              
                $get_details_arr                 = array();
                $get_details_arr['id']           = encrypt($get_detail['id']);

                $get_details_arr['title'] = '';

                $get_rewards_language = RewardsLanguage::where('reward_id', $get_detail['id'])
                    ->where('language_id', $language)
                    ->first();
                if ($get_rewards_language) {
                    $get_details_arr['title'] = $get_rewards_language['title'];
                }

                $get_details_arr['share_points'] = $get_detail['share_points'];
                $get_details_arr['image']        = $get_detail['image'] != '' ? url('uploads/product_images', $get_detail['image']) : asset('uploads/placeholder/placeholder.png');
                $get_details_arr['instagram']    = $get_detail['instagram'];
                $get_details_arr['facebook']     = $get_detail['facebook'];
                $get_details_arr['twitter']      = $get_detail['twitter'];
                $get_details_arr['youtube']      = $get_detail['youtube'];

               
                $get_details_arr['date']           = date('Y-m-d', strtotime($get_detail['created_at']));
                
                $get_list_arr[] = $get_details_arr;
            }
        }

        if (count($get_list_arr) > 0) {
            $output['status']                  = true;
            $output['data']                    = $get_list_arr;
            $output['page_count']              = ceil($RewardCount / $setLimit);
            $output['message']                 = "Reward share Points";
        }
        return json_encode($output);
    }
}
