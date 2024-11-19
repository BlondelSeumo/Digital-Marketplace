@extends('admin.layouts.form')
@section('section', translate('Settings'))
@section('title', translate('Language'))
@section('container', 'container-max-md')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.settings.language.update') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body p-4">
                <div class="mb-3">
                    <label class="form-label">{{ translate('Language') }}</label>
                    <select name="language[code]" class="form-select form-select-md selectpicker" data-live-search="true"
                        required>
                        @foreach ($languages as $key => $value)
                            <option value="{{ $key }}" @selected(@$settings->language->code == $key)>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label">{{ translate('Direction') }}</label>
                    <select name="language[direction]" class="form-select form-select-md selectpicker" required>
                        <option value="ltr" @selected(@$settings->language->direction == 'ltr')>{{ translate('LTR') }}</option>
                        <option value="rtl" @selected(@$settings->language->direction == 'rtl')>{{ translate('RTL') }}</option>
                    </select>
                </div>
                <a href="{{ route('admin.settings.language.translates.index') }}"
                    class="btn btn-outline-dark btn-md w-100"><i
                        class="fa-solid fa-language me-2"></i>{{ translate('View Translates') }}</a>
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
