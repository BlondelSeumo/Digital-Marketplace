@extends('admin.layouts.form')
@section('section', translate('Category Options'))
@section('title', $categoryOption->name)
@section('back', route('admin.categories.category-options.index'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.categories.category-options.update', $categoryOption->id) }}"
        method="POST">
        @csrf
        @method('PUT')
        <div class="card p-2 pb-3">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="col-lg-4">
                            <label class="form-label">{{ translate('Required') }}</label>
                            <input type="checkbox" name="required" data-toggle="toggle" data-height="45px"
                                data-on="{{ translate('Yes') }}" data-off="{{ translate('No') }}"
                                @checked($categoryOption->isRequired())>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Category') }}</label>
                        <select class="form-select form-select-lg" disabled>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected($categoryOption->category->id == $category->id)>{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Type') }}</label>
                        <select name="type" class="form-select form-select-lg" required>
                            <option value="1" @selected($categoryOption->type == 1)>{{ translate('Single Select') }}</option>
                            <option value="2" @selected($categoryOption->type == 2)>{{ translate('Multiple Select') }}
                            </option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ translate('Name') }}</label>
                        <input type="text" name="name" class="form-control form-control-lg"
                            value="{{ $categoryOption->name }}" required />
                    </div>
                    <div class="col-lg-12">
                        <div class="category-options">
                            <label class="form-label">{{ translate('Options') }}</label>
                            @foreach ($categoryOption->options as $key => $value)
                                <div class="category-option-{{ $key + 1 }} {{ !$loop->first ? 'mt-3' : '' }}">
                                    <div class="input-group">
                                        <input type="text" name="options[]" class="form-control form-control-lg"
                                            value="{{ $value }}" required>
                                        @if ($loop->first)
                                            <button id="addCategoryOption" class="btn btn-primary px-3" type="button">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-danger px-3 category-option-remove"
                                                data-id="{{ $key + 1 }}" type="button">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('top_scripts')
        <script>
            "use strict";
            let categoryOptionsCount = "{{ count($categoryOption->options) }}";
        </script>
    @endpush
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
