@extends('themes.basic.help.layout')
@section('section', translate('Help Center'))
@section('title', $article->title)
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'help_article', $article))
@section('container', 'container-custom')
@section('description', $article->short_description)
@section('content')
    <div class="row g-5">
        <div class="col-12 col-xl-8">
            <div class="article-header mb-4">
                {{ Breadcrumbs::render('help_article', $article) }}
                <h2 class="my-3">{{ $article->title }}</h2>
                <div class="row row-cols-auto g-2 text-muted small">
                    <div class="col">
                        <i class="fa-regular fa-calendar me-2"></i>{{ dateFormat($article->created_at) }}
                    </div>
                </div>
            </div>
            <div class="article-body">
                <div class="article-content">{!! $article->body !!}</div>
                <div class="box border text-center mt-5">
                    <div class="article-feedback">
                        <h5 class="mb-3">{{ translate('Was this article helpful?') }}</h5>
                        <div class="mb-3">
                            <div class="row row-cols-auto justify-content-center g-3">
                                <div class="col">
                                    <button class="btn btn-outline-primary px-3"
                                        data-action="1">{{ translate('Yes') }}</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-outline-danger px-3"
                                        data-action="2">{{ translate('No') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="fw-light mb-0">
                        {{ translate(':count out of :total found this helpful', [
                            'count' => $article->likes,
                            'total' => $article->likes + $article->dislikes,
                        ]) }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-4 d-none d-xl-block">
            <div class="p-0 mb-3">
                <form action="{{ route('help.index') }}" method="GET">
                    <div class="form-search form-search-reverse">
                        <button class="icon">
                            <i class="fa fa-search"></i>
                        </button>
                        <input type="text" name="search" placeholder="{{ translate('Search...') }}"
                            class="form-control form-control-md" value="{{ request('search') ?? '' }}">
                    </div>
                </form>
            </div>
            <nav class="support-sidebar-links position-sticky box border p-2">
                <div class="px-2 pt-2">
                    <h5 class="mb-3">{{ translate('Related articles') }}</h5>
                </div>
                <nav class="nav nav-pills flex-column">
                    @foreach ($relatedArticles as $relatedArticle)
                        <a class="nav-link" href="{{ $relatedArticle->getLink() }}"><i
                                class="fa-regular fa-file-lines me-2"></i>{{ $relatedArticle->title }}</a>
                    @endforeach
                </nav>
            </nav>
        </div>
    </div>
    @push('schema')
        {!! schema($__env, 'article', ['article' => $article]) !!}
    @endpush
    @push('scripts_libs')
        <script>
            "use strict";
            let articleFeedback = $('.article-feedback'),
                articleFeedbackBtn = articleFeedback.find('.btn');

            articleFeedbackBtn.on('click', function() {
                let action = $(this).data('action');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('help.react', $article->slug) }}",
                    type: 'POST',
                    data: {
                        action: action,
                    },
                    success: function(response) {
                        if ($.isEmptyObject(response.error)) {
                            articleFeedback.remove();
                            toastr.success(response.success);
                        } else {
                            toastr.error(response.error);
                        }
                    },
                    error: function(error) {
                        toastr.error(error);
                    }
                });
            });
        </script>
    @endpush
@endsection
