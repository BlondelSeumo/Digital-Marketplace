<form action="{{ $url ?? url()->current() }}" method="GET">
    <div class="header-search {{ $search_classes ?? '' }}">
        <input type="text" name="search" class="form-control" placeholder="{{ $placeholder ?? translate('Search...') }}"
            required value="{{ request('search') }}" />
        <button class="btn btn-primary fw-medium">
            <i class="fa fa-search me-1"></i>{{ translate('Search') }}
        </button>
    </div>
</form>
