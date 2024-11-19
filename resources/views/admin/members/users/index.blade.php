@extends('admin.layouts.grid')
@section('section', translate('Members'))
@section('title', translate('Users'))
@section('create', route('admin.members.users.create'))
@section('container', 'container-max-xxl')
@section('content')
    <div class="row g-3 row-cols-lg-{{ @$settings->kyc->status ? '3' : '4' }} mb-4">
        <div class="col">
            <div class="vironeer-counter-card bg-c-8">
                <div class="vironeer-counter-card-icon">
                    <i class="fa fa-users"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Active') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['active'] }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-danger">
                <div class="vironeer-counter-card-icon">
                    <i class="fa fa-ban"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Banned') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['banned'] }}</p>
                </div>
            </div>
        </div>
        @if (@$settings->kyc->status)
            <div class="col">
                <div class="vironeer-counter-card bg-c-14">
                    <div class="vironeer-counter-card-icon">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title">{{ translate('KYC Verified') }}</p>
                        <p class="vironeer-counter-card-number">{{ $counters['kyc_verified'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="vironeer-counter-card bg-c-5">
                    <div class="vironeer-counter-card-icon">
                        <i class="fa-solid fa-user-xmark"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title">{{ translate('KYC Unverified') }}</p>
                        <p class="vironeer-counter-card-number">{{ $counters['kyc_unverified'] }}</p>
                    </div>
                </div>
            </div>
        @endif
        <div class="col">
            <div class="vironeer-counter-card bg-success">
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-envelope-circle-check"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Email Verified') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['email_verified'] }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-gray">
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-envelope-open"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Email Unverified') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['email_unverified'] }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header p-3 border-bottom-small">
            <form action="{{ request()->url() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-12">
                        <input type="text" name="search" class="form-control"
                            placeholder="{{ translate('Search...') }}" value="{{ request()->input('search') ?? '' }}">
                    </div>
                    <div class="col-12 col-lg-4">
                        <select name="account_status" class="form-select selectpicker"
                            title="{{ translate('Account Status') }}">
                            <option value="1" @selected(request('account_status') == '1')>
                                {{ translate('Active') }}
                            </option>
                            <option value="0" @selected(request('account_status') == '0')>
                                {{ translate('Banned') }}
                            </option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-3">
                        <select name="kyc_status" class="form-select selectpicker" title="{{ translate('KYC Status') }}">
                            <option value="1" @selected(request('kyc_status') == '1')>
                                {{ translate('Verified') }}
                            </option>
                            <option value="0" @selected(request('kyc_status') == '0')>
                                {{ translate('Unverified') }}
                            </option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-3">
                        <select name="email_status" class="form-select selectpicker"
                            title="{{ translate('Email Status') }}">
                            <option value="1" @selected(request('email_status') == '1')>
                                {{ translate('Verified') }}
                            </option>
                            <option value="0" @selected(request('email_status') == '0')>
                                {{ translate('Unverified') }}
                            </option>
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
            @if ($users->count() > 0)
                <div class="table-responsive">
                    <table class="vironeer-normal-table table w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ translate('User details') }}</th>
                                <th>{{ translate('Username') }}</th>
                                @if (licenseType(2) && @$settings->premium->status)
                                    <th class="text-center">{{ translate('Premium') }}</th>
                                @endif
                                <th class="text-center">{{ translate('Account status') }}</th>
                                @if (@$settings->kyc->status)
                                    <th class="text-center">{{ translate('KYC Status') }}</th>
                                @endif
                                <th class="text-center">{{ translate('Email status') }}</th>
                                <th class="text-center">{{ translate('Registred date') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.members.users.edit', $user->id) }}">
                                            <i class="fa-solid fa-hashtag me-1"></i>{{ $user->id }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="vironeer-user-box">
                                            <a class="vironeer-user-avatar"
                                                href="{{ route('admin.members.users.edit', $user->id) }}">
                                                <img src="{{ $user->getAvatar() }}" class="rounded-3"
                                                    alt="{{ $user->getName() }}" />
                                            </a>
                                            <div>
                                                <a class="text-reset"
                                                    href="{{ route('admin.members.users.edit', $user->id) }}">{{ $user->getName() }}</a>
                                                <p class="text-muted mb-0">
                                                    {{ $user->email ? demo($user->email) : '--' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ '@' . $user->username ?? '--' }}</td>
                                    @if (licenseType(2) && @$settings->premium->status)
                                        <td class="text-center">
                                            @if ($user->isSubscribed())
                                                <span class="badge bg-c-22">{{ translate('Yes') }}</span>
                                            @else
                                                <span class="badge bg-c-17">{{ translate('No') }}</span>
                                            @endif
                                        </td>
                                    @endif
                                    <td class="text-center">
                                        @if ($user->isActive())
                                            <span class="badge bg-c-8">{{ translate('Active') }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ translate('Banned') }}</span>
                                        @endif
                                    </td>
                                    @if (@$settings->kyc->status)
                                        <td class="text-center">
                                            @if ($user->isKycVerified())
                                                <span class="badge bg-c-14">{{ translate('Verified') }}</span>
                                            @else
                                                <span class="badge bg-c-5">{{ translate('Unverified') }}</span>
                                            @endif
                                        </td>
                                    @endif
                                    <td class="text-center">
                                        @if ($user->isEmailVerified())
                                            <span class="badge bg-success">{{ translate('Verified') }}</span>
                                        @else
                                            <span class="badge bg-gray">{{ translate('Unverified') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ dateFormat($user->created_at) }}</td>
                                    <td>
                                        <div class="text-end">
                                            <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                                aria-expanded="true">
                                                <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-sm-end"
                                                data-popper-placement="bottom-end">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.members.users.edit', $user->id) }}">
                                                        <i class="fa-solid fa-desktop me-1"></i>
                                                        {{ translate('View Details') }}
                                                    </a>
                                                </li>
                                                @if (licenseType(2) && @$settings->premium->status && $user->isSubscribed())
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.premium.subscriptions.show', $user->subscription->id) }}">
                                                            <i class="fa-solid fa-crown me-1"></i>
                                                            {{ translate('View Subscription') }}
                                                        </a>
                                                    </li>
                                                @endif
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.members.users.destroy', $user->id) }}"
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
            @else
                @include('admin.partials.empty', ['empty_classes' => 'empty-lg'])
            @endif
        </div>
    </div>
    {{ $users->links() }}
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
