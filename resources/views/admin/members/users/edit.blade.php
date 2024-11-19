@extends('admin.layouts.grid')
@section('section', translate('Users'))
@section('title', translate(':name Account details', ['name' => $user->getName()]))
@section('back', route('admin.members.users.index'))
@section('content')
    @include('admin.members.users.includes.elements')
    <div class="row g-3">
        @include('admin.members.users.includes.sidebar')
        <div class="col-lg-9">
            <div class="card h-100">
                <div class="card-header">{{ translate('Account details') }}</div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.members.users.update', $user->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-auto">
                                <img id="filePreview" src="{{ $user->getAvatar() }}" alt="{{ $user->username }}"
                                    class="rounded-3 border" width="70px" height="70px">
                            </div>
                            <div class="col-auto">
                                <button id="selectFileBtn" type="button" class="btn btn-secondary"><i
                                        class="fas fa-camera me-2"></i>{{ translate('Choose Image') }}</button>
                                <input id="selectedFileInput" type="file" name="avatar"
                                    accept="image/png, image/jpg, image/jpeg" hidden>
                            </div>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-lg-6">
                                <label class="form-label">{{ translate('First Name') }} </label>
                                <input type="firstname" name="firstname" class="form-control form-control-lg"
                                    value="{{ $user->firstname }}" required>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">{{ translate('Last Name') }} </label>
                                <input type="lastname" name="lastname" class="form-control form-control-lg"
                                    value="{{ $user->lastname }}" required>
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label">{{ translate('Username') }} </label>
                                <input type="text" name="username" class="form-control form-control-lg"
                                    value="{{ $user->username }}" required>
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label">{{ translate('E-mail Address') }} </label>
                                <div class="input-group">
                                    <input type="email" name="email" class="form-control form-control-lg"
                                        value="{{ demo($user->email) }}" required>
                                    <button class="btn btn-dark" type="button" data-bs-toggle="modal"
                                        data-bs-target="#sendMailModal"><i
                                            class="far fa-paper-plane me-2"></i>{{ translate('Send Email') }}</button>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label">{{ translate('Address line 1') }}</label>
                                <input type="text" name="address_line_1" class="form-control form-control-lg"
                                    value="{{ @$user->address->line_1 }}">
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label">{{ translate('Address line 2') }}</label>
                                <input type="text" name="address_line_2" class="form-control form-control-lg"
                                    placeholder="{{ translate('Address line 2') }}" value="{{ @$user->address->line_2 }}">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">{{ translate('City') }}</label>
                                <input type="text" name="city" class="form-control form-control-lg"
                                    value="{{ @$user->address->city }}">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">{{ translate('State') }}</label>
                                <input type="text" name="state" class="form-control form-control-lg"
                                    value="{{ @$user->address->state }}">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">{{ translate('Postal code') }}</label>
                                <input type="text" name="zip" class="form-control form-control-lg"
                                    value="{{ @$user->address->zip }}">
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label">{{ translate('Country') }}</label>
                                <select name="country" class="form-select form-control-lg">
                                    <option value="">--</option>
                                    @foreach (countries() as $countryCode => $countryName)
                                        <option value="{{ $countryCode }}" @selected(@$user->address->country == $countryCode)>
                                            {{ $countryName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-md">{{ translate('Save Changes') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="sendMailModal" tabindex="-1" aria-labelledby="sendMailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendMailModalLabel">
                        {{ translate('Send Mail to :email', ['email' => demo($user->email)]) }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.members.users.sendmail', $user->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ translate('Subject') }} </label>
                                    <input type="subject" name="subject" class="form-control form-control-lg" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ translate('Reply to') }} </label>
                                    <input type="email" name="reply_to" class="form-control form-control-lg"
                                        value="{{ authUser()->email }}" required>
                                </div>
                            </div>
                        </div>
                        <textarea name="message" rows="10" class="ckeditor"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-lg">{{ translate('Send') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('admin.partials.ckeditor')
@endsection
