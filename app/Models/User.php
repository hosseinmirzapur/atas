<?php

namespace App\Models;

use App\Notifications\UserNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasFactory, HasApiTokens, Notifiable;
    const STATUS = ['FRESH', 'OTP_DONE', 'BLOCKED'];

    protected $guarded = [];

    /**
     * @return bool
     */
    public function isBlocked(): bool
    {
        return $this->getAttribute('status') == 'BLOCKED';
    }

    /**
     * @return HasOne
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class, 'user_id');
    }


    /**
     * @param $title
     * @param $text
     */
    public function sendNotification($title, $text)
    {
        $this->notify((new UserNotification($this, $title, $text))->delay(now()->addSeconds(2)));
    }

    /**
     * @return HasMany
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function billings(): HasMany
    {
        return $this->hasMany(Billing::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function followers(): HasMany
    {
        return $this->hasMany(Follow::class, 'following_user_id');
    }

    /**
     * @return HasMany
     */
    public function followings(): HasMany
    {
        return $this->hasMany(Follow::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class, 'user_id');
    }

    /**
     * @return BelongsToMany
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_user');
    }

    /**
     * @return BelongsToMany
     */
    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(Plan::class, 'plan_user');
    }

    /**
     * @return MorphMany
     */
    public function gMessages(): MorphMany
    {
        return $this->morphMany(GMessage::class, 'owner');
    }

}
