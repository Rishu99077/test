<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\ProductFood;
use App\Models\ProductFoodDescription;
use App\Models\Languages;
use Illuminate\Support\Str;

class TimeofDayController extends Controller
{
    public function index(Request $request)
    {
        $common          = array();
        $common['title'] = "Time of Day";
        Session::put("TopMenu", "Products");
        Session::put("SubMenu", "Time of Day");

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $get_timeofday_food = ProductFood::orderBy('id', 'desc')->where('type', 'time_of_day')->whereNull('is_delete')
            ->paginate(config('adminconfig.records_per_page'));

        $Products = [];
        if (!empty($get_timeofday_food)) {
            foreach ($get_timeofday_food as $key => $value) {
                $row  = getLanguageData('products_food_descriptions', $language_id, $value['id'], 'product_food_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $row['type']   = $value['type'];
                $Products[] = $row;
            }
        }

        return view('admin.productsfood.timeofday.index', compact('common', 'get_timeofday_food', 'Products'));
    }

    // Add Time of Day

    public function add_time_of_day(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Products");
        Session::put("SubMenu", "Time of Day");

        $common['title']          = 'Time of Day';
        $common['heading_title']  = 'Add Time of Day';

        $common['button']            = translate("Save");
        $get_timeofday_food           = getTableColumn('products_foods');
        $get_timeofday_food_language  = getTableColumn('products_food_descriptions');

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        if ($request->isMethod('post')) {

            $req_fields = array();
            $req_fields['title']   = "required";

            $errormsg = [
                "title" => translate("Title"),
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
                return back()->withErrors($validation)->withInput();
            }

            $request->request->add(['user_id' => Session::get('admin_id')]);

            if ($request->id != "") {
                $message   = translate("Update Successfully");
                $status    = "success";
                $ProductFood     = ProductFood::find($request->id);
            } else {
                $message   = translate("Add Successfully");
                $status    = "success";
                $ProductFood      = new ProductFood();
            }

            $ProductFood->status = $request->status;
            $ProductFood->type = "time_of_day";
            $ProductFood->save();

            ProductFoodDescription::where(["product_food_id" => $ProductFood->id, 'language_id' => $language_id])->delete();
            if (isset($request->title)) {
                $ProductFoodDescription                = new ProductFoodDescription();
                $ProductFoodDescription->title         = $request->title;
                $ProductFoodDescription->language_id   = $language_id;
                $ProductFoodDescription->product_food_id  = $ProductFood->id;
                $ProductFoodDescription->save();
            }
            return redirect()->route('admin.productsfood.timeofday')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                         = checkDecrypt($id);
            $common['title']            = "Edit Time of Day";
            $common['heading_title']    = "Edit Time of Day";
            $common['button']           = "Update";

            $get_timeofday_food = ProductFood::where('id', $id)->first();
            $get_timeofday_food_language  = getLanguageData('products_food_descriptions', $language_id, $id, 'product_food_id');

            if (!$get_timeofday_food) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.productsfood.timeofday.add_timeofday', compact('common', 'get_timeofday_food', 'get_timeofday_food_language'));
    }


    // Delete Time of Day

    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status       = 'error';
        $message      = 'Something went wrong!';
        $get_timeofday_food =  ProductFood::where(['id' => $id])->first();
        if ($get_timeofday_food) {
            $get_timeofday_food->is_delete = 1;
            $get_timeofday_food->save();
        }
        $status  = 'success';
        $message = 'Delete Successfully';
        return back()->withErrors([$status => $message]);
    }
}
