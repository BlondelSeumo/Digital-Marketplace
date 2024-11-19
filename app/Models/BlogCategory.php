<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory, Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    protected $fillable = [
        'name',
        'slug',
        'views',
    ];

    public function getLink()
    {
        return route('blog.category', $this->slug);
    }

    public function articles()
    {
        return $this->hasMany(BlogArticle::class, 'blog_category_id');
    }
}
