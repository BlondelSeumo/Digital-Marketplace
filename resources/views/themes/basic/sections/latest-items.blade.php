@if ($latestItemsSection)
    <section class="section">
        <div class="container container-custom">
            <div class="section-inner">
                <div class="section-header text-center">
                    <div class="col-lg-7 mx-auto">
                        <h2 class="section-title">{{ $latestItemsSection->name }}</h2>
                        @if ($latestItemsSection->description)
                            <p class="section-text mt-3">{{ $latestItemsSection->description }}</p>
                        @endif
                    </div>
                </div>
                <div class="section-body">
                    <div class="items-tabs-actions mb-4" id="pills-tab" role="tablist">
                        <div class="row row-cols-auto justify-content-center g-2">
                            <div class="col" role="presentation">
                                <button class="items-tabs-btn active" id="pills-all-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all"
                                    aria-selected="true">{{ translate('All Categories') }}</button>
                            </div>
                            @foreach ($latestItemsCategories as $category)
                                <div class="col" role="presentation">
                                    <button class="items-tabs-btn" id="pills-{{ $category->slug }}-tab"
                                        data-bs-toggle="pill" data-bs-target="#pills-{{ $category->slug }}"
                                        type="button" role="tab" aria-controls="pills-{{ $category->slug }}"
                                        aria-selected="false">{{ $category->name }}</button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-content" data-aos="fade-up" data-aos-duration="1000">
                        <div class="tab-pane fade show active" id="pills-all" role="tabpanel"
                            aria-labelledby="pills-all-tab">
                            @if ($latestItems->count() > 0)
                                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xxl-4 g-3">
                                    @foreach ($latestItems as $item)
                                        <div class="col">
                                            @include('themes.basic.partials.item', ['item' => $item])
                                        </div>
                                    @endforeach
                                </div>
                                <div class="text-center mt-5">
                                    <a href="{{ route('items.index') }}" class="btn btn-outline-primary btn-md px-5">
                                        {{ translate('View More') }}
                                        <i class="fa fa-arrow-right fa-rtl ms-2"></i>
                                    </a>
                                </div>
                            @else
                                <div class="box">
                                    <div class="text-center py-5">
                                        <p class="mb-0 text-muted">
                                            {{ translate('No Items Found') }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @foreach ($latestItemsCategories as $category)
                            <div class="tab-pane fade" id="pills-{{ $category->slug }}" role="tabpanel"
                                aria-labelledby="pills-{{ $category->slug }}-tab">
                                @if ($category->items->count() > 0)
                                    <div
                                        class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xxl-4 justify-content-center g-3">
                                        @foreach ($category->items as $item)
                                            <div class="col">
                                                @include('themes.basic.partials.item', ['item' => $item])
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="text-center mt-5">
                                        <a href="{{ $category->getLink() }}"
                                            class="btn btn-outline-primary btn-md px-5">
                                            {{ translate('View More') }}
                                            <i class="fa fa-arrow-right fa-rtl ms-2"></i>
                                        </a>
                                    </div>
                                @else
                                    <div class="box">
                                        <div class="text-center py-5">
                                            <p class="mb-0 text-muted">
                                                {{ translate('No Items Found') }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
