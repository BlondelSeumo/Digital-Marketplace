<?php

namespace App\Listeners;

use App\Events\SaleRefunded;
use App\Handlers\SupportHandler;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Statement;

class ProcessRefundedSale
{
    public function handle(SaleRefunded $event)
    {
        $sale = $event->sale;
        $user = $sale->user;
        $item = $sale->item;
        $purchase = $sale->purchase;

        $sale->status = Sale::STATUS_REFUNDED;
        $sale->update();

        $user->increment('balance', $sale->price);

        $statement1 = new Statement();
        $statement1->user_id = $user->id;
        $statement1->title = translate('[Refund] Purchase #:purchase_id (:item_name)', [
            'purchase_id' => $purchase->id,
            'item_name' => $item->name,
        ]);
        $statement1->amount = $sale->price;
        $statement1->type = Statement::TYPE_CREDIT;
        $statement1->save();

        $tax = $sale->tax;
        if ($tax) {
            $user->increment('balance', $tax->amount);

            $statement2 = new Statement();
            $statement2->user_id = $user->id;
            $statement2->title = translate('[Refund] :tax_name (:tax_rate%) Purchase #:purchase_id (:item_name)', [
                'purchase_id' => $purchase->id,
                'item_name' => $item->name,
                'tax_name' => $tax->name,
                'tax_rate' => $tax->rate,
            ]);
            $statement2->amount = $tax->amount;
            $statement2->type = Statement::TYPE_CREDIT;
            $statement2->save();
        }

        $purchase->status = Purchase::STATUS_REFUNDED;
        $purchase->update();

        app(SupportHandler::class)->refund($purchase);

        $item->decrement('total_sales');
        $item->decrement('total_sales_amount', $sale->price);

        $itemReview = $item->reviews->where('user_id', $user->id)->first();
        if ($itemReview) {
            $purchases = Purchase::where('user_id', $user->id)
                ->where('item_id', $item->id)
                ->active()->get();
            if ($purchases->count() < 1) {
                $itemReview->delete();
            }
        }
    }
}