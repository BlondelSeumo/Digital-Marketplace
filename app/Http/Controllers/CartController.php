<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Item;
use App\Models\SupportPeriod;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::forCurrentSession()
            ->orderbyDesc('id')->paginate(12);

        $cartTotal = 0;
        if ($cartItems->count() > 0) {
            foreach ($cartItems as $cartItem) {
                $cartTotal += $cartItem->getTotalAmountWithSupport();
            }
        }

        return theme_view('cart', [
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal,
        ]);
    }

    public function addItem(Request $request)
    {
        $item = Item::where('id', $request->item_id)
            ->purchaseMethodInternal()
            ->notFree()->active()->first();

        if (!$item) {
            return response()->json([
                'error' => translate('The chosen item are not available'),
            ]);
        }

        $rules = [
            'license_type' => ['required', 'integer', 'min:1', 'max:2'],
        ];

        $supportPeriodId = null;
        if (@settings('item')->support_status && $item->isSupported()) {
            $supportPeriodsCount = SupportPeriod::count();
            if ($supportPeriodsCount > 0) {
                $supportPeriod = SupportPeriod::where('id', $request->support)->firstOrFail();
                $rules['support'] = ['required', 'integer', 'exists:support_periods,id'];

                $supportPeriodId = $supportPeriod->id;
            }
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return response()->json(['error' => $error]);
            }
        }

        if ($request->license_type == 2 && !$item->hasExtendedLicense()) {
            return response()->json([
                'error' => translate('The chosen license are not available'),
            ]);
        }

        $user = authUser();

        if ($user) {
            $sessionId = null;
            $userId = $user->id;

            $cartItem = CartItem::where('user_id', $userId)
                ->where('item_id', $item->id)
                ->where('license_type', $request->license_type)->first();
        } else {
            if (session()->has('session_id')) {
                $sessionId = session()->get('session_id');
            } else {
                $sessionId = sha1(Str::random(12) . time());
                session()->put('session_id', $sessionId);
            }
            $userId = null;

            $cartItem = CartItem::where('session_id', $sessionId)
                ->where('item_id', $item->id)
                ->where('license_type', $request->license_type)
                ->first();
        }

        if (!$cartItem) {
            $cart = new CartItem();
            $cart->session_id = $sessionId;
            $cart->user_id = $userId;
            $cart->item_id = $item->id;
            $cart->license_type = $request->license_type;
            $cart->support_period_id = $supportPeriodId;
            $cart->save();
        } else {
            if ($cartItem->quantity >= 50) {
                return response()->json([
                    'error' => translate('You have reached the limit for each item'),
                ]);
            }
            $cartItem->support_period_id = $supportPeriodId;
            $cartItem->quantity = ($cartItem->quantity + 1);
            $cartItem->save();
        }

        return response()->json([
            'success' => translate('The item added to cart'),
        ]);
    }

    public function updateItem(Request $request, $id)
    {
        $cartItem = CartItem::where('id', $id)
            ->forCurrentSession()->firstOrFail();

        $rules = [
            'license_type' => ['required', 'integer', 'min:1', 'max:2'],
            'quantity' => ['required', 'integer', 'min:1', 'max:50'],
        ];

        $supportPeriodId = null;
        if ($cartItem->item->isSupported()) {
            $supportPeriod = SupportPeriod::where('id', $request->support)->firstOrFail();
            $rules['support'] = ['required', 'integer', 'exists:support_periods,id'];

            $supportPeriodId = $supportPeriod->id;
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        if ($request->license_type == 2 && !$cartItem->item->hasExtendedLicense()) {
            toastr()->error(translate('The chosen license are not available'));
            return back();
        }

        $cartItemExists = CartItem::whereNot('id', $cartItem->id)
            ->where('item_id', $cartItem->item_id)
            ->where('license_type', $request->license_type)
            ->forCurrentSession()
            ->first();

        if ($cartItemExists) {
            $cartItemExists->increment('quantity', $request->quantity);
            $cartItem->delete();
        } else {
            $cartItem->license_type = $request->license_type;
            $cartItem->quantity = $request->quantity;
            $cartItem->support_period_id = $supportPeriodId;
            $cartItem->update();
        }

        toastr()->success(translate('The cart item has been updated'));
        return back();
    }

    public function removeItem(Request $request, $id)
    {
        $cartItem = CartItem::where('id', $id)
            ->forCurrentSession()->firstOrFail();
        $cartItem->delete();
        return back();
    }

    public function empty(Request $request)
    {
        $cartItems = CartItem::forCurrentSession()->get();

        if ($cartItems->count() > 0) {
            foreach ($cartItems as $cartItem) {
                $cartItem->delete();
            }
        }

        return back();
    }

    public function checkout(Request $request)
    {
        $cartItems = CartItem::forCurrentSession()->whereHas('item', function ($query) {
            $query->active();
        })->get();

        if ($cartItems->count() > 0) {
            $transactionTotalAmount = 0;
            foreach ($cartItems as $cartItem) {
                $transactionTotalAmount += $cartItem->getTotalAmountWithSupport();
            }

            $transaction = new Transaction();
            $transaction->user_id = authUser()->id;
            $transaction->amount = $transactionTotalAmount;
            $transaction->total = $transactionTotalAmount;
            $transaction->type = Transaction::TYPE_PURCHASE;
            $transaction->save();

            foreach ($cartItems as $cartItem) {
                $item = $cartItem->item;

                if ($cartItem->isLicenseTypeExtended() && !$cartItem->item->hasExtendedLicense()) {
                    toastr()->error(translate('Some of the items in your cart have an unavailable license type'));
                    return back();
                }

                $price = $cartItem->isLicenseTypeRegular() ? $item->price->regular : $item->price->extended;

                $support = null;
                if (@settings('item')->support_status && $item->isSupported()) {
                    $supportPeriod = $cartItem->supportPeriod;
                    if ($supportPeriod) {
                        $supportPrice = (($price * $supportPeriod->percentage) / 100);
                        $support = [
                            'name' => $supportPeriod->name,
                            'title' => $supportPeriod->title,
                            'days' => $supportPeriod->days,
                            'percentage' => $supportPeriod->percentage,
                            'price' => round($supportPrice, 2),
                            'quantity' => $cartItem->quantity,
                            'total' => round($supportPrice * $cartItem->quantity, 2),
                        ];
                    }
                }

                $transactionItem = new TransactionItem();
                $transactionItem->transaction_id = $transaction->id;
                $transactionItem->item_id = $item->id;
                $transactionItem->license_type = $cartItem->license_type;
                $transactionItem->price = $price;
                $transactionItem->quantity = $cartItem->quantity;
                $transactionItem->support = $support;
                $transactionItem->total = $cartItem->getTotalAmount();
                $transactionItem->save();
            }

            return redirect()->route('checkout.index', hash_encode($transaction->id));
        }

        return back();
    }
}
