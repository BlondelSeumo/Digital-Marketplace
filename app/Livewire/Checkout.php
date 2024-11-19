<?php

namespace App\Livewire;

use App\Classes\Country;
use App\Models\PaymentGateway;
use App\Models\Tax;
use App\Traits\LivewireToastr;
use Livewire\Component;

class Checkout extends Component
{
    use LivewireToastr;

    public $user;
    public $trx;
    public $summary = [];
    public $payment_method;

    public $address_line_1;
    public $address_line_2;
    public $city;
    public $state;
    public $zip;
    public $country;

    public function mount()
    {
        $this->user = authUser();
        $this->payment_method = old('payment_method') ?? PaymentGateway::forTrx($this->trx)->active()->first()->alias;

        $user = $this->user;
        $this->address_line_1 = old('address_line_1') ?? @$user->address->line_1;
        $this->address_line_2 = old('address_line_2') ?? @$user->address->line_2;
        $this->city = old('city') ?? @$user->address->city;
        $this->state = old('state') ?? @$user->address->state;
        $this->zip = old('zip') ?? @$user->address->zip;
        $this->country = old('country') ?? @$user->address->country;
    }

    public function updateSummary()
    {
        $trx = $this->trx;
        $total = $trx->amount;

        $tax = null;
        if (!$trx->isTypeDeposit() && $this->country) {
            $tax = Tax::whereJsonContains('countries', $this->country)->first();

            if ($tax) {
                $taxRate = $tax->rate;
                $taxAmount = ($total * $taxRate) / 100;

                $tax = [
                    'name' => $tax->name,
                    'rate' => $taxRate,
                    'amount' => getAmount(round($taxAmount, 2)),
                ];

                $total = round($total + $taxAmount, 2);
            }
        }

        $gateway = null;
        if ($this->payment_method) {

            $paymentGateway = PaymentGateway::where('alias', $this->payment_method)
                ->active()->first();

            if ($paymentGateway && !$paymentGateway->isWallet()) {
                $gatewayFees = $paymentGateway->fees;

                if ($gatewayFees > 0) {
                    $feesAmount = ($total * $gatewayFees) / 100;

                    $gateway = [
                        'name' => $paymentGateway->name,
                        'fees' => $gatewayFees,
                        'amount' => getAmount(round($feesAmount, 2)),
                    ];

                    $total = round($total + $feesAmount, 2);
                }
            }
        }

        $this->summary = [
            'tax' => $tax,
            'gateway' => $gateway,
            'total' => $total,
        ];
    }

    public function render()
    {
        $this->updateSummary();

        $paymentGateways = PaymentGateway::forTrx($this->trx)->active()->get();

        return theme_view('livewire.checkout', [
            'paymentGateways' => $paymentGateways,
        ]);
    }
}
