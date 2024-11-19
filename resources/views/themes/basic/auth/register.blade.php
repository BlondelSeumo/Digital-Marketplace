@extends('themes.basic.layouts.auth')
@section('title', translate('Sign Up'))
@section('content')
    <div class="sign sign-lg">
        <div class="box">
            <div class="mb-4">
                <h2 class="sign-title">{{ translate('Sign Up') }}</h2>
                <p class="sign-text">{{ translate('Enter your details to create an account.') }}</p>
            </div>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="row g-3 mb-3">
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('First Name') }}</label>
                        <input type="text" name="firstname" class="form-control form-control-md"
                            placeholder="{{ translate('First Name') }}" value="{{ old('firstname') }}" required />
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Last Name') }}</label>
                        <input type="text" name="lastname" class="form-control form-control-md"
                            placeholder="{{ translate('Last Name') }}" value="{{ old('lastname') }}" required />
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ translate('Username') }}</label>
                    <input type="text" name="username" class="form-control form-control-md"
                        placeholder="{{ translate('Username') }}" value="{{ old('username') }}" min="6" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ translate('Email address') }}</label>
                    <input type="email" name="email" class="form-control form-control-md"
                        placeholder="{{ translate('Email address') }}" value="{{ old('email') }}" required />
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
                <button class="btn btn-primary btn-md w-100">{{ translate('Sign Up') }}</button>
            </form>
            <x-oauth-buttons />
        </div>
        <div class="mt-4 text-center">{{ translate('You an account already?') }} <a href="{{ route('login') }}"
                class="text-primary">{{ translate('Sign In') }}</a>
        </div>
    </div>
@endsection
