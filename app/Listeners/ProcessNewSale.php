<?php

namespace App\Listeners;

use App\Events\SaleCreated;
use App\Handlers\SupportHandler;
use App\Jobs\SendPurchaseConfirmationNotification;
use App\Models\Purchase;
use App\Models\Statement;
use Str;

class ProcessNewSale
{
    public function handle(SaleCreated $event)
    {
        $sale = $event->sale;
        $trx = $event->transaction;
        $support = $event->support;

        $user = $sale->user;
        $item = $sale->item;

        $purchase = new Purchase();
        $purchase->user_id = $user->id;
        $purchase->sale_id = $sale->id;
        $purchase->item_id = $item->id;
        $purchase->license_type = $sale->license_type;
        $purchase->code = Str::uuid()->toString();
        $purchase->save();

        $statement1 = new Statement();
        $statement1->user_id = $user->id;
        $statement1->title = translate('[Purchase] #:purchase_id (:item_name)', [
            'purchase_id' => $purchase->id,
            'item_name' => $item->name,
        ]);
        $statement1->amount = $sale->price;
        $statement1->type = Statement::TYPE_DEBIT;
        $statement1->save();

        $tax = $sale->tax;
        if ($tax) {
            $amount = ($sale->price * $tax->rate) / 100;
            $statement2 = new Statement();
            $statement2->user_id = $user->id;
            $statement2->title = translate('[:tax_name (:tax_rate%)] Purchase #:purchase_id (:item_name)', [
                'purchase_id' => $purchase->id,
                'item_name' => $item->name,
                'tax_name' => $tax->name,
                'tax_rate' => $tax->rate,
            ]);
            $statement2->amount = $amount;
            $statement2->type = Statement::TYPE_DEBIT;
            $statement2->save();
        }

        app(SupportHandler::class)->create($purchase, $trx, $support);

        $item->increment('total_sales');
        $item->increment('total_sales_amount', $sale->price);

        dispatch(new SendPurchaseConfirmationNotification($purchase));
    }
}