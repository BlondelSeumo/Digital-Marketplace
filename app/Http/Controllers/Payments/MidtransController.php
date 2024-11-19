<?php

namespace App\Http\Controllers\Payments;

use App\Events\TransactionPaid;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransController extends Controller
{
    private $paymentGateway;
    private $serverKey;

    public function __construct()
    {
        $this->paymentGateway = paymentGateway('midtrans');
        $this->serverKey = $this->paymentGateway->credentials->server_key;
        Config::$serverKey = $this->serverKey;
        Config::$isProduction = $this->paymentGateway->isSandboxMode() ? false : true;
        Config::$appendNotifUrl = route('payments.webhooks.midtrans');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function process($trx)
    {
        $user = $trx->user;

        $customer_details = [
            'first_name' => $user->firstname,
            'last_name' => $user->lastname,
            'email' => $user->email,
        ];

        $orderId = strtoupper(Str::random(22));

        $transaction_data = array(
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => round($trx->total, 0),
                'currency' => @settings('currency')->code,
            ],
            'customer_details' => $customer_details,
        );

        try {
            $transaction = Snap::createTransaction($transaction_data);

            $trx->payment_id = $orderId;
            $trx->update();

            $data['type'] = "success";
            $data['method'] = "redirect";
            $data['url'] = $transaction->redirect_url;
        } catch (\Exception $e) {
            $data['type'] = "error";
            $data['msg'] = $e->getMessage();
        }

        return json_encode($data);
    }

    public function ipn(Request $request)
    {
        $trx = Transaction::where('user_id', authUser()->id)
            ->where('payment_id', $request->order_id)
            ->whereIn('status', [Transaction::STATUS_PAID, Transaction::STATUS_UNPAID])
            ->firstOrFail();

        if ($trx->isPaid()) {
            $trx->user->emptyCart();
        }
        return redirect()->route('checkout.index', hash_encode($trx->id));
    }

    public function webhook(Request $request)
    {
        try {
            $payload = $request->all();
            if (!$payload) {
                return response('Invalid payload', 401);
            }

            $signature = hash("sha512", $payload['order_id'] . $payload['status_code'] . $payload['gross_amount'] . $this->serverKey);

            if ($signature != $payload['signature_key']) {
                return response('Invalid signature', 401);
            }

            $paid = false;
            if ($payload['transaction_status'] == 'capture') {
                if ($payload['fraud_status'] == 'accept') {
                    $paid = true;
                }
            } elseif ($payload['transaction_status'] == 'settlement') {
                $paid = true;
            }

            if ($paid) {
                $trx = Transaction::where('payment_id', $request['order_id'])->unpaid()->first();
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
