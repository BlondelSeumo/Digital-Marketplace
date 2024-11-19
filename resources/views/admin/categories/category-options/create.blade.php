@extends('admin.layouts.form')
@section('section', translate('Category Options'))
@section('title', translate('New Category Option'))
@section('back', route('admin.categories.category-options.index'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.categories.category-options.store') }}" method="POST">
        @csrf
        <div class="card p-2 pb-3">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="col-lg-4">
                            <label class="form-label">{{ translate('Required') }}</label>
                            <input type="checkbox" name="required" data-toggle="toggle" data-height="45px"
                                data-on="{{ translate('Yes') }}" data-off="{{ translate('No') }}" checked>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Category') }}</label>
                        <select name="category" class="form-select form-select-lg selectpicker"
                            title="{{ translate('Category') }}" data-live-search="true" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category') == $category->id)>{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Type') }}</label>
                        <select name="type" class="form-select form-select-lg" required>
                            <option value="1" @selected(old('type') == 1)>{{ translate('Single Select') }}</option>
                            <option value="2" @selected(old('type') == 2)>{{ translate('Multiple Select') }}
                            </option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ translate('Name') }}</label>
                        <input type="text" name="name" class="form-control form-control-lg"
                            value="{{ old('name') }}" required />
                    </div>
                    <div class="col-lg-12">
                        <div class="category-options">
                            <label class="form-label">{{ translate('Options') }}</label>
                            <div class="category-option-1">
                                <div class="input-group">
                                    <input type="text" name="options[]" class="form-control form-control-lg" required>
                                    <button id="addCategoryOption" class="btn btn-primary px-3" type="button">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('top_scripts')
        <script>
            "use strict";
            let categoryOptionsCount = 1;
        </script>
    @endpush
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
