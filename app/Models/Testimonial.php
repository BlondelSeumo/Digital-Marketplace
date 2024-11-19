<?php

namespace App\Models;

use App\Scopes\SortByIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new SortByIdScope);
    }

    protected $fillable = [
        'name',
        'avatar',
        'title',
        'body',
        'stars',
        'sort_id',
    ];

    public function getAvatar()
    {
        return asset($this->avatar);
    }

}
