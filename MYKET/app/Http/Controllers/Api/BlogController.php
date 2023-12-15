<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blogs;
use App\Models\Blogdescriptions;
use App\Models\Blogcategorydescriptions;
use App\Models\Blogtocategories;
use App\Models\Blogcategory;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{

    public function blog_list(Request $request)
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
        $setLimit     = 9;
        $offset       = $request->offset;
        $limit        = $offset * $setLimit;
        $data  = [];
        $get_blogs_count = Blogs::orderBy('id', 'desc')->where(['status' => 'Active'])->where('slug', '!=', '')->whereNull('is_delete')->count();
        $get_blogs = Blogs::orderBy('id', 'desc')->where(['status' => 'Active'])->where('slug', '!=', '')->whereNull('is_delete')
            ->offset($limit)
            ->limit($setLimit)
            ->get();

        $Blogs = array();
        if (!empty($get_blogs)) {
            foreach ($get_blogs as $key => $value) {
                $row           = getLanguageData('blog_descriptions', $language_id, $value['id'], 'blog_id');

                $Blogtocategories = Blogtocategories::where(['blog_id' => $value['id']])->get();
                $blog_category_arr = [];
                foreach ($Blogtocategories as $key => $BTC) {
                    $blog_categories_descriptions = getLanguageData('blogcategory_descriptions', $language_id, $BTC['blogcategory_id'], 'blogcategory_id');
                    if ($blog_categories_descriptions) {
                        $blog_category_arr[] = $blog_categories_descriptions['title'];
                    }
                }

                $row['id']       = $value['id'];
                $row['status']   = $value['status'];
                $row['slug']   = $value['slug'];
                $row['category'] = implode(',', $blog_category_arr);
                $row['date']     = date('d/M/Y', strtotime($value['created_at']));
                $row['image']    = $value['image'] != "" ? asset('uploads/blogs/' . $value['image']) : asset('uploads/products/dummyicon.png');
                $Blogs[]         = $row;
            }
            $output['page_count'] = ceil($get_blogs_count / $setLimit);
            $output['data'] = $Blogs;
            $output['status'] = true;
            $output['status_code'] = 200;
            $output['message'] = "Data Fetch Successfully";
        }

        return json_encode($output);
    }


    // Blog Details
    public function blog_details(Request $request)
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
        $blog_slug = $request->id;
        $Blog  = Blogs::where(['slug' => $blog_slug, 'status' => 'Active'])->whereNull('is_delete')->first();
        if ($Blog) {


            $row           = getLanguageData('blog_descriptions', $language_id, $Blog->id, 'blog_id');

            $Blogtocategories = Blogtocategories::where(['blog_id' => $Blog->id])->get();
            $blog_category_arr = [];
            foreach ($Blogtocategories as $key => $BTC) {
                $blog_categories_descriptions = getLanguageData('blogcategory_descriptions', $language_id, $BTC['blogcategory_id'], 'blogcategory_id');
                if ($blog_categories_descriptions) {
                    $blog_category_arr[] = $blog_categories_descriptions['title'];
                }
            }

            $row['id']       = $Blog->id;
            $row['status']   = $Blog->status;
            $row['category'] = implode(',', $blog_category_arr);
            $row['date']     = date('d/M/Y', strtotime($Blog->created_at));
            $row['image']    = $Blog->image != "" ? asset('uploads/blogs/' . $Blog->image) : asset('uploads/products/dummyicon.png');

            $top_post =   Blogs::orderBy('id', 'desc')->where(['status' => 'Active'])->where('slug', '!=', '')->whereNull('is_delete')->where('top_post', 1)->get();

            $blog_data['top_post'] = [];
            if (!empty($top_post)) {
                foreach ($top_post as $TPkey => $TP) {
                    $blog_descriptions  = getLanguageData('blog_descriptions', $language_id, $TP['id'], 'blog_id');
                    $blog_descriptions['id']     = $TP['id'];
                    $blog_descriptions['status'] = $TP['status'];
                    $blog_descriptions['image']  =  $TP['image'] != "" ? asset('uploads/blogs/' . $TP['image']) : asset('uploads/products/dummyicon.png');
                    $row['top_post'][] = $blog_descriptions;
                }
            }



            $output['data'] = $row;
            $output['status'] = true;
            $output['status_code'] = 200;
            $output['message'] = "Data Fetch Successfully";
        }
        return json_encode($output);
    }
}
