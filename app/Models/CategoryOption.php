<?php

namespace App\Models;

use App\Scopes\SortByIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryOption extends Model
{
    use HasFactory;

    const TYPE_SINGLE = 1;
    const TYPE_MULTIPLE = 2;

    const NOT_REQUIRED = 0;
    const REQUIRED = 1;

    protected static function booted()
    {
        static::addGlobalScope(new SortByIdScope);
    }

    public function isSingle()
    {
        return $this->type == self::TYPE_SINGLE;
    }

    public function isMultiple()
    {
        return $this->type == self::TYPE_MULTIPLE;
    }

    public function isRequired()
    {
        return $this->is_required == self::REQUIRED;
    }

    protected $fillable = [
        'category_id',
        'type',
        'name',
        'options',
        'is_required',
    ];

    protected $casts = [
        'options' => 'object',
    ];

    public function category()
    {
        return $this->belongsTo(category::class);
    }
}
