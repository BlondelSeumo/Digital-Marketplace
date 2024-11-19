<?php

namespace App\Http\Controllers\Payments;

use App\Events\TransactionPaid;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use KingFlamez\Rave\Facades\Rave as Flutterwave;

class FlutterwaveController extends Controller
{
    private $paymentGateway;

    public function __construct()
    {
        $this->paymentGateway = paymentGateway('flutterwave');
        Config::set(['flutterwave' => [
            'publicKey' => $this->paymentGateway->credentials->public_key,
            'secretKey' => $this->paymentGateway->credentials->secret_key,
            'secretHash' => $this->paymentGateway->credentials->secret_hash,
        ]]);
    }

    public function process($trx)
    {
        $user = $trx->user;

        try {
            $reference = Flutterwave::generateReference();

            $body = [
                'tx_ref' => $reference,
                'customizations' => [
                    'title' => translate('Payment for order #:number', [
                        'number' => $trx->id,
                    ]),
                ],
                'amount' => amountFormat($trx->total),
                'currency' => @settings('currency')->code,
                'email' => $user->email,
                'customer' => [
                    "name" => $user->getName(),
                    'email' => $user->email,
                ],
                'redirect_url' => route('payments.ipn.flutterwave'),
            ];

            $payment = Flutterwave::initializePayment($body);
            if ($payment['status'] !== 'success') {
                throw new Exception(translate('An error occurred while calling the API'));
            }

            $trx->payment_id = $reference;
            $trx->update();

            $data['type'] = "success";
            $data['method'] = "redirect";
            $data['url'] = $payment['data']['link'];
        } catch (\Exception $e) {
            $data['type'] = "error";
            $data['msg'] = $e->getMessage();
        }

        return json_encode($data);
    }

    public function ipn(Request $request)
    {
        try {
            $transactionID = Flutterwave::getTransactionIDFromCallback();
            $payment = Flutterwave::verifyTransaction($transactionID);

            if (!$payment) {
                throw new Exception(translate('An error occurred while calling the API'));
            }

            $data = $payment['data'];

            $trx = Transaction::where('user_id', authUser()->id)
                ->where('payment_id', $data['tx_ref'])
                ->whereIn('status', [Transaction::STATUS_PAID, Transaction::STATUS_UNPAID])
                ->firstOrFail();

            $checkoutLink = route('checkout.index', hash_encode($trx->id));

            if ($trx->isPaid()) {
                $trx->user->emptyCart();
                return redirect($checkoutLink);
            }

            if ($payment['status'] != "success" || $data['status'] != "successful") {
                toastr()->error(translate('Payment failed'));
                return redirect($checkoutLink);
            }

            $customer = $data['customer'];

            $trx->payer_id = $customer['id'];
            $trx->payer_email = $customer['email'];
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
        try {
            $verified = Flutterwave::verifyWebhook();
            if (!$verified) {
                return response('Invalid signature', 401);
            }

            $payload = $request->all();
            if (!$payload) {
                return response('Invalid payload', 401);
            }

            $data = $payload['data'];

            if ($payload['event'] == 'charge.completed' && $data['status'] == 'successful') {
                $trx = Transaction::where('payment_id', $data['tx_ref'])->unpaid()->first();
                if ($trx) {
                    $customer = $data['customer'];
                    $trx->payer_id = $customer['id'];
                    $trx->payer_email = $customer['email'];
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
