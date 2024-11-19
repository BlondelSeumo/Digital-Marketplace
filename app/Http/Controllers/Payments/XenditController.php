<?php

namespace App\Http\Controllers\Payments;

use App\Events\TransactionPaid;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Stripe\Webhook;
use Xendit\Configuration;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\InvoiceApi;

class XenditController extends Controller
{
    private $paymentGateway;

    public function __construct()
    {
        $this->paymentGateway = paymentGateway('xendit');
        Configuration::setXenditKey($this->paymentGateway->credentials->api_secret_key);
    }

    public function process($trx)
    {
        $user = $trx->user;

        $body = [
            'external_id' => "$trx->id",
            'description' => translate('Payment for order #:number', [
                'number' => $trx->id,
            ]),
            'amount' => $trx->total,
            'currency' => @settings('currency')->code,
            'reminder_time' => 1,
            'customer' => [
                'given_names' => $user->firstname,
                'surname' => $user->lastname,
                'email' => $user->email,
            ],
            'success_redirect_url' => route('payments.ipn.xendit', ['id' => hash_encode($trx->id)]),
            'failure_redirect_url' => route('checkout.index', hash_encode($trx->id)),
        ];

        try {
            $request = new CreateInvoiceRequest($body);

            $apiInstance = new InvoiceApi();
            $response = $apiInstance->createInvoice($request);

            $trx->payment_id = $response['id'];
            $trx->update();

            $data['type'] = "success";
            $data['method'] = "redirect";
            $data['url'] = $response['invoice_url'];
        } catch (\Exception $e) {
            $data['type'] = "error";
            $data['msg'] = $e->getMessage();
        }

        return json_encode($data);
    }

    public function ipn(Request $request)
    {
        $trx = Transaction::where('id', hash_decode($request->id))
            ->where('user_id', authUser()->id)
            ->whereIn('status', [Transaction::STATUS_PAID, Transaction::STATUS_UNPAID])
            ->firstOrFail();

        if ($trx->isPaid()) {
            $trx->user->emptyCart();
        }
        return redirect()->route('checkout.index', $request->id);
    }

    public function webhook(Request $request)
    {
        $webhookVerificationToken = $this->paymentGateway->credentials->webhook_verification_token;
        $incomingVerificationTokenHeader = $request->header('x-callback-token');

        try {
            if ($incomingVerificationTokenHeader != $webhookVerificationToken) {
                return response('Invalid verification token', 401);
            }

            $payload = $request->all();
            if (!$payload) {
                return response('Invalid payload', 401);
            }

            if ($payload['status'] == "PAID") {
                $trx = Transaction::where('payment_id', $payload['id'])
                    ->unpaid()->first();

                if ($trx) {
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
