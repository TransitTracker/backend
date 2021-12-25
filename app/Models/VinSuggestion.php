<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VinSuggestion extends Model
{
    use HasFactory;

    protected $fillable = ['vin', 'label', 'note'];

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'vehicle', 'vin');
    }
}
