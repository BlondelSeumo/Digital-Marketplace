<?php

namespace App\Jobs;

use App\Classes\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendRefundDeclinedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $refund;

    public $refundReply;

    public function __construct($refund, $refundReply)
    {
        $this->refund = $refund;
        $this->refundReply = $refundReply;
    }

    public function handle()
    {
        $refund = $this->refund;
        $user = $refund->user;

        SendMail::send($user->email, 'refund_request_declined', [
            'username' => $user->username,
            'refund_id' => $refund->id,
            'refund_item_name' => $refund->purchase->item->name,
            'refund_decline_reason' => $this->refundReply->body,
            'refund_link' => route('user.refunds.show', $refund->id),
            'website_name' => @settings('general')->site_name,
        ]);
    }
}