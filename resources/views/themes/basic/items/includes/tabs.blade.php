<div class="tabs-custom">
    <div class="container">
        <div class="swiper tabs-swiper">
            <div class="swiper-wrapper nav nav-tabs flex-nowrap position-relative border-bottom">
                <div class="swiper-slide">
                    <a href="{{ $item->getLink() }}"
                        class="nav-link {{ request()->routeIs('items.view') ? 'active' : '' }}">
                        <i class="fa-regular fa-circle-question me-2"></i>{{ translate('Description') }}
                    </a>
                </div>
                @if (@$settings->item->changelogs_status && $item->hasChangelogs())
                    <div class="swiper-slide">
                        <a href="{{ $item->getChangeLogsLink() }}"
                            class="nav-link {{ request()->routeIs('items.changelogs') ? 'active' : '' }}">
                            <i class="fa-solid fa-rotate me-2"></i>{{ translate('Changelogs') }}
                        </a>
                    </div>
                @endif
                @if (
                    ($settings->item->reviews_status && $item->hasReviews()) ||
                        ($settings->item->reviews_status && authUser() && authUser()->hasPurchasedItem($item->id)))
                    <div class="swiper-slide">
                        <a href="{{ $item->getReviewsLink() }}"
                            class="nav-link {{ request()->routeIs('items.reviews') ? 'active' : '' }}">
                            <i
                                class="fa-regular fa-star me-2"></i>{{ translate('Reviews (:count)', ['count' => numberFormat($item->total_reviews)]) }}
                        </a>
                    </div>
                @endif
                @if (@$itemSettings->comments_status)
                    <div class="swiper-slide">
                        <livewire:item.comments-counter :item="$item" :isActive="request()->routeIs('items.comments') ? true : false" />
                    </div>
                @endif
                @if (@$settings->item->support_status && $item->isSupported())
                    <div class="swiper-slide">
                        <a href="{{ $item->getSupportLink() }}"
                            class="nav-link {{ request()->routeIs('items.support') ? 'active' : '' }}">
                            <i class="fa-solid fa-headset me-2"></i>{{ translate('Support') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
