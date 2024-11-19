@extends('themes.basic.blog.layout')
@section('header_title', $blogCategory->name)
@section('title', $blogCategory->name)
@section('breadcrumbs', Breadcrumbs::render('blog_category', $blogCategory))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'blog_category', $blogCategory))
@section('header', true)
@section('content')
    <x-ad alias="blog_page_top" @class('mb-5') />
    @if ($blogArticles->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 justify-content-center g-4">
            @foreach ($blogArticles as $blogArticle)
                <div class="col">
                    <div class="box box-shadow h-100 bg-color p-2 border-0">
                        @include('themes.basic.partials.blog-post', ['blogArticle' => $blogArticle])
                    </div>
                </div>
            @endforeach
        </div>
        {{ $blogArticles->links() }}
    @else
        <div class="box bg-color p-5 text-center">
            <div class="py-3">
                <i class="fa-regular fa-file fa-lg"></i>
                <div class="text-muted">{{ translate('No blog articles found') }}</div>
            </div>
        </div>
    @endif
    <x-ad alias="blog_page_bottom" @class('mt-5') />
@endsection
