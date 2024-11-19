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
                                <a href="@yield('create')" class="btn btn-dark btn-md px-4"><i
                                        class="fa fa-plus"></i></a>
                            </div>
                        @endif
                        <div class="col-auto">
                            <button form="vironeer-submited-form"
                                class="btn btn-primary btn-md px-4">{{ translate('Save') }}</button>
                        </div>
                    </div>
                </div>
                <div class="vironeer-form-page">
                    @yield('content')
                </div>
            </div>
        </div>
        @include('admin.includes.footer')
    </div>
    @include('admin.includes.scripts')
</body>

</html>
