<?php

namespace App\Http\Controllers\Payments;

use App\Events\TransactionPaid;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Vironeer\PayPal\Core\PayPalHttpClient;
use Vironeer\PayPal\Core\ProductionEnvironment;
use Vironeer\PayPal\Core\SandboxEnvironment;
use Vironeer\PayPal\Orders\OrdersCaptureRequest;
use Vironeer\PayPal\Orders\OrdersCreateRequest;

class PaypalController extends Controller
{
    private $paymentGateway;
    private $environment;

    public function __construct()
    {
        $this->paymentGateway = paymentGateway('paypal');
        if ($this->paymentGateway->isSandboxMode()) {
            $this->environment = new SandboxEnvironment(
                $this->paymentGateway->credentials->client_id,
                $this->paymentGateway->credentials->client_secret
            );
        } else {
            $this->environment = new ProductionEnvironment(
                $this->paymentGateway->credentials->client_id,
                $this->paymentGateway->credentials->client_secret
            );
        }
    }

    public function process($trx)
    {
        $client = new PayPalHttpClient($this->environment);
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');

        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => $trx->id,
                "description" => translate('Payment for order #:number', [
                    'number' => $trx->id,
                ]),
                "amount" => [
                    "value" => amountFormat($trx->total),
                    "currency_code" => @settings('currency')->code,
                    "breakdown" => [
                        "item_total" => [
                            "value" => amountFormat($trx->amount),
                            "currency_code" => @settings('currency')->code,
                        ],
                        "handling" => [
                            "value" => amountFormat($trx->fees),
                            "currency_code" => @settings('currency')->code,
                        ],
                        "tax_total" => [
                            "value" => $trx->tax ? amountFormat($trx->tax->amount) : 0,
                            "currency_code" => @settings('currency')->code,
                        ],
                    ],
                ],
            ]],
            "application_context" => [
                "return_url" => route('payments.ipn.paypal'),
                "cancel_url" => route('checkout.index', hash_encode($trx->id)),
                "shipping_preference" => "NO_SHIPPING",
            ],
        ];

        try {
            $response = $client->execute($request);

            $trx->payment_id = $response->result->id;
            $trx->update();

            $data['type'] = "success";
            $data['method'] = "redirect";
            $data['url'] = $response->result->links[1]->href;
        } catch (\Exception $e) {
            $data['type'] = "error";
            $data['msg'] = $e->getMessage();
        }

        return json_encode($data);
    }

    public function ipn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => ['required'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return redirect()->route('home');
        }

        $trx = Transaction::where('user_id', authUser()->id)
            ->where('payment_id', $request->token)
            ->whereIn('status', [Transaction::STATUS_PAID, Transaction::STATUS_UNPAID])
            ->firstOrFail();

        $checkoutLink = route('checkout.index', hash_encode($trx->id));

        if ($trx->isPaid()) {
            $trx->user->emptyCart();
            return redirect($checkoutLink);
        }

        try {
            $ordersCaptureRequest = new OrdersCaptureRequest($trx->payment_id);
            $ordersCaptureRequest->prefer('return=representation');
            $client = new PayPalHttpClient($this->environment);
            $response = $client->execute($ordersCaptureRequest);

            if (@$response->result->status != 'COMPLETED') {
                toastr()->error(translate('Payment failed'));
                return redirect($checkoutLink);
            }

            $trx->payer_id = $response->result->payer->payer_id;
            $trx->payer_email = $response->result->payer->email_address;
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
        $headers = $request->headers->all();
        $rawRequestBody = $request->getContent();

        try {
            $signatureVerified = $this->verifyPayPalSignature($headers, $rawRequestBody);
            if (!$signatureVerified) {
                return response('Invalid signature', 401);
            }

            $payload = json_decode($request->getContent(), true);

            if (!$payload) {
                return response('Invalid payload', 401);
            }

            if (isset($payload['event_type']) && $payload['event_type'] === 'PAYMENT.CAPTURE.COMPLETED') {
                if (isset($payload['resource']['status']) && $payload['resource']['status'] === 'COMPLETED') {
                    $supplementaryData = $payload['resource']['supplementary_data'];
                    $trx = Transaction::where('payment_id', $supplementaryData['related_ids']['order_id'])->unpaid()->first();
                    if ($trx) {
                        $trx->status = Transaction::STATUS_PAID;
                        $trx->update();
                        event(new TransactionPaid($trx));
                    }
                }
            }

            return response('Webhook processed successfully', 200);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    private function verifyPayPalSignature($headers, $rawRequestBody)
    {
        $transmissionId = $headers['paypal-transmission-id'][0];
        $timeStamp = $headers['paypal-transmission-time'][0];
        $crc32 = crc32($rawRequestBody);

        $webhookId = $this->paymentGateway->credentials->webhook_id;

        $inputString = implode('|', [
            $transmissionId,
            $timeStamp,
            $webhookId,
            $crc32,
        ]);

        $signature = $headers['paypal-transmission-sig'][0];

        $certUrl = $headers['paypal-cert-url'][0];

        $publicKey = openssl_pkey_get_public(file_get_contents($certUrl));

        $verified = openssl_verify(
            $inputString,
            base64_decode($signature),
            $publicKey,
            OPENSSL_ALGO_SHA256
        );

        openssl_free_key($publicKey);

        return $verified === 1;
    }

}
