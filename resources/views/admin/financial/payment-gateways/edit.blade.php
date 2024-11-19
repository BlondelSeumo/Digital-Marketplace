@extends('admin.layouts.form')
@section('section', translate('Financial'))
@section('title', translate('Edit Payment Gateway'))
@section('back', route('admin.financial.payment-gateways.index'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.financial.payment-gateways.update', $paymentGateway->id) }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="vironeer-file-preview-box mb-3 bg-light p-4 text-center">
                            <div class="file-preview-box mb-3">
                                <img id="filePreview" src="{{ asset($paymentGateway->logo) }}" width="150px">
                            </div>
                            <button id="selectFileBtn" type="button" class="btn btn-secondary mb-2"><i
                                    class="fas fa-camera me-2"></i>{{ translate('Choose Logo') }}</button>
                            <input id="selectedFileInput" type="file" name="logo" accept=".png, .jpg, .jpeg, .webp"
                                hidden>
                            <small class="text-muted d-block">{{ translate('Allowed (PNG, JPG, JPEG, WEBP)') }}</small>
                        </div>
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <label class="form-label">{{ translate('Name') }}</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ $paymentGateway->name }}">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">{{ translate('Status') }} </label>
                                <input type="checkbox" name="status" data-toggle="toggle"
                                    {{ $paymentGateway->isActive() ? 'checked' : '' }}>
                            </div>
                            @if (!$paymentGateway->isWallet())
                                @if ($paymentGateway->mode)
                                    <div class="col-lg-6">
                                        <label class="form-label">{{ translate('Mode') }} </label>
                                        <select name="mode" class="form-select">
                                            @foreach (\App\Models\PaymentGateway::getModes() as $mode)
                                                <option value="{{ $mode }}"
                                                    {{ $paymentGateway->mode == $mode ? 'selected' : '' }}>
                                                    {{ ucfirst($mode) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="{{ $paymentGateway->mode ? 'col-lg-6' : 'col-lg-12' }}">
                                    <label class="form-label">{{ translate('Fees') }}</label>
                                    <div class="input-group">
                                        <input type="number" name="fees" class="form-control" placeholder="0"
                                            value="{{ $paymentGateway->fees }}">
                                        <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if (!$paymentGateway->isWallet())
                @if ($paymentGateway->parameters)
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">{{ translate('Parameters') }}</div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    @foreach ($paymentGateway->parameters as $key => $parameter)
                                        <div class="col-lg-12">
                                            <label class="form-label capitalize">{{ translate($parameter->label) }}</label>
                                            @if ($parameter->type == 'route')
                                                <div class="input-group">
                                                    <input id="input-link-{{ $key }}" type="text"
                                                        value="{{ url($parameter->content) }}" class="form-control"
                                                        readonly>
                                                    <button type="button" class="btn btn-secondary btn-copy"
                                                        data-clipboard-target="#input-link-{{ $key }}"><i
                                                            class="far fa-clone"></i></button>
                                                </div>
                                            @else
                                                <div class="input-group">
                                                    <input id="input-text-{{ $key }}" type="text"
                                                        value="{{ $parameter->content }}" class="form-control" readonly>
                                                    <button type="button" class="btn btn-secondary btn-copy"
                                                        data-clipboard-target="#input-text-{{ $key }}"><i
                                                            class="far fa-clone"></i></button>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-12">
                    @if (!$paymentGateway->isManual())
                        <div class="card">
                            <div class="card-header">{{ translate('Credentials') }}</div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    @foreach ($paymentGateway->credentials as $key => $value)
                                        <div class="col-lg-12">
                                            <label class="form-label capitalize">
                                                {{ translate(str_replace('_', ' ', $key)) }}
                                            </label>
                                            <input type="text" name="credentials[{{ $key }}]"
                                                value="{{ demo($value) }}" class="form-control">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card">
                            <div class="card-header">{{ translate('Instructions') }}</div>
                            <div class="card-body p-4">
                                <textarea name="instructions" class="ckeditor">{{ $paymentGateway->instructions }}</textarea>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </form>
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/clipboard/clipboard.min.js') }}"></script>
    @endpush
    @include('admin.partials.ckeditor')
@endsection
