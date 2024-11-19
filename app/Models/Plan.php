<?php

namespace App\Models;

use App\Scopes\SortByIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 1;

    const NOT_FEATURED = 0;
    const FEATURED = 1;

    const INTERVAL_WEEK = 'week';
    const INTERVAL_MONTH = 'month';
    const INTERVAL_YEAR = 'year';
    const INTERVAL_LIFETIME = 'lifetime';

    protected static function booted()
    {
        static::addGlobalScope(new SortByIdScope);
    }

    public function scopeWeekly($query)
    {
        $query->where('interval', self::INTERVAL_WEEK);
    }

    public function isWeekly()
    {
        return $this->interval == self::INTERVAL_WEEK;
    }

    public function scopeMonthly($query)
    {
        $query->where('interval', self::INTERVAL_MONTH);
    }

    public function isMonthly()
    {
        return $this->interval == self::INTERVAL_MONTH;
    }

    public function scopeYearly($query)
    {
        $query->where('interval', self::INTERVAL_YEAR);
    }

    public function isYearly()
    {
        return $this->interval == self::INTERVAL_YEAR;
    }

    public function scopeLifetime($query)
    {
        $query->where('interval', self::INTERVAL_LIFETIME);
    }

    public function isLifetime()
    {
        return $this->interval == self::INTERVAL_LIFETIME;
    }

    public function scopeDisabled($query)
    {
        $query->where('status', self::STATUS_DISABLED);
    }

    public function isDisabled()
    {
        return $this->status == self::STATUS_DISABLED;
    }

    public function scopeActive($query)
    {
        $query->where('status', self::STATUS_ACTIVE);
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isFeatured()
    {
        return $this->featured == self::FEATURED;
    }

    public function scopeFree($query)
    {
        $query->whereNull('price');
    }

    public function scopeNotFree($query)
    {
        $query->whereNotNull('price');
    }

    public function isFree()
    {
        return is_null($this->price);
    }

    public function hasUnlimitedDownloads()
    {
        return is_null($this->downloads);
    }

    protected $fillable = [
        'name',
        'description',
        'price',
        'interval',
        'downloads',
        'custom_features',
        'featured',
        'status',
        'sort_id',
    ];

    protected $casts = [
        'custom_features' => 'object',
    ];

    public function getFormatPrice()
    {
        $price = $this->price;
        if (is_numeric($price) && floor($price) == $price) {
            return getAmount($price, 0, '.', '');
        } else {
            return getAmount($price, 2, '.', '');
        }
    }

    public function getIntervalDays()
    {
        if ($this->isWeekly()) {
            return 7;
        } else if ($this->isMonthly()) {
            return 30;
        } else if ($this->isYearly()) {
            return 365;
        }

        return null;
    }

    public function getIntervalName()
    {
        return self::getIntervalOptions()[$this->interval];
    }

    public static function getIntervalOptions()
    {
        return [
            self::INTERVAL_WEEK => translate('Weekly'),
            self::INTERVAL_MONTH => translate('Monthly'),
            self::INTERVAL_YEAR => translate('Yearly'),
            self::INTERVAL_LIFETIME => translate('Lifetime'),
        ];
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}