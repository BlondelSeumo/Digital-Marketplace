@extends('admin.layouts.form')
@section('section', translate('Settings'))
@section('title', translate('New Page'))
@section('back', route('admin.settings.pages.index'))
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.settings.pages.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card h-100 p-2">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ translate('Title') }} </label>
                            <input type="text" name="title" id="create_slug" class="form-control"
                                value="{{ old('title') }}" required autofocus />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ translate('Slug') }} </label>
                            <input type="text" name="slug" id="show_slug" class="form-control"
                                value="{{ old('slug') }}" required />
                        </div>
                        <div class="ckeditor-lg mb-3">
                            <label class="form-label">{{ translate('Body') }} </label>
                            <textarea name="body" rows="10" class="form-control ckeditor">{{ old('content') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <label class="form-label">{{ translate('Short description') }} </label>
                        <textarea name="short_description" rows="6" class="form-control"
                            placeholder="{{ translate('50 to 200 character at most') }}" required>{{ old('short_description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('top_scripts')
        <script>
            "use strict";
            let GET_SLUG_URL = "{{ route('admin.settings.pages.slug') }}";
        </script>
    @endpush
    @include('admin.partials.ckeditor')
@endsection
