@extends('admin.layouts.form')
@section('section', translate('Newsletter'))
@section('title', translate('Newsletter Settings'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.newsletter.settings.update') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="card mb-3">
            <div class="card-header">{{ translate('Actions') }}</div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Newsletter Status') }}</label>
                        <input type="checkbox" name="newsletter[status]" data-toggle="toggle"
                            {{ @$settings->newsletter->status ? 'checked' : '' }}>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Show Popup') }}</label>
                        <input type="checkbox" name="newsletter[popup_status]" data-toggle="toggle"
                            data-on="{{ translate('Yes') }}" data-off="{{ translate('No') }}"
                            {{ @$settings->newsletter->popup_status ? 'checked' : '' }}>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Show Form In Footer') }}</label>
                        <input type="checkbox" name="newsletter[footer_status]" data-toggle="toggle"
                            data-on="{{ translate('Yes') }}" data-off="{{ translate('No') }}"
                            {{ @$settings->newsletter->footer_status ? 'checked' : '' }}>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Register New Users') }}</label>
                        <input type="checkbox" name="newsletter[register_new_users]" data-toggle="toggle"
                            data-on="{{ translate('Yes') }}" data-off="{{ translate('No') }}"
                            {{ @$settings->newsletter->register_new_users ? 'checked' : '' }}>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">{{ translate('Popup') }}</div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="image-box p-4 border bg-light rounded-2">
                            <h5>{{ translate('PopUp Image') }}</h5>
                            <div class="my-3">
                                <img id="image-preview-0" class="border p-2 rounded-2 bg-light"
                                    src="{{ asset(@$settings->newsletter->popup_image) }}"
                                    alt="{{ translate('PopUp Image') }}" width="250px" height="150px">
                            </div>
                            <input type="file" name="newsletter[popup_image]" class="form-control image-input"
                                data-id="0" accept=".jpg,.jpeg,.png,.webp">
                            <div class="form-text mt-2">
                                {{ translate('Supported (JPEG, JPG, PNG, WEBP) Size (1200x800px)') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ translate('PopUp Reminder After') }}</label>
                        <div class="input-group">
                            <input type="number" name="newsletter[popup_reminder_time]" class="form-control"
                                value="{{ @$settings->newsletter->popup_reminder_time }}">
                            <span class="input-group-text">{{ translate('Hours') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
