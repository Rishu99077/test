<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Countries;
use App\Models\Tax;
use App\Models\Categories;
use App\Models\Product;
use App\Models\TaxDescription;
use App\Models\Cities;
use App\Models\Languages;
use App\Models\Pagemeta;
use Illuminate\Support\Str;

class TaxController extends Controller
{
    public function add_tax(Request $request, $id = "")
    {

        $common = array();
        Session::put("TopMenu", "Financial");
        Session::put("SubMenu", "Tax");

        $common['title']          = 'Tax';
        $common['heading_title']  = 'Tax';
        $common['button']         = translate("Save");
        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];


        $destination_tax = Tax::where(['type' => 'destination'])->get();
        $category_tax    = Tax::where(['type' => 'category'])->get();
        $product_tax    = Tax::where(['type' => 'product'])->get();

        $title = ['product_tax_title', 'category_tax_title', 'destination_tax_title'];
        $title = getPagemeta($title, $language_id, '');





        $Countries = Countries::where(['is_delete' => null])->get();
        $Cities = [];
        $States = [];

        $get_category = Categories::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
            ->get();

        $categories = array();
        if (!empty($get_category)) {
            foreach ($get_category as $key => $value) {
                $row  = getLanguageData('category_descriptions', $language_id, $value['id'], 'category_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $categories[] = $row;
            }
        }

        $get_product = Product::where(['products.is_delete' => null, 'products.status' => 'Active', 'products.is_approved' => 'Approved'])->where('slug', '!=', '')->where('products_description.language_id', $language_id)
            ->select('products.*', 'products_description.title', 'products_description.language_id')
            ->leftJoin('products_description', 'products.id', '=', 'products_description.product_id')
            ->get();


        if ($request->isMethod('post')) {

            $req_fields = array();
            if (isset($request->tax)) {
                $req_fields['country.*'] = "required";
                $req_fields['tax.*']     = "required";
            }

            if (isset($request->category_tax)) {
                $req_fields['category.*']     = "required";
                $req_fields['category_tax.*'] = "required";
            }

            if (isset($request->product_tax)) {
                $req_fields['product.*']     = "required";
                $req_fields['product_tax.*'] = "required";
            }


            $errormsg = [
                "country.*"      => translate("Country"),
                "category.*"     => translate("Category"),
                "product.*"      => translate("Category"),
                "tax.*"          => translate("Tax"),
                "product_tax.*"  => translate("Tax"),
                "category_tax.*" => translate("Tax"),
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
                return response()->json(['error' => array_reverse($validation->getMessageBag()->toArray())]);
            }

            $destination_tax = Tax::where('type', 'destination')->get();

            if (isset($request->destination_tax_id)) {
                foreach ($destination_tax as $key => $destination_tax_delete) {
                    if (!in_array($destination_tax_delete['id'], $request->destination_tax_id)) {
                        Tax::where('id', $destination_tax_delete['id'])->delete();
                        TaxDescription::where('tax_id', $destination_tax_delete['id'])->delete();
                    }
                }
            } else {
                Tax::where('tax_type', 'destination')->delete();
                TaxDescription::where('tax_type', 'destination')->delete();
            }

            $category_tax = Tax::where('type', 'category')->get();
            if (isset($request->category_tax_id)) {
                foreach ($category_tax as $key => $category_tax_delete) {
                    if (!in_array($category_tax_delete['id'], $request->category_tax_id)) {
                        Tax::where('id', $category_tax_delete['id'])->delete();
                        TaxDescription::where('tax_id', $category_tax_delete['id'])->delete();
                    }
                }
            } else {
                Tax::where('tax_type', 'category')->delete();
                TaxDescription::where('tax_type', 'category')->delete();
            }

            $product_tax = Tax::where('type', 'product')->get();
            if (isset($request->product_tax_id)) {
                foreach ($product_tax as $key => $product_tax_delete) {
                    if (!in_array($product_tax_delete['id'], $request->product_tax_id)) {
                        Tax::where('id', $product_tax_delete['id'])->delete();
                        TaxDescription::where('tax_id', $product_tax_delete['id'])->delete();
                    }
                }
            } else {
                Tax::where('tax_type', 'product')->delete();
                TaxDescription::where('tax_type', 'product')->delete();
            }






            if (isset($request->tax)) {
                foreach ($request->tax as  $key => $value) {

                    if ($request->destination_tax_id[$key] != "") {
                        $Tax             = Tax::find($request->destination_tax_id[$key]);
                    } else {
                        $Tax             = new Tax();
                    }


                    $Tax->country  = $request->country[$key];
                    $Tax->state    = isset($request->state[$key]) ? $request->state[$key] : "";
                    $Tax->city     = isset($request->city[$key]) ? $request->city[$key] : "";
                    $Tax->amount   = $value;
                    $Tax->tax_type = $request->tax_type[$key];
                    $Tax->type     = "destination";
                    $Tax->save();


                    $TaxDescription = TaxDescription::where(['tax_id' => $Tax->id, 'language_id' => $language_id])->first();
                    // description
                    if (!$TaxDescription) {
                        $TaxDescription = new TaxDescription();
                    }
                    $TaxDescription->title       = $request->destination_title[$key] != "" ? $request->destination_title[$key] : "Destination Tax";
                    $TaxDescription->tax_id      = $Tax->id;
                    $TaxDescription->language_id = $language_id;
                    $TaxDescription->type        = 'destination';
                    $TaxDescription->save();
                }
            }


            if (isset($request->category_tax)) {
                foreach ($request->category_tax as  $key => $value) {

                    if ($request->category_tax_id[$key] != "") {
                        $Tax             = Tax::find($request->category_tax_id[$key]);
                    } else {
                        $Tax             = new Tax();
                    }


                    $Tax->category = $request->category[$key];
                    $Tax->amount   = $value;
                    $Tax->tax_type = $request->category_tax_type[$key];
                    $Tax->type     = "category";
                    $Tax->save();


                    $TaxDescription = TaxDescription::where(['tax_id' => $Tax->id, 'language_id' => $language_id])->first();
                    // description
                    if (!$TaxDescription) {
                        $TaxDescription = new TaxDescription();
                    }
                    $TaxDescription->title       = $request->category_title[$key] != "" ? $request->category_title[$key] : "Category Tax";
                    $TaxDescription->tax_id      = $Tax->id;
                    $TaxDescription->language_id = $language_id;
                    $TaxDescription->type        = 'category';
                    $TaxDescription->save();
                }
            }

            if (isset($request->product_tax)) {
                foreach ($request->product_tax as  $key => $value) {

                    if ($request->product_tax_id[$key] != "") {
                        $Tax             = Tax::find($request->product_tax_id[$key]);
                    } else {
                        $Tax             = new Tax();
                    }
                    $Tax->products = $request->product[$key];
                    $Tax->amount   = $value;
                    $Tax->tax_type = $request->product_tax_type[$key];
                    $Tax->type     = "product";
                    $Tax->save();

                    $TaxDescription = TaxDescription::where(['tax_id' => $Tax->id, 'language_id' => $language_id])->first();
                    // description
                    if (!$TaxDescription) {
                        $TaxDescription = new TaxDescription();
                    }
                    $TaxDescription->title       = $request->product_title[$key] != "" ? $request->product_title[$key] : "Product Tax";
                    $TaxDescription->tax_id      = $Tax->id;
                    $TaxDescription->language_id = $language_id;
                    $TaxDescription->type        = 'product';
                    $TaxDescription->save();
                }
            }

            if (isset($request->page_content)) {
                foreach ($request->page_content as $meta_key => $meta_value) {
                    $Pagemeta= Pagemeta::where(['language_id'=>$language_id])->where('meta_key',$meta_key)->first();
                    if ($Pagemeta) {
                    }else{
                        $Pagemeta = new Pagemeta();
                        $Pagemeta->language_id = $language_id;
                        $Pagemeta->page_id = $Page->id;
                        $Pagemeta->meta_key = $meta_key;
                    }
                    
                    $Pagemeta->meta_value = $meta_value;
                    $Pagemeta->save();
                }
            }

        }
        return view('admin.tax.add', compact('common', 'Countries', 'States', 'Cities', 'destination_tax', 'categories', 'category_tax', 'get_product', 'product_tax', 'title', 'language_id'));
    }
}
