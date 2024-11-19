@extends('themes.basic.layouts.auth')
@section('title', translate('Complete your information'))
@section('content')
    <div class="sign sign-lg">
        <div class="box">
            <div class="mb-4">
                <h2 class="sign-title">{{ translate('Complete your information') }}</h2>
                <p class="sign-text">
                    {{ translate('You need to complete some basic information required to log in next time') }}
                </p>
            </div>
            <form action="{{ route('oauth.data.complete') }}" method="POST">
                @csrf
                <div class="row g-3 mb-3">
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('First Name') }}</label>
                        <input type="text" name="firstname" class="form-control form-control-md"
                            placeholder="{{ translate('First Name') }}" value="{{ authUser()->firstname }}" required />
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Last Name') }}</label>
                        <input type="text" name="lastname" class="form-control form-control-md"
                            placeholder="{{ translate('Last Name') }}" value="{{ authUser()->lastname }}" required />
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ translate('Username') }}</label>
                    <input type="text" name="username" class="form-control form-control-md"
                        placeholder="{{ translate('Username') }}" value="{{ authUser()->username }}" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ translate('Email address') }}</label>
                    <input type="email" name="email" class="form-control form-control-md"
                        placeholder="{{ translate('Email address') }}" value="{{ authUser()->email }}" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ translate('Password') }}</label>
                    <input type="password" name="password" class="form-control form-control-md"
                        placeholder="{{ translate('Password') }}" minlength="8" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ translate('Confirm password') }}</label>
                    <input type="password" name="password_confirmation" class="form-control form-control-md"
                        placeholder="{{ translate('Confirm password') }}" minlength="8" required>
                </div>
                @if (@$settings->links->terms_of_use_link)
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="terms" id="terms"
                                {{ old('terms') ? 'checked' : '' }} required>
                            <label class="form-check-label" for="terms">
                                {{ translate('I agree to the') }}
                                <a
                                    href="{{ @$settings->links->terms_of_use_link }}">{{ translate('Terms of service') }}</a>
                            </label>
                        </div>
                    </div>
                @endif
                <x-captcha />
                <button class="btn btn-primary btn-md w-100">{{ translate('Continue') }}</button>
            </form>
        </div>
    </div>
@endsection
