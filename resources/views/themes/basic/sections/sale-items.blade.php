@if ($saleItemsSection && $saleItems->count() > 0)
    <section class="section">
        <div class="container container-custom">
            <div class="section-inner">
                <div class="section-header text-center text-lg-start">
                    <div class="row align-items-center justify-content-between g-3">
                        <div class="col-12 col-lg-8 col-xl-7 col-xxl-6">
                            <h2 class="section-title mb-0">
                                {{ $saleItemsSection->name }}
                            </h2>
                            @if ($saleItemsSection->description)
                                <p class="section-text mt-3">{{ $saleItemsSection->description }}</p>
                            @endif
                        </div>
                        <div class="col-12 col-lg-auto d-flex justify-content-center d-none d-lg-block">
                            <a href="{{ route('items.index', ['on_sale' => 'true']) }}"
                                class="btn btn-outline-primary btn-md px-4 py-2 fw-medium">
                                {{ translate('View All') }}
                                <i class="fa fa-chevron-right fa-sm fa-rtl ms-2"></i></a>
                        </div>
                    </div>
                </div>
                <div class="section-body">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xxl-4 g-3">
                        @foreach ($saleItems as $saleItem)
                            <div class="col" data-aos="fade-up" data-aos-duration="1000">
                                @include('themes.basic.partials.item', ['item' => $saleItem])
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-5 d-block d-lg-none">
                        <a href="{{ route('items.index', ['on_sale' => 'true']) }}"
                            class="btn btn-outline-primary btn-md px-5">
                            {{ translate('View All') }}
                            <i class="fa fa-arrow-right fa-rtl ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
