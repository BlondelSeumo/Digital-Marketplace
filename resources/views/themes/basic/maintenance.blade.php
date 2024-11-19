<!DOCTYPE html>
<html lang="{{ getLocale() }}">

<head>
    @section('noindex', true)
    @section('title', @$settings->maintenance->title)
    @push('styles')
        <link rel="stylesheet" href="{{ asset('themes/basic/assets/css/maintenance.css') }}">
    @endpush
    @include('themes.basic.includes.head')
</head>


<body class="maintenance bg-secondary d-flex justify-content-center align-items-center">
    <div class="background-animation">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <circle cx="50%" cy="50%" r="400" fill="rgba(0, 123, 255, 0.1)" class="float1" />
            <circle cx="50%" cy="50%" r="250" fill="rgba(0, 123, 255, 0.15)" class="float2" />
            <circle cx="50%" cy="50%" r="150" fill="rgba(0, 123, 255, 0.2)" class="float3" />
        </svg>
    </div>
    <div class="container text-center content-center">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-lg border-0 rounded-4 p-5">
                    <div class="logo-image mb-4">
                        <img src="{{ asset(@$settings->maintenance->image) }}"
                            alt="{{ @$settings->maintenance->title }}" class="img-fluid">
                    </div>
                    <h1 class="mb-3">{{ @$settings->maintenance->title }}</h1>
                    <p class="text-muted mb-4">{{ @$settings->maintenance->body }}</p>
                    <form action="{{ route('maintenance.unlock') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="password" class="form-control form-control-lg text-center" name="password"
                                placeholder="{{ translate('Enter Password') }}" autofocus required>
                        </div>
                        <div class="captcha-container">
                            <x-captcha />
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100">{{ translate('Unlock') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('vendor/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/libs/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/libs/vironeer/toastr/js/vironeer-toastr.min.js') }}"></script>
    <script src="{{ theme_assets_with_version('assets/js/app.js') }}"></script>
    @stack('scripts')
    @toastrRender
</body>

</html>
