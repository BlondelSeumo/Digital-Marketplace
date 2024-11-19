@extends('admin.layouts.grid')
@section('section', translate('Users'))
@section('title', translate(':name Actions', ['name' => $user->getName()]))
@section('back', route('admin.members.users.index'))
@section('content')
    @include('admin.members.users.includes.elements')
    <div class="row g-3">
        @include('admin.members.users.includes.sidebar')
        <div class="col-lg-9">
            <div class="card h-100">
                <div class="card-header">{{ translate('Actions') }}</div>
                <div class="card-body p-4">
                    <form id="vironeer-submited-form" action="{{ route('admin.members.users.actions.update', $user->id) }}"
                        method="POST">
                        @csrf
                        <div class="row g-3 mb-4">
                            <div class="col-lg-6">
                                <label class="form-label">{{ translate('Account status') }} </label>
                                <input type="checkbox" name="status" data-toggle="toggle"
                                    data-on="{{ translate('Active') }}" data-off="{{ translate('Banned') }}"
                                    {{ $user->isActive() ? 'checked' : '' }}>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">{{ translate('KYC Status') }} </label>
                                <input type="checkbox" name="kyc_status" data-toggle="toggle"
                                    data-on="{{ translate('Verified') }}" data-off="{{ translate('Unverified') }}"
                                    {{ $user->isKycVerified() ? 'checked' : '' }}>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">{{ translate('Email status') }} </label>
                                <input type="checkbox" name="email_status" data-toggle="toggle"
                                    data-on="{{ translate('Verified') }}" data-off="{{ translate('Unverified') }}"
                                    {{ $user->isEmailVerified() ? 'checked' : '' }}>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">{{ translate('Two-Factor Authentication') }} </label>
                                <input id="2faCheckbox" type="checkbox" name="google2fa_status" data-toggle="toggle"
                                    data-on="{{ translate('Active') }}" data-off="{{ translate('Disabled') }}"
                                    {{ $user->has2fa() ? 'checked' : '' }}>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-md">{{ translate('Save Changes') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
