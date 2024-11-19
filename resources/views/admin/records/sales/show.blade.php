@extends('admin.layouts.grid')
@section('section', translate('Records'))
@section('title', translate('Sale #:sale_id', ['sale_id' => $sale->id]))
@section('back', route('admin.records.sales.index'))
@section('container', 'container-max-md')
@section('content')
    <div class="card mb-3">
        <ul class="list-group list-group-flush">
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Sale ID') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span>#{{ $sale->id }}</span>
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Item') }}</strong>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.items.edit', $sale->item->id) }}" class="text-dark">
                            <i class="fa-solid fa-up-right-from-square me-1"></i>
                            {{ $sale->item->name }}
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
                        @if ($sale->isLicenseTypeRegular())
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
                        <a href="{{ route('admin.members.users.edit', $sale->user->id) }}" class="text-dark">
                            <i class="fa-regular fa-user me-1"></i>
                            {{ $sale->user->username }}
                        </a>
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Price') }}</strong>
                    </div>
                    <div class="col-auto">
                        <strong>{{ getAmount($sale->price) }}</strong>
                    </div>
                </div>
            </li>
            @if ($sale->tax)
                <li class="list-group-item p-4">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <strong>{{ translate(':tax_name (:tax_rate%)', [
                                'tax_name' => $sale->tax->name,
                                'tax_rate' => $sale->tax->rate,
                            ]) }}</strong>
                        </div>
                        <div class="col-auto">
                            <span class="text-danger">{{ getAmount($sale->tax->amount) }}</span>
                        </div>
                    </div>
                </li>
            @endif
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Total') }}</strong>
                    </div>
                    <div class="col-auto">
                        <strong class="text-success">{{ getAmount($sale->total) }}</strong>
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Status') }}</strong>
                    </div>
                    <div class="col-auto">
                        @if ($sale->isActive())
                            <div class="badge bg-green">
                                {{ translate('Active') }}
                            </div>
                        @elseif($sale->isRefunded())
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
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Sale Date') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span>{{ dateFormat($sale->created_at) }}</span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="card">
        <div class="card-body">
            <a class="btn btn-outline-secondary btn-lg w-100"
                href="{{ route('admin.records.purchases.show', $sale->purchase->id) }}" target="_blank">
                <i class="fa-solid fa-up-right-from-square me-1"></i>
                {{ translate('View Purchase') }}
            </a>
            @if ($sale->isActive())
                <div class="mt-3">
                    <form action="{{ route('admin.records.sales.cancel', $sale->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-danger btn-md w-100 action-confirm">
                            <i class="fa-solid fa-xmark me-1"></i>
                            <span>{{ translate('Cancel') }}</span>
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
