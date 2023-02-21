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
use Modules\Agent\Http\Controllers\AdminManageController;
$module = "manage";
$prefix = "admin";
Route::middleware('access.adminDashboard')->prefix($prefix)->group(function() use($prefix, $module) {
    Route::prefix($module . "/manage")->controller(AdminManageController::class)->group(function () use($module, $prefix) {
        $routeName = "{$module}_{$prefix}_setting";
        Route::get('/', 'index')->name($routeName . '/index');
        Route::get('/data/{level_id?}', 'data')->name($routeName . '/data');
        Route::get('/{level_id?}/form/{id?}', 'form')->name($routeName . '/form');
        Route::post('/save/{id?}', 'save')->name($routeName . '/save');
        Route::post('/updateField/{task?}/{id?}', 'updateField')->name($routeName . '/updateField');
        Route::delete('/trash/{id}', 'trash')->name($routeName . '/trash');
        Route::delete('/delete/{id}', 'delete')->name($routeName . '/delete');
        Route::delete('/destroy', 'destroy')->name($routeName . '/destroy');
        Route::delete('/trashDestroy', 'trashDestroy')->name($routeName . '/trashDestroy');
        Route::get('/{level_id?}/list-trash', 'trashIndex')->name($routeName . '/trashIndex');
    });
});
$prefix = "agent";
Route::middleware('access.agentDashboard')->prefix($prefix)->group(function() use($prefix, $module) {
    Route::prefix($module)->controller(ManageAgentController::class)->group(function () use($module, $prefix) {
        $routeName = "{$module}_{$prefix}";
        Route::get('/', 'index')->name($routeName . '/index');
        Route::get('/data', 'data')->name($routeName . '/data');
        Route::post('/save/{id?}', 'save')->name($routeName . '/save');
        Route::post('/updateField/{task?}/{id?}', 'updateField')->name($routeName . '/updateField');
        Route::delete('/trash/{id}', 'trash')->name($routeName . '/trash');
        Route::delete('/delete/{id}', 'delete')->name($routeName . '/delete');
        Route::delete('/destroy', 'destroy')->name($routeName . '/destroy');
        Route::delete('/trashDestroy', 'trashDestroy')->name($routeName . '/trashDestroy');
        Route::get('/list-trash', 'trashIndex')->name($routeName . '/trashIndex');
    });
});
