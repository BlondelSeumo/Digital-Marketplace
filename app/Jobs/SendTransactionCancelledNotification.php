<?php

namespace App\Jobs;

use App\Classes\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTransactionCancelledNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $transaction;

    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    public function handle()
    {
        $transaction = $this->transaction;
        $user = $transaction->user;

        SendMail::send($user->email, 'transaction_cancelled', [
            'username' => $user->username,
            'transaction_id' => $transaction->id,
            'transaction_subtotal' => getAmount($transaction->amount),
            'payment_method' => $transaction->paymentGateway->name,
            'transaction_fees' => getAmount($transaction->fees),
            'transaction_total' => getAmount($transaction->total),
            'transaction_date' => dateFormat($transaction->created_at),
            'transaction_view_link' => route('user.transactions.show', $transaction->id),
            'cancellation_reason' => $transaction->cancellation_reason,
            'website_name' => @settings('general')->site_name,
        ]);
    }
}
