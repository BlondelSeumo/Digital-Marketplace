<?php

namespace App\Jobs;

use App\Classes\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendRefundAcceptedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $refund;

    public function __construct($refund)
    {
        $this->refund = $refund;
    }

    public function handle()
    {
        $refund = $this->refund;
        $user = $refund->user;
        $purchase = $refund->purchase;

        SendMail::send($user->email, 'refund_request_accepted', [
            'username' => $user->username,
            'refund_id' => $refund->id,
            'refund_item_name' => $purchase->item->name,
            'refund_amount' => getAmount($purchase->sale->price),
            'refund_link' => route('user.refunds.show', $refund->id),
            'website_name' => @settings('general')->site_name,
        ]);
    }
}