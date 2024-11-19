<?php

namespace App\Models;

use App\Scopes\SortByIdScope;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Sluggable;
    const FILE_TYPE_FILE_WITH_IMAGE_PREVIEW = 1;
    const FILE_TYPE_FILE_WITH_VIDEO_PREVIEW = 2;
    const FILE_TYPE_FILE_WITH_AUDIO_PREVIEW = 3;

    protected static function booted()
    {
        static::addGlobalScope(new SortByIdScope);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function isFileTypeFileWithImagePreview()
    {
        return $this->file_type == self::FILE_TYPE_FILE_WITH_IMAGE_PREVIEW;
    }

    public function isFileTypeFileWithVideoPreview()
    {
        return $this->file_type == self::FILE_TYPE_FILE_WITH_VIDEO_PREVIEW;
    }

    public function isFileTypeFileWithAudioPreview()
    {
        return $this->file_type == self::FILE_TYPE_FILE_WITH_AUDIO_PREVIEW;
    }

    protected $fillable = [
        'name',
        'slug',
        'title',
        'description',
        'file_type',
        'views',
    ];

    public function getLink()
    {
        return route('categories.category', $this->slug);
    }

    public function getFileTypeName()
    {
        return self::getFileTypeOptions()[$this->file_type];
    }

    public static function getFileTypeOptions()
    {
        return [
            self::FILE_TYPE_FILE_WITH_IMAGE_PREVIEW => translate('File With Preview Image'),
            self::FILE_TYPE_FILE_WITH_VIDEO_PREVIEW => translate('File With Video Preview'),
            self::FILE_TYPE_FILE_WITH_AUDIO_PREVIEW => translate('File With Audio Preview'),
        ];
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function categoryOptions()
    {
        return $this->hasMany(CategoryOption::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}