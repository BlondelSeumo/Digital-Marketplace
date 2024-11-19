<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemDiscount extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($discount) {
            $item = $discount->item;
            $item->is_on_discount = Item::DISCOUNT_OFF;
            $item->update();
        });
    }

    public function scopeActive($query)
    {
        $query->where('status', self::STATUS_ACTIVE);
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function scopeInactive($query)
    {
        $query->where('status', self::STATUS_INACTIVE);
    }

    public function isInactive()
    {
        return $this->status == self::STATUS_INACTIVE;
    }

    public function scopeStarted($query)
    {
        $query->where('starting_at', '<=', Carbon::now());
    }

    public function isStarted()
    {
        return $this->starting_at <= Carbon::now();
    }

    public function scopeEnded($query)
    {
        $query->where('ending_at', '<', Carbon::now());
    }

    public function isEnded()
    {
        return $this->ending_at < Carbon::now();
    }

    public function withExtended()
    {
        if ($this->extended_percentage && $this->extended_price) {
            return true;
        }
        return false;
    }

    protected $fillable = [
        'item_id',
        'regular_percentage',
        'regular_price',
        'extended_percentage',
        'extended_price',
        'starting_at',
        'ending_at',
        'status',
    ];

    protected $dates = [
        'starting_at',
        'ending_at',
    ];

    public function getRegularPrice()
    {
        return ($this->regular_price + $this->item->category->regular_buyer_fee);
    }

    public function getExtendedPrice()
    {
        if ($this->extended_price) {
            return ($this->extended_price + $this->item->category->extended_buyer_fee);
        }
        return $this->extended_price;
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
