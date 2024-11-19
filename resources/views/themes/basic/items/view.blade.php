@extends('themes.basic.items.layout')
@section('title', $item->name)
@section('breadcrumbs', Breadcrumbs::render('items.view', $item))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'items.view', $item))
@section('og_image', $item->getImageLink())
@section('description', shorterText(strip_tags($item->description), 155))
@section('keywords', $item->tags)
@section('content')
    <div class="box bg-color p-4 mb-4">
        <div class="item-header mb-0">
            @if ($item->isPreviewFileTypeImage())
                <div class="item-single-img">
                    <img src="{{ $item->getPreviewImageLink() }}" alt="{{ $item->name }}" />
                </div>
            @elseif($item->isPreviewFileTypeVideo())
                <div class="item-single-video">
                    <video class="video-plyr" poster="{{ $item->getPreviewImageLink() }}" controls>
                        <source src="{{ $item->getPreviewLink() }}">
                    </video>
                </div>
            @elseif($item->isPreviewFileTypeAudio())
                <div class="item-single-audio">
                    <div class="item-audio-wave">
                        <div class="item-audio-actions md">
                            <button class="play-button btn btn-primary btn-md px-2">
                                <div class="play-button-icon">
                                    <i class="fas fa-play"></i>
                                </div>
                            </button>
                            <button class="pause-button btn btn-primary btn-md px-2 d-none">
                                <div class="play-button-icon">
                                    <i class="fas fa-pause"></i>
                                </div>
                            </button>
                        </div>
                        <div class="current-time fs-5">00:00</div>
                        <div class="waveform" data-url="{{ $item->getPreviewLink() }}" data-waveheight="100"></div>
                        <div class="total-duration fs-5">00:00</div>
                    </div>
                </div>
            @endif
            @if (licenseType(2) && @$settings->premium->status && $item->isPremium())
                <div class="item-badge item-badge-premium">
                    <i class="fa-solid fa-crown me-1"></i>
                    {{ translate('Premium') }}
                </div>
            @elseif ($item->isFree())
                <div class="item-badge item-badge-free">
                    <i class="fa-regular fa-heart me-1"></i>
                    {{ translate('Free') }}
                </div>
            @elseif ($item->isOnDiscount())
                <div class="item-badge item-badge-sale">
                    <i class="fa-solid fa-tag me-1"></i>
                    {{ translate('On Sale') }}
                </div>
            @elseif ($item->isTrending())
                <div class="item-badge item-badge-trending">
                    <i class="fa-solid fa-bolt me-1"></i>
                    {{ translate('Trending') }}
                </div>
            @endif
        </div>
        @if ($item->demo_link || $item->screenshots)
            <div class="mt-4">
                <div class="row row-cols-auto justify-content-center g-3">
                    @if ($item->demo_link)
                        <div class="col">
                            <a href="{{ $item->getDemoLink() }}" target="_blank" class="btn btn-secondary btn-md px-5">
                                <i
                                    class="fa-solid fa-up-right-from-square me-2"></i><span>{{ translate('Live Preview') }}</span>
                            </a>
                        </div>
                    @endif
                    @if ($item->screenshots)
                        <div class="col">
                            <button id="screenshots" class="btn btn-secondary btn-md px-5">
                                <i class="fa-regular fa-images me-2"></i><span>{{ translate('Screenshots') }}</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
    <div class="box p-4 border">
        <div class="item-single-paragraph">
            <x-ad alias="item_page_description_top" @class('mb-4') />
            {!! $item->description !!}
            <x-ad alias="item_page_description_bottom" @class('mt-4') />
        </div>
    </div>
    @push('schema')
        {!! schema($__env, 'item', ['item' => $item]) !!}
    @endpush
@endsection
