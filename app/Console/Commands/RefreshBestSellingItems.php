<?php

namespace App\Console\Commands;

use App\Models\Item;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RefreshBestSellingItems extends Command
{
    protected $signature = 'app:refresh-best-selling-items';

    protected $description = 'This command is to refresh best selling items';

    public function handle()
    {
        $bestSellingItems = Item::bestSelling()->get();
        foreach ($bestSellingItems as $bestSellingItem) {
            $bestSellingItem->is_best_selling = Item::NOT_BEST_SELLING;
            $bestSellingItem->save();
        }

        $items = Item::where('total_sales', '>', 0)
            ->orderBy('total_sales', 'desc')
            ->take(@settings('item')->best_selling_number)
            ->get();

        foreach ($items as $item) {
            $item->is_best_selling = Item::BEST_SELLING;
            $item->save();
        }

        Artisan::call('optimize:clear');

        $this->info('Best selling items has been refreshed successfully');
    }
}