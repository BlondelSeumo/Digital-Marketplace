<?php

namespace App\Jobs;

use App\Classes\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNewTicketReplyNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $ticketReply;

    public function __construct($ticketReply)
    {
        $this->ticketReply = $ticketReply;
    }

    public function handle()
    {
        $ticketReply = $this->ticketReply;
        $ticket = $ticketReply->ticket;
        $user = $ticket->user;

        SendMail::send($user->email, 'new_ticket_reply', [
            'username' => $user->username,
            'ticket_id' => $ticket->id,
            'reply_message' => $ticketReply->body,
            'link' => route('user.tickets.show', $ticket->id),
            'date' => dateFormat($ticket->created_at),
            'website_name' => @settings('general')->site_name,
        ]);
    }
}
