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

class MealTypeController extends Controller
{
    public function index(Request $request)
    {
        $common          = array();
        $common['title'] = translate("Type of Meal");
        Session::put("TopMenu", translate("Products"));
        Session::put("SubMenu", translate("Type of Meal"));

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $get_products_food = ProductFood::orderBy('id', 'desc')->where('type', 'type_of_meal')->whereNull('is_delete')
            ->paginate(config('adminconfig.records_per_page'));

        $Products_food = [];
        if (!empty($get_products_food)) {
            foreach ($get_products_food as $key => $value) {
                $row  = getLanguageData('products_food_descriptions', $language_id, $value['id'], 'product_food_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $row['type']   = $value['type'];
                $Products_food[] = $row;
            }
        }

        return view('admin.productsfood.mealtype.index', compact('common', 'get_products_food', 'Products_food'));
    }

    // Add Meal Type

    public function add_mealtype(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", translate("Products"));
        Session::put("SubMenu", translate("Type of Meal"));

        $common['title']          = translate('Type of Meal');
        $common['heading_title']  = translate('Add Type of Meal');

        $common['button']            = translate("Save");
        $get_products_food           = getTableColumn('products_foods');
        $get_products_food_language  = getTableColumn('products_food_descriptions');

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
            $ProductFood->type = "type_of_meal";
            $ProductFood->save();

            ProductFoodDescription::where(["product_food_id" => $ProductFood->id, 'language_id' => $language_id])->delete();
            if (isset($request->title)) {
                $ProductFoodDescription                = new ProductFoodDescription();
                $ProductFoodDescription->title         = $request->title;
                $ProductFoodDescription->language_id   = $language_id;
                $ProductFoodDescription->product_food_id  = $ProductFood->id;
                $ProductFoodDescription->save();
            }
            return redirect()->route('admin.productsfood.mealtype')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => translate("No Record Found")]);
            }
            $id                         = checkDecrypt($id);
            $common['title']            = translate("Edit Type of Meal");
            $common['heading_title']    = translate("Edit Type of Meal");
            $common['button']           = translate("Update");

            $get_products_food = ProductFood::where('id', $id)->first();
            $get_products_food_language  = getLanguageData('products_food_descriptions', $language_id, $id, 'product_food_id');

            if (!$get_products_food) {
                return back()->withErrors(["error" => translate("Something went wrong")]);
            }
        }
        return view('admin.productsfood.mealtype.add_mealtype', compact('common', 'get_products_food', 'get_products_food_language'));
    }


    // Delete Meal Type

    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => translate("No Record Found")]);
        }
        $id = checkDecrypt($id);
        $status       = 'error';
        $message      = translate('Something went wrong!');
        $get_products_food =  ProductFood::where(['id' => $id])->first();
        if ($get_products_food) {
            $get_products_food->is_delete = 1;
            $get_products_food->save();
        }
        $status  = 'success';
        $message = translate('Delete Successfully');
        return back()->withErrors([$status => $message]);
    }
}
