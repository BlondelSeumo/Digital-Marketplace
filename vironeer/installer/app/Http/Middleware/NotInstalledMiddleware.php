<?php

namespace Vironeer\Installer\App\Http\Middleware;

use Closure;

class NotInstalledMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!config('system.install.complete')) {
            return redirect()->route('installer.index');
        }
        return $next($request);
    }
}
