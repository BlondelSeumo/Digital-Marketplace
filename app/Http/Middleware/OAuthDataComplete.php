<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OAuthDataComplete
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
        if (authUser() && authUser()->isUser() && !authUser()->isDataCompleted()) {
            return redirect()->route('oauth.data.complete');
        }

        return $next($request);
    }
}