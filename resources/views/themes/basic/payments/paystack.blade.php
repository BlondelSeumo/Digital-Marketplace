@extends('themes.basic.layouts.single')
@section('noindex', true)
@section('section', translate('Checkout'))
@section('header_title', translate('Complete the payment'))
@section('title', translate('Complete the payment'))
@section('body_bg', 'bg-white')
@section('breadcrumbs', Breadcrumbs::render('checkout', $trx))
@section('header_v3', true)
@section('content')
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="box bg-color">
                <h6 class="fs-4 mb-4">{{ translate('Payment details') }}</h6>
                <ul class="list-group list-group-flush mb-4">
                    @if ($trx->hasTax() || $trx->hasFees())
                        <li class="list-group-item d-flex justify-content-between p-3 bg-color">
                            <strong>{{ translate('SubTotal') }}</strong>
                            <span>{{ getAmount($trx->amount) }}</span>
                        </li>
                        @if ($trx->hasTax())
                            <li class="list-group-item d-flex justify-content-between p-3 bg-color">
                                <strong>{{ translate(':tax_name (:tax_rate%)', [
                                    'tax_name' => $trx->tax->name,
                                    'tax_rate' => $trx->tax->rate,
                                ]) }}</strong>
                                <span>{{ getAmount($trx->tax->amount) }}</span>
                            </li>
                        @endif
                        @if ($trx->hasFees())
                            <li class="list-group-item d-flex justify-content-between p-3 bg-color">
                                <strong>{{ translate(':payment_gateway Fees (:percentage%)', [
                                    'payment_gateway' => $trx->paymentGateway->name,
                                    'percentage' => $trx->paymentGateway->fees,
                                ]) }}</strong>
                                <span>{{ getAmount($trx->fees) }}</span>
                            </li>
                        @endif
                    @endif
                    <li class="list-group-item d-flex justify-content-between p-3 bg-color">
                        <h3 class="mb-0">{{ translate('Total') }}</h3>
                        <h3 class="mb-0">{{ getAmount($trx->total) }}</h3>
                    </li>
                </ul>
                <form action="{{ route('payments.ipn.paystack') }}" method="POST">
                    @csrf
                    <button type="button" class="btn btn-primary btn-md w-100"
                        id="btn-confirm">{{ translate('Pay Now') }}</button>
                    <script src="//js.paystack.co/v1/inline.js" data-key="{{ $data->key }}" data-email="{{ $data->email }}"
                        data-amount="{{ round($data->amount) }}" data-currency="{{ $data->currency }}" data-ref="{{ $data->ref }}"
                        data-custom-button="btn-confirm"></script>
                </form>
                <a href="{{ route('checkout.index', hash_encode($trx->id)) }}"
                    class="btn btn-outline-primary btn-md w-100 mt-3">
                    {{ translate('Cancel Payment') }}
                </a>
            </div>
        </div>
    </div>
@endsection
