<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\InformationController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\VendoController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\LegalStuffController;
use App\Http\Controllers\Admin\YachtController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\CustomerGroupController;
use App\Http\Controllers\Admin\AffiliateController;
use App\Http\Controllers\Admin\CarDetailsController;
use App\Http\Controllers\Admin\PartnersController;
use App\Http\Controllers\Admin\TestimonialsController;
use App\Http\Controllers\Admin\FaqsController;
use App\Http\Controllers\Admin\AffiliatePageController;
use App\Http\Controllers\Admin\GiftPageController;
use App\Http\Controllers\Admin\MediaPageController;

use App\Http\Controllers\Admin\CityGuideController;
use App\Http\Controllers\Admin\CityGuidePageController;
use App\Http\Controllers\Admin\BusTypeController;

use App\Http\Controllers\Admin\PartnerPageController;
use App\Http\Controllers\Admin\AboutUsPageController;
use App\Http\Controllers\Admin\MediaBlogController;
use App\Http\Controllers\Admin\AirportController;
use App\Http\Controllers\Admin\CarTypeController;
use App\Http\Controllers\Admin\CarModelController;
use App\Http\Controllers\Admin\TransferController;
use App\Http\Controllers\Admin\TimeController;
use App\Http\Controllers\Admin\LodgeController;
use App\Http\Controllers\Admin\ZoneController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\OverRideController;
use App\Http\Controllers\Admin\TransferPageController;
use App\Http\Controllers\Admin\TransportationVehicleController;
use App\Http\Controllers\Admin\LimousineController;
use App\Http\Controllers\Admin\HomePageController;
use App\Http\Controllers\Admin\AdvertismentPageController;
use App\Http\Controllers\Admin\JoinPageController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\LodgePageController;
use App\Http\Controllers\Admin\TourPageController;
use App\Http\Controllers\Admin\GolfController;
use App\Http\Controllers\Admin\GolfCourseController;
use App\Http\Controllers\Admin\GolfPageController;
use App\Http\Controllers\Admin\TermConditionPageController;
use App\Http\Controllers\Admin\TheInsiderPageController;
use App\Http\Controllers\Admin\HelpPageController;
use App\Http\Controllers\Admin\HotelPageController;
use App\Http\Controllers\Admin\CouponCodeController;
use App\Http\Controllers\Admin\CategoryPageController;
use App\Http\Controllers\Admin\CommissionController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Api\OrderController as ApiOrderController;
use App\Http\Controllers\Admin\ProductRequestController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\RewardShareController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\CurrencyController;
use Illuminate\Support\Facades\View;
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

// -------------Pdf Order Routess
 Route::get('generate_airport_voucher/{order_id}', [ApiOrderController::class, 'generate_airport_voucher'])->name('admin.generate_airport_voucher');
 Route::get('generate_product_voucher/{order_id}', [ApiOrderController::class, 'generate_product_voucher'])->name('admin.generate_product_voucher');

// -------------Pdf Order  Routess

 
Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('/dologin', [LoginController::class, 'dologin'])->name('dologin');
Route::match(['get', 'post'], 'forgot_pasword', [LoginController::class, 'forgot_pasword'])->name('forgot_pasword');
Route::get('reset_password/{token}', [LoginController::class, 'reset_password'])->name('reset_password');
Route::match(['get', 'post'], 'reset_password', [LoginController::class, 'reset_password'])->name('update_password');
Route::match(['get', 'post'], 'demoMAil', [LoginController::class, 'demoMAil'])->name('demoMAil');



//// After Login MiddelWare
Route::middleware(['adminAuth'])->group(function () {
    ///DashBoard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    ///logout
    Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');

    ///Profile
    Route::match(['get', 'post'], 'profile', [DashboardController::class, 'profile'])->name('admin.profile');
    Route::post('get-state-city', [DashboardController::class, 'get_state_city'])->name('admin.get_state_city');
    Route::post('get-airport', [DashboardController::class, 'get_airport'])->name('admin.get_airport');
    Route::post('get-zones', [DashboardController::class, 'get_zones'])->name('admin.get_zones');

    ///Change Password
    Route::match(['get', 'post'], 'change_password', [DashboardController::class, 'change_password'])->name('admin.change_password');

    Route::match(['get', 'post'], 'language_change', [DashboardController::class, 'language_change'])->name('admin.language_change');

    // Staff
    Route::get('staff', [StaffController::class, 'index'])->name('admin.staff');
    Route::match(['get', 'post'], 'staff/add', [StaffController::class, 'store'])->name('admin.staff.add');
    Route::get('staff/edit/{id}', [StaffController::class, 'store'])->name('admin.staff.edit');
    Route::get('staff/delete/{id}', [StaffController::class, 'delete'])->name('admin.staff.delete');

    //Supplier
    Route::get('supplier', [SupplierController::class, 'index'])->name('admin.supplier');
    Route::match(['get', 'post'], 'supplier/add', [SupplierController::class, 'store'])->name('admin.supplier.add');
    Route::get('supplier/edit/{id}', [SupplierController::class, 'store'])->name('admin.supplier.edit');
    Route::get('supplier/delete/{id}', [SupplierController::class, 'delete'])->name('admin.supplier.delete');

    //Order
    Route::match(['get', 'post'],'orders', [OrderController::class, 'index'])->name('admin.orders');
    Route::match(['get', 'post'], 'orders/add', [OrderController::class, 'store'])->name('admin.orders.add');
    Route::get('orders/edit/{id}', [OrderController::class, 'store'])->name('admin.orders.edit');
    Route::get('orders/view/{id}', [OrderController::class, 'order_view'])->name('admin.orders.view');
    Route::get('orders/airport_transfer_order_detail/{id}', [OrderController::class, 'airport_transfer_order_detail'])->name('admin.orders.airport_transfer_order_detail');
    Route::match(['get', 'post'], 'orders/cancel', [OrderController::class, 'order_cancel'])->name('admin.orders.cancel');

    // Generate Excel
    Route::match(['get', 'post'], 'generate_excel',[OrderController::class,'generate_excel'])->name('admin.generate_excel');

    // Order Supplier Update
    Route::match(['get', 'post'], 'order_supplier_update',[OrderController::class,'order_supplier_update'])->name('admin.order_supplier_update');


    Route::match(['get', 'post'],'reports', [ReportController::class, 'reports'])->name('admin.reports');
    Route::get('best-seller-reports', [ReportController::class, 'best_seller_report'])->name('admin.best_seller_report');

    // Upcoming booking Reports
    Route::match(['get', 'post'],'upcoming-booking-reports', [ReportController::class, 'upcoming_booking_report'])->name('admin.upcoming_booking_report');


    // Report Export
    Route::match(['get', 'post'],'sales_report_export', [ReportController::class, 'sales_report_export'])->name('admin.sales_report_export');
    Route::post('best_seller_report_export', [ReportController::class, 'best_seller_report_export'])->name('admin.best_seller_report_export');
    Route::match(['get', 'post'],'upcoming_booking_report_export', [ReportController::class, 'upcoming_booking_report_export'])->name('admin.upcoming_booking_report_export');


    //Coupon Code
    Route::get('coupon_code', [CouponCodeController::class, 'index'])->name('admin.coupon_code');
    Route::match(['get', 'post'], 'coupon_code/add', [CouponCodeController::class, 'store'])->name('admin.coupon_code.add');
    Route::get('coupon_code/edit/{id}', [CouponCodeController::class, 'store'])->name('admin.coupon_code.edit');
    Route::get('coupon_code/delete/{id}', [CouponCodeController::class, 'delete'])->name('admin.coupon_code.delete');

    ///Categroy
    Route::get('category', [CategoryController::class, 'index'])->name('admin.category');
    Route::match(['get', 'post'], 'category/add', [CategoryController::class, 'addCategory'])->name('admin.category.add');
    Route::get('category/edit/{id}', [CategoryController::class, 'addCategory'])->name('admin.category.edit');
    Route::get('category/delete/{id}', [CategoryController::class, 'delete'])->name('admin.category.delete');

    ///Posts
    Route::get('posts', [PostController::class, 'index'])->name('admin.posts');
    Route::match(['get', 'post'], 'posts/add', [PostController::class, 'addPost'])->name('admin.posts.add');
    Route::get('posts/edit/{id}', [PostController::class, 'addPost'])->name('admin.posts.edit');
    Route::get('posts/delete/{id}', [PostController::class, 'delete'])->name('admin.posts.delete');

    ///Reward Share
    Route::get('rewardshare', [RewardShareController::class, 'index'])->name('admin.rewardshare');
    Route::match(['get', 'post'], 'rewardshare/add', [RewardShareController::class, 'add_Reward'])->name('admin.rewardshare.add');
    Route::get('rewardshare/edit/{id}', [RewardShareController::class, 'add_Reward'])->name('admin.rewardshare.edit');
    Route::get('rewardshare/delete/{id}', [RewardShareController::class, 'delete'])->name('admin.rewardshare.delete');


    ///Customers
    Route::get('partners_list', [CustomerController::class, 'partners_list'])->name('admin.partners_list');
    Route::match(['get', 'post'], 'partners_list/add', [CustomerController::class, 'add_Partner'])->name('admin.partners_list.add');
    Route::get('partners_list/edit/{id}', [CustomerController::class, 'add_Partner'])->name('admin.partners_list.edit');
    Route::get('partners_list/delete/{id}', [CustomerController::class, 'delete'])->name('admin.partners_list.delete');


    ///Customers
    Route::get('user', [UserController::class, 'index'])->name('admin.user');
    Route::match(['get', 'post'], 'user/add', [UserController::class, 'add_User'])->name('admin.user.add');
    Route::get('user/edit/{id}', [UserController::class, 'add_User'])->name('admin.user.edit');
    Route::get('user/delete/{id}', [UserController::class, 'delete'])->name('admin.user.delete');


    ///Subscribers
    Route::get('subscribers', [SubscriberController::class, 'index'])->name('admin.subscribers');
    Route::match(['get', 'post'], 'subscribers/add', [SubscriberController::class, 'add_subscribers'])->name('admin.subscribers.add');
    Route::get('subscribers/edit/{id}', [SubscriberController::class, 'add_subscribers'])->name('admin.subscribers.edit');
    Route::get('subscribers/delete/{id}', [SubscriberController::class, 'delete'])->name('admin.subscribers.delete');


    ///Reviews
    Route::get('user_reviews', [ReviewController::class, 'index'])->name('admin.user_reviews');
    Route::post('reviewstatus', [ReviewController::class, 'reviewstatus'])->name('admin.reviewstatus');

    ///Settings
    Route::match(['get', 'post'], 'settings', [SettingsController::class, 'settings'])->name('admin.settings');
    Route::match(['get', 'post'], 'get-append-view', [SettingsController::class, 'get_append_view'])->name('admin.get_append_view');

    // Products
    Route::get('excursion', [ProductController::class, 'index'])->name('admin.excursion');
    Route::get('excursion/fetch_data', ['as' => 'fetch_data', 'uses' => 'HomeController@fetch_data']);
    Route::any('excursion/fetch_data', [ProductController::class, 'fetch_data'])->name('admin.fetch_data');
    Route::match(['get', 'post'], 'product/add', [ProductController::class, 'addProduct'])->name('admin.excursion.add');
    Route::get('excursion/edit/{id}', [ProductController::class, 'addProduct'])->name('admin.excursion.edit');
    Route::post('get_subcategory_by_category', [ProductController::class, 'get_subcategory_by_category'])->name('admin.get_subcategory_by_category');
    Route::post('get_car_list', [ProductController::class, 'get_car_list'])->name('admin.get_car_list');
    Route::post('add_car_session', [ProductController::class, 'add_car_session'])->name('admin.add_car_session');
    Route::get('excursion/delete/{id}', [ProductController::class, 'delete'])->name('admin.excursion.delete');
    Route::get('excursion/duplicate/{id}', [ProductController::class, 'duplicate'])->name('admin.excursion.duplicate');

    //Lodge
    Route::get('lodge', [LodgeController::class, 'index'])->name('admin.lodge');
    Route::match(['get', 'post'], 'lodge/add', [LodgeController::class, 'addLodge'])->name('admin.lodge.add');
    Route::get('lodge/edit/{id}', [LodgeController::class, 'addLodge'])->name('admin.lodge.edit');
    Route::get('lodge/delete/{id}', [LodgeController::class, 'delete'])->name('admin.lodge.delete');
    Route::get('lodge/duplicate/{id}', [LodgeController::class, 'duplicate'])->name('admin.lodge.duplicate');

    Route::post("delete_single_lodge", [LodgeController::class, 'delete_single_lodge'])->name('delete_single_lodge');


    ///Time Slot
    Route::get('time_slot', [TimeController::class, 'index'])->name('admin.time_slot');
    Route::match(['get', 'post'], 'time_slot/add', [TimeController::class, 'addTime'])->name('admin.time_slot.add');
    Route::get('time_slot/edit/{id}', [TimeController::class, 'addTime'])->name('admin.time_slot.edit');
    Route::get('time_slot/delete/{id}', [TimeController::class, 'delete'])->name('admin.time_slot.delete');

    // Car details
    Route::get('car_details', [CarDetailsController::class, 'index'])->name('admin.car_details');
    Route::match(['get', 'post'], 'car_details/add', [CarDetailsController::class, 'addCarDetails'])->name('admin.car_details.add');
    Route::get('car_details/edit/{id}', [CarDetailsController::class, 'addCarDetails'])->name('admin.car_details.edit');
    Route::get('car_details/delete/{id}', [CarDetailsController::class, 'delete'])->name('admin.car_details.delete');

    //Affiliate
    Route::get('affiliate', [AffiliateController::class, 'index'])->name('admin.affiliate');
    Route::match(['get', 'post'], 'affiliate/add', [AffiliateController::class, 'store'])->name('admin.affiliate.add');
    Route::get('affiliate/edit/{id}', [AffiliateController::class, 'store'])->name('admin.affiliate.edit');
    Route::get('affiliate/view/{id}', [AffiliateController::class, 'view'])->name('admin.affiliate.view');
    Route::get('affiliate/delete/{id}', [AffiliateController::class, 'delete'])->name('admin.affiliate.delete');

    //Commission
    Route::get('commission', [CommissionController::class, 'index'])->name('admin.commission');
    Route::match(['get', 'post'], 'commission/add', [CommissionController::class, 'store'])->name('admin.commission.add');
    Route::get('commission/edit/{id}', [CommissionController::class, 'store'])->name('admin.commission.edit');
    Route::get('commission/view/{id}', [CommissionController::class, 'commission_view'])->name('admin.commission.view');

    Route::match(['get', 'post'],'add_comission_history', [CommissionController::class, 'add_comission_history'])->name('admin.add_comission_history');


    ///legal Stufff
    Route::get('legal_stuff', [LegalStuffController::class, 'index'])->name('admin.legal_stuff');
    Route::match(['get', 'post'], 'legal_stuff/add', [LegalStuffController::class, 'addLegalstuff'])->name('admin.legal_stuff.add');
    Route::get('legal_stuff/edit/{id}', [LegalStuffController::class, 'addLegalstuff'])->name('admin.legal_stuff.edit');
    Route::get('legal_stuff/delete/{id}', [LegalStuffController::class, 'delete'])->name('admin.legal_stuff.delete');

    ///Yacht
    Route::get('yachtes', [YachtController::class, 'index'])->name('admin.yachtes');
    Route::match(['get', 'post'], 'yachtes/add', [YachtController::class, 'addYacht'])->name('admin.addYacht');
    Route::get('yacht/edit/{id}', [YachtController::class, 'addYacht'])->name('admin.yacht.edit');
    Route::get('yacht/delete/{id}', [YachtController::class, 'delete'])->name('admin.yacht.delete');
    Route::get('yacht/duplicate/{id}', [YachtController::class, 'duplicate'])->name('admin.yacht.duplicate');

    ///Limousine
    Route::get('limousine', [LimousineController::class, 'index'])->name('admin.limousine');
    Route::match(['get', 'post'], 'limousine/add', [LimousineController::class, 'addlimousine'])->name('admin.addlimousine');
    Route::get('limousine/edit/{id}', [LimousineController::class, 'addlimousine'])->name('admin.limousine.edit');
    Route::get('limousine/delete/{id}', [LimousineController::class, 'delete'])->name('admin.limousine.delete');
    Route::get('limousine/duplicate/{id}', [LimousineController::class, 'duplicate'])->name('admin.limousine.duplicate');


    ///Golf 
    Route::get('golf', [GolfController::class, 'index'])->name('admin.golf');
    Route::match(['get', 'post'], 'golf/add', [GolfController::class, 'addgolf'])->name('admin.addgolf');
    Route::get('golf/edit/{id}', [GolfController::class, 'addgolf'])->name('admin.golf.edit');
    Route::get('golf/delete/{id}', [GolfController::class, 'delete'])->name('admin.golf.delete');
    Route::get('golf/duplicate/{id}', [GolfController::class, 'duplicate'])->name('admin.golf.duplicate');


    ///Golf Courses
    Route::get('golf_courses', [GolfCourseController::class, 'index'])->name('admin.golf_courses');
    Route::match(['get', 'post'], 'golf_courses/add', [GolfCourseController::class, 'add_golf_courses'])->name('admin.golf_courses.add');
    Route::get('golf_courses/edit/{id}', [GolfCourseController::class, 'add_golf_courses'])->name('admin.golf_courses.edit');
    Route::get('golf_courses/delete/{id}', [GolfCourseController::class, 'delete'])->name('admin.golf_courses.delete');


    ///Blog Category
    Route::get('blog_category', [BlogController::class, 'blogsCategory'])->name('admin.blogsCategory');
    Route::match(['get', 'post'], 'blog_category/add', [BlogController::class, 'addBlogCategory'])->name('admin.blogsCategory.add');
    Route::get('blog_category/edit/{id}', [BlogController::class, 'addBlogCategory'])->name('admin.blogsCategory.edit');
    Route::get('blog_category/delete/{id}', [BlogController::class, 'deleteBlogCategory'])->name('admin.blogsCategory.delete');

    ///Blog Category
    Route::get('blogs', [BlogController::class, 'blogs'])->name('admin.blogs');
    Route::match(['get', 'post'], 'blogs/add', [BlogController::class, 'addBlog'])->name('admin.blogs.add');
    Route::get('blogs/edit/{id}', [BlogController::class, 'addBlog'])->name('admin.blogs.edit');
    Route::get('blogs/delete/{id}', [BlogController::class, 'deleteBlog'])->name('admin.blogs.delete');

    //Language
    Route::get('language', [LanguageController::class, 'index'])->name('admin.language');
    Route::match(['get', 'post'], 'language/add', [LanguageController::class, 'store'])->name('admin.language.add');
    Route::get('language/edit/{id}', [LanguageController::class, 'store'])->name('admin.language.edit');
    Route::get('language/delete/{id}', [LanguageController::class, 'delete'])->name('admin.language.delete');


    //Currency
    Route::get('currency', [CurrencyController::class, 'index'])->name('admin.currency');
    Route::match(['get', 'post'], 'currency/add', [CurrencyController::class, 'store'])->name('admin.currency.add');
    Route::get('currency/edit/{id}', [CurrencyController::class, 'store'])->name('admin.currency.edit');
    Route::get('currency/delete/{id}', [CurrencyController::class, 'delete'])->name('admin.currency.delete');


    // Get Category By Country
    Route::post('get-category-by-country', [ProductController::class, 'get_category_by_country'])->name('admin.get_category_by_country');

    //Customer Groutp
    Route::get('customerGroup', [CustomerGroupController::class, 'index'])->name('admin.customerGroup');
    Route::match(['get', 'post'], 'customerGroup/add', [CustomerGroupController::class, 'addCustomerGroup'])->name('admin.customerGroup.add');
    Route::match(['get', 'post'], 'customerGroup/edit/{id}', [CustomerGroupController::class, 'addCustomerGroup'])->name('admin.customerGroup.edit');
    Route::get('customerGroup/delete/{id}', [CustomerGroupController::class, 'delete'])->name('admin.customerGroup.delete');

    ///Partners
    Route::get('partners', [PartnersController::class, 'index'])->name('admin.partners');
    Route::match(['get', 'post'], 'partners/add', [PartnersController::class, 'addPartners'])->name('admin.partners.add');
    Route::get('partners/edit/{id}', [PartnersController::class, 'addPartners'])->name('admin.partners.edit');
    Route::get('partners/delete/{id}', [PartnersController::class, 'delete'])->name('admin.partners.delete');

    ///Testimonials
    Route::get('testimonials', [TestimonialsController::class, 'index'])->name('admin.testimonials');
    Route::match(['get', 'post'], 'testimonials/add', [TestimonialsController::class, 'addTestimonials'])->name('admin.testimonials.add');
    Route::get('testimonials/edit/{id}', [TestimonialsController::class, 'addTestimonials'])->name('admin.testimonials.edit');
    Route::get('testimonials/delete/{id}', [TestimonialsController::class, 'delete'])->name('admin.testimonials.delete');


    ///Gift An Expirence
    Route::match(['get', 'post'], 'gift_an_expirence/add', [TestimonialsController::class, 'giftAnexpirence'])->name('admin.gift_an_expirence.add');





    ///Faqs
    Route::get('faqs', [FaqsController::class, 'index'])->name('admin.faqs');
    Route::match(['get', 'post'], 'faqs/add', [FaqsController::class, 'addFaqs'])->name('admin.faqs.add');
    Route::get('faqs/edit/{id}', [FaqsController::class, 'addFaqs'])->name('admin.faqs.edit');
    Route::get('faqs/delete/{id}', [FaqsController::class, 'delete'])->name('admin.faqs.delete');

    ///Faqs Category
    Route::get('faq_category', [FaqsController::class, 'faq_category'])->name('admin.faq_category');
    Route::match(['get', 'post'], 'faq_category/add', [FaqsController::class, 'add_faq_category'])->name('admin.faq_category.add');
    Route::get('faq_category/edit/{id}', [FaqsController::class, 'add_faq_category'])->name('admin.faq_category.edit');
    Route::get('faq_category/category_delete/{id}', [FaqsController::class, 'category_delete'])->name('admin.faq_category.category_delete');


    // City Guide Page
    Route::get('city_guide', [CityGuideController::class, 'index'])->name('admin.city_guide');
    Route::match(['get', 'post'], 'city_guide/add', [CityGuideController::class, 'add_city_guide'])->name('admin.city_guide.add');
    Route::get('city_guide/edit/{id}', [CityGuideController::class, 'add_city_guide'])->name('admin.city_guide.edit');
    Route::get('city_guide/delete/{id}', [CityGuideController::class, 'delete'])->name('admin.city_guide.delete');

    Route::get('city_guide/duplicate/{id}', [CityGuideController::class, 'duplicate'])->name('admin.city_guide.duplicate');
    

       



    // PAGES=======================

    // Home Page
    Route::match(['get', 'post'], 'home_page/add', [HomePageController::class, 'add_home_page'])->name('admin.home_page.add');
    Route::get('home_page/edit/{id}', [HomePageController::class, 'add_home_page'])->name('admin.home_page.edit');

    Route::match(['get', 'post'], 'home_popup', [HomePageController::class, 'home_popup'])->name('admin.home_popup');

    //Lodge List
    Route::match(['get', 'post'], 'lodge_page/add', [LodgePageController::class, 'add_lodge_page'])->name('admin.lodge_page.add');
    Route::get('lodge_page/edit/{id}', [LodgePageController::class, 'add_lodge_page'])->name('admin.lodge_page.edit');

    //Tour List
    Route::match(['get', 'post'], 'tour_page/add', [TourPageController::class, 'add_tour_page'])->name('admin.tour_page.add');
    Route::get('tour_page/edit/{id}', [TourPageController::class, 'add_tour_page'])->name('admin.tour_page.edit');

    ///Partners
    Route::match(['get', 'post'], 'side_banner/add', [HomePageController::class, 'addSideBanner'])->name('admin.side_banner.add');
    Route::get('side_banner/edit/{id}', [HomePageController::class, 'addSideBanner'])->name('admin.side_banner.edit');

    ///Partners
    Route::match(['get', 'post'], 'profile_banner/add', [HomePageController::class, 'addProfileBanner'])->name('admin.profile_banner.add');
    Route::get('profile_banner/edit/{id}', [HomePageController::class, 'addProfileBanner'])->name('admin.profile_banner.edit');

    // Affiliate Page
    Route::match(['get', 'post'], 'affiliate_page/add', [AffiliatePageController::class, 'add_affiliate_page'])->name('admin.affiliate_page.add');
    Route::get('affiliate_page/edit/{id}', [AffiliatePageController::class, 'add_affiliate_page'])->name('admin.affiliate_page.edit');

    // Gift Card Page
    // Route::get('giftcard_page', [GiftPageController::class, 'index'])->name('admin.giftcard_page');
    Route::match(['get', 'post'], 'giftcard_page/add', [GiftPageController::class, 'add_giftcard_page'])->name('admin.giftcard_page.add');
    Route::get('giftcard_page/edit/{id}', [GiftPageController::class, 'add_giftcard_page'])->name('admin.giftcard_page.edit');
    // Route::get('giftcard_page/delete/{id}', [GiftPageController::class, 'delete'])->name('admin.giftcard_page.delete');

    // Media Mension Page
    // Route::get('media_mension_page', [MediaPageController::class, 'index'])->name('admin.media_mension_page');
    Route::match(['get', 'post'], 'media_mension_page/add', [MediaPageController::class, 'add_media_mension_page'])->name('admin.media_mension_page.add');
    Route::get('media_mension_page/edit/{id}', [MediaPageController::class, 'add_media_mension_page'])->name('admin.media_mension_page.edit');
    // Route::get('media_mension_page/delete/{id}', [MediaPageController::class, 'delete'])->name('admin.media_mension_page.delete');

    // City Guide Page
    // Route::get('city_guide_page', [CityGuidePageController::class, 'index'])->name('admin.city_guide_page');
    Route::match(['get', 'post'], 'city_guide_page/add', [CityGuidePageController::class, 'add_city_guide_page'])->name('admin.city_guide_page.add');
    Route::get('city_guide_page/edit/{id}', [CityGuidePageController::class, 'add_city_guide_page'])->name('admin.city_guide_page.edit');
    // Route::get('city_guide_page/delete/{id}', [CityGuidePageController::class, 'delete'])->name('admin.city_guide_page.delete');

    // Partner Page
    // Route::get('partner_page', [PartnerPageController::class, 'index'])->name('admin.partner_page');
    Route::match(['get', 'post'], 'partner_page/add', [PartnerPageController::class, 'add_partner_page'])->name('admin.partner_page.add');
    Route::get('partner_page/edit/{id}', [PartnerPageController::class, 'add_partner_page'])->name('admin.partner_page.edit');
    // Route::get('partner_page/delete/{id}', [PartnerPageController::class, 'delete'])->name('admin.partner_page.delete');

    // Golf Page
    // Route::get('golf_page', [GolfPageController::class, 'index'])->name('admin.golf_page');
    Route::match(['get', 'post'], 'golf_page/add', [GolfPageController::class, 'add_golf_page'])->name('admin.golf_page.add');
    Route::get('golf_page/edit/{id}', [GolfPageController::class, 'add_golf_page'])->name('admin.golf_page.edit');
    // Route::get('golf_page/delete/{id}', [GolfPageController::class, 'delete'])->name('admin.golf_page.delete');


    // About Us Page
    Route::match(['get', 'post'], 'about_us_page/add', [AboutUsPageController::class, 'add_about_us_page'])->name('admin.about_us_page.add');
    Route::get('about_us_page/edit/{id}', [AboutUsPageController::class, 'add_about_us_page'])->name('admin.about_us_page.edit');

    //AdverTisment with us page
    Route::match(['get', 'post'], 'advertise_us_page/add', [AdvertismentPageController::class, 'add_adv_us_page'])->name('admin.advertise_us_page.add');
    Route::get('advertise_us_page/edit/{id}', [AdvertismentPageController::class, 'add_adv_us_page'])->name('admin.advertise_us_page.edit');

    Route::get('tranfer_page/edit/{id}', [TransferPageController::class, 'add_transfer_page'])->name('admin.transfer_page.edit');
    Route::match(['get', 'post'], 'tranfer_page/add', [TransferPageController::class, 'add_transfer_page'])->name('admin.transfer_page.add');


    Route::get('limousine_page/edit/{id}', [PagesController::class, 'add_limousine_page'])->name('admin.limousine_page.edit');
    Route::match(['get', 'post'], 'limousine_page/add', [PagesController::class, 'add_limousine_page'])->name('admin.limousine_page.add');

    Route::get('yacht_page/edit/{id}', [PagesController::class, 'add_yacht_page'])->name('admin.yacht_page.edit');
    Route::match(['get', 'post'], 'yacht_page/add', [PagesController::class, 'add_yacht_page'])->name('admin.yacht_page.add');

    Route::get('blog_page/edit/{id}', [PagesController::class, 'add_blog_page'])->name('admin.blog_page.edit');
    Route::match(['get', 'post'], 'blog_page/add', [PagesController::class, 'add_blog_page'])->name('admin.blog_page.add');

    //AdverTisment with us page
    Route::match(['get', 'post'], 'join_us_page/add', [JoinPageController::class, 'add_join_us_page'])->name('admin.join_us_page.add');
    Route::get('join_us_page/edit/{id}', [JoinPageController::class, 'add_join_us_page'])->name('admin.join_us_page.edit');

    //Terms & Condition page
    Route::match(['get', 'post'], 'term_condition_page/add', [TermConditionPageController::class, 'add_term_condition_page'])->name('admin.term_condition_page.add');
    Route::get('term_condition_page/edit/{id}', [TermConditionPageController::class, 'add_term_condition_page'])->name('admin.term_condition_page.edit');

    //The Insider
    Route::match(['get', 'post'], 'the_insider/add', [TheInsiderPageController::class, 'add_the_insider_page'])->name('admin.the_insider_page.add');
    Route::get('the_insider/edit/{id}', [TheInsiderPageController::class, 'add_the_insider_page'])->name('admin.the_insider_page.edit');

    //Help
    Route::match(['get', 'post'], 'help_page/add', [HelpPageController::class, 'add_help_page'])->name('admin.help_page.add');
    Route::get('help_page/edit/{id}', [HelpPageController::class, 'add_help_page'])->name('admin.help_page.edit');

    //Category Page
    Route::match(['get', 'post'], 'category_page/add', [CategoryPageController::class, 'add_category_page'])->name('admin.category_page.add');
    Route::get('category_page/edit/{id}', [CategoryPageController::class, 'add_category_page'])->name('admin.category_page.edit');
    // End PAGES=======================

    ///media blogs
    Route::get('media_blogs', [MediaBlogController::class, 'index'])->name('admin.media_blogs');
    Route::match(['get', 'post'], 'media_blogs/add', [MediaBlogController::class, 'addMedia_blog'])->name('admin.media_blogs.add');
    Route::get('media_blogs/edit/{id}', [MediaBlogController::class, 'addMedia_blog'])->name('admin.media_blogs.edit');
    Route::get('media_blogs/delete/{id}', [MediaBlogController::class, 'delete'])->name('admin.media_blogs.delete');

    ///Airport
    Route::get('airport', [AirportController::class, 'index'])->name('admin.airport');
    Route::match(['get', 'post'], 'airport/add', [AirportController::class, 'addAirport'])->name('admin.airport.add');
    Route::get('airport/edit/{id}', [AirportController::class, 'addAirport'])->name('admin.airport.edit');
    Route::get('airport/delete/{id}', [AirportController::class, 'delete'])->name('admin.airport.delete');

    ///Car type
    Route::get('car_type', [CarTypeController::class, 'index'])->name('admin.car_type');
    Route::match(['get', 'post'], 'car_type/add', [CarTypeController::class, 'add_car_type'])->name('admin.car_type.add');
    Route::get('car_type/edit/{id}', [CarTypeController::class, 'add_car_type'])->name('admin.car_type.edit');
    Route::get('car_type/delete/{id}', [CarTypeController::class, 'delete'])->name('admin.car_type.delete');

    ///Bus type
    Route::get('bus_type', [BusTypeController::class, 'index'])->name('admin.bus_type');
    Route::match(['get', 'post'], 'bus_type/add', [BusTypeController::class, 'add_bus_type'])->name('admin.bus_type.add');
    Route::get('bus_type/edit/{id}', [BusTypeController::class, 'add_bus_type'])->name('admin.bus_type.edit');
    Route::get('bus_type/delete/{id}', [BusTypeController::class, 'delete'])->name('admin.bus_type.delete');

    ///Car Model
    Route::get('car_model', [CarModelController::class, 'index'])->name('admin.car_model');
    Route::match(['get', 'post'], 'car_model/add', [CarModelController::class, 'addCarmodels'])->name('admin.car_model.add');
    Route::get('car_model/edit/{id}', [CarModelController::class, 'addCarmodels'])->name('admin.car_model.edit');
    Route::get('car_model/delete/{id}', [CarModelController::class, 'delete'])->name('admin.car_model.delete');

    // TRANSFER
    Route::match(['get', 'post'], 'transfer', [TransferController::class, 'index'])->name('admin.transfer');
    Route::match(['get', 'post'], 'transfer/add', [TransferController::class, 'addTransfer'])->name('admin.transfer.add');
    Route::get('transfer/edit/{id}', [TransferController::class, 'addTransfer'])->name('admin.transfer.edit');
    Route::get('transfer/delete/{id}', [TransferController::class, 'delete'])->name('admin.transfer.delete');
    Route::get('transfer/duplicate/{id}', [TransferController::class, 'duplicate'])->name('admin.transfer.duplicate');

    Route::post('get-locations', [TransferController::class, 'get_locations'])->name('admin.get_locations');


    ///Zones
    Route::get('zones', [ZoneController::class, 'index'])->name('admin.zones');
    Route::get('zoneExport', [ZoneController::class, 'zoneExport'])->name('admin.zoneExport');
    Route::match(['get', 'post'], 'zones/add', [ZoneController::class, 'add_zones'])->name('admin.zones.add');
    Route::get('zones/edit/{id}', [ZoneController::class, 'add_zones'])->name('admin.zones.edit');
    Route::get('zones/delete/{id}', [ZoneController::class, 'delete'])->name('admin.zones.delete');

    ///Locations
    Route::get('exportLocation', [LocationController::class, 'exportLocation'])->name('admin.locations.exportLocation');
    Route::get('locations', [LocationController::class, 'index'])->name('admin.locations');
    Route::match(['get', 'post'], 'locations/add', [LocationController::class, 'add_locations'])->name('admin.locations.add');
    Route::get('locations/edit/{id}', [LocationController::class, 'add_locations'])->name('admin.locations.edit');
    Route::get('locations/delete/{id}', [LocationController::class, 'delete'])->name('admin.locations.delete');

    Route::get('locations_list', [LocationController::class, 'locations_list'])->name('admin.locations_list');
    Route::match(['get', 'post'], 'locations/bulk_location_add', [LocationController::class, 'bulk_location_add'])->name('admin.locations.bulk_location_add');

    ///Countries
    Route::get('countries', [SettingsController::class, 'countries'])->name('admin.countries');
    Route::match(['get', 'post'], 'countries/add', [SettingsController::class, 'add_countries'])->name('admin.countries.add');
    Route::get('countries/edit/{id}', [SettingsController::class, 'add_countries'])->name('admin.countries.edit');
    Route::get('countries/delete_countries/{id}', [SettingsController::class, 'delete_countries'])->name('admin.countries.delete_countries');

    ///States
    Route::get('states', [SettingsController::class, 'states'])->name('admin.states');
    Route::match(['get', 'post'], 'states/add', [SettingsController::class, 'add_states'])->name('admin.states.add');
    Route::get('states/edit/{id}', [SettingsController::class, 'add_states'])->name('admin.states.edit');
    Route::get('states/delete_states/{id}', [SettingsController::class, 'delete_states'])->name('admin.states.delete_states');

    ///Cities
    Route::get('cities', [SettingsController::class, 'cities'])->name('admin.cities');
    Route::match(['get', 'post'], 'cities/add', [SettingsController::class, 'add_cities'])->name('admin.cities.add');
    Route::get('cities/edit/{id}', [SettingsController::class, 'add_cities'])->name('admin.cities.edit');
    Route::get('cities/delete_cities/{id}', [SettingsController::class, 'delete_cities'])->name('admin.cities.delete_cities');


    ///Boat Locations
    Route::get('boat_locations', [SettingsController::class, 'boat_locations'])->name('admin.boat_locations');
    Route::match(['get', 'post'], 'boat_locations/add', [SettingsController::class, 'add_boat_locations'])->name('admin.boat_locations.add');
    Route::get('boat_locations/edit/{id}', [SettingsController::class, 'add_boat_locations'])->name('admin.boat_locations.edit');
    Route::get('boat_locations/delete_boat_locations/{id}', [SettingsController::class, 'delete_boat_locations'])->name('admin.boat_locations.delete_boat_locations');

    ///Boat Types
    Route::get('boat_types', [SettingsController::class, 'boat_types'])->name('admin.boat_types');
    Route::match(['get', 'post'], 'boat_types/add', [SettingsController::class, 'add_boat_types'])->name('admin.boat_types.add');
    Route::get('boat_types/edit/{id}', [SettingsController::class, 'add_boat_types'])->name('admin.boat_types.edit');
    Route::get('boat_types/delete_boat_types/{id}', [SettingsController::class, 'delete_boat_types'])->name('admin.boat_types.delete_boat_types');


    ///Request Controller 
    Route::get('product_request', [ProductRequestController::class, 'product_request'])->name('admin.product_request');
    Route::get('product_request/view/{id}', [ProductRequestController::class, 'product_request_view'])->name('admin.product_request.view');



    //Limousine Types
    Route::get('limousine_types', [LimousineController::class, 'limousine_types'])->name('admin.limousine_types');
    Route::match(['get', 'post'], 'limousine_types/add', [LimousineController::class, 'add_limousine_types'])->name('admin.limousine_types.add');
    Route::get('limousine_types/edit/{id}', [LimousineController::class, 'add_limousine_types'])->name('admin.limousine_types.edit');
    Route::get('limousine_types/delete_limousine_types/{id}', [LimousineController::class, 'delete_limousine_types'])->name('admin.limousine_types.delete');


    ///Limousine Locations
    Route::get('limousine_locations', [LimousineController::class, 'limousine_locations'])->name('admin.limousine_locations');
    Route::match(['get', 'post'], 'limousine_locations/add', [LimousineController::class, 'add_limousine_locations'])->name('admin.limousine_locations.add');
    Route::get('limousine_locations/edit/{id}', [LimousineController::class, 'add_limousine_locations'])->name('admin.limousine_locations.edit');
    Route::get('limousine_locations/delete_boat_locations/{id}', [LimousineController::class, 'delete_limousine_locations'])->name('admin.limousine_locations.delete');

    ///Over Ride 
    Route::match(['get', 'post'], 'override_banner/add', [OverRideController::class, 'addBanner'])->name('admin.override_banner.add');
    Route::get('override_banner/edit/{id}', [OverRideController::class, 'addBanner'])->name('admin.override_banner.edit');

    Route::post("delete_single_banner", [OverRideController::class, 'delete_single_banner'])->name('delete_single_banner');

    ///Social Media
    Route::match(['get', 'post'], 'social_media/add', [SettingsController::class, 'addSocialMedia'])->name('admin.social_media.add');
    Route::get('social_media/edit/{id}', [SettingsController::class, 'addSocialMedia'])->name('admin.social_media.edit');

    ///Advertsiment banner
    Route::match(['get', 'post'], 'advertisment_banner/add', [SettingsController::class, 'addAdvertisment'])->name('admin.advertisment_banner.add');
    Route::get('advertisment_banner/edit/{id}', [SettingsController::class, 'addAdvertisment'])->name('admin.advertisment_banner.edit');

    //Send Notification 
    Route::match(['get', 'post'], 'send_notification/send', [SettingsController::class, 'send_notification'])->name('admin.send_notification.send');

    ///Contact setting
    Route::match(['get', 'post'], 'contact_setting/add', [SettingsController::class, 'add_contact_setting'])->name('admin.contact_setting.add');
    Route::get('contact_setting/edit/{id}', [SettingsController::class, 'add_contact_setting'])->name('admin.contact_setting.edit');

    
    ///Transportation Vehicle
    Route::get('transportationvehicle', [TransportationVehicleController::class, 'index'])->name('admin.transportation_vehicle');
    Route::match(['get', 'post'], 'transportation_vehicle/add', [TransportationVehicleController::class, 'add_transportation_vehicle'])->name('admin.transportation_vehicle.add');
    Route::get('transportationvehicle/edit/{id}', [TransportationVehicleController::class, 'add_transportation_vehicle'])->name('admin.transportation_vehicle.edit');
    Route::get('transportationvehicle/delete/{id}', [TransportationVehicleController::class, 'delete'])->name('admin.transportation_vehicle.delete');


    // Hotel Page
    Route::get('hotel_page', [HotelPageController::class, 'index'])->name('admin.hotel_page');
    Route::match(['get', 'post'], 'hotel_page/add', [HotelPageController::class, 'add_hotel_page'])->name('admin.hotel_page.add');
    Route::get('hotel_page/edit/{id}', [HotelPageController::class, 'add_hotel_page'])->name('admin.hotel_page.edit');
    Route::get('hotel_page/delete/{id}', [HotelPageController::class, 'delete'])->name('admin.hotel_page.delete');

    //Product Append Views
    Route::match(['get', 'post'], 'dummy', [ProductController::class, 'dummy'])->name('admin.dummy');
});


Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('optimize:clear');
    echo 'Clear d';
    die();
});
