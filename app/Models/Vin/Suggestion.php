<?php

namespace App\Models\Vin;

use App\Events\Vin\SuggestionCreated;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\VinSuggestion.
 *
 * @property int $id
 * @property string $vin
 * @property string $label
 * @property string|null $note
 * @property int $upvotes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vehicle[] $vehicles
 * @property-read int|null $vehicles_count
 * @method static \Illuminate\Database\Eloquent\Builder|VinSuggestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VinSuggestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VinSuggestion query()
 * @method static \Illuminate\Database\Eloquent\Builder|VinSuggestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VinSuggestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VinSuggestion whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VinSuggestion whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VinSuggestion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VinSuggestion whereUpvotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VinSuggestion whereVin($value)
 * @mixin \Eloquent
 */
class Suggestion extends Model
{
    use HasFactory;

    protected $table = 'vin_suggestions';

    protected $fillable = ['vin', 'label', 'note', 'is_rejected'];

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
