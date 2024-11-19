@extends('admin.layouts.form')
@section('section', translate('Sections'))
@section('title', translate('Edit Home Category'))
@section('back', route('admin.sections.home-categories.index'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.sections.home-categories.update', $homeCategory->id) }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card p-2 pb-3">
            <div class="card-body">
                <div class="row g-3 row-cols-1">
                    <div class="col">
                        <div class="vironeer-file-preview-box bg-light p-4 text-center">
                            <div class="file-preview-box mb-3">
                                <img id="filePreview" src="{{ $homeCategory->getIcon() }}" width="80" height="80">
                            </div>
                            <button id="selectFileBtn" type="button"
                                class="btn btn-secondary btn-md mb-2">{{ translate('Choose Icon') }}</button>
                            <input id="selectedFileInput" type="file" name="icon" accept=".png, .jpg, .jpeg, .webp"
                                hidden>
                            <small class="text-muted d-block">{{ translate('Allowed (PNG, JPG, JPEG, WEBP)') }}</small>
                        </div>
                    </div>
                    <div class="col">
                        <label class="form-label">{{ translate('Name') }} </label>
                        <input type="text" name="name" class="form-control form-control-lg"
                            value="{{ $homeCategory->name }}" required />
                    </div>
                    <div class="col">
                        <label class="form-label">{{ translate('Link') }} </label>
                        <input type="text" name="link" class="form-control form-control-lg"
                            value="{{ $homeCategory->link }}" required />
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
