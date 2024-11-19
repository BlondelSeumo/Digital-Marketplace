(function($) {
    "use strict";

    let mainFileSource = $('#mainFileSource');
    mainFileSource.on('change', function() {
        let mainFileSource1 = $('.main-file-source-1'),
            mainFileSource2 = $('.main-file-source-2');
        if ($(this).val() == 'upload') {
            mainFileSource2.prop('disabled', true);
            mainFileSource2.addClass('d-none');
            mainFileSource1.prop('disabled', false);
            mainFileSource1.removeClass('d-none');
        } else {
            mainFileSource1.prop('disabled', true);
            mainFileSource1.addClass('d-none');
            mainFileSource2.prop('disabled', false);
            mainFileSource2.removeClass('d-none');
        }
    });

    let supportOption = $('.support-option');
    supportOption.on('click', function() {
        let supportInstructions = $('.support-instructions');
        if ($(this).val() == 1) {
            supportInstructions.removeClass('d-none');
        } else {
            supportInstructions.addClass('d-none');
        }
    });

    let freeItem = $('#freeItem');
    freeItem.on('change', function() {
        let priceOptions = $('#priceOptions');
        if ($(this).is(':checked')) {
            priceOptions.addClass('d-none');
        } else {
            priceOptions.removeClass('d-none');
        }
    });

    let purchaseOption = $('.purchase-option');
    purchaseOption.on('click', function() {
        let purchaseUrl = $('.purchase-url');
        if ($(this).val() == 2) {
            purchaseUrl.removeClass('d-none');
        } else {
            purchaseUrl.addClass('d-none');
        }
    });

    let uploadFilesBox = $('#upload-files-box');

    if (uploadFilesBox.length) {

        let previewNode = document.querySelector("#upload-previews");
        previewNode.id = "";
        let previewTemplate = previewNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        let imageTypes = ["image/jpeg", "image/jpg", "image/png"];

        Dropzone.autoDiscover = false;
        var dropzone = new Dropzone("#dropzone-wrapper", {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: uploadConfig.upload_url,
            method: "POST",
            paramName: 'file',
            filesizeBase: 1024,
            parallelUploads: 10,
            maxFiles: null,
            maxFilesize: null,
            acceptedFiles: null,
            autoProcessQueue: true,
            timeout: 0,
            chunking: true,
            forceChunking: true,
            chunkSize: 52428800,
            retryChunks: true,
            clickable: "[data-dz-click]",
            previewsContainer: "#dropzone",
            previewTemplate: previewTemplate,
        });

        function fileDrag() {
            let dropzoneBox = $(".dropzone-box");
            if (dropzone.files.length > 0) {
                dropzoneBox.addClass('active');
            } else {
                dropzoneBox.removeClass('active');
            }
        }

        function onAddFile(file) {
            if (this.files.length) {
                var _i, _len;
                for (_i = 0, _len = this.files.length; _i < _len - 1; _i++) {
                    if (this.files[_i].name === file.name) {
                        this.removeFile(file);
                        toastr.error(uploadConfig.translates.errors.file_duplicate);
                        return;
                    }
                }
            }

            if (file.size == 0) {
                this.removeFile(file);
                toastr.error(uploadConfig.translates.errors.file_empty);
                return;
            }

            fileDrag();

            let preview = $(file.previewElement),
                previewFileSize = preview.find('.dz-size');

            previewFileSize.html('(' + formatBytes(file.size) + ')');

            let previewFileExt = preview.find("[data-dz-extension]");
            if (imageTypes.includes(file.type)) {
                previewFileExt.remove();
            } else {
                let fileExtension = file.name.split('.').pop(),
                    previewFileThumbnail = preview.find("[data-dz-thumbnail]")
                previewFileThumbnail.remove();
                if (fileExtension != "") {
                    previewFileExt.attr('data-type', fileExtension.substring(0, 4));
                } else {
                    previewFileExt.attr('data-type', '?');
                }
            }

            preview.find('[data-dz-name]').text(sliceString(file.upload.filename));
        }

        function onRemovedfile() {
            fileDrag();
        }

        function onUploadProgress(file, progress) {
            let preview = $(file.previewElement);
            preview.find(".dz-upload-percentage").html(progress.toFixed(0) + "%");
        }

        function onFileError(file, message = null) {
            this.removeFile(file);
            toastr.error(message);
        }

        function onUploadComplete(file) {
            if (file.status == "success") {
                let preview = $(file.previewElement),
                    response = JSON.parse(file.xhr.response);
                if (response.type == 'success') {
                    this.removeFile(file);
                    let uploadedFiles = $('.uploaded-files'),
                        thumbnail = '<span class="vi vi-file" data-type="' + response.extension + '"></span>';
                    if (imageTypes.includes(response.mime_type)) {
                        thumbnail = '<img src="' + response.link + '" alt="' + response.name + '" />';
                    }
                    uploadedFiles.append('<div class="uploaded-file uploaded-file-' + response.id + '">' +
                        '<div class="uploaded-file-icon">' + thumbnail + '</div>' +
                        '<div class="uploaded-file-info">' +
                        '<h6 class="uploaded-file-name">' +
                        '<span class="success-mark"><i class="far fa-check-circle"></i></span>' + sliceString(response.name) +
                        '<small class="ms-1">(' + response.size + ')</small></h6>' +
                        '<p class="uploaded-file-time">' + response.time + '</p>' +
                        '</div>' +
                        '<button type="button" class="uploaded-file-remove" data-id="' + response.id + '" data-delete-link="' + response.delete_link + '">' +
                        '<i class="fa fa-trash-alt"></i>' +
                        '</button>' +
                        '</div>');
                    loadUploadedFiles();
                    removeUploadedFiles();
                } else {
                    preview.removeClass('dz-success');
                    preview.addClass('dz-error');
                    this.removeFile(file);
                    toastr.error(response.message);
                }
            }
        }

        function formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return "0 " + uploadConfig.translates.format_bytes[0];
            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = uploadConfig.translates.format_bytes;
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }

        function sliceString(string) {
            if (string.length > 40) {
                return string.slice(0, 20) + ".." + string.slice(string.length - 4);
            }
            return string;
        }

        dropzone.on("addedfile", onAddFile);
        dropzone.on("removedfile", onRemovedfile);
        dropzone.on('uploadprogress', onUploadProgress);
        dropzone.on('error', onFileError);
        dropzone.on('complete', onUploadComplete);

        function removeUploadedFiles() {
            let uploadedFileRemove = $('.uploaded-file-remove');
            uploadedFileRemove.on('click', function(e) {
                e.preventDefault();
                let uploadedFileId = $(this).data('id'),
                    uploadedFileDeleteLink = $(this).data('delete-link'),
                    uploadedFileRemoveBtn = $('button[data-id="' + uploadedFileId + '"]');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: uploadedFileDeleteLink,
                    type: "DELETE",
                    dataType: "JSON",
                    beforeSend: function() {
                        uploadedFileRemoveBtn.prop('disabled', true);
                        uploadedFileRemoveBtn.empty();
                        uploadedFileRemoveBtn.append('<div class="spinner-border spinner-border-sm me-2"></div>');
                    },
                    success: function(response) {
                        uploadedFileRemoveBtn.prop('false', true);
                        uploadedFileRemoveBtn.empty();
                        uploadedFileRemoveBtn.append('<i class="fa fa-trash-alt"></i>');
                        if ($.isEmptyObject(response.error)) {
                            $('.uploaded-file-' + uploadedFileId).remove();
                            loadUploadedFiles();
                            toastr.success(response.success);
                        } else {
                            toastr.error(response.error);
                        }
                    },
                    error: function(request, status, error) {
                        uploadedFileRemoveBtn.prop('false', true);
                        uploadedFileRemoveBtn.empty();
                        uploadedFileRemoveBtn.append('<i class="fa fa-trash-alt"></i>');
                        toastr.error(error);
                    }
                });
            });
        }

        removeUploadedFiles();

        function loadUploadedFiles() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: uploadConfig.load_files_route,
                type: "POST",
                dataType: "JSON",
                success: function(response) {
                    let itemFilesSelect = $('select.item-files-select');
                    itemFilesSelect.selectpicker('destroy');
                    if (itemFilesSelect.length > 0) {
                        itemFilesSelect.empty();
                        $.each(response, function(index, option) {
                            itemFilesSelect.append('<option value="' + index + '">' + option + '</option>');
                        });
                    } else {
                        itemFilesSelect.empty();
                    }
                    itemFilesSelect.selectpicker();
                    itemFilesSelect.addClass('selectpicker');
                },
                error: function(request, status, error) {
                    toastr.error(error);
                }
            });
        }
    }


    let regularLicensePrice = $('#regular-license-price'),
        regularLicensePurchasePrice = $('#regular-license-purchase-price'),
        extendedLicensePrice = $('#extended-license-price'),
        extendedLicensePurchasePrice = $('#extended-license-purchase-price'),
        regularLicensePercentage = $('#regular-license-percentage'),
        extendedLicensePercentage = $('#extended-license-percentage');

    function calculatePurchasePriceAfterDiscount(price, percentage) {
        let percentageTrim = (!isNaN(percentage) && percentage !== '' && percentage !== null) ? parseFloat(percentage) : 0,
            priceTrim = (!isNaN(price) && price !== '' && price !== null) ? parseFloat(price) : 0;

        let percentageAmount = (priceTrim * percentageTrim) / 100,
            purchasePrice = Math.ceil(priceTrim - percentageAmount);

        return purchasePrice.toFixed(0);
    }

    regularLicensePercentage.on('input', function() {
        let regularLicensePercentageValue = parseFloat(regularLicensePercentage.val());

        if (regularLicensePercentageValue > 90) {
            regularLicensePercentage.val(90);
        }

        let purchasePrice = calculatePurchasePriceAfterDiscount(regularLicensePrice.val(), regularLicensePercentage.val());
        regularLicensePurchasePrice.val(purchasePrice);
    });

    extendedLicensePercentage.on('input', function() {
        let extendedLicensePercentageValue = parseFloat(extendedLicensePercentage.val());

        if (extendedLicensePercentageValue > 90) {
            extendedLicensePercentage.val(90);
        }

        let purchasePrice = calculatePurchasePriceAfterDiscount(extendedLicensePrice.val(), extendedLicensePercentage.val());
        extendedLicensePurchasePrice.val(purchasePrice);
    });


})(jQuery);