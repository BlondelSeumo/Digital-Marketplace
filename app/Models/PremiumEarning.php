<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumEarning extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'tax',
        'total',
        'subscription_id',
    ];

    protected $casts = [
        'tax' => 'object',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
