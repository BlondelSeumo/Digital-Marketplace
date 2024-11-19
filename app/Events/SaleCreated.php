<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class SaleCreated
{
    use SerializesModels;

    public $sale;
    public $transaction;
    public $support;

    public function __construct($sale, $transaction, $support)
    {
        $this->sale = $sale;
        $this->transaction = $transaction;
        $this->support = $support;
    }
}