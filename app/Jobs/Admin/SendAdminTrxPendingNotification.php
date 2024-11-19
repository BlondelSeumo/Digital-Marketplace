<?php

namespace App\Jobs\Admin;

use App\Classes\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAdminTrxPendingNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $admin;
    public $transaction;

    public function __construct($admin, $transaction)
    {
        $this->admin = $admin;
        $this->transaction = $transaction;
    }

    public function handle()
    {
        $admin = $this->admin;
        $transaction = $this->transaction;

        SendMail::send($admin->email, 'admin_transaction_pending', [
            'username' => $transaction->user->username,
            'transaction_id' => $transaction->id,
            'transaction_subtotal' => getAmount($transaction->amount),
            'payment_method' => $transaction->paymentGateway->name,
            'transaction_fees' => getAmount($transaction->fees),
            'transaction_total' => getAmount($transaction->total),
            'transaction_date' => dateFormat($transaction->created_at),
            'review_link' => route('admin.transactions.review', $transaction->id),
            'website_name' => @settings('general')->site_name,
        ]);
    }
}