<?php

namespace App\Http\Middleware;

use App\Models\CartItem;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CartMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cartItems = CartItem::forCurrentSession()
            ->whereHas('item', function ($query) {
                $query->disabled();
            })->get();

        if ($cartItems->count() > 0) {
            $cartItems->each->delete();
        }

        $cartItems = CartItem::forCurrentSession()
            ->where('license_type', CartItem::LICENSE_TYPE_EXTENDED)
            ->whereHas('item', function ($query) {
                $query->hasNoExtendedLicense();
            })->get();

        if ($cartItems->count() > 0) {
            $cartItems->each->delete();
        }

        return $next($request);
    }
}
