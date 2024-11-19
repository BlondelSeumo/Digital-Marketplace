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
            <div class="box bg-color mb-3">
                <h6 class="fs-4 mb-4">{{ translate('Payment details') }}</h6>
                <ul class="list-group list-group-flush">
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
            </div>
            <div class="box bg-color mb-3">
                <h6 class="fs-4 mb-4">{{ translate('Instructions') }}</h6>
                <div>
                    {!! $trx->paymentGateway->instructions !!}
                </div>
            </div>
            <div class="box bg-color">
                <h6 class="fs-4 mb-4">{{ translate('Payment proof') }}</h6>
                <p class="mb-4">
                    {{ translate('Choose payment Proof (Receipt, Bank statement, etc..), allowed file types (jpg, jpeg, png, pdf) in max size 2MB.') }}
                </p>
                <form action="{{ route('payments.manual.bankwire') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="checkout_id" value="{{ hash_encode($trx->id) }}">
                    <div class="mb-4">
                        <input type="file" name="payment_proof" class="form-control form-control-md"
                            accept="image/jpg, image/jpeg, image/png, application/pdf" required>
                    </div>
                    <button class="btn btn-primary btn-md w-100">{{ translate('Submit') }}</button>
                </form>
                <a href="{{ route('checkout.index', hash_encode($trx->id)) }}"
                    class="btn btn-outline-primary btn-md w-100 mt-3">
                    {{ translate('Cancel Payment') }}
                </a>
            </div>
        </div>
    </div>
@endsection
