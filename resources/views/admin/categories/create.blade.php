@extends('admin.layouts.form')
@section('section', translate('Main Categories'))
@section('title', translate('New Category'))
@section('back', route('admin.categories.index'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="card mb-3">
            <div class="card-header">{{ translate('Category') }}</div>
            <div class="card-body p-4">
                <div class="row g-3 row-cols-1 mb-2">
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
        <div class="card mb-3">
            <div class="card-header">{{ translate('Files') }}</div>
            <div class="card-body p-4">
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label class="form-label">{{ translate('File type') }} </label>
                        <select name="file_type" class="form-select" required>
                            <option value="" selected disabled>{{ translate('Choose') }}</option>
                            @foreach (\App\Models\Category::getFileTypeOptions() as $key => $value)
                                <option value="{{ $key }}" @selected(old('file_type') == $key)>{{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">{{ translate('SEO (Optional)') }}</div>
            <div class="card-body p-4">
                <div class="row g-3 row-cols-1 mb-2">
                    <div class="col">
                        <label class="form-label">{{ translate('Title') }} </label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}"
                            maxlength="70" />
                    </div>
                    <div class="col">
                        <label class="form-label">{{ translate('Description') }} </label>
                        <textarea type="text" name="description" class="form-control" rows="6" maxlength="150" />{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('top_scripts')
        <script>
            "use strict";
            let GET_SLUG_URL = "{{ route('admin.categories.slug') }}";
        </script>
    @endpush
@endsection
