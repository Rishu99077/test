<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerOverview;
use App\Models\BannerOverviewLanguage;
use App\Models\MetaGlobalLanguage;

use App\Models\AdvertismentPage;
use App\Models\AdvertismentPageLanguage;

use App\Models\AdvertiseWithUs;
use App\Models\AdvertiseWithUsLanguage;

use App\Models\AdvertisePagechoose;
use App\Models\AdvertisePagechooseLanguage;
use App\Models\MetaPageSettingLanguage;
use App\Models\MetaPageSetting;

use App\Models\Language;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Str;

class TermConditionPageController extends Controller
{
    ///Add Advertisment Us Page
    public function add_term_condition_page(Request $request, $id = '')
    {
        $common = [];
        Session::put('TopMenu', 'Pages');
        Session::put('SubMenu', 'Terms & Condition');

        $common['title']                = translate('Add Terms & Condition');
        $common['button']               = translate('Save');

        $get_banner_over_view           = [];
        $get_banner_over_view_language  = [];

        $get_advertise_us_page_language = [];
        $languages                      = Language::where(ConditionQuery())->get();

        $GAWU                            = getTableColumn('advertise_with_us');



        if ($request->isMethod('post')) {


            $req_fields = [];
            $req_fields['title.*'] = 'required';

            $errormsg = [
                'title.*' => translate('Title'),
            ];

            $validation = Validator::make(
                $request->all(),
                $req_fields,
                [
                    'required' => 'The :attribute field is required.',
                ],
                $errormsg,
            );

            // echo "<pre>";
            // print_r($request->all());
            // echo "</pre>";die();
            //     die;
            if ($validation->fails()) {
                return back()
                    ->withErrors($validation)
                    ->withInput();
            }





            MetaGlobalLanguage::where(['meta_title' => 'term_condition'])->delete();

            $getMetaPageSetting = MetaPageSetting::get();
            foreach ($getMetaPageSetting as $key => $MetaPageSetting_delete) {
                if (!in_array($MetaPageSetting_delete['id'], $request->facility_id)) {
                    MetaGlobalLanguage::where(['product_id' => $MetaPageSetting_delete['id'], 'meta_parent' => 'pages'])->delete();
                    MetaPageSetting::where('id', $MetaPageSetting_delete['id'])->delete();
                }
            }

            foreach ($request->facility_id as $webInfoKey => $value) {

                if ($value != "") {
                    $MetaPageSetting =  MetaPageSetting::find($value);
                } else {
                    $MetaPageSetting = new MetaPageSetting();
                }

                $MetaPageSetting['status'] = 'Active';
                $MetaPageSetting->save();
                MetaGlobalLanguage::where(['product_id' => $MetaPageSetting->id, 'meta_parent' => 'pages'])->delete();
                // print_die($request->heading);
                foreach ($request->heading as $facKey => $Val_fac) {
                    $MetaGlobalLanguage = new MetaGlobalLanguage();
                    $MetaGlobalLanguage->product_id  = $MetaPageSetting->id;
                    $MetaGlobalLanguage->meta_parent = 'pages';
                    if(isset($request->heading[3][$webInfoKey])){
                        $MetaGlobalLanguage->meta_title  = strtolower(str_replace(' ', '_', $request->heading[3][$webInfoKey]));
                    }
                    $MetaGlobalLanguage->title       = $Val_fac[$webInfoKey];
                    $MetaGlobalLanguage->language_id = $facKey;
                    $MetaGlobalLanguage->content     = $request->description[$facKey][$webInfoKey];
                    $MetaGlobalLanguage->status      = 'Active';
                    $MetaGlobalLanguage->save();
                }
            }


            return redirect()
                ->route('admin.term_condition_page.edit', encrypt(1))
                ->withErrors(['success' => 'data inserted']);
        }

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'No Record Found']);
            }
            $id = checkDecrypt($id);
            $common['title'] = 'Edit Advertise Us';
            $common['button'] = 'Update';



            $MetaPageSetting = MetaPageSetting::get();
            $MetaGlobalLanguageWebSite_info = MetaGlobalLanguage::where(['meta_parent' => 'pages'])->get();
            // dd($MetaGlobalLanguageTerm_Condition);



        }
        return view('admin.terms_condition.term_condition_page', compact('common', 'MetaPageSetting', 'GAWU', 'languages', 'MetaGlobalLanguageWebSite_info'));
    }
}
