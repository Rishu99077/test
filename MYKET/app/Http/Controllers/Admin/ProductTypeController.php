<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductType;
use App\Models\ProductTypeDescription;
use Illuminate\Support\Facades\View;


class ProductTypeController extends Controller
{
    // List Product Type
    public function index()
    {
        $common          = array();
        $common['title'] = "Product Type";
        Session::put("TopMenu", "Products");
        Session::put("SubMenu", "Product Type");

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];


        $get_product_type = ProductType::orderBy('id', 'desc')->whereNull('is_delete')
            ->paginate(config('adminconfig.records_per_page'));

        $ProductType = [];
        if (!empty($get_product_type)) {
            foreach ($get_product_type as $key => $value) {
                $row  = getLanguageData('product_type_description', $language_id, $value['id'], 'product_type_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $ProductType[] = $row;
            }
        }

        return view('admin.product_type.index', compact('common', 'get_product_type', 'ProductType'));
    }

    // Add Edit Product Type
    public function add_product_type(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Products");
        Session::put("SubMenu", "Product Type");

        $common['title']          = 'Product Type';
        $common['heading_title']  = 'Add Product Type';

        $common['button']          = translate("Save");
        $get_product_type          = getTableColumn('product_type');
        $get_product_type_language = getTableColumn('product_type_description');

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id              = $get_session_language['id'];

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
                $message     = translate("Update Successfully");
                $status      = "success";
                $ProductType = ProductType::find($request->id);
            } else {
                $message     = translate("Add Successfully");
                $status      = "success";
                $ProductType = new ProductType();
            }

            $ProductType->status = $request->status;
            $ProductType->save();

            ProductTypeDescription::where(["product_type_id" => $ProductType->id, 'language_id' => $language_id])->delete();
            if (isset($request->title)) {
                $ProductTypeDescription                = new ProductTypeDescription();
                $ProductTypeDescription->title         = $request->title;
                $ProductTypeDescription->language_id   = $language_id;
                $ProductTypeDescription->product_type_id      = $ProductType->id;
                $ProductTypeDescription->save();
            }
            return redirect()->route('admin.product_type')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                         = checkDecrypt($id);
            $common['title']            = "Edit Product Type";
            $common['heading_title']    = "Edit Product Type";
            $common['button']           = "Update";

            $get_product_type = ProductType::where('id', $id)->first();
            $get_product_type_language  = getLanguageData('product_type_description', $language_id, $id, 'product_type_id');

            if (!$get_product_type) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.product_type.add_product_type', compact('common', 'get_product_type', 'get_product_type_language'));
    }

    // Delete Product Type
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status       = 'error';
        $message      = 'Something went wrong!';
        $get_product_type =  ProductType::where(['id' => $id])->first();
        if ($get_product_type) {
            $get_product_type->is_delete = 1;
            $get_product_type->save();
        }
        $status  = 'success';
        $message = 'Delete Successfully';
        return back()->withErrors([$status => $message]);
    }
}
