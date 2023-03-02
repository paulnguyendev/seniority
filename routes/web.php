<?php

use App\Http\Controllers\Agent\License\AuthenController as LicenseAuthenController;
use App\Http\Controllers\Agent\NonLicense\AuthenController as NonLicenseAuthenController;
use App\Http\Controllers\Staff\AuthenController as StaffAuthenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Agent\License\DashboardController as LicenseDashboardController;
use App\Http\Controllers\Agent\NonLicense\DashboardController as NonLicenseDashboardController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Staff\ApplicationController as StaffApplicationController;
use App\Http\Controllers\Staff\ProductController as StaffProductController;
use App\Http\Controllers\Staff\MortgageAmbassadorController as StaffMortgageAmbassadorController;

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

Route::get('/', function () {
   return "123";
});
// $prefix = "agent-test";
// Route::middleware('access.agentDashboard')->prefix($prefix)->group(function () {
//    $routeName = "agent";
//    Route::controller(LicenseDashboardController::class)->group(function () use ($routeName) {
//       Route::get('/', 'index')->name($routeName . '/index');
//    });
// });
$prefix = "agents";
Route::prefix($prefix)->group(function () use ($prefix) {
   Route::get('/', function () {
      return "Agents Area";
   });
   $prefix_group = "license";
   Route::prefix($prefix_group)->group(function () use ($prefix, $prefix_group) {
      // Fai login mới vào được
      Route::middleware('access.licenseAgentDashboard')->group(function () use ($prefix, $prefix_group) {
         Route::prefix('')->controller(LicenseDashboardController::class)->group(function () use ($prefix, $prefix_group) {
            $routeName = "{$prefix}/{$prefix_group}/dashboard";
            Route::get('/', 'index')->name($routeName . '/index');
         });
      });
      # agents/license/login
      Route::controller(LicenseAuthenController::class)->group(function () use ($prefix, $prefix_group) {
         $routeName = "{$prefix}/{$prefix_group}/auth";
         Route::get('/login', 'login')->name($routeName . '/login');
         Route::get('/logout', 'logout')->name($routeName . '/logout');
         Route::get('/forget', 'forget')->name($routeName . '/forget');
         Route::get('/register', 'register')->name($routeName . '/register');
         Route::get('/active/{token}', 'active')->name($routeName . '/active');
         Route::get('/quickLogin/{token}', 'quickLogin')->name($routeName . '/quickLogin');
         Route::post('/agentCheckParent', 'agentCheckParent')->name($routeName . '/agentCheckParent');
         Route::post('/postLogin', 'postLogin')->name($routeName . '/postLogin');
         Route::post('/postRegister', 'postRegister')->name($routeName . '/postRegister');
         Route::post('/postForget', 'postForget')->name($routeName . '/postForget');
         Route::post('/postActive', 'postActive')->name($routeName . '/postActive');
      });
   });
   $prefix_group = "nonLicense";
   Route::prefix($prefix_group)->group(function () use ($prefix, $prefix_group) {
      // Fai login mới vào được
      Route::middleware('access.nonLicenseAgentDashboard')->group(function () use ($prefix, $prefix_group) {
         Route::prefix('')->controller(NonLicenseDashboardController::class)->group(function () use ($prefix, $prefix_group) {
            $routeName = "{$prefix}/{$prefix_group}/dashboard";
            Route::get('/', 'index')->name($routeName . '/index');
         });
      });
      # agents/nonLicense/login
      Route::controller(NonLicenseAuthenController::class)->group(function () use ($prefix, $prefix_group) {
         $routeName = "{$prefix}/{$prefix_group}/auth";
         Route::get('/login', 'login')->name($routeName . '/login');
         Route::get('/logout', 'logout')->name($routeName . '/logout');
         Route::get('/forget', 'forget')->name($routeName . '/forget');
         Route::get('/register', 'register')->name($routeName . '/register');
         Route::get('/active/{token}', 'active')->name($routeName . '/active');
         Route::get('/quickLogin/{token}', 'quickLogin')->name($routeName . '/quickLogin');
         Route::post('/agentCheckParent', 'agentCheckParent')->name($routeName . '/agentCheckParent');
         Route::post('/postLogin', 'postLogin')->name($routeName . '/postLogin');
         Route::post('/postRegister', 'postRegister')->name($routeName . '/postRegister');
         Route::post('/postForget', 'postForget')->name($routeName . '/postForget');
         Route::post('/postActive', 'postActive')->name($routeName . '/postActive');
      });
   });
});
$prefix = "staffs";
Route::prefix($prefix)->group(function () use ($prefix) {
   Route::get('/', function () {
      return "Staff Area";
   });
   // Fai login mới vào được
   Route::middleware('access.staffDashboard')->group(function () use ($prefix) {
      Route::prefix('')->controller(StaffDashboardController::class)->group(function () use ($prefix) {
         $routeName = "{$prefix}/dashboard";
         Route::get('/', 'index')->name($routeName . '/index');
      });
      Route::prefix('application')->controller(StaffApplicationController::class)->group(function () use ($prefix) {
         $routeName = "{$prefix}/application";
         Route::get('/', 'index')->name($routeName . '/index');
         Route::get('/form/{id?}', 'form')->name($routeName . '/form');
         Route::get('/data', 'data')->name($routeName . '/data');
         Route::post('/save/{id?}', 'save')->name($routeName . '/save');
         Route::post('/updateField/{task?}/{id?}', 'updateField')->name($routeName . '/updateField');
         Route::delete('/trash/{id}', 'trash')->name($routeName . '/trash');
         Route::delete('/delete/{id}', 'delete')->name($routeName . '/delete');
         Route::delete('/destroy', 'destroy')->name($routeName . '/destroy');
         Route::delete('/trashDestroy', 'trashDestroy')->name($routeName . '/trashDestroy');
         Route::get('/list-trash', 'trashIndex')->name($routeName . '/trashIndex');
      });
      Route::prefix('mortgage-ambassador')->controller(StaffMortgageAmbassadorController::class)->group(function () use ($prefix) {
         $routeName = "{$prefix}/mortgage";
         Route::get('/', 'index')->name($routeName . '/index');
         Route::get('/form/{id?}', 'form')->name($routeName . '/form');
         Route::get('/data', 'data')->name($routeName . '/data');
         Route::post('/save/{id?}', 'save')->name($routeName . '/save');
         Route::post('/updateField/{task?}/{id?}', 'updateField')->name($routeName . '/updateField');
         Route::delete('/trash/{id}', 'trash')->name($routeName . '/trash');
         Route::delete('/delete/{id}', 'delete')->name($routeName . '/delete');
         Route::delete('/destroy', 'destroy')->name($routeName . '/destroy');
         Route::delete('/trashDestroy', 'trashDestroy')->name($routeName . '/trashDestroy');
         Route::get('/list-trash', 'trashIndex')->name($routeName . '/trashIndex');
         Route::post('/suspend/{id?}/{suspend?}', 'suspend')->name($routeName . '/suspend');
         Route::post('/sendMailVerify/{email?}/{token?}/{verify_code?}', 'sendMailVerify')->name($routeName . '/sendMailVerify');
      });
      Route::prefix('product')->controller(StaffProductController::class)->group(function () use ($prefix) {
         $routeName = "{$prefix}/product";
         Route::get('/', 'index')->name($routeName . '/index');
         Route::get('/form/{id?}', 'form')->name($routeName . '/form');
         Route::get('/application', 'application')->name($routeName . '/application');
         Route::get('/data', 'data')->name($routeName . '/data');
         Route::post('/save/{id?}', 'save')->name($routeName . '/save');
         Route::post('/updateField/{task?}/{id?}', 'updateField')->name($routeName . '/updateField');
         Route::delete('/trash/{id}', 'trash')->name($routeName . '/trash');
         Route::delete('/delete/{id}', 'delete')->name($routeName . '/delete');
         Route::delete('/destroy', 'destroy')->name($routeName . '/destroy');
         Route::delete('/trashDestroy', 'trashDestroy')->name($routeName . '/trashDestroy');
         Route::get('/list-trash', 'trashIndex')->name($routeName . '/trashIndex');
         Route::get('/checkLevel', 'checkLevel')->name($routeName . '/checkLevel');
      });
   });
   # staffs/login
   Route::controller(StaffAuthenController::class)->group(function () use ($prefix) {
      $routeName = "{$prefix}/auth";
      Route::get('/login', 'login')->name($routeName . '/login');
      Route::get('/logout', 'logout')->name($routeName . '/logout');
      Route::get('/forget', 'forget')->name($routeName . '/forget');
      Route::get('/register', 'register')->name($routeName . '/register');
      Route::get('/active/{token}', 'active')->name($routeName . '/active');
      Route::get('/quickLogin/{token}', 'quickLogin')->name($routeName . '/quickLogin');
      Route::post('/agentCheckParent', 'agentCheckParent')->name($routeName . '/agentCheckParent');
      Route::post('/postLogin', 'postLogin')->name($routeName . '/postLogin');
      Route::post('/postRegister', 'postRegister')->name($routeName . '/postRegister');
      Route::post('/postForget', 'postForget')->name($routeName . '/postForget');
      Route::post('/postActive', 'postActive')->name($routeName . '/postActive');
   });

});
