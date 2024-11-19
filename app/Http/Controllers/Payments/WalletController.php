<?php

namespace App\Http\Controllers\Payments;

use App\Events\TransactionPaid;
use App\Http\Controllers\Controller;
use App\Models\Transaction;

class WalletController extends Controller
{
    public function process($trx)
    {
        try {
            $user = $trx->user;

            if ($user->balance < $trx->total) {
                $data['type'] = "error";
                $data['msg'] = translate('Your wallet balance is insufficient');
                return json_encode($data);
            }

            $user->decrement('balance', $trx->total);

            $trx->status = Transaction::STATUS_PAID;
            $trx->update();

            $user->emptyCart();
            event(new TransactionPaid($trx));

        } catch (\Exception $e) {
            $data['type'] = "error";
            $data['msg'] = $e->getMessage();
            return json_encode($data);
        }
    }
}