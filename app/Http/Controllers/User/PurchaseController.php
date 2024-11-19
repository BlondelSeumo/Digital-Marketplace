<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\SupportPeriod;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    public function index()
    {
        $supportPeriods = SupportPeriod::notFree()->get();

        $purchases = Purchase::where('user_id', authUser()->id)
            ->active();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $purchases->where('code', 'like', $searchTerm)
                ->OrWhereHas('item', function ($query) use ($searchTerm) {
                    $query->where('id', 'like', $searchTerm)
                        ->OrWhere('name', 'like', $searchTerm)
                        ->OrWhere('slug', 'like', $searchTerm)
                        ->OrWhere('description', 'like', $searchTerm)
                        ->OrWhere('options', 'like', $searchTerm)
                        ->OrWhere('demo_link', 'like', $searchTerm)
                        ->OrWhere('tags', 'like', $searchTerm)
                        ->OrWhere('regular_price', 'like', $searchTerm)
                        ->OrWhere('extended_price', 'like', $searchTerm);
                });
        }

        $purchases = $purchases->orderbyDesc('id')->paginate(20);
        $purchases->appends(request()->only(['search']));

        return theme_view('user.purchases.index', [
            'purchases' => $purchases,
            'supportPeriods' => $supportPeriods,
        ]);
    }

    public function supportPurchase(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'support' => ['required', 'integer', 'exists:support_periods,id'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $purchase = Purchase::where('user_id', authUser()->id)
            ->where('id', $id)->whereHas('item', function ($query) {
            $query->active();
        })->active()->firstOrFail();

        $supportPeriod = SupportPeriod::notFree()->firstOrFail();

        $item = $purchase->item;

        if ($item->isFree()) {
            toastr()->error(translate('The item is free currently'));
            return back();
        }

        if (!$item->isSupported()) {
            toastr()->error(translate('The item is not supported'));
            return back();
        }

        if ($purchase->isLicenseTypeExtended() && !$item->hasExtendedLicense()) {
            toastr()->error(translate('The item license type is not available'));
            return back();
        }

        $price = $purchase->isLicenseTypeRegular() ? $item->price->regular : $item->price->extended;

        $supportPrice = (($price * $supportPeriod->percentage) / 100);

        $support = [
            'name' => $supportPeriod->name,
            'title' => $supportPeriod->title,
            'days' => $supportPeriod->days,
            'percentage' => $supportPeriod->percentage,
            'price' => round($supportPrice, 2),
            'quantity' => 1,
            'total' => round($supportPrice, 2),
        ];

        $transaction = new Transaction();
        $transaction->user_id = authUser()->id;
        $transaction->amount = $supportPrice;
        $transaction->total = $supportPrice;
        $transaction->support = $support;
        $transaction->purchase_id = $purchase->id;
        $transaction->type = Transaction::TYPE_SUPPORT_PURCHASE;
        $transaction->save();

        return redirect()->route('checkout.index', hash_encode($transaction->id));
    }

    public function supportExtend(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'support' => ['required', 'integer', 'exists:support_periods,id'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $purchase = Purchase::where('user_id', authUser()->id)
            ->where('id', $id)->whereHas('item', function ($query) {
            $query->active();
        })->active()->supportExpired()->firstOrFail();

        $supportPeriod = SupportPeriod::notFree()->firstOrFail();

        $item = $purchase->item;

        if ($item->isFree()) {
            toastr()->error(translate('The item is free currently'));
            return back();
        }

        if (!$item->isSupported()) {
            toastr()->error(translate('The item is not supported'));
            return back();
        }

        if ($purchase->isLicenseTypeExtended() && !$item->hasExtendedLicense()) {
            toastr()->error(translate('The item license type is not available'));
            return back();
        }

        $price = $purchase->isLicenseTypeRegular() ? $item->price->regular : $item->price->extended;

        $supportPrice = (($price * $supportPeriod->percentage) / 100);

        $support = [
            'name' => $supportPeriod->name,
            'title' => $supportPeriod->title,
            'days' => $supportPeriod->days,
            'percentage' => $supportPeriod->percentage,
            'price' => round($supportPrice, 2),
            'quantity' => 1,
            'total' => round($supportPrice, 2),
        ];

        $transaction = new Transaction();
        $transaction->user_id = authUser()->id;
        $transaction->amount = $supportPrice;
        $transaction->total = $supportPrice;
        $transaction->support = $support;
        $transaction->purchase_id = $purchase->id;
        $transaction->type = Transaction::TYPE_SUPPORT_EXTEND;
        $transaction->save();

        return redirect()->route('checkout.index', hash_encode($transaction->id));
    }

    public function license($id)
    {
        $purchase = Purchase::where('id', $id)
            ->where('user_id', authUser()->id)
            ->active()
            ->firstOrFail();

        return theme_view('user.purchases.license', [
            'purchase' => $purchase,
        ]);
    }

    public function download($id)
    {
        $purchase = Purchase::where('id', $id)
            ->where('user_id', authUser()->id)
            ->active()
            ->firstOrFail();

        $url = route('user.purchases.index');
        if (!$this->isAuthorizedURL($url)) {
            return redirect($url);
        }

        $item = $purchase->item;
        try {
            $response = $item->download();
            if (isset($response->type) && $response->type == "error") {
                throw new Exception($response->message);
            }
            $purchase->is_downloaded = true;
            $purchase->update();
            return $response;
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    private function isAuthorizedURL($url)
    {
        $referer = request()->server('HTTP_REFERER');
        if ($referer && filter_var($referer, FILTER_VALIDATE_URL) !== false) {
            $referer = parse_url($referer);
            $url = parse_url($url);
            if ($url['host'] == $referer['host']) {
                return true;
            }
        }
        return false;
    }
}
