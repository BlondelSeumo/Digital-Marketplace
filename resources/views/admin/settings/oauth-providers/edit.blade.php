@extends('admin.layouts.form')
@section('section', translate('Settings'))
@section('title', translate('Edit OAuth Provider'))
@section('back', route('admin.settings.oauth-providers.index'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.settings.oauth-providers.update', $oauthProvider->id) }}"
        method="POST">
        @csrf
        <div class="card mb-4">
            <div class="card-body">
                <div class="vironeer-file-preview-box bg-light mb-3 p-4 text-center">
                    <div class="file-preview-box mb-3">
                        <img id="filePreview" src="{{ asset($oauthProvider->logo) }}" height="100px" height="100px">
                    </div>
                </div>
                <div class="row g-3 mb-2">
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Name') }} </label>
                        <input class="form-control" value="{{ $oauthProvider->name }}" disabled>
                    </div>

                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Status') }} </label>
                        <input type="checkbox" name="status" data-toggle="toggle"
                            {{ $oauthProvider->isActive() ? 'checked' : '' }}>
                    </div>
                </div>
            </div>
        </div>
        @if ($oauthProvider->instructions)
            <div class="card mb-4">
                <div class="card-header">
                    <i class="far fa-question-circle me-2"></i>{{ translate('Instructions') }}
                </div>
                <div class="card-body">
                    {!! str_replace('[URL]', url('/'), $oauthProvider->instructions) !!}
                </div>
            </div>
        @endif
        <div class="card mb-4">
            <div class="card-header">
                <i class="fa fa-key me-2"></i> {{ translate('Credentials') }}
            </div>
            <div class="card-body">
                <div class="row g-3 pb-2">
                    @foreach ($oauthProvider->credentials as $key => $value)
                        <div class="col-lg-12">
                            <label class="form-label capitalize">
                                {{ translate(str_replace('_', ' ', $key)) }} :
                            </label>
                            <input type="text" name="credentials[{{ $key }}]" value="{{ demo($value) }}"
                                class="form-control remove-spaces">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
@endsection
