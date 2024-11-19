@extends('admin.layouts.form')
@section('section', translate('Blog'))
@section('title', translate('Edit Blog Article'))
@section('back', route('admin.blog.articles.index'))
@section('content')
    <div class="mb-3">
        <a class="btn btn-outline-secondary" href="{{ $article->getLink() }}" target="_blank"><i
                class="fa fa-eye me-2"></i>{{ translate('View') }}</a>
    </div>
    <form id="vironeer-submited-form" action="{{ route('admin.blog.articles.update', $article->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <div class="card h-100 p-2 mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ translate('Title') }} </label>
                            <input type="text" name="title" id="create_slug" class="form-control"
                                value="{{ $article->title }}" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ translate('Slug') }} </label>
                            <input type="text" name="slug" class="form-control" value="{{ $article->slug }}"
                                required />
                        </div>
                        <div class="ckeditor-lg mb-0">
                            <label class="form-label">{{ translate('Body') }} </label>
                            <textarea name="body" rows="10" class="form-control ckeditor">{{ $article->body }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100 p-2 mb-3">
                    <div class="card-body">
                        <div class="vironeer-file-preview-box mb-3 bg-light p-5 text-center">
                            <div class="file-preview-box mb-3">
                                <img id="filePreview" src="{{ asset($article->image) }}" class="rounded-3 w-100"
                                    height="160px">
                            </div>
                            <button id="selectFileBtn" type="button" class="btn btn-secondary mb-2"><i
                                    class="fas fa-camera me-2"></i>{{ translate('Choose Image') }}</button>
                            <input id="selectedFileInput" type="file" name="image" accept=".png, .jpg, .jpeg, .webp"
                                hidden>
                            <small class="text-muted d-block">{{ translate('Allowed (PNG, JPG, JPEG, WEBP)') }}</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ translate('Category') }} </label>
                            <select id="articleCategories" name="category" class="form-select selectpicker"
                                data-live-search="true" title="{{ translate('Category') }}" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $article->category->id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">{{ translate('Short description') }} </label>
                            <textarea name="short_description" rows="6" class="form-control"
                                placeholder="{{ translate('50 to 200 character at most') }}" required>{{ $article->short_description }}</textarea>
                        </div>
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
    @include('admin.partials.ckeditor')
@endsection
