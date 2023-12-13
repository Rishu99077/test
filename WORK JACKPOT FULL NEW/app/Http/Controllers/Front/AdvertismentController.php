<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Session;

use App\Models\UserModel;
use App\Models\LanguagesModel;
use App\Models\CustomersModel;
use App\Models\CountryModel;
use App\Models\CityModel;
use App\Models\StateModel;
use App\Models\AdvertismentModel;
use App\Models\AdvertismentContract;
use App\Models\JobsModel;


class AdvertismentController extends Controller{

    public function add_advertisment(Request $request,$id=""){

        $common = array();
        $common['main_menu']     = 'Work Management';
        $common['heading_title'] = __('customer.text_work_managment');
        $AdvertismentModel       = array();
        $get_advertisment        = array();
        $customer_id             = Session::get('cust_id');
        $CountryModel            = CountryModel::get();

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
            $data['customer_id']  = $customer_id;
            
            foreach($data as $key => $value) {
                $Advertisment->$key = $value;
            }
            $Advertisment->save();
            return back()->withErrors(["success" => $message]);
        }
        if($id!=""){
           $get_advertisment = AdvertismentModel::where('id',$id)->where('customer_id',$customer_id)->first();
           if(empty($get_advertisment)){
             return back()->withErrors(["error" => __('customer.text_data_not_found')]);
           } 
            
        }
        return view('front.Advertisment.add_advertisment',compact('common','CountryModel','get_advertisment'));  
    }




    ////Advertisement Detail
    public function advertisment_detail($id){
        $common = array();
        $get_adv_check = array();
        $get_advertisment = array();

        $common['heading_title'] = 'Advertisement Detail';
        $customer_id             = Session::get('cust_id');
        $user                    = CustomersModel::where(['id' => $customer_id])->first();
        
        if($user['role'] == "provider"){
          $common['main_menu']     = 'Dashboard';
        }else{
          $common['main_menu']     = 'Work Management';
        }
        $get_advertisment        = AdvertismentModel::where('id',$id)->first();
        if(!$get_advertisment){
                return back();
        }
        $get_adv_check   = AdvertismentContract::where('customer_id',$customer_id)->where('advertisment_id',$id)->first();




        /////seeker
        $order_by = "id";
        $sort_by  = "Desc";
        $get_company_appliers    = array(); 
        $AdvertismentContract    = AdvertismentContract::select('advertisment_contracts.*')
                                        ->leftjoin('customers','customers.id','advertisment_contracts.customer_id')
                                        ->leftjoin('countries','countries.id','customers.country');
                                        
        
       
        // if(@$_GET['search_everything']){
        //     $search = @$_GET['search_everything'];
        //     $AdvertismentContract->where('company_name','like', "%".$search."%");
        // }
        
        $get_advertisment_contract = $AdvertismentContract->where('advertisment_id',$id)->orderBy($order_by,$sort_by)->get();
        if(!$get_advertisment_contract->isEmpty()){
            foreach($get_advertisment_contract as $key => $value) {
                $get_applier = array();
                $get_applier['advertisment_id'] = $value['advertisment_id'];
                $get_applier['customer_id']     = $value['customer_id'];
                $get_applier['id']              = $value['id'];
                $provider                       = CustomersModel::where(['id' => $get_applier['customer_id']])->first();
                $get_applier['company_name']    = $provider['company_name'];
                
                $CountryModel = CountryModel::where('id',$provider['country'])->first();
                if($CountryModel){
                  $get_applier['country'] = $CountryModel['name'];
                }
                $get_applier['created_at']  = date('d/m/Y',strtotime($value['created_at']));
                $get_applier['date']        = JobsModel::newtimeago($value['created_at']);
                $get_company_appliers[]     = $get_applier;
            }
        }

        return view('front.Advertisment.advertisement_detail',compact('common','get_advertisment','get_adv_check','user','get_company_appliers'));  
    }


    ///Add Adv Contract 
    public function advertisment_contract(Request $request){
        $response           = array();
        $response['status'] = false;
        $customer_id        = Session::get('cust_id');
        if($request->id !=""){
            $id  = $request->id;
            $get_advertisment = AdvertismentModel::where('id',$id)->first();
            if($get_advertisment){
                $AdvertismentContract = new AdvertismentContract();
                $AdvertismentContract->customer_id       = $customer_id;
                $AdvertismentContract->advertisment_id   = $id;
                $AdvertismentContract->save();
                $response['status']  = true;
                $response['message'] = __('customer.text_contracts').' '. __('customer.text_add_success');
            }else{
                $response['message'] = __('customer.text_advertisment').' '. __('customer.text_not_found');
            }

        }else{

            $response['message'] = __('customer.text_data_not_found');
        }
        return json_encode($response);
    }


    ///Company Appliers List 
    public function advertisment_appliers($id){
        $common = array();
        $get_advertisment = array();
        
        $common['main_menu']     = 'Work Management';
        $common['heading_title'] = __('customer.text_work_managment');
        $customer_id             = Session::get('cust_id');
        $user                    = CustomersModel::where(['id' => $customer_id])->first();

        
        $order_by = "id";
        $sort_by  = "Desc";
        $get_company_appliers    = array(); 
        $AdvertismentContract    = AdvertismentContract::select('advertisment_contracts.*')
                                        ->leftjoin('customers','customers.id','advertisment_contracts.customer_id')
                                        ->leftjoin('countries','countries.id','customers.country');
                                        
        
       
        if(@$_GET['search_everything']){
            $search = @$_GET['search_everything'];
            $AdvertismentContract->where('company_name','like', "%".$search."%");
        }

        if(@$_GET['company_no']){
            $search = @$_GET['company_no'];
            $AdvertismentContract->where('company_name','like', "%".$search."%");
        }
        if(@$_GET['offer_no']){
            $search = @$_GET['offer_no'];
            $AdvertismentContract->where('advertisment_id','=',$search);
        }
        if(@$_GET['location']){
           $search = @$_GET['location'];
           $AdvertismentContract->where('countries.name','=',$search); 
        }

        if(@$_GET['sort']){
            $sort = $_GET['sort'];
           if($sort == "name"){
             $order_by = "customers.company_name";
             $sort_by  = "Asc";
           }
           if($sort =="date"){
             $order_by = "advertisment_contracts.created_at";
             $sort_by  = "Descs";
           }
        }
        
        $get_advertisment        = AdvertismentModel::where('id',$id)->first();
        if(!$get_advertisment){
                return back();
        }


        $get_advertisment_contract = $AdvertismentContract->where('advertisment_id',$id)->orderBy($order_by,$sort_by)->get();
        if(!$get_advertisment_contract->isEmpty()){
            foreach($get_advertisment_contract as $key => $value) {
                $get_applier = array();
                $get_applier['advertisment_id'] = $value['advertisment_id'];
                $get_applier['customer_id']     = $value['customer_id'];
                $get_applier['id']              = $value['id'];
                $provider                       = CustomersModel::where(['id' => $get_applier['customer_id']])->first();
                $get_applier['company_name']    = $provider['company_name'];
                
                $CountryModel = CountryModel::where('id',$provider['country'])->first();
                if($CountryModel){
                  $get_applier['country'] = $CountryModel['name'];
                }
                $get_applier['created_at']  = date('d/m/Y',strtotime($value['created_at']));
                $get_applier['date']        = JobsModel::newtimeago($value['created_at']);
                $get_company_appliers[]     = $get_applier;
            }
        }

        return view('front.WorkManagement.Reports.adv_appliers',compact('common','user','get_company_appliers','get_advertisment'));
    }

    
}
