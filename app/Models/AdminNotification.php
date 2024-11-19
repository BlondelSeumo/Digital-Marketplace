<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    use HasFactory;

    const LINK_TYPE_INTERNAL = 1;
    const LINK_TYPE_EXTERNAL = 2;

    const STATUS_UNREAD = 0;
    const STATUS_READ = 1;

    public function isLinkTypeExternal()
    {
        return $this->link_type == self::LINK_TYPE_EXTERNAL;
    }

    public function scopeUnread($query)
    {
        $query->where('status', self::STATUS_UNREAD);
    }

    public function isUnread()
    {
        return $this->status == self::STATUS_UNREAD;
    }

    public function scopeRead($query)
    {
        $query->where('status', self::STATUS_READ);
    }

    public function isRead()
    {
        return $this->status == self::STATUS_READ;
    }

    protected $fillable = [
        'title',
        'image',
        'link',
        'link_type',
        'status',
    ];
}