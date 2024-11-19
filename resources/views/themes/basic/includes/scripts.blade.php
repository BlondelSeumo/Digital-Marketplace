<livewire:newsletter.popup />
<x-partials />
@stack('top_scripts')
<script src="{{ asset('vendor/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/libs/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/libs/vironeer/toastr/js/vironeer-toastr.min.js') }}"></script>
<script src="{{ asset('vendor/libs/wavesurfer/wavesurfer.min.js') }}"></script>
<script src="{{ asset('vendor/libs/plyr/plyr.min.js') }}"></script>
<livewire:scripts />
@stack('scripts_libs')
<script src="{{ theme_assets_with_version('assets/js/app.js') }}"></script>
@stack('scripts')
@toastrRender
{!! $themeSettings->extra_codes->footer_code !!}
