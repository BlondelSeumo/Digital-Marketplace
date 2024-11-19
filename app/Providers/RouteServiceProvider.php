<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Str;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "controllers".
     *
     * This is used by Laravel routes to make the old routes working.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';
    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->removeIndexFromUrl();
        $this->configureRateLimiting();

        Route::bind('user', function ($value) {
            return User::where('id', $value)->user()->firstOrFail();
        });

        Route::bind('admin', function ($value) {
            return User::where('id', $value)
                ->whereNot('id', authUser()->id)
                ->admin()->firstOrFail();
        });

        $this->routes(function () {
            Route::group(['namespace' => $this->namespace], function () {
                Route::middleware(['web', 'notInstalled'])
                    ->namespace('Admin')
                    ->prefix(adminPath())
                    ->group(base_path('routes/admin.php'));
                Route::middleware(['web', 'notInstalled'])
                    ->group(base_path('routes/payments.php'));
                Route::middleware(['web', 'notInstalled'])
                    ->group(base_path('routes/web.php'));
                Route::prefix('api')
                    ->middleware('api')
                    ->group(base_path('routes/api.php'));
            });
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }

    /**
     * Remove index.php from URL
     *
     * @return response()
     */
    protected function removeIndexFromUrl()
    {
        if (Str::contains(request()->getRequestUri(), '/index.php/')) {
            $url = str_replace('index.php/', '', request()->getRequestUri());
            if (strlen($url) > 0) {
                header("Location: $url", true, 301);
                exit;
            }
        }
    }
}
