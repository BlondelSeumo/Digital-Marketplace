@extends('admin.layouts.form')
@section('section', translate('System'))
@section('title', translate('Admin Panel Style'))
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.system.admin-panel-style') }}" method="POST">
        @csrf
        <div class="card mb-3">
            <div class="card-header">
                {{ translate('Colors') }}
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach (@$settings->system_admin->colors as $key => $value)
                        <div class="col-lg-6 col-xl-4">
                            <label class="form-label"> {{ translate(ucfirst(str_replace('_', ' ', $key))) }}</label>
                            <div class="colorpicker">
                                <input type="text" name="system_admin[colors][{{ $key }}]"
                                    class="form-control coloris" value="{{ $value }}" required>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                {{ translate('Custom CSS') }}
            </div>
            <div class="card-body p-0">
                <textarea name="custom_css" id="css-editor" class="form-control">{{ $customCssFile }}</textarea>
            </div>
        </div>
    </form>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/coloris/coloris.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/codemirror/codemirror.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/codemirror/monokai.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/coloris/coloris.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/codemirror/codemirror.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/codemirror/css.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/codemirror/sublime.min.js') }}"></script>
    @endpush
@endsection
