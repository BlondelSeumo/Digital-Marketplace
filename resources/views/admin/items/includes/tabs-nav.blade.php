<div class="dashboard-tabs-nav">
    <a href="{{ route('admin.items.edit', $item->id) }}"
        class="dashboard-tabs-nav-item {{ request()->routeIs('admin.items.edit') ? 'current' : '' }}">
        <i class="fa-regular fa-edit"></i>
        <span class="ms-1">{{ translate('Edit Details') }}</span>
    </a>
    @if (@$settings->item->changelogs_status)
        <a href="{{ route('admin.items.changelogs', $item->id) }}"
            class="dashboard-tabs-nav-item {{ request()->routeIs('admin.items.changelogs') ? 'current' : '' }}">
            <i class="fa-solid fa-rotate"></i>
            <span class="ms-1">{{ translate('ChangeLogs') }}</span>
        </a>
    @endif
    <a href="{{ route('admin.items.discount', $item->id) }}"
        class="dashboard-tabs-nav-item {{ request()->routeIs('admin.items.discount') ? 'current' : '' }}">
        <i class="fa-solid fa-tags"></i>
        <span class="ms-1">{{ translate('Discount') }}</span>
    </a>
    @if (@$settings->item->reviews_status)
        <a href="{{ route('admin.items.reviews', $item->id) }}"
            class="dashboard-tabs-nav-item {{ request()->routeIs('admin.items.reviews') ? 'current' : '' }}">
            <i class="fa-solid fa-star"></i>
            <span class="ms-1">{{ translate('Reviews') }} ({{ numberFormat($item->total_reviews) }})</span>
        </a>
    @endif
    @if (@$settings->item->comments_status)
        <a href="{{ route('admin.items.comments', $item->id) }}"
            class="dashboard-tabs-nav-item {{ request()->routeIs('admin.items.comments') ? 'current' : '' }}">
            <i class="fa-solid fa-comments"></i>
            <span class="ms-1">{{ translate('Comments') }} ({{ numberFormat($item->total_comments) }})</span>
        </a>
    @endif
    <a href="{{ route('admin.items.statistics', $item->id) }}"
        class="dashboard-tabs-nav-item {{ request()->routeIs('admin.items.statistics') ? 'current' : '' }}">
        <i class="fa-solid fa-chart-simple"></i>
        <span class="ms-1">{{ translate('Statistics') }}</span>
    </a>
</div>
