@extends('admin.layouts.grid')
@section('title', translate('Notifications'))
@section('container', 'container-max-lg')
@section('content')
    <div class="notifications">
        @forelse ($notifications as $notification)
            @if ($notification->link)
                <a href="{{ route('admin.notifications.view', $notification->id) }}"
                    {{ $notification->isLinkTypeExternal() ? 'target=_blank' : '' }}
                    class="notification-item {{ !$notification->status ? 'unread' : '' }} d-flex justify-content-between align-items-center">
                    <div class="flex-shrink-0">
                        <img src="{{ $notification->image }}" alt="{{ $notification->title }}" class="notification-image">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="mb-1">{{ $notification->title }}</h5>
                        <p class="mb-0 text-muted">{{ $notification->created_at->diffforhumans() }}</p>
                    </div>
                    @if (!$notification->status)
                        <div class="flex-grow-2 ms-3">
                            <span class="icon text-danger flashit"><i class="fas fa-circle"></i></span>
                        </div>
                    @endif
                </a>
            @else
                <div
                    class="notification-item {{ !$notification->status ? 'unread' : '' }} d-flex justify-content-between align-items-center">
                    <div class="flex-shrink-0">
                        <img src="{{ $notification->image }}" alt="{{ $notification->title }}" class="notification-image">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="mb-1">{{ $notification->title }}</h5>
                        <p class="mb-0 text-muted">{{ $notification->created_at->diffforhumans() }}</p>
                    </div>
                    @if (!$notification->status)
                        <div class="flex-grow-2 ms-3">
                            <span class="icon text-danger flashit"><i class="fas fa-circle"></i></span>
                        </div>
                    @endif
                </div>
            @endif
        @empty
            <div class="card">
                <div class="card-body">
                    @include('admin.partials.empty', ['empty_classes' => 'empty-lg'])
                </div>
            </div>
        @endforelse
    </div>
    {{ $notifications->links() }}
@endsection
