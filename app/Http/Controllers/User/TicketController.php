<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\Admin\SendAdminTicketNotification;
use App\Jobs\Admin\SendAdminTicketReplyNotification;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketReply;
use App\Models\TicketReplyAttachment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Validator;

class TicketController extends Controller
{
    public function index()
    {
        $user = authUser();

        $counters['opened_tickets'] = Ticket::where('user_id', $user->id)->opened()->count();
        $counters['closed_tickets'] = Ticket::where('user_id', $user->id)->closed()->count();

        $tickets = Ticket::where('user_id', $user->id);

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $tickets->where(function ($query) use ($searchTerm) {
                $query->where('subject', 'like', $searchTerm)
                    ->orWhereHas('replies', function ($query) use ($searchTerm) {
                        $query->where('body', 'like', $searchTerm);
                    });
            });
        }

        if (request()->filled('status')) {
            $tickets->where('status', request('status'));
        }

        $tickets = $tickets->orderbyDesc('id')->paginate(10);
        $tickets->appends(request()->only(['search', 'status']));

        return theme_view('user.tickets.index', [
            'counters' => $counters,
            'tickets' => $tickets,
        ]);
    }

    public function create()
    {
        $categories = TicketCategory::active()->get();
        return theme_view('user.tickets.create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $attachments = $request->file('attachments');
        $allowedExts = explode(',', @settings('ticket')->file_types);
        $maxFiles = @settings('ticket')->max_files;
        $maxFileSize = @settings('ticket')->max_file_size;

        $validator = Validator::make($request->all(), [
            'subject' => ['required', 'string', 'block_patterns', 'max:255'],
            'category' => ['required', 'integer', 'exists:ticket_categories,id'],
            'description' => ['required', 'string'],
            'attachments' => [
                'max:' . ($maxFileSize * 1024),
                function ($attribute, $value, $fail) use ($attachments, $allowedExts, $maxFiles, $maxFileSize) {
                    foreach ($attachments as $attachment) {
                        if ($attachment->getSize() > ($maxFileSize * 1048576)) {
                            return $fail(translate('Max file size is :max MB', ['max' => $maxFileSize]));
                        }
                        $ext = strtolower($attachment->getClientOriginalExtension());
                        if (!in_array($ext, $allowedExts)) {
                            return $fail(translate('Some uploaded files are not supported'));
                        }
                    }
                    if (count($attachments) > $maxFiles) {
                        return $fail(translate('Max :max files can be uploaded', ['max' => $maxFiles]));
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $category = TicketCategory::where('id', $request->category)->active()->firstOrFail();

        try {
            $user = authUser();

            $ticket = Ticket::create([
                'subject' => $request->subject,
                'user_id' => $user->id,
                'ticket_category_id' => $category->id,
            ]);

            if ($ticket) {
                $ticketReply = TicketReply::create([
                    'body' => $request->description,
                    'ticket_id' => $ticket->id,
                    'user_id' => $user->id,
                ]);
                if ($ticketReply) {
                    if ($request->hasFile('attachments')) {
                        foreach ($attachments as $attachment) {
                            $ticketReplyAttachment = new TicketReplyAttachment();
                            $ticketReplyAttachment->name = $attachment->getClientOriginalName();
                            $ticketReplyAttachment->path = storageFileUpload($attachment, "tickets/{$ticket->id}/", "local");
                            $ticketReplyAttachment->ticket_reply_id = $ticketReply->id;
                            $ticketReplyAttachment->save();
                        }
                    }
                }

                dispatch(new SendAdminTicketNotification($ticket));
                toastr()->success(translate('Ticket Created Successfully'));
                return redirect()->route('user.tickets.show', $ticket->id);
            }
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back()->withInput();
        }
    }

    public function show($id)
    {
        $ticket = Ticket::where('user_id', authUser()->id)
            ->where('id', $id)->with(['replies', 'category'])
            ->withAttachments()
            ->firstOrFail();

        return theme_view('user.tickets.show', [
            'ticket' => $ticket,
        ]);
    }

    public function reply(Request $request, $id)
    {
        $user = authUser();
        $ticket = Ticket::where('user_id', $user->id)->where('id', $id)->firstOrFail();

        $attachments = $request->file('attachments');
        $allowedExts = explode(',', @settings('ticket')->file_types);
        $maxFiles = @settings('ticket')->max_files;
        $maxFileSize = @settings('ticket')->max_file_size;

        $validator = Validator::make($request->all(), [
            'reply' => ['required', 'string'],
            'attachments' => [
                'max:' . ($maxFileSize * 1024),
                function ($attribute, $value, $fail) use ($attachments, $allowedExts, $maxFiles, $maxFileSize) {
                    foreach ($attachments as $attachment) {
                        if ($attachment->getSize() > ($maxFileSize * 1048576)) {
                            return $fail(translate('Max file size is :max MB', ['max' => $maxFileSize]));
                        }
                        $ext = strtolower($attachment->getClientOriginalExtension());
                        if (!in_array($ext, $allowedExts)) {
                            return $fail(translate('Some uploaded files are not supported'));
                        }
                    }
                    if (count($attachments) > $maxFiles) {
                        return $fail(translate('Max :max files can be uploaded', ['max' => $maxFiles]));
                    }
                },
            ],
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
                'user_id' => $user->id,
            ]);

            if ($ticketReply) {
                if ($request->hasFile('attachments')) {
                    foreach ($attachments as $attachment) {
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

            dispatch(new SendAdminTicketReplyNotification($ticketReply));
            toastr()->success(translate('Your Reply Sent Successfully'));
            return back();
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back()->withInput();
        }
    }

    public function download($id, $attachment_id)
    {
        $user = authUser();

        $ticket = Ticket::where('user_id', $user->id)->where('id', $id)->firstOrFail();
        $ticketReplyAttachment = TicketReplyAttachment::where('id', $attachment_id)->firstOrFail();

        $filePath = $ticketReplyAttachment->path;
        $fileName = $ticketReplyAttachment->name;

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
}