<?php
use Illuminate\Support\Facades\Route;
Route::prefix('')->group(function () {
    $routeName = "test";
    $controller = "home";
    $controllerName =  ucfirst($controller) . "Controller";
    #_ /ambassador
    Route::get('/', "{$controllerName}@index")->name($routeName . '/index');
    #_ /ambassador/mortgage
});