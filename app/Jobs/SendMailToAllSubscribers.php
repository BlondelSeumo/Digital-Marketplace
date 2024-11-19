<?php

namespace App\Jobs;

use App\Models\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendMailToAllSubscribers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $subject;
    public $reply_to;
    public $message;

    public function __construct($subject, $reply_to, $message)
    {
        $this->subject = $subject;
        $this->reply_to = $reply_to;
        $this->message = $message;
    }

    public function handle()
    {
        $subject = $this->subject;
        $replyTo = $this->reply_to;
        $msg = $this->message;

        $subscribers = NewsletterSubscriber::all();

        foreach ($subscribers as $subscriber) {
            $email = $subscriber->email;
            Mail::send([], [], function ($message) use ($msg, $email, $subject, $replyTo) {
                $message->to($email)
                    ->replyTo($replyTo)
                    ->subject($subject)
                    ->html($msg);
            });
        }
    }
}