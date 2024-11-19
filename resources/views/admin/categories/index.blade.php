@extends('admin.layouts.grid')
@section('title', translate('Main Categories'))
@section('create', route('admin.categories.create'))
@section('content')
    <div class="card">
        <div class="card-header p-3 border-bottom-small">
            <form action="{{ request()->url() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-10">
                        <input type="text" name="search" class="form-control" placeholder="{{ translate('Search...') }}"
                            value="{{ request()->input('search') ?? '' }}">
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
            <div class="table-responsive">
                <table class="table vironeer-normal-table sortable-table w-100">
                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-hashtag"></i></th>
                            <th>{{ translate('Name') }}</th>
                            <th class="text-center">{{ translate('Views') }}</th>
                            <th class="text-center">{{ translate('Created date') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="sortable-table-tbody">
                        @forelse ($categories as $category)
                            <tr data-id="{{ $category->id }}">
                                <td>
                                    <span class="sortable-table-handle me-2 text-muted">
                                        <i class="fas fa-arrows-alt fa-lg"></i>
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-dark">
                                        <i class="fa-solid fa-tags me-2"></i>{{ $category->name }}
                                    </a>
                                </td>
                                <td class="text-center"><span class="badge bg-dark">{{ $category->views }}</span></td>
                                <td class="text-center">{{ dateFormat($category->created_at) }}</td>
                                <td>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                            aria-expanded="true">
                                            <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('categories.category', $category->slug) }}"
                                                    target="_blank">
                                                    <i class="fa fa-eye me-2"></i>
                                                    {{ translate('View') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.categories.sub-categories.index', 'category=' . $category->id) }}">
                                                    <i class="fa-solid fa-tag me-2"></i>
                                                    {{ translate('Sub Categories') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.categories.edit', $category->id) }}">
                                                    <i class="fa-regular fa-pen-to-square me-2"></i>
                                                    {{ translate('Edit') }}
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.categories.destroy', $category->id) }}"
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
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    <span class="text-muted">{{ translate('No Categories Found') }}</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('top_scripts')
        <script>
            const sortingRoute = "{{ route('admin.categories.sortable') }}";
        </script>
    @endpush
    @push('styles_libs')
        <link href="{{ asset('vendor/libs/jquery/jquery-ui.min.css') }}" />
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/jquery/jquery-ui.min.js') }}"></script>
    @endpush
@endsection
