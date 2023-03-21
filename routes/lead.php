<?php
use Illuminate\Support\Facades\Route;
$prefix = config('prefix.lead');
Route::prefix('')->group(function () use($prefix) {
    #_ /mortgage
    $controller = "index";
    $controllerName =  ucfirst($controller) . "Controller";
    Route::get('/', "{$controllerName}@index")->name($prefix . '/index');
    Route::post('/save', "{$controllerName}@save")->name($prefix . '/save');
    
    
});
