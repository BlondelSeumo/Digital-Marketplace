<?php

namespace App\Models;

use App\Scopes\SortByIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCategory extends Model
{
    use HasFactory;

    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 1;

    protected static function booted()
    {
        static::addGlobalScope(new SortByIdScope);
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    protected $fillable = [
        'name',
        'status',
        'sort_id',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'ticket_category_id');
    }
}
