@extends('admin.layouts.app')
@section('title', translate('Dashboard'))
@section('container', 'container-max-xxl')
@section('content')
    @if (!@$settings->cronjob->last_execution)
        <div class="alert alert-danger p-4 mb-4">
            <div class="row row-cols-auto g-4">
                <div class="col">
                    <i class="fas fa-exclamation-triangle fa-3x"></i>
                </div>
                <div class="col">
                    <h4>{{ translate('Cron Job Not Working') }}</h4>
                    <p class="mb-2">
                        {{ translate("It seems that your Cron Job isn't set up correctly, which might be causing it not to work as expected. Please double-check and ensure that your Cron Job is properly configured.") }}
                    </p>
                    <p class="mb-3">
                        {{ translate('Cron Job is required by multiple things to be run (Emails, Badges, Discounts, Cache, Sitemap, etc...)') }}
                    </p>
                    <a href="{{ route('admin.system.cronjob.index') }}"
                        class="btn btn-outline-danger">{{ translate('Setup Cron Job') }}<i
                            class="fa-solid fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    @endif
    @if (!@$settings->smtp->status)
        <div class="alert alert-warning border border-warning p-4 mb-4">
            <div class="row row-cols-auto g-4">
                <div class="col">
                    <i class="fa-solid fa-circle-info fa-3x"></i>
                </div>
                <div class="col">
                    <h4>{{ translate('SMTP Is Not Enabled') }}</h4>
                    <p class="mb-3">
                        {{ translate('SMTP is not enabled, set it now to be able to recover the password and use all the features that needs to send an email.') }}
                    </p>
                    <a href="{{ route('admin.settings.smtp.index') }}"
                        class="btn btn-outline-dark">{{ translate('Setup SMTP') }}<i
                            class="fa-solid fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    @endif
    <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-4 g-3 mb-3">
        <div class="col">
            <div class="vironeer-counter-card bg-c-1">
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-dollar-sign"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">
                        {{ translate('Total Sales (:count)', ['count' => number_format($counters['total_sales'])]) }}
                    </p>
                    <p class="vironeer-counter-card-number">{{ getAmount($counters['total_sales_amount']) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-c-2">
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-circle-dollar-to-slot"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">
                        {{ translate('Support Sales (:count)', ['count' => number_format($counters['support_sales'])]) }}
                    </p>
                    <p class="vironeer-counter-card-number">{{ getAmount($counters['support_sales_amount']) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-c-6">
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Total Items') }}</p>
                    <p class="vironeer-counter-card-number">{{ number_format($counters['total_items']) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-c-7">
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-cart-arrow-down"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Total Sales') }}</p>
                    <p class="vironeer-counter-card-number">{{ number_format($counters['total_sales']) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-c-11">
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-share"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Total Refunds') }}</p>
                    <p class="vironeer-counter-card-number">{{ number_format($counters['total_refunds']) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-c-9">
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Total Users') }}</p>
                    <p class="vironeer-counter-card-number">{{ number_format($counters['total_users']) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-c-12">
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Total Transactions') }}</p>
                    <p class="vironeer-counter-card-number">{{ number_format($counters['total_transactions']) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-c-13">
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-inbox"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Total Tickets') }}</p>
                    <p class="vironeer-counter-card-number">{{ number_format($counters['total_tickets']) }}</p>
                </div>
            </div>
        </div>
    </div>
    @if (licenseType(2) && @$settings->premium->status)
        <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-3 g-3 mb-3">
            <div class="col">
                <div class="vironeer-counter-card bg-c-3">
                    <div class="vironeer-counter-card-icon">
                        <i class="fa-solid fa-crown"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title">{{ translate('Free Subscriptions') }}</p>
                        <p class="vironeer-counter-card-number">
                            {{ number_format($counters['premium_free_subscriptions']) }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="vironeer-counter-card bg-c-4">
                    <div class="vironeer-counter-card-icon">
                        <i class="fa-solid fa-crown"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title">{{ translate('Paid Subscriptions') }}</p>
                        <p class="vironeer-counter-card-number">
                            {{ number_format($counters['premium_paid_subscriptions']) }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="vironeer-counter-card bg-c-5">
                    <div class="vironeer-counter-card-icon">
                        <i class="fa-solid fa-dollar-sign"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title">{{ translate('Premium Earnings') }}</p>
                        <p class="vironeer-counter-card-number">
                            {{ getAmount($counters['premium_total_earnings']) }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-6 col-xxl-8">
            <div class="card h-100">
                <div class="vironeer-box chart-bar">
                    <div class="vironeer-box-header">
                        <p class="vironeer-box-header-title large mb-0">
                            {{ translate('Users Statistics For This Month') }}
                        </p>
                        <div class="vironeer-box-header-action ms-auto">
                            <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-sm-end">
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.members.users.index') }}">{{ translate('View All') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="vironeer-box-body">
                        <div class="chart-bar">
                            <canvas id="users-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl-4">
            <div class="card h-100">
                <div class="vironeer-box v2">
                    <div class="vironeer-box-header mb-3">
                        <p class="vironeer-box-header-title large mb-0">{{ translate('Recently registered') }}</p>
                        <div class="vironeer-box-header-action ms-auto">
                            <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-sm-end">
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.members.users.index') }}">{{ translate('View All') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="vironeer-box-body">
                        <div class="vironeer-random-lists">
                            @forelse ($users as $user)
                                <div class="vironeer-random-list">
                                    <div class="vironeer-random-list-cont">
                                        <a class="vironeer-random-list-img"
                                            href="{{ route('admin.members.users.edit', $user->id) }}">
                                            <img src="{{ $user->getAvatar() }}" />
                                        </a>
                                        <div class="vironeer-random-list-info">
                                            <div>
                                                <a class="vironeer-random-list-title fs-exact-14"
                                                    href="{{ route('admin.members.users.edit', $user->id) }}">
                                                    {{ $user->getName() }}
                                                </a>
                                                <p class="vironeer-random-list-text mb-0">
                                                    {{ $user->created_at->diffforhumans() }}
                                                </p>
                                            </div>
                                            <div class="vironeer-random-list-action d-none d-lg-block">
                                                <a href="{{ route('admin.members.users.edit', $user->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                @include('admin.partials.empty')
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl-4">
            <div class="card h-100">
                <div class="vironeer-box v2">
                    <div class="vironeer-box-header mb-3">
                        <p class="vironeer-box-header-title large mb-0">{{ translate('Top Selling Items') }}</p>
                    </div>
                    <div class="vironeer-box-body">
                        <div class="vironeer-random-lists">
                            @forelse ($topSellingItems as $topSellingItem)
                                @php
                                    $item = $topSellingItem->item;
                                @endphp
                                <div class="vironeer-random-list">
                                    <div class="vironeer-random-list-cont">
                                        <a class="vironeer-random-list-img"
                                            href="{{ route('admin.items.edit', $item->id) }}">
                                            <img src="{{ $item->getThumbnailLink() }}" />
                                        </a>
                                        <div class="vironeer-random-list-info">
                                            <div>
                                                <a class="vironeer-random-list-title fs-exact-14"
                                                    href="{{ route('admin.items.edit', $item->id) }}">
                                                    {{ shorterText($item->name, 50) }}
                                                </a>
                                                <p class="vironeer-random-list-text mb-0">
                                                    {{ translate('Sales (:count)', ['count' => numberFormat($topSellingItem->total_sales)]) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                @include('admin.partials.empty')
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl-8">
            <div class="card h-100">
                <div class="vironeer-box chart-bar">
                    <div class="vironeer-box-header mb-3">
                        <p class="vironeer-box-header-title large mb-0">
                            {{ translate('Sales Statistics For This Month') }}
                        </p>
                    </div>
                    <div class="vironeer-box-body">
                        <div class="chart-bar">
                            <canvas id="sales-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl-8">
            <div class="card h-100">
                <div class="vironeer-box">
                    <div class="vironeer-box-header mb-3">
                        <p class="vironeer-box-header-title large mb-0">
                            {{ translate('Purchasing Countries') }}
                        </p>
                    </div>
                    <div class="vironeer-box-body p-3">
                        <div class="chart-bar">
                            <div id="countries-chart" class="chart w-100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl-4">
            <div class="card h-100">
                <div class="vironeer-box v2">
                    <div class="vironeer-box-header mb-3">
                        <p class="vironeer-box-header-title large mb-0">{{ translate('Top Purchasing Countries') }}</p>
                    </div>
                    <div class="vironeer-box-body">
                        <div class="vironeer-random-lists">
                            @forelse ($topPurchasingCountries as $topPurchasingCountry)
                                <div class="vironeer-random-list py-2">
                                    <div class="vironeer-random-list-cont">
                                        <div class="vironeer-random-list-img">
                                            <img src="{{ countryFlag($topPurchasingCountry->country) }}"
                                                alt="{{ countries($topPurchasingCountry->country) }}" />
                                        </div>
                                        <div class="vironeer-random-list-info">
                                            <div>
                                                <div class="vironeer-random-list-title fs-exact-14">
                                                    {{ countries($topPurchasingCountry->country) }}
                                                </div>
                                            </div>
                                            <div class="vironeer-random-list-action">
                                                <strong class="text-success">
                                                    {{ getAmount($topPurchasingCountry->total_spend) }}
                                                </strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                @include('admin.partials.empty')
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('top_scripts')
        @php
            $chartsConfig = [
                'users' => $charts['users'],
                'sales' => $charts['sales'],
                'geo' => [
                    'data' => [],
                ],
            ];
            $chartsConfig['geo']['data'][] = ['Country', translate('Sales')];
            if (!$geoCountries->isEmpty()) {
                foreach ($geoCountries as $geoCountry) {
                    $chartsConfig['geo']['data'][] = [$geoCountry->country, (int) $geoCountry->total_sales];
                }
            }
        @endphp
        <script>
            "use strict";
            const chartsConfig = @json($chartsConfig);
        </script>
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/chartjs/chart.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/geochart/geochart.min.js') }}"></script>
        <script src="{{ asset_with_version('vendor/admin/js/charts.js') }}"></script>
    @endpush
@endsection
