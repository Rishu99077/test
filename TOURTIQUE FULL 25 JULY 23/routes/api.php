<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\BreakdownController;
use App\Http\Controllers\Api\PagesController;
use App\Http\Controllers\Api\LodgeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\YachtController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\AirportTransfer;
use App\Http\Controllers\Api\LimousineController;
use App\Http\Controllers\Api\GolfController;
use App\Http\Controllers\Api\CityGuideController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\ProductCheckoutController;
use App\Http\Controllers\Api\AffilliateController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\GiftCardController;
use App\Http\Controllers\Api\RewardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('generate_airport_voucher/{order_id}', [OrderController::class, 'generate_airport_voucher'])->name('admin.generate_airport_voucher');
Route::get('generate_product_voucher/{order_id}', [OrderController::class, 'generate_product_voucher'])->name('admin.generate_product_voucher');

// Route::post('/demoMAil', [LoginController::class, 'demoMAil'])->name('demoMAil');
Route::post('/home', [HomeController::class, 'index'])->name('home');
Route::post('/get_languages', [HomeController::class, 'get_languages'])->name('get_languages');
Route::post('/get_currency', [HomeController::class, 'get_currency'])->name('get_currency');
Route::post('/get_phone_code', [HomeController::class, 'get_phone_code'])->name('get_phone_code');
Route::post('/set_language', [HomeController::class, 'set_language'])->name('set_language');
Route::post('/set_currency', [HomeController::class, 'set_currency'])->name('set_currency');

Route::post('/firebase-token', [SettingsController::class, 'add_firebase_token'])->name('add_firebase_token');

//Get Activity Details
Route::post('/activity-details', [ActivityController::class, 'activity_details'])->name('activity_details');

Route::post('/get-tour-option-time', [BreakdownController::class, 'get_tour_option_time'])->name('get_tour_option_time');

// get Group Tour Option TIme
Route::post('/get-group-tour-option-time', [BreakdownController::class, 'get_group_tour_option_time'])->name('get_group_tour_option_time');

// get Activity Price BrakDown
Route::post('/activity-price-brakdown', [BreakdownController::class, 'activity_price_brakdown'])->name('activity_price_brakdown');

// Get Actiivty Group Rates BreakDown
Route::post('activity-group-rates-breakdown', [BreakdownController::class, 'activity_group_rates_breakdown'])->name('activity_group_rates_breakdown');

// get Activity Price BrakDown
Route::post('/activity-product-list', [ActivityController::class, 'activity_product_list'])->name('activity_product_list');
Route::post('/activity-category-product', [ActivityController::class, 'get_category_product'])->name('get_category_product');

// Get Sub Category
Route::post('/get-sub-category', [ActivityController::class, 'get_sub_category'])->name('get_sub_category');


Route::post('/actitivity-add-to-cart', [ActivityController::class, 'activity_add_to_cart'])->name('activity_add_to_cart');
Route::post('/activity_request_validation', [ActivityController::class, 'activity_request_validation'])->name('activity_request_validation');

// Get Group passenger AMount
Route::post('/get-group-passenger-amount', [ActivityController::class, 'get_group_passenger_amount'])->name('get_group_passenger_amount');

// Get Group percentage AMount
Route::post('/get-group-percentage-amount', [ActivityController::class, 'get_group_percentage_amount'])->name('get_group_percentage_amount');


//Counrty State City
Route::post('/get_country_list', [LoginController::class, 'countries'])->name('countries'); //get Country
Route::post('/get_state_list', [LoginController::class, 'states'])->name('states'); // Get states
Route::post('/get_city_list', [LoginController::class, 'cities'])->name('cities'); // Get City

//Lodge Page
Route::post('/get_lodge_detail', [LodgeController::class, 'lodge_details'])->name('lodge_details'); //get Product Lodge Detail
Route::post('/get-lodge-price-by-date', [LodgeController::class, 'lodge_price_by_date'])->name('lodge_price_by_date'); // Get Lodge Price By date

// get lodge Total Room Count
Route::post('/get-room-count-total', [LodgeController::class, 'get_room_count_total'])->name('get_room_count_total');

// Get Lodge Price By date

Route::post('/get-lodge-total', [LodgeController::class, 'get_lodge_total_calculation'])->name('get_lodge_total_calculation'); // Get Lodge Total
Route::post('/lodge_price_breakdown', [LodgeController::class, 'lodge_price_breakdown'])->name('lodge_price_breakdown'); //Lodge Price BreakDown

// get lodge list
Route::post('/lodge-product-list', [LodgeController::class, 'lodge_product_list'])->name('lodge_product_list');

// Lodge Add To Cart
Route::post('/lodge-add-to-cart', [LodgeController::class, 'lodge_add_to_cart'])->name('lodge_add_to_cart');


// city guide
// Route::post('/get_city_guide_list', [CityGuideController::class, 'get_city_guide_list'])->name('get_city_guide_list');
Route::post('/get_city_guide_details', [CityGuideController::class, 'get_city_guide_details'])->name('get_city_guide_details');

// city guide
Route::post('/get_hotel_list', [HotelController::class, 'get_hotel_list'])->name('get_hotel_list');
Route::post('/get_hotel_details', [HotelController::class, 'get_hotel_details'])->name('get_hotel_details');


//Page
Route::post('/get_affiliate_page', [PagesController::class, 'get_affiliate_page_data'])->name('get_affiliate_page');
Route::post('/get_gift_card_page', [PagesController::class, 'get_gift_card_page_data'])->name('get_gift_card_page');
Route::post('/get_city_guide_page', [PagesController::class, 'get_city_guide_page_data'])->name('get_city_guide_page');
Route::post('/get_media_mention_page', [PagesController::class, 'get_media_mention_page_data'])->name('get_media_mention_page');
Route::post('/get_transfer_page', [PagesController::class, 'get_transfer_page'])->name('get_transfer_page'); //Transfer Page
Route::post('/get_about_us_page', [PagesController::class, 'get_about_us_page_data'])->name('get_about_us_page')->middleware('cors'); //About Page
Route::post('/help', [PagesController::class, 'help_page_data'])->name('help_page_data'); //About Page
Route::post('/get_category_page', [PagesController::class, 'get_category_page'])->name('get_category_page'); //Category Page

Route::post('/get_advertisment_us_page', [PagesController::class, 'get_advertisment_us_page_data'])->name('get_advertisment_us_page'); //Advertisment Page

Route::post('/get_special_offers', [HomeController::class, 'get_special_offers'])->name('get_special_offers'); //Advertisment Page

Route::post('/get_join_us_page', [PagesController::class, 'get_join_us_page_data'])->name('get_join_us_page'); //Jooin Page

Route::post('/get_tour_list_page', [PagesController::class, 'get_tour_list_page_data'])->name('get_tour_list_page'); //Tour List Page

Route::post('/get_lodge_list_page', [PagesController::class, 'get_lodge_list_page_data'])->name('get_lodge_list_page'); //Lodge List Page

Route::post('/get_limousine_page', [PagesController::class, 'get_limousine_page_data'])->name('get_limousine_page'); //Limousine Page

Route::post('/get_yacht_page', [PagesController::class, 'get_yacht_page_data'])->name('get_yacht_page'); //Yacht Page

Route::post('/get_partner_page', [PagesController::class, 'get_partner_page_data'])->name('get_partner_page'); //Partner Page

Route::post('/get_golf_page', [PagesController::class, 'get_golf_page_data'])->name('get_golf_page'); //GOLF Page


//Product Country
Route::post('/get_product_country_list', [LimousineController::class, 'get_product_country_list'])->name('get_product_country_list');

// Get City by product
Route::post('/get_city_for_product', [HomeController::class, 'get_city_for_product'])->name('get_city_for_product');

//Blog
Route::post('/get_blogs_page', [PagesController::class, 'get_blogs_page'])->name('get_blogs_page');
Route::post('/get_blogs_page_details', [PagesController::class, 'get_blogs_page_details'])->name('get_blogs_page_details');


Route::post('/website_information', [PagesController::class, 'website_information'])->name('website_information');
Route::post('/the_insider', [PagesController::class, 'the_insider'])->name('the_insider');

//Yacht
Route::post('/yacht_details', [YachtController::class, 'yacht_details'])->name('yacht_details');
// Yacht
Route::post('/get-yacht-total', [YachtController::class, 'get_yacht_total'])->name('get_yacht_total');
Route::post('/yacht-list', [YachtController::class, 'yacht_list'])->name('yacht_list');
Route::post('/get-yacht-total-amount-calculation', [YachtController::class, 'get_yacht_total_amount_calculation'])->name('get_yacht_total_amount_calculation');
Route::post('/get-yacht-option-price', [YachtController::class, 'get_yacht_option_price'])->name('get_yacht_option_price');
Route::post('/get-yacht-breakdown', [YachtController::class, 'get_yacht_breakdown'])->name('get_yacht_breakdown');
Route::post('/yacht-add-to-cart', [YachtController::class, 'yacht_add_to_cart'])->name('yacht_add_to_cart');

// Limousine
Route::post('/limousine_list', [LimousineController::class, 'limousine_list'])->name('limousine_list');
Route::post('/limousine_detail', [LimousineController::class, 'limousine_details'])->name('limousine_detail');
Route::post('/get-limousine-total', [LimousineController::class, 'get_limousine_total'])->name('get_limousine_total');
Route::post('/get-limousine-total-amount-calculation', [LimousineController::class, 'get_limousine_total_amount_calculation'])->name('get_limousine_total_amount_calculation');
Route::post('/get-limousine-option-price', [LimousineController::class, 'get_limousine_option_price'])->name('get_limousine_option_price');
Route::post('/get-limousine-breakdown', [LimousineController::class, 'get_limousine_breakdown'])->name('get_limousine_breakdown');
Route::post('/limousine-add-to-cart', [LimousineController::class, 'limousine_add_to_cart'])->name('limousine_add_to_cart');
Route::post('/limousine_type', [LimousineController::class, 'limousine_type'])->name('limousine_type');



//Golf 
Route::post('/golf_list', [GolfController::class, 'golf_list'])->name('golf_list');
Route::post('/golf_detail', [GolfController::class, 'golf_detail'])->name('golf_detail');
Route::post('/golf_time_slots', [GolfController::class, 'golf_time_slots'])->name('golf_time_slots');


// Airport Transfer List
Route::post('/airport-transfer-list', [AirportTransfer::class, 'airport_transfer_list'])->name('airport_transfer_list');
Route::post('/get-transfer-extra-option-total', [AirportTransfer::class, 'transfer_extra_option_total'])->name('transfer_extra_option_total');
Route::post('/get-transfer-extra-need-total', [AirportTransfer::class, 'transfer_extra_need_total'])->name('transfer_extra_need_total');
Route::post('/get-transfer-total-amount', [AirportTransfer::class, 'transfer_total_amount'])->name('transfer_total_amount');
// Airport Tranfer Request
Route::post('/add-tranfer-request', [AirportTransfer::class, 'add_airport_request'])->name('add_airport_request');


Route::post('/api_for_add_location', [AirportTransfer::class, 'api_for_add_location'])->name('api_for_add_location');




Route::post('/get_information', [SettingsController::class, 'get_information'])->name('get_information'); //Setting Why Book With Us && Need Help Contacts
Route::post('/get_partners', [SettingsController::class, 'get_partners'])->name('get_partners'); //Partners
Route::post('/get_testimonials', [SettingsController::class, 'get_testimonials'])->name('get_testimonials'); //Partners


// Route::get('/demo', function () {
//     return view('email.signup_otp');
// });

// Add To cart
Route::post('/get-cart-item', [HomeController::class, 'get_cart_item'])->name('get_cart_item');
Route::post('remove-cart-item', [HomeController::class, 'remove_cart_item'])->name('remove_cart_item');



//Transfer Page
Route::post('/airport_transfer_details', [AirportTransfer::class, 'airport_transfer_details'])->name('airport_transfer_details');

//Signup
Route::post('/signup', [LoginController::class, 'signup'])->name('signup');
//Login
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/forgot_password', [LoginController::class, 'forgot_password'])->name('forgot_password');
Route::post('/reset_password', [LoginController::class, 'reset_password'])->name('reset_password');
Route::post('/forgot_verify_otp', [LoginController::class, 'forgot_verify_otp'])->name('forgot_verify_otp');

//Verify Otp
Route::post('/verify_otp', [LoginController::class, 'verify_otp'])->name('verify_otp');

// Get Airport List 
Route::post('/get_airport_list', [HomeController::class, 'get_airport_list'])->name('get_airport_list');
Route::post('/get_cart_count', [HomeController::class, 'get_cart_count'])->name('get_cart_count');
Route::post('/get_airport_location', [HomeController::class, 'get_airport_location'])->name('get_airport_location');


//Request Product   
Route::post('/yacht_request', [YachtController::class, 'yacht_request'])->name('yacht_request');
Route::post('/limoisine_request', [LimousineController::class, 'limoisine_request'])->name('limoisine_request');
Route::post('/activity_request', [ActivityController::class, 'activity_request'])->name('activity_request');
Route::post('/lodge_request', [LodgeController::class, 'lodge_request'])->name('lodge_request');

// Gift Add To cart gift-add-to-cart
Route::post('/gift-add-to-cart', [GiftCardController::class, 'gift_add_to_cart'])->name('gift_add_to_cart');


Route::post('/home-search-product', [HomeController::class, 'home_search_product'])->name('home_search_product');
//On Request Modal Content
Route::post('/request_modal', [PagesController::class, 'OnRequestModal'])->name('OnRequestModal');
//Resend Otp
Route::post('/resend_otp', [LoginController::class, 'resend_otp'])->name('resend_otp');
// Review List
Route::post('/review_list', [ReviewController::class, 'review_list'])->name('review_list');
// Review List
Route::post('/reward_list', [RewardController::class, 'reward_list'])->name('reward_list');

//Airport Transfer Check Out
Route::post('/add-tranfer-checkout-detail', [AirportTransfer::class, 'add_airport_checkout_detail'])->name('add_airport_checkout_detail');


//Help Page Support Form
Route::post('/support', [SettingsController::class, 'add_support_detail'])->name('add_support_detail'); //


//Join Us Form 
Route::post('/add_join_us', [SettingsController::class, 'add_join_us'])->name('add_join_us'); //

Route::post('/order_cancel', [OrderController::class, 'order_cancel'])->name('order_cancel');



//News Latter Subscribe
Route::post('/add_news_latter', [ReviewController::class, 'newsLatterSubscribe'])->name('add_news_latter');

//User Auth
Route::middleware(['checkUserAuth'])->group(function () {

    //User Profile
    Route::post('/user_profile', [UserController::class, 'userProfile'])->name('user_profile');
    Route::post('/user_wallet_history', [UserController::class, 'userWalletHistory'])->name('user_wallet_history');

    //User Profile Update
    Route::post('/user_profile_update', [UserController::class, 'userProfileupdate'])->name('user_profile_update');

    //Password Update
    Route::post('/changed_password', [UserController::class, 'changePassword'])->name('changePassword');

    //Airport Transfer Check Out
    Route::post('/add-tranfer-checkout', [AirportTransfer::class, 'add_airport_checkout'])->name('add_airport_checkout');


    //Prodcut Check Out
    Route::post('/product_checkout', [ProductCheckoutController::class, 'product_checkout'])->name('product_checkout');


    // Order_detail
    Route::post('/order_detail', [OrderController::class, 'order_detail'])->name('order_detail');
    Route::post('/order_list', [OrderController::class, 'order_list'])->name('order_list');
    Route::post('/order_list2', [OrderController::class, 'order_list2'])->name('order_list2');

    //Airport Transfer 
    // Route::post('/airport_transfer_order_list', [OrderController::class, 'airport_transfer_order_list'])->name('airport_transfer_order_list');
    Route::post('/airport_transfer_order_detail', [OrderController::class, 'airport_transfer_order_detail'])->name('airport_transfer_order_detail');

    // Generate Affiliate Link generate_affiliate_link
    Route::post('/generate_affiliate_link', [AffilliateController::class, 'generate_affiliate_link'])->name('generate_affiliate_link');

    // AFFILIATE
    Route::post('/affiliate_commission_list', [AffilliateController::class, 'affiliate_commission_list'])->name('affiliate_commission_list');
    Route::post('/affiliate_commission_detail', [AffilliateController::class, 'affiliate_commission_detail'])->name('affiliate_commission_detail');


    //Wishlist 
    Route::post('/add_wishlist', [WishlistController::class, 'add_wishlist'])->name('add_wishlist');
    Route::post('/wishlist', [WishlistController::class, 'wishlist_list'])->name('wishlist_list');

    Route::post('/gift_card_list', [GiftCardController::class, 'gift_card_list'])->name('gift_card_list');

    //Add Review 
    Route::post('/add_review', [ReviewController::class, 'add_review'])->name('add_review');

    //Coupon code check

    Route::post('/check_coupon_code', [SettingsController::class, 'check_coupon_code'])->name('check_coupon_code'); //Partners

    Route::post('/gift_card_check_coupon_code', [SettingsController::class, 'gift_card_check_coupon_code'])->name('gift_card_check_coupon_code');

});
