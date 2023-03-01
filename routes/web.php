<?php
use App\Http\Controllers\Agent\License\AuthenController as LicenseAuthenController;
use App\Http\Controllers\Agent\NonLicense\AuthenController as NonLicenseAuthenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Agent\License\DashboardController as LicenseDashboardController;
use App\Http\Controllers\Agent\NonLicense\DashboardController as NonLicenseDashboardController;

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
Route::prefix($prefix)->group(function () use($prefix) {
   $prefix_group = "license";
   Route::prefix($prefix_group)->group(function () use($prefix,$prefix_group) {
      // Fai login mới vào được
      Route::middleware('access.licenseAgentDashboard')->group(function () use($prefix,$prefix_group) {
         Route::prefix('')->controller(LicenseDashboardController::class)->group(function () use($prefix,$prefix_group) {
            $routeName = "{$prefix}/{$prefix_group}/dashboard";
            Route::get('/', 'index')->name($routeName . '/index');
         });
      });
      # agents/license/login
      Route::controller(LicenseAuthenController::class)->group(function () use($prefix,$prefix_group) {
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
   Route::prefix($prefix_group)->group(function () use($prefix,$prefix_group) {
      // Fai login mới vào được
      Route::middleware('access.nonLicenseAgentDashboard')->group(function () use($prefix,$prefix_group) {
         Route::prefix('')->controller(NonLicenseDashboardController::class)->group(function () use($prefix,$prefix_group) {
            $routeName = "{$prefix}/{$prefix_group}/dashboard";
            Route::get('/', 'index')->name($routeName . '/index');
         });
      });
      # agents/license/login
      Route::controller(NonLicenseAuthenController::class)->group(function () use($prefix,$prefix_group) {
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
