<?php

namespace App\Jobs\Admin;

use App\Classes\SendMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAdminItemCommentNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $comment;
    public $commentReply;

    public function __construct($comment, $commentReply)
    {
        $this->comment = $comment;
        $this->commentReply = $commentReply;
    }

    public function handle()
    {
        $comment = $this->comment;
        $commentReply = $this->commentReply;
        $item = $comment->item;

        $admins = User::admin()->get();
        foreach ($admins as $admin) {
            SendMail::send($admin->email, 'admin_item_comment', [
                'username' => $commentReply->user->username,
                'comment' => $commentReply->body,
                'item_name' => $comment->item->name,
                'item_link' => $comment->item->getLink(),
                'comment_link' => $comment->getLink(),
                'website_name' => @settings('general')->site_name,
            ]);
        }

        $title = translate('New comment on (:item_name)', ['item_name' => $item->name]);
        $image = asset('images/notifications/comment.png');
        $link = $comment->getLink();
        adminNotify($title, $image, $link, true);
    }
}