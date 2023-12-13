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
use App\Models\WorkModel;
use App\Models\WorkDescriptionModel;

class WorkController extends Controller{


    public function work_seeker(){
    	  $common = array();
        $common['main_menu']     = 'Menu';
        $common['sub_menu']      = 'Work_seeker';
        $common['heading_title'] = __('admin.text_work_it_work');

        $title = @$_GET['title'];
        $user = array();
        $user_id = Session::get('user_id');
        $user = UserModel::where(['id' => $user_id])->first();


        $WorkDetail = WorkModel::where(['role'=>$title])->orderBy('id','Desc')->paginate(5);
        $works = array();
        foreach ($WorkDetail as $key => $value) {
          $row['id'] = $value['id'];
          $row['image'] = $value['image'];
          $row['logo'] = $value['logo'];
          $row['role'] = $value['role'];
          $row['status'] = $value['status'];
          $get_work_desc = WorkDescriptionModel::where(['work_id'=>$value['id']])->first();
          $row['title'] = $get_work_desc['title'];

          $works[] = $row;
        }

        return view('admin.Work.index',compact('common','works','user','WorkDetail'));
    }

    public function work_seeker_add(){

    	  $common = array();
        $common['main_menu']      = 'Work_seeker';
        $common['sub_menu']       = 'Work_seeker';
        $common['heading_title']  = __('admin.text_add').' '.__('admin.text_work_it_work');

        $user    = array();
        $user_id = Session::get('user_id');
        $user    = UserModel::where(['id' => $user_id])->first();

        $get_languages = LanguagesModel::get();
        $get_work_description = array();
        $works = array();
        $works['id']    = '';
        $works['image'] = '';
        $works['logo']  = '';
        $works['role']  = '';
        $works['status'] = '';

        $work_id = @$_GET['id'];

        if ($work_id!='') {
          $common['heading_title'] = __('admin.text_edit').' '.__('admin.text_work_it_work');

          $get_work       = WorkModel::where(['id' => $work_id])->first();
          $works['id']    = $get_work['id'];
          $works['image'] = $get_work['image'];
          $works['logo']  = $get_work['logo'];
          $works['role']  = $get_work['role'];
          $works['status'] = $get_work['status'];
          foreach ($get_languages as $value) {
              $language_id =  $value['id'];
              $work_Description = WorkDescriptionModel::where(['work_id' => $work_id,'language_id'=>$language_id])->first();

              if($work_Description){
                  $get_work_description[$language_id]['title']  = $work_Description->title;
              }else{
                  $get_work_description[$language_id]['title']  = '';
              }

              if($work_Description){
                  $get_work_description[$language_id]['description']  = $work_Description->description;
              }else{
                  $get_work_description[$language_id]['description']  = '';
              }
          }

        }

        return view('admin.Work.work_add',compact('common','works','user','get_languages','get_work_description'));
    }

    public function save_work_seeker(Request $request){
        $user_id = Session::get('user_id');
        $user_details = UserModel::where(['id' => $user_id])->first();

        $data = $request->all();
        $Work_id  = $request->Work_id;

        if ($Work_id=='') {
          $Data = array();
          $Data['status'] = $data['status'];
          $Data['role'] = $data['role'];

	      	if ($request->file('image')) {
	            $img = $request->file('image');
	            $Data["image"] = $img->getClientOriginalName();
	            $destinationPath = public_path('/Images/Howitwork');
	            $img->move($destinationPath, $Data["image"]);
	        }


          if ($request->file('logo')) {
              $img = $request->file('logo');
              $Data["logo"] = $img->getClientOriginalName();
              $destinationPath = public_path('/Images/Howitwork');
              $img->move($destinationPath, $Data["logo"]);
          }

          $insert_id = WorkModel::create($Data);

          foreach ($request->title as $key => $value) {
              $data_desc = array();  
              $data_desc['work_id'] = $insert_id['id'];
              $data_desc['language_id'] = $key;
              $data_desc['title'] = $request->title[$key];
              $data_desc['description'] = $request->description[$key];

              WorkDescriptionModel::create($data_desc);    
          }  
          if ($data['role']=='seeker') {
             return redirect('admin/work_seeker?title=seeker')->withErrors(['success'=> __('admin.text_seeker').' '.__('admin.text_update_success')]);
          }elseif ($data['role']=='provider') {
             return redirect('admin/work_seeker?title=provider')->withErrors(['success'=> __('admin.text_provider').' '.__('admin.text_update_success')]);
          }
             
        }else{
          $UpdateData = array();
          if ($request->file('image')) {
              $img = $request->file('image');
              $UpdateData["image"] = $img->getClientOriginalName();
              $destinationPath = public_path('/Images/Howitwork');
              $img->move($destinationPath, $UpdateData["image"]);
          }

          if ($request->file('logo')) {
              $img = $request->file('logo');
              $UpdateData["logo"] = $img->getClientOriginalName();
              $destinationPath = public_path('/Images/Howitwork');
              $img->move($destinationPath, $UpdateData["logo"]);
          }
          $UpdateData['status'] = $data['status'];
          WorkModel::where(['id' => $Work_id])->update($UpdateData);
          
          foreach ($request->title as $key => $value) {
              $data_desc = array();  
              $data_desc['work_id'] = $Work_id;
              $data_desc['language_id'] = $key;
              $data_desc['title'] = $request->title[$key];
              $data_desc['description'] = $request->description[$key];
              WorkDescriptionModel::where(['work_id' => $Work_id,'language_id' =>$key])->update($data_desc);   
          }  
          if ($data['role']=='seeker') {
             return redirect('admin/work_seeker?title=seeker')->withErrors(['success'=> __('admin.text_seeker').' '.__('admin.text_update_success')]);
          }elseif ($data['role']=='provider') {
             return redirect('admin/work_seeker?title=provider')->withErrors(['success'=> __('admin.text_provider').' '.__('admin.text_update_success')]);
          }
        }    
    }

    public function work_seeker_delete(Request $request){
      if(@$_GET['id'] != ''){
        $Work_id = @$_GET['id'];
        $get_work = WorkModel::where('id', $Work_id)->first();

        WorkModel::where('id', $Work_id)->delete();
        WorkDescriptionModel::where('work_id', $Work_id)->delete();   
      }
      if ($get_work['role']=='seeker') {
         return redirect('admin/work_seeker?title=seeker')->withErrors(['error'=> __('admin.text_seeker_deleted')]);
      }elseif ($get_work['role']=='provider') {
         return redirect('admin/work_seeker?title=provider')->withErrors(['error'=> __('admin.text_provider_deleted')]);
      }
    }

}



