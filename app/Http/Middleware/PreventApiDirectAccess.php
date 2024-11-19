<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventApiDirectAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $browsers = ['Opera', 'Mozilla', 'Firefox', 'Chrome', 'Edge'];
        $userAgent = request()->header('User-Agent');

        $isBrowser = false;
        foreach ($browsers as $browser) {
            if (strpos($userAgent, $browser) !== false) {
                $isBrowser = true;
                break;
            }
        }

        if ($isBrowser == true) {
            return redirect(env('APP_URL'));
        };

        return $next($request);
    }
}
