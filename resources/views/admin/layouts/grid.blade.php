<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ getDirection() }}">

<head>
    @include('admin.includes.head')
    @include('admin.includes.styles')
</head>

<body>
    @include('admin.includes.sidebar')
    <div class="vironeer-page-content">
        @include('admin.includes.navbar')
        <div class="container @yield('container')">
            <div class="vironeer-page-body px-1 px-sm-2 px-xxl-0">
                <div class="py-4 g-3">
                    <div class="row g-3 align-items-center">
                        <div class="col-12 col-lg">
                            @include('admin.partials.breadcrumb')
                        </div>
                        @hasSection('back')
                            <div class="col-auto">
                                <a href="@yield('back')" class="btn btn-secondary btn-md px-4"><i
                                        class="fas fa-arrow-left fa-rtl me-2"></i>{{ translate('Back') }}</a>
                            </div>
                        @endif
                        @hasSection('create')
                            <div class="col-auto">
                                <a href="@yield('create')" class="btn btn-primary btn-md"><i
                                        class="fa fa-plus"></i></a>
                            </div>
                        @endif
                        @hasSection('item_view')
                            <div class="col-auto">
                                <a href="{{ $item->getLink() }}" target="_blank"
                                    class="btn btn-outline-primary btn-md px-4">
                                    <i class="fa-solid fa-up-right-from-square me-1"></i>
                                    {{ translate('View Item') }}
                                </a>
                            </div>
                        @endif
                        @hasSection('add_modal')
                            <div class="col-auto">
                                <button type="button" class="btn btn-primary btn-md px-4" data-bs-toggle="modal"
                                    data-bs-target="#addModal">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        @endif
                        @hasSection('upload_modal')
                            <div class="col-auto">
                                <button type="button" class="btn btn-primary btn-md px-4" data-bs-toggle="modal"
                                    data-bs-target="#uploadModal">
                                    <i class="fa fa-upload me-2"></i>@yield('upload_modal')
                                </button>
                            </div>
                        @endif
                        @if (request()->routeIs('admin.items.index'))
                            <div class="col-auto">
                                <button type="button" class="btn btn-primary btn-md px-4" data-bs-toggle="modal"
                                    data-bs-target="#addItemModel">
                                    <i class="fa-regular fa-plus me-1"></i>
                                    {{ translate('New Item') }}
                                </button>
                            </div>
                        @endif
                        @if (request()->routeIs('admin.notifications.index'))
                            @if ($notifications->count() > 0)
                                <div class="col-12 col-lg-auto">
                                    <form action="{{ route('admin.notifications.read.all') }}" method="POST">
                                        @csrf
                                        <button class="action-confirm btn btn-outline-success btn-md px-4">
                                            <i class="fa-regular fa-bookmark me-2"></i>
                                            {{ translate('Make All as Read') }}
                                        </button>
                                    </form>
                                </div>
                                <div class="col-12 col-lg-auto">
                                    <form action="{{ route('admin.notifications.delete.read') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="action-confirm btn btn-outline-danger btn-md px-4">
                                            <i class="fa-regular fa-trash-can me-2"></i>
                                            {{ translate('Delete All Read') }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endif
                        @if (request()->routeIs('admin.newsletter.subscribers.index'))
                            <div class="col-auto">
                                <button class="btn btn-outline-primary btn-md px-4" data-bs-toggle="modal"
                                    data-bs-target="#sendMailModal"><i
                                        class="far fa-paper-plane me-2"></i>{{ translate('Send Mail') }}</button>
                            </div>
                            <div class="col-auto">
                                <form action="{{ route('admin.newsletter.subscribers.export') }}" method="POST">
                                    @csrf
                                    <button class="btn btn-success btn-md px-4 action-confirm"><i
                                            class="fa-solid fa-file-export me-2"></i>{{ translate('Export All') }}</button>
                                </form>
                            </div>
                        @endif
                        @if (request()->routeIs('admin.system.info.index'))
                            <div class="col-auto">
                                <a href="{{ config('system.author.profile') }}" target="_blank"
                                    class="btn btn-secondary btn-md px-4"><i
                                        class="far fa-question-circle me-2"></i>{{ translate('Get Help') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row g-3 g-xl-3">
                    <div class="col">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        @include('admin.includes.footer')
    </div>
    @include('admin.includes.scripts')
</body>

</html>
