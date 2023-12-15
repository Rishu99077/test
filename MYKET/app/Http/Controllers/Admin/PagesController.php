<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Page;
use App\Models\ProductType;
use App\Models\Pagemeta;
use App\Models\MetaData;


use Illuminate\Support\Str;

class PagesController extends Controller
{

    public function index(Request $request)
    {
        $common          = array();
        $common['title'] = translate("Pages");
        Session::put("TopMenu", translate("Page Building"));
        Session::put("SubMenu", translate("Pages"));

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $Page = Page::paginate(config('adminconfig.records_per_page'));

        $Page_desc = array();
        if (!empty($Page)) {
            foreach ($Page as $key => $value) {
                $row  = getLanguageData('page_descriptions', $language_id, $value['id'], 'page_id');
                $row['id']     = $value['id'];
                $Page_desc[] = $row;
            }
        }
        return view('admin.pages.index', compact('common', 'Page_desc', 'Page'));
    }

    // Add Pages
    public function add_pages(Request $request, $id = "")
    {

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => translate("No Record Found")]);
            }
            $id = checkDecrypt($id);
            $Page = Page::where('id', $id)->first();
            if (!$Page) {
                return back()->withErrors(["error" => translate("Something went wrong")]);
            }
        } else {
            return back()->withErrors(["error" => translate("Something went wrong")]);
        }



        $get_session_language       = getLang();
        $language_id = $get_session_language['id'];

        if ($request->isMethod('post')) {
            $message      = translate("Update Successfully");
            $status       = "success";

            if (isset($request->meta_keyword) || isset($request->meta_description)) {
                $MetaData = MetaData::where(['language_id' => $language_id, 'value' => $Page->id, 'type' => 'page'])->first();
                if (!$MetaData) {

                    $MetaData                = new MetaData();
                }

                $MetaData['value']       = $Page->id;
                $MetaData['language_id'] = $language_id;
                $MetaData['keyword']     = $request->meta_keyword;
                $MetaData['description'] = $request->meta_description;
                $MetaData['type']        = 'page';

                $MetaData->save();
            }

            if (isset($request->page_content)) {
                foreach ($request->page_content as $meta_key => $meta_value) {
                    $Pagemeta = Pagemeta::where(['page_id' => $Page->id, 'language_id' => $language_id])->where('meta_key', $meta_key)->first();
                    if ($Pagemeta) {
                    } else {
                        $Pagemeta = new Pagemeta();
                        $Pagemeta->language_id = $language_id;
                        $Pagemeta->page_id = $Page->id;
                        $Pagemeta->meta_key = $meta_key;
                    }

                    if (is_array($meta_value)) {
                        $meta_value = implode(',', $meta_value);
                    }
                    if ($request->hasFile('page_content.' . $meta_key)) {
                        $img        = $request->file('page_content.' . $meta_key);
                        $meta_value = image_upload($img, 'uploads/pages');
                        if ($Pagemeta) {
                            if ($Pagemeta->meta_value) {
                                image_delete('uploads/pages/' . $Pagemeta->meta_value);
                            }
                        }
                        $Pagemeta->type = 'File';
                    }

                    $Pagemeta->meta_value = $meta_value;
                    $Pagemeta->save();
                }
            }
            $Pagemeta_ids = array();
            if (isset($request->page_content_multi)) {
                foreach ($request->page_content_multi as $meta_key => $metavalue) {
                    foreach ($metavalue as $key => $value) {
                        foreach ($value as $key1 => $value1) {
                            $key1_init = $key1;
                            $key1 = str_replace("hidden_", "", $key1);
                            $Pagemeta = Pagemeta::where(['page_id' => $Page->id, 'language_id' => $language_id])->where('meta_key', $meta_key)->where('child_row', $key1)->where('order_index', $key)->first();

                            if ($Pagemeta) {
                            } else {
                                $Pagemeta = new Pagemeta();
                                $Pagemeta->language_id = $language_id;
                                $Pagemeta->page_id = $Page->id;
                                $Pagemeta->meta_key = $meta_key;
                            }
                            $Pagemeta->order_index = $key;

                            if ($request->hasFile('page_content_multi.' . $meta_key . '.' . $key . '.' . $key1_init)) {
                                $img        = $request->file('page_content_multi.' . $meta_key . '.' . $key . '.' . $key1_init);
                                $value1 = image_upload($img, 'uploads/pages');
                                $Pagemeta->type = 'File';
                            }

                            $Pagemeta->child_row = $key1;
                            $Pagemeta->meta_value = $value1;
                            $Pagemeta->save();
                            $Pagemeta_ids[] = $Pagemeta->id;
                        }
                    }
                }
            }
            Pagemeta::where(['page_id' => $Page->id, 'language_id' => $language_id])->whereNotNull('child_row')->whereNotIn('id', $Pagemeta_ids)->delete();

            return back()->withErrors([$status => $message]);
        }

        $page_desc  = getLanguageData('page_descriptions', $language_id, $id, 'page_id');

        Session::put("TopMenu", translate("Page Building"));
        Session::put("SubMenu", translate("Pages"));

        $get_product_type = ProductType::whereNull('is_delete')->orderBy('id', 'desc')->get();

        $ProductType = [];
        if (!empty($get_product_type)) {
            foreach ($get_product_type as $key => $value) {
                $row  = getLanguageData('product_type_description', $language_id, $value['id'], 'product_type_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $ProductType[] = $row;
            }
        }
        $MetaData = MetaData::where(['language_id' => $language_id, 'value' => $Page->id, 'type' => 'page'])->first();
        $common = array();
        $common['title']            = "Edit Page - " . $page_desc['title'];
        $common['heading_title']    = "Edit Page - " . $page_desc['title'];
        $common['button']           = "Update";


        return view('admin.pages.page' . $Page->id, compact('common', 'language_id', 'Page', 'ProductType', 'MetaData'));
    }
}
