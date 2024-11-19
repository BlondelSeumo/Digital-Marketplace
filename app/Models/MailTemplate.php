<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    use HasFactory;

    public $timestamps = false;

    private const DEFAULT_TEMPLATES = [
        'password_reset',
        'email_verification',
    ];

    public function isDefault()
    {
        return in_array($this->alias, self::DEFAULT_TEMPLATES);
    }

    protected $fillable = [
        'subject',
        'body',
        'status',
    ];

    protected $casts = [
        'shortcodes' => 'object',
    ];
}