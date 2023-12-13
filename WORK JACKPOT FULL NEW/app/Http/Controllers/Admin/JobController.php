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
use App\Models\JobsModel;
use App\Models\FaqsDescriptionModel;
use App\Models\ContractsModel;
use App\Models\JobsFavouriteModel;
use App\Models\OtherDocuments;

class JobController extends Controller{


    public function all_jobs(){

        $common = array();
        $common['main_menu'] = 'Posted jobs';
        $common['sub_menu'] = 'Posted jobs';
        $common['heading_title'] = 'All posted jobs';

        $user    = array();
        $user_id = Session::get('user_id');
        $user    = UserModel::where(['id' => $user_id])->first();


        $get_jobs = JobsModel::orderBy('id','Desc')->paginate(9);

        $jobs = array();
        foreach ($get_jobs as $key => $value) {
          $row['job_id'] = $value['id'];
          $row['job_type_id'] = $value['job_type_id'];
          $row['title'] = $value['title'];
          $row['salary'] = $value['salary'];
          $row['profession_name'] = $value['profession_name'];
          $row['experience'] = $value['experience'];
          $row['working_hours'] = $value['working_hours'];
          $row['work_location'] = $value['work_location'];
          $row['start_date'] = $value['start_date'];
          $row['requirements'] = $value['requirements'];
          $row['description'] = $value['description'];
          $row['driving_license'] = $value['driving_license'];
          $row['own_car'] = $value['own_car'];
          $row['status'] = $value['status'];
         
          $newtimeago = $this->newtimeago($value['created_at']); 
          $row['datetime'] = $newtimeago;

          $row['contract_count'] = '0';
          $ContractsModel = ContractsModel::where(['job_id'=>$value['id']]);
          $ContractsModel->whereIn('status', ['Published']);
          $get_contract = $ContractsModel->get();
          
          if ($get_contract) {
            $row['contract_count'] = count($get_contract);
          }

          $jobs[] = $row;
      
        }

        return view('admin.Job.all_jobs',compact('common','jobs','user','get_jobs'));

    }

    public function admin_job_detail($Jobid=''){

        $common = array();
        $common['main_menu'] = 'Posted jobs';
        $common['sub_menu'] = 'Posted jobs';
        $common['heading_title'] = 'All posted jobs';

        $user    = array();
        $user_id = Session::get('user_id');
        $user    = UserModel::where(['id' => $user_id])->first();

        $jobs = array();
        $get_job_details = JobsModel::where('id',$Jobid)->first();
        if ($get_job_details) {
            $jobs['id']              = $get_job_details['id'];
            $jobs['job_type_id']     = $get_job_details['job_type_id'];
            $jobs['title']           = $get_job_details['title'];
            $jobs['salary']          = $get_job_details['salary'];
            $jobs['profession_name'] = $get_job_details['profession_name'];
            $jobs['experience']      = $get_job_details['experience'];
            $jobs['working_hours']   = $get_job_details['working_hours'];
            $jobs['work_location']   = $get_job_details['work_location'];
            $jobs['start_date']      = $get_job_details['start_date'];
            $jobs['requirements']    = $get_job_details['requirements'];
            $jobs['description']     = $get_job_details['description'];
            $jobs['driving_license'] = $get_job_details['driving_license'];
            $jobs['own_car']         = $get_job_details['own_car'];
            $jobs['status']         = $get_job_details['status'];

            $newtimeago = $this->newtimeago($get_job_details['created_at']); 
            $jobs['datetime'] = $newtimeago;
        } 

        return view('admin.Job.job_detail',compact('common','jobs','user'));

    }

    public function change_jobs_status(Request $request){
          
        $Jobid       = $request->Jobid;
        $Datastatus  = $request->Datastatus;
      
        if ($Jobid!='') {

          $UpdateData = array();
          $UpdateData['status'] = $Datastatus;

          JobsModel::where(['id' => $Jobid])->update($UpdateData);
             
        }
    }

    public function jobs_vacancies(){

        $common = array();
        $common['main_menu'] = 'Job vacancies';
        $common['sub_menu'] = 'Job vacancies';
        $common['heading_title'] = 'All Job vacancies';

        $user = array();
        $user_id = Session::get('user_id');
        $user = UserModel::where(['id' => $user_id])->first();


        $get_jobs = JobsModel::orderBy('id','Desc')->paginate(9);

        $jobs = array();
        foreach ($get_jobs as $key => $value) {
          $row['id'] = $value['id'];
          $row['job_type_id'] = $value['job_type_id'];
          $row['title'] = $value['title'];
          $row['salary'] = $value['salary'];
          $row['profession_name'] = $value['profession_name'];
          $row['experience'] = $value['experience'];
          $row['working_hours'] = $value['working_hours'];
          $row['work_location'] = $value['work_location'];
          $row['start_date'] = $value['start_date'];
          $row['requirements'] = $value['requirements'];
          $row['description'] = $value['description'];
          $row['driving_license'] = $value['driving_license'];
          $row['own_car'] = $value['own_car'];
          $row['status'] = $value['status'];
         
          $newtimeago = $this->newtimeago($value['created_at']); 
          $row['datetime'] = $newtimeago;

          $row['contract_count'] = '0';
          $ContractsModel = ContractsModel::where(['job_id'=>$value['id']]);
          $ContractsModel->whereIn('status', ['Published']);
          $get_contract = $ContractsModel->get();
          
          if ($get_contract) {
            $row['contract_count'] = count($get_contract);
          }

          $jobs[] = $row;
      
        }

        return view('admin.Job.index',compact('common','jobs','user','get_jobs'));

    }


    public function other_documents(){
        $common = array();
        $common['main_menu'] = 'other_documents';
        $common['sub_menu'] = 'other_documents';
        $common['heading_title'] = 'Other Documents';

        $user = array();
        $user_id = Session::get('user_id');
        $user = UserModel::where(['id' => $user_id])->first();
       
        $get_otherdocuments = OtherDocuments::orderBy('id','Desc')->paginate(10);
        $Documents = array();
        foreach ($get_otherdocuments as $key => $value) {
          $row = array();
          $row['document_id'] = $value['id'];
          $row['contract_id'] = $value['contract_id'];

          $row['from_id']     = $value['customer_id_from'];
          $row['to_id']       = $value['customer_id_to'];
          $row['from_name']   = '';
          $row['to_name']     = '';
          $get_from_cutomers  = CustomersModel::where(['id' => $value['customer_id_from']])->first();
          if ($get_from_cutomers) {
              $row['from_name'] = $get_from_cutomers['firstname'].' '.$get_from_cutomers['surname'];
          }
          $get_to_cutomers  = CustomersModel::where(['id' => $value['customer_id_to']])->first();
          if ($get_to_cutomers) {
              $row['to_name']   = $get_to_cutomers['firstname'].' '.$get_to_cutomers['surname'];
          }
          $row['title']       = $value['title'];
          $row['document']    = $value['document'];
          $row['date']        = $value['date'];

          $Documents[] = $row;
        }
      
        return view('admin.Job.other_documents',compact('common','get_otherdocuments','Documents','user'));
    }


    public function newtimeago($newdate){
      $timestamp = strtotime($newdate); 
    
      $newtimeago = '';
      $strTime = array("second", "minute", "hour", "day", "month", "year");
      $ago = 'ago';
      $length = array("60","60","24","30","12","10");        
      $currentTime = time();
      if($currentTime >= $timestamp) {
        $diff     = time()- $timestamp;
        for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
          $diff = $diff / $length[$i];
        }
        $diff = round($diff);
        $newtimeago =  $diff . " " . $strTime[$i] .' '.$ago;
      }
     
      return $newtimeago;
    }

}



