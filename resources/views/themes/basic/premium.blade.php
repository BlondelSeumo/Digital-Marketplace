@extends('themes.basic.layouts.single')
@section('header_title', translate('Premium'))
@section('title', translate('Premium'))
@section('body_bg', 'bg-white')
@section('breadcrumbs', Breadcrumbs::render('premium'))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'premium'))
@section('header_v3', true)
@section('content')
    <div class="premium my-4">
        @if ($countPlans > 0)
            @php
                $plans = [
                    [
                        'count' => $weeklyPlans->count(),
                        'id' => 'week-tab',
                        'target' => '#pills-week',
                        'label' => 'Weekly',
                    ],
                    [
                        'count' => $monthlyPlans->count(),
                        'id' => 'month-tab',
                        'target' => '#pills-month',
                        'label' => 'Monthly',
                    ],
                    [
                        'count' => $yearlyPlans->count(),
                        'id' => 'year-tab',
                        'target' => '#pills-year',
                        'label' => 'Yearly',
                    ],
                    [
                        'count' => $lifetimePlans->count(),
                        'id' => 'lifetime-tab',
                        'target' => '#pills-lifetime',
                        'label' => 'Lifetime',
                    ],
                ];

                $availablePlans = array_filter($plans, function ($plan) {
                    return $plan['count'] > 0;
                });

                $activePlan = $availablePlans ? reset($availablePlans) : null;
                $showSwitcher = count($availablePlans) > 1;
            @endphp
            @if ($showSwitcher)
                <div class="d-flex justify-content-center mb-5" id="pills-tab" role="tablist">
                    <div class="plan-switcher">
                        <div class="plan-switcher-inner">
                            @foreach ($plans as $plan)
                                @if ($plan['count'] > 0)
                                    <button
                                        class="plan-switcher-item {{ $activePlan && $activePlan['id'] === $plan['id'] ? 'active' : '' }}"
                                        id="{{ $plan['id'] }}" data-bs-toggle="pill" data-bs-target="{{ $plan['target'] }}">
                                        {{ translate($plan['label']) }}
                                    </button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            @php
                $firstAvailableTab = null;
                if ($weeklyPlans->count() > 0) {
                    $firstAvailableTab = 'pills-week';
                } elseif ($monthlyPlans->count() > 0) {
                    $firstAvailableTab = 'pills-month';
                } elseif ($yearlyPlans->count() > 0) {
                    $firstAvailableTab = 'pills-year';
                } elseif ($lifetimePlans->count() > 0) {
                    $firstAvailableTab = 'pills-lifetime';
                }
            @endphp
            <div class="tab-content plans" id="pills-tabContent">
                @if ($weeklyPlans->count() > 0)
                    <div class="tab-pane fade {{ $firstAvailableTab === 'pills-week' ? 'show active' : '' }}"
                        id="pills-week" role="tabpanel" tabindex="0">
                        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3 justify-content-center g-3">
                            @foreach ($weeklyPlans as $plan)
                                <div class="col">
                                    @include('themes.basic.partials.plan', ['plan' => $plan])
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if ($monthlyPlans->count() > 0)
                    <div class="tab-pane fade {{ $firstAvailableTab === 'pills-month' ? 'show active' : '' }}"
                        id="pills-month" role="tabpanel" tabindex="0">
                        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3 justify-content-center g-3">
                            @foreach ($monthlyPlans as $plan)
                                <div class="col">
                                    @include('themes.basic.partials.plan', ['plan' => $plan])
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if ($yearlyPlans->count() > 0)
                    <div class="tab-pane fade {{ $firstAvailableTab === 'pills-year' ? 'show active' : '' }}"
                        id="pills-year" role="tabpanel" tabindex="0">
                        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3 justify-content-center g-3">
                            @foreach ($yearlyPlans as $plan)
                                <div class="col">
                                    @include('themes.basic.partials.plan', ['plan' => $plan])
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if ($lifetimePlans->count() > 0)
                    <div class="tab-pane fade {{ $firstAvailableTab === 'pills-lifetime' ? 'show active' : '' }}"
                        id="pills-lifetime" role="tabpanel" tabindex="0">
                        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3 justify-content-center g-3">
                            @foreach ($lifetimePlans as $plan)
                                <div class="col">
                                    @include('themes.basic.partials.plan', ['plan' => $plan])
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @else
            <div class="box border p-5 text-center">
                <span class="text-muted">{{ translate('No premium plans available') }}</span>
            </div>
        @endif
        <div class="mt-5 text-center">
            <a href="{{ route('items.index', ['premium' => 'true']) }}" class="btn btn-outline-primary btn-lg px-5">
                <i class="fa-solid fa-crown me-1"></i>
                {{ translate('Browse premium items') }}
            </a>
        </div>
    </div>
@endsection
