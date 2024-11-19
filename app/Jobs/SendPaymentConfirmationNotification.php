<?php

namespace App\Jobs;

use App\Classes\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPaymentConfirmationNotification implements ShouldQueue
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

        SendMail::send($transaction->user->email, 'payment_confirmation', [
            'username' => $transaction->user->username,
            'transaction_id' => $transaction->id,
            'transaction_subtotal' => getAmount($transaction->amount),
            'payment_method' => $transaction->paymentGateway->name,
            'transaction_fees' => getAmount($transaction->fees),
            'transaction_total' => getAmount($transaction->total),
            'transaction_date' => dateFormat($transaction->created_at),
            'transaction_view_link' => route('user.transactions.show', $transaction->id),
            'website_name' => @settings('general')->site_name,
        ]);
    }
}
