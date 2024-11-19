@extends('admin.layouts.grid')
@section('section', translate('Items'))
@section('title', translate('New Item'))
@section('container', 'container-max-lg')
@section('back', route('admin.items.index'))
@section('content')
    <form action="{{ route('admin.items.store') }}" method="POST">
        @csrf
        <div class="card mb-4">
            <div class="card-header py-3 px-4">
                <h5 class="mb-0">{{ translate('Name And Description') }}</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label class="form-label">{{ translate('Name') }}</label>
                        <input id="create_slug" type="text" name="name" class="form-control form-control-md"
                            maxlength="100" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ translate('Slug') }} </label>
                        <input id="show_slug" type="text" name="slug" class="form-control form-control-md"
                            value="{{ old('slug') }}" required />
                    </div>
                    <div class="col-12 ckeditor-sm">
                        <label class="form-label">{{ translate('Description') }}</label>
                        <textarea name="description" class="ckeditor">{{ old('description') }}</textarea>
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
                        <input type="hidden" name="category" value="{{ $category->id }}">
                        <select class="form-select form-select-md" disabled>
                            @foreach ($categories as $mainCategory)
                                <option value="{{ $mainCategory->id }}" @selected($mainCategory->id == $category->id)>
                                    {{ $mainCategory->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if ($category->subCategories->count() > 0)
                        <div class="col-lg-12">
                            <label class="form-label">{{ translate('SubCategory (Optional)') }}</label>
                            <select name="sub_category" class="form-select form-select-md selectpicker" title="--"
                                data-live-search="true">
                                <option value="">--</option>
                                @foreach ($category->subCategories as $subCayegory)
                                    <option value="{{ $subCayegory->id }}" @selected(old('sub_category') == $subCayegory->id)>
                                        {{ $subCayegory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    @if ($category->categoryOptions->count() > 0)
                        @foreach ($category->categoryOptions as $categoryOption)
                            <div class="col-lg-12">
                                <label class="form-label">{{ $categoryOption->name }}</label>
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
                                            if ($categoryOption->isMultiple()) {
                                                $selected = old("options.{$categoryOption->id}")
                                                    ? in_array($option, old("options.{$categoryOption->id}"))
                                                    : false;
                                            } else {
                                                $selected = old("options.{$categoryOption->id}") == $option;
                                            }
                                        @endphp
                                        <option value="{{ $option }}" @selected($selected)>
                                            {{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    @endif
                    <div class="col-12">
                        <label class="form-label">{{ translate('Version (Optional)') }}</label>
                        <input type="text" name="version" class="form-control form-control-md"
                            placeholder="{{ translate('1.0 or 1.0.0') }}" value="{{ old('version') }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ translate('Demo Link (Optional)') }}</label>
                        <div class="form-group">
                            <select name="demo_type" class="form-select form-select-md first-input">
                                @foreach (\App\Models\Item::demoTypeOptions() as $demoTypeKey => $demoTypeValue)
                                    <option value="{{ $demoTypeKey }}">{{ $demoTypeValue }}</option>
                                @endforeach
                            </select>
                            <input type="url" name="demo_link" class="form-control form-control-md second-input"
                                value="{{ old('demo_link') }}" placeholder="https://example.com">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ translate('Tags') }}</label>
                        <input type="text" name="tags" class="form-control form-control-md tags-input"
                            value="{{ old('tags') }}" required>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.items.includes.files-box')
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
                        <input type="radio" class="btn-check support-option" name="support" value="0" id="support1"
                            @checked(old('support') ? old('support') == '0' : true)>
                        <label class="btn btn-outline-dark btn-md" for="support1">{{ translate('No') }}</label>
                        <input type="radio" class="btn-check support-option" name="support" value="1" id="support2"
                            @checked(old('support') == '1')>
                        <label class="btn btn-outline-dark btn-md" for="support2">{{ translate('Yes') }}</label>
                    </div>
                </div>
                <div
                    class="support-instructions ckeditor-sm mt-3 {{ old('support') && old('support') == '1' ? '' : 'd-none' }}">
                    <label class="form-label">{{ translate('Instructions') }}</label>
                    <textarea name="support_instructions" class="ckeditor" rows="6">{{ old('support_instructions') }}</textarea>
                    <div class="form-text">
                        {{ translate('Enter the instructions that the buyer should follow to get support. ') }}</div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header py-3 px-4">
                <h5 class="mb-0">{{ translate('Price') }}</h5>
            </div>
            <div class="card-body p-4">
                <div class="row row-cols-1 g-4 mb-2">
                    <div class="col">
                        <div class="col-lg-3">
                            <label class="form-label"> {{ translate('Free Item') }}</label>
                            <input id="freeItem" type="checkbox" name="free_item" data-toggle="toggle"
                                data-on="{{ translate('Yes') }}" data-off="{{ translate('No') }}" data-height="40px"
                                @checked(old('free_item') == 'on')>
                        </div>
                    </div>
                    <div id="priceOptions" class="col {{ old('free_item') == 'on' ? 'd-none' : '' }}">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                @include('admin.partials.input-price', [
                                    'label' => translate('Regular License Price'),
                                    'name' => 'regular_license_price',
                                    'input_class' => 'form-control-md',
                                    'min' => 1,
                                ])
                            </div>
                            <div class="col-lg-6">
                                @include('admin.partials.input-price', [
                                    'label' => translate('Extended License Price'),
                                    'name' => 'extended_license_price',
                                    'input_class' => 'form-control-md',
                                    'min' => 1,
                                ])
                            </div>
                        </div>
                        <div class="mt-2">
                            {{ translate('Enter 0 to disable the extended license.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header py-3 px-4">
                <h5 class="mb-0">{{ translate('Purchasing') }}</h5>
            </div>
            <div class="card-body p-4">
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check purchase-option" name="purchase_method" value="1"
                        id="purchase1" @checked(old('purchase_method') ? old('purchase_method') == 1 : true)>
                    <label class="btn btn-outline-dark btn-md" for="purchase1">{{ translate('Internal') }}</label>
                    <input type="radio" class="btn-check purchase-option" name="purchase_method" value="2"
                        id="purchase2" @checked(old('purchase_method') == 2)>
                    <label class="btn btn-outline-dark btn-md" for="purchase2">{{ translate('External') }}</label>
                </div>
                <div
                    class="purchase-url mt-4 mb-2 {{ old('purchase_method') && old('purchase_method') == 2 ? '' : 'd-none' }}">
                    <label class="form-label">{{ translate('Purchasing link') }}</label>
                    <input type="url" name="purchase_url" class="form-control form-control-md"
                        placeholder="https://example.com" value="{{ old('purchase_url') }}">
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
                    <input type="checkbox" name="status" data-toggle="toggle" data-height="40px">
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body p-4">
                <div class="col-lg-4 mb-4">
                    <label class="form-label">{{ translate('Send a notification to all subscribers') }}</label>
                    <input type="checkbox" name="subscribers_notification" data-toggle="toggle" data-height="40px"
                        data-on="{{ translate('Yes') }}" data-off="{{ translate('No') }}">
                </div>
                <button class="btn btn-primary btn-md px-4">{{ translate('Save') }}</button>
            </div>
        </div>
    </form>
    @push('top_scripts')
        <script>
            "use strict";
            let GET_SLUG_URL = "{{ route('admin.items.slug') }}";
        </script>
    @endpush
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
