@extends('admin.layouts.grid')
@section('title', $item->name)
@section('item_view', true)
@section('back', route('admin.items.index'))
@section('content')
    <div class="dashboard-tabs">
        @include('admin.items.includes.tabs-nav')
        <div class="dashboard-tabs-content">
            <div class="row g-3">
                <div class="col-lg-7 col-xxl-8 order-2 order-sm-0">
                    <form action="{{ route('admin.items.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card mb-4">
                            <div class="card-header py-3 px-4">
                                <h5 class="mb-0">{{ translate('Name And Description') }}</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3 mb-3">
                                    <div class="col-12">
                                        <label class="form-label">{{ translate('Name') }}</label>
                                        <input type="text" name="name" class="form-control form-control-md"
                                            maxlength="100" value="{{ $item->name }}" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">{{ translate('Slug') }} </label>
                                        <input type="text" name="slug" class="form-control form-control-md"
                                            value="{{ $item->slug }}" required />
                                    </div>
                                    <div class="col-12 ckeditor-sm">
                                        <label class="form-label">{{ translate('Description') }}</label>
                                        <textarea name="description" class="ckeditor">{{ $item->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header py-3 px-4">
                                <h5 class="mb-0">{{ translate('Category And Attributes') }}</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4 mb-3">
                                    <div class="col-lg-12">
                                        <label class="form-label">{{ translate('Category') }}</label>
                                        <select class="form-select form-select-md" disabled>
                                            @foreach ($categories as $mainCategory)
                                                <option value="{{ $mainCategory->id }}" @selected($item->category->id == $mainCategory->id)>
                                                    {{ $mainCategory->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($category->subCategories->count() > 0)
                                        <div class="col-lg-12">
                                            <label class="form-label">{{ translate('SubCategory (Optional)') }}</label>
                                            <select name="sub_category" class="form-select form-select-md selectpicker"
                                                title="--" data-live-search="true">
                                                <option value="">--</option>
                                                @foreach ($category->subCategories as $subCayegory)
                                                    <option value="{{ $subCayegory->id }}" @selected($item->subCategory && $item->subCategory->id == $subCayegory->id)>
                                                        {{ $subCayegory->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    @if ($category->categoryOptions->count() > 0)
                                        @foreach ($category->categoryOptions as $categoryOption)
                                            <div class="col-lg-12">
                                                @php
                                                    $categoryOptionName = $categoryOption->name;
                                                @endphp
                                                <label class="form-label">{{ $categoryOptionName }}</label>
                                                <select
                                                    name="options[{{ $categoryOption->id }}]{{ $categoryOption->isMultiple() ? '[]' : '' }}"
                                                    class="form-select form-select-md selectpicker" title="--"
                                                    {{ $categoryOption->isMultiple() ? 'multiple' : '' }}
                                                    {{ $categoryOption->isRequired() ? 'required' : '' }}>
                                                    @if (!$categoryOption->isRequired())
                                                        <option value="">--</option>
                                                    @endif
                                                    @foreach ($categoryOption->options as $option)
                                                        @php
                                                            $selected = false;
                                                            if (isset($item['options'][$categoryOptionName])) {
                                                                $selected = $categoryOption->isMultiple()
                                                                    ? in_array(
                                                                        $option,
                                                                        $item['options'][$categoryOptionName],
                                                                    )
                                                                    : $item['options'][$categoryOptionName] == $option;
                                                            }
                                                        @endphp
                                                        <option value="{{ $option }}" @selected($selected)>
                                                            {{ $option }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="col-12">
                                        <label class="form-label">{{ translate('Version (Optional)') }}</label>
                                        <input type="text" name="version" class="form-control form-control-md"
                                            placeholder="{{ translate('1.0 or 1.0.0') }}" value="{{ $item->version }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">{{ translate('Demo Link (Optional)') }}</label>
                                        <div class="form-group">
                                            <select name="demo_type" class="form-select form-select-md first-input">
                                                @foreach (\App\Models\Item::demoTypeOptions() as $demoTypeKey => $demoTypeValue)
                                                    <option value="{{ $demoTypeKey }}" @selected($item->demo_type == $demoTypeKey)>
                                                        {{ $demoTypeValue }}</option>
                                                @endforeach
                                            </select>
                                            <input type="url" name="demo_link"
                                                class="form-control form-control-md second-input"
                                                placeholder="https://example.com" value="{{ $item->demo_link }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">{{ translate('Tags') }}</label>
                                        <input type="text" name="tags" class="form-control form-control-md tags-input"
                                            value="{{ $item->tags }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('admin.items.includes.files-box')
                        @if (@$settings->item->support_status)
                            <div class="card mb-4">
                                <div class="card-header py-3 px-4">
                                    <h5 class="mb-0">{{ translate('Support') }}</h5>
                                </div>
                                <div class="card-body p-4">
                                    <p>
                                        {{ translate('Item will be supported?') }}
                                    </p>
                                    <div>
                                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                            <input type="radio" class="btn-check support-option" name="support"
                                                value="0" id="support1"@checked(!$item->isSupported())>
                                            <label class="btn btn-outline-dark btn-md"
                                                for="support1">{{ translate('No') }}</label>
                                            <input type="radio" class="btn-check support-option" name="support"
                                                value="1" id="support2" @checked($item->isSupported())>
                                            <label class="btn btn-outline-dark btn-md"
                                                for="support2">{{ translate('Yes') }}</label>
                                        </div>
                                    </div>
                                    <div
                                        class="support-instructions ckeditor-sm mt-3 {{ !$item->isSupported() ? 'd-none' : '' }}">
                                        <label class="form-label">{{ translate('Instructions') }}</label>
                                        <textarea name="support_instructions" class="ckeditor" rows="6">{{ $item->support_instructions }}</textarea>
                                        <div class="form-text">
                                            {{ translate('Enter the instructions that the buyer should follow to get support. ') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="card mb-4">
                            <div class="card-header py-3 px-4">
                                <h5 class="mb-0">{{ translate('Price') }}</h5>
                            </div>
                            <div class="card-body p-4">
                                @if (!$item->hasDiscount())
                                    <div class="row row-cols-1 g-4 mb-2">
                                        <div class="col">
                                            <div class="col-lg-3">
                                                <label class="form-label"> {{ translate('Free Item') }}</label>
                                                <input id="freeItem" type="checkbox" name="free_item"
                                                    data-toggle="toggle" data-on="{{ translate('Yes') }}"
                                                    data-off="{{ translate('No') }}" data-height="40px"
                                                    @checked($item->isFree())>
                                            </div>
                                        </div>
                                        <div id="priceOptions" class="col {{ $item->isFree() ? 'd-none' : '' }}">
                                            <div class="row g-3">
                                                <div class="col-lg-6">
                                                    @include('admin.partials.input-price', [
                                                        'label' => translate('Regular License Price'),
                                                        'name' => 'regular_license_price',
                                                        'input_class' => 'form-control-md',
                                                        'min' => 1,
                                                        'value' => $item->regular_price,
                                                    ])
                                                </div>
                                                <div class="col-lg-6">
                                                    @include('admin.partials.input-price', [
                                                        'label' => translate('Extended License Price'),
                                                        'name' => 'extended_license_price',
                                                        'input_class' => 'form-control-md',
                                                        'min' => 1,
                                                        'value' => $item->extended_price,
                                                    ])
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                {{ translate('Enter 0 to disable the extended license.') }}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-warning mb-0">
                                        <i class="fa-regular fa-circle-question me-2"></i>
                                        <span>{{ translate('The price cannot be update while the item is on discount') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header py-3 px-4">
                                <h5 class="mb-0">{{ translate('Purchasing') }}</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    <input type="radio" class="btn-check purchase-option" name="purchase_method"
                                        value="1" id="purchase1" @checked($item->isPurchaseMethodInternal())>
                                    <label class="btn btn-outline-dark btn-md"
                                        for="purchase1">{{ translate('Internal') }}</label>
                                    <input type="radio" class="btn-check purchase-option" name="purchase_method"
                                        value="2" id="purchase2" @checked($item->isPurchaseMethodExternal())>
                                    <label class="btn btn-outline-dark btn-md"
                                        for="purchase2">{{ translate('External') }}</label>
                                </div>
                                <div
                                    class="purchase-url mt-4 mb-2 {{ $item->isPurchaseMethodInternal() ? 'd-none' : '' }}">
                                    <label class="form-label">{{ translate('Purchasing link') }}</label>
                                    <input type="url" name="purchase_url" class="form-control form-control-md"
                                        placeholder="https://example.com" value="{{ $item->purchase_url }}">
                                    <div class="form-text">
                                        {{ translate('The buyers will be redirected to this URL after clicking on "Add to cart" or "Buy now"') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header py-3 px-4">
                                <h5 class="mb-0">{{ translate('Status') }}</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-2">
                                    {{ translate('The item will be hidden from the website for new users but remain accessible to buyers who have already purchased it.') }}
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label">{{ translate('Status') }}</label>
                                    <input type="checkbox" name="status" data-toggle="toggle" data-height="40px"
                                        @checked($item->isActive())>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="col-lg-4 mb-4">
                                    <label
                                        class="form-label">{{ translate('Send update notification to the buyers') }}</label>
                                    <input type="checkbox" name="update_notification" data-toggle="toggle"
                                        data-height="40px" data-on="{{ translate('Yes') }}"
                                        data-off="{{ translate('No') }}">
                                </div>
                                <button class="btn btn-primary btn-md px-4">{{ translate('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-5 col-xxl-4">
                    @include('admin.items.includes.sidebar')
                </div>
            </div>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/tags-input/bootstrap-tagsinput.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/tags-input/bootstrap-tagsinput.min.js') }}"></script>
        <script src="{{ asset_with_version('vendor/admin/js/item.js') }}"></script>
    @endpush
    @include('admin.partials.ckeditor')
@endsection
