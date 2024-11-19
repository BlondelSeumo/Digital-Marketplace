@extends('admin.layouts.grid')
@section('section', translate('Tickets'))
@section('title', translate('Ticket #:ticket_id', ['ticket_id' => $ticket->id]))
@section('back', route('admin.tickets.index'))
@section('content')
    <div class="row g-3">
        <div class="col-12 col-xl-8">
            <div class="row g-3 mb-3">
                @foreach ($ticket->replies as $reply)
                    <div class="col-12">
                        <div class="conversation">
                            <div class="card">
                                <div class="card-body p-4">
                                    <div class="mb-4">
                                        <div class="row row-cols-auto justify-content-between align-items-center g-3">
                                            <div class="col">
                                                <div class="conversation-user">
                                                    @php
                                                        $user = $reply->user;
                                                    @endphp
                                                    @if ($user->id == authUser()->id)
                                                        <img src="{{ $user->getAvatar() }}" alt="{{ $user->username }}">
                                                        <span class="h6 mb-0">{{ $user->username }}</span>
                                                        @if ($user->isAdmin())
                                                            <i class="bi bi-patch-check-fill text-primary ms-2"
                                                                title="{{ translate('Admin') }}"></i>
                                                        @endif
                                                    @else
                                                        @if ($user->isUser())
                                                            <a href="{{ route('admin.members.users.edit', $user->id) }}">
                                                                <img src="{{ $user->getAvatar() }}"
                                                                    alt="{{ $user->username }}">
                                                                <span class="h6 mb-0">{{ $user->username }}</span>
                                                            </a>
                                                        @else
                                                            <a href="{{ route('admin.members.admins.edit', $user->id) }}">
                                                                <img src="{{ $user->getAvatar() }}"
                                                                    alt="{{ $user->username }}">
                                                                <span class="h6 mb-0">{{ $user->username }}</span>
                                                            </a>
                                                            <i class="bi bi-patch-check-fill text-primary ms-2"
                                                                title="{{ translate('Admin') }}"></i>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <time class="text-muted small">{{ dateFormat($reply->created_at) }}</time>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="conversation-content">
                                        @if ($loop->first)
                                            <h5 class="mb-3">{{ $ticket->subject }}</h5>
                                        @endif
                                        {!! purifier($reply->body) !!}
                                        @if ($reply->attachments->count() > 0)
                                            <div class="mt-4">
                                                <h6 class="text-dark mb-3">
                                                    {{ translate('Attached files') }}:
                                                </h6>
                                                <div class="row g-3">
                                                    @foreach ($reply->attachments as $attachment)
                                                        <div class="col-lg-6">
                                                            <a href="{{ route('admin.tickets.download', [$ticket->id, $attachment->id]) }}"
                                                                class="d-block text-muted bg-light p-3 border rounded-2 h-100">
                                                                <div class="row align-items-center g-2">
                                                                    <div class="col-auto">
                                                                        <i class="fa fa-file-alt fa-lg"></i>
                                                                    </div>
                                                                    <div class="col">
                                                                        <h6 class="mb-0">
                                                                            {{ shorterText($attachment->name, 40) }}
                                                                        </h6>
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <i class="fa fa-download"></i>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-4">
                            <h5 class="mb-3">{{ translate('Reply') }}</h5>
                            <form action="{{ route('admin.tickets.reply', $ticket->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row g-3 mb-3">
                                    <div class="col-lg-12">
                                        <textarea name="reply" class="form-control" rows="5" required>{{ old('reply') }}</textarea>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="attachments">
                                            <div class="attachment-box-1">
                                                <label class="form-label">{{ translate('Attachments') }}</label>
                                                <div class="input-group">
                                                    <input type="file" name="attachments[]"
                                                        class="form-control form-control-md">
                                                    <button id="addAttachment" class="btn btn-outline-secondary"
                                                        type="button">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-md">{{ translate('Send') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="card mb-3">
                <div class="card-header">
                    {{ translate('User details') }}
                </div>
                <div class="card-body p-4">
                    <div class="text-center">
                        @php
                            $ticketUser = $ticket->user;
                        @endphp
                        <a href="{{ route('admin.members.users.edit', $ticketUser->id) }}">
                            <div class="mb-3">
                                <img src="{{ $ticketUser->getAvatar() }}" alt="{{ $ticketUser->getName() }}"
                                    class="rounded-3" width="80px" height="80px">
                            </div>
                            <h5 class="text-dark">{{ $ticketUser->getName() }}</h5>
                            <p class="mb-0 text-muted">{{ demo($ticketUser->email) }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card p-2">
                <div class="card-body p-4 py-3">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item py-3 px-0">
                            <div class="row align-items-center g-3">
                                <div class="col">
                                    <strong>{{ translate('Ticket ID') }}</strong>
                                </div>
                                <div class="col-auto">
                                    <span>#{{ $ticket->id }}</span>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item py-3 px-0">
                            <div class="row align-items-center g-3">
                                <div class="col">
                                    <strong>{{ translate('Category') }}</strong>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('admin.tickets.categories.edit', $ticket->category->id) }}"
                                        class="text-dark">
                                        <i class="fa-solid fa-tag me-2"></i>
                                        {{ $ticket->category->name }}
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
                                    @if ($ticket->isOpened())
                                        <span class="badge bg-green">
                                            {{ $ticket->getStatusName() }}
                                        </span>
                                    @else
                                        <span class="badge bg-red">
                                            {{ $ticket->getStatusName() }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item py-3 px-0">
                            <div class="row align-items-center g-3">
                                <div class="col">
                                    <strong>{{ translate('Created Date') }}</strong>
                                </div>
                                <div class="col-auto">
                                    <span>{{ dateFormat($ticket->created_at) }}</span>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item py-3 px-0">
                            <div class="row align-items-center g-3">
                                <div class="col">
                                    <strong>{{ translate('Last Activity') }}</strong>
                                </div>
                                <div class="col-auto">
                                    <span>{{ dateFormat($ticket->updated_at) }}</span>
                                </div>
                            </div>
                        </li>
                        @if ($ticket->isOpened())
                            <li class="list-group-item py-3 px-0">
                                <form action="{{ route('admin.tickets.close', $ticket->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-danger btn-lg w-100 action-confirm">
                                        <i class="fa-regular fa-circle-xmark me-1"></i>
                                        {{ translate('Close ticket') }}
                                    </button>
                                </form>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
