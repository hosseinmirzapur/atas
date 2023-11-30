<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use JetBrains\PhpStorm\ArrayShape;

class MessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected mixed $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(mixed $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return PrivateChannel|array
     */
    public function broadcastOn(): PrivateChannel|array
    {
        return new PrivateChannel('chat.' . $this->message->chat_id);
    }

    /**
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'user-chat';
    }

    /**
     * @return array
     */
    #[ArrayShape([
        'id' => "",
        'chat_id' => "",
        'text' => "",
        'media_url' => "",
        'seen' => "bool"
    ])]
    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'chat_id' => $this->message->chat_id,
            'text' => $this->message->text,
            'media_url' => $this->message->media_url,
            'seen' => $this->message->seen
        ];
    }
}
