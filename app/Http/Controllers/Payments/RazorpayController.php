<?php

namespace App\Http\Controllers\Payments;

use App\Events\TransactionPaid;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use Validator;

class RazorpayController extends Controller
{
    private $paymentGateway;
    private $api;

    public function __construct()
    {
        $this->paymentGateway = paymentGateway('razorpay');
        $this->api = new Api(
            $this->paymentGateway->credentials->key_id,
            $this->paymentGateway->credentials->key_secret
        );
    }

    public function process($trx)
    {
        try {
            $razorpayAmount = round($trx->total * 100);

            $order = $this->api->order->create([
                'receipt' => "{$trx->id}",
                'amount' => $razorpayAmount,
                'currency' => @settings('currency')->code,
            ]);

            $data['body'] = [
                'key' => $this->paymentGateway->credentials->key_id,
                'amount' => $razorpayAmount,
                'currency' => @settings('currency')->code,
                'order_id' => $order['id'],
                'buttontext' => translate('Pay Now'),
                'name' => @settings('general')->site_name,
                'description' => translate('Payment for order #:number', [
                    'number' => $trx->id,
                ]),
                'image' => asset(themeSettings('general')->logo_dark),
                'prefill.name' => $trx->user->getName(),
                'prefill.email' => $trx->user->email,
                'theme.color' => themeSettings('colors')->primary_color,
            ];

            $trx->payment_id = $order['id'];
            $trx->update();

            $data['type'] = "success";
            $data['method'] = "hosted";
            $data['view'] = 'razorpay';
        } catch (\Exception $e) {
            $data['type'] = "error";
            $data['msg'] = $e->getMessage();
        }

        return json_encode($data);
    }

    public function ipn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'trx_id' => ['required'],
            'razorpay_order_id' => ['required'],
            'razorpay_payment_id' => ['required'],
            'razorpay_signature' => ['required'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return redirect()->route('home');
        }

        $trxId = hash_decode($request->trx_id);
        $orderId = $request->razorpay_order_id;
        $paymentId = $request->razorpay_payment_id;

        $trx = Transaction::where('id', $trxId)
            ->where('user_id', authUser()->id)
            ->where(function ($query) use ($orderId, $paymentId) {
                $query->where('payment_id', $orderId)
                    ->orWhere('payment_id', $paymentId);
            })
            ->whereIn('status', [Transaction::STATUS_PAID, Transaction::STATUS_UNPAID])
            ->firstOrFail();

        $checkoutLink = route('checkout.index', hash_encode($trx->id));

        if ($trx->isPaid()) {
            $trx->user->emptyCart();
            return redirect($checkoutLink);
        }

        try {
            $payment = $this->api->payment->fetch($paymentId);

            $signature = hash_hmac('sha256', $orderId . "|" . $paymentId, $this->paymentGateway->credentials->key_secret);
            if ($payment['status'] != 'captured' || $signature != $request->razorpay_signature) {
                toastr()->error(translate('Payment failed'));
                return redirect($checkoutLink);
            }

            $trx->payment_id = $payment['id'];
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
        $webhookSecret = $this->paymentGateway->credentials->webhook_secret;

        $sigHeader = $request->header('x-razorpay-signature');
        $webhookBody = $request->getContent();

        try {
            $this->api->utility->verifyWebhookSignature($webhookBody, $sigHeader, $webhookSecret);

            $data = $request['payload'];

            if (!$data) {
                return response('Invalid payload', 401);
            }

            $trx = Transaction::where('payment_id', $data['payment']['entity']['order_id'])
                ->unpaid()->first();

            if ($trx) {
                $trx->payment_id = $data['payment']['entity']['id'];
                $trx->status = Transaction::STATUS_PAID;
                $trx->update();
                event(new TransactionPaid($trx));
            }

            return response('Webhook processed successfully', 200);
        } catch (SignatureVerificationError $e) {
            return response('Invalid signature', 401);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }
}