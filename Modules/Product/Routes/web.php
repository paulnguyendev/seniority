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
$module = "product";
$prefix = "staff";
Route::middleware('access.staffDashboard')->prefix($prefix)->group(function() use($prefix, $module) {
    Route::prefix($module)->controller(ProductStaffController::class)->group(function () use($module, $prefix) {
        $routeName = "{$module}_{$prefix}";
        Route::get('/', 'index')->name($routeName . '/index');
        Route::get('/checkLevel', 'checkLevel')->name($routeName . '/checkLevel');
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
});
$prefix = "agent";
Route::middleware('access.agentDashboard')->prefix($prefix)->group(function() use($prefix, $module) {
    Route::prefix($module)->controller(AgentStaffController::class)->group(function () use($module, $prefix) {
        $routeName = "{$module}_{$prefix}";
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
});
