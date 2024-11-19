<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCommentReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_comment_reply_id',
        'reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentReply()
    {
        return $this->belongsTo(ItemCommentReply::class, 'item_comment_reply_id');
    }
}