<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class SwitchLanguageDirection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (demoMode()) {
            $lang = 'en';
            $dir = 'ltr';

            if ($request->filled('dir')) {
                if ($request->dir == "rtl") {
                    $lang = 'ar';
                    $dir = 'rtl';
                    Cookie::queue('dir', $dir, 1440);
                } else {
                    Cookie::queue('dir', $dir, 1440);
                }
                return redirect($request->url());
            }

            if ($request->hasCookie('dir')) {
                if ($request->cookie('dir') == "rtl") {
                    $lang = 'ar';
                    $dir = 'rtl';
                }
            }

            Config::set('app.locale', $lang);
            Config::set('app.direction', $dir);
            Artisan::call('view:clear');
        }

        return $next($request);
    }
}
