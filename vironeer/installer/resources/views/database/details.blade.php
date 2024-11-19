@extends('installer::layouts.app')
@section('title', installer_trans('Database'))
@section('content')
    <div class="vironeer-steps-body">
        <p class="vironeer-form-info-text">
            {{ installer_trans('Enter your database details. You can read the docs included with the script files to learn how to create the database, please do not use the hashtag "#" or spaces on the database details.') }}
        </p>
        <form action="{{ route('installer.database.details') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">{{ installer_trans('Database host') }} : <span class="required">*</span></label>
                <div class="input-group">
                    <input type="text" name="db_host" class="form-control form-control-md remove-spaces"
                        placeholder="{{ installer_trans('Enter database host') }}" value="{{ old('db_host') ?? 'localhost' }}"
                        required>
                    <span class="input-group-text"><i class="fas fa-server"></i></span>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ installer_trans('Database name') }} : <span class="required">*</span></label>
                <div class="input-group">
                    <input type="text" name="db_name" class="form-control form-control-md remove-spaces"
                        placeholder="{{ installer_trans('Enter database name') }}" value="{{ old('db_name') }}"
                        autocomplete="off" required>
                    <span class="input-group-text"><i class="fas fa-question-circle"></i></span>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ installer_trans('Database username') }} : <span class="required">*</span></label>
                <div class="input-group">
                    <input type="text" name="db_user" class="form-control form-control-md remove-spaces"
                        placeholder="{{ installer_trans('Enter database username') }}" value="{{ old('db_user') }}"
                        autocomplete="off" required>
                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">{{ installer_trans('Database password') }} </label>
                <div class="input-group">
                    <input type="password" name="db_pass" class="form-control form-control-md remove-spaces"
                        placeholder="{{ installer_trans('Enter database password') }}" autocomplete="off">
                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                </div>
            </div>
            <button class="btn btn-primary btn-md">{{ installer_trans('Continue') }}<i
                    class="fas fa-arrow-right ms-2"></i></button>
        </form>
    </div>
@endsection
