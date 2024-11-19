<?php

namespace App\Console\Commands;

use App\Models\Item;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RefreshTrendingItems extends Command
{
    protected $signature = 'app:refresh-trending-items';

    protected $description = 'This command is to refresh trending items';

    public function handle()
    {
        $trendingItems = Item::trending()->get();
        foreach ($trendingItems as $trendingItem) {
            $trendingItem->is_trending = Item::NOT_TRENDING;
            $trendingItem->save();
        }

        $items = Item::where('current_month_views', '>', 0)
            ->orderBy('current_month_views', 'desc')
            ->take(@settings('item')->trending_number)
            ->get();

        if ($items->count() < @settings('item')->trending_number) {
            $items = Item::where('total_views', '>', 0)
                ->orderBy('total_views', 'desc')
                ->take(@settings('item')->trending_number)
                ->get();
        }

        foreach ($items as $item) {
            $item->is_trending = Item::TRENDING;
            $item->save();
        }

        Artisan::call('optimize:clear');

        $this->info('Trending items has been refreshed successfully');
    }
}