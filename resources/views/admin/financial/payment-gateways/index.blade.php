@extends('admin.layouts.grid')
@section('section', translate('Financial'))
@section('title', translate('Payment Gateways'))
@section('content')
    <div class="card">
        <div class="card-header p-3 border-bottom-small">
            <form class="multiple-select-search-form" action="{{ request()->url() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-8">
                        <input type="text" name="search" class="form-control" placeholder="{{ translate('Search...') }}"
                            value="{{ request()->input('search') ?? '' }}">
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="status" class="form-select selectpicker" title="{{ translate('Status') }}">
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>
                                {{ translate('Active') }}
                            </option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>
                                {{ translate('Disabled') }}</option>
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
            <div class="table-responsive">
                <table class="table sortable-table w-100">
                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-hashtag"></i></th>
                            <th>{{ translate('Logo') }}</th>
                            <th>{{ translate('Name') }}</th>
                            <th class="text-center">{{ translate('Fees') }}</th>
                            <th class="text-center">{{ translate('Status') }}</th>
                            <th class="text-end">{{ translate('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="sortable-table-tbody">
                        @forelse ($paymentGateways as $paymentGateway)
                            <tr data-id="{{ $paymentGateway->id }}">
                                <td>
                                    <span class="sortable-table-handle me-2 text-muted">
                                        <i class="fas fa-arrows-alt fa-lg"></i>
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.financial.payment-gateways.edit', $paymentGateway->id) }}">
                                        <img src="{{ asset($paymentGateway->logo) }}" alt="{{ $paymentGateway->name }}"
                                            width="100px">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.financial.payment-gateways.edit', $paymentGateway->id) }}"
                                        class="text-dark">
                                        {{ $paymentGateway->name }}
                                    </a>
                                    {!! addonBadge($paymentGateway->alias) !!}
                                </td>
                                <td class="text-center">
                                    {{ !$paymentGateway->isWallet() ? $paymentGateway->fees . '%' : '--' }}</td>
                                <td class="text-center">
                                    @if ($paymentGateway->isActive())
                                        <span class="badge bg-success">{{ translate('Active') }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ translate('Disabled') }}</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.financial.payment-gateways.edit', $paymentGateway->id) }}"
                                        class="btn btn-secondary">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="p-3 text-center text-muted">
                                        {{ translate('Not data found') }}
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('top_scripts')
        <script>
            const sortingRoute = "{{ route('admin.financial.payment-gateways.sortable') }}";
        </script>
    @endpush
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
        <link href="{{ asset('vendor/libs/jquery/jquery-ui.min.css') }}" />
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/jquery/jquery-ui.min.js') }}"></script>
    @endpush
@endsection
