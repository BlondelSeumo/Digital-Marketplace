@extends('admin.layouts.form')
@section('section', translate('Sub Categories'))
@section('title', translate('New Sub Category'))
@section('back', route('admin.categories.sub-categories.index'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.categories.sub-categories.store') }}" method="POST">
        @csrf
        <div class="card p-2 pb-3">
            <div class="card-body">
                <div class="row g-3 row-cols-1">
                    <div class="col">
                        <label class="form-label">{{ translate('Category') }} </label>
                        <select name="category" class="form-select selectpicker" title="{{ translate('Category') }}"
                            data-live-search="true">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label class="form-label">{{ translate('Name') }} </label>
                        <input type="text" name="name" id="create_slug" class="form-control"
                            value="{{ old('name') }}" required autofocus />
                    </div>
                    <div class="col">
                        <label class="form-label">{{ translate('Slug') }} </label>
                        <input type="text" name="slug" id="show_slug" class="form-control" value="{{ old('slug') }}"
                            required />
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('top_scripts')
        <script>
            "use strict";
            let GET_SLUG_URL = "{{ route('admin.categories.sub-categories.slug') }}";
        </script>
    @endpush
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
