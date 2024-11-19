@extends('admin.layouts.grid')
@section('title', $item->name)
@section('item_view', true)
@section('back', route('admin.items.index'))
@section('content')
    <div class="dashboard-tabs">
        @include('admin.items.includes.tabs-nav')
        <div class="dashboard-tabs-content">
            <div class="row align-items-center g-3 mb-3">
                <div class="col">
                    <h4 class="mb-0">{{ translate('Statistics') }}</h4>
                </div>
                <div class="col-auto">
                    @include('admin.partials.period-select', [
                        'date' => $item->created_at,
                    ])
                </div>
            </div>
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-3 g-3 mb-3">
                <div class="col">
                    <div class="card p-4 text-center">
                        <h2 class="mb-3">{{ number_format($counters['total_sales']) }}</h2>
                        <h5 class="fw-light mb-0">{{ translate('Total Sales') }}</h5>
                    </div>
                </div>
                <div class="col">
                    <div class="card p-4 text-center">
                        <h2 class="mb-3">{{ getAmount($counters['total_sales_amount']) }}</h2>
                        <h5 class="fw-light mb-0">{{ translate('Total Sales Amount') }}</h5>
                    </div>
                </div>
                <div class="col">
                    <div class="card p-4 text-center">
                        <h2 class="mb-3">{{ number_format($counters['total_views']) }}</h2>
                        <h5 class="fw-light mb-0">{{ translate('Total Views') }}</h5>
                    </div>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-12">
                    <div class="card h-100">
                        <div class="vironeer-box chart-bar">
                            <div class="vironeer-box-header mb-3">
                                <p class="vironeer-box-header-title large mb-0">
                                    {{ translate('Sales Statistics') }}
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
                <div class="col-12 col-lg-4">
                    <div class="card h-100">
                        <div class="vironeer-box v2">
                            <div class="vironeer-box-header mb-3">
                                <p class="vironeer-box-header-title large mb-0">
                                    {{ translate('Top Purchasing Countries') }}</p>
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
                <div class="col-12 col-xxl-8">
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
                <div class="col-12 col-xxl-8">
                    <div class="card h-100">
                        <div class="vironeer-box chart-bar">
                            <div class="vironeer-box-header mb-3">
                                <p class="vironeer-box-header-title large mb-0">
                                    {{ translate('Views Statistics') }}
                                </p>
                            </div>
                            <div class="vironeer-box-body">
                                <div class="chart-bar">
                                    <canvas id="views-chart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card h-100">
                        <div class="vironeer-box v2">
                            <div class="vironeer-box-header mb-3">
                                <p class="vironeer-box-header-title large mb-0">
                                    {{ translate('Top Referrals') }}</p>
                            </div>
                            <div class="vironeer-box-body">
                                <div class="vironeer-random-lists">
                                    @forelse($referrals as $referral)
                                        <div class="vironeer-random-list py-2">
                                            <div class="vironeer-random-list-cont">
                                                <div class="vironeer-random-list-info">
                                                    <div>
                                                        <div class="vironeer-random-list-title fs-exact-14">
                                                            {{ shorterText($referral->referrer, 60) }}
                                                        </div>
                                                    </div>
                                                    <div class="vironeer-random-list-action">
                                                        {{ numberFormat($referral->total_views) }}
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
        </div>
    </div>
    @push('top_scripts')
        @php
            $chartsConfig = [
                'sales' => $charts['sales'],
                'views' => $charts['views'],
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
