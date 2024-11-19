@extends('admin.layouts.grid')
@section('title', $item->name)
@section('item_view', true)
@section('back', route('admin.items.index'))
@section('content')
    <div class="dashboard-tabs">
        @include('admin.items.includes.tabs-nav')
        <div class="dashboard-tabs-content">
            @if ($item->hasDiscount())
                <div class="card">
                    @php
                        $discount = $item->discount;
                    @endphp
                    <div class="overflow-hidden">
                        <div class="table-custom-container">
                            <table class="table-custom table">
                                <thead>
                                    <tr>
                                        <th class="text-start">{{ translate('Regular') }}</th>
                                        @if ($discount->withExtended())
                                            <th class="text-start">{{ translate('Extended') }}</th>
                                        @endif
                                        <th class="text-center">{{ translate('Starting at') }}</th>
                                        <th class="text-center">{{ translate('Ending at') }}</th>
                                        <th class="text-center">{{ translate('Status') }}</th>
                                        <th class="text-center">{{ translate('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-start">
                                            <div class="table-price mb-2">
                                                <div class="row g-3">
                                                    <div class="col-lg-12">
                                                        <div
                                                            class="row row-cols-auto align-items-center justify-content-between flex-nowrap">
                                                            <div class="col">
                                                                <h6 class="mb-0 text-dark">
                                                                    {{ translate('Discount') }}
                                                                </h6>
                                                            </div>
                                                            <div class="col">
                                                                <div class="item-price">
                                                                    <span class="item-price-number small">
                                                                        {{ $discount->regular_percentage }}%
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div
                                                            class="row row-cols-auto align-items-center justify-content-between flex-nowrap">
                                                            <div class="col">
                                                                <h6 class="mb-0 text-dark">
                                                                    {{ translate('Purchase Price') }}
                                                                </h6>
                                                            </div>
                                                            <div class="col">
                                                                <div class="item-price">
                                                                    <span class="item-price-through small">
                                                                        {{ getAmount($item->getRegularPrice(), 0) }}
                                                                    </span>
                                                                    <span class="item-price-number small">
                                                                        {{ getAmount($discount->getRegularPrice(), 0) }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        @if ($discount->withExtended())
                                            <td class="text-start">
                                                <div class="table-price mb-2">
                                                    <div class="row g-3">
                                                        <div class="col-lg-12">
                                                            <div
                                                                class="row row-cols-auto align-items-center justify-content-between flex-nowrap">
                                                                <div class="col">
                                                                    <h6 class="mb-0 text-dark">
                                                                        {{ translate('Discount') }}
                                                                    </h6>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="item-price">
                                                                        <span class="item-price-number small">
                                                                            {{ $discount->extended_percentage }}%
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div
                                                                class="row row-cols-auto align-items-center justify-content-between flex-nowrap">
                                                                <div class="col">
                                                                    <h6 class="mb-0 text-dark">
                                                                        {{ translate('Purchase Price') }}
                                                                    </h6>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="item-price">
                                                                        <span class="item-price-through small">
                                                                            {{ getAmount($item->getExtendedPrice(), 0) }}
                                                                        </span>
                                                                        <span class="item-price-number small">
                                                                            {{ getAmount($discount->getExtendedPrice(), 0) }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                        <td class="text-center">{{ dateFormat($discount->starting_at, 'd M Y') }}</td>
                                        <td class="text-center">{{ dateFormat($discount->ending_at, 'd M Y') }}</td>
                                        <td class="text-center">
                                            @if ($discount->isActive())
                                                <div class="badge bg-green rounded-3 fw-light px-3 py-2">
                                                    {{ translate('Active') }}
                                                </div>
                                            @else
                                                <div class="badge bg-gray rounded-3 fw-light px-3 py-2">
                                                    {{ translate('Inactive') }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('admin.items.discount.delete', $item->id) }}"
                                                method="POST">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-padding action-confirm">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <form action="{{ route('admin.items.discount.store', $item->id) }}" method="POST">
                    @csrf
                    <div class="card p-0 mb-4">
                        <div class="card-header border-bottom py-3 px-4">
                            <h5 class="mb-0">{{ translate('Regular License discount') }}</h5>
                        </div>
                        <div class="card-body p-4">
                            <p class="mb-3">
                                <i class="fa-regular fa-circle-question me-1"></i>
                                <span>{{ translate('The maximum discount percentage is 90%') }}</span>
                            </p>
                            <div class="row g-4 mb-2">
                                <div class="col-12 col-lg-4">
                                    @include('admin.partials.input-price', [
                                        'label' => translate('Regular License Price'),
                                        'id' => 'regular-license-price',
                                        'input_class' => 'form-control-md',
                                        'value' => $item->regular_price,
                                        'disabled' => true,
                                    ])
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label class="form-label">
                                        {{ translate('Discount Percentage') }}
                                    </label>
                                    <div class="input-group">
                                        <input id="regular-license-percentage" type="number" name="regular_percentage"
                                            placeholder="0" min="1"
                                            max="{{ @$settings->item->discount_max_percentage }}"
                                            class="form-control form-control-md border-success" required>
                                        <span class="input-group-text px-4 bg-success text-white border-success">%</span>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    @include('admin.partials.input-price', [
                                        'label' => translate('Purchase price'),
                                        'id' => 'regular-license-purchase-price',
                                        'input_class' => 'form-control-md',
                                        'value' => 0,
                                        'disabled' => true,
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($item->hasExtendedLicense())
                        <div class="card p-0 mb-4">
                            <div class="card-header border-bottom py-3 px-4">
                                <h5 class="mb-0">{{ translate('Extended License discount (Optional)') }}
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <p class="mb-3">
                                    <i class="fa-regular fa-circle-question me-1"></i>
                                    <span>{{ translate('The maximum discount percentage is 90%') }}</span>
                                </p>
                                <div class="row g-4 mb-2">
                                    <div class="col-12 col-lg-4">
                                        @include('admin.partials.input-price', [
                                            'label' => translate('Extended License Price'),
                                            'id' => 'extended-license-price',
                                            'input_class' => 'form-control-md',
                                            'value' => $item->extended_price,
                                            'disabled' => true,
                                        ])
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label class="form-label">
                                            {{ translate('Discount Percentage') }}
                                        </label>
                                        <div class="input-group">
                                            <input id="extended-license-percentage" type="number"
                                                name="extended_percentage" placeholder="0" min="1"
                                                class="form-control form-control-md border-success">
                                            <span
                                                class="input-group-text px-4 bg-success text-white border-success">%</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        @include('admin.partials.input-price', [
                                            'label' => translate('Purchase price'),
                                            'id' => 'extended-license-purchase-price',
                                            'input_class' => 'form-control-md',
                                            'value' => 0,
                                            'disabled' => true,
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card p-0 mb-4">
                        <div class="card-header border-bottom py-3 px-4">
                            <h5 class="mb-0">{{ translate('Discount Period') }}</h5>
                        </div>
                        <div class="card-body p-4">
                            <p class="mb-2">
                                <i class="fa-regular fa-circle-question me-1"></i>
                                <span>{{ translate('The starting date cannot be in the past') }}</span>
                            </p>
                            <div class="row g-3 align-items-center">
                                <div class="col-12 col-lg">
                                    <input type="date" name="starting_date" class="form-control form-control-md"
                                        value="{{ old('starting_date') }}" required>
                                </div>
                                <div class="col-1 col-lg-1">
                                    <div class="text-center">{{ translate('to') }}</div>
                                </div>
                                <div class="col-10 col-lg">
                                    <input type="date" name="ending_date" class="form-control form-control-md"
                                        value="{{ old('ending_date') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body p-4">
                            <button
                                class="btn btn-primary btn-md action-confirm">{{ translate('Create a discount') }}</button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
    @if (!$item->hasDiscount())
        @push('scripts_libs')
            <script src="{{ asset('vendor/admin/js/item.js') }}"></script>
        @endpush
    @endif
@endsection
