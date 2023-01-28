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
use Modules\MLM\Http\Controllers\AdminController;
use Modules\MLM\Http\Controllers\AdminLevelController;
$module = "mlm";
$prefix = "admin";
Route::middleware('access.adminDashboard')->prefix($prefix)->group(function() use($prefix, $module) {
    Route::prefix($module)->controller(AdminController::class)->group(function () use($module, $prefix) {
        $routeName = "{$module}_{$prefix}";
        Route::get('/setting/{slug?}', 'index')->name($routeName . '/index');
        // Route::get('/level/{slug?}', 'level')->name($routeName . '/level');
        Route::get('/dataLevel', 'dataLevel')->name($routeName . '/dataLevel');
        Route::get('/data', 'data')->name($routeName . '/data');
        Route::get('/form/{id?}', 'form')->name($routeName . '/form');
        Route::get('/formLevel/{id?}', 'formLevel')->name($routeName . '/formLevel');
        Route::post('/save/{id?}', 'save')->name($routeName . '/save');
        Route::delete('/trash/{id}', 'trash')->name($routeName . '/trash');
        Route::delete('/delete/{id}', 'delete')->name($routeName . '/delete');
        Route::delete('/destroy', 'destroy')->name($routeName . '/destroy');
        Route::delete('/trashDestroy', 'trashDestroy')->name($routeName . '/trashDestroy');
        Route::get('/change-status/{id}-{status}', 'changeStatus')->name($routeName . '/changeStatus');
        Route::get('/list-trash', 'trashIndex')->name($routeName . '/trashIndex');
    });
    Route::prefix($module . "/level")->controller(AdminLevelController::class)->group(function () use($module, $prefix) {
        $routeName = "{$module}_{$prefix}_level";
        Route::get('/', 'index')->name($routeName . '/index');
        Route::get('/data', 'data')->name($routeName . '/data');
        Route::get('/form/{id?}', 'form')->name($routeName . '/form');
        Route::post('/save/{id?}', 'save')->name($routeName . '/save');
        Route::post('/updateField/{task?}/{id?}', 'updateField')->name($routeName . '/updateField');
        Route::delete('/trash/{id}', 'trash')->name($routeName . '/trash');
        Route::delete('/delete/{id}', 'delete')->name($routeName . '/delete');
        Route::delete('/destroy', 'destroy')->name($routeName . '/destroy');
        Route::delete('/trashDestroy', 'trashDestroy')->name($routeName . '/trashDestroy');
        Route::get('/list-trash', 'trashIndex')->name($routeName . '/trashIndex');
    });
});