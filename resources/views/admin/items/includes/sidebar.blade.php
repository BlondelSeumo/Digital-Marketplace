<div class="card shadow-sm">
    <div class="card-header py-3 px-4">
        <h5 class="mb-0">{{ translate('Item details') }}</h5>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item py-3 px-4">
            <div class="row align-items-center g-3">
                <div class="col">
                    <strong>{{ translate('ID') }}</strong>
                </div>
                <div class="col-auto">
                    <span>#{{ $item->id }}</span>
                </div>
            </div>
        </li>
        <li class="list-group-item py-3 px-4">
            <div class="row align-items-center g-3">
                <div class="col">
                    <strong>{{ translate('Thumbnail') }}</strong>
                </div>
                <div class="col-auto">
                    <img src="{{ $item->getThumbnailLink() }}" alt="{{ $item->name }}" width="40px" height="40px">
                </div>
            </div>
        </li>
        <li class="list-group-item py-3 px-4">
            <div class="row align-items-center g-3">
                <div class="col">
                    <strong>{{ translate('Name') }}</strong>
                </div>
                <div class="col-auto">
                    <span>{{ $item->name }}</span>
                </div>
            </div>
        </li>
        <li class="list-group-item py-3 px-4">
            <div class="row align-items-center g-3">
                <div class="col">
                    <strong>{{ translate('Category') }}</strong>
                </div>
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center m-0">
                            <li class="breadcrumb-item fs-6">
                                <a href="{{ route('categories.category', $item->category->slug) }}"
                                    target="_blank">{{ $item->category->name }}</a>
                            </li>
                            @if ($item->subCategory)
                                <li class="breadcrumb-item fs-6">
                                    <a href="{{ route('categories.sub-category', [$item->category->slug, $item->subCategory->slug]) }}"
                                        target="_blank">{{ $item->subCategory->name }}</a>
                                </li>
                            @endif
                        </ol>
                    </nav>
                </div>
            </div>
        </li>
        @if ($item->last_update_at)
            <li class="list-group-item py-3 px-4">
                <div class="row align-items-center g-3">
                    <div class="col">
                        <strong>{{ translate('Last Update') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span>{{ dateFormat($item->last_update_at) }}</span>
                    </div>
                </div>
            </li>
        @endif
        <li class="list-group-item py-3 px-4">
            <div class="row align-items-center g-3">
                <div class="col">
                    <strong>{{ translate('Published Date') }}</strong>
                </div>
                <div class="col-auto">
                    <span>{{ dateFormat($item->created_at) }}</span>
                </div>
            </div>
        </li>
        <li class="list-group-item py-3 px-4">
            <div class="row row-cols-1 g-3">
                <div class="col">
                    @if ($item->isMainFileSourceExternal())
                        <a href="{{ $item->main_file }}" target="_blank" class="btn btn-primary btn-lg w-100">
                            <i class="fa-solid fa-download me-1"></i>
                            {{ translate('Download') }}
                        </a>
                    @else
                        <a href="{{ route('admin.items.download', $item->id) }}" class="btn btn-primary btn-lg w-100">
                            <i class="fa-solid fa-download me-1"></i>
                            {{ translate('Download') }}
                        </a>
                    @endif
                </div>
                @if (!$item->isFeatured())
                    <form action="{{ route('admin.items.featured', $item->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-success btn-lg w-100 action-confirm">
                            <i class="fa-solid fa-certificate me-1"></i>
                            {{ translate('Make Featured') }}
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.items.featured.remove', $item->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-danger btn-lg w-100 action-confirm">
                            <i class="fa-solid fa-certificate me-1"></i>
                            {{ translate('Remove Featured') }}
                        </button>
                    </form>
                @endif
                @if (licenseType(2) && @$settings->premium->status && !$item->isFree())
                    @if (!$item->isPremium())
                        <form action="{{ route('admin.items.premium', $item->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-warning btn-lg w-100 action-confirm">
                                <i class="fa-solid fa-crown me-1"></i>
                                {{ translate('Add to premium') }}
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.items.premium.remove', $item->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-danger btn-lg w-100 action-confirm">
                                <i class="fa-solid fa-crown me-1"></i>
                                {{ translate('Remove from premium') }}
                            </button>
                        </form>
                    @endif
                @endif
                <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-lg w-100 action-confirm">
                        <i class="fa-solid fa-trash-can me-1"></i>
                        {{ translate('Delete') }}
                    </button>
                </form>
            </div>
        </li>
    </ul>
</div>
