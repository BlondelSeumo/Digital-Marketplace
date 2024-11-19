<?php

namespace App\Jobs;

use App\Classes\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSubscriptionExpiredNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $subscription;

    public function __construct($subscription)
    {
        $this->subscription = $subscription;
    }

    public function handle(): void
    {
        $subscription = $this->subscription;
        $user = $subscription->user;

        SendMail::send($user->email, 'subscription_expired', [
            'username' => $user->username,
            'expiry_date' => dateFormat($subscription->expiry_at),
            'renewing_link' => route('user.settings.index'),
            'website_name' => @settings('general')->site_name,
        ]);
    }
}
