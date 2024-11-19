@extends('themes.basic.help.layout')
@section('section', translate('Help Center'))
@section('title', $category->name)
@section('header_title', $category->name)
@section('breadcrumbs', Breadcrumbs::render('help_category', $category))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'help_category', $category))
@section('container', 'container-custom')
@section('header_v2', true)
@section('content')
    @if ($articles->count() > 0)
        <div class="list-group">
            @foreach ($articles as $article)
                <a href="{{ $article->getLink() }}" class="list-group-item list-group-item-action p-4">
                    <h6 class="mb-0"><i class="fa-regular fa-file-lines fa-lg me-2"></i>{{ $article->title }}</h6>
                </a>
            @endforeach
        </div>
        {{ $articles->links() }}
    @else
        <div class="box border p-5 text-center">
            <span class="text-muted">{{ translate('No articles found') }}</span>
        </div>
    @endif
@endsection
