<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ getDirection() }}">

<head>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/simplebar/simplebar.min.css') }}">
    @endpush
    @section('noindex', true)
    @include('themes.basic.includes.head')
</head>

<body class="pt-0">
    <div class="dashboard">
        @include('themes.basic.user.includes.sidebar')
        <div class="dashboard-body">
            @include('themes.basic.user.includes.navbar')
            <div class="dashboard-container pt-4 py-5 @yield('container')">
                @if (@settings('kyc')->status && @settings('kyc')->required && !authUser()->isKycVerified())
                    <div class="mb-4">
                        @if (authUser()->isKycPending())
                            <div class="alert alert-warning p-4">
                                <h4 class="alert-heading">{{ translate('KYC Verification Pending') }}</h4>
                                <span>{{ translate('Your KYC verification is currently pending. We are processing your information, and you will be notified once the verification is complete.') }}</span>
                            </div>
                        @else
                            <div class="alert alert-danger p-4">
                                <h4 class="alert-heading">{{ translate('KYC Verification Required') }}</h4>
                                <p>
                                    {{ translate('Your KYC verification is required to continue using our platform. Please complete the verification process as soon as possible.') }}
                                </p>
                                <a href="{{ route('user.kyc.index') }}"
                                    class="btn btn-danger px-4">{{ translate('Complete KYC') }}<i
                                        class="fa-solid fa-arrow-right ms-2"></i></a>
                            </div>
                        @endif
                    </div>
                @endif
                @if (licenseType(2) && @$settings->premium->status && authUser()->isSubscribed())
                    <div class="mb-4">
                        @if (authUser()->subscription->isAboutToExpire())
                            <div class="alert alert-warning p-4">
                                <h4 class="alert-heading">{{ translate('Your subscription is about to expire') }}
                                </h4>
                                <span>{{ translate('Your current subscription is nearing its expiration date. To continue enjoying uninterrupted access to premium features, please renew your subscription before it expires.') }}</span>
                            </div>
                        @elseif(authUser()->subscription->isExpired())
                            <div class="alert alert-danger p-4">
                                <h4 class="alert-heading">{{ translate('Your subscription has been expired') }}
                                </h4>
                                <span>{{ translate('Your subscription has expired, and you no longer have access to premium features. Please renew your subscription to regain access to all features.') }}</span>
                            </div>
                        @endif
                    </div>
                @endif
                <div class="mb-4">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col">
                            <h3>@yield('title')</h3>
                            @yield('breadcrumbs')
                        </div>
                        @hasSection('back')
                            <div class="col-auto">
                                <a href="@yield('back')" class="btn btn-outline-primary btn-md px-4"><i
                                        class="fa-solid fa-arrow-left fa-rtl me-1"></i>
                                    {{ translate('Back') }}
                                </a>
                            </div>
                        @endif
                        @hasSection('create')
                            <div class="col-auto">
                                <a href="@yield('create')" class="btn btn-primary btn-md px-4"><i
                                        class="fa fa-plus"></i></a>
                            </div>
                        @endif
                        @if (request()->routeIs('user.transactions.show'))
                            @if ($trx->isPaid())
                                <div class="col-auto">
                                    <a href="{{ route('user.transactions.invoice', $trx->id) }}" target="_blank"
                                        class="btn btn-primary btn-md px-4">
                                        <i class="fa-regular fa-file-lines me-1"></i>
                                        {{ translate('Invoice') }}
                                    </a>
                                </div>
                            @endif
                        @endif
                        @if (@$settings->deposit->status && request()->routeIs('user.wallet.index'))
                            <div class="col-auto">
                                <button type="button" class="btn btn-primary btn-md px-4" data-bs-toggle="modal"
                                    data-bs-target="#depositModel">
                                    <i class="fa-solid fa-circle-dollar-to-slot me-1"></i>
                                    {{ translate('Deposit') }}
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="page-content">
                    @yield('content')
                </div>
            </div>
            @include('themes.basic.user.includes.footer')
        </div>
    </div>
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/simplebar/simplebar.min.js') }}"></script>
    @endpush
    @include('themes.basic.includes.config')
    @include('themes.basic.includes.scripts')
</body>

</html>
