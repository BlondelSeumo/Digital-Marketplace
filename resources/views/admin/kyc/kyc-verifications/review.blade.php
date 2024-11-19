@extends('admin.layouts.grid')
@section('section', translate('KYC'))
@section('title', translate('KYC Verification #:kyc_verification_id', ['kyc_verification_id' => $kycVerification->id]))
@section('back', route('admin.kyc.kyc-verifications.index'))
@section('container', 'container-max-xl')
@section('content')
    @if (!$kycVerification->isRejected() && !$kycVerification->isApproved())
        <div class="card mb-3">
            <div class="card-header">{{ translate('Take Action') }}</div>
            <div class="card-body">
                <div class="row row-cols-auto g-3">
                    <div class="col">
                        <form action="{{ route('admin.kyc.kyc-verifications.approve', $kycVerification->id) }}"
                            method="POST">
                            @csrf
                            <button class="btn btn-outline-success btn-lg action-confirm">
                                <i class="fa-regular fa-circle-check me-1"></i>
                                <span>{{ translate('Approve') }}</span>
                            </button>
                        </form>
                    </div>
                    <div class="col">
                        <button id="kycRejectButton" class="btn btn-outline-danger btn-lg">
                            <i class="fa-regular fa-circle-xmark me-1"></i>
                            <span>{{ translate('Reject') }}</span>
                        </button>
                    </div>
                    <div id="kycRejectForm" class="col-12" style="display: none;">
                        <form action="{{ route('admin.kyc.kyc-verifications.reject', $kycVerification->id) }}"
                            method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">{{ translate('Rejection Reason') }}</label>
                                <textarea name="rejection_reason" class="form-control" rows="6" required></textarea>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="email_notification" class="form-check-input">
                                <label class="form-check-label">{{ translate('Send Email Notification') }}</label>
                            </div>
                            <button class="btn btn-danger btn-lg px-5 action-confirm">
                                <span>{{ translate('Submit') }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="card mb-3">
        <div class="card-header">{{ translate('User Informartion') }}</div>
        <div class="card-body">
            <div class="row g-3 mb-3">
                <div class="col-lg-6">
                    <label class="form-label">{{ translate('First Name') }} </label>
                    <input type="firstname" name="firstname" class="form-control form-control-lg"
                        value="{{ $kycVerification->user->firstname }}" disabled>
                </div>
                <div class="col-lg-6">
                    <label class="form-label">{{ translate('Last Name') }} </label>
                    <input type="lastname" name="lastname" class="form-control form-control-lg"
                        value="{{ $kycVerification->user->lastname }}" disabled>
                </div>
                <div class="col-lg-12">
                    <label class="form-label">{{ translate('Username') }} </label>
                    <input type="text" name="username" class="form-control form-control-lg"
                        value="{{ $kycVerification->user->username }}" disabled>
                </div>
                <div class="col-lg-12">
                    <label class="form-label">{{ translate('E-mail Address') }} </label>
                    <input type="email" name="email" class="form-control form-control-lg"
                        value="{{ demo($kycVerification->user->email) }}" disabled>
                </div>
            </div>
            <a href="{{ route('admin.members.users.edit', $kycVerification->user->id) }}" target="_blank"
                class="btn btn-outline-primary btn-lg w-100"><i
                    class="fa-solid fa-up-right-from-square me-2"></i>{{ translate('View Full Information') }}</a>
        </div>
    </div>
    <div class="card">
        <div class="card-header">{{ translate('Documents') }}</div>
        <div class="card-body">
            <div class="row g-3">
                @foreach ($kycVerification->documents as $key => $document)
                    @if ($document)
                        <div class="col-12 col-lg-6 col-xl">
                            <div class="border p-3 rounded-3 bg-light h-100">
                                <h5 class="border-bottom pb-3 mb-3 text-center">
                                    {{ translate(ucfirst(str_replace('_', ' ', $key))) }}
                                </h5>
                                <div class="mb-3">
                                    <a href="{{ route('admin.kyc.kyc-verifications.document', [$kycVerification->id, $key]) }}"
                                        target="_blank">
                                        <img src="{{ route('admin.kyc.kyc-verifications.document', [$kycVerification->id, $key]) }}"
                                            alt="{{ $document }}" class="rounded-3" width="100%" height="220px">
                                    </a>
                                </div>
                                <a href="{{ route('admin.kyc.kyc-verifications.document', [$kycVerification->id, $key]) }}"
                                    target="_blank" class="btn btn-outline-secondary btn-md w-100 mb-3"><i
                                        class="fa-solid fa-up-right-from-square me-2"></i>{{ translate('View Document') }}</a>
                                <form
                                    action="{{ route('admin.kyc.kyc-verifications.download', [$kycVerification->id, $key]) }}"
                                    method="POST">
                                    @csrf
                                    <button class="btn btn-primary btn-md w-100"><i
                                            class="fa-solid fa-download me-2"></i>{{ translate('Download') }}</button>
                                </form>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            "use strict";
            let kycRejectButton = $('#kycRejectButton'),
                kycRejectForm = $('#kycRejectForm');
            kycRejectButton.on('click', function() {
                kycRejectForm.toggle();
            })
        </script>
    @endpush
@endsection
