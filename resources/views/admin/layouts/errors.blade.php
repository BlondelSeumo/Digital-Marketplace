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
        <div class="container container-max-lg py-5">
            <div class="vironeer-page-body py-5">
                <div class="card error-card my-5 p-5">
                    <div class="py-4">
                        <h1 class="error-code">@yield('code')</h1>
                        <h2 class="error-title">@yield('title')</h2>
                        <div class="col-lg-9 m-auto">
                            <p class="error-message">@yield('message')</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-md"><i
                                    class="fa-solid fa-table-columns me-2"></i>{{ translate('Go to dashboard') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.includes.scripts')
</body>

</html>
