@extends('admin.layouts.form')
@section('section', translate('Premium'))
@section('title', translate('New Plan'))
@section('back', route('admin.premium.plans.index'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.premium.plans.store') }}" method="POST">
        @csrf
        <div class="card mb-4">
            <div class="card-header">{{ translate('Actions') }}</div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-12 col-lg">
                        <label class="form-label">{{ translate('Status') }}</label>
                        <input type="checkbox" name="status" data-toggle="toggle" @checked(old('status') ?? true)>
                    </div>
                    <div class="col-12 col-lg">
                        <label class="form-label">{{ translate('Featured') }}</label>
                        <input type="checkbox" name="featured" data-toggle="toggle" @checked(old('featured'))>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">{{ translate('Plan Details') }}</div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">{{ translate('Name') }}</label>
                        <input type="text" name="name" class="form-control form-control-md"
                            value="{{ old('name') }}" autofocus required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ translate('Description') }}</label>
                        <textarea name="description" class="form-control form-control-md" rows="3">{{ old('description') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ translate('Interval') }}</label>
                        <select name="interval" class="form-select form-select-md">
                            @foreach (\App\Models\Plan::getIntervalOptions() as $key => $value)
                                <option value="{{ $key }}" @selected(old('interval') == $key)>{{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ translate('Price') }}</label>
                        <div class="custom-input-group input-group">
                            @if (@$settings->currency->position == 1)
                                <span class="input-group-text px-4 bg-white">{{ @$settings->currency->symbol }}</span>
                            @endif
                            <input name="price" class="form-control form-control-md input-price" placeholder="0"
                                value="{{ old('price') }}">
                            @if (@$settings->currency->position == 2)
                                <span class="input-group-text px-4 bg-white">{{ @$settings->currency->symbol }}</span>
                            @endif
                        </div>
                        <div class="form-text">{{ translate('Leave the field empty to make the plan free.') }}</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ translate('Downloads (per day)') }}</label>
                        <input type="number" name="downloads" class="form-control form-control-md" placeholder="0"
                            value="{{ old('downloads') }}">
                        <div class="form-text">{{ translate('Leave the field empty for unlimited downloads.') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">{{ translate('Custom Features') }}</div>
            <div class="card-body p-4">
                <div class="row g-3 custom-features">
                    <div class="col-12">
                        <button id="addCustomFeature" type="button" class="btn btn-dark btn-md">
                            <i class="fa fa-plus me-1"></i>
                            {{ translate('Add custom feature') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('top_scripts')
        <script>
            "use strict";
            let customFeatures_i = 1;
        </script>
    @endpush
@endsection
