<?php

namespace App\Models\Vin;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $primaryKey = 'vin';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'others' => AsCollection::class,
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'vehicle', 'vin');
    }
}
