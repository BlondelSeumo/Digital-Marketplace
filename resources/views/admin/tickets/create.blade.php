@extends('admin.layouts.form')
@section('section', translate('Tickets'))
@section('title', translate('New Ticket'))
@section('back', route('admin.tickets.index'))
@section('container', 'container-max-lg')
@section('content')
    <div class="card">
        <div class="card-body p-4">
            <form id="vironeer-submited-form" action="{{ route('admin.tickets.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row g-4 mb-3">
                    <div class="col-lg-12">
                        <label class="form-label">{{ translate('Subject') }}</label>
                        <input type="text" name="subject" class="form-control form-control-md"
                            value="{{ old('subject') }}" autofocus required>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('User') }}</label>
                        <select name="user" class="form-select form-select-md selectpicker" data-live-search="true"
                            title="{{ translate('Choose') }}" required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @selected(old('user') == $user->id || request('user') == $user->id)>
                                    {{ $user->getName() }} ({{ demo($user->email) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Category') }}</label>
                        <select name="category" class="form-select form-select-md selectpicker" data-live-search="true"
                            title="{{ translate('Choose') }}" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-12">
                        <label class="form-label">{{ translate('Description') }}</label>
                        <textarea name="description" class="form-control" rows="10" required>{{ old('description') }}</textarea>
                    </div>
                    <div class="col-lg-12">
                        <div class="attachments">
                            <div class="attachment-box-1">
                                <label class="form-label">
                                    {{ translate('Attachments') }}
                                </label>
                                <div class="input-group">
                                    <input type="file" name="attachments[]" class="form-control form-control-md">
                                    <button id="addAttachment" class="btn btn-outline-secondary" type="button">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
