@extends('themes.basic.help.layout')
@section('title', translate('Help Center'))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'help'))
@section('container', 'container-custom')
@section('header_v1', true)
@section('content')
    @if ($categories->count() > 0)
        <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-3 g-4">
            @foreach ($categories as $category)
                <div class="col">
                    <div class="box border p-4 h-100">
                        <div class="py-2 d-flex flex-column h-100">
                            <a href="{{ $category->getLink() }}" class="text-dark">
                                <h4 class="support-category-title">{{ $category->name }}</h4>
                            </a>
                            <div class="d-flex flex-column gap-1 my-3 flex-grow-1">
                                @foreach ($category->articles as $article)
                                    <a href="{{ $article->getLink() }}" class="support-article-link fs-6">
                                        {{ $article->title }}
                                        <i class="fa fa-chevron-right fa-sm fa-rtl"></i>
                                    </a>
                                @endforeach
                            </div>
                            <div class="support-category-actions mt-auto">
                                <a href="{{ $category->getLink() }}">
                                    {{ translate('View more') }}
                                    <i class="fa fa-arrow-right-long fa-rtl ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="box border p-5 text-center">
            <span class="text-muted">{{ translate('No data found') }}</span>
        </div>
    @endif
    @if ($settings->actions->tickets)
        <div class="box border-0 bg-color mt-5 text-center">
            <div class="py-4">
                <h3 class="mb-3">{{ translate('Still no luck? We can help!') }}</h3>
                <p class="lead">{{ translate('Open a ticket and we will contact you back as soon as possible.') }}
                </p>
                <a href="{{ route('user.tickets.create') }}"
                    class="btn btn-primary btn-md">{{ translate('Open a request') }}</a>
            </div>
        </div>
    @endif
@endsection
