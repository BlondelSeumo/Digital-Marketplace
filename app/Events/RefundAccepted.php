<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class RefundAccepted
{
    use SerializesModels;

    public $refund;

    public function __construct($refund)
    {
        $this->refund = $refund;
    }
}
