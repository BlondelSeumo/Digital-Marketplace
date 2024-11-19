<?php

namespace App\Jobs;

use App\Classes\SendMail;
use App\Models\Purchase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendBuyersItemUpdateNotification implements ShouldQueue
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
        $purchases = Purchase::where('item_id', $item->id)->active()->get();

        $sentUsers = [];
        foreach ($purchases as $purchase) {
            $user = $purchase->user;

            if (in_array($user->email, $sentUsers)) {
                continue;
            }

            $image = $item->preview_image
            ? '<img src="' . $item->getImageLink() . '" width="100%"/>'
            : '<img src="' . $item->getImageLink() . '"/>';

            SendMail::send($user->email, 'buyer_item_update', [
                'username' => $user->username,
                'item_name' => $item->name,
                'item_preview_image' => $image,
                'item_link' => $item->getLink(),
                'website_name' => @settings('general')->site_name,
            ]);

            $sentUsers[] = $user->email;
        }
    }
}