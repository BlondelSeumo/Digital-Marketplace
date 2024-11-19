@extends('admin.layouts.grid')
@section('section', translate('Records'))
@section('title', translate('Purchases'))
@section('container', 'container-max-xxl')
@section('content')
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-6 col-xxl-4">
            <div class="vironeer-counter-card bg-green">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Active') }}</p>
                    <p class="vironeer-counter-card-number">{{ numberFormat($counters['active']) }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl-4">
            <div class="vironeer-counter-card bg-blue">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-share"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Refunded') }}</p>
                    <p class="vironeer-counter-card-number">{{ numberFormat($counters['refunded']) }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xxl-4">
            <div class="vironeer-counter-card bg-red">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Cancelled') }}</p>
                    <p class="vironeer-counter-card-number">{{ numberFormat($counters['cancelled']) }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header p-3 border-bottom-small">
            <form action="{{ url()->current() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-6">
                        <input type="text" name="search" class="form-control" placeholder="{{ translate('Search...') }}"
                            value="{{ request('search') ?? '' }}">
                    </div>
                    <div class="col-12 col-lg-2">
                        <input type="text" name="date_from" class="form-control text-secondary"
                            placeholder="{{ translate('From Date') }}" onfocus="(this.type='date')"
                            onblur="(this.type='text')" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-12 col-lg-2">
                        <input type="text" name="date_to" class="form-control text-secondary"
                            placeholder="{{ translate('To Date') }}" onfocus="(this.type='date')"
                            onblur="(this.type='text')" value="{{ request('date_to') }}">
                    </div>
                    <div class="col">
                        <button class="btn btn-primary w-100"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="col">
                        <a href="{{ url()->current() }}" class="btn btn-secondary w-100">{{ translate('Reset') }}</a>
                    </div>
                </div>
            </form>
        </div>
        <div>
            @if ($purchases->count() > 0)
                <div class="overflow-hidden">
                    <div class="table-custom-container">
                        <table class="table-custom table">
                            <thead>
                                <tr class="bg-light">
                                    <th>{{ translate('ID') }}</th>
                                    <th>{{ translate('Item') }}</th>
                                    <th class="text-center">{{ translate('License Type') }}</th>
                                    <th class="text-center">{{ translate('Buyer') }}</th>
                                    <th class="text-center">{{ translate('Status') }}</th>
                                    @if ($settings->item->support_status)
                                        <th class="text-center">{{ translate('Support Expiry Date') }}</th>
                                    @endif
                                    <th class="text-center">{{ translate('Date') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchases as $purchase)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.records.purchases.show', $purchase->id) }}"><i
                                                    class="fa-solid fa-hashtag me-1"></i>{{ $purchase->id }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.items.edit', $purchase->item->id) }}"
                                                class="text-dark">
                                                <i class="fa-solid fa-up-right-from-square me-1"></i>
                                                {{ shorterText($purchase->item->name, 40) }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            @if ($purchase->isLicenseTypeRegular())
                                                <div class="badge bg-gray">
                                                    {{ translate('Regular') }}
                                                </div>
                                            @else
                                                <div class="badge bg-purple">
                                                    {{ translate('Extended') }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.members.users.edit', $purchase->user->id) }}"
                                                class="text-dark">
                                                <i class="fa-regular fa-user me-1"></i>
                                                {{ $purchase->user->username }}
                                            </a>
                                        </td>
                                        <td class="text-center">
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
                                        </td>
                                        @if ($settings->item->support_status)
                                            <td class="text-center">
                                                {{ $purchase->support_expiry_at ? dateFormat($purchase->support_expiry_at) : '--' }}
                                            </td>
                                        @endif
                                        <td class="text-center">{{ dateFormat($purchase->created_at) }}</td>
                                        <td>
                                            <div class="text-end">
                                                <button type="button" class="btn btn-sm rounded-3"
                                                    data-bs-toggle="dropdown" aria-expanded="true">
                                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-sm-end"
                                                    data-popper-placement="bottom-end">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.records.purchases.show', $purchase->id) }}">
                                                            <i class="fa-solid fa-desktop me-1"></i>
                                                            {{ translate('Details') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.records.sales.show', $purchase->sale->id) }}"
                                                            target="_blank">
                                                            <i class="fa-solid fa-up-right-from-square me-1"></i>
                                                            {{ translate('View Sale') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                @include('admin.partials.empty', ['empty_classes' => 'empty-lg'])
            @endif
        </div>
    </div>
    {{ $purchases->links() }}
@endsection
