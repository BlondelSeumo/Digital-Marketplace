<?php

namespace App\Console\Commands\Subscriptions;

use App\Jobs\SendSubscriptionExpiredNotification;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SubscriptionExpiredNotify extends Command
{
    protected $signature = 'app:subscription-expired-notify';

    protected $description = 'Send an email to the user after subscription expired';

    public function handle()
    {
        $subscriptions = Subscription::expired()->get();
        foreach ($subscriptions as $subscription) {
            if (!$subscription->last_notification_at ||
                Carbon::parse($subscription->last_notification_at)->lt(Carbon::now()->subDays(Subscription::EXPIRING_DAYS))) {
                dispatch(new SendSubscriptionExpiredNotification($subscription));

                $subscription->last_notification_at = Carbon::now();
                $subscription->save();
            }
        }

        $this->info('Expired subscription notification sent successfully');
    }
}