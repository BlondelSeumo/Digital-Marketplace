@extends('admin.layouts.form')
@section('section', translate('Settings'))
@section('title', translate('SMTP'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.settings.smtp.update') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                {{ translate('SMTP details') }}
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item p-4">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-2">
                            <label class="col-form-label"><strong>{{ translate('Status') }}</strong></label>
                        </div>
                        <div class="col">
                            <div class="col-lg-3">
                                <input type="checkbox" name="smtp[status]" data-toggle="toggle"
                                    {{ @$settings->smtp->status ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item p-4">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-2">
                            <label class="col-form-label"><strong>{{ translate('Mail mailer') }}</strong></label>
                        </div>
                        <div class="col">
                            <select name="smtp[mailer]" class="form-select">
                                <option value="smtp" @selected(@$settings->smtp->mailer == 'smtp')>
                                    {{ translate('SMTP') }}
                                </option>
                                <option value="sendmail" @selected(@$settings->smtp->mailer == 'sendmail')>
                                    {{ translate('SENDMAIL') }}
                                </option>
                            </select>
                        </div>
                    </div>
                </li>
                <li class="list-group-item p-4">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-2">
                            <label class="col-form-label"><strong>{{ translate('Mail Host') }}</strong></label>
                        </div>
                        <div class="col">
                            <input type="text" name="smtp[host]" class="remove-spaces form-control"
                                value="{{ demo(@$settings->smtp->host) }}" placeholder="{{ translate('Enter mail host') }}">
                        </div>
                    </div>
                </li>
                <li class="list-group-item p-4">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-2">
                            <label class="col-form-label"><strong>{{ translate('Mail Port') }}</strong></label>
                        </div>
                        <div class="col">
                            <input type="text" name="smtp[port]" class="remove-spaces form-control"
                                value="{{ demo(@$settings->smtp->port) }}"
                                placeholder="{{ translate('Enter mail port') }}">
                        </div>
                    </div>
                </li>
                <li class="list-group-item p-4">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-2">
                            <label class="col-form-label"><strong>{{ translate('Mail username') }}</strong></label>
                        </div>
                        <div class="col">
                            <input type="text" name="smtp[username]" class="form-control remove-spaces"
                                value="{{ demo(@$settings->smtp->username) }}"
                                placeholder="{{ translate('Enter username') }}">
                        </div>
                    </div>
                </li>
                <li class="list-group-item p-4">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-2">
                            <label class="col-form-label"><strong>{{ translate('Mail password') }}</strong></label>
                        </div>
                        <div class="col">
                            <input type="password" name="smtp[password]" class="form-control"
                                value="{{ demo(@$settings->smtp->password) }}"
                                placeholder="{{ translate('Enter password') }}">
                        </div>
                    </div>
                </li>
                <li class="list-group-item p-4">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-2">
                            <label class="col-form-label"><strong>{{ translate('Mail encryption') }}</strong></label>
                        </div>
                        <div class="col">
                            <select name="smtp[encryption]" class="form-select">
                                <option value="tls" @selected(@$settings->smtp->encryption == 'tls')>
                                    {{ translate('TLS') }}
                                </option>
                                <option value="ssl" @selected(@$settings->smtp->encryption == 'ssl')>
                                    {{ translate('SSL') }}
                                </option>
                            </select>
                        </div>
                    </div>
                </li>
                <li class="list-group-item p-4">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-2">
                            <label class="col-form-label"><strong>{{ translate('From email') }}</strong></label>
                        </div>
                        <div class="col">
                            <input type="text" name="smtp[from_email]" class="remove-spaces form-control"
                                value="{{ demo(@$settings->smtp->from_email) }}"
                                placeholder="{{ translate('Enter from email') }}">
                        </div>
                    </div>
                </li>
                <li class="list-group-item p-4">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-2">
                            <label class="col-form-label"><strong>{{ translate('From name') }}</strong></label>
                        </div>
                        <div class="col">
                            <input type="text" name="smtp[from_name]" class="form-control"
                                value="{{ demo(@$settings->smtp->from_name) }}"
                                placeholder="{{ translate('Enter from name') }}">
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </form>
    @if (@$settings->smtp->status)
        <div class="card mt-3">
            <div class="card-header">
                {{ translate('Testing') }}
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.settings.smtp.test') }}" method="POST">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-lg-auto">
                            <label>{{ translate('E-mail Address') }} </label>
                        </div>
                        <div class="col">
                            <input type="email" name="email" class="form-control" placeholder="john@example.com"
                                value="{{ authUser()->email }}">
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-success">{{ translate('Send') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection
