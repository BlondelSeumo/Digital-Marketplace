@extends('themes.basic.user.layouts.app')
@section('section', translate('Refunds'))
@section('title', translate('Request a Refund'))
@section('breadcrumbs', Breadcrumbs::render('user.refunds.create'))
@section('back', route('user.refunds.index'))
@section('container', 'dashboard-container-sm')
@section('content')
    <div class="box">
        <form action="{{ route('user.refunds.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="form-label">{{ translate('Purchased Item') }}</label>
                <select name="purchase" class="selectpicker selectpicker-md" data-live-search="true" title="--" required>
                    @foreach ($purchases as $purchase)
                        <option value="{{ $purchase->id }}" @selected($purchase->id == request('purchase'))>{{ $purchase->item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="form-label">{{ translate('Reason') }}</label>
                <textarea name="reason" class="form-control" rows="8" required></textarea>
                <div class="form-text mt-2">
                    {{ translate('Explain the reason for requesting a refund, which will help to process your request faster') }}
                </div>
            </div>
            <button class="btn btn-primary btn-md px-4">{{ translate('Submit') }}</button>
        </form>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
