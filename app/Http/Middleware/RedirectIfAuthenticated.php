<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $response = $next($request);

        $user = authUser();
        if ($user) {
            $firstSegment = $request->segment(1);

            if ($user->isAdmin() && $firstSegment !== 'admin') {
                return redirect()->route('admin.index');
            } elseif ($user->isUser()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $response;
    }
}
