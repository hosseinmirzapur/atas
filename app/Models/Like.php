<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Like extends Model
{
    use HasFactory;


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
    public function ideas(): MorphToMany
    {
        return $this->morphedByMany(Idea::class, 'likeable');
    }

    /**
     * @return MorphToMany
     */
    public function comments(): MorphToMany
    {
        return $this->morphedByMany(Comment::class, 'likeable');
    }
}
