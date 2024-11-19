@extends('themes.basic.layouts.single')
@section('header_title', translate('Categories'))
@section('title', translate('Categories'))
@section('breadcrumbs', Breadcrumbs::render('categories'))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'categories'))
@section('header_v2', true)
@section('body_bg', 'bg-white')
@section('container', 'container-custom')
@section('content')
    @if ($categories->count() > 0)
        <div class="categories">
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-3 g-4">
                @foreach ($categories as $category)
                    <div class="col">
                        <div class="box p-0 h-100">
                            <div class="category">
                                <a href="{{ $category->getLink() }}" class="category-header">
                                    <div class="category-icon">
                                        <i class="fa-solid fa-tags fa-rtl"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">{{ $category->name }}</h5>
                                        <p class="mb-0 text-muted small">
                                            {{ translate_choice(':count item|:count items', $category->items_count, ['count' => $category->items_count]) }}
                                        </p>
                                    </div>
                                </a>
                                <div class="category-body">
                                    <div class="category-links">
                                        @foreach ($category->subCategories as $subCategory)
                                            <a href="{{ $subCategory->getLink() }}" class="category-link">
                                                <i class="fa-solid fa-tag fa-rtl me-2"></i>
                                                {{ translate(':category_name (:count)', [
                                                    'category_name' => $subCategory->name,
                                                    'count' => $subCategory->items_count,
                                                ]) }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{ $categories->links() }}
    @else
        <div class="box p-5 text-center">
            <span class="text-muted">{{ translate('No Categories found') }}</span>
        </div>
    @endif
@endsection
