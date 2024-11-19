<?php

namespace App\Listeners;

use App\Events\SaleCreated;
use App\Events\TransactionPaid;
use App\Handlers\SupportHandler;
use App\Http\Controllers\PremiumController;
use App\Jobs\SendPaymentConfirmationNotification;
use App\Models\PremiumEarning;
use App\Models\Sale;
use App\Models\Statement;
use Illuminate\Support\Str;

class ProcessPaidTransaction
{
    public function handle(TransactionPaid $event)
    {
        $trx = $event->transaction;

        try {
            if ($trx->isPaid()) {
                dispatch(new SendPaymentConfirmationNotification($trx));
                $method = 'handle' . Str::studly($trx->type) . 'Transaction';
                $this->{$method}($trx);
            }
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }
    }

    private function handlePurchaseTransaction($trx)
    {
        $trxItems = $trx->trxItems;
        $user = $trx->user;
        $user_country = @$user->address->country;

        foreach ($trxItems as $trxItem) {
            $item = $trxItem->item;
            for ($i = 0; $i < $trxItem->quantity; $i++) {
                $taxAmount = $trx->hasTax() ? ($trxItem->price * $trx->tax->rate) / 100 : 0;

                $sale = new Sale();
                $sale->user_id = $user->id;
                $sale->item_id = $item->id;
                $sale->license_type = $trxItem->license_type;
                $sale->price = $trxItem->price;
                if ($trx->hasTax()) {
                    $sale->tax = [
                        'name' => $trx->tax->name,
                        'rate' => $trx->tax->rate,
                        'amount' => round($taxAmount, 2),
                    ];
                }
                $sale->total = ($trxItem->price + $taxAmount);
                $sale->country = $user_country ?? null;
                $sale->save();

                event(new SaleCreated($sale, $trx, $trxItem->support));
            }
        }
    }

    private function handleSupportPurchaseTransaction($trx)
    {
        app(SupportHandler::class)->create($trx->purchase, $trx, $trx->support);
    }

    private function handleSupportExtendTransaction($trx)
    {
        app(SupportHandler::class)->create($trx->purchase, $trx, $trx->support);
    }

    private function handleDepositTransaction($trx)
    {
        $user = $trx->user;

        $user->increment('balance', $trx->amount);

        $statement1 = new Statement();
        $statement1->user_id = $user->id;
        $statement1->title = translate('[Deposit] Deposit to Wallet #:transaction_id', [
            'transaction_id' => $trx->id,
        ]);
        $statement1->amount = $trx->amount;
        $statement1->type = Statement::TYPE_CREDIT;
        $statement1->save();
    }

    private function handleSubscriptionTransaction($trx)
    {
        $user = $trx->user;
        $plan = $trx->plan;

        $subscription = PremiumController::handleSubscription($user, $plan);

        if ($subscription) {
            $plan = $trx->plan;
            $taxAmount = $trx->hasTax() ? ($trx->amount * $trx->tax->rate) / 100 : 0;

            $premiumEarning = new PremiumEarning();
            $premiumEarning->name = translate(':plan_name (:plan_interval)', [
                'plan_name' => $plan->name,
                'plan_interval' => $plan->getIntervalName(),
            ]);
            $premiumEarning->price = $trx->amount;
            if ($trx->hasTax()) {
                $premiumEarning->tax = [
                    'name' => $trx->tax->name,
                    'rate' => $trx->tax->rate,
                    'amount' => round($taxAmount, 2),
                ];
            }
            $premiumEarning->total = ($trx->amount + $taxAmount);
            $premiumEarning->subscription_id = $subscription->id;
            $premiumEarning->save();

            $statement1 = new Statement();
            $statement1->user_id = $user->id;
            $statement1->title = translate('[Subscription] #:subscription_id - :plan_name (:plan_interval)', [
                'subscription_id' => $subscription->id,
                'plan_name' => $plan->name,
                'plan_interval' => $plan->getIntervalName(),
            ]);
            $statement1->amount = $trx->amount;
            $statement1->type = Statement::TYPE_DEBIT;
            $statement1->save();

            if ($trx->tax) {
                $tax = $trx->tax;
                $statement2 = new Statement();
                $statement2->user_id = $user->id;
                $statement2->title = translate('[:tax_name (:tax_rate%)] Subscription #:subscription_id - :plan_name (:plan_interval)', [
                    'subscription_id' => $subscription->id,
                    'plan_name' => $plan->name,
                    'plan_interval' => $plan->getIntervalName(),
                    'tax_name' => $tax->name,
                    'tax_rate' => $tax->rate,
                ]);
                $statement2->amount = $tax->amount;
                $statement2->type = Statement::TYPE_DEBIT;
                $statement2->save();
            }
        }
    }
}