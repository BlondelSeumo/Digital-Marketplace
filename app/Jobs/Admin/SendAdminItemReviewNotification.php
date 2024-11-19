<?php

namespace App\Jobs\Admin;

use App\Classes\SendMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAdminItemReviewNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $review;

    public function __construct($review)
    {
        $this->review = $review;
    }

    public function handle()
    {
        $review = $this->review;
        $item = $review->item;

        $admins = User::admin()->get();
        foreach ($admins as $admin) {
            SendMail::send($admin->email, 'admin_item_review', [
                'username' => $review->user->username,
                'stars' => $review->stars,
                'review' => $review->body,
                'item_name' => $item->name,
                'item_link' => $item->getLink(),
                'review_link' => $review->getLink(),
                'website_name' => @settings('general')->site_name,
            ]);
        }

        $title = translate('New review on (:item_name)', ['item_name' => $item->name]);
        $image = asset('images/notifications/review.png');
        $link = $review->getLink();
        adminNotify($title, $image, $link, true);
    }
}