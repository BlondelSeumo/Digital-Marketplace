@extends('admin.layouts.grid')
@section('title', translate('Category Options'))
@section('create', route('admin.categories.category-options.create'))
@section('content')
    <div class="card">
        <div class="card-header p-3 border-bottom-small">
            <form action="{{ request()->url() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-7">
                        <input type="text" name="search" class="form-control" placeholder="{{ translate('Search...') }}"
                            value="{{ request()->input('search') ?? '' }}">
                    </div>
                    <div class="col-12 col-lg-3">
                        <select name="category" class="form-select selectpicker" title="{{ translate('Category') }}"
                            data-live-search="true">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $category->id == request('category') ? 'selected' : '' }}>
                                    {{ $category->name }}</option>
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
            <div class="table-responsive">
                <table class="table vironeer-normal-table sortable-table w-100">
                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-hashtag"></i></th>
                            <th>{{ translate('Option Name') }}</th>
                            <th>{{ translate('Category') }}</th>
                            <th class="text-center">{{ translate('Created date') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="sortable-table-tbody">
                        @forelse ($categoryOptions as $categoryOption)
                            <tr data-id="{{ $categoryOption->id }}">
                                <td>
                                    <span class="sortable-table-handle me-2 text-muted">
                                        <i class="fas fa-arrows-alt fa-lg"></i>
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.categories.category-options.edit', $categoryOption->id) }}"
                                        class="text-dark">
                                        {{ $categoryOption->name }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.categories.edit', $categoryOption->category->id) }}"
                                        class="text-dark">
                                        <i class="fa-solid fa-tags me-2"></i>
                                        {{ $categoryOption->category->name }}
                                    </a>
                                </td>
                                <td class="text-center">{{ dateFormat($categoryOption->created_at) }}</td>
                                <td>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                            aria-expanded="true">
                                            <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.categories.category-options.edit', $categoryOption->id) }}"><i
                                                        class="fa-regular fa-pen-to-square me-2"></i>{{ translate('Edit') }}</a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li>
                                                <form
                                                    action="{{ route('admin.categories.category-options.destroy', $categoryOption->id) }}"
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
                                <td colspan="5" class="text-center">
                                    <span class="text-muted">{{ translate('No Category options Found') }}</span>
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
            const sortingRoute = "{{ route('admin.categories.category-options.sortable') }}";
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
