@extends('admin.layouts.form')
@section('section', translate('Financial'))
@section('title', translate('Edit Tax'))
@section('back', route('admin.financial.taxes.index'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.financial.taxes.update', $tax->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card p-2 pb-3">
            <div class="card-body">
                <div class="row g-3 row-cols-1">
                    <div class="col">
                        <label class="form-label">{{ translate('Name') }} </label>
                        <input type="text" name="name" class="form-control" value="{{ $tax->name }}" required />
                    </div>
                    <div class="col">
                        <label class="form-label">{{ translate('Rate') }} </label>
                        <div class="input-group">
                            <input type="number" name="rate" class="form-control" value="{{ $tax->rate }}"
                                placeholder="0" min="1" max="100" required />
                            <span class="input-group-text px-3"><i class="fa-solid fa-percent"></i></span>
                        </div>
                    </div>
                    <div class="col">
                        <label class="form-label">{{ translate('Countries') }}</label>
                        <select name="countries[]" class="form-select selectpicker" multiple data-live-search="true"
                            title="--" required>
                            @foreach (countries() as $countryCode => $countryName)
                                <option value="{{ $countryCode }}" @selected(in_array($countryCode, $tax->countries))>
                                    {{ $countryName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
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
