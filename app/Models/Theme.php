<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'alias',
        'version',
        'preview_image',
        'description',
    ];

    public function isActive()
    {
        return $this->alias == activeTheme();
    }

}
