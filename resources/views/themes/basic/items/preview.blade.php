<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ getDirection() }}">

<head>
    @section('title', $item->name)
    @section('noindex', true)
    @include('themes.basic.includes.head')
</head>

<body class="pt-0">
    <div class="preview-nav">
        <div class="container-fluid h-100">
            <div class="d-flex align-items-center justify-content-between h-100">
                <a href="{{ route('home') }}" class="logo logo-preview">
                    <img src="{{ asset($themeSettings->general->logo_light) }}"
                        alt="{{ @$settings->general->site_name }}">
                </a>
                <div class="preview-nav-actions">
                    <div class="preview-nav-action preview-desktop d-none d-lg-block">
                        <svg width="28" height="28" viewBox="0 0 2048 1792" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M1856 992v-832q0-13-9.5-22.5t-22.5-9.5h-1600q-13 0-22.5 9.5t-9.5 22.5v832q0 13 9.5 22.5t22.5 9.5h1600q13 0 22.5-9.5t9.5-22.5zm128-832v1088q0 66-47 113t-113 47h-544q0 37 16 77.5t32 71 16 43.5q0 26-19 45t-45 19h-512q-26 0-45-19t-19-45q0-14 16-44t32-70 16-78h-544q-66 0-113-47t-47-113v-1088q0-66 47-113t113-47h1600q66 0 113 47t47 113z"
                                fill="#fff"></path>
                        </svg>
                    </div>
                    <div class="preview-nav-action preview-tablet d-none d-md-block">
                        <svg width="28" height="28" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M960 1408q0-26-19-45t-45-19-45 19-19 45 19 45 45 19 45-19 19-45zm384-160v-960q0-13-9.5-22.5t-22.5-9.5h-832q-13 0-22.5 9.5t-9.5 22.5v960q0 13 9.5 22.5t22.5 9.5h832q13 0 22.5-9.5t9.5-22.5zm128-960v1088q0 66-47 113t-113 47h-832q-66 0-113-47t-47-113v-1088q0-66 47-113t113-47h832q66 0 113 47t47 113z"
                                fill="#fff"></path>
                        </svg>
                    </div>
                    <div class="preview-nav-action preview-mobile d-none d-md-block">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="15" height="24" viewBox="0 0 18 24">
                            <image width="18" height="24"
                                xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAkCAYAAACNBsqdAAAA7UlEQVRIie2X4Q2CMBBGvxoGYBMZATeADdzMEWQD4gY6gY7ABmdOaVLu8KhQ/dWXkJQLfbm0TfoBhogqIuppO+yo2OnGQQ+gRBoGAAcWnwE0iaSerojolDu4ilq1MK8sVEnD0ouqArWqBMSI6yXJHLuZWhJkxx2A20rxfnIIxPm1NsSE5waefrIUzrnBmmwh5/5sjbM4izVZnMWaLP6zeOvVFL7Ly/RERFsu04/iJlXcit08TkPt+Mi4NUtMEmJa59wD77Vk8V19saZjL5Vji92YJk2I6Og/CMcGwzfBm+MXs7S5r+Dtu0j7qwDgCRSY7yn2Q9VrAAAAAElFTkSuQmCC">
                            </image>
                        </svg>
                    </div>
                </div>
                <a href="{{ $item->getLink() }}" class="btn btn-primary px-4">
                    <i class="fa fa-cart-shopping d-inline d-lg-none"></i>
                    <span class="d-none d-lg-inline">{{ translate('Buy Now') }}</span>
                </a>
            </div>
        </div>
        <div class="preview-btn">
            <i class="fa fa-angle-up"></i>
        </div>
    </div>
    <div class="preview-body">
        <iframe src="{{ $item->demo_link }}"></iframe>
    </div>
    <script src="{{ asset('vendor/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/libs/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/libs/vironeer/toastr/js/vironeer-toastr.min.js') }}"></script>
    <script src="{{ theme_assets_with_version('assets/js/app.js') }}"></script>
</body>

</html>
