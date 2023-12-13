<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partners;
use App\Models\PartnerImage;
use App\Models\PartnerLanguage;
use App\Models\Language;
use App\Models\MetaGlobalLanguage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Str;

class PartnersController extends Controller
{

	public function index(){
        $common          = array();
        $common['title'] = "Partners";
        Session::put("TopMenu", "Contents");
        Session::put("SubMenu", "Partners");

        $get_partner = Partners::select('partners.*', 'partners_language.title')->orderBy('partners.id', 'desc')->where(['partners.is_delete' => 0])
            ->join("partners_language", 'partners.id', '=', 'partners_language.partner_id')->groupBy('partners.id')
            ->paginate(config('adminconfig.records_per_page'));
            
        return view('admin.partners.index', compact('common', 'get_partner'));
    }

    public function addPartners(Request $request, $id = ""){
        $common = array();
        Session::put("TopMenu", "Contents");
        Session::put("SubMenu", "Partners");

        $common['title']      = translate("Add Partners");
        $common['button']     = translate("Save");
        $get_partner          = [];
        $get_partner_language = "";
        $languages            = Language::where(ConditionQuery())->get();
        $get_partner_images   = [];
        $get_heading_title    = [];

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];
        $get_languages = Language::where(['status'=>'Active','is_delete' => 0])->get();


        if ($request->isMethod('post')) {
            $req_fields             = array();
            $req_fields['name.*']   = "required";

            $errormsg = [
                "name.*" => translate("Title"),
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
            // print_die($request->all());
            $status   = "success";
            $message  = translate("Update Successfully");
            if(isset($request->id)){
                if(is_array($request->id)){
                    $PartnersDelete              = Partners::whereNotIn('id',$request->id)->delete();
                    $PartnerLanguageDelete       = PartnerLanguage::orderby('id','desc')->where('language_id',$lang_id)->delete();
                    $MetaGlobalLanguagedelete    = MetaGlobalLanguage::where('meta_parent', 'partners')->where('meta_title','partners_heading_title')->where('language_id',$lang_id)->delete();
                    foreach ($request->id as $key => $value) {
                        if($value !=''){
                            $Partners = Partners::find($value);
                        }else{
                            $Partners = new Partners();
                        }
                        if ($request->hasFile('image')) {
                            if (isset($request->image[$key])) {
                                $files     = $request->file('image')[$key];
                                $random_no = uniqid();
                                $image     = $files;
                                $imgFile   = Image::make($image->path());
                                $height    = $imgFile->height();
                                $width     = $imgFile->width();
                                if ($width > 600) {
                                    $imgFile->resize(792, 450, function ($constraint) {
                                        $constraint->aspectRatio();
                                    });
                                }
                                if ($height > 600) {
                                    $imgFile->resize(792, 450, function ($constraint) {
                                        $constraint->aspectRatio();
                                    });
                                }
                                $ext             = $files->getClientOriginalExtension();
                                $new_name        = time() . $random_no  . '.' . $ext;
                                $destinationPath = public_path('uploads/partner_images');
                                $imgFile->save($destinationPath.'/'.$new_name);
                                $Partners->image = $new_name;
                            }
                        }
                        $Partners->link   = $request->link[$key];
                        $Partners->status = $request->status[$key];
                        $Partners->save();
                        $partner_id       = $Partners->id;

                        if (!empty($request->name)) {
                            foreach ($request->name as $lang_key => $lang_value) {
                                $PartnerLanguage                = new PartnerLanguage();
                                $PartnerLanguage->title         = $lang_value[$key];
                                $PartnerLanguage->language_id   = $lang_key;
                                $PartnerLanguage->partner_id    = $partner_id;
                                $PartnerLanguage->save();
                            }
                        }
                    }
                }
            }


           /* //Partners Heading
            if(isset($request->partners_heading)){
                if(!empty($request->partners_heading)){
                    foreach ($request->partners_heading as $partner_key => $partner_value) {
                        $MetaGlobalLanguage = new MetaGlobalLanguage();
                        $MetaGlobalLanguage->meta_parent = 'partners';
                        $MetaGlobalLanguage->meta_title  = 'partners_heading_title';
                        $MetaGlobalLanguage->language_id = $partner_key;
                        $MetaGlobalLanguage->title       = $partner_value;
                        $MetaGlobalLanguage->content     = $request->partners_text[$partner_key];
                        $MetaGlobalLanguage->status = 'Active';
                        $MetaGlobalLanguage->save();
                    }
                }
            }*/

            if(isset($request->partners_heading)){
                if(!empty($request->partners_heading)){

                    foreach ($get_languages as $key => $value) {
                        if (!getDataFromDB('meta_global_language',['language_id'=>$value['id'],'meta_parent'=>'partners','meta_title' => 'partners_heading_title'],'row')) {     

                            $MetaGlobalLanguage = new MetaGlobalLanguage();
                            $MetaGlobalLanguage->meta_parent = 'partners';
                            $MetaGlobalLanguage->meta_title  = 'partners_heading_title';
                            $MetaGlobalLanguage->language_id = $value['id'];
                            $MetaGlobalLanguage->title       = isset($request->partners_heading[$value['id']]) ?  $request->partners_heading[$value['id']] : $request->partners_heading[$lang_id];
                            $MetaGlobalLanguage->content     = isset($request->partners_text[$value['id']]) ?  $request->partners_text[$value['id']] : $request->partners_text[$lang_id]; 
                            $MetaGlobalLanguage->status = 'Active';
                            $MetaGlobalLanguage->save();
                        }
                    }
                }
            }

            //Partners Heading End
            return redirect()->route('admin.partners.add')->withErrors([$status => $message]);
        }

        $get_partner            = Partners::orderBy('id','desc')->get();
        $get_heading_title      = MetaGlobalLanguage::where('meta_parent', 'partners')->where('meta_title','partners_heading_title')->get();
        return view('admin.partners.add_partners', compact('common', 'get_partner','get_heading_title','languages','lang_id'));
    }

    
    
    public function delete($id){
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_partner =  Partners::find($id);
        if ($get_partner) {
            $get_partner->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }
}
