@extends('themes.basic.items.layout')
@section('noindex', true)
@section('title', $item->name)
@section('breadcrumbs', Breadcrumbs::render('items.comments', $item))
@section('og_image', $item->getImageLink())
@section('description', shorterText(strip_tags($item->description), 155))
@section('keywords', $item->tags)
@section('content')
    <livewire:item.comments :item="$item" />
    <livewire:item.comment-report />
@endsection
