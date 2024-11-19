@extends('admin.layouts.grid')
@section('section', translate('Users'))
@section('title', translate(':name Password', ['name' => $user->getName()]))
@section('back', route('admin.members.users.index'))
@section('content')
    @include('admin.members.users.includes.elements')
    <div class="row g-3">
        @include('admin.members.users.includes.sidebar')
        <div class="col-lg-9">
            <div class="card h-100">
                <div class="card-header">{{ translate('Password') }}</div>
                <div class="card-body p-4">
                    <form id="vironeer-submited-form" action="{{ route('admin.members.users.password.update', $user->id) }}"
                        method="POST">
                        @csrf
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <label class="form-label">{{ translate('New Password') }} </label>
                                <input type="password" class="form-control  form-control-lg" name="new-password" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ translate('Confirm New Password') }} </label>
                                <input type="password" class="form-control  form-control-lg"
                                    name="new-password_confirmation" required>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-md">{{ translate('Save Changes') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
