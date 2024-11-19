<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ getDirection() }}">

<head>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/swiper/swiper-bundle.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/fancybox/fancybox.min.css') }}">
    @endpush
    @include('themes.basic.includes.head')
</head>

<body class="bg-white {{ @$settings->announcement->status && !request()->hasCookie('announce_close') ? 'pt-0' : '' }}">
    <x-announcement />
    @include('themes.basic.includes.navbar', ['navbar_classes' => 'v2'])
    @php
        $itemSettings = $settings->item;
    @endphp
    <header class="header header-auto header-item header-bg">
        <div class="header-bg-img"
            style="background-image: url('{{ asset($themeSettings->pages->header_background) }}');"></div>
        <div class="container d-flex flex-column flex-grow-1">
            <div class="header-inner text-start py-5">
                <div class="row g-3 align-items-center">
                    <div class="col-12 col-lg">
                        @yield('breadcrumbs')
                        <h1 class="h3 my-3">{{ $item->name }}</h1>
                        @if (
                            ($settings->item->reviews_status && $item->hasReviews()) ||
                                (!$item->isFree() && (@$settings->item->item_total_sales && $item->hasSales())) ||
                                $item->isRecentlyUpdated())
                            <div class="row row-cols-auto align-items-center g-2">
                                @if ($settings->item->reviews_status && $item->hasReviews())
                                    <div class="col">
                                        <div class="row row-cols-auto align-items-center g-2">
                                            <div class="col">
                                                @include('themes.basic.partials.rating-stars', [
                                                    'stars' => $item->avg_reviews,
                                                    'ratings_classes' => 'ratings-md',
                                                ])
                                            </div>
                                            <div class="col">
                                                <span class="text-muted">
                                                    {{ translate($item->total_reviews > 1 ? '(:count Reviews)' : '(:count Review)', [
                                                        'count' => number_format($item->total_reviews),
                                                    ]) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    @if ((!$item->isFree() && (@$settings->item->item_total_sales && $item->hasSales())) || $item->isRecentlyUpdated())
                                        <div class="col">
                                            <span class="text-muted">-</span>
                                        </div>
                                    @endif
                                @endif
                                @if (!$item->isFree() && (@$settings->item->item_total_sales && $item->hasSales()))
                                    <div class="col">
                                        <i
                                            class="fa fa-cart-shopping me-2"></i>{{ translate($item->total_sales > 1 ? ':count Sales' : ':count Sale', [
                                                'count' => number_format($item->total_sales),
                                            ]) }}
                                    </div>
                                    @if ($item->isRecentlyUpdated())
                                        <div class="col">
                                            <span>-</span>
                                        </div>
                                    @endif
                                @endif
                                @if ($item->isRecentlyUpdated())
                                    <div class="col text-green">
                                        <i class="fa-regular fa-circle-check me-2"></i><span
                                            class="fw-medium">{{ translate('Recently Updated') }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="col-12 col-lg-auto">
                        <div class="row g-3">
                            <div class="col">
                                <div class="row g-3">
                                    @if ($item->demo_link)
                                        <div class="col-auto">
                                            <a href="{{ $item->getDemoLink() }}" target="_blank"
                                                class="btn btn-outline-secondary btn-md px-3">
                                                <i
                                                    class="fa-solid fa-up-right-from-square me-2"></i>{{ translate('Live Preview') }}
                                            </a>
                                        </div>
                                    @endif
                                    <div class="col-auto">
                                        <livewire:item.favorite-button :item="$item">
                                    </div>
                                </div>
                            </div>
                            @if ($item->isFree())
                                <div class="col-auto d-inline d-lg-none">
                                    @if ($item->isMainFileSourceExternal())
                                        <a href="{{ route('items.free.download.external', hash_encode($item->id)) }}"
                                            target="_blank" class="btn btn-primary btn-md px-3">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    @else
                                        <form action="{{ route('items.free.download', hash_encode($item->id)) }}"
                                            method="POST">
                                            @csrf
                                            <button class="btn btn-primary btn-md px-3">
                                                <i class="fa-solid fa-download"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @else
                                <div class="col-auto d-inline d-lg-none">
                                    <form data-action="{{ route('cart.add-item') }}" class="add-to-cart-form"
                                        method="POST">
                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                        <input type="hidden" name="license_type" value="1">
                                        @if (@$settings->item->support_status && defaultSupportPeriod() && $item->isSupported())
                                            <input type="hidden" name="support"
                                                value="{{ defaultSupportPeriod()->id }}">
                                        @endif
                                        <button class="btn btn-primary btn-md px-3">
                                            <i class="fa fa-cart-shopping me-2"></i>
                                            <span>{{ getAmount($item->price->regular, 2, '.', '', true) }}</span>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('themes.basic.items.includes.tabs')
    </header>
    <x-ad alias="item_page_top" @class('container mt-5') />
    <section class="section py-5">
        <div class="container">
            <div class="section-inner">
                <div class="section-body">
                    <div class="row g-3">
                        <div class="col-12 col-lg-7 col-xl-7 col-xxl-8">
                            @yield('content')
                        </div>
                        <div class="col-12 col-lg-5 col-xl-5 col-xxl-4">
                            @if (licenseType(2) && @$settings->premium->status && $item->isPremium())
                                @if (authUser() && authUser()->isSubscribed())
                                    <div class="box border border-2 border-premium p-3 mb-4">
                                        <div class="box-body text-center p-3">
                                            <div class="mb-4">
                                                <div class="mb-3">
                                                    <i class="fa-solid fa-download text-premium fa-3x"></i>
                                                </div>
                                                <h3 class="mb-3">{{ translate('Premium download') }}</h3>
                                                <p class="mb-0">
                                                    {{ translate('You are subscribed to a premium plan. You can download this item directly.') }}
                                                </p>
                                            </div>
                                            @if ($item->isMainFileSourceExternal())
                                                <a href="{{ route('items.premium.download.external', hash_encode($item->id)) }}"
                                                    target="_blank" class="btn btn-premium btn-md w-100">
                                                    <i class="fa-solid fa-download me-1"></i>
                                                    {{ translate('Download') }}
                                                </a>
                                            @else
                                                <form
                                                    action="{{ route('items.premium.download', hash_encode($item->id)) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button class="btn btn-premium btn-md w-100">
                                                        <i class="fa-solid fa-download me-1"></i>
                                                        {{ translate('Download') }}
                                                    </button>
                                                </form>
                                            @endif
                                            <div class="text-center mt-3">
                                                <a href="{{ route('items.premium.license', encrypt($item->id)) }}"
                                                    class="text-premium" target="_blank">
                                                    {{ translate('License certificate') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="box border border-2 border-premium p-3 mb-4">
                                        <div class="box-body p-4">
                                            <div class="mb-4">
                                                <div class="mb-3">
                                                    <i class="fa-solid fa-crown text-premium fa-3x"></i>
                                                </div>
                                                <h3 class="mb-3">{{ translate('Get unlimited downloads') }}</h3>
                                                <p class="mb-0">
                                                    {{ translate('Subscribe to access unlimited downloads of themes, videos, graphics, plugins, and more premium assets for your creative needs.') }}
                                                </p>
                                            </div>
                                            <a href="{{ route('premium.index') }}"
                                                class="btn btn-premium btn-md w-100">{{ translate('Subscribe to download') }}</a>
                                            @if (@$settings->premium->terms_link)
                                                <div class="text-center mt-3">
                                                    <a href="{{ @$settings->premium->terms_link }}"
                                                        class="text-premium" target="_blank">
                                                        {{ translate('Learn more about premium') }}
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endif
                            @if ($item->isFree())
                                <div class="box p-0 mb-4">
                                    <div class="box-header border-bottom py-3 px-4">
                                        <div class="row row-cols-auto align-items-center justify-content-between g-2">
                                            <div class="col">
                                                <h5 class="mb-0">{{ translate('Free Item') }}</h5>
                                            </div>
                                            @if (@$settings->links->free_items_policy_link)
                                                <div class="col small">
                                                    <a href="{{ @$settings->links->free_items_policy_link }}">
                                                        <span>{{ translate('Free items policy') }}</span>
                                                        <i class="fa fa-chevron-right fa-rtl ms-1 fa-sm"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="box-body p-4">
                                        <p class="text-muted">
                                            {{ translate('This item is available for free download. You may download and use it according to the free item policy.') }}
                                        </p>
                                        @if ($item->isMainFileSourceExternal())
                                            <a href="{{ route('items.free.download.external', hash_encode($item->id)) }}"
                                                target="_blank" class="btn btn-primary btn-md w-100">
                                                <i class="fa fa-download me-1"></i>
                                                {{ translate('Download') }}
                                            </a>
                                        @else
                                            <form action="{{ route('items.free.download', hash_encode($item->id)) }}"
                                                method="POST">
                                                @csrf
                                                <button class="btn btn-primary btn-md w-100">
                                                    <i class="fa-solid fa-download me-1"></i>
                                                    {{ translate('Download') }}
                                                </button>
                                            </form>
                                        @endif
                                        <div class="text-center mt-3">
                                            <a href="{{ route('items.free.license', encrypt($item->id)) }}"
                                                target="_blank">
                                                {{ translate('License certificate') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="box p-0">
                                    <div class="box-header border-bottom py-3 px-4">
                                        <div class="row row-cols-auto align-items-center justify-content-between g-2">
                                            <div class="col">
                                                <h5 class="mb-0">{{ translate('License Option') }}</h5>
                                            </div>
                                            @if (@$settings->links->licenses_terms_link)
                                                <div class="col small">
                                                    <a href="{{ @$settings->links->licenses_terms_link }}">
                                                        <span>{{ translate('Licenses terms') }}</span>
                                                        <i class="fa fa-chevron-right fa-rtl ms-1 fa-sm"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="box-body p-4">
                                        <form data-action="{{ route('cart.add-item') }}" class="add-to-cart-form"
                                            method="POST">
                                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                                            <div class="form-check form-check-lg mb-3">
                                                <input id="license-type-regular"
                                                    class="form-check-input license-type mt-1" type="radio"
                                                    name="license_type" value="1" checked>
                                                <label class="form-check-label d-flex justify-content-between"
                                                    for="license-type-regular">
                                                    <div>
                                                        <h6 class="mb-1">{{ translate('Regular') }}</h6>
                                                        <span
                                                            class="small text-muted">{{ translate('For one project') }}</span>
                                                    </div>
                                                    <div class="item-price">
                                                        @if ($item->isOnDiscount())
                                                            <span class="item-price-through">
                                                                {{ getAmount($item->getRegularPrice(), 2, '.', '', true) }}
                                                            </span>
                                                            <span class="item-price-amount">
                                                                {{ getAmount($item->price->regular, 2, '.', '', true) }}
                                                            </span>
                                                        @else
                                                            <span class="item-price-amount">
                                                                {{ getAmount($item->getRegularPrice(), 2, '.', '', true) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </label>
                                            </div>
                                            @if ($item->hasExtendedLicense())
                                                <div class="form-check form-check-lg mb-3">
                                                    <input id="license-type-extended"
                                                        class="form-check-input license-type mt-1" type="radio"
                                                        name="license_type" value="2">
                                                    <label class="form-check-label d-flex justify-content-between"
                                                        for="license-type-extended">
                                                        <div>
                                                            <h6 class="mb-1">{{ translate('Extended') }}</h6>
                                                            <span
                                                                class="small text-muted">{{ translate('For unlimited projects') }}</span>
                                                        </div>
                                                        <div class="item-price">
                                                            @if ($item->isOnDiscount() && $item->isExtendedOnDiscount())
                                                                <span class="item-price-through">
                                                                    {{ getAmount($item->getExtendedPrice(), 2, '.', '', true) }}
                                                                </span>
                                                                <span class="item-price-amount">
                                                                    {{ getAmount($item->price->extended, 2, '.', '', true) }}
                                                                </span>
                                                            @else
                                                                <span class="item-price-amount">
                                                                    {{ getAmount($item->getExtendedPrice(), 2, '.', '', true) }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (@$settings->item->support_status && $item->isSupported())
                                                @php
                                                    $supportPeriods = supportPeriods();
                                                @endphp
                                                @if ($supportPeriods->count() > 0)
                                                    <div class="p-4 bg-light mb-3 rounded-3">
                                                        <div class="row g-2">
                                                            @foreach ($supportPeriods as $supportPeriod)
                                                                <div class="col-12">
                                                                    <div class="row g-3">
                                                                        <div class="col">
                                                                            <div class="form-check">
                                                                                <input
                                                                                    class="form-check-input item-support"
                                                                                    type="radio" name="support"
                                                                                    id="support{{ $supportPeriod->id }}"
                                                                                    value="{{ $supportPeriod->id }}"
                                                                                    @checked($supportPeriod->isDefault())>
                                                                                <label class="form-check-label"
                                                                                    for="support{{ $supportPeriod->id }}">
                                                                                    {{ $supportPeriod->title }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-auto">
                                                                            <strong class="regular-support">
                                                                                {{ $supportPeriod->isFree() ? translate('Free') : getAmount(($item->price->regular * $supportPeriod->percentage) / 100) }}
                                                                            </strong>
                                                                            @if ($item->hasExtendedLicense())
                                                                                <strong
                                                                                    class="extended-support d-none">
                                                                                    {{ $supportPeriod->isFree() ? translate('Free') : getAmount(($item->price->extended * $supportPeriod->percentage) / 100) }}
                                                                                </strong>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                            @if ($item->isPurchaseMethodInternal())
                                                <button class="btn btn-primary btn-md w-100">
                                                    <i class="fa fa-cart-shopping me-1"></i>
                                                    {{ translate('Add to Cart') }}
                                                </button>
                                            @else
                                                <a href="{{ $item->purchase_url }}" target="_blank"
                                                    class="btn btn-primary btn-md w-100">
                                                    <i class="fa fa-cart-shopping me-1"></i>
                                                    {{ translate('Add to Cart') }}
                                                </a>
                                            @endif
                                        </form>
                                        @if (@$itemSettings->buy_now_button)
                                            @if ($item->isPurchaseMethodInternal())
                                                <form action="{{ route('items.buy-now', [$item->slug, $item->id]) }}"
                                                    class="buy-now-form" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="item_id"
                                                        value="{{ $item->id }}">
                                                    <input type="hidden" name="license_type" value="1">
                                                    @if (@$settings->item->support_status && defaultSupportPeriod() && $item->isSupported())
                                                        <input type="hidden" name="support"
                                                            value="{{ defaultSupportPeriod()->id }}">
                                                    @endif
                                                    <button class="btn btn-outline-primary btn-md w-100 mt-3">
                                                        {{ translate('Buy Now') }}
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ $item->purchase_url }}" target="_blank"
                                                    class="btn btn-outline-primary btn-md w-100 mt-3">
                                                    {{ translate('Buy Now') }}
                                                </a>
                                            @endif
                                        @endif
                                        <div class="list mt-3">
                                            <div class="list-item mb-1 small">
                                                <i class="fa fa-check text-primary me-1"></i>
                                                {{ translate('Quality checked by :website_name', ['website_name' => @$settings->general->site_name]) }}
                                            </div>
                                            <div class="list-item mb-1 small">
                                                <i class="fa fa-check text-primary me-1"></i>
                                                {{ translate('Full Documentation') }}
                                            </div>
                                            <div class="list-item mb-1 small">
                                                <i class="fa fa-check text-primary me-1"></i>
                                                {{ translate('Future updates') }}
                                            </div>
                                            @if (@$settings->item->support_status)
                                                <div class="list-item small">
                                                    <i
                                                        class="fa {{ $item->isSupported() ? 'fa-check text-primary' : 'fa-times text-danger' }} me-1"></i>
                                                    {{ translate('24/7 Support') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <x-ad alias="item_page_sidebar" @class('mt-4') />
                            @if (@$settings->item->item_total_sales && !$item->isFree() && $item->hasSales())
                                <div class="box bg-color p-4 mt-4">
                                    <h5 class="mb-0">
                                        <i class="fa fa-cart-shopping me-2"></i>
                                        {{ translate($item->total_sales > 1 ? ':count Sales' : ':count Sale', [
                                            'count' => number_format($item->total_sales),
                                        ]) }}
                                    </h5>
                                </div>
                            @endif
                            @if (@$itemSettings->free_item_total_downloads && $item->isFree() && $item->free_downloads > 0)
                                <div class="box bg-color p-4 mt-4">
                                    <h5 class="mb-0">
                                        <i class="fa fa-download me-2"></i>
                                        {{ translate($item->free_downloads > 1 ? ':count Downloads' : ':count Download', ['count' => numberFormat($item->free_downloads)]) }}
                                    </h5>
                                </div>
                            @endif
                            <div class="box bg-color p-4 mt-4">
                                <div class="small">
                                    @if ($item->last_update_at)
                                        <div class="d-flex justify-content-between border-bottom pb-3 mb-3"">
                                            <p class="mb-0">{{ translate('Last Update') }}:</p>
                                            <p class="mb-0 ms-2">{{ dateFormat($item->last_update_at) }}</p>
                                        </div>
                                    @endif
                                    <div class="d-flex justify-content-between border-bottom pb-3 mb-3">
                                        <p class="mb-0">{{ translate('Published') }}:</p>
                                        <p class="mb-0 ms-2">{{ dateFormat($item->created_at) }}</p>
                                    </div>
                                    @if ($item->version)
                                        <div class="d-flex justify-content-between border-bottom pb-3 mb-3">
                                            <p class="mb-0">{{ translate('Version') }}:</p>
                                            <p class="mb-0 ms-2">
                                                @if (@$settings->item->changelogs_status && $item->hasChangelogs())
                                                    <a href="{{ $item->getChangelogsLink() }}">
                                                        {{ translate('v:version', ['version' => $item->version]) }}
                                                    </a>
                                                @else
                                                    <span>{{ translate('v:version', ['version' => $item->version]) }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                    <div class="d-flex justify-content-between border-bottom pb-3 mb-3">
                                        <p class="mb-0">{{ translate('Category') }}:</p>
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb justify-content-center m-0">
                                                <li class="breadcrumb-item">
                                                    <a
                                                        href="{{ $item->category->getLink() }}">{{ $item->category->name }}</a>
                                                </li>
                                                @if ($item->subCategory)
                                                    <li class="breadcrumb-item">
                                                        <a
                                                            href="{{ $item->subCategory->getLink() }}">{{ $item->subCategory->name }}</a>
                                                    </li>
                                                @endif
                                            </ol>
                                        </nav>
                                    </div>
                                    @if ($item->options && count($item->options) > 0)
                                        @foreach ($item->options as $key => $value)
                                            <div class="d-flex justify-content-between border-bottom pb-3 mb-3">
                                                <p class="mb-0">{{ $key }}:</p>
                                                @if (is_array($value))
                                                    <div class="col-7 text-end ms-2">
                                                        @foreach ($value as $option)
                                                            <a
                                                                href="{{ route('items.index', ['search' => strtolower($option)]) }}">
                                                                {{ $option }}
                                                            </a>{{ !$loop->last ? ',' : '' }}
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span>{{ $value }}</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="d-flex justify-content-between">
                                        <p class="mb-0">{{ translate('Tags') }}:</p>
                                        <div class="col-7 text-end ms-2">
                                            @foreach ($item->getTags() as $tag)
                                                <a
                                                    href="{{ route('items.index', ['search' => strtolower(str_replace(' ', '', $tag))]) }}">
                                                    {{ $tag }}</a>{{ !$loop->last ? ',' : '' }}
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box bg-color p-4 mt-4">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="fs-5">{{ translate('Share') }}:</span>
                                    @include('themes.basic.partials.share-buttons', [
                                        'link' => $item->getLink(),
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('themes.basic.items.includes.similar-items', ['similarItems' => $similarItems])
    <x-ad alias="item_page_bottom" @class('container mb-5') />
    @include('themes.basic.includes.footer')
    @include('themes.basic.includes.config')
    @if ($item->screenshots)
        @push('top_scripts')
            @php
                $screenshots = [];
                foreach ($item->getScreenshotLinks() as $key => $screenshot) {
                    $screenshots[$key]['src'] = $screenshot;
                    $screenshots[$key]['type'] = 'image';
                }
            @endphp
            <script>
                "use strict";
                const itemScreenshots = {!! json_encode($screenshots) !!};
            </script>
        @endpush
    @endif
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/swiper/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/fancybox/fancybox.min.js') }}"></script>
    @endpush
    @include('themes.basic.includes.scripts')
</body>

</html>
