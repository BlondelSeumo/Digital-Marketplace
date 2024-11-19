<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ getDirection() }}">

<head>
    @include('admin.includes.head')
    @include('admin.includes.styles')
</head>

<body>
    @include('admin.includes.sidebar')
    <div class="vironeer-page-content">
        @include('admin.includes.navbar')
        <div class="container @yield('container')">
            <div class="vironeer-page-body">
                <div class="py-4 g-3">
                    <div class="row g-3 align-items-center">
                        <div class="col-12 col-lg">
                            @include('admin.partials.breadcrumb')
                        </div>
                        @hasSection('back')
                            <div class="col-auto">
                                <a href="@yield('back')" class="btn btn-secondary btn-md px-4"><i
                                        class="fas fa-arrow-left fa-rtl me-2"></i>{{ translate('Back') }}</a>
                            </div>
                        @endif
                        @if (request()->routeIs('admin.dashboard'))
                            <div class="col-auto">
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-md px-4 dropdown-toggle" type="button"
                                        id="quickAccess" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ translate('Quick Access') }}
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="quickAccess">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.settings.language.index') }}">
                                                {{ translate('Language') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.settings.general') }}">
                                                {{ translate('General Settings') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.settings.mail-templates.index') }}">
                                                {{ translate('Mail Templates') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.financial.payment-gateways.index') }}">
                                                {{ translate('Payment Gateways') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @yield('content')
            </div>
        </div>
        @include('admin.includes.footer')
    </div>
    @include('admin.includes.scripts')
</body>

</html>
