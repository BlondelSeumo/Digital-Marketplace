<!DOCTYPE html>
<html lang="{{ getLocale() }}">

<head>
    @include('themes.basic.includes.head')
</head>

<body class="bg-white">
    <x-announcement />
    @include('themes.basic.includes.navbar', ['navbar_classes' => 'v2'])
    @hasSection('header')
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
                            <form action="{{ route('blog.index') }}" method="GET">
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
    <section class="section">
        <div class="container container-custom">
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
