@extends('themes.basic.layouts.single')
@section('noindex', true)
@section('header_title', $item->name)
@section('title', $item->name)
@section('body_bg', 'bg-white')
@section('breadcrumbs', Breadcrumbs::render('items.reviews.review', $item, $review))
@section('container', 'container-custom')
@section('section_classes', 'pt-0')
@section('header_v1', true)
@section('content')
    <div class="col-lg-8">
        <div class="reviews">
            @include('themes.basic.partials.item-review', [
                'item' => $item,
                'review' => $review,
            ])
        </div>
    </div>
@endsection
