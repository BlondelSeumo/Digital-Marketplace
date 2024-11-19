<?php

namespace App\Providers;

use App\Events\RefundAccepted;
use App\Events\Registered;
use App\Events\SaleCancelled;
use App\Events\SaleCreated;
use App\Events\SaleRefunded;
use App\Events\TransactionPaid;
use App\Events\TransactionPending;
use App\Listeners\ProcessAcceptedRefund;
use App\Listeners\ProcessCancelledSale;
use App\Listeners\ProcessNewSale;
use App\Listeners\ProcessPaidTransaction;
use App\Listeners\ProcessPendingTransaction;
use App\Listeners\ProcessRefundedSale;
use App\Listeners\SendEmailVerificationNotification;
use App\Listeners\SubscribeToNewsletter;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            SubscribeToNewsletter::class,
        ],
        TransactionPending::class => [
            ProcessPendingTransaction::class,
        ],
        TransactionPaid::class => [
            ProcessPaidTransaction::class,
        ],
        RefundAccepted::class => [
            ProcessAcceptedRefund::class,
        ],
        SaleCreated::class => [
            ProcessNewSale::class,
        ],
        SaleCancelled::class => [
            ProcessCancelledSale::class,
        ],
        SaleRefunded::class => [
            ProcessRefundedSale::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {

    }
}