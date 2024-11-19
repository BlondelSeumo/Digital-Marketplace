@extends('admin.layouts.form')
@section('section', translate('Settings'))
@section('title', translate('General'))
@section('container', 'container-max-xl')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.settings.general.update') }}" method="POST">
        @csrf
        <div class="card mb-3">
            <div class="card-header">{{ translate('General Details') }}</div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Site Name') }}</label>
                        <input type="text" name="general[site_name]" class="form-control"
                            value="{{ @$settings->general->site_name }}" required>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Site URL') }}</label>
                        <input type="text" name="general[site_url]" class="form-control"
                            value="{{ @$settings->general->site_url }}" required>
                    </div>
                    <div class="col-lg-12">
                        <label class="form-label">{{ translate('Contact Email') }}</label>
                        <input type="text" name="general[contact_email]" class="form-control"
                            value="{{ @$settings->general->contact_email }}">
                        <div class="form-text">
                            {{ translate('This email is required to receive emails from contact page') }}
                            <a href="{{ route('contact') }}" target="_blank">{{ route('contact') }}</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Date format') }}</label>
                        <select name="general[date_format]" class="form-select selectpicker" data-live-search="true"
                            title="{{ translate('Date format') }}">
                            @foreach (\App\Models\Settings::dateFormats() as $formatKey => $formatValue)
                                <option value="{{ $formatKey }}"
                                    {{ $formatKey == @$settings->general->date_format ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::now()->format($formatValue) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Timezone') }}</label>
                        <select name="general[timezone]" class="form-select selectpicker" data-live-search="true"
                            title="{{ translate('Timezone') }}">
                            @foreach (\App\Models\Settings::timezones() as $timezoneKey => $timezoneValue)
                                <option value="{{ $timezoneKey }}"
                                    {{ $timezoneKey == @$settings->general->timezone ? 'selected' : '' }}>
                                    {{ $timezoneValue }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">{{ translate('Social Media Links') }}</div>
            <div class="card-body p-4">
                <div class="row g-3">
                    @foreach (@$settings->social_links as $socialLinkKey => $socialLink)
                        <div class="col-lg-4">
                            <label class="form-label">
                                {{ translate(ucfirst(str_replace('_', ' ', $socialLinkKey))) }}</label>
                            <input type="text" name="social_links[{{ $socialLinkKey }}]" class="form-control"
                                value="{{ $socialLink }}">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">{{ translate('Links') }}</div>
            <div class="card-body p-4">
                <div class="row g-3">
                    @foreach (@$settings->links as $key => $link)
                        <div class="col-lg-6">
                            <label class="form-label"> {{ translate(ucfirst(str_replace('_', ' ', $key))) }}</label>
                            <input type="text" name="links[{{ $key }}]" class="form-control"
                                value="{{ $link }}">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">{{ translate('SEO') }}</div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-lg-12">
                        <label class="form-label">{{ translate('Home title') }}</label>
                        <input type="text" name="seo[title]" class="form-control"
                            placeholder="{{ translate('Title must be within 70 Characters') }}"
                            value="{{ @$settings->seo->title }}">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Description') }}</label>
                        <textarea name="seo[description]" class="form-control" rows="3"
                            placeholder="{{ translate('Description must be within 150 Characters') }}">{{ @$settings->seo->description }}</textarea>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ translate('Site keywords') }}</label>
                        <textarea id="keywords" name="seo[keywords]" class="form-control" rows="3"
                            placeholder="{{ translate('keyword1, keyword2, keyword3') }}">{{ @$settings->seo->keywords }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">{{ translate('Actions') }}</div>
            <div class="card-body p-4">
                <div class="row g-3">
                    @foreach (@$settings->actions as $key => $value)
                        <div class="col-lg-3">
                            <label class="form-label"> {{ translate(ucfirst(str_replace('_', ' ', $key))) }}</label>
                            <input type="checkbox" name="actions[{{ $key }}]" data-toggle="toggle"
                                {{ $value ? 'checked' : '' }}>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
