@extends('themes.basic.layouts.single')
@section('noindex', true)
@section('header_title', translate('Checkout'))
@section('title', translate('Checkout'))
@section('body_bg', 'bg-white')
@section('breadcrumbs', Breadcrumbs::render('checkout', $trx))
@section('header_v3', true)
@section('content')
    @if ($trx->isUnpaid())
        <livewire:checkout :trx="$trx" />
    @else
        <div class="box">
            <div class="col-lg-6 m-auto">
                <div class="py-3 text-center">
                    <div class="mb-4">
                        <i class="fa fa-check-circle text-primary fa-5x"></i>
                    </div>
                    @if ($trx->isTypePurchase())
                        <h2 class="mb-3">{{ translate('Payment completed') }}</h2>
                        <p>
                            {{ translate('Thank you for your purchase. Your payment has been completed successfully.') }}
                        </p>
                        <a href="{{ route('user.purchases.index') }}" class="btn btn-outline-primary btn-md px-5 mt-2">
                            {{ translate('View My Purchases') }}<i class="fa fa-arrow-right fa-rtl ms-2"></i>
                        </a>
                    @elseif($trx->isTypeDeposit())
                        <h2 class="mb-3">{{ translate('Deposit Completed') }}</h2>
                        <p>
                            {{ translate('Payment has been completed and your deposit has been processed successfully.') }}
                        </p>
                        <a href="{{ route('user.wallet.index') }}" class="btn btn-outline-primary btn-md px-5 mt-2">
                            {{ translate('View My Wallet') }}<i class="fa fa-arrow-right fa-rtl ms-2"></i>
                        </a>
                    @elseif($trx->isTypeSubscription())
                        <h2 class="mb-3">{{ translate('Payment Completed') }}</h2>
                        <p>
                            {{ translate('Payment has been completed and your subscription has been created successfully.') }}
                        </p>
                        <a href="{{ route('user.settings.index') }}" class="btn btn-outline-primary btn-md px-5 mt-2">
                            {{ translate('View My Subscription') }}<i class="fa fa-arrow-right fa-rtl ms-2"></i>
                        </a>
                    @elseif($trx->isTypeSupportPurchase())
                        <h2 class="mb-3">{{ translate('Payment completed') }}</h2>
                        <p>
                            {{ translate('Payment has been completed and your support has been purchased successfully.') }}
                        </p>
                        <a href="{{ route('user.purchases.index') }}" class="btn btn-outline-primary btn-md px-5 mt-2">
                            {{ translate('View My Purchases') }}<i class="fa fa-arrow-right fa-rtl ms-2"></i>
                        </a>
                    @elseif($trx->isTypeSupportExtend())
                        <h2 class="mb-3">{{ translate('Payment completed') }}</h2>
                        <p>
                            {{ translate('Payment has been completed and your support has been extended successfully.') }}
                        </p>
                        <a href="{{ route('user.purchases.index') }}" class="btn btn-outline-primary btn-md px-5 mt-2">
                            {{ translate('View My Purchases') }}<i class="fa fa-arrow-right fa-rtl ms-2"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif
    @push('scripts')
        <script>
            "use strict";
            let checkoutButton = $('.checkout-button');
            checkoutButton.on('click', function(e) {
                let checkedPaymentMethod = $('.payment-method input:checked');
                if (checkedPaymentMethod.val() == "balance") {
                    if (!confirm(config.translates.actionConfirm)) {
                        e.preventDefault();
                    }
                }
            });
        </script>
    @endpush
@endsection
