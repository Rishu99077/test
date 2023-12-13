<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Models\UserModel;
use App\Models\FaqsModel;
use App\Models\FaqsDescriptionModel;
use App\Models\TestimonialsModel;
use App\Models\TestimonialDescriptionModel;
use App\Models\LanguagesModel;
use App\Models\ContactModel;
use App\Models\WorkModel;
use App\Models\WorkDescriptionModel;
use App\Models\CustomersModel;


use Mail;
use App\Mail\NotifyMail;


class FrontController extends Controller{

    public function index(){
        $Lang_id = 1;
        if (Session::get('language_id')) {
    	   $Lang_id = Session::get('language_id');
        }
            
    	// Faqs
    	$get_faqs = FaqsModel::where(['status' => '1'])->get();
    	$faqs = array();
        $row = array();
    	if (!empty($get_faqs)) {
	    	foreach ($get_faqs as $key => $value) {
	    		$get_faq_desc = FaqsDescriptionModel::where(['faq_id' => $value['id'],'language_id' => $Lang_id])->get();
	    		foreach ($get_faq_desc as $key => $value_desc) {
		    		$row['title'] = $value_desc['title'];
		    		$row['description'] = $value_desc['description'];
		    	}
	   		 	$faqs[] = $row;
	    	}
    	}

    	// testimonials
    	$get_testimonials = TestimonialsModel::where(['status' => '1'])->get();
    	$testimonials = array();
    	if (!empty($get_testimonials)) {
	    	foreach ($get_testimonials as $key => $value) {
                $test = array();
		    	$test['image'] = $value['image'];
	    		$get_test_desc = TestimonialDescriptionModel::where(['testimonial_id' => $value['id'],'language_id' => $Lang_id])->get();
	    		foreach ($get_test_desc as $key => $value_desc) {
		    		$test['name'] = $value_desc['name'];
		    		$test['designation'] = $value_desc['designation'];
		    		$test['description'] = $value_desc['description'];
		    	}
	   		 	$testimonials[] = $test;
	    	}
    	}


        // How it works (Seeker)
        $get_work_seeker = WorkModel::where(['status' => '1','role' => 'seeker'])->get();
        $work_seeker = array();
        if (!empty($get_work_seeker)) {
            foreach ($get_work_seeker as $key => $value) {
                $work = array();
                $work['id'] = $value['id'];
                $work['image'] = $value['image'];
                $work['logo'] = $value['logo'];

                $get_work_desc = WorkDescriptionModel::where(['work_id' => $value['id'],'language_id' => $Lang_id])->get();

                foreach ($get_work_desc as $key => $value_desc) {
                    $work['work_id'] = $value_desc['work_id'];
                    $work['title'] = $value_desc['title'];
                    $work['description'] = $value_desc['description'];
                }
                $work_seeker[] = $work;
            }
        }


        // How it works (Provider)
        $get_work_provider = WorkModel::where(['status' => '1','role' => 'provider'])->get();
        $work_provider = array();
        if (!empty($get_work_provider)) {
            foreach ($get_work_provider as $key => $value) {
                $work = array();
                $work['id'] = $value['id'];
                $work['image'] = $value['image'];
                $work['logo'] = $value['logo'];
                $get_work_desc = WorkDescriptionModel::where(['work_id' => $value['id'],'language_id' => $Lang_id])->get();
                foreach ($get_work_desc as $key => $value_desc) {
                    $work['work_id'] = $value_desc['work_id'];
                    $work['title'] = $value_desc['title'];
                    $work['description'] = $value_desc['description'];
                }
                $work_provider[] = $work;
            }
        }
      
        return view('front.home',compact('faqs','testimonials','work_seeker','work_provider'));
    }


    public function save_contact(Request $request){
    	$data = $request->all();
    	
    	$Data = array();
        $Data['first_name'] = $data['first_name'];
        $Data['family_name'] = $data['family_name'];
        $Data['email'] = $data['email'];
        $Data['phone'] = $data['phone'];
        $Data['topic'] = $data['topic'];
        $Data['message'] = $data['message'];

        if ($request->file('image')) {
            $random_no  = uniqid();
            $img = $data['image'];
            $ext = $img->getClientOriginalExtension();
            $new_name = $random_no . '.' . $ext;
            if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg') {
                $destinationPath  =  public_path('/Images/Contacts');
                $img->move($destinationPath, $new_name);
                $UpdateData['image'] = $new_name;
            }
        }

        $Data['status'] = 0;

        $users = array();
	    $users['first_name'] = $data['first_name'];
        $users['family_name'] = $data['family_name'];
        $users['email'] = $data['email'];
        $users['phone'] = $data['phone'];
        // $users['image'] = $data['image'];
	    $tomail = $data['email'];

	    Mail::to($tomail)->send(new NotifyMail($users));

        $insert_id = ContactModel::create($Data);


        return redirect('/')->withErrors(['success'=> __('customer.text_mail_send')]);
    }




    public function changeLang(Request $req){
        $LanguagesModel = LanguagesModel::where('id',$req->value)->first();
        $short_name     =  $LanguagesModel->short_name;
        App::setLocale($short_name);
        $getlocale      = App::getLocale(); 
        session()->put('locale', $getlocale);
        session()->put('language_id',$LanguagesModel->id);
        
        echo App::getLocale();
    }
    
    public function changeDashLang(Request $req){
        $cust_id = Session::get('cust_id');
        $Languge_id = $req->Languge_id;


        $LanguagesModel = LanguagesModel::where('id',$Languge_id)->first();
        $short_name     =  $LanguagesModel->short_name;
        // $image           =  $LanguagesModel->image;
        App::setLocale($short_name);
        // App::setLocale($short_name);
        $getlocale      = App::getLocale(); 
        session()->put('locale', $getlocale);
        session()->put('language_id',$LanguagesModel->id);
        
        $UpdateData = array();
        $UpdateData['language_id'] = $Languge_id;
        
        CustomersModel::where(['id' => $cust_id])->update($UpdateData);

        echo App::getLocale();

    }
}
