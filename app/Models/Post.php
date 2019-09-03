<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Post extends Model implements HasMedia
{
    use SoftDeletes,
        HasMediaTrait;

    protected $fillable = ['title', 'description', 'short_description', 'posted_at', 'scheduled_at', 'user_id'];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param Media|null $media
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumbnail')
            ->queued()
            ->width(368)
            ->height(232)
            ->sharpen(10)
            ->withResponsiveImages()
            ->performOnCollections('images');

        $this->addMediaConversion('thumbnail')
            ->queued()
            ->width(368)
            ->height(232)
            ->sharpen(10)
            ->extractVideoFrameAtSecond(20)
            ->performOnCollections('videos');
    }

    /**
     * @return array
     */
    public function registerMediaCollections()
    {
        return [
            'videos',
            'images'
        ];
    }
}
