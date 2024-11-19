<?php

namespace App\Jobs\Admin;

use App\Classes\SendMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAdminRefundNotification implements ShouldQueue
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

        $admins = User::admin()->get();
        foreach ($admins as $admin) {
            SendMail::send($admin->email, 'admin_refund_request', [
                'username' => $refund->user->username,
                'refund_id' => $refund->id,
                'refund_item_name' => $refund->purchase->item->name,
                'refund_reason' => $this->refundReply->body,
                'refund_link' => route('admin.refunds.show', $refund->id),
                'website_name' => @settings('general')->site_name,
            ]);
        }

        $title = translate('New Refund Request [#:refund_id]', ['refund_id' => $refund->id]);
        $image = asset('images/notifications/refund.png');
        $link = route('admin.refunds.show', $refund->id);
        adminNotify($title, $image, $link);
    }
}