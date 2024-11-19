<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    const LICENSE_TYPE_REGULAR = 1;
    const LICENSE_TYPE_EXTENDED = 2;

    public function isLicenseTypeRegular()
    {
        return $this->license_type == self::LICENSE_TYPE_REGULAR;
    }

    public function isLicenseTypeExtended()
    {
        return $this->license_type == self::LICENSE_TYPE_EXTENDED;
    }

    public function scopeForCurrentSession($query)
    {
        if (authUser()) {
            $query->where('user_id', authUser()->id)
                ->whereNull('session_id');
        } else {
            $query->where('session_id', session()->get('session_id'))
                ->whereNull('user_id');
        }
    }

    protected $fillable = [
        'session_id',
        'user_id',
        'item_id',
        'license_type',
        'quantity',
        'support_period_id',
    ];

    public function getTotalAmount()
    {
        $quantity = $this->quantity;
        if ($this->isLicenseTypeRegular()) {
            $amount = $this->item->price->regular;
        } else {
            $amount = $this->item->price->extended;
        }

        $total = ($amount * $quantity);

        return $total;
    }

    public function getTotalAmountWithSupport()
    {
        $quantity = $this->quantity;
        if ($this->isLicenseTypeRegular()) {
            $amount = $this->item->price->regular;
        } else {
            $amount = $this->item->price->extended;
        }

        $supportPeriod = $this->supportPeriod;
        if ($supportPeriod) {
            $supportPeriodAmount = ($amount * $supportPeriod->percentage) / 100;
            $amount = ($amount + $supportPeriodAmount);
        }

        $total = ($amount * $quantity);

        return $total;
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function supportPeriod()
    {
        return $this->belongsTo(SupportPeriod::class);
    }
}