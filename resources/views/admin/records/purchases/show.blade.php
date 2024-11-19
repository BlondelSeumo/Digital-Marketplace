@extends('admin.layouts.grid')
@section('section', translate('Records'))
@section('title', translate('Purchase #:purchase_id', ['purchase_id' => $purchase->id]))
@section('back', route('admin.records.purchases.index'))
@section('container', 'container-max-md')
@section('content')
    <div class="card mb-3">
        <ul class="list-group list-group-flush">
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Purchase ID') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span>#{{ $purchase->id }}</span>
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Item') }}</strong>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.items.edit', $purchase->item->id) }}" class="text-dark">
                            <i class="fa-solid fa-up-right-from-square me-1"></i>
                            {{ $purchase->item->name }}
                        </a>
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('License Type') }}</strong>
                    </div>
                    <div class="col-auto">
                        @if ($purchase->isLicenseTypeRegular())
                            <div class="badge bg-gray">
                                {{ translate('Regular') }}
                            </div>
                        @else
                            <div class="badge bg-purple">
                                {{ translate('Extended') }}
                            </div>
                        @endif
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Buyer') }}</strong>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.members.users.edit', $purchase->user->id) }}" class="text-dark">
                            <i class="fa-regular fa-user me-1"></i>
                            {{ $purchase->user->username }}
                        </a>
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Purchase Code') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span>{{ $purchase->code }}</span>
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Downloaded') }}</strong>
                    </div>
                    <div class="col-auto">
                        @if ($purchase->isDownloaded())
                            <div class="badge bg-blue">
                                {{ translate('Yes') }}
                            </div>
                        @else
                            <div class="badge bg-gray">
                                {{ translate('No') }}
                            </div>
                        @endif
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Status') }}</strong>
                    </div>
                    <div class="col-auto">
                        @if ($purchase->isActive())
                            <div class="badge bg-green">
                                {{ translate('Active') }}
                            </div>
                        @elseif($purchase->isRefunded())
                            <div class="badge bg-blue">
                                {{ translate('Refunded') }}
                            </div>
                        @else
                            <div class="badge bg-red">
                                {{ translate('Cancelled') }}
                            </div>
                        @endif
                    </div>
                </div>
            </li>
            @if ($settings->item->support_status)
                <li class="list-group-item p-4">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <strong>{{ translate('Support Expiry Date') }}</strong>
                        </div>
                        <div class="col-auto">
                            <span>{{ $purchase->support_expiry_at ? dateFormat($purchase->support_expiry_at) : '--' }}</span>
                        </div>
                    </div>
                </li>
            @endif
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Purchase Date') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span>{{ dateFormat($purchase->created_at) }}</span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="card">
        <div class="card-body">
            <a class="btn btn-outline-secondary btn-lg w-100"
                href="{{ route('admin.records.sales.show', $purchase->sale->id) }}" target="_blank">
                <i class="fa-solid fa-up-right-from-square me-1"></i>
                {{ translate('View Sale') }}
            </a>
        </div>
    </div>
@endsection
