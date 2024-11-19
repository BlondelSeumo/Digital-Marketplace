@extends('admin.layouts.form')
@section('section', translate('Sections'))
@section('title', translate('Announcement'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.sections.announcement.update') }}" method="POST">
        @csrf
        <div class="card mb-4">
            <div class="card-body p-4">
                <div class="mb-3 col-lg-4">
                    <label class="form-label">{{ translate('Status') }}</label>
                    <input type="checkbox" name="announcement[status]" data-toggle="toggle" data-height="40"
                        {{ @$settings->announcement->status ? 'checked' : '' }}>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ translate('Announcement Body') }}</label>
                    <textarea name="announcement[body]" class="form-control" rows="6">{{ @$settings->announcement->body }}</textarea>
                </div>
                <div class="row g-3">
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Button Title') }}</label>
                        <input type="text" name="announcement[button_title]" class="form-control form-control-lg"
                            value="{{ @$settings->announcement->button_title }}">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Button Link') }}</label>
                        <input type="text" name="announcement[button_link]" class="form-control form-control-lg"
                            value="{{ @$settings->announcement->button_link }}">
                    </div>
                    <div class="col-lg-12">
                        <label class="form-label">{{ translate('Announcement Background Color') }}</label>
                        <div class="colorpicker">
                            <input type="text" name="announcement[background_color]"
                                class="form-control form-control-lg coloris"
                                value="{{ @$settings->announcement->background_color }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Button Background Color') }}</label>
                        <div class="colorpicker">
                            <input type="text" name="announcement[button_background_color]"
                                class="form-control form-control-lg coloris"
                                value="{{ @$settings->announcement->button_background_color }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Button Text Color') }}</label>
                        <div class="colorpicker">
                            <input type="text" name="announcement[button_text_color]"
                                class="form-control form-control-lg coloris"
                                value="{{ @$settings->announcement->button_text_color }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/coloris/coloris.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/coloris/coloris.min.js') }}"></script>
    @endpush
@endsection
