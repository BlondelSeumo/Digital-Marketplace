<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadedFile extends Model
{
    use HasFactory;

    public function scopeExpired($query)
    {
        $query->where('expiry_at', '<', Carbon::now());
    }

    public function scopeNotExpired($query)
    {
        $query->where('expiry_at', '>', Carbon::now());
    }

    public function isImage()
    {
        $mimeTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        return in_array($this->mime_type, $mimeTypes);
    }

    protected $fillable = [
        'name',
        'mime_type',
        'extension',
        'size',
        'path',
        'expiry_at',
        'category_id',
    ];

    protected $casts = [
        'expiry_at' => 'datetime',
    ];

    public function getShortName()
    {
        $name = $this->name;
        if (strlen($name) > 40) {
            return substr($name, 0, 20) . ".." . substr($name, -4);
        }
        return $name;
    }

    public function getSize()
    {
        return formatBytes($this->size);
    }

    public function getFileLink()
    {
        return getLinkFromStorageProvider($this->path);
    }

    public function deleteFile()
    {
        $storageProvider = storageProvider();
        $processor = new $storageProvider->processor;
        $processor->delete($this->path);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
