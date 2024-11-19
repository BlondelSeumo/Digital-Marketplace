@if ($categoriesSection && $homeCategories->count() > 0)
    <section class="section {{ $categoriesSection->name || $categoriesSection->description ? '' : 'section-margin' }}">
        <div class="container container-custom">
            <div class="section-inner">
                @if ($categoriesSection->name || $categoriesSection->description)
                    <div class="section-header text-center text-lg-start">
                        <div class="row align-items-center justify-content-between g-3">
                            <div class="col-12 col-lg-8 col-xl-7 col-xxl-6">
                                <h2 class="section-title">
                                    {{ $categoriesSection->name }}
                                </h2>
                                @if ($categoriesSection->description)
                                    <p class="section-text">
                                        {{ $categoriesSection->description }}
                                    </p>
                                @endif
                            </div>
                            <div class="col-12 col-lg-auto d-flex justify-content-center d-none d-lg-block">
                                <a href="{{ route('categories.index') }}"
                                    class="btn btn-outline-primary btn-md px-4 py-2 fw-medium">
                                    {{ translate('View All') }}
                                    <i class="fa fa-chevron-right fa-sm fa-rtl ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="section-body" data-aos="fade-up" data-aos-duration="1000">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 justify-content-center g-3">
                        @foreach ($homeCategories as $homeCategory)
                            <div class="col">
                                <a href="{{ $homeCategory->link }}" class="home-category">
                                    <div class="home-category-icon">
                                        <img src="{{ $homeCategory->getIcon() }}" alt="{{ $homeCategory->name }}" />
                                    </div>
                                    <div class="home-category-info">
                                        <h5 class="home-category-title">{{ $homeCategory->name }}</h5>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    @if (!$categoriesSection->name && !$categoriesSection->description)
                        <div class="d-flex justify-content-center mt-4">
                            <a href="{{ route('categories.index') }}"
                                class="btn btn-outline-primary btn-md px-5 fw-medium">
                                {{ translate('View All') }}
                                <i class="fa fa-arrow-right fa-rtl ms-1"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endif
