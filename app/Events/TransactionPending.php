<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class TransactionPending
{
    use SerializesModels;

    public $transaction;

    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }
}
