<div>
    <div class="row g-4">
        <div class="col-12 col-xl-7 order-2 order-xl-1">
            <form id="checkoutForm" action="{{ route('checkout.process', hash_encode($trx->id)) }}" method="POST">
                @csrf
                <div class="box border box-shadow p-4 mb-4">
                    <h6 class="fs-5 mb-4">{{ translate('Payments Method') }}</h1>
                    </h6>
                    <div class="row g-3">
                        @foreach ($paymentGateways as $paymentGateway)
                            <div class="{{ $paymentGateway->isWallet() ? 'col-12' : 'col-6 col-sm-6 col-lg-4' }}">
                                <div class="payment-method">
                                    <div class="payment-img">
                                        <img src="{{ $paymentGateway->getLogoLink() }}"
                                            alt="{{ $paymentGateway->name }}">
                                    </div>
                                    @if ($paymentGateway->isWallet())
                                        <span>{{ getAmount(authUser()->balance) }}</span>
                                    @endif
                                    <input class="form-check-input" type="radio" name="payment_method"
                                        wire:model="payment_method" wire:change="updateSummary"
                                        value="{{ $paymentGateway->alias }}" id="{{ $paymentGateway->alias }}"
                                        @checked($payment_method == $paymentGateway->alias)>
                                    <label class="form-check-label" for="{{ $paymentGateway->alias }}"></label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="box border box-shadow p-4">
                    <h5 class="mb-4">{{ translate('Billing address') }}</h5>
                    <div class="row mb-3 g-3">
                        <div class="col-lg-6">
                            <label class="form-label">{{ translate('First Name') }}</label>
                            <input type="text" class="form-control form-control-md"
                                value="{{ authUser()->firstname }}" disabled>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">{{ translate('Last Name') }}</label>
                            <input type="text" class="form-control form-control-md"
                                value="{{ authUser()->lastname }}" disabled>
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ translate('Address line 1') }}</label>
                            <input type="text" wire:model="address_line_1" name="address_line_1"
                                class="form-control form-control-md" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ translate('Address line 2') }}</label>
                            <input type="text" wire:model="address_line_2" name="address_line_2"
                                class="form-control form-control-md">
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">{{ translate('City') }}</label>
                                <input type="text" wire:model="city" name="city"
                                    class="form-control form-control-md" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">{{ translate('State') }}</label>
                                <input type="text" wire:model="state" name="state"
                                    class="form-control form-control-md" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">{{ translate('Postal code') }}</label>
                                <input type="text" wire:model="zip" name="zip"
                                    class="form-control form-control-md" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label class="form-label">{{ translate('Country') }}</label>
                            <select wire:model="country" wire:change="updateSummary" name="country"
                                class="form-select form-select-md" required>
                                <option value="">--</option>
                                @foreach (countries() as $countryCode => $countryName)
                                    <option value="{{ $countryCode }}" @selected($countryCode == $country)>
                                        {{ $countryName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            <div class="box bg-color border box-shadow p-4 d-block d-xl-none mt-4">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <i class="fas fa-shield-alt text-success fa-3x"></i>
                    </div>
                    <div class="col">
                        <span class="h6 text-uppercase mb-2 d-block">
                            {{ translate('SSL Secure Payment') }}
                        </span>
                        <p class="text-muted mb-0">
                            {{ translate('Your information is protected by 256-bit SSL encryption') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="d-block d-xl-none mt-4">
                <button form="checkoutForm"
                    class="btn btn-primary checkout-button btn-md w-100">{{ translate('Continue') }}</button>
            </div>
        </div>
        <div class="col-12 col-xl-5 order-1 order-xl-2">
            <div class="box bg-color border box-shadow p-4">
                <h5 class="mb-2">{{ translate('Order Summary') }}</h5>
                @if ($trx->isTypePurchase())
                    @foreach ($trx->trxItems as $trxItem)
                        @php
                            $item = $trxItem->item;
                        @endphp
                        <div class="row g-3 align-items-center border-bottom py-3">
                            <div class="col-auto">
                                <a href="{{ $item->getLink() }}">
                                    <div class="item-img item-img-sm">
                                        <img src="{{ $item->getThumbnailLink() }}" alt="{{ $item->name }}">
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <div class="mb-2">
                                    <a href="{{ $item->getLink() }}" class="text-dark me-3">{{ $item->name }}</a>
                                </div>
                                <div class="row g-3 row-cols-auto">
                                    <div class="col">
                                        <div class="small">
                                            <span>{{ translate('License') }}:</span>
                                            <span class="text-muted">
                                                {{ $trxItem->isLicenseTypeRegular() ? translate('Regular') : translate('Extended') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="small">
                                            <span>{{ translate('Qty') }}:</span>
                                            <span class="text-muted">{{ $trxItem->quantity }}</span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="small">
                                            <span>{{ translate('Price') }}:</span>
                                            <span class="text-muted">{{ getAmount($trxItem->price) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto text-center">
                                <h6 class="mb-0 ms-auto">{{ getAmount($trxItem->total) }}</h6>
                            </div>
                        </div>
                        @if ($trxItem->support)
                            <div class="row g-3 align-items-center border-bottom py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>{{ $trxItem->support->title }}</span>
                                    <h6 class="mb-0">
                                        {{ getAmount($trxItem->support->total) }}
                                    </h6>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @elseif($trx->isTypeDeposit())
                    <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                        <span>{{ translate('Deposit Amount') }}</span>
                        <h6 class="mb-0">{{ getAmount($trx->amount) }}</h6>
                    </div>
                @elseif($trx->isTypeSubscription())
                    <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                        <span>{{ translate('Subscription - :plan_name (:plan_interval)', [
                            'plan_name' => $trx->plan->name,
                            'plan_interval' => $trx->plan->getIntervalName(),
                        ]) }}</span>
                        <h6 class="mb-0">{{ getAmount($trx->amount) }}</h6>
                    </div>
                @elseif($trx->isTypeSupportPurchase() || $trx->isTypeSupportExtend())
                    <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                        <span>{{ $trx->support->title }}</span>
                        <h6 class="mb-0">{{ getAmount($trx->amount) }}</h6>
                    </div>
                @endif
                @if ($summary['gateway'] || $summary['tax'])
                    <div class="border-bottom pb-3">
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span>{{ translate('SubTotal') }}</span>
                            <h6 class="mb-0">{{ getAmount($trx->amount) }}</h6>
                        </div>
                        @if ($summary['tax'])
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span>{{ translate(':tax_name (:tax_rate%)', [
                                    'tax_name' => $summary['tax']['name'],
                                    'tax_rate' => $summary['tax']['rate'],
                                ]) }}</span>
                                <h6 class="mb-0">{{ $summary['tax']['amount'] }}</h6>
                            </div>
                        @endif
                        @if ($summary['gateway'])
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span>{{ translate(':payment_gateway Fees (:percentage%)', [
                                    'payment_gateway' => $summary['gateway']['name'],
                                    'percentage' => $summary['gateway']['fees'],
                                ]) }}</span>
                                <h6 class="mb-0">{{ $summary['gateway']['amount'] }}</h6>
                            </div>
                        @endif
                    </div>
                @endif
                <div class="d-flex justify-content-between align-items-center pt-3">
                    <strong class="fs-5">{{ translate('Total') }}</strong>
                    <h6 class="mb-0 fs-5"><strong>{{ getAmount($summary['total']) }}</strong></h6>
                </div>
            </div>
            <div class="box bg-color border box-shadow p-4 d-none d-xl-block mt-4">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <i class="fas fa-shield-alt text-success fa-3x"></i>
                    </div>
                    <div class="col">
                        <span class="h6 text-uppercase mb-2 d-block">{{ translate('SSL Secure Payment') }}</span>
                        <p class="text-muted mb-0">
                            {{ translate('Your information is protected by 256-bit SSL encryption') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="d-none d-xl-block mt-4">
                <button form="checkoutForm"
                    class="btn btn-primary checkout-button btn-md w-100">{{ translate('Continue') }}</button>
            </div>
        </div>
    </div>
</div>
