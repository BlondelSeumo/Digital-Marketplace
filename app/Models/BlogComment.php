<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory;

    const STATUS_PENDING = 0;
    const STATUS_PUBLISHED = 1;

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function isPending()
    {
        $this->status == self::STATUS_PENDING;
    }

    protected $fillable = [
        'user_id',
        'body',
        'status',
        'blog_article_id',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(BlogArticle::class, 'blog_article_id');
    }
}
