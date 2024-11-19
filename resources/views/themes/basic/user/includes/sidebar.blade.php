<aside class="dashboard-sidebar">
    <div class="overlay"></div>
    <div class="dashboard-sidebar-container">
        <div class="dashboard-sidebar-header">
            <a href="{{ route('home') }}" class="logo logo-sm">
                <img src="{{ asset($themeSettings->general->logo_dark) }}" alt="{{ @$settings->general->site_name }}" />
            </a>
        </div>
        <div class="dashboard-sidebar-body" data-simplebar>
            <div class="dashboard-sidebar-content">
                <div class="dashboard-sidebar-inner">
                    <div class="page-user-info text-center mb-4">
                        <a href="{{ route('user.settings.index') }}" class="user-avatar user-avatar-xl mb-3 me-0">
                            <img class="rounded-pill" src="{{ authUser()->getAvatar() }}"
                                alt="{{ authUser()->getName() }}" />
                        </a>
                        <h5 class="mb-1">
                            <a href="{{ route('user.settings.index') }}">
                                <span class="small text-dark">{{ authUser()->getName() }}</span>
                            </a>
                        </h5>
                        <p class="text-muted fw-light small mb-0">{{ authUser()->email }}</p>
                    </div>
                    <div class="dashboard-balance border mb-4">
                        <div class="dashboard-balance-info">
                            <p class="dashboard-balance-title mb-2">{{ translate('Balance') }}</p>
                            <p class="dashboard-balance-number">{{ getAmount(authUser()->balance) }}</p>
                        </div>
                        <div class="dashboard-balance-icon">
                            <a href="{{ route('user.wallet.index') }}"><i class="fa fa-wallet"></i></a>
                        </div>
                    </div>
                    <div class="dashboard-sidebar-links">
                        <div
                            class="dashboard-sidebar-link {{ request()->segment(2) == 'purchases' ? 'current' : '' }}">
                            <a href="{{ route('user.purchases.index') }}" class="dashboard-sidebar-link-title">
                                <i class="bi bi-bag"></i>
                                {{ translate('Purchases') }}
                            </a>
                        </div>
                        <div
                            class="dashboard-sidebar-link {{ request()->segment(2) == 'transactions' ? 'current' : '' }}">
                            <a href="{{ route('user.transactions.index') }}" class="dashboard-sidebar-link-title">
                                <i class="bi bi-receipt"></i>
                                {{ translate('Transactions') }}
                            </a>
                        </div>
                        @if (@$settings->actions->refunds)
                            <div
                                class="dashboard-sidebar-link {{ request()->segment(2) == 'refunds' ? 'current' : '' }}">
                                <a href="{{ route('user.refunds.index') }}" class="dashboard-sidebar-link-title ">
                                    <i class="bi bi-arrow-clockwise"></i>
                                    {{ translate('Refunds') }}
                                </a>
                            </div>
                        @endif
                        @if (@$settings->actions->tickets)
                            <div
                                class="dashboard-sidebar-link {{ request()->segment(2) == 'tickets' ? 'current' : '' }}">
                                <a href="{{ route('user.tickets.index') }}" class="dashboard-sidebar-link-title">
                                    <i class="bi bi-inbox"></i>
                                    {{ translate('Tickets') }}
                                </a>
                            </div>
                        @endif
                        @if (@$settings->kyc->status && !authUser()->isKycVerified())
                            <div class="dashboard-sidebar-link {{ request()->segment(2) == 'kyc' ? 'current' : '' }}">
                                <a href="{{ route('user.kyc.index') }}" class="dashboard-sidebar-link-title">
                                    <i class="bi bi-fingerprint"></i>
                                    {{ translate('KYC Verification') }}
                                </a>
                            </div>
                        @endif
                        <div class="dashboard-sidebar-link {{ request()->segment(2) == 'settings' ? 'current' : '' }}">
                            <a href="{{ route('user.settings.index') }}" class="dashboard-sidebar-link-title">
                                <i class="bi bi-gear"></i>
                                {{ translate('Settings') }}
                            </a>
                        </div>
                        <div class="dashboard-sidebar-link">
                            <a href="#" class="dashboard-sidebar-link-title text-danger"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-left"></i>
                                {{ translate('Logout') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>
