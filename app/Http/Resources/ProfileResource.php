<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'photo' => $this->photo,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'user_name' => $this->user_name,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'zip_code' => $this->zip_code,
            'phone_number' => $this->phone_number,
            'email' => $this->user->email,
            'about_me' => $this->about_me,
            'show_status' => (bool)$this->show_status,
            'instagram' => $this->instagram,
            'twitter' => $this->twitter,
            'facebook' => $this->facebook,
            'website' => $this->website,
            'youtube_channel' => $this->youtube_channel,
            'youtube_username' => $this->youtube_username,
            'signature' => $this->signature,
            'social_in_signature' => $this->social_in_signature,
            'authentication_type' => $this->handleAuthenticationType(),
            'expire_vip_time' => exists($this->user->rank) ? $this->user->rank->expired_at : null,
            'remaining_day_of_vip' => exists($this->user->rank) ? now()->diffInDays($this->user->rank->expired_at) : null,
            'join_time' => now()->diffForHumans($this->user->created_at),
            'followers' => exists($this->user->followers) ? $this->user->followers->count() : 0,
            'followings' => exists($this->user->followings) ? $this->user->followings->count() : 0,
            'reputation' => $this->user->reputation,
            'ideas' => exists($this->user->ideas) ? $this->user->ideas->count() : 0,
            'top_mentioned_symbols' => [],
            'is_vip' => exists($this->user->rank),
            'user_id' => $this->user->id
        ];
    }

    /**
     * @return string
     */
    #[Pure] public function handleAuthenticationType(): string
    {
        return Str::lower($this->authentication_type);
    }
}
