@extends('admin.layouts.grid')
@section('section', translate('Records'))
@section('title', translate('Sales'))
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
                    <p class="vironeer-counter-card-title">{{ translate('Active') }}
                        ({{ numberFormat($counters['active']['total']) }})</p>
                    <p class="vironeer-counter-card-number">{{ getAmount($counters['active']['amount']) }}</p>
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
                    <p class="vironeer-counter-card-title">{{ translate('Refunded') }}
                        ({{ numberFormat($counters['refunded']['total']) }})</p>
                    <p class="vironeer-counter-card-number">{{ getAmount($counters['refunded']['amount']) }}</p>
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
                    <p class="vironeer-counter-card-title">{{ translate('Cancelled') }}
                        ({{ numberFormat($counters['cancelled']['total']) }})</p>
                    <p class="vironeer-counter-card-number">{{ getAmount($counters['cancelled']['amount']) }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header p-3 border-bottom-small">
            <form action="{{ url()->current() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-6">
                        <input type="text" name="search" class="form-control"
                            placeholder="{{ translate('Search...') }}" value="{{ request('search') ?? '' }}">
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
            @if ($sales->count() > 0)
                <div class="overflow-hidden">
                    <div class="table-custom-container">
                        <table class="table-custom table">
                            <thead>
                                <tr class="bg-light">
                                    <th>{{ translate('ID') }}</th>
                                    <th>{{ translate('Item') }}</th>
                                    <th>{{ translate('Buyer') }}</th>
                                    <th class="text-center">{{ translate('Price') }}</th>
                                    <th class="text-center">{{ translate('Status') }}</th>
                                    <th class="text-center">{{ translate('Date') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.records.sales.show', $sale->id) }}"><i
                                                    class="fa-solid fa-hashtag me-1"></i>{{ $sale->id }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.items.edit', $sale->item->id) }}" class="text-dark">
                                                <i class="fa-solid fa-up-right-from-square me-1"></i>
                                                {{ shorterText($sale->item->name, 40) }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.members.users.edit', $sale->user->id) }}"
                                                class="text-dark">
                                                <i class="fa-regular fa-user me-1"></i>
                                                {{ $sale->user->username }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <strong>{{ getAmount($sale->price) }}</strong>
                                        </td>
                                        <td class="text-center">
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
                                        </td>
                                        <td class="text-center">{{ dateFormat($sale->created_at) }}</td>
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
                                                            href="{{ route('admin.records.sales.show', $sale->id) }}">
                                                            <i class="fa-solid fa-desktop me-1"></i>
                                                            {{ translate('Details') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.records.purchases.show', $sale->purchase->id) }}"
                                                            target="_blank">
                                                            <i class="fa-solid fa-up-right-from-square me-1"></i>
                                                            {{ translate('View Purchase') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider" />
                                                    </li>
                                                    <li>
                                                        <form
                                                            action="{{ route('admin.records.sales.destroy', $sale->id) }}"
                                                            method="POST">
                                                            @csrf @method('DELETE')
                                                            <button class="action-confirm dropdown-item text-danger">
                                                                <i class="far fa-trash-alt me-1"></i>
                                                                {{ translate('Delete') }}
                                                            </button>
                                                        </form>
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
    {{ $sales->links() }}
@endsection
