<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FaqsController;
use App\Http\Controllers\Admin\WorkController;
use App\Http\Controllers\Admin\JobTypeController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\ListController;
use App\Http\Controllers\Admin\ContractsController;
use App\Http\Controllers\Admin\NotificationsController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\AdminJobsController;
use App\Http\Controllers\Controller;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get("/",[AdminController::class,'index']);
Route::post("login",[AdminController::class,'login']);
Route::get("logout",[AdminController::class,'logout']);

Route::get("get_states_by_countryid/{CountryID}",[AdminController::class, 'get_states_by_countryid']);
Route::get("get_cities_by_stateid/{StateID}",[AdminController::class, 'get_cities_by_stateid']);

Route::match(['get','post'],'forgotpassword',[AdminController::class,'forgot_password'])->name('admin_forgotpassword');

////ResetPasword
Route::get('reset_password/{id}',[AdminController::class,'reset_password'])->name('reset_password');
Route::post('update_password',[AdminController::class,'update_password'])->name('admin_update_password');

Route::middleware(['CustomAuth'])->group(function () {
    // dashboard
    Route::get("/dashboard",[AdminController::class,'dashboard'])->name('admin_dashboard');

    // Assistant
    Route::get("/assistant",[AdminController::class,'assistant'])->name('admin_assistant');
    Route::get("/assistant/add",[AdminController::class,'assistant_add'])->name('assistant_add');
    Route::post("/save_assistant",[AdminController::class,'save_assistant'])->name('save_assistant');
    Route::get("/delete_assistant",[AdminController::class,'delete_assistant'])->name('delete_assistant');

    // Testimoials
    Route::get("/testimonials",[AdminController::class,'testimonials'])->name('testimonials');
    Route::get("/testimonial/add",[AdminController::class,'testimonial_add'])->name('testimonial_add');
    Route::get("/testimonial/delete",[AdminController::class,'testimonial_delete'])->name('testimonial_delete');
    Route::post("/save_testimonials",[AdminController::class,'save_testimonials']);

    // Contacts
    Route::get("/contacts",[AdminController::class,'contacts'])->name('contacts');

    // Customers
    Route::get("/customers",[UserController::class,'customers'])->name('all_customers');
    Route::get("/customer/add",[UserController::class,'customers_add'])->name('customers_add');
    Route::get("/customer/edit/{id}",[UserController::class,'customer_edit'])->name('customer_edit');

    Route::get("/providers",[UserController::class,'providers'])->name('all_providers');
    Route::get("/provider/add",[UserController::class,'providers_add'])->name('providers_add');
    
    Route::post("/save_customer",[UserController::class,'save_customer'])->name('save_customer');
    Route::get("/delete",[UserController::class,'delete'])->name('delete');
    Route::get("/change_status",[UserController::class,'change_status'])->name('change_status');

    // Profile
    Route::get('my-profile',[UserController::class,'my_profile'])->name('admin_my_profile');
    Route::post('update_profile',[UserController::class,'update_profile'])->name('admin_update_profile');

    // changePassword
    Route::match(['get','post'],'changepassword',[UserController::class,'changepassword'])->name('admin_change_password');


    // Contracts
    Route::get("/contracts",[ContractsController::class,'index'])->name('contracts');
    Route::get("/contract/view",[ContractsController::class,'view'])->name('contract_view');
    Route::get("/contract/delete",[ContractsController::class,'delete'])->name('contract_delete');

    Route::post("change_request_status", [ContractsController::class, 'change_request_status'])->name('request_status');


    // faqs
    Route::get("/faqs",[FaqsController::class,'faqs'])->name('faqs');
    Route::get("/faq/add",[FaqsController::class,'faq_add'])->name('faq_add');
    Route::get("/faq/delete",[FaqsController::class,'faq_delete'])->name('faq_delete');
    Route::post("/save_faqs",[FaqsController::class,'save_faqs']);

    // Work
    Route::get("/work_seeker",[WorkController::class,'work_seeker'])->name('work_seeker');
    Route::get("/work_seeker/add",[WorkController::class,'work_seeker_add'])->name('work_seeker_add');
    Route::get("/work_seeker/delete",[WorkController::class,'work_seeker_delete'])->name('work_seeker_delete');
    Route::post("/save_work_seeker",[WorkController::class,'save_work_seeker']);

    // Jobs

    Route::get("/All-jobs",[JobController::class,'all_jobs'])->name('all_jobs');
    Route::get("/Jobs-detail/{id}",[JobController::class,'admin_job_detail'])->name('admin_job_detail');
    Route::post("change_jobs_status", [JobController::class, 'change_jobs_status']);



    Route::get("/jobs_vacancies",[JobController::class,'jobs_vacancies'])->name('jobs_vacancies');
    Route::get("/admin_other_documents",[JobController::class,'other_documents'])->name('admin_other_documents');

    // job_types
    Route::get("/job_types",[JobTypeController::class,'job_types'])->name('job_types');
    Route::get("/job_type/add",[JobTypeController::class,'job_type_add'])->name('job_type_add');
    Route::get("/job_type/delete",[JobTypeController::class,'job_type_delete'])->name('job_type_delete');
    Route::post("/save_job_type",[JobTypeController::class,'save_job_type']);


    // Notification
    Route::get("/notifications",[NotificationsController::class,'notifications'])->name('notifications');
    Route::get("/notification/add",[NotificationsController::class,'notification_add'])->name('notification_add');
    Route::get("/notification/delete",[NotificationsController::class,'notification_delete'])->name('notification_delete');
    Route::post("/send_notification",[NotificationsController::class,'send_notification']);


    /////Chat
    Route::get("/chat",[ChatController::class,'index'])->name('admin_chat');
    Route::post("get_chat",[Controller::class,'get_chat'])->name('admin_get_chat');
    Route::post("send_chat",[Controller::class,'send_chat'])->name('admin_send_chat');

    // LIST

    /*applicants*/
    Route::get("ProviderList",[ListController::class,'providers_list'])->name('providers_list');
    Route::get("ProviderJobs/{id}",[ListController::class,'providers_jobs'])->name('providers_jobs');
    Route::get("ProviderApplicants/{id}",[ListController::class,'providers_applicants'])->name('providers_applicants');

    /*Employess*/
    Route::get("EmployesList",[ListController::class,'employes_list'])->name('employes_list');

    /*Seekeer ADV*/
    Route::get("SeekerAdvertisment",[ListController::class,'seeker_advertisment'])->name('seeker_advertisment');
    Route::get("EditAdvertisment/{id}",[ListController::class,'edit_advertisment'])->name('edit_advertisment');
    Route::post("update_advertisment",[ListController::class,'update_advertisment'])->name('update_advertisment');

    Route::post("change_advertisment_status", [ListController::class, 'change_advertisment_status']);

    /*Actual Conracts*/
    Route::get("ActualContracts",[ListController::class,'actual_contracts'])->name('actual_contracts');

    /*Seeker  other Documents*/
    Route::get("SeekerOtherDocuments",[ListController::class,'other_documents_from_seeker'])->name('other_documents_from_seeker');

    /*Provider other Documents*/
    Route::get("ProviderOtherDocuments",[ListController::class,'other_documents_from_provider'])->name('other_documents_from_provider');


    /*Seeker Documents*/
    Route::get("SeekerDocuments",[ListController::class,'documents_from_seeker'])->name('documents_from_seeker');

    /*Provider Documents*/
    Route::get("ProviderDocuments",[ListController::class,'documents_from_provider'])->name('documents_from_provider');    

    Route::get("OtherDocuments_Details/{id}",[ListController::class,'otherdocument_detail'])->name('otherdocument_detail');

});


Route::get('/clear-all', function() {
    Artisan::call('cache:clear');
    Artisan::call('optimize');
    Artisan::call('route:cache');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    return '<h1>Cache all value cleared</h1>';
});

//Clear Cache facade value:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});


//Reoptimized class loader:

Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:

Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:

Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});


//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});