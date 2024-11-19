<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ getDirection() }}">

<head>
    @include('themes.basic.includes.head')
    <x-ad alias="head_code" />
</head>

<body
    class="{{ @$settings->announcement->status && !request()->hasCookie('announce_close') ? 'pt-0' : '' }} @yield('body_bg')">
    <x-announcement />
    @include('themes.basic.includes.navbar', ['navbar_classes' => 'v2'])
    @hasSection('header_v1')
        <header class="header header-auto header-bg-color">
            <div class="container container-custom d-flex flex-column flex-grow-1">
                <div class="header-inner text-start py-0">
                    @yield('breadcrumbs')
                    <h1 class="header-title mb-0"> @yield('header_title')</h1>
                </div>
            </div>
        </header>
    @endif
    @hasSection('header_v2')
        <header class="header header-auto header-bg">
            <div class="header-bg-img"
                style="background-image: url('{{ asset($themeSettings->pages->header_background) }}');"></div>
            <div class="container container-custom d-flex flex-column flex-grow-1">
                <div class="header-inner text-start">
                    <div class="row row-cols-1 row-cols-sm-auto justify-content-between align-items-center g-4">
                        <div class="col">
                            @yield('breadcrumbs')
                            <h1 class="header-title mb-0"> @yield('header_title')</h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    @endif
    @hasSection('header_v3')
        <header class="header header-auto header-bg">
            <div class="header-bg-img"
                style="background-image: url('{{ asset($themeSettings->pages->header_background) }}');"></div>
            <div class="container container-custom d-flex flex-column flex-grow-1">
                <div class="header-inner">
                    <div class="d-flex justify-content-center">
                        @yield('breadcrumbs')
                    </div>
                    <h1 class="header-title mb-0"> @yield('header_title')</h1>
                </div>
            </div>
        </header>
    @endif
    @hasSection('header_v4')
        <header class="header header-auto header-bg">
            <div class="header-bg-img"
                style="background-image: url('{{ asset($themeSettings->pages->header_background) }}');"></div>
            <div class="container container-custom d-flex flex-column flex-grow-1">
                <div class="header-inner text-start py-5">
                    @yield('breadcrumbs')
                    <h1 class="header-title mb-4">@yield('header_title')</h1>
                    @include('themes.basic.partials.search-form', [
                        'search_classes' => 'shadow-sm',
                    ])
                    <div class="mt-3">
                        @if (request()->query->count() > 0)
                            <a href="{{ request()->url() }}" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-xmark me-2"></i>
                                {{ translate('Clear All') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </header>
    @endif
    @hasSection('header_v5')
        <header class="header header-auto header-bg">
            <div class="header-bg-img"
                style="background-image: url('{{ asset($themeSettings->pages->header_background) }}');"></div>
            <div class="container container-custom d-flex flex-column flex-grow-1">
                <div class="header-inner text-start">
                    <div class="row row-cols-1 row-cols-sm-auto justify-content-between align-items-center g-4">
                        <div class="col">
                            @yield('breadcrumbs')
                            <h1 class="header-title mb-0">@yield('header_title')</h1>
                        </div>
                        <div class="col-md-5 col-lg-4 col-xxl-3">
                            <form action="{{ url()->current() }}" method="GET">
                                <div class="form-search form-search-reverse">
                                    <button class="icon">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <input type="text" name="search" placeholder="{{ translate('Search...') }}"
                                        class="form-control form-control-md" value="{{ request('search') ?? '' }}">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    @endif
    <section class="section @yield('section_classes')">
        <div class="container @yield('container')">
            <div class="section-inner">
                <div class="section-body">
                    @yield('content')
                </div>
            </div>
        </div>
    </section>
    @include('themes.basic.includes.footer')
    @include('themes.basic.includes.config')
    @include('themes.basic.includes.scripts')
</body>

</html>
