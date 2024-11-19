@push('scripts_libs')
    @php
        $translation = null;
        $language = getLocale();
        $translationFile = "vendor/libs/ckeditor/translations/{$language}.js";
        if (file_exists(public_path($translationFile))) {
            $translation = $translationFile;
        }
    @endphp
@if ($translation)
<script src="{{ asset($translationFile) }}"></script>
@endif
<script src="{{ asset('vendor/libs/ckeditor/plugins/uploadAdapterPlugin.js') }}"></script>
<script src="{{ asset('vendor/libs/ckeditor/ckeditor.js') }}"></script>
@endpush
