<?php

namespace App\Models;

use App\Scopes\SortByIdScope;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory, Sluggable;

    protected static function booted()
    {
        static::addGlobalScope(new SortByIdScope);
    }

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
        'title',
        'description',
        'category_id',
        'views',
    ];

    public function getLink()
    {
        return route('categories.sub-category', [$this->category->slug, $this->slug]);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}