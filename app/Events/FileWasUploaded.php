<?php

namespace App\Events;

use App\Image;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class FileWasUploaded
{
    use InteractsWithSockets, SerializesModels;
    public $file;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Image $image)
    {
        $this->file = $image;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
