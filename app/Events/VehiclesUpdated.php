<?php

namespace App\Events;

use App\Agency;
use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class VehiclesUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $agency;

    /**
     * The name of the queue on which to place the event.
     *
     * @var string
     */
    public $broadcastQueue = 'notifications';

    /**
     * Create a new event instance.
     *
     * @param Agency $agency
     */
    public function __construct($agency)
    {
        $this->agency = $agency;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('updates');
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'id' => $this->agency->id,
            'slug' => $this->agency->slug
        ];
    }
}
