@extends('admin.layouts.grid')
@section('section', translate('Sections'))
@section('title', translate('Home Sections'))
@section('container', 'container-max-lg')
@section('content')
    @if ($homeSections->count() > 0)
        <div class="card mb-3">
            <ul class="sortable-list custom-list-group list-group list-group-flush">
                @foreach ($homeSections as $homeSection)
                    <li class="list-group-item" data-id="{{ $homeSection->id }}">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <span class="sortable-list-handle text-muted">
                                    <i class="fas fa-arrows-alt fa-lg"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="item-title">
                                    <a href="{{ route('admin.sections.home-sections.edit', $homeSection->id) }}"
                                        class="text-dark">
                                        <h5 class="mb-0">{{ ucfirst(str_replace('_', ' ', $homeSection->alias)) }}</h5>
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="row g-4 align-items-center">
                                    <div class="col">
                                        @if ($homeSection->isActive())
                                            <span class="badge bg-success">{{ translate('Active') }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ translate('Disabled') }}</span>
                                        @endif
                                    </div>
                                    <div class="col">
                                        <a href="{{ route('admin.sections.home-sections.edit', $homeSection->id) }}"
                                            class="btn btn-secondary btn-md">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
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
            const sortingRoute = "{{ route('admin.sections.home-sections.sortable') }}";
        </script>
    @endpush
    @push('styles_libs')
        <link href="{{ asset('vendor/libs/jquery/jquery-ui.min.css') }}" />
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/jquery/jquery-ui.min.js') }}"></script>
    @endpush
@endsection
