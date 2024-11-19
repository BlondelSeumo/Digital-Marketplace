<?php

namespace Vironeer\Installer;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Vironeer\Installer\App\Http\Middleware\InstalledMiddleware;
use Vironeer\Installer\App\Http\Middleware\NotInstalledMiddleware;

class InstallerServiceProvider extends ServiceProvider
{
    protected $namespace = 'Vironeer\Installer\App\Http\Controllers';

    public function boot()
    {
        $this->registerHelper();

        $router = $this->app->make(Router::class);

        $router->aliasMiddleware('installed', InstalledMiddleware::class);

        $router->aliasMiddleware('notInstalled', NotInstalledMiddleware::class);

        Route::group(['namespace' => $this->namespace], function () {
            $this->loadRoutesFrom(__DIR__ . '/Routes.php');
        });

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'installer');
    }

    public function registerHelper()
    {
        if (file_exists($file = __DIR__ . '/Helper.php')) {
            require $file;
        }
    }
}