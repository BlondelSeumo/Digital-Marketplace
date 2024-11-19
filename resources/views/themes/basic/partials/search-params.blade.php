<div id="searchFiltersSidebar" class="d-none d-xl-block">
    @isset($category)
        @if ($category->subCategories->count() > 0)
            <div class="box bg-color p-4 mb-4">
                <h5 class="mb-4">{{ $category->name }}</h5>
                @foreach ($category->subCategories as $subCategory)
                    <div class="filter-item {{ !$loop->last ? 'mb-3' : '' }}">
                        <a href="{{ route('categories.sub-category', [$category->slug, $subCategory->slug] + request()->all()) }}"
                            class="text-dark">
                            <div class="row align-items-center g-3">
                                <div class="col">
                                    {{ $subCategory->name }}
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-tag fa-rtl"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    @endisset
    <div class="box bg-color p-4 mb-4">
        <h5 class="mb-4">{{ translate('Options') }}</h5>
        <div class="filter-item">
            <div class="form-check">
                <input class="form-check-input search-param" type="checkbox" name="free" value="true"
                    id="op1">
                <label class="form-check-label" for="op1">{{ translate('Free') }}</label>
            </div>
        </div>
        @if (licenseType(2) && @$settings->premium->status)
            <div class="filter-item">
                <div class="form-check">
                    <input class="form-check-input search-param" type="checkbox" name="premium" value="true"
                        id="op2">
                    <label class="form-check-label" for="op2">{{ translate('Premium') }}</label>
                </div>
            </div>
        @endif
        <div class="filter-item">
            <div class="form-check">
                <input class="form-check-input search-param" type="checkbox" name="on_sale" value="true"
                    id="op3">
                <label class="form-check-label" for="op3">{{ translate('On Sale') }}</label>
            </div>
        </div>
        <div class="filter-item">
            <div class="form-check">
                <input class="form-check-input search-param" type="checkbox" name="best_selling" value="true"
                    id="op4">
                <label class="form-check-label" for="op4">{{ translate('Best Selling') }}</label>
            </div>
        </div>
        <div class="filter-item">
            <div class="form-check">
                <input class="form-check-input search-param" type="checkbox" name="trending" value="true"
                    id="op5">
                <label class="form-check-label" for="op5">{{ translate('Trending') }}</label>
            </div>
        </div>
        <div class="filter-item">
            <div class="form-check">
                <input class="form-check-input search-param" type="checkbox" name="featured" value="true"
                    id="op6">
                <label class="form-check-label" for="op6">{{ translate('Featured') }}</label>
            </div>
        </div>
    </div>
    <div class="box bg-color p-4 mb-4">
        <h5 class="mb-4">{{ translate('Price') }}</h5>
        <div class="filter-item">
            <div class="d-flex align-items-center gap-2">
                <input id="priceForm" type="number" name="min_price" class="form-control form-control-md"
                    placeholder="{{ translate('min') }}" value="{{ request()->input('min_price') }}" />
                <span>-</span>
                <input id="priceTo" type="number" name="max_price" class="form-control form-control-md"
                    placeholder="{{ translate('max') }}" value="{{ request()->input('max_price') }}" />
                <button id="searchByPrice" class="btn btn-primary btn-md btn-padding">
                    <i class="fa fa-arrow-right fa-rtl"></i>
                </button>
            </div>
        </div>
    </div>
    @if (isset($category) && $category->categoryOptions->count() > 0)
        @foreach ($category->categoryOptions as $categoryOption)
            <div class="box bg-color p-4 mb-4">
                <h5 class="mb-4">{{ $categoryOption->name }}</h5>
                @foreach ($categoryOption->options as $key => $value)
                    <div class="filter-item">
                        <div class="form-check">
                            <input class="form-check-input search-param"
                                type="{{ $categoryOption->isMultiple() ? 'checkbox' : 'radio' }}"
                                name="{{ strtolower(Str::slug($categoryOption->name, '_')) }}{{ $categoryOption->isMultiple() ? '[]' : '' }}"
                                value="{{ strtolower(Str::slug($value)) }}" id="cop{{ $key }}"
                                {{ $categoryOption->isMultiple() ? 'data-multiple=true' : '' }}>
                            <label class="form-check-label" for="cop{{ $key }}">{{ $value }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif
    @if (@$settings->item->reviews_status)
        <div class="box bg-color p-4 mb-4">
            <h5 class="mb-4">{{ translate('Rating') }}</h5>
            <div class="filter-item">
                <div class="form-check">
                    <input class="form-check-input search-param" type="radio" name="stars" value=""
                        id="rating1">
                    <label class="form-check-label" for="rating1">{{ translate('Show All') }}</label>
                </div>
            </div>
            <div class="filter-item">
                <div class="form-check">
                    <input class="form-check-input search-param" type="radio" name="stars" value="5"
                        id="rating2">
                    <label class="form-check-label" for="rating2">
                        <div class="row g-2 row-cols-auto align-items-center">
                            <div class="col">
                                @include('themes.basic.partials.rating-stars', [
                                    'stars' => 5,
                                ])
                            </div>
                            <div class="col">
                                {{ translate('5 stars') }}
                            </div>
                        </div>
                    </label>
                </div>
            </div>
            <div class="filter-item">
                <div class="form-check">
                    <input class="form-check-input search-param" type="radio" name="stars" value="4"
                        id="rating3">
                    <label class="form-check-label" for="rating3">
                        <div class="row g-2 row-cols-auto align-items-center">
                            <div class="col">
                                @include('themes.basic.partials.rating-stars', [
                                    'stars' => 4,
                                ])
                            </div>
                            <div class="col">
                                {{ translate('4 stars') }}
                            </div>
                        </div>
                    </label>
                </div>
            </div>
            <div class="filter-item">
                <div class="form-check">
                    <input class="form-check-input search-param" type="radio" name="stars" value="3"
                        id="rating4">
                    <label class="form-check-label" for="rating4">
                        <div class="row g-2 row-cols-auto align-items-center">
                            <div class="col">
                                @include('themes.basic.partials.rating-stars', [
                                    'stars' => 3,
                                ])
                            </div>
                            <div class="col">
                                {{ translate('3 stars') }}
                            </div>
                        </div>
                    </label>
                </div>
            </div>
            <div class="filter-item">
                <div class="form-check">
                    <input class="form-check-input search-param" type="radio" name="stars" value="2"
                        id="rating5">
                    <label class="form-check-label" for="rating5">
                        <div class="row g-2 row-cols-auto align-items-center">
                            <div class="col">
                                @include('themes.basic.partials.rating-stars', [
                                    'stars' => 2,
                                ])
                            </div>
                            <div class="col">
                                {{ translate('2 stars') }}
                            </div>
                        </div>
                    </label>
                </div>
            </div>
            <div class="filter-item">
                <div class="form-check">
                    <input class="form-check-input search-param" type="radio" name="stars" value="1"
                        id="rating6">
                    <label class="form-check-label" for="rating6">
                        <div class="row g-2 row-cols-auto align-items-center">
                            <div class="col">
                                @include('themes.basic.partials.rating-stars', [
                                    'stars' => 1,
                                ])
                            </div>
                            <div class="col">
                                {{ translate('1 star') }}
                            </div>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    @endif
    <div class="box bg-color  p-4 mb-4">
        <h5 class="mb-4">{{ translate('Date Added') }}</h5>
        <div class="filter-item">
            <div class="form-check">
                <input class="form-check-input search-param" type="radio" name="date" value=""
                    id="date1">
                <label class="form-check-label" for="date1">{{ translate('Any time') }}</label>
            </div>
        </div>
        <div class="filter-item">
            <div class="form-check">
                <input class="form-check-input search-param" type="radio" name="date" value="this_month"
                    id="date2">
                <label class="form-check-label" for="date2">{{ translate('This month') }}</label>
            </div>
        </div>
        <div class="filter-item">
            <div class="form-check">
                <input class="form-check-input search-param" type="radio" name="date" value="last_month"
                    id="date3">
                <label class="form-check-label" for="date3">{{ translate('Last month') }}</label>
            </div>
        </div>
        <div class="filter-item">
            <div class="form-check">
                <input class="form-check-input search-param" type="radio" name="date" value="this_year"
                    id="date4">
                <label class="form-check-label" for="date4">{{ translate('This year') }}</label>
            </div>
        </div>
        <div class="filter-item">
            <div class="form-check">
                <input class="form-check-input search-param" type="radio" name="date" value="last_year"
                    id="date5">
                <label class="form-check-label" for="date5">{{ translate('Last year') }}</label>
            </div>
        </div>
    </div>
</div>
<div id="searchFiltersMenu">
    <div class="offcanvas offcanvas-start" tabindex="-1" id="searchFilters" aria-labelledby="searchFiltersLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="searchFiltersLabel">{{ translate('Search Filters') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            @isset($category)
                @if ($category->subCategories->count() > 0)
                    <div class="box bg-color p-4 mb-4">
                        <h5 class="mb-4">{{ $category->name }}</h5>
                        @foreach ($category->subCategories as $subCategory)
                            <div class="filter-item {{ !$loop->last ? 'mb-3' : '' }}">
                                <a href="{{ route('categories.sub-category', [$category->slug, $subCategory->slug] + request()->all()) }}"
                                    class="text-dark">
                                    <div class="row align-items-center g-3">
                                        <div class="col">
                                            {{ $subCategory->name }}
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-tag fa-rtl"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endisset
            <div class="box bg-color p-4 mb-4">
                <h5 class="mb-4">{{ translate('Options') }}</h5>
                <div class="filter-item">
                    <div class="form-check">
                        <input class="form-check-input search-param" type="checkbox" name="free" value="true"
                            id="op1-1">
                        <label class="form-check-label" for="op1-1">{{ translate('Free') }}</label>
                    </div>
                </div>
                @if (licenseType(2) && @$settings->premium->status)
                    <div class="filter-item">
                        <div class="form-check">
                            <input class="form-check-input search-param" type="checkbox" name="premium"
                                value="true" id="op2-2">
                            <label class="form-check-label" for="op2-2">{{ translate('Premium') }}</label>
                        </div>
                    </div>
                @endif
                <div class="filter-item">
                    <div class="form-check">
                        <input class="form-check-input search-param" type="checkbox" name="on_sale" value="true"
                            id="op3-3">
                        <label class="form-check-label" for="op3-3">{{ translate('On Sale') }}</label>
                    </div>
                </div>
                <div class="filter-item">
                    <div class="form-check">
                        <input class="form-check-input search-param" type="checkbox" name="best_selling"
                            value="true" id="op4-4">
                        <label class="form-check-label" for="op4-4">{{ translate('Best Selling') }}</label>
                    </div>
                </div>
                <div class="filter-item">
                    <div class="form-check">
                        <input class="form-check-input search-param" type="checkbox" name="trending" value="true"
                            id="op5-5">
                        <label class="form-check-label" for="op5-5">{{ translate('Trending') }}</label>
                    </div>
                </div>
                <div class="filter-item">
                    <div class="form-check">
                        <input class="form-check-input search-param" type="checkbox" name="featured" value="true"
                            id="op6-6">
                        <label class="form-check-label" for="op6-6">{{ translate('Featured') }}</label>
                    </div>
                </div>
            </div>
            <div class="box bg-color p-4 mb-4">
                <h5 class="mb-4">{{ translate('Price') }}</h5>
                <div class="filter-item">
                    <div class="d-flex align-items-center gap-2">
                        <input id="priceForm1" type="number" name="min_price" class="form-control form-control-md"
                            placeholder="{{ translate('min') }}" value="{{ request()->input('min_price') }}" />
                        <span>-</span>
                        <input id="priceTo1" type="number" name="max_price" class="form-control form-control-md"
                            placeholder="{{ translate('max') }}" value="{{ request()->input('max_price') }}" />
                        <button id="searchByPrice" class="btn btn-primary btn-md btn-padding">
                            <i class="fa fa-arrow-right fa-rtl"></i>
                        </button>
                    </div>
                </div>
            </div>
            @if (isset($category) && $category->categoryOptions->count() > 0)
                @foreach ($category->categoryOptions as $categoryOption)
                    <div class="box bg-color p-4 mb-4">
                        <h5 class="mb-4">{{ $categoryOption->name }}</h5>
                        @foreach ($categoryOption->options as $key => $value)
                            <div class="filter-item">
                                <div class="form-check">
                                    <input class="form-check-input search-param"
                                        type="{{ $categoryOption->isMultiple() ? 'checkbox' : 'radio' }}"
                                        name="{{ strtolower(Str::slug($categoryOption->name, '_')) }}{{ $categoryOption->isMultiple() ? '[]' : '' }}"
                                        value="{{ strtolower(Str::slug($value)) }}"
                                        id="cop{{ $key }}-{{ $key }}"
                                        {{ $categoryOption->isMultiple() ? 'data-multiple=true' : '' }}>
                                    <label class="form-check-label"
                                        for="cop{{ $key }}-{{ $key }}">{{ $value }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif
            @if (@$settings->item->reviews_status)
                <div class="box bg-color p-4 mb-4">
                    <h5 class="mb-4">{{ translate('Rating') }}</h5>
                    <div class="filter-item">
                        <div class="form-check">
                            <input class="form-check-input search-param" type="radio" name="stars"
                                value="" id="rating1-1">
                            <label class="form-check-label" for="rating1">{{ translate('Show All') }}</label>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="form-check">
                            <input class="form-check-input search-param" type="radio" name="stars"
                                value="5" id="rating2-2">
                            <label class="form-check-label" for="rating2-2">
                                <div class="row g-2 row-cols-auto align-items-center">
                                    <div class="col">
                                        @include('themes.basic.partials.rating-stars', [
                                            'stars' => 5,
                                        ])
                                    </div>
                                    <div class="col">
                                        {{ translate('5 stars') }}
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="form-check">
                            <input class="form-check-input search-param" type="radio" name="stars"
                                value="4" id="rating3-3">
                            <label class="form-check-label" for="rating3-3">
                                <div class="row g-2 row-cols-auto align-items-center">
                                    <div class="col">
                                        @include('themes.basic.partials.rating-stars', [
                                            'stars' => 4,
                                        ])
                                    </div>
                                    <div class="col">
                                        {{ translate('4 stars') }}
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="form-check">
                            <input class="form-check-input search-param" type="radio" name="stars"
                                value="3" id="rating4-4">
                            <label class="form-check-label" for="rating4-4">
                                <div class="row g-2 row-cols-auto align-items-center">
                                    <div class="col">
                                        @include('themes.basic.partials.rating-stars', [
                                            'stars' => 3,
                                        ])
                                    </div>
                                    <div class="col">
                                        {{ translate('3 stars') }}
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="form-check">
                            <input class="form-check-input search-param" type="radio" name="stars"
                                value="2" id="rating5-5">
                            <label class="form-check-label" for="rating5-5">
                                <div class="row g-2 row-cols-auto align-items-center">
                                    <div class="col">
                                        @include('themes.basic.partials.rating-stars', [
                                            'stars' => 2,
                                        ])
                                    </div>
                                    <div class="col">
                                        {{ translate('2 stars') }}
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="form-check">
                            <input class="form-check-input search-param" type="radio" name="stars"
                                value="1" id="rating6-6">
                            <label class="form-check-label" for="rating6-6">
                                <div class="row g-2 row-cols-auto align-items-center">
                                    <div class="col">
                                        @include('themes.basic.partials.rating-stars', [
                                            'stars' => 1,
                                        ])
                                    </div>
                                    <div class="col">
                                        {{ translate('1 star') }}
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            @endif
            <div class="box bg-color  p-4 mb-4">
                <h5 class="mb-4">{{ translate('Date Added') }}</h5>
                <div class="filter-item">
                    <div class="form-check">
                        <input class="form-check-input search-param" type="radio" name="date" value=""
                            id="date1-1">
                        <label class="form-check-label" for="date1-1">{{ translate('Any time') }}</label>
                    </div>
                </div>
                <div class="filter-item">
                    <div class="form-check">
                        <input class="form-check-input search-param" type="radio" name="date"
                            value="this_month" id="date2-2">
                        <label class="form-check-label" for="date2-2">{{ translate('This month') }}</label>
                    </div>
                </div>
                <div class="filter-item">
                    <div class="form-check">
                        <input class="form-check-input search-param" type="radio" name="date"
                            value="last_month" id="date3-3">
                        <label class="form-check-label" for="date3-3">{{ translate('Last month') }}</label>
                    </div>
                </div>
                <div class="filter-item">
                    <div class="form-check">
                        <input class="form-check-input search-param" type="radio" name="date" value="this_year"
                            id="date4-4">
                        <label class="form-check-label" for="date4-4">{{ translate('This year') }}</label>
                    </div>
                </div>
                <div class="filter-item">
                    <div class="form-check">
                        <input class="form-check-input search-param" type="radio" name="date" value="last_year"
                            id="date5-5">
                        <label class="form-check-label" for="date5-5">{{ translate('Last year') }}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
