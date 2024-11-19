<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemComment extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::created(function ($comment) {
            $comment->item->increment('total_comments');
        });

        static::deleted(function ($comment) {
            $comment->item->decrement('total_comments');
        });
    }

    protected $fillable = [
        'user_id',
        'item_id',
        'created_at',
        'updated_at',
    ];

    protected $with = [
        'replies',
    ];

    public function getLink()
    {
        return route('items.comment', [
            $this->item->slug,
            $this->item->id,
            $this->id,
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function replies()
    {
        return $this->hasMany(ItemCommentReply::class);
    }
}
