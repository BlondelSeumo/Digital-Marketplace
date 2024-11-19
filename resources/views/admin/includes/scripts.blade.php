@include('admin.includes.config')
@stack('top_scripts')
<script src="{{ asset('vendor/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/libs/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/libs/simplebar/simplebar.min.js') }}"></script>
@stack('scripts_libs')
<script src="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.js') }}"></script>
<script src="{{ asset('vendor/libs/jquery/jquery.priceformat.min.js') }}"></script>
<script src="{{ asset('vendor/libs/datatable/datatables.jq.min.js') }}"></script>
<script src="{{ asset('vendor/libs/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('vendor/libs/vironeer/toastr/js/vironeer-toastr.min.js') }}"></script>
<script src="{{ asset_with_version('vendor/admin/js/app.js') }}"></script>
@toastrRender
@stack('scripts')
