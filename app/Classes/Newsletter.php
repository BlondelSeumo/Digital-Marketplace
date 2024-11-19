<?php

namespace App\Classes;

use App\Models\NewsletterSubscriber;

class Newsletter
{
    public static function subscribe($email)
    {
        $newsletterSubscriber = new NewsletterSubscriber();
        $newsletterSubscriber->email = $email;
        $newsletterSubscriber->save();
    }

    public static function isSubscribed($email)
    {
        return NewsletterSubscriber::where('email', $email)->exists();
    }
}