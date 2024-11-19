@extends('admin.layouts.grid')
@section('title', translate('Transactions'))
@section('container', 'container-max-xxl')
@section('content')
    <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-3 g-3 mb-4">
        <div class="col">
            <div class="vironeer-counter-card bg-orange">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-regular fa-hourglass-half"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Pending') }}
                        ({{ numberFormat($counters['pending']['total']) }})</p>
                    <p class="vironeer-counter-card-number">{{ getAmount($counters['pending']['amount']) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-green">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Paid') }}
                        ({{ numberFormat($counters['paid']['total']) }})</p>
                    <p class="vironeer-counter-card-number">{{ getAmount($counters['paid']['amount']) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-red">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-xmark"></i>
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
            <form action="{{ request()->url() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12">
                        <input type="text" name="search" class="form-control"
                            placeholder="{{ translate('Search...') }}" value="{{ request('search') ?? '' }}">
                    </div>
                    <div class="col-12 col-lg-3">
                        <input type="text" name="date_from" class="form-control text-secondary"
                            placeholder="{{ translate('From Date') }}" onfocus="(this.type='date')"
                            onblur="(this.type='text')" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-12 col-lg-3">
                        <input type="text" name="date_to" class="form-control text-secondary"
                            placeholder="{{ translate('To Date') }}" onfocus="(this.type='date')"
                            onblur="(this.type='text')" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="payment_method" class="form-select selectpicker"
                            title="{{ translate('Payment Method') }}" data-live-search="true">
                            @foreach ($paymentGateways as $paymentGateway)
                                <option value="{{ $paymentGateway->id }}" @selected(request('payment_method') == $paymentGateway->id)>
                                    {{ $paymentGateway->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="status" class="form-select selectpicker" title="{{ translate('Status') }}">
                            @foreach (\App\Models\Transaction::getStatusOptions() as $key => $value)
                                <option value="{{ $key }}" @selected($key == request('status'))>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
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
            @if ($transactions->count() > 0)
                <div class="table-responsive">
                    <table class="vironeer-normal-table table w-100">
                        <thead>
                            <tr class="bg-light">
                                <th>{{ translate('ID') }}</th>
                                <th>{{ translate('User') }}</th>
                                <th class="text-center">{{ translate('SubTotal') }}</th>
                                <th class="text-center">{{ translate('Tax') }}</th>
                                <th class="text-center">{{ translate('Fees') }}</th>
                                <th class="text-center">{{ translate('Total') }}</th>
                                <th class="text-center">{{ translate('Type') }}</th>
                                <th class="text-center">{{ translate('Status') }}</th>
                                <th class="text-center">{{ translate('Date') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $trx)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.transactions.review', $trx->id) }}">
                                            <i class="fa-solid fa-hashtag"></i>
                                            {{ $trx->id }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.members.users.edit', $trx->user->id) }}"
                                            class="text-dark">
                                            <i class="fa fa-user me-2"></i>
                                            {{ $trx->user->username }}
                                        </a>
                                    </td>
                                    <td class="text-center text-dark">{{ getAmount($trx->amount) }}</td>
                                    <td class="text-center text-dark">
                                        {{ getAmount($trx->hasTax() ? $trx->tax->amount : 0) }}
                                    </td>
                                    <td class="text-center text-dark">{{ getAmount($trx->fees) }}</td>
                                    <td class="text-center text-dark"><strong>{{ getAmount($trx->total) }}</strong></td>
                                    <td class="text-center text-dark">
                                        {{ $trx->getTypeName() }}
                                    </td>
                                    <td class="text-center">
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
                                    </td>
                                    <td class="text-center">{{ dateFormat($trx->created_at) }}</td>
                                    <td>
                                        <div class="text-end">
                                            <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                                aria-expanded="true">
                                                <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-sm-end"
                                                data-popper-placement="bottom-end">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.transactions.review', $trx->id) }}"><i
                                                            class="fa-solid fa-desktop me-2"></i>{{ translate('Details') }}</a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.transactions.destroy', $trx->id) }}"
                                                        method="POST">
                                                        @csrf @method('DELETE')
                                                        <button class="dropdown-item action-confirm text-danger"><i
                                                                class="far fa-trash-alt me-2"></i>{{ translate('Delete') }}</button>
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
            @else
                @include('admin.partials.empty', ['empty_classes' => 'empty-lg'])
            @endif
        </div>
    </div>
    {{ $transactions->links() }}
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
