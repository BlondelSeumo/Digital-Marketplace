@extends('themes.basic.blog.layout')
@section('header_title', $blogArticle->title)
@section('title', $blogArticle->title)
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'blog_article', $blogArticle))
@section('og_image', $blogArticle->getImageLink())
@section('description', $blogArticle->short_description)
@section('content')
    <div class="blog-container">
        <div class="row row-cols-1 g-4">
            <div class="col">
                <div class="blog-post v2 blog-post-single">
                    <div class="text-center mb-4">
                        <div class="blog-post-meta">
                            <div class="row row-cols-auto align-items-center justify-content-center gx-3 gy-2">
                                <div class="col">
                                    <a href="{{ route('blog.category', $blogArticle->category->slug) }}">
                                        <div class="blog-post-category mb-0">
                                            <i class="fa-solid fa-tag me-2"></i>
                                            {{ $blogArticle->category->name }}
                                        </div>
                                    </a>
                                </div>
                                <div class="col d-flex align-items-center text-muted small">
                                    <i class="far fa-calendar me-2"></i>
                                    <span>{{ dateFormat($blogArticle->created_at) }}</span>
                                </div>
                            </div>
                        </div>
                        <h2 class="blog-post-title px-2 mb-0">{{ $blogArticle->title }}</h2>
                    </div>
                    <div class="blog-post-header">
                        <img src="{{ $blogArticle->getImageLink() }}" alt="{{ $blogArticle->title }}" class="blog-post-img">
                    </div>
                    <div class="blog-post-body px-sm-4">
                        <x-ad alias="blog_article_page_top" @class('mb-4') />
                        <div class="blog-post-single-text">
                            {!! $blogArticle->body !!}
                        </div>
                        <x-ad alias="blog_article_page_bottom" @class('mt-4') />
                        @include('themes.basic.partials.share-buttons', [
                            'socials_classes' => 'my-4',
                            'link' => route('blog.article', $blogArticle->slug),
                        ])
                        <div class="comments">
                            <h5 class="comments-title">
                                <i
                                    class="far fa-comments me-2"></i>{{ translate('Comments (:count)', ['count' => $blogArticleComments->count()]) }}
                            </h5>
                            @forelse ($blogArticleComments as $blogArticleComment)
                                @php
                                    $user = $blogArticleComment->user;
                                @endphp
                                <div class="box bg-color p-4 mb-3">
                                    <div class="comment">
                                        <div class="comment-info">
                                            <div class="comment-img">
                                                <img src="{{ $user->getAvatar() }}" alt="{{ $user->username }}">
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="comment-title mb-1">
                                                    {{ $user->username }}
                                                </h6>
                                                <time class="comment-time small text-muted">
                                                    <i class="far fa-calendar me-1"></i>
                                                    {{ dateFormat($blogArticleComment->created_at) }}
                                                </time>
                                            </div>
                                        </div>
                                        <p class="comment-text mb-0">{!! purifier($blogArticleComment->body) !!}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="box p-4">
                            @if (authUser())
                                <h5 class="mb-4">{{ translate('Leave a comment') }}</h5>
                                <form action="{{ route('blog.article', $blogArticle->slug) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <textarea class="form-control form-control-md" name="comment" rows="4"
                                            placeholder="{{ translate('Your comment') }}" required>{{ old('comment') }}</textarea>
                                    </div>
                                    <x-captcha />
                                    <button class="btn btn-primary btn-md px-4">{{ translate('Publish') }}</button>
                                </form>
                            @else
                                <div class="text-center">
                                    {{ translate('Login or create account to leave comments') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('schema')
        {!! schema($__env, 'article', ['article' => $blogArticle]) !!}
    @endpush
@endsection
