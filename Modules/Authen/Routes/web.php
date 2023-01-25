<?php
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
use Illuminate\Support\Facades\Route;
use Modules\Authen\Http\Controllers\AuthenAdminController;
$module = "auth";
$prefix = "user";
Route::prefix($prefix)->group(function() use($prefix, $module) {
    $module = "auth";
    Route::prefix($module)->controller(AuthenUserController::class)->group(function () use($module, $prefix) {
        $routeName = "{$module}_{$prefix}";
        Route::get('/login', 'login')->name($routeName . '/login')->middleware('check.login');
        Route::get('/logout', 'logout')->name($routeName . '/logout');
        Route::get('/forget', 'forget')->name($routeName . '/forget');
        Route::get('/register', 'register')->name($routeName . '/register');
        Route::get('/active/{token}', 'active')->name($routeName . '/active');
    });
});
$prefix = "admin";
Route::prefix($prefix)->group(function() use($prefix, $module) {
    Route::prefix($module)->controller(AuthenAdminController::class)->group(function () use($module, $prefix) {
        $routeName = "{$module}_{$prefix}";
        Route::get('/login', 'login')->name($routeName . '/login')->middleware('check.login_admin');
        Route::get('/logout', 'logout')->name($routeName . '/logout');
    });
});
// $module = "blog";
// Route::middleware('access.adminDashboard')->prefix($prefix)->group(function() use($prefix, $module) {
//     Route::prefix($module)->controller(AuthenAdminController::class)->group(function () use($module, $prefix) {
//         $routeName = "{$module}_{$prefix}";
//         Route::get('/', 'index')->name($routeName . '/index');
//     });
// });