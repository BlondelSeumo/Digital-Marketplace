@extends('themes.basic.items.layout')
@section('noindex', true)
@section('title', $item->name)
@section('breadcrumbs', Breadcrumbs::render('items.support', $item))
@section('og_image', $item->getImageLink())
@section('description', shorterText(strip_tags($item->description), 155))
@section('keywords', $item->tags)
@section('content')
    <div class="item-support">
        <div class="box bg-color rounded-2 p-4 mb-3">
            <div class="row align-items-center g-3">
                <div class="col-12 col-lg">
                    <div class="row row-cols-auto align-items-center g-3">
                        <div class="col">
                            <a class="user-avatar user-avatar-lg me-1">
                                <img src="{{ asset($themeSettings->general->brand) }}"
                                    alt="{{ $settings->general->site_name }}">
                            </a>
                        </div>
                        <div class="col">
                            <div class="d-block text-dark fs-5 mb-1">
                                <h5 class="mb-0">
                                    {{ translate('This item is supported by :website_name', ['website_name' => $settings->general->site_name]) }}
                                </h5>
                            </div>
                            <p class="mb-0 fs-6">
                                <span class="text-muted small">
                                    {{ translate('Read the support instructions below to know how you can get help.') }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-auto">
                    <span class="badge bg-primary">
                        {{ translate('Supported') }}
                    </span>
                </div>
            </div>
        </div>
        <div>
            <div class="box bg-color rounded-2 p-4">
                <h5 class="pb-3 border-bottom mb-4">
                    {{ translate('Support instructions') }}</h5>
                {!! $item->support_instructions !!}
            </div>
        </div>
    </div>
@endsection
