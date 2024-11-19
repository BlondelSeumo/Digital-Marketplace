<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ getDirection() }}">

<head>
    @include('themes.basic.includes.head')
    <x-ad alias="head_code" />
</head>

<body {{ @$settings->announcement->status && !request()->hasCookie('announce_close') ? 'class=pt-0' : '' }}>
    <x-announcement />
    @include('themes.basic.includes.navbar', ['navbar_classes' => 'v2'])
    <section class="section">
        <div class="container container-custom">
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-8 m-auto">
                        <div class="error-card my-4">
                            <h1 class="error-code">@yield('code')</h1>
                            <h2 class="error-title">@yield('title')</h2>
                            <div class="col-lg-9 m-auto">
                                <p class="error-message">@yield('message')</p>
                            </div>
                            <a href="{{ route('home') }}" class="btn btn-primary btn-md px-5"><i
                                    class="fa fa-home me-1"></i>{{ translate('Back to home') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('themes.basic.includes.footer')
    @include('themes.basic.includes.config')
    @include('themes.basic.includes.scripts')
</body>

</html>
