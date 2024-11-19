<div class="drop-down user-menu ms-3 me-0" data-dropdown data-dropdown-position="top">
    <div class="drop-down-btn">
        <img src="{{ authUser()->getAvatar() }}" class="user-img" alt="{{ authUser()->getName() }}">
        <span class="mx-2 d-none d-lg-inline-block">{{ authUser()->getName() }}</span>
        <i class="bi bi-chevron-down d-none d-lg-inline-block"></i>
    </div>
    <div class="drop-down-menu w-auto">
        @if (authUser()->isUser() && authUser()->isDataCompleted())
            <div class="user-menu-balance d-flex align-items-center p-3 border-bottom text-nowrap gap-2 small">
                <a href="{{ route('user.settings.index') }}">
                    <img src="{{ authUser()->getAvatar() }}" class="user-img user-img-md flex-shrink-0"
                        alt="{{ authUser()->getName() }}">
                </a>
                <div class="user-menu-balance-content">
                    <a href="{{ route('user.settings.index') }}" class="text-dark">
                        <h6 class="user-menu-balance-name mb-1 fw-light">
                            {{ authUser()->getName() }}
                        </h6>
                    </a>
                    <a href="{{ route('user.wallet.index') }}">
                        <span
                            class="user-menu-balance-amount text-primary fw-medium">{{ getAmount(authUser()->balance) }}</span>
                    </a>
                </div>
            </div>
            <a href="{{ route('user.wallet.index') }}" class="drop-down-item">
                <i class="bi bi-wallet2"></i>{{ translate('My Wallet') }}
            </a>
            <a href="{{ route('user.purchases.index') }}" class="drop-down-item">
                <i class="bi bi-bag"></i>{{ translate('Purchases') }}
            </a>
            <a href="{{ route('favorites') }}" class="drop-down-item">
                <i class="bi bi-heart"></i>{{ translate('Favorites') }}
            </a>
            <a href="{{ route('user.transactions.index') }}" class="drop-down-item">
                <i class="bi bi-receipt"></i>{{ translate('Transactions') }}
            </a>
            @if (@$settings->actions->refunds)
                <a href="{{ route('user.refunds.index') }}" class="drop-down-item">
                    <i class="bi bi-arrow-clockwise"></i>{{ translate('Refunds') }}
                </a>
            @endif
            @if (@$settings->actions->tickets)
                <a href="{{ route('user.tickets.index') }}" class="drop-down-item">
                    <i class="bi bi-inbox"></i>{{ translate('Tickets') }}
                </a>
            @endif
            <a href="{{ route('user.settings.index') }}" class="drop-down-item">
                <i class="bi bi-gear"></i>{{ translate('Settings') }}
            </a>
        @endif
        @if (authUser()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="drop-down-item">
                <i class="bi bi-layout-text-window-reverse"></i>{{ translate('Admin Panel') }}
            </a>
        @endif
        <a href="#" class="drop-down-item text-danger"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-left"></i>{{ translate('Logout') }}
        </a>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
</div>
