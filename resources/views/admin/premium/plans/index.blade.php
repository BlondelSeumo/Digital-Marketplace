@extends('admin.layouts.grid')
@section('section', translate('Premium'))
@section('title', translate('Plans'))
@section('create', route('admin.premium.plans.create'))
@section('container', 'container-max-xl')
@section('content')
    <div class="card">
        <div class="card-header p-3 border-bottom-small">
            <form class="multiple-select-search-form" action="{{ request()->url() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-8">
                        <input type="text" name="search" class="form-control" placeholder="{{ translate('Search...') }}"
                            value="{{ request()->input('search') ?? '' }}">
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="status" class="form-select selectpicker" title="{{ translate('Status') }}">
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>
                                {{ translate('Active') }}
                            </option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>
                                {{ translate('Disabled') }}</option>
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
            @if ($plans->count() > 0)
                <div class="table-responsive">
                    <table class="table sortable-table w-100">
                        <thead>
                            <tr>
                                <th><i class="fa-solid fa-hashtag"></i></th>
                                <th>{{ translate('Name') }}</th>
                                <th>{{ translate('Interval') }}</th>
                                <th class="text-center">{{ translate('Price') }}</th>
                                <th class="text-center">{{ translate('Downloads') }}</th>
                                <th class="text-center">{{ translate('Status') }}</th>
                                <th class="text-end">{{ translate('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="sortable-table-tbody">
                            @foreach ($plans as $plan)
                                <tr data-id="{{ $plan->id }}">
                                    <td>
                                        <span class="sortable-table-handle me-2 text-muted">
                                            <i class="fas fa-arrows-alt fa-lg"></i>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.premium.plans.edit', $plan->id) }}" class="text-dark">
                                            {{ $plan->name }}
                                            @if ($plan->isFeatured())
                                                <span class="badge bg-c-2 ms-2">{{ translate('Featured') }}</span>
                                            @endif
                                        </a>
                                    </td>
                                    <td>{{ $plan->getIntervalName() }}</td>
                                    <td class="text-center">
                                        {{ !$plan->isFree() ? getAmount($plan->price) : translate('Free') }}</td>
                                    <td class="text-center">
                                        {{ $plan->hasUnlimitedDownloads() ? translate('Unlimited') : number_format($plan->downloads) }}
                                    </td>
                                    <td class="text-center">
                                        @if ($plan->isActive())
                                            <span class="badge bg-green">{{ translate('Active') }}</span>
                                        @else
                                            <span class="badge bg-red">{{ translate('Disabled') }}</span>
                                        @endif
                                    </td>
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
                                                        href="{{ route('admin.premium.plans.edit', $plan->id) }}">
                                                        <i class="fa-regular fa-pen-to-square me-2"></i>
                                                        {{ translate('Edit') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.premium.plans.destroy', $plan->id) }}"
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
    @push('top_scripts')
        <script>
            const sortingRoute = "{{ route('admin.premium.plans.sortable') }}";
        </script>
    @endpush
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
        <link href="{{ asset('vendor/libs/jquery/jquery-ui.min.css') }}" />
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/jquery/jquery-ui.min.js') }}"></script>
    @endpush
@endsection
