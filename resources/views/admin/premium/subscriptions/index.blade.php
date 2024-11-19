@extends('admin.layouts.grid')
@section('section', translate('Premium'))
@section('title', translate('Subscriptions'))
@section('content')
    <div class="card">
        <div class="card-header p-3 border-bottom-small">
            <form action="{{ url()->current() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-7">
                        <input type="text" name="search" class="form-control" placeholder="{{ translate('Search...') }}"
                            value="{{ request('search') ?? '' }}">
                    </div>
                    <div class="col-12 col-lg-3">
                        <select name="plan" class="form-select selectpicker" title="{{ translate('Plan') }}">
                            @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}" @selected($plan->id == request('plan'))>
                                    {{ translate(':plan_name (:plan_interval)', [
                                        'plan_name' => $plan->name,
                                        'plan_interval' => $plan->getIntervalName(),
                                    ]) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary w-100"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="col">
                        <a href="{{ url()->current() }}" class="btn btn-secondary w-100">{{ translate('Reset') }}</a>
                    </div>
                </div>
            </form>
        </div>
        <div>
            @if ($subscriptions->count() > 0)
                <div class="overflow-hidden">
                    <div class="table-custom-container">
                        <table class="table-custom table">
                            <thead>
                                <tr class="bg-light">
                                    <th>{{ translate('ID') }}</th>
                                    <th>{{ translate('User') }}</th>
                                    <th class="text-center">{{ translate('Plan') }}</th>
                                    <th class="text-center">{{ translate('Downloads') }}</th>
                                    <th class="text-center">{{ translate('Expiry date') }}</th>
                                    <th class="text-center">{{ translate('Date') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscriptions as $subscription)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.premium.subscriptions.show', $subscription->id) }}"><i
                                                    class="fa-solid fa-hashtag me-1"></i>{{ $subscription->id }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.members.users.edit', $subscription->user->id) }}"
                                                class="text-dark">
                                                <i class="fa-regular fa-user me-1"></i>
                                                {{ $subscription->user->username }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.premium.plans.edit', $subscription->plan->id) }}"
                                                class="text-dark">
                                                {{ translate(':plan_name (:plan_interval)', [
                                                    'plan_name' => $subscription->plan->name,
                                                    'plan_interval' => $subscription->plan->getIntervalName(),
                                                ]) }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            @if ($subscription->plan->hasUnlimitedDownloads())
                                                <span>{{ translate('Unlimited') }}</span>
                                            @else
                                                <span>{{ $subscription->total_downloads }} /
                                                    {{ $subscription->plan->downloads }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ dateFormat($subscription->expiry_at) }}</td>
                                        <td class="text-center">{{ dateFormat($subscription->created_at) }}</td>
                                        <td>
                                            <div class="text-end">
                                                <button type="button" class="btn btn-sm rounded-3"
                                                    data-bs-toggle="dropdown" aria-expanded="true">
                                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-sm-end"
                                                    data-popper-placement="bottom-end">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.premium.subscriptions.show', $subscription->id) }}">
                                                            <i class="fa-solid fa-desktop me-1"></i>
                                                            {{ translate('View details') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                @include('admin.partials.empty', ['empty_classes' => 'empty-lg'])
            @endif
        </div>
    </div>
    {{ $subscriptions->links() }}
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
