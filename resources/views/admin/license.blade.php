@extends('admin.layouts.grid')
@section('title', translate('License Verification'))
@section('container', 'container-max-md')
@section('content')
    <div class="card">
        <div class="card-body p-4">
            <h3 class="mb-3">{{ translate('License Verification') }}</h3>
            <p class="text-muted">
                {{ translate('You can use this tool to verify license codes after receiving them from your buyers.') }}
            </p>
            <form action="{{ route('admin.license-verification') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="text" name="purchase_code" class="form-control form-control-md"
                        placeholder="{{ translate('Enter purchase code') }}" value="{{ old('purchase_code') }}" required
                        autofocus>
                </div>
                <button class="btn btn-primary btn-md px-4">{{ translate('Verify') }}</button>
            </form>
        </div>
    </div>
    @php
        $purchase = session('purchase');
    @endphp
    @if ($purchase)
        <div class="card mt-4">
            <ul class="list-group list-group-flush">
                <li class="list-group-item p-4">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <strong>{{ translate('Purchase ID') }}</strong>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.records.purchases.show', $purchase->id) }}"
                                target="_blank">#{{ $purchase->id }}</a>
                        </div>
                    </div>
                </li>
                <li class="list-group-item p-4">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <strong>{{ translate('Item') }}</strong>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.items.edit', $purchase->item->id) }}" target="_blank"
                                class="text-dark">
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
                            <a href="{{ route('admin.members.users.edit', $purchase->user->id) }}" target="_blank"
                                class="text-dark">
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
    @endif
@endsection
