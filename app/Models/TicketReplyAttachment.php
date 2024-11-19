<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketReplyAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'ticket_reply_id',
    ];

    public function reply()
    {
        return $this->belongsTo(TicketReply::class);
    }
}
