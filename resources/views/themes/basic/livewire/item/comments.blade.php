<div class="item-comments">
    @if (authUser())
        <div class="box bg-color {{ $comments->count() > 1 ? 'mb-4' : '' }} p-4">
            <div class="leave-comment">
                <div class="d-flex align-items-start">
                    <div class="user-avatar">
                        <img src="{{ authUser()->getAvatar() }}" alt="{{ authUser()->username }}">
                    </div>
                    <div class="flex-grow-1">
                        <form wire:submit.prevent="storeComment">
                            <textarea class="form-control form-control-md w-100 mb-3" wire:model.defer="comment"
                                placeholder="{{ translate('Your comment') }}" rows="2" required></textarea>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary px-4">{{ translate('Publish') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @elseif($comments->count() < 1)
        <div class="box bg-color text-center">
            <i class="fa-regular fa-comments fa-lg"></i>
            <p class="mt-3">{{ translate('This item has no comments') }}</p>
            @if (!authUser())
                <p class="mt-2 mb-0">{!! translate(':sign_in to comment', [
                    'sign_in' => '<a href="' . route('login') . '">' . translate('Sign In') . '</a>',
                ]) !!}</p>
            @endif
        </div>
    @endif
    @if ($comments->count() > 0)
        <div class="item-comments">
            <div class="row row-cols-1 {{ $comments->count() > 1 ? 'g-4' : (authUser() ? 'mt-4' : '') }}">
                @foreach ($comments as $comment)
                    <livewire:item.comment-replies :comment="$comment" wire:key="{{ hash_encode($comment->id) }}" />
                @endforeach
            </div>
        </div>
        {{ $comments->links() }}
    @endif

</div>
