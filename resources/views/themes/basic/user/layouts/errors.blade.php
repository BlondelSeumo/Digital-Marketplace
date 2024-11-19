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
            <div class="dashboard-container dashboard-container-sm py-4">
                <div class="page-content py-5">
                    <div class="error-card h-100 my-5">
                        <h1 class="error-code">@yield('code')</h1>
                        <h2 class="error-title">@yield('title')</h2>
                        <div class="col-lg-9 m-auto">
                            <p class="error-message">@yield('message')</p>
                        </div>
                        <div>
                            <a href="{{ route('user.purchases.index') }}" class="btn btn-primary btn-md"><i
                                    class="bi bi-bag me-2"></i>{{ translate('Go to My Purchases') }}</a>
                        </div>
                    </div>
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
