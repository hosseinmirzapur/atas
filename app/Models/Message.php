<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['media_url'];

    /**
     * @return BelongsTo
     */
    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }

    public function markAsSeen()
    {
        $this->update(['seen' => true]);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::make($value)->format('M d, H:i');
    }

    /**
     * @return string|null
     */
    public function getMediaUrlAttribute(): ?string
    {
        if ($this->media != null) {
            return Storage::url($this->media);
        } return null;
    }

}
