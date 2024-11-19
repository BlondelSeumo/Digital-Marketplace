<?php

namespace App\Jobs;

use App\Classes\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPurchaseConfirmationNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $purchase;

    public function __construct($purchase)
    {
        $this->purchase = $purchase;
    }

    public function handle()
    {
        $purchase = $this->purchase;
        $user = $purchase->user;
        $item = $purchase->item;

        $image = $item->preview_image
        ? '<img src="' . $item->getImageLink() . '" width="100%"/>'
        : '<img src="' . $item->getImageLink() . '"/>';

        SendMail::send($user->email, 'purchase_confirmation', [
            'username' => $user->username,
            'item_name' => $item->name,
            'item_preview_image' => $image,
            'item_link' => $item->getLink(),
            'purchase_code' => $purchase->code,
            'download_link' => route('user.purchases.index'),
            'website_name' => @settings('general')->site_name,
        ]);
    }
}