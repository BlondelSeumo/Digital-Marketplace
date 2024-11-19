<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class SaleRefunded
{
    use SerializesModels;

    public $sale;

    public function __construct($sale)
    {
        $this->sale = $sale;
    }
}
