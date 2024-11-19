<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
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

    protected $fillable = [
        'transaction_id',
        'item_id',
        'license_type',
        'price',
        'quantity',
        'total',
        'support',
    ];

    protected $with = [
        'item',
    ];

    protected $casts = [
        'support' => 'object',
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

        if ($this->support) {
            $total += $this->support->total;
        }

        return $total;
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}