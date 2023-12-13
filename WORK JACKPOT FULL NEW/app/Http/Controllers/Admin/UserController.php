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
use App\Models\CountryModel;
use App\Models\CityModel;
use App\Models\StateModel;

use App\Models\CustomersModel;
use App\Models\CustomerSchool;
use App\Models\SkillsModel;
use App\Models\HobbiesModel;
use App\Models\CustomerHiringHistory;
use App\Models\CustomerExperiance;
use App\Models\CustomerProfession;
use App\Models\CustomerLanguage;
use App\Models\CustomerOtherKnowledge;
use App\Models\CustomerEducation;
use App\Models\CustomerPermission;
use App\Models\CustomerInformation;

class UserController extends Controller{


    public function customers(){
    	$common                  = array();
        $common['main_menu']     = 'customers';
        $common['sub_menu']      = 'customers';
        $common['heading_title'] = __('admin.text_all_customers');
        $user    = array();
        $user_id = Session::get('user_id');
        $user    = UserModel::where(['id' => $user_id])->first();
       
        $get_customers = CustomersModel::where(['role'=>'seeker'])->orderBy('id','Desc')->paginate(10);

        
        return view('admin.Customer.customers',compact('common','get_customers','user'));
    }

    public function customer_edit($id=""){
        $common = array();
        $common['main_menu']     = 'customers';
        $common['sub_menu']      = 'customers';
        $common['heading_title'] = __('admin.text_edit_customers');

        $user                    = array();
        $customer                = array();
        $user_id                 = Session::get('user_id');
        $user                    = UserModel::where(['id' => $user_id])->first();
        

        $get_countries           = CountryModel::get();
        $StateModel              = StateModel::get();
        $CityModel               = CityModel::get();

        
        $user_details  = CustomersModel::where(['id' => $id])->first()->toArray();

        if ($user_details['role']=='customers') {
            $common['main_menu']     = 'customers';
        }elseif($user_details['role']=='providers'){
            $common['main_menu']     = 'providers';

        }

      

        if($user_details){
            $customer['id']            = $user_details['id'];
            $customer['firstname']     = $user_details['firstname'];
            $customer['surname']       = $user_details['surname'];
            $customer['profile_image'] = $user_details['profile_image'];
            $customer['dob']           = $user_details['dob'];
            $customer['gender']        = $user_details['gender'];
            $customer['address']       = $user_details['address'];
            $customer['zip_code']      = $user_details['zip_code'];
            $customer['house_number']  = $user_details['house_no'];
            $customer['phone_number']  = $user_details['phone_number'];
            $customer['email']         = $user_details['email'];
            $customer['country']       = $user_details['country'];
            $customer['state']         = $user_details['state'];
            $customer['city']          = $user_details['city'];
            $customer['file']          = $user_details['file'];
            $customer['role']          = $user_details['role'];
            $customer['files']         = $user_details['files'];


            if($user_details['role'] == 'seeker'){
            
                $customer['education']  = array();
                $CustomerSchool         =  CustomerSchool::where('customer_id',$id)->get();
                foreach($CustomerSchool as $key => $value){
                    $education                   = array();
                    $education['school_name']    = $value['school_name'];
                    $education['school_address'] = $value['school_address'];
                    $education['school_year']    = $value['school_year'];
                   
                    $customer['education'][]     = $education;
                }


                $skills        = array();
                $SkillsModel = SkillsModel::where('customer_id',$id)->get();
                foreach($SkillsModel as $key => $value1){
                    $skills[]    = $value1['skill'];
                }
                    $customer['skills']    = $skills;

                $hobbies      = array();
                $HobbiesModel = HobbiesModel::where('customer_id',$id)->get();
                foreach($HobbiesModel as $key => $value2){
                    $hobbies[]         = $value2['hobby'];
                }
                $customer['hobbies']       = $hobbies;

                $customer['hiring_history'] = array();
                $CustomerHiringHistory = CustomerHiringHistory::where('customer_id',$id)->get();
                foreach($CustomerHiringHistory as $key => $value3){
                    $hiring_history = array();
                    $hiring_history['company_name']    =  $value3['company_name'];
                    $hiring_history['company_address'] =  $value3['company_address'];
                    $hiring_history['working_year']    =  $value3['working_year'];
                   
                    $customer['hiring_history'][]          = $hiring_history;
                }

                $customer['experiance'] = array();
                $CustomerExperiance = CustomerExperiance::where('customer_id',$id)->get();
                foreach($CustomerExperiance as $key => $value4){
                    $experiance     = array();
                    $experiance['company_name']    = $value4['company_name'];
                    $experiance['company_address'] = $value4['company_address'];
                    $experiance['working_year']    = $value4['working_year'];

                    $customer['experiance'][] = $experiance;
                    
                }


                $customer['profession'] = array();
                $CustomerProfession = CustomerProfession::where('customer_id',$id)->get();
                foreach($CustomerProfession as $key => $value6){
                    $profession     = array();
                    $profession['profession_name']    = $value6['profession_name'];
                    $profession['profession_year'] = $value6['profession_year'];

                    $customer['profession'][] = $profession;
                    
                }


                // Customer Permission
                $customer['permission'] = array();
                $CustomerPermission = CustomerPermission::where('customer_id',$id)->get();
                foreach($CustomerPermission as $key => $value7){
                    $permission     = array();
                    $permission['permission'] = $value7['permission'];

                    $customer['permission'][] = $permission;
                    
                }

                // Customer Other knowledge
                $customer['others'] = array();
                $CustomerOtherKnowledge = CustomerOtherKnowledge::where('customer_id',$id)->get();
                foreach($CustomerOtherKnowledge as $key => $value8){
                    $others     = array();
                    $others['other_knowledge'] = $value8['other_knowledge'];

                    $customer['others'][] = $others;
                    
                }

                // Customer langgage
                $customer['cust_languages'] = array();
                $CustomerLanguage = CustomerLanguage::where('customer_id',$id)->get();
                foreach($CustomerLanguage as $key => $value9){
                    $cust_languages     = array();
                    $cust_languages['language']    = $value9['language'];

                    $customer['cust_languages'][] = $cust_languages;
                    
                }

                // Customer Add info
                $customer['add_info'] = array();
                $CustomerInformation = CustomerInformation::where('customer_id',$id)->get();
                if(!$CustomerInformation->isEmpty()){
                    foreach($CustomerInformation as $key => $value_info) {
                        $customer_info   = array();
                        $customer_info['information']    = $value_info['information'];

                        $customer['add_info'][]  = $customer_info;
                    }
                }

            }
        }
        return view('admin.Customer.edit_customer',compact('common','user','customer','get_countries','StateModel','CityModel')); 
    }

    public function save_customer(Request $request){
        $user_id = Session::get('user_id');
        $user_details = UserModel::where(['id' => $user_id])->first();

        $data = $request->all();

        $validation = Validator::make($request->all(), [
            'email'            => 'required',
        ]);

        if ($validation->fails()) {
          return back()->withErrors($validation)->withInput();
        }

        $CustID = $request->CustID;
    
        if($CustID!='') {
            $get_customer = CustomersModel::where(['id' => $CustID])->first();
            $CustID       = $get_customer['id'];

            $UpdateData = array();
			$UpdateData['firstname']    = $data['firstname'];
			$UpdateData['surname']      = $data['surname'];
			// $UpdateData['nick_name']    = $data['nick_name'];
			$UpdateData['country']      = $data['country'];
			$UpdateData['state']        = $data['state'];
			$UpdateData['city']         = $data['city'];
			$UpdateData['address']      = $data['address'];
			$UpdateData['zip_code']     = $data['zip_code'];
			// $UpdateData['house_number'] = $data['house_number'];
			$UpdateData['phone_number'] = $data['phone_number'];
            // $UpdateData['role']         = $data['role'];
			$UpdateData['email']        = $data['email'];

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


            CustomersModel::where(['id' => $CustID])->update($UpdateData);

            if ($data['role']=='seeker') {
                ///Education
                if(count($request->school_name)>0){
                    CustomerSchool::where('customer_id',$CustID)->delete();
                    foreach($request->school_name as $key => $school){
                        if($school !=""){
                            $CustomerSchool   = new CustomerSchool();
                            $CustomerSchool->customer_id      = $CustID;
                            $CustomerSchool->school_name      = $school;
                            $CustomerSchool->school_address   = $request->school_address[$key];
                            $CustomerSchool->school_year      = $request->school_year[$key];
                            $CustomerSchool->save();
                        }
     
                    }
                }

                ///Customer Skills
                if(count($request->skills)>0){
                    SkillsModel::where('customer_id',$CustID)->delete();
                    foreach($request->skills as $key => $skill){
                        if($skill !=""){
                            $SkillsModel                  = new SkillsModel();
                            $SkillsModel->customer_id     = $CustID;
                            $SkillsModel->skill           = $skill;
                            $SkillsModel->save();

                        }
                    }
                }

                //Customer Hobbies
                if(count($request->hobbies)>0){
                    HobbiesModel::where('customer_id',$CustID)->delete();
                    foreach($request->hobbies as $key => $hobby){
                        if($hobby !=""){
                            $HobbiesModel                  = new HobbiesModel();
                            $HobbiesModel->customer_id     = $CustID;
                            $HobbiesModel->hobby           = $hobby;
                            $HobbiesModel->save();

                        }
                    }
                }


                ///Customer Hiring History
                if(count($request->company_name)>0){
                    CustomerHiringHistory::where('customer_id',$CustID)->delete();
                    foreach($request->company_name as $key => $company_name){
                        if($company_name !=""){
                            $CustomerHiringHistory                  = new CustomerHiringHistory();
                            $CustomerHiringHistory->customer_id     = $CustID;
                            $CustomerHiringHistory->company_name    = $company_name;
                            $CustomerHiringHistory->company_address = $request->company_address[$key];
                            $CustomerHiringHistory->working_year    = $request->working_years[$key];
                            $CustomerHiringHistory->save();

                        }
                    }
                }

                 ///Customer Expirience in Abroad
                if(count($request->hr_cmp_name)>0){
                    CustomerExperiance::where('customer_id',$CustID)->delete();
                    foreach($request->hr_cmp_name as $key => $hr_cmp_name){
                        if($hr_cmp_name !=""){
                            $CustomerExperiance                  = new CustomerExperiance();
                            $CustomerExperiance->customer_id     = $CustID;
                            $CustomerExperiance->company_name    = $hr_cmp_name;
                            $CustomerExperiance->company_address = $request->cmp_address[$key];
                            $CustomerExperiance->working_year    = $request->wrking_years[$key];
                            $CustomerExperiance->save();

                        }
                    }
                }

                ///Profession
                if(count($request->profs_name)>0){
                    CustomerProfession::where('customer_id',$CustID)->delete();
                    foreach($request->profs_name as $key => $profs_name){
                        if($profs_name !=""){
                            $CustomerProfession                  = new CustomerProfession();
                            $CustomerProfession->customer_id     = $CustID;
                            $CustomerProfession->profession_name = $profs_name;
                            $CustomerProfession->profession_year = $request->profs_years[$key];
                            $CustomerProfession->save();

                        }
                    }
                }

                
                ///Permission
                if(count($request->permission)>0){
                    CustomerPermission::where('customer_id',$CustID)->delete();
                    foreach($request->permission as $key => $permission){
                        if($permission !=""){
                            $CustomerPermission                  = new CustomerPermission();
                            $CustomerPermission->customer_id     = $CustID;
                            $CustomerPermission->permission      = $permission;
                            $CustomerPermission->save();

                        }
                    }
                }


                ///Customer Information
                if(count($request->information)>0){
                    CustomerInformation::where('customer_id',$CustID)->delete();
                    foreach($request->information as $key => $information){
                        if($information !=""){
                            $CustomerInformation                  = new CustomerInformation();
                            $CustomerInformation->customer_id     = $CustID;
                            $CustomerInformation->information     = $information;
                            $CustomerInformation->save();

                        }
                    }
                }


                ///LAnguages
                if(count($request->languages)>0){
                    CustomerLanguage::where('customer_id',$CustID)->delete();
                    foreach($request->languages as $key =>$value){
                        if($value !=""){
                            $CustomerLanguage              = new CustomerLanguage();
                            $CustomerLanguage->customer_id = $CustID;
                            $CustomerLanguage->language    = $value;
                           $CustomerLanguage->save();
                        }
                    }
                }
                
                ///Other Knowledge
                if(count($request->other_knowledge)>0){
                    CustomerOtherKnowledge::where('customer_id',$CustID)->delete();
                    foreach($request->other_knowledge as $key =>$knowledge){
                        if($knowledge !=""){
                            $other_knowledge                     = new CustomerOtherKnowledge();
                            $other_knowledge->customer_id        = $CustID;
                            $other_knowledge->other_knowledge    = $knowledge;
                            $other_knowledge->save();
                        }
                    }
                }


            }


            if($request->role == 'seeker'){
              $message = __('admin.text_seeker').' '.__('admin.text_update_success');
            }else{
              $message = __('admin.text_provider').' '.__('admin.text_update_success');
            }
        }

        if($request->role == 'seeker'){
          return redirect('admin/customers')->withErrors(['success'=>  $message]);
        }else{
          return redirect('admin/providers')->withErrors(['success'=>  $message]);
        }                   
    }

    public function delete(Request $request){
      if(@$_GET['CustID'] != ''){
         $CustID = @$_GET['CustID'];
         $get_customer = CustomersModel::where(['id' => $CustID])->first(); 
         CustomersModel::where('id', $CustID)->delete();
         if ($get_customer['role']=='seeker') {
            return redirect('admin/customers')->withErrors(['error'=> __('admin.text_seeker_deleted')]);  
         }elseif ($get_customer['role']=='provider'){
            return redirect('admin/providers')->withErrors(['error'=> __('admin.text_provider_deleted')]);  
         }
      }
    }

    public function change_status(Request $request){
      if($_GET['CustID'] != ''){
          $CustID = $_GET['CustID'];
          $Status = $_GET['Status'];

          $UpdateData = array();
          $UpdateData['status']  = $Status;
          CustomersModel::where(['id' => $CustID])->update($UpdateData);

         $get_customer = CustomersModel::where(['id' => $CustID])->first(); 
         if ($get_customer['role']=='seeker') {
            return redirect('admin/customers')->withErrors(['success'=> __('admin.text_seeker_list').' '.__('admin.text_update_success')]);  
         }elseif ($get_customer['role']=='provider'){
            return redirect('admin/providers')->withErrors(['success'=> __('admin.text_provider_list').' '.__('admin.text_update_success')]);  
         }
      }
    }

    public function providers(){
    	$common = array();
        $common['main_menu']     = 'providers';
        $common['sub_menu']      = 'providers';
        $common['heading_title'] = __('admin.text_all_providers');
        $user = array();
        $user_id = Session::get('user_id');
        $user = UserModel::where(['id' => $user_id])->first();

        $get_providers = CustomersModel::where(['role'=>'provider'])->orderBy('id','Desc')->paginate(10);	

        return view('admin.Provider.providers',compact('common','get_providers','user'));
    }

    public function providers_add(){
        $common = array();
        $common['main_menu']     = 'providers';
        $common['sub_menu']      = 'providers';
        $common['heading_title'] = __('admin.text_add_providers');

        $user = array();
        $user_id = Session::get('user_id');
        $user = UserModel::where(['id' => $user_id])->first();

        $get_countries = CountryModel::get();
        $customers     = array();
        $StateModel    = array();
        $CityModel     = array();
        $customers['id']           = '';
        $customers['firstname']    = '';
        $customers['surname']      = '';
        $customers['nick_name']    = '';
        $customers['country']      = '';
        $customers['state']        = '';
        $customers['city']         = '';
        $customers['address']      = '';
        $customers['zip_code']     = '';
        $customers['house_number'] = '';
        $customers['phone_number'] = '';
        $customers['password']     = '';
        $customers['email']        = '';
        $customers['role']         = '';
        $customers['country']      = '';
        $customers['state']        = '';
        $customers['city']         = '';

        $CustID = @$_GET['CustID'];

        if (@$_GET['CustID']!='') {
          $get_customer  = CustomersModel::where(['id' => $CustID])->first();

          $customers['id']           = $get_customer['id'];
          $customers['firstname']    = $get_customer['firstname'];
          $customers['surname']      = $get_customer['surname'];
          $customers['nick_name']    = $get_customer['nick_name'];
          $customers['country']      = $get_customer['country'];
          $customers['state']        = $get_customer['state'];
          $customers['city']         = $get_customer['city'];
          $customers['address']      = $get_customer['address'];
          $customers['zip_code']     = $get_customer['zip_code'];
          $customers['house_number'] = $get_customer['house_number'];
          $customers['phone_number'] = $get_customer['phone_number'];
          $customers['email']        = $get_customer['email'];
          $customers['password']     = $get_customer['password'];
          $customers['role']         = $get_customer['role'];


          $StateModel = StateModel::where('country_id',$get_customer['country'])->get();
          $CityModel  = CityModel::where('state_id',$get_customer['state'])->get();

        }

        
        return view('admin.Provider.providers_add',compact('common','get_countries','customers','StateModel','CityModel','user'));
    }

    public function my_profile(){
        $common = array();
        $common['main_menu'] = 'My-profile';   
        $common['sub_menu']  = 'My-profile';   
        $common['heading_title'] = __('admin.text_my_profile'); 
       
        $user = array();
        $user_id = Session::get('user_id');
        $user = UserModel::where(['id' => $user_id])->first();

        return view('admin.Profile.profile',compact('common','user'));
    }

    public function update_profile(Request $request){
        
        $req_fields = array(
            'first_name'      => 'required',
        );

        $errormsg = array(
            'first_name'   =>  "First Name",
        );
        $validator = Validator::make(
            $request->all(),
            $req_fields,
            $errormsg
        );
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

          // echo "<pre>";
          // print_r($request->all());
          // echo "</pre>";
          // die;
          $data      = $request->all();
          $user_id  = Session::get('user_id');
          if ($user_id!='') {
            $UpdateData = array();
            $UpdateData['first_name'] = $request->first_name;
            $UpdateData['last_name']  = $request->last_name;;

            if ($request->hasFile('prof_img')) {
                $random_no  = uniqid();
                $img = $request->file('prof_img');
                $ext = $img->getClientOriginalExtension();
                $new_name = $random_no . '.' . $ext;
                if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg') {
                    $destinationPath  =  public_path('profile');
                    $img->move($destinationPath, $new_name);
                    $UpdateData['profile_image'] = $new_name;
                }
            }
            
            User::where(['id' => $user_id])->update($UpdateData);
          
          return redirect('admin/my-profile')->withErrors(['success'=> __('admin.text_profile').' '.__('admin.text_update_success')]);
             
        }

    }

    public function changepassword(Request $request){

        $common = array();
        $common['main_menu'] = 'My-profile';
        $common['sub_menu'] = 'My-profile';
        $common['heading_title'] = __('admin.text_chn_password');

        $user = array();
        $user_id = Session::get('user_id');
        $user = array();
        $user_details = UserModel::where(['id' => $user_id])->first();
        if ($user_details) {
          $user['first_name']    = $user_details['first_name'];
          $user['last_name']     = $user_details['last_name'];
          $user['profile_image'] = $user_details['profile_image'];
          $user['email']         = $user_details['email'];
          $user['phone_no']      = $user_details['phone_no'];
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

          $id =  Session::get('user_id');
          $user_data = User::where(['id' => $id ])->first();
          
          if (Hash::check($request->current_password, $user_data->password)) {
            
              $UpdateData['password']     =  Hash::make($request->confirm_password);
              User::where(['id' => $id])->update($UpdateData);
              session()->flush();
              return redirect('/admin')->withErrors(['success' => __('admin.text_password').' '.__('admin.text_update_success')]);
          }else{
             
              return back()->withErrors(['error' => __('admin.text_wrg_current_pass')]);
          }
              
        }

        return view('admin.Profile.change_password',compact('common','user'));
    } 


    /* public function customers_add(){
        $common = array();
        $common['main_menu'] = 'customers';
        $common['heading_title'] = 'Add customers';
        $user = array();
        $user_id = Session::get('user_id');
        $user = UserModel::where(['id' => $user_id])->first();

        $get_countries = CountryModel::get();
        $StateModel    = array();
        $CityModel     = array();
        $customers     = array();
        $customers['id']           = '';
        $customers['firstname']    = '';
        $customers['surname']      = '';
        $customers['nick_name']    = '';
        $customers['country']      = '';
        $customers['state']        = '';
        $customers['city']         = '';
        $customers['address']      = '';
        $customers['zip_code']     = '';
        $customers['house_number'] = '';
        $customers['phone_number'] = '';
        $customers['password']     = '';
        $customers['email']        = '';
        $customers['role']         = '';
        $customers['country']      = '';
        $customers['state']        = '';
        $customers['city']         = '';

        $CustID = @$_GET['CustID'];

        if (@$_GET['CustID']!='') {
            $get_customer = CustomersModel::where(['id' => $CustID])->first();

                $customers['id']           = $get_customer['id'];
                $customers['firstname']    = $get_customer['firstname'];
                $customers['surname']      = $get_customer['surname'];
                $customers['nick_name']    = $get_customer['nick_name'];
                $customers['country']      = $get_customer['country'];
                $customers['state']        = $get_customer['state'];
                $customers['city']         = $get_customer['city'];
                $customers['address']      = $get_customer['address'];
                $customers['zip_code']     = $get_customer['zip_code'];
                $customers['house_number'] = $get_customer['house_number'];
                $customers['phone_number'] = $get_customer['phone_number'];
                $customers['email']        = $get_customer['email'];
                $customers['password']     = $get_customer['password'];
                $customers['role']         = $get_customer['role'];


          $StateModel = StateModel::where('country_id',$get_customer['country'])->get();
          $CityModel  = CityModel::where('state_id',$get_customer['state'])->get();
        }
        return view('admin.Customer.customers_add',compact('common','get_countries','customers','StateModel','CityModel','user'));
    }*/

}



