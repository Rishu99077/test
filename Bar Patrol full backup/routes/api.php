<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserAuthController;
use App\Http\Controllers\Api\LocationsApiController;
use App\Http\Controllers\Api\VendorsApiController;
use App\Http\Controllers\Api\IconsApiController;
use App\Http\Controllers\Api\ProductTypeApiController;
use App\Http\Controllers\Api\ListApiController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\ProductCategorieApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\InventryApiController;

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
Route::post("list/countries",[ListApiController::class,'countries']);
Route::post("list/states",[ListApiController::class,'states']);
Route::post("list/cities",[ListApiController::class,'cities']);

Route::post("customer_signup",[UserAuthController::class,'customer_signup']);
Route::post("customer_login",[UserAuthController::class,'customer_login']);

Route::post("restaurant/detail",[RestaurantController::class,'detail']);
Route::post("restaurant/update",[RestaurantController::class,'update']);
Route::post("restaurant/changepassword",[RestaurantController::class,'changepassword']);
// Route::post("restaurant/newpassword",[RestaurantController::class,'newpassword']);
Route::post("restaurant/forgotpassword",[RestaurantController::class,'forgotpassword']);
Route::post("restaurant/check_number",[RestaurantController::class,'check_number']);

Route::post("location/add",[LocationsApiController::class,'add']);
Route::post("location/detail",[LocationsApiController::class,'detail']);
Route::post("location/update",[LocationsApiController::class,'update']);
Route::post("location/locations_list",[LocationsApiController::class,'locations_list']);
Route::post("location/delete",[LocationsApiController::class,'delete']);

Route::post("vendor/add",[VendorsApiController::class,'add']);
Route::post("vendor/detail",[VendorsApiController::class,'detail']);
Route::post("vendor/update",[VendorsApiController::class,'update']);
Route::post("vendor/vendors_list",[VendorsApiController::class,'vendors_list']);
Route::post("vendor/vendor_delete",[VendorsApiController::class,'vendor_delete']);

Route::post("icon/add",[IconsApiController::class,'add']);
Route::post("icon/detail",[IconsApiController::class,'detail']);
Route::post("icon/update",[IconsApiController::class,'update']);
Route::post("icon/icons_list",[IconsApiController::class,'icons_list']);
Route::post("icon/icon_delete",[IconsApiController::class,'icon_delete']);

Route::post("product_type_add",[ProductTypeApiController::class,'product_type_add']);
Route::post("product_type_detail",[ProductTypeApiController::class,'product_type_detail']);
Route::post("product_type_update",[ProductTypeApiController::class,'product_type_update']);
Route::post("product_type_list",[ProductTypeApiController::class,'product_type_list']);
Route::post("product_type_delete",[ProductTypeApiController::class,'product_type_delete']);

Route::post("product_categorie_add",[ProductCategorieApiController::class,'product_categorie_add']);
// new
Route::post("product_categorie_add_new",[ProductCategorieApiController::class,'product_categorie_add_new']);
Route::post("product_categorie_detail",[ProductCategorieApiController::class,'product_categorie_detail']);
// new
Route::post("product_categorie_detail_new",[ProductCategorieApiController::class,'product_categorie_detail_new']);
Route::post("product_categorie_update",[ProductCategorieApiController::class,'product_categorie_update']);
// new
Route::post("product_categorie_update_new",[ProductCategorieApiController::class,'product_categorie_update_new']);
Route::post("product_categorie_list",[ProductCategorieApiController::class,'product_categorie_list']);
Route::post("product_categorie_delete",[ProductCategorieApiController::class,'product_categorie_delete']);

Route::post("product/product_add",[ProductApiController::class,'product_add']);
Route::post("product/product_detail",[ProductApiController::class,'product_detail']);
Route::post("product/product_update",[ProductApiController::class,'product_update']);
Route::post("product/product_list",[ProductApiController::class,'product_list']);
Route::post("product/delete",[ProductApiController::class,'delete']);

Route::post("product/product_quantity_update",[ProductApiController::class,'product_quantity_update']);	

Route::post("order/add_order",[OrderApiController::class,'add_order']);
Route::post("order/purchase_order_detail",[OrderApiController::class,'purchase_order_detail']);
Route::post("order/place_order",[OrderApiController::class,'place_order']);
Route::post("order/received_order_detail",[OrderApiController::class,'received_order_detail']);
Route::post("order/add_order_to_invoice",[OrderApiController::class,'add_order_to_invoice']);

Route::post("inventry/add_inventry",[InventryApiController::class,'add_inventry']);
Route::post("inventry/all_inventries",[InventryApiController::class,'all_inventries']);
Route::post("inventry/view_inventry_detail",[InventryApiController::class,'view_inventry_detail']);
Route::post("inventry/inventry_locations",[InventryApiController::class,'inventry_locations']);
Route::post("inventry/edit_inventry",[InventryApiController::class,'edit_inventry']);
Route::post("inventry/add_inventry_products",[InventryApiController::class,'add_inventry_products']);


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
