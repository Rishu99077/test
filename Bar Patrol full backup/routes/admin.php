<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Adminview\AdminController;
use App\Http\Controllers\AdminControllers\IconsController;
use App\Http\Controllers\AdminControllers\ProductTypeController;
use App\Http\Controllers\AdminControllers\ProductCategorieController;
use App\Http\Controllers\AdminControllers\VendorController;
use App\Http\Controllers\AdminControllers\LocationsController;

use App\Http\Controllers\AdminControllers\ProductsController;
use App\Http\Controllers\AdminControllers\InventriesController;

use App\Http\Controllers\AdminControllers\UserController;
use App\Http\Controllers\AdminControllers\PurchaseOrderController;
use App\Http\Controllers\AdminControllers\ReceiveProductsController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group whic
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin_login', function () {
    return view('login');
});

Route::get("Login", [AdminController::class, 'Login']);
Route::get("get_states_by_countryid/{CountryID}", [AdminController::class, 'get_states_by_countryid']);
Route::get("get_cities_by_stateid/{StateID}", [AdminController::class, 'get_cities_by_stateid']);

Route::get("Signup", [AdminController::class, 'Signup']);

Route::post("save_signup", [AdminController::class, 'save_signup']);
Route::get("logout", [AdminController::class, 'logout']);

Route::middleware(['CustomAuth'])->group(function () {
    // dashboard
    Route::get("/dashboard", [AdminController::class, 'dashboard']);

    // Products Type
    Route::get("/Product_type", [ProductTypeController::class, 'Product_type']);
    Route::get("/admin_type", [ProductTypeController::class, 'admin_type']);
    Route::get("/master_type", [ProductTypeController::class, 'master_type']);

    Route::get("/add_Producttype", [ProductTypeController::class, 'add_Producttype']);
    Route::post("save_product_type", [ProductTypeController::class, 'save_product_type']);
    Route::get("/delete_Producttype", [ProductTypeController::class, 'delete_Producttype']);

    Route::post("addtype_from_master", [ProductTypeController::class, 'addtype_from_master']);
    Route::post("product_type_movetomaster", [ProductTypeController::class, 'product_type_movetomaster']);
    Route::post("product_type_remove_master", [ProductTypeController::class, 'product_type_remove_master']);

    // Icons
    Route::get("/icons", [IconsController::class, 'icons']);
    Route::get("/test", [IconsController::class, 'test']);
    Route::get("/add_icons", [IconsController::class, 'add_icons']);
    Route::post("save_icons", [IconsController::class, 'save_icons']);
    Route::get("/delete_icons", [IconsController::class, 'delete_icons']);


    // Location
    Route::get("/locations", [LocationsController::class, 'locations']);

    Route::get("/add_location", [LocationsController::class, 'add_location']);
    Route::post("save_locations", [LocationsController::class, 'save_locations']);
    Route::get("/delete_location", [LocationsController::class, 'delete_location']);

    Route::post("add_location_from_master", [LocationsController::class, 'add_location_from_master']);
    Route::post("location_movetomaster", [LocationsController::class, 'location_movetomaster']);
    Route::post("location_remove_master", [LocationsController::class, 'location_remove_master']);


    // Products categorie
    Route::get("/productcategorie", [ProductCategorieController::class, 'productcategorie']);

    Route::get("/add_productcategorie", [ProductCategorieController::class, 'add_productcategorie']);
    Route::post("save_categorie", [ProductCategorieController::class, 'save_categorie']);
    Route::get("/delete_categorie", [ProductCategorieController::class, 'delete_categorie']);

    Route::post("addcategorie_from_master", [ProductCategorieController::class, 'addcategorie_from_master']);
    Route::post("categorie_movetomaster", [ProductCategorieController::class, 'categorie_movetomaster']);
    Route::post("categorie_remove_master", [ProductCategorieController::class, 'categorie_remove_master']);

    // Update Sorting

    Route::post("Product-save-position", [ProductTypeController::class, 'ProductsavePosition'])->name("product.savePosition");
    Route::post("Product-edit-position", [ProductTypeController::class, 'ProducteditPosition'])->name("product.editPosition");




    // Vendors
    Route::get("/vendors", [VendorController::class, 'vendors']);
    Route::get("/admin_vendors", [VendorController::class, 'admin_vendors']);
    Route::get("/master_vendors", [VendorController::class, 'master_vendors']);

    Route::get("/add_vendor", [VendorController::class, 'add_vendor']);
    Route::post("save_vendor", [VendorController::class, 'save_vendor']);
    Route::get("/delete_vendor", [VendorController::class, 'delete_vendor']);

    Route::post("add_from_master", [VendorController::class, 'add_from_master']);
    Route::post("vendor_movetomaster", [VendorController::class, 'vendor_movetomaster']);
    Route::post("vendor_remove_master", [VendorController::class, 'vendor_remove_master']);


    // Products
    Route::get("/products", [ProductsController::class, 'products']);
    Route::get("/admin_products", [ProductsController::class, 'admin_products']);
    Route::get("/master_products", [ProductsController::class, 'master_products']);

    Route::get("/add_product", [ProductsController::class, 'add_product']);
    Route::post("save_product", [ProductsController::class, 'save_product']);
    Route::get("/delete_product", [ProductsController::class, 'delete_product']);
    Route::post("/get_categories", [ProductsController::class, 'get_categories']);

    Route::post("addproduct_from_master", [ProductsController::class, 'addproduct_from_master']);
    Route::post("product_movetomaster", [ProductsController::class, 'product_movetomaster']);
    Route::post("product_remove_master", [ProductsController::class, 'product_remove_master']);


    // Inventry
    Route::get("/inventries", [InventriesController::class, 'inventries']);
    Route::get("/add_inventrie", [InventriesController::class, 'add_inventrie']);
    Route::get("/view_inventrie", [InventriesController::class, 'view_inventrie']);
    Route::get("/view_locationinventrie", [InventriesController::class, 'view_locationinventrie']);

    Route::post("save_inventrie", [InventriesController::class, 'save_inventrie']);
    Route::get("/delete_inventrie", [InventriesController::class, 'delete_inventrie']);

    Route::post("get_products", [InventriesController::class, 'get_products']);
    Route::post("get_locations", [InventriesController::class, 'get_locations']);

    Route::post("save_inventrie_products", [InventriesController::class, 'save_inventrie_products']);

    Route::post("save_single_inventrie", [InventriesController::class, 'save_single_inventrie']);
    Route::post("delete_inventrie_products", [InventriesController::class, 'delete_inventrie_products']);
    Route::get("/edit_inventries", [InventriesController::class, 'edit_inventries']);
    Route::post("update_single_inventrie", [InventriesController::class, 'update_single_inventrie']);
    Route::post("update_quantity", [InventriesController::class, 'update_quantity']);
    Route::post("update_weight", [InventriesController::class, 'update_weight']);


    // Users
    Route::get("/users", [UserController::class, 'users']);
    Route::get("/add_user", [UserController::class, 'add_user']);
    Route::post("save_user", [UserController::class, 'save_user']);
    Route::get("/delete_user", [UserController::class, 'delete_user']);
    Route::get("/update_userprofile", [UserController::class, 'update_userprofile']);

    // Purchase order
    Route::get("/purchase_order", [PurchaseOrderController::class, 'purchase_order']);
    Route::post("save_draft_order", [PurchaseOrderController::class, 'save_draft_order']);
    Route::post("save_purchase_order", [PurchaseOrderController::class, 'save_purchase_order']);
    Route::post("save_single_order", [PurchaseOrderController::class, 'save_single_order']);
    Route::get("/delete_purchase_order", [PurchaseOrderController::class, 'delete_purchase_order']);
    Route::get("/save_order", [PurchaseOrderController::class, 'save_order']);

    // Receive Products
    Route::get("/receive_products", [ReceiveProductsController::class, 'receive_products']);
    Route::get("update_productstatus", [ReceiveProductsController::class, 'update_productstatus']);
    Route::get("/delete_order", [ReceiveProductsController::class, 'delete_order']);

    // Invoice
    Route::get("/invoice", [ReceiveProductsController::class, 'invoice']);
    Route::get("/view_invoice", [ReceiveProductsController::class, 'view_invoice']);
    Route::get("/delete_invoice", [ReceiveProductsController::class, 'delete_invoice']);
});





Route::get('/clear-all', function () {

    Artisan::call('cache:clear');

    Artisan::call('optimize');

    Artisan::call('route:cache');

    Artisan::call('route:clear');

    Artisan::call('view:clear');

    Artisan::call('config:cache');

    return '<h1>Cache all value cleared</h1>';
});



//Clear Cache facade value:

Route::get('/clear-cache', function () {

    $exitCode = Artisan::call('cache:clear');

    return '<h1>Cache facade value cleared</h1>';
});



//Reoptimized class loader:

Route::get('/optimize', function () {

    $exitCode = Artisan::call('optimize');

    return '<h1>Reoptimized class loader</h1>';
});



//Route cache:

Route::get('/route-cache', function () {

    $exitCode = Artisan::call('route:cache');

    return '<h1>Routes cached</h1>';
});



//Clear Route cache:

Route::get('/route-clear', function () {

    $exitCode = Artisan::call('route:clear');

    return '<h1>Route cache cleared</h1>';
});



//Clear View cache:

Route::get('/view-clear', function () {

    $exitCode = Artisan::call('view:clear');

    return '<h1>View cache cleared</h1>';
});



//Clear Config cache:

Route::get('/config-cache', function () {

    $exitCode = Artisan::call('config:cache');

    return '<h1>Clear Config cleared</h1>';
});
