<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $endUserProfile = $this->endUser->profile;
        return [
            'name' => exists($endUserProfile) ? $endUserProfile->first_name . ' ' . $endUserProfile->last_name : null,
            'last_message' => $this->formatLastMessage(),
            'unread' => $this->unreadMessages()->count(),
            'type' => 'private',
            'last_message_time' => exists($this->messages->last()) ? $this->messages->last()->created_at : null
        ];
    }

    /**
     * @return string|null
     */
    protected function formatLastMessage(): ?string
    {
        $lastMessage = $this->messages->last();
        if (!$lastMessage) {
            return null;
        }
        if ($lastMessage->text == null) {
            return 'media';
        }
        return $lastMessage->text;
    }
}
