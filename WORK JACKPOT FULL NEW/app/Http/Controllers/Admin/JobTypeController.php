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
use App\Models\JobTypesModel;
use App\Models\JobTypesDescriptionModel;

class JobTypeController extends Controller{


    public function job_types(){
    	  $common = array();
        $common['main_menu'] = 'Job';
        $common['sub_menu'] = 'Job';
        $common['heading_title'] = 'Job types';

        $user = array();
        $user_id = Session::get('user_id');
        $user = UserModel::where(['id' => $user_id])->first();

        $Job_Types = JobTypesModel::orderBy('id','Desc')->paginate(5);
        $job_types = array();
        foreach ($Job_Types as $key => $value) {
          $row['id'] = $value['id'];
          $row['status'] = $value['status'];
          $get_jobtype_desc = JobTypesDescriptionModel::where(['job_type_id'=>$value['id']])->first();
          $row['title'] = $get_jobtype_desc['title'];

          $job_types[] = $row;
        }

        return view('admin.Job.job_type',compact('common','job_types','Job_Types','user'));
    }

    public function job_type_add(){
    	  $common = array();
        $common['main_menu'] = 'Job';
        $common['sub_menu'] = 'Job';
        $common['heading_title'] = 'Job types';

        $user = array();
        $user_id = Session::get('user_id');
        $user = UserModel::where(['id' => $user_id])->first();

        $get_languages = LanguagesModel::get();
        $get_job_type_description = array();
        $job_types = array();
        $jobtype_id = @$_GET['id'];

        if ($jobtype_id!='') {
          $get_job_type = JobTypesModel::where(['id' => $jobtype_id])->first();
          $job_types['id'] = $get_job_type['id'];
          $job_types['status'] = $get_job_type['status'];


          foreach ($get_languages as $value) {
                $language_id =  $value['id'];
                $job_typesdescription = JobTypesDescriptionModel::where(['job_type_id' => $jobtype_id,'language_id'=>$language_id])->first();

                if($job_typesdescription){
                    $get_job_type_description[$language_id]['title']  = $job_typesdescription->title;
                }else{
                    $get_job_type_description[$language_id]['title'] = '';
                }

                if($job_typesdescription){
                    $get_job_type_description[$language_id]['description']  = $job_typesdescription->description;
                }else{
                    $get_job_type_description[$language_id]['description'] = '';
                }
            }

        }

        return view('admin.Job.job_type_add',compact('common','job_types','get_languages','get_job_type_description','user'));
    }


    public function save_job_type(Request $request){
        $user_id = Session::get('user_id');
        $user_details = UserModel::where(['id' => $user_id])->first();

        $data = $request->all();
        $Job_type_id  = $request->Job_type_id;

        if ($Job_type_id=='') {
          $Data = array();
          $Data['status'] = $data['status'];
          $insert_id = JobTypesModel::create($Data);

          foreach ($request->title as $key => $value) {
              $data_desc = array();  
              $data_desc['job_type_id'] = $insert_id['id'];
              $data_desc['language_id'] = $key;
              $data_desc['title'] = $request->title[$key];
              $data_desc['description'] = $request->description[$key];

              JobTypesDescriptionModel::create($data_desc);    
          }  
          return redirect('admin/job_types')->withErrors(['success'=> 'Job types added successfully']);
             
        }else{

          $UpdateData = array();
          $UpdateData['status'] = $data['status'];
          JobTypesModel::where(['id' => $Job_type_id])->update($UpdateData);
          

          foreach ($request->title as $key => $value) {
              $data_desc = array();  
              $data_desc['job_type_id'] = $Job_type_id;
              $data_desc['language_id'] = $key;
              $data_desc['title'] = $request->title[$key];
              $data_desc['description'] = $request->description[$key];
   

              JobTypesDescriptionModel::where(['job_type_id' => $Job_type_id,'language_id' =>$key])->update($data_desc);   

          }  
          return redirect('admin/job_types')->withErrors(['success'=> 'job types Updated successfully']);
        }    
    }


    public function job_type_delete(Request $request){
      if(@$_GET['id'] != ''){
        $Job_type_id = @$_GET['id'];
        JobTypesModel::where('id', $Job_type_id)->delete();
        JobTypesDescriptionModel::where('job_type_id', $Job_type_id)->delete();   
      }
      return redirect('admin/job_types')->withErrors(['error'=> 'job_types deleted']);
    }

}



