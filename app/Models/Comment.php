<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Comment extends Model
{
    use HasFactory;
    const STATUS = ['PENDING', 'REJECTED', 'ACCEPTED'];
    protected $guarded = [];
    protected $appends = ['replies'];

    /**
     * @return MorphToMany
     */
    public function likes(): MorphToMany
    {
        return $this->morphToMany(Like::class, 'likeable');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    /**
     * @return BelongsTo
     */
    public function idea(): BelongsTo
    {
        return $this->belongsTo(Idea::class, 'idea_id');
    }

    /**
     * @return Collection|array
     */
    public function getRepliesAttribute(): Collection|array
    {
        return Comment::query()->where('related_comment_id', $this->id)->get();
    }
}
