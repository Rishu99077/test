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
use App\Models\CountryModel;
use App\Models\CustomerExperiance;
use App\Models\AdvertismentContract;
use Illuminate\Support\Facades\View;


require_once __DIR__ . "../../../../../plugin/dompdf/autoload.inc.php";

use Dompdf\Dompdf;


class WorkManagementController extends Controller{

    // PORVIDER REPORTS
    public function provider_reports(){
        $common                  = array();
        $common['main_menu']     = 'Work Management';
        $common['heading_title'] = __('customer.text_work_managment');

        $cust_id = Session::get('cust_id');
        $user    = CustomersModel::where(['id' => $cust_id])->first(); 

        $jobs_id                  = array();
        $get_reports              = array();
        $get_reports_det          = array();
        
        $ContractsModel = ContractsModel::MyContracts();
        $order_by  = "contracts.id"; 
        $sort_type = "desc";
          
        $jobs_id  = JobsModel::MyJobs();
        if(count($jobs_id)>0){

          //////Reports 
          $order_by  = "id"; 
          $sort_type = "desc";
          $ReportsModel = ReportsModel::select('reports.*')
                                      ->groupBy("reports.id")
                                      ->leftJoin('customers','customers.id','=','reports.customer_id')
                                      ->whereIn('contract',$jobs_id)->where('send_provider',1);
            ////Filter
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

            $get_reports_det = $ReportsModel->orderBy($order_by,$sort_type)->paginate(8);

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

                $get_job = ContractsModel::select('contracts.*','contracts.id AS job_id','jobs.*')
                              ->leftJoin('jobs','jobs.id','=','contracts.job_id')
                              ->where(['contracts.id' => $reports['contract'] ])->first();

                if ($get_job) {
                    $reports_array['job_title']   =  $get_job['title'];          
                }



                $get_reports[] = $reports_array;
            }

        }

        //////Reports 
        return view('front.ManagmentProvider.reports',compact('common','user','get_reports_det','get_reports'));
    }

    // PROVIDER APPLICANTS
    public function provider_applicants(){
        $common                  = array();
        $common['main_menu']     = 'Work Management';
        $common['heading_title'] = __('customer.text_work_managment');

        $cust_id = Session::get('cust_id');
        $user    = CustomersModel::where(['id' => $cust_id])->first(); 

  
        $seekers                  = array();
        $get_seekers              = array();


        
        $ContractsModel = ContractsModel::MyContracts();
        $order_by  = "contracts.id"; 
        $sort_type = "desc";
                                            
        //Applicants
            
            
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

        $get_seekers = $ContractsModel->where('contracts.status','Ongoing')->orderBy($order_by,$sort_type)->paginate(6);
    
        
        if($get_seekers){
            foreach ($get_seekers as $key => $value){
                $row = array();
                $row['job_id']             = $value['job_id'];
                $row['id']                 = $value['id'];
                $row['familyname']         = $value['familyname'];
                $row['contract_id']        = $value['contract_id'];
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

                $get_jobs = JobsModel::where(['id' => $value['job_id']])->first();
                if ($get_jobs) {
                    $row['job_title']     = $get_jobs['title'];
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
                $row['driving_license']    = '-';
                $row['work_location']      = '-';
                $row['date']               = '-';
                $get_advertisment          = AdvertismentModel::where([ 'customer_id' => $value['id'] ])->first();

                if ($get_advertisment) {
                    $row['adv_no']         = $get_advertisment['id'];
                    $row['working_hour']   = $get_advertisment['working_hour'];
                    $row['work_location']  = $get_advertisment['work_location'];
                    $row['driving_license']= $get_advertisment['driving_license'];
                    $row['own_car']        = $get_advertisment['own_car'];
                    $row['date']           = $get_advertisment['date'];
                    // $row['date']           = $get_advertisment['day'].'/'.$get_advertisment['month'].'/'.$get_advertisment['year'];
                }

                $seekers[] = $row;
            }
        }

        return view('front.ManagmentProvider.applicants',compact('common','user','get_seekers','seekers'));
    }

    // PROVIDER EMPLOYEES
    public function provider_employees(){
        $common                  = array();
        $common['main_menu']     = 'Work Management';
        $common['heading_title'] = __('customer.text_work_managment');

        $cust_id = Session::get('cust_id');
        $user    = CustomersModel::where(['id' => $cust_id])->first(); 

        $jobs_id                  = array();
        $get_employees            = array();
        $Employees                = array();
        
        ///Employes
        $get_contract = ContractsModel::MyContracts();
        $order_by  = "contracts.id"; 
        $sort_type = "desc";
        
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

        $Employees     = $get_contract->where('contracts.status','Published')->orderBy($order_by,$sort_type)->paginate(6);

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

                $get_jobs = JobsModel::where(['id' => $value2['job_id']])->first();
                if ($get_jobs) {
                    $employe['job_title']     = $get_jobs['title'];
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
                    $employe['date']           = $get_advertisment['date'];
                    // $employe['date']  = $get_advertisment['day'].'/'.$get_advertisment['month'].'/'.$get_advertisment['year'];
                }

                $get_employees[] = $employe;
            }
        }
         
        //////Reports 
        return view('front.ManagmentProvider.employees',compact('common','user','get_employees','Employees'));
    } 

    // PROVIDER SALARIES
    public function provider_salaries(){
        $common                  = array();
        $common['main_menu']     = 'Work Management';
        $common['heading_title'] = __('customer.text_work_managment');

        $cust_id = Session::get('cust_id');
        $user    = CustomersModel::where(['id' => $cust_id])->first(); 

        $jobs_id                  = array();
        $get_reports              = array();
        $get_reports_det          = array();

        $jobs_id  = JobsModel::MyJobs();
        if(count($jobs_id)>0){

          //////Reports 
          $order_by  = "id"; 
          $sort_type = "desc";
          $ReportsModel = ReportsModel::select('reports.*')
                                      ->groupBy("reports.id")
                                      ->leftJoin('customers','customers.id','=','reports.customer_id')
                                      ->whereIn('contract',$jobs_id)->where(['send_provider'=>1,'reports.status'=>'generate']);
            ////Filter
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

        return view('front.ManagmentProvider.salaries',compact('common','user','get_reports_det','get_reports'));
    }


    // Provider Generate Report
    public function generate_report($id=''){
        $common                  = array();
        $common['main_menu']     = 'Work Management';
        $common['heading_title'] = __('customer.text_work_managment');

        $cust_id = Session::get('cust_id');
        $user    = CustomersModel::where(['id' => $cust_id])->first(); 

        $Report_ID = $id;
        $reports = array();

        $get_report_detail = ReportsModel::select('reports.*','reports.id AS report_id','contracts.*','reports.customer_id AS seeker_id','jobs.*')
                              ->leftJoin('contracts','contracts.id','=','reports.contract')
                              ->leftJoin('jobs','jobs.id','=','contracts.job_id')
                              ->where(['reports.id' => $Report_ID ])->first()->toArray();
                           

        if ($get_report_detail) {
            $reports['report_id']       = $get_report_detail['report_id'];
            $reports['contract']        = $get_report_detail['contract'];
            $reports['working_hours']   = $get_report_detail['working_hours'];
            $reports['working_amount']  = $get_report_detail['working_amount'];
            $reports['start_date']      = $get_report_detail['start_date'];
            $reports['end_date']        = $get_report_detail['end_date'];
            $reports['document']        = $get_report_detail['document'];
            $reports['seeker_id']       = $get_report_detail['seeker_id'];
            $reports['send_provider']   = $get_report_detail['send_provider'];
            $reports['paid']            = $get_report_detail['paid'];
            $reports['created_at']      = $get_report_detail['created_at'];
            $reports['job_id']          = $get_report_detail['job_id'];
            $reports['contract_status'] = $get_report_detail['status'];
            $reports['total_amount']    = $reports['working_hours']*$get_report_detail['salary'];
            $reports['total_inst']      = $reports['total_amount']*70/100;


            $get_job = JobsModel::where('id',$get_report_detail['job_id'])->first();
            if ($get_job) {
                $reports['job_title']   = $get_job['title'];
            }

            $get_customer = CustomersModel::where('id',$get_report_detail['seeker_id'])->first();
            if ($get_customer) {
                $reports['seeker_name']   = $get_customer['firstname'];
            }
        }

        //////Reports 
        return view('front.ManagmentProvider.generate_report',compact('common','user','reports'));
    }
    
    // Provider chenge report status
    public function change_report_status(Request $request){
          
        $Report_ID  = $request->Report_ID;
        $Datastatus = $request->Datastatus;
      
        if ($Report_ID!='') {

          $UpdateData = array();
          $UpdateData['status'] = $Datastatus;

          ReportsModel::where(['id' => $Report_ID])->update($UpdateData);

          // return back()->withErrors(['success' => 'status update success']);
          // return redirect('Work-management/Provider/reports')->withErrors(['success'=> __('status update success')])->withInput();   
        }
    }

    // Provider Billing Info
    public function billing_info($id=''){
        $common                  = array();
        $common['main_menu']     = 'Work Management';
        $common['heading_title'] = __('customer.text_work_managment');

        $cust_id = Session::get('cust_id');
        $user    = CustomersModel::where(['id' => $cust_id])->first(); 

        $Report_ID = $id;
        $reports = array();

        $get_report_detail = ReportsModel::select('reports.*','reports.id AS report_id','contracts.*','reports.customer_id AS seeker_id','jobs.*')
                              ->leftJoin('contracts','contracts.id','=','reports.contract')
                              ->leftJoin('jobs','jobs.id','=','contracts.job_id')
                              ->where(['reports.id' => $Report_ID ])->first()->toArray();
                   

        if ($get_report_detail) {
            $reports['report_id']       = $get_report_detail['report_id'];
            $reports['contract']        = $get_report_detail['contract'];
            $reports['working_hours']   = $get_report_detail['working_hours'];
            $reports['working_amount']  = $get_report_detail['working_amount'];
            $reports['start_date']      = $get_report_detail['start_date'];
            $reports['end_date']        = $get_report_detail['end_date'];
            $reports['document']        = $get_report_detail['document'];
            $reports['seeker_id']       = $get_report_detail['seeker_id'];
            $reports['send_provider']   = $get_report_detail['send_provider'];
            $reports['paid']            = $get_report_detail['paid'];
            $reports['created_at']      = $get_report_detail['created_at'];
            $reports['job_id']          = $get_report_detail['job_id'];
            $reports['contract_status'] = $get_report_detail['status'];
            $reports['total_amount']    = $reports['working_hours']*$get_report_detail['salary'];
            $reports['total_inst']      = $reports['total_amount']*70/100;
            
            $get_job = JobsModel::where('id',$get_report_detail['job_id'])->first();
            if ($get_job) {
                $reports['job_title']   = $get_job['title'];
            }

            $get_customer = CustomersModel::where('id',$get_report_detail['seeker_id'])->first();
            if ($get_customer) {
                $reports['seeker_name']   = $get_customer['firstname'].' '.$get_customer['familyname'];
            }



        }
       


        //////Reports 
        return view('front.ManagmentProvider.billing_info',compact('common','user','reports'));
    }

    // -------------------------------------------------------------------------------


    // SEEKER REPORTS
    public function seeker_reports(){
    	$common = array();
        $common['main_menu']     = 'Work Management';
        $common['heading_title'] = __('customer.text_work_managment');

       
        $sort_type    ="desc";
        $order_by     ="id";

        $cust_id      = Session::get('cust_id');
        $user         = CustomersModel::where(['id' => $cust_id])->first();

        // Reports ----------------
        $ReportsModel = ReportsModel::where(['customer_id' => $cust_id]);
       
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
           if($sort == "contract"){
               $order_by  = "contract"; 
               $sort_type = "asc"; 
           }
           if($sort == "date"){
               $order_by  = "created_at"; 
               $sort_type = "desc"; 
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
      
        return view('front.ManagmentSeeker.reports',compact('common','user','get_reports','reports'));
    }


    public function generate_report_pdf(){

        // return view('report_pdf');

        $dompdf = new Dompdf();

        $viewhtml = View::make('pdf.report_pdf')->render();
        // return $viewhtml;
        // die();
        $date = date('d-m-Y');

        $dompdf->loadHtml($viewhtml);
        $options = $dompdf->getOptions();
        $options->set(array('isRemoteEnabled' => true));
        $options->set('isPhpEnabled', true);
        $dompdf->setOptions($options);
        $dompdf->set_paper('A4', 'portrait');
        $dompdf->render();
        $pdf = $dompdf->output();
        $dompdf->stream("Report-".$date);

    }


    // public function generate_excel(){
    //    $file_name = 'employees_'.date('Y_m_d_H_i_s').'.csv';
    //    return Excel::download(new CustomersModel, $file_name);
    // }


    // SEEKER ADVERTISMENT
    public function seeker_advertisment(){
    	$common = array();
        $common['main_menu']     = 'Work Management';
        $common['heading_title'] = __('customer.text_work_managment');

       
        $sort_type    ="desc";
        $order_by     ="id";
        $cust_id      = Session::get('cust_id');
        $user         = CustomersModel::where(['id' => $cust_id])->first();

        // Advertisment ----------------

        $AdvertismentModel = AdvertismentModel::where(['customer_id' => $cust_id]);
        $sort_type    = "desc";
        $order_by     = "id";
        
        ///Advertisiment Filter
        
            
        if(@$_GET['search_everything']){
            $search_name =  @$_GET['search_everything'];
            $AdvertismentModel = $AdvertismentModel->where('work_location',$search_name);
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

        // whereBetween('age', [$ageFrom, $ageTo]);
        // if(@$_GET['salary_from'] || @$_GET['salary_to']){
        //     $search_from =  @$_GET['salary_from'];
        //     $search_to =  @$_GET['salary_to'];

        //     $AdvertismentModel->whereBetween('hours_salary', [$search_from, $search_to]); 
        // }



        if(@$_GET['salary_from']){
            $search_from =  @$_GET['salary_from'];
            $AdvertismentModel->where('hours_salary','>=',$search_from); 
        }
        if(@$_GET['salary_to']){
            $search_to =  @$_GET['salary_to'];
            $AdvertismentModel->where('hours_salary','<=',$search_to);
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
                $row['start_date']             = $value['date'];
                $row['driving_license']        = $value['driving_license'];
                $row['own_car']                = $value['own_car'];
                $row['description']            = $value['description'];
                $row['adv_status']             = $value['status'];
                $row['adv_contract_count']     = AdvertismentContract::where('advertisment_id',$value['id'])->count();
                $newtimeago = $this->newtimeago($value['created_at']); 
                $row['datetime'] = $newtimeago;
              
                $advs[] = $row;
            }   
        }

        return view('front.ManagmentSeeker.advertisment',compact('common','user','get_advertisment','advs'));
    }

    public function edit_advertisment($adv_id=''){

        $common = array();
        $common['main_menu']     = 'Work Management';
        $common['heading_title'] = __('customer.text_work_managment');

        $user = array();
        $cust_id = Session::get('cust_id');
        $user = CustomersModel::where(['id' => $cust_id])->first();

        $get_advertisment = array();
        $get_advertisment = AdvertismentModel::where('id',$adv_id)->first();
       
        $CountryModel     = CountryModel::get();

        return view('front.ManagmentSeeker.edit_advertisment',compact('common','user','get_advertisment','CountryModel'));

    }

    // SEEKER ACTUAL CONTARCT
    public function seeker_actual_contract(){
    	$common = array();
        $common['main_menu']     = 'Work Management';
        $common['heading_title'] = __('customer.text_work_managment');

       
        $sort_type    ="desc";
        $order_by     ="id";
        $cust_id      = Session::get('cust_id');
        $user         = CustomersModel::where(['id' => $cust_id])->first();

        ///// Actual Contract
        $ContractsModel  = ContractsModel::select('contracts.*')
                            ->leftJoin("jobs", "jobs.id", "=", "contracts.job_id")
                            ->where('contracts.customer_id',$cust_id)
                            ->where('contracts.status','Published');

        ///Actual Contract Filter
        if(@$_GET['search_everything']){
            $search_name =  @$_GET['search_everything'];
            $ContractsModel = $ContractsModel->where('contracts.status',$search_name);
        }
        
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
            $search_from =  @$_GET['salary_from'];
            $ContractsModel->where('jobs.salary','>=',$search_from); 
        }
        if(@$_GET['salary_to']){
            $search_to =  @$_GET['salary_to'];
            $ContractsModel->where('jobs.salary','<=',$search_to);
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

        return view('front.ManagmentSeeker.actual_contract',compact('common','user','get_contracts','contracts'));
    }

    // SEEKER CONTRACT TO SIGN
    public function seeker_contract_to_sign(){
    	$common = array();
        $common['main_menu']     = 'Work Management';
        $common['heading_title'] = __('customer.text_work_managment');

       
        $sort_type    ="desc";
        $order_by     ="id";
        $cust_id      = Session::get('cust_id');
        $user         = CustomersModel::where(['id' => $cust_id])->first();


        ////  Contract to sign

        $ContractsToSign  = ContractsModel::select('contracts.*')
                            ->leftJoin("jobs", "jobs.id", "=", "contracts.job_id")
                            ->where('contracts.customer_id',$cust_id)
                            ->where('contracts.status','Ongoing');

        
        if(@$_GET['search_everything']){
            $search_name =  @$_GET['search_everything'];
            $ContractsToSign = $ContractsToSign->where('contracts.customer_id',$search_name);
        }
        
        if(@$_GET['offer_no']){
            $search_name =  @$_GET['offer_no'];
            $ContractsToSign->where('contracts.id',$search_name);
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
      
        return view('front.ManagmentSeeker.contract_to_sign',compact('common','user','get_contracts_to_sign','contracts_to_sign'));
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



