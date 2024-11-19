@extends('admin.layouts.grid')
@section('title', translate('Items'))
@section('container', 'container-max-xxl')
@section('content')
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-4">
            <div class="vironeer-counter-card bg-c-3">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-circle-play"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Videos') }}</p>
                    <p class="vironeer-counter-card-number">{{ number_format($counters['videos']) }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="vironeer-counter-card bg-c-4">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-volume-high"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Audios') }}</p>
                    <p class="vironeer-counter-card-number">{{ number_format($counters['audios']) }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="vironeer-counter-card bg-secondary">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-box"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Others') }}</p>
                    <p class="vironeer-counter-card-number">{{ number_format($counters['others']) }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header p-3 border-bottom-small">
            <form action="{{ request()->url() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-7">
                        <input type="text" name="search" class="form-control" placeholder="{{ translate('Search...') }}"
                            value="{{ request('search') ?? '' }}">
                    </div>
                    <div class="col-12 col-lg-3">
                        <select name="category" class="form-select selectpicker" title="{{ translate('Category') }}"
                            data-live-search="true">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                    {{ $category->name }}
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
            @if ($items->count() > 0)
                <div class="overflow-hidden">
                    <div class="table-custom-container">
                        <table class="table-custom table">
                            <thead>
                                <tr class="bg-light">
                                    <th>{{ translate('ID') }}</th>
                                    <th>{{ translate('Details') }}</th>
                                    <th>{{ translate('Licenses Price') }}</th>
                                    <th class="text-center">{{ translate('Published Date') }}</th>
                                    <th class="text-center">{{ translate('Last Update') }}</th>
                                    <th class="text-end">{{ translate('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.items.edit', $item->id) }}">
                                                <i class="fa-solid fa-hashtag"></i>
                                                {{ $item->id }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="vironeer-item-box">
                                                <a class="vironeer-item-image"
                                                    href="{{ route('admin.items.edit', $item->id) }}">
                                                    <img src="{{ $item->getThumbnailLink() }}" class="rounded-3"
                                                        alt="{{ $item->name }}">
                                                </a>
                                                <div>
                                                    <a class="text-reset"
                                                        href="{{ route('admin.items.edit', $item->id) }}">{{ $item->name }}</a>
                                                    <nav aria-label="breadcrumb">
                                                        <ol class="breadcrumb m-0 mt-2">
                                                            <li class="breadcrumb-item">
                                                                <a
                                                                    href="{{ route('admin.categories.edit', $item->category->id) }}">{{ $item->category->name }}</a>
                                                            </li>
                                                            @if ($item->subCategory)
                                                                <li class="breadcrumb-item">
                                                                    <a
                                                                        href="{{ route('admin.categories.sub-categories.edit', $item->subCategory->id) }}">{{ $item->subCategory->name }}</a>
                                                                </li>
                                                            @endif
                                                        </ol>
                                                    </nav>
                                                    <div class="mt-2 row row-cols-auto gx-2">
                                                        <div class="col">
                                                            @if ($item->isActive())
                                                                <span class="badge bg-success">
                                                                    {{ $item->getStatusName() }}
                                                                </span>
                                                            @else
                                                                <span class="badge bg-danger">
                                                                    {{ $item->getStatusName() }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        @if ($item->isFeatured())
                                                            <div class="col">
                                                                <span
                                                                    class="badge bg-c-1">{{ translate('Featured') }}</span>
                                                            </div>
                                                        @endif
                                                        @if (licenseType(2) && @$settings->premium->status && $item->isPremium())
                                                            <div class="col">
                                                                <span
                                                                    class="badge bg-warning">{{ translate('Premium') }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            @if ($item->isFree())
                                                <div class="table-price">
                                                    <div
                                                        class="row row-cols-auto align-items-center justify-content-between flex-nowrap">
                                                        <div class="col">
                                                            <h6 class="mb-0 text-dark">
                                                                {{ translate('Free') }}
                                                            </h6>
                                                        </div>
                                                        <div class="col">
                                                            <div class="item-price small">
                                                                <span class="small text-dark">--</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="table-price">
                                                    <div
                                                        class="row row-cols-auto align-items-center justify-content-between flex-nowrap">
                                                        <div class="col">
                                                            <h6 class="mb-0 text-dark">
                                                                {{ translate('Regular') }}
                                                            </h6>
                                                        </div>
                                                        <div class="col">
                                                            <div class="item-price small">
                                                                @if ($item->isOnDiscount())
                                                                    <span class="item-price-through small">
                                                                        {{ getAmount($item->getRegularPrice()) }}
                                                                    </span>
                                                                    <span class="item-price-number small">
                                                                        {{ getAmount($item->price->regular) }}
                                                                    </span>
                                                                @else
                                                                    <span class="small text-dark">
                                                                        {{ getAmount($item->getRegularPrice()) }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($item->hasExtendedLicense())
                                                    <div class="table-price mt-3">
                                                        <div
                                                            class="row row-cols-auto align-items-center justify-content-between flex-nowrap">
                                                            <div class="col">
                                                                <h6 class="mb-0 text-dark">
                                                                    {{ translate('Extended') }}
                                                                </h6>
                                                            </div>
                                                            <div class="col">
                                                                <div class="item-price small">
                                                                    @if ($item->isOnDiscount() && $item->isExtendedOnDiscount())
                                                                        <span class="item-price-through small">
                                                                            {{ getAmount($item->getExtendedPrice()) }}
                                                                        </span>
                                                                        <span class="item-price-number small">
                                                                            {{ getAmount($item->price->extended) }}
                                                                        </span>
                                                                    @else
                                                                        <span class="small text-dark">
                                                                            {{ getAmount($item->getExtendedPrice()) }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            {{ dateFormat($item->created_at) }}
                                        </td>
                                        <td class="text-center">
                                            {{ $item->last_update_at ? dateFormat($item->last_update_at) : '--' }}
                                        </td>
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
                                                            href="{{ route('admin.items.edit', $item->id) }}">
                                                            <i class="fa-solid fa-edit me-1"></i>
                                                            {{ translate('Edit Details') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ $item->getLink() }}"
                                                            target="_blank">
                                                            <i class="fa-solid fa-up-right-from-square me-1"></i>
                                                            {{ translate('View Item') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        @if ($item->isMainFileSourceExternal())
                                                            <a class="dropdown-item" href="{{ $item->main_file }}"
                                                                target="_blank">
                                                                <i class="fa-solid fa-download me-1"></i>
                                                                {{ translate('Download') }}
                                                            </a>
                                                        @else
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.items.download', $item->id) }}">
                                                                <i class="fa-solid fa-download me-1"></i>
                                                                {{ translate('Download') }}
                                                            </a>
                                                        @endif
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider" />
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.records.sales.index', ['item' => $item->id]) }}">
                                                            <i class="fa-solid fa-cart-shopping me-1"></i>
                                                            {{ translate('Sales') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.records.purchases.index', ['item' => $item->id]) }}">
                                                            <i class="fa-solid fa-basket-shopping me-1"></i>
                                                            {{ translate('Purchases') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider" />
                                                    </li>
                                                    <li>
                                                        @if (!$item->isFeatured())
                                                            <form action="{{ route('admin.items.featured', $item->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button class="action-confirm dropdown-item text-success">
                                                                    <i class="fa-solid fa-certificate me-1"></i>
                                                                    {{ translate('Make Featured') }}
                                                                </button>
                                                            </form>
                                                        @else
                                                            <form
                                                                action="{{ route('admin.items.featured.remove', $item->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button class="action-confirm dropdown-item text-danger">
                                                                    <i class="fa-solid fa-certificate me-1"></i>
                                                                    {{ translate('Remove Featured') }}
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </li>
                                                    @if (licenseType(2) && @$settings->premium->status && !$item->isFree())
                                                        <li>
                                                            <hr class="dropdown-divider" />
                                                        </li>
                                                        <li>
                                                            @if (!$item->isPremium())
                                                                <form
                                                                    action="{{ route('admin.items.premium', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <button
                                                                        class="action-confirm dropdown-item text-warning">
                                                                        <i class="fa-solid fa-crown me-1"></i>
                                                                        {{ translate('Add to Premium') }}
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <form
                                                                    action="{{ route('admin.items.premium.remove', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <button
                                                                        class="action-confirm dropdown-item text-danger">
                                                                        <i class="fa-solid fa-crown me-1"></i>
                                                                        {{ translate('Remove from Premium') }}
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <hr class="dropdown-divider" />
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.items.destroy', $item->id) }}"
                                                            method="POST">
                                                            @csrf @method('DELETE')
                                                            <button class="action-confirm dropdown-item text-danger">
                                                                <i class="fa-solid fa-trash-can me-1"></i>
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
    {{ $items->links() }}
    <div class="modal fade" id="addItemModel" tabindex="-1" aria-labelledby="addItemModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4">
                <div class="modal-header border-0 p-0 mb-3">
                    <h1 class="modal-title fs-5" id="addItemModelLabel">{{ translate('Category') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <form action="{{ route('admin.items.create') }}" method="GET">
                        <div class="mb-3">
                            <select name="category" class="form-select form-select-md">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-primary btn-md w-100">{{ translate('Continue') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
