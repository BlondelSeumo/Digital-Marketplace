<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (authUser() && authUser()->isAdmin()) {
            if (!$request->ajax()) {
                toastr()->error(translate('This action is not available for admins'));
                if ($request->headers->has('referer')) {
                    return back();
                }
                return redirect()->route('home');
            } else {
                return response()->json(['error' => translate('This action is not available for admins')]);
            }
        }

        return $next($request);
    }
}
