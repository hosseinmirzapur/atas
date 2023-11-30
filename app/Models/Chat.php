<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    use HasFactory;

    protected $guarded = [];

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
    public function endUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'endpoint_user_id');
    }

    /**
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'chat_id');
    }

    public function markAllAsSeen()
    {
        $this->messages()->update(['seen' => true]);
    }

    /**
     * @return Collection
     */
    public function unreadMessages(): Collection
    {
        return $this->messages()->where('seen', false)->get();
    }
}
