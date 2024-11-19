@extends('admin.layouts.grid')
@section('section', translate('Settings'))
@section('title', translate('Support Periods'))
@section('create', route('admin.settings.support-periods.create'))
@section('container', 'container-max-lg')
@section('content')
    @if ($supportPeriods->count() > 0)
        <div class="card mb-3">
            <ul class="sortable-list custom-list-group list-group list-group-flush">
                @foreach ($supportPeriods as $supportPeriod)
                    <li class="list-group-item" data-id="{{ $supportPeriod->id }}">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <span class="sortable-list-handle text-muted">
                                    <i class="fas fa-arrows-alt fa-lg"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="item-title">
                                    <a href="{{ route('admin.settings.support-periods.edit', $supportPeriod->id) }}"
                                        class="text-dark">
                                        <h5 class="m-0 d-inline">
                                            {{ $supportPeriod->name }}
                                            <span
                                                class="text-muted">{{ $supportPeriod->isDefault() ? translate('(Default)') : '' }}</span>
                                        </h5>
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="row g-3 align-items-center">
                                    <div class="col">
                                        <a href="{{ route('admin.settings.support-periods.edit', $supportPeriod->id) }}"
                                            class="btn btn-secondary btn-md">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <form
                                            action="{{ route('admin.settings.support-periods.destroy', $supportPeriod->id) }}"
                                            method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="action-confirm btn btn-danger btn-md">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="card">
            <div class="card-body">
                @include('admin.partials.empty', ['empty_classes' => 'empty-lg'])
            </div>
        </div>
    @endif
    @push('top_scripts')
        <script>
            const sortingRoute = "{{ route('admin.settings.support-periods.sortable') }}";
        </script>
    @endpush
    @push('styles_libs')
        <link href="{{ asset('vendor/libs/jquery/jquery-ui.min.css') }}" />
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/jquery/jquery-ui.min.js') }}"></script>
    @endpush
@endsection
