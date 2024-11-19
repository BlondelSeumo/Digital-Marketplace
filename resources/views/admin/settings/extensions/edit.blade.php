@extends('admin.layouts.form')
@section('section', translate('Settings'))
@section('title', translate('Edit Extension'))
@section('back', route('admin.settings.extensions.index'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.settings.extensions.update', $extension->id) }}" method="POST">
        @csrf
        <div class="card mb-4">
            <div class="card-body">
                <div class="vironeer-file-preview-box bg-light mb-3 p-4 text-center">
                    <div class="file-preview-box mb-3">
                        <img id="filePreview" src="{{ asset($extension->logo) }}" height="100px" height="100px">
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Name') }} </label>
                        <input class="form-control" value="{{ translate($extension->name) }}" disabled>
                    </div>

                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Status') }} </label>
                        <input type="checkbox" name="status" data-toggle="toggle"
                            {{ $extension->isActive() ? 'checked' : '' }}>
                    </div>
                </div>
            </div>
        </div>
        @if ($extension->instructions)
            <div class="card mb-4">
                <div class="card-header">
                    <i class="far fa-question-circle me-2"></i>
                    {{ translate('Instructions') }}
                </div>
                <div class="card-body">
                    {!! str_replace('[URL]', url('/'), $extension->instructions) !!}
                </div>
            </div>
        @endif
        <div class="card mb-4">
            <div class="card-header">
                <i class="fa fa-cog me-2"></i>
                {{ translate('Settings') }}
            </div>
            <div class="card-body">
                <div class="row g-3 pb-2">
                    @foreach ($extension->settings as $key => $value)
                        <div class="col-lg-12">
                            <label class="form-label capitalize">
                                {{ translate(str_replace('_', ' ', $key)) }}
                            </label>
                            <input type="text" name="settings[{{ $key }}]" value="{{ demo($value) }}"
                                class="form-control remove-spaces">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
@endsection
