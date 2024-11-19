<?php

namespace App\Http\Controllers\Admin\Tickets;

use App\Http\Controllers\Controller;
use App\Jobs\SendNewTicketNotification;
use App\Jobs\SendNewTicketReplyNotification;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketReply;
use App\Models\TicketReplyAttachment;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TicketController extends Controller
{
    public function index()
    {
        $counters['opened_tickets'] = Ticket::opened()->count();
        $counters['closed_tickets'] = Ticket::closed()->count();

        $categories = TicketCategory::all();
        $tickets = Ticket::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $tickets->where(function ($query) use ($searchTerm) {
                $query->where('subject', 'like', $searchTerm)
                    ->orWhereHas('replies', function ($query) use ($searchTerm) {
                        $query->where('body', 'like', $searchTerm);
                    });
            });
        }

        if (request()->filled('user')) {
            $tickets->where('user_id', request('user'));
            $ticketsClone = clone $tickets;
            $counters['opened_tickets'] = $tickets->opened()->count();
            $counters['closed_tickets'] = $ticketsClone->closed()->count();
        }

        if (request()->filled('category')) {
            $tickets->where('ticket_category_id', request('category'));
        }

        if (request()->filled('status')) {
            $tickets->where('status', request('status'));
        }

        $tickets = $tickets->orderbyDesc('id')->paginate(50);
        $tickets->appends(request()->only(['search', 'user', 'category', 'status']));

        return view('admin.tickets.index', [
            'counters' => $counters,
            'categories' => $categories,
            'tickets' => $tickets,
        ]);
    }

    public function create()
    {
        $users = User::user()->active()->get();
        $categories = TicketCategory::active()->get();

        return view('admin.tickets.create', [
            'users' => $users,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => ['required', 'string', 'block_patterns', 'max:255'],
            'user' => ['required', 'integer', 'exists:users,id'],
            'category' => ['required', 'integer', 'exists:ticket_categories,id'],
            'description' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $user = User::where('id', $request->user)->user()->active()->firstOrFail();

        $category = TicketCategory::where('id', $request->category)->active()->firstOrFail();

        try {
            $ticket = Ticket::create([
                'subject' => $request->subject,
                'user_id' => $user->id,
                'ticket_category_id' => $category->id,
            ]);

            if ($ticket) {
                $ticketReply = TicketReply::create([
                    'body' => $request->description,
                    'ticket_id' => $ticket->id,
                    'user_id' => authUser()->id,
                ]);
                if ($ticketReply) {
                    if ($request->hasFile('attachments')) {
                        foreach ($request->file('attachments') as $attachment) {
                            $ticketReplyAttachment = new TicketReplyAttachment();
                            $ticketReplyAttachment->name = $attachment->getClientOriginalName();
                            $ticketReplyAttachment->path = storageFileUpload($attachment, "tickets/{$ticket->id}/", "local");
                            $ticketReplyAttachment->ticket_reply_id = $ticketReply->id;
                            $ticketReplyAttachment->save();
                        }
                    }
                }

                dispatch(new SendNewTicketNotification($ticket));
                toastr()->success(translate('Ticket Created Successfully'));
                return redirect()->route('admin.tickets.show', $ticket->id);
            }
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back()->withInput();
        }
    }

    public function show(Ticket $ticket)
    {
        return view('admin.tickets.show', ['ticket' => $ticket]);
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $validator = Validator::make($request->all(), [
            'reply' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        try {
            $ticketReply = TicketReply::create([
                'body' => $request->reply,
                'ticket_id' => $ticket->id,
                'user_id' => authUser()->id,
            ]);

            if ($ticketReply) {
                if ($request->hasFile('attachments')) {
                    foreach ($request->file('attachments') as $attachment) {
                        $ticketReplyAttachment = new TicketReplyAttachment();
                        $ticketReplyAttachment->name = $attachment->getClientOriginalName();
                        $ticketReplyAttachment->path = storageFileUpload($attachment, "tickets/{$ticket->id}/", "local");
                        $ticketReplyAttachment->ticket_reply_id = $ticketReply->id;
                        $ticketReplyAttachment->save();
                    }
                }
                $ticket->status = Ticket::STATUS_OPENED;
                $ticket->update();
            }

            dispatch(new SendNewTicketReplyNotification($ticketReply));
            toastr()->success(translate('Your Reply Sent Successfully'));
            return back();
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back()->withInput();
        }
    }

    public function download(Ticket $ticket, TicketReplyAttachment $attachment)
    {
        $filePath = $attachment->path;
        $fileName = $attachment->name;

        try {
            $disk = Storage::disk('local');
            if (!$disk->exists($filePath)) {
                toastr()->error(translate('The requested file are not exists'));
                return back();
            }

            $headers = [
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ];

            return new StreamedResponse(function () use ($disk, $filePath) {
                $stream = $disk->readStream($filePath);
                while (!feof($stream) && connection_status() === 0) {
                    echo fread($stream, 1024 * 8);
                    flush();
                }
                fclose($stream);
            }, 200, $headers);
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function close(Request $request, Ticket $ticket)
    {
        $ticket->status = Ticket::STATUS_CLOSED;
        $ticket->update();

        toastr()->success(translate('Ticket Closed Successfully'));
        return back();
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        toastr()->success(translate('Deleted Successfully'));
        return back();
    }
}
