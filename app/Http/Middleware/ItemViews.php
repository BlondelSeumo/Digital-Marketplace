<?php

namespace App\Http\Middleware;

use App\Models\Item;
use App\Models\ItemView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ItemViews
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $itemId = $request->route('id');
        $item = Item::where('id', $itemId)->first();

        if ($item) {
            $ip = getIp();
            $referrer = $request->server('HTTP_REFERER');
            $referrerHost = parse_url($referrer, PHP_URL_HOST);
            $websiteUrl = parse_url(url('/'), PHP_URL_HOST);

            if ($referrerHost == $websiteUrl) {
                $referrer = '/';
            }

            $lastView = ItemView::where('item_id', $itemId)
                ->where('ip', $ip)
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$lastView || now()->diffInHours($lastView->created_at) >= 24) {
                $view = new ItemView();
                $view->item_id = $itemId;
                $view->ip = $ip;
                $view->referrer = $referrer;
                $view->save();

                $item->increment('total_views');
                $item->increment('current_month_views');
            }
        }

        return $next($request);
    }
}