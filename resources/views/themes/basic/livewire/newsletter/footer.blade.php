<div>
    @if (
        @$settings->newsletter->status &&
            $settings->newsletter->footer_status &&
            !request()->hasCookie('newsletter_subscribed'))
        <div class="footer-subscribe">
            <div class="row row-cols-1 row-cols-lg-2 g-3">
                <div class="col">
                    <h3 class="mb-3">{{ translate('Subscribe to Our Newsletter') }}</h3>
                    <p class="mb-0">
                        {{ translate('Stay tuned for the latest and greatest items and offers, delivered right to your inbox!') }}
                    </p>
                </div>
                <div class="col">
                    <form wire:submit.prevent="subscribe">
                        <div class="input-group">
                            <input type="email" wire:model.defer="email" class="form-control form-control-lg"
                                placeholder="name@example.com" value="{{ authUser() ? authUser()->email : '' }}"
                                required>
                            <button class="btn btn-primary btn-lg">
                                {{ translate('Subscribe') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
