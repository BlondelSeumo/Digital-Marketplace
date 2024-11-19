<?php

namespace App\Http\Middleware\Actions;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FreeItemsRequireLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (@settings('item')->free_items_require_login && !authUser()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}