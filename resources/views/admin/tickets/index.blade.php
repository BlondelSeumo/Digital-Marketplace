@extends('admin.layouts.grid')
@section('title', translate('Tickets'))
@section('create', route('admin.tickets.create'))
@section('content')
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-6 col-xxl-6">
            <div class="vironeer-counter-card bg-green">
                <div class="vironeer-counter-card-icon">
                    <i class="fa-regular fa-clock"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Opened tickets') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['opened_tickets'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl-6">
            <div class="vironeer-counter-card bg-red">
                <div class="vironeer-counter-card-icon">
                    <i class="fa-regular fa-circle-xmark"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Closed tickets') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['closed_tickets'] }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header p-3 border-bottom-small">
            <form action="{{ request()->url() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-6">
                        <input type="text" name="search" class="form-control" placeholder="{{ translate('Search...') }}"
                            value="{{ request()->input('search') ?? '' }}">
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="category" class="form-select selectpicker" title="{{ translate('Category') }}"
                            data-live-search="true">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected($category->id == request('category'))>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="status" class="form-select selectpicker" title="{{ translate('Status') }}">
                            @foreach (\App\Models\Ticket::getStatusOptions() as $key => $value)
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
            @if ($tickets->count() > 0)
                <div class="table-responsive">
                    <table class="vironeer-normal-table table w-100">
                        <thead class="bg-light">
                            <tr>
                                <th>{{ translate('ID') }}</th>
                                <th>{{ translate('Subject') }}</th>
                                <th>{{ translate('User') }}</th>
                                <th>{{ translate('Category') }}</th>
                                <th class="text-center">{{ translate('Status') }}</th>
                                <th class="text-center">{{ translate('Created date') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.tickets.show', $ticket->id) }}">
                                            <i class="fa-solid fa-hashtag"></i>
                                            <span>{{ $ticket->id }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="text-dark">
                                            {{ shorterText($ticket->subject, 50) }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.members.users.edit', $ticket->user->id) }}"
                                            class="text-dark">
                                            <i class="fa fa-user me-1"></i>
                                            {{ $ticket->user->username }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.tickets.categories.edit', $ticket->category->id) }}"
                                            class="text-dark">
                                            <i class="fa-solid fa-tag me-2"></i>
                                            {{ $ticket->category->name }}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        @if ($ticket->isOpened())
                                            <span class="badge bg-green">
                                                {{ $ticket->getStatusName() }}
                                            </span>
                                        @else
                                            <span class="badge bg-red">
                                                {{ $ticket->getStatusName() }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ dateFormat($ticket->created_at) }}</td>
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
                                                        href="{{ route('admin.tickets.show', $ticket->id) }}"><i
                                                            class="fas fa-eye me-2"></i>{{ translate('View') }}</a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.tickets.destroy', $ticket->id) }}"
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
    {{ $tickets->links() }}
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
