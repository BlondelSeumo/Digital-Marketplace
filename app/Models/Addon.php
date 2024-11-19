<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    use HasFactory;

    const STATUS_NULL = null;
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 0;

    public function scopeActive($query)
    {
        $query->where('status', self::STATUS_ACTIVE);
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isDisabled()
    {
        return $this->status == self::STATUS_DISABLED;
    }

    public function hasNoStatus()
    {
        return $this->status === self::STATUS_NULL;
    }

    protected $fillable = [
        'name',
        'alias',
        'version',
        'thumbnail',
        'path',
        'action',
        'status',
    ];
}
