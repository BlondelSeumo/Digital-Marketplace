<?php

namespace App\Models;

use App\Scopes\SortByIdScope;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpCategory extends Model
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
        'views',
        'sort_id',
    ];

    public function getLink()
    {
        return route('help.category', $this->slug);
    }

    public function articles()
    {
        return $this->hasMany(HelpArticle::class, 'help_category_id', );
    }
}
