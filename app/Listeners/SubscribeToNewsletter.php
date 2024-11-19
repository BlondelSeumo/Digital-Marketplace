<?php

namespace App\Listeners;

use App\Classes\Newsletter;

class SubscribeToNewsletter
{
    public function handle($event)
    {
        $user = $event->user;
        $newsletter = settings('newsletter');
        if (@$newsletter->status && @$newsletter->register_new_users) {
            if (!Newsletter::isSubscribed($user->email)) {
                Newsletter::subscribe($user->email);
            }
        }
    }
}