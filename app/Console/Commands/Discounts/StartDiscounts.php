<?php

namespace App\Console\Commands\Discounts;

use App\Models\Item;
use App\Models\ItemDiscount;
use Illuminate\Console\Command;

class StartDiscounts extends Command
{
    protected $signature = 'app:discounts-start';

    protected $description = 'Start Inactive discounts';

    public function handle()
    {
        $discounts = ItemDiscount::started()->inactive()->get();

        foreach ($discounts as $discount) {
            $item = $discount->item;
            $item->is_on_discount = Item::DISCOUNT_ON;
            $item->update();

            $discount->status = ItemDiscount::STATUS_ACTIVE;
            $discount->update();
        }

        $this->info('The discounts has been started');
    }
}
