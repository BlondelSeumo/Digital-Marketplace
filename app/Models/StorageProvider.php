<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageProvider extends Model
{
    use HasFactory;

    public function isLocal()
    {
        return $this->alias === "local";
    }

    public function isStorj()
    {
        return $this->alias === "storj";
    }

    public function isDefault()
    {
        return $this->alias == env('FILESYSTEM_DRIVER');
    }

    public function scopeDefault($query)
    {
        $query->where('alias', env('FILESYSTEM_DRIVER'));
    }

    protected $fillable = [
        'credentials',
    ];

    protected $casts = [
        'credentials' => 'object',
    ];
}
