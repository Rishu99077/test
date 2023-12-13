<?php
namespace App\Http\Controllers\Front;

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
use App\Models\JobsFavouriteModel;
use App\Models\JobTypesModel;
use App\Models\JobTypesDescriptionModel;
use App\Models\JobRequirementsModel;
use App\Models\ContractsModel;

use App\Models\CustomerLanguage;
use App\Models\CustomerOtherKnowledge;
use App\Models\CustomerEducation;
use App\Models\CustomerSchool;
use App\Models\CustomerProfession;
use App\Models\CustomerHiringHistory;
use App\Models\CustomerExperiance;
use App\Models\CustomerPermission;
use App\Models\CustomerInformation;
use App\Models\AdvertismentModel;
use App\Models\SkillsModel;
use App\Models\HobbiesModel;

class JobController extends Controller{


    public function job(){

    	  $common   = array();
        $jobs     = array();
        $get_jobs = array();

        $common['main_menu']     = 'Job';
        $common['heading_title'] = __('customer.text_published').' '. __('customer.text_jobs');

        $cust_id = Session::get('cust_id');
        $user    = CustomersModel::where(['id' => $cust_id])->first();


        @$JobSearch = @$_GET['JobSearch'];
        @$LocSearch = @$_GET['LocSearch'];
        @$jobno     = @$_GET['job_no'];
        @$search_everything     = @$_GET['search_everything'];

        $JobsModel = JobsModel::select('jobs.*','jobs.id AS job_id',)
                              ->leftJoin('customers','customers.id','=','jobs.customer_id')
                              ->where(['jobs.customer_id' => $cust_id]);

        $sort    = "jobs.id";
        $orderby = "Desc";
      
        if ($JobSearch!='') {
            $JobsModel->where('title','LIKE','%'.$JobSearch.'%');
        }  
        if ($LocSearch!='') {
            $JobsModel->where('work_location','LIKE','%'.$LocSearch.'%');
        }  
        if ($jobno!='') {
            $JobsModel->where('jobs.id','LIKE','%'.$jobno.'%');
        }  
        if(@$_GET['search_everything']){
            $search = @$_GET['search_everything'];
            $JobsModel->where('customers.firstname', 'LIKE','%'.$search.'%')->Orwhere('customers.surname', 'LIKE','%'.$search.'%')->Orwhere('jobs.title', 'LIKE','%'.$search.'%');
        }

        if(@$_GET['sort']){
           if(@$_GET['sort'] == "date"){
              $sort    = "customers.created_at";
              $orderby = "Desc";
           }else{
              $sort    = "jobs.title";
              $orderby = "asc";
           }
        } 

        $get_jobs = $JobsModel->orderBy($sort,$orderby)->paginate(6);

        foreach ($get_jobs as $key => $value) {
          $row['id']              = $value['job_id'];
          $row['job_type_id']     = $value['job_type_id'];
          $row['title']           = $value['title'];
          $row['salary']          = $value['salary'];
          $row['profession_name'] = $value['profession_name'];
          $row['experience']      = $value['experience'];
          $row['working_hours']   = $value['working_hours'];
          $row['work_location']   = $value['work_location'];
          $row['start_date']      = $value['start_date'];
          $row['requirements']    = $value['requirements'];
          $row['description']     = $value['description'];
          $row['driving_license'] = $value['driving_license'];
          $row['own_car']         = $value['own_car'];
          $row['status']          = $value['status'];
          $row['wishlist']        = '0';

          $get_favourite = JobsFavouriteModel::where(['job_id'=>$value['id'],'customer_id'=>$cust_id])->first();
          if ($get_favourite) {
            $row['wishlist']  = '1';
          }
         
          $newtimeago = $this->newtimeago($value['created_at']); 
          $row['datetime']  = $newtimeago;

          $row['contract_count'] = '0';
          $ContractsModel = ContractsModel::where(['job_id'=>$value['id']]);
          $ContractsModel->whereIn('status', ['Published']);
          $get_contract   = $ContractsModel->get();
          
          if ($get_contract) {
            $row['contract_count'] = count($get_contract);
          }

          $jobs[] = $row;
      
        }
        return view('front.Job.jobs',compact('common','jobs','user','get_jobs'));
    }

    public function job_add(){
    	  $common = array();
        $common['main_menu'] = 'Job';
        $common['heading_title'] = __('customer.text_add').' '. __('customer.text_jobs');

        $cust_id = Session::get('cust_id');
        $user = CustomersModel::where(['id' => $cust_id])->first();

        $job_requirements = array();
        $get_jobs = array();
        $get_job_type_desc = array();

        $get_jobs['id']              = '';
        $get_jobs['job_type_id']     = '';
        $get_jobs['title']           = '';
        $get_jobs['salary']          = '';
        $get_jobs['profession_name'] = '';
        $get_jobs['experience']      = '';
        $get_jobs['working_hours']   = '';
        $get_jobs['work_location']   = '';
        $get_jobs['day']             = '';
        $get_jobs['month']           = '';
        $get_jobs['year']            = '';
        $get_jobs['start_date']      = '';
        $get_jobs['requirements']    = '';
        $get_jobs['description']     = '';
        $get_jobs['driving_license'] = '';
        $get_jobs['own_car']         = '';
        $get_jobs['status']          = '';

        $Job_id = @$_GET['id'];
        if ($Job_id!='') {
          $common['heading_title']    = __('customer.text_edit').' '. __('customer.text_jobs');
          $Job = JobsModel::where(['id' => $Job_id])->first();
          $get_jobs['id']              = $Job['id'];
          $get_jobs['job_type_id']     = $Job['job_type_id'];          
          $get_jobs['title']           = $Job['title'];
          $get_jobs['salary']          = $Job['salary'];
          $get_jobs['profession_name'] = $Job['profession_name'];
          $get_jobs['experience']      = $Job['experience'];
          $get_jobs['working_hours']   = $Job['working_hours'];
          $get_jobs['work_location']   = $Job['work_location'];
          $get_jobs['start_date']      = $Job['start_date'];

          // $StartDate = explode('/', $Job['start_date']);
          
          // $get_jobs['day']   = $StartDate[0];
          // $get_jobs['month'] = $StartDate[1];
          // $get_jobs['year']  = $StartDate[2];

          $get_jobs['requirements']    = $Job['requirements'];
          $get_jobs['description']     = $Job['description'];
          $get_jobs['driving_license'] = $Job['driving_license'];
          $get_jobs['own_car']         = $Job['own_car'];
          $get_jobs['status']          = $Job['status'];

          $get_requirments = JobRequirementsModel::where(['job_id'=>$Job_id])->get();
          if ($get_requirments) {
            foreach ($get_requirments as $key => $value_req) {
              $row['requirements'] = $value_req['requirements'];
              $job_requirements[]  = $row;
            }
          }

        }

        $language_id = 1;
        $get_job_type_desc = JobTypesDescriptionModel::where(['language_id'=>$language_id])->get();
      
        return view('front.Job.job_add',compact('common','get_job_type_desc','user','get_jobs','job_requirements'));
        
    }


    public function save_job(Request $request){
        $cust_id = Session::get('cust_id');
        $user = CustomersModel::where(['id' => $cust_id])->first();

        $validator = Validator::make($request->all(), [

            'job_type_id'     => 'required',
            'title'           => 'required',
            'salary'          => 'required',
            'profession_name' => 'required',
            'experience'      => 'required',
            'working_hours'   => 'required',
            'work_location'   => 'required',
            // 'day'             => 'required',
            // 'month'           => 'required',
            // 'year'            => 'required',
            'requirements'    => 'required',

        ]);
         if ($validator->fails()){
            return back()->withErrors($validator)->withInput();
         }

        $data = $request->all();


        $Job_id  = $request->Job_id;

        if ($Job_id=='') {
            $Data = array();
            $Data['job_type_id']     = $data['job_type_id'];
            $Data['title']           = $data['title'];
            $Data['salary']          = $data['salary'];
            $Data['profession_name'] = $data['profession_name'];
            $Data['experience']      = $data['experience'];
            $Data['working_hours']   = $data['working_hours'];
            $Data['work_location']   = $data['work_location'];
         // $Data['start_date']      = $data['day'].'/'.$data['month'].'/'.$data['year'];
            $Data['start_date']      = $data['start_date'];
            $Data['description']     = $data['description'];
            $Data['driving_license'] = $data['driving_license'];
            $Data['own_car']         = $data['own_car'];
            $Data['status']          = 'Pending';
            $Data['customer_id']     = $cust_id;

            $insert_id = JobsModel::create($Data);

            foreach ($request->requirements as $key => $value_req) {
              if($value_req !=""){
                $data_desc = array();  
                $data_desc['job_id'] = $insert_id['id'];
                $data_desc['requirements'] = $value_req;

                JobRequirementsModel::create($data_desc);    
              }
            }  

            return redirect('job')->withErrors(['success'=> __('customer.text_jobs').' '.__('customer.text_add_success')]);    
        }else{

            $UpdateData = array();
            $UpdateData['job_type_id']     = $data['job_type_id'];
            $UpdateData['title']           = $data['title'];
            $UpdateData['salary']          = $data['salary'];
            $UpdateData['profession_name'] = $data['profession_name'];
            $UpdateData['experience']      = $data['experience'];
            $UpdateData['working_hours']   = $data['working_hours'];
            $UpdateData['work_location']   = $data['work_location'];
            // $UpdateData['start_date']      = $data['day'].'/'.$data['month'].'/'.$data['year'];
            $UpdateData['start_date']      = $data['start_date'];
            // $UpdateData['requirements'] = $data['requirements'];
            $UpdateData['description']     = $data['description'];
            $UpdateData['driving_license'] = $data['driving_license'];
            $UpdateData['own_car']         = $data['own_car'];
            $UpdateData['customer_id']     = $cust_id;

            JobsModel::where(['id' => $Job_id])->update($UpdateData);

            JobRequirementsModel::where('job_id',$Job_id)->delete();

            foreach ($request->requirements as $key => $value) {
                $data_desc = array();  
                $data_desc['job_id'] = $Job_id;
                $data_desc['requirements'] = $request->requirements[$key];

                JobRequirementsModel::create($data_desc);    
            }  

            return redirect('job')->withErrors(['success'=> __('customer.text_jobs').' '.__('customer.text_update_success')]);
        }
          
    }


    public function job_detail(){
    
        $common = array();
        $common['main_menu'] = 'Job';
        $common['heading_title'] = __('customer.text_add').' '. __('customer.text_jobs');

        $cust_id = Session::get('cust_id');
        $user = CustomersModel::where(['id' => $cust_id])->first();

        $Job_id = @$_GET['id'];
       
        $contracts = array();
        $job_details = array();
        $contract = array();


        $Job = JobsModel::where(['id' => $Job_id])->first();
        
        if ($Job) {
          $job_details['id']          = $Job['id'];
          $job_details['job_type_id'] = $Job['job_type_id'];
          $job_details['title']       = $Job['title'];
          $job_details['salary']      = $Job['salary'];
          $job_details['profession_name'] = $Job['profession_name'];
          $job_details['experience']    = $Job['experience'];
          $job_details['working_hours'] = $Job['working_hours'];
          $job_details['work_location'] = $Job['work_location'];
          $job_details['start_date']    = $Job['start_date'];
          $job_details['requirements']  = $Job['requirements'];
          $job_details['description']   = $Job['description'];
          $job_details['driving_license'] = $Job['driving_license'];
          $job_details['own_car']       = $Job['own_car'];
          $job_details['status']        = $Job['status'];

          $job_details['wishlist'] = '0';
          $get_favourite = JobsFavouriteModel::where(['job_id'=>$Job['id'],'customer_id'=>$cust_id])->first();
          if ($get_favourite) {
            $job_details['wishlist'] = '1';
          }

          $job_details['contract_count'] = '0';
          $ContractsModel = ContractsModel::where(['job_id'=>$Job['id']]);
          $ContractsModel->whereIn('status', ['Published']);
          $get_contract = $ContractsModel->orderBy('id','Desc')->paginate(3);
          
          if ($get_contract) {
            $job_details['contract_count'] = count($get_contract);
          }

          
          if ($get_contract) {
            foreach ($get_contract as $key => $value) {
              $contract['id'] = $value['id'];
              $contract['job_id'] = $value['job_id'];
              $contract['customer_id'] = $value['customer_id'];

              $contract['customer_name'] = '';
              $get_customer = CustomersModel::where(['id' => $value['customer_id']])->first();
              if ($get_customer) {
                $contract['customer_name'] = $get_customer['firstname'];
                $contract['profile_image'] = $get_customer['profile_image'];
              }

              $contract['status'] = $value['status'];

              $get_job = JobsModel::where(['id' => $value['job_id']])->first();
              $contract['job_type_id']    = $get_job['job_type_id'];
              $contract['title']          = $get_job['title'];
              $contract['salary']         = $get_job['salary'];
              $contract['profession_name']= $get_job['profession_name'];
              $contract['experience']     = $get_job['experience'];
              $contract['working_hours']  = $get_job['working_hours'];
              $contract['work_location']  = $get_job['work_location'];
              $contract['start_date']     = $get_job['start_date'];
              $contract['requirements']   = $get_job['requirements'];
              $contract['description']    = $get_job['description'];
              $contract['driving_license']= $get_job['driving_license'];
              $contract['own_car']        = $get_job['own_car'];

              $contracts[] = $contract;
            }
          }

          $newtimeago = $this->newtimeago($Job['created_at']); 
          $job_details['datetime'] = $newtimeago;
        }
        return view('front.Job.job_view',compact('common','user','job_details','contracts'));

    }

    public function seeker_job_detail(){
    
        $common = array();
        $common['main_menu'] = 'Dashboard';
        $common['heading_title'] = __('customer.text_jobs').' '.__('customer.text_detail');

        $cust_id = Session::get('cust_id');
        $user = CustomersModel::where(['id' => $cust_id])->first();

        $Job_id = @$_GET['id'];
       
        $job_details = array();
        $Job = JobsModel::where(['id' => $Job_id])->first();

        if ($Job) {
          $job_details['id'] = $Job['id'];
          $job_details['job_type_id'] = $Job['job_type_id'];
          $job_details['title'] = $Job['title'];
          $job_details['salary'] = $Job['salary'];
          $job_details['profession_name'] = $Job['profession_name'];
          $job_details['experience'] = $Job['experience'];
          $job_details['working_hours'] = $Job['working_hours'];
          $job_details['work_location'] = $Job['work_location'];
          $job_details['start_date'] = $Job['start_date'];
          $job_details['requirements'] = $Job['requirements'];
          $job_details['description'] = $Job['description'];
          $job_details['driving_license'] = $Job['driving_license'];
          $job_details['own_car'] = $Job['own_car'];
          $job_details['status'] = $Job['status'];

          $job_details['wishlist'] = '0';
          $get_favourite = JobsFavouriteModel::where(['job_id'=>$Job['id'],'customer_id'=>$cust_id])->first();
          if ($get_favourite) {
            $job_details['wishlist'] = '1';
          }

          $job_details['contract'] = '';
          $ContractsModel = ContractsModel::where(['job_id'=>$Job['id'],'customer_id'=>$cust_id]);
          $get_contract = $ContractsModel->first();

          if ($get_contract) {
            $job_details['contract']        = '1';
            $job_details['contract_status'] = $get_contract['status'];
          }

          $newtimeago = $this->newtimeago($Job['created_at']); 
          $job_details['datetime'] = $newtimeago;


          $job_details['requirements'] = array();
          $JobRequirementsModel = JobRequirementsModel::where(['job_id'=>$Job['id']])->get();
          if(!$JobRequirementsModel->isEmpty()){
            foreach($JobRequirementsModel as $key => $value) {
               $row = array(); 
               $row['requirements']     = $value['requirements']; 
               
               $job_details['requirements'][] = $row;
            }
          }


        }
        return view('front.Seeker.seeker_job_view',compact('common','user','job_details'));

    }

    public function add_wishlist(Request $request){
      $cust_id = Session::get('cust_id');
      $Job_ID = $request->Job_ID;
      $Data = array();
      
      $get_favourite = JobsFavouriteModel::where(['job_id'=>$Job_ID,'customer_id'=>$cust_id])->first();
      if ($get_favourite=='') {
        $Data['job_id'] = $Job_ID;
        $Data['customer_id'] = $cust_id;
        $insert_id = JobsFavouriteModel::create($Data);

        $request->session()->flash('success', __('customer.text_job_add_to_fav'));
        // return redirect('job')->withErrors(['success'=> 'Jobs added to Favorite']);  
      }else{
        JobsFavouriteModel::where('job_id', $Job_ID)->delete();
        $request->session()->flash('danger', __('customer.text_job_remove_to_fav'));
      }


    }


    public function save_contract(Request $request){
      $cust_id = Session::get('cust_id');
      $Job_ID = $request->Job_ID;
      $Data = array();
      
      $get_contract = ContractsModel::where(['job_id'=>$Job_ID,'customer_id'=>$cust_id])->first();
      if ($get_contract=='') {

        $Data['job_id'] = $Job_ID;
        $Data['customer_id'] = $cust_id;
        $Data['status'] = 'Pending';
        $insert_id = ContractsModel::create($Data);

        $request->session()->flash('success', __('customer.text_contracts').' '.__('customer.text_add')); 
      }


    }


    public function job_delete(Request $request){
      if(@$_GET['id'] != ''){
        $Job_id = @$_GET['id'];
        JobsModel::where('id', $Job_id)->delete(); 
      }
      return redirect('job')->withErrors(['error'=> __('customer.text_job').' '.__('customer.text_delete')]);
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


    public function applicant_view_profile(){
      $common                  = array();
      $common['main_menu']     = 'Job';
      $common['heading_title'] = __('customer.text_published').' '. __('customer.text_jobs');

      $cust_id = Session::get('cust_id');
      $user = CustomersModel::where(['id' => $cust_id])->first();

      $Contract_ID = @$_GET['id'];

      $ContractsModel = ContractsModel::where(['id' => $Contract_ID]);
      $ContractsModel->whereIn('status', ['Published']);
      $get_contract = $ContractsModel->first();
          
      $contract = array();
      
      if ($get_contract) {
          $contract['id']             = $get_contract['id'];
          $contract['job_id']         = $get_contract['job_id'];
          $contract['customer_id']    = $get_contract['customer_id'];
          $contract['contract_status']= $get_contract['status'];

          $get_customer = CustomersModel::where(['id' => $get_contract['customer_id']])->first();
          if ($get_customer) {
            $contract['customer_name'] = $get_customer['firstname'];
            $contract['customer_surname'] = $get_customer['surname'];
            $contract['email'] = $get_customer['email'];
          }

          $contract['status'] = $get_contract['status'];

          $get_job = JobsModel::where(['id' => $get_contract['job_id']])->first();
          if ($get_job) {
            $contract['job_type_id']      = $get_job['job_type_id'];
            $contract['title']            = $get_job['title'];
            $contract['salary']           = $get_job['salary'];
            $contract['profession_name']  = $get_job['profession_name'];
            $contract['experience']       = $get_job['experience'];
            $contract['working_hours']    = $get_job['working_hours'];
            $contract['work_location']    = $get_job['work_location'];
            $contract['start_date']       = $get_job['start_date'];
            $contract['requirements']     = $get_job['requirements'];
            $contract['description']      = $get_job['description'];
            $contract['driving_license']  = $get_job['driving_license'];
            $contract['own_car']          = $get_job['own_car'];

            $newtimeago = $this->newtimeago($get_job['created_at']); 
            $contract['create_time'] = $newtimeago;
          }


          ////Edutucation Source
          $users['education_source'] = array();
          $CustomerSchool = CustomerSchool::where('customer_id',$get_contract['customer_id'])->get();
          if(!$CustomerSchool->isEmpty()){
            foreach($CustomerSchool as $key => $value) {
               $edu_source                    = array(); 
               $edu_source['school_name']     = $value['school_name']; 
               $edu_source['school_address']  = $value['school_address']; 
               $edu_source['school_year']     = $value['school_year']; 
               
               $users['education_source'][] = $edu_source;
            }
          }


          /////Hiring History
          $users['hiring_history'] = array();
          $CustomerHiringHistory = CustomerHiringHistory::where('customer_id',$get_contract['customer_id'])->get();
          if(!$CustomerHiringHistory->isEmpty()){
            foreach($CustomerHiringHistory as $key => $value2) {
                $customer_hiring   = array();
                $customer_hiring['company_name']    = $value2['company_name'];
                $customer_hiring['company_address'] = $value2['company_address'];
                $customer_hiring['working_year']    = $value2['working_year'];
                
                $users['hiring_history'][]  = $customer_hiring;
            }
          }

          ////Experiance in Ablroad
          $users['exp_abroad'] = array();
          $CustomerExperiance = CustomerExperiance::where('customer_id',$get_contract['customer_id'])->get();
          if(!$CustomerExperiance->isEmpty()){
            foreach($CustomerExperiance as $key => $value3) {
                $customer_exp_abrod   = array();
                $customer_exp_abrod['company_name']    = $value3['company_name'];
                $customer_exp_abrod['company_address'] = $value3['company_address'];
                $customer_exp_abrod['working_year']    = $value3['working_year'];
                
                $users['exp_abroad'][]  = $customer_exp_abrod;
            }
          }

          ////Skills
          $users['skills'] = array();
          $SkillsModel = SkillsModel::where('customer_id',$get_contract['customer_id'])->get();
          if(!$SkillsModel->isEmpty()){
            foreach($SkillsModel as $key => $value4) {
                $customer_skill   = array();
                $customer_skill['skill']    = $value4['skill'];
                
                $users['skills'][]  = $customer_skill;
            }
          }


          ////Permissions
          $users['permission'] = array();
          $CustomerPermission = CustomerPermission::where('customer_id',$get_contract['customer_id'])->get();
          if(!$CustomerPermission->isEmpty()){
            foreach($CustomerPermission as $key => $value_per) {
                $customer_permission   = array();
                $customer_permission['permission']    = $value_per['permission'];
                
                $users['permission'][]  = $customer_permission;
            }
          }


           ////Langugaes
          $users['cust_language'] = array();
          $CustomerLanguage = CustomerLanguage::where('customer_id',$get_contract['customer_id'])->get();
          if(!$CustomerLanguage->isEmpty()){
            foreach($CustomerLanguage as $key => $value_lang) {
                $customer_language   = array();
                $customer_language['language']    = $value_lang['language'];
                
                $users['cust_language'][]  = $customer_language;
            }
          }


           ////Other Knowledge
          $users['other_knowledges'] = array();
          $CustomerOtherKnowledge = CustomerOtherKnowledge::where('customer_id',$get_contract['customer_id'])->get();
          if(!$CustomerOtherKnowledge->isEmpty()){
            foreach($CustomerOtherKnowledge as $key => $value_oth) {
                $customer_other   = array();
                $customer_other['other_knowledge']    = $value_oth['other_knowledge'];
                
                $users['other_knowledges'][]  = $customer_other;
            }
          }


          /////Intrest & Hobbies
          $users['hobbies'] = array();
          $HobbiesModel = HobbiesModel::where('customer_id',$get_contract['customer_id'])->get();
          if(!$HobbiesModel->isEmpty()){
            foreach($HobbiesModel as $key => $value5) {
                $customer_hobbies   = array();
                $customer_hobbies['hobby']    = $value5['hobby'];
                
                $users['hobbies'][]  = $customer_hobbies;
            }
          }

          /////Addition indo 
          $users['add_info'] = array();
          $CustomerInformation = CustomerInformation::where('customer_id',$get_contract['customer_id'])->get();
          if(!$CustomerInformation->isEmpty()){
            foreach($CustomerInformation as $key => $value_info) {
                $customer_info   = array();
                $customer_info['information']    = $value_info['information'];
                
                $users['add_info'][]  = $customer_info;
            }
          }


          /////Profession
          $users['professions'] = array();
          $CustomerProfession = CustomerProfession::where('customer_id',$get_contract['customer_id'])->get();
          if(!$CustomerProfession->isEmpty()){
            foreach($CustomerProfession as $key => $value6) {
                $customer_professions   = array();
                $customer_professions['profession_name']    = $value6['profession_name'];
                $customer_professions['profession_year']    = $value6['profession_year'];
                
                $users['professions'][]  = $customer_professions;
            }
          }  

      }


      return view('front.Job.applicant_profile',compact('common','contract','user','users'));
    }


    public function change_job_status(Request $request){
          
        $ContractId  = $request->ContractId;
        $JobId       = $request->JobId;
        $Datastatus  = $request->Datastatus;
      
        if ($ContractId!='') {

          $UpdateData = array();
          $UpdateData['status'] = $Datastatus;

          ContractsModel::where(['id' => $ContractId])->update($UpdateData);

          $UpdateJob = array();
          $UpdateJob['contract_id'] = $ContractId;
          $UpdateJob['status'] = $Datastatus;

          JobsModel::where(['id' => $JobId])->update($UpdateJob);
             
        }
    }
}



