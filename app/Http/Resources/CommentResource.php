<?php

namespace App\Http\Resources;

use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'user' => [
                'image' => exists($this->user->profile) ? $this->user->profile->photo : '',
                'full_name' => exists($this->user->profile) ? $this->user->profile->first_name . ' ' . $this->user->profile->last_name : '',
                'id' => $this->user->id
            ],
            'content' => $this->text,
            'created_at' => $this->created_at,
            'like_count' => $this->likes->count(),
            'liked' => exists(Like::query()
                ->where('likeable_id', $this->id)
                ->where('likeable_type', Comment::class)
                ->where('user_id', currentUser()->id)
                ->first()),
            'replies' => $this->replies
        ];
    }
}
