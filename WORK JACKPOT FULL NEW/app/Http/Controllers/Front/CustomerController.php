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
use App\Models\JobsModel;
use App\Models\JobsFavouriteModel;
use App\Models\LanguagesModel;
use App\Models\ContactModel;
use App\Models\CustomersModel;
use App\Models\CountryModel;
use App\Models\CityModel;
use App\Models\StateModel;
use App\Models\FavouriteCustomerModel;
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


class CustomerController extends Controller{

    public function login(Request $request){

        if($request->isMethod('post')) {
            $validation = Validator::make($request->all(), [
                'email'    => 'email|required',
                'password' => 'required'
            ])->validate();
            $customer = CustomersModel::where(['email' => $request->email])->first();
            
            if($customer){ 
                if($customer->is_verify == 0){
                    $request->session()->put('temp_session_id', $customer->id);
                    $otp                       = rand(100000,999999);
                    $otp                       =  123456;
                    $customer->otp             = $otp;
                    $expiry_time_str           = strtotime("+1 minutes", strtotime(date('Y-m-d H:i:s')));
                    $customer->otp_expiry_time = date('Y-m-d H:i:s',$expiry_time_str);
                    $customer->update();
                    $email = $customer->email;

                    $data = array('email'=>$customer->email,'user_id'=>$customer->id,'name'=>$customer->firstname.' '.$customer->surname,"otp"=>$otp);
                    $sent = Mail::send('emails.otp_mail', $data, function($message) use ($email) {
                        $message->to($email)->subject(__('customer.text_forgot_password'));
                    });

                    if($customer->role == "provider"){
                        return redirect('/signup')->withErrors(['provider_otp_modal'=> true]);
                    }else{
                        return redirect('/seeker_signup')->withErrors(['seeker_otp_modal'=> true]);
                    }
                }
            }

            if(!empty($customer)){
                if($customer->is_delete != "On"){
                    if (Hash::check($request->password, $customer->password)) {
                        $request->session()->put('cust_id', $customer->id);
                        $request->session()->put('is_setup', 0);
                        if ($customer->is_setup == '1') {
                          $request->session()->put('is_setup', $customer->is_setup);
                        }
                        $request->session()->put('role', $customer->role);
                        
                        $get_language_details = LanguagesModel::where(['id' => $customer->language_id, 'status' => '1'])->first();
                        $request->session()->put('locale', $get_language_details->short_name);

                        return redirect('/dashboard')->withErrors(['success'=> __('customer.text_login_success')])->withInput();
                    }else{
                        return back()->withErrors(['error'=> __('customer.text_invalid_password')])->withInput();
                    }
                }
                else{
                    return back()->withErrors(['error'=> __('customer.text_acc_deleted')])->withInput();
                }
            }else{
                return back()->withErrors(['error'=> __('customer.text_customer_not_found')])->withInput();
            }
        }else{
            return view('front.login');
        }

    }

    public function dashboard(Request $request){

        $common                  = array();
        $common['main_menu']     = 'Dashboard';
        $common['heading_title'] = 'Dashboard';
        
        
        $cust_id  = Session::get('cust_id');
        $is_setup = Session::get('is_setup');
        $role     = Session::get('role');
      

      	$user    = CustomersModel::where(['id' => $cust_id])->first();
      
        $get_seekers  = array();
        $seekers      = array();
        $jobs         = array();
        $get_jobs     = array();
        
        if($user['role']=='provider'){
            $sort    = "contracts.id";
            $orderby = "Desc";
            
            $CustomersModel = ContractsModel::MyContracts();
            
            if(@$_GET['search_everything']){
                $search         = @$_GET['search_everything'];
                $CustomersModel->where('customers.firstname', 'LIKE','%'.$search.'%')->Orwhere('surname', 'LIKE','%'.$search.'%');
            }
            if (@$_GET['NameSearch']) {
                $NameSearch     = @$_GET['NameSearch'];
                $CustomersModel->where('customers.firstname','LIKE','%'.$NameSearch.'%');
            }


            if(@$_GET['job_no']){
                $search    = @$_GET['job_no'];
                $CustomersModel->where('job_id',$search);
            }
            if(@$_GET['profession']){
                $search  = @$_GET['profession'];
                $CustomersModel->where('profession_name', 'LIKE','%'.$search.'%');
            }
            if(@$_GET['location']){
                $search   = @$_GET['location'];
                $CustomersModel->where('work_location', 'LIKE','%'.$search.'%'); 
            }
            
            if(@$_GET['sort']){
             if(@$_GET['sort'] == "date"){
                $sort    = "customers.created_at";
                $orderby = "Desc";
             }else{
                $sort    = "customers.firstname";
                $orderby = "asc";
             }
            } 

            $get_seekers = $CustomersModel->orderBy($sort,$orderby)->paginate(6);

            if ($get_seekers) {
                foreach ($get_seekers as $key => $value) {
                    $row['job_id']             = $value['job_id'];
                    $row['id']                 = $value['id'];
                    $row['familyname']         = $value['familyname'];
                    $row['firstname']          = $value['firstname'];
                    $row['profile_image']      = $value['profile_image'];
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
                    $row['role']               = $value['role'];
                    $row['fav_candidates']     = '0';
                    $get_favourite             = FavouriteCustomerModel::where(['customer_id'=>$value['id'],'provider_id'=>$cust_id])->first();
                    if ($get_favourite) {
                        $row['fav_candidates'] = '1';
                    }
                    $get_experience            = CustomerExperiance::where([ 'customer_id' => $value['id'] ])->first();
                    if ($get_experience) {
                        $row['working_year']   = $get_experience['working_year'];
                    }else{
                        $row['working_year']   = "-";
                    }
                    $row['adv_no']             = '';
                    $row['working_hour']       = '-';
                    $row['work_location']      = '-';
                    $row['own_car']            = '-';
                    $row['driving_license']    = '-';
                    $row['date']               = '-';
                    $get_advertisment          = AdvertismentModel::where([ 'customer_id' => $value['id'] ])->first();
                    
                    if ($get_advertisment) {
                        $row['adv_no']         = $get_advertisment['id'];
                        $row['working_hour']   = $get_advertisment['working_hour'];
                        $row['work_location']  = $get_advertisment['work_location'];
                        $row['own_car']        = $get_advertisment['own_car'];
                        $row['driving_license']= $get_advertisment['driving_license'];
                        $row['date']           = $get_advertisment['date'];
                     // $row['date']= $get_advertisment['day'].'/'.$get_advertisment['month'].'/'.$get_advertisment['year'];
                    }
                    $seekers[] = $row;
                }
               
            }

            return view('front.dashboard',compact('user','common','get_seekers','seekers'));

        }elseif($user['role']=='seeker'){
            

            $JobsModel = JobsModel::where(['status'=>'Published']);
            $sort    = "id";
            $orderby = "Desc";

            if(@$_GET['search_everything']){
                $search                    = @$_GET['search_everything'];
                $JobsModel->where('title', 'LIKE','%'.$search.'%')->orWhere('id',$search)->orWhere('work_location', 'LIKE','%'.$search.'%');
            }

            if(@$_GET['job_no']){
                $search    = @$_GET['job_no'];
                $JobsModel->where('id',$search);
            }
            if(@$_GET['profession']){
                $search                    = @$_GET['profession'];
                $JobsModel->where('profession_name', 'LIKE','%'.$search.'%');
            }
            if(@$_GET['location']){
               $search               = @$_GET['location'];
               $JobsModel->where('work_location', 'LIKE','%'.$search.'%'); 
            }
            
            if(@$_GET['sort']){
             if(@$_GET['sort'] == "date"){
                $sort    = "created_at";
                $orderby = "Desc";
             }else{
                $sort    = "title";
                $orderby = "asc";
             }
            }

           
            $get_jobs = $JobsModel->orderBy($sort,$orderby)->paginate(6);
            //  echo $JobsModel->toSql();
            // die;

            if ($get_jobs) {
                foreach ($get_jobs as $key => $value) {
                  $job                    = array();
                  $job['id']              = $value['id'];
                  $job['job_type_id']     = $value['job_type_id'];
                  $job['title']           = $value['title'];
                  $job['salary']          = $value['salary'];
                  $job['profession_name'] = $value['profession_name'];
                  $job['experience']      = $value['experience'];
                  $job['working_hours']   = $value['working_hours'];
                  $job['work_location']   = $value['work_location'];
                  $job['start_date']      = $value['start_date'];
                  $job['requirements']    = $value['requirements'];
                  $job['description']     = $value['description'];
                  $job['driving_license'] = $value['driving_license'];
                  $job['own_car']         = $value['own_car'];
                  $job['status']          = $value['status'];

                  $job['wishlist']        = '0';
                  $get_favourite = JobsFavouriteModel::where(['job_id'=>$value['id'],'customer_id'=>$cust_id])->first();
                  if ($get_favourite){
                    $job['wishlist']      = '1';
                  }

                  $job['contract']        = '';
                  $get_contract = ContractsModel::where(['job_id'=>$value['id'],'customer_id'=>$cust_id])->first();
                  if($get_contract) {
                    $job['contract']         = '1';
                    $job['contract_status']  = $get_contract['status'];
                  }


                  $newtimeago             = $this->newtimeago($value['created_at']); 
                  $job['datetime']        = $newtimeago;
                  $jobs[] = $job;
                }
            }
            return view('front.dashboard',compact('user','common','get_jobs','jobs'));
        }else{
            return view('front.dashboard',compact('user','common'));
        }
    }

    public function get_flag(Request $request){
        $Languge_id = $request->Languge_id;

        $get_language_details = LanguagesModel::where(['id' => $Languge_id, 'status' => '1'])->first();

        // $request->session()->put('lang_id', $Languge_id);
        $html = '';
        $flag_image = $get_language_details['image'];
        $html .= '<img src="'.url('/Images/Flags/'.$flag_image.'').'" alt="" height="24px" width="24px">';
      
        echo $html;
        die();
    
    }


    public function search(){

        $common                    = array();
        $get_profession            = array();
        $common['main_menu']       = 'Search';
        $common['profession_name'] = "";
        $common['location']        = "";
        $common['main_menu']       = 'Search';
        $common['Job_title']       = "";
        $common['Job_no']          = "";
        $common['Job_location']    = "";
        $common['Job_skills']      = "";
        $common['Job_salary_from'] = "";
        $common['Job_salary_to']   = "";
        $get_jobs                  = array(); 
        $get_seekers               = array();
        $cust_id = Session::get('cust_id');
        $user    = CustomersModel::where(['id' => $cust_id])->first();

        $get_profession =  JobsModel::get(['profession_name']);

        $seekers = array();
        $jobs    = array();
        if($user['role']=='provider'){
            $common['heading_title'] = __('customer.text_search_for_worker');
            $sort_type = "Desc"; 
            $order_by  = "contracts.id"; 
                

            $CustomersModel = ContractsModel::MyContracts();
            
            if(@$_GET['Job_no']){
                $search    = @$_GET['Job_no'];
                $CustomersModel->where('job_id',$search);
            }
            if(@$_GET['Job_title']){
                $search                    = @$_GET['Job_title'];
                $CustomersModel->where('customers.firstname', 'LIKE','%'.$search.'%');
            }
            if(@$_GET['Job_location']){
               $search               = @$_GET['Job_location'];
               $CustomersModel->where('work_location', 'LIKE','%'.$search.'%'); 
            }

            // echo @$_GET['profession'];
            // die();

            //////Header Search
            if(@$_GET['profession']){
              $search                    =  @$_GET['profession'];
              $CustomersModel->where('profession_name', 'LIKE', '%' . $search . '%');
            }
            if(@$_GET['location']){
               $search    =  @$_GET['location'];
               $CustomersModel->where('work_location', 'LIKE', '%' . $search . '%'); 
            }
             //////Header Search


            if(@$_GET['sort']){
               $sort      = @$_GET['sort'];
               if($sort == "name"){
                   $order_by  = "firstname"; 
                   $sort_type = "asc"; 
               }
               if($sort == "date"){
                   $order_by  = "contracts.created_at"; 
                   $sort_type = "desc"; 
               }
            }

            // if(@$_GET['show_all'] || @$_GET['location'] || @$_GET['profession'] || @$_GET['filter']){ 
            // }
            $get_seekers =  $CustomersModel->where(['role'=>'seeker'])->orderBy($order_by, $sort_type)->paginate(6);

            if($get_seekers){
                foreach ($get_seekers as $key => $value) {
                    $row                       = array();
                    $row['job_id']             = $value['job_id'];
                    $row['id']                 = $value['id'];
                    $row['familyname']         = $value['familyname'];
                    $row['firstname']          = $value['firstname'];
                    $row['profile_image']      = $value['profile_image'];
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
                    $row['fav_candidates']     = '0';
                    $get_favourite = FavouriteCustomerModel::where(['customer_id'=>$value['id'],'provider_id'=>$cust_id])->first();
                    if($get_favourite){
                        $row['fav_candidates'] = '1';
                    }
                    $get_experience            = CustomerExperiance::where([ 'customer_id' => $value['id'] ])->first();
                    if ($get_experience) {
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
                        // $row['date']  = $get_advertisment['day'].'/'.$get_advertisment['month'].'/'.$get_advertisment['year'];
                        $row['date']           = $get_advertisment['date'];
                        
                    }   


                    $get_job  = JobsModel::where(['id' => $value['job_id'] ])->first();

                    if ($get_job) {
                        $row['driving_license'] = $get_job['driving_license'];
                    }

                    $seekers[] = $row;
                }
            }
            return view('front.search_result',compact('user','common','get_seekers','seekers','get_profession'));

        }elseif($user['role']=='seeker'){

            $common['heading_title'] = __('customer.text_search_for_work');
            $JobsModel               = new JobsModel();
            $sort_type = "Desc"; 
            $order_by  = "id"; 

            ////Header Search////////
            if(@$_GET['profession']){
              $search    =  @$_GET['profession'];
              $JobsModel =  $JobsModel->where('profession_name', 'LIKE', '%' . $search . '%');
            }
            if(@$_GET['location']){
               $search    =  @$_GET['location'];
               $JobsModel = $JobsModel->where('work_location', 'LIKE', '%' . $search . '%'); 
            }
            ////Header Search End ////////


            ///////// Filter Search /////////
            if(@$_GET['Job_title']){
               $search    =  @$_GET['Job_title'];
               $JobsModel = $JobsModel->where('title', 'LIKE', '%' . $search . '%');
            }
            if(@$_GET['Job_no']){
               $search    =  @$_GET['Job_no'];
               $JobsModel = $JobsModel->where('id',$search);
            }
            if(@$_GET['Job_location']){
               $search    =  @$_GET['Job_location'];
               $JobsModel = $JobsModel->where('work_location', 'LIKE', '%' .$search. '%');
            }
            if(@$_GET['Job_skills']){
               $search =  @$_GET['Job_skills'];
               $JobsModel = $JobsModel->where('profession_name', 'LIKE', '%' . $search . '%'); 
            }
            if(@$_GET['Job_salary_from'] || @$_GET['Job_salary_to']){
                if(@$_GET['Job_salary_from']){
                  $salary_from =  @$_GET['Job_salary_from'];
                  $JobsModel = $JobsModel->where('salary','>=',$salary_from); 
                }
                if(@$_GET['Job_salary_to']){
                  $salary_to   =  @$_GET['Job_salary_to'];
                  $JobsModel = $JobsModel->where('salary','<=',$salary_to);
                }
            }
            ///////// Filter Search End /////////

            if(@$_GET['sort']){
               $sort      = @$_GET['sort'];
               if($sort == "job_title"){
                   $sort_type = "asc"; 
                   $order_by  = "title"; 
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

            // echo $JobsModel->toSql();
            // die;


            if(@$_GET['show_all'] || @$_GET['filter'] || @$_GET['location'] || @$_GET['profession']){ 
             $get_jobs = $JobsModel->where(['status'=>'Published'])->orderBy($order_by,$sort_type)->paginate(6);
            }

            if($get_jobs){
                foreach ($get_jobs as $key => $value) {
                  $job = array();
                  $job['id']              = $value['id'];
                  $job['job_type_id']     = $value['job_type_id'];
                  $job['title']           = $value['title'];
                  $job['salary']          = $value['salary'];
                  $job['profession_name'] = $value['profession_name'];
                  $job['experience']      = $value['experience'];
                  $job['working_hours']   = $value['working_hours'];
                  $job['work_location']   = $value['work_location'];
                  $job['start_date']      = $value['start_date'];
                  $job['requirements']    = $value['requirements'];
                  $job['description']     = $value['description'];
                  $job['driving_license'] = $value['driving_license'];
                  $job['own_car']         = $value['own_car'];

                  $job['wishlist'] = '0';
                  $get_favourite   = JobsFavouriteModel::where(['job_id'=>$value['id'],'customer_id'=>$cust_id])->first();
                  if($get_favourite){
                    $job['wishlist'] = '1';
                  }

  
                  $job['contract'] = '';
                  $ContractsModel  = ContractsModel::where(['job_id'=>$value['id'],'customer_id'=>$cust_id,'status'=>'Pending']);
                  $ContractsModel->whereIn('status', ['Pending','Published','Reject','Completed']);
                  $get_contract    = $ContractsModel->first();
                  if($get_contract) {
                    $job['contract'] = '1';
                  }
                  $newtimeago      = $this->newtimeago($value['created_at']); 
                  $job['datetime'] = $newtimeago;

                  $jobs[] = $job;
                }
            }

            return view('front.search_result',compact('user','common','get_jobs','jobs','get_profession'));
        }else{
            return view('front.search_result',compact('user','common','get_profession'));
        }
    }

    public function favorite_candidates(Request $request){

        $common = array();
        $common['main_menu']     = 'Favorites Candidates';
        $common['heading_title'] = 'Favorites Candidates';
        $cust_id                 = Session::get('cust_id');
        $user                    = CustomersModel::where(['id' => $cust_id])->first();

        $FavouriteCustomerModel  = FavouriteCustomerModel::select('favourite_customers.*','contracts.job_id')
                                                        ->groupBy("favourite_customers.id")
                                                        ->leftJoin('customers','customers.id','=','favourite_customers.customer_id')
                                                        ->leftJoin('customer_professions','customers.id','=','favourite_customers.customer_id')
                                                        ->leftJoin('contracts','contracts.customer_id','=','favourite_customers.customer_id');

                                                        
        
        $order_by  = "favourite_customers.id";
        $sort_type = "Desc";
        
        if(@$_GET['job_no']){
            $search_name =@$_GET['job_no'];
            $FavouriteCustomerModel->where('contracts.job_id',$search_name);
        }
        if(@$_GET['name']){
            $search_name =@$_GET['name'];
            $FavouriteCustomerModel->where('firstname','LIKE', '%' . $search_name . '%');
        }
        if(@$_GET['profession']){
            $search_name =@$_GET['profession'];
            $FavouriteCustomerModel->where('profession_name','LIKE', '%' . $search_name . '%');
        }

        if(@$_GET['search_everything']){
            $search_name = @$_GET['search_everything'];
            $FavouriteCustomerModel->where('customers.firstname', 'LIKE','%'.$search_name.'%')->Orwhere('customers.surname', 'LIKE','%'.$search_name.'%');
        }

        if(@$_GET['sort']){
           $sort      = @$_GET['sort'];
           if($sort == "name"){
               $order_by  = "firstname"; 
               $sort_type = "asc"; 
           }
           if($sort == "date"){
               $order_by  = "favourite_customers.created_at"; 
               $sort_type = "desc"; 
           }

        }




        $get_fav_candidsates = $FavouriteCustomerModel->where(['provider_id'=>$cust_id])->orderBy($order_by,$sort_type)->paginate(6);
        $candidates              = array();
        if ($get_fav_candidsates) { 
            foreach ($get_fav_candidsates as $key => $value) {
                $row                = array();
                $row['id']          = $value['id'];
                $row['customer_id'] = $value['customer_id'];
                $row['job_id']      = $value['job_id'];

                $get_seekers        = CustomersModel::where(['id' => $value['customer_id']])->first();
                if ($get_seekers) {
                    $row['firstname']     = $get_seekers['firstname'];
                    $row['surname']       = $get_seekers['surname'];
                    $row['email']         = $get_seekers['email'];
                    $row['profile_image'] = $get_seekers['profile_image'];

                    $get_experience       = CustomerExperiance::where([ 'customer_id' => $get_seekers['id'] ])->first();
                    if ($get_experience) {
                        $row['working_year'] = $get_experience['working_year'];
                    }
                    
                    $row['adv_no']        = '';
                    $row['working_hour']  = '';
                    $row['own_car']       = '';
                    $row['date']          = '';
                    $row['work_location'] = '';
                    $get_advertisment     = AdvertismentModel::where([ 'customer_id' => $get_seekers['id'] ])->first();
                  
                    if ($get_advertisment) {
                        $row['adv_no']        = $get_advertisment['id'];
                        $row['work_location'] = $get_advertisment['work_location'];
                        $row['working_hour']  = $get_advertisment['working_hour'];
                        $row['own_car']       = $get_advertisment['own_car'];
                        $row['date']          = $get_advertisment['date'];
                        // $row['date']          = $get_advertisment['day'].'/'.$get_advertisment['month'].'/'.$get_advertisment['year'];
                    }

                    $get_job  = JobsModel::where(['id' => $value['job_id'] ])->first();

                    if ($get_job) {
                        $row['driving_license'] = $get_job['driving_license'];
                    }

                }
                $candidates[] = $row;
            }
        }
      
        return view('front.Favourite.candidates',compact('user','common','candidates','get_fav_candidsates'));
    }


    public function seeker_profile(Request $request){

        $common = array();
        $Page = @$_GET['Page'];
        $common['main_menu']     = 'Favorites Candidates';
        if ($Page == 'Work Management') {
            $common['main_menu']     = 'Work Management'; 
        }elseif ($Page == 'Dashboard') {
            $common['main_menu']     = 'Dashboard';
        }elseif ($Page == 'Search') {
            $common['main_menu']     = 'Search';
        }elseif ($Page == 'Job') {
            $common['main_menu']     = 'Job';
        }

        $common['heading_title'] = __('customer.text_seeker_profile');
        $get_advertisment        = array();
        $ID = @$_GET['ID'];
      
        $cust_id = Session::get('cust_id');
        $user = CustomersModel::where(['id' => $cust_id])->first();

        $user_details = CustomersModel::where(['id'=>$ID])->first();
        $seeker = array();
        if ($user_details) { 
              $seeker['firstname']      = $user_details['firstname'];
              $seeker['surname']        = $user_details['surname'];
              $seeker['profile_image']  = $user_details['profile_image'];
              $seeker['dob']            = $user_details['dob'];
              $seeker['gender']         = $user_details['gender'];
              $seeker['address']        = $user_details['address'];
              $seeker['zip_code']       = $user_details['zip_code'];
              $seeker['house_number']   = $user_details['house_number'];
              $seeker['phone_number']   = $user_details['phone_number'];
              $seeker['email']          = $user_details['email'];
              $seeker['country']        = $user_details['country'];
              $seeker['state']          = $user_details['state'];
              $seeker['city']           = $user_details['city'];
              $seeker['file']           = $user_details['file'];
              $seeker['role']           = $user_details['role'];
              
              $seeker['country_name']   = '';
              $get_countries = CountryModel::where('id',$user_details['country'])->first();
              if ($get_countries) {
                  $seeker['country_name'] = $get_countries['name'];  
              }

              ////Edutucation Source
              $seeker['education_source'] = array();
              $CustomerSchool = CustomerSchool::where('customer_id',$user_details['id'])->get();
              if(!$CustomerSchool->isEmpty()){
                foreach($CustomerSchool as $key => $value) {
                   $edu_source                    = array(); 
                   $edu_source['school_name']     = $value['school_name']; 
                   $edu_source['school_address']  = $value['school_address']; 
                   $edu_source['school_year']     = $value['school_year']; 
                   
                   $seeker['education_source'][] = $edu_source;
                }
              }


              /////Hiring History
              $seeker['hiring_history'] = array();
              $CustomerHiringHistory = CustomerHiringHistory::where('customer_id',$user_details['id'])->get();
              if(!$CustomerHiringHistory->isEmpty()){
                foreach($CustomerHiringHistory as $key => $value2) {
                    $customer_hiring   = array();
                    $customer_hiring['company_name']    = $value2['company_name'];
                    $customer_hiring['company_address'] = $value2['company_address'];
                    $customer_hiring['working_year']    = $value2['working_year'];
                    
                    $seeker['hiring_history'][]  = $customer_hiring;
                }
              }

              ////Experiance in Ablroad
              $seeker['exp_abroad'] = array();
              $CustomerExperiance = CustomerExperiance::where('customer_id',$user_details['id'])->get();
              if(!$CustomerExperiance->isEmpty()){
                foreach($CustomerExperiance as $key => $value3) {
                    $customer_exp_abrod   = array();
                    $customer_exp_abrod['company_name']    = $value3['company_name'];
                    $customer_exp_abrod['company_address'] = $value3['company_address'];
                    $customer_exp_abrod['working_year']    = $value3['working_year'];
                    
                    $seeker['exp_abroad'][]  = $customer_exp_abrod;
                }
              }

              ////Skills
              $seeker['skills'] = array();
              $SkillsModel = SkillsModel::where('customer_id',$user_details['id'])->get();
              if(!$SkillsModel->isEmpty()){
                foreach($SkillsModel as $key => $value4) {
                    $customer_skill   = array();
                    $customer_skill['skill']    = $value4['skill'];
                    
                    $seeker['skills'][]  = $customer_skill;
                }
              }


              /////Intrest & Hobbies
              $seeker['hobbies'] = array();
              $HobbiesModel = HobbiesModel::where('customer_id',$user_details['id'])->get();
              if(!$HobbiesModel->isEmpty()){
                foreach($HobbiesModel as $key => $value5) {
                    $customer_hobbies   = array();
                    $customer_hobbies['hobby']    = $value5['hobby'];
                    
                    $seeker['hobbies'][]  = $customer_hobbies;
                }
              }

              ////Permissions
              $seeker['permission'] = array();
              $CustomerPermission = CustomerPermission::where('customer_id',$user_details['id'])->get();
              if(!$CustomerPermission->isEmpty()){
                foreach($CustomerPermission as $key => $value_per) {
                    $customer_permission   = array();
                    $customer_permission['permission']    = $value_per['permission'];
                    
                    $seeker['permission'][]  = $customer_permission;
                }
              }


               ////Langugaes
              $seeker['cust_language'] = array();
              $CustomerLanguage = CustomerLanguage::where('customer_id',$user_details['id'])->get();
              if(!$CustomerLanguage->isEmpty()){
                foreach($CustomerLanguage as $key => $value_lang) {
                    $customer_language   = array();
                    $customer_language['language']    = $value_lang['language'];
                    
                    $seeker['cust_language'][]  = $customer_language;
                }
              }


               ////Other Knowledge
              $seeker['other_knowledges'] = array();
              $CustomerOtherKnowledge = CustomerOtherKnowledge::where('customer_id',$user_details['id'])->get();
              if(!$CustomerOtherKnowledge->isEmpty()){
                foreach($CustomerOtherKnowledge as $key => $value_oth) {
                    $customer_other   = array();
                    $customer_other['other_knowledge']    = $value_oth['other_knowledge'];
                    
                    $seeker['other_knowledges'][]  = $customer_other;
                }
              }

              /////Addition indo 
              $seeker['add_info'] = array();
              $CustomerInformation = CustomerInformation::where('customer_id',$user_details['id'])->get();
              if(!$CustomerInformation->isEmpty()){
                foreach($CustomerInformation as $key => $value_info) {
                    $customer_info   = array();
                    $customer_info['information']    = $value_info['information'];
                    
                    $seeker['add_info'][]  = $customer_info;
                }
              }
              

              /////Profession
              $seeker['professions'] = array();
              $CustomerProfession = CustomerProfession::where('customer_id',$user_details['id'])->get();
              if(!$CustomerProfession->isEmpty()){
                foreach($CustomerProfession as $key => $value6) {
                    $customer_professions   = array();
                    $customer_professions['profession_name']    = $value6['profession_name'];
                    $customer_professions['profession_year']    = $value6['profession_year'];
                    
                    $seeker['professions'][]  = $customer_professions;
                }
              }


              ////////Seeker Advertisment
              $get_advertisment   = AdvertismentModel::select('advertisment.*','customers.profile_image','advertisment.working_hour as adv_working_hours')
                                         ->leftJoin('customers','customers.id','=','advertisment.customer_id')
                                         ->where('customer_id',$user_details['id'])->get();
              

        }else{
            return back();
        }

        return view('front.Seeker.view_profile',compact('user','common','seeker','get_advertisment'));
    
    }


    public function favorite_jobs(Request $request){

        $common                  =  array();
        $get_fav_jobs            = array();
        $common['main_menu']     = 'Favorites Jobs';
        $common['heading_title'] = 'Favorites Jobs';
        $sort_type               ="desc";
        $order_by                ="id";

        $cust_id              = Session::get('cust_id');
        $user                 = CustomersModel::where(['id' => $cust_id])->first();
        $JobsFavouriteModel   = JobsFavouriteModel::select('jobs_favourite.*')
                                                ->leftJoin("jobs", "jobs.id", "=", "jobs_favourite.job_id")
                                                ->where('jobs_favourite.customer_id',$cust_id);

        ////Filter 
        if(@$_GET['search_for_everything']){
            $search_name =  @$_GET['search_for_everything'];
            $JobsFavouriteModel->where('jobs.title','LIKE','%'.$search_name.'%');
        }

        if(@$_GET['profession']){
            $search_name =  @$_GET['profession'];
            $JobsFavouriteModel->where('jobs.profession_name','LIKE','%'.$search_name.'%');
        }
        if(@$_GET['job_no']){
            $search_name =  @$_GET['job_no'];
            $JobsFavouriteModel->where('jobs.id',$search_name);
        }
        if(@$_GET['location']){
            $search_name =  @$_GET['location'];
            $JobsFavouriteModel->where('jobs.work_location','LIKE','%'.$search_name.'%');
        }
        if(@$_GET['search_everything']){
            $search_name = @$_GET['search_everything'];
            $JobsFavouriteModel->where('jobs.title', 'LIKE','%'.$search_name.'%');
        }

        if(@$_GET['sort']){
           $sort      = @$_GET['sort'];
           if($sort == "name"){
               $sort_type = "asc"; 
               $order_by  = "title"; 
           }
           if($sort == "date"){
               $order_by  = "created_at"; 
               $sort_type = "desc"; 
           }

        } 

        
        $get_fav_jobs = $JobsFavouriteModel->orderBy($order_by,$sort_type)->paginate(6);
        $jobs         = array();
        if($get_fav_jobs) { 
            foreach ($get_fav_jobs as $key => $value) {
                $job = array();
                $job['id']        = $value['id'];
                $job['job_id']    = $value['job_id'];

                $get_jobs = JobsModel::where(['id' => $value['job_id']])->first();
                if($get_jobs){
                    $job['id']              = $get_jobs['id'];
                    $job['job_type_id']     = $get_jobs['job_type_id'];
                    $job['title']           = $get_jobs['title'];
                    $job['salary']          = $get_jobs['salary'];
                    $job['profession_name'] = $get_jobs['profession_name'];
                    $job['experience']      = $get_jobs['experience'];
                    $job['working_hours']   = $get_jobs['working_hours'];
                    $job['work_location']   = $get_jobs['work_location'];
                    $job['start_date']      = $get_jobs['start_date'];
                    $job['requirements']    = $get_jobs['requirements'];
                    $job['description']     = $get_jobs['description'];
                    $job['driving_license'] = $get_jobs['driving_license'];
                    $job['own_car']         = $get_jobs['own_car'];
                    $job['status']          = $get_jobs['status'];
                    $job['wishlist']        = '0';
                    $get_favourite          = JobsFavouriteModel::where(['job_id'=>$value['id'],'customer_id'=>$cust_id])->first();
                    if ($get_favourite) {
                    $job['wishlist']         = '1';
                    }
                    $newtimeago              = $this->newtimeago($get_jobs['created_at']); 
                    $job['datetime']         = $newtimeago;
                }

                $jobs[] = $job;

            }
        }

        return view('front.Favourite.favourite_jobs',compact('user','common','jobs','get_fav_jobs'));
    
    }

    public function add_favourite_candidates(Request $request){

      $cust_id = Session::get('cust_id');
      $Seeker_ID = $request->Seeker_ID;
      
      $get_favourite = FavouriteCustomerModel::where(['customer_id'=>$Seeker_ID,'provider_id'=>$cust_id])->first();
      if ($get_favourite=='') {
        $Data = array();
        $Data['customer_id'] = $Seeker_ID;
        $Data['provider_id'] = $cust_id;
        $insert_id = FavouriteCustomerModel::create($Data);

        $request->session()->flash('success', __('customer.text_seeker_add_to_fav'));
        // return redirect('job')->withErrors(['success'=> 'Jobs added to Favorite']);  
      }else{
        FavouriteCustomerModel::where('customer_id', $Seeker_ID)->delete();
        $request->session()->flash('danger', __('customer.text_seeker_remove_to_fav'));
      }

    }

    public function forgot_password(Request $request){
        
        if ($request->isMethod('post')) {        
            
            $validation = Validator::make($request->all(), [
                'email' => 'email|required',
                
            ]);
    
            if ($validation->fails()) {
                return back()->withErrors($validation)->withInput();
            }
            $UserModel = CustomersModel::where(['email' => $request->email])->first();
            if (!empty($UserModel)) {
                $name         = $UserModel->name;
                $email        = $UserModel->email;
                $data = array('email'=>$UserModel->email,'user_id'=>$UserModel->id,'name'=>$UserModel->firstname.' '.$UserModel->surname);
               
                $sent = Mail::send('emails.user_forgotpassword', $data, function($message) use ($email) {
                    $message->to($email)->subject('Forgot Password');
                });
                return back()->withErrors(["success" => __('customer.text_mail_send')]);
            }else{
                return back()->withErrors(['error' => __('customer.text_customer_not_exists'), 'emailid' => $request->email]);
              
            }
        }else{
            return view('front.forgotpassword');
        }

    }


    public function reset_password($id=""){
        return view('front.reset_password',compact('id'));
    }

    public function update_password(Request $request){
         $validator = Validator::make($request->all(), [

            'new_password'     => 'required',
            'confirm_password' => 'required_with:new_password|same:new_password|'

         ]);
         if ($validator->fails()){
            return back()->withErrors($validator)->withInput();
         }
        
         if($request->id > 0){

            $UpdateData['password']     =  Hash::make($request->confirm_password);
            CustomersModel::where(['id' => $request->id])->update($UpdateData);

            return redirect('/')->withErrors(["success" => __('customer.text_password').' '.__('customer.text_update_success')]);
           
         }
         else
         {
            return back();
         }
    }

    public function my_profile(){
        $common                  = array();
        $common['main_menu']     = 'My Profile';   
        $common['heading_title'] = 'My Profile'; 
       
        $cust_id      = Session::get('cust_id');
        $user         = array();
        $user_details = CustomersModel::where(['id' => $cust_id])->first();
        if($user_details) {
          $user['firstname']      = $user_details['firstname'];
          $user['familyname']     = $user_details['familyname'];
          $user['surname']        = $user_details['surname'];
          $user['profile_image']  = $user_details['profile_image'];
          $user['dob']            = $user_details['dob'];
          $user['gender']         = $user_details['gender'];
          $user['address']        = $user_details['address'];
          $user['zip_code']       = $user_details['zip_code'];
          $user['house_number']   = $user_details['house_number'];
          $user['phone_number']   = $user_details['phone_number'];
          $user['email']          = $user_details['email'];
          $user['country']        = $user_details['country'];
          $user['state']          = $user_details['state'];
          $user['city']           = $user_details['city'];
          $user['file']           = $user_details['file'];
          $user['role']           = $user_details['role'];

          ////Edutucation Source
          $user['education_source'] = array();
          $CustomerSchool = CustomerSchool::where('customer_id',$user_details['id'])->get();
          if(!$CustomerSchool->isEmpty()){
            foreach($CustomerSchool as $key => $value) {
               $edu_source                    = array(); 
               $edu_source['school_name']     = $value['school_name']; 
               $edu_source['school_address']  = $value['school_address']; 
               $edu_source['school_year']     = $value['school_year']; 
               
               $user['education_source'][] = $edu_source;
            }
          }


          /////Hiring History
          $user['hiring_history'] = array();
          $CustomerHiringHistory = CustomerHiringHistory::where('customer_id',$user_details['id'])->get();
          if(!$CustomerHiringHistory->isEmpty()){
            foreach($CustomerHiringHistory as $key => $value2) {
                $customer_hiring   = array();
                $customer_hiring['company_name']    = $value2['company_name'];
                $customer_hiring['company_address'] = $value2['company_address'];
                $customer_hiring['working_year']    = $value2['working_year'];
                
                $user['hiring_history'][]  = $customer_hiring;
            }
          }

          ////Experiance in Ablroad
          $user['exp_abroad'] = array();
          $CustomerExperiance = CustomerExperiance::where('customer_id',$user_details['id'])->get();
          if(!$CustomerExperiance->isEmpty()){
            foreach($CustomerExperiance as $key => $value3) {
                $customer_exp_abrod   = array();
                $customer_exp_abrod['company_name']    = $value3['company_name'];
                $customer_exp_abrod['company_address'] = $value3['company_address'];
                $customer_exp_abrod['working_year']    = $value3['working_year'];
                
                $user['exp_abroad'][]  = $customer_exp_abrod;
            }
          }

          ////Skills
          $user['skills'] = array();
          $SkillsModel = SkillsModel::where('customer_id',$user_details['id'])->get();
          if(!$SkillsModel->isEmpty()){
            foreach($SkillsModel as $key => $value4) {
                $customer_skill   = array();
                $customer_skill['skill']    = $value4['skill'];
                
                $user['skills'][]  = $customer_skill;
            }
          }


          ////Permissions
          $user['permission'] = array();
          $CustomerPermission = CustomerPermission::where('customer_id',$user_details['id'])->get();
          if(!$CustomerPermission->isEmpty()){
            foreach($CustomerPermission as $key => $value_per) {
                $customer_permission   = array();
                $customer_permission['permission']    = $value_per['permission'];
                
                $user['permission'][]  = $customer_permission;
            }
          }


           ////Langugaes
          $user['cust_language'] = array();
          $CustomerLanguage = CustomerLanguage::where('customer_id',$user_details['id'])->get();
          if(!$CustomerLanguage->isEmpty()){
            foreach($CustomerLanguage as $key => $value_lang) {
                $customer_language   = array();
                $customer_language['language']    = $value_lang['language'];
                
                $user['cust_language'][]  = $customer_language;
            }
          }


           ////Other Knowledge
          $user['other_knowledges'] = array();
          $CustomerOtherKnowledge = CustomerOtherKnowledge::where('customer_id',$user_details['id'])->get();
          if(!$CustomerOtherKnowledge->isEmpty()){
            foreach($CustomerOtherKnowledge as $key => $value_oth) {
                $customer_other   = array();
                $customer_other['other_knowledge']    = $value_oth['other_knowledge'];
                
                $user['other_knowledges'][]  = $customer_other;
            }
          }


          /////Intrest & Hobbies
          $user['hobbies'] = array();
          $HobbiesModel = HobbiesModel::where('customer_id',$user_details['id'])->get();
          if(!$HobbiesModel->isEmpty()){
            foreach($HobbiesModel as $key => $value5) {
                $customer_hobbies   = array();
                $customer_hobbies['hobby']    = $value5['hobby'];
                
                $user['hobbies'][]  = $customer_hobbies;
            }
          }

          /////Addition indo 
          $user['add_info'] = array();
          $CustomerInformation = CustomerInformation::where('customer_id',$user_details['id'])->get();
          if(!$CustomerInformation->isEmpty()){
            foreach($CustomerInformation as $key => $value_info) {
                $customer_info   = array();
                $customer_info['information']    = $value_info['information'];
                
                $user['add_info'][]  = $customer_info;
            }
          }


          /////Profession
          $user['professions'] = array();
          $CustomerProfession = CustomerProfession::where('customer_id',$user_details['id'])->get();
          if(!$CustomerProfession->isEmpty()){
            foreach($CustomerProfession as $key => $value6) {
                $customer_professions   = array();
                $customer_professions['profession_name']    = $value6['profession_name'];
                $customer_professions['profession_year']    = $value6['profession_year'];
                
                $user['professions'][]  = $customer_professions;
            }
          }  
        }
        

        return view('front.Profile.profile',compact('common','user'));
    }

    public function edit_profile(){
        $common                  = array();
        $common['main_menu']     = 'My Profile';   
        $common['heading_title'] = __('customer.text_edit_profile'); 

        $get_countries = CountryModel::get();
        $StateModel    = StateModel::get();
        $CityModel     = CityModel::get();
       
        $cust_id       = Session::get('cust_id');
        $user          = array();
        $user_details  = CustomersModel::where(['id' => $cust_id])->first();
        if($user_details) {
            $user['firstname']     = $user_details['firstname'];
            $user['familyname']    = $user_details['familyname'];
            $user['surname']       = $user_details['surname'];
            $user['profile_image'] = $user_details['profile_image'];
            $user['dob']           = $user_details['dob'];
            $user['gender']        = $user_details['gender'];
            $user['address']       = $user_details['address'];
            $user['zip_code']      = $user_details['zip_code'];
            $user['house_number']  = $user_details['house_no'];
            $user['phone_number']  = $user_details['phone_number'];
            $user['email']         = $user_details['email'];
            $user['country']       = $user_details['country'];

            $user['country_name']   = '';
            $get_country = CountryModel::where('id',$user_details['country'])->first();
            if ($get_country) {
                $user['country_name'] = $get_country['name'];  
            }

            $user['city_name']   = '';
            $get_city = CityModel::where('id',$user_details['city'])->first();
            if ($get_city) {
                $user['city_name'] = $get_city['name'];  
            }

            $user['state']         = $user_details['state'];
            $user['city']          = $user_details['city'];
            $user['file']          = $user_details['file'];
            $user['role']          = $user_details['role'];
            $user['files']         = $user_details['files'];
            $user['company_name']  = $user_details['company_name'];
            $user['tax_number']    = $user_details['tax_number'];
            $user['street']        = $user_details['street'];


            if($user_details['role'] == 'seeker'){
            
                $user['education']  = array();
                $CustomerSchool    =  CustomerSchool::where('customer_id',$cust_id)->get();
                foreach($CustomerSchool as $key => $value){
                    $education                   = array();
                    $education['school_name']    = $value['school_name'];
                    $education['school_address'] = $value['school_address'];
                    $education['school_year']    = $value['school_year'];
                   
                    $user['education'][]     = $education;
                }


                $skills        = array();
                $SkillsModel = SkillsModel::where('customer_id',$cust_id)->get();
                foreach($SkillsModel as $key => $value1){
                    $skills[]    = $value1['skill'];
                }
                    $user['skills']    = $skills;

                $hobbies      = array();
                $HobbiesModel = HobbiesModel::where('customer_id',$cust_id)->get();
                foreach($HobbiesModel as $key => $value2){
                    $hobbies[]         = $value2['hobby'];
                }
                $user['hobbies']       = $hobbies;

                $user['hiring_history'] = array();
                $CustomerHiringHistory = CustomerHiringHistory::where('customer_id',$cust_id)->get();
                foreach($CustomerHiringHistory as $key => $value3){
                    $hiring_history = array();
                    $hiring_history['company_name']    =  $value3['company_name'];
                    $hiring_history['company_address'] =  $value3['company_address'];
                    $hiring_history['working_year']    =  $value3['working_year'];
                   
                    $user['hiring_history'][]          = $hiring_history;
                }

                $user['experiance'] = array();
                $CustomerExperiance = CustomerExperiance::where('customer_id',$cust_id)->get();
                foreach($CustomerExperiance as $key => $value4){
                    $experiance     = array();
                    $experiance['company_name']    = $value4['company_name'];
                    $experiance['company_address'] = $value4['company_address'];
                    $experiance['working_year']    = $value4['working_year'];

                    $user['experiance'][] = $experiance;
                    
                }


                $user['profession'] = array();
                $CustomerProfession = CustomerProfession::where('customer_id',$cust_id)->get();
                foreach($CustomerProfession as $key => $value6){
                    $profession     = array();
                    $profession['profession_name']    = $value6['profession_name'];
                    $profession['profession_year'] = $value6['profession_year'];

                    $user['profession'][] = $profession;
                    
                }

                // Customer Permission
                $user['permission'] = array();
                $CustomerPermission = CustomerPermission::where('customer_id',$cust_id)->get();
                foreach($CustomerPermission as $key => $value7){
                    $permission     = array();
                    $permission['permission'] = $value7['permission'];

                    $user['permission'][] = $permission;
                    
                }

                // Customer Other knowledge
                $user['others'] = array();
                $CustomerOtherKnowledge = CustomerOtherKnowledge::where('customer_id',$cust_id)->get();
                foreach($CustomerOtherKnowledge as $key => $value8){
                    $others     = array();
                    $others['other_knowledge'] = $value8['other_knowledge'];

                    $user['others'][] = $others;
                    
                }

                // Customer langgage
                $user['cust_languages'] = array();
                $CustomerLanguage = CustomerLanguage::where('customer_id',$cust_id)->get();
                foreach($CustomerLanguage as $key => $value9){
                    $cust_languages     = array();
                    $cust_languages['language']    = $value9['language'];

                    $user['cust_languages'][] = $cust_languages;
                    
                }

                // Customer Add info
                $user['add_info'] = array();
                $CustomerInformation = CustomerInformation::where('customer_id',$user_details['id'])->get();
                if(!$CustomerInformation->isEmpty()){
                    foreach($CustomerInformation as $key => $value_info) {
                        $customer_info   = array();
                        $customer_info['information']    = $value_info['information'];

                        $user['add_info'][]  = $customer_info;
                    }
                }

            }
        }
        return view('front.Profile.edit_profile',compact('common','user','get_countries','StateModel','CityModel'));
    }

    public function update_profile(Request $request){

        $data     = $request->all();
        $cust_id  = Session::get('cust_id');
        if($cust_id != ''){
            $UpdateData                 = array();
            $UpdateData['firstname']    = $data['firstname'];
            // $UpdateData['surname']      = $data['surname'];
            $UpdateData['familyname']   = $data['familyname'];
            $UpdateData['country']      = $data['country'];
            $UpdateData['state']        = $data['state'];
            $UpdateData['city']         = $data['city'];
            $UpdateData['zip_code']     = $data['zip_code'];
            // $UpdateData['house_number'] = $data['house_number'];
            $UpdateData['phone_number'] = $data['phone_number'];
            // $UpdateData['address']      = $data['address'];
            
             if($request->hasFile('files')) {
                $random_no  = uniqid();
                $img = $request->file('files');
                $ext = $img->getClientOriginalExtension();
                $new_name = $random_no . '.' . $ext;
                $destinationPath =  public_path('uploads');
                $img->move($destinationPath, $new_name);
                $UpdateData['file'] = $new_name;
                
            }



            if($request->file('prof_img')){
                $random_no  = uniqid();
                $img = $data['prof_img'];
                $ext = $img->getClientOriginalExtension();
                $new_name  = $random_no . '.' . $ext;
                if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg') {
                    $destinationPath  =  public_path('profile');
                    $img->move($destinationPath, $new_name);
                    $UpdateData['profile_image'] = $new_name;
                }
            }
            CustomersModel::where(['id' => $cust_id])->update($UpdateData);
            $user_details  = CustomersModel::where(['id' => $cust_id])->first();

            
            if($user_details['role'] == "seeker"){
                ///Education
                if(count($request->school_name)>0){
                    CustomerSchool::where('customer_id',$cust_id)->delete();
                    foreach($request->school_name as $key => $school){
                        if($school !=""){
                            $CustomerSchool   = new CustomerSchool();
                            $CustomerSchool->customer_id      = $cust_id;
                            $CustomerSchool->school_name      = $school;
                            $CustomerSchool->school_address   = $request->school_address[$key];
                            $CustomerSchool->school_year      = $request->school_year[$key];
                            $CustomerSchool->save();
                        }
     
                    }
                }

                ///Customer Skills
                if(count($request->skills)>0){
                    SkillsModel::where('customer_id',$cust_id)->delete();
                    foreach($request->skills as $key => $skill){
                        if($skill !=""){
                            $SkillsModel                  = new SkillsModel();
                            $SkillsModel->customer_id     = $cust_id;
                            $SkillsModel->skill           = $skill;
                            $SkillsModel->save();

                        }
                    }
                }

                //Customer Hobbies
                if(count($request->hobbies)>0){
                    HobbiesModel::where('customer_id',$cust_id)->delete();
                    foreach($request->hobbies as $key => $hobby){
                        if($hobby !=""){
                            $HobbiesModel                  = new HobbiesModel();
                            $HobbiesModel->customer_id     = $cust_id;
                            $HobbiesModel->hobby           = $hobby;
                            $HobbiesModel->save();

                        }
                    }
                }


                ///Customer Hiring History
                if(count($request->company_name)>0){
                    CustomerHiringHistory::where('customer_id',$cust_id)->delete();
                    foreach($request->company_name as $key => $company_name){
                        if($company_name !=""){
                            $CustomerHiringHistory                  = new CustomerHiringHistory();
                            $CustomerHiringHistory->customer_id     = $cust_id;
                            $CustomerHiringHistory->company_name    = $company_name;
                            $CustomerHiringHistory->company_address = $request->company_address[$key];
                            $CustomerHiringHistory->working_year    = $request->working_years[$key];
                            $CustomerHiringHistory->save();

                        }
                    }
                }

                 ///Customer Expirience in Abroad
                if(count($request->hr_cmp_name)>0){
                    CustomerExperiance::where('customer_id',$cust_id)->delete();
                    foreach($request->hr_cmp_name as $key => $hr_cmp_name){
                        if($hr_cmp_name !=""){
                            $CustomerExperiance                  = new CustomerExperiance();
                            $CustomerExperiance->customer_id     = $cust_id;
                            $CustomerExperiance->company_name    = $hr_cmp_name;
                            $CustomerExperiance->company_address = $request->cmp_address[$key];
                            $CustomerExperiance->working_year    = $request->wrking_years[$key];
                            $CustomerExperiance->save();

                        }
                    }
                }

                ///Profession
                if(count($request->profs_name)>0){
                    CustomerProfession::where('customer_id',$cust_id)->delete();
                    foreach($request->profs_name as $key => $profs_name){
                        if($profs_name !=""){
                            $CustomerProfession                  = new CustomerProfession();
                            $CustomerProfession->customer_id     = $cust_id;
                            $CustomerProfession->profession_name = $profs_name;
                            $CustomerProfession->profession_year = $request->profs_years[$key];
                            $CustomerProfession->save();

                        }
                    }
                }


                ///Permission
                if(count($request->permission)>0){
                    CustomerPermission::where('customer_id',$cust_id)->delete();
                    foreach($request->permission as $key => $permission){
                        if($permission !=""){
                            $CustomerPermission                  = new CustomerPermission();
                            $CustomerPermission->customer_id     = $cust_id;
                            $CustomerPermission->permission      = $permission;
                            $CustomerPermission->save();

                        }
                    }
                }


                ///Customer Information
                if(count($request->information)>0){
                    CustomerInformation::where('customer_id',$cust_id)->delete();
                    foreach($request->information as $key => $information){
                        if($information !=""){
                            $CustomerInformation                  = new CustomerInformation();
                            $CustomerInformation->customer_id     = $cust_id;
                            $CustomerInformation->information     = $information;
                            $CustomerInformation->save();

                        }
                    }
                }


                ///LAnguages
                if(count($request->languages)>0){
                    CustomerLanguage::where('customer_id',$cust_id)->delete();
                    foreach($request->languages as $key =>$value){
                        if($value !=""){
                            $CustomerLanguage              = new CustomerLanguage();
                            $CustomerLanguage->customer_id = $cust_id;
                            $CustomerLanguage->language    = $value;
                           $CustomerLanguage->save();
                        }
                    }
                }
                
                ///Other Knowledge
                if(count($request->other_knowledge)>0){
                    CustomerOtherKnowledge::where('customer_id',$cust_id)->delete();
                    foreach($request->other_knowledge as $key =>$knowledge){
                        if($knowledge !=""){
                            $other_knowledge                     = new CustomerOtherKnowledge();
                            $other_knowledge->customer_id        = $cust_id;
                            $other_knowledge->other_knowledge    = $knowledge;
                            $other_knowledge->save();
                        }
                    }
                }



            }
          
            return redirect('my-profile')->withErrors(['success'=> __('customer.text_profile').' '.__('customer.text_update_success')]);
             
        }

    }

    public function changepassword(Request $request){

        $common                   = array();
        $common['main_menu']      = 'My Profile';
        $common['heading_title']  = __('customer.text_change_pass');

        $cust_id = Session::get('cust_id');
        $user = array();
        $user_details = CustomersModel::where(['id' => $cust_id])->first();
        if ($user_details) {
          $user['firstname']     = $user_details['firstname'];
          $user['surname']       = $user_details['surname'];
          $user['profile_image'] = $user_details['profile_image'];
          $user['role']          = $user_details['role'];
          $user['email']         = $user_details['email'];
        }

        if ($request->isMethod('post')){
          $validation = Validator::make($request->all(), [
              'current_password'    => 'required',
              'new_password'        => 'required',
              'confirm_password'    => 'required_with:new_password|same:new_password',
          ]);

          if ($validation->fails()) {
              return back()->withErrors($validation)->withInput();
          }

          $id        =  Session::get('cust_id');
          $user_data = CustomersModel::where(['id' => $id ])->first();          
          if (Hash::check($request->current_password, $user_data->password)) {
              $UpdateData['password']     =  Hash::make($request->confirm_password);
              CustomersModel::where(['id' => $id])->update($UpdateData);
              return redirect('my-profile')->withErrors(['success' => __('customer.text_password').' '.__('customer.text_update_success')]);
          }else{
             return back()->withErrors(['error' => __('customer.text_pass_wrong')]);
          }
              
        }
        return view('front.Profile.change_password',compact('common','user'));
    } 


    public function logout(Request $request){
        $request->session()->flush();
        return redirect('/login');
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

    public function verification_account(Request $request){
    
        $cust_id = Session::get('cust_id');
        $CountryModel = CountryModel::get();
        $CityModel    = CityModel::get();
        
        $customers = array();
        $customers['id'] = '';
        
        if ($cust_id!='') {
          $Customer = CustomersModel::where(['id' => $cust_id])->first();
          $customers['id']           = $Customer['id'];
          $customers['familyname']   = $Customer['familyname'];
          $customers['firstname']    = $Customer['firstname'];
          $customers['surname']      = $Customer['surname'];
          $customers['nick_name']    = $Customer['nick_name'];
          $customers['dob']          = $Customer['dob'];
          $customers['gender']       = $Customer['gender'];
          $customers['company_name'] = $Customer['company_name'];
          $customers['role']         = $Customer['role'];
          $customers['nationality']  = $Customer['nationality'];
          $customers['country']      = $Customer['country'];
          $customers['state']        = $Customer['state'];
          $customers['city']         = $Customer['city'];

          $customers['city_name']    = '';
          $get_city = CityModel::where('id',$Customer['city'])->first();
          if ($get_city) {
            $customers['city_name']  = $get_city['name'];
          }

          $customers['street']       = $Customer['street'];
          $customers['zipcode']      = $Customer['zip_code'];
          $customers['house_number'] = $Customer['house_number'];
          $customers['phone_no']     = $Customer['phone_number'];
          $customers['email']        = $Customer['email'];
          
        }
        return view('front.verfication_account',compact('CountryModel','CityModel','customers'));
    }


    public function save_verfication_account(Request $request){

        $cust_id = Session::get('cust_id');
        $CountryModel = CountryModel::get();

        if($request->isMethod('post')){

            $req_fields = array(
                'name'              => 'required',
                'familyname'        => 'required',
                'email'             => 'required',
                'dob'               => 'required',
                'gender'            => 'required',
                'phone_no'          => 'required',
                'street'            => 'required',
                'zipcode'           => 'required',
                'personal_country'  => 'required',
                'nationality'       => 'required',
                // 'education'         => 'required',
                'files'             => 'required',
                'profile_image'     => 'required',
                'salary_expectaion' => 'required',
                'search_country'    => 'required',
                'rules'             => 'required',
                'gdpr'              => 'required',
                'accept_term'       => 'required',
            );
                
            $validator = Validator::make(
                $request->all(),
                $req_fields
            );
            
            if ($validator->fails()) {
                return response()->json(array('error'=>$validator->getMessageBag()->toArray(),));
            }

            if (Session::get('role') == 'seeker' AND Session::get('is_setup') == '0'){
            
                $customer_id = $cust_id;
                $CustomersModel                       =   CustomersModel::find($customer_id);
                $CustomersModel->firstname            =   $request->name; 
                $CustomersModel->familyname           =   $request->familyname; 
                $CustomersModel->email                =   $request->email; 
                $CustomersModel->dob                  =   $request->dob; 
                $CustomersModel->gender               =   $request->gender; 
                $CustomersModel->phone_number         =   $request->phone_no; 
                $CustomersModel->street               =   $request->street; 
                $CustomersModel->zip_code             =   $request->zipcode; 
                $CustomersModel->personal_country     =   $request->personal_country; 
                $CustomersModel->nationality          =   $request->nationality; 
                $CustomersModel->salary_expectation   =   $request->salary_expectaion; 
                $CustomersModel->available            =   $request->available; 
                $CustomersModel->search_country       =   $request->search_country; 
                $CustomersModel->is_setup             =   1; 


                if($request->hasFile('files')) {
                    $random_no  = uniqid();
                    $img = $request->file('files');
                    $ext = $img->getClientOriginalExtension();
                    $new_name = $random_no . '.' . $ext;
                    $destinationPath =  public_path('uploads');
                    $img->move($destinationPath, $new_name);
                    $CustomersModel->file = $new_name;
                    
                }
                if($request->hasFile('profile_image')) {
                    $random_no  = uniqid();
                    $img = $request->file('profile_image');
                    $ext = $img->getClientOriginalExtension();
                    $new_name = $random_no . '.' . $ext;
                    $destinationPath =  public_path('profile');
                    $img->move($destinationPath, $new_name);
                    $CustomersModel->profile_image = $new_name;
                    
                }

                $CustomersModel->update();
                $request->session()->put('is_setup', '1');

                
                ///LAnguages
                if(count($request->languages)>0){
                    foreach($request->languages as $key =>$value){
                        if($value !=""){
                            $CustomerLanguage              = new CustomerLanguage();
                            $CustomerLanguage->customer_id = $customer_id;
                            $CustomerLanguage->language    = $value;
                           $CustomerLanguage->save();
                        }
                    }
                }
                
                ///Other Knowledge
                if(count($request->other_knowledge)>0){
                    foreach($request->other_knowledge as $key =>$knowledge){
                        if($knowledge !=""){
                            $other_knowledge                     = new CustomerOtherKnowledge();
                            $other_knowledge->customer_id        = $customer_id;
                            $other_knowledge->other_knowledge    = $knowledge;
                            $other_knowledge->save();
                        }
                    }
                }
                

                ///Education
                // if(count($request->education)>0){
                //     foreach($request->education as $key => $education){
                //         if($education !=""){
                //             $CustomerEducation = new CustomerEducation();
                //             $CustomerEducation->customer_id = $customer_id;
                //             $CustomerEducation->education   = $education;
                //             $CustomerEducation->save();
                //         }
                //     }
                // }


                ////School Detail
                if(count($request->school_name)>0){
                    foreach($request->school_name as $key => $school){
                        if($school !=""){
                            $CustomerSchool   = new CustomerSchool();
                            $CustomerSchool->customer_id      = $customer_id;
                            $CustomerSchool->school_name      = $school;
                            $CustomerSchool->school_address   = $request->school_address[$key];
                            $CustomerSchool->school_year      = $request->school_year[$key];
                            $CustomerSchool->save();
                        }
     
                    }
                }


                /////Professions
                if(count($request->profession_name)>0){
                    foreach($request->profession_name as $key => $profession){
                        if($profession !=""){
                            $CustomerProfession   = new CustomerProfession();
                            $CustomerProfession->customer_id       = $customer_id;
                            $CustomerProfession->profession_name   = $profession;
                            $CustomerProfession->profession_year   = $request->profession_year[$key];
                            $CustomerProfession->save();
                        }
     
                    }
                }
                 


                ///Customer Hiring History
                if(count($request->company_name)>0){
                    foreach($request->company_name as $key => $company_name){
                        if($company_name !=""){
                            $CustomerHiringHistory                  = new CustomerHiringHistory();
                            $CustomerHiringHistory->customer_id     = $customer_id;
                            $CustomerHiringHistory->company_name    = $company_name;
                            $CustomerHiringHistory->company_address = $request->company_address[$key];
                            $CustomerHiringHistory->working_year    = $request->working_years[$key];
                            $CustomerHiringHistory->save();

                        }
                    }
                }


                ///Customer Expirience in Abroad
                if(count($request->exp_company_name)>0){
                    foreach($request->exp_company_name as $key => $exp_company_name){
                        if($exp_company_name !=""){
                            $CustomerExperiance                  = new CustomerExperiance();
                            $CustomerExperiance->customer_id     = $customer_id;
                            $CustomerExperiance->company_name    = $exp_company_name;
                            $CustomerExperiance->company_address = $request->exp_company_address[$key];
                            $CustomerExperiance->working_year    = $request->exp_wrking_years[$key];
                            $CustomerExperiance->save();

                        }
                    }
                }    



                ////Customer PErmission 
                if(count($request->permission)>0){
                    foreach($request->permission as $key => $permission){
                        if($permission !=""){
                            $CustomerPermission                  = new CustomerPermission();
                            $CustomerPermission->customer_id     = $customer_id;
                            $CustomerPermission->permission      = $permission;
                            $CustomerPermission->save();

                        }
                    }
                }
                


                ///Customer Skills
                if(count($request->skills)>0){
                    foreach($request->skills as $key => $skill){
                        if($skill !=""){
                            $SkillsModel                  = new SkillsModel();
                            $SkillsModel->customer_id     = $customer_id;
                            $SkillsModel->skill           = $skill;
                            $SkillsModel->save();

                        }
                    }
                }


                ///Customer Hobbies
                if(count($request->hobbies)>0){
                    foreach($request->hobbies as $key => $hobby){
                        if($hobby !=""){
                            $HobbiesModel                  = new HobbiesModel();
                            $HobbiesModel->customer_id     = $customer_id;
                            $HobbiesModel->hobby           = $hobby;
                            $HobbiesModel->save();

                        }
                    }
                }

                ///Customer Information
                if(count($request->information)>0){
                    foreach($request->information as $key => $information){
                        if($information !=""){
                            $CustomerInformation                  = new CustomerInformation();
                            $CustomerInformation->customer_id     = $customer_id;
                            $CustomerInformation->information     = $information;
                            $CustomerInformation->save();

                        }
                    }
                }
            }
            return redirect('dashboard')->withErrors(['success' => __('customer.text_login_success')]);
        }    
    }

}
