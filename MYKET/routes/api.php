<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\WishlistApiController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PagesController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\GuideController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductUploadController;
use App\Http\Controllers\Api\ProviderAccountController;
use App\Http\Controllers\Api\AffilliateController;
use App\Http\Controllers\Api\HotelController;
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

//Login
Route::post('/login', [LoginController::class, 'login'])->name('login');

// Langauge List
Route::post('/get_languages', [HomeController::class, 'get_languages'])->name('get_languages');

// Currency List
Route::post('/get_currency', [HomeController::class, 'get_currency'])->name('get_currency');

// Set Language
Route::post('/set_language', [HomeController::class, 'set_language'])->name('set_language');

// get Phone Code
Route::post('/phone_code', [HomeController::class, 'phone_code'])->name('phone_code');

//Signup
Route::post('/signup', [LoginController::class, 'signup'])->name('signup');

// HomePage
Route::post('/home', [PagesController::class, 'home_page'])->name('home_page');

// About Us Page
Route::post('/about-us', [PagesController::class, 'about_us'])->name('about_us');

// Blog  Page
Route::post('/blog', [PagesController::class, 'blog'])->name('blog');

// Guide Page
Route::post('/guide', [PagesController::class, 'guide'])->name('guide');

// Contact Us Page
Route::post('/contact-us', [PagesController::class, 'contact_us'])->name('contact_us');

// Affiliate Page
Route::post('/affiliate', [PagesController::class, 'affiliate'])->name('affiliate');

// Listing Page
Route::post('/listing', [PagesController::class, 'listing'])->name('listing');


// Affiliate Page
Route::post('/privacy-policy', [PagesController::class, 'privacy_policy'])->name('privacy_policy');

// Terms Condition page
Route::post('/terms-condition', [PagesController::class, 'terms_condition'])->name('terms_condition');

// Partner page
Route::post('/partners', [PagesController::class, 'partners'])->name('partners');



// Blog List 
Route::post('/blog-list', [BlogController::class, 'blog_list'])->name('blog_list');

// Blog Details
Route::post('/blog-details', [BlogController::class, 'blog_details'])->name('blog_details');

// Guide List 
Route::post('/guide-list', [GuideController::class, 'guide_list'])->name('guide_list');

// Guide Details
Route::post('/guide-detail', [GuideController::class, 'guide_detail'])->name('guide_detail');





// Product List
Route::post('/product-list', [ProductController::class, 'product_list'])->name('product_list');

// product Destination List
Route::post('/destination-product-list', [ProductController::class, 'destination_product_list'])->name('destination_product_list');

// search Destination 
Route::post('/search-data', [HomeController::class, 'search_data'])->name('search_data');

// Product Details
Route::post('/product-details', [ProductController::class, 'product_details'])->name('product_details');

// Product Available options
Route::post('/available-options', [ProductController::class, 'available_options'])->name('available_options');


// Get State
Route::post('/get-states', [HomeController::class, 'get_states'])->name('get_states');


// Get City
Route::post('/get-city', [HomeController::class, 'get_cities'])->name('get_cities');

// Add to cart
Route::post('/add-to-cart', [OrderController::class, 'add_to_cart'])->name('add_to_cart');

// Cart List
Route::post('/cart-list', [OrderController::class, 'cart_list'])->name('cart_list');

// Delete Cart
Route::post('/delete-cart', [OrderController::class, 'delete_cart'])->name('delete_cart');



// Get Company Details
Route::post('/get-compnany-details', [ProviderAccountController::class, 'get_company_details'])->name('get_company_details');

// Top Attraction listing 
Route::post('/top-attraction-listing', [ProductController::class, 'top_attraction_listing'])->name('top_attraction_listing');

// Contact Us
Route::post('/send-contact', [HomeController::class, 'send_contact'])->name('send_contact');

// Vwerify Email
Route::post('/verify-email', [LoginController::class, 'verify_email'])->name('verify_email');

// Verify Link
Route::post('/forget-verify-link', [LoginController::class, 'forget_verify_link'])->name('forget_verify_link');

// Reset Password
Route::post('/reset-password', [LoginController::class, 'reset_password'])->name('reset_password');



Route::middleware(['checkUserAuth'])->group(function () {
    // Add To Wishlist
    Route::post('/add_wishlist', [WishlistApiController::class, 'add_wishlist'])->name('add_wishlist');

    // get Wishlist List
    Route::post('/get-wishlist', [WishlistApiController::class, 'get_wishlist'])->name('get_wishlist');

    // Add To Wishlist Activity
    Route::post('/add_wishlist_activity', [WishlistApiController::class, 'add_wishlist_activity'])->name('add_wishlist_activity');

    // get Wishlist Activity List
    Route::post('/get-wishlist-activity-list', [WishlistApiController::class, 'get_wishlist_activity_list'])->name('get_wishlist_activity_list');

    // get Wishlist List
    Route::post('/remove_wishlist', [WishlistApiController::class, 'remove_wishlist'])->name('remove_wishlist');


    // get User Profile
    Route::post('/user-profile', [UserController::class, 'userProfile'])->name('userProfile');

    //  User Profile Update
    Route::post('/user-profile-update', [UserController::class, 'userProfileUpdate'])->name('userProfileUpdate');

    // get Booking History
    Route::post('/transaction-history', [UserController::class, 'transactionHistory'])->name('transactionHistory');

    // Checkout
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');

    // Upcoming Booking
    Route::post('/upcoming_booking', [OrderController::class, 'upcoming_booking'])->name('upcoming_booking');

    // Booking History
    Route::post('/booking_history', [OrderController::class, 'booking_history'])->name('booking_history');

    // Order Details
    Route::post('/order-details', [OrderController::class, 'order_details'])->name('order_details');

    // Uplodad Product 
    Route::post('/upload-product', [ProductUploadController::class, 'upload_product'])->name('upload_product');

    // get Product Data
    Route::post('/get-product-data', [ProductUploadController::class, 'get_product_data'])->name('get_product_data');

    // Get Product Transportation modal View 
    Route::post('/get-transportation-modal-view', [ProductUploadController::class, 'get_transportation_modal_view'])->name('get_transportation_modal_view');

    // Add Product Transportation 
    Route::post('/add-product-transportation', [ProductUploadController::class, 'add_product_transportation'])->name('add_product_transportation');


    // Get Product Food Drink Modal View 
    Route::post('/get-food-drink-modal-view', [ProductUploadController::class, 'get_food_drink_modal_view'])->name('get_food_drink_modal_view');

    // Add Product Food Drink 
    Route::post('/add-product-food-drink', [ProductUploadController::class, 'add_product_food_drink'])->name('add_product_food_drink');


    Route::post('/option-pricing-type', [ProductUploadController::class, 'change_option_pricing_type'])->name('change_option_pricing_type');

    // Provider Tours List
    Route::post('/my-tours', [ProviderAccountController::class, 'my_tours'])->name('my_tours');

    // Delete Partner Tour 
    Route::post('/remove-tour', [ProviderAccountController::class, 'delete_partner_tour'])->name('delete_partner_tour');

    // Company Profile Details;
    Route::post('/compnany-details', [ProviderAccountController::class, 'company_details'])->name('company_details');


    // Provider Order List
    Route::post('/partner-order-list', [ProviderAccountController::class, 'partner_order_list'])->name('partner_order_list');

    // Partner Order Details
    Route::post('/partner-order-details', [ProviderAccountController::class, 'partner_order_details'])->name('partner_order_details');

    // Remove Product Option
    Route::post('/remove-product-option', [ProviderAccountController::class, 'remove_product_option'])->name('remove_product_option');


    Route::post('/remove-product-option-pricing', [ProviderAccountController::class, 'remove_product_option_pricing'])->name('remove_product_option_pricing');

    // generate affiliate link 
    Route::post('/generate_affiliate_link', [AffilliateController::class, 'generate_affiliate_link'])->name('generate_affiliate_link');

    // Affiliate Commission History
    Route::post('/affiliate-commission-list', [AffilliateController::class, 'affiliate_commission_list'])->name('affiliate_commission_list');

    // Affilliate Commission Details
    Route::post('/affiliate-commission-details', [AffilliateController::class, 'affiliate_commission_details'])->name('affiliate_commission_details');




    Route::post('/provider-dashboard', [ProviderAccountController::class, 'provider_dashboard'])->name('provider_dashboard');

    // Partner Upcoming Orders 
    Route::post('/provider-upcoming-orders', [ProviderAccountController::class, 'partner_upcoming_orders'])->name('partner_upcoming_orders');

    // Add Review
    Route::post('/add-review', [OrderController::class, 'add_review'])->name('add_review');

    // Make Money
    Route::post('/make-money', [AffilliateController::class, 'make_money'])->name('make_money');

    // Afffilliate Dashboard
    Route::post('/affilliate-dashboard', [AffilliateController::class, 'affilliate_dashboard'])->name('affilliate_dashboard');

    // Partner Commission
    Route::post('/partner-commission', [ProviderAccountController::class, 'partner_commission'])->name('partner_commission');

    // Hotel Dashboard
    Route::post('/hotel-dashboard', [HotelController::class, 'hotel_dashboard'])->name('hotel_dashboard');

    // Hotel Commission History
    Route::post('/hotel-commission-list', [HotelController::class, 'hotel_commission_list'])->name('hotel_commission_list');

    // Hotel Commission Details
    Route::post('/hotel-commission-details', [HotelController::class, 'hotel_commission_details'])->name('hotel_commission_details');

    // cancel Product
    Route::post('/cancel-order', [OrderController::class, 'cancel_order'])->name('cancel_order');
}); 

// Wishlist
