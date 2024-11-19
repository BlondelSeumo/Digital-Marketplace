<div class="col-lg-3">
    <div class="card">
        <ul class="sidebar-list-group list-group list-group-flush">
            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ request()->routeIs('admin.members.admins.edit') ? 'active' : '' }}"
                href="{{ route('admin.members.admins.edit', $admin->id) }}">
                <span><i class="fa fa-edit me-2"></i>{{ translate('Account details') }}</span>
                <i class="fa-solid fa-chevron-right fa-rtl"></i>
            </a>
            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ request()->routeIs('admin.members.admins.actions.index') ? 'active' : '' }}"
                href="{{ route('admin.members.admins.actions.index', $admin->id) }}">
                <span><i class="fa-solid fa-gears me-2"></i>{{ translate('Actions') }}</span>
                <i class="fa-solid fa-chevron-right fa-rtl"></i>
            </a>
            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ request()->routeIs('admin.members.admins.password.index') ? 'active' : '' }}"
                href="{{ route('admin.members.admins.password.index', $admin->id) }}">
                <span><i class="fa fa-lock me-2"></i>{{ translate('Password') }}</span>
                <i class="fa-solid fa-chevron-right fa-rtl"></i>
            </a>
        </ul>
    </div>
</div>
