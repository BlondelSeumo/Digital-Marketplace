<div class="item {{ $item_classes ?? '' }}">
    <div class="item-header">
        @if ($item->isPreviewFileTypeImage())
            <a href="{{ $item->getLink() }}" class="item-img">
                <img src="{{ $item->getPreviewImageLink() }}" alt="{{ $item->name }}" />
            </a>
        @elseif($item->isPreviewFileTypeVideo())
            <a href="{{ $item->getLink() }}" class="opacity-100">
                <div class="item-video">
                    <video class="plyr" poster="{{ $item->getPreviewImageLink() }}" muted>
                        <source src="{{ $item->getPreviewLink() }}">
                    </video>
                    <div class="item-video-actions d-flex align-items-center justify-content-between gap-1">
                        <div class="item-video-volume item-video-action">
                            <i class="fa-solid fa-volume-high" class="unmuted"></i>
                            <i class="fa-solid fa-volume-xmark" class="muted"></i>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <div class="item-video-full item-video-action">
                                <i class="fa fa-expand"></i>
                            </div>
                        </div>
                    </div>
                    <div class="item-video-progress">
                        <span></span>
                    </div>
                </div>
            </a>
        @elseif($item->isPreviewFileTypeAudio())
            <div class="item-audio">
                <a href="{{ $item->getLink() }}" class="item-audio-link opacity-100"></a>
                <div class="item-audio-wave">
                    <div class="item-audio-actions">
                        <button class="play-button btn btn-primary btn-sm px-2">
                            <div class="play-button-icon">
                                <i class="fas fa-play"></i>
                            </div>
                        </button>
                        <button class="pause-button btn btn-primary btn-sm px-2 d-none">
                            <div class="play-button-icon">
                                <i class="fas fa-pause"></i>
                            </div>
                        </button>
                    </div>
                    <div class="waveform" data-url="{{ $item->getPreviewLink() }}" data-waveheight="50"></div>
                    <div class="total-duration">00:00</div>
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
    <div class="item-content">
        <h6 class="item-title">
            <a href="{{ $item->getLink() }}">{{ $item->name }}</a>
        </h6>
        <div class="item-meta">
            <nav class="item-category" aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="{{ $item->category->getLink() }}">{{ $item->category->name }}</a>
                    </li>
                    @if ($item->subCategory)
                        <li class="breadcrumb-item">
                            <a href="{{ $item->subCategory->getLink() }}">{{ $item->subCategory->name }}</a>
                        </li>
                    @endif
                </ol>
            </nav>
            @if ($settings->item->reviews_status && $item->hasReviews())
                <div class="item-rating">
                    <div class="ratings row row-cols-auto flex-nowrap g-1">
                        <div class="col">
                            @include('themes.basic.partials.rating-stars', [
                                'stars' => $item->avg_reviews,
                            ])
                        </div>
                        <div class="col">
                            <span class="text-muted">({{ numberFormat($item->total_reviews) }})</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="item-info d-flex justify-content-between align-items-center gap-3">
            @if ($item->isFree())
                <div>
                    <div
                        class="item-price {{ @$settings->item->free_item_total_downloads && $item->free_downloads > 1 ? '' : 'mb-0' }}">
                        <span class="item-price-amount">{{ translate('Free') }}</span>
                    </div>
                    @if (@$settings->item->free_item_total_downloads && $item->free_downloads > 1)
                        <div class="item-sales">
                            <i class="fa fa-download me-1"></i>
                            {{ translate($item->free_downloads > 1 ? ':count Downloads' : ':count Download', ['count' => numberFormat($item->free_downloads)]) }}
                        </div>
                    @endif
                </div>
            @else
                <div>
                    <div class="item-price {{ !$item->hasSales() ? 'mb-0' : '' }}">
                        @if ($item->isOnDiscount())
                            <span class="item-price-through">
                                {{ getAmount($item->getRegularPrice(), 2, '.', '', true) }}
                            </span>
                            <span class="item-price-amount">
                                {{ getAmount($item->price->regular, 2, '.', '', true) }}
                            </span>
                        @else
                            <span class="item-price-amount">
                                {{ getAmount($item->getRegularPrice(), 2, '.', '', true) }}
                            </span>
                        @endif
                    </div>
                    @if (@$settings->item->item_total_sales && $item->hasSales())
                        <div class="item-sales">
                            <i class="fa fa-cart-shopping me-1"></i>
                            {{ translate($item->total_sales > 1 ? ':count Sales' : ':count Sale', ['count' => numberFormat($item->total_sales)]) }}
                        </div>
                    @endif
                </div>
            @endif
            <div class="row row-cols-auto g-2">
                @if ($item->isFree())
                    <div class="col">
                        @if ($item->isMainFileSourceExternal())
                            <a href="{{ route('items.free.download.external', hash_encode($item->id)) }}"
                                target="_blank" class="btn btn-outline-primary btn-md btn-padding">
                                <i class="fa fa-download"></i>
                            </a>
                        @else
                            <form action="{{ route('items.free.download', hash_encode($item->id)) }}" method="POST">
                                @csrf
                                <button class="btn btn-outline-primary btn-md btn-padding"><i
                                        class="fa-solid fa-download"></i></button>
                            </form>
                        @endif
                    </div>
                @else
                    <div class="col">
                        @if ($item->isPurchaseMethodInternal())
                            <form data-action="{{ route('cart.add-item') }}" class="add-to-cart-form" method="POST">
                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                <input type="hidden" name="license_type" value="1">
                                @if (@$settings->item->support_status && defaultSupportPeriod() && $item->isSupported())
                                    <input type="hidden" name="support" value="{{ defaultSupportPeriod()->id }}">
                                @endif
                                <button class="btn btn-outline-primary btn-md btn-padding">
                                    <i class="fa-solid fa-shopping-cart"></i>
                                </button>
                            </form>
                        @else
                            <a href="{{ $item->purchase_url }}" target="_blank"
                                class="btn btn-outline-primary btn-md btn-padding">
                                <i class="fa-solid fa-shopping-cart"></i>
                            </a>
                        @endif
                    </div>
                @endif
                <div class="col">
                    <a href="{{ $item->getLink() }}" class="btn btn-outline-secondary btn-md btn-padding">
                        <i class="far fa-eye"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
