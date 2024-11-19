@extends('admin.layouts.grid')
@section('section', translate('Records'))
@section('title', translate('Support Earnings #:support_earning_id', ['support_earning_id' => $supportEarning->id]))
@section('back', route('admin.records.support-earnings.index'))
@section('container', 'container-max-md')
@section('content')
    <div class="card mb-3">
        <ul class="list-group list-group-flush">
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('ID') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span>#{{ $supportEarning->id }}</span>
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Name') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span>{{ $supportEarning->name }}</span>
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Title') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span>{{ $supportEarning->title }}</span>
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Days') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span>{{ $supportEarning->days }}</span>
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Support Expiry Date') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span>{{ dateFormat($supportEarning->support_expiry_at) }}</span>
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Price') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span>{{ getAmount($supportEarning->price) }}</span>
                    </div>
                </div>
            </li>
            @if ($supportEarning->tax)
                <li class="list-group-item p-4">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <strong>{{ translate(':tax_name (:tax_rate%)', [
                                'tax_name' => $supportEarning->tax->name,
                                'tax_rate' => $supportEarning->tax->rate,
                            ]) }}</strong>
                        </div>
                        <div class="col-auto">
                            <span class="text-danger">{{ getAmount($supportEarning->tax->amount) }}</span>
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
                        <strong class="text-success">{{ getAmount($supportEarning->total) }}</strong>
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Status') }}</strong>
                    </div>
                    <div class="col-auto">
                        @if ($supportEarning->isActive())
                            <div class="badge bg-green">
                                {{ translate('Active') }}
                            </div>
                        @elseif($supportEarning->isRefunded())
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
                        <strong>{{ translate('Date') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span>{{ dateFormat($supportEarning->created_at) }}</span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="card">
        <div class="card-body">
            <a class="btn btn-outline-secondary btn-lg w-100"
                href="{{ route('admin.records.purchases.show', $supportEarning->purchase->id) }}" target="_blank">
                <i class="fa-solid fa-up-right-from-square me-1"></i>
                {{ translate('View Purchase') }}
            </a>
        </div>
    </div>
@endsection
