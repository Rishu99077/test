<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\LoginController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProfileController;
use App\Http\Controllers\Front\StaffController;

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

Route::match(['get', 'post'], '/signup', [LoginController::class, 'signup'])->name('signup');
Route::match(['get', 'post'], '/login', [LoginController::class, 'login'])->name('login');


Route::get('staff/{id}', [HomeController::class, 'staff'])->name('staff');
Route::get('downoad_vcard/{id}', [HomeController::class, 'downoad_vcard'])->name('downoad_vcard');
Route::get('no_found', [HomeController::class, 'no_found'])->name('front.no_found');


// MiddleWare User
Route::middleware(['userAuth'])->group(function () {
	Route::match(['get', 'post'], '/', [HomeController::class, 'index'])->name('home');
	Route::match(['get', 'post'], '/my_request', [HomeController::class, 'my_request'])->name('my_request');
	Route::match(['get', 'post'], '/send_request', [HomeController::class, 'send_request'])->name('send_request');
	Route::match(['get', 'post'], '/change_request_status', [HomeController::class, 'change_request_status'])->name('change_request_status');

	// Profile
	Route::match(['get', 'post'], '/my_profile', [ProfileController::class, 'my_profile'])->name('my_profile');
	Route::match(['get', 'post'], '/save_favourites', [ProfileController::class, 'save_favourites'])->name('save_favourites');
	Route::match(['get', 'post'], '/my_friends', [ProfileController::class, 'my_friends'])->name('my_friends');

	// Staff
	Route::match(['get', 'post'], '/my_staff', [StaffController::class, 'index'])->name('staffs');
    Route::match(['get', 'post'], '/my_staff/add', [StaffController::class, 'add_staff'])->name('my_staff.add');
    Route::get('/staff/edit/{id}', [StaffController::class, 'add_staff'])->name('staff.edit');    
    Route::get('/staff/delete/{id}', [StaffController::class, 'delete'])->name('staff.delete');    
    
    Route::match(['get', 'post'], 'card_design', [StaffController::class, 'card_design'])->name('card_design');
    Route::match(['get', 'post'], 'profile', [StaffController::class, 'profile'])->name('profile');

	Route::match(['get', 'post'], '/logout', [LoginController::class, 'logout'])->name('logout');

});

