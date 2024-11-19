@extends('admin.layouts.grid')
@section('section', translate('Members'))
@section('title', translate('Admins'))
@section('create', route('admin.members.admins.create'))
@section('container', 'container-max-xxl')
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
            @if ($admins->count() > 0)
                <div class="table-responsive">
                    <table class="vironeer-normal-table table w-100">
                        <thead>
                            <tr>
                                <th class="tb-w-3x">#</th>
                                <th class="tb-w-20x">{{ translate('Admin details') }}</th>
                                <th class="tb-w-3x text-center">{{ translate('Added date') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                                <tr>
                                    <td>{{ $admin->id }}</td>
                                    <td>
                                        <div class="vironeer-user-box">
                                            <a class="vironeer-user-avatar"
                                                href="{{ route('admin.members.admins.edit', $admin->id) }}">
                                                <img src="{{ $admin->getAvatar() }}" class="rounded-3"
                                                    alt="{{ $admin->getName() }}" />
                                            </a>
                                            <div>
                                                <a class="text-reset"
                                                    href="{{ route('admin.members.admins.edit', $admin->id) }}">{{ $admin->getName() }}</a>
                                                <p class="text-muted mb-0">{{ demo($admin->email) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ dateFormat($admin->created_at) }}</td>
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
                                                        href="{{ route('admin.members.admins.edit', $admin->id) }}">
                                                        <i class="fa-solid fa-desktop me-1"></i>
                                                        {{ translate('View Details') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.members.admins.destroy', $admin->id) }}"
                                                        method="POST">
                                                        @csrf @method('DELETE')
                                                        <button class="action-confirm dropdown-item text-danger"><i
                                                                class="far fa-trash-alt me-1"></i>{{ translate('Delete') }}</button>
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
    {{ $admins->links() }}
@endsection
