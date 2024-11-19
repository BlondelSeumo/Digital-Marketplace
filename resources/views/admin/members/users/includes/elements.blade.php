<div class="row row-cols-1 row-cols-lg-3 row-cols-xxl-3 g-3 mb-4">
    <div class="col">
        <div class="vironeer-counter-card bg-c-1">
            <div class="vironeer-counter-card-icon">
                <i class="fa-solid fa-dollar-sign"></i>
            </div>
            <div class="vironeer-counter-card-meta">
                <p class="vironeer-counter-card-title">{{ translate('Balance') }}</p>
                <p class="vironeer-counter-card-number">{{ getAmount($user->balance) }}</p>
            </div>
            <div class="ms-auto">
                <a href="{{ route('admin.records.statements.index', ['user' => $user->id]) }}"
                    class="btn btn-outline-light">{{ translate('Statements') }}</a>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="vironeer-counter-card bg-c-2">
            <div class="vironeer-counter-card-icon">
                <i class="fa-solid fa-cart-plus"></i>
            </div>
            <div class="vironeer-counter-card-meta">
                <p class="vironeer-counter-card-title">{{ translate('Purchases') }}</p>
                <p class="vironeer-counter-card-number">{{ number_format($user->purchases_count) }}</p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="vironeer-counter-card bg-c-6">
            <div class="vironeer-counter-card-icon">
                <i class="fa-solid fa-cash-register"></i>
            </div>
            <div class="vironeer-counter-card-meta">
                <p class="vironeer-counter-card-title">{{ translate('Total Spend') }}</p>
                <p class="vironeer-counter-card-number">{{ getAmount($counters['total_transactions_amount']) }}</p>
            </div>
        </div>
    </div>
</div>
<div class="card mb-4">
    <div class="card-header">{{ translate('Quick Actions') }}</div>
    <div class="card-body p-4">
        <div class="row row-cols-1 row-cols-lg-4 g-3">
            @if (licenseType(2) && @$settings->premium->status && $user->isSubscribed())
                <div class="col">
                    <a class="btn btn-warning btn-lg w-100"
                        href="{{ route('admin.premium.subscriptions.show', $user->subscription->id) }}" target="_blank">
                        <i class="fa-solid fa-crown me-1"></i>
                        {{ translate('View Subscription') }}
                    </a>
                </div>
            @endif
            <div class="col">
                <a class="btn btn-outline-dark btn-lg w-100"
                    href="{{ route('admin.kyc.kyc-verifications.index', ['user' => $user->id]) }}" target="_blank">
                    <i class="fa-solid fa-address-card me-1"></i>
                    {{ translate('KYC Verifications') }}
                </a>
            </div>
            @if (@$settings->actions->tickets)
                <div class="col">
                    <a class="btn btn-outline-dark btn-lg w-100"
                        href="{{ route('admin.tickets.index', ['user' => $user->id]) }}" target="_blank">
                        <i class="fa-solid fa-inbox me-1"></i>
                        {{ translate('Tickets') }}
                    </a>
                </div>
                <div class="col">
                    <a class="btn btn-outline-dark btn-lg w-100"
                        href="{{ route('admin.tickets.create', ['user' => $user->id]) }}" target="_blank">
                        <i class="fa-solid fa-plus me-1"></i>
                        {{ translate('Open a Ticket') }}
                    </a>
                </div>
            @endif
            <div class="col">
                <a class="btn btn-outline-dark btn-lg w-100"
                    href="{{ route('admin.records.purchases.index', ['user' => $user->id]) }}" target="_blank">
                    <i class="fa-solid fa-basket-shopping me-1"></i>
                    {{ translate('Purchases') }}
                </a>
            </div>
            <div class="col">
                <a class="btn btn-outline-dark btn-lg w-100"
                    href="{{ route('admin.transactions.index', ['user' => $user->id]) }}" target="_blank">
                    <i class="fa-solid fa-receipt me-1"></i>
                    {{ translate('Transactions') }}
                </a>
            </div>
            @if (@$settings->actions->refunds)
                <div class="col">
                    <a class="btn btn-outline-dark btn-lg w-100"
                        href="{{ route('admin.refunds.index', ['user' => $user->id]) }}" target="_blank">
                        <i class="fa-solid fa-share me-1"></i>
                        {{ translate('Refunds') }}
                    </a>
                </div>
            @endif
            <div class="col">
                <a class="btn btn-outline-dark btn-lg w-100"
                    href="{{ route('admin.records.statements.index', ['user' => $user->id]) }}" target="_blank">
                    <i class="fa-solid fa-file-lines me-1"></i>
                    {{ translate('Statements') }}
                </a>
            </div>
        </div>
    </div>
</div>
