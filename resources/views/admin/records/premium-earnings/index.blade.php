@extends('admin.layouts.grid')
@section('section', translate('Records'))
@section('title', translate('Premium Earnings'))
@section('container', 'container-max-xxl')
@section('content')
    <div class="card">
        <div class="card-header p-3 border-bottom-small">
            <form action="{{ url()->current() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-6">
                        <input type="text" name="search" class="form-control" placeholder="{{ translate('Search...') }}"
                            value="{{ request('search') ?? '' }}">
                    </div>
                    <div class="col-12 col-lg-2">
                        <input type="text" name="date_from" class="form-control text-secondary"
                            placeholder="{{ translate('From Date') }}" onfocus="(this.type='date')"
                            onblur="(this.type='text')" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-12 col-lg-2">
                        <input type="text" name="date_to" class="form-control text-secondary"
                            placeholder="{{ translate('To Date') }}" onfocus="(this.type='date')"
                            onblur="(this.type='text')" value="{{ request('date_to') }}">
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
            @if ($premiumEarnings->count() > 0)
                <div class="overflow-hidden">
                    <div class="table-custom-container">
                        <table class="table-custom table">
                            <thead>
                                <tr class="bg-light">
                                    <th>{{ translate('ID') }}</th>
                                    <th class="text-center">{{ translate('Subscription') }}</th>
                                    <th class="text-center">{{ translate('Price') }}</th>
                                    <th class="text-center">{{ translate('Tax') }}</th>
                                    <th class="text-center">{{ translate('Total') }}</th>
                                    <th class="text-center">{{ translate('Date') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($premiumEarnings as $premiumEarning)
                                    <tr>
                                        <td>
                                            <a
                                                href="{{ route('admin.records.premium-earnings.show', $premiumEarning->id) }}"><i
                                                    class="fa-solid fa-hashtag me-1"></i>{{ $premiumEarning->id }}</a>
                                        </td>
                                        <td class="text-center">
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
                                        </td>
                                        <td class="text-center">
                                            {{ getAmount($premiumEarning->price) }}
                                        </td>
                                        <td class="text-center text-danger">
                                            {{ getAmount($premiumEarning->tax ? $premiumEarning->tax->amount : 0) }}
                                        </td>
                                        <td class="text-center text-success">
                                            {{ getAmount($premiumEarning->total) }}
                                        </td>
                                        <td class="text-center">{{ dateFormat($premiumEarning->created_at) }}</td>
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
                                                            href="{{ route('admin.records.premium-earnings.show', $premiumEarning->id) }}">
                                                            <i class="fa-solid fa-desktop me-1"></i>
                                                            {{ translate('View Details') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider" />
                                                    </li>
                                                    <li>
                                                        <form
                                                            action="{{ route('admin.records.premium-earnings.destroy', $premiumEarning->id) }}"
                                                            method="POST">
                                                            @csrf @method('DELETE')
                                                            <button class="action-confirm dropdown-item text-danger">
                                                                <i class="far fa-trash-alt me-1"></i>
                                                                {{ translate('Delete') }}
                                                            </button>
                                                        </form>
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
    {{ $premiumEarnings->links() }}
@endsection
