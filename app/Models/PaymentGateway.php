<?php

namespace App\Models;

use App\Scopes\SortByIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    use HasFactory;

    public $timestamps = false;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const MODE_SANDBOX = 'sandbox';
    const MODE_LIVE = 'live';

    const ALIAS_WALLET = 'wallet';

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

    public function isManual()
    {
        return $this->is_manual == true;
    }

    public function isSandboxMode()
    {
        return $this->mode == self::MODE_SANDBOX;
    }

    public function isLiveMode()
    {
        return $this->mode == self::MODE_LIVE;
    }

    public function scopeWallet($query)
    {
        return $query->where('alias', self::ALIAS_WALLET);
    }

    public function scopeNotWallet($query)
    {
        return $query->whereNot('alias', self::ALIAS_WALLET);
    }

    public function isWallet()
    {
        return $this->alias == self::ALIAS_WALLET;
    }

    public function scopeForTrx($query, $trx)
    {
        if ($trx->isTypeDeposit()) {
            return $query->notWallet();
        }
    }

    protected $fillable = [
        'name',
        'logo',
        'fees',
        'credentials',
        'instructions',
        'mode',
        'status',
    ];

    protected $casts = [
        'credentials' => 'object',
        'parameters' => 'object',
    ];

    public function getLogoLink()
    {
        return asset($this->logo);
    }

    public static function getModes()
    {
        return [
            translate(self::MODE_SANDBOX),
            translate(self::MODE_LIVE),
        ];
    }
}
