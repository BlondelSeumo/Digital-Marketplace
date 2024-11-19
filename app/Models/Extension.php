<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extension extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 0;

    protected $fillable = [
        'name',
        'alias',
        'logo',
        'settings',
        'status',
    ];

    protected $casts = [
        'settings' => 'object',
    ];

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function setSettings()
    {
        switch ($this->alias) {
            case 'trustip':
                setEnv('TRUSTIP_API_KEY', $this->settings->api_key);
                break;
        }
    }
}