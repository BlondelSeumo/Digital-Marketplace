@extends('admin.layouts.grid')
@section('title', translate(':name Account balance', ['name' => $user->getName()]))
@section('back', route('admin.members.users.index'))
@section('content')
    @include('admin.members.users.includes.elements')
    <div class="row g-3">
        @include('admin.members.users.includes.sidebar')
        <div class="col-lg-9">
            <div class="card h-100">
                <div class="card-header">{{ translate('Account balance') }}</div>
                <div class="card-body p-4">
                    <div class="vironeer-counter-card bg-c-1 h-auto mb-3">
                        <div class="vironeer-counter-card-icon">
                            <i class="fa-solid fa-dollar-sign"></i>
                        </div>
                        <div class="vironeer-counter-card-meta">
                            <p class="vironeer-counter-card-title">{{ translate('Current balance') }}</p>
                            <p class="vironeer-counter-card-number">{{ getAmount($user->balance) }}</p>

                        </div>
                        <div class="ms-auto">
                            <a href="{{ route('admin.records.statements.index', ['user' => $user->id]) }}"
                                class="btn btn-outline-light">{{ translate('View Statements') }}</a>
                        </div>
                    </div>
                    <div class="card shadow-none border bg-light">
                        <div class="card-body p-4">
                            <h5 class="text-muted mb-3">{{ translate('Credit or Debit the balance') }}</h5>
                            <form action="{{ route('admin.members.users.wallet.update', $user->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">{{ translate('Type') }}</label>
                                    <select name="type" class="form-select form-select-md" required>
                                        <option value="credit" @selected(old('type' == 'credit'))>
                                            {{ translate('Credit') }}
                                        </option>
                                        <option value="debit" @selected(old('type' == 'debit'))>
                                            {{ translate('Debit') }}
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{ translate('Amount') }}</label>
                                    <input type="text" name="amount" class="form-control form-control-md input-price"
                                        value="{{ old('amount') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{ translate('Title') }}</label>
                                    <input type="text" name="title" class="form-control form-control-md"
                                        value="{{ old('title') }}" required>
                                </div>
                                <button class="btn btn-primary btn-md action-confirm">{{ translate('Submit') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
