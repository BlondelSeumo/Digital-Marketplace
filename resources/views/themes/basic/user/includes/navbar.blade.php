<nav class="dashboard-nav">
    <div class="dashboard-nav-btn dashboard-btn dashboard-toggle-btn">
        <i class="fa fa-bars"></i>
    </div>
    <a href="{{ route('home') }}" class="logo logo-sm logo-toggle ms-3">
        <img src="{{ asset($themeSettings->general->logo_dark) }}" alt="{{ @$settings->general->site_name }}" />
    </a>
    <div class="d-flex align-items-center ms-auto">
        @if (licenseType(2) && @$settings->premium->status && !authUser()->isSubscribed())
            <a href="{{ route('premium.index') }}">
                <button class="btn btn-outline-premium px-3">
                    <i class="fa-solid fa-crown"></i><span
                        class="ms-2 d-none d-lg-inline">{{ translate('Premium') }}</span>
                </button>
            </a>
        @endif
        @include('themes.basic.partials.user-menu')
    </div>
</nav>
