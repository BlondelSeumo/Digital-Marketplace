@extends('admin.layouts.form')
@section('section', translate('Admins'))
@section('title', translate('New Admin'))
@section('back', route('admin.members.admins.index'))
@section('container', 'container-max-md')
@section('content')
    <div class="card">
        <div class="card-body p-4">
            <form id="vironeer-submited-form" action="{{ route('admin.members.admins.store') }}" method="POST">
                @csrf
                <div class="row g-3 mb-2">
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('First Name') }} </label>
                        <input type="firstname" name="firstname" class="form-control form-control-lg"
                            value="{{ old('firstname') }}" required>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Last Name') }} </label>
                        <input type="lastname" name="lastname" class="form-control form-control-lg"
                            value="{{ old('lastname') }}" required>
                    </div>
                    <div class="col-lg-12">
                        <label class="form-label">{{ translate('Username') }} </label>
                        <input type="text" name="username" class="form-control form-control-lg"
                            value="{{ old('username') }}" minlength="5" required>
                    </div>
                    <div class="col-lg-12">
                        <label class="form-label">{{ translate('E-mail Address') }} </label>
                        <input type="email" name="email" class="form-control form-control-lg"
                            value="{{ old('email') }}" required>
                    </div>
                    <div class="col-lg-12">
                        <label class="form-label">{{ translate('Password') }} </label>
                        <div class="input-group">
                            <input id="randomPasswordInput" type="text" class="form-control form-control-lg"
                                name="password" required>
                            <button class="btn btn-secondary btn-copy" type="button"
                                data-clipboard-target="#randomPasswordInput"><i class="far fa-clone"></i></button>
                            <button id="randomPasswordBtn" class="btn btn-secondary" type="button"><i
                                    class="fa-solid fa-rotate me-2"></i>{{ translate('Generate') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/clipboard/clipboard.min.js') }}"></script>
    @endpush
@endsection
