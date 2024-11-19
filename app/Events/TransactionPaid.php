<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class TransactionPaid
{
    use SerializesModels;

    public $transaction;

    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }
}
