<?php

namespace App\Http\Controllers\Payments;

use App\Events\TransactionPaid;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Mollie\Laravel\Facades\Mollie;

class MollieController extends Controller
{
    private $paymentGateway;
    private $mollieApi;

    public function __construct()
    {
        $this->paymentGateway = paymentGateway('mollie');
        Config::set(['mollie.key' => trim($this->paymentGateway->credentials->api_key)]);
        $this->mollieApi = Mollie::api();
    }

    public function process($trx)
    {
        $body = [
            'amount' => [
                'currency' => @settings('currency')->code,
                'value' => amountFormat($trx->total),
            ],
            'description' => translate('Payment for order #:number', [
                'number' => $trx->id,
            ]),
            "metadata" => [
                "trx_id" => $trx->id,
            ],
            'redirectUrl' => route('payments.ipn.mollie', 'id=' . hash_encode($trx->id)),
            'cancelUrl' => route('checkout.index', hash_encode($trx->id)),
            'webhookUrl' => route('payments.webhooks.mollie'),
        ];

        try {
            $payment = $this->mollieApi->payments->create($body);
            $payment = $this->mollieApi->payments->get($payment->id);

            $trx->payment_id = $payment->id;
            $trx->update();

            $data['type'] = "success";
            $data['method'] = "redirect";
            $data['url'] = $payment->getCheckoutUrl();
        } catch (\Exception $e) {
            $data['type'] = "error";
            $data['msg'] = $e->getMessage();
        }

        return json_encode($data);
    }

    public function ipn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return redirect()->route('home');
        }

        $trx = Transaction::where('id', hash_decode($request->id))
            ->where('user_id', authUser()->id)
            ->whereIn('status', [Transaction::STATUS_PAID, Transaction::STATUS_UNPAID])
            ->firstOrFail();

        $checkoutLink = route('checkout.index', hash_encode($trx->id));

        if ($trx->isPaid()) {
            $trx->user->emptyCart();
            return redirect($checkoutLink);
        }

        try {
            $payment = $this->mollieApi->payments->get($trx->payment_id);
            if ($payment->status != "paid") {
                toastr()->error(translate('Payment failed'));
                return redirect($checkoutLink);
            }

            $trx->payer_id = $payment->profileId;
            $trx->status = Transaction::STATUS_PAID;
            $trx->update();

            $trx->user->emptyCart();
            event(new TransactionPaid($trx));
            return redirect($checkoutLink);
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect($checkoutLink);
        }
    }

    public function webhook(Request $request)
    {
        $paymentId = $request->id;

        try {
            $payment = $this->mollieApi->payments->get($paymentId);
            if ($payment) {
                if ($payment->status != "paid") {
                    return response('Payment failed', 400);
                }

                $trx = Transaction::where('id', $payment->metadata->trx_id)
                    ->where('payment_id', $payment->id)->unpaid()->first();
                if ($trx) {
                    $trx->payer_id = $payment->profileId;
                    $trx->status = Transaction::STATUS_PAID;
                    $trx->update();
                    event(new TransactionPaid($trx));
                }
            }

            return response('Webhook processed successfully', 200);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }
}
