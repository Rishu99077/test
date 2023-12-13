<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Models\UserModel;
use App\Models\CustomersModel;
use App\Models\LanguagesModel;
use App\Models\FaqsModel;
use App\Models\FaqsDescriptionModel;

class FaqsController extends Controller{


    public function faqs(){
    	  $common = array();
        $common['main_menu'] = 'Menu';
        $common['sub_menu']  = 'Faqs';
        $common['heading_title'] = 'All Faqs';

        $user = array();
        $user_id = Session::get('user_id');
        $user = UserModel::where(['id' => $user_id])->first();

        $Faqs = FaqsModel::orderBy('id','Desc')->paginate(5);
        $faqs = array();
        foreach ($Faqs as $key => $value) {
          $row['id'] = $value['id'];
          $row['status'] = $value['status'];
          $get_faq_desc = FaqsDescriptionModel::where(['faq_id'=>$value['id']])->first();
          if ($get_faq_desc) {
            $row['title'] = $get_faq_desc['title'];
          }

          $faqs[] = $row;
        }

        return view('admin.Faqs.index',compact('common','faqs','user','Faqs'));
    }

    public function faq_add(){


    	  $common = array();
        $common['main_menu'] = 'Menu';
        $common['sub_menu']  = 'Faqs';
        $common['heading_title'] = 'Add Faqs';

        $user = array();
        $user_id = Session::get('user_id');
        $user = UserModel::where(['id' => $user_id])->first();

        $get_languages = LanguagesModel::get();
        $get_faq_description = array();
        $faqs = array();
        $faq_id = @$_GET['id'];

        if ($faq_id!='') {
          $get_faq = FaqsModel::where(['id' => $faq_id])->first();
          $faqs['id'] = $get_faq['id'];
          $faqs['status'] = $get_faq['status'];
          $common['heading_title'] = 'Edit Faqs';

          foreach ($get_languages as $value) {
                $language_id =  $value['id'];
                $faqsdescription = FaqsDescriptionModel::where(['faq_id' => $faq_id,'language_id'=>$language_id])->first();

                if($faqsdescription){
                    $get_faq_description[$language_id]['title']  = $faqsdescription->title;
                }else{
                    $get_faq_description[$language_id]['title'] = '';
                }

                if($faqsdescription){
                    $get_faq_description[$language_id]['description']  = $faqsdescription->description;
                }else{
                    $get_faq_description[$language_id]['description'] = '';
                }
            }

        }

        return view('admin.Faqs.faq_add',compact('common','faqs','get_languages','get_faq_description','user'));
    }


    public function save_faqs(Request $request){
        $user_id = Session::get('user_id');
        $user_details = UserModel::where(['id' => $user_id])->first();

        $data = $request->all();
        $Faq_id  = $request->Faq_id;

        if ($Faq_id=='') {
          $Data = array();
          $Data['status'] = $data['status'];
          $insert_id = FaqsModel::create($Data);

          foreach ($request->title as $key => $value) {
              $data_desc = array();  
              $data_desc['faq_id'] = $insert_id['id'];
              $data_desc['language_id'] = $key;
              $data_desc['title'] = $request->title[$key];
              $data_desc['description'] = $request->description[$key];

              FaqsDescriptionModel::create($data_desc);    
          }  
          return redirect('admin/faqs')->withErrors(['success'=> 'Faqs added successfully']);
             
        }else{

          $UpdateData = array();
          $UpdateData['status'] = $data['status'];
          FaqsModel::where(['id' => $Faq_id])->update($UpdateData);
          

          foreach ($request->title as $key => $value) {
              $data_desc = array();  
              $data_desc['faq_id'] = $Faq_id;
              $data_desc['language_id'] = $key;
              $data_desc['title'] = $request->title[$key];
              $data_desc['description'] = $request->description[$key];
   

              FaqsDescriptionModel::where(['faq_id' => $Faq_id,'language_id' =>$key])->update($data_desc);   

          }  
          return redirect('admin/faqs')->withErrors(['success'=> 'Faqs Updated successfully']);
        }    
    }


    public function faq_delete(Request $request){
      if(@$_GET['id'] != ''){
        $Faq_id = @$_GET['id'];
        FaqsModel::where('id', $Faq_id)->delete();
        FaqsDescriptionModel::where('faq_id', $Faq_id)->delete();   
      }
      return redirect('admin/faqs')->withErrors(['error'=> 'Faqs deleted']);
    }

}



