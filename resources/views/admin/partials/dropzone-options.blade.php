@php
    $directFileToBig = translate('file is too big max file size: {{maxFilesize}}MiB.');
    $dictResponseError = translate('Server responded with {{statusCode}} code.');
@endphp
<script>
    "use strict";
    const dropzoneOptions = {
        dictDefaultMessage: "{{ translate('Drop files here to upload') }}",
        dictFallbackMessage: "{{ translate('Your browser does not support drag and drop file uploads.') }}",
        dictFallbackText: "{{ translate('Please use the fallback form below to upload your files like in the olden days.') }}",
        dictFileTooBig: "{{ $directFileToBig }}",
        dictInvalidFileType: "{{ translate('You cannot upload files of this type.') }}",
        dictResponseError: "{{ $dictResponseError }}",
        dictCancelUpload: "{{ translate('Cancel upload') }}",
        dictCancelUploadConfirmation: "{{ translate('Are you sure you want to cancel this upload?') }}",
        dictRemoveFile: "{{ translate('Remove file') }}",
        dictMaxFilesExceeded: "{{ translate('You can not upload any more files.') }}",
    };
</script>