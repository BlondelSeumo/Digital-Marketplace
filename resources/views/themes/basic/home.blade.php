@extends('themes.basic.layouts.app')
@section('title', @$settings->seo->title)
@section('content')
    <header class="header header-image header-height"
        style="background-image:url('{{ asset($themeSettings->home_page->header_background) }}')">
        <div class="container container-custom d-flex flex-column flex-grow-1">
            <div class="header-inner">
                <div class="col-lg-10 col-xl-9 col-xxl-8 mx-auto text-center">
                    <h1 class="header-title header-title-home" data-aos="fade-right" data-aos-duration="1000">
                        {{ translate('WordPress Templates, Plugins, PHP Scripts And Graphics Digital Marketplace') }}
                    </h1>
                </div>
                <div class="col-lg-10 col-xl-9 col-xxl-7 mx-auto text-center">
                    <p class="header-text" data-aos="fade-left" data-aos-duration="1000">
                        {{ translate('JavaScript, PHP Scripts, CSS, HTML5, Site Templates, WordPress Themes, Plugins, Mobile Apps, Graphics, Prints, Brochures, Flyers, Resumes, and More...') }}
                    </p>
                    <div data-aos="fade-right" data-aos-duration="1000">
                        @include('themes.basic.partials.search-form', [
                            'url' => route('items.index'),
                        ])
                    </div>
                </div>
            </div>
        </div>
    </header>
    @foreach ($homeSections as $key => $homeSection)
        @include('themes.basic.sections.' . str($homeSection->alias)->replace('_', '-'))
        @if ($key == 0)
            <x-ad alias="home_page_top" @class('container container-custom my-5') />
        @elseif ($key == 3)
            <x-ad alias="home_page_center" @class('container container-custom my-5') />
        @endif
    @endforeach
    <x-ad alias="home_page_bottom" @class('container container-custom my-5') />
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/swiper/swiper-bundle.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/aos/aos.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/swiper/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/aos/aos.min.js') }}"></script>
    @endpush
@endsection
