<?php

namespace App\Jobs\Admin;

use App\Classes\SendMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAdminTicketReplyNotification implements ShouldQueue
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

        $admins = User::admin()->get();
        foreach ($admins as $admin) {
            SendMail::send($admin->email, 'admin_new_ticket_reply', [
                'username' => $ticket->user->username,
                'ticket_id' => $ticket->id,
                'reply_message' => $ticketReply->body,
                'link' => route('admin.tickets.show', $ticket->id),
                'date' => dateFormat($ticket->created_at),
                'website_name' => @settings('general')->site_name,
            ]);
        }

        $title = translate('New Ticket Reply [#:ticket_id]', ['ticket_id' => $ticket->id]);
        $image = asset('images/notifications/ticket.png');
        $link = route('admin.tickets.show', $ticket->id);
        adminNotify($title, $image, $link);
    }
}