<div class="blog-post">
    <div class="blog-post-header">
        <a href="{{ route('blog.article', $blogArticle->slug) }}">
            <img src="{{ $blogArticle->getImageLink() }}" alt="{{ $blogArticle->title }}" class="blog-post-img">
        </a>
        <a href="{{ route('blog.category', $blogArticle->category->slug) }}" class="blog-post-category">
            <i class="fa-solid fa-tag me-2"></i>{{ $blogArticle->category->name }}
        </a>
    </div>
    <div class="blog-post-body">
        <h5 class="blog-post-title">
            <a href="{{ route('blog.article', $blogArticle->slug) }}">
                {{ $blogArticle->title }}
            </a>
        </h5>
        <div class="blog-post-meta">
            <div class="row row-cols-auto align-items-center gx-3 gy-2">
                <div class="col d-flex align-items-center text-muted small">
                    <i class="far fa-calendar me-2"></i>
                    <span>{{ dateFormat($blogArticle->created_at) }}</span>
                </div>
            </div>
        </div>
        <p class="blog-post-text">
            {{ $blogArticle->short_description }}
        </p>
        <a href="{{ route('blog.article', $blogArticle->slug) }}" class=" mt-auto">
            {{ translate('Read More...') }}
        </a>
    </div>
</div>
