<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\CustomerController;
use App\Http\Controllers\Front\JobController;
use App\Http\Controllers\Front\ProviderController;
use App\Http\Controllers\Front\WorkManagementController;
use App\Http\Controllers\Front\SeekerController;
use App\Http\Controllers\Front\ReportController;
use App\Http\Controllers\Front\AdvertismentController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\DocumentsController;
use App\Http\Controllers\Front\SettingController;
use App\Http\Controllers\Controller;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/clear-cache-all', function() {
    Artisan::call('cache:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('optimize');
    $exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('config:cache');
    dd("Cache Clear All");
});


Route::middleware(['set_lang'])->group(function () {
	Route::get("/",[FrontController::class,'index']);
	Route::post("/save_contact",[FrontController::class,'save_contact']);
    Route::post('changeLang',[FrontController::class,'changeLang'])->name('changeLang'); 

    // custom auth remain-------------------------
    Route::middleware(['check_customer_withoutlogin'])->group(function (){
        // -----------------------------------------------------------------------------------------------//
        ///Seeker Rout
        Route::match(['get','post'],'seeker_signup',[SeekerController::class,'signup'])->name('seeker_signup');

        ///Login
        Route::match(['get','post'],'login',[CustomerController::class,'login']);
        Route::match(['get','post'],'forgotpassword',[CustomerController::class,'forgot_password'])->name('forgotpassword');

        ////ResetPasword
        Route::get('reset_password/{id}',[CustomerController::class,'reset_password'])->name('reset_password');
        Route::post('update_password',[CustomerController::class,'update_password'])->name('update_password');
        // -----------------------------------------------------------------------------------------------//
        //////Provider Route
        Route::match(['get','post'],'signup',[ProviderController::class,'signup'])->name('providersignup');
        Route::post('match_otp',[ProviderController::class,'match_otp']);
        Route::match(['get','post'],'resend_otp',[ProviderController::class,'resend_otp']);
    });

    // custom auth remain-------------------------
    Route::middleware(['check_customer'])->group(function (){

        Route::post('changeDashLang',[FrontController::class,'changeDashLang'])->name('changeDashLang'); 
          
        ////Personal Detail
        Route::match(['get','post'],'verification_account',[CustomerController::class,'verification_account'])->name('verification_account');
        Route::post('save_verfication_account',[CustomerController::class,'save_verfication_account'])->name('save_verfication_account');
        
        Route::get("logout",[CustomerController::class,'logout'])->name('user_logout');

        Route::middleware(['check_customer_setup'])->group(function (){        

            ////// Dashboard 
            Route::get("/dashboard",[CustomerController::class,'dashboard'])->name('frontdashboard');
            Route::get("/get_flag",[CustomerController::class,'get_flag'])->name('get_flag');

            Route::get("/search",[CustomerController::class,'search'])->name('search');

            // Fav. candidates
            Route::post("add_favourite_candidates", [CustomerController::class, 'add_favourite_candidates']);
            Route::get("/favorite-candidates",[CustomerController::class,'favorite_candidates'])->name('favorite_candidates');

            // view seeker profile
            Route::get("/seeker/profile",[CustomerController::class,'seeker_profile'])->name('seeker_profile');

            // Fav . Jobs
            Route::get("/favorite-jobs",[CustomerController::class,'favorite_jobs'])->name('favorite_jobs');

            // Profile
            Route::get('my-profile',[CustomerController::class,'my_profile'])->name('my_profile');
            Route::get('edit-profile',[CustomerController::class,'edit_profile'])->name('edit_profile');
            Route::post('update_profile',[CustomerController::class,'update_profile'])->name('update_profile');

            // Contact US
            Route::get("/contact-us",[ContactController::class,'index'])->name('contact_us');
            Route::post("/save_contact_us",[ContactController::class,'save_contact_us']);
            Route::get("/notification",[ContactController::class,'notification'])->name('notification');

            // changePassword
            Route::match(['get','post'],'changepassword',[CustomerController::class,'changepassword'])->name('change_password');
            
            // Job 
            Route::get("job",[JobController::class,'job'])->name('job');
            Route::get("job/add",[JobController::class,'job_add'])->name('job_add');
            Route::get("job/view",[JobController::class,'job_detail'])->name('job_detail');

            // Route::get("/job/view",[JobController::class,'job_detail'])->name('job_detail');
            

            Route::get("seeker-job/view",[JobController::class,'seeker_job_detail'])->name('seeker.job_detail');

            Route::get("job/delete",[JobController::class,'job_delete'])->name('job_delete');
            Route::post("save_job",[JobController::class,'save_job']);
            Route::post("add_wishlist", [JobController::class, 'add_wishlist']);
            Route::post("save_contract", [JobController::class, 'save_contract']);

            Route::get("/applicant/view-profile",[JobController::class,'applicant_view_profile'])->name('provider.applicant_view_profile');
            Route::post("change_job_status", [JobController::class, 'change_job_status']);
            

            
            // Work Management/Reports Seeker

            // CH Route::get("/work-management/seeker",[ReportController::class,'index'])->name('seeker.report');

            Route::get("work-management/report/add",[ReportController::class,'add'])->name('report_add');
            Route::get("work-management/report/delete",[ReportController::class,'delete'])->name('report_delete');
            Route::post("work-management/report/send_report",[ReportController::class,'send_report'])->name('send_report');
            Route::post("save_report",[ReportController::class,'save'])->name('report_save');

            Route::get("work-management/advertisment/view",[ReportController::class,'advertisment_detail'])->name('advertisment_detail');
            Route::get("work-management/ExportZip",[ReportController::class,'ExportZip'])->name('download_report');
            
            Route::get("work-management/ExportZipProvider",[ReportController::class,'ExportZip_provider'])->name('download_report_provider');


            // Work Management/Reports Seeker

            // CH Route::get("/work-management/provider",[ReportController::class,'provider_report'])->name('provider.report');

            // Route::get("work-management/pay",[ReportController::class,'provider_pay'])->name('provider.pay');
            Route::post("update_payment",[ReportController::class,'update_payment'])->name('update_payment');

            // NEW WM PROVIDER
            Route::get("Work-management/Provider/reports",[WorkManagementController::class,'provider_reports'])->name('provider.reports');
            Route::get("Work-management/Provider/applicants",[WorkManagementController::class,'provider_applicants'])->name('provider.applicants');
            Route::get("Work-management/Provider/employees",[WorkManagementController::class,'provider_employees'])->name('provider.employees');
            Route::get("Work-management/Provider/salaries",[WorkManagementController::class,'provider_salaries'])->name('provider.salaries');

            Route::get("Work-management/Provider/generate_report/{id}",[WorkManagementController::class,'generate_report'])->name('provider.generate_report');
            Route::get("Work-management/Provider/billing_info/{id}",[WorkManagementController::class,'billing_info'])->name('provider.billing_info');

            Route::post("change_report_status", [WorkManagementController::class, 'change_report_status']);


            // NEW WM SEEKER
            Route::get("Work-management/Seeker/reports",[WorkManagementController::class,'seeker_reports'])->name('seeker.reports');
            Route::get("Work-management/Seeker/advertisment",[WorkManagementController::class,'seeker_advertisment'])->name('seeker.advertisment');
            Route::get("Work-management/Seeker/actual_contract",[WorkManagementController::class,'seeker_actual_contract'])->name('seeker.actual_contract');
            Route::get("Work-management/Seeker/contract_to_sign",[WorkManagementController::class,'seeker_contract_to_sign'])->name('seeker.contract_to_sign');

            Route::get("Work-management/Seeker/edit_advertisment/{id}",[WorkManagementController::class,'edit_advertisment'])->name('seeker.edit_advertisment');


            // report pdf
            Route::get("Report-pdf",[WorkManagementController::class,'generate_report_pdf'])->name('generate_report_pdf');
            Route::get("Report-Excel",[WorkManagementController::class,'generate_excel'])->name('generate_excel');


            /////Documents Seeker
            Route::get("documents/seeker",[DocumentsController::class,'seeker_documents'])->name('seeker.documents');
            Route::get("documents/contract_details",[DocumentsController::class,'contract_details'])->name('seeker.contract_details');

            /////new 
            Route::get("documents/seeker/contracts",[DocumentsController::class,'seeker_documents_contracts'])->name('seeker.documents_contracts');
            Route::get("documents/seeker/salaries",[DocumentsController::class,'seeker_documents_salaries'])->name('seeker.documents_salaries');
            Route::get("documents/seeker/reports",[DocumentsController::class,'seeker_documents_reports'])->name('seeker.documents_reports');
            Route::get("documents/seeker/other_documents",[DocumentsController::class,'seeker_documents_other_documents'])->name('seeker.documents_other_documents');


            /////Documents Provider
            Route::get("documents/provider",[DocumentsController::class,'provider_documents'])->name('provider.documents');

            Route::get("documents/provider/contracts",[DocumentsController::class,'provider_documents_contracts'])->name('provider.documents_contracts');
            Route::get("documents/provider/bills",[DocumentsController::class,'provider_documents_bills'])->name('provider.documents_bills');
            Route::get("documents/provider/payed_bills",[DocumentsController::class,'provider_documents_payed_bills'])->name('provider.documents_payed_bills');
            Route::get("documents/provider/other_documents",[DocumentsController::class,'provider_documents_other_documents'])->name('provider.documents_other_documents');


            ////Advertisment
            Route::get('advertisment',[AdvertismentController::class,'advertisment']);
            Route::match(['get','post'],'add_advertisment',[AdvertismentController::class,'add_advertisment'])->name('add_advertisment');
            Route::get('advertisment_detail/{id}',[AdvertismentController::class,'advertisment_detail'])->name('advertisment.detail');
            Route::post('advertisment_contract',[AdvertismentController::class,'advertisment_contract'])->name('adv_contract');
            Route::get('post_reply/{id?}',[AdvertismentController::class,'advertisment_appliers'])->name('adv_appliers');


            ////Settings
            Route::get('settings',[SettingController::class,'index'])->name('settings');
            Route::post('update_settings',[SettingController::class,'update_settings'])->name('update_settings');


            //Documents
            Route::get("other_documents",[DocumentsController::class,'send_otherdocuments'])->name('other_documents');
            Route::match(['get','post'],"other_documents/send",[DocumentsController::class,'send_otherdocuments'])->name('send_documents');



            ////Chat 
            Route::post("get_chat",[Controller::class,'get_chat'])->name('get_chat');
            Route::post("send_chat",[Controller::class,'send_chat'])->name('send_chat');


            // PDF
            Route::get("generate-pdf/{id}",[DocumentsController::class,'generate_pdf'])->name('generate_pdf');


        });
    });  
});
    

