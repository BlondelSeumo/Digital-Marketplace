<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCommentReply extends Model
{
    use HasFactory;

    public function hasReported()
    {
        return $this->report;
    }

    protected $fillable = [
        'item_comment_id',
        'user_id',
        'body',
        'created_at',
        'updated_at',
    ];

    protected $with = [
        'user',
    ];

    public function comment()
    {
        return $this->belongsTo(ItemComment::class, 'item_comment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function report()
    {
        return $this->hasOne(ItemCommentReport::class, 'item_comment_reply_id');
    }
}
