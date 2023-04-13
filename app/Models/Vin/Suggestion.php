<?php

namespace App\Models\Vin;

use App\Events\Vin\SuggestionCreated;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Suggestion extends Model
{
    use HasFactory;

    protected $table = 'vin_suggestions';

    protected $guarded = [];

    protected $casts = [
        'is_rejected' => 'boolean',
    ];

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'vehicle', 'vin');
    }

    protected $dispatchesEvents = [
        'created' => SuggestionCreated::class,
    ];
}
