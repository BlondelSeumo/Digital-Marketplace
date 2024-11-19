@extends('admin.layouts.form')
@section('section', translate('Blog'))
@section('title', translate('Edit Blog Category'))
@section('back', route('admin.blog.categories.index'))
@section('container', 'container-max-lg')
@section('content')
    <div class="mb-3">
        <a class="btn btn-outline-secondary" href="{{ $category->getLink() }}" target="_blank"><i
                class="fa fa-eye me-2"></i>{{ translate('View') }}</a>
    </div>
    <form id="vironeer-submited-form" action="{{ route('admin.blog.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card p-2 pb-3">
            <div class="card-body">
                <div class="row g-3 row-cols-1">
                    <div class="col">
                        <label class="form-label">{{ translate('Name') }} </label>
                        <input type="text" name="name" class="form-control" value="{{ $category->name }}" required />
                    </div>
                    <div class="col">
                        <label class="form-label">{{ translate('Slug') }} </label>
                        <input type="text" name="slug" class="form-control" value="{{ $category->slug }}" required />
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
