@extends('admin.layouts.grid')
@section('section', translate('Appearance'))
@section('title', translate('Themes'))
@section('upload_modal', translate('Upload'))
@section('content')
    <div class="row g-4">
        @foreach ($themes as $theme)
            <div class="col-lg-6 col-xl-4">
                <div class="card theme-card">
                    @if ($theme->isActive())
                        <span class="badge bg-success theme-card-active-badge shadow-sm">{{ translate('Active') }}</span>
                    @endif
                    <img src="{{ asset($theme->preview_image) }}" class="card-img-top theme-card-image border-1 border-bottom"
                        alt="{{ $theme->name }}">
                    <div class="card-body">
                        <h5 class="card-title theme-card-title">
                            {{ $theme->name }}
                            <span>v{{ $theme->version }}</span>
                        </h5>
                        <p class="card-text theme-card-text">{{ $theme->description }}</p>
                        <div class="row g-2">
                            <div class="col">
                                <form action="{{ route('admin.appearance.themes.active', $theme->id) }}" method="POST">
                                    @csrf
                                    <button
                                        class="btn btn-primary btn-md w-100 action-confirm {{ $theme->isActive() ? 'disabled' : '' }}"><i
                                            class="fa-solid fa-check-double me-2"></i>{{ translate('Make Active') }}</button>
                                </form>
                            </div>
                            <div class="col-auto">
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-md w-100 dropdown-toggle" type="button"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v fa-sm"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.appearance.themes.settings.index', $theme->id) }}">
                                                <i class="fa fa-cog text-muted me-2"></i>
                                                {{ translate('Settings') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.appearance.themes.custom-css.index', $theme->id) }}">
                                                <i class="fa-solid fa-code me-2"></i>
                                                {{ translate('Custom CSS') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <h5 class="modal-header bg-primary text-white mb-0">{{ translate('Upload a theme') }}</h5>
                <div class="modal-body p-4">
                    <div class="note note-warning">
                        <h5 class="mb-2"><strong>{{ translate('Important!') }}</strong></h5>
                        <ul class="mb-0">
                            <li class="mb-1">
                                {{ translate('Make sure you are uploading the correct files.') }}
                            </li>
                            <li class="mb-0">
                                {{ translate('Before uploading a new theme make sure to take a backup of your website files and database.') }}
                            </li>
                        </ul>
                    </div>
                    <form action="{{ route('admin.appearance.themes.upload') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ translate('Theme Purchase Code') }} </label>
                            <input type="text" name="purchase_code" class="form-control form-control-lg"
                                placeholder="{{ translate('Purchase code') }}" value="{{ old('purchase_code') }}"
                                required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">{{ translate('Theme Files (Zip)') }} </label>
                            <input type="file" name="theme_files" class="form-control form-control-lg" accept=".zip"
                                required>
                        </div>
                        <div class="row justify-content-center g-3">
                            <div class="col-12 col-lg">
                                <button type="button" class="btn btn-secondary btn-lg w-100" data-bs-dismiss="modal"
                                    aria-label="Close">{{ translate('Close') }}</button>
                            </div>
                            <div class="col-12 col-lg">
                                <button class="btn btn-primary btn-lg w-100">{{ translate('Upload') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
