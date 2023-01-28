<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
use Illuminate\Support\Facades\Route;
use Modules\Authen\Http\Controllers\AuthenApiController;
Route::middleware('auth:api')->get('/authen', function (Request $request) {
    return $request->user();
});
#_User
Route::middleware('web')->prefix('auth')->group(function() {
    $routeName = "auth_api";
    // Route::controller(AuthenApiController::class)->group(function () use ($routeName) {
    //     Route::post('/register', 'register')->name($routeName . '/register');
    //     Route::post('/login', 'login')->name($routeName . '/login');
    //     Route::post('/loginAdmin', 'loginAdmin')->name($routeName . '/loginAdmin');
 
    // });
    //Route::get('/', 'AuthenController@index');
});