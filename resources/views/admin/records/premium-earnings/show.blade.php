@extends('admin.layouts.grid')
@section('section', translate('Records'))
@section('title', translate('Premium Earning #:premium_earning_id', ['premium_earning_id' => $premiumEarning->id]))
@section('back', route('admin.records.premium-earnings.index'))
@section('container', 'container-max-md')
@section('content')
    <div class="card mb-4">
        <ul class="list-group list-group-flush">
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('ID') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span>#{{ $premiumEarning->id }}</span>
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Subscription') }}</strong>
                    </div>
                    <div class="col-auto">
                        @if ($premiumEarning->subscription)
                            <a href="{{ route('admin.premium.subscriptions.show', $premiumEarning->subscription->id) }}"
                                class="text-dark">
                                {{ translate(':plan_name (:plan_interval)', [
                                    'plan_name' => $premiumEarning->subscription->plan->name,
                                    'plan_interval' => $premiumEarning->subscription->plan->getIntervalName(),
                                ]) }}
                            </a>
                        @else
                            <span>{{ $premiumEarning->name }}</span>
                        @endif
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Price') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span>{{ getAmount($premiumEarning->price) }}</span>
                    </div>
                </div>
            </li>
            @if ($premiumEarning->tax)
                <li class="list-group-item p-4">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <strong>{{ translate(':tax_name (:tax_rate%)', [
                                'tax_name' => $premiumEarning->tax->name,
                                'tax_rate' => $premiumEarning->tax->rate,
                            ]) }}</strong>
                        </div>
                        <div class="col-auto">
                            <span class="text-danger">{{ getAmount($premiumEarning->tax->amount) }}</span>
                        </div>
                    </div>
                </li>
            @endif
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Total') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span class="text-success">{{ getAmount($premiumEarning->total) }}</span>
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Date') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span>{{ dateFormat($premiumEarning->created_at) }}</span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <form action="{{ route('admin.records.premium-earnings.destroy', $premiumEarning->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-outline-danger btn-lg w-100 action-confirm">{{ translate('Delete') }}</button>
    </form>
@endsection
