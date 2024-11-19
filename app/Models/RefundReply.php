<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'refund_id',
        'user_id',
        'body',
    ];

    public function refund()
    {
        return $this->belongsTo(Refund::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
