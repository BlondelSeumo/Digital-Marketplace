<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SmtpMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!@settings('smtp')->status) {
            die(translate('SMTP is not enabled, please enable the smtp from settings'));
        }
        return $next($request);
    }
}
