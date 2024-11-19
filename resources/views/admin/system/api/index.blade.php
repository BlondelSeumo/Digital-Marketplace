@extends('admin.layouts.grid')
@section('section', translate('System'))
@section('title', translate('API'))
@section('container', 'container-max-xl')
@section('content')
    <div class="card mb-4">
        <div class="card-header p-3">{{ translate('API') }}</div>
        <div class="card-body p-4">
            <form action="{{ route('admin.system.api.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3 mb-2">
                    <div class="col-12">
                        <div class="col-lg-4">
                            <label class="form-label">{{ translate('Status') }}</label>
                            <input id="apiStatus" type="checkbox" name="api[status]" data-toggle="toggle" data-height="40px"
                                @checked(@$settings->api->status)>
                        </div>
                    </div>
                    <div class="api-box col-12 {{ !@$settings->api->status ? 'd-none' : '' }}">
                        <label class="form-label">{{ translate('API Key') }}</label>
                        <div class="input-group">
                            <input id="apiKeyInput" type="text" name="api[key]" class="form-control form-control-lg"
                                name="password" value="{{ demo(@$settings->api->key) }}" required readonly>
                            <button class="btn btn-secondary btn-copy" type="button"
                                data-clipboard-target="#apiKeyInput"><i class="far fa-clone"></i></button>
                            <button id="apiKeyBtn" class="btn btn-secondary" type="button"><i
                                    class="fa-solid fa-rotate me-2"></i>{{ translate('Generate') }}</button>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary btn-lg px-4">{{ translate('Save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card api-box {{ !@$settings->api->status ? 'd-none' : '' }}">
        <div class="card-header p-3">{{ translate('Documentation') }}</div>
        <div class="card-body p-4">
            <div class="accordion api" id="accordion">
                <div class="accordion-item border shadow-none mb-3">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed p-4" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                            <h5 class="mb-0">{{ translate('Purchase Validation') }}</h5>
                        </button>
                    </h2>
                    <div id="collapse1" class="accordion-collapse border-top collapse" data-bs-parent="#accordion">
                        <div class="accordion-body p-4">
                            @include('admin.system.api.includes.purchase-validation')
                        </div>
                    </div>
                </div>
                <div class="accordion-item border shadow-none mb-3">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed p-4" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
                            <h5 class="mb-0">{{ translate('Load All Items') }}</h5>
                        </button>
                    </h2>
                    <div id="collapse2" class="accordion-collapse border-top collapse" data-bs-parent="#accordion">
                        <div class="accordion-body p-4">
                            @include('admin.system.api.includes.items-all')
                        </div>
                    </div>
                </div>
                <div class="accordion-item border shadow-none">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed p-4" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                            <h5 class="mb-0">{{ translate('Load Single Item') }}</h5>
                        </button>
                    </h2>
                    <div id="collapse3" class="accordion-collapse border-top collapse" data-bs-parent="#accordion">
                        <div class="accordion-body p-4">
                            @include('admin.system.api.includes.single-item')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/clipboard/clipboard.min.js') }}"></script>
    @endpush
    @push('scripts')
        <script>
            "use strict";

            let apiStatus = $('#apiStatus'),
                apiBox = $('.api-box'),
                apiKeyBtn = $('#apiKeyBtn'),
                apiKeyInput = $('#apiKeyInput');

            function generateApiKey() {
                const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                let apiKey = '';
                for (let i = 0; i < 50; i++) {
                    apiKey += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                return apiKey;
            }

            if (apiKeyInput.val() == '') {
                apiKeyInput.val(generateApiKey());
            }

            apiKeyBtn.on('click', function() {
                apiKeyInput.val(generateApiKey());
            });

            apiStatus.on('change', function() {
                if ($(this).is(':checked')) {
                    apiBox.removeClass('d-none');
                } else {
                    apiBox.addClass('d-none');
                }
            });

            let codes = document.querySelectorAll('.code');
            if (codes) {
                codes.forEach(codeElement => {
                    let code = codeElement.closest('div');
                    const clipboard = new ClipboardJS(code, {
                        target: () => code.querySelector('.copy-data')
                    });
                    clipboard.on("success", (e) => {
                        e.clearSelection();
                        const copyButton = code.querySelector('.copy');
                        copyButton.innerHTML = '<i class="fa fa-check"></i>';
                        copyButton.classList.add("copied");
                        setTimeout(() => {
                            copyButton.innerHTML = '<i class="far fa-clone"></i>';
                            copyButton.classList.remove("copied");
                        }, 500);
                    });
                });
            }
        </script>
    @endpush
@endsection
