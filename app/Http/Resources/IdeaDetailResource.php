<?php

namespace App\Http\Resources;

use App\Models\Bookmark;
use App\Models\Follow;
use App\Models\Idea;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class IdeaDetailResource extends JsonResource
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
            'title' => $this->title,
            'caption' => $this->description,
            'file' => $this->idea_file,
            'file_type' => $this->idea_file_type,
            'tags' => $this->tags,
            'type' => $this->type1 . ' ' . $this->type2,
            'category' => $this->category,
            'created_at' => $this->created_at,
            'details' => $this->coin,
            'time_frame' => $this->time_frame,
            'strategy' => Str::lower($this->investment_strategy),
            'like_count' => $this->likes->count(),
            'liked' => exists(Like::query()
                ->where('user_id', currentUser()->id)
                ->where('likeable_id', $this->id)
                ->where('likeable_type', Idea::class)
                ->first()),
            'share_link' => config('services.misc.website') . '/ideas/' . $this->id,
            'bookmarked' => Bookmark::query()
                ->where('user_id', currentUser()->id)
                ->where('bookmarkable_id', $this->id)
                ->where('bookmarkable_type', Idea::class)
                ->first(),
            'comments' => CommentResource::collection($this->comments),
            'user' => [
                'is_followed' => exists(Follow::query()
                    ->where('user_id', currentUser()->id)
                    ->where('following_user_id', $this->user->id)
                    ->first()),
                'full_name' => exists($this->user->profile) ? $this->user->profile->first_name . ' ' . $this->user->profile->last_name : '',
                'image' => exists($this->user->profile) ? $this->user->profile->photo : '',
                'is_vip' => exists($this->user->rank)
            ]
        ];
    }
}
