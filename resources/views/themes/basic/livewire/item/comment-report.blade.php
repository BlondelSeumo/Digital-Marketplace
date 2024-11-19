<div wire:ignore.self wire:key="reportItemCommentyModal" class="modal fade" id="reportItemCommentModal" tabindex="-1"
    aria-labelledby="reportItemCommentModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    @if ($itemCommentReply)
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content p-4">
                <div class="modal-header p-0 border-0 mb-4">
                    <h1 class="modal-title fs-5" id="reportItemCommentModalLabel">
                        {{ translate('Report comment') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="item-comment bg-color border border-2 rounded-2 p-4 mb-4">
                        <div class="row row-cols-auto flex-nowrap g-3">
                            <div class="col d-flex flex-column align-items-center">
                                <div class="user-avatar me-0">
                                    <img src="{{ $itemCommentReply->user->getAvatar() }}"
                                        alt="{{ $itemCommentReply->user->username }}">
                                </div>
                            </div>
                            <div class="col flex-grow-1 flex-shrink-1">
                                <div class="row row-cols-auto align-items-center justify-content-between g-2 mb-2">
                                    <div class="col">
                                        <div class="row row-cols-auto align-items-center g-2">
                                            <div class="col">
                                                <h6 class="mb-0">
                                                    {{ $itemCommentReply->user->username }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col small">
                                        <div class="row row-cols-auto g-2">
                                            <div class="col">
                                                <span class="text-muted mb-0">
                                                    {{ $itemCommentReply->created_at->diffforhumans() }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="fw-light">
                                    {!! purifier(shorterText($itemCommentReply->body, 500)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <form wire:submit.prevent="sendCommentReport">
                        <div class="mb-4">
                            <label class="form-label">{{ translate('Report Reason') }}</label>
                            <textarea wire:model.defer="report_reason" class="form-control p-3" rows="6"
                                placeholder="{{ translate('Tell us why we should delete this comment...') }}" required></textarea>
                        </div>
                        <div class="row justify-content-center g-3">
                            <div class="col-12 col-lg">
                                <button type="button" class="btn btn-outline-primary btn-md w-100"
                                    data-bs-dismiss="modal">{{ translate('Close') }}</button>
                            </div>
                            <div class="col-12 col-lg">
                                <button type="submit"
                                    class="btn btn-primary btn-md w-100">{{ translate('Send') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
