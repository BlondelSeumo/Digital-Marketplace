<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Ticket extends Model
{
    use HasFactory;

    const STATUS_OPENED = 1;
    const STATUS_CLOSED = 2;

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($ticket) {
            $path = "tickets/{$ticket->id}";
            $disk = Storage::disk('local');
            if ($disk->exists($path)) {
                $disk->deleteDirectory($path);
            }
        });
    }

    public function scopeOpened($query)
    {
        return $query->where('status', self::STATUS_OPENED);
    }

    public function isOpened()
    {
        return $this->status == self::STATUS_OPENED;
    }

    public function scopeClosed($query)
    {
        return $query->where('status', self::STATUS_CLOSED);
    }

    public function isClosed()
    {
        return $this->status == self::STATUS_CLOSED;
    }

    public function scopeWithAttachments($query)
    {
        return $query->with('replies.attachments');
    }

    protected $fillable = [
        'user_id',
        'ticket_category_id',
        'subject',
        'status',
    ];

    public static function getStatusOptions()
    {
        return [
            self::STATUS_OPENED => translate('Opened'),
            self::STATUS_CLOSED => translate('Closed'),
        ];
    }

    public function getStatusName()
    {
        return self::getStatusOptions()[$this->status];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(TicketCategory::class, 'ticket_category_id');
    }

    public function replies()
    {
        return $this->hasMany(TicketReply::class);
    }
}