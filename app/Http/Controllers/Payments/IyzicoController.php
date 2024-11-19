<?php

namespace App\Http\Controllers\Payments;

use App\Events\TransactionPaid;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Iyzipay\Model\Address;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\BasketItemType;
use Iyzipay\Model\Buyer;
use Iyzipay\Model\CheckoutForm;
use Iyzipay\Model\CheckoutFormInitialize;
use Iyzipay\Model\Locale;
use Iyzipay\Model\PaymentGroup;
use Iyzipay\Options;
use Iyzipay\Request\CreateCheckoutFormInitializeRequest;
use Iyzipay\Request\RetrieveCheckoutFormRequest;

class IyzicoController extends Controller
{
    private $paymentGateway;
    private $options;

    public function __construct()
    {
        $this->paymentGateway = paymentGateway('iyzico');
        $this->options = new Options();
        $this->options->setApiKey($this->paymentGateway->credentials->api_key);
        $this->options->setSecretKey($this->paymentGateway->credentials->secret_key);
        $this->options->setBaseUrl($this->paymentGateway->isSandboxMode() ?
            'https://sandbox-api.iyzipay.com' : 'https://api.iyzipay.com');
    }

    public function process($trx)
    {
        try {
            $user = $trx->user;

            $request = new CreateCheckoutFormInitializeRequest();
            $request->setLocale(Locale::EN);
            $request->setConversationId($trx->id);
            $request->setPrice($trx->total);
            $request->setPaidPrice($trx->total);
            $request->setBasketId($user->id);
            $request->setPaymentGroup(PaymentGroup::PRODUCT);
            $request->setCurrency(@settings('currency')->code);
            $request->setCallbackUrl(route('payments.ipn.iyzico', ['id' => hash_encode($trx->id)]));

            $buyer = new Buyer();
            $buyer->setId($user->id);
            $buyer->setName($user->firstname);
            $buyer->setSurname($user->lastname);
            $buyer->setEmail($user->email);
            $buyer->setIdentityNumber(hash_encode($user->id));
            $buyer->setRegistrationAddress(@$user->address->line_1 . ', ' . @$user->address->line_2);
            $buyer->setCity(@$user->address->city);
            $buyer->setCountry(@$user->address->country);
            $buyer->setZipCode(@$user->address->zip);
            $request->setBuyer($buyer);

            $shippingAddress = new Address();
            $shippingAddress->setContactName($user->getName());
            $shippingAddress->setCity(@$user->address->city);
            $shippingAddress->setCountry(@$user->address->country);
            $shippingAddress->setAddress(@$user->address->line_1 . ', ' . @$user->address->line_2);
            $shippingAddress->setZipCode(@$user->address->zip);
            $request->setShippingAddress($shippingAddress);

            $billingAddress = new Address();
            $billingAddress->setContactName($user->getName());
            $billingAddress->setCity(@$user->address->city);
            $billingAddress->setCountry(@$user->address->country);
            $billingAddress->setAddress(@$user->address->line_1 . ', ' . @$user->address->line_2);
            $billingAddress->setZipCode(@$user->address->zip);
            $request->setBillingAddress($billingAddress);

            $basketItem = new BasketItem();
            $basketItem->setId($trx->id);
            $basketItem->setName(translate('Payment for order #:number', ['number' => $trx->id]));
            $basketItem->setCategory1(@settings('general')->site_name);
            $basketItem->setItemType(BasketItemType::VIRTUAL);
            $basketItem->setPrice($trx->total);

            $basketItems[0] = $basketItem;
            $request->setBasketItems($basketItems);

            $checkoutFormInitialize = CheckoutFormInitialize::create($request, $this->options);

            $trx->payment_id = $checkoutFormInitialize->getToken();
            $trx->update();

            $data['type'] = "success";
            $data['method'] = "redirect";
            $data['url'] = $checkoutFormInitialize->getPaymentPageUrl();
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
            'token' => ['required'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return redirect()->route('home');
        }

        $token = $request->token;

        $trx = Transaction::where('id', hash_decode($request->id))
            ->where('payment_id', $token)
            ->whereIn('status', [Transaction::STATUS_PAID, Transaction::STATUS_UNPAID])
            ->firstOrFail();

        $checkoutLink = route('checkout.index', hash_encode($trx->id));

        if ($trx->isPaid()) {
            $trx->user->emptyCart();
            return redirect($checkoutLink);
        }

        try {
            $request = new RetrieveCheckoutFormRequest();
            $request->setLocale(Locale::EN);
            $request->setConversationId($trx->id);
            $request->setToken($token);

            $checkoutForm = CheckoutForm::retrieve($request, $this->options);

            $status = $checkoutForm->getStatus();
            $paymentStatus = $checkoutForm->getPaymentStatus();

            if ($status != "success" || $paymentStatus != "SUCCESS") {
                toastr()->error(translate('Payment failed'));
                return redirect($checkoutLink);
            }

            $paymentId = $checkoutForm->getPaymentId();

            $trx->payment_id = $paymentId;
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
            $sigHeader = $request->header('x-iyz-signature');

            $payload = $request->all();
            if (!$payload) {
                return response('Invalid payload', 401);
            }

            $secretKey = $this->paymentGateway->credentials->secret_key;
            $eventType = $payload['iyziEventType'];
            $paymentId = $payload['iyziPaymentId'];

            $concatenatedString = $secretKey . $eventType . $paymentId;
            $sha1Hash = sha1($concatenatedString);
            $base64EncodedSignature = base64_encode($sha1Hash);

            if ($sigHeader != $base64EncodedSignature) {
                return response('Invalid signature', 401);
            }

            if ($payload['status'] == "SUCCESS") {
                $trx = Transaction::where('payment_id', $payload['token'])
                    ->unpaid()->first();

                if ($trx) {
                    $trx->payment_id = $payload['iyziPaymentId'];
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
