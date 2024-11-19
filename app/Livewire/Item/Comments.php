<?php

namespace App\Livewire\Item;

use App\Jobs\Admin\SendAdminItemCommentNotification;
use App\Models\ItemComment;
use App\Models\ItemCommentReply;
use App\Traits\LivewireToastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination, LivewireToastr;

    public $user;

    public $item;

    public $comment;

    public function mount($item)
    {
        $this->user = authUser();
        $this->item = $item;
    }

    public function rules()
    {
        return [
            'comment' => ['required', 'string', 'max:5000'],
        ];
    }

    public function storeComment()
    {
        $validator = Validator::make([
            'comment' => $this->comment,
        ], $this->rules());

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return $this->toastr('error', $error);
            }
        }

        $lastCommentsCount = ItemComment::where('item_id', $this->item->id)
            ->where('user_id', $this->user->id)
            ->where('created_at', '>', Carbon::now()->subMinutes(2))
            ->count();

        if ($lastCommentsCount >= 3) {
            return $this->toastr('error', translate('Your are writing too many comments in shorter time, please try again later'));
        }

        $user = $this->user;
        $item = $this->item;

        $comment = new ItemComment();
        $comment->user_id = $user->id;
        $comment->item_id = $item->id;
        $comment->save();

        $commentReply = new ItemCommentReply();
        $commentReply->item_comment_id = $comment->id;
        $commentReply->user_id = $user->id;
        $commentReply->body = $this->comment;
        $commentReply->save();

        $this->comment = '';

        $this->emit('refreshCommentsCounter');

        if ($user->isUser()) {
            dispatch(new SendAdminItemCommentNotification($comment, $commentReply));
        }

        return $this->toastr('success', translate('Your comment has been published successfully'));
    }

    public function render()
    {
        $comments = ItemComment::where('item_id', $this->item->id)
            ->with('user')
            ->orderByDesc('id')->paginate(40);

        return theme_view('livewire.item.comments', [
            'comments' => $comments,
        ]);
    }
}
