<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterLink extends Model
{
    use HasFactory;

    const LINK_TYPE_INTERNAL = 1;
    const LINK_TYPE_EXTERNAL = 2;

    public function isInternal()
    {
        return $this->link_type == self::LINK_TYPE_INTERNAL;
    }

    public function isExternal()
    {
        return $this->link_type == self::LINK_TYPE_EXTERNAL;
    }

    public function scopeByOrder($query)
    {
        return $query->orderBy('order', 'asc');
    }

    protected $fillable = [
        'name',
        'link',
        'link_type',
        'parent_id',
        'order',
    ];

    public function children()
    {
        return $this->hasMany(FooterLink::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(FooterLink::class, 'parent_id');
    }
}
