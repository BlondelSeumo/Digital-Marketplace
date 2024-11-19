<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaptchaProvider extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 0;

    const DEFAULT = 1;
    const NOT_DEFAULT = 0;

    public function scopeActive($query)
    {
        $query->where('status', self::STATUS_ACTIVE);
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function scopeDefault($query)
    {
        $query->where('is_default', self::DEFAULT);
    }

    public function isDefault()
    {
        return $this->is_default == self::DEFAULT;
    }

    protected $fillable = [
        'name',
        'alias',
        'logo',
        'settings',
        'status',
        'is_default',
    ];

    protected $casts = [
        'settings' => 'object',
    ];
}
