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
        Route::get('/data', 'data')->name($routeName . '/data');
        Route::get('/profile', 'profile')->name($routeName . '/profile');
        Route::get('/form/{id?}', 'form')->name($routeName . '/form');
        Route::post('/save/{id?}', 'save')->name($routeName . '/save');
        Route::delete('/trash/{id}', 'trash')->name($routeName . '/trash');
        Route::delete('/delete/{id}', 'delete')->name($routeName . '/delete');
        Route::delete('/destroy', 'destroy')->name($routeName . '/destroy');
        Route::delete('/trashDestroy', 'trashDestroy')->name($routeName . '/trashDestroy');
        Route::post('/profileSave', 'profileSave')->name($routeName . '/profileSave');
        Route::get('/change-status/{id}-{status}', 'changeStatus')->name($routeName . '/changeStatus');
        Route::post('/suspend/{id?}/{suspend?}', 'suspend')->name($routeName . '/suspend');
        Route::post('/sendMailVerify/{email?}/{token?}', 'sendMailVerify')->name($routeName . '/sendMailVerify');
        Route::get('/list-trash', 'trashIndex')->name($routeName . '/trashIndex');
        Route::post('/updateField/{task?}/{id?}', 'updateField')->name($routeName . '/updateField');
    });
});
$prefix = "user";
Route::middleware('access.userDashboard')->prefix($prefix)->group(function() use($prefix, $module) {
    Route::controller(UserManageUserController::class)->group(function () use($module, $prefix) {
        $routeName = "{$module}_{$prefix}";
        Route::get('/profile', 'profile')->name($routeName . '/profile');
    });
});
