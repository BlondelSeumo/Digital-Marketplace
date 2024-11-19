@extends('admin.layouts.form')
@section('section', translate('KYC'))
@section('title', translate('KYC Settings'))
@section('container', 'container-max-xl')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.kyc.settings.update') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="card mb-3">
            <div class="card-header">{{ translate('Actions') }}</div>
            <div class="card-body p-4">
                <div class="alert alert-warning">
                    <i class="fa-regular fa-circle-question me-2"></i>
                    <span>{{ translate('When KYC is required the user will not be able to buy or sell items until finish the KYC verification.') }}</span>
                </div>
                <div class="row g-3">
                    <div class="col-lg-4">
                        <label class="form-label">{{ translate('Kyc Status') }}</label>
                        <input type="checkbox" name="kyc[status]" data-toggle="toggle"
                            {{ @$settings->kyc->status ? 'checked' : '' }}>
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label">{{ translate('Required') }}</label>
                        <input type="checkbox" name="kyc[required]" data-toggle="toggle" data-on="{{ translate('Yes') }}"
                            data-off="{{ translate('No') }}" {{ @$settings->kyc->required ? 'checked' : '' }}>
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label">{{ translate('Selfie Verification') }}</label>
                        <input type="checkbox" name="kyc[selfie_verification]" data-toggle="toggle"
                            {{ @$settings->kyc->selfie_verification ? 'checked' : '' }}>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">{{ translate('Avatars') }}</div>
            <div class="card-body p-4">
                <div class="row row-cols-1 g-3">
                    <div class="col-lg-6">
                        <div class="my-3">
                            <div class="vironeer-image-preview-box p-5">
                                <img id="attach-image-preview-0" src="{{ asset(@$settings->kyc->id_front_image) }}"
                                    width="100%" height="200px">
                            </div>
                        </div>
                        <div class="mb-3">
                            <input id="attach-image-targeted-input-0" type="file" name="kyc[id_front_image]"
                                accept=".jpg,.jpeg,.png,.svg" class="form-control" hidden>
                            <button data-id="0" type="button"
                                class="attach-image-button btn btn-secondary btn-lg w-100 mb-2"><i
                                    class="fas fa-camera me-2"></i>{{ translate('Choose ID Front Image') }}</button>
                            <small class="text-muted">{{ translate('Supported (JPEG, JPG, PNG, SVG)') }}</small>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="my-3">
                            <div class="vironeer-image-preview-box p-5">
                                <img id="attach-image-preview-1" src="{{ asset(@$settings->kyc->id_back_image) }}"
                                    width="100%" height="200px">
                            </div>
                        </div>
                        <div class="mb-3">
                            <input id="attach-image-targeted-input-1" type="file" name="kyc[id_back_image]"
                                accept=".jpg,.jpeg,.png,.svg" class="form-control" hidden>
                            <button data-id="1" type="button"
                                class="attach-image-button btn btn-secondary btn-lg w-100 mb-2"><i
                                    class="fas fa-camera me-2"></i>{{ translate('Choose ID Back Image') }}</button>
                            <small class="text-muted">{{ translate('Supported (JPEG, JPG, PNG, SVG)') }}</small>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="my-3">
                            <div class="vironeer-image-preview-box p-5">
                                <img id="attach-image-preview-4" src="{{ asset(@$settings->kyc->passport_image) }}"
                                    width="100%" height="200px">
                            </div>
                        </div>
                        <div class="mb-3">
                            <input id="attach-image-targeted-input-4" type="file" name="kyc[passport_image]"
                                accept=".jpg,.jpeg,.png,.svg" class="form-control" hidden>
                            <button data-id="4" type="button"
                                class="attach-image-button btn btn-secondary btn-lg w-100 mb-2"><i
                                    class="fas fa-camera me-2"></i>{{ translate('Choose ID Passport Image') }}</button>
                            <small class="text-muted">{{ translate('Supported (JPEG, JPG, PNG, SVG)') }}</small>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="my-3">
                            <div class="vironeer-image-preview-box p-5">
                                <img id="attach-image-preview-2" src="{{ asset(@$settings->kyc->selfie_image) }}"
                                    width="200px" height="200px">
                            </div>
                        </div>
                        <div class="mb-3">
                            <input id="attach-image-targeted-input-2" type="file" name="kyc[selfie_image]"
                                accept=".jpg,.jpeg,.png,.svg" class="form-control" hidden>
                            <button data-id="2" type="button"
                                class="attach-image-button btn btn-secondary btn-lg w-100 mb-2"><i
                                    class="fas fa-camera me-2"></i>{{ translate('Choose Selfie Image') }}</button>
                            <small class="text-muted">{{ translate('Supported (JPEG, JPG, PNG, SVG)') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
