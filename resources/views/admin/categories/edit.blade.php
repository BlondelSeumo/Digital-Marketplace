@extends('admin.layouts.form')
@section('section', translate('Main Categories'))
@section('title', $category->name)
@section('back', route('admin.categories.index'))
@section('container', 'container-max-lg')
@section('content')
    <div class="mb-3">
        <a class="btn btn-outline-secondary" href="{{ route('categories.category', $category->slug) }}" target="_blank"><i
                class="fa fa-eye me-2"></i>{{ translate('View') }}</a>
    </div>
    <form id="vironeer-submited-form" action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card mb-3">
            <div class="card-header">{{ translate('Category') }}</div>
            <div class="card-body p-4">
                <div class="row g-3 row-cols-1 mb-2">
                    <div class="col">
                        <label class="form-label">{{ translate('Name') }} </label>
                        <input type="text" name="name" class="form-control" value="{{ $category->name }}" required />
                    </div>
                    <div class="col">
                        <label class="form-label">{{ translate('Slug') }} </label>
                        <input type="text" name="slug" id="show_slug" class="form-control"
                            value="{{ $category->slug }}" required />
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">{{ translate('Files') }}</div>
            <div class="card-body p-4">
                <div class="row g-3 mb-2">
                    <div class="col-12">
                        <label class="form-label">{{ translate('File type') }} </label>
                        <select class="form-select" disabled>
                            @foreach (\App\Models\Category::getFileTypeOptions() as $key => $value)
                                <option value="{{ $key }}" @selected($category->file_type == $key)>{{ $value }}
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
                <div class="row g-3 row-cols-1 mb-3">
                    <div class="col">
                        <label class="form-label">{{ translate('Title') }} </label>
                        <input type="text" name="title" class="form-control" value="{{ $category->title }}"
                            maxlength="70" />
                    </div>
                    <div class="col">
                        <label class="form-label">{{ translate('Description') }} </label>
                        <textarea type="text" name="description" class="form-control" rows="6" maxlength="150" />{{ $category->description }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
