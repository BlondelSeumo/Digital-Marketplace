<?php

namespace App\Console\Commands;

use App\Models\Item;
use Illuminate\Console\Command;

class ResetItemMonthlyViews extends Command
{
    protected $signature = 'app:reset-item-monthly-views';

    protected $description = 'This command is to reset item monthly views';

    public function handle()
    {
        $items = Item::where('current_month_views', '>', 0)->get();

        foreach ($items as $item) {
            $item->current_month_views = 0;
            $item->update();
        }

        $this->info('Monthly views have been reset for all items.');
    }
}