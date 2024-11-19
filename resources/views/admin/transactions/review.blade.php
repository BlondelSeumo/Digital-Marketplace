@extends('admin.layouts.grid')
@section('title', translate('Transaction #:transaction_id', ['transaction_id' => $trx->id]))
@section('back', route('admin.transactions.index'))
@section('container', 'container-max-md')
@section('content')
    @if (!$trx->isCancelled())
        <div class="card mb-3">
            <div class="card-body p-4">
                <div class="row g-3">
                    @if ($trx->isPending())
                        <div class="col">
                            <form action="{{ route('admin.transactions.paid', $trx->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-outline-success btn-md action-confirm w-100">
                                    <i class="fa-solid fa-check me-1"></i>
                                    <span>{{ translate('Paid') }}</span>
                                </button>
                            </form>
                        </div>
                    @endif
                    <div class="col">
                        <button id="trxCancelButton" type="button" class="btn btn-outline-danger btn-md w-100">
                            <i class="fa-solid fa-xmark me-1"></i>
                            <span>{{ translate('Cancel') }}</span>
                        </button>
                    </div>
                    <div id="trxCancelForm" class="col-12" style="display: none;">
                        <form action="{{ route('admin.transactions.cancel', $trx->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">{{ translate('Cancellation Reason') }}</label>
                                <textarea name="cancellation_reason" class="form-control" rows="6" required></textarea>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="email_notification" class="form-check-input">
                                <label class="form-check-label">{{ translate('Send Email Notification') }}</label>
                            </div>
                            <button class="btn btn-danger btn-lg px-5 action-confirm">
                                <span>{{ translate('Submit') }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($trx->payment_proof)
        <div class="card mb-3">
            <div class="card-body p-4">
                <a href="{{ route('admin.transactions.payment-proof', $trx->id) }}" target="_blank"
                    class="btn btn-outline-primary btn-md w-100">
                    <i class="fa-solid fa-arrow-up-right-from-square me-1"></i>
                    {{ translate('View Payment Proof') }}
                </a>
            </div>
        </div>
    @endif
    <div class="card mb-3">
        <ul class="list-group list-group-flush">
            <li class="list-group-item  p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('User') }}</strong>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.members.users.edit', $trx->user->id) }}" class="text-dark">
                            <i class="fa fa-user me-2"></i>
                            {{ $trx->user->username }}
                        </a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
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
                            <div class="badge bg-orange">
                                {{ $trx->getStatusName() }}
                            </div>
                        @elseif($trx->isPaid())
                            <div class="badge bg-green">
                                {{ $trx->getStatusName() }}
                            </div>
                        @elseif($trx->isCancelled())
                            <div class="badge bg-red">
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
                        <strong>{{ translate('Payment Gateway') }}</strong>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.financial.payment-gateways.edit', $trx->paymentGateway->id) }}"
                            class="text-dark">
                            <span>{{ $trx->paymentGateway->name }}</span>
                        </a>
                    </div>
                </div>
            </li>
            @if ($trx->purchase)
                <li class="list-group-item  p-4">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <strong>{{ translate('Purchase ID') }}</strong>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.records.purchases.show', $trx->purchase->id) }}">
                                <span>#{{ $trx->purchase->id }}</span>
                            </a>
                        </div>
                    </div>
                </li>
            @endif
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
                            <h6>{{ getAmount($trx->amount) }}</h6>
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
                                <h6 class="fw-light">{{ getAmount($trx->tax->amount) }}</h6>
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
                                <h6 class="fw-light">{{ getAmount($trx->fees) }}</h6>
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
    @push('scripts')
        <script>
            "use strict";
            let trxCancelButton = $('#trxCancelButton'),
                trxCancelForm = $('#trxCancelForm');
            trxCancelButton.on('click', function() {
                trxCancelForm.toggle();
            })
        </script>
    @endpush
@endsection
