@extends('admin.layouts.form')
@section('section', translate('Settings'))
@section('title', translate(':language_name Translates', ['language_name' => $language]))
@section('back', route('admin.settings.language.index'))
@section('content')
    <div class="note note-warning d-flex">
        <div class="icon">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <div>
            <div class="mb-1"><strong>{{ translate('Important!') }}</strong></div>
            <li>
                <small>
                    {!! translate(
                        'There are some words that should not be translated that start with some tags or are inside a tag :words etc...',
                        ['words' => '<strong>:value, :seconds, :min, ::max, {username}</strong>'],
                    ) !!}
                </small>
            </li>
            <li><small>{{ translate('You must clear the cache after saving the translations.') }}</small></li>
        </div>
    </div>
    <div class="card">
        <div class="card-header p-3 border-bottom-small">
            <form action="{{ url()->current() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-10">
                        <input type="text" name="search" class="form-control" placeholder="{{ translate('Search...') }}"
                            value="{{ request('search') ?? '' }}">
                    </div>
                    <div class="col">
                        <button class="btn btn-primary w-100"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="col">
                        <a href="{{ url()->current() }}" class="btn btn-secondary w-100">{{ translate('Reset') }}</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body my-1">
            @if ($translates->count() > 0)
                <form id="vironeer-submited-form" action="{{ route('admin.settings.language.translates.update') }}"
                    method="POST">
                    @csrf
                    @foreach ($translates as $translate)
                        <div class="vironeer-translate-box">
                            <div class="vironeer-translated-item d-block d-lg-flex bd-highlight align-items-center">
                                <div class="flex-grow-1 bd-highlight">
                                    <textarea class="vironeer-translate-key translate-fields form-control" rows="1" readonly>{{ $translate->key }}</textarea>
                                </div>
                                <div class="pe-3 ps-3 bd-highlight text-center text-success d-none d-lg-block"><i
                                        class="fas fa-chevron-right"></i></div>
                                <div class="flex-grow-1 bd-highlight">
                                    <textarea name="translates[{{ $translate->id }}]" class="translate-fields form-control" rows="1">{{ $translate->value }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </form>
            @else
                <div class="text-center text-muted p-5">{{ translate('No data found') }}</div>
            @endif
        </div>
    </div>
    {{ $translates->links() }}
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/autosize/autosize.min.js') }}"></script>
    @endpush
    @push('scripts')
        <script>
            autosize($('textarea'));
        </script>
    @endpush
@endsection
