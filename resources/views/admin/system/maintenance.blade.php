@extends('admin.layouts.form')
@section('section', translate('System'))
@section('title', translate('Maintenance Mode'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.system.maintenance') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="card mb-3">
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="col-lg-4">
                            <label class="form-label">{{ translate('Status') }}</label>
                            <input type="checkbox" name="maintenance[status]" data-toggle="toggle" data-height="40px"
                                @checked(@$settings->maintenance->status)>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="image-box p-4 border bg-light rounded-2">
                            <h5>{{ translate('Icon') }}</h5>
                            <div class="my-3">
                                <img id="image-preview-0" class="border p-2 rounded-2 bg-light"
                                    src="{{ asset(@$settings->maintenance->image) }}" alt="{{ translate('Image') }}"
                                    height="60px">
                            </div>
                            <input type="file" name="maintenance[icon]" class="form-control form-control-md image-input"
                                data-id="0" accept=".jpg,.jpeg,.png,.svg">
                            <div class="form-text mt-2">
                                {{ translate('Supported (JPEG, JPG, PNG, SVG)') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ translate('Title') }}</label>
                        <input name="maintenance[title]" class="form-control form-control-md"
                            value="{{ @$settings->maintenance->title }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ translate('Body') }}</label>
                        <textarea name="maintenance[body]" class="form-control" rows="8">{{ @$settings->maintenance->body }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ translate('Password') }}</label>
                        <input name="maintenance[password]" class="form-control form-control-md" value="">
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
