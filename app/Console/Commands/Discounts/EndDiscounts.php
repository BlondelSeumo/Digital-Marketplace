<?php

namespace App\Console\Commands\Discounts;

use App\Models\Item;
use App\Models\ItemDiscount;
use Illuminate\Console\Command;

class EndDiscounts extends Command
{
    protected $signature = 'app:discounts-end';

    protected $description = 'End expired discounts';

    public function handle()
    {
        $discounts = ItemDiscount::ended()->active()->get();

        foreach ($discounts as $discount) {
            $item = $discount->item;
            $item->is_on_discount = Item::DISCOUNT_OFF;
            $item->update();

            $discount->delete();
        }

        $this->info('The expired discounts has been ended');
    }
}
