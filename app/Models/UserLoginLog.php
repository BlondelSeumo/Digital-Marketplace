<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoginLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip',
        'country',
        'country_code',
        'timezone',
        'location',
        'latitude',
        'longitude',
        'browser',
        'os',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
