<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\InterestsController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\GuideController;
use App\Http\Controllers\Admin\RecommendedThingsController;
use App\Http\Controllers\Admin\AddOnController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\GearController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\InclusionController;
use App\Http\Controllers\Admin\RestrictionController;
use App\Http\Controllers\Admin\MealTypeController;
use App\Http\Controllers\Admin\TimeofDayController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TransportationController;
use App\Http\Controllers\Admin\ProductTypeController;
use App\Http\Controllers\Admin\TopDestinationController;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\Admin\TopAttractionController;
use App\Http\Controllers\Admin\AffiliateController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\TransactionHistoryController;
use App\Http\Controllers\Admin\ReportController;

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

Route::middleware(['checkLogin'])->group(function () {
    Route::match(['get', 'post'], '/', [LoginController::class, 'login'])->name('login');
    Route::match(['get', 'post'], '/login', [LoginController::class, 'login'])->name('dologin');
    Route::match(['get', 'post'], '/forgot_password', [LoginController::class, 'forgot_password'])->name('forgot_password');
    Route::get('reset_password/{user_id}', [LoginController::class, 'reset_password'])->name('reset_password');
});

// MiddleWare Admin
Route::middleware(['adminAuth'])->group(function () {
    Route::match(['get', 'post'], '/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::match(['get', 'post'], '/profile', [DashboardController::class, 'profileUpdate'])->name('admin.profile');
    Route::match(['get', 'post'], '/logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::match(['get', 'post'], '/changepassword', [UserController::class, 'changepassword'])->name('admin.changepassword');
    Route::match(['get', 'post'], '/changelanguage/{lng}', [DashboardController::class, 'changelanguage'])->name('admin.changelanguage');

    Route::match(['get', 'post'], 'language_change', [DashboardController::class, 'language_change'])->name('admin.language_change');
    // ChangePassword
    Route::match(['get', 'post'], '/settings', [SettingController::class, 'settings'])->name('admin.settings');
    Route::match(['get', 'post'], 'get-append-view', [SettingController::class, 'get_append_view'])->name('admin.get_append_view');

    // get state city
    Route::post('get-state-city', [DashboardController::class, 'get_state_city'])->name('admin.get_state_city');

    ///Categroy
    Route::get('categories', [CategoriesController::class, 'index'])->name('admin.categories');
    Route::match(['get', 'post'], 'categories/add', [CategoriesController::class, 'add_category'])->name('admin.categories.add');
    Route::get('categories/edit/{id}', [CategoriesController::class, 'add_category'])->name('admin.categories.edit');
    Route::get('categories/delete/{id}', [CategoriesController::class, 'delete'])->name('admin.categories.delete');


    ///Interest
    Route::get('interests', [InterestsController::class, 'index'])->name('admin.interests');
    Route::match(['get', 'post'], 'interests/add', [InterestsController::class, 'add_interest'])->name('admin.interests.add');
    Route::get('interests/edit/{id}', [InterestsController::class, 'add_interest'])->name('admin.interests.edit');
    Route::get('interests/delete/{id}', [InterestsController::class, 'delete'])->name('admin.interests.delete');

    // Services
    Route::get('services', [ServiceController::class, 'index'])->name('admin.services');
    Route::match(['get', 'post'], 'services/add', [ServiceController::class, 'add_services'])->name('admin.services.add');
    Route::get('services/edit/{id}', [ServiceController::class, 'add_services'])->name('admin.services.edit');
    Route::get('services/delete/{id}', [ServiceController::class, 'delete'])->name('admin.services.delete');

    // Our Partners
    Route::get('partners', [PartnerController::class, 'index'])->name('admin.partners');
    Route::match(['get', 'post'], 'partners/add', [PartnerController::class, 'add_partners'])->name('admin.partners.add');
    Route::get('partners/edit/{id}', [PartnerController::class, 'add_partners'])->name('admin.partners.edit');
    Route::get('partners/delete/{id}', [PartnerController::class, 'delete'])->name('admin.partners.delete');






    // Our Partners Accotuns
    Route::match(['get', 'post'], 'partner-account', [UserController::class, 'partners'])->name('admin.partner_account');
    Route::post('change-status', [UserController::class, 'change_status'])->name('admin.change_status');
    Route::match(['get', 'post'], 'partner-account/add', [UserController::class, 'add_partner_account'])->name('admin.partner_account.add');
    Route::get('partner-account/edit/{id}', [UserController::class, 'add_partner_account'])->name('admin.partner_account.edit');
    Route::get('partner-account/delete/{id}', [UserController::class, 'delete'])->name('admin.partner_account.delete');

    Route::match(['get', 'post'], 'users_list', [UserController::class, 'users_list'])->name('admin.users_list');


    // Affiliate
    Route::match(['get', 'post'], 'affiliates', [AffiliateController::class, 'index'])->name('admin.affiliates');
    Route::match(['get', 'post'], 'affiliates/add', [AffiliateController::class, 'add_affiliate'])->name('admin.affiliates.add');
    Route::get('affiliates/edit/{id}', [AffiliateController::class, 'add_affiliate'])->name('admin.affiliates.edit');
    Route::get('affiliates/delete/{id}', [AffiliateController::class, 'delete'])->name('admin.affiliates.delete');

    // Affiliate Couopn 
    Route::match(['get', 'post'], 'affilliate-coupon/{id}', [AffiliateController::class, 'affilliate_coupon'])->name('admin.affiliates.affilliate_coupon');
    Route::match(['get', 'post'], 'add-affilliate-coupon/{Afid}', [AffiliateController::class, 'add_affilliate_coupon'])->name('admin.add_affilliate_coupon');
    Route::match(['get', 'post'], 'edit-affilliate-coupon/{Afid}/{id}', [AffiliateController::class, 'add_affilliate_coupon'])->name('admin.edit_affilliate_coupon');


    // Affiliate Commissions
    Route::match(['get', 'post'], 'affiliate_commission', [AffiliateController::class, 'affiliate_commission'])->name('admin.affiliate_commission');
    Route::get('affiliate_commission/view/{id}', [AffiliateController::class, 'affiliate_commission_view'])->name('admin.affiliate_commission.view');

    // Change Product Approved

    Route::post('change_product_approved', [ProductController::class, 'change_product_approved'])->name('admin.change_product_approved');


    // Our Teams
    Route::get('teams', [TeamController::class, 'index'])->name('admin.teams');
    Route::match(['get', 'post'], 'teams/add', [TeamController::class, 'add_teams'])->name('admin.teams.add');
    Route::get('teams/edit/{id}', [TeamController::class, 'add_teams'])->name('admin.teams.edit');
    Route::get('teams/delete/{id}', [TeamController::class, 'delete'])->name('admin.teams.delete');

    // Testimonials
    Route::get('testimonials', [TestimonialController::class, 'index'])->name('admin.testimonials');
    Route::match(['get', 'post'], 'testimonials/add', [TestimonialController::class, 'add_testimonials'])->name('admin.testimonials.add');
    Route::get('testimonials/edit/{id}', [TestimonialController::class, 'add_testimonials'])->name('admin.testimonials.edit');
    Route::get('testimonials/delete/{id}', [TestimonialController::class, 'delete'])->name('admin.testimonials.delete');

    ///Hotels
    Route::match(['get', 'post'], 'hotels', [HotelController::class, 'index'])->name('admin.hotels');
    Route::match(['get', 'post'], 'hotels/add', [HotelController::class, 'add_hotel'])->name('admin.hotels.add');
    Route::get('hotels/edit/{id}', [HotelController::class, 'add_hotel'])->name('admin.hotels.edit');
    Route::get('hotels/delete/{id}', [HotelController::class, 'delete'])->name('admin.hotels.delete');

    // Orders
    Route::match(['get', 'post'], 'orders', [OrderController::class, 'index'])->name('admin.orders');
    Route::get('orders/details/{id}', [OrderController::class, 'orders_details'])->name('admin.orders.details');
    Route::post('orders/change-status', [OrderController::class, 'change_status'])->name('admin.orders.change_status');

    // Affiliiate History
    Route::match(['get', 'post'], 'reports/affilliate-history', [ReportController::class, 'affilliate_history'])->name('admin.affilliate_history');
    Route::match(['get', 'post'], 'reports/affilliate-history-details/{id}', [ReportController::class, 'affilliate_history_details'])->name('admin.affilliate_history_details');


    // Hotel History
    Route::match(['get', 'post'], 'reports/hotel-history', [ReportController::class, 'hotel_history'])->name('admin.hotel_history');
    Route::match(['get', 'post'], 'reports/hotel-history-details/{id}', [ReportController::class, 'hotel_history_details'])->name('admin.hotel_history_details');
    Route::get('hotel_commission/view/{id}', [ReportController::class, 'hotel_commission_view'])->name('admin.hotel_commission_view');


    // Partner History
    Route::match(['get', 'post'], 'reports/supplier-history', [ReportController::class, 'supplier_history'])->name('admin.supplier_history');
    Route::match(['get', 'post'], 'reports/supplier-history-details/{id}', [ReportController::class, 'supplier_history_details'])->name('admin.supplier_history_details');
    Route::match(['get', 'post'], 'reports/supplier-commission-details/{id}/{order_id}', [ReportController::class, 'supplier_commission_view'])->name('admin.supplier_commission_view');


    // Transaction History
    Route::match(['get', 'post'], 'transaction_history', [TransactionHistoryController::class, 'transaction_history'])->name('admin.transaction_history');
    Route::match(['get', 'post'], 'transaction_history/view/{id}', [TransactionHistoryController::class, 'view_transaction_history'])->name('admin.transaction_history.view');


    // Faqs
    Route::get('faqs', [FaqController::class, 'index'])->name('admin.faqs');
    Route::match(['get', 'post'], 'faqs/add', [FaqController::class, 'add_faqs'])->name('admin.faqs.add');
    Route::get('faqs/edit/{id}', [FaqController::class, 'add_faqs'])->name('admin.faqs.edit');
    Route::get('faqs/delete/{id}', [FaqController::class, 'delete'])->name('admin.faqs.delete');

    // Blogs
    Route::get('blogs', [BlogController::class, 'index'])->name('admin.blogs');
    Route::match(['get', 'post'], 'blogs/add', [BlogController::class, 'add_blogs'])->name('admin.blogs.add');
    Route::get('blogs/edit/{id}', [BlogController::class, 'add_blogs'])->name('admin.blogs.edit');
    Route::get('blogs/delete/{id}', [BlogController::class, 'delete'])->name('admin.blogs.delete');

    // BlogCategory
    Route::get('blogcategory', [BlogCategoryController::class, 'index'])->name('admin.blogcategory');
    Route::match(['get', 'post'], 'blogcategory/add', [BlogCategoryController::class, 'add_blogcategory'])->name('admin.blogcategory.add');
    Route::get('blogcategory/edit/{id}', [BlogCategoryController::class, 'add_blogcategory'])->name('admin.blogcategory.edit');
    Route::get('blogcategory/delete/{id}', [BlogCategoryController::class, 'delete'])->name('admin.blogcategory.delete');

    // Guide
    Route::get('guide', [GuideController::class, 'index'])->name('admin.guide');
    Route::match(['get', 'post'], 'guide/add', [GuideController::class, 'add_guide'])->name('admin.guide.add');
    Route::get('guide/edit/{id}', [GuideController::class, 'add_guide'])->name('admin.guide.edit');
    Route::get('guide/delete/{id}', [GuideController::class, 'delete'])->name('admin.guide.delete');

    // Gear
    Route::get('gear', [GearController::class, 'index'])->name('admin.gears');
    Route::match(['get', 'post'], 'gear/add', [GearController::class, 'add_gears'])->name('admin.gears.add');
    Route::get('gear/edit/{id}', [GearController::class, 'add_gears'])->name('admin.gears.edit');
    Route::get('gear/delete/{id}', [GearController::class, 'delete'])->name('admin.gears.delete');

    // Media
    Route::get('media', [MediaController::class, 'index'])->name('admin.media');
    Route::match(['get', 'post'], 'media/add', [MediaController::class, 'add_media'])->name('admin.media.add');
    Route::get('media/edit/{id}', [MediaController::class, 'add_media'])->name('admin.media.edit');
    Route::get('media/delete/{id}', [MediaController::class, 'delete'])->name('admin.media.delete');

    // inclusion
    Route::get('inclusion', [InclusionController::class, 'index'])->name('admin.inclusion');
    Route::match(['get', 'post'], 'inclusion/add', [InclusionController::class, 'add_inclusion'])->name('admin.inclusion.add');
    Route::get('inclusion/edit/{id}', [InclusionController::class, 'add_inclusion'])->name('admin.inclusion.edit');
    Route::get('inclusion/delete/{id}', [InclusionController::class, 'delete'])->name('admin.inclusion.delete');

    //  Restriction
    Route::get('restriction', [RestrictionController::class, 'index'])->name('admin.restriction');
    Route::match(['get', 'post'], 'restriction/add', [RestrictionController::class, 'add_restriction'])->name('admin.restriction.add');
    Route::get('restriction/edit/{id}', [RestrictionController::class, 'add_restriction'])->name('admin.restriction.edit');
    Route::get('restriction/delete/{id}', [RestrictionController::class, 'delete'])->name('admin.restriction.delete');

    // Products Add On
    Route::get('add_on', [AddOnController::class, 'index'])->name('admin.add_on');
    Route::match(['get', 'post'], 'add_on/add', [AddOnController::class, 'add_addOn'])->name('admin.add_on.add');
    Route::get('add_on/edit/{id}', [AddOnController::class, 'add_addOn'])->name('admin.add_on.edit');
    Route::get('add_on/delete/{id}', [AddOnController::class, 'delete'])->name('admin.add_on.delete');

    // Coupon Code
    Route::match(['get', 'post'], 'coupon', [CouponController::class, 'index'])->name('admin.coupon');
    Route::match(['get', 'post'], 'coupon/add', [CouponController::class, 'add_coupon'])->name('admin.coupon.add');
    Route::get('coupon/edit/{id}', [CouponController::class, 'add_coupon'])->name('admin.coupon.edit');
    Route::get('coupon/delete/{id}', [CouponController::class, 'delete'])->name('admin.coupon.delete');


    // Tax Controller
    // Route::get('tax', [TaxController::class, 'index'])->name('admin.tax');
    Route::match(['get', 'post'], 'tax/add', [TaxController::class, 'add_tax'])->name('admin.tax.add');
    //  Route::get('add_on/edit/{id}', [AddOnController::class, 'add_addOn'])->name('admin.add_on.edit');
    //  Route::get('add_on/delete/{id}', [AddOnController::class, 'delete'])->name('admin.add_on.delete');

    // Top Attraction
    Route::get('top_attraction', [TopAttractionController::class, 'index'])->name('admin.top_attraction');
    Route::match(['get', 'post'], 'top_attraction/add', [TopAttractionController::class, 'add_top_attraction'])->name('admin.top_attraction.add');
    Route::get('top_attraction/edit/{id}', [TopAttractionController::class, 'add_top_attraction'])->name('admin.top_attraction.edit');
    Route::get('top_attraction/delete/{id}', [TopAttractionController::class, 'delete'])->name('admin.top_attraction.delete');



    //  Meal Type
    Route::get('mealtype', [MealTypeController::class, 'index'])->name('admin.productsfood.mealtype');
    Route::match(['get', 'post'], 'mealtype/add', [MealTypeController::class, 'add_mealtype'])->name('admin.productsfood.mealtype.add');
    Route::get('mealtype/edit/{id}', [MealTypeController::class, 'add_mealtype'])->name('admin.productsfood.mealtype.edit');
    Route::get('mealtype/delete/{id}', [MealTypeController::class, 'delete'])->name('admin.productsfood.mealtype.delete');

    //  Time of Day
    Route::get('timeofday', [TimeofDayController::class, 'index'])->name('admin.productsfood.timeofday');
    Route::match(['get', 'post'], 'timeofday/add', [TimeofDayController::class, 'add_time_of_day'])->name('admin.productsfood.timeofday.add');
    Route::get('timeofday/edit/{id}', [TimeofDayController::class, 'add_time_of_day'])->name('admin.productsfood.timeofday.edit');
    Route::get('timeofday/delete/{id}', [TimeofDayController::class, 'delete'])->name('admin.productsfood.timeofday.delete');

    //  Tags
    Route::get('tags', [TagController::class, 'index'])->name('admin.productsfood.tags');
    Route::match(['get', 'post'], 'tags/add', [TagController::class, 'add_tags'])->name('admin.productsfood.tags.add');
    Route::get('tags/edit/{id}', [TagController::class, 'add_tags'])->name('admin.productsfood.tags.edit');
    Route::get('tags/delete/{id}', [TagController::class, 'delete'])->name('admin.productsfood.tags.delete');

    //  Transportation
    Route::get('transportation', [TransportationController::class, 'index'])->name('admin.transportation');
    Route::match(['get', 'post'], 'transportation/add', [TransportationController::class, 'add_transportation'])->name('admin.transportation.add');
    Route::get('transportation/edit/{id}', [TransportationController::class, 'add_transportation'])->name('admin.transportation.edit');
    Route::get('transportation/delete/{id}', [TransportationController::class, 'delete'])->name('admin.transportation.delete');
    Route::get('product/delete/{id}', [TransportationController::class, 'product_delete'])->name('admin.product.delete');

    // Products
    Route::match(['get', 'post'], 'add-product/{tab?}', [ProductController::class, 'add_product'])->name('admin.add_product');
    Route::match(['get', 'post'], 'add-product/{id?}', [ProductController::class, 'add_product'])->name('admin.edit_product');
    Route::match(['get', 'post'], 'get-products', [ProductController::class, 'get_products'])->name('admin.get_products');

    // Recommended Things  
    Route::match(['get', 'post'], 'recommended-things', [RecommendedThingsController::class, 'index'])->name('admin.recommended_things');
    Route::match(['get', 'post'], 'recommended-things/add', [RecommendedThingsController::class, 'add_recommended_things'])
        ->name('admin.recommended_things.add');
    Route::get('recommended-things/edit/{id}', [RecommendedThingsController::class, 'add_recommended_things'])->name('admin.recommended_things.edit');
    Route::get('recommended-things/delete/{id}', [RecommendedThingsController::class, 'delete'])->name('admin.recommended_things.delete');



    // Prpduct Type
    Route::get('product-type', [ProductTypeController::class, 'index'])->name('admin.product_type');
    Route::match(['get', 'post'], 'product-type/add', [ProductTypeController::class, 'add_product_type'])->name('admin.product_type.add');
    Route::get('product-type/edit/{id}', [ProductTypeController::class, 'add_product_type'])->name('admin.product_type.edit');
    Route::get('product-type/delete/{id}', [ProductTypeController::class, 'delete'])->name('admin.product_type.delete');

    // Edit Option Pricing edit_option_pricing
    Route::match(['get', 'post'], 'edit-option-pricing', [ProductController::class, 'edit_option_pricing'])->name('admin.edit_option_pricing');
    Route::match(['get', 'post'], 'remove-option-pricing', [ProductController::class, 'remove_option_pricing'])->name('admin.remove_option_pricing');

    // Edit Option edit_product_option
    Route::match(['get', 'post'], 'edit-option', [ProductController::class, 'edit_product_option'])->name('admin.edit_product_option');

    // Edit Availability
    Route::match(['get', 'post'], 'edit-price-availability', [ProductController::class, 'edit_price_availability'])->name('admin.edit_price_availability');

    // Edit Price Discount
    Route::match(['get', 'post'], 'edit-price-discount', [ProductController::class, 'edit_price_discount'])->name('admin.edit_price_discount');



    Route::match(['get', 'post'], 'add-product2', [ProductController::class, 'add_product2'])->name('admin.add_product2');
    Route::match(['get', 'post'], 'add-product2/{id?}', [ProductController::class, 'add_product2'])->name('admin.edit_product2');

    // Prouct Transportation
    Route::match(['get', 'post'], 'add-product-transportation', [ProductController::class, 'add_product_transportation'])->name('admin.add_product_transportation');
    Route::match(['get', 'post'], 'get-transportation-view', [ProductController::class, 'get_transportation_modal_view'])->name('admin.get_transportation_modal_view');
    Route::match(['get', 'post'], 'remove-product-transportation', [ProductController::class, 'remove_product_transportation'])->name('admin.remove_product_transportation');

    // Product Top Destination
    Route::get('top-destination', [TopDestinationController::class, 'index'])->name('admin.top_destination');
    Route::match(['get', 'post'], 'top-destination/add', [TopDestinationController::class, 'add_top_destination'])->name('admin.top_destination.add');
    Route::get('top-destination/edit/{id}', [TopDestinationController::class, 'add_top_destination'])->name('admin.top_destination.edit');
    Route::get('top-destination/delete/{id}', [TopDestinationController::class, 'delete'])->name('admin.top_destination.delete');

    // Reviews
    Route::get('reviews', [ReviewController::class, 'index'])->name('admin.reviews');
    Route::post('reviews-change-status', [ReviewController::class, 'change_status'])->name('admin.reviews.change_status');

    // Remove Highlight
    Route::match(['get', 'post'], 'remove-product-highlight', [ProductController::class, 'remove_product_highlight'])->name('admin.remove_product_highlight');

    // Remove Information
    Route::match(['get', 'post'], 'remove-product-information', [ProductController::class, 'remove_product_information'])->name('admin.remove_product_information');

    // Remove About Activity
    Route::match(['get', 'post'], 'remove-about-activity', [ProductController::class, 'remove_about_activity'])->name('admin.remove_about_activity');

    // remove Prosuct option
    Route::match(['get', 'post'], 'remove-product-option', [ProductController::class, 'remove_product_option'])->name('admin.remove_product_option');

    // Product Food  
    Route::match(['get', 'post'], 'get-food-modal-view', [ProductController::class, 'get_food_modal_view'])->name('admin.get_food_modal_view');
    Route::match(['get', 'post'], 'get-drink-modal-view', [ProductController::class, 'get_drink_modal_view'])->name('admin.get_drink_modal_view');

    Route::match(['get', 'post'], 'get-food-drink-modal-view', [ProductController::class, 'get_food_drink_modal_view'])->name('admin.get_food_drink_modal_view');

    Route::match(['get', 'post'], 'add-product-food-drink', [ProductController::class, 'add_product_food_drink'])->name('admin.add_product_food_drink');
    Route::match(['get', 'post'], 'remove-product-food-drink', [ProductController::class, 'remove_product_food_drink'])->name('admin.remove_product_food_drink');

    Route::match(['get', 'post'], 'send-reason', [ProductController::class, 'send_reason'])->name('admin.send_reason');

    Route::match(['get', 'post'], 'test_template', [OrderController::class, 'test_template'])->name('test_template');

    // 

    // Append view page
    Route::match(['get', 'post'], 'get-append-view', [SettingController::class, 'get_append_view'])->name('admin.get_append_view');

    //Pages
    Route::get('pages', [PagesController::class, 'index'])->name('admin.pages');
    Route::match(['get', 'post'], 'pages/edit/{id}', [PagesController::class, 'add_pages'])->name('admin.pages.edit');
});

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('optimize:clear');
    echo 'Clear d';
    die();
});
