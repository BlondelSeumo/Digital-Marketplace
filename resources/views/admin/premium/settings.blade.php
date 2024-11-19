@extends('admin.layouts.form')
@section('section', translate('Premium'))
@section('title', translate('Premium Settings'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.premium.settings.update') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="col-lg-4">
                            <label class="form-label">{{ translate('Status') }}</label>
                            <input type="checkbox" name="premium[status]" data-toggle="toggle" @checked(@$settings->premium->status)>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ translate('Premium Terms') }}</label>
                        <input type="text" name="premium[terms_link]" class="form-control"
                            value="{{ @$settings->premium->terms_link }}">
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
