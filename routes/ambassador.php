<?php
use Illuminate\Support\Facades\Route;
Route::prefix('')->group(function () {
    $prefix = config('prefix.portal');
    $controller = "home";
    $controllerName =  ucfirst($controller) . "Controller";
    #_ /ambassador
    Route::get('/', "{$controllerName}@index")->name($prefix . '/index');
    #_ /ambassador/mortgage
});