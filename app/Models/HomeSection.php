<?php

namespace App\Models;

use App\Scopes\SortByIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    use HasFactory;

    public $timestamps = false;

    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 0;

    protected static function booted()
    {
        static::addGlobalScope(new SortByIdScope);
    }

    public function scopeActive($query)
    {
        $query->where('status', self::STATUS_ACTIVE);
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    protected $fillable = [
        'name',
        'description',
        'items_number',
        'cache_expiry_time',
        'status',
        'sort_id',
    ];
}
