<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpArticle extends Model
{
    use HasFactory, Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    protected $fillable = [
        'title',
        'slug',
        'body',
        'short_description',
        'views',
        'likes',
        'dislikes',
        'help_category_id',
    ];

    public function getLink()
    {
        return route('help.article', $this->slug);
    }

    public function category()
    {
        return $this->belongsTo(HelpCategory::class, 'help_category_id');
    }
}
