<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    #[ArrayShape([
        'text' => "mixed",
        'media' => "mixed",
        'seen' => "mixed",
        'chat_id' => "mixed",
        'id' => "mixed"
    ])]
    public function toArray($request): array
    {
        return [
            'text' => $this->text,
            'media' => $this->media_url,
            'seen' => $this->seen,
            'chat_id' => $this->chat_id,
            'id' => $this->id
        ];
    }
}
