<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;

    const STATUS_PENDING = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_DECLINED = 3;

    public function scopePending($query)
    {
        $query->where('status', self::STATUS_PENDING);
    }

    public function isPending()
    {
        return $this->status == self::STATUS_PENDING;
    }

    public function scopeAccepted($query)
    {
        $query->where('status', self::STATUS_ACCEPTED);
    }

    public function isAccepted()
    {
        return $this->status == self::STATUS_ACCEPTED;
    }

    public function scopeDeclined($query)
    {
        $query->where('status', self::STATUS_DECLINED);
    }

    public function isDeclined()
    {
        return $this->status == self::STATUS_DECLINED;
    }

    protected $fillable = [
        'user_id',
        'purchase_id',
        'status',
    ];

    public static function getStatusOptions()
    {
        return [
            self::STATUS_PENDING => translate('Pending'),
            self::STATUS_ACCEPTED => translate('Accepted'),
            self::STATUS_DECLINED => translate('Declined'),
        ];
    }

    public function getStatusName()
    {
        return self::getStatusOptions()[$this->status];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function replies()
    {
        return $this->hasMany(RefundReply::class);
    }
}