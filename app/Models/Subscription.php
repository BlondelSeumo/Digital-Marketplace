<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    const RENEWING_DAYS = 3;
    const EXPIRING_DAYS = 3;

    public function isDailyLimitReached()
    {
        return !is_null($this->plan->downloads) && $this->total_downloads >= $this->plan->downloads;
    }

    public function scopeAboutToExpire($query)
    {
        return $query->whereHas('plan', function ($q) {
            $q->whereNot('interval', Plan::INTERVAL_LIFETIME);
        })
            ->whereNotNull('expiry_at')
            ->where('expiry_at', '>', Carbon::now())
            ->whereRaw('DATEDIFF(expiry_at, NOW()) <= ?', [self::RENEWING_DAYS]);
    }

    public function isAboutToExpire()
    {
        if ($this->plan->isLifetime()) {
            return false;
        }

        if (is_null($this->expiry_at)) {
            return false;
        }

        $expiryDate = Carbon::parse($this->expiry_at);
        $today = Carbon::now();

        if ($this->isExpired()) {
            return false;
        }

        $daysLeft = $today->diffInDays($expiryDate, false);
        return $daysLeft <= self::RENEWING_DAYS && $daysLeft >= 0;
    }

    public function scopeExpired($query)
    {
        return $query->whereNotNull('expiry_at')
            ->where('expiry_at', '<', Carbon::now());
    }

    public function isExpired()
    {
        if (is_null($this->expiry_at)) {
            return false;
        }
        return $this->expiry_at->isPast();
    }

    protected $fillable = [
        'user_id',
        'plan_id',
        'total_downloads',
        'expiry_at',
        'last_notification_at',
    ];

    protected $casts = [
        'expiry_at' => 'datetime',
        'last_notification_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}