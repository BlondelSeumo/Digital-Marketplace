@extends('admin.layouts.grid')
@section('section', translate('System'))
@section('title', translate('Addons'))
@section('upload_modal', translate('Upload'))
@section('container', 'container-max-lg')
@section('content')
    @if ($addons->count() > 0)
        <div class="card">
            <ol class="list-group list-group-flush">
                @foreach ($addons as $addon)
                    <li class="list-group-item px-4 py-4">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                @if ($addon->action)
                                    <a href="{{ adminUrl($addon->action) }}">
                                        <img src="{{ asset($addon->thumbnail) }}" alt="{{ $addon->name }}" width="70px"
                                            height="70px">
                                    </a>
                                @else
                                    <img src="{{ asset($addon->thumbnail) }}" alt="{{ $addon->name }}" width="70px"
                                        height="70px">
                                @endif
                            </div>
                            <div class="col">
                                <div class="row g-3 align-items-center">
                                    <div class="col-xl-10">
                                        @if ($addon->action)
                                            <a href="{{ adminUrl($addon->action) }}">
                                                <h5 class="text-dark">{{ $addon->name }}</h5>
                                            </a>
                                        @else
                                            <h5 class="text-dark">{{ $addon->name }}</h5>
                                        @endif
                                        <span
                                            class="text-muted">{{ translate('Version: :version', ['version' => $addon->version]) }}</span>
                                    </div>
                                    <div class="col">
                                        <div class="row g-3">
                                            @if (!$addon->hasNoStatus())
                                                <div class="col-12 col-lg-6 col-xl-12">
                                                    <input class="addon-status" type="checkbox" name="status"
                                                        data-toggle="toggle"
                                                        data-update-link="{{ route('admin.system.addons.update', $addon->id) }}"
                                                        {{ $addon->isActive() ? 'checked' : '' }}>
                                                </div>
                                            @endif
                                            @if ($addon->action)
                                                <div class="col-12 col-lg-6 col-xl-12">
                                                    <a href="{{ adminUrl($addon->action) }}"
                                                        class="btn btn-secondary w-100"><i
                                                            class="fa fa-cog me-2"></i>{{ translate('Settings') }}</a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    @else
        <div class="card">
            <div class="card-body">
                @include('admin.partials.empty', ['empty_classes' => 'empty-lg'])
            </div>
        </div>
    @endif
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <h5 class="modal-header bg-primary text-white mb-0">{{ translate('Upload an addon') }}</h5>
                <div class="modal-body p-4">
                    <div class="note note-warning">
                        <h5 class="mb-2"><strong>{{ translate('Important!') }}</strong></h5>
                        <ul class="mb-0">
                            <li class="mb-1">
                                {{ translate('Make sure you are uploading the correct files.') }}
                            </li>
                            <li class="mb-0">
                                {{ translate('Before uploading a new addon make sure to take a backup of your website files and database.') }}
                            </li>
                        </ul>
                    </div>
                    <form action="{{ route('admin.system.addons.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ translate('Addon Purchase Code') }} </label>
                            <input type="text" name="purchase_code" class="form-control form-control-lg"
                                placeholder="{{ translate('Purchase code') }}" value="{{ old('purchase_code') }}"
                                required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">{{ translate('Addon Files (Zip)') }} </label>
                            <input type="file" name="addon_files" class="form-control form-control-lg" accept=".zip"
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
