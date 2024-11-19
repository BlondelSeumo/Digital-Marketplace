<div class="col">
    <div class="box overflow-hidden p-0">
        <div class="box-header border-bottom bg-color py-3 px-4">
            <div class="row row-cols-auto justify-content-between align-items-center g-2">
                <div class="col">
                    <div class="row row-cols-auto align-items-center g-2">
                        <div class="col">
                            @include('themes.basic.partials.rating-stars', [
                                'stars' => $review->stars,
                                'ratings_classes' => 'ratings-md',
                            ])
                        </div>
                        <div class="col">
                            <span>
                                {!! translate('By :username', ['username' => '<strong>' . $review->user->username . '</strong>']) !!}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="d-flex flex-wrap align-items-center gap-1">
                        <a href="{{ $review->getLink() }}"
                            class="small text-muted">{{ $review->created_at->diffforhumans() }}</a>
                    </div>
                </div>
            </div>
        </div>
        @if ($review->body)
            <div class="box-body p-4">
                <p class="fw-light mb-0">
                    {!! purifier($review->body) !!}
                </p>
            </div>
        @endif
        @if ($review->reply)
            <div class="box-footer border-top bg-color py-3 px-4">
                @php
                    $reply = $review->reply;
                    $replyUser = $reply->user;
                @endphp
                <div class="row row-cols-auto flex-nowrap g-3">
                    <div class="col d-flex flex-column align-items-center">
                        <div class="user-avatar me-0">
                            <img src="{{ $replyUser->getAvatar() }}" alt="{{ $replyUser->username }}">
                        </div>
                    </div>
                    <div class="col flex-grow-1 flex-shrink-1">
                        <div class="row row-cols-auto align-items-center justify-content-between g-2 mb-2">
                            <div class="col">
                                <div class="row row-cols-auto align-items-center g-2">
                                    <div class="col">
                                        <h6 class="mb-0">{{ $replyUser->username }}</h6>
                                    </div>
                                    @if ($replyUser->isAdmin())
                                        <div class="col">
                                            <i class="bi bi-patch-check-fill text-primary"
                                                title="{{ translate('Admin') }}"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col">
                                <p class="text-muted small mb-0">
                                    {{ $reply->created_at->diffforhumans() }}
                                </p>
                            </div>
                        </div>
                        <div class="fw-light">
                            {!! purifier($reply->body) !!}
                        </div>
                    </div>
                </div>
            </div>
        @elseif(authUser() && authUser()->isAdmin() && $review->body)
            <div class="box-footer border-top bg-color py-3 px-4">
                <form action="{{ route('items.reviews.reply', [$item->slug, $item->id, $review->id]) }}" method="POST">
                    @csrf
                    <textarea class="form-control form-control-md w-100 mb-3" name="reply" placeholder="{{ translate('Your reply') }}"
                        rows="2" required></textarea>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary px-4">{{ translate('Publish') }}</button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>
