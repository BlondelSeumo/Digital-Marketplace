@extends('admin.layouts.form')
@section('section', translate('Sub Categories'))
@section('title', $subCategory->name)
@section('back', route('admin.categories.sub-categories.index'))
@section('container', 'container-max-lg')
@section('content')
    <div class="mb-3">
        <a class="btn btn-outline-secondary"
            href="{{ route('categories.sub-category', [$subCategory->category->slug, $subCategory->slug]) }}"
            target="_blank"><i class="fa fa-eye me-2"></i>{{ translate('View') }}</a>
    </div>
    <form id="vironeer-submited-form" action="{{ route('admin.categories.sub-categories.update', $subCategory->id) }}"
        method="POST">
        @csrf
        @method('PUT')
        <div class="card p-2 pb-3">
            <div class="card-body">
                <div class="row g-3 row-cols-1">
                    <div class="col">
                        <label class="form-label">{{ translate('Category') }} </label>
                        <select class="form-select" disabled>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected($category->id == $subCategory->category->id)>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label class="form-label">{{ translate('Name') }} </label>
                        <input type="text" name="name" class="form-control" value="{{ $subCategory->name }}"
                            required />
                    </div>
                    <div class="col">
                        <label class="form-label">{{ translate('Slug') }} </label>
                        <input type="text" name="slug" id="show_slug" class="form-control"
                            value="{{ $subCategory->slug }}" required />
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
