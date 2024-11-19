@extends('admin.layouts.form')
@section('section', translate('Settings'))
@section('title', translate('Edit Mail Template'))
@section('back', route('admin.settings.mail-templates.index'))
@section('content')
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary border-0 text-white">{{ translate($mailTemplate->name) }}</div>
                <div class="card-body">
                    <form id="vironeer-submited-form"
                        action="{{ route('admin.settings.mail-templates.update', $mailTemplate->id) }}" method="POST">
                        @csrf
                        <div class="row g-3 mb-4">
                            <div class="{{ $mailTemplate->isDefault() ? 'col-lg-12' : 'col-lg-8' }}">
                                <label class="form-label">{{ translate('Subject') }} </label>
                                <input type="text" name="subject" class="form-control"
                                    value="{{ $mailTemplate->subject }}" required>
                            </div>
                            @if (!$mailTemplate->isDefault())
                                <div class="col-lg-4">
                                    <label class="form-label">{{ translate('Status') }} </label>
                                    <input type="checkbox" name="status" data-toggle="toggle"
                                        {{ $mailTemplate->status ? 'checked' : '' }}>
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ translate('Body') }} </label>
                            <textarea name="body" class="ckeditor">{{ $mailTemplate->body }}</textarea>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-primary border-0 text-white">
                    {{ translate('Short Codes') }}
                </div>
                <div class="card-body">
                    @foreach ($mailTemplate->shortcodes as $shortcode)
                        <div class="input-group {{ !$loop->last ? 'mb-3' : '' }}">
                            <input id="{{ $shortcode }}" type="text" class="form-control form-control-md"
                                value="@php echo str("{{ ". $shortcode ." }}")->replace(' ', '') @endphp" readonly>
                            <button class="btn btn-secondary btn-copy" type="button"
                                data-clipboard-target="#{{ $shortcode }}"><i class="far fa-clone"></i></button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/clipboard/clipboard.min.js') }}"></script>
    @endpush
    @include('admin.partials.ckeditor')
@endsection
