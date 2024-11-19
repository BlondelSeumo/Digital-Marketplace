@extends('admin.layouts.grid')
@section('section', translate('KYC'))
@section('title', translate('KYC Verifications'))
@section('container', 'container-max-xxl')
@section('content')
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-card bg-orange">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-regular fa-hourglass-half"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Pending') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['pending'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-card bg-success">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Approved') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['approved'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-card bg-danger">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Rejected') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['rejected'] }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header p-3 border-bottom-small">
            <form action="{{ request()->url() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-5">
                        <input type="text" name="search" class="form-control" placeholder="{{ translate('Search...') }}"
                            value="{{ request('search') ?? '' }}">
                    </div>
                    <div class="col-12 col-lg-3">
                        <select name="document_type" class="form-select selectpicker"
                            title="{{ translate('Document Type') }}">
                            @foreach (\App\Models\KycVerification::getDocumentTypeOptions() as $key => $value)
                                <option value="{{ $key }}" @selected(request('document_type') == $key)>
                                    {{ translate($value) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="status" class="form-select selectpicker" title="{{ translate('Status') }}">
                            @foreach (\App\Models\KycVerification::getStatusOptions() as $key => $value)
                                <option value="{{ $key }}" @selected(request('status') == $key)>
                                    {{ $value }}
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
            @if ($kycVerifications->count() > 0)
                <div class="table-responsive">
                    <table class="vironeer-normal-table table w-100">
                        <thead>
                            <tr class="bg-light">
                                <th>{{ translate('ID') }}</th>
                                <th>{{ translate('User details') }}</th>
                                <th class="text-center">{{ translate('Document Type') }}</th>
                                <th class="text-center">{{ translate('Document Number') }}</th>
                                <th class="text-center">{{ translate('Status') }}</th>
                                <th class="text-center">{{ translate('Submited Date') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kycVerifications as $kycVerification)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.kyc.kyc-verifications.review', $kycVerification->id) }}">
                                            <i class="fa-solid fa-hashtag"></i>
                                            <span>{{ $kycVerification->id }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="vironeer-user-box">
                                            <a class="vironeer-user-avatar"
                                                href="{{ route('admin.members.users.edit', $kycVerification->user->id) }}">
                                                <img src="{{ $kycVerification->user->getAvatar() }}" class="rounded-3"
                                                    alt="{{ $kycVerification->user->getName() }}">
                                            </a>
                                            <div>
                                                <a class="text-reset"
                                                    href="{{ route('admin.members.users.edit', $kycVerification->user->id) }}">{{ $kycVerification->user->getName() }}</a>
                                                <p class="text-muted mb-0">{{ demo($kycVerification->user->email) }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if ($kycVerification->isNationalIdDocument())
                                            {{ translate('National ID') }}
                                        @elseif($kycVerification->isPassportDocument())
                                            {{ translate('Passport') }}
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $kycVerification->document_number }}</td>
                                    <td class="text-center">
                                        @if ($kycVerification->isPending())
                                            <div class="badge bg-warning">
                                                {{ $kycVerification->getStatusName() }}
                                            </div>
                                        @elseif ($kycVerification->isApproved())
                                            <div class="badge bg-success">
                                                {{ $kycVerification->getStatusName() }}
                                            </div>
                                        @elseif($kycVerification->isRejected())
                                            <div class="badge bg-danger">
                                                {{ $kycVerification->getStatusName() }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ dateFormat($kycVerification->created_at) }}</td>
                                    <td>
                                        <div class="text-end">
                                            <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                                aria-expanded="true">
                                                <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-sm-end"
                                                data-popper-placement="bottom-end">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.kyc.kyc-verifications.review', $kycVerification->id) }}"><i
                                                            class="fa-solid fa-desktop me-2"></i>{{ translate('Details') }}</a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li>
                                                    <form
                                                        action="{{ route('admin.kyc.kyc-verifications.destroy', $kycVerification->id) }}"
                                                        method="POST">
                                                        @csrf @method('DELETE')
                                                        <button class="action-confirm dropdown-item text-danger"><i
                                                                class="far fa-trash-alt me-2"></i>{{ translate('Delete') }}</button>
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
    {{ $kycVerifications->links() }}
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
