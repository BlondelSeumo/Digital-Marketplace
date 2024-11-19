<?php

namespace App\Listeners;

use App\Events\RefundAccepted;
use App\Events\SaleRefunded;
use App\Jobs\SendRefundAcceptedNotification;

class ProcessAcceptedRefund
{
    public function handle(RefundAccepted $event)
    {
        $refund = $event->refund;

        event(new SaleRefunded($refund->purchase->sale));

        dispatch(new SendRefundAcceptedNotification($refund));
    }
}
