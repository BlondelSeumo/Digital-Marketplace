@bootstrap
<link rel="stylesheet" href="{{ asset('vendor/libs/fontawesome/fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/bootstrap-icons/bootstrap-icons.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/libs/simplebar/simplebar.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/libs/datatable/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/counter-cards.min.css') }}">
@stack('styles_libs')
<link rel="stylesheet" href="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/toastr/css/vironeer-toastr.min.css') }}">
@adminColors
<link rel="stylesheet" href="{{ asset_with_version('vendor/admin/css/app.css') }}">
@if (getDirection() == 'rtl')
<link rel="stylesheet" href="{{ asset_with_version('vendor/admin/css/app.rtl.css') }}">
@endif
@stack('styles')
@adminCustomStyle
