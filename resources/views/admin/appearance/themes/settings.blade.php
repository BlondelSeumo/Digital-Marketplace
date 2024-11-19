@extends('admin.layouts.form')
@section('section', translate('Appearance'))
@section('title', translate(':theme_name Theme Settings', ['theme_name' => $theme->name]))
@section('back', route('admin.appearance.themes.index'))
@section('content')
    <div class="row g-4">
        <div class="col-lg-3">
            <div class="card">
                <ul class="theme-list-group list-group list-group-flush">
                    @foreach ($themeSettingsGroups as $themeSettingsGroup)
                        <a class="theme-list-group-item list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $themeSettingsGroup == $activeGroup ? 'active' : '' }}"
                            href="{{ route('admin.appearance.themes.settings.group', [$theme->id, $themeSettingsGroup]) }}">
                            <span class="capitalize">{{ translate(str_replace('_', ' ', $themeSettingsGroup)) }}</span>
                            <i class="fa-solid fa-chevron-right fa-rtl"></i>
                        </a>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card h-100">
                <div class="card-header capitalize p-3">{{ translate(str_replace('_', ' ', $activeGroup)) }}</div>
                <div class="card-body p-4">
                    <form id="vironeer-submited-form"
                        action="{{ route('admin.appearance.themes.settings.update', [$theme->id, $activeGroup]) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row row-cols-1 g-3">
                            @foreach ($themeSettingsCollection as $themeSetting)
                                @if ($themeSetting->field === 'input')
                                    <div class="{{ $themeSetting->col }}">
                                        <label class="form-label">{{ translate($themeSetting->label) }}</label>
                                        @if (isset($themeSetting->disabled) && $themeSetting->disabled)
                                            <input type="{{ $themeSetting->type }}" class="form-control"
                                                value="{{ $themeSetting->value }}" disabled>
                                        @else
                                            <input type="{{ $themeSetting->type }}" name="{{ $themeSetting->key }}"
                                                class="form-control" value="{{ $themeSetting->value }}"
                                                {{ $themeSetting->required ? 'required' : '' }}>
                                        @endif
                                    </div>
                                @elseif ($themeSetting->field === 'number')
                                    <div class="{{ $themeSetting->col }}">
                                        <label class="form-label">{{ translate($themeSetting->label) }}</label>
                                        <input type="number" name="{{ $themeSetting->key }}" class="form-control"
                                            value="{{ $themeSetting->value }}" min="{{ $themeSetting->min }}"
                                            max="{{ $themeSetting->max }}"
                                            {{ $themeSetting->required ? 'required' : '' }}>
                                    </div>
                                @elseif ($themeSetting->field === 'textarea')
                                    <div class="{{ $themeSetting->col }}">
                                        <label class="form-label">{{ translate($themeSetting->label) }}</label>
                                        <textarea name="{{ $themeSetting->key }}" class="form-control" rows="{{ $themeSetting->rows }}"
                                            {{ $themeSetting->required ? 'required' : '' }}>{{ $themeSetting->value }}</textarea>
                                    </div>
                                @elseif ($themeSetting->field === 'ckeditor')
                                    <div class="{{ $themeSetting->col }}">
                                        <label class="form-label">{{ translate($themeSetting->label) }}</label>
                                        <textarea name="{{ $themeSetting->key }}" class="form-control ckeditor">{{ $themeSetting->value }}</textarea>
                                    </div>
                                @elseif ($themeSetting->field === 'select')
                                    <div class="{{ $themeSetting->col }}">
                                        <label class="form-label">{{ translate($themeSetting->label) }}</label>
                                        <select name="{{ $themeSetting->key }}" class="form-select"
                                            {{ $themeSetting->required ? 'required' : '' }}>
                                            @foreach ($themeSetting->options as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ $themeSetting->value == $key ? 'selected' : '' }}>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @elseif ($themeSetting->field === 'bootstrap-select')
                                    <div class="{{ $themeSetting->col }}">
                                        <label class="form-label">{{ translate($themeSetting->label) }}</label>
                                        <select name="{{ $themeSetting->key }}" class="form-select selectpicker"
                                            title="{{ translate($themeSetting->label) }}"
                                            data-live-search="{{ $themeSetting->search }}"
                                            {{ $themeSetting->required ? 'required' : '' }}>
                                            @foreach ($themeSetting->options as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ $themeSetting->value == $key ? 'selected' : '' }}>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @elseif ($themeSetting->field === 'checkbox')
                                    <div class="{{ $themeSetting->col }}">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="{{ $themeSetting->key }}"
                                                id="{{ $themeSetting->key }}"
                                                {{ $themeSetting->required ? 'required' : '' }}
                                                {{ $themeSetting->value ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                {{ translate($themeSetting->label) }}
                                            </label>
                                        </div>
                                    </div>
                                @elseif ($themeSetting->field === 'radios')
                                    <div class="{{ $themeSetting->col }}">
                                        <label class="form-label">{{ translate($themeSetting->label) }}</label>
                                        @foreach ($themeSetting->options as $key => $value)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="{{ $themeSetting->key }}" id="{{ $themeSetting->key . $key }}"
                                                    value="{{ $key }}"
                                                    {{ $themeSetting->value == $key ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ $themeSetting->key . $key }}">
                                                    {{ $value }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif ($themeSetting->field === 'toggle')
                                    <div class="{{ $themeSetting->col }}">
                                        <label class="form-label">{{ translate($themeSetting->label) }}</label>
                                        <input type="checkbox" name="{{ $themeSetting->key }}"
                                            data-off="{{ translate($themeSetting->off) }}"
                                            data-on="{{ translate($themeSetting->on) }}" id="{{ $themeSetting->key }}"
                                            {{ $themeSetting->required ? 'required' : '' }} data-toggle="toggle"
                                            {{ $themeSetting->value ? 'checked' : '' }}>
                                    </div>
                                @elseif ($themeSetting->field === 'color')
                                    <div class="{{ $themeSetting->col }}">
                                        <label class="form-label">{{ translate($themeSetting->label) }}</label>
                                        <div class="colorpicker">
                                            <input type="text" name="{{ $themeSetting->key }}"
                                                class="form-control coloris" value="{{ $themeSetting->value }}"
                                                {{ $themeSetting->required ? 'required' : '' }}>
                                        </div>
                                    </div>
                                @elseif ($themeSetting->field === 'image')
                                    <div class="{{ $themeSetting->col }}">
                                        @if ($themeSetting->box_type == 'regular')
                                            <div class="image-box p-4 border bg-light rounded-2">
                                                <h5>{{ translate($themeSetting->label) }}</h5>
                                                <div class="my-3">
                                                    <img id="image-preview-{{ $loop->index }}"
                                                        class="border p-2 rounded-2 {{ $themeSetting->box_bg }}"
                                                        src="{{ asset($themeSetting->value) }}"
                                                        alt="{{ $themeSetting->key }}" height="60px">
                                                </div>
                                                <input type="file" name="{{ $themeSetting->key }}"
                                                    class="form-control image-input" data-id="{{ $loop->index }}"
                                                    accept="{{ $themeSetting->accept }}">
                                                @if ($themeSetting->description)
                                                    <div class="form-text mt-2">
                                                        {{ translate($themeSetting->description) }}</div>
                                                @endif
                                            </div>
                                        @elseif ($themeSetting->box_type == 'square-small')
                                            <div class="my-3">
                                                <div class="vironeer-image-preview {{ $themeSetting->box_bg }}">
                                                    <img id="attach-image-preview-{{ $loop->index }}"
                                                        src="{{ asset($themeSetting->value) }}"
                                                        alt="{{ $themeSetting->key }}">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <input id="attach-image-targeted-input-{{ $loop->index }}"
                                                    type="file" name="{{ $themeSetting->key }}"
                                                    accept="{{ $themeSetting->accept }}" class="form-control" hidden>
                                                <button data-id="{{ $loop->index }}" type="button"
                                                    class="attach-image-button btn btn-secondary btn-lg w-100 mb-2"><i
                                                        class="fas fa-camera me-2"></i>{{ translate('Choose ' . $themeSetting->label) }}</button>
                                                @if ($themeSetting->description)
                                                    <small
                                                        class="text-muted">{{ translate($themeSetting->description) }}</small>
                                                @endif
                                            </div>
                                        @elseif ($themeSetting->box_type == 'square-large')
                                            <div class="my-3">
                                                <div class="vironeer-image-preview-box {{ $themeSetting->box_bg }}">
                                                    <img id="attach-image-preview-{{ $loop->index }}"
                                                        src="{{ asset($themeSetting->value) }}"
                                                        alt="{{ $themeSetting->key }}" width="100%" height="200px">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <input id="attach-image-targeted-input-{{ $loop->index }}"
                                                    type="file" name="{{ $themeSetting->key }}"
                                                    accept="{{ $themeSetting->accept }}" class="form-control" hidden>
                                                <button data-id="{{ $loop->index }}" type="button"
                                                    class="attach-image-button btn btn-secondary btn-lg w-100 mb-2"><i
                                                        class="fas fa-camera me-2"></i>{{ translate('Choose ' . $themeSetting->label) }}</button>
                                                @if ($themeSetting->description)
                                                    <small
                                                        class="text-muted">{{ translate($themeSetting->description) }}</small>
                                                @endif
                                            </div>
                                        @elseif ($themeSetting->box_type == 'full')
                                            <div
                                                class="vironeer-file-preview-box mb-3 {{ $themeSetting->box_bg }} p-4 text-center">
                                                <div class="file-preview-box mb-3">
                                                    <img id="attach-image-preview-{{ $loop->index }}"
                                                        src="{{ asset($themeSetting->value) }}"
                                                        alt="{{ $themeSetting->key }}" height="70px">
                                                </div>
                                                <button type="button" class="attach-image-button btn btn-secondary mb-2"
                                                    data-id="{{ $loop->index }}"><i
                                                        class="fas fa-camera me-2"></i>{{ translate('Choose ' . $themeSetting->label) }}</button>
                                                <input id="attach-image-targeted-input-{{ $loop->index }}"
                                                    type="file" name="{{ $themeSetting->key }}"
                                                    accept="{{ $themeSetting->accept }}" hidden>
                                                @if ($themeSetting->description)
                                                    <div class="form-text">{{ translate($themeSetting->description) }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/coloris/coloris.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/coloris/coloris.min.js') }}"></script>
    @endpush
    @include('admin.partials.ckeditor')
@endsection
