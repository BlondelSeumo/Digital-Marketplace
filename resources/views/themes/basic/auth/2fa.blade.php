@extends('themes.basic.layouts.auth')
@section('title', translate('2Fa Verification'))
@section('content')
    <div class="sign my-5">
        <div class="box">
            <div class="mb-4">
                <h2 class="sign-title">{{ translate('2Fa Verification') }}</h2>
                <p class="sign-text">{{ translate('Please enter the OTP code to continue') }}</p>
            </div>
            <form action="{{ route('2fa.verify') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="text" name="otp_code" class="form-control form-control-md input-numeric" maxlength="6"
                        required placeholder="• • • • • •" autofocus>
                </div>
                <button class="btn btn-primary btn-md w-100">{{ translate('Continue') }}</button>
            </form>
        </div>
    </div>
@endsection
