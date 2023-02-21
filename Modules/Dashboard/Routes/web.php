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
use Modules\Dashboard\Http\Controllers\DashboardAgentController;

$module = "dashboard";
$prefix = "staff";
Route::middleware('access.adminDashboard')->prefix($prefix)->group(function() use($prefix, $module) {
    Route::prefix($module)->controller(AdminManageUserController::class)->group(function () use($module, $prefix) {
        $routeName = "{$module}_{$prefix}";
        Route::get('/', 'index')->name($routeName . '/index');
    });
});
$prefix = "agent";
Route::middleware('access.agentDashboard')->prefix($prefix)->group(function() use($prefix, $module) {
    Route::prefix($module)->controller(DashboardAgentController::class)->group(function () use($module, $prefix) {
        $routeName = "{$module}_{$prefix}";
        Route::get('/', 'index')->name($routeName . '/index');
        Route::get('/profile', 'profile')->name($routeName . '/profile');
    });
});
$prefix = "staff";
Route::middleware('access.staffDashboard')->prefix($prefix)->group(function() use($prefix, $module) {
    Route::prefix($module)->controller(DashboardStaffController::class)->group(function () use($module, $prefix) {
        $routeName = "{$module}_{$prefix}";
        Route::get('/', 'index')->name($routeName . '/index');
        Route::get('/profile', 'profile')->name($routeName . '/profile');
    });
});
