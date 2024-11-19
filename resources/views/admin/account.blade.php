@extends('admin.layouts.grid')
@section('title', translate('Account settings'))
@section('container', 'container-max-lg')
@section('content')
    <div class="details mb-4">
        <form action="{{ route('admin.account.details') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header">
                    <span>{{ translate('Account Details') }}</span>
                </div>
                <div class="card-body">
                    <div class="row g-3 align-items-center mb-4">
                        <div class="col-auto">
                            <img id="filePreview" src="{{ $admin->getAvatar() }}" alt="{{ $admin->getName() }}"
                                class="rounded-3 border" width="70px" height="70px">
                        </div>
                        <div class="col-auto">
                            <button id="selectFileBtn" type="button" class="btn btn-secondary"><i
                                    class="fas fa-camera me-2"></i>{{ translate('Choose Image') }}</button>
                            <input id="selectedFileInput" type="file" name="avatar"
                                accept="image/png, image/jpg, image/jpeg" hidden>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-lg-6">
                            <label class="form-label">{{ translate('First Name') }} </label>
                            <input type="firstname" class="form-control  form-control-lg" name="firstname"
                                value="{{ $admin->firstname }}" required>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">{{ translate('Last Name') }} </label>
                            <input type="lastname" class="form-control  form-control-lg" name="lastname"
                                value="{{ $admin->lastname }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ translate('Username') }} </label>
                        <input type="text" name="username" class="form-control form-control-lg"
                            value="{{ $admin->username }}" minlength="5" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ translate('Email Address') }} </label>
                        <input type="email" class="form-control  form-control-lg" name="email"
                            value="{{ $admin->email }}" required>
                    </div>
                    <button class="btn btn-primary btn-lg">{{ translate('Save Changes') }}</button>
                </div>
            </div>
        </form>
    </div>
    <div class="password mb-4">
        <form id="vironeer-submited-form" action="{{ route('admin.account.password') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-header">
                    <span>{{ translate('Change Password') }}</span>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">{{ translate('Password') }} </label>
                        <input type="password" class="form-control  form-control-lg" name="current-password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ translate('New Password') }} </label>
                        <input type="password" class="form-control  form-control-lg" name="new-password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ translate('Confirm New Password') }} </label>
                        <input type="password" class="form-control  form-control-lg" name="new-password_confirmation"
                            required>
                    </div>
                    <button class="btn btn-primary btn-lg">{{ translate('Save Changes') }}</button>
                </div>
            </div>
        </form>
    </div>
    <div class="2fa">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>{{ translate('2Factor Authentication') }}</span>
                @if (!$admin->google2fa_status)
                    <span class="badge bg-danger">{{ translate('Disabled') }}</span>
                @else
                    <span class="badge bg-success">{{ translate('Enabled') }}</span>
                @endif
            </div>
            <div class="card-body">
                <p class="mb-0">
                    {{ translate('Two-factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two-factor authentication protects against phishing, social engineering, and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.') }}
                </p>
                <div class="col-lg-6 m-auto my-4">
                    <div class="border p-4 rounded-3 text-center">
                        @if (!$admin->google2fa_status)
                            <div class="mb-1">
                                {!! $qrCode !!}
                            </div>
                            <div class="input-group mb-3">
                                <input id="input-secret" type="text" class="form-control form-control-lg"
                                    value="{{ $admin->google2fa_secret }}" readonly>
                                <button class="btn btn-secondary btn-copy" data-clipboard-target="#input-secret"><i
                                        class="far fa-clone"></i></button>
                            </div>
                            <button class="btn btn-primary btn-lg w-100" data-bs-toggle="modal"
                                data-bs-target="#enable2FAModal">{{ translate('Enable 2FA Authentication') }}</button>
                        @else
                            <button class="btn btn-danger btn-lg w-100" data-bs-toggle="modal"
                                data-bs-target="#disable2FAModal">{{ translate('Disable 2FA Authentication') }}</button>
                        @endif
                    </div>
                </div>
                <p class="mb-2">
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
                <li class="mb-1"><a target="_blank"
                        href="https://play.google.com/store/apps/details?id=com.azure.authenticator&hl=en_US&gl=US">{{ translate('Microsoft Authenticator for Android') }}</a>
                </li>
            </div>
        </div>
    </div>
    @if (!$admin->google2fa_status)
        <div class="modal fade" id="enable2FAModal" tabindex="-1" aria-labelledby="enable2FAModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4">
                    <div class="modal-header p-0 mb-3 border-0">
                        <h1 class="modal-title fs-5" id="enable2FAModalLabel">{{ translate('OTP Code') }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <form action="{{ route('admin.account.2fa.enable') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="otp_code" class="form-control form-control-lg input-numeric"
                                    placeholder="• • • • • •" maxlength="6" required>
                            </div>
                            <div class="row justify-content-center g-3">
                                <div class="col-12 col-lg">
                                    <button type="button" class="btn btn-secondary btn-lg w-100" data-bs-dismiss="modal"
                                        aria-label="Close">{{ translate('Close') }}</button>
                                </div>
                                <div class="col-12 col-lg">
                                    <button class="btn btn-primary btn-lg w-100">{{ translate('Enable') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="modal fade" id="disable2FAModal" tabindex="-1" aria-labelledby="disable2FAModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4">
                    <div class="modal-header p-0 mb-3 border-0">
                        <h1 class="modal-title fs-5" id="disable2FAModalLabel">{{ translate('OTP Code') }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <form action="{{ route('admin.account.2fa.disable') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="otp_code" class="form-control form-control-lg input-numeric"
                                    placeholder="• • • • • •" maxlength="6" required>
                            </div>
                            <div class="row justify-content-center g-3">
                                <div class="col-12 col-lg">
                                    <button type="button" class="btn btn-secondary btn-lg w-100" data-bs-dismiss="modal"
                                        aria-label="Close">{{ translate('Close') }}</button>
                                </div>
                                <div class="col-12 col-lg">
                                    <button class="btn btn-danger btn-lg w-100">{{ translate('Disable') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/clipboard/clipboard.min.js') }}"></script>
    @endpush
@endsection
