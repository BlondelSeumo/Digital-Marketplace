<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statement extends Model
{
    use HasFactory;

    const TYPE_CREDIT = 1;
    const TYPE_DEBIT = 2;

    public function scopeCredit($query)
    {
        $query->where('type', self::TYPE_CREDIT);
    }

    public function isCredit()
    {
        return $this->type == self::TYPE_CREDIT;
    }

    public function scopeDebit($query)
    {
        $query->where('type', self::TYPE_DEBIT);
    }

    public function isDebit()
    {
        return $this->type == self::TYPE_DEBIT;
    }

    protected $fillable = [
        'user_id',
        'title',
        'amount',
        'type',
    ];

    public function getAmount()
    {
        return getAmount($this->isCredit() ? $this->amount : '-' . $this->amount);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}