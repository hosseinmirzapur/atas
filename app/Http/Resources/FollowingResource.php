<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class FollowingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = User::query()->find($this->following_user_id);
        return [
            'type' => 'user',
            'image' => $user->profile->image ?? '',
            'is_vip' => (bool)exists($user->rank),
            'full_name' => exists($user->profile) ? $user->profile->first_name . ' ' . $user->profile->last_name : $user->email,
            'status' => $this->when(exists($user->profile) && $user->profile->show_status, Cache::get('user_' . $user->id . '_is_online') ?? false),
            'is_follow' => $this->following_user_id == currentUser()->id
        ];
    }
}
