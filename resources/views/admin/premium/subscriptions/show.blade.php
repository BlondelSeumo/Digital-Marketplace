@extends('admin.layouts.grid')
@section('section', translate('Premium'))
@section('title', translate('Subscription #:subscription_id', ['subscription_id' => $subscription->id]))
@section('back', route('admin.premium.subscriptions.index'))
@section('container', 'container-max-md')
@section('content')
    <div class="card mb-4">
        <ul class="list-group list-group-flush">
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Subscription ID') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span>#{{ $subscription->id }}</span>
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('User') }}</strong>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.members.users.edit', $subscription->user->id) }}" class="text-dark">
                            <i class="fa-regular fa-user me-1"></i>
                            {{ $subscription->user->username }}
                        </a>
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Plan') }}</strong>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.premium.plans.edit', $subscription->plan->id) }}" class="text-dark">
                            {{ translate(':plan_name (:plan_interval)', [
                                'plan_name' => $subscription->plan->name,
                                'plan_interval' => $subscription->plan->getIntervalName(),
                            ]) }}
                        </a>
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Downloads') }}</strong>
                    </div>
                    <div class="col-auto">
                        @if ($subscription->plan->hasUnlimitedDownloads())
                            <span>{{ translate('Unlimited') }}</span>
                        @else
                            <span>{{ $subscription->total_downloads }} /
                                {{ $subscription->plan->downloads }}</span>
                        @endif
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Expiry Date') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span>{{ dateFormat($subscription->expiry_at) }}</span>
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ translate('Date') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span>{{ dateFormat($subscription->created_at) }}</span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <form action="{{ route('admin.premium.subscriptions.cancel', $subscription->id) }}" method="POST">
        @csrf
        <button class="btn btn-outline-danger btn-lg w-100 action-confirm">
            <i class="fa-solid fa-xmark me-1"></i>
            {{ translate('Cancel Subscription') }}
        </button>
    </form>
@endsection
