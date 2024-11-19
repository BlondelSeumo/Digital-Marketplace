@extends('admin.layouts.grid')
@section('section', translate('Records'))
@section('title', translate('Statments'))
@section('container', 'container-max-xxl')
@section('content')
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-6">
            <div class="vironeer-counter-card bg-green">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-circle-dollar-to-slot"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Total Cedited') }}
                        ({{ numberFormat($counters['credit']['total']) }})</p>
                    <p class="vironeer-counter-card-number">{{ getAmount($counters['credit']['amount']) }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="vironeer-counter-card bg-danger">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-cash-register"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ translate('Total Debited') }}
                        ({{ numberFormat($counters['debit']['total']) }})</p>
                    <p class="vironeer-counter-card-number">{{ getAmount($counters['debit']['amount']) }}</p>
                </div>
            </div>
        </div>
    </div>
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
            @if ($statements->count() > 0)
                <div class="overflow-hidden">
                    <div class="table-custom-container">
                        <table class="table-custom table">
                            <thead>
                                <tr>
                                    <th>{{ translate('ID') }}</th>
                                    <th>{{ translate('Details') }}</th>
                                    <th class="text-center">{{ translate('Amount') }}</th>
                                    <th class="text-center">{{ translate('Date') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($statements as $statement)
                                    <tr>
                                        <td><i class="fa-solid fa-hashtag me-1"></i>{{ $statement->id }}</td>
                                        <td class="text-muted">{{ $statement->title }}</td>
                                        <td
                                            class="text-center {{ $statement->isCredit() ? 'text-success' : 'text-danger' }}">
                                            <strong>{{ $statement->getAmount() }}</strong>
                                        </td>
                                        <td class="text-center">
                                            {{ dateFormat($statement->created_at) }}
                                        </td>
                                        <td>
                                            <div class="text-end">
                                                <button type="button" class="btn btn-sm rounded-3"
                                                    data-bs-toggle="dropdown" aria-expanded="true">
                                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-sm-end"
                                                    data-popper-placement="bottom-end">
                                                    <li>
                                                        <a href="{{ route('admin.members.users.edit', $statement->user->id) }}"
                                                            class="dropdown-item">
                                                            <i class="far fa-user me-2"></i>
                                                            {{ translate('View User') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider" />
                                                    </li>
                                                    <li>
                                                        <form
                                                            action="{{ route('admin.records.statements.destroy', $statement->id) }}"
                                                            method="POST">
                                                            @csrf @method('DELETE')
                                                            <button class="action-confirm dropdown-item text-danger">
                                                                <i class="far fa-trash-alt me-2"></i>
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
    {{ $statements->links() }}
@endsection
