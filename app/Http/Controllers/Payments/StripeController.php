<?php

namespace App\Http\Controllers\Payments;

use App\Events\TransactionPaid;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\Webhook;
use UnexpectedValueException;

class StripeController extends Controller
{
    private $paymentGateway;

    public function __construct()
    {
        $this->paymentGateway = paymentGateway('stripe');
        Stripe::setApiKey($this->paymentGateway->credentials->secret_key);
    }

    public function process($trx)
    {
        $body = [
            'customer_creation' => 'always',
            'customer_email' => $trx->user->email,
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'unit_amount' => round($trx->total * 100),
                    'currency' => @settings('currency')->code,
                    'product_data' => [
                        'name' => @settings('general')->site_name,
                        'description' => translate('Payment for order #:number', [
                            'number' => $trx->id,
                        ]),
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            "cancel_url" => route('checkout.index', hash_encode($trx->id)),
            'success_url' => route('payments.ipn.stripe') . '?session_id={CHECKOUT_SESSION_ID}',
        ];

        try {
            $session = Session::create($body);

            $trx->payment_id = $session->id;
            $trx->update();

            $data['type'] = "success";
            $data['method'] = "redirect";
            $data['url'] = $session->url;
        } catch (\Exception $e) {
            $data['type'] = "error";
            $data['msg'] = $e->getMessage();
        }

        return json_encode($data);
    }

    public function ipn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'session_id' => ['required'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return redirect()->route('home');
        }

        $sessionId = $request->session_id;

        $trx = Transaction::where('user_id', authUser()->id)
            ->where('payment_id', $sessionId)
            ->whereIn('status', [Transaction::STATUS_PAID, Transaction::STATUS_UNPAID])
            ->firstOrFail();

        $checkoutLink = route('checkout.index', hash_encode($trx->id));

        if ($trx->isPaid()) {
            $trx->user->emptyCart();
            return redirect($checkoutLink);
        }

        try {
            $session = Session::retrieve($sessionId);
            if ($session->payment_status != "paid" || $session->status != "complete") {
                toastr()->error(translate('Payment failed'));
                return redirect($checkoutLink);
            }

            $customer = Customer::retrieve($session->customer);
            $trx->payer_id = $customer->id;
            $trx->payer_email = $customer->email;
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
        $endpointSecret = $this->paymentGateway->credentials->webhook_secret;

        $sigHeader = $request->header('Stripe-Signature');
        $payload = $request->getContent();

        if (!$payload) {
            return response('Invalid payload', 401);
        }

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
            if ($event && $event->type == 'checkout.session.completed') {
                $session = $event->data->object;
                $trx = Transaction::where('payment_id', $session->id)->unpaid()->first();
                if ($trx) {
                    $customer = Customer::retrieve($session->customer);
                    $trx->payer_id = $customer->id;
                    $trx->payer_email = $customer->email;
                    $trx->status = Transaction::STATUS_PAID;
                    $trx->update();
                    event(new TransactionPaid($trx));
                }
            }

            return response('Webhook processed successfully', 200);
        } catch (SignatureVerificationException $e) {
            return response('Invalid signature', 401);
        } catch (UnexpectedValueException $e) {
            return response('Invalid payload', 401);
        }
    }
}
