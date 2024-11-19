@extends('themes.basic.layouts.single')
@section('header_title', $page->title)
@section('title', $page->title)
@section('description', $page->short_description)
@section('body_bg', 'bg-white')
@section('breadcrumbs', Breadcrumbs::render('page', $page))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'page', $page))
@section('header_v2', true)
@section('container', 'container-custom')
@section('content')
    {!! $page->body !!}
@endsection
