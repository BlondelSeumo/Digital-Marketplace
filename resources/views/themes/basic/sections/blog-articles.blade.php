@if (@$settings->actions->blog && $blogArticlesSection && $blogArticles->count() > 0)
    <section class="section">
        <div class="container container-custom">
            <div class="section-inner">
                <div class="section-header text-center">
                    <h2 class="section-title" data-aos="fade-down" data-aos-duration="1000">
                        {{ $blogArticlesSection->name }}
                    </h2>
                    @if ($blogArticlesSection->description)
                        <p class="section-text col-lg-6 mx-auto" data-aos="fade-down" data-aos-duration="1000"
                            data-aos-delay="200">
                            {{ $blogArticlesSection->description }}
                        </p>
                    @endif
                </div>
                <div class="section-body">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 justify-content-center g-3">
                        @foreach ($blogArticles as $blogArticle)
                            <div class="col">
                                <div class="box h-100 p-2" data-aos="fade-up" data-aos-duration="1000"
                                    data-aos-delay="{{ ($loop->index + 1) * 100 }}">
                                    @include('themes.basic.partials.blog-post', [
                                        'blogArticle' => $blogArticle,
                                    ])
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mt-4" data-aos="fade-up" data-aos-duration="1000"
                        data-aos-delay="600">
                        <a href="{{ route('blog.index') }}" class="btn btn-primary btn-md px-5">
                            {{ translate('View All') }}
                            <i class="fa fa-arrow-right fa-rtl ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
