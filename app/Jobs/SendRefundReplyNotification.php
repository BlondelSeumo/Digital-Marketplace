<?php

namespace App\Jobs;

use App\Classes\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendRefundReplyNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $refundReply;

    public function __construct($refundReply)
    {
        $this->refundReply = $refundReply;
    }

    public function handle()
    {
        $refundReply = $this->refundReply;
        $refund = $refundReply->refund;
        $user = $refund->user;

        SendMail::send($user->email, 'refund_request_new_reply', [
            'username' => $user->username,
            'refund_id' => $refund->id,
            'refund_item_name' => $refund->purchase->item->name,
            'refund_reply' => $refundReply->body,
            'refund_link' => route('user.refunds.show', $refund->id),
            'website_name' => @settings('general')->site_name,
        ]);
    }
}