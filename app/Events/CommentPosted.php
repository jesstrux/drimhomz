<?php

namespace App\Events;

use App\ExpertRating;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CommentPosted implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;
    public $rating, $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ExpertRating $rating, User $user)
    {
        $this->rating = $rating;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('maziwa-mengi');
    }
}
