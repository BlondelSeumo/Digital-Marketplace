@extends('themes.basic.layouts.single')
@section('header_title', translate('Contact US'))
@section('title', translate('Contact US'))
@section('body_bg', 'bg-white')
@section('breadcrumbs', Breadcrumbs::render('contact'))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'contact'))
@section('header_v3', true)
@section('container', 'container-custom')
@section('content')
    <div class="row row-cols-2 justify-content-center g-5">
        <div class="col-12 col-md-9">
            <form action="{{ route('contact') }}" method="POST">
                @csrf
                <div class="row g-3 mb-3">
                    <div class="col-12 col-lg-6">
                        <label class="form-label">{{ translate('Name') }}</label>
                        <input type="text" name="name" class="form-control form-control-md"
                            value="{{ auth()->user() ? auth()->user()->getName() : '' }}" required>
                    </div>
                    <div class="col-12 col-lg-6">
                        <label class="form-label">{{ translate('Email') }}</label>
                        <input type="email" name="email" class="form-control form-control-md"
                            value="{{ auth()->user() ? auth()->user()->email : '' }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ translate('Subject') }}</label>
                        <input type="text" name="subject" class="form-control form-control-md"
                            value="{{ old('subject') }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ translate('Message') }}</label>
                        <textarea class="form-control" name="message" rows="8" required>{{ old('message') }}</textarea>
                    </div>
                </div>
                <x-captcha />
                <button class="btn btn-primary btn-md px-5">{{ translate('Send') }}</button>
            </form>
        </div>
    </div>
@endsection
