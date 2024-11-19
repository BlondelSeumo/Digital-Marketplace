<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemView extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'ip',
        'referrer',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
