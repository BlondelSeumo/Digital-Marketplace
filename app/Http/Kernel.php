<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,

    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\SwitchLanguageDirection::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \App\Http\Middleware\DisableApiDuringDemoMode::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\PreventApiDirectAccess::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'demo' => \App\Http\Middleware\DemoMode::class,
        'addon.active' => \App\Http\Middleware\IsAddonActive::class,
        'smtp' => \App\Http\Middleware\SmtpMiddleware::class,
        'admin' => \App\Http\Middleware\IsAdmin::class,
        'user' => \App\Http\Middleware\IsUser::class,
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'oauth.complete' => \App\Http\Middleware\OAuthDataComplete::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'license' => \App\Http\Middleware\LicenseMiddleware::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        'ajax.only' => \App\Http\Middleware\AjaxOnlyMiddleware::class,
        'registration.disable' => \App\Http\Middleware\Actions\RegistrationDisable::class,
        'blog.disable' => \App\Http\Middleware\Actions\BlogDisable::class,
        'api.disable' => \App\Http\Middleware\Actions\ApiDisable::class,
        'tickets.disable' => \App\Http\Middleware\Actions\TicketsDisable::class,
        'refunds.disable' => \App\Http\Middleware\Actions\RefundsDisable::class,
        'contact.disable' => \App\Http\Middleware\Actions\ContactDisable::class,
        'kyc.disable' => \App\Http\Middleware\Actions\KYCDisable::class,
        'kyc.required' => \App\Http\Middleware\KycRequired::class,
        'kyc.verified' => \App\Http\Middleware\KycVerified::class,
        'item_changelogs.disable' => \App\Http\Middleware\Actions\ItemChangeLogsDisable::class,
        'item_reviews.disable' => \App\Http\Middleware\Actions\ItemReviewsDisable::class,
        'item_comments.disable' => \App\Http\Middleware\Actions\ItemCommentsDisable::class,
        'item_support.disable' => \App\Http\Middleware\Actions\ItemSupportDisable::class,
        'free_items_login' => \App\Http\Middleware\Actions\FreeItemsRequireLogin::class,
        'buy_now.disable' => \App\Http\Middleware\Actions\BuyNowDisable::class,
        'deposit.disable' => \App\Http\Middleware\Actions\DepositDisable::class,
        'premium.disable' => \App\Http\Middleware\Actions\PremiumDisable::class,
        'user.status' => \App\Http\Middleware\UserStatusCheck::class,
        '2fa.verify' => \App\Http\Middleware\TwoFactorVerify::class,
        'item.views' => \App\Http\Middleware\ItemViews::class,
        'maintenance' => \App\Http\Middleware\MaintenanceMode::class,
        'trustip' => \App\Http\Middleware\Trustip::class,
        'cart' => \App\Http\Middleware\CartMiddleware::class,
    ];
}
