<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\PlansController;


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

Route::middleware(['checkLogin'])->group(function () {
    Route::match(['get', 'post'], '/', [LoginController::class, 'login'])->name('admin.login');
    Route::match(['get', 'post'], '/login', [LoginController::class, 'login'])->name('dologin');
});


// MiddleWare Admin
Route::middleware(['adminAuth'])->group(function () {
    Route::match(['get', 'post'], '/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::match(['get', 'post'], 'get-append-view', [DashboardController::class, 'get_append_view'])->name('admin.get_append_view');


    // Slider Images
    Route::get('users', [UsersController::class, 'index'])->name('admin.users');
    Route::match(['get', 'post'], 'user/add', [UsersController::class, 'add_user'])->name('admin.user.add');
    Route::get('user/edit/{id}', [UsersController::class, 'add_user'])->name('admin.user.edit');
    Route::get('user/delete/{id}', [UsersController::class, 'delete'])->name('admin.user.delete');


    // Slider Images
    Route::get('slider', [SliderController::class, 'index'])->name('admin.slider');
    Route::match(['get', 'post'], 'slider/add', [SliderController::class, 'add_slider'])->name('admin.slider.add');
    Route::get('slider/edit/{id}', [SliderController::class, 'add_slider'])->name('admin.slider.edit');
    Route::get('slider/delete/{id}', [SliderController::class, 'delete'])->name('admin.slider.delete');


    // PlansController
    Route::get('plans', [PlansController::class, 'index'])->name('admin.plans');
    Route::match(['get', 'post'], 'plans/add', [PlansController::class, 'add_plan'])->name('admin.plans.add');
    Route::get('plans/edit/{id}', [PlansController::class, 'add_plan'])->name('admin.plans.edit');
    Route::get('plans/delete/{id}', [PlansController::class, 'delete'])->name('admin.plans.delete');


    Route::match(['get', 'post'], '/logout', [LoginController::class, 'logout'])->name('admin.logout');
});

