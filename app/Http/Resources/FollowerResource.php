<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class FollowerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $user = $this->user;
        return [
            'type' => 'user',
            'image' => $user->profile->image ?? '',
            'is_vip' => (bool)exists($user->rank),
            'full_name' => exists($user->profile) ? $user->profile->first_name . ' ' . $user->profile->last_name : $user->email,
            'status' => $this->when(exists($user->profile) && $user->profile->show_status, Cache::get('user_' . $user->id . '_is_online') ?? false),
            'is_follow' => $this->user_id == currentUser()->id
        ];
    }
}
