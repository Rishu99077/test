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

class TagController extends Controller
{
    public function index(Request $request)
    {
        $common          = array();
        $common['title'] = "Tags";
        Session::put("TopMenu", "Products");
        Session::put("SubMenu", "Tags");

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $get_products_tags = ProductFood::orderBy('id', 'desc')->where('type', 'food_tags')->orWhere('type', 'drink_tags')->where(['status' => 'Active'])->whereNull('is_delete')
            ->paginate(config('adminconfig.records_per_page'));

        $Products_tags = [];
        if (!empty($get_products_tags)) {
            foreach ($get_products_tags as $key => $value) {
                $row  = getLanguageData('products_food_descriptions', $language_id, $value['id'], 'product_food_id');
                $row['id']       = $value['id'];
                $row['status']   = $value['status'];
                $row['type']     = $value['type'];
                $Products_tags[] = $row;
            }
        }

        return view('admin.productsfood.tags.index', compact('common', 'get_products_tags', 'Products_tags'));
    }

    // Add Tags

    public function add_tags(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Products");
        Session::put("SubMenu", "Tags");

        $common['title']          = 'Tags';
        $common['heading_title']  = 'Add Tags';

        $common['button']            = translate("Save");
        $get_products_tags           = getTableColumn('products_foods');
        $get_products_tags_language  = getTableColumn('products_food_descriptions');

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
                $message      = translate("Update Successfully");
                $status       = "success";
                $ProductFood  = ProductFood::find($request->id);
            } else {
                $message      = translate("Add Successfully");
                $status       = "success";
                $ProductFood  = new ProductFood();
            }

            $ProductFood->status = $request->status;
            $ProductFood->type   = $request->type;
            $ProductFood->save();

            ProductFoodDescription::where(["product_food_id" => $ProductFood->id, 'language_id' => $language_id])->delete();
            if (isset($request->title)) {
                $ProductFoodDescription                   = new ProductFoodDescription();
                $ProductFoodDescription->title            = $request->title;
                $ProductFoodDescription->language_id      = $language_id;
                $ProductFoodDescription->product_food_id  = $ProductFood->id;
                $ProductFoodDescription->save();
            }
            return redirect()->route('admin.productsfood.tags')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                         = checkDecrypt($id);
            $common['title']            = "Edit Tags";
            $common['heading_title']    = "Edit Tags";
            $common['button']           = "Update";

            $get_products_tags = ProductFood::where('id', $id)->first();
            $get_products_tags_language  = getLanguageData('products_food_descriptions', $language_id, $id, 'product_food_id');
    
            if (!$get_products_tags) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.productsfood.tags.addtags', compact('common', 'get_products_tags', 'get_products_tags_language'));
    }


    // Delete Tags

    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status       = 'error';
        $message      = 'Something went wrong!';
        $get_products_tags =  ProductFood::where(['id' => $id])->first();
        if ($get_products_tags) {
            $get_products_tags->is_delete = 1;
            $get_products_tags->save();
        }
        $status  = 'success';
        $message = 'Delete Successfully';
        return back()->withErrors([$status => $message]);
    }
}
