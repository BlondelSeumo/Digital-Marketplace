<?php

namespace App\Jobs\Admin;

use App\Classes\SendMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAdminTicketNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    public function handle(): void
    {
        $ticket = $this->ticket;

        $admins = User::admin()->get();
        foreach ($admins as $admin) {
            SendMail::send($admin->email, 'admin_new_ticket', [
                'username' => $ticket->user->username,
                'ticket_id' => $ticket->id,
                'subject' => $ticket->subject,
                'category' => $ticket->category->name,
                'link' => route('admin.tickets.show', $ticket->id),
                'date' => dateFormat($ticket->created_at),
                'website_name' => @settings('general')->site_name,
            ]);
        }

        $title = translate('New Ticket [#:ticket_id]', ['ticket_id' => $ticket->id]);
        $image = asset('images/notifications/ticket.png');
        $link = route('admin.tickets.show', $ticket->id);
        adminNotify($title, $image, $link);
    }
}