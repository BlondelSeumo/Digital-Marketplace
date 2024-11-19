<?php

namespace App\Jobs;

use App\Classes\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNewTicketNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    public function handle()
    {
        $ticket = $this->ticket;
        $user = $ticket->user;

        SendMail::send($user->email, 'new_ticket', [
            'username' => $user->username,
            'ticket_id' => $ticket->id,
            'subject' => $ticket->subject,
            'category' => $ticket->category->name,
            'link' => route('user.tickets.show', $ticket->id),
            'date' => dateFormat($ticket->created_at),
            'website_name' => @settings('general')->site_name,
        ]);
    }
}
