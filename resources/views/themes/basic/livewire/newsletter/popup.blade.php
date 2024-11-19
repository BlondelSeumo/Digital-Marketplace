<div>
    @if (
        @$settings->newsletter->status &&
            @$settings->newsletter->popup_status &&
            !request()->hasCookie('newsletter_subscribed') &&
            !request()->hasCookie('newsletter_reminder'))
        <div wire:ignore.self class="modal fade" id="newsletterModal" tabindex="-1" aria-labelledby="newsletterModalLabel"
            aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content p-0 border-0 rounded-3 shadow-lg">
                    <div class="modal-body p-0">
                        <div class="row g-0">
                            <div class="col-lg-6 d-none d-lg-block">
                                <img src="{{ asset(@$settings->newsletter->popup_image) }}"
                                    class="img-fluid w-100 h-100 rounded-start object-fit-cover"
                                    alt="{{ translate('Subscribe to Our Newsletter') }}"
                                    style="max-height: 600px; object-fit: cover;">
                            </div>
                            <div class="col-lg-6 p-5 d-flex flex-column justify-content-center bg-color">
                                <h2 class="mb-4 fw-bold text-primary">{{ translate('Subscribe to Our Newsletter') }}
                                </h2>
                                <p class="mb-4 text-muted">
                                    {{ translate('Stay tuned for the latest and greatest items and offers, delivered right to your inbox!') }}
                                </p>
                                <div class="bg-white p-4 border rounded-3 shadow-sm">
                                    <form wire:submit.prevent="subscribe">
                                        <div class="mb-3">
                                            <label class="form-label">{{ translate('Your Email') }}</label>
                                            <input type="email" wire:model.defer="email"
                                                class="form-control form-control-lg" placeholder="name@example.com"
                                                value="{{ authUser() ? authUser()->email : '' }}" required>
                                        </div>
                                        <button
                                            class="btn btn-primary btn-lg w-100">{{ translate('Subscribe') }}</button>
                                    </form>
                                    <button class="btn btn-outline-primary btn-lg mt-3 w-100"
                                        wire:click="remindLater">{{ translate('Remind me later') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            "use strict";
            document.addEventListener("DOMContentLoaded", function() {
                var newsletterModal = new bootstrap.Modal(document.getElementById('newsletterModal'));
                newsletterModal.show();
            });
        </script>
    @endif
</div>
