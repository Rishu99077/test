<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RequestController;


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

Route::post('/signup', [LoginController::class, 'signup'])->name('api_signup');
Route::post('/login', [LoginController::class, 'login'])->name('api_login');
Route::post('/forgotpasword', [LoginController::class, 'forgotpasword'])->name('api_forgotpasword');
Route::post('/verify_otp', [LoginController::class, 'verify_otp'])->name('api_verify_otp');
Route::post('/resetpasword', [LoginController::class, 'resetpasword'])->name('api_resetpasword');

Route::post('/home', [HomeController::class, 'index'])->name('api_home');
Route::post('/contact_us', [HomeController::class, 'contact_us'])->name('api_contact_us');
Route::post('/users_list', [HomeController::class, 'users_list'])->name('api_users_list');
Route::post('/users_details', [HomeController::class, 'users_details'])->name('api_users_details');
Route::post('/countries', [HomeController::class, 'countries'])->name('api_countries');

Route::post('/subscription_plan', [HomeController::class, 'subscription_plan'])->name('api_subscription_plan');



Route::post('/profile', [ProfileController::class, 'profile'])->name('api_profile');
Route::post('/profile_update', [ProfileController::class, 'profile_update'])->name('api_profile_update');
Route::post('/change_password', [ProfileController::class, 'change_password'])->name('api_change_password');

Route::post('/send_request', [RequestController::class, 'send_request'])->name('API_send_request');
Route::post('/accept_request', [RequestController::class, 'accept_request'])->name('API_accept_request');
Route::post('/reject_request', [RequestController::class, 'reject_request'])->name('API_reject_request');
Route::post('/friend_list', [RequestController::class, 'friend_list'])->name('API_friend_list');

Route::post('/my_request', [RequestController::class, 'my_request'])->name('API_my_request');




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

    return $request->user();
});
