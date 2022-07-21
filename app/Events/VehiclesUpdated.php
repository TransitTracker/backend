<?php

namespace App\Events;

use App\Models\Agency;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class VehiclesUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    /**
     * The name of the queue on which to place the event.
     *
     * @var string
     */
    public $broadcastQueue = 'notifications';

    /**
     * Create a new event instance.
     *
     * @param  Agency  $agency
     */
    public function __construct(public Agency $agency)
    {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        $channels = [new Channel('updates')];
        foreach ($this->agency->regions as $region) {
            array_push($channels, new Channel($region->slug));
        }

        return $channels;
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'slug' => $this->agency->slug,
            'region' => $this->agency->regions[0]->slug,
        ];
    }
}
