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
use App\Models\AdvertismentModel;
use App\Models\AdvertismentContract;
use App\Models\CountryModel;
use App\Models\ReportsModel;

class ListController extends Controller{


  // Applicants
	public function providers_list(){

        $common = array();
        $common['main_menu'] = 'Applicants';
        $common['sub_menu']  = 'Applicants';

        $common['heading_title'] = 'Providers List';

        $user = array();
        $user_id = Session::get('user_id');
        $user = UserModel::where(['id' => $user_id])->first();

        $get_providers = array();
        $get_providers = CustomersModel::where(['role'=>'provider'])->orderBy('id','ASC')->paginate(10);

        return view('admin.List.providers_list',compact('common','user','get_providers'));

  }

  public function providers_jobs($id=''){

      $common = array();
      $common['main_menu'] = 'Applicants';
      $common['sub_menu']  = 'Applicants';
      $common['heading_title'] = 'Jobs posted';

      $user = array();
      $user_id = Session::get('user_id');
      $user = UserModel::where(['id' => $user_id])->first();
      

      $JobsModel = JobsModel::where(['customer_id' => $id]);

      $sort    = "jobs.id";
      $orderby = "Desc";
    
      $get_jobs = array();
      $jobs = array();

      $get_jobs = $JobsModel->orderBy($sort,$orderby)->paginate(6);

      foreach ($get_jobs as $key => $value) {
    			$row['id'] 		  = $value['id'];
    			$row['job_type_id'] = $value['job_type_id'];
    			$row['title'] 	  = $value['title'];
    			$row['salary'] 	  = $value['salary'];
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
    			$get_contract = $ContractsModel->get();

    			if ($get_contract) {
    			$row['contract_count'] = count($get_contract);
    			}

    			$jobs[] = $row;
    	}

      return view('admin.List.providers_jobs',compact('common','user','jobs','get_jobs'));

  }

  public function providers_applicants($jobid=''){

      $common = array();
      $common['main_menu'] = 'Applicants';
      $common['sub_menu']  = 'Applicants';
      $common['heading_title'] = 'Applicants';

      $user = array();
      $user_id = Session::get('user_id');
      $user = UserModel::where(['id' => $user_id])->first();

      $get_contract = array();
      $contracts = array();
      $get_contract = ContractsModel::where('job_id',$jobid)->paginate(6);

      foreach ($get_contract as $key => $value) {
        $row = array();
        $row['job_id'] = $value['job_id'];
        $row['customer_id'] = $value['customer_id'];

        $get_customer_detail = CustomersModel::where('id',$value['customer_id'])->first();

        if ($get_customer_detail) {
          $row['customer_name'] = $get_customer_detail['firstname'].' '.$get_customer_detail['surname'];
        }

        $get_job_detail = JobsModel::where('id',$value['job_id'])->first();

        if ($get_job_detail) {
          $row['driving_license'] = $get_job_detail['driving_license'];
          $row['own_car']         = $get_job_detail['own_car'];
          $row['experience']      = $get_job_detail['experience'];
          $row['start_date']      = $get_job_detail['start_date'];
          $row['working_hours']   = $get_job_detail['working_hours'];
          $row['work_location']   = $get_job_detail['work_location'];
        }

        $newtimeago = $this->newtimeago($value['created_at']); 
        $row['datetime'] = $newtimeago;

        $contracts[] = $row;
      }
      return view('admin.List.providers_applicants',compact('common','user','get_contract','contracts'));

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


  // Employees
  public function employes_list(){

      $common = array();
      $common['main_menu'] = 'Employees';
      $common['sub_menu']  = 'Employees';
      $common['heading_title'] = 'Employees';

      $user = array();
      $user_id = Session::get('user_id');
      $user = UserModel::where(['id' => $user_id])->first();

      $get_contract = array();
      $contracts = array();
      $get_contract = ContractsModel::orderBy('id','desc')->paginate(6);

      foreach ($get_contract as $key => $value) {
        $row = array();
        $row['contract_id'] = $value['id'];
        $row['contract_status'] = $value['status'];
        $newtimeago = $this->newtimeago($value['created_at']); 
        $row['datetime'] = $newtimeago;

        $get_customer_detail = CustomersModel::where('id',$value['customer_id'])->first();

        if ($get_customer_detail) {
          $row['employee_name'] = $get_customer_detail['firstname'].' '.$get_customer_detail['surname'];
        }

        $get_job_detail = JobsModel::where('id',$value['job_id'])->first();

        if ($get_job_detail) {
          $row['job_id']          = $get_job_detail['id'];
          $row['title']           = $get_job_detail['title'];
          $row['salary']          = $get_job_detail['salary'];
          $row['profession_name'] = $get_job_detail['profession_name'];  
          $row['driving_license'] = $get_job_detail['driving_license'];
          $row['own_car']         = $get_job_detail['own_car'];
          $row['experience']      = $get_job_detail['experience'];
          $row['start_date']      = $get_job_detail['start_date'];
          $row['working_hours']   = $get_job_detail['working_hours'];
          $row['work_location']   = $get_job_detail['work_location'];

          $get_provider_detail = CustomersModel::where('id',$get_job_detail['customer_id'])->first();

          if ($get_provider_detail) {
            $row['provider_name'] = $get_provider_detail['firstname'].' '.$get_provider_detail['surname'];
          }

        }


        $contracts[] = $row;
      }
      return view('admin.List.employes_list',compact('common','user','get_contract','contracts'));

  }

  // Seeker advertisment
  public function seeker_advertisment(){

      $common = array();
      $common['main_menu']     = 'advertisment';
      $common['sub_menu']      = 'advertisment';
      $common['heading_title'] = 'Advertisment posted by Seekers';

      $user = array();
      $user_id = Session::get('user_id');
      $user = UserModel::where(['id' => $user_id])->first();

      $get_advertisment = array();
      $advertisments = array();
      $get_advertisment = AdvertismentModel::orderBy('id','desc')->paginate(6);

      foreach ($get_advertisment as $key => $value) {
        $row = array();
        $row['adv_id']          = $value['id'];
        $row['employee_name']   = $value['firstname'].' '.$value['familyname'];
        $row['working_hour']    = $value['working_hour'];
        $row['experience']      = $value['experience'];
        $row['work_location']   = $value['work_location'];
        $row['driving_license'] = $value['driving_license'];
        $row['own_car']         = $value['own_car'];
        $row['date']            = $value['date'];
        $row['status']          = $value['status'];

        $newtimeago = $this->newtimeago($value['created_at']); 
        $row['datetime'] = $newtimeago;

        $row['adv_contract_count'] = 0;
        $get_adv_contract = AdvertismentContract::where('advertisment_id',$value['id'])->get();
        if ($get_adv_contract) {
          $row['adv_contract_count'] = count($get_adv_contract);
        }

        $advertisments[] = $row;
      }
      return view('admin.List.seeker_advertisment',compact('common','user','get_advertisment','advertisments'));

  }


  // Edit advertisment
  public function edit_advertisment($adv_id=''){

      $common = array();
      $common['main_menu']     = 'advertisment';
      $common['sub_menu']      = 'advertisment';
      $common['heading_title'] = 'Edit Advertisment';

      $user = array();
      $user_id = Session::get('user_id');
      $user = UserModel::where(['id' => $user_id])->first();

      $get_advertisment = array();
      $get_advertisment = AdvertismentModel::where('id',$adv_id)->first();
      $CountryModel     = CountryModel::get();

      return view('admin.List.edit_advertisment',compact('common','user','get_advertisment','CountryModel'));

  }

  public function update_advertisment(Request $request){

      $get_advertisment = array();
     
      $get_advertisment['firstname']       ="";
      $get_advertisment['familyname']      ="";
      $get_advertisment['academic_level']  ="";
      $get_advertisment['nationality']     ="";
      $get_advertisment['country']         ="";
      $get_advertisment['zipcode']         ="";
      $get_advertisment['profession_name'] ="";
      $get_advertisment['hours_salary']    ="";
      $get_advertisment['working_hour']    ="";
      $get_advertisment['experience']      ="";
      $get_advertisment['work_location']   ="";
      $get_advertisment['date']            ="";
      // $get_advertisment['day']             ="";
      // $get_advertisment['month']           ="";
      // $get_advertisment['year']            ="";
      $get_advertisment['driving_license'] ="";
      $get_advertisment['own_car']         ="";
      $get_advertisment['description']     ="";
      $get_advertisment['id']              ="";


      if($request->isMethod('post')){
          $req_fields = array(
              'firstname'         => 'required',
              'familyname'        => 'required',
              // 'academic_level'    => 'required',
              'nationality'       => 'required',
              'country'           => 'required',
              'zipcode'           => 'required',
              'profession_name'   => 'required',
              'hours_salary'      => 'required',
              'working_hour'      => 'required',
              'experience'        => 'required',
              'work_location'     => 'required',
              'date'              => 'required',
              // 'day'               => 'required',
              // 'month'             => 'required',
              // 'year'              => 'required',
              // 'description '      => 'required',
          );
          
          $validator = Validator::make(
              $request->all(),
              $req_fields
          );

          
          if($validator->fails()) {
             return back()->withErrors($validator)->withInput();
          }
  
          $data                    = array();
          if($request->id !=""){
             $message              = __('customer.text_advertisment').' '.__('customer.text_update_success');
             $data                 = $request->except('id','_token');
             $Advertisment         = AdvertismentModel::find($request->id);
          }else{
             $message              =__('customer.text_advertisment').' '.__('customer.text_add_success');
             $Advertisment         = new AdvertismentModel();
             $data                 = $request->except('_token');
          }
          
          foreach($data as $key => $value) {
              $Advertisment->$key = $value;
          }
          $Advertisment->save();
          return back()->withErrors(["success" => $message]);
      }

  }

  public function change_advertisment_status(Request $request){
          
      $Adv_ID  = $request->Adv_ID;
      $Datastatus  = $request->Datastatus;
    
      if ($Adv_ID!='') {

        $UpdateData = array();
        $UpdateData['status'] = $Datastatus;

        AdvertismentModel::where(['id' => $Adv_ID])->update($UpdateData);    
      }
  }


  /*Actual contarcts*/
  public function actual_contracts(){


      $common = array();
      $common['main_menu']     = 'actual_contracts';
      $common['sub_menu']      = 'actual_contracts';
      $common['heading_title'] = 'Actual contracts';

      $user = array();
      $user_id = Session::get('user_id');
      $user = UserModel::where(['id' => $user_id])->first();

        ///// Actual Contract
        $ContractsModel  = ContractsModel::select('contracts.*')
                            ->leftJoin("jobs", "jobs.id", "=", "contracts.job_id")
                            ->where('contracts.status','Ongoing');

        ///Actual Contract Filter
        
        if(@$_GET['offer_no']){
            $search_name =  @$_GET['offer_no'];
            $ContractsModel->where('contracts.id',$search_name);
        }
        if(@$_GET['profession']){
            $search_name =  @$_GET['profession'];
            $ContractsModel->where('profession_name',$search_name);
        }
        if(@$_GET['location']){
            $search_name =  @$_GET['location'];
            $ContractsModel->where('work_location',$search_name);
        }

        if(@$_GET['salary_from']){
            $search_name =  @$_GET['salary_from'];
            $ContractsModel->where('salary','>=',$search_name); 
        }
        if(@$_GET['salary_to']){
            $search_name =  @$_GET['salary_to'];
            $ContractsModel->where('salary','<=',$search_name);
        }
        if(@$_GET['sort']){
           $sort      = @$_GET['sort'];
           if($sort == "start"){
               $order_by  = "created_at";
               $sort_type = "asc"; 
           }
           if($sort == "date"){
               $order_by  = "created_at"; 
               $sort_type = "desc"; 
           }

        }

        $order_by  = "id";
        $sort_type = "asc"; 

        $get_contracts = $ContractsModel->orderBy($order_by,$sort_type)->paginate(8);

        $contracts = array();
        if (!empty($get_contracts)) {
            foreach ($get_contracts as $key => $value_con) {
                
                $contract = array();
                $contract['id'] = $value_con['id'];
                $contract['job_id'] = $value_con['job_id'];
                $contract['start_date'] = $value_con['created_at'];

                $contract['title'] = '';
                $get_job_detail = JobsModel::where('id',$value_con['job_id'])->first();
                if (!empty($get_job_detail)) {
                    $contract['title'] = $get_job_detail['title'];
                }

                $contract['document'] = '';
                $get_report_detail = ReportsModel::where('contract',$value_con['id'])->first();
                if (!empty($get_report_detail)) {
                    $contract['document'] = $get_report_detail['document'];
                }
                $contracts[] = $contract;

            }
        }

        return view('admin.List.actual_contracts',compact('common','user','get_contracts','contracts'));
  }


  /*Seeker other Documents*/
  public function other_documents_from_seeker(){
      $common = array();
      $common['main_menu']     = 'other_documents_from_seeker';
      $common['sub_menu']      = 'other_documents_from_seeker';
      $common['heading_title'] = 'Seeker other Documents';

      $user = array();
      $user_id = Session::get('user_id');
      $user = UserModel::where(['id' => $user_id])->first();

      $order_by  = "id";
      $sort_type = "asc"; 

      ///// Seeker Documents
      $documents = array();

      $OtherDocuments = OtherDocuments::select('other_documents.*')
                                      ->leftJoin('customers','customers.id','=','other_documents.customer_id_from')
                                      ->where(['customers.role' => 'seeker']);                                
                              

      $get_other_document  = $OtherDocuments->orderBy($order_by,$sort_type)->paginate(8);

      foreach ($get_other_document as $key => $value_doc) {
          $row = array();
          $row['title']        = '';
          $row['contract_id']  = '';
          $row['document']     = '';
          $row['date']         = '';
    
          $get_seekers = CustomersModel::where(['id'=>$value_doc['customer_id_from']])->first();
          if ($get_seekers) {
            $row['id']           = $value_doc['id'];
            $row['title']        = $value_doc['title'];
            $row['contract_id']  = $value_doc['contract_id'];
            $row['document']     = $value_doc['document'];
            $row['date']         = $value_doc['date'];
            $row['seekername']   = $get_seekers['firstname'].' '.$get_seekers['surname'];
          }
          $documents[] = $row;
      }

      return view('admin.List.other_documents',compact('common','user','get_other_document','documents'));
  }

  /*Provider other Documents*/
  public function other_documents_from_provider(){

      $common = array();
      $common['main_menu']     = 'other_documents_from_provider';
      $common['sub_menu']      = 'other_documents_from_provider';
      $common['heading_title'] = 'Provider other Documents';

      $user = array();
      $user_id = Session::get('user_id');
      $user = UserModel::where(['id' => $user_id])->first();

      $order_by  = "id";
      $sort_type = "asc"; 

      ///// Seeker Documents
      $documents = array();

      $OtherDocuments = OtherDocuments::select('other_documents.*')
                                      ->leftJoin('customers','customers.id','=','other_documents.customer_id_from')
                                      ->where(['customers.role' => 'provider']);                                
                              

      $get_other_document  = $OtherDocuments->orderBy($order_by,$sort_type)->paginate(8);

      foreach ($get_other_document as $key => $value_doc) {
          $row = array();
          $row['title']        = '';
          $row['contract_id']  = '';
          $row['document']     = '';
          $row['date']         = '';
    
          $get_seekers = CustomersModel::where(['id'=>$value_doc['customer_id_from']])->first();
          if ($get_seekers) {
            $row['id']           = $value_doc['id'];
            $row['title']        = $value_doc['title'];
            $row['contract_id']  = $value_doc['contract_id'];
            $row['document']     = $value_doc['document'];
            $row['date']         = $value_doc['date'];
            $row['seekername']   = $get_seekers['firstname'].' '.$get_seekers['surname'];
          }
          $documents[] = $row;
      }

      return view('admin.List.other_documents',compact('common','user','get_other_document','documents'));
  }


  /*Seeker other Documents*/
  public function documents_from_seeker(){
      $common = array();
      $common['main_menu']     = 'documents_from_seeker';
      $common['sub_menu']      = 'documents_from_seeker';
      $common['heading_title'] = 'Seeker  Documents';

      $user = array();
      $user_id = Session::get('user_id');
      $user = UserModel::where(['id' => $user_id])->first();

      $order_by  = "id";
      $sort_type = "asc"; 

      ///// Seeker Documents
      $documents = array();
                               
      $get_seekers = CustomersModel::where(['role'=>'seeker'])->orderBy($order_by,$sort_type)->paginate(8);
    

      foreach ($get_seekers as $key => $value) {
          $row = array();
         
          $row['customer_id']  = $value['id'];
          $row['name']         = $value['firstname'].' '.$value['surname'];
          $row['file']         = $value['file'];
          $row['date']         = $value['created_at'];
        
          $documents[] = $row;
      }

      return view('admin.List.documents',compact('common','user','get_seekers','documents'));
  }


  /*Seeker other Documents*/
  public function documents_from_provider(){
      $common = array();
      $common['main_menu']     = 'documents_from_provider';
      $common['sub_menu']      = 'documents_from_provider';
      $common['heading_title'] = 'Provider  Documents';

      $user    = array();
      $user_id = Session::get('user_id');
      $user    = UserModel::where(['id' => $user_id])->first();

      $order_by  = "id";
      $sort_type = "asc"; 

      ///// Seeker Documents
      $documents = array();
                               
      $get_seekers = CustomersModel::where(['role'=>'provider'])->orderBy($order_by,$sort_type)->paginate(8);
    

      foreach ($get_seekers as $key => $value) {
          $row = array();
         
          $row['customer_id']  = $value['id'];
          $row['name']         = $value['firstname'].' '.$value['surname'];
          $row['file']         = $value['file'];
          $row['date']         = $value['created_at'];
        
          $documents[] = $row;
      }

      return view('admin.List.documents',compact('common','user','get_seekers','documents'));
  }


  public function otherdocument_detail($id=''){
    
        $common = array();
        $common['main_menu'] = 'other_documents_from_provider';
        $common['sub_menu']  = 'other_documents_from_provider';
        $common['heading_title'] = 'Details';

        $user    = array();
        $user_id = Session::get('user_id');
        $user    = UserModel::where(['id' => $user_id])->first();

        $document_id = $id;

        $get_other_document = OtherDocuments::select('other_documents.*','jobs.*','jobs.id as job_id','other_documents.title as doc_title')
                                            ->leftJoin('contracts','contracts.id','=','other_documents.contract_id')
                                            ->leftJoin('jobs','jobs.id','=','contracts.job_id')
                                            ->where('other_documents.id',$document_id)->first()->toArray();

        return view('admin.List.contract_details',compact('common','user','get_other_document'));
    }

}



