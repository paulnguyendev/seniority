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

$module = "media";
$prefix = "admin";
Route::middleware('access.adminDashboard')->prefix($prefix)->group(function() use($prefix, $module) {
    Route::prefix($module)->controller(MediaController::class)->group(function () use($module, $prefix) {
        $routeName = "{$module}_{$prefix}";
        Route::get('/folders', 'folders')->name($routeName . '/folders');
        Route::post('/upload', 'upload')->name($routeName . '/upload');
        Route::post('/action', 'action')->name($routeName . '/action');
       
    });
});