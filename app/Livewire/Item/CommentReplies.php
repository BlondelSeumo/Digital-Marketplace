<?php

namespace App\Livewire\Item;

use App\Jobs\SendCommentReplyNotification;
use App\Models\ItemCommentReply;
use App\Traits\LivewireToastr;
use App\Traits\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class CommentReplies extends Component
{
    use WithPagination, LivewireToastr;

    public $user;

    public $comment;

    public $reply;

    public $perPage = 4;

    public $allRepliesLoaded = false;

    protected $listeners = [
        'refreshItemCommentReplies' => '$refresh',
    ];

    public function mount($comment)
    {
        $this->user = authUser();
        $this->comment = $comment;
    }

    public function storeReply()
    {
        $validator = Validator::make(['reply' => $this->reply], [
            'reply' => ['required', 'string', 'max:5000'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return $this->toastr('error', $error);
            }
        }

        $user = $this->user;
        $comment = $this->comment;
        $item = $comment->item;

        if (!$user->isAdmin() && $user->id != $comment->user->id) {
            return $this->toastr('error', translate('Invalid request action'));
        }

        if ($user->isUser()) {
            $lastRepliesCount = ItemCommentReply::where('item_comment_id', $comment->id)
                ->where('user_id', $user->id)
                ->where('created_at', '>', Carbon::now()->subMinutes(2))
                ->count();

            if ($lastRepliesCount >= 5) {
                return $this->toastr('error', translate('Your are writing too many replies in shorter time, please try again later'));
            }
        }

        $commentReply = new ItemCommentReply();
        $commentReply->item_comment_id = $comment->id;
        $commentReply->user_id = $user->id;
        $commentReply->body = $this->reply;
        $commentReply->save();

        $this->reply = '';

        $this->perPage = $this->comment->replies()->count();
        $this->emit('refreshItemCommentReplies');

        dispatch(new SendCommentReplyNotification($commentReply));

        return $this->toastr('success', translate('Your reply has been published successfully'));
    }

    public function loadAllReplies()
    {
        $this->perPage = $this->comment->replies()->count();
    }

    public function render()
    {
        $item = $this->comment->item;

        $commentReplies = ItemCommentReply::where('item_comment_id', $this->comment->id)
            ->paginate($this->perPage);

        $totalCommentReplies = $commentReplies->total() - $this->perPage;

        if ($commentReplies->lastPage() <= $commentReplies->currentPage()) {
            $this->allRepliesLoaded = true;
        }

        return theme_view('livewire.item.comment-replies', [
            'item' => $item,
            'totalCommentReplies' => $totalCommentReplies,
            'commentReplies' => $commentReplies,
        ]);
    }

}
