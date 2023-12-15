<?php

defined('BASEPATH') OR exit('No direct script access allowed');



/*

| -------------------------------------------------------------------------

| URI ROUTING

| -------------------------------------------------------------------------

| This file lets you re-map URI requests to specific controller functions.

|

| Typically there is a one-to-one relationship between a URL string

| and its corresponding controller class/method. The segments in a

| URL normally follow this pattern:

|

|	example.com/class/method/id/

|

| In some instances, however, you may want to remap this relationship

| so that a different class/function is called than the one

| corresponding to the URL.

|

| Please see the user guide for complete details:

|

|	https://codeigniter.com/user_guide/general/routing.html

|

| -------------------------------------------------------------------------

| RESERVED ROUTES

| -------------------------------------------------------------------------

|

| There are three reserved routes:

|

|	$route['default_controller'] = 'welcome';

|

| This route indicates which controller class should be loaded if the

| URI contains no data. In the above example, the "welcome" class

| would be loaded.

|

|	$route['404_override'] = 'errors/page_missing';

|

| This route will tell the Router which controller/method to use if those

| provided in the URL cannot be matched to a valid route.

|

|	$route['translate_uri_dashes'] = FALSE;

|

| This is not exactly a route, but allows you to automatically route

| controller and method names that contain dashes. '-' isn't a valid

| class or method name character, so it requires translation.

| When you set this option to TRUE, it will replace ALL dashes in the

| controller and method URI segments.

|

| Examples:	my-controller/index	-> my_controller/index

|		my-controller/my-method	-> my_controller/my_method

*/

//$route['default_controller'] = 'Front/Home';

$route['404_override'] = '';

$route['translate_uri_dashes'] = FALSE;

$route['default_controller'] = 'Admin/Login';
$route['admin'] = 'Admin/Dashboard';
$route['admin/(:num)'] = 'Admin/Dashboard';
$route['admin/logout'] = 'Admin/Login/logout';


/*==== Admin Users ====*/

$route['admin/users'] = 'Admin/Users';

$route['admin/users/(:num)'] = 'Admin/Users';

$route['admin/deleteuser/:num'] = 'Admin/Users/deleteuser';

$route['admin/deleteuser'] = 'Admin/Users/deleteuser';

$route['admin/adduser'] = 'Admin/Adduser';

$route['admin/adduservalidation'] = 'Admin/Adduser/adduserAjaxValidation';

$route['admin/edituser/:num'] = 'Admin/Edituser';

$route['admin/edituser/updateuservalidation'] = 'Admin/Edituser/updateuserAjaxValidation';

/*Edit Profile*/
$route['admin/editprofile'] = 'Admin/Users/editprofile';
$route['admin/updateprofile'] = 'Admin/Users/updateprofile';

/*==== Admin Crops ====*/
$route['admin/crops'] = 'Admin/Crops';
$route['admin/crops/(:num)'] = 'Admin/Crops';
$route['admin/cropedit'] = 'Admin/Crops/cropedit';
$route['admin/deletecrop/:num'] = 'Admin/Crops/deletecrop';
$route['admin/restorecrop/:num'] = 'Admin/Crops/restorecrop';

$route['admin/deletecrop'] = 'Admin/Crops/deletecrop';

/*==== Admin Controlvariety ====*/
$route['admin/controlvariety'] = 'Admin/Controlvariety';
$route['admin/controlvariety/(:num)'] = 'Admin/Controlvariety';
$route['admin/controlvarietyedit'] = 'Admin/Controlvariety/controlvarietyedit';
$route['admin/deletecontrolvariety/:num'] = 'Admin/Controlvariety/deletecontrolvariety';
$route['admin/restorecontrolvariety/:num'] = 'Admin/Controlvariety/restorecontrolvariety';

/*==== Admin Suppliers ====*/
$route['admin/suppliers'] = 'Admin/Suppliers';
$route['admin/suppliers/(:num)'] = 'Admin/Suppliers';
$route['admin/supplieredit'] = 'Admin/Suppliers/supplieredit';
$route['admin/deletesupplier/:num'] = 'Admin/Suppliers/deletesupplier';
$route['admin/restoresupplier/:num'] = 'Admin/Suppliers/restoresupplier';

$route['admin/deletesupplier'] = 'Admin/Suppliers/deletesupplier';



/*==== Admin Seeds ====*/
$route['admin/seeds'] = 'Admin/Seeds';
$route['admin/seeds/(:num)'] = 'Admin/Seeds';
$route['admin/seededit'] = 'Admin/Seeds/seededit';
$route['admin/seedview'] = 'Admin/Seeds/seedview';
$route['admin/deleteseed/:num'] = 'Admin/Seeds/deleteseed';
$route['admin/restoreseed/:num'] = 'Admin/Seeds/restoreseed';
$route['admin/checkvariety'] = 'Admin/Seeds/checkvariety';
$route['admin/stocks'] = 'Admin/Seeds/stocks';
$route['admin/stocks/(:num)'] = 'Admin/Seeds/stocks';
$route['admin/getstock'] = 'Admin/Seeds/getstock';
$route['admin/updateseed'] = 'Admin/Seeds/updateseed';

$route['admin/deleteseed'] = 'Admin/Seeds/deleteseed';

$route['admin/seedsexport'] = 'Admin/Seeds/seedsexport';
$route['admin/stocksexport'] = 'Admin/Seeds/stocksexport';

// development
$route['admin/seedsummary'] = 'Admin/Seeds/seedsummary';
$route['admin/summaryexport'] = 'Admin/Seeds/summaryexport';

$route['admin/seedsadd'] = 'Admin/Seeds/seedsadd';
$route['admin/seedstatus'] = 'Admin/Seeds/seedstatus';
$route['admin/seedrecord'] = 'Admin/Seeds/seedrecord';

$route['admin/seed_images_edit'] = 'Admin/Seeds/seed_images_edit';


/*==== Admin Receivers ====*/
$route['admin/receivers'] = 'Admin/Receivers';
$route['admin/receivers/(:num)'] = 'Admin/Receivers';
$route['admin/receiverview'] = 'Admin/Receivers/receiverview';
$route['admin/receiveredit'] = 'Admin/Receivers/receiveredit';
$route['admin/deletereceiver/:num'] = 'Admin/Receivers/deletereceiver';
$route['admin/restorereceiver/:num'] = 'Admin/Receivers/restorereceiver';

$route['admin/deletereceiver'] = 'Admin/Receivers/deletereceiver';

/*==== Admin Techncial team ====*/
$route['admin/techncialteam'] = 'Admin/Techncialteam';
$route['admin/techncialteam/(:num)'] = 'Admin/Techncialteam';
$route['admin/techncialteamedit'] = 'Admin/Techncialteam/techncialteamedit';
$route['admin/deletetechncialteam/:num'] = 'Admin/Techncialteam/deletetechncialteam';
$route['admin/restoretechncialteam/:num'] = 'Admin/Techncialteam/restoretechncialteam';

$route['admin/deletetechncialteam'] = 'Admin/Techncialteam/deletetechncialteam';

/*==== Admin Sampling ====*/
$route['admin/sampling'] = 'Admin/Sampling';
$route['admin/sampling/(:num)'] = 'Admin/Sampling';
$route['admin/samplingedit'] = 'Admin/Sampling/samplingedit';
$route['admin/samplingview'] = 'Admin/Sampling/samplingview';
$route['admin/location'] = 'Admin/Sampling/location';
$route['admin/location_view'] = 'Admin/Sampling/location_view';
$route['admin/refreshInternalsamplingcode'] = 'Admin/Sampling/refreshInternalsamplingcode';
$route['admin/check_Internalsamplingcode'] = 'Admin/Sampling/check_Internalsamplingcode';
$route['admin/seed'] = 'Admin/Sampling/seed';
$route['admin/seed_view'] = 'Admin/Sampling/seed_view';
$route['admin/seedstock'] = 'Admin/Sampling/seedstock';
$route['admin/seedstock_view'] = 'Admin/Sampling/seedstock_view';
$route['admin/deletesampling/:num'] = 'Admin/Sampling/deletesampling';
$route['admin/restoresampling/:num'] = 'Admin/Sampling/restoresampling';

$route['admin/deletesampling'] = 'Admin/Sampling/deletesampling';

$route['admin/samplingsexport'] = 'Admin/Sampling/samplingsexport';

/*==== Admin Trial ====*/
$route['admin/trial'] = 'Admin/Trial';
$route['admin/trial/(:num)'] = 'Admin/Trial';
$route['admin/trialedit'] = 'Admin/Trial/trialedit';
$route['admin/trialview'] = 'Admin/Trial/trialview';
$route['admin/trialcheckinternalcode'] = 'Admin/Trial/checkinternalcode';
$route['admin/restoretrial/:num'] = 'Admin/Trial/restoretrial';
$route['admin/deletetrial/:num'] = 'Admin/Trial/deletetrial';
$route['admin/trialreport'] = 'Admin/Trial/trialreport';
$route['admin/reporttrial/:num'] = 'Admin/Trial/reporttrial';

$route['admin/deletetrial'] = 'Admin/Trial/deletetrial';

// development
$route['admin/trialsummary'] = 'Admin/Trial/trialsummary';
$route['admin/viewtrial'] = 'Admin/Trial/viewtrial';
$route['admin/triallocation'] = 'Admin/Trial/triallocation';


/*==== Admin Evaluation ====*/
$route['admin/evaluation'] = 'Admin/Evaluation';
$route['admin/evaluation/(:num)'] = 'Admin/Evaluation';
$route['admin/evaluationedit'] = 'Admin/Evaluation/evaluationedit';
$route['admin/evaluationview'] = 'Admin/Evaluation/evaluationedit';
$route['admin/evaluationclose'] = 'Admin/Evaluation/evaluationclose';
$route['admin/evaluationclose/(:num)'] = 'Admin/Evaluation/evaluationclose';
$route['admin/evaluationcheckinternalcode'] = 'Admin/Evaluation/checkinternalcode';
$route['admin/deleteevaluation/:num'] = 'Admin/Evaluation/deleteevaluation';
$route['admin/restoreevaluation/:num'] = 'Admin/Evaluation/restoreevaluation';
$route['admin/reportevaluation/:num'] = 'Admin/Evaluation/reportevaluation';
$route['admin/evaluationreport'] = 'Admin/Evaluation/evaluationreport';

$route['admin/deleteevaluation'] = 'Admin/Evaluation/deleteevaluation';

$route['admin/removeevaluation'] = 'Admin/Evaluation/removeevaluation';
$route['admin/removeevaluation/:num'] = 'Admin/Evaluation/removeevaluation';

// Development
$route['admin/viewcloseevaluation'] = 'Admin/Evaluation/viewcloseevaluation';
$route['admin/evaluationlocation'] = 'Admin/Evaluation/evaluationlocation';

/*==== Admin Recheck ====*/
$route['admin/recheck'] = 'Admin/Recheck';
$route['admin/recheck/(:num)'] = 'Admin/Recheck';
$route['admin/recheckedit'] = 'Admin/Recheck/recheckedit';
$route['admin/restorerecheck/:num'] = 'Admin/Recheck/restorerecheck';
$route['admin/deleterecheck/:num'] = 'Admin/Recheck/deleterecheck';

$route['admin/deleterecheck'] = 'Admin/Recheck/deleterecheck';

$route['admin/recheckstatus'] = 'Admin/Recheck/recheckstatus';

$route['admin/recheckcheckinternalcode'] = 'Admin/Recheck/checkinternalcode';


// Development

$route['admin/rechecksummary'] = 'Admin/Recheck/rechecksummary';
$route['admin/seed_recheck'] = 'Admin/Recheck/seed_recheck';
$route['admin/supplier_recheck'] = 'Admin/Recheck/supplier_recheck';


/*==== Admin Precommercial ====*/
$route['admin/precommercial'] = 'Admin/Precommercial';
$route['admin/precommercial/(:num)'] = 'Admin/Precommercial';
$route['admin/precommercialedit'] = 'Admin/Precommercial/precommercialedit';
$route['admin/deleteprecommercial/:num'] = 'Admin/Precommercial/deleteprecommercial';
$route['admin/restoreprecommercial/:num'] = 'Admin/Precommercial/restoreprecommercial';

$route['admin/deleteprecommercial'] = 'Admin/Precommercial/deleteprecommercial';


/*==== Admin Phonebook ====*/
$route['admin/phonebook'] = 'Admin/Phonebook';
$route['admin/phonebook/(:num)'] = 'Admin/Phonebook';
$route['admin/phonebookadd'] = 'Admin/Phonebook/phonebookadd';
$route['admin/deletephonebook/:num'] = 'Admin/Phonebook/deletephonebook';
$route['admin/addphonebookvalidation'] = 'Admin/Phonebook/addphonebookAjaxValidation';
$route['admin/phonebookedit/:num'] = 'Admin/Phonebook/phonebookedit';
$route['admin/phonebookedit/updatephonebookvalidation'] = 'Admin/Phonebook/updatephonebookAjaxValidation';

$route['admin/phonebookexport'] = 'Admin/Phonebook/phonebookexport';

/*==== Admin Logs ====*/
$route['admin/logs'] = 'Admin/Logs';
$route['admin/logs/(:num)'] = 'Admin/Logs';
$route['admin/clearlogs'] = 'Admin/Logs/clearlogs';
$route['admin/restores'] = 'Admin/Restores';
$route['admin/restore/delete/(:any)/(:num)'] = 'Admin/Restores/restore_delete';
$route['admin/restore/restore/(:any)/(:num)'] = 'Admin/Restores/restore_delete';

/*========== API Routing ==========*/
$route['api/user/login'] = 'Api/User';
$route['api/evaluation'] = 'Api/Evaluation';
$route['api/evaluation/add'] = 'Api/Evaluation/add';
$route['api/evaluation/internalsamplecode'] = 'Api/Evaluation/internalsamplecode';
$route['api/evaluation/checkinternalsamplecode'] = 'Api/Evaluation/checkinternalsamplecode';

$route['api/trial'] = 'Api/Trial';
$route['api/trial/add'] = 'Api/Trial/add';
$route['api/trial/edit'] = 'Api/Trial/edit';