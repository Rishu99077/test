<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Models\UserModel;
use App\Models\CountryModel;
use App\Models\CityModel;
use App\Models\StateModel;
use App\Models\TestimonialsModel;
use App\Models\TestimonialDescriptionModel;
use App\Models\LanguagesModel;
use App\Models\ContactModel;
use App\Models\CustomersModel;
use App\Models\JobsModel;
use App\Models\ContractsModel;



class AdminController extends Controller{


    public function index(){
        return view('admin.login');
    }

    public function login(Request $request){
        $validation = Validator::make($request->all(), [
            'email' => 'email|required',
            'password' => 'required'
        ])->validate();
        $user = User::where(['email' => $request->email])->first();
        
        if(!empty($user)){
            if (Hash::check($request->password, $user->password)) {  
                $request->session()->put('user_id', $user->id);
                return redirect('admin/dashboard');
            }else{
                return redirect()->back()->withErrors(['error'=> __('admin.text_invalid_password')]);
            }
        }else{
            return redirect()->back()->withErrors(['error'=> __('admin.text_user_not_found')]);
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
            $UserModel = User::where(['email' => $request->email])->first();
            if (!empty($UserModel)) {
                $name         = $UserModel->name;
                $email         = 'dev4.infosparkles@gmail.com';
                $data = array('email'=>$UserModel->email,'user_id'=>$UserModel->id,'name'=>$UserModel->first_name.' '.$UserModel->last_name);
               
                $sent = Mail::send('emails.forgotpassword', $data, function($message) use ($email) {
                    $message->to($email)->subject('Forget Password');
                });
                
                return back()->withErrors(["success" => __('admin.text_mail_send_inbox')]);
            }else{
                return back()->withErrors(['error' => __('admin.text_user_not_found'), 'emailid' => $request->email]);
              
            }
        }else{
            return view('admin.forgotpassword');
        }
    }

    public function reset_password($id=""){
        return view('admin.reset_password',compact('id'));
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
            User::where(['id' => $request->id])->update($UpdateData);

            return redirect('/admin')->withErrors(["success" => __('admin.text_pass_update_success')]);
           
         }
         else
         {
            return back();
         }
    }


    public function dashboard(Request $request){
        $common = array();
        $common['main_menu'] = 'Dashboard';
        $common['sub_menu']  = 'Dashboard';
        $common['heading_title'] = __('admin.text_dashboard');
        
    	$user = array();
    	$user_id = Session::get('user_id');
    	$user = UserModel::where(['id' => $user_id])->first();

        // Jobs
        $get_jobs = JobsModel::get();
        if (!empty($get_jobs)) {
            $common['jobs_count'] = count($get_jobs);
        }
    
        $get_seekers = CustomersModel::where('role','seeker')->get();
        if (!empty($get_seekers)) {
            $common['seeker_count'] = count($get_seekers);
        }

        $get_providers = CustomersModel::where('role','provider')->get();
        if (!empty($get_providers)) {
            $common['provider_count'] = count($get_providers);
        }

        $get_contracts = ContractsModel::where('status','published')->get();
        if (!empty($get_contracts)) {
            $common['contract_count'] = count($get_contracts);
        }

    	return view('admin.dashboard',compact('user','common'));
    }

    // Assistant --------------------------------------------------
    public function assistant(){
        $common                  = array();
        $common['main_menu']     = 'Assistant';
        $common['sub_menu']      = 'Assistant';
        $common['heading_title'] = 'All Assistant';
        $user = array();
        $user_id = Session::get('user_id');
        $user = UserModel::where(['id' => $user_id])->first();
       
        $get_assistant = UserModel::where('user_role','Assistant')->orderBy('id','Desc')->paginate(10);

        
        return view('admin.Assistant.assistant',compact('common','get_assistant','user'));
    }

    public function assistant_add(){

        $common = array();
        $common['main_menu']     = 'Assistant';
        $common['sub_menu']      = 'Assistant';
        $common['heading_title'] = __('admin.text_edit_assistant');

        $user                    = array();
        $assistant               = array();
        $user_id                 = Session::get('user_id');
        $user                    = UserModel::where(['id' => $user_id])->first();
        
        $get_countries           = CountryModel::get();
        $StateModel              = StateModel::get();
        $CityModel               = CityModel::get();

        $assistant['id']            = '';
        $assistant['first_name']    = '';
        $assistant['last_name']     = '';
        $assistant['profile_image'] = '';
        $assistant['phone_no']      = '';
        $assistant['email']         = '';
        $assistant['country']       = '';
        $assistant['state']         = '';
        $assistant['city']          = '';
        $assistant['user_role']     = '';


        $ID = @$_GET['ID'];
        if ($ID) {
            $user_details  = UserModel::where(['id' => $ID])->first();
            if($user_details){
                $assistant['id']            = $user_details['id'];
                $assistant['first_name']    = $user_details['first_name'];
                $assistant['last_name']     = $user_details['last_name'];
                $assistant['profile_image'] = $user_details['profile_image'];
                $assistant['phone_no']      = $user_details['phone_no'];
                $assistant['email']         = $user_details['email'];
                $assistant['country']       = $user_details['country'];
                $assistant['state']         = $user_details['state'];
                $assistant['city']          = $user_details['city'];
                $assistant['user_role']     = $user_details['user_role'];
            }
        }
        return view('admin.Assistant.edit_assistant',compact('common','user','assistant','get_countries','StateModel','CityModel')); 
    }

    public function save_assistant(Request $request){
        $user_id = Session::get('user_id');
        $user_details = UserModel::where(['id' => $user_id])->first();

        $data = $request->all();

        $validation = Validator::make($request->all(), [
            'first_name'       => 'required|max:25',
            'last_name'        => 'required|max:25',
            'email'            => 'required',
            'password'         => 'required',
            'country'          => 'required',
            'state'            => 'required',
            'city'             => 'required',
        ]);

        if ($validation->fails()) {
          return back()->withErrors($validation)->withInput();
        }

        $Assi_ID = $request->Assi_ID;
    
        if($Assi_ID!='') {
            $get_customer = CustomersModel::where(['id' => $Assi_ID])->first();
            $Assi_ID       = $get_customer['id'];

            $UpdateData = array();
            $UpdateData['first_name']    = $data['first_name'];
            $UpdateData['last_name']     = $data['last_name'];
            $UpdateData['country']       = $data['country'];
            $UpdateData['state']         = $data['state'];
            $UpdateData['city']          = $data['city'];
            $UpdateData['phone_no']      = $data['phone_no'];
            $UpdateData['email']         = $data['email'];

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

            UserModel::where(['id' => $Assi_ID])->update($UpdateData);

            $message = __('admin.text_assistant').' '.__('admin.text_update_success');
           
        }else{

            $data_desc = array();  
            $data_desc['first_name'] = $data['first_name'];
            $data_desc['last_name']  = $data['last_name'];
            $data_desc['email']      = $data['email'];
            $data_desc['password']   = Hash::make($data['password']);
            $data_desc['phone_no']   = $data['phone_no'];
            $data_desc['country']    = $data['country'];
            $data_desc['state']      = $data['state'];
            $data_desc['city']       = $data['city'];
            $data_desc['user_role']  = 'Assistant';

            if($request->file('prof_img')){
                $random_no  = uniqid();
                $img = $data['prof_img'];
                $ext = $img->getClientOriginalExtension();
                $new_name  = $random_no . '.' . $ext;
                if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg') {
                    $destinationPath  =  public_path('profile');
                    $img->move($destinationPath, $new_name);
                    $data_desc['profile_image'] = $new_name;
                }
            }

            UserModel::create($data_desc);

            $message = __('admin.text_assistant').' '.__('admin.text_add_success');
        }

       
        return redirect('admin/assistant')->withErrors(['success'=>  $message]);
                           
    }

    public function delete_assistant(Request $request){
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


    public function Signup(){
    	return view('signup');
    }

    public function save_signup(Request $request){
        if($request->isMethod('post')){
            $validator = Validator::make(
              $request->all(), 
               [
                    'firstname' => 'required',
                    'lastname'  => 'required',
                    'user_name' =>'required|unique:users',
                    'email'     => 'required|email|unique:users',
                    'password'  => 'required|min:6',
                    'confirm_password' => 'required|min:6|same:password',
                    'phone_no'  => 'required|min:10|unique:users',
               ]
            );

            if ($validator->fails()) {
                return response()->json(array('error'=>$validator->getMessageBag()->toArray(),));
            }

            $data                       = $request->all();
            $content                    = new UserModel;
            $content->firstname        = $data['firstname'];
            $content->lastname         = $data['lastname'];
            $content->user_name         = $data['user_name'];
            $content->email             = $data['email'];
            $content->phone_no      = $data['phone_no'];
            $content->password          = Hash::make($data['password']);
            $content->user_role   = 1;

        
            if($content->save()){
                return redirect('/admin_login')->with('success',__('admin.text_signup_success'));
            }
        }     
    }

    public function get_states_by_countryid($CountryID){
        $get_states = StateModel::where('country_id',$CountryID)
                            ->get()
                            ->toArray();
        $response = [];
        $options =  '<option value="">'.__("admin.text_choose").' Province</option>';
        if(!empty($get_states)){
            foreach ($get_states as $key => $value) {
                if($value['id'] == @$_GET['StateID']){
                    $options .=  "<option value=".$value['id']." selected='selected' >".ucfirst($value['name'])." </option> ";
                }else{
                    $options .=  "<option value=".$value['id']." >".ucfirst($value['name'])." </option> ";
                }
                //$options .=  "<option value=".$value['id']." >".ucfirst($value['name'])." </option> ";
                
            }
        }
        $response['get_states']   = $options;
        return $response;
    }

    public function get_cities_by_stateid($StateID){
        
        $get_cities = CityModel::where('state_id',$StateID)
                            ->get()
                            ->toArray();
        $response = [];
        $options =  '<option value="">'.__('admin.text_choose').' '.__('admin.text_city').'</option>';
        if(!empty($get_cities)){
            foreach ($get_cities as $key => $value) {
                if($value['id'] ==  @$_GET['CityID']){
                    $options .=  "<option value=".$value['id']." selected='selected' >".ucfirst($value['name'])." </option> ";
                }else{
                    $options .=  "<option value=".$value['id'].">".ucfirst($value['name'])." </option> ";
                }
                
                
            }
        }
        $response['get_cities']   = $options;
        return $response;
    }
    

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('/admin');
    }

    // testimonials
    public function testimonials(){
        $common = array();
        $common['main_menu'] = 'Menu';
        $common['sub_menu'] = 'Testimonials';
        $common['heading_title'] = 'All Testimonials';

        $user = array();
        $user_id = Session::get('user_id');
        $user = UserModel::where(['id' => $user_id])->first();
        $Testimonials = TestimonialsModel::orderBy('id','Desc')->paginate(5);
        $testimonials = array();
        foreach ($Testimonials as $key => $value) {
          $row['id'] = $value['id'];
          $row['image'] = $value['image'];
          $row['status'] = $value['status'];
          $get_test_desc = TestimonialDescriptionModel::where(['testimonial_id'=>$value['id']])->first();
          $row['name'] = $get_test_desc['name'];
          $row['designation'] = $get_test_desc['designation'];

          $testimonials[] = $row;
        }

        return view('admin.Testimonials.index',compact('common','testimonials','user','Testimonials'));
    }

    public function testimonial_add(){
        $common = array();
        $common['main_menu']        = 'Menu';
        $common['sub_menu']         = 'Testimonials';
        $common['heading_title']    = __('admin.text_add').' '.__('admin.text_testimonials');

        $user = array();
        $user_id = Session::get('user_id');
        $user = UserModel::where(['id' => $user_id])->first();

        $get_languages        = LanguagesModel::get();
        $get_test_description = array();
        $tests           = array();
        $tests['id']     = "";
        $tests['status'] = "";
        $tests['image']  = "";
        $testimonial_id = @$_GET['id'];

        if ($testimonial_id!='') {
          $get_testimonial = TestimonialsModel::where(['id' => $testimonial_id])->first();
          $tests['id'] = $get_testimonial['id'];
          $tests['status'] = $get_testimonial['status'];
          $tests['image'] = $get_testimonial['image'];


          foreach ($get_languages as $value) {
                $language_id =  $value['id'];
                $testdescription = TestimonialDescriptionModel::where(['testimonial_id' => $testimonial_id,'language_id'=>$language_id])->first();

                if($testdescription){
                    $get_test_description[$language_id]['name']  = $testdescription->name;
                }else{
                    $get_test_description[$language_id]['name'] = '';
                }

                if($testdescription){
                    $get_test_description[$language_id]['designation']  = $testdescription->designation;
                }else{
                    $get_test_description[$language_id]['designation'] = '';
                }


                if($testdescription){
                    $get_test_description[$language_id]['description']  = $testdescription->description;
                }else{
                    $get_test_description[$language_id]['description'] = '';
                }
            }

        }

        return view('admin.Testimonials.testimonial_add',compact('common','user','tests','get_languages','get_test_description'));
    }


    public function save_testimonials(Request $request){
        $user_id = Session::get('user_id');
        $user_details = UserModel::where(['id' => $user_id])->first();

        $data = $request->all();

        $Test_id  = $request->Test_id;

        if ($Test_id=='') {
            $Data = array();
            $Data['status'] = $data['status'];

            // if ($request->file('image')) {
            //     $img = $request->file('image');
            //     $Data["image"] = $img->getClientOriginalName();
            //     $destinationPath = public_path('/Images/Testimonials');
            //     $img->move($destinationPath, $Data["image"]);      
            // }

            if ($request->hasFile('image')) {
                $random_no  = uniqid();
                $img = $request->file('image');
                $ext = $img->getClientOriginalExtension();
                $new_name = $random_no . '.' . $ext;
                if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg') {
                    $destinationPath  =  public_path('/Images/Testimonials');
                    $img->move($destinationPath, $new_name);
                    $Data['image'] = $new_name;
                }
            }


            $insert_id = TestimonialsModel::create($Data);

          foreach ($request->name as $key => $value) {
              $data_desc = array();  
              $data_desc['testimonial_id'] = $insert_id['id'];
              $data_desc['language_id'] = $key;
              $data_desc['name'] = $request->name[$key];
              $data_desc['designation'] = $request->designation[$key];
              $data_desc['description'] = $request->description[$key];

              TestimonialDescriptionModel::create($data_desc);    
          }  
          return redirect('admin/testimonials')->withErrors(['success'=> __('admin.text_testimonials').' '.__('admin.text_add_success')]);
             
        }else{

            $UpdateData = array();
            $UpdateData['status'] = $data['status'];
           

            if ($request->hasFile('image')) {
                $random_no  = uniqid();
                $img = $request->file('image');
                $ext = $img->getClientOriginalExtension();
                $new_name = $random_no . '.' . $ext;
                if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg') {
                    $destinationPath  =  public_path('/Images/Testimonials');
                    $img->move($destinationPath, $new_name);
                    $UpdateData['image'] = $new_name;
                }
            }

            TestimonialsModel::where(['id' => $Test_id])->update($UpdateData);
          

            foreach ($request->name as $key => $value) {
                $data_desc = array();  
                $data_desc['testimonial_id'] = $Test_id;
                $data_desc['language_id'] = $key;
                $data_desc['name'] = $request->name[$key];
                $data_desc['designation'] = $request->designation[$key];
                $data_desc['description'] = $request->description[$key];

                TestimonialDescriptionModel::where(['testimonial_id' => $Test_id,'language_id' =>$key])->update($data_desc);
            }  
            return redirect('admin/testimonials')->withErrors(['success'=> __('admin.text_testimonials').' '.__('admin.text_update_success')]);
        }    
    }


    public function testimonial_delete(Request $request){
      if(@$_GET['id'] != ''){
        $Test_id = $_GET['id'];
        TestimonialsModel::where('id', $Test_id)->delete();
        TestimonialDescriptionModel::where('testimonial_id', $Test_id)->delete();   
      }
      return redirect('admin/testimonials')->withErrors(['error'=> __('admin.text_testimonials').' '.__('admin.text_deleted')]);
    }


     // contacts
    public function contacts(){
        $common = array();
        $common['main_menu']     = 'Menu';
        $common['sub_menu']      = 'Contacts';
        $common['heading_title'] = __('admin.text_all_contact_detail');

        $user = array();
        $user_id = Session::get('user_id');
        $user = UserModel::where(['id' => $user_id])->first();

        $Contacts = ContactModel::orderBy('id','Desc')->paginate(5);
        $contacts = array();
        foreach ($Contacts as $key => $value) {
            $row['id']          = $value['id'];
            $row['first_name']  = $value['first_name'];
            $row['family_name'] = $value['family_name'];
            $row['email']       = $value['email'];
            $row['phone']       = $value['phone'];
            $row['topic']       = $value['topic'];
            $row['message']     = $value['message'];
            $row['image']       = $value['image'];
            $row['status']      = $value['status'];
          $contacts[] = $row;
        }

        return view('admin.Contact.index',compact('common','contacts','user','Contacts'));
    }
}



