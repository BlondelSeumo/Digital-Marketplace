@extends('installer::layouts.app')
@section('title', installer_trans('Import'))
@section('content')
    <div class="vironeer-steps-body">
        <p class="vironeer-form-info-text">
            {{ installer_trans('Import your database, some servers may not support this feature or have problems, so we recommend using manual Import if you encounter a problem with automatic Import.') }}
        </p>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active text-success" id="auto-tab" data-bs-toggle="tab" data-bs-target="#auto"
                    type="button" role="tab" aria-controls="auto" aria-selected="true"><i
                        class="fas fa-file-import me-2"></i>{{ installer_trans('Auto Import') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-secondary" id="manual-tab" data-bs-toggle="tab" data-bs-target="#manual"
                    type="button" role="tab" aria-controls="manual" aria-selected="false"><i
                        class="fas fa-file-download me-2"></i>{{ installer_trans('Manual Import') }}</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="auto" role="tabpanel" aria-labelledby="auto-tab">
                <div class="card-body border-top-0 py-4">
                    <h3 class="text-muted mb-3">
                        {{ installer_trans('Importing your database automatically, click import now') }}
                    </h3>
                    <div class="mb-4">
                        <form action="{{ route('installer.database.import') }}" method="POST">
                            @csrf
                            <button class="btn btn-success btn-md"><i
                                    class="fas fa-upload me-2"></i>{{ installer_trans('Import Now') }}</button>
                        </form>
                    </div>
                    <div class="alert alert-danger mb-0">
                        <div class="row g-3">
                            <div class="col-lg-4">
                                <img src="{{ asset('vendor/installer/img/import-error.png') }}" width="100%">
                            </div>
                            <div class="col-lg-8">
                                <strong>{{ installer_trans('Important Notice !') }} :</strong>
                                <hr>
                                <p>{{ installer_trans('Auto import is not supported on some servers, if you click import and you get 500 Error that means your server does not support it, please use the manual import.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="manual" role="tabpanel" aria-labelledby="manual-tab">
                <div class="card-body border-top-0 p-4">
                    <h3 class="text-muted mb-3">
                        {{ installer_trans('Importing your database Manually, follow the steps') }}
                    </h3>
                    <hr>
                    <div class="mb-0">
                        <div class="step-1">
                            <h5 class="text-muted mb-3">{{ installer_trans('1 - Download the SQL file') }}</h5>
                            <form action="{{ route('installer.database.import.download') }}" method="POST">
                                @csrf
                                <button class="btn btn-warning btn-md"><i
                                        class="fas fa-download me-2"></i>{{ installer_trans('Download SQL file') }}</button>
                            </form>
                        </div>
                        <hr>
                        <div class="step-2">
                            <h5 class="text-muted mb-3">{{ installer_trans('2 - Follow this steps') }}</h5>
                            <img src="{{ asset('vendor/installer/img/database-steps.png') }}" width="500">
                            <div class="alert alert-warning mb-0 mt-3">
                                <p class="mb-0">
                                    <i class="fab fa-youtube me-2"></i>
                                    <span>{{ installer_trans('Check this video to know how you can import the database') }} :
                                    </span>
                                    <br>
                                    <a href="https://www.youtube.com/watch?v=jW5lrS6EUPM&ab_channel=HostGator"
                                        target="_blank">https://www.youtube.com/watch?v=jW5lrS6EUPM&ab_channel=HostGator</a>
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="step-3">
                            <h5 class="text-muted mb-3">
                                {{ installer_trans('3 - After importing the database, click Skip to the next step') }}</h5>
                            <form action="{{ route('installer.database.import.skip') }}" method="POST">
                                @csrf
                                <button class="btn btn-primary btn-md">{{ installer_trans('Skip to next step') }}<i
                                        class="fas fa-arrow-right ms-2"></i></button>
                            </form>
                            <div class="alert alert-primary mt-3 mb-0">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ installer_trans('Make sure you import the database before clicking skip to next step') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
