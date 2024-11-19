@extends('admin.layouts.form')
@section('section', translate('Blog'))
@section('title', translate('New blog category'))
@section('back', route('admin.blog.categories.index'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.blog.categories.store') }}" method="POST">
        @csrf
        <div class="card p-2 pb-3">
            <div class="card-body">
                <div class="row g-3 row-cols-1">
                    <div class="col">
                        <label class="form-label">{{ translate('Name') }} </label>
                        <input type="text" name="name" id="create_slug" class="form-control" value="{{ old('name') }}"
                            required autofocus />
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
            let GET_SLUG_URL = "{{ route('admin.blog.categories.slug') }}";
        </script>
    @endpush
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
