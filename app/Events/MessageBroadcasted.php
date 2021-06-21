<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageBroadcasted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message;
    public string $name_from;
    public string $time;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        string $message,
        string $name_from,
        string $time
    ) {
        $this->message = $message;
        $this->name_from = $name_from;
        $this->time = $time;
    }

    public function broadcastAs()
    {
        return "message_created_boi";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel("message-notification");
    }
}
