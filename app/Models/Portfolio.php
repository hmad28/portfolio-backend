<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;

class Portfolio extends Model implements HasMedia
{
    use InteractsWithMedia, HasTags;

    protected $fillable = [
        'title',
        'slug',
        'company',
        'category',
        'description',
        'link',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // Register media collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->useDisk('public')
            ->singleFile();

        $this->addMediaCollection('gallery')
            ->useDisk('public');
    }

    // HAPUS atau COMMENT method ini (jika ada)
    // public function registerMediaConversions(...) { ... }
}