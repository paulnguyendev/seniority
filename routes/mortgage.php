<?php
use Illuminate\Support\Facades\Route;
$prefix = config('prefix.portal_license');
Route::prefix('')->middleware('access.licenseDashboard')->group(function () use($prefix) {
    #_ /mortgage
    $controller = "home";
    $controllerName =  ucfirst($controller) . "Controller";
    Route::get('/', "{$controllerName}@index")->name($prefix . '/index');
    #_ /mortgage/downline
    Route::prefix('downline')->group(function() use($prefix) {
        $controller = "downline";
        $controllerName =  ucfirst($controller) . "Controller";
        Route::get('/', "{$controllerName}@index")->name($prefix . '/downline');
        Route::get('/ambassadors/{slug?}', "{$controllerName}@ambassador")->name($prefix . '/downlineAmbassadors');
        Route::get('/loans/{slug?}', "{$controllerName}@loans")->name($prefix . '/downlineLoans');
    });
    Route::prefix('loans')->group(function() use($prefix) {
        $controller = "loans";
        $controllerName =  ucfirst($controller) . "Controller";
        Route::get('/', "{$controllerName}@index")->name($prefix . '/loans');
       
    });
    
});
Route::prefix('')->group(function () use($prefix) {
    
    $controller = "auth";
    $controllerName =  ucfirst($controller) . "Controller";
    #_ /ambassador
    Route::get('/login', "{$controllerName}@login")->name($prefix . '/login');
    Route::get('/logout', "{$controllerName}@logout")->name($prefix . '/logout');
    Route::get('/register', "{$controllerName}@register")->name($prefix . '/register');
    Route::post('/postLogin', "{$controllerName}@postLogin")->name($prefix . '/postLogin');
    Route::post('/postRegister', "{$controllerName}@postRegister")->name($prefix . '/postRegister');
    Route::post('/postActive', "{$controllerName}@postActive")->name($prefix . '/postActive');
    Route::post('/agentCheckParent', "{$controllerName}@agentCheckParent")->name($prefix . '/agentCheckParent');
    Route::get('/active', "{$controllerName}@active")->name($prefix . '/active');
    Route::get('/quick-login/{token}', "{$controllerName}@quickLogin")->name($prefix . '/quickLogin');
    #_ /ambassador/mortgage
});
