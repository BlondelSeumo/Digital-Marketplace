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
                <form action="{{ route('payments.ipn.razorpay') }}" method="POST">
                    @csrf
                    <input type="hidden" name="trx_id" value="{{ hash_encode($trx->id) }}">
                    <script src="https://checkout.razorpay.com/v1/checkout.js"
                        @foreach ($data as $key => $value) data-{{ $key }}="{{ $value }}" @endforeach></script>
                </form>
                <a href="{{ route('checkout.index', hash_encode($trx->id)) }}"
                    class="btn btn-outline-primary btn-md w-100 mt-3">
                    {{ translate('Cancel Payment') }}
                </a>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            "use strict";
            let razorpayPaymentButton = $('.razorpay-payment-button');
            razorpayPaymentButton.addClass('btn btn-primary btn-md w-100');
        </script>
    @endpush
@endsection
