@extends('admin.layouts.grid')
@section('section', translate('Refunds'))
@section('title', translate('Refund #:refund_id', ['refund_id' => $refund->id]))
@section('back', route('admin.refunds.index'))
@section('content')
    <div class="row">
        <div class="col-lg-6 col-xxl-7">
            <div class="row g-3 mb-3">
                @foreach ($refund->replies as $reply)
                    <div class="col-12">
                        <div class="conversation">
                            <div class="card">
                                <div class="card-body p-4">
                                    <div class="mb-4">
                                        <div class="row row-cols-auto justify-content-between align-items-center g-3">
                                            <div class="col">
                                                @php
                                                    $user = $reply->user;
                                                @endphp
                                                @if ($user->id == authUser()->id)
                                                    <a class="conversation-user text-dark">
                                                        <img src="{{ $user->getAvatar() }}" alt="{{ $user->username }}">
                                                        <span class="h6 mb-0">{{ $user->username }}</span>
                                                        @if ($user->isAdmin())
                                                            <i class="bi bi-patch-check-fill text-primary ms-2"
                                                                title="{{ translate('Admin') }}"></i>
                                                        @endif
                                                    </a>
                                                @else
                                                    @if ($user->isUser())
                                                        <a href="{{ route('admin.members.admins.edit', $user->id) }}"
                                                            class="conversation-user">
                                                            <img src="{{ $user->getAvatar() }}" alt="{{ $user->username }}">
                                                            <span class="h6 mb-0">{{ $user->username }}</span>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('admin.members.users.edit', $user->id) }}"
                                                            class="conversation-user">
                                                            <img src="{{ $user->getAvatar() }}"
                                                                alt="{{ $user->username }}">
                                                            <span class="h6 mb-0">{{ $user->username }}</span>
                                                            <i class="bi bi-patch-check-fill text-primary ms-2"
                                                                title="{{ translate('Admin') }}"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="col">
                                                <time class="text-muted small">{{ dateFormat($reply->created_at) }}</time>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="conversation-content">
                                        {!! purifier($reply->body) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if ($refund->isPending())
                <div class="card">
                    <div class="card-body p-4">
                        <form action="{{ route('admin.refunds.reply', $refund->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">{{ translate('Your reply') }}</label>
                                <textarea name="reply" class="form-control" rows="7" required></textarea>
                            </div>
                            <button class="btn btn-primary btn-md px-4">{{ translate('Send') }}</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-lg-6 col-xxl-5">
            <div class="card shadow-sm">
                <div class="card-body p-4 py-3">
                    @php
                        $purchase = $refund->purchase;
                        $item = $purchase->item;
                    @endphp
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item py-3 px-0">
                            <div class="row align-items-center g-3">
                                <div class="col">
                                    <strong>{{ translate('Refund ID') }}</strong>
                                </div>
                                <div class="col-auto">
                                    <span>#{{ $refund->id }}</span>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item py-3 px-0">
                            <div class="row align-items-center g-3">
                                <div class="col">
                                    <strong>{{ translate('Purchase') }}</strong>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('admin.records.purchases.show', $refund->purchase->id) }}"
                                        target="_blank" class="text-dark">
                                        <i class="fa-solid fa-up-right-from-square me-1"></i>
                                        {{ $item->name }}
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item py-3 px-0">
                            <div class="row align-items-center g-3">
                                <div class="col">
                                    <strong>{{ translate('License Type') }}</strong>
                                </div>
                                <div class="col-auto">
                                    @if ($purchase->isLicenseTypeRegular())
                                        <div class="badge bg-gray rounded-2 fw-light px-3 py-2">
                                            {{ translate('Regular') }}
                                        </div>
                                    @else
                                        <div class="badge bg-primary rounded-2 fw-light px-3 py-2">
                                            {{ translate('Extended') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item py-3 px-0">
                            <div class="row align-items-center g-3">
                                <div class="col">
                                    <strong>{{ translate('Price') }}</strong>
                                </div>
                                <div class="col-auto">
                                    {{ getAmount($purchase->sale->price) }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item py-3 px-0">
                            <div class="row align-items-center g-3">
                                <div class="col">
                                    <strong>{{ translate('Purchase Date') }}</strong>
                                </div>
                                <div class="col-auto">
                                    {{ dateFormat($purchase->created_at) }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item py-3 px-0">
                            <div class="row align-items-center g-3">
                                <div class="col">
                                    <strong>{{ translate('Purchase Code') }}</strong>
                                </div>
                                <div class="col-auto">
                                    {{ $purchase->code }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item py-3 px-0">
                            <div class="row align-items-center g-3">
                                <div class="col">
                                    <strong>{{ translate('Downloaded') }}</strong>
                                </div>
                                <div class="col-auto">
                                    @if ($purchase->isDownloaded())
                                        <div class="badge bg-blue rounded-2 fw-light px-3 py-2">
                                            {{ translate('Yes') }}
                                        </div>
                                    @else
                                        <div class="badge bg-gray rounded-2 fw-light px-3 py-2">
                                            {{ translate('No') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item py-3 px-0">
                            <div class="row align-items-center g-3">
                                <div class="col">
                                    <strong>{{ translate('User') }}</strong>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('admin.members.users.edit', $refund->user->id) }}" class="text-dark">
                                        <i class="fa-regular fa-user me-1"></i>
                                        {{ $refund->user->username }}
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item py-3 px-0">
                            <div class="row align-items-center g-3">
                                <div class="col">
                                    <strong>{{ translate('Status') }}</strong>
                                </div>
                                <div class="col-auto">
                                    @if ($refund->isPending())
                                        <div class="badge bg-orange rounded-2 fw-light px-3 py-2">
                                            {{ $refund->getStatusName() }}
                                        </div>
                                    @elseif ($refund->isAccepted())
                                        <div class="badge bg-green rounded-2 fw-light px-3 py-2">
                                            {{ $refund->getStatusName() }}
                                        </div>
                                    @else
                                        <div class="badge bg-red rounded-2 fw-light px-3 py-2">
                                            {{ $refund->getStatusName() }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item py-3 px-0">
                            <div class="row align-items-center g-3">
                                <div class="col">
                                    <strong>{{ translate('Date') }}</strong>
                                </div>
                                <div class="col-auto">
                                    {{ dateFormat($refund->created_at) }}
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            @if ($refund->isPending())
                <div class="card p-4 mt-3">
                    <div class="row g-3 row-cols-1">
                        <div class="col">
                            <form action="{{ route('admin.refunds.accept', $refund->id) }}" method="POST">
                                @csrf
                                <button
                                    class="btn btn-success btn-lg w-100 action-confirm">{{ translate('Accept') }}</button>
                            </form>
                        </div>
                        <div class="col">
                            <button id="declineRequest"
                                class="btn btn-danger btn-lg w-100">{{ translate('Decline') }}</button>
                        </div>
                        <div id="declineRequestForm" class="col-12" style="display: none;">
                            <form action="{{ route('admin.refunds.decline', $refund->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">{{ translate('Reason') }}</label>
                                    <textarea name="reason" class="form-control" rows="5" required></textarea>
                                </div>
                                <button class="btn btn-danger btn-md action-confirm">{{ translate('Submit') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @push('scripts')
        <script>
            "use strict";
            let declineRequest = $('#declineRequest'),
                declineRequestForm = $('#declineRequestForm');
            declineRequest.on('click', function() {
                declineRequestForm.toggle();
            });
        </script>
    @endpush
@endsection
