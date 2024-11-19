<?php

namespace Vironeer\Installer\App\Http\Middleware;

use Closure;

class InstalledMiddleware
{
    public function handle($request, Closure $next)
    {
        if (config('system.install.complete')) {
            return redirect('/');
        }
        return $next($request);
    }
}
