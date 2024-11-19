@extends('admin.layouts.form')
@section('section', translate('Admins'))
@section('title', translate(':name Account details', ['name' => $admin->getName()]))
@section('back', route('admin.members.admins.index'))
@section('content')
    <div class="row g-3">
        @include('admin.members.admins.includes.sidebar')
        <div class="col-lg-9">
            <div class="card h-100">
                <div class="card-header">{{ translate('Account details') }}</div>
                <div class="card-body p-4">
                    <form id="vironeer-submited-form" action="{{ route('admin.members.admins.update', $admin->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row align-items-center mb-4">
                            <div class="col-auto">
                                <img id="filePreview" src="{{ $admin->getAvatar() }}" alt="{{ $admin->getName() }}"
                                    class="rounded-3 border" width="80px" height="80px">
                            </div>
                            <div class="col-auto">
                                <button id="selectFileBtn" type="button" class="btn btn-secondary"><i
                                        class="fas fa-camera me-2"></i>{{ translate('Choose Image') }}</button>
                                <input id="selectedFileInput" type="file" name="avatar"
                                    accept="image/png, image/jpg, image/jpeg" hidden>
                            </div>
                        </div>
                        <div class="row g-3 mb-2">
                            <div class="col-lg-6">
                                <label class="form-label">{{ translate('First Name') }} </label>
                                <input type="firstname" name="firstname" class="form-control form-control-lg"
                                    value="{{ $admin->firstname }}" required>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">{{ translate('Last Name') }} </label>
                                <input type="lastname" name="lastname" class="form-control form-control-lg"
                                    value="{{ $admin->lastname }}" required>
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label">{{ translate('Username') }} </label>
                                <input type="text" name="username" class="form-control form-control-lg"
                                    value="{{ $admin->username }}" minlength="5" required>
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label">{{ translate('E-mail Address') }} </label>
                                <div class="input-group">
                                    <input type="email" name="email" class="form-control form-control-lg"
                                        value="{{ demo($admin->email) }}" required>
                                    <button class="btn btn-dark" type="button" data-bs-toggle="modal"
                                        data-bs-target="#sendMailModal"><i
                                            class="far fa-paper-plane me-2"></i>{{ translate('Send Email') }}</button>
                                </div>
                            </div>
                        </div>
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
                        {{ translate('Send Mail to :email', ['email' => demo($admin->email)]) }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.members.admins.sendmail', $admin->id) }}" method="POST">
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
