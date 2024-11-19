<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemReview extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::created(function ($review) {
            self::updateItemReviews($review->item);
        });

        static::updated(function ($review) {
            self::updateItemReviews($review->item);
        });

        static::deleted(function ($review) {
            self::updateItemReviews($review->item);
        });
    }

    protected static function updateItemReviews($item)
    {
        $item->total_reviews = $item->reviews->count();
        $item->avg_reviews = $item->reviews->count() > 0 ? $item->reviews->avg('stars') : 0;
        $item->update();
    }

    protected $fillable = [
        'user_id',
        'item_id',
        'stars',
        'body',
        'created_at',
        'updated_at',
    ];

    public function getLink()
    {
        return route('items.review', [
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

    public function reply()
    {
        return $this->hasOne(ItemReviewReply::class, 'item_review_id');
    }
}