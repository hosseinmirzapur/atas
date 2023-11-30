<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Idea extends Model
{
    use HasFactory;

    const FILE_TYPE = ['IMAGE', 'VIDEO'];
    const PRIVACY_SETTINGS = ['PUBLIC', 'PRIVATE'];
    const TYPE1 = ['ANALYSIS', 'TUTORIAL'];
    const TYPE2 = ['TECHNICAL', 'FUNDAMENTAL'];
    const INVESTMENT_STRATEGY = ['LONG', 'NEUTRAL', 'SHORT'];
    const IDEA_TYPE = ['IDEA', 'NEWS'];
    const STATUS = ['REJECTED', 'PENDING', 'ACCEPTED'];

    // Creation
    const TYPES = ['FA', 'TA', 'FE', 'TE'];
    const SUPPORTED_IMAGE_TYPES = ['tif', 'tiff', 'bmp', 'jpg', 'jpeg', 'gif', 'png'];
    const SUPPORTED_VIDEO_TYPES = ['webm', 'mpg', 'mp2', 'mpeg', 'mpe', 'mpv', 'ogg', 'mp4', 'm4v', 'avi', 'wmv', 'mov', 'qt', 'flv', 'swf'];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return MorphToMany
     */
    public function likes(): MorphToMany
    {
        return $this->morphToMany(Like::class, 'likeable');
    }

    /**
     * @return bool
     */
    public function isPrivate(): bool
    {
        return $this->privacy_settings == 'PRIVATE';
    }
}
