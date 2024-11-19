<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    const LICENSE_TYPE_REGULAR = 1;
    const LICENSE_TYPE_EXTENDED = 2;

    const STATUS_ACTIVE = 1;
    const STATUS_REFUNDED = 2;
    const STATUS_CANCELLED = 3;

    public function isLicenseTypeRegular()
    {
        return $this->license_type == self::LICENSE_TYPE_REGULAR;
    }

    public function isLicenseTypeExtended()
    {
        return $this->license_type == self::LICENSE_TYPE_EXTENDED;
    }

    public function scopeActive($query)
    {
        $query->where('status', self::STATUS_ACTIVE);
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function scopeRefunded($query)
    {
        $query->where('status', self::STATUS_REFUNDED);
    }

    public function isRefunded()
    {
        return $this->status == self::STATUS_REFUNDED;
    }

    public function scopeCancelled($query)
    {
        $query->where('status', self::STATUS_CANCELLED);
    }

    public function isCancelled()
    {
        return $this->status == self::STATUS_CANCELLED;
    }

    protected $fillable = [
        'user_id',
        'item_id',
        'license_type',
        'price',
        'tax',
        'total',
        'country',
        'status',
    ];

    protected $casts = [
        'tax' => 'object',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }
}