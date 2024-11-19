<div class="col-lg-3">
    <div class="card mb-4">
        <ul class="sidebar-list-group list-group list-group-flush">
            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center 
            {{ request()->routeIs('admin.members.users.edit') ? 'active' : '' }}"
                href="{{ route('admin.members.users.edit', $user->id) }}">
                <span><i class="fa fa-edit me-2"></i>{{ translate('Account details') }}</span>
                <i class="fa-solid fa-chevron-right fa-rtl"></i>
            </a>
            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center
             {{ request()->routeIs('admin.members.users.wallet.index') ? 'active' : '' }}"
                href="{{ route('admin.members.users.wallet.index', $user->id) }}">
                <span><i class="fa-solid fa-wallet me-2"></i>{{ translate('Wallet') }}</span>
                <i class="fa-solid fa-chevron-right fa-rtl"></i>
            </a>
            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center 
            {{ request()->routeIs('admin.members.users.password.index') ? 'active' : '' }}"
                href="{{ route('admin.members.users.password.index', $user->id) }}">
                <span><i class="fa fa-lock me-2"></i>{{ translate('Password') }}</span>
                <i class="fa-solid fa-chevron-right fa-rtl"></i>
            </a>
            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center 
            {{ request()->routeIs('admin.members.users.actions.index') ? 'active' : '' }}"
                href="{{ route('admin.members.users.actions.index', $user->id) }}">
                <span><i class="fa-solid fa-gears me-2"></i>{{ translate('Actions') }}</span>
                <i class="fa-solid fa-chevron-right fa-rtl"></i>
            </a>
            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center 
            {{ request()->routeIs('admin.members.users.login-logs') ? 'active' : '' }}"
                href="{{ route('admin.members.users.login-logs', $user->id) }}">
                <span><i class="fa fa-key me-2"></i>{{ translate('Login Logs') }}</span>
                <i class="fa-solid fa-chevron-right fa-rtl"></i>
            </a>
        </ul>
    </div>
</div>
