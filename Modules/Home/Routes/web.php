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
use Modules\Home\Http\Controllers\AdminHomeController;

// $module = "home";
// $prefix = "admin";
// Route::middleware('access.adminDashboard')->prefix($prefix)->group(function() use($prefix, $module) {
//     Route::prefix('')->controller(AdminHomeController::class)->group(function () use($module, $prefix) {
//         $routeName = "{$module}_{$prefix}";
//         Route::get('/', 'index')->name($routeName . '/index');
       
//     });
// });