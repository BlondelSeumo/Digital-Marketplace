<?php

namespace App\Listeners;

use App\Events\TransactionPending;
use App\Jobs\Admin\SendAdminTrxPendingNotification;
use App\Models\User;

class ProcessPendingTransaction
{
    public function handle(TransactionPending $event)
    {
        $transaction = $event->transaction;

        if ($transaction->isPending()) {
            $admins = User::admin()->get();
            foreach ($admins as $admin) {
                dispatch(new SendAdminTrxPendingNotification($admin, $transaction));
            }

            $title = translate('New Pending Transaction [#:transaction_id]', ['transaction_id' => $transaction->id]);
            $image = asset('images/notifications/transaction.png');
            $link = route('admin.transactions.review', $transaction->id);
            adminNotify($title, $image, $link);
        }
    }
}