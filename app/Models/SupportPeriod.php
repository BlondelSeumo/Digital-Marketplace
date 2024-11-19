<?php

namespace App\Models;

use App\Scopes\SortByIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportPeriod extends Model
{
    use HasFactory;

    const NOT_DEFAULT = 0;
    const DEFAULT = 1;

    protected static function booted()
    {
        static::addGlobalScope(new SortByIdScope);
    }

    public function scopeDefault($query)
    {
        $query->where('is_default', self::DEFAULT);
    }

    public function isDefault()
    {
        return $this->is_default == self::DEFAULT;
    }

    public function scopeNotFree($query)
    {
        $query->whereNot('percentage', 0);
    }

    public function isFree()
    {
        return $this->percentage == 0;
    }

    protected $fillable = [
        'name',
        'title',
        'days',
        'percentage',
        'is_default',
        'sort_id',
    ];
}
