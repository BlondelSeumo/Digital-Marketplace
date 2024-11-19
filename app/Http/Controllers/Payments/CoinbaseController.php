<?php

namespace App\Http\Controllers\Payments;

use App\Events\TransactionPaid;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CoinbaseController extends Controller
{
    private $paymentGateway;

    public function __construct()
    {
        $this->paymentGateway = paymentGateway('coinbase');
    }

    public function process($trx)
    {
        $body = [
            'name' => @settings('general')->site_name,
            'description' => translate('Payment for order #:number', [
                'number' => $trx->id,
            ]),
            'pricing_type' => "fixed_price",
            'local_price' => [
                'amount' => amountFormat($trx->total),
                'currency' => @settings('currency')->code,
            ],
            "redirect_url" => route('payments.ipn.coinbase', ['id' => hash_encode($trx->id)]),
            "cancel_url" => route('checkout.index', hash_encode($trx->id)),
        ];

        try {
            $response = $this->callApi($body);
            $result = json_decode($response);

            if (@$result->error != '') {
                throw new Exception(translate('An error occurred while calling the API'));
            }

            $trx->payment_id = $result->data->id;
            $trx->update();

            $data['type'] = "success";
            $data['method'] = "redirect";
            $data['url'] = $result->data->hosted_url;
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
        try {
            $payload = $request->getContent();
            $webhookSignature = $request->header('X-Cc-Webhook-Signature');
            $expectedSignature = hash_hmac('sha256', $payload, $this->paymentGateway->credentials->webhook_shared_secret);

            if ($webhookSignature !== $expectedSignature) {
                return response('Invalid signature', 401);
            }

            $data = json_decode($payload);
            $event = $data->event;

            if ($event->type === 'charge:confirmed') {
                $trx = Transaction::where('payment_id', $event->data->id)->unpaid()->first();
                if ($trx) {
                    $trx->status = Transaction::STATUS_PAID;
                    $trx->save();
                    event(new TransactionPaid($trx));
                }
            }

            return response('Webhook processed successfully', 200);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    private function callApi($array)
    {
        $client = new Client();

        $headers = [
            'Content-Type' => 'application/json',
            'X-CC-Api-Key' => $this->paymentGateway->credentials->api_key,
            'X-CC-Version' => '2018-03-22',
        ];

        $response = $client->post('https://api.commerce.coinbase.com/charges', [
            'headers' => $headers,
            'json' => $array,
        ]);

        return $response->getBody()->getContents();
    }
}