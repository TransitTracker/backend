<?php

namespace App\Events;

use App\Models\Vehicle;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VehicleForceRefAdded
{
    use Dispatchable, SerializesModels;

    public function __construct(public Vehicle $vehicle)
    {
    }
}
