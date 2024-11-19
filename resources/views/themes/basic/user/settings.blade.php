@extends('themes.basic.user.layouts.app')
@section('title', translate('Settings'))
@section('breadcrumbs', Breadcrumbs::render('user.settings'))
@section('content')
    <div class="box box-padding mb-3">
        <div class="form-section">
            <h5 class="mb-0">{{ translate('Account details') }}</h5>
        </div>
        <form action="{{ route('user.settings.index') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <div class="mb-4">
                    <div class="row align-items-center g-3">
                        <div class="col-auto">
                            <div class="user-avatar user-avatar-lg d-block me-0">
                                <img id="attach-image-preview-1" src="{{ $user->getAvatar() }}"
                                    alt="{{ $user->getName() }}">
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-light attach-image-button text-dark border"
                                data-id="1">
                                <i class="fas fa-camera me-2"></i>{{ translate('Choose Avatar') }}
                            </button>
                            <input id="attach-image-targeted-input-1" name="avatar" type="file" hidden>
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-12 col-lg-6">
                        <label class="form-label">{{ translate('First Name') }}</label>
                        <input type="firstname" name="firstname" class="form-control form-control-md"
                            value="{{ $user->firstname }}" required>
                    </div>
                    <div class="col-12 col-lg-6">
                        <label class="form-label">{{ translate('Last Name') }}</label>
                        <input type="lastname" name="lastname" class="form-control form-control-md"
                            value="{{ $user->lastname }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ translate('Username') }}</label>
                        <input type="text" name="username" class="form-control form-control-md"
                            value="{{ $user->username }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ translate('Email address') }}</label>
                        <input type="email" name="email" class="form-control form-control-md"
                            value="{{ $user->email }}">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Address line 1') }}</label>
                        <input type="text" name="address_line_1" class="form-control form-control-md"
                            value="{{ @$user->address->line_1 }}" required>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Address line 2') }}</label>
                        <input type="text" name="address_line_2" class="form-control form-control-md"
                            value="{{ @$user->address->line_2 }}">
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">{{ translate('City') }}</label>
                            <input type="text" name="city" class="form-control form-control-md"
                                value="{{ @$user->address->city }}" required>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">{{ translate('State') }}</label>
                            <input type="text" name="state" class="form-control form-control-md"
                                value="{{ @$user->address->state }}" required>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">{{ translate('Postal code') }}</label>
                            <input type="text" name="zip" class="form-control form-control-md"
                                value="{{ @$user->address->zip }}" required>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <label class="form-label">{{ translate('Country') }}</label>
                        <select name="country" class="form-select form-select-md" required>
                            <option value="">--</option>
                            @foreach (countries() as $countryCode => $countryName)
                                <option value="{{ $countryCode }}" @selected($countryCode == @$user->address->country)>
                                    {{ $countryName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary btn-md px-4">{{ translate('Save Changes') }}</button>
        </form>
    </div>
    @if (licenseType(2) && $settings->premium->status)
        <div class="box box-padding mb-3">
            <div class="form-section">
                <div class="row align-items-center g-3">
                    <div class="col">
                        <h5 class="mb-0">{{ translate('Subscription') }}</h5>
                    </div>
                    @if ($user->isSubscribed())
                        <div class="col-auto">
                            <a href="{{ route('items.index', ['premium' => 'true']) }}"
                                class="btn btn-outline-primary w-100">
                                <i class="fa-solid fa-crown me-1"></i>
                                {{ translate('Browse premium items') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            @if ($user->isSubscribed())
                <div class="border bg-color rounded-2 p-4">
                    @php
                        $subscription = $user->subscription;
                    @endphp
                    <div class="row align-items-center g-4 p-2">
                        <div class="col-12 col-lg">
                            <h3 class="mb-3">
                                {{ translate(':plan_name (:plan_interval)', [
                                    'plan_name' => $subscription->plan->name,
                                    'plan_interval' => $subscription->plan->getIntervalName(),
                                ]) }}
                            </h3>
                            <p class="text-muted mb-0">
                                {{ translate('Expiry date') }}:
                                @if ($subscription->plan->isLifetime())
                                    <span>∞</span>
                                @else
                                    <span
                                        class="{{ $subscription->isAboutToExpire() ? 'text-warning' : ($subscription->isExpired() ? 'text-danger' : '') }}">{{ dateFormat($subscription->expiry_at) }}</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-12 col-lg-auto">
                            <div class="row row-cols-auto g-3">
                                @if (
                                    ($subscription->isAboutToExpire() && !authUser()->subscription->plan->isFree()) ||
                                        ($subscription->isExpired() && !authUser()->subscription->plan->isFree()))
                                    <div class="col">
                                        @if ($subscription->plan->isActive())
                                            <form action="{{ route('premium.subscribe', $subscription->plan->id) }}"
                                                method="POST">
                                                @csrf
                                                <button class="btn btn-primary action-confirm">
                                                    <i class="fa-solid fa-arrows-rotate me-1"></i>
                                                    {{ translate('Renew') }}
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('premium.index') }}" class="btn btn-primary"><i
                                                    class="fa-solid fa-arrows-rotate me-1"></i>
                                                {{ translate('Renew') }}
                                            </a>
                                        @endif
                                    </div>
                                @endif
                                <div class="col">
                                    <a href="{{ route('premium.index') }}" class="btn btn-secondary">
                                        <i class="fa-regular fa-circle-up me-1"></i>
                                        {{ translate('Upgrade') }}
                                    </a>
                                </div>
                                <div class="col">
                                    <form action="{{ route('user.settings.subscription.cancel') }}" method="POST">
                                        @csrf
                                        <button class="btn btn-danger action-confirm">
                                            <i class="fa-regular fa-circle-xmark me-1"></i>
                                            {{ translate('Cancel') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-primary mb-0">
                    <h4>{{ translate('You are not subscribed') }}</h4>
                    <p class="mb-3">
                        {{ translate('You are not subscribed to any plan, you can subscribe by clicking on the button below') }}
                    </p>
                    <a href="{{ route('premium.index') }}"
                        class="btn btn-outline-primary px-4">{{ translate('Subscribe') }}</a>
                </div>
            @endif
        </div>
    @endif
    <div class="box box-padding mb-3">
        <div class="form-section">
            <h5 class="mb-0">{{ translate('Change Password') }}</h5>
        </div>
        <form action="{{ route('user.settings.password.update') }}" method="POST">
            @csrf
            <div class="mb-4">
                <div class="mb-3">
                    <label class="form-label">{{ translate('Password') }}</label>
                    <input type="password" class="form-control form-control-md " name="current-password" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ translate('New Password') }}</label>
                    <input type="password" class="form-control form-control-md " name="new-password" required>
                </div>
                <div class="mb-0">
                    <label class="form-label">{{ translate('Confirm New Password') }}</label>
                    <input type="password" class="form-control form-control-md " name="new-password_confirmation"
                        required>
                </div>
            </div>
            <button class="btn btn-primary btn-md px-4">{{ translate('Save Changes') }}</button>
        </form>
    </div>
    <div class="box box-padding">
        <div class="form-section">
            <h5 class="mb-0">{{ translate('2FA Authentication') }}</h5>
        </div>
        <div>
            <p class="text-muted">
                {{ translate('Two-factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two-factor authentication protects against phishing, social engineering, and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.') }}
            </p>
            <div class="mt-4">
                <div class="row g-3 align-items-center">
                    @if (!$user->google2fa_status)
                        <div class="col-12 col-lg-auto col-xl-auto">
                            <div class="text-center">
                                {!! $qr_image !!}
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-xxl-3">
                            <div class="input-group mb-3">
                                <input id="input-code" type="text" class="form-control form-control-md"
                                    value="{{ $user->google2fa_secret }}" readonly>
                                <button class="btn btn-primary btn-md btn-copy" data-clipboard-target="#input-code">
                                    <i class="far fa-clone"></i>
                                </button>
                            </div>
                            <button class="btn btn-primary btn-md px-4 w-100" data-bs-toggle="modal"
                                data-bs-target="#towfactorModal">{{ translate('Enable 2FA Authentication') }}</button>
                        </div>
                    @else
                        <div class="col-lg-4">
                            <burron class="btn btn-danger btn-md px-4 w-100 " data-bs-toggle="modal"
                                data-bs-target="#towfactorDisableModal">{{ translate('Disable 2FA Authentication') }}
                            </burron>
                        </div>
                    @endif
                </div>
            </div>
            <div class="mt-4">
                <p class="text-muted mb-2">
                    {{ translate('To use the two factor authentication, you have to install a Google Authenticator compatible app. Here are some that are currently available:') }}
                </p>
                <li class="mb-1"><a target="_blank"
                        href="https://apps.apple.com/us/app/google-authenticator/id388497605">{{ translate('Google Authenticator for iOS') }}</a>
                </li>
                <li class="mb-1"><a target="_blank"
                        href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en&gl=US">{{ translate('Google Authenticator for Android') }}</a>
                </li>
                <li class="mb-1"><a target="_blank"
                        href="https://apps.apple.com/us/app/microsoft-authenticator/id983156458">{{ translate('Microsoft Authenticator for iOS') }}</a>
                </li>
                <li class="mb-0"><a target="_blank"
                        href="https://play.google.com/store/apps/details?id=com.azure.authenticator&hl=en_US&gl=US">{{ translate('Microsoft Authenticator for Android') }}</a>
                </li>
            </div>
        </div>
    </div>
    @if (!$user->google2fa_status)
        <div class="modal fade" id="towfactorModal" aria-labelledby="towfactorModalLabel" data-bs-backdrop="static"
            data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4">
                    <div class="modal-header border-0 p-0 mb-3">
                        <h5 class="modal-title" id="createFolderModalLabel">{{ translate('OTP Code') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('user.settings.2fa.enable') }}" method="POST">
                        @csrf
                        <div class="modal-body p-0">
                            <div class="mb-4">
                                <input type="text" name="otp_code" class="form-control form-control-md input-numeric"
                                    placeholder="• • • • • •" maxlength="6" required>
                            </div>
                            <div class="row justify-content-center g-3">
                                <div class="col-12 col-lg">
                                    <button type="button" class="btn btn-outline-primary btn-md w-100"
                                        data-bs-dismiss="modal">{{ translate('Close') }}</button>
                                </div>
                                <div class="col-12 col-lg">
                                    <button type="submit"
                                        class="btn btn-primary btn-md w-100 ">{{ translate('Enable') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="modal fade" id="towfactorDisableModal" tabindex="-1" aria-labelledby="towfactorDisableModalLabel"
            data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4">
                    <div class="modal-header border-0 p-0 mb-3">
                        <h5 class="modal-title" id="createFolderModalLabel">{{ translate('OTP Code') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('user.settings.2fa.disable') }}" method="POST">
                        @csrf
                        <div class="modal-body p-0">
                            <div class="mb-4">
                                <input type="text" name="otp_code" class="form-control form-control-md input-numeric"
                                    placeholder="• • • • • •" maxlength="6" required>
                            </div>
                            <div class="row justify-content-center g-3">
                                <div class="col-12 col-lg">
                                    <button type="button" class="btn btn-outline-danger btn-md w-100"
                                        data-bs-dismiss="modal">{{ translate('Close') }}</button>
                                </div>
                                <div class="col-12 col-lg">
                                    <button type="submit"
                                        class="btn btn-danger btn-md w-100">{{ translate('Disable') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/clipboard/clipboard.min.js') }}"></script>
    @endpush
@endsection
