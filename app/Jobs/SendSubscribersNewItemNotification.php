<?php

namespace App\Jobs;

use App\Classes\SendMail;
use App\Models\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSubscribersNewItemNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $item;

    public function __construct($item)
    {
        $this->item = $item;
    }

    public function handle()
    {
        $item = $this->item;

        $subscribers = NewsletterSubscriber::all();

        foreach ($subscribers as $subscriber) {

            $image = $item->preview_image
            ? '<img src="' . $item->getImageLink() . '" width="100%"/>'
            : '<img src="' . $item->getImageLink() . '"/>';

            SendMail::send($subscriber->email, 'subscriber_new_item', [
                'item_name' => $item->name,
                'item_preview_image' => $image,
                'item_link' => $item->getLink(),
                'website_name' => @settings('general')->site_name,
            ]);
        }
    }
}