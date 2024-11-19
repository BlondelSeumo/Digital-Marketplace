@extends('admin.layouts.form')
@section('section', translate('Settings'))
@section('title', translate('Ticket Settings'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.settings.ticket.update') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body p-4">
                <div class="row g-3 mb-2">
                    <div class="col-lg-12">
                        <label class="form-label">{{ translate('Allowed file types') }}</label>
                        <input type="text" name="ticket[file_types]" class="form-control tags-input"
                            placeholder="{{ translate('Enter the file extension') }}"
                            value="{{ @$settings->ticket->file_types }}" required>
                    </div>
                    <div class="col-lg-12">
                        <label class="form-label">{{ translate('Max upload files') }}</label>
                        <input type="number" name="ticket[max_files]" class="form-control" placeholder="0"
                            value="{{ @$settings->ticket->max_files }}" min="1" max="1000" required>
                    </div>
                    <div class="col-lg-12">
                        <label class="form-label">{{ translate('Max size per file') }}</label>
                        <div class="input-group">
                            <input type="number" name="ticket[max_file_size]" class="form-control" placeholder="0"
                                value="{{ @$settings->ticket->max_file_size }}" min="1" required>
                            <span class="input-group-text"><strong>{{ translate('MB') }}</strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/tags-input/bootstrap-tagsinput.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/tags-input/bootstrap-tagsinput.min.js') }}"></script>
    @endpush
@endsection
