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
use App\Models\JobsModel;
use App\Models\CustomersModel;
use App\Models\FavouriteCustomerModel;
use App\Models\LanguagesModel;
use App\Models\WorkManageModel;
use App\Models\ReportsModel;
use App\Models\AdvertismentModel;
use App\Models\ContractsModel;
use App\Models\CustomerExperiance;
use App\Models\AdvertismentContract;
use File;
use ZipArchive;


class ReportController extends Controller{

    /*public function index(){
    	$common = array();
        $common['main_menu']     = 'Work Management';
        $common['heading_title'] = __('customer.text_work_managment');
        $tab          ="";
        $sort_type    ="desc";
        $order_by     ="id";
        $cust_id      = Session::get('cust_id');
        $user         = CustomersModel::where(['id' => $cust_id])->first();

        // Reports ----------------
        $ReportsModel = ReportsModel::where(['customer_id' => $cust_id]);
        if(@$_GET['tab']){
            $tab = @$_GET['tab'];
        }

        if($tab == "Report_tab"){
            if(@$_GET['search_everything']){
                $search_name =  @$_GET['search_everything'];
                $ReportsModel = $ReportsModel->where('contract',$search_name);
            }
            if(@$_GET['contract_no']){
                $search_name =@$_GET['contract_no'];
                $ReportsModel = $ReportsModel->where('contract',$search_name);
            }
            if(@$_GET['month']){
                $search_name =@$_GET['month'];
                $ReportsModel->whereMonth('created_at',$search_name);
            }
            if(@$_GET['year']){
                $search_name  = @$_GET['year'];
                $ReportsModel = $ReportsModel->whereYear('created_at',$search_name);
            }
        
            if(@$_GET['sort']){
               $sort      = @$_GET['sort'];
               if($sort == "name"){
                   $sort_type = "asc"; 
                   $order_by  = "id"; 
               }
               if($sort == "start"){
                   $order_by  = "created_at"; 
                   $sort_type = "asc"; 
               }
               if($sort == "date"){
                   $order_by  = "created_at"; 
                   $sort_type = "desc"; 
               }

            }
        }
        $get_reports = $ReportsModel->orderBy($order_by,$sort_type)->paginate(8);
        $reports     = array();
        if ($get_reports) {
            foreach ($get_reports as $key => $value) {
                $row                     = array();
                $row['id']               = $value['id'];
                $row['contract']         = $value['contract'];
                $row['working_hours']    = $value['working_hours'];
                $row['working_amount']   = $value['working_amount'];
                $row['start_date']       = $value['start_date'];
                $row['end_date']         = $value['end_date'];
                $row['document']         = $value['document'];
                $row['send_provider']    = $value['send_provider'];
                $row['send_admin']       = $value['send_admin'];

                $get_jobs = JobsModel::where(['id' => $value['contract']])->first();
                if ($get_jobs) {
                   $row['job'] = $get_jobs['title'];
                }
                $reports[] = $row;
            }    
        }

        // Advertisment ----------------

        $AdvertismentModel = AdvertismentModel::where(['customer_id' => $cust_id]);
        $sort_type    ="desc";
        $order_by     ="id";
        
          ///Advertisiment Filter
        
        if($tab == "adv_tab"){
            
            if(@$_GET['search_everything']){
                $search_name =  @$_GET['search_everything'];
                $ReportsModel = $ReportsModel->where('contract',$search_name);
            }
            
            if(@$_GET['offer_no']){
                $search_name =  @$_GET['offer_no'];
                $AdvertismentModel->where('id',$search_name);
            }
            if(@$_GET['profession']){
                $search_name =  @$_GET['profession'];
                $AdvertismentModel->where('profession_name',$search_name);
            }
            if(@$_GET['location']){
                $search_name =  @$_GET['location'];
                $AdvertismentModel->where('work_location',$search_name);
            }

            if(@$_GET['salary_from']){
                $search_name =  @$_GET['salary_from'];
                $AdvertismentModel->where('salary','>=',$search_name); 
            }
            if(@$_GET['salary_to']){
                $search_name =  @$_GET['salary_to'];
                $AdvertismentModel->where('salary','<=',$search_name);
            }
            if(@$_GET['sort']){
               $sort      = @$_GET['sort'];
               if($sort == "name"){
                   $sort_type = "asc"; 
                   $order_by  = "id"; 
               }
               if($sort == "start"){
                   $order_by  = "created_at";
                   $sort_type = "asc"; 
               }
               if($sort == "date"){
                   $order_by  = "created_at"; 
                   $sort_type = "desc"; 
               }

            }

        }
        $get_advertisment = $AdvertismentModel->orderBy($order_by,$sort_type)->paginate(6);

        $advs = array();
        if ($get_advertisment) {
            foreach ($get_advertisment as $key => $value) {
                $row = array();
                $row['id']                     = $value['id'];
                $row['firstname']              = $value['firstname'];
                $row['familyname']             = $value['familyname'];
                $row['academic_level']         = $value['academic_level'];
                $row['nationality']            = $value['nationality'];
                $row['country']                = $value['country'];
                $row['zipcode']                = $value['zipcode'];
                $row['profession_name']        = $value['profession_name'];
                $row['hours_salary']           = $value['hours_salary'];
                $row['working_hour']           = $value['working_hour'];
                $row['experience']             = $value['experience'];
                $row['work_location']          = $value['work_location'];
                $row['day']                    = $value['day'];
                $row['month']                  = $value['month'];
                $row['year']                   = $value['year'];
                $row['start_date']             = $value['day'].'/'.$value['month'].'/'.$value['year'];
                $row['driving_license']        = $value['driving_license'];
                $row['own_car']                = $value['own_car'];
                $row['description']            = $value['description'];
                $row['adv_contract_count']     = AdvertismentContract::where('advertisment_id',$value['id'])->count();
                $newtimeago = $this->newtimeago($value['created_at']); 
                $row['datetime'] = $newtimeago;
              
                $advs[] = $row;
            }   
        }


        ///// Actual Contract
        $ContractsModel  = ContractsModel::select('contracts.*')
                            ->leftJoin("jobs", "jobs.id", "=", "contracts.job_id")
                            ->where('contracts.customer_id',$cust_id)
                            ->where('contracts.status','Ongoing');

        ///Actual Contract Filter
        
        if($tab == "actual_contract_tab"){
            
            if(@$_GET['search_everything']){
                $search_name =  @$_GET['search_everything'];
                $ContractsModel = $ContractsModel->where('contract',$search_name);
            }
            
            if(@$_GET['offer_no']){
                $search_name =  @$_GET['offer_no'];
                $ContractsModel->where('id',$search_name);
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
               if($sort == "name"){
                   $sort_type = "asc"; 
                   $order_by  = "jobs.title"; 
               }
               if($sort == "start"){
                   $order_by  = "created_at";
                   $sort_type = "asc"; 
               }
               if($sort == "date"){
                   $order_by  = "created_at"; 
                   $sort_type = "desc"; 
               }

            }

        }
        
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


        ////  Contract to sign

        $ContractsToSign  = ContractsModel::select('contracts.*')
                            ->leftJoin("jobs", "jobs.id", "=", "contracts.job_id")
                            ->where('contracts.customer_id',$cust_id)
                            ->where('contracts.status','Completed');

        if($tab == "contract_tab"){
            
            if(@$_GET['search_everything']){
                $search_name =  @$_GET['search_everything'];
                $ContractsToSign = $ContractsToSign->where('contract',$search_name);
            }
            
            if(@$_GET['offer_no']){
                $search_name =  @$_GET['offer_no'];
                $ContractsToSign->where('id',$search_name);
            }
            if(@$_GET['profession']){
                $search_name =  @$_GET['profession'];
                $ContractsToSign->where('profession_name',$search_name);
            }
            if(@$_GET['location']){
                $search_name =  @$_GET['location'];
                $ContractsToSign->where('work_location',$search_name);
            }

            if(@$_GET['salary_from']){
                $search_name =  @$_GET['salary_from'];
                $ContractsToSign->where('salary','>=',$search_name); 
            }
            if(@$_GET['salary_to']){
                $search_name =  @$_GET['salary_to'];
                $ContractsToSign->where('salary','<=',$search_name);
            }
            if(@$_GET['sort']){
               $sort      = @$_GET['sort'];
               if($sort == "name"){
                   $sort_type = "asc"; 
                   $order_by  = "id"; 
               }
               if($sort == "start"){
                   $order_by  = "created_at";
                   $sort_type = "asc"; 
               }
               if($sort == "date"){
                   $order_by  = "created_at"; 
                   $sort_type = "desc"; 
               }

            }

        }
        
        
        $get_contracts_to_sign = $ContractsToSign->orderBy($order_by,$sort_type)->paginate(8);

        $contracts_to_sign = array();
        if (!empty($get_contracts_to_sign)) {
            foreach ($get_contracts_to_sign as $key => $value_sign) {
                
                $con_sign = array();
                $con_sign['id'] = $value_sign['id'];
                $con_sign['job_id'] = $value_sign['job_id'];
                $con_sign['start_date'] = $value_sign['created_at'];

                $get_job_detail = JobsModel::where('id',$value_sign['job_id'])->first();
                if (!empty($get_job_detail)) {
                    $con_sign['title'] = $get_job_detail['title'];
                }
                $contracts_to_sign[] = $con_sign;

            }
        }
      
        return view('front.WorkManagement.Reports.seeker_index',compact('common','user','get_reports','reports','get_advertisment','advs','get_contracts','contracts','get_contracts_to_sign','contracts_to_sign'));
    }*/

    public function add(){
    	$common = array();
        $common['main_menu']     = 'Work Management';
        $common['heading_title'] = __('customer.text_upload_weekly_report');

        $cust_id = Session::get('cust_id');
        $user    = CustomersModel::where(['id' => $cust_id])->first();

        // $get_jobs  = JobsModel::get();

        $get_jobs = ContractsModel::select('contracts.*','customers.firstname','jobs.title as contract_title')
                                        ->leftJoin('jobs','jobs.id','=','contracts.job_id')
                                        ->leftJoin('customers','customers.id','=','jobs.customer_id')
                                        ->where('contracts.customer_id',$cust_id)->get();                              

        $get_works = array();
        $get_works['id'] = '';
        $get_works['contract'] = '';
        $get_works['working_hours'] = '';
        $get_works['working_amount'] = '';
        $get_works['start_date'] = '';
        $get_works['end_date'] = '';
        $get_works['document'] = '';
        

        $Report_id = @$_GET['id'];
        if ($Report_id!='') {
          $common['heading_title'] = 'Edit Job';
          $Reports = ReportsModel::where(['id' => $Report_id])->first();
          $get_works['id'] = $Reports['id'];
          $get_works['contract'] = $Reports['contract'];          
          $get_works['working_hours'] = $Reports['working_hours'];
          $get_works['working_amount'] = $Reports['working_amount'];
          $get_works['start_date'] = $Reports['start_date'];
          $get_works['end_date'] = $Reports['end_date'];
          $get_works['document'] = $Reports['document'];
        
        }
      
        return view('front.WorkManagement.Reports.add',compact('common','user','get_works','get_jobs'));
        
    }

    public function advertisment_detail(){
        $common = array();
        $common['main_menu']     = 'Work Management';
        $common['heading_title'] = __('customer.text_work_managment');

        $cust_id = Session::get('cust_id');
        $user = CustomersModel::where(['id' => $cust_id])->first();

        $get_advertisment = array();
        $Adv_id = @$_GET['id'];
        if ($Adv_id) {
            $get_advertisment = AdvertismentModel::where(['customer_id' => $cust_id,'id' => $Adv_id])->first();
        }

        return view('front.WorkManagement.Reports.view_adv_details',compact('common','user','get_advertisment'));
    }

    public function save(Request $request){
        
        $cust_id = Session::get('cust_id');
        $user    = CustomersModel::where(['id' => $cust_id])->first();

        $validator = Validator::make($request->all(), [
            'contract'          => 'required',
            'working_hours'     => 'required',
            'working_amount'    => 'required',
            'start_date'        => 'required',
            'end_date'          => 'required',
            'document'          => 'required|mimes:pdf,jpeg,bmp,png',
        ]);
         if ($validator->fails()){
            return back()->withErrors($validator)->withInput();
         }

        $data       = $request->all();
      
        $Report_id  = $request->Report_id;
        
        if ($Report_id=='') {
            $Data = array();
            $Data['contract']        = $data['contract'];
            $Data['working_hours']   = $data['working_hours'];
            $Data['working_amount']  = $data['working_amount'];
            $Data['start_date']      = $data['start_date'];
            $Data['end_date']        = $data['end_date'];
            $Data['document']        = '';
            $Data['customer_id']     = $cust_id;

            if ($data['document']) {
                // $random_no  = uniqid();
                $img = $data['document'];
                $original_name = $img->getClientOriginalName();
                $filename = explode('.', $original_name);
                $name = $filename[0];
                $time = date('m.Y');
                
                $ext = $img->getClientOriginalExtension();
                $new_name = $name.'_'.$time.'.'.$ext;
                // if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg') {
                    $destinationPath  =  public_path('/Images/WorkDocuments');
                    $img->move($destinationPath, $new_name);
                    $Data['document'] = $new_name;
                // }
            }
            ReportsModel::create($Data);
            $message = __('customer.text_reports').' '.__('customer.text_add_success');
        }else{
           
            $UpdateData = array();
            $UpdateData['contract']       = $data['contract'];
            $UpdateData['working_hours']  = $data['working_hours'];
            $UpdateData['working_amount'] = $data['working_amount'];
            $UpdateData['start_date']     = $data['start_date'];
            $UpdateData['end_date']       = $data['end_date'];

            if(@$data['document']){
                $img = $request->file('document');
                $UpdateData["document"] = $img->getClientOriginalName();
                $destinationPath = public_path('/Images/WorkDocuments');
                $img->move($destinationPath, $UpdateData["document"]);
            }    
           
            $UpdateData['customer_id']  = $cust_id;
            ReportsModel::where(['id' => $Report_id])->update($UpdateData);
            $message = __('customer.text_reports').' '.__('customer.text_update_success');
        }
            return redirect('Work-management/Seeker/reports')->withErrors(['success'=> $message]);    
          
    }

    public function delete(Request $request){
      if(@$_GET['id'] != ''){
        $Report_id = @$_GET['id'];
        ReportsModel::where('id', $Report_id)->delete(); 
      }
      return redirect('work-management/reports')->withErrors(['error'=> __('customer.text_reports').' '.__('customer.text_delete')]);
    }

    public function ExportZip(){

        $cust_id      = Session::get('cust_id');
        $get_reports = ReportsModel::where(['customer_id' => $cust_id])->get();

        $files = array(); 
        foreach ($get_reports as  $value) {
            if ($value['document']!='') {
                $files[] = public_path('Images/WorkDocuments/'.$value['document']);
            }
        }

        $zip = new ZipArchive;
        $fileName = 'Reports.zip';
        if ($zip->open(public_path('Images/WorkDocuments/zipfol/'.$fileName), ZipArchive::CREATE) === TRUE) {
          
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }
            
            $zip->close();
        }

        return response()->download(public_path('Images/WorkDocuments/zipfol/'.$fileName))->deleteFileAfterSend(true);

    }


    public function ExportZip_provider(){

        $cust_id      = Session::get('cust_id');

        $jobs_id  = JobsModel::MyJobs();
        if(count($jobs_id)>0){

            $get_reports = ReportsModel::select('reports.*')
                                      ->groupBy("reports.id")
                                      ->leftJoin('customers','customers.id','=','reports.customer_id')
                                      ->whereIn('contract',$jobs_id)->where('send_provider',1)->get();

            $files = array(); 
            foreach ($get_reports as  $value) {
                if ($value['document']!='') {
                    $files[] = public_path('Images/WorkDocuments/'.$value['document']);
                }
            }

        }
        $zip = new ZipArchive;
        $fileName = 'Reports_provider.zip';
        if ($zip->open(public_path('Images/WorkDocuments/zipfol/'.$fileName), ZipArchive::CREATE) === TRUE) {
          
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }
            
            $zip->close();
        }

        return response()->download(public_path('Images/WorkDocuments/zipfol/'.$fileName))->deleteFileAfterSend(true);

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

    public function provider_report(){
        $common                  = array();
        $common['main_menu']     = 'Work Management';
        $common['heading_title'] = __('customer.text_work_managment');

        $cust_id = Session::get('cust_id');
        $user    = CustomersModel::where(['id' => $cust_id])->first(); 


        $jobs_id                  = array();
        $customer_id_published    = array();
        $customer_id_hired        = array();
        $contracts_id             = array();
        $get_reports              = array();
        $get_employees            = array();
        $seekers                  = array();
        $Employees                = array();
        $get_seekers              = array();
        $get_reports_det          = array();


        
        $ContractsModel = ContractsModel::MyContracts();
        $order_by  = "contracts.id"; 
        $sort_type = "desc";
                                            
        //Applicants
        if(@$_GET['tab']){
            $tab = @$_GET['tab'];
            
            ////Applicants Filters
            if($tab == "applicant_tab"){
                if(@$_GET['name']){
                    $search_name =@$_GET['name'];
                    $ContractsModel->where('firstname', 'LIKE','%'.$search_name.'%');
                }
                if(@$_GET['job_no']){
                    $search_name =@$_GET['job_no'];
                    $ContractsModel->where('job_id',$search_name);
                }
                if(@$_GET['profession']){
                    $search_name =@$_GET['profession'];
                    $ContractsModel->where('jobs.profession_name','LIKE','%'.$search_name.'%');
                }
                if(@$_GET['location']){
                    $search_name =@$_GET['location'];
                    $ContractsModel->where('jobs.work_location','LIKE','%'.$search_name.'%');
                }
                if(@$_GET['search_everything']){
                    $search_name = @$_GET['search_everything'];
                    $ContractsModel->where('customers.firstname', 'LIKE','%'.$search_name.'%')->Orwhere('customers.surname', 'LIKE','%'.$search_name.'%')->Orwhere('jobs.title', 'LIKE','%'.$search_name.'%');
                }
            }
            if(@$_GET['sort']){
               $sort      = @$_GET['sort'];
               if($sort == "name"){
                   $sort_type = "asc"; 
                   $order_by  = "firstname"; 
               }
               if($sort == "date"){
                   $order_by  = "contracts.created_at"; 
                   $sort_type = "desc"; 
               }

            }
        }

        $get_seekers = $ContractsModel->where('contracts.status','Ongoing')->orderBy($order_by,$sort_type)->get()->toArray();
    
        
        if($get_seekers){
            foreach ($get_seekers as $key => $value){
                $row = array();
                $row['job_id']             = $value['job_id'];
                $row['id']                 = $value['id'];
                $row['familyname']         = $value['familyname'];
                $row['contract_id']         = $value['contract_id'];
                $row['firstname']          = $value['firstname'];
                $row['surname']            = $value['surname'];
                $row['nick_name']          = $value['nick_name'];
                $row['country']            = $value['country'];
                $row['state']              = $value['state'];
                $row['city']               = $value['city'];
                $row['address']            = $value['address'];
                $row['zip_code']           = $value['zip_code'];
                $row['house_number']       = $value['house_number'];
                $row['phone_number']       = $value['phone_number'];
                $row['email']              = $value['email'];
                $row['salary_expectation'] = $value['salary_expectation'];
                $row['dob']                = $value['dob'];
                $row['gender']             = $value['gender'];
                $row['company_name']       = $value['company_name'];
                $row['profile_image']      = $value['profile_image'];
                $row['fav_candidates']     = '0';

                $get_favourite             = FavouriteCustomerModel::where(['customer_id'=>$value['id'],'provider_id'=>$cust_id])->first();
                if ($get_favourite) {
                    $row['fav_candidates'] = '1';
                }
                $get_experience            = CustomerExperiance::where([ 'customer_id' => $value['id'] ])->first();
                if ($get_experience){
                    $row['working_year']   = $get_experience['working_year'];
                }else{
                    $row['working_year']   = "-";
                }
                $row['adv_no']             = '-';
                $row['working_hour']       = '-';
                $row['work_location']      = '-';
                $row['own_car']            = '-';
                $row['work_location']      = '-';
                $row['date']               = '-';
                $get_advertisment          = AdvertismentModel::where([ 'customer_id' => $value['id'] ])->first();

                if ($get_advertisment) {
                    $row['adv_no']         = $get_advertisment['id'];
                    $row['working_hour']   = $get_advertisment['working_hour'];
                    $row['work_location']  = $get_advertisment['work_location'];
                    $row['own_car']        = $get_advertisment['own_car'];
                    $row['date']           = $get_advertisment['day'].'/'.$get_advertisment['month'].'/'.$get_advertisment['year'];
                }

                $seekers[] = $row;
            }
        }

            
        
        ///Employes
        $get_contract = ContractsModel::MyContracts();
        $order_by  = "contracts.id"; 
        $sort_type = "desc";
        if(@$_GET['tab']){
            $tab = @$_GET['tab'];
            
            ////Applicants Filters
            if($tab == "employees_tab"){
                if(@$_GET['name']){
                    $search_name =@$_GET['name'];
                    $get_contract->where('firstname', 'LIKE','%'.$search_name.'%');
                }
                if(@$_GET['job_no']){
                    $search_name =@$_GET['job_no'];
                    $get_contract->where('job_id',$search_name);
                }
                if(@$_GET['profession']){
                    $search_name =@$_GET['profession'];
                    $get_contract->where('jobs.profession_name','LIKE','%'.$search_name.'%');
                }
                if(@$_GET['location']){
                    $search_name =@$_GET['location'];
                    $get_contract->where('jobs.work_location','LIKE','%'.$search_name.'%');
                }
                if(@$_GET['search_everything']){
                    $search_name = @$_GET['search_everything'];
                    $get_contract->where('firstname', 'LIKE','%'.$search_name.'%');
                }
            }
            if(@$_GET['sort']){
               $sort      = @$_GET['sort'];
               if($sort == "name"){
                   $sort_type = "asc"; 
                   $order_by  = "firstname"; 
               }
               if($sort == "date"){
                   $order_by  = "contracts.created_at"; 
                   $sort_type = "desc"; 
               }

            }
        }
        $Employees     = $get_contract->where('contracts.status','Completed')->orderBy($order_by,$sort_type)->get();
        if($Employees){
            foreach ($Employees as $key => $value2) {
                $employe                       = array();
                $employe['job_id']             = $value2['job_id'];
                $employe['id']                 = $value2['id'];
                $employe['familyname']         = $value2['familyname'];
                $employe['firstname']          = $value2['firstname'];
                $employe['surname']            = $value2['surname'];
                $employe['nick_name']          = $value2['nick_name'];
                $employe['country']            = $value2['country'];
                $employe['state']              = $value2['state'];
                $employe['city']               = $value2['city'];
                $employe['address']            = $value2['address'];
                $employe['zip_code']           = $value2['zip_code'];
                $employe['house_number']       = $value2['house_number'];
                $employe['phone_number']       = $value2['phone_number'];
                $employe['email']              = $value2['email'];
                $employe['salary_expectation'] = $value2['salary_expectation'];
                $employe['dob']                = $value2['dob'];
                $employe['gender']             = $value2['gender'];
                $employe['company_name']       = $value2['company_name'];
                $employe['profile_image']      = $value2['profile_image'];
                $employe['fav_candidates']     = '0';
                $get_favourite             = FavouriteCustomerModel::where(['customer_id'=>$value2['id'],'provider_id'=>$cust_id])->first();
                if ($get_favourite) {
                    $row['fav_candidates'] = '1';
                }
                $get_experience            = CustomerExperiance::where([ 'customer_id' => $value2['id'] ])->first();
                if ($get_experience){
                    $row['working_year']   = $get_experience['working_year'];
                }else{
                    $row['working_year']   = "-";
                }
                $employe['adv_no']             = '-';
                $employe['working_hour']       = '-';
                $employe['work_location']      = '-';
                $employe['own_car']            = '-';
                $employe['work_location']      = '-';
                $employe['date']               = '-';
                $get_advertisment          = AdvertismentModel::where([ 'customer_id' => $value2['id'] ])->first();

                if ($get_advertisment) {
                    $employe['adv_no']         = $get_advertisment['id'];
                    $employe['working_hour']   = $get_advertisment['working_hour'];
                    $employe['work_location']  = $get_advertisment['work_location'];
                    $employe['own_car']        = $get_advertisment['own_car'];
                    $employe['date']           = $get_advertisment['day'].'/'.$get_advertisment['month'].'/'.$get_advertisment['year'];
                }

                $get_employees[] = $employe;
            }
        }
          

        $jobs_id                  = JobsModel::MyJobs();
        if(count($jobs_id)>0){

          //////Reports 
          $order_by  = "id"; 
          $sort_type = "desc";
          $ReportsModel = ReportsModel::select('reports.*')
                                      ->groupBy("reports.id")
                                      ->leftJoin('customers','customers.id','=','reports.customer_id')
                                      ->whereIn('contract',$jobs_id)->where('send_provider',1);
            ////Filter
          if(@$_GET['tab']){
            $tab = @$_GET['tab'];
            
            ////Reports Filters
            if($tab == "Report_tab"){
                if(@$_GET['name']){
                    $search_name =@$_GET['name'];
                    $ReportsModel->where('firstname',$search_name);
                }
                if(@$_GET['month']){
                    $search_name =@$_GET['month'];
                    $ReportsModel->whereMonth('reports.created_at',$search_name);
                }
                if(@$_GET['year']){
                    $search_name =@$_GET['year'];
                    $ReportsModel->whereYear('reports.created_at',$search_name);
                }
            }
            if(@$_GET['sort']){
               $sort      = @$_GET['sort'];
               if($sort == "name"){
                   $sort_type = "asc"; 
                   $order_by  = "firstname"; 
               }
               if($sort == "start"){
                   $order_by  = "reports.created_at"; 
                   $sort_type = "asc"; 
               }
               if($sort == "date"){
                   $order_by  = "reports.created_at"; 
                   $sort_type = "desc"; 
               }

            }
          }
          $get_reports_det = $ReportsModel->orderBy($order_by,$sort_type)->paginate(10);
          foreach($get_reports_det as $key => $reports){
            $reports_array                     = array();
            $reports_array['report_id']        = $reports['id'];
            $reports_array['contract_id']      = $reports['contract'];
            $reports_array['working_hours']    = $reports['working_hours'];
            $reports_array['working_amount']   = $reports['working_amount'];
            $reports_array['start_date']       = $reports['start_date'];
            $reports_array['end_date']         = $reports['end_date'];
            $reports_array['document']         = $reports['document'];
            $reports_array['paid']             = $reports['paid'];
            $reports_array['customer_id']      = $reports['customer_id'];
            $seeker    = CustomersModel::where(['id' => $reports['customer_id']])->first();
            if($seeker){
                $reports_array['seeker_name'] = $seeker['firstname']." ".$seeker['surname'];
            }
            $get_reports[] = $reports_array;
          }

        }
        //////Reports 
        return view('front.WorkManagement.Reports.provider_index',compact('common','user','get_seekers','seekers','get_reports_det','get_reports','get_employees','Employees'));
    }
    


    public function send_report(Request $request){
        $cust_id = Session::get('cust_id');
        $user    = CustomersModel::where(['id' => $cust_id])->first();
        $message = "Something went Wrong";
        $status  = "error";


        // if(isset($request->id)){ 
            if(!empty($request->report_id)){
                foreach($request->report_id as $key =>$value){
                  if($value !=""){
                   $ReportsModel                =  ReportsModel::find($value);
                   $ReportsModel->send_provider =  1;
                   $ReportsModel->update();
                   $message = __('customer.text_snd_report');
                   $status  = "success";
                  }
                }
            }
        // }
        return back()->withErrors([$status => $message]);


    }

    /*public function provider_pay(){
        $common = array();
        $common['main_menu']     = 'Work Management';
        $common['heading_title'] = __('customer.text_billing_info');

        $Report_ID = @$_GET['report_id'];
        $get_single_report = ReportsModel::where('id',$Report_ID)->first();

        $single_report                     = array();
        $single_report['report_id']        = $get_single_report['id'];
        $single_report['contract_id']      = $get_single_report['contract'];
        $single_report['working_hours']    = $get_single_report['working_hours'];
        $single_report['working_amount']   = $get_single_report['working_amount'];
        $single_report['start_date']       = $get_single_report['start_date'];
        $single_report['end_date']         = $get_single_report['end_date'];
        $single_report['document']         = $get_single_report['document'];
        $single_report['customer_id']      = $get_single_report['customer_id'];
        $seeker    = CustomersModel::where(['id' => $get_single_report['customer_id']])->first();
        if($seeker){
            $single_report['seeker_name'] = $seeker['firstname']." ".$seeker['surname'];
        }
        
        return view('front.WorkManagement.Reports.provider_pay',compact('common','single_report'));
    }*/

    public function update_payment(Request $request){
        $cust_id = Session::get('cust_id');

        $data = $request->all();
        $Report_ID = $data['report_id'];
       
        if ($Report_ID) {
            $UpdateData          = array();
            $UpdateData['paid']  = 1;

            ReportsModel::where(['id' => $Report_ID])->update($UpdateData);
            $message = "Payment success";
            return redirect('Work-management/Provider/salaries')->withErrors(['success'=> $message]); 

        }else{
            $message = "Something went wrong";
            return redirect('Work-management/Provider/salaries')->withErrors(['danger'=> $message]);
        }
    }

}



