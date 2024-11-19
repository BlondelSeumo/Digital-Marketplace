<?php

namespace App\Handlers;

use App\Models\Statement;
use App\Models\SupportEarning;
use Carbon\Carbon;

class SupportHandler
{
    public function create($purchase, $trx, $support = null)
    {
        if (@settings('item')->support_status && $support) {

            $item = $purchase->item;
            $user = $purchase->user;
            $supportPrice = $support->price;

            $expiryDate = Carbon::now()->addDays($support->days);

            if ($supportPrice > 0) {
                $taxAmount = $trx->hasTax() ? ($supportPrice * $trx->tax->rate) / 100 : 0;

                $supportEarning = new SupportEarning();
                $supportEarning->name = $support->name;
                $supportEarning->title = $support->title;
                $supportEarning->days = $support->days;
                $supportEarning->price = $supportPrice;
                if ($trx->hasTax()) {
                    $supportEarning->tax = [
                        'name' => $trx->tax->name,
                        'rate' => $trx->tax->rate,
                        'amount' => round($taxAmount, 2),
                    ];
                }
                $supportEarning->total = ($supportPrice + $taxAmount);
                $supportEarning->support_expiry_at = $expiryDate;
                $supportEarning->purchase_id = $purchase->id;
                $supportEarning->save();

                $this->createBuyerNewSupportStatements($user, $trx, $item, $supportEarning);
            }

            if ($purchase->support_expiry_at) {
                if ($purchase->isSupportExpired()) {
                    $purchase->support_expiry_at = $expiryDate;
                }
            } else {
                $purchase->support_expiry_at = $expiryDate;
            }

            $purchase->update();
        }
    }

    public function refund($purchase)
    {
        if ($purchase->support_expiry_at && !$purchase->isSupportExpired()) {

            $supportEarning = $purchase->supportEarnings->where('support_expiry_at', $purchase->support_expiry_at)->first();

            if ($supportEarning) {
                $user = $purchase->user;
                $user->increment('balance', $supportEarning->price);

                $item = $purchase->item;

                $statement3 = new Statement();
                $statement3->user_id = $user->id;
                $statement3->title = translate('[Refund] Support #:support_earning_id (:item_name)', [
                    'support_earning_id' => $supportEarning->id,
                    'item_name' => $item->name,
                ]);
                $statement3->amount = $supportEarning->price;
                $statement3->type = Statement::TYPE_CREDIT;
                $statement3->save();

                if ($supportEarning->tax) {
                    $user->increment('balance', $supportEarning->tax->amount);

                    $statement4 = new Statement();
                    $statement4->user_id = $user->id;
                    $statement4->title = translate('[Refund] :tax_name (:tax_rate%) Support #:support_earning_id (:item_name)', [
                        'support_earning_id' => $supportEarning->id,
                        'item_name' => $item->name,
                        'tax_name' => $supportEarning->tax->name,
                        'tax_rate' => $supportEarning->tax->rate,
                    ]);
                    $statement4->amount = $supportEarning->tax->amount;
                    $statement4->type = Statement::TYPE_CREDIT;
                    $statement4->save();
                }

                $supportEarning->status = SupportEarning::STATUS_REFUNDED;
                $supportEarning->update();
            }
        }
    }

    public function cancel($purchase)
    {
        if ($purchase->support_expiry_at && !$purchase->isSupportExpired()) {

            $supportEarning = $purchase->supportEarnings->where('support_expiry_at', $purchase->support_expiry_at)->first();

            if ($supportEarning) {
                $user = $purchase->user;
                $user->increment('balance', $supportEarning->price);

                $item = $purchase->item;

                $statement5 = new Statement();
                $statement5->user_id = $user->id;
                $statement5->title = translate('[Cancellation] Support #:support_earning_id (:item_name)', [
                    'support_earning_id' => $supportEarning->id,
                    'item_name' => $item->name,
                ]);
                $statement5->amount = $supportEarning->price;
                $statement5->type = Statement::TYPE_CREDIT;
                $statement5->save();

                if ($supportEarning->tax) {
                    $user->increment('balance', $supportEarning->tax->amount);

                    $statement6 = new Statement();
                    $statement6->user_id = $user->id;
                    $statement6->title = translate('[Cancellation] :tax_name (:tax_rate%) Support #:support_earning_id (:item_name)', [
                        'support_earning_id' => $supportEarning->id,
                        'item_name' => $item->name,
                        'tax_name' => $supportEarning->tax->name,
                        'tax_rate' => $supportEarning->tax->rate,
                    ]);
                    $statement6->amount = $supportEarning->tax->amount;
                    $statement6->type = Statement::TYPE_CREDIT;
                    $statement6->save();
                }

                $supportEarning->status = SupportEarning::STATUS_REFUNDED;
                $supportEarning->update();
            }
        }
    }

    private function createBuyerNewSupportStatements($user, $trx, $item, $supportEarning)
    {
        $type = translate('Support Purchase');
        if ($trx->isTypeSupportExtend()) {
            $type = translate('Support Extend');
        }

        $statement1 = new Statement();
        $statement1->user_id = $user->id;
        $statement1->title = translate('[:type] #:support_earning_id (:item_name)', [
            'type' => $type,
            'support_earning_id' => $supportEarning->id,
            'item_name' => $item->name,
        ]);
        $statement1->amount = $supportEarning->price;
        $statement1->type = Statement::TYPE_DEBIT;
        $statement1->save();

        if ($supportEarning->tax) {
            $statement2 = new Statement();
            $statement2->user_id = $user->id;
            $statement2->title = translate('[:tax_name (:tax_rate%)] :type #:support_earning_id (:item_name)', [
                'support_earning_id' => $supportEarning->id,
                'item_name' => $item->name,
                'tax_name' => $supportEarning->tax->name,
                'tax_rate' => $supportEarning->tax->rate,
                'type' => $type,
            ]);
            $statement2->amount = $supportEarning->tax->amount;
            $statement2->type = Statement::TYPE_DEBIT;
            $statement2->save();
        }
    }
}