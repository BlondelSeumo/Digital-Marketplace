<header class="vironeer-page-header">
    <div class="vironeer-sibebar-icon me-auto">
        <i class="fa fa-bars fa-lg"></i>
    </div>
    <div class="row row-cols-auto g-3">
        <div class="col">
            <a href="{{ route('admin.license-verification') }}" class="btn btn-outline-success rounded-1">
                <i class="fa-solid fa-key"></i>
                <span class="d-none d-lg-inline ms-1">{{ translate('License Verification') }}</span>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('admin.system.info.cache') }}" class="btn btn-outline-danger rounded-1 action-confirm">
                <i class="fa-solid fa-broom"></i>
                <span class="d-none d-lg-inline ms-1">{{ translate('Clear Cache') }}</span>
            </a>
        </div>
        <div class="col">
            <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-dark rounded-1">
                <i class="fa-solid fa-eye"></i>
                <span class="d-none d-lg-inline ms-1">{{ translate('Preview') }}</span>
            </a>
        </div>
    </div>
    <div class="vironeer-notifications ms-2" data-dropdown-v2>
        <div class="vironeer-notifications-title">
            <i class="far fa-bell"></i>
            <div class="counter">{{ $navbarNotifications['unread'] > 9 ? '9+' : $navbarNotifications['unread'] }}</div>
        </div>
        <div class="vironeer-notifications-menu">
            <div class="vironeer-notifications-header">
                <p class="vironeer-notifications-header-title mb-0">
                    {{ translate('Notifications') }} ({{ $navbarNotifications['unread'] }})</p>
                @if ($navbarNotifications['unread'] > 0)
                    <div class="ms-auto">
                        <form action="{{ route('admin.notifications.read.all') }}" method="POST">
                            @csrf
                            <button
                                class="vironeer-notifications-read-button action-confirm">{{ translate('Mark All as Read') }}</button>
                        </form>
                    </div>
                @endif
            </div>
            <div class="vironeer-notifications-body">
                @forelse ($navbarNotifications['list'] as $navbarNotification)
                    @if ($navbarNotification->link)
                        <a class="vironeer-notification {{ !$navbarNotification->status ? 'unread' : '' }}"
                            href="{{ route('admin.notifications.view', $navbarNotification->id) }}"
                            {{ $navbarNotification->isLinkTypeExternal() ? 'target=_blank' : '' }}>
                            <div class="vironeer-notification-image">
                                <img src="{{ $navbarNotification->image }}" alt="{{ $navbarNotification->title }}">
                            </div>
                            <div class="vironeer-notification-info">
                                <p
                                    class="vironeer-notification-title mb-0 d-flex justify-content-between align-items-center">
                                    <span>{{ $navbarNotification->title }}</span>
                                    @if (!$navbarNotification->status)
                                        <span class="unread flashit"><i class="fas fa-circle"></i></span>
                                    @endif
                                </p>
                                <p class="vironeer-notification-text mb-0">
                                    {{ $navbarNotification->created_at->diffforhumans() }}
                                </p>
                            </div>
                        </a>
                    @else
                        <div class="vironeer-notification {{ !$navbarNotification->status ? 'unread' : '' }}">
                            <div class="vironeer-notification-image">
                                <img src="{{ $navbarNotification->image }}" alt="{{ $navbarNotification->title }}">
                            </div>
                            <div class="vironeer-notification-info">
                                <p
                                    class="vironeer-notification-title mb-0 d-flex justify-content-between align-items-center">
                                    <span>{{ $navbarNotification->title }}</span>
                                    @if (!$navbarNotification->status)
                                        <span class="unread flashit"><i class="fas fa-circle"></i></span>
                                    @endif
                                </p>
                                <p class="vironeer-notification-text mb-0">
                                    {{ $navbarNotification->created_at->diffforhumans() }}
                                </p>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="empty">
                        <small class="text-muted mb-0">{{ translate('No notifications found') }}</small>
                    </div>
                @endforelse
            </div>
            <a class="vironeer-notifications-footer" href="{{ route('admin.notifications.index') }}">
                {{ translate('View All') }}
            </a>
        </div>
    </div>
    <div class="vironeer-user-menu">
        <div class="vironeer-user" id="dropdownMenuButton" data-bs-toggle="dropdown">
            <div class="vironeer-user-avatar">
                <img src="{{ authUser()->getAvatar() }}" alt="{{ authUser()->getName() }}" />
            </div>
            <div class="vironeer-user-info d-none d-md-block">
                <p class="vironeer-user-title mb-0">{{ authUser()->getName() }}</p>
                <p class="vironeer-user-text mb-0">{{ authUser()->email }}</p>
            </div>
        </div>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li>
                <a class="dropdown-item" href="{{ route('admin.account.index') }}">
                    <i class="fa-solid fa-cog me-1"></i>
                    {{ translate('Settings') }}
                </a>
            </li>
            <li>
                <a class="dropdown-item text-danger" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    {{ translate('Logout') }}
                </a>
            </li>
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
        </form>
    </div>
</header>
