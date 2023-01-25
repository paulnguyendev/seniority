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
$module = "user";
$prefix = "admin";
Route::middleware('access.adminDashboard')->prefix($prefix)->group(function() use($prefix, $module) {
    Route::prefix($module)->controller(AdminManageUserController::class)->group(function () use($module, $prefix) {
        $routeName = "{$module}_{$prefix}";
        Route::get('/', 'index')->name($routeName . '/index');
        Route::get('/profile', 'profile')->name($routeName . '/profile');
        Route::get('/form/{id?}', 'form')->name($routeName . '/form');
        Route::get('/delete/{id}', 'delete')->name($routeName . '/delete');
        Route::get('/change-status/{id}-{status}', 'changeStatus')->name($routeName . '/changeStatus');
    });
});
$prefix = "user";
Route::middleware('access.userDashboard')->prefix($prefix)->group(function() use($prefix, $module) {
    Route::controller(UserManageUserController::class)->group(function () use($module, $prefix) {
        $routeName = "{$module}_{$prefix}";
        Route::get('/profile', 'profile')->name($routeName . '/profile');
    });
});
