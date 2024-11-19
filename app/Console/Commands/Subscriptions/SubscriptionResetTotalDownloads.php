<?php

namespace App\Console\Commands\Subscriptions;

use App\Models\Subscription;
use Illuminate\Console\Command;

class SubscriptionResetTotalDownloads extends Command
{
    protected $signature = 'app:subscription-rest-total-downloads';

    protected $description = 'Reset subscription total downloads daily';

    public function handle()
    {
        $subscriptions = Subscription::all();

        foreach ($subscriptions as $subscription) {
            $subscription->total_downloads = 0;
            $subscription->update();
        }

        $this->info('Subscription total downloads has been reset.');
    }
}