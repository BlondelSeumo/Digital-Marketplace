<?php

namespace App\Jobs;

use App\Classes\SendMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendCommentReplyNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $commentReply;

    public function __construct($commentReply)
    {
        $this->commentReply = $commentReply;
    }

    public function handle()
    {
        $commentReply = $this->commentReply;
        $comment = $commentReply->comment;
        $item = $comment->item;

        if ($commentReply->user->isAdmin()) {
            SendMail::send($comment->user->email, 'item_comment_reply', [
                'username' => $comment->user->username,
                'comment_reply' => $commentReply->body,
                'item_name' => $item->name,
                'item_link' => $item->getLink(),
                'comment_link' => $comment->getLink(),
                'website_name' => @settings('general')->site_name,
            ]);
        } else {
            $admins = User::admin()->get();
            foreach ($admins as $admin) {
                SendMail::send($admin->email, 'admin_item_comment_reply', [
                    'username' => $commentReply->user->username,
                    'comment_reply' => $commentReply->body,
                    'item_name' => $item->name,
                    'item_link' => $item->getLink(),
                    'comment_link' => $comment->getLink(),
                    'website_name' => @settings('general')->site_name,
                ]);
            }

            $title = translate('New comment reply on (:item_name)', ['item_name' => $item->name]);
            $image = asset('images/notifications/comment.png');
            $link = $comment->getLink();
            adminNotify($title, $image, $link, true);
        }
    }
}
