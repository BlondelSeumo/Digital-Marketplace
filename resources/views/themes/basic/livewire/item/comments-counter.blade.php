<a href="{{ $item->getCommentsLink() }}" class="nav-link {{ $isActive ? 'active' : '' }}">
    <i
        class="fa-regular fa-comments me-2"></i>{{ translate('Comments (:count)', ['count' => numberFormat($item->total_comments)]) }}
</a>
