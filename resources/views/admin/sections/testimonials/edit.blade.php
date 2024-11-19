@extends('admin.layouts.form')
@section('section', translate('Sections'))
@section('title', translate('Edit Testimonial'))
@section('back', route('admin.sections.testimonials.index'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.sections.testimonials.update', $testimonial->id) }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card p-2 mb-3">
            <div class="card-body">
                <div class="vironeer-file-preview-box mb-3 bg-light p-4 text-center">
                    <div class="file-preview-box mb-3">
                        <img id="filePreview" src="{{ $testimonial->getAvatar() }}" class="rounded-3" width="80px"
                            height="80px">
                    </div>
                    <button id="selectFileBtn" type="button"
                        class="btn btn-secondary btn-md mb-2">{{ translate('Choose Avatar') }}</button>
                    <input id="selectedFileInput" type="file" name="avatar" accept=".png, .jpg, .jpeg, .webp" hidden>
                    <small class="text-muted d-block">{{ translate('Allowed (PNG, JPG, JPEG, WEBP)') }}</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ translate('Name') }}</label>
                    <input type="text" name="name" class="form-control form-control-lg"
                        value="{{ $testimonial->name }}" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ translate('Title') }}</label>
                    <input type="text" name="title" class="form-control form-control-lg"
                        value="{{ $testimonial->title }}" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ translate('Body') }}</label>
                    <textarea name="body" rows="10" class="form-control form-control-lg" required>{{ $testimonial->body }}</textarea>
                </div>
                <div class="mb-2">
                    <label class="form-label">{{ translate('Stars') }}</label>
                    <input type="number" name="stars" class="form-control form-control-lg" min="1" max="5"
                        value="{{ $testimonial->stars }}" required />
                </div>
            </div>
        </div>
    </form>
@endsection
