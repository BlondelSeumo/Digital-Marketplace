@extends('themes.basic.items.layout')
@section('noindex', true)
@section('title', $item->name)
@section('breadcrumbs', Breadcrumbs::render('items.changelogs', $item))
@section('og_image', $item->getImageLink())
@section('description', shorterText(strip_tags($item->description), 155))
@section('keywords', $item->tags)
@section('content')
    <div class="row g-4 changelogs">
        @foreach ($changeLogs as $changeLog)
            <div class="col-12">
                <div class="box p-4">
                    <div class="row g-3 align-items-center mb-3">
                        <div class="col">
                            <strong
                                class="fs-5">{{ translate('Version :version', ['version' => $changeLog->version]) }}</strong>
                        </div>
                        <div class="col-auto">
                            <span>{{ dateFormat($changeLog->created_at) }}</span>
                        </div>
                    </div>
                    <pre>{{ $changeLog->body }}</pre>
                </div>
            </div>
        @endforeach
    </div>
@endsection
