@extends('admin.layouts.form')
@section('section', translate('Settings'))
@section('title', translate('Edit Page'))
@section('back', route('admin.settings.pages.index'))
@section('content')
    <div class="mb-3">
        <a class="btn btn-outline-secondary" href="{{ route('page', $page->slug) }}" target="_blank"><i
                class="fa fa-eye me-2"></i>{{ translate('Preview') }}</a>
    </div>
    <form id="vironeer-submited-form" action="{{ route('admin.settings.pages.update', $page->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card h-100 p-2">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ translate('Title') }} </label>
                            <input type="text" name="title" class="form-control" required
                                value="{{ $page->title }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ translate('Slug') }} </label>
                            <input type="text" name="slug" class="form-control" required
                                value="{{ $page->slug }}" />
                        </div>
                        <div class="ckeditor-lg mb-3">
                            <label class="form-label">{{ translate('Body') }} </label>
                            <textarea name="body" rows="10" class="form-control ckeditor">{{ $page->body }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <label class="form-label">{{ translate('Short description') }} </label>
                        <textarea name="short_description" rows="6" class="form-control"
                            placeholder="{{ translate('50 to 200 character at most') }}" required>{{ $page->short_description }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @include('admin.partials.ckeditor')
@endsection
