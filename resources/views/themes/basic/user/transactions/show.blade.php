@extends('themes.basic.user.layouts.app')
@section('section', translate('Transactions'))
@section('title', translate('Invoice #:number', ['number' => $trx->id]))
@section('back', route('user.transactions.index'))
@section('breadcrumbs', Breadcrumbs::render('user.transactions.show', $trx))
@section('container', 'dashboard-container-sm')
@section('content')
    <div class="card mb-3">
        <ul class="list-group list-group-flush">
            <li class="list-group-item  p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Transaction ID') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span>#{{ $trx->id }}</span>
                    </div>
                </div>
            </li>
            <li class="list-group-item  p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Transaction Date') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span>{{ dateFormat($trx->created_at) }}</span>
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Transaction Status') }}</strong>
                    </div>
                    <div class="col-auto">
                        @if ($trx->isPending())
                            <div class="badge bg-orange rounded-2 fw-light px-3 py-2">
                                {{ $trx->getStatusName() }}
                            </div>
                        @elseif($trx->isPaid())
                            <div class="badge bg-green rounded-2 fw-light px-3 py-2">
                                {{ $trx->getStatusName() }}
                            </div>
                        @elseif($trx->isCancelled())
                            <div class="badge bg-red rounded-2 fw-light px-3 py-2">
                                {{ $trx->getStatusName() }}
                            </div>
                        @endif
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Transaction Type') }}</strong>
                    </div>
                    <div class="col-auto">{{ $trx->getTypeName() }}</div>
                </div>
            </li>
            @if ($trx->isCancelled() && $trx->cancellation_reason)
                <li class="list-group-item p-4">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <strong>{{ translate('Cancellation reason') }}</strong>
                        </div>
                        <div class="col-auto">
                            <i class="text-muted">{{ $trx->cancellation_reason }}</i>
                        </div>
                    </div>
                </li>
            @endif
            <li class="list-group-item  p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Payment Method') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span>{{ $trx->paymentGateway->name }}</span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="card mb-3">
        <ul class="list-group list-group-flush">
            @if ($trx->isTypePurchase())
                @foreach ($trx->trxItems as $trxItem)
                    @php
                        $item = $trxItem->item;
                        $licenseType = $trxItem->isLicenseTypeRegular()
                            ? translate('Regular License')
                            : translate('Extended License');
                    @endphp
                    <li class="list-group-item p-4">
                        <div class="row g-2 align-items-center">
                            <div class="col">
                                <div class="mb-1">
                                    <strong>{{ $item->name }}</strong>
                                    <span>({{ $licenseType }})</span>
                                </div>
                                <div>({{ getAmount($trxItem->price) . ' x ' . $trxItem->quantity }})</div>
                            </div>
                            <div class="col-auto">
                                <h6 class="fw-light mb-0">{{ getAmount($trxItem->total) }}</h6>
                            </div>
                        </div>
                        @if ($trxItem->support)
                            <div class="row g-2 align-items-center mt-2">
                                <div class="col">
                                    <div>
                                        {{ $trxItem->support->title }}
                                        @if ($trxItem->support->total)
                                            ({{ getAmount($trxItem->support->price) . ' x ' . $trxItem->support->quantity }})
                                        @endif
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <h6 class="fw-light mb-0">
                                        {{ getAmount($trxItem->support->total) }}
                                    </h6>
                                </div>
                            </div>
                        @endif
                    </li>
                @endforeach
            @elseif($trx->isTypeSupportPurchase() || $trx->isTypeSupportExtend())
                <li class="list-group-item p-4">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <div>
                                <strong>{{ $trx->support->title }}</strong>
                                @if ($trx->support->total)
                                    ({{ getAmount($trx->support->price) . ' x ' . $trx->support->quantity }})
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <h6 class="fw-light mb-0">
                                {{ getAmount($trx->support->total) }}
                            </h6>
                        </div>
                    </div>
                </li>
            @elseif($trx->isTypeDeposit())
                <li class="list-group-item p-4">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <strong>{{ translate('Deposit to account balance') }}</strong>
                        </div>
                        <div class="col-auto">
                            <h6 class="fw-light mb-0">{{ getAmount($trx->amount) }}</h6>
                        </div>
                    </div>
                </li>
            @elseif($trx->isTypeSubscription())
                <li class="list-group-item p-4">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <strong>{{ translate('Subscription - :plan_name (:plan_interval)', [
                                'plan_name' => $trx->plan->name,
                                'plan_interval' => $trx->plan->getIntervalName(),
                            ]) }}</strong>
                        </div>
                        <div class="col-auto">
                            <h6 class="fw-light mb-0">{{ getAmount($trx->amount) }}</h6>
                        </div>
                    </div>
                </li>
            @endif
        </ul>
    </div>
    <div class="card">
        <ul class="list-group list-group-flush">
            @if ($trx->hasFees() || $trx->hasTax())
                <li class="list-group-item  p-4">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <strong>{{ translate('SubTotal') }}</strong>
                        </div>
                        <div class="col-auto">
                            <h6 class="mb-0">{{ getAmount($trx->amount) }}</h6>
                        </div>
                    </div>
                </li>
                @if ($trx->hasTax())
                    <li class="list-group-item p-4">
                        <div class="row g-2 align-items-center">
                            <div class="col">
                                <strong>{{ translate(':tax_name (:tax_rate%)', [
                                    'tax_name' => $trx->tax->name,
                                    'tax_rate' => $trx->tax->rate,
                                ]) }}</strong>
                            </div>
                            <div class="col-auto">
                                <h6 class="fw-light mb-0">{{ getAmount($trx->tax->amount) }}</h6>
                            </div>
                        </div>
                    </li>
                @endif
                @if ($trx->hasFees())
                    <li class="list-group-item p-4">
                        <div class="row g-2 align-items-center">
                            <div class="col">
                                <strong>{{ translate(':payment_gateway Fees (:percentage%)', [
                                    'payment_gateway' => $trx->paymentGateway->name,
                                    'percentage' => $trx->paymentGateway->fees,
                                ]) }}</strong>
                            </div>
                            <div class="col-auto">
                                <h6 class="fw-light mb-0">{{ getAmount($trx->fees) }}</h6>
                            </div>
                        </div>
                    </li>
                @endif
            @endif
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h4 class="mb-0">{{ translate('Total') }}</h4>
                    </div>
                    <div class="col-auto">
                        <h4 class="mb-0">{{ getAmount($trx->total) }}</h4>
                    </div>
                </div>
            </li>
        </ul>
    </div>
@endsection
