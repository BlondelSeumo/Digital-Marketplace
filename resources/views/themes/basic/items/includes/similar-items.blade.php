@if ($similarItems->count() > 0)
    <section class="section">
        <div class="container">
            <div class="section-inner">
                <div class="section-header text-center text-lg-start">
                    <div class="row align-items-center justify-content-between g-3">
                        <div class="col-12 col-lg-8 col-xl-7 col-xxl-6">
                            <h2 class="section-title mb-0">{{ translate('Similar items') }}</h2>
                        </div>
                        <div class="col-12 col-lg-auto d-flex justify-content-center d-none d-lg-block">
                            <a href="{{ $item->subCategory ? $item->subCategory->getLink() : $item->category->getLink() }}"
                                class="btn btn-outline-primary btn-md px-4 py-2 fw-medium">
                                {{ translate('View More') }}
                                <i class="fa fa-chevron-right fa-sm fa-rtl ms-2"></i></a>
                        </div>
                    </div>
                </div>
                <div class="section-body">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-3">
                        @foreach ($similarItems as $similarItem)
                            <div class="col">
                                @include('themes.basic.partials.item', [
                                    'item' => $similarItem,
                                    'item_classes' => 'item-lg border shadow-none',
                                ])
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center d-block d-lg-none mt-4">
                        <a href="{{ $item->subCategory ? $item->subCategory->getLink() : $item->category->getLink() }}"
                            class="btn btn-outline-primary btn-md px-5">{{ translate('View More') }}<i
                                class="fa fa-chevron-right fa-sm fa-rtl ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
