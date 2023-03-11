<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Modules\Authen\Http\Middleware\AccessAgentDashboard;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \App\Http\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'check.login' => \Modules\Authen\Http\Middleware\CheckLogin::class,
        'check.login_admin' => \Modules\Authen\Http\Middleware\CheckLoginAdmin::class,
        'check.login_agent' => \Modules\Authen\Http\Middleware\CheckLoginAgent::class,
        'check.login_staff' => \Modules\Authen\Http\Middleware\CheckStaffAgent::class,
        'access.adminDashboard' => \App\Http\Middleware\AccessAdminDashboard::class,
        'access.userDashboard' => \Modules\Authen\Http\Middleware\AccessUserDashboard::class,
        'access.licenseAgentDashboard' => \App\Http\Middleware\AccessLicenceAgentDashboard::class,
        'access.nonLicenseAgentDashboard' => \App\Http\Middleware\AccessNonLicenceAgentDashboard::class,
        'access.staffDashboard' => \App\Http\Middleware\AccessStaffDashboard::class,
        'access.licenseDashboard' => \App\Http\Middleware\AccessLicenseDashboard::class,
        // 'access.staffDashboard' => \Modules\Authen\Http\Middleware\AccessStaffDashboard::class,
    ];
}
