<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DemoMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $method = null)
    {
        if (demoMode()) {
            $error = 'Some features are disabled in the demo version';
            if ($method) {
                if ($request->isMethod($method)) {
                    toastr()->error($error);
                    return back();
                }
            } else {
                if ($request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('DELETE')) {
                    if (!$request->ajax()) {
                        toastr()->error($error);
                        return back();
                    } else {
                        return response()->json(['error' => $error]);
                    }
                }
            }
        }

        return $next($request);
    }
}
