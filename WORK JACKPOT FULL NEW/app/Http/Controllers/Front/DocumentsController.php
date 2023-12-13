<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Models\UserModel;
use App\Models\CustomersModel;
use App\Models\LanguagesModel;
use App\Models\JobsModel;
use App\Models\ContractsModel;
use App\Models\OtherDocuments;
use App\Models\ReportsModel;
use App\Models\JobsFavouriteModel;
use App\Models\JobRequirementsModel;
use App\Models\CityModel;
use App\Models\CountryModel;
use Illuminate\Support\Facades\View;

require_once __DIR__ . "../../../../../plugin/dompdf/autoload.inc.php";

use Dompdf\Dompdf;

class DocumentsController extends Controller{
    // Seeker----------------------------not in use
    public function seeker_documents(Request $request){
        $tab                     = "";
        $get_contracts           = array();
        $contracts               = array();
        $common                  = array();
        $common['main_menu']     = 'Documents';
        $common['heading_title'] = __('customer.text_documents');
        $sort_type               = "desc";
        $order_by                = "id";
        
      	$cust_id = Session::get('cust_id');
      	$user    = CustomersModel::where(['id' => $cust_id])->first();


        //// Contract
        // $ContractsModel  = ContractsModel::select('contracts.*')
        //                     ->leftJoin("jobs", "jobs.id", "=", "contracts.job_id")
        //                     ->where('contracts.customer_id',$cust_id);

        $ContractsModel = ContractsModel::select('contracts.*','customers.firstname','jobs.title as contract_title')
                                        ->groupBy("contracts.id")
                                        ->leftJoin('jobs','jobs.id','=','contracts.job_id')
                                        ->leftJoin('customers','customers.id','=','jobs.customer_id')
                                        ->where('contracts.customer_id',$cust_id);                    
        /////Filter Contract
        if(@$_GET['tab']){
            $tab = @$_GET['tab'];
        }   
        if($tab == "contract_tab"){
            if(@$_GET['job_title']){
                $search_name =  @$_GET['job_title'];
                $ContractsModel->where('jobs.title','LIKE','%'.$search_name.'%');
            }
            if(@$_GET['contract_no']){
                $search_name =  @$_GET['contract_no'];
                $ContractsModel->where('contracts.id',$search_name);
            }
            if(@$_GET['location']){
                $search_name =  @$_GET['location'];
                $ContractsModel->where('jobs.work_location','LIKE','%'.$search_name.'%');
            }
            if(@$_GET['search_everything']){
                $search_name = @$_GET['search_everything'];
                $ContractsModel->where('jobs.title', 'LIKE','%'.$search_name.'%');
            }

            if(@$_GET['sort']){
               $sort      = @$_GET['sort'];
               if($sort == "name"){
                   $sort_type = "asc"; 
                   $order_by  = 'jobs.title'; 
               }
               if($sort == "date"){
                   $order_by  = "created_at"; 
                   $sort_type = "desc"; 
               }

            } 
        }   
        $get_contracts = $ContractsModel->orderBy($order_by,$sort_type)->paginate(8);
       
        // echo $ContractsModel->toSql();
        // die();
        if ($get_contracts) {
          foreach($get_contracts as $key => $value) {
            
                $contrct                    = array();
                $contrct['id']              = $value['id'];
                $contrct['job_id']          = $value['job_id'];
                $contrct['title']           = $value['contract_title'];
                $contrct['start_date']      = $value['created_at'];
                $contrct['document'] = '';
                $get_other_documents = OtherDocuments::where(['contract_id'=>$contrct['id']])->first();
                if ($get_other_documents) {
                  $contrct['document']  = $get_other_documents['document'];
                }

                $contracts[] = $contrct;
           
          }
        }
       
        ////Salaries 
        $ReportsModel  = ReportsModel::select('reports.*')
                            ->leftJoin("jobs", "jobs.id", "=", "reports.contract")
                            ->where('reports.customer_id',$cust_id);

        if(@$_GET['tab']){
            $tab = @$_GET['tab'];
        }
        $sort_type               ="desc";
        $order_by                ="id";

        if($tab == "salary_tab"){
            if(@$_GET['search_everything']){
                $search_name =  @$_GET['search_everything'];
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

        $get_reports = $ReportsModel->orderBy($order_by,$sort_type)->paginate(8);
        if ($get_reports) {
            $reports     = array();
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

        ////OtherDocuments
        $GetOtherDocuments = OtherDocuments::select('other_documents.*')
                                            ->leftJoin('contracts','contracts.id','=','other_documents.contract_id')
                                            ->leftJoin('jobs','jobs.id','=','contracts.job_id')
                                            ->where(function ($query) use ($cust_id){ 
                                                    $query->where('customer_id_from', '=', $cust_id)
                                                      ->orWhere('customer_id_to', '=', $cust_id);
                                                });
        $order_by  = "id"; 
        $sort_type = "desc";

        ////Other Document Filters
        if($tab == "other_doc"){
            if(@$_GET['job_title']){
                $search_name =  @$_GET['job_title'];
                $GetOtherDocuments->where('jobs.title','LIKE','%'.$search_name.'%');
            }
            if(@$_GET['contract_no']){
                $search_name =  @$_GET['contract_no'];
                $GetOtherDocuments->where('other_documents.contract_id',$search_name);
            }
            if(@$_GET['location']){
                $search_name =  @$_GET['location'];
                $GetOtherDocuments->where('jobs.work_location','LIKE','%'.$search_name.'%');
            }
            if(@$_GET['search_everything']){
                $search_name = @$_GET['search_everything'];
                $GetOtherDocuments->where('jobs.title', 'LIKE','%'.$search_name.'%');
            }


            if(@$_GET['sort']){
               $sort      = @$_GET['sort'];
               if($sort == "name"){
                   $sort_type = "asc"; 
                   $order_by  = "other_documents.title"; 
               }
               if($sort == "date"){
                   $order_by  = "other_documents.date"; 
                   $sort_type = "desc"; 
               }

            } 
        }
       
        $OtherDocuments = $GetOtherDocuments->orderBy($order_by,$sort_type)->paginate(8);
       
        return view('front.Documents.seeker_documents',compact('user','common','get_contracts','contracts','OtherDocuments','reports'));
    }


    // Contracts Seeker
    public function seeker_documents_contracts(Request $request){
       
        $common                  = array();
        $common['main_menu']     = 'Documents';
        $common['heading_title'] = __('customer.text_documents');

        $contracts               = array();

        $sort_type               = "desc";
        $order_by                = "id";
        
        $cust_id = Session::get('cust_id');
        $user    = CustomersModel::where(['id' => $cust_id])->first();

        $ContractsModel = ContractsModel::select('contracts.*','customers.firstname','jobs.title as contract_title')
                                        ->groupBy("contracts.id")
                                        ->leftJoin('jobs','jobs.id','=','contracts.job_id')
                                        ->leftJoin('customers','customers.id','=','jobs.customer_id')
                                        ->where('contracts.customer_id',$cust_id);                    
        /////Filter Contract
        if(@$_GET['job_title']){
            $search_name =  @$_GET['job_title'];
            $ContractsModel->where('jobs.title','LIKE','%'.$search_name.'%');
        }
        if(@$_GET['contract_no']){
            $search_name =  @$_GET['contract_no'];
            $ContractsModel->where('contracts.id',$search_name);
        }
        if(@$_GET['location']){
            $search_name =  @$_GET['location'];
            $ContractsModel->where('jobs.work_location','LIKE','%'.$search_name.'%');
        }
        if(@$_GET['search_everything']){
            $search_name = @$_GET['search_everything'];
            $ContractsModel->where('jobs.title', 'LIKE','%'.$search_name.'%');
        }

        if(@$_GET['sort']){
           $sort      = @$_GET['sort'];
           if($sort == "name"){
               $sort_type = "asc"; 
               $order_by  = 'jobs.title'; 
           }
           if($sort == "date"){
               $order_by  = "created_at"; 
               $sort_type = "desc"; 
           }

        } 
        $get_contracts = $ContractsModel->orderBy($order_by,$sort_type)->paginate(8);
       
        if ($get_contracts) {
          foreach($get_contracts as $key => $value) {
            
                $contrct                    = array();
                $contrct['id']              = $value['id'];
                $contrct['job_id']          = $value['job_id'];
                $contrct['title']           = $value['contract_title'];
                $contrct['start_date']      = $value['created_at'];
                $contrct['document'] = '';
                $get_other_documents = OtherDocuments::where(['contract_id'=>$contrct['id']])->first();
                if ($get_other_documents) {
                  $contrct['document']  = $get_other_documents['document'];
                }

                $contracts[] = $contrct;
           
          }
        }
    
        return view('front.DocumentsSeeker.contracts',compact('user','common','get_contracts','contracts'));
    }

    // Salaries Seeker
    public function seeker_documents_salaries(Request $request){
        
        $common                  = array();
        $common['main_menu']     = 'Documents';
        $common['heading_title'] = __('customer.text_documents');

        
        $cust_id = Session::get('cust_id');
        $user    = CustomersModel::where(['id' => $cust_id])->first();

        ////Salaries 
        $ReportsModel  = ReportsModel::select('reports.*')
                            ->leftJoin("jobs", "jobs.id", "=", "reports.contract")
                            ->where('reports.customer_id',$cust_id);

        $sort_type               ="desc";
        $order_by                ="id";
        
        if(@$_GET['search_everything']){
            $search_name =  @$_GET['search_everything'];
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
        
        $get_reports = $ReportsModel->orderBy($order_by,$sort_type)->paginate(8);
        if ($get_reports) {
            $reports     = array();
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
       
        return view('front.DocumentsSeeker.salaries',compact('user','common','get_reports','reports'));
    }


    //// Reports Seeker
    public function seeker_documents_reports(Request $request){
        
        $common                  = array();
        $common['main_menu']     = 'Documents';
        $common['heading_title'] = __('customer.text_documents');

        
        $cust_id = Session::get('cust_id');
        $user    = CustomersModel::where(['id' => $cust_id])->first();

        ////Salaries 
        $ReportsModel  = ReportsModel::select('reports.*')
                            ->leftJoin("jobs", "jobs.id", "=", "reports.contract")
                            ->where('reports.customer_id',$cust_id);

        $sort_type               ="desc";
        $order_by                ="id";
        
        if(@$_GET['search_everything']){
            $search_name =  @$_GET['search_everything'];
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
        
        $get_reports = $ReportsModel->orderBy($order_by,$sort_type)->paginate(8);
        if ($get_reports) {
            $reports     = array();
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
       
        return view('front.DocumentsSeeker.reports',compact('user','common','get_reports','reports'));
    }

    ///Other Documents
    public function seeker_documents_other_documents(Request $request){
        
        $common                  = array();
        $common['main_menu']     = 'Documents';
        $common['heading_title'] = __('customer.text_documents');
        
        $cust_id = Session::get('cust_id');
        $user    = CustomersModel::where(['id' => $cust_id])->first();

        ////OtherDocuments
        $GetOtherDocuments = OtherDocuments::select('other_documents.*')
                                            ->leftJoin('contracts','contracts.id','=','other_documents.contract_id')
                                            ->leftJoin('jobs','jobs.id','=','contracts.job_id')
                                            ->where(function ($query) use ($cust_id){ 
                                                    $query->where('customer_id_from', '=', $cust_id)
                                                      ->orWhere('customer_id_to', '=', $cust_id);
                                                });
        $order_by  = "id"; 
        $sort_type = "desc";

        ////Other Document Filters
        if(@$_GET['job_title']){
            $search_name =  @$_GET['job_title'];
            $GetOtherDocuments->where('jobs.title','LIKE','%'.$search_name.'%');
        }

        if(@$_GET['contract_no']){
            $search_name =  @$_GET['contract_no'];
            $GetOtherDocuments->where('other_documents.contract_id',$search_name);
        }

        if(@$_GET['location']){
            $search_name =  @$_GET['location'];
            $GetOtherDocuments->where('jobs.work_location','LIKE','%'.$search_name.'%');
        }

        if(@$_GET['search_everything']){
            $search_name = @$_GET['search_everything'];
            $GetOtherDocuments->where('jobs.title', 'LIKE','%'.$search_name.'%');
        }

        if(@$_GET['month']){
            $search_name =@$_GET['month'];
            $GetOtherDocuments->whereMonth('other_documents.created_at',$search_name);
        }
        
        if(@$_GET['year']){
            $search_name =@$_GET['year'];
            $GetOtherDocuments->whereYear('other_documents.created_at',$search_name);
        }



        if(@$_GET['sort']){
           $sort      = @$_GET['sort'];
           if($sort == "name"){
               $sort_type = "asc"; 
               $order_by  = "other_documents.title"; 
           }
           if($sort == "date"){
               $order_by  = "other_documents.date"; 
               $sort_type = "desc"; 
           }
        } 
       
        $OtherDocuments = $GetOtherDocuments->orderBy($order_by,$sort_type)->paginate(8);
       
        return view('front.DocumentsSeeker.other_documents',compact('user','common','OtherDocuments'));
    }

    public function contract_details(){
    
        $common = array();
        $common['main_menu'] = 'Documents';
        $common['heading_title'] = __('customer.text_documents');

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
          $ContractsModel->whereIn('status', ['Pending','Published','Reject','Completed']);
          $get_contract = $ContractsModel->first();
          
          if ($get_contract) {
            $job_details['contract'] = '1';
          }

          $job_details['datetime'] ='';


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
        return view('front.Documents.contract_details',compact('common','user','job_details'));
    }


    // PRovider ------------------------
    public function provider_documents(Request $request){

        $common = array();
        $common['main_menu']     = 'Documents';
        $common['heading_title'] = __('customer.text_documents');
        $tab  = "";
        
        $cust_id = Session::get('cust_id');
        $user    = CustomersModel::where(['id' => $cust_id])->first();

        $jobs_id = array();
        $JobsModel         = JobsModel::where('customer_id',$cust_id)->get();
        foreach($JobsModel as $key => $job){
            $jobs_id[] = $job['id'];
        }


        if(@$_GET['tab']){
            $tab = @$_GET['tab'];
        }

        $get_contracts = array();
        $get_contracts_details = array();
        if(count($jobs_id)>0){
            $order_by  = "contracts.id"; 
            $sort_type = "desc";
            

            ////Applicants
            $ContractsModel = ContractsModel::select('contracts.*','jobs.title','jobs.start_date')
                                            ->groupBy("contracts.id")
                                            ->leftJoin('jobs','jobs.id','=','contracts.job_id')
                                            ->whereIn('job_id',$jobs_id);

            ////Applicants Filters
            if($tab == "contract_tab"){
                if(@$_GET['job_title']){
                    $search_name =@$_GET['job_title'];
                    $ContractsModel->where('title', 'LIKE','%'.$search_name.'%');
                }
                if(@$_GET['contract_no']){
                    $search_name =@$_GET['contract_no'];
                    $ContractsModel->where('contracts.id',$search_name);
                }
                if(@$_GET['worker']){
                    $search_name =@$_GET['worker'];
                    $ContractsModel->where('jobs.profession_name','LIKE','%'.$search_name.'%');
                }
                if(@$_GET['location']){
                    $search_name =@$_GET['location'];
                    $ContractsModel->where('jobs.work_location','LIKE','%'.$search_name.'%');
                }
                
                if(@$_GET['search_everything']){
                    $search = @$_GET['search_everything'];
                    $ContractsModel->where('jobs.title', 'LIKE','%'.$search.'%')->Orwhere('jobs.profession_name', 'LIKE','%'.$search.'%');
                }

                if(@$_GET['sort']){
                    $sort      = @$_GET['sort'];

                    if($sort == "name"){
                       $sort_type = "asc"; 
                       $order_by  = "jobs.title"; 
                    }
                   if($sort == "date"){
                       $order_by  = "contracts.created_at"; 
                       $sort_type = "desc"; 
                   }

                }
            }
            
            $get_contracts_details  = $ContractsModel->groupBy('contracts.job_id')->where('contracts.status','Published')->orderBy( $order_by, $sort_type)->paginate(8);

            $get_contracts = array();
            if (!empty($get_contracts_details)) {
                foreach ($get_contracts_details as $key => $value_con) {
                    
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
                    $get_contracts[] = $contract;

                }
            }
           

        }


        ////OtherDocuments
        $GetOtherDocuments = OtherDocuments::select('other_documents.*')
                                            ->leftJoin('contracts','contracts.id','=','other_documents.contract_id')
                                            ->leftJoin('jobs','jobs.id','=','contracts.job_id')
                                            ->where(function ($query) use ($cust_id){ 
                                                    $query->where('customer_id_from', '=', $cust_id)
                                                      ->orWhere('customer_id_to', '=', $cust_id);
                                                });
        $order_by  = "id"; 
        $sort_type = "desc";

        ////Other Document Filters
        if($tab == "other_documents_tab"){
            if(@$_GET['job_title']){
                $search_name =@$_GET['job_title'];
                $GetOtherDocuments->where('jobs.title', 'LIKE','%'.$search_name.'%');
            }
            if(@$_GET['contract_no']){
                $search_name =@$_GET['contract_no'];
                $GetOtherDocuments->where('other_documents.contract_id',$search_name);
            }
            if(@$_GET['worker']){
                $search_name =@$_GET['worker'];
                $GetOtherDocuments->where('jobs.profession_name','LIKE','%'.$search_name.'%');
            }
            if(@$_GET['location']){
                $search_name =@$_GET['location'];
                $GetOtherDocuments->where('jobs.work_location','LIKE','%'.$search_name.'%');
            }

            if(@$_GET['search_everything']){
                $search = @$_GET['search_everything'];
                $GetOtherDocuments->where('jobs.title', 'LIKE','%'.$search.'%')->Orwhere('other_documents.contract_id', 'LIKE','%'.$search.'%');
            }
        
            if(@$_GET['sort']){
               $sort      = @$_GET['sort'];
               if($sort == "name"){
                   $sort_type = "asc"; 
               }
               if($sort == "date"){
                   $sort_type = "desc"; 
               }

            }
        }
       
        $OtherDocuments = $GetOtherDocuments->orderBy($order_by,$sort_type)->get();


        // Reports Unpaid (Bills)
        $get_reports_unpaid = array();
        $ReportsModel = ReportsModel::select('reports.*')
                                      ->groupBy("reports.id")
                                      ->leftJoin('customers','customers.id','=','reports.customer_id')
                                      ->whereIn('contract',$jobs_id)->where(['customer_id'=> $cust_id, 'reports.paid' => 0]);

        if(@$_GET['tab']){
            $tab = @$_GET['tab'];
            
            ////Reports Filters
            if($tab == "bills_tab"){
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
            }
        }
        $ReportsModel = $ReportsModel->orderBy($order_by,$sort_type)->paginate(10);
        foreach($ReportsModel as $key => $reports){
          $reports_array                     = array();
          $reports_array['report_id']        = $reports['id'];
          $reports_array['contract_id']      = $reports['contract'];
          $reports_array['working_hours']    = $reports['working_hours'];
          $reports_array['working_amount']   = $reports['working_amount'];
          $reports_array['start_date']       = $reports['start_date'];
          $reports_array['end_date']         = $reports['end_date'];
          $reports_array['document']         = $reports['document'];
          $reports_array['customer_id']      = $reports['customer_id'];
          $seeker    = CustomersModel::where(['id' => $reports['customer_id']])->first();
          if($seeker){
              $reports_array['seeker_name'] = $seeker['firstname']." ".$seeker['surname'];
          }
          $get_jobs = JobsModel::where(['id' => $reports['contract']])->first();
          if ($get_jobs) {
             $reports_array['job'] = $get_jobs['title'];
          }

          $get_reports_unpaid[] = $reports_array;
        }


        
         // Reports paid (Payed Bills)
        $get_reports_paid = array();
        $ReportsModel = ReportsModel::select('reports.*')
                                      ->groupBy("reports.id")
                                      ->leftJoin('customers','customers.id','=','reports.customer_id')
                                      ->whereIn('contract',$jobs_id)->where(['customer_id'=> $cust_id, 'reports.paid' => 1]);

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
          $ReportsModel = $ReportsModel->orderBy($order_by,$sort_type)->paginate(10);
          foreach($ReportsModel as $key => $reports){
            $reports_array                     = array();
            $reports_array['report_id']        = $reports['id'];
            $reports_array['contract_id']      = $reports['contract'];
            $reports_array['working_hours']    = $reports['working_hours'];
            $reports_array['working_amount']   = $reports['working_amount'];
            $reports_array['start_date']       = $reports['start_date'];
            $reports_array['end_date']         = $reports['end_date'];
            $reports_array['document']         = $reports['document'];
            $reports_array['customer_id']      = $reports['customer_id'];
            $seeker    = CustomersModel::where(['id' => $reports['customer_id']])->first();
            if($seeker){
                $reports_array['seeker_name'] = $seeker['firstname']." ".$seeker['surname'];
            }
            $get_jobs = JobsModel::where(['id' => $reports['contract']])->first();
            if ($get_jobs) {
               $reports_array['job'] = $get_jobs['title'];
            }

            $get_reports_paid[] = $reports_array;
          }  
                        
       
        return view('front.Documents.provider_documents',compact('user','common','get_contracts','get_contracts_details','OtherDocuments','get_reports_paid','get_reports_unpaid'));
    }

    // CONTRACTS PROVIDER-------
    public function provider_documents_contracts(Request $request){

        $common = array();
        $common['main_menu']     = 'Documents';
        $common['heading_title'] = __('customer.text_documents');
          
        $sort_type               = "desc";
        $order_by                = "id";  

        $cust_id = Session::get('cust_id');
        $user    = CustomersModel::where(['id' => $cust_id])->first();

        $jobs_id = array();
        $JobsModel         = JobsModel::where('customer_id',$cust_id)->get();
        foreach($JobsModel as $key => $job){
            $jobs_id[] = $job['id'];
        }

        $get_contracts = array();
        $get_contracts_details = array();
        if(count($jobs_id)>0){
            $order_by  = "contracts.id"; 
            $sort_type = "desc";
          
            $ContractsModel = ContractsModel::select('contracts.*','jobs.title','jobs.start_date')
                                            ->groupBy("contracts.id")
                                            ->leftJoin('jobs','jobs.id','=','contracts.job_id')
                                            ->whereIn('job_id',$jobs_id);
            
            if(@$_GET['job_title']){
                $search_name =@$_GET['job_title'];
                $ContractsModel->where('title', 'LIKE','%'.$search_name.'%');
            }

            if(@$_GET['contract_no']){
                $search_name =@$_GET['contract_no'];
                $ContractsModel->where('contracts.id',$search_name);
            }

            if(@$_GET['worker']){
                $search_name =@$_GET['worker'];
                $ContractsModel->where('jobs.profession_name','LIKE','%'.$search_name.'%');
            }

            if(@$_GET['location']){
                $search_name =@$_GET['location'];
                $ContractsModel->where('jobs.work_location','LIKE','%'.$search_name.'%');
            }
            
            if(@$_GET['search_everything']){
                $search = @$_GET['search_everything'];
                $ContractsModel->where('jobs.title', 'LIKE','%'.$search.'%')->Orwhere('jobs.profession_name', 'LIKE','%'.$search.'%');
            }

            if(@$_GET['sort']){
                $sort      = @$_GET['sort'];

                if($sort == "name"){
                   $sort_type = "asc"; 
                   $order_by  = "jobs.title"; 
                }
               if($sort == "date"){
                   $order_by  = "contracts.created_at"; 
                   $sort_type = "desc"; 
               }

            }
            
            $get_contracts_details  = $ContractsModel->groupBy('contracts.job_id')->where('contracts.status','Published')->orderBy( $order_by, $sort_type)->paginate(8);



            $get_contracts = array();
            if (!empty($get_contracts_details)) {
                foreach ($get_contracts_details as $key => $value_con) {
                    
                    $contract = array();
                    $contract['id'] = $value_con['id'];
                    $contract['job_id'] = $value_con['job_id'];
                    $contract['start_date'] = $value_con['created_at'];

                    $get_customer_detail = CustomersModel::where(['id'=>$value_con['customer_id']])->first();
                    if ($get_customer_detail) {
                      $contract['customer_name'] = $get_customer_detail['firstname'];
                    }
                    

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
                    $get_contracts[] = $contract;

                }

            }
    
        }            
       
        return view('front.DocumentsProvider.contracts',compact('user','common','get_contracts','get_contracts_details'));
    }
    
    // BILLSSS PROVIDER--------
    public function provider_documents_bills(Request $request){

        $common = array();
        $common['main_menu']     = 'Documents';
        $common['heading_title'] = __('customer.text_documents');
        
        $sort_type               = "desc";
        $order_by                = "id";
        
        $cust_id = Session::get('cust_id');
        $user    = CustomersModel::where(['id' => $cust_id])->first();

        $jobs_id = array();
        $JobsModel         = JobsModel::where('customer_id',$cust_id)->get();
        foreach($JobsModel as $key => $job){
            $jobs_id[] = $job['id'];
        }
        
        // Reports Unpaid (Bills)
        $get_reports_unpaid = array();
        $ReportsModel = ReportsModel::select('reports.*')
                                      ->groupBy("reports.id")
                                      ->leftJoin('customers','customers.id','=','reports.customer_id')
                                      ->whereIn('contract',$jobs_id)->where(['customer_id'=> $cust_id, 'reports.paid' => 0]);
            
        ////Reports Filters
        if(@$_GET['search_everything']){
            $search_name =  @$_GET['search_everything'];
            $ReportsModel = $ReportsModel->where('customers.familyname',$search_name);
        }                              
                                      
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

        $ReportsModel = $ReportsModel->orderBy($order_by,$sort_type)->paginate(10);
        foreach($ReportsModel as $key => $reports){
          $reports_array                     = array();
          $reports_array['report_id']        = $reports['id'];
          $reports_array['contract_id']      = $reports['contract'];
          $reports_array['working_hours']    = $reports['working_hours'];
          $reports_array['working_amount']   = $reports['working_amount'];
          $reports_array['start_date']       = $reports['start_date'];
          $reports_array['end_date']         = $reports['end_date'];
          $reports_array['document']         = $reports['document'];
          $reports_array['customer_id']      = $reports['customer_id'];
          $seeker    = CustomersModel::where(['id' => $reports['customer_id']])->first();
          if($seeker){
              $reports_array['seeker_name'] = $seeker['firstname']." ".$seeker['surname'];
          }
          $get_jobs = JobsModel::where(['id' => $reports['contract']])->first();
          if ($get_jobs) {
             $reports_array['job'] = $get_jobs['title'];
          }

          $get_reports_unpaid[] = $reports_array;
        }
             
       
        return view('front.DocumentsProvider.bills',compact('user','common','get_reports_unpaid'));
    }


    // PAYED BILLSS PROVIDER
    public function provider_documents_payed_bills(Request $request){

        $common = array();
        $common['main_menu']     = 'Documents';
        $common['heading_title'] = __('customer.text_documents');
        
        $sort_type               = "desc";
        $order_by                = "id";  
        
        $cust_id = Session::get('cust_id');
        $user    = CustomersModel::where(['id' => $cust_id])->first();

        $jobs_id = array();
        $JobsModel         = JobsModel::where('customer_id',$cust_id)->get();
        foreach($JobsModel as $key => $job){
            $jobs_id[] = $job['id'];
        }
        
         // Reports paid (Payed Bills)
          $get_reports_paid = array();
          $ReportsModel = ReportsModel::select('reports.*')
                                      ->groupBy("reports.id")
                                      ->leftJoin('customers','customers.id','=','reports.customer_id')
                                      ->whereIn('contract',$jobs_id)->where(['customer_id'=> $cust_id, 'reports.paid' => 1]);

            
          ////Reports Filters
            if(@$_GET['search_everything']){
                $search_name =  @$_GET['search_everything'];
                $ReportsModel = $ReportsModel->where('customers.familyname',$search_name);
            }
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
          $ReportsModel = $ReportsModel->orderBy($order_by,$sort_type)->paginate(10);
          foreach($ReportsModel as $key => $reports){
            $reports_array                     = array();
            $reports_array['report_id']        = $reports['id'];
            $reports_array['contract_id']      = $reports['contract'];
            $reports_array['working_hours']    = $reports['working_hours'];
            $reports_array['working_amount']   = $reports['working_amount'];
            $reports_array['start_date']       = $reports['start_date'];
            $reports_array['end_date']         = $reports['end_date'];
            $reports_array['document']         = $reports['document'];
            $reports_array['customer_id']      = $reports['customer_id'];
            $seeker    = CustomersModel::where(['id' => $reports['customer_id']])->first();
            if($seeker){
                $reports_array['seeker_name'] = $seeker['firstname']." ".$seeker['surname'];
            }
            $get_jobs = JobsModel::where(['id' => $reports['contract']])->first();
            if ($get_jobs) {
               $reports_array['job'] = $get_jobs['title'];
            }

            $get_reports_paid[] = $reports_array;
          }  
                        
       
        return view('front.DocumentsProvider.payed_bills',compact('user','common','get_reports_paid'));
    }


    // OTHER DOCUMENTS PROVIDER
    public function provider_documents_other_documents(Request $request){

        $common = array();
        $common['main_menu']     = 'Documents';
        $common['heading_title'] = __('customer.text_documents');

        $sort_type               = "desc";
        $order_by                = "id";          

        $cust_id = Session::get('cust_id');
        $user    = CustomersModel::where(['id' => $cust_id])->first();

        $jobs_id = array();
        $JobsModel         = JobsModel::where('customer_id',$cust_id)->get();
        foreach($JobsModel as $key => $job){
            $jobs_id[] = $job['id'];
        }

        ////OtherDocuments
        $GetOtherDocuments = OtherDocuments::select('other_documents.*')
                                            ->leftJoin('contracts','contracts.id','=','other_documents.contract_id')
                                            ->leftJoin('jobs','jobs.id','=','contracts.job_id')
                                            ->where(function ($query) use ($cust_id){ 
                                                    $query->where('customer_id_from', '=', $cust_id)
                                                      ->orWhere('customer_id_to', '=', $cust_id);
                                                });

        ////Other Document Filters
        if(@$_GET['job_title']){
            $search_name =@$_GET['job_title'];
            $GetOtherDocuments->where('jobs.title', 'LIKE','%'.$search_name.'%');
        }
        if(@$_GET['contract_no']){
            $search_name =@$_GET['contract_no'];
            $GetOtherDocuments->where('other_documents.contract_id',$search_name);
        }
        if(@$_GET['worker']){
            $search_name =@$_GET['worker'];
            $GetOtherDocuments->where('jobs.profession_name','LIKE','%'.$search_name.'%');
        }
        if(@$_GET['location']){
            $search_name =@$_GET['location'];
            $GetOtherDocuments->where('jobs.work_location','LIKE','%'.$search_name.'%');
        }

        if(@$_GET['search_everything']){
            $search = @$_GET['search_everything'];
            $GetOtherDocuments->where('jobs.title', 'LIKE','%'.$search.'%')->Orwhere('other_documents.contract_id', 'LIKE','%'.$search.'%');
        }
    
        if(@$_GET['sort']){
           $sort      = @$_GET['sort'];
           if($sort == "name"){
               $sort_type = "asc"; 
           }
           if($sort == "date"){
               $sort_type = "desc"; 
           }

        }
       
        $OtherDocuments = $GetOtherDocuments->orderBy($order_by,$sort_type)->get();


        return view('front.DocumentsProvider.other_documents',compact('user','common','OtherDocuments'));
    }


    public function send_otherdocuments(Request $request){
        $common = array();
        $common['main_menu']     = 'Documents';
        $common['heading_title'] = __('customer.text_documents');
        
        $cust_id        = Session::get('cust_id');
        
        $user           = CustomersModel::where(['id' => $cust_id])->first();

        $get_providers  = CustomersModel::where('role','provider')->get();
        
        if($user['role'] == 'seeker'){
            
            $ContractsModel = ContractsModel::select('contracts.*','customers.firstname','jobs.title as contract_title')
                                        ->groupBy("contracts.id")
                                        ->leftJoin('jobs','jobs.id','=','contracts.job_id')
                                        ->leftJoin('customers','customers.id','=','jobs.customer_id')
                                        ->where('contracts.customer_id',$cust_id)->orderBy('id','desc')->get();
        }else{

           $jobs_id        = JobsModel::MyJobs();
           $ContractsModel = ContractsModel::select('contracts.*','customers.firstname as contract_title','jobs.title')
                                        ->groupBy("contracts.id")
                                        ->leftJoin('jobs','jobs.id','=','contracts.job_id')
                                        ->leftJoin('customers','customers.id','=','contracts.customer_id')
                                        ->whereIn('contracts.job_id',$jobs_id)->orderBy('id','desc')->get(); 
                                        
                                   


        }

        if($request->isMethod('post')){

            $field = array();
            $field['contract']      = "required";
            $field['send_to']       = "required";
            $field['title']         = "required";
            $field['date']          = "required";
            $field['document']      = "required|mimes:pdf,jpeg,bmp,png";

            $validator = Validator::make($request->all(),$field);
             if ($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $OtherDocuments  =  new OtherDocuments();
            
            $OtherDocuments->contract_id        =  $request->contract;
            $contract = ContractsModel::where('id',$request->contract)->first();

            if ($request->send_to=='2') {
              if($user['role'] == 'seeker'){
                $JobsModel = JobsModel::where('id',$contract['job_id'])->first();
                $OtherDocuments->customer_id_to     =  $JobsModel->customer_id;
              }else{ 
                $OtherDocuments->customer_id_to     =  $contract->customer_id;
              }
            }elseif ($request->send_to=='1') {
              $OtherDocuments->customer_id_to     =  1;
            }
            

            $OtherDocuments->customer_id_from   =  $cust_id;
            $OtherDocuments->title              =  $request->title;
            $OtherDocuments->date               =  $request->date; 
            

            if($request->hasFile('document')) {
                $random_no  = uniqid();
                $img = $request->document;
                $ext = $img->getClientOriginalExtension();
                $new_name = $random_no . '.' . $ext;
                    $destinationPath  =  public_path('/Images/otherdocuments');
                    $img->move($destinationPath, $new_name);
                    $OtherDocuments->document  = $new_name;
            }
            $OtherDocuments->save();
            return redirect('documents/seeker/other_documents')->withErrors(['success'=> "Documents Send Successfully"]);
        }
        

        return view('front.Documents.add_document ',compact('common','ContractsModel','user','get_providers'));
    }


    public function generate_pdf($contract_id=''){

      $contract_detail = array();
      $get_contract_details = ContractsModel::where('id',$contract_id)->first();
      if ($get_contract_details) {
        $contract_detail['contract_id'] = $get_contract_details['id'];
        $contract_detail['job_id']      = $get_contract_details['job_id'];
        $contract_detail['customer_id'] = $get_contract_details['customer_id'];
        $contract_detail['status']      = $get_contract_details['status'];
        $contract_detail['signing_date']= $get_contract_details['created_at'];

        $contract_detail['customer_name']     = '-';
        $contract_detail['phone_number']      = '-';
        $contract_detail['customer_street']   = '-';
        $contract_detail['customer_zip_code'] = '-';
        $contract_detail['customer_city']     = '-';
        $contract_detail['customer_country']  = '-';

        // (STREET, CITYS ZIP-CODE, CITY, COUNTRY)
        $get_customer_detail = CustomersModel::where(['id'=>$get_contract_details['customer_id']])->first();
        if ($get_customer_detail) {
          $contract_detail['customer_name']     = $get_customer_detail['firstname'].' '.$get_customer_detail['surname'];
          $contract_detail['phone_number']      = $get_customer_detail['phone_number'];
          $contract_detail['customer_street']   = $get_customer_detail['street'];
          $contract_detail['customer_zip_code'] = $get_customer_detail['zip_code'];

          $get_city = CityModel::where('id',$get_customer_detail['city'])->first();
          if ($get_city) {
            $contract_detail['customer_city']     = $get_city['name'];
          }

          $get_country = CountryModel::where('id',$get_customer_detail['country'])->first();
          if ($get_country) {
            $contract_detail['customer_country']  = $get_country['name'];
          }
        }  

        $get_single_job = JobsModel::where(['id'=>$get_contract_details['job_id']])->first();
        if ($get_single_job) {
          $contract_detail['job_type_id']     = $get_single_job['job_type_id'];
          $contract_detail['job_title']       = $get_single_job['title'];
          $contract_detail['salary']          = $get_single_job['salary'];
          $contract_detail['profession_name'] = $get_single_job['profession_name'];
          $contract_detail['experience']      = $get_single_job['experience'];
          $contract_detail['working_hours']   = $get_single_job['working_hours'];
          $contract_detail['work_location']   = $get_single_job['work_location'];
          $contract_detail['start_date']      = $get_single_job['start_date'];
          $contract_detail['requirements']    = $get_single_job['requirements'];
          $contract_detail['description']     = $get_single_job['description'];
          $contract_detail['driving_license'] = $get_single_job['driving_license'];
          $contract_detail['own_car']         = $get_single_job['own_car'];
          $contract_detail['employer_id']     = $get_single_job['customer_id'];
        }

        $contract_detail['employer_city']      = '-';
        $contract_detail['employer_country']   = '-';
        $contract_detail['employer_name']      = '-';
        $contract_detail['employer_street']    = '-';
        $contract_detail['employer_zip_code']  = '-';

        $get_employer_detail = CustomersModel::where(['id'=>$get_single_job['customer_id']])->first();
        if ($get_employer_detail) {
          $contract_detail['employer_name']     = $get_employer_detail['firstname'].' '.$get_employer_detail['surname'];
          $contract_detail['employer_street']   = $get_employer_detail['street'];
          $contract_detail['employer_zip_code'] = $get_employer_detail['zip_code'];

          $get_emp_city = CityModel::where('id',$get_employer_detail['city'])->first();
          if ($get_emp_city) {
            $contract_detail['employer_city']     = $get_emp_city['name'];
          }

          $get_emp_country = CountryModel::where('id',$get_employer_detail['country'])->first();
          if ($get_emp_country) {
            $contract_detail['employer_country']  = $get_emp_country['name'];
          }

          
        }

      }

      // return view('testpdf',compact('contract_detail'));
     
      $dompdf = new Dompdf();

      $viewhtml = View::make('pdf.contract_detail', compact('contract_detail'))->render();
      // return $viewhtml;
      $date = date('d-m-Y');

      $dompdf->loadHtml($viewhtml);
      $options = $dompdf->getOptions();
      $options->set(array('isRemoteEnabled' => true));
      $options->set('isPhpEnabled', true);
      $dompdf->setOptions($options);
      $dompdf->set_paper('A4', 'portrait');
      $dompdf->render();
      $pdf = $dompdf->output();
      $dompdf->stream("contract-detail-".$date);
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
