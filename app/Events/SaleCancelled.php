<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class SaleCancelled
{
    use SerializesModels;

    public $sale;

    public function __construct($sale)
    {
        $this->sale = $sale;
    }
}
