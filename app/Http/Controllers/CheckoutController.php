<?php

namespace App\Http\Controllers;

use App\Classes\Country;
use App\Models\PaymentGateway;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function index($id)
    {
        $trx = Transaction::where('id', hash_decode($id))
            ->where('user_id', authUser()->id)
            ->whereIn('status', [Transaction::STATUS_UNPAID, Transaction::STATUS_PAID])
            ->firstOrFail();

        if ($trx->isUnpaid()) {
            if ($this->trxHasAChange($trx)) {
                $trx->delete();
                toastr()->info(translate('There has been a change in your transaction'));
                return redirect()->route('home');
            }
        }

        return theme_view('checkout', [
            'trx' => $trx,
        ]);
    }

    public function process(Request $request, $id)
    {
        $user = authUser();

        $trx = Transaction::where('id', hash_decode($id))->where('user_id', $user->id)
            ->unpaid()->firstOrFail();

        if ($this->trxHasAChange($trx)) {
            $trx->delete();
            toastr()->info(translate('There has been a change in your transaction'));
            return redirect()->route('home');
        }

        $validator = Validator::make($request->all(), [
            'payment_method' => ['required', 'string', 'exists:payment_gateways,alias'],
            'address_line_1' => ['required', 'string', 'max:255', 'block_patterns'],
            'address_line_2' => ['nullable', 'string', 'max:255', 'block_patterns'],
            'city' => ['required', 'string', 'max:150', 'block_patterns'],
            'state' => ['required', 'string', 'max:150', 'block_patterns'],
            'zip' => ['required', 'string', 'max:100', 'block_patterns'],
            'country' => ['required', 'string', 'in:' . implode(',', array_keys(Country::all()))],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $paymentGateway = PaymentGateway::where('alias', $request->payment_method)
            ->active()->firstOrFail();

        $address = [
            'line_1' => $request->address_line_1,
            'line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $request->country,
        ];

        $user->address = $address;
        $user->update();

        $trx->payment_gateway_id = $paymentGateway->id;
        $trx->payment_id = null;
        $trx->payer_id = null;
        $trx->payer_email = null;
        $trx->update();

        $trx->calculate();

        $alias = ucfirst($paymentGateway->alias);
        $processor = new ("App\\Http\\Controllers\\Payments\\{$alias}Controller");
        $response = json_decode($processor->process($trx));

        if ($response) {
            if ($response->type == "error") {
                toastr()->error($response->msg);
                return back();
            }

            if ($response->type == "success" && $response->method == "redirect") {
                return redirect($response->url);
            }

            if ($response->type == "success" && $response->method == "hosted") {
                $data = isset($response->body) ? $response->body : null;
                return theme_view("payments.{$response->view}", [
                    'trx' => $trx,
                    'data' => $data,
                ]);
            }
        }

        return back();
    }

    private function trxHasAChange($trx)
    {
        if ($trx->isTypePurchase()) {
            $totalItemsAmount = 0;
            $trxItems = $trx->trxItems()->whereHas('item', function ($query) {
                $query->active();
            })->get();
            foreach ($trxItems as $trxItem) {
                if ($trxItem->isLicenseTypeExtended() && $trxItem->item->hasExtendedLicense()) {
                    $totalItemsAmount += $trxItem->getTotalAmount();
                }
            }

            if (round($totalItemsAmount, 2) != $trx->amount) {
                return true;
            }
        }

        if ($trx->isTypeDeposit() && !@settings('deposit')->status) {
            return true;
        }

        return false;
    }
}
