<?php

namespace App\Console\Commands\Subscriptions;

use App\Jobs\SendSubscriptionAboutToExpireNotification;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SubscriptionAboutToExpireNotify extends Command
{
    protected $signature = 'app:subscription-about-to-expire-notify';

    protected $description = 'Send an email to the user before subscription expire';

    public function handle()
    {
        $subscriptions = Subscription::aboutToExpire()->get();
        foreach ($subscriptions as $subscription) {
            if (!$subscription->last_notification_at ||
                Carbon::parse($subscription->last_notification_at)->lt(Carbon::now()->subDays(Subscription::RENEWING_DAYS))) {
                dispatch(new SendSubscriptionAboutToExpireNotification($subscription));

                $subscription->last_notification_at = Carbon::now();
                $subscription->save();
            }
        }

        $this->info('Subscription about to expire notification sent successfully');
    }
}