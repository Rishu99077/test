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
use App\Models\ContractsModel;
use App\Models\JobsModel;

class ContractsController extends Controller{


    public function index(){
    	  $common = array();
        $common['main_menu'] = 'Contracts';
        $common['sub_menu'] = 'Contracts';
        $common['heading_title'] = 'All Contracts';

        $user = array();
        $user_id = Session::get('user_id');
        $user = UserModel::where(['id' => $user_id])->first();

        $Contracts = ContractsModel::orderBy('id','Desc')->paginate(12);
        $contracts = array();
        foreach ($Contracts as $key => $value) {
          $row['id'] = $value['id'];
          $row['job_id'] = $value['job_id'];
          $row['customer_id'] = $value['customer_id'];
          $row['status'] = $value['status'];


          $get_customer_detail = CustomersModel::where(['id'=>$value['customer_id']])->first();
          if ($get_customer_detail) {
            $row['customer_name'] = $get_customer_detail['firstname'];
          }

          $get_single_job = JobsModel::where(['id'=>$value['job_id']])->first();
          if ($get_single_job) {
            $row['job_type_id'] = $get_single_job['job_type_id'];
            $row['title'] = $get_single_job['title'];
            $row['salary'] = $get_single_job['salary'];
            $row['profession_name'] = $get_single_job['profession_name'];
            $row['experience'] = $get_single_job['experience'];
            $row['working_hours'] = $get_single_job['working_hours'];
            $row['work_location'] = $get_single_job['work_location'];
            $row['start_date'] = $get_single_job['start_date'];
            $row['requirements'] = $get_single_job['requirements'];
            $row['description'] = $get_single_job['description'];
            $row['driving_license'] = $get_single_job['driving_license'];
            $row['own_car'] = $get_single_job['own_car'];

            $newtimeago = $this->newtimeago($get_single_job['created_at']); 
            $row['start_date'] = $newtimeago;
          }

          $contracts[] = $row;
        }

       

        return view('admin.Contracts.index',compact('common','contracts','user','Contracts'));
    }

    public function view(){
    	  $common = array();
        $common['main_menu'] = 'Contracts';
        $common['sub_menu'] = 'Contracts';

        $common['heading_title'] = 'Add Contracts';

        $user = array();
        $user_id = Session::get('user_id');
        $user = UserModel::where(['id' => $user_id])->first();

        $Contract_ID = @$_GET['id'];

        $contracts = array();
        $get_contract = ContractsModel::where(['id'=>$Contract_ID])->first();
        if ($get_contract) {
          $contracts['id'] = $get_contract['id'];
          $contracts['job_id'] = $get_contract['job_id'];
          $contracts['customer_id'] = $get_contract['customer_id'];
          $contracts['status'] = $get_contract['status'];


          $get_customer_detail = CustomersModel::where(['id'=>$get_contract['customer_id']])->first();
          if ($get_customer_detail) {
            $contracts['customer_name'] = $get_customer_detail['firstname'];
          }


          $get_single_job = JobsModel::where(['id'=>$get_contract['job_id']])->first();
          if ($get_single_job) {
              $contracts['job_type_id'] = $get_single_job['job_type_id'];
              $contracts['title'] = $get_single_job['title'];
              $contracts['salary'] = $get_single_job['salary'];
              $contracts['profession_name'] = $get_single_job['profession_name'];
              $contracts['experience'] = $get_single_job['experience'];
              $contracts['working_hours'] = $get_single_job['working_hours'];
              $contracts['work_location'] = $get_single_job['work_location'];
              // $contracts['start_date'] = $get_single_job['start_date'];
              $contracts['requirements'] = $get_single_job['requirements'];
              $contracts['description'] = $get_single_job['description'];
              $contracts['driving_license'] = $get_single_job['driving_license'];
              $contracts['own_car'] = $get_single_job['own_car'];

              $newtimeago = $this->newtimeago($get_single_job['created_at']); 
              $contracts['start_date'] = $newtimeago;
          }

        }

        return view('admin.Contracts.view',compact('common','contracts','user'));
    }

    public function change_request_status(Request $request){
          
        $ContractId  = $request->ContractId;
        $Datastatus  = $request->Datastatus;
      
        if ($ContractId!='') {

          $UpdateData = array();
          $UpdateData['status'] = $Datastatus;

          ContractsModel::where(['id' => $ContractId])->update($UpdateData);
             
        }
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



