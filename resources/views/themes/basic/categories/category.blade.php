@extends('themes.basic.layouts.single')
@section('header_title', $category->name)
@section('title', $category->title ?? $category->name)
@section('body_bg', 'bg-white')
@if ($category->description)
    @section('description', $category->description)
@endif
@section('header_v4', true)
@section('breadcrumbs', Breadcrumbs::render('categories.category', $category))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'categories.category', $category))
@section('container', 'container-custom')
@section('content')
    <x-ad alias="category_page_top" @class('mb-5') />
    <div class="row g-2 align-items-center mb-4">
        <div class="col">
            <h5 class="mb-0">
                @if (request()->query->count() > 0)
                    {{ translate('Your search results for the ":name" category', [
                        'name' => strtolower($category->name),
                    ]) }}
                @else
                    {{ translate('All results for the ":name" category', [
                        'name' => strtolower($category->name),
                    ]) }}
                @endif
            </h5>
        </div>
        <div class="col-auto">
            <button class="btn btn-theme btn-padding d-block d-xl-none" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#searchFilters" aria-controls="searchFilters">
                <i class="fa fa-filter"></i>
            </button>
        </div>
        @if ($items->count() > 0)
            <div class="col-auto d-none d-md-inline">
                @include('themes.basic.partials.grid-buttons')
            </div>
        @endif
    </div>
    <div class="row g-4">
        <div class="col-12 col-xl-3">
            @include('themes.basic.partials.search-params')
        </div>
        <div class="col-12 col-xl-9">
            @include('themes.basic.partials.search-items', [
                'items' => $items,
            ])
        </div>
    </div>
    <x-ad alias="category_page_bottom" @class('mt-5') />
@endsection
