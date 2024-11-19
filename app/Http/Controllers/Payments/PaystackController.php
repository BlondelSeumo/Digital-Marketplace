<?php

namespace App\Http\Controllers\Payments;

use App\Events\TransactionPaid;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Str;
use Validator;

class PaystackController extends Controller
{
    private $paymentGateway;

    public function __construct()
    {
        $this->paymentGateway = paymentGateway('paystack');
    }

    public function process($trx)
    {
        try {
            $reference = 'pys_' . Str::random(22);

            $data['body'] = [
                'key' => $this->paymentGateway->credentials->public_key,
                'email' => $trx->user->email,
                'amount' => ($trx->total * 100),
                'currency' => @settings('currency')->code,
                'ref' => $reference,
            ];

            $trx->payment_id = $reference;
            $trx->update();

            $data['type'] = "success";
            $data['method'] = "hosted";
            $data['view'] = 'paystack';
        } catch (\Exception $e) {
            $data['type'] = "error";
            $data['msg'] = $e->getMessage();
        }

        return json_encode($data);
    }

    public function ipn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reference' => ['required'],
            'paystack-trxref' => ['required'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return redirect()->route('home');
        }

        $reference = $request->reference;
        $trx = Transaction::where('user_id', authUser()->id)
            ->where('payment_id', $reference)
            ->whereIn('status', [Transaction::STATUS_PAID, Transaction::STATUS_UNPAID])
            ->firstOrFail();

        $checkoutLink = route('checkout.index', hash_encode($trx->id));

        if ($trx->isPaid()) {
            $trx->user->emptyCart();
            return redirect($checkoutLink);
        }

        try {
            $response = $this->verifyReference($reference);
            $result = json_decode($response, true);

            if (!$result || $result['data']['status'] != "success") {
                toastr()->error(translate('Payment failed'));
                return redirect($checkoutLink);
            }

            $customer = $result['data']['customer'];

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
        $headerSignature = $request->header('x-paystack-signature');
        $content = $request->getContent();

        try {
            $signature = hash_hmac('sha512', $content, $this->paymentGateway->credentials->secret_key);
            if ($signature != $headerSignature) {
                return response('Invalid signature', 401);
            }

            $payload = $request->all();
            if (!$payload) {
                return response('Invalid payload', 401);
            }

            if ($payload['event'] == 'charge.success') {
                $data = $payload['data'];

                $trx = Transaction::where('payment_id', $data['reference'])
                    ->unpaid()->first();
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

    private function verifyReference($reference)
    {
        $client = new Client();
        $paystackSecretKey = $this->paymentGateway->credentials->secret_key;
        $response = $client->request('GET', 'https://api.paystack.co/transaction/verify/' . $reference, [
            'headers' => [
                'Authorization' => 'Bearer ' . $paystackSecretKey,
            ],
        ]);
        return $response->getBody();
    }
}