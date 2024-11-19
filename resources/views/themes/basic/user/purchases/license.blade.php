<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ translate('License Certificate for :item_name', ['item_name' => $purchase->item->name]) }}</title>
    <link rel="icon" href="{{ asset($themeSettings->general->favicon) }}">
    @include('themes.basic.includes.styles')
</head>
<style>
    @media print {
        @page {
            size: landscape;
            margin: 0;
        }

        .col-lg-7 {
            width: 100%;
        }

        .m-auto {
            margin: 0 !important;
        }

        .btn {
            display: none;
        }
    }
</style>

<body class="pt-0">
    <div class="col-lg-7 m-auto">
        <div class="card border-0 shadow-none">
            <div class="card-body p-5">
                <div>
                    <div class="mb-4">
                        <img src="{{ asset($themeSettings->general->logo_dark) }}"
                            alt="{{ @$settings->general->site_name }}" class="mb-2" height="40px">
                    </div>
                    <h1 class="mb-3">{{ translate('License Certificate') }}</h1>
                    <div class="mb-3">
                        <p class="mb-0">
                            {{ translate('This document certifies the purchase of the following license:') }}
                            <strong>{{ strtoupper($purchase->isLicenseTypeRegular() ? translate('Regular License') : translate('Extended License')) }}</strong>.
                        </p>
                        <p class="mb-0">
                            {{ translate('Details of the license can be accessed from your workspace purchases page.') }}
                        </p>
                    </div>
                </div>
                <div class="my-3 py-3 border-bottom border-top">
                    <p>
                        <strong>{{ translate("Licensor's:") }}</strong>
                        {{ ucfirst($settings->general->site_name) }}
                    </p>
                    <p><strong>{{ translate('Licensee:') }}</strong> {{ $purchase->user->getName() }}</p>
                    <p><strong>{{ translate('Item ID:') }}</strong> {{ $purchase->item->id }}</p>
                    <p><strong>{{ translate('Item Name:') }}</strong> {{ $purchase->item->name }}</p>
                    <p><strong>{{ translate('Item URL:') }}</strong> <a
                            href="{{ $purchase->item->getLink() }}">{{ $purchase->item->getLink() }}</a>
                    </p>
                    <p><strong>{{ translate('Item Purchase Code:') }}</strong> {{ $purchase->code }}</p>
                    <p class="mb-0"><strong>{{ translate('Purchase Date:') }}</strong>
                        {{ dateFormat($purchase->created_at) }}
                    </p>
                </div>
                <div class="mb-4">
                    @if (@$settings->actions->contact_page)
                        <p>{{ translate('For any queries related to this document or licenses please contact us via') }}
                            <a href="{{ route('contact') }}">{{ route('contact') }}</a>
                        </p>
                    @endif
                    <p>{{ @$settings->general->site_name }}</p>
                </div>
                <div class="mt-auto text-center">
                    <button class="btn btn-primary btn-md fw-medium" onclick="window.print()">
                        <i class="fa-solid fa-print me-2"></i>
                        {{ translate('Print') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @include('themes.basic.includes.scripts')
</body>

</html>
