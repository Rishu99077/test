<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guide;
use App\Models\Guideimages;
use App\Models\Guidedescriptions;
use App\Models\Guidehighlights;
use App\Models\Guidehighlightdescriptions;
use App\Models\Guidefaqs;
use App\Models\GuideFaqdescriptions;
use Illuminate\Support\Facades\Validator;

class GuideController extends Controller
{

    // Guide List
    public function guide_list(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";

        $validation = Validator::make($request->all(), [
            'language' => 'required',
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
        $setLimit     = 8;
        $offset       = $request->offset;
        $limit        = $offset * $setLimit;
        $data  = [];
        $get_guide_count = Guide::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')->count();
        $get_guide = Guide::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
            ->offset($limit)
            ->limit($setLimit)
            ->get();

        $Guide = array();
        if (!empty($get_guide)) {
            foreach ($get_guide as $key => $value) {
                $row  = getLanguageData('guide_descriptions', $language_id, $value['id'], 'guide_id');
                $row['id']              = $value['id'];
                $row['status']          = $value['status'];
                $row['slug']          = $value['slug'];
                $row['image']           = $value['image'] != "" ? asset('uploads/guide/' . $value['image']) : asset('uploads/products/dummyicon.png');
                $Guide[] = $row;
            }
            $output['page_count'] = ceil($get_guide_count / $setLimit);
            $output['data'] = $Guide;
            $output['status'] = true;
            $output['status_code'] = 200;
            $output['message'] = "Data Fetch Successfully";
        }
        return json_encode($output);
    }

    // Guide Details
    public function guide_detail(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language' => 'required',
            'id' => 'required',
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
        $guide_slug = $request->id;
        $Guide  = Guide::where(['slug' => $guide_slug, 'status' => 'Active'])->whereNull('is_delete')->first();
        if ($Guide) {
            $id = $Guide->id;
            $row           = getLanguageData('guide_descriptions', $language_id, $id, 'guide_id');

            // highlight
            $row['highlight'] = [];
            $get_additional_highlights      = Guidehighlights::where('guide_id', $id)->get();
            if (!$get_additional_highlights->isEmpty()) {
                foreach ($get_additional_highlights as $key => $value) {
                    // $arr = [];
                    $arr  = getLanguageData('guide_highlight_descriptions', $language_id, $value['id'], 'guide_highlight_id');
                    $arr['id']                    = $value['id'];
                    $row['highlight'][] = $arr;
                }
            }

            // Slider
            $row['slider'] = [];
            $get_additional_images      = Guideimages::where('guide_id', $id)->get();
            if (!$get_additional_images->isEmpty()) {
                foreach ($get_additional_images as $key => $value) {
                    $arr = [];
                    $arr['id']                    = $value['id'];
                    $arr['guide_gallery_image']   = asset('uploads/guide/gallery/' . $value['guide_gallery_image']);
                    $row['slider'][] = $arr;
                }
            }

            // faq
            $row['faq'] = [];
            $get_additional_faqs      = Guidefaqs::where('guide_id', $id)->get();
            if (!$get_additional_faqs->isEmpty()) {
                foreach ($get_additional_faqs as $key => $value_5) {
                    // $arr = [];
                    $arr  = getLanguageData('guide_faqs_descriptions', $language_id, $value_5['id'], 'guide_faq_id');
                    $arr['id']                    = $value_5['id'];
                    $row['faq'][] = $arr;
                }
            }

            $row['id']       = $Guide->id;
            $row['status']   = $Guide->status;
            $row['image']    = $Guide->image != "" ? asset('uploads/guide/' . $Guide->image) : asset('uploads/products/dummyicon.png');

            $output['data'] = $row;
            $output['status'] = true;
            $output['status_code'] = 200;
            $output['message'] = "Data Fetch Successfully";
        }
        return json_encode($output);
    }
}
